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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->enum('selling_type', ['online', 'cash,']);
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->constrained('stores');
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
            $table->text('description')->nullable();
            $table->string('hsn_sac_code')->nullable();
            $table->enum('unit_of_measure', ['kg', 'liter', 'piece', 'meter', 'dozen', 'gram', 'ml']);
            $table->decimal('unit_price', 10, 2);
            $table->enum('tax_type', ['inclusive', 'exclusive']);
            $table->enum('tax_category', ['gst', 'sgst', 'cgst', 'igst']);
            $table->enum('tax_percentage', ['0', '5', '18', '40']);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('quantity_alert', 10, 2)->nullable();
            $table->string('barcode_symbology')->nullable();
            $table->string('barcode')->nullable();
            $table->date('manufactured_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('discount_type')->nullable()->after('item_barcode');
            $table->decimal('discount_value', 8, 2)->nullable()->after('discount_type');
            $table->string('warranties')->nullable();
            $table->string('manufacturer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
