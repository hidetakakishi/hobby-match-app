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
        Schema::create('favorite_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // お気に入りしたユーザーID
            $table->unsignedBigInteger('favorited_user_id'); // お気に入りされたユーザーID
            $table->timestamps(); // 作成日時および更新日時

            // 重複したお気に入り登録を防ぐためのユニーク制約
            $table->unique(['user_id', 'favorited_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_users');
    }
};
