<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Consolidated Supplier Details (Responsive)</title>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<!-- Select2 Bootstrap 5 Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<style>

    /* --- Custom Styles to Augment Bootstrap --- */
    :root {
        --primary-color: #34495e;
        --secondary-color: #3498db;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --info-color: #3498db;
        --light-gray: #ecf0f1;
        --dark-gray: #7f8c8d;
        --text-color: #2c3e50;
        --white: #ffffff;
        --body-bg: #f5f7fa;
        --coa-header-bg-green: #27ae60;
        --coa-header-bg-red: #c0392b;
    }
    
    .dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
    }

    body {
        background-color: var(--body-bg);
        color: var(--text-color);
    }
    h1, .h1, h2, .h2 {
        color: var(--primary-color);
    }
    .download-link {
        text-decoration: none;
        color: var(--dark-gray);
        font-weight: 500;
        cursor: pointer;
    }
    .download-link:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }
    
    /* Table-specific Customizations */
    .table-container {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .supplier-details-table thead th {
        background-color: var(--primary-color);
        color: var(--white);
        vertical-align: middle;
        position: sticky; top: 0; z-index: 10;
    }
    .th-content-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }
    .filter-button {
        color: var(--light-gray);
        background-color: transparent;
        border: 1px solid var(--dark-gray);
    }
    .filter-button:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: var(--light-gray);
    }
    
    /* Cell Content Styles */
    .cell-primary { font-weight: 600; font-size: 1rem; }
    .cell-secondary { font-size: 0.85rem; color: var(--dark-gray); line-height: 1.5; }
    .risk-category { display: inline-block; padding: 5px 12px; border-radius: 15px; font-weight: 600; }
    .risk-high { background-color: #e74c3c20; color: var(--danger-color); }
    .risk-medium { background-color: #f39c1220; color: var(--warning-color); }
    .risk-low { background-color: #2ecc7120; color: var(--success-color); }
    .fssai-number { font-family: monospace; }
    .nc-closed { color: var(--success-color); }
    .nc-open { color: var(--danger-color); }
    .status-closed { color: var(--success-color); font-weight: bold; }
    .status-open { color: var(--danger-color); font-weight: bold;}
    .contract-status-badge { font-size: 0.8rem; } /* For contract status */


    /* Icon Button Styles */
    .icon-button { background: none; border: none; padding: 2px; }
    .icon-button i { font-size: 18px; color: var(--dark-gray); transition: color 0.2s ease-in-out; }
    .icon-button.view-icon:hover i { color: var(--secondary-color); }
    .icon-button.edit-icon:hover i { color: var(--warning-color); }
    .icon-button.delete-icon:hover i { color: var(--danger-color); }
    
    /* Card View Styles */
    .card { border: none; box-shadow: 0 3px 10px rgba(0,0,0,0.08); }
    .card .card-header { background-color: var(--primary-color); color: var(--white); font-weight: 600; }
    .card .card-body { padding: 0; } /* Remove padding for list-group */
    .card .card-footer { background-color: #f8f9fa; border-top: 1px solid #dee2e6; }
    .card .list-group-item { background-color: transparent; border-bottom: 1px solid rgba(0,0,0,0.05) !important; padding: 0.75rem 1rem;}
    .card .list-group-item:last-child { border-bottom: none !important; }
    .card-label { font-weight: 600; color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.25rem; }
    .card-value { font-size: 0.95rem; }
    .card-footer .btn, .card-footer .icon-button { margin-right: 0.5rem; margin-bottom: 0.5rem; } /* Spacing for buttons */

    /* --- Mobile Sticky Header --- */
    @media (max-width: 991.98px) { /* Below large breakpoint */
        .sticky-controls-mobile {
            position: sticky;
            top: 0;
            z-index: 1021; /* High z-index to stay on top */
            background-color: var(--body-bg);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    }

    /* --- Accept/Reject Switch --- */
    .form-switch-accept-reject .form-check-input {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }
    .form-switch-accept-reject .form-check-input:checked {
        background-color: var(--success-color);
        border-color: var(--success-color);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }
    
    /* Modal and Filter styles */
    .modal-body .table-container thead th {
         position: sticky; top: -1.5rem; /* Adjust for modal scroll */
    }
    .dropdown-menu {
        padding: 0; /* Remove default padding */
        width: 300px;
    }
    .dropdown-menu .form-label, #mobileFilterModal .form-label, .modal-body .form-label {
        font-weight: 500;
        color: var(--primary-color);
    }
    .dropdown-menu hr { margin: 0.75rem 0; }
    .filter-options-container {
        max-height: 150px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        padding: 0.5rem;
        border-radius: 4px;
    }
    .form-check-label { font-size: 0.9rem; }
    .accordion-button { background-color: #f8f9fa; }
    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: var(--white);
    }
    .accordion-button:focus { box-shadow: none; }
    
    /* Select2 Customization */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: .375rem;
    }
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }

    /* --- Vendor History Card Styles (for Modals) --- */
    .coa-container {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        overflow: hidden; 
        margin-bottom: 1.5rem; 
    }
    .coa-header {
        color: var(--white);
        padding: 1rem 1.5rem;
    }
    .coa-header.renew-history { background-color: var(--coa-header-bg-green); }
    .coa-header.complain-history { background-color: var(--coa-header-bg-red); }
    .coa-header h2 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
    }
    .coa-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    .coa-meta {
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 5px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        white-space: nowrap;
    }
    .coa-body .detail-label {
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    .coa-body .detail-value {
        color: var(--dark-gray);
    }
    .modal-body .card.coa-body .card-body {
        padding: 1.5rem;
    }
     .modal-body .table-container {
        margin-top: 0;
    }
    /* Specific styles for the mobile complain history cards inside modal */
    #complainHistoryModal .card .card-body, #renewHistoryModal .card .card-body {
        padding: 0.5rem;
    }
     #complainHistoryModal .card .visible-details .list-group-item,
     #complainHistoryModal .card .collapse .list-group-item,
     #renewHistoryModal .card .visible-details .list-group-item,
     #renewHistoryModal .card .collapse .list-group-item {
        background-color: transparent;
        border: none;
        padding: 0.25rem 0.5rem;
    }
    /* ############### NEW STYLE FOR REVIEW & EDITABLE TABLES ############### */
    #bulkUploadReviewModal .table tr.row-selected {
        background-color: #e9f5ff; /* A light blue to indicate selection */
    }
    [contenteditable="true"], .editable-select {
        padding: 2px 5px;
        border-radius: 3px;
        outline: 1px dashed #ccc;
        cursor: text;
        transition: outline 0.2s ease;
    }
    [contenteditable="true"]:focus, .editable-select:hover {
        outline: 2px solid var(--secondary-color);
        background-color: #fff;
    }
    .editable-select .bi-pencil-fill {
        cursor: pointer;
        font-size: 0.7rem;
        visibility: hidden;
    }
    .editable-select:hover .bi-pencil-fill {
        visibility: visible;
    }
    /* Log book styles */
    #logBookModal .table td {
        font-size: 0.9rem;
    }
    #logBookModal .table .old-value {
        text-decoration: line-through;
        color: var(--danger-color);
    }
    #logBookModal .table .new-value {
        font-weight: 600;
        color: var(--success-color);
    }
    
    /* ############### COMPLIANCE LOG STYLES ############### */
    .compliance-ticket-item {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }
    .compliance-ticket-header {
        background-color: #f8f9fa;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
    }
    .compliance-ticket-header .h6 {
        margin-bottom: 0.25rem;
    }
    .compliance-ticket-header .small {
        color: var(--dark-gray);
    }
    .compliance-ticket-body {
        padding: 1.25rem;
    }
    .action-point-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--light-gray);
    }
    .action-point-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .action-point-item .btn-success {
        width: 90px;
    }
    .action-point-item .resolved-text {
        font-size: 0.9rem;
        color: var(--dark-gray);
    }
    .badge-status {
        font-size: 0.8rem;
    }
    .badge-status.bg-danger { background-color: var(--danger-color) !important; }
    .badge-status.bg-success { background-color: var(--success-color) !important; }

    /* Action point input group */
    .action-point-input-group {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .action-point-input-group input {
        flex-grow: 1;
    }
    .action-point-input-group .btn-danger {
        flex-shrink: 0;
    }
    .error-message {
        display: none;
        color: var(--danger-color);
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    .form-control.is-invalid ~ .error-message,
    .action-points-container.is-invalid .error-message,
    .form-control.is-invalid + .error-message {
        display: block;
    }
    #resolveActionPointForm .form-label {
        font-weight: 500;
    }
    #actionPointText {
        font-weight: 600;
        color: var(--primary-color);
        background-color: var(--light-gray);
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
    }


    /* Breaking News Ribbon */
    .breaking-news-ribbon {
        display: none; /* Hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: var(--danger-color);
        color: var(--white);
        padding: 0.5rem 0;
        z-index: 1056; /* Above modals */
        overflow: hidden;
        white-space: nowrap;
    }
    .breaking-news-content {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 20s linear infinite;
    }
    .breaking-news-content .bi {
        margin-right: 1rem;
        margin-left: 2rem;
    }
    @keyframes marquee {
        0%   { transform: translate(0, 0); }
        100% { transform: translate(-100%, 0); }
    }
    
    /* Compliance Center Styles */
    .compliance-summary-item {
        border: 1px solid #dee2e6;
        border-radius: .375rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .compliance-summary-item .supplier-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--dark-gray);
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
     .compliance-summary-item .ticket-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
     }
    .compliance-summary-item ul {
        list-style-type: none;
        padding-left: 1rem;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }
    .compliance-summary-item ul li {
        position: relative;
        padding-left: 1.2rem;
    }
    .compliance-summary-item ul li::before {
        content: '-';
        position: absolute;
        left: 0;
        color: var(--danger-color);
        font-weight: bold;
    }
    .compliance-summary-item.resolved-item ul li::before {
        content: '\\F26E'; /* Bootstrap Icon check-circle-fill */
        font-family: 'bootstrap-icons';
        color: var(--success-color);
    }


</style>
</head>
<body>

<!-- Breaking News Ribbon Container -->
<div class="breaking-news-ribbon" id="breakingNewsRibbon">
    <div class="breaking-news-content" id="breakingNewsContent">
        <!-- Content will be set by JS -->
    </div>
</div>

<div class="container-fluid my-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
        <h1 class="mb-0 h1">Supplier Details</h1>
         <!-- Desktop-only Actions -->
        <div class="d-none d-lg-flex align-items-center gap-2">
            <button class="btn btn-danger d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#complianceCenterModal">
                <i class="bi bi-bell-fill"></i> Compliance Center
            </button>
            <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#newSupplierModal">
                <i class="bi bi-plus-circle"></i> New Supplier
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                <i class="bi bi-upload"></i> Bulk Upload
            </button>
            <button class="btn btn-outline-success d-flex align-items-center gap-2" id="downloadExcelBtn">
                <i class="bi bi-file-earmark-excel"></i> Export to Excel
            </button>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="sticky-controls-mobile">
        <div class="d-flex align-items-center gap-2 justify-content-end">
             <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" id="globalSearch" placeholder="Search suppliers...">
            </div>
            <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="modal" data-bs-target="#mobileFilterModal" title="Open Filters">
                <i class="bi bi-funnel-fill"></i>
            </button>
            <button class="btn btn-outline-secondary" id="refreshBtn" data-bs-toggle="tooltip" title="Refresh List"><i class="bi bi-arrow-clockwise"></i></button>
        </div>
    </div>


<!-- ############### DESKTOP TABLE VIEW ############### -->
<div class="table-responsive table-container d-none d-lg-block mt-4">
    <table class="table table-hover align-middle supplier-details-table">
        <thead>
            <tr>
                <th>
                    <div class="th-content-wrapper">
                        <span>Hierarchy / Location</span>
                        <div class="dropdown">
                            <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Hierarchy">
                                <i class="bi bi-funnel"></i>
                            </button>
                            <div class="dropdown-menu" data-bs-auto-close="outside">
                                <form class="p-3" id="hierarchyFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Corporate</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Corporate...">
                                        <div class="filter-options-container" data-filter-container-for="corporate"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Regional</label>
                                         <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Regional...">
                                        <div class="filter-options-container" data-filter-container-for="regional"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Unit</label>
                                         <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Unit...">
                                        <div class="filter-options-container" data-filter-container-for="unit"></div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-content-wrapper">
                        <span>Supplier Details</span>
                         <div class="dropdown">
                            <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Supplier">
                                <i class="bi bi-funnel"></i>
                            </button>
                            <div class="dropdown-menu" data-bs-auto-close="outside">
                                
                               <!--<form class="p-3" id="supplierFilterForm" method="GET" action="{{ route('sqa.suplier.list') }}">-->

                               <form class="p-3" id="supplierFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Supplier Name</label>
                                        <input type="search" name="supplierName" class="form-control form-control-sm mb-2" placeholder="Search Supplier Name...">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Service Nature</label>
                                        <input type="search" name="serviceNature1" class="form-control form-control-sm mb-2" placeholder="Search Service Nature...">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supplier Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="statusActive" name="supplierStatus[]">
                                            <label class="form-check-label" for="statusActive">Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="0" id="statusInactive" name="supplierStatus[]">
                                            <label class="form-check-label" for="statusInactive">Inactive</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">License Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Valid" id="licenseValid" name="licenseStatus[]">
                                            <label class="form-check-label" for="licenseValid">Valid</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Invalid" id="licenseDueSoon" name="licenseStatus[]">
                                            <label class="form-check-label" for="licenseDueSoon">Invalid</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                                        <button type="submit"  id="applyFilter1" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-content-wrapper">
    <span>Supplier Details</span>
    <div class="dropdown">
        <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Supplier">
            <i class="bi bi-funnel"></i>
        </button>
        <div class="dropdown-menu p-2" data-bs-auto-close="outside" style="max-height: 400px; overflow-y: auto;">
            
            <form class="p-3" id="supplierFilterForm">
                <div class="mb-3">
                    <label class="form-label">Supplier Name</label>
                    <input type="search" name="supplierName" class="form-control form-control-sm mb-2" placeholder="Search Supplier Name...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Service Nature</label>
                    <input type="search" name="serviceNature1" class="form-control form-control-sm mb-2" placeholder="Search Service Nature...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Supplier Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="statusActive" name="supplierStatus[]">
                        <label class="form-check-label" for="statusActive">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="0" id="statusInactive" name="supplierStatus[]">
                        <label class="form-check-label" for="statusInactive">Inactive</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">License Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Valid" id="licenseValid" name="licenseStatus[]">
                        <label class="form-check-label" for="licenseValid">Valid</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Invalid" id="licenseDueSoon" name="licenseStatus[]">
                        <label class="form-check-label" for="licenseDueSoon">Invalid</label>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                    <button type="submit" id="applyFilter1" class="btn btn-primary btn-sm">Apply</button>
                </div>
            </form>

        </div>
    </div>
</div>

                    <!--<div class="th-content-wrapper">-->
                    <!--    <span>Contract</span>-->
                    <!--    <div class="dropdown">-->
                    <!--        <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Contract">-->
                    <!--            <i class="bi bi-funnel"></i>-->
                    <!--        </button>-->
                    <!--        <div class="dropdown-menu" data-bs-auto-close="outside">-->
                    <!--            <form class="p-3" id="contractFilterForm">-->
                    <!--                <div class="mb-3">-->
                    <!--                    <label class="form-label">Contract Type</label>-->
                    <!--                    <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Contract Type...">-->
                    <!--                    <div class="filter-options-container" data-filter-container-for="contractType"></div>-->
                    <!--                </div>-->
                    <!--                <div class="mb-3">-->
                    <!--                    <label class="form-label">Upload Status</label>-->
                    <!--                    <div class="form-check"><input class="form-check-input" type="checkbox" value="uploaded" id="contractUploaded" name="contractStatus"><label class="form-check-label" for="contractUploaded">Uploaded</label></div>-->
                    <!--                    <div class="form-check"><input class="form-check-input" type="checkbox" value="not_uploaded" id="contractNotUploaded" name="contractStatus"><label class="form-check-label" for="contractNotUploaded">Not Uploaded</label></div>-->
                    <!--                </div>-->
                    <!--                <div class="mb-3">-->
                    <!--                    <label class="form-label">Validity Status</label>-->
                    <!--                    <div class="form-check"><input class="form-check-input" type="checkbox" value="Valid" id="contractValid" name="contractValidityStatus"><label class="form-check-label" for="contractValid">Valid</label></div>-->
                    <!--                    <div class="form-check"><input class="form-check-input" type="checkbox" value="Due soon" id="contractDueSoon" name="contractValidityStatus"><label class="form-check-label" for="contractDueSoon">Due soon</label></div>-->
                    <!--                    <div class="form-check"><input class="form-check-input" type="checkbox" value="Expired" id="contractExpired" name="contractValidityStatus"><label class="form-check-label" for="contractExpired">Expired</label></div>-->
                    <!--                </div>-->
                    <!--                <div class="mb-3">-->
                    <!--                    <label class="form-label">Contract End Date</label>-->
                    <!--                    <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="date" class="form-control" name="contractFromDate"></div>-->
                    <!--                    <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="date" class="form-control" name="contractToDate"></div>-->
                    <!--                </div>-->
                    <!--                <hr>-->
                    <!--                <div class="d-flex justify-content-between">-->
                    <!--                    <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>-->
                    <!--                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>-->
                    <!--                </div>-->
                    <!--            </form>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </th>
                <th>
                    <div class="th-content-wrapper">
                        <span>List</span>
                        <div class="dropdown">
                            <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by List">
                                <i class="bi bi-funnel"></i>
                            </button>
                            <div class="dropdown-menu" data-bs-auto-close="outside">
                                 <form class="p-3" id="listFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Risk</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="High Risk" id="riskHigh" name="riskStatus"><label class="form-check-label" for="riskHigh">High</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Medium Risk" id="riskMedium" name="riskStatus"><label class="form-check-label" for="riskMedium">Medium</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Low Risk" id="riskLow" name="riskStatus"><label class="form-check-label" for="riskLow">Low</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="product_added" id="productAdded" name="productStatus"><label class="form-check-label" for="productAdded">Product Added</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="product_not_added" id="productNotAdded" name="productStatus"><label class="form-check-label" for="productNotAdded">Product Not Added</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="productName" placeholder="Product name...">
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </th>
                 <th>
                    <div class="th-content-wrapper">
                        <span>Audit</span>
                        <div class="dropdown">
                            <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Audit">
                                <i class="bi bi-funnel"></i>
                            </button>
                            <div class="dropdown-menu" data-bs-auto-close="outside">
                                 <form class="p-3" id="auditFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Audit Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="conducted" id="auditConducted" name="auditStatus"><label class="form-check-label" for="auditConducted">Conducted</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="not_conducted" id="auditNotConducted" name="auditStatus"><label class="form-check-label" for="auditNotConducted">Not Conducted</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Frequency</label>
                                         <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Frequency...">
                                        <div class="filter-options-container">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" value="Annually" id="freq_annually" name="auditFrequency"><label class="form-check-label" for="freq_annually">Annually</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" value="Quarterly" id="freq_quarterly" name="auditFrequency"><label class="form-check-label" for="freq_quarterly">Quarterly</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" value="Half-Yearly" id="freq_half_yearly" name="auditFrequency"><label class="form-check-label" for="freq_half_yearly">Half-Yearly</label></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Audit Period (Last Audit)</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="date" class="form-control" name="auditFromDate"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="date" class="form-control" name="auditToDate"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Compliance Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Open" name="complianceStatus" id="statusOpen"><label class="form-check-label" for="statusOpen">Open</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Closed" name="complianceStatus" id="statusClosed"><label class="form-check-label" for="statusClosed">Closed</label></div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-content-wrapper">
                        <span>Evaluation</span>
                        <div class="dropdown">
                            <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Evaluation">
                                <i class="bi bi-funnel"></i>
                            </button>
                             <div class="dropdown-menu" data-bs-auto-close="outside">
                                <form class="p-3" id="evalFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="completed" id="evalCompleted" name="evalStatus"><label class="form-check-label" for="evalCompleted">Completed</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="not_completed" id="evalNotCompleted" name="evalStatus"><label class="form-check-label" for="evalNotCompleted">Not Completed</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Evaluation Score (%)</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="number" class="form-control" name="evalScoreFrom" min="0" max="100"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="number" class="form-control" name="evalScoreTo" min="0" max="100"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Evaluation Period (Last Eval)</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="date" class="form-control" name="evalFromDate"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="date" class="form-control" name="evalToDate"></div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-content-wrapper">
                        <span>Complains & Compliance</span>
                        <div class="dropdown">
                            <button class="btn btn-sm filter-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter by Complains">
                                <i class="bi bi-funnel"></i>
                            </button>
                             <div class="dropdown-menu" data-bs-auto-close="outside">
                                <form class="p-3" id="complainFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="has_complains" id="hasComplains" name="complainStatus"><label class="form-check-label" for="hasComplains">Has Complains</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="no_complains" id="noComplains" name="complainStatus"><label class="form-check-label" for="noComplains">No Complains</label></div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </th>
                <th><div class="th-content-wrapper"><span>Action</span></div></th>
            </tr>
        </thead>
        <tbody id="supplierTableBody" data-table="supplier-table">
         @include('admin.training._supplier_table', ['suppliers' => $suppliers])
        </tbody>
    </table>
     <div class="div-pagination-container">
        {{ $suppliers->links() }}
    </div>
