<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB,Helper;
use App\Models\ServingArea;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;

class NutrilatorController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request) {
		  $name = $_GET['name'] ?? '';
		 $tab_name = $_GET['tab_name'] ?? '';
		  $s_date = $_GET['s_date'] ?? '';
		  $e_date = $_GET['e_date'] ?? '';
		  $Ingredients_Symbol = $_GET['Ingredients_Symbol'] ?? '';
		  $Refrence = $_GET['Refrence'] ?? '';
		$departments = DB::table('departments')->orderBy('id', 'DESC')->get();
		$refrences = DB::table('refrences')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
		$product = DB::table('product_Ingredients')->where('created_by',Auth::user()->id)->where('type',"1")->orderBy('id', 'DESC')->get();
			$Ingredients = DB::table('product_Ingredients')->where('created_by',Auth::user()->id)->where('type',"2")->orderBy('id', 'DESC')->get();
$nutrilator_measurement_unit_list = DB::table('nutrilator_measurement_unit')->where('created_by',Auth::user()->id)->get();
		$servingareas= ServingArea::where('created_by',Auth::user()->id)->get();
		$authority = DB::table('authority')->where('unit_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
		$Ingredientlist = DB::table('Ingredient')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
		$Ingredientlist = DB::table('Ingredient');
		                     if(!empty($name)){
								 $Ingredientlist->where('name', 'LIKE', "%$name%"); 
								 $Ingredientlist->orWhere('Keyword', 'LIKE', "%$name%"); 
          }
		
		         if(!empty($s_date && $e_date)  ){
              $Ingredientlist =  $Ingredientlist->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
          }
		
		         if(!empty($Ingredients_Symbol)  ){
              $Ingredientlist =  $Ingredientlist->where('Ingredients_Symbol', $Ingredients_Symbol);  
          }
		
		         if(!empty($Refrence)  ){
 $Ingredientlist =  $Ingredientlist->where('Refrence', $Refrence);            }
		
		
		
		
		$Ingredientlist = $Ingredientlist->orderBy('id', 'DESC')->paginate(5); 
		
		$tab_name="1";
		
		
		
return view('admin.nutrilator.measurement',compact('nutrilator_measurement_unit_list','servingareas','departments','authority','refrences','product','Ingredients','Ingredientlist','tab_name'));
}



