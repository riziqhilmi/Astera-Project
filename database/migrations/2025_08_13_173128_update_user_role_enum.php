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
        // First, change the column type to string temporarily
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
        
        // Update existing user_input records to user
        DB::table('users')->where('role', 'user_input')->update(['role' => 'user']);
        
        // Now change back to enum with new values
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user', 'user_operasional'])->default('user')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, change the column type to string temporarily
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user_input')->change();
        });
        
        // Update existing user records back to user_input
        DB::table('users')->where('role', 'user')->update(['role' => 'user_input']);
        
        // Now change back to enum with original values
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user_input', 'user_operasional'])->default('user_input')->change();
        });
    }
};
