<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() :void
    {
        Schema::create('property', static function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['AVAILABLE', 'RENTED', 'EXPIRED', 'DISABLED', 'MODERATING', 'PAYMENT_PENDING'])
                ->comment('available - is visible in the system. disabled - by admin, owner or editor.
                                      moderating - user publish adv. editor should check it
                                      payment_pending - user publish and maybe moderator check but waiting payment');
            // dates
            $table->date('expire_at')->nullable()->comment('when property will be expired');
            // todo create worker to check field and change status to expired
            $table->date('available_at')->nullable()->comment('when customer can move in');
            $table->timestamps();

            $table->string('title');
            $table->text('description');
            $table->integer('price')->nullable();
            $table->integer('price_max')->nullable();
            $table->string('address');
            $table->string('postcode');
            $table->integer('square_feet')->nullable();
            $table->boolean('pets')->default(0);
            $table->unsignedTinyInteger('bedrooms');
            $table->decimal('bathrooms', 2, 1);
            $table->decimal('lat', 7, 4);
            $table->decimal('lng', 7, 4);

            $table->integer('property_type_id');
            $table->foreign('property_type_id')->references('id')->on('property_type')->onDelete('restrict')->onUpdate('cascade');

            $table->integer('city_id');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade')->onUpdate('cascade');

            $table->json('features')->nullable();
            $table->json('initiator')->nullable();

            /* neightbourhood */
            /* todo feature position */

            // todo extend user table add type user, like company, datafeed
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
//            $table->integer('account_type_id');
//            $table->foreign('account_type_id')->references('id')->on('account_type')->onDelete('cascade')->onUpdate('cascade');

//            $table->json('phone')->nullable();
//            $table->json('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() :void
    {
        Schema::dropIfExists('property');
    }
}
