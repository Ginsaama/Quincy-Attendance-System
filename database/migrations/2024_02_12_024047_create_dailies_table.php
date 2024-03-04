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
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchandisers_id'); // Unsigned big integer to match the 'id' column type
            $table->foreign('merchandisers_id')->references('id')->on('merchandisers');
            $table->date('date');
            $table->string('status');
            $table->boolean('excused')->nullable();
            $table->string('offset')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('dailies');
    }
};
