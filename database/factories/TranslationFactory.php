<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Translation::class;
    public function definition(){
        return [
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'key' => Str::uuid()->toString(),
            'content' => $this->faker->sentence,
            'tags' => $this->faker->randomElement([
                ['mobile', 'desktop', 'web'],
                ['mobile', 'tablet'],
                ['desktop', 'web'],
            ]),
        ];
    }
}
