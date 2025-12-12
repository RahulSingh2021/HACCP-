<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ingredient Specifications & Compliance</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<style>

.modal-backdrop {
    z-index: -1 !important;
    opacity: 0 !important;
    display: none !important;
}

.modal-content {
  border-radius: 12px;
  box-shadow: 0px 4px 20px rgba(0,0,0,0.15);
}
.modal-header {
  border-bottom: 1px solid #eee;
}
.modal-footer {
  border-top: 1px solid #eee;
}

button#direct-camcorder-btn {
    display: none;
}
#addNameModal > div {
    pointer-events: auto; /* ensure input is clickable */
}

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
        --border-radius: 6px;
        --box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
        --bs-card-border-radius: 12px;
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
    .btn-green-text {
        background-color: var(--status-green-bg);
        border-color: var(--secondary-action);
        color: var(--secondary-action-dark);
        font-weight: 600;
    }
    .btn-green-text:hover {
        background-color: var(--secondary-action);
        border-color: var(--secondary-action);
        color: var(--text-on-brand);
    }
    .btn-slate {
        background-color: #64748b;
        border-color: #64748b;
        color: var(--text-on-brand);
    }
    .btn-slate:hover {
        background-color: #475569;
        border-color: #475569;
    }

    .spec-container-wrapper { 
        background-color: var(--bg-card); 
        border-top: 4px solid var(--primary-brand);
    }
    .spec-header { 
        padding: 16px 24px; 
        border-bottom: 1px solid var(--border-color);
        position: sticky;
        top: 0;
        z-index: 1020; /* Below flash news */
        background-color: var(--bg-card);
    }
    .spec-title h2 { font-size: 18px; font-weight: 600; color: var(--text-primary); margin: 0; }
    
    .action-button.review-btn { padding: 6px 12px; font-size: 12px; }
    .action-button.accept { background-color: transparent; color: var(--status-green-text); border-color: var(--status-green-text); }
    .action-button.reject { background-color: transparent; color: var(--status-red-text); border-color: var(--status-red-text); }
    .action-button.accept.active, .action-button.accept:hover { background-color: var(--status-green-bg); }
    .action-button.reject.active, .action-button.reject:hover { background-color: var(--status-red-bg); }
    
    #universal-search-input {
        background-color: var(--bg-page);
    }
    #universal-search-input:focus {
        border-color: var(--primary-brand);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }

    .spec-table { width: 100%; border-collapse: collapse; }
    
    .spec-table thead th, .review-table thead th { 
        text-align: left; 
        padding: 12px 20px; 
        font-size: 12px; 
        font-weight: 600; 
        text-transform: uppercase; 
        white-space: nowrap; 
        vertical-align: middle; 
        background-color: var(--primary-brand);
        color: var(--text-on-brand);
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
    .spec-table tbody td, .review-table tbody td { padding: 16px 20px; font-size: 14px; vertical-align: middle; border-bottom: 1px solid var(--border-color); }
    .spec-table tbody tr:last-child td, .review-table tbody tr:last-child td { border-bottom: none; }
    
    .spec-table tbody tr:not(.inactive-row):hover {
        background-color: var(--status-yellow-bg);
    }

    .spec-table tbody td[rowspan] { vertical-align: top; padding-top: 20px; }
    .sl-no-col { width: 60px; min-width: 60px; }
    .product-name-cell { display: flex; flex-direction: column; align-items: flex-start; gap: 4px; }
    .product-name-cell .name-wrapper { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; width: 100%; }
    
    .product-name-cell .name { 
        flex-grow: 1; 
        font-weight: 600; 
        color: var(--primary-brand); 
    }
    .product-meta-info { font-size: 12px; color: var(--text-muted); line-height: 1.4; }
    .risk-badge { display: inline-block; margin-top: 4px; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 9999px; text-transform: capitalize; }
    .risk-low { background-color: var(--status-green-bg); color: var(--status-green-text); }
    .risk-medium { background-color: var(--status-yellow-bg); color: var(--status-yellow-text); }
    .risk-high { background-color: var(--status-red-bg); color: var(--status-red-text); }
    .risk-na { background-color: var(--status-grey-bg); color: var(--status-grey-text); }
    .vendor-cell-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
    .vendor-list-item { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 4px 0; }
    .detail-list { display: flex; flex-direction: column; gap: 12px; }
    .detail-item { line-height: 1.5; display: flex; justify-content: space-between; align-items: center; }
    .detail-item-content { display: flex; align-items: center; gap: 0.5em; flex-wrap: wrap; }
    .detail-label { color: var(--text-muted); }
    .detail-value { font-weight: 500; color: var(--text-primary); }
    .brand-name-wrapper { display: flex; align-items: center; gap: 8px; flex-grow: 1; }
    .status-badge { display: inline-block; padding: 4px 10px; font-size: 12px; font-weight: 600; border-radius: 9999px; text-transform: capitalize; }
    .status-badge.active, .status-badge.accepted { background-color: var(--status-green-bg); color: var(--status-green-text); }
    .status-badge.inactive, .status-badge.rejected { background-color: var(--status-red-bg); color: var(--status-red-text); }
    tr.inactive-row { opacity: 0.6; background-color: var(--bg-muted); }
    tr:not(.inactive-row) .editable-text,
    tr:not(.inactive-row) .editable-risk,
    tr:not(.inactive-row) .editable-multiselect { cursor: pointer; }
    .cell-edit-input { padding: 4px 6px; font-size: 14px; width: 100%; }

    .actions-cell { display: flex; flex-direction: column; gap: 1rem; }
    .review-dates { display: flex; flex-direction: column; gap: 4px; font-size: 12px; }
    .row-actions { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }
    .cell-actions { display: flex; gap: 0.5rem; align-items: center; }
    .icon-button { display: inline-flex; align-items: center; justify-content: center; padding: 6px; border-radius: 6px; border: 1px solid var(--border-color); background-color: var(--bg-card); cursor: pointer; color: var(--text-secondary); }
    .icon-button svg { width: 16px; height: 16px; }
    
    .icon-button:hover { background-color: var(--bg-muted); color: var(--primary-brand); }
    .icon-button.add-vendor-btn:hover, .icon-button.add-variant-btn:hover { background-color: var(--status-green-bg); color: var(--status-green-text); }
    .icon-button.remove-vendor-btn:hover, .icon-button.delete-image-btn:hover, .icon-button.remove-variant-btn:hover { background-color: var(--status-red-bg); color: var(--status-red-text); }
    .icon-button.coa-history-btn:hover, .icon-button.receiving-history-btn:hover { background-color: var(--primary-brand-dark); color: var(--text-on-brand); }
    
    .toggle-status-text-btn {
        padding: 6px 12px; font-size: 12px; font-weight: 600; border-radius: 6px; 
        border: 1px solid var(--border-color); cursor: pointer; transition: var(--transition); white-space: nowrap;
    }
    .toggle-status-text-btn.deactivate { background-color: var(--status-red-bg); color: var(--status-red-text); border-color: var(--status-red-text); }
    .toggle-status-text-btn.deactivate:hover { background-color: var(--status-red-text); color: var(--text-on-brand); }
    .toggle-status-text-btn.activate { background-color: var(--status-green-bg); color: var(--status-green-text); border-color: var(--status-green-text); }
    .toggle-status-text-btn.activate:hover { background-color: var(--status-green-text); color: var(--text-on-brand); }
    
    .toggle-status-text-btn.renew-coa {
        background-color: var(--status-yellow-bg); color: var(--status-yellow-text); border-color: #f59e0b;
    }
    .toggle-status-text-btn.renew-coa:hover { background-color: #f59e0b; color: var(--text-primary); }

    .icon-button:disabled, .action-button:disabled, .toggle-status-text-btn:disabled {
        cursor: not-allowed; opacity: 0.5; background-color: var(--bg-muted);
        color: var(--text-muted); border-color: var(--border-color);
    }
    .icon-button:disabled:hover, .action-button:disabled:hover, .toggle-status-text-btn:disabled:hover {
        background-color: var(--bg-muted); color: var(--text-muted); border-color: var(--border-color);
    }
    
    .spec-edit-mode { display: none; flex-direction: column; gap: 8px; width: 100%;}
    .spec-options-list { max-height: 150px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 6px; }
    .spec-option { padding: 8px 12px; cursor: pointer; }
    .spec-option:hover { background-color: var(--bg-muted); }
    .spec-option.selected { background-color: var(--primary-brand); color: white; }
    .spec-edit-actions { display: flex; gap: 8px; justify-content: flex-end; }
    .spec-edit-actions .action-button { padding: 6px 12px; font-size: 12px; }

    .add-variant-form {
        display: none;
        flex-direction: column;
        gap: 8px;
        padding: 12px;
        margin-top: 10px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: var(--bg-page);
    }
    .add-variant-form .form-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    
    .review-table .brand-review-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .review-table .brand-review-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        padding: 4px;
        border-radius: 4px;
    }
    .review-table .brand-review-item .brand-name-display {
        flex-grow: 1;
    }
    .review-table .edit-brand-container {
        display: flex;
        gap: 4px;
        flex-grow: 1;
    }
     .review-table .edit-brand-container input {
        flex-grow: 1;
     }
    .review-table .edit-brand-review-btn {
        padding: 2px 6px;
        font-size: 10px;
    }
    .product-name-edit-container { display: none; }


    .image-cell-wrapper { position: relative; width: 80px; height: 80px; }
    .table-image { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; transition: transform 0.2s, filter 0.2s; cursor: pointer; }
    .image-cell-wrapper:hover .table-image { filter: brightness(0.7); }
    .image-action-buttons { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; gap: 8px; opacity: 0; transition: opacity 0.2s; pointer-events: none; background: rgba(0,0,0,0.3); border-radius: 8px; }
    .image-cell-wrapper:hover .image-action-buttons { opacity: 1; pointer-events: auto; }
    .image-action-buttons .icon-button { background-color: rgba(255,255,255,0.8); color: var(--text-primary); }
    .image-action-buttons .icon-button:hover { background-color: white; }
    .image-action-buttons .icon-button.delete-image-btn:hover { background-color: var(--status-red-text); color: white; }

    .image-upload-placeholder {
        width: 80px; height: 80px;
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: var(--transition);
        background-color: var(--bg-page);
        color: var(--text-muted);
    }
    .image-upload-placeholder:hover {
        border-color: var(--primary-brand);
        background-color: var(--bg-muted);
        color: var(--primary-brand);
    }
    .image-upload-placeholder svg {
        width: 24px; height: 24px;
    }
    .image-upload-placeholder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 6px;
    }


    #review-csv-modal .modal-dialog { max-width: 70vw; }
    .form-group label { font-weight: 500; color: var(--text-primary); }
    #vendor-checkbox-list, #multiselect-list { max-height: 250px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 6px; padding: 8px; }
    #vendor-checkbox-list label, #multiselect-list label { display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 4px; cursor: pointer; user-select: none; }
    #vendor-checkbox-list label:hover, #multiselect-list label:hover { background-color: var(--bg-muted); }
    #select-vendor-modal .filter-item { padding: 8px; border-radius: 4px; cursor: pointer; }
    #select-vendor-modal .filter-item:hover { background-color: var(--bg-muted); }
    .review-table { width: 100%; border-collapse: collapse; }
    .review-table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: -10px; }
    .review-table tr.rejected-group { opacity: 0.6; text-decoration: line-through; background-color: var(--bg-muted); }
    .review-table tr.rejected-group .detail-item-content,
    .review-table tr.rejected-group .brand-review-list { pointer-events: none; }
    #image-viewer-modal .modal-content { background: transparent; box-shadow: none; border: none; }
    #image-viewer-modal .modal-dialog { max-width: 90vw; max-height: 90vh; }
    #image-viewer-modal img { width: 100%; height: 100%; object-fit: contain; }
    
    #coa-history-modal .modal-dialog,
    #packet-audit-modal .modal-dialog,
    #receiving-history-modal .modal-dialog,
    #compliance-center-modal .modal-dialog {
        max-width: 95vw;
    }
     #coa-history-modal .modal-content,
    #packet-audit-modal .modal-content,
    #receiving-history-modal .modal-content,
    #compliance-center-modal .modal-content {
        height: 95vh;
    }
    
    .view-link { font-size: 12px; font-weight: 500; color: var(--primary-brand); text-decoration: none; }
    .view-link:hover { text-decoration: underline; }

    #rows-per-page {
        padding: 6px 8px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background-color: var(--bg-page);
        max-width: 80px;
    }
    .filter-icon {
        cursor: pointer;
        color: rgba(255, 255, 255, 0.7);
        display: inline-flex;
        padding: 4px;
        border-radius: 4px;
        transition: color 0.2s, background-color 0.2s;
    }
    .filter-icon:hover, .filter-icon.active {
        background-color: var(--primary-brand-dark);
        color: white;
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
    .filter-date-range {
        display: flex;
        gap: 8px;
        align-items: center;
        font-size: 12px;
    }
    .filter-date-range input {
        font-size: 12px;
        padding: 4px 6px;
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
    .filter-item input[type="checkbox"], .filter-item input[type="radio"] {
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
    .filter-actions .apply-filter-btn {
        background-color: var(--secondary-action);
        border-color: var(--secondary-action);
        color: white;
    }
    .filter-actions .apply-filter-btn:hover {
        background-color: var(--secondary-action-dark);
        border-color: var(--secondary-action-dark);
    }
    .filter-actions .clear-filter-btn {
        background-color: #64748b;
        border-color: #64748b;
        color: white;
    }
    .filter-actions .clear-filter-btn:hover {
        background-color: #475569;
        border-color: #475569;
    }
    
    .action-toggle-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
    }
    .action-toggle {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }
    .action-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .action-toggle .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--status-red-text);
        transition: .4s;
        border-radius: 24px;
    }
    .action-toggle .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    .action-toggle input:checked + .slider {
        background-color: var(--secondary-action);
    }
    .action-toggle input:checked + .slider:before {
        transform: translateX(20px);
    }
    .action-toggle-label {
        font-size: 14px;
        font-weight: 600;
    }
    .action-toggle-label.remove {
        color: var(--status-red-text);
    }
    .action-toggle-label.accept {
        color: var(--secondary-action);
    }
    
    .uploaded-by-info {
        font-size: 12px;
        color: var(--text-muted);
    }
    
    #add-ingredient-modal .modal-dialog {
        max-width: 800px;
    }
    .form-section {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .form-section-header {
        background-color: var(--bg-muted);
        padding: 10px 16px;
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .form-section-body {
        padding: 16px;
    }
     #add-ingredient-modal .form-select {
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236b7280'%3E%3Cpath fill-rule='evenodd' d='M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z' clip-rule='evenodd' /%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
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
        z-index: 1060; /* Above modal backdrop */
        margin-top: 4px;
        display: none;
        flex-direction: column;
    }
    .custom-multiselect.open .dropdown-panel {
        display: flex;
    }
    .custom-multiselect .dropdown-panel-body {
        padding: 8px;
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
    .custom-multiselect .dropdown-options label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        cursor: pointer;
        border-radius: 4px;
    }
     .custom-multiselect .dropdown-options label:hover {
        background-color: var(--bg-muted);
     }
    .custom-multiselect .dropdown-actions {
        padding: 8px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        gap: 8px;
        background-color: var(--bg-page);
    }
    .custom-multiselect .dropdown-options .create-new-option {
        font-style: italic;
        color: var(--primary-brand);
    }
    .custom-multiselect .dropdown-options .create-new-option strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    #renew-coa-modal .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
    }
     #renew-coa-modal .modal-title {
        font-weight: 600;
        font-size: 1.125rem;
        color: var(--text-primary);
    }
    #renew-coa-modal .modal-body {
        padding: 1.5rem;
    }
    #renew-coa-modal .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        background-color: var(--bg-page);
    }
    #renew-coa-modal .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    #renew-coa-modal .form-control {
        font-size: 14px;
    }
     #renew-coa-modal .form-control[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.6;
    }
     #renew-coa-modal .form-control[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }
    #renew-coa-modal .modal-footer .btn {
        padding: 0.5rem 1rem;
        font-weight: 600;
    }
    
    #comments-modal .comment {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    #comments-modal .comment:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    #comments-modal .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        margin-bottom: 0.5rem;
    }
    #comments-modal .comment-meta { color: var(--text-muted); }
    #comments-modal .comment-body {
        white-space: pre-wrap;
    }

    .flash-news-ticker {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: var(--primary-brand-dark);
        color: white;
        z-index: 1056; /* Above modals */
        overflow: hidden;
        white-space: nowrap;
        padding: 8px 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .flash-news-ticker .content-wrapper {
        display: flex;
        align-items: center;
        width: 100%;
    }
    .flash-news-ticker .scrolling-text {
        animation: scroll-left 20s linear infinite;
        padding-left: 100%; /* Start off-screen */
        cursor: pointer;
    }
    .flash-news-ticker .scrolling-text:hover {
        animation-play-state: paused;
        text-decoration: underline;
    }
    .flash-news-ticker .close-ticker {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 0 10px;
    }

    @keyframes scroll-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); }
    }
    
    /* --- NEW DASHBOARD STYLES START --- */
    .summary-dashboard {
        padding: 1.5rem;
        background-color: var(--bg-muted);
        border-bottom: 1px solid var(--border-color);
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        position: relative; /* Added fix */
        z-index: 2;       /* Added fix */
    }
    .summary-card {
        background-color: var(--status-green-bg);
        border: 1px solid var(--status-green-text);
        border-radius: var(--border-radius);
        color: var(--text-primary);
    }
    .summary-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        cursor: pointer;
        font-weight: 600;
    }
    .summary-card-header .title-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--status-green-text);
    }
    .summary-card-header .title-group svg {
        width: 20px;
        height: 20px;
    }
    .summary-card-header .chevron {
        transition: transform 0.3s ease;
    }
    .summary-card-header[aria-expanded="false"] .chevron {
        transform: rotate(-90deg);
    }
    .summary-card-body {
        background-color: var(--bg-card);
        padding: 1rem;
        border-top: 1px solid var(--status-green-text);
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .stat-item {
        font-size: 0.875rem;
        padding: 0.5rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .stat-item:hover {
        background-color: var(--bg-muted);
    }
    .stat-item .label {
        color: var(--text-muted);
    }
    .stat-item .value {
        font-weight: 600;
        font-size: 1.125rem;
    }
    .stat-item .subtext {
        font-size: 0.75rem;
        font-style: italic;
        color: var(--text-secondary);
    }
    .summary-progress-bar {
        display: flex;
        height: 20px;
        background-color: var(--bg-muted);
        border-radius: 99px;
        overflow: hidden;
        width: 100%;
    }
    .progress-bar-segment {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        transition: width 0.5s ease-in-out;
    }
    .progress-bar-segment.bg-green { background-color: var(--secondary-action); }
    .progress-bar-segment.bg-red { background-color: var(--status-red-text); }
    .progress-bar-segment.bg-yellow { background-color: var(--status-yellow-text); }
    .progress-bar-segment.bg-grey { background-color: var(--status-grey-text); }
    .progress-bar-segment.bg-blue { background-color: var(--primary-brand); }
    /* --- NEW DASHBOARD STYLES END --- */


    .action-point-item {
        display: flex;
        gap: 0.75rem;
        padding: 0.5rem;
    }
     .action-point-item .form-control {
        flex-grow: 1;
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
        #add-ingredient-btn .button-text {
            display: none;
        }
         #add-ingredient-btn::before {
            content: "Add New";
        }
         #refresh-table-btn, #mobile-filter-btn {
            gap: 0;
            padding: 10px;
            min-width: 42px;
            justify-content: center;
        }
         #refresh-table-btn .button-text {
             display: none;
         }
        #add-ingredient-modal .modal-dialog {
            max-width: 95vw;
        }
        .summary-dashboard {
            grid-template-columns: 1fr;
        }
    }

    .input-group .form-control {
      height: 38px;           
      border-radius: 0 5px 5px 0;
    }
    
    .input-group-text {
      height: 38px;
      border-radius: 5px 0 0 5px;
    }
    
    .input-group {
      max-width: 450px;        
    }
</style>
</head>
<body>

<div id="flash-news" class="flash-news-ticker">
    <div class="content-wrapper">
        <span id="flash-news-text" class="scrolling-text"></span>
    </div>
    <button id="close-ticker-btn" class="close-ticker" aria-label="Close">&times;</button>
</div>

<div class="container-fluid py-3 py-md-4 page-wrapper">
    <div class="card spec-container-wrapper shadow-sm">
        <header class="card-header spec-header">
            <div class="row gy-3 align-items-center">
                <!--<div class="col-12 col-lg-3 col-xl-3">-->
                <!--    <div class="spec-title"><h2>Ingredient Specifications & Compliance</h2></div>-->
                <!--</div>-->
                <!--<div class="col-12 col-lg-7 col-xl-7">-->
                <!--     <div class="input-group">-->
                <!--        <span class="input-group-text bg-light border-end-0">-->
                <!--            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">-->
                <!--                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>-->
                <!--            </svg>-->
                <!--        </span>-->
                <!--        <input type="search" id="universal-search-input" class="form-control " placeholder="Search by product, brand, vendor...">-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-12 col-lg-7 col-xl-7">
                  <div class="input-group align-items-center" style="max-width:350px;">
                    <span class="input-group-text bg-light border-end-0">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                      </svg>
                    </span>
                    <input type="search" id="universal-search-input" class="form-control" placeholder="Search by product, brand, vendor...">
                  </div>
                </div>

   
                <div class="col-12 col-lg-5 col-xl-5">
                    <div class="d-flex flex-wrap flex-lg-nowrap gap-2 justify-content-start justify-content-lg-end">
                        <button id="compliance-center-btn" class="btn btn-outline-primary">Compliance Center</button>
                        <button id="add-ingredient-btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-ingredient-modal"><span class="button-text">Add New Ingredient</span></button>
                        <button id="refresh-table-btn" class="btn btn-success" title="Refresh Table">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"></path>
                                <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"></path>
                            </svg>
                            <span class="button-text d-none d-md-inline">Refresh</span>
                        </button>
                        <div class="d-none d-lg-flex gap-2">
                           <button id="download-excel-btn" class="btn btn-green-text">Download Excel</button>
                           <button id="upload-csv-btn" class="btn btn-success">Bulk Upload CSV</button>
                           <button id="download-sample-csv-btn" class="btn btn-slate">Download Sample</button>
                        </div>
                        <button id="mobile-filter-btn" class="btn btn-dark d-lg-none" data-bs-toggle="modal" data-bs-target="#mobile-filter-modal">
                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                             <span class="button-text d-none d-md-inline">Filter</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!--<header class="card-header spec-header">-->
        <!--  <div class="container">-->
        <!--    <div class="row gy-3 align-items-center">-->
        
              <!-- Title -->
        <!--      <div class="col-12 col-md-4 col-lg-3">-->
        <!--        <div class="spec-title">-->
        <!--          <h2>Ingredient Specifications & Compliance</h2>-->
        <!--        </div>-->
        <!--      </div>-->
        
              <!-- Search -->
        <!--      <div class="col-12 col-md-5 col-lg-4">-->
        <!--        <div class="input-group">-->
        <!--          <span class="input-group-text bg-light border-end-0 d-flex align-items-center">-->
        <!--            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">-->
        <!--              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>-->
        <!--            </svg>-->
        <!--          </span>-->
        <!--          <input type="search" id="universal-search-input" class="form-control border-start-0" placeholder="Search by product, brand, vendor...">-->
        <!--        </div>-->
        <!--      </div>-->
        
              <!-- Buttons -->
        <!--      <div class="col-12 col-md-3 col-lg-5 d-flex flex-wrap gap-2 justify-content-start justify-content-lg-end">-->
        <!--        <button id="compliance-center-btn" class="btn btn-outline-primary">Compliance Center</button>-->
        <!--        <button id="add-ingredient-btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-ingredient-modal">-->
        <!--          <span class="button-text">Add New Ingredient</span>-->
        <!--        </button>-->
        <!--        <button id="refresh-table-btn" class="btn btn-success" title="Refresh Table">-->
        <!--          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">-->
        <!--            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"></path>-->
        <!--            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"></path>-->
        <!--          </svg>-->
        <!--          <span class="button-text d-none d-md-inline">Refresh</span>-->
        <!--        </button>-->
        <!--        <button id="download-excel-btn" class="btn btn-green-text">Download Excel</button>-->
        <!--        <button id="upload-csv-btn" class="btn btn-success">Bulk Upload CSV</button>-->
        <!--        <button id="download-sample-csv-btn" class="btn btn-slate">Download Sample</button>-->
        <!--        <button id="mobile-filter-btn" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#mobile-filter-modal">-->
        <!--          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">-->
        <!--            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />-->
        <!--          </svg>-->
        <!--          <span class="button-text d-none d-md-inline">Filter</span>-->
        <!--        </button>-->
        <!--      </div>-->
        
        <!--    </div>-->
        <!--  </div>-->
        <!--</header>-->

        <!-- START: New Comprehensive Dashboard Section -->
        <div id="summary-dashboard-container" class="summary-dashboard">
            <!-- Dashboard cards will be rendered here by JavaScript -->
        </div>
        <!-- END: New Comprehensive Dashboard Section -->


        <div class="card-body p-0 spec-container">
            <div class="table-responsive">
                <table class="table spec-table mb-0">
                    <thead id="spec-table-head">
                        <tr>
                            <th class="sl-no-col">
                                <div class="th-content-wrapper"><span>Sl No.</span></div>
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Product Name</span>
                                    <span class="filter-icon" data-column="productName" title="Filter by Product Name, Risk, or Specification">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Approved Vendor</span>
                                     <span class="filter-icon" data-column="approvedVendors" title="Filter by Vendor">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                            <th><div class="th-content-wrapper"><span>Image</span></div></th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Brand & Status</span>
                                    <span class="filter-icon" data-column="brand" title="Filter by Brand">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>Labeling Specs</span>
                                    <span class="filter-icon" data-column="labelingSpecs" title="Filter by Labeling Specs">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                                
                            </th>
                            <th>
                                <div class="th-content-wrapper">
                                    <span>COA Details</span>
                                    <span class="filter-icon" data-column="coaDetails" title="Filter by COA Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                                </div>
                            </th>
                            <!-- <th>-->
                            <!--    <div class="th-content-wrapper">-->
                            <!--        <span>Yield/Stockable</span>-->
                            <!--        <span class="filter-icon" data-column="yieldStockableDetails" title="Filter by Yield/Stockable">-->
                            <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>-->
                            <!--        </span>-->
                            <!--    </div>-->
                            <!--</th>-->
                            <th><div class="th-content-wrapper"><span>Traceability Report</span></div></th>
                            <th>
                               <div class="th-content-wrapper">
                                   <span>Label Compliance</span>
                                   <span class="filter-icon" data-column="labelCompliance" title="Filter by Compliance Status">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" /></svg>
                                    </span>
                               </div>
                            </th>
                            <th><div class="th-content-wrapper"><span>Compliance Comments</span></div></th>
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

<!-- Hidden file inputs for table script -->
<!--<input type="file" id="image-upload-input" style="display: none;" accept="image/*">-->
<input 
    type="file" 
    id="image-upload-input" 
    accept="image/*" 
    capture="environment" 
    style="display: none;"
>



<input type="file" id="csv-upload-input" style="display: none;" accept=".csv">

<!-- All Modals -->
<div class="modal fade" id="add-vendor-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="add-vendor-title">Add Approved Vendor(s)</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="mb-3"><label for="vendor-search-input" class="form-label">Search for a vendor</label><input type="search" id="vendor-search-input" class="form-control" placeholder="Start typing..."></div><div id="vendor-checkbox-list"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="save-vendor-add-btn">Add Selected</button></div></div></div></div>
<div class="modal fade" id="edit-multiselect-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="multiselect-title">Edit Value</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="mb-3"><input type="search" id="multiselect-search" class="form-control" placeholder="Search options..."></div><div id="multiselect-list"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="save-multiselect-btn">Save Changes</button></div></div></div></div>
<div class="modal fade" id="review-csv-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Review Uploaded Data</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();"></button></div>
<div class="modal-body" id="review-csv-body"></div><div class="modal-footer">
    <button type="button" class="btn btn-primary" id="done-csv-review-btn" data-bs-dismiss="modal" style="display:none">Done</button>
    </div></div></div></div>
<div class="modal fade" id="image-viewer-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><img id="fullscreen-image" src="" class="img-fluid"></div></div></div>
<div class="modal fade" id="mobile-filter-modal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Filter Ingredients</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body" id="mobile-filter-modal-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" id="clear-mobile-filters-btn">Clear All</button><button type="button" class="btn btn-primary" id="apply-mobile-filters-btn">Apply Filters</button></div></div></div></div>

<!-- Select Vendor Modal -->
<div class="modal fade" id="select-vendor-modal" tabindex="-1" aria-labelledby="selectVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectVendorModalLabel">Select Vendor for Bulk Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-secondary mb-3">Choose a vendor to associate with the uploaded products.</p>
                <input type="search" id="vendor-selection-search" class="form-control mb-3" placeholder="Search...">
                <div id="vendor-selection-list" class="filter-checklist" style="max-height: 250px; overflow-y: auto;">
                    <!-- Vendor radio buttons will be populated here by JS -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="proceed-with-vendor-btn">Proceed</button>
            </div>
        </div>
    </div>
</div>

<!-- Renew COA Modal -->
<!--<div class="modal fade" id="renew-coa-modal" tabindex="-1" aria-labelledby="renewCoaModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="renewCoaModalLabel">Renew COA for...</h5>-->
<!--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <p class="text-secondary mb-4">Enter the details for the new certificate.</p>-->
<!--                <form id="renew-coa-form">-->
<!--                    <div class="mb-3">-->
<!--                        <label for="new-testing-date" class="form-label">New Testing Date</label>-->
<!--                        <input type="text" class="form-control" id="new-testing-date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="dd-mm-yyyy" required>-->
<!--                    </div>-->
<!--                    <div class="mb-3">-->
<!--                        <label for="new-expiry-date" class="form-label">New Expiry Date</label>-->
<!--                        <input type="text" class="form-control" id="new-expiry-date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="dd-mm-yyyy" required>-->
<!--                    </div>-->
<!--                    <div class="mb-3">-->
<!--                        <label for="material-receiving-date" class="form-label">Material Receiving Date</label>-->
<!--                        <input type="text" class="form-control" id="material-receiving-date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="dd-mm-yyyy" required>-->
<!--                    </div>-->
<!--                    <div class="mb-3">-->
<!--                        <label for="new-batch-no" class="form-label">New Batch No.</label>-->
<!--                        <input type="text" class="form-control" id="new-batch-no" placeholder="e.g., BN-240801-A01" required>-->
<!--                    </div>-->
<!--                    <div class="mb-3">-->
<!--                        <label for="new-coa-pdf" class="form-label">Upload New COA PDF</label>-->
<!--                        <input type="file" class="form-control" id="new-coa-pdf" accept=".pdf" required>-->
<!--                    </div>-->
<!--                    <div class="mb-3">-->
<!--                        <label for="form-e-upload" class="form-label">Upload Form E</label>-->
<!--                        <input type="file" class="form-control" id="form-e-upload">-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-slate" data-bs-dismiss="modal">Cancel</button>-->
<!--                <button type="submit" form="renew-coa-form" class="btn btn-success" id="submit-renewal-btn">Submit Renewal</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Renew COA Modal -->
<div class="modal fade" id="renew-coa-modal" tabindex="-1" aria-labelledby="renewCoaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renewCoaModalLabel">Renew COA for...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-secondary mb-4">Enter the details for the new certificate.</p>
                <form id="renew-coa-form" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                    <div class="mb-3">
                        <label for="new-testing-date" class="form-label">New Testing Date</label>
                        <input type="text" class="form-control" id="new-testing-date" name="new_testing_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="dd-mm-yyyy" required>
                    </div>
                    <!--<div class="mb-3">-->
                    <!--    <label for="new-expiry-date" class="form-label">New Expiry Date</label>-->
                    <!--    <input type="text" class="form-control" id="new-expiry-date" name="new_expiry_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="dd-mm-yyyy" required>-->
                    <!--</div>-->
                    <div class="mb-3">
                        <label for="material-receiving-date" class="form-label">Material Receiving Date</label>
                        <input type="text" class="form-control" id="material-receiving-date" name="material_receiving_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="dd-mm-yyyy" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-batch-no" class="form-label">New Batch No.</label>
                        <input type="text" class="form-control" id="new-batch-no" name="batch_no" placeholder="e.g., BN-240801-A01" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-coa-pdf" class="form-label">Upload New COA PDF</label>
                        <input type="file" class="form-control" id="new-coa-pdf" name="new_coa_pdf" accept=".pdf" required>
                    </div>
                    <!--<div class="mb-3">-->
                    <!--    <label for="form-e-upload" class="form-label">Upload Form E</label>-->
                    <!--    <input type="file" class="form-control" id="form-e-upload" name="form_e_upload" accept=".pdf">-->
                    <!--</div>-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-slate" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="renew-coa-form" class="btn btn-success" id="submit-renewal-btn">Submit Renewal</button>
            </div>
        </div>
    </div>
