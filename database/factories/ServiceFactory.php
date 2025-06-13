<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'service_id' => 'SRV-' . strtoupper(Str::random(6)), // ID custom
            'tanggal_masuk' => $this->faker->date(),
            'owner' => $this->faker->name(),
            'kendala' => $this->faker->sentence(),
            'penggantian_part' => $this->faker->word(),
            'tipe' => $this->faker->randomElement(['Elektronik', 'Mekanik', 'Software']),
            'serial_number' => $this->faker->unique()->numberBetween(100000, 999999),
        ];
    }
}
