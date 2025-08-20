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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->enum('role', ['super_admin', 'admin', 'manager', 'technician', 'user'])->default('user')->after('email');
            $table->json('permissions')->nullable()->after('role')->comment('User-specific permissions');
            $table->boolean('is_active')->default(true)->after('permissions');
            
            // Indexes
            $table->index('company_id');
            $table->index('role');
            $table->index(['company_id', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropIndex(['company_id']);
            $table->dropIndex(['role']);
            $table->dropIndex(['company_id', 'role']);
            $table->dropColumn(['company_id', 'role', 'permissions', 'is_active']);
        });
    }
};