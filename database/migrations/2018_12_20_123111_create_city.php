<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() :void
    {
        Schema::create('city', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->decimal('lat', 7, 4);
            $table->decimal('lng', 7, 4);
            $table->integer('state_id');
            $table->foreign('state_id')->references('id')->on('state')->onDelete('cascade')->onUpdate('cascade');
        });

        Artisan::call(
            'db:seed',
            [
                '--class' => 'CityTableSeeder',
                '--force' => true
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() :void
    {
        Schema::dropIfExists('city');
    }
}
