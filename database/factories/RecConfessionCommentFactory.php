<?php

namespace Database\Factories;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecConfessionCommentModel>
 */
class RecConfessionCommentFactory extends Factory
{
    use Daily;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "id_confession" => mt_rand(1, 200),
            "id_user" => $this->faker->randomElement($randomnessOfUsers),
            "comment" => collect($this->faker->paragraphs(mt_rand(1, 1)))
                ->map(fn ($p) => "<p>$p</p>")
                ->implode(""),
            "privacy" => $this->faker->randomElement(["anonymous", "public"]),
            "created_at" => $this->faker->dateTimeBetween("-" . self::getTotalDays() . " days", "now"),
        ];
    }
}
