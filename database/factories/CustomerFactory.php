<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerId = 'CUST-' . $this->faker->unique()->numerify('######');
        
        return [
            'company_id' => Company::factory(),
            'customer_id' => $customerId,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'whatsapp_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'status' => $this->faker->randomElement(['active', 'suspended', 'inactive']),
            'connection_type' => $this->faker->randomElement(['fiber', 'wireless', 'cable']),
            'service_plan' => $this->faker->randomElement(['Basic 10Mbps', 'Standard 25Mbps', 'Premium 50Mbps', 'Ultimate 100Mbps']),
            'monthly_fee' => $this->faker->randomFloat(2, 25, 150),
            'installation_date' => $this->faker->dateTimeBetween('-2 years', '-1 month'),
            'contract_end_date' => $this->faker->dateTimeBetween('+6 months', '+2 years'),
            'notes' => $this->faker->sentence,
            'custom_fields' => [
                'installation_technician' => $this->faker->name,
                'equipment_serial' => $this->faker->bothify('SN-########'),
                'preferred_contact_time' => $this->faker->randomElement(['morning', 'afternoon', 'evening']),
            ],
        ];
    }

    /**
     * Indicate that the customer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the customer is suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
        ]);
    }
}