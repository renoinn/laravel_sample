<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\ProviderUser;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class TwitterAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['expect' => 'logout']);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('twitter')->user();
        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, false);
        return redirect('home');
    }

    public function findOrCreateUser($twitter_user)
    {
        // TODO provider_typeのconstを定義する
        $authUser = ProviderUser::where([
            'provider_user_id' => $twitter_user->id,
            'provider_type' => 'twitter',
        ])->first();

        if ($authUser) {
            $user = $authUser->user;
            if($user) {
                return $user;
            }
            throw new \Exception("cant find user");
        }
        
        // create user
        $user = User::create([
            'name' => $twitter_user->name,
            'email' => str_random(16)."@example.com", //仮で入れる
            'password' => bcrypt(str_random(16)), //仮で入れる
        ]);

        $provider_user = new ProviderUser([
            'provider_user_id' => $twitter_user->id,
            'provider_type' => 'twitter',
            'email' => $twitter_user->email,
            'name' => $twitter_user->name,
            'nickname' => $twitter_user->nickname,
            'avatar' => $twitter_user->avatar,
            'token' => $twitter_user->token,
            'token_secret' => $twitter_user->tokenSecret,
        ]);

        $user->provider_users()->save($provider_user);
        return $user;
    }

    public function logout()
    {
        $user = Socialite::driver('twitter')->user();
        Auth::logout();
    }
}
