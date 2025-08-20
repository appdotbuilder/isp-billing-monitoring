<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $employeeId = 'EMP-' . $this->faker->unique()->numerify('####');
        
        $positions = [
            'Network Technician',
            'Field Engineer',
            'Customer Support',
            'Sales Representative',
            'Network Administrator',
            'IT Manager',
            'Billing Specialist',
            'Installation Technician',
        ];
        
        $departments = [
            'Technical',
            'Customer Service',
            'Sales',
            'Administration',
            'Field Operations',
            'IT',
            'Finance',
        ];
        
        return [
            'company_id' => Company::factory(),
            'employee_id' => $employeeId,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'position' => $this->faker->randomElement($positions),
            'department' => $this->faker->randomElement($departments),
            'salary' => $this->faker->randomFloat(2, 800, 5000),
            'hire_date' => $this->faker->dateTimeBetween('-3 years', '-1 month'),
            'birth_date' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'terminated']),
            'employment_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'permissions' => [
                'device_monitoring' => $this->faker->boolean(70),
                'customer_management' => $this->faker->boolean(60),
                'billing_access' => $this->faker->boolean(40),
                'reporting' => $this->faker->boolean(50),
            ],
            'notes' => $this->faker->sentence,
        ];
    }

    /**
     * Indicate that the employee is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the employee is a manager.
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => 'Manager',
            'salary' => $this->faker->randomFloat(2, 3000, 8000),
            'permissions' => [
                'device_monitoring' => true,
                'customer_management' => true,
                'billing_access' => true,
                'reporting' => true,
                'employee_management' => true,
            ],
        ]);
    }
}