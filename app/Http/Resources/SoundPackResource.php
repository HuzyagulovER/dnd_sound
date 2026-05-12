<?php

namespace App\Http\Resources;

use App\Models\SoundPack;
use App\Services\SoundPack\Image;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin SoundPack
 */
class SoundPackResource
	extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'    => $this->id,
			'title' => $this->title,
			'media' => [
				'tracks' => TrackResource::collection($this->tracks),
				'ambient' => $this->ambient,
				'one_shots' => $this->one_shots,
			],
			'image' => Storage::url(Image::getPath($this->id))
		];
	}
}
