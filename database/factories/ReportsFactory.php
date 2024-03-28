<?php

namespace Database\Factories;
use App\Models\Report;
    use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportsFactory extends Factory
{
    protected static?string $model= Report::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_category'=> $this->faker->name,
            'description'=> $this->faker->name,
            'status'=> $this->faker->name,
            'user_id'=> $this->faker->integers,
        ];
    }
}
