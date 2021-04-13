<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_navs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->string('title', 70);
            $table->string('link', 100);
            $table->unsignedTinyInteger('status')->default(0); // 0 : hide, 1 : show
            $table->unsignedInteger('sort')->default(1);
            $table->unsignedTinyInteger('screen')->default(1); // 0 : small screen, 1 : medium screen or bigger


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
        Schema::dropIfExists('top_navs');
    }
}
