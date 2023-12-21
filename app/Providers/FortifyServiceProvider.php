<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Platform;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!Platform::installed()) {
            Fortify::ignoreRoutes();
        }

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Platform::installed()) {
            return;
        }

        Fortify::loginView(function () {
            return Inertia::render('Admin/Auth/Login', [
                'canResetPassword' => Route::has('password.request'),
                'status' => session('status'),
            ]);
        });

        Fortify::twoFactorChallengeView(function () {
            return Inertia::render('Admin/Auth/TwoFactorChallenge');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return Inertia::render('Admin/Auth/ForgotPassword', ['status' => session('status')]);
        });

        Fortify::resetPasswordView(function ($request) {
            if (
                !Password::broker(config('fortify.passwords'))
                    ->tokenExists(
                        Password::broker(config('fortify.passwords'))
                            ->getUser([
                                'email' => $request->email,
                                'token' => $request->token,
                            ]),
                        $request->token
                    )
            ) {
                abort(404);
            }

            return Inertia::render('Admin/Auth/ResetPassword', [
                'email' => $request->email,
                'token' => $request->token,
            ]);
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
