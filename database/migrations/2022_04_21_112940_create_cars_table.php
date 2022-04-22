<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id')->constrained();
            $table->foreignId('vehicle_type_id')->constrained();
            $table->foreignId('colour_id')->constrained();
            $table->string('registration');
            $table->string('range');
            $table->string('model');
            $table->string('derivative');
            $table->integer('price');
            $table->integer('mileage');
            $table->string('images');
            $table->boolean('active');
            $table->date('date_on_forecourt')->nullable();
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
        Schema::dropIfExists('cars');
    }
};
