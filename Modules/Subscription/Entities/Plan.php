<?php

namespace Modules\Subscription\Entities;

use App\Platform;
use Modules\Support\Eloquent\Model;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use Translatable,  SoftDeletes;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'duration',
        'position',
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

        static::saved(function (Plan $meal) {
            if (Platform::inAdminPanel() && !empty(request()->all())) {
                $meal->saveRelations(request()->all());
            }
        });

        static::addActiveGlobalScope();
    }


    /**
     * Save associated relations for the meal.
     *
     * @param array $attributes
     * @return void
     */
    public function saveRelations($attributes = [])
    {

        $this->planPrices()->delete();
        $this->planPrices()->createMany(\Arr::get($attributes, 'prices', []));
    }


    public function getDurationText()
    {
        return __('admin.plans.duration_text', [
            'duration' => $this->duration
        ]);
    }


    /**
     * Get the prices for the plan.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planPrices(): HasMany
    {
        return $this->hasMany(PlanPrice::class);
    }
}