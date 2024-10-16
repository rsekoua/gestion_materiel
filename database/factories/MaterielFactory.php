<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materiel>
 */
class MaterielFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['ordinateur', 'imprimante', 'videoprojecteur']),
            'marque' => $this->faker->randomElement(['Dell', 'HP', 'Lenovo', 'Canon', 'Epson', 'Sony']),
            'modele' => $this->faker->bothify('Model-###'),
            'numero_serie' => strtoupper($this->faker->unique()->bothify('SN-?????-#####')), // Génère un numéro de série unique
            'est_disponible' => true, // Le matériel est disponible par défaut lors de la création
            'est_fonctionnel' => $this->faker->boolean(90), // 90% de chances que le matériel soit fonctionnel
            'date_fabrication' => $this->faker->dateTimeBetween('-6 years', 'now'), // Date de fabrication entre il y a 6 ans et maintenant

        ];
    }
}
