<?php

namespace Modules\User\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class RoleSearchFilter
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
            !empty($request->search),
            function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhereLikeTranslation("display_name", $request->search);
            }
        );
    }
}
