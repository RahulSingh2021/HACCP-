<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FhmController;
use App\Http\Controllers\Admin\AddNewCourseController;
use App\Http\Controllers\Admin\CourseManageController;
use App\Http\Controllers\Admin\AddNewCategoryController;
use App\Http\Controllers\Admin\AddNewCouponController;
use App\Http\Controllers\Admin\CreateTemplateController;
use App\Http\Controllers\StudentDashboard\CompleteSolutionController;
use App\Http\Controllers\StudentDashboard\CoursesBundleController;
use App\Http\Controllers\StudentDashboard\MyCoursesController;
use App\Http\Controllers\StudentDashboard\TrainingCourseController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\NewSupplierController;
use App\Http\Controllers\RecordsController;


use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|-----------------------------------------------------s---------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



 

Route::get('/', function () {
    return view('welcome');
});


Route::post('/add_keyword','\App\Http\Controllers\VendorController@add_keyword')->name('add_keyword');
Route::post('/delete_keyword','\App\Http\Controllers\VendorController@delete_keyword')->name('delete_keyword');
Route::post('/upload-image',[NewSupplierController::class,'ingsupplier_product_upload_specification'])->name('upload.image');
Route::delete('/destroy-raw-material-image/{id}', '\App\Http\Controllers\TrainersController@destroyRawMaterialImage')->name('destroy.raw-material.image');
Route::post('/variant/image/update', '\App\Http\Controllers\TrainersController@updateRawMaterialImage')->name('variant.image.update');
Route::post('/save-krdo-image',[NewSupplierController::class,'saveKrdoImage'])->name('save.krdo.image');
Route::post('/save-multiselect-storage-raw-material', '\App\Http\Controllers\TrainersController@saveMultiselectStorageRawMaterial')->name('save-multiselect-storage-raw-material');

Route::post('/sqa-raw-material-update-risk','\App\Http\Controllers\TrainersController@updateRawMaterialRisk')
     ->name('sqa-raw-material-update-risk');

Route::get('/suppliers/export-all', '\App\Http\Controllers\TrainersController@exportAllSupplier')->name('suppliers.export-all');

Route::post('/update-product-name-raw-material', '\App\Http\Controllers\TrainersController@updateProductNameRawMaterial')->name('update.product.name.raw.material');

Route::get('/get-coa-history-data','\App\Http\Controllers\TrainersController@getCoaHistoryData')
    ->name('get.coa.history.data');
Route::post('/save-coa-renewal','\App\Http\Controllers\TrainersController@saveCoaRenewal')->name('save.coa.renewal');


//new record
Route::group(['prefix' => 'record-new', 'as' => 'record.new.'], function () {
    Route::get('index','\App\Http\Controllers\NewRecordsController@index')->name('index');
    Route::group(['prefix' => 'thawing', 'as' => 'thawing.'], function () {
       Route::get('list','\App\Http\Controllers\NewRecordsController@indexThawingRecord')->name('list');
       Route::get('get-issue-interactive-stock-records','\App\Http\Controllers\NewRecordsController@getIssueInteractiveStockRecords')->name('get.issue.interactive.stock.records');
       Route::get('get-issue-interactive-product','\App\Http\Controllers\NewRecordsController@getIssueInteractiveProduct')->name('get.issue.interactive.product');
       Route::get('get-issue-interactive-product-details','\App\Http\Controllers\NewRecordsController@getIssueInteractiveProductDetails')->name('get.issue.interactive.product.details');
       Route::post('save-record','\App\Http\Controllers\NewRecordsController@saveRecord')->name('save-record');
       Route::post('save-complete-of-record','\App\Http\Controllers\NewRecordsController@saveCompleteOfRecord')->name('save.complete.of.record');
       Route::post('save-verify-of-record','\App\Http\Controllers\NewRecordsController@saveVerifyOfRecord')->name('save.verify.of.record');
        Route::post('save-issued-items','\App\Http\Controllers\NewRecordsController@saveIssuedItems')->name('save.issued.items');
    });
});

    
//new training routes
Route::group(['prefix' => 'training'], function () {
    Route::get('/index',[TrainingController::class,'index'])->middleware(['auth'])->name('training_data_index_new');
    Route::get('/calanderlist',[TrainingController::class,'calanderlist'])->middleware(['auth'])->name('calanderlist');
    Route::group(['prefix' => 'topics'], function () {
           Route::group(['prefix' => 'sops'], function () {
               
             Route::post('/save',[TrainingController::class,'saveSops']);
              Route::post('/delete',[TrainingController::class,'deleteSop']);
              Route::post('/toggle-status', [TrainingController::class, 'toggleStatusSop']);
              Route::post('/update',[TrainingController::class,'UpdateSop']);
              Route::post('/upload-csv',[TrainingController::class,'UploadCsvSop']); 
           });
           
           
           Route::group(['prefix' => 'sub-sops'], function () {
              Route::post('/add',[TrainingController::class,'saveSubSop']);
              Route::post('/delete',[TrainingController::class,'deleteSubSop']);
              Route::post('/toggle-status', [TrainingController::class, 'toggleSubSopStatusSop']);
              Route::post('/update',[TrainingController::class,'UpdateSubSop']);
              Route::post('/upload-csv',[TrainingController::class,'UploadCsvSubSop']); 
           });
           
    });
    
     Route::group(['prefix' => 'tni'], function () {
           Route::post('/save-single-count',[TrainingController::class,'saveSingleCount']);
     });
     
     
    Route::group(['prefix' => 'tni-new-mapping'], function () {
           Route::get('/tni-mapping-new-page',[TrainingController::class,'newTniMappingPage'])->name('tni.mapping.new.page');
     });
     
      Route::group(['prefix' => 'data'], function () {
           Route::get('/data-page',[TrainingController::class,'trainingDataPage'])->name('training.data.page');
         
     });
     
     Route::group(['prefix' => 'trainer'], function () {
           Route::get('/get-user-unit',[TrainingController::class,'getUserUnit']);
           Route::get('/search-employees-trainer', [TrainingController::class, 'searchEmployeeTrainer']);
           Route::get('/delete/{id}',[TrainingController::class,'deleteTrainerEmployee']);
            Route::post('/add-trainer-employee',[TrainingController::class,'addTrainerEmployee']);
            Route::post('/update-trainer-employee-status',[TrainingController::class,'updateTrainerEmployeeStatus']);
     });
     
    Route::group(['prefix' => 'data-new'], function () {
        Route::get('/data-page',[TrainingController::class,'trainingDataNewPage'])->name('training.data.new.page');
        Route::get('/training-hierarchy-data',[TrainingController::class,'trainingHierarchyData'])->name('training.hierarchy.data');
        Route::get('/training-config-data',[TrainingController::class,'trainingConfigDat1a'])->name('training.config.data');
    });
     
    Route::group(['prefix' => 'calendar'], function () {
           Route::delete('/delete-calendar-data/{id}',[TrainingController::class,'deleteCalendarData']);
           Route::get('/old-calendar-page',[TrainingController::class,'trainingOldCalendarPage']);
           Route::post('/add-upload-training-calendar',[TrainingController::class,'addUploadTrainingCalendar'])->name('add.upload.training.calendar');
           Route::get('/calendar-page',[TrainingController::class,'trainingCalendarPage'])->name('training.calendar.page');
           Route::get('/get-sub-sop-by-sop',[TrainingController::class,'getSubSopBySop']);
           Route::delete('/delete/{id}',[TrainingController::class,'deleteCalendarList']);
           Route::delete('/delete-training-pdf/{id}',[TrainingController::class,'deleteTrainingPdf']);
           Route::post('/add',[TrainingController::class,'addCalendarList'])->name('add.training.calendar.data');
           
           Route::post('/update/{id}', [TrainingController::class, 'updateCalendar']);
           Route::get('/certificate/delete/{id}', [TrainingController::class, 'deleteCertificate']);
           Route::get('/search-employee',[TrainingController::class,'getSearchEmployee']);
           Route::get('/get-dynamic-employee-training-scope',[TrainingController::class,'getDynamicEmployeeTrainingScope']);
           Route::post('/add-calendar-training-participant',[TrainingController::class,'addCalendarTrainingParticipant'])->name('add.calendar.training.participant');
           Route::get('/get-calendar-training-participants',[TrainingController::class,'getCalendarTrainingParticipants'])->name('get.calendar.training.participants');
           Route::post('/calendar-remove-participant',[TrainingController::class,'calendarRemoveParticipant'])->name('calendar.remove.participant');
           Route::post('/calendar-update-participant-status',[TrainingController::class,'calendarUpdateParticipantStatus'])->name('calendar.update.participant.status');
           
           
Route::get('/training/calendar/data/{id}', [TrainingController::class, 'getTrainingCalendarData'])->name('get.training.calendar.data');
           Route::put('/training/update/{id}', [TrainingController::class, 'updateTrainingData'])->name('update.training.calendar.data');
     });
     
     
     
    // Route::get('/training_data_index_new', [TrainingController::class,'saveSops'])->middleware(['auth'])->name('training_data_index_new');
    Route::get('/coa-raw-material-popup', [TrainingController::class,'coaRawMaterialPopup'])->middleware(['auth'])->name('coa.raw.material.popup');
    
});


Route::post('/update-datetime-stock-issue',[RecordsController::class,'updateDateTimeStockIssue'])->name('update.datetime.stock.issue');
//record
Route::get('/show-records',[RecordsController::class,'index'])->name('record');

Route::get('/receiving-records',[RecordsController::class,'receivingRecord'])->name('receiving.record');

Route::get('/receiving.record.new',[RecordsController::class,'receivingRecordNew'])->name('receiving.record.new');
Route::get('/get-receiving-records-data-new',[RecordsController::class,'getReceivingRecordsDataNew'])->middleware(['auth'])->name('get-receiving-records-data-new');
Route::post('/store-receiving-record-new',[RecordsController::class,'storeReceivingRecordNew'])->name('store.receiving.record.new');
Route::post('/save-verification-receiving-record',[RecordsController::class,'saveVerificationReceivingRecord'])->name('save.verification.receiving.record');

Route::post('/get-product-basis-on-vendor',[RecordsController::class,'getProductBasisOnVendor'])->name('get.product.basis.on.vendor');


