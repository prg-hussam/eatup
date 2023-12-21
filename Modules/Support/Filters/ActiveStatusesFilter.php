<?php

namespace Modules\Support\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class ActiveStatusesFilter
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
        $request = request();
        return $next($query)->when(
            is_array($request->statuses) && count($request->statuses) > 0,
            function ($query) use ($request) {
                $query->whereIn('is_active', $request->statuses);
            }
        );
    }
}
