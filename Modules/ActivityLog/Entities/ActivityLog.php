<?php


namespace Modules\ActivityLog\Entities;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends SpatieActivity
{
    public function causer(): MorphTo
    {
        return $this->morphTo()
            ->withTrashed()
            ->withoutGlobalScope('active');
    }

    public function agent(): Attribute
    {
        return Attribute::make(get: function () {
            $userAgent = $this->properties['info']['user_agent'] ?? '';
            if ($userAgent) {
                $agent = tap(new Agent, function ($agent) use ($userAgent) {
                    $agent->setUserAgent($userAgent);
                });

                return [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ];
            }
        });
    }
}
