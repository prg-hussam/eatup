<?php

namespace Modules\Localization\Entities;

use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use SoftDeletes, Translatable;

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
        'is_active',
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
     * Get the cities for the province.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class)
            ->withTrashed()
            ->withoutGlobalScope('active');
    }

    /**
     * Get a list of all provinces .
     *
     * @return \Illuminate\Support\Collection
     */
    public static function list(): Collection
    {
        return Cache::tags("provinces")
            ->rememberForever(
                md5("provinces.all.list:" . locale()),
                function () {
                    return static::select('id', 'name')
                        ->get()
                        ->pluck('name', 'id');
                }
            );
    }
}