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
class RecordsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
      
        return view('admin.record.list');
    }

    public function receivingRecord(Request $request)
    {
      
      
            $auth = Auth::user();
            $user_id = $auth->id;
            $user_ids = [$user_id];
        
            $user = DB::table('users')->where('id', $user_id)->first();
        
            if ($auth->is_role == 1 && $user && $user->created_by) {
                $user_ids[] = $user->created_by;
            } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        
            $user_ids[] = 1; 
            $user_ids = array_unique($user_ids);
            $vendors = DB::table('sqa_new_suppliers')->whereIn('created_by', $user_ids)->get();
        
            // Products query
            $products = DB::table('sqa_raw_material_product_details as mpd')
                ->select('mp.name', 'mpv.sqa_brand_name')
                ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
                ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
                ->whereIn('mpd.created_by', $user_ids)
                ->get();
        
            // Group the products by name and collect unique brands
            $productDatabase = $products->groupBy('name')
                ->map(function ($items) {
                    $brands = $items->pluck('sqa_brand_name')
                        ->filter() // Remove null values
                        ->unique()
                        ->values()
                        ->toArray();
        
                    return empty($brands) ? [] : $brands;
                })
                ->toArray();
         $vendors = DB::table('sqa_new_suppliers')->whereIn('created_by', $user_ids)->get();
         
         $user = DB::table('users')->where('id',$user_id)->first();
         $name = $user->name;
 
        return view('admin.record.receving-record',compact('vendors','productDatabase','name'));
    }
    
    
    public function receivingRecordNew(Request $request){
           
            $auth = Auth::user();
            $user_id = $auth->id;
            $user_ids = [$user_id];
        
            $user = DB::table('users')->where('id', $user_id)->first();
        
            if ($auth->is_role == 1 && $user && $user->created_by) {
                $user_ids[] = $user->created_by;
            } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
                if ($user->created_by) {
                    $user_ids[] = $user->created_by;
                }
                if ($user->created_by1) {
                    $user_ids[] = $user->created_by1;
                }
            }
        
            $user_ids[] = 1; 
            $user_ids = array_unique($user_ids);
            $vendors = DB::table('sqa_new_suppliers')->whereIn('created_by', $user_ids)->get();
        
            // Products query
            $products = DB::table('sqa_raw_material_product_details as mpd')
                ->select('mp.name', 'mpv.sqa_brand_name')
                ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
                ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
                ->whereIn('mpd.created_by', $user_ids)
                ->get();
        
            // Group the products by name and collect unique brands
            $productDatabase = $products->groupBy('name')
                ->map(function ($items) {
                    $brands = $items->pluck('sqa_brand_name')
                        ->filter() // Remove null values
                        ->unique()
                        ->values()
                        ->toArray();
        
                    return empty($brands) ? [] : $brands;
                })
                ->toArray();
         $vendors = DB::table('sqa_new_suppliers')->whereIn('created_by', $user_ids)->get();
         
         $user = DB::table('users')->where('id',$user_id)->first();
         $name = $user->name;
 
        return view('admin.record.receving-record-new',compact('vendors','productDatabase','name'));
    }
    
    
    // public function getReceivingRecordsData(Request $request){
        
    //     $auth = Auth::user();
    //     $user_id = $auth->id;
    
    //     $user_ids = [$user_id];
    
    //     $user = DB::table('users')->where('id', $user_id)->first();
    
    //     if ($auth->is_role == 1 && $user && $user->created_by) {
    //         $user_ids[] = $user->created_by;
    //     } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
    //         if ($user->created_by) {
    //             $user_ids[] = $user->created_by;
    //         }
    //         if ($user->created_by1) {
    //             $user_ids[] = $user->created_by1;
    //         }
    //     }
    
    //     $user_ids[] = 1; 
    //     $user_ids = array_unique($user_ids);
    
    //      $vendors = DB::table('sqa_new_suppliers')->where('created_by',$user_ids)->get();
         
    //       $products = DB::table('sqa_raw_material_product_details as mpd')
    //     ->select('mp.name', 'mpv.sqa_brand_name')
    //     ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
    //     ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
    //     ->whereIn('mpd.created_by', $user_ids)
    //     ->get();

    //     // Group the products by name and collect unique brands
    //     $productDatabase = $products->groupBy('name')
    //         ->map(function ($items) {
    //             $brands = $items->pluck('sqa_brand_name')
    //                 ->filter() // Remove null values
    //                 ->unique()
    //                 ->values()
    //                 ->toArray();
    
    //             return empty($brands) ? [] : $brands;
    //         })
    //         ->toArray();
            
            
    //     $records = DB::table('receiving_record')->where('created_by',$user_ids) ->orderBy('id', 'desc')->get();
        
    //   $formattedRecords = [];

    //     foreach ($records as $record) {
    //         $status = 'Completed';
    //         if (!empty($record->discrepancy_remarks)) {
    //             $status = 'Discrepancy';
    //         }

    //         // Create a formatted array for each record
    //         $formattedRecords[] = [
    //             'id' => $record->id,
    //             'rec' => $record->receiving_no,
    //             'date' => Carbon::parse($record->created_at)->format('Y-m-d'),
    //             'time' => Carbon::parse($record->created_at)->format('h:i A'),
    //             'invoice' => $record->invoice_number,
    //             'vendor' => $record->vendor,
    //             'productName' => $record->product,
    //             'brand' => $record->brand,
    //             'storageArea' => $record->storage_area,
    //             'batch' => $record->batch,
    //             'mfg' => $record->mfg_date,
    //             'exp' => $record->exp_date,
    //             'created_at' => $record->created_at,
    //             'ordered' => $record->order_qty,
    //             'received' => $record->receive_qty,
    //             'temp' => $record->temperature,
    //             'discrepancyReason' => $record->discrepancy_remarks ? 'Rejected' : null,
    //             'rejectionRemarks' => $record->discrepancy_remarks,
    //             'correctiveAction' => $record->corrective_action_taken,
    //             'receivedBy' => (string) $record->received_by,
    //             'vendorEval' => 95, // Placeholder value
    //             'verified' => true, // Placeholder value
    //             'tempImageSrc' => $record->temperature_image,
    //             'vehicleVideoUrl' => null,
    //             'attachments' => [
    //                 'formE' => (bool)$record->upload_form_e,
    //                 'invoice' => (bool)$record->upload_invoice,
    //                 'coa' => (bool)$record->attachment_coa,
    //                 'formE_file' => $record->upload_form_e ? $record->upload_form_e : null,
    //                 'invoice_file' => $record->upload_invoice ? $record->upload_invoice : null,
    //                 'coa_file' => $record->attachment_coa ? $record->attachment_coa : null,
    //             ],
    //             'status' => $status,
    //         ];
    //     }
        
    //     return response()->json([
    //         'success'=> true,
    //         'productDatabase' => $productDatabase,
    //         'vendors' => $vendors,
    //         'formattedRecords' => $formattedRecords
    //     ]);
    
    // }
    
    public function getReceivingRecordsData(Request $request){
    $auth = Auth::user();
    $user_id = $auth->id;
    $user_ids = [$user_id];

    $user = DB::table('users')->where('id', $user_id)->first();

    if ($auth->is_role == 1 && $user && $user->created_by) {
        $user_ids[] = $user->created_by;
    } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
        if ($user->created_by) {
            $user_ids[] = $user->created_by;
        }
        if ($user->created_by1) {
            $user_ids[] = $user->created_by1;
        }
    }

    $user_ids[] = 1; 
    $user_ids = array_unique($user_ids);

    // Vendors query (optional to filter vendors too if you want)
    $vendors = DB::table('sqa_new_suppliers')->whereIn('created_by', $user_ids)->get();

    // Products query
    $products = DB::table('sqa_raw_material_product_details as mpd')
        ->select('mp.name', 'mpv.sqa_brand_name')
        ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
        ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
        ->whereIn('mpd.created_by', $user_ids)
        ->get();

    // Group the products by name and collect unique brands
    $productDatabase = $products->groupBy('name')
        ->map(function ($items) {
            $brands = $items->pluck('sqa_brand_name')
                ->filter() // Remove null values
                ->unique()
                ->values()
                ->toArray();

            return empty($brands) ? [] : $brands;
        })
        ->toArray();

    // Query for receiving records with filters
    $recordsQuery = DB::table('receiving_record')->whereIn('created_by', $user_ids);

    // Apply filters from request
    if ($request->filled('dateFrom')) {
        $recordsQuery->whereDate('created_at', '>=', $request->dateFrom);
    }
    if ($request->filled('dateTo')) {
        $recordsQuery->whereDate('created_at', '<=', $request->dateTo);
    }
    if ($request->filled('invoiceNo')) {
        $recordsQuery->where('invoice_number', 'like', '%' . $request->invoiceNo . '%');
    }
    if ($request->filled('reportNo')) {
        $recordsQuery->where('receiving_no', 'like', '%' . $request->reportNo . '%');
    }
    if ($request->filled('status')) {
        if ($request->status == 'Discrepancy') {
            $recordsQuery->whereNotNull('discrepancy_remarks')->where('discrepancy_remarks', '!=', '');
        } elseif ($request->status == 'Completed') {
            $recordsQuery->where(function($query) {
                $query->whereNull('discrepancy_remarks')->orWhere('discrepancy_remarks', '');
            });
        }
    }
    if ($request->filled('vendor')) {
        $recordsQuery->where('vendor', 'like', '%' . $request->vendor . '%');
    }
    if ($request->filled('product')) {
        $recordsQuery->where('product', 'like', '%' . $request->product . '%');
    }

     $records = $recordsQuery->orderBy('mfg_date', 'DESC')->get();

    $formattedRecords = [];

    foreach ($records as $record) {
        $status = 'Completed';
        if (!empty($record->discrepancy_remarks)) {
            $status = 'Discrepancy';
        }

        $formattedRecords[] = [
            'id' => $record->id,
            'rec' => $record->receiving_no,
            'date' => Carbon::parse($record->created_at)->format('Y-m-d'),
            'time' => Carbon::parse($record->created_at)->format('h:i A'),
            'invoice' => $record->invoice_number,
            'vendor' => $record->vendor,
            'productName' => $record->product,
            'brand' => $record->brand,
            'storageArea' => $record->storage_area,
            'batch' => $record->batch,
            'mfg' => $record->mfg_date,
            'exp' => $record->exp_date,
            'created_at' => $record->created_at,
            'ordered' => $record->order_qty,
            'received' => $record->receive_qty,
            'temp' => $record->temperature,
            'discrepancyReason' => $record->discrepancy_remarks ? 'Rejected' : null,
            'rejectionRemarks' => $record->discrepancy_remarks,
            'correctiveAction' => $record->corrective_action_taken,
            'receivedBy' => (string) $record->received_by,
           'receivedSign' => !empty($record->signature) ? $record->signature : null,
            'vendorEval' => 95,
            'verified' => true,
            'tempImageSrc' => $record->temperature_image,
            'vehicleVideoUrl' => null,
            'attachments' => [
                'formE' => (bool)$record->upload_form_e,
                'invoice' => (bool)$record->upload_invoice,
                'coa' => (bool)$record->attachment_coa,
                'formE_file' => $record->upload_form_e ?: null,
                'invoice_file' => $record->upload_invoice ?: null,
                'coa_file' => $record->attachment_coa ?: null,
            ],
            'status' => $status,
        ];
    }

    return response()->json([
        'success' => true,
        'productDatabase' => $productDatabase,
        'vendors' => $vendors,
        'formattedRecords' => $formattedRecords
    ]);
}

    
    // public function storeReceivingRecord(Request $request){
    //     $productsData = json_decode($request->products_data, true);

    //     $upload_invoice = null; 
    //     if ($request->hasFile('invoice_file')) {
    //         $contractFile = $request->file('invoice_file');
    //         $contractFileName = time() . '_' . uniqid() . '_invoice_file.' . $contractFile->getClientOriginalExtension();
    //         $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
    //         $upload_invoice = asset('uploads/record/receiving/' . $contractFileName);
    //     }
         
    //     $upload_form_e = null;
    //     if ($request->hasFile('form_e_file')) {
    //         $contractFile = $request->file('form_e_file');
    //         $contractFileName = time() . '_' . uniqid() . '_form_e_file.' . $contractFile->getClientOriginalExtension();
    //         $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
    //         $upload_form_e = asset('uploads/record/receiving/' . $contractFileName);
    //     }
        
    //     $signature_name = null;
        
    //     if ($request->filled('user_signature') && $request->user_signature !== 'null') {
    //         $signatureData = str_replace('data:image/png;base64,', '', $request->user_signature);
    //         $signatureData = str_replace(' ', '+', $signatureData);
    //         $filename = time().'_user_signature.png';
    //         $path = 'uploads/record/sign/'.$filename;
    //         Storage::disk('public')->put($path, base64_decode($signatureData));
    //         $signature_name = asset('storage/'.$path);
    //     }

        
    //     $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    //     $receiving_no = 'REC-' . $randomNumber;

    //     if (!empty($productsData)) {
    //         foreach ($productsData as $index => $product) {

    //             $temperature_image = null;
    //             if ($request->hasFile("temperature_image_{$index}")) {
    //                 $contractFile = $request->file("temperature_image_{$index}");
    //                 $contractFileName = time() . '_' . uniqid() . '_temperature_image.' . $contractFile->getClientOriginalExtension();
    //                 $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
    //                 $temperature_image = asset('uploads/record/receiving/' . $contractFileName);
    //             }
                
    //             $attachment_coa = null;
    //             if ($request->hasFile("attachment_coa_{$index}")) {
    //                 $contractFile = $request->file("attachment_coa_{$index}");
    //                 $contractFileName = time() . '_' . uniqid() . '_attachment_coa.' . $contractFile->getClientOriginalExtension();
    //                 $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
    //                 $attachment_coa = asset('uploads/record/receiving/' . $contractFileName);
    //             }
    
        
        
    //              $letters = '';
    //             $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //             for ($i = 0; $i < 2; $i++) {
    //                 $letters .= $chars[rand(0, strlen($chars) - 1)];
    //             }
    //             $digits = '';
    //             for ($i = 0; $i < 2; $i++) {
    //                 $digits .= rand(0, 9);
    //             }
    //             $batchCode = $letters . $digits;



 


    //             DB::table('receiving_record')->insert([
    //                 'receiving_no' => $receiving_no,
    //                 'vendor' => $request->vendor,
    //                 'po_number' => $request->po_number,
    //                 'invoice_number' => $request->invoice_number,
    //                 'upload_invoice' => $upload_invoice,
    //                 'upload_form_e' => $upload_form_e,
    //                 'vendor_evaluation_checklist' =>  $request->vendor_evaluation_checklist, 
    //                 'general_remarks' => $request->general_remarks,
    //                 'received_by' => $request->received_by,
    //                 'signature' => $signature_name,
    //                 'product' => $product['product'],
    //                 'brand' => $product['brand'],
    //                 // 'batch' => $product['batch'],
    //                   'batch' => $product['batch'] . '(' . $batchCode . ')',
    //                 'storage_area' => $product['storage_area'],
    //                 'mfg_date' => $product['mfg_date'],
    //                 'exp_date' => $product['exp_date'],
    //                 'mfg_exp_difference' => $product['shelf_life_display'], 
    //                 'order_qty' => $product['order_qty'],
    //                 'receive_qty' => $product['receive_qty'],
    //                 // 'discrepancy_value' => $product['discrepancy_value'],
    //                 'discrepancy_value' => round($product['order_qty'] - $product['receive_qty'], 2),
    //                 'discrepancy_remarks' => implode(', ', $product['discrepancy_remarks']),
    //                 'corrective_action_taken' => implode(', ', $product['corrective_action']),
    //                 'qty_type' => $product['qty_type'],
    //                 'temperature' => $product['temperature'],
    //                 'temperature_image' => $temperature_image,
    //                 'attachment_coa' => $attachment_coa,
    //                 'created_by' => Auth::id(),
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
                
    //         }
    //     }

    //     return response()->json(['status' => true,'message' => 'Record saved successfully!'], 200);
        
    // }
    
        public function storeReceivingRecord(Request $request){
        $productsData = json_decode($request->products_data, true);

        $upload_invoice = null; 
        if ($request->hasFile('invoice_file')) {
            $contractFile = $request->file('invoice_file');
            $contractFileName = time() . '_' . uniqid() . '_invoice_file.' . $contractFile->getClientOriginalExtension();
            $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
            $upload_invoice = asset('uploads/record/receiving/' . $contractFileName);
        }
         
        $upload_form_e = null;
        if ($request->hasFile('form_e_file')) {
            $contractFile = $request->file('form_e_file');
            $contractFileName = time() . '_' . uniqid() . '_form_e_file.' . $contractFile->getClientOriginalExtension();
            $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
            $upload_form_e = asset('uploads/record/receiving/' . $contractFileName);
        }
        
        $signature_name = null;
        
        if ($request->filled('user_signature') && $request->user_signature !== 'null') {
            $signatureData = str_replace('data:image/png;base64,', '', $request->user_signature);
            $signatureData = str_replace(' ', '+', $signatureData);
            $filename = time().'_user_signature.png';
            $path = 'uploads/record/sign/'.$filename;
            Storage::disk('public')->put($path, base64_decode($signatureData));
            $signature_name = asset('storage/'.$path);
        }

        
        $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $receiving_no = 'REC-' . $randomNumber;

        if (!empty($productsData)) {
            foreach ($productsData as $index => $product) {

                $temperature_image = null;
                if ($request->hasFile("temperature_image_{$index}")) {
                    $contractFile = $request->file("temperature_image_{$index}");
                    $contractFileName = time() . '_' . uniqid() . '_temperature_image.' . $contractFile->getClientOriginalExtension();
                    $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
                    $temperature_image = asset('uploads/record/receiving/' . $contractFileName);
                }
                
                $attachment_coa = null;
                if ($request->hasFile("attachment_coa_{$index}")) {
                    $contractFile = $request->file("attachment_coa_{$index}");
                    $contractFileName = time() . '_' . uniqid() . '_attachment_coa.' . $contractFile->getClientOriginalExtension();
                    $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
                    $attachment_coa = asset('uploads/record/receiving/' . $contractFileName);
                }
    
        
        
                 $letters = '';
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                for ($i = 0; $i < 2; $i++) {
                    $letters .= $chars[rand(0, strlen($chars) - 1)];
                }
                $digits = '';
                for ($i = 0; $i < 2; $i++) {
                    $digits .= rand(0, 9);
                }
                $batchCode = $letters . $digits;

                
                
                
                  $yield_no = 0;

                $productName = $product['product'] ?? null; 
                
                if ($productName) {
                    $product = DB::table('sqa_raw_material_product')
                        ->where('name', $productName)
                        ->where('created_by', Auth::id())
                        ->first();
                
                    if ($product) {
                        $detail = DB::table('sqa_raw_material_product_details')
                            ->where('sqa_raw_mat_prod_id', $product->id)
                            ->first();
                
                        if ($detail) {
                            $yield_no = ($detail->is_yield === 'no') ? 0 : 1;
                        }
                    }
                }
                
                         

                DB::table('receiving_record')->insert([
                    'receiving_no' => $receiving_no,
                    'vendor' => $request->vendor,
                    'po_number' => $request->po_number,
                    'invoice_number' => $request->invoice_number,
                    'upload_invoice' => $upload_invoice,
                    'upload_form_e' => $upload_form_e,
                    'vendor_evaluation_checklist' =>  $request->vendor_evaluation_checklist, 
                    'general_remarks' => $request->general_remarks,
                    'received_by' => $request->received_by,
                    'signature' => $signature_name,
                    'product' => $product['product'],
                    'brand' => $product['brand'],
                    // 'batch' => $product['batch'],
                      'batch' => $product['batch'] . '(' . $batchCode . ')',
                    'storage_area' => $product['storage_area'],
                    'mfg_date' => $product['mfg_date'],
                    'exp_date' => $product['exp_date'],
                    'mfg_exp_difference' => $product['shelf_life_display'], 
                    'order_qty' => $product['order_qty'],
                    'receive_qty' => $product['receive_qty'],
                    // 'discrepancy_value' => $product['discrepancy_value'],
                    'discrepancy_value' => round($product['order_qty'] - $product['receive_qty'], 2),
                    'discrepancy_remarks' => implode(', ', $product['discrepancy_remarks']),
                    'corrective_action_taken' => implode(', ', $product['corrective_action']),
                    'qty_type' => $product['qty_type'],
                    'temperature' => $product['temperature'],
                    'temperature_image' => $temperature_image,
                    'attachment_coa' => $attachment_coa,
                    'created_by' => Auth::id(),
                    'is_yield' => $yield_no,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
            }
        }

        return response()->json(['status' => true,'message' => 'Record saved successfully!'], 200);
        
    }


  public function advanceInteractiveStockRegister(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
    
        $user_ids = [$user_id];
    
        $user = DB::table('users')->where('id', $user_id)->first();
    
        if ($auth->is_role == 1 && $user && $user->created_by) {
            $user_ids[] = $user->created_by;
        } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
            if ($user->created_by) {
                $user_ids[] = $user->created_by;
            }
            if ($user->created_by1) {
                $user_ids[] = $user->created_by1;
            }
        }
    
        $user_ids[] = 1;
        $user_ids = array_unique($user_ids);
    
        $records = DB::table('receiving_record')
                      ->whereIn('created_by', $user_ids)
                      ->where('is_yield',0)
                      ->get();
                      
        /** delete process staart */
        $manage_delete = DB::table('receiving_record')
              ->whereIn('created_by', $user_ids)
              ->where('is_yield',1)
              ->pluck('id');      
              
               
        if($manage_delete){       
            $existing_receive_stock = DB::table('advanced_interactive_stock_register')
                ->whereIn('receiving_record_id', $manage_delete)
                ->whereNull('yield_raw_material_variant_id')
                ->update(['is_deleted' => 1]);
            
            $existing_interactive_ids = DB::table('advanced_interactive_stock_register')
                ->whereIn('receiving_record_id', $manage_delete)
                ->pluck('id');
            
            $existing_issue_stock = DB::table('advanced_interactive_stock_register')
                ->whereIn('issue_receiving_record_id', $existing_interactive_ids)
                ->whereNull('yield_raw_material_variant_id')
                ->whereNull('issue_yield_raw_material_variant_id')
                ->update(['is_deleted' => 1]);
        }
       /** delete process end */

     
        $existing_ids = DB::table('advanced_interactive_stock_register')
                          ->pluck('receiving_record_id')
                          ->toArray();
    
        $new_records_to_insert = [];
    
        foreach ($records as $record) {
            if (!in_array($record->id, $existing_ids)) {
                $new_records_to_insert[] = [
                    'receiving_record_id' => $record->id,
                    'receiving_no' => $record->receiving_no,
                    'vendor' => $record->vendor,
                    'po_number' => $record->po_number,
                    'invoice_number' => $record->invoice_number,
                    'product' => $record->product,
                    'brand' => $record->brand,
                    'batch' => $record->batch,
                    'mfg_date' => $record->mfg_date,
                    'exp_date' => $record->exp_date,
                    'qty_type' => $record->qty_type,
                    'received_date_time' => $record->created_at,
                    'type' => 'receive',
                    'receive_qty' => $record->receive_qty,
                    'receive_from_name' => $record->vendor,
                    'created_by' => Auth::id(),
                    'created_time' => $record->created_at,
                    'storage' => $record->storage_area,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
    
        if (!empty($new_records_to_insert)) {
            DB::table('advanced_interactive_stock_register')->insert($new_records_to_insert);
        }
        
        return view('admin.record.advance_interactive_stock_register');
    }

 


public function getDataInteractiveStockRegister(Request $request)
{
    
        $auth = Auth::user();
    $user_id = $auth->id;

    $user_ids = [$user_id];

    $user = DB::table('users')->where('id', $user_id)->first();

    if ($auth->is_role == 1 && $user && $user->created_by) {
        $user_ids[] = $user->created_by;
    } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
        if ($user->created_by) {
            $user_ids[] = $user->created_by;
        }
        if ($user->created_by1) {
            $user_ids[] = $user->created_by1;
        }
    }

    $user_ids[] = 1; // always include admin
    $user_ids = array_unique($user_ids);
    // $records = DB::table('advanced_interactive_stock_register')
    //     ->orderBy('id', 'DESC')
    //         // ->orderBy('created_time', 'DESC')
    //      ->whereIn('created_by', $user_ids)
    //     ->get();
    
    
    /** check deleted data */
      $records = DB::table('advanced_interactive_stock_register')
        ->orderBy('id', 'DESC')
        ->where('is_deleted',0)
         ->whereIn('created_by', $user_ids)
        ->get();
    /** end */
        

    $data = $records->map(function ($row) {
        return [
            'mainId' => $row->id,
            'class'      => $row->type == 'receive' ? 'stock-in' : 'stock-out',
            'itemName'   => $row->product,
            'brandName'  => $row->brand,
            'batchNumber'=> $row->batch,
            'unit'       => $row->qty_type, // or your correct unit column
            'quantity'   => $row->type == 'receive' ? $row->receive_qty : -$row->issue_qty,
            'mfgDate'    => $row->mfg_date,
            'expDate'    => $row->exp_date,
            'datetime'   => $row->received_date_time, // or issue_time
            'fromTo'     => $row->type == 'receive' ? $row->receive_from_name : $row->issue_to_name,
            'issuedFrom' => $row->issued_from ?? null, // if exists
        ];
    });

    // return response()->json($data);
    
    
    // Existing department logic
    $ids = [];
    if ($auth->is_role == 1) {
        $regional = DB::table('users')->where('id', $auth->id)->first();
        if ($regional) {
            $ids[] = $regional->id;
            $corporate = DB::table('users')->where('id', $regional->created_by)->first();
            if ($corporate) $ids[] = $corporate->id;
            $unit = DB::table('users')->where('created_by1', $regional->id)->first();
            if ($unit) $ids[] = $unit->id;
        }
    } elseif ($auth->is_role == 2) {
        $corporate = DB::table('users')->where('id', $auth->id)->first();
        if ($corporate) {
            $ids[] = $corporate->id;
            $regional = DB::table('users')->where('created_by', $corporate->id)->first();
            if ($regional) $ids[] = $regional->id;
            $unit = DB::table('users')->where('created_by1', $regional->id)->first();
            if ($unit) $ids[] = $unit->id;
        }
    } elseif ($auth->is_role == 3) {
        $unit = DB::table('users')->where('id', $auth->id)->first();
        if ($unit) {
            $ids[] = $unit->id;
            $corporate = DB::table('users')->where('id', $unit->created_by)->first();
            if ($corporate) $ids[] = $corporate->id;
            $regional = DB::table('users')->where('id', $unit->created_by1)->first();
            if ($regional) $ids[] = $regional->id;
        }
    }
    $ids = array_unique($ids);
    $departments = DB::table('locations')->whereIn('created_by', $ids)->get();


    
     return response()->json(['data' => $data, 'departments' => $departments]);
}


    // public function stockIssueSave(Request $request)
    // {
    //     // foreach ($request['issuedFrom'] as $issue) {
    //      foreach (array_reverse($request['issuedFrom']) as $issue) {
    //     $receive = DB::table('advanced_interactive_stock_register')
    //         ->where('batch', $issue['batchNumber'])
    //         ->where(function ($query) {
    //             $query->where('type', 'receive')
    //                   ->orWhereNull('type');
    //         })
    //         ->where('receive_qty', '>', 0)
    //         ->first();
    
    //         if (!$receive) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => "No stock found for Batch: {$issue['batchNumber']} and Vendor: {$issue['vendorName']}"
    //             ]);
    //         }
    
    //         if ($receive->receive_qty < $issue['quantityIssued']) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => "Not enough stock in Batch: {$issue['batchNumber']} for Vendor: {$issue['vendorName']}!"
    //             ]);
    //         }
            
            
    
    //         DB::table('advanced_interactive_stock_register')->insert([
    //             'issue_receiving_record_id'=> $receive->receiving_record_id ?? null,
    //             'issue_yield_raw_material_variant_id' => $receive->yield_raw_material_variant_id ?? null,
    //             'vendor'             => $receive->vendor,
    //             'po_number'          => $receive->po_number,
    //             'invoice_number'     => $receive->invoice_number,
    //             'product'            => $receive->product,
    //             'brand'              => $receive->brand,
    //             'batch'              => $issue['batchNumber'],
    //             'qty_type'           => $receive->qty_type,
    //             'receive_qty'        => 0,
    //             'issue_qty'          => $issue['quantityIssued'],
    //             'receive_from_name'  => null,
    //             'issue_to_name'      => $request['issuedTo'],
    //             'type'               => 'issue',
    //             'mfg_date'           => $receive->mfg_date,
    //             'exp_date'           => $receive->exp_date,
    //             // 'received_date_time' => now(),
    //             'received_date_time' => $request['datetime'],
    //             'created_by'         => Auth::id(),
    //             'created_at'         => now(),
    //             'updated_at'         => now(),
    //         ]);
    
        
    //     }
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Stock issued successfully'
    //     ]);
    // }
    
    public function stockIssueSave(Request $request)
    {
      $baseDateTime = Carbon::parse($request['datetime']);
        $index = 0; 
    
        foreach (array_reverse($request['issuedFrom']) as $issue) {
    
            $receive = DB::table('advanced_interactive_stock_register')
                ->where('batch', $issue['batchNumber'])
                ->where(function ($query) {
                    $query->where('type', 'receive')
                          ->orWhereNull('type');
                })
                ->where('receive_qty', '>', 0)
                ->first();
    
            if (!$receive) {
                return response()->json([
                    'success' => false,
                    'message' => "No stock found for Batch: {$issue['batchNumber']} and Vendor: {$issue['vendorName']}"
                ]);
            }
    
            if ($receive->receive_qty < $issue['quantityIssued']) {
                return response()->json([
                    'success' => false,
                    'message' => "Not enough stock in Batch: {$issue['batchNumber']} for Vendor: {$issue['vendorName']}!"
                ]);
            }
    
            $issueDateTime = $baseDateTime->copy()->addSeconds($index);
    
            DB::table('advanced_interactive_stock_register')->insert([
                'issue_receiving_record_id'=> $receive->receiving_record_id ?? null,
                'issue_yield_raw_material_variant_id' => $receive->yield_raw_material_variant_id ?? null,
                'vendor'             => $receive->vendor,
                'po_number'          => $receive->po_number,
                'invoice_number'     => $receive->invoice_number,
                'product'            => $receive->product,
                'brand'              => $receive->brand,
                'batch'              => $issue['batchNumber'],
                'qty_type'           => $receive->qty_type,
                'receive_qty'        => 0,
                'issue_qty'          => $issue['quantityIssued'],
                'receive_from_name'  => null,
                'issue_to_name'      => $request['issuedTo'],
                'type'               => 'issue',
                'mfg_date'           => $receive->mfg_date,
                'exp_date'           => $receive->exp_date,
                'received_date_time' => $issueDateTime,  
                'created_by'         => Auth::id(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
    
            $index++; 
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Stock issued successfully'
        ]);
    }




    // public function destroyReceivingRecord($id)
    // {
    //     try {
    //       $record = DB::table('receiving_record')->where('id',$id)->first();
    //         if($record){
    //             DB::table('advanced_interactive_stock_register')->where('receiving_record_id',$record->id)->delete();
    //             DB::table('advanced_interactive_stock_register')->where('issue_receiving_record_id',$record->id)->delete();
    //             DB::table('receiving_record')->where('id',$id)->delete();
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Record deleted successfully.'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Deletion failed.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function destroyReceivingRecord($id)
    {
        try {
            DB::beginTransaction();
    
            $record = DB::table('receiving_record')->where('id', $id)->first();
    
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }
    
            DB::table('advanced_interactive_stock_register')
                ->where('receiving_record_id', $record->id)
                ->orWhere('issue_receiving_record_id', $record->id)
                ->delete();
    
            $yield_variants = DB::table('yield_raw_material_variants')
                ->where('receiving_record_id', $record->id)
                ->get();
    
            if ($yield_variants->isNotEmpty()) {
                $variantIds = $yield_variants->pluck('id');
    
                DB::table('yield_raw_material_variant_storages')
                    ->whereIn('yield_raw_material_variant_id', $variantIds)
                    ->delete();
    
                DB::table('advanced_interactive_stock_register')
                    ->whereIn('yield_raw_material_variant_id', $variantIds)
                    ->orWhereIn('issue_yield_raw_material_variant_id', $variantIds)
                    ->delete();
    
                DB::table('yield_raw_material_variants')
                    ->whereIn('id', $variantIds)
                    ->delete();
            }
    
            DB::table('receiving_record')->where('id', $id)->delete();
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Record and all related data deleted successfully.'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Deletion failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

 
    // public function updateReceivingRecord(Request $request){
    //   try {
    //     $record = DB::table('receiving_record')->where('id', $request->recordId)->first();
    
    //     if ($record) {
    //         $mfg = Carbon::parse($request->mfg);
    //         $exp = Carbon::parse($request->exp);
    
    //         $mfgExpDifference = $exp->diffInDays($mfg);
    
    //         $percentage = 0;
    //         if ($request->ordered > 0) {
    //             $percentage = round(($mfgExpDifference / $request->ordered) * 100); 
    //         }
    
    //         $mfgExpDifferenceDisplay = $mfgExpDifference . 'd (' . $percentage . '%)';
    
    //         DB::table('receiving_record')->where('id', $request->recordId)->update([
    //             'mfg_date'           => $request->mfg,
    //             'exp_date'           => $request->exp,
    //             'mfg_exp_difference' => $mfgExpDifferenceDisplay, // store as string
    //             'order_qty'          => $request->ordered,
    //             'receive_qty'        => $request->received,
    //             'discrepancy_value'  => round($request->ordered - $request->received, 2),
    //             'updated_at'         => now(),
    //             'created_at'         => $request->received_date, 
    //         ]);
    
    //         DB::table('advanced_interactive_stock_register')
    //             ->where('receiving_record_id', $record->id)
    //             ->update([
    //                 'mfg_date'          => $request->mfg,
    //                 'exp_date'          => $request->exp,
    //                 'received_date_time'=> $request->received_date,
    //                 'created_time'      => $request->received_date,
    //                 'receive_qty'       => $request->received,
    //             ]);
    
    //         DB::table('advanced_interactive_stock_register')
    //             ->where('issue_receiving_record_id', $record->id)
    //             ->update([
    //                 'mfg_date'          => $request->mfg,
    //                 'exp_date'          => $request->exp,
    //                 'received_date_time'=> $request->received_date,
    //                 'created_time'      => $request->received_date,
    //             ]);
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Record updated successfully.'
    //         ]);
    //     }
    
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Record not found.'
    //     ], 404);
    
    // } catch (\Exception $e) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Updation failed.',
    //         'error'   => $e->getMessage()
    //     ], 500);
    // }
    // }
    
    public function updateReceivingRecord(Request $request)
    {
        try {
            $record = DB::table('receiving_record')->where('id', $request->recordId)->first();
    
            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record not found.'
                ], 404);
            }
    
            $mfg = Carbon::parse($request->mfg);
            $exp = Carbon::parse($request->exp);
    
            $mfgExpDifference = $exp->diffInDays($mfg);
    
            $percentage = 0;
            if ($request->ordered > 0) {
                $percentage = round(($mfgExpDifference / $request->ordered) * 100);
            }
    
            $mfgExpDifferenceDisplay = $mfgExpDifference . 'd (' . $percentage . '%)';
    
            DB::table('receiving_record')->where('id', $request->recordId)->update([
                'batch' => $request->batch,
                'mfg_date'           => $request->mfg,
                'exp_date'           => $request->exp,
                'mfg_exp_difference' => $mfgExpDifferenceDisplay,
                'order_qty'          => $request->ordered,
                'receive_qty'        => $request->received,
                'discrepancy_value'  => round($request->ordered - $request->received, 2),
                'updated_at'         => now(),
                'created_at'         => $request->received_date,
            ]);
    
            DB::table('advanced_interactive_stock_register')
                ->where('receiving_record_id', $record->id)
                ->where(function ($query) {
                    $query->whereNull('yield_raw_material_variant_id')
                          ->whereNull('issue_yield_raw_material_variant_id');
                })
                ->update([
                    'batch' => $request->batch,
                    'mfg_date'           => $request->mfg,
                    'exp_date'           => $request->exp,
                    'received_date_time' => $request->received_date,
                    'created_time'       => $request->received_date,
                    'receive_qty'        => $request->received,
                ]);
    
            DB::table('advanced_interactive_stock_register')
                ->where('receiving_record_id', $record->id)
                ->where(function ($query) {
                    $query->whereNotNull('yield_raw_material_variant_id')
                          ->orWhereNotNull('issue_yield_raw_material_variant_id');
                })
                ->update([
                    'batch' => $request->batch,
                    'mfg_date'           => $request->mfg,
                    'exp_date'           => $request->exp,
                    'received_date_time' => $request->received_date,
                    'created_time'       => $request->received_date,
                ]);
    
            DB::table('advanced_interactive_stock_register')
                ->where('issue_receiving_record_id', $record->id)
                ->update([
                     'batch' => $request->batch,
                    'mfg_date'           => $request->mfg,
                    'exp_date'           => $request->exp,
                    'received_date_time' => $request->received_date,
                    'created_time'       => $request->received_date,
                ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Record updated successfully.'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Updation failed.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    
    public function issueDestroyStock($id)
    {
        try {
            // Check if record exists
            $record = DB::table('advanced_interactive_stock_register')->where('id', $id)->first();
    
            if (!$record) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Record not found.'
                ], 404);
            }
    
            // Delete the record
            DB::table('advanced_interactive_stock_register')->where('id', $id)->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Record deleted successfully.'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function updateDateTimeStockIssue(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'variant' => 'required|string',
            'datetime' => 'required|date',
        ]);

        $id = $request->input('id');
        $variant = $request->input('variant');
        $datetime = str_replace('T', ' ', $request->input('datetime')) . ':00';

        $updated = DB::table('advanced_interactive_stock_register')
            ->where('id', $id)
            ->update(['received_date_time' => $datetime]);

        if ($updated) {
            return response()->json(['message' => 'Datetime updated successfully.']);
        } else {
            return response()->json(['error' => 'Record not found or update failed.'], 404);
        }
    }
    
    public function getReceivingRecordsDataNew(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
        $user_ids = [$user_id];
    
        $user = DB::table('users')->where('id', $user_id)->first();
    
        if ($auth->is_role == 1 && $user && $user->created_by) {
            $user_ids[] = $user->created_by;
        } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
            if ($user->created_by) {
                $user_ids[] = $user->created_by;
            }
            if ($user->created_by1) {
                $user_ids[] = $user->created_by1;
            }
        }
    
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
    
        $vendors = DB::table('sqa_new_suppliers')
            ->whereIn('created_by', $user_ids)
             ->select('id', 'name')
            ->get();
    
        $products = DB::table('sqa_raw_material_product_details as mpd')
            ->select('mp.name', 'mpv.sqa_brand_name')
            ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
            ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
            ->whereIn('mpd.created_by', $user_ids)
            ->get();
    
        $productDatabase = $products->groupBy('name')
            ->map(function ($items) {
                $brands = $items->pluck('sqa_brand_name')
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();
                return empty($brands) ? [] : $brands;
            })
            ->toArray();
    
    
        $records = DB::table('receiving_record')
        ->whereIn('created_by', $user_ids)
        ->orderBy('created_at', 'desc')
        ->get();

    
        // $recordsQuery = DB::table('receiving_record')->whereIn('created_by', $user_ids);
        // $records = $recordsQuery->orderBy('created_at', 'desc')->get();
    
        // $records = $recordsQuery->orderBy('id', 'desc')->get();
        
        // $records = $recordsQuery->orderBy('mfg_date', 'DESC')->get();
    
        $formattedRecords = [];
    
        foreach ($records as $record) {
            $status = !empty($record->discrepancy_remarks) ? 'Discrepancy' : 'Completed';
    
            $tempValue = $record->temperature ?? 'N/A';
            if(!empty($record->temperature_image)){
              $tempImageSrc = $record->temperature_image;
            }else{
              $tempImageSrc = "https://placehold.co/80x30/fee2e2/dc2626?text=" . urlencode($tempValue . "°C");
            }
            // if (is_numeric($tempValue)) {
            //     $tempImageSrc = "https://placehold.co/80x30/fee2e2/dc2626?text=" . urlencode($tempValue . "°C");
            // } else {
            //     $tempImageSrc = null;
            // }
            
            $verified_data = DB::table('receiving_record_verification')->where('receiving_record_id',$record->id)->first();
            
            $verified_bool = false;
            $verified_com = null;
            $verified_sign = null;
            if($verified_data){
                    $verified_bool = true;
                    $verified_com = $verified_data->comment;
                    $verified_sign = $verified_data->signature; 
            }
    
            $formattedRecords[] = [
                'id' => $record->id,
                'rec' => $record->receiving_no,
                'date' => Carbon::parse($record->created_at)->format('Y-m-d'),
                'time' => Carbon::parse($record->created_at)->format('h:i A'),
                'invoice' => $record->invoice_number,
                'vendor' => $record->vendor,
                'productName' => $record->product,
                'brand' => $record->brand,
                'batch' => $record->batch,
                'mfg' => $record->mfg_date,
                'exp' => $record->exp_date,
                 'created_at' => $record->created_at,
                // 'ordered' => (int) $record->order_qty,
                // 'received' => (int) $record->receive_qty,
                 'ordered' =>  $record->order_qty,
                'received' =>  $record->receive_qty,
                'temp' => $tempValue,
                'discrepancyReason' => !empty($record->discrepancy_remarks)
                    ? ($record->discrepancy_reason ?? 'Rejected')
                    : null,
                'rejectionRemarks' => $record->discrepancy_remarks ?? '',
                'correctiveAction' => $record->corrective_action_taken ?: '-',
                'receivedBy' => (string) $record->received_by,
                'receivedSign' => !empty($record->signature) ? $record->signature : null,
                'vendorEval' => 95,
                // 'verified' => true,
                 'verified' => $verified_bool,
                 'verified_com' => $verified_com,
                 'verified_sign' => $verified_sign,
                'tempImageSrc' => $tempImageSrc,
                'vehicleVideoUrl' => '#',
                'attachments' => [
                    'formE' => (bool)$record->upload_form_e,
                    'invoice' => (bool)$record->upload_invoice,
                    'coa' => (bool)$record->attachment_coa,
                    'formE_file' => $record->upload_form_e ?: null,
                    'invoice_file' => $record->upload_invoice ?: null,
                    'coa_file' => $record->attachment_coa ?: null,

                ],
                'status' => $status,
            ];
        }
        // print_r($formattedRecords);die;
        return response()->json([
            'success' => true,
            'productDatabase' => $productDatabase,
            'vendors' => $vendors,
            'formattedRecords' => $formattedRecords
        ]);
    }


    public function storeReceivingRecordNew(Request $request){
        $productsData = json_decode($request->products_data, true);

        $upload_invoice = null; 
        if ($request->hasFile('invoice_file')) {
            $contractFile = $request->file('invoice_file');
            $contractFileName = time() . '_' . uniqid() . '_invoice_file.' . $contractFile->getClientOriginalExtension();
            $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
            $upload_invoice = asset('uploads/record/receiving/' . $contractFileName);
        }
         
        $upload_form_e = null;
        if ($request->hasFile('form_e_file')) {
            $contractFile = $request->file('form_e_file');
            $contractFileName = time() . '_' . uniqid() . '_form_e_file.' . $contractFile->getClientOriginalExtension();
            $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
            $upload_form_e = asset('uploads/record/receiving/' . $contractFileName);
        }
        
        $signature_name = null;
        
        if ($request->filled('user_signature') && $request->user_signature !== 'null') {
            $signatureData = str_replace('data:image/png;base64,', '', $request->user_signature);
            $signatureData = str_replace(' ', '+', $signatureData);
            $filename = time().'_user_signature.png';
            $path = 'uploads/record/sign/'.$filename;
            Storage::disk('public')->put($path, base64_decode($signatureData));
            $signature_name = asset('storage/'.$path);
        }

        
        $randomNumber = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $receiving_no = 'REC-' . $randomNumber;

        if (!empty($productsData)) {
            foreach ($productsData as $index => $product) {

                $temperature_image = null;
                if ($request->hasFile("temperature_image_{$index}")) {
                    $contractFile = $request->file("temperature_image_{$index}");
                    $contractFileName = time() . '_' . uniqid() . '_temperature_image.' . $contractFile->getClientOriginalExtension();
                    $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
                    $temperature_image = asset('uploads/record/receiving/' . $contractFileName);
                }
                
                $attachment_coa = null;
                if ($request->hasFile("attachment_coa_{$index}")) {
                    $contractFile = $request->file("attachment_coa_{$index}");
                    $contractFileName = time() . '_' . uniqid() . '_attachment_coa.' . $contractFile->getClientOriginalExtension();
                    $contractFile->move(public_path('uploads/record/receiving'), $contractFileName);
                    $attachment_coa = asset('uploads/record/receiving/' . $contractFileName);
                }
    
        
        
                 $letters = '';
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                for ($i = 0; $i < 2; $i++) {
                    $letters .= $chars[rand(0, strlen($chars) - 1)];
                }
                $digits = '';
                for ($i = 0; $i < 2; $i++) {
                    $digits .= rand(0, 9);
                }
                $batchCode = $letters . $digits;
                
                
                /** check yield */
                $yield_no = 0;

                $productName = $product['product'] ?? null; 
                
                if ($productName) {
                    $product1 = DB::table('sqa_raw_material_product')
                        ->where('name', $productName)
                        ->where('created_by', Auth::id())
                        ->first();
               
              
                    if ($product1) {
                        $detail = DB::table('sqa_raw_material_product_details')
                            ->where('sqa_raw_mat_prod_id', $product1->id)
                            ->first();
                        if ($detail) {
                            $yield_no = ($detail->is_yield === "yes") ? 1 : 0;
                        }
                    }
                }
                /** end */


                DB::table('receiving_record')->insert([
                    'receiving_no' => $receiving_no,
                    'vendor' => $request->vendor,
                    'po_number' => $request->po_number,
                    'invoice_number' => $request->invoice_number,
                    'upload_invoice' => $upload_invoice,
                    'upload_form_e' => $upload_form_e,
                    'vendor_evaluation_checklist' =>  $request->vendor_evaluation_checklist, 
                    'general_remarks' => $request->general_remarks,
                    'received_by' => $request->received_by,
                    'signature' => $signature_name,
                    'product' => $product['product'],
                    'brand' => $product['brand'],
                    // 'batch' => $product['batch'],
                      'batch' => $product['batch'] . '(' . $batchCode . ')',
                    'storage_area' => $product['storage_area'],
                    'mfg_date' => $product['mfg_date'],
                    'exp_date' => $product['exp_date'],
                    'mfg_exp_difference' => $product['shelf_life_display'], 
                    'order_qty' => $product['order_qty'],
                    'receive_qty' => $product['receive_qty'],
                    // 'discrepancy_value' => $product['discrepancy_value'],
                    'discrepancy_value' => round($product['order_qty'] - $product['receive_qty'], 2),
                    // 'discrepancy_remarks' => implode(', ', $product['discrepancy_remarks']),
                    // 'corrective_action_taken' => implode(', ', $product['corrective_action']),
                      'discrepancy_remarks' => $product['discrepancy_remarks'],
                    'corrective_action_taken' => $product['corrective_action'],
                    'qty_type' => $product['qty_type'],
                    'temperature' => $product['temperature'],
                    'temperature_image' => $temperature_image,
                    'attachment_coa' => $attachment_coa,
                    'is_yield' => $yield_no,
                    'created_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
            }
        }

        return response()->json(['status' => true,'message' => 'Record saved successfully!'], 200);
        
    }
    
    
        public function saveVerificationReceivingRecord(Request $request){
              try {
                $recordIds = $request->input('recordIds');
                $comment = $request->input('comments');
                $signatureName = null;
        
                if ($request->filled('signature') && $request->signature !== 'null') {
                    $signatureData = str_replace('data:image/png;base64,', '', $request->signature);
                    $signatureData = str_replace(' ', '+', $signatureData);
                    $filename = time().'_user_signature.png';
                    $path = 'uploads/record/sign/'.$filename;
                    \Storage::disk('public')->put($path, base64_decode($signatureData));
                    $signatureName = asset('storage/'.$path);
                }
        
                DB::table('receiving_record_verification')
                    ->whereIn('receiving_record_id', $recordIds)
                    ->delete();
        
                foreach ($recordIds as $rid) {
                    DB::table('receiving_record_verification')->insert([
                        'receiving_record_id' => $rid,
                        'comment' => $comment,
                        'signature' => $signatureName,
                        'created_by' => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
        
        
                return response()->json(['success' => true, 'message' => 'Verification saved successfully.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        
    public function getProductBasisOnVendor(Request $request)
    {
        $auth = Auth::user();
        $user_id = $auth->id;
        $user_ids = [$user_id];
    
        $user = DB::table('users')->where('id', $user_id)->first();
    
        if ($auth->is_role == 1 && $user && $user->created_by) {
            $user_ids[] = $user->created_by;
        } elseif (!in_array($auth->is_role, [0, 2]) && $user) {
            if ($user->created_by) {
                $user_ids[] = $user->created_by;
            }
            if ($user->created_by1) {
                $user_ids[] = $user->created_by1;
            }
        }
    
        $user_ids[] = 1; 
        $user_ids = array_unique($user_ids);
    
        $productDetailIds = DB::table('sqa_raw_material_product_vendors')
            ->where('sqa_new_supplier_name', $request->name)
            ->whereIn('created_by', $user_ids)
            ->pluck('sqa_raw_material_product_detail_id');
    
        // $products = DB::table('sqa_raw_material_product_details as mpd')
        //     ->select('mp.name', 'mpv.sqa_brand_name')
        //     ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
        //     ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
        //     ->whereIn('mpd.id', $productDetailIds)  
        //     ->get();
    
        // $productDatabase = $products->groupBy('name')
        //     ->map(function ($items) {
        //         return $items->pluck('sqa_brand_name')
        //             ->filter()
        //             ->unique()
        //             ->values()
        //             ->toArray();
        //     })
        //     ->toArray();
            
            
                
        $products = DB::table('sqa_raw_material_product_details as mpd')
            ->select('mp.name', 'mpv.sqa_brand_name')
            ->leftJoin('sqa_raw_material_product as mp', 'mp.id', '=', 'mpd.sqa_raw_mat_prod_id')
            ->leftJoin('sqa_raw_material_product_variants as mpv', 'mpd.id', '=', 'mpv.sqa_raw_material_product_detail_id')
            ->whereIn('mpd.id', $productDetailIds)
            ->get();
    
        $productDatabase = $products->groupBy('name')
            ->map(function ($items) {
                $brands = $items->pluck('sqa_brand_name')
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();
                return empty($brands) ? [] : $brands;
            })
            ->toArray();
    
        return response()->json([
            'status' => true,
            'message' => 'Get successfully',
            'data' => $productDatabase  
        ]);
    }

    }

