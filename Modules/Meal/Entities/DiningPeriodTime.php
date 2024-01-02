<?php

namespace Modules\Meal\Entities;

use App\Platform;
use Modules\Support\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiningPeriodTime extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'from',
        'to',
        'dining_period_id',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        if (!Platform::inAdminPanel()) {
            static::addActiveGlobalScope();
        }
    }

    /**
     *  Get the dining period that owns the dining period time.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diningPeriod(): BelongsTo
    {
        return $this->belongsTo(DiningPeriod::class)
            ->withTrashed()
            ->withoutGlobalScope('active');
    }
}
