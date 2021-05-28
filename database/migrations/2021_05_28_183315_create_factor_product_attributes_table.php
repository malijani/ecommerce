<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_product_attributes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('factor_product_id');
            $table->foreign('factor_product_id')
                ->references('id')
                ->on('factor_products');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->string('attribute', 200)->nullable();
            $table->string('count', 5)->nullable();

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
        Schema::dropIfExists('factor_product_attributes');
    }
}
