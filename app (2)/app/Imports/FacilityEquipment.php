<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use App\Models\FacilityEquipmentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FacilityEquipment implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     * Handle the collection of rows from the Excel file.
     */
//     public function collection(Collection $collection)
//     {
        
//         $insertedId = DB::table('facility_equipment')->insert([
//     'cat_id' => null,
//     'location_id' => 327,
//     'department' => null,
//     'responsibility_id' => null,
//     'c_frequency' => null,
//     'p_frequency' => null,
//     'equipment_id' => 'Maurya/PTM/01',
//     'created_by' => 60,
//     'modal_number' => null,
//     'brand' => null,
//     'name' => 'Probe Thermometer',
//     'cleaning_task_start_date' => null,
//     'pm_task_start_date' => null,
//     'company_logo' => null,
//     'corporate_id' => null,
//     'regional_id' => null,
//     'hotel_name' => null,
//     'sub_location' => null,
//     'type' => null,
//     'capacity_range' => null,
//     'capacity_utility_range' => null,
//     'cleaning_last_completed_on' => null,
//     'pm_last_completed_on' => null,
//     'Calibration_status' => 'yes',
//     'create_at' => null,
//     'update_at' => null,
//     'status' => 1
// ]);

// // Log the inserted ID or any additional checks
// Log::info("Inserted facility equipment with ID  kjkjkkj: $insertedId");


// die;
//         $error_messages = []; 

//         foreach ($collection as $row) {
//             if ($row->isEmpty()) continue;

//             // Initialize the necessary data variables
//             $location_data = null;
//             $department_data = null;
//             $responsibility = null;
//             $category = null;

//             try {
//                 // Fetch location data
//                 if (!empty($row['location'])) {
//                     $location_data = DB::table('locations')->where('name', $row['location'])->first();
//                     if (empty($location_data)) {
//                         $error_messages[] = 'Location not found: ' . $row['location'];
//                     }
//                 }
                
//                 // Fetch department data
//                 if (!empty($row['department'])) {
//                     $department_data = DB::table('departments')->where('name', $row['department'])->first();
//                     if (empty($department_data)) {
//                         $error_messages[] = 'Department not found: ' . $row['department'];
//                     }
//                 }

//                 // Fetch responsibility data
//                 if (!empty($row['cleaning_responsibility'])) {
//                     $responsibility = DB::table('authority')->where('name', $row['cleaning_responsibility'])->first();
//                     if (empty($responsibility)) {
//                         $error_messages[] = 'Responsibility not found: ' . $row['cleaning_responsibility'];
//                     }
//                 }

//                 // Fetch category data
//                 if (!empty($row['equipment_category'])) {
//                     $category = DB::table('fhm_category')->where('name', $row['equipment_category'])->first();
//                     if (empty($category)) {
//                         $error_messages[] = 'Category not found: ' . $row['equipment_category'];
//                     }
//                 }

//                 // Check if there are any error messages for missing data
//                 // if (!empty($error_messages)) {
//                 //     throw new \Exception(implode(', ', $error_messages));  // Throw an exception if errors exist
//                 // }

       
// // $facilityEquipmentData = [
// //     'cat_id' => !empty($category) && isset($category->id) ? $category->id : null,
// //     'location_id' => !empty($location_data) && isset($location_data->id) ? $location_data->id : null,
// //     'department' => !empty($department_data) && isset($department_data->id) ? $department_data->id : null,
// //     'responsibility_id' => !empty($responsibility) && isset($responsibility->id) ? $responsibility->id : null,
// //     'c_frequency' => !empty($category) && isset($category->c_frequency_weekly) ? $category->c_frequency_weekly : null,
// //     'p_frequency' => !empty($category) && isset($category->p_frequency) ? $category->p_frequency : null,
// //     'equipment_id' => !empty($row['equipment_id']) ? $row['equipment_id'] : null,
// //     'created_by' => Auth::user()->id,
// //     'modal_number' => !empty($row['modal_number']) ? $row['modal_number'] : null,
// //     'brand' => !empty($row['brand']) ? $row['brand'] : null,
// //     'name' => !empty($row['equipment_name']) ? $row['equipment_name'] : null,
// //     'cleaning_task_start_date' => !empty($row['cleaning_starting_date']) ? $row['cleaning_starting_date'] : null,
// //     'pm_task_start_date' => !empty($row['pm_starting_date']) ? $row['pm_starting_date'] : null,
// //     'company_logo' => null,
// //     'corporate_id' => null,
// //     'regional_id' => null,
// //     'hotel_name' => null,
// //     'sub_location' => null,
// //     'type' => null,
// //     'capacity_range' => null,
// //     'capacity_utility_range' => null,
// //     'cleaning_last_completed_on' => null,
// //     'pm_last_completed_on' => null,
// //     'Calibration_status' => 'yes',
// //     'create_at' => null,  // Ensure proper format
// //     'update_at' => null,  // Ensure proper format
// //     'status' => 1,
// // ];

