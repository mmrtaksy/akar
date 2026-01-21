<?php

namespace App\Http\Controllers;

use App\Models\Services;

class SitemapController extends Controller
{
    // 

    public function index()
    {
        $blogtr = Services::where('lang', 1)->where('model_id', 3)->orderBy('updated_at', 'desc')->first();
        $blogen = Services::where('lang', 2)->where('model_id', 3)->orderBy('updated_at', 'desc')->first();
        
        $servicestr = Services::where('lang', 1)->where('model_id', 2)->orderBy('updated_at', 'desc')->first();
        $servicesen = Services::where('lang', 2)->where('model_id', 2)->orderBy('updated_at', 'desc')->first();


        return response()->view('sitemap.index', [
            'blogtr' => $blogtr,
            'blogen' => $blogen,
            'servicestr' => $servicestr,
            'servicesen' => $servicesen,
        ])->header('Content-Type', 'text/xml');
    }

    public function blogsTr()
    {
        $data = Services::where('lang', 1)->where('model_id', 3)->with('parentSeo')->orderBy('updated_at', 'desc')->get(); 
        
        return response()->view('sitemap.blogs', [
            'data' => $data,
            'locale' => 'tr'
        ])->header('Content-Type', 'text/xml');
    }

    public function blogsEn()
    {
        $data = Services::where('lang', 2)->where('model_id', 3)->with('parentSeo')->orderBy('updated_at', 'desc')->get();
        
         
        return response()->view('sitemap.blogs', [
            'data' => $data,
            'locale' => 'en'
        ])->header('Content-Type', 'text/xml');
    }

   
  
       public function servicesTr()
        {
          $data = Services::where('model_id', 2)
            ->where('lang', 1)
            ->with(['parentSeo' => function ($query) {
                $query->where('model_id', 2)->where('lang', 1);
            }])
            ->orderBy('updated_at', 'desc')
            ->get();
        
            return response()->view('sitemap.services', [
                'data' => $data,
                'locale' => 'tr',
                'prefix' => '',
            ])->header('Content-Type', 'text/xml');
        }


     public function servicesEn()
        {
            $data = Services::where('model_id', 2)
                ->where('lang', 2)
                ->with(['parentSeo' => function ($query) {
                    $query->where('model_id', 2)->where('lang', 2);
                }])
                ->orderBy('updated_at', 'desc')
                ->get();
         
        
            return response()->view('sitemap.services', [
                'data' => $data,
                'locale' => 'en',
                'prefix' => '',
            ])->header('Content-Type', 'text/xml');
        }
        
 

 

}
