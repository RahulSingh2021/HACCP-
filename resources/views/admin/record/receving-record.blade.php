<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Food Material Receiving System - Final Version</title>
    <!-- External CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Embedded CSS -->
    <style>
        :root {
            --color-danger: #d93025;
            --color-danger-bg: #fce8e6;
            --color-warning: #a15c00;
            --color-warning-bg: #feefc3;
            --color-success: #1e8e3e;
            --color-success-bg: #e6f4ea;
            --color-primary: #1a73e8;
            --color-text-primary: #202124;
            --color-text-secondary: #5f6368;
            --border-color: #e0e0e0;
        }

        body { background-color: #f8f9fa; font-family: 'Roboto', sans-serif; }
        .signature-display { font-family: 'Caveat', cursive; font-size: 1.5rem; color: #0d6efd; }
        .table th, .table td { vertical-align: middle; }
        .shelf-life-warning { color: var(--color-danger); font-weight: 500; }
        .shelf-life-ok { color: var(--color-success); font-weight: 500; }
        .signature-pad-canvas { border: 2px dashed #ccc; cursor: crosshair; width: 100%; height: 100px; }

        /* Mobile Report View Styles */
        .report-container {
            font-family: 'Inter', sans-serif;
            color: #172b4d;
            max-width: 900px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(23, 43, 77, 0.1);
            overflow: hidden;
        }
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            background-color: #fafbfd;
            border-bottom: 1px solid #dfe1e6;
        }
        .product-info h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            color: #091e42;
        }
        .product-info p {
            margin: 4px 0 0;
            font-size: 14px;
            color: #6b778c;
        }
        .media-info {
            display: flex;
            gap: 15px;
        }
        .media-item {
            text-align: center;
        }
        .media-placeholder {
            width: 80px;
            height: 60px;
            border: 2px dashed #c1c7d0;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #6b778c;
            background-color: #f4f5f7;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .media-caption {
            font-size: 12px;
            font-weight: 500;
            color: #42526e;
        }
        .view-link {
            font-size: 12px;
            font-weight: 500;
            color: #0052cc;
            text-decoration: none;
        }
        .view-link:hover {
            text-decoration: underline;
        }
        .report-body {
            padding: 24px;
        }
        .section {
            margin-bottom: 24px;
        }
        .section:last-child {
            margin-bottom: 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #091e42;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #dfe1e6;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .grid-item {
            font-size: 14px;
        }
        .grid-item .label {
            display: block;
            font-weight: 500;
            color: #6b778c;
            margin-bottom: 6px;
        }
        .grid-item .value {
            font-weight: 400;
            color: #172b4d;
        }
        .grid-item .value.rejected {
            color: #de350b;
            font-weight: 600;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .text-area {
            background-color: #fafbfd;
            border: 1px solid #dfe1e6;
            border-radius: 4px;
            padding: 12px;
            min-height: 60px;
            color: #172b4d;
            font-size: 14px;
        }
        .signatures {
             grid-template-columns: 1fr 1fr;
        }
        .signature-area {
            background-color: #fafbfd;
            border: 1px solid #dfe1e6;
            border-radius: 4px;
            padding: 12px;
            min-height: 80px;
            color: #172b4d;
        }

        /* Style for activated filter icon on desktop */
        .filter-active i {
            color: var(--color-primary) !important;
        }

        /* Mobile Specific Styles */
        @media screen and (max-width: 991.98px) {
            .header-actions .btn-label { display: none; }
            /* Hide the table header on mobile, as we have a dedicated filter offcanvas */
            .table thead { display: none; }
            .table tr, .table td { display: block; width: 100%; }
            .table > tbody > tr > td { padding: 0; border: none; }
            .table > tbody > tr { margin-bottom: 1rem; border: none; box-shadow: none; background-color: transparent; }
             /* Ensure TomSelect dropdowns are visible in modals on mobile */
            .ts-dropdown {
                z-index: 1060; /* Higher than modal's default z-index of 1055 */
            }

            /* STICKY MOBILE HEADER */
            #page-header {
                position: sticky;
                top: 0;
                background-color: #f8f9fa; /* Match body bg color */
                z-index: 1020;
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05); 
                 /* Full-width effect to break out of container padding */
                margin-left: -1rem;
                margin-right: -1rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        #receivingRegisterTable th { font-weight: 500; white-space: nowrap; }
        #receivingRegisterTable .form-control, #receivingRegisterTable .form-select, #receivingRegisterTable .btn { font-size: 0.85rem; }
        #receivingRegisterTable td { padding: 0.5rem; }
        #receivingRegisterTable .form-control-sm { padding: 0.25rem 0.5rem; }
        #receivingRegisterTable th:first-child, #receivingRegisterTable td:first-child { width: 45px; text-align: center; }
        
        .merged-cell-label { font-size: 0.75rem; color: var(--color-text-secondary); margin-bottom: 0.2rem; display: block; }
        .discrepancy-display { font-size: 0.8rem; color: var(--color-danger); font-weight: 500; margin-top: 0.2rem; }
        .needs-review { background-color: var(--color-warning-bg) !important; }
        
        .temp-image-preview { width: 40px; height: 30px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; display: none; margin-left: 5px; }
        .view-coa-btn { padding: 0.25rem 0.5rem; }
        .view-attachment-link { text-decoration: none; }
        .view-attachment-link i { color: var(--color-primary); }
        .input-group-icon {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            color: var(--color-text-secondary);
        }
        .form-control-icon { padding-left: 2.5rem !important; }
        .is-invalid-label {
            color: var(--color-danger) !important;
            border-color: var(--color-danger) !important;
            background-color: var(--color-danger-bg) !important;
        }

        #recordsTable th a.text-secondary {
            text-decoration: none;
        }
        #recordsTable th a.text-secondary:hover {
            color: var(--color-primary) !important;
        }
        
        /* Style for mismatched data in bulk upload review */
        .mismatch-tag {
            background-color: var(--color-danger-bg);
            color: var(--color-danger);
            padding: 0.25em 0.6em;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
        }

        /* TomSelect styling override for smaller font size in table */
        #receivingRegisterTable .ts-control {
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
        }
         #receivingRegisterTable .ts-input {
            font-size: 0.85rem;
        }
        
        
        
        .custom-select {
  position: relative;
  width: 100%;
  font-family: inherit;
}

.select-selected {
  background-color: #fff;
  border: 1px solid #ced4da;
  padding: 10px;
  border-radius: 4px;
  cursor: pointer;
}

.select-items {
  position: absolute;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-top: none;
  z-index: 99;
  width: 100%;
  max-height: 220px;
  overflow-y: auto;
  border-radius: 0 0 4px 4px;
  display: none;
}

.select-search {
  width: 100%;
  padding: 8px;
  border: none;
  border-bottom: 1px solid #ddd;
  outline: none;
}

.select-option {
  padding: 10px;
  cursor: pointer;
}

.select-option:hover {
  background-color: #f1f1f1;
}

    </style>
</head>
<body class="bg-light">

    <!-- Header -->
    <!--<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">-->
    <!--    <div class="container-fluid">-->
    <!--        <a class="navbar-brand d-flex align-items-center" href="#"><div class="bg-primary text-white p-2 rounded me-2"><i class="fas fa-utensils"></i></div><span class="fw-bold fs-4">FoodSafe</span></a>-->
    <!--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"><span class="navbar-toggler-icon"></span></button>-->
    <!--        <div class="collapse navbar-collapse" id="navbarSupportedContent">-->
    <!--            <ul class="navbar-nav ms-auto"><li class="nav-item dropdown"><a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"><div class="avatar bg-primary text-white rounded-circle me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">JS</div><div><div class="fw-bold">Jane Smith</div><div class="small text-muted">Quality Manager</div></div></a><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="#">Profile</a></li><li><a class="dropdown-item" href="#">Settings</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item" href="#">Logout</a></li></ul></li></ul>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</nav>-->

    <!-- Main Content -->
    <div class="container-fluid p-3 p-md-4">
        <div class="row g-3 mb-4 align-items-center" id="page-header">
            <div class="col-md-4">
                <h1 class="h3 mb-0">Receiving Records</h1>
            </div>
            <div class="col-md-4">
                 <form onsubmit="return false;">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                        <input class="form-control border-start-0" type="search" id="globalSearchInput" placeholder="Search records...">
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="header-actions d-flex gap-2 justify-content-md-end">
                     <button class="btn btn-warning d-none" id="verifySelectedBtn"><i class="fas fa-check-double me-1"></i><span class="btn-label"> Verify Selected</span></button>
                     <button class="btn btn-outline-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileFilterOffcanvas" id="mobileFilterBtn">
                        <i class="fas fa-filter me-1"></i> Filter
                     </button>
                     <button class="btn btn-info" id="downloadPdfBtn"><i class="fas fa-file-pdf me-1"></i><span class="btn-label"> Download PDF</span></button>
                     <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt me-1"></i><span class="btn-label"> Refresh</span></button>
                     <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewRecordModal"><i class="fas fa-plus me-1"></i><span class="btn-label"> New Record</span></button>
                </div>
            </div>
         </div>


        <div class="card shadow-sm border-0">
             <div class="card-body p-0 p-lg-2">
                <div class="table-responsive">
                    <table class="table" id="recordsTable">
                        <thead class="bg-light">
                             <tr>
                                <th>
                                    Receiving / Invoice No. <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="receiving"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" style="width: 280px;" data-filter-group-content="receiving"></div>
                                </th>
                                <th>
                                    Supplier & Material Details <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="supplier"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" style="width: 320px;" data-filter-group-content="supplier"></div>
                                </th>
                                <th>Storage Area</th>
                                <th>
                                    Quantity <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="quantity"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" data-filter-group-content="quantity"></div>
                                </th>
                                <th>
                                    Quality Checks <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="quality"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" data-filter-group-content="quality"></div>
                                </th>
                                <th>
                                    Vendor Eval. <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="vendor"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" data-filter-group-content="vendor"></div>
                                </th>
                                <th>Received By</th>
                                <th>
                                    Corrective Action <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="action"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" data-filter-group-content="action"></div>
                                </th>
                                <th>Verified By</th>
                                <th>
                                    Attachments <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false" data-filter-group="attachments"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" style="width: 250px;" data-filter-group-content="attachments"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center">
                    <span class="me-2">Rows per page:</span>
                    <select class="form-select form-select-sm" id="rowsPerPageSelect" style="width: auto;">
                        <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                    </select>
                </div>
                <div id="paginationInfo" class="text-muted small"></div>
                <nav id="paginationControls" aria-label="Page navigation"></nav>
            </div>
        </div>
    </div>
    
    <!-- Mobile Filter Offcanvas -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilterOffcanvas" aria-labelledby="mobileFilterOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileFilterOffcanvasLabel"><i class="fas fa-filter me-2"></i>Filter Records</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="accordion" id="filterAccordion">
                <!-- All filter content will be dynamically inserted here by JavaScript -->
            </div>
        </div>
        <div class="offcanvas-footer p-3 bg-light border-top">
             <div class="d-flex gap-2">
                <button class="btn btn-secondary flex-grow-1" id="clearAllFiltersBtn">Clear All</button>
                <button class="btn btn-primary flex-grow-1" id="applyAllFiltersBtn" data-bs-dismiss="offcanvas">Apply</button>
            </div>
        </div>
    </div>


    <!-- Modals -->
    <div class="modal fade" id="addNewRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Receiving Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                    <form id="newRecordForm" novalidate>
                        <!-- STEP 1 -->
                        <div id="step1-vendor-details">
                            <h5 class="mb-3 fw-bold">Step 1: Vendor & Shipment Details</h5>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="card h-100 shadow-sm"><div class="card-header bg-white py-3"><h6 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipment Information</h6></div>
                                        <div class="card-body">
                                            <!--<div class="mb-3">-->
                                            <!--    <label class="form-label">Vendor <span class="text-danger">*</span></label>-->
                                            <!--    <select id="vendorSelect" name="vendor" class="form-control" required>-->
                                            <!--        <option value="" disabled selected>Search or select a vendor...</option>-->
                                            <!--        @foreach($vendors as $v)-->
                                            <!--            <option value="{{ $v->name }}">{{ $v->name }}</option>-->
                                            <!--        @endforeach-->
                                            <!--    </select>-->
                                            <!--</div>-->
                                            
                                            
                                            
<div class="mb-3">
  <label class="form-label">Vendor <span class="text-danger">*</span></label>

  <div class="custom-select" id="vendorDropdown">
    <div class="select-selected">Select vendor...</div>
    <div class="select-items">
      <input type="text" class="select-search" placeholder="Search vendor...">
      @foreach($vendors as $v)
        <div class="select-option" data-value="{{ $v->name }}">{{ $v->name }}</div>
      @endforeach
    </div>
  </div>

  <!-- Hidden real input for form submission -->
  <input type="hidden" name="vendor" id="vendorInput" required>