Route::get('/get-receiving-records-data',[RecordsController::class,'getReceivingRecordsData'])->middleware(['auth'])->name('get.receiving.records.data');
Route::post('/store-receiving-record',[RecordsController::class,'storeReceivingRecord'])->name('store.receiving.record');
Route::get('/advance-interactive-stock-register',[RecordsController::class,'advanceInteractiveStockRegister'])->middleware(['auth'])->name('advance.interactive.stock.register');
Route::get('/get-data-interactive-stock-register',[RecordsController::class,'getDataInteractiveStockRegister'])->middleware(['auth'])->name('get.data.interactive.stock.register');

  Route::get('/get-data-hierarchy-training-dashboard',[TrainingController::class,'getDataHierarchyTrainingDashboard'])->middleware(['auth'])->name('get.data.hierarchy.training.dashboard');
  

Route::post('/stock-issue-save',[RecordsController::class,'stockIssueSave'])->name('stock.issue.save');

Route::delete('/delete-receiving-record/{id}', [RecordsController::class, 'destroyReceivingRecord'])
    ->name('delete-receiving-record');
Route::post('/update-receiving-record', [RecordsController::class, 'updateReceivingRecord'])
    ->name('update.receiving.record');  
Route::delete('/issue-stock-destroy/{id}', [RecordsController::class, 'issueDestroyStock'])->name('issue.stock.destroy');
    

//new supplier 
Route::get('supplier-vendor-manage', '\App\Http\Controllers\NewSupplierController@supplierVendorManage')->middleware(['auth'])->name('supplier_vendor_manage');

Route::group(['prefix' => 'new-supplier'], function () {
 Route::post('/add',[NewSupplierController::class,'addNewSupplier']);
 Route::post('/edit-material',[NewSupplierController::class,'updateMaterials']);
  Route::delete('/delete/{id}', [NewSupplierController::class, 'delete']);
  Route::get('/get-categories', [NewSupplierController::class, 'getCategories']);
  Route::get('/get-all-categories', [NewSupplierController::class, 'getAllCategories']);


Route::post('/save-comment/{id}',[NewSupplierController::class,'saveComment']);

// Route::get('/get-subcategories/{categoryId}', [NewSupplierController::class, 'getSubcategories']);

 
 Route::post('/supplier-product-upload-specification',
    [NewSupplierController::class,'supplier_product_upload_specification']
)->name('supplier_product_upload_specification');

Route::post('/bulk-import', [NewSupplierController::class, 'bulkImport'])->name('new-supplier.bulk.import');

});

Route::get('/get-subcategories/{categoryId}', function ($categoryId) {
    $subcategories = DB::table('new_supplier_product_sub_category')
        ->where('prod_cat_id', $categoryId)
        ->get(['id', 'name']);

    return response()->json($subcategories);
})->name('get.subcategories');


Route::get('thanku', '\App\Http\Controllers\EnrollParticipantsController@thanku')->name('thanku');
Route::get('scanlms/{id}', '\App\Http\Controllers\EnrollParticipantsController@scanlms')->name('scanlms');
Route::post('submitscanlms', '\App\Http\Controllers\EnrollParticipantsController@submitscanlms')->name('submitscanlms');

Route::get('/search-employee', '\App\Http\Controllers\EnrollParticipantsController@search')->name('search');
Route::get('/search-employee-details', '\App\Http\Controllers\EnrollParticipantsController@fetchDetails')->name('fetchDetails');



Route::post('exportdatacsv', '\App\Http\Controllers\TrainersController@exportdatacsv')->name('exportdatacsv');
Route::get('demousers', '\App\Http\Controllers\DepartmentController@demousers')->name('demousers');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



Route::post('login_user_set', '\App\Http\Controllers\AuthController@login_user_set')->name('login_user_set');
Route::get('switch_account', '\App\Http\Controllers\AuthController@switch_account')->name('switch_account');



Route::get('adminlogout', '\App\Http\Controllers\AuthController@logout')->name('adminlogout');
Route::get('changePassword', '\App\Http\Controllers\AuthController@changePassword')->name('changePassword');
Route::post('updatePassword', '\App\Http\Controllers\AuthController@updatePassword')->name('updatePassword');
Route::get('users', '\App\Http\Controllers\AuthController@index')->middleware(['auth'])->name('users');
Route::get('corporateManagement', '\App\Http\Controllers\AuthController@corporateManagement')->middleware(['auth'])->name('corporateManagement');
Route::get('regionals/{id}', '\App\Http\Controllers\AuthController@regionals')->name('regionals');
Route::get('units/{id}/{type}/{status}', '\App\Http\Controllers\AuthController@units')->name('units');
Route::post('units-lincesupload', '\App\Http\Controllers\AuthController@lincesupload')->middleware(['auth'])->name('lincesupload');
Route::post('units-updatelincesstatus', '\App\Http\Controllers\AuthController@updatelincesstatus')->middleware(['auth'])->name('updatelincesstatus');
Route::post('updatelinces', '\App\Http\Controllers\AuthController@updatelinces')->middleware(['auth'])->name('updatelinces');
Route::get('destoryDocuments/{id}', '\App\Http\Controllers\AuthController@destoryDocuments')->name('destoryDocuments');
Route::get('getDocuments/{id}/{type}/{user_type}', '\App\Http\Controllers\AuthController@getDocuments')->name('getDocuments');
Route::get('getallDocuments/{id}/{type}/{user_type}', '\App\Http\Controllers\AuthController@getallDocuments')->name('getallDocuments');
Route::get('getotherDocuments/{id}/{type}/{user_type}', '\App\Http\Controllers\AuthController@getotherDocuments')->name('getotherDocuments');
Route::post('units-foodtest', '\App\Http\Controllers\AuthController@foodtest')->middleware(['auth'])->name('foodtest');
Route::get('units-foodtest-delete/{id}', '\App\Http\Controllers\AuthController@foodtestDelete')->middleware(['auth'])->name('foodtestDelete');


Route::get('getexpDocuments/{id}/{type}/{status}/{user_type}', '\App\Http\Controllers\AuthController@getexpDocuments')->name('getexpDocuments');
Route::get('getexpotherDocuments/{id}/{type}/{status}/{user_type}', '\App\Http\Controllers\AuthController@getexpotherDocuments')->name('getexpotherDocuments');
Route::get('unit-history/{id}/{type}', '\App\Http\Controllers\AuthController@unitHistory')->name('unitHistory');
Route::get('unit-history-hra/{id}/{type}', '\App\Http\Controllers\AuthController@unitHistoryHra')->name('unitHistoryHra');
Route::get('all-unit-history/{id}/{type}', '\App\Http\Controllers\AuthController@allUnitHistory')->name('allUnitHistory');


Route::get('linces-history', '\App\Http\Controllers\AuthController@UnitLincesHistory')->name('UnitLincesHistory');
Route::get('fostac-history', '\App\Http\Controllers\AuthController@UnitFocHistory')->name('UnitFocHistory');



Route::get('upload-FoSTaC/{id}/{type}', '\App\Http\Controllers\AuthController@uploadFoSTaC')->name('uploadFoSTaC');

Route::get('FoSTaC-units/{id}/{type}/{status}/{userTye}', '\App\Http\Controllers\AuthController@unitsFoSTaC')->name('unitsFoSTaC');
Route::get('getexpFoSTaCDocuments/{id}/{exp_status}', '\App\Http\Controllers\AuthController@getexpFoSTaCDocuments')->name('getexpFoSTaCDocuments');

Route::get('all-FoSTaC-history/{id}/{type}/{employee}', '\App\Http\Controllers\AuthController@allFoSTaCHistory')->name('allFoSTaCHistory');
Route::get('getFoSTaCDocuments/{id}/{type}/{user_type}', '\App\Http\Controllers\AuthController@getFoSTaCDocuments')->name('getFoSTaCDocuments');



Route::get('regional_list', '\App\Http\Controllers\AuthController@regional_list')->middleware(['auth'])->name('regional_list');
Route::get('filterregional_list', '\App\Http\Controllers\AuthController@filterregional_list')->middleware(['auth'])->name('filterregional_list');
Route::get('filterrunitdeprtmentlist', '\App\Http\Controllers\AuthController@filterrunitdeprtmentlist')->middleware(['auth'])->name('filterrunitdeprtmentlist');

Route::get('unit_corporate_id', '\App\Http\Controllers\AuthController@unit_corporate_id')->middleware(['auth'])->name('unit_corporate_id');

Route::get('regional_unitlist', '\App\Http\Controllers\AuthController@regional_unitlist')->name('regional_unitlist');
Route::get('filterrregional_unitlist', '\App\Http\Controllers\AuthController@filterrregional_unitlist')->name('filterrregional_unitlist');
Route::post('edit-users', '\App\Http\Controllers\AuthController@update')->name('edit_users');
Route::get('department', '\App\Http\Controllers\DepartmentController@index')->middleware(['auth'])->name('department');
Route::get('responsibility', '\App\Http\Controllers\DepartmentController@responsibility')->middleware(['auth'])->name('responsibility');

             
Route::get('usermanagement', '\App\Http\Controllers\DepartmentController@usermanagementnew')->middleware(['auth'])->name('usermanagement');
//Route::get('usermanagement', '\App\Http\Controllers\DepartmentController@usermanagement')->middleware(['auth'])->name('usermanagement');
//Route::get('usermanagementnew', '\App\Http\Controllers\DepartmentController@usermanagementnew')->middleware(['auth'])->name('usermanagementnew');


