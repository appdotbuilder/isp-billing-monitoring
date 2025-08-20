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
        Schema::create('scheduled_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // billing, messaging, suspension, monitoring
            $table->string('frequency'); // daily, weekly, monthly, custom
            $table->string('cron_expression')->nullable();
            $table->timestamp('next_run')->nullable();
            $table->timestamp('last_run')->nullable();
            $table->enum('status', ['active', 'inactive', 'running'])->default('active');
            $table->json('parameters')->nullable()->comment('Task-specific parameters');
            $table->json('results')->nullable()->comment('Last execution results');
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('type');
            $table->index('status');
            $table->index('next_run');
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_tasks');
    }
};