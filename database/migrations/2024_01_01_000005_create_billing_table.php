<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->date('billing_date');
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'mobile_payment'])->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('description')->nullable();
            $table->json('line_items')->nullable()->comment('Billing details and services');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('customer_id');
            $table->index('invoice_number');
            $table->index('status');
            $table->index('billing_date');
            $table->index('due_date');
            $table->index(['company_id', 'status']);
            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};