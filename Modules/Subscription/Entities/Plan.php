<?php

namespace Modules\Subscription\Entities;


use Modules\Support\Money;
use Modules\Support\Eloquent\Model;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'price',
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
        static::addActiveGlobalScope();
    }

    public function getDurationText()
    {
        return __('admin.plans.duration_text', [
            'duration' => $this->duration
        ]);
    }

    /**
     * Get plan price
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Money::inDefaultCurrency($value)
        );
    }
}