<?php

namespace Dialect\Tablify;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class TablifyServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . '/../views', 'tablify');
		$this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
		$this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);
		$loader = AliasLoader::getInstance();
		$loader->alias('Excel', "\Maatwebsite\Excel\Facades\Excel");
		$loader->alias('PDF', "\Barryvdh\DomPDF\Facade");
		$this->publishes([
			__DIR__.'/../config/tablify.php' => config_path('tablify.php'),
		], 'config');
		$this->publishes([
			__DIR__ . '/../views' => base_path('resources/views/vendor/tablify')
		], 'views');
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('tablify', Tablify::class);

	}

}