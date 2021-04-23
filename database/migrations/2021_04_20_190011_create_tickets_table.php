<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->unsignedBigInteger('admin_id')->nullable();
            $table->index('admin_id');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('ticket_categories')->onDelete('SET NULL');

            $table->string('uuid', 12); // Generate a 12 character in controller
            $table->string('title', 100);

            $table->text('message');
            $table->string('file', 50)->nullable();

            $table->unsignedTinyInteger('priority'); // 0 : not important, 1 : important, 2 very important
            $table->unsignedTinyInteger('status'); // 0 : open , 1 : answered, 2 : closed

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
        Schema::dropIfExists('tickets');
    }
}
