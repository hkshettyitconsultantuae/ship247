<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('quick_request_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->string('origin_name')->nullable();
            $table->string('destination_name')->nullable();
            $table->tinyInteger('route_type')->default(ROUTE_TYPE_SEA);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quick_request_forms');
    }
};
