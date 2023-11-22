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
        Schema::create('sea_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('locations');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('container_size');
            $table->unsignedDouble('pickup_charges')->default(0);
            $table->unsignedDouble('origin_charges')->default(0);
            $table->unsignedTinyInteger('origin_charges_included')->default(0);
            $table->unsignedDouble('ocean_freight')->default(0);
            $table->unsignedDouble('destination_charges')->default(0);
            $table->unsignedTinyInteger('destination_charges_included')->default(0);
            $table->unsignedDouble('delivery_charges')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sea_schedules');
    }
};