</div>

<!-- ############### MOBILE CARD VIEW ############### -->
<div id="supplierCardContainer" class="d-lg-none mt-4">
    <!-- Card 1 -->
    <div class="card mb-3" data-supplier-id="supplier-1">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span data-field="supplierName">VEZLAY FOODS PVT LTD</span>
            <span class="badge text-bg-success">Active</span>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><div class="card-label">Hierarchy</div><div class="card-value" data-field="hierarchy">IHCL > Jaipur & Ajmer > Rambagh Palace</div></li>
                <li class="list-group-item" data-container="license-upload">
                    <div class="card-label">License</div>
                    <div class="card-value d-flex justify-content-between align-items-center">
                        <div>FSSAI: <span class="fssai-number" data-field="license-number">10017018002411</span> <span class="badge text-bg-success" data-field="license-status">Valid</span></div>
                        <div class="icon-actions">
                            <button class="icon-button view-icon" title="View FSSAI"><i class="bi bi-eye-fill"></i></button>
                            <button class="icon-button edit-icon" title="Edit FSSAI" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-pencil-fill"></i></button>
                            <button class="icon-button delete-icon" title="Delete FSSAI"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    </div>
                </li>
                 <li class="list-group-item" data-container="contract-upload">
                    <div class="card-label">Contract</div>
                    <div class="card-value">
                        <div class="d-flex justify-content-between align-items-center">
                             <div>Type: <span data-field="contractType">Annual Rate</span> | Ends: <span data-field="contract-end-date">2025-08-20</span></div>
                             <div class="contract-status-container"></div>
                        </div>
                         <div class="icon-actions mt-1">
                            <button class="icon-button view-icon" title="View Contract"><i class="bi bi-eye-fill"></i></button>
                            <button class="icon-button edit-icon" title="Edit Contract" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-pencil-fill"></i></button>
                            <button class="icon-button delete-icon" title="Delete Contract"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item"><div class="card-label">Address</div><div class="card-value" data-field="address">352, FIE, Patparganj, Delhi</div></li>
                <li class="list-group-item"><div class="card-label">List / Risk</div><div class="card-value"><span class="risk-category risk-medium">Medium Risk</span> (2 Items)</div></li>
                <li class="list-group-item"><div class="card-label">Audit</div><div class="card-value">Score: <span data-field="audit-score">88/100</span> | Freq: <span data-field="audit-frequency">Annually</span> | Last: <span data-field="audit-last-date">2023-11-15</span><br>NCs: <span class="nc-closed">3 Closed</span> / <span class="nc-open">1 Open</span></div></li>
                <li class="list-group-item"><div class="card-label">Evaluation</div><div class="card-value">Score: <span data-field="eval-score">88% / >85%</span> | Freq: Annually | Last: <span data-field="eval-last-date">2023-11-20</span></div></li>
                <li class="list-group-item"><div class="card-label">Complains & Compliance</div><div class="card-value">2 Complains, Last: 2024-02-10 <button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></li>
                <li class="list-group-item"><div class="card-label">Data updated on</div><div class="card-value last-updated">8/29/2025, 5:30:00 PM</div></li>
            </ul>
        </div>
        <div class="card-footer d-flex flex-wrap align-items-center">
            <div class="open-ticket-button-placeholder me-auto"></div>
            <button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#editSupplierModal" title="Edit Supplier"><i class="bi bi-pencil-fill fs-5"></i></button>
            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logBookModal">Log</button>
            <button class="btn btn-sm btn-primary">List</button>
            <button class="btn btn-sm btn-warning">Audit</button>
            <button class="btn btn-sm btn-warning">Eval</button>
        </div>
    </div>
    <!-- Card 2 -->
    <div class="card mb-3" data-supplier-id="supplier-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span data-field="supplierName">AgriFresh Suppliers</span>
            <span class="badge text-bg-secondary">Inactive</span>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><div class="card-label">Hierarchy</div><div class="card-value" data-field="hierarchy">Global Foods Inc. > West India > Mumbai Central</div></li>
                <li class="list-group-item" data-container="license-upload">
                    <div class="card-label">License</div>
                    <div class="card-value d-flex justify-content-between align-items-center">
                        <div>FSSAI: <span class="fssai-number" data-field="license-number">11223045006789</span> <span class="badge text-bg-warning" data-field="license-status">Expiring soon</span></div>
                        <div class="icon-actions">
                            <button class="icon-button view-icon" title="View FSSAI"><i class="bi bi-eye-fill"></i></button>
                            <button class="icon-button edit-icon" title="Edit FSSAI" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-pencil-fill"></i></button>
                            <button class="icon-button delete-icon" title="Delete FSSAI"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    </div>
                </li>
                 <li class="list-group-item" data-container="contract-upload">
                    <div class="card-label">Contract</div>
                    <div class="card-value">
                        <div class="d-flex justify-content-between align-items-center">
                             <div>Type: <span data-field="contractType">Quarterly Supply</span> | Ends: <span data-field="contract-end-date">2025-09-15</span></div>
                             <div class="contract-status-container"></div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-upload me-1"></i>Upload Contract</button>
                    </div>
                </li>
                 <li class="list-group-item"><div class="card-label">Address</div><div class="card-value" data-field="address">9/399, Mahiya Nagar, Jaipur</div></li>
                <li class="list-group-item"><div class="card-label">List / Risk</div><div class="card-value"><span class="risk-category risk-high">High Risk</span> (2 Items)</div></li>
                <li class="list-group-item"><div class="card-label">Audit</div><div class="card-value">Score: <span data-field="audit-score">95/100</span> | Freq: <span data-field="audit-frequency">Quarterly</span> | Last: <span data-field="audit-last-date">2024-03-20</span><br>NCs: <span class="nc-closed">5 Closed</span> / <span class="nc-open">0 Open</span></div></li>
                <li class="list-group-item"><div class="card-label">Evaluation</div><div class="card-value">Score: <span data-field="eval-score">95% / >90%</span> | Freq: Quarterly | Last: <span data-field="eval-last-date">2024-03-25</span></div></li>
                <li class="list-group-item"><div class="card-label">Complains & Compliance</div><div class="card-value">0 Complains <button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></li>
                 <li class="list-group-item"><div class="card-label">Data updated on</div><div class="card-value last-updated">8/28/2025, 11:10:00 AM</div></li>
            </ul>
        </div>
        <div class="card-footer d-flex flex-wrap align-items-center">
             <div class="open-ticket-button-placeholder me-auto"></div>
            <button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#editSupplierModal" title="Edit Supplier"><i class="bi bi-pencil-fill fs-5"></i></button>
            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logBookModal">Log</button>
            <button class="btn btn-sm btn-primary">List</button>
            <button class="btn btn-sm btn-warning">Audit</button>
            <button class="btn btn-sm btn-warning">Eval</button>
        </div>
    </div>
    <!-- Card 3 -->
    <div class="card mb-3" data-supplier-id="supplier-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span data-field="supplierName">Jaipur Pest Control</span>
            <span class="badge text-bg-success">Active</span>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><div class="card-label">Hierarchy</div><div class="card-value" data-field="hierarchy">IHCL > Jaipur & Ajmer > Jai Mahal Palace</div></li>
                <li class="list-group-item" data-container="license-upload">
                    <div class="card-label">License</div>
                    <div class="card-value">
                       <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-plus-circle-dotted me-1"></i>Upload License</button>
                    </div>
                </li>
                 <li class="list-group-item" data-container="contract-upload">
                    <div class="card-label">Contract</div>
                    <div class="card-value">
                        <div class="d-flex justify-content-between align-items-center">
                             <div>Type: <span data-field="contractType">Annual Service</span> | Ends: <span data-field="contract-end-date">2025-01-31</span></div>
                             <div class="contract-status-container"></div>
                        </div>
                        <div class="icon-actions mt-1">
                            <button class="icon-button view-icon" title="View Contract"><i class="bi bi-eye-fill"></i></button>
                            <button class="icon-button edit-icon" title="Edit Contract" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-pencil-fill"></i></button>
                            <button class="icon-button delete-icon" title="Delete Contract"><i class="bi bi-trash-fill"></i></button>
                        </div>
                    </div>
                </li>
                <li class="list-group-item"><div class="card-label">Address</div><div class="card-value" data-field="address">12B, C-Scheme, Jaipur</div></li>
                <li class="list-group-item"><div class="card-label">List / Risk</div><div class="card-value"><span class="risk-category risk-low">Low Risk</span> (1 Item)</div></li>
                <li class="list-group-item"><div class="card-label">Audit</div><div class="card-value">Score: <span data-field="audit-score">98/100</span> | Freq: <span data-field="audit-frequency">Half-Yearly</span> | Last: <span data-field="audit-last-date">2024-03-10</span><br>NCs: <span class="nc-closed">1 Closed</span> / <span class="nc-open">0 Open</span></div></li>
                <li class="list-group-item"><div class="card-label">Evaluation</div><div class="card-value">Score: <span data-field="eval-score">98% / >90%</span> | Freq: Half-Yearly | Last: <span data-field="eval-last-date">2024-03-15</span></div></li>
                <li class="list-group-item"><div class="card-label">Complains & Compliance</div><div class="card-value">0 Complains <button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></li>
                 <li class="list-group-item"><div class="card-label">Data updated on</div><div class="card-value last-updated">8/27/2025, 3:00:00 PM</div></li>
            </ul>
        </div>
        <div class="card-footer d-flex flex-wrap align-items-center">
            <div class="open-ticket-button-placeholder me-auto"></div>
            <button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#editSupplierModal" title="Edit Supplier"><i class="bi bi-pencil-fill fs-5"></i></button>
             <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logBookModal">Log</button>
            <button class="btn btn-sm btn-primary">List</button>
            <button class="btn btn-sm btn-warning">Audit</button>
            <button class="btn btn-sm btn-warning">Eval</button>
        </div>
    </div>
</div>


<!-- Pagination Controls -->
<div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-3">
    <!--<div class="d-flex align-items-center gap-2">-->
    <!--    <span>Show</span>-->
    <!--    <select class="form-select form-select-sm" style="width: auto;">-->
    <!--        <option value="10" selected>10</option>-->
    <!--        <option value="25">25</option>-->
    <!--        <option value="50">50</option>-->
    <!--        <option value="100">100</option>-->
    <!--    </select>-->
    <!--    <span>entries</span>-->
    <!--</div>-->
    <div class="text-muted small" id="paginationInfo"></div>
    <!--<nav>-->
    <!--    <ul class="pagination pagination-sm mb-0">-->
    <!--        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>-->
    <!--        <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
    <!--        <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>-->
    <!--    </ul>-->
    <!--</nav>-->
</div>
</div>

<!-- ############### RENEW MODAL ############### -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="renewModalLabel">Confirm Contract Renewal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to renew the contract for <strong id="renewSupplierName"></strong> for another year?</p>
        <p>The new contract end date will be <strong id="newContractEndDate"></strong>.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmRenewBtn">Confirm Renewal</button>
      </div>
    </div>
  </div>
</div>


<!-- ############### COMPLIANCE CENTER MODAL ############### -->
<div class="modal fade" id="complianceCenterModal" tabindex="-1" aria-labelledby="complianceCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="complianceCenterModalLabel">Compliance Center</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="complianceCenterBody">
                <!-- Summary of open tickets will be rendered here by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- ############### RESOLVE ACTION POINT MODAL ############### -->
<div class="modal fade" id="resolveActionPointModal" tabindex="-1" aria-labelledby="resolveActionPointModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resolveActionPointModalLabel">Resolve Action Point</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="resolveActionPointForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Action Point:</label>
                        <p id="actionPointText">Allergen declaration missing.</p>
                    </div>
                    <div class="mb-3">
                        <label for="resolutionNotes" class="form-label">Resolution Notes</label>
                        <textarea class="form-control" id="resolutionNotes" rows="3" required></textarea>
                        <div class="error-message">Please fill out this field.</div>
                    </div>
                    <div class="mb-3">
                        <label for="evidenceFile" class="form-label">Upload Evidence</label>
                        <input class="form-control" type="file" id="evidenceFile">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="resolveActionPointForm" id="submitResolutionBtn">Submit Resolution</button>
            </div>
        </div>
    </div>
</div>


<!-- ############### COMPLIANCE LOG MODAL ############### -->
<div class="modal fade" id="complianceLogModal" tabindex="-1" aria-labelledby="complianceLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="complianceLogModalLabel">Compliance Log for <span id="complianceSupplierName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="complianceTicketsContainer">
                    <!-- Tickets will be dynamically inserted here -->
                </div>
                <hr>
                <div id="createTicketContainer">
                    <h5 class="mt-4">Create New Compliance Ticket</h5>
                    <form id="newComplianceTicketForm" novalidate>
                        <div class="mb-3">
                            <label for="ticketTitle" class="form-label">Ticket Title</label>
                            <input type="text" class="form-control" id="ticketTitle" placeholder="e.g., Labeling Errors" required>
                            <div class="error-message">Please fill out this field.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Action Points</label>
                            <div id="actionPointsContainer" class="action-points-container">
                                <!-- Action point inputs will be added here -->
                            </div>
                            <div class="error-message" id="actionPointError">Please add and fill out at least one action point.</div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="addAnotherPointBtn">
                                <i class="bi bi-plus-circle me-1"></i>Add another point
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitTicketBtn">Submit Ticket</button>
                    </form>
                </div>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ############### MOBILE FILTER MODAL ############### -->
<div class="modal fade" id="mobileFilterModal" tabindex="-1" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mobileFilterModalLabel"><i class="bi bi-funnel-fill me-2"></i>Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="filterAccordion">
                    
                    <!-- Hierarchy Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingHierarchy">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHierarchy" aria-expanded="false" aria-controls="collapseHierarchy">
                                Hierarchy / Location
                            </button>
                        </h2>
                        <div id="collapseHierarchy" class="accordion-collapse collapse" aria-labelledby="headingHierarchy" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <form id="m_hierarchyFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Corporate</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Corporate...">
                                        <div class="filter-options-container" data-filter-container-for="corporate"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Regional</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Regional...">
                                        <div class="filter-options-container" data-filter-container-for="regional"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Unit</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Unit...">
                                        <div class="filter-options-container" data-filter-container-for="unit"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Supplier Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSupplier">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSupplier" aria-expanded="false" aria-controls="collapseSupplier">
                                Supplier Details
                            </button>
                        </h2>
                        <div id="collapseSupplier" class="accordion-collapse collapse" aria-labelledby="headingSupplier" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                               <form id="m_supplierFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Supplier Name</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Supplier Name...">
                                        <div class="filter-options-container" data-filter-container-for="supplierNameList"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Service Nature</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Service Nature...">
                                        <div class="filter-options-container" data-filter-container-for="serviceNature"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supplier Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Active" id="m_statusActive" name="supplierStatus"><label class="form-check-label" for="m_statusActive">Active</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Inactive" id="m_statusInactive" name="supplierStatus"><label class="form-check-label" for="m_statusInactive">Inactive</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">License Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Valid" id="m_licenseValid" name="licenseStatus"><label class="form-check-label" for="m_licenseValid">Valid</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Expiring soon" id="m_licenseDueSoon" name="licenseStatus"><label class="form-check-label" for="m_licenseDueSoon">Expiring Soon</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="license_added" id="m_licenseAdded" name="licenseStatus"><label class="form-check-label" for="m_licenseAdded">Added</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="license_not_added" id="m_licenseNotAdded" name="licenseStatus"><label class="form-check-label" for="m_licenseNotAdded">Not Added</label></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Contract Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingContract">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContract" aria-expanded="false" aria-controls="collapseContract">
                                Contract
                            </button>
                        </h2>
                        <div id="collapseContract" class="accordion-collapse collapse" aria-labelledby="headingContract" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <form id="m_contractFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Contract Type</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Contract Type...">
                                        <div class="filter-options-container" data-filter-container-for="contractType"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Upload Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="uploaded" id="m_contractUploaded" name="contractStatus"><label class="form-check-label" for="m_contractUploaded">Uploaded</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="not_uploaded" id="m_contractNotUploaded" name="contractStatus"><label class="form-check-label" for="m_contractNotUploaded">Not Uploaded</label></div>
                                    </div>
                                     <div class="mb-3">
                                        <label class="form-label">Validity Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Valid" id="m_contractValid" name="contractValidityStatus"><label class="form-check-label" for="m_contractValid">Valid</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Due soon" id="m_contractDueSoon" name="contractValidityStatus"><label class="form-check-label" for="m_contractDueSoon">Due soon</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Expired" id="m_contractExpired" name="contractValidityStatus"><label class="form-check-label" for="m_contractExpired">Expired</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contract End Date</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="date" class="form-control" name="contractFromDate"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="date" class="form-control" name="contractToDate"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- List Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingList">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseList" aria-expanded="false" aria-controls="collapseList">
                                List
                            </button>
                        </h2>
                        <div id="collapseList" class="accordion-collapse collapse" aria-labelledby="headingList" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                 <form id="m_listFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Risk</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="High Risk" id="m_riskHigh" name="riskStatus"><label class="form-check-label" for="m_riskHigh">High</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Medium Risk" id="m_riskMedium" name="riskStatus"><label class="form-check-label" for="m_riskMedium">Medium</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Low Risk" id="m_riskLow" name="riskStatus"><label class="form-check-label" for="m_riskLow">Low</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="product_added" id="m_productAdded" name="productStatus"><label class="form-check-label" for="m_productAdded">Product Added</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="product_not_added" id="m_productNotAdded" name="productStatus"><label class="form-check-label" for="m_productNotAdded">Product Not Added</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="productName" placeholder="Product name...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- Audit Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingAudit">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAudit" aria-expanded="false" aria-controls="collapseAudit">
                                Audit
                            </button>
                        </h2>
                        <div id="collapseAudit" class="accordion-collapse collapse" aria-labelledby="headingAudit" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <form id="m_auditFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Audit Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="conducted" id="m_auditConducted" name="auditStatus"><label class="form-check-label" for="m_auditConducted">Conducted</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="not_conducted" id="m_auditNotConducted" name="auditStatus"><label class="form-check-label" for="m_auditNotConducted">Not Conducted</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Frequency</label>
                                        <input type="search" class="form-control form-control-sm mb-2 filter-search" placeholder="Search Frequency...">
                                        <div class="filter-options-container">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" value="Annually" id="m_freq_annually" name="auditFrequency"><label class="form-check-label" for="m_freq_annually">Annually</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" value="Quarterly" id="m_freq_quarterly" name="auditFrequency"><label class="form-check-label" for="m_freq_quarterly">Quarterly</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" value="Half-Yearly" id="m_freq_half_yearly" name="auditFrequency"><label class="form-check-label" for="m_freq_half_yearly">Half-Yearly</label></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Audit Period (Last Audit)</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="date" class="form-control" name="auditFromDate"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="date" class="form-control" name="auditToDate"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Compliance Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Open" name="complianceStatus" id="m_statusOpen"><label class="form-check-label" for="m_statusOpen">Open</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="Closed" name="complianceStatus" id="m_statusClosed"><label class="form-check-label" for="m_statusClosed">Closed</label></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- Evaluation Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEval">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEval" aria-expanded="false" aria-controls="collapseEval">
                                Evaluation
                            </button>
                        </h2>
                        <div id="collapseEval" class="accordion-collapse collapse" aria-labelledby="headingEval" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <form id="m_evalFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="completed" id="m_evalCompleted" name="evalStatus"><label class="form-check-label" for="m_evalCompleted">Completed</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="not_completed" id="m_evalNotCompleted" name="evalStatus"><label class="form-check-label" for="m_evalNotCompleted">Not Completed</label></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Evaluation Score (%)</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="number" class="form-control" name="evalScoreFrom" min="0" max="100"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="number" class="form-control" name="evalScoreTo" min="0" max="100"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Evaluation Period (Last Eval)</label>
                                        <div class="input-group input-group-sm"><span class="input-group-text">From</span><input type="date" class="form-control" name="evalFromDate"></div>
                                        <div class="input-group input-group-sm mt-2"><span class="input-group-text">To</span><input type="date" class="form-control" name="evalToDate"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- Complains Filter -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingComplain">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComplain" aria-expanded="false" aria-controls="collapseComplain">
                                Complains
                            </button>
                        </h2>
                        <div id="collapseComplain" class="accordion-collapse collapse" aria-labelledby="headingComplain" data-bs-parent="#filterAccordion">
                            <div class="accordion-body">
                                <form id="m_complainFilterForm">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="has_complains" id="m_hasComplains" name="complainStatus"><label class="form-check-label" for="m_hasComplains">Has Complains</label></div>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" value="no_complains" id="m_noComplains" name="complainStatus"><label class="form-check-label" for="m_noComplains">No Complains</label></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" id="clearMobileFilters">Clear All</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- ############### NEW SUPPLIER MODAL ############### -->
