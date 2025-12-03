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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('team_1_id');
            $table->integer('team_2_id');
            $table->integer('team_1_score')->nullable();
            $table->integer('team_2_score')->nullable();
            $table->integer('field');
            $table->string('referee');
            $table->time('start_time');
            $table->string('type');
            $table->integer('tournament_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
