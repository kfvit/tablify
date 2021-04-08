<?php
namespace Dialect\Tablify\Renders;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;

class XlsxRenderer extends HtmlRenderer {
	protected $documentName;
	protected $data;

	public function __construct($data, $documentName = 'tablify') {
		$this->data = $data;
		$this->documentName = $documentName;
	}

	public function render($footer = null, $header = null){

		$html = parent::render();

		return Excel::download(new Export($html), $this->documentName.'.xlsx');

	}

}

class Export implements FromView
{
	protected $html;
	function __construct($html) {
	$this->html = $html;
}

	public function view(): View
	{
		return view('tablify::excel', [
			'html' => $this->html
		]);
	}
}