</div>


<!-- Comments/Compliance Ticket Modal -->
<div class="modal fade" id="comments-modal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentsModalLabel">Compliance Center</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ticket-history">
                    <!-- Ticket history will be populated here -->
                </div>
                <hr>
                <form id="add-ticket-form">
                    <h5 class="mb-3">Create New Compliance Ticket</h5>
                    <div class="mb-3">
                        <label for="new-ticket-title" class="form-label">Ticket Title</label>
                        <input type="text" class="form-control" id="new-ticket-title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Action Points</label>
                        <div id="action-points-container">
                           <div class="action-point-item input-group mb-2">
                               <input type="text" class="form-control" placeholder="Action point 1..." required>
                               <button class="btn btn-outline-danger remove-action-point-btn" type="button">X</button>
                           </div>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" type="button" id="add-action-point-btn">+ Add another point</button>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Ticket</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Resolve Action Point Modal -->
<div class="modal fade" id="resolve-point-modal" tabindex="-1" aria-labelledby="resolvePointModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resolvePointModalLabel">Resolve Action Point</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="resolve-point-form">
                    <p><strong>Action Point:</strong> <span id="point-to-resolve-text"></span></p>
                    <div class="mb-3">
                        <label for="resolution-notes" class="form-label">Resolution Notes</label>
                        <textarea class="form-control" id="resolution-notes" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="evidence-upload" class="form-label">Upload Evidence</label>
                        <input type="file" class="form-control" id="evidence-upload" required>
                    </div>
                </form>
            </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="resolve-point-form" class="btn btn-primary">Submit Resolution</button>
            </div>
        </div>
    </div>
</div>

<!-- Compliance Center Dashboard Modal -->
<div class="modal fade" id="compliance-center-modal" tabindex="-1" aria-labelledby="complianceCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="complianceCenterModalLabel">Compliance Center: All Open Action Points</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="compliance-center-body">
                <!-- List of all open tickets will be populated here -->
            </div>
        </div>
    </div>
</div>

<!-- Add New Ingredient Modal -->
<div class="modal fade" id="add-ingredient-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Ingredient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-section">
                    <div class="form-section-header">Product Details</div>
                    <div class="form-section-body">
                         <div class="row g-3">
                            <div class="col-12 form-group">
                                <label for="new-product-name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" id="new-product-name" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="new-storage-conditions" class="form-label">Storage Condition</label>
                                <div class="custom-multiselect" id="new-storage-conditions">
                                    <div class="select-button">
                                        <span>Select Conditions...</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                                    </div>
                                     <div class="dropdown-panel">
                                        <div class="dropdown-panel-body">
                                            <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search conditions...">
                                            <div class="dropdown-options"></div>
                                        </div>
                                        <div class="dropdown-actions"><button type="button" class="btn btn-sm btn-success apply-btn">Apply</button><button type="button" class="btn btn-sm btn-secondary clear-btn">Clear</button></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="new-risk-level" class="form-label">Risk Level</label>
                                <select id="new-risk-level" class="form-select">
                                    <option value="" selected>Select a risk level...</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-12 form-group">
                                <label for="new-approved-vendors" class="form-label">Approved Vendors</label>
                                <div class="custom-multiselect" id="new-approved-vendors">
                                    <div class="select-button">
                                        <span>Select Vendors...</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div class="dropdown-panel">
                                        <div class="dropdown-panel-body">
                                            <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search vendors...">
                                            <div class="dropdown-options"></div>
                                        </div>
                                        <div class="dropdown-actions"><button type="button" class="btn btn-sm btn-success apply-btn">Apply</button><button type="button" class="btn btn-sm btn-secondary clear-btn">Clear</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-header">Initial Brand</div>
                    <div class="form-section-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8 form-group">
                                <label for="new-brand-select" class="form-label">Brand Name <span class="text-danger">*</span>
                                
                                 <button type="button" class="btn btn-primary add-brand-modal">
                                    Add Brand
                                    </button>

                                
                                </label>
                                <div class="custom-multiselect" id="new-brand-select" data-selected-value="">
                                    <div class="select-button">
                                        <span>Select or create a brand...</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div class="dropdown-panel">
                                        <div class="dropdown-panel-body">
                                            <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search or type to create new...">
                                            <div class="dropdown-options"></div>
                                        </div>
                                        <div class="dropdown-actions"><button type="button" class="btn btn-sm btn-success apply-btn">Apply</button><button type="button" class="btn btn-sm btn-secondary clear-btn">Clear</button></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-group text-center">
                                <label class="form-label">Brand Image</label>
                                <div class="image-upload-placeholder mx-auto" id="new-ingredient-image-upload" title="Upload Brand Image">
                                     Camera Icon will be here 
                                </div>



                                <!-- <button type="button" class="btn btn-primary" id="openSecondModal">-->
                                <!--  Image Upload-->
                                <!--</button>-->


                            </div>
                        </div>
                    </div>
                </div>
                
                
                

                <div class="form-section">
                    <div class="form-section-header">Specifications</div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label for="new-allergens" class="form-label">Allergens</label>
                            <div class="custom-multiselect" id="new-allergens">
                                <div class="select-button"><span>Select Allergens...</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg></div>
                                <div class="dropdown-panel">
                                    <div class="dropdown-panel-body">
                                        <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search allergens...">
                                        <div class="dropdown-options"></div>
                                    </div>
                                    <div class="dropdown-actions"><button type="button" class="btn btn-sm btn-success apply-btn">Apply</button><button type="button" class="btn btn-sm btn-secondary clear-btn">Clear</button></div>
                                </div>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label for="new-instruction" class="form-label">Special Handling Instructions</label>
                            <div class="custom-multiselect" id="new-instruction">
                                <div class="select-button"><span>Select Instructions...</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg></div>
                                <div class="dropdown-panel">
                                    <div class="dropdown-panel-body">
                                        <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search instructions...">
                                        <div class="dropdown-options"></div>
                                    </div>
                                    <div class="dropdown-actions"><button type="button" class="btn btn-sm btn-success apply-btn">Apply</button><button type="button" class="btn btn-sm btn-secondary clear-btn">Clear</button></div>
                                </div>
                            </div>
                        </div>

                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="save-ingredient-btn">Save Ingredient</button>
            </div>
        </div>
    </div>
</div>

  <!-- First Modal -->
  <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="secondModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="firstModalLabel">Image Upload</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
       <div class="modal-body p-0"> <!-- No padding -->
        <iframe
          src="{{ route('sqa.suplier.image-upload') }}"
          style="width: 100%; height: 100vh; border: none;"
        ></iframe>
      </div>
      </div>
    </div>
  </div>


<div id="addNameModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:#fff; width:400px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.3); position:relative; padding:20px;">
        
        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h2 style="font-size:18px; margin:0;">Add New Brand Name</h2>
            <button class="close-btn" style="background:none; border:none; font-size:22px; cursor:pointer;">&times;</button>
        </div>

        <!-- Body -->
        <form id="addBrandForm">
            <div style="margin-bottom:15px;">
                <label for="addNameInput1" style="display:block; margin-bottom:6px;">Brand Name</label>
                <input type="text" id="addNameInput1" name="brand_name" placeholder="Enter the new brand name" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:14px;">
            </div>

            <!-- Footer -->
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="close-btn" style="padding:8px 14px; border:none; background:#ddd; border-radius:5px; cursor:pointer;">Cancel</button>
                <button type="submit" style="padding:8px 14px; border:none; background:#4CAF50; color:#fff; border-radius:5px; cursor:pointer;">Save</button>
            </div>
        </form>
    </div>
</div>



  
    

<!-- Full Screen Modals -->
<!--<div class="modal fade" id="coa-history-modal" tabindex="-1"><div class="modal-dialog modal-fullscreen"><div class="modal-content">-->
<!--    <div class="modal-header"><h5 class="modal-title">COA History</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">-->
        
<!--    </button></div>-->
<!--    <div class="modal-body">-->
<!--            <iframe id="coa-history-iframe"-->
<!--                src=""-->
<!--                width="100%" height="600px" frameborder="0"></iframe>-->
<!--        </div></div></div></div>-->
<div class="modal fade" id="coa-history-modal" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">COA History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="coa-history-iframe"
                src=""
                width="100%" height="600px" frameborder="0">
        </iframe>
      </div>
    </div>
  </div>
</div>

    
<div class="modal fade" id="packet-audit-modal" tabindex="-1"><div class="modal-dialog modal-fullscreen"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Ingredients Packet Audit</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><!-- Content removed as per request --></div></div></div></div>
<div class="modal fade" id="receiving-history-modal" tabindex="-1"><div class="modal-dialog modal-fullscreen"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Goods Receiving History</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div id="receiving-history-content"></div></div></div></div></div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog "> <!-- Centered + Large -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body -->
      <div class="modal-body">
        @include('admin.training.bulkupload')
      </div>
 
      
    </div>
  </div>
</div>



<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const openSecondModalBtn = document.getElementById("openSecondModal");

    openSecondModalBtn.addEventListener("click", function () {
      const secondModal = new bootstrap.Modal(document.getElementById("secondModal"));
      secondModal.show();
    });
  });
</script>

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
    const modal = document.getElementById('addNameModal');
    const openBtns = document.getElementsByClassName('add-brand-modal'); // HTMLCollection
    const closeBtns = document.querySelectorAll('.close-btn');
    const input = document.getElementById('addNameInput1');

    // Loop through all buttons if multiple
    Array.from(openBtns).forEach(btn => {
        btn.addEventListener('click', () => {
            modal.style.display = 'flex';
            input.focus(); // automatically focus
        });
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });

    // Click outside to close
    window.addEventListener('click', (e) => {
        if(e.target === modal){
            modal.style.display = 'none';
        }
    });
</script>

<script>
$(document).on('click', '.delete-btn', function() {
    let btn = $(this);
    let productId = btn.data('product-id');
    let createdBy = btn.data('created-by');
    let authId = btn.data('auth-id');

    // Authorization check
    if (authId != createdBy) {
        toastr.error("You are not authorized to delete this item.");
        return;
    }

    if (!confirm("Are you sure you want to delete this item?")) {
        return;
    }

    $.ajax({
        url: "{{ route('raw-material-product-delete', ':id') }}".replace(':id', productId),
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        success: function(response) {
            btn.closest('tr').remove();
            toastr.success("Product deleted successfully.");
            setTimeout(() => {
                // location.reload();
                // reloadGetData();
            }, 2000);
        },
        error: function(xhr) {
            toastr.error("Something went wrong.");
        }
    });
});


