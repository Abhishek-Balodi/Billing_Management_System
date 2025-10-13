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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->string('hsn_code');
            $table->integer('qty');
            $table->string('unit');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->decimal('discount', 5, 2)->default(0.00);
            $table->decimal('tax_percent', 5, 2)->default(0.00);
            $table->decimal('igst_percent', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            $table->foreign('purchase_id')->references('id')->on('purchase_details')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
