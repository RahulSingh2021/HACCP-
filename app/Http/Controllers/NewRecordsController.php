<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use DB;
use Helper;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Str;
class NewRecordsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function index(Request $request){
        
        return view('admin.new_record.index');
    }

    public function indexThawingRecord(Request $request)
    {
        
        /**main data*/
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
        
         
    
            $cop_name = null;
            $reg_name = null;
            $unit_name = null;
            $auth = DB::table('users')->where('id',Auth::id())->first();
            if ($auth->is_role == 1) {
                $corporate = DB::table('users')->where('id', $auth->id)->first();
                if ($corporate) {
                    $cop_name = $corporate->company_name;
        
                    $regional = DB::table('users')->where('created_by', $corporate->id)->first();
                    if ($regional) {
                        $reg_name = $regional->company_name;
        
                        $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                        if ($unit) {
                            $unit_name = $unit->company_name;
                        }
                    }
                }
        
            } elseif ($auth->is_role == 2) {
                $regional = DB::table('users')->where('id', $auth->id)->first();
                if ($regional) {
                    $reg_name = $regional->company_name;
        
                    $corporate = DB::table('users')->where('id', $regional->created_by)->first();
                    if ($corporate) {
                        $cop_name = $corporate->company_name;
                    }
        
                    $unit = DB::table('users')->where('created_by1', $regional->id)->first();
                    if ($unit) {
                        $unit_name = $unit->company_name;
                    }
                }
        
            } elseif ($auth->is_role == 3) {
                $unit = DB::table('users')->where('id', $auth->id)->first();
                if ($unit) {
                    $unit_name = $unit->company_name;
        
                    $corporate = DB::table('users')->where('id', $unit->created_by)->first();
                    if ($corporate) {
                        $cop_name = $corporate->company_name;
                    }
        
                    $regional = DB::table('users')->where('id', $unit->created_by1)->first();
                    if ($regional) {
                        $reg_name = $regional->company_name;
                    }
                }
            }
            
            
               $departments = DB::table('departments')
            ->join('locations', 'departments.id', '=', 'locations.department_id')
            ->whereIn('departments.unit_id', $user_ids)
            ->select('departments.*', 'locations.name as location_name', 'locations.id as location_id')
            ->get();
    
            
         $outlets = [];
        foreach ($departments as $department) {
            $outlets[] = [
                'id' => $department->id,
                'corporate' => $cop_name,
                'regional' => $reg_name,
                'unit' => $unit_name,
                'department' => $department->name,
                'location' => $department->location_name,
            ];
        }
        
        $user_name = Auth::user()->name;
        
            // 'outletsD' => $outlets,
            // 'user_name' => $user_name,
            
            
        $thrawings = DB::table('thawing_records')->where('created_by',$user_ids)->get();    
        foreach($thrawings as $thrawing){
            $issue_stock = DB::table('thawing_record_batch_issues')->where('thawing_record_id',$thrawing->id)->OrderBy('id','asc')->first();
            $thrawing->batchNumber = null;
            $thrawing->expiryDate = null;
            $thrawing->storedUnit = null;
            $thrawing->totalQty = 0;
            $thrawing->productId = null;
            $thrawing->quantity = null;
            $thrawing->manufacturingDate = null;
            $thrawing->stockInDate = null;
            if($issue_stock){
                   $thrawing->batchNumber = $issue_stock->batch_number;
                   $interactive = DB::table('advanced_interactive_stock_register')->where('id',$issue_stock->advanced_interactive_stock_register_id)->first();
                   $thrawing->expiryDate = $interactive->exp_date;
                    $thrawing->storedUnit = $interactive->storage;
                    $totalIssuedQty = DB::table('advanced_interactive_stock_register')
                        ->where('batch', $issue_stock->batch_number)
                        ->where('product', $thrawing->productName)
                        ->where('type', 'issue')
                        ->sum('issue_qty');                   
                    $thrawing->totalQty = $totalIssuedQty;
                    $thrawing->productId =$interactive->id;
                    $thrawing->quantity = $interactive->issue_qty;
                    $thrawing->manufacturingDate = $interactive->mfg_date;
                    $thrawing->stockInDate =  $interactive->received_date_time;
            }
            
        }
        
        return view('admin.new_record.thawing_record.list',compact('outlets','user_name','thrawings'));
    }
    
    // public function getIssueInteractiveStockRecords(Request $request){
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    
    //     $user_ids = [$user_id];
    
    //     if ($auth->is_role == 1) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user && $user->created_by) {
    //             $user_ids[] = $user->created_by;
    //         }
    //     } elseif (!in_array($auth->is_role, [0, 2])) {
    //         $user = DB::table('users')->where('id', $user_id)->first();
    //         if ($user) {
    //             if ($user->created_by) {
    //                 $user_ids[] = $user->created_by;
    //             }
    //             if ($user->created_by1) {
    //                 $user_ids[] = $user->created_by1;
    //             }
    //         }
    //     }
    
    //      $user_ids[] = 1; 
    //      $user_ids = array_unique($user_ids);
        
         
    
    //         $cop_name = null;
    //         $reg_name = null;
    //         $unit_name = null;
    //         $auth = DB::table('users')->where('id',Auth::id())->first();
    //         if ($auth->is_role == 1) {
    //             $corporate = DB::table('users')->where('id', $auth->id)->first();
    //             if ($corporate) {
    //                 $cop_name = $corporate->company_name;
        
    //                 $regional = DB::table('users')->where('created_by', $corporate->id)->first();
    //                 if ($regional) {
    //                     $reg_name = $regional->company_name;
        
    //                     $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //                     if ($unit) {
    //                         $unit_name = $unit->company_name;
    //                     }
    //                 }
    //             }
        
    //         } elseif ($auth->is_role == 2) {
    //             $regional = DB::table('users')->where('id', $auth->id)->first();
    //             if ($regional) {
    //                 $reg_name = $regional->company_name;
        
    //                 $corporate = DB::table('users')->where('id', $regional->created_by)->first();
    //                 if ($corporate) {
    //                     $cop_name = $corporate->company_name;
    //                 }
        
    //                 $unit = DB::table('users')->where('created_by1', $regional->id)->first();
    //                 if ($unit) {
    //                     $unit_name = $unit->company_name;
    //                 }
    //             }
        
    //         } elseif ($auth->is_role == 3) {
    //             $unit = DB::table('users')->where('id', $auth->id)->first();
    //             if ($unit) {
    //                 $unit_name = $unit->company_name;
        
    //                 $corporate = DB::table('users')->where('id', $unit->created_by)->first();
    //                 if ($corporate) {
    //                     $cop_name = $corporate->company_name;
    //                 }
        
    //                 $regional = DB::table('users')->where('id', $unit->created_by1)->first();
    //                 if ($regional) {
    //                     $reg_name = $regional->company_name;
    //                 }
    //             }
    //         }
            
            
    //           $departments = DB::table('departments')
    //         ->join('locations', 'departments.id', '=', 'locations.department_id')
    //         ->whereIn('departments.unit_id', $user_ids)
    //         ->select('departments.*', 'locations.name as location_name', 'locations.id as location_id')
    //         ->get();
    
            
    //      $outlets = [];
    //     foreach ($departments as $department) {
    //         $outlets[] = [
    //             'id' => $department->id,
    //             'corporate' => $cop_name,
    //             'regional' => $reg_name,
    //             'unit' => $unit_name,
    //             'department' => $department->name,
    //             'location' => $department->location_name,
    //         ];
    //     }
        
    //     $user_name = Auth::user()->name;

    //     return response()->json([
    //         'success' => true,
    //         'outletsD' => $outlets,
    //         'user_name' => $user_name,
    //     ]);
                         
    // }

    public function getIssueInteractiveProduct(Request $request){
        
        DB::table('advanced_interactive_stock_register')
        ->where('type', 'issue')
        ->whereNull('issue_to_thawing_record')
        ->update([
            'issue_to_thawing_record' => DB::raw('issue_qty')
        ]);
        
        /**main*/
        
        $corporate = $request->corporate;
        $regional = $request->regional;
        $unit = $request->unit;
        $department = $request->department;
        $location = $request->location;
        
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
        
        // $products = DB::table('advanced_interactive_stock_register')
        // ->where('issue_to_name', $location)
        // ->where('type', 'issue')
        // ->whereIn('created_by',$user_ids)
        // ->groupBy('product')
        // ->get();   

        $products = DB::table('advanced_interactive_stock_register')
            ->select(
                DB::raw('MIN(id) as id'),
                'issue_to_name',
                'product as name',
                'brand as brand'
            )
            ->where('issue_to_name', $location)
            ->where('type', 'issue')
            ->whereIn('created_by', $user_ids)
            ->groupBy('issue_to_name', 'product', 'brand')
            ->get();
    
        // Format products like your JS structure
        $formattedProducts = $products->map(function ($p) {
            return [
                'id' => (int) $p->id,
                'outletId' => 1, // if you have outlet_id column, replace with $p->outlet_id
                'name' => $p->name,
                'brand' => $p->brand ?? 'N/A',
            ];
        });
    
        return response()->json($formattedProducts);
         
        // return response()->json($products);

    }
    
    public function getIssueInteractiveProductDetails(Request $request){
        $request->validate([
        'product_id' => 'required',
        'product_name' => 'required|string',
        ]);
        
        
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
        
        // $batches = DB::table('advanced_interactive_stock_register')
        // ->where('product', $request->product_name)
        // ->whereIn('created_by', $user_ids)
        // ->where('type', 'issue') 
        // ->select(
        //     'id as productId',
        //     'batch as number',
        //     'issue_qty as quantity',
        //     'mfg_date as manufacturingDate',
        //     'created_at as stockInDate',
        //     'brand as storedUnit',
        //     'exp_date as expiryDate',
        //     'product as productName'
        // )
        // ->orderBy('created_at', 'desc')
        // ->get();
        
        
    
        $batches = DB::table('advanced_interactive_stock_register')
        ->where('product', $request->product_name)
        ->whereIn('created_by', $user_ids)
        ->where('type', 'issue') 
        ->where('issue_to_thawing_record', '>', 0)
        ->select(
            'id as productId',
            'batch as number',
            'issue_to_thawing_record as quantity',
            'mfg_date as manufacturingDate',
            'created_at as stockInDate',
            'storage as storedUnit',
            'exp_date as expiryDate',
            'product as productName'
        )
        ->orderBy('created_at', 'desc')
        ->get();
        
        $formatted = $batches->map(function ($batch) {
            return [
                'productId' => (int) $batch->productId,
                'number' => $batch->number,
                'quantity' => (float) $batch->quantity,
                'manufacturingDate' => $batch->manufacturingDate,
                'stockInDate' => $batch->stockInDate,
                'storedUnit' => $batch->storedUnit,
                'expiryDate' => $batch->expiryDate,
                'productName'=> $batch->productName,
            ];
        });
    
        return response()->json($formatted);

    }
    
   
   public function saveRecord(Request $request)
    {
        try {
            $record = $request->all();
            $userName = auth()->user()->name ?? 'System';
    
            $initialTempImg = $this->saveBase64Image($record['initialTempImg'] ?? '', 'thawing/temps');
            $initiatedBySign = $this->saveBase64Image($record['initiatedBySign'] ?? '', 'thawing/signs');
            $waterTempImg = $this->saveBase64Image($record['waterTempImg'] ?? '', 'thawing/temps');
            $finalTempImg = $this->saveBase64Image($record['finalTempImg'] ?? '', 'thawing/temps');
    
            $recordId = DB::table('thawing_records')->insertGetId([
                'uuid' => $record['uuid'] ?? Str::uuid(),
                'outlet_id' => $record['outletId'] ?? null,
                'outletCorporate' => $record['outletCorporate'] ?? null,
                'outletRegional' => $record['outletRegional'] ?? null,
                'outletUnit' => $record['outletUnit'] ?? null,
                'outletDepartment' => $record['outletDepartment'] ?? null,
                'outletLocation' => $record['outletLocation'] ?? null,
                'product_id' => $record['productId'] ?? null,
                'productName' => $record['productName'] ?? null,
                'brand_name' => $record['brandName'] ?? null,
                'method' => $record['method'] ?? null,
                'thawingQuantity' => $record['thawingQuantity'] ?? null,
                'thawStart' => $record['thawStart'] ?? null,
                'initialTemp' => $record['initialTemp'] ?? null,
                'initialTempImg' => $initialTempImg,
                'thawingUnit' => $record['thawingUnit'] ?? null,
                'initiatedBy' => $record['initiatedBy'] ?? null,
                'initiatedBySign' => $initiatedBySign,
                'waterTemp' => $record['waterTemp'] ?? null,
                'waterTempImg' => $waterTempImg,
                'thawCompleted' => $record['thawCompleted'] ?? null,
                'finalTemp' => $record['finalTemp'] ?? null,
                'finalTempImg' => $finalTempImg,
                'completedBy' => $record['completedBy'] ?? null,
                'completedBySign' => $record['completedBySign'] ?? null,
                'correctiveAction' => $record['correctiveAction'] ?? null,
                'verifierName' => $record['verifierName'] ?? null,
                'verificationComments' => $record['verificationComments'] ?? null,
                'verifierSignature' => $record['verifierSignature'] ?? null,
                'created_by' =>  Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            if (!empty($record['issued'])) {
                $issuedBatches = json_decode($record['issued'], true);
                if (is_array($issuedBatches)) {
                    foreach ($issuedBatches as $issue) {
            
                      $stock = DB::table('advanced_interactive_stock_register')
                        ->where('id', $issue['id'])
                        ->update([
                            'issue_to_thawing_record' => $issue['balanceQty']
                        ]);

                    $interactive_issue_id = $stock->id ?? null;
                        DB::table('thawing_record_batch_issues')->insert([
                            'thawing_record_id' => $recordId,
                            'advanced_interactive_stock_register_id' => $issue['id'] ?? '',
                            'batch_number' => $issue['batchNumber'] ?? '',
                            'issued_qty' => $issue['issuedQty'] ?? 0,
                            'before_qty' => $issue['beforeQty'] ?? 0,
                            'balance_qty' => $issue['balanceQty'] ?? 0,
                            'created_by' => Auth::id(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
    
            return response()->json([
                'message' => 'Record and issued batches saved successfully!',
                'record_id' => $recordId
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   
   
    public function saveCompleteOfRecord(Request $request)
    {
        try {
            $data = $request->all();

            $finalTempImgPath   = $this->saveBase64Image($data['final_temp_img'] ?? '', 'thawing/temps');
            $completedBySignPath = $this->saveBase64Image($data['completed_by_sign'] ?? '', 'thawing/signs');

            $updated = DB::table('thawing_records')
                ->where('uuid', $data['uuid'])
                ->update([
                    'finalTemp'        => $data['final_temp'] ?? null,
                    'finalTempImg'     => $finalTempImgPath,
                    'correctiveAction' => $data['corrective_action'] ?? null,
                    'completedBy'      => $data['completed_by'] ?? null,
                    'completedBySign'  => $completedBySignPath,
                    // 'thawCompleted' => $data['thawCompleted'] ?? null,
                    'updated_at'       => now(),
                ]);

            if (!$updated) {
                return response()->json([
                    'error' => 'Record not found or update failed.'
                ], 404);
            }

            return response()->json([
                'message' => 'Thawing record updated successfully',
                'finalTempImg' => $finalTempImgPath,
                'completedBySign' => $completedBySignPath,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function saveVerifyOfRecord(Request $request)
    {
        try {
            $data = $request->all();
    
            $updateData = [
                'verificationComments' => $data['verification_comments'] ?? null,
                'verifierName'         => $data['verifier_name'] ?? null,
                'updated_at'           => now(),
            ];
    
            if (!empty($data['verifier_signature'])) {
                $path = $this->saveBase64Image($data['verifier_signature'], 'thawing/signs');
                $updateData['verifierSignature'] = $path;
            }
    
            $updated = DB::table('thawing_records')
                ->where('uuid', $data['uuid'])
                ->update($updateData);
    
            if (!$updated) {
                return response()->json(['error' => 'Record not found or update failed.'], 404);
            }
    
            return response()->json([
                'message' => 'Verification updated successfully',
                'verifierSignature' => $updateData['verifierSignature'] ?? null
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }


    
     private function saveBase64Image($base64, $folder = 'thawing')
    {
        if (empty($base64)) return null;
        $image = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
        $image = str_replace(' ', '+', $image);
        $fileName = $folder . '/' . uniqid() . '.jpg';
        $path = public_path('storage/' . $fileName);
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
        file_put_contents($path, base64_decode($image));
        $baseUrl = "https://efsm.safefoodmitra.com/admin/public/";
        return $baseUrl . 'storage/' . $fileName;
    }




    public function saveIssuedItems(Request $request)
    {
        $data = $request->validate([
            'uuid'   => 'required|string',
            'issued' => 'nullable|string',
        ]);
    
        $issuedJson = $data['issued'];
        $issuedItems = json_decode($issuedJson, true);
    
        // Delete old
        DB::table('thawing_record_issue_qty_to_section')
          ->where('thawing_record_uuid', $data['uuid'])
          ->delete();
    
        if (!empty($issuedItems)) {
            $insertData = [];
            foreach ($issuedItems as $item) {
                $shelfLifeInput = $item['shelfLife'] ?? null;
                $shelfLifeDb = null;
                if ($shelfLifeInput) {
                    try {
                        $dt = Carbon::createFromFormat('d/m/Y, H:i', $shelfLifeInput);
                        $shelfLifeDb = $dt->format('Y-m-d H:i:s');
                    } catch (\Exception $e) {
                        $shelfLifeDb = null;
                    }
                }
    
                $insertData[] = [
                    'thawing_record_uuid' => $data['uuid'],
                    'new_item'            => $item['section'] ?? null,
                    'purpose'             => $item['purpose'] ?? null,
                    'qty'                 => $item['quantity'] ?? 0,
                    'shelf_life'          => $shelfLifeDb,
                    'created_by'=> Auth::id(),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ];
            }
    
            DB::table('thawing_record_issue_qty_to_section')->insert($insertData);
        }
    
        return response()->json([
            'message' => 'Issued items saved successfully in separate rows',
            'issued_count' => count($issuedItems),
        ], 200);
    }

}