</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
         reloadGetData();
    });
    
    function reloadGetData(){
        fetch("{{ route('fetch-data-frotend.rawMaterial') }}")
            .then(res => res.json())
            .then(data => {
                // initApp(data); 
                    if (data.success) {
                        console.log("data.vendors",data.vendors);
                          console.log("data.products",data.products);
                     initApp(data.products, data.vendors, data.specifications,data.brands);
                    } else {
                        initApp([], []);
                    }
            })
            .catch(err => {
               initApp([], []);
            });
    }
    

  function initApp(initialProductData,initialVendors, specifications,brandsData) {
      console.log("brandsData",brandsData);
        let productData = JSON.parse(JSON.stringify(initialProductData));
        console.log("productDataproductData",productData);
        const tableBody = document.getElementById('spec-table-body');
        const csvUploadInput = document.getElementById('csv-upload-input');
        let nextDataId = 100;
        let tempCsvData = { matched: [], new: [] };
        let currentPage = 1;
        let rowsPerPage = 10;
        let filteredData = [];
        let universalSearchTerm = '';
        let activeFilters = {};
        let selectedVendorForUpload = null;
    
        // --- START: Bootstrap Modal Instantiation ---
        const addVendorModal = new bootstrap.Modal(document.getElementById('add-vendor-modal'));
        const editMultiSelectModal = new bootstrap.Modal(document.getElementById('edit-multiselect-modal'));
        const reviewCsvModal = new bootstrap.Modal(document.getElementById('review-csv-modal'));
        const imageViewerModal = new bootstrap.Modal(document.getElementById('image-viewer-modal'));
        const mobileFilterModalEl = document.getElementById('mobile-filter-modal');
        const mobileFilterModal = new bootstrap.Modal(mobileFilterModalEl);
        const addIngredientModal = new bootstrap.Modal(document.getElementById('add-ingredient-modal'));
        const coaHistoryModal = new bootstrap.Modal(document.getElementById('coa-history-modal'));
        const packetAuditModal = new bootstrap.Modal(document.getElementById('packet-audit-modal'));
        const receivingHistoryModal = new bootstrap.Modal(document.getElementById('receiving-history-modal'));
        const renewCoaModal = new bootstrap.Modal(document.getElementById('renew-coa-modal'));
        const selectVendorModal = new bootstrap.Modal(document.getElementById('select-vendor-modal'));
        const commentsModal = new bootstrap.Modal(document.getElementById('comments-modal'));
        const resolvePointModal = new bootstrap.Modal(document.getElementById('resolve-point-modal'));
        const complianceCenterModal = new bootstrap.Modal(document.getElementById('compliance-center-modal'));
        // --- END: Bootstrap Modal Instantiation ---
    
        const ICONS = { 
            plus: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>`,
            trash: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>`,
            history: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>`,
            view: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639l4.43-4.43a1.012 1.012 0 0 1 1.431 0l4.43 4.43a1.012 1.012 0 0 1 0 .639l-4.43 4.43a1.012 1.012 0 0 1-1.431 0l-4.43-4.43Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>`,
            edit: `<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" /></svg>`,
            camera: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.776 48.776 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" /></svg>`
        };
        
        const dummyPdfBase64 = 'JVBERi0xLjcKMSAwIG9iago8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFI+PgplbmRvYmoKMiAwIG9iago8PC9UeXBlL1BhZ2VzL0NvdW50IDEvS2lkc1sgMyAwIFJdPj4KZW5kb2JqCjMgMCBvYmoKPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9NZWRpYUJveFswIDAgNTk1IDg0Ml0vQ29udGVudHMgNCAwIFIvUmVzb3VyY2VzPDwvRm9udDw8L0YxIDUgMCBSPj4+Pj4+CmVuZG9iago0IDAgb2JqCjw8L0xlbmd0aCAxMDQ+PgpzdHJlYW0KQlQgL0YxIDQwIFRmIDcwIDcwMCBUZCAoQ2VydGlmaWNhdGUpIFRqIEVUIEJULyYxIDMwIFRmIDcwIDY1MCBUZCAoRm9yIFByb2R1Y3Q6IFdoZXkgUHJvdGVpbiBJc29sYXRlKSBUaiBFV CBCVC9GMSAxMiBUZiA3MCAxMDAgVGQgKEJhdGNoIE5vOiBCTi0yNDAyMC1BMDEpIFRqIEVUCmVuZHN0cmVhbQplbmRvYmoKNSAwIG9iago8PC9UeXBlL0ZvbnQvU3VidHlwZS9UeXBlMS9CYXNlRm9udC9IZWx2ZXRpY2E+PgplbmRvYmoKeHJlZgowIDYKMDAwMDAwMDAwMCA2NTUzNSBmIAowMDAwMDAwMDE1IDY1NTM1IG4gCjAwMDAwMDAwNjMgNjU1MzUgbiAKMDAwMDAwMDA5MyA2NTUzNSBuIAowMDAwMDAwMjE2IDY1NTM1IG4gCjAwMDAwMDAzMzAgNjU1MzUgbiAKdHJhaWxlcgo8PC9TaXplIDYvUm9vdCAxIDAgUj4+CnN0YXJ0eHJlZgozOTAKJSVFT0YK';
    
        // const DUMMY_SPECIFICATIONS = ["Whey Protein Concentrate Spec v1.2", "Creatine Monohydrate Spec v2.1", "Omega-3 Fish Oil Spec v1.0", "Vitamin D3 5000IU Spec v3.0", "Organic Pea Protein Spec v1.5"];
       
       
        const DUMMY_SPECIFICATIONS = Array.isArray(specifications) ? specifications : [];
        
        const RISK_LEVELS = ['low', 'medium', 'high'];
        // const DUMMY_VENDORS = ["Global Nutrition", "Bulk Supplements Inc.", "Oceanic Wellness", "PlantBased Co."];
        const DUMMY_VENDORS = Array.isArray(initialVendors) ? initialVendors : [];
        // const STORAGE_OPTIONS = ["Ambient", "Cool, Dry Place", "Refrigerate (2-8Â¡Ã†C)", "Frozen (-18Â¡Ã†C)"];
        // const ALLERGEN_OPTIONS = ["None", "Milk", "Soy", "Fish", "Peanuts", "Tree Nuts", "Wheat", "Eggs"];
        
        
        // const STORAGE_OPTIONS = ["Store in a cool and dry place, away from direct sunlight",
        // "Store at below 5 degree Celsius (in a refrigerator)","Store at below –18 degree Celsius (in a freezer)"];
        
          const STORAGE_OPTIONS = ["Received vegetarian food hot at or above 65°C.",
        "Received non-vegetarian food hot at or above 70°C.","Received and stored at or below 5°C.","Received at or below 5°C and stored at or below –18°C.","Received and stored at or below –18°C."
        ,"Received and stored at ambient temperature; once opened, store under refrigeration.","Received and stored at ambient temperature.","Can be received and stored either below 5°C (chilled) or at or below –18°C (frozen)"];
        
        const ALLERGEN_OPTIONS = ["None","Milk","Celery","Gluten","Crustaceans","Eggs","Fish","Lupin","Molluscs",
        "Mustard","Nuts","Peanuts","Sesame seeds","Soya","Sulphur dioxide and sulphites"];
        
        const HANDLING_INSTRUCTIONS = ["Thawing & Cooking","Thawing  & RTE/RTS","Thawing  & Cold processing","Others (Yes/No/NA)"];
        
    
        // //  let initialProductData = [
        //         { productName: "Glutamine", isProductActive: true, lastUpdated: "2025-08-25T10:00:00.000Z", corporateName: "Wellness Holdings", regionalName: "Asia-Pacific", unitName: "Recovery Labs", uploadedBy: "David Chen", approvedVendors: ["PlantBased Co."], specificationName: "Glutamine Spec v1.0", variants: [{id: 11, brand: "RecoverPure", riskLevel: 'high', isActive: true, imageUrl: 'https://via.placeholder.com/150', complianceStatus: 'Non-compliant', coaExpiry: '2025-08-15', lastReview: '2023-07-01', nextReviewDate: '2024-07-01', allergens: ["None"], storageTemp: ["Ambient"], complianceTickets: [{ticketId: 'T1', title: "Labeling Errors", date: "2023-07-02T14:00:00.000Z", user: "Jane Doe", actionPoints: [{text: "Allergen declaration missing.", status: 'open'}, {text: "Net weight font too small.", status: 'resolved', resolutionNotes: 'Reprinted labels with correct font size.', evidenceUrl: '#', resolvedBy: 'John Smith', resolvedDate: '2023-07-05T10:00:00.000Z'}] }] }] },
        // //     ];

        
        // --- START: Helper & Core Logic ---
        const getDaysDifference = (dateStr) => {
            if (!dateStr) return null;
            const today = new Date();
            today.setHours(0,0,0,0);
            const targetDate = new Date(dateStr);
            const diffTime = targetDate - today;
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        };
    
        const formatDateForDisplay = (isoString) => {
            if (!isoString) return 'N/A';
            const date = new Date(isoString);
            const userTimezoneOffset = date.getTimezoneOffset() * 60000;
            const localDate = new Date(date.getTime() + userTimezoneOffset);
            return localDate.toLocaleDateString('en-GB', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
        };
    
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
        
        function getHighestRiskForProduct(product) {
            const riskLevelsMap = { low: 0, medium: 1, high: 2 };
            const validRisks = product.variants.map(v => v.riskLevel).filter(Boolean);
            if (validRisks.length === 0) return 'Data Not Added';
            const maxRiskIndex = Math.max(...validRisks.map(r => riskLevelsMap[r]));
            return RISK_LEVELS[maxRiskIndex];
        }
    
    
        function getCoaStatus(variant) {
            if (!variant.coaExpiry) return 'Not Attached';
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const expiryDate = new Date(variant.coaExpiry);
            return expiryDate < today ? 'Expired' : 'Valid';
        }
    
        function getReviewStatus(variant) {
            if (variant.lastReview) return 'Completed';
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (variant.nextReviewDate && new Date(variant.nextReviewDate) >= today) {
                return 'Coming Soon';
            }
            return 'Pending';
        }
    
        function applyFilters() {
            let dataToFilter = [...productData];
            
            if (universalSearchTerm) {
                const lowerCaseTerm = universalSearchTerm.toLowerCase();
                dataToFilter = dataToFilter.filter(product => {
                    const nameMatch = product.productName.toLowerCase().includes(lowerCaseTerm);
                    const vendorMatch = (product.approvedVendors || []).some(v => v.toLowerCase().includes(lowerCaseTerm));
                    const brandMatch = product.variants.some(v => v.brand && v.brand.toLowerCase().includes(lowerCaseTerm));
                    return nameMatch || vendorMatch || brandMatch;
                });
            }
            
            // Product-level filters
            const { overallCompliance, vendorAttachment, specificationAttachment, brandAttachment, productName, riskCategory, approvedVendors, productStatus } = activeFilters;
            
            if (productStatus) {
                const isActive = productStatus[0] === 'Active';
                dataToFilter = dataToFilter.filter(p => p.isProductActive === isActive);
            }
            if (overallCompliance) {
                const isCompliant = overallCompliance[0] === 'Compliant';
                dataToFilter = dataToFilter.filter(product => {
                    if (!product.variants || product.variants.length === 0) return isCompliant;
                    const hasNonCompliant = product.variants.some(v => v.complianceStatus === 'Non-compliant');
                    return isCompliant ? !hasNonCompliant : hasNonCompliant;
                });
            }
            if (vendorAttachment) {
                const isAttached = vendorAttachment[0] === 'Attached';
                dataToFilter = dataToFilter.filter(p => (isAttached ? (p.approvedVendors && p.approvedVendors.length > 0) : (!p.approvedVendors || p.approvedVendors.length === 0)));
            }
            if (specificationAttachment) {
                const isAttached = specificationAttachment[0] === 'Attached';
                dataToFilter = dataToFilter.filter(p => (isAttached ? !!p.specificationName : !p.specificationName));
            }
            if (brandAttachment) {
                const isAttached = brandAttachment[0] === 'Attached';
                dataToFilter = dataToFilter.filter(p => (isAttached ? (p.variants && p.variants.length > 0) : (!p.variants || p.variants.length === 0)));
            }
            if (productName?.length) dataToFilter = dataToFilter.filter(p => productName.includes(p.productName));
            if (riskCategory?.length) dataToFilter = dataToFilter.filter(p => riskCategory.includes(getHighestRiskForProduct(p)));
            if (approvedVendors?.length) dataToFilter = dataToFilter.filter(p => approvedVendors.some(v => (p.vendorNames || []).includes(v)));
    
            // Filter Variants within the remaining products
            const { brand, allergens, storageTemp,instructionHandles, coaStatus, coaExpiry, complianceStatus, reviewStatus, lastReview, riskLevel, allergenProfile, brandStatus, imageAttachment } = activeFilters;
            
            const filtered = dataToFilter.map(product => {
                if (!product.variants || product.variants.length === 0) {
                    const hasVariantFilters = Object.keys(activeFilters).some(k => ['brand', 'allergens', 'storageTemp', 'instructionHandles','coaStatus', 'coaExpiry', 'complianceStatus', 'reviewStatus', 'lastReview', 'riskLevel', 'allergenProfile', 'brandStatus', 'imageAttachment'].includes(k));
                    return hasVariantFilters ? null : product;
                }
    
                const filteredVariants = product.variants.filter(variant => {
                    let match = true;
                    if (brand?.length && !brand.includes(variant.brand)) match = false;
                    if (brandStatus) {
                        const isActive = brandStatus[0] === 'Active';
                        if (variant.isActive !== isActive) match = false;
                    }
                    if (imageAttachment) {
                        const isAttached = imageAttachment[0] === 'Attached';
                        if (isAttached ? !variant.imageUrl : !!variant.imageUrl) match = false;
                    }
                    if (riskLevel) {
                        if(riskLevel[0] === 'Not Identified') {
                            if (!!variant.riskLevel) match = false;
                        } else if (!riskLevel.includes(variant.riskLevel)) {
                            match = false;
                        }
                    }
                    if (allergens?.length && !allergens.some(a => (variant.allergens || []).includes(a))) match = false;
                    if (storageTemp?.length && !storageTemp.some(s => (variant.storageTemp || []).includes(s))) match = false;
                    if (instructionHandles?.length && !instructionHandles.some(s => (variant.instructionHandles || []).includes(s))) match = false;
                    
                    
                    if (allergenProfile) {
                        const hasAllergens = variant.allergens && variant.allergens.length > 0 && !(variant.allergens.length === 1 && variant.allergens[0] === 'None');
                        if (allergenProfile[0] === 'Allergen' && !hasAllergens) match = false;
                        if (allergenProfile[0] === 'Allergen-Free' && hasAllergens) match = false;
                    }
                    
                    const currentCoaStatus = getCoaStatus(variant);
                    if(coaStatus?.length) {
                        if (coaStatus.includes('Due Soon')) {
                            const today = new Date();
                            const thirtyDaysFromNow = new Date();
                            thirtyDaysFromNow.setDate(today.getDate() + 30);
                            const expiryDate = new Date(variant.coaExpiry);
                            if (!(expiryDate >= today && expiryDate <= thirtyDaysFromNow)) match = false;
                        } else if (!coaStatus.includes(currentCoaStatus)) {
                             match = false;
                        }
                    }
    
                    if (complianceStatus) {
                         if (complianceStatus[0] === 'Pending') {
                            if(variant.complianceStatus === 'Compliant' || variant.complianceStatus === 'Non-compliant') match = false;
                         } else if (!complianceStatus.includes(variant.complianceStatus)) {
                            match = false;
                         }
                    }
                    if (reviewStatus?.length && !reviewStatus.includes(getReviewStatus(variant))) match = false;
                    
                    if (coaExpiry) {
                        const expiryDate = variant.coaExpiry ? new Date(variant.coaExpiry) : null;
                        if (!expiryDate || (coaExpiry.from && expiryDate < new Date(coaExpiry.from)) || (coaExpiry.to && expiryDate > new Date(coaExpiry.to))) match = false;
                    }
                    if (lastReview) {
                        const reviewDate = variant.lastReview ? new Date(variant.lastReview) : null;
                        if (!reviewDate || (lastReview.from && reviewDate < new Date(lastReview.from)) || (lastReview.to && reviewDate > new Date(lastReview.to))) match = false;
                    }
                    return match;
                });
    
                if (filteredVariants.length > 0) {
                    return {...product, variants: filteredVariants};
                }
                return null;
            }).filter(Boolean);
    
            // filteredData = filtered.sort((a,b) => new Date(b.lastUpdated) - new Date(a.lastUpdated));
            filteredData = filtered.sort((a,b) => b.productId - a.productId);

        }
    
    
        // function setupPagination() {
        //     const paginationWrapper = document.getElementById('pagination-wrapper');
        //     const summaryEl = document.getElementById('pagination-summary');
        //     paginationWrapper.innerHTML = '';
    
        //     const totalRows = filteredData.length;
        //     if (totalRows === 0) {
        //         summaryEl.textContent = 'No results found';
        //         return;
        //     }
    
        //     const totalPages = Math.ceil(totalRows / rowsPerPage);
        //     const startItem = (currentPage - 1) * rowsPerPage + 1;
        //     const endItem = Math.min(currentPage * rowsPerPage, totalRows);
            
        //     summaryEl.textContent = `Showing ${startItem}-${endItem} of ${totalRows}`;
    
        //     let paginationHtml = '<nav><ul class="pagination mb-0">';
            
        //     const prevDisabled = currentPage === 1 ? 'disabled' : '';
        //     paginationHtml += `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
            
        //     for (let i = 1; i <= totalPages; i++) {
        //          const activeClass = i === currentPage ? 'active' : '';
        //          paginationHtml += `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        //     }
    
        //     const nextDisabled = currentPage === totalPages ? 'disabled' : '';
        //     paginationHtml += `<li class="page-item ${nextDisabled}"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
            
        //     paginationHtml += '</ul></nav>';
        //     paginationWrapper.innerHTML = paginationHtml;
        // }
        
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
        
            // Prev Button
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            paginationHtml += `<li class="page-item ${prevDisabled}">
                <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
            </li>`;
        
            // ---- Page Numbers with "..." ----
            const maxVisible = 5; // how many page numbers to show around current
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, currentPage + 2);
        
            if (currentPage <= 3) {
                endPage = Math.min(totalPages, maxVisible);
            }
            if (currentPage >= totalPages - 2) {
                startPage = Math.max(1, totalPages - (maxVisible - 1));
            }
        
            // Show first page
            if (startPage > 1) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>`;
                if (startPage > 2) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }
        
            // Loop visible pages
            for (let i = startPage; i <= endPage; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                paginationHtml += `<li class="page-item ${activeClass}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            }
        
            // Show last page
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a></li>`;
            }
        
            // Next Button
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            paginationHtml += `<li class="page-item ${nextDisabled}">
                <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
            </li>`;
        
            paginationHtml += '</ul></nav>';
            paginationWrapper.innerHTML = paginationHtml;
        }

    
        function renderTable(pageProducts, pageStartIndex) {
            console.log("check pageProducts",pageProducts)
            tableBody.innerHTML = '';
            tableBody.closest('.table-responsive').id = `table-wrapper-${Date.now()}`;
            nextDataId = Math.max(0, ...productData.flatMap(p => p.variants.map(v => v.id))) + 1;
    
            if (pageProducts.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="10" class="text-center p-5">No matching records found.</td></tr>`;
                return;
            }
            
            pageProducts.forEach((product, groupIndex) => {
                const { productName,vendorNames, corporateName,is_stockable,is_yield, regionalName, unitName, specificationName, approvedVendors, variants, productId, createdBy, authId,specificationView,riskLevel } = product;
                 const rowspan = Math.max(1, (variants || []).length); 
    
                const isGroupInactive = !product.isProductActive;
                const disabledAttr = isGroupInactive ? 'disabled' : '';
    
                const highestRisk = getHighestRiskForProduct(product);
                const riskContent = highestRisk !== 'Data Not Added'
                    ? `<span class="risk-badge risk-${highestRisk.toLowerCase().replace(' ','-')}">${highestRisk}</span>`
                    : `<span class="risk-badge risk-na">Not Added</span>`;
    
                // const vendorCellContent = `<div class="vendor-cell-content"><div class="vendor-cell-header"><span class="detail-label text-uppercase fw-bold">Vendors</span><button class="icon-button add-vendor-btn" data-product-name="${productName}" title="Add New Vendor" ${disabledAttr}>${ICONS.plus}</button>
                // </div>${(approvedVendors || []).map(vendor => `<div class="vendor-list-item"><span>${vendor}</span><button class="icon-button remove-vendor-btn" data-product-name="${productName}" data-vendor-name="${vendor}" title="Remove Vendor" ${disabledAttr}>${ICONS.trash}</button></div>`).join('')}</div>`;
                const vendorsArray = vendorNames ? vendorNames.split(",") : [];
                
                const vendorCellContent = `
                  <div class="vendor-cell-content">
                    <div class="vendor-cell-header">
                      <span class="detail-label text-uppercase fw-bold">Vendors</span>
                      <button class="icon-button add-vendor-btn" data-product-id="${productId}" data-product-name="${productName}" title="Add New Vendor" ${disabledAttr}>
                        ${ICONS.plus}
                      </button>
                    </div>
                    ${vendorsArray.map(vendor => `
                      <div class="vendor-list-item">
                        <span>${vendor.trim()}</span>
                        <button class="icon-button remove-vendor-btn"
                                data-product-id="${productId}"
                                data-product-name="${productName}" 
                                data-vendor-name="${vendor.trim()}" 
                                title="Remove Vendor" ${disabledAttr}>
                          ${ICONS.trash}
                        </button>
                      </div>
                    `).join('')}
                  </div>`;
  
                const productStatusButtonText = product.isProductActive ? 'Deactivate' : 'Activate';
                const productStatusButtonClass = product.isProductActive ? 'deactivate' : 'activate';
    
                const metaInfoHTML = [corporateName, regionalName, unitName].filter(Boolean).join(' &bull; ');
                
                const firstRow = document.createElement('tr');
                if (isGroupInactive) firstRow.classList.add('inactive-row');
    
                // const specContent = specificationName
                //     ? `<div class="name-wrapper"><button class="btn btn-sm btn-outline-secondary view-spec-btn" data-spec-name="${specificationName}" style="flex-grow:1; justify-content: flex-start;">View Specification</button><div class="cell-actions"><a href="#" class="view-link edit-spec-btn" data-product-name="${productName}" data-product-id="${productId}" data-current-spec="${specificationName}" ${disabledAttr}>Edit</a></div></div>`
                //     : `<div class="name-wrapper"><span class="detail-label">Specification: Data not added</span><div class="cell-actions"><a href="#" class="view-link edit-spec-btn" data-product-name="${productName}"  data-product-id="${productId}" data-current-spec="" ${disabledAttr}>Add</a></div></div>`;
                
                
                const specContent = specificationName
                    ? `<div class="name-wrapper"><button class="btn btn-sm btn-outline-secondary view-spec-btn" data-spec-name="${specificationName}" data-spec-view="${specificationView}" style="flex-grow:1; justify-content: flex-start;">View Specification</button><div class="cell-actions"><a href="#" class="view-link edit-spec-btn" data-product-name="${productName}" data-product-id="${productId}" data-current-spec="${specificationName}" ${disabledAttr}>Edit</a></div></div>`
                    : `<div class="name-wrapper"><span class="detail-label">Specification: Data not added</span><div class="cell-actions"><a href="#" class="view-link edit-spec-btn" data-product-name="${productName}"  data-product-id="${productId}" data-current-spec="" ${disabledAttr}>Add</a></div></div>`;
                
                
                firstRow.innerHTML = `
                
                    <td rowspan="${rowspan}" class="sl-no-col">${pageStartIndex + groupIndex + 1}.</td>
                    <td rowspan="${rowspan}" class="product-name-col">
                        <div class="product-name-cell">
                            <div class="name-wrapper"><span class="name editable-text" data-product-name="${productName}">${productName}</span>
                                <span class="delete-btn" 
                                  data-product-id="${productId}" 
                                    data-created-by="${createdBy}" 
                                    data-auth-id="${authId}" 
                                     style="cursor:pointer"
                                     title="Delete"
                                  >
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     class="delete-icon" 
                                     viewBox="0 0 24 24" 
                                     width="20" 
                                     height="20">
                                  <path fill="red" d="M3 6h18v2H3V6zm2 3h14l-1.5 13h-11L5 9zm4 2v9h2v-9H9zm4 0v9h2v-9h-2z"/>
                                </svg>
                              </span>             
                              </div>
                            ${metaInfoHTML ? `<div class="product-meta-info">${metaInfoHTML}</div>` : ''}
                            <div class="product-meta-info fst-italic">Updated on: ${formatDateForDisplay(product.lastUpdated)}</div>
                            <div class="uploaded-by-info mt-2">Uploaded by: <strong>${product.uploadedBy || 'N/A'}</strong></div>
                            <div class="action-toggle-container">
                                <span class="action-toggle-label remove">Remove</span>
                                <label class="action-toggle"><input type="checkbox" checked><span class="slider"></span></label>
                                <span class="action-toggle-label accept">Accept</span>
                            </div>
                            <div class="spec-display-mode" style="margin-top: 12px;">${specContent}</div>
                            <div class="spec-edit-mode">
                                <input type="search" placeholder="Search specifications..." class="form-control form-control-sm mb-2">
                                <div class="spec-options-list"></div>
                                <div class="spec-edit-actions">
                                    <button class="btn btn-sm btn-success save-spec-btn">Save</button>
                                    <button class="btn btn-sm btn-secondary cancel-spec-btn">Cancel</button>
                                </div>
                            </div>
                            <div class="detail-item" style="width:100%; margin-top:8px;">
                                <div class="detail-item-content editable-risk" data-product-name="${productName}" data-product-id="${productId}"><span class="detail-label">Risk:</span>${riskContent}</div>
                                <button class="toggle-status-text-btn ${productStatusButtonClass} toggle-product-status-btn" data-product-name="${productName}">${productStatusButtonText}</button>
                            </div>
                            
                            
                        <div class="mt-1">
                          <label class="merged-cell-label d-block mb-1">Yield</label>
                          <div class="d-flex gap-2">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input yield-radio" type="radio"
                                     name="yield-${productId}" 
                                     id="yield-yes-${productId}" 
                                     value="Yes"
                                     data-variant-id="${productId}"   ${is_yield === 'yes' ? 'checked' : ''}>
                              <label class="form-check-label" for="yield-yes-${productId}" style="font-size:11px">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input yield-radio" type="radio"
                                     name="yield-${productId}" 
                                     id="yield-no-${productId}" 
                                     value="No"
                                     data-variant-id="${productId}"
                                     ${is_yield === 'no' ? 'checked' : ''}>
                              <label class="form-check-label" for="yield-no-${productId}" style="font-size:11px">No</label>
                            </div>
                          </div>
                        </div>

                        <div class="mt-1">
                          <label class="merged-cell-label d-block mb-1">Stockable</label>
                          <div class="d-flex gap-2">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" 
                                     name="stockable-${productId}" 
                                     id="stockable-yes-${productId}" 
                                     value="Yes"
                                     data-variant-id="${productId}"
                                     ${is_stockable === 'yes' ? 'checked' : ''}>
                              <label class="form-check-label" for="stockable-yes-${productId}" style="font-size:11px">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" 
                                     name="stockable-${productId}" 
                                     id="stockable-no-${productId}" 
                                     value="No"
                                     data-variant-id="${productId}"  ${is_stockable === 'no' ? 'checked' : ''}>
                              <label class="form-check-label" for="stockable-no-${productId}" style="font-size:11px">No</label>
                            </div>
                          </div>
                        </div>

                    </div>
                        </div>
                    </td>
                    <td rowspan="${rowspan}" class="vendor-col">${vendorCellContent}</td>`;
                
                if (variants && variants.length > 0) {
                     populateVariantCells(firstRow, variants[0], product, 0);
                } else {
                    console.log("asdsadsa");
                   
                     const addVariantFormHTML = `
                        <div class="add-variant-form">
                            <div class="form-group">
                                <label class="form-label">New Brand Name</label>
                                <div class="custom-multiselect" id="add-variant-brand-select-${productName.replace(/\s+/g, '-')}" data-selected-value="">
                                    <div class="select-button"><span>Select or create a brand...</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path></svg></div>
                                    <div class="dropdown-panel">
                                        <div class="dropdown-panel-body">
                                            <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search or type to create new...">
                                            <div class="dropdown-options"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions"><button class="btn btn-sm btn-secondary cancel-add-variant-btn">Cancel</button><button class="btn btn-sm btn-success save-new-variant-btn" data-product-name="${productName}">Save</button></div>
                        </div>`;
                    firstRow.innerHTML += `
                                           <td><button class="icon-button add-variant-btn" title="Add New Brand" ${disabledAttr}>${ICONS.plus}</button>${addVariantFormHTML}</td>
                                           <td class="text-center text-muted fst-italic">No Brand</td>
                                           <td class="text-center text-muted fst-italic">No Brand</td>
                                           <td class="text-center text-muted fst-italic">No Brand</td>
                                           <td class="text-center text-muted fst-italic">No Brand</td>
                                           <td class="text-center text-muted fst-italic">No Brand</td>`;
                }
                tableBody.appendChild(firstRow);
    
                if (variants) {
                    variants.slice(1).forEach((variant, itemIndex) => {
                        const subsequentRow = document.createElement('tr');
                        if (isGroupInactive || !variant.isActive) subsequentRow.classList.add('inactive-row');
                        subsequentRow.dataset.variantId = variant.id;
                        populateVariantCells(subsequentRow, variant, product, itemIndex + 1);
                        tableBody.appendChild(subsequentRow);
                    });
                     // Add variant id to first row for scroll targeting
                    if (variants.length > 0) {
                        firstRow.dataset.variantId = variants[0].id;
                    }
                }
            });
        }
    
        function updateView() {
            calculateAndRenderDashboard();
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
            const isRowInactive = !variant.isActive || !product.isProductActive;
            const disabledAttr = isRowInactive ? 'disabled' : '';
            const variantStatusButtonText = variant.isActive ? 'Deactivate' : 'Activate';
            const variantStatusButtonClass = variant.isActive ? 'deactivate' : 'activate';
            const rr = variant.receivingReport || {};
            const displayArray = (arr) => arr && arr.length > 0 ? arr.join(', ') : 'N/A';
            const complianceStatusClass = (status) => {
                if (!status) return 'inactive';
                switch(status.toLowerCase()) {
                    case 'compliant': return 'accepted';
                    case 'non-compliant': return 'rejected';
                    default: return 'inactive';
                }
            };
    
            // const imageCellContent = variant.imageUrl
            //     ? `<div class="image-cell-wrapper">
            //             <img src="${variant.imageUrl}" class="table-image" data-bs-toggle="modal" data-bs-target="#image-viewer-modal" data-src="${variant.imageUrl}">
            //             <div class="image-action-buttons">
            //                 <button class="icon-button view-image-btn" title="View Image">${ICONS.view}</button>
            //                   <button class="icon-button edit-image-btn" data-variant-id="${product.productId}" title="Edit Image">${ICONS.edit}</button>
            //                 <button class="icon-button delete-image-btn" data-variant-id="${product.productId}" title="Delete Image">${ICONS.trash}</button>
            //             </div>
            //         </div>`
            //     // : `<div class="image-upload-placeholder" data-variant-id="${product.productId}" title="Upload Image">${ICONS.camera}</div>`;
            //         : `<div class="image-upload-placeholder" data-variant-id="${product.productId}" title="Upload Image">${ICONS.camera}</div>`;
            
            const imageCellContent = variant.imageUrl
            ? `<div class="image-cell-wrapper">
                    <img src="${variant.imageUrl}" class="table-image" data-bs-toggle="modal" data-bs-target="#image-viewer-modal" data-src="${variant.imageUrl}">
                    <div class="image-action-buttons">
                        <button class="icon-button view-image-btn" title="View Image">${ICONS.view}</button>
                        <button class="icon-button edit-image-btn" data-variant-id="${variant.id}" title="Edit Image">${ICONS.edit}</button>
                        <button class="icon-button delete-image-btn" data-variant-id="${variant.id}" title="Delete Image">${ICONS.trash}</button>
                    </div>
               </div>`
            : `<div class="image-upload-placeholder" data-variant-id="${variant.id}" title="Upload Image">${ICONS.camera}</div>`;



    
            const addVariantFormHTML = itemIndex === 0 ? `
                <div class="add-variant-form">
                    <div class="form-group">
                        <label class="form-label">New Brand Name</label>
                         <div class="custom-multiselect" id="add-variant-brand-select" data-selected-value="">
                            <div class="select-button">
                                <span>Select or create a brand...</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="dropdown-panel">
                                <div class="dropdown-panel-body">
                                    <input type="search" class="dropdown-search form-control form-control-sm" placeholder="Search or type to create new...">
                                    <div class="dropdown-options"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-sm btn-secondary cancel-add-variant-btn">Cancel</button>
                        <button class="btn btn-sm btn-success save-new-variant-btn" data-product-name="${product.productName}">Save</button>
                    </div>
                </div>` : '';
    
            const openPoints = variant.complianceTickets?.flatMap(t => t.actionPoints.filter(p => p.status === 'open')) || [];
            const openPointsCount = openPoints.length;
            const viewCommentsBtnText = openPointsCount > 0 ? `${openPointsCount} Open Point${openPointsCount > 1 ? 's' : ''}` : 'View History';
            const commentsCellHTML = `
                <td>
                    <div class="d-flex flex-column align-items-center gap-2">
                        <button class="btn btn-sm ${openPointsCount > 0 ? 'btn-danger' : 'btn-outline-secondary'} view-comments-btn w-100" data-variant-id="${variant.id}">${viewCommentsBtnText}</button>
                       
                        <button class="btn btn-sm btn-outline-primary add-comment-btn w-100" data-variant-id="${variant.id}">Create Ticket</button>
                    </div>
                </td>`;
    
            const cellsHTML = `
                <td>${imageCellContent}</td>
                <td>
                    <div class="detail-list">
                        <div class="detail-item">
                            <div class="detail-item-content"><span class="detail-label">Brand:</span><span class="detail-value editable-text" data-variant-id="${variant.id}" data-field="brand">${variant.brand || 'Not Added'}</span></div>
                            <div class="cell-actions">
                               <button class="icon-button remove-variant-btn" data-variant-id="${variant.id}" title="Remove Brand" ${disabledAttr}>${ICONS.trash}</button>
                               ${itemIndex === 0 ? `<button class="icon-button add-variant-btn" title="Add New Brand" ${disabledAttr}>${ICONS.plus}</button>` : ''}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-item-content"><span class="detail-label">Status:</span><span class="status-badge ${variant.isActive ? 'active' : 'inactive'}">${variant.isActive ? 'Active' : 'Inactive'}</span></div>
                            <button class="toggle-status-text-btn ${variantStatusButtonClass}" data-variant-id="${variant.id}" ${!product.isProductActive ? 'disabled' : ''}>${variantStatusButtonText}</button>
                        </div>
                    </div>
                    ${addVariantFormHTML}
                </td>
                <td>
                    <div class="detail-list">
                        <div class="detail-item"><div class="detail-item-content"><span class="detail-label">Allergens:</span><span class="detail-value editable-multiselect" data-variant-id="${variant.id}" data-field="allergens">${displayArray(variant.allergens)}</span></div></div>
                        <div class="detail-item"><div class="detail-item-content"><span class="detail-label">Storage:</span><span class="detail-value editable-multiselect" data-variant-id="${variant.id}" data-field="storageTemp">${displayArray(variant.storageTemp)}</span></div></div>
                         <div class="detail-item"><div class="detail-item-content"><span class="detail-label">Special Handling Instruction:</span><span class="detail-value editable-multiselect" data-variant-id="${variant.id}" data-field="instructionHandles">
                         ${displayArray(variant.instructionHandles)}</span></div></div>
                    </div>
                </td>
                <td>
                    <div class="detail-list">
                        <div class="detail-item">
                            <div class="detail-item-content">
                                <span class="detail-label">Testing:</span>
                                <span class="detail-value">${variant.coaExpiry ? formatDateForDisplay(variant.coaExpiry) : 'COA is not added'}</span>
                            </div>
                            <div class="cell-actions">
                                 ${variant.coaExpiry 
                                  ? `<a href="${variant.coa_latest_pdf}" download class="view-link" data-variant-id="${variant.id}" title="View Latest COA PDF">View PDF</a>` 
                                  : ''}


                                 <button class="icon-button coa-history-btn" data-variant-id="${variant.id}" title="COA History">${ICONS.history}</button>
                            </div>
                        </div>
                         <div class="detail-item" style="justify-content:center; margin-top: 8px;">
                            <button class="toggle-status-text-btn renew-coa" data-variant-id="${variant.id}" data-brand-name="${variant.brand}" ${disabledAttr}>Renew COA</button>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="detail-list">
                        <div class="detail-item"><div class="detail-item-content"><span class="detail-label">Last Rcvd:</span><span class="detail-value">${formatDateForDisplay(rr.lastReceivingDate)}</span></div> <button class="icon-button receiving-history-btn" data-variant-id="${variant.id}" title="Receiving History">${ICONS.history}</button></div>
                        <div class="detail-item"><div class="detail-item-content"><span class="detail-label">Vendor:</span><span class="detail-value">${rr.vendorName || 'N/A'}</span></div></div>
                        <div class="detail-item"><div class="detail-item-content"><span class="detail-label">Qty (Acc/Rej):</span><span class="detail-value">${rr.acceptedQty || 0} / ${rr.rejectedQty || 0}</span></div></div>
                        <div class="detail-item">
                            <div class="detail-item-content">
                                <span class="detail-label">Form E:</span>
                                <span class="status-badge ${complianceStatusClass(rr.formEStatus)}">${rr.formEStatus || 'N/A'}</span>
                            </div>
                            <a href="#" class="view-link">View</a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="detail-list">
                         <div class="detail-item">
                            <div class="detail-item-content"><span class="detail-label">Reviewed On:</span><span class="detail-value">${formatDateForDisplay(variant.lastReview)}</span></div>
                         </div>
                         <div class="detail-item">
                             <div class="detail-item-content"><span class="detail-label">Status:</span><span class="status-badge ${complianceStatusClass(variant.complianceStatus)}">${variant.complianceStatus || 'Pending'}</span></div>
                         </div>
                         <div class="detail-item">
                            <div class="detail-item-content"><span class="detail-label">Next Review:</span><span class="detail-value">${formatDateForDisplay(variant.nextReviewDate)}</span></div>
                         </div>
                         <div class="detail-item">
                            <a href="#" class="view-link packet-audit-btn" data-variant-id="${variant.id}" title="Ingredients Packet Audit">View Audit</a>
                         </div>
                         <div class="detail-item" style="justify-content:center; margin-top: 8px;">
                            <button class="btn btn-sm btn-success" data-variant-id="${variant.id}">Start Audit</button>
                         </div>
                    </div>
                </td>
                ${commentsCellHTML}`;
            
            rowElement.innerHTML += cellsHTML;
        }
        
        function levenshteinDistance(s1, s2) {
            s1 = s1.toLowerCase();
            s2 = s2.toLowerCase();
            const costs = [];
            for (let i = 0; i <= s1.length; i++) {
                let lastValue = i;
                for (let j = 0; j <= s2.length; j++) {
                    if (i === 0) {
                        costs[j] = j;
                    } else {
                        if (j > 0) {
                            let newValue = costs[j - 1];
                            if (s1.charAt(i - 1) !== s2.charAt(j - 1)) {
                                newValue = Math.min(Math.min(newValue, lastValue), costs[j]) + 1;
                            }
                            costs[j - 1] = lastValue;
                            lastValue = newValue;
                        }
                    }
                }
                if (i > 0) {
                    costs[s2.length] = lastValue;
                }
            }
            return costs[s2.length];
        }
        
        $(document).on('change', '.yield-radio', function() {
            const variantId = $(this).data('variant-id');
            const value = $(this).val();
            $.ajax({
                url: "{{route('save.yield.raw.material')}}",
                method: 'POST',
                data: {
                    variant_id: variantId,
                    yield_value: value,
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    toastr.success('Yield Added Successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating yield:', error);
                    // Optional: show error message or revert change
                }
            });
        });
    
        function downloadSampleCSV() {
            const headers = "productName";
            const exampleRows = [
                "Whey Protein Isolate",
                "Creatine Monohydrate",
                "Omega-3 Fish Oil"
                
            ].join("\n");
            const csvContent = "data:text/csv;charset=utf-8," + headers + "\n" + exampleRows;
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "bulk_upload_sample.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    
        function handleCSVUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const text = e.target.result;
                    const rows = text.split('\n').filter(row => row.trim() !== '');
                    if (rows.length < 2) throw new Error("CSV file must contain a header and at least one data row.");
                    const headers = rows.shift().trim().split(',').map(h => h.replace(/"/g, ''));
                    if (!headers.includes('productName')) {
                        throw new Error(`CSV must contain the following header: productName.`);
                    }
                    
                    const parsedData = rows.map(row => {
                        const values = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g) || [];
                        let obj = {};
                        headers.forEach((header, index) => obj[header] = values[index] ? values[index].replace(/"/g, '').trim() : '');
                        return obj;
                    });
    
                    const newProductGroups = {};
                    const matchedProductGroups = {};
    
                    parsedData.forEach(item => {
                        const { productName } = item;
                        if (!productName) return;
    
                        let bestMatch = null;
                        let bestSimilarity = 0;
                        let bestMatchName = '';
    
                        productData.forEach(p => {
                            const dist = levenshteinDistance(productName, p.productName);
                            const similarity = (1 - (dist / Math.max(productName.length, p.productName.length))) * 100;
                            if (similarity > bestSimilarity) {
                                bestSimilarity = similarity;
                                bestMatch = p;
                                bestMatchName = p.productName;
                            }
                        });
    
                        if (bestMatch && bestSimilarity >= 75) {
                            if (!matchedProductGroups[bestMatchName]) {
                                matchedProductGroups[bestMatchName] = {
                                    productName: bestMatchName,
                                    uploadedNames: [],
                                    status: 'accepted'
                                };
                            }
                            matchedProductGroups[bestMatchName].uploadedNames.push({
                                csvName: productName,
                                similarity: bestSimilarity
                            });
                        } else {
                            if (!newProductGroups[productName]) {
                                newProductGroups[productName] = {
                                    productName: productName,
                                    status: 'accepted'
                                };
                            }
                        }
                    });
                    
                    tempCsvData = {
                        matched: Object.values(matchedProductGroups),
                        new: Object.values(newProductGroups)
                    };
                    
                    showCsvReviewModal();
                } catch (error) {
                    alert(`Error processing CSV file: ${error.message}`);
                }
            };
            reader.readAsText(file);
            csvUploadInput.value = ''; 
        }
    
    
        function showCsvReviewModal() {
            const { matched, new: newData } = tempCsvData;
            const reviewBody = document.getElementById('review-csv-body');
        
            const createReviewTable = (title, products, type) => {
                const actionButtons = products.length > 0 ?
                    `<div class="cell-actions btn-group">
                        <button class="btn btn-sm btn-outline-success accept-all-btn" data-type="${type}">Accept All</button>
                        <button class="btn btn-sm btn-outline-danger reject-all-btn" data-type="${type}">Reject All</button>
                    </div>` : '';
        
                let html = `<div class="review-table-header d-flex justify-content-between align-items-center mb-2">
                                <h4>${title} (${products.length})</h4>
                                ${actionButtons}
                            </div>`;
        
                if (products.length === 0) {
                    return html + '<p class="text-muted">No items to review in this category.</p>';
                }
        
                if (type === 'matched') {
                    html += `<table class="table table-sm review-table"><thead><tr><th>Database Product Name</th><th>Uploaded Name (Match %)</th><th>Actions</th></tr></thead><tbody>`;
                    products.forEach((product, productIndex) => {
                        const isRejected = product.status === 'rejected';
                        const isAccepted = product.status === 'accepted';
                        const uploadedNamesHTML = product.uploadedNames.map((up) => `
                            <li class="d-flex align-items-center justify-content-between">
                                <div class="product-name-display-container">
                                    <span>'${up.csvName}' <small class="text-muted">(${up.similarity.toFixed(0)}%)</small></span>
                                    <button class="icon-button edit-product-review-btn ms-2">${ICONS.edit}</button>
                                </div>
                                <div class="product-name-edit-container input-group input-group-sm">
                                    <input type="text" class="form-control" value="${up.csvName}">
                                    <button class="btn btn-outline-success save-product-review-btn">Save</button>
                                    <button class="btn btn-outline-secondary cancel-product-review-btn">X</button>
                                </div>
                            </li>`
                        ).join('');
        
                        html += `<tr class="${isRejected ? 'rejected-group' : isAccepted ? 'accepted-group' : ''}" data-type="${type}" data-product-index="${productIndex}">
                            <td><strong>${product.productName}</strong></td>
                            <td><ul class="list-unstyled mb-0">${uploadedNamesHTML}</ul></td>
                            <td><div class="cell-actions btn-group">
                                <button class="btn btn-sm btn-outline-success accept review-btn" title="Accept">Accept</button>
                                <button class="btn btn-sm btn-outline-danger reject review-btn" title="Reject">Reject</button>
                            </div></td></tr>`;
                    });
                } else { // type === 'new'
                    html += `<table class="table table-sm review-table"><thead><tr><th>New Product Name to Add</th><th>Actions</th></tr></thead><tbody>`;
                    products.forEach((product, productIndex) => {
                        const isRejected = product.status === 'rejected';
                        const isAccepted = product.status === 'accepted';
                        html += `<tr class="${isRejected ? 'rejected-group' : isAccepted ? 'accepted-group' : ''}" data-type="${type}" data-product-index="${productIndex}">
                            <td>
                                 <div class="d-flex align-items-center justify-content-between">
                                    <div class="product-name-display-container">
                                        <span>${product.productName}</span>
                                        <button class="icon-button edit-product-review-btn ms-2">${ICONS.edit}</button>
                                    </div>
                                    <div class="product-name-edit-container input-group input-group-sm">
                                        <input type="text" class="form-control" value="${product.productName}">
                                        <button class="btn btn-outline-success save-product-review-btn">Save</button>
                                        <button class="btn btn-outline-secondary cancel-product-review-btn">X</button>
                                    </div>
                                </div>
                            </td>
                            <td><div class="cell-actions btn-group">
                                <button class="btn btn-sm btn-outline-success accept review-btn" title="Accept">Accept</button>
                                <button class="btn btn-sm btn-outline-danger reject review-btn" title="Reject">Reject</button>
                            </div></td></tr>`;
                    });
                }
                return html + '</tbody></table>';
            };
        
            // Render HTML
            reviewBody.innerHTML = createReviewTable('Suggested Matches', matched, 'matched') + '<hr>' +
                                   createReviewTable('New Ingredients', newData, 'new');
        
            // === Event Handlers ===
        
        // Accept/Reject single
         reviewBody.querySelectorAll('.review-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const row = this.closest('tr');
                const type = row.dataset.type;              
                const index = parseInt(row.dataset.productIndex, 10);
                const action = this.classList.contains('accept') ? 'accepted' : 'rejected';
        
                const product = tempCsvData[type][index];
        
               let uploadedNames = [];
               if (product.uploadedNames) {
                    if (Array.isArray(product.uploadedNames)) {
                    uploadedNames = product.uploadedNames.map(u => {
                        if (typeof u === 'object') {
                            return u.uploadedName || u.csvName || ""; 
                        }
                        return u;
                        });
                    } else if (typeof product.uploadedNames === 'string') {
                        uploadedNames = product.uploadedNames.split(',').map(s => s.trim());
                    }
                }
                
                const savedVendor = localStorage.getItem('selectedVendor');

                fetch("{{ route('raw-material-product.storeSingleCsv') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        type: type,
                        productName: product.productName,
                        uploadedNames: uploadedNames,    
                        status: action,
                        savedVendor:savedVendor
                    })
                })
                .then(res => res.json())
                  .then(data => {
                          if (data.success) {
                              toastr.success(data.message);
                          } else {
                              setTimeout(()=>{
                              toastr.error("Save failed!");
                                  
                              },2000);
                            //   location.reload()
                             reloadGetData();
                          }
                         localStorage.removeItem('selectedVendor');
                      })
                .catch(error => {
                    console.error("Save Error:", error);
                    toastr.error("Server error occurred!");
                    localStorage.removeItem('selectedVendor');
                });
            });
        });


        // // Accept All / Reject All
        reviewBody.querySelectorAll('.accept-all-btn, .reject-all-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const type = this.dataset.type;             
                const action = this.classList.contains('accept-all-btn') ? 'accepted' : 'rejected';
        
                const items = tempCsvData[type] || [];
                if (items.length === 0) return;

                const products = items.map(item => {
                    let uploadedNames = [];
                    if (item.uploadedNames) {
                        if (Array.isArray(item.uploadedNames)) {
                            uploadedNames = item.uploadedNames.map(u => 
                                typeof u === 'object' ? u.csvName : u
                            );
                        } else if (typeof item.uploadedNames === 'string') {
                            uploadedNames = item.uploadedNames.split(',').map(s => s.trim());
                        }
                    }
                    return {
                        productName: item.productName,
                        uploadedNames: uploadedNames,
                        status: action
                    };
                });
                
                const savedVendor = localStorage.getItem('selectedVendor');

                // alert(savedVendor);
                // alert(type);
                // alert(action);
                // alert(products);
                
                fetch("{{ route('raw-material-product.storeMultipleCsv') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        type: type,
                        status: action,
                        products: products,
                        savedVendor : savedVendor
                    })
                })
                .then(res => res.json())
                .then(data => {

                      if (data.success) {
                          toastr.success(data.message);
                      }else {
                          setTimeOut(()=>{
                            toastr.error("Save failed!");
                          },2000);
                        //   location.reload()
                         reloadGetData();
                      }
                      localStorage.removeItem('selectedVendor');
                 })
                  .catch(error => {
                    console.error("Save Error:", error);
                    // toastr.error("Server error occurred!");
                    localStorage.removeItem('selectedVendor');
                });

            });
        });
        
        
            // Show/hide modal
            if (tempCsvData.matched.length === 0 && tempCsvData.new.length === 0) {
                reviewCsvModal.hide();
                updateView();
            } else {
                reviewCsvModal.show();
            }
        }

    
    
        // function showCsvReviewModal() {
        //     const { matched, new: newData } = tempCsvData;
        //     const reviewBody = document.getElementById('review-csv-body');
            
        //     const createReviewTable = (title, products, type) => {
        //         const actionButtons = products.length > 0 ?
        //             `<div class="cell-actions btn-group">
        //                 <button class="btn btn-sm btn-outline-success accept-all-btn" data-type="${type}">Accept All</button>
        //                 <button class="btn btn-sm btn-outline-danger reject-all-btn" data-type="${type}">Reject All</button>
        //             </div>` : '';
    
        //         let html = `<div class="review-table-header d-flex justify-content-between align-items-center mb-2">
        //                         <h4>${title} (${products.length})</h4>
        //                         ${actionButtons}
        //                     </div>`;
                
        //         if (products.length === 0) {
        //             return html + '<p class="text-muted">No items to review in this category.</p>';
        //         }
                
        //         if (type === 'matched') {
        //             html += `<table class="table table-sm review-table"><thead><tr><th>Database Product Name</th><th>Uploaded Name (Match %)</th><th>Actions</th></tr></thead><tbody>`;
        //             products.forEach((product, productIndex) => {
        //                 const isRejected = product.status === 'rejected';
        //                 const uploadedNamesHTML = product.uploadedNames.map((up) => `
        //                     <li class="d-flex align-items-center justify-content-between">
        //                         <div class="product-name-display-container">
        //                             <span>'${up.csvName}' <small class="text-muted">(${up.similarity.toFixed(0)}%)</small></span>
        //                             <button class="icon-button edit-product-review-btn ms-2">${ICONS.edit}</button>
        //                         </div>
        //                         <div class="product-name-edit-container input-group input-group-sm">
        //                             <input type="text" class="form-control" value="${up.csvName}">
        //                             <button class="btn btn-outline-success save-product-review-btn">Save</button>
        //                             <button class="btn btn-outline-secondary cancel-product-review-btn">X</button>
        //                         </div>
        //                     </li>`
        //                 ).join('');
    
        //                 html += `<tr class="${isRejected ? 'rejected-group' : ''}" data-type="${type}" data-product-index="${productIndex}">
        //                     <td><strong>${product.productName}</strong></td>
        //                     <td><ul class="list-unstyled mb-0">${uploadedNamesHTML}</ul></td>
        //                     <td><div class="cell-actions btn-group">
        //                         <button class="btn btn-sm btn-outline-success accept review-btn" title="Accept">Accept</button>
        //                         <button class="btn btn-sm btn-outline-danger reject review-btn" title="Reject">Reject</button>
        //                     </div></td></tr>`;
        //             });
        //         } else { // type === 'new'
        //             html += `<table class="table table-sm review-table"><thead><tr><th>New Product Name to Add</th><th>Actions</th></tr></thead><tbody>`;
        //             products.forEach((product, productIndex) => {
        //                 const isRejected = product.status === 'rejected';
        //                 html += `<tr class="${isRejected ? 'rejected-group' : ''}" data-type="${type}" data-product-index="${productIndex}">
        //                     <td>
        //                          <div class="d-flex align-items-center justify-content-between">
        //                             <div class="product-name-display-container">
        //                                 <span>${product.productName}</span>
        //                                 <button class="icon-button edit-product-review-btn ms-2">${ICONS.edit}</button>
        //                             </div>
        //                             <div class="product-name-edit-container input-group input-group-sm">
        //                                 <input type="text" class="form-control" value="${product.productName}">
        //                                 <button class="btn btn-outline-success save-product-review-btn">Save</button>
        //                                 <button class="btn btn-outline-secondary cancel-product-review-btn">X</button>
        //                             </div>
        //                         </div>
        //                     </td>
        //                     <td><div class="cell-actions btn-group">
        //                         <button class="btn btn-sm btn-outline-success accept review-btn" title="Accept">Accept</button>
        //                         <button class="btn btn-sm btn-outline-danger reject review-btn" title="Reject">Reject</button>
        //                     </div></td></tr>`;
        //             });
        //         }
        //         return html + '</tbody></table>';
        //     };
    
        //     reviewBody.innerHTML = createReviewTable('Suggested Matches', matched, 'matched') + '<hr>' +
        //                           createReviewTable('New Ingredients', newData, 'new');
            
        //     if (tempCsvData.matched.length === 0 && tempCsvData.new.length === 0) {
        //         reviewCsvModal.hide();
        //         updateView();
        //     } else {
        //         reviewCsvModal.show();
        //     }
        // }
    
    
        function addProductToMainData(product, type) {
            if (type === 'new') {
                const newProduct = {
                    productName: product.productName,
                    lastUpdated: new Date().toISOString(),
                    uploadedBy: "Bulk Upload",
                    isProductActive: true,
                    approvedVendors: selectedVendorForUpload ? [selectedVendorForUpload] : [],
                    variants: [{
                        id: nextDataId++,
                        brand: product.productName, 
                        riskLevel: null,
                        isActive: true,
                        imageUrl: null,
                        allergens: [],
                        storageTemp: [],
                        instructionHandles:[],
                        coaExpiry: null, 
                        lastReview: null, 
                        complianceStatus: 'Pending', 
                        nextReviewDate: null, 
                        receivingReport: { status: 'pending' }, 
                        complianceTickets: []
                    }]
                };
                if (!productData.some(p => p.productName.toLowerCase() === newProduct.productName.toLowerCase())) {
                     productData.unshift(newProduct);
                }
            }
        }
        
        document.getElementById('upload-csv-btn').addEventListener('click', () => openSelectVendorModal());
        document.getElementById('download-sample-csv-btn').addEventListener('click', downloadSampleCSV);
        csvUploadInput.addEventListener('change', handleCSVUpload);
        document.getElementById('done-csv-review-btn').addEventListener('click', () => {
            reviewCsvModal.hide();
            updateView();
        });
    
        tableBody.addEventListener('click', handleMainTableClicks);
        tableBody.addEventListener('dblclick', handleDoubleClickEdit);
        document.getElementById('review-csv-body').addEventListener('click', (e) => handleReviewModalClicks(e));
        
        function openDummyPdf() {
            const pdfWindow = window.open("");
            pdfWindow.document.write(`<iframe width='100%' height='100%' src='data:application/pdf;base64, ${dummyPdfBase64}'></iframe>`);
            pdfWindow.document.title = "COA Document";
        }
    
        function handleMainTableClicks(e) {
            const target = e.target;
            const placeholder = target.closest('.image-upload-placeholder');
            
            // if (placeholder) {
            //     const imageInput = document.getElementById('image-upload-input');
            //     imageInput.dataset.variantId = placeholder.dataset.variantId;
            //     imageInput.click();
            //     return;
            // }
            
            const button = target.closest('button');
            const link = target.closest('a');
    
            if (!button && !link) return;
            
            const element = button || link;
            if (element.hasAttribute('disabled')) {
                return;
            }
    
            const productName = element.dataset.productName;
             const productId = element.dataset.productId;
            const variantId = element.dataset.variantId;
            if (element.matches('.edit-spec-btn')) {
                e.preventDefault();
                const cell = element.closest('.product-name-cell');
                const currentSpec = element.dataset.currentSpec;
                showSpecEdit(cell, productName,productId, currentSpec);
            } else if (element.matches('.view-spec-btn')) {
                alert(`Simulating opening specification PDF for: ${element.dataset.specName}`);
                
                  const appUrl = "{{ rtrim(config('app.url'), '/') }}";
                    const filePath = element.dataset.specView; 
                    const url = `${appUrl}/inspection/${filePath}`;
                    
                    window.open(url, '_blank');
    
            } else if (element.matches('.toggle-product-status-btn')) {
                const product = productData.find(p => p.productName === productName);
                if (product) {
                    const action = product.isProductActive ? 'deactivate' : 'activate';
                    if (confirm(`Are you sure you want to ${action} the product "${productName}"? This will visually ${action} all its associated brands.`)) {
                        product.isProductActive = !product.isProductActive;
                        updateProductTimestamp(productName);
                        updateView();
                    }
                }
            } else if (element.matches('.add-variant-btn')) {
                const form = element.closest('td').querySelector('.add-variant-form');
                if (form) {
                    document.querySelectorAll('.add-variant-form').forEach(f => f.style.display = 'none');
                    form.style.display = 'flex';
                    const brandSelect = form.querySelector('.custom-multiselect');
                    populateBrandSelector(brandSelect, '');
                    brandSelect.querySelector('input.dropdown-search').focus();
                }
            } else if (element.matches('.cancel-add-variant-btn')) {
                element.closest('.add-variant-form').style.display = 'none';
            } else if (element.matches('.save-new-variant-btn')) {
                const form = element.closest('.add-variant-form');
                const brandSelect = form.querySelector('.custom-multiselect');
                const brandName = brandSelect.dataset.selectedValue;
                const product = productData.find(p => p.productName === productName);
                
                
                if (!brandName) {
                    alert('Brand name is required.');
                    return;
                }
                
                if (!product) {
                    alert('Product not found.');
                    return;
                }


    
                if (product && brandName && product.variants.some(v => v.brand.toLowerCase() === brandName.toLowerCase())) {
                    alert(`The brand "${brandName}" has already been added to this product.`);
                    return;
                }
                
                
                if (brandName && product) {
                    
                    $.ajax({
                        url: "{{route('sqa.raw.material.add.variant')}}", 
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            product_detail_id: product.productId,
                            brand_name: brandName
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                        },
                        success: function(data) {
                            if (data.success) {
                                console.log("data",data.variant.sqa_brand_name)
                                const newVariant = {
                                    id: data.variant.id,
                                    brand: data.variant.sqa_brand_name,
                                    riskLevel: null, // You can get this from the server response if needed
                                    isActive: data.variant.status,
                                    imageUrl: data.variant.image_url || null,
                                    allergens: [],
                                    storageTemp: [],
                                    instructionHandles:[],
                                    lastReview: null,
                                    complianceStatus: 'Pending',
                                    nextReviewDate: null,
                                    receivingReport: { status: 'pending' },
                                    complianceTickets: []
                                };
                                console.log("newVariantnewVariant",newVariant)
                                product.variants.push(newVariant);
                                updateProductTimestamp(productName);
                                updateView();
                    
                                 toastr.success(`Variant added successfully!`); 
                                 setTimeout(()=>{
                                     
                                    //  location.reload()
                              
                                    //  reloadGetData();
                                 },2000)
                            } else {
                                  toastr.error(`Error: ${data.message}`); 
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            let errorMessage = "An unknown error occurred.";
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (errorThrown) {
                                errorMessage = errorThrown;
                            }
                    
                           toastr.error("Failed to create new variant. Error: " + errorMessage); 
                        }
                    });

                    //  const newVariant = {
                    //     id: nextDataId++, brand: brandName, riskLevel: null,
                    //     isActive: true, imageUrl: null, allergens: [], storageTemp: [],
                    //     lastReview: null, complianceStatus: 'Pending', nextReviewDate: null,
                    //     receivingReport: { status: 'pending' }, complianceTickets: []
                    // };
                    // product.variants.push(newVariant);
                    // updateProductTimestamp(productName);
                    // updateView();
                } else if (!brandName) {
                    alert('Brand name is required.');
                }
            } else if (element.matches('.add-vendor-btn')) {
                openAddVendorModal(productName,productId);
            } else if (element.matches('.remove-vendor-btn')) {
                // const vendorName = element.dataset.vendorName;
                // if (confirm(`Are you sure you want to remove vendor "${vendorName}" from "${productName}"?`)) {
                //     const product = productData.find(p => p.productName === productName);
                //     if (product && product.approvedVendors) {
                //         product.approvedVendors = product.approvedVendors.filter(v => v !== vendorName);
                //         updateProductTimestamp(productName);
                //         updateView();
                //     }
                // }
                
                
                const vendorName = element.dataset.vendorName;
                const productId  = element.dataset.productId; 
                    if (confirm(`Are you sure you want to remove vendor "${vendorName}" from "${productName}"?`)) {
                        $.ajax({
                            url: "{{ route('delete-sqa-raw-material-vendor') }}", 
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}", 
                                product_name: productName,
                                vendor_name: vendorName,
                                product_id:productId
                            },
                            success: function (response) {
                                if (response.success) {
                                    toastr.success(response.message); 
                                    setTimeout(()=>{
                                        //  location.reload();
                                         reloadGetData();
                                    },3000)
                                } else {
                                    toastr.error(response.message || "Something went wrong!");
                                }
                            },
                            error: function (xhr) {
                                toastr.error("Server error occurred.");
                            }
                        });
                    }

            } else if (element.matches('.renew-coa')) {
                const brandName = element.dataset.brandName;
                openRenewCoaModal(variantId, brandName);
            } else if (element.matches('.remove-variant-btn')) {
                 const variant = findVariantById(variantId);
                 if (confirm(`Are you sure you want to permanently remove the brand "${variant.brand}"?`)) {
                        $.ajax({
                            url: "{{route('sqa.raw.material.delete.variant')}}",
                            
                            type: 'GET',
                            dataType: 'json',
                            data: {
                                id: variantId 
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                toastr.success(response.message); 
                                
                                   const product = findProductByVariantId(variantId);
                                    if (product) {
                                        product.variants = product.variants.filter(v => v.id != variantId);
                                        updateProductTimestamp(product.productName);
                                        updateView();
                                    }
                    
                    
                                    setTimeout(()=>{
                                        //  location.reload();
                                        //  reloadGetData();
                                    },3000)
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                    toastr.error("Error: " + (jqXHR.responseJSON.message || 'Unknown error'));
                            }
                        });
                        
                    // const product = findProductByVariantId(variantId);
                    // if (product) {
                    //     product.variants = product.variants.filter(v => v.id != variantId);
                    //     updateProductTimestamp(product.productName);
                    //     updateView();
                    // }
                }
            } else if (element.matches('.toggle-status-text-btn') && variantId) {
                  $.ajax({
                        url: "{{route('sqa.variation.status.update')}}",
                        
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            variant_id: variantId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                              toastr.success("Status updated successfully");
                            const variant = findVariantById(variantId);
                            if (variant) {
                                variant.isActive = data.newStatus;
                                updateProductTimestampByVariant(variantId);
                                updateView();
                            }
                          
                            setTimeout(()=>{
                                // location.reload()
                                //  reloadGetData();
                            },200)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            let errorMessage = "An unknown error occurred.";
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (errorThrown) {
                                errorMessage = errorThrown;
                            }
                            toastr.error(errorMessage);
                          
                        }
                    });
                    
                
                
                //  const variant = findVariantById(variantId);
                //  alert(variant);
                //  if(variant) {
                //     variant.isActive = !variant.isActive;
                //     updateProductTimestampByVariant(variantId);
                //     updateView();
                //  }
            } else if (element.matches('.add-comment-btn, .view-comments-btn')) {
                openComplianceModal(variantId, element.matches('.add-comment-btn'));
            } else if (element.matches('.view-image-btn')) {
                openImageViewer(element.closest('.image-cell-wrapper').querySelector('img').dataset.src);
            } else if (element.matches('.edit-image-btn')) {
                
                     let myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();
                // alert(variantId);
                const imageInput = document.getElementById('image-upload-input');
                imageInput.value = ""; 
                imageInput.dataset.variantId = variantId;
               // imageInput.click();

            } else if (element.matches('.delete-image-btn')) {
                if (confirm('Are you sure you want to delete this image?')) {
                    const variant = variantId;
                        let url = "{{ route('destroy.raw-material.image', ':id') }}".replace(':id', variant);

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if(response.status === 'success') {
                                   toastr.success(response.message); 
                                   
                                        const variant = findVariantById(variantId);
                                        if (variant) {
                                            variant.imageUrl = null;
                                            updateProductTimestampByVariant(variantId);
                                            updateView();
                                        }
                                    
                    
                                   setTimeout(()=>{
                                        //  location.reload();
                                        //  reloadGetData();
                                    },3000)
                                    
                                } else {
                                   toastr.error(response.message); 
                                }
                            },
                            error: function(xhr) {
                                toastr.error("Something went wrong!"); 
                            }
                        });

                    // const variant = findVariantById(variantId);
                    // alert(variant);
                    // if (variant) {
                    //     variant.imageUrl = null;
                    //     updateProductTimestampByVariant(variantId);
                    //     updateView();
                    // }
                }
            } else if (variantId) {
                const variant = findVariantById(variantId);
                const product = findProductByVariantId(variantId);
                if (!variant || !product) return;
    
                if (element.matches('.view-latest-coa-btn')) {
                    e.preventDefault();
                    openDummyPdf();
                } else if (element.matches('.coa-history-btn')) {
                    openCoaHistoryModal(product, variant);
                } else if (element.matches('.receiving-history-btn')) {
                    openReceivingHistoryModal(product, variant);
                } else if (element.matches('.packet-audit-btn')) {
                     e.preventDefault();
                    openPacketAuditModal(product, variant);
                }
            }
        }
        
        
        document.addEventListener('click', function (e) {
            const uploadBtn = e.target.closest('.image-upload-placeholder');
            
                if (uploadBtn) {
                const variantId = uploadBtn.dataset.variantId;
                
              
                // Save variant ID on input
                $('#image-upload-input').data('variantId', variantId);
                 let myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();
            }
            
               
    
 
            // if (uploadBtn) {
            //     const variantId = uploadBtn.dataset.variantId;
        
            //     // Save variant ID on input
            //     $('#image-upload-input').data('variantId', variantId);
        
            //     // Trigger file input
            //     $('#image-upload-input').click();
            // }
        });


        $('#image-upload-input').on('change', function(e) {
            let files = e.target.files;
            
            
            if (!files || files.length === 0) {
                alert("No file selected");
                return;
            }
        
            let file = files[0];
            let variantId = $(this).data('variantId');
            let formData = new FormData();
            formData.append('image', file);
            formData.append('variant_id', variantId);
            formData.append('_token', "{{ csrf_token() }}");
            // alert("dsasdsadd");
            $.ajax({
                url: "{{ route('variant.image.update') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message); 
                        setTimeout(() => {
                            //  reloadGetData();
                            // location.reload(); // You can change this to dynamic refresh if needed
                        }, 1500);
                    } else {
                        toastr.error(response.message); 
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Laravel validation error
                        const errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            errors[field].forEach(msg => toastr.error(msg));
                        }
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Laravel exception error
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error("Something went wrong!");
                    }
                }
            });
        });

                        
                
        // $('#image-upload-input').on('change', function(e) {
        // let files = e.target.files;
        
        //     if (!files || files.length === 0) {
        //         alert("No file selected");
        //         return;
        //     }
        
        //     let file = files[0];


        //     let variantId = $(this).data('variantId');

        //     if (!file) return;
        
        //     let formData = new FormData();
        //     formData.append('image', file);
        //     formData.append('variant_id', variantId);
        //     formData.append('_token', "{{ csrf_token() }}");
        
        //     $.ajax({
        //         url: "{{ route('variant.image.update') }}",
        //         type: "POST",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             if (response.status === 'success') {
        //                 toastr.success(response.message); 
        //               setTimeout(()=>{
        //                      location.reload();
        //                 },3000)
        //             } else {
        //                  toastr.error(response.message); 
        //             }
        //         },
        //         error: function(xhr) {
        //              toastr.error("Something went wrong!"); 
        //         }
        //     });
        // });
            
        function handleDoubleClickEdit(e) {
            const target = e.target;
            if (target.closest('tr.inactive-row')) return;
    
            if (target.matches('.editable-text')) {
                const productName = target.dataset.productName;
                const variantId = target.dataset.variantId;
                const field = target.dataset.field;
                
                // if (productName) {
                //      enableCellEditing(target, target.textContent, (newName) => {
                //         if (newName && newName !== productName) {
                //             const product = productData.find(p => p.productName === productName);
                //             alert(product.productId);
                //             if (product) {
                //                 product.productName = newName;
                //                 alert(newName);
                //                 updateProductTimestamp(newName);
                //             }
                //         }
                //         updateView();
                //     });
                // } 
                
                if (productName) {
                    enableCellEditing(target, target.textContent, (newName) => {
                        if (newName && newName !== productName) {
                            const product = productData.find(p => p.productName === productName);
                
                            if (product) {
                                const productId = product.productId;
                
                                $.ajax({
                                    url:"{{route('update.product.name.raw.material')}}",
                                    type: 'POST',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'), 
                                        product_id: productId,
                                        new_name: newName
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            toastr.success('Product name updated successfully!');
                                            product.productName = newName;
                                            updateProductTimestamp(newName);
                                            updateView();
                                            //     setTimeout(()=>{
                                            //      reloadGetData();
                                            //   },3000)
                                        } else {
                                            toastr.error(response.message || 'Update failed.');
                                        }
                                    },
                                    error: function(xhr) {
                                        toastr.error('Something went wrong. Please try again.');
                                        console.error(xhr.responseText);
                                    }
                                });
                            }
                        } else {
                            updateView();
                        }
                    });
                }

                
                else if (variantId && field === 'brand') {
                     enableCellEditing(target, target.textContent, (newBrand) => {
                        const variant = findVariantById(variantId);
                        if (variant) {
                            variant.brand = newBrand.trim() || 'Not Added';
                            updateProductTimestampByVariant(variantId);
                        }
                        updateView();
                    });
                }
            } else if (target.closest('.editable-risk')) {
                const wrapper = target.closest('.editable-risk');
                const productName = wrapper.dataset.productName;
                const productId = wrapper.dataset.productId;
                enableRiskEditing(wrapper.querySelector('.risk-badge'), productId, productName, (newRisk) => {
                    const product = productData.find(p => p.productName === productName);
                    if (product) {
                        product.variants.forEach(v => v.riskLevel = newRisk);
                        updateProductTimestamp(productName);
                    }
                    updateView();
                            });
            } else if (target.matches('.editable-multiselect')) {
                const variantId = target.dataset.variantId;
                const field = target.dataset.field;
                if (variantId && field) {
                    openMultiSelectModal(variantId, field);
                }
            }
        }
        

        function showSpecEdit(cell, productName,productId, currentSpecName) {
            const displayMode = cell.querySelector('.spec-display-mode');
            const editMode = cell.querySelector('.spec-edit-mode');
            const searchInput = editMode.querySelector('input[type="search"]');
            const listContainer = editMode.querySelector('.spec-options-list');
            const saveBtn = editMode.querySelector('.save-spec-btn');
            const cancelBtn = editMode.querySelector('.cancel-spec-btn');
    
            let selectedValue = currentSpecName;
    
            const populateList = (filter = '') => {
                listContainer.innerHTML = '';
                DUMMY_SPECIFICATIONS
                    .filter(spec => spec.toLowerCase().includes(filter.toLowerCase()))
                    .forEach(spec => {
                        const option = document.createElement('div');
                        option.className = 'spec-option';
                        option.textContent = spec;
                        option.dataset.value = spec;
                        if (spec === selectedValue) {
                            option.classList.add('selected');
                        }
                        listContainer.appendChild(option);
                    });
            };
    
            populateList();
            searchInput.value = '';
            displayMode.style.display = 'none';
            editMode.style.display = 'flex';
            searchInput.focus();
    
            searchInput.onkeyup = () => populateList(searchInput.value);
            
            listContainer.onclick = (e) => {
                if (e.target.classList.contains('spec-option')) {
                    selectedValue = e.target.dataset.value;
                    populateList(searchInput.value);
                }
            };
    
            const closeEditMode = () => {
                editMode.style.display = 'none';
                displayMode.style.display = 'block';
            };
            
            // saveBtn.onclick = () => {
            //     const product = productData.find(p => p.productName === productName);
            //     alert(selectedValue);
            //       alert(productName);
            //       alert(product);
            //       alert(productId);
            //     if (product && selectedValue) {
            //         product.specificationName = selectedValue;
            //         updateProductTimestamp(productName);
            //         updateView();
            //     } else {
            //         closeEditMode();
            //     }
            // };
            
            saveBtn.onclick = () => {
                const product = productData.find(p => p.productName === productName);
            
                if (product && selectedValue) {
                    product.specificationName = selectedValue;
                    updateProductTimestamp(productName);
                    updateView();
            
            
                    $.ajax({
                        url: "{{ route('sqa.raw-material.save-specification') }}",
                        type: "POST",
                        data: {
                            product_id: productId,
                            specification_name: selectedValue,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                           toastr.success(response.message || 'Specification updated successfully!');
                           setTimeout(()=>{
                            //   location.reload();
                             reloadGetData();
                           },3000)
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                             toastr.error("Error saving specification");
                        }
                    });
            
                } else {
                    closeEditMode();
                }
            };
            
            cancelBtn.onclick = closeEditMode;
        }
    
        function handleReviewModalClicks(e) {
            const target = e.target;
            const row = target.closest('tr[data-product-index]');
            const listItem = target.closest('li');
    
            const toggleEditView = (container, isEditing) => {
                const display = container.querySelector('.product-name-display-container');
                const edit = container.querySelector('.product-name-edit-container');
                display.style.display = isEditing ? 'none' : '';
                edit.style.display = isEditing ? 'flex' : 'none';
                if (isEditing) {
                    edit.querySelector('input').focus();
                }
            };
    
            if (target.closest('.edit-product-review-btn')) {
                const container = target.closest('li, td > div');
                toggleEditView(container, true);
            } else if (target.closest('.cancel-product-review-btn')) {
                const container = target.closest('li, td > div');
                toggleEditView(container, false);
            } else if (target.closest('.save-product-review-btn')) {
                const container = target.closest('li, td > div');
                const input = container.querySelector('input');
                const newValue = input.value.trim();
                const productIndex = parseInt(row.dataset.productIndex, 10);
                const type = row.dataset.type;
    
                if (newValue) {
                    if (type === 'new') {
                        tempCsvData.new[productIndex].productName = newValue;
                    } else if (type === 'matched') {
                         const upIndex = Array.from(listItem.parentNode.children).indexOf(listItem);
                         tempCsvData.matched[productIndex].uploadedNames[upIndex].csvName = newValue;
                    }
                    showCsvReviewModal(); // Re-render to reflect changes
                }
            } else if (row) {
                const { type, productIndex } = row.dataset;
                if (target.closest('.accept.review-btn')) {
                    if (type === 'new') {
                        const [acceptedProduct] = tempCsvData[type].splice(productIndex, 1);
                        addProductToMainData(acceptedProduct, type);
                    } else {
                        tempCsvData[type].splice(productIndex, 1);
                    }
                    showCsvReviewModal();
                } else if (target.closest('.reject.review-btn')) {
                    tempCsvData[type].splice(productIndex, 1);
                    showCsvReviewModal();
                }
            }
    
            const acceptAllBtn = e.target.closest('.accept-all-btn');
            if (acceptAllBtn) {
                const type = acceptAllBtn.dataset.type;
                if (type === 'new') {
                    const productsToProcess = [...tempCsvData[type]];
                    productsToProcess.forEach(product => addProductToMainData(product, type));
                }
                tempCsvData[type] = [];
                showCsvReviewModal();
            }
    
            const rejectAllBtn = e.target.closest('.reject-all-btn');
            if (rejectAllBtn) {
                const type = rejectAllBtn.dataset.type;
                tempCsvData[type] = [];
                showCsvReviewModal();
            }
        }
    
    
        function enableCellEditing(element, initialValue, onSave) {
            const input = document.createElement('input');
            input.type = 'text';
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
    
        // function enableRiskEditing(element, productName, onSave) {
        //     const currentRiskText = element.textContent.trim();
        //     const currentRisk = RISK_LEVELS.includes(currentRiskText) ? currentRiskText : '';
        //     const select = document.createElement('select');
        //             select.className = 'cell-edit-input form-select form-select-sm';
        //     select.innerHTML = `<option value="">Select Risk...</option>` + 
        //         RISK_LEVELS.map(level => `<option value="${level}" ${level === currentRisk ? 'selected' : ''}>${level}</option>`).join('');
        //     element.parentNode.replaceChild(select, element);
        //     select.focus();
        //     const save = () => onSave(select.value);
        //     select.addEventListener('blur', save, { once: true });
        //     select.addEventListener('change', save, { once: true });
        // }
        
        
        
        function enableRiskEditing(element, productId, productName, onSave) {
            const currentRiskText = element.textContent.trim();
            const currentRisk = RISK_LEVELS.includes(currentRiskText) ? currentRiskText : '';
        
            const select = document.createElement('select');
            select.className = 'cell-edit-input form-select form-select-sm';
        
            select.innerHTML = `<option value="">Select Risk...</option>` +
                RISK_LEVELS.map(level => 
                    `<option value="${level}" ${level === currentRisk ? 'selected' : ''}>${level}</option>`
                ).join('');
        
            element.parentNode.replaceChild(select, element);
            select.focus();
        
        
            const save = () => {
                const selectedRisk = select.value;
                if (typeof onSave === 'function') {
                    onSave(selectedRisk);
                }
        
                fetch("{{ route('sqa-raw-material-update-risk') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_name: productName,
                        risk: selectedRisk,
                        productId:productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || "Risk updated successfully!");
                        
                        setTimeout(()=>{
                            // location.reload()
                             reloadGetData();
                        },2000)
                    } else {
                        toastr.warning(data.message || "Failed to update risk.");
                    }
                })
                .catch(error => {
                    console.error("Error updating risk:", error);
                    toastr.error("Something went wrong. Please try again.");
                });
            };
        
            // 🔹 Trigger on blur or change
            select.addEventListener('blur', save, { once: true });
            select.addEventListener('change', save, { once: true });
        }

        
        
        
        
        function findVariantById(variantId) { return productData.flatMap(p => p.variants).find(v => v.id == variantId); }
        function findProductByVariantId(variantId) { return productData.find(p => p.variants.some(v => v.id == variantId)); }
        
        // function openAddVendorModal(productName) {
        //     const modalEl = document.getElementById('add-vendor-modal');
        //     modalEl.dataset.productName = productName;
        //     document.getElementById('add-vendor-title').textContent = `Add Vendor(s) to ${productName}`;
        //     const product = productData.find(p => p.productName === productName);
        //     const availableVendors = DUMMY_VENDORS.filter(v => !(product.approvedVendors || []).includes(v));
        //     const listEl = document.getElementById('vendor-checkbox-list');
        //     listEl.innerHTML = availableVendors.length ? availableVendors.map(v => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${v}" id="v-${v}"><label class="form-check-label" for="v-${v}">${v}</label></div>`).join('') : '<p>All dummy vendors are already approved.</p>';
        //     addVendorModal.show();
        // }
        
        //new start 
        
        let currentAvailableVendors = [];
        function openAddVendorModal(productName,productId) {
            const modalEl = document.getElementById('add-vendor-modal');
            modalEl.dataset.productName = productName;
            modalEl.dataset.productId = productId;
            document.getElementById('add-vendor-title').textContent = `Add Vendor(s) to ${productName}`;
            const product = productData.find(p => p.productName === productName);
            // currentAvailableVendors = DUMMY_VENDORS.filter(v => !(product.approvedVendors || []).includes(v));
        
            // renderVendorCheckboxList(currentAvailableVendors);
            
            renderVendorCheckboxList(DUMMY_VENDORS);
            document.getElementById('vendor-search-input').value = '';
            addVendorModal.show();
        }

        function renderVendorCheckboxList(vendors) {
            const listEl = document.getElementById('vendor-checkbox-list');
            if (!vendors.length) {
                listEl.innerHTML = '<p class="text-muted">No vendors found.</p>';
                return;
            }
            const html = vendors.map(v => {
                const id = `v-${v.name.replace(/[^a-zA-Z0-9]/g, '-')}`; 
                return `<div class="form-check">
                    <input class="form-check-input" type="checkbox" value="${v.id}" id="${id}">
                    <label class="form-check-label" for="${id}">${v.name} (${v.unit_name})</label>
                </div>`;
            }).join('');
            listEl.innerHTML = html;
        }
        
        document.getElementById('vendor-search-input').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            

            // const filtered = DUMMY_VENDORS.filter(v => v.toLowerCase().includes(filter));
            const filtered = DUMMY_VENDORS.filter(v => v.name.toLowerCase().includes(filter));
            // const filtered = currentAvailableVendors.filter(v => v.toLowerCase().includes(filter));
            renderVendorCheckboxList(filtered);
        });
        
        
        //new end


    
        // document.getElementById('save-vendor-add-btn').addEventListener('click', () => {
        //     const modalEl = document.getElementById('add-vendor-modal');
        //     const productName = modalEl.dataset.productName;
        //       const productId = modalEl.dataset.productId;
        //       alert(productId);
        //     const product = productData.find(p => p.productName === productName);
        //     if(!product.approvedVendors) product.approvedVendors = [];
        //     document.querySelectorAll('#vendor-checkbox-list input:checked').forEach(cb => {
        //         if (!product.approvedVendors.includes(cb.value)) product.approvedVendors.push(cb.value);
        //     });
        //     updateProductTimestamp(productName);
        //     updateView();
        //     addVendorModal.hide();
        // });
        
        document.getElementById('save-vendor-add-btn').addEventListener('click', () => {
            const modalEl = document.getElementById('add-vendor-modal');
            const productName = modalEl.dataset.productName;
            const productId = modalEl.dataset.productId;
            const product = productData.find(p => p.productName === productName);
            if (!product.approvedVendors) product.approvedVendors = [];
        
            const selectedVendors = [];
            
            // document.querySelectorAll('#vendor-checkbox-list input:checked').forEach(cb => {
            // modalEl.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
            //     if (!product.approvedVendors.includes(cb.value)) {
            //         product.approvedVendors.push(cb.value);
            //         selectedVendors.push(cb.value);
            //     }
            // });
            
            modalEl.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                let val = cb.value && cb.value.trim() !== "" ? cb.value : (cb.id || cb.name || cb.getAttribute('data-id'));
                 if (val) {
                    selectedVendors.push(val);
                }
                
            });

            if (selectedVendors.length > 0) {
                fetch("{{ route('sqa-raw-material-save-vendor') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        productId: productId,
                        vendors: selectedVendors
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message || 'Vendors saved successfully!');
                        setTimeout(()=>{
                            // location.reload();
                             reloadGetData();
                        },3000);
                    } else {
                        toastr.warning(data.message || 'Something went wrong while saving vendors.');
                    }
                })
                .catch(error => {
                    console.error('Error saving vendors:', error);
                    toastr.error('Failed to save vendors. Please try again.');
                });
            }

        
            updateProductTimestamp(productName);
            updateView();
            addVendorModal.hide();
        });

    
        function openMultiSelectModal(variantId, fieldType) {
            const variant = findVariantById(variantId);
            const titleEl = document.getElementById('multiselect-title');
            const listEl = document.getElementById('multiselect-list');
            const searchEl = document.getElementById('multiselect-search');
            searchEl.value = '';
    
            let options = [], selectedValues = variant[fieldType] || [];
            if (fieldType === 'storageTemp') {
                titleEl.textContent = 'Edit Storage Conditions';
                options = STORAGE_OPTIONS;
            } else if (fieldType === 'allergens') {
                titleEl.textContent = 'Edit Allergens';
                options = ALLERGEN_OPTIONS;
            }else if (fieldType === 'instructionHandles') {
                titleEl.textContent = 'Edit Instructions';
                options = HANDLING_INSTRUCTIONS;
            }
            
            
    
    
    
            const updateList = (filter = '') => {
                listEl.innerHTML = '';
                options.filter(opt => opt.toLowerCase().includes(filter.toLowerCase())).forEach(opt => {
                    const isChecked = selectedValues.includes(opt);
                    
                    listEl.innerHTML += `<div class="form-check"><input class="form-check-input" type="checkbox" value="${opt}" id="ms-${opt}" ${isChecked ? 'checked' : ''}><label class="form-check-label" for="ms-${opt}">${opt}</label></div>`;
                });
            };
           

            searchEl.oninput = () => updateList(searchEl.value);
    
            // document.getElementById('save-multiselect-btn').onclick = () => {
            //     const newValues = [];
            //     document.querySelectorAll('#multiselect-list input:checked').forEach(cb => newValues.push(cb.value));
            //     variant[fieldType] = newValues;
            //     alert(variantId);
            //     alert(newValues);
            //     updateProductTimestampByVariant(variantId);
            //     updateView();
            //     editMultiSelectModal.hide();
            // };
            
            document.getElementById('save-multiselect-btn').onclick = () => {
                const newValues = [];
                document.querySelectorAll('#multiselect-list input:checked').forEach(cb => newValues.push(cb.value));
            
                // Store in variant object (local update)
                variant[fieldType] = newValues;
                            
                $.ajax({
                    url: "{{route('save-multiselect-storage-raw-material')}}", 
                    method: 'POST',
                    data: {
                        variant_id: variantId,
                        field_type: fieldType,
                        values: newValues,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log("Saved:", response);
            
                        // Local update
                        updateProductTimestampByVariant(variantId);
                        updateView();
            
                        // Hide modal
                        editMultiSelectModal.hide();
                        setTimeout(()=>{
                                    // const editMultiSelectModal = new bootstrap.Modal(document.getElementById('edit-multiselect-modal'));
                                $('.modal-backdrop').remove(); // Remove the overlay
                                    $('body').removeClass('modal-open'); // Enable scroll
                                    $('body').css({
                                        'overflow': '', // Remove overflow hidden
                                        'padding-right': '' // Remove added padding (if any)
                                    });
        
                            //  location.reload();
                        //   reloadGetData();
                        },2000);
                        toastr.success("Values saved successfully!");
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        toastr.error("Failed to save values!");
                    }
                });
            };
            

    
            updateList();
            editMultiSelectModal.show();
        }
    
        function openImageViewer(src) {
            document.getElementById('fullscreen-image').src = src;
            imageViewerModal.show();
        }
    
        function openRenewCoaModal(variantId, brandName) {
            const modalEl = document.getElementById('renew-coa-modal');
            modalEl.dataset.variantId = variantId;
            // alert(variantId);
            document.getElementById('renewCoaModalLabel').textContent = `Renew COA for ${brandName}`;
            document.getElementById('renew-coa-form').reset();
            renewCoaModal.show();
        }
    
        document.getElementById('renew-coa-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const modalEl = document.getElementById('renew-coa-modal');
            const variantId = modalEl.dataset.variantId;
            const variant = findVariantById(variantId);
            const newExpiryDate = document.getElementById('new-expiry-date').value;
            const receivingDate = document.getElementById('material-receiving-date').value;
            const coaPdfFile = document.getElementById('new-coa-pdf').files[0];
    
            if (variant && newExpiryDate && receivingDate && coaPdfFile) {
                variant.coaExpiry = newExpiryDate;
                if(!variant.receivingReport) variant.receivingReport = {};
                variant.receivingReport.lastReceivingDate = receivingDate;
                // logic to handle form e and coa pdf upload would go here
                updateProductTimestampByVariant(variantId);
                updateView();
                renewCoaModal.hide();
            } else {
                alert('Please fill out all required fields, including the COA PDF.');
            }
        });
    
  function openSelectVendorModal() {
    const listEl = document.getElementById('vendor-selection-list');
    const searchInput = document.getElementById('vendor-selection-search');
    searchInput.value = '';

    // Convert vendor to display text safely
    const getVendorText = (v) => {
        if (typeof v === "string") return v;
        if (typeof v === "number") return String(v);
        if (v && typeof v === "object" && v.name) return v.name;
        return ""; // skip invalid entries
    };

    const populateList = (filter = '') => {
        let vendorsHTML = `
            <div class="filter-item">
                <input class="form-check-input" type="radio" name="vendor-select" value="" id="no-vendor" checked>
                <label class="form-check-label w-100" for="no-vendor"><strong>Upload without selection</strong></label>
            </div>
        `;

        const filteredVendors = DUMMY_VENDORS
            .map(v => getVendorText(v))       // convert safely
            .filter(v => v.length > 0)        // remove invalid entries
            .filter(v => v.toLowerCase().includes(filter.toLowerCase()));

        filteredVendors.forEach(vendor => {
            const id = `vendor-${vendor.replace(/[^a-zA-Z0-9]/g, '-')}`;

            vendorsHTML += `
                <div class="filter-item">
                    <input class="form-check-input" type="radio" name="vendor-select" value="${vendor}" id="${id}">
                    <label class="form-check-label w-100" for="${id}">${vendor}</label>
                </div>
            `;
        });

        listEl.innerHTML = vendorsHTML;
    };

    populateList();
    searchInput.addEventListener('input', () => populateList(searchInput.value));
    selectVendorModal.show();
}

    
    
    
    //    function openSelectVendorModal() {
    //         alert("adsasd")
    //         const listEl = document.getElementById('vendor-selection-list');
    //         const searchInput = document.getElementById('vendor-selection-search');
    //         searchInput.value = '';
    
    //         const populateList = (filter = '') => {
    //             let vendorsHTML = `<div class="filter-item"><input class="form-check-input" type="radio" name="vendor-select" value="" id="no-vendor" checked><label class="form-check-label w-100" for="no-vendor"><strong>Upload without selection</strong></label></div>`;
    //             const filteredVendors = DUMMY_VENDORS.filter(v => v.toLowerCase().includes(filter.toLowerCase()));
                
    //             filteredVendors.forEach(vendor => {
    //                 const id = `vendor-${vendor.replace(/[^a-zA-Z0-9]/g, '-')}`;
    //                 vendorsHTML += `<div class="filter-item"><input class="form-check-input" type="radio" name="vendor-select" value="${vendor}" id="${id}"><label class="form-check-label w-100" for="${id}">${vendor}</label></div>`;
    //             });
    //             listEl.innerHTML = vendorsHTML;
    //         };
    
    //         populateList();
    //         searchInput.addEventListener('input', () => populateList(searchInput.value));
    //         selectVendorModal.show();
    //     }
    
    
    
        document.getElementById('proceed-with-vendor-btn').addEventListener('click', () => {
            const selectedRadio = document.querySelector('#vendor-selection-list input[name="vendor-select"]:checked');
            selectedVendorForUpload = selectedRadio ? selectedRadio.value : null;
                if (selectedVendorForUpload) {
                    localStorage.setItem('selectedVendor', selectedVendorForUpload);
                } else {
                    localStorage.removeItem('selectedVendor');  
                }
            // alert(selectedVendorForUpload);
            selectVendorModal.hide();
            csvUploadInput.click();
        });
        
        // function populateCustomMultiselect(container, class, options, selectedValues = []) {
        //     const optionsContainer = container.querySelector('.dropdown-options');
        //     const placeholder = container.querySelector('.select-button span').textContent;
        //     optionsContainer.innerHTML = '';
        //     options.forEach(opt => {
        //         const isChecked = selectedValues.includes(opt);
        //         const optionHTML = `<label class="w-100"><input type="checkbox" class="form-check-input me-2 `${class}`" value="${opt}" ${isChecked ? 'checked' : ''}>${opt}</label>`;
        //         optionsContainer.insertAdjacentHTML('beforeend', optionHTML);
        //     });
        //     updateMultiselectButtonText(container, placeholder);
        // }
        
        function populateCustomMultiselect(container, customClass, options, selectedValues = []) {
      
            const optionsContainer = container.querySelector('.dropdown-options');
            const placeholder = container.querySelector('.select-button span').textContent;
        
            optionsContainer.innerHTML = '';
        
            options.forEach(opt => {
                const isChecked = selectedValues.includes(opt);
                const optionHTML = `
                    <label class="w-100">
                        <input type="checkbox" 
                               class="form-check-input me-2 ${customClass}" 
                               value="${opt}" 
                               ${isChecked ? 'checked' : ''}>
                        ${opt}
                    </label>`;
                optionsContainer.insertAdjacentHTML('beforeend', optionHTML);
            });
        
            updateMultiselectButtonText(container, placeholder);
        }

        
        function populateCustomMultiselect1(container, customClass, options, selectedValues = []) {
            const optionsContainer = container.querySelector('.dropdown-options');
            const placeholder = container.querySelector('.select-button span').textContent;
        
            optionsContainer.innerHTML = '';
        
        
            options.forEach(opt => {
                const isChecked = selectedValues.includes(opt);
                const optionHTML = `
                    <label class="w-100">
                        <input type="checkbox" 
                               class="form-check-input me-2 ${customClass}" 
                               value="${opt.id}" 
                               ${isChecked ? 'checked' : ''}>
                        ${opt.name} (${opt.unit_name})
                    </label>`;
                optionsContainer.insertAdjacentHTML('beforeend', optionHTML);
            });
        
            updateMultiselectButtonText(container, placeholder);
        }

    
        function updateMultiselectButtonText(container, placeholder) {
            const buttonText = container.querySelector('.select-button span');
            const checkedCount = container.querySelectorAll('.dropdown-options input:checked').length;
            buttonText.textContent = (checkedCount === 0) ? placeholder : `${checkedCount} selected`;
        }
    
        function getValuesFromCustomMultiselect(containerId) {
            const container = document.getElementById(containerId);
            const checked = container.querySelectorAll('.dropdown-options input:checked');
            return Array.from(checked).map(cb => cb.value);
        }
        
        document.getElementById('add-ingredient-modal').addEventListener('show.bs.modal', () => {
            document.getElementById('new-product-name').value = '';
            document.getElementById('new-risk-level').value = '';
            const imagePlaceholder = document.getElementById('new-ingredient-image-upload');
            imagePlaceholder.innerHTML = ICONS.camera;
            imagePlaceholder.dataset.imageDataUrl = '';
 
            // populateCustomMultiselect(document.getElementById('new-approved-vendors'), DUMMY_VENDORS);
            // populateCustomMultiselect(document.getElementById('new-allergens'), ALLERGEN_OPTIONS);
            // populateCustomMultiselect(document.getElementById('new-storage-conditions'), STORAGE_OPTIONS);
            
             populateCustomMultiselect1(document.getElementById('new-approved-vendors'), 'vendors', DUMMY_VENDORS);
            populateCustomMultiselect(document.getElementById('new-allergens'), 'allergens', ALLERGEN_OPTIONS);
            populateCustomMultiselect(document.getElementById('new-storage-conditions'), 'storage', STORAGE_OPTIONS);
                populateCustomMultiselect(document.getElementById('new-instruction'), 'instructions', HANDLING_INSTRUCTIONS);
            
            const brandSelect = document.getElementById('new-brand-select');
            brandSelect.dataset.selectedValue = '';
            brandSelect.querySelector('.select-button span').textContent = 'Select or create a brand...';
            populateBrandSelector(brandSelect, '');
        });
    
        function populateBrandSelector(container, searchTerm, brandPool) {
            console.log("check 123401",brandsData);
            const optionsContainer = container.querySelector('.dropdown-options');
                // const allBrands = brandPool || [...new Set(productData.flatMap(p => p.variants.map(v => v.brand)).filter(Boolean))].sort();
            
                //         const filteredBrands = allBrands.filter(b => b.toLowerCase().includes(searchTerm.toLowerCase()));
                        
                //         optionsContainer.innerHTML = '';
                        
                //         filteredBrands.forEach(brand => {
                //             optionsContainer.innerHTML += `<label class="w-100"><input type="radio" name="new-brand-radio" class="form-check-input me-2" value="${brand}"> ${brand}</label>`;
                //         });
                
                
            const allBrands = brandsData 
                ? Object.entries(brandsData).map(([id, name]) => ({ id, name }))
                : [...new Set(
                    productData.flatMap(p => p.variants.map(v => v.brand)).filter(Boolean)
                  )].map(name => ({ id: null, name })).sort((a, b) => a.name.localeCompare(b.name));
            
            //   const allBrands = brandsData 
            // ? Object.entries(brandsData).map(([id, name, unit_name]) => ({ id, name, unit_name }))
            // : [...new Set(
            //     productData.flatMap(p => p.variants.map(v => v.brand)).filter(Boolean)
            //   )].map(name => ({ id: null, name })).sort((a, b) => a.name.localeCompare(b.name));
            
            
            console.log("checking... allBrands",allBrands);
            // Filter by name
            const filteredBrands = allBrands.filter(b => 
                b.name.name.toLowerCase().includes(searchTerm.toLowerCase())
            );
            
            optionsContainer.innerHTML = '';
              //   value="${brand.id || brand.name}"
            filteredBrands.forEach(brand => {
                optionsContainer.innerHTML += `
                    <label class="w-100">
                        <input type="radio" 
                              name="new-brand-radio" 
                              class="form-check-input me-2" 
                                value="${brand.name.name}"
                              > 
                        ${brand.name.name} (${brand.name.unit_name})
                    </label>`;
            });

    
            if (searchTerm && !allBrands.some(b => b.toLowerCase() === searchTerm.toLowerCase())) {
                optionsContainer.innerHTML += `<label class="create-new-option w-100"><input type="radio" name="new-brand-radio" class="form-check-input me-2" value="${searchTerm}">Create new brand: "<strong>${searchTerm}</strong>"</label>`;
            }
            
            if (optionsContainer.innerHTML === '') {
                optionsContainer.innerHTML = `<div class="p-2 text-center text-muted">No matching brands found.</div>`;
            }
        }
    


        document.getElementById('save-ingredient-btn').addEventListener('click', () => {
             let btn = this;
            const productName = document.getElementById('new-product-name').value.trim();
            const brandName = document.getElementById('new-brand-select').dataset.selectedValue;
                        const imageUrl = document.getElementById('new-ingredient-image-upload').dataset.imageDataUrl || null;

            const approvedVendors = Array.from(
                document.querySelectorAll('#new-approved-vendors .dropdown-options input[type="checkbox"]:checked')
            ).map(cb => cb.value);

          const storageConditions = Array.from(
                document.querySelectorAll('#new-storage-conditions .dropdown-options input[type="checkbox"]:checked')
            ).map(cb => cb.value);
            
            const allergens = Array.from(
                document.querySelectorAll('#new-allergens .dropdown-options input[type="checkbox"]:checked')
            ).map(cb => cb.value);
            
            const instructions = Array.from(
                document.querySelectorAll('#new-instruction .dropdown-options input[type="checkbox"]:checked')
            ).map(cb => cb.value);


            // alert(instructions);

           const riskLevel = document.getElementById("new-risk-level").value;


            btn.disabled = true;
            btn.innerText = "Saving...";
        
            // if (!productName || !brandName) {
            //     alert('Product Name and Brand Name are required.');
            //     return;
            // }
            
            //save form
             fetch("{{ route('raw-material-product.storeManual') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    
                },
                body: JSON.stringify({
                    name: productName,
                    approvedVendors: approvedVendors,
                    imageUrl : imageUrl,
                    brandName:brandName,
                    storageConditions:storageConditions,
                    riskLevel:riskLevel,
                    allergens:allergens,
                    instructions:instructions
                    
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    let modalEl = document.getElementById("add-ingredient-modal");
                    let modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();
        
                    toastr.success(data.message);
        
                    localStorage.setItem("activeTab", "raw");
                        
                    updateView();
                    setTimeout(() => {
                            location.reload();
                            //  reloadGetData();
                    }, 3000);
            
                } else {
                    toastr.error("Error while saving!");
                    btn.disabled = false;
                    btn.innerText = "Save Ingredient";
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Something went wrong!");
                btn.disabled = false;
                btn.innerText = "Save Ingredient";
            });
            
                
    
            // const newVariant = {
            //     id: nextDataId++,
            //     brand: brandName,
            //     riskLevel: document.getElementById('new-risk-level').value || null,
            //     isActive: true,
            //     imageUrl: imageUrl,
            //     allergens: getValuesFromCustomMultiselect('new-allergens'),
            //     storageTemp: getValuesFromCustomMultiselect('new-storage-conditions'),
            //     coaExpiry: null, lastReview: null, complianceStatus: 'Pending', nextReviewDate: null, receivingReport: { status: 'pending' }, complianceTickets: []
            // };
    
            // const newProduct = {
            //     productName: productName,
            //     lastUpdated: new Date().toISOString(),
            //     uploadedBy: "Current User",
            //     isProductActive: true,
            //     approvedVendors: getValuesFromCustomMultiselect('new-approved-vendors'),
            //     variants: [newVariant]
            // };
            
            // productData.unshift(newProduct);
            // updateView();
            // addIngredientModal.hide();
        });
        
        document.addEventListener("DOMContentLoaded", function () {
            let activeTab = localStorage.getItem("activeTab");
        
            if (activeTab) {
                // saare tabs inactive karo
                document.querySelectorAll(".tab-content").forEach(tab => tab.classList.add("hidden"));
                document.querySelectorAll(".tab-btn").forEach(btn => {
                    btn.classList.remove("bg-blue-200", "text-blue-800");
                    btn.classList.add("hover:bg-blue-50");
                });
        
                // Raw Material tab ko active karo
                document.getElementById(activeTab).classList.remove("hidden");
                const btn = document.querySelector(`[data-tab='${activeTab}']`);
                btn.classList.add("bg-blue-200", "text-blue-800");
                btn.classList.remove("hover:bg-blue-50");
        
                localStorage.removeItem("activeTab");
            }
        });
    
    
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
    
                const searchTerm = searchInput.value.trim();
                if (multiselect.id === 'new-brand-select' || multiselect.id.startsWith('add-variant-brand-select')) {
                    populateBrandSelector(multiselect, searchTerm);
                } else {
                     multiselect.querySelector('.dropdown-options').querySelectorAll('label').forEach(label => {
                        const labelText = label.textContent.trim().toLowerCase();
                        label.style.display = labelText.includes(searchTerm.toLowerCase()) ? 'flex' : 'none';
                    });
                }
            }
        });
        
        document.body.addEventListener('change', function(e) {
            if (e.target.matches('.dropdown-options input[type="checkbox"]')) {
                const multiselect = e.target.closest('.custom-multiselect');
                
                const placeholder = multiselect.id === 'new-approved-vendors' ? 'Select Vendors...' :
                                     multiselect.id === 'new-instruction' ? 'Select Instructions...' :
                                    multiselect.id === 'new-allergens' ? 'Select Allergens...' : 'Select Conditions...';
                updateMultiselectButtonText(multiselect, placeholder);
    
                if (multiselect.id === 'new-storage-conditions') {
                    const selectedValues = getValuesFromCustomMultiselect('new-storage-conditions');
                    if (selectedValues.includes('Refrigerate (2-8Â¡Ã†C)') || selectedValues.includes('Frozen (-18Â¡Ã†C)')) {
                        document.getElementById('new-risk-level').value = 'high';
                    }
                }
            }
        });
        
        document.body.addEventListener('click', e => {
            const multiselect = e.target.closest('.custom-multiselect');
            if (!multiselect) return;
    
            const applyBtn = e.target.closest('.apply-btn');
            const clearBtn = e.target.closest('.clear-btn');
            const radio = e.target.closest('.dropdown-options input[type="radio"]');
    
            if (applyBtn) {
                if (multiselect.id.includes('-brand-select')) {
                    const selectedRadio = multiselect.querySelector('input[type="radio"]:checked');
                    if (selectedRadio) {
                        const selectedValue = selectedRadio.value;
                        multiselect.dataset.selectedValue = selectedValue;
                        multiselect.querySelector('.select-button span').textContent = selectedValue;
                    }
                }
                multiselect.classList.remove('open');
            } else if (clearBtn) {
                 if (multiselect.id.includes('-brand-select')) {
                     multiselect.dataset.selectedValue = '';
                     multiselect.querySelector('.select-button span').textContent = 'Select or create a brand...';
                     const selectedRadio = multiselect.querySelector('input[type="radio"]:checked');
                     if (selectedRadio) selectedRadio.checked = false;
                 } else {
                     
                    const placeholder = multiselect.id === 'new-approved-vendors' ? 'Select Vendors...'
                                        : multiselect.id === 'new-instruction' ? 'Select Instructions...'
                                        : multiselect.id === 'new-allergens' ? 'Select Allergens...'
                                        : 'Select Conditions...';
                    multiselect.querySelectorAll('.dropdown-options input:checked').forEach(cb => cb.checked = false);
                    updateMultiselectButtonText(multiselect, placeholder);
                 }
            } else if(radio) {
                const selectedValue = radio.value;
                multiselect.dataset.selectedValue = selectedValue;
                multiselect.querySelector('.select-button span').textContent = selectedValue;
                multiselect.classList.remove('open');
            }
        });
        
        document.getElementById('new-product-name').addEventListener('blur', function() {
            const newName = this.value.trim();
            if (!newName) return;
    
            let bestMatch = null;
            let bestSimilarity = 0;
    
            productData.forEach(p => {
                const dist = levenshteinDistance(newName, p.productName);
                const similarity = (1 - (dist / Math.max(newName.length, p.productName.length))) * 100;
                if (similarity > bestSimilarity) {
                    bestSimilarity = similarity;
                    bestMatch = p.productName;
                }
            });
    
            if (bestMatch && bestSimilarity >= 60) {
                if (!confirm(`A similar product "${bestMatch}" already exists. Are you sure you want to create a new one?`)) {
                    this.focus();
                }
            }
        });
    
        document.getElementById('image-upload-input').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const dataUrl = event.target.result;
                    const variantId = e.target.dataset.variantId;
                    
                    if (variantId === 'new-ingredient') {
                        const placeholder = document.getElementById('new-ingredient-image-upload');
                        placeholder.innerHTML = `<img src="${dataUrl}" alt="Preview">`;
                        placeholder.dataset.imageDataUrl = dataUrl;
                    } else {
                        const variant = findVariantById(variantId);
                        if (variant) {
                            variant.imageUrl = dataUrl;
                            updateProductTimestampByVariant(variantId);
                            updateView();
                        }
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
            this.value = ''; // Reset input
        });
        
        document.getElementById('add-ingredient-modal').addEventListener('click', e => {
            if(e.target.closest('#new-ingredient-image-upload')) {
                const imageInput = document.getElementById('image-upload-input');
                imageInput.dataset.variantId = 'new-ingredient';
                imageInput.click();
            }
        });
    
        // function openCoaHistoryModal(product, variant) { 
        //     alert(variant.id)
        //     coaHistoryModal.show(); 
        // }
        function openCoaHistoryModal(product, variant) {
            const baseUrl = "{{ route('coa.raw.material.popup') }}"; 
            const iframeUrl = `${baseUrl}?variant_id=${variant.id}`;
            document.getElementById('coa-history-iframe').src = iframeUrl;
            const modal = new bootstrap.Modal(document.getElementById('coa-history-modal'));
            modal.show();
        }

        function openPacketAuditModal(product, variant) { packetAuditModal.show(); }
        function openReceivingHistoryModal(product, variant) {
            receivingHistoryModal.show(); 
        }
        
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
            } else if (cfg.type === 'date-range') {
                const from = activeFilters[cfg.key]?.from || '';
                const to = activeFilters[cfg.key]?.to || '';
                sectionHTML += `<div class="filter-date-range">
                    <input type="date" class="form-control form-control-sm" data-section="${cfg.key}-from" value="${from}">
                    <span>to</span>
                    <input type="date" class="form-control form-control-sm" data-section="${cfg.key}-to" value="${to}">
                </div>`;
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
                    <button class="btn apply-filter-btn">Apply</button>
                    <button class="btn clear-filter-btn">Clear</button>
                </div>`;
            
            switch(column) {
                case 'productName':
                    contentHTML += buildFilterSection({ title: 'BY PRODUCT NAME', key: 'productName', values: [...new Set(productData.map(p => p.productName))].sort(), type: 'checklist' });
                    contentHTML += buildFilterSection({ title: 'BY RISK CATEGORY', key: 'riskCategory', values: [...new Set(productData.map(getHighestRiskForProduct))].sort(), type: 'checklist' });
                    contentHTML += buildFilterSection({ title: 'BY SPECIFICATION', key: 'specification', values: [...new Set(productData.map(p => p.specificationName || 'Not Added'))].sort(), type: 'checklist' });
                    break;
                case 'labelingSpecs':
                    contentHTML += buildFilterSection({ title: 'BY ALLERGEN', key: 'allergens', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => v.allergens || [])))].sort(), type: 'checklist' });
                    contentHTML += buildFilterSection({ title: 'BY STORAGE', key: 'storageTemp', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => v.storageTemp || [])))].sort(), type: 'checklist' });
                     contentHTML += buildFilterSection({ title: 'BY INSTRUCTIONS', key: 'instructionHandles', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => v.instructionHandles || [])))].sort(), type: 'checklist' });
                    break;
                case 'coaDetails':
                    contentHTML += buildFilterSection({ title: 'BY STATUS', key: 'coaStatus', values: ['Valid', 'Due Soon', 'Expired', 'Not Attached'], type: 'checklist' });
                    contentHTML += buildFilterSection({ title: 'BY EXPIRY DATE', key: 'coaExpiry', type: 'date-range' });
                    break;
                case 'yieldStockableDetails':   
                     contentHTML += buildFilterSection({ title: 'Stockable', key: 'stockableData', values: ['yes', 'no'], type: 'checklist' });
                     contentHTML += buildFilterSection({ title: 'Yield', key: 'yieldData', values: ['yes', 'no'], type: 'checklist' });
                    break;
                case 'labelCompliance':
                    contentHTML += buildFilterSection({ title: 'BY STATUS', key: 'complianceStatus', values: ['Compliant', 'Non-compliant', 'Pending'].sort(), type: 'checklist' });
                    contentHTML += buildFilterSection({ title: 'BY REVIEW STATUS', key: 'reviewStatus', values: ['Completed', 'Coming Soon', 'Pending'], type: 'checklist' });
                    contentHTML += buildFilterSection({ title: 'BY REVIEW DATE', key: 'lastReview', type: 'date-range' });
                    break;
                default: 
                     const title = `BY ${column.replace(/([A-Z])/g, ' $1').toUpperCase()}`;
                     contentHTML += buildFilterSection({ title: title, key: column, values: [...new Set(productData.flatMap(p => column === 'brand' ? p.variants.map(v => v.brand) : p.approvedVendors || []))].filter(Boolean).sort(), type: 'checklist' });
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
                const sections = new Set([...dropdown.querySelectorAll('[data-section]')].map(el => el.dataset.section.replace(/-(from|to)$/, '')));
                
                sections.forEach(sectionKey => {
                     const checkboxes = dropdown.querySelectorAll(`input[type="checkbox"][data-section="${sectionKey}"]:checked`);
                     if(checkboxes.length > 0) {
                        newFilters[sectionKey] = [...checkboxes].map(cb => cb.value);
                     }
                     const dateFrom = dropdown.querySelector(`input[type="date"][data-section="${sectionKey}-from"]`);
                     if(dateFrom && (dateFrom.value)) {
                        if(!newFilters[sectionKey]) newFilters[sectionKey] = {};
                        newFilters[sectionKey].from = dateFrom.value;
                     }
                     const dateTo = dropdown.querySelector(`input[type="date"][data-section="${sectionKey}-to"]`);
                     if(dateTo && (dateTo.value)) {
                        if(!newFilters[sectionKey]) newFilters[sectionKey] = {};
                        newFilters[sectionKey].to = dateTo.value;
                     }
                });
    
                activeFilters = {...activeFilters, ...newFilters};
    
                for(const key in activeFilters) {
                     if(typeof activeFilters[key] === 'object' && !Array.isArray(activeFilters[key]) && activeFilters[key] !== null && Object.keys(activeFilters[key]).length === 0) {
                         delete activeFilters[key];
                    }
                }
                
                currentPage = 1;
                updateView();
                closeAllFilterDropdowns();
            });
    
            dropdown.querySelector('.clear-filter-btn').addEventListener('click', () => {
                 const keysToClear = new Set([...dropdown.querySelectorAll('[data-section]')].map(el => el.dataset.section.replace(/-(from|to)$/, '')));
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
                    productName: ['productName', 'riskCategory', 'specification'],
                    labelingSpecs: ['allergens', 'storageTemp','instructionHandles'],
                    coaDetails: ['coaStatus', 'coaExpiry'],
                    yieldStockableDetails: ['stockableData', 'yieldData'],
                    labelCompliance: ['complianceStatus', 'reviewStatus', 'lastReview'],
                    approvedVendors: ['approvedVendors'],
                    brand: ['brand']
                }[col] || [];
                
                isActive = relevantKeys.some(key => activeFilters[key] && (Array.isArray(activeFilters[key]) ? activeFilters[key].length > 0 : Object.keys(activeFilters[key]).length > 0));
                
                icon.classList.toggle('active', isActive);
            });
        }
    
        // START: Mobile Filter Modal Population
        function populateMobileFilterModal() {
            const body = document.getElementById('mobile-filter-modal-body');
            const filterConfigs = [
                {
                    title: 'Product Details',
                    content: [
                        buildFilterSection({ title: 'BY PRODUCT NAME', key: 'productName', values: [...new Set(productData.map(p => p.productName))].sort(), type: 'checklist' }),
                        buildFilterSection({ title: 'BY RISK CATEGORY', key: 'riskCategory', values: [...new Set(productData.map(getHighestRiskForProduct))].sort(), type: 'checklist' }),
                        buildFilterSection({ title: 'BY SPECIFICATION', key: 'specification', values: [...new Set(productData.map(p => p.specificationName || 'Not Added'))].sort(), type: 'checklist' })
                    ].join('')
                },
                {
                    title: 'Vendor & Brand',
                    content: [
                        buildFilterSection({ title: 'BY APPROVED VENDOR', key: 'approvedVendors', values: [...new Set(productData.flatMap(p => p.approvedVendors || []))].filter(Boolean).sort(), type: 'checklist' }),
                        buildFilterSection({ title: 'BY BRAND', key: 'brand', values: [...new Set(productData.flatMap(p => p.variants.map(v => v.brand)))].filter(Boolean).sort(), type: 'checklist' })
                    ].join('')
                },
                {
                    title: 'Labeling & Storage',
                    content: [
                        buildFilterSection({ title: 'BY ALLERGEN', key: 'allergens', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => v.allergens || [])))].sort(), type: 'checklist' }),
                        buildFilterSection({ title: 'BY STORAGE', key: 'storageTemp', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => v.storageTemp || [])))].sort(), type: 'checklist' }),
                        buildFilterSection({ title: 'BY INSTRUCTIONS', key: 'instructionHandles', values: [...new Set(productData.flatMap(p => p.variants.flatMap(v => v.instructionHandles || [])))].sort(), type: 'checklist' }),
                        
                    ].join('')
                },
                {
                    title: 'COA Details',
                    content: [
                        buildFilterSection({ title: 'BY STATUS', key: 'coaStatus', values: ['Valid', 'Due Soon', 'Expired', 'Not Attached'], type: 'checklist' }),
                        buildFilterSection({ title: 'BY EXPIRY DATE', key: 'coaExpiry', type: 'date-range' })
                    ].join('')
                },
                {
                    title: 'Yield/Stockable',
                    content: [
                        buildFilterSection({ title: 'BY STOCKABLE', key: 'stockableData', values: ['yes', 'no'], type: 'checklist' }),
                        buildFilterSection({ title: 'BY YIELD', key: 'yieldData', values: ['yes', 'no'], type: 'checklist' }),
                    ].join('')
                },
                {
                    title: 'Label Compliance',
                    content: [
                        buildFilterSection({ title: 'BY STATUS', key: 'complianceStatus', values: ['Compliant', 'Non-compliant', 'Pending'].sort(), type: 'checklist' }),
                        buildFilterSection({ title: 'BY REVIEW STATUS', key: 'reviewStatus', values: ['Completed', 'Coming Soon', 'Pending'], type: 'checklist' }),
                        buildFilterSection({ title: 'BY REVIEW DATE', key: 'lastReview', type: 'date-range' })
                    ].join('')
                }
            ];
    
            let accordionHTML = '<div class="accordion" id="mobile-filter-accordion">';
            filterConfigs.forEach((config, index) => {
                accordionHTML += `
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-${index}">
                            <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${index}" aria-expanded="${index === 0}" aria-controls="collapse-${index}">
                                ${config.title}
                            </button>
                        </h2>
                        <div id="collapse-${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading-${index}" data-bs-parent="#mobile-filter-accordion">
                            <div class="accordion-body">${config.content}</div>
                        </div>
                    </div>`;
            });
            accordionHTML += '</div>';
            
            body.innerHTML = accordionHTML;
    
            // Re-attach search listeners
            body.querySelectorAll('.filter-search-input').forEach(input => {
                input.addEventListener('input', (e) => {
                    const searchTerm = e.target.value.toLowerCase();
                    const checklist = e.target.nextElementSibling;
                    checklist.querySelectorAll('.filter-item').forEach(item => {
                        const label = item.querySelector('label');
                        if(label) {
                           item.style.display = label.textContent.toLowerCase().includes(searchTerm) ? 'flex' : 'none';
                        }
                    });
                });
            });
        }
    
        mobileFilterModalEl.addEventListener('show.bs.modal', populateMobileFilterModal);
        // END: Mobile Filter Modal Population
    
        document.getElementById('apply-mobile-filters-btn').addEventListener('click', () => {
            const modal = document.getElementById('mobile-filter-modal');
            const newFilters = {};
            const sections = new Set([...modal.querySelectorAll('[data-section]')].map(el => el.dataset.section.replace(/-(from|to)$/, '')));
            
            sections.forEach(sectionKey => {
                 const checkboxes = modal.querySelectorAll(`input[type="checkbox"][data-section="${sectionKey}"]:checked`);
                 if(checkboxes.length > 0) {
                    newFilters[sectionKey] = [...checkboxes].map(cb => cb.value);
                 }
                 const dateFrom = modal.querySelector(`input[type="date"][data-section="${sectionKey}-from"]`);
                 if(dateFrom && dateFrom.value) {
                    if(!newFilters[sectionKey]) newFilters[sectionKey] = {};
                    newFilters[sectionKey].from = dateFrom.value;
                 }
                 const dateTo = modal.querySelector(`input[type="date"][data-section="${sectionKey}-to"]`);
                 if(dateTo && dateTo.value) {
                    if(!newFilters[sectionKey]) newFilters[sectionKey] = {};
                    newFilters[sectionKey].to = dateTo.value;
                 }
            });
    
            activeFilters = newFilters;
            currentPage = 1;
            updateView();
            mobileFilterModal.hide();
        });
        
        document.getElementById('clear-mobile-filters-btn').addEventListener('click', () => {
            activeFilters = {};
            currentPage = 1;
            updateView();
            mobileFilterModal.hide();
        });
        // --- END: FILTER LOGIC ---
        
        async function downloadExcelReport() {
            const btn = document.getElementById('download-excel-btn');
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...`;
    
            try {
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Ingredients Report');
    
                worksheet.columns = [
                    { header: 'Sl No.', key: 'sl', width: 8 }, 
                    { header: 'Product Name', key: 'productName', width: 30 }, 
                    { header: 'Approved Vendors', key: 'vendors', width: 30 }, 
                    { header: 'Image URL', key: 'imageUrl', width: 40 }, 
                    { header: 'Brand', key: 'brand', width: 25 }, 
                    { header: 'Risk Level', key: 'risk', width: 15 }, 
                    { header: 'Allergens', key: 'allergens', width: 25 }, 
                    { header: 'Storage', key: 'storage', width: 25 }, 
                    { header: 'Instructions', key: 'instructions', width: 25 }, 
                    { header: 'COA Expiry', key: 'coa', width: 15, style: { numFmt: 'dd/mm/yyyy' } }, 
                    { header: 'Compliance Status', key: 'compliance', width: 18 }
                ];
                worksheet.getRow(1).font = { bold: true };
    
                productData.forEach((product, index) => {
                    product.variants.forEach(variant => {
                        const coaDate = variant.coaExpiry && !isNaN(new Date(variant.coaExpiry)) ? new Date(variant.coaExpiry) : null;
                        worksheet.addRow({
                            sl: index + 1,
                            productName: product.productName,
                            vendors: (product.approvedVendors || []).join(', '),
                            imageUrl: variant.imageUrl || 'N/A',
                            brand: variant.brand || 'N/A',
                            risk: variant.riskLevel || 'N/A',
                            allergens: (variant.allergens || []).join(', '),
                            storage: (variant.storageTemp || []).join(', '),
                            instructions: (variant.instructionHandles || []).join(', '),
                            coa: coaDate,
                            compliance: variant.complianceStatus || 'N/A'
                        });
                    });
                });
    
                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob(buffer, { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'Ingredients_Report.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error('Error generating Excel file:', error);
                alert('An error occurred while generating the Excel report.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Download Excel';
            }
        }
        document.getElementById('download-excel-btn').addEventListener('click', downloadExcelReport);
    
        // --- START: Comments Logic ---
        function openComplianceModal(variantId, isCreatingNew = false) {
            const variant = findVariantById(variantId);
            const product = findProductByVariantId(variantId);
            if (!variant) return;
    
            const modal = document.getElementById('comments-modal');
            modal.dataset.variantId = variantId;
    
            document.getElementById('commentsModalLabel').textContent = `Compliance Log for ${variant.brand}`;
            
            const historyContainer = document.getElementById('ticket-history');
            historyContainer.innerHTML = ''; // Clear previous
    
            if (variant.complianceTickets && variant.complianceTickets.length > 0) {
                const sortedTickets = [...variant.complianceTickets].sort((a,b) => new Date(b.date) - new Date(a.date));
                sortedTickets.forEach((ticket, ticketIndex) => {
                    const allPointsResolved = ticket.actionPoints.every(p => p.status === 'resolved');
                    const ticketEl = document.createElement('div');
                    ticketEl.className = 'card mb-3';
                    let pointsHTML = '<ul class="list-group list-group-flush">';
    
                    ticket.actionPoints.forEach((point, pointIndex) => {
                        const isResolved = point.status === 'resolved';
                        pointsHTML += `
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">${isResolved ? '<s>' + point.text + '</s>' : point.text}</div>
                                    ${isResolved ? `<small class="text-muted">Resolved by ${point.resolvedBy} on ${new Date(point.resolvedDate).toLocaleDateString()}: ${point.resolutionNotes} <a href="${point.evidenceUrl}" target="_blank">View Evidence</a></small>` : ''}
                                </div>
                                ${!isResolved ? `<button class="btn btn-sm btn-success resolve-point-btn" data-ticket-index="${ticketIndex}" data-point-index="${pointIndex}">Resolve</button>` : `<span class="badge bg-success rounded-pill">Resolved</span>`}
                            </li>`;
                    });
                    pointsHTML += '</ul>';
    
                    ticketEl.innerHTML = `
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">${ticket.title}</h6>
                                <small class="text-muted">Created by ${ticket.user} on ${new Date(ticket.date).toLocaleString()}</small>
                            </div>
                            <span class="status-badge ${allPointsResolved ? 'accepted' : 'rejected'}">${allPointsResolved ? 'Closed' : 'Open'}</span>
                        </div>
                        ${pointsHTML}`;
                    historyContainer.appendChild(ticketEl);
                });
            } else {
                historyContainer.innerHTML = '<p class="text-center text-muted">No compliance tickets yet.</p>';
            }
            
            const form = document.getElementById('add-ticket-form');
            form.style.display = isCreatingNew ? 'block' : 'none';
            form.reset();
            document.getElementById('action-points-container').innerHTML = `<div class="action-point-item input-group mb-2"><input type="text" class="form-control" placeholder="Action point 1..." required><button class="btn btn-outline-danger remove-action-point-btn" type="button">X</button></div>`;
            
            commentsModal.show();
        }
        
        document.getElementById('add-action-point-btn').addEventListener('click', () => {
            const container = document.getElementById('action-points-container');
            const pointCount = container.children.length + 1;
            const newItem = document.createElement('div');
            newItem.className = 'action-point-item input-group mb-2';
            newItem.innerHTML = `<input type="text" class="form-control" placeholder="Action point ${pointCount}..." required><button class="btn btn-outline-danger remove-action-point-btn" type="button">X</button>`;
            container.appendChild(newItem);
        });
    
        document.getElementById('action-points-container').addEventListener('click', e => {
            if(e.target.matches('.remove-action-point-btn') && document.getElementById('action-points-container').children.length > 1) {
                e.target.closest('.action-point-item').remove();
            }
        });
    
        document.getElementById('add-ticket-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const modal = document.getElementById('comments-modal');
            const variantId = modal.dataset.variantId;
            const ticketTitle = document.getElementById('new-ticket-title').value.trim();
            const actionPointInputs = document.querySelectorAll('#action-points-container input');
            
            if (ticketTitle && actionPointInputs.length > 0 && variantId) {
                const variant = findVariantById(variantId);
                if (variant) {
                    if (!variant.complianceTickets) variant.complianceTickets = [];
    
                    const newTicket = {
                        ticketId: 'T' + Date.now(),
                        title: ticketTitle,
                        user: 'Current User',
                        date: new Date().toISOString(),
                        actionPoints: Array.from(actionPointInputs).map(input => ({
                            text: input.value.trim(),
                            status: 'open'
                        }))
                    };
                    
                    variant.complianceTickets.push(newTicket);
                    updateProductTimestampByVariant(variantId);
                    updateView();
                    commentsModal.hide();
                    showFlashNews(variantId, newTicket);
                }
            }
        });
    
        document.getElementById('comments-modal').addEventListener('click', e => {
            if(e.target.matches('.resolve-point-btn')) {
                const variantId = e.target.closest('.modal').dataset.variantId;
                const ticketIndex = e.target.dataset.ticketIndex;
                const pointIndex = e.target.dataset.pointIndex;
                const variant = findVariantById(variantId);
                const point = variant.complianceTickets[ticketIndex].actionPoints[pointIndex];
                
                const resolveModal = document.getElementById('resolve-point-modal');
                resolveModal.dataset.variantId = variantId;
                resolveModal.dataset.ticketIndex = ticketIndex;
                resolveModal.dataset.pointIndex = pointIndex;
                document.getElementById('point-to-resolve-text').textContent = point.text;
                document.getElementById('resolve-point-form').reset();
                resolvePointModal.show();
            }
        });
        
        document.getElementById('resolve-point-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const modal = document.getElementById('resolve-point-modal');
            const { variantId, ticketIndex, pointIndex } = modal.dataset;
            
            const notes = document.getElementById('resolution-notes').value;
            const evidenceFile = document.getElementById('evidence-upload').files[0];
    
            const variant = findVariantById(variantId);
            const point = variant.complianceTickets[ticketIndex].actionPoints[pointIndex];
            
            point.status = 'resolved';
            point.resolutionNotes = notes;
            point.evidenceUrl = '#'; // In a real app, you would upload the file and get a URL
            point.resolvedBy = 'Current User';
            point.resolvedDate = new Date().toISOString();
    
            updateProductTimestampByVariant(variantId);
            resolvePointModal.hide();
            openComplianceModal(variantId); // Refresh comments modal
            updateView();
        });
    
        document.getElementById('compliance-center-btn').addEventListener('click', () => {
            const body = document.getElementById('compliance-center-body');
            body.innerHTML = '';
            let hasOpenPoints = false;
    
            productData.forEach(product => {
                product.variants.forEach(variant => {
                    const openTickets = variant.complianceTickets?.filter(t => t.actionPoints.some(p => p.status === 'open'));
                    if (openTickets && openTickets.length > 0) {
                        hasOpenPoints = true;
                        openTickets.forEach(ticket => {
                            const openPoints = ticket.actionPoints.filter(p => p.status === 'open');
                            const ticketHTML = `
                            <div class="card mb-3">
                                <div class="card-header"><strong>${product.productName} - ${variant.brand}</strong></div>
                                <div class="card-body">
                                    <h6 class="card-title">${ticket.title} (${openPoints.length} open point${openPoints.length > 1 ? 's' : ''})</h6>
                                    <ul class="list-unstyled mb-2">
                                    ${openPoints.map(p => `<li>- ${p.text}</li>`).join('')}
                                    </ul>
                                    <button class="btn btn-sm btn-primary view-ticket-btn" data-variant-id="${variant.id}">View Full Ticket</button>
                                </div>
                            </div>`;
                            body.insertAdjacentHTML('beforeend', ticketHTML);
                        });
                    }
                });
            });
            
            if (!hasOpenPoints) {
                body.innerHTML = '<p class="text-center text-muted">No open action points found.</p>';
            }
    
            complianceCenterModal.show();
        });
        
        document.getElementById('compliance-center-body').addEventListener('click', e => {
            if (e.target.matches('.view-ticket-btn')) {
                const variantId = e.target.dataset.variantId;
                complianceCenterModal.hide();
                // Wait for modal to hide before showing the next one
                setTimeout(() => openComplianceModal(variantId), 500);
            }
        });
    
        // --- END: Comments Logic ---
    
        // --- START: Flash News Logic ---
        function showFlashNews(variantId, ticket) {
            const ticker = document.getElementById('flash-news');
            const textEl = document.getElementById('flash-news-text');
    
            const message = `A new Compliance Ticket has been created by ${ticket.user}: "${ticket.title}". Click here to see details.`;
            textEl.textContent = message;
            textEl.dataset.variantId = variantId;
            
            ticker.style.display = 'block';
            document.body.style.paddingTop = `${ticker.offsetHeight}px`; // Adjust body padding
    
            // Reset animation
            textEl.style.animation = 'none';
            textEl.offsetHeight; /* trigger reflow */
            textEl.style.animation = ''; 
    
            const duration = message.length / 25;
            textEl.style.animationDuration = `${Math.max(15, duration)}s`;
        }
    
        document.getElementById('flash-news-text').addEventListener('click', e => {
            const variantId = e.target.dataset.variantId;
            const row = document.querySelector(`tr[data-variant-id="${variantId}"]`);
            if (row) {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => { // open modal after scroll
                    openComplianceModal(variantId);
                }, 500);
            }
            document.getElementById('flash-news').style.display = 'none';
            document.body.style.paddingTop = '0';
        });
    
        document.getElementById('close-ticker-btn').addEventListener('click', () => {
             document.getElementById('flash-news').style.display = 'none';
             document.body.style.paddingTop = '0';
        });
        // --- END: Flash News Logic ---
    
        // --- START: NEW Comprehensive Dashboard Logic ---
        function calculateAndRenderDashboard() {
            const stats = {
                overallCompliant: 0, overallNonCompliant: 0,
                vendorAttached: 0, vendorNotAttached: 0,
                specAttached: 0, specNotAttached: 0,
                brandAttached: 0, brandNotAttached: 0,
                productActive: 0, productInactive: 0,
                brandActive: 0, brandInactive: 0,
                imageAttached: 0, imageNotAttached: 0,
                highRisk: 0, mediumRisk: 0, lowRisk: 0, riskNotIdentified: 0,
                allergenFood: 0, allergenFree: 0,
                labelingCompliant: 0, labelingNonCompliant: 0, labelingPending: 0,
                coaValid: 0, coaDueSoon: 0, coaExpired: 0, coaNotUploaded: 0,
                coaValidDays: [], coaDueSoonDays: [], coaExpiredDays: []
            };
            
            productData.forEach(product => {
                // Product Level Stats
                if (product.isProductActive) stats.productActive++; else stats.productInactive++;
                if (product.approvedVendors && product.approvedVendors.length > 0) stats.vendorAttached++; else stats.vendorNotAttached++;
                if (product.specificationName) stats.specAttached++; else stats.specNotAttached++;
                
                if (product.variants && product.variants.length > 0) {
                    stats.brandAttached++;
                    if (product.variants.some(v => v.complianceStatus === 'Non-compliant')) stats.overallNonCompliant++; else stats.overallCompliant++;
                } else {
                    stats.brandNotAttached++;
                    stats.overallCompliant++; // No variants, so compliant by default
                }
    
                // Variant Level Stats
                product.variants.forEach(variant => {
                    if (variant.isActive) stats.brandActive++; else stats.brandInactive++;
                    if (variant.imageUrl) stats.imageAttached++; else stats.imageNotAttached++;
    
                    if (variant.riskLevel === 'high') stats.highRisk++;
                    else if (variant.riskLevel === 'medium') stats.mediumRisk++;
                    else if (variant.riskLevel === 'low') stats.lowRisk++;
                    else stats.riskNotIdentified++;
                    
                    if (variant.allergens && variant.allergens.length > 0 && !(variant.allergens.length === 1 && variant.allergens[0] === 'None')) stats.allergenFood++; else stats.allergenFree++;
    
                    if (variant.complianceStatus === 'Compliant') stats.labelingCompliant++;
                    else if (variant.complianceStatus === 'Non-compliant') stats.labelingNonCompliant++;
                    else stats.labelingPending++;
    
                    const daysDiff = getDaysDifference(variant.coaExpiry);
                    if (!variant.coaExpiry) {
                        stats.coaNotUploaded++;
                    } else if (daysDiff < 0) {
                        stats.coaExpired++;
                        stats.coaExpiredDays.push(daysDiff);
                    } else if (daysDiff <= 30) {
                        stats.coaDueSoon++;
                        stats.coaDueSoonDays.push(daysDiff);
                        stats.coaValid++; // Still valid
                        stats.coaValidDays.push(daysDiff);
                    } else {
                        stats.coaValid++;
                        stats.coaValidDays.push(daysDiff);
                    }
                });
            });
            
            const avgDays = (arr) => arr.length ? (arr.reduce((a, b) => a + b, 0) / arr.length).toFixed(0) : 0;
            
            const dashboardContainer = document.getElementById('summary-dashboard-container');
            
            const createSummaryCard = (config) => {
                const total = config.stats.reduce((sum, item) => sum + item.value, 0);
                
                const statsHTML = config.stats.map(item => `
                    <div class="stat-item" data-filter-type="${config.filterType}" data-filter-value="${item.filterValue || item.label}">
                        <div class="label">${item.label}</div>
                        <div class="value">${item.value}${config.showTotal ? ` / ${total}`: ''}</div>
                        ${item.subtext ? `<div class="subtext">${item.subtext}</div>` : ''}
                    </div>
                `).join('');
    
                const progressBarHTML = config.stats.map(item => {
                    const percentage = total > 0 ? (item.value / total) * 100 : 0;
                    return `<div class="progress-bar-segment ${item.color}" style="width: ${percentage}%;" title="${item.label}: ${item.value} (${percentage.toFixed(1)}%)">
                                ${percentage > 15 ? `${percentage.toFixed(0)}%` : ''}
                             </div>`;
                }).join('');
    
                return `
                    <div class="summary-card">
                        <div class="summary-card-header" data-bs-toggle="collapse" href="#${config.id}" role="button" aria-expanded="true" aria-controls="${config.id}">
                            <span class="title-group">
                                ${config.icon}
                                ${config.title}
                            </span>
                            <svg class="chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/></svg>
                        </div>
                        <div class="collapse show" id="${config.id}">
                            <div class="summary-card-body">
                                <div class="stats-grid">${statsHTML}</div>
                                <div class="summary-progress-bar">${progressBarHTML}</div>
                            </div>
                        </div>
                    </div>
                `;
            };
            
            const cardsConfig = [
                 {
                    id: 'overallComplianceCard', title: 'Overall Compliance', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>`,
                    filterType: 'overallCompliance', showTotal: true,
                    stats: [
                        { label: 'Compliant', value: stats.overallCompliant, color: 'bg-green' },
                        { label: 'Non-Compliant', value: stats.overallNonCompliant, color: 'bg-red' }
                    ]
                },
                {
                    id: 'labelingCard', title: 'Labeling Status', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>`,
                    filterType: 'complianceStatus', showTotal: true,
                    stats: [
                        { label: 'Compliant', value: stats.labelingCompliant, color: 'bg-green' },
                        { label: 'Non-Compliant', value: stats.labelingNonCompliant, color: 'bg-red' },
                        { label: 'Pending', value: stats.labelingPending, color: 'bg-grey' }
                    ]
                },
                 {
                    id: 'coaCard', title: 'COA Status', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>`,
                    filterType: 'coaStatus', showTotal: true,
                    stats: [
                        { label: 'Valid', value: stats.coaValid, color: 'bg-green', subtext: `Avg ${avgDays(stats.coaValidDays)} days left`},
                        { label: 'Due Soon', value: stats.coaDueSoon, color: 'bg-yellow', subtext: `Avg ${avgDays(stats.coaDueSoonDays)} days left` },
                        { label: 'Expired', value: stats.coaExpired, color: 'bg-red', subtext: `Avg ${Math.abs(avgDays(stats.coaExpiredDays))} days ago` },
                        { label: 'Not Attached', value: stats.coaNotUploaded, color: 'bg-grey' }
                    ]
                },
                {
                    id: 'riskCard', title: 'Risk Profile', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>`,
                    filterType: 'riskLevel', showTotal: true,
                    stats: [
                        { label: 'High', value: stats.highRisk, color: 'bg-red', filterValue: 'high' },
                        { label: 'Medium', value: stats.mediumRisk, color: 'bg-yellow', filterValue: 'medium' },
                        { label: 'Low', value: stats.lowRisk, color: 'bg-green', filterValue: 'low' },
                        { label: 'Not Identified', value: stats.riskNotIdentified, color: 'bg-grey'}
                    ]
                },
                {
                    id: 'productStatusCard', title: 'Product Status', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>`,
                    filterType: 'productStatus', showTotal: true,
                    stats: [
                        { label: 'Active', value: stats.productActive, color: 'bg-green' },
                        { label: 'Inactive', value: stats.productInactive, color: 'bg-red' }
                    ]
                },
                {
                    id: 'brandStatusCard', title: 'Brand Status', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M12 2.25L9.75 3.563M12 2.25V5.25m0 0L9.75 6.563m2.25-1.313L14.25 6.563M5.25 8.813l2.25 1.313m0 0L9.75 11.438m-2.25-1.313L5.25 11.438m2.25-1.313L7.5 5.25m-2.25 3.563L3 10.063m0 0L5.25 11.437M3 10.063l2.25-1.25M18.75 8.813l-2.25 1.313m0 0L14.25 11.438m2.25-1.313L18.75 11.438m-2.25-1.313L16.5 5.25m2.25 3.563L21 10.063m0 0L18.75 11.437M21 10.063l-2.25-1.25" /></svg>`,
                    filterType: 'brandStatus', showTotal: true,
                    stats: [
                        { label: 'Active', value: stats.brandActive, color: 'bg-green' },
                        { label: 'Inactive', value: stats.brandInactive, color: 'bg-red' }
                    ]
                },
                {
                    id: 'imageCard', title: 'Image Attachment', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>`,
                    filterType: 'imageAttachment', showTotal: true,
                    stats: [
                        { label: 'Attached', value: stats.imageAttached, color: 'bg-green' },
                        { label: 'Not Attached', value: stats.imageNotAttached, color: 'bg-red' }
                    ]
                },
                {
                    id: 'allergenCard', title: 'Allergen Profile', icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>`,
                    filterType: 'allergenProfile', showTotal: true,
                    stats: [
                        { label: 'Allergen', value: stats.allergenFood, color: 'bg-yellow' },
                        { label: 'Allergen-Free', value: stats.allergenFree, color: 'bg-blue' }
                    ]
                },
            ];
    
            dashboardContainer.innerHTML = cardsConfig.map(createSummaryCard).join('');
        }
    
        document.getElementById('summary-dashboard-container').addEventListener('click', e => {
            const statItem = e.target.closest('.stat-item');
            if (statItem) {
                const filterType = statItem.dataset.filterType;
                const filterValue = statItem.dataset.filterValue;
                
                activeFilters = { [filterType]: [filterValue] };
                currentPage = 1;
                updateView();
            }
        });
        // --- END: NEW Comprehensive Dashboard Logic ---
    
    
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
        
        
        const refreshBtn = document.getElementById('refresh-table-btn');
        refreshBtn.addEventListener('click', () => {
            
            refreshBtn.disabled = true;
            refreshBtn.querySelector('.button-text').textContent = 'Refreshing...';
    
            setTimeout(() => {
                activeFilters = {};
                universalSearchTerm = '';
                document.getElementById('universal-search-input').value = '';
                updateView();
                refreshBtn.disabled = false;
                refreshBtn.querySelector('.button-text').textContent = 'Refresh';
            }, 300);
        });
    
        updateView(); // Initial Render
}
    // });
