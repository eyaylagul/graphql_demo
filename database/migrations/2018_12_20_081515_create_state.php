<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() :void
    {
        Schema::create('state', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->nullable();
            $table->string('name', 30)->unique();
            $table->integer('country_id');
            $table->foreign('country_id')->references('id')->on('country')->onDelete('cascade')->onUpdate('cascade');
        });

        Artisan::call(
            'db:seed',
            [
                '--class' => 'StateTableSeeder',
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
        Schema::dropIfExists('state');
    }
}
