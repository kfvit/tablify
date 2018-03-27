<?php
namespace Dialect\Tablify\Renders;

use Barryvdh\DomPDF\Facade as PDF;

class PdfRenderer extends HtmlRenderer {
	protected $documentName, $data;
	function __construct($data, $documentName = 'tablify') {
		$this->data = $data;
		$this->documentName = $documentName;
	}


	public function render() {
		$html = Parent::render();
		$pdf = PDF::loadView("tablify::pdf", ["html" => $html]);
		return $pdf->download($this->documentName);

	}
}