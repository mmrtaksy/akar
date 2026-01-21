<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Languages;
use App\Models\Services;
use App\Models\ServicesImage;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\App;

class ApiController extends Controller
{



    public function getImages(Request $request)
    {
        $directory = public_path('uploads'); // uploads klasörü
        $imageFiles = array_filter(File::files($directory), function ($file) {
            return in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        });

        $limit = 30;

        // Dosyaların ismini ve modifikasyon zamanlarını al
        $fileDetails = [];
        foreach ($imageFiles as $file) {
            $fileDetails[] = [
                'name' => $file->getFilename(),
                'timestamp' => $file->getMTime(), // Dosyanın son değiştirilme zamanı
            ];
        }

        // Modifikasyon zamanına göre sıralama
        usort($fileDetails, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp']; // En son değiştirilen önce gelsin
        });

        // Son 3 resmi al
        $latestImages = array_slice($fileDetails, 0, $limit);

        // Yalnızca resim isimlerini döndür
        $latestImageNames = array_map(function ($file) {
            return $file['name'];
        }, $latestImages);

        return response()->json($latestImageNames);
    }

    public function transferImages(Request $request)
    {
        $id = $request->get('id');
        $current = Services::findOrFail($id);
        $dataTR = Services::where('id', $current->lang_parent_id)->with('images')->first();
        $images = $dataTR->images;
        return $images;
    }

    public function transferMetaRoute(Request $request)
    {
        $id = $request->get('id');
        $current = Services::findOrFail($id);
        $dataTR = Services::where('id', $current->lang_parent_id)->with('images')->first();
        $metaTR = array(
            'meta_title' => $dataTR->meta_title,
            'meta_description' => $dataTR->meta_description,
            'meta_keywords' => $dataTR->meta_keywords,
        );

        return $metaTR;
    }



    public function uploadImages(Request $request)
    {
        $uploadedFiles = $request->file('images');
        $savedFileNames = [];

        if ($uploadedFiles) {
            foreach ($uploadedFiles as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName);
                $savedFileNames[] = $fileName; // Kaydedilen dosyanın adını saklayın
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Resimler başarıyla yüklendi.',
            'files' => $savedFileNames,
        ]);
    }


    public function serviceDeleteImage(Request $request)
    {

        $path = $request->id;

        // Resim dosyasının fiziksel olarak silinmesi
        $filePath = public_path('uploads/' . $path); // Dosya yolu
        if (file_exists($filePath)) {
            unlink($filePath); // Dosyayı sil
        }


        $model = ServicesImage::where('path', $path)->get();

        foreach ($model as $item) {
            $item->delete();
        }

        return response()->json(['statu' => true]);

    }

    public function serviceSetCoverImage(Request $request)
    {



        ServicesImage::where('service_id', $request->service_id)->update(['is_first' => false]); // Tümünü sıfırla

        $model = ServicesImage::where('id', $request->id)->first();
        $model->is_first = true;
        $model->save();

        return response()->json(['statu' => true]);
    }

    public function serviceSetSort(Request $request)
    {
        $order = $request->input('order'); // Payload verisini al
        if ($order) {
            $this->updateOrder($order);
            return response()->json(['status' => true, 'message' => 'Order updated successfully.']);
        }

        return response()->json(['status' => false, 'message' => 'No order data received.']);
    }




    private function updateOrder($items, $parentId = null)
    {
        foreach ($items as $index => $item) {
            // İlgili kategoriyi bul ve güncelle
            $service = Services::find($item['id']);
            if ($service) {
                $service->parent_id = $parentId; // Üst kategori ID
                $service->sort_id = $index;     // Sıra değeri
                $service->save();
            }

            // Eğer alt kategoriler varsa, recursive olarak güncelle
            if (isset($item['children']) && is_array($item['children'])) {
                $this->updateOrder($item['children'], $item['id']);
            }
        }
    }






    public function translations(Request $request)
    {
        $locale = $request->get('lang', 'tr');

        if (!in_array($locale, ['en', 'tr'])) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        Cache::put('locale', $locale, now()->addMinutes(60)); // 1 saat boyunca cache’de tut

        $currentLangId = Languages::where('native', $locale)->value('id');
        $translation = Translation::select('key', 'value')->where('languages_id', $currentLangId)->get();

        return response()->json($translation);
    }


    public function menus()
    {
        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->value('id'); // Tek değer almak için `value()`
        $model = 2;

        $data = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->with([
                'children' => function ($query) use ($langId) {
                    $query->where('lang', $langId)
                        ->where('statu', 1)
                        ->orderBy('sort_id');
                }
            ])
            ->orderBy('sort_id', 'asc')
            ->get()
            ->makeHidden([
                'single_path',
                'parent',
                'lang_parent_id',
                'lang',
                'parent_id',
                'model_id',
                'sort_id',
                'extra',
                'description',
                'created_at',
                'updated_at'
            ]);

        // Children ilişkisine de makeHidden uygulamak için döngüyle her elemana uygula
        $data->each(function ($item) {
            $item->children->each->makeHidden([
                'id',
                'single_path',
                'parent',
                'lang_parent_id',
                'lang',
                'parent_id',
                'model_id',
                'sort_id',
                'extra',
                'description',
                'created_at',
                'updated_at'
            ]);
        });

        return response()->json($data);
    }


    public function highlight_services()
    {
        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->value('id'); // Tek değer almak için `value()`
        $model = 9;

        $data = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden([
                'single_path',
                'parent',
                'slug',
                'lang_parent_id',
                'lang',
                'parent_id',
                'model_id',
                'sort_id',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'created_at',
                'updated_at'
            ])
            ->map(function ($service) {
                $service->extra = $service->extra ? json_decode($service->extra, true)[0] : null;
                return $service;
            });


        return response()->json($data);
    }




    public function slides()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 3;


        $langId = Languages::where('native', $locale)->pluck('id');

        $data = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden([
                'id',
                'single_path',
                'parent',
                'lang_parent_id',
                'children',
                'slug',
                'lang',
                'parent_id',
                'model_id',
                'sort_id',
                'extra',
                'description',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'created_at',
                'updated_at'
            ])
            ->map(function ($service) {
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;
                return $service;
            });

        return response()->json($data);
    }

    public function services(Request $request)
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 2;
        $parentId = $locale == 'tr' ? 20 : 21;
        $limit = $request->get('limit') ?? 30;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->where('parent_id', $parentId)
            ->where('statu', 1)
            ->where('model_id', $model)
            ->with('single_path')
            ->orderBy('sort_id')
            ->limit($limit)
            ->get()
            ->makeHidden(['single_path', 'lang_parent_id', 'lang', 'parent_id', 'model_id', 'sort_id', 'statu', 'created_at', 'updated_at'])
            ->map(function ($service) {
                $service->date = $service->created_at->translatedFormat('M d, Y');

                $service->description = Helper::turkishcharacters($service->description);
                $extraParse = $service->extra ? json_decode($service->extra, true) : [];
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;

                $extra = [];
                if (!empty($extraParse)) {
                    foreach ($extraParse as $item) {
                        if (isset($item['name']) && isset($item['value'])) {
                            $extra[$item['name']] = $item['value'];
                        }
                    }
                }



                $service->extra = $extra;

                return $service;
            });

        return response()->json($data);
    }



    public function services_single($slug)
    {
        if (!$slug) {
            return response()->json(null);
        }

        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');

        $service = Services::where('lang', $langId)
            ->where('statu', 1)
            ->where('slug', $slug)
            ->first();

        if (!$service) {
            return response()->json(null);
        }

        $service->makeHidden('single_path', 'sort_id', 'lang', 'statu', 'parent_id', 'model_id', 'id', 'lang_parent_id');

        if (!$service) {
            return response()->json(null);
        }

        $service->date = $service->created_at->translatedFormat('M d, Y');

        $service->description = Helper::turkishcharacters($service->description);
        $extraParse = $service->extra ? json_decode($service->extra, true) : [];
        $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;

        $extra = [];
        if (!empty($extraParse)) {
            foreach ($extraParse as $item) {
                if (isset($item['name']) && isset($item['value'])) {
                    $extra[$item['name']] = $item['value'];
                }
            }
        }

        $service->extra = $extra;

        if (!$service) {
            return response()->json(null);
        }


        return response()->json($service);
    }

    public function testimonial()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 8;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::select('id', 'title', 'description', 'created_at')
            ->where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden(['single_path', 'parent', 'children', 'lang_parent_id', 'lang', 'parent_id', 'model_id'])
            ->map(function ($service) {

                $service->date = $service->created_at->translatedFormat('M d, Y');
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;
                return $service;
            });

        return response()->json($data);
    }


    public function brands()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 4;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->with('images')
            ->orderBy('sort_id')
            ->first();

        $data = $data->images->map(function ($item) {
            $item->full_image_path = $item->path ? asset('uploads/' . $item->path) : null;
            return $item;
        });

        return response()->json($data);
    }

    public function stories()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 5;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->whereNotNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->limit(4)
            ->get()
            ->makeHidden(['single_path', 'parent', 'children', 'lang_parent_id', 'lang', 'parent_id', 'model_id'])
            ->map(function ($service) {
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;
                $service->category = $service->parent->title;
                return $service;
            });


        return response()->json($data);
    }



    public function teams()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 6;
        $limit = 6;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::select('id', 'title', 'description')->where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->limit($limit)
            ->get()
            ->makeHidden(['single_path', 'parent', 'children', 'lang_parent_id', 'lang', 'parent_id', 'model_id'])
            ->map(function ($service) {
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;
                return $service;
            });


        return response()->json($data);
    }

    public function locations()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 10;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::select('id', 'title', 'description')->where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden(['single_path', 'parent', 'children', 'lang_parent_id', 'lang', 'parent_id', 'model_id'])
            ->map(function ($service) {
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;
                return $service;
            });


        return response()->json($data);
    }



    public function faq()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 11;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::select('id', 'title', 'description')->where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden(['single_path', 'parent', 'children', 'lang_parent_id', 'lang', 'parent_id', 'model_id'])
            ->map(function ($service) {
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;
                $service->description = Helper::turkishcharacters($service->description);
                return $service;
            });


        return response()->json($data);
    }


    public function blogs_home()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 1;
        $limit = 3;

        $metaData = collect(['title' => 'Blog', 'image' => null]);
        $metaData = (object) $metaData->all();


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->whereNotNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->with('children')
            ->orderBy('sort_id')
            ->limit($limit)
            ->get()
            ->makeHidden(['single_path', 'parent', 'children', 'lang_parent_id', 'lang', 'parent_id', 'model_id'])
            ->map(function ($item) {
                $item->full_image_path = $item->single_path ? asset('uploads/' . $item->single_path->path) : null;
                $item->category = $item->parent->title;
                $item->date = $item->created_at->translatedFormat('M d, Y');
                $item->category_slug = $item->parent->slug;

                $extraParse = $item->extra ? Helper::isArray($item->extra) : [];
                $extra = [];
                if (!empty($extraParse)) {
                    foreach ($extraParse as $set) {
                        if (isset($set['name']) && isset($set['value'])) {
                            $extra[$set['name']] = $set['value'];
                        }
                    }
                }
                $item->extra = $extra;



                return $item;
            });



        return response()->json($data);
    }


    public function blogs()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 1;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->whereNotNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->with('single_path', 'parent')
            ->orderBy('sort_id')
            ->get()
            ->makeHidden(['single_path', 'lang_parent_id', 'lang', 'parent_id', 'parent', 'model_id', 'sort_id', 'statu', 'created_at', 'updated_at'])
            ->map(function ($item) {

                $item->date = $item->created_at->translatedFormat('M d, Y');

                $item->description = Helper::turkishcharacters($item->description);

                $item->full_image_path = $item->single_path ? asset('uploads/' . $item->single_path->path) : null;
                $item->category = $item->parent->title;
                $item->category_slug = $item->parent->slug;

                $extraParse = $item->extra ? Helper::isArray($item->extra) : [];
                $extra = [];
                if (!empty($extraParse)) {
                    foreach ($extraParse as $set) {
                        if (isset($set['name']) && isset($set['value'])) {
                            $extra[$set['name']] = $set['value'];
                        }
                    }
                }
                $item->extra = $extra;

                return $item;
            });

        return response()->json($data);
    }

    public function blogsCategory($category)
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 1;


        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::where('lang', $langId)
            ->whereNotNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->whereHas('parent', function ($query) use ($category) {
                $query->where('slug', $category);  // parent slug ile eşleşenleri al
            })
            ->with('single_path', 'parent')
            ->orderBy('sort_id')
            ->get()
            ->makeHidden(['single_path', 'lang_parent_id', 'lang', 'parent_id', 'parent', 'model_id', 'sort_id', 'statu', 'created_at', 'updated_at'])
            ->map(function ($item) {

                $item->date = $item->created_at->translatedFormat('M d, Y');

                $item->description = Helper::turkishcharacters($item->description);

                $item->full_image_path = $item->single_path ? asset('uploads/' . $item->single_path->path) : null;
                $item->category = $item->parent->title;
                $item->category_slug = $item->parent->slug;

                $extraParse = $item->extra ? Helper::isArray($item->extra) : [];
                $extra = [];
                if (!empty($extraParse)) {
                    foreach ($extraParse as $set) {
                        if (isset($set['name']) && isset($set['value'])) {
                            $extra[$set['name']] = $set['value'];
                        }
                    }
                }
                $item->extra = $extra;

                return $item;
            });

        return response()->json($data);
    }


    public function blog_single($slug)
    {
        if (!$slug) {
            return response()->json(null);
        }

        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');

        $item = Services::where('lang', $langId)
            ->where('statu', 1)
            ->where('slug', $slug)
            ->first()
            ->makeHidden('single_path', 'sort_id', 'lang', 'statu', 'parent_id', 'model_id', 'id', 'lang_parent_id', 'parent', 'created_at', 'updated_at');

        if (!$item) {
            return response()->json(null);
        }


        $item->date = $item->created_at->translatedFormat('M d, Y');

        $item->description = Helper::turkishcharacters($item->description);
        $extraParse = $item->extra ? json_decode($item->extra, true) : [];
        $item->full_image_path = $item->single_path ? asset('uploads/' . $item->single_path->path) : null;
        $item->category = $item->parent()->select('title', 'slug')->first();

        $extraParse = $item->extra ? Helper::isArray($item->extra) : [];
        $extra = [];
        if (!empty($extraParse)) {
            foreach ($extraParse as $set) {
                if (isset($set['name']) && isset($set['value'])) {
                    $extra[$set['name']] = $set['value'];
                }
            }
        }
        $item->extra = $extra;


        return response()->json($item);
    }

    public function menu($type)
    {

        if (!$type) {
            return response()->json(null);
        }

        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');
        $model = 2;


        $data = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('model_id', $model)
            ->where('id', $type)
            ->orWhere('lang_parent_id', $type)
            ->orderBy('sort_id', 'asc')
            ->first();


        if (!$data) {
            return response()->json(null);
        }

        $data = $data->makeHidden(['model_id', 'parent_id', 'lang', 'lang_parent_id', 'created_at', 'updated_at', 'sort_id']);

        $data->description = Helper::turkishcharacters($data->description);
        $extraParse = $data->extra ? json_decode($data->extra, true) : [];
        $data->full_image_path = $data->single_path ? asset('uploads/' . $data->single_path->path) : null;

        $data->gallery = $data->images
            ->filter(function ($item) {
                return !$item->is_first; // is_first == 0 olanları filtrele
            })
            ->map(function ($item) {
                $item->full_image_path = asset('uploads/' . $item->path);
                return $item;
            })
            ->values() // Boş indexleri sıfırdan düzenler
            ->toArray(); // Sonucu array olarak döndürür




        $extra = [];
        if (!empty($extraParse)) {
            foreach ($extraParse as $item) {
                if (isset($item['name']) && isset($item['value'])) {
                    $extra[$item['name']] = $item['value'];
                }
            }
        }

        $data->extra = $extra;



        return response()->json($data);
    }

    public function page($id)
    {

        if (!$id) {
            return response()->json(null);
        }

        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');

        $data = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $id)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden(['model_id', 'parent_id', 'lang', 'lang_parent_id', 'single_path', 'created_at', 'updated_at', 'sort_id'])
            ->map(function ($service) {
                $service->date = $service->created_at->translatedFormat('M d, Y');

                $service->description = Helper::turkishcharacters($service->description);
                $extraParse = $service->extra ? json_decode($service->extra, true) : [];
                $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;

                $extra = [];
                if (!empty($extraParse)) {
                    foreach ($extraParse as $item) {
                        if (isset($item['name']) && isset($item['value'])) {
                            $extra[$item['name']] = $item['value'];
                        }
                    }
                }



                $service->extra = $extra;

                return $service;
            });






        if (!$data) {
            return response()->json(null);
        }


        return response()->json($data);
    }


    public function page_first($id)
    {

        if (!$id) {
            return response()->json(null);
        }

        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');

        $service = Services::where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $id)
            ->orderBy('sort_id')
            ->first()
            ->makeHidden(['model_id', 'parent_id', 'lang', 'lang_parent_id', 'single_path', 'created_at', 'updated_at', 'sort_id']);

        $service->date = $service->created_at->translatedFormat('M d, Y');

        $service->description = Helper::turkishcharacters($service->description);
        $extraParse = $service->extra ? json_decode($service->extra, true) : [];
        $service->full_image_path = $service->single_path ? asset('uploads/' . $service->single_path->path) : null;

        $extra = [];
        if (!empty($extraParse)) {
            foreach ($extraParse as $item) {
                if (isset($item['name']) && isset($item['value'])) {
                    $extra[$item['name']] = $item['value'];
                }
            }
        }

        $service->extra = $extra;

        if (!$service) {
            return response()->json(null);
        }


        return response()->json($service);
    }




    public function sectors_home()
    {

        $locale = Cache::get('locale', config('app.locale'));
        $model = 13;
        $limit = 30;
        $chunk = 6;



        $langId = Languages::where('native', $locale)->pluck('id');
        $data = Services::select('title')
            ->where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $model)
            ->orderBy('sort_id')
            ->limit($limit)
            ->get()
            ->chunk($chunk)
            ->map(function ($chunk) {
                return $chunk->values(); // İç içe dizilerin indekslerini sıfırlıyoruz
            })
            ->values();




        return response()->json($data);
    }



    public function terms()
    {


        $modelId = 17;
        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');


        $select = [
            'title',
            'slug',
            'extra',
            'created_at',
        ];

        $data = Services::select($select)
            ->where('lang', $langId)
            ->whereNull('parent_id')
            ->where('statu', 1)
            ->where('model_id', $modelId)
            ->orderBy('sort_id')
            ->get()
            ->makeHidden('created_at')
            ->map(function ($service) {
                $service->date = $service->created_at->translatedFormat('M d, Y');
                $extraParse = $service->extra ? json_decode($service->extra, true) : [];

                $extra = [];
                if (!empty($extraParse)) {
                    foreach ($extraParse as $item) {
                        if (isset($item['name']) && isset($item['value'])) {
                            $extra[$item['name']] = $item['value'];
                        }
                    }
                }



                $service->extra = $extra;

                return $service;
            });






        if (!$data) {
            return response()->json(null);
        }

        $dataArr = [
            'cookie' => $data[0] ?? null,
            'privacy' => $data[1] ?? null
        ];


        return response()->json($dataArr);
    }

    public function search(Request $request)
    {


        $modelId = 17;
        $locale = Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->pluck('id');

        $q = $request->get('q');

        if (!$q) {
            return response()->json(null);
        }

        $select = [
            'title',
            'slug',
            'parent_id',
        ];

        $data = Services::select($select)
            ->where('lang', $langId)
            ->whereNotNull('parent_id')
            ->where('statu', 1)
            ->where('title', 'LIKE', '%' . $q . '%')
            ->where('model_id', 1)
            ->with('parent')
            ->orderBy('sort_id')
            ->limit(20)
            ->get()
            ->makeHidden('parent')
            ->map(function ($item) use ($locale) {

                $item->full_url = $item->parent->slug . '/' . $item->slug;

                return $item;
            });






        if (!$data) {
            return response()->json(null);
        }



        return response()->json($data);
    }


    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subject' => 'nullable|max:100',
            'email' => 'required|email',
            'message' => 'required|max:1000',
            'terms' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'title.required' => __('validation.name.required'),
            'title.max' => __('validation.name.max'),
            'subject.max' => __('validation.subject.max'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'message.required' => __('validation.message.required'),
            'message.max' => __('validation.message.max'),
            'g-recaptcha-response.required' => __('validation.captcha.required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['statu' => 0], 200);
        }

        $data = $request->post();

        $recaptcha = $request->input('g-recaptcha-response');
        $secret_key = env('GOOGLE_RECAPTCHA_SECRET');

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;

        $response = file_get_contents($url);

        $response = json_decode($response);


        $data = $request->post();

        if ($response->success == true) {
            Contact::create($data);
            return response()->json(['statu' => 1], 200);
        } else {
            return response()->json(['statu' => 0], 200);
        }


    }


}

