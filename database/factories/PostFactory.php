<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_active = ["y", 'n'];
        return [
            'title' => $this->faker->text(6),
            'name' => $this->faker->text(6),
            'description' => $this->faker->text(50),
            'custom_id' => getUniqueString("posts"),
            'is_active' =>  $this->faker->randomElement($is_active),
            'publish_date' => $this->faker->dateTimeBetween('-5 years'),
            'category_id' => $this->faker->randomElement(Category::all())['id'],
        ];
    }
}
