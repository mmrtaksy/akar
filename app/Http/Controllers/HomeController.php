<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Languages;
use App\Models\Services;



// use App\Models\Testimonial;
// use App\Models\Works;

class HomeController extends Controller
{
    //



    public function index($locale)
    {




        $currentLangId = Languages::where('native', $locale)->value('id');


        $services = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 1, 'parent_id' => null])->with('single_path')->orderBy('sort_id', 'desc')->limit(4)->get();
        $rooms = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 2])->whereNull('parent_id')->with('single_path')->orderBy('sort_id', 'desc')->limit(2)->get();
        $blogs = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 3])->whereNotNull('parent_id')->whereHas('parent')->with('single_path', 'parent')->orderBy('sort_id', 'desc')->limit(3)->get();
        $slider = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 4])->orderBy('sort_id', 'desc')->limit(6)->get();
        $testimonial = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 5])->with('single_path')->orderBy('sort_id', 'desc')->limit(6)->get();
        $highlightservices = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 10])->with('single_path')->orderBy('sort_id', 'desc')->limit(6)->get();

        return view('pages.home', [
            'rooms' => $rooms ?? null,
            'blogs' => $blogs ?? null,
            'services' => $services ?? null,
            'testimonial' => $testimonial ?? null,
            'highlightservices' => $highlightservices ?? null,
            'slider' => $slider ?? null
        ]);
    }




    public function pageShow($locale, $slug = null)
    {
        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('slug', $slug)->where('model_id', 7)->where('lang', $langId)->first();

        if (!$data) {
            abort(404);
        }

        return view('pages.pages.index', ['data' => $data]);
    }

    public function about($locale = 'tr')
    {

        $metaData = collect(['title' => Helper::translate('about'), 'image' => null]);
        $metaData = (object) $metaData->all();


        $currentLangId = Languages::where('native', $locale)->value('id');
        $rooms = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 2])->whereNull('parent_id')->with('single_path')->inRandomOrder()->limit(6)->get();
        
        $highlightservices = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => 10])->with('single_path')->orderBy('sort_id', 'desc')->limit(6)->get();
        
        return view('pages.about', ['rooms' => $rooms, 'highlightservices' => $highlightservices, 'metaData' => $metaData]);
    }





    public function faq($locale = "tr")
    {


        $metaData = collect(['title' => Helper::translate('faqs'), 'image' => null]);
        $metaData = (object) $metaData->all();


        $currentLangId = Languages::where('native', $locale)->pluck('id');
        $modelId = 6;
        $data = Services::where(['statu' => true, 'lang' => $currentLangId, 'model_id' => $modelId])->whereNull('parent_id')->with('single_path')->orderBy('sort_id')->get();


        return view('pages.faq', ['pageData' => $data, 'metaData' => $metaData]);

    }

    public function notfound()
    {
        return view('errors.404');
    }


    public function page()
    {

        // abort(404);
        return view('pages.page');
    }


    public function menuList($locale)
    {

        $langId = Languages::where('native', $locale)->pluck('id');
        $pageData = Services::where('lang', $langId)
            ->where('parent_id', null)
            ->where('model_id', 8)
            ->with('children')
            ->orderBy('sort_id')
            ->get();


        $metaData = collect(['title' => 'Menü', 'image' => null]);
        $metaData = (object) $metaData->all();

        //  $menusTR = Services::where('lang', 1)
        //     ->whereNotNull('parent_id')
        //     ->where('model_id', 8)
        //     ->get();

        // foreach ($menusTR as $item) {
        //     $menuEN = Services::where('lang_parent_id', $item->id)
        //         ->whereNotNull('parent_id')
        //         ->where('lang', 2)
        //         ->where('model_id', 8)
        //         ->first();

        //     if ($menuEN) {
        //         $menuEN->extra = $item->extra;
        //         $menuEN->save();
        //     }
        // }




        return view('pages.menuList.index', ['pageData' => $pageData, 'metaData' => $metaData]);
    }



    public function projectAll($locale)
    {

        $langId = Languages::where('native', $locale)->pluck('id');


        return view('pages.projects.list');
    }


    public function teamAll($locale)
    {

        $data = Services::where('lang', Languages::where('native', $locale)->pluck('id'))
            ->where('model_id', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_id')
            ->get();

            
        $metaData = collect(['title' => 'Ekibimiz', 'image' => null]);
        $metaData = (object) $metaData->all();


        return view('pages.team', ['data' => $data, 'metaData' => $metaData]);
    }

    public function projectShow($locale, $slug)
    {
        $langId = Languages::where('native', $locale)->pluck('id');

        // $others = Projects::where('slug', '!=', $slug)->where('lang', $langId)->orderByDesc('id')->limit(6)->get();

        // $data = Projects::where('slug', $slug)->first();
        // if (!$data) {
        //     abort(404);
        // }
        // return view('pages.projects.show', ['data' => $data, 'others' => $others]);
    }



    public function blogAll($locale)
    {

        $metaData = collect(['title' => 'Blog', 'image' => null]);
        $metaData = (object) $metaData->all();


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->where('parent_id', null)
            ->where('model_id', 3)
            ->with('children')
            ->orderByDesc('id')
            ->paginate(6);


        return view('pages.blog.list', ['pageData' => $data, 'metaData' => $metaData]);
    }

    public function blogShow($locale, $category, $slug = null)
    {
        $langId = Languages::where('native', $locale)->pluck('id');

        if ($category && !$slug) {
            $categoryData = Services::where('slug', $category)->where('lang', $langId)->first();
            if(!$categoryData){
                abort(404);
            }
            $data = Services::where('parent_id', $categoryData->id)->where('model_id', 3)->where('lang', $langId)->has('parent')->orderByDesc('id')->paginate(6);



            return view('pages.blog.category', ['data' => $data, 'category' => $categoryData]);
        }




        $others = Services::where('slug', '!=', $slug)
            ->where('model_id', 3)->where('lang', $langId)
            ->has('parent')
            ->orderByDesc('id')
            ->limit(6)
            ->get();


        $data = Services::where('slug', $slug)->where('lang', $langId)->first();
        if (!$data) {
            abort(404);
        }

        $prevData = Services::where('lang', $langId)->whereNotNull('parent_id')->has('parent')->where('model_id', 3)->where('id', '<', $data->id)->first();
        $nextData = Services::where('lang', $langId)->whereNotNull('parent_id')->has('parent')->where('model_id', 3)->where('id', '>', $data->id)->first();



        $cats = Services::where(['lang' => $langId, 'model_id' => $data->model_id, 'parent_id' => null])
            ->has('children')
            ->where('id', '!=', $data->id)
            ->limit(10)
            ->orderByDesc('id')
            ->get();


        return view('pages.blog.show', ['data' => $data, 'cats' => $cats, 'others' => $others, 'prevData' => $prevData, 'nextData' => $nextData]);
    }



    public function serviceAll($locale)
    {

        $metaData = collect([
            'title' => "Hizmetlerimiz",
            'image' => null,
        ]);

        $metaData = (object) $metaData->all();

        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->where('parent_id', null)
            ->where('model_id', 2)
            ->orderBy('sort_id')
            ->get();


        return view('pages.services.list', ['data' => $data, 'metaData' => $metaData]);
    }



    public function serviceCatShow($locale, $category = null, $slug = null)
    {
        $langId = Languages::where('native', $locale)->value('id');

        // Kategori varsa kategori sayfasını açıyoruz
        if ($category && !$slug) {
            $categoryData = Services::where(['slug' => $category, 'lang' => $langId])
                ->first();

            if (!$categoryData) {
                abort(404);
            }

            $others = Services::where(['lang' => $langId, 'parent_id' => $categoryData->id])
                ->orderBy('sort_id')
                ->paginate(6);

            return view('pages.services.category', [
                'data' => $categoryData,
                'others' => $others,
            ]);
        }

        // Kategori ve slug varsa, hizmet detay sayfasını açıyoruz
        if ($slug) {
            // Slug'ın son segmentini alıyoruz
            $slugParts = explode('/', $slug);
            $lastSlug = end($slugParts);

            // Hizmet detayını çekiyoruz
            $data = Services::where(['slug' => $lastSlug, 'lang' => $langId])
                ->with('single_path')
                ->first();

            if (!$data) {
                abort(404);
            }

            // Diğer hizmetleri getiriyoruz
            $parentId = $data->parent_id ?: $data->id;

            if ($data->model_id == 5) {
                $others = Services::where(['lang' => $langId, 'model_id' => $data->model_id, 'parent_id' => $data->parent_id])
                    ->where('id', '!=', $data->id)
                    ->orderBy('sort_id')
                    ->get();
            } else {
                $others = Services::where(['lang' => $langId, 'model_id' => $data->model_id, 'parent_id' => null])
                    ->where('id', '!=', $data->id)
                    ->limit(20)
                    ->orderBy('sort_id')
                    ->get();
            }

            $parseData = ['data' => $data, 'others' => $others];


            return view('pages.services.show', $parseData);
        }

        // Hiçbir şart sağlanmazsa 404
        abort(404);
    }





    public function serviceShow($locale, $slug)
    {
        $langId = Languages::where('native', $locale)->value('id');

        // En son segmenti almak için slug'ı '/' karakterine göre parçalara ayırıyoruz
        $slugParts = explode('/', $slug);
        $lastSlug = end($slugParts); // En son parçayı alıyoruz



        // En son slug parçasına göre hizmeti çekiyoruz

        $data = Services::where(['slug' => $lastSlug, 'lang' => $langId])->with('single_path')
            ->first();

        if (!$data) {
            abort(404);
        }




        // Diğer hizmetleri getiriyoruz


        $others = Services::where(['lang' => $langId, 'model_id' => $data->model_id, 'parent_id' => null])
        ->where('id', '!=', $data->id)
        ->limit(20)
        ->orderBy('sort_id')
        ->get();

        // ->inRandomOrder()
        // ->paginate(6);




        $parseData = ['data' => $data, 'others' => $others];

        // if($data->model_id == 5){
        //     return view('pages.services.countries_show', $parseData);
        // }

        return view('pages.services.show', $parseData);
    }


    public function getMenuChildren($id)
    {



        $menu = Services::where('model_id', 8)
        ->with('childrenadmin.single_path')
        ->findOrFail($id);


        $children = $menu->childrenadmin->map(function ($child) use ($id) {
            return [
                'id' => $child->id,
                'title' => $child->title,
                'description' => Helper::turkishcharacters(strip_tags($child->description)),
                'parent_id' => $id,
                'image' => asset('uploads/' . optional($child->single_path)->path),
                'price' => Helper::getExtra($child->extra, 'price')
            ];
        });

        return response()->json(['data' => $children]);
    }



    public function getMenuSearch(Request $request)
    {
        $keyword = $request->get('q');
        $langId = $request->get('lang');

        if(!$langId){
            return response()->json([]);
        }

        if (!$keyword || strlen($keyword) < 2) {
            return response()->json([]);
        }

        $results = Services::select('id', 'title as name', 'parent_id')
            ->where('model_id', 8)
            ->whereNotNull('parent_id')
            ->where('lang', $langId)
            ->where('title', 'like', '%' . $keyword . '%')
            ->limit(10)
            ->get();

        return response()->json($results);
    }


}


