<?php

namespace App\Http\Controllers\Auth;

// use Illuminate\Http\Request;

use App\Http\Requests;
use Forone\Admin\Controllers\Auth\AuthController as Controller;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;


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
}
