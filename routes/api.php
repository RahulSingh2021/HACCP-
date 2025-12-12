<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-otp', [AuthController::class, 'verify_otp']);
Route::post('/create-mpin', [AuthController::class, 'create_mpin']);
Route::post('/login-mpin', [AuthController::class, 'login_mpin']);
Route::post('/loginbyemail', [AuthController::class, 'loginByEmail']);
Route::post('/department-list', [AuthController::class, 'department_list']);
Route::post('/responsibility-list', [AuthController::class, 'responsibility_list']);
Route::post('/inspection-list', [AuthController::class, 'inspection_list']);
Route::post('/department-location', [AuthController::class, 'department_location']);
Route::post('/responbility-concern', [AuthController::class, 'responbility_concern']);
Route::post('/add-inspection', [AuthController::class, 'add_inspection']);
Route::post('/edit-inspection', [AuthController::class, 'edit_inspection']);
Route::post('/corporate-list', [AuthController::class, 'corporate_list']);
Route::post('/regional-list', [AuthController::class, 'regional_list']);
Route::post('/unit-list', [AuthController::class, 'unit_list']);
Route::post('/edit-inspection', [AuthController::class, 'edit_inspection']);
Route::post('/update-inspection', [AuthController::class, 'update_inspection']);
Route::post('/user-details', [AuthController::class, 'user_details']);
Route::post('/delete-inspection', [AuthController::class, 'delete_inspection']);
Route::post('/follow-up-inspection', [AuthController::class, 'follow_up']);
Route::post('/follow-up-inspection-list', [AuthController::class, 'follow_up_list']);
Route::get('/get-all-weeks', [AuthController::class, 'getAllWeeks']);
Route::get('/filter-week', [AuthController::class, 'weekData']);
Route::get('/get-cleaning-schedules', [AuthController::class, 'getCleaningSchedules']);
Route::get('/get-cleaning-schedules-history', [AuthController::class, 'getCleaningSchedulesHistory']);
Route::post('/cleaning-schedule-attend', [AuthController::class, 'cleaningScheduleAttend']);
Route::get('/get-months-data', [AuthController::class, 'getMonthsDataPM']);
Route::get('/get-pm-schedules', [AuthController::class, 'getPMSchedules']);
Route::get('/get-pm-schedule-history', [AuthController::class, 'getPMScheduleHistory']);
Route::post('/pm-schedule-attend', [AuthController::class, 'pmScheduleAttend']);
Route::get('/get-yearly-month', [AuthController::class, 'getYearlyMonth']);
Route::get('/get-monthly-week', [AuthController::class, 'getMonthlyWeek']);
Route::get('/get-cleaning-filter-schedule', [AuthController::class, 'getCleaningScheduleFilters']);
Route::get('/get-pm-filter-schedule', [AuthController::class, 'getPMScheduleFilters']);
Route::get('/delete-breakdown', [AuthController::class, 'deleteBreakdown']);
Route::get('/get-equipments-list', [AuthController::class, 'getEquipmentLists']);
Route::post('/add-breakdown', [AuthController::class, 'addBreakdown']);
Route::get('/get-breakdown-data-by-id', [AuthController::class, 'getBreakdownDataById']);
Route::get('/get-all-breakdown-data', [AuthController::class, 'getAllBreakdownData']);
Route::post('/approve-breakdown', [AuthController::class, 'approveBreakdown']);
Route::get('/get-equipment-list-with-all-data', [AuthController::class, 'getEquipmentListWithAllData']);
Route::get('/get-equipment-list-filter-with-all-data', [AuthController::class, 'getEquipmentListFilterWithAllData']);
Route::post('/add-equipment', [AuthController::class, 'AddEquipment']);
Route::post('/edit-equipment', [AuthController::class, 'EditEquipment']);
Route::get('/get-all-course-web', [AuthController::class, 'getAllCourseWeb']);



