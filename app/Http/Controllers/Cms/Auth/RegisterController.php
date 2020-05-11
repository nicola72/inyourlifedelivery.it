<?php

namespace App\Http\Controllers\Cms\Auth;

use App\Model\Cms\ClearcmsPassword;
use App\Model\Cms\RoleCms;
use App\Model\Cms\UserCms;
use App\Http\Controllers\Controller;
use App\Model\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cms';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //se la richiesta non viene da un IP autorizzato esco
        $this->middleware('cms.isipauth');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $roles = RoleCms::all();
        $shops = Shop::all();
        return view('cms.auth.register',['roles'=> $roles,'shops'=>$shops]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\Cms\UserCms|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function create(array $data)
    {
        $shop_id = (isset($data['shop_id'])) ? $data['shop_id'] : null;

        $userCms = new UserCms();
        $userCms->role_id = $data['role_id'];
        $userCms->shop_id = $shop_id;
        $userCms->name = $data['name'];
        $userCms->email = $data['email'];
        $userCms->password = Hash::make($data['password']);
        $userCms->save();

        $user_id = $userCms->id;

        $clear_pwd = new ClearcmsPassword();
        $clear_pwd->user_cms_id = $user_id;
        $clear_pwd->password = $data['password'];
        $clear_pwd->save();

        return $userCms;
    }
}
