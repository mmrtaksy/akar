<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\CategoryUser;
use App\Models\Cities;
use App\Models\Counties;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


    public function list()
    {
        $data = Category::whereNull('parent_id')->with('sub')->orderBy('id', 'asc')->get();

        return view('xadmin.pages.category.list', ['data' => $data]);
    }



    public function category_slug($slug, $perpage = 9)
    {
        $city = null;
        $county = null;
        $categorySlug = $slug;

        $exp = explode('-', $slug);

        if (count($exp) > 1) {
            $city = $exp[0];


            if ($this->isValidCity($city)) {
                $countyValid = isset($exp[1]) ? $exp[1] : null;

                if ($this->isValidCounty($countyValid)) {
                    $county = isset($exp[1]) ? $exp[1] : null;
                    $categorySlug = implode('-', array_slice($exp, 2));
                } else {
                    $categorySlug = implode('-', array_slice($exp, 1));
                }
            } else {
                $city = null;
            }
        }

        $users = $this->getUsersForCategory($categorySlug, $perpage, $city, $county);

        return $this->returnCategoryView($categorySlug, $users, $city, $county, $perpage);
    }

    // Şehir geçerliliğini kontrol etmek için bir yardımcı fonksiyon  
 
   
 


    public function search(Request $request){

        $paramsCity     = $request->city;
        $paramsCategory = $request->category;

        $slug = $paramsCity . '-' . Str::slug($paramsCategory, '-');

        return redirect(route('category_show', ['slug' => $slug]));

    }

    public function create(Request $request)
    {

        $data = $request->post();
        $id = null;
        $model = null;


            if (isset($data['id'])){ // TR dili ise
                $id = $data['id'];
                $model = Category::where(['id' => $id])->first();
            }


            if ($request->hasFile('cover')) { // Resim varsa
                $file = $request->file('cover');
                $fileName = Helper::uploadImage($file, 950, 390, 252, $model);
                $data['cover'] =  $fileName;
            }

            if( isset($model->id) || isset($model->xid)  ){ // Güncelle
                $model->update($data);
            }

            $data['parent_id'] = $request->parent_id ? $request->parent_id : null;

           if($id == null){ // Yeni Kayıt Oluştur
            Category::create($data);
           }


        $data = Category::orderBy('id', 'asc')->get();
        return redirect(route('category_list'))->with(['data' => $data]);
    }


    public function delete($id)
    {
        if (!$id) {
            return false;
        }

        $model = Category::where('id', $id)->first();

        Category::destroy($id);

        return redirect()->back();
    }
}
