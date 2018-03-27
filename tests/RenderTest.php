<?php

class RenderTest extends \Dialect\Tablify\TestCase
{

	/** @test */
	public function it_can_render_to_array(){
		$collection = [
			[
				"first_name" => str_random(2),
				"last_name" => str_random(3)
			],
			[
				"first_name" => str_random(4),
				"last_name" => str_random(5)
			]
		];

		$array = tablify($collection)->map('firstName', 'first_name')->toArray();
		$this->assertTrue(is_array($array));

	}

	/** @test */
	public function it_can_render_to_json(){
		$collection = [
			[
				"first_name" => str_random(2),
				"last_name" => str_random(3)
			],
			[
				"first_name" => str_random(4),
				"last_name" => str_random(5)
			]
		];

		$json = tablify($collection)->map('firstName', 'first_name')->toJson();

		$this->assertJson($json);

	}

	/** @test */
	public function it_can_render_to_html(){
		$collection = [
			[
				"first_name" => str_random(2),
				"last_name" => str_random(3)
			],
			[
				"first_name" => str_random(4),
				"last_name" => str_random(5)
			]
		];
		$settings = [
			'class' => 'testclass',
		];
		$headerSettings = [
			'class' => 'headerclass',
		];

		$html = tablify($collection)->map('firstName', 'first_name',$settings ,$headerSettings)->toHtml();
		$this->assertTrue(is_string($html));

	}


	/** @test */
	public function it_can_render_to_xlsx(){
		$collection = [
			[
				"first_name" => str_random(2),
				"last_name" => str_random(3)
			],
			[
				"first_name" => str_random(4),
				"last_name" => str_random(5)
			]
		];
		$settings = [
			'class' => 'testclass',
		];
		$headerSettings = [
			'class' => 'headerclass',
		];

		$excel = tablify($collection)->map('firstName', 'first_name',$settings ,$headerSettings)->toXlsx();
		$this->assertEquals(get_class($excel), 'Symfony\Component\HttpFoundation\BinaryFileResponse');

	}

	/** @test */
	public function it_can_render_pdf(){
		$collection = [
			[
				"first_name" => str_random(2),
				"last_name" => str_random(3)
			],
			[
				"first_name" => str_random(4),
				"last_name" => str_random(5)
			]
		];
		$settings = [
			'class' => 'testclass',
		];
		$headerSettings = [
			'class' => 'headerclass',
		];

		$pdf = tablify($collection)->map('firstName', 'first_name',$settings ,$headerSettings)->toPdf();
		$this->assertEquals(get_class($pdf), 'Illuminate\Http\Response');

	}



}