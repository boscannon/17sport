<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use \Illuminate\Http\Request;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use App\Actions\Fortify\CaptchaValidation;
use App\Models\User;
use App\Models\Member;
use Hash;
use Auth;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Fortify::authenticateThrough(function (Request $request) {
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                CaptchaValidation::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });

        Fortify::authenticateUsing(function (Request $request) {
            if(config('fortify.guard') == 'admin') {
                $user = User::where('email', $request->email)->first();
            }else{
                $user = Member::where('email', $request->email)->first();
            }

            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