<div class="modal fade" id="newSupplierModal" tabindex="-1" aria-labelledby="newSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h5" id="newSupplierModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Add New Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    @php
         $user = auth()->user(); 
        $unit = $user->company_name;
        $regional = $corporate = null;
        $r_id = $c_id = null;
    
        if($user->is_role == "3") {
            $r_name = DB::table('users')->where('id', $user->created_by1)->first();
            $c_name = DB::table('users')->where('id', $user->created_by)->first();
    
            $regional = $r_name->company_name ?? 'N/A';
            $corporate = $c_name->company_name ?? 'N/A';
    
            $r_id = $r_name->id ?? '';
            $c_id = $c_name->id ?? '';
        }
    @endphp
      <div class="modal-body">
        <form id="newSupplierForm" class="needs-validation" novalidate>
            <div class="row g-3">
                <h6 class="text-secondary mb-0 mt-2">Hierarchy & Location</h6>
                <div class="col-md-4">
                <label for="newSupplierCorporate" class="form-label">Corporate</label>
                <select class="form-select" name="corporate" id="newSupplierCorporate" required>
                    <option selected disabled value="">Choose...</option>
                    @if($c_id)
                        <option value="{{ $c_id }}" selected>{{ $corporate }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="newSupplierRegional" class="form-label">Regional</label>
                <select class="form-select" name="regional" id="newSupplierRegional" required>
                    <option selected disabled value="">Choose...</option>
                    @if($r_id)
                        <option value="{{ $r_id }}" selected>{{ $regional }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-4">
                <label for="newSupplierUnit" class="form-label">Unit</label>
                <select class="form-select"  name="unit" id="newSupplierUnit" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="{{ $user->id }}" selected>{{ $unit }}</option>
                </select>
            </div>

                <hr class="my-3">
                <h6 class="text-secondary mb-0">Basic Information</h6>
                <div class="col-md-8">
                    <label for="newSupplierName" class="form-label">Supplier Name</label>
                    <input type="text" class="form-control" id="newSupplierName" name="name" placeholder="e.g., VEZLAY FOODS PVT LTD" required>
                </div>
                <div class="col-md-4">
                   <label for="newSupplierServiceNature" class="form-label">Service Nature</label>
                   <select class="form-select" name="service_nature" id="newSupplierServiceNature" required>
                        <option selected disabled value="">Choose...</option>
                        <option>Food/Ingredients</option>
                        <option>Service-Pest Control</option>
                        <option>Other Service</option>
                   </select>
                </div>
                <div class="col-12">
                    <label for="newSupplierEmail" class="form-label">Contact Email</label>
                    <input type="email" class="form-control" name="email" id="newSupplierEmail" placeholder="supplier@example.com">
                </div>
                <div class="col-12">
                    <label for="newSupplierAddress" class="form-label">Full Address</label>
                    <textarea class="form-control" id="newSupplierAddress" name="address" rows="2" placeholder="Street, City, State, PIN"></textarea>
                </div>
                
                <hr class="my-3">
                <h6 class="text-secondary mb-0">License Details (e.g., FSSAI)</h6>
                 <div class="col-md-6">
                    <label for="newSupplierLicenseNumber" class="form-label">License Number</label>
                    <input type="text" class="form-control" id="newSupplierLicenseNumber" name="license_number" placeholder="Enter license number">
                </div>
                 <div class="col-md-6">
                    <label for="newSupplierLicenseExpiry" class="form-label">License Expiry Date</label>
                    <input type="date" class="form-control" name="license_expiry" id="newSupplierLicenseExpiry">
                </div>
                 <div class="col-12">
                     <label for="newSupplierLicenseFile" class="form-label">Upload License Document</label>
                     <input class="form-control" type="file" name="license_file" id="newSupplierLicenseFile" accept=".pdf,.jpg,.jpeg,.png">
                 </div>
                 
                 <hr class="my-3">
                 <h6 class="text-secondary mb-0">Contract Details</h6>
                 <div class="col-md-6">
                   <label for="newSupplierContractType" class="form-label">Contract Type</label>
                   <select class="form-select" name="contract_type" id="newSupplierContractType" required>
                        <option selected disabled value="">Choose...</option>
                        <option>Annual Rate</option>
                        <option>Quarterly Supply</option>
                        <option>Annual Service</option>
                        <option>One-Time Purchase</option>
                   </select>
                </div>
                <div class="col-md-6">
                    <label for="newSupplierContractNumber" class="form-label">Contract Number</label>
                    <input type="text" class="form-control" name="contract_number" id="newSupplierContractNumber" placeholder="e.g., C-2024-004">
                </div>
                <div class="col-md-6">
                    <label for="newSupplierContractStart" class="form-label">Contract Start Date</label>
                    <input type="date" class="form-control"  name="contract_start" id="newSupplierContractStart" required>
                </div>
                <div class="col-md-6">
                    <label for="newSupplierContractEnd" class="form-label">Contract End Date</label>
                    <input type="date" class="form-control"  name="contract_end" id="newSupplierContractEnd" required>
                </div>
                 <div class="col-12">
                     <label for="newSupplierContractFile" class="form-label">Upload Contract Document</label>
                     <input class="form-control" type="file" name="contract_file" id="newSupplierContractFile" accept=".pdf">
                 </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="newSupplierForm"><i class="bi bi-save me-2"></i>Save Supplier</button>
      </div>
    </div>
  </div>
</div>

<!-- ############### EDIT SUPPLIER MODAL ############### -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h5" id="editSupplierModalLabel"><i class="bi bi-pencil-square me-2"></i>Edit Supplier Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editSupplierForm" class="needs-validation" novalidate>
             <div class="row g-3">
                <h6 class="text-secondary mb-0">Basic Information</h6>
                <div class="col-md-8">
                    <label for="editSupplierName" class="form-label">Supplier Name</label>
                    <input type="text" class="form-control" id="editSupplierName" required>
                </div>
                <div class="col-md-4">
                   <label for="editSupplierServiceNature" class="form-label">Service Nature</label>
                   <select class="form-select" id="editSupplierServiceNature" required>
                        <option disabled value="">Choose...</option>
                        <option>Food/Ingredients</option>
                        <option>Service-Pest Control</option>
                        <option>Other Service</option>
                        <option>Transport</option>
                   </select>
                </div>
                <div class="col-12">
                    <label for="editSupplierEmail" class="form-label">Contact Email</label>
                    <input type="email" class="form-control" id="editSupplierEmail">
                </div>
                <div class="col-12">
                    <label for="editSupplierAddress" class="form-label">Full Address</label>
                    <textarea class="form-control" id="editSupplierAddress" rows="2"></textarea>
                </div>
                 <hr class="my-3">
                 <h6 class="text-secondary mb-0">Contract Details</h6>
                 <div class="col-md-6">
                   <label for="editSupplierContractType" class="form-label">Contract Type</label>
                   <select class="form-select" id="editSupplierContractType" required>
                        <option disabled value="">Choose...</option>
                        <option>Annual Rate</option>
                        <option>Quarterly Supply</option>
                        <option>Annual Service</option>
                        <option>One-Time Purchase</option>
                   </select>
                </div>
                <div class="col-md-6">
                    <label for="editSupplierContractNumber" class="form-label">Contract Number</label>
                    <input type="text" class="form-control" id="editSupplierContractNumber">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" form="editSupplierForm"><i class="bi bi-save me-2"></i>Save Changes</button>
      </div>
    </div>
  </div>
</div>

<!-- ############### LOG BOOK MODAL ############### -->
<div class="modal fade" id="logBookModal" tabindex="-1" aria-labelledby="logBookModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logBookModalLabel"><i class="bi bi-journal-text me-2"></i>Change Log Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="coa-container">
                <div class="coa-header d-flex justify-content-between align-items-center flex-wrap gap-3" style="background-color: var(--info-color);">
                    <div>
                        <h2 class="h2" id="logBookSupplierName">Supplier Name</h2>
                        <p>Detailed audit trail of all changes.</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive table-container">
                <table class="table table-sm table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Action / Field</th>
                            <th>Previous Value</th>
                            <th>Current Value</th>
                        </tr>
                    </thead>
                    <tbody id="logBookTableBody">
                        <!-- Log entries will be populated dynamically by JS -->
                    </tbody>
                </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- ############### UPLOAD MODALS ############### -->

<!-- Upload/Edit Contract Modal -->
<!--<div class="modal fade" id="uploadContractModal" tabindex="-1" aria-labelledby="uploadContractModalLabel" aria-hidden="true">-->
<!--  <div class="modal-dialog">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title h5" id="uploadContractModalLabel">Upload Contract Document</h5>-->
<!--        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        <form id="contractUploadForm">-->
<!--          <div class="mb-3">-->
<!--            <label for="contractNumberInput" class="form-label">Contract Number</label>-->
<!--            <input type="text" class="form-control" id="contractNumberInput" placeholder="Enter contract number">-->
<!--          </div>-->
<!--          <div class="mb-3">-->
<!--            <label for="contractFileInput" class="form-label">Upload PDF</label>-->
<!--            <input class="form-control" type="file" id="contractFileInput" accept=".pdf">-->
<!--          </div>-->
<!--          <div class="mb-3">-->
<!--            <label for="contractEndDateInput" class="form-label">End Date</label>-->
<!--            <input type="date" class="form-control" id="contractEndDateInput">-->
<!--          </div>-->
<!--        </form>-->
<!--      </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
<!--        <button type="button" class="btn btn-primary" id="saveContractBtn">Upload</button>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<div class="modal fade" id="uploadContractModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="contractForm"  method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="supplier_id" id="supplier_id">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
                <div  class="mb-3">
                   <label for="newSupplierContractType1" class="form-label">Contract Type</label>
                   <select class="form-select" name="contract_type" id="newSupplierContractType1" required>
                        <option disabled value="">Choose...</option>
                        <option value="Annual Rate">Annual Rate</option>
                        <option value="Quarterly Supply">Quarterly Supply</option>
                        <option value="Annual Service">Annual Service</option>
                        <option value="One-Time Purchase">One-Time Purchase</option>
                   </select>
                </div>

              <div class="mb-3">
                  <label>Contract Number</label>
                  <input type="text" class="form-control" name="contract_number" id="contract_number">
              </div>

              <div class="mb-3">
                  <label>Start Date</label>
                  <input type="date" class="form-control" name="contract_start_date" id="contract_start_date">
              </div>


              <div class="mb-3">
                  <label>End Date</label>
                  <input type="date" class="form-control" name="contract_end_date" id="contract_end_date">
              </div>
          <div class="mb-3">
                <label>Upload PDF</label>
                <input type="file" 
                       class="form-control" 
                       name="contract_file" 
                       id="contract_file" 
                       accept="application/pdf">
            </div>


          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </div>
    </form>
  </div>
</div>





<!-- Upload/Edit License Modal -->
<div class="modal fade" id="uploadLicenseModal" tabindex="-1" aria-labelledby="uploadLicenseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h5" id="uploadLicenseModalLabel">Upload FSSAI/License Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="licenseUploadForm">
          <div class="mb-3">
            <label for="licenseNumberInput" class="form-label">License Number</label>
            <input type="text" class="form-control" id="licenseNumberInput" placeholder="Enter license number">
          </div>
          <div class="mb-3">
            <label for="licenseFileInput" class="form-label">Upload Document</label>
            <input class="form-control" type="file" id="licenseFileInput" accept=".pdf,.jpg,.jpeg,.png">
          </div>
          <div class="mb-3">
            <label for="licenseExpiryDateInput" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" id="licenseExpiryDateInput">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveLicenseBtn">Upload</button>
      </div>
    </div>
  </div>
</div>

<!-- ############### RENEW HISTORY MODAL ############### -->
<div class="modal fade" id="renewHistoryModal" tabindex="-1" aria-labelledby="renewHistoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="renewHistoryModalLabel"><i class="bi bi-clock-history me-2"></i>Renew History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="coa-container">
                <div class="coa-header renew-history d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="h2">Vendor History Card</h2>
                        <p id="renewHistorySupplierName">Historical Records for [Supplier Name]</p>
                    </div>
                    <div class="coa-meta text-center">
                        <div>Vendor ID: <span id="renewHistoryVendorId">VF-1001</span></div>
                        <div>GENERATED: 29-Jul-2025</div>
                    </div>
                </div>
            </div>
            <div class="table-responsive table-container">
                <table class="table table-hover align-middle supplier-details-table">
                    <thead>
                        <tr>
                            <th><div class="th-content-wrapper"><span>Financial Year</span></div></th>
                            <th><div class="th-content-wrapper"><span>Action / Contract</span></div></th>
                            <th><div class="th-content-wrapper"><span>Audit</span></div></th>
                            <th><div class="th-content-wrapper"><span>Evaluation</span></div></th>
                            <th><div class="th-content-wrapper"><span>Complains</span></div></th>
                        </tr>
                    </thead>
                    <tbody id="renewHistoryTableBody">
                        <!-- History will be populated dynamically -->
                    </tbody>
                </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ############### COMPLAIN HISTORY MODAL ############### -->
<div class="modal fade" id="complainHistoryModal" tabindex="-1" aria-labelledby="complainHistoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="complainHistoryModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Complain History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="coa-container">
                <div class="coa-header complain-history d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h2 class="h2">Vendor Complain History</h2>
                        <p id="complainHistorySupplierName">Complain Records for [Supplier Name]</p>
                    </div>
                     <div class="coa-meta text-center">
                        <div>Vendor ID: <span id="complainHistoryVendorId">VF-1001</span></div>
                        <div>GENERATED: 29-Jul-2025</div>
                    </div>
                </div>
            </div>
            <div class="table-responsive table-container d-none d-lg-block">
                <table class="table table-hover align-middle supplier-details-table">
                    <thead>
                        <tr>
                            <th><div class="th-content-wrapper"><span>Sl. No</span></div></th>
                            <th><div class="th-content-wrapper"><span>Complain Date & Reporter</span></div></th>
                            <th><div class="th-content-wrapper"><span>Nature of Complain</span></div></th>
                            <th><div class="th-content-wrapper"><span>Root Cause Analysis</span></div></th>
                            <th><div class="th-content-wrapper"><span>Action Taken</span></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="cell-primary d-block">1</span></td>
                            <td><span class="cell-primary d-block">2024-07-28</span><span class="cell-secondary">By: John Doe (QA)</span></td>
                            <td><span class="cell-primary d-block">Foreign object found</span><span class="cell-secondary">Product: Soya Chunks (Batch #SC12345)</span></td>
                            <td><span class="cell-primary d-block">Contamination during packaging</span><span class="cell-secondary">Cause: Torn sieve on line 3.</span></td>
                            <td><span class="cell-primary d-block">Status: <span class="status-closed">Closed</span></span><span class="cell-secondary">Action: Batch recalled. Sieve replaced.</span><div class="mt-2"><button class="btn btn-sm btn-outline-primary">View CAPA Report</button></div></td>
                        </tr>
                         <tr>
                            <td><span class="cell-primary d-block">2</span></td>
                            <td><span class="cell-primary d-block">2024-02-10</span><span class="cell-secondary">By: Jane Smith (Production)</span></td>
                            <td><span class="cell-primary d-block">Incorrect Labeling</span><span class="cell-secondary">Product: Veggie Nuggets (Lot #VN-0624)</span></td>
                            <td><span class="cell-primary d-block">Human error</span><span class="cell-secondary">Cause: Wrong label roll loaded.</span></td>
                            <td><span class="cell-primary d-block">Status: <span class="status-closed">Closed</span></span><span class="cell-secondary">Action: Product re-labeled. Operator retrained.</span><div class="mt-2"><button class="btn btn-sm btn-outline-primary">View CAPA Report</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-lg-none">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">Complain #1<span class="badge text-bg-success">Closed</span></div>
                    <div class="card-body visible-details"><ul class="list-group list-group-flush"><li class="list-group-item"><strong>Nature:</strong> <span class="cell-secondary">Foreign object found</span></li><li class="list-group-item"><strong>Date:</strong> <span class="cell-secondary">2024-07-28</span></li></ul></div>
                    <div class="collapse" id="complainDetails1"><div class="card-body pt-0"><ul class="list-group list-group-flush"><li class="list-group-item"><strong>Reported by:</strong><br><span class="cell-secondary">John Doe (Quality Assurance)</span></li><li class="list-group-item"><strong>Product info:</strong><br><span class="cell-secondary">Soya Chunks (Batch #SC12345)</span></li><li class="list-group-item"><strong>Root Cause:</strong><br><span class="cell-secondary">Contamination during packaging due to torn sieve.</span></li><li class="list-group-item"><strong>Action Taken:</strong><br><span class="cell-secondary">Batch recalled and sieve replaced.</span><div class="mt-2"><button class="btn btn-sm btn-outline-primary">View CAPA</button></div></li></ul></div></div>
                    <div class="card-footer text-center"><button class="btn btn-sm btn-light w-100" data-bs-toggle="collapse" data-bs-target="#complainDetails1" aria-expanded="false" aria-controls="complainDetails1">View Details <i class="bi bi-chevron-down"></i></button></div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ############### BULK UPLOAD MODAL (STEP 1) ############### -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulkUploadModalLabel"><i class="bi bi-upload me-2"></i>Bulk Upload Suppliers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Upload a CSV file with supplier data. Please ensure the format matches the provided template to avoid errors.</p>
        <div class="mb-3">
          <a id="downloadSampleCsvLink" class="download-link d-inline-block">
            <i class="bi bi-file-earmark-arrow-down me-1"></i>Download CSV Template
          </a>
        </div>

        <hr>
        <div class="mb-3">
            <label for="csvFileInput" class="form-label">Select CSV File</label>
            <input class="form-control" type="file" id="csvFileInput" accept=".csv">
        </div>
        <div class="alert alert-info small d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>
                After uploading, you will be able to review all entries before they are added to the system.
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="uploadAndReviewBtn">Upload & Review</button>
      </div>
    </div>
  </div>
</div>

<!-- ############### BULK UPLOAD REVIEW MODAL (STEP 2) ############### -->
<div class="modal fade" id="bulkUploadReviewModal" tabindex="-1" aria-labelledby="bulkUploadReviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bulkUploadReviewModalLabel"><i class="bi bi-check2-square me-2"></i>Review Bulk Upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted">Review the data from your CSV file. You can edit fields directly in the table. Use the checkboxes to select which records to import.</p>
        
        <!-- DUPLICATES TABLE -->
        <h2 class="h5 mt-2"><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Duplicate Records (Review Required)</h2>
        <div class="table-responsive table-container">
            <table class="table table-hover align-middle supplier-details-table">
                <thead>
                    <tr>
                        <th style="width: 5%;"><input class="form-check-input" type="checkbox" id="selectAllDuplicates"></th>
                        <th>Status</th>
                        <th>Supplier Details</th>
                        <th>Contract Details</th>
                    </tr>
                </thead>
                <tbody id="reviewDuplicateTableBody">
                    <!-- JS will populate this content -->
                </tbody>
            </table>
        </div>

        <!-- NEW RECORDS TABLE -->
        <h2 class="h5 mt-4"><i class="bi bi-plus-circle-fill text-success me-2"></i>New Records</h2>
        <div class="table-responsive table-container">
            <table class="table table-hover align-middle supplier-details-table">
                <thead>
                     <tr>
                        <th style="width: 5%;"><input class="form-check-input" type="checkbox" id="selectAllNew"></th>
                        <th>Status</th>
                        <th>Supplier Details</th>
                        <th>Contract Details</th>
                    </tr>
                </thead>
                <tbody id="reviewNewTableBody">
                    <!-- JS will populate this content -->
                </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <div>
            <button type="button" class="btn btn-outline-primary btn-sm" id="selectAllBtn">Select All</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="deselectAllBtn">Deselect All</button>
        </div>
        <div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" id="confirmImportBtn">
                <i class="bi bi-check-circle-fill me-2"></i>Import Selected (<span id="importCount">0</span>)
            </button>
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Static modal structure -->
<!-- Bootstrap Modal -->
@foreach($suppliers as $supplier)
<div class="modal fade" id="listingModal{{ $supplier->id }}" tabindex="-1" aria-labelledby="listingModalLabel{{ $supplier->id }}" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="listingModalLabel{{ $supplier->id }}">Supplier Listing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0"> <!-- removed extra padding -->
        <iframe 
            src="{{ route('supplier.add.and.view.list', $supplier->id) }}" 
            class="w-100 h-100 border-0" 
            style="min-height: 100vh;"
        ></iframe>
      </div>
    </div>
  </div>
</div>
@endforeach


<!-- SheetJS (xlsx) for Excel Export -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": true,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": true,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "3000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
</script>
<script>
$(document).on('change', '.acceptRejectSwitch', function () {
    let checkbox = $(this);
    let supplierId = checkbox.data('id');
    alert("aaaaa");
    alert(supplierId);
    if (checkbox.is(':checked')) {
        // Confirmation popup
        if (confirm("Are you sure you want to continue this action?")) {
            
            // ✅ User pressed Continue → send AJAX request
            $.ajax({
                url: "/supplier/reject",   // <-- apna route dalna
                type: "POST",
                data: {
                    id: supplierId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    alert("Supplier rejected successfully!");
                },
                error: function () {
                    alert("Something went wrong!");
                    checkbox.prop('checked', false); // error pr revert
                }
            });

        } else {
            // ❌ User pressed Cancel → revert checkbox
            checkbox.prop('checked', false);
        }
    }
});

</script>
<script>
// const viewListingBtn = newRow.querySelector('[data-action="view-listing"]');
// alert(viewListingBtn);
// viewListingBtn.addEventListener('click', function () {
//     const supplierId = this.getAttribute('data-supplier-id');

//     // Set supplier ID in modal
//     document.getElementById('modalSupplierId').textContent = supplierId;

//     // Optional: Load more content dynamically
//     document.getElementById('listingContentArea').innerHTML = `Loading data for <strong>${supplierId}</strong>...`;

//     // Show modal using Bootstrap
//     const modal = new bootstrap.Modal(document.getElementById('listingModal'));
//     modal.show();
// });

</script>
<script>
$(document).ready(function() {

    const bulkUploadReviewModalEl = $('#bulkUploadReviewModal')[0];

    $('#confirmImportBtn').on('click', function() {

        // ✅ select only checked new rows
        const selectedNewRows = $('#reviewNewTableBody .row-checkbox:checked', bulkUploadReviewModalEl);

        if (selectedNewRows.length === 0) {
            alert("No new suppliers selected for import.");
            return;
        }

        const suppliersToImport = [];

        selectedNewRows.each(function() {
            const $row = $(this).closest('tr');
            const $cells = $row.find('td');

            // clean email
            const emailCellText = $cells.eq(2).text();
            const emailMatch = emailCellText.match(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/);
            const email = emailMatch ? emailMatch[0] : '';

            const supplierData = {
                supplierName: $cells.eq(2).find('.cell-primary').text().trim() || '',
                serviceNature: $cells.eq(2).find('[data-field="serviceNature"]').text().trim() || '',
                email: email,
                contractType: $cells.eq(3).find('[data-field="contractType"]').text().trim() || '',
                contractNumber: $cells.eq(3).find('[contenteditable="true"]').eq(0).text().trim() || '',
                contractStartDate: $cells.eq(3).find('[contenteditable="true"]').eq(1).text().trim() || '',
                contractEndDate: $cells.eq(3).find('[contenteditable="true"]').eq(2).text().trim() || ''
            };

            suppliersToImport.push(supplierData);
        });

        // ✅ AJAX fetch with jQuery
        $.ajax({
            url: "{{route('sqa-new-supplier-update-bulk-parse')}}",
            type: "POST",
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({ suppliers: suppliersToImport }),
            success: function(data) {
                if(data.success){
                    toastr.success(`${suppliersToImport.length} supplier(s) successfully imported.`);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error('Failed to import suppliers: ' + data.message);
                }
            },
            error: function(err){
                console.error('Import error:', err);
                toastr.error('Something went wrong during import.');
            }
        });

    });

});

</script>

<script>
$(document).ready(function() {
    const bulkUploadModal = new bootstrap.Modal($('#bulkUploadModal')[0]);
    const bulkUploadReviewModal = new bootstrap.Modal($('#bulkUploadReviewModal')[0]);

    function renderPreviewFromCsv(mockCsvData) {
        const existingSuppliers = new Set();
        $('#supplierTableBody [data-field="supplierName"]').each(function() {
            existingSuppliers.add($(this).text().trim().toUpperCase());
        });

        let duplicateRowHtml = '';
        let newRowHtml = '';

        mockCsvData.forEach((row, index) => {
            const supplierName = row.supplierName ? row.supplierName.trim() : "";
            const serviceNature = row.serviceNature || "";
            const email = row.email || "";
            const contractType = row.contractType || "";
            const contractNumber = row.contractNumber || "";
            const contractStartDate = row.contractStartDate || "";
            const contractEndDate = row.contractEndDate || "";

            const isDuplicate = existingSuppliers.has(supplierName.toUpperCase());
            const status = isDuplicate
                ? `<span class="badge text-bg-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i>Duplicate</span>`
                : `<span class="badge text-bg-success"><i class="bi bi-plus-circle-fill me-1"></i>New</span>`;

            const rowContent = `
                <td><input class="form-check-input row-checkbox" type="checkbox" id="reviewCheck${index}" ${!isDuplicate ? 'checked' : ''}></td>
                <td>${status}</td>
                <td>
                    <span class="cell-primary" contenteditable="true">${supplierName}</span>
                    <span class="cell-secondary d-block">
                        <strong>Service:</strong> <span class="editable-select" data-field="serviceNature">${serviceNature}</span><br>
                        <strong>Email:</strong> <span contenteditable="true">${email}</span>
                    </span>
                </td>
                <td>
                    <span class="cell-primary d-block">Type: <span class="editable-select" data-field="contractType">${contractType}</span></span>
                    <span class="cell-secondary">
                        No: <span contenteditable="true">${contractNumber}</span><br>
                        Start Date: <span contenteditable="true">${contractStartDate}</span><br>
                        End Date: <span contenteditable="true">${contractEndDate}</span>
                    </span>
                </td>
            `;

            if(isDuplicate) duplicateRowHtml += `<tr>${rowContent}</tr>`;
            else newRowHtml += `<tr data-is-new="true">${rowContent}</tr>`;
        });

        $('#reviewDuplicateTableBody').html(duplicateRowHtml || `<tr><td colspan="4" class="text-center text-muted">No duplicate records found.</td></tr>`);
        $('#reviewNewTableBody').html(newRowHtml || `<tr><td colspan="4" class="text-center text-muted">No new records found.</td></tr>`);

        bulkUploadModal.hide();
        bulkUploadReviewModal.show();
        updateImportCountAndStyles(); // optional
    }

    // Bind click with jQuery
    $('#uploadAndReviewBtn').on('click', function() {
        const fileInput = $('#csvFileInput')[0];
        if(fileInput.files.length === 0) {
            alert('Please select a CSV file to upload.');
            return;
        }

        const file = fileInput.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const text = e.target.result;
            const lines = text.trim().split('\n');
            const headers = lines[0].split(',').map(h => h.trim());
            const mockCsvData = [];

            for(let i = 1; i < lines.length; i++) {
                const row = lines[i].split(',').map(col => col.trim());
                const rowData = {};
                headers.forEach((header, index) => { rowData[header] = row[index] || ''; });

                mockCsvData.push({
                    supplierName: rowData['supplierName'],
                    serviceNature: rowData['serviceNature'],
                    email: rowData['email'],
                    contractType: rowData['contractType'],
                    contractNumber: rowData['contractNumber'],
                    contractStartDate: rowData['contractStartDate'],
                    contractEndDate: rowData['contractEndDate']
                });
            }

            renderPreviewFromCsv(mockCsvData);
        };

        reader.readAsText(file);
    });

});



const bulkUploadReviewModalEl = document.getElementById('bulkUploadReviewModal');
const reviewDuplicateTableBody = document.getElementById('reviewDuplicateTableBody');
const reviewNewTableBody = document.getElementById('reviewNewTableBody');
const importCountSpan = document.getElementById('importCount');
const selectAllDuplicatesCheckbox = document.getElementById('selectAllDuplicates'); // optional
const selectAllNewCheckbox = document.getElementById('selectAllNew'); // optional

function updateImportCountAndStyles() {
    const allCheckboxes = bulkUploadReviewModalEl.querySelectorAll('.row-checkbox');
    let checkedCount = 0;

    allCheckboxes.forEach(checkbox => {
        const row = checkbox.closest('tr');
        if (checkbox.checked) {
            checkedCount++;
            row.classList.add('row-selected');
        } else {
            row.classList.remove('row-selected');
        }
    });
    
    importCountSpan.textContent = checkedCount;

    if(selectAllDuplicatesCheckbox){
        const allDupCheckboxes = [...reviewDuplicateTableBody.querySelectorAll('.row-checkbox')];
        selectAllDuplicatesCheckbox.checked = allDupCheckboxes.length > 0 && allDupCheckboxes.every(cb => cb.checked);
    }

    if(selectAllNewCheckbox){
        const allNewCheckboxes = [...reviewNewTableBody.querySelectorAll('.row-checkbox')];
        selectAllNewCheckbox.checked = allNewCheckboxes.length > 0 && allNewCheckboxes.every(cb => cb.checked);
    }
}

// Bind change event
$(document).on('change', '.row-checkbox', updateImportCountAndStyles);

</script>



<script>
$(document).on('click', '#applyFilter1', function () {
    let formData = {
        supplierName: $('input[name="supplierName"]').val(),
        serviceNature: $('input[name="serviceNature1"]').val(),
        supplierStatus: $('input[name="supplierStatus[]"]:checked').map(function(){ return this.value }).get(),
        licenseStatus: $('input[name="licenseStatus[]"]:checked').map(function(){ return this.value }).get(),
    };

    $.ajax({
        url: "{{ route('sqa.suplier.list') }}",
        type: "GET",
        data: formData,
        success: function(response) {
            $('#supplierTableBody').html(response.html);
            $('.div-pagination-container').html(response.pagination);
        }
    });
});

$(document).on('click', '.div-pagination-container a', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            supplierName: $('input[name="supplierName"]').val(),
            serviceNature: $('input[name="serviceNature1"]').val(),
            supplierStatus: $('input[name="supplierStatus[]"]:checked').map(function(){ return this.value }).get(),
            licenseStatus: $('input[name="licenseStatus[]"]:checked').map(function(){ return this.value }).get(),
        },
        success: function(response) {
            $('#supplierTableBody').html(response.html);
            $('.div-pagination-container').html(response.pagination);
        }
    });
});


