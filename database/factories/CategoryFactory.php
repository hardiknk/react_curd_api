<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        // $table->string("custom_id")->nullable();
        // $table->string("title")->nullable();
        // $table->string("description")->nullable();
        // $table->enum("is_active", ["y", 'n'])->default("y")->nullable();

        $is_active = ["y", 'n'];
        return [
            'title' => $this->faker->text(6),
            'custom_id' => getUniqueString("categories"),
            'description' => $this->faker->text(50),
            'is_active' => $this->faker->randomElement($is_active),
        ];
    }
}
