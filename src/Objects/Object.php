<?php
namespace Dialect\Tablify\Objects;

abstract class Object{

	protected $value,$rawValue, $class, $style, $id;
	function __construct($value, $rawValue, $class = null, $style = null, $id = null) {
		$this->value = $value;
		$this->rawValue = $rawValue;
		$this->class = $class;
		$this->style = $style;
		$this->id = $id;
	}

	public function getValue(){
		return $this->value;
	}

	public function getRawValue(){
		return $this->rawValue;
	}

	public function getClass(){
		return $this->class;
	}

	public function getStyle(){
		return $this->style;
	}

	public function getId(){
		return $this->id;
	}

}