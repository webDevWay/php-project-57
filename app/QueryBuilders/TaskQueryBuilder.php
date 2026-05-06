<?php

namespace App\QueryBuilders;

use App\Models\Task;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

final class TaskQueryBuilder
{
    public static function build(): QueryBuilder
    {
        return QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            )
            ->defaultSort('-id')
            ->allowedSorts('id', 'name', 'created_at');
    }
}