<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountry extends Migration
{
    /**
     * Run the migrations.
     * used source https://github.com/hiiamrohit/Countries-States-Cities-database,
     * https://simplemaps.com/data/ca-cities
     * @return void
     */
    public function up() :void
    {
        Schema::create('country', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 3)->unique();
            $table->string('name', 150)->unique();
        });

        if (env('APP_ENV') !== 'testing') {
            Artisan::call(
                'db:seed',
                [
                    '--class' => 'CountryTableSeeder',
                    '--force' => true
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() :void
    {
        Schema::dropIfExists('country');
    }
}
