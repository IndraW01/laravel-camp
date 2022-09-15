<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\RegisteredSuccess;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\User\AfterRegister;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

class SocialiteController extends Controller
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->user();

        if ($cekUser = $this->user->cekUser($user->id)) {
            Auth::login($cekUser);
        } else {
            DB::beginTransaction();

            try {
                $userCreate = $this->user->createUserGoogle($user);

                event(new RegisteredSuccess($userCreate));

                Auth::login($userCreate);

                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();

                return $exception->getMessage();
            }
        }

        Alert::success('Login!', 'You have successfully logged in');
        return redirect()->route('main.dashboard');
    }
}
