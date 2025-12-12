@extends('layouts.app', ['pagetitle'=>'Dashboard'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }
        
        h1 {
    color: #fff !important;
}
        
        .dashboard-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }
        
        .card-header {
            background-color: var(--primary-color) !important;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pass {
            background-color: rgba(39, 174, 96, 0.2);
            color: var(--success-color);
        }
        
        .status-fail {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger-color);
        }
        
        .status-pending {
            background-color: rgba(241, 196, 15, 0.2);
            color: var(--warning-color);
        }
        
        .status-draft {
            background-color: rgba(52, 152, 219, 0.2);
            color: var(--secondary-color);
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .nav-pills .nav-link {
            color: var(--primary-color);
        }
        
        .data-table th {
            background-color: var(--light-color);
            font-weight: 600;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        .progress-bar {
            background-color: var(--secondary-color);
        }
        
        .filter-section {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        .summary-card {
            text-align: center;
            padding: 15px;
            border-left: 4px solid var(--secondary-color);
        }
        
        .summary-card .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .summary-card .label {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            margin-right: 3px;
        }
        
        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .test-result-value {
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .test-result-pass {
            color: var(--success-color);
        }
        
        .test-result-fail {
            color: var(--danger-color);
        }

        /* Style for editable rows */
        .editable-row input,
        .editable-row select {
            width: 100%;
            padding: 0.25rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }

        .editable-row input:focus,
        .editable-row select:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .editable-row .form-control-sm {
            min-height: calc(1.5em + 0.5rem + 2px);
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }

        .editable-row .form-select-sm {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            padding-left: 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }

        /* PDF preview styles */
        .pdf-preview-container {
            margin-top: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            display: none;
        }

        .pdf-preview {
            width: 100%;
            height: 300px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .pdf-info {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .pdf-remove {
            color: #dc3545;
            cursor: pointer;
            margin-left: 10px;
        }

        /* Draft badge style */
        .draft-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
        }

        /* Highlight draft rows */
        .table-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }
        
        
        /* Main Tab Interface Styles */
        body.main-tab-interface {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        .tabs-container-main { /* Renamed to avoid conflict with FSSAI's .container */
            max-width: 95%; /* Wider to accommodate FSSAI content */
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
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


        /* FSSAI specific global styles - these might conflict or affect other tabs if not scoped */
        #panel-license :root { /* This won't work as expected when embedded. Define vars directly or scope. */
            --primary-color: #2c5f9e;
            --primary-light: #e1eaf2;
            --secondary-color: #f58220;
            --success-color: #28a745;
            --warning-color: #ffc107;
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
        /* More specific selector for FSSAI container if :root causes issues */
        #panel-license .fssai-container-embed {
            --primary-color: #2c5f9e;
            --primary-light: #e1eaf2;
            --secondary-color: #f58220;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --border-color: #dee2e6;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;

            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white; /* FSSAI page's container background */
            color: #495057;
            line-height: 1.6;
            padding-top: 0px; /* Let FSSAI container handle this */
            max-width: 100%; /* Override FSSAI's max-width if needed */
            /* background-color: white; /* Overridden by .tabs-container-main? */
            border-radius: 0; /* FSSAI content is inside tab, remove its rounding */
            box-shadow: none; /* Remove FSSAI container shadow, tab container has it */
            padding: 25px;
            margin-bottom: 0px; /* No bottom margin inside tab */
        }


        #panel-license .fssai-container-embed h1,
        #panel-license .fssai-container-embed h2,
        #panel-license .fssai-container-embed h3,
        #panel-license .fssai-container-embed h4,
        #panel-license .fssai-container-embed h5,
        #panel-license .fssai-container-embed h6 {
            color: var(--dark-color, #343a40); /* Use fallback if var not defined */
            font-weight: 600;
        }

        #panel-license .page-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color, #dee2e6);
        }

        #panel-license .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        #panel-license .dashboard-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: var(--shadow-sm, 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075));
            border-left: 4px solid transparent;
            transition: var(--transition, all 0.3s ease);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        #panel-license .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md, 0 0.5rem 1rem rgba(0, 0, 0, 0.15));
        }

        #panel-license .dashboard-card-green { border-left-color: var(--success-color, #28a745); }
        #panel-license .dashboard-card-orange { border-left-color: var(--warning-color, #ffc107); }
        #panel-license .dashboard-card-blue { border-left-color: var(--info-color, #17a2b8); }
        #panel-license .dashboard-card-red { border-left-color: var(--danger-color, #dc3545); }
        #panel-license .dashboard-card-gray { border-left-color: var(--gray-color, #6c757d); }


        #panel-license .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color, #343a40);
            margin-bottom: 15px;
        }

        #panel-license .card-status-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        #panel-license .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        #panel-license .status-compliant {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color, #28a745);
        }

        #panel-license .status-due-soon {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color, #ffc107);
        }

        #panel-license .status-expired {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color, #dc3545);
        }
         #panel-license .status-pending { /* This class name is duplicated, ensure proper usage */
            background-color: rgba(23, 162, 184, 0.1);
            color: var(--info-color, #17a2b8);
         }

        #panel-license .due-date {
            font-size: 0.85rem;
            color: var(--gray-color, #6c757d);
        }

        #panel-license .progress-container {
            margin-bottom: 10px;
        }

        #panel-license .progress-bar {
            background-color: #e9ecef;
            border-radius: 5px;
            height: 8px;
            overflow: hidden;
        }

        #panel-license .progress-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.5s ease-in-out;
        }

        #panel-license .progress-fill-green { background-color: var(--success-color, #28a745); }
        #panel-license .progress-fill-orange { background-color: var(--warning-color, #ffc107); }
        #panel-license .progress-fill-blue { background-color: var(--info-color, #17a2b8); }
        #panel-license .progress-fill-red { background-color: var(--danger-color, #dc3545); }


        #panel-license .card-info-row {
            display: flex;
            justify-content: flex-end;
            font-size: 0.85rem;
            color: var(--gray-color, #6c757d);
            margin-bottom: 15px;
        }

        /* ====== TABLE STYLES ====== */
        #panel-license .table-section {
            margin-top: 30px;
        }

        #panel-license .table-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }

        #panel-license .table-responsive {
            border-radius: 8px;
            overflow-x: auto;
            box-shadow: var(--shadow-sm, 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075));
        }

        #panel-license .table {
            margin-bottom: 0;
            min-width: 1200px;
        }

        #panel-license .table th {
            background-color: var(--primary-color, #2c5f9e);
            color: white;
            font-weight: 500;
            padding: 12px 15px;
            vertical-align: middle;
            white-space: nowrap;
            position: relative;
        }

        #panel-license .table td {
            padding: 12px 15px;
            vertical-align: middle;
             white-space: nowrap;
        }
         #panel-license .table td:nth-child(2),
         #panel-license .table td:nth-child(9)
         {
            white-space: normal;
         }


        #panel-license,#ingredients-block .table tr:hover {
            background-color: rgba(44, 95, 158, 0.03);
        }

        #panel-license .editable-row {
            background-color: #fffde7 !important;
        }
         #panel-license .editable-row input.is-invalid,
         #panel-license .editable-row select.is-invalid {
            border-color: var(--danger-color, #dc3545);
         }

         #panel-license .table tr.has-draft {
             background-color: #fffde7 !important;
             font-style: italic;
         }
         #panel-license .table tr.has-draft:hover {
              background-color: #fffacd !important;
         }

        /* ====== STATUS BADGES ====== */
        #panel-license .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        #panel-license .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color, #28a745);
        }

        /* This class name is duplicated in your original CSS for .status-badge and .status.
           Ensure the correct one is targeted or combine them if they are the same.
           I'll assume they are meant for the table status here. */
        #panel-license .table .status-pending {
            background-color: rgba(23, 162, 184, 0.1);
            color: var(--info-color, #17a2b8);
        }

        #panel-license .status-expired { /* Also duplicated, assuming table context */
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color, #dc3545);
        }


        /* ====== FILE UPLOAD & DOCUMENT PREVIEW ====== */
        #panel-license .file-upload {
            position: relative;
            display: inline-block;
            padding: 8px 16px;
            background-color: var(--light-color, #f8f9fa);
            border: 1px dashed var(--border-color, #dee2e6);
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition, all 0.3s ease);
            font-size: 0.85rem;
        }

        #panel-license .file-upload:hover {
            background-color: #e9ecef;
            border-color: var(--gray-color, #6c757d);
        }

        #panel-license .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        #panel-license .uploaded-file {
            font-size: 0.8rem;
            color: var(--success-color, #28a745);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        #panel-license .document-preview {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition, all 0.3s ease);
            max-width: 200px;
            min-width: 150px;
        }

        #panel-license .document-preview:hover {
            background-color: #e9ecef;
        }

        #panel-license .document-icon {
            /* color: var(--danger-color); /* General - overridden below */
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        #panel-license .document-icon.fa-file-pdf { color: #e74c3c; }
        #panel-license .document-icon.fa-file-image { color: #3498db; }
        #panel-license .document-icon.fa-file-word { color: #2b579a; }
        #panel-license .document-icon.fa-file-excel { color: #217346; }
        #panel-license .document-icon.fa-file:not(.fa-file-pdf):not(.fa-file-image):not(.fa-file-word):not(.fa-file-excel) { color: var(--gray-color, #6c757d); }


        #panel-license .document-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
        }

        /* ====== BUTTON STYLES ====== */
        /* Bootstrap handles .btn, these are custom variants */
        #panel-license .btn-renew {
            background-color: var(--success-color, #28a745);
            color: white;
        }
        #panel-license .btn-renew:hover { background-color: #218838; color: white; }

        #panel-license .btn-history {
            background-color: var(--info-color, #17a2b8);
            color: white;
        }
        #panel-license .btn-history:hover { background-color: #138496; color: white; }

        #panel-license .btn-save {
            background-color: var(--success-color, #28a745);
            color: white;
        }
        #panel-license .btn-save:hover { background-color: #218838; color: white; }

        #panel-license .btn-cancel {
            background-color: var(--danger-color, #dc3545);
            color: white;
        }
        #panel-license .btn-cancel:hover { background-color: #c82333; color: white; }

        #panel-license .btn-view {
            background-color: var(--primary-color, #2c5f9e);
            color: white;
        }
        #panel-license .btn-view:hover { background-color: #1f4b85; color: white; }

        #panel-license .btn-schedule {
            background-color: var(--warning-color, #ffc107);
            color: var(--dark-color, #343a40);
        }
        #panel-license .btn-schedule:hover { background-color: #e0a800; color: var(--dark-color, #343a40); }

        #panel-license .btn-download {
            background-color: var(--gray-color, #6c757d);
            color: white;
        }
        #panel-license .btn-download:hover { background-color: #5a6268; color: white; }

         #panel-license #submitDraftsButton:disabled {
             cursor: not-allowed;
             opacity: 0.65;
         }

        /* ====== ACTION BUTTONS IN TABLE ====== */
        #panel-license .action-btns {
            display: flex;
            flex-wrap: nowrap;
            gap: 6px;
        }

        /* ====== MODAL STYLES ====== */
        /* Bootstrap handles .modal-content, .modal-body, etc. */
        #panel-license .modal-header {
            background-color: var(--primary-color, #2c5f9e);
            color: white;
            padding: 15px 20px;
        }
         #panel-license .modal-header .btn-close {
             filter: brightness(0) invert(1);
         }

        #panel-license .modal-title {
            font-weight: 600;
        }


        /* ====== PAGINATION STYLES ====== */
        #panel-license .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-top: 20px;
            border-top: 1px solid var(--border-color, #dee2e6);
            flex-wrap: wrap;
        }
        /* Bootstrap handles .page-item, .page-link styling mostly */
        #panel-license .pagination-controls .page-item.active .page-link {
            background-color: var(--primary-color, #2c5f9e);
            border-color: var(--primary-color, #2c5f9e);
        }
        #panel-license .pagination-controls .page-link {
            color: var(--primary-color, #2c5f9e);
        }
        #panel-license .pagination-controls .page-link:hover {
            color: #0a58ca; /* Bootstrap's default link hover */
        }

        #panel-license .rows-per-page-select {
            width: auto;
            display: inline-block;
            margin-left: 10px;
        }
         #panel-license .pagination-info {
             font-size: 0.9rem;
             color: var(--gray-color, #6c757d);
             margin-bottom: 10px;
         }
         #panel-license .pagination-nav {
             margin-bottom: 10px;
         }


        /* ====== UTILITY CLASSES ====== */
        #panel-license .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ====== TABLE HEADER FILTER STYLES ====== */
        #panel-license .th-filterable {
             position: relative;
        }

        #panel-license .th-content-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #panel-license .th-filter-icon {
            margin-left: 8px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 0.9em;
        }
         #panel-license .th-filter-icon:hover {
             color: white;
         }

        #panel-license .th-filter-icon.active {
            color: white;
        }

        #panel-license .th-filter-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1050; /* Ensure above Bootstrap components */
            min-width: 250px;
            background-color: #fff;
            border: 1px solid var(--border-color, #dee2e6);
            border-radius: 4px;
            box-shadow: var(--shadow-md, 0 0.5rem 1rem rgba(0, 0, 0, 0.15));
            color: var(--dark-color, #343a40);
            font-weight: normal;
            font-size: 14px;
            text-align: left;
            white-space: normal;
        }

        #panel-license .th-filter-dropdown[data-column-key="category"] .filter-search,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .filter-search,
        #panel-license .th-filter-dropdown[data-column-key="status"] .filter-search {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .filter-search input[type="text"],
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .filter-search input[type="text"],
        #panel-license .th-filter-dropdown[data-column-key="status"] .filter-search input[type="text"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 13px;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-container,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-container,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-container {
            max-height: 180px;
            overflow-y: auto;
            border: 1px solid #ccc;
            margin: 10px;
            border-radius: 4px;
            position: relative;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-list,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-list,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-list li,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-list li,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-list li {
            padding: 6px 10px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.2s ease;
            white-space: normal;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-list li:hover,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-list li:hover,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-list li:hover {
            background-color: #f0f0f0;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-list input[type="checkbox"],
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-list input[type="checkbox"],
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-list input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer;
            width: 14px;
            height: 14px;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-list label,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-list label,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-list label {
            font-size: 13px;
            color: #333;
            flex-grow: 1;
            cursor: pointer;
            margin-bottom: 0;
            font-weight: normal;
        }

        #panel-license .th-filter-dropdown .filter-actions {
            padding: 8px 10px;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        #panel-license .th-filter-dropdown .filter-actions .btn {
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
        }
        #panel-license .th-filter-dropdown .filter-actions .btn-apply {
            background-color: #3498db; /* FSSAI specific color */
            color: white;
            border: none;
        }
        #panel-license .th-filter-dropdown .filter-actions .btn-apply:hover {
            background-color: #2980b9;
        }
        #panel-license .th-filter-dropdown .filter-actions .btn-clear {
            background-color: #ecf0f1;
            color: #333;
            border: 1px solid #bdc3c7;
        }
        #panel-license .th-filter-dropdown .filter-actions .btn-clear:hover {
            background-color: #dde1e2;
        }

        #panel-license .th-filter-dropdown[data-column-key="category"] .options-container::-webkit-scrollbar,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-container::-webkit-scrollbar,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-container::-webkit-scrollbar {
          width: 10px;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-container::-webkit-scrollbar-track,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-container::-webkit-scrollbar-track,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-container::-webkit-scrollbar-track {
          background: #f1f1f1;
           border-radius: 4px;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-container::-webkit-scrollbar-thumb,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-container::-webkit-scrollbar-thumb,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-container::-webkit-scrollbar-thumb {
          background: #aaa;
          border-radius: 5px;
          border: 2px solid #f1f1f1;
        }
        #panel-license .th-filter-dropdown[data-column-key="category"] .options-container::-webkit-scrollbar-thumb:hover,
        #panel-license .th-filter-dropdown[data-column-key="licenseType"] .options-container::-webkit-scrollbar-thumb:hover,
        #panel-license .th-filter-dropdown[data-column-key="status"] .options-container::-webkit-scrollbar-thumb:hover {
          background: #777;
        }

        #panel-license .unit-hierarchy-filter-dropdown .hierarchical-filter-content {
            padding: 15px;
            min-width: 250px;
        }
        #panel-license .unit-hierarchy-filter-dropdown .filter-group {
            margin-bottom: 15px;
        }
        #panel-license .unit-hierarchy-filter-dropdown .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85em;
            font-weight: 600;
            color: #4a5568;
        }
        #panel-license .unit-hierarchy-filter-dropdown .select-wrapper {
            position: relative;
        }
        #panel-license .unit-hierarchy-filter-dropdown select {
            width: 100%;
            padding: 8px 30px 8px 12px;
            font-size: 0.9em;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #495057;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%236c757d" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 18px;
        }
        #panel-license .unit-hierarchy-filter-dropdown .corporate-wrapper select {
            border: 2px solid #000;
            background-color: #fff;
            font-weight: 500;
        }
        #panel-license .unit-hierarchy-filter-dropdown select:focus {
            outline: none;
            border-color: #3b82f6; /* FSSAI specific */
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        #panel-license .unit-hierarchy-filter-dropdown .button-group.filter-actions {
            margin-top: 15px;
            margin-left: -15px;
            margin-right: -15px;
            margin-bottom: -15px;
            padding-left: 15px;
            padding-right: 15px;
            padding-bottom: 10px;
        }

        #panel-license .th-filter-dropdown[data-column-key="licenseNo"] .filter-content-padding,
        #panel-license .th-filter-dropdown[data-column-key="expiryDate"] .filter-content-padding {
             padding: 10px 15px;
        }
        #panel-license .th-filter-dropdown .date-range-filter label {
             margin-bottom: 3px;
             font-size: 0.85em;
             font-weight: 600;
             color: #4a5568;
        }
        #panel-license .th-filter-dropdown .date-range-filter input[type="date"] {
            width: 100%;
        }
        #panel-license .th-filter-dropdown[data-column-key="licenseNo"] label {
            font-size: 0.85em;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 3px;
        }


        /* ====== FSSAI RESPONSIVE ADJUSTMENTS (scoped) ====== */
        @media (max-width: 768px) { /* This might conflict with main tab's responsive */
            #panel-license .fssai-container-embed {
                padding: 15px;
            }

            #panel-license .cards-container {
                grid-template-columns: 1fr;
            }

            #panel-license #addNewButton,
            #panel-license #submitDraftsButton,
            #panel-license #exportButton,
            #panel-license #refreshTableButton {
                display: none !important; /* FSSAI original style */
            }

            #panel-license .table-actions .ms-auto {
                width: 100%;
                margin-left: 0 !important;
                justify-content: space-between;
            }

            #panel-license .table-actions .ms-auto .show-select-wrapper {
                flex-shrink: 0;
            }

            #panel-license .table-actions .ms-auto .input-group {
                flex-grow: 1;
                flex-basis: 150px;
                max-width: 100%;
            }


            #panel-license .action-btns {
                flex-wrap: wrap;
            }
            #panel-license .action-btns .btn { /* Scoped this */
                width: 100%;
            }

             #panel-license .pagination-controls {
                flex-direction: column;
                align-items: center;
            }
            #panel-license .pagination-info,
            #panel-license .pagination-nav {
                margin-bottom: 10px;
                width: 100%;
                text-align: center;
            }
            #panel-license .pagination-nav ul {
                 justify-content: center;
            }
        }

        @media (min-width: 992px) {
            #panel-license .cards-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
       button#exportButton
 {
    background: transparent;
    border: 1px solid;
}

/* Hover effect */
button#exportButton:hover
 {
    background: #0d6efd;
    border: 1px solid #0d6efd;
    cursor: pointer;
}

button#refreshTableButton {
    background: transparent;
    border: 1px solid #6c757d;
    color: #6c757d;
}

