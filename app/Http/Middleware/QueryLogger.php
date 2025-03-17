<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DbLog;
use App\Models\DbQuery;

class QueryLogger
{
    public function handle(Request $request, Closure $next)
    {
        DB::enableQueryLog();
        $response = $next($request);
        $queries = DB::getQueryLog();

        $insertCount = $selectCount = $updateCount = $deleteCount = 0;
        $sqlQueries = [];

        foreach ($queries as $query) {
            $sql = $query['query'];
            $firstWord = strtoupper(strtok($sql, ' '));

            match ($firstWord) {
                'INSERT' => $insertCount++,
                'SELECT' => $selectCount++,
                'UPDATE' => $updateCount++,
                'DELETE' => $deleteCount++,
                default => null
            };

            $sqlQueries[] = $sql;
        }

        // Создаем запись в `db_logs`
        $log = DbLog::create([
            'user' => Auth::check() ? Auth::user()->name : 'guest',
            'insert_count' => $insertCount,
            'select_count' => $selectCount,
            'update_count' => $updateCount,
            'delete_count' => $deleteCount,
            'status' => $response->status() >= 400 ? 'error' : 'success',
            'message' => $response->status() >= 400 ? 'Ошибка в запросе' : 'Запрос выполнен успешно',
        ]);

        // Сохраняем все SQL-запросы отдельно в `db_queries`
        foreach ($sqlQueries as $sql) {
            DbQuery::create([
                'db_log_id' => $log->id,
                'sql' => $sql,
            ]);
        }

        return $response;
    }
}
