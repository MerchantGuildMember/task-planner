<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 'user' = normal user, 'admin' = web staff
            $table->string('role')->default('user')->after('email');
            // Flag so fake seeded accounts can be bulk-deleted
            $table->boolean('is_fake')->default(false)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_fake']);
        });
    }
};
