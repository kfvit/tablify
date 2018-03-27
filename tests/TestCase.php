<?php

namespace Dialect\Tablify;

use Dialect\Tablify\Parsers\ParseGroup;
use Dialect\Tablify\Parsers\ParseObject;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp()
    {
        parent::setUp();

    }
    protected function getPackageProviders($app)
    {
        return [TablifyServiceProvider::class];
    }


    public function dummyObject($header = null, $binding = null, $settings = null, $headerSettings = null){
    	return new ParseObject($header ?: str_random(5), $binding ?: str_random(6), $settings ?: [], $headerSettings ?: []);
    }

    public function dummyGroup($binding = null, $closure = null){
        $dummyClosure = function(Tablify $tablify){
            return $tablify->map(str_random(3), str_random(4))->map(str_random(5), str_random(6));
        };
        return new ParseGroup($binding ?: str_random(5), $closure ?: $dummyClosure);
    }


}