</div>


                                            <div class="mb-3"><label class="form-label">PO Number</label><div class="position-relative"><i class="fas fa-hashtag input-group-icon"></i><input type="text" class="form-control form-control-icon" id="poNumberInput" placeholder="Enter Purchase Order number"></div></div>
                                            <div><label class="form-label">Invoice Number <span class="text-danger">*</span></label><div class="position-relative"><i class="fas fa-file-invoice input-group-icon"></i><input type="text" class="form-control form-control-icon" id="invoiceNumberInput" placeholder="Enter invoice number" required></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card h-100 shadow-sm"><div class="card-header bg-white py-3"><h6 class="mb-0"><i class="fas fa-folder-open me-2 text-primary"></i>Required Documents</h6></div>
                                        <div class="card-body">
                                            <div class="mb-3"><label class="form-label">Upload Invoice <span class="text-danger">*</span></label><input class="form-control" type="file" id="invoiceInput" required><div class="form-text">Please attach the vendor's official invoice document.</div></div>
                                            <div><label class="form-label">Upload Form E <span class="text-danger">*</span></label>
                                            <input class="form-control" type="file" id="formEInput" required><div class="form-text">Ensure the Form E document is clear and complete.</div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4"><div class="d-flex justify-content-end gap-2"><button type="button" class="btn btn-success" id="vendorChecklistBtn"><i class="fas fa-check-square me-1"></i> Complete Checklist & Proceed</button></div>
                        </div>
                        <!-- STEP 2 -->
                        <div id="step2-receiving-register" class="d-none">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 fw-bold">Step 2: Receiving Register</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <label for="bulkUploadInput" class="btn btn-secondary btn-sm mb-0"><i class="fas fa-upload me-1"></i> Bulk Upload CSV</label><input type="file" id="bulkUploadInput" class="d-none" accept=".csv"><a href="#" id="downloadSampleCsvBtn" class="btn btn-outline-info btn-sm"><i class="fas fa-download me-1"></i> Sample CSV</a>
                                </div>
                            </div>
                            <div class="table-responsive"><table id="receivingRegisterTable" class="table table-bordered align-middle bg-white"><thead class="table-light"><tr><th>Action</th><th>Product / Brand</th><th>Batch #</th><th>Storage Area</th><th>Dates & Shelf Life</th><th>Quantities</th><th>Temperature</th><th>Attachments (COA)</th></tr></thead><tbody id="product-entries-tbody"></tbody></table></div>
                            <button type="button" class="btn btn-outline-primary mt-2" id="addMoreProductBtn"><i class="fas fa-plus"></i> Add Another Product</button>
                            <div class="card mt-4 shadow-sm"><div class="card-header bg-white py-3"><h6 class="mb-0"><i class="fas fa-pen-alt me-2 text-primary"></i>Finalization</h6></div>
                                <div class="card-body"><div class="row g-4">
                                    <div class="col-lg-5"><div class="form-floating h-100"><textarea id="generalRemarks" class="form-control" placeholder="Leave a comment here" style="min-height: 125px;"></textarea><label for="generalRemarks">General Remarks (Optional)</label></div></div>
                                    <div class="col-lg-3"><label class="form-label">Received By</label><div class="position-relative"><i class="fas fa-user input-group-icon"></i><input type="text" id="received_by" class="form-control form-control-icon" value="{{$name}}" readonly></div></div>
                                    <div class="col-lg-4" style="display:none"><label class="form-label">Signature <span class="text-danger">*</span></label><div class="border rounded p-1 bg-white">
                                        <canvas id="receiverSignPad" class="signature-pad-canvas"></canvas></div><button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clearReceiverSign"><i class="fas fa-eraser me-1"></i>Clear</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">User Signature <span class="text-danger">*</span></label>
                                        <div class="border rounded p-1 bg-white" style="height:100px">
                                            <canvas id="userSignatureCanvas" class="custom-signature-canvas" width="400" height="200"></canvas>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="btnClearSignature">
                                            <i class="fas fa-eraser me-1"></i>Clear
                                        </button>
                                        <button type="button" class="btn btn-primary mt-2" id="btnConfirmSignature" disabled>
                                            Confirm
                                        </button>
                                    </div>
                                </div></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-primary" id="saveRecordBtn" disabled>Save Record</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dataMatcherModal" tabindex="-1" aria-labelledby="dataMatcherModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"><div class="modal-dialog modal-xl modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="dataMatcherModalLabel"><i class="fas fa-list-check me-2"></i>Review Bulk Upload</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><p class="text-muted">Review items that couldn't be matched to our database. You can accept items individually, or correct and accept all remaining items in bulk.</p><div class="table-responsive"><table class="table table-sm table-bordered align-middle"><thead class="table-light"><tr><th style="width: 5%;" class="text-center"><input class="form-check-input" type="checkbox" id="selectAllMatcherCheckbox" title="Select All"></th><th style="width: 20%;">Product in CSV</th><th style="width: 20%;">Brand in CSV</th><th style="width: 35%;">Corrected Value (Select to fix)</th><th style="width: 20%;" class="text-center">Actions</th></tr></thead><tbody id="mismatched-items-tbody"></tbody></table></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-outline-danger" id="rejectSelectedMatcherBtn"><i class="fas fa-trash-alt me-1"></i> Reject Selected</button><button type="button" class="btn btn-primary" id="confirmMatcherBtn"><i class="fas fa-check-double me-1"></i> Accept All Remaining</button></div></div></div></div>
    <div class="modal fade" id="vendorChecklistModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">
        
        
        
        
        
        <h5 class="modal-title">Vendor Evaluation Checklist</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Ensure all checks are satisfactory.</p><table class="table table-bordered"><tbody><tr><td>Vehicle Condition</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c1"></div></td></tr><tr><td>Temperature Control</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c2"></div></td></tr><tr><td>Packaging Integrity</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c3"></div></td></tr><tr><td>Driver Hygiene</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c4"></div></td></tr></tbody></table></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmChecklistBtn">Confirm & Proceed</button></div></div></div></div>
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Confirm Verification</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label for="verificationComments" class="form-label">Comments (Optional)</label><textarea class="form-control" id="verificationComments" rows="2"></textarea></div><div class="mb-3"><label class="form-label">Signature</label><div class="border rounded p-1"><canvas id="verifierSignPad" class="signature-pad-canvas"></canvas></div><button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="clearVerifierSign">Clear</button></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmVerificationBtn" disabled>Confirm Verification</button></div></div></div></div>
    <div class="modal fade" id="viewVendorReportModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Vendor Evaluation Report</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="vendorReportBody"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div></div></div></div>


    <div class="modal fade" id="editRowModal" tabindex="-1" aria-labelledby="editRowModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editRowForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editRowModalLabel">Edit Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Manufacturing Date -->
          <div class="mb-3">
            <label for="editMfg" class="form-label">Manufacturing Date (MFG)</label>
            <input type="date" class="form-control" id="editMfg" name="mfg" required>
          </div>

          <!-- Expiry Date -->
          <div class="mb-3">
            <label for="editExp" class="form-label">Expiry Date (EXP)</label>
            <input type="date" class="form-control" id="editExp" name="exp" required>
          </div>
          
          
        <div class="mb-3">
            <label for="editReceivedDate" class="form-label">Receiving Date</label>
             <input type="datetime-local" class="form-control" id="editReceivedDate" required>
          </div>
          

          <!-- Ordered Quantity -->
          <div class="mb-3">
            <label for="editOrdered" class="form-label">Ordered Quantity</label>
            <input type="number" step="0.01" class="form-control" id="editOrdered" name="ordered" required>
          </div>

          <!-- Received Quantity -->
          <div class="mb-3">
            <label for="editReceived" class="form-label">Received Quantity</label>
            <input type="number" step="0.01" class="form-control" id="editReceived" name="received" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.0/dist/signature_pad.umd.min.js"></script>
<script>
const dropdown = document.getElementById("vendorDropdown");
const selected = dropdown.querySelector(".select-selected");
const items = dropdown.querySelector(".select-items");
const search = dropdown.querySelector(".select-search");
const options = dropdown.querySelectorAll(".select-option");
const hiddenInput = document.getElementById("vendorInput");

// Toggle dropdown
selected.addEventListener("click", () => {
  items.style.display = items.style.display === "block" ? "none" : "block";
  search.focus();
});

// Filter options
search.addEventListener("keyup", function() {
  const filter = this.value.toLowerCase();
  options.forEach(opt => {
    const text = opt.textContent.toLowerCase();
    opt.style.display = text.includes(filter) ? "" : "none";
  });
});

// Select option
options.forEach(opt => {
  opt.addEventListener("click", function() {
    selected.textContent = this.textContent;
    hiddenInput.value = this.dataset.value;
    items.style.display = "none";
  });
});

