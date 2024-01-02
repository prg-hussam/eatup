<?php

namespace Modules\Meal\Entities;

use App\Platform;
use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Illuminate\Support\Facades\Cache;
use Modules\Category\Entities\Category;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiningPeriod extends Model
{
    use Translatable, HasMedia, SoftDeletes;


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

    protected $with = ['files'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ["icon"];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function (DiningPeriod $diningPeriod) {
            if (Platform::inAdminPanel() && !empty(request()->all())) {
                $diningPeriod->saveRelations(request()->all());
            }
        });


        static::addActiveGlobalScope();
    }


    /**
     * Save associated relations for the dining period.
     *
     * @param array $attributes
     * @return void
     */
    public function saveRelations($attributes = [])
    {

        $this->categories()->sync(\Arr::get($attributes, 'categories', []));
    }


    /**
     * Get the times for the dining period.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function times(): HasMany
    {
        return $this->hasMany(DiningPeriodTime::class);
    }

    /**
     * Get icon.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function icon(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fileResource($this->files->where('pivot.zone', 'icon')->first())
        );
    }

    /**
     * The categories that belong to the dining period.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }


    /**
     * The meals that belong to the dining period.
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class);
    }

    /**
     * Get a list of all dining periods.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function list(): Collection
    {
        return Cache::tags("dining_periods")->rememberForever(md5("dining_periods.list:" . locale()), function () {
            return static::select('id', 'name')->get()->pluck('name', 'id');
        });
    }
}
