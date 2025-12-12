<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddNewCategoryController extends Controller
{
    public function index(){
         $categories = DB::table('course_main_category')->select('course_main_category.*')->paginate(4);
         foreach($categories as $category){
           $category->subcategories = DB::table('course_sub_category')->select('course_sub_category.category_title as sub_category_title' , 'course_sub_category.icon as sub_category_icon','course_sub_category.id as sub_category_id')->where('main_category_id',$category->id)->get();
         }
        return view('admin.AddNewCategory.views.index', ['categories' => $categories]);
    }

    public function addNewCategoryPage()
    {
        $data = DB::table('course_main_category')->get();
        return view('admin.AddNewCategory.views.add', ['data' => $data]);
    }
    
    // public function addNewCategorySubcategory(Request $request){
    //     if(empty($request->parent_picker) || $request->parent_picker == "" || $request->parent_picker==null){
    //         $path = '';
    //         if ($request->hasFile('category_thumbnail')) {
    //             $file = $request->file('category_thumbnail');
    //             $filename = time() . '.' . $file->getClientOriginalExtension();
    //             // $path = $file->storeAs('public/resources/courses/category/main/thumbnail', $filename);
    //             $path = $file->storeAs('courses/category/main/thumbnail', $filename, 'public');


    //         }
    //           DB::table('course_main_category')->insert([
    //             'category_code' => $request->category_code ?? '',
    //             'category_title' => $request->category_title ?? '',
    //             'icon' => $request->icon ?? '',
    //             'thumbnail' => $path
    //           ]);
    //           return redirect()->back()->with('success', 'Course main category added successfully');
    //     }else{
    //         $path = '';
    //         if ($request->hasFile('sub_category_thumbnail')) {
    //             $file = $request->file('sub_category_thumbnail');
    //             $filename = time() . '.' . $file->getClientOriginalExtension();
    //             $path = $file->storeAs('public/resources/courses/category/sub/thumbnail', $filename);
    //         }
    //           DB::table('course_sub_category')->insert([
    //             'main_category_id' => $request->parent_picker ?? '',
    //             'category_code' => $request->category_code ?? '',
    //             'category_title' => $request->category_title ?? '',
    //             'icon' => $request->icon ?? '',
    //             'thumbnail' => $path
    //           ]);
    //           return redirect()->back()->with('success', 'Course sub category added successfully');
    //     }
    // }
    
    
    
    
public function addNewCategorySubcategory(Request $request)
{
    if (empty($request->parent_picker)) {
        $path = null;

        if ($request->hasFile('category_thumbnail')) {
            $file = $request->file('category_thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/main_category'), $filename); // Save to 'public/images/main_category'
            $path = 'images/main_category/' . $filename; // Save the relative path
        }

        DB::table('course_main_category')->insert([
            'category_code' => $request->category_code ?? '',
            'category_title' => $request->category_title ?? '',
            'icon' => $request->icon ?? '',
            'thumbnail' => $path,
        ]);

        return redirect()->back()->with('success', 'Course main category added successfully');
    } else {
        $path = null;

        if ($request->hasFile('sub_category_thumbnail')) {
            $file = $request->file('sub_category_thumbnail');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/sub_category'), $filename); 
            $path = 'images/sub_category/' . $filename;
        }

        DB::table('course_sub_category')->insert([
            'main_category_id' => $request->parent_picker ?? '',
            'category_code' => $request->category_code ?? '',
            'category_title' => $request->category_title ?? '',
            'icon' => $request->icon ?? '',
            'thumbnail' => $path,
        ]);

        return redirect()->back()->with('success', 'Course sub category added successfully');
    }
}


    public function deleteMainCategory($id){
        $main_delete = DB::table('course_main_category')->where('id',$id)->delete();
        $sub_delete = DB::table('course_sub_category')->where('main_category_id',$id)->delete();
        return redirect()->back()->with('success', 'Main Category deleted successfully');
    }

    public function deleteSubCategory($id){
        $sub_delete = DB::table('course_sub_category')->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Sub Category deleted successfully');
    }

    public function editMainCategoryPage($id){
        $edit = DB::table('course_main_category')->where('id',$id)->first();
        return view('admin.AddNewCategory.views.edit-main', ['edit' => $edit]);
    }

    public function editSubCategoryPage($id){
        $edit = DB::table('course_sub_category')->where('id',$id)->first();
        $data = DB::table('course_main_category')->get();
        return view('admin.AddNewCategory.views.edit-sub', ['edit' => $edit,'data'=>$data]);
    }

    public function updateMainCategory(Request $request, $id)
    {
        $path = null;
        if ($request->hasFile('category_thumbnail')) {
            $file = $request->file('category_thumbnail');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/resources/courses/category/main/thumbnail', $filename);
        }

        DB::table('course_main_category')->where('id', $id)->update([
            'category_code' => $request->category_code ?? DB::raw('category_code'),
            'category_title' => $request->category_title ?? DB::raw('category_title'),
            'icon' => $request->icon ?? DB::raw('icon'),
            'thumbnail' => $path ?? DB::raw('thumbnail'),
        ]);
    
        return redirect()->back()->with('success', 'Course main category updated successfully');
    }
    

    public function updateSubCategory(Request $request,$id){
        $path = null;
        if ($request->hasFile('sub_category_thumbnail')) {
            $file = $request->file('sub_category_thumbnail');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/resources/courses/category/main/thumbnail', $filename);
        }

        DB::table('course_sub_category')->where('id', $id)->update([
            'main_category_id' => $request->parent_picker ?? DB::raw('main_category_id'),
            'category_code' => $request->category_code ?? DB::raw('category_code'),
            'category_title' => $request->category_title ?? DB::raw('category_title'),
            'icon' => $request->icon ?? DB::raw('icon'),
            'thumbnail' => $path ?? DB::raw('thumbnail'),
        ]);
    
        return redirect()->back()->with('success', 'Course sub category updated successfully');
    }
}