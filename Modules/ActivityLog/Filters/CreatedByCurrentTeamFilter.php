<?php

namespace Modules\ActivityLog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Entities\Customer;

class CreatedByCurrentTeamFilter
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
        return $next($query)
            ->where("causer_type", Customer::class)
            ->where('properties->team_id', auth('customer')->user()->currentTeam->id);
    }
}
