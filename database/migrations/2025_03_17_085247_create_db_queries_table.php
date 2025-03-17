<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('db_queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('db_log_id')->constrained()->onDelete('cascade'); // Связь с DbLog
            $table->text('sql'); // Сам SQL-запрос
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('db_queries');
    }
};

