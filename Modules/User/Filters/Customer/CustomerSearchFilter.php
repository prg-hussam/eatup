<?php

namespace Modules\User\Filters\Customer;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class CustomerSearchFilter
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

        return $next($query)->when($request->search, function ($query) use ($request) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                ->orWhere('phone', 'LIKE', "%+966{$request->search}%");
        });
    }
}