button#refreshTableButton:hover {
    background: #6c757d; /* Optional */
    border-color: #6c757d;
    color: #fff;
    cursor: pointer;
}
button#searchButton {
    background: transparent;
    border: 1px solid;
}

button#searchButton:hover {
    background: transparent;
    border: 1px solid !important;
}

.btn-danger {
    color: #fff;
    background-color: #d10b1e !important;
    border-color: #b02a37;
}


.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0; left: 0;
  right: 0; bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 20px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #28a745; /* green */
}

input:checked + .slider:before {
  transform: translateX(20px);
}
    </style>
@section('content')
 



<div class="tabs-container-main">
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
                <button role="tab" aria-selected="false" aria-controls="panel-license" id="tab-license" >
                    <a     href="{{route('fssailinces')}}" >
                    <i class="fas fa-id-card"></i>License
                    </a>
                </button>
            </li>
            <li>
                <button role="tab" aria-selected="false" aria-controls="panel-medical" id="tab-medical">
                                        <a   href="{{route('medical')}}" >

                    <i class="fas fa-briefcase-medical"></i>Medical
                    </a>
                </button>
            </li>
            <li>
                <button role="tab" aria-selected="false" aria-controls="panel-testing" id="tab-testing" class="active">
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

        <!-- Tab Content Panels -->
        <div class="tabs-content-main">
            <div role="tabpanel" id="panel-dashboard" aria-labelledby="tab-dashboard" class="tab-panel-main ">
                <h2><i class="fas fa-tachometer-alt"></i>Dashboard Content</h2>
                <p>This is the content for the Dashboard tab. You can put any relevant information here, like charts, summaries, or quick links.</p>
            </div>

            <div role="tabpanel" id="panel-license" aria-labelledby="tab-license" class="tab-panel-main active">
                <!-- EMBEDDED FSSAI CONTENT START -->
                <div class="fssai-content-wrapper">
                    <div class="container fssai-container-embed"> <!-- Original FSSAI container, renamed class for safety -->
                        											 	 <div class="" id="company-details1" role="tabpanel">
							
														 
				    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bi bi-clipboard2-pulse"></i> Food Safety Testing Dashboard</h1>
                    <p class="mb-0">Comprehensive testing results for food, water, equipment, hand swabs, and environmental samples</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="reportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-download"></i> Export Report
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="reportDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf"></i> PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-excel"></i> Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-text"></i> CSV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="filter-section">
            <div class="row">
                <div class="col-md-3">
                    <label for="monthSelect" class="form-label">Month</label>
                    <select class="form-select" id="monthSelect">
                        <option selected>April 2023</option>
                        <option>March 2023</option>
                        <option>February 2023</option>
                        <option>January 2023</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="facilitySelect" class="form-label">Facility</label>
                    <select class="form-select" id="facilitySelect">
                        <option selected>All Facilities</option>
                        <option>Main Production</option>
                        <option>Packaging Unit</option>
                        <option>Warehouse</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="testTypeSelect" class="form-label">Test Type</label>
                    <select class="form-select" id="testTypeSelect">
                        <option selected>All Tests</option>
                        <option>Food</option>
                        <option>Water</option>
                        <option>Equipment</option>
                        <option>Hand Swabs</option>
                        <option>Environmental</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusSelect" class="form-label">Status</label>
                    <select class="form-select" id="statusSelect">
                        <option selected>All Statuses</option>
                        <option>Pass</option>
                        <option>Fail</option>
                        <option>Pending</option>
                        <option>Draft</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-end">
                    <button class="btn btn-primary me-2"><i class="bi bi-funnel"></i> Apply Filters</button>
                    <button class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Detailed Test Results with Comprehensive Parameters</span>
                        <div>
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addNewTestBtn" >
                                <i class="bi bi-plus-circle"></i> Add New Test
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content" id="results-tabContent">
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover data-table" id="testResultsTable">
                                        <thead>
                                            <tr>
                                                <th>Test ID</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Location</th>
                                                <th>Test Parameter</th>
                                                <th>Physical</th>
                                                <th>Chemical</th>
                                                <th>Microbial</th>
                                                <th>Pesticide</th>
                                                <th>Antibiotics</th>
                                                <th>Natural Toxin</th>
                                                <th>Adulteration</th>
                                         
                                                <th>Status</th>
                                                <th>Report</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Food Test Example -->
                                            @php $i=1; @endphp
                                            @foreach($result as $results)
                                            <tr>
                                                <td>{{$i ?? ''}}</td>
                                                <td>{{$results->test_date ?? ''}}</td>
                                                <td>{{$results->type ?? ''}}</td>
                                                <td>{{$results->location ?? ''}}</td>
                                                <td>{{$results->test_parameter ?? ''}}</td>
                                                <td><span >{{$results->physical_test ?? ''}}</span></td>
                                                <td><span >{{$results->chemical_test ?? ''}}</span></td>
                                                <td><span >{{$results->microbial_test ?? ''}}</span></td>
                                                <td><span >{{$results->pesticide_test ?? ''}}</span></td>
                                                <td><span >{{$results->antibiotics_test ?? ''}}</span></td>
                                                <td><span >{{$results->natural_toxin_test ?? ''}}</span></td>
                                                <td><span >{{$results->adulteration_test ?? ''}}</span></td>
                            
                                                <td><span class="status-badge status-pass">{{$results->status ?? ''}}</span></td>
                                                <td>
                                                    
                                                    <div class="position-relative d-inline-block">
                                                                                                            <a target="_blank()" href="{{asset('documents')}}/{{$results->image ?? ''}}"><i class="bi bi-file-earmark-pdf"></i></a>

                                                    </div>
                                                </td>
                                                <td class="action-buttons">
                                                    <button class="btn btn-sm btn-outline-primary view-test"><i class="bi bi-eye"></i></button>
                                                    
                                                    <button 
    class="btn btn-sm btn-outline-success edit-test"
    data-id="{{$results->id}}"
    data-test_date="{{$results->test_date}}"
    data-type="{{$results->type}}"
    data-location="{{$results->location}}"
    data-test_parameter="{{$results->test_parameter}}"
    data-physical_test="{{$results->physical_test}}"
    data-chemical_test="{{$results->chemical_test}}"
    data-microbial_test="{{$results->microbial_test}}"
    data-pesticide_test="{{$results->pesticide_test}}"
    data-antibiotics_test="{{$results->antibiotics_test}}"
    data-natural_toxin_test="{{$results->natural_toxin_test}}"
    data-adulteration_test="{{$results->adulteration_test}}"
    data-status="{{$results->status}}"
    data-notes="{{$results->notes}}"
