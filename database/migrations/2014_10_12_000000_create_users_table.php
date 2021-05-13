<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50);
            $table->string('mobile',11)->unique();

            /*CHANGED IN LAZY_USER MIGRATION*/
            $table->string('family', 50); // deleted
            $table->string('email', 70)->unique(); // nullable, not unique

            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedTinyInteger('level')->default(0); // 121 admin - 0 user
            $table->boolean('status')->default(true);
            $table->string('password');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
