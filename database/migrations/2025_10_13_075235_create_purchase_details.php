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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->enum('status', ['pending', 'complete', 'cancelled'])->default('pending');
            $table->enum('purchase_type', ['Regular', 'Bill of Supply', 'Export'])->default('Regular');
            $table->string('challan_no')->nullable();
            $table->date('challan_date')->nullable();
            $table->string('lr_no')->nullable();
            $table->date('entry_date')->nullable();
            $table->enum('delivery_mode', ['Transport', 'Direct Delivery', 'Courier', 'Self'])->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('grand_total', 10, 2);
            $table->text('remarks')->nullable();
            $table->boolean('reverse_charge')->default(false);
            $table->string('shipping_address');
            $table->string('place_of_supply');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