><i class="bi bi-pencil"></i></button>

                        <a target="_blank()" class="btn btn-sm btn-outline-danger" href="{{route('foodtestDelete',$results->id)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="bi bi-trash"></i></a>



                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                            @endforeach
                          
                                        </tbody>
                                    </table>
                                </div>
                                <nav aria-label="Test results pagination">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Other tab panes would go here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Test Modal -->
    <div class="modal fade" id="addNewTestBtn" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTestModalLabel">Add New Test</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTestForm" action="{{route('foodtest')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="test_id">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="testType" class="form-label">Test Type</label>
                                <select class="form-select" id="testType" name="type" required>
                                    <option value="">Select Test Type</option>
                                    <option value="Food">Food</option>
                                    <option value="Water">Water</option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Hand Swabs">Hand Swabs</option>
                                    <option value="Environmental">Environmental</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="testDate" class="form-label">Test Date</label>
                                <input type="date" class="form-control" name="test_date" id="testDate" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" id="location" required>
                            </div>
                            <div class="col-md-6">
    <label class="form-label d-block">Test Parameter</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="test_parameter" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="test_parameter" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="test_parameter" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>
                        </div>
                        <div class="row mb-3">
                            
                            <div class="col-md-4">
    <label class="form-label d-block">Physical Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="physical_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="physical_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="physical_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>

