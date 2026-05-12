<?php

namespace App\Http\Resources;

use App\Models\SoundPack;
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
			'count' => $this->allMedia()
			                ->map(fn (?EloquentCollection $item) => $item?->count() ?? 0)
			                ->sum(),
			'image' => Storage::url('images/' . $this->id)
		];
	}
}
