<?php

namespace App\Helpers;


use App\Models\Languages;
use App\Models\Pages;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Str;
use App\Models\Seo;
use App\Models\Contact;
use App\Models\Settings;
use App\Models\Services;
use App\Models\PanelMenu;
use App\Models\Translation;

class Helper
{


    public static function panelMenu($id = null)
    {
       
        $data = PanelMenu::all();
        

        if ($id) {
            foreach ($data as $item) {
                if ($item['id'] == $id) {
                    return $item;
                }
            }

            return null;
        }

        // ID verilmezse tüm veriyi döndür
        return $data;
    }

    public static function turkishcharacters($string)
    {

        $string = str_replace('&ndash;', '–', $string);
        $string = str_replace('&ccedil;', 'ç', $string);
        $string = str_replace('&yacute;', 'ı', $string);
        $string = str_replace('&Ccedil;', 'Ç', $string);
        $string = str_replace('&Ouml;', 'Ö', $string);
        $string = str_replace('&Yacute;', 'Ü', $string);
        $string = str_replace('&ETH;', 'Ğ', $string);
        $string = str_replace('&THORN;', 'Ş', $string);
        $string = str_replace('&Yacute;', 'İ', $string);
        $string = str_replace('&ouml;', 'ö', $string);
        $string = str_replace('&thorn;', 'ş', $string);
        $string = str_replace('&eth;', 'ğ', $string);
        $string = str_replace('&uuml;', 'ü', $string);
        $string = str_replace('&uum', 'ü', $string);
        $string = str_replace('&Uuml;', 'Ü', $string);
        $string = str_replace('&yacute;', 'ı', $string);
        $string = str_replace('&amp;', '&', $string);
        $string = str_replace('&rsquo;', "'", $string);
        $string = str_replace('&nbsp;', ' ', $string);
        $string = str_replace('&#39;', "'", $string);

        return $string;
    }

    public static function getExtra($extra, $key){
        return collect(json_decode($extra, true))->where('name', $key)->first()['value'] ?? '';
    }
    public static function slugify($text)
    {
        // Türkçe karakterleri eşleme
        $turkce = array('ş', 'Ş', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'Ç', 'ç');
        $english = array('s', 'S', 'i', 'I', 'g', 'G', 'u', 'U', 'o', 'O', 'C', 'c');
        $text = str_replace($turkce, $english, $text);

        // Diğer temizleme işlemleri
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        return $text;
    }

    public static function getPage($id, $linkOnly = false){
        $lang = app()->getLocale();
        $currentLangId = Languages::where('native', $lang)->value('id');
       
        $page = Services::where(['id' => $id, 'lang_parent_id' => null, 'lang' => $currentLangId])->first();


        if(!$page){
            
            $page = Services::where(['lang_parent_id' => $id, 'lang' => $currentLangId])->first();
            if(!$page){
                return "";
            }
        }


        $link = self::localizedRoute('page_show', ['slug' => $page->slug]);

        if($linkOnly){
            return $link;
        }
        return '<a href="'.$link.'" target="_blank" rel="noopener">'.$page->title.'</a>';
    }

    public static function isArray($data)
    {
        return is_array($data) ? $data : json_decode($data, true);
    }

    public static function Langs()
    {
        return Languages::get();
    }

    /* ___________ LOCALE CONFIG ___________ */
    public static function getLocaleFromUrl()
    {
        $locale = request()->segment(1);
        return in_array($locale, ['en', 'tr']) ? $locale : config('app.locale');
    }

    public static function localizedRoute($name, $parameters = [], $absolute = true)
    {
        $parameters = array_merge($parameters, ['locale' => app()->getLocale()]);
        return route($name, $parameters, $absolute);
    }

    /* ___________ LOCALE CONFIG ___________ */

    public static function getMenus($type, $model_id, $limit = null)
    {
        $locale = app()->getLocale();
        $langId = Languages::where('native', $locale)->value('id');

        // Model isimlendirme mantığını tanımlayın
        $modelNamespace = 'App\\Models\\'; // Model'lerinizin namespace'i
        $modelName = $modelNamespace . ucfirst($type); // Örn: 'services' -> 'Services'

        if (class_exists($modelName)) {
            return $modelName::where('lang', $langId)
                ->where('model_id', $model_id)
                ->where('statu', true)
                ->whereNull('parent_id')
                ->orderBy('sort_id')
                ->limit($limit)
                ->get();
        }

        throw new \Exception("Model $modelName bulunamadı.");
    }






    
    public static function getSubService($id, $modelId = 1, $limit = null)
    {
        return self::subServiceQuery($id, $modelId)
            ->orderBy('sort_id')
            ->when($limit, function ($query) use ($limit) {
                return $query->limit($limit);
            })
            ->get();
    }
    
    public static function isSubService($id, $modelId = 1)
    {
        return self::subServiceQuery($id, $modelId)->exists();
    }
    
    protected static function subServiceQuery($parentId, $modelId)
    {
        $langId = self::getLangId();
    
        return Services::where('lang', $langId)
            ->where('model_id', $modelId)
            ->where('parent_id', $parentId);
    }
    
    protected static function getLangId()
    {
        $locale = app()->getLocale();
        return Languages::where('native', $locale)->value('id');
    }


















