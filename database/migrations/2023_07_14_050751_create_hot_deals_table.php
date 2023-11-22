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
        Schema::create('hot_deals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('locations');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('container_size');
            $table->dateTime('eta');
            $table->dateTime('etd');
            $table->dateTime('valid_till')->nullable();
            $table->unsignedInteger('tt');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('amount');
            $table->tinyInteger('route_type')->default(ROUTE_TYPE_SEA);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('hot_deals');
    }
};
