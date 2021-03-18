<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factors', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->string('price', 10)->default(0);


            $table->string('pay_trans_id')->nullable();
            $table->string('pay_reference')->nullable();
            $table->string('pay_tracking')->nullable();

            $table->unsignedTinyInteger('status')->default(0); // 0 unpaid, 1 paid

            $table->string('shipping_cost', 10)->default(0);
            $table->unsignedTinyInteger('delivery')->default(0); // 0 in stock, 1 posted, 2 delivered
            $table->string('post_tracking', 50)->nullable();

            $table->string('description')->nullable();
            $table->text('comment')->nullable(); // user comment about the factor

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
        Schema::dropIfExists('factors');
    }
}
