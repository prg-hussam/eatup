<?php

namespace Modules\Verification\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Verification\Entities\Verification;
use Modules\Verification\Notifications\SendVerificationNotification;
use Illuminate\Support\Facades\Notification;

class VerificationSaved
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param \Modules\Verification\Entities\Verification $verification
     * @return void
     */
    public function __construct(Verification $verification)
    {
        // Notification::route($verification->channel, $verification->username)
        //     ->notify(new SendVerificationNotification($verification));
    }
}