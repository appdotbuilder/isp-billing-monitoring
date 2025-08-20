<?php

namespace Database\Factories;

use App\Models\Billing;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoiceNumber = 'INV-' . $this->faker->unique()->numerify('########');
        $amount = $this->faker->randomFloat(2, 25, 200);
        $taxAmount = $amount * 0.1; // 10% tax
        $totalAmount = $amount + $taxAmount;
        $billingDate = $this->faker->dateTimeBetween('-3 months', 'now');
        
        return [
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
            'invoice_number' => $invoiceNumber,
            'billing_date' => $billingDate,
            'due_date' => $billingDate->modify('+30 days'),
            'amount' => $amount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'status' => $this->faker->randomElement(['pending', 'paid', 'overdue', 'cancelled']),
            'payment_method' => $this->faker->randomElement(['cash', 'bank_transfer', 'credit_card', 'mobile_payment']),
            'paid_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween($billingDate, 'now') : null,
            'description' => 'Monthly internet service',
            'line_items' => [
                [
                    'description' => 'Internet Service - Monthly Plan',
                    'quantity' => 1,
                    'unit_price' => $amount,
                    'total' => $amount,
                ],
                [
                    'description' => 'Service Tax (10%)',
                    'quantity' => 1,
                    'unit_price' => $taxAmount,
                    'total' => $taxAmount,
                ],
            ],
        ];
    }

    /**
     * Indicate that the billing is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the billing is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
            'paid_at' => null,
        ]);
    }
}