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
            $table->string('uuid', 10)->after('id');
            $table->string('raw_price', 10)->default(0)->after('price');
            $table->string('discount_price', 10)->default(0)->after('raw_price');
            $table->string('discount_code', 20)->nullable()->after('discount_price');
            $table->string('weight', 10)->default(0)->after('discount_code');
            $table->string('count', 5)->default(0)->after('weight');

            $table->dateTime('paid_at')->nullable()->after('pay_tracking');

            $table->string('shipping_name_family', 100)->after('delivery');
            $table->text('shipping_address')->nullable()->after('shipping_name_family');
            $table->string('shipping_mobile', 11)->nullable()->after('shipping_address');
            $table->string('shipping_tell', 11)->nullable()->after('shipping_mobile');
            $table->string('shipping_post_code', 10)->nullable()->after('shipping_tell');

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
                'uuid',
                'raw_price',
                'discount_price',
                'discount_code',
                'weight',
                'count',
                'paid_at',
                'shipping_name_family',
                'shipping_address',
                'shipping_mobile',
                'shipping_tell',
                'shipping_post_code',
            ]);
        });
    }
}
