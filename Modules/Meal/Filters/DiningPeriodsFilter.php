<?php

namespace Modules\Meal\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class DiningPeriodsFilter
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
            is_array($request->diningPeriods) && count($request->diningPeriods) > 0,
            function ($query) use ($request) {
                $query->whereHas('diningPeriods', function ($query) use ($request) {
                    $query->whereIn('id', $request->diningPeriods);
                });
            }
        );
    }
}