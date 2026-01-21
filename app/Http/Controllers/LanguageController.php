<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
      
        $q = $request->get('q') ?? null;


        $languages = Languages::all();

        $limit = 5;

        $data = $languages->map(function ($language) use ($q, $limit) {
            $translationsQuery = $language->translations();
        
            if ($q) {
                $limit = 100;
                $translationsQuery->where(function ($query) use ($q) {
                    $query->where('key', 'like', "%{$q}%")
                          ->orWhere('value', 'like', "%{$q}%");
                });
            }
        
            return [
                'language' => $language,
                'translations' => $translationsQuery->orderByDesc('id')->paginate($limit),
            ];
        });
 

        return view('xadmin.pages.translate.index', compact('data'));
    }
 
    
    public function createTranslateGet()
    { 
        return view('xadmin.pages.translate.create');
    }
    
    
    public function editTranslateGet($id)
    { 
        $data = Translation::findOrFail($id);
        return view('xadmin.pages.translate.edit', ['data' => $data, 'id' => $id]);
    }
    
  

    public function createTranslatePost(Request $request)
    {
 

        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'value' => 'required|string'
        ], [
            'key.required' => 'Key zorunludur.', 
            'value.required' => 'Çeviri alanı zorunludur.', 
        ]);

        $langs = Languages::all();

        $data = $request->post();

        foreach ($langs as $item) {
            $data['languages_id'] = $item->id;
            Translation::create($data);
        }
        return redirect(route('translate_index'))->with('success', 'Çeviri başarıyla eklendi.');
    }
 
        public function updateTranslatePost(Request $request)
        {
            $translation = Translation::findOrFail($request->id);
        
            // Çeviri kaydını güncelle
            $translation->update($request->only('key', 'value'));
        
            // Eğer 'next' parametresi varsa ve dil ID'si 2 ise
            if ($request->next) {
                if ($translation->languages_id == 2) {
                    // Bir sonraki kaydı bul
                    $nextTranslation = Translation::where('id', '>', $translation->id)
                        ->where('languages_id', 2)
                        ->orderBy('id', 'asc')
                        ->first();
        
                    // Eğer bir sonraki kayıt varsa ona yönlendir, yoksa index sayfasına yönlendir
                    if ($nextTranslation) {
                        return redirect(route('translate.edit', ['id' => $nextTranslation->id]))
                            ->with('success', 'Çeviri başarıyla güncellendi. Bir sonraki çeviriye geçtiniz.')->withInput();
                    }
                }
            }
        
            // Eğer bir sonraki kayıt yoksa veya 'next' parametresi yoksa index sayfasına yönlendir
            return redirect(route('translate_index'))->with('success', 'Çeviri başarıyla güncellendi.');
        }
    
 

    public function deleteTranslation($id)
    {
        $mod = Translation::findOrFail($id);
        
        Translation::where('key', $mod->key)->delete();

        return redirect(route('translate_index'))->with('success', 'Çeviri başarıyla silindi.');
    }
}
