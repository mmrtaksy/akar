<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Services;

class ServicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'model_id' => $this->faker->randomElement([1, 2]),
            'title' => $this->faker->sentence(2),
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraphs(2, true),
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->text(160),
            'meta_keywords' => implode(',', $this->faker->words(5)),
            'statu' => $this->faker->boolean,
            'lang' => 1,
            'parent_id' => null,
            'sort_id' => $this->faker->randomDigit,
            'lang_parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
