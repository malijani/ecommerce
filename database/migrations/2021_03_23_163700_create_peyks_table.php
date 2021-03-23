<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeyksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peyks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->date('date');
            $table->unsignedTinyInteger('time_start')->default(8);
            $table->unsignedTinyInteger('time_end')->default(16);
            $table->string('count', 4);
            $table->string('weight', 9);
            $table->string('price', 9);
            $table->text('description');
            $table->unsignedInteger('sort')->default(1);

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
        Schema::dropIfExists('peyks');
    }
}
