<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class Services extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $guarded = [
        'id'
    ];
    
    public function children()
    {
        
         
        
        $locale =  Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->value('id');
          
          return $this->hasMany(Services::class, 'parent_id', 'id')
                    ->where('lang', $langId)
                    ->orderBy('sort_id');
    }
    public function childrenadmin()
    {
        $langId = request()->get('lang');

          
          return $this->hasMany(Services::class, 'parent_id', 'id')
                    ->where('lang', $langId)
                    ->orderBy('sort_id');
    }
    
    public function parent()
    {
        
        $locale =  Cache::get('locale', config('app.locale'));
        $langId = Languages::where('native', $locale)->value('id');

          
        return $this->hasOne(Services::class, 'id', 'parent_id')
                ->where('lang', $langId)
                ->orderBy('sort_id');
    }
    public function parentadmin()
    {
         
        $langId = request()->get('lang');
          
        return $this->hasOne(Services::class, 'id', 'parent_id')
                ->where('lang', $langId)
                ->orderBy('sort_id');


    }
    

  public function parentSeo()
    {
        return $this->hasOne(Services::class, 'id', 'parent_id')
                ->orderBy('sort_id');
    }
    
    
    public function images()
    {
        return $this->hasMany(ServicesImage::class, 'service_id', 'id');
    }
  

    public function single_path()
    {
        return $this->hasOne(ServicesImage::class, 'service_id', 'id')->where('is_first', true);
    }
  
}
