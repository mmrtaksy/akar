<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    //

    public function index(){
        $model = Seo::where('id', 1)->first();

        return view('xadmin.pages.seo.index', ['data' => $model]);
    }

    public function update(Request $request){

        Seo::where('id', 1)->update($request->post());

        return redirect()->back()->with('success', 'Bilgiler başarıyla güncellendi.');
    }
}
