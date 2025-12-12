<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Helper;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class NewSupplierController extends BaseController
{
   
    public function supplierVendorManage(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        if ($auth->is_role == 1) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user && $user->created_by) {
                $user_ids[] = $user->created_by;
            }
        } elseif (!in_array($auth->is_role, [0, 2])) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        }
    
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
    
        $categories = DB::table('new_supplier_product_category as c')
            ->leftJoin('new_supplier_product_sub_category as sc', 'sc.prod_cat_id', '=', 'c.id')
            ->leftJoin('new_supplier_product_specific_sub_category as ssc', function($join) {
                $join->on('ssc.prod_cat_id', '=', 'c.id')
                     ->on('ssc.prod_sub_cat_id', '=', 'sc.id');
            })
            ->select(
                'c.id as category_id', 'c.name as category_name',
                'sc.id as sub_category_id', 'sc.name as sub_category_name',
                'ssc.id as specific_sub_id', 'ssc.name as specific_sub_name'
            )
            ->whereIn('c.created_by', $user_ids)
            ->orderBy('c.name')
            ->orderBy('sc.name')
            ->orderBy('ssc.name')
            ->get();
    
        $suppliers = DB::table('new_supplier as ns')
            ->leftJoin('new_supplier_product_category as c', 'c.id', '=', 'ns.prod_cat_id')
            ->leftJoin('new_supplier_product_sub_category as sc', 'sc.id', '=', 'ns.prod_sub_cat_id')
            ->leftJoin('new_supplier_product_specific_sub_category as ssc', 'ssc.id', '=', 'ns.prod_spec_sub_cat_id')
            ->select(
                'ns.id as supplier_id',
                'ns.status as status',
                'ns.status_active_reason as status_active_reason',
                'ns.status_update_date as status_update_date',
                'c.name as category',
                'sc.name as sub_category',
                'ssc.name as specific_sub',
                'ns.created_at',
                'ns.created_by'
            )
            ->latest('ns.id')
            ->whereIn('ns.created_by', $user_ids)
            // ->paginate(5);
            ->get();
    
        return view('admin.vendor_managment.supplier_vendor_manage', compact('categories', 'suppliers'));
    }

    public function addNewSupplier(Request $request)
    {
        $request->validate([
            'category'      => 'nullable|string|max:255|required_without_all:sub_category,specific_sub',
            'sub_category'  => 'nullable|string|max:255|required_without_all:category,specific_sub',
            'specific_sub'  => 'nullable|string|max:255|required_without_all:category,sub_category',
        ]);
    
        $cat_id = null;
        $sub_cat_id = null;
        $specific_sub_id = null;
    
        if (!empty($request->id)) {
            $supplier = DB::table('new_supplier')->where('id', $request->id)->first();
    
            if (!$supplier) {
                return response()->json(['success' => false, 'message' => 'Supplier not found']);
            }
    
            $cat_id = $supplier->prod_cat_id;
            $sub_cat_id = $supplier->prod_sub_cat_id;
            $specific_sub_id = $supplier->prod_spec_sub_cat_id;
    
            if (!empty($request->category)) {
                if ($cat_id) {
                  $check =  DB::table('new_supplier_product_category')
                        ->where('name', $request->category)->first();
                    if($check){
                        $cat_id = $check->id;
                    }else{
                        DB::table('new_supplier_product_category')
                        ->where('id', $cat_id)
                        ->update(['name' => $request->category, 'updated_at' => now()]);
                    }
                } else {
                    $check_exist = DB::table('new_supplier_product_category')->where('name',$request->category)->first();
                    if($check_exist){
                        $cat_id = $check_exist->id;
                    }else{
                    $cat_id = DB::table('new_supplier_product_category')->insertGetId([
                        'name'       => $request->category,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'created_by' => Auth::id(),
                    ]);
                        
                    }
                }
            }
    
            if (!empty($request->sub_category)) {
                if ($sub_cat_id) {
                    $check =  DB::table('new_supplier_product_sub_category')
                        ->where('name', $request->sub_category)->first();
                    if($check){
                        $sub_cat_id = $check->id;
                    }else{
                        DB::table('new_supplier_product_sub_category')
                        ->where('id', $sub_cat_id)
                        ->update(['name' => $request->sub_category, 'updated_at' => now()]);
                    }
                } else {
                     $check_exist = DB::table('new_supplier_product_sub_category')->where('name',$request->sub_category)->first();
                    if($check_exist){
                        $sub_cat_id = $check_exist->id;
                    }else{
                        $sub_cat_id = DB::table('new_supplier_product_sub_category')->insertGetId([
                            'name'        => $request->sub_category,
                            'prod_cat_id' => $cat_id,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                            'created_by'  => Auth::id(),
                        ]);
                    }
                }
            }
    
            if (!empty($request->specific_sub)) {
                if ($specific_sub_id) {
                      $check =  DB::table('new_supplier_product_specific_sub_category')
                        ->where('name', $request->specific_sub)->first();
                    if($check){
                        $specific_sub_id = $check->id;
                    }else{
                        DB::table('new_supplier_product_specific_sub_category')
                        ->where('id', $specific_sub_id)
                        ->update(['name' => $request->specific_sub, 'updated_at' => now()]);
                    }
                } else {
                     $check_exist = DB::table('new_supplier_product_specific_sub_category')->where('name',$request->specific_sub)->first();
                    if($check_exist){
                        $specific_sub_id = $check_exist->id;
                    }else{
                        
                    $specific_sub_id = DB::table('new_supplier_product_specific_sub_category')->insertGetId([
                        'name'            => $request->specific_sub,
                        'prod_cat_id'     => $cat_id,
                        'prod_sub_cat_id' => $sub_cat_id,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                        'created_by'      => Auth::id(),
                    ]);
                    }
                    
                }
            }
    
            DB::table('new_supplier')->where('id', $request->id)->update([
                'prod_cat_id'          => $cat_id,
                'prod_sub_cat_id'      => $sub_cat_id,
                'prod_spec_sub_cat_id' => $specific_sub_id,
                'updated_at'           => now(),
            ]);
    
            return response()->json(['success' => true, 'message' => 'Supplier updated successfully']);
        } else {

            if (!empty($request->category)) {
                $cat = DB::table('new_supplier_product_category')->where('name', $request->category)->first();
                if (!$cat) {
                    $cat_id = DB::table('new_supplier_product_category')->insertGetId([
                        'name'       => $request->category,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'created_by' => Auth::id(),
                    ]);
                } else {
                    $cat_id = $cat->id;
                }
            }
    
            if (!empty($request->sub_category)) {
                $sub_cat = DB::table('new_supplier_product_sub_category')
                    ->where('name', $request->sub_category)
                    ->when($cat_id, function ($q) use ($cat_id) {
                        return $q->where('prod_cat_id', $cat_id);
                    })
                    ->first();
        
                if (!$sub_cat) {
                    $sub_cat_id = DB::table('new_supplier_product_sub_category')->insertGetId([
                        'name'        => $request->sub_category,
                        'prod_cat_id' => $cat_id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                        'created_by'  => Auth::id(),
                    ]);
                } else {
                    $sub_cat_id = $sub_cat->id;
        
                }
            }
        
            if (!empty($request->specific_sub)) {
                $specific_sub = DB::table('new_supplier_product_specific_sub_category')
                    ->where('name', $request->specific_sub)
                    ->when($cat_id, function ($q) use ($cat_id) {
                        return $q->where('prod_cat_id', $cat_id);
                    })
                    ->when($sub_cat_id, function ($q) use ($sub_cat_id) {
                        return $q->where('prod_sub_cat_id', $sub_cat_id);
                    })
                    ->first();
        
                if (!$specific_sub) {
                    $specific_sub_id = DB::table('new_supplier_product_specific_sub_category')->insertGetId([
                        'name'            => $request->specific_sub,
                        'prod_cat_id'     => $cat_id,
                        'prod_sub_cat_id' => $sub_cat_id,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                        'created_by'      => Auth::id(),
                    ]);
                } else {
                    $specific_sub_id = $specific_sub->id;
                }
            }
    
            DB::table('new_supplier')->insert([
                'prod_cat_id'          => $cat_id,
                'prod_sub_cat_id'      => $sub_cat_id,
                'prod_spec_sub_cat_id' => $specific_sub_id,
                'created_by'           => Auth::id(),
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
    
            return response()->json(['success' => true, 'message' => 'Supplier added successfully']);
        }
    }

    public function updateMaterials(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:new_supplier,id',
            'materials'   => 'nullable|array'
        ]);
    
        DB::table('new_supplier')
            ->where('id', $request->supplier_id)
            ->update([
                'material' => json_encode($request->materials) 
            ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Materials updated successfully'
        ]);
    }
    
    // public function delete($id)
    // {
    //     $check = DB::table('new_supplier')->where('id', $id)->where('created_by',Auth::id())->first();
    //     if($check){
    //     $deleted = DB::table('new_supplier')->where('id', $id)->delete();
    
    //     if ($deleted) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Supplier deleted successfully'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to delete supplier'
    //         ], 400);
    //     }
    //     }else{
    //          return response()->json([
    //             'success' => false,
    //             'message' => 'You can not delete this as you are not created this'
    //         ], 400);
    //     }
    // }


    public function delete($id)
    {
        $check = DB::table('new_supplier')
            ->where('id', $id)
            ->where('created_by', Auth::id())
            ->first();
    
        if (!$check) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete this as you are not the creator.'
            ], 400);
        }
    
        $supplier = DB::table('new_supplier')->where('id', $id)->first();
    
        if (!empty($supplier->prod_cat_id) && empty($supplier->prod_sub_cat_id) && empty($supplier->prod_spec_sub_cat_id)) {
            DB::table('new_supplier_product_specific_sub_category')->where('prod_cat_id', $supplier->prod_cat_id)->delete();
            DB::table('new_supplier_product_sub_category')->where('prod_cat_id', $supplier->prod_cat_id)->delete();
            DB::table('new_supplier_product_category')->where('id', $supplier->prod_cat_id)->delete();
    
        } elseif (!empty($supplier->prod_cat_id) && !empty($supplier->prod_sub_cat_id) && empty($supplier->prod_spec_sub_cat_id)) {
            DB::table('new_supplier_product_specific_sub_category')
                ->where('prod_cat_id', $supplier->prod_cat_id)
                ->where('prod_sub_cat_id', $supplier->prod_sub_cat_id)
                ->delete();
    
            DB::table('new_supplier_product_sub_category')
                ->where('prod_cat_id', $supplier->prod_cat_id)
                ->where('id', $supplier->prod_sub_cat_id)
                ->delete();
    
        } elseif (!empty($supplier->prod_cat_id) && !empty($supplier->prod_sub_cat_id) && !empty($supplier->prod_spec_sub_cat_id)) {
            DB::table('new_supplier_product_specific_sub_category')
                ->where('id', $supplier->prod_spec_sub_cat_id)
                ->delete();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No category, subcategory, or specific subcategory found.'
            ], 400);
        }
    
        // Delete any related specialisation uploads
        DB::table('new_supplier_product_specialisation_uploads')
            ->where('new_supplier_id', $id)
            ->delete();
    
        // Now delete the supplier
        $deleted = DB::table('new_supplier')->where('id', $id)->delete();
    
        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier deleted successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete supplier.'
            ], 400);
        }
    }


  public function saveComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'nullable|string|max:1000',
            'status'  => 'required|in:0,1'
        ]);
    
        $supplier = DB::table('new_supplier')->where('id', $id)->first();
    
        DB::table('new_supplier')->where('id', $id)->update([
            'status_active_reason' => $request->comment,
            'status'  => $request->status,
            'status_update_date' => now()
        ]);
    
        return response()->json([
            'success' => true,
            'updated_at' => \Carbon\Carbon::now()->format('M d, Y g:i A'),
            'oldComment' => $supplier->status_active_reason
        ]);
    }


    public function getCategories()
    {
        
         $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        if ($auth->is_role == 1) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user && $user->created_by) {
                $user_ids[] = $user->created_by;
            }
        }
    
        elseif (!in_array($auth->is_role, [0, 2])) {
            $user = DB::table('users')->where('id', $user_id)->first();
            if ($user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        }
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
        
        $categories = DB::table('new_supplier_product_category')
            ->select('id', 'name')
            ->whereIn('created_by',$user_ids)
            // ->where('created_by',Auth::id())
            ->get();
    
        return response()->json($categories);
    }



    public function getSubcategories($categoryId)
    {
        $subcategories =  DB::table('new_supplier_product_sub_category')::select('id', 'name')
            ->where('prod_cat_id', $categoryId)
            ->get();

        return response()->json($subcategories);
    }
    
    
    
    public function getAllCategories()
    { 
            $auth = Auth::user();
            $user_id = $auth->id;
        
            $user_ids = [$user_id];
        
            if ($auth->is_role == 1) {
                $user = DB::table('users')->where('id', $user_id)->first();
                if ($user && $user->created_by) {
                    $user_ids[] = $user->created_by;
                }
            }
        
            elseif (!in_array($auth->is_role, [0, 2])) {
                $user = DB::table('users')->where('id', $user_id)->first();
                if ($user) {
                    if ($user->created_by) {
                        $user_ids[] = $user->created_by;
                    }
                    if ($user->created_by1) {
                        $user_ids[] = $user->created_by1;
                    }
                }
            }
            $user_ids[] = 1; 
            $user_ids = array_unique($user_ids);
            
        $categories = DB::table('new_supplier_product_category')
            ->select('id', 'name')
            ->whereIn('created_by',$user_ids)
            // ->where('created_by', Auth::id())
            ->get();
    
        $response = [];
    
        foreach ($categories as $cat) {
            $response[$cat->name] = []; 
            $subcategories = DB::table('new_supplier_product_sub_category')
                ->select('id', 'name')
                ->where('prod_cat_id', $cat->id)
                 ->whereIn('created_by',$user_ids)
                ->get();
    
            foreach ($subcategories as $sub) {
                $response[$cat->name][$sub->name] = []; 
                $specificSubs = DB::table('new_supplier_product_specific_sub_category')
                    ->select('id', 'name')
                    ->where('prod_cat_id', $cat->id)
                    ->where('prod_sub_cat_id', $sub->id)
                     ->whereIn('created_by',$user_ids)
                    ->get();
    
                foreach ($specificSubs as $spec) {
                    $response[$cat->name][$sub->name][] = $spec->name;
                }
            }
        }
        
        return response()->json($response);
    }

    public function supplier_product_upload_specification(Request $request)
    {
        try {
            $login_user = Auth::id();
    
            $request->validate([
                'image' => 'required|mimes:pdf',
                'supplier_id' => 'required|integer'
            ]);
    
            $file = $request->file('image');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('inspection'), $filename);
    
            $dataArr = [
                'new_supplier_id' => $request->supplier_id,
                'file' => $filename,
                'created_by' => $login_user,
                'updated_at' => now(),
            ];
    
            $existing = DB::table('new_supplier_product_specialisation_uploads')
                ->where('new_supplier_id', $request->supplier_id)
                ->first();
    
            if ($existing) {
                DB::table('new_supplier_product_specialisation_uploads')
                    ->where('id', $existing->id)
                    ->update($dataArr);
                $msg = "File updated successfully!";
            } else {
                $dataArr['created_at'] = now();
                DB::table('new_supplier_product_specialisation_uploads')->insert($dataArr);
                $msg = "File uploaded successfully!";
            }
    
            return response()->json(['success' => true, 'message' => $msg]);
    
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // public function bulkImport(Request $request)
    // {
    //     $request->validate([
    //         'csv_file' => 'required|file|mimes:csv,txt',
    //     ]);
        
    //     $categoryId = $request->input('category_id'); // This is optional based on your logic.
    //     $file = $request->file('csv_file');
        
    //     // Read CSV data
    //     $data = array_map('str_getcsv', file($file->getRealPath()));
    //     $header = array_map('trim', $data[0]);
        
    //     // Remove header row from data
    //     unset($data[0]);
    
    //     foreach ($data as $row) {
    //         $categoryName = $row[0]; // Assumes the category name is in the first column
            
    //         if (empty($categoryId)) {
    //             // If no category ID is provided, insert into the parent category table
    //             $existingCategory = DB::table('new_supplier_product_category')
    //                 ->where('name', $categoryName)
    //                 ->first();
    
    //             if (!$existingCategory) {
    //                 DB::table('new_supplier_product_category')->insert([
    //                     'name' => $categoryName,
    //                     'created_by' => Auth::id(),
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         } elseif (!empty($categoryId)) {
    //             // If category ID is provided, insert into the sub-category table
    //             $existingCategory = DB::table('new_supplier_product_sub_category')
    //                 ->where('prod_cat_id', $categoryId)
    //                 ->where('name', $categoryName)
    //                 ->first();
    
    //             if (!$existingCategory) {
    //                 DB::table('new_supplier_product_sub_category')->insert([
    //                     'name' => $categoryName,
    //                     'prod_cat_id' => $categoryId,
    //                     'created_by' => Auth::id(),
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }
    //     }
    
    //     return redirect()->back()->with('success', 'CSV Categories Imported Successfully!');
    // }
    

    public function bulkImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
    
        // Safe handling of optional inputs
        $categoryId = $request->filled('category_id') ? $request->input('category_id') : null;
        $subCategoryId = $request->filled('sub_category_id') ? $request->input('sub_category_id') : null;
    
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
    
        if (empty($data) || !isset($data[0])) {
            return redirect()->back()->withErrors(['csv_file' => 'Invalid or empty CSV file.']);
        }
    
        $header = array_map('trim', $data[0]);
        unset($data[0]); // Remove header
    
        foreach ($data as $row) {
            if (!isset($row[0]) || empty(trim($row[0]))) {
                continue; // Skip empty rows
            }
    
            $categoryName = trim($row[0]);
    
            /**
             * CASE 1: Creating Parent Category
             */
            if (is_null($categoryId) && is_null($subCategoryId)) {
                $existingCategory = DB::table('new_supplier_product_category')
                    ->where('name', $categoryName)
                    ->first();
    
                if (!$existingCategory) {
                    $newCategoryId = DB::table('new_supplier_product_category')->insertGetId([
                        'name' => $categoryName,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
    
                    DB::table('new_supplier')->insert([
                        'prod_cat_id' => $newCategoryId,
                        'status' => 0,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
    
            /**
             * CASE 2: Creating Sub-Category under given Category
             */
            elseif (!is_null($categoryId) && is_null($subCategoryId)) {
                $existingSubCategory = DB::table('new_supplier_product_sub_category')
                    ->where('prod_cat_id', $categoryId)
                    ->where('name', $categoryName)
                    ->first();
    
                if (!$existingSubCategory) {
                    $newSubCatId = DB::table('new_supplier_product_sub_category')->insertGetId([
                        'name' => $categoryName,
                        'prod_cat_id' => $categoryId,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
    
                    $check = DB::table('new_supplier')
                        ->where('prod_cat_id', $categoryId)
                        ->whereNull('prod_sub_cat_id')
                        ->first();
    
                    if ($check) {
                        DB::table('new_supplier')
                            ->where('id', $check->id)
                            ->update(['prod_sub_cat_id' => $newSubCatId]);
                    } else {
                        DB::table('new_supplier')->insert([
                            'prod_cat_id' => $categoryId,
                            'prod_sub_cat_id' => $newSubCatId,
                            'status' => 0,
                            'created_by' => Auth::id(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
    
            /**
             * CASE 3: Creating Specific Sub-Category under Category & Sub-Category
             */
            elseif (!is_null($categoryId) && !is_null($subCategoryId)) {
                $existingSpecSubCategory = DB::table('new_supplier_product_specific_sub_category')
                    ->where('prod_cat_id', $categoryId)
                    ->where('prod_sub_cat_id', $subCategoryId)
                    ->where('name', $categoryName)
                    ->first();
    
                if (!$existingSpecSubCategory) {
                    $newSpecSubCatId = DB::table('new_supplier_product_specific_sub_category')->insertGetId([
                        'name' => $categoryName,
                        'prod_cat_id' => $categoryId,
                        'prod_sub_cat_id' => $subCategoryId,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
    
                    $check = DB::table('new_supplier')
                        ->where('prod_cat_id', $categoryId)
                        ->where('prod_sub_cat_id', $subCategoryId)
                        ->whereNull('prod_spec_sub_cat_id')
                        ->first();
    
                    if ($check) {
                        DB::table('new_supplier')
                            ->where('id', $check->id)
                            ->update(['prod_spec_sub_cat_id' => $newSpecSubCatId]);
                    } else {
                        DB::table('new_supplier')->insert([
                            'prod_cat_id' => $categoryId,
                            'prod_sub_cat_id' => $subCategoryId,
                            'prod_spec_sub_cat_id' => $newSpecSubCatId,
                            'status' => 0,
                            'created_by' => Auth::id(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    
        return redirect()->back()->with('success', 'CSV Categories Imported Successfully!');
    }


    public function saveKrdoImage(Request $request)
    {
        if ($request->hasFile('croppedImage')) {
            $file = $request->file('croppedImage');

            // Extension detect karo
            $extension = $file->getClientOriginalExtension() ?: 'jpg';

            // Unique filename banao
            $filename = time() . '.' . $extension;

            // Save directly inside public/uploads folder
            $destinationPath = public_path('uploads');
            
            // Ensure folder exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move file
            $file->move($destinationPath, $filename);

            // Public URL banado
            $fullUrl = url('uploads/' . $filename);

            return response()->json([
                'success'  => true,
                'file'     => $filename,
                'full_url' => $fullUrl
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No image found'], 400);
    }


}