</script>



 <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- UPLOADER COMPONENT SCRIPT ---
        (() => {
            const uploadArea = document.querySelector('.details-container');
            const directCameraBtn = document.getElementById('direct-camera-btn');
            const directCamcorderBtn = document.getElementById('direct-camcorder-btn');
            const directGalleryBtn = document.getElementById('direct-gallery-btn');
            const cameraFileInput = document.getElementById('camera-file-input');
            const galleryFileInput = document.getElementById('gallery-file-input');
            const imageCollagePreviewArea = document.getElementById('image-collage-preview-area');
            const createCollageBtn = document.getElementById('create-collage-btn');
            const imageError = document.getElementById('image-error');
            const videoRecorderModal = document.getElementById('video-recorder-modal');
            const videoPreview = document.getElementById('video-preview');
            const startRecordBtn = document.getElementById('start-record-btn');
            const stopRecordBtn = document.getElementById('stop-record-btn');
            const saveVideoBtn = document.getElementById('save-video-btn');
            const cancelVideoBtn = document.getElementById('cancel-video-btn');
            const recordingIndicator = document.getElementById('recording-indicator');
            const collageMakerContainer = document.getElementById('collage-maker-container');
            const closeCollageMakerBtn = document.getElementById('close-collage-maker');
            const cancelCollageBtn = document.getElementById('cancel-collage-btn');
            const saveCollageBtn = document.getElementById('save-collage-btn');
            const collageMakerPreviewArea = document.getElementById('collage-maker-preview-area');
            const collageCanvas = document.getElementById('collage-canvas');
            const collageLayoutSelect = document.getElementById('collage-layout-select');
            const collageStyleModifier = document.getElementById('collage-style-modifier');
            const collageBorderSelect = document.getElementById('collage-border-select');
            const collageLayouts = document.querySelectorAll('.collage-layout');
            const imageEditorModal = document.getElementById('image-editor-modal');
            const closeImageEditorBtn = document.getElementById('close-image-editor-btn');
            const editorSaveChangesBtn = document.getElementById('editor-save-changes-btn');
            const editorResetBtn = document.getElementById('editor-reset-btn');
            const imageEditorCanvas = document.getElementById('image-editor-canvas');
            const mainToolbar = document.getElementById('main-editor-toolbar');
            const imagePreviewModal = document.getElementById('image-preview-modal');
            const closeImagePreviewModalBtn = document.getElementById('close-image-preview-modal');
            const cropApplyBtn = document.getElementById('crop-apply-btn');
            const cropCancelBtn = document.getElementById('crop-cancel-btn');
            const aspectRatioSelect = document.getElementById('aspect-ratio-select');
            const cropApplyBtnMobile = document.getElementById('crop-apply-btn-mobile');
            const cropCancelBtnMobile = document.getElementById('crop-cancel-btn-mobile');
            const aspectRatioSelectMobile = document.getElementById('aspect-ratio-select-mobile');
            const complaintInputWrapper = document.getElementById('complaintInputWrapper');

            const MAX_FILES_TOTAL = 6;
            let selectedFiles = [];
            let currentEditingFileIndex = -1;
            let currentEditorObjectURL = null;
            let mediaRecorder;
            let recordedChunks = [];
            let mediaStream = null;
            let recordedFile = null;
            let editorState = {};
window.getUploadedFiles = () => selectedFiles;

            function resetUploader() {
                selectedFiles.forEach(file => {
                    if (file.objectURL) {
                        URL.revokeObjectURL(file.objectURL);
                    }
                });
                selectedFiles = [];
                updateMainFormPreview();
                hideImageError();
            }

            document.addEventListener('form-reset', resetUploader);

            function resetEditorState() {
                editorState = {
                    activeTool: 'select', objects: [], baseImage: null, originalImage: null,
                    selectedObjectId: null, isDrawing: false, isDragging: false, isErasing: false,
                    startX: 0, startY: 0, lastDragX: 0, lastDragY: 0,
                    tempObject: null, isCropping: false, cropBox: null, aspectRatio: 'free', activeHandle: null,
                };
                mainToolbar.querySelectorAll('button').forEach(b => b.classList.remove('active'));
                document.getElementById('tool-select-btn').classList.add('active');
                closeAllSubToolbars(false);
                setCanvasCursor();
            }

            if (directCameraBtn) {
                directCameraBtn.addEventListener('click', () => { if (!isAtMaxFiles()) cameraFileInput.click(); });
            }
            if (directCamcorderBtn) {
                directCamcorderBtn.addEventListener('click', () => { if (!isAtMaxFiles()) { videoRecorderModal.style.display = 'flex'; startVideoStream(); } });
            }
            if (directGalleryBtn) {
                directGalleryBtn.addEventListener('click', () => { if (!isAtMaxFiles()) galleryFileInput.click(); });
            }

            cameraFileInput.addEventListener('change', (e) => {
                const files = e.target.files;
                if (files.length > 0) {
                    const startIndex = selectedFiles.length;
                    processAndAddFiles(files);
                    if (selectedFiles.length > startIndex) {
                        const newFileIndex = selectedFiles.length - 1;
                        setTimeout(() => launchImageEditor(selectedFiles[newFileIndex], newFileIndex, 'crop'), 100);
                    }
                }
            });
            galleryFileInput.addEventListener('change', (e) => processAndAddFiles(e.target.files));

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eName => uploadArea.addEventListener(eName, e => { e.preventDefault(); e.stopPropagation(); }, false));
            ['dragenter', 'dragover'].forEach(eName => uploadArea.addEventListener(eName, () => uploadArea.classList.add('highlight')));
            ['dragleave', 'drop'].forEach(eName => uploadArea.addEventListener(eName, () => uploadArea.classList.remove('highlight')));
            uploadArea.addEventListener('drop', (e) => { const dt = e.dataTransfer; if (dt.files) processAndAddFiles(dt.files); });

            function isAtMaxFiles() {
                if (selectedFiles.length >= MAX_FILES_TOTAL) {
                    showImageError(`Maximum of ${MAX_FILES_TOTAL} files allowed.`);
                    return true;
                }
                return false;
            }

            function processAndAddFiles(files) {
                if (isAtMaxFiles()) return;
                hideImageError();
                const newValidFiles = [];
                const allowedTypePrefixes = ['image/', 'video/', 'application/pdf'];
                for (const file of files) {
                    if (selectedFiles.length + newValidFiles.length >= MAX_FILES_TOTAL) {
                        showImageError(`Maximum ${MAX_FILES_TOTAL} files reached.`);
                        break;
                    }
                    if (!allowedTypePrefixes.some(prefix => file.type.startsWith(prefix))) {
                        showImageError(`Invalid type: ${file.name}`);
                        continue;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        showImageError(`File too large: ${file.name}`);
                        continue;
                    }
                    newValidFiles.push(file);
                }
                if (newValidFiles.length > 0) {
                    selectedFiles.push(...newValidFiles);
                    updateMainFormPreview();
                }
                cameraFileInput.value = '';
                galleryFileInput.value = '';
            }

            function updateMainFormPreview() {
                imageCollagePreviewArea.innerHTML = '';
                const hasFiles = selectedFiles.length > 0;

                complaintInputWrapper.classList.toggle('has-media', hasFiles);

                imageCollagePreviewArea.style.display = hasFiles ? 'grid' : 'none';

                if (hasFiles) {
                    const imageFileCount = selectedFiles.filter(f => f.type.startsWith('image/')).length;
                    createCollageBtn.style.display = imageFileCount > 1 ? 'block' : 'none';
                    selectedFiles.forEach((file, index) => {
                        const item = document.createElement('div');
                        item.className = 'preview-item';
                        const controls = document.createElement('div');
                        controls.className = 'preview-item-controls';
                        const fileURL = file.objectURL || URL.createObjectURL(file);
                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = fileURL;
                            img.alt = file.name;
                            item.appendChild(img);
                            item.ondblclick = (e) => { e.stopPropagation(); openImagePreviewModal(fileURL); };
                            let lastTap = 0;
                            item.addEventListener('touchend', (e) => {
                                const currentTime = new Date().getTime();
                                const tapLength = currentTime - lastTap;
                                if (tapLength < 300 && tapLength > 0) {
                                    e.preventDefault(); e.stopPropagation(); openImagePreviewModal(fileURL);
                                }
                                lastTap = currentTime;
                            });
                            const enlargeBtn = document.createElement('button');
                            enlargeBtn.className = 'enlarge-preview-btn'; enlargeBtn.innerHTML = '⚲';
                            enlargeBtn.title = "Enlarge Image";
                            enlargeBtn.onclick = (e) => { e.stopPropagation(); openImagePreviewModal(fileURL); };
                            controls.appendChild(enlargeBtn);
                            const editBtn = document.createElement('button');
                            editBtn.className = 'edit-preview-btn'; editBtn.innerHTML = '✎';
                            editBtn.title = "Edit Image";
                            editBtn.onclick = (e) => { e.stopPropagation(); launchImageEditor(file, index); };
                            controls.appendChild(editBtn);
                        } else if (file.type.startsWith('video/')) {
                            item.innerHTML = `<div class="video-overlay"><svg viewBox="0 0 24 24"><path d="M8,5.14V19.14L19,12.14L8,5.14Z" /></svg></div><video src="${fileURL}" muted loop playsinline title="${file.name}"></video>`;
                            item.addEventListener('click', () => openImagePreviewModal(fileURL, 'video'));
                        } else if (file.type === 'application/pdf') {
                            item.innerHTML = `<div class="pdf-placeholder"><svg viewBox="0 0 24 24"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2zM9.5 11.5c0 .83-.67 1.5-1.5 1.5H7v2H5.5V7H8c.83 0 1.5.67 1.5 1.5v3zm6.5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v5z"/></svg><span>${file.name}</span></div>`;
                            item.style.cursor = 'default';
                        }
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'remove-preview-btn'; removeBtn.innerHTML = '×';
                        removeBtn.title = "Remove File";
                        removeBtn.onclick = (e) => { e.stopPropagation(); removeFileFromMainPreview(index); };
                        controls.appendChild(removeBtn);
                        item.appendChild(controls);
                        imageCollagePreviewArea.appendChild(item);
                    });
                    if (selectedFiles.length < MAX_FILES_TOTAL) {
                        const addMoreWrapper = document.createElement('div');
                        addMoreWrapper.className = 'add-more-options-wrapper';
                        
                        const createAddMoreBtn = (id, iconSvg) => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'upload-option-direct';
                            btn.innerHTML = `<div class="upload-option-direct-icon-bg hidebox">${iconSvg}</div>`;
                            if (id === 'camera') btn.addEventListener('click', () => { if (!isAtMaxFiles()) cameraFileInput.click(); });
                            else if (id === 'camcorder') btn.addEventListener('click', () => { if (!isAtMaxFiles()) { videoRecorderModal.style.display = 'flex'; startVideoStream(); } });
                            else if (id === 'gallery') btn.addEventListener('click', () => { if (!isAtMaxFiles()) galleryFileInput.click(); });
                            return btn;
                        };

                        addMoreWrapper.appendChild(createAddMoreBtn('camera', directCameraBtn.querySelector('svg').outerHTML));
                        addMoreWrapper.appendChild(createAddMoreBtn('camcorder', directCamcorderBtn.querySelector('svg').outerHTML));
                        addMoreWrapper.appendChild(createAddMoreBtn('gallery', directGalleryBtn.querySelector('svg').outerHTML));
                        
                        imageCollagePreviewArea.appendChild(addMoreWrapper);
                    }
                }
                document.dispatchEvent(new CustomEvent('complaintBoxUpdated'));
            }
            updateMainFormPreview();

            function openImagePreviewModal(url, type = 'image') {
                const content = imagePreviewModal.querySelector('.modal-content');
                const existingMedia = content.querySelector('img, video');
                if (existingMedia) { existingMedia.remove(); }
                let mediaElement;
                if (type === 'image') {
                    mediaElement = document.createElement('img');
                    mediaElement.src = url;
                    mediaElement.alt = 'Image Preview';
                } else if (type === 'video') {
                    mediaElement = document.createElement('video');
                    mediaElement.src = url;
                    mediaElement.controls = true;
                    mediaElement.autoplay = true;
                }
                if (mediaElement) { content.prepend(mediaElement); }
                imagePreviewModal.style.display = 'flex';
                document.addEventListener('keydown', onEscKey);
            }

            function closeImagePreviewModal() {
                imagePreviewModal.style.display = 'none';
                const content = imagePreviewModal.querySelector('.modal-content');
                const existingMedia = content.querySelector('img, video');
                if (existingMedia) { existingMedia.remove(); }
                document.removeEventListener('keydown', onEscKey);
            }

            function onEscKey(e) { if (e.key === 'Escape') { closeImagePreviewModal(); } }
            closeImagePreviewModalBtn.addEventListener('click', closeImagePreviewModal);
            imagePreviewModal.addEventListener('click', (e) => { if (e.target === imagePreviewModal) { closeImagePreviewModal(); } });

            function removeFileFromMainPreview(index) {
                const file = selectedFiles[index];
                if (file?.objectURL) { URL.revokeObjectURL(file.objectURL); }
                selectedFiles.splice(index, 1);
                updateMainFormPreview();
                if (selectedFiles.length < MAX_FILES_TOTAL) hideImageError();
            }
            function showImageError(msg) { imageError.textContent = msg; imageError.style.display = 'block'; }
            function hideImageError() { imageError.style.display = 'none'; }

            function stopVideoStream() { if (mediaStream) { mediaStream.getTracks().forEach(track => track.stop()); mediaStream = null; } }
            async function startVideoStream() {
                stopVideoStream();
                try {
                    mediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                    videoPreview.srcObject = mediaStream;
                    startRecordBtn.style.display = 'inline-block';
                    stopRecordBtn.style.display = 'none';
                    saveVideoBtn.style.display = 'none';
                    recordingIndicator.style.display = 'none';
                } catch (err) {
                    console.error("Error accessing camera/mic:", err);
                    alert("Could not access camera or microphone. Please check permissions.");
                    videoRecorderModal.style.display = 'none';
                }
            }
            cancelVideoBtn.addEventListener('click', () => { if (mediaRecorder && mediaRecorder.state === 'recording') mediaRecorder.stop(); stopVideoStream(); videoRecorderModal.style.display = 'none'; });
            startRecordBtn.addEventListener('click', () => {
                if (!mediaStream) return;
                recordedChunks = [];
                mediaRecorder = new MediaRecorder(mediaStream);
                mediaRecorder.ondataavailable = (event) => { if (event.data.size > 0) recordedChunks.push(event.data); };
                mediaRecorder.onstop = () => {
                    const videoBlob = new Blob(recordedChunks, { type: 'video/webm' });
                    recordedFile = new File([videoBlob], `recorded-video-${Date.now()}.webm`, { type: 'video/webm' });
                };
                mediaRecorder.start();
                startRecordBtn.style.display = 'none';
                stopRecordBtn.style.display = 'inline-block';
                recordingIndicator.style.display = 'inline-block';
            });
            stopRecordBtn.addEventListener('click', () => { if (mediaRecorder && mediaRecorder.state === 'recording') { mediaRecorder.stop(); stopRecordBtn.style.display = 'none'; saveVideoBtn.style.display = 'inline-block'; recordingIndicator.style.display = 'none'; } });
            saveVideoBtn.addEventListener('click', () => { if (recordedFile) processAndAddFiles([recordedFile]); stopVideoStream(); videoRecorderModal.style.display = 'none'; });

            function launchImageEditor(file, index, defaultTool = 'select') {
                resetEditorState();
                currentEditingFileIndex = index;
                if (currentEditorObjectURL) { URL.revokeObjectURL(currentEditorObjectURL); }
                if (!file || !file.type.startsWith('image/')) return;
                currentEditorObjectURL = file.objectURL || URL.createObjectURL(file);
                const img = new Image();
                img.onload = () => {
                    editorState.baseImage = img;
                    editorState.originalImage = img;
                    imageEditorModal.style.display = 'flex';
                    setTimeout(() => {
                        setInitialCanvasSize();
                        if (defaultTool === 'crop') {
                            document.getElementById('tool-crop-btn')?.click();
                        }
                    }, 50);
                };
                img.src = currentEditorObjectURL;
            }

            function setInitialCanvasSize() {
                const previewArea = imageEditorCanvas.parentElement;
                const img = editorState.baseImage;
                const areaW = previewArea.clientWidth;
                const areaH = previewArea.clientHeight;
                const imgW = img.naturalWidth;
                const imgH = img.naturalHeight;
                let canvasW, canvasH;
                if (imgW / imgH > areaW / areaH) {
                    canvasW = areaW;
                    canvasH = areaW / (imgW / imgH);
                } else {
                    canvasH = areaH;
                    canvasW = areaH * (imgW / imgH);
                }
                imageEditorCanvas.width = canvasW;
                imageEditorCanvas.height = canvasH;
                redrawEditorCanvas();
            }

            function closeImageEditor() { imageEditorModal.style.display = 'none'; }

            editorResetBtn.addEventListener('click', () => {
                if (!editorState.originalImage) return;
                if (!confirm('Are you sure you want to reset all changes? This cannot be undone.')) { return; }
                editorState.baseImage = editorState.originalImage;
                editorState.objects = [];
                editorState.tempObject = null;
                editorState.selectedObjectId = null;
                editorState.isDrawing = false;
                editorState.isDragging = false;
                if (editorState.isCropping) { cancelCrop(); }
                if (editorState.activeTool !== 'select') { document.getElementById('tool-select-btn')?.click(); }
                setInitialCanvasSize();
            });

            async function rotateImage() {
                if (!editorState.baseImage || editorState.isCropping) return;
                const oldW = editorState.baseImage.naturalWidth;
                const oldH = editorState.baseImage.naturalHeight;
                const rotateCanvas = document.createElement('canvas');
                rotateCanvas.width = oldH;
                rotateCanvas.height = oldW;
                const rotCtx = rotateCanvas.getContext('2d');
                rotCtx.translate(oldH / 2, oldW / 2);
                rotCtx.rotate(90 * Math.PI / 180);
                rotCtx.drawImage(editorState.baseImage, -oldW / 2, -oldH / 2);
                const rotatedImage = await new Promise(resolve => {
                    const img = new Image();
                    img.onload = () => resolve(img);
                    img.src = rotateCanvas.toDataURL();
                });
                const oldCanvasW = imageEditorCanvas.width;
                const oldCanvasH = imageEditorCanvas.height;
                
                editorState.objects.forEach(obj => {
                    const transformPoint = (x, y, w, h) => ({ x: y * (h / w), y: (w - x) * (w / h) });
                    const transformCoords = (obj, w, h) => {
                        if (obj.x !== undefined && obj.y !== undefined) { const p = transformPoint(obj.x, obj.y, w, h); obj.x = p.x; obj.y = p.y; }
                        if (obj.x1 !== undefined && obj.y1 !== undefined) { const p1 = transformPoint(obj.x1, obj.y1, w, h); obj.x1 = p1.x; obj.y1 = p1.y; }
                        if (obj.x2 !== undefined && obj.y2 !== undefined) { const p2 = transformPoint(obj.x2, obj.y2, w, h); obj.x2 = p2.x; obj.y2 = p2.y; }
                        if (obj.points) { obj.points = obj.points.map(p => transformPoint(p.x, p.y, w, h)); }
                    };
                    transformCoords(obj, oldCanvasW, oldCanvasH);
                });

                editorState.baseImage = rotatedImage;
                setInitialCanvasSize();
            }

            function redrawEditorCanvas(renderCanvas = imageEditorCanvas, forExport = false) {
                const ctx = renderCanvas.getContext('2d');
                ctx.clearRect(0, 0, renderCanvas.width, renderCanvas.height);
                if (editorState.baseImage) {
                    ctx.drawImage(editorState.baseImage, 0, 0, renderCanvas.width, renderCanvas.height);
                }
                const scale = forExport ? (editorState.baseImage.naturalWidth / imageEditorCanvas.width) : 1;
                
                const drawOnContext = (targetCtx) => {
                    editorState.objects.forEach(obj => drawObject(targetCtx, obj, scale));
                    if (editorState.tempObject && !forExport) {
                        drawObject(targetCtx, editorState.tempObject, 1);
                    }
                };

                if (editorState.isCropping && editorState.cropBox && !forExport) {
                    drawCropOverlay(ctx);
                } else {
                    drawOnContext(ctx);
                    if (!forExport && editorState.selectedObjectId) {
                        const selectedObject = editorState.objects.find(o => o.id === editorState.selectedObjectId);
                        if (selectedObject) drawSelectionHandles(ctx, selectedObject, 1);
                    }
                }
            }

            function drawObject(ctx, obj, scale = 1) {
                ctx.save();
                if (obj.type === 'text') {
                    ctx.font = `${obj.size * scale}px ${obj.font}`; ctx.fillStyle = obj.color;
                    ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
                    ctx.fillText(obj.text, obj.x * scale, obj.y * scale);
                } else if (obj.type === 'draw') {
                    ctx.strokeStyle = obj.color; ctx.lineWidth = obj.width * scale;
                    ctx.lineCap = 'round'; ctx.lineJoin = 'round'; ctx.beginPath();
                    if (obj.points.length > 0) ctx.moveTo(obj.points[0].x * scale, obj.points[0].y * scale);
                    for (let i = 1; i < obj.points.length; i++) { ctx.lineTo(obj.points[i].x * scale, obj.points[i].y * scale); }
                    ctx.stroke();
                } else if (['rect', 'circle', 'arrow'].includes(obj.type)) {
                    ctx.strokeStyle = obj.strokeColor; ctx.lineWidth = obj.strokeWidth * scale;
                    ctx.fillStyle = obj.fillColor; ctx.beginPath();
                    const x1s = obj.x1 * scale, y1s = obj.y1 * scale, x2s = obj.x2 * scale, y2s = obj.y2 * scale;
                    if (obj.type === 'rect') { ctx.rect(x1s, y1s, x2s - x1s, y2s - y1s); }
                    else if (obj.type === 'circle') { const radius = Math.hypot(x2s - x1s, y2s - y1s); ctx.arc(x1s, y1s, radius, 0, 2 * Math.PI); }
                    else if (obj.type === 'arrow') { drawArrow(ctx, x1s, y1s, x2s, y2s, scale); }
                    if (obj.isFilled) ctx.fill();
                    ctx.stroke();
                }
                ctx.restore();
            }

            function drawArrow(ctx, fromx, fromy, tox, toy, scale = 1) {
                const headlen = Math.max(10, ctx.lineWidth * 3);
                const dx = tox - fromx, dy = toy - fromy, angle = Math.atan2(dy, dx);
                ctx.moveTo(fromx, fromy); ctx.lineTo(tox, toy);
                ctx.lineTo(tox - headlen * Math.cos(angle - Math.PI / 6), toy - headlen * Math.sin(angle - Math.PI / 6));
                ctx.moveTo(tox, toy); ctx.lineTo(tox - headlen * Math.cos(angle + Math.PI / 6), toy - headlen * Math.sin(angle + Math.PI / 6));
            }

            function getCanvasForExport() {
                const exportCanvas = document.createElement('canvas');
                exportCanvas.width = editorState.baseImage.naturalWidth;
                exportCanvas.height = editorState.baseImage.naturalHeight;
                redrawEditorCanvas(exportCanvas, true);
                return exportCanvas;
            }

            function setCanvasCursor() {
                if (editorState.isCropping) { imageEditorCanvas.style.cursor = 'crosshair'; return; }
                if (editorState.activeTool === 'text') imageEditorCanvas.style.cursor = 'text';
                else if (editorState.activeTool === 'select') imageEditorCanvas.style.cursor = 'default';
                else imageEditorCanvas.style.cursor = 'crosshair';
            }

            closeImageEditorBtn.addEventListener('click', closeImageEditor);
            editorSaveChangesBtn.addEventListener('click', () => {
                commitPendingObject();
                const exportCanvas = getCanvasForExport();
                exportCanvas.toBlob((blob) => {
                    if (!blob) { closeImageEditor(); return; }
                    const originalFile = selectedFiles[currentEditingFileIndex];
                    const editedFile = new File([blob], `edited_${originalFile.name}`, { type: 'image/png', lastModified: Date.now() });
                    editedFile.objectURL = URL.createObjectURL(blob);
                    if (originalFile && originalFile.objectURL) { URL.revokeObjectURL(originalFile.objectURL); }
                    selectedFiles[currentEditingFileIndex] = editedFile;
                    if (currentEditorObjectURL) { URL.revokeObjectURL(currentEditorObjectURL); currentEditorObjectURL = null; }
                    updateMainFormPreview();
                    closeImageEditor();
                }, 'image/png', 1.0);
            });

            function commitPendingObject() {
                if (editorState.isCropping) { applyCrop(); }
                if (editorState.tempObject) {
                    let isValid = false;
                    if (editorState.tempObject.type === 'draw' && editorState.tempObject.points.length > 1) { isValid = true; }
                    else if (editorState.tempObject.type === 'text' && editorState.tempObject.text.trim() !== '') { isValid = true; }
                    else if (!['draw', 'text'].includes(editorState.tempObject.type)) { const distanceMoved = Math.hypot(editorState.tempObject.x2 - editorState.tempObject.x1, editorState.tempObject.y2 - editorState.tempObject.y1); if (distanceMoved > 5) { isValid = true; } }
                    if (isValid) { editorState.tempObject.id = `obj_${Date.now()}`; editorState.objects.push(editorState.tempObject); }
                    editorState.tempObject = null;
                    redrawEditorCanvas();
                }
            }

            mainToolbar.addEventListener('click', (e) => {
                const button = e.target.closest('button'); if (!button) return;
                commitPendingObject();
                const tool = button.dataset.tool;
                if (tool === 'rotate') { rotateImage(); return; }
                if (tool === 'undo') { if (editorState.objects.length > 0) { editorState.objects.pop(); redrawEditorCanvas(); } return; }
                editorState.activeTool = tool;
                editorState.selectedObjectId = null;
                editorState.isCropping = (tool === 'crop');
                if (editorState.isCropping) { initializeCropBox(); }
                redrawEditorCanvas();
                mainToolbar.querySelectorAll('button').forEach(b => b.classList.remove('active')); button.classList.add('active'); setCanvasCursor();
                const isMobile = window.innerWidth <= 768;
                let activeToolOptionsId = tool === 'crop' ? 'crop-options' : tool === 'text' ? 'text-options' : ['rect', 'circle', 'arrow'].includes(tool) ? 'shape-options' : tool === 'draw' ? 'draw-options' : null;
                document.querySelectorAll('.editor-options').forEach(el => el.classList.remove('active'));
                if (activeToolOptionsId) { document.getElementById(activeToolOptionsId).classList.add('active'); }
                let subToolbarId = null;
                if (tool === 'crop') subToolbarId = 'crop-options-toolbar';
                else if (tool === 'draw') subToolbarId = 'draw-options-toolbar';
                else if (tool === 'text') subToolbarId = 'text-options-toolbar';
                else if (['rect', 'circle', 'arrow'].includes(tool)) subToolbarId = 'shape-options-toolbar';
                if (isMobile) {
                    closeAllSubToolbars(false);
                    if (subToolbarId) { mainToolbar.style.display = 'none'; document.getElementById(subToolbarId).classList.add('active'); }
                }
            });

            function closeAllSubToolbars(switchToSelect = true) {
                document.querySelectorAll('.sub-toolbar').forEach(tb => tb.classList.remove('active'));
                mainToolbar.style.display = 'flex';
                if (switchToSelect && editorState.activeTool !== 'select') { document.getElementById('tool-select-btn')?.click(); }
            }
            document.querySelectorAll('.sub-toolbar-done:not(#crop-apply-btn-mobile)').forEach(btn => btn.addEventListener('click', () => { commitPendingObject(); closeAllSubToolbars(true); }));
            document.querySelectorAll('.sub-toolbar-cancel:not(#crop-cancel-btn-mobile)').forEach(btn => btn.addEventListener('click', () => { editorState.tempObject = null; editorState.isDrawing = false; redrawEditorCanvas(); closeAllSubToolbars(true); }));
            document.querySelectorAll('.sub-toolbar-undo').forEach(btn => btn.addEventListener('click', () => {
                if (editorState.tempObject) { editorState.tempObject = null; redrawEditorCanvas(); }
                else if (editorState.objects.length > 0) { editorState.objects.pop(); redrawEditorCanvas(); }
            }));
            aspectRatioSelectMobile.innerHTML = aspectRatioSelect.innerHTML;
            const fontSelectDesktop = document.getElementById('font-family-select'); const fontSelectMobile = document.getElementById('font-family-select-mobile');
            if (fontSelectDesktop) fontSelectMobile.innerHTML = fontSelectDesktop.innerHTML;
            function syncControls(sourceId, targetIds) {
                const sourceEl = document.getElementById(sourceId);
                sourceEl.addEventListener('input', () => {
                    targetIds.forEach(targetId => {
                        const targetEl = document.getElementById(targetId);
                        if (targetEl && targetEl.value !== sourceEl.value) { targetEl.value = sourceEl.value; targetEl.dispatchEvent(new Event('input', { bubbles: true })); }
                    });
                    if (sourceEl.type === 'range') { const displayId = sourceId.replace(/-input(-mobile)?/, '-value$1'); document.getElementById(displayId).textContent = `${sourceEl.value}px`; }
                    else if (sourceEl.type === 'color') { document.querySelector(`label[for="${sourceId}"]`).style.backgroundColor = sourceEl.value; }
                    updateObjectFromControls();
                });
            }
            ['brush-size-input', 'draw-color-input', 'shape-stroke-width-input', 'shape-stroke-color-input', 'font-size-input', 'font-family-select', 'text-color-input'].forEach(id => { syncControls(id, [id + '-mobile']); syncControls(id + '-mobile', [id]); });
            document.querySelectorAll('input[type="range"], input[type="color"]').forEach(input => input.dispatchEvent(new Event('input')));
            document.querySelectorAll('.color-swatch').forEach(swatch => swatch.addEventListener('click', () => document.getElementById(swatch.htmlFor).click()));
            function updateObjectFromControls() {
                const obj = editorState.tempObject; if (!obj) return;
                const getVal = (id) => document.getElementById(id + '-mobile').value;
                if (obj.type === 'text') { obj.font = getVal('font-family-select'); obj.size = parseInt(getVal('font-size-input'), 10); obj.color = getVal('text-color-input'); }
                else if (obj.type === 'draw') { obj.width = getVal('brush-size-input'); obj.color = getVal('draw-color-input'); }
                else { obj.strokeWidth = getVal('shape-stroke-width-input'); obj.strokeColor = getVal('shape-stroke-color-input'); }
                redrawEditorCanvas();
            }
            const getCanvasCoords = (e) => {
                const rect = imageEditorCanvas.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX; const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                return { x: (clientX - rect.left) * (imageEditorCanvas.width / rect.width), y: (clientY - rect.top) * (imageEditorCanvas.height / rect.height) };
            };
            function distToSegmentSquared(p, v, w) { var l2 = (v.x - w.x) ** 2 + (v.y - w.y) ** 2; if (l2 == 0) return (p.x - v.x) ** 2 + (p.y - v.y) ** 2; var t = ((p.x - v.x) * (w.x - v.x) + (p.y - v.y) * (w.y - v.y)) / l2; t = Math.max(0, Math.min(1, t)); return (p.x - (v.x + t * (w.x - v.x))) ** 2 + (p.y - (v.y + t * (w.y - v.y))) ** 2; }
            function findObjectAtPoint(coords, ctx) {
                const { x, y } = coords; const buffer = 10;
                for (let i = editorState.objects.length - 1; i >= 0; i--) {
                    const obj = editorState.objects[i]; let isHit = false;
                    switch (obj.type) {
                        case 'text': ctx.font = `${obj.size}px ${obj.font}`; const metrics = ctx.measureText(obj.text); const textW = metrics.width, textH = obj.size; if (x >= obj.x - textW / 2 - buffer && x <= obj.x + textW / 2 + buffer && y >= obj.y - textH / 2 - buffer && y <= obj.y + textH / 2 + buffer) { isHit = true; } break;
                        case 'rect': const x1 = Math.min(obj.x1, obj.x2), y1 = Math.min(obj.y1, obj.y2); const w = Math.abs(obj.x1 - obj.x2), h = Math.abs(obj.y1 - obj.y2); if (x >= x1 - buffer && x <= x1 + w + buffer && y >= y1 - buffer && y <= y1 + h + buffer) { isHit = true; } break;
                        case 'circle': const dist = Math.hypot(x - obj.x1, y - obj.y1); const radius = Math.hypot(obj.x2 - obj.x1, obj.y2 - obj.y1); if (dist <= radius + buffer) { isHit = true; } break;
                        case 'arrow': case 'draw': let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity; const points = obj.type === 'arrow' ? [{ x: obj.x1, y: obj.y1 }, { x: obj.x2, y: obj.y2 }] : obj.points; points.forEach(p => { minX = Math.min(minX, p.x); minY = Math.min(minY, p.y); maxX = Math.max(maxX, p.x); maxY = Math.max(maxY, p.y); }); if (x >= minX - buffer && x <= maxX + buffer && y >= minY - buffer && y <= maxY + buffer) { for (let j = 0; j < points.length - 1; j++) { const p1 = points[j], p2 = points[j + 1]; const distSq = distToSegmentSquared({ x, y }, p1, p2); const lineBuffer = (obj.width || obj.strokeWidth || 5) / 2 + buffer; if (distSq <= lineBuffer * lineBuffer) { isHit = true; break; } } } break;
                    }
                    if (isHit) return obj;
                }
                return null;
            }
            function onPointerDown(e) { e.preventDefault(); const coords = getCanvasCoords(e); editorState.startX = coords.x; editorState.startY = coords.y; if (editorState.isCropping) { onCropPointerDown(coords); return; } if (editorState.activeTool === 'select') { commitPendingObject(); const selectedObject = findObjectAtPoint(coords, imageEditorCanvas.getContext('2d')); if (selectedObject) { editorState.selectedObjectId = selectedObject.id; editorState.isDragging = true; editorState.lastDragX = coords.x; editorState.lastDragY = coords.y; } else { editorState.selectedObjectId = null; } redrawEditorCanvas(); } else if (editorState.activeTool !== 'text') { commitPendingObject(); editorState.isDrawing = true; const getVal = id => document.getElementById(id + '-mobile').value; const props = { strokeWidth: getVal('shape-stroke-width-input'), strokeColor: getVal('shape-stroke-color-input'), width: getVal('brush-size-input'), color: getVal('draw-color-input'), }; if (editorState.activeTool === 'draw') { editorState.tempObject = { type: 'draw', points: [{ x: coords.x, y: coords.y }], ...props }; } else { editorState.tempObject = { type: editorState.activeTool, x1: coords.x, y1: coords.y, x2: coords.x, y2: coords.y, ...props }; } } }
            function onPointerMove(e) { const coords = getCanvasCoords(e); if (editorState.isCropping) { onCropPointerMove(coords); return; } if (editorState.isDragging && editorState.selectedObjectId) { e.preventDefault(); const selectedObject = editorState.objects.find(o => o.id === editorState.selectedObjectId); if (!selectedObject) return; const dx = coords.x - editorState.lastDragX; const dy = coords.y - editorState.lastDragY; switch (selectedObject.type) { case 'text': selectedObject.x += dx; selectedObject.y += dy; break; case 'rect': case 'circle': case 'arrow': selectedObject.x1 += dx; selectedObject.y1 += dy; selectedObject.x2 += dx; selectedObject.y2 += dy; break; case 'draw': selectedObject.points.forEach(p => { p.x += dx; p.y += dy; }); break; } editorState.lastDragX = coords.x; editorState.lastDragY = coords.y; redrawEditorCanvas(); } else if (editorState.isDrawing) { e.preventDefault(); if (editorState.tempObject) { if (editorState.activeTool === 'draw') editorState.tempObject.points.push({ x: coords.x, y: coords.y }); else { editorState.tempObject.x2 = coords.x; editorState.tempObject.y2 = coords.y; } redrawEditorCanvas(); } } else if (editorState.activeTool === 'select') { const hoveredObject = findObjectAtPoint(coords, imageEditorCanvas.getContext('2d')); imageEditorCanvas.style.cursor = hoveredObject ? 'move' : 'default'; } }
            function onPointerUp(e) { if (editorState.isCropping) { onCropPointerUp(); return; } if (editorState.isDrawing) { editorState.isDrawing = false; redrawEditorCanvas(); } else if (editorState.isDragging) { editorState.isDragging = false; } else if (editorState.activeTool === 'text') { const { x, y } = getCanvasCoords(e); if (Math.hypot(x - editorState.startX, y - editorState.startY) < 10) { commitPendingObject(); const text = prompt("Enter text:", "Text"); if (text) { const getVal = id => document.getElementById(id + '-mobile').value; editorState.tempObject = { type: 'text', text, x, y, font: getVal('font-family-select'), size: parseInt(getVal('font-size-input'), 10), color: getVal('text-color-input') }; redrawEditorCanvas(); } } } }
            imageEditorCanvas.addEventListener('pointerdown', onPointerDown);
            imageEditorCanvas.addEventListener('pointermove', onPointerMove);
            imageEditorCanvas.addEventListener('pointerup', onPointerUp);
            imageEditorCanvas.addEventListener('pointerleave', () => { if (editorState.isDrawing || editorState.isCropping) { onPointerUp(); } if (editorState.isDragging) { editorState.isDragging = false; } });
            window.addEventListener('resize', () => { if (imageEditorModal.style.display === 'flex') { setInitialCanvasSize(); if (editorState.isCropping) { initializeCropBox(); } } });

            function initializeCropBox() { const w = imageEditorCanvas.width * 0.8; const h = imageEditorCanvas.height * 0.8; const x = (imageEditorCanvas.width - w) / 2; const y = (imageEditorCanvas.height - h) / 2; editorState.cropBox = { x, y, w, h }; applyAspectRatio(); }
            function applyAspectRatio() { if (!editorState.cropBox || editorState.aspectRatio === 'free') return; const [w, h] = editorState.aspectRatio.split('/').map(Number); const ratio = w / h; const box = editorState.cropBox; if (box.w / box.h > ratio) { box.w = box.h * ratio; } else { box.h = box.w / ratio; } redrawEditorCanvas(); }
            function drawCropOverlay(ctx) { const box = editorState.cropBox; if (!box) return; ctx.save(); ctx.fillStyle = 'rgba(0, 0, 0, 0.6)'; ctx.beginPath(); ctx.rect(0, 0, ctx.canvas.width, ctx.canvas.height); ctx.rect(box.x, box.y, box.w, box.h); ctx.fill('evenodd'); ctx.restore(); ctx.strokeStyle = 'rgba(255, 255, 255, 0.9)'; ctx.lineWidth = 1; ctx.strokeRect(box.x, box.y, box.w, box.h); ctx.save(); ctx.setLineDash([2, 4]); ctx.beginPath(); ctx.moveTo(box.x + box.w / 3, box.y); ctx.lineTo(box.x + box.w / 3, box.y + box.h); ctx.moveTo(box.x + box.w * 2 / 3, box.y); ctx.lineTo(box.x + box.w * 2 / 3, box.y + box.h); ctx.moveTo(box.x, box.y + box.h / 3); ctx.lineTo(box.x + box.w, box.y + box.h / 3); ctx.moveTo(box.x, box.y + box.h * 2 / 3); ctx.lineTo(box.x + box.w, box.y + box.h * 2 / 3); ctx.stroke(); ctx.restore(); ctx.fillStyle = 'rgba(255, 255, 255, 0.9)'; const handleSize = 10; getHandles().forEach(handle => { ctx.fillRect(handle.x - handleSize / 2, handle.y - handleSize / 2, handleSize, handleSize); }); }
            function getHandles() { const box = editorState.cropBox; if (!box) return []; return [{ name: 'topLeft', x: box.x, y: box.y }, { name: 'topRight', x: box.x + box.w, y: box.y }, { name: 'bottomLeft', x: box.x, y: box.y + box.h }, { name: 'bottomRight', x: box.x + box.w, y: box.y + box.h }, { name: 'top', x: box.x + box.w / 2, y: box.y }, { name: 'bottom', x: box.x + box.w / 2, y: box.y + box.h }, { name: 'left', x: box.x, y: box.y + box.h / 2 }, { name: 'right', x: box.x + box.w, y: box.y + box.h / 2 },]; }
            function onCropPointerDown(coords) { const handleSize = 20; for (const handle of getHandles()) { if (Math.abs(coords.x - handle.x) < handleSize / 2 && Math.abs(coords.y - handle.y) < handleSize / 2) { editorState.activeHandle = handle.name; editorState.isDragging = true; return; } } const box = editorState.cropBox; if (box && coords.x > box.x && coords.x < box.x + box.w && coords.y > box.y && coords.y < box.y + box.h) { editorState.activeHandle = 'move'; editorState.isDragging = true; } }
            function onCropPointerMove(coords) { if (!editorState.isDragging) { const handleSize = 10; let cursor = 'crosshair'; let onHandle = false; for (const handle of getHandles()) { if (Math.abs(coords.x - handle.x) < handleSize / 2 && Math.abs(coords.y - handle.y) < handleSize / 2) { if (handle.name.includes('top') || handle.name.includes('bottom')) cursor = 'ns-resize'; if (handle.name.includes('left') || handle.name.includes('right')) cursor = 'ew-resize'; if ((handle.name.startsWith('top') && handle.name.endsWith('Left')) || (handle.name.startsWith('bottom') && handle.name.endsWith('Right'))) cursor = 'nwse-resize'; if ((handle.name.startsWith('top') && handle.name.endsWith('Right')) || (handle.name.startsWith('bottom') && handle.name.endsWith('Left'))) cursor = 'nesw-resize'; onHandle = true; break; } } if (!onHandle) { const box = editorState.cropBox; if (box && coords.x > box.x && coords.x < box.x + box.w && coords.y > box.y && coords.y < box.y + box.h) { cursor = 'move'; } } imageEditorCanvas.style.cursor = cursor; return; } const dx = coords.x - editorState.startX; const dy = coords.y - editorState.startY; const box = editorState.cropBox; const handle = editorState.activeHandle; const minSize = 20; let newX = box.x, newY = box.y, newW = box.w, newH = box.h; if (handle === 'move') { newX += dx; newY += dy; } else { if (handle.includes('left')) { newX += dx; newW -= dx; } if (handle.includes('top')) { newY += dy; newH -= dy; } if (handle.includes('right')) { newW += dx; } if (handle.includes('bottom')) { newH += dy; } } if (newW < minSize) { if (handle.includes('left')) newX = box.x + box.w - minSize; newW = minSize; } if (newH < minSize) { if (handle.includes('top')) newY = box.y + box.h - minSize; newH = minSize; } if (editorState.aspectRatio !== 'free') { const [ratioW, ratioH] = editorState.aspectRatio.split('/').map(Number); const ratio = ratioW / ratioH; const isCorner = handle.length > 5; if (isCorner || handle.includes('left') || handle.includes('right')) { const hChange = newW / ratio - box.h; if (handle.includes('top')) newY -= hChange; newH = newW / ratio; } else { const wChange = newH * ratio - box.w; if (handle.includes('left')) newX -= wChange; newW = newH * ratio; } } if (newX < 0) { newW += newX; newX = 0; } if (newY < 0) { newH += newY; newY = 0; } if (newX + newW > imageEditorCanvas.width) { newW = imageEditorCanvas.width - newX; } if (newY + newH > imageEditorCanvas.height) { newH = imageEditorCanvas.height - newY; } editorState.cropBox = { x: newX, y: newY, w: newW, h: newH }; editorState.startX = coords.x; editorState.startY = coords.y; redrawEditorCanvas(); }
            function onCropPointerUp() { editorState.isDragging = false; editorState.activeHandle = null; }
            function applyCrop() { if (!editorState.isCropping || !editorState.cropBox) return; const box = editorState.cropBox; const originalImage = editorState.baseImage; const scaleX = originalImage.naturalWidth / imageEditorCanvas.width; const scaleY = originalImage.naturalHeight / imageEditorCanvas.height; const sourceX = box.x * scaleX; const sourceY = box.y * scaleY; const sourceWidth = box.w * scaleX; const sourceHeight = box.h * scaleY; const tempCanvas = document.createElement('canvas'); tempCanvas.width = sourceWidth; tempCanvas.height = sourceHeight; const tempCtx = tempCanvas.getContext('2d'); tempCtx.drawImage(originalImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, sourceWidth, sourceHeight); const img = new Image(); img.onload = () => { editorState.baseImage = img; editorState.originalImage = img; editorState.objects = []; const croppedWidth = editorState.cropBox.w; const croppedHeight = editorState.cropBox.h; cancelCrop(); imageEditorCanvas.width = croppedWidth; imageEditorCanvas.height = croppedHeight; redrawEditorCanvas(); }; img.src = tempCanvas.toDataURL(); }
            function cancelCrop() { editorState.isCropping = false; editorState.cropBox = null; editorState.activeHandle = null; document.getElementById('tool-select-btn').click(); redrawEditorCanvas(); }
            [cropApplyBtn, cropApplyBtnMobile].forEach(btn => btn.addEventListener('click', applyCrop));
            [cropCancelBtn, cropCancelBtnMobile].forEach(btn => btn.addEventListener('click', cancelCrop));
            [aspectRatioSelect, aspectRatioSelectMobile].forEach(sel => { sel.addEventListener('change', (e) => { editorState.aspectRatio = e.target.value; applyAspectRatio(); }); });

            // --- Collage Maker Logic ---
            let collageImagesData = []; let styleModifierResources = { texture: null }; let collageState = { isDraggingPhoto: false, draggedImageIndex: -1, dragStartX: 0, dragStartY: 0 };
            function filterCollageLayouts(imageCount) {
                const layoutOptions = collageLayoutSelect.querySelectorAll('option');
                const layoutDivs = document.querySelectorAll('.collage-layout');
                const optgroups = collageLayoutSelect.querySelectorAll('optgroup');
                layoutOptions.forEach(option => { const count = parseInt(option.dataset.photoCount, 10); option.style.display = (count <= imageCount) ? '' : 'none'; });
                optgroups.forEach(group => { const visibleOptions = group.querySelectorAll('option:not([style*="display: none"])'); group.style.display = visibleOptions.length > 0 ? '' : 'none'; });
                layoutDivs.forEach(div => { const count = parseInt(div.dataset.photoCount, 10); div.style.display = (count <= imageCount) ? 'flex' : 'none'; });
            }
            function selectBestLayout(imageCount) {
                const layoutOptions = Array.from(collageLayoutSelect.querySelectorAll('option')); let bestLayoutValue = null;
                const exactMatch = layoutOptions.find(opt => parseInt(opt.dataset.photoCount, 10) === imageCount && opt.style.display !== 'none');
                if (exactMatch) { bestLayoutValue = exactMatch.value; }
                else { let highestCount = 0; layoutOptions.forEach(opt => { const count = parseInt(opt.dataset.photoCount, 10); if (count <= imageCount && count > highestCount && opt.style.display !== 'none') { highestCount = count; bestLayoutValue = opt.value; } }); }
                if (bestLayoutValue) { collageLayoutSelect.value = bestLayoutValue; collageLayouts.forEach(el => { const isActive = el.dataset.layout === bestLayoutValue; el.classList.toggle('active', isActive); el.setAttribute('aria-checked', isActive); }); }
            }
            createCollageBtn.addEventListener('click', () => {
                const imageFiles = selectedFiles.map((f, i) => ({ file: f, originalIndex: i })).filter(item => item.file.type.startsWith('image/')); if (imageFiles.length === 0) { alert('No images available for collage.'); return; }
                collageMakerContainer.style.display = 'flex'; collageImagesData = [];
                const promises = imageFiles.map(({ file, originalIndex }) => new Promise((res) => { const img = new Image(); img.src = file.objectURL || URL.createObjectURL(file); img.onload = () => { collageImagesData.push({ img, file, originalIndexInSelectedFiles: originalIndex, id: `c${Math.random()}`, isActive: true, rotation: 0 }); res(); }; img.onerror = () => res(); }));
                Promise.all(promises).then(() => { const imageCount = collageImagesData.length; filterCollageLayouts(imageCount); selectBestLayout(imageCount); generateCollagePreview(false); });
            });
            async function generateCollagePreview(forSave = false) {
                const activeImages = collageImagesData.filter(d => d.isActive); 
                const layout = collageLayoutSelect.value; 
                if (activeImages.length === 0 || !layout) { 
                    collageMakerPreviewArea.classList.add('empty'); 
                    collageCanvas.style.display = 'none';
                    if (forSave) return null;
                    return; 
                }

                const targetCanvas = forSave ? document.createElement('canvas') : collageCanvas;
                let W, H;
                
                if (forSave) {
                    let maxImageWidth = 0;
                    let maxImageHeight = 0;
                    activeImages.forEach(data => {
                        if (data.img) {
                            maxImageWidth = Math.max(maxImageWidth, data.img.naturalWidth);
                            maxImageHeight = Math.max(maxImageHeight, data.img.naturalHeight);
                        }
                    });
                    const exportDimension = Math.min(8192, Math.max(maxImageWidth, maxImageHeight, 2048));
                    W = H = exportDimension;
                } else {
                    const previewDimension = 600;
                    W = H = previewDimension;
                }

                targetCanvas.width = W;
                targetCanvas.height = H;

                if (!forSave) {
                    collageMakerPreviewArea.classList.remove('empty');
                    collageCanvas.style.display = 'block';
                }

                const ctx = targetCanvas.getContext('2d');
                const border = parseInt(collageBorderSelect.value, 10) * (W / 600);

                ctx.fillStyle = 'white'; 
                ctx.fillRect(0, 0, W, H);

                let imageIndex = 0;
                const getNextActiveImage = () => { 
                    const requiredCount = parseInt(collageLayoutSelect.options[collageLayoutSelect.selectedIndex].dataset.photoCount, 10); 
                    if (imageIndex >= requiredCount) return undefined; 
                    return activeImages[imageIndex++]; 
                }

                const drawCell = (data, x, y, w, h) => {
                    ctx.save(); 
                    ctx.beginPath(); 
                    ctx.rect(x, y, w, h); 
                    ctx.clip();
                    if (!data || !data.img) { 
                        ctx.fillStyle = '#f0f0f0'; 
                        ctx.fillRect(x, y, w, h); 
                        ctx.restore(); 
                        return; 
                    }
                    const img = data.img; 
                    const rotation = data.rotation || 0;
                    const cellCenterX = x + w / 2; 
                    const cellCenterY = y + h / 2; 
                    ctx.translate(cellCenterX, cellCenterY); 
                    ctx.rotate(rotation * Math.PI / 180);
                    const imgW = (rotation === 90 || rotation === 270) ? img.naturalHeight : img.naturalWidth; 
                    const imgH = (rotation === 90 || rotation === 270) ? img.naturalWidth : img.naturalHeight;
                    const scale = Math.max(w / imgW, h / imgH); 
                    const dw = imgW * scale; const dh = imgH * scale; 
                    ctx.drawImage(img, -dw / 2, -dh / 2, dw, dh); 
                    ctx.restore();
                };

                // Simplified layout logic for brevity
                if (layout === 'side-by-side') { 
                    const cW = (W - border) / 2; 
                    drawCell(getNextActiveImage(), 0, 0, cW, H); 
                    drawCell(getNextActiveImage(), cW + border, 0, cW, H); 
                } else if (layout === 'grid-2x2') {
                    const cW = (W - border) / 2, cH = (H - border) / 2;
                    drawCell(getNextActiveImage(), 0, 0, cW, cH);
                    drawCell(getNextActiveImage(), cW + border, 0, cW, cH);
                    drawCell(getNextActiveImage(), 0, cH + border, cW, cH);
                    drawCell(getNextActiveImage(), cW + border, cH + border, cW, cH);
                } else {
                     drawCell(getNextActiveImage(), 0, 0, W, H); 
                }

                if (forSave) {
                    return targetCanvas;
                }
            }

            function closeAndCleanupCollageMaker() { collageMakerContainer.style.display = 'none'; collageImagesData.forEach(data => { if (!data.file.objectURL) URL.revokeObjectURL(data.img.src); }); collageImagesData = []; }
            closeCollageMakerBtn.addEventListener('click', closeAndCleanupCollageMaker);
            cancelCollageBtn.addEventListener('click', closeAndCleanupCollageMaker);
            saveCollageBtn.addEventListener('click', () => {
                generateCollagePreview(true).then((exportCanvas) => {
                    if (!exportCanvas) { closeAndCleanupCollageMaker(); return; }
                    exportCanvas.toBlob((blob) => {
                        if (!blob) { closeAndCleanupCollageMaker(); return; }
                        const collageFile = new File([blob], `collage-${Date.now()}.png`, { type: 'image/png' });
                        collageFile.objectURL = URL.createObjectURL(blob);
                        const usedImageIndices = collageImagesData.filter(d => d.isActive).slice(0, parseInt(collageLayoutSelect.options[collageLayoutSelect.selectedIndex].dataset.photoCount, 10)).map(d => d.originalIndexInSelectedFiles);
                        const unusedOriginalFiles = selectedFiles.filter((file, index) => !usedImageIndices.includes(index));
                        const finalFiles = [collageFile, ...unusedOriginalFiles];
                        if (finalFiles.length > MAX_FILES_TOTAL) { URL.revokeObjectURL(collageFile.objectURL); alert(`Cannot save collage. The resulting ${finalFiles.length} files would exceed the limit of ${MAX_FILES_TOTAL}.`); return; }
                        selectedFiles = finalFiles;
                        updateMainFormPreview();
                        closeAndCleanupCollageMaker();
                    }, 'image/png', 1.0);
                });
            });
            collageLayouts.forEach(layoutDiv => { layoutDiv.addEventListener('click', () => { collageLayouts.forEach(el => { el.classList.remove('active'); el.setAttribute('aria-checked', 'false'); }); layoutDiv.classList.add('active'); layoutDiv.setAttribute('aria-checked', 'true'); collageLayoutSelect.value = layoutDiv.dataset.layout; generateCollagePreview(false); }); });
            collageLayoutSelect.addEventListener('change', () => { const layoutValue = collageLayoutSelect.value; collageLayouts.forEach(el => { const isActive = el.dataset.layout === layoutValue; el.classList.toggle('active', isActive); el.setAttribute('aria-checked', isActive); }); generateCollagePreview(false); });
            [collageBorderSelect, collageStyleModifier].forEach(el => el.addEventListener('change', () => generateCollagePreview(false)));
            function getCollageCanvasCoords(e) { const rect = collageCanvas.getBoundingClientRect(); const scaleX = collageCanvas.width / rect.width; const scaleY = collageCanvas.height / rect.height; const clientX = e.touches ? e.touches[0].clientX : e.clientX; const clientY = e.touches ? e.touches[0].clientY : e.clientY; return { x: (clientX - rect.left) * scaleX, y: (clientY - rect.top) * scaleY }; }
            function onCollagePointerDown(e) { e.preventDefault(); const coords = getCollageCanvasCoords(e); collageState.dragStartX = coords.x; collageState.dragStartY = coords.y; const activeImages = collageImagesData.filter(d => d.isActive); const requiredCount = parseInt(collageLayoutSelect.options[collageLayoutSelect.selectedIndex].dataset.photoCount, 10); for (let i = 0; i < activeImages.length && i < requiredCount; i++) { const data = activeImages[i]; if (data.bounds && coords.x >= data.bounds.x && coords.x <= data.bounds.x + data.bounds.w && coords.y >= data.bounds.y && coords.y <= data.bounds.y + data.bounds.h) { collageState.isDraggingPhoto = true; collageState.draggedImageIndex = i; collageCanvas.style.cursor = 'grabbing'; generateCollagePreview(false); return; } } }
            function onCollagePointerMove(e) { if (collageState.isDraggingPhoto) return; const coords = getCollageCanvasCoords(e); let onPhoto = false; const activeImages = collageImagesData.filter(d => d.isActive); const requiredCount = parseInt(collageLayoutSelect.options[collageLayoutSelect.selectedIndex].dataset.photoCount, 10); for (let i = 0; i < activeImages.length && i < requiredCount; i++) { const data = activeImages[i]; if (data.bounds && coords.x >= data.bounds.x && coords.x <= data.bounds.x + data.bounds.w && coords.y >= data.bounds.y && coords.y <= data.bounds.y + data.bounds.h) { onPhoto = true; break; } } collageCanvas.style.cursor = onPhoto ? 'grab' : 'default'; }
            function onCollagePointerUp(e) { const coords = getCollageCanvasCoords(e); const wasDrag = Math.hypot(coords.x - collageState.dragStartX, coords.y - collageState.dragStartY) > 10; const activeImages = collageImagesData.filter(d => d.isActive); const requiredCount = parseInt(collageLayoutSelect.options[collageLayoutSelect.selectedIndex].dataset.photoCount, 10); let actionTaken = false; if (collageState.isDraggingPhoto && wasDrag) { let dropTargetIndex = -1; for (let i = 0; i < activeImages.length && i < requiredCount; i++) { const data = activeImages[i]; if (i !== collageState.draggedImageIndex && data.bounds && coords.x >= data.bounds.x && coords.x <= data.bounds.x + data.bounds.w && coords.y >= data.bounds.y && coords.y <= data.bounds.y + data.bounds.h) { dropTargetIndex = i; break; } } if (dropTargetIndex !== -1) { const dragged = activeImages[collageState.draggedImageIndex]; activeImages[collageState.draggedImageIndex] = activeImages[dropTargetIndex]; activeImages[dropTargetIndex] = dragged; let activeIdx = 0; for (let i = 0; i < collageImagesData.length; i++) { if (collageImagesData[i].isActive) { collageImagesData[i] = activeImages[activeIdx++]; } } actionTaken = true; } } else { for (let i = 0; i < activeImages.length && i < requiredCount; i++) { const data = activeImages[i]; if (data.rotateButtonBounds && coords.x >= data.rotateButtonBounds.x && coords.x <= data.rotateButtonBounds.x + data.rotateButtonBounds.w && coords.y >= data.rotateButtonBounds.y && coords.y <= data.rotateButtonBounds.y + data.rotateButtonBounds.h) { data.rotation = ((data.rotation || 0) + 90) % 360; actionTaken = true; break; } if (data.removeButtonBounds && coords.x >= data.removeButtonBounds.x && coords.x <= data.removeButtonBounds.x + data.removeButtonBounds.w && coords.y >= data.removeButtonBounds.y && coords.y <= data.removeButtonBounds.y + data.removeButtonBounds.h) { data.isActive = false; filterCollageLayouts(activeImages.length - 1); actionTaken = true; break; } } } collageState.isDraggingPhoto = false; collageState.draggedImageIndex = -1; collageCanvas.style.cursor = 'grab'; if (actionTaken) { generateCollagePreview(false); } }
            collageCanvas.addEventListener('pointerdown', onCollagePointerDown);
            collageCanvas.addEventListener('pointermove', onCollagePointerMove);
            collageCanvas.addEventListener('pointerup', onCollagePointerUp);
            collageCanvas.addEventListener('pointerleave', () => { if (collageState.isDraggingPhoto) { collageState.isDraggingPhoto = false; collageState.draggedImageIndex = -1; collageCanvas.style.cursor = 'grab'; generateCollagePreview(false); } });
        })();

        // --- DETAILS COMPONENT SCRIPT ---
        (() => {
            // --- DATA SOURCES ---
            let allSops = ["Food Safety Policy", "Hygiene Standards", "Customer Service Protocol", "Equipment SOP", "Waste Management SOP", "General Safety Protocol"];
            let allDepartments = ['Kitchen', 'Front of House', 'Management', 'Bar'];
            
            let allLocations = [
                { name: 'Main Dining Area', department: 'Front of House' },
                { name: 'Kitchen Prep Station', department: 'Kitchen' },
                { name: 'Walk-in Freezer', department: 'Kitchen' },
                { name: 'Bar Counter', department: 'Bar' },
                { name: 'Restrooms', department: 'Front of House' }
            ];
            let allResponsibilities = ['Restaurant Manager', 'Head Chef', 'Shift Supervisor'];
            
            const allIndependentPeople = [
                { name: 'Shreekant', id: 'E0001'},
                { name: 'John Doe', id: 'E0002' },
                { name: 'Jane Smith', id: 'E0003' },
                { name: 'Peter Jones', id: 'E0004' },
                { name: 'Alice Williams', id: 'E0005' },
            ];
            const allIndependentEquipment = [
                { name: 'Oven', id: '87' },
                { name: 'Freezer', id: '42' },
                { name: 'Dishwasher', id: '11' },
                { name: 'Chiller', id: '86' },
                { name: 'POS Terminal', id: '05' }
            ];
            const allFood = ['Chicken', 'Lettuce', 'Soup', 'Beef', 'Tomatoes', 'Bread', 'Cheese'];
            
            const initialLocations = [...allLocations];
            const initialResponsibilities = [...allResponsibilities];

            let selectedSops = [], selectedPeople = [], selectedEquipment = [], selectedFood = [], selectedResponsibilities = [];
            let selectedLocations = [];

            let masterKeywordList = [
                { canonical: 'spoiled chicken', type: 'food', aliases: ['rotten chicken', 'spoled chiken'], sop: ['Food Safety Policy'], selectValue: 'Chicken' },
                { canonical: 'food safety', type: 'keyword', aliases: ['foodsafety'], sop: ['Food Safety Policy'] },
                { canonical: 'safety', type: 'keyword', aliases: ['safe', 'unsafe'], sop: ['General Safety Protocol'] },
                { canonical: 'undercooked', type: 'keyword', aliases: ['raw', 'undercokd', 'not cooked'], sop: ['Food Safety Policy'] },
                { canonical: 'Oven', type: 'equipment', aliases: ['ovn', 'bad oven'], sop: ['Equipment SOP'], selectValue: 'Oven (87)'},
                { canonical: 'Chiller', type: 'equipment', aliases: ['chiler'], sop: ['Equipment SOP'], selectValue: 'Chiller (86)' },
                { canonical: 'kitchen', type: 'location', aliases: ['cook area'], sop: ['Hygiene Standards'], selectValue: 'Kitchen Prep Station (Kitchen)' },
                { canonical: 'dining room', type: 'location', aliases: ['front area', 'seating'], sop: ['Customer Service Protocol'], selectValue: 'Main Dining Area (Front of House)' },
                { canonical: 'equipment', type: 'category_trigger', aliases: ['machine', 'appliance'], targetSelectId: 'equipmentSelector' },
                { canonical: 'employee', type: 'category_trigger', aliases: ['staff', 'person'], targetSelectId: 'peopleSelector' },
            ];
            let fuse, fuseOptions;
            let previousMatchedItems = [];

            const concernInput = document.getElementById('concernInput');
            const modelStatus = document.getElementById('modelStatus');
            const submitBtn = document.getElementById('submitBtn');
            const complaintInputWrapper = document.getElementById('complaintInputWrapper');
            const sentenceTemplate = document.getElementById('complaint-sentence-template');


            function debounce(func, delay) { let timeout; return function(...args) { clearTimeout(timeout); timeout = setTimeout(() => func.apply(this, args), delay); }; }
            
            loadSelectionsFromLocalStorage();
            fuseOptions = { includeScore: true, threshold: 0.4, ignoreLocation: true, distance: 100 };
            rebuildFuseIndex();
            
            const componentConfig = {
                sop:          { label: 'Policy',        svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>` },
                department:   { label: 'Department',    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>` },
                location:     { label: 'Location (Dept)',      svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>` },
                responsibility: { label: 'Responsibility',svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>` },
                people:       { label: 'Add Person',    svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>` },
                equipment:    { label: 'Add Equipment', svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>` },
                food:         { label: 'Add Food Item', svg: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2z"></path><path d="M15.09 15.09a2.5 2.5 0 0 1-3.54 0"></path><path d="M8.5 8.5v.01"></path><path d="M15.5 8.5v.01"></path><path d="M12 18c-2.33 0-4.5-1.19-6-3.21"></path><path d="M12 18c2.33 0 4.5-1.19 6-3.21"></path></svg>` },
            };
            
            setupMultiSelectComponent({ containerId: 'sopSelector',             config: componentConfig.sop,          dataProvider: () => allSops,                 selectedItems: selectedSops, onSelectionChange: null });
            setupMultiSelectComponent({ containerId: 'locationSelector',        config: componentConfig.location,     dataProvider: () => allLocations,            selectedItems: selectedLocations, onSelectionChange: saveSelectionsToLocalStorage, displayFormatter: item => `${item.name} (${item.department})`});
            setupMultiSelectComponent({ containerId: 'responsibilitySelector',  config: componentConfig.responsibility, dataProvider: () => allResponsibilities,     selectedItems: selectedResponsibilities, onSelectionChange: saveSelectionsToLocalStorage });
            setupMultiSelectComponent({ containerId: 'peopleSelector',          config: componentConfig.people,       dataProvider: () => allIndependentPeople,    selectedItems: selectedPeople, onSelectionChange: null, displayFormatter: item => `${item.name} (${item.id})` });
            setupMultiSelectComponent({ containerId: 'equipmentSelector',       config: componentConfig.equipment,    dataProvider: () => allIndependentEquipment, selectedItems: selectedEquipment, onSelectionChange: null, displayFormatter: item => `${item.name} (${item.id})` });
            setupMultiSelectComponent({ containerId: 'foodSelector',            config: componentConfig.food,         dataProvider: () => allFood,                 selectedItems: selectedFood, onSelectionChange: null });

            const optionalToggle = document.querySelector('.optional-details-toggle-wrapper > h4');
            if (optionalToggle) {
                optionalToggle.addEventListener('click', () => {
                    optionalToggle.parentElement.classList.toggle('is-expanded');
                });
            }

            concernInput.addEventListener('input', () => {
                 const hasText = concernInput.textContent.trim().length > 0;
                 if (hasText || complaintInputWrapper.classList.contains('has-media')) {
                     complaintInputWrapper.classList.add('is-typing');
                     sentenceTemplate.style.display = 'inline';
                 } else {
                     complaintInputWrapper.classList.remove('is-typing');
                     sentenceTemplate.style.display = 'none';
                 }
            });

            concernInput.addEventListener('input', debounce(processAndDisplayConcern, 400));
            submitBtn.addEventListener('click', handleSubmit);

            concernInput.addEventListener('click', (e) => {
                const target = e.target.closest('.highlight, .misspelled');
                if (target && target.dataset.canonical) {
                    const canonical = target.dataset.canonical;
                    const matchItem = masterKeywordList.find(item => item.canonical === canonical);
                    if (matchItem) {
                        applyMatch(matchItem);
                        
                        let targetId;
                        if (matchItem.type === 'keyword' && matchItem.sop && matchItem.sop.length > 0) {
                            targetId = 'sopSelector';
                        } else if(matchItem.type !== 'keyword') {
                           targetId = `${matchItem.type}Selector`;
                        }
                        
                        const selector = document.getElementById(targetId);
                        if (selector && selector.show) {
                           selector.show();
                        }
                    }
                }
            });
        
            function rebuildFuseIndex() { fuse = new Fuse(masterKeywordList, { ...fuseOptions, keys: ['canonical', 'aliases'] }); }
            





   
            
            function getCursorPosition(el) { try { const s=window.getSelection(); if(s.rangeCount===0)return 0; const r=s.getRangeAt(0),pr=r.cloneRange(); pr.selectNodeContents(el);pr.setEnd(r.startContainer,r.startOffset);return pr.toString().length; } catch (e) { return 0; } }
            function setCursorPosition(el,pos) { const s=window.getSelection(),r=document.createRange(),w=document.createTreeWalker(el,NodeFilter.SHOW_TEXT,null,false); let charCount=0,node; while(node=w.nextNode()){const len=node.length; if(charCount+len>=pos){try{r.setStart(node,pos-charCount);r.collapse(true);s.removeAllRanges();s.addRange(r);}catch(e){}return;}charCount+=len;} try {r.selectNodeContents(el);r.collapse(false);s.removeAllRanges();s.addRange(r);} catch(e){} }
            
            function loadSelectionsFromLocalStorage() {
                const savedLocs = localStorage.getItem('previousLocations');
                const savedResps = localStorage.getItem('previousResponsibilities');

                if (savedLocs) selectedLocations.push(...JSON.parse(savedLocs));
                if (savedResps) selectedResponsibilities.push(...JSON.parse(savedResps));
            }
            function saveSelectionsToLocalStorage() {
                localStorage.setItem('previousLocations', JSON.stringify(selectedLocations));
                localStorage.setItem('previousResponsibilities', JSON.stringify(selectedResponsibilities));
            }
            function arraysAreEqual(a, b) {
                if (a.length !== b.length) return false;
                const sortedA = [...a].sort(); const sortedB = [...b].sort();
                return sortedA.every((val, index) => val === sortedB[index]);
            }
// function handleSubmit(e) {
    
//     alert("hello");
//         e.preventDefault();

//         // Call the global function to get the files
//         const filesToUpload = window.getUploadedFiles(); // CORRECT WAY TO GET FILES

//         const savedLocs = JSON.parse(localStorage.getItem('previousLocations') || '[]');
//         const savedResps = JSON.parse(localStorage.getItem('previousResponsibilities') || '[]');
//         let needsConfirmation = false;
//         let confirmationMessage = "You are using the same selections as your last submission for:";

//         if (selectedLocations.length > 0 && arraysAreEqual(selectedLocations, savedLocs)) {
//             needsConfirmation = true;
//             confirmationMessage += "\n- Location(s)";
//         }
//         if (selectedResponsibilities.length > 0 && arraysAreEqual(selectedResponsibilities, savedResps)) {
//             needsConfirmation = true;
//             confirmationMessage += "\n- Responsibility";
//         }
//         confirmationMessage += "\n\nIs this correct?";

//         const proceed = () => {
//             const formData = new FormData();

//             // --- Add text fields ---
//             formData.append('concern', concernInput.textContent || '');
//             formData.append('sops', JSON.stringify(selectedSops));
//             formData.append('locations', JSON.stringify(selectedLocations));
//             formData.append('responsibilities', JSON.stringify(selectedResponsibilities));
//             formData.append('people', JSON.stringify(selectedPeople));
//             formData.append('equipment', JSON.stringify(selectedEquipment));
//             formData.append('food', JSON.stringify(selectedFood));
//             formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

//             // --- IMPORTANT: Append all files from the filesToUpload array ---
//             filesToUpload.forEach((file, index) => { // Use filesToUpload here
//                 formData.append(`files[${index}]`, file);
//             });

//             $.ajax({
//     url: '{{ route("postbulkupload") }}',
//     method: 'POST',
//     data: formData,
//     processData: false,  // IMPORTANT for FormData
//     contentType: false,  // IMPORTANT for FormData
//     success: function(response) {
//         console.log('Complaint saved:', response);
//         //alert("Complaint submitted successfully! The form will now be reset.");

//         // --- Reset text fields and selections ---
//         concernInput.innerHTML = "";
//         complaintInputWrapper.classList.remove('is-typing');
//         document.querySelector('#complaint-sentence-template').style.display = 'none';

//         selectedSops.length = 0;
//         selectedLocations.length = 0;
//         selectedResponsibilities.length = 0;
//         selectedPeople.length = 0;
//         selectedEquipment.length = 0;
//         selectedFood.length = 0;

//         allLocations = [...initialLocations];
//         allResponsibilities = [...initialResponsibilities];

     

//         // --- Reset uploader component state ---
//         document.dispatchEvent(new CustomEvent('form-reset'));

//         // --- Redirect after success ---
//         //window.location.href = "https://efsm.safefoodmitra.com/admin/public/index.php/inspection/newlist";
//     },
//     error: function(xhr) {
//         alert("Failed to submit complaint. Please try again.");
//         console.error(xhr.responseText);
//     }
// });

//         };

//         if (needsConfirmation) {
//             if (window.confirm(confirmationMessage)) { proceed(); }
//             else { console.log("Submission cancelled by user."); }
//         } else {
//             proceed();
//         }
//     }

    // --- Attach handler ---
    document.getElementById('submitBtn').addEventListener('click', handleSubmit);


        })();
    });
    
