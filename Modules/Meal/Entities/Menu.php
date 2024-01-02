<?php

namespace Modules\Meal\Entities;

use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Eloquent\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
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
        'is_default',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];




    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addActiveGlobalScope();

        static::saved(fn ($menu) => $menu->syncDefaultMenu());
    }

    /**
     * Sync default menu
     *
     * @return void
     */
    public function syncDefaultMenu(): void
    {
        $this->withoutEvents(function () {
            if ($this->is_default) {
                self::where('id', '<>', $this->id)->update(['is_default' => false]);

                if ($this->is_default && !$this->is_active) {
                    self::withoutGlobalScope('active')->where('id', $this->id)->update(['is_active' => true]);
                }
            } elseif (!static::hasDefaultMenu($this->id)) {
                self::withoutGlobalScope('active')->where('id', $this->id)->update(['is_default' => true, 'is_active' => true]);
            }
        });
    }

    /**
     * Determine if has default menu
     *
     * @param int|null $exceptionId
     * @return bool
     */
    public static function hasDefaultMenu(?int $exceptionId = null): bool
    {
        return static::where(function ($query) use ($exceptionId) {
            $query->where('id', '<>', $exceptionId);
        })
            ->where('is_default', true)
            ->exists();
    }




    /**
     * The meals that belong to the menu.
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
        return Cache::tags("menus")->rememberForever(md5("menus.list:" . locale()), function () {
            return static::select('id', 'name')->get()->pluck('name', 'id');
        });
    }
}
