<?php
namespace Dialect\Tablify;
use Dialect\Tablify\Parsers\ParseCurrency;
use Dialect\Tablify\Parsers\ParseFooterColumn;
use Dialect\Tablify\Parsers\ParseHeaderColumn;
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
    protected $headersToSum;
    protected $headerColumns;
    protected $footerColumns;
    protected $mainHeader;

    function __construct($collection = null) {
        $this->headerColumns = [];
        $this->footerColumns = [];
        $this->parserObjects = [];
        $this->collection = $collection;
        $this->headersToSum = [];
    }

    public function setCollection($collection){
        $this->collection = $collection;
    }

    public function map($headerName, $binding, $settings = [], $headerSettings = []){
        $this->parserObjects[] = new ParseObject($headerName, $binding, $settings, $headerSettings);
        return $this;
    }

    public function group($binding, $closure){
        $this->parserObjects[] = new ParseGroup($binding, $closure);
        return $this;
    }

    public function headerColumn($headerName, $value, $settings = []){
        $this->headerColumns[] = new ParseHeaderColumn($headerName, $value, $settings, []);
        return $this;
    }

    public function footerColumn($headerName, $value, $settings = []){
        $this->footerColumns[] = new ParseFooterColumn($headerName, $value, $settings, []);
        return $this;
    }

    public function text($headerName, $binding, $settings = [], $headerSettings = []){
        $this->map($headerName, $binding, $settings, $headerSettings);
        return $this;
    }

    public function number($headerName, $binding, $settings = [], $headerSettings = []){
        if($settings){
            $settings = $settings + config('tablify.number', []);
        }else{
            $settings = config('tablify.number', []);
        }
        if($headerSettings){
            $headerSettings = $headerSettings + config('tablify.number.header', []);
        }else{
            $headerSettings = config('tablify.number.header', []);
        }

        $this->parserObjects[] = new ParseNumber($headerName, $binding, $settings, $headerSettings);
        return $this;
    }

    public function currency($headerName, $binding, $settings = [], $headerSettings = []){
        if($settings){
            $settings = $settings + config('tablify.currency', []);
        }else{
            $settings = config('tablify.currency', []);
        }

        if($headerSettings){
            $headerSettings = $headerSettings + config('tablify.currency.header', []);
        }else{
            $headerSettings = config('tablify.currency.header', []);
        }


        $this->parserObjects[] = new ParseCurrency($headerName, $binding, $settings, $headerSettings);
        return $this;
    }

    public function sum($headersToSum){
        $this->headersToSum = $headersToSum;
        return $this;
    }

    protected function parse(){
        $headers =  Parser::parseHeaders($this->parserObjects);
        $rows = Parser::parseRows($this->parserObjects, $this->collection, $this->headerColumns, $this->footerColumns);
        $sums = Parser::parseSumRows($rows, $this->headersToSum);
        return [
            'headers' => $headers,
            'rows' => $rows,
            'sums' => $sums
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

    public function toPdf($documentName = 'tablify', $footer = null){
        return $this->render(new PdfRenderer($this->parse(), $documentName, $footer, $this->mainHeader));
    }

    public function getParsers(){
        return $this->parserObjects;
    }

    public function getHeaderColumns(){
        return $this->headerColumns;
    }

    public function getFooterColumns(){
        return $this->footerColumns;
    }

    public function mainHeader($header)
    {
        $this->mainHeader = $header;
        return $this;
    }
}
