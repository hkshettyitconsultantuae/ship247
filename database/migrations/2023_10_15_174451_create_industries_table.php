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
        Schema::create('industries', function (Blueprint $table) {
            $table->id();  // Assuming 'id' is an unsigned big integer
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
        
        // Schema::table('companies', function (Blueprint $table) {
        //     $table->unsignedBigInteger('industry_id')->nullable()->after('country'); // Match data type with 'id' in industries
        //     $table->foreign('industry_id')->references('id')->on('industries');
        // });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
