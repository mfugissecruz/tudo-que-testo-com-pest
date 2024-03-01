<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'title' => fake()->title,
            'owner_id' => $user->id,
            'code' => 'jeremias'
        ];
    }
}
