<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->unsignedBigInteger('category_id');
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');



            $table->string('title', 70)->unique();
            $table->string('title_en', 70)->unique();
            $table->string('keywords', 70)->nullable();
            $table->string('description')->nullable();
            $table->string('short_text')->nullable();
            $table->text('long_text');
            $table->string('pic', 70)->nullable();
            $table->string('pic_alt', 70)->nullable();

            $table->unsignedTinyInteger('period')->default(5); //minute
            $table->unsignedBigInteger('before')->default(0);
            $table->unsignedBigInteger('after')->default(0);
            $table->unsignedBigInteger('visit')->default(0);
            $table->unsignedInteger('sort')->default(1);
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('articles');
    }
}