<div class="col-md-4">
    <label class="form-label d-block">Chemical Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="chemical_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="chemical_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="chemical_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>

<div class="col-md-4">
    <label class="form-label d-block">Microbial Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="microbial_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="microbial_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="microbial_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>

                        </div>
                        
                        
                        <div class="row mb-3">
                            
                            <div class="col-md-4">
    <label class="form-label d-block">Pesticide Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="pesticide_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="pesticide_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="pesticide_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>

<div class="col-md-4">
    <label class="form-label d-block">Antibiotics Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="antibiotics_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="antibiotics_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="antibiotics_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>

<div class="col-md-4">
    <label class="form-label d-block">Natural Toxin Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="natural_toxin_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="natural_toxin_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="natural_toxin_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>

                        </div>
                        
                        
                   
                        <div class="row mb-3">
                            
                            <div class="col-md-6">
    <label class="form-label d-block">Adulteration Test</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="adulteration_test" id="parameter_yes" value="Yes" required>
        <label class="form-check-label" for="parameter_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="adulteration_test" id="parameter_no" value="No">
        <label class="form-check-label" for="parameter_no">No</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="adulteration_test" id="parameter_na" value="NA">
        <label class="form-check-label" for="parameter_na">N/A</label>
    </div>
</div>


                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Pass">Pass</option>
                                    <option value="Fail">Fail</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="3" name="notes"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Report (PDF only)</label>
                            <div class="file-upload btn btn-outline-secondary">
                                <span><i class="bi bi-upload"></i> Choose PDF File</span>
                                <input type="file" name="image" class="file-upload-input" id="testReport" >
                            </div>
                            <small class="text-muted ms-2">Max file size: 5MB</small>
                            <div class="pdf-preview-container mt-2">
                                <div class="pdf-preview" id="pdfPreview"></div>
                                <div class="pdf-info">
                                    <span id="pdfFileName"></span>
                                    <span class="pdf-remove" id="removePdf"><i class="bi bi-x-circle"></i> Remove</span>
                                </div>
                            </div>
                        </div>
                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <!--<button type="button" class="btn btn-warning" id="saveDraftBtn">Save as Draft</button>-->
                    <button type="submit" class="btn btn-primary" id="finalSaveBtn">Save</button>
                </div>
                   </form>
            </div>
        </div>
    </div>

    <!-- PDF Upload Modal -->
    <div class="modal fade" id="pdfUploadModal" tabindex="-1" aria-labelledby="pdfUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfUploadModalLabel">Upload PDF Report</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pdfFile" class="form-label">Select PDF file</label>
                        <input class="form-control" type="file" id="pdfFile" accept=".pdf">
                    </div>
                    <div class="pdf-preview-container">
                        <div class="pdf-preview" id="uploadPdfPreview"></div>
                        <div class="pdf-info">
                            <span id="uploadPdfFileName"></span>
                            <span class="pdf-remove" id="removeUploadPdf"><i class="bi bi-x-circle"></i> Remove</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="uploadPdfBtn">Upload</button>
                </div>
            </div>
        </div>
    </div>
                    
                            
										
                                  </div>      
                                    
                                </div>

                    </div> <!-- End of FSSAI original container -->

                    
                    



                   
                </div> <!-- End of FSSAI content wrapper -->
                <!-- EMBEDDED FSSAI CONTENT END -->
            </div>

           
        </div>
    </div>

                         
                    <!--end row-->  
                    
                    

