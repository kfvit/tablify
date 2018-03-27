<?php
namespace Dialect\Tablify\Renders;

class ArrayRenderer implements Renderer{
	protected $data;
	public function __construct($data) {
		$this->data = $data;
	}

	public function render() {
		$array = [];

		foreach($this->data['rows'] as $row){
			$res = [];
			foreach($row as $head => $col){
				$res[$head] = $col->getValue();
			}
			$array[] = $res;
		}

		return $array;
	}
}