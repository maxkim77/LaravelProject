<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'body' => fake() ->paragraph(1), 
        //여러개 paragraph가 나와서 오류가 떠서 1로 수정    
        'user_id' => 1,
    ];
    }
}