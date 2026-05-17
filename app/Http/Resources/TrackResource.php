<?php

namespace App\Http\Resources;

use App\Models\Track;
use App\Services\Track\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Track
 */
class TrackResource
	extends AbstractMediaResource
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
			'file'        => $this->getFileString($this->id),
			'image'       => Image::getRealUrl($this->id),
		];
	}
}
