<?php

namespace Modules\Meal\Entities;

use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use Translatable, HasMedia, SoftDeletes;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['name'];


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['files'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
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
        static::addActiveGlobalScope();
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
     * The meals that belong to the ingredient.
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class);
    }

    /**
     * Get a list of all ingredients.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function list(): Collection
    {
        return Cache::tags("ingredients")->rememberForever(md5("ingredients.list:" . locale()), function () {
            return static::select('id', 'name')->get()->pluck('name', 'id');
        });
    }
}