 public function index1(Request $request) {
     
     
    
    
//      $recipes = DB::table('Recipe')->get();

// foreach ($recipes as $recipess) {
    
//     // Get allergen names from product_Ingredients table
//     $allergenNames = DB::table('recipe_items')
//         ->where('recipe_id', $recipess->id)
//         ->pluck('Ingredients_id');
//     // Update the Ingredient table
//     $results = DB::table('Ingredient')
//         ->whereIn('id', $allergenNames)
//         ->pluck('name')->toArray();
        
//         dd($results);

// }


     
//  $recipes = DB::table('Ingredientcopy')->get();

// foreach ($recipes as $recipess) {
//     // Decode the Allergen field (supports both JSON arrays and objects)
//     $rawAllergens = json_decode($recipess->Allergen, true);

//     if (!$rawAllergens || !is_array($rawAllergens)) {
//         continue; // Skip invalid or empty data
//     }

//     // Extract allergen IDs
//     $allergenIds = array_values($rawAllergens);

//     // Get allergen names from product_Ingredients table
//     $allergenNames = DB::table('product_Ingredients')
//         ->whereIn('id', $allergenIds)
//         ->pluck('name')
//         ->toArray();

//     // Prepare update data
//     $data = [
//         'Allergen' => implode(', ', $allergenNames)
//     ];

//     // Update the Ingredient table
//     DB::table('Ingredient')
//         ->where('id', $recipess->id)
//         ->update($data);
// }
//  die();


    
//     die();
//     $recipes = DB::table('Recipe')->get();

// foreach ($recipes as $recipe) {
//     // Get first ingredient_id for this recipe
//     $ingredientId = DB::table('recipe_items')
//         ->where('recipe_id', $recipe->id)
//         ->value('Ingredients_id'); // returns single value

//     if ($ingredientId) {
//         // Get ingredient record
//         $ingredient = DB::table('Ingredient')
//             ->where('id', $ingredientId)
//             ->first();
            
       

//         if ($ingredient) {
//             // Update the recipe with this ingredient's values
//             DB::table('Recipe')
//                 ->where('id', $recipe->id)
//                 ->update([
//                     'allergen' => $ingredient->Allergen ?? '',
//                     'refrence' => $ingredient->Refrence ?? '',
//                 ]);
//         }
//     }
// }

//  die();
    
		  $name = $_GET['name'] ?? '';
		 $tab_name = $_GET['tab_name'] ?? '';
		  $s_date = $_GET['s_date'] ?? '';
		  $e_date = $_GET['e_date'] ?? '';
		
		  $Ingredients_Symbol = $_GET['Ingredients_Symbol'] ?? '';
		  $Refrence = $_GET['Refrence'] ?? '';
		
		
		$departments = DB::table('departments')->orderBy('id', 'DESC')->get();
		$refrences = DB::table('refrences')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->get();
		$product = DB::table('product_Ingredients')->where('created_by',Auth::user()->id)->where('type',"1")->orderBy('id', 'DESC')->get();
			$Ingredients = DB::table('product_Ingredients')->where('created_by',Auth::user()->id)->where('type',"2")->orderBy('id', 'DESC')->get();
		
		
$nutrilator_measurement_unit_list = DB::table('nutrilator_measurement_unit')->where('created_by',Auth::user()->id)->get();
		$servingareas= ServingArea::where('created_by',Auth::user()->id)->get();
		$authority = DB::table('authority')->where('unit_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
		
		
		
		if(!empty(Session::get('unit_id'))  ){

    $Ingredientlist = DB::table('Ingredient')->where(function($query) {
    $query->where('created_by', Session::get('unit_id'))
          ->orWhere('created_by', 1); // Add your OR condition here
})->orderBy('id', 'DESC')->get();
    $recipe_list = DB::table('Recipe')->where('created_by',Session::get('unit_id'))->orderBy('id', 'DESC')->limit(100)->get();
}

else{
		$Ingredientlist = DB::table('Ingredient')->where(function($query) {
    $query->where('created_by', Auth::user()->id)
          ->orWhere('created_by', 1); // Add your OR condition here
})->orderBy('id', 'DESC')->get();
		    $recipe_list = DB::table('Recipe')->where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->limit(100)->get();


}






		$tab_name="1";
return view('admin.nutrilator.newinstrution',compact('nutrilator_measurement_unit_list','servingareas','departments','authority','refrences','product','Ingredients','Ingredientlist','tab_name','recipe_list'));
}
    public function nutrilator_measurement_unit_store(Request $request) {
    	 $dataArr['name']=$request->name;
		 $dataArr['si_unit_name']=$request->si_unit_name;
       $dataArr['created_by']=Auth::user()->id;
            DB::table('nutrilator_measurement_unit')->insert($dataArr);
	return redirect()->route('nutrilator',['tab_name' => 1])->with('success', 'Delete Successfully');
}
	
				    public function nutrilator_measurement_unit_edit(Request $request) {
    		 $dataArr['name']=$request->name;
		 $dataArr['si_unit_name']=$request->si_unit_name;
					          DB::table('nutrilator_measurement_unit')->where('id',$request->nutrilator_measurement_unit_edit_id)->update($dataArr);
		return redirect()->route('nutrilator',['tab_name' => 1])->with('add_department', 'Add Successfully');
}
	
		    public function destory($id) {
    	$retData=DB::table('nutrilator_measurement_unit')->where('id',$id)->delete();
return redirect()->route('nutrilator',['tab_name' => 1])->with('success', 'Delete Successfully');
}	
	
	/******************* Serving Area *************/
	
		    public function get_servingArea(Request $request) {
				
		try {

			if(request()->ajax()) {

				$columns = array(
					0   =>'name',
					1   =>'action',
				);

				## Read value
				$draw = request('draw');

				$start = request('start');

				$rowperpage = request('length'); // Rows display per page

				$columnIndex = request('order.0.column'); // Column index



				$columnSortOrder = request('order.0.dir'); // asc or desc

				$searchValue = request('search.value'); // Search value

				## Total number of records without filtering
				$totalRecords = ServingArea::count();

				## Total number of record with filtering
				$totalRecordwithFilter = ServingArea::count();

				## Fetch records
				$products = ServingArea::select('id', '', 'name',   'created_at', 'updated_at')
							->offset($start)
							->limit($rowperpage)
					
							->get();

				$data = array();

				$delete_confirmation_msg = "'Are you sure you want to delete?'";

                $i = $start;

				foreach($products as $key => $row) {

                    $i++;

					$actions = '';

    					$actions .='<a href="" class="btn btn-sm btn-outline-success m-btn m-btn--icon">
                            <span>
                                <i class="la la-edit"></i>
                                <span>Edit</span>
                            </span>
                        </a> &nbsp;
                        <a href="'.route('delete_servingArea', [$row->id]).'" onclick="return confirm('.$delete_confirmation_msg.')" class="btn btn-sm btn-outline-danger m-btn m-btn--icon">
                            <span>
                                <i class="la la-trash"></i>
                                <span>Delete</span>
                            </span>
                        </a>';
                 

					

					//$data[$key]['id'] = $i;
					    $data[$key]['id'] = '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" name="product_id[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox"><span></span></label>';
					$data[$key]['name'] = $product_detail;
    
					$data[$key]['action'] = $actions;

				}

				## Response
				$response = array(
				  "draw" => intval($draw),
				  "iTotalRecords" => $totalRecords,
				  "iTotalDisplayRecords" => $totalRecordwithFilter,
				  "aaData" => $data
				);

				echo json_encode($response);

				exit();
			}

		} catch (Exception $e) {

            return $e->getMessage();
        }
}
	
	
	    public function store_servingArea(Request $request) {
			
			
		$tab_name=$request->tab_name;
		$dataArr['corporate_id']=$request->corporate_id;
		$dataArr['regional_id']=$request->regional_id;
		$dataArr['hotel_name']=$request->hotel_name;
		$dataArr['department']=$request->department;
		$dataArr['location_id']=$request->location_id;
		$dataArr['sub_location']=$request->sub_location;
       $dataArr['created_by']=Auth::user()->id;
			
				$ServingArea = ServingArea::insert($dataArr);
			if($ServingArea) {
			return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');	
			}
}
	
		    public function update_servingArea(Request $request) {
$tab_name=$request->tab_name;
		$dataArr['corporate_id']=$request->corporate_id;
		$dataArr['regional_id']=$request->regional_id;
		$dataArr['hotel_name']=$request->hotel_name;
		$dataArr['department']=$request->department;
		$dataArr['location_id']=$request->location_id;
		$dataArr['sub_location']=$request->sub_location;

				
				
			$ServingArea = ServingArea::where('id', $request->update_servingArea_id)->update($dataArr);
			 return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');
}
	
			    public function delete_servingArea($id) {
    	$retData=ServingArea::where('id',$id)->delete();
return redirect()->route('nutrilator',['tab_name' => 2])->with('success', 'Delete Successfully');
}	
	   
	/******************* End Serving Area *************/
	
	
			    public function update_datarefrence(Request $request) {
			        $tab_name=$request->tab_name;
				    	 $dataArr['name']=$request->name;
			$ServingArea = DB::table('refrences')->where('id', $request->update_servingArea_id)->update($dataArr);
			return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');
}
	
				    public function delete_datarefrence($id) {
    	$retData=DB::table('refrences')->where('id',$id)->delete();
return redirect()->route('nutrilator',['tab_name' => 3])->with('success', 'Delete Successfully');
}
					    public function deleteproduct_Ingredients($id) {
    	$retData=DB::table('product_Ingredients')->where('id',$id)->delete();
return redirect()->route('nutrilator',['tab_name' => 4])->with('success', 'Delete Successfully');
}



					    public function deleteproduct_allergen($id) {
    	$retData=DB::table('product_Ingredients')->where('id',$id)->delete();
return redirect()->route('nutrilator',['tab_name' => 5])->with('success', 'Delete Successfully');
}


	
						    public function deleteIngredients($id) {
		
    	$retData=DB::table('Ingredient')->where('id',$id)->delete();
return redirect()->route('nutrilatornew')->with('success', 'Delete Successfully');
}
	
	
		    public function refrences_store(Request $request) {
			    	 $tab_name=$request->tab_name;
			    	 $dataArr['name']=$request->name;
       $dataArr['created_by']=Auth::user()->id;
				$ServingArea = DB::table('refrences')->insert($dataArr);
			if($ServingArea) {
			return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');	
			}
}
	
	
			    public function product_Ingredients(Request $request) {
			        $tab_name=$request->tab_name;
			    	 $dataArr['name']=$request->name;
					$dataArr['type']=$request->type;
       $dataArr['created_by']=Auth::user()->id;
					
							      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
					
					
				$ServingArea = DB::table('product_Ingredients')->insert($dataArr);
			if($ServingArea) {
			 return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');	
			}
}
	
				    public function editproduct_Ingredients(Request $request) {
				        $tab_name=$request->tab_name;
			    	 $dataArr['name']=$request->name;
							      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
				$ServingArea = DB::table('product_Ingredients')->where('id',$request->id)->update($dataArr);
			 return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');		
}
	
	
	
					   public function store_Ingredient(Request $request)
{
    
   
    $data = $request->all();

    $Refrence_order = DB::table('refrences')->where('id', $request->Refrence)->first();
    $tab_name = $request->tab_name;

    $dataArr['name'] = $request->name;
    $dataArr['Keyword'] = $request->Keyword;
    $dataArr['Ingredients_Symbol'] = $request->Ingredients_Symbol;
    $dataArr['Refrence'] = $request->Refrence;
    $dataArr['order_by'] = $Refrence_order->sr_no ?? NULL;
    $dataArr['Allergen'] = is_array($request->Allergen) ? implode(',', $request->Allergen) : $request->Allergen;
    $dataArr['Energy'] = $request->Energy;
    $dataArr['Protein'] = $request->portion;
    $dataArr['portion_lable'] = $request->portion;
    $dataArr['portion'] = $request->Protein;
    $dataArr['Carbohydrates'] = $request->Carbohydrates;
    $dataArr['Fat'] = $request->Fat;

    $login_user = Session::get('unit_id') ?? Auth::user()->id;
    $dataArr['created_by'] = $login_user ?? '';

    if (!empty($request->edit_id)) {
        // Update Ingredient
        DB::table('Ingredient')->where('id', $request->edit_id)->update($dataArr);
        $Ingredients_id = $request->edit_id;

        // Delete old keywords
        DB::table('Ingredients_keyword')->where('Ingredients_id', $Ingredients_id)->delete();
    } else {
        // Insert Ingredient
        DB::table('Ingredient')->insert($dataArr);
        $Ingredients_id = DB::getPdo()->lastInsertId();
    }

    // Insert new keywords
    $keywords = explode(',', $request->Keyword);
    foreach ($keywords as $keyword) {
        $keyword = trim($keyword);
        if (!empty($keyword)) {
            DB::table('Ingredients_keyword')->insert([
                'Ingredients_id' => $Ingredients_id,
                'name' => $keyword,
            ]);
        }
    }

    // Optional: Link to recipe if exists
    if (!empty($request->recipe_id)) {
        $logo_name = Helper::IngredientsLogo($Ingredients_id);
        $name = DB::table('product_Ingredients')->where('id', $request->Ingredients_Symbol)->first();

        $dataArr1['Ingredients_id'] = $Ingredients_id;
        $dataArr1['Quantity'] = "100";
        $dataArr1['recipe_id'] = $request->recipe_id;
        $dataArr1['slug'] = $request->recipe_slug;
        $dataArr1['logo_name'] = $name->name ?? '';
        $dataArr1['created_by'] = $login_user ?? '';

        DB::table('recipe_items')->insert($dataArr1);

        //return redirect()->back()->with('success', 'Ingredient updated successfully.');
    }
    
    
        return response()->json(['success' => true]);

           // return response()->json(['message' => 'Ingredient updated successfully']);


   // return redirect()->route('nutrilatornew')->with('add_department', !empty($request->edit_id) ? 'Update Successfully' : 'Add Successfully');
}

	
	
						    public function update_Ingredient(Request $request) {
						        
						       
					$tab_name=$request->tab_name;
			    	 		$dataArr['name']=$request->name;
							$dataArr['Keyword']=$request->Keyword;
					
							$dataArr['Ingredients_Symbol']=$request->Ingredients_Symbol;
							$dataArr['Refrence']=$request->Refrence;
							$dataArr['Allergen']=json_encode($request->Allergen);
							$dataArr['Energy']=$request->Energy;
							$dataArr['Protein']=$request->Protein;
								$dataArr['Carbohydrates']=$request->Carbohydrates;
							$dataArr['Fat']=$request->Fat;
	DB::table('Ingredient')->where('id',$request->editIngredients_id)->update($dataArr);
			return redirect()->route('nutrilator',['tab_name' => $tab_name])->with('add_department', 'Add Successfully');			
}
	
		   public function Ingredientslist(Request $request) {

		  $name = $request->name ?? '';
		  $s_date= $request->s_date ?? '';
		  $e_date = $request->e_date ?? '';
		  $Ingredients_Symbol = $request->Ingredients_Symbol ?? '';
		  $Refrence = $request->Refrence ?? '';

			   
if(!empty(Session::get('unit_id'))  ){

    $products = DB::table('Ingredient')->where('created_by',Session::get('unit_id'))->where('status',1)->get();
}

else{
    
    
    $products = DB::table('Ingredient');
    if(!empty($name)){
    $products->where('name', 'LIKE', "%$name%"); 
    $products->orWhere('Keyword', 'LIKE', "%$name%"); 
    }
    
    if(!empty($s_date && $e_date)  ){
    $products =  $products->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
    }
    
    if(!empty($Ingredients_Symbol)  ){
    $products =  $products->where('Ingredients_Symbol', $Ingredients_Symbol);  
    }
    
    if(!empty($Refrence)  ){
    $products =  $products->where('Refrence', $Refrence);
    
    }
    
    $products = $products->where('created_by',Auth::user()->id)->where('status',1)->get();
}
						   

        if(request()->ajax()) {

            $columns = array(
                0   =>'Ingredients_Symbol',
                1   =>'name',
                2   =>'Keyword',
                3   =>'Refrence',
                4   =>'Allergen',
                5   => 'Energy',
				6   =>'Protein',
                7   =>'Carbohydrates',
                8   =>'Fat',
				9   =>'create_at',
				10   =>'action',
                );

            ## Read value
                $draw = request('draw');

                $row = request('start');

                $rowperpage = request('length'); // Rows display per page

                $columnIndex = request('order.0.column'); // Column index

                $columnName = request('columns')[$columnIndex]['data']; // Column name

                $columnSortOrder = request('order.0.dir'); // asc or desc

                $searchValue = request('search.value'); // Search value



if(!empty(Session::get('unit_id'))  ){

                                
                $totalRecords = DB::table('Ingredient');
if(!empty($name)){
$totalRecords->where('name', 'LIKE', "%$name%"); 
$totalRecords->orWhere('Keyword', 'LIKE', "%$name%"); 
}

if(!empty($s_date && $e_date)  ){
$totalRecords =  $totalRecords->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
}

if(!empty($Ingredients_Symbol)  ){
$totalRecords =  $totalRecords->where('Ingredients_Symbol', $Ingredients_Symbol);  
}

if(!empty($Refrence)  ){
$totalRecords =  $totalRecords->where('Refrence', $Refrence);

}

$totalRecords = $totalRecords->where('created_by',Session::get('unit_id'))->where('status',1)->get()->count();
                
                          ## Total number of record with filtering
                          
                          
$totalRecordwithFilter = DB::table('Ingredient');
if(!empty($name)){
$totalRecordwithFilter->where('name', 'LIKE', "%$name%"); 
$totalRecordwithFilter->orWhere('Keyword', 'LIKE', "%$name%"); 
}

if(!empty($s_date && $e_date)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
}

if(!empty($Ingredients_Symbol)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->where('Ingredients_Symbol', $Ingredients_Symbol);  
}

if(!empty($Refrence)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->where('Refrence', $Refrence);

}

$totalRecordwithFilter = $totalRecordwithFilter->where('created_by',Session::get('unit_id'))->where('status',1)->get()->count();



                                
$products = DB::table('Ingredient');
if(!empty($name)){
$products->where('name', 'LIKE', "%$name%"); 
$products->orWhere('Keyword', 'LIKE', "%$name%"); 
}

if(!empty($s_date && $e_date)  ){
$products =  $products->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
}

if(!empty($Ingredients_Symbol)  ){
$products =  $products->where('Ingredients_Symbol', $Ingredients_Symbol);  
}

if(!empty($Refrence)  ){
$products =  $products->where('Refrence', $Refrence);

}
    
    $products = $products->offset($row)->limit($rowperpage)->where('created_by',Session::get('unit_id'))->where('status',1)->orderBy('id', 'desc')->get();

}

else{

                $totalRecords = DB::table('Ingredient');
if(!empty($name)){
$totalRecords->where('name', 'LIKE', "%$name%"); 
$totalRecords->orWhere('Keyword', 'LIKE', "%$name%"); 
}

if(!empty($s_date && $e_date)  ){
$totalRecords =  $totalRecords->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
}

if(!empty($Ingredients_Symbol)  ){
$totalRecords =  $totalRecords->where('Ingredients_Symbol', $Ingredients_Symbol);  
}

if(!empty($Refrence)  ){
$totalRecords =  $totalRecords->where('Refrence', $Refrence);

}

$totalRecords = $totalRecords->where('created_by',Auth::user()->id)->where('status',1)->get()->count();
                
                          ## Total number of record with filtering
                          
                          
$totalRecordwithFilter = DB::table('Ingredient');
if(!empty($name)){
$totalRecordwithFilter->where('name', 'LIKE', "%$name%"); 
$totalRecordwithFilter->orWhere('Keyword', 'LIKE', "%$name%"); 
}

if(!empty($s_date && $e_date)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
}

if(!empty($Ingredients_Symbol)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->where('Ingredients_Symbol', $Ingredients_Symbol);  
}

if(!empty($Refrence)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->where('Refrence', $Refrence);

}

$totalRecordwithFilter = $totalRecordwithFilter->where('created_by',Auth::user()->id)->where('status',1)->get()->count();



                                
$products = DB::table('Ingredient');
if(!empty($name)){
$products->where('name', 'LIKE', "%$name%"); 
$products->orWhere('Keyword', 'LIKE', "%$name%"); 
}

if(!empty($s_date && $e_date)  ){
$products =  $products->whereDate('create_at', '>=', $s_date)->whereDate('create_at', '<=', $e_date);  
}

if(!empty($Ingredients_Symbol)  ){
$products =  $products->where('Ingredients_Symbol', $Ingredients_Symbol);  
}

if(!empty($Refrence)  ){
$products =  $products->where('Refrence', $Refrence);

}
    
    $products = $products->offset($row)->limit($rowperpage)->where('created_by',Auth::user()->id)->where('status',1)->orderBy('id', 'desc')->get();

}


      

                $data = array();

                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
			  $allergenslist='';
			$delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row) {
                    $i++;
                    
                    		$Allergen = json_decode($row->Allergen);
					$Allergenlist=array();
					$Refrence =Helper::refrencesName($row->Refrence);
					$allergenslist='';
                    if($Allergen){
                    foreach($Allergen as $Allergenlistss ){
                    $Allergenlist[]= $Allergenlistss;
                    }
                    
                    $Allergenarray=array_unique($Allergenlist);
                    $allergenslist='';
                    if($Allergenarray){
                    foreach($Allergenarray as  $Allergens){
                    if(Helper::Ingredientsimage($Allergens)){
                    $allergenslist .='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="202303241641Soya.png" alt="`"   style=" width: 40px !important; margin: 0px !important;">';
                    }
                    }
                    }
                    }
                    else{
                    $allergenslist = '';
                    }
                    
                    
                    
				// 	$Allergen = json_decode($row->Allergen);
					
				// 	$Refrence =Helper::refrencesName($row->Refrence);
				// 					if($Allergen){
						
				// 		foreach($Allergen as  $Allergens) {
				// 				if(Helper::Ingredientsimage($Allergens)){
				// 					$allergenslist ='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="" alt="photo"  height="40" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
				// 				}
				// 		}
				// 	}
				// 	else{
				// 	$allergenslist = '';
				// 	}	
		
					   $image = '<img src="'.$url.Helper::Ingredientsimage($row->Ingredients_Symbol).'" class="" alt="photo"  height="60" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
          
                 $actions = ''; 
					
					
								$actions .=' <i   class="font-20 bx bxs-edit edit_data" data-id="'.$row->id.'"></i>

                        <a href="'.route('deleteIngredients', [$row->id]).'" onclick="return confirm('.$delete_confirmation_msg.')" >
                       <i href="" class="font-20 bx bxs-trash"></i>
                        </a>';
					
					
				
					
					
					   $data[$key]['checkbox'] = '<label id="equpitments_detailss7_'.$row->id.'" class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand checkboxequpitmentsvalue7"><input type="checkbox" name="product_quantity[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox checkboxequpitmentsvalue7"><span></span></label>';
	$data[$key]['sr_no'] =$i ;				
 $data[$key]['Ingredients_Symbol'] =$image ;
					 $data[$key]['name'] = $row->name;
					 $data[$key]['Keyword'] = $row->Keyword;
					 $data[$key]['Refrence'] = $Refrence;
					 $data[$key]['Allergen'] = $allergenslist ?? '';
					 $data[$key]['Energy'] = $row->Energy;
					 $data[$key]['Protein'] = $row->Protein;
					 $data[$key]['Carbohydrates'] = $row->Carbohydrates;
					 $data[$key]['Fat'] = $row->Fat;
					$data[$key]['create_at'] = $row->create_at;
					$data[$key]['action'] = $actions ?? '';

                }

                ## Response
                $response = array(
                  "draw" => intval($draw),
                  "iTotalRecords" => $totalRecords,
                  "iTotalDisplayRecords" => $totalRecordwithFilter,
                  "aaData" => $data
                );

                echo json_encode($response);

                exit();
        }

        return view('admin.nutrilator.nutrilator');
			   
 
	   }


