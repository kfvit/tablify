<?php
namespace Dialect\Tablify\Parsers;

use Dialect\Tablify\Objects\Column;
use Dialect\Tablify\Objects\Header;
use Illuminate\Support\Collection;

class ParseObject{
	protected $header, $binding, $settings;
	function __construct($header, $binding, $settings, $headerSettings) {
		$this->header = $header;
		$this->binding = $binding;
		$this->settings = $settings;
		$this->headerSettings = $headerSettings;
	}

	public function parseHeader(){
		$settings = $this->parseSettings($this->headerSettings, null);
		return new Header($this->header, $settings['class'], $settings['style'], $settings['id']);
	}

	public function parseRow($item){
		$values = $this->parseValue($item);
		$settings = $this->parseSettings($this->settings, $item);
		return [$this->header => new Column($values['processed'], $values['raw'], $settings['class'], $settings['style'], $settings['id'])];
	}

	protected function parseSettings($settings, $item){
		return [
			'class' => $this->parseSetting($settings, 'class', $item),
			'id' => $this->parseSetting($settings, 'id', $item),
			'style' => $this->parseSetting($settings, 'style', $item),
		];
	}

	protected function parseSetting($settings, $setting, $item){
		$value = null;
		if(is_array($settings) && array_key_exists($setting,$settings)){
			$value = $settings[$setting];
			if($value instanceof \Closure){
				$value = call_user_func($value, $item);
			}
		}

		return $value;
	}

	protected function parseValue($item){
		$value = null;
		if($item instanceof Collection){
			$item = $item->all();
		}

		if($this->binding instanceof \Closure) {
			$value = call_user_func($this->binding, $item);
		}else{
			$value = $this->parseValueFromBinding($item);
		}

		return ['processed' => $this->process($value), 'raw' => $value];


	}

	protected function parseValueFromBinding($item){
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

			if(!$item) return null;
		}

		return $item;

	}

	protected function process($value){
		return $value;
	}

}