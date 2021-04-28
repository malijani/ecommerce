<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->string('title', 70);
            $table->string('title_en', 70);
            $table->unsignedTinyInteger('status')->default(0);

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
        Schema::dropIfExists('footer_items');
    }
}
