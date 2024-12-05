<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName'); //for the love of god, use camelCase
            $table->string('userName')->unique();
            $table->integer('number')->unique();
            $table->boolean('admin');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('logo');
            $table->string('location');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->json('cart')->nullable();
            $table->timestamps();//for some reason, users can sign up on the same username, even though it's unique. We have to solve that
            //nevermind, im an idiot, we wrote Unique instead of unique in front of userName
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
