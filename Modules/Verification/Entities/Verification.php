<?php

namespace Modules\Verification\Entities;

use Modules\Support\Eloquent\Model;
use Modules\Verification\Enums\VerificationChannelsCases;
use Modules\Verification\Events\VerificationSaved;

class Verification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'token',
        'code',
        'channel',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => VerificationSaved::class,
    ];

    /**
     * Find by token
     *
     * @param string $token
     * @return \Modules\User\Entities\Verification|null
     */
    public static function findByToken(string $token): ?Verification
    {
        return static::where("token", $token)->first();
    }

    /**
     * Find by username
     *
     * @param string $username
     * @return \Modules\User\Entities\Verification|null
     */
    public static function findByUsername(string $username): ?Verification
    {
        return static::where("username", $username)->first();
    }

    /**
     * Add or update
     *
     * @param string $username
     * @param \Modules\Verification\Enums\VerificationChannelsCases $channel
     * @param array|null $meta
     * @return \Modules\User\Entities\Verification
     */
    public static function addOrUpdate(string $username, ?VerificationChannelsCases $channel = null, ?array $meta = null): Verification
    {
        $verification = self::findByUsername($username);
        if (is_null($verification)) {
            $verification = new static;
            $verification->username = $username;
            $verification->channel = $channel->value;
        }
        // $verification->code = rand(11111, 99999);

        //TODO:: remove on production
        $verification->code = 12345;
        $verification->token = \Str::random(60);
        if (is_array($meta)) {
            $verification->meta = $meta;
        }
        $verification->save();
        return $verification;
    }

    /**
     * Find by token and code
     *
     * @param string $token
     * @param string $code
     * @return \Modules\User\Entities\Verification|null
     */
    public static function findByTokenAndCode(string $token, string $code): ?Verification
    {
        return static::where("code", $code)->where("token", $token)->first();
    }
}