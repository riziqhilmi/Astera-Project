<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite compatibility, we'll use string instead of enum
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user_input')->change();
        });
        
        // Update existing user records to user_input
        DB::table('users')->where('role', 'user')->update(['role' => 'user_input']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update existing user_input records back to user
        DB::table('users')->where('role', 'user_input')->update(['role' => 'user']);
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }
};
