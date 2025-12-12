<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Product Specification Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">


    <!-- Scripts for Specification Generator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <style>
       /* Force Toastr background colors */
        .toast-success {
            background-color: #51A351 !important;
            color: #fff !important;
        }
        .toast-error {
            background-color: #BD362F !important;
            color: #fff !important;
        }
        .toast-warning {
            background-color: #F89406 !important;
            color: #fff !important;
        }
        .toast-info {
            background-color: #2F96B4 !important;
            color: #fff !important;
        }

        /* --- Dashboard Styles --- */
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --info-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .dashboard-container {
            margin: 0 auto;
            background-color: white;
            box-shadow: var(--box-shadow);
            overflow: hidden;
            min-height: 100vh;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            border-bottom: 1px solid #e9ecef;
            flex-wrap: wrap;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-title i {
            color: var(--primary-color);
        }
        
        .mobile-header-buttons {
            display: none;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary { background-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: var(--secondary-color); transform: translateY(-2px); }
        .btn-secondary { background-color: var(--gray-color); color: white; }
        .btn-secondary:hover { background-color: #5a6268; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-success { background-color: var(--success-color); color: white; }
        .btn-warning { background-color: var(--warning-color); color: white; }
        .btn-info { background-color: var(--info-color); color: white; }
        .btn-danger { background-color: var(--danger-color); color: white; }
        
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; vertical-align: top; word-wrap: break-word; }
        th { background-color: #f8f9fa; font-weight: 600; color: var(--dark-color); position: sticky; top: 0; z-index: 10; vertical-align: middle; }
        .th-content { display: flex; justify-content: space-between; align-items: center; }
        .th-filter-icon { color: var(--gray-color); cursor: pointer; font-size: 0.8em; margin-left: 8px; transition: var(--transition); }
        .th-filter-icon:hover, .th-filter-icon.filter-active { color: var(--primary-color); }
        tr:hover { background-color: #f8f9fa; }
        .not-specified { color: var(--gray-color); font-style: italic; }
        .material-tag { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px; background-color: #e9ecef; margin: 2px; font-size: 12px; color: var(--dark-color); }
        .material-tag.not-specified { background-color: transparent; color: var(--gray-color); }
        .edit-material-btn { background: none; border: none; cursor: pointer; color: var(--primary-color); font-size: 14px; transition: var(--transition); }
        .edit-material-btn:hover { color: var(--secondary-color); transform: scale(1.1); }
        
        .action-buttons, .spec-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .last-updated { font-size: 12px; color: var(--gray-color); margin-top: 8px; }
        .spec-buttons .last-updated { width: 100%; margin-top: 4px; }
        
        /* --- Modal Styles (Dashboard) --- */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; animation: fadeIn 0.3s ease; }
        .modal-content { background-color: white; padding: 25px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); width: 90%; max-width: 600px; max-height: 90vh; display: flex; flex-direction: column; }
        .modal-content.small { max-width: 450px; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef; }
        .modal-title { font-size: 20px; font-weight: 600; color: var(--dark-color); display: flex; align-items: center; gap: 10px; }
        .close-modal { background: none; border: none; font-size: 24px; cursor: pointer; color: var(--gray-color); }
        .modal-body { flex-grow: 1; overflow-y: auto; margin-bottom: 20px; }
        .modal-body textarea { width: 100%; min-height: 100px; padding: 10px; border: 1px solid #ced4da; border-radius: var(--border-radius); font-family: inherit; resize: vertical; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding-top: 15px; border-top: 1px solid #e9ecef; }
        
        /* CSV Upload Styles */
        .csv-upload-area { display: flex; flex-direction: column; align-items: center; padding: 30px; border: 2px dashed #adb5bd; border-radius: var(--border-radius); background-color: #f8f9fa; text-align: center; transition: var(--transition); }
        .csv-upload-area.drag-over { border-color: var(--primary-color); background-color: rgba(67, 97, 238, 0.05); }
        .csv-upload-icon { font-size: 48px; color: var(--primary-color); margin-bottom: 15px; }
        .csv-upload-area p { color: var(--gray-color); margin-bottom: 15px; }
        .csv-file-input { display: none; }
        .csv-selected-file { margin-top: 15px; font-size: 14px; color: var(--success-color); display: flex; align-items: center; gap: 8px; }
        .csv-upload-status { margin-top: 15px; padding: 12px; border-radius: var(--border-radius); font-size: 14px; display: none; width: 100%; text-align: center; }
        .csv-upload-status.success { background-color: rgba(76, 201, 240, 0.2); color: #155724; display: block; border: 1px solid rgba(76, 201, 240, 0.5); }
        .csv-upload-status.error { background-color: rgba(247, 37, 133, 0.1); color: #721c24; display: block; border: 1px solid rgba(247, 37, 133, 0.3); }
        
        /* Status Cell styles */
        .status-cell-content { display: flex; flex-direction: column; gap: 8px; }
        .status-main { display: flex; align-items: center; gap: 10px; }
        .status-text { font-weight: 500; font-size: 14px; }
        .status-text.active { color: #28a745; }
        .status-text.inactive { color: var(--gray-color); }
        .status-details { font-size: 12px; color: var(--gray-color); padding-left: 5px; border-left: 2px solid #e9ecef; line-height: 1.4; }
        .status-details.hidden { display: none; }
        .status-toggle { position: relative; display: inline-block; width: 50px; height: 26px; flex-shrink: 0; }
        .status-toggle input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--gray-color); transition: .4s; border-radius: 26px; }
        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #28a745; }
        input:checked + .slider:before { transform: translateX(24px); }
        
        /* Top Toolbar Styles */
        .top-toolbar { padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; border-bottom: 1px solid #e9ecef; }
        .toolbar-group-left, .toolbar-group-right { display: flex; gap: 10px; align-items: center; }
        
        /* Bulk Actions */
        .bulk-actions { background-color: #e9ecef; padding: 10px 20px; display: none; align-items: center; justify-content: space-between; margin: 20px; border-radius: var(--border-radius); }
        .bulk-actions.show { display: flex; }
        .bulk-selection-count { font-weight: 500; }
        .bulk-action-buttons { display: flex; gap: 10px; }
        
        /* Undo Notification */
        .undo-notification { position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background-color: var(--dark-color); color: white; padding: 12px 24px; border-radius: var(--border-radius); display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; opacity: 0; transition: opacity 0.3s ease; }
        .undo-notification.show { opacity: 1; }
        .undo-btn { background-color: var(--primary-color); color: white; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-weight: 500; }
        
        /* Filter Popups */
        .filter-popup { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1010; background-color: white; border-radius: var(--border-radius); box-shadow: 0 8px 16px rgba(0,0,0,0.15); width: 90%; max-width: 320px; display: none; flex-direction: column; }
        .filter-popup-header { padding: 12px 15px; border-bottom: 1px solid #e9ecef; font-weight: 600; }
        .filter-popup-body { padding: 10px; display: flex; flex-direction: column; }
        .filter-popup-search { width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; margin-bottom: 10px; }
        .filter-popup-checklist { max-height: 200px; overflow-y: auto; display: flex; flex-direction: column; gap: 5px; padding: 5px; }
        .filter-popup-checklist label { display: flex; align-items: center; gap: 8px; padding: 5px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .filter-popup-checklist label:hover { background-color: #f8f9fa; }
        .filter-popup-footer { padding: 10px 15px; border-top: 1px solid #e9ecef; display: flex; justify-content: space-between; }
        
        /* Editable row styles */
        .editable-row { background-color: #f0f7ff !important; }
        .editable-row td { position: relative; }
        .editable-row input, .editable-row select, .material-edit-container input { width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; }
        .editable-row input:disabled { background-color: #e9ecef; cursor: not-allowed; color: #6c757d; }
        
        /* Searchable dropdown styles */
        .searchable-dropdown { position: relative; width: 100%; }
        .searchable-dropdown input { width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; font-family: inherit; }
        .dropdown-options { position: absolute; top: 100%; left: 0; right: 0; max-height: 200px; overflow-y: auto; background: white; border: 1px solid #ced4da; border-top: none; border-radius: 0 0 4px 4px; z-index: 100; display: none; }
        .dropdown-options.show { display: block; }

        /* Material Modal */
        .material-search-input { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: var(--border-radius); margin-bottom: 15px; }
        .material-list { list-style: none; padding: 0; margin: 0; max-height: 300px; overflow-y: auto; }
        
        /* Fade animations */
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
        
        /* --- Specification Generator Modal & Content Styles --- */
        .spec-generator-modal .modal-content { max-width: 95vw; width: 95vw; height: 95vh; max-height: 95vh; }
        .spec-generator-modal .modal-body { padding-right: 15px; }
        .spec-generator-content { font-family: 'Inter', sans-serif; color: #333; }
        .spec-generator-content h1 { color: #283593; text-align: center; margin-bottom: 30px; font-weight: 600; font-size: 1.8em; }
        .spec-generator-content h2 { color: #283593; margin: 25px 0 15px; font-weight: 500; border-bottom: 2px solid #8e99f3; padding-bottom: 5px; }
        .spec-generator-content h3.content-block-title { color: #5c6bc0; margin: 15px 0 10px; font-weight: 500; font-size: 1.1em; display: flex; align-items: center; padding: 5px 0; }
        .spec-generator-content .content-block-title > .title-text-span { flex-grow: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .spec-generator-content .content-block-drag-handle { cursor: grab; margin-right: 8px; color: #5c6bc0; user-select: none; font-size: 1.2em; line-height: 1; }
        .spec-generator-content .form-group { margin-bottom: 20px; }
        .spec-generator-content label { display: block; margin-bottom: 8px; font-weight: 500; color: #333; }
        .spec-generator-content .required-field::after { content: " *"; color: #f44336; }
        .spec-generator-content input, .spec-generator-content select, .spec-generator-content textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; font-size: 16px; transition: border-color 0.3s; }
        .spec-generator-content .table-remarks-textarea { margin-top: 5px; }
        .spec-generator-content input:focus, .spec-generator-content select:focus, .spec-generator-content textarea:focus { border-color: #5c6bc0; outline: none; box-shadow: 0 0 0 2px rgba(92, 107, 192, 0.2); }
        .spec-generator-content .radio-group { display: flex; gap: 15px; margin-top: 10px; flex-wrap: wrap; }
        .spec-generator-content .btn { display: inline-block; background-color: #283593; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: 500; text-align: center; transition: background-color 0.3s, transform 0.2s; }
        .spec-generator-content .btn:hover { background-color: #5c6bc0; transform: translateY(-2px); }
        .spec-generator-content .btn-secondary { background-color: #757575; } .spec-generator-content .btn-secondary:hover { background-color: #616161; }
        .spec-generator-content .btn-success { background-color: #4caf50; } .spec-generator-content .btn-success:hover { background-color: #43a047; }
        .spec-generator-content .btn-danger { background-color: #f44336; } .spec-generator-content .btn-danger:hover { background-color: #e53935; }
        .spec-generator-content .btn-info { background-color: #2196F3; } .spec-generator-content .btn-info:hover { background-color: #1976D2; }
        .spec-generator-content .btn-small { padding: 8px 16px; font-size: 14px; }
        .spec-generator-content .btn-xs { padding: 3px 6px; font-size: 12px; line-height: 1.2; }
        .spec-generator-content .action-buttons { display: flex; justify-content: space-between; margin-top: 30px; flex-wrap: wrap; gap: 10px; }
        .spec-generator-content table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 15px; table-layout: fixed; }
        .spec-generator-content th, .spec-generator-content td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; word-wrap: break-word; }
        .spec-generator-content th { background-color: #f5f5f5; font-weight: 600; color: #283593; }
        .spec-generator-content .basic-info-grid-container { display: grid; grid-template-columns: repeat(3, 1fr); column-gap: 20px; }
        .spec-generator-content .basic-info-grid-container .grid-span-3 { grid-column: 1 / -1; }
        .spec-generator-content [contenteditable="true"]:not(.tox-edit-area__iframe):focus { outline: 1px solid #5c6bc0; background-color: #fff; }

        /* --- Responsive Adjustments --- */
        @media (max-width: 992px) {
            .top-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .toolbar-group-right {
                justify-content: flex-end;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .header {
                position: sticky;
                top: 0;
                z-index: 100;
                flex-shrink: 0;
            }
            
            .table-area-wrapper {
                flex-grow: 1;
                overflow-y: auto;
                padding: 15px;
            }

            .bulk-actions {
                position: sticky;
                top: 0;
                z-index: 20;
                margin: -15px -15px 15px -15px; /* Adjust margin for sticky position */
                width: calc(100% + 30px);
                border-radius: 0;
            }

            .page-title {
                font-size: 22px;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .mobile-header-buttons {
                display: flex;
                gap: 10px;
                width: 100%;
                justify-content: flex-end;
            }

            .top-toolbar {
                display: none;
            }

            .bulk-actions {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            .bulk-action-buttons {
                width: 100%;
                justify-content: flex-end;
            }

            #productTable thead {
                display: none;
            }

            #productTable, #productTable tbody, #productTable tr, #productTable td {
                display: block;
            }

            #productTable tr {
                border: 1px solid #ddd;
                border-radius: var(--border-radius);
                margin-bottom: 15px;
                padding: 10px;
                background: white;
            }
            
            #productTable td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 5px;
                text-align: right;
                border-bottom: 1px solid #e9ecef;
            }

            #productTable td:last-child {
                border-bottom: none;
            }

            #productTable td::before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                padding-right: 15px;
                color: var(--dark-color);
                flex-shrink: 0;
            }
            
            #productTable td .material-display,
            #productTable td .status-cell-content {
                flex-basis: 60%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }
            
            #productTable td[data-label="Select"],
            #productTable td[data-label="#"],
            #productTable td[data-label="Actions"],
            #productTable td[data-label="Status"] {
                display: none;
            }

            #productTable .spec-buttons {
                flex-direction: column;
                width: 100%;
            }

            #productTable .spec-buttons-inline-group {
                display: flex;
                gap: 8px;
                width: 100%;
            }
            #productTable .spec-buttons-inline-group .btn {
                flex-grow: 1;
            }

            #productTable td[data-label="Specification"] .spec-edit-btn,
            #productTable td[data-label="Specification"] .btn-warning {
                display: none;
            }

            .spec-generator-content h1 { font-size: 1.4em; }
            .spec-generator-content .basic-info-grid-container {
                grid-template-columns: 1fr;
            }
            
            .spec-generator-content .action-buttons {
                flex-direction: column;
            }
    
            .spec-generator-content .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <!--<div class="page-wrapper">-->
        
 <!--<div style="padding-top:30px;background-color:white">-->
 <!--   <div class="container-fluid">-->
 <!--       <div class="">-->
 <!--           <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">-->
 <!--               <li class="nav-item" role="presentation"  style="margin:5px;">-->
 <!--                   <a class="nav-link" data-bs-toggle="pill" href="{{route('supplier_details')}}" role="tab"-->
 <!--                       aria-selected="false">-->
 <!--                       <div class="d-flex align-items-center">-->
 <!--                           <div class="tab-title">Supplier Details</div>-->
 <!--                       </div>-->
 <!--                   </a>-->

 <!--               </li>-->

 <!--               <li class="nav-item " role="presentation" style="margin:5px;">-->
 <!--                   <a class="nav-link" href="{{route('coa')}}">-->
 <!--                       <div class="d-flex align-items-center">-->
 <!--                           <div class="tab-title">COA</div>-->
 <!--                       </div>-->
 <!--                   </a>-->

 <!--               </li>-->

 <!--               <li class="nav-item " role="presentation" style="margin:5px;">-->
 <!--                   <a class="nav-link" href="{{route('fgc')}}">-->
 <!--                       <div class="d-flex align-items-center">-->
 <!--                           <div class="tab-title">FGC</div>-->
 <!--                       </div>-->
 <!--                   </a>-->

 <!--               </li>-->

 <!--               <li class="nav-item " role="presentation" style="margin:5px;">-->
 <!--                   <a class="nav-link" href="{{route('product_category')}}">-->
 <!--                       <div class="d-flex align-items-center">-->
 <!--                           <div class="tab-title">Product Category </div>-->
 <!--                       </div>-->
 <!--                   </a>-->

 <!--               </li>-->

 <!--               <li class="nav-item" role="presentation" style="margin:5px;color: #fff;background-color: #17a00e;">-->
 <!--                   <a class="nav-link" href="{{route('supplier_vendor_manage')}}">-->
 <!--                       <div class="d-flex align-items-center">-->
 <!--                           <div class="tab-title">Supplier </div>-->
 <!--                       </div>-->
 <!--                   </a>-->

 <!--               </li>-->
 <!--           </ul>-->
 <!--       </div>-->
 <!--   </div>-->
    
    <div class="dashboard-container">
        <div class="header">
            <div class="page-title">
                <i class="fas fa-list-alt"></i>
                Product Specification Dashboard
            </div>
            <div class="mobile-header-buttons">
                 <button class="btn btn-primary btn-sm" id="mobileFilterBtn">
                    <i class="fas fa-filter"></i> Filters
                </button>
                 <button class="btn btn-secondary btn-sm" id="mobileResetFiltersBtn">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>
        </div>
        
        <div class="top-toolbar">
            <div class="toolbar-group-left">
                <button id="csvSampleBtn" class="btn btn-secondary" style="background-color: #6c757d;color: white">
                    <i class="fas fa-download"></i> Sample CSV
                </button>
                <button id="openCsvModalBtn" class="btn btn-secondary" style="background-color: #6c757d;color: white">
                    <i class="fas fa-file-import"></i> Bulk Import Categories
                </button>
                <button id="addProductBtn" class="btn btn-primary" style="background-color: #4361ee;color: white;">
                    <i class="fas fa-plus"></i> Add New Product
                </button>
            </div>
             <div class="toolbar-group-right">
                <button class="btn btn-secondary" id="resetFilters" style="background-color: #6c757d;color: white">
                    <i class="fas fa-undo"></i> Reset All Filters
                </button>
            </div>
        </div>
        
        <div class="table-area-wrapper">
            <div class="bulk-actions" id="bulkActions">
                <div class="bulk-selection-count" id="bulkSelectionCount">
                    0 products selected
                </div>
                <div class="bulk-action-buttons">
                    <button class="btn btn-success btn-sm" id="bulkEditBtn">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" id="bulkDeleteBtn">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button class="btn btn-secondary btn-sm" id="bulkDeselectBtn">
                        <i class="fas fa-times"></i> Deselect All
                    </button>
                </div>
            </div>
            
            <table id="productTable">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" id="selectAllCheckbox"></th>
                        <th style="width: 50px;"><div class="th-content">#</div></th>
                        <th><div class="th-content"><span>Product Category</span><i class="fas fa-filter th-filter-icon"></i></div></th>
                        <th><div class="th-content"><span>Sub Category</span><i class="fas fa-filter th-filter-icon"></i></div></th>
                        <th><div class="th-content"><span>Specific Subcategory</span><i class="fas fa-filter th-filter-icon"></i></div></th>
                        <th><div class="th-content"><span>Material</span><i class="fas fa-filter th-filter-icon"></i></div></th>
                        <th style="width: 110px;"><div class="th-content">Actions</div></th>
                        <th><div class="th-content"><span>Specification</span><i class="fas fa-filter th-filter-icon"></i></div></th>
                        <th style="width: 170px;"><div class="th-content"><span>Status</span><i class="fas fa-filter th-filter-icon"></i></div></th>
                    </tr>
                </thead>
                <tbody>
                    @if($suppliers)
                    @foreach($suppliers as $supplier)
                    <tr data-supplier-id="{{ $supplier->supplier_id }}">
                        <td data-label="Select"><input type="checkbox" class="row-checkbox"></td>
                        <td data-label="#">{{$loop->index+1}}</td>
                        <td data-label="Product Category">{{$supplier->category}}</td>
                        <td data-label="Sub Category">{{$supplier->sub_category}}</td>
                        <td data-label="Specific Subcategory">{{$supplier->specific_sub}}</td>
                        <td data-label="Material">
                            <div class="material-display">
                                <span class="material-tag">Plastic</span>
                                <span class="material-tag">Glass</span>
                                <button class="edit-material-btn" title="Edit materials"><i class="fas fa-edit"></i></button>
                            </div>
                        </td>
                        <td data-label="Actions">
                            <!--<div class="action-buttons">-->
                            <!--    <button class="btn btn-success edit-btn" title="Edit"  style="padding: 19px 8px;font-size: 13px;background-color: #4cc9f0;color: white;"   @if($supplier->created_by != Auth::id()) disabled @endif><i class="fas fa-edit"></i></button>-->
                            <!--    <button class="btn btn-danger delete-btn" style="padding: 19px 8px;font-size: 13px;background-color: #f72585;color: white;" title="Delete"   @if($supplier->created_by != Auth::id()) disabled @endif><i class="fas fa-trash"></i></button>-->
                            <!--</div>-->
                            <div class="action-buttons">
                                <button 
                                    class="btn btn-success edit-btn" 
                                    title="Edit"
                                    style="padding: 19px 8px; font-size: 13px; background-color: #4cc9f0; color: white; position: relative;" 
                                    @if($supplier->created_by != Auth::id()) disabled @endif>
                                    
                                    <i class="fas fa-edit"></i>
                            
                                    @if($supplier->created_by != Auth::id())
                                        <span style="position: absolute; top: 2px; right: 4px; font-size: 14px; color: red;">&#10060;</span>
                                    @endif
                                </button>
                            
                                <button 
                                    class="btn btn-danger delete-btn" 
                                    title="Delete"
                                    style="padding: 19px 8px; font-size: 13px; background-color: #f72585; color: white; position: relative;" 
                                    @if($supplier->created_by != Auth::id()) disabled @endif>
                                    
                                    <i class="fas fa-trash"></i>
                            
                                    @if($supplier->created_by != Auth::id())
                                        <span style="position: absolute; top: 2px; right: 4px; font-size: 14px; color: red;">&#10060;</span>
                                    @endif
                                </button>
                            </div>

                        </td>
                        <td data-label="Specification">
                             @php 
                              $spec_data = DB::table('new_supplier_product_specialisation_uploads')->where('new_supplier_id', $supplier->supplier_id)->first();
                            @endphp 
                            <div class="spec-buttons">
                                <button class="btn btn-success spec-edit-btn" style="padding: 6px 12px;font-size: 13px;background-color: #4cc9f0;color: white;"><i class="fas fa-edit"></i> Upload</button>
                                
                                <button class="btn btn-warning" style="padding: 6px 12px;font-size: 13px;background-color: #f8961e;color: white;"><i class="fas fa-file-alt"></i> Draft</button>
                                <div class="spec-buttons-inline-group">
                                    <!--<button class="btn btn-primary spec-view-btn" title="View Specification"  style="padding: 6px 12px;font-size: 13px;background-color: #4361ee;color: white;"><i class="fas fa-eye"></i> View</button>-->
                                  @if($spec_data)
                                    <a href="{{config('app.url').'/inspection'}}/{{$spec_data->file ?? ''}}" target="_blank"> <button class="btn btn-info" style="padding: 6px 12px;font-size: 13px;background-color: #4895ef;color: white;margin-top:5px"><i class="fas fa-download"></i> Download</button></a>
                                   
                                   @endif
                                </div> 
                                <div class="last-updated">
                                    Last updated: 
                                    <span class="update-time">
                                        {{ $spec_data?->updated_at ? \Carbon\Carbon::parse($spec_data->updated_at)->format('Y-m-d H:i') : 'N/A' }}
                                    </span>
                                    
                                </div>
                                 <div class="last-updated">
                                     Updated By: 
                                    <span class="update-time">
                                        @if($spec_data)
                                        @php $user = DB::table('users')->where('id',$spec_data->created_by)->first() @endphp
                                        {{$user->company_name ?? 'N/A'}}
                                        @else
                                        N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td data-label="Status">
                            
                           <div class="status-cell-content" data-supplier-id="{{ $supplier->supplier_id }}">
                                <div class="status-main">
                                    <label class="status-toggle">
                                        <input type="checkbox" class="status-checkbox" {{ $supplier->status == 1 ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="status-text">{{ $supplier->status == 0 ? 'Inactive' : 'Active' }}</span>
                                </div>
                                <div class="status-details">
                                    <div class="status-date">
                                        Date: <span>@if($supplier->status_update_date) {{ \Carbon\Carbon::parse($supplier->status_update_date)->format('M d, Y g:i A') }} @endif</span>
                                    </div>

                                    @if($supplier->status == 0)
                                        <div class="status-comment">
                                            <span class="comment-text">@if($supplier->status_active_reason) {{$supplier->status_active_reason}} @else Initial activation. @endif</span>
                                            <i class="fas fa-pencil-alt edit-comment-icon" title="Add/Edit Comment"></i>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            
                        </td>
                    </tr>
                    @endforeach
                    @endif
                
                </tbody>
            </table>
        </div>
        <span style="margin-top:10px">
       </span>
    </div>


    <!-- Filter Popup -->
    <div class="filter-popup" id="filterPopup">
        <div class="filter-popup-header" id="filterPopupTitle">Filter by</div>
        <div class="filter-popup-body">
            <input type="search" class="filter-popup-search" id="filterPopupSearch" placeholder="Search values...">
            <div class="filter-popup-checklist" id="filterPopupChecklist"></div>
        </div>
        <div class="filter-popup-footer">
            <button class="btn btn-secondary btn-sm" id="filterClearBtn">Clear</button>
            <button class="btn btn-primary btn-sm" id="filterApplyBtn">Apply</button>
        </div>
    </div>

    <!-- Specification Filter Popup -->
    <div class="filter-popup" id="specFilterPopup">
        <div class="filter-popup-header">Filter by Specification</div>
        <div class="filter-popup-body">
            <div style="margin-bottom: 15px;">
                <strong style="display: block; margin-bottom: 8px; font-weight: 500;">Data Availability</strong>
                <div id="specAvailabilityFilter" style="display: flex; gap: 10px; font-size: 14px; flex-wrap: wrap;">
                    <label style="cursor:pointer;"><input type="radio" name="spec-availability" value="all" checked> All</label>
                    <label style="cursor:pointer;"><input type="radio" name="spec-availability" value="available"> Available</label>
                    <label style="cursor:pointer;"><input type="radio" name="spec-availability" value="not-available"> Not Available</label>
                </div>
            </div>
            <div>
                <strong style="display: block; margin-bottom: 8px; font-weight: 500;">Last Updated Date Range</strong>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label for="specDateFrom" style="font-size: 14px; display: block;">From:</label>
                    <input type="date" id="specDateFrom" class="filter-popup-search" style="margin-bottom: 5px;">
                    <label for="specDateTo" style="font-size: 14px; display: block;">To:</label>
                    <input type="date" id="specDateTo" class="filter-popup-search" style="margin-bottom: 0;">
                </div>
            </div>
        </div>
        <div class="filter-popup-footer">
            <button class="btn btn-secondary btn-sm" id="specFilterClearBtn">Clear</button>
            <button class="btn btn-primary btn-sm" id="specFilterApplyBtn">Apply</button>
        </div>
    </div>


 <!-- CSV Import Modal -->
<div class="modal" id="csvImportModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title">
                    <i class="fas fa-file-import"></i> Bulk Import Categories
                </h5>
                <button type="button" class="close close-modal" data-target-modal="csvImportModal" aria-label="Close">
                    &times;
                </button>
            </div>
           <form action="{{ route('new-supplier.bulk.import') }}" method="POST" enctype="multipart/form-data" id="csvUploadForm">
                @csrf
                
                @php
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
                } if ($user->created_by1) {
                $user_ids[] = $user->created_by1; } } }
                $user_ids[] = 1; 
                $user_ids = array_unique($user_ids);
                $categories = DB::table('new_supplier_product_category')->whereIn('created_by', $user_ids)->get(); @endphp
                
            
                <!-- Modal Body -->
                <div class="modal-body">
            
                    <!-- Category Select Dropdown -->
                    <div class="form-group mb-4">
                        <label for="categorySelect">Select Category</label>
                        <select id="categorySelect" name="category_id" class="form-control" >
                            <option value="">-- Select --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="subCategorySelect">Select Sub Category</label>
                        <select id="subCategorySelect" name="sub_category_id" class="form-control">
                            <option value="">-- Select --</option>
                        </select>
                    </div>
            
                    <!-- CSV Upload Area -->
                    <div class="form-group mb-4">
                        <label for="csvFileInput">Upload CSV File</label>
                        <div class="csv-upload-area border rounded p-4 text-center" id="csvUploadArea">
                            <div class="csv-upload-icon mb-2">
                                <i class="fas fa-file-csv fa-2x"></i>
                            </div>
                            <p>Drag & drop your CSV file here or click the button below</p>
            
                            <input type="file" id="csvFileInput" name="csv_file" class="d-none" accept=".csv" required>
                            <button type="button" id="csvUploadBtn" class="btn btn-primary">
                                <i class="fas fa-folder-open"></i> Select File
                            </button>
            
                            <!-- File Name Display -->
                            <div id="csvSelectedFile" class="mt-3 text-success font-weight-bold"></div>
            
                            <!-- Upload Status Message -->
                            <div id="csvUploadStatus" class="csv-upload-status mt-2 text-info"></div>
                        </div>
                    </div>
            
                    <!-- Submit Button -->
                    <div class="form-group text-center mt-4">
                        <button type="submit" id="csvSubmitBtn" class="btn btn-success">
                            <i class="fas fa-upload"></i> Upload CSV
                        </button>
                    </div>
            
                </div>
            </form>
        </div>
    </div>
</div>


    
    <!-- Material Edit Modal -->
    <div class="modal" id="materialEditModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title"><i class="fas fa-cogs"></i> Edit Materials</div>
                <button class="close-modal" data-target-modal="materialEditModal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="search" id="materialSearchInput" class="material-search-input" placeholder="Search materials...">
                <ul id="materialList" class="material-list"></ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal" style="background: none;border: none;font-size: 24px;cursor: pointer;color: #6c757d;" data-target-modal="materialEditModal">Cancel</button>
                <button class="btn btn-primary" id="saveMaterialBtn" 
                style="padding: 10px 20px;border: none;border-radius: 8px;cursor: pointer;font-size: 14px;font-weight: 500;transition:all 0.3s ease;display: inline-flex;align-items: center
                ;justify-content: center;gap: 8px;background-color: #4361ee;color: white;">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Comment Modal -->
    <div class="modal" id="commentModal">
        <div class="modal-content small">
            <div class="modal-header">
                <div class="modal-title"><i class="fas fa-comment"></i> Add/Edit Comment</div>
                <button class="close-modal" data-target-modal="commentModal">&times;</button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="supplier_id" id="supplier_id_input_1">
                <textarea id="commentTextarea" placeholder="Enter reason for status change..."></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal" data-target-modal="commentModal" style="height: 42px;color: white;">Cancel</button>
                <button class="btn btn-primary" id="saveCommentBtn">Save Comment</button>
                
            </div>
        </div>
    </div>

    <!-- Specification Generator Modal -->
    <div class="modal spec-generator-modal" id="specGeneratorModal">
        <div class="modal-content">
            <div class="modal-header">
                  <div class="modal-title">Upload Specification</div>
                <button class="close-modal" data-target-modal="specGeneratorModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="spec-generator-content">
                      <div style="display:none">
                           <span id="generatorMaterialNameTitle"></span>
                          <input type="text" id="materialName" required>
                              <select id="mainCategory" required>
                                    <option value="">Select a category</option>
                                </select>
                                <input type="text" id="specificSubCategory">
                                <input type="text" id="subCategory" required>
                      </div>
                    
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="supplier_id" id="supplier_id_input">
                    
                        <div class="row">
                    <div class="mb-12 col-md-12">
                        <label class="form-label">Upload :</label>
                        <input type="file" class="form-control" name="image" accept="application/pdf" required>
                    </div>


                    <div class="mb-3 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Upload New</button>
                    </div>
                      </div>
                    </form>

<div id="resultMsg" class="text-center mt-2"></div>

                </div>
            </div>
        </div>
    </div>


    <!-- Undo Notification -->
    <div class="undo-notification" id="undoNotification">
        <span id="undoMessage">Product deleted successfully</span>
        <button class="" id="undoActionBtn"></button>
    </div>

    <!-- Mobile Filter Menu Modal -->
    <div class="modal" id="mobileFilterMenuModal">
        <div class="modal-content small">
            <div class="modal-header">
                <div class="modal-title"><i class="fas fa-filter"></i> Select a Filter</div>
                <button class="close-modal" data-target-modal="mobileFilterMenuModal">&times;</button>
            </div>
            <div class="modal-body" id="mobileFilterMenuList" style="display: flex; flex-direction: column; gap: 10px;">
                <!-- Buttons will be dynamically added here by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Templates for Specification Generator -->
    <template id="newCategoryTemplate">
        <div class="dynamic-category-shell">
            <h2 class="section-header collapsible dynamic-category-header">
                <span class="section-number-prefix"></span>
                <span class="category-name-editable" contenteditable="true">Custom Section</span>
                <span class="toggle-icon">-</span>
            </h2>
            <div class="section-content-wrapper">
                <div class="category-content-blocks-container"></div>
                <div class="category-block-actions">
                    <button type="button" class="btn btn-info btn-small add-table-to-category-btn">Add Table Block</button>
                    <button type="button" class="btn btn-info btn-small add-text-to-category-btn">Add Text Block</button>
                </div>
                <div class="form-group" style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn btn-danger btn-small remove-category-btn">Remove This Section</button>
                </div>
            </div>
        </div>
    </template>
    <template id="tableBlockTemplate">
        <div class="content-block table-block" draggable="true">
            <h3 class="content-block-title">
                <span class="content-block-drag-handle">☰</span>
                <span class="table-block-title-text title-text-span" contenteditable="true">Table Block</span>
                <span class="buttons-group"><button type="button" class="btn btn-danger btn-small remove-content-block-btn">Remove Table</button></span>
            </h3>
            <div class="table-top-remarks form-group">
                <label><input type="checkbox" class="toggle-table-remarks-cb" data-target="top"> Add Top Remarks</label>
                <textarea class="table-remarks-textarea hidden" placeholder="Enter remarks for the top of the table..."></textarea>
            </div>
            <div class="section-toggle">
                <div class="section-actions">
                    <div class="file-upload">
                        <input type="file" class="import-table-csv-input" accept=".csv" id="tableFile_placeholder">
                        <label class="file-upload-label import-table-csv-label" for="tableFile_placeholder">Import CSV</label>
                    </div>
                     <button type="button" class="btn btn-secondary btn-small download-table-csv-btn">Download CSV Template</button>
                </div>
            </div>
            <div class="table-container-div"><table class="dynamic-table"><thead><tr><th contenteditable="false" class="action-column-header">Action</th></tr></thead><tbody></tbody></table></div>
            <div class="table-bottom-remarks form-group">
                 <label><input type="checkbox" class="toggle-table-remarks-cb" data-target="bottom"> Add Bottom Remarks</label>
                <textarea class="table-remarks-textarea hidden" placeholder="Enter remarks for the bottom of the table..."></textarea>
            </div>
        </div>
    </template>
    <template id="textBlockTemplate">
        <div class="content-block text-block" draggable="true">
             <h3 class="content-block-title">
                <span class="content-block-drag-handle">☰</span>
                <span class="text-block-title-text title-text-span" contenteditable="true">Text Block</span>
                <span class="buttons-group"><button type="button" class="btn btn-danger btn-small remove-content-block-btn">Remove Text Block</button></span>
            </h3>
            <div class="form-group">
                <label class="text-block-label" for="text_block_editor_placeholder_textarea" contenteditable="true">Content</label>
                <textarea class="text-block-textarea-tinymce" id="text_block_editor_placeholder_textarea"></textarea>
            </div>
            <div class="sub-text-blocks-container" style="margin-top:10px;"></div>
            <button type="button" class="btn btn-secondary btn-xs add-sub-text-btn" style="margin-top:5px;">+ Add Sub-Note</button>
        </div>
    </template>
<!--</div>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif

    @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif
</script>
<script>
    $(document).ready(function () {
        $('#categorySelect').on('change', function () {
            let categoryId = $(this).val();
            let subCategorySelect = $('#subCategorySelect');

            subCategorySelect.empty().append('<option value="">-- Select --</option>');

            if (categoryId) {
                $.ajax({
                    url: "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('check_dddd',data);
                        if (data.length > 0) {
                            $.each(data, function (key, subcategory) {
                                subCategorySelect.append(
                                    $('<option>', {
                                        value: subcategory.id,
                                        text: subcategory.name
                                    })
                                );
                            });
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert("Something went wrong while fetching subcategories.");
                    }
                });
            }
        });
    });
</script>
<script>
$('#uploadForm').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.prop('disabled', true).text('Uploading...');

    $('#resultMsg').html('<span class="text-info">Uploading...</span>');

    $.ajax({
        url: "{{ route('supplier_product_upload_specification') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            if(res.success){
                toastr.success(res.message);
                $('#resultMsg').html('<span class="text-success">'+res.message+'</span>');
                $submitBtn.prop('disabled', false).text('Upload New'); 
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            } else {
                toastr.error(res.message);
                $('#resultMsg').html('<span class="text-danger">'+res.message+'</span>');
                $submitBtn.prop('disabled', false).text('Upload New'); // enable again
            }
        },
        error: function(xhr) {
            toastr.error("Error: " + xhr.responseText);
            $('#resultMsg').html('<span class="text-danger">Error: '+xhr.responseText+'</span>');
            $submitBtn.prop('disabled', false).text('Upload New'); // enable again
        }
    });
});
</script>

    <script>
    
        // Target element (subcategory input)
        // const subCategoryInput = document.querySelector('.subcategory-search');
        
        // // MutationObserver config
        // const observer = new MutationObserver((mutations) => {
        //     mutations.forEach((mutation) => {
        //         if (mutation.type === 'attributes' && mutation.attributeName === 'disabled') {
        //             // Agar disable remove ho gaya hai
        //             if (!subCategoryInput.disabled) {
        //                 console.log("Subcategory enabled, running fetch function...");
        
        //                 let catVal = document.querySelector('.category-search').value;
        //                 if (catVal) {
        //                     fetch(`{{ url('new-supplier/get-subcategories/') }}/${catVal}`)
        //                         .then(res => res.json())
        //                         .then(categories => {
        //                             let existingSubCategories = new Set();
        //                             categories.forEach(cat => existingSubCategories.add(cat.name));
        
        //                             console.log('Existing Categories sub Set:', existingSubCategories);
        //                         })
        //                         .catch(err => console.error('Error fetching sub categories:', err));
        //                 }
        //             }
        //         }
        //     });
        // });
        
        // // Start observing for attribute changes
        // observer.observe(subCategoryInput, { attributes: true });




        document.addEventListener('DOMContentLoaded', function() {
            // --- DASHBOARD SCRIPT ---
            const productTable = document.getElementById('productTable');
            const addProductBtn = document.getElementById('addProductBtn');
            const tbody = productTable.querySelector('tbody');
            const thead = productTable.querySelector('thead');
            const resetFiltersBtn = document.getElementById('resetFilters');
            const mobileResetFiltersBtn = document.getElementById('mobileResetFiltersBtn');
            const csvSampleBtn = document.getElementById('csvSampleBtn');
            const openCsvModalBtn = document.getElementById('openCsvModalBtn');
            const modals = document.querySelectorAll('.modal');
            const closeModalBtns = document.querySelectorAll('.close-modal');
            const commentModal = document.getElementById('commentModal');
            const commentTextarea = document.getElementById('commentTextarea');
            const saveCommentBtn = document.getElementById('saveCommentBtn');
            const materialEditModal = document.getElementById('materialEditModal');
            const materialSearchInput = document.getElementById('materialSearchInput');
            const materialList = document.getElementById('materialList');
            const saveMaterialBtn = document.getElementById('saveMaterialBtn');
            const csvUploadArea = document.getElementById('csvUploadArea');
            const csvFileInput = document.getElementById('csvFileInput');
            const csvUploadBtn = document.getElementById('csvUploadBtn');
            const csvSelectedFile = document.getElementById('csvSelectedFile');
            const csvUploadStatus = document.getElementById('csvUploadStatus');
            const bulkActions = document.getElementById('bulkActions');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const bulkSelectionCount = document.getElementById('bulkSelectionCount');
            const bulkEditBtn = document.getElementById('bulkEditBtn');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkDeselectBtn = document.getElementById('bulkDeselectBtn');
            const undoNotification = document.getElementById('undoNotification');
            const undoActionBtn = document.getElementById('undoActionBtn');
            const undoMessage = document.getElementById('undoMessage');
            const filterPopup = document.getElementById('filterPopup');
            const filterPopupTitle = document.getElementById('filterPopupTitle');
            const filterPopupSearch = document.getElementById('filterPopupSearch');
            const filterPopupChecklist = document.getElementById('filterPopupChecklist');
            const filterApplyBtn = document.getElementById('filterApplyBtn');
            const filterClearBtn = document.getElementById('filterClearBtn');
            const specFilterPopup = document.getElementById('specFilterPopup');
            const specFilterApplyBtn = document.getElementById('specFilterApplyBtn');
            const specFilterClearBtn = document.getElementById('specFilterClearBtn');

            const specGeneratorModal = document.getElementById('specGeneratorModal');
            const mobileFilterBtn = document.getElementById('mobileFilterBtn');
            const mobileFilterMenuModal = document.getElementById('mobileFilterMenuModal');
            const mobileFilterMenuList = document.getElementById('mobileFilterMenuList');

            let activeFilters = { specification: { availability: 'all', from: null, to: null } };
            
            
            // const existingCategories = new Set(['Electronics', 'Clothing']);

             const existingCategories = new Set();
            fetch("{{ url('new-supplier/get-categories') }}")
                .then(res => res.json())
                .then(categories => {
                    categories.forEach(cat => {
                        existingCategories.add(cat.name);
                    });
                    })
            .catch(err => console.error('Error fetching categories:', err))
    
    
            // const existingSubCategories = new Set(['Mobile Phones', 'Laptops']);
            // const existingSpecificSubcategories = new Set(['Smartphones', 'Gaming']);
            
             const existingSubCategories = new Set();
             const existingSpecificSubcategories = new Set();
        
            const predefinedMaterials = ['Plastic', 'Glass', 'Aluminum', 'Steel', 'Rubber', 'Silicone', 'Wood', 'Carbon Fiber', 'Titanium', 'Ceramic', 'Leather'];
            
            // let categoryData = {'Electronics': {'Mobile Phones': ['Smartphones', 'Feature Phones'], 'Laptops': ['Gaming', 'Business', 'Ultrabooks']}, 'Clothing': {}};

                let categoryData = {};
                
                fetch("{{ url('new-supplier/get-all-categories') }}")
                    .then(res => res.json())
                    .then(categories => {
                        Object.entries(categories).forEach(([catName, subcategories]) => {
                            categoryData[catName] = {};
                
                            Object.entries(subcategories).forEach(([subName, specs]) => {
                                categoryData[catName][subName] = specs;
                            });
                        });
                
                        console.log('Existing Categories Set:', categoryData);
                    })
                    .catch(err => console.error('Error fetching categories:', err));



            let deletedRows = [];
            let originalRowData = null; 
            let currentlyEditingMaterialCell = null;
            let currentlyEditingCommentTarget = null;
            const csvSampleData = `Product Category,Sub Category,Specific Subcategory\nElectronics,Mobile Phones,Smartphones\nElectronics,Mobile Phones,Feature Phones\nElectronics,Laptops,Gaming\nElectronics,Laptops,Business\nElectronics,Laptops,Ultrabooks\nClothing,Men,Shirts\nClothing,Men,Pants\nClothing,Men,Jackets\nClothing,Women,Dresses\nClothing,Women,Skirts\nClothing,Women,Blouses`;

            // Function to initialize and run the Specification Generator script
            function initSpecGenerator() {
                const { jsPDF } = window.jspdf;
                const specFormScope = document.querySelector('.spec-generator-content');
                if (!specFormScope) return;
                
                const materialNameInputForTitle = specFormScope.querySelector('#materialName');
                const generatorTitleSpan = specFormScope.querySelector('#generatorMaterialNameTitle');
                if (materialNameInputForTitle && generatorTitleSpan) {
                    materialNameInputForTitle.addEventListener('input', () => {
                        generatorTitleSpan.textContent = materialNameInputForTitle.value.trim() || '[Material Name]';
                    });
                }

                const dynamicCategoriesContainer = specFormScope.querySelector('#dynamicCategoriesContainer');
                let draggedRow = null, draggedColumnHeader = null, rowPlaceholder = null;
                let draggedContentBlock = null, contentBlockPlaceholder = null;

                function makeEditable(element, saveCallback, revertValueProvider, defaultIfEmpty = "Untitled") { element.contentEditable = true; let originalValue = ''; element.addEventListener('focus', () => { originalValue = revertValueProvider ? revertValueProvider() : element.textContent.trim(); if (element.classList.contains('header-text-editable')) element.style.border = '1px solid #5c6bc0'; }); element.addEventListener('blur', () => { let newValue = element.textContent.trim(); if (newValue === "") { newValue = originalValue !== "" ? originalValue : defaultIfEmpty; element.textContent = newValue; } saveCallback(newValue); if (element.classList.contains('header-text-editable')) element.style.border = '1px dashed transparent'; }); element.addEventListener('keydown', (event) => { if (event.key === 'Enter' && !event.shiftKey && element.tagName !== 'DIV') { event.preventDefault(); element.blur(); } else if (event.key === 'Escape') { element.textContent = originalValue !== "" ? originalValue : defaultIfEmpty; element.blur(); } }); }
                function renumberDynamicCategoryTitles() { const dynamicCategories = dynamicCategoriesContainer.querySelectorAll('.dynamic-category-shell'); let currentNumber = 1; dynamicCategories.forEach(shell => { const numberPrefixSpan = shell.querySelector('.section-number-prefix'); const nameEditableSpan = shell.querySelector('.category-name-editable'); const header = shell.querySelector('.dynamic-category-header'); header.dataset.categoryNumber = currentNumber; if (numberPrefixSpan) numberPrefixSpan.textContent = `${currentNumber}. `; if (nameEditableSpan && !nameEditableSpan.textContent.trim() && header.dataset.categoryName) nameEditableSpan.textContent = header.dataset.categoryName; else if (nameEditableSpan && !nameEditableSpan.textContent.trim() && !header.dataset.categoryName) nameEditableSpan.textContent = "Custom Section"; currentNumber++; }); }
                function toggleCollapsibleSection(event) { if (event.target.closest('[contenteditable="true"], button, .content-block-drag-handle, th.draggable-column .header-text-editable, .tox-tinymce')) return; const header = event.currentTarget; const contentWrapper = header.nextElementSibling; if (contentWrapper && contentWrapper.classList.contains('section-content-wrapper')) { contentWrapper.classList.toggle('collapsed'); header.classList.toggle('collapsed'); const icon = header.querySelector('.toggle-icon'); if (icon) icon.textContent = contentWrapper.classList.contains('collapsed') ? '+' : '-'; } }
                specFormScope.querySelectorAll('h2.section-header.collapsible:not(.dynamic-category-header)').forEach(h => h.addEventListener('click', toggleCollapsibleSection));
                function initContentBlockDragAndDrop(containerElement) { if (!contentBlockPlaceholder) { contentBlockPlaceholder = document.createElement('div'); contentBlockPlaceholder.classList.add('content-block-drop-placeholder');} containerElement.addEventListener('dragstart', e => { let handle = e.target.classList.contains('content-block-drag-handle') ? e.target : e.target.closest('.content-block-drag-handle'); if (handle) draggedContentBlock = handle.closest('.content-block'); else if (e.target.classList.contains('content-block') && !e.target.closest('input, textarea, button, [contenteditable="true"]:not(.title-text-span), .th-actions, .cell-actions, .tox-tinymce')) draggedContentBlock = e.target; if (draggedContentBlock) { e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setData('text/plain', null); setTimeout(() => draggedContentBlock.classList.add('dragging'), 0); }}); containerElement.addEventListener('dragover', e => { e.preventDefault(); if (!draggedContentBlock) return; const targetBlock = e.target.closest('.content-block'); if (targetBlock && targetBlock !== draggedContentBlock && targetBlock.parentNode === containerElement) { const rect = targetBlock.getBoundingClientRect(); const isAfter = (e.clientY - rect.top) > (rect.height / 2); if (isAfter) containerElement.insertBefore(contentBlockPlaceholder, targetBlock.nextSibling); else containerElement.insertBefore(contentBlockPlaceholder, targetBlock); } else if (!targetBlock && e.target === containerElement) containerElement.appendChild(contentBlockPlaceholder); }); containerElement.addEventListener('drop', e => { e.preventDefault(); if (draggedContentBlock && contentBlockPlaceholder && contentBlockPlaceholder.parentNode === containerElement) containerElement.insertBefore(draggedContentBlock, contentBlockPlaceholder); cleanupContentBlockDrag(); }); containerElement.addEventListener('dragend', cleanupContentBlockDrag); }
                function cleanupContentBlockDrag() { if (draggedContentBlock) { draggedContentBlock.classList.remove('dragging'); draggedContentBlock = null; } if (contentBlockPlaceholder && contentBlockPlaceholder.parentNode) contentBlockPlaceholder.parentNode.removeChild(contentBlockPlaceholder); }
                function initRowDragAndDrop(tbodyElement) { tbodyElement.addEventListener('dragstart', e => { if (e.target.tagName === 'TR' && e.target.classList.contains('draggable-row')) { draggedRow = e.target; e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setData('text/plain', null); setTimeout(() => draggedRow.classList.add('dragging'), 0); if (!rowPlaceholder) { rowPlaceholder = document.createElement('tr'); const td = document.createElement('td'); td.colSpan = draggedRow.cells.length; td.classList.add('drag-over-placeholder-row'); rowPlaceholder.appendChild(td);}}}); tbodyElement.addEventListener('dragover', e => { e.preventDefault(); if (!draggedRow || !e.target.closest('tr.draggable-row')) return; const targetRow = e.target.closest('tr.draggable-row'); if (targetRow && targetRow !== draggedRow && targetRow.parentNode === tbodyElement) { const rect = targetRow.getBoundingClientRect(); const nextSibling = (e.clientY - rect.top) > (rect.height / 2) ? targetRow.nextSibling : targetRow; tbodyElement.insertBefore(rowPlaceholder, nextSibling); }}); tbodyElement.addEventListener('drop', e => { e.preventDefault(); if (draggedRow && rowPlaceholder && rowPlaceholder.parentNode === tbodyElement) tbodyElement.insertBefore(draggedRow, rowPlaceholder); cleanupRowDrag(); }); tbodyElement.addEventListener('dragend', cleanupRowDrag); }
                function cleanupRowDrag() { if (draggedRow) { draggedRow.classList.remove('dragging'); draggedRow = null; } if (rowPlaceholder && rowPlaceholder.parentNode) rowPlaceholder.parentNode.removeChild(rowPlaceholder); }
                function initColumnDragAndDrop(theadElement) { theadElement.addEventListener('dragstart', e => { if (e.target.classList.contains('header-text-editable')) { const th = e.target.closest('th.draggable-column'); if (th) { draggedColumnHeader = th; e.dataTransfer.effectAllowed = 'move'; e.dataTransfer.setData('text/plain', Array.from(th.parentNode.children).indexOf(th)); setTimeout(() => draggedColumnHeader.classList.add('dragging'), 0); }} else e.preventDefault(); }); theadElement.addEventListener('dragover', e => { e.preventDefault(); const targetTh = e.target.closest('th.draggable-column'); if (targetTh && targetTh !== draggedColumnHeader) { theadElement.querySelectorAll('th.drag-over-target-col').forEach(t => t.classList.remove('drag-over-target-col')); targetTh.classList.add('drag-over-target-col'); e.dataTransfer.dropEffect = 'move'; } else if (!targetTh) theadElement.querySelectorAll('th.drag-over-target-col').forEach(t => t.classList.remove('drag-over-target-col')); }); theadElement.addEventListener('dragleave', e => { const targetTh = e.target.closest('th.draggable-column'); if (targetTh) targetTh.classList.remove('drag-over-target-col'); }); theadElement.addEventListener('drop', e => { e.preventDefault(); const targetTh = e.target.closest('th.drag-over-target-col'); if (draggedColumnHeader && targetTh && targetTh !== draggedColumnHeader) { const table = theadElement.closest('table'); const fromIndex = Array.from(draggedColumnHeader.parentNode.children).indexOf(draggedColumnHeader); const toIndex = Array.from(targetTh.parentNode.children).indexOf(targetTh); swapTableColumns(table, fromIndex, toIndex); } cleanupColumnDrag(theadElement); }); theadElement.addEventListener('dragend', e => cleanupColumnDrag(theadElement)); }
                function cleanupColumnDrag(theadElement) { if (draggedColumnHeader) { draggedColumnHeader.classList.remove('dragging'); draggedColumnHeader = null; } if (theadElement) theadElement.querySelectorAll('th.drag-over-target-col').forEach(t => t.classList.remove('drag-over-target-col')); }
                function swapTableColumns(table, colIndex1, colIndex2) { const headerRow = table.querySelector('thead tr'); if (headerRow.children[colIndex1].classList.contains('action-column-header') || headerRow.children[colIndex2].classList.contains('action-column-header')) return; const col1Header = headerRow.children[colIndex1], col2Header = headerRow.children[colIndex2]; if (colIndex1 < colIndex2) { headerRow.insertBefore(col2Header, col1Header); headerRow.insertBefore(col1Header, headerRow.children[colIndex2 + 1] || null); } else { headerRow.insertBefore(col1Header, col2Header); headerRow.insertBefore(col2Header, headerRow.children[colIndex1 + 1] || null); } table.querySelectorAll('tbody tr').forEach(row => { const cell1 = row.children[colIndex1], cell2 = row.children[colIndex2]; if (colIndex1 < colIndex2) { row.insertBefore(cell2, cell1); row.insertBefore(cell1, row.children[colIndex2 + 1] || null); } else { row.insertBefore(cell1, cell2); row.insertBefore(cell2, row.children[colIndex1 + 1] || null); } }); }
                function createActionCellContent(table, row) { const actionCell = document.createElement('td'); actionCell.classList.add('cell-actions'); const insertAboveBtn = document.createElement('button'); insertAboveBtn.type = 'button'; insertAboveBtn.className = 'btn btn-info btn-xs insert-row-above-btn'; insertAboveBtn.title = 'Insert row above'; insertAboveBtn.textContent = '↑+ Insert'; insertAboveBtn.addEventListener('click', () => insertRowAtIndex(table, Array.from(row.parentNode.children).indexOf(row))); const deleteBtn = document.createElement('button'); deleteBtn.type = 'button'; deleteBtn.className = 'btn btn-danger btn-xs delete-row-btn'; deleteBtn.title = 'Delete row'; deleteBtn.textContent = 'X Delete'; deleteBtn.addEventListener('click', () => { if (confirm('Delete this row?')) { const tbody = row.parentNode; tbody.removeChild(row); if (tbody.children.length === 0) addTableRow(table); }}); actionCell.append(insertAboveBtn, deleteBtn); return actionCell; }
                function addTableRow(tableElement, atIndex = -1) { if (!tableElement) return; const tbody = tableElement.querySelector('tbody'), headerRow = tableElement.querySelector('thead tr'); if (!tbody || !headerRow) return; const dataHeaders = Array.from(headerRow.children).filter(th => !th.classList.contains('action-column-header')); const newRow = document.createElement('tr'); newRow.classList.add('draggable-row'); newRow.draggable = true; dataHeaders.forEach(header => { const cell = document.createElement('td'), input = document.createElement('input'); input.type = 'text'; const headerTextSpan = header.querySelector('.header-text-editable'); input.placeholder = headerTextSpan ? (headerTextSpan.dataset.originalText || headerTextSpan.textContent.trim()) : 'Value'; cell.appendChild(input); newRow.appendChild(cell); }); newRow.appendChild(createActionCellContent(tableElement, newRow)); if (atIndex === -1 || atIndex >= tbody.children.length) tbody.appendChild(newRow); else tbody.insertBefore(newRow, tbody.children[atIndex]); }
                function insertRowAtIndex(table, index) { addTableRow(table, index); }
                function makeTableHeaderInteractive(thElement, tableElement) { const headerTextSpan = thElement.querySelector('.header-text-editable'); if (!headerTextSpan) return; thElement.classList.add('draggable-column'); makeEditable(headerTextSpan, (newHeaderText) => { headerTextSpan.dataset.originalText = newHeaderText; const headerIndex = Array.from(thElement.parentNode.children).indexOf(thElement); if (headerIndex > -1) tableElement.querySelectorAll('tbody tr').forEach(row => { const cell = row.cells[headerIndex]; if (cell) { const input = cell.querySelector('input[type="text"]'); if (input) input.placeholder = newHeaderText; }}); }, () => headerTextSpan.dataset.originalText || headerTextSpan.textContent.trim(), "Parameter"); const insertLeftBtn = thElement.querySelector('.insert-col-left-btn'), deleteBtn = thElement.querySelector('.delete-col-btn'); if (insertLeftBtn) insertLeftBtn.addEventListener('click', () => { const colIndex = Array.from(thElement.parentNode.children).indexOf(thElement); const newName = prompt("Enter name for the new column:", "New Column"); if (newName) insertColumnAtIndex(tableElement, colIndex, newName.trim()); }); if (deleteBtn) deleteBtn.addEventListener('click', () => { const colIndex = Array.from(thElement.parentNode.children).indexOf(thElement); deleteColumnAtIndex(tableElement, colIndex); }); }
                function createNewHeaderCell(headerName = "New Param", table) { const th = document.createElement('th'); th.innerHTML = `<div class="th-content-wrapper"><span class="header-text-editable" contenteditable="true" data-original-text="${headerName}">${headerName}</span><div class="th-actions"><button type="button" class="btn btn-info btn-xs insert-col-left-btn" title="Insert column left">←+</button><button type="button" class="btn btn-danger btn-xs delete-col-btn" title="Delete column">X</button></div></div>`; makeTableHeaderInteractive(th, table); return th; }
                function insertColumnAtIndex(table, index, headerName = "New Column") { const headerRow = table.querySelector('thead tr'), newTh = createNewHeaderCell(headerName, table); headerRow.insertBefore(newTh, headerRow.children[index]); table.querySelectorAll('tbody tr').forEach(row => { const newTd = document.createElement('td'), input = document.createElement('input'); input.type = 'text'; input.placeholder = headerName; newTd.appendChild(input); row.insertBefore(newTd, row.children[index]); }); }
                function deleteColumnAtIndex(table, index) { const headerRow = table.querySelector('thead tr'); const dataColumnCount = Array.from(headerRow.children).filter(th => !th.classList.contains('action-column-header')).length; if (dataColumnCount <= 1) { alert("Cannot delete the last data column."); return; } if (confirm(`Delete column "${headerRow.children[index].querySelector('.header-text-editable').textContent.trim()}"?`)) { headerRow.children[index].remove(); table.querySelectorAll('tbody tr').forEach(row => { if (row.children[index]) row.children[index].remove(); }); } }
                function parseCsvLine(line) { const cells = []; let currentCell = '', inQuotes = false; for (let char of line) { if (char === '"' && (currentCell.length === 0 || currentCell.charAt(currentCell.length - 1) !== '\\')) { inQuotes = !inQuotes; if (!inQuotes && currentCell.endsWith('"')) currentCell = currentCell.slice(0, -1); else if (inQuotes && currentCell.startsWith('"')) currentCell = currentCell.substring(1); else currentCell += char; } else if (char === ',' && !inQuotes) { cells.push(currentCell.trim().replace(/""/g, '"')); currentCell = ''; } else currentCell += char; } cells.push(currentCell.trim().replace(/""/g, '"')); return cells; }
                function addTableBlockToCategory(categoryShell, categoryIdBase, blockTitle = "Data Table") { const tableBlockCounter = parseInt(categoryShell.dataset.tableBlockCount || '0') + 1; categoryShell.dataset.tableBlockCount = tableBlockCounter; const blockIdBase = `${categoryIdBase}-table${tableBlockCounter}`; const template = document.getElementById('tableBlockTemplate'), clone = template.content.cloneNode(true); const tableBlockDiv = clone.querySelector('.table-block'); tableBlockDiv.id = blockIdBase; const titleSpan = clone.querySelector('.table-block-title-text'); const defaultTitle = (blockTitle === "Data Table" && tableBlockCounter > 1) ? `${blockTitle} ${tableBlockCounter}` : blockTitle; titleSpan.textContent = defaultTitle; tableBlockDiv.dataset.blockTitle = defaultTitle; makeEditable(titleSpan, (newTitle) => { tableBlockDiv.dataset.blockTitle = newTitle; }, () => tableBlockDiv.dataset.blockTitle, "Table Block"); const currentTable = clone.querySelector('.dynamic-table'); currentTable.id = `${blockIdBase}_Table`; const tableContainerDiv = clone.querySelector('.table-container-div'); const theadTr = currentTable.querySelector('thead tr'); theadTr.innerHTML = ''; const initialHeaders = ["Parameter 1", "Parameter 2", "Parameter 3"]; initialHeaders.forEach(headerText => theadTr.appendChild(createNewHeaderCell(headerText, currentTable))); const actionTh = document.createElement('th'); actionTh.classList.add('action-column-header'); actionTh.textContent = "Action"; actionTh.contentEditable = false; theadTr.appendChild(actionTh); initRowDragAndDrop(currentTable.querySelector('tbody')); initColumnDragAndDrop(currentTable.querySelector('thead')); clone.querySelectorAll('.toggle-table-remarks-cb').forEach(cb => { cb.addEventListener('change', function() { const targetType = this.dataset.target, remarksTextarea = tableBlockDiv.querySelector(`.table-${targetType}-remarks .table-remarks-textarea`); if (this.checked) remarksTextarea.classList.remove('hidden'); else remarksTextarea.classList.add('hidden'); }); }); clone.querySelector('.download-table-csv-btn').addEventListener('click', function() { const dataHeaders = Array.from(currentTable.querySelectorAll('thead th:not(.action-column-header) .header-text-editable')).map(span => `"${(span.dataset.originalText || span.textContent.trim()).replace(/"/g, '""')}"`).join(','); const filename = `${(tableBlockDiv.dataset.blockTitle || "table_data").replace(/\s+/g, '_')}_template.csv`; const blob = new Blob([`${dataHeaders}\n`], { type: 'text/csv;charset=utf-8;' }); const link = document.createElement('a'); link.href = URL.createObjectURL(blob); link.download = filename; document.body.appendChild(link); link.click(); document.body.removeChild(link); }); const fileInput = clone.querySelector('.import-table-csv-input'); fileInput.id = `${blockIdBase}_File`; clone.querySelector('.import-table-csv-label').htmlFor = fileInput.id; fileInput.addEventListener('change', function(event) { const file = event.target.files[0]; if (!file || !currentTable) return; const reader = new FileReader(); reader.onload = function(e) { const content = e.target.result, tbody = currentTable.querySelector('tbody'), thead = currentTable.querySelector('thead'); if (!tbody || !thead) return; tbody.innerHTML = ''; thead.querySelector('tr').innerHTML = ''; const lines = content.split(/\r\n|\n/).filter(line => line.trim() !== ''); if (lines.length === 0) { if (tbody.children.length === 0) addTableRow(currentTable); return; } const csvHeaders = parseCsvLine(lines[0]); csvHeaders.forEach(headerText => thead.querySelector('tr').appendChild(createNewHeaderCell(headerText.trim(), currentTable))); const newActionTh = document.createElement('th'); newActionTh.classList.add('action-column-header'); newActionTh.textContent = "Action"; newActionTh.contentEditable = false; thead.querySelector('tr').appendChild(newActionTh); for (let i = 1; i < lines.length; i++) { addTableRow(currentTable); const newRow = tbody.lastElementChild, csvCells = parseCsvLine(lines[i]), dataCellsInRow = Array.from(newRow.children).filter(td => !td.classList.contains('cell-actions')); dataCellsInRow.forEach((td, j) => { const input = td.querySelector('input'); if (input && csvCells[j] !== undefined) input.value = csvCells[j]; }); } if (tbody.children.length === 0) addTableRow(currentTable); }; reader.readAsText(file); event.target.value = ''; }); clone.querySelector('.remove-content-block-btn').addEventListener('click', function() { if (confirm(`Remove table block "${tableBlockDiv.dataset.blockTitle}"?`)) tableBlockDiv.remove(); }); categoryShell.querySelector('.category-content-blocks-container').appendChild(clone); if (currentTable.querySelector('tbody tr') === null) addTableRow(currentTable); }
                function createSubSubTextBlock(parentSubItemId, subSubTextCounter, subSubTextContainer) { const subSubItemId = `${parentSubItemId}-sub${subSubTextCounter}`; const subSubItemDiv = document.createElement('div'); subSubItemDiv.className = 'sub-sub-text-block-item form-group'; subSubItemDiv.id = subSubItemId; const subSubLabel = document.createElement('label'); subSubLabel.htmlFor = `${subSubItemId}_textarea`; subSubLabel.textContent = `Sub-Sub-Note ${subSubTextCounter}:`; subSubLabel.contentEditable = true; makeEditable(subSubLabel, () => {}, () => `Sub-Sub-Note ${subSubTextCounter}:`, `Sub-Sub-Note ${subSubTextCounter}`); const subSubTextarea = document.createElement('textarea'); subSubTextarea.id = `${subSubItemId}_textarea`; subSubTextarea.placeholder = "Enter sub-sub-note content..."; const removeSubSubBtn = document.createElement('button'); removeSubSubBtn.type = 'button'; removeSubSubBtn.className = 'btn btn-danger btn-xs remove-sub-sub-text-btn'; removeSubSubBtn.textContent = 'X'; removeSubSubBtn.title = 'Remove Sub-Sub-Note'; removeSubSubBtn.onclick = function() { if (confirm('Remove this sub-sub-note?')) subSubItemDiv.remove(); }; subSubItemDiv.appendChild(removeSubSubBtn); subSubItemDiv.appendChild(subSubLabel); subSubItemDiv.appendChild(subSubTextarea); subSubTextContainer.appendChild(subSubItemDiv); }
                function addTextBlockToCategory(categoryShell, categoryIdBase, blockTitle = "Text Block") { const textBlockCounter = parseInt(categoryShell.dataset.textBlockCount || '0') + 1; categoryShell.dataset.textBlockCount = textBlockCounter; const blockIdBase = `${categoryIdBase}-text${textBlockCounter}`; let subTextCounter = 0; const template = document.getElementById('textBlockTemplate'), clone = template.content.cloneNode(true); const textBlockDiv = clone.querySelector('.text-block'); textBlockDiv.id = blockIdBase; const titleSpan = clone.querySelector('.text-block-title-text'); const defaultTitle = (blockTitle === "Text Block" && textBlockCounter > 1) ? `${blockTitle} ${textBlockCounter}` : blockTitle; titleSpan.textContent = defaultTitle; textBlockDiv.dataset.blockTitle = defaultTitle; const textarea = clone.querySelector('.text-block-textarea-tinymce'); const uniqueEditorId = `${blockIdBase}_Editor_TinyMCE`; textarea.id = uniqueEditorId; makeEditable(titleSpan, (newTitle) => { textBlockDiv.dataset.blockTitle = newTitle; }, () => textBlockDiv.dataset.blockTitle, "Text Block"); const label = clone.querySelector('.text-block-label'); label.htmlFor = uniqueEditorId; makeEditable(label, () => {}, () => "Content", "Content"); const subTextContainer = clone.querySelector('.sub-text-blocks-container'); clone.querySelector('.add-sub-text-btn').addEventListener('click', function() { subTextCounter++; const subItemId = `${blockIdBase}-sub${subTextCounter}`; const subItemDiv = document.createElement('div'); subItemDiv.className = 'sub-text-block-item form-group'; subItemDiv.id = subItemId; let subSubTextCounterForThisSub = 0; const subLabel = document.createElement('label'); subLabel.htmlFor = `${subItemId}_textarea`; subLabel.textContent = `Sub-Note ${subTextCounter}:`; subLabel.contentEditable = true; makeEditable(subLabel, () => {}, () => `Sub-Note ${subTextCounter}:`, `Sub-Note ${subTextCounter}`); const subTextarea = document.createElement('textarea'); subTextarea.id = `${subItemId}_textarea`; subTextarea.placeholder = "Enter sub-note content..."; const removeSubBtn = document.createElement('button'); removeSubBtn.type = 'button'; removeSubBtn.className = 'btn btn-danger btn-xs remove-sub-text-btn'; removeSubBtn.textContent = 'X'; removeSubBtn.title = 'Remove Sub-Note'; removeSubBtn.onclick = function() { if (confirm('Remove this sub-note (and all its sub-sub-notes)?')) subItemDiv.remove(); }; const subSubTextContainerDiv = document.createElement('div'); subSubTextContainerDiv.className = 'sub-sub-text-blocks-container'; subSubTextContainerDiv.style.marginTop = '10px'; const addSubSubTextBtn = document.createElement('button'); addSubSubTextBtn.type = 'button'; addSubSubTextBtn.className = 'btn btn-secondary btn-xs add-sub-sub-text-btn'; addSubSubTextBtn.textContent = '+ Add Sub-Sub-Note'; addSubSubTextBtn.style.marginTop = '5px'; addSubSubTextBtn.style.fontSize = '0.8em'; addSubSubTextBtn.onclick = function() { subSubTextCounterForThisSub++; createSubSubTextBlock(subItemId, subSubTextCounterForThisSub, subSubTextContainerDiv); }; subItemDiv.appendChild(removeSubBtn); subItemDiv.appendChild(subLabel); subItemDiv.appendChild(subTextarea); subItemDiv.appendChild(subSubTextContainerDiv); subItemDiv.appendChild(addSubSubTextBtn); subTextContainer.appendChild(subItemDiv); }); clone.querySelector('.remove-content-block-btn').addEventListener('click', function() { if (confirm(`Remove text block "${textBlockDiv.dataset.blockTitle}"?`)) { const editorInstance = tinymce.get(uniqueEditorId); if (editorInstance) editorInstance.remove(); textBlockDiv.remove(); } }); categoryShell.querySelector('.category-content-blocks-container').appendChild(clone); tinymce.init({ selector: `#${uniqueEditorId}`, height: 250, menubar: 'file edit view insert format tools table help', plugins: ['advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount'], content_style: 'body { font-family:Inter,sans-serif; font-size:16px }', init_instance_callback: function(editor) { editor.on('focus', function(e) { draggedContentBlock = null; }); } }); }
                specFormScope.querySelector('#addNewCategoryBtn').addEventListener('click', function() { const categoryIdBase = `customCategory${Date.now()}`; const template = document.getElementById('newCategoryTemplate'), clone = template.content.cloneNode(true); const categoryShell = clone.querySelector('.dynamic-category-shell'); categoryShell.id = categoryIdBase; categoryShell.dataset.tableBlockCount = 0; categoryShell.dataset.textBlockCount = 0; const header = clone.querySelector('.dynamic-category-header'), nameEditableSpan = clone.querySelector('.category-name-editable'); const defaultBaseCategoryName = "Custom Section"; nameEditableSpan.textContent = defaultBaseCategoryName; header.dataset.categoryName = defaultBaseCategoryName; header.addEventListener('click', toggleCollapsibleSection); const contentBlocksContainer = categoryShell.querySelector('.category-content-blocks-container'); initContentBlockDragAndDrop(contentBlocksContainer); clone.querySelector('.add-table-to-category-btn').addEventListener('click', () => addTableBlockToCategory(categoryShell, categoryIdBase, "Data Table")); clone.querySelector('.add-text-to-category-btn').addEventListener('click', () => addTextBlockToCategory(categoryShell, categoryIdBase, "Additional Notes")); clone.querySelector('.remove-category-btn').addEventListener('click', function() { if (confirm(`Remove entire section "${header.dataset.categoryName}"?`)) { const tinymceTextareas = categoryShell.querySelectorAll('.text-block-textarea-tinymce'); tinymceTextareas.forEach(ta => { const editor = tinymce.get(ta.id); if(editor) editor.remove(); }); categoryShell.remove(); renumberDynamicCategoryTitles(); } }); dynamicCategoriesContainer.appendChild(categoryShell); renumberDynamicCategoryTitles(); makeEditable(nameEditableSpan, (newName) => { header.dataset.categoryName = newName; renumberDynamicCategoryTitles(); }, () => header.dataset.categoryName || defaultBaseCategoryName, "Custom Section"); });

                async function generatePdfDocument() {
                    const doc = new jsPDF({ unit: 'mm', format: 'a4' });
                    const pageMargin = 10; const totalPagesId = '{totalPages}'; const pageBottomMargin = 20; const contentTextIndent = pageMargin + 4; const nestedContentIndent = contentTextIndent + 4;
                    const basicDataForHeader = { materialName: specFormScope.querySelector("#materialName").value.trim(), mainCategory: specFormScope.querySelector("#mainCategory").value, subCategory: specFormScope.querySelector("#subCategory").value.trim(), specificSubCategory: specFormScope.querySelector("#specificSubCategory").value.trim(), dietaryType: specFormScope.querySelector('input[name="dietaryType"]:checked') ? specFormScope.querySelector('input[name="dietaryType"]:checked').value : 'N/A', materialOrigin: specFormScope.querySelector('input[name="materialOrigin"]:checked') ? specFormScope.querySelector('input[name="materialOrigin"]:checked').value : 'N/A' };
                    function drawPageHeaderAndFooter(docInstance, pageNum, totalPagesStr) {
                        const FONT_FAMILY = 'helvetica'; const originalStyles = { font: { name: docInstance.getFont().fontName, style: docInstance.getFont().fontStyle }, fontSize: docInstance.getFontSize(), textColor: docInstance.getTextColor() };
                        const headerTopMargin = 8; const companyNameValue = "Your Company Name"; const pageWidth = docInstance.internal.pageSize.width; const contentWidth = pageWidth - 2 * pageMargin; const BASE_R_HEIGHT = 7.5; const cellPaddingX = 2; const textLineHeightForCalc = 4; let currentY = headerTopMargin;
                        docInstance.setFont(FONT_FAMILY); docInstance.setLineWidth(0.2); docInstance.setDrawColor(0, 0, 0);
                        function drawCellText(rawText, x, cellWidth, yBase, options = {}) { const { align = 'left', bold = false, fontSize = 8, isLabelWithValue = false, label = '', value = '', labelBold = false, valueBold = false } = options; docInstance.setFontSize(fontSize); const textLineH = docInstance.getLineHeight() / docInstance.internal.scaleFactor * 1.1; let textToProcess = ""; let lines; const availableWidth = cellWidth - (2 * cellPaddingX); if (isLabelWithValue) { let currentLineY = yBase; let totalLinesForCell = 0; docInstance.setFont(FONT_FAMILY, labelBold ? 'bold' : 'normal'); const labelLines = docInstance.splitTextToSize(String(label), availableWidth > 0 ? availableWidth : 1); labelLines.forEach(line => { docInstance.text(line, x + cellPaddingX, currentLineY); currentLineY += textLineH; totalLinesForCell++; }); docInstance.setFont(FONT_FAMILY, valueBold ? 'bold' : 'normal'); const valueLines = docInstance.splitTextToSize(String(value || 'N/A'), availableWidth > 0 ? availableWidth : 1); valueLines.forEach(line => { docInstance.text(line, x + cellPaddingX, currentLineY); currentLineY += textLineH; totalLinesForCell++; }); return totalLinesForCell; } else { textToProcess = String(rawText); docInstance.setFont(FONT_FAMILY, bold ? 'bold' : 'normal'); lines = docInstance.splitTextToSize(textToProcess, availableWidth > 0 ? availableWidth : 1); lines.forEach((line, index) => { let textX = x + cellPaddingX; if (align === 'center') { const lineWidth = docInstance.getTextWidth(line); textX = x + (cellWidth - lineWidth) / 2; } docInstance.text(line, textX, yBase + (index * textLineH)); }); return lines.length; } }
                        let r1Height, r2Height, r3Height, r4ActualHeight, r5Height; const textYAdjustment = 2.5; docInstance.setFontSize(12); r1Height = Math.max(BASE_R_HEIGHT, drawCellText(companyNameValue, pageMargin, contentWidth, currentY + textYAdjustment, { align: 'center', bold: true, fontSize: 12 }) * textLineHeightForCalc + 3); currentY += r1Height; docInstance.setFontSize(11); r2Height = Math.max(BASE_R_HEIGHT, drawCellText("Raw Material Specification", pageMargin, contentWidth, currentY + textYAdjustment, { align: 'center', bold: true, fontSize: 11 }) * textLineHeightForCalc + 3); currentY += r2Height; docInstance.setFontSize(10); r3Height = Math.max(BASE_R_HEIGHT, drawCellText("", pageMargin, contentWidth, currentY + textYAdjustment, { align: 'center', isLabelWithValue: true, label: "Material Name: ", value: (basicDataForHeader.materialName || "N/A"), labelBold: true, fontSize:10 }) * textLineHeightForCalc + 3); currentY += r3Height; const R4_Y_START = currentY; const colWidthR4 = contentWidth / 4; let currentX_R4 = pageMargin; docInstance.setFontSize(8); let r4MaxLinesInRow = 1; const categoryDataR4 = [{ label: "Main Category: ", value: basicDataForHeader.mainCategory, boldLabel: false }, { label: "Sub Category: ", value: basicDataForHeader.subCategory, boldLabel: true }, { label: "Specific Sub Category: ", value: basicDataForHeader.specificSubCategory, boldLabel: false }]; categoryDataR4.forEach(item => { let lines = drawCellText('', currentX_R4, colWidthR4, R4_Y_START + textYAdjustment, { isLabelWithValue:true, label: item.label, value: item.value, labelBold: item.boldLabel, fontSize: 8 }); r4MaxLinesInRow = Math.max(r4MaxLinesInRow, lines); currentX_R4 += colWidthR4; }); const dietaryOriginTextR4 = `${basicDataForHeader.dietaryType}; ${basicDataForHeader.materialOrigin}`; let linesLastCellR4 = drawCellText(dietaryOriginTextR4, currentX_R4, colWidthR4, R4_Y_START + textYAdjustment, {fontSize: 8}); r4MaxLinesInRow = Math.max(r4MaxLinesInRow, linesLastCellR4); r4ActualHeight = Math.max(BASE_R_HEIGHT, r4MaxLinesInRow * textLineHeightForCalc + 3); currentY += r4ActualHeight; const R5_Y_START = currentY; let currentX_R5 = pageMargin; const docInfoLabelsR5 = ["Doc No:", "Issue Date:", "Version No:", "Revision Date:"]; docInfoLabelsR5.forEach((label) => { drawCellText(label, currentX_R5, colWidthR4, R5_Y_START + textYAdjustment, { bold: false, fontSize: 8 }); currentX_R5 += colWidthR4; }); r5Height = BASE_R_HEIGHT; currentY += r5Height; const headerTotalActualHeight = (currentY - headerTopMargin); docInstance.rect(pageMargin, headerTopMargin, contentWidth, headerTotalActualHeight); let lineY = headerTopMargin; lineY += r1Height; docInstance.line(pageMargin, lineY, pageWidth - pageMargin, lineY); lineY += r2Height; docInstance.line(pageMargin, lineY, pageWidth - pageMargin, lineY); lineY += r3Height; docInstance.line(pageMargin, lineY, pageWidth - pageMargin, lineY); lineY += r4ActualHeight; docInstance.line(pageMargin, lineY, pageWidth - pageMargin, lineY); let xCursorForVLines = pageMargin; for (let i = 0; i < 3; i++) { xCursorForVLines += colWidthR4; docInstance.line(xCursorForVLines, R4_Y_START, xCursorForVLines, R4_Y_START + r4ActualHeight + r5Height); } docInstance.setFont(FONT_FAMILY, 'normal'); docInstance.setFontSize(originalStyles.fontSize); const footerText = `Page ${pageNum} of ${totalPagesStr}`; const footerY = docInstance.internal.pageSize.height - 10; docInstance.text(footerText, pageWidth / 2, footerY, { align: 'center' }); docInstance.setFont(originalStyles.font.name, originalStyles.font.style); docInstance.setFontSize(originalStyles.fontSize); if (typeof originalStyles.textColor === 'string') docInstance.setTextColor(originalStyles.textColor); else if (Array.isArray(originalStyles.textColor)) docInstance.setTextColor(originalStyles.textColor[0], originalStyles.textColor[1], originalStyles.textColor[2]); else docInstance.setTextColor(0,0,0); return currentY + 6; }
                    let yPosition = drawPageHeaderAndFooter(doc, 1, totalPagesId);
                    function checkAddPage(currentYPos, neededHeight = 10) { if (currentYPos + neededHeight > doc.internal.pageSize.height - pageBottomMargin) { doc.addPage(); return drawPageHeaderAndFooter(doc, doc.internal.getNumberOfPages(), totalPagesId); } return currentYPos; }
                    const categoryShells = specFormScope.querySelectorAll('#dynamicCategoriesContainer .dynamic-category-shell');
                    for (const categoryShell of categoryShells) {
                        const categoryHeader = categoryShell.querySelector('h2.dynamic-category-header'); const categoryName = categoryHeader.dataset.categoryName || "Custom Section"; const categoryNumber = categoryHeader.dataset.categoryNumber; yPosition = checkAddPage(yPosition, 15); doc.setFontSize(14); doc.setTextColor(40, 53, 147); doc.setFont('helvetica', 'bold'); doc.text(`${categoryNumber}. ${categoryName}`, pageMargin, yPosition); yPosition += 8;
                        let subSectionCounter = 1; const contentBlocks = categoryShell.querySelectorAll('.category-content-blocks-container .content-block');
                        for (const block of contentBlocks) {
                            const blockTitle = block.dataset.blockTitle || (block.classList.contains('table-block') ? "Data Table" : "Notes"); yPosition = checkAddPage(yPosition, 12); doc.setFontSize(12); doc.setTextColor(50, 50, 50); doc.setFont('helvetica', 'bold'); doc.text(`${categoryNumber}.${subSectionCounter++} ${blockTitle}`, contentTextIndent, yPosition); yPosition += 7; doc.setFontSize(11); doc.setTextColor(0, 0, 0); doc.setFont('helvetica', 'normal');
                            if (block.classList.contains('table-block')) {
                                const topRemarksTextarea = block.querySelector('.table-top-remarks .table-remarks-textarea'); const topRemarksCb = block.querySelector('.table-top-remarks .toggle-table-remarks-cb'); if (topRemarksCb && topRemarksCb.checked && topRemarksTextarea && topRemarksTextarea.value.trim()) { yPosition = checkAddPage(yPosition, 5); doc.setFont('helvetica', 'italic'); doc.setFontSize(10); const topRemarkLines = doc.splitTextToSize("Top Remarks: " + String(topRemarksTextarea.value.trim()), doc.internal.pageSize.width - nestedContentIndent - pageMargin - 5); topRemarkLines.forEach(line => { yPosition = checkAddPage(yPosition, 4.5); doc.text(line, nestedContentIndent, yPosition); yPosition += 4.5;}); yPosition += 3; doc.setFont('helvetica', 'normal'); doc.setFontSize(11); }
                                const tableElement = block.querySelector('.dynamic-table'); if (tableElement) { const headers = Array.from(tableElement.querySelectorAll('thead th:not(.action-column-header) .header-text-editable')).map(span => String(span.dataset.originalText || span.textContent.trim())); const tableRows = tableElement.querySelectorAll('tbody tr'); const bodyData = []; let hasAnyCellData = false; if (tableRows.length > 0) { tableRows.forEach(row => { const rowDataArray = []; const dataCellsInCurrentRow = Array.from(row.children).filter(td => !td.classList.contains('cell-actions')); for (let i = 0; i < headers.length; i++) { const cell = dataCellsInCurrentRow[i]; const input = cell ? cell.querySelector('input') : null; const value = input ? String(input.value.trim()) : ''; rowDataArray.push(value); if (value) hasAnyCellData = true; } bodyData.push(rowDataArray); });} if (headers.length > 0) { yPosition = checkAddPage(yPosition, 15); doc.autoTable({ head: [headers], body: bodyData, startY: yPosition, theme: 'grid', styles: { fontSize: 9, cellPadding: 1.5, lineColor: [180, 180, 180], lineWidth: 0.1, overflow: 'linebreak', font: 'helvetica' }, headStyles: { fillColor: [230, 230, 230], textColor: [0,0,0], fontStyle: 'bold', fontSize: 9.5, lineColor: [150, 150, 150], lineWidth: 0.1 }, margin: { left: nestedContentIndent, right: pageMargin }, tableWidth: 'auto', didDrawPage: (data) => { yPosition = drawPageHeaderAndFooter(doc, data.pageNumber, totalPagesId); data.cursor.y = yPosition; } }); yPosition = doc.autoTable.previous.finalY; if (!hasAnyCellData && bodyData.length > 0 && bodyData.some(row => row.length > 0)) { yPosition = checkAddPage(yPosition, 6); doc.setFontSize(9); doc.setFont('helvetica', 'italic'); doc.setTextColor(100,100,100); doc.text('Note: The table above contains no data in its cells.', nestedContentIndent, yPosition + 3); yPosition += 6;} else if (bodyData.length === 0 || (bodyData.length > 0 && !bodyData.some(row => row.length > 0 && row.some(cellVal => String(cellVal).trim() !=='')) )) { yPosition = checkAddPage(yPosition, 6); doc.setFontSize(9); doc.setFont('helvetica', 'italic'); doc.setTextColor(100,100,100); doc.text('Note: The table above has no data rows or no data in rows.', nestedContentIndent, yPosition + 3); yPosition += 6; } doc.setFontSize(11); doc.setFont('helvetica', 'normal'); doc.setTextColor(0,0,0); yPosition += 5; } else { yPosition = checkAddPage(yPosition, 6); doc.text('No headers defined for this table.', nestedContentIndent, yPosition); yPosition += 6; }} else { yPosition = checkAddPage(yPosition, 6); doc.text('Table element not found within block.', nestedContentIndent, yPosition); yPosition += 6; }
                                const bottomRemarksTextarea = block.querySelector('.table-bottom-remarks .table-remarks-textarea'); const bottomRemarksCb = block.querySelector('.table-bottom-remarks .toggle-table-remarks-cb'); if (bottomRemarksCb && bottomRemarksCb.checked && bottomRemarksTextarea && bottomRemarksTextarea.value.trim()) { yPosition = checkAddPage(yPosition, 5); doc.setFont('helvetica', 'italic'); doc.setFontSize(10); const bottomRemarkLines = doc.splitTextToSize("Bottom Remarks: " + String(bottomRemarksTextarea.value.trim()), doc.internal.pageSize.width - nestedContentIndent - pageMargin - 5); bottomRemarkLines.forEach(line => { yPosition = checkAddPage(yPosition, 4.5); doc.text(line, nestedContentIndent, yPosition); yPosition += 4.5;}); yPosition += 3; doc.setFont('helvetica', 'normal'); doc.setFontSize(11); }
                            } else if (block.classList.contains('text-block')) { 
                                const labelElement = block.querySelector('.text-block-label'); const labelText = labelElement ? String(labelElement.textContent.trim()) : ""; if (labelText && labelText.toLowerCase() !== "content") { yPosition = checkAddPage(yPosition, 5); doc.setFont('helvetica', 'italic'); doc.setTextColor(80, 80, 80); doc.setFontSize(10.5); doc.text(labelText + ":", nestedContentIndent, yPosition); yPosition += 5; doc.setFont('helvetica', 'normal'); doc.setTextColor(0, 0, 0); doc.setFontSize(11); } const editorTextarea = block.querySelector('.text-block-textarea-tinymce'); const editorInstance = tinymce.get(editorTextarea.id); let htmlContent = ""; if (editorInstance) htmlContent = String(editorInstance.getContent({format: 'html'})); if (htmlContent.trim() && htmlContent.trim() !== "<p><br data-mce-bogus=\"1\"></p>" && htmlContent.trim() !== "<p> </p>") { const tempDiv = document.createElement('div'); tempDiv.innerHTML = htmlContent; tempDiv.style.cssText = `font-family: helvetica, sans-serif; font-size: 10pt; line-height: 1.4; color: #333; width: ${doc.internal.pageSize.width - nestedContentIndent - pageMargin - 5}px; position: absolute; left: -9999px;`; document.body.appendChild(tempDiv); yPosition = checkAddPage(yPosition, 10); try { await doc.html(tempDiv, { x: nestedContentIndent, y: yPosition, width: doc.internal.pageSize.width - nestedContentIndent - pageMargin -5, windowWidth: (doc.internal.pageSize.width - nestedContentIndent - pageMargin -5) * (72/25.4) * 1.25, html2canvas: { scale: 1, logging: false, useCORS: true, dpi: 96 }, autoPaging: 'slice', margin: [0,0,0,0], pagesplit: true, callback: function(docInstance) { yPosition = docInstance.internal.y; if (docInstance.lastAutoTable && docInstance.lastAutoTable.finalY) yPosition = Math.max(yPosition, docInstance.lastAutoTable.finalY); }, didDrawPage: (data) => { yPosition = drawPageHeaderAndFooter(doc, data.pageNumber, totalPagesId); } }); yPosition = doc.internal.y;  } catch (error) { console.error("Error rendering HTML to PDF:", error); const textContent = String(tempDiv.innerText || tempDiv.textContent || "Error displaying content."); const textLines = doc.splitTextToSize(textContent, doc.internal.pageSize.width - nestedContentIndent - pageMargin - 10); textLines.forEach(line => { yPosition = checkAddPage(yPosition, 4.5); doc.text(line, nestedContentIndent, yPosition); yPosition += 4.5; }); } finally { document.body.removeChild(tempDiv); } yPosition = checkAddPage(yPosition + 5); } else { yPosition = checkAddPage(yPosition, 6); doc.setFont('helvetica', 'italic'); doc.setTextColor(150,150,150); doc.text('No main content entered for this block.', nestedContentIndent, yPosition); yPosition += 6; doc.setFont('helvetica', 'normal'); doc.setTextColor(0,0,0); }
                                const subTextItems = block.querySelectorAll('.sub-text-block-item'); if (subTextItems.length > 0) { yPosition = checkAddPage(yPosition + 2); for (const subItem of subTextItems) { const subLabelEl = subItem.querySelector('label'), subTextareaEl = subItem.querySelector('textarea'); const subLabelText = subLabelEl ? String(subLabelEl.textContent.trim()) : "Sub-Note:", subTextValue = subTextareaEl ? String(subTextareaEl.value.trim()) : ""; if (subTextValue) { yPosition = checkAddPage(yPosition, 5); doc.setFont('helvetica', 'italic'); doc.setFontSize(10); doc.setTextColor(100, 100, 100); doc.text(subLabelText, nestedContentIndent + 3, yPosition); yPosition += 5; doc.setFont('helvetica', 'normal'); doc.setFontSize(10.5); doc.setTextColor(0,0,0); const subTextLines = doc.splitTextToSize(subTextValue, doc.internal.pageSize.width - (nestedContentIndent + 6) - pageMargin - 5); subTextLines.forEach(line => { yPosition = checkAddPage(yPosition, 5); doc.text(line, nestedContentIndent + 6, yPosition); yPosition += 5; }); yPosition += 2; } const subSubTextItems = subItem.querySelectorAll('.sub-sub-text-block-item'); if (subSubTextItems.length > 0) { yPosition = checkAddPage(yPosition + 1); for (const subSubItem of subSubTextItems) { const subSubLabelEl = subSubItem.querySelector('label'), subSubTextareaEl = subSubItem.querySelector('textarea'); const subSubLabelText = subSubLabelEl ? String(subSubLabelEl.textContent.trim()) : "Sub-Sub-Note:", subSubTextValue = subSubTextareaEl ? String(subSubTextareaEl.value.trim()) : ""; if (subSubTextValue) { yPosition = checkAddPage(yPosition, 4); doc.setFont('helvetica', 'italic'); doc.setFontSize(9.5); doc.setTextColor(120, 120, 120); doc.text(subSubLabelText, nestedContentIndent + 6, yPosition); yPosition += 4; doc.setFont('helvetica', 'normal'); doc.setFontSize(10); doc.setTextColor(0,0,0); const subSubTextLines = doc.splitTextToSize(subSubTextValue, doc.internal.pageSize.width - (nestedContentIndent + 9) - pageMargin - 5); subSubTextLines.forEach(line => { yPosition = checkAddPage(yPosition, 4.5); doc.text(line, nestedContentIndent + 9, yPosition); yPosition += 4.5; }); yPosition += 1.5; } } } } } }
                            yPosition += 3;
                        }
                        yPosition += 4;
                    }
                    const totalPages = doc.internal.getNumberOfPages();
                    for (let i = 1; i <= totalPages; i++) { doc.setPage(i); drawPageHeaderAndFooter(doc, i, totalPages.toString()); }
                    return doc;
                }
                
                specFormScope.querySelector('#exportPdfBtn').addEventListener('click', async function() { if (!specFormScope.querySelector('#specForm').reportValidity()) { alert('Please fill in all required fields.'); return; } const doc = await generatePdfDocument(); doc.save('Raw_Material_Specification.pdf'); });
                specFormScope.querySelector('#previewPdfBtn').addEventListener('click', async function() { if (!specFormScope.querySelector('#specForm').reportValidity()) { alert('Please fill in all required fields.'); return; } try { const doc = await generatePdfDocument(); const pdfDataUri = doc.output('datauristring'); const previewWindow = window.open(); if (previewWindow) { previewWindow.document.write(`<iframe width='100%' height='100%' src='${pdfDataUri}#zoom=100' style='border:none; margin:0; padding:0; overflow:hidden;'></iframe>`); previewWindow.document.title = "PDF Preview"; previewWindow.document.body.style.margin = "0"; previewWindow.document.body.style.padding = "0"; previewWindow.document.body.style.overflow = "hidden"; } else alert("Popup blocked. Please allow popups for this site to preview the PDF."); } catch (e) { console.error("Error generating PDF for preview:", e); alert("Error generating PDF for preview. Check console for details."); }});
                specFormScope.querySelector('#clearFormBtn').addEventListener('click', function() { if (confirm('Are you sure you want to clear the entire form?')) { const allEditors = tinymce.get(); allEditors.forEach(editor => editor.remove()); specFormScope.querySelector('#specForm').reset(); dynamicCategoriesContainer.innerHTML = ''; specFormScope.querySelectorAll('h2.section-header.collapsible:not(.dynamic-category-header)').forEach(header => { const cw = header.nextElementSibling; if (cw) cw.classList.remove('collapsed'); header.classList.remove('collapsed'); const icon = header.querySelector('.toggle-icon'); if (icon) icon.textContent = '-'; }); ['dietaryType', 'materialOrigin'].forEach(name => { const radios = specFormScope.querySelectorAll(`input[name="${name}"]`); radios.forEach((rb, index) => rb.checked = (index === 0 && rb.required)); }); renumberDynamicCategoryTitles(); } });
                specFormScope.querySelector('#saveDraftBtn').addEventListener('click', () => alert('Draft saved! (Placeholder for actual save logic)'));
                
                specFormScope.querySelectorAll('h2.section-header.collapsible:not(.dynamic-category-header)').forEach(header => { const contentWrapper = header.nextElementSibling; if (contentWrapper) contentWrapper.classList.remove('collapsed'); const icon = header.querySelector('.toggle-icon'); if (icon) icon.textContent = '-'; });
                
                renumberDynamicCategoryTitles();

                if (dynamicCategoriesContainer.children.length === 0) {
                    specFormScope.querySelector('#addNewCategoryBtn').click();
                }
            }
            
            function addDataLabelsToCells() {
                const headers = Array.from(thead.querySelectorAll('th'));
                const headerTexts = headers.map(th => {
                    const span = th.querySelector('.th-content span');
                    return (span ? span.textContent : (th.textContent || "")).trim();
                });

                tbody.querySelectorAll('tr').forEach(row => {
                    row.querySelectorAll('td').forEach((td, index) => {
                        if (headerTexts[index]) {
                            td.setAttribute('data-label', headerTexts[index]);
                        }
                    });
                });
            }

            function initDashboardModals() {
                openCsvModalBtn.addEventListener('click', () => document.getElementById('csvImportModal').style.display = 'flex');
                closeModalBtns.forEach(btn => btn.addEventListener('click', () => {
                    const modalId = btn.getAttribute('data-target-modal');
                    const modalToClose = document.getElementById(modalId);
                    
                    if (modalId === 'specGeneratorModal') {
                        if (confirm('Are you sure you want to close?.')) {
                            modalToClose.style.display = 'none';
                            const clearBtn = modalToClose.querySelector('#clearFormBtn');
                            if (clearBtn) clearBtn.click();
                        }
                    } else {
                        modalToClose.style.display = 'none';
                    }
                }));
                modals.forEach(modal => modal.addEventListener('click', e => { if (e.target === modal) {
                    const modalId = modal.id;
                    if (modalId === 'specGeneratorModal') {
                         if (confirm('Are you sure you want to close? Any unsaved changes in the generator will be lost.')) {
                            modal.style.display = 'none';
                            const clearBtn = modal.querySelector('#clearFormBtn');
                            if (clearBtn) clearBtn.click();
                         }
                    } else {
                        modal.style.display = 'none';
                    }
                } }));
                // saveCommentBtn.addEventListener('click', () => { if (currentlyEditingCommentTarget) { const newComment = commentTextarea.value.trim(); currentlyEditingCommentTarget.textContent = newComment || 'No comment.'; commentModal.style.display = 'none'; currentlyEditingCommentTarget = null; } });
            
            //     saveCommentBtn.addEventListener('click', () => {
            //     // if (!currentlyEditingCommentTarget) return;
            //     const newComment = commentTextarea.value.trim() || 'No comment.';
            //     const row = currentlyEditingCommentTarget.closest('tr[data-supplier-id]');
            //     const supplierId = row.dataset.supplierId;
            //     const statusCheckbox = row.querySelector('.status-checkbox');
            //     const newStatus = statusCheckbox.checked ? 1 : 0; 
            //     currentlyEditingCommentTarget.textContent = newComment;
            //     commentModal.style.display = 'none';
            //     fetch("{{ url('new-supplier/save-comment') }}/" + supplierId, {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //         },
            //         body: JSON.stringify({ 
            //             comment: newComment,
            //             status: newStatus 
            //         })
            //     })
            //     .then(res => res.json())
            //     .then(data => {
            //         if (data.success) {
            //             toastr.success('Comment and status updated successfully!');
            //             // const statusText = row.querySelector('.status-text');
            //             // statusText.textContent = newStatus === 1 ? 'Active' : 'Inactive';
            
            //             // const dateSpan = row.querySelector('.status-update-date');
            //             // if (dateSpan) dateSpan.textContent = data.updated_at; 
            //              setTimeout(() => {
            //                     window.location.reload();
            //                 }, 1000);
                        
            //         } else {
            //             toastr.error('Failed to update.');
            //             currentlyEditingCommentTarget.textContent = data.oldComment || 'No comment.';
            //         }
            //     })
            //     .catch(err => {
            //         console.error(err);
            //         toastr.error('Error while saving comment and status.');
            //     });
            
            //     currentlyEditingCommentTarget = null;
            // });
            
            
            saveCommentBtn.addEventListener('click', () => {
                const newComment = commentTextarea.value.trim() || 'No comment.';
            
                const supplierId = document.getElementById('supplier_id_input_1').value;
            
                if (!supplierId) {
                    toastr.error("Supplier ID not found!");
                    return;
                }
            
                const row = document.querySelector(`tr[data-supplier-id="${supplierId}"]`);
                if (!row) {
                    toastr.error("Row not found!");
                    return;
                }
            
                const statusCheckbox = row.querySelector('.status-checkbox');
                const newStatus = statusCheckbox.checked ? 1 : 0;
            
                const commentSpan = row.querySelector('.comment-text');
                if (commentSpan) {
                    commentSpan.textContent = newComment;
                }
            
                commentModal.style.display = 'none';
            
                fetch("{{ url('new-supplier/save-comment') }}/" + supplierId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        comment: newComment,
                        status: newStatus 
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Comment and status updated successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error('Failed to update.');
                        if (commentSpan) {
                            commentSpan.textContent = data.oldComment || 'No comment.';
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Error while saving comment and status.');
                });
            });


            }
            
            function initCsvDownload() { csvSampleBtn.addEventListener('click', () => { const blob = new Blob([csvSampleData], { type: 'text/csv' }); const url = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = url; a.download = 'category_import_sample.csv'; document.body.appendChild(a); a.click(); document.body.removeChild(a); URL.revokeObjectURL(url); }); }
            // function initCsvUpload() { csvUploadBtn.addEventListener('click', () => csvFileInput.click()); csvFileInput.addEventListener('change', e => e.target.files.length > 0 && handleCsvFile(e.target.files[0])); csvUploadArea.addEventListener('dragover', e => { e.preventDefault(); csvUploadArea.classList.add('drag-over'); }); csvUploadArea.addEventListener('dragleave', () => csvUploadArea.classList.remove('drag-over')); csvUploadArea.addEventListener('drop', e => { e.preventDefault(); csvUploadArea.classList.remove('drag-over'); e.dataTransfer.files.length > 0 && handleCsvFile(e.dataTransfer.files[0]); }); }
           function initCsvUpload() {
                // Trigger file input when the "Select File" button is clicked
                csvUploadBtn.addEventListener('click', () => {
                    csvFileInput.click();
                });
            
                // Handle file selection, but do not upload automatically
                csvFileInput.addEventListener('change', e => {
                    const file = e.target.files[0];
                    if (file) {
                        // Show selected file name (No automatic upload here)
                        document.getElementById('csvSelectedFile').textContent = `Selected: ${file.name}`;
                    }
                });
            
                // Handle dragover to show feedback when a file is dragged over the area
                csvUploadArea.addEventListener('dragover', e => {
                    e.preventDefault();
                    csvUploadArea.classList.add('drag-over');
                });
            
                // Handle dragleave to remove feedback when a file is dragged out
                csvUploadArea.addEventListener('dragleave', () => {
                    csvUploadArea.classList.remove('drag-over');
                });
            
                // Handle drop of a file into the area, but do not upload automatically
                csvUploadArea.addEventListener('drop', e => {
                    e.preventDefault();
                    csvUploadArea.classList.remove('drag-over');
                    const file = e.dataTransfer.files[0];
                    if (file) {
                        // Show selected file name (No automatic upload here)
                        document.getElementById('csvSelectedFile').textContent = `Selected: ${file.name}`;
                    }
                });
            
                // Handle the Upload button click (this will trigger the actual file upload)
                document.getElementById('csvSubmitBtn').addEventListener('click', function () {
                    const fileInput = csvFileInput;
                    if (fileInput.files.length > 0) {
                        const file = fileInput.files[0];
            
                        // Simulate the file upload logic (e.g., send via AJAX or submit form)
                        // For now, just show a success message
                        document.getElementById('csvUploadStatus').textContent = `File "${file.name}" uploaded successfully!`;
                    } else {
                        document.getElementById('csvUploadStatus').textContent = 'Please select a file first!';
                    }
                });
            }

            function handleCsvFile(file) { if (!file.name.toLowerCase().endsWith('.csv')) return showCsvStatus('Please upload a valid CSV file', 'error'); csvSelectedFile.innerHTML = `<i class="fas fa-file-csv"></i> Selected file: ${file.name}`; const reader = new FileReader(); reader.onload = e => { try { const results = parseCsv(e.target.result); if (results.length > 0) { processCsvData(results); showCsvStatus(`Successfully imported ${results.length} categories`, 'success'); addImportedCategoriesToTable(results); setTimeout(() => document.getElementById('csvImportModal').style.display = 'none', 1500); } else showCsvStatus('CSV file is empty or invalid format', 'error'); } catch (error) { showCsvStatus('Error processing CSV file: ' + error.message, 'error'); console.error(error); } }; reader.onerror = () => showCsvStatus('Error reading file', 'error'); reader.readAsText(file); }
            function parseCsv(csvData) { const lines = csvData.split('\n').filter(line => line.trim() !== ''); if (lines.length < 2) throw new Error('CSV file must contain at least one data row'); const headers = lines[0].split(',').map(h => h.trim()); const requiredHeaders = ['Product Category', 'Sub Category', 'Specific Subcategory']; if (requiredHeaders.some(h => !headers.includes(h))) throw new Error(`CSV is missing required headers: ${requiredHeaders.join(', ')}`); const results = []; for (let i = 1; i < lines.length; i++) { const values = lines[i].split(',').map(v => v.trim()); if (values.length >= 3) { results.push({'Product Category': values[0] || null, 'Sub Category': values[1] || null, 'Specific Subcategory': values[2] || null}); } } if (results.length === 0) throw new Error('No valid data rows found in CSV'); return results; }
            function processCsvData(csvData) { csvData.forEach(row => { const [category, subCategory, specificSub] = [row['Product Category'], row['Sub Category'], row['Specific Subcategory']]; if (!category) return; if (!existingCategories.has(category)) { existingCategories.add(category); categoryData[category] = {}; } if (!subCategory) return;
            
            if (!existingSubCategories.has(subCategory)) existingSubCategories.add(subCategory); if (!categoryData[category][subCategory]) categoryData[category][subCategory] = []; if (!specificSub) return; if (!existingSpecificSubcategories.has(specificSub)) existingSpecificSubcategories.add(specificSub); if (!categoryData[category][subCategory].includes(specificSub)) categoryData[category][subCategory].push(specificSub); }); }
            function addImportedCategoriesToTable(csvData) { csvSelectedFile.textContent = ''; csvData.forEach(row => addNewRowWithData(row['Product Category'], row['Sub Category'], row['Specific Subcategory'])); }
            function addNewRowWithData(category, subCategory, specificSub) {
                const rowCount = tbody.querySelectorAll('tr').length + 1;
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td data-label="Select"><input type="checkbox" class="row-checkbox"></td>
                    <td data-label="#">${rowCount}</td>
                    <td data-label="Product Category">${category || '<span class="not-specified">Not specified</span>'}</td>
                    <td data-label="Sub Category">${subCategory || '<span class="not-specified">Not specified</span>'}</td>
                    <td data-label="Specific Subcategory">${specificSub || '<span class="not-specified">Not specified</span>'}</td>
                    <td data-label="Material"><div class="material-display"><span class="material-tag not-specified">Not selected</span><button class="edit-material-btn" title="Edit materials"><i class="fas fa-edit"></i></button></div></td>
                    <td data-label="Actions"><div class="action-buttons"><button class="btn btn-success btn-sm edit-btn" title="Edit"><i class="fas fa-edit"></i></button><button class="btn btn-danger btn-sm delete-btn" title="Delete"><i class="fas fa-trash"></i></button></div></td>
                    <td data-label="Specification"><div class="spec-buttons">
                    <button class="btn btn-success spec-edit-btn" style="padding: 6px 12px;font-size: 13px;background-color: #4cc9f0;color: white;"><i class="fas fa-edit">
                    </i> Upload</button><button class="btn btn-warning" style="padding: 6px 12px;font-size: 13px;background-color: #f8961e;color: white;">
                    <i class="fas fa-file-alt"></i> Draft</button><div class="spec-buttons-inline-group">
                    </div>
                    <div class="last-updated">Last updated: <span class="update-time">${getCurrentDateTime()}</span></div></div></td>
                    <td data-label="Status"><div class="status-cell-content"><div class="status-main"><label class="status-toggle"><input type="checkbox" class="status-checkbox"><span class="slider"></span></label><span class="status-text inactive">Inactive</span></div><div class="status-details hidden"><div class="status-date">Date: <span></span></div><div class="status-comment"><span class="comment-text"></span><i class="fas fa-pencil-alt edit-comment-icon" title="Add/Edit Comment"></i></div></div></div></td>
                `;
                tbody.insertBefore(newRow, tbody.firstChild);
                updateSerialNumbers();
                newRow.querySelector('.edit-btn').click(); 
            }
            function showCsvStatus(message, type) { csvUploadStatus.innerHTML = type === 'success' ? `<i class="fas fa-check-circle"></i> ${message}` : `<i class="fas fa-exclamation-circle"></i> ${message}`; csvUploadStatus.className = 'csv-upload-status ' + type; setTimeout(() => { csvUploadStatus.style.opacity = '0'; setTimeout(() => { csvUploadStatus.style.display = 'none'; csvUploadStatus.style.opacity = '1'; }, 300); }, 5000); }
            function initBulkActions() { const updateBulkActions = () => { const checkedBoxes = tbody.querySelectorAll('.row-checkbox:checked'); bulkActions.classList.toggle('show', checkedBoxes.length > 0); if (checkedBoxes.length > 0) bulkSelectionCount.textContent = `${checkedBoxes.length} product${checkedBoxes.length > 1 ? 's' : ''} selected`; }; selectAllCheckbox.addEventListener('change', function() { tbody.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked); updateBulkActions(); }); tbody.addEventListener('change', e => { if (e.target.classList.contains('row-checkbox')) { const allCheckboxes = tbody.querySelectorAll('.row-checkbox'); const checkedCount = tbody.querySelectorAll('.row-checkbox:checked').length; selectAllCheckbox.checked = checkedCount === allCheckboxes.length; selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < allCheckboxes.length; updateBulkActions(); } }); bulkDeleteBtn.addEventListener('click', () => { const selectedRows = Array.from(tbody.querySelectorAll('.row-checkbox:checked')).map(cb => cb.closest('tr')); if (selectedRows.length === 0) return; if (confirm(`Are you sure you want to delete ${selectedRows.length} product${selectedRows.length > 1 ? 's' : ''}?`)) { deletedRows = selectedRows.map(row => ({ element: row, data: row.innerHTML, position: Array.from(tbody.children).indexOf(row) })); selectedRows.forEach(row => { row.classList.add('fade-out'); setTimeout(() => { row.remove(); updateSerialNumbers(); }, 300); }); showUndoNotification(`${selectedRows.length} product${selectedRows.length > 1 ? 's' : ''} deleted`); bulkActions.classList.remove('show'); selectAllCheckbox.checked = false; } }); bulkDeselectBtn.addEventListener('click', () => { tbody.querySelectorAll('.row-checkbox:checked').forEach(cb => cb.checked = false); updateBulkActions(); selectAllCheckbox.checked = false; selectAllCheckbox.indeterminate = false; }); bulkEditBtn.addEventListener('click', () => alert(`Bulk edit for ${Array.from(tbody.querySelectorAll('.row-checkbox:checked')).length} products would open here`)); }
            function initUndoFunctionality() { undoActionBtn.addEventListener('click', () => { if (deletedRows.length === 0) return; deletedRows.sort((a,b) => a.position - b.position).forEach(rowData => { const newRow = document.createElement('tr'); newRow.innerHTML = rowData.data; if (tbody.children[rowData.position]) { tbody.insertBefore(newRow, tbody.children[rowData.position]); } else { tbody.appendChild(newRow); } }); updateSerialNumbers(); hideUndoNotification(); deletedRows = []; }); }
            function showUndoNotification(message) { undoMessage.textContent = message; undoNotification.classList.add('show'); setTimeout(() => { if (undoNotification.classList.contains('show')) { hideUndoNotification(); deletedRows = []; } }, 8000); }
            function hideUndoNotification() { undoNotification.classList.remove('show'); }
            function makeRowEditable(row) { const [catText, subText, specText] = [row.cells[2].textContent.trim(), row.cells[3].textContent.trim(), row.cells[4].textContent.trim()]; const isNotSpecified = text => text === 'Not specified' || text === ''; originalRowData = { html: Array.from(row.cells).map(cell => cell.innerHTML), values: { category: isNotSpecified(catText) ? '' : catText, subCategory: isNotSpecified(subText) ? '' : subText, specificSub: isNotSpecified(specText) ? '' : specText }}; row.classList.add('editable-row'); row.cells[2].innerHTML = `<div class="searchable-dropdown"><input type="text" class="category-search" placeholder="Search or add category" value="${originalRowData.values.category}"><div class="dropdown-options category-options"></div></div>`; row.cells[3].innerHTML = `<div class="searchable-dropdown"><input type="text" class="subcategory-search" placeholder="Search or add sub-category" value="${originalRowData.values.subCategory}"><div class="dropdown-options subcategory-options"></div></div>`; row.cells[4].innerHTML = `<div class="searchable-dropdown"><input type="text" class="specific-subcategory-search" placeholder="Search or add specific subcategory" value="${originalRowData.values.specificSub}"><div class="dropdown-options specific-subcategory-options"></div></div>`; const [catInput, subInput, specInput] = [row.querySelector('.category-search'), row.querySelector('.subcategory-search'), row.querySelector('.specific-subcategory-search')]; const [hasCat, hasSub] = [originalRowData.values.category !== '', originalRowData.values.subCategory !== '']; catInput.disabled = hasSub; subInput.disabled = originalRowData.values.specificSub !== '' || !hasCat; specInput.disabled = !hasSub; initSearchableDropdown(row, 'category'); initSearchableDropdown(row, 'subcategory'); initSearchableDropdown(row, 'specific-subcategory'); row.cells[6].innerHTML = `<div class="action-buttons"><button class="btn btn-success save-btn"  style="padding: 19px 8px;font-size: 13px;background-color: #4cc9f0;color: white;" title="Save"><i class="fas fa-save"></i></button><button class="btn btn-danger cancel-btn"  style="padding: 19px 8px;font-size: 13px;background-color: #f72585;color: white;"title="Cancel"><i class="fas fa-times"></i></button></div>`; }
            function initSearchableDropdown(row, type) { const input = row.querySelector(`.${type}-search`); 
            const optionsContainer = row.querySelector(`.${type}-options`); const populateOptions = () => { let options = []; const catVal = row.querySelector('.category-search').value, subVal = row.querySelector('.subcategory-search').value; if (type === 'category') options = Array.from(existingCategories); else if (type === 'subcategory') options = catVal && categoryData[catVal] ? Object.keys(categoryData[catVal]) : []; else if (type === 'specific-subcategory') options = catVal && subVal && categoryData[catVal]?.[subVal] ? categoryData[catVal][subVal] : []; updateDropdownOptions(input.value, options, optionsContainer, type, row); }; input.addEventListener('input', populateOptions); input.addEventListener('focus', () => { populateOptions(); optionsContainer.classList.add('show'); }); document.addEventListener('click', e => { if (!input.closest('.searchable-dropdown').contains(e.target)) optionsContainer.classList.remove('show'); }); input.addEventListener('change', () => { const subcategoryInput = row.querySelector('.subcategory-search'), specificSubInput = row.querySelector('.specific-subcategory-search'); if (type === 'category') { subcategoryInput.value = ''; specificSubInput.value = ''; subcategoryInput.disabled = !(input.value && categoryData[input.value]); specificSubInput.disabled = true; } else if (type === 'subcategory') { specificSubInput.value = ''; specificSubInput.disabled = !(input.value && categoryData[row.querySelector('.category-search').value]?.[input.value]); } }); }
            function updateDropdownOptions(searchTerm, options, container, type, row) { container.innerHTML = ''; options.filter(opt => opt.toLowerCase().includes(searchTerm.toLowerCase())).forEach(option => { const optionEl = document.createElement('div'); optionEl.className = 'dropdown-option'; optionEl.textContent = option; optionEl.addEventListener('click', () => { container.previousElementSibling.value = option; container.classList.remove('show'); container.previousElementSibling.dispatchEvent(new Event('change', { bubbles: true })); }); container.appendChild(optionEl); }); if (searchTerm && !options.map(o => o.toLowerCase()).includes(searchTerm.toLowerCase())) { const addNewEl = document.createElement('div'); addNewEl.className = 'add-new-option'; addNewEl.innerHTML = `<i class="fas fa-plus"></i> Add "${searchTerm}"`; addNewEl.addEventListener('click', () => { const input = container.previousElementSibling; input.value = searchTerm; container.classList.remove('show'); const [catVal, subVal] = [row.querySelector('.category-search').value, row.querySelector('.subcategory-search').value]; if (type === 'category' && !categoryData[searchTerm]) { existingCategories.add(searchTerm); categoryData[searchTerm] = {}; } else if (type === 'subcategory' && catVal && categoryData[catVal] && !categoryData[catVal][searchTerm]) { existingSubCategories.add(searchTerm); categoryData[catVal][searchTerm] = []; } else if (type === 'specific-subcategory' && catVal && subVal && categoryData[catVal]?.[subVal] && !categoryData[catVal][subVal].includes(searchTerm)) { existingSpecificSubcategories.add(searchTerm); categoryData[catVal][subVal].push(searchTerm); } input.dispatchEvent(new Event('change', { bubbles: true })); }); container.appendChild(addNewEl); } }
            function initMaterialModal() { materialSearchInput.addEventListener('input', function() { const searchTerm = this.value.toLowerCase(); materialList.querySelectorAll('.material-list-item').forEach(item => { item.style.display = item.querySelector('label').textContent.toLowerCase().includes(searchTerm) ? '' : 'none'; }); }); 
           
            // saveMaterialBtn.addEventListener('click', () => { if (!currentlyEditingMaterialCell) return; 
            // const selected = Array.from(materialList.querySelectorAll('input:checked')).map(input => input.value); 
            // const tagsHtml = selected.length > 0 ? selected.map(m => `<span class="material-tag">${m}</span>`).join('') : '<span class="material-tag not-specified">Not selected</span>'; 
            // currentlyEditingMaterialCell.innerHTML = `<div class="material-display">${tagsHtml}<button class="edit-material-btn" title="Edit materials"><i class="fas fa-edit"></i></button></div>`;
            // materialEditModal.style.display = 'none'; currentlyEditingMaterialCell = null; });
            
                        saveMaterialBtn.addEventListener('click', () => {
                        if (!currentlyEditingMaterialCell) return;
                    
                        const supplierRow = currentlyEditingMaterialCell.closest("tr");
                        const supplierId = supplierRow.getAttribute("data-supplier-id");
                    
                        const selected = Array.from(materialList.querySelectorAll('input:checked')).map(input => input.value);
                    
                        fetch("{{ url('new-supplier/edit-material') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                supplier_id: supplierId,
                                materials: selected
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const tagsHtml = selected.length > 0 
                                    ? selected.map(m => `<span class="material-tag">${m}</span>`).join('') 
                                    : '<span class="material-tag not-specified">Not selected</span>';
                    
                                currentlyEditingMaterialCell.innerHTML = `
                                    <div class="material-display">
                                        ${tagsHtml}
                                        <button class="edit-material-btn" title="Edit materials"><i class="fas fa-edit"></i></button>
                                    </div>
                                `;
                    
                              toastr.success("Materials updated successfully!");
                            } else {
                                toastr.error("Failed to save materials.");
                            }
                    
                            materialEditModal.style.display = 'none';
                            currentlyEditingMaterialCell = null;
                        })
                        .catch(err => {
                            console.error(err);
                            toastr.error("Error while saving data.");
                        });
                    });

                   }
            

            function openMaterialModal(materialCell) { currentlyEditingMaterialCell = materialCell; const currentMaterials = new Set(Array.from(materialCell.querySelectorAll('.material-tag:not(.not-specified)')).map(tag => tag.textContent)); materialList.innerHTML = predefinedMaterials.map(material => `<li class="material-list-item"><input type="checkbox" id="mat-${material}" value="${material}" ${currentMaterials.has(material) ? 'checked' : ''}><label for="mat-${material}">${material}</label></li>`).join(''); materialSearchInput.value = ''; materialSearchInput.dispatchEvent(new Event('input')); materialEditModal.style.display = 'flex'; }
            // function saveRowEdits(row) { const [newCat, newSub, newSpec] = [row.querySelector('.category-search').value.trim(), row.querySelector('.subcategory-search').value.trim(), row.querySelector('.specific-subcategory-search').value.trim()]; const oldVals = originalRowData.values; if (newCat && oldVals.category && newCat !== oldVals.category) { updateMasterData('category', oldVals.category, newCat); updateTableRows('category', oldVals.category, newCat); } if (newSub && oldVals.subCategory && newSub !== oldVals.subCategory) { updateMasterData('subcategory', oldVals.subCategory, newSub, newCat); updateTableRows('subcategory', oldVals.subCategory, newSub, newCat); } if (newSpec && oldVals.specificSub && newSpec !== oldVals.specificSub) { updateMasterData('specific-subcategory', oldVals.specificSub, newSpec, newCat, newSub); updateTableRows('specific-subcategory', oldVals.specificSub, newSpec, newCat, newSub); } row.cells[2].innerHTML = newCat || '<span class="not-specified">Not specified</span>'; row.cells[3].innerHTML = newSub || '<span class="not-specified">Not specified</span>'; row.cells[4].innerHTML = newSpec || '<span class="not-specified">Not specified</span>'; row.querySelector('.update-time').textContent = getCurrentDateTime(); row.cells[6].innerHTML = `<div class="action-buttons"><button class="btn btn-success btn-sm edit-btn" title="Edit"><i class="fas fa-edit"></i></button><button class="btn btn-danger btn-sm delete-btn" title="Delete"><i class="fas fa-trash"></i></button></div>`; row.classList.remove('editable-row'); originalRowData = null; }
         
            function saveRowEdits(row) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
                const [newCat, newSub, newSpec] = [
                    row.querySelector('.category-search').value.trim(),
                    row.querySelector('.subcategory-search').value.trim(),
                    row.querySelector('.specific-subcategory-search').value.trim()
                ];
            
                const oldVals = originalRowData.values;
                let rowId = row.dataset.supplierId;
                fetch("{{ url('new-supplier/add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id: rowId,
                        category: newCat,
                        sub_category: newSub,
                        specific_sub: newSpec
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (newCat && oldVals.category && newCat !== oldVals.category) {
                            updateMasterData('category', oldVals.category, newCat);
                            updateTableRows('category', oldVals.category, newCat);
                        }
                        if (newSub && oldVals.subCategory && newSub !== oldVals.subCategory) {
                            updateMasterData('subcategory', oldVals.subCategory, newSub, newCat);
                            updateTableRows('subcategory', oldVals.subCategory, newSub, newCat);
                        }
                        if (newSpec && oldVals.specificSub && newSpec !== oldVals.specificSub) {
                            updateMasterData('specific-subcategory', oldVals.specificSub, newSpec, newCat, newSub);
                            updateTableRows('specific-subcategory', oldVals.specificSub, newSpec, newCat, newSub);
                        }
            
                        row.cells[2].innerHTML = newCat || '<span class="not-specified">Not specified</span>';
                        row.cells[3].innerHTML = newSub || '<span class="not-specified">Not specified</span>';
                        row.cells[4].innerHTML = newSpec || '<span class="not-specified">Not specified</span>';
                        row.querySelector('.update-time').textContent = getCurrentDateTime();
            
                        row.cells[6].innerHTML = `
                            <div class="action-buttons">
                                <button class="btn btn-success btn-sm edit-btn" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm delete-btn" title="Delete"><i class="fas fa-trash"></i></button>
                            </div>`;
            
                        row.classList.remove('editable-row');
                        originalRowData = null;
            
                       toastr.success(data.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        alert("Failed to save changes");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Error saving changes");
                });
            }
            
            function getCurrentDateTime() {
                const now = new Date();
                return now.getFullYear() + "-" +
                   String(now.getMonth() + 1).padStart(2, '0') + "-" +
                   String(now.getDate()).padStart(2, '0') + " " +
                   String(now.getHours()).padStart(2, '0') + ":" +
                   String(now.getMinutes()).padStart(2, '0');
            }
           
            function cancelRowEdits(row) { originalRowData.html.forEach((html, i) => { row.cells[i].innerHTML = html; }); row.classList.remove('editable-row'); originalRowData = null; }
            function updateMasterData(level, oldName, newName, p1, p2) { if (level === 'category') { if (categoryData[oldName]) { categoryData[newName] = categoryData[oldName]; delete categoryData[oldName]; } existingCategories.delete(oldName); existingCategories.add(newName); } else if (level === 'subcategory') { if (p1 && categoryData[p1]?.[oldName]) { categoryData[p1][newName] = categoryData[p1][oldName]; delete categoryData[p1][oldName]; } existingSubCategories.delete(oldName); existingSubCategories.add(newName); } else if (level === 'specific-subcategory') { if (p1 && p2 && categoryData[p1]?.[p2]) { const list = categoryData[p1][p2]; const idx = list.indexOf(oldName); if (idx > -1) list[idx] = newName; } existingSpecificSubcategories.delete(oldName); existingSpecificSubcategories.add(newName); } }
            function updateTableRows(level, oldName, newName, p1, p2) { tbody.querySelectorAll('tr:not(.editable-row)').forEach(row => { const [catCell, subCell, specCell] = [row.cells[2], row.cells[3], row.cells[4]]; if (level === 'category' && catCell.textContent.trim() === oldName) catCell.textContent = newName; else if (level === 'subcategory' && catCell.textContent.trim() === p1 && subCell.textContent.trim() === oldName) subCell.textContent = newName; else if (level === 'specific-subcategory' && catCell.textContent.trim() === p1 && subCell.textContent.trim() === p2 && specCell.textContent.trim() === oldName) specCell.textContent = newName; }); }
            function openFilterPopup(filterIcon) { specFilterPopup.style.display = 'none'; const th = filterIcon.closest('th'); const colIndex = th.cellIndex; const headerText = th.querySelector('.th-content span').textContent; const values = new Set(); tbody.querySelectorAll('tr').forEach(row => { const cell = row.cells[colIndex]; if (!cell) return; if (colIndex === 5) { if (cell.querySelector('.not-specified')) values.add('Not selected'); else cell.querySelectorAll('.material-tag').forEach(tag => values.add(tag.textContent)); } else if (colIndex === 8) { const statusText = cell.querySelector('.status-text'); if (statusText) values.add(statusText.textContent); } else { if (cell.querySelector('.not-specified')) values.add('Not Specified'); else values.add(cell.textContent.trim()); } }); filterPopupTitle.textContent = `Filter by ${headerText}`; filterPopupChecklist.innerHTML = ''; const currentColumnFilters = activeFilters[colIndex] || []; [...values].sort().forEach(value => { const isChecked = currentColumnFilters.includes(value); filterPopupChecklist.innerHTML += `<label><input type="checkbox" value="${value}" ${isChecked ? 'checked' : ''}><span>${value}</span></label>`; }); 
            const rect = filterIcon.getBoundingClientRect(); 
            filterPopup.style.position = 'absolute';
            filterPopup.style.top = `${rect.bottom + window.scrollY + 5}px`; 
            filterPopup.style.left = `${Math.max(10, rect.left + window.scrollX - (filterPopup.offsetWidth / 2) + (rect.width / 2))}px`;
            filterPopup.style.transform = '';

            if (window.innerWidth <= 768) {
                 filterPopup.style.position = 'fixed';
                 filterPopup.style.top = '50%';
                 filterPopup.style.left = '50%';
                 filterPopup.style.transform = 'translate(-50%, -50%)';
            }
            
            filterPopup.style.display = 'flex'; filterPopup.dataset.columnIndex = colIndex; filterPopupSearch.value = ''; filterPopupSearch.focus(); 
            }
            function openSpecFilterPopup(filterIcon) { filterPopup.style.display = 'none'; const rect = filterIcon.getBoundingClientRect(); 
            
            specFilterPopup.style.position = 'absolute';
            specFilterPopup.style.top = `${rect.bottom + window.scrollY + 5}px`;
            const popupLeft = rect.left + window.scrollX - specFilterPopup.offsetWidth + rect.width; 
            specFilterPopup.style.left = `${Math.max(10, popupLeft)}px`;
            specFilterPopup.style.transform = '';

            if(window.innerWidth <= 768) {
                specFilterPopup.style.position = 'fixed';
                specFilterPopup.style.top = '50%';
                specFilterPopup.style.left = '50%';
                specFilterPopup.style.transform = 'translate(-50%, -50%)';
            }
            specFilterPopup.style.display = 'flex';
            }
            function applyAllFilters() { 
                // const checklistFilterKeys = Object.keys(activeFilters).filter(k => k !== 'specification'); 
                //  alert(checklistFilterKeys);

                const checklistFilterKeys = Object.keys(activeFilters).filter(k => k !== 'specification');

                const specFilter = activeFilters.specification; tbody.querySelectorAll('tr').forEach(row => { 
                    //   alert(row);
                    let isVisible = true; 
                    //  alert(isVisible);
                    for (const colIndex of checklistFilterKeys)
                    {
                        // alert(colIndex);
                        const filterValues = activeFilters[colIndex]; 
                        if (!filterValues || filterValues.length === 0) continue; 
                        const cell = row.cells[colIndex]; let cellContent = [];
                        // alert(colIndex);
                        if (colIndex == 5) { 
                            //  alert('5');
                            const tags = cell.querySelectorAll('.material-tag:not(.not-specified)'); 
                            if (tags.length === 0) cellContent.push('Not selected'); 
                            else tags.forEach(tag => cellContent.push(tag.textContent));
                            } else if (colIndex == 8) { 
                                // alert('8');
                                cellContent.push(cell.querySelector('.status-text')?.textContent || ''); 
                                
                            } else {
                                //   alert('other');
                                if (cell.querySelector('.not-specified')) cellContent.push('Not Specified'); 
                                else cellContent.push(cell.textContent.trim()); } 
                                if (!filterValues.some(filterValue => cellContent.includes(filterValue))) { isVisible = false; break; } }
                                if (!isVisible) { row.style.display = 'none'; return; } 
                                const specCell = row.cells[7];
                                if (specFilter.availability !== 'all') { 
                                    const isActuallyAvailable = !specCell.querySelector('.btn-warning'); 
                                    if (specFilter.availability === 'available' && !isActuallyAvailable) isVisible = false; 
                                    if (specFilter.availability === 'not-available' && isActuallyAvailable) isVisible = false; 
                                    
                                } if (isVisible && (specFilter.from || specFilter.to)) {
                                    const dateSpan = specCell.querySelector('.update-time'); 
                                    if (dateSpan) { const rowDateStr = dateSpan.textContent.split(' ')[0]; const rowDate = new Date(rowDateStr); rowDate.setHours(0,0,0,0); if (specFilter.from) { const fromDate = new Date(specFilter.from); fromDate.setHours(0,0,0,0); if (rowDate < fromDate) isVisible = false; } if (isVisible && specFilter.to) { const toDate = new Date(specFilter.to); toDate.setHours(0,0,0,0); if (rowDate > toDate) isVisible = false; } } else { isVisible = false; } } row.style.display = isVisible ? '' : 'none'; }); updateSerialNumbers(); }
            
            
            
                        
            
            
//             function applyAllFilters() {
//     const checklistFilterKeys = Object.keys(activeFilters).filter(k => k !== 'specification');
//     const specFilter = activeFilters.specification;

//     tbody.querySelectorAll('tr').forEach(row => {
//         let isVisible = true;

//         // -------------------------------
//         // 1. Checklist filters (if exist)
//         // -------------------------------
//         for (const colIndex of checklistFilterKeys) {
//             const filterValues = activeFilters[colIndex];
//             if (!filterValues || filterValues.length === 0) continue;

//             const cell = row.cells[colIndex];
//             let cellContent = [];

//             if (colIndex == 5) {
//                 const tags = cell.querySelectorAll('.material-tag:not(.not-specified)');
//                 if (tags.length === 0) cellContent.push('Not selected');
//                 else tags.forEach(tag => cellContent.push(tag.textContent));
//             } else if (colIndex == 8) {
//                 cellContent.push(cell.querySelector('.status-text')?.textContent || '');
//             } else {
//                 if (cell.querySelector('.not-specified')) cellContent.push('Not Specified');
//                 else cellContent.push(cell.textContent.trim());
//             }

//             if (!filterValues.some(filterValue => cellContent.includes(filterValue))) {
//                 isVisible = false;
//                 break;
//             }
//         }

//         // -------------------------------
//         // 2. Always check Specification column (colIndex == 7)
//         // -------------------------------
//         // if (isVisible && specFilter) {
//         //     const specCell = row.cells[7];
//         //     if (specFilter.availability && specFilter.availability !== 'all') {
//         //         const isActuallyAvailable = !specCell.querySelector('.btn-warning');
//         //         if (specFilter.availability === 'available' && !isActuallyAvailable) isVisible = false;
//         //         if (specFilter.availability === 'not-available' && isActuallyAvailable) isVisible = false;
//         //     }

//         //     // Date range filter
//         //     if (isVisible && (specFilter.from || specFilter.to)) {
//         //         const dateSpan = specCell.querySelector('.update-time');
//         //         if (dateSpan) {
//         //             const rowDateStr = dateSpan.textContent.split(' ')[0];
//         //             const rowDate = new Date(rowDateStr);
//         //             rowDate.setHours(0, 0, 0, 0);

//         //             if (specFilter.from) {
//         //                 const fromDate = new Date(specFilter.from);
//         //                 fromDate.setHours(0, 0, 0, 0);
//         //                 if (rowDate < fromDate) isVisible = false;
//         //             }

//         //             if (isVisible && specFilter.to) {
//         //                 const toDate = new Date(specFilter.to);
//         //                 toDate.setHours(0, 0, 0, 0);
//         //                 if (rowDate > toDate) isVisible = false;
//         //             }
//         //         } else {
//         //             // If no dateSpan in col 7 but date filter applied → hide
//         //             isVisible = false;
//         //         }
//         //     }
//         // }
//     //   if (isVisible && specFilter) {
//     //         const specCell = row.cells[7];
        
//     //         // 1. Availability filter
//     //         if (specFilter.availability && specFilter.availability !== 'all') {
//     //             const isActuallyAvailable = !specCell.querySelector('.btn-warning');
//     //             if (specFilter.availability === 'available' && !isActuallyAvailable) isVisible = false;
//     //             if (specFilter.availability === 'not-available' && isActuallyAvailable) isVisible = false;
//     //         }
        
//     //         // 2. Date range filter
//     //         if (isVisible && (specFilter.from || specFilter.to)) {
//     //             alert('1');
//     //             alert(isVisible);
//     //             alert('2');
//     //             alert(specFilter.from);
//     //             alert('3');
//     //             alert(specFilter.to);
//     //             const dateSpans = specCell.querySelectorAll('.last-updated .update-time');
//     //             alert('4');
//     //             alert(dateSpans);
//     //             const dateSpan = dateSpans.length > 0 ? dateSpans[0] : null; // 👈 Always first span (Last updated)
//     //             alert('5');
//     //              alert(dateSpan);
//     //             if (dateSpan) {
//     //                 const rowDateStr = dateSpan.textContent.trim().split(' ')[0]; // YYYY-MM-DD
//     //                 alert('6');
//     //              alert(rowDateStr);
//     //                 const rowDate = new Date(rowDateStr);
//     //                 rowDate.setHours(0, 0, 0, 0);
//     //              alert('7');
//     //              alert(rowDate);
//     //                 if (specFilter.from) {
//     //                     const fromDate = new Date(specFilter.from);
//     //                       alert('8');
//     //              alert(fromDate);
//     //                     fromDate.setHours(0, 0, 0, 0);
//     //                     if (rowDate < fromDate) isVisible = false;
//     //                 }
        
//     //                 if (isVisible && specFilter.to) {
//     //                     const toDate = new Date(specFilter.to);
//     //                          alert('9');
//     //              alert(toDate);
//     //                     toDate.setHours(0, 0, 0, 0);
//     //                     if (rowDate > toDate) isVisible = false;
//     //                 }
//     //             } else {
//     //                 isVisible = false; // No date found
//     //             }
//     //         }
//     //     }

// // 2. Date range filter (ignore time part)
// // if (isVisible && (specFilter.from || specFilter.to)) {
// //     alert("pop00");
// //     // const dateSpan = specCell.querySelector('.update-time'); // direct grab
// // const dateSpan = document.querySelector('.update-time');

// //     if (dateSpan) {
// //         const rowDateStr = dateSpan.textContent.trim(); 
// //         alert("Row Date Found: " + rowDateStr); // ✅ ab string dikhayega

// //         if (rowDateStr !== 'N/A' && rowDateStr !== '') {
// //             const rowDateOnly = rowDateStr.split(' ')[0]; // "2025-09-08"
// //             const [year, month, day] = rowDateOnly.split('-').map(Number);
// //             const rowDate = new Date(year, month - 1, day);

// //             if (specFilter.from) {
// //                 const [fy, fm, fd] = specFilter.from.split('-').map(Number);
// //                 const fromDate = new Date(fy, fm - 1, fd);
// //                 if (rowDate < fromDate) isVisible = false;
// //             }

// //             if (isVisible && specFilter.to) {
// //                 const [ty, tm, td] = specFilter.to.split('-').map(Number);
// //                 const toDate = new Date(ty, tm - 1, td);
// //                 if (rowDate > toDate) isVisible = false;
// //             }
// //         } else {
// //             isVisible = false; 
// //         }
// //     } else {
// //         alert("❌ .update-time span not found in this row");
// //         isVisible = false; 
// //     }
// // }


// // Example: Assuming a loop over table rows
// // For each row (tableRow)...
// // ... get the cell that contains the spec-related data
// // const specCell = tableRow.querySelector('td[data-label="Specification"]');

// // 2. Date range filter (ignore time part)
// if (isVisible && (specFilter.from || specFilter.to)) {
//     // Isse aapko pata chalega ki specCell mein koi value hai ya nahi
//     // console.log("Processing row with specCell:", specCell);

//     // Sahi code: dateSpan ko specCell ke andar hi search karein
//     const dateSpan = specCell.querySelector('.update-time');

//     // Ab is alert se aapko dateSpan ki value milegi
//     // Agar specCell galat hai to 'null' milega, otherwise element
//     alert(dateSpan);

//     if (dateSpan) {
//         const rowDateStr = dateSpan.textContent.trim();
//         // Baaki ka code sahi hai
//         if (rowDateStr !== 'N/A' && rowDateStr !== '') {
//             const rowDateOnly = rowDateStr.split(' ')[0];
//             const [year, month, day] = rowDateOnly.split('-').map(Number);
//             const rowDate = new Date(year, month - 1, day);

//             if (specFilter.from) {
//                 const [fy, fm, fd] = specFilter.from.split('-').map(Number);
//                 const fromDate = new Date(fy, fm - 1, fd);
//                 if (rowDate < fromDate) isVisible = false;
//             }

//             if (isVisible && specFilter.to) {
//                 const [ty, tm, td] = specFilter.to.split('-').map(Number);
//                 const toDate = new Date(ty, tm - 1, td);
//                 if (rowDate > toDate) isVisible = false;
//             }
//         } else {
//             isVisible = false;
//         }

//     } else {
//         isVisible = false;
//     }
// }

//                 // -------------------------------
//                 // 3. Show/hide row
//                 // -------------------------------
//                 row.style.display = isVisible ? '' : 'none';
//             });
        
//             updateSerialNumbers();
//     }

            
            
            function initFilterPopup() { 
                const updateFilter = (colIndex, shouldClear = false) => { const filterIcon = thead.rows[0].cells[colIndex].querySelector('.th-filter-icon');
                if (shouldClear) { delete activeFilters[colIndex]; filterIcon.classList.remove('filter-active'); } 
                else { const checkedValues = Array.from(filterPopupChecklist.querySelectorAll('input:checked')).map(input => input.value);
                if (checkedValues.length > 0) { activeFilters[colIndex] = checkedValues; filterIcon.classList.add('filter-active'); } 
                else { delete activeFilters[colIndex]; filterIcon.classList.remove('filter-active'); } } applyAllFilters(); filterPopup.style.display = 'none'; }
                filterApplyBtn.addEventListener('click', () => updateFilter(filterPopup.dataset.columnIndex));
                filterClearBtn.addEventListener('click', () => { filterPopupChecklist.querySelectorAll('input').forEach(i => i.checked = false); 
                updateFilter(filterPopup.dataset.columnIndex, true); }); 
                filterPopupSearch.addEventListener('input', e => { const searchTerm = e.target.value.toLowerCase()
                ; filterPopupChecklist.querySelectorAll('label').forEach(label => 
                { label.style.display = label.querySelector('span').textContent.toLowerCase().includes(searchTerm) ? 'flex' : 'none'; }); }); 
                specFilterApplyBtn.addEventListener('click', () => {
                // const availability = document.querySelector('input[name="spec-availability"]:checked').value; 
                // const fromDate = document.getElementById('specDateFrom').value; const toDate = document.getElementById('specDateTo').value;
                // activeFilters.specification = { availability: availability, from: fromDate || null, to: toDate || null };
                
                    const availability = document.querySelector('input[name="spec-availability"]:checked')?.value || 'all';
                    const fromDate = document.getElementById('specDateFrom')?.value || null;
                    const toDate = document.getElementById('specDateTo')?.value || null;
                
                    activeFilters.specification = {
                        availability: availability,
                        from: fromDate,
                        to: toDate
                    };
                                
                
                // alert(availability);
                // alert(fromDate);
                // alert(toDate);
                // alert(activeFilters.specification);
                
                
                const specFilterIcon = thead.rows[0].cells[7].querySelector('.th-filter-icon'); 
                // alert(specFilterIcon);
                specFilterIcon.classList.toggle('filter-active', availability !== 'all' || fromDate || toDate);
                applyAllFilters(); specFilterPopup.style.display = 'none'; }); 
                specFilterClearBtn.addEventListener('click', () => { 
                     alert("abc");
                    document.querySelector('input[name="spec-availability"][value="all"]').checked = true; 
                    document.getElementById('specDateFrom').value = '';
                    document.getElementById('specDateTo').value = ''; 
                    activeFilters.specification = { availability: 'all', from: null, to: null }; 
                    thead.rows[0].cells[7].querySelector('.th-filter-icon').classList.remove('filter-active');
                    applyAllFilters(); 
                    specFilterPopup.style.display = 'none';
                    }); 
                    document.addEventListener('click', (e) => {
                        const isClickOnFilterIcon = e.target.classList.contains('th-filter-icon');
                        if (filterPopup.style.display === 'flex' && !filterPopup.contains(e.target) && !isClickOnFilterIcon) { 
                            filterPopup.style.display = 'none';
                            }
                            if (specFilterPopup.style.display === 'flex' && !specFilterPopup.contains(e.target) && !isClickOnFilterIcon) { specFilterPopup.style.display = 'none'; }
                            });
                }
                
                
                

            function resetAllFilters() {
                activeFilters = { specification: { availability: 'all', from: null, to: null } };
                thead.querySelectorAll('.th-filter-icon').forEach(icon => icon.classList.remove('filter-active'));
                
                // Reset spec filter form
                const specAvailabilityAll = document.querySelector('input[name="spec-availability"][value="all"]');
                if(specAvailabilityAll) specAvailabilityAll.checked = true;
                const specDateFrom = document.getElementById('specDateFrom');
                if(specDateFrom) specDateFrom.value = '';
                const specDateTo = document.getElementById('specDateTo');
                if(specDateTo) specDateTo.value = '';

                applyAllFilters();
            }

            function initDashboardEventListeners() { 
                addProductBtn.addEventListener('click', () => addNewRowWithData(null, null, null));
                resetFiltersBtn.addEventListener('click', resetAllFilters);
                mobileResetFiltersBtn.addEventListener('click', resetAllFilters);

                tbody.addEventListener('click', function(e) { 
                    const row = e.target.closest('tr'); 
                    if (!row) return; 

                    if (e.target.matches('.edit-comment-icon')) { 
                        const commentSpan = row.querySelector('.comment-text'); 
                        currentlyEditingCommentTarget = commentSpan; 
                        commentTextarea.value = commentSpan.textContent === 'No comment.' ? '' : commentSpan.textContent; 
                            const supplierId = row.dataset.supplierId;
                            document.getElementById("supplier_id_input_1").value = supplierId;
                        commentModal.style.display = 'flex'; 
                        return; 
                    } 
                    
                    const button = e.target.closest('button'); 
                    if (!button) return; 
                    
                    if (button.matches('.delete-btn')) { 
                        // if (confirm('Are you sure you want to delete this product?')) { 
                        //     deletedRows = [{ element: row, data: row.innerHTML, position: Array.from(tbody.children).indexOf(row) }]; 
                        //     row.classList.add('fade-out'); 
                        //     setTimeout(() => { row.remove(); updateSerialNumbers(); showUndoNotification('Product deleted successfully'); }, 300); 
                        // } 
                        
                         if (confirm('Are you sure you want to delete this product?')) {
                            let id = row.getAttribute('data-supplier-id'); 
                            
                          fetch("{{ url('new-supplier/delete') }}/" + id, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    deletedRows = [{ 
                                        element: row, 
                                        data: row.innerHTML, 
                                        position: Array.from(tbody.children).indexOf(row) 
                                    }];
                                    row.classList.add('fade-out');
                                    setTimeout(() => { 
                                        row.remove(); 
                                        updateSerialNumbers(); 
                                        showUndoNotification('Product deleted successfully'); 
                                    }, 300);
                                    toastr.success('Deleted Successfully');
                                } else {
                                    toastr.error(data.message)     
                                }
                            })
                            .catch(error => {
                                console.error("Error deleting:", error);
                                alert("Something went wrong!");
                            });
                        }

                    } else if (button.matches('.edit-btn')) { 
                        makeRowEditable(row); 
                    } else if (button.matches('.save-btn')) { 
                        saveRowEdits(row); 
                    } else if (button.matches('.cancel-btn')) { 
                        cancelRowEdits(row); 
                    } else if (button.matches('.edit-material-btn')) { 
                        openMaterialModal(button.closest('td')); 
                    } else if (button.matches('.spec-edit-btn') || button.matches('.spec-view-btn')) {
                        const getCellText = (cellIndex) => { const cell = row.cells[cellIndex]; const text = cell.textContent.trim(); return (text === 'Not specified' || cell.classList.contains('not-specified')) ? '' : text; };
                        const productCategory = getCellText(2);
                        const subCategory = getCellText(3);
                        const specificSubCategory = getCellText(4);
                        
                        const materialNameInput = specGeneratorModal.querySelector('#materialName');
                        const mainCategorySelect = specGeneratorModal.querySelector('#mainCategory');
                        const subCategoryInput = specGeneratorModal.querySelector('#subCategory');
                        const specificSubCategoryInput = specGeneratorModal.querySelector('#specificSubCategory');
                        const generatorTitleSpan = specGeneratorModal.querySelector('#generatorMaterialNameTitle');

                        materialNameInput.value = subCategory;
                        mainCategorySelect.value = productCategory;
                        subCategoryInput.value = subCategory;
                        specificSubCategoryInput.value = specificSubCategory;
                        generatorTitleSpan.textContent = subCategory || '[Material Name]';

                       const supplierId = button.closest("tr").getAttribute("data-supplier-id");
                       document.getElementById("supplier_id_input").value = supplierId;

                        specGeneratorModal.style.display = 'flex';
                    }
                });

                tbody.addEventListener('change', function(e) { 
                    if (e.target.classList.contains('status-checkbox')) { 
                        const row = e.target.closest('tr'), statusText = row.querySelector('.status-text'), statusDetails = row.querySelector('.status-details'); 
                        const dateSpan = row.querySelector('.status-date span'), commentSpan = row.querySelector('.comment-text'); 
                        const isActive = e.target.checked; 
                        statusText.textContent = isActive ? 'Active' : 'Inactive'; 
                        statusText.className = `status-text ${isActive ? 'active' : 'inactive'}`; 
                        dateSpan.textContent = getCurrentDate(); 
                        statusDetails.classList.remove('hidden'); 
                        currentlyEditingCommentTarget = commentSpan; 
                          const supplierId = row.dataset.supplierId;
                          document.getElementById("supplier_id_input_1").value = supplierId;
        
                        commentTextarea.value = ''; 
                        commentModal.style.display = 'flex'; 
                        commentTextarea.focus(); 
                    } 
                });
                
                thead.addEventListener('click', e => { 
                    if (e.target.classList.contains('th-filter-icon')) { 
                        const th = e.target.closest('th'); 
                        if (th.cellIndex === 7) { 
                            openSpecFilterPopup(e.target); 
                        } else { 
                            openFilterPopup(e.target); 
                        } 
                    } 
                }); 
            }
            function updateSerialNumbers() { let visibleIndex = 1; tbody.querySelectorAll('tr').forEach((row) => { if(row.style.display !== 'none'){ row.cells[1].textContent = visibleIndex++; } }); }
            function getCurrentDateTime() { const now = new Date(); return `${now.toISOString().split('T')[0]} ${now.toTimeString().split(' ')[0].substring(0, 5)}`; }
            function getCurrentDate() { return new Date().toISOString().split('T')[0]; }
            
            function initMobileFilterMenu() {
                mobileFilterMenuList.innerHTML = ''; // Clear existing menu items
                const filterableHeaders = thead.querySelectorAll('th .th-filter-icon');
                filterableHeaders.forEach(icon => {
                    const th = icon.closest('th');
                    const headerText = th.querySelector('.th-content span')?.textContent || 'Filter';

                    const button = document.createElement('button');
                    button.className = 'btn btn-secondary';
                    button.style.width = '100%';
                    button.style.justifyContent = 'center';
                    button.innerHTML = `<i class="fas fa-filter"></i> Filter by ${headerText}`;

                    button.addEventListener('click', () => {
                        mobileFilterMenuModal.style.display = 'none';
                        setTimeout(() => {
                            icon.click();
                        }, 100);
                    });

                    mobileFilterMenuList.appendChild(button);
                });

                mobileFilterBtn.addEventListener('click', () => {
                    mobileFilterMenuModal.style.display = 'flex';
                });
            }

            // --- INITIALIZE ALL COMPONENTS ---
            initDashboardModals();
            initCsvDownload();
            initCsvUpload();
            initBulkActions();
            initUndoFunctionality();
            initDashboardEventListeners();
            initMaterialModal();
            initFilterPopup();
            initSpecGenerator();
            addDataLabelsToCells();
            initMobileFilterMenu();
        });
    </script>
</body>
</html>  