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
        Schema::create('network_infrastructure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['odc', 'odp', 'pole', 'cabinet']); // ODC, ODP, etc.
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('address')->nullable();
            $table->integer('capacity')->nullable()->comment('Maximum connections');
            $table->integer('used_capacity')->default(0)->comment('Current connections');
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->foreignId('parent_device_id')->nullable()->constrained('devices')->onDelete('set null');
            $table->text('description')->nullable();
            $table->json('specifications')->nullable()->comment('Technical specifications');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('type');
            $table->index('status');
            $table->index(['latitude', 'longitude']);
            $table->index(['company_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_infrastructure');
    }
};