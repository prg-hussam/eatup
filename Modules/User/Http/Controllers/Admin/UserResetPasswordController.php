<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;

class UserResetPasswordController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = User::find($request->id);

        $status = $this->broker()->sendResetLink(
            ['email' => $user->email ?? '']
        );

        if ($status != Password::RESET_LINK_SENT) {
            return response()->json(__($status), 429);
        }

        _activity(
            "reset_password_email",
            $user,
            "messages.reset_password_email_sent",
            auth('web')->user(),
            [
                "attributes" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "username" => $user->username,
                    "email" => $user->email
                ]
            ],
        );

        return response()->json(__('passwords.sent_to_user', ['username' => $user->name]), 200);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }
}
