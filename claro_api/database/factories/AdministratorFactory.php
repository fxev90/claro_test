<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdministratorFactory extends Factory
{
    public function definition(): array
    {
        return [
            "nombre" => "Administrator",
            "email" => "admin@example.com",
            "apellido" => "Administrator",
            "password" => bcrypt("123456789"),
        ];
    }
}
