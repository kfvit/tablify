<?php

class TablifyTest extends \Dialect\Tablify\TestCase
{

	/** @test */
	public function it_can_get_parsers(){
		$this->assertTrue(is_array(tablify()->getParsers()));
	}

	/** @test */
	public function it_can_map_a_key(){
		$collection = [];
		$tablify = tablify($collection)->map('HeaderName', 'name');
		$this->assertCount(1, $tablify->getParsers());
		$this->assertEquals(get_class($tablify->getParsers()[0]), 'Dialect\Tablify\Parsers\ParseObject');
	}

	/** @test */
	public function it_can_add_a_group(){
		$collection = [];

		$tablify = tablify($collection)->group('binding', function(\Dialect\Tablify\Tablify $tablify){
			return $tablify->map('foo', 'bar');
		});
		$this->assertCount(1, $tablify->getParsers());
		$this->assertEquals(get_class($tablify->getParsers()[0]), 'Dialect\Tablify\Parsers\ParseGroup');
	}

	/** @test */
	public function it_can_map_currency(){
		$collection = [];
		$tablify = tablify($collection)->currency('HeaderName', 'name');
		$this->assertCount(1, $tablify->getParsers());
		$this->assertEquals(get_class($tablify->getParsers()[0]), 'Dialect\Tablify\Parsers\ParseCurrency');
	}

	/** @test */
	public function it_can_map_number(){
		$collection = [];
		$tablify = tablify($collection)->number('HeaderName', 'name');
		$this->assertCount(1, $tablify->getParsers());
		$this->assertEquals(get_class($tablify->getParsers()[0]), 'Dialect\Tablify\Parsers\ParseNumber');
	}
	/** @test */
	public function it_can_map_header_column(){
		$collection = [];
		$tablify = tablify($collection)->headerColumn('HeaderName', 'name');
		$this->assertCount(1, $tablify->getHeaderColumns());
		$this->assertEquals(get_class($tablify->getHeaderColumns()[0]), 'Dialect\Tablify\Parsers\ParseHeaderColumn');
	}

	/** @test */
	public function it_can_map_fotter_column(){
		$collection = [];
		$tablify = tablify($collection)->footerColumn('HeaderName', 'name');
		$this->assertCount(1, $tablify->getFooterColumns());
		$this->assertEquals(get_class($tablify->getFooterColumns()[0]), 'Dialect\Tablify\Parsers\ParseFooterColumn');
	}


}