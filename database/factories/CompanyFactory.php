<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company;
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => $this->faker->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'logo' => null,
            'type' => 'tenant',
            'parent_id' => null,
            'is_active' => true,
            'settings' => [
                'timezone' => $this->faker->timezone,
                'currency' => $this->faker->currencyCode,
                'billing_cycle' => $this->faker->randomElement(['monthly', 'quarterly', 'yearly']),
            ],
        ];
    }

    /**
     * Indicate that the company is a parent company.
     */
    public function parent(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'parent',
            'parent_id' => null,
        ]);
    }

    /**
     * Indicate that the company is a tenant.
     */
    public function tenant($parentId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'tenant',
            'parent_id' => $parentId,
        ]);
    }
}