<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

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
        $name = $this->faker->realText(20);
        $price = $this->faker->randomFloat(2, 0, 9999.99);
        return [
            'category_id' => $this->faker->randomElement(range(1, 10)),
            'name' => $name,
            'slug' => Str::slug($name),
            'initial_price' => $price,
            'price' => $price,
            'closing_price' => $this->faker->randomFloat(2, $price, 12000.00),
            'auto_increment' => $this->faker->boolean(1),
            'min_increment' => $this->faker->randomFloat(2, 2, 10),
            'bid_credit' => 1,
            'starts_at' => now(),
            'expire_at' => $this->faker->dateTimeBetween('+30 minutes', '+1 day'),
            'description' => $this->faker->realText(2000),
        ];
    }
}
