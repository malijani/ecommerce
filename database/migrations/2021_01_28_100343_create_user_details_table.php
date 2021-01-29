<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->string('national_code', 10)->nullable();
            $table->string('avatar', 15)->nullable();
            $table->boolean('avatar_flag')->default(false);
            $table->boolean('news_receive')->default(false);
            $table->enum('sex', ['m', 'f'])->nullable(); // 1 Male , 0 Female , 2 Unknown
            $table->string('bill', 20)->nullable();
            $table->string('bill_cart', 20)->nullable();
            $table->string('birthday', 15)->nullable();
            $table->boolean('status')->default(false);


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
        Schema::dropIfExists('user_details');
    }
}
