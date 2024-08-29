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
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rater_user_id'); // 評価したユーザーID
            $table->unsignedBigInteger('rated_user_id'); // 評価されたユーザーID
            $table->boolean('is_positive')->default(false); // 高評価
            $table->boolean('is_negative')->default(false); // 低評価
            $table->timestamps();

            // 重複評価を防ぐための複合ユニークインデックス
            $table->unique(['rater_user_id', 'rated_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ratings');
    }
};
