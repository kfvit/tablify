<?php
namespace Dialect\Tablify\Renders;
interface Renderer{

	public function __construct($data);
	public function render();
}