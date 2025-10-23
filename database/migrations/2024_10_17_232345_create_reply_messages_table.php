<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bot_id');
            $table->foreign('bot_id')->references('id')->on('auto_replies')->onDelete('cascade');
            $table->unsignedBigInteger('incoming_message_id');
            $table->foreign('incoming_message_id')->references('id')->on('incoming_messages')->onDelete('cascade');
            $table->string('type');
            $table->string('message');
            $table->string('url_file')->nullable();
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
        Schema::dropIfExists('reply_messages');
    }
}
