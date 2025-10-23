<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUsersAndDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('status')->default(false)->nullable();
            $table->string('status_account')->nullable();
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->integer('limit_send_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_account');
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('limit_send_message');
        });
    }
}
