<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $faker = $this->faker;

        return [
            'nombre' => $faker->firstName,
            'apellido' => $faker->lastName,
            'edad' => $faker->numberBetween(18, 60),
            'cedula' => $faker->unique()->numerify('########'),
            'email' => $faker->unique()->safeEmail,
        ];
    }
}
