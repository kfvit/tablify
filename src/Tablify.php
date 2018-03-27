<?php
namespace Dialect\Tablify;
use Dialect\Tablify\Parsers\ParseCurrency;
use Dialect\Tablify\Parsers\ParseNumber;
use Dialect\Tablify\Parsers\Parser;
use Dialect\Tablify\Parsers\ParseObject;
use Dialect\Tablify\Parsers\ParseGroup;
use Dialect\Tablify\Renders\ArrayRenderer;
use Dialect\Tablify\Renders\HtmlRenderer;
use Dialect\Tablify\Renders\JsonRenderer;
use Dialect\Tablify\Renders\PdfRenderer;
use Dialect\Tablify\Renders\XlsRenderer;
use Dialect\Tablify\Renders\XlsxRenderer;

class Tablify{
	protected $parserObjects;
	protected $collection;
	function __construct($collection = null) {
		$this->parserObjects = [];
		$this->collection = $collection;
	}

	public function setCollection($collection){
		$this->collection = $collection;
	}

	public function map($headerName, $binding, $settings = null, $headerSettings = null){
		$this->parserObjects[] = new ParseObject($headerName, $binding, $settings, $headerSettings);
		return $this;
	}

	public function group($binding, $closure){
		$this->parserObjects[] = new ParseGroup($binding, $closure);
		return $this;
	}

	public function text($headerName, $binding, $settings = null, $headerSettings = null){
		$this->map($headerName, $binding, $settings, $headerSettings);
		return $this;
	}

	public function number($headerName, $binding, $settings = null, $headerSettings = null){
		$settings = $settings + config('tablify.number');
		$headerSettings = $headerSettings + config('tablify.number.header');
		$this->parserObjects[] = new ParseNumber($headerName, $binding, $settings, $headerSettings);
		return $this;
	}

	public function currency($headerName, $binding, $settings = null, $headerSettings = null){
		$settings = $settings + config('tablify.currency');
		$headerSettings = $headerSettings + config('tablify.currency.header');
		$this->parserObjects[] = new ParseCurrency($headerName, $binding, $settings, $headerSettings);
		return $this;
	}


	protected function parse(){
		return [
			'headers' => Parser::parseHeaders($this->parserObjects),
			'rows' => Parser::parseRows($this->parserObjects, $this->collection)
		];
	}

	protected function render($renderer){
		return $renderer->render();
	}

	public function toArray(){
		return $this->render(new ArrayRenderer($this->parse()));
	}

	public function toJson(){
		return $this->render(new JsonRenderer($this->parse()));
	}

	public function toHtml(){
		return $this->render(new HtmlRenderer($this->parse()));
	}

	public function toXlsx($documentName = 'tablify'){
		return $this->render(new XlsxRenderer($this->parse(), $documentName));
	}

	public function toXls($documentName = 'tablify'){
		return $this->toXlsx($documentName);
	}

	public function toExcel($documentName = 'tablify'){
		return $this->toXlsx($documentName);
	}

	public function toPdf($documentName = 'tablify'){
		return $this->render(new PdfRenderer($this->parse(), $documentName));
	}

	public function getParsers(){
		return $this->parserObjects;
	}

}