<?php

namespace Database\Factories;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecConfession>
 */
class RecConfessionFactory extends Factory
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
            "date" => $this->faker->date("Y-m-d"),
            "title" => $this->faker->sentence(mt_rand(1, 3)),
            "slug" => $this->faker->slug(),
            "body" => collect($this->faker->paragraphs(mt_rand(5, 10)))
                ->map(fn ($p) => "<p>$p</p>")
                ->implode(""),
            "excerpt" => $this->faker->sentence(mt_rand(3, 5)),
            "place" => $this->faker->randomElement(["out", "in"]),
            "status" => $this->faker->randomElement(["process"]),
            "privacy" => $this->faker->randomElement(["anonymous", "public"]),
            "created_at" => $this->faker->dateTimeBetween("-" . self::getTotalDays() . " days", "now"),
            "id_confession_category" => mt_rand(1, 11),
            "id_user" => $this->faker->randomElement([3, 4, 5]),
            "assigned_to" => $this->faker->randomElement([6, 7, 8, 9, 10]),
        ];
    }
}