Route::get('userconcern', '\App\Http\Controllers\DepartmentController@userconcern')->middleware(['auth'])->name('userconcern');
Route::get('userstaffcategory', '\App\Http\Controllers\DepartmentController@userstaffcategory')->middleware(['auth'])->name('userstaffcategory');
Route::post('add-department', '\App\Http\Controllers\DepartmentController@store')->name('add_department');
Route::post('edit-department', '\App\Http\Controllers\DepartmentController@update')->name('edit_department');
Route::get('department-delete/{id}', '\App\Http\Controllers\DepartmentController@destorydepartment')->name('department_delete');
Route::post('add-authority', '\App\Http\Controllers\DepartmentController@storeauthority')->name('add_authority');
Route::post('edit-authority', '\App\Http\Controllers\DepartmentController@editauthority')->name('edit_authority');
Route::get('authority-delete/{id}', '\App\Http\Controllers\DepartmentController@authoritydepartment')->name('authority_delete');
Route::post('add-location', '\App\Http\Controllers\DepartmentController@storelocation')->name('add_location');
Route::post('edit-location', '\App\Http\Controllers\DepartmentController@editlocation')->name('edit_location');
Route::post('add-locationform', '\App\Http\Controllers\DepartmentController@locationform')->name('locationform');
Route::post('edit-locationform', '\App\Http\Controllers\DepartmentController@editlocationform')->name('editlocationform');
Route::post('add-users', '\App\Http\Controllers\AuthController@store')->name('add_users');
Route::get('storeusers-delete/{id}', '\App\Http\Controllers\AuthController@destory')->name('storeusers_delete');

Route::post('add-concern', '\App\Http\Controllers\DepartmentController@storeconcern')->name('add_concern');
Route::get('concern-delete/{id}', '\App\Http\Controllers\DepartmentController@destory_concern')->name('concern_delete');

Route::post('add-staff', '\App\Http\Controllers\DepartmentController@storestaff')->name('add_staff');
Route::get('staff-delete/{id}', '\App\Http\Controllers\DepartmentController@staff_delete')->name('staff_delete');


///***************** Unit Routes ***************////

Route::post('add-unit', '\App\Http\Controllers\DepartmentController@add_unit')->name('add_unit');
Route::post('edit-unit', '\App\Http\Controllers\DepartmentController@edit_unit')->name('edit_unit');
Route::get('department_location', '\App\Http\Controllers\DepartmentController@department_location')->name('department_location');
Route::get('filterdepartment_location', '\App\Http\Controllers\DepartmentController@filterdepartment_location')->name('filterdepartment_location');
Route::get('location_sublocation', '\App\Http\Controllers\DepartmentController@location_sublocation')->name('location_sublocation');
Route::get('equipment_details', '\App\Http\Controllers\FhmController@equipment_details')->name('equipment_details');
Route::get('viewEquipment/{id}', '\App\Http\Controllers\FhmController@viewEquipment')->name('viewEquipment');
Route::post('search_Equipment', '\App\Http\Controllers\FhmController@search_Equipment')->name('search_Equipment');
Route::post('list_Equipment', '\App\Http\Controllers\FhmController@list_Equipment')->name('list_Equipment');
Route::post('add_template_equpiments', '\App\Http\Controllers\FhmController@add_template_equpiments')->name('add_template_equpiments');
Route::post('addTemplateEquipments', '\App\Http\Controllers\FhmController@addTemplateEquipments')->name('addTemplateEquipments');
Route::get('concern_subconcern', '\App\Http\Controllers\DepartmentController@concern_subconcern')->name('concern_subconcern');
Route::get('responbility_concern', '\App\Http\Controllers\DepartmentController@responbility_concern')->name('responbility_concern');
Route::get('delete_Equipment/{id}', '\App\Http\Controllers\FhmController@delete_Equipment')->name('delete_Equipment');

Route::get('deleteFhm/{id}', '\App\Http\Controllers\FhmController@deleteFhm')->name('deleteFhm');



Route::post('add_unit_user', '\App\Http\Controllers\DepartmentController@add_unit_user')->name('add_unit_user');
Route::post('edit_unit_user', '\App\Http\Controllers\DepartmentController@edit_unit_user')->name('edit_unit_user');
Route::get('unit_user-delete/{id}', '\App\Http\Controllers\DepartmentController@unit_user_delete')->name('unit_user_delete');
Route::get('demounit_user-delete/{id}', '\App\Http\Controllers\DepartmentController@demo_unit_user_delete')->name('demo_unit_user_delete');
Route::get('unit_department-delete/{id}', '\App\Http\Controllers\DepartmentController@unit_department_delete')->name('unit_department_delete');

Route::get('unit_department_location-delete/{id}', '\App\Http\Controllers\DepartmentController@unit_department_location_delete')->name('unit_department_location_delete');



Route::post('edit_unit_user_sublocation', '\App\Http\Controllers\DepartmentController@edit_unit_user_sublocation')->name('edit_unit_user_sublocation');

Route::post('edit_unit_user_location', '\App\Http\Controllers\DepartmentController@edit_unit_user_location')->name('edit_unit_user_location');
Route::post('edit_unit_user_department', '\App\Http\Controllers\DepartmentController@edit_unit_user_department')->name('edit_unit_user_department');
Route::post('unit_user_status', '\App\Http\Controllers\DepartmentController@unit_user_status')->name('unit_user_status');
Route::get('unit_user_status_history/{id}', '\App\Http\Controllers\DepartmentController@unit_user_status_history')->name('unit_user_status_history');



//Route::get('units/{id}', '\App\Http\Controllers\AuthController@units')->name('units');

/************************ Facility Hygiene ***************/
Route::get('Facility-Hygiene', '\App\Http\Controllers\FhmController@index')->middleware(['auth'])->name('facility_hygiene');
Route::get('Facility-Hygiene-new', '\App\Http\Controllers\FhmController@index1')->middleware(['auth'])->name('facility_hygiene_new');
Route::get('Cleaningschedule', '\App\Http\Controllers\FhmController@Cleaningschedule')->middleware(['auth'])->name('Cleaningschedule');
Route::get('Facility-Hygiene-Category', '\App\Http\Controllers\FhmController@fhmcat')->middleware(['auth'])->name('facility_hygiene_fhmcat');
Route::post('facility_store', '\App\Http\Controllers\FhmController@store')->name('facility_store');
Route::post('updateEqupiments', '\App\Http\Controllers\FhmController@updateEqupiments')->name('updateEqupiments');
Route::post('deletelinkEqupiments', '\App\Http\Controllers\FhmController@deletelinkEqupiments')->name('deletelinkEqupiments');
Route::post('facility_store_cat', '\App\Http\Controllers\FhmController@storeCat')->name('facility_store_cat');
Route::POST('import_equipment2', 'App\Http\Controllers\FhmController@import_equipment2')->name('import_equipment2');
Route::get('facility_store-cat-delete/{id}', '\App\Http\Controllers\FhmController@destory_cat')->name('facility_store_cat_delete');
Route::get('facility_cat_details', '\App\Http\Controllers\FhmController@facility_cat_details')->name('facility_cat_details');
Route::get('Facility-Hygiene-Details/{id}', '\App\Http\Controllers\FhmController@fhm_details')->name('fhm_details');
Route::get('Facility-Hygiene-Calibration/{id}', '\App\Http\Controllers\FhmController@Calibration_details')->name('Calibration_details');
Route::get('Facility-Hygiene-Calibration-history/{id}', '\App\Http\Controllers\FhmController@Calibration_history')->name('Calibration_history');
Route::post('facility_edit', '\App\Http\Controllers\FhmController@facility_edit')->name('facility_edit');

Route::get('Facility-Hygiene-delete/{id}', '\App\Http\Controllers\FhmController@fhm_delete')->name('fhm_delete');

Route::post('facility_calibration_history', '\App\Http\Controllers\FhmController@facility_calibration_history')->name('facility_calibration_history');

Route::post('AddChecklist', '\App\Http\Controllers\FhmController@AddChecklist')->name('AddChecklist');
Route::get('Checklist/delete/{id}', '\App\Http\Controllers\FhmController@delete_checklist')->name('delete_checklist');


Route::post('AddChecklistNew', '\App\Http\Controllers\FhmController@AddChecklistNew')->name('AddChecklistNew');



Route::post('saveNotes', '\App\Http\Controllers\FhmController@saveNotes')->name('saveNotes');
Route::post('completeTask', '\App\Http\Controllers\FhmController@completeTask')->name('completeTask');
Route::post('verifiedTask', '\App\Http\Controllers\FhmController@verifiedTask')->name('verifiedTask');

Route::post('Facility-Hygiene-status', '\App\Http\Controllers\FhmController@fhm_status_change')->name('fhm_status_change');
Route::post('calibration-status-changes', '\App\Http\Controllers\FhmController@calibration_status_changes')->name('calibration_status_changes');


/************************ FSSAI Compliance ***************/
Route::get('fssai/linces', '\App\Http\Controllers\FhmController@linces')->middleware(['auth'])->name('linces');
Route::get('fssai/food', '\App\Http\Controllers\FhmController@food')->middleware(['auth'])->name('food');
Route::get('fssai/fssailinces', '\App\Http\Controllers\FhmController@fssailinces')->middleware(['auth'])->name('fssailinces');
Route::post('fssai/fssailincesDelete', '\App\Http\Controllers\AuthController@fssailincesDelete')->middleware(['auth'])->name('fssailincesDelete');

Route::post('fssai/License_catageory', '\App\Http\Controllers\FhmController@License_catageory')->middleware(['auth'])->name('License_catageory');
Route::get('fssai/License_catageory_delete/{id}', '\App\Http\Controllers\FhmController@License_catageory_delete')->middleware(['auth'])->name('License_catageory_delete');

Route::get('fssai/medical', '\App\Http\Controllers\FhmController@medical')->middleware(['auth'])->name('medical');
Route::get('fssai/fostac', '\App\Http\Controllers\FhmController@fostac')->middleware(['auth'])->name('fostac');
Route::get('fssai/corporate-fostac', '\App\Http\Controllers\FhmController@corporatefostac')->middleware(['auth'])->name('corporatefostac');
Route::get('fssai/corporate-fostac-linces', '\App\Http\Controllers\FhmController@corporatefostaclinces')->middleware(['auth'])->name('corporatefostaclinces');
Route::get('fssai/corporate-fostac-unit-linces', '\App\Http\Controllers\FhmController@corporatefostacunitlinces')->middleware(['auth'])->name('corporatefostacunitlinces');
Route::post('fssai/fostacDelete', '\App\Http\Controllers\FhmController@fostacDelete')->middleware(['auth'])->name('fostacDelete');


/************************Gourav ***************/
/** Breakdown **/

