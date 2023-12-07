<?php

namespace Database\Factories;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistoryConfessionResponse>
 */
class HistoryConfessionResponseFactory extends Factory
{
    use Daily;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $officers = [6, 7, 8, 9, 10];

        return [
            "response" => collect($this->faker->paragraphs(mt_rand(1, 1)))
                ->map(fn ($p) => "<p>$p</p>")
                ->implode(""),
            "confession_status" => $this->faker->randomElement(["process"]),
            "id_user" => $this->faker->randomElement($officers),
            "created_at" => $this->faker->dateTimeBetween("-" . self::getTotalDays() . " days", "now"),
            "system_response" => "N",
            "id_confession" => mt_rand(1, 200),
        ];
    }
}
