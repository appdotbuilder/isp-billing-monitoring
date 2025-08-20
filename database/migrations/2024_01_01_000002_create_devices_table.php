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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // router, olt, tr069, ssh, snmp
            $table->string('brand')->nullable(); // mikrotik, genieacs, etc.
            $table->string('model')->nullable();
            $table->string('ip_address');
            $table->integer('port')->default(22);
            $table->string('username')->nullable();
            $table->string('password')->nullable(); // Should be encrypted
            $table->string('community_string')->nullable(); // For SNMP
            $table->enum('status', ['online', 'offline', 'maintenance'])->default('offline');
            $table->timestamp('last_seen')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('description')->nullable();
            $table->json('monitoring_config')->nullable()->comment('Device-specific monitoring settings');
            $table->json('last_metrics')->nullable()->comment('Latest monitoring data');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('type');
            $table->index('status');
            $table->index('ip_address');
            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};