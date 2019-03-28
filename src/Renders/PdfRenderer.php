<?php
namespace Dialect\Tablify\Renders;

use Barryvdh\DomPDF\Facade as PDF;

class PdfRenderer extends HtmlRenderer {
    protected $documentName, $data, $footer;
    function __construct($data, $documentName = 'tablify', $footer = null) {
        $this->data = $data;
        $this->documentName = $documentName;
        $this->footer = $footer;
    }


    public function render($footer = null) {
        $html = Parent::render($this->footer);
        $pdf = PDF::loadView("tablify::pdf", ["html" => $html]);
        return $pdf->download($this->documentName);

    }
}