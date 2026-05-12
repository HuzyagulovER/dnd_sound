<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string id
 * @property string title
 */
class SoundPack
	extends Model
{
	use HasUuids, HasFactory;

	public function tracks(): HasMany
	{
		return $this->hasMany(Track::class);
	}

	public function ambient(): HasMany
	{
		return $this->hasMany(Ambient::class);
	}

	public function one_shots(): HasMany
	{
		return $this->hasMany(OneShot::class);
	}

	public function allMedia(): Collection
	{
		return collect(
			[
				'tracks'   => $this->tracks,
				'ambient'  => $this->ambient,
				'one_shot' => $this->one_shot,
			]
		);
	}
}
