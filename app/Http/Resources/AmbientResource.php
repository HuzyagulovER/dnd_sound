<?php

namespace App\Http\Resources;

use App\Models\Ambient;
use App\Services\Ambient\Media;
use App\Services\Ambient\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Ambient
 */
class AmbientResource
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
