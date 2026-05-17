<?php

namespace App\Http\Resources;

use App\Models\OneShot;
use App\Services\OneShot\Image;
use App\Services\OneShot\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin OneShot
 */
class OneShotResource
	extends AbstractMediaResource
{
	public const MEDIA_CLASS = Media::class;

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'          => $this->id,
			'title'       => $this->title,
			'description' => $this->description,
			'file'        => $this->getFileString($this->id),
			'image'       => Image::getRealUrl($this->id),
		];
	}
}