// Close dropdown if clicked outside
document.addEventListener("click", function(e) {
  if (!dropdown.contains(e.target)) {
    items.style.display = "none";
  }
});
 </script>
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn')) {
                const btn = e.target.closest('.delete-btn');
                const id = btn.getAttribute('data-id');
                let url = btn.getAttribute('data-route');
        
                url = url.replace(':id', id);
                if (confirm('Are you sure you want to delete this item?')) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success('Deleted successfully!');
                            btn.closest('tr').remove();
                            
                        } else {
                             toastr.error('Deletion failed!');
                        }
                    })
                    .catch(err => console.error(err));
                }
            }
        });

    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const canvas = document.getElementById('userSignatureCanvas');
            const signaturePad = new SignaturePad(canvas);
        
            const btnConfirm = document.getElementById('btnConfirmSignature');
            const btnClear = document.getElementById('btnClearSignature');
        
            canvas.addEventListener('pointerup', () => {
                btnConfirm.disabled = signaturePad.isEmpty();
            });
        
            btnClear.addEventListener('click', () => {
                signaturePad.clear();
                btnConfirm.disabled = true;
            });
        });

    </script>
    <script>
    function formatForDatetimeLocal(input) {
        const d = new Date(input);
        if (isNaN(d.getTime())) return ""; 
        return d.toISOString().slice(0, 16); 
    }

        const editModal = new bootstrap.Modal(document.getElementById('editRowModal'));
        let editingRowId = null;
        
        document.addEventListener('click', function(e) {
          if(e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            editingRowId = btn.dataset.id;
             document.getElementById('editMfg').value = btn.dataset.mfg || '';
            document.getElementById('editExp').value = btn.dataset.exp || '';
            document.getElementById('editOrdered').value = btn.dataset.ordered || '';
            document.getElementById('editReceived').value = btn.dataset.received || '';
            document.getElementById('editReceivedDate').value = formatForDatetimeLocal(btn.dataset.receivingdate) || '';
            
    
        
            editModal.show();
          }
        });

        document.getElementById('editRowForm').addEventListener('submit', function(e) {
          e.preventDefault();
        
          const mfg = document.getElementById('editMfg').value;
          const exp = document.getElementById('editExp').value;
          const ordered = parseFloat(document.getElementById('editOrdered').value);
          const received = parseFloat(document.getElementById('editReceived').value);
          const editReceivedDate = document.getElementById('editReceivedDate').value;
        
          const recordId = editingRowId;
        
          fetch("{{route('update.receiving.record')}}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
              mfg: mfg,
              exp: exp,
              ordered: ordered,
              received: received,
              received_date: editReceivedDate,
              recordId:recordId
            })
          })
          .then(response => response.json())
          .then(data => {
              console.log("datadata",data)
            if (data.success) {
            //   const tr = document.querySelector(`tr[data-id='${recordId}']`);
        
            //   if(tr) {
            //     const btn = tr.querySelector('.edit-btn');
            //     btn.dataset.mfg = mfg;
            //     btn.dataset.exp = exp;
            //     btn.dataset.ordered = ordered;
            //     btn.dataset.received = received;
            //     btn.dataset.receivingdate = editReceivedDate;
        
            //     tr.querySelector('.d-none.d-lg-table-cell:nth-child(2) .small:nth-child(4)').innerHTML =
            //       `MFG: ${mfg} <br> EXP: ${exp}`;
        
            //     tr.querySelector('.d-none.d-lg-table-cell:nth-child(4) div').innerHTML =
            //       `<div class="small"><span class="text-muted">Ordered:</span> ${ordered}</div>
            //       <div class="small"><span class="text-muted">Accepted:</span> ${received}</div>`;
            //   }
        
            //   editModal.hide();
        
              toastr.success('Record updated successfully!');
               setTimeout(()=>{
                location.reload()
            },2000)
            } else {
              toastr.error('Failed to update!');
            }
          })
          .catch(error => {
            console.error(error);
            toastr.error('AJAX error occurred!');
          });
        });


    </script>
    <script>

     document.addEventListener("DOMContentLoaded", () => {
            loadRecords();
        });

        // async function loadRecords() {
        //     try {
        //         const res = await fetch("get-receiving-records-data");
        //         const data = await res.json();
        
        //         if (data.success) {
        //           console.log("data1234",data);
        //             initApps(data.productDatabase, data.vendors,data.formattedRecords); 
        
        //         } else {
        //             console.error("Failed to load brands:", data.message);
        //             initApps({}, [],[]);
        //         }
        //     } catch (err) {
        //         console.error("Error fetching brands:", err);
        //       initApps({}, [],[]);
        //     }
        // }

    async function loadRecords(filters = {}) {
      try {
        const queryString = new URLSearchParams(filters).toString();
        const url = queryString
          ? `get-receiving-records-data?${queryString}`
          : "get-receiving-records-data";
        const res = await fetch(url);
        const data = await res.json();
    
        if (data.success) {
          console.log("Loaded data:", data);
          initApps(data.productDatabase, data.vendors, data.formattedRecords);
        } else {
          console.error("Failed to load records:", data.message);
          initApps({}, [], []);
        }
      } catch (err) {
        console.error("Error fetching records:", err);
        initApps({}, [], []);
      }
    }



    function initApps(productDetails, vendorsData, dataMain){
        let allRecords = [];
        let displayedRecords = [];
        let paginationState = { currentPage: 1, rowsPerPage: 10 };
        let verificationMode = 'single';
        let verificationTargetIds = [];
        let csvReviewData = { matched: [], mismatched: [] };
        let tomSelectInstances = {};

         const productDatabase = productDetails;
         
        // const allBrands = [...new Set(Object.values(productDatabase).flat())];
        const storageLocations = ["Dry Store A", "Dry Store B", "Chiller Room 1", "Chiller Room 2", "Freezer A-1", "Freezer B-2"];

        const mainModalEl = document.getElementById('addNewRecordModal');
        const verificationModalEl = document.getElementById('verificationModal');
        const dataMatcherModalEl = document.getElementById('dataMatcherModal');
        const viewVendorReportModalEl = document.getElementById('viewVendorReportModal');
        
        const mainModal = new bootstrap.Modal(mainModalEl);
        const checklistModal = new bootstrap.Modal(document.getElementById('vendorChecklistModal'));
        const verificationModal = new bootstrap.Modal(verificationModalEl);
        const dataMatcherModal = new bootstrap.Modal(dataMatcherModalEl);
        const viewVendorReportModal = new bootstrap.Modal(viewVendorReportModalEl);
        
        new bootstrap.Tooltip(document.body, { selector: "[data-bs-toggle='tooltip']" });

        function setupSignaturePad(canvasId, buttonId, modalElement) {
            const canvas = document.getElementById(canvasId);
            const button = document.getElementById(buttonId);
            if (!canvas || !modalElement) return null;
            const signaturePad = new SignaturePad(canvas);
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
                if (button) button.disabled = true;
            }
            window.addEventListener("resize", resizeCanvas);
            modalElement.addEventListener('shown.bs.modal', resizeCanvas);
            if (button) { signaturePad.onEnd = () => { button.disabled = false; }; }
            return signaturePad;
        }
        const receiverSignPad = setupSignaturePad('receiverSignPad', null, mainModalEl);
        const verifierSignPad = setupSignaturePad('verifierSignPad', 'confirmVerificationBtn', verificationModalEl);
        document.getElementById('clearReceiverSign').addEventListener('click', () => { receiverSignPad.clear(); });
        document.getElementById('clearVerifierSign').addEventListener('click', () => { verifierSignPad.clear(); document.getElementById('confirmVerificationBtn').disabled = true; });

        const tableBody = document.querySelector("#recordsTable tbody");
        
        function getStatus(record) {
            const ordered = parseFloat(record.ordered);
            const received = parseFloat(record.received);
            if (received === 0 && ordered > 0) return 'Rejected';
            if (received < ordered) return 'Partial';
            return 'Approved';
        }

        function loadInitialData() {
            allRecords = dataMain;
            
            // allRecords = [
            //     { id: 3, rec: 'REC-08903', date: '2025-09-07', time: '11:45 AM', invoice: 'INV-QM-441', vendor: 'Quality Meats Ltd.', productName: 'Beef Tenderloin', brand: 'Quality Meats Ltd.', storageArea: 'Freezer B-2', batch: 'M-517-C', mfg: '2025-09-04', exp: '2025-09-11', ordered: 25, received: 0, temp: 9, discrepancyReason: 'Rejected', rejectionRemarks: 'Temp. high & low shelf life.', correctiveAction: 'Full shipment returned.', receivedBy: 'Michael Brown', vendorEval: 85, verified: true, tempImageSrc: 'https://placehold.co/80x30/fee2e2/dc2626?text=9%C2%B0C', vehicleVideoUrl: '#', attachments: { formE: true, invoice: true, coa: false } },
            //     { id: 2, rec: 'REC-08902', date: '2025-09-07', time: '09:30 AM', invoice: 'INV-DB-112', vendor: 'DairyBest', productName: 'Milk', brand: 'DairyBest', storageArea: 'Chiller Room 1', batch: 'M-209-B', mfg: '2025-09-05', exp: '2025-09-12', ordered: 100, received: 90, temp: 4, discrepancyReason: 'Shortfall', rejectionRemarks: '2 crates damaged.', correctiveAction: 'Credit note to be issued.', receivedBy: 'John Doe', vendorEval: 92, verified: false, tempImageSrc: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAABaCAYAAACVz3NMAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAYdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjEuNWRHWFIAAAKnSURBVHhe7d3BbdhAEAbgejcrgUagBKzgrEaACqQEWkI3sBOkBVpBOnB2Yv+TdCU3SOMzcgSRf2737c3lxd3e3d2P+/0+37e3t/fT09PTM27b9v2Yc3NeHh4efr5v255+P/7x8fHpdh4G2Jfh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4-AAAAAAElFTSuQmCC', vehicleVideoUrl: '#', attachments: { formE: true, invoice: true, coa: true } },
            //     { id: 1, rec: 'REC-08901', date: '2025-09-07', time: '08:15 AM', invoice: 'INV-FP-556', vendor: 'Fresh Produce Inc.', productName: 'Organic Tomatoes', brand: 'Fresh Produce Inc.', storageArea: 'Dry Store A', batch: 'T-451', mfg: '2025-09-06', exp: '2025-09-13', ordered: 50, received: 50, temp: 'N/A', rejectionRemarks: '', correctiveAction: '-', receivedBy: 'John Doe', vendorEval: 98, verified: true, tempImageSrc: null, vehicleVideoUrl: null, attachments: { formE: true, invoice: true, coa: false } },
            // ].map(rec => ({...rec, status: getStatus(rec)}));
            console.log("allRecords",allRecords);
            displayedRecords = [...allRecords];
             console.log("displayedRecords",displayedRecords);
            setupFilterUI();
            populateFilterDropdowns();
            renderTable();
        }

        function renderTable() {
            tableBody.innerHTML = '';
            const start = (paginationState.currentPage - 1) * paginationState.rowsPerPage;
            const end = start + paginationState.rowsPerPage;
            const paginatedRecords = displayedRecords.slice(start, end);
            paginatedRecords.forEach(data => tableBody.appendChild(createTableRowElement(data)));
            renderPaginationControls();
            updateVerifyButtonState();
        }
        

        document.getElementById('rowsPerPageSelect').addEventListener('change', function () {
            paginationState.rowsPerPage = parseInt(this.value);
            paginationState.currentPage = 1;
            renderTable();
        });


        // function renderPaginationControls() {
        //     const totalRecords = displayedRecords.length; const totalPages = Math.ceil(totalRecords / paginationState.rowsPerPage);
        //     const infoEl = document.getElementById('paginationInfo'); const controlsEl = document.getElementById('paginationControls');
        //     if (totalRecords === 0) { infoEl.textContent = 'No records found.'; controlsEl.innerHTML = ''; return; }
        //     const startRecord = (paginationState.currentPage - 1) * paginationState.rowsPerPage + 1; const endRecord = Math.min(startRecord + paginationState.rowsPerPage - 1, totalRecords);
        //     infoEl.textContent = `Showing ${startRecord} to ${endRecord} of ${totalRecords} entries`;
        //     let html = '<ul class="pagination pagination-sm mb-0">';
        //     html += `<li class="page-item ${paginationState.currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${paginationState.currentPage - 1}">«</a></li>`;
        //     let pages = [];
        //     if (totalPages <= 7) { for (let i = 1; i <= totalPages; i++) pages.push(i); } else {
        //         pages.push(1); if (paginationState.currentPage > 3) pages.push('...');
        //         for (let i = Math.max(2, paginationState.currentPage - 1); i <= Math.min(totalPages - 1, paginationState.currentPage + 1); i++) pages.push(i);
        //         if (paginationState.currentPage < totalPages - 2) pages.push('...'); pages.push(totalPages);
        //     }
        //     pages.forEach(page => { if (page === '...') { html += `<li class="page-item disabled"><span class="page-link">...</span></li>`; } else { html += `<li class="page-item ${page === paginationState.currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${page}">${page}</a></li>`; } });
        //     html += `<li class="page-item ${paginationState.currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${paginationState.currentPage + 1}">»</a></li>`;
        //     html += '</ul>'; controlsEl.innerHTML = html;
        // }


        function renderPaginationControls() {
            const totalRecords = displayedRecords.length;
            const totalPages = Math.ceil(totalRecords / paginationState.rowsPerPage);
        
            const infoEl = document.getElementById('paginationInfo');
            const controlsEl = document.getElementById('paginationControls');
        
            if (totalRecords === 0) {
                infoEl.textContent = 'No records found.';
                controlsEl.innerHTML = '';
                return;
            }
        
            const startRecord = (paginationState.currentPage - 1) * paginationState.rowsPerPage + 1;
            const endRecord = Math.min(startRecord + paginationState.rowsPerPage - 1, totalRecords);
            infoEl.textContent = `Showing ${startRecord} to ${endRecord} of ${totalRecords} entries`;
        
            let html = '<ul class="pagination pagination-sm mb-0">';
        
            html += `<li class="page-item ${paginationState.currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${paginationState.currentPage - 1}">«</a>
                     </li>`;
        
            let pages = [];
            if (totalPages <= 7) {
                for (let i = 1; i <= totalPages; i++) pages.push(i);
            } else {
                pages.push(1);
                if (paginationState.currentPage > 3) pages.push('...');
                for (let i = Math.max(2, paginationState.currentPage - 1); i <= Math.min(totalPages - 1, paginationState.currentPage + 1); i++) pages.push(i);
                if (paginationState.currentPage < totalPages - 2) pages.push('...');
                pages.push(totalPages);
            }
        
            pages.forEach(page => {
                if (page === '...') {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                } else {
                    html += `<li class="page-item ${page === paginationState.currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${page}">${page}</a>
                             </li>`;
                }
            });
        
            html += `<li class="page-item ${paginationState.currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${paginationState.currentPage + 1}">»</a>
                     </li>`;
            html += '</ul>';
        
            controlsEl.innerHTML = html;
        
            controlsEl.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    if (page && page !== '...') {
                        paginationState.currentPage = parseInt(page);
                        renderTable();             
                        renderPaginationControls();  
                    }
                });
            });
        }


        // function initTomSelect(selector, options, placeholder) { 
        //      if (tomSelectInstances[selector]) { tomSelectInstances[selector].destroy(); }
        //      tomSelectInstances[selector] = new TomSelect(selector, { create: false, sortField: { field: "text", direction: "asc" }, options: options, placeholder: placeholder, allowEmptyOption: true }); 
        // }

        // function populateFilterDropdowns() {
        //     // const uniqueVendors = [...new Set(allRecords.map(r => r.vendor))].map(v => ({value: v, text: v}));
        //     const uniqueVendors = vendorsData.map(v => ({ value: v.name, text: v.name }));
        //     alert();
        //     const uniqueProducts = [...new Set(allRecords.map(r => r.productName))].map(p => ({value: p, text: p}));
        //     initTomSelect('#filterVendorName', uniqueVendors, 'Select a vendor...');
        //     initTomSelect('#filterProductName', uniqueProducts, 'Select a product...');
        // }

    // Function to populate dropdowns and init TomSelect
    function populateFilterDropdowns() {
        const vendorSelects = document.querySelectorAll('.filterVendorName12');
        const productSelects = document.querySelectorAll('.filterProductName11');
        const uniqueProducts = Object.keys(productDatabase);
        vendorSelects.forEach(select => {
          select.innerHTML = '<option value="">Select a vendor...</option>';
        
          vendorsData.forEach(v => {
            const option = document.createElement('option');
            option.value = v.name;
            option.textContent = v.name;
            select.appendChild(option);
          });
        
        });
        
        productSelects.forEach(select => {
          select.innerHTML = '<option value="">Select a product...</option>';
        
          uniqueProducts.forEach(p => {
            const option = document.createElement('option');
            option.value = p;
            option.textContent = p;
            select.appendChild(option);
          });
        });
    }

        // function renderAttachmentsCell(attachments) {
        //     if (!attachments) { return `<div class="small text-muted">N/A</div>`; }
        //     const createLine = (label, has, type) => `<div class="d-flex justify-content-between align-items-center"><span>${label}:</span><span>${has ? `<span class="badge bg-success">Attached</span> <a href="#" class="ms-2 view-attachment-link" title="View ${label}" data-type="${type}"><i class="fas fa-eye"></i></a>` : `<span class="badge bg-secondary">Missing</span>`}</span></div>`;
        //     return `<div class="d-grid gap-1 small">${createLine('Form E', attachments.formE, 'form-e')}${createLine('Invoice', attachments.invoice, 'invoice')}${createLine('COA', attachments.coa, 'coa')}</div>`;
        // }

        function renderAttachmentsCell(attachments) {
            if (!attachments) {
                return `<div class="small text-muted">N/A</div>`;
            }
            const createLine = (label, filePath) => {
                const isAttached = !!filePath;
                return `<div class="d-flex justify-content-between align-items-center">
                    <span>${label}:</span>
                    <span>${isAttached ? 
                        `<span class="badge bg-success">Attached</span> <a href="${filePath}" target="_blank" class="ms-2 view-attachment-link" title="View ${label}"><i class="fas fa-eye"></i></a>` 
                        : `<span class="badge bg-secondary">Missing</span>`}
                    </span>
                </div>`;
            };
        
            return `<div class="d-grid gap-1 small">
                ${createLine('Form E', attachments.formE_file)}
                ${createLine('Invoice', attachments.invoice_file)}
                ${createLine('COA', attachments.coa_file)}
            </div>`;
        }

        // function createTableRowElement(data) {
        //     const tr = document.createElement('tr');
        //     tr.dataset.id = data.id;
        //     const received = parseFloat(data.received); const ordered = parseFloat(data.ordered); const shelfLife = calculateShelfLife(data.mfg, data.exp); const discrepancyQty = ordered - received; const verifiedByName = 'Jane Smith';
        //     let statusBadge = (data.status === 'Rejected') ? `<span class="badge bg-danger-subtle text-danger-emphasis rounded-pill mt-1"><i class="fas fa-times-circle me-1"></i>Rejected</span>` : (data.status === 'Partial') ? `<span class="badge bg-warning-subtle text-warning-emphasis rounded-pill mt-1"><i class="fas fa-exclamation-circle me-1"></i>Partial</span>` : `<span class="badge bg-success-subtle text-success-emphasis rounded-pill mt-1"><i class="fas fa-check-circle me-1"></i>Approved</span>`;
        //     let shelfLifeHTML = ''; if (shelfLife.days >= 0 && shelfLife.percentage >= 0) { const colorClass = shelfLife.percentage < 25 ? 'shelf-life-warning' : 'shelf-life-ok'; shelfLifeHTML = `<div class="small mt-1"><strong class="text-muted">Shelf Life:</strong> <span class="${colorClass}">${shelfLife.days} days (${shelfLife.percentage.toFixed(0)}%)</span></div>`; }
        //     let qtyHTML = `<div class="small"><span class="text-muted">Ordered:</span> ${ordered}</div><div class="small"><span class="text-muted">Accepted:</span> ${received}</div>`; if (discrepancyQty > 0) qtyHTML += `<div class="small text-danger fw-bold"><span class="text-muted">${data.discrepancyReason}:</span> ${discrepancyQty}</div>`; if (data.rejectionRemarks) qtyHTML += `<div class="small text-danger fst-italic">Reason: ${data.rejectionRemarks}</div>`;
        //     const qualityHTML = (data.temp === 'N/A') ? `<div><div class="fw-bold mb-1">N/A</div></div>` : `<div><div class="fw-bold mb-1">${data.temp}°C</div><a href="${data.tempImageSrc || '#'}" target="_blank" title="View full screen"><img src="${data.tempImageSrc || '#'}" alt="Temp" class="img-thumbnail p-0" style="width:80px; height:auto; border: 1px solid #ddd; cursor: pointer;"></a><div class="small text-muted fst-italic">${data.date} ${data.time}</div></div>`;
        //     const vendorEvalHTML = `<div class="text-center"><div class="fw-bold">${data.vendorEval}%</div><button class="btn btn-sm btn-outline-info w-100 mt-1">Report</button>${data.vehicleVideoUrl ? `<a href="${data.vehicleVideoUrl}" target="_blank" class="btn btn-sm btn-outline-secondary w-100 mt-2" title="View Vehicle Video"><i class="fas fa-video"></i></a>` : ''}</div>`;
        //     const verifiedHTML = data.verified ? `<div>${verifiedByName}</div><div class="signature-display">${verifiedByName.split(' ').map(n=>n[0]).join('.') + '.'}</div>` : `<button class="btn btn-sm btn-warning w-100 mb-2 verify-btn">Verify</button><div class="form-check"><input class="form-check-input row-checkbox" type="checkbox" data-id="${data.id}"><label class="form-check-label small">Select</label></div>`;
        //     const receivedBySignature = data.receivedBy.split(' ').map(n=>n[0]).join('.') + '.'; const attachmentsHTML = renderAttachmentsCell(data.attachments);
        //     const desktopHTML = `<td class="d-none d-lg-table-cell"><div><div class="fw-bold">${data.rec}</div><div class="text-muted small">${data.date}, ${data.time}</div><div class="small"><span class="text-muted">Invoice:</span> ${data.invoice}</div>${statusBadge}</div></td><td class="d-none d-lg-table-cell"><div>
            
        //  <div class="fw-bold">${data.productName}</div>
            
        //     <div class="text-muted">${data.brand}</div>
            
        //     <div class="text-muted">${data.vendor}</div>
            
        //     <hr class="my-1"><div class="small"><span class="text-muted">Batch:</span> ${data.batch}</div><div class="small"><span class="text-muted">MFG:</span> ${data.mfg}</div><div class="small"><span class="text-muted">EXP:</span> ${data.exp}</div>${shelfLifeHTML}</div></td><td class="d-none d-lg-table-cell fw-bold">${data.storageArea}</td><td class="d-none d-lg-table-cell"><div>${qtyHTML}</div></td><td class="d-none d-lg-table-cell">${qualityHTML}</td><td class="d-none d-lg-table-cell">${vendorEvalHTML}</td><td class="d-none d-lg-table-cell"><div>${data.receivedBy}</div><div class="signature-display">${receivedBySignature}</div></td><td class="d-none d-lg-table-cell"><div class="small">${data.correctiveAction || '-'}</div></td><td class="d-none d-lg-table-cell verified-cell">${verifiedHTML}</td><td class="d-none d-lg-table-cell">${attachmentsHTML}</td>`;
        //     const mobileHTML = `<td class="d-lg-none p-0"><div class="report-container my-3 mx-auto" style="box-shadow: none; border: 1px solid #dee2e6; border-radius: 8px; min-width: 0;"><div class="report-header"><div class="product-info flex-grow-1"><div><h1 class="h6">${data.productName}</h1><p class="small text-muted mb-1">Vendor: ${data.vendor}</p><p class="small text-muted mb-0">Received: ${data.date} ${data.time}</p></div></div><div class="media-info ps-3"><div class="media-item">${data.temp !== 'N/A' ? `<a href="${data.tempImageSrc || '#'}" target="_blank" class="text-decoration-none"><div class="media-placeholder" style="border-style: solid; background-color: #e9ecef;"><i class="fas fa-thermometer-half fa-2x"></i></div><div class="media-caption">${data.temp} &deg;C</div></a>` : `<div class="media-placeholder">N/A</div><div class="media-caption">Ambient</div>`}</div><div class="media-item"><button type="button" class="btn p-0 view-checklist-btn" data-id="${data.id}"><div class="media-placeholder" style="border-style: solid; background-color: #e9ecef; border-color: #0d6efd;"><i class="fas fa-clipboard-check fa-2x text-primary"></i></div><div class="media-caption">Checklist (${data.vendorEval}%)</div></button></div></div></div><div class="report-body"><div class="text-center mb-3"><button class="btn btn-sm btn-outline-secondary toggle-details-btn w-100">Show Full Report</button></div><div class="collapsible-details" style="display: none;"><div class="section"><h2 class="section-title">General Information</h2><div class="grid"><div class="grid-item full-width"><span class="label">Documentation</span><span class="value">${data.attachments.formE ? '<a href="#" class="view-link">Form E</a>' : 'Form E (Missing)'} | ${data.attachments.coa ? '<a href="#" class="view-link">COA</a>' : 'COA (Missing)'} | ${data.attachments.invoice ? `<a href="#" class="view-link">Invoice (${data.invoice})</a>` : `Invoice (${data.invoice}) (Missing)`}</span></div></div></div><div class="section"><h2 class="section-title">Product Details</h2><div class="grid"><div class="grid-item"><span class="label">MFD</span><span class="value">${data.mfg}</span></div><div class="grid-item"><span class="label">EXP</span><span class="value">${data.exp}</span></div><div class="grid-item"><span class="label">Batch #</span><span class="value">${data.batch}</span></div><div class="grid-item"><span class="label">Storage Area</span><span class="value fw-bold">${data.storageArea}</span></div><div class="grid-item full-width"><span class="label">Balance Shelf Life</span><span class="value ${shelfLife.percentage < 25 ? 'text-danger fw-bold' : ''}">${shelfLife.days} Days (${shelfLife.percentage.toFixed(0)}%)</span></div></div></div><div class="section"><h2 class="section-title">Order Info</h2><div class="grid"><div class="grid-item"><span class="label">Ordered</span><span class="value">${ordered}</span></div><div class="grid-item"><span class="label">Received</span><span class="value">${received}</span></div><div class="grid-item"><span class="label">Discrepancy</span><span class="value rejected">${discrepancyQty > 0 ? discrepancyQty : '0'}</span></div><div class="grid-item full-width"><span class="label">Comments</span><div class="text-area">${data.rejectionRemarks || 'N/A'}</div></div><div class="grid-item full-width"><span class="label">Corrective Action</span><div class="text-area">${data.correctiveAction || 'N/A'}</div></div></div></div></div><div class="section"><h2 class="section-title">Verification</h2><div class="grid signatures"><div class="grid-item"><span class="label">Received by</span><div class="signature-area"><div>${data.receivedBy}</div><div class="signature-display">${receivedBySignature}</div></div></div><div class="grid-item"><span class="label">Verified by</span><div class="signature-area d-flex flex-column align-items-center justify-content-center text-center">${verifiedHTML}</div></div></div></div></div></div></td>`;
        //     tr.innerHTML = desktopHTML + mobileHTML;
        //     return tr;
        // }
        
        function createTableRowElement(data) {
            const tr = document.createElement('tr');
            tr.dataset.id = data.id;
        
            const received = parseFloat(data.received);
            const ordered = parseFloat(data.ordered);
            const shelfLife = calculateShelfLife(data.mfg, data.exp);
            const discrepancyQty1 = ordered - received;
            const discrepancyQty = discrepancyQty1.toFixed(2);
            // const discrepancyQty = ordered - received;
            const verifiedByName = 'Jane Smith';
        
            let statusBadge = (data.status === 'Rejected') ? 
                `<span class="badge bg-danger-subtle text-danger-emphasis rounded-pill mt-1"><i class="fas fa-times-circle me-1"></i>Rejected</span>` :
                (data.status === 'Partial') ? 
                `<span class="badge bg-warning-subtle text-warning-emphasis rounded-pill mt-1"><i class="fas fa-exclamation-circle me-1"></i>Partial</span>` :
                `<span class="badge bg-success-subtle text-success-emphasis rounded-pill mt-1"><i class="fas fa-check-circle me-1"></i>Approved</span>`;
        
            // Shelf life
            let shelfLifeHTML = '';
            if (shelfLife.days >= 0 && shelfLife.percentage >= 0) {
                const colorClass = shelfLife.percentage < 25 ? 'shelf-life-warning' : 'shelf-life-ok';
                shelfLifeHTML = `<div class="small mt-1"><strong class="text-muted">Shelf Life:</strong> <span class="${colorClass}">${shelfLife.days} days (${shelfLife.percentage.toFixed(0)}%)</span></div>`;
            }
        
            // Quantity info
            let qtyHTML = `<div class="small"><span class="text-muted">Ordered:</span> ${ordered}</div>
                           <div class="small"><span class="text-muted">Accepted:</span> ${received}</div>`;
            if (discrepancyQty > 0) qtyHTML += `<div class="small text-danger fw-bold"><span class="text-muted">${data.discrepancyReason}:</span> ${discrepancyQty}</div>`;
            if (data.rejectionRemarks) qtyHTML += `<div class="small text-danger fst-italic">Reason: ${data.rejectionRemarks}</div>`;
        
            // Quality info
            const qualityHTML = (data.temp === 'N/A') ? 
                `<div><div class="fw-bold mb-1">N/A</div></div>` : 
                `<div>
                    <div class="fw-bold mb-1">${data.temp}°C</div>
                    <a href="${data.tempImageSrc || '#'}" target="_blank" title="View full screen">
                        <img src="${data.tempImageSrc || '#'}" alt="Temp" class="img-thumbnail p-0" style="width:80px; height:auto; border:1px solid #ddd; cursor:pointer;">
                    </a>
                    <div class="small text-muted fst-italic">${data.date} ${data.time}</div>
                </div>`;
        
            // Vendor evaluation
            const vendorEvalHTML = `<div class="text-center">
                                        <div class="fw-bold">${data.vendorEval}%</div>
                                        <button class="btn btn-sm btn-outline-info w-100 mt-1">Report</button>
                                        ${data.vehicleVideoUrl ? `<a href="${data.vehicleVideoUrl}" target="_blank" class="btn btn-sm btn-outline-secondary w-100 mt-2" title="View Vehicle Video"><i class="fas fa-video"></i></a>` : ''}
                                    </div>`;
        
            // Verified
            // const verifiedHTML = data.verified ? 
            //     `<div>${verifiedByName}</div>
            //      <div class="signature-display">${verifiedByName.split(' ').map(n=>n[0]).join('.') + '.'}</div>` :
            //     `<button class="btn btn-sm btn-warning w-100 mb-2 verify-btn">Verify</button>
            //      <div class="form-check"><input class="form-check-input row-checkbox" type="checkbox" data-id="${data.id}"><label class="form-check-label small">Select</label></div>`;
        
         const verifiedHTML = 
                `<button class="btn btn-sm btn-warning w-100 mb-2 verify-btn">Verify</button>
                 <div class="form-check"><input class="form-check-input row-checkbox" type="checkbox" data-id="${data.id}"><label class="form-check-label small">Select for n</label></div>`;
        
        
            const receivedBySignature = data.receivedBy.split(' ').map(n=>n[0]).join('.') + '.';
    //   const receivedBySignature = (data.receivedSign && data.receivedSign.trim() !== '')
    // ? data.receivedSign
    // : data.receivedBy.split(' ').map(n => n[0].toUpperCase()).join('.') + '.';

            const attachmentsHTML = renderAttachmentsCell(data.attachments);
        
            const desktopHTML = `
            <td class="d-none d-lg-table-cell">
                <div>
                    <div class="fw-bold">${data.rec}</div>
                    <div class="text-muted small">${data.date}, ${data.time}</div>
                    <div class="small"><span class="text-muted">Invoice:</span> ${data.invoice}</div>
                    ${statusBadge}
                    
                  <!-- Edit Button -->
                    <button class="btn btn-primary edit-btn" 
                            data-id="${data.id}"
                            data-exp="${data.exp}"
                            data-mfg="${data.mfg}"
                            data-receivingdate="${data.created_at}"
                            data-received="${data.received}"
                            data-ordered="${data.ordered}">
                        <i class="fas fa-edit"></i>
                    </button>
                
                    <!-- Delete Button -->
                    <button class="btn btn-danger delete-btn" 
                            data-id="${data.id}"
                            data-route="{{ route('delete-receiving-record', ':id') }}">
                        <i class="fas fa-trash-alt"></i> 
                    </button>
                        
                </div>
            </td>
            <td class="d-none d-lg-table-cell">
                <div>
                    <div class="fw-bold">${data.productName}</div>
                    <div class="text-muted">${data.brand}</div>
                    <div class="text-muted">${data.vendor}</div>
                    <hr class="my-1">
                    <div class="small"><span class="text-muted">Batch:</span> ${data.batch}</div>
                    <div class="small"><span class="text-muted">MFG:</span> ${data.mfg}</div>
                    <div class="small"><span class="text-muted">EXP:</span> ${data.exp}</div>
                    ${shelfLifeHTML}
                </div>
            </td>
            <td class="d-none d-lg-table-cell fw-bold">${data.storageArea}</td>
            <td class="d-none d-lg-table-cell"><div>${qtyHTML}</div></td>
            <td class="d-none d-lg-table-cell">${qualityHTML}</td>
            <td class="d-none d-lg-table-cell">${vendorEvalHTML}</td>
            <td class="d-none d-lg-table-cell">
              <div>${data.receivedBy}</div>
               <div class="signature-display">
                ${data.receivedSign 
                  ? `<img src="${data.receivedSign}" alt="Signature" style="width: 80px; height: auto;">` 
                  : receivedBySignature}
              </div>
            </td>


            <td class="d-none d-lg-table-cell"><div class="small">${data.correctiveAction || '-'}</div></td>
            <td class="d-none d-lg-table-cell verified-cell">${verifiedHTML}</td>
            <td class="d-none d-lg-table-cell">${attachmentsHTML}</td>`;
        
            // ✅ Mobile HTML remains unchanged
            const mobileHTML = `<td class="d-lg-none p-0"><div class="report-container my-3 mx-auto" style="box-shadow: none; border: 1px solid #dee2e6; border-radius: 8px; min-width: 0;"> ... your existing mobileHTML ... </td>`;
        
            tr.innerHTML = desktopHTML + mobileHTML;
            return tr;
        }


        function readFileAsDataURL(file) { return new Promise((resolve, reject) => { const reader = new FileReader(); reader.onload = () => resolve(reader.result); reader.onerror = reject; reader.readAsDataURL(file); }); }
        function calculateShelfLife(mfgStr, expStr) {
            if (!mfgStr || !expStr) return { days: 0, percentage: 0 };
            const mfgDateUTC = new Date(mfgStr + 'T00:00:00Z'); const expDateUTC = new Date(expStr + 'T00:00:00Z');
            const todayUTC = new Date(new Date().toISOString().split('T')[0] + 'T00:00:00Z');
            if (isNaN(mfgDateUTC.getTime()) || isNaN(expDateUTC.getTime()) || expDateUTC < mfgDateUTC) return { days: -1, percentage: 0 };
            const totalShelfLife = (expDateUTC - mfgDateUTC) / 864e5; if (totalShelfLife <= 0) return { days: 0, percentage: 0 };
            const remainingDays = Math.ceil((expDateUTC - todayUTC) / 864e5); const percentage = (remainingDays / totalShelfLife) * 100;
            return { days: remainingDays, percentage: Math.max(0, Math.min(100, percentage)) };
        }
        function getSelectedRecordIds() { return Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => parseInt(cb.dataset.id)); }
        function updateVerifyButtonState() { const selectedCount = getSelectedRecordIds().length; document.getElementById('verifySelectedBtn').classList.toggle('d-none', selectedCount === 0); }
        
        // function getProductRowTemplate(index) {
        //     return `<tr class="product-entry-row">
        //             <td><button type="button" class="btn btn-outline-danger btn-sm remove-product-btn" title="Delete Row"><i class="fas fa-trash"></i></button></td>
        //             <td><select class="form-select-sm product-name" required placeholder="Select product..."></select><select class="form-select-sm product-brand mt-1" required placeholder="Select brand..."></select></td>
        //              <td>
        //                 <label class="merged-cell-label">Batch #</label>
        //                 <input type="text" class="form-control form-control-sm product-batch" required>
        //                 <div class="mt-1">
        //                     <label class="merged-cell-label d-block mb-1">Yield</label>
        //                     <div class="d-flex gap-2">
        //                         <div class="form-check form-check-inline">
        //                             <input class="form-check-input" type="radio" 
        //                                   name="yield-${index}" id="yield-yes-${index}" value="Yes">
        //                             <label class="form-check-label" for="yield-yes-${index}"  style="font-size:11px">Yes</label>
        //                         </div>
        //                         <div class="form-check form-check-inline">
        //                             <input class="form-check-input" type="radio" 
        //                                   name="yield-${index}" id="yield-no-${index}" value="No" checked>
        //                             <label class="form-check-label" for="yield-no-${index}" style="font-size:11px">No</label>
        //                         </div>
        //                     </div>
        //                 </div>
        //             </td>

        //             <td><label class="merged-cell-label">Storage Area</label><select class="form-select-sm storage-area-select" required placeholder="Select area..."></select>
        //              <div class="mt-1">
        //                 <label class="merged-cell-label d-block mb-1">Stockable</label>
        //                 <div class="d-flex gap-2">
        //                     <div class="form-check form-check-inline">
        //                         <input class="form-check-input" type="radio" 
        //                               name="stockable-${index}" id="stockable-yes-${index}" value="Yes" checked>
        //                         <label class="form-check-label" for="stockable-yes-${index}"  style="font-size:11px">Yes</label>
        //                     </div>
        //                     <div class="form-check form-check-inline">
        //                         <input class="form-check-input" type="radio" 
        //                               name="stockable-${index}" id="stockable-no-${index}" value="No">
        //                         <label class="form-check-label" for="stockable-no-${index}" style="font-size:11px">No</label>
        //                     </div>
        //                 </div>
        //             </div>
        //             </td>
        //             <td><div class="d-flex gap-2"><div><label class="merged-cell-label">MFG Date</label><input type="date" class="form-control form-control-sm product-mfg" required></div><div><label class="merged-cell-label">EXP Date</label><input type="date" class="form-control form-control-sm product-exp" required></div></div><div class="shelf-life-display text-center small text-muted mt-1">---</div></td>
        //             <td>
        //                 <div class="input-group input-group-sm">
        //                     <input type="number" class="form-control quantity-ordered" required placeholder="Ordered"  step="any">
        //                     <input type="number" class="form-control quantity-received" required placeholder="Received"  step="any">
        //                     <select class="form-select quantity-unit" style="max-width: 65px;"><option>Kg</option><option>pcs</option></select>
        //                 </div>
        //                 <div class="discrepancy-display text-center"></div>
        //                 <div class="discrepancy-details-container d-none mt-2 p-2 bg-light rounded">
        //                     <div class="mb-2">
        //                         <label class="form-label mb-1 small fw-bold">Discrepancy Remarks:</label>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Damaged packaging" id="dr1-${index}"><label class="form-check-label" for="dr1-${index}">Damaged packaging</label></div>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Incorrect quantity" id="dr2-${index}"><label class="form-check-label" for="dr2-${index}">Incorrect quantity</label></div>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Expired product" id="dr3-${index}"><label class="form-check-label" for="dr3-${index}">Expired product</label></div>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Temperature abuse" id="dr4-${index}"><label class="form-check-label" for="dr4-${index}">Temperature abuse</label></div>
        //                         <div class="form-check small"><input class="form-check-input other-checkbox" type="checkbox" id="dr-other-${index}"><label class="form-check-label" for="dr-other-${index}">Other</label></div>
        //                         <input type="text" class="form-control form-control-sm mt-1 d-none other-text" placeholder="Please specify">
        //                     </div>
        //                     <hr class="my-2">
        //                      <div class="mb-1">
        //                         <label class="form-label mb-1 small fw-bold">Corrective Action Taken:</label>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Credit note to be issued" id="ca1-${index}"><label class="form-check-label" for="ca1-${index}">Credit note to be issued</label></div>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Full shipment returned" id="ca2-${index}"><label class="form-check-label" for="ca2-${index}">Full shipment returned</label></div>
        //                         <div class="form-check small"><input class="form-check-input" type="checkbox" value="Partial shipment returned" id="ca3-${index}"><label class="form-check-label" for="ca3-${index}">Partial shipment returned</label></div>
        //                         <div class="form-check small"><input class="form-check-input other-checkbox" type="checkbox" id="ca-other-${index}"><label class="form-check-label" for="ca-other-${index}">Other</label></div>
        //                         <input type="text" class="form-control form-control-sm mt-1 d-none other-text" placeholder="Please specify">
        //                     </div>
        //                 </div>
        //             </td>
        //             <td><div class="d-flex align-items-center"><div class="input-group input-group-sm"><input type="number" step="0.1" class="form-control product-temp" required placeholder="°C"><label class="input-group-text" for="temp-image-upload-${index}"><i class="fas fa-camera"></i></label><input class="d-none temp-image-upload" type="file" accept="image/*" id="temp-image-upload-${index}"></div><img class="temp-image-preview" id="temp-image-preview-${index}" src="#" alt="Preview"/><button type="button" class="btn btn-outline-secondary btn-sm view-temp-image-btn d-none ms-1" title="View Fullscreen"><i class="fas fa-expand"></i></button></div><div class="invalid-feedback d-block temp-validation-message small m-0"></div></td>
        //             <td><div class="input-group input-group-sm"><input class="form-control form-control-sm product-coa" type="file"><button type="button" class="btn btn-outline-secondary view-coa-btn" title="View COA" disabled><i class="fas fa-eye"></i></button></div></td>
        //         </tr>`;
        // }
          function getProductRowTemplate(index) {
            return `<tr class="product-entry-row">
                    <td><button type="button" class="btn btn-outline-danger btn-sm remove-product-btn" title="Delete Row"><i class="fas fa-trash"></i></button></td>
                    <td><select class="form-select-sm product-name" required placeholder="Select product..."></select><select class="form-select-sm product-brand mt-1" required placeholder="Select brand..."></select></td>
                     <td>
                        <label class="merged-cell-label">Batch #</label>
                        <input type="text" class="form-control form-control-sm product-batch" required>
                        
                    </td>

                    <td><label class="merged-cell-label">Storage Area</label><select class="form-select-sm storage-area-select" required placeholder="Select area..."></select>
                    
                    </td>
                    <td><div class="d-flex gap-2"><div><label class="merged-cell-label">MFG Date</label><input type="date" class="form-control form-control-sm product-mfg" required></div><div><label class="merged-cell-label">EXP Date</label><input type="date" class="form-control form-control-sm product-exp" required></div></div><div class="shelf-life-display text-center small text-muted mt-1">---</div></td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control quantity-ordered" required placeholder="Ordered"  step="any">
                            <input type="number" class="form-control quantity-received" required placeholder="Received"  step="any">
                            <select class="form-select quantity-unit" style="max-width: 65px;"><option>Kg</option><option>pcs</option></select>
                        </div>
                        <div class="discrepancy-display text-center"></div>
                        <div class="discrepancy-details-container d-none mt-2 p-2 bg-light rounded">
                            <div class="mb-2">
                                <label class="form-label mb-1 small fw-bold">Discrepancy Remarks:</label>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Damaged packaging" id="dr1-${index}"><label class="form-check-label" for="dr1-${index}">Damaged packaging</label></div>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Incorrect quantity" id="dr2-${index}"><label class="form-check-label" for="dr2-${index}">Incorrect quantity</label></div>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Expired product" id="dr3-${index}"><label class="form-check-label" for="dr3-${index}">Expired product</label></div>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Temperature abuse" id="dr4-${index}"><label class="form-check-label" for="dr4-${index}">Temperature abuse</label></div>
                                <div class="form-check small"><input class="form-check-input other-checkbox" type="checkbox" id="dr-other-${index}"><label class="form-check-label" for="dr-other-${index}">Other</label></div>
                                <input type="text" class="form-control form-control-sm mt-1 d-none other-text" placeholder="Please specify">
                            </div>
                            <hr class="my-2">
                             <div class="mb-1">
                                <label class="form-label mb-1 small fw-bold">Corrective Action Taken:</label>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Credit note to be issued" id="ca1-${index}"><label class="form-check-label" for="ca1-${index}">Credit note to be issued</label></div>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Full shipment returned" id="ca2-${index}"><label class="form-check-label" for="ca2-${index}">Full shipment returned</label></div>
                                <div class="form-check small"><input class="form-check-input" type="checkbox" value="Partial shipment returned" id="ca3-${index}"><label class="form-check-label" for="ca3-${index}">Partial shipment returned</label></div>
                                <div class="form-check small"><input class="form-check-input other-checkbox" type="checkbox" id="ca-other-${index}"><label class="form-check-label" for="ca-other-${index}">Other</label></div>
                                <input type="text" class="form-control form-control-sm mt-1 d-none other-text" placeholder="Please specify">
                            </div>
                        </div>
                    </td>
                    <td><div class="d-flex align-items-center"><div class="input-group input-group-sm"><input type="number" step="0.1" class="form-control product-temp" required placeholder="°C"><label class="input-group-text" for="temp-image-upload-${index}"><i class="fas fa-camera"></i></label><input class="d-none temp-image-upload" type="file" accept="image/*" id="temp-image-upload-${index}"></div><img class="temp-image-preview" id="temp-image-preview-${index}" src="#" alt="Preview"/><button type="button" class="btn btn-outline-secondary btn-sm view-temp-image-btn d-none ms-1" title="View Fullscreen"><i class="fas fa-expand"></i></button></div><div class="invalid-feedback d-block temp-validation-message small m-0"></div></td>
                    <td><div class="input-group input-group-sm"><input class="form-control form-control-sm product-coa" type="file"><button type="button" class="btn btn-outline-secondary view-coa-btn" title="View COA" disabled><i class="fas fa-eye"></i></button></div></td>
                </tr>`;
        }
        
        const productTbody = document.getElementById('product-entries-tbody');

        // function initializeTomSelectForRow(rowElement) {
        //     const productOptions = Object.keys(productDatabase).map(p => ({value: p, text: p}));
        //     const brandOptions = allBrands.map(b => ({value: b, text: b}));
        //     const storageOptions = storageLocations.map(s => ({value: s, text: s}));
            
        //     new TomSelect(rowElement.querySelector('.product-name'), { options: productOptions });
        //     new TomSelect(rowElement.querySelector('.product-brand'), { options: brandOptions });
        //     new TomSelect(rowElement.querySelector('.storage-area-select'), { options: storageOptions });
        // }
        
        function initializeTomSelectForRow(rowElement) {
            const productOptions = Object.keys(productDatabase).map(p => ({ value: p, text: p }));
        
            // Product select
            const productSelect = new TomSelect(rowElement.querySelector('.product-name'), { 
                options: productOptions 
            });
        
            const brandSelect = new TomSelect(rowElement.querySelector('.product-brand'), { 
                options: [] 
            });
        
            productSelect.on('change', (selectedProduct) => {
                const brandOptions = (productDatabase[selectedProduct] || []).map(b => ({
                    value: b, text: b
                }));
        
                brandSelect.clearOptions(); 
                brandSelect.addOptions(brandOptions); 
        
                if (brandOptions.length > 0) {
                    brandSelect.setValue(brandOptions[0].value);
                }
            });
        
            const storageOptions = storageLocations.map(s => ({ value: s, text: s }));
            new TomSelect(rowElement.querySelector('.storage-area-select'), { options: storageOptions });
        }


        function addFirstProductRow() { 
            productTbody.innerHTML = getProductRowTemplate(0); 
            const firstRow = productTbody.querySelector('.product-entry-row');
            firstRow.querySelector('.remove-product-btn')?.remove(); 
            initializeTomSelectForRow(firstRow);
        }

        // document.getElementById('addMoreProductBtn').addEventListener('click', function () { 
        //     const entryIndex = productTbody.querySelectorAll('.product-entry-row').length; 
        //     productTbody.insertAdjacentHTML('beforeend', getProductRowTemplate(entryIndex));
        //     const newRow = productTbody.lastElementChild;
        //     if(newRow) {
        //         initializeTomSelectForRow(newRow);
        //     }
        // });
        

        if (!window.productBtnListenerAdded) {
            document.getElementById('addMoreProductBtn').addEventListener('click', function () { 
                const entryIndex = productTbody.querySelectorAll('.product-entry-row').length; 
                productTbody.insertAdjacentHTML('beforeend', getProductRowTemplate(entryIndex));
        
                const newRow = productTbody.lastElementChild;
                if (newRow) {
                    initializeTomSelectForRow(newRow);
                }
            });
        
            window.productBtnListenerAdded = true;
        }


        productTbody.addEventListener('click', e => { if (e.target.closest('.remove-product-btn')) { e.target.closest('.product-entry-row').remove(); } if (e.target.closest('.view-coa-btn')) { const coaInput = e.target.closest('.input-group').querySelector('.product-coa'); if (coaInput.files && coaInput.files[0]) { window.open(URL.createObjectURL(coaInput.files[0]), '_blank'); } } if (e.target.closest('.view-temp-image-btn')) { const viewBtn = e.target.closest('.view-temp-image-btn'); if (viewBtn.dataset.url) { window.open(viewBtn.dataset.url, '_blank'); } } });
        function updateShelfLifeDisplay(row) { if (!row) return; const mfg = row.querySelector('.product-mfg').value; const exp = row.querySelector('.product-exp').value; const el = row.querySelector('.shelf-life-display'); if (mfg && exp) { const { days, percentage } = calculateShelfLife(mfg, exp); el.innerHTML = days < 0 ? `<span class="shelf-life-warning">EXPIRED</span>` : `<span class="${percentage < 25 ? 'shelf-life-warning' : 'shelf-life-ok'}">${days}d (${percentage.toFixed(0)}%)</span>`; } else { el.textContent = '---'; } }
        function updateDiscrepancyRowState(row) { if (!row) return; const container = row.querySelector('.discrepancy-details-container'); if (!container) return; const ordered = parseFloat(row.querySelector('.quantity-ordered').value) || 0; const received = parseFloat(row.querySelector('.quantity-received').value) || 0; const tempInput = row.querySelector('.product-temp'); const selectedOpt = row.querySelector('.product-name option:checked'); const validationEl = row.querySelector('.temp-validation-message'); const discrepancyEl = row.querySelector('.discrepancy-display'); const hasDiscrepancy = ordered > received && received >= 0; discrepancyEl.textContent = hasDiscrepancy ? `Discrepancy: ${(ordered - received).toFixed(2)}` : ''; let isTempInvalid = false; tempInput.classList.remove('is-invalid'); validationEl.textContent = ''; if (selectedOpt && selectedOpt.dataset.tempType !== 'ambient' && !tempInput.disabled) { const { min, max } = selectedOpt.dataset; const current = parseFloat(tempInput.value); if (!isNaN(current)) { let err = ''; if ('min' in selectedOpt.dataset && 'max' in selectedOpt.dataset && (current < parseFloat(min) || current > parseFloat(max))) err = `Must be ${min}°C - ${max}°C`; else if ('max' in selectedOpt.dataset && current > parseFloat(max)) err = `Must be below ${max}°C`; if (err) { isTempInvalid = true; tempInput.classList.add('is-invalid'); validationEl.textContent = err; } } } const showRow = hasDiscrepancy || isTempInvalid; container.classList.toggle('d-none', !showRow); if (!showRow) { container.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false); container.querySelectorAll('.other-text').forEach(input => { input.value = ''; input.classList.add('d-none'); }); } }
        productTbody.addEventListener('input', e => { const row = e.target.closest('.product-entry-row'); if (!row) return; if (e.target.matches('.product-name')) { const opt = e.target.options[e.target.selectedIndex]; const tempInput = row.querySelector('.product-temp'); const isAmbient = opt?.dataset.tempType === 'ambient'; tempInput.disabled = isAmbient; tempInput.required = !isAmbient; if(isAmbient) tempInput.value = ''; } if (e.target.matches('.quantity-ordered, .quantity-received, .product-temp, .product-name')) { updateDiscrepancyRowState(row); } if (e.target.matches('.product-mfg, .product-exp')) { updateShelfLifeDisplay(row); } if (e.target.matches('.temp-image-upload')) { const preview = row.querySelector('.temp-image-preview'); const viewBtn = row.querySelector('.view-temp-image-btn'); if (e.target.files && e.target.files[0]) { const url = URL.createObjectURL(e.target.files[0]); preview.src = url; preview.style.display = 'block'; viewBtn.dataset.url = url; viewBtn.classList.remove('d-none'); } else { preview.style.display = 'none'; viewBtn.classList.add('d-none'); } } if (e.target.matches('.product-coa')) { e.target.closest('.input-group').querySelector('.view-coa-btn').disabled = !(e.target.files && e.target.files[0]); } });
        productTbody.addEventListener('change', e => { if (e.target.classList.contains('other-checkbox')) { const textInput = e.target.closest('.form-check').nextElementSibling; if (textInput && textInput.classList.contains('other-text')) { textInput.classList.toggle('d-none', !e.target.checked); if (!e.target.checked) { textInput.value = ''; } } } });

        // MODAL AND FORM SUBMISSION LOGIC
        document.getElementById('vendorChecklistBtn').addEventListener('click', () => checklistModal.show());
        document.getElementById('confirmChecklistBtn').addEventListener('click', function() { checklistModal.hide(); document.getElementById('vendorChecklistBtn').classList.add('disabled', 'btn-outline-success'); document.getElementById('step1-vendor-details').classList.add('d-none'); document.getElementById('step2-receiving-register').classList.remove('d-none'); document.getElementById('saveRecordBtn').disabled = false; });
        
        
        // document.getElementById('saveRecordBtn').addEventListener('click', async (event) => { 
            
        //     event.preventDefault(); const form = document.getElementById('newRecordForm');
            
            
        //     let isTempImgValid = true; document.querySelectorAll('.is-invalid-label').forEach(el => el.classList.remove('is-invalid-label'));
            
        //     // for (const row of productTbody.querySelectorAll('.product-entry-row')) 
        //     // { 
        //     //     const upload = row.querySelector('.temp-image-upload'); 
        //     // if (upload.required && upload.files.length === 0)
            
        //     // { isTempImgValid = false; const label = row.querySelector(`label[for="${upload.id}"]`); if (label) label.classList.add('is-invalid-label'); } } 
        
        // // if (!form.checkValidity() || receiverSignPad.isEmpty() || !isTempImgValid) { form.classList.add('was-validated'); alert('Please fill all required fields, provide a signature, and upload required temperature images.'); return; }
        
        // const sharedData = { time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }), date: new Date().toISOString().split('T')[0], vendor: document.getElementById('vendorSelect').value, invoice: document.getElementById('invoiceNumberInput').value, receivedBy: 'John Doe', verified: false }; const filePromises = Array.from(productTbody.querySelectorAll('.product-entry-row')).map(row => { const fileInput = row.querySelector('.temp-image-upload'); return fileInput.files.length > 0 ? readFileAsDataURL(fileInput.files[0]) : Promise.resolve(null); }); const imageSources = await Promise.all(filePromises); productTbody.querySelectorAll('.product-entry-row').forEach((row, index) => { const discrepancyRadio = row.querySelector('.discrepancy-reason:checked'); let newRecord = { ...sharedData, id: Date.now() + index, rec: `REC-${Math.floor(10000 + Math.random() * 90000)}`, productName: row.querySelector('.product-name').value, brand: row.querySelector('.product-brand').value, batch: row.querySelector('.product-batch').value, storageArea: row.querySelector('.storage-area-select').value, mfg: row.querySelector('.product-mfg').value, exp: row.querySelector('.product-exp').value, ordered: row.querySelector('.quantity-ordered').value, received: row.querySelector('.quantity-received').value, temp: row.querySelector('.product-temp').disabled ? 'N/A' : row.querySelector('.product-temp').value, discrepancyReason: discrepancyRadio ? discrepancyRadio.value : '', rejectionRemarks: discrepancyRadio ? row.querySelector('.rejection-remarks').value : '', correctiveAction: row.querySelector('.discrepancy-details-container').classList.contains('d-none') ? '' : row.querySelector('.corrective-action-remarks').value, vendorEval: Math.floor(80 + Math.random() * 20), tempImageSrc: imageSources[index], attachments: { formE: document.getElementById('formEInput').files.length > 0, invoice: document.getElementById('invoiceInput').files.length > 0, coa: row.querySelector('.product-coa').files.length > 0 }, vehicleVideoUrl: '#' }; newRecord.status = getStatus(newRecord); allRecords.unshift(newRecord); }); applyFilters(); mainModal.hide();
        
            
        // });
        
        
    document.getElementById('saveRecordBtn').addEventListener('click', async (event) => {
    event.preventDefault();

    const form = document.getElementById('newRecordForm');
    const productTbody = document.getElementById('product-entries-tbody');

    // Basic form validation check
    // if (!form.checkValidity()) {
    //     form.classList.add('was-validated');
    //     alert('Please fill out all required fields.');
    //     return;
    // }

    const canvas = document.getElementById('userSignatureCanvas');
    const signatureDataURL = canvas.toDataURL('image/png');
    
    const formData = new FormData();

    const vendor = document.getElementById('vendorSelect')?.value || '';
    const poNumber = document.getElementById('poNumberInput')?.value || '';
    const invoiceNumber = document.getElementById('invoiceNumberInput')?.value || '';
    
    const invoiceFile = document.getElementById('invoiceInput')?.files[0];
    const formEFile = document.getElementById('formEInput')?.files[0];

    formData.append('vendor', vendor);
    formData.append('po_number', poNumber);
    formData.append('invoice_number', invoiceNumber);
    
    formData.append('user_signature', signatureDataURL);


    if (invoiceFile) {
        formData.append('invoice_file', invoiceFile);
    }
    if (formEFile) {
        formData.append('form_e_file', formEFile);
    }
    
    
    
    //check list
    const checklistItems = [];
    const checklistModal = document.getElementById('vendorEvaluationChecklistModal'); 
    if (checklistModal) {
        checklistModal.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
            const itemText = checkbox.closest('tr').querySelector('td').textContent.trim();
            checklistItems.push(itemText);
        });
    }

    // Convert the array to a comma-separated string and append it
    const vendorChecklist = checklistItems.join(', ');
    formData.append('vendor_evaluation_checklist', vendorChecklist);



    const productsData = [];
    const productRows = productTbody.querySelectorAll('.product-entry-row');

    productRows.forEach((row, index) => {
        // Use optional chaining to safely access values from elements
        const product = row.querySelector('.product-name')?.value || '';
        const brand = row.querySelector('.product-brand')?.value || '';
        const batch = row.querySelector('.product-batch')?.value || '';
        const storageArea = row.querySelector('.storage-area-select')?.value || '';
        const mfgDate = row.querySelector('.product-mfg')?.value || '';
        const expDate = row.querySelector('.product-exp')?.value || '';
        const orderedQty = row.querySelector('.quantity-ordered')?.value || '';
        const receivedQty = row.querySelector('.quantity-received')?.value || '';
        const qtyType = row.querySelector('.quantity-unit')?.value || '';
        const temperature = row.querySelector('.product-temp')?.value || '';
        
        
        const shelfLifeElement = row.querySelector('.shelf-life-ok');
        const shelfLife = shelfLifeElement ? shelfLifeElement.textContent.trim() : null;
        
        
    
        const discrepancyRemarksContainer = $(row).find('div > label:contains("Discrepancy Remarks:")').parent()[0];
        const correctiveActionContainer = $(row).find('div > label:contains("Corrective Action Taken:")').parent()[0];
        
        // Your existing logic to find and push values
        const discrepancyRemarks = [];
        if (discrepancyRemarksContainer) {
            $(discrepancyRemarksContainer).find('input.form-check-input:checked').each(function() {
                if ($(this).hasClass('other-checkbox')) {
                    const otherText = $(this).closest('.form-check').next('.other-text').val() || '';
                    if (otherText) discrepancyRemarks.push(otherText);
                } else {
                    discrepancyRemarks.push($(this).val());
                }
            });
        }


        const correctiveAction = [];
        if (correctiveActionContainer) {
            $(correctiveActionContainer).find('input.form-check-input:checked').each(function() {
                if ($(this).hasClass('other-checkbox')) {
                    const otherText = $(this).closest('.form-check').next('.other-text').val() || '';
                    if (otherText) correctiveAction.push(otherText);
                } else {
                    correctiveAction.push($(this).val());
                }
            });
        }

    
        let discrepancyValue = null;
           const discrepancyDisplayElement = row.querySelector('.discrepancy-display') || null;
        if (discrepancyDisplayElement) {
            const textContent = discrepancyDisplayElement.textContent;
            const match = textContent.match(/Discrepancy: (\d+)/);
            if (match) {
                discrepancyValue = parseInt(match[1]); // Parse the number as an integer
            }
        }
        

        productsData.push({
            product: product,
            brand: brand,
            batch: batch,
            storage_area: storageArea,
            mfg_date: mfgDate,
            exp_date: expDate,
            order_qty: orderedQty,
            receive_qty: receivedQty,
            qty_type: qtyType,
            temperature: temperature,
            discrepancy_remarks: discrepancyRemarks,
            corrective_action: correctiveAction,
            shelf_life_display: shelfLife,
              discrepancy_value: discrepancyValue,
        });

        // Append files from product row
        
        const tempImageFile = row.querySelector('.temp-image-upload')?.files[0];
        const coaFile = row.querySelector('.product-coa')?.files[0];
        
        if (tempImageFile) {
            formData.append(`temperature_image_${index}`, tempImageFile);
        }
        if (coaFile) {
            formData.append(`attachment_coa_${index}`, coaFile);
        }
        
        // if (tempImageFile) {
        //     formData.append('temperature_image', tempImageFile);
        // }
        // if (coaFile) {
        //     formData.append('attachment_coa', coaFile);
        // }
    });

    // Append the entire products array as a JSON string
    formData.append('products_data', JSON.stringify(productsData));

    
    // E. Collect and append finalization data
    const generalRemarks = document.getElementById('generalRemarks')?.value || '';
    let receiverSignature = null;
    if (typeof receiverSignPad !== 'undefined' && !receiverSignPad.isEmpty()) {
        receiverSignature = receiverSignPad.toDataURL();
    }
    formData.append('general_remarks', generalRemarks);
    // formData.append('receiver_signature', receiverSignature);
    
    // Correctly get the "Received By" value using its ID
    const receivedByInput = document.getElementById('received_by');
    const receivedBy = receivedByInput?.value || '';
    formData.append('received_by', receivedBy);
    

    formData.append('general_remarks', generalRemarks);
    formData.append('receiver_signature', receiverSignature);
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', csrfToken);
    
    // E. Send data using $.ajax()
    $.ajax({
        url: "{{route('store.receiving.record')}}",
        method: 'POST',
        data: formData,
        contentType: false, // Prevents jQuery from setting the Content-Type header
        processData: false, // Prevents jQuery from processing the data
        success: function(response) {
            toastr.success('Record saved successfully!');
            setTimeout(()=>{
                location.reload()
            },2000)
            const mainModal = bootstrap.Modal.getInstance(document.getElementById('addNewRecordModal'));
            if (mainModal) {
                mainModal.hide();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
             toastr.error('Failed to save record. Please try again.');
        }
    });
});
        
        
    
        tableBody.addEventListener('click', function(e) { if (e.target.classList.contains('verify-btn')) { const recordId = parseInt(e.target.closest('tr').dataset.id, 10); alert(recordId); verificationMode = 'single'; verificationTargetIds = [recordId]; verifierSignPad.clear(); verificationModal.show(); } const toggleBtn = e.target.closest('.toggle-details-btn'); if (toggleBtn) { e.preventDefault(); const details = toggleBtn.closest('.report-container').querySelector('.collapsible-details'); if (details) { const isHidden = details.style.display === 'none'; details.style.display = isHidden ? 'block' : 'none'; toggleBtn.textContent = isHidden ? 'Hide Full Report' : 'Show Full Report'; } } const checklistBtn = e.target.closest('.view-checklist-btn'); if (checklistBtn) { const recordId = parseInt(checklistBtn.dataset.id, 10); const record = allRecords.find(r => r.id === recordId); if (record) { populateVendorReportModal(record); viewVendorReportModal.show(); } } });
        tableBody.addEventListener('change', function(e) { if (e.target.classList.contains('row-checkbox')) { updateVerifyButtonState(); } });
        document.getElementById('verifySelectedBtn').addEventListener('click', function() { const selectedIds = getSelectedRecordIds(); alert(selectedIds); if (selectedIds.length > 0) { verificationMode = 'batch'; verificationTargetIds = selectedIds; verifierSignPad.clear(); verificationModal.show(); } });
        document.getElementById('confirmVerificationBtn').addEventListener('click', function() { if (verifierSignPad.isEmpty()) { alert('A signature is required to verify.'); return; } allRecords = allRecords.map(record => { if (verificationTargetIds.includes(record.id)) { record.verified = true; } return record; }); verificationModal.hide(); applyFilters(); });
        
        // --- BULK UPLOAD & SAMPLE CSV ---
        document.getElementById('downloadSampleCsvBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const header = "ProductName,BrandName,BatchNumber,StorageArea,MfgDate(YYYY-MM-DD),ExpDate(YYYY-MM-DD),QtyOrdered,QtyReceived,Unit,Temperature,DiscrepancyReason,DiscrepancyRemarks,CorrectiveAction";
            const example1 = "Organic Tomatoes,OrganiFarms,T-451,Dry Store A,2025-09-06,2025-09-13,50,50,Kg,N/A,,,,";
            const example2 = "Milk,DairyBest,M-209-B,Chiller Room 1,2025-09-05,2025-09-12,100,90,L,4.5,Shortfall,2 crates damaged.,Credit note to be issued.";
            const example3 = "Milk,OrganiFarms,M-210-C,Chiller Room 1,2025-09-05,2025-09-12,50,50,L,4.1,,,,"; // Mismatched Example
            const example4 = "Frozen Chicken Nuggets,GoldenBites,G-555-A,Freezer A-1,2025-08-10,2026-08-10,200,180,Kg,-19,Shortfall,1 box open.,Credit note to be issued.";
            const csvContent = [header, example1, example2, example3, example4].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url); link.setAttribute("download", "product_upload_sample.csv");
            document.body.appendChild(link); link.click(); document.body.removeChild(link);
        });
        
        document.getElementById('bulkUploadInput').addEventListener('change', function(e) {
            const file = e.target.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = function(event) {
                csvReviewData = { matched: [], mismatched: [] };
                const text = event.target.result.replace(/\r/g, ""); // Remove carriage returns
                const rows = text.split('\n').filter(row => row.trim() !== '');
                if (rows.length <= 1) { alert('CSV file is empty or contains only a header.'); return; }
                rows.slice(1).forEach((rowStr, index) => {
                    const cols = rowStr.split(',').map(c => c.trim());
                    if (cols.length < 9) return;
                    const rowData = { productName: cols[0] || '', brandName: cols[1] || '', batch: cols[2] || '', storageArea: cols[3] || '', mfgDate: cols[4] || '', expDate: cols[5] || '', qtyOrdered: cols[6] || '', qtyReceived: cols[7] || '', unit: cols[8] || 'Kg', temp: cols[9] || '', discrepancyReason: cols[10] || '', discrepancyRemarks: cols[11] || '', correctiveAction: cols[12] || '', originalIndex: index };
                    const isValid = productDatabase[rowData.productName] && productDatabase[rowData.productName].includes(rowData.brandName);
                    if (isValid) { csvReviewData.matched.push(rowData); } else { csvReviewData.mismatched.push(rowData); }
                });
                if (csvReviewData.mismatched.length > 0) { 
                    populateMatcherModal(); 
                    dataMatcherModal.show(); 
                } 
                else { 
                    processAndAddProducts(csvReviewData.matched); 
                }
            };
            reader.readAsText(file);
            e.target.value = ''; // Reset for re-uploading
        });
        
        // --- DATA MATCHER MODAL LOGIC ---
        function populateMatcherModal() {
            const tbody = document.getElementById('mismatched-items-tbody');
            tbody.innerHTML = '';
            const productOptions = Object.keys(productDatabase).map(p => `<option value="${p}">${p}</option>`).join('');
            csvReviewData.mismatched.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.dataset.originalIndex = item.originalIndex;
                const bestGuessProduct = Object.keys(productDatabase).find(p => p.toLowerCase().includes(item.productName.toLowerCase())) || Object.keys(productDatabase)[0];
                
                // const brandOptions = productDatabase[bestGuessProduct].map(b => `<option value="${b}">${b}</option>`).join('');
                
                const brandOptions = (productDatabase[bestGuessProduct] || [])
    .map(b => `<option value="${b}">${b}</option>`).join('');

                
                tr.innerHTML = `
                    <td class="text-center"><input class="form-check-input row-matcher-checkbox" type="checkbox"></td>
                    <td><span class="mismatch-tag">${item.productName || '<i>(empty)</i>'}</span></td>
                    <td><span class="mismatch-tag">${item.brandName || '<i>(empty)</i>'}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm corrected-product">${productOptions}</select>
                            <select class="form-select form-select-sm corrected-brand">${brandOptions}</select>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-success accept-item-btn"><i class="fas fa-check"></i> Accept</button>
                            <button type="button" class="btn btn-danger reject-item-btn"><i class="fas fa-times"></i> Reject</button>
                        </div>
                    </td>
                `;
                tr.querySelector('.corrected-product').value = bestGuessProduct;
                tbody.appendChild(tr);
            });
        }
        
        dataMatcherModalEl.addEventListener('change', e => {
            if (e.target.classList.contains('corrected-product')) {
                const brandSelect = e.target.closest('tr').querySelector('.corrected-brand');
                const selectedProduct = e.target.value;
                brandSelect.innerHTML = productDatabase[selectedProduct].map(b => `<option value="${b}">${b}</option>`).join('');
            }
        });
        
        document.getElementById('selectAllMatcherCheckbox').addEventListener('change', function(e) {
            document.querySelectorAll('.row-matcher-checkbox').forEach(cb => cb.checked = e.target.checked);
        });
        
        document.getElementById('mismatched-items-tbody').addEventListener('click', e => {
            const row = e.target.closest('tr');
            if (!row) return;
            if (e.target.closest('.accept-item-btn')) {
                const correctedProduct = row.querySelector('.corrected-product').value;
                const correctedBrand = row.querySelector('.corrected-brand').value;
                const originalIndex = parseInt(row.dataset.originalIndex);
                const itemToMove = csvReviewData.mismatched.find(item => item.originalIndex === originalIndex);
                if (itemToMove) {
                    itemToMove.productName = correctedProduct;
                    itemToMove.brandName = correctedBrand;
                    csvReviewData.matched.push(itemToMove);
                    csvReviewData.mismatched = csvReviewData.mismatched.filter(item => item.originalIndex !== originalIndex);
                }
                row.remove();
            } else if (e.target.closest('.reject-item-btn')) {
                const originalIndex = parseInt(row.dataset.originalIndex);
                csvReviewData.mismatched = csvReviewData.mismatched.filter(item => item.originalIndex !== originalIndex);
                row.remove();
            }
        });
        
        document.getElementById('rejectSelectedMatcherBtn').addEventListener('click', function() {
            const rows = document.querySelectorAll('#mismatched-items-tbody tr');
            rows.forEach(row => {
                if (row.querySelector('.row-matcher-checkbox:checked')) {
                    const originalIndex = parseInt(row.dataset.originalIndex);
                    csvReviewData.mismatched = csvReviewData.mismatched.filter(item => item.originalIndex !== originalIndex);
                    row.remove();
                }
            });
        });
        
        document.getElementById('confirmMatcherBtn').addEventListener('click', function() {
            const rows = document.querySelectorAll('#mismatched-items-tbody tr');
            rows.forEach(row => {
                const correctedProduct = row.querySelector('.corrected-product').value;
                const correctedBrand = row.querySelector('.corrected-brand').value;
                const originalIndex = parseInt(row.dataset.originalIndex);
                const itemToMove = csvReviewData.mismatched.find(item => item.originalIndex === originalIndex);
                if (itemToMove) {
                    itemToMove.productName = correctedProduct;
                    itemToMove.brandName = correctedBrand;
                    csvReviewData.matched.push(itemToMove);
                }
            });
            csvReviewData.mismatched = []; // Clear mismatches as all have been processed
            dataMatcherModal.hide();
            processAndAddProducts(csvReviewData.matched);
            csvReviewData.matched = []; // Clear matched after processing
        });
        
        function processAndAddProducts(products) {
            if (products.length === 0) return;
            const firstEmptyRow = productTbody.querySelector('.product-name:invalid');
            if (firstEmptyRow) {
                firstEmptyRow.closest('.product-entry-row').remove();
            }

            products.forEach(item => {
                const entryIndex = productTbody.querySelectorAll('.product-entry-row').length;
                productTbody.insertAdjacentHTML('beforeend', getProductRowTemplate(entryIndex));
                const newRow = productTbody.lastElementChild;
                if (newRow) {
                    initializeTomSelectForRow(newRow);
                    newRow.querySelector('.product-name').tomselect.setValue(item.productName);
                    newRow.querySelector('.product-brand').tomselect.setValue(item.brandName);
                    newRow.querySelector('.storage-area-select').tomselect.setValue(item.storageArea);
                    newRow.querySelector('.product-batch').value = item.batch;
                    newRow.querySelector('.product-mfg').value = item.mfgDate;
                    newRow.querySelector('.product-exp').value = item.expDate;
                    newRow.querySelector('.quantity-ordered').value = item.qtyOrdered;
                    newRow.querySelector('.quantity-received').value = item.qtyReceived;
                    newRow.querySelector('.quantity-unit').value = item.unit;
                    newRow.querySelector('.product-temp').value = item.temp === 'N/A' ? '' : item.temp;
                    if (item.temp === 'N/A') {
                       newRow.querySelector('.product-temp').disabled = true;
                       newRow.querySelector('.product-temp').required = false;
                    }
                    if (item.discrepancyReason) {
                        const reasonRadio = newRow.querySelector(`.discrepancy-reason[value="${item.discrepancyReason}"]`);
                        if (reasonRadio) reasonRadio.checked = true;
                        newRow.querySelector('.rejection-remarks').value = item.discrepancyRemarks;
                        newRow.querySelector('.corrective-action-remarks').value = item.correctiveAction;
                    }
                    updateShelfLifeDisplay(newRow);
                    updateDiscrepancyRowState(newRow);
                }
            });
        }
        
        function populateVendorReportModal(record) {
            const body = document.getElementById('vendorReportBody');
            const score = record.vendorEval;
            const getStatusBadge = (check) => check ? `<span class="badge bg-success">Pass</span>` : `<span class="badge bg-danger">Fail</span>`;
            
            // Simulate checklist results based on score
            const checks = {
                vehicle: score >= 80,
                temp: score >= 85,
                packaging: score >= 75,
                hygiene: score >= 90
            };

            body.innerHTML = `
                <p><strong>Vendor:</strong> ${record.vendor}</p>
                <ul class="list-group">
                  <li class="list-group-item d-flex justify-content-between align-items-center">Vehicle Condition ${getStatusBadge(checks.vehicle)}</li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Temperature Control ${getStatusBadge(checks.temp)}</li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Packaging Integrity ${getStatusBadge(checks.packaging)}</li>
                  <li class="list-group-item d-flex justify-content-between align-items-center">Driver Hygiene ${getStatusBadge(checks.hygiene)}</li>
                </ul>
                <div class="text-center mt-3">
                    <h5 class="mb-0">Overall Score: <strong>${score}%</strong></h5>
                </div>
            `;
        }


        // =================================================================
        // =========== FILTERING LOGIC (DESKTOP & MOBILE) ==================
        // =================================================================
        // const filterContentHTML = `<div id="filter-content-wrapper"><h6>Filter by Receiving</h6><div class="mb-2"><label class="form-label small">Receiving Date</label>
        // <input type="date" id="filterDateFrom" class="form-control form-control-sm"><input type="date" id="filterDateTo" class="form-control form-control-sm mt-1">
        // </div><div class="mb-2"><label class="form-label small">Invoice Number</label><input type="text" id="filterInvoiceNo" class="form-control form-control-sm"></div>
        // <div class="mb-2"><label class="form-label small">Receiving Report No.</label><input type="text" id="filterRecNo" class="form-control form-control-sm"></div>
        // <div class="mb-3"><label class="form-label small">Status</label><select id="filterStatus" class="form-select form-select-sm">
        // <option value="" selected>Any</option><option value="Approved">Approved</option><option value="Partial">Partial</option><option value="Rejected">Rejected</option></select>
        // </div><h6>Filter by Supplier/Material</h6><div class="mb-2"><label class="form-label small">Product Name</label>
        // <select class="filterProductName11" id="filterProductName" placeholder="Select a product..."></select></div><div class="mb-2">
        // <label class="form-label small">Vendor Name</label><select id="filterVendorName" style="width: 191px;" class="filterVendorName12" placeholder="Select a vendor...">
        // </select></div><div class="mb-2"><label class="form-label small">Batch Number</label><input type="text" id="filterBatchNo" class="form-control form-control-sm">
        // </div><div class="mb-2"><label class="form-label small">Manufacturing Date</label><input type="date" id="filterMfgFrom" class="form-control form-control-sm">
        // <input type="date" id="filterMfgTo" class="form-control form-control-sm mt-1"></div><div class="mb-2"><label class="form-label small">Expiry Date</label>
        // <input type="date" id="filterExpFrom" class="form-control form-control-sm"><input type="date" id="filterExpTo" class="form-control form-control-sm mt-1">
        // </div><div class="mb-3"><label class="form-label small">Balance Shelf Life</label><div class="input-group input-group-sm"><select class="form-select" style="max-width: 65px;" id="filterShelfLifeOp">
        // <option value="gte" selected="">&gt;=</option><option value="lte">&lt;=</option><option value="eq">==</option></select><input type="number" class="form-control" id="filterShelfLifeVal" placeholder="%">
        // </div></div><h6>Filter by Quantity</h6><div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyAny" value="" checked><label class="form-check-label" for="qtyAny">Any</label>
        // </div><div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyRejected" value="Rejected"><label class="form-check-label" for="qtyRejected">Rejected</label></div>
        // <div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyShort" value="Short Supply"><label class="form-check-label" for="qtyShort">Short Supply</label></div>
        // <div class="form-check mb-3"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyActual" value="Actual"><label class="form-check-label" for="qtyActual">Actual</label></div>
        // <h6>Filter by Quality</h6><div class="mb-2"><label class="form-label small">Compliance</label><select id="filterCompliance" class="form-select form-select-sm"><option value="" selected>Any</option>
        // <option value="Compliance">Compliance</option><option value="Non-Compliance">Non-Compliance</option></select></div><div class="mb-3"><label class="form-label small">Temperature Range (°C)</label>
        // <div class="d-flex gap-2"><input type="number" id="filterTempFrom" class="form-control form-control-sm" placeholder="From"><input type="number" id="filterTempTo" class="form-control form-control-sm" placeholder="To">
        // </div></div><h6>Filter by Score</h6><div class="mb-3"><label class="form-label small">Score %</label><div class="d-flex gap-2">
        // <input type="number" id="filterScoreFrom" class="form-control form-control-sm" placeholder="From"><input type="number" id="filterScoreTo" class="form-control form-control-sm" placeholder="To"></div></div><h6>
        // Filter by Action</h6><div class="form-check"><input class="form-check-input" type="radio" name="caFilter" id="caAny" value="" checked><label class="form-check-label" for="caAny">Any</label>
        // </div><div class="form-check"><input class="form-check-input" type="radio" name="caFilter" id="caYes" value="yes"><label class="form-check-label" for="caYes">Yes</label></div><div class="form-check mb-3">
        // <input class="form-check-input" type="radio" name="caFilter" id="caNo" value="no"><label class="form-check-label" for="caNo">No</label></div><h6>Filter by Attachments</h6><div class="mb-2">
        // <label class="form-label small fw-bold">Attached</label><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="formE" data-status="attached" id="attFormE">
        // <label class="form-check-label" for="attFormE">Form E</label></div><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="invoice" data-status="attached" id="attInvoice">
        // <label class="form-check-label" for="attInvoice">Invoice</label></div><div class="form-check"><input class="form-check-input attachment-filter" data-type="coa" data-status="attached" type="checkbox" id="attCOA">
        // <label class="form-check-label" for="attCOA">COA</label></div></div><div class="mb-2"><label class="form-label small fw-bold">Missing</label>
        // <div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="formE" data-status="missing" id="misFormE">
        // <label class="form-check-label" for="misFormE">Form E</label></div><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="invoice" data-status="missing" id="misInvoice">
        // <label class="form-check-label" for="misInvoice">Invoice</label></div><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="coa" data-status="missing" id="misCOA">
        // <label class="form-check-label" for="misCOA">COA</label></div></div><div><button type="submit" class="btn btn-primary btn-sm me-2">Submit</button>
        // <button type="reset" class="btn btn-secondary btn-sm">Clear</button>
        // </div></div>`;

        // const filterContentHTML = `
        // <form id="filterForm">
        //   <div id="filter-content-wrapper" style="padding: 16px; background-color: #f9f9f9; border-radius: 6px; border: 1px solid #ccc;">
        
        //     <h6 class="mb-3">Filter by Receiving</h6>
        
        //     <!-- Receiving Dates -->
        //     <div class="mb-3">
        //       <label class="form-label small">Receiving Date</label>
        //       <input type="date" id="filterDateFrom" class="form-control form-control-sm mb-1">
        //       <input type="date" id="filterDateTo" class="form-control form-control-sm">
        //     </div>
        
        //     <!-- Invoice Number -->
        //     <div class="mb-3">
        //       <label class="form-label small">Invoice Number</label>
        //       <input type="text" id="filterInvoiceNo" class="form-control form-control-sm">
        //     </div>
        
        //     <!-- Receiving Report No. -->
        //     <div class="mb-3">
        //       <label class="form-label small">Receiving Report No.</label>
        //       <input type="text" id="filterRecNo" class="form-control form-control-sm">
        //     </div>
        
        //     <!-- Status -->
        //     <div class="mb-4">
        //       <label class="form-label small">Status</label>
        //       <select id="filterStatus" class="form-select form-select-sm">
        //         <option value="" selected>Any</option>
        //         <option value="Approved">Approved</option>
        //         <option value="Partial">Partial</option>
        //         <option value="Rejected">Rejected</option>
        //       </select>
        //     </div>
        
        //     <h6 class="mb-3">Filter by Supplier/Material</h6>
        
        //     <!-- Product Name -->
        //     <div class="mb-3">
        //       <label class="form-label small">Product Name</label>
        //       <select id="filterProductName" class="form-select form-select-sm filterProductName11" placeholder="Select a product...">
        //         <option value="">Select a product...</option>
        //         <!-- Options will be populated dynamically -->
        //       </select>
        //     </div>
        
        //     <!-- Vendor Name -->
        //     <div class="mb-3">
        //       <label class="form-label small">Vendor Name</label>
        //       <select id="filterVendorName" class="form-select form-select-sm filterVendorName12" placeholder="Select a vendor..." style="width: 100%;">
        //         <option value="">Select a vendor...</option>
        //         <!-- Options will be populated dynamically -->
        //       </select>
        //     </div>
        
        //     <!-- Action Buttons -->
        //     <div class="mt-4">
        //       <button type="submit" class="btn btn-primary btn-sm me-2">Submit</button>
        //       <button type="reset" class="btn btn-secondary btn-sm">Clear</button>
        //     </div>
        //   </div>
        // </form>`;

        const filterContentHTML = `
        <form id="filterForm" class="filterForm">
          <div id="filter-content-wrapper" class="filter-content-wrapper" 
               style="padding: 16px; background-color: #f9f9f9; border-radius: 6px; border: 1px solid #ccc;">
          
            <h6 class="mb-3">Filter by Receiving</h6>
        
            <!-- Receiving Dates -->
            <div class="mb-3">
              <label class="form-label small">Receiving Date</label>
              <input type="date" id="filterDateFrom" class="form-control form-control-sm mb-1 filterDateFrom">
              <input type="date" id="filterDateTo" class="form-control form-control-sm filterDateTo">
            </div>
        
            <!-- Invoice Number -->
            <div class="mb-3">
              <label class="form-label small">Invoice Number</label>
              <input type="text" id="filterInvoiceNo" class="form-control form-control-sm filterInvoiceNo">
            </div>
        
            <!-- Receiving Report No. -->
            <div class="mb-3">
              <label class="form-label small">Receiving Report No.</label>
              <input type="text" id="filterRecNo" class="form-control form-control-sm filterRecNo">
            </div>
        
            <!-- Status -->
            <div class="mb-4">
              <label class="form-label small">Status</label>
              <select id="filterStatus" class="form-select form-select-sm filterStatus">
                <option value="" selected>Any</option>
                <option value="Approved">Approved</option>
                <option value="Partial">Partial</option>
                <option value="Rejected">Rejected</option>
              </select>
            </div>
        
            <h6 class="mb-3">Filter by Supplier/Material</h6>
        
            <!-- Product Name -->
            <div class="mb-3">
              <label class="form-label small">Product Name</label>
              <select id="filterProductName" 
                      class="form-select form-select-sm filterProductName filterProductName11" 
                      placeholder="Select a product...">
                <option value="">Select a product...</option>
              </select>
            </div>
        
            <!-- Vendor Name -->
            <div class="mb-3">
              <label class="form-label small">Vendor Name</label>
              <select id="filterVendorName" 
                      class="form-select form-select-sm filterVendorName filterVendorName12" 
                      placeholder="Select a vendor..." style="width: 100%;">
                <option value="">Select a vendor...</option>
              </select>
            </div>
        
            <!-- Action Buttons -->
            <div class="mt-4">
              <button type="submit" class="btn btn-primary btn-sm me-2 filterSubmitBtn">Submit</button>
              <button 
              type="reset" 
              class="btn btn-secondary btn-sm filterClearBtn" 
              onclick="setTimeout(() => loadRecords({}), 10)">
              Clear
            </button>
            </div>
          </div>
        </form>`;


        function setupFilterUI() {
            document.querySelectorAll('.dropdown-menu[data-filter-group-content]').forEach(dd => { dd.innerHTML = filterContentHTML; });
            document.getElementById('filterAccordion').innerHTML = filterContentHTML;
        }

        function areFiltersActive() {
             if (document.getElementById('globalSearchInput').value) return true;
             if (document.getElementById('filterDateFrom').value || document.getElementById('filterDateTo').value) return true;
             if (document.getElementById('filterInvoiceNo').value) return true;
             if (document.getElementById('filterRecNo').value) return true;
             if (document.getElementById('filterStatus').value) return true;
             if (tomSelectInstances['#filterProductName'] && tomSelectInstances['#filterProductName'].getValue() != '') return true;
             if (tomSelectInstances['#filterVendorName'] && tomSelectInstances['#filterVendorName'].getValue() != '') return true;
             if (document.getElementById('filterBatchNo').value) return true;
             if (document.querySelector('input[name="qtyFilter"]:checked')?.value) return true;
             if (document.querySelector('input[name="caFilter"]:checked')?.value) return true;
             if (document.querySelectorAll('.attachment-filter:checked').length > 0) return true;
             return false;
        }

        function updateFilterIndicators() {
            const isActive = areFiltersActive();
            document.querySelectorAll('a[data-filter-group]').forEach(toggle => { toggle.classList.toggle('filter-active', isActive); });
            const mobileBtn = document.getElementById('mobileFilterBtn');
            if(mobileBtn) { mobileBtn.classList.toggle('btn-primary', isActive); mobileBtn.classList.toggle('btn-outline-primary', !isActive); }
        }

        function resetAllFilters() {
            document.getElementById('globalSearchInput').value = '';
            const filterWrappers = document.querySelectorAll('#filterAccordion, .dropdown-menu');
            filterWrappers.forEach(wrapper => {
                wrapper.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]').forEach(input => input.value = '');
                wrapper.querySelectorAll('select').forEach(select => { if (select.tomselect) select.tomselect.clear(); else select.selectedIndex = 0; });
                wrapper.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = radio.id.includes('Any'));
                wrapper.querySelectorAll('input[type="checkbox"]').forEach(check => check.checked = false);
            });
            applyFilters();
        }

        document.getElementById('refreshBtn').addEventListener('click', resetAllFilters);
        document.getElementById('clearAllFiltersBtn').addEventListener('click', resetAllFilters);
        document.getElementById('applyAllFiltersBtn').addEventListener('click', applyFilters);
        document.querySelectorAll('.apply-filter-btn').forEach(btn => btn.addEventListener('click', applyFilters));
        document.getElementById('globalSearchInput').addEventListener('input', applyFilters);


        function applyFilters() {
            const filters = { 
                globalSearch: document.getElementById('globalSearchInput').value.toLowerCase().trim(),
                dateFrom: document.getElementById('filterDateFrom').value, dateTo: document.getElementById('filterDateTo').value, 
                invoiceNo: document.getElementById('filterInvoiceNo').value.toLowerCase(), 
                recNo: document.getElementById('filterRecNo').value.toLowerCase(), 
                status: document.getElementById('filterStatus').value, 
                productName: tomSelectInstances['#filterProductName']?.getValue(), 
                vendorName: tomSelectInstances['#filterVendorName']?.getValue(), 
                batchNo: document.getElementById('filterBatchNo').value.toLowerCase(), mfgFrom: document.getElementById('filterMfgFrom').value, mfgTo: document.getElementById('filterMfgTo').value, expFrom: document.getElementById('filterExpFrom').value, expTo: document.getElementById('filterExpTo').value, shelfLifeOp: document.getElementById('filterShelfLifeOp').value, shelfLifeVal: document.getElementById('filterShelfLifeVal').value, qty: document.querySelector('input[name="qtyFilter"]:checked').value, compliance: document.getElementById('filterCompliance').value, tempFrom: document.getElementById('filterTempFrom').value, tempTo: document.getElementById('filterTempTo').value, scoreFrom: document.getElementById('filterScoreFrom').value, scoreTo: document.getElementById('filterScoreTo').value, correctiveAction: document.querySelector('input[name="caFilter"]:checked').value, attachments: Array.from(document.querySelectorAll('.attachment-filter:checked')).map(el => ({ type: el.dataset.type, status: el.dataset.status })) };
            
            displayedRecords = allRecords.filter(rec => { 
                if (filters.globalSearch) {
                    const term = filters.globalSearch;
                    const isFound = rec.rec.toLowerCase().includes(term) || rec.invoice.toLowerCase().includes(term) || rec.vendor.toLowerCase().includes(term) || rec.productName.toLowerCase().includes(term) || rec.batch.toLowerCase().includes(term);
                    if (!isFound) return false;
                }
                if (filters.dateFrom && rec.date < filters.dateFrom) return false; if (filters.dateTo && rec.date > filters.dateTo) return false; if (filters.invoiceNo && !rec.invoice.toLowerCase().includes(filters.invoiceNo)) return false; if (filters.recNo && !rec.rec.toLowerCase().includes(filters.recNo)) return false; if (filters.status && rec.status !== filters.status) return false; if (filters.productName && rec.productName !== filters.productName) return false; if (filters.vendorName && rec.vendor !== filters.vendorName) return false; if (filters.batchNo && !rec.batch.toLowerCase().includes(filters.batchNo)) return false; if (filters.mfgFrom && rec.mfg < filters.mfgFrom) return false; if (filters.mfgTo && rec.mfg > filters.mfgTo) return false; if (filters.expFrom && rec.exp < filters.expFrom) return false; if (filters.expTo && rec.exp > filters.expTo) return false; if(filters.shelfLifeVal) { const shelfLife = calculateShelfLife(rec.mfg, rec.exp).percentage; const val = parseFloat(filters.shelfLifeVal); if (filters.shelfLifeOp === 'gte' && shelfLife < val) return false; if (filters.shelfLifeOp === 'lte' && shelfLife > val) return false; if (filters.shelfLifeOp === 'eq' && Math.floor(shelfLife) !== Math.floor(val)) return false; } if (filters.qty) { const ordered = parseFloat(rec.ordered); const received = parseFloat(rec.received); if (filters.qty === 'Rejected' && (received !== 0 || ordered === 0)) return false; if (filters.qty === 'Short Supply' && (received >= ordered || received === 0)) return false; if (filters.qty === 'Actual' && received !== ordered) return false; } if (filters.tempFrom && (rec.temp === 'N/A' || parseFloat(rec.temp) < parseFloat(filters.tempFrom))) return false; if (filters.tempTo && (rec.temp === 'N/A' || parseFloat(rec.temp) > parseFloat(filters.tempTo))) return false; if (filters.scoreFrom && rec.vendorEval < parseFloat(filters.scoreFrom)) return false; if (filters.scoreTo && rec.vendorEval > parseFloat(filters.scoreTo)) return false; if (filters.correctiveAction) { const hasAction = rec.correctiveAction && rec.correctiveAction.trim() !== '-'; if (filters.correctiveAction === 'yes' && !hasAction) return false; if (filters.correctiveAction === 'no' && hasAction) return false; } if (filters.attachments.length > 0) { for(const att of filters.attachments) { const hasAttachment = rec.attachments[att.type]; if (att.status === 'attached' && !hasAttachment) return false; if (att.status === 'missing' && hasAttachment) return false; } } return true; });
            paginationState.currentPage = 1; renderTable(); updateFilterIndicators();
        }
        
        // --- INITIAL LOAD ---
        loadInitialData();
        // initTomSelect(
        //     '#vendorSelect',
        //     vendorsData.map(v => ({ value: v.name, text: v.name })),
        //     'Search for a vendor...'
        // );
        

        // document.addEventListener("submit", function (e) {
        //   if (e.target.classList.contains("filterForm")) {
        //     e.preventDefault();
        
        //     const form = e.target;
        //     const filters = {
        //       dateFrom: form.querySelector(".filterDateFrom")?.value || "",
        //       dateTo: form.querySelector(".filterDateTo")?.value || "",
        //       invoiceNo: form.querySelector(".filterInvoiceNo")?.value || "",
        //       reportNo: form.querySelector(".filterRecNo")?.value || "",
        //       status: form.querySelector(".filterStatus")?.value || "",
        //       vendor: form.querySelector(".filterVendorName")?.value || "",
        //       product: form.querySelector(".filterProductName")?.value || "",
        //     };
        
        //     // console.log("Submitted filters:", filters);
        //     // alert(JSON.stringify(filters, null, 2));
        //     loadRecords(filters);
        //   }
        // });
        
        
        // document.addEventListener("submit", function (e) {
        //   if (e.target.classList.contains("filterForm")) {
        //     e.preventDefault();
        //     console.log("Form submitted");
        
        //     const form = e.target;
        //     const filters = {
        //       dateFrom: form.querySelector(".filterDateFrom")?.value || "",
        //       dateTo: form.querySelector(".filterDateTo")?.value || "",
        //       invoiceNo: form.querySelector(".filterInvoiceNo")?.value || "",
        //       reportNo: form.querySelector(".filterRecNo")?.value || "",
        //       status: form.querySelector(".filterStatus")?.value || "",
        //       vendor: form.querySelector(".filterVendorName")?.value || "",
        //       product: form.querySelector(".filterProductName")?.value || "",
        //     };
        
        //     console.log("Filters:", filters);
        
        //     loadRecords(filters);
        // event.stopPropagation();
        //     form.style.display = "none"; 
        //   }
        // });
        
        document.addEventListener("submit", function (e) {
              if (e.target.classList.contains("filterForm")) {
                e.preventDefault();
                console.log("Form submitted");
            
                const form = e.target;
                const filters = {
                  dateFrom: form.querySelector(".filterDateFrom")?.value || "",
                  dateTo: form.querySelector(".filterDateTo")?.value || "",
                  invoiceNo: form.querySelector(".filterInvoiceNo")?.value || "",
                  reportNo: form.querySelector(".filterRecNo")?.value || "",
                  status: form.querySelector(".filterStatus")?.value || "",
                  vendor: form.querySelector(".filterVendorName")?.value || "",
                  product: form.querySelector(".filterProductName")?.value || "",
                };
            
                loadRecords(filters);
                event.stopPropagation();
            
                form.classList.add('d-none');
                const dropdown = form.closest('.dropdown-menu');
                if (dropdown) {
                  const dropdownInstance = bootstrap.Dropdown.getInstance(
                    dropdown.previousElementSibling
                  );
                  if (dropdownInstance) dropdownInstance.hide();
                }
              }
        });


        document.addEventListener('click', function(e) {
          if (e.target.classList.contains('filterClearBtn')) {
            e.preventDefault(); 
        
            const form = e.target.closest('form');
            if (form) {
              form.reset();
            }
        
            loadRecords({});
          }
        });
    }
    // });
    </script>
    

</body>
</html>