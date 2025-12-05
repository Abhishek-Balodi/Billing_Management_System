<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');                    // sales_details ka id
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->string('hsn_code');
            $table->integer('qty');
            $table->string('unit');
            $table->decimal('price', 15, 2);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->decimal('discount_percent', 8, 2)->default(0);
            $table->decimal('discount_rs', 15, 2)->default(0);
            $table->decimal('gst_percent', 8, 2)->default(0);
            $table->decimal('igst_percent', 8, 2)->default(0);
            $table->decimal('cess_percent', 8, 2)->default(0);
            $table->decimal('cess_rs', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->date('expiry_date')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('sale_id')->references('id')->on('sales_details')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_items');
    }
};