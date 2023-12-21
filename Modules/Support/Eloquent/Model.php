<?php

namespace Modules\Support\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Modules\Support\Traits\HasClearCache;

abstract class Model extends Eloquent
{
    use HasClearCache;

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    protected static function booting()
    {
        static::registerClearCacheOnEvents();
    }

    public static function queryWithoutEagerRelations()
    {
        return (new static)->newQueryWithoutEagerRelations();
    }

    public function newQueryWithoutEagerRelations()
    {
        return $this->registerGlobalScopes(
            $this->newModelQuery()->withCount($this->withCount)
        );
    }

    /**
     * Register a new active global scope on the model.
     *
     * @return void
     */
    public static function addActiveGlobalScope()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });
    }

    public function scopeWhereDateFromAndTo($query, ?string $from = null, ?string $to = null)
    {
        $query->when(!is_null($from), function ($query) use ($from) {
            $query->whereDate('created_at', ">=", date("Y-m-d", strtotime($from)));
        })
            ->when(!is_null($to), function ($query) use ($to) {
                $query->whereDate('created_at', "<=", date('Y-m-d', strtotime($to)));
            });
    }
}
