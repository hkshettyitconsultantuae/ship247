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
        Schema::create('sea_schedule_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sea_schedule_id');
            $table->foreign('sea_schedule_id')->references('id')->on('sea_schedules');
            $table->dateTime('eta');
            $table->dateTime('etd');
            $table->date('valid_till');
            $table->unsignedInteger('tt');
            $table->unsignedInteger('ft');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sea_schedule_details');
    }
};