Route::get('breakdown', '\App\Http\Controllers\FhmController@breakdown')->name('breakdown');
Route::get('delete-breakdown/{id}', '\App\Http\Controllers\FhmController@deletebreakdown')->name('delete_breakdown');
Route::get('breakdown-add-page', '\App\Http\Controllers\FhmController@breakdownaddpage')->name('breakdown_add_page');
Route::post('breakdown-add', '\App\Http\Controllers\FhmController@breakdownadd')->name('breakdown_add');


Route::get('approve_page_breakdown/{id}', '\App\Http\Controllers\FhmController@addPageBreakdown')->name('approve_page_breakdown');


/**Cleaning Schedule**/
Route::get('facility_hygiene_cleaning_schedule', '\App\Http\Controllers\FhmController@fhmcleaningschedule')->name('facility_hygiene_cleaning_schedule');
Route::get('facility_hygiene_cleaning_schedule_new', '\App\Http\Controllers\FhmController@facility_hygiene_cleaning_schedule_new')->name('facility_hygiene_cleaning_schedule_new');

Route::post('calibration-status-update', '\App\Http\Controllers\FhmController@calibration_status_change')->name('calibration_status_change');
Route::post('calibration-upload-file', '\App\Http\Controllers\FhmController@calibration_upload_file')->name('calibration_upload_file');


Route::get('facility_hygiene_cleaning_schedule_history/{id}', '\App\Http\Controllers\FhmController@fhmcleaningschedulehistory')->name('facility_hygiene_cleaning_schedule_history');


Route::get('facility_hygiene_pm_schedule', '\App\Http\Controllers\FhmController@fhmpmschedule')->name('facility_hygiene_pm_schedule');
Route::get('facility_hygiene_pm_schedule_history/{id}', '\App\Http\Controllers\FhmController@fhmpmschedulehistory')->name('facility_hygiene_pm_schedule_history');
Route::post('add_calibration_list', '\App\Http\Controllers\FhmController@add_calibration_list')->name('add_calibration_list');
Route::post('add_calibration_list_renew', '\App\Http\Controllers\FhmController@add_calibration_list_renew')->name('add_calibration_list_renew');
Route::post('remove_calibration_list', '\App\Http\Controllers\FhmController@remove_calibration_list')->name('remove_calibration_list');



Route::get('get-equipment-name/{id}', [\App\Http\Controllers\FhmController::class, 'fhmCleaningEquipmentName'])->name('get-equipment-name');
Route::get('fhm-category-export', [\App\Http\Controllers\FhmController::class, 'fhmCategoryExport'])->name('fhm-category-export');
Route::get('fhm-responsibility-export', [\App\Http\Controllers\FhmController::class, 'fhmResponsibilityExport'])->name('fhm-responsibility-export');
Route::get('fhm-department-export', [\App\Http\Controllers\FhmController::class, 'fhmDepartmentExport'])->name('fhm-department-export');
Route::get('fhm-cleaning-export', [\App\Http\Controllers\FhmController::class, 'fhmCleaningExport'])->name('fhm-cleaning-export');
Route::get('fhm-pm-export', [\App\Http\Controllers\FhmController::class, 'fhmPMExport'])->name('fhm-pm-export');
Route::get('fhm-equpimentlist-export', [\App\Http\Controllers\FhmController::class, 'fhmEquipmentListExport'])->name('fhm-equpimentlist-export');


Route::get('pm_schedules', '\App\Http\Controllers\FhmController@breakdown')->name('pm_schedules');




Route::get('facility_store-delete/{id}', '\App\Http\Controllers\FhmController@destory')->name('facility_store_delete');
Route::get('facility_store-calibration-delete/{id}', '\App\Http\Controllers\FhmController@destoryCalibration')->name('facility_store_destoryCalibration');
Route::post('facility_update', '\App\Http\Controllers\FhmController@update')->name('facility_update');
Route::post('chemical_store', '\App\Http\Controllers\FhmController@chemical_store')->name('chemical_store');
Route::post('chemical_edit', '\App\Http\Controllers\FhmController@chemical_edit')->name('chemical_edit');
Route::get('chemical_store-delete/{id}', '\App\Http\Controllers\FhmController@destory1')->name('chemical_store_delete');
Route::post('facility_tool_store', '\App\Http\Controllers\FhmController@facility_tool_store')->name('facility_tool_store');
Route::get('facility_tool_store-delete/{id}', '\App\Http\Controllers\FhmController@destory2')->name('facility_tool_delete');
Route::post('facility_tool_update', '\App\Http\Controllers\FhmController@facility_tool_update')->name('facility_tool_update');
Route::post('schedule_maker_store', '\App\Http\Controllers\FhmController@schedule_maker_store')->name('schedule_maker_store');
Route::post('calibration_store', '\App\Http\Controllers\FhmController@calibration_store')->name('calibration_store');
Route::post('calibration_edit', '\App\Http\Controllers\FhmController@calibration_edit')->name('calibration_edit');
Route::post('schedule_maker_edit', '\App\Http\Controllers\FhmController@schedule_maker_edit')->name('schedule_maker_edit');
Route::get('facility_schedule_store-delete/{id}', '\App\Http\Controllers\FhmController@destory3')->name('facility_schedule_delete');
Route::POST('import_equipment', 'App\Http\Controllers\FhmController@import')->name('import_equipment');
Route::POST('import_equipment1', 'App\Http\Controllers\FhmController@import1')->name('import_equipment1');
Route::POST('importDepartment', 'App\Http\Controllers\FhmController@importDepartment')->name('importDepartment');
Route::POST('importLocation', 'App\Http\Controllers\FhmController@importLocation')->name('importLocation');
Route::POST('importUserManagement', 'App\Http\Controllers\FhmController@importUserManagement')->name('importUserManagement');
Route::POST('importConcernManagement', 'App\Http\Controllers\FhmController@importConcernManagement')->name('importConcernManagement');
Route::POST('importSupplier', 'App\Http\Controllers\FhmController@importSupplier')->name('importSupplier');

Route::get('calibration-delete/{id}', '\App\Http\Controllers\FhmController@calibration_delete')->name('calibration_delete');
Route::POST('importCoa', 'App\Http\Controllers\FhmController@importCoa')->name('importCoa');
Route::POST('importFga', 'App\Http\Controllers\FhmController@importFga')->name('importFga');


Route::POST('importUserManagementData', 'App\Http\Controllers\FhmController@importUserManagementData')->name('importUserManagementData');
Route::POST('updateEmployee', 'App\Http\Controllers\FhmController@updateEmployee')->name('updateEmployee');
Route::get('unit_user-deletes/{id}', 'App\Http\Controllers\FhmController@DeleteEmployee')->name('DeleteEmployee');
Route::post('deactivateupdateStatus', 'App\Http\Controllers\DepartmentController@deactivateupdateStatus')->name('deactivateupdateStatus');
Route::post('activateupdateStatus', 'App\Http\Controllers\DepartmentController@activateupdateStatus')->name('activateupdateStatus');






/************************ End Facility Hygiene ***************/

/************************  Nutrilator  ***************/
Route::get('nutrilator', '\App\Http\Controllers\NutrilatorController@index')->middleware(['auth'])->name('nutrilator');
Route::get('nutrilatornew', '\App\Http\Controllers\NutrilatorController@index1')->middleware(['auth'])->name('nutrilatornew');
Route::post('nutrilator_measurement_unit_store', '\App\Http\Controllers\NutrilatorController@nutrilator_measurement_unit_store')->name('nutrilator_measurement_unit_store');
Route::post('nutrilator_measurement_unit_edit', '\App\Http\Controllers\NutrilatorController@nutrilator_measurement_unit_edit')->name('nutrilator_measurement_unit_edit');
Route::get('nutrilator_measurement_unit_store-delete/{id}', '\App\Http\Controllers\NutrilatorController@destory')->name('nutrilator_measurement_unit_delete');
Route::post('refrences_store', '\App\Http\Controllers\NutrilatorController@refrences_store')->name('refrences_store');
Route::post('product_Ingredients', '\App\Http\Controllers\NutrilatorController@product_Ingredients')->name('product_Ingredients');
Route::get('Ingredientslist', '\App\Http\Controllers\NutrilatorController@Ingredientslist')->name('Ingredientslist');
Route::post('Ingredientslist', '\App\Http\Controllers\NutrilatorController@Ingredientslist');
Route::post('Ingredient_details', '\App\Http\Controllers\NutrilatorController@Ingredient_details')->name('Ingredient_details');
Route::get('copy_ingredient_items', '\App\Http\Controllers\NutrilatorController@copy_ingredient_items')->name('copy_ingredient_items');
Route::get('keyword_ingredient_items', '\App\Http\Controllers\NutrilatorController@keyword_ingredient_items')->name('keyword_ingredient_items');
Route::get('ingredient_items_status', '\App\Http\Controllers\NutrilatorController@ingredient_items_status')->name('ingredient_items_status');
Route::get('ingredient_protinupdate', '\App\Http\Controllers\NutrilatorController@ingredient_protinupdate')->name('ingredient_protinupdate');
Route::get('ingredient_keyworddelate', '\App\Http\Controllers\NutrilatorController@ingredient_keyworddelate')->name('ingredient_keyworddelate');
Route::get('recipe_protinupdate', '\App\Http\Controllers\NutrilatorController@recipe_protinupdate')->name('recipe_protinupdate');

Route::get('ingredient_recipe_items', '\App\Http\Controllers\NutrilatorController@ingredient_recipe_items')->name('ingredient_recipe_items');
Route::get('usermanagementlist', '\App\Http\Controllers\DepartmentController@usermanagementlist')->name('usermanagementlist');
Route::post('update-status', '\App\Http\Controllers\DepartmentController@updateStatus')->name('updateStatus');


/************************ Serving Area  ***************/

Route::post('get_servingArea', '\App\Http\Controllers\NutrilatorController@get_servingArea')->name('get_servingArea');

