<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->unsignedBigInteger('parent_id')->default(0);

            $table->string('title', 70)->unique();
            $table->string('title_en', 70)->unique();

            $table->text('text')->nullable();
            $table->string('pic', 70)->nullable();
            $table->string('pic_alt', 70)->nullable();
            $table->string('color', 10)->nullable();
            $table->string('keywords', 70)->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('sort')->default(1);
            $table->boolean('status')->default(true);
            $table->boolean('menu')->default(false);

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
        Schema::dropIfExists('categories');
    }
}
