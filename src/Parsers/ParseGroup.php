<?php
namespace Dialect\Tablify\Parsers;

use Dialect\Tablify\Tablify;

class ParseGroup{
	protected $binding, $closure;
	function __construct($binding, $closure) {
		$this->binding = $binding;
		$this->closure =$closure;
	}

	public function parseHeaders(){

		return Parser::parseHeaders($this->getParsers()['parsers']);
	}

	public function parseRows($item){
		$parsers = $this->getParsers($item);
		return Parser::parseRows($parsers['parsers'], $this->getCollection($item), $parsers['headerColumns'], $parsers['footerColumns']);
	}

	public function parseSettings($item){
		return [];
	}

	protected function getParsers($item = null){

		$tablify = new Tablify($this->getCollection($item));
		call_user_func($this->closure, $tablify);
		return [
			'parsers' => $tablify->getParsers(),
			'headerColumns' => $tablify->getHeaderColumns(),
			'footerColumns' => $tablify->getFooterColumns()
		];

	}

	protected function getCollection($item){
		if(!$item) return [];
		if($this->binding instanceof  \Closure){
			$collection = call_user_func($this->binding, $item);
		}
		else{
			$collection = $this->getCollectionFromItem($item);
		}
		return $collection;
	}



	protected function getCollectionFromItem($item){

		$keys = explode('.', $this->binding);

		foreach($keys as $key){
			if(is_array($item) && array_key_exists($key, $item)){
				$item = $item[$key];
			}
			elseif(is_object($item) && $item->{$key}){
				$item = $item->{$key};
			}
			else{
				$item = null;
			}

			if(!$item) return [];
		}

		return $item;


	}
}
