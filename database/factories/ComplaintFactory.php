<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "date" => $this->faker->date("Y-m-d"),
            "title" => $this->faker->sentence(mt_rand(1, 3)),
            "slug" => $this->faker->slug(),
            "body" => collect($this->faker->paragraphs(mt_rand(5, 10)))
                ->map(fn ($p) => "<p>$p</p>")
                ->implode(""),
            "excerpt" => $this->faker->sentence(mt_rand(3, 5)),
            "student_nik" => $this->faker->randomElement(["1234561234567890", "1234556789061234", "5678901234561234"]),
            "category_id" => mt_rand(1, 11),
            "place" => $this->faker->randomElement(["out", "in"]),
            "status" => $this->faker->randomElement(["0", "1", "2"]),
            "privacy" => $this->faker->randomElement(["anonymous", "public"]),
            "created_at" => $this->faker->dateTimeBetween("-6 days", "now"),
        ];
    }
}
