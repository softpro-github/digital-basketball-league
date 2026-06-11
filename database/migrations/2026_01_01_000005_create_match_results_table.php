<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_match_id')->constrained()->cascadeOnDelete();
            $table->integer('home_q1')->default(0);
            $table->integer('home_q2')->default(0);
            $table->integer('home_q3')->default(0);
            $table->integer('home_q4')->default(0);
            $table->integer('away_q1')->default(0);
            $table->integer('away_q2')->default(0);
            $table->integer('away_q3')->default(0);
            $table->integer('away_q4')->default(0);
            $table->integer('home_total')->storedAs('home_q1 + home_q2 + home_q3 + home_q4');
            $table->integer('away_total')->storedAs('away_q1 + away_q2 + away_q3 + away_q4');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_results');
    }
};
