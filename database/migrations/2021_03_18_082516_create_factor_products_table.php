<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('factor_id');
            $table->index('factor_id');
            $table->foreign('factor_id')->references('id')->on('factors')->onDelete('cascade');

            $table->unsignedBigInteger('product_id');
            $table->index('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedTinyInteger('price_type')->default(1); // 0 discount price - 1 definitive price
            $table->string('price', 10)->default(0);
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->unsignedTinyInteger('count')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factor_products');
    }
}