</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Global Data Stores ---
    const logData = {}; // For Log Book

    // --- ############### COMPLIANCE TICKET DATA & LOGIC ############### ---
    let complianceTicketIdCounter = 100;
    const complianceData = {
        "supplier-1": [
            {
                id: 1,
                title: "Labeling Errors",
                createdBy: "Jane Doe",
                createdAt: "2/7/2023, 7:30:00 pm",
                status: "Open",
                supplierId: "supplier-1",
                supplierName: "VEZLAY FOODS PVT LTD",
                actionPoints: [
                    { id: 10, text: "Allergen declaration missing.", status: "Open", resolvedBy: null, resolvedAt: null, resolutionDetails: null },
                    { id: 11, text: "Net weight font too small.", status: "Resolved", resolvedBy: "John Smith", resolvedAt: "5/7/2023", resolutionDetails: "Reprinted labels with correct font size." }
                ]
            }
        ],
        "supplier-2": [
            {
                id: 2,
                title: "Incorrect Invoice Details",
                createdBy: "Peter Jones",
                createdAt: "3/15/2023, 10:00:00 am",
                status: "Resolved",
                supplierId: "supplier-2",
                supplierName: "AgriFresh Suppliers",
                actionPoints: [
                    { id: 12, text: "Invoice #5889 had wrong PO number.", status: "Resolved", resolvedBy: "Admin", resolvedAt: "3/16/2023", resolutionDetails: "Corrected invoice received and processed." }
                ]
            }
        ],
        "supplier-3": []
    };
    
    const complianceLogModalEl = document.getElementById('complianceLogModal');
    const complianceLogModal = new bootstrap.Modal(complianceLogModalEl);
    const complianceCenterModalEl = document.getElementById('complianceCenterModal');
    const complianceCenterModal = new bootstrap.Modal(complianceCenterModalEl);
    const resolveActionPointModalEl = document.getElementById('resolveActionPointModal');
    const resolveActionPointModal = new bootstrap.Modal(resolveActionPointModalEl);
    const newComplianceTicketForm = document.getElementById('newComplianceTicketForm');
    const actionPointsContainer = document.getElementById('actionPointsContainer');
    const addAnotherPointBtn = document.getElementById('addAnotherPointBtn');
    
    function addActionPointInput(text = '') {
        const pointId = `point-${Date.now()}`;
        const newPointHTML = `
            <div class="action-point-input-group" id="group-${pointId}">
                <input type="text" class="form-control" placeholder="Action point..." value="${text}" required>
                <button type="button" class="btn btn-sm btn-danger remove-point-btn" aria-label="Remove point"><i class="bi bi-x-lg"></i></button>
            </div>`;
        actionPointsContainer.insertAdjacentHTML('beforeend', newPointHTML);
    }

    addAnotherPointBtn.addEventListener('click', () => addActionPointInput());
    
    actionPointsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-point-btn')) {
            e.target.closest('.action-point-input-group').remove();
        }
    });

    function checkAndToggleRibbon() {
        const ribbon = document.getElementById('breakingNewsRibbon');
        const allTickets = Object.values(complianceData).flat();
        const openTickets = allTickets.filter(ticket => ticket.status === 'Open');

        if (openTickets.length > 0) {
            const ribbonContent = document.getElementById('breakingNewsContent');
            const messages = openTickets.map(t => `<i class="bi bi-exclamation-triangle-fill"></i> OPEN TICKET for ${t.supplierName}: "${t.title}" `).join('');
            ribbonContent.innerHTML = messages;
            ribbon.style.display = 'block';
        } else {
            ribbon.style.display = 'none';
        }
    }


    function updateOpenTicketCounts() {
        document.querySelectorAll('[data-supplier-id]').forEach(element => {
            const supplierId = element.dataset.supplierId;
            const openTicketsCount = (complianceData[supplierId] || []).filter(t => t.status === 'Open').length;
            
            const placeholder = element.querySelector('.open-ticket-button-placeholder');
            if (placeholder) {
                if (openTicketsCount > 0) {
                    placeholder.innerHTML = `
                        <button class="btn btn-sm btn-danger position-relative" data-bs-toggle="modal" data-bs-target="#complianceLogModal">
                            Open Tickets
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-danger border border-danger">
                                ${openTicketsCount}
                            </span>
                        </button>`;
                } else {
                    placeholder.innerHTML = '';
                }
            }
        });
    }

    function renderComplianceTickets(supplierId, container, ticketIdToFocus = null) {
        let ticketsToRender = complianceData[supplierId] || [];

        // If a specific ticket ID is provided, filter for that ticket only
        if (ticketIdToFocus) {
            ticketsToRender = ticketsToRender.filter(t => t.id == ticketIdToFocus);
        }

        if (ticketsToRender.length === 0) {
            container.innerHTML = '<p class="text-muted">No compliance tickets found for this view.</p>';
            return;
        }

        let ticketsHtml = ticketsToRender.map(ticket => {
            const statusBadge = ticket.status === 'Open' 
                ? '<span class="badge bg-danger badge-status">Open</span>' 
                : '<span class="badge bg-success badge-status">Resolved</span>';

            const actionPointsHtml = ticket.actionPoints.map(point => {
                let actionControl = '';
                if (point.status === 'Open') {
                    actionControl = `<button class="btn btn-sm btn-success resolve-btn" data-bs-toggle="modal" data-bs-target="#resolveActionPointModal" data-supplier-id="${ticket.supplierId}" data-ticket-id="${ticket.id}" data-point-id="${point.id}">Resolve</button>`;
                } else {
                    actionControl = `
                        <div class="resolved-text text-end">
                            Resolved by ${point.resolvedBy} on ${point.resolvedAt}<br>
                            <em>${point.resolutionDetails}</em> 
                            <a href="#" class="ms-1">View Evidence</a>
                        </div>`;
                }
                return `
                    <div class="d-flex justify-content-between align-items-center action-point-item">
                        <span>${point.text}</span>
                        ${actionControl}
                    </div>`;
            }).join('');
            
            return `
                <div class="compliance-ticket-item">
                    <div class="compliance-ticket-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="h6 mb-0">${ticket.title}</h6>
                            <small>Created by ${ticket.createdBy} on ${ticket.createdAt}</small>
                        </div>
                        ${statusBadge}
                    </div>
                    <div class="compliance-ticket-body">
                        ${actionPointsHtml}
                    </div>
                </div>`;
        }).join('');
        container.innerHTML = ticketsHtml;
    }

    complianceLogModalEl.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const supplierContainer = button.closest('[data-supplier-id]');
        
        const supplierId = this.dataset.currentSupplier || (supplierContainer ? supplierContainer.dataset.supplierId : null);
        const ticketId = this.dataset.currentTicket || null;

        if (!supplierId) return; // Should not happen if triggered correctly

        this.dataset.currentSupplier = supplierId; // Ensure it's set for other functions
        
        const supplierName = document.querySelector(`[data-supplier-id="${supplierId}"] [data-field="supplierName"]`).textContent;
        document.getElementById('complianceSupplierName').textContent = supplierName;
        
        // If we are viewing a specific ticket (from compliance center), hide the create form
        const createTicketContainer = document.getElementById('createTicketContainer');
        createTicketContainer.style.display = ticketId ? 'none' : 'block';

        renderComplianceTickets(supplierId, document.getElementById('complianceTicketsContainer'), ticketId);
        
        if (!ticketId) { // Only reset form if not viewing a specific ticket
            newComplianceTicketForm.reset();
            actionPointsContainer.innerHTML = '';
            addActionPointInput();
            newComplianceTicketForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        }
    });
    
    // Clear the programmatically set data when the modal hides to ensure correct context next time
    complianceLogModalEl.addEventListener('hidden.bs.modal', function() {
        delete this.dataset.currentSupplier;
        delete this.dataset.currentTicket;
    });

    newComplianceTicketForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const supplierId = complianceLogModalEl.dataset.currentSupplier;
        if (!supplierId) return;

        const titleInput = document.getElementById('ticketTitle');
        const pointInputs = actionPointsContainer.querySelectorAll('input');
        
        let isValid = true;
        if (!titleInput.value.trim()) {
            titleInput.classList.add('is-invalid');
            isValid = false;
        } else {
            titleInput.classList.remove('is-invalid');
        }
        const validPoints = Array.from(pointInputs).filter(input => input.value.trim());
        if (validPoints.length === 0) {
            actionPointsContainer.classList.add('is-invalid');
            isValid = false;
        } else {
            actionPointsContainer.classList.remove('is-invalid');
        }

        if (!isValid) return;

        const newTicket = {
            id: complianceTicketIdCounter++,
            title: titleInput.value.trim(),
            createdBy: 'Current User',
            createdAt: new Date().toLocaleString(),
            status: 'Open',
            supplierId: supplierId,
            supplierName: document.querySelector(`[data-supplier-id="${supplierId}"] [data-field="supplierName"]`).textContent,
            actionPoints: validPoints.map(input => ({
                id: complianceTicketIdCounter++,
                text: input.value.trim(),
                status: 'Open',
                resolvedBy: null,
                resolvedAt: null,
                resolutionDetails: null
            }))
        };

        if (!complianceData[supplierId]) {
            complianceData[supplierId] = [];
        }
        complianceData[supplierId].unshift(newTicket);
        
        renderComplianceTickets(supplierId, document.getElementById('complianceTicketsContainer'));
        this.reset();
        actionPointsContainer.innerHTML = '';
        addActionPointInput();
        
        updateOpenTicketCounts();
        checkAndToggleRibbon();
    });

    resolveActionPointModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const { supplierId, ticketId, pointId } = button.dataset;

        this.dataset.supplierId = supplierId;
        this.dataset.ticketId = ticketId;
        this.dataset.pointId = pointId;

        const ticket = complianceData[supplierId]?.find(t => t.id == ticketId);
        const point = ticket?.actionPoints.find(p => p.id == pointId);

        if(point) {
            document.getElementById('actionPointText').textContent = point.text;
        }
        document.getElementById('resolveActionPointForm').reset();
        document.getElementById('resolutionNotes').classList.remove('is-invalid');
    });

    document.getElementById('resolveActionPointForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const { supplierId, ticketId, pointId } = resolveActionPointModalEl.dataset;
        const notesInput = document.getElementById('resolutionNotes');

        if (!notesInput.value.trim()) {
            notesInput.classList.add('is-invalid');
            return;
        }
        notesInput.classList.remove('is-invalid');

        const ticket = complianceData[supplierId].find(t => t.id == ticketId);
        const point = ticket.actionPoints.find(p => p.id == pointId);

        if (point) {
            point.status = 'Resolved';
            point.resolvedBy = 'Current User'; 
            point.resolvedAt = new Date().toLocaleDateString();
            point.resolutionDetails = notesInput.value.trim();
        }

        const allPointsResolved = ticket.actionPoints.every(p => p.status === 'Resolved');
        if (allPointsResolved) {
            ticket.status = 'Resolved';
        }
        
        resolveActionPointModal.hide();
    });

    resolveActionPointModalEl.addEventListener('hidden.bs.modal', function() {
        if (complianceLogModalEl.classList.contains('show')) {
            const currentSupplier = complianceLogModalEl.dataset.currentSupplier;
            const currentTicket = complianceLogModalEl.dataset.currentTicket;
            renderComplianceTickets(currentSupplier, document.getElementById('complianceTicketsContainer'), currentTicket);
        }
        updateOpenTicketCounts();
        checkAndToggleRibbon();
    });

    // --- Compliance Center Logic ---
    function renderComplianceCenter() {
        const container = document.getElementById('complianceCenterBody');
        const allTickets = Object.values(complianceData).flat();
        
        const openTickets = allTickets.filter(t => t.status === 'Open');
        const resolvedTickets = allTickets.filter(t => t.status === 'Resolved');

        let html = '';

        // Render Open Tickets Section
        html += '<h5 class="mb-3">Open Action Points</h5>';
        if (openTickets.length > 0) {
            openTickets.forEach(ticket => {
                const openPoints = ticket.actionPoints.filter(p => p.status === 'Open');
                if (openPoints.length === 0) return;

                const pointsList = openPoints.map(p => `<li>${p.text}</li>`).join('');
                
                html += `
                    <div class="compliance-summary-item">
                        <div class="supplier-name">${ticket.supplierName}</div>
                        <div class="ticket-title">${ticket.title} (${openPoints.length} open point${openPoints.length > 1 ? 's' : ''})</div>
                        <ul>${pointsList}</ul>
                        <button class="btn btn-primary btn-sm view-full-ticket-btn" data-supplier-id="${ticket.supplierId}" data-ticket-id="${ticket.id}">
                            View Full Ticket
                        </button>
                    </div>
                `;
            });
        } else {
            html += '<p class="text-muted">No open action points found.</p>';
        }

        // Render Resolved Tickets Section
        if (resolvedTickets.length > 0) {
            html += '<hr class="my-4">';
            html += '<h5 class="mb-3">Resolved History</h5>';
            resolvedTickets.forEach(ticket => {
                const resolvedPoints = ticket.actionPoints.filter(p => p.status === 'Resolved');
                if(resolvedPoints.length === 0) return;

                const pointsList = resolvedPoints.map(p => `<li>${p.text} <small class="text-muted fst-italic">- Resolved ${p.resolvedAt}</small></li>`).join('');

                html += `
                    <div class="compliance-summary-item resolved-item bg-light">
                        <div class="supplier-name">${ticket.supplierName}</div>
                        <div class="ticket-title text-muted"><i class="bi bi-check-circle-fill text-success me-2"></i>${ticket.title}</div>
                        <ul>${pointsList}</ul>
                        <button class="btn btn-outline-secondary btn-sm view-full-ticket-btn" data-supplier-id="${ticket.supplierId}" data-ticket-id="${ticket.id}">
                            View Full Ticket
                        </button>
                    </div>
                `;
            });
        }

        if (openTickets.length === 0 && resolvedTickets.length === 0) {
            container.innerHTML = '<p class="text-center text-muted">No compliance history found.</p>';
        } else {
            container.innerHTML = html;
        }
    }

    complianceCenterModalEl.addEventListener('show.bs.modal', renderComplianceCenter);

    document.getElementById('complianceCenterBody').addEventListener('click', function(e) {
        if (e.target.classList.contains('view-full-ticket-btn')) {
            const { supplierId, ticketId } = e.target.dataset;
            
            complianceLogModalEl.dataset.currentSupplier = supplierId;
            complianceLogModalEl.dataset.currentTicket = ticketId;
            
            complianceCenterModal.hide();
            complianceLogModal.show();
        }
    });

    // --- ############### RENEW LOGIC ############### ---
    const renewModalEl = document.getElementById('renewModal');
    const renewModal = new bootstrap.Modal(renewModalEl);
    const confirmRenewBtn = document.getElementById('confirmRenewBtn');
    
    renewModalEl.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const supplierContainer = button.closest('[data-supplier-id]');
        const supplierId = supplierContainer.dataset.supplierId;
        this.dataset.supplierId = supplierId;

        const supplierName = supplierContainer.querySelector('[data-field="supplierName"]').textContent;
        const endDateEl = supplierContainer.querySelector('[data-field="contract-end-date"]');
        
        const currentDate = new Date(endDateEl.textContent);
        currentDate.setFullYear(currentDate.getFullYear() + 1);
        const newDateString = currentDate.toISOString().split('T')[0];
        
        document.getElementById('renewSupplierName').textContent = supplierName;
        document.getElementById('newContractEndDate').textContent = newDateString;
    });

    confirmRenewBtn.addEventListener('click', function() {
        const supplierId = renewModalEl.dataset.supplierId;
        const supplierElements = document.querySelectorAll(`[data-supplier-id="${supplierId}"]`);
        
        const oldDateEl = supplierElements[0].querySelector('[data-field="contract-end-date"]');
        const oldDate = oldDateEl.textContent;
        
        const newDate = document.getElementById('newContractEndDate').textContent;

        supplierElements.forEach(el => {
            el.querySelector('[data-field="contract-end-date"]').textContent = newDate;
        });

        logChange(supplierId, 'Contract Renewal', oldDate, newDate);
        addHistoryEntry(supplierId, `Contract renewed to ${newDate}`);
        updateLastUpdatedTimestamp(supplierId);
        calculateAndDisplayContractStatus();
        renewModal.hide();
    });


    // --- Initialize Tooltips ---
    let tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    let tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // --- Initialize Select2 on Modal Dropdowns ---
    $('#newSupplierModal select, #editSupplierModal select').each(function () {
        $(this).select2({
            theme: 'bootstrap-5',
            dropdownParent: $(this).closest('.modal')
        });
    });
    
    const tableBody = document.getElementById('supplierTableBody');
    const cardContainer = document.getElementById('supplierCardContainer');
    let newSupplierIdCounter = 100; // Counter for unique IDs for new suppliers
    const paginationInfo = document.getElementById('paginationInfo');
    const allFilterForms = document.querySelectorAll('.dropdown-menu form, #mobileFilterModal form');
    const mobileFilterForms = document.querySelectorAll('#mobileFilterModal form');
    const refreshBtn = document.getElementById('refreshBtn');
    const globalSearchInput = document.getElementById('globalSearch');
    const clearMobileFiltersBtn = document.getElementById('clearMobileFilters');

    // --- ############### LOG BOOK & DATA UPDATE LOGIC (TASK 1 & 3) ############### ---
    
    /**
     * Records a change in the log book for a specific supplier.
     * @param {string} supplierId - The ID of the supplier.
     * @param {string} action - The action performed or field changed.
     * @param {string} oldValue - The value before the change.
     * @param {string} newValue - The value after the change.
     * @param {string} [user='Admin'] - The user who made the change.
     */
    function logChange(supplierId, action, oldValue, newValue, user = 'Admin') {
        if (!logData[supplierId]) {
            logData[supplierId] = [];
        }
        logData[supplierId].unshift({
            timestamp: new Date(),
            user,
            action,
            oldValue,
            newValue
        });
    }
    
    /**
     * Updates the 'Last Updated' timestamp for a supplier and logs the event.
     * @param {string} supplierId - The ID of the supplier to update.
     */
    function updateLastUpdatedTimestamp(supplierId) {
        const newTimestamp = new Date().toLocaleString();
        document.querySelectorAll(`[data-supplier-id="${supplierId}"] .last-updated`).forEach(el => {
            const oldTimestamp = el.textContent;
            el.textContent = newTimestamp;
        });
    }

    const logBookModalEl = document.getElementById('logBookModal');
    logBookModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const supplierContainer = button.closest('[data-supplier-id]');
        if (!supplierContainer) return;

        const supplierId = supplierContainer.dataset.supplierId;
        const supplierName = supplierContainer.querySelector('[data-field="supplierName"]').textContent;

        document.getElementById('logBookSupplierName').textContent = supplierName;
        const logBookTableBody = document.getElementById('logBookTableBody');
        const logs = logData[supplierId] || [];

        if (logs.length === 0) {
            logBookTableBody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No changes have been recorded for this supplier.</td></tr>`;
        } else {
            logBookTableBody.innerHTML = logs.map(log => `
                <tr>
                    <td>${log.timestamp.toLocaleString()}</td>
                    <td>${log.user}</td>
                    <td>${log.action}</td>
                    <td class="old-value">${log.oldValue !== null ? log.oldValue : 'N/A'}</td>
                    <td class="new-value">${log.newValue !== null ? log.newValue : 'N/A'}</td>
                </tr>
            `).join('');
        }
    });


    // --- ############### EXCEL EXPORT LOGIC (UPDATED) ############### ---
    const downloadExcelBtn = document.getElementById('downloadExcelBtn');

    // function exportTableToExcel() {
    //     const table = document.querySelector('.supplier-details-table');
    //     // const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
    //      const visibleRows = table.querySelectorAll('tbody tr');
        
    //     if (visibleRows.length === 0) {
    //         alert("No data available to export.");
    //         return;
    //     }
        
    //     // Define headers including new ones
    //     const headers = [
    //         "Hierarchy", "Supplier Name", "Supplier Status", "Data Updated On", "Uploaded By", "Service Nature",
    //         "Email", "Address", "FSSAI Number", "License Status", "Approval Status",
    //         "Contract Type", "Contract No", "Contract Start Date", "Contract End Date", "Contract Validity Status", "Contract Upload Status",
    //         "Risk Category", "Items", "Total Items",
    //         "Audit Score", "Audit Frequency", "Last Audit Date", "Audit NCs",
    //         "Evaluation Score (%)", "Evaluation Target (%)", "Evaluation Frequency", "Last Evaluation Date",
    //         "Total Complains", "Last Complain Date", "Overall Status"
    //     ];
        
    //     let data = [headers];

    //     visibleRows.forEach(row => {
    //         const cells = row.cells;
    //         let rowData = [];

    //         // Helper to get text content safely
    //         const getText = (selector) => row.querySelector(selector)?.textContent.trim() || 'N/A';

    //         // Column 0: Hierarchy
    //         rowData.push(getText('[data-field="hierarchy"]'));

    //         // Column 1: Supplier Details
    //         const secondaryText1 = getText('.cell-secondary');
    //         const lines1 = secondaryText1.split('\n');
    //         rowData.push(getText('[data-field="supplierName"]')); // Name
    //         rowData.push(getText('.badge:not(.contract-status-badge)')); // Supplier Status (Active/Inactive)
    //         rowData.push(getText('.last-updated')); // Data Updated On
    //         rowData.push(lines1.find(l => l.includes('Uploaded by:'))?.split(':')[1]?.trim() || 'N/A');
    //         rowData.push(getText('[data-field="serviceNature"]'));
    //         rowData.push(getText('[data-field="email"]'));
    //         rowData.push(getText('[data-field="address"]'));
    //         rowData.push(getText('.fssai-number') || 'Not Added');
    //         rowData.push(getText('[data-field="license-status"]') || 'Not Added');
    //         rowData.push(getText('.form-switch-accept-reject .form-check-label'));

    //         // Column 2: Contract
    //         rowData.push(getText('[data-field="contractType"]'));
    //         rowData.push(getText('[data-field="contractNumber"]'));
    //         const secondaryText2 = getText('td:nth-child(3) .cell-secondary');
    //         const startDateMatch = secondaryText2.match(/Start:\s*(\S+)/);
    //         rowData.push(startDateMatch ? startDateMatch[1] : 'N/A');
    //         rowData.push(getText('[data-field="contract-end-date"]'));
    //         rowData.push(getText('[data-field="contract-status"]')); // Contract Validity Status
    //         rowData.push(row.querySelector('.upload-container .btn') ? 'Not Uploaded' : 'Uploaded');

    //         // Column 3: List / Risk
    //         const secondaryText3 = getText('td:nth-child(4) .cell-secondary');
    //         const totalItemsMatch = secondaryText3.match(/Total Items:\s*(\d+)/);
    //         rowData.push(getText('.risk-category'));
    //         rowData.push(totalItemsMatch ? secondaryText3.split('Total Items:')[0].trim().replace(/\n/g, ', ') : secondaryText3);
    //         rowData.push(totalItemsMatch ? totalItemsMatch[1] : 'N/A');

    //         // Column 4: Audit
    //         const primaryText4 = getText('td:nth-child(5) .cell-primary');
    //         const secondaryText4 = getText('td:nth-child(5) .cell-secondary');
    //         const freqMatch4 = secondaryText4.match(/Freq:\s*([^|]+)/);
    //         const lastDateMatch4 = secondaryText4.match(/Last:\s*([^\n]+)/);
    //         const ncMatch4 = secondaryText4.match(/NCs:\s*(.*)/);
    //         rowData.push(primaryText4.split('/')[0].trim());
    //         rowData.push(freqMatch4 ? freqMatch4[1].trim() : 'N/A');
    //         rowData.push(lastDateMatch4 ? lastDateMatch4[1].trim() : 'N/A');
    //         rowData.push(ncMatch4 ? ncMatch4[1].trim() : 'N/A');

    //         // Column 5: Evaluation
    //         const primaryText5 = getText('td:nth-child(6) .cell-primary');
    //         const secondaryText5 = getText('td:nth-child(6) .cell-secondary');
    //         const freqMatch5 = secondaryText5.match(/Freq:\s*([^|]+)/);
    //         const lastDateMatch5 = secondaryText5.match(/Last:\s*([^\n]+)/);
    //         rowData.push(primaryText5.split('/')[0]?.trim().replace('%', ''));
    //         rowData.push(primaryText5.split('/')[1]?.trim().replace('>', '').replace('%', '') || 'N/A');
    //         rowData.push(freqMatch5 ? freqMatch5[1].trim() : 'N/A');
    //         rowData.push(lastDateMatch5 ? lastDateMatch5[1].trim() : 'N/A');
            
    //         // Column 6: Complains
    //         const primaryText6 = getText('td:nth-child(7) .cell-primary');
    //         const secondaryText6 = getText('td:nth-child(7) .cell-secondary');
    //         const complainCountMatch = primaryText6.match(/(\d+)/);
    //         const lastComplainDateMatch = secondaryText6.match(/Last:\s*(.*)/);
    //         rowData.push(complainCountMatch ? complainCountMatch[1] : '0');
    //         rowData.push(lastComplainDateMatch ? lastComplainDateMatch[1].trim() : 'N/A');

    //         // Column 7: Action (Overall Status)
    //         rowData.push(getText('td:nth-child(8) .form-check-label'));

    //         data.push(rowData);
    //     });

    //     const ws = XLSX.utils.aoa_to_sheet(data);
    //     const wb = XLSX.utils.book_new();
    //     XLSX.utils.book_append_sheet(wb, ws, "Supplier_Details");
    //     XLSX.writeFile(wb, "Supplier_Details_Report.xlsx");
    // }

function exportTableToExcel() {
    fetch("{{route('suppliers.export-all')}}")
    .then(function(res) {
        return res.json();
    })
    .then(function(suppliers) {
        if (!suppliers.length) {
            alert("No data available to export.");
            return;
        }

        // Define headers
        var headers = [
            "Hierarchy", "Supplier Name", "Supplier Status", "Data Updated On", "Uploaded By", "Service Nature",
            "Email", "Address", "FSSAI Number", "License Status", "Approval Status",
            "Contract Type", "Contract No", "Contract Start Date", "Contract End Date", "Contract Validity Status", "Contract Upload Status",
            "Risk Category", "Items", "Total Items",
            "Audit Score", "Audit Frequency", "Last Audit Date", "Audit NCs",
            "Evaluation Score (%)", "Evaluation Target (%)", "Evaluation Frequency", "Last Evaluation Date",
            "Total Complains", "Last Complain Date", "Overall Status"
        ];

        var data = [headers];

        suppliers.forEach(function(s) {
            var rowData = [];

        const currentDate = new Date(); // current date
        
        rowData.push(s.hierarchy || 'N/A');                  // hierarchy
        rowData.push(s.name || 'N/A');                       // name
        rowData.push(s.status == 1 ? 'Active' : 'Not Active'); // status
        rowData.push(s.updated_at || 'N/A');                 // updated_at
        rowData.push(s.created || 'N/A');                    // created
        rowData.push(s.service_nature || 'N/A');            // service_nature
        rowData.push(s.email || 'N/A');                      // email
        rowData.push(s.full_address || 'N/A');                      // email
        rowData.push(s.license_number || 'Not Added');       // license_number
        
        // Correct date comparison for license expiry
        rowData.push(
            s.license_expiry_date 
            ? (new Date(s.license_expiry_date) > currentDate ? 'Valid' : 'Not Valid') 
            : 'N/A'
        );
        rowData.push(s.status == 1 ? 'Active' : 'Not Active'); // status
        
        // Contract fields
        rowData.push(s.contract_type || 'N/A');              // contract_type
        rowData.push(s.contract_number || 'N/A');            // contract_number
        rowData.push(s.contract_start_date || 'N/A');        // contract_start_date
        rowData.push(s.contract_end_date || 'N/A');          // contract_end_date
        
        // Correct date comparison for contract validity
        rowData.push(
            s.contract_end_date 
            ? (new Date(s.contract_end_date) > currentDate ? 'Valid' : 'Expired') 
            : 'N/A'
        );
        
        rowData.push(s.contract_document ? 'Uploaded' : 'Not Uploaded'); // contract_document


            rowData.push(s.risk || 'N/A');
            rowData.push(s.itemsList || '0');
            rowData.push(s.vendor_count ?? 'N/A');

            rowData.push('88');
            rowData.push('Annually');
            rowData.push('2023-11-15NCs: 3 Closed / 1 Open');
            rowData.push('3 Closed / 1 Open');

            rowData.push('88');
            rowData.push('85');
            rowData.push('Annually');
            rowData.push('2023-11-20');

            rowData.push('2');
            rowData.push('2023-11-20');

            rowData.push('2023-11-20');

            data.push(rowData);
        });

        var ws = XLSX.utils.aoa_to_sheet(data);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Supplier_Details");
        XLSX.writeFile(wb, "Supplier_Details_Report.xlsx");
    })
    .catch(function(err) {
        console.error(err);
        alert("Failed to fetch data from backend.");
    });
}
    downloadExcelBtn.addEventListener('click', exportTableToExcel);

    // --- RENEW HISTORY & AUDIT TRAIL LOGIC ---
    const renewHistoryModalEl = document.getElementById('renewHistoryModal');
    
    const initialHistory = {
        'supplier-1': `
            <tr><td><span class="cell-primary d-block">2023-2024</span></td><td><span class="cell-primary d-block">Type: Annual Rate</span><span class="cell-secondary">Start: 2023-01-01 | End: 2023-12-31</span></td><td><span class="cell-primary d-block">95 / 100</span><span class="cell-secondary">Freq: Annually</span></td><td><span class="cell-primary d-block">95% / >90%</span><span class="cell-secondary">Exceeds target.</span></td><td><span class="cell-primary d-block">0 Complains</span></td></tr>`,
        'supplier-2': `
            <tr><td><span class="cell-primary d-block">2023-2024</span></td><td><span class="cell-primary d-block">Type: Quarterly Supply</span><span class="cell-secondary">Start: 2023-10-01 | End: 2023-12-31</span></td><td><span class="cell-primary d-block">92 / 100</span><span class="cell-secondary">Freq: Quarterly</span></td><td><span class="cell-primary d-block">94% / >90%</span><span class="cell-secondary">Exceeds target.</span></td><td><span class="cell-primary d-block">1 Complain</span></td></tr>`,
        'supplier-3': `
            <tr><td><span class="cell-primary d-block">2023-2024</span></td><td><span class="cell-primary d-block">Type: Annual Service</span><span class="cell-secondary">Start: 2023-02-01 | End: 2024-01-31</span></td><td><span class="cell-primary d-block">99 / 100</span><span class="cell-secondary">Freq: Half-Yearly</span></td><td><span class="cell-primary d-block">98% / >90%</span><span class="cell-secondary">Exceeds target.</span></td><td><span class="cell-primary d-block">0 Complains</span></td></tr>`
    };

    function addHistoryEntry(supplierId, actionText) {
        const currentDate = new Date().toISOString().split('T')[0];
        const currentYear = new Date().getFullYear();
        const financialYear = `${currentYear}-${currentYear + 1}`;

        const newHistoryRowHTML = `
            <tr>
                <td><span class="cell-primary d-block">${financialYear}</span></td>
                <td>
                    <span class="cell-primary d-block">${actionText}</span>
                    <span class="cell-secondary">On: ${currentDate}</span>
                </td>
                <td><span class="cell-secondary">N/A</span></td>
                <td><span class="cell-secondary">N/A</span></td>
                <td><span class="cell-secondary">N/A</span></td>
            </tr>`;
        
        if (initialHistory[supplierId]) {
            initialHistory[supplierId] = newHistoryRowHTML + initialHistory[supplierId];
        } else {
            initialHistory[supplierId] = newHistoryRowHTML;
        }
    }
    
    renewHistoryModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const supplierContainer = button.closest('[data-supplier-id]');
        if (!supplierContainer) return;
        const supplierId = supplierContainer.dataset.supplierId;
        const supplierName = supplierContainer.querySelector('[data-field="supplierName"]').textContent;
        
        document.getElementById('renewHistorySupplierName').textContent = `Historical Records for ${supplierName}`;
        document.getElementById('renewHistoryVendorId').textContent = supplierId.toUpperCase();
        
        const historyTableBody = document.getElementById('renewHistoryTableBody');
        historyTableBody.innerHTML = initialHistory[supplierId] || '<tr><td colspan="5" class="text-center">No history found.</td></tr>';
    });


    // --- SORTING LOGIC ---
    function sortSuppliers() {
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const cards = Array.from(cardContainer.querySelectorAll('.card'));
        const getStatus = (element) => {
            const badge = element.querySelector('.badge');
            return badge && (badge.classList.contains('text-bg-success') || badge.classList.contains('text-bg-warning')) ? 1 : 0;
        };
        rows.sort((a, b) => getStatus(b) - getStatus(a));
        cards.sort((a, b) => getStatus(b) - getStatus(a));
        rows.forEach(row => tableBody.appendChild(row));
        cards.forEach(card => cardContainer.appendChild(card));
    }
    
    // --- ############### CONTRACT STATUS LOGIC (TASK 2) ############### ---
    function calculateAndDisplayContractStatus() {
        const allSupplierItems = document.querySelectorAll('[data-supplier-id]');
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Normalize today's date
        const dueSoonLimit = new Date();
        dueSoonLimit.setDate(today.getDate() + 30); // Set "due soon" threshold to 30 days from now

        allSupplierItems.forEach(item => {
            const endDateEl = item.querySelector('[data-field="contract-end-date"]');
            if (!endDateEl) return;
            
            const endDate = new Date(endDateEl.textContent);
            let status = '';
            let badgeClass = '';

            if (endDate < today) {
                status = 'Expired';
                badgeClass = 'text-bg-danger';
            } else if (endDate <= dueSoonLimit) {
                status = 'Due soon';
                badgeClass = 'text-bg-warning';
            } else {
                status = 'Valid';
                badgeClass = 'text-bg-success';
            }
            
            const statusContainers = item.querySelectorAll('.contract-status-container');
            statusContainers.forEach(container => {
                 container.innerHTML = `<span class="badge ${badgeClass} contract-status-badge" data-field="contract-status">${status}</span>`;
            });
        });
    }


    // --- ############### FILTER LOGIC (TASK 1, 2, 3) ############### ---
    function populateDynamicFilters() {
        const filters = {
            corporate: new Set(),
            regional: new Set(),
            unit: new Set(),
            supplierNameList: new Set(),
            serviceNature: new Set(),
            contractType: new Set()
        };

        document.querySelectorAll('#supplierTableBody tr').forEach(row => {
            const hierarchyText = (row.querySelector('[data-field="hierarchy"]')?.textContent || ' > > ').trim();
            const [corp, reg, unit] = hierarchyText.split(' > ');
            if (corp) filters.corporate.add(corp);
            if (reg) filters.regional.add(reg);
            if (unit) filters.unit.add(unit);
            
            const supplierName = row.querySelector('[data-field="supplierName"]')?.textContent.trim();
            if (supplierName) filters.supplierNameList.add(supplierName);
            
            const serviceNature = row.querySelector('[data-field="serviceNature"]')?.textContent.trim();
            if (serviceNature) filters.serviceNature.add(serviceNature);
            
            const contractType = row.querySelector('[data-field="contractType"]')?.textContent.trim();
            if (contractType) filters.contractType.add(contractType);
        });

        const generateOptionsHTML = (filterName, values, prefix = '') => {
            let html = '';
            let i = 0;
            values.forEach(value => {
                const id = `${prefix}${filterName}_${i++}`.replace(/\s+/g, '-');
                html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${value}" id="${id}" name="${filterName}">
                        <label class="form-check-label" for="${id}">${value}</label>
                    </div>`;
            });
            return html;
        };

        for (const filterName in filters) {
            const sortedValues = [...filters[filterName]].sort((a, b) => a.localeCompare(b));
            
            const containers = document.querySelectorAll(`[data-filter-container-for="${filterName}"]`);
            
            containers.forEach(container => {
                const prefix = container.closest('.modal') ? 'm_' : '';
                container.innerHTML = generateOptionsHTML(filterName, sortedValues, prefix);
            });
        }
    }

    function applyAllFilters() {
        const activeFilters = {};
        allFilterForms.forEach(form => {
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                if (value) {
                    if (!activeFilters[key]) activeFilters[key] = [];
                    activeFilters[key].push(value);
                }
            }
        });

        const globalSearchTerm = globalSearchInput.value.toLowerCase();
        
        const allItems = [
            ...Array.from(tableBody.querySelectorAll('tr')),
            ...Array.from(cardContainer.querySelectorAll('.card'))
        ];
        
        let visibleCount = 0;

        const getFieldText = (item, fieldName) => {
            const element = item.querySelector(`[data-field="${fieldName}"]`);
            return element ? element.textContent.trim() : '';
        };

        allItems.forEach(item => {
            let matches = true;

            if (globalSearchTerm && !item.textContent.toLowerCase().includes(globalSearchTerm)) {
                matches = false;
            }

            if (matches && (activeFilters.corporate || activeFilters.regional || activeFilters.unit)) {
                const hierarchyText = getFieldText(item, 'hierarchy');
                const [corp, reg, unit] = hierarchyText.split(' > ').map(s => s.trim());
                const corpMatch = !activeFilters.corporate || activeFilters.corporate.includes(corp);
                const regMatch = !activeFilters.regional || activeFilters.regional.includes(reg);
                const unitMatch = !activeFilters.unit || activeFilters.unit.includes(unit);
                if (!(corpMatch && regMatch && unitMatch)) matches = false;
            }

            if (matches && (activeFilters.supplierNameList || activeFilters.serviceNature || activeFilters.licenseStatus || activeFilters.supplierStatus)) {
                const nameMatch = !activeFilters.supplierNameList || activeFilters.supplierNameList.includes(getFieldText(item, 'supplierName'));
                const natureMatch = !activeFilters.serviceNature || activeFilters.serviceNature.includes(getFieldText(item, 'serviceNature'));
                const statusMatch = !activeFilters.supplierStatus || activeFilters.supplierStatus.includes(item.querySelector('.badge:not(.contract-status-badge)')?.textContent.trim());

                let licenseMatch = !activeFilters.licenseStatus || activeFilters.licenseStatus.some(status => {
                    const statusText = getFieldText(item, 'license-status');
                    const hasLicense = !!item.querySelector('[data-field="license-number"]');
                    if (status === 'license_added') return hasLicense;
                    if (status === 'license_not_added') return !hasLicense;
                    return status === statusText;
                });
                if (!(nameMatch && natureMatch && licenseMatch && statusMatch)) matches = false;
            }
            
            if (matches && (activeFilters.contractType || activeFilters.contractStatus || activeFilters.contractValidityStatus || activeFilters.contractFromDate?.[0] || activeFilters.contractToDate?.[0])) {
                const typeMatch = !activeFilters.contractType || activeFilters.contractType.includes(getFieldText(item, 'contractType'));
                const uploadStatusMatch = !activeFilters.contractStatus || activeFilters.contractStatus.some(status => {
                    const hasUploaded = !!item.querySelector('.upload-status-wrapper[data-upload-type="contract-static"]');
                    if (status === 'uploaded') return hasUploaded;
                    if (status === 'not_uploaded') return !hasUploaded;
                    return false;
                });
                const validityStatusMatch = !activeFilters.contractValidityStatus || activeFilters.contractValidityStatus.includes(getFieldText(item, 'contract-status'));

                const endDateStr = getFieldText(item, 'contract-end-date');
                let dateMatch = true;
                if (endDateStr && (activeFilters.contractFromDate?.[0] || activeFilters.contractToDate?.[0])) {
                    const endDate = new Date(endDateStr);
                    const fromDate = activeFilters.contractFromDate?.[0] ? new Date(activeFilters.contractFromDate[0]) : null;
                    const toDate = activeFilters.contractToDate?.[0] ? new Date(activeFilters.contractToDate[0]) : null;
                    if ((fromDate && endDate < fromDate) || (toDate && endDate > toDate)) dateMatch = false;
                }
                if (!(typeMatch && uploadStatusMatch && dateMatch && validityStatusMatch)) matches = false;
            }
            
            if (matches && (activeFilters.riskStatus || activeFilters.productName?.[0])) {
                 const riskMatch = !activeFilters.riskStatus || activeFilters.riskStatus.includes(item.querySelector('.risk-category')?.textContent.trim());
                 const productName = activeFilters.productName?.[0]?.toLowerCase();
                 const productText = item.querySelector('.risk-category')?.nextElementSibling?.textContent.toLowerCase();
                 const productMatch = !productName || (productText && productText.includes(productName));
                 if (!(riskMatch && productMatch)) matches = false;
            }

             if (matches && (activeFilters.auditStatus || activeFilters.auditFrequency || activeFilters.complianceStatus || activeFilters.auditFromDate?.[0] || activeFilters.auditToDate?.[0])) {
                const auditScoreText = getFieldText(item, 'audit-score');
                const isConducted = auditScoreText && !auditScoreText.toLowerCase().includes('not');
                const auditStatusMatch = !activeFilters.auditStatus || activeFilters.auditStatus.some(s => (s === 'conducted' && isConducted) || (s === 'not_conducted' && !isConducted));
                const freqMatch = !activeFilters.auditFrequency || activeFilters.auditFrequency.includes(getFieldText(item, 'audit-frequency'));
                const complianceText = item.querySelector('.nc-open, .nc-closed')?.parentElement.textContent;
                const complianceMatch = !activeFilters.complianceStatus || activeFilters.complianceStatus.some(s => complianceText && complianceText.includes(s));
                
                let dateMatch = true;
                const lastDateStr = getFieldText(item, 'audit-last-date');
                if (lastDateStr && (activeFilters.auditFromDate?.[0] || activeFilters.auditToDate?.[0])) {
                    const lastDate = new Date(lastDateStr);
                    const fromDate = activeFilters.auditFromDate?.[0] ? new Date(activeFilters.auditFromDate[0]) : null;
                    const toDate = activeFilters.auditToDate?.[0] ? new Date(activeFilters.auditToDate[0]) : null;
                    if ((fromDate && lastDate < fromDate) || (toDate && lastDate > toDate)) dateMatch = false;
                }
                if (!(auditStatusMatch && freqMatch && complianceMatch && dateMatch)) matches = false;
             }
             
             if (matches && (activeFilters.evalStatus || activeFilters.evalScoreFrom?.[0] || activeFilters.evalScoreTo?.[0] || activeFilters.evalFromDate?.[0] || activeFilters.evalToDate?.[0])) {
                 const evalScoreText = getFieldText(item, 'eval-score');
                 const isCompleted = evalScoreText && !evalScoreText.toLowerCase().includes('not');
                 const statusMatch = !activeFilters.evalStatus || activeFilters.evalStatus.some(s => (s === 'completed' && isCompleted) || (s === 'not_completed' && !isCompleted));
                 
                 let scoreMatch = true;
                 if (isCompleted && (activeFilters.evalScoreFrom?.[0] || activeFilters.evalScoreTo?.[0])) {
                     const score = parseInt(evalScoreText, 10);
                     const fromScore = activeFilters.evalScoreFrom?.[0] ? parseInt(activeFilters.evalScoreFrom[0], 10) : 0;
                     const toScore = activeFilters.evalScoreTo?.[0] ? parseInt(activeFilters.evalScoreTo[0], 10) : 100;
                     if (score < fromScore || score > toScore) scoreMatch = false;
                 }

                 let dateMatch = true;
                const lastDateStr = getFieldText(item, 'eval-last-date');
                if (lastDateStr && (activeFilters.evalFromDate?.[0] || activeFilters.evalToDate?.[0])) {
                    const lastDate = new Date(lastDateStr);
                    const fromDate = activeFilters.evalFromDate?.[0] ? new Date(activeFilters.evalFromDate[0]) : null;
                    const toDate = activeFilters.evalToDate?.[0] ? new Date(activeFilters.evalToDate[0]) : null;
                    if ((fromDate && lastDate < fromDate) || (toDate && lastDate > toDate)) dateMatch = false;
                }
                 if (!(statusMatch && scoreMatch && dateMatch)) matches = false;
             }
             
             if (matches && activeFilters.complainStatus) {
                 let hasComplains = false;
                 if (item.tagName === 'TR') {
                     const complainCellText = item.cells[6]?.querySelector('.cell-primary')?.textContent || '0';
                     hasComplains = parseInt(complainCellText, 10) > 0;
                 } else {
                     const labels = item.querySelectorAll('.card-label');
                     const complainLabel = Array.from(labels).find(el => el.textContent.trim() === 'Complains');
                     if (complainLabel) {
                         const complainValueText = complainLabel.nextElementSibling?.textContent || '0';
                         hasComplains = parseInt(complainValueText, 10) > 0;
                     }
                 }
                 
                 const complainMatch = activeFilters.complainStatus.some(s => (s === 'has_complains' && hasComplains) || (s === 'no_complains' && !hasComplains));
                 if (!complainMatch) matches = false;
             }

            item.style.display = matches ? '' : 'none';
            if (matches && item.tagName === 'TR') {
                visibleCount++;
            }
        });

        const totalRows = tableBody.querySelectorAll('tr').length;
        // paginationInfo.textContent = `Showing ${visibleCount} of ${totalRows} entries (filtered)`;
    }
    
    function syncFilters(sourceForm) {
        const sourceData = new FormData(sourceForm);
        const sourceValues = {};
        for (const [key, value] of sourceData.entries()) {
            if (!sourceValues[key]) {
                sourceValues[key] = [];
            }
            sourceValues[key].push(value);
        }

        allFilterForms.forEach(targetForm => {
            if (targetForm === sourceForm) return;

            targetForm.querySelectorAll('input, select').forEach(input => {
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else if (input.type !== 'search') {
                    input.value = '';
                }
            });

            for (const key in sourceValues) {
                const values = sourceValues[key];
                targetForm.querySelectorAll(`[name="${key}"]`).forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        if (values.includes(input.value)) {
                            input.checked = true;
                        }
                    } else {
                        input.value = values[0];
                    }
                });
            }
        });
    }

    allFilterForms.forEach(form => {
        form.addEventListener('submit', (e) => { e.preventDefault(); applyAllFilters(); });
        form.addEventListener('reset', (e) => { 
            const formId = e.target.id;
            setTimeout(() => {
                const clearedForm = document.getElementById(formId);
                syncFilters(clearedForm); 
                applyAllFilters(); 
            }, 0);
        });
        form.addEventListener('change', (e) => { syncFilters(e.currentTarget); applyAllFilters(); });
        form.addEventListener('keyup', (e) => { syncFilters(e.currentTarget); applyAllFilters(); });
    });
    
    globalSearchInput.addEventListener('input', applyAllFilters);
    // refreshBtn.addEventListener('click', () => { allFilterForms.forEach(form => form.reset()); globalSearchInput.value = ''; applyAllFilters(); });
        // Refresh button click
        refreshBtn.addEventListener('click', () => {
            allFilterForms.forEach(form => form.reset());
            globalSearchInput.value = '';
            window.location.href = "https://efsm.safefoodmitra.com/admin/public/index.php/sqa-suplier-list";
        });



    clearMobileFiltersBtn.addEventListener('click', () => { mobileFilterForms.forEach(form => { form.reset(); }); syncFilters(mobileFilterForms[0]); applyAllFilters(); });

    document.querySelectorAll('.filter-search').forEach(searchInput => {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const optionsContainer = this.nextElementSibling;
            if (optionsContainer?.classList.contains('filter-options-container')) {
                 optionsContainer.querySelectorAll('.form-check').forEach(wrapper => {
                    const labelText = wrapper.querySelector('.form-check-label')?.textContent.toLowerCase();
                    if(labelText) { wrapper.style.display = labelText.includes(searchTerm) ? '' : 'none'; }
                });
            }
        });
    });

    // --- DYNAMIC UPLOAD & SAVE LOGIC ---
    const contractModalEl = document.getElementById('uploadContractModal');
    const licenseModalEl = document.getElementById('uploadLicenseModal');
    const saveContractBtn = document.getElementById('saveContractBtn');
    const saveLicenseBtn = document.getElementById('saveLicenseBtn');
    
    [contractModalEl, licenseModalEl].forEach(modal => {
        modal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const supplierContainer = button.closest('[data-supplier-id]');
            if (supplierContainer) {
                modal.dataset.currentSupplier = supplierContainer.dataset.supplierId;
            }
        });
    });

    saveContractBtn.addEventListener('click', function() { 
        const modal = this.closest('.modal');
        const supplierId = modal.dataset.currentSupplier;
        if(supplierId) {
            logChange(supplierId, 'Contract Upload', 'Not Uploaded', 'Uploaded');
            updateLastUpdatedTimestamp(supplierId);
        }
        bootstrap.Modal.getInstance(modal).hide();
    });
    saveLicenseBtn.addEventListener('click', function() {
        const modal = this.closest('.modal');
        const supplierId = modal.dataset.currentSupplier;
        if(supplierId) {
            logChange(supplierId, 'License Upload', 'Not Uploaded', 'Uploaded');
            updateLastUpdatedTimestamp(supplierId);
        }
         bootstrap.Modal.getInstance(modal).hide();
    });

    // --- DELEGATED EVENT LISTENERS FOR TOGGLES & DELETE ---
    document.body.addEventListener('click', function(event) {
        const deleteButton = event.target.closest('.delete-icon');
        if (deleteButton) {
            const supplierContainer = deleteButton.closest('[data-supplier-id]');
            if (!supplierContainer) return;

            const supplierId = supplierContainer.dataset.supplierId;
                  const numericId = parseInt(supplierId.replace('supplier-', ''), 10);
            const contractContainer = deleteButton.closest('[data-container="contract-upload"]');
            const licenseContainer = deleteButton.closest('[data-container="license-upload"]');

            if (confirm('Are you sure you want to delete this items?')) {
                let deletedItemType = null;
                if (contractContainer) {
                        // if(!confirm("Are you sure you want to delete this contract?")) return;
                    
                        $.ajax({
                            url: "{{route('sqa.supplier.delete.contract')}}",
                            type: 'POST',        
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: numericId
                            },
                            success: function(response) {
                                if(response.success) {
                                    // addHistoryEntry(supplierId, 'Contract document deleted.');
                                    // logChange(supplierId, 'Contract Deletion', 'Present', 'Deleted');
                    
                                    // // Remove row from table
                                    // const row = contractContainer.closest('tr');
                                    // if(row) row.remove();
                    
                                    toastr.success('Contract deleted successfully!');
                                    setTimeout(()=>{
                                        location.reload()
                                    },2000)
                                } else {
                                    toastr.error('Failed to delete contract.');
                                }
                            },
                            error: function(xhr, status, error) {
                                  toastr.error('Error deleting contract..');
                            }
                        });
                
                    // addHistoryEntry(supplierId, 'Contract document deleted.');
                    // logChange(supplierId, 'Contract Deletion', 'Present', 'Deleted');
                    // deletedItemType = 'contract';
                } else if (licenseContainer) {
                    addHistoryEntry(supplierId, 'FSSAI License deleted.');
                    logChange(supplierId, 'License Deletion', 'Present', 'Deleted');
                    deletedItemType = 'license';
                }

                if (deletedItemType) {
                    updateLastUpdatedTimestamp(supplierId);
                    const allSupplierElements = document.querySelectorAll(`[data-supplier-id="${supplierId}"]`);
                    allSupplierElements.forEach(element => {
                        const containerToUpdate = element.querySelector(`[data-container="${deletedItemType}-upload"]`);
                        if(containerToUpdate) {
                             if(deletedItemType === 'contract') {
                                 containerToUpdate.innerHTML = `<button class="btn btn-sm btn-outline-primary mt-1" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-upload me-1"></i>Upload Contract Copy</button>`;
                             } else {
                                const parentCell = containerToUpdate.closest('.cell-secondary, .list-group-item');
                                if(parentCell) {
                                    parentCell.querySelector('[data-container="license-upload"]').innerHTML = `<button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-plus-circle-dotted me-1"></i>Upload License</button>`;
                                }
                             }
                        }
                    });
                }
            }
        }
    });

    document.body.addEventListener('change', function(event) {
        const target = event.target;
        const supplierContainer = target.closest('[data-supplier-id]');
        if (!supplierContainer) return;
        const supplierId = supplierContainer.dataset.supplierId;

        if (target.matches('.form-switch-accept-reject .form-check-input')) {
            const label = target.nextElementSibling;
            if (label) {
                const oldValue = target.checked ? 'Rejected' : 'Accepted';
                const newValue = target.checked ? 'Accepted' : 'Rejected';
                label.textContent = newValue;
                logChange(supplierId, 'Approval Status', oldValue, newValue);
                updateLastUpdatedTimestamp(supplierId);
            }
        }
        if (target.matches('.form-switch:not(.form-switch-accept-reject) .form-check-input')) {
            const isChecked = target.checked;
            const toggleLabel = target.nextElementSibling;
            
            if(toggleLabel) {
                 const oldValue = isChecked ? 'Inactive' : 'Active';
                 const newValue = isChecked ? 'Active' : 'Inactive';
                 toggleLabel.textContent = newValue;
                 logChange(supplierId, 'Supplier Status', oldValue, newValue);
                 updateLastUpdatedTimestamp(supplierId);
            }
            document.querySelectorAll(`[data-supplier-id="${supplierId}"]`).forEach(element => {
                const badge = element.querySelector('.badge:not(.contract-status-badge)');
                if (badge) {
                    badge.textContent = isChecked ? 'Active' : 'Inactive';
                    badge.classList.toggle('text-bg-success', isChecked);
                    badge.classList.toggle('text-bg-secondary', !isChecked);
                }
            });
            sortSuppliers();
        }
    });

    // --- ############### EDIT SUPPLIER SCRIPTING START ############### ---
    const editSupplierModalEl = document.getElementById('editSupplierModal');
    const editSupplierForm = document.getElementById('editSupplierForm');
    const editSupplierModal = new bootstrap.Modal(editSupplierModalEl);
    let originalData = {};

    editSupplierModalEl.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        const supplierContainer = button.closest('[data-supplier-id]');
        const supplierId = supplierContainer.dataset.supplierId;
        editSupplierModalEl.dataset.currentSupplier = supplierId;

        const sourceElement = document.querySelector(`[data-supplier-id="${supplierId}"]`);
        
        originalData = {
            supplierName: sourceElement.querySelector('[data-field="supplierName"]').textContent,
            serviceNature: sourceElement.querySelector('[data-field="serviceNature"]').textContent,
            email: sourceElement.querySelector('[data-field="email"]')?.textContent || '',
            address: sourceElement.querySelector('[data-field="address"]')?.textContent || '',
            contractType: sourceElement.querySelector('[data-field="contractType"]').textContent,
            contractNumber: sourceElement.querySelector('[data-field="contractNumber"]').textContent
        };

        document.getElementById('editSupplierName').value = originalData.supplierName;
        $('#editSupplierServiceNature').val(originalData.serviceNature).trigger('change');
        document.getElementById('editSupplierEmail').value = originalData.email;
        document.getElementById('editSupplierAddress').value = originalData.address;
        $('#editSupplierContractType').val(originalData.contractType).trigger('change');
        document.getElementById('editSupplierContractNumber').value = originalData.contractNumber;
    });


    editSupplierForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const supplierId = editSupplierModalEl.dataset.currentSupplier;
    if (!supplierId) return;

    const formData = {
        supplierName: document.getElementById('editSupplierName').value,
        serviceNature: document.getElementById('editSupplierServiceNature').value,
        email: document.getElementById('editSupplierEmail').value,
        address: document.getElementById('editSupplierAddress').value,
        contractType: document.getElementById('editSupplierContractType').value,
        contractNumber: document.getElementById('editSupplierContractNumber').value,
        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel CSRF
    };

    const url = "{{ route('sqa-new-supplier-update', ':id') }}".replace(':id', supplierId);

    // AJAX request
     fetch(url, {
            method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify(formData)
    })
    .then(async (response) => {
        try {
            const data = await response.json();
    
            if (data.success) {
                toastr.success("Supplier updated successfully!");
    
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                toastr.error("Something went wrong!");
            }
        } catch (err) {
            console.error("JSON parsing error or other issue:", err);
            toastr.error("Invalid response format!");
        }
    })
    .catch(error => {
        toastr.error("Error updating supplier!");
    });

    });


    // --- ############### BULK UPLOAD SCRIPTING START ############### ---

    const uploadAndReviewBtn = document.getElementById('uploadAndReviewBtn');
    const confirmImportBtn = document.getElementById('confirmImportBtn');
    const csvFileInput = document.getElementById('csvFileInput');
    const reviewDuplicateTableBody = document.getElementById('reviewDuplicateTableBody');
    const reviewNewTableBody = document.getElementById('reviewNewTableBody');
    const bulkUploadModal = new bootstrap.Modal(document.getElementById('bulkUploadModal'));
    const bulkUploadReviewModal = new bootstrap.Modal(document.getElementById('bulkUploadReviewModal'));
    const bulkUploadReviewModalEl = document.getElementById('bulkUploadReviewModal');
    const importCountSpan = document.getElementById('importCount');

    const selectAllDuplicatesCheckbox = document.getElementById('selectAllDuplicates');
    const selectAllNewCheckbox = document.getElementById('selectAllNew');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deselectAllBtn = document.getElementById('deselectAllBtn');

    const selectOptions = {
        serviceNature: ["Food/Ingredients", "Service-Pest Control", "Other Service", "Transport"],
        contractType: ["Annual Rate", "Quarterly Supply", "Annual Service", "One-Time Purchase"]
    };

    function updateImportCountAndStyles() {
        const allCheckboxes = bulkUploadReviewModalEl.querySelectorAll('.row-checkbox');
        let checkedCount = 0;

        allCheckboxes.forEach(checkbox => {
            const row = checkbox.closest('tr');
            if (checkbox.checked) {
                checkedCount++;
                row.classList.add('row-selected');
            } else {
                row.classList.remove('row-selected');
            }
        });
        
        importCountSpan.textContent = checkedCount;

        const allDupCheckboxes = [...reviewDuplicateTableBody.querySelectorAll('.row-checkbox')];
        selectAllDuplicatesCheckbox.checked = allDupCheckboxes.length > 0 && allDupCheckboxes.every(cb => cb.checked);

        const allNewCheckboxes = [...reviewNewTableBody.querySelectorAll('.row-checkbox')];
        selectAllNewCheckbox.checked = allNewCheckboxes.length > 0 && allNewCheckboxes.every(cb => cb.checked);
    }
    

