<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpErrorCodeAndMessageColumnsToFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factors', function (Blueprint $table) {
            $table->ipAddress('user_ip')->nullable()->after('status');
            $table->string('error_code', 5)->nullable()->after('user_ip');
            $table->string('error_message')->nullable()->after('error_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factors', function (Blueprint $table) {
            $table->dropColumn(['user_ip', 'error_code', 'error_message']);
        });
    }
}
