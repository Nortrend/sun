<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DbLog;
use App\Models\DbQuery;

class QueryTester extends Command
{
    protected $signature = 'query:test';
    protected $description = 'Выполняет тестовые SELECT, INSERT, UPDATE запросы и логирует ошибки';

    public function handle()
    {
        DB::enableQueryLog();

        try {
            $queries = [];

            // SELECT posts
            try {
                $queries[] = DB::table('posts')
                    ->join('profiles', 'posts.profile_id', '=', 'profiles.id')
                    ->join('categories', 'posts.category_id', '=', 'categories.id')
                    ->select('posts.title', 'profiles.name as author', 'categories.title as category', 'posts.published_at')
                    ->get();
            } catch (\Exception $e) {
                $this->logError('Ошибка в SELECT posts', $e);
            }

            // SELECT articles
            try {
                $queries[] = DB::table('articles')
                    ->join('profiles', 'articles.profile_id', '=', 'profiles.id')
                    ->join('categories', 'articles.category_id', '=', 'categories.id')
                    ->select('articles.title', 'profiles.name as author', 'categories.title as category', 'articles.created_at')
                    ->get();
            } catch (\Exception $e) {
                $this->logError('Ошибка в SELECT articles', $e);
            }

            // INSERT в posts
            try {
                DB::table('posts')->insert([
                    'title' => 'Новый пост',
                    'content' => 'Тестовое содержимое',
                    'profile_id' => 1, // Убедись, что ID профиля существует
                    'category_id' => 3, // Убедись, что ID категории существует
                    'is_published' => true,
                    'views' => 0,
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                $this->logError('Ошибка в INSERT posts', $e);
            }

            // INSERT в posts
            try {
                DB::table('articles')->insert([
                    'title' => 'new article',
                    'content' => 'Тестовое содержимое',
                    'profile_id' => 1, // Убедись, что ID профиля существует
                    'category_id' => 3, // Убедись, что ID категории существует
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                $this->logError('Ошибка в INSERT articles', $e);
            }

            // UPDATE views в posts
            try {
                DB::table('posts')
                    ->where('id', 1) // Убедись, что пост с таким ID существует
                    ->update(['views' => DB::raw('views + 1')]);
            } catch (\Exception $e) {
                $this->logError('Ошибка в UPDATE posts', $e);
            }

            // Битый SQL (специально вызовет ошибку)
            try {
                DB::select('SELECT FROM non_existing_table'); // Ошибочный SQL
            } catch (\Exception $e) {
                $this->logError('Ошибка в битом SQL-запросе', $e);
            }

            $executedQueries = DB::getQueryLog();

            $queryCounts = array_reduce($executedQueries, function ($counts, $query) {
                $sql = strtoupper($query['query']);
                if (str_starts_with($sql, 'INSERT')) {
                    $counts['insert']++;
                } elseif (str_starts_with($sql, 'SELECT')) {
                    $counts['select']++;
                } elseif (str_starts_with($sql, 'UPDATE')) {
                    $counts['update']++;
                } elseif (str_starts_with($sql, 'DELETE')) {
                    $counts['delete']++;
                }
                return $counts;
            }, ['insert' => 0, 'select' => 0, 'update' => 0, 'delete' => 0]);

            // Логируем успешные запросы
            $log = DbLog::create([
                'user' => Auth::check() ? Auth::user()->name : 'console',
                'insert_count' => $queryCounts['insert'],
                'select_count' => $queryCounts['select'],
                'update_count' => $queryCounts['update'],
                'delete_count' => $queryCounts['delete'],
                'status' => 'success',
                'message' => 'Команда выполнена успешно',
            ]);

            // Записываем все SQL-запросы в `db_queries`
            foreach ($executedQueries as $query) {
                DbQuery::create([
                    'db_log_id' => $log->id,
                    'sql' => $query['query'],
                ]);
            }

            $this->info("Запросы выполнены и записаны в логи. Всего запросов: " . count($executedQueries) . ", SELECT: {$queryCounts['select']}, INSERT: {$queryCounts['insert']}, UPDATE: {$queryCounts['update']}, DELETE: {$queryCounts['delete']}");

        } finally {
            DB::disableQueryLog();
        }
    }

    private function logError($message, $exception)
    {
        $this->error($message . ': ' . $exception->getMessage());

        DbLog::create([
            'user' => Auth::check() ? Auth::user()->name : 'console',
            'insert_count' => 0,
            'select_count' => 0,
            'update_count' => 0,
            'delete_count' => 0,
            'status' => 'error',
            'message' => $message . ' - ' . $exception->getMessage(),
        ]);
    }
}
