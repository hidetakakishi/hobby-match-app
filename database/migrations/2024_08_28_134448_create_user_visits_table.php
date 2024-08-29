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
        Schema::create('user_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_user_id'); // 足跡をつけたユーザーID
            $table->unsignedBigInteger('visited_user_id'); // 足跡をつけられたユーザーID
            $table->timestamps(); // 作成日時および更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_visits');
    }
};
