<?php
namespace Dialect\Tablify\Parsers;

use Dialect\Tablify\Objects\Column;
use Dialect\Tablify\Objects\Sum;

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

	public static function parseRows($objects, $collection, $headerColumns = [], $footerColumns = []){
		$rows = [];

		$headerRow = [];
		foreach($headerColumns as $headerColumn){
			$headerRow = array_merge($headerRow, $headerColumn->parseRow(null));
		}

		if(count($headerRow)){
			$rows[] = $headerRow;
		}

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

		$footerRow = [];
		foreach($footerColumns as $footerColumn){
			$footerRow = array_merge($footerRow, $footerColumn->parseRow(null));
		}

		if(count($footerRow)){
			$rows[] = $footerRow;
		}

		return $rows;
	}

	public static function parseSumRows($paredRows, $headersToSum){

		$sums = [];
		$headers = [];
		//Init values to 0
		foreach($headersToSum as $header => $settings){
			if(is_array($settings)){
				$headers[] = $header;
				$sums[$header] = 0;
			}else{
				$headers[] = $settings;
				$sums[$settings] = 0;
			}
		}

		//sum
		foreach($paredRows as $row){

			foreach($headers as $header){
				if(array_key_exists($header, $row)){
					$sums[$header] += floatval($row[$header]->getRawValue());
				}
			}
		}

		$sumObjects = [];
		//format and convert sums
		foreach($sums as $header => $sum){
			$settings = array_key_exists($header, $headersToSum) ? $headersToSum[$header] : [];
			$sumObjects[$header] = new Sum(Parser::processSumValue($sum, $settings), $sum, Parser::getSumSettings('class', $settings), Parser::getSumSettings('style', $settings), Parser::getSumSettings('id', $settings));
		}

		return $sumObjects;
	}

	protected static function getSumSettings($settingsName, $settings){
		if($settingsName == 'class'){
			if(array_key_exists($settingsName, $settings)) return $settings[$settingsName] + config('tablify.number.class', []);
		}
		if(array_key_exists($settingsName, $settings)) return $settings[$settingsName];

		return null;
	}

	protected static function  processSumValue($value, $settings) {
		$format = number_format($value, Parser::getSumSettings('decimals', $settings) ?: config('tablify.number.decimals'),
			Parser::getSumSettings('decimal_point', $settings) ?: config('tablify.number.decimal_point'),
			Parser::getSumSettings('thousands_separator', $settings) ?: config('tablify.number.thousands_separator'));

		if( Parser::getSumSettings('currency_symbol_after', $settings)){
			return $format.Parser::getSumSettings('currency_symbol', $settings);
		}else{
			return Parser::getSumSettings('currency_symbol', $settings).$format;
		}
	}


}