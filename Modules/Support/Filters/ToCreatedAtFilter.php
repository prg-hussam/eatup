<?php

namespace Modules\Support\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class ToCreatedAtFilter
{
    /**
     * Handle Query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Closure $next;
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(Builder $query, Closure $next): Builder
    {
        return $next($query)->when(
            !empty(request()->to),
            fn ($query) => $query->whereDate(
                'created_at',
                "<=",
                date("Y-m-d", strtotime(request()->to))
            )
        );
    }
}
