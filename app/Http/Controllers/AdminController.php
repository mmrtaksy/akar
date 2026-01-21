<?php

namespace App\Http\Controllers;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\LanguageLevel;
use App\Models\Languages;
use App\Models\Pages;
use App\Models\ServicesImage;
use App\Models\User;
use App\Models\UserTypes;
use App\Models\Contact;
use App\Models\Settings;
use App\Models\Visitor;
use App\Services\SeoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use DB;

use Akaunting\Apexcharts\Chart;

class AdminController extends Controller
{

    private $defaultLang = 1;

    public function determineParentId($categoryId, $lang)
    {
        if ($categoryId == 1 && $lang == 1)
            return 52;
        if ($categoryId == 2 && $lang == 2)
            return 53;
        if ($categoryId == 3 && $lang == 1)
            return 284;
        if ($categoryId == 4 && $lang == 2)
            return 285;
        if ($categoryId == 5 && $lang == 1)
            return 58;
        if ($categoryId == 6 && $lang == 2)
            return 59;
        if ($categoryId == 7 && $lang == 1)
            return 286;
        if ($categoryId == 8 && $lang == 2)
            return 287;

        return null;
    }

    public function index()
    {

        $visitorsData = Visitor::select('ip_address', 'browser', 'country', 'device', 'visit_count', 'last_visit_at')
            ->orderBy('last_visit_at', 'DESC')
            ->paginate(6);

        $visitors = Visitor::selectRaw('COUNT(*) as visits, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();


        $pages = Visitor::select(DB::raw('url, COUNT(*) as visit_count'))
            ->groupBy('url')
            ->orderBy('visit_count', 'DESC')
            ->limit(20)
            ->get();

        $browsers = Visitor::select('browser', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('browser')
            ->orderBy('visit_count', 'DESC')
            ->get();

        $countries = Visitor::select('country', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('country')
            ->orderBy('visit_count', 'DESC')
            ->get();

        $devices = Visitor::select('device', DB::raw('COUNT(*) as visit_count'))
            ->groupBy('device')
            ->orderBy('visit_count', 'DESC')
            ->get();

        // ApexCharts nesneleri oluşturuluyor

 


        // Diğer bilgiler
        $totalVisitors = Visitor::count();
        $averageVisits = Visitor::avg('visit_count');
        $mostVisitedPage = Visitor::select('url', DB::raw('COUNT(*) as count'))
            ->groupBy('url')
            ->orderByDesc('count')
            ->first();
        $mostVisitedPage = $mostVisitedPage ? $mostVisitedPage->url : null;

        $refererSource = Visitor::select('referer')
            ->selectRaw('COUNT(*) as total_count')
            ->groupBy('referer')
            ->orderByDesc('total_count')
            ->first();
        $refererCount = $refererSource ? $refererSource->total_count : 0;

      
        return view('xadmin.pages.home-chart', [
            'visitors' => $visitorsData,
            'chart' =>  null,
            'chart2' =>  null,
            'chart3' => null,
            'chart4' => null,
            'chart5' =>  null,
            'totalVisitors' => $totalVisitors,
            'averageVisits' => $averageVisits,
            'mostVisitedPage' => $mostVisitedPage,
            'refererSource' => $refererSource,
            'refererCount' => $refererCount,
        ]);



        // return view('xadmin.pages.home');
    }

    public function loginGet()
    {
        return view('xadmin.auth.login');
    }

    public function loginPost(Request $request)
    {


        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $data['user_type_id'] = 1;


        if (!Auth::attempt($data)) {
            return back()->withErrors([
                'email' => 'Giriş bilgileriniz sistemde bulunmamaktadır.',
            ])->onlyInput('email');
        }


        $request->session()->regenerate();
        return redirect('/xadmin');
    }



    /* ####### USER ####### */
    public function userList(Request $request)
    {
        $order = $request->get('order') ?? 'id';
        $dataUsers = User::where('user_type_id', '!=', 1)->orderByDesc($order)->paginate(10);
        $dataAdmins = User::where('user_type_id', 1)->orderByDesc($order)->paginate(10);

        return view('xadmin.pages.user.list', ['dataUsers' => $dataUsers, 'dataAdmins' => $dataAdmins]);
    }
    public function userCreateGet()
    {
        $types = UserTypes::get();
        return view('xadmin.pages.user.create', ['types' => $types]);
    }
    public function userUpdateGet($id)
    {
        $data = User::find($id);
        if (!$data) {
            return redirect(route('userList'))->with('error', 'Kullanıcı bulunamadı');
        }
        $types = UserTypes::get();
        return view('xadmin.pages.user.update', ['types' => $types, 'data' => $data]);
    }
    public function userUpdatePasswordGet($id)
    {
        $data = User::find($id);
        if (!$data) {
            return redirect()->back();
        }

        return view('xadmin.pages.user.passwordupdate', ['data' => $data]);
    }
    public function userPasswordUpdatePost(Request $request)
    {

        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ], [
            'password.required' => 'Yeni Şifre zorunludur.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = User::where('id', $id)->first();
        $isUpdate = User::whereId($id)->update([
            'password' => Hash::make($request->password)
        ]);

        if ($isUpdate) {
            return redirect(route('userList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function userUpdatePost(Request $request)
    {

        $id = $request->id;


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
            return redirect(route('userList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function userCreatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'nullable|unique:users',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Ad alanı zorunludur.',
            'name.max' => 'Ad maksimum 255 karakter olmalı.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.max' => 'Soyad maksimum 255 karakter olmalı.',
            'phone.unique' => 'Bu telefon numarası zaten kayıtlı.',
            'password.min' => 'Şifre minimum 6 karakter olmalı.',
            'password.required' => 'Şifre alanı zorunludur.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors($validator);
        }


        $data = $request->post();

        $user = new User();
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        $user->user_type_id = $data['user_type_id'];
        $user->statu = $data['statu'];
        $user->save();

        if ($user) {
            return redirect(route('userList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function userDelete(Request $request)
    {

        $id = $request->id;
        $user = User::find($id);

        if (!isset($user)) {
            return redirect(route('userList'))->with('error', 'Kullanıcı bulunamadı');
        }

        $user->delete();


        if ($user) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function loginAsUser($id)
    {


        $user = User::find($id);
        if (!$user) {
            return redirect()->back();
        }

        Session::put('admin_user_id', Auth::id());
        Auth::login($user);

        return redirect(Helper::localizedRoute('homepage'));

    }

    public function returnToAdmin()
    {
        $adminUserId = Session::get('admin_user_id');

        $adminUser = User::find($adminUserId);

        if (!$adminUser) {
            return redirect()->back();
        }
        Auth::login($adminUser);
        Session::forget('admin_user_id');

        return redirect()->route('home');
    }

    /* ####### USER ####### */




    /* ####### USER TYPE ####### */
    public function usertypeList()
    {
        $data = UserTypes::paginate(15);
        return view('xadmin.pages.usertype.list', ['data' => $data]);
    }
    public function usertypeCreateGet()
    {
        return view('xadmin.pages.usertype.create');
    }
    public function usertypeUpdateGet($id)
    {
        $data = UserTypes::find($id);
        if (!$data) {
            return redirect()->back();
        }
        return view('xadmin.pages.usertype.update', ['data' => $data]);
    }
    public function usertypeUpdatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => 'Tip adı zorunludur.',
            'title.max' => 'Tip adı maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $id = $request->id;
        $data = $request->post();

        $model = UserTypes::find($id);
        $model->update($data);

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function usertypeCreatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => 'Tip adı zorunludur.',
            'title.max' => 'Tip adı maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $request->post();
        $user = UserTypes::create($data);

        if ($user) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function usertypeDelete(Request $request)
    {

        $id = $request->id;
        $model = UserTypes::find($id)->delete();

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    /* ####### USER TYPE ####### */





















    /* ####### SERVICES ####### */

    public function servicesList(Request $request)
    {



        $q = $request->get('q') ?? null;
        $lang = $request->get('lang') ?? 1;
        $parentid = $request->get('parent_id') ?? null;
        $modelId = $request->get('model_id') ?? 1;


        if ($q) {
            $data = Services::where('lang', $lang)
                ->where('model_id', $modelId)
                ->where('title', 'like', "%{$q}%")
                ->where('lang', $lang)
                ->with('single_path', 'parentadmin', 'childrenadmin')
                ->orderBy('sort_id')->paginate(15);
        } else {

            if (!$parentid) {
                $data = Services::where('lang', $lang)
                    ->where('model_id', $modelId)
                    ->whereNull('parent_id')
                    ->with('single_path', 'childrenadmin')
                    ->orderBy('sort_id')->paginate(15);
            } else {

                $data = Services::where('lang', $lang)
                    ->where('model_id', $modelId)
                    ->where('parent_id', $parentid)
                    ->with('single_path', 'parentadmin', 'childrenadmin')
                    ->orderBy('sort_id')->paginate(15);

            }

        }


        $data->appends([
            'lang' => $lang,
            'parent_id' => $parentid,
            'model_id' => $modelId
        ]);



        return view('xadmin.pages.services.list', ['data' => $data, 'listlang' => $lang, 'modelId' => $modelId, 'parent_id' => $parentid]);
    }
    public function servicesSortGet(Request $request)
    {

        $lang = $request->get('lang') ?? 1;
        $modelId = $request->get('model_id') ?? 1;

        $data = Services::where('lang', $lang)
            ->where('model_id', $modelId)
            ->whereNull('parent_id') // Sadece üst kategoriler
            ->with('childrenadmin')
            ->orderBy('sort_id') // Üst kategoriler için sıralama
            ->get();


        return view('xadmin.pages.services.sort', ['data' => $data, 'listlang' => $lang, 'modelId' => $modelId]);
    }




    public function servicesCreateGet(Request $request)
    {
        $modelId = $request->get('model_id');
        $lang = $request->get('lang') ?? 1;
        $parentid = $request->get('parent_id') ?? null;

        $parents = Services::where(['lang' => $lang, 'model_id' => $modelId])->orderByDesc('id')->get();


        return view('xadmin.pages.services.create', [
            'parents' => $parents,
            'modelId' => $modelId,
            'parentid' => $parentid
        ]);
    }



    public function servicesUpdateGet(Request $request)
    {


        $modelId = $request->get('model_id') ?? null;
        $id = $request->get('id') ?? null;
        $lang = $request->get('lang') ?? 1;

        if (!$modelId) {

            return redirect(route('servicesList'));
        }

        $data = Services::where(['id' => $id, 'lang' => $lang])
            ->with('images')
            ->first();


        $parents = Services::where(['lang' => $lang, 'model_id' => $modelId])->orderByDesc('id')->get();


        if (!$data) {
            $defaultData = Services::where(['id' => $id, 'lang' => $this->defaultLang])->first();

            if ($defaultData) {
                $data = $defaultData;
                $data->id = null;
                $data->lang = $lang;
            } else {
                return redirect()->back();
            }
        }

        $locale = Languages::find($lang);
        $mergedExtras = json_decode($data->extra, true) ?? [];




        return view('xadmin.pages.services.update', ['data' => $data, 'mergedExtras' => $mergedExtras, 'locale' => $locale, 'parents' => $parents, 'modelId' => $modelId]);





    }



    public function servicesCreatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|string',
        ], [
            'title.required' => 'Hizmet adı zorunludur.',
            'description.required' => 'Açıklama alanı zorunludur.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }



        $seoService = new SeoService();
        $data = $request->only(['model_id', 'title', 'extra', 'description', 'meta_title', 'meta_description', 'meta_keywords']);
        $data['slug'] = $request->slug ?? $seoService->make_slug($request->title);
        $data['lang'] = Languages::where('is_default', true)->value('id');
        $data['parent_id'] = $request->parent_id ?? null;



        // `extra` verilerini hazırlama
        if ($request->has('extra')) {
            $extra = [];
            foreach ($request->extra as $field) {
                foreach ($field as $name => $value) {
                    $extra[] = [
                        'name' => $name,
                        'value' => $value,
                    ];
                }
            }
            $data['extra'] = json_encode($extra); // JSON formatında kaydet
        } else {
            $data['extra'] = null;
        }



        $service = Services::create($data);


        // Resim işlemleri
        if ($request->images) {
            foreach ($request->images as $index => $image) {

                if ($image) {
                    ServicesImage::create([
                        'service_id' => $service->id,
                        'path' => $image,
                        'is_first' => $index === 0, // İlk resim için
                    ]);
                }
            }
        }

        // Diğer diller için oluştur
        $languages = Languages::where('is_default', false)->get();
        foreach ($languages as $lang) {
            $translatedTitle = $this->translateText($data['title'], $lang->code);
            $translatedDescription = $this->translateText($data['description'], $lang->code);


            $translatedParentId = $request->parent_id ? Services::where('lang_parent_id', $request->parent_id)->value('id') : null;


            $translatedService = $service->replicate();
            $translatedService->title = $translatedTitle;
            $translatedService->description = $translatedDescription;
            $translatedService->parent_id = $translatedParentId;
            $translatedService->lang = $lang->id;
            $translatedService->lang_parent_id = $service->id;
            $translatedService->save();



            if ($request->images) {
                foreach ($request->images as $index => $image) {
                    if ($image) {
                        ServicesImage::create([
                            'service_id' => $translatedService->id,
                            'path' => $image,
                            'is_first' => $index === 0, // İlk resim için
                        ]);
                    }
                }
            }

        }

        return redirect()->route('servicesList', ['model_id' => $request->model_id, 'lang' => 1])->with('success', 'Kayıt başarıyla oluşturuldu.');
    }


    public function servicesUpdatePost(Request $request)
    {

        $id = $request->get('id') ?? null;

        $service = Services::findOrFail($id);


        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {

                    $exists = Services::where('title', $value)
                        ->where('model_id', $request->model_id)
                        ->where('lang', $request->lang)
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($exists) {
                        $fail('Bu kayıt adı zaten mevcut. Lütfen farklı bir hizmet adı girin.');
                    }
                },
            ],
            'description' => 'required|string',
            'slug' => [
                'nullable',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {

                    $exists = Services::where('slug', $value)
                        ->where('model_id', $request->model_id)
                        ->where('lang', $request->lang)
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($exists) {
                        $fail('Bu slug zaten mevcut. Lütfen farklı bir slug girin.');
                    }
                },
            ],
            'meta_title' => [
                'nullable',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {

                    $exists = Services::where('meta_title', $value)
                        ->where('model_id', $request->model_id)
                        ->where('lang', $request->lang)
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($exists) {
                        $fail('Bu meta başlık zaten mevcut. Lütfen farklı bir meta başlık girin.');
                    }
                },
            ],
            'meta_description' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request, $id) {

                    $exists = Services::where('meta_description', $value)
                        ->where('model_id', $request->model_id)
                        ->where('lang', $request->lang)
                        ->where('id', '!=', $id)
                        ->exists();

                    if ($exists) {
                        $fail('Bu meta açıklama zaten mevcut. Lütfen farklı bir meta açıklama girin.');
                    }
                },
            ],
        ], [
            'title.required' => 'Hizmet adı zorunludur.',
            'description.required' => 'Açıklama alanı zorunludur.',
            'slug.required' => 'Slug alanı zorunludur.',
        ]);



        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $seoService = new SeoService();
        $data = $request->only(['title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'statu']);
        $data['slug'] = $request->slug ?? $seoService->make_slug($request->title);
        $data['parent_id'] = $request->parent_id ?? null;


        // `extra` verisini formdan alıp, JSON olarak işliyoruz
        if ($request->has('extra')) {
            $extra = [];
            foreach ($request->extra as $field) {
                foreach ($field as $name => $value) {
                    $extra[] = [
                        'name' => $name,
                        'value' => $value,
                    ];
                }
            }
            $data['extra'] = json_encode($extra); // JSON formatında kaydet
        } else {
            $data['extra'] = null;
        }


        $service->update($data);

        // Resim işlemleri
        $oldImages = ServicesImage::where('service_id', $service->id)->get();
        $anyIsFirst = ServicesImage::where('service_id', $service->id)->where('is_first', true)->count();

        $oldImagePaths = $oldImages->pluck('path')->toArray(); // Eski resim yolları

        // Gelen yeni resim yollarını kontrol et, yoksa boş bir dizi yap
        $newImagePaths = $request->images ?? [];

        // 1. Silinecek resimleri belirle ve sil
        $imagesToDelete = array_diff($oldImagePaths, $newImagePaths);

        if (count($imagesToDelete) > 0) {
            foreach ($imagesToDelete as $pathToDelete) {
                $image = ServicesImage::where('service_id', $service->id)->where('path', $pathToDelete)->first();
                if ($image) {
                    $image->delete();
                }
            }
        }

        // 2. Yeni eklenen resimleri kaydet
        $imagesToAdd = array_diff($newImagePaths, $oldImagePaths);


        foreach ($imagesToAdd as $index => $pathToAdd) {
            if ($pathToAdd) {
                ServicesImage::create([
                    'service_id' => $service->id,
                    'path' => $pathToAdd,
                    'is_first' => $anyIsFirst == 0 && $index == 0 ? true : false
                ]);

            }
        }



        return redirect()->back()->with('success', 'Kayıt başarıyla güncellendi.');
    }
    private function translateText($text, $langCode)
    {
        // Basit bir örnek çeviri işlemi
        return $text . ' (' . strtoupper($langCode) . ')';
    }





    public function servicesDelete(Request $request)
    {
        $id = $request->get('id') ?? null;

        // Servisi al
        $model = Services::findOrFail($id);

        if ($model) {
            $model->delete();

            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }

        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');
    }




    public function servicesDeleteAll(Request $request)
    {
        $id = $request->get('model_id');

        if (!$id) {
            return redirect()->back()->with('error', 'Model ID bulunamadı.');
        }

        // Tüm ilgili servisleri tek seferde sil
        Services::where('model_id', $id)->delete();

        return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
    }




    /* ####### SERVICES ####### */







    /* ####### LANGUAGES ####### */
    public function languagesList()
    {
        $data = Languages::paginate(15);
        return view('xadmin.pages.languages.list', ['data' => $data]);
    }
    public function languagesCreateGet()
    {
        return view('xadmin.pages.languages.create');
    }
    public function languagesUpdateGet($id)
    {
        $data = Languages::find($id);

        if (!$data) {
            return redirect()->back();
        }

        return view('xadmin.pages.languages.update', ['data' => $data]);
    }
    public function languagesUpdatePost(Request $request)
    {

        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                Rule::unique('languages')->ignore($id)
            ],
            'native' => [
                'required',
                'max:2',
                Rule::unique('languages')->ignore($id)
            ],
            'code' => [
                'required',
                'max:10',
                Rule::unique('languages')->ignore($id)
            ],
            'is_default' => 'boolean',
            'statu' => 'boolean'
        ], [
            'name.required' => 'Dil adı zorunludur.',
            'name.max' => 'Dil adı maksimum 255 karakter olmalı.',
            'name.unique' => 'Başlık alanı benzersiz olmalı.',
            'native.required' => 'Native alanı zorunludur.',
            'native.max' => 'Native alanı maksimum 2 karakter olmalı.',
            'native.unique' => 'Native alanı benzersiz olmalı.',
            'code.required' => 'Kod alanı zorunludur.',
            'code.max' => 'Kod maksimum 10 karakter olmalı.',
            'code.unique' => 'Kod alanı benzersiz olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'native', 'code', 'is_default', 'statu']);

        $model = Languages::find($id);
        $model->update($data);

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function languagesCreatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:languages',
            'native' => 'required|max:2|unique:languages',
            'code' => 'required|max:10|unique:languages',
            'is_default' => 'boolean',
            'statu' => 'boolean'
        ], [
            'name.required' => 'Dil adı zorunludur.',
            'name.max' => 'Dil adı maksimum 255 karakter olmalı.',
            'name.unique' => 'Başlık alanı benzersiz olmalı.',
            'native.required' => 'Native alanı zorunludur.',
            'native.max' => 'Native alanı maksimum 2 karakter olmalı.',
            'native.unique' => 'Native alanı benzersiz olmalı.',
            'code.required' => 'Kod alanı zorunludur.',
            'code.max' => 'Kod maksimum 10 karakter olmalı.',
            'code.unique' => 'Kod alanı benzersiz olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'native', 'code', 'is_default', 'statu']);
        $language = Languages::create($data);

        if ($language) {
            return redirect()->back()->with('success', 'Dil başarıyla eklendi.');
        }

        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');
    }
    public function languagesDelete(Request $request)
    {

        $id = $request->id;
        $model = Languages::find($id)->delete();

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    /* ####### LANGUAGES ####### */




    /* ####### LANGUAGE LEVEL ####### */
    public function languagelevelList($listlang = 1)
    {
        $data = LanguageLevel::where('lang', $listlang)->paginate(15);
        return view('xadmin.pages.languagelevel.list', ['data' => $data, 'listlang' => $listlang]);
    }
    public function languagelevelCreateGet()
    {
        return view('xadmin.pages.languagelevel.create');
    }
    public function languagelevelUpdateGet($id, $lang)
    {

        $data = LanguageLevel::where(['id' => $id, 'lang' => $lang])->first();

        if (!$data) {
            $defaultData = LanguageLevel::where(['id' => $id, 'lang' => $this->defaultLang])->first();

            if ($defaultData) {
                $data = $defaultData;
                $data->id = null;
                $data->lang = $lang;
            } else {
                return redirect()->back();
            }
        }

        $locale = Languages::find($lang);
        return view('xadmin.pages.languagelevel.update', ['data' => $data, 'locale' => $locale]);

    }
    public function languagelevelUpdatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => 'Tip adı zorunludur.',
            'title.max' => 'Tip adı maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }


        $data = $request->except('_token');

        if ($request->id) {
            $data['id'] = $request->id;
        }

        $data['lang'] = $request->lang;

        $matchCriteria = [
            'id' => $data['id'] ?? null,
            'lang' => $data['lang']
        ];

        $model = LanguageLevel::updateOrCreate($matchCriteria, $data);

        if ($model) {
            return redirect(route('languagelevelList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function languagelevelCreatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => 'Tip adı zorunludur.',
            'title.max' => 'Tip adı maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $request->post();
        $lang = Languages::where('is_default', true)->first();
        $data['lang'] = $lang->id;
        $model = LanguageLevel::create($data);

        $langs = Languages::where('is_default', false)->get();
        foreach ($langs as $item) {
            $data['lang'] = $item->id;
            $data['lang_parent_id'] = $model->id;
            LanguageLevel::create($data);
        }

        if ($model) {
            return redirect(route('languagelevelList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function languagelevelDelete(Request $request)
    {

        $id = $request->id;
        $model = LanguageLevel::find($id)->delete();


        $model2 = LanguageLevel::where('lang_parent_id', $id)->first();
        if ($model2) {
            $model2->delete();
        }

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    /* ####### LANGUAGE LEVEL ####### */








    /* ####### PAGES ####### */
    public function pagesList($listlang = 1)
    {
        $data = Pages::where('lang', $listlang)->paginate(15);
        return view('xadmin.pages.pages.list', ['data' => $data, 'listlang' => $listlang]);
    }
    public function pagesCreateGet()
    {
        return view('xadmin.pages.pages.create');
    }
    public function pagesUpdateGet($id)
    {
        $data = Pages::find($id);
        if (!$data) {
            return redirect()->back();
        }
        return view('xadmin.pages.pages.update', ['data' => $data]);
    }
    public function pagesUpdatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => 'Tip adı zorunludur.',
            'title.max' => 'Tip adı maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $id = $request->id;
        $data = $request->post();

        $model = Pages::find($id);
        $model->update($data);

        if ($model) {
            return redirect(route('pagesList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function pagesCreatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ], [
            'title.required' => 'Tip adı zorunludur.',
            'title.max' => 'Tip adı maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $request->post();
        $lang = Languages::where('is_default', true)->first();
        $data['lang'] = $lang->id;
        $model = Pages::create($data);

        $langs = Languages::where('is_default', false)->get();
        foreach ($langs as $item) {
            $data['lang'] = $item->id;
            $data['lang_parent_id'] = $model->id;
            Pages::create($data);
        }

        if ($model) {
            return redirect(route('pagesList'))->with('success', 'İşlem başarıyla tamamlandı.');
        }


        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    public function pagesDelete(Request $request)
    {

        $id = $request->id;
        $model = Pages::find($id)->delete();


        $model2 = Pages::where('lang_parent_id', $id)->first();
        if ($model2) {
            $model2->delete();
        }

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    /* ####### PAGES ####### */








    /* ####### MESSAGES ####### */
    public function messagesList()
    {
        $data = Contact::paginate(15);
        return view('xadmin.pages.contact.list', ['data' => $data]);
    }
    public function messagesShow($id)
    {
        $data = Contact::find($id);

        $data->read = true;
        $data->save();

        return view('xadmin.pages.contact.show', ['data' => $data]);
    }

    public function messagesDelete($id)
    {


        $model = Contact::find($id)->delete();

        if ($model) {
            return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }
    /* ####### MESSAGES ####### */










    /* ####### SETTINGS ####### */
    public function settingsIndex()
    {

        $model = Settings::first();




        if (!$model) {

            $newData = array(
                array(
                    'name' => 'Facebook',
                    'value' => '',
                    'description' => 'Facebook sayfa linki'
                )
            );

            $new = array(
                'data' => $newData
            );

            Settings::create($new);
        }


        $data = collect($model->data);


        return view('xadmin.pages.settings.index', ['data' => $data]);
    }
    public function settingsCreateGet()
    {
        return view('xadmin.pages.settings.create');
    }
    public function settingsUpdatePost(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'value' => 'required',
        ], [
            'name.required' => 'Eylem zorunludur.',
            'value.required' => 'Durum zorunludur.',
            'name.max' => 'Eylem maksimum 255 karakter olmalı.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }


        $data = array(
            'name' => $request->name,
            'value' => Helper::turkishcharacters($request->value),
            'description' => $request->description ?? ''
        );

        $model = Settings::first();


        if ($model) {
            $existingData = $model->data;


            $existingData[] = $data;


            $model->data = $existingData;
            $model->save();
        } else {
            throw new \Exception('Settings model not found.');
        }

        if ($model) {
            return redirect(route('settingsIndex'))->with('success', 'İşlem başarıyla tamamlandı.');
        }

        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }


    public function settingsDelete($id)
    {
        $model = Settings::first();

        if (!$model) {
            return redirect()->back()->with('error', 'Model bulunamadı.');
        }

        $data = $model->data;

        if (!is_array($data)) {
            return redirect()->back()->with('error', 'Veri işlenemedi.');
        }

        if (array_key_exists($id, $data)) {
            unset($data[$id]);


            $model->data = $data;

            $model->save();

            return redirect()->back()->with('success', 'Ayar başarıyla silindi.');
        }

        return redirect()->back()->with('error', 'Belirtilen ID bulunamadı.');
    }


    public function settingsUpdateSet(Request $request)
    {




        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
            ], [
                'avatar.image' => 'Avatar bir resim dosyası olmalıdır.',
                'avatar.mimes' => 'Avatar sadece jpeg, png, jpg formatlarında olabilir.',
                'avatar.max' => 'Avatar dosyası maksimum 5048 KB olmalıdır.',
            ]);


            if ($validator->fails()) {
                return back()->withErrors($validator);
            }



        }


        $model = Settings::first();
        $collect = collect($model->data);
        $currentData = $collect[$request->id];




        $data = [
            'name' => $request->name ?? $currentData['name'],
            'value' => Helper::turkishcharacters($request->value) ?? Helper::turkishcharacters($currentData['value']),
            'description' => $request->description ?? $currentData['description'] ?? ''
        ];




        if ($model) {

            if ($request->hasFile('image')) {
                $avatar = $request->file('image');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('covers'), $avatarName);
                $data['value'] = $avatarName;


                if (file_exists('covers/' . $model->image)) {
                    Storage::delete('covers/' . $model->image);
                }
            }


            $existingData = $model->data;


            $existingData[$request->id] = $data;

            $model->data = $existingData;
            $model->save();
        } else {
            throw new \Exception('Settings model not found.');
        }

        if ($model) {
            return redirect(route('settingsIndex'))->with('success', 'İşlem başarıyla tamamlandı.');
        }

        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');

    }

    public function settingsUpdateGet($id)
    {
        $model = Settings::first();

        if (!$model) {
            return redirect()->back();
        }

        $item = $model->data[$id];


        if ($model) {
            return view('xadmin.pages.settings.update', ['data' => $item, 'id' => $id]);
        }
        return redirect()->back()->with('error', 'Bir şeyler ters gitti, tekrar deneyin.');


    }

    /* ####### SETTINGS ####### */








    public function userCreate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
        ], [
            'name.required' => 'Ad alanı zorunludur.',
            'name.max' => 'Ad maksimum 255 karakter olmalı.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.max' => 'Soyad maksimum 255 karakter olmalı.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'phone.unique' => 'Bu telefon numarası zaten kayıtlı.',
            'email.required' => 'Email alanı zorunludur.',
            'email.email' => 'Geçerli bir email adresi olmalı.',
            'email.max' => 'Email adresi maksimum 255 karakter olmalı.',
            'email.unique' => 'Bu email adresi zaten kayıtlı.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalı.',
            'avatar.mimes' => 'Resim uzantısı sadece jpeg, png, jpg, gif olmalı.',
            'avatar.max' => 'Resim maksimum 10MB olmalı.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($validator);
        }



        $data = $request->post();
        $countyIds = $request->counties_id;


        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = Helper::uploadImage($file, 800, 480, 300);
            $data['avatar'] = $fileName;
        }

        $user = User::create($data);



        return back()->withErrors([
            'name' => 'Ad alanı zorunludur.',
            'surname' => 'Soyad alanı zorunludur.',
            'phone' => 'Telefon alanı zorunludur.',
            'email' => 'Email alanı zorunludur.',
            'password' => 'Şifre alanı zorunludur.',
            'city_id' => 'İl zorunludur.',
            'counties_id' => 'İlçe zorunludur.',
        ])->withInput([
                    'name' => $request->input('name'),
                    'surname' => $request->input('surname'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email')
                ]);
    }

    public function userEdit($id)
    {

        $data = User::where('id', $id)->with('counties')->first();



        return view('xadmin.pages.users.edit', ['data' => $data]);
    }
    public function userNew()
    {

        return view('xadmin.pages.users.new');
    }
    public function userUpdate(Request $request)
    {


        $model = User::findorFail($request->id);


        // Validation kuralları
        $rules = [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required|unique:users,phone,' . $model->id,
            'email' => 'required|email|unique:users,email,' . $model->id . '|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048'
        ];

        if ($model->isadmin) {
            $rules = [
                'name' => 'required|max:255',
                'surname' => 'required|max:255',
                'phone' => 'required|unique:users',
                'email' => 'required|email|unique:users|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048'
            ];
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'Ad alanı zorunludur.',
            'name.max' => 'Ad maksimum 255 karakter olmalı.',
            'surname.required' => 'Soyad alanı zorunludur.',
            'surname.max' => 'Soyad maksimum 255 karakter olmalı.',
            'phone.required' => 'Telefon alanı zorunludur.',
            'phone.unique' => 'Bu telefon numarası zaten kayıtlı.',
            'email.required' => 'Email alanı zorunludur.',
            'email.email' => 'Geçerli bir email adresi olmalı.',
            'email.max' => 'Email adresi maksimum 255 karakter olmalı.',
            'email.unique' => 'Bu email adresi zaten kayıtlı.',
            'avatar.mimes' => 'Resim uzantısı sadece jpeg, png, jpg, gif olmalı.',
            'avatar.max' => 'Resim maksimum 10MB olmalı.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($validator);
        }



        $data = $request->post();

        // $countyIds = $request->counties_id;

        // $model->counties()->sync($countyIds);



        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = Helper::uploadImage($file, 800, 480, 300);
            $data['avatar'] = $fileName;
        }

        $user = $model->update($data);

        if ($user) {
            return redirect()->back()->with('success', 'Kullanıcı başarıyla güncellendi.');
        }

        return back()->withErrors([
            'name' => 'Ad alanı zorunludur.',
            'surname' => 'Soyad alanı zorunludur.',
            'phone' => 'Telefon alanı zorunludur.',
            'email' => 'Email alanı zorunludur.',
            'email.unique' => 'Bu email başka kullanıcıda kayıtlı.',
            'city_id' => 'İl zorunludur.',
            'countien_id' => 'İlçe zorunludur.',
        ])->withInput([
                    'name' => $request->input('name'),
                    'surname' => $request->input('surname'),
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email')
                ]);
    }

    public function set_user_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);


        $isUpdate = User::whereId($request->id)->update([
            'password' => Hash::make($request->password)
        ]);

        if ($isUpdate) {
            return redirect()->back()->with('success3', 'Şifre başarıyla değiştirildi');
        } else {
            return redirect()->back()->with('error', 'Şifre değiştirilemedi. Tekrar deneyin.');
        }
    }

    public function userDestroy($id)
    {

        $exitst = User::findorFail($id);
        if ($exitst) {
            $result = User::destroy($id);
            if ($result) {
                return redirect()->back()->with('success', 'Kullanıcı silme başarılı');
            } else {
                return redirect()->back()->with('error', 'Kullanıcı silme başarısız');
            }
        } else {
            return redirect()->back()->with('error', 'Kullanıcı bulunamadı');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/xadmin');
    }
}
