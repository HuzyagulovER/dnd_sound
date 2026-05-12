<?php

namespace Database\Factories;

use App\Models\SoundPack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoundPack>
 */
class SoundPackFactory
	extends Factory
{
	protected $model = SoundPack::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => fake()->realText(30),
		];
	}

	public function forRandomUser(): SoundPackFactory
	{
		return $this->state(
			function () {
				return [
					'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
				];
			}
		);
	}
}
