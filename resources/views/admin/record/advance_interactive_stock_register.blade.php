<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Professional Interactive Stock Register (Bootstrap 5)</title>
    <!-- SheetJS Library for XLSX Export -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-body-font-family: 'Inter', sans-serif;
        }
        body {
            background-color: #f8f9fa;
        }
        .container-fluid {
            max-width: 1900px;
        }
        .stock-in { background-color: rgba(23, 162, 184, 0.1); }
        .stock-out { background-color: rgba(220, 53, 69, 0.05); }

        .item-details .item-name { font-weight: 600; font-size: 1.1em; }
        .batch-details .brand-name, .batch-details .batch-info { color: #6c757d; font-size: 0.9em; }

        .type-in { color: var(--bs-teal); font-weight: 600; }
        .type-out { color: var(--bs-danger); font-weight: 600; }

        .stock-flow-summary {
            font-family: 'Courier New', Courier, monospace;
            font-size: 1.0em;
        }
        .stock-flow-summary .balance {
            font-weight: 700;
            border-top: 1px solid var(--bs-gray-300);
            padding-top: 0.5rem;
            margin-top: 0.5rem;
        }
        .transaction-details {
             border-left: 3px solid var(--bs-info);
             padding-left: 10px;
             margin: 0.5rem 0;
        }
         .stock-out .transaction-details {
             border-left-color: var(--bs-danger);
         }


        .stock-summary {
            background-color: #fcfcfc;
            border: 1px solid var(--bs-gray-200);
            border-radius: var(--bs-border-radius);
            padding: 0.75rem;
        }
        .stock-summary h4 {
            margin: 0 0 0.5rem 0;
            font-size: 0.9em;
            font-weight: 600;
        }
        .stock-summary ul {
            list-style: none; padding: 0; margin: 0;
            font-family: 'Courier New', Courier, monospace; font-size: 0.9em;
            max-height: 250px; overflow-y: auto;
        }
        .stock-summary .total-stock {
            font-weight: 700; font-size: 1.1em;
            border-top: 2px solid var(--bs-gray-400);
            margin-top: 0.5rem; padding-top: 0.5rem;
        }
        .live-calc {
            font-family: 'Courier New', Courier, monospace;
            font-size: 1.1em;
        }
        .live-issue-details div {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.9em;
            margin-top: 0.25rem;
        }
        /* Custom Dropdown Styles */
        .custom-dropdown {
            position: relative;
        }
        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1056; /* Higher z-index for modals */
            display: none;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        }
        .custom-dropdown-menu.show {
            display: block;
        }
        .custom-dropdown-item {
            display: block;
            width: 100%;
            padding: .5rem 1rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: pointer;
        }
        .custom-dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-search-input {
            padding: .5rem;
        }
        .new-entry-row .dropdown-search-input {
            padding: .375rem .75rem;
        }
        #historyModal .table {
            font-size: 0.9em;
        }
        /* Styles for Header Filters */
        .table-dark th {
            position: relative;
        }
        .th-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-dropdown .dropdown-menu {
            padding: 1rem;
            min-width: 320px;
        }
        .filter-dropdown .dropdown-toggle::after {
            display: none; /* Hide default caret */
        }
         .filter-icon {
            color: #adb5bd;
            cursor: pointer;
            font-size: 1.1em;
        }
        .filter-icon:hover {
            color: #fff;
        }
        .header-controls {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .mobile-toggle-btn {
            display: none;
        }

        /* =================================== */
        /* ===== MOBILE CARD VIEW STYLES ===== */
        /* =================================== */
        @media (max-width: 992px) {
            .card {
                display: flex;
                flex-direction: column;
                height: calc(100vh - 120px);
            }
            .card-header {
                position: sticky;
                top: 0;
                z-index: 1020;
            }
             .card-body {
                overflow-y: auto;
                flex-grow: 1;
            }
            .card-footer {
                flex-shrink: 0;
            }
            .table-responsive thead {
                display: none;
            }
            .table-responsive tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--bs-border-color);
                border-radius: var(--bs-card-border-radius);
                box-shadow: var(--bs-box-shadow-sm);
                background-color: var(--bs-body-bg);
            }
            .table-bordered {
                border: 0;
            }
            .table-responsive td {
                display: block;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid var(--bs-border-color-translucent);
            }
            .table-responsive td:last-child {
                border-bottom: none;
            }
            .table-responsive td:first-child {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                font-weight: 600;
                background-color: var(--bs-light);
            }
            .table-responsive .opening-stock-summary,
            .table-responsive .stock-flow-summary,
            .table-responsive .closing-stock-summary {
                position: relative;
                padding-top: 3rem;
            }
            .table-responsive .opening-stock-summary::before,
            .table-responsive .stock-flow-summary::before,
            .table-responsive .closing-stock-summary::before,
            .table-responsive .transaction-in-details::before,
            .table-responsive .transaction-out-details::before,
            .table-responsive .actions::before {
                content: attr(data-label);
                display: block;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: var(--bs-secondary-color);
            }
            .table-responsive .opening-stock-summary::before,
            .table-responsive .stock-flow-summary::before,
            .table-responsive .closing-stock-summary::before {
                position: absolute;
                top: 0.9rem;
                left: 1rem;
                margin-bottom: 0;
            }
            .table-responsive .opening-stock-summary::before { content: "Opening Stock"; }
            .table-responsive .stock-flow-summary::before { content: "Stock Flow & Summary"; }
            .table-responsive .closing-stock-summary::before { content: "Closing Stock"; }
            .table-responsive .transaction-in-details::before { content: "Transaction In Details"; }
            .table-responsive .transaction-out-details::before { content: "Transaction Out Details"; }
            .table-responsive .actions::before { content: "Actions"; }
            .table-responsive .transaction-in-details:empty,
            .table-responsive .transaction-out-details:empty {
                display: none;
            }
            .card-header .header-controls {
                width: 100%;
                margin-top: 0.5rem;
                justify-content: space-between;
            }
            .card-header #universalSearch {
                flex-grow: 1;
            }
            .new-entry-row td {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            .new-entry-row td:first-child {
                flex-direction: column;
                align-items: flex-start;
            }
             .new-entry-row .live-calc, .new-entry-row .balance {
                display: flex;
                justify-content: space-between;
                width: 100%;
            }
            .mobile-toggle-btn {
                display: inline-block;
                position: absolute;
                top: 0.75rem;
                right: 1rem;
                width: 24px;
                height: 24px;
                border: 1px solid #ccc;
                border-radius: 50%;
                background-color: #f0f0f0;
                color: #333;
                font-weight: bold;
                font-size: 1.2rem;
                line-height: 21px;
                text-align: center;
                cursor: pointer;
                z-index: 5;
            }
            .mobile-toggle-btn + .collapsible-content {
                display: none;
            }
            .mobile-toggle-btn.active + .collapsible-content {
                display: block;
            }
            .new-entry-row .actions {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid my-4">
        <header class="text-center mb-4">
            <h1 class="display-5">Advanced Interactive Stock Register</h1>
        </header>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">Stock Ledger</h5>
                <div class="header-controls">
                    <input type="search" class="form-control form-control-sm" id="universalSearch" placeholder="Search anything...">
                    <button id="refreshButton" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-clockwise"></i></button>
                    <button class="btn btn-secondary btn-sm d-lg-none" data-bs-toggle="modal" data-bs-target="#mobileFilterModal"><i class="bi bi-funnel-fill"></i></button>
                    <button id="exportButton" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i><span class="d-none d-lg-inline ms-1">Export</span></button>
                    <button id="addNewButton" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i><span class="d-none d-lg-inline ms-1">Add New Entry</span></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    <div class="th-content">
                                        <span>Date & Item Details</span>
                                        <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form class="filter-form">
                                                    <div class="mb-3">
                                                        <label class="form-label">Transaction Date</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">From</span>
                                                            <input type="date" name="dateFrom" class="form-control">
                                                            <span class="input-group-text">To</span>
                                                            <input type="date" name="dateTo" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" name="productName" class="form-control dropdown-search-input" placeholder="Search product..." autocomplete="off">
                                                            <div class="custom-dropdown-menu" id="productFilterDropdown">
                                                                <!-- Dynamic Content -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Opening Stock</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Stock Flow & Summary</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Closing Stock</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Transaction In Details</span>
                                        <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form class="filter-form">
                                                     <div class="mb-3">
                                                        <label class="form-label">Vendor Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" name="vendorName" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                                            <div class="custom-dropdown-menu" id="vendorFilterDropdown">
                                                               <!-- Dynamic Content -->
                                                            </div>
                                                        </div>
                                                     </div>
                                                     <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Transaction Out Details</span>
                                         <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form class="filter-form">
                                                    <div class="mb-3">
                                                        <label class="form-label">Issued To</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" name="issuedTo" class="form-control dropdown-search-input" placeholder="Search recipient..." autocomplete="off">
                                                            <div class="custom-dropdown-menu" id="recipientFilterDropdown">
                                                                <!-- Dynamic Content -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="stockTableBody"></tbody>
                    </table>
                </div>
            </div>
             <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <label for="rowsPerPageSelect" class="form-label me-2 mb-0">Show</label>
                    <select class="form-select form-select-sm" id="rowsPerPageSelect" style="width: auto;">
                        <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                    </select>
                    <span class="ms-2" id="entriesInfo"></span>
                </div>
                <nav><ul class="pagination pagination-sm mb-0" id="paginationControls"></ul></nav>
            </div>
        </div>
    </div>

    <!-- Mobile Filter Modal -->
    <div class="modal fade" id="mobileFilterModal" tabindex="-1" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mobileFilterModalLabel">Filter Entries</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <form id="mobileFilterForm">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <div class="custom-dropdown">
                                <input type="text" name="productName" class="form-control dropdown-search-input" placeholder="Search product..." autocomplete="off">
                                <div class="custom-dropdown-menu" id="mobileProductFilterDropdown">
                                     <!-- Dynamic Content -->
                                </div>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Vendor Name</label>
                             <div class="custom-dropdown">
                                <input type="text" name="vendorName" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                <div class="custom-dropdown-menu" id="mobileVendorFilterDropdown">
                                   <!-- Dynamic Content -->
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Issued To</label>
                            <div class="custom-dropdown">
                                <input type="text" name="issuedTo" class="form-control dropdown-search-input" placeholder="Search recipient..." autocomplete="off">
                                <div class="custom-dropdown-menu" id="mobileRecipientFilterDropdown">
                                    <!-- Dynamic Content -->
                                </div>
                            </div>
                        </div>
                     </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="mobileResetButton">Reset</button>
                    <button type="button" class="btn btn-primary" id="mobileApplyButton">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="historyModalLabel">Stock History for...</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light"><tr><th>Date & Time</th><th>Transaction</th><th class="text-end">Qty In</th><th class="text-end">Qty Out</th><th class="text-end">Balance</th><th>Details</th></tr></thead>
                        <tbody id="historyModalBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
 </script>
<script>
    
            document.addEventListener('DOMContentLoaded', function() {
        fetch("{{route('get.data.interactive.stock.register')}}")
            .then(response => response.json())
            .then(res => {
                console.log("Backend Data:", res);
    
                    loadInitialData(res.data,res.departments);  
            })
        
        .catch(error => console.error("Error fetching stock data:", error));
    });
    
     
    function loadInitialData(data,departments){
   let initialData = data;
        
    // document.addEventListener('DOMContentLoaded', function() {
        const stockTableBody = document.getElementById('stockTableBody');
        const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
        const mobileFilterModal = new bootstrap.Modal(document.getElementById('mobileFilterModal'));
        const historyModalLabel = document.getElementById('historyModalLabel');
        const historyModalBody = document.getElementById('historyModalBody');
        const universalSearch = document.getElementById('universalSearch');
        const refreshButton = document.getElementById('refreshButton');
        const exportButton = document.getElementById('exportButton');
        const rowsPerPageSelect = document.getElementById('rowsPerPageSelect');
        const paginationControls = document.getElementById('paginationControls');
        const entriesInfo = document.getElementById('entriesInfo');
        
        let allRows = [], filteredRows = [], currentPage = 1, rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
        let currentFilters = {};



  
        console.log("initialDatainitialData",initialData)
        const calculateAllBatchBalances = (rowsToConsider) => {
            const batches = {};
            rowsToConsider.forEach(row => {
                if (!row.dataset.itemName) return;
                if (row.dataset.issuedFrom) {
                    const issuedBatches = JSON.parse(row.dataset.issuedFrom);
                    issuedBatches.forEach(batchInfo => {
                        if (!batches[batchInfo.batchNumber]) batches[batchInfo.batchNumber] = { ...batchInfo, itemName: row.dataset.itemName, unit: row.dataset.unit, balance: 0 };
                        batches[batchInfo.batchNumber].balance -= parseFloat(batchInfo.quantity);
                    });
                } else {
                    const batchNum = row.dataset.batchNumber;
                    if (!batches[batchNum]) batches[batchNum] = { ...row.dataset, balance: 0, receivingQty: row.dataset.class === 'stock-in' ? parseFloat(row.dataset.quantity) : 0 };
                    batches[batchNum].balance += parseFloat(row.dataset.quantity);
                }
            });
            return Object.values(batches);
        };
        const findLastRowByItemName = (name) => allRows.filter(row => row.dataset.itemName === name).pop();
        const recalculateUIForItem = (itemName) => {
            const allItemRows = allRows.filter(row => row.dataset.itemName === itemName).sort((a, b) => (a.dataset.datetime).localeCompare(b.dataset.datetime));
            let runningTotal = 0, processedRows = [];
            allItemRows.forEach(row => {
                const quantity = parseFloat(row.dataset.quantity), unit = row.dataset.unit;
                const openingBalances = calculateAllBatchBalances(processedRows);
                row.querySelector('.opening-stock-summary').innerHTML = `<button class="mobile-toggle-btn" aria-expanded="false">+</button><div class="collapsible-content">${generateBatchSummaryHTML(itemName, openingBalances, 'Opening Batches')}</div>`;
                const openingStockForItem = openingBalances.reduce((sum, batch) => sum + batch.balance, 0);
                let transactionText = '';
                if (row.dataset.issuedFrom) {
                    const issuedBatches = JSON.parse(row.dataset.issuedFrom);
                    let breakdownHTML = issuedBatches.map(b => `<div class="text-muted small border-start ps-2 mb-1">- ${b.quantity.toFixed(2)} ${unit} from <strong>${b.batchNumber}</strong><div>Vendor: ${b.vendorName} | Mfg: ${b.mfgDate} | Exp: ${b.expDate}</div><div>Received: ${b.receivingDate} (${parseFloat(b.receivingQty).toFixed(2)} ${unit})</div></div>`).join('');
                    transactionText = `<div class="transaction-details"><div>Issued: ${(-quantity).toFixed(2)} ${unit}</div>${breakdownHTML}</div>`;
                } else {
                      const actionText = quantity < 0 ? 'Issued' : 'Received';

                    transactionText = `<div class="transaction-details stock-in"><div>${actionText}: ${Math.abs(quantity).toFixed(2)} ${unit}</div>
                    <div class="text-muted small">Vendor: ${row.dataset.fromTo} | Batch: <strong>${row.dataset.batchNumber}</strong> | Mfg: ${row.dataset.mfgDate} | Exp: ${row.dataset.expDate}</div>
                    </div>`;
                    // transactionText = `<div class="transaction-details stock-in"><div>Received: ${quantity.toFixed(2)} ${unit}</div>
                    // <div class="text-muted small">Vendor: ${row.dataset.fromTo} | Batch: <strong>${row.dataset.batchNumber}</strong> | Mfg: ${row.dataset.mfgDate} | Exp: ${row.dataset.expDate}</div>
                    // </div>`;
                }
                runningTotal += quantity;
                const rowsForClosingSummary = [...processedRows, row];
                const closingBalances = calculateAllBatchBalances(rowsForClosingSummary);
                row.querySelector('.closing-stock-summary').innerHTML = `<button class="mobile-toggle-btn" aria-expanded="false">+</button><div class="collapsible-content">${generateBatchSummaryHTML(itemName, closingBalances, 'Closing Batches')}</div>`;
                const stockFlowHTML = `<div>Opening Stock: ${openingStockForItem.toFixed(2)} ${unit}</div>${transactionText}<div class="balance">Balance: ${runningTotal.toFixed(2)} ${unit}</div>`;
                row.querySelector('.stock-flow-summary').innerHTML = `<button class="mobile-toggle-btn" aria-expanded="false">+</button><div class="collapsible-content">${stockFlowHTML}</div>`;
                processedRows.push(row);
            });
        };
        const generateBatchSummaryHTML = (itemName, balances, title) => {
            const unit = findLastRowByItemName(itemName)?.dataset.unit || 'unit';
            let totalStock = 0, listItemsHTML = '';
            balances.sort((a,b) => new Date(a.expDate) - new Date(b.expDate)).forEach(batch => {
                if (batch.balance > 0.001) {
                    listItemsHTML += `<li class="border-bottom py-1"><div class="d-flex justify-content-between"><span>${batch.batchNumber}:</span><strong>${batch.balance.toFixed(2)} ${unit}</strong></div><div class="text-muted small">Vendor: ${batch.fromTo || batch.vendorName} | Brand: ${batch.brandName}</div><div class="text-muted small">Mfg: ${batch.mfgDate} | Exp: ${batch.expDate}</div><div class="text-muted small">Received: ${batch.datetime || batch.receivingDate} (${parseFloat(batch.receivingQty).toFixed(2)} ${unit})</div></li>`;
                    totalStock += batch.balance;
                }
            });
            if (listItemsHTML === '') listItemsHTML = '<li>No existing stock for this item.</li>';
            return `<div class="stock-summary"><h4>${title}</h4><ul>${listItemsHTML}<li class="total-stock d-flex justify-content-between"><span>TOTAL:</span> <strong>${totalStock.toFixed(2)} ${unit}</strong></li></ul></div>`;
        };
        const showHistoryModal = (itemName) => {
            const unit = findLastRowByItemName(itemName)?.dataset.unit || 'unit';
            historyModalLabel.textContent = `Stock History for: ${itemName}`;
            historyModalBody.innerHTML = '';
            const allItemRows = allRows.filter(row => row.dataset.itemName === itemName).sort((a, b) => (a.dataset.datetime).localeCompare(b.dataset.datetime));
            let balance = 0;
            allItemRows.forEach(row => {
                const data = row.dataset, quantity = parseFloat(data.quantity);
                balance += quantity;
                let qtyIn = '', qtyOut = '', details = '', transactionType = '';
                if (quantity > 0) {
                    qtyIn = `${quantity.toFixed(2)} ${unit}`; transactionType = `<span class="type-in">IN</span>`; details = `From: <strong>${data.fromTo}</strong> (Batch: ${data.batchNumber})`;
                } else {
                    qtyOut = `${(-quantity).toFixed(2)} ${unit}`; transactionType = `<span class="type-out">OUT</span>`;
                    const breakdown = JSON.parse(data.issuedFrom).map(b => `${b.quantity.toFixed(2)} from ${b.batchNumber}`).join(', ');
                    details = `To: <strong>${data.fromTo}</strong> (${breakdown})`;
                }
                historyModalBody.innerHTML += `<tr><td>${data.datetime}</td><td>${transactionType}</td><td class="text-end">${qtyIn}</td><td class="text-end">${qtyOut}</td><td class="text-end"><strong>${balance.toFixed(2)} ${unit}</strong></td><td>${details}</td></tr>`;
            });
            historyModal.show();
        };
        document.getElementById('addNewButton').addEventListener('click', () => {
            const existingNewRow = document.querySelector('.new-entry-row');
            if (existingNewRow) existingNewRow.remove();
            const allItemNames = [...new Set(allRows.map(row => row.dataset.itemName).filter(Boolean))];
            const allIssuedTo = [...new Set(allRows.filter(row => row.classList.contains('stock-out')).map(row => row.dataset.fromTo).filter(Boolean))];

         const issuedToDropdownHTML = `
                <div class="custom-dropdown">
                    <input type="text" name="supplierOrIssuedTo" class="form-control form-control-sm dropdown-search-input" placeholder="Select or type recipient..." required autocomplete="off">
                    <div class="custom-dropdown-menu">
                        ${departments.map(dep => `
                    <a class="custom-dropdown-item" href="#" data-id="${dep.name}">
                        ${dep.name}
                    </a>
                `).join('')}
                    </div>
                </div>`;
                //  ${createDropdownHTML(`supplierOrIssuedTo_${type}`, "Select or type recipient...", allIssuedTo)}
                
                //   ${issuedToDropdownHTML}

            const createDropdownHTML = (name, placeholder, items) => `
                <div class="custom-dropdown">
                    <input type="text" name="${name}" class="form-control form-control-sm dropdown-search-input" placeholder="${placeholder}" required autocomplete="off">
                    <div class="custom-dropdown-menu">
                        ${items.map(item => `<a class="custom-dropdown-item" href="#">${item}</a>`).join('')}
                    </div>
                </div>`;
                
                     const createDropdownHTML1 = (name, placeholder, items) => `
                <div class="custom-dropdown">
                    <input type="text" name="${name}" class="form-control form-control-sm dropdown-search-input" placeholder="${placeholder}" required autocomplete="off">
                    <div class="custom-dropdown-menu">
                        ${departments.map(dep => `<a class="custom-dropdown-item" href="#"  data-id="${dep.name}"> ${dep.name}</a>`).join('')}
                    </div>
                </div>`;
                

            const itemNameInputHTML = (type) => `
                <div class="input-group-container">
                    <label class="form-label small">Item Name</label>
                    ${createDropdownHTML(`itemName_${type}`, "Select or type item...", allItemNames)}
                </div>`;

            const quantityInputHTML = (type) => `
                <div class="input-group-container">
                    <label class="form-label small">Issued Quantity</label>
                    <div class="input-group input-group-sm">
                        <input type="number" name="quantity_${type}" class="form-control" required>
                        <span class="input-group-text unit-display">--</span>
                    </div>
                </div>`;
            
            const issuedToInputHTML = (type) => `
                <div class="input-group-container">
                    <label class="form-label small">Issued To</label>
                    
                      ${createDropdownHTML1(`supplierOrIssuedTo_${type}`, "Select or type recipient...", allIssuedTo)}
                </div>`;

            const actionButtonsHTML = `
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm save-btn w-50">Save</button>
                    <button class="btn btn-danger btn-sm cancel-btn w-50">Cancel</button>
                </div>`;

            const newRow = stockTableBody.insertRow(0);
            newRow.classList.add('table-info', 'new-entry-row');
            
            const now = new Date();
const localTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
    .toISOString()
    .slice(0, 16);
    
                    // <input type="datetime-local" class="form-control form-control-sm" name="datetime" value="${new Date().toISOString().slice(0, 16)}">
            newRow.innerHTML = `
                <td>
                        <input type="datetime-local" class="form-control form-control-sm" name="datetime" value="${localTime}">

                    <hr class="my-2">
                    
                    <!-- Mobile-only grouped view -->
                    <div class="d-lg-none d-flex flex-column gap-2">
                        ${itemNameInputHTML('mobile')}
                        ${quantityInputHTML('mobile')}
                        ${issuedToInputHTML('mobile')}
                        ${actionButtonsHTML}
                    </div>

                    <!-- Desktop-only view -->
                    <div class="d-none d-lg-block">${itemNameInputHTML('web')}</div>
                </td>
                <td class="live-summary-container align-top"></td>
                <td>
                    <div class="d-none d-lg-block">${quantityInputHTML('web')}</div>
                    <hr>
                    <div class="live-calc text-primary">Opening Stock: <strong class="live-opening text-dark">--</strong></div>
                    <div class="live-issue-details my-2"></div>
                    <div class="live-calc text-danger balance">New Balance: <strong class="live-balance text-dark">--</strong></div>
                </td>
                <td class="live-closing-stock-summary align-top"></td>
                <td class="transaction-in-details"></td>
                <td class="transaction-out-details">
                    <div class="d-none d-lg-block">${issuedToInputHTML('web')}</div>
                </td>
                <td class="actions">
                    <button class="btn btn-success btn-sm save-btn">Save</button>
                    <button class="btn btn-danger btn-sm cancel-btn">Cancel</button>
                </td>`;

            // Sync duplicated inputs
            ['itemName', 'quantity', 'supplierOrIssuedTo'].forEach(name => {
                const webInput = newRow.querySelector(`[name=${name}_web]`);
                const mobileInput = newRow.querySelector(`[name=${name}_mobile]`);
                
                const syncValues = (source, target) => {
                    if (target.value !== source.value) {
                        target.value = source.value;
                        target.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                };
                
                webInput.addEventListener('input', () => syncValues(webInput, mobileInput));
                mobileInput.addEventListener('input', () => syncValues(mobileInput, webInput));
            });
        });
        
        stockTableBody.addEventListener('input', function(event) {
            const target = event.target;
            const tempRow = target.closest('.new-entry-row');
            if (!tempRow) return;

            const name = target.name.replace('_web', '').replace('_mobile', '');
            if (name !== 'itemName' && name !== 'quantity') return;

            const itemName = tempRow.querySelector('[name="itemName_web"]').value;
            const quantityToIssue = parseFloat(tempRow.querySelector('[name="quantity_web"]').value) || 0;
            
            const openingStockCell = tempRow.querySelector('.live-summary-container');
            const closingStockCell = tempRow.querySelector('.live-closing-stock-summary');
            const unitDisplays = tempRow.querySelectorAll('.unit-display');
            const liveOpeningText = tempRow.querySelector('.live-opening');
            const liveBalanceText = tempRow.querySelector('.live-balance');
            const liveIssueDetails = tempRow.querySelector('.live-issue-details');

            if (!itemName) {
                openingStockCell.innerHTML = '';
                closingStockCell.innerHTML = '';
                unitDisplays.forEach(el => el.textContent = '--');
                liveOpeningText.textContent = '--';
                liveBalanceText.textContent = '--';
                liveIssueDetails.innerHTML = '';
                return;
            }
            
            const unit = findLastRowByItemName(itemName)?.dataset.unit || 'units';
            const availableBatches = calculateAllBatchBalances(allRows).filter(b => b.itemName === itemName && b.balance > 0.001).sort((a, b) => new Date(a.expDate) - new Date(b.expDate));
            const totalAvailableStock = availableBatches.reduce((sum, batch) => sum + batch.balance, 0);

            unitDisplays.forEach(el => el.textContent = unit);
            liveOpeningText.textContent = `${totalAvailableStock.toFixed(2)} ${unit}`;
            liveIssueDetails.innerHTML = '';

            const openingStockHTML = generateBatchSummaryHTML(itemName, availableBatches, 'Current Batches');
            openingStockCell.innerHTML = openingStockHTML;

            if (quantityToIssue > 0) {
                if (quantityToIssue > totalAvailableStock) {
                    liveBalanceText.textContent = 'ERROR';
                    closingStockCell.innerHTML = '<div class="stock-summary text-danger p-2">Error: Insufficient stock.</div>';
                } else {
                    liveBalanceText.textContent = `${(totalAvailableStock - quantityToIssue).toFixed(2)} ${unit}`;
                    
                    let remainingQtyToIssue = quantityToIssue;
                    let breakdownHTML = '';
                    const closingBatches = JSON.parse(JSON.stringify(availableBatches));

                    for (const batch of closingBatches) {
                        if (remainingQtyToIssue <= 0) break;
                        const qtyFromThisBatch = Math.min(remainingQtyToIssue, batch.balance);
                        
                        breakdownHTML += `<div class="text-muted small">- ${qtyFromThisBatch.toFixed(2)} ${unit} from <strong>${batch.batchNumber}</strong></div>`;
                        batch.balance -= qtyFromThisBatch;
                        remainingQtyToIssue -= qtyFromThisBatch;
                    }

                    liveIssueDetails.innerHTML = breakdownHTML;
                    const closingStockHTML = generateBatchSummaryHTML(itemName, closingBatches, 'Resulting Batches');
                    closingStockCell.innerHTML = closingStockHTML;
                }
            } else {
                liveBalanceText.textContent = '--';
                closingStockCell.innerHTML = openingStockHTML;
            }
        });

        stockTableBody.addEventListener('click', function(event) {
            const target = event.target;
            
            // Mobile toggle
            if (target.classList.contains('mobile-toggle-btn')) {
                const parentCard = target.closest('tr'), currentlyActive = target.classList.contains('active');
                parentCard.querySelectorAll('.mobile-toggle-btn').forEach(btn => {
                    btn.classList.remove('active'); btn.textContent = '+'; btn.setAttribute('aria-expanded', 'false');
                });
                if (!currentlyActive) { target.classList.add('active'); target.textContent = '−'; target.setAttribute('aria-expanded', 'true'); }
                return;
            }

            // Cancel button
            if (target.classList.contains('cancel-btn')) { 
                target.closest('tr').remove(); 
            }
            
            // History button
            if (target.classList.contains('history-btn')) { 
                if (target.closest('tr').dataset.itemName) showHistoryModal(target.closest('tr').dataset.itemName);
            }

            // --- START: NEW DELETE LOGIC ---
            // if (target.classList.contains('delete-btn')) {
            //     const rowToDelete = target.closest('tr');
            //     alert(rowToDelete.dataset.itemId)
            //     if (confirm('Are you sure you want to delete this transaction? This action cannot be undone.')) {
            //         const itemName = rowToDelete.dataset.itemName;
                    
            //         // Find and remove the row from the master data array
            //         const rowIndex = allRows.findIndex(row => row === rowToDelete);
            //         if (rowIndex > -1) {
            //             allRows.splice(rowIndex, 1);
            //         }
                    
            //         // Recalculate UI for the affected item
            //         recalculateUIForItem(itemName);
                    
            //         // Re-render the entire table to reflect the deletion and recalculations
            //         renderTable();
            //     }
            // }
            // --- END: NEW DELETE LOGIC ---

            // Save button
            if (!target.classList.contains('save-btn')) return;
            event.preventDefault();

            const tempRow = target.closest('tr');
            let datetimeValue = tempRow.querySelector('[name="datetime"]').value;
            const itemName = tempRow.querySelector('[name="itemName_web"]').value, 
                  quantityToIssue = parseFloat(tempRow.querySelector('[name="quantity_web"]').value), 
                  issuedTo = tempRow.querySelector('[name="supplierOrIssuedTo_web"]').value, 
                  unit = tempRow.querySelector('.unit-display').textContent;
            
            if (!itemName || !quantityToIssue || !issuedTo || unit === '--' || !datetimeValue) { 
                alert('Please fill all required fields, including date and time.'); 
                return; 
            }
            if (quantityToIssue <= 0) { 
                alert('Issued quantity must be greater than zero.'); 
                return; 
            }

            const datetime = datetimeValue.replace('T', ' '); // Format for consistency

            const availableBatches = calculateAllBatchBalances(allRows).filter(b => b.itemName === itemName && b.balance > 0.001).sort((a, b) => new Date(a.expDate) - new Date(b.expDate));
            const totalAvailableStock = availableBatches.reduce((sum, batch) => sum + batch.balance, 0);
            
            if (quantityToIssue > totalAvailableStock) { 
                alert(`Error: Cannot issue ${quantityToIssue} ${unit}. Only ${totalAvailableStock.toFixed(2)} ${unit} is available.`); 
                return; 
            }

            let remainingQtyToIssue = quantityToIssue;
            const issuedBatchesDetails = [];
            const lastItemId = (findLastRowByItemName(itemName)?.dataset.itemId) || (itemName.slice(0,3).toUpperCase() + Date.now().toString().slice(-3));

          for (const batch of availableBatches) {
                // alert(JSON.stringify(batch, null, 2));
                if (remainingQtyToIssue <= 0) break;
            
                const qtyFromThisBatch = Math.min(remainingQtyToIssue, batch.balance);
                const remainingBalance = batch.balance - qtyFromThisBatch;
            
                issuedBatchesDetails.push({
                    batchNumber: batch.batchNumber,
                    quantityIssued: qtyFromThisBatch,
                    remainingBalance: remainingBalance,
                    vendorName: batch.fromTo,
                    receivingDate: batch.datetime
                });
            
                remainingQtyToIssue -= qtyFromThisBatch;
            }
            
            // Dynamic batch number string
            const batchNumbersString = issuedBatchesDetails.map(b => b.batchNumber).join(', ');
            const vendorNamesString = issuedBatchesDetails.map(b => b.vendorName).join(', ');

            const postData = {
                itemId: lastItemId,
                itemName: itemName,
                batchNumber: batchNumbersString,  
                unit: unit,
                quantity: quantityToIssue,
                issuedTo: issuedTo,
                datetime: datetime,
                  vendorName: vendorNamesString, 
                issuedFrom: issuedBatchesDetails 
            };

        $.ajax({
            url: "{{route('stock.issue.save')}}", 
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                if(response.success){
                      toastr.success(response.message || "Stock issued successfully!");
                      setTimeout(()=>{
                          location.reload()
                      },2000)
                } else {
                       toastr.error('Error saving stock: ' + response.message);
                }
            },
            error: function(xhr, status, error){
                console.error(error);
                 toastr.error('Unable to issue stock.');
            }
        });
         

            // for (const batch of availableBatches) {
            //     if (remainingQtyToIssue <= 0) break;
            //     const qtyFromThisBatch = Math.min(remainingQtyToIssue, batch.balance);
            //     issuedBatchesDetails.push({ ...batch, quantity: qtyFromThisBatch, vendorName: batch.fromTo, receivingDate: batch.datetime });
            //     remainingQtyToIssue -= qtyFromThisBatch;
            // }

            const newSavedRow = document.createElement('tr');
            newSavedRow.className = 'stock-out';
            Object.assign(newSavedRow.dataset, { itemName: itemName, batchNumber: 'Mixed', unit: unit, quantity: -quantityToIssue, fromTo: issuedTo, datetime: datetime, issuedFrom: JSON.stringify(issuedBatchesDetails) });
            
            newSavedRow.innerHTML = `<td><div>${datetime}</div><div class="item-details mt-2"><div class="item-name">${itemName}</div></div>
            </td><td class="opening-stock-summary"></td><td class="stock-flow-summary"></td><td class="closing-stock-summary"></td>
            <td class="transaction-in-details"></td><td class="transaction-out-details"><div class="type-out mb-2">STOCK OUT</div><div>To: 
            <strong>${issuedTo}</strong></div></td><td class="actions"><button class="btn btn-info btn-sm history-btn">History</button><button class="btn btn-danger btn-sm delete-btn ms-1" data-id="${mainId}">Delete</button></td>`;
            
            allRows.push(newSavedRow); 
            tempRow.remove(); 
            recalculateUIForItem(itemName); 
            renderTable();
            
            // allRows.unshift(newSavedRow); // Changed .push() to .unshift()
            // tempRow.remove(); 
            // recalculateUIForItem(itemName); 
            // renderTable();

        });
        
        const applyFiltersAndSearch = () => {
            let tempRows = [...allRows];

            // Apply column filters
            if (currentFilters.productName) {
                tempRows = tempRows.filter(row => row.dataset.itemName === currentFilters.productName);
            }
            if (currentFilters.vendorName) {
                tempRows = tempRows.filter(row => row.classList.contains('stock-in') && row.dataset.fromTo === currentFilters.vendorName);
            }
            if (currentFilters.issuedTo) {
                 tempRows = tempRows.filter(row => row.classList.contains('stock-out') && row.dataset.fromTo === currentFilters.issuedTo);
            }
            if (currentFilters.dateFrom) {
                 tempRows = tempRows.filter(row => row.dataset.datetime.slice(0, 10) >= currentFilters.dateFrom);
            }
            if (currentFilters.dateTo) {
                 tempRows = tempRows.filter(row => row.dataset.datetime.slice(0, 10) <= currentFilters.dateTo);
            }
            
            // Apply universal search on top of filters
            const searchTerm = universalSearch.value.toLowerCase();
            if (searchTerm) {
                tempRows = tempRows.filter(row => 
                    row.textContent.toLowerCase().includes(searchTerm) || 
                    Object.values(row.dataset).join(' ').toLowerCase().includes(searchTerm)
                );
            }

            filteredRows = tempRows;
            filteredRows.sort((a, b) => (b.dataset.datetime).localeCompare(a.dataset.datetime));
        };
        // const renderPagination = () => {
        //     paginationControls.innerHTML = '';
        //     const totalEntries = filteredRows.length, totalPages = Math.ceil(totalEntries / rowsPerPage);
        //     const startEntry = totalEntries === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1, endEntry = Math.min(currentPage * rowsPerPage, totalEntries);
        //     entriesInfo.textContent = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;
        //     if (totalPages <= 1) return;
        //     paginationControls.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`;
        //     for (let i = 1; i <= totalPages; i++) paginationControls.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        //     paginationControls.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`;
        // };
    
    
       const renderPagination = () => {
            paginationControls.innerHTML = '';
            const totalEntries = filteredRows.length;
            const totalPages = Math.ceil(totalEntries / rowsPerPage);
            const startEntry = totalEntries === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1;
            const endEntry = Math.min(currentPage * rowsPerPage, totalEntries);
        
            entriesInfo.textContent = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;
        
            if (totalPages <= 1) return;
        
            const addPage = (page, label = page, active = false, disabled = false) => {
                paginationControls.innerHTML += `
                    <li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${page}">${label}</a>
                    </li>`;
            };
        
            addPage(currentPage - 1, 'Previous', false, currentPage === 1);
        
            const maxVisible = 5; // middle numbers
        
            if (totalPages <= 10) {
                for (let i = 1; i <= totalPages; i++) {
                    addPage(i, i, currentPage === i);
                }
            } else {
                addPage(1, '1', currentPage === 1);
                addPage(2, '2', currentPage === 2);
        
                if (currentPage > 4) {
                    paginationControls.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
        
                const start = Math.max(3, currentPage - 2);
                const end = Math.min(totalPages - 2, currentPage + 2);
        
                for (let i = start; i <= end; i++) {
                    addPage(i, i, currentPage === i);
                }
        
                if (currentPage < totalPages - 3) {
                    paginationControls.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
        
                addPage(totalPages - 1, totalPages - 1, currentPage === totalPages - 1);
                addPage(totalPages, totalPages, currentPage === totalPages);
            }
        
            addPage(currentPage + 1, 'Next', false, currentPage === totalPages);
        };
    
        
        const renderTable = () => {
            applyFiltersAndSearch(); renderPagination(); stockTableBody.innerHTML = '';
            const pageRows = filteredRows.slice((currentPage - 1) * rowsPerPage, (currentPage - 1) * rowsPerPage + rowsPerPage);
            pageRows.forEach(row => stockTableBody.appendChild(row));
        };
        universalSearch.addEventListener('input', () => { currentPage = 1; renderTable(); });
        
        function resetAllFilters() {
            currentFilters = {};
            document.querySelectorAll('.filter-form, #mobileFilterForm').forEach(form => form.reset());
            universalSearch.value = '';
            currentPage = 1;
            rowsPerPageSelect.value = 10; 
            rowsPerPage = 10;
            renderTable();
        }

        refreshButton.addEventListener('click', resetAllFilters);

        rowsPerPageSelect.addEventListener('change', () => { rowsPerPage = parseInt(rowsPerPageSelect.value, 10); currentPage = 1; renderTable(); });
        paginationControls.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                const page = parseInt(e.target.dataset.page, 10);
                if (page) { currentPage = page; renderTable(); }
            }
        });
        function loadInitialData() {
            console.log("111111111111111111");
            console.log("initialData111",initialData)
            // initialData.forEach(data => {
            //       console.log("data2222",data)
            //     const row = document.createElement('tr');
            //     row.className = data.class;
            //     Object.assign(row.dataset, data);
                
            //     let inHTML = '', outHTML = '', actionsHTML = '';
            //     console.log("data.class",data.class);
            //     // if(data.class == "stock-in") {
            //     // if (data.class.trim().toLowerCase() === "stock-in") {
            //     //     console.log("stockin11")
            //     //     inHTML = `<div class="type-in mb-2">STOCK IN</div><div>From: <strong>${data.fromTo}</strong></div>`;
            //     //     actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>`;
            //     // } else {
            //     //                         console.log("stockout2222")

            //     //     outHTML = `<div class="type-out mb-2">STOCK OUT</div><div>To: <strong>${data.fromTo}</strong></div>`;
            //     //     actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button><button class="btn btn-danger btn-sm delete-btn ms-1">Delete</button>`;
            //     // }
                
            //     const className = (data.class || '').trim().toLowerCase();

            //     console.log("classNameclassName",className)
            //     if (className === "stock-in") {
            //         console.log("✅ stock-in block running");
            //         inHTML = `<div class="type-in mb-2">STOCK IN</div>
            //                   <div>From: <strong>${data.fromTo}</strong></div>`;
            //         actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>`;
            //     } else if (className === "stock-out") {
            //         console.log("✅ stock-out block running");
            //         outHTML = `<div class="type-out mb-2">STOCK OUT</div>
            //                   <div>To: <strong>${data.fromTo}</strong></div>`;
            //         actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>
            //                       <button class="btn btn-danger btn-sm delete-btn ms-1">Delete</button>`;
            //     } else {
            //         console.log("⚠ Unexpected class value:", data.class);
            //     }


            //     row.innerHTML = `<td><div>${data.datetime}</div><div class="item-details mt-2"><div class="item-name">${data.itemName}</div></div></td><td class="opening-stock-summary"></td><td class="stock-flow-summary"></td><td class="closing-stock-summary"></td><td class="transaction-in-details">${inHTML}</td><td class="transaction-out-details">${outHTML}</td><td class="actions">${actionsHTML}</td>`;
               
               
            //   console.log("rowrow",row)
            //     allRows.push(row);
            // });
            
            
            // initialData.forEach(data => {
            //     const row = document.createElement('tr');
            
            //     // Safely assign dataset
            //     Object.keys(data).forEach(key => {
            //         row.dataset[key] = data[key] != null ? data[key] : '';
            //     });
            
            //     const className = (data.class || '').trim().toLowerCase();
            
            //     let inHTML = '', outHTML = '', actionsHTML = '';
            //     if (className === "stock-in") {
            //         inHTML = `<div class="type-in mb-2">STOCK IN</div>
            //                   <div>From: <strong>${data.fromTo}</strong></div>`;
            //         actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>`;
            //     } else if (className === "stock-out") {
            //         outHTML = `<div class="type-out mb-2">STOCK OUT</div>
            //                   <div>To: <strong>${data.fromTo}</strong></div>`;
            //         actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>
            //                       <button class="btn btn-danger btn-sm delete-btn ms-1" data-id="${data.mainId}">Delete</button>`;
            //     }
            
            // // <td><div>${data.datetime}</div>
            // //                          <div class="item-details mt-2">
            // //                              <div class="item-name">${data.itemName}</div>
            // //                          </div>
            // //                      </td>
                                 
            //     row.innerHTML = `<td>
            //                   <input type="datetime-local" class="form-control form-control-sm datetime-input" 
            //                          value="${formatToInputDateTime(data.datetime)}" />
            //                   <div class="item-details mt-2">
            //                     <div class="item-name">${data.itemName}</div>
            //                   </div>
            //                 </td>
            //                      <td class="opening-stock-summary"></td>
            //                      <td class="stock-flow-summary"></td>
            //                      <td class="closing-stock-summary"></td>
            //                      <td class="transaction-in-details">${inHTML}</td>
            //                      <td class="transaction-out-details">${outHTML}</td>
            //                      <td class="actions">${actionsHTML}</td>`;
            
            //     allRows.push(row);
            // });
            
            // function formatToInputDateTime(dateStr) {
            //     const date = new Date(dateStr);
            //     if (isNaN(date)) return ''; // fallback for invalid dates
            
            //     const pad = num => num.toString().padStart(2, '0');
            //     const yyyy = date.getFullYear();
            //     const mm = pad(date.getMonth() + 1);
            //     const dd = pad(date.getDate());
            //     const hh = pad(date.getHours());
            //     const mi = pad(date.getMinutes());
            
            //     return `${yyyy}-${mm}-${dd}T${hh}:${mi}`;
            // }
            function formatToInputDateTime(dateStr) {
                const date = new Date(dateStr);
                if (isNaN(date)) return ''; // fallback for invalid dates
            
                const pad = num => num.toString().padStart(2, '0');
            
                const yyyy = date.getFullYear();
                const mm = pad(date.getMonth() + 1);
                const dd = pad(date.getDate());
                const hh = pad(date.getHours());
                const mi = pad(date.getMinutes());
                const ss = pad(date.getSeconds());
            
                return `${yyyy}-${mm}-${dd}T${hh}:${mi}:${ss}`;
            }


            initialData.forEach(data => {
                const row = document.createElement('tr');
            
                // Set dataset values
                Object.keys(data).forEach(key => {
                    row.dataset[key] = data[key] != null ? data[key] : '';
                });
            
                const className = (data.class || '').trim().toLowerCase();
                let inHTML = '', outHTML = '', actionsHTML = '';
            
                if (className === "stock-in") {
                    inHTML = `<div class="type-in mb-2">STOCK IN</div>
                              <div>From: <strong>${data.fromTo}</strong></div>`;
                    actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>`;
                } else if (className === "stock-out") {
                    outHTML = `<div class="type-out mb-2">STOCK OUT</div>
                               <div>To: <strong>${data.fromTo}</strong></div>`;
                    actionsHTML = `<button class="btn btn-info btn-sm history-btn">History</button>
                                   <button class="btn btn-danger btn-sm delete-btn ms-1" data-id="${data.mainId}">Delete</button>`;
                }
            
                // Main row HTML with editable datetime
                row.innerHTML = `
                    <td>
                        <input type="datetime-local" 
                               step="1"
                               class="form-control form-control-sm datetime-input"
                               value="${formatToInputDateTime(data.datetime)}"
                               data-id="${data.mainId}" 
                               data-variant="${className}" 
                        />

                        <div class="item-details mt-2">
                            <div class="item-name">${data.itemName}</div>
                        </div>
                    </td>
                    <td class="opening-stock-summary"></td>
                    <td class="stock-flow-summary"></td>
                    <td class="closing-stock-summary"></td>
                    <td class="transaction-in-details">${inHTML}</td>
                    <td class="transaction-out-details">${outHTML}</td>
                    <td class="actions">${actionsHTML}</td>
                `;
            
                // Add change listener to datetime input
                const datetimeInput = row.querySelector('.datetime-input');
                datetimeInput.addEventListener('change', (e) => {
                    const newDatetime = e.target.value;
                    const id = e.target.dataset.id;
                    const variant = e.target.dataset.variant;
            // alert(newDatetime)
            // alert(id)
            // alert(variant)
                    // Optional: Update dataset
                    row.dataset.datetime = newDatetime;
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            
                    // AJAX: Send updated datetime to the backend
                    fetch("{{route('update.datetime.stock.issue')}}", {
                        method: 'POST', // or 'PUT'
                         headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                            id: id,
                            variant: variant,
                            datetime: newDatetime
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to update datetime');
                        return response.json();
                    })
                    .then(result => {
                         toastr.options = {
                            "timeOut": "2000",
                            "onHidden": function () {
                                location.reload();
                            }
                        };
                    
                        toastr.success('Datetime updated successfully.');
                        console.log('Server response:', result);
                    })
                    .catch(err => {
                         toastr.error('Error updating datetime.');
                        console.error(err);
                    });
                });
            
                allRows.push(row);
            });



            const allItems = [...new Set(allRows.map(row => row.dataset.itemName))];
            allItems.forEach(item => recalculateUIForItem(item));
            renderTable();
        }
        
        function setupSearchableDropdowns() {
            document.addEventListener('focusin', (e) => {
                if (e.target.classList.contains('dropdown-search-input')) {
                    e.target.nextElementSibling.classList.add('show');
                }
            });

            document.addEventListener('focusout', (e) => {
                if (e.target.classList.contains('dropdown-search-input')) {
                    setTimeout(() => { if(e.target.nextElementSibling) { e.target.nextElementSibling.classList.remove('show'); } }, 200);
                }
            });
            
            document.addEventListener('mousedown', (e) => {
                // alert("oppoass");
                if (e.target.classList.contains('custom-dropdown-item')) {
                    e.preventDefault();
                    const dropdown = e.target.closest('.custom-dropdown');
                    const input = dropdown.querySelector('.dropdown-search-input');
                    input.value = e.target.textContent === 'All' ? '' : e.target.textContent;
                    input.dispatchEvent(new Event('input', { bubbles: true })); 
                    dropdown.querySelector('.custom-dropdown-menu').classList.remove('show');
                }
            });

            document.addEventListener('keyup', (e) => {
                if (e.target.classList.contains('dropdown-search-input')) {
                    const input = e.target;
                    const filter = input.value.toUpperCase();
                    const menu = input.nextElementSibling;
                    const items = menu.getElementsByTagName('a');
                    for (let i = 0; i < items.length; i++) {
                        const txtValue = items[i].textContent || items[i].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) { items[i].style.display = ""; } 
                        else { items[i].style.display = "none"; }
                    }
                }
            });
        }
        function populateFilterDropdowns() {
            const products = [...new Set(allRows.map(row => row.dataset.itemName))].sort();
            const vendors = [...new Set(allRows.filter(row => row.classList.contains('stock-in')).map(row => row.dataset.fromTo))].sort();
            const recipients = [...new Set(allRows.filter(row => row.classList.contains('stock-out')).map(row => row.dataset.fromTo))].sort();

            const productHTML = '<a class="custom-dropdown-item" href="#">All</a>' + products.map(p => `<a class="custom-dropdown-item" href="#">${p}</a>`).join('');
            const vendorHTML = '<a class="custom-dropdown-item" href="#">All</a>' + vendors.map(v => `<a class="custom-dropdown-item" href="#">${v}</a>`).join('');
            const recipientHTML = '<a class="custom-dropdown-item" href="#">All</a>' + recipients.map(r => `<a class="custom-dropdown-item" href="#">${r}</a>`).join('');

            document.getElementById('productFilterDropdown').innerHTML = productHTML;
            document.getElementById('vendorFilterDropdown').innerHTML = vendorHTML;
            document.getElementById('recipientFilterDropdown').innerHTML = recipientHTML;
            document.getElementById('mobileProductFilterDropdown').innerHTML = productHTML;
            document.getElementById('mobileVendorFilterDropdown').innerHTML = vendorHTML;
            document.getElementById('mobileRecipientFilterDropdown').innerHTML = recipientHTML;
        }

        // --- START: XLSX EXPORT LOGIC ---
        function cleanCellForXLSX(cellElement) {
            if (!cellElement) return "";
            const clone = cellElement.cloneNode(true);
            
            clone.querySelector('.mobile-toggle-btn')?.remove();
            clone.querySelector('.history-btn')?.remove();
            
            clone.querySelectorAll('div, li, .balance, .total-stock, h4').forEach(el => {
                if (el.textContent.trim() !== "") {
                     el.append(document.createTextNode('\n'));
                }
            });
             clone.querySelectorAll('hr').forEach(el => {
                el.replaceWith(document.createTextNode('\n------------------\n'));
            });

            let text = clone.textContent || "";
            return text.split('\n').map(line => line.trim()).filter(line => line).join('\n');
        }

        // function exportToXLSX() {
        //     const wb = XLSX.utils.book_new();
        //     const headers = [
        //         "Date & Item Details", "Opening Stock", "Stock Flow & Summary", 
        //         "Closing Stock", "Transaction In Details", "Transaction Out Details"
        //     ];

        //     const products = [...new Set(filteredRows.map(row => row.dataset.itemName))].sort();

        //     if (products.length === 0) {
        //         alert("No data available to export.");
        //         return;
        //     }

        //     products.forEach(product => {
        //         const productRows = filteredRows.filter(row => row.dataset.itemName === product);
        //         const sheetData = [headers];

        //         productRows.forEach(rowEl => {
        //             const cells = Array.from(rowEl.querySelectorAll('td'));
        //             const rowData = [
        //                 cleanCellForXLSX(cells[0]), cleanCellForXLSX(cells[1]),
        //                 cleanCellForXLSX(cells[2]), cleanCellForXLSX(cells[3]),
        //                 cleanCellForXLSX(cells[4]), cleanCellForXLSX(cells[5])
        //             ];
        //             sheetData.push(rowData);
        //         });

        //         const ws = XLSX.utils.aoa_to_sheet(sheetData);
                
        //         const colWidths = [
        //             { wch: 25 }, // Date & Item
        //             { wch: 40 }, // Opening Stock
        //             { wch: 40 }, // Stock Flow
        //             { wch: 40 }, // Closing Stock
        //             { wch: 30 }, // Txn In
        //             { wch: 30 }  // Txn Out
        //         ];
        //         ws['!cols'] = colWidths;
                
        //         const sheetName = product.replace(/[\\/*?:"<>|]/g, "").substring(0, 31);
        //         XLSX.utils.book_append_sheet(wb, ws, sheetName);
        //     });

        //     XLSX.writeFile(wb, "stock_register.xlsx");
        // }
      
      
      function exportToXLSX() {
        const wb = XLSX.utils.book_new();
    
        const headers = [
            "Date & Item Details", 
            "Opening Stock", 
            "Stock Flow & Summary",
            "Closing Stock", 
            "Transaction In Details", 
            "Transaction Out Details"
        ];
    
        const products = [...new Set(filteredRows.map(row => row.dataset.itemName))].sort();
    
        if (products.length === 0) {
            alert("No data available to export.");
            return;
        }
    
    //   function getCellValue(cell) {
    //     const input = cell.querySelector("input[type='datetime-local']");
    //     const inputValue = input ? input.value : "";
    
    //     let formattedDate = "";
    //     if (inputValue) {
    //         const dt = new Date(inputValue);
    
    //         formattedDate = dt.toLocaleString("en-US", {
    //             day: "2-digit",
    //             month: "short",
    //             year: "numeric",
    //             hour: "numeric",
    //             minute: "2-digit",
    //             hour12: true
    //         });
    //     }
    
    //     const itemNameEl = cell.querySelector(".item-name");
    //     const itemName = itemNameEl ? itemNameEl.innerText.trim() : "";
    
    //     if (formattedDate && itemName) return `${formattedDate} - ${itemName}`;
    //     if (formattedDate) return formattedDate;
    //     if (itemName) return itemName;
    
    //     return cell.innerText.trim();
    // }

function getCellValue(cell) {
    const input = cell.querySelector("input[type='datetime-local']");
    let inputValue = input ? input.value : "";

    // Convert "2025-11-17T18:49:01" → "2025-11-17 18:49:01"
    if (inputValue) {
        inputValue = inputValue.replace("T", " ");
    }

    const itemNameEl = cell.querySelector(".item-name");
    const itemName = itemNameEl ? itemNameEl.innerText.trim() : "";

    if (inputValue && itemName) return `${inputValue} - ${itemName}`;
    if (inputValue) return inputValue;
    if (itemName) return itemName;

    return cell.innerText.trim();
}


    products.forEach(product => {
        const productRows = filteredRows.filter(row => row.dataset.itemName === product);
        const sheetData = [headers];

        productRows.forEach(rowEl => {
            const cells = Array.from(rowEl.querySelectorAll('td'));

            const rowData = [
                getCellValue(cells[0]),   // ⭐ FIXED COLUMN
                cleanCellForXLSX(cells[1]),
                cleanCellForXLSX(cells[2]),
                cleanCellForXLSX(cells[3]),
                cleanCellForXLSX(cells[4]),
                cleanCellForXLSX(cells[5])
            ];

            sheetData.push(rowData);
        });

        const ws = XLSX.utils.aoa_to_sheet(sheetData);

        ws['!cols'] = [
            { wch: 35 }, 
            { wch: 40 },
            { wch: 40 },
            { wch: 40 },
            { wch: 30 },
            { wch: 30 }
        ];

        const sheetName = product.replace(/[\\/*?:"<>|]/g, "").substring(0, 31);
        XLSX.utils.book_append_sheet(wb, ws, sheetName);
    });

    XLSX.writeFile(wb, "stock_register.xlsx");
}

        exportButton.addEventListener('click', exportToXLSX);
        // --- END: XLSX EXPORT LOGIC ---


        // --- START: Filter Logic ---
        function applyActiveFilters(formElement) {
            const formData = new FormData(formElement);
            currentFilters = Object.fromEntries(formData.entries());
            currentPage = 1;
            renderTable();
        }

        document.querySelectorAll('.filter-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                applyActiveFilters(form);
                const dropdownToggle = e.target.closest('.filter-dropdown').querySelector('.dropdown-toggle');
                bootstrap.Dropdown.getInstance(dropdownToggle)?.hide();
            });
        });

        document.getElementById('mobileApplyButton').addEventListener('click', () => {
            const mobileForm = document.getElementById('mobileFilterForm');
            applyActiveFilters(mobileForm);
            mobileFilterModal.hide();
        });
        
        document.getElementById('mobileResetButton').addEventListener('click', () => {
            resetAllFilters();
            mobileFilterModal.hide();
        });
        // --- END: Filter Logic ---


        loadInitialData();
        setupSearchableDropdowns();
        populateFilterDropdowns();
        // });
        }
    </script>
    <script>
    const deleteRouteTemplate = "{{ route('issue.stock.destroy', ['id' => ':id']) }}";
     document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-btn')) {
            const id = e.target.getAttribute('data-id');
            // alert(id);
    
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
            const deleteUrl = deleteRouteTemplate.replace(':id', id); // Replace :id with actual ID
    
            if (confirm("Are you sure you want to delete this record?")) {
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // alert("Deleted successfully!");
                         toastr.success("Deleted successfully!");
                        setTimeout(()=>{
                            location.reload()
                        })
                    } else {
                        toastr.error("Delete failed.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    toastr.error("Something went wrong.");
                    // alert("Something went wrong.");
                });
            }
        }
    });

    </script>
</body>
</html>