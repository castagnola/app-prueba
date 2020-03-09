<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Funcion inicial para inicial el proceso de acceso con Socialite
     * @Autor Fabio Castagnola
     * @param $service
     * @return mixed
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->stateless()->redirect();


    }

    /**
     * EndPoint de vuelta para validar las credenciales del usuario y acceso a la aplicación
     * @Autor Fabio castagnola
     * @param $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($service)
    {
        $userSocial = Socialite::driver($service)->stateless()->user();
        $findUser = User::where('email', $userSocial->email)->first();

        if ($findUser) {
            Auth::login($findUser, true);
            return redirect($this->redirectTo);
        } else {

            $user = User::create([
                'name' => $userSocial->name .' ' . $userSocial->nickname,
                'email' => $userSocial->email,
                'password' => bcrypt(123456),
                'role_id' => 2,
                'id_social' => true,
                'photo' => $userSocial->avatar,

            ]);
            if (isset($user)) {
                Auth::login($user, true);
                return redirect($this->redirectTo);
            }

        }
    }
}
