<?php

namespace App\Http\Resources;

use App\Models\Track;
use App\Services\Track\Media;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @mixin Track
 */
class AbstractMediaResource
	extends JsonResource
{
	public const MEDIA_CLASS = Media::class;

	public function getFileString(string $id): string
	{
		$storage  = Storage::disk('public');
		$filepath = collect($storage->allFiles(static::MEDIA_CLASS::STORAGE_PATH))
			->firstWhere(fn (string $item) => Str::of($item)->contains($id));

		return !empty($filepath) && $storage->exists($filepath)
			? Storage::url($filepath)
			: '';
	}
}
