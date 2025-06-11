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
        Schema::create('RoboRoadNodes', function (Blueprint $table) {
            $table->uuid('NodeID')->primary()->default(DB::raw('(UUID())'))->unique();
            $table->string('NodeName')->unique();
            $table->string('NodeAddress')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('RoboRoadNodes');
    }
};
