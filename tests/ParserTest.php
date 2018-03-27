<?php
use \Dialect\Tablify\Parsers\Parser;
class ParserTest extends \Dialect\Tablify\TestCase
{

	/** @test */
	public function it_can_parse_headers_of_objects(){
		$header1 = str_random(3);
		$header2 = str_random(4);
		$header3 = str_random(5);
		$objects = [
			$this->dummyObject($header1),
			$this->dummyObject($header2),
			$this->dummyObject($header3),
		];

		$headers = Parser::parseHeaders($objects);
		$this->assertCount(3, $headers);
		$this->assertEquals($header1, $headers[0]->getValue());
		$this->assertEquals($header2, $headers[1]->getValue());
		$this->assertEquals($header3, $headers[2]->getValue());
	}

	/** @test */
	public function it_can_parse_headers_of_group(){
		$header1 = str_random(3);
		$header2 = str_random(4);
		$header3 = str_random(5);
		$closure = function($tablify)use ($header1, $header2, $header3){
			return $tablify->map($header1, '')->map($header2, '')->map($header3, '');
		};
		$group = $this->dummyGroup(str_random(5), $closure);

		$headers = Parser::parseHeaders([$group]);
		$this->assertCount(3, $headers);
		$this->assertEquals($header1, $headers[0]->getValue());
		$this->assertEquals($header2, $headers[1]->getValue());
		$this->assertEquals($header3, $headers[2]->getValue());
	}

	/** @test */
	public function it_can_parse_headers_of_both_group_and_object(){
		$header1 = str_random(3);
		$header2 = str_random(4);
		$header3 = str_random(5);
		$closure = function($tablify)use ($header2, $header3){
			return $tablify->map($header2, '')->map($header3, '');
		};
		$object = $this->dummyObject($header1);
		$group = $this->dummyGroup(str_random(5), $closure);

		$headers = Parser::parseHeaders([$object, $group]);
		$this->assertCount(3, $headers);
		$this->assertEquals($header1, $headers[0]->getValue());
		$this->assertEquals($header2, $headers[1]->getValue());
		$this->assertEquals($header3, $headers[2]->getValue());
	}

	/** @test */
	public function it_can_only_add_the_same_header_once(){
		$header = str_random(3);

		$objects = [
			$this->dummyObject($header),
			$this->dummyObject($header)
		];

		$headers = Parser::parseHeaders($objects);
		$this->assertCount(1, $headers);;
	}

	/** @test */
	public function it_can_parse_objects_to_rows(){
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
		$objects = [
			$this->dummyObject("first", "first_name"),
			$this->dummyObject("last", "last_name"),
		];

		$rows = Parser::parseRows($objects, $collection);
		$this->assertCount(2, $rows);
		$this->assertEquals($collection[0]['first_name'], $rows[0]['first']->getValue());
		$this->assertEquals($collection[0]['last_name'], $rows[0]['last']->getValue());
		$this->assertEquals($collection[1]['first_name'], $rows[1]['first']->getValue());
		$this->assertEquals($collection[1]['last_name'], $rows[1]['last']->getValue());


	}

	/** @test */
	public function it_can_parse_groups_to_rows(){
		$collection = [
			[
			'names' => [
					[
						"first_name" => str_random(2),
						"last_name" => str_random(3)
					],
					[
						"first_name" => str_random(4),
						"last_name" => str_random(5)
					]
				]
			]
		];
		$closure = function($tablify){
			return $tablify->map('first', 'first_name')->map('last', 'last_name');
		};
		$group = $this->dummyGroup('names', $closure);

		$rows = Parser::parseRows([$group], $collection);
		$this->assertCount(3, $rows);
		$this->assertEquals($collection[0]['names'][0]['first_name'], $rows[1]['first']->getValue());
		$this->assertEquals($collection[0]['names'][0]['last_name'], $rows[1]['last']->getValue());
		$this->assertEquals($collection[0]['names'][1]['first_name'], $rows[2]['first']->getValue());
		$this->assertEquals($collection[0]['names'][1]['last_name'], $rows[2]['last']->getValue());

	}

	/** @test */
	public function it_can_parse_groups_and_objects_to_rows(){
		$collection = [
			[
				'heading' => str_random(6),
				'names' => [
					[
						"first_name" => str_random(2),
						"last_name" => str_random(3)
					],
					[
						"first_name" => str_random(4),
						"last_name" => str_random(5)
					]
				]
			]
		];
		$closure = function($tablify){
			return $tablify->map('first', 'first_name')->map('last', 'last_name');
		};
		$object = $this->dummyObject("head", "heading");
		$group = $this->dummyGroup('names', $closure);

		$rows = Parser::parseRows([$object,$group], $collection);

		$this->assertCount(3, $rows);
		$this->assertEquals($collection[0]['heading'], $rows[0]['head']->getValue());
		$this->assertEquals($collection[0]['names'][0]['first_name'], $rows[1]['first']->getValue());
		$this->assertEquals($collection[0]['names'][0]['last_name'], $rows[1]['last']->getValue());
		$this->assertEquals($collection[0]['names'][1]['first_name'], $rows[2]['first']->getValue());
		$this->assertEquals($collection[0]['names'][1]['last_name'], $rows[2]['last']->getValue());

	}

	/** @test */
	public function it_can_parse_settings(){
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
			'class' => str_random(5),
			'id' => str_random(6),
			'style' => str_random(7),
		];

		$object = $this->dummyObject("first", "first_name" ,$settings);
		$rows = Parser::parseRows([$object], $collection);
		$this->assertEquals($settings['class'], $rows[0]['first']->getClass());
		$this->assertEquals($settings['id'], $rows[0]['first']->getId());
		$this->assertEquals($settings['style'], $rows[0]['first']->getStyle());
		$this->assertEquals($settings['class'], $rows[1]['first']->getClass());
		$this->assertEquals($settings['id'], $rows[1]['first']->getId());
		$this->assertEquals($settings['style'], $rows[1]['first']->getStyle());
	}

}