Route::post('store_servingArea', '\App\Http\Controllers\NutrilatorController@store_servingArea')->name('store_servingArea');
Route::post('update_servingArea', '\App\Http\Controllers\NutrilatorController@update_servingArea')->name('update_servingArea');
Route::get('delete_servingArea/{id}', '\App\Http\Controllers\NutrilatorController@delete_servingArea')->name('delete_servingArea');
Route::post('update_datarefrence', '\App\Http\Controllers\NutrilatorController@update_datarefrence')->name('update_datarefrence');
Route::get('delete_datarefrence/{id}', '\App\Http\Controllers\NutrilatorController@delete_datarefrence')->name('delete_datarefrence');
Route::post('editproduct_Ingredients', '\App\Http\Controllers\NutrilatorController@editproduct_Ingredients')->name('editproduct_Ingredients');
Route::get('deleteproduct_Ingredients/{id}', '\App\Http\Controllers\NutrilatorController@deleteproduct_Ingredients')->name('deleteproduct_Ingredients');
Route::get('deleteproduct_allergen/{id}', '\App\Http\Controllers\NutrilatorController@deleteproduct_allergen')->name('deleteproduct_allergen');

/************************ End Serving Area  ***************/

/************************ Serving Area  ***************/


Route::post('store_Ingredient', '\App\Http\Controllers\NutrilatorController@store_Ingredient')->name('store_Ingredient');
Route::post('update_Ingredient', '\App\Http\Controllers\NutrilatorController@update_Ingredient')->name('update_Ingredient');
Route::get('deleteIngredients/{id}', '\App\Http\Controllers\NutrilatorController@deleteIngredients')->name('deleteIngredients');
Route::get('deleteIngredientslist', '\App\Http\Controllers\NutrilatorController@deleteIngredientslist')->name('deleteIngredientslist');
Route::post('deleterecipelists', '\App\Http\Controllers\NutrilatorController@deleterecipelists')->name('deleterecipelists');


/************************ End Serving Area  ***************/


/************************ End nutrilator  ***************/






Route::post('search_recipe', '\App\Http\Controllers\RecipeController@search_recipe')->name('search_recipe');
Route::post('search_recipe1', '\App\Http\Controllers\RecipeController@search_recipe1')->name('search_recipe1');
Route::post('search_recipe2', '\App\Http\Controllers\RecipeController@search_recipe2')->name('search_recipe2');

Route::post('search_recipe3', '\App\Http\Controllers\RecipeController@search_recipe3')->name('search_recipe3');
Route::post('search_recipe4', '\App\Http\Controllers\RecipeController@search_recipe4')->name('search_recipe4');
Route::post('search_recipe5', '\App\Http\Controllers\RecipeController@search_recipe5')->name('search_recipe5');
Route::post('Recipeslist', '\App\Http\Controllers\RecipeController@Recipeslist')->name('Recipeslist');
Route::get('recipes/paginated', '\App\Http\Controllers\RecipeController@getPaginatedRecipes')->name('recipes.paginated');




Route::post('add_recipe', '\App\Http\Controllers\RecipeController@add_recipe')->name('add_recipe');
Route::post('add_recipe_item', '\App\Http\Controllers\RecipeController@add_recipe_item')->name('add_recipe_item');
Route::get('edit_recipe/{slug}', '\App\Http\Controllers\RecipeController@edit_recipe')->name('edit_recipe');
Route::get('update_recipe', '\App\Http\Controllers\RecipeController@edit_recipe')->name('update_recipe');
Route::post('update_recipe_item', '\App\Http\Controllers\RecipeController@update_recipe_item')->name('update_recipe_item');
Route::post('update_recipe_items', '\App\Http\Controllers\RecipeController@update_recipe_items')->name('update_recipe_items');
Route::get('update_recipe_details', '\App\Http\Controllers\RecipeController@edit_recipe')->name('update_recipe_details');
Route::post('update_recipe_details_item', '\App\Http\Controllers\RecipeController@update_recipe_details_item')->name('update_recipe_details_item');
Route::post('update_recipe_details_item', '\App\Http\Controllers\RecipeController@update_recipe_details_item')->name('update_recipe_details_item');
Route::get('delete_save_recipe/{id}', '\App\Http\Controllers\RecipeController@delete_save_recipe')->name('delete_save_recipe');
Route::get('delete_recipe_item/{id}', '\App\Http\Controllers\RecipeController@delete_recipe_item')->name('delete_recipe_item');
Route::get('copy_recipe_items/{id}', '\App\Http\Controllers\RecipeController@copy_recipe_items')->name('copy_recipe_items');
Route::get('edit_recipe_print/{id}', '\App\Http\Controllers\RecipeController@edit_recipe_print')->name('edit_recipe_print');
Route::post('update_recipe', '\App\Http\Controllers\RecipeController@update_recipe')->name('update_recipe');
Route::post('update_final_Weight', '\App\Http\Controllers\RecipeController@update_recipe_details_item')->name('update_final_Weight');
Route::get('export_recipe_data', '\App\Http\Controllers\RecipeController@export_recipe_data')->name('export_recipe_data');
Route::post('update-create-recipe-items', '\App\Http\Controllers\RecipeController@storeOrUpdate')->name('update_create_recipe_items');

Route::get('copy_recipe_itemslist', '\App\Http\Controllers\RecipeController@copy_recipe_itemslist')->name('copy_recipe_itemslist');
Route::post('change_recipe_status', '\App\Http\Controllers\RecipeController@change_recipe_status')->name('change_recipe_status');
















/************************  Multiple Delete  ***************/



Route::delete('delete_all_companydetails', '\App\Http\Controllers\DepartmentController@delete_all_companydetails')->name('delete_all_companydetails');
Route::delete('delete_all_departments', '\App\Http\Controllers\DepartmentController@delete_all_departments')->name('delete_all_departments');
Route::delete('delete_all_responsibility', '\App\Http\Controllers\DepartmentController@delete_all_responsibility')->name('delete_all_responsibility');

Route::delete('delete_all_usermanagment', '\App\Http\Controllers\DepartmentController@delete_all_usermanagment')->name('delete_all_usermanagment');


Route::delete('delete_all_equpitments', '\App\Http\Controllers\FhmController@delete_all_equpitments')->name('delete_all_equpitments');
Route::delete('delete_all_chemicalselection', '\App\Http\Controllers\FhmController@delete_all_chemicalselection')->name('delete_all_chemicalselection');

Route::delete('delete_all_toolselection', '\App\Http\Controllers\FhmController@delete_all_toolselection')->name('delete_all_toolselection');


Route::delete('delete_all_cleaning_schedular', '\App\Http\Controllers\FhmController@delete_all_cleaning_schedular')->name('delete_all_cleaning_schedular');

Route::delete('delete_all_cleaning_schedular1', '\App\Http\Controllers\FhmController@delete_all_cleaning_schedular')->name('delete_all_cleaning_schedular1');
Route::delete('delete_all_recipe', '\App\Http\Controllers\RecipeController@delete_all_recipe')->name('delete_all_recipe');
Route::delete('delete_all_ingredient', '\App\Http\Controllers\NutrilatorController@delete_all_ingredient')->name('delete_all_ingredient');
Route::delete('delete_all_supplyer', '\App\Http\Controllers\VendorController@delete_all_supplyer')->name('delete_all_supplyer');
Route::delete('delete_all_pcat', '\App\Http\Controllers\VendorController@delete_all_pcat')->name('delete_all_pcat');
Route::delete('delete_all_coa', '\App\Http\Controllers\VendorController@delete_all_coa')->name('delete_all_coa');
Route::delete('delete_all_fgc', '\App\Http\Controllers\VendorController@delete_all_fgc')->name('delete_all_fgc');


/************************ End Multiple Delete  ***************/




/************************ Start Inspection  ***************/
Route::get('inspection/list', '\App\Http\Controllers\InspectionController@newlist')->middleware(['auth'])->name('inspection_list');
Route::post('/inspection/data', '\App\Http\Controllers\InspectionController@getInspectionData')->middleware(['auth'])->name('getInspectionData');




//Route::get('inspection/newlist', '\App\Http\Controllers\InspectionController@newlist')->middleware(['auth'])->name('newinspection_list');
Route::get('inspection/dashboard', '\App\Http\Controllers\InspectionController@dashboard')->middleware(['auth'])->name('inspection_dashboard');
Route::post('inspection_store', '\App\Http\Controllers\InspectionController@store')->name('inspection_store');
Route::post('inspection_edit', '\App\Http\Controllers\InspectionController@inspection_edit')->name('inspection_edit');
Route::get('inspection/delete/{id}', '\App\Http\Controllers\InspectionController@delete')->name('inspection_delete');
Route::post('deleteInspection', '\App\Http\Controllers\InspectionController@deleteInspection')->name('deleteInspection');
Route::get('exportdata', '\App\Http\Controllers\InspectionController@exportdata')->name('exportdata');
Route::post('inspectionsavestatus', '\App\Http\Controllers\InspectionController@inspectionsavestatus')->name('inspectionsavestatus');


Route::get('inspection/bulkupload', '\App\Http\Controllers\InspectionController@uploadData')->middleware(['auth'])->name('uploadData');
Route::get('inspection/editinspection/{id}', '\App\Http\Controllers\InspectionController@uploadData1')->middleware(['auth'])->name('uploadData1');
Route::post('inspection/postbulkupload', '\App\Http\Controllers\InspectionController@postbulkupload')->middleware(['auth'])->name('postbulkupload');
Route::post('inspection/bulkuploaddata', '\App\Http\Controllers\InspectionController@bulkuploaddata')->middleware(['auth'])->name('bulkuploaddata');
Route::post('inspection/followinspection', '\App\Http\Controllers\InspectionController@followinspection')->middleware(['auth'])->name('followinspection');

Route::post('inspection/postafterimage', '\App\Http\Controllers\InspectionController@postafterimage')->middleware(['auth'])->name('postafterimage');
Route::post('brakedown', '\App\Http\Controllers\InspectionController@brakedown')->middleware(['auth'])->name('brakedown');
Route::post('brakedownhistory', '\App\Http\Controllers\InspectionController@brakedownhistory')->middleware(['auth'])->name('brakedownhistory');
Route::post('updateBreakdownStatus', '\App\Http\Controllers\InspectionController@updateBreakdownStatus')->middleware(['auth'])->name('updateBreakdownStatus');
Route::post('inspection_compliant_history', '\App\Http\Controllers\InspectionController@inspection_compliant_history')->middleware(['auth'])->name('inspection_compliant_history');
Route::post('postprogress', '\App\Http\Controllers\InspectionController@postprogress')->middleware(['auth'])->name('postprogress');

