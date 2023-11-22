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
        Schema::create('land_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('locations');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('truck_type_id');
            $table->foreign('truck_type_id')->references('id')->on('truck_types');
            $table->unsignedInteger('axle')->default(0);
            $table->string('container_size');
            $table->unsignedDouble('max_load_in_ton')->default(0);
            $table->unsignedDouble('land_freight')->default(0);
            $table->unsignedInteger('available_trucks')->default(0);
            $table->unsignedDouble('detention_charges_per_hour')->default(0);
            $table->date('valid_till');
            $table->unsignedInteger('tt');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_schedules');
    }
};
