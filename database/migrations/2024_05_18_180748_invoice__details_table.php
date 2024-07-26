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
        Schema::create('invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('product');
            $table->decimal('rate', 8, 2);
            $table->string('unit');
            $table->integer('qty');
            $table->integer('discount');
            $table->decimal('netamount', 8, 2);
            $table->decimal('totalamount', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_detail');
    }
};
