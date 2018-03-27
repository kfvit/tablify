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

		return Parser::parseHeaders($this->getParsers());
	}

	public function parseRows($item){

		return Parser::parseRows($this->getParsers($item), $this->getCollection($item));
	}

	public function parseSettings($item){
		return [];
	}

	protected function getParsers($item = null){

		$tablify = new Tablify($this->getCollection($item));
		call_user_func($this->closure, $tablify);
		if($tablify->getParsers()){
			return $tablify->getParsers();
		}
		return [];
	}

	protected function getCollection($item){
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