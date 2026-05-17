<?php

namespace App\Services\File;

use Illuminate\Support\Facades\Storage;

abstract class AbstractImage
	extends AbstractFile
{
	public static function getRealUrl(string $path): ?string
	{
		$storage = Storage::disk('public');
		return $storage->exists(static::getPath($path)) ? $storage->url(static::getPath($path)) : null;
	}
}