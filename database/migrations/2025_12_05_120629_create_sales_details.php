<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->string('sales_type')->default('Regular'); // Regular, Bill of Supply, Export etc.
            $table->string('challan_no')->nullable();
            $table->date('challan_date')->nullable();
            $table->string('lr_no')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);      // Taxable amount
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);       // Final amount after round off
            $table->decimal('actual_total', 15, 2)->default(0);      // Before round off
            $table->decimal('round_off_amount', 15, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->boolean('reverse_charge')->default(false);
            $table->text('shipping_address');
            $table->string('place_of_supply');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_details');
    }
};