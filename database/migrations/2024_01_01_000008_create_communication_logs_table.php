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
        Schema::create('communication_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('channel', ['whatsapp', 'sms', 'email', 'voice'])->default('whatsapp');
            $table->string('recipient');
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->json('metadata')->nullable()->comment('Channel-specific data');
            $table->string('external_id')->nullable()->comment('Third-party service ID');
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('company_id');
            $table->index('customer_id');
            $table->index('channel');
            $table->index('status');
            $table->index('sent_at');
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_logs');
    }
};