//     uploadAndReviewBtn.addEventListener('click', function () {
//         alert("fdsffdff")
//         const fileInput = document.getElementById('csvFileInput');
    
//         if (fileInput.files.length === 0) {
//             alert('Please select a CSV file to upload.');
//             return;
//         }
    
//         const file = fileInput.files[0];
//         const reader = new FileReader();
    
//         reader.onload = function (e) {
//             const text = e.target.result;
    
//             // Split CSV rows
//             const lines = text.trim().split('\n');
//             const headers = lines[0].split(',').map(h => h.trim());
    
//             const mockCsvData = [];
    
//             for (let i = 1; i < lines.length; i++) {
//                 const row = lines[i].split(',').map(col => col.trim());
    
//                 // Build object based on headers
//                 const rowData = {};
//                 headers.forEach((header, index) => {
//                     rowData[header] = row[index] || '';
//                 });
    
//                 // Push in your desired format
//                 mockCsvData.push({
//                     supplierName: rowData['supplierName'],
//                     serviceNature: rowData['serviceNature'],
//                     email: rowData['email'],
//                     contractType: rowData['contractType'],
//                     contractNumber: rowData['contractNumber'],
//                     contractStartDate: rowData['contractStartDate'],
//                     contractEndDate: rowData['contractEndDate']
//                 });
//             }
    
