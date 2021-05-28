<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeededColumnsToFactorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factor_products', function (Blueprint $table) {
            $table->string('weight')->nullable()->after('price');
            $table->string('discount_price')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factor_products', function (Blueprint $table) {
            $table->dropColumn(['weight', 'discount_price']);
        });
    }
}
