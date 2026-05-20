<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('topic');
            $table->json('structure');
            $table->string('share_token', 64)->unique()->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->string('ai_model')->nullable();
            $table->float('ai_temperature')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