//             renderPreviewFromCsv(mockCsvData); 
//         };
    
//         reader.readAsText(file);
//     });


// function renderPreviewFromCsv(mockCsvData) {
//     const existingSuppliers = new Set();
//     document.querySelectorAll('#supplierTableBody [data-field="supplierName"]').forEach(cell => {
//         existingSuppliers.add(cell.textContent.trim().toUpperCase());
//     });

//     let duplicateRowHtml = '';
//     let newRowHtml = '';

//     mockCsvData.forEach((row, index) => {
//         // ✅ safely handle missing supplierName
//         const supplierName = row.supplierName ? row.supplierName.toString().trim() : "";
//         const serviceNature = row.serviceNature || "";
//         const email = row.email || "";
//         const contractType = row.contractType || "";
//         const contractNumber = row.contractNumber || "";
//         const contractStartDate = row.contractStartDate || "";
//         const contractEndDate = row.contractEndDate || "";

//         const isDuplicate = existingSuppliers.has(supplierName.toUpperCase());

//         const status = isDuplicate
//             ? `<span class="badge text-bg-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i>Duplicate</span>`
//             : `<span class="badge text-bg-success"><i class="bi bi-plus-circle-fill me-1"></i>New</span>`;

//         const rowContent = `
//             <td>
//                 <input class="form-check-input row-checkbox" type="checkbox" id="reviewCheck${index}" ${!isDuplicate ? 'checked' : ''}>
//             </td>
//             <td>${status}</td>
//             <td>
//                 <span class="cell-primary" contenteditable="true">${supplierName}</span>
//                 <span class="cell-secondary d-block">
//                     <strong>Service:</strong> <span class="editable-select" data-field="serviceNature">${serviceNature} <i class="bi bi-pencil-fill small text-muted ms-1"></i></span><br>
//                     <strong>Email:</strong> <span contenteditable="true">${email}</span>
//                 </span>
//             </td>
//             <td>
//                 <span class="cell-primary d-block">Type: <span class="editable-select" data-field="contractType">${contractType} <i class="bi bi-pencil-fill small text-muted ms-1"></i></span></span>
//                 <span class="cell-secondary">
//                     No: <span contenteditable="true">${contractNumber}</span><br>
//                     Start Date: <span contenteditable="true">${contractStartDate}</span><br>
//                     End Date: <span contenteditable="true">${contractEndDate}</span>
//                 </span>
//             </td>
//         `;

