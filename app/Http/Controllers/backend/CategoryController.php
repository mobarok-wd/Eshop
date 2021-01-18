<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;


class CategoryController extends Controller
{
    public function create(){


        $categories = Category::where('category_id','=',null)->select('name','id')->get();

        return view('backend.catagories.create',compact('categories'));
    }

    public function store(Request $request){

     
        $request->validate([
            'category_id'=>'nullable', 
            'cat_name'=>'required', 
            'is_menu'=>'required', 
            'is_active'=>'required', 
            
        ],[
            'category_id.required'=>'Parent category field is empty.',
            'cat_name.required'=>'Name field is empty',
            'is_menu.required'=>'Menu field is empty.',
            'is_active.required'=>'Active field is empty',
        ]);

        $data = [
            'category_id'=>$request->category_id,
            'name'=>$request->cat_name,
            'is_menu'=>$request->is_menu ? true : false,
            'is_active'=>$request->is_active ? true : false,
            
        ];
        
        
        $img =$request->file('photo');
        if($img){
            $img_name = uniqid();
            $ext = $img->getClientOriginalExtension();
            $img_full_name = $img_name.'.'.$ext;
            $img_path = 'upload/';
            $img_url = $img_path.$img_full_name;
            $img->move($img_path,$img_full_name);
            
            $data['photo']=$img_url;
            $category = Category::create($data);
            dd($category);

            try{
                if($category){
                    $notification = array(
                        'message'=>'category Added Successful!',
                        'alert-type'=>'success',
                    );
                    return Redirect()->back()->with($notification);
                }
            }catch(Throwable $exception){
                $notification = array(
                    'message'=>'Something is Wrong !!',
                    'alert-type'=>'error',
                );
                return Redirect()->back()->with($notification);
            }
        }else{
            $category = category::create($data);
            try{
                if($category){
                    $notification = array(
                        'message'=>'category Added Successful!',
                        'alert-type'=>'success',
                    );
                    return Redirect()->back()->with($notification);
                }
            }catch(Throwable $exception){
                $notification = array(
                    'message'=>'Something is Wrong',
                    'alert-type'=>'error',
                );
                return Redirect()->back()->with($notification);
            }
        }
 

    }
}