	public function Ingredient_details(Request $request){
		
			$result = DB::table('Ingredient')->where('id', $request->id)->first();
	
	return view('admin.popups.nutrilator.editingredient', compact('result'));
	}
	
	
													    public function delete_all_ingredient(Request $request) {
							     $ids = $request->ids;
								foreach($ids as $idss){
								    DB::table("Ingredient")->where('id',$idss)->delete();  
								}
        return response()->json(['success'=>" Deleted successfully."]);  
}
	
	
	
	
	public function copy_ingredient_items(Request $request)
{
    $id = $request->input('id');

    // Step 1: Get original ingredient
    $original = DB::table('Ingredient')->where('id', $id)->first();

    if (!$original) {
        return response()->json(['message' => 'Ingredient not found'], 404);
    }

    // Step 2: Prepare new ingredient data
    $newName = 'Copy of ' . $original->name;
    $newSlug = Str::slug($newName . '-' . uniqid());

    $dataArr = [
        'name' => $newName,
        'Ingredients_Symbol' => $original->Ingredients_Symbol ?? '',
        'Ingredients_Specification' => $original->Ingredients_Specification ?? '',
        'Refrence' => $original->Refrence ?? '',
        'Allergen' => $original->Allergen ?? '',
        'Energy' => $original->Energy ?? '',
        'Protein' => $original->Protein ?? '',
        'Carbohydrates' => $original->Carbohydrates ?? '',
        'Fat' => $original->Fat ?? '',
        'create_at' => now(),
    ];

    // Use unit_id from session or authenticated user
    if (!empty(Session::get('unit_id'))) {
        $dataArr['created_by'] = Session::get('unit_id');
    } else {
        $dataArr['created_by'] = Auth::user()->id ?? 0;
    }

    // Step 3: Insert into Ingredient table
    $newId = DB::table('Ingredient')->insertGetId($dataArr);

    // Step 4: Copy keywords
    $keywords = DB::table('Ingredients_keyword')->where('Ingredients_id', $id)->get();

    foreach ($keywords as $keyword) {
        DB::table('Ingredients_keyword')->insert([
            'Ingredients_id' => $newId,
            'name' => $keyword->name,
            'created_at' => now()
        ]);
    }

    // Optional: Return new data (for AJAX frontend update)
    $newIngredient = DB::table('Ingredient')->where('id', $newId)->first();

    return response()->json([
        'message' => 'Ingredient duplicated successfully',
        'data' => $newIngredient
    ]);
}
	
	
	public function keyword_ingredient_items(Request $request) {
                    $dataArr['Ingredients_id']=$request->id ?? '';
                    $dataArr['name']=$request->keyword ?? '';
					DB::table('Ingredients_keyword')->insert($dataArr);  
    
        return response()->json(['success'=>" Added successfully."]);  
  
}

public function ingredient_items_status(Request $request)
{
    $id = $request->input('id');
    $status = $request->input('status');

    // Validate inputs
    if (!$id || !in_array($status, ['active', 'inactive'])) {
        return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
    }

    // Convert string status to numeric: active = 1, inactive = 0
    $statusValue = $status === 'active' ? 1 : 0;

    // Update in database
    $updated = DB::table('Ingredient')->where('id', $id)->update([
        'status' => $statusValue,
        'update_at' => now()
    ]);

    if ($updated) {
        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to update status.']);
    }
}


public function ingredient_protinupdate(Request $request)
{
    
    $id = $request->input('id');
    $updated = DB::table('Ingredient')->where('id', $id)->update([
        'portion' => $request->input('grams'),
        'portion_lable' => $request->input('label'),
        'update_at' => now()
    ]);

    if ($updated) {
        return response()->json(['success' => true, 'message' => 'updated successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to update status.']);
    }
}


public function recipe_protinupdate(Request $request)
{
    
    $id = $request->input('id');
    $updated = DB::table('Recipe')->where('id', $id)->update([
        'final_Weight' => $request->input('grams'),
        'portion_lable' => $request->input('label'),
        'updated_at' => now()
    ]);

    if ($updated) {
        return response()->json(['success' => true, 'message' => 'updated successfully.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to update status.']);
    }
}

public function ingredient_keyworddelate(Request $request)
{
  
    $id = $request->input('id');
    $retData=DB::table('Ingredients_keyword')->where('Ingredients_id',$id)->delete();
        return response()->json(['success' => true, 'message' => 'updated successfully.']);
    
}



public function deleteIngredientslist(Request $request)
{
    $ids = $request->input('ids'); // Get IDs from query or POST data
    if (!is_array($ids)) {
        return response()->json(['error' => 'Invalid input'], 400);
    }
        $retData=DB::table('Ingredient')->whereIn('id',$ids)->delete();
    return response()->json(['success' => true, 'deleted_ids' => $ids]);
}

public function deleterecipelists(Request $request)
{
    $ids = $request->input('ids'); // Get IDs from query or POST data
    if (!is_array($ids)) {
        return response()->json(['error' => 'Invalid input'], 400);
    }
        $retData=DB::table('Recipe')->whereIn('id',$ids)->delete();
        $retData=DB::table('recipe_items')->whereIn('recipe_id',$ids)->delete();
    return response()->json(['success' => true, 'deleted_ids' => $ids]);
}


	public function ingredient_recipe_items(Request $request)
{
    
    
    
      $ingredientId = $request->input('ingredient_id');


if(!empty(Session::get('unit_id'))  ){
    $data = DB::table('recipe_items as ri')
        ->join('Recipe as r', 'ri.recipe_id', '=', 'r.id')
        ->select('r.name as name', 'ri.Quantity')
        ->where('ri.Ingredients_id', $ingredientId)
        ->where('ri.created_by', Session::get('unit_id'))
        ->get();
    
}else{
    $data = DB::table('recipe_items as ri')
        ->join('Recipe as r', 'ri.recipe_id', '=', 'r.id')
        ->select('r.name as name', 'ri.Quantity')
        ->where('ri.Ingredients_id', $ingredientId)
        ->where('ri.created_by', Auth::user()->id)
        ->get();
}
    

    return response()->json($data);
}

	
}
