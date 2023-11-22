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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('origin_id');
            $table->foreign('origin_id')->references('id')->on('locations');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->decimal('amount',20,2)->default("0.00");
            $table->string('container_size')->nullable();
            $table->unsignedInteger('no_of_containers')->default(1)->nullable();
            $table->string('product')->nullable();
            $table->string('transportation')->nullable();
            $table->string('shipping_number')->nullable();
            $table->string('receipt_number')->nullable();
            $table->timestamp('arrival_date_time')->nullable();
            $table->timestamp('departure_date_time')->nullable();
            $table->double('pickup_charges')->default(0);
            $table->double('origin_charges')->default(0);
            $table->double('basic_ocean_freight')->default(0);
            $table->double('destination_charges')->default(0);
            $table->double('delivery_charges')->default(0);

            // Add the "is_checked" columns with char datatype and default value 'N'
            $table->char('is_checked_pickup_charges', 1)->default('N');
            $table->char('is_checked_origin_charges', 1)->default('N');
            $table->char('is_checked_basic_ocean_freight', 1)->default('N');
            $table->char('is_checked_destination_charges', 1)->default('N');
            $table->char('is_checked_delivery_charges', 1)->default('N');
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
