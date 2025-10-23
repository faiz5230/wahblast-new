<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('receiver_type')->nullable();
            $table->string('number')->nullable();
            $table->string('header')->nullable();
            $table->text('text');
            $table->string('footer')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignUuid('id_device');
            $table->string('delay')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}
