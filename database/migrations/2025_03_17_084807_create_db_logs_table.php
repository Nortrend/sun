<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('db_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable(); // Имя пользователя (если нужно)
            $table->integer('insert_count')->default(0);
            $table->integer('select_count')->default(0);
            $table->integer('update_count')->default(0);
            $table->integer('delete_count')->default(0);
            $table->text('sql')->nullable(); // SQL-запрос
            $table->enum('status', ['success', 'error'])->default('success');
            $table->timestamp('time')->useCurrent(); // Время выполнения
            $table->timestamps(); // Добавляем created_at и updated_at
            $table->text('message')->nullable(); // Сообщение об ошибке или успехе
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('db_logs');
    }
};

