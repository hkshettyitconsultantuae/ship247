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
        Schema::create('pick_and_delivery_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('locations');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('container_size');
            $table->unsignedDouble('price');
            $table->date('valid_till');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickn_delivery_schedules');
    }
};
