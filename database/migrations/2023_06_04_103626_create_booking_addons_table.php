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
        Schema::create('booking_addons', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('type');
            $table->text('additional_text')->nullable();
            $table->string('default_value')->nullable();
            $table->float('step')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('booking_addons');
    }
};
