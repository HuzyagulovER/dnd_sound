<?php

namespace App\Providers;

use App\Macros\BlueprintMacros;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider
	extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @throws \ReflectionException
	 */
	public function boot(): void
	{
		if (config('app.env') === 'local') {
			URL::forceScheme('http');
		}

		Blueprint::mixin(new BlueprintMacros);
	}
}
