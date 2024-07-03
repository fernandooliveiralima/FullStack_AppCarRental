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
        
        Schema::create('model_cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->string('model_name', 30);
            $table->string('model_image', 100);
            $table->integer('number_doors');
            $table->integer('places');
            $table->boolean('air_bag');
            $table->boolean('abs');
            $table->timestamps();
    
            //foreign key (constraints)
            $table->foreign('brand_id')->references('id')->on('brands');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_cars');
    }
};
