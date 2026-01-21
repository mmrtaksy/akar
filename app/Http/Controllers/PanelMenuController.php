<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PanelMenuRequest;
use Illuminate\Http\Request;
use App\Models\PanelMenu;
class PanelMenuController extends Controller
{
    public function index()
    {
        $menus = PanelMenu::all();
        return view('xadmin.pages.panel-menus.index', ['menus' => $menus]);
    }

    public function create()
    {
        return view('xadmin.pages.panel-menus.create');
    }

    public function edit($id)
    {
        $data = PanelMenu::findOrFail($id);
        return view('xadmin.pages.panel-menus.edit', ['data' => $data]);
    }

    public function delete($id)
    {
        $data = PanelMenu::findOrFail($id);
        if($data){
            $data->delete();
        }
        return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
    }
    
    public function updatePost(Request $request)
    {
        $menu = PanelMenu::findOrFail($request->id);


        
        $menu->title = $request->title;
        $menu->statu = filter_var($request->statu, FILTER_VALIDATE_BOOLEAN);
        $menu->meta = filter_var($request->meta, FILTER_VALIDATE_BOOLEAN);
        $menu->editor = filter_var($request->editor, FILTER_VALIDATE_BOOLEAN);
        $menu->multiple_image = filter_var($request->multiple_image, FILTER_VALIDATE_BOOLEAN);
        $menu->image = filter_var($request->image, FILTER_VALIDATE_BOOLEAN);
        $menu->categories = filter_var($request->categories, FILTER_VALIDATE_BOOLEAN);
        $menu->extra = $request->extra ?? null;
    
        $menu->save();
    
        return redirect()->back()->with('success', 'İşlem başarıyla güncellendi.');
    }
    public function createNewPost(Request $request)
    {
        $newData = new PanelMenu();
    
        $newData->title = $request->title;
        $newData->statu = filter_var($request->statu, FILTER_VALIDATE_BOOLEAN);
        $newData->meta = filter_var($request->meta, FILTER_VALIDATE_BOOLEAN);
        $newData->editor = filter_var($request->editor, FILTER_VALIDATE_BOOLEAN);
        $newData->multiple_image = filter_var($request->multiple_image, FILTER_VALIDATE_BOOLEAN);
        $newData->image = filter_var($request->image, FILTER_VALIDATE_BOOLEAN);
        $newData->categories = filter_var($request->categories, FILTER_VALIDATE_BOOLEAN);
        $newData->extra = $request->extra ?? null;
    
        $newData->save();
    
        return redirect()->back()->with('success', 'İşlem başarıyla tamamlandı.');
    }
    
}
