<?php

namespace App\Http\Controllers\Auth;

// use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Forone\Admin\Controllers\Auth\AuthController as Controller;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\User;

class AdminAuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * @var string
     */
    protected $redirectPath = 'admin';

    /**
     * @var string
     */
    protected $redirectAfterLogout = 'admin/auth/login';

    /**
     * @var string
     */
    protected $loginPath = 'admin/auth/login';

    protected $username = 'username';
    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin.guest', ['except' => 'getLogout']);
        $this->redirectPath = config('forone.RedirectAfterLoginPath') ? config('forone.RedirectAfterLoginPath') : $this->redirectPath;
    }

    /**
     * @return View
     */
    public function getLogin() {
        return view('forone::auth.login');
    }

    public function postLogin(Request $request){
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        if(User::where('username',$request->get('username'))->first()->type != User::TYPE_ADMIN){
            return redirect($this->loginPath());
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }
}
