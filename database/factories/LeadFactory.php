<?php

namespace Database\Factories;
use App\Models\Client;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "score"     => rand(1, 10),
            "name"       => fake()->name(),
            "email"      => fake()->unique()->safeEmail(),
            "phone"      => fake()->phoneNumber(),
        ];
    }

}
