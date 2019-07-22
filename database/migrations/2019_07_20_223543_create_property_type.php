<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() :void
    {
        Schema::create('property_type', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->text('description');
        });

        if (env('APP_ENV') !== 'testing') {
            Artisan::call(
                'db:seed',
                [
                    '--class' => 'PropertyTypeTableSeeder',
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
        Schema::dropIfExists('property_type');
    }
}