//         if (isDuplicate) {
//             duplicateRowHtml += `<tr>${rowContent}</tr>`;
//         } else {
//             newRowHtml += `<tr data-is-new="true">${rowContent}</tr>`;
//         }
//     });

//     reviewDuplicateTableBody.innerHTML = duplicateRowHtml || `<tr><td colspan="4" class="text-center text-muted">No duplicate records found.</td></tr>`;
//     reviewNewTableBody.innerHTML = newRowHtml || `<tr><td colspan="4" class="text-center text-muted">No new records found.</td></tr>`;

//     bulkUploadModal.hide();
//     bulkUploadReviewModal.show();
//     updateImportCountAndStyles();
// }












    bulkUploadReviewModalEl.addEventListener('change', (event) => {
        if (event.target.matches('.row-checkbox, #selectAllDuplicates, #selectAllNew')) {
            updateImportCountAndStyles();
        }
    });
    
    // --- In-place Editing for Selects in Review Modal ---
    bulkUploadReviewModalEl.addEventListener('click', function(e) {
        const target = e.target.closest('.editable-select');
        if (!target) return;

        const field = target.dataset.field;
        const options = selectOptions[field];
        if (!options) return;

        const currentValue = target.textContent.trim();
        const select = document.createElement('select');
        select.className = 'form-select form-select-sm';
        
        options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt;
            option.textContent = opt;
            if (opt === currentValue) {
                option.selected = true;
            }
            select.appendChild(option);
        });

        target.replaceWith(select);
        select.focus();

        const revertToSpan = () => {
            const newValue = select.value;
            const newSpan = document.createElement('span');
            newSpan.className = 'editable-select';
            newSpan.dataset.field = field;
            newSpan.innerHTML = `${newValue} <i class="bi bi-pencil-fill small text-muted ms-1"></i>`;
            select.replaceWith(newSpan);
        };

        select.addEventListener('blur', revertToSpan);
        select.addEventListener('change', revertToSpan);
    });


    selectAllBtn.addEventListener('click', () => {
        bulkUploadReviewModalEl.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = true);
        updateImportCountAndStyles();
    });

    deselectAllBtn.addEventListener('click', () => {
        bulkUploadReviewModalEl.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
        updateImportCountAndStyles();
    });

    selectAllDuplicatesCheckbox.addEventListener('change', function() {
        reviewDuplicateTableBody.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
        updateImportCountAndStyles();
    });

    selectAllNewCheckbox.addEventListener('change', function() {
        reviewNewTableBody.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
        updateImportCountAndStyles();
    });

    // function addSupplierToTableAndCard(data) {
    //     const newId = `supplier-${newSupplierIdCounter++}`;
    //     const newToggleId = `toggle-${newId}`;
    //     const newAcceptId = `accept-${newId}`;
    //     complianceData[newId] = [];

    //     const newRow = document.createElement('tr');
    //     newRow.dataset.supplierId = newId;
    //     newRow.innerHTML = `
    //         <td><span class="cell-secondary" data-field="hierarchy">From Bulk Upload</span></td>
    //         <td>
    //             <div class="d-flex justify-content-between align-items-center mb-1">
    //                 <span class="cell-primary" data-field="supplierName">${data.supplierName}</span>
    //                 <span class="badge text-bg-success">Active</span>
    //             </div>
    //             <span class="cell-secondary">
    //                 <strong>Uploaded by:</strong> Bulk Upload<br>
    //                 <strong>Service Nature:</strong> <span data-field="serviceNature">${data.serviceNature}</span><br>
    //                 <strong>Email:</strong> <span data-field="email">${data.email}</span><br>
    //                 <div class="upload-container mt-1 mb-2" data-container="license-upload">
    //                     <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-plus-circle-dotted me-1"></i>Upload License</button>
    //                 </div>
    //                 <strong>Address:</strong> <span data-field="address">Not provided</span><br>
    //                 <strong>Data updated on:</strong> <span class="last-updated">${data.lastUpdated}</span>
    //             </span>
    //             <div class="form-check form-switch form-switch-accept-reject mt-2"><input class="form-check-input" type="checkbox" role="switch" id="${newAcceptId}" checked><label class="form-check-label small" for="${newAcceptId}">Accepted</label></div>
    //         </td>
    //         <td>
    //             <div class="d-flex justify-content-between align-items-center">
    //                 <span class="cell-primary d-block">Type: <span data-field="contractType">${data.contractType}</span></span>
    //                 <div class="contract-status-container"></div>
    //             </div>
    //             <span class="cell-secondary">Contract No: <span data-field="contractNumber">${data.contractNumber}</span><br>Start: N/A | End: <span data-field="contract-end-date">${data.contractEndDate}</span></span>
    //             <div class="upload-container mt-2" data-container="contract-upload">
    //                 <button class="btn btn-sm btn-outline-primary mt-1" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-upload me-1"></i>Upload Contract Copy</button>
    //             </div>
    //         </td>
    //         <td><span class="cell-secondary d-block">Not Set</span><div class="mt-2"><button class="btn btn-sm btn-primary" data-action="view-listing" data-supplier-id="${newId}">Add & View List</button></div></td>
    //         <td><span class="cell-primary d-block" data-field="audit-score">Not Conducted</span><div class="mt-2"><button class="btn btn-sm btn-warning">Start Audit</button></div></td>
    //         <td><span class="cell-primary d-block" data-field="eval-score">Not Evaluated</span><div class="mt-2"><button class="btn btn-sm btn-warning">Start Eval</button></div></td>
    //         <td><span class="cell-primary d-block">0 Complains</span><span class="cell-secondary">No complains</span><div class="mt-2"><button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complainHistoryModal">History</button><button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></td>
    //         <td>
    //             <div class="d-flex flex-column gap-2">
    //                 <div class="open-ticket-button-placeholder"></div>
    //                 <button class="btn btn-sm btn-warning d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#editSupplierModal"><i class="bi bi-pencil-fill"></i> Edit</button>
    //                 <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logBookModal">Log Book</button>
    //                 <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">Renew</button>
    //                 <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#renewHistoryModal">Renew History</button>
    //                 <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="${newToggleId}" checked><label class="form-check-label" for="${newToggleId}">Active</label></div>
    //             </div>
    //         </td>`;
    //     tableBody.appendChild(newRow);
        
    //     const newCard = document.createElement('div');
    //     newCard.className = 'card mb-3';
    //     newCard.dataset.supplierId = newId;
    //     newCard.innerHTML = `
    //         <div class="card-header d-flex justify-content-between align-items-center">
    //             <span data-field="supplierName">${data.supplierName}</span>
    //             <span class="badge text-bg-success">Active</span>
    //         </div>
    //         <div class="card-body">
    //             <ul class="list-group list-group-flush">
    //                 <li class="list-group-item"><div class="card-label">Hierarchy</div><div class="card-value" data-field="hierarchy">From Bulk Upload</div></li>
    //                 <li class="list-group-item" data-container="license-upload"><div class="card-label">License</div><div class="card-value"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-plus-circle-dotted me-1"></i>Upload License</button></div></li>
    //                 <li class="list-group-item" data-container="contract-upload">
    //                     <div class="card-label">Contract</div>
    //                     <div class="card-value">
    //                          <div class="d-flex justify-content-between align-items-center">
    //                             <div>Type: <span data-field="contractType">${data.contractType}</span> | Ends: <span data-field="contract-end-date">${data.contractEndDate}</span></div>
    //                             <div class="contract-status-container"></div>
    //                          </div>
    //                          <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-upload me-1"></i>Upload Contract</button>
    //                     </div>
    //                 </li>
    //                 <li class="list-group-item"><div class="card-label">Email</div><div class="card-value" data-field="email">${data.email}</div></li>
    //                 <li class="list-group-item"><div class="card-label">List / Risk</div><div class="card-value">Not Set</div></li>
    //                 <li class="list-group-item"><div class="card-label">Complains & Compliance</div><div class="card-value">0 Complains <button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></li>
    //                 <li class="list-group-item"><div class="card-label">Data updated on</div><div class="card-value last-updated">${data.lastUpdated}</div></li>
    //             </ul>
    //         </div>
    //         <div class="card-footer d-flex flex-wrap align-items-center">
    //             <div class="open-ticket-button-placeholder me-auto"></div>
    //             <button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#editSupplierModal" title="Edit Supplier"><i class="bi bi-pencil-fill fs-5"></i></button>
    //             <button class="btn btn-sm btn-outline-info">Log</button>
    //             <button class="btn btn-sm btn-primary">List</button>
    //             <button class="btn btn-sm btn-warning">Audit</button>
    //             <button class="btn btn-sm btn-warning">Eval</button>
    //         </div>`;
    //     cardContainer.appendChild(newCard);
        
        
        
    //     const viewListingBtn = newRow.querySelector('[data-action="view-listing"]');
    //     alert(viewListingBtn);
    //     viewListingBtn.addEventListener('click', function () {
    //         const supplierId = this.getAttribute('data-supplier-id');
        
    //         // Set supplier ID in modal
    //         document.getElementById('modalSupplierId').textContent = supplierId;
        
    //         // Optional: Load more content dynamically
    //         document.getElementById('listingContentArea').innerHTML = `Loading data for <strong>${supplierId}</strong>...`;
        
    //         // Show modal using Bootstrap
    //         const modal = new bootstrap.Modal(document.getElementById('listingModal'));
    //         modal.show();
    //     });


    // }


