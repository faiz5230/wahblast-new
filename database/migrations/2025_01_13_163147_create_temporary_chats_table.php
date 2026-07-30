<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_chats', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('from_name')->nullable();
            $table->text('text');
            $table->integer('status')->nullable();
            $table->foreignUuid('id_device');
            $table->string('type');
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
        Schema::dropIfExists('temporary_chats');
    }
}
