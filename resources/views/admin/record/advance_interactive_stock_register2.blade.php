<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Professional Interactive Stock Register (Bootstrap 5)</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                justify-content: space-between;
                align-items: center;
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
                                                <form>
                                                    <div class="mb-3">
                                                        <label class="form-label">Transaction Date</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">From</span>
                                                            <input type="date" class="form-control">
                                                            <span class="input-group-text">To</span>
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Product Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search product..." autocomplete="off">
                                                            <div class="custom-dropdown-menu">
                                                                <a class="custom-dropdown-item" href="#">All Products</a>
                                                                <a class="custom-dropdown-item" href="#">Poultry</a>
                                                                <a class="custom-dropdown-item" href="#">Beef</a>
                                                                <a class="custom-dropdown-item" href="#">Fish</a>
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
                                        <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form>
                                                    <div class="mb-3"><label class="form-label">Quantity</label><div class="input-group"><input type="number" class="form-control" placeholder="Less than..."><input type="number" class="form-control" placeholder="More than..."></div></div>
                                                    <div class="mb-3"><label class="form-label">Batch Number</label><input type="text" class="form-control" placeholder="Search batch..."></div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Vendor Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                                            <div class="custom-dropdown-menu">
                                                                <a class="custom-dropdown-item" href="#">All Vendors</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier A</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier B</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier C</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Manufacturing Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <div class="mb-3"><label class="form-label">Expiry Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <div class="mb-3"><label class="form-label">Receiving Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Stock Flow & Summary</span>
                                        <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form>
                                                    <div class="mb-3"><label class="form-label">Quantity</label><div class="input-group"><input type="number" class="form-control" placeholder="Less than..."><input type="number" class="form-control" placeholder="More than..."></div></div>
                                                    <div class="mb-3"><label class="form-label">Batch Number</label><input type="text" class="form-control" placeholder="Search batch..."></div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Vendor Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                                            <div class="custom-dropdown-menu">
                                                                <a class="custom-dropdown-item" href="#">All Vendors</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier A</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier B</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier C</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Manufacturing Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <div class="mb-3"><label class="form-label">Expiry Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <div class="mb-3"><label class="form-label">Receiving Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Closing Stock</span>
                                        <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form>
                                                    <div class="mb-3"><label class="form-label">Quantity</label><div class="input-group"><input type="number" class="form-control" placeholder="Less than..."><input type="number" class="form-control" placeholder="More than..."></div></div>
                                                    <div class="mb-3"><label class="form-label">Batch Number</label><input type="text" class="form-control" placeholder="Search batch..."></div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Vendor Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                                            <div class="custom-dropdown-menu">
                                                                <a class="custom-dropdown-item" href="#">All Vendors</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier A</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier B</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier C</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Manufacturing Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <div class="mb-3"><label class="form-label">Expiry Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <div class="mb-3"><label class="form-label">Receiving Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="th-content">
                                        <span>Transaction In Details</span>
                                        <div class="dropdown filter-dropdown">
                                            <i class="bi bi-funnel-fill filter-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-config='{"strategy":"fixed"}'></i>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg" onclick="event.stopPropagation()">
                                                <form>
                                                     <div class="mb-3">
                                                        <label class="form-label">Vendor Name</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                                            <div class="custom-dropdown-menu">
                                                                <a class="custom-dropdown-item" href="#">All Vendors</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier A</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier B</a>
                                                                <a class="custom-dropdown-item" href="#">Supplier C</a>
                                                            </div>
                                                        </div>
                                                     </div>
                                                     <div class="mb-3"><label class="form-label">Stock Out</label><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusIn" id="stockOutInAll" value="all" checked><label class="form-check-label" for="stockOutInAll">All</label></div><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusIn" id="stockOutInYes" value="yes"><label class="form-check-label" for="stockOutInYes">Yes</label></div><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusIn" id="stockOutInNo" value="no"><label class="form-check-label" for="stockOutInNo">No</label></div></div>
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
                                                <form>
                                                    <div class="mb-3">
                                                        <label class="form-label">Issued To</label>
                                                        <div class="custom-dropdown">
                                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search recipient..." autocomplete="off">
                                                            <div class="custom-dropdown-menu">
                                                                <a class="custom-dropdown-item" href="#">All Recipients</a>
                                                                <a class="custom-dropdown-item" href="#">Main Kitchen</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3"><label class="form-label">Stock Out</label><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusOut" id="stockOutOutAll" value="all" checked><label class="form-check-label" for="stockOutOutAll">All</label></div><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusOut" id="stockOutOutYes" value="yes"><label class="form-check-label" for="stockOutOutYes">Yes</label></div><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusOut" id="stockOutOutNo" value="no"><label class="form-check-label" for="stockOutOutNo">No</label></div></div>
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
                        <option value="5" selected>5</option><option value="10">10</option><option value="25">25</option><option value="50">50</option>
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
                    <div class="accordion" id="mobileFilterAccordion">

                        <!-- Filter Group 1: Date & Item -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Date & Item Details
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#mobileFilterAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text">From</span><input type="date" class="form-control">
                                            <span class="input-group-text">To</span><input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <div class="custom-dropdown">
                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search product..." autocomplete="off">
                                            <div class="custom-dropdown-menu">
                                                 <a class="custom-dropdown-item" href="#">All Products</a>
                                                 <a class="custom-dropdown-item" href="#">Poultry</a>
                                                 <a class="custom-dropdown-item" href="#">Beef</a>
                                                 <a class="custom-dropdown-item" href="#">Fish</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Group 2: Stock Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Stock Details
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#mobileFilterAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3"><label class="form-label">Quantity</label><div class="input-group"><input type="number" class="form-control" placeholder="Less than..."><input type="number" class="form-control" placeholder="More than..."></div></div>
                                    <div class="mb-3"><label class="form-label">Batch Number</label><input type="text" class="form-control" placeholder="Search batch..."></div>
                                    <div class="mb-3"><label class="form-label">Manufacturing Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                    <div class="mb-3"><label class="form-label">Expiry Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                    <div class="mb-3"><label class="form-label">Receiving Date</label><div class="input-group"><span class="input-group-text">From</span><input type="date" class="form-control"><span class="input-group-text">To</span><input type="date" class="form-control"></div></div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Group 3: Transaction Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Transaction Details
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#mobileFilterAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label">Vendor Name</label>
                                         <div class="custom-dropdown">
                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search vendor..." autocomplete="off">
                                            <div class="custom-dropdown-menu">
                                                <a class="custom-dropdown-item" href="#">All Vendors</a>
                                                <a class="custom-dropdown-item" href="#">Supplier A</a>
                                                <a class="custom-dropdown-item" href="#">Supplier B</a>
                                                <a class="custom-dropdown-item" href="#">Supplier C</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Issued To</label>
                                        <div class="custom-dropdown">
                                            <input type="text" class="form-control dropdown-search-input" placeholder="Search recipient..." autocomplete="off">
                                            <div class="custom-dropdown-menu">
                                                <a class="custom-dropdown-item" href="#">All Recipients</a>
                                                <a class="custom-dropdown-item" href="#">Main Kitchen</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="mb-3"><label class="form-label">Transaction Status (Stock Out)</label><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusMobile" id="stockOutMobileAll" value="all" checked><label class="form-check-label" for="stockOutMobileAll">All</label></div><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusMobile" id="stockOutMobileYes" value="yes"><label class="form-check-label" for="stockOutMobileYes">Yes</label></div><div class="form-check"><input class="form-check-input" type="radio" name="stockOutStatusMobile" id="stockOutMobileNo" value="no"><label class="form-check-label" for="stockOutMobileNo">No</label></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light">Reset</button>
                    <button type="button" class="btn btn-primary">Apply Filters</button>
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
            // .then(data => {
            //     console.log("Backend Data:", data); 
            //     loadInitialData(data); 
            // })
            .then(res => {
                console.log("Backend Data:", res);
    
                    loadInitialData(res.data,res.departments);  
            })
        
        .catch(error => console.error("Error fetching stock data:", error));
    });
    
     function loadInitialData(data,departments){

    // document.addEventListener('DOMContentLoaded', function() {
        const stockTableBody = document.getElementById('stockTableBody');
        const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
        const historyModalLabel = document.getElementById('historyModalLabel');
        const historyModalBody = document.getElementById('historyModalBody');
        const universalSearch = document.getElementById('universalSearch');
        const refreshButton = document.getElementById('refreshButton');
        const rowsPerPageSelect = document.getElementById('rowsPerPageSelect');
        const paginationControls = document.getElementById('paginationControls');
        const entriesInfo = document.getElementById('entriesInfo');
        let allRows = [], filteredRows = [], currentPage = 1, rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
        // const initialData = [
        //     { class: 'stock-in', itemName: 'Poultry', brandName: 'Premium Poultry', batchNumber: 'B11202', unit: 'kg', quantity: 50, itemId: 'POUL01', mfgDate: '2025-09-15', expDate: '2025-10-15', datetime: '2025-09-15 10:00', fromTo: 'Supplier A' },
        //     { class: 'stock-in', itemName: 'Poultry', brandName: 'Fresh Farms', batchNumber: 'B11302', unit: 'kg', quantity: 50, itemId: 'POUL01', mfgDate: '2025-09-15', expDate: '2025-10-18', datetime: '2025-09-15 11:00', fromTo: 'Supplier B' },
        //     { class: 'stock-in', itemName: 'Poultry', brandName: 'Budget Birds', batchNumber: 'B11402', unit: 'kg', quantity: 75, itemId: 'POUL01', mfgDate: '2025-09-14', expDate: '2025-10-10', datetime: '2025-09-16 14:00', fromTo: 'Supplier C' },
        //     { class: 'stock-in', itemName: 'Poultry', brandName: 'Fresh Farms', batchNumber: 'B11502', unit: 'kg', quantity: 30, itemId: 'POUL01', mfgDate: '2025-09-16', expDate: '2025-10-25', datetime: '2025-09-17 09:30', fromTo: 'Supplier B' },
        //     { class: 'stock-out', itemName: 'Poultry', batchNumber: 'Mixed', unit: 'kg', quantity: -80, itemId: 'POUL01', datetime: '2025-09-18 09:00', fromTo: 'Main Kitchen',
        //       issuedFrom: JSON.stringify([
        //           { batchNumber: 'B11402', brandName: 'Budget Birds', mfgDate: '2025-09-14', expDate: '2025-10-10', quantity: 75, vendorName: 'Supplier C', receivingDate: '2025-09-16 14:00', receivingQty: 75 },
        //           { batchNumber: 'B11202', brandName: 'Premium Poultry', mfgDate: '2025-09-15', expDate: '2025-10-15', quantity: 5, vendorName: 'Supplier A', receivingDate: '2025-09-15 10:00', receivingQty: 50 }
        //       ])
        //     }
        // ];
                const initialData = data;

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
                    transactionText = `<div class="transaction-details stock-in"><div>Received: ${quantity.toFixed(2)} ${unit}</div><div class="text-muted small">Vendor: ${row.dataset.fromTo} | Batch: <strong>${row.dataset.batchNumber}</strong> | Mfg: ${row.dataset.mfgDate} | Exp: ${row.dataset.expDate}</div></div>`;
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
            const itemNameDropdownHTML = `
                <div class="custom-dropdown">
                    <input type="text" name="itemName" class="form-control form-control-sm dropdown-search-input" placeholder="Select or type item..." required autocomplete="off">
                    <div class="custom-dropdown-menu">
                        ${allItemNames.map(name => `<a class="custom-dropdown-item" href="#">${name}</a>`).join('')}
                    </div>
                </div>`;

            // const allIssuedTo = [...new Set(allRows
            //     .filter(row => row.classList.contains('stock-out'))
            //     .map(row => row.dataset.fromTo).filter(Boolean))];
            // const issuedToDropdownHTML = `
            //     <div class="custom-dropdown">
            //         <input type="text" name="supplierOrIssuedTo" class="form-control form-control-sm dropdown-search-input" placeholder="Select or type recipient..." required autocomplete="off">
            //         <div class="custom-dropdown-menu">
            //             ${allIssuedTo.map(name => `<a class="custom-dropdown-item" href="#">${name}</a>`).join('')}
            //         </div>
            //     </div>`;

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


            const newRow = stockTableBody.insertRow(0);
            newRow.classList.add('table-info', 'new-entry-row');
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control-plaintext" name="datetime" value="${new Date().toISOString().slice(0, 16).replace('T', ' ')}" readonly>
                    <hr class="my-2">
                    <label class="form-label small">Item Name</label>
                    ${itemNameDropdownHTML}
                </td>
                <td class="live-summary-container align-top"></td>
                <td>
                    <div class="mb-2">
                        <label class="form-label small">Issued Quantity</label>
                        <div class="input-group input-group-sm">
                            <input type="number" name="quantity" class="form-control" required>
                            <span class="input-group-text unit-display">--</span>
                        </div>
                    </div>
                    <hr>
                    <div class="live-calc text-primary">Opening Stock: <strong class="live-opening text-dark">--</strong></div>
                    <div class="live-issue-details my-2"></div>
                    <div class="live-calc text-danger balance">New Balance: <strong class="live-balance text-dark">--</strong></div>
                </td>
                <td class="live-closing-stock-summary align-top"></td>
                <td class="transaction-in-details"></td>
                <td class="transaction-out-details">
                    <label class="form-label small">Issued To</label>
                    ${issuedToDropdownHTML}
                </td>
                <td class="actions">
                    <button class="btn btn-success btn-sm save-btn">Save</button>
                    <button class="btn btn-danger btn-sm cancel-btn">Cancel</button>
                </td>`;
        });
        
        stockTableBody.addEventListener('input', function(event) {
            const target = event.target;
            if (!target.closest('.new-entry-row') || (target.name !== 'itemName' && target.name !== 'quantity')) return;

            const tempRow = target.closest('.new-entry-row');
            const itemName = tempRow.querySelector('[name="itemName"]').value;
            
            // Find all the cells and elements we need to update
            const openingStockCell = tempRow.querySelector('.live-summary-container');
            const closingStockCell = tempRow.querySelector('.live-closing-stock-summary');
            const unitDisplay = tempRow.querySelector('.unit-display');
            const liveOpeningText = tempRow.querySelector('.live-opening');
            const liveBalanceText = tempRow.querySelector('.live-balance');
            const liveIssueDetails = tempRow.querySelector('.live-issue-details');

            // Clear everything if there's no item name
            if (!itemName) {
                openingStockCell.innerHTML = '';
                closingStockCell.innerHTML = '';
                unitDisplay.textContent = '--';
                liveOpeningText.textContent = '--';
                liveBalanceText.textContent = '--';
                liveIssueDetails.innerHTML = '';
                return;
            }
            
            // --- Calculations ---
            const unit = findLastRowByItemName(itemName)?.dataset.unit || 'units';
            const availableBatches = calculateAllBatchBalances(allRows).filter(b => b.itemName === itemName && b.balance > 0.001).sort((a, b) => new Date(a.expDate) - new Date(b.expDate));
            const totalAvailableStock = availableBatches.reduce((sum, batch) => sum + batch.balance, 0);
            const quantityToIssue = parseFloat(tempRow.querySelector('[name="quantity"]').value) || 0;

            // --- Update UI Elements ---

            // 1. Update Unit and Text Readouts in the middle column
            unitDisplay.textContent = unit;
            liveOpeningText.textContent = `${totalAvailableStock.toFixed(2)} ${unit}`;
            liveIssueDetails.innerHTML = ''; // Clear previous details

            // 2. Update the Opening Stock Column
            const openingStockHTML = generateBatchSummaryHTML(itemName, availableBatches, 'Current Batches');
            openingStockCell.innerHTML = openingStockHTML;

            // 3. Update the Closing Stock Column and Issue Details
            if (quantityToIssue > 0) {
                if (quantityToIssue > totalAvailableStock) {
                    liveBalanceText.textContent = 'ERROR';
                    closingStockCell.innerHTML = '<div class="stock-summary text-danger p-2">Error: Insufficient stock.</div>';
                } else {
                    liveBalanceText.textContent = `${(totalAvailableStock - quantityToIssue).toFixed(2)} ${unit}`;
                    
                    let remainingQtyToIssue = quantityToIssue;
                    let breakdownHTML = '';
                    const closingBatches = JSON.parse(JSON.stringify(availableBatches)); // Deep copy

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
                // If quantity is 0, closing stock is the same as opening stock
                closingStockCell.innerHTML = openingStockHTML;
            }
        });

        stockTableBody.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('mobile-toggle-btn')) {
                const parentCard = target.closest('tr'), currentlyActive = target.classList.contains('active');
                parentCard.querySelectorAll('.mobile-toggle-btn').forEach(btn => {
                    btn.classList.remove('active'); btn.textContent = '+'; btn.setAttribute('aria-expanded', 'false');
                });
                if (!currentlyActive) { target.classList.add('active'); target.textContent = '−'; target.setAttribute('aria-expanded', 'true'); }
                return;
            }
            if (target.classList.contains('cancel-btn')) { target.closest('tr').remove(); }
            if (target.classList.contains('history-btn')) { if (target.closest('tr').dataset.itemName) showHistoryModal(target.closest('tr').dataset.itemName); }
            if (!target.classList.contains('save-btn')) return;
            event.preventDefault();
            const tempRow = target.closest('tr');
            const itemName = tempRow.querySelector('[name="itemName"]').value, quantityToIssue = parseFloat(tempRow.querySelector('[name="quantity"]').value), issuedTo = tempRow.querySelector('[name="supplierOrIssuedTo"]').value, datetime = tempRow.querySelector('[name="datetime"]').value, unit = tempRow.querySelector('.unit-display').textContent;
            if (!itemName || !quantityToIssue || !issuedTo || unit === '--') { alert('Please fill all required fields.'); return; }
            if (quantityToIssue <= 0) { alert('Issued quantity must be greater than zero.'); return; }
            const availableBatches = calculateAllBatchBalances(allRows).filter(b => b.itemName === itemName && b.balance > 0.001).sort((a, b) => new Date(a.expDate) - new Date(b.expDate));
            const totalAvailableStock = availableBatches.reduce((sum, batch) => sum + batch.balance, 0);
           
           
           
           
           
           
              // Issue from batches
            let remainingQtyToIssue = quantityToIssue;
            const lastItemId = (findLastRowByItemName(itemName)?.dataset.itemId) || (itemName.slice(0,3).toUpperCase() + Date.now().toString().slice(-3));
            const issuedBatchesDetails = [];
            
            for (const batch of availableBatches) {
                alert(JSON.stringify(batch, null, 2));
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

        // alert(JSON.stringify(postData, null, 2));
        
            
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
                    // Add new row to table on success
                    // const newSavedRow = document.createElement('tr');
                    // newSavedRow.className = 'stock-out';
                    // Object.assign(newSavedRow.dataset, {
                    //     itemId: lastItemId,
                    //     itemName: itemName,
                    //     batchNumber: 'Mixed',
                    //     unit: unit,
                    //     quantity: -quantityToIssue,
                    //     fromTo: issuedTo,
                    //     datetime: datetime,
                    //     issuedFrom: JSON.stringify(issuedBatchesDetails)
                    // });
                    // newSavedRow.innerHTML = `
                    //     <td><div>${datetime}</div><div class="item-details mt-2"><div class="item-name">${itemName} (${lastItemId})</div></div></td>
                    //     <td class="opening-stock-summary"></td>
                    //     <td class="stock-flow-summary"></td>
                    //     <td class="closing-stock-summary"></td>
                    //     <td class="transaction-in-details"></td>
                    //     <td class="transaction-out-details"><div class="type-out mb-2">STOCK OUT</div><div>To: <strong>${issuedTo}</strong></div></td>
                    //     <td class="actions"><button class="btn btn-info btn-sm history-btn">History</button></td>
                    // `;
                    // allRows.push(newSavedRow);
                    // tempRow.remove();
                    // recalculateUIForItem(itemName);
                    // renderTable();
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


           
           
            // if (quantityToIssue > totalAvailableStock) { alert(`Error: Cannot issue ${quantityToIssue} ${unit}. Only ${totalAvailableStock.toFixed(2)} ${unit} is available.`); return; }
            // let remainingQtyToIssue = quantityToIssue;
            // const lastItemId = (findLastRowByItemName(itemName)?.dataset.itemId) || (itemName.slice(0,3).toUpperCase() + Date.now().toString().slice(-3));
            // const issuedBatchesDetails = [];
            // for (const batch of availableBatches) {
            //     if (remainingQtyToIssue <= 0) break;
            //     const qtyFromThisBatch = Math.min(remainingQtyToIssue, batch.balance);
            //     issuedBatchesDetails.push({ ...batch, quantity: qtyFromThisBatch, vendorName: batch.fromTo, receivingDate: batch.datetime });
            //     remainingQtyToIssue -= qtyFromThisBatch;
            // }
            
            
            
        
            
            
            const newSavedRow = document.createElement('tr');
            newSavedRow.className = 'stock-out';
            Object.assign(newSavedRow.dataset, { itemId: lastItemId, itemName: itemName, batchNumber: 'Mixed', unit: unit, quantity: -quantityToIssue, fromTo: issuedTo, datetime: datetime, issuedFrom: JSON.stringify(issuedBatchesDetails) });
            newSavedRow.innerHTML = `<td><div>${datetime}</div><div class="item-details mt-2"><div class="item-name">${itemName} (${lastItemId})</div></div></td>
            <td class="opening-stock-summary"></td><td class="stock-flow-summary"></td><td class="closing-stock-summary"></td><td class="transaction-in-details"></td>
            <td class="transaction-out-details"><div class="type-out mb-2">STOCK OUT</div><div>To: <strong>${issuedTo}</strong></div></td><td class="actions">
            <button class="btn btn-info btn-sm history-btn">History</button></td>`;
            allRows.push(newSavedRow); tempRow.remove(); recalculateUIForItem(itemName); renderTable();
            
        });
        

        const applyFiltersAndSearch = () => {
            const searchTerm = universalSearch.value.toLowerCase();
            filteredRows = !searchTerm ? [...allRows] : allRows.filter(row => row.textContent.toLowerCase().includes(searchTerm) || Object.values(row.dataset).join(' ').toLowerCase().includes(searchTerm));
            filteredRows.sort((a, b) => (b.dataset.datetime).localeCompare(a.dataset.datetime));
        };
        const renderPagination = () => {
            paginationControls.innerHTML = '';
            const totalEntries = filteredRows.length, totalPages = Math.ceil(totalEntries / rowsPerPage);
            const startEntry = totalEntries === 0 ? 0 : (currentPage - 1) * rowsPerPage + 1, endEntry = Math.min(currentPage * rowsPerPage, totalEntries);
            entriesInfo.textContent = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;
            if (totalPages <= 1) return;
            paginationControls.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`;
            for (let i = 1; i <= totalPages; i++) paginationControls.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            paginationControls.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`;
        };
        const renderTable = () => {
            applyFiltersAndSearch(); renderPagination(); stockTableBody.innerHTML = '';
            const pageRows = filteredRows.slice((currentPage - 1) * rowsPerPage, (currentPage - 1) * rowsPerPage + rowsPerPage);
            pageRows.forEach(row => stockTableBody.appendChild(row));
        };
        universalSearch.addEventListener('input', () => { currentPage = 1; renderTable(); });
        refreshButton.addEventListener('click', () => { universalSearch.value = ''; currentPage = 1; rowsPerPageSelect.value = 5; rowsPerPage = 5; renderTable(); });
        rowsPerPageSelect.addEventListener('change', () => { rowsPerPage = parseInt(rowsPerPageSelect.value, 10); currentPage = 1; renderTable(); });
        paginationControls.addEventListener('click', (e) => {
            if (e.target.tagName === 'A') {
                e.preventDefault();
                const page = parseInt(e.target.dataset.page, 10);
                if (page) { currentPage = page; renderTable(); }
            }
        });
        function loadInitialData() {
            initialData.forEach(data => {
                const row = document.createElement('tr');
                row.className = data.class;
                Object.assign(row.dataset, data);
                let inHTML = '', outHTML = '';
                if(data.class === 'stock-in') inHTML = `<div class="type-in mb-2">STOCK IN</div><div>From: <strong>${data.fromTo}</strong></div>`;
                else outHTML = `<div class="type-out mb-2">STOCK OUT</div><div>To: <strong>${data.fromTo}</strong></div>`;
                row.innerHTML = `<td><div>${data.datetime}</div><div class="item-details mt-2"><div class="item-name">${data.itemName} (${data.itemId})</div></div></td><td class="opening-stock-summary"></td><td class="stock-flow-summary"></td><td class="closing-stock-summary"></td><td class="transaction-in-details">${inHTML}</td><td class="transaction-out-details">${outHTML}</td><td class="actions"><button class="btn btn-info btn-sm history-btn">History</button></td>`;
                allRows.push(row);
            });
            const allItems = [...new Set(allRows.map(row => row.dataset.itemName))];
            allItems.forEach(item => recalculateUIForItem(item));
            renderTable();
        }
        
        // --- START: Searchable Dropdown Logic ---
        function setupSearchableDropdowns() {
            document.addEventListener('focusin', (e) => {
                if (e.target.classList.contains('dropdown-search-input')) {
                    e.target.nextElementSibling.classList.add('show');
                }
            });

            document.addEventListener('focusout', (e) => {
                if (e.target.classList.contains('dropdown-search-input')) {
                    // Delay hiding to allow click event on items
                    setTimeout(() => {
                        if(e.target.nextElementSibling) {
                           e.target.nextElementSibling.classList.remove('show');
                        }
                    }, 200);
                }
            });
            
            document.addEventListener('mousedown', (e) => {
                if (e.target.classList.contains('custom-dropdown-item')) {
                    e.preventDefault();
                    const dropdown = e.target.closest('.custom-dropdown');
                    const input = dropdown.querySelector('.dropdown-search-input');
                    input.value = e.target.textContent;
                    // Dispatch an event to notify of the change for the live calculator
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
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            items[i].style.display = "";
                        } else {
                            items[i].style.display = "none";
                        }
                    }
                }
            });
        }
        // --- END: Searchable Dropdown Logic ---

        // --- START: Mobile Filter Modal Auto-Close Logic ---
        const mobileFilterModalEl = document.getElementById('mobileFilterModal');
        if (mobileFilterModalEl) {
            const mobileFilterModal = new bootstrap.Modal(mobileFilterModalEl);
            const mobileApplyFilterBtn = mobileFilterModalEl.querySelector('.modal-footer .btn-primary');
            if (mobileApplyFilterBtn) {
                mobileApplyFilterBtn.addEventListener('click', function() {
                    mobileFilterModal.hide();
                });
            }
        }
        // --- END: Mobile Filter Modal Auto-Close Logic ---

        loadInitialData();
        setupSearchableDropdowns(); // Initialize the new dropdown functionality
    // });
    }
    </script>
</body>
</html>