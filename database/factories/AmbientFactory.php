<?php

namespace Database\Factories;

use App\Models\Ambient;
use App\Models\SoundPack;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoundPack>
 */
class AmbientFactory
	extends Factory
{
	protected $model = Ambient::class;

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

	public function forRandomSoundPack(): AmbientFactory
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
