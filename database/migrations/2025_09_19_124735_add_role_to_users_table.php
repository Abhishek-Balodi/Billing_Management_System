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
            // Add a 'role_id' column to the 'users' table

            $table->unsignedBigInteger('role_id')->nullable();

            //add foreign key constraint if want to link with other table

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // remove role_id if rollback the migration
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
