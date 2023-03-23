<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Response>
 */
class ResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "complaint_id" => mt_rand(1, 15),
            "body" => collect($this->faker->paragraphs(mt_rand(5, 10)))
                ->map(fn ($p) => "<p>$p</p>")
                ->implode(""),
            "officer_nik" => $this->faker->randomElement(["1234567890123456", "1201234563456789", "1234512345667890", "1234516678902345", '1238902345451667']),
            "created_at" => $this->faker->dateTimeBetween("-6 days", "now"),
        ];
    }
}