function addSupplierToTableAndCard(data) {
    const newId = `supplier-${newSupplierIdCounter++}`;
    const newToggleId = `toggle-${newId}`;
    const newAcceptId = `accept-${newId}`;
    complianceData[newId] = [];

    const newRow = document.createElement('tr');
    newRow.dataset.supplierId = newId;

    newRow.innerHTML = `
        <td><span class="cell-secondary" data-field="hierarchy">From Bulk Upload</span></td>
        <td>
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="cell-primary" data-field="supplierName">${data.supplierName}</span>
                <span class="badge text-bg-success">Active</span>
            </div>
            <span class="cell-secondary">
                <strong>Uploaded by:</strong> Bulk Upload<br>
                <strong>Service Nature:</strong> <span data-field="serviceNature">${data.serviceNature}</span><br>
                <strong>Email:</strong> <span data-field="email">${data.email}</span><br>
                <div class="upload-container mt-1 mb-2" data-container="license-upload">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-plus-circle-dotted me-1"></i>Upload License</button>
                </div>
                <strong>Address:</strong> <span data-field="address">Not provided</span><br>
                <strong>Data updated on:</strong> <span class="last-updated">${data.lastUpdated}</span>
            </span>
            <div class="form-check form-switch form-switch-accept-reject mt-2">
                <input class="form-check-input" type="checkbox" role="switch" id="${newAcceptId}" checked>
                <label class="form-check-label small" for="${newAcceptId}">Accepted</label>
            </div>
        </td>
        <td>
            <div class="d-flex justify-content-between align-items-center">
                <span class="cell-primary d-block">Type: <span data-field="contractType">${data.contractType}</span></span>
                <div class="contract-status-container"></div>
            </div>
            <span class="cell-secondary">
                Contract No: <span data-field="contractNumber">${data.contractNumber}</span><br>
                Start: N/A | End: <span data-field="contract-end-date">${data.contractEndDate}</span>
            </span>
            <div class="upload-container mt-2" data-container="contract-upload">
                <button class="btn btn-sm btn-outline-primary mt-1" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-upload me-1"></i>Upload Contract Copy</button>
            </div>
        </td>
        <td>
            <span class="cell-secondary d-block">Not Set</span>
            <div class="mt-2">
                <button class="btn btn-sm btn-primary" data-action="view-listing" data-supplier-id="${newId}">
                    Add & View List
                </button>
            </div>
        </td>
        <td>
            <span class="cell-primary d-block" data-field="audit-score">Not Conducted</span>
            <div class="mt-2"><button class="btn btn-sm btn-warning">Start Audit</button></div>
        </td>
        <td>
            <span class="cell-primary d-block" data-field="eval-score">Not Evaluated</span>
            <div class="mt-2"><button class="btn btn-sm btn-warning">Start Eval</button></div>
        </td>
        <td>
            <span class="cell-primary d-block">0 Complains</span>
            <span class="cell-secondary">No complains</span>
            <div class="mt-2">
                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complainHistoryModal">History</button>
                <button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button>
            </div>
        </td>
        <td>
            <div class="d-flex flex-column gap-2">
                <div class="open-ticket-button-placeholder"></div>
                <button class="btn btn-sm btn-warning d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#editSupplierModal"><i class="bi bi-pencil-fill"></i> Edit</button>
                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logBookModal">Log Book</button>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">Renew</button>
                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#renewHistoryModal">Renew History</button>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="${newToggleId}" checked>
                    <label class="form-check-label" for="${newToggleId}">Active</label>
                </div>
            </div>
        </td>
    `;

    tableBody.appendChild(newRow);

    // === Add Event Listener to Modal Button ===
    const viewListingBtn = newRow.querySelector('[data-action="view-listing"]');
    if (viewListingBtn) {
        viewListingBtn.addEventListener('click', function () {
            const supplierId = this.getAttribute('data-supplier-id');

            const supplierIdEl = document.getElementById('modalSupplierId');
            const listingContentEl = document.getElementById('listingContentArea');
            const modalEl = document.getElementById('listingModal');

            if (!supplierIdEl || !listingContentEl || !modalEl) {
                console.error("Modal elements missing in DOM.");
                return;
            }

            supplierIdEl.textContent = supplierId;
            listingContentEl.innerHTML = `Loading data for <strong>${supplierId}</strong>...`;

            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });
    } else {
        console.warn('Button with data-action="view-listing" not found.');
    }

    // === Optional: Add Supplier Card (if needed)
    const newCard = document.createElement('div');
    newCard.className = 'card mb-3';
    newCard.dataset.supplierId = newId;

    newCard.innerHTML = `
        <div class="card-header d-flex justify-content-between align-items-center">
            <span data-field="supplierName">${data.supplierName}</span>
            <span class="badge text-bg-success">Active</span>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><div class="card-label">Hierarchy</div><div class="card-value">From Bulk Upload</div></li>
                <li class="list-group-item"><div class="card-label">License</div><div class="card-value"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal"><i class="bi bi-plus-circle-dotted me-1"></i>Upload License</button></div></li>
                <li class="list-group-item"><div class="card-label">Contract</div><div class="card-value">Type: <span data-field="contractType">${data.contractType}</span> | Ends: <span data-field="contract-end-date">${data.contractEndDate}</span><br><button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#uploadContractModal"><i class="bi bi-upload me-1"></i>Upload Contract</button></div></li>
                <li class="list-group-item"><div class="card-label">Email</div><div class="card-value">${data.email}</div></li>
                <li class="list-group-item"><div class="card-label">List / Risk</div><div class="card-value">Not Set</div></li>
                <li class="list-group-item"><div class="card-label">Complains & Compliance</div><div class="card-value">0 Complains <button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></li>
                <li class="list-group-item"><div class="card-label">Data updated on</div><div class="card-value">${data.lastUpdated}</div></li>
            </ul>
        </div>
        <div class="card-footer d-flex flex-wrap align-items-center">
            <div class="open-ticket-button-placeholder me-auto"></div>
            <button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#editSupplierModal" title="Edit Supplier"><i class="bi bi-pencil-fill fs-5"></i></button>
            <button class="btn btn-sm btn-outline-info">Log</button>
            <button class="btn btn-sm btn-primary">List</button>
            <button class="btn btn-sm btn-warning">Audit</button>
            <button class="btn btn-sm btn-warning">Eval</button>
        </div>
    `;

    cardContainer.appendChild(newCard);
}









    // confirmImportBtn.addEventListener('click', function () {
    //     const selectedNewRows = bulkUploadReviewModalEl.querySelectorAll('#reviewNewTableBody .row-checkbox:checked');
    //     if (selectedNewRows.length === 0) {
    //         alert("No new suppliers selected for import.");
    //         return;
    //     }
        

    //     const suppliersToImport = [];
    
    //     selectedNewRows.forEach(checkbox => {
    //         const row = checkbox.closest('tr');
    //         const cells = row.querySelectorAll('td');


    //     const emailCellText = cells[2].innerText;  
    //             let emailMatch = emailCellText.match(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}/);
    //             let email = emailMatch ? emailMatch[0] : '';
                
    //             const supplierData = {
    //                 supplierName: cells[2].querySelector('.cell-primary')?.textContent.trim() || '',
    //                 serviceNature: cells[2].querySelector('[data-field="serviceNature"]')?.textContent.trim() || '',
    //                 email: email,   // ✅ only clean email
    //                 contractType: cells[3].querySelector('[data-field="contractType"]')?.textContent.trim() || '',
    //                 contractNumber: cells[3].querySelectorAll('[contenteditable="true"]')[0]?.textContent.trim() || '',
    //                 contractStartDate: cells[3].querySelectorAll('[contenteditable="true"]')[1]?.textContent.trim() || '',
    //                 contractEndDate: cells[3].querySelectorAll('[contenteditable="true"]')[2]?.textContent.trim() || '',
    //             };
                
     

    //         suppliersToImport.push(supplierData);
    //     });

    //     fetch("{{route('sqa-new-supplier-update-bulk-parse')}}", {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         body: JSON.stringify({ suppliers: suppliersToImport })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.success) {
    //              toastr.success(`${suppliersToImport.length} supplier(s) successfully imported.`);
    //                 setTimeout(() => {
    //                     location.reload();
    //                 }, 2000);
    //         } else {
    //             toastr.error('Failed to import suppliers: ' + data.message);
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Import error:', error);
    //           toastr.error('Something went wrong during import.');
    //     });
        
    // });
    
    // --- ############### BULK UPLOAD SCRIPTING END ############### ---



    // --- INITIAL LOAD ---
    sortSuppliers();
    populateDynamicFilters(); 
    calculateAndDisplayContractStatus(); 
    updateOpenTicketCounts();
    checkAndToggleRibbon();
});
</script>

<script>
$(document).ready(function () {

    function downloadSampleCSV() {
        const headers = ["supplierName", "serviceNature", "email", "contractType", "contractNumber", "contractEndDate"];
        const rows = [
            ["New Dairy Farms", "Food/Ingredients", "sales@newdairy.com", "Quarterly Supply", "C-2025-105", "2025-03-31"],
            ["CleanScape Services", "Other Service", "support@cleanscape.com", "Annual Service", "C-2025-106", "2025-12-31"]
        ];
        
        let csvContent = "data:text/csv;charset=utf-8," 
            + headers.join(",") + "\n" 
            + rows.map(e => e.join(",")).join("\n");

        let encodedUri = encodeURI(csvContent);
        let link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "supplier_template.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    $("#downloadSampleCsvLink").on("click", function(e) {
        e.preventDefault();
        downloadSampleCSV();
    });

});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".edit-icon").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("supplier_id").value = this.dataset.id;
            
            document.getElementById("contract_number").value = this.dataset.number || '';
            document.getElementById("contract_start_date").value = this.dataset.start || '';
            document.getElementById("contract_end_date").value = this.dataset.end || '';

            const contractTypeSelect = document.getElementById("newSupplierContractType1");
            const typeValue = (this.dataset.type || "").trim().toLowerCase();
            let matched = false;
            [...contractTypeSelect.options].forEach(opt => {
                if (opt.value.trim().toLowerCase() === typeValue) {
                    contractTypeSelect.value = opt.value;
                    matched = true;
                }
            });

            if (!matched) {
                console.warn("Contract type not matched:", typeValue);
            }
        });
    });
    
    populateDynamicFilters();
});


$(document).on('click', '.delete-supplier', function() {
    let btn = $(this);
    
    let productId = btn.data('supplier-id');
    if (!confirm("Are you sure you want to delete this supplier?")) {
        return;
    }

    $.ajax({
        url: "{{ route('sqa-new-supplier-delete', ':id') }}".replace(':id', productId),
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            btn.closest('tr').remove();
            toastr.success("Supplier deleted successfully.");
            setTimeout(() => {
                location.reload();
            }, 2000);
        },
        error: function(xhr) {
            toastr.error("Something went wrong.");
        }
    });
});


</script>
<script>
$(document).ready(function() {
    $('#contractForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('sqa.supplier.save.contract') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status === 'success') {
                    $('#uploadContractModal').modal('hide'); // hide modal
                    $('#contractForm')[0].reset();           // reset form
                    toastr.success(response.message);        // show success 
                    setTimeout(()=>{
                        location.reload()
                    },2000)
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]); // show each validation error
                    });
                } else {
                    toastr.error('Something went wrong!');
                }
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $('#newSupplierForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        var formData = new FormData(this); 

        $.ajax({
            url: "{{ route('add.sqa.new.supplier') }}",
            method: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="bi bi-save me-2"></i>Saving...'); 
            },
            success: function(response) {
                 toastr.success(response.success);
                $('#newSupplierModal').modal('hide');
                form[0].reset();
                 setTimeout(() => {
                location.reload();
            }, 2000);
            },
           error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error("Something went wrong!");
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false); // re-enable button
                submitBtn.html('<i class="bi bi-save me-2"></i>Save Supplier'); // restore original text
            }
            
        });
    });
});
</script>


</body>
</html>