Route::post('brakedownVerify', '\App\Http\Controllers\InspectionController@brakedownVerify')->middleware(['auth'])->name('brakedownVerify');
Route::post('inspection_progress_comments', '\App\Http\Controllers\InspectionController@inspection_progress_comments')->middleware(['auth'])->name('inspection_progress_comments');
Route::post('get_inspection_progress_comments', '\App\Http\Controllers\InspectionController@get_inspection_progress_comments')->middleware(['auth'])->name('get_inspection_progress_comments');


/************************ End Inspection  ***************/



/************************ Start Inspection  ***************/
Route::get('templates/list', '\App\Http\Controllers\TemplatesController@index')->middleware(['auth'])->name('templates_list');
Route::get('templates/delete/{id}', '\App\Http\Controllers\TemplatesController@template_delete')->name('template_delete');
Route::get('templates/details/{id}', '\App\Http\Controllers\TemplatesController@template_details')->name('template_details');
Route::get('templates/create', '\App\Http\Controllers\TemplatesController@store')->middleware(['auth'])->name('templates_store');
Route::get('templates/update/{id}', '\App\Http\Controllers\TemplatesController@updateTemplate')->middleware(['auth'])->name('templates_update');
Route::post('templates/updatevalue', '\App\Http\Controllers\TemplatesController@updatetemplatemeta')->middleware(['auth'])->name('templates_update_meta');
Route::post('templates/addquestion', '\App\Http\Controllers\TemplatesController@addquestion')->middleware(['auth'])->name('templates_addquestion');
Route::post('templates/updatequestion', '\App\Http\Controllers\TemplatesController@updatequestion')->middleware(['auth'])->name('templates_updatequestion');
Route::post('templates/addquestionsection', '\App\Http\Controllers\TemplatesController@addquestionsection')->middleware(['auth'])->name('templates_addquestionsection');
Route::post('templates/updatequestionsection', '\App\Http\Controllers\TemplatesController@updatequestionsection')->middleware(['auth'])->name('templates_updatequestionsection');


Route::post('templates/addpage', '\App\Http\Controllers\TemplatesController@addpage')->middleware(['auth'])->name('templates_addpage');
Route::post('templates/updatepage', '\App\Http\Controllers\TemplatesController@updatepage')->middleware(['auth'])->name('templates_updatepage');
Route::post('templates/upload-image', '\App\Http\Controllers\TemplatesController@uploadImage')->middleware(['auth'])->name('templates_uploadImage');

Route::get('templates/list/{type}', '\App\Http\Controllers\TemplatesController@templatelist')->middleware(['auth'])->name('templatetypelist');
Route::get('templates/create/{type}', '\App\Http\Controllers\TemplatesController@store1')->middleware(['auth'])->name('templates_store1');
Route::get('templates/update1/{id}/{type}', '\App\Http\Controllers\TemplatesController@updateTemplate1')->middleware(['auth'])->name('templates_update1');


Route::post('templates/add_multiple_choice', '\App\Http\Controllers\TemplatesController@add_multiple_choice')->middleware(['auth'])->name('template_add_multiple_choice');
Route::post('templates/edit_multiple_choice', '\App\Http\Controllers\TemplatesController@edit_multiple_choice')->middleware(['auth'])->name('edit_multiple_choice');
Route::post('templates/deletequestion', '\App\Http\Controllers\TemplatesController@deletequestion')->middleware(['auth'])->name('deletequestion');
Route::get('templates/duplicate/{id}', '\App\Http\Controllers\TemplatesController@duplicatequestion')->middleware(['auth'])->name('duplicatequestion');
/************************ End Inspection  ***************/


/************************ Start Vendor Managment  ***************/
Route::get('supplier-details', '\App\Http\Controllers\VendorController@index')->middleware(['auth'])->name('supplier_details');
Route::post('supplier-store', '\App\Http\Controllers\VendorController@store')->middleware(['auth'])->name('supplier_store');
Route::get('supplier/delete/{id}', '\App\Http\Controllers\VendorController@delete')->name('supplier_delete');
Route::get('supplier/edit', '\App\Http\Controllers\VendorController@edit_supplier')->name('edit_supplier');
Route::post('supplier-auditupload', '\App\Http\Controllers\VendorController@auditupload')->middleware(['auth'])->name('auditupload');

Route::get('product-category', '\App\Http\Controllers\VendorController@productCategory')->middleware(['auth'])->name('product_category');
Route::post('product-category-add', '\App\Http\Controllers\VendorController@productCategoryStore')->middleware(['auth'])->name('product_category_add');
Route::post('product-category-update', '\App\Http\Controllers\VendorController@productCategoryUpdate')->middleware(['auth'])->name('productCategoryUpdate');
Route::get('productcategorydelete/delete/{id}', '\App\Http\Controllers\VendorController@productcategorydelete')->name('productcategorydelete');



/************************ End Vendor Managment  ***************/


/************************ Start CoA Managment  ***************/
Route::get('coa', '\App\Http\Controllers\CoaController@index')->middleware(['auth'])->name('coa');
Route::get('fgc', '\App\Http\Controllers\CoaController@fgclist')->middleware(['auth'])->name('fgc');
Route::post('coa-store', '\App\Http\Controllers\CoaController@store')->middleware(['auth'])->name('supplier_coa');
Route::post('fgc-store', '\App\Http\Controllers\CoaController@storeFgc')->middleware(['auth'])->name('storeFgc');
Route::get('coa/delete/{id}', '\App\Http\Controllers\CoaController@delete')->name('coa_delete');
Route::get('fgc/delete/{id}', '\App\Http\Controllers\CoaController@delete1')->name('fgc_delete');
Route::get('coa/edit', '\App\Http\Controllers\CoaController@edit_supplier')->name('edit_supplier');
Route::post('coa-auditupload', '\App\Http\Controllers\CoaController@auditupload')->middleware(['auth'])->name('auditupload');
/************************ End CoA Managment  ***************/

/*prodparams categories route*/
Route::get('/prodparams', 'App\Http\Controllers\ProdparamsController@prodparams')->name('prodparams');
Route::get('/prodparams/{id}/edit', 'App\Http\Controllers\ProdparamsController@edit');
Route::get('/prodparams/{id}/delete', 'App\Http\Controllers\ProdparamsController@delete');
Route::get('/prodparams/status/{id}', 'App\Http\Controllers\ProdparamsController@changestatus');
Route::post('/prodparams/store', 'App\Http\Controllers\ProdparamsController@prodparamsstore')->name('prodparams_add');
Route::match(['GET', 'POST'],'/prodparams/import', 'App\Http\Controllers\ProdparamsController@import')->name('prodparamsimport');
Route::post('/prodparams/delete', 'App\Http\Controllers\ProdparamsController@prodparamsdelete')->name('prodparamsdelete');
Route::match(['GET', 'POST'],'/prodparams/import', 'App\Http\Controllers\ProdparamsController@import')->name('prodparamsimport');
Route::post('/prodparams/importfile', 'App\Http\Controllers\ProdparamsController@import1')->name('importfile');
Route::post('/prodparams/importfileuser', 'App\Http\Controllers\ProdparamsController@importfileuser')->name('importfileuser');
Route::post('/prodparams/importfile11', 'App\Http\Controllers\ProdparamsController@import11')->name('importfile11');
Route::post('/prodparams/importfile21', 'App\Http\Controllers\ProdparamsController@import21')->name('importfile21');
Route::get('/prodparams/add_prodparams', 'App\Http\Controllers\ProdparamsController@add_prodparams')->name('add_prodparams');
Route::get('/prodparams/edit_prodparams', 'App\Http\Controllers\ProdparamsController@edit_prodparams')->name('edit_prodparams');


// 6-march-2024
/************************ Start People  ***************/
Route::get('people/list', '\App\Http\Controllers\PeopleController@index')->middleware(['auth'])->name('people_list');
Route::get('people/dashboard', '\App\Http\Controllers\PeopleController@dashboard')->middleware(['auth'])->name('people_dashboard');
Route::post('people_store', '\App\Http\Controllers\PeopleController@store')->name('people_store');
Route::post('people_edit', '\App\Http\Controllers\PeopleController@people_edit')->name('people_edit');
Route::get('people/delete/{id}', '\App\Http\Controllers\PeopleController@delete')->name('people_delete');
Route::get('exportdata', '\App\Http\Controllers\PeopleController@exportdata')->name('exportdata');

/************************ End People  ***************/



/************************ Start Trainers  ***************/
Route::get('trainers/list', '\App\Http\Controllers\TrainersController@index')->middleware(['auth'])->name('trainers_list');
Route::get('trainers/training_data_index', '\App\Http\Controllers\TrainersController@training_data_index')->middleware(['auth'])->name('training_data_index');

Route::get('yield-raw-mat', '\App\Http\Controllers\TrainersController@yieldRawMat')->middleware(['auth'])->name('yield.raw.mat');
Route::post('save-yield-raw-material', '\App\Http\Controllers\TrainersController@saveYieldRawMaterial')->middleware(['auth'])->name('save.yield.raw.material');
Route::get('fetch-data-yield-rawMaterial', '\App\Http\Controllers\TrainersController@fetchDataYieldRawMaterial')->middleware(['auth'])->name('fetch.data.yield.rawMaterial');
Route::post('/save-yield-raw-material-data', '\App\Http\Controllers\TrainersController@saveYieldRawMaterialData')->name('save.yield.raw.material.data');
Route::post('/delete-yield-raw-material-variant', '\App\Http\Controllers\TrainersController@deleteYieldRawMaterialVariant')->name('delete.yield.raw.material.variant');
Route::post('/yield-raw-material-delete-storage', '\App\Http\Controllers\TrainersController@yieldRawMaterialDeleteStorage')->name('yield.raw.material.delete.storage');
Route::post('/save-storage-yield-raw-material', '\App\Http\Controllers\TrainersController@saveStorageYieldRawMaterial')->name('save.storage.yield.raw.material');




