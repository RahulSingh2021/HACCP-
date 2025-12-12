@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">s.css">
        <style>
        
     

        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-gray: #ecf0f1;
            --dark-gray: #7f8c8d;
            --text-color: #2c3e50;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--text-color);
        }
        
        .top-nav {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
       
        
        .logo {
            padding: 15px 0;
        }
        
        .logo h2 {
            color: var(--primary-color);
        }
        
       
        
        .header {
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: var(--text-color);
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .card-icon.blue {
            background-color: var(--primary-color);
        }
        
        .card-icon.green {
            background-color: var(--success-color);
        }
        
        .card-icon.orange {
            background-color: var(--warning-color);
        }
        
        .card-icon.red {
            background-color: var(--danger-color);
        }
        
        .card-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .card-title {
            color: var(--dark-gray);
            font-size: 14px;
        }
        
        .tabs-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        .tabs-header {
            display: flex;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .tab {
            padding: 15px 25px;
            cursor: pointer;
            position: relative;
        }
        
        .tab.active {
            color: var(--primary-color);
        }
        
        .tab.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .tab-content {
            padding: 25px;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }
        
        .reports-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .reports-table th, .reports-table td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
            font-size: 13px;
        }
        
        .reports-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .reports-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status.overdue {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status.draft {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status.final {
            background-color: #d4edda;
            color: #155724;
        }
        
        .parameter-status {
            padding: 3px 6px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .parameter-status.done {
            background-color: #d4edda;
            color: #155724;
        }
        
        .parameter-status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .parameter-status.na {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .parameter-status.expired {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            font-size: 12px;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }
        
        .view-btn {
            background-color: var(--primary-color);
            color: white;
        }
        
        .edit-btn {
            background-color: var(--warning-color);
            color: white;
        }
        
        .save-btn {
            background-color: var(--success-color);
            color: white;
        }
        
        .final-btn {
            background-color: #28a745;
            color: white;
        }
        
        .cancel-btn {
            background-color: #6c757d;
            color: white;
        }
        
        .history-btn {
            background-color: #6c757d;
            color: white;
        }
        
        .add-btn {
            background-color: var(--success-color);
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
        }
        
        .add-btn:hover {
            background-color: #28a745;
        }
        
        select.parameter-select {
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            font-size: 12px;
            cursor: pointer;
        }
        
        input.test-date {
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            font-size: 12px;
            width: 90px;
        }
        
        select.validity-select {
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            font-size: 12px;
            cursor: pointer;
            width: 90px;
        }
        
        select.test-category {
            padding: 3px 6px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            font-size: 12px;
            cursor: pointer;
        }
        
        .certificate-upload {
            display: inline-flex;
            align-items: center;
            position: relative;
        }
        
        .certificate-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .certificate-btn {
            background-color: var(--light-gray);
            color: var(--text-color);
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            transition: background-color 0.3s;
        }
        
        .certificate-btn:hover {
            background-color: #e0e0e0;
        }
        
        .certificate-btn i {
            margin-right: 5px;
        }
        
        .certificate-status {
            font-size: 12px;
            margin-left: 5px;
            color: var(--dark-gray);
        }
        
        .certificate-status.uploaded {
            color: var(--success-color);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 1200px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .modal-header h2 {
            color: var(--primary-color);
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark-gray);
            transition: color 0.2s;
        }
        
        .close-modal:hover {
            color: var(--text-color);
        }
        
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .history-table th, .history-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            font-size: 12px;
        }
        
        .history-table th {
            background-color: #f8f9fa;
        }
        
        .parameter-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }
        
        .parameter-history-table th, .parameter-history-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: center;
            white-space: nowrap;
        }
        
        .parameter-history-table th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            font-weight: 600;
        }
        
        .parameter-history-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .parameter-history-table tr:hover {
            background-color: #f1f1f1;
        }
        
        .history-header {
            font-weight: 600;
            background-color: #e9ecef;
        }
        
        .scrollable-table {
            overflow-x: auto;
            max-width: 100%;
        }
        
        .edit-mode {
            background-color: #fff3cd;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        
        @media (max-width: 1200px) {
            .dashboard-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
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
                <button role="tab" aria-selected="false" aria-controls="panel-medical" id="tab-medical" class="active">
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

        <!-- Tab Content Panels -->
        <div class="tabs-content-main">
            <div role="tabpanel" id="panel-dashboard" aria-labelledby="tab-dashboard" class="tab-panel-main ">
                <h2><i class="fas fa-tachometer-alt"></i>Dashboard Content</h2>
                <p>This is the content for the Dashboard tab. You can put any relevant information here, like charts, summaries, or quick links.</p>
            </div>

            <div role="tabpanel" id="panel-license" aria-labelledby="tab-license" class="tab-panel-main active">
                <!-- EMBEDDED FSSAI CONTENT START -->
                <div class="fssai-content-wrapper">

                   

                    <div class="" id="company-details1" role="tabpanel">
							
		


    
 <div class="main-content">
        <div class="header">
            <h1>Employee Medical Test Report Tracker</h1>
        </div>
        
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-value" id="total-employees">142</div>
                        <div class="card-title">Total Employees</div>
                    </div>
                    <div class="card-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-value" id="completed-tests-count">87</div>
                        <div class="card-title">Tests Completed</div>
                    </div>
                    <div class="card-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-value" id="pending-tests">32</div>
                        <div class="card-title">Pending Tests</div>
                    </div>
                    <div class="card-icon orange">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-value" id="expired-tests">23</div>
                        <div class="card-title">Expired Tests</div>
                    </div>
                    <div class="card-icon red">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tabs-container">
            
            
            <div class="tab-content active" id="current-tests">
                <button id="addNewEmployeeBtn" class="add-btn">
                    <i class="fas fa-plus"></i> Add New Employee
                </button>
                <div class="table-container">
                    <table class="reports-table" id="currentTestsTable">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Test Type</th>
                                <th>Test Category</th>
                                <th>Test Date</th>
                                <th>Validity</th>
                                <th>Blood Test</th>
                                <th>Urine Test</th>
                                <th>Stool Test</th>
                                <th>HBsAg Test</th>
                                <th>Typhoid Vaccine</th>
                                <th>Hepatitis Vaccine</th>
                                <th>Chest X-Ray</th>
                                <th>Skin Exam</th>
                                <th>VDRL</th>
                                <th>Widal</th>
                                <th>Eye Exam</th>
                                <th>Certificate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="current-tests-body
                            
                             @foreach($unit_users_lists as $unit_users_list)
                            <tr data-emp-id="EMP-1001">
                                <td>{{$unit_users_list->employe_id}}</td>
                                <td contenteditable="true">{{$unit_users_list->employer_fullname}}</td>
                                <td contenteditable="true">@php $department_name = DB::table('departments')->where('id',$unit_users_list->department)->first(); @endphp 
{{$department_name->name ?? ''}}</td>
                                <td contenteditable="true">{{$unit_users_list->designation ?? ''}}</td>
                                <td contenteditable="true">Comprehensive</td>
                                <td>
                                    <select class="test-category">
                                        <option value="Regular">Regular</option>
                                        <option value="Pre-Joining">Pre-Joining</option>
                                    </select>
                                </td>
                                <td><input type="date" class="test-date" value="2023-06-01"></td>
                                <td>
                                    <select class="validity-select">
                                        <option value="6 Months">6 Months</option>
                                        <option value="1 Year" selected>1 Year</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Done">Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Done">Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Done">Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending" selected>Pending</option>
                                        <option value="Done">Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="parameter-select">
                                        <option value="Pending">Pending</option>
                                        <option value="Done" selected>Done</option>
                                        <option value="NA">NA</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="certificate-upload">
                                        <input type="file" id="cert-1001" class="certificate-input" data-emp="EMP-1001" accept=".pdf,.jpg,.png">
                                        <label for="cert-1001" class="certificate-btn">
                                            <i class="fas fa-upload"></i> Upload
                                        </label>
                                        <span class="certificate-status">Not uploaded</span>
                                    </div>
                                </td>
                                <td><span class="status final">Final</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn edit-btn" onclick="editEmployee('EMP-1001')">Edit</button>
                                        <button class="action-btn history-btn" onclick="viewHistory('EMP-1001')">History</button>
                                    </div>
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                                                                                                        {{ $unit_users_lists->appends(request()->query())->links() }}

            </div>
            
            
        </div>
    </div>
    
    <!-- History Modal -->
    <div class="modal" id="historyModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Test History for <span id="history-emp-name"></span> (ID: <span id="history-emp-id"></span>)</h2>
                <button class="close-modal" onclick="closeModal('historyModal')">&times;</button>
            </div>
            <div id="history-content">
                <div style="margin-bottom: 15px;">
                    <strong>Test Type:</strong> <span id="history-test-type"></span> | 
                    <strong>Current Status:</strong> <span id="history-current-status"></span>
                </div>
                
                <div class="scrollable-table">
                    <table class="parameter-history-table">
                        <thead>
                            <tr>
                                <th>Updated On</th>
                                <th>Test Date</th>
                                <th>Validity</th>
                                <th>Blood Test</th>
                                <th>Urine Test</th>
                                <th>Stool Test</th>
                                <th>HBsAg Test</th>
                                <th>Typhoid Vaccine</th>
                                <th>Hepatitis Vaccine</th>
                                <th>Chest X-Ray</th>
                                <th>Skin Exam</th>
                                <th>VDRL</th>
                                <th>Widal</th>
                                <th>Eye Exam</th>
                                <th>Certificate</th>
                            </tr>
                        </thead>
                        <tbody id="parameter-history-details">
                            <!-- History data will be loaded here -->
                        </tbody>
                    </table>
                </div>
                
                <h3 style="margin-top: 25px; margin-bottom: 15px;">Change Log</h3>
                <div class="table-container">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action</th>
                                <th>Changed By</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody id="change-history-details">
                            <!-- Change log will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

                            
										
                                  </div>      
                                    
                                </div>
                                
                            </div>
                        </div>

                   
                </div> <!-- End of FSSAI content wrapper -->
                <!-- EMBEDDED FSSAI CONTENT END -->
            </div>

            
        </div>
    </div>
 



                    
                    

@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    
    <script>
        // Sample data storage with enhanced history tracking
        const testData = {
            'EMP-1001': {
                name: 'John Smith',
                department: 'Operations',
                designation: 'Manager',
                testType: 'Comprehensive',
                testCategory: 'Regular',
                testDate: '2023-06-01',
                validity: '1 Year',
                status: 'final',
                certificate: 'Not uploaded',
                parameters: {
                    bloodTest: { status: 'Done', updatedOn: '2023-06-01', updatedBy: 'Admin' },
                    urineTest: { status: 'Done', updatedOn: '2023-06-01', updatedBy: 'Admin' },
                    stoolTest: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    hbsagTest: { status: 'Done', updatedOn: '2023-06-02', updatedBy: 'Admin' },
                    typhoidVaccine: { status: 'Done', updatedOn: '2023-05-15', updatedBy: 'Admin' },
                    hepatitisVaccine: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    chestXRay: { status: 'Done', updatedOn: '2023-06-03', updatedBy: 'Admin' },
                    skinExam: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    vdrl: { status: 'Done', updatedOn: '2023-06-02', updatedBy: 'Admin' },
                    widal: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    eyeExam: { status: 'Done', updatedOn: '2023-05-30', updatedBy: 'Admin' }
                },
                history: [
                    {
                        date: '2023-06-03',
                        action: 'final_save',
                        changedBy: 'Admin',
                        changes: {
                            chestXRay: { status: 'Done' }
                        }
                    },
                    {
                        date: '2023-06-02',
                        action: 'edit',
                        changedBy: 'Admin',
                        changes: {
                            hbsagTest: { status: 'Done' },
                            vdrl: { status: 'Done' }
                        }
                    },
                    {
                        date: '2023-06-01',
                        action: 'draft_save',
                        changedBy: 'Admin',
                        changes: {
                            bloodTest: { status: 'Done' },
                            urineTest: { status: 'Done' }
                        }
                    }
                ]
            }
        };

        // Track current user (in a real app, this would come from authentication)
        const currentUser = 'Admin';
        
        // Track which employees are in edit mode
        const editMode = {};

        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                tab.classList.add('active');
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
                
                if (tabId === 'history') {
                    loadHistoryData();
                }
            });
        });
        
        // File upload functionality
        document.querySelectorAll('.certificate-input').forEach(input => {
            input.addEventListener('change', function() {
                const empId = this.getAttribute('data-emp');
                const fileName = this.files[0]?.name || 'No file selected';
                const statusElement = this.nextElementSibling.nextElementSibling;
                
                if (this.files[0]) {
                    statusElement.innerHTML = `<i class="fas fa-check"></i> ${fileName}`;
                    statusElement.classList.add('uploaded');
                    testData[empId].certificate = fileName;
                    console.log(`Uploading certificate for employee ${empId}: ${fileName}`);
                }
            });
        });
        
        // Function to add new employee data to the top of the table
        function addNewEmployee() {
            const tableBody = document.getElementById('current-tests-body');
            const newEmpId = 'EMP-' + (Math.floor(Math.random() * 9000) + 1000);
            const today = new Date().toISOString().split('T')[0];
            
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-emp-id', newEmpId);
            newRow.innerHTML = `
                <td>${newEmpId}</td>
                <td contenteditable="true">New Employee</td>
                <td contenteditable="true">Operations</td>
                <td contenteditable="true">Employee</td>
                <td contenteditable="true">Comprehensive</td>
                <td>
                    <select class="test-category">
                        <option value="Regular">Regular</option>
                        <option value="Pre-Joining">Pre-Joining</option>
                    </select>
                </td>
                <td><input type="date" class="test-date" value="${today}"></td>
                <td>
                    <select class="validity-select">
                        <option value="6 Months">6 Months</option>
                        <option value="1 Year" selected>1 Year</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <select class="parameter-select">
                        <option value="Pending" selected>Pending</option>
                        <option value="Done">Done</option>
                        <option value="NA">NA</option>
                        <option value="Expired">Expired</option>
                    </select>
                </td>
                <td>
                    <div class="certificate-upload">
                        <input type="file" id="cert-${newEmpId.replace('EMP-', '')}" class="certificate-input" data-emp="${newEmpId}" accept=".pdf,.jpg,.png">
                        <label for="cert-${newEmpId.replace('EMP-', '')}" class="certificate-btn">
                            <i class="fas fa-upload"></i> Upload
                        </label>
                        <span class="certificate-status">Not uploaded</span>
                    </div>
                </td>
                <td><span class="status draft">Draft</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn save-btn" onclick="saveDraft('${newEmpId}')">Save Draft</button>
                        <button class="action-btn final-btn" onclick="finalSave('${newEmpId}')">Final Save</button>
                        <button class="action-btn history-btn" onclick="viewHistory('${newEmpId}')">History</button>
                    </div>
                </td>
            `;

            // Insert the new row at the top of the table
            tableBody.insertBefore(newRow, tableBody.firstChild);

            // Initialize file upload for the new row
            const newFileInput = newRow.querySelector('.certificate-input');
            newFileInput.addEventListener('change', function() {
                const empId = this.getAttribute('data-emp');
                const fileName = this.files[0]?.name || 'No file selected';
                const statusElement = this.nextElementSibling.nextElementSibling;
                
                if (this.files[0]) {
                    statusElement.innerHTML = `<i class="fas fa-check"></i> ${fileName}`;
                    statusElement.classList.add('uploaded');
                    testData[empId].certificate = fileName;
                }
            });

            // Initialize the data structure for this new employee
            testData[newEmpId] = {
                name: 'New Employee',
                department: 'Operations',
                designation: 'Employee',
                testType: 'Comprehensive',
                testCategory: 'Regular',
                testDate: today,
                validity: '1 Year',
                status: 'draft',
                certificate: 'Not uploaded',
                parameters: {
                    bloodTest: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    urineTest: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    stoolTest: { status: 'Pending', updatedOn: '', updatedBy: '' },
                                      hbsagTest: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    typhoidVaccine: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    hepatitisVaccine: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    chestXRay: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    skinExam: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    vdrl: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    widal: { status: 'Pending', updatedOn: '', updatedBy: '' },
                    eyeExam: { status: 'Pending', updatedOn: '', updatedBy: '' }
                },
                history: []
            };

            // Put the row in edit mode
            editMode[newEmpId] = true;
            newRow.classList.add('edit-mode');
        }

        // Function to edit an employee's record
        function editEmployee(empId) {
            const row = document.querySelector(`tr[data-emp-id="${empId}"]`);
            
            if (editMode[empId]) {
                // Already in edit mode, do nothing
                return;
            }
            
            // Change action buttons
            const actionCell = row.querySelector('td:last-child');
            actionCell.innerHTML = `
                <div class="action-buttons">
                    <button class="action-btn save-btn" onclick="saveDraft('${empId}')">Save Draft</button>
                    <button class="action-btn final-btn" onclick="finalSave('${empId}')">Final Save</button>
                    <button class="action-btn cancel-btn" onclick="cancelEdit('${empId}')">Cancel</button>
                    <button class="action-btn history-btn" onclick="viewHistory('${empId}')">History</button>
                </div>
            `;
            
            // Change status to draft
            const statusCell = row.querySelector('td:nth-last-child(2)');
            statusCell.innerHTML = '<span class="status draft">Draft</span>';
            
            // Enable edit mode
            editMode[empId] = true;
            row.classList.add('edit-mode');
        }

        // Function to cancel editing and revert changes
        function cancelEdit(empId) {
            const row = document.querySelector(`tr[data-emp-id="${empId}"]`);
            const employeeData = testData[empId];
            
            // Revert all editable fields
            row.querySelector('td:nth-child(2)').textContent = employeeData.name;
            row.querySelector('td:nth-child(3)').textContent = employeeData.department;
            row.querySelector('td:nth-child(4)').textContent = employeeData.designation;
            row.querySelector('td:nth-child(5)').textContent = employeeData.testType;
            
            // Revert selects
            row.querySelector('.test-category').value = employeeData.testCategory;
            row.querySelector('.test-date').value = employeeData.testDate;
            row.querySelector('.validity-select').value = employeeData.validity;
            
            // Revert parameter selects
            const parameters = employeeData.parameters;
            const selects = row.querySelectorAll('.parameter-select');
            selects[0].value = parameters.bloodTest.status;
            selects[1].value = parameters.urineTest.status;
            selects[2].value = parameters.stoolTest.status;
            selects[3].value = parameters.hbsagTest.status;
            selects[4].value = parameters.typhoidVaccine.status;
            selects[5].value = parameters.hepatitisVaccine.status;
            selects[6].value = parameters.chestXRay.status;
            selects[7].value = parameters.skinExam.status;
            selects[8].value = parameters.vdrl.status;
            selects[9].value = parameters.widal.status;
            selects[10].value = parameters.eyeExam.status;
            
            // Revert certificate status
            const certStatus = row.querySelector('.certificate-status');
            certStatus.textContent = employeeData.certificate === 'Not uploaded' ? 'Not uploaded' : `<i class="fas fa-check"></i> ${employeeData.certificate}`;
            if (employeeData.certificate !== 'Not uploaded') {
                certStatus.classList.add('uploaded');
            } else {
                certStatus.classList.remove('uploaded');
            }
            
            // Revert action buttons
            const actionCell = row.querySelector('td:last-child');
            actionCell.innerHTML = `
                <div class="action-buttons">
                    <button class="action-btn edit-btn" onclick="editEmployee('${empId}')">Edit</button>
                    <button class="action-btn history-btn" onclick="viewHistory('${empId}')">History</button>
                </div>
            `;
            
            // Revert status
            const statusCell = row.querySelector('td:nth-last-child(2)');
            statusCell.innerHTML = `<span class="status ${employeeData.status}">${employeeData.status.charAt(0).toUpperCase() + employeeData.status.slice(1)}</span>`;
            
            // Disable edit mode
            editMode[empId] = false;
            row.classList.remove('edit-mode');
        }

        // Function to save as draft
        function saveDraft(empId) {
            const row = document.querySelector(`tr[data-emp-id="${empId}"]`);
            const employeeData = testData[empId];
            
            // Get all values from the row
            const name = row.querySelector('td:nth-child(2)').textContent;
            const department = row.querySelector('td:nth-child(3)').textContent;
            const designation = row.querySelector('td:nth-child(4)').textContent;
            const testType = row.querySelector('td:nth-child(5)').textContent;
            const testCategory = row.querySelector('.test-category').value;
            const testDate = row.querySelector('.test-date').value;
            const validity = row.querySelector('.validity-select').value;
            
            // Get parameter values
            const selects = row.querySelectorAll('.parameter-select');
            const bloodTest = selects[0].value;
            const urineTest = selects[1].value;
            const stoolTest = selects[2].value;
            const hbsagTest = selects[3].value;
            const typhoidVaccine = selects[4].value;
            const hepatitisVaccine = selects[5].value;
            const chestXRay = selects[6].value;
            const skinExam = selects[7].value;
            const vdrl = selects[8].value;
            const widal = selects[9].value;
            const eyeExam = selects[10].value;
            
            // Get certificate status
            const certStatus = row.querySelector('.certificate-status');
            const certificate = certStatus.textContent.includes('Not uploaded') ? 'Not uploaded' : certStatus.textContent.replace('<i class="fas fa-check"></i> ', '');
            
            // Track changes for history
            const changes = {};
            const today = new Date().toISOString().split('T')[0];
            
            if (employeeData.name !== name) changes.name = name;
            if (employeeData.department !== department) changes.department = department;
            if (employeeData.designation !== designation) changes.designation = designation;
            if (employeeData.testType !== testType) changes.testType = testType;
            if (employeeData.testCategory !== testCategory) changes.testCategory = testCategory;
            if (employeeData.testDate !== testDate) changes.testDate = testDate;
            if (employeeData.validity !== validity) changes.validity = validity;
            
            // Check parameter changes
            if (employeeData.parameters.bloodTest.status !== bloodTest) {
                changes.bloodTest = { status: bloodTest };
                employeeData.parameters.bloodTest.updatedOn = today;
                employeeData.parameters.bloodTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.urineTest.status !== urineTest) {
                changes.urineTest = { status: urineTest };
                employeeData.parameters.urineTest.updatedOn = today;
                employeeData.parameters.urineTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.stoolTest.status !== stoolTest) {
                changes.stoolTest = { status: stoolTest };
                employeeData.parameters.stoolTest.updatedOn = today;
                employeeData.parameters.stoolTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.hbsagTest.status !== hbsagTest) {
                changes.hbsagTest = { status: hbsagTest };
                employeeData.parameters.hbsagTest.updatedOn = today;
                employeeData.parameters.hbsagTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.typhoidVaccine.status !== typhoidVaccine) {
                changes.typhoidVaccine = { status: typhoidVaccine };
                employeeData.parameters.typhoidVaccine.updatedOn = today;
                employeeData.parameters.typhoidVaccine.updatedBy = currentUser;
            }
            if (employeeData.parameters.hepatitisVaccine.status !== hepatitisVaccine) {
                changes.hepatitisVaccine = { status: hepatitisVaccine };
                employeeData.parameters.hepatitisVaccine.updatedOn = today;
                employeeData.parameters.hepatitisVaccine.updatedBy = currentUser;
            }
            if (employeeData.parameters.chestXRay.status !== chestXRay) {
                changes.chestXRay = { status: chestXRay };
                employeeData.parameters.chestXRay.updatedOn = today;
                employeeData.parameters.chestXRay.updatedBy = currentUser;
            }
            if (employeeData.parameters.skinExam.status !== skinExam) {
                changes.skinExam = { status: skinExam };
                employeeData.parameters.skinExam.updatedOn = today;
                employeeData.parameters.skinExam.updatedBy = currentUser;
            }
            if (employeeData.parameters.vdrl.status !== vdrl) {
                changes.vdrl = { status: vdrl };
                employeeData.parameters.vdrl.updatedOn = today;
                employeeData.parameters.vdrl.updatedBy = currentUser;
            }
            if (employeeData.parameters.widal.status !== widal) {
                changes.widal = { status: widal };
                employeeData.parameters.widal.updatedOn = today;
                employeeData.parameters.widal.updatedBy = currentUser;
            }
            if (employeeData.parameters.eyeExam.status !== eyeExam) {
                changes.eyeExam = { status: eyeExam };
                employeeData.parameters.eyeExam.updatedOn = today;
                employeeData.parameters.eyeExam.updatedBy = currentUser;
            }
            if (employeeData.certificate !== certificate) changes.certificate = certificate;
            
            // Update the main data object
            employeeData.name = name;
            employeeData.department = department;
            employeeData.designation = designation;
            employeeData.testType = testType;
            employeeData.testCategory = testCategory;
            employeeData.testDate = testDate;
            employeeData.validity = validity;
            employeeData.status = 'draft';
            employeeData.certificate = certificate;
            
            employeeData.parameters.bloodTest.status = bloodTest;
            employeeData.parameters.urineTest.status = urineTest;
            employeeData.parameters.stoolTest.status = stoolTest;
            employeeData.parameters.hbsagTest.status = hbsagTest;
            employeeData.parameters.typhoidVaccine.status = typhoidVaccine;
            employeeData.parameters.hepatitisVaccine.status = hepatitisVaccine;
            employeeData.parameters.chestXRay.status = chestXRay;
            employeeData.parameters.skinExam.status = skinExam;
            employeeData.parameters.vdrl.status = vdrl;
            employeeData.parameters.widal.status = widal;
            employeeData.parameters.eyeExam.status = eyeExam;
            
            // Add to history if there are changes
            if (Object.keys(changes).length > 0) {
                employeeData.history.unshift({
                    date: today,
                    action: 'draft_save',
                    changedBy: currentUser,
                    changes: changes
                });
            }
            
            // Show success message
            alert('Draft saved successfully!');
            
            // Update counts (in a real app, this would be calculated from all employee data)
            updateCounts();
        }

        // Function to final save
        function finalSave(empId) {
            const row = document.querySelector(`tr[data-emp-id="${empId}"]`);
            const employeeData = testData[empId];
            
            // Get all values from the row (same as saveDraft)
            const name = row.querySelector('td:nth-child(2)').textContent;
            const department = row.querySelector('td:nth-child(3)').textContent;
            const designation = row.querySelector('td:nth-child(4)').textContent;
            const testType = row.querySelector('td:nth-child(5)').textContent;
            const testCategory = row.querySelector('.test-category').value;
            const testDate = row.querySelector('.test-date').value;
            const validity = row.querySelector('.validity-select').value;
            
            const selects = row.querySelectorAll('.parameter-select');
            const bloodTest = selects[0].value;
            const urineTest = selects[1].value;
            const stoolTest = selects[2].value;
            const hbsagTest = selects[3].value;
            const typhoidVaccine = selects[4].value;
            const hepatitisVaccine = selects[5].value;
            const chestXRay = selects[6].value;
            const skinExam = selects[7].value;
            const vdrl = selects[8].value;
            const widal = selects[9].value;
            const eyeExam = selects[10].value;
            
            const certStatus = row.querySelector('.certificate-status');
            const certificate = certStatus.textContent.includes('Not uploaded') ? 'Not uploaded' : certStatus.textContent.replace('<i class="fas fa-check"></i> ', '');
            
            // Track changes for history
            const changes = {};
            const today = new Date().toISOString().split('T')[0];
            
            if (employeeData.name !== name) changes.name = name;
            if (employeeData.department !== department) changes.department = department;
            if (employeeData.designation !== designation) changes.designation = designation;
            if (employeeData.testType !== testType) changes.testType = testType;
            if (employeeData.testCategory !== testCategory) changes.testCategory = testCategory;
            if (employeeData.testDate !== testDate) changes.testDate = testDate;
            if (employeeData.validity !== validity) changes.validity = validity;
            
            // Check parameter changes
            if (employeeData.parameters.bloodTest.status !== bloodTest) {
                changes.bloodTest = { status: bloodTest };
                employeeData.parameters.bloodTest.updatedOn = today;
                employeeData.parameters.bloodTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.urineTest.status !== urineTest) {
                changes.urineTest = { status: urineTest };
                employeeData.parameters.urineTest.updatedOn = today;
                employeeData.parameters.urineTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.stoolTest.status !== stoolTest) {
                changes.stoolTest = { status: stoolTest };
                employeeData.parameters.stoolTest.updatedOn = today;
                employeeData.parameters.stoolTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.hbsagTest.status !== hbsagTest) {
                changes.hbsagTest = { status: hbsagTest };
                employeeData.parameters.hbsagTest.updatedOn = today;
                employeeData.parameters.hbsagTest.updatedBy = currentUser;
            }
            if (employeeData.parameters.typhoidVaccine.status !== typhoidVaccine) {
                changes.typhoidVaccine = { status: typhoidVaccine };
                employeeData.parameters.typhoidVaccine.updatedOn = today;
                employeeData.parameters.typhoidVaccine.updatedBy = currentUser;
            }
            if (employeeData.parameters.hepatitisVaccine.status !== hepatitisVaccine) {
                changes.hepatitisVaccine = { status: hepatitisVaccine };
                employeeData.parameters.hepatitisVaccine.updatedOn = today;
                employeeData.parameters.hepatitisVaccine.updatedBy = currentUser;
            }
            if (employeeData.parameters.chestXRay.status !== chestXRay) {
                changes.chestXRay = { status: chestXRay };
                employeeData.parameters.chestXRay.updatedOn = today;
                employeeData.parameters.chestXRay.updatedBy = currentUser;
            }
            if (employeeData.parameters.skinExam.status !== skinExam) {
                changes.skinExam = { status: skinExam };
                employeeData.parameters.skinExam.updatedOn = today;
                employeeData.parameters.skinExam.updatedBy = currentUser;
            }
            if (employeeData.parameters.vdrl.status !== vdrl) {
                changes.vdrl = { status: vdrl };
                employeeData.parameters.vdrl.updatedOn = today;
                employeeData.parameters.vdrl.updatedBy = currentUser;
            }
            if (employeeData.parameters.widal.status !== widal) {
                changes.widal = { status: widal };
                employeeData.parameters.widal.updatedOn = today;
                employeeData.parameters.widal.updatedBy = currentUser;
            }
            if (employeeData.parameters.eyeExam.status !== eyeExam) {
                changes.eyeExam = { status: eyeExam };
                employeeData.parameters.eyeExam.updatedOn = today;
                employeeData.parameters.eyeExam.updatedBy = currentUser;
            }
            if (employeeData.certificate !== certificate) changes.certificate = certificate;
            
            // Update the main data object
            employeeData.name = name;
            employeeData.department = department;
            employeeData.designation = designation;
            employeeData.testType = testType;
            employeeData.testCategory = testCategory;
            employeeData.testDate = testDate;
            employeeData.validity = validity;
            employeeData.status = 'final';
            employeeData.certificate = certificate;
            
            employeeData.parameters.bloodTest.status = bloodTest;
            employeeData.parameters.urineTest.status = urineTest;
            employeeData.parameters.stoolTest.status = stoolTest;
            employeeData.parameters.hbsagTest.status = hbsagTest;
            employeeData.parameters.typhoidVaccine.status = typhoidVaccine;
            employeeData.parameters.hepatitisVaccine.status = hepatitisVaccine;
            employeeData.parameters.chestXRay.status = chestXRay;
            employeeData.parameters.skinExam.status = skinExam;
            employeeData.parameters.vdrl.status = vdrl;
            employeeData.parameters.widal.status = widal;
            employeeData.parameters.eyeExam.status = eyeExam;
            
            // Add to history
            employeeData.history.unshift({
                date: today,
                action: 'final_save',
                changedBy: currentUser,
                changes: changes
            });
            
            // Update the UI to show it's no longer in edit mode
            const actionCell = row.querySelector('td:last-child');
            actionCell.innerHTML = `
                <div class="action-buttons">
                    <button class="action-btn edit-btn" onclick="editEmployee('${empId}')">Edit</button>
                    <button class="action-btn history-btn" onclick="viewHistory('${empId}')">History</button>
                </div>
            `;
            
            // Update status
            const statusCell = row.querySelector('td:nth-last-child(2)');
            statusCell.innerHTML = '<span class="status final">Final</span>';
            
            // Disable edit mode
            editMode[empId] = false;
            row.classList.remove('edit-mode');
            
            // Show success message
            alert('Final save successful!');
            
            // Update counts
            updateCounts();
        }

        // Function to view history
        function viewHistory(empId) {
            const employeeData = testData[empId];
            
            // Set modal header info
            document.getElementById('history-emp-name').textContent = employeeData.name;
            document.getElementById('history-emp-id').textContent = empId;
            document.getElementById('history-test-type').textContent = employeeData.testType;
            document.getElementById('history-current-status').textContent = employeeData.status.charAt(0).toUpperCase() + employeeData.status.slice(1);
            
            // Clear previous history data
            document.getElementById('parameter-history-details').innerHTML = '';
            document.getElementById('change-history-details').innerHTML = '';
            
            // Add parameter history
            const paramsHistoryTable = document.getElementById('parameter-history-details');
            
            // Current values row
            const currentRow = document.createElement('tr');
            currentRow.className = 'history-header';
            currentRow.innerHTML = `
                <td>Current</td>
                <td>${employeeData.testDate}</td>
                <td>${employeeData.validity}</td>
                <td><span class="parameter-status ${employeeData.parameters.bloodTest.status.toLowerCase()}">${employeeData.parameters.bloodTest.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.urineTest.status.toLowerCase()}">${employeeData.parameters.urineTest.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.stoolTest.status.toLowerCase()}">${employeeData.parameters.stoolTest.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.hbsagTest.status.toLowerCase()}">${employeeData.parameters.hbsagTest.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.typhoidVaccine.status.toLowerCase()}">${employeeData.parameters.typhoidVaccine.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.hepatitisVaccine.status.toLowerCase()}">${employeeData.parameters.hepatitisVaccine.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.chestXRay.status.toLowerCase()}">${employeeData.parameters.chestXRay.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.skinExam.status.toLowerCase()}">${employeeData.parameters.skinExam.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.vdrl.status.toLowerCase()}">${employeeData.parameters.vdrl.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.widal.status.toLowerCase()}">${employeeData.parameters.widal.status}</span></td>
                <td><span class="parameter-status ${employeeData.parameters.eyeExam.status.toLowerCase()}">${employeeData.parameters.eyeExam.status}</span></td>
                <td>${employeeData.certificate === 'Not uploaded' ? 'Not uploaded' : `<i class="fas fa-check"></i> ${employeeData.certificate}`}</td>
            `;
            paramsHistoryTable.appendChild(currentRow);
            
            // Add history rows
            employeeData.history.forEach(historyItem => {
                const row = document.createElement('tr');
                
                let rowContent = `
                    <td>${historyItem.date}</td>
                    <td>${historyItem.action === 'draft_save' ? 'Draft Save' : 'Final Save'}</td>
                    <td>${historyItem.changedBy}</td>
                    <td>
                `;
                
                // Add change details
                const changeDetails = [];
                for (const [key, value] of Object.entries(historyItem.changes)) {
                    if (key === 'certificate') {
                        changeDetails.push(`Certificate: ${value}`);
                    } else if (key in employeeData.parameters) {
                        changeDetails.push(`${key}: ${value.status}`);
                    } else {
                        changeDetails.push(`${key}: ${value}`);
                    }
                }
                
                rowContent += changeDetails.join('<br>') + '</td>';
                row.innerHTML = rowContent;
                document.getElementById('change-history-details').appendChild(row);
            });
            
            // Show the modal
            document.getElementById('historyModal').style.display = 'flex';
        }

        // Function to close modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Function to load history data for the history tab
        function loadHistoryData() {
            const historyBody = document.getElementById('history-body');
            historyBody.innerHTML = '';
            
            // In a real app, this would fetch from a database
            // For now, we'll just show some sample data
            for (const [empId, data] of Object.entries(testData)) {
                if (data.history.length > 0) {
                    data.history.forEach(historyItem => {
                        const row = document.createElement('tr');
                        
                        // Count how many parameters are done
                        let doneCount = 0;
                        for (const param in data.parameters) {
                            if (data.parameters[param].status === 'Done') doneCount++;
                        }
                        
                        row.innerHTML = `
                            <td>${empId}</td>
                            <td>${data.name}</td>
                            <td>${data.testType}</td>
                            <td>${data.testDate}</td>
                            <td>${doneCount}/11</td>
                            <td><span class="status ${historyItem.action === 'final_save' ? 'final' : 'draft'}">${historyItem.action === 'final_save' ? 'Final' : 'Draft'}</span></td>
                            <td>${historyItem.date}</td>
                            <td>${historyItem.changedBy}</td>
                        `;
                        historyBody.appendChild(row);
                    });
                }
            }
        }

        // Function to update dashboard counts
        function updateCounts() {
            // In a real app, these would be calculated from all employee data
            // For now, we'll just update with some sample values
            document.getElementById('total-employees').textContent = '142';
            document.getElementById('completed-tests-count').textContent = '87';
            document.getElementById('pending-tests').textContent = '32';
            document.getElementById('expired-tests').textContent = '23';
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener for "Add New Employee" button
            document.getElementById('addNewEmployeeBtn').addEventListener('click', addNewEmployee);
            
            // Initialize counts
            updateCounts();
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === document.getElementById('historyModal')) {
                    closeModal('historyModal');
                }
            });
        });
    </script>


   