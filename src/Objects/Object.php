<?php
namespace Dialect\Tablify\Objects;

abstract class Object{

	protected $value, $class, $style, $id;
	function __construct($value, $class = null, $style = null, $id = null) {
		$this->value = $value;
		$this->class = $class;
		$this->style = $style;
		$this->id = $id;
	}

	public function getValue(){
		return $this->value;
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