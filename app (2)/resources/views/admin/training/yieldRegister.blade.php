<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredient Specifications & Compliance</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>

<style>
    :root {
        --primary-brand: #4f46e5;
        --primary-brand-dark: #4338ca;
        --secondary-action: #10b981;
        --secondary-action-dark: #059669;
        --status-green-bg: #e7f8f3;
        --status-green-text: #059669;
        --status-red-bg: #fee2e2;
        --status-red-text: #dc2626;
        --status-yellow-bg: #fefce8;
        --status-yellow-text: #a16207;
        --status-grey-bg: #f3f4f6;
        --status-grey-text: #4b5563;
        --text-primary: #111827;
        --text-secondary: #4b5563;
        --text-muted: #6b7280;
        --text-on-brand: #ffffff;
        --bg-page: #f9fafb;
        --bg-card: #ffffff;
        --bg-muted: #f3f4f6;
        --border-color: #e5e7eb;
        --border-radius: 16px; /* Increased for a softer look */
        --box-shadow: 0 8px 24px rgba(0,0,0,0.05); /* Softened shadow */
        --transition: all 0.3s ease-in-out;

        /* Override Bootstrap Variables */
        --bs-primary: var(--primary-brand);
        --bs-primary-rgb: 79, 70, 229;
        --bs-secondary: var(--text-muted);
        --bs-secondary-rgb: 107, 114, 128;
        --bs-success: var(--secondary-action);
        --bs-success-rgb: 16, 185, 129;
        --bs-body-font-family: 'Inter', sans-serif;
        --bs-body-bg: var(--bg-page);
        --bs-body-color: var(--text-secondary);
        --bs-body-font-size: 14px;
        --bs-card-border-radius: var(--border-radius);
        --bs-card-border-color: var(--border-color);
        --bs-card-cap-bg: transparent;
        --bs-modal-border-radius: 12px;
        --bs-accordion-border-radius: 8px;
        --bs-accordion-inner-border-radius: 8px;
        --bs-accordion-btn-focus-box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
        --bs-accordion-active-bg: var(--bg-page);
        --bs-accordion-active-color: var(--text-primary);
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
    }
    
    .btn {
        transition: var(--transition);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        font-weight: 500;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background-color: var(--primary-brand);
        border-color: var(--primary-brand);
        color: var(--text-on-brand);
    }
    .btn-primary:hover {
        background-color: var(--primary-brand-dark);
        border-color: var(--primary-brand-dark);
    }
     .btn-secondary {
        background-color: var(--text-muted);
        border-color: var(--text-muted);
    }
    .btn-success {
        background-color: var(--secondary-action);
        border-color: var(--secondary-action);
    }
    .btn-success:hover {
        background-color: var(--secondary-action-dark);
        border-color: var(--secondary-action-dark);
    }

    .spec-container-wrapper { 
        background-color: var(--bg-card); 
        border-top: 4px solid var(--primary-brand);
        border-radius: var(--border-radius);
    }
    .spec-header { 
        padding: 20px 24px; 
        border-bottom: 1px solid var(--border-color);
        position: sticky;
        top: 0;
        z-index: 1020;
        background-color: var(--bg-card);
    }
    .spec-title h2 { font-size: 18px; font-weight: 600; color: var(--text-primary); margin: 0; }
    
    #universal-search-input {
        background-color: var(--bg-page);
    }
    #universal-search-input:focus {
        border-color: var(--primary-brand);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }

    .spec-table { width: 100%; border-collapse: collapse; }
    
    /* --- UPGRADED TABLE HEADER --- */
    .spec-table thead th { 
        text-align: left; 
        padding: 16px 24px; 
        font-size: 12px; 
        font-weight: 600; 
        text-transform: uppercase; 
        white-space: nowrap; 
        vertical-align: middle; 
        background-color: var(--bg-page);
        color: var(--text-muted);
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border-color);
    }
    .spec-table thead th {
        position: relative;
    }
    .th-content-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }
    /* --- UPGRADED TABLE BODY --- */
    .spec-table tbody td { 
        padding: 20px 24px; /* Increased padding */
        font-size: 14px; 
        vertical-align: middle; 
        border-bottom: 1px solid var(--border-color); 
    }
    .spec-table tbody tr:last-child td { border-bottom: none; }
    
    .spec-table tbody tr:not(.inactive-row):hover {
        background-color: var(--bg-page); /* More subtle hover */
    }

    .spec-table tbody td[rowspan] { vertical-align: top; padding-top: 24px; }
    .sl-no-col { width: 60px; min-width: 60px; color: var(--text-muted); }
    .info-col, .stock-col { min-width: 200px; }

    /* New styles for product details cell */
    .product-details-cell .product-name {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--primary-brand);
        margin: 0 0 4px 0;
    }
    .product-details-cell .product-tags {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 16px;
    }
    .product-details-cell .meta-info {
        font-size: 0.875rem;
        color: var(--text-muted);
        line-height: 1.6;
    }
    .product-details-cell .meta-info span {
        display: block;
        margin-bottom: 4px;
    }
     .product-details-cell .meta-info span:last-child {
        margin-bottom: 0;
    }
    .product-details-cell .meta-info strong {
        color: var(--text-primary);
        font-weight: 500;
    }

    .detail-list { display: flex; flex-direction: column; gap: 16px; } /* Increased gap */
    .detail-item { line-height: 1.5; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; }
    .detail-item-content { display: flex; align-items: center; gap: 0.5em; flex-wrap: wrap; }
    .detail-label { color: var(--text-muted); font-size: 0.9em; white-space: nowrap; }
    .detail-value { font-weight: 500; color: var(--text-primary); text-align: right; flex-grow: 1;}
    
    tr:not(.inactive-row) .editable-text { cursor: pointer; }
    .cell-edit-input { padding: 4px 6px; font-size: 14px; width: 100%; }
    
    .cell-actions { display: flex; gap: 0.5rem; align-items: center; }
    .icon-button { display: inline-flex; align-items: center; justify-content: center; padding: 6px; border-radius: 6px; border: 1px solid var(--border-color); background-color: var(--bg-card); cursor: pointer; color: var(--text-secondary); }
    .icon-button svg { width: 16px; height: 16px; }
    
    .icon-button:hover { background-color: var(--bg-muted); color: var(--primary-brand); }
    .icon-button.add-variant-btn:hover,
    .icon-button.add-storage-btn:hover { background-color: var(--status-green-bg); color: var(--status-green-text); }
    .icon-button.remove-variant-btn:hover,
    .icon-button.remove-storage-btn:hover { background-color: var(--status-red-bg); color: var(--status-red-text); }
    
    .add-variant-form, .add-storage-form {
        display: none;
        flex-direction: column;
        gap: 8px;
        padding: 12px;
        margin-top: 10px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: var(--bg-page);
    }
    .add-variant-form .form-actions, .add-storage-form .form-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    
    #multiselect-list { max-height: 250px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 6px; padding: 8px; }
    #multiselect-list label { display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 4px; cursor: pointer; user-select: none; }
    #multiselect-list label:hover { background-color: var(--bg-muted); }

    #rows-per-page {
        padding: 6px 8px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background-color: var(--bg-page);
        max-width: 80px;
    }
    /* --- UPGRADED FILTER ICONS --- */
    .filter-icon {
        cursor: pointer;
        color: var(--text-muted);
        display: inline-flex;
        padding: 6px;
        border-radius: 6px;
        transition: var(--transition);
    }
    .filter-icon:hover, .filter-icon.active {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--primary-brand);
    }
    .filter-icon svg {
        width: 16px;
        height: 16px;
    }
    .filter-dropdown {
        position: absolute;
        z-index: 10;
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        min-width: 280px;
        display: none; 
        flex-direction: column;
        top: 100%;
        left: 0;
        margin-top: 4px;
    }
    .filter-dropdown-content {
        padding: 12px;
        overflow-y: auto;
        flex-grow: 1;
        max-height: 400px;
    }
    .filter-section {
        margin-bottom: 1rem;
    }
    .filter-section:last-child {
        margin-bottom: 0;
    }
    .filter-subtitle {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }
    .filter-search-input {
        width: 100%;
        margin-bottom: 0.75rem;
        padding: 6px 10px;
        font-size: 13px;
    }
    .filter-checklist {
        max-height: 150px;
        overflow-y: auto;
        padding-right: 5px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .filter-item {
        display: flex;
        align-items: center;
    }
    .filter-item input[type="checkbox"] {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
        cursor: pointer;
    }
    .filter-item label {
        font-size: 14px;
        font-weight: 400;
        color: var(--text-primary);
        cursor: pointer;
        width: 100%;
    }
    .filter-actions {
        padding: 12px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-start;
        gap: 8px;
        background-color: var(--bg-page);
    }
    .filter-actions .btn {
        flex-grow: 0;
        border-radius: 6px;
        font-weight: 500;
        padding: 6px 16px;
        font-size: 14px;
    }
    
    .custom-multiselect {
        position: relative;
    }
    .custom-multiselect .select-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        border: 1px solid var(--bs-border-color);
        background-color: white;
        cursor: pointer;
        user-select: none;
    }
    .custom-multiselect .select-button span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .custom-multiselect .select-button svg {
        width: 20px;
        height: 20px;
        fill: var(--text-muted);
        transition: transform 0.2s;
    }
    .custom-multiselect.open .select-button svg {
        transform: rotate(180deg);
    }
    .custom-multiselect .dropdown-panel {
        display: none; 
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        z-index: 1060;
        margin-top: 4px;
        display: none;
        flex-direction: column;
    }
    .custom-multiselect.open .dropdown-panel {
        display: flex;
    }
    .custom-multiselect .dropdown-search {
        width: 100%;
        padding: 6px 10px;
        margin-bottom: 8px;
    }
    .custom-multiselect .dropdown-options {
        max-height: 150px;
        overflow-y: auto;
    }
     .custom-multiselect .dropdown-options label:hover {
        background-color: var(--bg-muted);
     }
    .custom-multiselect .dropdown-options .create-new-option {
        font-style: italic;
        color: var(--primary-brand);
    }

    @media (max-width: 767.98px) {
        .spec-title { display: none; }
        .page-wrapper::before {
            content: "Ingredients";
            display: block;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
    }
</style>
</head>
<body>

<div class="container-fluid py-3 py-md-4 page-wrapper">
    <div class="card spec-container-wrapper shadow-sm">
        <header class="card-header spec-header">
            <div class="row gy-3 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="spec-title"><h2>Ingredient Specifications & Compliance</h2></div>
                </div>
                <div class="col-12 col-md-7">
                     <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                        </span>
                        <input type="search" id="universal-search-input" class="form-control border-start-0" placeholder="Search by product, yield name...">
                         <button class="btn btn-outline-secondary" type="button" id="refresh-btn" title="Refresh Data">
                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/><path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/></svg>
                         </button>
                         <button class="btn btn-outline-secondary" type="button" id="excel-download-btn" title="Download as Excel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
                         </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="card-body p-0 spec-container">
            <div class="table-responsive">
                <table class="table spec-table mb-0">
                    <thead id="spec-table-head">
                        <tr>
                            <th class="sl-no-col">
                                <div class="th-content-wrapper"><span>#</span></div>
                            </th>
                            <th class="info-col">
                                <div class="th-content-wrapper"><span>Source Details</span></div>
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Product Details</span>
                                    <span class="filter-icon" data-column="productName" title="Filter by Product Name or Specification">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5-757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                             <th class="stock-col">
                                <div class="th-content-wrapper"><span>Stock</span></div>
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Yield Name</span>
                                    <span class="filter-icon" data-column="yieldName" title="Filter by Yield Name">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Issue Headline</span>
                                    <span class="filter-icon" data-column="labelingSpecs" title="Filter by Issue Headline">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="spec-table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3 shadow-sm">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <label for="rows-per-page" class="text-nowrap">Rows per page:</label>
                <select id="rows-per-page" class="form-select form-select-sm">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div id="pagination-wrapper">
                <!-- Pagination buttons will be generated here -->
            </div>
            <div class="pagination-summary text-muted" id="pagination-summary"></div>
        </div>
    </div>
</div>


<!-- All Modals -->
<div class="modal fade" id="edit-multiselect-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="multiselect-title">Edit Value</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="mb-3"><input type="search" id="multiselect-search" class="form-control" placeholder="Search options..."></div><div id="multiselect-list"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="save-multiselect-btn">Save Changes</button></div></div></div></div>
<div class="modal fade" id="mobile-filter-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Filter Ingredients</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="mobile-filter-modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" id="clear-mobile-filters-btn">Clear All</button><button type="button" class="btn btn-primary" id="apply-mobile-filters-btn">Apply Filters</button></div></div></div></div>


<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000"
};
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("check kro 12345");
     reloadGetData1();
});

