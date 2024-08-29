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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('email_auth_flag');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('gender')->nullable(); // 性別
            $table->integer('age')->nullable(); // 年齢
            $table->string('url')->nullable(); // URL
            $table->text('profile')->nullable(); // プロフィール
            $table->string('profile_image_url')->nullable(); // プロフィール画像URL
            $table->string('prefecture')->nullable(); // 都道府県
            for ($i = 1; $i <= 10; $i++) {
                $table->unsignedTinyInteger('hobbies_id_' . $i)->nullable(); // 趣味ID (1~10まで)
            }
            for ($i = 1; $i <= 5; $i++) {
                $table->string('gallery_image_url_' . $i)->nullable(); // ギャラリー画像URL (1~5まで)
            }
            $table->boolean('is_deleted')->default(false); // 削除フラグ
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
