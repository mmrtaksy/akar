<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

 
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AccountController extends Controller
{
    //
 
    // protected $iyzicoService;

    // public function __construct(IyzicoService $iyzicoService)
    // {
    //     $this->iyzicoService = $iyzicoService;
    // }


 
    public function indexUpdate(Request $request){
        $id = Auth::user()->id;


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'about' => 'nullable|max:1000',
            'phone' => [
                'nullable',
                Rule::unique('users')->ignore($id)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id)
            ],
        ], [
            'name.required' => 'Ad alanı zorunludur.',
            'name.max' => 'Ad maksimum 255 karakter olmalı.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.max' => 'Soyad maksimum 255 karakter olmalı.',
            'phone.unique' => 'Bu telefon numarası zaten kayıtlı.',
            'about.max' => 'Hakkında maksimum 1000 karakter olmalı.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $request->post();

        $model = User::find($id);
        $model->update($data);


        if ($model) {
            return redirect()->back()->with('success', __('main.success_text'));
        }
        return redirect()->back()->with('error', __('main.error_text'));

    }
 

 

}
