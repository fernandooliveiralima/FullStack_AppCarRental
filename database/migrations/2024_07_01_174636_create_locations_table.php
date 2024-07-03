<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('costumer_id');
            $table->unsignedBigInteger('car_id');
            $table->dateTime('date_start_period');
            $table->dateTime('date_end_period');
            $table->dateTime('end_date_realized_period');
            $table->float('daily_value', 8,2);
            $table->integer('km_start');
            $table->integer('km_end');
            $table->timestamps();
    
            //foreign key (constraints)
            $table->foreign('costumer_id')->references('id')->on('costumers');
            $table->foreign('car_id')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
