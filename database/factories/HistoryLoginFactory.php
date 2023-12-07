<?php

namespace Database\Factories;

use App\Models\Traits\Daily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistoryLogin>
 */
class HistoryLoginFactory extends Factory
{
    use Daily;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $operatingSystem = ["\"Linux\"", "\"Mac\"", "\"Windows\"", "\"Android\""];

        return [
            "username" => $this->faker->randomElement(["alfianchii", "moepoi", "nata.ardhana", 'fauzy', "fadli.890"]),
            "attempt_result" => $this->faker->randomElement(["Y", "N"]),
            "operating_system" => $this->faker->randomElement($operatingSystem),
            "remote_address" => "127.0.0.1",
            "user_agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36",
            "browser" => "\"Brave\";v=\"117\", \"Not;A=Brand\";v=\"8\", \"Chromium\";v=\"117\"\\",
            "created_at" => $this->faker->dateTimeBetween("-" . self::getTotalDays() . " days", "now"),
        ];
    }
}
