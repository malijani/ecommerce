<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('brand_id');
            $table->index('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('title', 100)->unique();
            $table->string('title_en', 100)->unique();

            $table->string('short_text')->nullable();
            $table->mediumText('long_text')->nullable();

            $table->unsignedTinyInteger('origin')->default(1); // 1 original - 2 second class - 3 third class
            $table->unsignedTinyInteger('deliver')->default(1); // 0 express delivery - 1 long time delivery
            $table->unsignedTinyInteger('warranty')->default(1); // 0 without warranty - 1 with warranty
            $table->unsignedTinyInteger('price_type')->default(1); // 0 discount price - 1 definitive price - 2 ask price
            $table->unsignedBigInteger('price'); // toman
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->unsignedBigInteger('price_self_buy'); // toman
            $table->unsignedSmallInteger('entity')->default(1);

            $table->string('keywords',70)->nullable();
            $table->string('description', 70)->nullable();
            $table->string('color', 8)->nullable();
            $table->unsignedBigInteger('visit')->default(0);
            $table->unsignedInteger('sort')->default(1);
            $table->unsignedTinyInteger('status')->default(1); // 0 deactive - 1 active - 2 no entity

            $table->unsignedBigInteger('before')->nullable();
            $table->unsignedBigInteger('after')->nullable();


            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
