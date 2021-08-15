<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Product::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'title' => $this->faker->words(3, true),
			'price' => $this->faker->randomFloat(2, 10, 100),
			'description' => $this->faker->realText(200),
			'quantity' => $this->faker->randomDigit,
			'discount' => $this->faker->numberBetween(1, 100),
			'user_id' => 1,
			'category_id' => $this->faker->numberBetween(1, 10)
		];
	}
}
