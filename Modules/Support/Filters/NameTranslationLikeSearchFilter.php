<?php

namespace Modules\Support\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class NameTranslationLikeSearchFilter
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
            fn ($query) => $query->whereLikeTranslation("name", $request->search)
        );
    }
}