// $facilityEquipmentData = [
//     'cat_id' => null,
//     'location_id' => 327,
//     'department' =>  null,
//     'responsibility_id' => null,
//     'c_frequency' =>null,
//     'p_frequency' =>  null,
//     'equipment_id' =>  "Maurya/PTM/01",
//     'created_by' => Auth::user()->id,
//     'modal_number' =>  null,
//     'brand' =>  null,
//     'name' => "Probe Thermometer",
//     'cleaning_task_start_date' =>  null,
//     'pm_task_start_date' => null,
//     'company_logo' => null,
//     'corporate_id' => null,
//     'regional_id' => null,
//     'hotel_name' => null,
//     'sub_location' => null,
//     'type' => null,
//     'capacity_range' => null,
//     'capacity_utility_range' => null,
//     'cleaning_last_completed_on' => null,
//     'pm_last_completed_on' => null,
//     'Calibration_status' => 'yes',
//     'create_at' => null,  // Ensure proper format
//     'update_at' => null,  // Ensure proper format
//     'status' => 1,
// ];


// // Check the data being passed to the DB
// Log::info('Data to be inserted:', $facilityEquipmentData);

// // Insert the data into the database
// $insertedId = DB::table('facility_equipment')->insertGetId($facilityEquipmentData);
// print_r($insertedId);die;
// // Log the inserted ID
// Log::info('Inserted ID: ', [$insertedId]);

// // Additional debugging info to check query execution
// $queryLog = DB::getQueryLog();
// Log::info('Query Log:', $queryLog);
// print_r('aaa');die;
//                 // Log query for debugging
//                 Log::info('Facility Equipment inserted with ID: ' . $insertedId);

//                 // Now handle the calibration data if provided
//                 if ($row['calibration_unique_id'] || $row['calibration_type'] || $row['capacity_range'] ||
//                     $row['calibration_current_utility_range'] || $row['calibration_range'] ||
//                     $row['calibration_least_count'] || $row['calibration_date'] || $row['calibration_exp_date'] ||
//                     $row['certificate_number'] || $row['calibration_due_date']) {

//                     $calibrationData = [
//                         'fhm_id' => $insertedId, 
//                         'least_count' => $row['calibration_least_count'] ?? null,
//                         'unique_id' => $row['calibration_unique_id'] ?? null,
//                         'type' => $row['calibration_type'] ?? null,
//                         'capacity_range' => $row['capacity_range'] ?? null,
//                         'capacity_utility_range' => $row['calibration_current_utility_range'] ?? null,
//                         'calibration_range' => $row['calibration_range'] ?? null,
//                         'calibration_date' => $row['calibration_date'] ?? null,
//                         'calibration_due_date' => $row['calibration_due_date'] ?? null,
//                         'company_logo' => null,
//                         'calibration_expdate' => $row['calibration_exp_date'] ?? null,
//                         'sr_number' => $row['sr_number'] ?? null,
//                         'modal_number' => $row['modal_number'] ?? null,
//                         'created_at' => now(),
//                         'updated_at' => now(),
//                         'created_by' => Auth::user()->id,
//                         'certificate_number' => $row['certificate_number'] ?? null
//                     ];

//                     // Insert calibration data into the facility_equipment_calibration table
//                     DB::table('facility_equipment_calibration')->insert($calibrationData);
//                 }

//             } catch (\Exception $e) {
//                 // Log any errors encountered
//                 Log::error('Error inserting facility equipment: ' . $e->getMessage());
//                 return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
//             }
//         }

//         // If there were any validation errors, display them
//         if (!empty($error_messages)) {
//             return redirect()->back()->with('error', implode(', ', $error_messages));
//         }
//     }
}
