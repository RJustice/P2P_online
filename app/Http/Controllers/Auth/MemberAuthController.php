<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\User;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Sms;
use Hash;

class MemberAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = 'member';
    protected $redirectAfterLogout = '/';
    protected $loginPath = 'member/auth/login';
    protected $username = 'phone';
    protected $registerPath = 'member/auth/register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('member.guest', ['except' => 'getLogout']);
    }

    public function getLogin(){
        return view('member.login');
    }

    public function postLogin(Request $request){
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        if( !captcha_check($request->get('vercode')) ){
            return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors(['e'=>'验证码错误!']);
        }

        $user = User::where($this->loginUsername(),$request->get($this->loginUsername()))->first();
        if( ! $user ){
            return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors(['e'=>$this->getFailedLoginMessage()]);
        }
        if($user->type == User::TYPE_ADMIN){
            return redirect($this->loginPath())
                ->withErrors(['e' => '登陆异常,请联系客服.']);
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
            ->withErrors(['e'=>$this->getFailedLoginMessage()]);
    }

    public function getRegister(){
        return view('member.register');
    }

    public function getRegisterStep2(){
        if( Session::has('register') ){
            $phone = preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',Session::get('register.phone'));
            if( Session::has('sms') && time() - Session::get('sms.sendtime') < 120 ){
                return view('member.register_2',compact('phone'));
            }
            if( ! Sms::sendVerCode(Session::get('smsphone')) ){
                return view('member.register_2',compact('phone'))
                    ->withErrors(['sms'=>Sms::getError()]);
            }
            return view('member.register_2',compact('phone'));
        }
        return redirect($this->registerPath);
        // return view('member.register_2');
    }

    public function postRegister(Request $request){
        if( $request->get('step') == 1 ){
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect($this->registerPath)
                    ->withInput($request->only('phone','rec_user'))
                    ->withErrors($validator);
            }
            Session::put('register',[
                    'register_step' => true,
                    'phone' => $request->get('phone'),
                    'password' => $request->get('password'),
                    'rec_user' => $request->get('rec_user'),
                ]);
            Session::put('smsphone',$request->get('phone'));
            // Session::push('register.register_step',true);
            // Session::push('register.phone',$request->get('phone'));
            // Session::push('register.password',$request->get('password'));
            // Session::push('register.rec_user',$request->get('rec_user'));
            return redirect(url('member/confirm'));
        }elseif( $request->get('step') == 2 ){
            $code = $request->get('txt_smscode');
            if( ! Sms::check($code) ){
                return redirect(url('member/confirm'))
                    ->withErrors(['e'=>Sms::getError()]);
            }

            $user = $this->create(Session::get('register'));
            if( $user ){
                Auth::login($user);
            }
            return redirect($this->redirectPath());
        }
        return redirect($this->registerPath);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        Validator::extend('check', function($attribute, $value, $parameters)
        {
            return captcha_check($value);
        });
        $v = Validator::make($data, [
            'phone'=>['required','unique:users','regex:/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/'],
            'password' => 'required',
            'password_confirmation'=> 'confirmed',
            'agreement' => 'accepted',
            'rec_user' => 'sometimes|exists:users,phone',
            'vercode' => 'required|check'
        ]);
        // $v->sometimes('rec_user','required|exists:users,phone,type,'.User::TYPE_EMPLOYEE,function($request){
        //     return $request->get('rec_user');
        // });
        return $v;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
                'username' => $data['phone'],
                'phone' => $data['phone'],
                'name' => '',
                'email' => '',
                'type' => User::TYPE_MEMBER,
                'password' => Hash::make($data['password']),
                'state' => 1,
                'sales_manager' => User::find($data['rec_user'])->getKey()
            ]);
        Session::forget('sms');
        Session::forget('register');
        Session::forget('smsphone');
        return $user;
    }
}
