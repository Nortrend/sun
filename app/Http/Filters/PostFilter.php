<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{

    protected array $keys = [
        'title',
        'category_title',
        'views_from',
        'views_to',
        'likes_from',
        'likes_to',
        'published_at_from',
        'published_at_to',
    ];

        protected function title(Builder $builder, $value): void
        {
            $builder->where('title', 'LIKE', "%$value%");
        }

        protected function categoryTitle(Builder $builder, $value): void
        {
            $builder->whereRelation('category',  'title', 'LIKE', "%$value%");
        }

        protected function viewsFrom(Builder $builder, $value): void
        {
            $builder->where('views', '>=', $value);
        }

        protected function viewsTo(Builder $builder, $value): void
        {
            $builder->where('views', '<=', $value);
        }

        protected function likesFrom(Builder $builder, $value): void
        {
            $builder->withCount('likedBy')->having('liked_by_count', '>=', $value);
        }

        protected function likesTo(Builder $builder, $value): void
        {
            $builder->withCount('likedBy')->having('liked_by_count', '<=', $value);
        }

        protected function publishedAtFrom(Builder $builder, $value): void
        {
            $builder->where('published_at', '>=', $value);
        }

        protected function publishedAtTo(Builder $builder, $value): void
        {
            $builder->where('published_at', '<=', $value);
        }
}
