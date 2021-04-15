<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->string('title', 100);
            $table->string('menu_title', 20);
            $table->string('title_en', 70)->unique();
            $table->mediumText('content');

            $table->string('keywords', 70);
            $table->string('description');

            $table->unsignedBigInteger('visit')->default(0); // total visit of the page
            $table->unsignedTinyInteger('menu')->default(0); // 0 : hide, 1 : show
            $table->unsignedTinyInteger('status')->default(0); // 0 : don't publish, 1 : publish
            $table->unsignedTinyInteger('sort')->default(1);


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
        Schema::dropIfExists('pages');
    }
}
