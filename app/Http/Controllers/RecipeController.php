<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB,Helper,Str;
use App\Models\ServingArea;
use App\Models\Recipe;
use App\Models\RecipeItem;
use Illuminate\Support\Facades\Session;

use Illuminate\Routing\Controller as BaseController;

class RecipeController extends BaseController
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
		$refrences = DB::table('refrences')->orderBy('id', 'DESC')->get();
		$product = DB::table('product_Ingredients')->where('type',"1")->orderBy('id', 'DESC')->get();
			$Ingredients = DB::table('product_Ingredients')->where('type',"2")->orderBy('id', 'DESC')->get();
		
		
$nutrilator_measurement_unit_list = DB::table('nutrilator_measurement_unit')->get();
		$servingareas= ServingArea::all();
		$authority = DB::table('authority')->orderBy('id', 'DESC')->get();
		$Ingredientlist = DB::table('Ingredient')->orderBy('id', 'DESC')->get();
		
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
		
		
		
return view('admin.nutrilator.measurement',compact('nutrilator_measurement_unit_list','servingareas','departments','authority','refrences','product','Ingredients','Ingredientlist','tab_name'));
}


 public function export_recipe_data() {
  return view('admin.nutrilator.Recipe.recipe_pdf');   
 }
 
 
 
 
  public function edit_recipe_print($name) {
      
      $details = DB::table('Recipe')->where('id', $name)->first();
        $Refrence = DB::table('refrences')->get();
        
        
        							   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
		   ->where('recipe_items.logo_name', "Non-Veg")
            ->orderBy('recipe_items.id', 'desc')->first();
	   
	   if(!empty($Ingredientlistlast)){
	   $Ingredientlistlast=$Ingredientlistlast;
	   }
	   else{
	   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('recipe_items.id', 'desc')->first();
	   }
	   
													

													
														$Ingredientlist = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
				  ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('id', 'desc')->get();
         
     return view('admin.nutrilator.Recipe.recipe_details_pdf',compact('details','Refrence','Ingredientlistlast','Ingredientlist'));
 }




    public function edit_recipe($name) {
        
        $details = DB::table('Recipe')->where('id', $name)->first();
        $Refrence = DB::table('refrences')->get();
        
        
        							   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
		   ->where('recipe_items.logo_name', "Non-Veg")
            ->orderBy('recipe_items.id', 'desc')->first();
	   
	   if(!empty($Ingredientlistlast)){
	   $Ingredientlistlast=$Ingredientlistlast;
	   }
	   else{
	   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('recipe_items.id', 'desc')->first();
	   }
	   
													

													
														$Ingredientlist = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
				  ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('id', 'desc')->get();
 
         
     return view('admin.nutrilator.Recipe.recipe_details',compact('details','Refrence','Ingredientlistlast','Ingredientlist'));
}
	
				    public function nutrilator_measurement_unit_edit(Request $request) {
    		 $dataArr['name']=$request->name;
		 $dataArr['si_unit_name']=$request->si_unit_name;
					          DB::table('nutrilator_measurement_unit')->where('id',$request->nutrilator_measurement_unit_edit_id)->update($dataArr);
		return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');
}
	
		    public function destory($id) {
    	$retData=DB::table('nutrilator_measurement_unit')->where('id',$id)->delete();
return redirect()->route('nutrilator')->with('success', 'Delete Successfully');
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
			
			
		$dataArr['corporate_id']=$request->corporate_id;
		$dataArr['regional_id']=$request->regional_id;
		$dataArr['hotel_name']=$request->hotel_name;
		$dataArr['department']=$request->department;
		$dataArr['location_id']=$request->location_id;
		$dataArr['sub_location']=$request->sub_location;
       $dataArr['created_by']=Auth::user()->id;
			
				$ServingArea = ServingArea::insert($dataArr);

			if($ServingArea) {
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');	
			}
}
	
		    public function update_servingArea(Request $request) {

		$dataArr['corporate_id']=$request->corporate_id;
		$dataArr['regional_id']=$request->regional_id;
		$dataArr['hotel_name']=$request->hotel_name;
		$dataArr['department']=$request->department;
		$dataArr['location_id']=$request->location_id;
		$dataArr['sub_location']=$request->sub_location;

				
				
			$ServingArea = ServingArea::where('id', $request->update_servingArea_id)->update($dataArr);
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');	
}
	
			    public function delete_servingArea($id) {
    	$retData=ServingArea::where('id',$id)->delete();
return redirect()->route('nutrilator')->with('success', 'Delete Successfully');
}	
	   
	/******************* End Serving Area *************/
	
	

	
				    public function delete_datarefrence($id) {
    	$retData=DB::table('refrences')->where('id',$id)->delete();
return redirect()->route('nutrilator')->with('success', 'Delete Successfully');
}
					    public function deleteproduct_Ingredients($id) {
    	$retData=DB::table('product_Ingredients')->where('id',$id)->delete();
return redirect()->route('nutrilator')->with('success', 'Delete Successfully');
}
	
						    public function deleteIngredients($id) {
    	$retData=DB::table('Ingredient')->where('id',$id)->delete();
return redirect()->route('nutrilator')->with('success', 'Delete Successfully');
}
	
	
		    public function refrences_store(Request $request) {
			    	 $dataArr['name']=$request->name;
       $dataArr['created_by']=Auth::user()->id;
				$ServingArea = DB::table('refrences')->insert($dataArr);
			if($ServingArea) {
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');	
			}
}
	
	
			    public function product_Ingredients(Request $request) {
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
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');	
			}
}
	
				    public function editproduct_Ingredients(Request $request) {
			    	 $dataArr['name']=$request->name;
							      if($request->file('company_logo')){
                        $file= $request->file('company_logo');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('companylogo'), $filename);
                        $dataArr['company_logo']= $filename;
                    }
				$ServingArea = DB::table('product_Ingredients')->where('id',$request->id)->update($dataArr);
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');			
}
	
	
	
					    public function store_Ingredient(Request $request) {
					
				 		$dataArr['name']=$request->name;
							$dataArr['Keyword']=$request->Keyword;
	
							$dataArr['Ingredients_Symbol']=$request->Ingredients_Symbol;
							$dataArr['Refrence']=$request->Refrence;
							$dataArr['Allergen']=json_encode($request->Allergen);
							$dataArr['Energy']=$request->Energy;
							$dataArr['Protein']=$request->Protein;
								$dataArr['Carbohydrates']=$request->Carbohydrates;
							$dataArr['Fat']=$request->Fat;
	DB::table('Ingredient')->insert($dataArr);
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');			
}
	
	
						    public function update_Ingredient(Request $request) {
					
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
			return redirect()->route('nutrilator')->with('add_department', 'Add Successfully');			
}
	
		   public function search_recipe(Request $request) {
		       
		  
		
        $products = DB::table('Ingredient')->get();

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


		  $name = $request->search_name ?? '';
		 $product_ids = $request->product_ids ?? '';
                    $Ingredientlist = DB::table('Ingredient');

                    if(!empty($name)){
                    $Ingredientlist->where('name', 'LIKE', "%$name%"); 
                    }


                    if(!empty($product_ids)){
                    $Ingredientlist->whereIn('Refrence', $product_ids);
                    }
                $totalRecords = $Ingredientlist->get()->count();


                ## Total number of record with filtering
                
                     $Ingredientlist = DB::table('Ingredient');

                    if(!empty($name)){
                    $Ingredientlist->where('name', 'LIKE', "%$name%"); 
                    }
                    
                      if(!empty($product_ids)){
                    $Ingredientlist->whereIn('Refrence', $product_ids);
                    }
                    
                $totalRecordwithFilter = $Ingredientlist->get()->count();

                ## Fetch records
                
                
                
                $Ingredientlist = DB::table('Ingredient');
                  if(!empty($name)){
                    $Ingredientlist->where('name', 'LIKE', "%$name%"); 
                    }
                      if(!empty($product_ids)){
                    $Ingredientlist->whereIn('Refrence', $product_ids);
                    }
                    
                    
                      $products = $Ingredientlist->offset($row)
                                ->limit($rowperpage)
                                ->orderBy('order_by', 'asc')
                                ->get();
               

                $data = array();

                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
			  $allergenslist='';
			$delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row) {
                    
              
                    $i++;
					$Allergen = json_decode($row->Allergen);
					
					$Refrence =Helper::refrencesName($row->Refrence);
					$allergenslist='';
									if($Allergen){
						
						foreach($Allergen as  $Allergens) {
								if(Helper::Ingredientsimage($Allergens)){
									$allergenslist ='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="" alt="photo"  height="40" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
								}
						}
					}
					else{
					$allergenslist = '';
					}	
		
					   $image = '<img src="'.$url.Helper::Ingredientsimage($row->Ingredients_Symbol).'" class="" alt="photo"  height="60" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
          
                 $actions = ''; 
                 $ids = "'".$row->id."'"; 
					
					
								$actions .=' <a  class="btn btn add_items" style="    color: #fff; background-color: #17a00e;"  href="javascript:;" onclick="add_recipe_item('.$ids.')">Add</a>';
			
					   $data[$key]['checkbox'] = '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" name="product_quantity[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox"><span></span></label>';
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
	   
	    
		   public function search_recipe1(Request $request) {
		       
		 
        $products = DB::table('recipe_items')->where('recipe_id',$request->id)->get();

        if(request()->ajax()) {
            
            			
			

            $columns = array(
                0   =>'serving_size',
                1   =>'Ingredients_Symbol',
                2   =>'Quantity',
                3   =>'name',
                4   =>'Refrence',
                5   =>'Allergen',
                6   => 'Energy',
				7   =>'Protein',
                8   =>'Carbohydrates',
                9   =>'Fat',
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


                $totalRecords = DB::table('recipe_items')->where('recipe_id',$request->id)->get()->count();


                ## Total number of record with filtering
                $totalRecordwithFilter = DB::table('recipe_items')->where('recipe_id',$request->id)->get()->count();

                ## Fetch records
                $products = DB::table('recipe_items')->where('recipe_id',$request->id)->offset($row)
                                ->limit($rowperpage)
                                
                                ->orderBy('id', 'desc')
                                ->get();

                $data = array();

                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
			  $allergenslist='';
			$delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row1) {
                    
                     $row1->Ingredients_id;
                    
                   $row = DB::table('Ingredient')->where('id',$row1->Ingredients_id)->first();
                   
                 // echo "<pre>";
                  //print_r($row);
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
		
	
					   $image = '<img src="'.$url.Helper::Ingredientsimage($row->Ingredients_Symbol).'" class="" alt="photo"  height="60" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
          
                 $actions = ''; 
                 $Quantity = ''; 
                 $ids = "'".$row->id."'"; 
                 $idss = "'".$row1->id."'"; 
		
		$delete_confirmation_msg = "'Are you sure you want to delete?'";
								$actions .=' <a  class="btn btn "  href="'.route('delete_recipe_item', [$row1->id]).'" onclick="return confirm('.$delete_confirmation_msg.') "><i class="font-20 bx bxs-trash"></i></a>';
								
								   
								
																$Quantity .=' <input class="form-control" id="recipe_item_'.$row1->id.'" onchange="update_recipe_item('.$idss.')" type="number" value="'.$row1->Quantity.'">';
			
			
		$data[$key]['sr_no'] =$i ;		
	$data[$key]['serving_size'] =Helper::RecipeServiceSize($row1->recipe_id) ;				
 $data[$key]['Ingredients_Symbol'] =$image ;
 $data[$key]['Quantity'] =$Quantity ;
 

					 $data[$key]['name'] = $row->name;
					 $data[$key]['Refrence'] = $Refrence;
					 $data[$key]['Allergen'] = $allergenslist ?? '';
					 $data[$key]['Energy'] = number_format((int)$row->Energy/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Protein'] = number_format((int)$row->Protein/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Carbohydrates'] = number_format((int)$row->Carbohydrates/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Fat'] = number_format((int)$row->Fat/100*$row1->Quantity, 2, '.', '');
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

		   }
			   
 
	   public function search_recipe2(Request $request) {
		
        $products = DB::table('recipe_items')->where('recipe_id',$request->id)->get();

        if(request()->ajax()) {
            
            			
			

            $columns = array(
                0   =>'serving_size',
                1   =>'Ingredients_Symbol',
                2   =>'Quantity',
                3   =>'name',
                4   =>'Refrence',
                5   =>'Allergen',
                6   => 'Energy',
				7   =>'Protein',
                8   =>'Carbohydrates',
                9   =>'Fat',
                );

            ## Read value
                $draw = request('draw');

                $row = request('start');

                $rowperpage = request('length'); // Rows display per page

                $columnIndex = request('order.0.column'); // Column index

                $columnName = request('columns')[$columnIndex]['data']; // Column name

                $columnSortOrder = request('order.0.dir'); // asc or desc

                $searchValue = request('search.value'); // Search value


                $totalRecords = DB::table('recipe_items')->where('recipe_id',$request->id)->get()->count();


                ## Total number of record with filtering
                $totalRecordwithFilter = DB::table('recipe_items')->where('recipe_id',$request->id)->get()->count();

                ## Fetch records
                $products = DB::table('recipe_items')->where('recipe_id',$request->id)->offset($row)
                                ->limit($rowperpage)
                                
                                ->orderBy('id', 'desc')
                                ->get();

                $data = array();

                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
			  $allergenslist='';
			$delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row1) {
                    
                   $row = DB::table('Ingredient')->where('id',$row1->Ingredients_id)->first();
                    $i++;
					$Allergen = json_decode($row->Allergen);
					
					$Refrence =Helper::refrencesName($row->Refrence);
									if($Allergen){
						
						foreach($Allergen as  $Allergens) {
								if(Helper::Ingredientsimage($Allergens)){
									$allergenslist ='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="" alt="photo"  height="40" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
								}
						}
					}
					else{
					$allergenslist = '';
					}	
		
					   $image = '<img src="'.$url.Helper::Ingredientsimage($row->Ingredients_Symbol).'" class="" alt="photo"  height="60" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
          
                 $actions = ''; 
                 $Quantity = ''; 
                 $ids = "'".$row->id."'"; 
                 $idss = "'".$row1->id."'"; 
		
		$delete_confirmation_msg = "'Are you sure you want to delete?'";
								$actions .=' <a  class="btn btn "  href="'.route('delete_recipe_item', [$row1->id]).'" onclick="return confirm('.$delete_confirmation_msg.') "><i class="font-20 bx bxs-trash"></i></a>';
								
								   
								
																$Quantity .=' <input class="form-control" id="recipe_item_'.$row1->id.'" onchange="update_recipe_item('.$idss.')" type="number" value="'.$row1->Quantity.'">';
			
			
		$data[$key]['sr_no'] =$i ;		
	$data[$key]['serving_size'] =Helper::RecipeServiceSize($row1->recipe_id) ;				
 $data[$key]['Ingredients_Symbol'] =$image ;
 $data[$key]['Quantity'] =$Quantity ;
 

					 $data[$key]['name'] = $row->name;
					 $data[$key]['Refrence'] = $Refrence;
					 $data[$key]['Allergen'] = $allergenslist ?? '';
					 $data[$key]['Energy'] = number_format($row->Energy/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Protein'] = number_format($row->Protein/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Carbohydrates'] = number_format($row->Carbohydrates/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Fat'] = number_format($row->Fat/100*$row1->Quantity, 2, '.', '');
			


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

		   }
		   
		   
		   public function search_recipe4(Request $request) {
		
        $products = DB::table('recipe_items')->where('recipe_id',$request->id)->get();

        if(request()->ajax()) {
            
            			
			

            $columns = array(
                0   =>'serving_size',
                1   =>'Ingredients_Symbol',
                2   =>'Quantity',
                3   =>'name',
                4   =>'Refrence',
                5   =>'Allergen',
                6   => 'Energy',
				7   =>'Protein',
                8   =>'Carbohydrates',
                9   =>'Fat',
				10   =>'Created At',
                );

            ## Read value
                $draw = request('draw');

                $row = request('start');

                $rowperpage = request('length'); // Rows display per page

                $columnIndex = request('order.0.column'); // Column index

                $columnName = request('columns')[$columnIndex]['data']; // Column name

                $columnSortOrder = request('order.0.dir'); // asc or desc

                $searchValue = request('search.value'); // Search value


                $totalRecords = DB::table('recipe_items')->where('recipe_id',$request->id)->get()->count();


                ## Total number of record with filtering
                $totalRecordwithFilter = DB::table('recipe_items')->where('recipe_id',$request->id)->get()->count();

                ## Fetch records
                $products = DB::table('recipe_items')->where('recipe_id',$request->id)->offset($row)
                                ->limit($rowperpage)
                                
                                ->orderBy('id', 'desc')
                                ->get();

                $data = array();

                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
			  $allergenslist='';
			$delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row1) {
                    
                   $row = DB::table('Ingredient')->where('id',$row1->Ingredients_id)->first();
                    $i++;
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
		
					   $image = '<img src="'.$url.Helper::Ingredientsimage($row->Ingredients_Symbol).'" class="" alt="photo"  height="60" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
          
                 $actions = ''; 
                 $Quantity = ''; 
                 $ids = "'".$row->id."'"; 
                 $idss = "'".$row1->id."'"; 
		
		$delete_confirmation_msg = "'Are you sure you want to delete?'";
								$actions .=' <a  class="btn btn "  href="'.route('delete_recipe_item', [$row1->id]).'" onclick="return confirm('.$delete_confirmation_msg.') "><i class="font-20 bx bxs-trash"></i></a>';
								
								   
								
																$Quantity .=' <input class="form-control" id="recipe_item_'.$row1->id.'" onchange="update_recipe_item('.$idss.')" type="number" value="'.$row1->Quantity.'">';
			
			
		$data[$key]['sr_no'] =$i ;		
	$data[$key]['serving_size'] =Helper::RecipeServiceSize($row1->recipe_id) ;				
 $data[$key]['Ingredients_Symbol'] =$image ;
 $data[$key]['Quantity'] =$row1->Quantity ?? '' ;
 

					 $data[$key]['name'] = $row->name;
					 $data[$key]['Refrence'] = $Refrence;
					 $data[$key]['Allergen'] = $allergenslist ?? '';
					 $data[$key]['Energy'] = number_format((int)$row->Energy/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Protein'] = number_format((int)$row->Protein/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Carbohydrates'] = number_format((int)$row->Carbohydrates/100*$row1->Quantity, 2, '.', '');
					 $data[$key]['Fat'] = number_format((int)$row->Fat/100*$row1->Quantity, 2, '.', '');
					$data[$key]['create_at'] = $row->create_at;
					$data[$key]['action'] = $row->create_at ?? '';

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

		   }
		   
		   

	public function Ingredient_details(Request $request){
		
			$row = DB::table('Ingredient')->where('id', $request->id)->first();
		$Allergen='';
		$url ="https://safefoodmitra.com/efsm/admin/public/public/companylogo/";
		$Allergen = json_decode($row->Allergen);
		
									if($Allergen){
						
						foreach($Allergen as  $Allergens) {
						
						}
					}
					else{
					$allergenslist = '';
					}	
		
		
					 $data['id'] =$row->id;
		             $data['Ingredients_Symbol'] =$row->Ingredients_Symbol;
					 $data['name'] = $row->name;
					 $data['Keyword'] = $row->Keyword;
					 $data['Refrence'] = $row->Refrence;
					 $data['Allergen'] = $Allergen ?? '';
					 $data['Energy'] = $row->Energy;
					 $data['Protein'] = $row->Protein;
					 $data['Carbohydrates'] = $row->Carbohydrates;
					 $data['Fat'] = $row->Fat;
					$data['create_at'] = $row->create_at;
		
		
		
		    echo json_encode($data);
	exit();

	
	}
	
	
	
		   public function delete_all_recipe(Request $request) {
					
		
							
	   }
	   
	   
	   public function add_recipe(Request $request) {
	       
	       
	        if(!empty(Session::get('unit_id'))  ){
	          $login_user=  Session::get('unit_id');
	        }
	        
	        else{
	         $login_user=  Auth::user()->id;   
	        }
					$slug = Str::slug($request->name);
				 		$dataArr['name']=$request->name;
				 		$dataArr['created_by']=$login_user;
							$dataArr['slug']=Str::slug($request->name);;
							
							
							DB::table('Recipe')->insert($dataArr);
							
							$id = DB::getPdo()->lastInsertId();

							
							return redirect()->route('edit_recipe', ['slug' => $id])->with('message', 'State saved correctly!!!');

							
	   }
	   
	   
	   
	   	   public function add_recipe_item(Request $request) {
	   	    
	   	        $slug = Helper::RecipeSlug($request->recipe_id);
	   	        $logo_name = Helper::IngredientsLogo($request->id);
	   	     
				
				 		$dataArr['Quantity']="100";
				 		$dataArr['recipe_id']=$request->recipe_id ?? '';
				 		$dataArr['Ingredients_id']=$request->id ?? '';
				 		$dataArr['slug']=$slug ?? '';
				 		$dataArr['logo_name']=$logo_name ?? '';
				 		 $dataArr['created_by']=Auth::user()->id;
		
							DB::table('recipe_items')->insert($dataArr);
							
						 ## Response
                $response = array(
               
                  "message" => "Add Data Succesfully."
                );

                echo json_encode($response);

                exit();

							
	   }
	   
	   
	   
	   
	   
	   
	   			    public function update_recipe_details_item(Request $request) {
				    	 $dataArr['final_Weight']=$request->final_Weight;
				    	 $dataArr['Weight_change']=$request->Weight_change;
				    	 
				    	 $dataArr1['final_Weight']=$request->final_Weight;
				    	 $dataArr1['Weight_change']=$request->Weight_change;
				    	 
				    	 
			$ServingArea = DB::table('Recipe')->where('id', $request->id)->update($dataArr);
			$ServingArea = DB::table('recipe_items')->where('recipe_id', $request->id)->update($dataArr1);
		    echo json_encode($ServingArea);
	exit();
}	  

	   			    public function update_recipe(Request $request) {
				    	 $dataArr['serving_size']=$request->size;
			$ServingArea = DB::table('Recipe')->where('id', $request->id)->update($dataArr);
		    echo json_encode($ServingArea);
	exit();
}	   	




public function update_recipe_item(Request $request) {
   
				    	 $dataArr['Quantity']=$request->Quantity;
			$ServingArea = DB::table('recipe_items')->where('id', $request->id)->update($dataArr);
		    echo json_encode($ServingArea);
	exit();
}	   			  

public function update_recipe_items(Request $request) {

				    	 $dataArr['name']=$request->name;
			$ServingArea = DB::table('Recipe')->where('id', $request->id)->update($dataArr);
		    echo json_encode($ServingArea);
	exit();
}

public function storeOrUpdate(Request $request)
{
    
   
    if(!empty(Session::get('unit_id'))  ){
	          $login_user=  Session::get('unit_id');
	        }
	        
	        else{
	         $login_user=  Auth::user()->id;   
	        }
    
   $data = $request->all();

    $request->validate([
        'name' => 'required|string',
        'servings' => 'required|integer|min:1',
        'portion' => 'required|numeric|min:0',
        'symbol' => 'required|string',
        'allergen' => 'nullable|string',
        'refrence' => 'nullable|string',
        'description' => 'nullable|string',
        'notes' => 'nullable|string',
        'energy' => 'nullable|numeric',
        'protein' => 'nullable|numeric',
        'carb' => 'nullable|numeric',
        'fat' => 'nullable|numeric',
        'ingredients' => 'required|array|min:1',
        'ingredients.*.ingredientId' => 'required|integer',
        'ingredients.*.quantity' => 'required|numeric|min:0.01',
    ]);

    // If ID is present, update existing recipe
    if (!empty($data['id'])) {
        $recipe = Recipe::find($data['id']);
        if (!$recipe) {
            return response()->json(['success' => false, 'message' => 'Recipe not found']);
        }
        $recipe->update([
            'name' => $data['name'],
            'serving_size' => $data['servings'],
            'portion' => $data['portion'],
            'symbol' => $data['symbol'],
            'allergen' => $data['allergen'],
            'refrence' => $data['refrence'],
            'description' => $data['description'],
            'notes' => $data['notes'],
            'energy' => $data['energy'],
            'protein' => $data['protein'],
            'carb' => $data['carb'],
            'fat' => $data['fat'],
            'final_Weight' => $data['finalWeight'],
            'Weight_change' => $data['weightChange'],
           
        ]);

        // Delete old ingredients and insert new
        RecipeItem::where('recipe_id', $recipe->id)->delete();
    } else {
        // Create new recipe
        $recipe = Recipe::create([
            'name' => $data['name'],
            'serving_size' => $data['servings'],
            'portion' => $data['portion'],
            'symbol' => $data['symbol'],
            'allergen' => $data['allergen'],
            'refrence' => $data['refrence'],
            'description' => $data['description'],
            'notes' => $data['notes'],
            'energy' => $data['energy'],
            'protein' => $data['protein'],
            'carb' => $data['carb'],
             'created_by' => $login_user,
            'fat' => $data['fat'],
            'final_Weight' => $data['finalWeight'],
            'isActive' =>1,
            'Weight_change' => $data['weightChange'],
        
        ]);
    }

    // Save recipe ingredients
    foreach ($data['ingredients'] as $ing) {
        RecipeItem::create([
            'recipe_id' => $recipe->id,
            'Ingredients_id' => $ing['ingredientId'],
            'Quantity' => $ing['quantity']
        ]);
    }

    return response()->json(['success' => true, 'recipe_id' => $recipe->id]);
}
	
	
			    public function delete_save_recipe($id) {
			   
    	$retData=DB::table('Recipe')->where('id',$id)->delete();
    	$retData=DB::table('recipe_items')->where('recipe_id',$id)->delete();
    	return redirect()->back()->with('success', 'your message,here');
 //return redirect()->route('nutrilator',['tab_name' => 7])->with('add_department', 'Add Successfully');
}	


			    public function delete_recipe_item($id) {
    	$retData=DB::table('recipe_items')->where('id',$id)->delete();
return redirect()->back()->with('success', 'your message,here');  
}

			    public function copy_recipe_items($id) {
			        
	
			     
    	$retData=DB::table('Recipe')->where('id',$id)->first();
    	
    		 	$slug = Str::slug($retData->name);
    	
    			
    			
    		 	$slug_details="copy".$slug;
    		 	
    	
    	
				 		$dataArr1['name']=$retData->name;
							$dataArr1['slug']=$slug_details;
							
									if(!empty(Session::get('unit_id'))  ){
				 		 $dataArr1['created_by']=Session::get('unit_id');
				 		}
				 		
				 		else{
				 		$dataArr1['created_by']=Auth::user()->id;
				 		}

							DB::table('Recipe')->insert($dataArr1);

						$insertid =DB::getPdo()->lastInsertId();


    	$recipe_items=DB::table('recipe_items')->where('recipe_id',$id)->get();
    	
    	foreach($recipe_items as $recipe_itemss){
    
	   	        $logo_name = Helper::IngredientsLogo($recipe_itemss->Ingredients_id);
				 		$dataArr['Quantity']=$recipe_itemss->Quantity ?? '';
				 		$dataArr['recipe_id']=$insertid ?? '';
				 		$dataArr['Ingredients_id']=$recipe_itemss->Ingredients_id ?? '';
				 		$dataArr['slug']=$slug_details ?? '';
				 		$dataArr['logo_name']=$logo_name ?? '';
				 		
				 		if(!empty(Session::get('unit_id'))  ){
				 		 $dataArr['created_by']=Session::get('unit_id');
				 		}
				 		
				 		else{
				 		$dataArr['created_by']=Auth::user()->id;
				 		}
						DB::table('recipe_items')->insert($dataArr);  
    	}

								   	       
	            return redirect()->route('nutrilator',['tab_name' => "7"])->with('add_department', 'Add Successfully');

//return redirect()->back()->with('success', 'your message,here');  
}



    public function search_recipe3(Request $request) {
        
        
        
          $details = DB::table('Recipe')->where('id', $request->name)->first();
        $Refrence = DB::table('refrences')->get();
        
        
        							   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
		   ->where('recipe_items.logo_name', "Non-Veg")
            ->orderBy('recipe_items.id', 'desc')->first();
	   
	   if(!empty($Ingredientlistlast)){
	   $Ingredientlistlast=$Ingredientlistlast;
	   }
	   else{
	   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('recipe_items.id', 'desc')->first();
	   }
	   
													

													
														$Ingredientlist = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
				  ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('id', 'desc')->get();
            
                $sum_quantity = 0;
                $sum_energy = 0 ;
                $sum_protin = 0 ;
                $sum_carb = 0 ;
                $sum_fat = 0 ;
            foreach($Ingredientlist as $Ingredientlists)
            {

                $sum_quantity += $Ingredientlists->Quantity;
                $sum_energy += (int)$Ingredientlists->Energy/100*$Ingredientlists->Quantity;
                $sum_protin += (int)$Ingredientlists->Protein/100*$Ingredientlists->Quantity;
                $sum_carb += (int)$Ingredientlists->Carbohydrates/100*$Ingredientlists->Quantity;
                $sum_fat += (int)$Ingredientlists->Fat/100*$Ingredientlists->Quantity;
                $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
            }
            
            
            
            		if(!empty($details->final_Weight)){
												
											 $final_Weight = $details->final_Weight; }
												
												else{
											 $final_Weight = $sum_quantity/$details->serving_size ?? ''; 

											}
											
											$Ingredientlists_name='';
											foreach($Ingredientlist as $Ingredientlists) {
											    $Ingredientlists_name .=$Ingredientlists->name.',';
											}
											
								
						   
						   $Refrencesl=array();

						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Refrencelist[] = json_decode($Ingredientlists->Refrence);
						
					
						   $Refrencelist=array_unique($Refrencelist);
							   
							   }
					
						
						   $Refrence='';
						foreach($Refrencelist as $Ingredientlists){ 
						    $Refrence .= Helper::refrencesName1($Ingredientlists).',' ;
						} 
							
							
							
						   $Allergenlist=array();
						   $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Allergenlists = json_decode($Ingredientlists->Allergen);
							   
							   foreach($Allergenlists as $Allergenlistss ){
								  $Allergenlist[]= $Allergenlistss;
							   }
					
						   }
					
						     $Allergenarray=array_unique($Allergenlist);
						     $image='';
						   		   if($Allergenarray){
						   foreach($Allergenarray as  $Allergens){
						   if(Helper::Ingredientsimage($Allergens)){
						   	   $image .='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="202303241641Soya.png" alt="`"   style=" width: 40px !important; margin: 0px !important;">';
						   }
						   }
						   		   }
						   		   
						   		   if($sum_fat){
						   		   
						   		  $sum_fat_value= number_format(($sum_fat/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '');
						   		   }
						   		   else{
						   		       
						   		       $sum_fat_value='';
						   		   }
						   		   
											
											
$html = '<tr class="odd">
<td>1</td>
<td class="sorting_1">'.$details->serving_size .'</td>
<td><img src="'.$url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol ?? '') .'" class="" alt="photo" style="width: 40px !important; "></td>
<td>'.$final_Weight.'</td>
<td class="sorting_1"> '.$Ingredientlists_name.' </td>
<td>'.$Refrence.'</td>
<td>
'.$image.'
</td>
<td>'.number_format($sum_energy/$details->serving_size ?? '', 2, '.', '').'</td>
<td>'.number_format($sum_protin/$details->serving_size ?? '', 2, '.', '').'</td>
<td>'.number_format($sum_carb/$details->serving_size ?? '', 2, '.', '').'</td>
<td>'.number_format($sum_fat/$details->serving_size ?? '', 2, '.', '').'</td>
</tr>
<tr class="odd">
<td>2</td>
<td class="sorting_1">'.$details->serving_size .'</td>
<td><img src="'.$url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol ?? '') .'" class="" alt="photo" style="width: 40px !important; "></td>
<td>100</td>
<td class="sorting_1"> '.$Ingredientlists_name.' </td>
<td>'.$Refrence.'</td>

<td>
'.$image.'
</td>
<td>'.number_format(($sum_energy/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '').'</td>
<td>'.number_format(($sum_protin/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '').'</td>
<td>'.number_format(($sum_carb/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '').'</td>
<td>'.$sum_fat_value.'</td>
</tr>';


$Ingredientsimage = '<img src="'.$url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol ?? '') .'" class="" alt="photo" style="width: 100px !important; ">';
$output['data'] = $html;
$output['Serving_size'] = $final_Weight;
$output['box1'] = number_format($sum_energy/$details->serving_size ?? '', 2, '.', '');
$output['box2'] = number_format($sum_protin/$details->serving_size ?? '', 2, '.', '');
$output['box3'] = number_format($sum_carb/$details->serving_size ?? '', 2, '.', '');
$output['box4'] = number_format($sum_fat/$details->serving_size ?? '', 2, '.', '');
$output['Ingredientsimage'] = $Ingredientsimage;

// echo "<pre>";
// print_r($Ingredientlists->Allergen);
//die;


	$dataArr['name']=$details->name;
$dataArr['Ingredients_Symbol']=$Ingredientlistlast->Ingredients_Symbol ?? '';
$dataArr['Refrence']='10';
$dataArr['order_by']='7';
$dataArr['Allergen']=json_encode($Allergenarray);
$dataArr['Energy']=number_format(($sum_energy/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '');
$dataArr['Protein']=number_format(($sum_protin/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '');
$dataArr['Carbohydrates']=number_format(($sum_carb/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '');
$dataArr['Fat']=$sum_fat_value ?? '';
$dataArr['status']=0;



if(!empty(Session::get('unit_id'))  ){
$login_user=  Session::get('unit_id');
}

else{
$login_user=  Auth::user()->id;   
}
$dataArr['created_by']=$login_user ?? '';
    $result =  DB::table('Ingredient')->where('name',$details->name)->where('created_by',$login_user)->first();
 
    if(!empty($result)){
        
        DB::table('Ingredient')->where('name',$details->name)->where('created_by',$login_user)->update($dataArr); 

    }
    
    else{
        DB::table('Ingredient')->insert($dataArr);  

    }
return response()->json($output);

    }
public function search_recipe5(Request $request) {
        
        
        
          $details = DB::table('Recipe')->where('id', $request->name)->first();
        $Refrence = DB::table('refrences')->get();
        
        
        							   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
		   ->where('recipe_items.logo_name', "Non-Veg")
            ->orderBy('recipe_items.id', 'desc')->first();
	   
	   if(!empty($Ingredientlistlast)){
	   $Ingredientlistlast=$Ingredientlistlast;
	   }
	   else{
	   $Ingredientlistlast = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
			
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('recipe_items.id', 'desc')->first();
	   }
	   

													
														$Ingredientlist = DB::table('Ingredient')
            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
				  ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
						->where('recipe_items.recipe_id', $details->id)
            ->orderBy('id', 'desc')->get();
            
    
            
                $sum_quantity = 0;
                $sum_energy = 0 ;
                $sum_protin = 0 ;
                $sum_carb = 0 ;
                $sum_fat = 0 ;
            foreach($Ingredientlist as $Ingredientlists)
            {

                $sum_quantity += $Ingredientlists->Quantity;
                $sum_energy += (int)$Ingredientlists->Energy/100*$Ingredientlists->Quantity;
                $sum_protin += (int)$Ingredientlists->Protein/100*$Ingredientlists->Quantity;
                $sum_carb += (int)$Ingredientlists->Carbohydrates/100*$Ingredientlists->Quantity;
                $sum_fat += (int)$Ingredientlists->Fat/100*$Ingredientlists->Quantity;
                $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
            }
            
            
            
            		if(!empty($details->final_Weight)){
												
											 $final_Weight = $details->final_Weight; }
												
												else{
											 $final_Weight = $sum_quantity/$details->serving_size ?? ''; 

											}
											
											$Ingredientlists_name='';
											foreach($Ingredientlist as $Ingredientlists) {
											    $Ingredientlists_name .=$Ingredientlists->name.',';
											}
											
								
						   
						   $Refrencesl=array();

						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Refrencelist[] = json_decode($Ingredientlists->Refrence);
						
					
						   $Refrencelist=array_unique($Refrencelist);
							   
							   }
					
						
						   $Refrence='';
						foreach($Refrencelist as $Ingredientlists){ 
						    $Refrence .= Helper::refrencesName1($Ingredientlists).',' ;
						} 
							
							
							
						   $Allergenlist=array();
						   $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
						   foreach($Ingredientlist as $Ingredientlists ){
						   
							   $Allergenlists = json_decode($Ingredientlists->Allergen);
							   
							   foreach($Allergenlists as $Allergenlistss ){
								  $Allergenlist[]= $Allergenlistss;
							   }
					
						   }
					
						     $Allergenarray=array_unique($Allergenlist);
						     $image='';
						   		   if($Allergenarray){
						   foreach($Allergenarray as  $Allergens){
						   if(Helper::Ingredientsimage($Allergens)){
						   	   $image .='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="202303241641Soya.png" alt="`"   style=" width: 40px !important; margin: 0px !important;">';
						   }
						   }
						   		   }
						   		   
						   		   if($sum_fat){
						   		   
						   		  $sum_fat_value= number_format(($sum_fat/$details->serving_size ?? '')/($final_Weight)*100, 2, '.', '');
						   		   }
						   		   else{
						   		       
						   		       $sum_fat_value='';
						   		   }
						   		   
						   		   
						   		   $Initial_weight = $sum_quantity/$details->serving_size;
						   		   $Weight_change =$details->Weight_change ?? '';
											
											
$html = '<tr class="odd">
<td>1</td>
<td class="sorting_1">'.$details->serving_size .'</td>
<td><img src="'.$url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol ?? '') .'" class="" alt="photo" style="width: 40px !important; "></td>
<td>'.$Initial_weight.'</td>
<td class="sorting_1"> '.$Ingredientlists_name.' </td>
<td>'.$Refrence.'</td>
<td>
'.$image.'
</td>
<td>'.number_format($sum_energy/$details->serving_size ?? '', 2, '.', '').'</td>
<td>'.number_format($sum_protin/$details->serving_size ?? '', 2, '.', '').'</td>
<td>'.number_format($sum_carb/$details->serving_size ?? '', 2, '.', '').'</td>
<td>'.number_format($sum_fat/$details->serving_size ?? '', 2, '.', '').'</td>
</tr>';



$unit_name = Helper::user_info($details->created_by)->company_name;


$html1='<tbody><tr>
               <td width="50%">Unit Name:  '.$unit_name.'</td>
               <td align="right">Reference to Protocol:<br> FSSAI Guidance Notes on Menu Labeling </td>
            </tr>
            <tr>
               <td>Recipe Name: '.$details->name.' <img src="veg-icon.png" width="20" alt="" style="vertical-align: middle;"></td>
               <td align="right">Portion Number: 01, Portion Size: '.$final_Weight.' g/m</td>
            </tr>
            
            <tr>
               <td>Data Reference: '.$Refrence.'</td>
               <td align="right">Allergen Ingredients:  '.$image.'</td>
						   
					
            </tr>
            
         </tbody>';


$output['data'] = $html;
$output['data1'] = $html1;
$output['Initial_weight'] = $Initial_weight;
$output['final_Weight'] = $final_Weight;
$output['Weight_change'] = $Weight_change;
return response()->json($output);
        
    }





		   public function Recipeslist(Request $request) {



			   $r_name = $request->r_name?? '';
			   $r_sdate = $request->r_sdate?? '';
			   $r_edate = $request->r_edate?? '';

	
                if(!empty(Session::get('unit_id'))  ){
                    
                    
                    $products = DB::table('Recipe');
                    
                    if(!empty($r_name)){
                    $products->where('name', 'LIKE', "%$r_name%"); 
                    }
                    
                    if(!empty($r_sdate && $r_edate)  ){
                    $products =  $products->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
                    }
                    
                    
                    $products = $products->where('created_by',Session::get('unit_id'))->get();
                }
                
                else{
                
                       $products = DB::table('Recipe');
                    
                    if(!empty($r_name)){
                    $products->where('name', 'LIKE', "%$r_name%"); 
                    }
                    
                    if(!empty($r_sdate && $r_edate)  ){
                    $products =  $products->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
                    }
                    
                    $products = $products->where('created_by',Auth::user()->id)->get();
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
    
    
    $totalRecords = DB::table('Recipe');

if(!empty($r_name)){
$totalRecords->where('name', 'LIKE', "%$r_name%"); 
}

if(!empty($r_sdate && $r_edate)  ){
$totalRecords =  $totalRecords->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
}

$totalRecords = $totalRecords->where('created_by',Session::get('unit_id'))->get()->count();



$totalRecordwithFilter = DB::table('Recipe');

if(!empty($r_name)){
$totalRecordwithFilter->where('name', 'LIKE', "%$r_name%"); 
}

if(!empty($r_sdate && $r_edate)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
}

$totalRecordwithFilter = $totalRecordwithFilter->where('created_by',Session::get('unit_id'))->count();





$products = DB::table('Recipe');

if(!empty($r_name)){
$products->where('name', 'LIKE', "%$r_name%"); 
}

if(!empty($r_sdate && $r_edate)  ){
$products =  $products->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
}

$products = $products->offset($row)->limit($rowperpage)->where('created_by',Session::get('unit_id'))->orderBy('id', 'desc')->get();



}

else{
    




$totalRecords = DB::table('Recipe');

if(!empty($r_name)){
$totalRecords->where('name', 'LIKE', "%$r_name%"); 
}

if(!empty($r_sdate && $r_edate)  ){
$totalRecords =  $totalRecords->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
}

$totalRecords = $totalRecords->where('created_by',Auth::user()->id)->get()->count();



$totalRecordwithFilter = DB::table('Recipe');

if(!empty($r_name)){
$totalRecordwithFilter->where('name', 'LIKE', "%$r_name%"); 
}

if(!empty($r_sdate && $r_edate)  ){
$totalRecordwithFilter =  $totalRecordwithFilter->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
}

$totalRecordwithFilter = $totalRecordwithFilter->where('created_by',Auth::user()->id)->count();





$products = DB::table('Recipe');

if(!empty($r_name)){
$products->where('name', 'LIKE', "%$r_name%"); 
}

if(!empty($r_sdate && $r_edate)  ){
$products =  $products->whereDate('created_at', '>=', $r_sdate)->whereDate('created_at', '<=', $r_edate);  
}

$products = $products->offset($row)->limit($rowperpage)->where('created_by',Auth::user()->id)->orderBy('id', 'desc')->get();


                    


        ## Total number of record with filtering
 

}


      

                $data = array();
                
                $delete_confirmation_msg = "'Are you sure you want to delete?'";
                $i =$row;
                $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
                $allergenslist='';
                $delete_confirmation_msg = "'Are you sure you want to delete?'";
			
                foreach($products as $key => $row) {
                    $i++;
			
                    $actions = ''; 
                    $actions .=' <i   class="font-20 bx bxs-edit edit_data" data-id="'.$row->id.'"></i>
                    
                    <a href="'.route('deleteIngredients', [$row->id]).'" onclick="return confirm('.$delete_confirmation_msg.')" >
                    <i href="" class="font-20 bx bxs-trash"></i>
                    </a>';
                    
                    
                    $buttons='<div class="dropdown">
                    <i class="font-20 bx bx-menu" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>                                                          
                    
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="'.route('edit_recipe', [$row->id]).'">Edit</a></li>
                    <li>
                    <a class="dropdown-item" href="'.route('delete_save_recipe', [$row->id]).'"  onclick="return confirm('.$delete_confirmation_msg.')">Delete</a>
                    
                    </li>
                    
                    <li><a class="dropdown-item"  href="'.route('copy_recipe_items', [$row->id]).'">Duplicate</a></li>
                    <li><a class="dropdown-item" href="'.route('edit_recipe_print', [$row->id]).'"   target="_blank">Export</a></li>
                    <li><a class="dropdown-item" href="#">Generate</a></li>
                    <li><a class="dropdown-item" href="#">Buffet Tag</a></li>
                    </ul>
                    </div>';
        
                    $ProductNature	 = ''; 
                    			$url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
                    			
                            $Ingredientlistlast = DB::table('Ingredient')
                            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
                            
                            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
                            ->where('recipe_items.recipe_id', $row->id)
                            ->where('recipe_items.logo_name', "Non-Veg")
                            ->orderBy('recipe_items.id', 'desc')->first();
                            
                            if(!empty($Ingredientlistlast)){
                            $Ingredientlistlast=$Ingredientlistlast;
                            }
                            else{
                            $Ingredientlistlast = DB::table('Ingredient')
                            ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
                            
                            ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id','recipe_items.id as ids')
                            ->where('recipe_items.recipe_id', $row->id)
                            ->orderBy('recipe_items.id', 'desc')->first();
                            }

if(!empty($Ingredientlistlast->Ingredients_Symbol)){
    
 					   $image = '<img src="'.$url.Helper::Ingredientsimage($Ingredientlistlast->Ingredients_Symbol).'" class="" alt="photo"  height="60" width="40" style="max-height: 40px !important; max-width: 40px !important; margin: 0px !important;">';
   
}

else{
     $image = '';
    
}
					
			
                                $Ingredientlist = DB::table('Ingredient')
                                ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
                                ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
                                ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
                                ->where('recipe_items.recipe_id', $row->id)
                                ->orderBy('id', 'desc')->get();
											
                          $sum_quantity = 0;
$sum_energy = 0;
$sum_protin = 0;
$sum_carb = 0;
$sum_fat = 0;

foreach($Ingredientlist as $Ingredientlists) {
    $sum_quantity += $Ingredientlists->Quantity; 
    $sum_energy += (int)$Ingredientlists->Energy / 100 * $Ingredientlists->Quantity;
    $sum_protin += (int)$Ingredientlists->Protein / 100 * $Ingredientlists->Quantity; 
    $sum_carb += (int)$Ingredientlists->Carbohydrates / 100 * $Ingredientlists->Quantity;
    $sum_fat += (int)$Ingredientlists->Fat / 100 * $Ingredientlists->Quantity; 
}

if (!empty($row->final_Weight)) {
    $final_Weight = $row->final_Weight;
} else {
    // Check if $sum_quantity and $row->serving_size are not zero before division
    $final_Weight = ($sum_quantity != 0 && $row->serving_size != 0) ? $sum_quantity / $row->serving_size : 0;
}
					   $final_Weight = number_format($final_Weight?? '', 2, '.', '');
				$product_name= '<input type="text" id="recipe_name_'.$row->id.'" onkeyup="update_recipe_details_item('.$row->id.')" class="form-control" value="'.$row->name.'">';

                        $Ingredientlist = DB::table('Ingredient')
                        ->join('recipe_items', 'Ingredient.id', '=', 'recipe_items.Ingredients_id')
                        ->join('Recipe', 'recipe_items.recipe_id', '=', 'Recipe.id')
                        ->select('Ingredient.*', 'recipe_items.Quantity','recipe_items.Ingredients_id', 'Recipe.name as recipename','Recipe.serving_size')
                        ->where('recipe_items.recipe_id', $row->id)
                        ->orderBy('id', 'desc')->get();

				
					                      $Ingredientlists_name = '' ;
										foreach($Ingredientlist as $Ingredientlists){
                                $Ingredientlists_name .= $Ingredientlists->name ; 
                               
							}
							
                            $Allergenlist=array();
                            $url ="https://safefoodmitra.com/efsm/admin/public/companylogo/";
                            foreach($Ingredientlist as $Ingredientlists ){
                            
                            $Allergenlists = json_decode($Ingredientlists->Allergen);
                            $allergenslist='';
                            
                            foreach($Allergenlists as $Allergenlistss ){
                            $Allergenlist[]= $Allergenlistss;
                            }
                            }
                            $Allergenarray=array_unique($Allergenlist);
                            
                            
                            if($Allergenarray){
                                
                               				foreach($Allergenarray as $Allergens){
                               				    
                               				    	if(Helper::Ingredientsimage($Allergens)){
									$allergenslist .='<img src="'.$url.Helper::Ingredientsimage($Allergens).'" class="'.Helper::Ingredientsimage($Allergens).'" alt="photo"  height="55" width="50" style="max-height: 55px !important; max-width: 50px !important; margin: 0px !important;">';
								}

							} 
                            }

					   
$serving_size = ($row->serving_size != 0) ? $row->serving_size : 1; // Default to 1 if serving size is zero
$Energy = number_format($sum_energy / $serving_size, 2, '.', '');
$Protien = number_format($sum_protin / $serving_size, 2, '.', '');
$Carb = number_format($sum_carb / $serving_size, 2, '.', '');
$Fat = number_format($sum_fat / $serving_size, 2, '.', '');
					   

                        $data[$key]['checkbox'] = '<label id="equpitments_detailss7_'.$row->id.'" class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand checkboxequpitmentsvalue7"><input type="checkbox" name="product_quantity[]" value="'.$row->id.'" id="stock_qtys_'.$row->id.'" class="product_qty m-checkable checkbox checkboxequpitmentsvalue7"><span></span></label>';
                        $data[$key]['sr_no'] =$i ;				
                        $data[$key]['Ingredients_Symbol'] =$row->updated_at;
                        $data[$key]['name'] = $image;
                        $data[$key]['Keyword'] = $final_Weight;
                        $data[$key]['Refrence'] = $product_name;
                        $data[$key]['Allergen'] = $Ingredientlists_name ?? '';
                        $data[$key]['Energy'] = $allergenslist;
                        $data[$key]['Protein'] = $Energy;
                        $data[$key]['Carbohydrates'] = $Protien;
                        $data[$key]['Fat'] = $Carb;
                        $data[$key]['create_at'] = $Fat;
                        $data[$key]['action'] = $buttons ?? '';

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


	public function copy_recipe_itemslist(Request $request)
{
    $id = $request->input('id');

    // Step 1: Find the original Recipe
    $original = Recipe::with('items')->find($id);

    if (!$original) {
        return response()->json(['message' => 'Recipe not found'], 404);
    }

    // Step 2: Duplicate the Recipe
    $newRecipe = $original->replicate(); // creates a copy without saving
    $newRecipe->name = 'Copy of ' . $original->name;
    $newRecipe->created_by = Session::get('unit_id') ?? Auth::id();
    $newRecipe->created_at = now();
    $newRecipe->updated_at = now();
    $newRecipe->save(); // saves the new recipe

    // Step 3: Copy each RecipeItem
    foreach ($original->items as $item) {
        $newItem = $item->replicate(); // creates copy of item
        $newItem->recipe_id = $newRecipe->id;
        $newItem->created_at = now();
        $newItem->updated_at = now();
        $newItem->save();
    }

    return response()->json([
        'message' => 'Recipe and items duplicated successfully',
        'data' => $newRecipe
    ]);
}


	public function change_recipe_status(Request $request)
{
    $id = $request->input('id');
    $isActive = filter_var($request->input('isActive'), FILTER_VALIDATE_BOOLEAN); // ensures boolean
    $deactivatedOn = $isActive ? null : now(); // if false, set current datetime


if($isActive== true){
   $isActive1=$isActive; 
    
}else{
       $isActive1=NULL; 

}
    $updated = DB::table('Recipe')
        ->where('id', $id)
        ->update([
            'isActive' => $isActive1,
            'deactivatedOn' => $deactivatedOn,
            'updated_at' => now()
        ]);

    if ($updated) {
        return response()->json(['message' => 'Recipe status updated successfully']);
    } else {
        return response()->json(['message' => 'Recipe not found'], 404);
    }
}



public function getPaginatedRecipes(Request $request)
{
    
    
    $per_page = $request->per_page ?? 10;
    $search   = $request->search ?? null;
    
    
    if(!empty($search)){
        
         if(!empty(Session::get('unit_id'))  ){
            $recipes = Recipe::where('created_by',Session::get('unit_id'))->where('name', 'like', "%{$search}%")->orderBy('id', 'DESC')->paginate($per_page); // or $request->input('limit', 10)
}
else{
        $recipes = Recipe::where('created_by',Auth::user()->id)->where('name', 'like', "%{$search}%")->orderBy('id', 'DESC')->paginate($per_page); // or $request->input('limit', 10)
}
        
    }else{
        
       
        if(!empty(Session::get('unit_id'))  ){
            $recipes = Recipe::where('created_by',Session::get('unit_id'))->orderBy('id', 'DESC')->paginate($per_page); // or $request->input('limit', 10)
}
else{
        $recipes = Recipe::where('created_by',Auth::user()->id)->orderBy('id', 'DESC')->paginate($per_page); // or $request->input('limit', 10)
} 
    }

   
    $recipes->getCollection()->transform(function ($recipe) {
 $unitDetails = DB::table('users')->where('id', $recipe->created_by)->first();
        $unitDetails2 = DB::table('users')->where('id', $unitDetails->created_by1 ?? 0)->first();
        $unitDetails3 = DB::table('users')->where('id', $unitDetails->created_by ?? 0)->first();
         $role = Auth::user()->is_role;
                

        if ($role == 3) {
        $unitName = $unitDetails->company_name ?? 'N/A';
    } elseif ($role == 2) {
        $corporateName = $unitDetails2->company_name ?? 'N/A';
    } elseif ($role == 1) {
        $regionalName = $unitDetails3->company_name ?? 'N/A';
    }
    
    

        return [
            'id'            => $recipe->id,
            'corporateName' => $corporateName ?? 'N/A',
            'regionalName'  => $regionalName ?? 'N/A',
            'unitName'      => $unitName ??  'N/A',
            'name'          => $recipe->name ?? '',
            'symbol'        => $recipe->symbol ?? '',
            'refrence'      => $recipe->refrence ?? '',
            'allergen'      => $recipe->allergen ?? '',
            'portion'       => (float) $recipe->final_Weight,
            'energy'        => (float) $recipe->energy,
            'protein'       => (float) $recipe->protein,
            'carb'          => (float) $recipe->carb,
            'fat'           => (float) $recipe->fat,
            'createdOn'     => $recipe->created_at ?? '',
            'isActive'      => $recipe->isActive ?? 0,
            'deactivatedOn' => $recipe->deactivatedOn ?? '',
            'servings'      => $recipe->serving_size ?? 0,
            'description'   => $recipe->description ?? '',
            'notes'         => $recipe->notes ?? '',
            'ingredients'   => DB::table('recipe_items')
                                ->where('recipe_id', $recipe->id)
                                ->get()
                                ->map(function ($item) {
                                    return [
                                        'ingredientId' => $item->Ingredients_id,
                                        'quantity'     => $item->Quantity ?? 0,
                                    ];
                                })
        ];
    });

    return response()->json($recipes);
}

	
}
