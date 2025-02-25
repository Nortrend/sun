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
        Schema::table('logs', function (Blueprint $table) {
            $table->string('model')->after('id'); // Модель, к которой относится лог
            $table->string('event')->after('model'); // Событие (создание, обновление, удаление и т. д.)
            $table->json('old_data')->nullable()->after('event'); // Данные до изменения
            $table->json('new_data')->nullable()->after('old_data'); // Данные после изменения
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropColumn(['model', 'event', 'old_data', 'new_data']);
        });
    }
};
