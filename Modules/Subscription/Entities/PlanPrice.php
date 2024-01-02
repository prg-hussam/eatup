<?php

namespace Modules\Subscription\Entities;

use App\Platform;
use Modules\Support\Eloquent\Model;
use Modules\Meal\Entities\DiningPeriod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'price',
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
     * Get the dining period that owns the plan price.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diningPeriod(): BelongsTo
    {
        return $this->belongsTo(DiningPeriod::class)->withTrashed();
    }
}