<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Company;
use App\Models\CompanyLogo;
use App\Models\CompanyUser;
use App\Models\DeleteAccount;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Helpers\Helper;

class UserController extends Controller
{


    public function index()
    {
        $user = User::orderBy('id', 'asc')->get();
        return $user;
    }



    public function userAccount()
    {
        $id = Auth::user()->id;
        $data = User::where('id', $id)->with('company.info')->first();
        if(!$data){
            abort(404);
        }


        return view('pages.auth.account', ['data' => $data]);
    }



    public function updatePost(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required',
            'country' => 'required',
            'email' => 'required|email|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'about' => 'nullable|max:1000',
        ]);

        $data = $request->post();
        $id = Auth::user()->id;
        $model = User::findorFail($id);
        $user = $model->update($data);

        // if ($request->hasFile('avatar')) {
        //     $file = $request->file('avatar');
        //     $fileName = Helper::uploadImage($file, 800, 480, 300);
        //     $data['avatar'] = $fileName;
        // }


        if ($user) {
            return redirect(route('userDashboard'))->with('success', 'Kullanıcı başarıyla güncellendi.');
        }

        return redirect(route('userSetting'))->withErrors([
            'name' => __('auth.name_required'),
            'surname' => __('auth.surname_required'),
            'phone' => __('auth.phone_required'),
            'country' => __('auth.country_required'),
            'email' => __('auth.email_required'),
        ])->withInput([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email')
        ]);

    }


    public function password_update(Request $request)
    {


        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|confirmed|different:password',
        ]);

        $auth = Auth::user();
        $user = User::where('id', $auth->id)->first();

        if (Hash::check($request->password, $user->password)) {

            $isUpdate = User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            if ($isUpdate) {
                Session::flash('alert', 'Şifre Başarıyla Değiştirildi');
                return redirect('/edit');
            } else {
                Session::flash('alert', 'Şifre Değiştirilirken Sorun Oluştu, Tekrar Deneyin');
                return redirect('/edit');
            }
        } else {
            Session::flash('alert', 'Eski Şifrenizden Farklı Bir Şifre Girmelisiniz');
            return redirect('/edit');
        }
    }

 
    public function loginGet(){ 
        return view('pages.auth.login');
    }


    public function passwordResetGet($token, $email)
    {
        return view('pages.auth.newpassword', ['token' => $token, 'email' => $email]);
    }

    public function resetPasswordGet(){
        return view('pages.auth.reset');
    }

  

    public function resetPasswordPost(Request $request){


        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ], [
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.max' => __('validation.email.max'),
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator);
        }


        $email = $request->email;

        $data = User::where('email', $email)->first();
        if(!$data){
            return redirect()->back()->with('error', 'Bu email sistemimizde kayıtlı değildir');
        }

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/password-reset', ['token' => $token, 'email' => $email]);

        Mail::send('emails.password_reset', ['resetLink' => $resetLink], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Şifre Sıfırlama Talebi');
        });

        return redirect()->back()->with('success', 'Şifre sıfırlama linki email adresinize gönderildi.');
    }

    public function newPasswordPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|confirmed|min:6',
            'token' => 'required',
            'email' => 'required|email',
        ], [
            'new_password.min' => __('validation.new_password.min'),
            'new_password.required' => __('validation.new_password.required'),
            'new_password.confirmed' => __('validation.new_password.confirmed'),
            'token.required' => __('validation.token.required'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email')
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('new_password', 'new_password_confirmation'))
                ->withErrors($validator);
        }

        $token = $request->input('token');
        $email = $request->input('email');

        // Token ve email ile kayıtlı şifre sıfırlama isteği kontrolü
        $passwordReset = DB::table('password_resets')->where('email', $email)->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return back()->withErrors(['token' => 'Geçersiz veya süresi dolmuş şifre sıfırlama tokenı.']);
        }

        // Kullanıcının yeni şifresini kaydetme
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => __('auth.user_not_found')]);
        }

        $user->password = $request->new_password;
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Şifre sıfırlama isteğini veritabanından sil
        DB::table('password_resets')->where('email', $email)->delete();

        return redirect('/login')->with('success', __('auth.password_reset_success'));
    }

    public function loginPost(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ], [
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.max' => __('validation.email.max'),
            'password.min' => __('validation.password.min'),
            'password.required' => __('validation.password.required'),
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($validator);
        }

        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if(!isset($user->id)){
            return redirect()->back()->with('error', __('auth.deleted'));
        }

        if($user){
            $isdelete = DeleteAccount::where('user_id', $user->id)->exists();
            if($isdelete){
             return redirect()->back()->with('error', __('auth.deleted'));
            }
        }

        

        $isCompanyExists = CompanyUser::where('user_id', $user->id)->exists();

        if(!$isCompanyExists){
            return redirect()->back()->with('error', __('auth.not_found_company'));
        }


        if (!Auth::attempt($data)) {
            return back()->withErrors([
                'email' => __('auth.not_login'),
            ])->onlyInput('email');
        }
 
        $request->session()->regenerate();
        
        return redirect(Helper::localizedRoute('userAccount'));
    }

    public function verify(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $verification = DB::table('email_verifications')->where('email', $email)->first();

        if (!$verification) {
            return redirect()->back()->with('error', 'Geçersiz doğrulama isteği.');
        }

        if (!Hash::check($token, $verification->token)) {
            return redirect()->back()->with('error', 'Token geçerli değil.');
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            DB::table('email_verifications')->where('email', $email)->delete();

            return redirect()->back()->with('error', 'E-posta adresiniz başarıyla doğrulandı.');
        }

        return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
    }



    public function userLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
