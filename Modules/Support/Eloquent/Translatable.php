<?php

namespace Modules\Support\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Translatable\HasTranslations;

trait Translatable
{
    use HasTranslations;

    /**
     * Scope a query to where like translations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string                                 $column
     * @param  string                                 $operator
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereLikeTranslation(Builder $query, string $column, string $operator)
    {
        return $query->whereRaw('LOWER(' . $column . '->"$.' . locale() . '") LIKE ?', '%' . strtolower($operator) . '%');
    }

    /**
     * Scope a query to where like translations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string                                 $column
     * @param  string                                 $operator
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrWhereLikeTranslation(Builder $query, string $column, string $operator)
    {
        return $query->orWhereRaw('LOWER(' . $column . '->"$.' . locale() . '") LIKE ?', '%' . strtolower($operator) . '%');
    }
}
