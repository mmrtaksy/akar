<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //

    public function index()
    {

        $metaData = collect(['title' => Helper::translate('contact'), 'image' => null]);
        $metaData = (object) $metaData->all();

        return view('pages.contact', ['metaData' => $metaData]);
    }


    public function list()
    {
        $data = Contact::orderBy('id', 'desc')->get();
        return view('xadmin.pages.contact.list', ['data' => $data]);
    }
 



    public function formcontact(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subject' => 'nullable|max:100',
            'email' => 'required|email',
            'g-recaptcha-response' => 'required',
        ], [
            'title.required' => __('validation.name.required'),
            'title.max' =>  __('validation.name.max'),
            'subject.max' =>  __('validation.subject.max'),
            'email.required' => __('validation.email.required'),
            'email.email' =>  __('validation.email.email'),
            'g-recaptcha-response.required' => __('validation.captcha.required'),
        ]);
 
        if ($validator->fails()) {
            return back()
                ->withInput($request->except('g-recaptcha-response'))
                ->withErrors($validator);
        }

        $data = $request->post();

        $recaptcha = $request->input('g-recaptcha-response');
        $secret_key = env('GOOGLE_RECAPTCHA_SECRET');

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='. $secret_key . '&response=' . $recaptcha;

        $response = file_get_contents($url);

        $response = json_decode($response);


        $data = $request->post();

        if ($response->success == true) {
            Contact::create($data);
            return redirect()->back()->with('success', Helper::translate('success_contact_message'));
        }else{
            return redirect()->back()->with('error', Helper::translate('error_contact_message'));
        }


    }

    public function delete($id)
    {
        if (!$id) {
            return false;
        }

        Contact::destroy($id);

        return redirect()->back();
    }
}
