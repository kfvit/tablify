<?php
if (! function_exists('tablify')) {
	/**
	 * Create instance of tablify
	 * @param $collection
	 *
	 * @return \Dialect\Tablify\Tablify
	 */
	function tablify($collection = null) {
		$tablify = app('tablify');
		$tablify->setCollection($collection);
		return $tablify;
	}
}
