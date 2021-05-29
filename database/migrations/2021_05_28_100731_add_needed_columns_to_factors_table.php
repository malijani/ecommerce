<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeededColumnsToFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factors', function (Blueprint $table) {
            $table->string('raw_price', 10)->default(0)->after('price');
            $table->string('discount_price', 10)->default(0)->after('raw_price');
            $table->string('discount_code', 20)->nullable()->after('discount_price');
            $table->string('weight', 10)->default(0)->after('discount_code');
            $table->string('count', 5)->default(0)->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factors', function (Blueprint $table) {
            $table->dropColumn([
                'raw_price',
                'discount_price',
                'discount_code',
                'weight',
                'count'
            ]);
        });
    }
}
