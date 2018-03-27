<?php
namespace Dialect\Tablify\Parsers;
class ParseNumber extends ParseObject{

	public function process($value) {
		return number_format($value, $this->settings['decimals'], $this->settings['decimal_point'],$this->settings['thousands_separator']).$this->settings['unit'];
	}
}


