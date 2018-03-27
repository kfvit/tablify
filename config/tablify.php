<?php

return [
	/*
	 * Settings for renderers
	 */

	'html' => [
		'class' => 'table table-striped',
	],

	/*
	 * Settings for helpers
 	 */

	'number' => [
		'decimals' => 0,
		'decimal_point' => '.',
		'thousands_separator' => '',
		'unit' => '',
		'class' => 'text-right',
		'header' => [
			'class' => 'text-right',
		]
	],
	'currency' => [
		'decimals' => 2,
		'decimal_point' => '.',
		'thousands_separator' => ' ',
		'currency_symbol' => '$',
		'currency_symbol_after' => false,
		'class' => 'text-right',
		'header' => [
			'class' => 'text-right',
		]
	]
];
