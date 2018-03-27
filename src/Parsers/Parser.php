<?php
namespace Dialect\Tablify\Parsers;

class Parser{


	public static function parseHeaders($parseObjects){
		$headers = [];
		foreach($parseObjects as $parseObject){
			if($parseObject instanceof ParseGroup){
				$headers = Parser::addHeaderGroup($parseObject, $headers);
			}
			else{
				$headers = Parser::addHeader($parseObject, $headers);
			}
		}

		return $headers;
	}
	protected static function addHeader($object, $headers){
		$header = $object->parseHeader();
		if(!Parser::containsHeader($header, $headers)){
			$headers[] = $header;
		}
		return $headers;
	}

	protected static function addHeaderGroup($group, $headers){
		$objects = $group->parseHeaders();

		foreach($objects as $header){
			if(!Parser::containsHeader($header, $headers)){
				$headers[] = $header;
			}
		}
		return $headers;
	}

	protected static function containsHeader($header, $headers){
		foreach($headers as $h){
			if($h->getValue() == $header->getValue()) return true;
		}
		return false;
	}

	public static function parseRows($objects, $collection){
		$rows = [];

		foreach($collection as $item){
			$mainRow = [];
			$groupRows = [];
			foreach($objects as $object){
				if($object instanceof ParseGroup){
					$groupRows = array_merge($groupRows, $object->parseRows($item));
				}else{
					$mainRow = array_merge($mainRow, $object->parseRow($item));
				}
			}
			$rows[] = $mainRow;
			foreach($groupRows as $gr){
				$rows[] = $gr;
			}
		}
		return $rows;
	}


}