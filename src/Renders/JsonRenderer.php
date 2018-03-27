<?php
namespace Dialect\Tablify\Renders;

class JsonRenderer extends ArrayRenderer {

	public function __construct($data) {
		parent::__construct($data);
	}

	public function render() {
		return json_encode(parent::render());
	}
}