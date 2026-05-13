<?php

namespace App\Http\Resources;

use App\Models\Ambient;
use App\Services\Ambient\Media;
use Illuminate\Http\Request;

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
		];
	}
}
