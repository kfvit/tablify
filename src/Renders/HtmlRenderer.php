<?php
namespace Dialect\Tablify\Renders;

class HtmlRenderer implements Renderer{
	protected $data;
	public function __construct($data) {
		$this->data = $data;
	}

	public function render() {
		$class = config('tablify.html')['class'];
		$html = '<table class="'.$class.'">';
		$html .= $this->renderHeader();
		$html .= $this->renderBody();
		$html .= '</table>';

		return $html;
	}

	protected function renderHeader(){
		$html = '<thead><tr>';
		foreach($this->data['headers'] as $header){
			$html .= '<th '.$this->getClass($header).$this->getStyle($header).$this->getId($header).'>'.$header->getValue().'</th>';

		}
		$html .= '</tr></thead>';
		return $html;
	}

	protected function renderBody(){
		$html = '<tbody>';
		foreach($this->data['rows'] as $row){
			$html .= '<tr>';
			foreach($this->data['headers'] as $header){
				$found = false;
				foreach($row as $key => $col){
					if($header->getValue() == $key){
						$html .= '<td '.$this->getClass($col).$this->getStyle($col).$this->getId($col).'>'.$col->getValue().'</td>';
						$found = true;
						break;
					}
				}
				if(!$found){
					$html .= '<td></td>';
				}
			}
			$html .= '</tr>';
		}
		if(count($this->data['sums'])){
			$html .= '<tr>';
			foreach($this->data['headers'] as $header){
				$found = false;
				foreach($this->data['sums'] as $key => $col){
					if($header->getValue() == $key){
						$html .= '<td '.$this->getClass($col).$this->getStyle($col).$this->getId($col).'><strong>'.$col->getValue().'</strong></td>';
						$found = true;
						break;
					}
				}
				if(!$found){
					$html .= '<td></td>';
				}
			}
			$html .= '</tr>';
		}

		$html .= '</tbody>';
		return $html;
	}

	protected function getClass($object){
		if($object->getClass()) return 'class="'.$object->getClass().'" ';

		return null;
	}

	protected function getStyle($object){
		if($object->getStyle()) return 'style="'.$object->getStyle().'" ';

		return null;
	}

	protected function getId($object){
		if($object->getId()) return 'id="'.$object->getId().'" ';

		return null;
	}
}