@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
  function edit_supplier(id){
        let url = '{{route("edit_supplier")}}';
        $.ajax({
            type: "GET",
            url: url,
            data:{id:id},
            success: function(response) {

                $('#editsupplier').modal('show'); // show modal
            },
       
        });
    }
</script>

<script>


													/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclicktool_section').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxtool_section").prop('checked', true);    
         } else {    
            $(".checkboxtool_section").prop('checked',false);    
         }    
        }); 
  $("#delbuttontool_section").click(function(){
         if (confirm("Are you sure you want to Delete Item!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxtool_section:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_fgc') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxtool_section:checked").each(function() {    
                                    $(this).parents("tr").remove();  
                                });  
                                alert(data['success']);  
                            } else if (data['error']) {  
                                alert(data['error']);  
                            } else {  
                                alert('Whoops Something went wrong!!');  
                            }  
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                  $.each(allVals, function( index, value ) {  
                      $('table tr').filter("[data-row-id='checkboxtool_section_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        // Set PDF.js worker path
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Counter for generating test IDs
        let testCounter = 202;
        let currentEditingRow = null;
        let currentEditingTestId = null;
        let currentPdfFile = null;
        let currentUploadPdfFile = null;

        // Function to format date for display
        function formatDateForDisplay(dateString) {
            if (!dateString) return 'N/A';
            const dateObj = new Date(dateString);
            return dateObj.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }

        // Function to format date for input[type="date"]
        function formatDateForInput(dateString) {
            if (!dateString || dateString === 'N/A') return '';
            
            const months = {
                'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'May': '05', 'Jun': '06',
                'Jul': '07', 'Aug': '08', 'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'
            };
            
            const parts = dateString.split(' ');
            if (parts.length === 3) {
                const month = months[parts[1]];
                const day = parts[0].replace(',', '').padStart(2, '0');
                const year = parts[2];
                return `${year}-${month}-${day}`;
            }
            return '';
        }

        // Function to determine result class based on value
        function getResultClass(value) {
            if (!value) return '';
            return value.includes('Pass') ? 'test-result-pass' : 
                   value.includes('Fail') ? 'test-result-fail' : '';
        }

        // Function to create a new test row
        function createTestRow(data) {
            const row = document.createElement('tr');
            if (data.isDraft) {
                row.classList.add('table-warning');
            }
            
            row.innerHTML = `
                <td>${data.testId || 'N/A'}</td>
                <td>${formatDateForDisplay(data.testDate)}</td>
                <td>${data.testType || 'N/A'}</td>
                <td>${data.location || 'N/A'}</td>
                <td>${data.parameter || 'N/A'}</td>
                <td><span class="test-result-value ${getResultClass(data.physicalTest)}">${data.physicalTest || 'N/A'}</span></td>
                <td><span class="test-result-value ${getResultClass(data.chemicalTest)}">${data.chemicalTest || 'N/A'}</span></td>
                <td><span class="test-result-value ${getResultClass(data.microbialTest)}">${data.microbialTest || 'N/A'}</span></td>
                <td><span class="test-result-value">${data.pesticideTest || 'N/A'}</span></td>
                <td><span class="test-result-value">${data.antibioticsTest || 'N/A'}</span></td>
                <td><span class="test-result-value">${data.naturalToxinTest || 'N/A'}</span></td>
                <td><span class="test-result-value">${data.adulterationTest || 'None'}</span></td>
                <td>${data.result || data.microbialTest || data.chemicalTest || data.physicalTest || 'N/A'}</td>
                <td>
                    <span class="status-badge ${data.status === 'Pass' ? 'status-pass' : 
                                             data.status === 'Fail' ? 'status-fail' : 
                                             data.status === 'Pending' ? 'status-pending' : 
                                             'status-draft'}">
                        ${data.status || 'Pending'}
                    </span>
                </td>
                <td>
                    <div class="position-relative d-inline-block">
                        <button class="btn btn-sm btn-outline-secondary upload-report" data-testid="${data.testId || ''}">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </button>
                        ${data.hasPdf ? '<span class="draft-badge"><i class="bi bi-check"></i></span>' : ''}
                    </div>
                                    </td>
                <td class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary view-test"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-outline-success edit-test"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger delete-test"><i class="bi bi-trash"></i></button>
                </td>
            `;
            return row;
        }

        // Function to generate a test ID based on type
        function generateTestId(testType) {
            const prefixMap = {
                'Food': 'F',
                'Water': 'W',
                'Equipment': 'E',
                'Hand Swabs': 'HS',
                'Environmental': 'ENV'
            };
            const prefix = prefixMap[testType] || 'T';
            const month = (new Date().getMonth() + 1).toString().padStart(2, '0');
            const yearShort = new Date().getFullYear().toString().slice(-2);
            const id = testCounter.toString().padStart(3, '0');
            testCounter++;
            return `${prefix}-${month}${yearShort}-${id}`;
        }

        // Function to show PDF preview
        function showPdfPreview(file, previewElement, fileNameElement) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const typedarray = new Uint8Array(event.target.result);
                
                // Load the PDF document
                pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                    // Fetch the first page
                    pdf.getPage(1).then(function(page) {
                        const viewport = page.getViewport({ scale: 1.0 });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        
                        previewElement.innerHTML = '';
                        previewElement.appendChild(canvas);
                        
                        // Render PDF page
                        page.render({
                            canvasContext: context,
                            viewport: viewport
                        });
                        
                        // Show file info
                        fileNameElement.textContent = file.name;
                        previewElement.parentElement.style.display = 'block';
                    });
                });
            };
            reader.readAsArrayBuffer(file);
        }

        // Function to reset the add test form
        function resetAddTestForm() {
            document.getElementById('addTestForm').reset();
            document.querySelector('.pdf-preview-container').style.display = 'none';
            currentPdfFile = null;
        }

        // Function to collect form data
        function collectFormData() {
            const testType = document.getElementById('testType').value;
            const testDate = document.getElementById('testDate').value;
            const location = document.getElementById('location').value;
            const parameter = document.getElementById('parameter').value;
            const physicalTest = document.getElementById('physicalTest').value;
            const chemicalTest = document.getElementById('chemicalTest').value;
            const microbialTest = document.getElementById('microbialTest').value;
            const pesticideTest = document.getElementById('pesticideTest').value;
            const antibioticsTest = document.getElementById('antibioticsTest').value;
            const naturalToxinTest = document.getElementById('naturalToxinTest').value;
            const adulterationTest = document.getElementById('adulterationTest').value;
            const status = document.getElementById('status').value;
            const notes = document.getElementById('notes').value;
            
            return {
                testType,
                testDate,
                location,
                parameter,
                physicalTest,
                chemicalTest,
                microbialTest,
                pesticideTest,
                antibioticsTest,
                naturalToxinTest,
                adulterationTest,
                status,
                notes,
                hasPdf: currentPdfFile !== null,
                isDraft: status === 'Draft'
            };
        }

        // Event listener for Add New Test button
        document.getElementById('addNewTestBtn').addEventListener('click', function() {
            resetAddTestForm();
            const modal = new bootstrap.Modal(document.getElementById('addTestModal'));
            modal.show();
        });

        // Event listener for PDF file selection in add test modal
        document.getElementById('testReport').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                currentPdfFile = e.target.files[0];
                showPdfPreview(
                    currentPdfFile, 
                    document.getElementById('pdfPreview'), 
                    document.getElementById('pdfFileName')
                );
            }
        });

        // Event listener for PDF file selection in upload modal
        document.getElementById('pdfFile').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                currentUploadPdfFile = e.target.files[0];
                showPdfPreview(
                    currentUploadPdfFile, 
                    document.getElementById('uploadPdfPreview'), 
                    document.getElementById('uploadPdfFileName')
                );
            }
        });

        // Event listener for removing PDF in add test modal
        document.getElementById('removePdf').addEventListener('click', function() {
            document.getElementById('testReport').value = '';
            document.querySelector('.pdf-preview-container').style.display = 'none';
            currentPdfFile = null;
        });

        // Event listener for removing PDF in upload modal
        document.getElementById('removeUploadPdf').addEventListener('click', function() {
            document.getElementById('pdfFile').value = '';
            document.querySelector('#pdfUploadModal .pdf-preview-container').style.display = 'none';
            currentUploadPdfFile = null;
        });

        // Event listener for Save as Draft button
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            document.getElementById('status').value = 'Draft';
            document.getElementById('finalSaveBtn').click();
        });

        // Event listener for Final Save button
        document.getElementById('finalSaveBtn').addEventListener('click', function() {
            const formData = collectFormData();
            
            // Generate test ID if this is a new test
            if (!currentEditingTestId) {
                formData.testId = generateTestId(formData.testType);
            } else {
                formData.testId = currentEditingTestId;
            }
            
            // Create or update the row
            const newRow = createTestRow(formData);
            const tableBody = document.querySelector('#testResultsTable tbody');
            
            if (currentEditingRow) {
                tableBody.replaceChild(newRow, currentEditingRow);
            } else {
                tableBody.insertBefore(newRow, tableBody.firstChild);
            }
            
            // Reset form and close modal
            resetAddTestForm();
            bootstrap.Modal.getInstance(document.getElementById('addTestModal')).hide();
            
            // Reset editing state
            currentEditingRow = null;
            currentEditingTestId = null;
        });

        // Event delegation for edit buttons
        document.querySelector('#testResultsTable').addEventListener('click', function(e) {
            if (e.target.closest('.edit-test')) {
                const row = e.target.closest('tr');
                const cells = row.cells;
                
                // Collect data from the row
                const testData = {
                    testId: cells[0].textContent,
                    testDate: formatDateForInput(cells[1].textContent),
                    testType: cells[2].textContent,
                    location: cells[3].textContent,
                    parameter: cells[4].textContent,
                    physicalTest: cells[5].querySelector('.test-result-value').textContent,
                    chemicalTest: cells[6].querySelector('.test-result-value').textContent,
                    microbialTest: cells[7].querySelector('.test-result-value').textContent,
                    pesticideTest: cells[8].querySelector('.test-result-value').textContent,
                    antibioticsTest: cells[9].querySelector('.test-result-value').textContent,
                    naturalToxinTest: cells[10].querySelector('.test-result-value').textContent,
                    adulterationTest: cells[11].querySelector('.test-result-value').textContent,
                    status: cells[13].querySelector('.status-badge').textContent.trim(),
                    hasPdf: cells[14].querySelector('.draft-badge') !== null
                };
                
                // Fill the form
                document.getElementById('testType').value = testData.testType;
                document.getElementById('testDate').value = testData.testDate;
                document.getElementById('location').value = testData.location;
                document.getElementById('parameter').value = testData.parameter;
                document.getElementById('physicalTest').value = testData.physicalTest;
                document.getElementById('chemicalTest').value = testData.chemicalTest;
                document.getElementById('microbialTest').value = testData.microbialTest;
                document.getElementById('pesticideTest').value = testData.pesticideTest;
                document.getElementById('antibioticsTest').value = testData.antibioticsTest;
                document.getElementById('naturalToxinTest').value = testData.naturalToxinTest;
                document.getElementById('adulterationTest').value = testData.adulterationTest;
                document.getElementById('status').value = testData.status;
                
                // Set editing state
                currentEditingRow = row;
                currentEditingTestId = testData.testId;
                
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('addTestModal'));
                modal.show();
            }
            
            // Handle delete button
            if (e.target.closest('.delete-test')) {
                if (confirm('Are you sure you want to delete this test record?')) {
                    const row = e.target.closest('tr');
                    row.remove();
                }
            }
            
            // Handle PDF upload button
            if (e.target.closest('.upload-report')) {
                const testId = e.target.closest('.upload-report').getAttribute('data-testid');
                document.getElementById('pdfUploadModalLabel').textContent = `Upload PDF Report for ${testId}`;
                const modal = new bootstrap.Modal(document.getElementById('pdfUploadModal'));
                modal.show();
            }
        });

        // Event listener for PDF upload button in upload modal
        document.getElementById('uploadPdfBtn').addEventListener('click', function() {
            if (currentUploadPdfFile) {
                // In a real application, you would upload the file to a server here
                // For this demo, we'll just show a success message
                alert('PDF uploaded successfully!');
                bootstrap.Modal.getInstance(document.getElementById('pdfUploadModal')).hide();
                
                // Reset the upload form
                document.getElementById('pdfFile').value = '';
                document.querySelector('#pdfUploadModal .pdf-preview-container').style.display = 'none';
                currentUploadPdfFile = null;
            } else {
                alert('Please select a PDF file first.');
            }
        });

        // Initialize the page with some sample data
        document.addEventListener('DOMContentLoaded', function() {
            // This would normally come from a server API
            const sampleData = [
                {
                    testId: 'F-0423-201',
                    testDate: '2023-04-15',
                    testType: 'Food',
                    location: 'Production Line 2',
                    parameter: 'Chicken Product',
                    physicalTest: 'Pass',
                    chemicalTest: 'Pass',
                    microbialTest: '< 10 CFU/g',
                    pesticideTest: 'Not Detected',
                    antibioticsTest: 'Not Detected',
                    naturalToxinTest: 'Not Detected',
                    adulterationTest: 'None',
                    status: 'Pass',
                    hasPdf: true
                },
                {
                    testId: 'W-0423-042',
                    testDate: '2023-04-12',
                    testType: 'Water',
                    location: 'Filling Station',
                    parameter: 'Drinking Water',
                    physicalTest: 'Pass',
                    chemicalTest: '8.2 pH',
                    microbialTest: 'Pass',
                    pesticideTest: 'N/A',
                    antibioticsTest: 'N/A',
                    naturalToxinTest: 'N/A',
                    adulterationTest: 'None',
                    status: 'Fail',
                    hasPdf: false
                }
            ];
            
            // Add sample data to the table
            const tableBody = document.querySelector('#testResultsTable tbody');
            sampleData.forEach(data => {
                const row = createTestRow(data);
                tableBody.appendChild(row);
            });
        });
    </script>


