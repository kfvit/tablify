<?php
namespace Dialect\Tablify\Renders;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfRenderer extends HtmlRenderer {

    protected $documentName;
    protected $data;
    protected $footer;
    protected $header;

    function __construct($data, $documentName = 'tablify', $footer = null, $header = null) {
        $this->data = $data;
        $this->documentName = $documentName;
        $this->footer = $footer;
        $this->header = $header;
    }


    public function render($footer = null, $header = null) {
        $html = Parent::render($this->footer, $this->header);
        $pdf = Pdf::loadView("tablify::pdf", ["html" => $html]);
        return $pdf->download($this->documentName);

    }
}