//     function divFunction(){
        
      
// let variantId = $("#image-upload-input").data('variantId');

//         // Call the global function to get the files
//         const filesToUpload = window.getUploadedFiles(); // CORRECT WAY TO GET FILES

//         const savedLocs = JSON.parse(localStorage.getItem('previousLocations') || '[]');
//         const savedResps = JSON.parse(localStorage.getItem('previousResponsibilities') || '[]');
//         let needsConfirmation = false;
//         let confirmationMessage = "You are using the same selections as your last submission for:";



//         const proceed = () => {
//             const formData = new FormData();
//             formData.append('variant_id', variantId);

//             // --- Add text fields ---
//             formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

//             // --- IMPORTANT: Append all files from the filesToUpload array ---
//             // filesToUpload.forEach((file, index) => { // Use filesToUpload here
//             //     formData.append(`files[${index}]`, file);
//             // });
//             alert("abc");
//               alert(formData);
//               $.ajax({
//                 url: "{{ route('variant.image.update') }}",
//                 type: "POST",
//                 data: formData,
//                 processData: false,
//                 contentType: false,
//                 success: function(response) {
//                     if (response.status === 'success') {
//                         toastr.success(response.message);
                        
//                         setTimeout(() => {
//                              reloadGetData();
//                         $('#exampleModal').modal('hide');
//                             //  location.reload(); // You can change this to dynamic refresh if needed
//                         }, 1500);
//                     } else {
//                         toastr.error(response.message); 
//                     }
//                 },
//                 error: function(xhr) {
//                     if (xhr.status === 422) {
//                         // Laravel validation error
//                         const errors = xhr.responseJSON.errors;
//                         for (let field in errors) {
//                             errors[field].forEach(msg => toastr.error(msg));
//                         }
//                     } else if (xhr.responseJSON && xhr.responseJSON.message) {
//                         // Laravel exception error
//                         toastr.error(xhr.responseJSON.message);
//                     } else {
//                         toastr.error("Something went wrong!");
//                     }
//                 }
//             });

