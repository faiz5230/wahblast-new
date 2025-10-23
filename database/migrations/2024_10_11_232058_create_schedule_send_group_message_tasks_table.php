<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleSendGroupMessageTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_send_group_message_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->text('text');
            $table->boolean('status')->default(false);
            $table->foreignUuid('id_device');
            $table->string('schedule_date');
            $table->string('schedule_time');
            $table->string('type');
            $table->string('url_file')->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('schedule_send_group_message_tasks');
    }
}
