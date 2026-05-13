<?php

namespace Database\Factories;

use App\Models\SoundPack;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoundPack>
 */
class TrackFactory
	extends Factory
{
	protected $model = Track::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title'       => fake()->realText(30),
			'description' => fake()->realTextBetween(5, 20),
		];
	}

	public function forRandomSoundPack(): TrackFactory
	{
		return $this->state(
			function () {
				return [
					'sound_pack_id' => SoundPack::inRandomOrder()->first()?->id ?? SoundPack::factory(),
				];
			}
		);
	}

	public function forSoundPack(string $id): TrackFactory
	{
		return $this->state(
			function () use ($id) {
				return [
					'sound_pack_id' => $id,
				];
			}
		);
	}
}
