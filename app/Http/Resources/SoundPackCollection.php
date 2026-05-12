<?php

namespace App\Http\Resources;

use App\Models\SoundPack;
use App\Services\SoundPack\Image;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @mixin SoundPack
 */
class SoundPackCollection
	extends ResourceCollection
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return collect($this->collection)
			->map(
				function (SoundPackResource $item) use ($request) {
					$collection = collect($item->toArray($request));
					return $collection
						->put(
							'count',
							(function () use ($collection) {
								$media = collect($collection->get('media'));

								return $media->map(fn (EloquentCollection|AnonymousResourceCollection|null $item) => $item?->count() ?? 0)->sum();
							})()
						)
						->forget('media');
				}
			)
			->toArray();
	}

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
//	public function toArray(Request $request): array
//	{
//		return [
//			'id'    => $this->id,
//			'title' => $this->title,
//			'count' => $this->allMedia()
//			                ->map(fn (?EloquentCollection $item) => $item?->count() ?? 0)
//			                ->sum(),
//			'image' => Storage::url(Image::getPath($this->id))
//		];
//	}
}
