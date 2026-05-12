<?php

namespace App\Services\File;

use Illuminate\Support\Str;

abstract class AbstractFile
{
	public const STORAGE_PATH = '';

	public static function getPath(string $path): string
	{
		return static::STORAGE_PATH . '/' . Str::of($path)->ltrim('/');
	}
}