<?php

namespace Database\Factories;

use App\Models\Chamado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chamado>
 */
class ChamadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(4),
            'descricao' => $this->faker->paragraph(),
            'solitante' => $this->faker->name(),
            'data_de_abertura' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'data_de_fechamento' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['pedente', 'em_andamento', 'finalizado']),
        ];
    }
}
