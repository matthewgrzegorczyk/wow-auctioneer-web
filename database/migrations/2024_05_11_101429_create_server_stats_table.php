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
        Schema::create('server_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('server_name', 50);
            $table->integer('players_online');
            $table->integer('horde_count');
            $table->integer('alliance_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_stats');
    }
};