<script>
$(document).on('click', '.edit-test', function () {
    const btn = $(this);

    // Set form action if different from 'add'
    const form = $('#addTestForm');
    const id = btn.data('id');
    //form.attr('action', '/update-foodtest/' + id); // adjust route as needed
    //form.prepend('<input type="hidden" name="_method" value="PUT">'); // spoof PUT for Laravel

    // Update modal title
    $('#addTestModalLabel').text('Edit Test');
    $('#test_id').val(btn.data('id'));


    // Fill inputs
    $('#testType').val(btn.data('type'));
    $('#testDate').val(btn.data('test_date'));
    $('#location').val(btn.data('location'));
    $('#status').val(btn.data('status'));
    $('#notes').val(btn.data('notes'));

    // Set radios
    setRadio('test_parameter', btn.data('test_parameter'));
    setRadio('physical_test', btn.data('physical_test'));
    setRadio('chemical_test', btn.data('chemical_test'));
    setRadio('microbial_test', btn.data('microbial_test'));
    setRadio('pesticide_test', btn.data('pesticide_test'));
    setRadio('antibiotics_test', btn.data('antibiotics_test'));
    setRadio('natural_toxin_test', btn.data('natural_toxin_test'));
    setRadio('adulteration_test', btn.data('adulteration_test'));

    // Show modal
    $('#addNewTestBtn').modal('show');
});

// Helper function
function setRadio(name, value) {
    $(`input[name=${name}][value="${value}"]`).prop('checked', true);
}
</script>


   