<?php

namespace App\Traits\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder, array $data): Builder
    {

        $ClassName = 'App\\Http\\Filters\\' . class_basename($this) . 'Filter';
        // Проверяем, что `scopeFilter()` вызывается и передаёт правильные данные
//        dd('scopeFilter called', $data); // Проверяем, вызывается ли фильтрация

        $filter = new $ClassName();

        return $filter->apply($data, $builder);

    }
}
