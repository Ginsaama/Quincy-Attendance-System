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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // Foreign key
            $table->unsignedBigInteger('merchandisers_id'); // Unsigned big integer to match the 'id' column type
            $table->foreign('merchandisers_id')->references('id')->on('merchandisers');
            // Tables
            $table->boolean('monday')->default(false);
            $table->time('monday_in')->nullable();
            $table->time('monday_out')->nullable();
            $table->boolean('tuesday')->default(false);
            $table->time('tuesday_in')->nullable();
            $table->time('tuesday_out')->nullable();
            $table->boolean('wednesday')->default(false);
            $table->time('wednesday_in')->nullable();
            $table->time('wednesday_out')->nullable();
            $table->boolean('thursday')->default(false);
            $table->time('thursday_in')->nullable();
            $table->time('thursday_out')->nullable();
            $table->boolean('friday')->default(false);
            $table->time('friday_in')->nullable();
            $table->time('friday_out')->nullable();
            $table->boolean('saturday')->default(false);
            $table->time('saturday_in')->nullable();
            $table->time('saturday_out')->nullable();
            $table->boolean('sunday')->default(false);
            $table->time('sunday_in')->nullable();
            $table->time('sunday_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