//         };

//         if (needsConfirmation) {
//             if (window.confirm(confirmationMessage)) { proceed(); }
//             else { console.log("Submission cancelled by user."); }
//         } else {
//             proceed();
//         }
// }




function divFunction() {
    const variantId = $("#image-upload-input").data('variantId');
    const filesToUpload = window.getUploadedFiles();

    if (filesToUpload.length === 0) {
        alert("No files selected");
        return;
    }

    const compressPromises = filesToUpload.map(file => compressFileTo1MB(file));

    // Wait for all compression to finish
    Promise.all(compressPromises).then(compressedFiles => {
        const formData = new FormData();
        formData.append('variant_id', variantId);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        compressedFiles.forEach((file, idx) => {
            formData.append(`files[${idx}]`, file);
        });

        $.ajax({
            url: "{{ route('variant.image.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status === 'success') {
                    toastr.success(response.message);
                   setTimeout(()=>{
                        // reloadGetData();
                    // $('#exampleModal').modal('hide');
                    location.reload()
                   },2000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for(let field in errors){
                        errors[field].forEach(msg => toastr.error(msg));
                    }
                } else if(xhr.responseJSON && xhr.responseJSON.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    }).catch(err => {
        console.error("Error compressing files:", err);
        toastr.error("Error processing files");
    });

    // --------------------------
    // Compress a single image to ~1MB
    // --------------------------
    function compressFileTo1MB(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = function(event) {
                const img = new Image();
                img.src = event.target.result;

                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    const maxWidth = 1280;
                    const maxHeight = 720;

                    if(width > height) {
                        if(width > maxWidth) {
                            height = Math.round((height * maxWidth)/width);
                            width = maxWidth;
                        }
                    } else {
                        if(height > maxHeight) {
                            width = Math.round((width * maxHeight)/height);
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, width, height);

                    // Recursive compression to ~1MB
                    let quality = 0.8; // start
                    const compressLoop = () => {
                        canvas.toBlob(function(blob){
                            if(blob.size / (1024*1024) > 1 && quality > 0.2){
                                quality -= 0.1;
                                compressLoop();
                            } else {
                                const compressedFile = new File([blob], file.name, {
                                    type: file.type,
                                    lastModified: Date.now()
                                });
                                resolve(compressedFile);
                            }
                        }, file.type, quality);
                    };
                    compressLoop();
                };

                img.onerror = reject;
            };

            reader.onerror = reject;
        });
    }
}


document.getElementById('renew-coa-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const modalEl = document.getElementById('renew-coa-modal');
    if (modalEl.dataset.variantId) {
        formData.append('variant_id', modalEl.dataset.variantId);
    }

    fetch('/admin/public/index.php/save-coa-renewal', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            toastr.success('Renewal saved successfully!');
            const renewCoaModal = bootstrap.Modal.getInstance(modalEl);
            renewCoaModal.hide();
            form.reset();
            setTimeout(()=>{
                location.reload()
            },2000)
        } else {
            alert('Failed to save renewal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});


    </script>
</body>

</html> 







