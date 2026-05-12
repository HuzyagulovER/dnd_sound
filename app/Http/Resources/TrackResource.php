<?php

namespace App\Http\Resources;

use App\Models\Track;
use App\Services\Track\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Track
 */
class TrackResource
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
			'id'          => $this->id,
			'title'       => $this->title,
			'description' => $this->description,
			'file'        => Storage::url(Media::getPath($this->id)),
		];
	}
}
