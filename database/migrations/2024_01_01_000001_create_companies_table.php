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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->enum('type', ['parent', 'tenant'])->default('tenant');
            $table->foreignId('parent_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable()->comment('Company-specific settings');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('type');
            $table->index('parent_id');
            $table->index('is_active');
            $table->index(['type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};