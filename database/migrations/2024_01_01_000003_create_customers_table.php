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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('customer_id')->unique(); // Custom customer ID
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active');
            $table->enum('connection_type', ['fiber', 'wireless', 'cable'])->nullable();
            $table->string('service_plan')->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(0);
            $table->date('installation_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable()->comment('Additional customer data');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('customer_id');
            $table->index('status');
            $table->index('email');
            $table->index('phone');
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};