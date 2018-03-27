<?php
namespace Dialect\Tablify\Parsers;
class ParseCurrency extends ParseObject{

	public function process($value) {
		if($this->settings['currency_symbol_after']){
			return number_format($value, $this->settings['decimals'], $this->settings['decimal_point'], $this->settings['thousands_separator']).$this->settings['currency_symbol'];
		}else{
			return $this->settings['currency_symbol'].number_format($value, $this->settings['decimals'], $this->settings['decimal_point'], $this->settings['thousands_separator']);
		}
	}

}


