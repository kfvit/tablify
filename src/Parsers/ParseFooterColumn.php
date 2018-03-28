<?php
namespace Dialect\Tablify\Parsers;

use Dialect\Tablify\Objects\Column;
use Dialect\Tablify\Objects\Header;
use Illuminate\Support\Collection;

class ParseFooterColumn extends ParseObject {



	protected function parseValue($item = null){

		$value = null;

		if($this->binding instanceof \Closure) {
			$value = call_user_func($this->binding, $item);
		}else{
			$value = $this->binding;
		}

		return ['processed' => $this->process($value), 'raw' => $value];


	}

	protected function process($value){
		return $value;
	}

}