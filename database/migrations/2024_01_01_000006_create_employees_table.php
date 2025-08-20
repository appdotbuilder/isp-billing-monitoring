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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('position');
            $table->string('department')->nullable();
            $table->decimal('salary', 10, 2);
            $table->date('hire_date');
            $table->date('birth_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
            $table->enum('employment_type', ['full_time', 'part_time', 'contract'])->default('full_time');
            $table->json('permissions')->nullable()->comment('Employee permissions and access levels');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('employee_id');
            $table->index('email');
            $table->index('status');
            $table->index('department');
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};