    public static function getSettingMessage($key = null, $lang = false, $clear = false)
    {
        if (!$key) {
            return "not found key";
        }


        $set = Settings::first();
        if (!isset($set)) {
            return null;
        }
        $data = collect($set->data);


        if ($lang) {
            $key .= app()->getLocale();
        }


        $keyData = $data->firstWhere('name', $key);

        $val = $keyData['value'] ?? "";

        if ($clear) {
            $val = strip_tags($val);
        }

        return $val;

    }



    public static function translate($id)
    {

        $lang = app()->getLocale();
        $currentLangId = Languages::where('native', $lang)->value('id');

        $translation = Translation::where('key', $id)->where('languages_id', $currentLangId)->first();
        return $translation ? $translation->value ?? $translation->key : null;
    }



    public static function social()
    {

        $set = Settings::first();
        if (!isset($set->data)) {
            return array(
                'instagram' => "",
                'twitter' => "",
                'facebook' => "",
                'youtube' => "",
                'linkedin' => "",
                'whatsapp' => ""
            );
        }
        $data = collect($set->data);

        $facebook = $data->firstWhere('name', 'facebook');
        $instagram = $data->firstWhere('name', 'instagram');
        $twitter = $data->firstWhere('name', 'twitter');
        $linkedin = $data->firstWhere('name', 'linkedin');
        $youtube = $data->firstWhere('name', 'youtube');
        $whatsapp = $data->firstWhere('name', 'whatsapp');



        $data = array(
            'instagram' => strip_tags($instagram['value'] ?? ""),
            'twitter' => strip_tags($twitter['value'] ?? ""),
            'facebook' => strip_tags($facebook['value'] ?? ""),
            'youtube' => strip_tags($youtube['value'] ?? ""),
            'linkedin' => strip_tags($linkedin['value'] ?? ""),
            'whatsapp' => strip_tags($whatsapp['value'] ?? "")
        );

        return $data;
    }


    public static function cacheCssVersion($type = false){
        if($type){
            return rand();
        }else{
            return 3;
        }
    }
    

    public static function addClassToParagraphs($html, $class = 'blog-details__text-2')
{
    $dom = new \DOMDocument();
    libxml_use_internal_errors(true); // HTML5 uyumsuzluk uyarılarını bastırmak için
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $paragraphs = $dom->getElementsByTagName('p');

    foreach ($paragraphs as $p) {
        $existingClass = $p->getAttribute('class');
        $p->setAttribute('class', trim($existingClass . ' ' . $class));
    }

    $body = $dom->getElementsByTagName('body')->item(0);
    $innerHTML = '';
    foreach ($body->childNodes as $child) {
        $innerHTML .= $dom->saveHTML($child);
    }

    return $innerHTML;
}



    public static function messageCount()
    {
        return Contact::where('read', false)->count();
    }


 


    public static function removeImage($model)
    {
        if (Storage::exists("uploads/" . $model->image)) {
            Storage::delete("uploads/" . $model->image);
        }
        return;
    }


    public static function uploadImage($file, $resize, $width, $height, $model = null)
    {

        $allowedfileExtension = ['jpeg', 'jpg', 'png', 'webp'];

        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension, $allowedfileExtension);

        if ($check) {

            $realPath = public_path('/uploads');
            $thumbnailPath = public_path('/uploads/thumbnail');

            if ($model) {
                if (Storage::exists("uploads/" . $model->image)) {
                    Storage::delete("uploads/" . $model->image);
                    Storage::delete("uploads/thumbnail/" . $model->image);
                }
            }


            $randName = Str::random(20);
            $fileName = $randName . '.webp';

            $image = Image::make($file);


            $image->resize($resize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($realPath . "/" . $fileName, 80);


            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            })->crop($width, $height)->save($thumbnailPath . "/" . $fileName, 80);


            return $fileName;
        } else {
            return false;
        }
    }


    

    public static function generateSeoMeta($data = null)
    {


        $seo = Seo::where('id', 1)->first();



        if($data){
            if(isset($data->meta_title)){
                $title = $data->meta_title;
            }elseif(isset($data->title)){
                $title = $data->title . ' - ' . $seo->meta_title;
            }
        }else{
            $title = $seo->meta_title;
        }

        /* if ($seo->title_prefix) {
            $title .= $seo->title_prefix ? $seo->title_prefix . ' ' . $title : $title;
        } */

        /*  if ($seo->title_suffix) {
               $title .= $seo->title_suffix ? $title . ' ' . $seo->title_suffix : $title;
           }
           */
        // Description & Keywords
        
        $description = '';

        if(isset($data->meta_description)){
            $description = $data->meta_description;
        }elseif($seo->meta_description) {
            $description = $seo->meta_description;
        }

        $keywords = '';

        if(isset($data->meta_keywords)){
            $keywords = $data->meta_keywords;
        }elseif($seo->meta_keywords) {
            $keywords = $seo->meta_keywords;
        }


        // Clean description
        $description = str_replace(["\n", "\r"], '', $description);


        $datePublished = $data && isset($data->created_at) ? $data->created_at : null;
        $dateModified = $data && isset($data->updated_at) ? $data->updated_at : null;


        // Return SEO data
        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'datePublished' => $datePublished,
            'dateModified' => $dateModified
        ];
    }




}
