<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ArticleFilter extends AbstractFilter
{
    protected array $keys = [
        'title',
        'category_title',
        'profile_name',
        'published_at_from',
        'published_at_to',
    ];

    protected function title(Builder $builder, $value): void
    {
        $builder->where('title', 'LIKE', "%$value%");
    }

    protected function categoryTitle(Builder $builder, $value): void
    {
        $builder->whereRelation('category', 'title', 'LIKE', "%$value%");
    }

    protected function profileName(Builder $builder, $value): void
    {
        $builder->whereRelation('profile', 'name', 'LIKE', "%$value%");
    }

    protected function publishedAtFrom(Builder $builder, $value): void
    {
        $builder->whereDate('created_at', '>=', $value);
    }

    protected function publishedAtTo(Builder $builder, $value): void
    {
        $builder->whereDate('created_at', '<=', $value);
    }
}
