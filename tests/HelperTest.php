<?php

class HelperTest extends \Dialect\Tablify\TestCase
{
	/** @test */
	public function it_can_get_instance_of_tablify_using_helper(){
		$tablify = tablify();
		$this->assertEquals(get_class($tablify), 'Dialect\Tablify\Tablify');
	}

	/** @test */
	public function it_can_take_an_array_as_argument(){
		$collection = [];
		$tablify = tablify($collection);
		$this->assertEquals(get_class($tablify), 'Dialect\Tablify\Tablify');
	}

}