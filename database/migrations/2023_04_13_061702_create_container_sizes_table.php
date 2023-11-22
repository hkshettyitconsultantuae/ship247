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
        Schema::create('container_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('display_label')->nullable();
            $table->text('value')->nullable();
            $table->string('hapag_value')->nullable();
            $table->string('msc_value')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_sizes');
    }
};