function reloadGetData1() {
    console.log("Fetching data...");

    fetch("{{ route('fetch.data.yield.rawMaterial') }}")
        .then(res => {
            if (!res.ok) throw new Error("Network response was not ok");
            return res.json();
        })
        .then(data => {
            console.log("Raw Response:", data);
            initApp(data.data);
        })
        .catch(err => {
            console.error("❌ Fetch Error:", err);
            initApp([]);
        });
}
function initApp(initialDATA){
    const tableBody = document.getElementById('spec-table-body');
    let nextDataId = 100;
    let currentPage = 1;
    let rowsPerPage = 10;
    let filteredData = [];
    let universalSearchTerm = '';
    let activeFilters = {};

    // --- START: Bootstrap Modal Instantiation ---
    const editMultiSelectModal = new bootstrap.Modal(document.getElementById('edit-multiselect-modal'));
    const mobileFilterModal = new bootstrap.Modal(document.getElementById('mobile-filter-modal'));
    // --- END: Bootstrap Modal Instantiation ---

    const ICONS = { 
        plus: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>`,
        trash: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>`
    };
    
    const YIELD_NAME_OPTIONS = ["Mutton keema", "Mutton Boneless", "Mutton Curry cut staff", "Mutton Curry Cut Guest", "Mutton Chop"];
    const STORAGE_OPTIONS = ["Direct issue for cooking", "Stored in freezer", "Stored in chiller"];
    const OUTLET_OPTIONS = ["Main Kitchen", "Bakery", "QSR"];
    
    // const initialProductData = [
    //     { productName: "Glutamine", vendorName: "PharmaSupply Co.", brandName: "NutriMax", receivingDate: "2025-08-20", batchNumber: "BATCH-00123", processingDate: "2025-08-21", expiryDate: "2027-08-20", tags: ["Wellness Holdings", "Asia-Pacific", "Recovery Labs"], uploadedBy: "David Chen", totalWeight: 500, balanceWeight: 200, lastUpdated: "2025-08-25T10:00:00.000Z", specificationName: "Glutamine Spec v1.0", variants: [{id: 11, yieldName: "Mutton keema", weight: 50, storage: [{type: "Stored in freezer", qty: 50}] },  {id: 11, yieldName: "Mutton keema", weight: 50, storage: [{type: "Stored in freezer", qty: 50}] }] },
    //     { productName: "Ashwagandha Extract", vendorName: "Herbal Essence Ltd.", brandName: "KSM-66", receivingDate: "2025-08-18", batchNumber: "BATCH-AE-556", processingDate: "2025-08-19", expiryDate: "2026-08-18", tags: ["Herbal Essence Ltd.", "KSM-66"], uploadedBy: "Sarah Lee", totalWeight: 1000, balanceWeight: 850, lastUpdated: "2025-08-24T12:00:00.000Z", specificationName: "Ashwagandha Spec v2.1", variants: [{id: 12, yieldName: "Mutton Boneless", weight: 150, storage: [{type: "Stored in chiller", qty: 100}, {type: "Direct issue for cooking", qty: 50, outlet: "Main Kitchen"}] }] },
    //     { productName: "Omega-3 Fish Oil", vendorName: "Ocean Nutrients", brandName: "MegaOmega", receivingDate: "2025-08-22", batchNumber: "BATCH-O3-987", processingDate: "2025-08-23", expiryDate: "2027-02-22", tags: ["Ocean Nutrients", "MegaOmega"], uploadedBy: "David Chen", totalWeight: 200, balanceWeight: 200, lastUpdated: "2025-08-23T09:00:00.000Z", specificationName: null, variants: [] },
    //     { productName: "Creatine Monohydrate", vendorName: "Bulk Powders Inc.", brandName: "Creapure", receivingDate: "2025-08-15", batchNumber: "BATCH-CM-451", processingDate: "2025-08-16", expiryDate: "2028-08-15", tags: ["Bulk Powders Inc.", "Creapure"], uploadedBy: "Mike Johnson", totalWeight: 2500, balanceWeight: 1250, lastUpdated: "2025-08-22T14:00:00.000Z", specificationName: "Creatine Monohydrate Spec v2.1", variants: [{id: 13, yieldName: "Mutton Curry cut staff", weight: 750, storage: [] }, {id: 14, yieldName: "Mutton Curry Cut Guest", weight: 500, storage: [{type: "Direct issue for cooking", qty: 500, outlet: "QSR"}] }] },
    // ];
    
    const initialProductData= initialDATA;

    let productData = JSON.parse(JSON.stringify(initialProductData));
    
    // --- START: Helper & Core Logic ---

    function formatDisplayDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        const userTimezoneOffset = date.getTimezoneOffset() * 60000;
        const adjustedDate = new Date(date.getTime() + userTimezoneOffset);
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return adjustedDate.toLocaleDateString('en-GB', options);
    }

    function recalculateProductQuantities(productName) {
        const product = productData.find(p => p.productName === productName);
        if (!product) return;

        const sumOfYields = product.variants.reduce((sum, variant) => sum + (parseFloat(variant.weight) || 0), 0);
        product.balanceWeight = product.totalWeight - sumOfYields;
    }

    function initializeQuantities() {
        productData.forEach(product => {
            recalculateProductQuantities(product.productName);
        });
    }

    function updateProductTimestamp(productName) {
        const product = productData.find(p => p.productName === productName);
        if (product) {
            product.lastUpdated = new Date().toISOString();
        }
    }

    function updateProductTimestampByVariant(variantId) {
        const product = findProductByVariantId(variantId);
        if (product) {
            product.lastUpdated = new Date().toISOString();
        }
    }
    
    function applyFilters() {
        let dataToFilter = JSON.parse(JSON.stringify(productData));
        
        if (universalSearchTerm) {
            const lowerCaseTerm = universalSearchTerm.toLowerCase();
            dataToFilter = dataToFilter.filter(product => {
                const nameMatch = product.productName.toLowerCase().includes(lowerCaseTerm);
                const yieldNameMatch = product.variants.some(v => v.yieldName && v.yieldName.toLowerCase().includes(lowerCaseTerm));
                return nameMatch || yieldNameMatch;
            });
        }
        
        const { productName, yieldName, storageTemp } = activeFilters;
        
        if (productName?.length) dataToFilter = dataToFilter.filter(p => productName.includes(p.productName));

        const filtered = dataToFilter.map(product => {
            if (!product.variants || product.variants.length === 0) {
                 const hasVariantFilters = Object.keys(activeFilters).some(k => ['yieldName', 'storageTemp'].includes(k));
                return hasVariantFilters ? null : product;
            }

            const filteredVariants = product.variants.filter(variant => {
                let match = true;
                if (yieldName?.length && !yieldName.includes(variant.yieldName)) match = false;
                if (storageTemp?.length && !storageTemp.some(s => (variant.storage || []).some(store => store.type === s))) match = false;
                return match;
            });

            if (filteredVariants.length > 0) {
                return {...product, variants: filteredVariants};
            }
            return null;
        }).filter(Boolean);

        filteredData = filtered.sort((a,b) => new Date(b.lastUpdated) - new Date(a.lastUpdated));
    }


    function setupPagination() {
        const paginationWrapper = document.getElementById('pagination-wrapper');
        const summaryEl = document.getElementById('pagination-summary');
        paginationWrapper.innerHTML = '';

        const totalRows = filteredData.length;
        if (totalRows === 0) {
            summaryEl.textContent = 'No results found';
            return;
        }

        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const startItem = (currentPage - 1) * rowsPerPage + 1;
        const endItem = Math.min(currentPage * rowsPerPage, totalRows);
        
        summaryEl.textContent = `Showing ${startItem}-${endItem} of ${totalRows}`;

        let paginationHtml = '<nav><ul class="pagination mb-0">';
        
        const prevDisabled = currentPage === 1 ? 'disabled' : '';
        paginationHtml += `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
        
        for (let i = 1; i <= totalPages; i++) {
             const activeClass = i === currentPage ? 'active' : '';
             paginationHtml += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }

        const nextDisabled = currentPage === totalPages ? 'disabled' : '';
        paginationHtml += `<li class="page-item ${nextDisabled}"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
        
        paginationHtml += '</ul></nav>';
        paginationWrapper.innerHTML = paginationHtml;
    }

    function renderTable(pageProducts, pageStartIndex) {
        tableBody.innerHTML = '';
        nextDataId = Math.max(0, ...productData.flatMap(p => p.variants.map(v => v.id))) + 1;

        if (pageProducts.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-5">No matching records found.</td></tr>`;
            return;
        }
        
        pageProducts.forEach((product, groupIndex) => {
            const { productName, variants, totalWeight, balanceWeight, tags, vendorName, brandName, receivingDate, batchNumber, processingDate, expiryDate, yield_id, record_id } = product;
            const rowspan = Math.max(1, (variants || []).length); 
            
            const firstRow = document.createElement('tr');
            
            const sourceDetailsContent = `
                <div class="detail-item"><span class="detail-label">Vendor:</span><span class="detail-value">${vendorName || 'N/A'}</span></div>
                <div class="detail-item"><span class="detail-label">Brand:</span><span class="detail-value">${brandName || 'N/A'}</span></div>
                <div class="detail-item"><span class="detail-label">Received:</span><span class="detail-value">${formatDisplayDate(receivingDate) || 'N/A'}</span></div>
            `;
            
            const stockContent = `
                <div class="detail-item">
                    <span class="detail-label">Received Qty:</span>
                    <span class="detail-value">${totalWeight || 0} kg</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Balance Qty:</span>
                    <span class="detail-value">${balanceWeight.toFixed(2)} kg</span>
                </div>`;
            
            const formattedProcessingDate = formatDisplayDate(processingDate);
            const formattedExpiryDate = formatDisplayDate(expiryDate);
            
            const productDetailsContent = `
                 <div class="product-details-cell">
                    <h5 class="product-name">${productName}</h5>
                     <div class="product-tags">${(tags || []).join(' • ')}</div>
                    <div class="meta-info">
                        <span class="batch-number">Batch: <strong>${batchNumber || 'N/A'}</strong></span>
                        <span class="processing-date">Processing: ${formattedProcessingDate}</span>
                        <span class="expiry-date">Expiry: ${formattedExpiryDate}</span>
                    </div>
                </div>`;


            firstRow.innerHTML = `
                <td rowspan="${rowspan}" class="sl-no-col">${pageStartIndex + groupIndex + 1}.</td>
                <td rowspan="${rowspan}" class="info-col"><div class="detail-list">${sourceDetailsContent}</div></td>
                <td rowspan="${rowspan}" class="product-name-col">${productDetailsContent}</td>
                <td rowspan="${rowspan}" class="stock-col"><div class="detail-list">${stockContent}</div></td>`;
            
            if (variants && variants.length > 0) {
                 populateVariantCells(firstRow, variants[0], product, 0);
            } else {
                const addVariantFormHTML = `
                    <div class="add-variant-form">
                        <div class="form-group"><label class="form-label">New Yield Name</label><div class="custom-multiselect" id="add-variant-yield-select-${productName.replace(/\s+/g, '-')}" data-selected-value=""><div class="select-button"><span>Select a Yield Name...</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path></svg></div><div class="dropdown-panel"><div class="dropdown-panel-body"><input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search..."><div class="dropdown-options"></div></div></div></div></div>
                        <div class="form-group mt-2"><label class="form-label">Weight (kg)</label><input type="number" class="form-control form-control-sm new-variant-weight" placeholder="e.g., 50.5"></div>
                        <div class="form-actions"><button class="btn btn-sm btn-secondary cancel-add-variant-btn">Cancel</button><button class="btn btn-sm btn-success save-new-variant-btn" data-yield-id="${yield_id}"  data-record-id="${record_id}" data-product-name="${productName}">Save</button></div>
                    </div>`;
                firstRow.innerHTML += `<td><button class="icon-button add-variant-btn" title="Add New Yield Name">${ICONS.plus}</button>${addVariantFormHTML}</td>
                                       <td class="text-center text-muted fst-italic">No Specs Added</td>`;
            }
            tableBody.appendChild(firstRow);

            if (variants) {
                variants.slice(1).forEach((variant, itemIndex) => {
                    const subsequentRow = document.createElement('tr');
                    subsequentRow.dataset.variantId = variant.id;
                    populateVariantCells(subsequentRow, variant, product, itemIndex + 1);
                    tableBody.appendChild(subsequentRow);
                });
                if (variants.length > 0) {
                    firstRow.dataset.variantId = variants[0].id;
                }
            }
        });
    }

    function updateView() {
        applyFilters();
        
        if (currentPage > Math.ceil(filteredData.length / rowsPerPage) && filteredData.length > 0) {
            currentPage = Math.ceil(filteredData.length / rowsPerPage);
        } else if (filteredData.length === 0) {
            currentPage = 1;
        }

        setupPagination();

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const pageProducts = filteredData.slice(startIndex, endIndex);

        renderTable(pageProducts, startIndex);
        updateFilterIcons();
    }
    
    function populateVariantCells(rowElement, variant, product, itemIndex) {
        const addVariantFormHTML = itemIndex === 0 ? `
            <div class="add-variant-form">
                <div class="form-group"><label class="form-label">New Yield Name</label><div class="custom-multiselect" id="add-variant-yield-select" data-selected-value=""><div class="select-button"><span>Select a Yield Name...</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path></svg></div><div class="dropdown-panel"><div class="dropdown-panel-body"><input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search..."><div class="dropdown-options"></div></div></div></div></div>
                <div class="form-group mt-2"><label class="form-label">Weight (kg)</label><input type="number" class="form-control form-control-sm new-variant-weight" placeholder="e.g., 50.5"></div>
                <div class="form-actions"><button class="btn btn-sm btn-secondary cancel-add-variant-btn">Cancel</button><button class="btn btn-sm btn-success save-new-variant-btn" data-yield-id="${product.yield_id}"  data-record-id="${product.record_id}" data-product-name="${product.productName}">Save</button></div>
            </div>` : '';
        
        const storageOptionsHTML = STORAGE_OPTIONS.map(opt => `<option value="${opt}">${opt}</option>`).join('');
        const outletOptionsHTML = OUTLET_OPTIONS.map(opt => `<option value="${opt}">${opt}</option>`).join('');

        const addStorageFormHTML = `
             <div class="add-storage-form">
                <div class="form-group"><label class="form-label">Storage</label><select class="form-select form-select-sm new-storage-type"><option value="">Choose...</option>${storageOptionsHTML}</select></div>
                 <div class="form-group mt-2 outlet-selection-group" style="display: none;">
                    <label class="form-label">Outlet</label>
                    <select class="form-select form-select-sm new-storage-outlet"><option value="">Choose...</option>${outletOptionsHTML}</select>
                </div>
                <div class="form-group mt-2"><label class="form-label">Quantity (kg)</label><input type="number" class="form-control form-control-sm new-storage-qty" placeholder="e.g., 10"></div>
                <div class="form-actions"><button class="btn btn-sm btn-secondary cancel-add-storage-btn">Cancel</button><button class="btn btn-sm btn-success save-new-storage-btn" data-variant-id="${variant.id}">Save</button></div>
            </div>`;

        let storageItemsHTML = (variant.storage && variant.storage.length > 0)
            ? variant.storage.map(s => {
                let displayText = s.type;
                if (s.type === "Direct issue for cooking" && s.outlet) {
                    displayText += ` (Outlet: ${s.outlet})`;
                }
                return `
                <div class="detail-item">
                    <span>${displayText}</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="detail-value">${s.qty} kg</span>
                        <button class="icon-button remove-storage-btn" data-storage-id="${s.id}" data-variant-id="${variant.id}" data-storage-type="${s.type}" title="Remove Storage">${ICONS.trash}</button>
                    </div>
                </div>`
            }).join('')
            : '<div class="text-muted text-center fst-italic p-2">No storage added</div>';

        const cellsHTML = `
            <td>
                <div class="detail-item mb-2">
                    <div class="detail-item-content w-100">
                        <span class="detail-value editable-text" data-variant-id="${variant.id}" data-field="yieldName">${variant.yieldName}</span>
                        <span class="detail-value editable-text ms-auto" data-variant-id="${variant.id}" data-field="weight">${variant.weight} kg</span>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="cell-actions">
                        <button class="icon-button remove-variant-btn" data-variant-id="${variant.id}" title="Remove Yield Name">${ICONS.trash}</button>
                        ${itemIndex === 0 ? `<button class="icon-button add-variant-btn" title="Add New Yield Name">${ICONS.plus}</button>` : ''}
                    </div>
                </div>
                ${addVariantFormHTML}
            </td>
            <td>
                <div class="detail-list">${storageItemsHTML}</div>
                 <div class="d-flex justify-content-end mt-2">
                    <button class="icon-button add-storage-btn" title="Add New Storage">${ICONS.plus}</button>
                </div>
                ${addStorageFormHTML}
            </td>`;
        
        rowElement.innerHTML += cellsHTML;
    }
    
    tableBody.addEventListener('click', handleMainTableClicks);
    tableBody.addEventListener('dblclick', handleDoubleClickEdit);
    tableBody.addEventListener('change', (e) => {
        if (e.target.matches('.new-storage-type')) {
            const form = e.target.closest('.add-storage-form');
            const outletGroup = form.querySelector('.outlet-selection-group');
            if (e.target.value === 'Direct issue for cooking') {
                outletGroup.style.display = 'block';
            } else {
                outletGroup.style.display = 'none';
            }
        }
    });

    
    function handleMainTableClicks(e) {
        const target = e.target;
        const button = target.closest('button');

        if (!button) return;
        
        const element = button;

        if (element.matches('.add-variant-btn')) {
            const form = element.closest('td').querySelector('.add-variant-form');
            if (form) {
                document.querySelectorAll('.add-variant-form, .add-storage-form').forEach(f => f.style.display = 'none');
                form.style.display = 'flex';
                const yieldNameSelect = form.querySelector('.custom-multiselect');
                populateYieldNameSelector(yieldNameSelect, '');
                yieldNameSelect.querySelector('input.dropdown-search').focus();
            }
        } else if (element.matches('.cancel-add-variant-btn')) {
            element.closest('.add-variant-form').style.display = 'none';
        } else if (element.matches('.save-new-variant-btn')) {
            const productName = element.dataset.productName;
            const yieldId = element.dataset.yieldId;
            const receivingRecordId = element.dataset.recordId;


            const form = element.closest('.add-variant-form');
            const yieldNameSelect = form.querySelector('.custom-multiselect');
            const yieldName = yieldNameSelect.dataset.selectedValue;
            const weightInput = form.querySelector('.new-variant-weight');
            const weight = parseFloat(weightInput.value);
            const product = productData.find(p => p.productName === productName);

            if (product && yieldName && product.variants.some(v => v.yieldName.toLowerCase() === yieldName.toLowerCase())) {
                alert(`The yield name "${yieldName}" has already been added to this product.`);
                return;
            }

            if (yieldName && product) {
                 if (isNaN(weight) || weight <= 0) {
                    alert('Please enter a valid, positive weight.'); return;
                }
                const currentSumOfYields = product.variants.reduce((sum, v) => sum + (v.weight || 0), 0);
                if (currentSumOfYields + weight > product.totalWeight) {
                    alert(`Cannot add yield. The total yield weight (${currentSumOfYields + weight} kg) would exceed the received quantity (${product.totalWeight} kg).`);
                    return;
                }
                
               
              fetch("{{route('save.yield.raw.material.data')}}", { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        yieldId: yieldId,  
                        receivingRecordId : receivingRecordId,
                        yieldName: yieldName,     
                        weight: weight
                    })
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const newVariant = { id: response.yieldId, yieldName, weight, storage: [] };
                        product.variants.push(newVariant);
                        recalculateProductQuantities(product.name);
                        updateProductTimestamp(product.name);
                        updateView();
                       toastr.success('Yield added successfully');
                    } else {
                        toastr.error(response.message || 'Failed to save yield ❌');
                    }
                })
                .catch(err => {
                    console.error(err);
                     toastr.error('An error occurred while saving the yield ❗');
                });

                
                // const newVariant = { id: nextDataId++, yieldName, weight, storage: [] };
                // product.variants.push(newVariant);
                // recalculateProductQuantities(productName);
                // updateProductTimestamp(productName);
                // updateView();
            } else if (!yieldName) {
                alert('Yield name is required.');
            }
        } else if (element.matches('.remove-variant-btn')) {
            // const variantId = element.dataset.variantId;
            // alert(variantId)
            // const variant = findVariantById(variantId);
            // if (confirm(`Are you sure you want to permanently remove the yield name "${variant.yieldName}"?`)) {
            //     const product = findProductByVariantId(variantId);
            //     if (product) {
            //         product.variants = product.variants.filter(v => v.id != variantId);
            //         recalculateProductQuantities(product.productName);
            //         updateProductTimestamp(product.productName);
            //         updateView();
            //     }
            // }
            
            const variantId = element.dataset.variantId;
            const variant = findVariantById(variantId);
            
            if (confirm(`Are you sure you want to permanently remove the yield name "${variant.yieldName}"?`)) {
                fetch("{{ route('delete.yield.raw.material.variant') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        id: variantId
                    })
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        const product = findProductByVariantId(variantId);
                        if (product) {
                            product.variants = product.variants.filter(v => v.id != variantId);
                            recalculateProductQuantities(product.productName);
                            updateProductTimestamp(product.productName);
                            updateView();
                        }
            
                        toastr.success(response.message || "Deleted successfully");
                    } else {
                        toastr.error(response.message || "Failed to delete variant");
                    }
                })
                .catch(err => {
                    console.error("Delete Error:", err);
                    toastr.error("An error occurred while deleting the variant.");
                });
            }

        } 
        
        else if (element.matches('.add-storage-btn')) {
            const form = element.closest('td').querySelector('.add-storage-form');
            if (form) {
                document.querySelectorAll('.add-variant-form, .add-storage-form').forEach(f => f.style.display = 'none');
                form.style.display = 'flex';
                form.querySelector('.new-storage-type').value = '';
                form.querySelector('.new-storage-qty').value = '';
                form.querySelector('.new-storage-outlet').value = '';
                form.querySelector('.outlet-selection-group').style.display = 'none';
            }
        } else if (element.matches('.cancel-add-storage-btn')) {
            element.closest('.add-storage-form').style.display = 'none';
        } else if (element.matches('.remove-storage-btn')) {
            const variantId = element.dataset.variantId;
            const storageId = element.dataset.storageId;
            // alert(storageId)
            const storageType = element.dataset.storageType;
            if (confirm(`Remove storage type "${storageType}"?`)) {
                const variant = findVariantById(variantId);
                if (variant) {
                    variant.storage = variant.storage.filter(s => s.type !== storageType);
                    updateProductTimestampByVariant(variantId);
                    updateView();
                }
                
                
                 fetch("{{route('yield.raw.material.delete.storage')}}", {  
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            storage_id: storageId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Failed to delete storage on server: ' + data.message);
                        }else{
                            toastr.success('Deleted Successfully')
                        }
                    })
                    .catch(err => {
                        console.error('AJAX error:', err);
                        alert('Server error while deleting storage.');
                    });
            }
        } else if (element.matches('.save-new-storage-btn')) {
            const variantId = element.dataset.variantId;
            const form = element.closest('.add-storage-form');
            const storageType = form.querySelector('.new-storage-type').value;
            const storageQty = parseFloat(form.querySelector('.new-storage-qty').value);
            const variant = findVariantById(variantId);

            if (!variant) return;
            if (!storageType) { alert("Please select a storage type."); return; }
            if (isNaN(storageQty) || storageQty <= 0) { alert("Please enter a valid, positive quantity."); return; }

            let newStorageObject = { type: storageType, qty: storageQty };

            if (storageType === 'Direct issue for cooking') {
                const outlet = form.querySelector('.new-storage-outlet').value;
                if (!outlet) {
                    alert("Please select an outlet for 'Direct issue for cooking'.");
                    return;
                }
                newStorageObject.outlet = outlet;
            }

            const currentStoredQty = variant.storage.reduce((sum, s) => sum + s.qty, 0);
            if (currentStoredQty + storageQty > variant.weight) {
                alert(`Cannot add. Total stored quantity (${currentStoredQty + storageQty} kg) would exceed this yield's weight (${variant.weight} kg).`);
                return;
            }
            if (variant.storage.some(s => s.type === storageType && s.outlet === newStorageObject.outlet)) {
                 alert(`This exact storage type and outlet combination already exists.`);
                 return;
            }

            // fetch("{{route('save.storage.yield.raw.material')}}", {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({
            //         variant_id: variantId,
            //         type: newStorageObject.type,
            //         qty: newStorageObject.qty,
            //         outlet: newStorageObject.outlet
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         toastr.success("Storage added successfully!");
            //         variant.storage.push(newStorageObject); // frontend update
            //         updateProductTimestampByVariant(variantId);
            //         updateView();
            //     } else {
            //         alert("Failed to save storage: " + data.message);
            //     }
            // })
            // .catch(err => {
            //     console.error(err);
            //     alert("An error occurred while saving storage.");
            // });
            
            fetch("{{route('save.storage.yield.raw.material')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    variant_id: variantId,
                    type: newStorageObject.type,
                    qty: newStorageObject.qty,
                    outlet: newStorageObject.outlet
                })
            })
            .then(async response => {
                const text = await response.text(); // debug ke liye
                console.log("Raw response:", text);
            
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error("Invalid JSON: " + text);
                }
            })
            .then(data => {
                if (data.success) {
                    toastr.success("Storage added successfully!");
                    variant.storage.push(newStorageObject); // frontend update
                    updateProductTimestampByVariant(variantId);
                    updateView();
                } else {
                    alert("Failed to save storage: " + data.message);
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert("An error occurred while saving storage: " + err.message);
            });


            // variant.storage.push(newStorageObject);
            // updateProductTimestampByVariant(variantId);
            // updateView();
        }
    }

    function handleDoubleClickEdit(e) {
        const target = e.target;

        if (target.matches('.editable-text')) {
            const variantId = target.dataset.variantId;
            const field = target.dataset.field;
            const variant = findVariantById(variantId);
            if (!variant) return;

            if (field === 'yieldName') {
                enableCellEditing(target, variant.yieldName, (newValue) => {
                    variant.yieldName = newValue.trim() || 'Not Added';
                    updateProductTimestampByVariant(variantId);
                    updateView();
                });
            } else if (field === 'weight') {
                enableCellEditing(target, variant.weight, (newWeightStr) => {
                    const newWeight = parseFloat(newWeightStr);
                    if (isNaN(newWeight) || newWeight < 0) { alert('Invalid weight.'); updateView(); return; }
                    
                    const product = findProductByVariantId(variantId);
                    const otherVariantsWeight = product.variants.filter(v => v.id != variantId).reduce((sum, v) => sum + (v.weight || 0), 0);
                    if (otherVariantsWeight + newWeight > product.totalWeight) {
                        alert(`Total yield weight would exceed received quantity.`); updateView(); return;
                    }
                    
                    const currentStoredQty = variant.storage.reduce((sum, s) => sum + s.qty, 0);
                    if (newWeight < currentStoredQty) {
                         alert(`New weight cannot be less than the total quantity in storage (${currentStoredQty} kg).`); updateView(); return;
                    }

                    variant.weight = newWeight;
                    recalculateProductQuantities(product.productName);
                    updateProductTimestampByVariant(variantId);
                    updateView();
                }, 'number');
            }
        }
    }
    
    function enableCellEditing(element, initialValue, onSave, inputType = 'text') {
        const input = document.createElement('input');
        input.type = inputType;
        if (inputType === 'number') input.step = 'any';
        input.value = initialValue === 'Not Added' ? '' : initialValue;
        input.className = 'cell-edit-input form-control form-control-sm';
        const parent = element.parentNode;
        parent.replaceChild(input, element);
        input.focus();
        input.select();
        const save = () => { onSave(input.value.trim() || initialValue); };
        input.addEventListener('blur', save, { once: true });
        input.addEventListener('keydown', (e) => { if (e.key === 'Enter') input.blur(); });
    }

    function findVariantById(variantId) { return productData.flatMap(p => p.variants).find(v => v.id == variantId); }
    function findProductByVariantId(variantId) { return productData.find(p => p.variants.some(v => v.id == variantId)); }
    
    function populateYieldNameSelector(container, searchTerm) {
        const optionsContainer = container.querySelector('.dropdown-options');
        const allYieldNames = YIELD_NAME_OPTIONS;
        const filteredYieldNames = allYieldNames.filter(b => b.toLowerCase().includes(searchTerm.toLowerCase()));
        
        optionsContainer.innerHTML = '';
        
        filteredYieldNames.forEach(name => {
            optionsContainer.innerHTML += `<label class="w-100"><input type="radio" name="new-yield-name-radio" class="form-check-input me-2" value="${name}"> ${name}</label>`;
        });
        
        if (optionsContainer.innerHTML === '') {
            optionsContainer.innerHTML = `<div class="p-2 text-center text-muted">No matching yield names found.</div>`;
        }
    }
    
    document.addEventListener('click', function(e) {
        const selectButton = e.target.closest('.select-button');
        if (selectButton) {
            const multiselect = selectButton.closest('.custom-multiselect');
            const wasOpen = multiselect.classList.contains('open');
            document.querySelectorAll('.custom-multiselect.open').forEach(openSelect => openSelect.classList.remove('open'));
            if (!wasOpen) multiselect.classList.add('open');
        } else if (!e.target.closest('.custom-multiselect')) {
            document.querySelectorAll('.custom-multiselect.open').forEach(openSelect => openSelect.classList.remove('open'));
        }
    });

    document.body.addEventListener('input', function(e) {
        const searchInput = e.target;
        if (searchInput.matches('.dropdown-search')) {
            const multiselect = searchInput.closest('.custom-multiselect');
            if (!multiselect) return;
            populateYieldNameSelector(multiselect, searchInput.value.trim());
        }
    });
    
    document.body.addEventListener('click', e => {
        const multiselect = e.target.closest('.custom-multiselect');
        if (!multiselect) return;

        const radio = e.target.closest('.dropdown-options input[type="radio"]');
        if(radio) {
            const selectedValue = radio.value;
            multiselect.dataset.selectedValue = selectedValue;
            multiselect.querySelector('.select-button span').textContent = selectedValue;
            multiselect.classList.remove('open');
        }
    });
        
    // --- START: FILTER LOGIC ---
    function buildFilterSection(cfg) {
        let sectionHTML = `<div class="filter-section"><h4 class="filter-subtitle">${cfg.title}</h4>`;
        if (cfg.type === 'checklist') {
            const currentSelection = new Set(activeFilters[cfg.key] || []);
            const itemsHTML = cfg.values.map(value => {
                 const uniqueId = `f-${cfg.key}-${value.replace(/[^a-zA-Z0-9]/g, '-')}`;
                 return `
                    <div class="filter-item">
                        <input type="checkbox" value="${value}" data-section="${cfg.key}" id="${uniqueId}" ${currentSelection.has(value) ? 'checked' : ''}>
                        <label for="${uniqueId}">${value}</label>
                    </div>`;
            }).join('');
            sectionHTML += `<input type="search" class="form-control form-control-sm filter-search-input" data-section="${cfg.key}" placeholder="Search...">`;
            sectionHTML += `<div class="filter-checklist">${itemsHTML}</div>`;
        }
        return sectionHTML + `</div>`;
    }

    function openFilterDropdown(column, targetIcon) {
        closeAllFilterDropdowns(); 
        const dropdown = document.createElement('div');
        dropdown.className = 'filter-dropdown';

        let contentHTML = '';
        const actionsFooterHTML = `
            <div class="filter-actions">
                <button class="btn btn-sm btn-primary apply-filter-btn">Apply</button>
                <button class="btn btn-sm btn-secondary clear-filter-btn">Clear</button>
            </div>`;
        
        switch(column) {
            case 'productName':
                contentHTML += buildFilterSection({ title: 'BY PRODUCT NAME', key: 'productName', values: [...new Set(productData.map(p => p.productName))].sort(), type: 'checklist' });
                // contentHTML += buildFilterSection({ title: 'BY SPECIFICATION', key: 'specification', values: [...new Set(productData.map(p => p.specificationName || 'Not Added'))].sort(), type: 'checklist' });
                break;
            case 'labelingSpecs':
                contentHTML += buildFilterSection({ title: 'BY STORAGE', key: 'storageTemp', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => (v.storage || []).map(s => s.type))))].sort(), type: 'checklist' });
                break;
            case 'yieldName': 
                 contentHTML += buildFilterSection({ title: 'BY YIELD NAME', key: 'yieldName', values: [...new Set(productData.flatMap(p => p.variants.map(v => v.yieldName)))].filter(Boolean).sort(), type: 'checklist' });
                break;
        }

        dropdown.innerHTML = `<div class="filter-dropdown-content">${contentHTML}</div>` + actionsFooterHTML;
        targetIcon.parentNode.appendChild(dropdown);
        dropdown.style.display = 'flex';
        
        dropdown.querySelectorAll('.filter-search-input').forEach(input => {
            input.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const checklist = e.target.nextElementSibling;
                checklist.querySelectorAll('.filter-item').forEach(item => {
                    const label = item.querySelector('label');
                    if (label) {
                        item.style.display = label.textContent.toLowerCase().includes(searchTerm) ? 'flex' : 'none';
                    }
                });
            });
        });
        
        dropdown.querySelector('.apply-filter-btn').addEventListener('click', () => {
            const newFilters = {};
            const sections = new Set([...dropdown.querySelectorAll('[data-section]')].map(el => el.dataset.section));
            
            sections.forEach(sectionKey => {
                 const checkboxes = dropdown.querySelectorAll(`input[type="checkbox"][data-section="${sectionKey}"]:checked`);
                 if(checkboxes.length > 0) {
                    newFilters[sectionKey] = [...checkboxes].map(cb => cb.value);
                 }
            });

            activeFilters = {...activeFilters, ...newFilters};
            currentPage = 1;
            updateView();
            closeAllFilterDropdowns();
        });

        dropdown.querySelector('.clear-filter-btn').addEventListener('click', () => {
             const keysToClear = new Set([...dropdown.querySelectorAll('[data-section]')].map(el => el.dataset.section));
             keysToClear.forEach(key => delete activeFilters[key]);
            currentPage = 1;
            updateView();
            closeAllFilterDropdowns();
        });

        dropdown.addEventListener('click', e => e.stopPropagation());
    }

    function closeAllFilterDropdowns() { document.querySelectorAll('.filter-dropdown').forEach(d => d.remove()); }

    function updateFilterIcons() {
        document.querySelectorAll('.filter-icon').forEach(icon => {
            const col = icon.dataset.column;
            let isActive = false;
            
            const relevantKeys = {
                productName: ['productName', 'specification'],
                labelingSpecs: ['storageTemp'],
                yieldName: ['yieldName']
            }[col] || [];
            
            isActive = relevantKeys.some(key => activeFilters[key] && activeFilters[key].length > 0);
            
            icon.classList.toggle('active', isActive);
        });
    }

    async function handleExcelExport() {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Ingredients');

        worksheet.columns = [
            { header: '#', key: 'slNo', width: 5 },
            { header: 'Product Name', key: 'productName', width: 25 },
            { header: 'Vendor', key: 'vendorName', width: 20 },
            { header: 'Brand', key: 'brandName', width: 20 },
            { header: 'Received Date', key: 'receivingDate', width: 15 },
            { header: 'Batch Number', key: 'batchNumber', width: 20 },
            { header: 'Processing Date', key: 'processingDate', width: 15 },
            { header: 'Expiry Date', key: 'expiryDate', width: 15 },
            { header: 'Received Qty (kg)', key: 'totalWeight', width: 18 },
            { header: 'Balance Qty (kg)', key: 'balanceWeight', width: 18 },
            { header: 'Yield Name', key: 'yieldName', width: 25 },
            { header: 'Yield Weight (kg)', key: 'yieldWeight', width: 18 },
            { header: 'Storage Type', key: 'storageType', width: 25 },
            { header: 'Storage Qty (kg)', key: 'storageQty', width: 18 },
            { header: 'Outlet', key: 'outlet', width: 20 },
        ];
        
        worksheet.getRow(1).font = { bold: true };

        let slNo = 1;
        filteredData.forEach(product => {
            if (product.variants.length === 0) {
                worksheet.addRow({
                    slNo: slNo++,
                    productName: product.productName,
                    vendorName: product.vendorName,
                    brandName: product.brandName,
                    receivingDate: formatDisplayDate(product.receivingDate),
                    batchNumber: product.batchNumber,
                    processingDate: formatDisplayDate(product.processingDate),
                    expiryDate: formatDisplayDate(product.expiryDate),
                    totalWeight: product.totalWeight,
                    balanceWeight: product.balanceWeight,
                    yieldName: 'N/A',
                });
            } else {
                product.variants.forEach(variant => {
                    if (variant.storage.length === 0) {
                        worksheet.addRow({
                            slNo: slNo++,
                            productName: product.productName,
                            vendorName: product.vendorName,
                            brandName: product.brandName,
                            receivingDate: formatDisplayDate(product.receivingDate),
                            batchNumber: product.batchNumber,
                            processingDate: formatDisplayDate(product.processingDate),
                            expiryDate: formatDisplayDate(product.expiryDate),
                            totalWeight: product.totalWeight,
                            balanceWeight: product.balanceWeight,
                            yieldName: variant.yieldName,
                            yieldWeight: variant.weight,
                            storageType: 'N/A',
                        });
                    } else {
                        variant.storage.forEach(storage => {
                            worksheet.addRow({
                                slNo: slNo++,
                                productName: product.productName,
                                vendorName: product.vendorName,
                                brandName: product.brandName,
                                receivingDate: formatDisplayDate(product.receivingDate),
                                batchNumber: product.batchNumber,
                                processingDate: formatDisplayDate(product.processingDate),
                                expiryDate: formatDisplayDate(product.expiryDate),
                                totalWeight: product.totalWeight,
                                balanceWeight: product.balanceWeight,
                                yieldName: variant.yieldName,
                                yieldWeight: variant.weight,
                                storageType: storage.type,
                                storageQty: storage.qty,
                                outlet: storage.outlet || 'N/A'
                            });
                        });
                    }
                });
            }
        });

        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'Ingredient_Specifications.xlsx';
        link.click();
    }
    
    function handleRefresh() {
        productData = JSON.parse(JSON.stringify(initialProductData));
        universalSearchTerm = '';
        activeFilters = {};
        currentPage = 1;
        document.getElementById('universal-search-input').value = '';
        updateView();
    }


    document.getElementById('excel-download-btn').addEventListener('click', handleExcelExport);
    document.getElementById('refresh-btn').addEventListener('click', handleRefresh);
    document.getElementById('universal-search-input').addEventListener('input', (e) => {
        universalSearchTerm = e.target.value;
        currentPage = 1;
        updateView();
    });
    document.getElementById('rows-per-page').addEventListener('change', (e) => {
        rowsPerPage = parseInt(e.target.value, 10);
        currentPage = 1;
        updateView();
    });
     document.getElementById('pagination-wrapper').addEventListener('click', (e) => {
        if (e.target.matches('.page-link')) {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page, 10);
            if (page && page !== currentPage) {
                currentPage = page;
                updateView();
            }
        }
    });

    document.querySelector('thead').addEventListener('click', e => {
        const filterIcon = e.target.closest('.filter-icon');
        if (filterIcon) {
            e.stopPropagation();
            const column = filterIcon.dataset.column;
            if (filterIcon.closest('.th-content-wrapper').querySelector('.filter-dropdown')) {
                closeAllFilterDropdowns();
            } else {
                openFilterDropdown(column, filterIcon);
            }
        }
    });
    
    document.addEventListener('click', (e) => { if (!e.target.closest('.filter-icon')) { closeAllFilterDropdowns(); } });
    
    initializeQuantities(); // Initial calculation on page load
    updateView(); // Initial Render
}
// });
</script>
</body>
</html>