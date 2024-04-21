<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
/**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $tiposCurso = ['Presencial', 'Virtual'];
        $horarios = ['Mañana', 'Tarde', 'Noche'];

        $fechaInicio = $this->faker->dateTimeBetween('-1 year', 'now');
        $fechaFin = $this->faker->dateTimeBetween($fechaInicio, '+6 months');

        return [
            'nombre' => $this->faker->sentence(3),
            'horario' => $this->faker->randomElement($horarios),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'tipo' => $this->faker->randomElement($tiposCurso),
        ];
    }
}
