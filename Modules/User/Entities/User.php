<?php

namespace Modules\User\Entities;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\Actions\ConfirmPassword;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Modules\Setting\Traits\HasSetting;
use Modules\User\Repositories\RoleRepository;
use Spatie\Permission\Traits\HasRoles;
use Modules\User\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use SoftDeletes,
        Notifiable,
        HasSetting,
        TwoFactorAuthenticatable,
        CanResetPassword,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'current_roles',
    ];



    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });
    }

    /**
     * Get the user's is profile Photo Url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function profilePhotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=E5E7EB&background=1F2937'
        );
    }

    /**
     * Check user is super admin
     *
     * @var bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleRepository::SUPER_ADMIN) ? true : false;
    }

    /**
     * Confirm that the given password is valid for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @param  string  $password
     * @return bool
     */
    public function confirmPassword(StatefulGuard $guard, string $password): bool
    {
        return app(ConfirmPassword::class)(
            $guard,
            $this,
            $password
        );
    }

    /**
     * Parse user object to resource
     *
     * @return array
     */
    public function toAuthResource(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,
            'is_super_admin' => $this->isSuperAdmin(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'roles' => $this->getRoleNames(),
            'two_factor_enabled' => $this->hasEnabledTwoFactorAuthentication(),
            'two_factor_confirmed' => !is_null($this->two_factor_confirmed_at),
        ];
    }

    /**
     * Get the user role's .
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function currentRoles(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->roles->pluck('id')->toArray()
        );
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->username));
    }
}