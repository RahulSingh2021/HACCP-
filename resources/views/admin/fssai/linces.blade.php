@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
        
        button.btn.btn-outline-secondary.btn-sm {
    background: none;
    border: 1px solid #6c757d;
}

 button.btn.btn-outline-secondary.btn-sm:hover {
    background: #6c757d;
    border: 1px solid #6c757d;
}

button#exportButton {
    background: none;
    border: 1px solid #0d6efd;
}

button#exportButton:hover {
    background: #008cff;
     border: 1px solid #0d6efd;
}


button#refreshTableButton {
    background: none;
    border: 1px solid #6c757d;
}

button#refreshTableButton:hover {
    background: #008cff;
     border: 1px solid #0d6efd;
}


.main-content {
    width: 100%;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
}

        /* ========================= */
        /* ===== EMBEDDED CSS ====== */
        /* ========================= */

        /* ====== GLOBAL STYLES ====== */
        :root {
            --primary-color: #2c5f9e;
            --primary-light: #e1eaf2;
            --secondary-color: #f58220; /* Orange for scheduled items */
            --success-color: #28a745;
            --warning-color: #ffc107; /* Yellow for drafts */
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --border-color: #dee2e6;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #495057;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        .container-fluid {
            width: 100%;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            background-color: white;
            border-radius: 0;
            box-shadow: none;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            padding-top: 0px;
            padding-bottom: 30px;
        }


        h1, h2, h3, h4, h5, h6 {
            color: var(--dark-color);
            font-weight: 600;
        }

        /* ====== HEADER STYLES ====== */
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        /* ====== TOP ACTION BAR (SEARCH/FILTER) ====== */
        .table-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
            flex-shrink: 0;
        }
        .table-actions .desktop-controls-wrapper {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-left: auto;
        }
        .btn-desktop-action {
            display: none;
        }
        .mobile-controls-wrapper {
            display: none;
            align-items: center;
            gap: 10px;
            width: 100%;
        }
        .show-select-wrapper-mobile {
             flex-grow: 1;
        }
        .show-select-wrapper-mobile .rows-per-page-select {
            max-width: 70px;
        }


        /* ====== DASHBOARD CARD STYLES ====== */
        .dashboard-section {
            flex-shrink: 0;
        }
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .dashboard-card { background-color: white; border-radius: 8px; padding: 20px; box-shadow: var(--shadow-sm); border-left: 4px solid transparent; transition: var(--transition); display: flex; flex-direction: column; height: 100%; }
        .dashboard-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .dashboard-card-green { border-left-color: var(--success-color); }
        .dashboard-card-orange { border-left-color: var(--warning-color); }
        .dashboard-card-blue { border-left-color: var(--info-color); }
        .dashboard-card-red { border-left-color: var(--danger-color); }
        .dashboard-card-gray { border-left-color: var(--gray-color); }
        .card-title { font-size: 1.1rem; font-weight: 600; color: var(--dark-color); margin-bottom: 15px; }
        .card-status-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .status-compliant { background-color: rgba(40, 167, 69, 0.1); color: var(--success-color); }
        .status-due-soon { background-color: rgba(255, 193, 7, 0.1); color: var(--warning-color); }
        .status-expired { background-color: rgba(220, 53, 69, 0.1); color: var(--danger-color); }
        .status-pending { background-color: rgba(23, 162, 184, 0.1); color: var(--info-color); }
        .due-date { font-size: 0.85rem; color: var(--gray-color); }
        .progress-container { margin-bottom: 10px; }
        .progress-bar { background-color: #e9ecef; border-radius: 5px; height: 8px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 5px; transition: width 0.5s ease-in-out; }
        .progress-fill-green { background-color: var(--success-color); }
        .progress-fill-orange { background-color: var(--warning-color); }
        .progress-fill-blue { background-color: var(--info-color); }
        .progress-fill-red { background-color: var(--danger-color); }
        .card-info-row { display: flex; justify-content: flex-end; font-size: 0.85rem; color: var(--gray-color); margin-bottom: 15px; }

        /* ====== TABLE STYLES (Desktop) ====== */
        .table-section {
            margin-top: 30px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
            overflow: hidden;
        }
        .table-responsive {
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
            overflow: auto;
            flex-grow: 1;
            min-height: 0;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            padding: 12px 15px;
            vertical-align: middle;
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            white-space: nowrap;
            position: relative;
        }
        .table td:nth-child(2), .table td:nth-child(3), .table td:nth-child(9) { white-space: normal; }
        .table td:nth-child(5) {
            white-space: normal;
        }
        .table tr:hover { background-color: rgba(44, 95, 158, 0.03); }
        .editable-row { background-color: #fffde7 !important; }
        .editable-row input.is-invalid, .editable-row select.is-invalid { border-color: var(--danger-color); }
        .editable-row .other-category-name-input-wrapper { margin-top: 5px; }
        .table tr.has-draft { background-color: #fffde7 !important; font-style: italic; }
        .table tr.has-draft:hover { background-color: #fffacd !important; }

        .table tr.is-scheduled .btn-action-icon.btn-schedule {
            background-color: var(--warning-color) !important;
            border-color: var(--warning-color) !important;
            color: var(--dark-color) !important;
        }
        .scheduled-info-badge {
            font-size: 0.75rem;
            color: var(--secondary-color);
            background-color: rgba(245, 130, 32, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 4px;
            display: inline-block;
            white-space: nowrap;
        }

        .table tr.row-deactivated { background-color: #f8f9fa; color: var(--gray-color); font-style: italic; }
        .table tr.row-deactivated:hover { background-color: #e9ecef; }
        .table tr.row-deactivated .document-preview { opacity: 0.7; }
        .table tr.row-deactivated .btn { opacity: 0.65; }
        .table tr.row-deactivated .form-check-input,
        .table tr.row-deactivated .btn-action-icon { opacity: 1; }


        /* Common Status Badges, File Uploads, Buttons, Modals, Pagination etc. */
        .status { display:inline-block; padding:5px 12px; border-radius:20px; font-size:0.75rem; font-weight:600; }
        .status-active { background-color:rgba(40,167,69,0.1); color:var(--success-color); }
        .status-pending { background-color:rgba(23,162,184,0.1); color:var(--info-color); }
        .status-expired { background-color:rgba(220,53,69,0.1); color:var(--danger-color); }
        .status-deactivated { background-color:rgba(108,117,125,0.1); color:var(--gray-color); }
        .file-upload { position:relative; display:inline-block; padding:8px 16px; background-color:var(--light-color); border:1px dashed var(--border-color); border-radius:4px; cursor:pointer; font-size:0.85rem; }
        .file-upload:hover { background-color:#e9ecef; border-color:var(--gray-color); }
        .file-upload input[type="file"] { position:absolute; left:0; top:0; opacity:0; width:100%; height:100%; cursor:pointer; }
        .uploaded-file {
            font-size:0.8rem;
            color:var(--success-color);
            margin-top:5px;
            display:flex;
            align-items:center;
            gap:5px;
            overflow-wrap: break-word; /* For better text wrapping */
            word-break: break-all;     /* Fallback for very long non-breaking strings */
            max-width: 100%;           /* Respect parent container width */
        }
        .document-preview { display:flex; align-items:center; gap:8px; padding:5px; background-color:#f8f9fa; border-radius:4px; cursor:pointer; max-width:200px; min-width:150px; }
        .document-preview:hover { background-color:#e9ecef; }
        .document-icon { font-size:1.1rem; flex-shrink:0; }
        .document-icon.fa-file-pdf { color:#e74c3c; } .document-icon.fa-file-image { color:#3498db; } .document-icon.fa-file-word { color:#2b579a; } .document-icon.fa-file-excel { color:#217346; }
        .document-name {
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            font-size:0.85rem;
            overflow-wrap: break-word;
        }
        .btn { font-weight:500; padding:8px 16px; border-radius:5px; } .btn-sm { padding:5px 10px; font-size:0.85rem; }
        #submitDraftsButton:disabled { cursor:not-allowed; opacity:0.65; }

        .action-buttons-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .action-btns {
            display: flex;
            flex-wrap: nowrap;
            gap: 5px;
            align-items: center;
        }
         .btn-action-icon {
            padding: 0.3rem 0.6rem;
            font-size: 0.9rem;
            line-height: 1;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        .btn-action-icon:hover {
            transform: scale(1.1);
        }
        .btn-action-icon.btn-renew { background-color: var(--info-color); color: white; border-color: var(--info-color);}
        .btn-action-icon.btn-renew:hover { background-color: #138496; border-color: #117a8b;}
        .btn-action-icon.btn-history { background-color: var(--gray-color); color: white; border-color: var(--gray-color);}
        .btn-action-icon.btn-history:hover { background-color: #5a6268; border-color: #545b62;}
        .btn-action-icon.btn-delete { background-color: var(--danger-color); color: white; border-color: var(--danger-color);}
        .btn-action-icon.btn-delete:hover { background-color: #c82333; border-color: #bd2130;}
        .btn-action-icon.btn-submit-draft { background-color: var(--success-color); color: white; border-color: var(--success-color);}
        .btn-action-icon.btn-submit-draft:hover { background-color: #1e7e34; border-color: #1c7430;}
        .btn-action-icon.btn-update-status { background-color: var(--primary-color); color: white; border-color: var(--primary-color);}
        .btn-action-icon.btn-update-status:hover { background-color: #005cbf; border-color: #0056b3;}
        .btn-action-icon.btn-schedule { background-color: var(--secondary-color); color: white; border-color: var(--secondary-color); }
        .btn-action-icon.btn-schedule:hover { background-color: #d3680c; border-color: #bd5e0b; }
        .btn-action-icon.btn-schedule.active-schedule {
             background-color: var(--warning-color);
             border-color: var(--warning-color);
             color: var(--dark-color);
        }


        .action-btns .form-check.form-switch {
            min-height:auto;
            padding-left: 2.8em;
            margin-bottom:0;
            display: flex;
            align-items: center;
        }
        .action-btns .form-check-input {
            width: 2.2em;
            height: 1.2em;
            margin-top: 0.1em;
        }


        .modal-content { border:none; border-radius:10px; overflow:hidden; }
        .modal-header { background-color:var(--primary-color); color:white; padding:15px 20px; }
        .modal-header .btn-close { filter:brightness(0) invert(1); } .modal-title { font-weight:600; } .modal-body { padding:20px; }
        .pagination-controls {
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 0;
            margin-top:20px;
            border-top:1px solid var(--border-color);
            flex-wrap:wrap;
            flex-shrink: 0;
        }
        .pagination-controls .page-item.disabled .page-link { color:#6c757d; pointer-events:none; background-color:#fff; border-color:#dee2e6; }
        .pagination-controls .page-item.active .page-link { z-index:3; color:#fff; background-color:var(--primary-color); border-color:var(--primary-color); }
        .pagination-controls .page-link { color:var(--primary-color); } .pagination-controls .page-link:hover { color:#0a58ca; }
        .rows-per-page-select { width:auto; display:inline-block; margin-left:10px; }
        .pagination-info { font-size:0.9rem; color:var(--gray-color); margin-bottom:10px; } .pagination-nav { margin-bottom:10px; }
        .th-filterable { position:relative; } .th-content-wrapper { display:flex; align-items:center; justify-content:space-between; }
        .th-filter-icon { margin-left:8px; color:rgba(255,255,255,0.7); cursor:pointer; font-size:0.9em; } .th-filter-icon:hover, .th-filter-icon.active { color:white; }
        .th-filter-dropdown { display:none; position:absolute; top:100%; left:0; z-index:1050; min-width:250px; background-color:#fff; border:1px solid var(--border-color); border-radius:4px; box-shadow:var(--shadow-md); color:var(--dark-color); font-weight:normal; font-size:14px; text-align:left; white-space:normal; }
        .th-filter-dropdown .filter-search { padding:8px 10px; border-bottom:1px solid #eee; }
        .th-filter-dropdown .filter-search input[type="text"] { width:100%; padding:8px 10px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box; font-size:13px; }
        .th-filter-dropdown .options-container { max-height:180px; overflow-y:auto; border:1px solid #ccc; margin:10px; border-radius:4px; position:relative; }
        .th-filter-dropdown .options-list { list-style:none; padding:0; margin:0; }
        .th-filter-dropdown .options-list li { padding:6px 10px; display:flex; align-items:center; cursor:pointer; white-space:normal; } .th-filter-dropdown .options-list li:hover { background-color:#f0f0f0; }
        .th-filter-dropdown .options-list input[type="checkbox"] { margin-right:8px; cursor:pointer; width:14px; height:14px; }
        .th-filter-dropdown .options-list label { font-size:13px; color:#333; flex-grow:1; cursor:pointer; margin-bottom:0; font-weight:normal; }
        .th-filter-dropdown .filter-actions { padding:8px 10px; display:flex; justify-content:space-between; border-top:1px solid #eee; background-color:#f9f9f9; border-radius:0 0 4px 4px; }
        .unit-hierarchy-filter-dropdown select { width:100%; padding:8px 30px 8px 12px; font-size:0.9em; border:1px solid #e2e8f0; border-radius:4px; background-color:#f8f9fa; color:#495057; cursor:pointer; appearance:none;-webkit-appearance:none;-moz-appearance:none; background-image:url('data:image/svg+xml;utf8,<svg fill="%236c757d" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); background-repeat:no-repeat; background-position:right 8px center; background-size:18px; }
        .unit-hierarchy-filter-dropdown select:disabled { background-color:#e9ecef; opacity:0.7; cursor:not-allowed; }

        /* --- CUSTOM CATEGORY MANAGEMENT SECTION --- */
        .collapse .card-body {
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
        }
        #customCategoryList .list-group-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        #customCategoryList .badge {
            font-size: 0.7em;
            vertical-align: middle;
            margin-left: 8px;
        }
        /* --- END CUSTOM CATEGORY MANAGEMENT SECTION --- */


        /* ====== RESPONSIVE ADJUSTMENTS (MOBILE) ====== */
        @media (max-width: 768px) {
            .container-fluid {
                padding-top: 10px;
                padding-bottom: 15px;
            }
            .table-actions {
                position: sticky;
                top: 0;
                background-color: #fff;
                padding: 10px 0;
                z-index: 1020;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-left: 0;
                margin-right: 0;
                width: 100%;
                box-sizing: border-box;
                margin-bottom: 10px;
                flex-wrap: wrap;
            }

            .dashboard-section {
                 padding-top: 15px;
            }
             .table-section {
                padding-top: 10px;
            }


            .table-actions #searchInput {
                display: block !important;
                flex-basis: 100%;
                order: 1;
                margin-bottom: 10px;
            }

            .mobile-controls-wrapper {
                display: flex !important;
                order: 2;
                width: 100%;
                justify-content: space-between;
            }

            .table-actions #mobileFilterButton {
                display: flex !important;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                padding: 0.375rem 0.75rem;
                font-size: 1.2rem;
                line-height: 1;
                height: 38px;
            }
            .table-actions #mobileFilterButton .fa-filter { margin-right: 0; }
            .table-actions #mobileFilterButton .mobile-filter-text { display: none; }

            .table-actions .desktop-controls-wrapper,
            .table-actions .btn-desktop-action {
                display: none !important;
            }

            .table-responsive {
                padding-top: 5px;
                overflow: auto;
            }
            .table {
                min-width: 100%;
            }

            #fssaiTable thead { display: none; }
            #fssaiTable tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid var(--border-color);
                border-left-width: 4px;
                border-left-style: solid;
                border-left-color: var(--gray-color);
                border-radius: 8px;
                box-shadow: var(--shadow-sm);
                background-color: white;
                padding: 0;
                margin-left: 0;
                margin-right: 0;
                width: 100%;
                box-sizing: border-box;
            }
            #fssaiTable tbody tr.mobile-card-border-active { border-left-color: var(--success-color); }
            #fssaiTable tbody tr.mobile-card-border-expired { border-left-color: var(--danger-color); }
            #fssaiTable tbody tr.mobile-card-border-pending { border-left-color: var(--info-color); }
            #fssaiTable tbody tr.mobile-card-border-deactivated { border-left-color: var(--gray-color); }
            #fssaiTable tbody tr.has-draft.mobile-card-border-active,
            #fssaiTable tbody tr.has-draft {
                border-left-color: var(--warning-color) !important;
            }
            .mobile-license-card .right-details p.scheduled-info-mobile {
                font-size: 0.8rem;
                color: var(--secondary-color);
                font-weight: 500;
                margin-top: 5px;
                margin-bottom: 0;
                overflow-wrap: break-word; /* For better text wrapping */
                word-break: break-all;     /* Fallback for very long non-breaking strings */
            }
            .mobile-license-card .right-details p.scheduled-info-mobile .fa-calendar-check {
                margin-right: 5px;
            }


            #fssaiTable tbody td { display: block; width: 100%; padding: 0 !important; border: none; box-sizing: border-box;}
            .mobile-license-card {
                padding: 15px;
                color: var(--dark-color);
                width: 100%;
                box-sizing: border-box;
            }
            .mobile-license-card .card-header-mobile { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color); }
            .mobile-license-card .unit-name-mobile {
                font-size: 1.1rem;
                font-weight: bold;
                overflow-wrap: break-word;
            }
            .mobile-license-card .status-mobile .status { font-size: 0.8rem; padding: 3px 10px; }
            .mobile-license-card .card-subheader-mobile {
                font-size: 0.95rem;
                font-weight: bold;
                margin-bottom: 15px;
                overflow-wrap: break-word;
            }
            .mobile-license-card .card-body-mobile { display: flex; justify-content: space-between; margin-bottom: 15px; gap: 15px; }
            .mobile-license-card .left-details, .mobile-license-card .right-details {
                flex: 1;
                font-size: 0.85rem;
                min-width: 0;
            }
            .mobile-license-card .left-details p, .mobile-license-card .right-details p {
                margin-bottom: 8px;
                line-height: 1.4;
                color: var(--gray-color);
                overflow-wrap: break-word;
            }
            .mobile-license-card .left-details p strong, .mobile-license-card .right-details p strong { color: var(--dark-color); display: inline; margin-right: 4px; }
            .mobile-license-card .card-footer-mobile {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin-top: 15px;
                padding-bottom: 5px;
            }
            .mobile-license-card .actions-mobile {
                display: none !important;
            }

            .mobile-license-card .pdf-icon-mobile .document-preview {
                padding: 8px;
                /* min-width: 100px; */ /* Removed fixed min-width */
                width: auto;         /* Allow shrink/grow by content */
                max-width: 150px;    /* Keep a reasonable max */
                align-self: center;
            }
            .mobile-license-card .pdf-icon-mobile .document-icon { font-size: 2rem; margin-bottom: 3px; }
            .mobile-license-card .pdf-icon-mobile .document-name {
                font-size: 0.75rem;
                overflow-wrap: break-word;
            }
            .mobile-license-card .pdf-icon-mobile .file-upload {
                padding: 10px;
                font-size: 0.8rem;
                /* min-width: 100px; */ /* Removed fixed min-width */
                width: auto;         /* Allow shrink/grow by content */
                max-width: 150px;    /* Keep a reasonable max */
                align-self: center;
            }
            .mobile-license-card .pdf-icon-mobile .file-upload i { font-size: 1.5rem; margin-bottom: 3px; }

            #fssaiTable .th-filterable .th-filter-icon { display: none !important; }
            .pagination-controls { flex-direction: column; }
            .pagination-info { margin-bottom: 10px; width: 100%; text-align: center; }
            .pagination-nav { width: 100%; } .pagination { justify-content: center; }
            #fssaiTable tbody tr.has-draft .mobile-license-card { background-color: #fffde7 !important; }
            #fssaiTable tbody tr.has-draft:hover .mobile-license-card { background-color: #fffacd !important; }
            #fssaiTable tbody tr.row-deactivated .mobile-license-card { background-color: #f8f9fa; opacity: 0.75; }
            #fssaiTable tbody tr.row-deactivated .mobile-license-card .status-mobile .status { opacity: 1; }

            /* Adjust dashboard cards for very narrow screens */
            @media (max-width: 320px) {
                .cards-container {
                    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Reduced min width */
                }
            }
        }

        @media (min-width: 769px) {
            .btn-desktop-action {
                display: inline-block;
            }
            .mobile-controls-wrapper {
                display: none !important;
            }
        }


#fssaiTable thead {
    background: var(--primary-color);
    padding: 10px !important;
    height: 50px;
}

 .tabs-nav-main { /* Renamed */
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            background-color: #e9ecef;
            border-bottom: 1px solid #dee2e6;
        }

        .tabs-nav-main li {
            flex-grow: 1;
        }

        .tabs-nav-main li button {
            width: 100%;
            padding: 15px 10px;
            border: none;
            background-color: transparent;
            color: #495057;
            cursor: pointer;
            font-size: 0.9em;
            text-align: center;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-bottom: 3px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tabs-nav-main li button i {
            margin-right: 8px;
        }

        .tabs-nav-main li button:hover {
            background-color: #dee2e6;
            color: #212529;
        }

        .tabs-nav-main li button.active {
            background-color: #fff;
            color: #007bff;
            font-weight: bold;
            border-bottom-color: #007bff;
        }

        .tabs-nav-main li button#tab-dashboard.active {
            background-color: transparent;
            color: #495057;
            font-weight: bold;
            border-bottom-color: #ffc107;
        }
        .tabs-nav-main li button#tab-dashboard.active:hover {
            background-color: #dee2e6;
        }

        .tabs-nav-main li button:focus {
            outline: 2px solid #007bff;
            outline-offset: -2px;
        }

        .tabs-content-main { /* Renamed */
            padding: 0; /* Remove padding to allow FSSAI container to manage its own */
        }

        .tab-panel-main { /* Renamed */
            display: none;
            animation: fadeInMain 0.5s ease-in-out;
            /* Padding will be handled by content within, esp. for FSSAI */
        }
        /* Ensure FSSAI panel takes full width and applies its styles */
        #panel-license {
            padding: 0; /* Reset padding here */
        }


        .tab-panel-main.active {
            display: block;
        }

        /* Generic content panel styling for non-FSSAI tabs */
        .tab-panel-main:not(#panel-license) {
            padding: 20px;
        }
        .tab-panel-main:not(#panel-license) h2 {
            margin-top: 0;
            color: #333;
            display: flex;
            align-items: center;
        }
        .tab-panel-main:not(#panel-license) h2 i {
            margin-right: 8px;
            color: #007bff;
        }


        @keyframes fadeInMain {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .tabs-nav-main {
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            .tabs-nav-main li {
                flex-grow: 0;
                flex-shrink: 0;
            }
            .tabs-nav-main li button {
                padding: 12px 15px;
            }
        }

        /* ================================= */
        /* ===== FSSAI EMBEDDED CSS ====== */
        /* ================================= */
        #panel-license .fssai-content-wrapper { /* Wrapper to contain FSSAI styles */
            /*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa; /* This might be overridden by tab container */
            /*color: #495057;
            line-height: 1.6;
            padding-top: 20px; /* Let FSSAI container handle this */
        }

        @media (min-width: 1200px) { .cards-container { grid-template-columns: repeat(4, 1fr); } }
        @media (min-width: 992px) and (max-width: 1199.98px) { .cards-container { grid-template-columns: repeat(2, 1fr); } }
    </style>
    
    
@section('content')
 

              <div class="container-fluid">
        <!-- Tab Navigations -->
        <ul class="tabs-nav-main" role="tablist">
            <li>
                <button role="tab" aria-selected="true" aria-controls="panel-dashboard" id="tab-dashboard" >
                                        <a   href="{{route('linces')}}" >

                    <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </button>
            </li>
            <li>
                <button role="tab" aria-selected="false" aria-controls="panel-license" id="tab-license" class="active">
                    <a     href="{{route('fssailinces')}}" >
                    <i class="fas fa-id-card"></i>License
                    </a>
                </button>
            </li>
            <li>
                <button role="tab" aria-selected="false" aria-controls="panel-medical" id="tab-medical" >
                                        <a   href="{{route('medical')}}" >

                    <i class="fas fa-briefcase-medical"></i>Medical
                    </a>
                </button>
            </li>
            <li>
                <button role="tab" aria-selected="false" aria-controls="panel-testing" id="tab-testing">
                                        <a   href="{{route('food')}}" >

                    <i class="fas fa-vial"></i>Food
                    </a>
                </button>
            </li>
            <li>
                <button role="tab" aria-selected="false" aria-controls="panel-fostac" id="tab-fostac">
                    <a   href="{{route('fostac')}}" >

                    <i class="fas fa-award"></i>FoSTaC

</a>
                </button>
            </li>
        </ul>
 <div class="main-content">

        <!-- CUSTOM CATEGORY MANAGEMENT - START -->
        <div class="my-3">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#categoryManagementSection" aria-expanded="false" aria-controls="categoryManagementSection">
                <i class="fas fa-cogs me-2"></i>Manage Categories 
            </button>
        </div>
        <div class="collapse mb-4" id="categoryManagementSection">
            <div class="card card-body">
                
                           <form method="post" action="{{route('License_catageory')}}" id="customCategoryForm">
                    @csrf
                    
                <h4 class="mb-3">Add New Custom Category</h4>
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="newCustomCategoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="cat_name" class="form-control form-control-sm" id="newCustomCategoryName" placeholder="e.g., Water Testing Certificate">
                    </div>
                    <div class="col-md-3" id="customCategoryScopeWrapper">
                        {/* Scope selection will be dynamically populated */}
                    </div>
                    <div class="col-md-auto">
                        <button class="btn btn-sm btn-primary" onclick="addNewCustomCategory()"><i class="fas fa-plus me-1"></i>Add Category</button>
                    </div>
                </div>
                <hr>
                <h5>Existing Custom Categories (<span id="customCategoryListScope">Current Scope</span>)</h5>
                <ul id="customCategoryList11" class="list-group list-group-flush">
                    @foreach($License_catageory as $License_catageorys)
             
                    
                    <li class="list-group-item d-flex justify-content-between align-items-center">{{$License_catageorys->name ?? ''}} <span class="badge bg-primary rounded-pill">Global</span> <a class="btn btn-sm btn-outline-danger py-0 px-1" href="{{route('License_catageory_delete',$License_catageorys->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-times"></i></a></li>
                    
                    
                      @endforeach
                </ul>
                
                     </form>
            </div>
        </div>
        <!-- CUSTOM CATEGORY MANAGEMENT - END -->


        <div class="table-actions">
            
            
            @if (Auth::user()->is_role == 3)
    <button class="btn btn-primary btn-desktop-action" onclick="addNewLicense()">
        <i class="fas fa-plus me-2"></i>Add New
    </button>
@endif

            
            
            <button id="submitDraftsButton" class="btn btn-success btn-desktop-action" title="Apply all saved drafts" disabled><i class="fas fa-check-double me-2"></i>Submit Drafts (<span id="draftCount">0</span>)</button>
            <button id="exportButton" class="btn btn-outline-primary btn-desktop-action" onclick="exportTableToCSV('fssai_licenses.csv')"><i class="fas fa-download me-2"></i>Export</button>
            <button id="refreshTableButton" class="btn btn-outline-secondary btn-desktop-action" title="Refresh Table Data & Clear Filters"><i class="fas fa-sync-alt me-2"></i>Refresh</button>

            <input type="text" id="searchInput" class="form-control" placeholder="Global Search...">

            <div class="mobile-controls-wrapper">
                <div class="show-select-wrapper-mobile d-flex align-items-center">
                    <span class="me-1 text-muted small">Show:</span>
                    <select id="rowsPerPageSelectMobile" class="form-select form-select-sm rows-per-page-select">
                        <option value="5">5</option><option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                    </select>
                </div>
                <button id="mobileFilterButton" class="btn btn-info" onclick="openMobileFilterModal()"><i class="fas fa-filter"></i><span class="mobile-filter-text">Filters</span></button>
            </div>

            <div class="desktop-controls-wrapper">
                <div class="show-select-wrapper d-flex align-items-center me-md-3 mb-2 mb-md-0">
                    <span class="me-2 text-muted small">Show:</span>
                    <select id="rowsPerPageSelectDesktop" class="form-select form-select-sm rows-per-page-select">
                        <option value="5">5</option><option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <section class="dashboard-section">
            <h2 class="h5 mb-3 text-muted">Compliance Overview (<span id="dashboardScopeInfo">All Data</span>)</h2>
            <div class="cards-container">
                <div id="card-license" class="dashboard-card dashboard-card-green"><h3 class="card-title">FSSAI License</h3><div class="card-status-row"><span id="card-license-status" class="status-badge">N/A</span><span id="card-license-due" class="due-date">Next Due: N/A</span></div><div class="progress-container"><div class="progress-bar"><div id="card-license-progress" class="progress-fill" style="width:0%"></div></div></div><div class="card-info-row"><span id="card-license-info" class="validity-text">No Data</span></div></div>
                <div id="card-hra" class="dashboard-card dashboard-card-orange"><h3 class="card-title">Hygiene Rating Audit</h3><div class="card-status-row"><span id="card-hra-status" class="status-badge">N/A</span><span id="card-hra-due" class="due-date">Next Due: N/A</span></div><div class="progress-container"><div class="progress-bar"><div id="card-hra-progress" class="progress-fill" style="width:0%"></div></div></div><div class="card-info-row"><span id="card-hra-info" class="validity-text">No Data</span></div></div>
                <div id="card-tpa" class="dashboard-card dashboard-card-blue"><h3 class="card-title">Third Party Audit</h3><div class="card-status-row"><span id="card-tpa-status" class="status-badge">N/A</span><span id="card-tpa-due" class="due-date">Next Due: N/A</span></div><div class="progress-container"><div class="progress-bar"><div id="card-tpa-progress" class="progress-fill" style="width:0%"></div></div></div><div class="card-info-row"><span id="card-tpa-info" class="validity-text">No Data</span></div></div>
                <!--<div id="card-others" class="dashboard-card dashboard-card-gray"><h3 class="card-title">Others</h3><div class="card-status-row"><span id="card-others-status" class="status-badge">N/A</span><span id="card-others-due" class="due-date">Next Due: N/A</span></div><div class="progress-container"><div class="progress-bar"><div id="card-others-progress" class="progress-fill" style="width:0%"></div></div></div><div class="card-info-row"><span id="card-others-info" class="validity-text">No Data</span></div></div>-->
            </div>
        </section>

        <section class="table-section">
            <h2 class="h5 mb-3 text-muted">License Management</h2>
            <div class="table-responsive">
                <table class="table table-hover" id="fssaiTable">
                     <thead>
                        <tr>
                            <th>SL No</th>
                            <th class="th-filterable" data-column-key="unitName"><div class="th-content-wrapper"><span>Unit Hierarchy</span><i class="fas fa-filter th-filter-icon" data-column-key="unitName"></i></div><div class="th-filter-dropdown unit-hierarchy-filter-dropdown" data-column-key="unitName"><div class="hierarchical-filter-content"><div class="filter-group"><label for="unit-filter-corporate-select">Corporate:</label><div class="select-wrapper corporate-wrapper"><select id="unit-filter-corporate-select" name="corporate"><option value="" selected>-- All --</option></select></div></div><div class="filter-group"><label for="unit-filter-regional-select">Regional:</label><div class="select-wrapper"><select id="unit-filter-regional-select" name="regional"><option value="" selected>-- All --</option></select></div></div><div class="filter-group"><label for="unit-filter-unit-select">Unit:</label><div class="select-wrapper"><select id="unit-filter-unit-select" name="unit"><option value="" selected>-- All --</option></select></div></div><div class="button-group filter-actions"><button type="button" class="btn btn-sm btn-apply unit-filter-apply">Apply</button><button type="button" class="btn btn-sm btn-clear unit-filter-clear">Clear</button></div></div></div></th>
                            <th class="th-filterable" data-column-key="category"><div class="th-content-wrapper"><span>Category</span><i class="fas fa-filter th-filter-icon" data-column-key="category"></i></div><div class="th-filter-dropdown" data-column-key="category"><div class="filter-search"><input type="text" placeholder="Search Categories..."></div><div class="options-container"><ul class="options-list"></ul></div><div class="filter-actions"><button class="btn btn-sm btn-apply">Apply</button><button class="btn btn-sm btn-clear">Clear</button></div></div></th>
                            <th class="th-filterable" data-column-key="licenseNo"><div class="th-content-wrapper"><span>License Number</span><i class="fas fa-filter th-filter-icon" data-column-key="licenseNo"></i></div><div class="th-filter-dropdown" data-column-key="licenseNo"><div class="filter-content-padding"><div class="mb-2"><label for="licenseNoSearchInput" class="form-label small fw-semibold">Search:</label><input type="text" id="licenseNoSearchInput" class="form-control form-control-sm" placeholder="Enter License No..."></div></div><div class="filter-actions"><button type="button" class="btn btn-sm btn-apply licenseNo-filter-apply">Apply</button><button type="button" class="btn btn-sm btn-clear licenseNo-filter-clear">Clear</button></div></div></th>
                            <th class="th-filterable" data-column-key="expiryDate"><div class="th-content-wrapper"><span>Expiry Date</span><i class="fas fa-filter th-filter-icon" data-column-key="expiryDate"></i></div><div class="th-filter-dropdown" data-column-key="expiryDate"><div class="filter-content-padding"><div class="date-range-filter mb-2"><div class="mb-2"><label for="expiryDateFromInput" class="form-label small fw-semibold">From:</label><input type="date" id="expiryDateFromInput" class="form-control form-control-sm"></div><div><label for="expiryDateToInput" class="form-label small fw-semibold">To:</label><input type="date" id="expiryDateToInput" class="form-control form-control-sm"></div></div></div><div class="filter-actions"><button type="button" class="btn btn-sm btn-apply expiryDate-filter-apply">Apply</button><button type="button" class="btn btn-sm btn-clear expiryDate-filter-clear">Clear</button></div></div></th>
                            <th class="th-filterable" data-column-key="licenseType"><div class="th-content-wrapper"><span>License Type</span><i class="fas fa-filter th-filter-icon" data-column-key="licenseType"></i></div><div class="th-filter-dropdown" data-column-key="licenseType"><div class="filter-search"><input type="text" placeholder="Search License Types..."></div><div class="options-container"><ul class="options-list"></ul></div><div class="filter-actions"><button class="btn btn-sm btn-apply">Apply</button><button class="btn btn-sm btn-clear">Clear</button></div></div></th>
                            <th>License Copy</th>
                            <th class="th-filterable" data-column-key="status"><div class="th-content-wrapper"><span>Status</span><i class="fas fa-filter th-filter-icon" data-column-key="status"></i></div><div class="th-filter-dropdown" data-column-key="status"><div class="filter-search"><input type="text" placeholder="Search Statuses..."></div><div class="options-container"><ul class="options-list"></ul></div><div class="filter-actions"><button class="btn btn-sm btn-apply">Apply</button><button class="btn btn-sm btn-clear">Clear</button></div></div></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="fssaiTableBody"></tbody>
                </table>
            </div>
            <div class="pagination-controls">
                 <div class="pagination-info">Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalEntries">0</span> entries</div>
                <nav class="pagination-nav" aria-label="Table navigation"><ul class="pagination pagination-sm mb-0" id="paginationUl"></ul></nav>
            </div>
        </section>
    </div>

    <!-- Modals -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="documentModalLabel">Document Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="documentPreview">
        <!-- Dynamic content will appear here -->
      </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="renewModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Renew / Update License</h5><button type="button" class="btn-close btn-light" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="renewLicenseNumber"><div class="mb-3"><label class="form-label">Unit Name</label><p id="renewUnitName" class="form-control bg-light"></p></div><div class="mb-3"><label class="form-label">Corporate</label><p id="renewCorporateName" class="form-control bg-light"></p></div><div class="mb-3"><label class="form-label">Regional</label><p id="renewRegionalName" class="form-control bg-light"></p></div><div class="mb-3"><label class="form-label">Category</label><p id="renewCategory" class="form-control bg-light"></p></div><div class="mb-3 d-none" id="renewOtherCategoryNameWrapper"><label for="renewOtherCategoryName" class="form-label">Other Category Detail</label><input type="text" id="renewOtherCategoryName" class="form-control"></div><div class="mb-3"><label class="form-label">Current License No</label><p id="displayLicenseNumber" class="form-control bg-light"></p></div><div class="mb-3"><label class="form-label">Current Expiry Date</label><p id="currentExpiryDate" class="form-control bg-light"></p></div><div class="mb-3"><label for="newExpiryDate" class="form-label">New Expiry Date</label><input type="date" id="newExpiryDate" class="form-control" required></div><div class="mb-3"><label class="form-label">Upload New Doc (Opt)</label><label class="file-upload"><i class="fas fa-cloud-upload-alt me-1"></i>Choose File<input type="file" id="renewalDocument"></label><span id="renewalFileName" class="uploaded-file"><i class="fas fa-file-alt"></i>No file selected</span></div></div><div class="modal-footer"><button type="button" class="btn btn-warning w-100" onclick="saveDraftUpdate()"><i class="fas fa-save me-2"></i>Save as Draft</button></div></div></div></div>
    <div class="modal fade" id="historyModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">License History Log</h5><button type="button" class="btn-close btn-light" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="row mb-3"><div class="col-md-6">Unit: <strong id="historyUnitName"></strong></div><div class="col-md-6">License No: <strong id="historyLicenseNumber"></strong></div><div class="col-md-6">Corporate: <strong id="historyCorporateName"></strong></div><div class="col-md-6">Regional: <strong id="historyRegionalName"></strong></div></div><div class="table-responsive"><table class="table table-sm table-striped"><thead><tr><th>Date</th><th>Action</th><th>Details</th><th>User</th></tr></thead><tbody id="historyTableBody"></tbody></table></div></div></div></div></div>

    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Renew/Update</h5>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="scheduleLicenseNumber">
                    <div class="mb-3">
                        <label class="form-label">Unit Name:</label>
                        <p id="scheduleUnitName" class="form-control-plaintext ps-0 fw-bold"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">License No:</label>
                        <p id="scheduleDisplayLicenseNumber" class="form-control-plaintext ps-0"></p>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Current Expiry:</label>
                        <p id="scheduleCurrentExpiry" class="form-control-plaintext ps-0"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="scheduleDate" class="form-label">Schedule Date <span class="text-danger">*</span></label>
                            <input type="date" id="scheduleDate" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="scheduleTime" class="form-label">Schedule Time</label>
                            <input type="time" id="scheduleTime" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="scheduleComments" class="form-label">Comments/Notes</label>
                        <textarea id="scheduleComments" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveScheduledUpdate()">Save Schedule</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mobileFilterModal" tabindex="-1"><div class="modal-dialog modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="mobileFilterModalLabel">Apply Filters</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3 border p-2 rounded"><h6 class="mb-2">Unit Hierarchy</h6><div class="filter-group mb-2"><label for="mobile-unit-filter-corporate-select" class="form-label small">Corporate:</label><select id="mobile-unit-filter-corporate-select" class="form-select form-select-sm" name="corporate"><option value="" selected>-- All --</option></select></div><div class="filter-group mb-2"><label for="mobile-unit-filter-regional-select" class="form-label small">Regional:</label><select id="mobile-unit-filter-regional-select" class="form-select form-select-sm" name="regional"><option value="" selected>-- All --</option></select></div><div class="filter-group"><label for="mobile-unit-filter-unit-select" class="form-label small">Unit:</label><select id="mobile-unit-filter-unit-select" class="form-select form-select-sm" name="unit"><option value="" selected>-- All --</option></select></div></div><div class="mb-3 border p-2 rounded"><h6 class="mb-2">Category</h6><input type="text" id="mobile-category-search" class="form-control form-control-sm mb-2" placeholder="Search Categories..."><div id="mobile-category-options" class="options-container" style="max-height:150px;overflow-y:auto;border:1px solid #ccc;padding:5px"></div></div><div class="mb-3 border p-2 rounded"><h6 class="mb-2">License Type</h6><input type="text" id="mobile-licensetype-search" class="form-control form-control-sm mb-2" placeholder="Search License Types..."><div id="mobile-licensetype-options" class="options-container" style="max-height:150px;overflow-y:auto;border:1px solid #ccc;padding:5px"></div></div><div class="mb-3 border p-2 rounded"><h6 class="mb-2">Status</h6><input type="text" id="mobile-status-search" class="form-control form-control-sm mb-2" placeholder="Search Statuses..."><div id="mobile-status-options" class="options-container" style="max-height:150px;overflow-y:auto;border:1px solid #ccc;padding:5px"></div></div><div class="mb-3 border p-2 rounded"><h6 class="mb-2">License Number</h6><input type="text" id="mobile-licenseNoSearchInput" class="form-control form-control-sm" placeholder="Enter License No..."></div><div class="mb-3 border p-2 rounded"><h6 class="mb-2">Expiry Date Range</h6><div class="mb-2"><label for="mobile-expiryDateFromInput" class="form-label small">From:</label><input type="date" id="mobile-expiryDateFromInput" class="form-control form-control-sm"></div><div><label for="mobile-expiryDateToInput" class="form-label small">To:</label><input type="date" id="mobile-expiryDateToInput" class="form-control form-control-sm"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-outline-secondary" onclick="clearMobileFilters()">Clear All</button><button type="button" class="btn btn-primary" onclick="applyMobileFilters()">Apply Filters</button></div></div></div></div>              
          <div id="ingredients-block"></div>          
</div>  
@endsection



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- START: IDENTIFY CHANGES (Custom Categories & Schedule Feature) ---
        // This section marks the beginning of the JavaScript changes for
        // custom categories and scheduling functionality.
        // --- END: IDENTIFY CHANGES ---

const DATA_KEYS = ['slNo', 'unitName', 'category', 'licenseNo', 'expiryDate', 'licenseType', 'licenseCopy', 'status', 'actions'];
    const ALL_OPTION_VALUE = "";
    let currentUser = {
        role: 'Super Admin',
        corporateName: null,
        regionalName: null,
        unitName: null
    };
    let accessibleLicenseData = [];

     let allLicenseData = [
        @foreach($result as $index => $results)
        @php 
        $unitDetails = DB::table('users')->where('id',$results->created_by)->first();
        $unitDetails2 = DB::table('users')->where('id',$unitDetails->created_by1)->first();
        $unitDetails3 = DB::table('users')->where('id',$unitDetails->created_by)->first();
        
        $CorporateName = Helper::CorporateName($unitDetails->created_by);
        @endphp
        {
            slNo: {{ $index + 1 }},
            unitName: '{{ $unitDetails->company_name }}',
            corporate: '{{$unitDetails3->company_name ?? ''}}',
            regional: '{{$unitDetails2->company_name ?? ''}}',
            category: '{{ $results->cat_type ?? '' }}',
            otherCategoryName: '{{ $results->otherCategoryName ?? '' }}',
            licenseNo: '{{ $results->lincess_number ?? '' }}',
            expiryDate: '{{ $results->due_date ?? '' }}',
            licenseType: '{{ $results->document_type ?? '' }}',
            licenseCopy: '{{ asset('documents/' . ($results->image ?? '')) }}',
            status: '{{ $results->deactivate_status ?? '' }}',
            isActive: {{ $results->isActive ?? '' }}
        }@if(!$loop->last),@endif
        @endforeach
    ];

    let filteredLicenseData = [];
    let draftUpdates = [];
        // --- START: IDENTIFY CHANGES (New Global Variables) ---
        let scheduledUpdates = [];
        let customCategoriesData = []; // This will be populated if you fetch custom categories from a backend
       
        const BASE_CATEGORIES = ['License', 'HRA', 'TPA', 'Others'];

            // --- END: IDENTIFY CHANGES ---

        let currentPage=1;let rowsPerPage=10;let activeFilters={selectedCorporate:null,selectedRegional:null,selectedUnit:null,licenseNoSearch:null,expiryDateFrom:null,expiryDateTo:null};let currentlyOpenFilterDropdown=null;var tooltipTriggerList,tooltipList,documentModal,renewModal,historyModal,scheduleModalInstance, mobileFilterModalInstance;

        const rowsPerPageSelectDesktopEl = document.getElementById('rowsPerPageSelectDesktop');
        const rowsPerPageSelectMobileEl = document.getElementById('rowsPerPageSelectMobile');

        function setCurrentUser(role,corporate=null,regional=null,unit=null){currentUser.role=role;currentUser.corporateName=corporate;currentUser.regionalName=regional;currentUser.unitName=unit;const sI=document.getElementById('dashboardScopeInfo');if(sI){if(role==='Super Admin')sI.textContent='All Data';else if(role==='Corporate')sI.textContent=`Corporate: ${corporate}`;else if(role==='Regional')sI.textContent=`Regional: ${regional} (${corporate})`;else if(role==='Unit')sI.textContent=`Unit: ${unit}`;}initializeUserScope();}
        function filterDataForCurrentUser(){if(!allLicenseData)return[];if(currentUser.role==='Super Admin')return[...allLicenseData];return allLicenseData.filter(i=>{if(currentUser.role==='Corporate')return i.corporate===currentUser.corporateName;if(currentUser.role==='Regional')return i.corporate===currentUser.corporateName&&i.regional===currentUser.regionalName;if(currentUser.role==='Unit')return i.corporate===currentUser.corporateName&&i.regional===currentUser.regionalName&&i.unitName===currentUser.unitName;return false;});}

        // --- START: IDENTIFY CHANGES (Modified initializeUserScope) ---
        function initializeUserScope(){
            accessibleLicenseData=filterDataForCurrentUser();
            resetAllFiltersInternal();

            populateCustomCategoryScopeSelector();
            displayCustomCategories(); // Ensure custom categories are displayed based on scope

            applyAllFilters();
            const m=calculateDashboardMetrics(accessibleLicenseData);
            updateDashboardCards(m);
            updateHierarchicalFilterOptionsBasedOnUserScope();
            updateGeneralFilterOptionsBasedOnUserScope();
            populateMobileFilterOptions();
            updateDraftCount();

            const aNB=document.getElementById('addNewButton');
            if(aNB){
                const iM=isMobileView();
                 // --- MODIFICATION: Allow 'Add New' for Super Admin and Corporate as well on desktop
                if((currentUser.role==='Unit' || currentUser.role === 'Super Admin' || currentUser.role === 'Corporate') && !iM){
                    aNB.style.display='inline-block';
                    aNB.disabled=false;
                } else {
                    aNB.style.display='none';
                }
            }
            if (rowsPerPageSelectDesktopEl) rowsPerPageSelectDesktopEl.value = rowsPerPage;
            if (rowsPerPageSelectMobileEl) rowsPerPageSelectMobileEl.value = rowsPerPage;
        }
        // --- END: IDENTIFY CHANGES ---

        function applyUserRoleSelection(){const sel=document.getElementById('roleSelector'),sV=sel.value,p=sV.split('_');setCurrentUser(p[0],p[1]||null,p[2]||null,p[3]||null);addHistoryEntry('SYSTEM','Role Change',`Simulated role to ${p[0]} ${p[1]?'('+p[1]+')':''}`,'User');}
        function getFileIconClass(fName){if(!fName)return'fa-file';const ext=fName.split('.').pop().toLowerCase();if(['pdf'].includes(ext))return'fa-file-pdf document-icon';if(['jpg','jpeg','png','gif','bmp'].includes(ext))return'fa-file-image document-icon';if(['doc','docx'].includes(ext))return'fa-file-word document-icon';if(['xls','xlsx'].includes(ext))return'fa-file-excel document-icon';return'fa-file document-icon';}
        function downloadDocument(){const frm=document.getElementById('documentFrame'),eMD=document.getElementById('docErrorMsg'),fS=frm.getAttribute('src');if(eMD.classList.contains('d-none')===false||!fS||fS==='about:blank'){alert("Preview failed.");return;}const fN=frm.getAttribute('data-filename')||fS.split('/').pop(),lnk=document.createElement('a');lnk.href=fS;lnk.download=fN;document.body.appendChild(lnk);lnk.click();document.body.removeChild(lnk);}
        function handleLicenseUpload(licNo,input){const f=input.files[0];if(!f)return;const dIdx=findDataIndexByLicenseNo(licNo);if(dIdx===-1)return;allLicenseData[dIdx].licenseCopy=f.name;initializeUserScope();addHistoryEntry(licNo,'Document Upload',`Uploaded: ${f.name}`,'User');}
        function handleNewLicenseUpload(input){const f=input.files[0],uFS=input.closest('td, .pdf-icon-mobile').querySelector('.uploaded-file');if(f){uFS.innerHTML=`<i class="fas ${getFileIconClass(f.name)}"></i> ${f.name}`;input.dataset.uploadedFileName=f.name;}else{uFS.innerHTML='';delete input.dataset.uploadedFileName;}}
        function toggleOtherNameInput(selEl,wId=null,iId=null){let oNW,oNI;if(wId&&iId){oNW=document.getElementById(wId);oNI=document.getElementById(iId);}else{const r=selEl.closest('tr');if(!r)return;oNW=r.querySelector('.other-category-name-input-wrapper');if(oNW)oNI=oNW.querySelector('input[name="otherCategoryName"]');}if(oNW&&oNI){oNW.classList.toggle('d-none',selEl.value!=='Others');if(selEl.value!=='Others')oNI.value='';}}
        function handleCategoryChange(catSel){const r=catSel.closest('tr'),lTSel=r.querySelector('select[name="licenseType"]');if(!lTSel)return;lTSel.disabled=catSel.value!=='License';if(catSel.value!=='License')lTSel.value='NA';else if(lTSel.value==='NA'){const fNNAO=Array.from(lTSel.options).find(o=>o.value!=='NA');if(fNNAO)lTSel.value=fNNAO.value;else lTSel.value='';}if(r.classList.contains('editable-row'))toggleOtherNameInput(catSel);}
        function openRenewModal(licNo){const dIdx=findDataIndexByLicenseNo(licNo);if(dIdx===-1){alert("Error: License not found.");return;}const oD=allLicenseData[dIdx];if(!oD.isActive){alert("License is deactivated. Cannot renew/update.");return;}const eD=draftUpdates.find(d=>d.licenseNo===licNo);document.getElementById('renewLicenseNumber').value=oD.licenseNo;document.getElementById('renewUnitName').textContent=oD.unitName;document.getElementById('renewCorporateName').textContent=oD.corporate||'N/A';document.getElementById('renewRegionalName').textContent=oD.regional||'N/A';document.getElementById('displayLicenseNumber').textContent=oD.licenseNo;document.getElementById('currentExpiryDate').textContent=oD.expiryDate||'N/A';document.getElementById('newExpiryDate').value=eD?eD.newExpiryDate:'';document.getElementById('renewCategory').textContent=oD.category||'N/A';const rOCNW=document.getElementById('renewOtherCategoryNameWrapper'),rOCNI=document.getElementById('renewOtherCategoryName');if(oD.category==='Others'){rOCNW.classList.remove('d-none');rOCNI.value=(eD&&typeof eD.otherCategoryName!=='undefined')?(eD.otherCategoryName||''):(oD.otherCategoryName||'');}else{rOCNW.classList.add('d-none');rOCNI.value='';}document.getElementById('renewalDocument').value=null;document.getElementById('renewalFileName').innerHTML=(eD&&eD.newDocumentName)?`<i class="fas ${getFileIconClass(eD.newDocumentName)}"></i> ${eD.newDocumentName}`:'<i class="fas fa-file-alt"></i> No new file';if(renewModal)renewModal.show();}

function viewDocument(filename) {
   

    const modalElement = document.getElementById('documentModal');
    const previewContainer = document.getElementById('documentPreview');

    if (!previewContainer) {
        console.error("Element with id 'documentPreview' not found.");
        return;
    }

    const filePath = `${filename}`;
    const fileExtension = filename.split('.').pop().toLowerCase();

    // Clear previous content
    previewContainer.innerHTML = '';

    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
        const img = document.createElement('img');
        img.src = filePath;
        img.alt = filename;
        img.classList.add('img-fluid');
        previewContainer.appendChild(img);
    } else if (fileExtension === 'pdf') {
        const iframe = document.createElement('iframe');
        iframe.src = filePath;
        iframe.width = '100%';
        iframe.height = '600px';
        iframe.frameBorder = '0';
        previewContainer.appendChild(iframe);
    } else {
        previewContainer.innerHTML = `<div class="alert alert-warning">Cannot preview this file type.</div>`;
    }

    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}



        function openScheduleModal(licenseNo) {
            const dataIndex = findDataIndexByLicenseNo(licenseNo);
            if (dataIndex === -1) {
                alert("Error: License not found.");
                return;
            }
            const originalData = allLicenseData[dataIndex];
             if (!originalData.isActive) {
                alert("License is deactivated. Cannot schedule update.");
                return;
            }

            const existingSchedule = scheduledUpdates.find(s => s.licenseNo === licenseNo);

            document.getElementById('scheduleLicenseNumber').value = originalData.licenseNo;
            document.getElementById('scheduleUnitName').textContent = originalData.unitName || 'N/A';
            document.getElementById('scheduleDisplayLicenseNumber').textContent = originalData.licenseNo || 'N/A';
            document.getElementById('scheduleCurrentExpiry').textContent = originalData.expiryDate || 'N/A';

            if (existingSchedule) {
                document.getElementById('scheduleDate').value = existingSchedule.scheduledDate || '';
                document.getElementById('scheduleTime').value = existingSchedule.scheduledTime || '';
                document.getElementById('scheduleComments').value = existingSchedule.scheduledComments || '';
            } else {
                document.getElementById('scheduleDate').value = '';
                document.getElementById('scheduleTime').value = '';
                document.getElementById('scheduleComments').value = '';
            }
            if(scheduleModalInstance) scheduleModalInstance.show();
        }

        function saveScheduledUpdate() {
            const licenseNo = document.getElementById('scheduleLicenseNumber').value;
            const scheduledDate = document.getElementById('scheduleDate').value;
            const scheduledTime = document.getElementById('scheduleTime').value;
            const scheduledComments = document.getElementById('scheduleComments').value.trim();

            if (!scheduledDate) {
                alert('Please select a schedule date.');
                document.getElementById('scheduleDate').classList.add('is-invalid');
                return;
            }
            document.getElementById('scheduleDate').classList.remove('is-invalid');

            const scheduleData = {
                licenseNo: licenseNo,
                scheduledDate: scheduledDate,
                scheduledTime: scheduledTime,
                scheduledComments: scheduledComments
            };

            const existingScheduleIndex = scheduledUpdates.findIndex(s => s.licenseNo === licenseNo);
            if (existingScheduleIndex > -1) {
                scheduledUpdates[existingScheduleIndex] = scheduleData;
            } else {
                scheduledUpdates.push(scheduleData);
            }

            initializeUserScope();
            addHistoryEntry(licenseNo, 'Update Scheduled', `Scheduled for ${scheduledDate}${scheduledTime ? ' at ' + scheduledTime : ''}. Notes: ${scheduledComments || 'None'}`, 'User');
            if(scheduleModalInstance) scheduleModalInstance.hide();
            alert(`Update for license ${licenseNo} scheduled successfully.`);
        }


        const licenseHistoryData={'123456789012':[{date:'2022-01-15',action:'Issued',details:'Initial License',user:'System'},{date:'2023-11-01',action:'Doc Upload',details:'FSSAI_License_123456789012.pdf',user:'User1'}],'SOUTHBETA999':[{date:'2024-11-30',action:'Issued',details:'Initial HRA',user:'System'}],'NORTHC001234':[{date:'2023-08-15',action:'Issued',details:'Initial TPA',user:'System'}],SYSTEM:[{date:new Date().toISOString().split('T')[0],action:'System',details:'Dashboard loaded',user:'System'}],'MPA-HRA-001':[{date:new Date().toISOString().split('T')[0],action:'Issued',details:'Initial HRA MPA',user:'System'}],'MPA-OTH-001':[{date:'2024-01-10',action:'Issued',details:'Pest Audit',user:'System'}],'SWB-OTH-002':[{date:'2022-07-01',action:'Issued',details:'Water Report',user:'System'}],'WECGC888000':[{date:'2025-01-01',action:'Issued',details:'Initial License GC',user:'System'}],'WEBDHRA001':[{date:'2023-05-01',action:'Issued',details:'Initial HRA BD',user:'System'}],'STC-TPA-01':[{date:'2022-09-15',action:'Issued',details:'Initial TPA STC',user:'System'}]};
        function addHistoryEntry(licNo,action,details,user='System'){if(!licNo||!action||!details)return;if(!licenseHistoryData[licNo])licenseHistoryData[licNo]=[];licenseHistoryData[licNo].unshift({date:new Date().toISOString().split('T')[0],action,details,user});}
       
       
      function openHistoryModal(licenseNumber) {
            let url = '{{route("UnitLincesHistory")}}';
        $.ajax({
            type: "GET",
            url: url,
            data:{id:licenseNumber},
            success: function(response) {
                if(response.status == true){
                    $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
                }
                else{
                          $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
                    //alert('error','There is some problem to get ingredient!Please contact to your server administrator');
                }
            },
            error: function(data) {
                      $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
               //alert('error','There is some problem to get ingredient!Please contact to your server administrator');
            }
        });    
}
       
        //function openHistoryModal(licNo){const dIdx=findDataIndexByLicenseNo(licNo);if(dIdx===-1&&licNo!=='SYSTEM'){alert("Error: License not found.");return;}const d=licNo==='SYSTEM'?{unitName:'System Log',licenseNo:'SYSTEM',corporate:'N/A',regional:'N/A'}:allLicenseData[dIdx];document.getElementById('historyUnitName').textContent=d.unitName;document.getElementById('historyLicenseNumber').textContent=d.licenseNo;document.getElementById('historyCorporateName').textContent=d.corporate||'N/A';document.getElementById('historyRegionalName').textContent=d.regional||'N/A';const h=licenseHistoryData[licNo]||[],hTB=document.getElementById('historyTableBody');hTB.innerHTML=h.length===0?'<tr><td colspan="4" class="text-center text-muted">No history.</td></tr>':h.map(e=>`<tr><td>${e.date}</td><td>${e.action}</td><td>${e.details}</td><td>${e.user}</td></tr>`).join('');if(historyModal)historyModal.show();}
        function findDataIndexByLicenseNo(licNo){return licNo?allLicenseData.findIndex(i=>i.licenseNo===licNo):-1;}
        function getStatusBadge(sTxt,isAct=true){if(isAct===false)return`<span class="status status-deactivated">Deactivated</span>`;sTxt=sTxt||'Unknown';let s=sTxt.toLowerCase(),bCls=s==='active'?'status-active':(s==='expired'?'status-expired':'status-pending');return`<span class="status ${bCls}">${sTxt.charAt(0).toUpperCase()+sTxt.slice(1)}</span>`;}
        function updateStatusBasedOnDate(dStr,curStat='Active'){if(!dStr||dStr==='N/A'||curStat==='Pending'||!['License','HRA','TPA','Others'].includes(curStat)){if(dStr&&dStr!=='N/A'){try{const eD=new Date(dStr),t=new Date();t.setHours(0,0,0,0);if(!isNaN(eD.getTime())&&eD<t)return'Expired';}catch(e){}}return curStat;}try{const eD=new Date(dStr),t=new Date();t.setHours(0,0,0,0);return isNaN(eD.getTime())?'Unknown':(eD<t?'Expired':'Active');}catch(e){return'Unknown';}}
        function initializeStatuses(){allLicenseData.forEach(i=>{i.corporate=i.corporate||null;i.regional=i.regional||null;i.isActive=typeof i.isActive==='undefined'?true:i.isActive;if(i.category&&!['License','HRA','TPA','Others'].includes(i.category))i.licenseType='NA';if(i.category==='Others'&&typeof i.otherCategoryName==='undefined')i.otherCategoryName=null;i.status=updateStatusBasedOnDate(i.expiryDate,i.status);});}
        function generateLicenseCopyHTML(fName,licNo){if(fName)return`<div class="document-preview" onclick="viewDocument('${fName}')" title="View ${fName}"><i class="fas ${getFileIconClass(fName)}"></i><span class="document-name">${fName}</span></div>`;const dIdx=findDataIndexByLicenseNo(licNo);if(dIdx===-1||isMobileView()){return`<label class="file-upload"><i class="fas fa-cloud-upload-alt me-1"></i> Upload<input type="file" onchange="handleNewLicenseUpload(this)" accept=".pdf,.jpg,.jpeg,.png" name="licenseCopyFile"></label><span class="uploaded-file"></span>`;}const i=allLicenseData[dIdx];return(i.category&&['License','HRA','TPA','Others'].includes(i.category))?`<label class="file-upload"><i class="fas fa-cloud-upload-alt me-1"></i> Upload<input type="file" id="license-${licNo}" onchange="handleLicenseUpload('${licNo}',this)" accept=".pdf,.jpg,.jpeg,.png"></label><span id="upload-status-${licNo}" class="uploaded-file"></span>`:'<!-- NA -->';}

        function generateActionsHTML(item) {
            if (isMobileView()) {
                return '<!-- Actions hidden on mobile -->';
            }

            const licNo = item.licenseNo;
            let toggleHTML = '';
            let buttonsHTML = '';

            if (!item || typeof item.status === 'undefined' || typeof item.isActive === 'undefined') {
                return `<div class="action-buttons-wrapper"><div class="action-btns"></div></div>`;
            }

            const hasDraft = draftUpdates.some(d => d.licenseNo === licNo);
            const isScheduled = scheduledUpdates.some(s => s.licenseNo === licNo);
            const uniqueSwitchId = `toggle-${(licNo || `new-${Math.random().toString(36).substring(2, 7)}`).replace(/[^a-zA-Z0-9]/g, "")}`;

            toggleHTML = `<div class="form-check form-switch" title="${item.isActive ? 'Deactivate' : 'Activate'} License">
                            <input class="form-check-input" type="checkbox" role="switch" id="${uniqueSwitchId}" ${item.isActive ? 'checked' : ''} onchange="toggleActivation('${licNo}', this)" ${!licNo ? 'disabled' : ''}>
                            <label class="form-check-label visually-hidden" for="${uniqueSwitchId}">${item.isActive ? 'Active' : 'Inactive'}</label>
                        </div>`;

            let specificActions = [];
            if (item.isActive) {
                if (hasDraft) {
                    specificActions.push(
                        `<button class="btn-action-icon btn-submit-draft" onclick="submitSingleDraft('${licNo}', this)" title="Submit Saved Draft">
                            <i class="fas fa-check"></i>
                        </button>`
                    );
                } else if (item.status === 'Pending') {
                    specificActions.push(
                        `<button class="btn-action-icon btn-update-status" onclick="alert('Update Status for ${licNo} - Not Implemented.')" title="Update License Status">
                            <i class="fas fa-edit"></i>
                        </button>`
                    );
                } else if (['License', 'HRA', 'TPA', 'Others'].includes(item.category)) {
                    if (!isScheduled || (isScheduled && !hasDraft)) {
                        specificActions.push(
                            `<button class="btn-action-icon btn-renew" onclick="openRenewModal('${licNo}')" title="Renew or Update License Details">
                                <i class="fas fa-sync-alt"></i>
                            </button>`
                        );
                    }
                }
                if (['License', 'HRA', 'TPA', 'Others'].includes(item.category)) {
                    specificActions.push(
                        `<button class="btn-action-icon btn-schedule ${isScheduled ? 'active-schedule' : ''}" onclick="openScheduleModal('${licNo}')" title="${isScheduled ? 'Manage Schedule' : 'Schedule Renew/Update'}">
                            <i class="fas fa-calendar-alt"></i>
                        </button>`
                    );
                }
            }


            if (licNo) {
                specificActions.push(
                    `<button class="btn-action-icon btn-history" onclick="openHistoryModal('${licNo}')" title="View License History">
                        <i class="fas fa-history"></i>
                    </button>`
                );
                 specificActions.push(
                    `<button class="btn-action-icon btn-delete" onclick="deleteLicense('${licNo}')" title="Delete License">
                        <i class="fas fa-trash-alt"></i>
                    </button>`
                );
            }

            buttonsHTML = `<div class="action-btns">${specificActions.join('')}</div>`;
            return `<div class="action-buttons-wrapper">${toggleHTML}${buttonsHTML}</div>`;
        }

        function deleteLicense(licenseNo) {
            if (!licenseNo) {
                alert("Error: License number is missing.");
                return;
            }
            if (!confirm(`Are you sure you want to permanently delete license ${licenseNo}? This action cannot be undone.`)) {
                return;
            }

            const dataIndex = findDataIndexByLicenseNo(licenseNo);
            if (dataIndex === -1) {
                alert("Error: License not found in the data.");
                return;
            }

            const deletedItem = allLicenseData.splice(dataIndex, 1)[0];

            const draftIndex = draftUpdates.findIndex(d => d.licenseNo === licenseNo);
            if (draftIndex > -1) {
                draftUpdates.splice(draftIndex, 1);
                updateDraftCount();
            }
            const scheduleIndex = scheduledUpdates.findIndex(s => s.licenseNo === licenseNo);
            if (scheduleIndex > -1) {
                scheduledUpdates.splice(scheduleIndex, 1);
            }


            addHistoryEntry(licenseNo, 'License Deleted',
                `License ${licenseNo} (Unit: ${deletedItem.unitName}, Category: ${deletedItem.category}) was deleted.`,
                currentUser.role);

            initializeUserScope();
            alert(`License ${licenseNo} has been deleted successfully.`);
            
            
            // 🔁 Send status as "Active" or "Deactivated"
    const url = '{{ route("fssailincesDelete") }}';
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            license_id: licenseNo,
        },
        success: function(response) {
            console.log('Status updated:', response);
        },
        error: function(xhr) {
            alert('Failed to update status on server.');
            console.error(xhr.responseText);

            // Rollback toggle and data if AJAX fails
            cb.checked = !cb.checked;
            i.isActive = !i.isActive;
            initializeUserScope();
        }
    });
        }


function toggleActivation(licNo, cb) {
    const dIdx = findDataIndexByLicenseNo(licNo);
    if (dIdx === -1) {
        alert("Error: License not found.");
        cb.checked = !cb.checked;
        return;
    }

    const i = allLicenseData[dIdx];
    const newStatus = cb.checked ? 'Active' : 'Deactivated';

    // Update local state
    i.isActive = cb.checked;
    addHistoryEntry(i.licenseNo, 'Activation Change', `License ${newStatus.toLowerCase()}.`, 'User');
    initializeUserScope();
    alert(`License ${licNo} ${newStatus.toLowerCase()}.`);

    // 🔁 Send status as "Active" or "Deactivated"
    const url = '{{ route("updatelincesstatus") }}';
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            license_id: licNo,
            status: newStatus
        },
        success: function(response) {
            console.log('Status updated:', response);
        },
        error: function(xhr) {
            alert('Failed to update status on server.');
            console.error(xhr.responseText);

            // Rollback toggle and data if AJAX fails
            cb.checked = !cb.checked;
            i.isActive = !i.isActive;
            initializeUserScope();
        }
    });
}



        function populateHierarchicalOptions(dTUse,selEl,key,pF=null){const cV=selEl.value;selEl.innerHTML=`<option value="${ALL_OPTION_VALUE}" selected>-- All --</option>`;let fD=dTUse;if(pF){if(pF.corporate&&pF.corporate!==ALL_OPTION_VALUE)fD=fD.filter(i=>i.corporate===pF.corporate);if(pF.regional&&pF.regional!==ALL_OPTION_VALUE)fD=fD.filter(i=>i.regional===pF.regional);}const uV=[...new Set(fD.map(i=>i[key]).filter(Boolean))].sort((a,b)=>String(a).localeCompare(String(b),undefined,{numeric:true}));uV.forEach(v=>selEl.add(new Option(v,v)));selEl.value=Array.from(selEl.options).some(o=>o.value===cV)?cV:(activeFilters[`selected${key.charAt(0).toUpperCase()+key.slice(1).replace('Name','')}`]||ALL_OPTION_VALUE);selEl.disabled=selEl.options.length<=1&&!selEl.value;}
        function updateHierarchicalFilterOptionsBasedOnUserScope(){const s={c:document.getElementById('unit-filter-corporate-select'),r:document.getElementById('unit-filter-regional-select'),u:document.getElementById('unit-filter-unit-select'),mC:document.getElementById('mobile-unit-filter-corporate-select'),mR:document.getElementById('mobile-unit-filter-regional-select'),mU:document.getElementById('mobile-unit-filter-unit-select')};if(Object.values(s).some(sel=>!sel))return;const cFC=activeFilters.selectedCorporate||s.c.value,cFR=activeFilters.selectedRegional||s.r.value;populateHierarchicalOptions(accessibleLicenseData,s.c,'corporate');populateHierarchicalOptions(accessibleLicenseData,s.r,'regional',{corporate:cFC});populateHierarchicalOptions(accessibleLicenseData,s.u,'unitName',{corporate:cFC,regional:cFR});populateHierarchicalOptions(accessibleLicenseData,s.mC,'corporate');populateHierarchicalOptions(accessibleLicenseData,s.mR,'regional',{corporate:cFC});populateHierarchicalOptions(accessibleLicenseData,s.mU,'unitName',{corporate:cFC,regional:cFR});const setDis=(sel,val,dis)=>{if(sel){sel.value=val;sel.disabled=dis;}};if(currentUser.role==='Corporate'){setDis(s.c,currentUser.corporateName,true);setDis(s.mC,currentUser.corporateName,true);populateHierarchicalOptions(accessibleLicenseData,s.r,'regional',{corporate:currentUser.corporateName});populateHierarchicalOptions(accessibleLicenseData,s.u,'unitName',{corporate:currentUser.corporateName,regional:activeFilters.selectedRegional||s.r.value});populateHierarchicalOptions(accessibleLicenseData,s.mR,'regional',{corporate:currentUser.corporateName});populateHierarchicalOptions(accessibleLicenseData,s.mU,'unitName',{corporate:currentUser.corporateName,regional:activeFilters.selectedRegional||s.mR.value});}else if(currentUser.role==='Regional'){setDis(s.c,currentUser.corporateName,true);setDis(s.r,currentUser.regionalName,true);setDis(s.mC,currentUser.corporateName,true);setDis(s.mR,currentUser.regionalName,true);populateHierarchicalOptions(accessibleLicenseData,s.u,'unitName',{corporate:currentUser.corporateName,regional:currentUser.regionalName});populateHierarchicalOptions(accessibleLicenseData,s.mU,'unitName',{corporate:currentUser.corporateName,regional:currentUser.regionalName});}else if(currentUser.role==='Unit'){[s.c,s.mC].forEach(sel=>setDis(sel,currentUser.corporateName,true));[s.r,s.mR].forEach(sel=>setDis(sel,currentUser.regionalName,true));[s.u,s.mU].forEach(sel=>setDis(sel,currentUser.unitName,true));}Object.values(s).forEach(sel=>{if(sel&&!sel.disabled)sel.disabled=sel.options.length<=1&&!sel.value;});if(s.c.disabled)activeFilters.selectedCorporate=s.c.value!==ALL_OPTION_VALUE?s.c.value:null;if(s.r.disabled)activeFilters.selectedRegional=s.r.value!==ALL_OPTION_VALUE?s.r.value:null;if(s.u.disabled)activeFilters.selectedUnit=s.u.value!==ALL_OPTION_VALUE?s.u.value:null;}

        // --- START: IDENTIFY CHANGES (Modified getUniqueColumnValues) ---
        function getUniqueColumnValues(k){
            const vS=new Set();
            if (k === 'category') {
                BASE_CATEGORIES.forEach(cat => vS.add(cat));
                const customCats = getScopedCustomCategories(); // Use scoped categories
                customCats.forEach(cat => vS.add(cat.name));
            } else {
                accessibleLicenseData.forEach(i=>{
                    if(k==='status')vS.add(i.isActive===false?'Deactivated':(i.status||'(Empty)'));
                    else vS.add(i[k]||'(Empty)');
                });
            }
            return [...vS].filter(v=>v||v==='(Empty)').sort((a,b)=>String(a).localeCompare(String(b)));
        }
        // --- END: IDENTIFY CHANGES ---

        function updateGeneralFilterOptionsBasedOnUserScope(){['category','licenseType','status'].forEach(k=>{const dE=document.querySelector(`.th-filter-dropdown[data-column-key="${k}"]`);if(dE)populateFilterOptions(dE,k);});}
        function populateFilterOptions(dE,k){if(['unitName','licenseNo','expiryDate'].includes(k))return;const oL=dE.querySelector('.options-list'),sI=dE.querySelector('.filter-search input');if(!oL)return;const uV=getUniqueColumnValues(k),cCF=Array.isArray(activeFilters[k])?activeFilters[k]:[];oL.innerHTML=uV.map(v=>{const sV=String(v).replace(/[^a-zA-Z0-9-_]/g,''),cbId=`filter-${k}-${sV||'empty'}-${Math.random().toString(36).substring(2,7)}`,iC=cCF.includes(v);return`<li><input type="checkbox" id="${cbId}" value="${v}" ${iC?'checked':''}><label for="${cbId}">${v}</label></li>`;}).join('');if(sI){sI.value='';filterDropdownOptions(sI);}}
        function filterDropdownOptions(sI){if(!sI)return;const fT=sI.value.toLowerCase(),oL=sI.closest('.th-filter-dropdown, .modal-body').querySelector('.options-list, .options-container');if(!oL)return;oL.querySelectorAll('li, .form-check').forEach(i=>{const l=i.querySelector('label');if(l)i.style.display=l.textContent.toLowerCase().includes(fT)?'':'none';});}
        function closeAllFilterDropdowns(eE=null){document.querySelectorAll('.th-filter-dropdown').forEach(d=>{if(d!==eE)d.style.display='none';});if(currentlyOpenFilterDropdown&&currentlyOpenFilterDropdown!==eE)currentlyOpenFilterDropdown=null;}
        function resetAllFiltersInternal(){activeFilters.licenseNoSearch=null;activeFilters.expiryDateFrom=null;activeFilters.expiryDateTo=null;['licenseNoSearchInput','expiryDateFromInput','expiryDateToInput','mobile-licenseNoSearchInput','mobile-expiryDateFromInput','mobile-expiryDateToInput'].forEach(id=>{const el=document.getElementById(id);if(el)el.value='';});['category','licenseType','status'].forEach(k=>{delete activeFilters[k];const d=document.querySelector(`.th-filter-dropdown[data-column-key="${k}"]`);if(d){d.querySelectorAll('.options-list input[type="checkbox"]').forEach(cb=>cb.checked=false);const sI=d.querySelector('.filter-search input');if(sI){sI.value='';filterDropdownOptions(sI);}}const mK=k==='licenseType'?'licensetype':k,mOC=document.getElementById(`mobile-${mK}-options`);if(mOC)mOC.querySelectorAll('input[type="checkbox"]').forEach(cb=>cb.checked=false);const mSI=document.getElementById(`mobile-${mK}-search`);if(mSI)mSI.value='';});const s={c:'unit-filter-corporate-select',r:'unit-filter-regional-select',u:'unit-filter-unit-select',mC:'mobile-unit-filter-corporate-select',mR:'mobile-unit-filter-regional-select',mU:'mobile-unit-filter-unit-select'};const rS=(id,val)=>{const el=document.getElementById(id);if(el)el.value=val;};if(currentUser.role==='Super Admin'){activeFilters.selectedCorporate=null;activeFilters.selectedRegional=null;activeFilters.selectedUnit=null;Object.values(s).forEach(id=>rS(id,ALL_OPTION_VALUE));}else if(currentUser.role==='Corporate'){activeFilters.selectedCorporate=currentUser.corporateName;activeFilters.selectedRegional=null;activeFilters.selectedUnit=null;[s.c,s.mC].forEach(id=>rS(id,currentUser.corporateName));[s.r,s.u,s.mR,s.mU].forEach(id=>rS(id,ALL_OPTION_VALUE));}else if(currentUser.role==='Regional'){activeFilters.selectedCorporate=currentUser.corporateName;activeFilters.selectedRegional=currentUser.regionalName;activeFilters.selectedUnit=null;[s.c,s.mC].forEach(id=>rS(id,currentUser.corporateName));[s.r,s.mR].forEach(id=>rS(id,currentUser.regionalName));[s.u,s.mU].forEach(id=>rS(id,ALL_OPTION_VALUE));}else if(currentUser.role==='Unit'){activeFilters.selectedCorporate=currentUser.corporateName;activeFilters.selectedRegional=currentUser.regionalName;activeFilters.selectedUnit=currentUser.unitName;[s.c,s.mC].forEach(id=>rS(id,currentUser.corporateName));[s.r,s.mR].forEach(id=>rS(id,currentUser.regionalName));[s.u,s.mU].forEach(id=>rS(id,currentUser.unitName));}const sInp=document.getElementById('searchInput');if(sInp)sInp.value='';document.querySelectorAll('.th-filter-icon.active').forEach(i=>i.classList.remove('active'));closeAllFilterDropdowns();}
        function resetAllFilters(){resetAllFiltersInternal();initializeUserScope();addHistoryEntry('SYSTEM','Table Refresh','Filters cleared.','User');}
        const DUE_SOON_DAYS=90;function calculateDashboardMetrics(dTUse){const cats=['License','HRA','TPA','Others'],mets={};const t=new Date();t.setHours(0,0,0,0);const dSD=new Date(t);dSD.setDate(t.getDate()+DUE_SOON_DAYS);cats.forEach(cat=>{const cD=dTUse.filter(i=>i.category===cat&&i.isActive===true);let aC=0,eC=0,dSC=0,eDD=null;cD.forEach(i=>{if(i.status==='Active'){aC++;if(i.expiryDate&&i.expiryDate!=='N/A'){try{const exp=new Date(i.expiryDate);if(!isNaN(exp.getTime())){exp.setHours(0,0,0,0);if(!eDD||exp<eDD)eDD=exp;if(exp>=t&&exp<=dSD)dSC++;}}catch(e){}}}else if(i.status==='Expired')eC++;});mets[cat]={total:cD.length,active:aC,expired:eC,dueSoon:dSC,earliestDueDate:eDD};});return mets;}
        function updateDashboardCards(mets){const cM={'License':{p:'card-license',c:'dashboard-card-green'},'HRA':{p:'card-hra',c:'dashboard-card-orange'},'TPA':{p:'card-tpa',c:'dashboard-card-blue'},'Others':{p:'card-others',c:'dashboard-card-gray'}};Object.keys(cM).forEach(cat=>{const m=mets[cat],cfg=cM[cat],el=id=>document.getElementById(`${cfg.p}-${id}`);const sE=el('status'),dE=el('due'),pE=el('progress'),iE=el('info'),cE=document.getElementById(cfg.p);if(!sE||!dE||!pE||!iE||!cE)return;sE.className='status-badge';pE.className='progress-fill';cE.className=`dashboard-card`;if(!m||m.total===0){sE.textContent='N/A';sE.classList.add('status-pending');dE.textContent='Next Due: N/A';pE.style.width='0%';iE.textContent='No Active Data';cE.className=`dashboard-card dashboard-card-gray`;return;}let oTxt='COMPLIANT',oCls='status-compliant',pClrCls='progress-fill-green',cBdrCls=cfg.c;if(m.expired>0){oTxt='EXPIRED';oCls='status-expired';pClrCls='progress-fill-red';cBdrCls='dashboard-card-red';}else if(m.dueSoon>0){oTxt='DUE SOON';oCls='status-due-soon';pClrCls='progress-fill-orange';cBdrCls='dashboard-card-orange';}sE.textContent=oTxt;sE.classList.add(oCls);dE.textContent=m.earliestDueDate?`Next Due: ${m.earliestDueDate.toISOString().split('T')[0]}`:(m.active===0&&m.total>0?'Next Due: N/A (None Active)':'Next Due: N/A');pE.style.width=`${m.total>0?(m.active/m.total)*100:0}%`;pE.classList.add(pClrCls);iE.textContent=`Active: ${m.active} / Total: ${m.total}`;cE.className=`dashboard-card ${cBdrCls}`;});}


function saveDraftUpdate() {
    const formData = new FormData();
    const licNo = document.getElementById('renewLicenseNumber').value.trim();
    const expDateInput = document.getElementById('newExpiryDate');
    const expDate = expDateInput.value.trim();
    const category = document.getElementById('renewCategory').textContent.trim();
    const fileInput = document.getElementById('renewalDocument');
    const otherCatInput = document.getElementById('renewOtherCategoryName');
    const otherCatWrapper = document.getElementById('renewOtherCategoryNameWrapper');

    // Clear previous validation states
    expDateInput.classList.remove('is-invalid');
    otherCatInput.classList.remove('is-invalid');

    let isValid = true;
    let showOtherCatError = false;

    if (!expDate) {
        expDateInput.classList.add('is-invalid');
        isValid = false;
    }

    let otherCat = '';
    if (category === 'Others' && !otherCatWrapper.classList.contains('d-none')) {
        otherCat = otherCatInput.value.trim();
        if (!otherCat) {
            otherCatInput.classList.add('is-invalid');
            isValid = false;
            showOtherCatError = true;
        }
    }

    if (!isValid) {
        let msg = 'Please fill all required fields: ';
        const missing = [];
        if (!expDate) missing.push('New Expiry Date');
        if (showOtherCatError) missing.push('Other Category Name');
        alert(msg + missing.join(', ') + '.');
        return;
    }

    const dIdx = findDataIndexByLicenseNo(licNo);
    if (dIdx > -1 && !allLicenseData[dIdx].isActive) {
        alert("Cannot save draft for deactivated license.");
        if (renewModal) renewModal.hide();
        return;
    }

    const file = fileInput?.files[0];
    const fileName = file ? file.name : (draftUpdates.find(d => d.licenseNo === licNo)?.newDocumentName || null);

    const draftData = {
        licenseNo: licNo,
        expiryDate: expDate,
        certificate: fileName
    };

    formData.append('licenseNo', licNo);
    formData.append('expiryDate', expDate);
    if (file) {
        formData.append('certificate', file);
    }

    if (category === 'Others') {
        draftData.otherCategoryName = otherCat;
        formData.append('otherCategoryName', otherCat);
    }

    const draftIndex = draftUpdates.findIndex(d => d.licenseNo === licNo);
    if (draftIndex > -1) {
        draftUpdates[draftIndex] = draftData;
    } else {
        draftUpdates.push(draftData);
    }

    initializeUserScope();
    updateDraftCount();

    if (renewModal) renewModal.hide();
    alert(`Draft saved for ${licNo}.`);
    
    
    // Optionally: submit to server if needed

    fetch("{{ route('lincesupload') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            
            location.reload();

            alert("Draft data saved to server successfully.");
        } else {
            alert("Server error: " + (data.message || "Unknown issue."));
        }
    })
    .catch(error => {
        console.error("Draft Save Error:", error);
        alert("Failed to save draft data to the server.");
    });
    

    
}


        function updateDraftCount(){const c=draftUpdates.length;document.getElementById('draftCount').textContent=c;document.getElementById('submitDraftsButton').disabled=(c===0);}

        // --- START: IDENTIFY CHANGES (Modified reapplyDraftStyles & reapplyScheduledStyles) ---
        function reapplyDraftStyles(){
            const tB=document.getElementById('fssaiTableBody');
            tB.querySelectorAll('tr.has-draft').forEach(r => r.classList.remove('has-draft'));
            draftUpdates.forEach(d=>{
                const r=tB.querySelector(`tr[data-license-no="${d.licenseNo}"]`);
                if(r){
                    const iIdx=findDataIndexByLicenseNo(d.licenseNo);
                    if(iIdx>-1&&allLicenseData[iIdx].isActive){ r.classList.add('has-draft'); }
                }
            });
            if (!isMobileView()) {
                 tB.querySelectorAll('tr[data-license-no]').forEach(row => {
                    const licNo = row.dataset.licenseNo;
                    const itemIndex = findDataIndexByLicenseNo(licNo);
                    if (itemIndex > -1) {
                        const item = allLicenseData[itemIndex];
                        const actionCellIndex = DATA_KEYS.indexOf('actions');
                        if (row.cells[actionCellIndex]) { row.cells[actionCellIndex].innerHTML = generateActionsHTML(item); }
                    }
                });
            }
        }
        function reapplyScheduledStyles() {
            const tB = document.getElementById('fssaiTableBody');
            tB.querySelectorAll('tr.is-scheduled').forEach(r => r.classList.remove('is-scheduled'));
            scheduledUpdates.forEach(s => {
                const r = tB.querySelector(`tr[data-license-no="${s.licenseNo}"]`);
                if (r) {
                    const iIdx = findDataIndexByLicenseNo(s.licenseNo);
                    if (iIdx > -1 && allLicenseData[iIdx].isActive) { r.classList.add('is-scheduled'); }
                }
            });
            if (!isMobileView()) {
                 tB.querySelectorAll('tr[data-license-no]').forEach(row => {
                    const licNo = row.dataset.licenseNo;
                    const itemIndex = findDataIndexByLicenseNo(licNo);
                    if (itemIndex > -1) {
                        const item = allLicenseData[itemIndex];
                        const actionCellIndex = DATA_KEYS.indexOf('actions');
                         if (row.cells[actionCellIndex]) { row.cells[actionCellIndex].innerHTML = generateActionsHTML(item); }
                    }
                });
            }
        }
        // --- END: IDENTIFY CHANGES ---

        function isMobileView(){return window.innerWidth<=768;}
        function submitSingleDraft(licNo,btnEl){const drIdx=draftUpdates.findIndex(d=>d.licenseNo===licNo);if(drIdx===-1){alert(`Error: Draft not found for ${licNo}.`);if(btnEl?.closest('tr'))btnEl.closest('tr').classList.remove('has-draft');return;}const dr=draftUpdates[drIdx],dIdx=findDataIndexByLicenseNo(licNo);if(dIdx===-1){alert(`Error: Original data not for ${licNo}.`);draftUpdates.splice(drIdx,1);updateDraftCount();if(btnEl?.closest('tr'))btnEl.closest('tr').classList.remove('has-draft');return;}const i=allLicenseData[dIdx];if(!i.isActive){alert(`License ${licNo} deactivated.`);return;}const oE=i.expiryDate,oD=i.licenseCopy,oOCN=i.otherCategoryName;i.expiryDate=dr.newExpiryDate;i.licenseCopy=dr.newDocumentName;if(i.category==='Others'&&typeof dr.otherCategoryName!=='undefined')i.otherCategoryName=dr.otherCategoryName;i.status=updateStatusBasedOnDate(i.expiryDate,i.status);let dets=`Applied: Exp ${oE||'N/A'}->${i.expiryDate}`;if(dr.newDocumentName&&dr.newDocumentName!==oD)dets+=`, Doc: ${dr.newDocumentName}`;else if(!dr.newDocumentName&&oD)dets+=`, Doc Removed`;if(i.category==='Others'&&dr.otherCategoryName!==oOCN)dets+=`, OthDetail: ${oOCN||'N/A'}->${i.otherCategoryName}`;addHistoryEntry(i.licenseNo,'Draft Submitted',dets,'User');draftUpdates.splice(drIdx,1);updateDraftCount();initializeUserScope();alert(`Draft for ${licNo} submitted.`);}
        function applyAllFilters(){const gST=document.getElementById('searchInput').value.toLowerCase().trim();let dR=[...accessibleLicenseData];const{selectedCorporate:sC,selectedRegional:sR,selectedUnit:sU,licenseNoSearch:lNS,expiryDateFrom:eDF,expiryDateTo:eDT}=activeFilters;if(sC&&sC!==ALL_OPTION_VALUE)dR=dR.filter(i=>i.corporate===sC);if(sR&&sR!==ALL_OPTION_VALUE)dR=dR.filter(i=>i.regional===sR);if(sU&&sU!==ALL_OPTION_VALUE)dR=dR.filter(i=>i.unitName===sU);Object.keys(activeFilters).forEach(k=>{const v=activeFilters[k];if(!['selectedCorporate','selectedRegional','selectedUnit','expiryDateFrom','expiryDateTo','licenseNoSearch'].includes(k)&&Array.isArray(v)&&v.length>0){dR=dR.filter(i=>v.includes(k==='status'?(i.isActive===false?'Deactivated':(i.status||'(Empty)')):(i[k]||'(Empty)')));}});if(lNS)dR=dR.filter(i=>i.licenseNo&&i.licenseNo.toLowerCase().includes(lNS.toLowerCase()));if(eDF||eDT){const f=eDF?new Date(eDF):null,t=eDT?new Date(eDT):null;if(f)f.setHours(0,0,0,0);if(t)t.setHours(23,59,59,999);dR=dR.filter(i=>{if(!i.expiryDate||i.expiryDate==='N/A')return false;try{const iD=new Date(i.expiryDate);iD.setHours(0,0,0,0);return(f?iD>=f:true)&&(t?iD<=t:true);}catch(e){return false;}}); }filteredLicenseData=gST?dR.filter(i=>Object.values(i).some(v=>(v&&v.toString().toLowerCase().includes(gST))||(i.category==='Others'&&i.otherCategoryName&&i.otherCategoryName.toLowerCase().includes(gST)))):dR;document.querySelectorAll('.th-filter-icon').forEach(icon=>{const k=icon.dataset.columnKey;let iA=false;if(k==='unitName')iA=!!(sC||sR||sU);else if(k==='licenseNo')iA=!!lNS;else if(k==='expiryDate')iA=!!(eDF||eDT);else iA=Array.isArray(activeFilters[k])&&activeFilters[k].length>0;icon.classList.toggle('active',iA);});renderTablePage(1); }

        function handleRowsPerPageChange(event) {
            rowsPerPage = parseInt(event.target.value, 10);
            if (event.target.id === 'rowsPerPageSelectDesktop' && rowsPerPageSelectMobileEl) {
                rowsPerPageSelectMobileEl.value = rowsPerPage;
            } else if (event.target.id === 'rowsPerPageSelectMobile' && rowsPerPageSelectDesktopEl) {
                rowsPerPageSelectDesktopEl.value = rowsPerPage;
            }
            renderTablePage(1);
        }

        function setupEventListeners(){
            document.querySelectorAll('.th-filter-icon').forEach(i=>{i.addEventListener('click',e=>{e.stopPropagation();const k=i.dataset.columnKey,d=i.closest('th').querySelector('.th-filter-dropdown');if(!d)return;if(d===currentlyOpenFilterDropdown)closeAllFilterDropdowns();else{closeAllFilterDropdowns(d);if(k==='licenseNo'){const inp=d.querySelector('#licenseNoSearchInput');if(inp){inp.value=activeFilters.licenseNoSearch||'';inp.focus();}}else if(k==='expiryDate'){const f=d.querySelector('#expiryDateFromInput'),t=d.querySelector('#expiryDateToInput');if(f)f.value=activeFilters.expiryDateFrom||'';if(t)t.value=activeFilters.expiryDateTo||'';}else if(!['unitName'].includes(k)){populateFilterOptions(d,k);const s=d.querySelector('.filter-search input');if(s)s.focus();}d.style.display='block';currentlyOpenFilterDropdown=d;}});});document.querySelectorAll('.th-filter-dropdown[data-column-key="category"] .btn-apply,.th-filter-dropdown[data-column-key="licenseType"] .btn-apply,.th-filter-dropdown[data-column-key="status"] .btn-apply').forEach(b=>b.addEventListener('click',()=>{const d=b.closest('.th-filter-dropdown'),k=d.dataset.columnKey,sV=Array.from(d.querySelectorAll('.options-list input:checked')).map(cb=>cb.value);if(sV.length>0)activeFilters[k]=sV;else delete activeFilters[k];closeAllFilterDropdowns();applyAllFilters();}));document.querySelectorAll('.th-filter-dropdown[data-column-key="category"] .btn-clear,.th-filter-dropdown[data-column-key="licenseType"] .btn-clear,.th-filter-dropdown[data-column-key="status"] .btn-clear').forEach(b=>b.addEventListener('click',()=>{const d=b.closest('.th-filter-dropdown'),k=d.dataset.columnKey;d.querySelectorAll('.options-list input').forEach(cb=>cb.checked=false);const sI=d.querySelector('.filter-search input');if(sI){sI.value='';filterDropdownOptions(sI);}delete activeFilters[k];applyAllFilters();}));document.querySelectorAll('.th-filter-dropdown[data-column-key="category"] .filter-search input,.th-filter-dropdown[data-column-key="licenseType"] .filter-search input,.th-filter-dropdown[data-column-key="status"] .filter-search input').forEach(i=>i.addEventListener('input',()=>filterDropdownOptions(i)));const cS=document.getElementById('unit-filter-corporate-select'),rS=document.getElementById('unit-filter-regional-select'),uS=document.getElementById('unit-filter-unit-select'),uFA=document.querySelector('.unit-filter-apply'),uFC=document.querySelector('.unit-filter-clear');if(cS)cS.addEventListener('change',()=>{if(!cS.disabled){activeFilters.selectedCorporate=cS.value!==ALL_OPTION_VALUE?cS.value:null;activeFilters.selectedRegional=null;activeFilters.selectedUnit=null;if(rS)rS.value=ALL_OPTION_VALUE;if(uS)uS.value=ALL_OPTION_VALUE;updateHierarchicalFilterOptionsBasedOnUserScope();}});if(rS)rS.addEventListener('change',()=>{if(!rS.disabled){activeFilters.selectedRegional=rS.value!==ALL_OPTION_VALUE?rS.value:null;activeFilters.selectedUnit=null;if(uS)uS.value=ALL_OPTION_VALUE;updateHierarchicalFilterOptionsBasedOnUserScope();}});if(uFA&&cS&&rS&&uS)uFA.addEventListener('click',()=>{if(!cS.disabled)activeFilters.selectedCorporate=cS.value!==ALL_OPTION_VALUE?cS.value:null;if(!rS.disabled)activeFilters.selectedRegional=rS.value!==ALL_OPTION_VALUE?rS.value:null;if(!uS.disabled)activeFilters.selectedUnit=uS.value!==ALL_OPTION_VALUE?uS.value:null;closeAllFilterDropdowns();applyAllFilters();});if(uFC&&cS&&rS&&uS)uFC.addEventListener('click',()=>{if(!cS.disabled){cS.value=ALL_OPTION_VALUE;activeFilters.selectedCorporate=null;}if(!rS.disabled){rS.value=ALL_OPTION_VALUE;activeFilters.selectedRegional=null;}if(!uS.disabled){uS.value=ALL_OPTION_VALUE;activeFilters.selectedUnit=null;}updateHierarchicalFilterOptionsBasedOnUserScope();applyAllFilters();});const lNA=document.querySelector('.licenseNo-filter-apply'),lNC=document.querySelector('.licenseNo-filter-clear'),lNS=document.getElementById('licenseNoSearchInput');if(lNA&&lNS){lNA.addEventListener('click',()=>{activeFilters.licenseNoSearch=lNS.value.trim()||null;closeAllFilterDropdowns();applyAllFilters();});lNS.addEventListener('keypress',e=>{if(e.key==='Enter'){e.preventDefault();lNA.click();}});}if(lNC&&lNS)lNC.addEventListener('click',()=>{lNS.value='';activeFilters.licenseNoSearch=null;applyAllFilters();});const eDA=document.querySelector('.expiryDate-filter-apply'),eDC=document.querySelector('.expiryDate-filter-clear'),eDF=document.getElementById('expiryDateFromInput'),eDT=document.getElementById('expiryDateToInput');if(eDA&&eDF&&eDT)eDA.addEventListener('click',()=>{activeFilters.expiryDateFrom=eDF.value||null;activeFilters.expiryDateTo=eDT.value||null;closeAllFilterDropdowns();applyAllFilters();});if(eDC&&eDF&&eDT)eDC.addEventListener('click',()=>{eDF.value='';eDT.value='';activeFilters.expiryDateFrom=null;activeFilters.expiryDateTo=null;applyAllFilters();});document.addEventListener('click',e=>{if(currentlyOpenFilterDropdown&&!currentlyOpenFilterDropdown.contains(e.target)&&!e.target.closest('.th-filter-icon')&&!e.target.closest('.th-filter-dropdown .filter-actions button'))closeAllFilterDropdowns();});document.querySelectorAll('.th-filter-dropdown').forEach(d=>d.addEventListener('click',e=>e.stopPropagation()));
            const sI=document.getElementById('searchInput');
            if(sI){
                sI.addEventListener('keypress',e=>{if(e.key==='Enter')applyAllFilters();});
                sI.addEventListener('input',()=>applyAllFilters());
            }

            if (rowsPerPageSelectDesktopEl) {
                rowsPerPageSelectDesktopEl.addEventListener('change', handleRowsPerPageChange);
            }
            if (rowsPerPageSelectMobileEl) {
                rowsPerPageSelectMobileEl.addEventListener('change', handleRowsPerPageChange);
            }

            document.getElementById('submitDraftsButton').addEventListener('click',()=>{if(draftUpdates.length===0){alert("No drafts.");return;}if(!confirm(`Submit ${draftUpdates.length} draft(s)?`))return;let app=0,skp=0;const tS=[...draftUpdates];tS.forEach(d=>{const idx=findDataIndexByLicenseNo(d.licenseNo);if(idx>-1){const i=allLicenseData[idx];if(!i.isActive){skp++;return;}const oE=i.expiryDate,oD=i.licenseCopy,oOCN=i.otherCategoryName;i.expiryDate=d.newExpiryDate;i.licenseCopy=d.newDocumentName;if(i.category==='Others'&&typeof d.otherCategoryName!=='undefined')i.otherCategoryName=d.otherCategoryName;i.status=updateStatusBasedOnDate(i.expiryDate,i.status);let dets=`Applied: Exp ${oE||'N/A'}->${i.expiryDate}`;if(d.newDocumentName&&d.newDocumentName!==oD)dets+=`, Doc: ${d.newDocumentName}`;else if(!d.newDocumentName&&oD)dets+=`, Doc Removed`;if(i.category==='Others'&&d.otherCategoryName!==oOCN)dets+=`, OthDetail: ${oOCN||'N/A'}->${i.otherCategoryName}`;addHistoryEntry(i.licenseNo,'Draft Submitted',dets,'User');const oIdx=draftUpdates.findIndex(dr=>dr.licenseNo===d.licenseNo);if(oIdx>-1)draftUpdates.splice(oIdx,1);app++;}else{const oIdx=draftUpdates.findIndex(dr=>dr.licenseNo===d.licenseNo);if(oIdx>-1)draftUpdates.splice(oIdx,1);}});updateDraftCount();initializeUserScope();let msg=`${app} draft(s) submitted.`;if(skp>0)msg+=` ${skp} for deactivated skipped.`;alert(msg);});
            document.getElementById('refreshTableButton').addEventListener('click',()=>resetAllFilters());
            const mCS=document.getElementById('mobile-unit-filter-corporate-select'),mRS=document.getElementById('mobile-unit-filter-regional-select');if(mCS)mCS.addEventListener('change',()=>{if(!mCS.disabled){const sC=mCS.value!==ALL_OPTION_VALUE?mCS.value:null;populateHierarchicalOptions(accessibleLicenseData,mRS,'regional',{corporate:sC});populateHierarchicalOptions(accessibleLicenseData,document.getElementById('mobile-unit-filter-unit-select'),'unitName',{corporate:sC,regional:mRS.value!==ALL_OPTION_VALUE?mRS.value:null});}});if(mRS)mRS.addEventListener('change',()=>{if(!mRS.disabled){const sR=mRS.value!==ALL_OPTION_VALUE?mRS.value:null;const cMC=mCS.value!==ALL_OPTION_VALUE?mCS.value:null;populateHierarchicalOptions(accessibleLicenseData,document.getElementById('mobile-unit-filter-unit-select'),'unitName',{corporate:cMC,regional:sR});}});['category','licensetype','status'].forEach(k=>{const sInp=document.getElementById(`mobile-${k}-search`);if(sInp)sInp.addEventListener('input',()=>filterMobileDropdownOptions(sInp,k));});
        }
        function openMobileFilterModal(){populateMobileFilterOptions();if(mobileFilterModalInstance)mobileFilterModalInstance.show();}
        function populateMobileFilterOptions(){const mCS=document.getElementById('mobile-unit-filter-corporate-select'),mRS=document.getElementById('mobile-unit-filter-regional-select'),mUS=document.getElementById('mobile-unit-filter-unit-select');const cFC=activeFilters.selectedCorporate,cFR=activeFilters.selectedRegional,cFU=activeFilters.selectedUnit;populateHierarchicalOptions(accessibleLicenseData,mCS,'corporate');populateHierarchicalOptions(accessibleLicenseData,mRS,'regional',{corporate:cFC});populateHierarchicalOptions(accessibleLicenseData,mUS,'unitName',{corporate:cFC,regional:cFR});if(cFC)mCS.value=cFC;if(cFC)populateHierarchicalOptions(accessibleLicenseData,mRS,'regional',{corporate:cFC});if(cFR)mRS.value=cFR;if(cFR)populateHierarchicalOptions(accessibleLicenseData,mUS,'unitName',{corporate:cFC,regional:cFR});if(cFU)mUS.value=cFU;const sMSD=(s,v,d)=>{if(s){s.value=v;s.disabled=d;}};if(currentUser.role==='Corporate'){sMSD(mCS,currentUser.corporateName,true);populateHierarchicalOptions(accessibleLicenseData,mRS,'regional',{corporate:currentUser.corporateName});populateHierarchicalOptions(accessibleLicenseData,mUS,'unitName',{corporate:currentUser.corporateName,regional:mRS.value!==ALL_OPTION_VALUE?mRS.value:activeFilters.selectedRegional});if(activeFilters.selectedRegional)mRS.value=activeFilters.selectedRegional;if(activeFilters.selectedUnit)mUS.value=activeFilters.selectedUnit;mRS.disabled=mRS.options.length<=1&&!mRS.value;mUS.disabled=mUS.options.length<=1&&!mUS.value;}else if(currentUser.role==='Regional'){sMSD(mCS,currentUser.corporateName,true);sMSD(mRS,currentUser.regionalName,true);populateHierarchicalOptions(accessibleLicenseData,mUS,'unitName',{corporate:currentUser.corporateName,regional:currentUser.regionalName});if(activeFilters.selectedUnit)mUS.value=activeFilters.selectedUnit;mUS.disabled=mUS.options.length<=1&&!mUS.value;}else if(currentUser.role==='Unit'){sMSD(mCS,currentUser.corporateName,true);sMSD(mRS,currentUser.regionalName,true);sMSD(mUS,currentUser.unitName,true);}else{[mCS,mRS,mUS].forEach(s=>{if(s)s.disabled=s.options.length<=1&&!s.value;});}['category','licensetype','status'].forEach(kI=>{const dK=kI==='licensetype'?'licenseType':kI;const oC=document.getElementById(`mobile-${kI}-options`),sI=document.getElementById(`mobile-${kI}-search`);if(!oC)return;const uV=getUniqueColumnValues(dK),cCF=Array.isArray(activeFilters[dK])?activeFilters[dK]:[];oC.innerHTML=uV.map(v=>{const sV=String(v).replace(/[^a-zA-Z0-9-_]/g,''),cbId=`mobile-filter-${kI}-${sV||'empty'}-${Math.random().toString(36).substring(2,7)}`,iC=cCF.includes(v);return`<div class="form-check"><input class="form-check-input" type="checkbox" value="${v}" id="${cbId}" ${iC?'checked':''}><label class="form-check-label" for="${cbId}">${v}</label></div>`;}).join('');if(sI){sI.value='';filterMobileDropdownOptions(sI,kI);}});const mLNI=document.getElementById('mobile-licenseNoSearchInput');if(mLNI)mLNI.value=activeFilters.licenseNoSearch||'';const mEF=document.getElementById('mobile-expiryDateFromInput');if(mEF)mEF.value=activeFilters.expiryDateFrom||'';const mET=document.getElementById('mobile-expiryDateToInput');if(mET)mET.value=activeFilters.expiryDateTo||'';}
        function filterMobileDropdownOptions(sI,k){const fT=sI.value.toLowerCase(),oC=document.getElementById(`mobile-${k}-options`);if(!oC)return;oC.querySelectorAll('.form-check').forEach(i=>{const l=i.querySelector('label');if(l)i.style.display=l.textContent.toLowerCase().includes(fT)?'':'none';});}
        function applyMobileFilters(){const mC=document.getElementById('mobile-unit-filter-corporate-select'),mR=document.getElementById('mobile-unit-filter-regional-select'),mU=document.getElementById('mobile-unit-filter-unit-select');if(!mC.disabled)activeFilters.selectedCorporate=mC.value!==ALL_OPTION_VALUE?mC.value:null;if(!mR.disabled)activeFilters.selectedRegional=mR.value!==ALL_OPTION_VALUE?mR.value:null;if(!mU.disabled)activeFilters.selectedUnit=mU.value!==ALL_OPTION_VALUE?mU.value:null;['category','licensetype','status'].forEach(k=>{const dK=k==='licensetype'?'licenseType':k;const c=document.getElementById(`mobile-${k}-options`);if(c){const s=Array.from(c.querySelectorAll('input[type="checkbox"]:checked')).map(cb=>cb.value);if(s.length>0)activeFilters[dK]=s;else delete activeFilters[dK];}});activeFilters.licenseNoSearch=document.getElementById('mobile-licenseNoSearchInput').value.trim()||null;activeFilters.expiryDateFrom=document.getElementById('mobile-expiryDateFromInput').value||null;activeFilters.expiryDateTo=document.getElementById('mobile-expiryDateToInput').value||null;applyAllFilters();if(mobileFilterModalInstance)mobileFilterModalInstance.hide();}
        function clearMobileFilters(){resetAllFiltersInternal();populateMobileFilterOptions();}

        // --- START: IDENTIFY CHANGES (Modified renderTablePage for scheduled info) ---
        function renderTablePage(page){
            currentPage=page;
            const tB=document.getElementById('fssaiTableBody');
            tB.innerHTML='';
            let dataToRender=filteredLicenseData;
            const isMobile=isMobileView();

            if(isMobile){
                let mobileDisplayData=[...dataToRender];
                mobileDisplayData.sort((a,b)=>(a.isActive===b.isActive)?0:a.isActive?-1:1);
                dataToRender=mobileDisplayData;
            }

            let totalItems=dataToRender.length,totalPages=Math.ceil(totalItems/rowsPerPage)||1;
            page=Math.max(1,Math.min(page,totalPages));
            currentPage=page;
            let start=(page-1)*rowsPerPage,end=start+rowsPerPage;
            let pageData=dataToRender.slice(start,end);

            if(pageData.length===0&&totalItems>0&&currentPage>1){changePage(currentPage-1);return;}
            if(pageData.length===0&&totalItems===0){tB.innerHTML=isMobile?`<tr><td><div class="mobile-license-card text-center text-muted p-3">No data available.</div></td></tr>`:`<tr><td colspan="${DATA_KEYS.length}" class="text-center text-muted">No data available.</td></tr>`;updatePaginationControls(0,0,0);return;}

            pageData.forEach((item,index)=>{
                const actualSlNo=start+index+1,row=tB.insertRow();
                row.setAttribute('data-license-no',item.licenseNo||`temp-${index}`);
                if(item.isActive===false)row.classList.add('row-deactivated','mobile-card-border-deactivated');
                else if(item.status==='Active')row.classList.add('mobile-card-border-active');
                else if(item.status==='Expired')row.classList.add('mobile-card-border-expired');
                else if(item.status==='Pending')row.classList.add('mobile-card-border-pending');

                if(draftUpdates.some(d=>d.licenseNo===item.licenseNo)&&item.isActive)row.classList.add('has-draft');

                const scheduleForItem = scheduledUpdates.find(s => s.licenseNo === item.licenseNo);
                if(scheduleForItem && item.isActive) row.classList.add('is-scheduled');


                if(isMobile){
                    const cell=row.insertCell();
                    cell.colSpan=DATA_KEYS.length;
                    let catDisp=item.category==='Others'&&item.otherCategoryName?`Others: ${item.otherCategoryName}`:(item.category||'N/A');
                    let dispExpDate=item.expiryDate||'N/A';
                    if(item.expiryDate&&/^\d{4}-\d{2}-\d{2}$/.test(item.expiryDate)){const p=item.expiryDate.split('-');dispExpDate=`${p[1]}/${p[2]}/${p[0]}`; }

                    let scheduledInfoMobileHTML = '';
                    if (scheduleForItem && item.isActive) {
                        scheduledInfoMobileHTML = `<p class="scheduled-info-mobile" title="${scheduleForItem.scheduledComments || 'No comments'}"><i class="fas fa-calendar-check"></i> Scheduled: ${scheduleForItem.scheduledDate}${scheduleForItem.scheduledTime ? ' @ ' + scheduleForItem.scheduledTime : ''}</p>`;
                    }

                    cell.innerHTML=`
                        <div class="mobile-license-card">
                            <div class="card-header-mobile"><span class="unit-name-mobile">${item.unitName||'N/A'}</span><span class="status-mobile">${getStatusBadge(item.status,item.isActive)}</span></div>
                            <div class="card-subheader-mobile">${item.corporate||'N/A'} &gt; ${item.regional||'N/A'}</div>
                            <div class="card-body-mobile">
                                <div class="left-details">
                                    <p><strong>Category:</strong> ${catDisp}</p>
                                    <p><strong>License Type:</strong> ${item.licenseType||'N/A'}</p>
                                </div>
                                <div class="right-details">
                                    <p><strong>License No:</strong> ${item.licenseNo||'N/A'}</p>
                                    <p><strong>Expiry Date:</strong> ${dispExpDate}</p>
                                    ${scheduledInfoMobileHTML}
                                </div>
                            </div>
                            <div class="card-footer-mobile">
                                <div class="pdf-icon-mobile">${generateLicenseCopyHTML(item.licenseCopy,item.licenseNo)}</div>
                                <div class="actions-mobile">${generateActionsHTML(item)}</div>
                            </div>
                        </div>`;
                } else {
                    row.insertCell().textContent=actualSlNo;
                    const uHC=row.insertCell();
                    uHC.innerHTML=`<div>${item.unitName||''}</div><small class="text-muted">${item.corporate||'N/A'} > ${item.regional||'N/A'}</small>`;
                    uHC.style.whiteSpace='normal';
                    const cC=row.insertCell();
                    cC.textContent=item.category==='Others'&&item.otherCategoryName?`Others: ${item.otherCategoryName}`:(item.category||'');
                    row.insertCell().textContent=item.licenseNo||'';

                    const expiryDateCell = row.insertCell();
                    let expiryDateHTML = item.expiryDate||'N/A';
                    if (scheduleForItem && item.isActive) {
                        expiryDateHTML += `<div class="scheduled-info-badge" title="${scheduleForItem.scheduledComments || 'No comments'}">
                                              <i class="fas fa-calendar-check me-1"></i>Scheduled: ${scheduleForItem.scheduledDate}${scheduleForItem.scheduledTime ? ' @ ' + scheduleForItem.scheduledTime : ''}
                                           </div>`;
                    }
                    expiryDateCell.innerHTML = expiryDateHTML;

                    row.insertCell().textContent=item.licenseType||'N/A';
                    row.insertCell().innerHTML=generateLicenseCopyHTML(item.licenseCopy,item.licenseNo);
                    row.insertCell().innerHTML=getStatusBadge(item.status,item.isActive);
                    row.insertCell().innerHTML=generateActionsHTML(item);
                }
            });
            updatePaginationControls(page,totalPages,totalItems);
            if (!isMobile) { // Re-init tooltips for desktop only, as mobile doesn't show action buttons with tooltips
                tooltipList.forEach(tooltip => tooltip.dispose());
                tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], .action-buttons-wrapper [title], .scheduled-info-badge[title]'));
                tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }
        // --- END: IDENTIFY CHANGES ---

        function updatePaginationControls(curP,totP,totI){const pU=document.getElementById('paginationUl');pU.innerHTML='';const sS=document.getElementById('showingStart'),sE=document.getElementById('showingEnd'),tE=document.getElementById('totalEntries');if(totI===0){sS.textContent=0;sE.textContent=0;tE.textContent=0;pU.innerHTML='<li class="page-item disabled"><span class="page-link">No data</span></li>';return;}const sEntry=(curP-1)*rowsPerPage+1,eEntry=Math.min(sEntry+rowsPerPage-1,totI);sS.textContent=sEntry;sE.textContent=eEntry;tE.textContent=totI;let liP=document.createElement('li');liP.className=`page-item ${curP===1?'disabled':''}`;liP.innerHTML=`<a class="page-link" href="#" ${curP>1?`onclick="event.preventDefault();changePage(${curP-1})"`:''}>Previous</a>`;pU.appendChild(liP);const mP=5;let sP=Math.max(1,curP-Math.floor(mP/2)),eP=Math.min(totP,sP+mP-1);sP=Math.max(1,eP-mP+1);if(sP>1){pU.appendChild(createPageItem(1));if(sP>2)pU.appendChild(createEllipsisItem());}for(let i=sP;i<=eP;i++)pU.appendChild(createPageItem(i,curP===i));if(eP<totP){if(eP<totP-1)pU.appendChild(createEllipsisItem());pU.appendChild(createPageItem(totP));}let liN=document.createElement('li');liN.className=`page-item ${curP===totP?'disabled':''}`;liN.innerHTML=`<a class="page-link" href="#" ${curP<totP?`onclick="event.preventDefault();changePage(${curP+1})"`:''}>Next</a>`;pU.appendChild(liN);}
        function createPageItem(pN,isAct=false){let li=document.createElement('li');li.className=`page-item ${isAct?'active':''}`;li.innerHTML=`<a class="page-link" href="#" onclick="event.preventDefault();changePage(${pN})">${pN}</a>`;return li;}
        function createEllipsisItem(){let li=document.createElement('li');li.className='page-item disabled';li.innerHTML=`<span class="page-link">...</span>`;return li;}
        function changePage(pg){let dataToProcess = filteredLicenseData; if(isMobileView()){ let mobileSortedData = [...filteredLicenseData]; mobileSortedData.sort((a, b) => (a.isActive === b.isActive)? 0 : a.isActive? -1 : 1); dataToProcess = mobileSortedData; } const tP = Math.ceil(dataToProcess.length / rowsPerPage) || 1; if(pg < 1 || pg > tP) return; renderTablePage(pg); }

        // --- START MODIFICATION BLOCK ---
        // This function is modified to filter the category dropdown based on the entered unit.
        // It hides categories (except "Others") that are already active for the unit.
        // It shows categories that are deactivated or not yet added for the unit.
        // "Others" category is always available.
        function updateAvailableCategoriesForNewRow(unitNameInput) {
            const newRow = unitNameInput.closest('tr');
            if (!newRow || !newRow.classList.contains('editable-row')) return;

            const categorySelect = newRow.querySelector('select[name="category"]');
            const currentUnitName = unitNameInput.value.trim();
            const previouslySelectedCategory = categorySelect.value;

            // Define all potentially available categories (system + scoped custom)
            let allPotentialCategories = new Set([...BASE_CATEGORIES]);
            const scopedCustomCategories = getScopedCustomCategories(); // Custom categories visible to the current user
            scopedCustomCategories.forEach(customCat => allPotentialCategories.add(customCat.name));

            let categoriesToDisplay = new Set(allPotentialCategories); // Start with all potential categories

            if (currentUnitName) { // Only filter if a unit name is present
                // Determine the corporate and regional context for the entered unit (currentUnitName)
                // This helps ensure the filtering is specific to the correct instance of the unit.
                let unitCorporateContext = null;
                let unitRegionalContext = null;

                // If the current user is 'Unit' scoped and entering their own unit name, use their context.
                if (currentUser.role === 'Unit' && currentUser.unitName && currentUser.unitName.toLowerCase() === currentUnitName.toLowerCase()) {
                    unitCorporateContext = currentUser.corporateName;
                    unitRegionalContext = currentUser.regionalName;
                } else {
                    // For other roles, or if typing a different unit name, try to find the context from existing data.
                    // This finds the first (preferably active) item matching the unit name to derive its context.
                    const representativeItem = allLicenseData.find(item =>
                        item.unitName && item.unitName.toLowerCase() === currentUnitName.toLowerCase() && item.isActive
                    ) || allLicenseData.find(item => // Fallback to any item if no active one found
                        item.unitName && item.unitName.toLowerCase() === currentUnitName.toLowerCase()
                    );

                    if (representativeItem) {
                        unitCorporateContext = representativeItem.corporate;
                        unitRegionalContext = representativeItem.regional;
                    }
                    // If no representativeItem is found (e.g., completely new unit name not in allLicenseData),
                    // unitCorporateContext and unitRegionalContext will remain null.
                    // In this case, activeCategoriesForUnit will be empty, and allPotentialCategories will be shown.
                }

                const activeCategoriesForThisUnit = new Set();
                allLicenseData.forEach(item => {
                    if (
                        item.unitName && item.unitName.toLowerCase() === currentUnitName.toLowerCase() &&
                        item.category !== 'Others' && // "Others" is exempt from being hidden by this rule
                        item.isActive === true &&
                        // Apply corporate/regional context to ensure we're checking the correct unit instance
                        // If context is null (e.g. new unit), these checks effectively pass for items without corp/region or allow broader match
                        (unitCorporateContext === null || item.corporate === unitCorporateContext) &&
                        (unitRegionalContext === null || item.regional === unitRegionalContext)
                    ) {
                        activeCategoriesForThisUnit.add(item.category);
                    }
                });

                // Filter: show categories that are NOT active for this unit, or are "Others"
                categoriesToDisplay = new Set(
                    [...allPotentialCategories].filter(cat => cat === 'Others' || !activeCategoriesForThisUnit.has(cat))
                );
            }
            // Ensure "Others" is definitely in the list if it was in potential categories
            if (allPotentialCategories.has('Others')) {
                 categoriesToDisplay.add('Others');
            }


            // Populate the dropdown with the filtered categories
            categorySelect.innerHTML = ''; // Clear existing options

            let placeholderOption = document.createElement('option');
            placeholderOption.value = "";
            placeholderOption.textContent = "-- Select Category (Required) --";
            placeholderOption.disabled = true;
            // Select placeholder if previouslySelectedCategory is empty or no longer in the available list
            placeholderOption.selected = !previouslySelectedCategory || !categoriesToDisplay.has(previouslySelectedCategory);
            categorySelect.appendChild(placeholderOption);

            // Sort categories for display. "Others" is often preferred last.
            let sortedDisplayCategories = Array.from(categoriesToDisplay).sort((a, b) => {
                if (a === 'Others') return 1; // Puts "Others" at/near the end
                if (b === 'Others') return -1;
                return a.localeCompare(b); // Alphabetical for others
            });

            sortedDisplayCategories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                categorySelect.appendChild(option);
            });

            // Try to re-select the previously selected category if it's still available
            if (previouslySelectedCategory && categoriesToDisplay.has(previouslySelectedCategory)) {
                categorySelect.value = previouslySelectedCategory;
            } else if (categorySelect.options.length > 0 && categorySelect.options[0].value === "") {
                // If the old selection is no longer valid, and placeholder exists, ensure it's selected.
                categorySelect.selectedIndex = 0;
            }

            handleCategoryChange(categorySelect); // Update "Other Category Name" input visibility
        }
        // --- END MODIFICATION BLOCK ---


         function addNewLicense(){
            const tB = document.getElementById('fssaiTableBody');
            if (tB.querySelector('.editable-row')) {
                alert('Please save or cancel the current new license entry before adding another.');
                return;
            }
            const nR = tB.insertRow(0);
            nR.classList.add('editable-row');
            let unitNameValue = (currentUser.role === 'Unit') ? currentUser.unitName : '';
            let unitNameDisabled = (currentUser.role === 'Unit') ? 'disabled' : '';
            let uNIHTML = `<input type="text" class="form-control form-control-sm" value="<?= Auth::user()->company_name ?>" name="unitName"  placeholder="Unit Name (Required)" oninput="updateAvailableCategoriesForNewRow(this)">`;
            const cSHTML = `<div>
                                <select class="form-select form-select-sm" name="category" onchange="handleCategoryChange(this)"></select>
                                <div class="other-category-name-input-wrapper d-none mt-1">
                                    <input type="text" class="form-control form-control-sm" name="otherCategoryName" placeholder="Specify Other Name (Required)">
                                </div>
                            </div>`;
            const lTO = ['NA', 'Registration', 'State', 'Central'];
            let lTSHTML = '<select class="form-select form-select-sm" name="licenseType" disabled>';
            lTO.forEach(o => lTSHTML += `<option value="${o}" ${o === 'NA' ? 'selected' : ''}>${o}</option>`);
            lTSHTML += '</select>';
            nR.insertCell().textContent = '*';
            nR.insertCell().innerHTML = uNIHTML;
            nR.insertCell().innerHTML = cSHTML;
            nR.insertCell().innerHTML = '<input type="text" class="form-control form-control-sm" placeholder="License No (Required)" name="licenseNo">';
            nR.insertCell().innerHTML = '<input type="date" class="form-control form-control-sm" name="expiryDate" title="Expiry Date (Required)">';
            nR.insertCell().innerHTML = lTSHTML;
            nR.insertCell().innerHTML = `<div class="file-upload"><i class="fas fa-cloud-upload-alt me-1"></i>Upload<input type="file" onchange="handleNewLicenseUpload(this)" class="certificate-input" accept=".pdf,.jpg,.jpeg,.png" name="certificate"></div><span class="uploaded-file"></span>`;
            nR.insertCell().innerHTML = getStatusBadge('Active', true);
            nR.insertCell().innerHTML = `<div class="action-buttons-wrapper">
                                            <div class="action-btns">
                                                <button class="btn btn-sm btn-success btn-save" onclick="saveNewLicense(this)"><i class="fas fa-save me-1"></i>Save</button>
                                                <button class="btn btn-sm btn-danger btn-cancel" onclick="cancelNewLicense(this)"><i class="fas fa-times me-1"></i>Cancel</button>
                                            </div>
                                        </div>`;
            const nUNI = nR.querySelector('input[name="unitName"]');
            if (nUNI) updateAvailableCategoriesForNewRow(nUNI);
            nR.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

function saveNewLicense(btn) {
    const r = btn.closest('tr'),
        inps = r.querySelectorAll('input[name], select[name]'),
        formData = new FormData();

    let isV = true,
        licNo = '',
        expD = '',
        aTO = false,
        nD = {
            slNo: 0,
            isActive: true
        };

    inps.forEach(i => {
        const n = i.name,
              v = i.value;

        i.classList.remove('is-invalid');

        if (i.tagName === 'SELECT' && !v && n === 'category') {
            i.classList.add('is-invalid');
            isV = false;
        } else if (n === 'otherCategoryName') {
            if (r.querySelector('select[name="category"]').value === 'Others') {
                if (!v.trim()) {
                    i.classList.add('is-invalid');
                    isV = false;
                    aTO = true;
                }
                formData.append(n, v.trim());
                nD[n] = v.trim();
            }
        } else if (i.type !== 'file' && !v.trim() && ['licenseNo', 'expiryDate', 'unitName'].includes(n) && !i.disabled) {
            i.classList.add('is-invalid');
            isV = false;
        } else if (i.type !== 'file') {
            formData.append(n, v.trim());
            nD[n] = v.trim();
        }

        if (n === 'licenseNo') licNo = v.trim();
        if (n === 'expiryDate') expD = v;
    });

    // ✅ Append file from `.certificate-input`
    const fileInput = r.querySelector('.certificate-input');
    if (fileInput && fileInput.files.length > 0) {
        formData.append('certificate', fileInput.files[0]);
    }

    // License type validation
    if (nD.category === 'License' && (!nD.licenseType || nD.licenseType === 'NA')) {
        const lTSel = r.querySelector('select[name="licenseType"]');
        if (lTSel && !lTSel.disabled) {
            lTSel.classList.add('is-invalid');
            isV = false;
        }
    } else if (nD.category !== 'License') {
        nD.licenseType = 'NA';
        formData.append('licenseType', 'NA');
    }

    if (!isV) {
        let m = 'Please fill all required fields: ',
            rF = [];
        if (r.querySelector('select[name="category"].is-invalid')) rF.push('Category');
        if (r.querySelector('input[name="licenseNo"].is-invalid')) rF.push('License No');
        if (r.querySelector('input[name="expiryDate"].is-invalid')) rF.push('Expiry Date');
        if (r.querySelector('select[name="licenseType"].is-invalid')) rF.push('License Type');
        if (aTO) rF.push('Other Category Name');
        alert(m + rF.join(', ') + '.');
        return;
    }

    if (!licNo) {
        alert('License Number cannot be empty.');
        r.querySelector('input[name="licenseNo"]').classList.add('is-invalid');
        return;
    }

    if (findDataIndexByLicenseNo(licNo) !== -1) {
        alert(`License with number ${licNo} already exists.`);
        r.querySelector('input[name="licenseNo"]').classList.add('is-invalid');
        return;
    }

    nD.status = updateStatusBasedOnDate(expD, 'Active');
    nD.slNo = Math.max(0, ...allLicenseData.map(d => d.slNo)) + 1;
    formData.append('slNo', nD.slNo);
    formData.append('status', nD.status);
    formData.append('isActive', '1');

    allLicenseData.unshift(nD);
    initializeUserScope();

    let hD = `Category: ${nD.category}`;
    if (nD.category === 'Others' && nD.otherCategoryName) hD += ` (${nD.otherCategoryName})`;
    hD += `, Type: ${nD.licenseType}, Exp: ${expD}`;

    addHistoryEntry(licNo, 'License Created', hD, 'User');

    alert('New license added successfully.');

    // ✅ Use FormData (don't set content-type manually!)
    fetch("{{ route('lincesupload') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();

           // alert('License submitted to server successfully!');
            
        } else {
            
            
            alert('Server error: ' + (data.message || 'Unknown issue'));
        }
    })
    .catch(error => {
        console.error('Submission error:', error);
        alert('Error submitting license to the server.');
    });
}

        function cancelNewLicense(btn){btn.closest('tr').remove();}
        function downloadCSV(csv,fName){const cF=new Blob(["\uFEFF"+csv],{type:"text/csv;charset=utf-8;"}),dL=document.createElement("a");dL.download=fName;dL.href=window.URL.createObjectURL(cF);dL.style.display="none";document.body.appendChild(dL);dL.click();document.body.removeChild(dL);}
        function exportTableToCSV(fName){const csv=[],h=['SL No','Corporate','Regional','Unit Name','Category','Other Category Detail','License No','Expiry Date','License Type','License Copy File','Status','Is Active'];csv.push(h.join(","));const d=filteredLicenseData;if(d.length===0){alert("No data to export.");return;}d.forEach((i,idx)=>{const rD=[];rD.push(`"${idx+1}"`);rD.push(`"${i.corporate?.replace(/"/g,'""')||''}"`);rD.push(`"${i.regional?.replace(/"/g,'""')||''}"`);rD.push(`"${i.unitName?.replace(/"/g,'""')||''}"`);rD.push(`"${i.category?.replace(/"/g,'""')||''}"`);rD.push(`"${(i.category==='Others'&&i.otherCategoryName)?i.otherCategoryName.replace(/"/g,'""'):''}"`);rD.push(`"${i.licenseNo?.replace(/"/g,'""')||''}"`);rD.push(`"${i.expiryDate||''}"`);rD.push(`"${i.licenseType?.replace(/"/g,'""')||''}"`);rD.push(`"${i.licenseCopy?i.licenseCopy.replace(/"/g,'""'):'No'}"`);const dS=i.isActive===false?'Deactivated':(i.status||'');rD.push(`"${dS.replace(/"/g,'""')}"`);rD.push(`"${i.isActive?'Yes':'No'}"`);csv.push(rD.join(","));});downloadCSV(csv.join("\n"),fName);addHistoryEntry('SYSTEM','Export',`Exported ${d.length} records.`,'User');}

        // --- START: IDENTIFY CHANGES (New Custom Category Functions) ---
        function populateCustomCategoryScopeSelector() {
            const wrapper = document.getElementById('customCategoryScopeWrapper');
            const nameInput = document.getElementById('newCustomCategoryName');
            const addButton = document.querySelector('#categoryManagementSection button[onclick="addNewCustomCategory()"]');

            if (!wrapper || !nameInput || !addButton) return;
            wrapper.innerHTML = '';

            if (currentUser.role === 'Super Admin') {
                let optionsHTML = `<label for="customCategoryScope" class="form-label">Scope</label>
                                <select id="customCategoryScope" class="form-select form-select-sm">
                                    <option value="Super Admin" selected>Global (All Users)</option>`;
                const corporates = [...new Set(allLicenseData.map(item => item.corporate).filter(Boolean))].sort();
                corporates.forEach(corp => {
                    optionsHTML += `<option value="Corporate_${corp}">${corp}</option>`;
                });
                optionsHTML += `</select>`;
                wrapper.innerHTML = optionsHTML;
                nameInput.disabled = false;
                addButton.disabled = false;
            } else if (currentUser.role === 'Corporate') {
                wrapper.innerHTML = `<input type="hidden" id="customCategoryScope" value="Corporate_${currentUser.corporateName}">
                                    <p class="form-control-plaintext ps-0 small text-muted mb-0 pb-2">Scope: ${currentUser.corporateName} (Corporate)</p>`;
                nameInput.disabled = false;
                addButton.disabled = false;
            } else if (currentUser.role === 'Regional') {
                wrapper.innerHTML = `<input type="hidden" id="customCategoryScope" value="Regional_${currentUser.corporateName}_${currentUser.regionalName}">
                                    <p class="form-control-plaintext ps-0 small text-muted mb-0 pb-2">Scope: ${currentUser.regionalName} (${currentUser.corporateName})</p>`;
                nameInput.disabled = false;
                addButton.disabled = false;
            } else {
                wrapper.innerHTML = '<p class="small text-muted mb-0 pb-2">Category creation not available for Unit role.</p>';
                nameInput.disabled = true;
                addButton.disabled = true;
            }
        }

        function getScopedCustomCategories() {
            let visibleCategories = [];
            // Assuming customCategoriesData is populated from your backend or defined elsewhere
            // Example: customCategoriesData = [{name: "Water Test", scope: "Super Admin"}, {name: "Pest Control Cert", scope: "Corporate_IHCL"}];
            
            visibleCategories.push(...customCategoriesData.filter(cat => cat.scope === 'Super Admin'));

            if (currentUser.role === 'Corporate' || currentUser.role === 'Regional' || currentUser.role === 'Unit') {
                if(currentUser.corporateName) {
                    visibleCategories.push(...customCategoriesData.filter(cat => cat.scope === `Corporate_${currentUser.corporateName}`));
                }
            }
            if (currentUser.role === 'Regional' || currentUser.role === 'Unit') {
                if(currentUser.corporateName && currentUser.regionalName) {
                    visibleCategories.push(...customCategoriesData.filter(cat => cat.scope === `Regional_${currentUser.corporateName}_${currentUser.regionalName}`));
                }
            }
            // Remove duplicates by name, preferring more specific scopes if names clash (though ideally names are unique or namespacing is used)
            return [...new Map(visibleCategories.map(item => [item.name, item])).values()];
        }

       function displayCustomCategories() {
    const listElement = document.getElementById('customCategoryList');
    const scopeInfoEl = document.getElementById('customCategoryListScope');
    if (!listElement || !scopeInfoEl) return;

    scopeInfoEl.textContent = "Custom Category List";

    listElement.innerHTML = '';

    if (!customCategoriesData || customCategoriesData.length === 0) {
        listElement.innerHTML = '<li class="list-group-item text-muted">No custom categories available.</li>';
        return;
    }

    customCategoriesData.sort((a, b) => a.name.localeCompare(b.name)).forEach(cat => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';

        // Static Global badge
        const scopeBadge = `<span class="badge bg-primary rounded-pill">Global</span>`;

        li.innerHTML = `
            ${cat.name} ${scopeBadge}
            <a class="btn btn-sm btn-outline-danger py-0 px-1" href="/custom-category/delete/${cat.id}" onclick="return confirm('Are you sure you want to delete this item?');">
                <i class="fas fa-times"></i>
            </a>
        `;

        listElement.appendChild(li);
    });
}

// Call the function after DOM is loaded
document.addEventListener('DOMContentLoaded', displayCustomCategories);


        function addNewCustomCategory() {
            const nameInput = document.getElementById('newCustomCategoryName');
            const categoryName = nameInput.value.trim();
            if (!categoryName) {
                alert("Category name cannot be empty.");
                nameInput.classList.add('is-invalid');
                return;
            }

            
               document.getElementById('customCategoryForm').submit();
        }

        function deleteCustomCategory(categoryName, categoryScope) {
            // Check if category is in use
            const isInUse = allLicenseData.some(item => item.category === categoryName &&
                ( // This scope check for deletion is simplified; a real app would need robust checks
                  categoryScope === "Super Admin" ||
                  (categoryScope.startsWith("Corporate_") && item.corporate === categoryScope.split("_")[1]) ||
                  (categoryScope.startsWith("Regional_") && item.corporate === categoryScope.split("_")[1] && item.regional === categoryScope.split("_")[2])
                )
            );

            if (isInUse) {
                alert(`Cannot delete category "${categoryName}" as it is currently in use by one or more licenses.`);
                return;
            }

            if (!confirm(`Are you sure you want to delete the custom category "${categoryName}" for scope "${categoryScope}"?`)) return;

            customCategoriesData = customCategoriesData.filter(cat => !(cat.name === categoryName && cat.scope === categoryScope));
            addHistoryEntry('SYSTEM', 'Custom Category Deleted', `Category: ${categoryName}, Scope: ${categoryScope}`, currentUser.role);
            alert(`Custom category "${categoryName}" deleted.`);
            displayCustomCategories();
            initializeUserScope();
        }
        // --- END: IDENTIFY CHANGES ---

        document.addEventListener('DOMContentLoaded',()=>{
            tooltipTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipList=tooltipTriggerList.map(el=>new bootstrap.Tooltip(el));

            documentModal=new bootstrap.Modal(document.getElementById('documentModal'));
            renewModal=new bootstrap.Modal(document.getElementById('renewModal'));
            historyModal=new bootstrap.Modal(document.getElementById('historyModal'));
            scheduleModalInstance = new bootstrap.Modal(document.getElementById('scheduleModal'));
            mobileFilterModalInstance=new bootstrap.Modal(document.getElementById('mobileFilterModal'));

            initializeStatuses();
            
            
            <?php
        $role = Auth::user()->is_role;
        $company = Auth::user()->company_name;
    ?>

            <?php if ($role == '2'): ?>
        
        setCurrentUser('Corporate', '<?= Auth::user()->company_name ?>', 'Jaipur & Ajmer', '<?= Auth::user()->company_name ?>');
    <?php elseif ($role == '3'): ?>
        
            setCurrentUser('Unit', 'IHCL', 'Jaipur &amp; Ajmer', '<?= Auth::user()->company_name ?>'); // --- MODIFICATION: Set specific user for testing
    <?php elseif ($role == '1'): ?>
        
        
                    setCurrentUser('Regional', 'IHCL', 'Jaipur &amp; Ajmer', '<?= Auth::user()->company_name ?>'); // --- MODIFICATION: Set specific user for testingting


    <?php else: ?>
         setCurrentUser('Super Admin', '<?= Auth::user()->company_name ?>', '<?= Auth::user()->company_name ?>', '<?= Auth::user()->company_name ?>');
    <?php endif; ?>
    
    
    
            // setCurrentUser('Super Admin'); // Original call

            setupEventListeners();
            addHistoryEntry('SYSTEM','System Init',`Dashboard Initialized for ${currentUser.role} ${currentUser.corporateName||''}`,'System');
        });

        function handleResize(){
            const isM = isMobileView();
            const aNB = document.getElementById('addNewButton');
            if(aNB){
                // --- MODIFICATION: Allow 'Add New' for Super Admin and Corporate as well on desktop
                if((currentUser.role==='Unit' || currentUser.role === 'Super Admin' || currentUser.role === 'Corporate') && !isM) {
                    aNB.style.display='inline-block';
                } else {
                    aNB.style.display='none';
                }
            }

            const currentRowsPerPageValue = document.getElementById('rowsPerPageSelectDesktop')?.value || document.getElementById('rowsPerPageSelectMobile')?.value || rowsPerPage;
            rowsPerPage = parseInt(currentRowsPerPageValue, 10);
            if (document.getElementById('rowsPerPageSelectDesktop')) document.getElementById('rowsPerPageSelectDesktop').value = rowsPerPage;
            if (document.getElementById('rowsPerPageSelectMobile')) document.getElementById('rowsPerPageSelectMobile').value = rowsPerPage;

            renderTablePage(currentPage);

            tooltipList.forEach(tooltip => tooltip.dispose());
            tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], .action-buttons-wrapper [title], .scheduled-info-badge[title]'));
            tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        window.addEventListener('resize',handleResize);
    </script>
   