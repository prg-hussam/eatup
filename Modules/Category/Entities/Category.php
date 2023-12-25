<?php

namespace Modules\Category\Entities;

use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Meal\Entities\DiningPeriod;

class Category extends Model
{
    use Translatable, SoftDeletes;

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

    /**
     * The dining periods that belong to the category.
     */
    public function diningPeriods(): BelongsToMany
    {
        return $this->belongsToMany(DiningPeriod::class);
    }

    /**
     * Get a list of all categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function list(): Collection
    {
        return Cache::tags("categories")->rememberForever(md5("categories.list:" . locale()), function () {
            return static::select('id', 'name')->get()->pluck('name', 'id');
        });
    }
}