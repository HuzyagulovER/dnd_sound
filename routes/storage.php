<?php

use Illuminate\Support\Facades\Route;

Route::get('/storage/{path}', function ($path) {
	$filePath = storage_path('app/public/' . $path);

	if (!file_exists($filePath) || is_dir($filePath)) {
		abort(404);
	}

	$getId3 = new getID3;

	$mimeType = $getId3->analyze($filePath);

	return response()->file($filePath, [
		'Content-Type' => $mimeType,
	]);
})->where('path', '.*');