Route::get('trainers/training_dashboard', '\App\Http\Controllers\TrainersController@training_dashboard')->middleware(['auth'])->name('training_dashboard');
Route::get('trainers/competency_matrix', '\App\Http\Controllers\TrainersController@competency_matrix')->middleware(['auth'])->name('competency_matrix');
Route::get('trainers/staff_role_competency_mapping', '\App\Http\Controllers\TrainersController@staff_role_competency_mapping')->middleware(['auth'])->name('staff_role_competency_mapping');
Route::get('trainers/sqa', '\App\Http\Controllers\TrainersController@sqa')->middleware(['auth'])->name('sqa');
Route::get('supplier/raw', '\App\Http\Controllers\TrainersController@raw')->middleware(['auth'])->name('supplier.raw');
Route::get('supplier/raw-all', '\App\Http\Controllers\TrainersController@rawAll')->middleware(['auth'])->name('supplier.raw.all');
Route::get('sqa-suplier-list', '\App\Http\Controllers\TrainersController@sqaSuplierList')->middleware(['auth'])->name('sqa.suplier.list');


Route::post('/raw-material-product/store-manual', '\App\Http\Controllers\TrainersController@storeRawMaterialManual')->name('raw-material-product.storeManual');
Route::get('/fetch-data-frotend-raw-material', '\App\Http\Controllers\TrainersController@fetchDataFrotendRawMaterial')->name('fetch-data-frotend.rawMaterial');
Route::get('/fetch-data-frotend-all-raw-material', '\App\Http\Controllers\TrainersController@fetchDataFrotendAllRawMaterial')->name('fetch-data-frotend.allRawMaterial');
Route::post('/raw-material-product/storeSingleCsv',  '\App\Http\Controllers\TrainersController@storeRawMaterialSingleCsv')->name('raw-material-product.storeSingleCsv');
Route::post('/raw-material-product/storeMultipleCsv',  '\App\Http\Controllers\TrainersController@storeRawMaterialMultipleCsv')->name('raw-material-product.storeMultipleCsv');
Route::delete('/raw-material-product-delete/{id}', '\App\Http\Controllers\TrainersController@deleteRawMaterialProduct')->name('raw-material-product-delete');

Route::post('/add-sqa-new-supplier', '\App\Http\Controllers\TrainersController@addSqaNewSupplier')->name('add.sqa.new.supplier');
Route::delete('/sqa-new-supplier-delete/{id}', '\App\Http\Controllers\TrainersController@deleteSqaNewSupplier')->name('sqa-new-supplier-delete');

Route::post('/sqa-new-supplier-update/{id}', '\App\Http\Controllers\TrainersController@updateSqaNewSupplier')->name('sqa-new-supplier-update');
Route::post('/sqa-new-supplier-update/bulk-parse', '\App\Http\Controllers\TrainersController@uploadBulkSqaNewSuppliers')->name('sqa-new-supplier-update-bulk-parse');

// Route::get('/fetch-sqa-supplier-raw-material', '\App\Http\Controllers\TrainersController@fetchSqaSupplierRawMaterial')->name('fetch-sqa-supplier-raw-material');
Route::post('/delete-sqa-raw-material-vendor','\App\Http\Controllers\TrainersController@deleteSqaRawMaterialVendor')->name('delete-sqa-raw-material-vendor');

Route::post('/sqa-raw-material-save-vendor','\App\Http\Controllers\TrainersController@sqaRawMaterialSaveVendor')->name('sqa-raw-material-save-vendor');
Route::post('/sqa-raw-material-save-specification', '\App\Http\Controllers\TrainersController@sqaRawMaterialSaveSpecification')->name('sqa.raw-material.save-specification');
Route::get('sqa-suplier-image-upload', '\App\Http\Controllers\TrainersController@sqaSuplierImageUpload')->middleware(['auth'])->name('sqa.suplier.image-upload');

Route::get('/sqa-suplier-brand', '\App\Http\Controllers\TrainersController@sqaSuplierBrand')->middleware(['auth'])->name('sqa.suplier.brand');
Route::post('/sqa-brand-store', '\App\Http\Controllers\TrainersController@sqaBrandStore')->middleware(['auth'])->name('sqa.brand.store');

Route::post('/sqa-brand-import', '\App\Http\Controllers\TrainersController@sqaBrandImport')->middleware(['auth'])->name('sqa.brand.import');
Route::get('/get-sqa-brand-list', '\App\Http\Controllers\TrainersController@getBrandsList')->middleware(['auth'])->name('get.sqa.brand.list');

Route::post('/brand-single-approve', '\App\Http\Controllers\TrainersController@approveSingleBrand')->name('sqa.single.brand.approve');
Route::post('/brand-single-reject', '\App\Http\Controllers\TrainersController@rejectSingleBrand')->name('sqa.single.brand.reject');
Route::post('/brand-single-update', '\App\Http\Controllers\TrainersController@updateSingleBrand')->name('sqa.single.brand.update');
Route::get('/get-sqa-brand-list', '\App\Http\Controllers\TrainersController@getBrandsList')->middleware(['auth'])->name('get.sqa.brand.list');
Route::get('/sqa-single-brand-delete', '\App\Http\Controllers\TrainersController@deleteBrandsList')->middleware(['auth'])->name('sqa.single.brand.delete');


Route::post('/sqa-raw-material-add-variant', '\App\Http\Controllers\TrainersController@sqaRawMaterialAddVariant')->name('sqa.raw.material.add.variant');

Route::get('/sqa-raw-material-delete-variant', '\App\Http\Controllers\TrainersController@sqaRawMaterialDeleteVariant')->middleware(['auth'])->name('sqa.raw.material.delete.variant');

Route::get('/sqa-variation-status-update', '\App\Http\Controllers\TrainersController@sqaVariationStatusUpdate')->middleware(['auth'])->name('sqa.variation.status.update');


Route::post('/sqa-supplier-delete-contract', '\App\Http\Controllers\TrainersController@sqaSupplierDeleteContract')->middleware(['auth'])->name('sqa.supplier.delete.contract');


Route::post('/sqa-supplier-save-contract', '\App\Http\Controllers\TrainersController@sqaSupplierSaveContract')->middleware(['auth'])->name('sqa.supplier.save.contract');


Route::get('sqa-suplier-all-list', '\App\Http\Controllers\TrainersController@sqaAllSuplierList')->middleware(['auth'])->name('sqa.suplier.all.list');
Route::post('accept-reject-supplier-all', '\App\Http\Controllers\TrainersController@acceptRejectSupplierAll')->middleware(['auth'])->name('accept.reject.supplier.all');



//supplier add and view list
Route::get('supplier-add-and-view-list/{id}', '\App\Http\Controllers\TrainersController@supplierAddAndViewList')->middleware(['auth'])->name('supplier.add.and.view.list');

Route::get('get-all-raw-material-supplier-list', '\App\Http\Controllers\TrainersController@getAllRawMaterialSupplierList')->middleware(['auth'])->name('get.all.raw.material.supplier.list');
Route::post('add-vendor-raw-material', '\App\Http\Controllers\TrainersController@addVendorRawMaterial')->middleware(['auth'])->name('add.vendor.raw.material');

Route::post('copy-raw-material', '\App\Http\Controllers\TrainersController@copyRawMaterial')->middleware(['auth'])->name('copy.raw.material');



Route::post('/brandname/bulk-update-approve', '\App\Http\Controllers\TrainersController@bulkUpdateBrandApprove')->name('brands.bulk.update.approve');
Route::post('/brandname/bulk-update-reject', '\App\Http\Controllers\TrainersController@bulkUpdateBrandReject')->name('brands.bulk.update.reject');
Route::post('/brandname/bulk-delete', '\App\Http\Controllers\TrainersController@bulkUpdateBrandDelete')->name('brands.bulk.delete');


Route::post('trainers/training_data_edit', '\App\Http\Controllers\TrainersController@training_data_edit')->name('training_data_edit');
Route::post('trainers/training_status_update', '\App\Http\Controllers\TrainersController@training_status_update')->name('training_status_update');
Route::get('trainers/training_data_delete/{id}', '\App\Http\Controllers\TrainersController@training_data_delete')->name('training_data_delete');

Route::match(['get', 'post'], 'trainers/trainers_data_index', '\App\Http\Controllers\TrainersController@trainers_data_index')->middleware(['auth'])->name('trainers_data_index');
Route::post('trainers/trainers_add', '\App\Http\Controllers\TrainersController@trainers_add')->name('trainers_add');
Route::post('trainers/trainers_delete', '\App\Http\Controllers\TrainersController@trainers_delete')->name('trainers_delete');
Route::get('trainers/trainers_data_delete/{id}', '\App\Http\Controllers\TrainersController@trainers_data_delete')->name('trainers_data_delete');
Route::post('saveDocuments', '\App\Http\Controllers\TrainersController@saveDocuments')->middleware(['auth'])->name('saveDocuments');
Route::get('destorypepoleDocuments/{id}', '\App\Http\Controllers\TrainersController@destorypepoleDocuments')->name('destorypepoleDocuments');



/************************ End Trainers  ***************/


Route::match(['get', 'post'], 'trainers/employee_month_training_tracker', '\App\Http\Controllers\TrainersController@employee_month_training_tracker')->middleware(['auth'])->name('employee_month_training_tracker');
Route::match(['get', 'post'], 'trainers/employee_topic_training_tracker', '\App\Http\Controllers\TrainersController@employee_topic_training_tracker')->middleware(['auth'])->name('employee_topic_training_tracker');

Route::match(['get', 'post'], 'trainers/training_calendra_index', '\App\Http\Controllers\TrainersController@training_calendra_index')->middleware(['auth'])->name('training_calendra_index');
Route::get('trainers_card/{topic_id}/{user_id}', '\App\Http\Controllers\TrainersController@trainers_card')->name('trainers_card');
Route::get('trainers_cards/{user_id}', '\App\Http\Controllers\TrainersController@trainers_cards')->name('trainers_cards');


Route::post('department/user_status_update', '\App\Http\Controllers\DepartmentController@user_status_update')->name('user_status_update');

