<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider
	extends BaseRouteServiceProvider
{
	public function map(): void
	{
		$this->mapStorageRoutes();
		$this->mapWebRoutes();
		$this->mapApiRoutes();
	}

	protected function mapStorageRoutes(): void
	{
		// Storage маршруты без middleware set.guard
		Route::middleware(['web']) // Только web, без set.guard
		     ->group(base_path('routes/storage.php'));
	}

	protected function mapWebRoutes(): void
	{
		Route::middleware(['web', 'set.guard:web'])
		     ->group(base_path('routes/web.php'));
	}

	protected function mapApiRoutes(): void
	{
		Route::prefix('api')
		     ->middleware(['api'])
//		     ->withoutMiddleware('jwt.auth')
		     ->name('api.')
		     ->group(base_path('routes/api.php'));
	}
}
