<?php

namespace Database\Factories;

use App\Models\OneShot;
use App\Models\SoundPack;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoundPack>
 */
class OneShotFactory
	extends Factory
{
	protected $model = OneShot::class;

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

	public function forRandomSoundPack(): OneShotFactory
	{
		return $this->state(
			function () {
				return [
					'sound_pack_id' => SoundPack::inRandomOrder()->first()?->id ?? SoundPack::factory(),
				];
			}
		);
	}
}
