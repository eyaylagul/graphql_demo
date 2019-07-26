<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() :void
    {
        Schema::create('property_media', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->comment('where store file');
            $table->string('description')->nullable();
            $table->integer('position')->comment('needs to detect in which order show files');
            $table->boolean('is_primary')->default(0)->comment('when true is main property file');
            $table->boolean('is_local')->default(0)->comment('file locally or external: http://');
            $table->enum('type', ['IMG', 'VIDEO']);
            $table->integer('property_id');
            $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() :void
    {
        Schema::dropIfExists('property_media');
    }
}
