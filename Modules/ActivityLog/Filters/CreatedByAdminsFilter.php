<?php

namespace Modules\ActivityLog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Entities\User;

class CreatedByAdminsFilter
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
        return $next($query)->where("causer_type", User::class);
    }
}
