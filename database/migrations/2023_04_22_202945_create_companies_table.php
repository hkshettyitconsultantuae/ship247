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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('contact_no');
            $table->string('country');
            $table->string('city');
            $table->string('website')->nullable();
            $table->string('business_type');
            $table->string('description')->nullable();
            $table->string('industry')->nullable();
            $table->tinyInteger('is_activated')->default(0);
            $table->string('status')->nullable();
            $table->text('message')->nullable();
            $table->softDeletes();
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
