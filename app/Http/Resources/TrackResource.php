<?php

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Request;

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
		];
	}
}
