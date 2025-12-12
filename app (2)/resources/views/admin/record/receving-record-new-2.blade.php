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
        
        /* HIDE TOP RIBBON ON ALL VIEWS */
        .navbar.sticky-top {
            display: none;
        }

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
            gap: 25px;
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

        @media screen and (max-width: 991.98px) {
            .header-actions .btn-label { display: none; }
            .table thead { display: none; }
            .table tr, .table td { display: block; width: 100%; }
            .table > tbody > tr > td { padding: 0; border: none; }
            .table > tbody > tr { margin-bottom: 1rem; border: none; box-shadow: none; background-color: transparent; }
        }

        #receivingRegisterTable th { font-weight: 500; white-space: nowrap; }
        #receivingRegisterTable .form-control, #receivingRegisterTable .form-select, #receivingRegisterTable .btn { font-size: 0.85rem; }
        #receivingRegisterTable td { padding: 0.5rem; }
        #receivingRegisterTable .form-control-sm { padding: 0.25rem 0.5rem; }
        #receivingRegisterTable th:first-child, #receivingRegisterTable td:first-child { width: 45px; text-align: center; }
        
        .merged-cell-label { font-size: 0.75rem; color: var(--color-text-secondary); margin-bottom: 0.2rem; }
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

    </style>
</head>
<body class="bg-light">

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#"><div class="bg-primary text-white p-2 rounded me-2"><i class="fas fa-utensils"></i></div><span class="fw-bold fs-4">FoodSafe</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex ms-auto my-2 my-lg-0"><div class="input-group"><span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fas fa-search"></i></span><input class="form-control border-start-0" type="search" placeholder="Search records..."></div></form>
                <ul class="navbar-nav ms-lg-3"><li class="nav-item dropdown"><a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"><div class="avatar bg-primary text-white rounded-circle me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">JS</div><div><div class="fw-bold">Jane Smith</div><div class="small text-muted">Quality Manager</div></div></a><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="#">Profile</a></li><li><a class="dropdown-item" href="#">Settings</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item" href="#">Logout</a></li></ul></li></ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid p-3 p-md-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div><h1 class="h3 mb-1">Receiving Records</h1></div>
            <div class="header-actions d-flex gap-2">
                 <button class="btn btn-warning d-none" id="verifySelectedBtn"><i class="fas fa-check-double me-1"></i><span class="btn-label"> Verify Selected</span></button>
                 <button class="btn btn-info" id="downloadPdfBtn"><i class="fas fa-file-pdf me-1"></i><span class="btn-label"> Download PDF</span></button>
                 <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt me-1"></i><span class="btn-label"> Refresh</span></button>
                 <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewRecordModal"><i class="fas fa-plus me-1"></i><span class="btn-label"> New Record</span></button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
             <div class="card-body p-0 p-lg-2">
                <div class="table-responsive">
                    <table class="table" id="recordsTable">
                        <thead class="bg-light">
                             <tr>
                                <th>
                                    Receiving / Invoice No. <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" style="width: 280px;">
                                        <h6>Filter by Receiving</h6>
                                        <div class="mb-2">
                                            <label class="form-label small">Receiving Date</label>
                                            <input type="date" id="filterDateFrom" class="form-control form-control-sm" placeholder="From">
                                            <input type="date" id="filterDateTo" class="form-control form-control-sm mt-1" placeholder="To">
                                        </div>
                                        <div class="mb-2"><label class="form-label small">Invoice Number</label><input type="text" id="filterInvoiceNo" class="form-control form-control-sm"></div>
                                        <div class="mb-2"><label class="form-label small">Receiving Report No.</label><input type="text" id="filterRecNo" class="form-control form-control-sm"></div>
                                        <div><label class="form-label small">Status</label><select id="filterStatus" class="form-select form-select-sm"><option value="" selected>Any</option><option value="Approved">Approved</option><option value="Partial">Partial</option><option value="Rejected">Rejected</option></select></div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
                                </th>
                                <th>
                                    Supplier & Material Details <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" style="width: 320px;">
                                        <h6>Filter by Supplier/Material</h6>
                                        <div class="mb-2"><label class="form-label small">Product Name</label><select id="filterProductName" placeholder="Select a product..."></select></div>
                                        <div class="mb-2"><label class="form-label small">Vendor Name</label><select id="filterVendorName" placeholder="Select a vendor..."></select></div>
                                        <div class="mb-2"><label class="form-label small">Batch Number</label><input type="text" id="filterBatchNo" class="form-control form-control-sm"></div>
                                        <div class="mb-2"><label class="form-label small">Manufacturing Date</label><input type="date" id="filterMfgFrom" class="form-control form-control-sm" placeholder="From"><input type="date" id="filterMfgTo" class="form-control form-control-sm mt-1" placeholder="To"></div>
                                        <div class="mb-2"><label class="form-label small">Expiry Date</label><input type="date" id="filterExpFrom" class="form-control form-control-sm" placeholder="From"><input type="date" id="filterExpTo" class="form-control form-control-sm mt-1" placeholder="To"></div>
                                        <div class="mb-2">
                                            <label class="form-label small">Balance Shelf Life</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-select" style="max-width: 65px;" id="filterShelfLifeOp">
                                                    <option value="gte" selected="">&gt;=</option>
                                                    <option value="lte">&lt;=</option>
                                                    <option value="eq">==</option>
                                                </select>
                                                <input type="number" class="form-control" id="filterShelfLifeVal" placeholder="%">
                                            </div>
                                        </div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
                                </th>
                                <th>
                                    Quantity <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();">
                                        <h6>Filter by Quantity</h6>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyAny" value="" checked><label class="form-check-label" for="qtyAny">Any</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyRejected" value="Rejected"><label class="form-check-label" for="qtyRejected">Rejected</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyShort" value="Short Supply"><label class="form-check-label" for="qtyShort">Short Supply</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="qtyFilter" id="qtyActual" value="Actual"><label class="form-check-label" for="qtyActual">Actual</label></div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
                                </th>
                                <th>
                                    Quality Checks <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();">
                                        <h6>Filter by Quality</h6>
                                        <div class="mb-2"><label class="form-label small">Compliance</label><select id="filterCompliance" class="form-select form-select-sm"><option value="" selected>Any</option><option value="Compliance">Compliance</option><option value="Non-Compliance">Non-Compliance</option></select></div>
                                        <div class="mb-2"><label class="form-label small">Temperature Range (Â°C)</label><div class="d-flex gap-2"><input type="number" id="filterTempFrom" class="form-control form-control-sm" placeholder="From"><input type="number" id="filterTempTo" class="form-control form-control-sm" placeholder="To"></div></div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
                                </th>
                                <th>
                                    Vendor Eval. <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();">
                                        <h6>Filter by Score</h6>
                                        <div class="mb-2"><label class="form-label small">Score %</label><div class="d-flex gap-2"><input type="number" id="filterScoreFrom" class="form-control form-control-sm" placeholder="From"><input type="number" id="filterScoreTo" class="form-control form-control-sm" placeholder="To"></div></div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
                                </th>
                                <th>Received By</th>
                                <th>
                                    Corrective Action <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();">
                                        <h6>Filter by Action</h6>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="caFilter" id="caAny" value="" checked><label class="form-check-label" for="caAny">Any</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="caFilter" id="caYes" value="yes"><label class="form-check-label" for="caYes">Yes</label></div>
                                        <div class="form-check"><input class="form-check-input" type="radio" name="caFilter" id="caNo" value="no"><label class="form-check-label" for="caNo">No</label></div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
                                </th>
                                <th>Verified By</th>
                                <th>
                                    Attachments <a href="#" class="ms-1 text-secondary" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-filter"></i></a>
                                    <div class="dropdown-menu p-3" onclick="event.stopPropagation();" style="width: 250px;">
                                        <h6>Filter by Attachments</h6>
                                        <div class="mb-2"><label class="form-label small fw-bold">Attached</label><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="formE" data-status="attached" id="attFormE"><label class="form-check-label" for="attFormE">Form E</label></div><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="invoice" data-status="attached" id="attInvoice"><label class="form-check-label" for="attInvoice">Invoice</label></div><div class="form-check"><input class="form-check-input attachment-filter" data-type="coa" data-status="attached" type="checkbox" id="attCOA"><label class="form-check-label" for="attCOA">COA</label></div></div>
                                        <div class="mb-2"><label class="form-label small fw-bold">Missing</label><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="formE" data-status="missing" id="misFormE"><label class="form-check-label" for="misFormE">Form E</label></div><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="invoice" data-status="missing" id="misInvoice"><label class="form-check-label" for="misInvoice">Invoice</label></div><div class="form-check"><input class="form-check-input attachment-filter" type="checkbox" data-type="coa" data-status="missing" id="misCOA"><label class="form-check-label" for="misCOA">COA</label></div></div>
                                        <hr><div class="d-flex gap-2"><button class="btn btn-secondary btn-sm flex-grow-1 clear-filter-btn">Clear</button><button class="btn btn-primary btn-sm flex-grow-1 apply-filter-btn">Apply</button></div>
                                    </div>
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
                        <!-- =========== REDESIGNED STEP 1 START =========== -->
                        <div id="step1-vendor-details">
                            <h5 class="mb-3 fw-bold">Step 1: Vendor & Shipment Details</h5>
                            <div class="row g-4">
                                <!-- Left Column: Shipment Information -->
                                <div class="col-lg-6">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipment Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Vendor <span class="text-danger">*</span></label>
                                                <select id="vendorSelect" required placeholder="Search for a vendor..."></select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">PO Number</label>
                                                 <div class="position-relative">
                                                    <i class="fas fa-hashtag input-group-icon"></i>
                                                    <input type="text" class="form-control form-control-icon" id="poNumberInput" placeholder="Enter Purchase Order number">
                                                 </div>
                                            </div>
                                            <div>
                                                <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <i class="fas fa-file-invoice input-group-icon"></i>
                                                    <input type="text" class="form-control form-control-icon" id="invoiceNumberInput" placeholder="Enter invoice number" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Right Column: Required Documents -->
                                <div class="col-lg-6">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="mb-0"><i class="fas fa-folder-open me-2 text-primary"></i>Required Documents</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Upload Invoice <span class="text-danger">*</span></label>
                                                <!--<input class="form-control" type="file" id="invoiceInput" required>-->
                                                <input class="form-control" type="file" id="invoiceInput">

                                                <div class="form-text">Please attach the vendor's official invoice document.</div>
                                            </div>
                                            <div>
                                                <label class="form-label">Upload Form E <span class="text-danger">*</span></label>
                                                <input class="form-control" type="file" id="formEInput">

                                                <!--<input class="form-control" type="file" id="formEInput" required>-->
                                                <div class="form-text">Ensure the Form E document is clear and complete.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-success" id="vendorChecklistBtn"><i class="fas fa-check-square me-1"></i> Complete Checklist & Proceed</button>
                            </div>
                        </div>
                        <!-- =========== REDESIGNED STEP 1 END =========== -->

                        <div id="step2-receiving-register" class="d-none">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 fw-bold">Step 2: Receiving Register</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <label for="bulkUploadInput" class="btn btn-secondary btn-sm mb-0"><i class="fas fa-upload me-1"></i> Bulk Upload CSV</label>
                                    <input type="file" id="bulkUploadInput" class="d-none" accept=".csv">
                                    <a href="#" id="downloadSampleCsvBtn" class="btn btn-outline-info btn-sm"><i class="fas fa-download me-1"></i> Sample CSV</a>
                                </div>
                            </div>
                            <div id="bulk-upload-review-alert" class="alert alert-warning d-none" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><strong>Review Required:</strong> One or more items from your bulk upload could not be matched. Please correct the highlighted rows before saving.
                            </div>
                            <div class="table-responsive">
                                <table id="receivingRegisterTable" class="table table-bordered align-middle bg-white">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Action</th>
                                            <th>Product / Brand</th>
                                            <th>Batch #</th>
                                            <th>Dates & Shelf Life</th>
                                            <th>Quantities</th>
                                            <th>Temperature</th>
                                            <th>Attachments (COA)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-entries-tbody"></tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" id="addMoreProductBtn"><i class="fas fa-plus"></i> Add Another Product</button>
                            
                            <!-- =========== REDESIGNED FINALIZATION SECTION START =========== -->
                            <div class="card mt-4 shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="fas fa-pen-alt me-2 text-primary"></i>Finalization</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- General Remarks -->
                                        <div class="col-lg-5">
                                             <div class="form-floating h-100">
                                                <textarea id="generalRemarks" class="form-control" placeholder="Leave a comment here" style="min-height: 125px;"></textarea>
                                                <label for="generalRemarks">General Remarks (Optional)</label>
                                            </div>
                                        </div>
                                        <!-- Received By -->
                                        <div class="col-lg-3">
                                            <label class="form-label">Received By</label>
                                            <div class="position-relative">
                                                <i class="fas fa-user input-group-icon"></i>
                                                <input type="text" class="form-control form-control-icon" id="received_by" value="{{$name}}" readonly>
                                            </div>
                                        </div>
                                        <!-- Signature -->
                                        <div class="col-lg-4"  style="display:none">
                                            <label class="form-label">Signature <span class="text-danger">*</span></label>
                                            <div class="border rounded p-1 bg-white">
                                                <canvas id="receiverSignPad" class="signature-pad-canvas"></canvas>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clearReceiverSign">
                                                <i class="fas fa-eraser me-1"></i>Clear
                                            </button>
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
                                    </div>
                                </div>
                            </div>
                            <!-- =========== REDESIGNED FINALIZATION SECTION END =========== -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveRecordBtn" disabled>Save Record</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Data Matcher Modal -->
    <div class="modal fade" id="dataMatcherModal" tabindex="-1" aria-labelledby="dataMatcherModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataMatcherModalLabel"><i class="fas fa-tasks me-2"></i>Review Bulk Upload</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Review items that couldn't be matched to our database. You can accept items individually, or correct and accept all remaining items in bulk.</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;" class="text-center"><input class="form-check-input" type="checkbox" id="selectAllMatcherCheckbox" title="Select All"></th>
                                    <th style="width: 20%;">Product in CSV</th>
                                    <th style="width: 20%;">Brand in CSV</th>
                                    <th style="width: 35%;">Corrected Value (Select to fix)</th>
                                    <th style="width: 20%;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="mismatched-items-tbody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-danger" id="rejectSelectedMatcherBtn"><i class="fas fa-trash-alt me-1"></i> Reject Selected</button>
                    <button type="button" class="btn btn-primary" id="confirmMatcherBtn"><i class="fas fa-check-double me-1"></i> Accept All Remaining</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Modals -->
    <div class="modal fade" id="vendorChecklistModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Vendor Evaluation Checklist</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Ensure all checks are satisfactory.</p><table class="table table-bordered"><tbody><tr><td>Vehicle Condition</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c1"></div></td></tr><tr><td>Temperature Control</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c2"></div></td></tr><tr><td>Packaging Integrity</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c3"></div></td></tr><tr><td>Driver Hygiene</td><td class="text-center"><div class="form-check"><input class="form-check-input" type="checkbox" id="c4"></div></td></tr></tbody></table></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmChecklistBtn">Confirm & Proceed</button></div></div></div></div>
    <!--<div class="modal fade" id="verificationModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Confirm Verification</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label for="verificationComments" class="form-label">Comments (Optional)</label><textarea class="form-control" id="verificationComments" rows="2"></textarea></div><div class="mb-3"><label class="form-label">Signature</label><div class="border rounded p-1"><canvas id="verifierSignPad" class="signature-pad-canvas"></canvas></div><button type="button" class="btn btn-sm btn-outline-secondary mt-1" id="clearVerifierSign">Clear</button></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmVerificationBtn" disabled>Confirm Verification</button></div></div></div></div>-->
    
    <div class="modal fade" id="verificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Confirm Verification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label for="verificationComments" class="form-label">Comments (Optional)</label>
          <textarea class="form-control" id="verificationComments" rows="2"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Signature</label>
          <div class="border rounded p-1">
            <canvas id="verifierSignPad" style="width:100%;height:150px;"></canvas>
          </div>

          <!-- âœ… Signature Clear Button -->
          <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clearVerifierSign">
            Clear
          </button>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        
        <!-- âœ… Submit (Confirm Verification) -->
        <button type="button" class="btn btn-primary" id="confirmVerificationBtn">
          Confirm Verification
        </button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editRowModal" tabindex="-1" aria-labelledby="editRowModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editRowForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editRowModalLabel">Edit Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
              <div class="mb-3">
            <label for="editBatch" class="form-label">Batch</label>
            <input type="text" class="form-control" id="editBatch" name="batch" required>
          </div>
          
          
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
             <input type="datetime-local" class="form-control" id="editReceivedDate"step="1" required>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
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
    // function formatForDatetimeLocal(input) {
    //     const d = new Date(input);
    //     if (isNaN(d.getTime())) return ""; 
    //     return d.toISOString().slice(0, 16); 
    // }

        const editModal = new bootstrap.Modal(document.getElementById('editRowModal'));
        let editingRowId = null;
        
        document.addEventListener('click', function(e) {
          if(e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            editingRowId = btn.dataset.id;
            
            
            document.getElementById('editBatch').value = btn.dataset.batch || '';
            document.getElementById('editMfg').value = btn.dataset.mfg || '';
            document.getElementById('editExp').value = btn.dataset.exp || '';
            document.getElementById('editOrdered').value = btn.dataset.ordered || '';
            document.getElementById('editReceived').value = btn.dataset.received || '';
            // document.getElementById('editReceivedDate').value = formatForDatetimeLocal(btn.dataset.receivingdate) || '';
              document.getElementById('editReceivedDate').value = btn.dataset.receivingdate || '';
            
    
        
            editModal.show();
          }
        });

        document.getElementById('editRowForm').addEventListener('submit', function(e) {
          e.preventDefault();
        
          const batch = document.getElementById('editBatch').value;
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
              batch: batch,
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
        
        
        
        let vendorProductDatabase = null;

        $('#vendorSelect').on('change', function () {
            const vendorName = $(this).val();
        
            $.ajax({
                url: "{{ route('get.product.basis.on.vendor') }}",
                type: "POST",
                data: {
                    name: vendorName,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    vendorProductDatabase = response.data;  
                    loadRecords();   
                }
            });
        });

        


// async function loadRecords(filters = {}) {
//     try {
//          const queryString = new URLSearchParams(filters).toString();
//             const url = "get-receiving-records-data-new";
//             const res = await fetch(url);
//             const data = await res.json();

//         // ðŸ‘‡ LOGIC FIXED
//         let finalProductDatabase =
//             vendorProductDatabase !== null  // if vendor selected â†’ use vendor DB
//                 ? vendorProductDatabase
//                 : data.productDatabase;      // else â†’ use main DB

//         if (data.success) {
//             initApps(
//                 finalProductDatabase,
//                 data.vendors,
//                 data.formattedRecords
//             );
//         } else {
//             initApps({}, [], []);
//         }
//     } catch (err) {
//         initApps({}, [], []);
//     }
// }
        
        

    async function loadRecords(filters = {}) {
      try {
        // const queryString = new URLSearchParams(filters).toString();
        // const url = queryString
        //   ? `get-receiving-records-data?${queryString}`
        //   : "get-receiving-records-data";
            const queryString = new URLSearchParams(filters).toString();
            const url = "get-receiving-records-data-new";
            const res = await fetch(url);
            const data = await res.json();
            
            
            let finalProductDatabase =
            vendorProductDatabase !== null  // if vendor selected â†’ use vendor DB
                ? vendorProductDatabase
                : data.productDatabase;      // else â†’ use main DB
        
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


    // document.addEventListener('DOMContentLoaded', function () {
      function initApps(productDetails, vendorsData, dataMain){
        let allRecords = [];
        let displayedRecords = [];
        let paginationState = { currentPage: 1, rowsPerPage: 10 };
        let verificationMode = 'single';
        let verificationTargetIds = []; // Can hold one or many IDs
        let csvReviewData = { matched: [], mismatched: [] };
        let tomSelectInstances = {};

        // --- SIMULATED PRODUCT DATABASE ---
        // const productDatabase = {
        //     "Milk": ["DairyBest"],
        //     "Yogurt": ["DairyBest"],
        //     "Frozen Peas": ["OrganiFarms"],
        //     "Organic Tomatoes": ["OrganiFarms", "Fresh Produce Inc."],
        //     "Beef Tenderloin": ["Quality Meats Ltd."]
        // };
         let productDatabase = productDetails;
        
        
        const allBrands = [...new Set(Object.values(productDatabase).flat())];

        const mainModalEl = document.getElementById('addNewRecordModal');
        const verificationModalEl = document.getElementById('verificationModal');
        const dataMatcherModalEl = document.getElementById('dataMatcherModal');
        const mainModal = new bootstrap.Modal(mainModalEl);
        const checklistModal = new bootstrap.Modal(document.getElementById('vendorChecklistModal'));
        const verificationModal = new bootstrap.Modal(verificationModalEl);
        const dataMatcherModal = new bootstrap.Modal(dataMatcherModalEl);
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
                // if (button) button.disabled = true;
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
            console.log("check kro data",dataMain)
            // allRecords = [
            //     { id: 3, rec: 'REC-08903', date: '2025-09-07', time: '11:45 AM', invoice: 'INV-QM-441', vendor: 'Quality Meats Ltd.', productName: 'Beef Tenderloin', brand: 'Quality Meats Ltd.', batch: 'M-517-C', mfg: '2025-09-04', exp: '2025-09-11', ordered: 25, received: 0, temp: 9, discrepancyReason: 'Rejected', rejectionRemarks: 'Temp. high & low shelf life.', correctiveAction: 'Full shipment returned.', receivedBy: 'Michael Brown', vendorEval: 85, verified: true, tempImageSrc: 'https://placehold.co/80x30/fee2e2/dc2626?text=9%C2%B0C', vehicleVideoUrl: '#', attachments: { formE: true, invoice: true, coa: false } },
            //     { id: 2, rec: 'REC-08902', date: '2025-09-07', time: '09:30 AM', invoice: 'INV-DB-112', vendor: 'DairyBest', productName: 'Milk', brand: 'DairyBest', batch: 'M-209-B', mfg: '2025-09-05', exp: '2025-09-12', ordered: 100, received: 90, temp: 4, discrepancyReason: 'Shortfall', rejectionRemarks: '2 crates damaged.', correctiveAction: 'Credit note to be issued.', receivedBy: 'John Doe', vendorEval: 92, verified: false, tempImageSrc: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAABaCAYAAACVz3NMAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAYdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjEuNWRHWFIAAAKnSURBVHhe7d3BbdhAEAbgejcrgUagBKzgrEaACqQEWkI3sBOkBVpBOnB2Yv+TdCU3SOMzcgSRf2737c3lxd3e3d2P+/0+37e3t/fT09PTM27b9v2Yc3NeHh4efr5v255+P/7x8fHpdh4G2Jfh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4eHh4-AAAAAAElFTkSuQmCC', vehicleVideoUrl: '#', attachments: { formE: true, invoice: true, coa: true } },
            //     { id: 1, rec: 'REC-08901', date: '2025-09-07', time: '08:15 AM', invoice: 'INV-FP-556', vendor: 'Fresh Produce Inc.', productName: 'Organic Tomatoes', brand: 'Fresh Produce Inc.', batch: 'T-451', mfg: '2025-09-06', exp: '2025-09-13', ordered: 50, received: 50, temp: 'N/A', rejectionRemarks: '', correctiveAction: '-', receivedBy: 'John Doe', vendorEval: 98, verified: true, tempImageSrc: null, vehicleVideoUrl: null, attachments: { formE: true, invoice: true, coa: false } },
            // ].map(rec => ({...rec, status: getStatus(rec)})); // Add status to each record
            
             allRecords = dataMain;
             
            displayedRecords = [...allRecords];
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
        //     html += `<li class="page-item ${paginationState.currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${paginationState.currentPage - 1}">Â«</a></li>`;
        //     let pages = [];
        //     if (totalPages <= 7) { for (let i = 1; i <= totalPages; i++) pages.push(i); } else {
        //         pages.push(1); if (paginationState.currentPage > 3) pages.push('...');
        //         for (let i = Math.max(2, paginationState.currentPage - 1); i <= Math.min(totalPages - 1, paginationState.currentPage + 1); i++) pages.push(i);
        //         if (paginationState.currentPage < totalPages - 2) pages.push('...'); pages.push(totalPages);
        //     }
        //     pages.forEach(page => { if (page === '...') { html += `<li class="page-item disabled"><span class="page-link">...</span></li>`; } else { html += `<li class="page-item ${page === paginationState.currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${page}">${page}</a></li>`; } });
        //     html += `<li class="page-item ${paginationState.currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${paginationState.currentPage + 1}">Â»</a></li>`;
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
                        <a class="page-link" href="#" data-page="${paginationState.currentPage - 1}">Â«</a>
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
                        <a class="page-link" href="#" data-page="${paginationState.currentPage + 1}">Â»</a>
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

        function initTomSelect(selector, options, placeholder) { 
             if (tomSelectInstances[selector]) {
                tomSelectInstances[selector].destroy();
             }
             tomSelectInstances[selector] = new TomSelect(selector, { 
                create: false, 
                sortField: { field: "text", direction: "asc" },
                options: options,
                placeholder: placeholder,
                allowEmptyOption: true,
                render: {
                    option: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    item: function(data, escape) {
                        return '<div>' + escape(data.text) + '</div>';
                    }
                }
            }); 
        }

        function populateFilterDropdowns() {
          const uniqueVendors = [...new Set(allRecords.map(r => r.vendor))].map(v => ({value: v, text: v}));
          const uniqueVendors2 = [...new Map(vendorsData.map(v => [v.name, v])).values()]
            .map(v => ({ value: v.name, text: v.name }));
          const uniqueProducts = [...new Set(allRecords.map(r => r.productName))].map(p => ({value: p, text: p}));
            //  const uniqueProducts = [];

            //   Object.entries(productDatabase).forEach(([productName, brands]) => {
            //     if (brands && brands.length > 0) {
            //       brands.forEach(brand => {
            //         uniqueProducts.push({
            //           value: `${productName} - ${brand}`,
            //           text: `${productName} - ${brand}`,
            //         });
            //       });
            //     } else {
            //       uniqueProducts.push({
            //         value: productName,
            //         text: productName,
            //       });
            //     }
            //   });
            initTomSelect('#filterVendorName', uniqueVendors, 'Select a vendor...');
            initTomSelect('#filterProductName', uniqueProducts, 'Select a product...');
            initTomSelect('#vendorSelect', uniqueVendors2, 'Search for a vendor...');
        }
        
        // function renderAttachmentsCell(attachments) {
        //     if (!attachments) {
        //         return `
        //             <div class="small text-muted">Form E: N/A</div>
        //             <div class="small text-muted mt-1">Invoice: N/A</div>
        //             <div class="small text-muted mt-1">COA: N/A</div>
        //         `;
        //     }
        //     const createAttachmentLine = (label, hasAttachment, type) => {
        //         const status = hasAttachment
        //             ? `<span class="badge bg-success">Attached</span> <a href="#" class="ms-2 view-attachment-link" title="View ${label}" data-type="${type}"><i class="fas fa-eye"></i></a>`
        //             : `<span class="badge bg-secondary">Missing</span>`;
        //         return `<div class="d-flex justify-content-between align-items-center"><span>${label}:</span><span>${status}</span></div>`;
        //     };

        //     const formEHtml = createAttachmentLine('Form E', attachments.formE, 'form-e');
        //     const invoiceHtml = createAttachmentLine('Invoice', attachments.invoice, 'invoice');
        //     const coaHtml = createAttachmentLine('COA', attachments.coa, 'coa');

        //     return `<div class="d-grid gap-1 small">${formEHtml}${invoiceHtml}${coaHtml}</div>`;
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


        function createTableRowElement(data) {
            console.log("data.received",data.received);
              console.log("data.check kro",data);
            console.log("data.ordered",data.ordered);
            const tr = document.createElement('tr');
            tr.dataset.id = data.id;

            // const received = parseFloat(data.received);
            // const ordered = parseFloat(data.ordered);
                const received = data.received;
            const ordered = data.ordered;
            const shelfLife = calculateShelfLife(data.mfg, data.exp);
            const discrepancyQty = ordered - received;
            // const verifiedByName = 'Jane Smith';
           const verifiedByName = data.verified ? data.verified_com : 'Jane Smith';


            let statusBadge;
            if (data.status === 'Rejected') {
                statusBadge = `<span class="badge bg-danger-subtle text-danger-emphasis rounded-pill mt-1"><i class="fas fa-times-circle me-1"></i>Rejected</span>`;
            } else if (data.status === 'Partial') {
                statusBadge = `<span class="badge bg-warning-subtle text-warning-emphasis rounded-pill mt-1"><i class="fas fa-exclamation-circle me-1"></i>Partial</span>`;
            } else {
                statusBadge = `<span class="badge bg-success-subtle text-success-emphasis rounded-pill mt-1"><i class="fas fa-check-circle me-1"></i>Approved</span>`;
            }
            
            let shelfLifeHTML = '';
            if (shelfLife.days >= 0 && shelfLife.percentage >= 0) {
                const colorClass = shelfLife.percentage < 25 ? 'shelf-life-warning' : 'shelf-life-ok';
                shelfLifeHTML = `<div class="small mt-1"><strong class="text-muted">Shelf Life:</strong> <span class="${colorClass}">${shelfLife.days} days (${shelfLife.percentage.toFixed(0)}%)</span></div>`;
            }

            let qtyHTML = `<div class="small"><span class="text-muted">Ordered:</span> ${ordered}</div><div class="small"><span class="text-muted">Accepted:</span> ${received}</div>`;
            if (discrepancyQty > 0) qtyHTML += `<div class="small text-danger fw-bold"><span class="text-muted">${data.discrepancyReason}:</span> ${discrepancyQty}</div>`;
            if (data.rejectionRemarks) qtyHTML += `<div class="small text-danger fst-italic">Reason: ${data.rejectionRemarks}</div>`;

            // const qualityHTML = (data.temp === 'N/A') ? `<div><div class="fw-bold mb-1">N/A</div></div>` : (() => {
            //     const tempImgSrc = data.tempImageSrc || `https://placehold.co/80x30/dbeafe/2563eb?text=${data.temp}Â°C`;
            //     return `<div>
            //                 <div class="fw-bold mb-1">${data.temp}Â°C</div>
            //                 <a href="${tempImgSrc}" target="_blank" title="View full screen">
            //                     <img src="${tempImgSrc}" alt="Temp" class="img-thumbnail p-0" style="width:80px; height:auto; border: 1px solid #ddd; cursor: pointer;">
            //                 </a>
            //                 <div class="small text-muted fst-italic">${data.date} ${data.time}</div>
            //             </div>`;
            // })();
            const qualityHTML = (data.temp === 'N/A') ? 
                `<div><div class="fw-bold mb-1">N/A</div></div>` : 
                `<div>
                    <div class="fw-bold mb-1">${data.temp}Â°C</div>
                    <a href="${data.tempImageSrc || '#'}" target="_blank" title="View full screen">
                        <img src="${data.tempImageSrc || '#'}" alt="Temp" class="img-thumbnail p-0" style="width:80px; height:auto; border:1px solid #ddd; cursor:pointer;">
                    </a>
                    <div class="small text-muted fst-italic">${data.date} ${data.time}</div>
                </div>`;
            let videoHTML = '';
            if (data.vehicleVideoUrl) {
                videoHTML = `
                    <a href="${data.vehicleVideoUrl}" target="_blank" class="btn btn-sm btn-outline-secondary w-100 mt-2" title="View Vehicle Video">
                        <i class="fas fa-video"></i>
                    </a>`;
            }
            const vendorEvalHTML = `
                <div class="text-center">
                    <div class="fw-bold">${data.vendorEval}%</div>
                    <button class="btn btn-sm btn-outline-info w-100 mt-1">Report</button>
                    ${videoHTML}
                </div>
            `;

            // const verifiedHTML = data.verified ? `<div>${verifiedByName}</div>
            
            // <div class="signature-display">
            // ${verifiedByName.split(' ').map(n=>n[0]).join('.') + '.'}
            // </div>` : `<button class="btn btn-sm btn-warning w-100 mb-2 verify-btn">Verify</button><div class="form-check"><input class="form-check-input row-checkbox" type="checkbox" data-id="${data.id}"><label class="form-check-label small">Select for batch</label></div>`;
            
            
            const verifiedHTML = data.verified 
    ? `<div>${verifiedByName}</div>
       <div class="signature-display">
           ${data.verified_sign ? `<img src="${data.verified_sign}" alt="Signature" class="img-fluid" style="max-height:40px;">` 
                                : verifiedByName.split(' ').map(n => n[0]).join('.') + '.'}
       </div>` 
    : `<button class="btn btn-sm btn-warning w-100 mb-2 verify-btn">Verify</button>
       <div class="form-check">
           <input class="form-check-input row-checkbox" type="checkbox" data-id="${data.id}">
           <label class="form-check-label small">Select for batch</label>
       </div>`;


            
            // const verifiedHTML = `<button class="btn btn-sm btn-warning w-100 mb-2 verify-btn">Verify</button><div class="form-check"><input class="form-check-input row-checkbox" type="checkbox" data-id="${data.id}"><label class="form-check-label small">Select for batch</label></div>`;
           
            const receivedBySignature = data.receivedBy.split(' ').map(n=>n[0]).join('.') + '.';
            const attachmentsHTML = renderAttachmentsCell(data.attachments);

            const desktopHTML = `
                <td class="d-none d-lg-table-cell"><div><div class="fw-bold">${data.rec}</div>
                <div class="text-muted small">${data.date}, ${data.time}</div><div class="small"><span class="text-muted">Invoice:</span> ${data.invoice}</div>${statusBadge}</div>
                
                  <!-- Edit Button -->
                    <button class="btn btn-primary edit-btn" 
                            data-id="${data.id}"
                            data-batch="${data.batch}"
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
                
                </td>
                <td class="d-none d-lg-table-cell"><div><div class="fw-bold">${data.vendor}</div><div class="text-muted">${data.productName}</div><hr class="my-1"><div class="small"><span class="text-muted">Batch:</span> ${data.batch}</div><div class="small"><span class="text-muted">MFG:</span> ${data.mfg}</div><div class="small"><span class="text-muted">EXP:</span> ${data.exp}</div>${shelfLifeHTML}</div></td>
                <td class="d-none d-lg-table-cell"><div>${qtyHTML}</div></td><td class="d-none d-lg-table-cell">${qualityHTML}</td>
                 <td class="d-none d-lg-table-cell">${vendorEvalHTML}</td>
                <td class="d-none d-lg-table-cell"><div>${data.receivedBy}</div><div class="signature-display">
                ${data.receivedSign
                  ? `<img src="${data.receivedSign}" alt="Signature" style="width: 80px; height: auto;">`
                  : receivedBySignature}</div></td>
                <td class="d-none d-lg-table-cell"><div class="small">${data.correctiveAction || '-'}</div></td>
                <td class="d-none d-lg-table-cell verified-cell">${verifiedHTML}</td>
                <td class="d-none d-lg-table-cell">${attachmentsHTML}</td>`;
            
            const mobileHTML = `
                <td class="d-lg-none p-0">
                    <div class="report-container my-3 mx-auto" style="box-shadow: none; border: 1px solid #dee2e6; border-radius: 8px; min-width: 0;">
                        <!-- Report Header -->
                        <div class="report-header">
                            <div class="product-info">
                                <h1>Report: ${data.productName}</h1>
                                <p class="small text-muted mb-1">Received: ${data.date} ${data.time}</p>
                                <p>Vendor: ${data.vendor}</p>
                            </div>
                            <div class="media-info">
                                <div class="media-item">
                                    ${data.temp !== 'N/A' ? `
                                        <div class="media-placeholder" style="border-style: solid; background-color: #e9ecef;"><i class="fas fa-thermometer-half fa-2x"></i></div>
                                        <div class="media-caption">${data.temp} &deg;C</div>
                                    ` : `
                                        <div class="media-placeholder">N/A</div>
                                        <div class="media-caption">Ambient</div>
                                    `}
                                </div>
                                <div class="media-item">
                                    <div class="media-placeholder" style="border-style: solid; background-color: #e9ecef;"><i class="fas fa-clipboard-check fa-2x"></i></div>
                                    <a href="#" class="view-link d-block" style="font-size: 12px; font-weight: 500; margin-top: -4px; margin-bottom: 2px;">View Checklist</a>
                                    <div class="media-caption">(${data.vendorEval}%)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Body -->
                        <div class="report-body">
                             <div class="text-center mb-3">
                                <button class="btn btn-sm btn-outline-secondary toggle-details-btn w-100">Show Full Report</button>
                            </div>

                            <div class="collapsible-details" style="display: none;">
                                <!-- Section: General Information -->
                                <div class="section">
                                    <h2 class="section-title">General Information</h2>
                                    <div class="grid">
                                        <div class="grid-item full-width">
                                            <span class="label">Documentation</span>
                                            <span class="value">
                                                ${data.attachments.formE ? '<a href="#" class="view-link">Form E</a>' : 'Form E (Missing)'} |
                                                ${data.attachments.coa ? '<a href="#" class="view-link">COA</a>' : 'COA (Missing)'} |
                                                ${data.attachments.invoice ? `<a href="#" class="view-link">Invoice (${data.invoice})</a>` : `Invoice (${data.invoice}) (Missing)`}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Product Details -->
                                <div class="section">
                                    <h2 class="section-title">Product Details</h2>
                                    <div class="grid">
                                        <div class="grid-item">
                                            <span class="label">Manufacture Date (MFD)</span>
                                            <span class="value">${data.mfg}</span>
                                        </div>
                                        <div class="grid-item">
                                            <span class="label">Expiry Date (EXP)</span>
                                            <span class="value">${data.exp}</span>
                                        </div>
                                        <div class="grid-item">
                                            <span class="label">Batch Number</span>
                                            <span class="value">${data.batch}</span>
                                        </div>
                                        <div class="grid-item">
                                            <span class="label">Balance Shelf Life</span>
                                            <span class="value ${shelfLife.percentage < 25 ? 'text-danger fw-bold' : ''}">${shelfLife.days} Days (${shelfLife.percentage.toFixed(0)}%)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Order Information -->
                                <div class="section">
                                    <h2 class="section-title">Order & Receiving Information</h2>
                                    <div class="grid">
                                        <div class="grid-item">
                                            <span class="label">Quantity Ordered</span>
                                            <span class="value">${ordered}</span>
                                        </div>
                                        <div class="grid-item">
                                            <span class="label">Quantity Received</span>
                                            <span class="value">${received}</span>
                                        </div>
                                        <div class="grid-item">
                                            <span class="label">Rejected / Short Supply</span>
                                            <span class="value rejected">${discrepancyQty > 0 ? discrepancyQty : '0'}</span>
                                        </div>
                                        <div class="grid-item full-width">
                                            <span class="label">Rejection Comments</span>
                                            <div class="text-area">${data.rejectionRemarks || 'N/A'}</div>
                                        </div>
                                        <div class="grid-item full-width">
                                            <span class="label">Corrective Action</span>
                                            <div class="text-area">${data.correctiveAction || 'N/A'}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Section: Vendor Evaluation -->
                                <div class="section">
                                    <h2 class="section-title">Vendor Evaluation</h2>
                                    <div class="grid">
                                        <div class="grid-item">
                                            <span class="label">Score</span>
                                            <span class="value">${data.vendorEval}%</span>
                                        </div>
                                         <div class="grid-item">
                                            <span class="label">Vehicle Inspection Video</span>
                                             ${data.vehicleVideoUrl ? `<a href="${data.vehicleVideoUrl}" target="_blank" class="view-link">View Video</a>` : '<span class="value text-muted">N/A</span>'}
                                        </div>
                                        <div class="grid-item full-width">
                                            <button class="btn btn-sm btn-outline-info w-100">View Full Evaluation Report</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Section: Verification -->
                            <div class="section">
                                <h2 class="section-title">Verification & Signatures</h2>
                                <div class="grid signatures">
                                    <div class="grid-item">
                                        <span class="label">Received by</span>
                                        <div class="signature-area">
                                            <div>${data.receivedBy}</div>
                                               <div class="signature-display">
                                                    ${data.receivedSign 
                                                      ? `<img src="${data.receivedSign}" alt="Signature" style="width: 80px; height: auto;">` 
                                                      : receivedBySignature}
                                                  </div>
                                        </div>
                                    </div>
                                    <div class="grid-item">
                                        <span class="label">Verified by</span>
                                        <div class="signature-area d-flex flex-column align-items-center justify-content-center text-center">
                                            ${verifiedHTML}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>`;

            tr.innerHTML = desktopHTML + mobileHTML;
            return tr;
        }

        function readFileAsDataURL(file) { return new Promise((resolve, reject) => { const reader = new FileReader(); reader.onload = () => resolve(reader.result); reader.onerror = reject; reader.readAsDataURL(file); }); }
        function calculateShelfLife(mfgStr, expStr) {
            if (!mfgStr || !expStr) return { days: 0, percentage: 0 };
            const mfgDateUTC = new Date(mfgStr + 'T00:00:00Z'); const expDateUTC = new Date(expStr + 'T00:00:00Z');
            const today = new Date(); const todayUTC = new Date(Date.UTC(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate()));
            if (isNaN(mfgDateUTC.getTime()) || isNaN(expDateUTC.getTime()) || expDateUTC < mfgDateUTC) return { days: -1, percentage: 0 };
            const totalShelfLife = (expDateUTC - mfgDateUTC) / 864e5; if (totalShelfLife <= 0) return { days: 0, percentage: 0 };
            const remainingDays = Math.ceil((expDateUTC - todayUTC) / 864e5); const percentage = (remainingDays / totalShelfLife) * 100;
            return { days: remainingDays, percentage: Math.max(0, Math.min(100, percentage)) };
        }
        function getSelectedRecordIds() { return Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => parseInt(cb.dataset.id)); }
        function updateVerifyButtonState() { const selectedCount = getSelectedRecordIds().length; document.getElementById('verifySelectedBtn').classList.toggle('d-none', selectedCount === 0); }
        
        function getProductRowTemplate(index) {
            return `
                <tr class="product-entry-row">
                    <td><button type="button" class="btn btn-outline-danger btn-sm remove-product-btn" title="Delete Row"><i class="fas fa-trash"></i></button></td>
                   <td><select class="form-select-sm product-name" required placeholder="Select product..."></select><select class="form-select-sm product-brand mt-1" required placeholder="Select brand..."></select></td>
                    <td><label class="merged-cell-label">Batch #</label><input type="text" class="form-control form-control-sm product-batch" required></td>
                    <td>
                        <div class="d-flex gap-2">
                           <div><label class="merged-cell-label">MFG Date</label><input type="date" class="form-control form-control-sm product-mfg" required></div>
                           <div><label class="merged-cell-label">EXP Date</label><input type="date" class="form-control form-control-sm product-exp" required></div>
                        </div>
                        <div class="shelf-life-display text-center small text-muted mt-1">---</div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control quantity-ordered" required placeholder="Ordered">
                            <input type="number" class="form-control quantity-received" required placeholder="Received">
                            <select class="form-select quantity-unit" style="max-width: 65px;"><option>Kg</option><option>gm</option><option>L</option><option>ml</option><option>pcs</option></select>
                        </div>
                        <div class="discrepancy-display text-center"></div>
                        <div class="discrepancy-details-container d-none mt-2 p-2 bg-light rounded">
                             <div class="row g-2 align-items-center">
                                <div class="col-md-auto fw-bold"><label class="form-label mb-0 small">Reason:</label></div>
                                <div class="col-md-auto"><div class="form-check form-check-inline"><input class="form-check-input discrepancy-reason" type="radio" name="discrepancyReason${index}" value="Rejected"><label class="form-check-label small">Rejected</label></div><div class="form-check form-check-inline"><input class="form-check-input discrepancy-reason" type="radio" name="discrepancyReason${index}" value="Shortfall"><label class="form-check-label small">Shortfall</label></div></div>
                                <div class="col-12"><hr class="my-1"></div>
                                <div class="col-md-12">
                                    <label class="form-label mb-1 small fw-bold">Discrepancy Remarks:</label>
                                    <textarea class="form-control form-control-sm rejection-remarks" name="rejection-remarks" rows="1"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label mb-1 small fw-bold">Corrective Action:</label>
                                    <textarea class="form-control form-control-sm corrective-action-remarks"  name="corrective-action-remarks" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-sm">
                                 <input type="number" step="0.1" class="form-control product-temp" required placeholder="Â°C">
                                 <label class="input-group-text" for="temp-image-upload-${index}"><i class="fas fa-camera"></i></label>
                                 <input class="d-none temp-image-upload" type="file" accept="image/*" id="temp-image-upload-${index}">
                            </div>
                            <img class="temp-image-preview" id="temp-image-preview-${index}" src="#" alt="Preview"/>
                            <button type="button" class="btn btn-outline-secondary btn-sm view-temp-image-btn d-none ms-1" title="View Fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                        <div class="invalid-feedback d-block temp-validation-message small m-0"></div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-sm product-coa" type="file">
                            <button type="button" class="btn btn-outline-secondary view-coa-btn" title="View COA" disabled><i class="fas fa-eye"></i></button>
                        </div>
                    </td>
                </tr>`;
        }


        document.addEventListener('focusin', function(event) {
          if (event.target.classList.contains('product-name')) {
            const select = event.target;
        
            if (select.options.length > 1) return;
        
            select.innerHTML = '<option value="" selected disabled>Select Product...</option>';
        
            Object.keys(productDatabase).forEach(productName => {
              const option = document.createElement('option');
              option.value = productName;
              option.textContent = productName;
              select.appendChild(option);
            });
          }
        });
        
        document.addEventListener('change', function(event) {
          if (event.target.classList.contains('product-name')) {
            const productSelect = event.target;
            const selectedProduct = productSelect.value;
            const brandSelect = productSelect.closest('td').querySelector('.product-brand');
        
            brandSelect.innerHTML = '<option value="" selected disabled>Select Brand...</option>';
        
            const brands = productDatabase[selectedProduct] || [];
        
            if (brands.length > 0) {
              brands.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand;
                option.textContent = brand;
                brandSelect.appendChild(option);
              });
            } else {
              const option = document.createElement('option');
              option.value = 'N/A';
              option.textContent = 'N/A';
              brandSelect.appendChild(option);
            }
          }
        });


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
        
            // const storageOptions = storageLocations.map(s => ({ value: s, text: s }));
            // new TomSelect(rowElement.querySelector('.storage-area-select'), { options: storageOptions });
        }





        const productTbody = document.getElementById('product-entries-tbody');

        function addFirstProductRow() {
            productTbody.innerHTML = getProductRowTemplate(0);
            productTbody.querySelector('.remove-product-btn')?.remove();
            initializeTomSelectForRow(productTbody);
        }

const addMoreBtn = document.getElementById('addMoreProductBtn');

if (!addMoreBtn.dataset.listenerAdded) {
    addMoreBtn.dataset.listenerAdded = "true"; // Mark listener as added

    addMoreBtn.addEventListener('click', function () {
        const rows = productTbody.querySelectorAll('.product-entry-row');
        let lastIndex = 0;

        if (rows.length > 0) {
            lastIndex = parseInt(rows[rows.length - 1].dataset.index) || (rows.length - 1);
        }

        const newIndex = lastIndex + 1;

        alert(newIndex); // अब सिर्फ एक बार show होगा

        // Insert new row
        productTbody.insertAdjacentHTML('beforeend', getProductRowTemplate(newIndex));
        const newRow = productTbody.lastElementChild;

        if (newRow) initializeTomSelectForRow(newRow); // सिर्फ new row initialize होगी
    });
}




        productTbody.addEventListener('click', e => {
            if (e.target.closest('.remove-product-btn')) {
                const rowToRemove = e.target.closest('.product-entry-row');
                rowToRemove.remove();
            }
            if (e.target.closest('.view-coa-btn')) {
                const coaInput = e.target.closest('.input-group').querySelector('.product-coa');
                if (coaInput.files && coaInput.files[0]) {
                    const fileURL = URL.createObjectURL(coaInput.files[0]);
                    window.open(fileURL, '_blank');
                }
            }
            if (e.target.closest('.view-temp-image-btn')) {
                const viewBtn = e.target.closest('.view-temp-image-btn');
                if (viewBtn.dataset.url) {
                    window.open(viewBtn.dataset.url, '_blank');
                }
            }
        });

        function updateShelfLifeDisplay(row) {
            if (!row) return;
            const mfgDate = row.querySelector('.product-mfg').value;
            const expDate = row.querySelector('.product-exp').value;
            const displayEl = row.querySelector('.shelf-life-display');
            if (mfgDate && expDate) {
                const { days, percentage } = calculateShelfLife(mfgDate, expDate);
                if (days < 0) { displayEl.innerHTML = `<span class="shelf-life-warning">EXPIRED</span>`; }
                else { const colorClass = percentage < 25 ? 'shelf-life-warning' : 'shelf-life-ok'; displayEl.innerHTML = `<span class="${colorClass}">${days}d (${percentage.toFixed(0)}%)</span>`; }
            } else { displayEl.textContent = '---'; }
        }

        function updateDiscrepancyRowState(row) {
            if (!row) return;
            const discrepancyContainer = row.querySelector('.discrepancy-details-container');
            if (!discrepancyContainer) return;

            const ordered = parseFloat(row.querySelector('.quantity-ordered').value) || 0;
            const received = parseFloat(row.querySelector('.quantity-received').value) || 0;
            const tempInput = row.querySelector('.product-temp');
            const selectedOption = row.querySelector('.product-name option:checked');
            const validationMessageEl = row.querySelector('.temp-validation-message');
            const discrepancyDisplay = row.querySelector('.discrepancy-display');

            const reasonRadios = discrepancyContainer.querySelectorAll('.discrepancy-reason');
            const rejectionRemarks = discrepancyContainer.querySelector('.rejection-remarks');
            const correctiveActionRemarks = discrepancyContainer.querySelector('.corrective-action-remarks');

            const hasQtyDiscrepancy = ordered > received && received >= 0;
            discrepancyDisplay.textContent = hasQtyDiscrepancy ? `Discrepancy: ${ordered - received}` : '';

            let isTempInvalid = false;
            tempInput.classList.remove('is-invalid');
            validationMessageEl.textContent = '';
            if (selectedOption && selectedOption.dataset.tempType !== 'ambient' && !tempInput.disabled) {
                const { min, max } = selectedOption.dataset;
                const minTemp = parseFloat(min); const maxTemp = parseFloat(max); const currentTemp = parseFloat(tempInput.value);
                if (!isNaN(currentTemp)) {
                    let err = '';
                    if ('min' in selectedOption.dataset && 'max' in selectedOption.dataset && (currentTemp < minTemp || currentTemp > maxTemp)) err = `Must be ${minTemp}Â°C - ${maxTemp}Â°C`;
                    else if ('max' in selectedOption.dataset && currentTemp > maxTemp) err = `Must be below ${maxTemp}Â°C`;
                    if (err) { isTempInvalid = true; tempInput.classList.add('is-invalid'); validationMessageEl.textContent = err; }
                }
            }
            
            const shouldShowRow = hasQtyDiscrepancy || isTempInvalid;
            discrepancyContainer.classList.toggle('d-none', !shouldShowRow);
            
            reasonRadios.forEach(r => r.required = hasQtyDiscrepancy);
            rejectionRemarks.required = hasQtyDiscrepancy;
            correctiveActionRemarks.required = shouldShowRow;

            if (!shouldShowRow) {
                reasonRadios.forEach(r => r.checked = false);
                rejectionRemarks.value = '';
                correctiveActionRemarks.value = '';
            }
        }
        
        productTbody.addEventListener('input', e => {
            const row = e.target.closest('.product-entry-row');
            if (!row) return;
            
            if (e.target.matches('.quantity-ordered, .quantity-received, .product-temp')) {
                 updateDiscrepancyRowState(row);
            }

            if (e.target.matches('.product-mfg, .product-exp')) {
                updateShelfLifeDisplay(row);
            }

            if (e.target.matches('.temp-image-upload')) {
                const preview = row.querySelector('.temp-image-preview');
                const viewBtn = row.querySelector('.view-temp-image-btn');
                const cameraLabel = row.querySelector(`label[for="${e.target.id}"]`);
                if (cameraLabel) cameraLabel.classList.remove('is-invalid-label');

                if (e.target.files && e.target.files[0]) {
                    const fileURL = URL.createObjectURL(e.target.files[0]);
                    preview.src = fileURL;
                    preview.style.display = 'block';
                    viewBtn.dataset.url = fileURL;
                    viewBtn.classList.remove('d-none');
                } else {
                    preview.style.display = 'none';
                    viewBtn.classList.add('d-none');
                }
            }

            if (e.target.matches('.product-coa')) {
                const viewBtn = e.target.closest('.input-group').querySelector('.view-coa-btn');
                viewBtn.disabled = !(e.target.files && e.target.files[0]);
            }
        });

        productTbody.addEventListener('change', e => {
            const row = e.target.closest('.product-entry-row');
            if (!row) return;

            if (e.target.matches('.product-name')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const tempInput = row.querySelector('.product-temp');
                const brandSelect = row.querySelector('.product-brand');
                
                const selectedProduct = e.target.value;
                const validBrands = productDatabase[selectedProduct] || [];
                brandSelect.innerHTML = '<option value="" selected disabled>Select Brand...</option>'; 
                validBrands.forEach(brand => {
                    const option = new Option(brand, brand);
                    brandSelect.add(option);
                });

                const isAmbient = selectedOption.dataset.tempType === 'ambient';
                tempInput.disabled = isAmbient;
                tempInput.required = !isAmbient;
                if(isAmbient) tempInput.value = '';

                updateDiscrepancyRowState(row);
            }
        });


        document.getElementById('downloadSampleCsvBtn').addEventListener('click', function(e) {
            e.preventDefault();
            const header = "ProductName,BrandName,BatchNumber,MfgDate(YYYY-MM-DD),ExpDate(YYYY-MM-DD),QtyOrdered,QtyReceived,Unit,Temperature,DiscrepancyReason,DiscrepancyRemarks,CorrectiveAction";
            const example1 = "Organic Tomatoes,OrganiFarms,T-451,2025-09-06,2025-09-13,50,50,Kg,N/A,,,,";
            const example2 = "Milk,DairyBest,M-209-B,2025-09-05,2025-09-12,100,90,L,4.5,Shortfall,2 crates damaged.,Credit note to be issued.";
            const csvContent = [header, example1, example2].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url); link.setAttribute("download", "product_upload_sample.csv");
            document.body.appendChild(link); link.click(); document.body.removeChild(link);
        });

        function processAndAddProducts(data) {
             if (productTbody.querySelector('.product-entry-row')) {
                productTbody.innerHTML = ''; 
            }
            if (data.length === 0) { addFirstProductRow(); return; }

            data.forEach((item) => {
                appendProductToRegister(item);
            });
        }
        
        function appendProductToRegister(item) {
            if (productTbody.querySelectorAll('.product-entry-row').length === 1 && !productTbody.querySelector('.product-batch')?.value) {
                productTbody.innerHTML = '';
            }

            const entryIndex = Date.now() + Math.random();
            productTbody.insertAdjacentHTML('beforeend', getProductRowTemplate(entryIndex));
            const newRow = Array.from(productTbody.querySelectorAll('.product-entry-row')).pop();

            if (productTbody.querySelectorAll('.product-entry-row').length === 1) {
                newRow.querySelector('.remove-product-btn')?.remove();
            }
            
             initializeTomSelectForRow(newRow);
             
            newRow.querySelector('.product-name').value = item.productName;
            newRow.querySelector('.product-name').dispatchEvent(new Event('change', { bubbles: true }));

            newRow.querySelector('.product-brand').value = item.brandName;
            newRow.querySelector('.product-batch').value = item.batch;
            newRow.querySelector('.product-mfg').value = item.mfgDate;
            newRow.querySelector('.product-exp').value = item.expDate;
            newRow.querySelector('.quantity-ordered').value = item.qtyOrdered;
            newRow.querySelector('.quantity-received').value = item.qtyReceived;
            newRow.querySelector('.quantity-unit').value = item.unit;
            
            const tempInput = newRow.querySelector('.product-temp');
            if (item.temp && !tempInput.disabled) {
                tempInput.value = item.temp;
            }
            
            if (item.discrepancyReason) {
                const discrepancyContainer = newRow.querySelector('.discrepancy-details-container');
                const radio = discrepancyContainer.querySelector(`.discrepancy-reason[value="${item.discrepancyReason}"]`);
                if(radio) radio.checked = true;
                discrepancyContainer.querySelector('.rejection-remarks').value = item.discrepancyRemarks;
                discrepancyContainer.querySelector('.corrective-action-remarks').value = item.correctiveAction;
            }

            updateShelfLifeDisplay(newRow);
            updateDiscrepancyRowState(newRow);
        }

        document.getElementById('bulkUploadInput').addEventListener('change', function(e) {
            const file = e.target.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = function(event) {
                csvReviewData = { matched: [], mismatched: [] };
                const rows = event.target.result.split('\n').filter(row => row.trim() !== '');
                if (rows.length <= 1) { alert('CSV file is empty or contains only a header.'); return; }
                
                rows.slice(1).forEach((rowStr, index) => {
                    const cols = rowStr.split(',').map(c => c.trim());
                    if (cols.length < 8) return;
                    
                    const rowData = {
                        productName: cols[0] || '', brandName: cols[1] || '', batch: cols[2] || '', mfgDate: cols[3] || '',
                        expDate: cols[4] || '', qtyOrdered: cols[5] || '', qtyReceived: cols[6] || '', unit: cols[7] || 'Kg',
                        temp: cols[8] || '', discrepancyReason: cols[9] || '', discrepancyRemarks: cols[10] || '',
                        correctiveAction: cols[11] || '', originalIndex: index
                    };

                    const isValid = productDatabase[rowData.productName] && productDatabase[rowData.productName].includes(rowData.brandName);
                    if (isValid) {
                        csvReviewData.matched.push(rowData);
                    } else {
                        csvReviewData.mismatched.push(rowData);
                    }
                });

                if (csvReviewData.mismatched.length > 0) {
                    populateMatcherModal();
                    dataMatcherModal.show();
                } else {
                    processAndAddProducts(csvReviewData.matched);
                }
            };
            reader.readAsText(file);
            e.target.value = '';
        });

        function populateMatcherModal() {
            const tbody = document.getElementById('mismatched-items-tbody');
            tbody.innerHTML = '';
            document.getElementById('selectAllMatcherCheckbox').checked = false;
            
            const productOptions = Object.keys(productDatabase).map(p => `<option value="${p}">${p}</option>`).join('');
            const brandOptions = allBrands.map(b => `<option value="${b}">${b}</option>`).join('');

            csvReviewData.mismatched.forEach(item => {
                const tr = document.createElement('tr');
                tr.dataset.originalIndex = item.originalIndex;
                tr.innerHTML = `
                    <td class="text-center"><input class="form-check-input matcher-row-checkbox" type="checkbox"></td>
                    <td><span class="badge bg-danger-subtle text-danger-emphasis">${item.productName || '(empty)'}</span></td>
                    <td><span class="badge bg-danger-subtle text-danger-emphasis">${item.brandName || '(empty)'}</span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm corrected-product">${productOptions}</select>
                            <select class="form-select form-select-sm corrected-brand">${brandOptions}</select>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-success accept-matcher-btn" title="Accept this corrected entry"><i class="fas fa-check"></i> Accept</button>
                            <button type="button" class="btn btn-outline-danger reject-matcher-btn" title="Reject this entry"><i class="fas fa-times"></i> Reject</button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.getElementById('mismatched-items-tbody').addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            if (!row) return;
            if (e.target.closest('.reject-matcher-btn')) { row.remove(); }
            if (e.target.closest('.accept-matcher-btn')) {
                const originalIndex = parseInt(row.dataset.originalIndex, 10);
                const originalItem = csvReviewData.mismatched.find(item => item.originalIndex === originalIndex);
                if (originalItem) {
                    const correctedItem = { ...originalItem };
                    correctedItem.productName = row.querySelector('.corrected-product').value;
                    correctedItem.brandName = row.querySelector('.corrected-brand').value;
                    appendProductToRegister(correctedItem);
                    row.remove();
                }
            }
        });

        document.getElementById('rejectSelectedMatcherBtn').addEventListener('click', function() {
            document.querySelectorAll('#mismatched-items-tbody .matcher-row-checkbox:checked').forEach(checkbox => { checkbox.closest('tr').remove(); });
            document.getElementById('selectAllMatcherCheckbox').checked = false;
        });

        document.getElementById('selectAllMatcherCheckbox').addEventListener('change', function(e) {
            document.querySelectorAll('#mismatched-items-tbody .matcher-row-checkbox').forEach(checkbox => { checkbox.checked = e.target.checked; });
        });

        document.getElementById('confirmMatcherBtn').addEventListener('click', function() {
            const correctedItems = [];
            document.querySelectorAll('#mismatched-items-tbody tr').forEach(tr => {
                const originalIndex = parseInt(tr.dataset.originalIndex, 10);
                const originalItem = csvReviewData.mismatched.find(item => item.originalIndex === originalIndex);
                if (originalItem) {
                    const correctedItem = { ...originalItem };
                    correctedItem.productName = tr.querySelector('.corrected-product').value;
                    correctedItem.brandName = tr.querySelector('.corrected-brand').value;
                    correctedItems.push(correctedItem);
                }
            });
            const finalData = [...csvReviewData.matched, ...correctedItems];
            finalData.forEach(item => appendProductToRegister(item));
            csvReviewData.matched = []; 
            dataMatcherModal.hide();
        });

        document.getElementById('vendorChecklistBtn').addEventListener('click', () => checklistModal.show());
        document.getElementById('confirmChecklistBtn').addEventListener('click', function() {
            checklistModal.hide();
            document.getElementById('vendorChecklistBtn').classList.add('disabled', 'btn-outline-success');
            document.getElementById('step1-vendor-details').classList.add('d-none');
            document.getElementById('step2-receiving-register').classList.remove('d-none');
            document.getElementById('saveRecordBtn').disabled = false;
        });

        // document.getElementById('saveRecordBtn').addEventListener('click', async (event) => {
        //     event.preventDefault(); 
        //     const form = document.getElementById('newRecordForm');

        //     let isTempImageValid = true;
        //     document.querySelectorAll('.is-invalid-label').forEach(el => el.classList.remove('is-invalid-label'));

        //     for (const row of productTbody.querySelectorAll('.product-entry-row')) {
        //         const tempImageUpload = row.querySelector('.temp-image-upload');
        //         if (tempImageUpload.required && tempImageUpload.files.length === 0) {
        //             isTempImageValid = false;
        //             const cameraLabel = row.querySelector(`label[for="${tempImageUpload.id}"]`);
        //             if (cameraLabel) cameraLabel.classList.add('is-invalid-label');
        //         }
        //     }

        //     if (!form.checkValidity() || receiverSignPad.isEmpty() || !isTempImageValid) {
        //         form.classList.add('was-validated');
        //         let alertMessage = 'Please fill all required fields and provide a signature.';
        //         if (!isTempImageValid) {
        //             alertMessage += '\n\nA temperature image is required for all chilled or frozen items.';
        //         }
        //         alert(alertMessage);
        //         return;
        //     }

        //     const sharedData = { time: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }), date: new Date().toISOString().split('T')[0], vendor: document.getElementById('vendorSelect').value, invoice: document.getElementById('invoiceNumberInput').value, receivedBy: 'John Doe', verified: false };
        //     const hasFormE = document.getElementById('formEInput').files.length > 0;
        //     const hasInvoice = document.getElementById('invoiceInput').files.length > 0;
            
        //     const productRows = Array.from(productTbody.querySelectorAll('.product-entry-row'));
        //     const filePromises = productRows.map(row => {
        //         const fileInput = row.querySelector('.temp-image-upload');
        //         return fileInput.files.length > 0 ? readFileAsDataURL(fileInput.files[0]) : Promise.resolve(null);
        //     });
        //     const imageSources = await Promise.all(filePromises);

        //     productRows.forEach((row, index) => {
        //         const discrepancyContainer = row.querySelector('.discrepancy-details-container');
        //         const discrepancyRadio = discrepancyContainer.querySelector('.discrepancy-reason:checked');
        //         const hasCOA = row.querySelector('.product-coa').files.length > 0;
        //         let newRecord = { ...sharedData, id: Date.now() + index, rec: `REC-${Math.floor(10000 + Math.random() * 90000)}`,
        //             productName: row.querySelector('.product-name').value, brand: row.querySelector('.product-brand').value, batch: row.querySelector('.product-batch').value,
        //             mfg: row.querySelector('.product-mfg').value, exp: row.querySelector('.product-exp').value,
        //             ordered: row.querySelector('.quantity-ordered').value, received: row.querySelector('.quantity-received').value,
        //             temp: row.querySelector('.product-temp').disabled ? 'N/A' : row.querySelector('.product-temp').value,
        //             discrepancyReason: discrepancyRadio ? discrepancyRadio.value : '',
        //             rejectionRemarks: discrepancyRadio ? discrepancyContainer.querySelector('.rejection-remarks').value : '',
        //             correctiveAction: discrepancyContainer.classList.contains('d-none') ? '' : discrepancyContainer.querySelector('.corrective-action-remarks').value,
        //             vendorEval: Math.floor(80 + Math.random() * 20),
        //             tempImageSrc: imageSources[index],
        //             attachments: { formE: hasFormE, invoice: hasInvoice, coa: hasCOA },
        //             vehicleVideoUrl: '#' 
        //         };
        //         newRecord.status = getStatus(newRecord);
        //         allRecords.unshift(newRecord);
        //     });
        //     applyFilters();
        //     mainModal.hide();
        // });

          document.getElementById('saveRecordBtn').addEventListener('click', async (event) => {
            event.preventDefault();

            const form = document.getElementById('newRecordForm');
            const productTbody = document.getElementById('product-entries-tbody');
    
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
            
            const checklistItems = [];
            const checklistModal = document.getElementById('vendorEvaluationChecklistModal'); 
            if (checklistModal) {
                checklistModal.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
                    const itemText = checkbox.closest('tr').querySelector('td').textContent.trim();
                    checklistItems.push(itemText);
                });
            }
        
            const vendorChecklist = checklistItems.join(', ');
            formData.append('vendor_evaluation_checklist', vendorChecklist);
        
        
        
            const productsData = [];
            const productRows = productTbody.querySelectorAll('.product-entry-row');
        
            productRows.forEach((row, index) => {
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
                
                const correctiveActionRemark = row.querySelector('.corrective-action-remarks')?.value || '';
                const rejectionRemark = row.querySelector('.rejection-remarks')?.value || '';
                
                const shelfLifeElement = row.querySelector('.shelf-life-ok');
                const shelfLife = shelfLifeElement ? shelfLifeElement.textContent.trim() : null;
                
                const discrepancyRemarksContainer = $(row).find('div > label:contains("Discrepancy Remarks:")').parent()[0];
                const correctiveActionContainer = $(row).find('div > label:contains("Corrective Action Taken:")').parent()[0];
                
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
                        discrepancyValue = parseInt(match[1]);
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
                    // discrepancy_remarks: discrepancyRemarks,
                    // corrective_action: correctiveAction,
                      discrepancy_remarks: rejectionRemark,
                    corrective_action: correctiveActionRemark,
                    shelf_life_display: shelfLife,
                    discrepancy_value: discrepancyValue,
                });


                    const tempImageFile = row.querySelector('.temp-image-upload')?.files[0];
                    const coaFile = row.querySelector('.product-coa')?.files[0];
                    
                    if (tempImageFile) {
                        formData.append(`temperature_image_${index}`, tempImageFile);
                    }
                    if (coaFile) {
                        formData.append(`attachment_coa_${index}`, coaFile);
                    }
                    
                });
            
                formData.append('products_data', JSON.stringify(productsData));
            
                alert(JSON.stringify(productsData))
                const generalRemarks = document.getElementById('generalRemarks')?.value || '';
                let receiverSignature = null;
                if (typeof receiverSignPad !== 'undefined' && !receiverSignPad.isEmpty()) {
                    receiverSignature = receiverSignPad.toDataURL();
                }
                formData.append('general_remarks', generalRemarks);

                const receivedByInput = document.getElementById('received_by');
                const receivedBy = receivedByInput?.value || '';
                formData.append('received_by', receivedBy);
                
                formData.append('general_remarks', generalRemarks);
                formData.append('receiver_signature', receiverSignature);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                formData.append('_token', csrfToken);
                
                $.ajax({
                    url: "{{route('store.receiving.record.new')}}",
                    method: 'POST',
                    data: formData,
                    contentType: false, 
                    processData: false, 
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


            function formDataToJson(formData) {
                const obj = {};
                for (const [key, value] of formData.entries()) {
                    if (value instanceof File) {
                        obj[key] = value.name; 
                    } else {
                        obj[key] = value;
                    }
                }
                return obj;
            }


        tableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('verify-btn')) {
                const recordId = parseInt(e.target.closest('tr').dataset.id, 10);
                verificationMode = 'single';
                verificationTargetIds = [recordId];
                verifierSignPad.clear();
                verificationModal.show();
            }

            const toggleBtn = e.target.closest('.toggle-details-btn');
            if (toggleBtn) {
                e.preventDefault();
                const reportContainer = toggleBtn.closest('.report-container');
                if (reportContainer) {
                    const details = reportContainer.querySelector('.collapsible-details');
                    if (details) {
                        const isHidden = details.style.display === 'none';
                        if (isHidden) {
                            details.style.display = 'block';
                            toggleBtn.textContent = 'Hide Full Report';
                        } else {
                            details.style.display = 'none';
                            toggleBtn.textContent = 'Show Full Report';
                        }
                    }
                }
            }
        });
        
        tableBody.addEventListener('change', function(e) {
            if (e.target.classList.contains('row-checkbox')) {
                updateVerifyButtonState();
            }
        });

        document.getElementById('verifySelectedBtn').addEventListener('click', function() {
            const selectedIds = getSelectedRecordIds();
            if (selectedIds.length > 0) {
                verificationMode = 'batch';
                verificationTargetIds = selectedIds;
                verifierSignPad.clear();
                verificationModal.show();
            }
        });

        // document.getElementById('confirmVerificationBtn').addEventListener('click', function() {
        //     if (verifierSignPad.isEmpty()) {
        //         alert('A signature is required to verify.');
        //         return;
        //     }
            
        //     allRecords = allRecords.map(record => {
        //         if (verificationTargetIds.includes(record.id)) {
        //             record.verified = true;
        //         }
        //         return record;
        //     });

        //     verificationModal.hide();
        //     applyFilters(); 
        // });
        
        document.getElementById('confirmVerificationBtn').addEventListener('click', function() {
            if (verifierSignPad.isEmpty()) {
                toastr.error('A signature is required to verify.');
                return;
            }
            
            const comments = document.getElementById('verificationComments').value.trim();
            const signatureData = verifierSignPad.toDataURL();
        
            // ðŸŸ§ Step 3: Update local records
            // allRecords = allRecords.map(record => {
            //     if (verificationTargetIds.includes(record.id)) {
            //         record.verified = true;
            //         record.verificationComments = comments;
            //         record.signature = signatureData;
            //     }
            //     return record;
            // });
        
        
            fetch("{{route('save.verification.receiving.record')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    recordIds: verificationTargetIds,
                    comments: comments,
                    signature: signatureData
                })
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {
                    toastr.success('Verification saved successfully!');
                    setTimeout(()=>{
                        location.reload()
                    },2000)
                } else {
                    toastr.error('Failed to save verification.');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Error while saving verification: ' + err.message);
            });
        
            verificationModal.hide();
            applyFilters(); 
        });



        function generatePdfAsImage() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'l', unit: 'mm', format: 'a4' });
            
            const MARGIN = 10;
            const PAGE_WIDTH = doc.internal.pageSize.getWidth();
            const ROW_HEIGHT = 35; 
            const LINE_HEIGHT = 4.5;
            const FONT_SIZE_NORMAL = 9;
            const FONT_SIZE_SMALL = 8;
            
            let startY = MARGIN + 15;

            const drawEyeIcon = (doc, x, y) => {
                doc.setDrawColor('#0d6efd'); doc.setLineWidth(0.5);
                doc.ellipse(x, y, 1.5, 1); doc.setFillColor('#0d6efd');
                doc.circle(x, y, 0.5, 'F');
            };

            const drawCameraIcon = (doc, x, y) => {
                doc.setDrawColor('#6c757d'); doc.setFillColor('#f8f9fa');
                doc.roundedRect(x, y, 5, 3.5, 0.5, 0.5, 'FD');
                doc.setFillColor('#6c757d'); doc.circle(x + 2.5, y + 1.75, 1.2, 'F');
                doc.rect(x + 1.5, y - 0.5, 2, 0.5, 'F');
            };

            const drawVerifyButton = (doc, x, y) => {
                const buttonWidth = 15; const buttonHeight = 7;
                doc.setFillColor('#ffc107');
                doc.roundedRect(x, y, buttonWidth, buttonHeight, 1, 1, 'F');
                doc.setTextColor('#000000'); doc.setFont('helvetica', 'bold');
                doc.setFontSize(FONT_SIZE_SMALL);
                doc.text('Verify', x + 3.5, y + 4.5);
            };

             const drawAttachmentStatus = (doc, x, y, label, isAttached) => {
                doc.setFontSize(FONT_SIZE_NORMAL); doc.setFont('helvetica', 'normal');
                doc.setTextColor('#5f6368'); doc.text(label, x, y);
                const badgeX = x + 10;
                const badgeText = isAttached ? 'Attached' : 'Missing';
                const badgeColor = isAttached ? '#198754' : '#6c757d';
                const badgeWidth = 16;
                doc.setFillColor(badgeColor);
                doc.roundedRect(badgeX, y - 3.5, badgeWidth, 5, 2, 2, 'F');
                doc.setTextColor('#FFFFFF'); doc.setFontSize(FONT_SIZE_SMALL);
                doc.setFont('helvetica', 'bold');
                doc.text(badgeText, badgeX + 3, y - 0.2);
                if (isAttached) { drawEyeIcon(doc, badgeX + badgeWidth + 3, y - 1); }
            };

            doc.setFontSize(14); doc.setFont('helvetica', 'bold');
            doc.text("Receiving Records", MARGIN, MARGIN);
            doc.setFontSize(8); doc.setTextColor('#5f6368');
            doc.text(`Generated on: ${new Date().toLocaleString()}`, MARGIN, MARGIN + 5);

            const headers = ['Receiving / Invoice No.', 'Supplier & Material Details', 'Quantity', 'Quality Checks', 'Vendor Eval.', 'Received By', 'Corrective Action', 'Verified By', 'Attachments'];
            const colX = [10, 50, 95, 125, 155, 175, 200, 225, 255];
            doc.setFont('helvetica', 'bold'); doc.setFontSize(9);
            doc.setTextColor('#212529');
            headers.forEach((header, i) => doc.text(header, colX[i], MARGIN + 12));
            doc.setDrawColor('#dee2e6');
            doc.line(MARGIN, MARGIN + 15, PAGE_WIDTH - MARGIN, MARGIN + 15);

            let currentY = MARGIN + 22;
            displayedRecords.forEach((rec, index) => {
                if (currentY > 180) { doc.addPage(); currentY = MARGIN + 10; }
                let startOfRowY = currentY;

                doc.setFontSize(FONT_SIZE_NORMAL); doc.setFont('helvetica', 'bold');
                doc.text(rec.rec, colX[0], currentY);
                doc.setFont('helvetica', 'normal'); doc.setFontSize(FONT_SIZE_SMALL);
                doc.setTextColor('#5f6368');
                doc.text(`${rec.date}, ${rec.time}`, colX[0], currentY += LINE_HEIGHT);
                doc.text(`Invoice: ${rec.invoice}`, colX[0], currentY += LINE_HEIGHT);
                let badgeColor = rec.status === 'Rejected' ? '#f8d7da' : (rec.status === 'Partial' ? '#fff3cd' : '#d1e7dd');
                let textColor = rec.status === 'Rejected' ? '#721c24' : (rec.status === 'Partial' ? '#664d03' : '#0f5132');
                let text = rec.status;
                doc.setFillColor(badgeColor);
                doc.roundedRect(colX[0], currentY + 2, doc.getTextWidth(text) + 4, 6, 2, 2, 'F');
                doc.setTextColor(textColor); doc.setFont('helvetica', 'bold');
                doc.text(text, colX[0] + 2, currentY + 6);
                
                currentY = startOfRowY; doc.setTextColor('#000000');
                doc.setFontSize(FONT_SIZE_NORMAL); doc.setFont('helvetica', 'bold');
                doc.text(rec.vendor, colX[1], currentY);
                doc.setFont('helvetica', 'normal');
                doc.text(rec.productName, colX[1], currentY += LINE_HEIGHT);
                doc.setFontSize(FONT_SIZE_SMALL); doc.setTextColor('#5f6368');
                doc.text(`Batch: ${rec.batch}`, colX[1], currentY += LINE_HEIGHT + 2);
                doc.text(`MFG: ${rec.mfg}`, colX[1], currentY += LINE_HEIGHT);
                doc.text(`EXP: ${rec.exp}`, colX[1], currentY += LINE_HEIGHT);

                currentY = startOfRowY; doc.setTextColor('#5f6368');
                doc.setFontSize(FONT_SIZE_SMALL);
                doc.text(`Ordered:`, colX[2], currentY);
                doc.text(`Accepted:`, colX[2], currentY + LINE_HEIGHT);
                doc.setTextColor('#000000');
                doc.text(`${rec.ordered}`, colX[2] + 12, startOfRowY);
                doc.text(`${rec.received}`, colX[2] + 12, startOfRowY + LINE_HEIGHT);
                if (rec.ordered > rec.received) {
                    currentY += LINE_HEIGHT * 2;
                    doc.setTextColor('#dc3545'); doc.setFont('helvetica', 'bold');
                    const discrepancyLabel = rec.discrepancyReason === 'Rejected' ? 'Rejected:' : 'Shortfall:';
                    doc.text(discrepancyLabel, colX[2], currentY);
                    doc.text(`${rec.ordered - rec.received}`, colX[2] + 12, currentY);
                    doc.setFont('helvetica', 'normal'); currentY += LINE_HEIGHT;
                    doc.text(`Reason: ${rec.rejectionRemarks}`, colX[2], currentY, { maxWidth: 28 });
                }
                
                currentY = startOfRowY; doc.setTextColor('#000000');
                doc.setFont('helvetica', 'bold'); doc.setFontSize(FONT_SIZE_NORMAL);
                doc.text(rec.temp !== 'N/A' ? `${rec.temp}Â°C` : 'N/A', colX[3], currentY);
                if(rec.temp !== 'N/A') {
                    doc.setDrawColor('#dee2e6');
                    doc.rect(colX[3], currentY + 2, 15, 8, 'S');
                    doc.setTextColor('#6c757d');
                    doc.text('Img', colX[3] + 5, currentY + 7);
                }
                doc.setFont('helvetica', 'normal'); doc.setFontSize(FONT_SIZE_SMALL);
                doc.setTextColor('#5f6368'); doc.text(`${rec.date} ${rec.time}`, colX[3], currentY + 14);

                currentY = startOfRowY; doc.setTextColor('#000000');
                doc.setFont('helvetica', 'bold'); doc.setFontSize(FONT_SIZE_NORMAL);
                doc.text(`${rec.vendorEval}%`, colX[4], currentY);
                doc.setFillColor('#e0f7fa'); doc.setDrawColor('#0dcaf0');
                doc.roundedRect(colX[4], currentY + 3, 15, 7, 1.5, 1.5, 'FD');
                doc.setTextColor('#055160'); doc.text('Report', colX[4] + 3.5, currentY + 7.5);
                doc.setFillColor('#f8f9fa'); doc.setDrawColor('#adb5bd');
                doc.roundedRect(colX[4], currentY + 12, 15, 7, 1.5, 1.5, 'FD');
                drawCameraIcon(doc, colX[4] + 5, currentY + 14);

                currentY = startOfRowY; doc.setTextColor('#000000');
                doc.setFont('helvetica', 'normal'); doc.setFontSize(FONT_SIZE_NORMAL);
                doc.text(rec.receivedBy, colX[5], currentY);
                doc.setFont('times', 'italic'); doc.setFontSize(14);
                doc.setTextColor('#0d6efd');
                const receivedByInitials = rec.receivedBy.split(' ').map(n=>n[0]).join('.') + '.';
                doc.text(receivedByInitials, colX[5], currentY + 8);
                
                currentY = startOfRowY; doc.setTextColor('#000000');
                doc.setFont('helvetica', 'normal'); doc.setFontSize(FONT_SIZE_SMALL);
                doc.text(rec.correctiveAction || '-', colX[6], currentY, { maxWidth: 22 });
                
                currentY = startOfRowY;
                 if (rec.verified) {
                    doc.setTextColor('#000000'); doc.setFont('helvetica', 'normal');
                    doc.setFontSize(FONT_SIZE_NORMAL); doc.text('Jane Smith', colX[7], currentY);
                    doc.setFont('times', 'italic'); doc.setFontSize(14);
                    doc.setTextColor('#0d6efd'); doc.text('J.S.', colX[7], currentY + 8);
                } else { drawVerifyButton(doc, colX[7], currentY); }

                currentY = startOfRowY;
                drawAttachmentStatus(doc, colX[8], currentY, 'Form E:', rec.attachments.formE);
                currentY += LINE_HEIGHT + 2;
                drawAttachmentStatus(doc, colX[8], currentY, 'Invoice:', rec.attachments.invoice);
                currentY += LINE_HEIGHT + 2;
                drawAttachmentStatus(doc, colX[8], currentY, 'COA:', rec.attachments.coa);
                
                currentY = startOfRowY + ROW_HEIGHT;
                doc.setDrawColor('#e9ecef');
                doc.line(MARGIN, currentY, PAGE_WIDTH - MARGIN, currentY);
            });
            doc.save('FoodSafe_Receiving_Records.pdf');
            
        }

        document.getElementById('downloadPdfBtn').addEventListener('click', generatePdfAsImage);
        
        function resetAndRefresh() {
            document.querySelectorAll('.dropdown-menu input[type="text"], .dropdown-menu input[type="date"], .dropdown-menu input[type="number"]').forEach(input => input.value = '');
            document.querySelectorAll('.dropdown-menu select').forEach(select => { if (select.tomselect) { select.tomselect.clear(); } else { select.selectedIndex = 0; } });
            document.querySelectorAll('input[name="qtyFilter"][value=""]').forEach(radio => radio.checked = true);
            document.querySelectorAll('input[name="caFilter"][value=""]').forEach(radio => radio.checked = true);
            document.querySelectorAll('.attachment-filter').forEach(check => check.checked = false);
            applyFilters();
        }

        document.getElementById('refreshBtn').addEventListener('click', resetAndRefresh);

        function applyFilters() {
            const filters = {
                dateFrom: document.getElementById('filterDateFrom').value, dateTo: document.getElementById('filterDateTo').value,
                invoiceNo: document.getElementById('filterInvoiceNo').value.toLowerCase(), recNo: document.getElementById('filterRecNo').value.toLowerCase(),
                status: document.getElementById('filterStatus').value, productName: tomSelectInstances['#filterProductName'].getValue(),
                vendorName: tomSelectInstances['#filterVendorName'].getValue(), batchNo: document.getElementById('filterBatchNo').value.toLowerCase(),
                mfgFrom: document.getElementById('filterMfgFrom').value, mfgTo: document.getElementById('filterMfgTo').value,
                expFrom: document.getElementById('filterExpFrom').value, expTo: document.getElementById('filterExpTo').value,
                shelfLifeOp: document.getElementById('filterShelfLifeOp').value, shelfLifeVal: document.getElementById('filterShelfLifeVal').value,
                qty: document.querySelector('input[name="qtyFilter"]:checked').value, compliance: document.getElementById('filterCompliance').value,
                tempFrom: document.getElementById('filterTempFrom').value, tempTo: document.getElementById('filterTempTo').value,
                scoreFrom: document.getElementById('filterScoreFrom').value, scoreTo: document.getElementById('filterScoreTo').value,
                correctiveAction: document.querySelector('input[name="caFilter"]:checked').value,
                attachments: Array.from(document.querySelectorAll('.attachment-filter:checked')).map(el => ({ type: el.dataset.type, status: el.dataset.status }))
            };

            displayedRecords = allRecords.filter(rec => {
                if (filters.dateFrom && rec.date < filters.dateFrom) return false;
                if (filters.dateTo && rec.date > filters.dateTo) return false;
                if (filters.invoiceNo && !rec.invoice.toLowerCase().includes(filters.invoiceNo)) return false;
                if (filters.recNo && !rec.rec.toLowerCase().includes(filters.recNo)) return false;
                if (filters.status && rec.status !== filters.status) return false;
                if (filters.productName && rec.productName !== filters.productName) return false;
                if (filters.vendorName && rec.vendor !== filters.vendorName) return false;
                if (filters.batchNo && !rec.batch.toLowerCase().includes(filters.batchNo)) return false;
                if (filters.mfgFrom && rec.mfg < filters.mfgFrom) return false;
                if (filters.mfgTo && rec.mfg > filters.mfgTo) return false;
                if (filters.expFrom && rec.exp < filters.expFrom) return false;
                if (filters.expTo && rec.exp > filters.expTo) return false;
                if(filters.shelfLifeVal) {
                    const shelfLife = calculateShelfLife(rec.mfg, rec.exp).percentage; const val = parseFloat(filters.shelfLifeVal);
                    if (filters.shelfLifeOp === 'gte' && shelfLife < val) return false;
                    if (filters.shelfLifeOp === 'lte' && shelfLife > val) return false;
                    if (filters.shelfLifeOp === 'eq' && Math.floor(shelfLife) !== Math.floor(val)) return false;
                }
                if (filters.qty) {
                    const ordered = parseFloat(rec.ordered); const received = parseFloat(rec.received);
                    if (filters.qty === 'Rejected' && (received !== 0 || ordered === 0)) return false;
                    if (filters.qty === 'Short Supply' && (received >= ordered || received === 0)) return false;
                    if (filters.qty === 'Actual' && received !== ordered) return false;
                }
                if (filters.tempFrom && (rec.temp === 'N/A' || parseFloat(rec.temp) < parseFloat(filters.tempFrom))) return false;
                if (filters.tempTo && (rec.temp === 'N/A' || parseFloat(rec.temp) > parseFloat(filters.tempTo))) return false;
                if (filters.scoreFrom && rec.vendorEval < parseFloat(filters.scoreFrom)) return false;
                if (filters.scoreTo && rec.vendorEval > parseFloat(filters.scoreTo)) return false;
                if (filters.correctiveAction) {
                    const hasAction = rec.correctiveAction && rec.correctiveAction.trim() !== '-';
                    if (filters.correctiveAction === 'yes' && !hasAction) return false;
                    if (filters.correctiveAction === 'no' && hasAction) return false;
                }
                if (filters.attachments.length > 0) {
                    for(const att of filters.attachments) {
                        const hasAttachment = rec.attachments[att.type];
                        if (att.status === 'attached' && !hasAttachment) return false;
                        if (att.status === 'missing' && hasAttachment) return false;
                    }
                }
                return true;
            });

            paginationState.currentPage = 1;
            renderTable();
        }
        
        document.querySelectorAll('.apply-filter-btn').forEach(btn => btn.addEventListener('click', applyFilters));
        document.querySelectorAll('.clear-filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const dropdown = e.target.closest('.dropdown-menu');
                dropdown.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]').forEach(input => input.value = '');
                dropdown.querySelectorAll('select').forEach(select => { if (select.tomselect) { select.tomselect.clear(); } else { select.selectedIndex = 0; } });
                dropdown.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = radio.value === "");
                dropdown.querySelectorAll('input[type="checkbox"]').forEach(check => check.checked = false);
                applyFilters();
            });
        });

        function resetNewRecordModal() {
            const form = document.getElementById('newRecordForm');
            form.reset();
            form.classList.remove('was-validated');

            if (tomSelectInstances['#vendorSelect']) {
                tomSelectInstances['#vendorSelect'].clear();
            }
            receiverSignPad.clear();

            document.getElementById('step1-vendor-details').classList.remove('d-none');
            document.getElementById('step2-receiving-register').classList.add('d-none');
            const checklistBtn = document.getElementById('vendorChecklistBtn');
            checklistBtn.classList.remove('disabled', 'btn-outline-success');
            document.getElementById('saveRecordBtn').disabled = true;

            document.querySelectorAll('#vendorChecklistModal input[type="checkbox"]').forEach(cb => cb.checked = false);
            
            addFirstProductRow();
        }
        mainModalEl.addEventListener('hidden.bs.modal', resetNewRecordModal);

        loadInitialData();
        addFirstProductRow();
      };
      
      
      
      
    

    // });
    </script>
</body>
</html>