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

class DatabaseSeeder
	extends Seeder
{
	use WithoutModelEvents;

	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		/** @var SoundPackFactory $soundPackFactory */
		$soundPackFactory = SoundPack::factory();
		/** @var TrackFactory $trackFactory */
		$trackFactory = Track::factory();
		/** @var AmbientFactory $ambientFactory */
		$ambientFactory = Ambient::factory();
		/** @var OneShotFactory $oneShotFactory */
		$oneShotFactory = OneShot::factory();

//		User::factory(10)->create();

		$soundPackFactory->forRandomUser()->count(5)->create();
		$trackFactory->forRandomSoundPack()->count(10)->create();
		$ambientFactory->forRandomSoundPack()->count(10)->create();
		$oneShotFactory->forRandomSoundPack()->count(10)->create();
	}
}
