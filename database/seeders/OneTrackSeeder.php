<?php

namespace Database\Seeders;

use App\Models\Ambient;
use App\Models\OneShot;
use App\Models\SoundPack;
use App\Models\Track;
use App\Models\User;
use Database\Factories\AmbientFactory;
use Database\Factories\OneShotFactory;
use Database\Factories\SoundPackFactory;
use Database\Factories\TrackFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OneTrackSeeder
	extends Seeder
{
	use WithoutModelEvents;

	private int $soundPackId;

	public function __construct(int $soundPackId)
	{
		$this->soundPackId = $soundPackId;
	}

	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		Track::factory()->forSoundPack($this->soundPackId)->create();
	}
}
