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
            //drop  foreign key constract cz role_id use as a foreign key here

            $table->dropForeign(['role_id']);
            //drop existing role id col
            $table->dropColumn('role_id');
            //add role_uuid col
            $table->string('role_uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // add role_id if roll back
            $table->integer('role_id')->nullable();
            
            //Add the foreign key constrain back
            $table->foreign('role_id')->reference('id')->on('roles')-onDelete('cascade');
            $table->dropColumn('role_uuid');


        });
    }
};
