<?php

namespace Dialect\Tablify;

use Dialect\Tablify\Parsers\ParseGroup;
use Dialect\Tablify\Parsers\ParseObject;
use Illuminate\Support\Str;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

    }
    protected function getPackageProviders($app)
    {
        return [TablifyServiceProvider::class];
    }


    public function dummyObject($header = null, $binding = null, $settings = null, $headerSettings = null){
    	return new ParseObject($header ?: Str::random(5), $binding ?: Str::random(6), $settings ?: [], $headerSettings ?: []);
    }

    public function dummyGroup($binding = null, $closure = null){
        $dummyClosure = function(Tablify $tablify){
            return $tablify->map(Str::random(3), Str::random(4))->map(Str::random(5), Str::random(6));
        };
        return new ParseGroup($binding ?: Str::random(5), $closure ?: $dummyClosure);
    }


}
