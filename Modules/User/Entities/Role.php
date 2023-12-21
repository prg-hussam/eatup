<?php

namespace Modules\User\Entities;

use Arr;
use Artisan;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;
use Modules\Support\Eloquent\Translatable;
use Modules\User\Repositories\PermissionRepository;
use Modules\User\Repositories\RoleRepository;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Traits\HasClearCache;
class Role extends SpatieRole
{
    use Translatable,HasClearCache;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['display_name'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'original_display_name',
        'is_native',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($product) {
            if (!empty(request()->all())) {
                $product->saveRelations(request()->all());
            }
        });

        static::registerClearCacheOnEvents();
        
    }

    /**
     * Save associated relations for the product.
     *
     * @param  array  $attributes
     * @return void
     */
    public function saveRelations($attributes = [])
    {
        foreach (PermissionRepository::collapse() as  $permission) {
            if (!Permission::where('name', $permission)->first()) {
                Artisan::call("permission:create-permission $permission");
            }
        }

        $this->saveRelationPermissions($attributes);
    }

    public function saveRelationPermissions($attributes)
    {
        $this->syncPermissions(Arr::get($attributes, 'permissions', []));
    }

    /**
     * Get the role's is displayName.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function displayName($displayName)
    {
        return Attribute::make(
            get: fn () => $displayName ?: $this->name
        );
    }

    /**
     * Get the role's is originalDisplayName.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function originalDisplayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->exists ? $this->attributes['display_name'] : null
        );
    }

    /**
     * Get the role's is native.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isNative(): Attribute
    {
        return Attribute::make(
            get: fn () => in_array($this->attributes['name'] ?? '', RoleRepository::all())
        );
    }

    /**
     * Get a list of all roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function list(): Collection
    {
        return Cache::tags("roles")->rememberForever(md5("roles.list:" . locale()), function () {
            return static::select('id', 'display_name')->get()->pluck('display_name', 'id');
        });
    }
}