/*Enroll Participants route Add*/
		
		Route::get('/enrollparticipantslist/lmslist', 'App\Http\Controllers\EnrollParticipantsController@lmslist')->name('lmslist');
	Route::get('/lmslist/users/{id}', 'App\Http\Controllers\EnrollParticipantsController@lmsviewlist')->name('lmsviewlist');
		Route::post('addlms', 'App\Http\Controllers\EnrollParticipantsController@store_lms')->name('addlms');
		Route::get('/add_lms_enrolled', 'App\Http\Controllers\EnrollParticipantsController@add_lms_enrolled')->name('add_lms_enrolled');
		Route::post('/store_lms_enrolled', 'App\Http\Controllers\EnrollParticipantsController@store_lms_enrolled')->name('store_lms_enrolled');
		Route::post('/enrollparticipants/add_lms_store_user', 'App\Http\Controllers\EnrollParticipantsController@add_lms_store_user')->name('add_lms_store_user');
		Route::get('/enrollparticipants/deletemember_lms1/{id}', 'App\Http\Controllers\EnrollParticipantsController@deletemember_lms1')->name('deletemember_lms1');
		Route::post('/enrollparticipantslist/lms/edit_lms_user', 'App\Http\Controllers\EnrollParticipantsController@edit_lms_user')->name('edit_lms_user');
		Route::post('/enrollparticipantslist/lms/edit_lms_video_status', 'App\Http\Controllers\EnrollParticipantsController@edit_lms_video_status')->name('edit_lms_video_status');
		Route::get('/enrollparticipants/getusermobile/{id}', 'App\Http\Controllers\EnrollParticipantsController@getusermobile')->name('getusermobile');
		Route::get('/enrollparticipants/getusernamebynumber/{id}', 'App\Http\Controllers\EnrollParticipantsController@getusernamebynumber')->name('getusernamebynumber');
		Route::get('/enrollparticipants/add_enrolled_store1/{id}', 'App\Http\Controllers\EnrollParticipantsController@add_enrolled_store1')->name('add_enrolled_store1');
		Route::get('/enrollparticipants/add_enrolled_store2/{id}', 'App\Http\Controllers\EnrollParticipantsController@add_enrolled_store2')->name('add_enrolled_store2');
        Route::post('/enrollparticipants/deletemember_lms', 'App\Http\Controllers\EnrollParticipantsController@deletemember_lms')->name('deletemember_lms');
        Route::post('add_enrollunit_user', '\App\Http\Controllers\EnrollParticipantsController@add_unit_user')->name('add_enrollunit_user');
        Route::post('lms-certificateupload', '\App\Http\Controllers\EnrollParticipantsController@lmscertificateupload')->middleware(['auth'])->name('lmscertificateupload');
        Route::get('destorycertificatDocuments/{id}', '\App\Http\Controllers\EnrollParticipantsController@destorycertificatDocuments')->name('destorycertificatDocuments');
        Route::get('editcertificatDocuments/{id}', '\App\Http\Controllers\EnrollParticipantsController@editcertificatDocuments')->name('editcertificatDocuments');
        Route::get('delete_lms/{id}', '\App\Http\Controllers\EnrollParticipantsController@delete_lms')->name('delete_lms');
        Route::post('search_enrollstudent', '\App\Http\Controllers\EnrollParticipantsController@search_enrollstudent')->name('search_enrollstudent');
        



// Route::post('/course-datatatat', function (Request $request) {
//     return response()->json(['message' => 'Route hit successfully']);
// })->withoutMiddleware(['auth']);
Route::post('/add-course-new', [AddNewCourseController::class, 'addNewCourseDetails'])->withoutMiddleware(['auth']);


/*End Enroll Participants route Add*/




//frontend
Route::group(['prefix' => 'student-dashboard'], function () {

    Route::group(['prefix' => 'courses-bundles'], function () {
      Route::get('/', [CoursesBundleController::class, 'index']);
      Route::get('/show', [CoursesBundleController::class, 'show']);
    });

    Route::group(['prefix' => 'my-courses'], function () {
        Route::get('/', [MyCoursesController::class, 'index']);
      });

    Route::group(['prefix' => 'training-course'], function () {
        Route::get('/', [TrainingCourseController::class, 'index']);
    });

    Route::group(['prefix' => 'complete-solution'], function () {
        Route::get('/', [CompleteSolutionController::class, 'index']);
    });
});


//admin
Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'course-manage'], function () {
        Route::get('/', [CourseManageController::class, 'list']);
        Route::get('/index/{id}', [CourseManageController::class, 'index']);
        Route::get('/edit-course/{id}', [CourseManageController::class, 'editCourse']);
        Route::post('/add-section', [CourseManageController::class, 'addSection']);
        Route::post('/add-lesson', [CourseManageController::class, 'addLesson']);
        Route::post('/add-quiz', [CourseManageController::class, 'addQuiz']);
        Route::get('/delete-lesson/{id}', [CourseManageController::class, 'deleteLesson']);
        Route::post('/add-resource-file', [CourseManageController::class, 'addResourceFile']);
        Route::get('/delete-resource-file/{id}', [CourseManageController::class, 'deleteResourceFile']);
        Route::post('/update-resource-file', [CourseManageController::class, 'updateResourceFile']);
        Route::get('/download-resource-file/{id}', [CourseManageController::class, 'downloadResourceFile']);
        Route::get('/delete-quiz/{id}', [CourseManageController::class, 'deleteQuiz']);
        Route::post('/update-quiz', [CourseManageController::class, 'updateQuiz']);
        Route::get('/delete-section/{id}', [CourseManageController::class, 'deleteSection']);
        Route::post('/update-session', [CourseManageController::class, 'updateSection']);
        Route::post('/add-quiz-question', [CourseManageController::class, 'addQuizQuestion']);
        Route::get('/delete-quiz-question/{id}', [CourseManageController::class, 'deleteQuizQuestion']);
        Route::post('/update-quiz-question', [CourseManageController::class, 'updateQuizQuestion']);
        Route::post('/update-quiz-question-order', [CourseManageController::class, 'updateQuizQuestionOrder']);
        Route::post('/update-lesson-order', [CourseManageController::class, 'updateLessonOrder']);
        Route::post('/update-section-order', [CourseManageController::class, 'updateSectionOrder']);
        Route::post('/seo-settings', [CourseManageController::class, 'updateSeoByCourseId']);
        Route::post('/add-google-meet-live-class', [CourseManageController::class, 'addGoogleMeetLiveClass']);
        Route::post('/add-jitsi-live-class', [CourseManageController::class, 'addJitsiLiveClass']);
        Route::post('/add-assignment', [CourseManageController::class, 'addAssignment']);
        Route::get('/delete-assignment/{id}', [CourseManageController::class, 'deleteAssignment']);
        Route::get('/download-assignment-question-file/{id}', [CourseManageController::class, 'downloadAssignmentQuestionFile']);
        Route::post('/update-assignment', [CourseManageController::class, 'updateAssignment']);
        Route::post('/add-new-notice', [CourseManageController::class, 'addNewNotice']);
        Route::get('/delete-notice/{id}', [CourseManageController::class, 'deleteNotice']);
        Route::post('/update-notice', [CourseManageController::class, 'updateNotice']);
        Route::post('/add-faqs', [CourseManageController::class, 'addFaqs']);
        Route::post('/add-requirements', [CourseManageController::class, 'addRequirements']);
        Route::post('/add-outcomes', [CourseManageController::class, 'addOutcomes']);
        Route::get('/delete-faq/{id}', [CourseManageController::class, 'deleteFaq']);
        Route::post('/update-faq', [CourseManageController::class, 'updateFaq']);
        Route::post('/update-requirement', [CourseManageController::class, 'updateRequirements']);
        Route::get('/delete-requirement/{id}', [CourseManageController::class, 'deleteRequirement']);
        Route::post('/update-outcome', [CourseManageController::class, 'updateOutcomes']);
        Route::get('/delete-outcome/{id}', [CourseManageController::class, 'deleteOutcome']);
        Route::post('/course-pricing', [CourseManageController::class, 'coursePricing']);
        Route::post('/course_media', [CourseManageController::class, 'courseMedia']);
        Route::get('/download-caption-file/{id}', [CourseManageController::class, 'downloadCaptionFile']);
        Route::post('/update-lesson', [CourseManageController::class, 'updateLesson']);
        Route::post('/update-course', [CourseManageController::class, 'updataCourse']);
    });

    Route::group(['prefix' => 'add-new-course'], function () {
        Route::get('/', [AddNewCourseController::class, 'index']);
        // Route::post('/add-course-details', [AddNewCourseController::class, 'addCourseDetails'])->name('poppp');
    });

    Route::group(['prefix' => 'add-new-category'], function () {
        Route::get('/', [AddNewCategoryController::class, 'index']);
        Route::get('/category-add', [AddNewCategoryController::class, 'addNewCategoryPage']);
        Route::post('/add-new-category-subcategory', [AddNewCategoryController::class, 'addNewCategorySubcategory']);
        Route::get('/delete-main-category/{id}', [AddNewCategoryController::class, 'deleteMainCategory']);
        Route::get('/delete-sub-category/{id}', [AddNewCategoryController::class, 'deleteSubCategory']);
        Route::get('/edit-main-category/{id}', [AddNewCategoryController::class, 'editMainCategoryPage']);
        Route::get('/edit-sub-category/{id}', [AddNewCategoryController::class, 'editSubCategoryPage']);
        Route::post('/update-main-category/{id}', [AddNewCategoryController::class, 'updateMainCategory']);
        Route::post('/update-sub-category/{id}', [AddNewCategoryController::class, 'updateSubCategory']);
    });

    Route::group(['prefix'=>'add-new-coupon'],function(){
        Route::get('/', [AddNewCouponController::class, 'index']);
        Route::get('/add-page', [AddNewCouponController::class, 'addCouponPage']);
        Route::post('/add-coupon', [AddNewCouponController::class, 'addCoupon']);
        Route::get('/delete-coupon/{id}', [AddNewCouponController::class, 'deleteCoupon']);
        Route::get('/edit-coupon/{id}', [AddNewCouponController::class, 'editCoupon']);
        Route::post('/update-coupon/{id}', [AddNewCouponController::class, 'updateCoupon']);
    });
    

    Route::group(['prefix'=>'create-template'],function(){
     Route::get('/',[CreateTemplateController::class,'index']);
    });
});

