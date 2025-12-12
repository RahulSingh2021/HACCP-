<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Calibration Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- Design System & Variables --- */
        :root {
            /* Adaptive Font Size */
            font-size: clamp(14px, 1.2vw + 0.25rem, 16px);
            
            /* Color Palette */
            --primary-color: #0a4d68;
            --primary-light: #0d6e8f;
            --secondary-color: #088395;
            --secondary-light: #0aa5c0;
            --accent-color: #05bfdb;
            --accent-light: #0ae0ff;
            --light-color: #f8fcff;
            --light-gray: #f0f5f9;
            --medium-gray: #e1e8ed;
            --dark-color: #2d3748;
            --text-color: #4a5568;
            --text-light: #718096;
            
            /* Status Colors */
            --status-ok: #38a169;
            --status-due: #d69e2e;
            --status-overdue: #e53e3e;
            --status-warning: #dd6b20;
            --status-info: #3182ce;
            
            /* Shadows */
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
            
            /* Spacing */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
            
            /* Border Radius */
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 0.15s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.5s ease;
        }

        /* --- Base Styles --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            background-color: var(--light-gray);
            color: var(--text-color);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 1800px;
            margin: 0 auto;
            padding: var(--space-md);
        }

        h1, h2, h3, h4 {
            color: var(--dark-color);
            margin-top: 0;
            font-weight: 600;
            line-height: 1.25;
        }

        h1 { font-size: 2rem; }
        h2 { font-size: 1.5rem; }
        h3 { font-size: 1.25rem; }
        h4 { font-size: 1rem; }

        a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        a:hover {
            color: var(--primary-light);
        }

        /* Accessibility Helper */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* --- Layout Components --- */
        .card {
            background-color: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: var(--space-lg);
            transition: box-shadow var(--transition-normal);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--space-md);
            margin-bottom: var(--space-md);
            padding-bottom: var(--space-sm);
            border-bottom: 1px solid var(--medium-gray);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
        }

        /* --- Header & Navigation --- */
        .header {
            background-color: white;
            padding: var(--space-md);
            border-bottom: 1px solid var(--medium-gray);
            margin-bottom: var(--space-lg);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }

        .header-icon {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .main-nav {
            display: flex;
            gap: var(--space-sm);
        }

        .nav-btn {
            background-color: transparent;
            border: none;
            color: var(--text-light);
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all var(--transition-normal);
            display: flex;
            align-items: center;
            gap: var(--space-xs);
        }

        .nav-btn:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        .nav-btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        .nav-btn i {
            font-size: 0.9rem;
        }
        
        /* --- General Table Styles --- */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .data-table th, .data-table td {
            padding: var(--space-md) var(--space-lg);
            text-align: left;
            border-bottom: 1px solid var(--medium-gray);
            vertical-align: top; /* Changed for better multi-line alignment */
        }
        
        .data-table th:first-child, .data-table td:first-child {
            width: 1%;
            padding-right: var(--space-sm);
        }

        .data-table th {
            background-color: var(--light-gray);
            font-weight: 600;
            color: var(--dark-color);
            position: sticky;
            top: 0;
            white-space: nowrap;
        }
        
        .th-content {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }

        .table-sort-icon, .table-filter-icon {
            cursor: pointer;
            color: var(--text-light);
            transition: color var(--transition-fast);
        }
        .table-filter-icon {
            font-size: 0.8em;
        }
        .th-content:hover .table-sort-icon,
        .th-content:hover .table-filter-icon {
            color: var(--text-color);
        }
        .table-filter-icon.active {
            color: var(--primary-color);
        }

        .data-table tbody tr {
            transition: background-color var(--transition-fast), border-left-color var(--transition-fast), opacity var(--transition-normal);
            border-left: 4px solid transparent; 
        }
        .data-table tr.status-border-overdue { border-left-color: var(--status-overdue); }
        .data-table tr.status-border-due-soon { border-left-color: var(--status-due); }
        .data-table tr.status-border-warning { border-left-color: var(--status-warning); }
        .data-table tr.status-border-compliant { border-left-color: var(--status-ok); }


        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background-color: var(--light-color);
        }
        
        .details-cell {
            white-space: normal;
            line-height: 1.5;
            min-width: 200px;
        }

        .details-main {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: var(--space-xs);
        }

        .details-sub {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .details-sub strong {
            color: var(--text-color);
            font-weight: 500;
        }

        .inline-edit-input {
            width: 95%;
            padding: var(--space-xs);
            font-size: 0.9rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--radius-sm);
            background-color: var(--light-color);
            margin-bottom: 2px;
        }
        select.inline-edit-input {
            width: auto;
            max-width: 95%;
            padding: 2px;
        }
        
        .view-cert-link {
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            color: var(--primary-color);
        }
        .view-cert-link:hover {
            text-decoration: underline;
        }
        .view-cert-link i {
            margin-right: var(--space-xs);
        }

        /* --- Dashboard Specific Styles --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: var(--space-md);
            margin-bottom: var(--space-xl);
        }

        .stat-card {
            background-color: white;
            padding: var(--space-lg);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            text-align: center;
            border-top: 4px solid var(--primary-color);
            transition: transform var(--transition-fast), box-shadow var(--transition-fast);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card.due { border-color: var(--status-due); }
        .stat-card.overdue { border-color: var(--status-overdue); }
        .stat-card.warning { border-color: var(--status-warning); }
        
        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-sm);
        }

        .stat-icon {
            font-size: 1.25rem;
        }

        .stat-card .stat-icon { color: var(--primary-color); }
        .stat-card.due .stat-icon { color: var(--status-due); }
        .stat-card.overdue .stat-icon { color: var(--status-overdue); }
        .stat-card:has(#compliant-stat) .stat-icon { color: var(--status-ok); }

        .stat-card h3 {
            margin: 0;
            font-size: 0.95rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .stat-number {
            font-size: 2.25rem;
            font-weight: 700;
            margin: var(--space-sm) 0;
            color: var(--primary-color);
        }

        .stat-card.due .stat-number { color: var(--status-due); }
        .stat-card.overdue .stat-number { color: var(--status-overdue); }
        .stat-card.warning .stat-number { color: var(--status-warning); }
        
        .stat-trend {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-xs);
        }

        .trend-up { color: var(--status-overdue); }
        .trend-down { color: var(--status-ok); }

        /* --- Status Badges --- */
        .status-badge {
            padding: var(--space-xs) var(--space-sm);
            border-radius: var(--radius-full);
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: var(--space-xs);
            white-space: nowrap;
        }

        .status-badge i {
            font-size: 0.7rem;
        }

        .status-compliant { background-color: var(--status-ok); }
        .status-due-soon { background-color: var(--status-due); }
        .status-overdue { background-color: var(--status-overdue); }
        .status-warning { background-color: var(--status-warning); }
        .status-info { background-color: var(--status-info); }

        /* --- Action Buttons --- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-xs);
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            border: 1px solid transparent;
        }

        .btn-sm {
            padding: var(--space-xs) var(--space-sm);
            font-size: 0.8rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }
        .btn-outline {
            background-color: transparent;
            border-color: var(--medium-gray);
            color: var(--text-color);
        }

        .btn-outline:hover {
            background-color: var(--light-gray);
            border-color: var(--medium-gray);
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons {
            display: flex;
            gap: var(--space-xs);
            flex-wrap: nowrap;
        }

        /* --- List Controls --- */
        .list-controls {
            margin-bottom: var(--space-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--space-md);
        }

        .search-input {
            position: relative;
            flex-grow: 1;
            min-width: 250px;
            max-width: 400px;
        }

        .search-input input {
            width: 100%;
            padding: var(--space-sm) var(--space-md) var(--space-sm) 2.5rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
            background-color: white;
        }

        .search-input input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(10, 77, 104, 0.1);
        }

        .search-icon {
            position: absolute;
            left: var(--space-md);
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
        }

        .filter-controls {
            display: flex;
            gap: var(--space-sm);
            align-items: center;
        }

        .filter-select {
            padding: var(--space-sm) var(--space-md);
            border: 1px solid var(--medium-gray);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            background-color: white;
            cursor: pointer;
        }
        
        /* --- Dropdown Menu for Export --- */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: var(--shadow-md);
            z-index: 1;
            border-radius: var(--radius-sm);
            overflow: hidden;
            right: 0;
        }
        .dropdown-content button {
            color: var(--text-color);
            background: white;
            width: 100%;
            border: none;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            text-align: left;
            cursor: pointer;
        }
        .dropdown-content button:hover {background-color: var(--light-gray);}
        .dropdown:hover .dropdown-content {display: block;}

        /* --- Pagination --- */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--space-lg);
            flex-wrap: wrap;
            gap: var(--space-md);
        }
        .items-per-page-selector {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            font-size: 0.9rem;
            color: var(--text-light);
        }
        .items-per-page-selector label {
            font-weight: 500;
        }
        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: var(--space-xs);
        }
        .pagination-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            background-color: white;
            border: 1px solid var(--medium-gray);
            cursor: pointer;
            transition: all var(--transition-fast);
        }
        .pagination-btn:hover { background-color: var(--light-gray); }
        .pagination-btn.active { background-color: var(--primary-color); color: white; border-color: var(--primary-color); }
        .pagination-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        /* --- Tooltips --- */
        .tooltip { position: relative; display: inline-block; }
        .tooltip .tooltip-text {
            visibility: hidden; width: 120px; background-color: var(--dark-color); color: white;
            text-align: center; border-radius: var(--radius-sm); padding: var(--space-xs) var(--space-sm);
            position: absolute; z-index: 1; bottom: 125%; left: 50%; transform: translateX(-50%);
            opacity: 0; transition: opacity var(--transition-fast); font-size: 0.8rem; pointer-events: none;
        }
        .tooltip:hover .tooltip-text { visibility: visible; opacity: 1; }

        /* --- Modals, Bulk Actions & Notifications --- */
        .bulk-actions-bar {
            display: none;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-sm) var(--space-lg);
            background-color: var(--primary-color);
            color: white;
            border-radius: var(--radius-md);
            margin-bottom: var(--space-lg);
            animation: fadeIn 0.3s;
        }
        .bulk-actions-bar.visible { display: flex; }
        .bulk-actions-bar span { font-weight: 500; }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn var(--transition-normal);
        }
        .modal-overlay.visible { display: flex; }
        .modal-box {
            background: white;
            border-radius: var(--radius-md);
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
            animation: scaleIn 0.3s;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }


        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-lg); }
        .modal-close-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-light); }
        .modal-body .form-group { margin-bottom: var(--space-md); }
        .modal-body label { display: block; margin-bottom: var(--space-xs); font-weight: 500; }
        .modal-body input {
            width: 100%; padding: var(--space-sm) var(--space-md); border: 1px solid var(--medium-gray);
            border-radius: var(--radius-md); font-size: 0.95rem;
        }
        .modal-footer { display: flex; justify-content: flex-end; gap: var(--space-sm); margin-top: var(--space-lg); }

        .reminder-bar {
            background-color: var(--status-warning);
            color: white;
            padding: var(--space-md);
            border-radius: var(--radius-md);
            margin-bottom: var(--space-lg);
            display: none; /* Hidden by default */
        }
        .reminder-content { display: flex; justify-content: space-between; align-items: center; }
        .reminder-close { font-size: 1.2rem; cursor: pointer; background: none; border: none; color: white; }

        .filter-dropdown {
            position: absolute;
            z-index: 101;
            background-color: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            width: 250px;
            display: none;
        }
        .filter-dropdown.visible { display: block; }
        .filter-dropdown-header {
            padding: var(--space-sm) var(--space-md);
            border-bottom: 1px solid var(--medium-gray);
        }
        .filter-dropdown-header input {
            width: 100%;
            border: 1px solid var(--medium-gray);
            border-radius: var(--radius-sm);
            padding: var(--space-xs);
        }
        .filter-dropdown-body {
            max-height: 200px;
            overflow-y: auto;
            padding: var(--space-sm);
        }
        .filter-item {
            display: block;
            padding: var(--space-xs) var(--space-sm);
        }
        .filter-item label {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            font-size: 0.9rem;
            cursor: pointer;
        }
        .filter-dropdown-footer {
            padding: var(--space-sm) var(--space-md);
            border-top: 1px solid var(--medium-gray);
            display: flex;
            justify-content: space-between;
        }

        /* --- Deactivated Row Style --- */
        .data-table .deactivated-row {
            opacity: 0.5;
            background-color: #f8f9fa;
        }
        .data-table .deactivated-row:hover {
            opacity: 0.7;
        }
        .data-table .deactivated-row .btn:not(.activate-btn) {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.5;
        }
        .data-table .deactivated-row .details-main, 
        .data-table .deactivated-row .details-sub {
             text-decoration: line-through;
        }

        /* --- Renew Modal Specific Styles --- */
        #renew-modal .modal-box { padding: 0; }
        #renew-modal .modal-header { margin-bottom: 0; }
        #renew-modal .modal-footer { margin-top: 0; }
        #renew-modal input[readonly] {
            background-color: var(--light-gray);
            cursor: not-allowed;
        }
        #renew-form label {
            display: block;
            margin-bottom: var(--space-xs);
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-light);
        }
        #renew-form input[type="text"],
        #renew-form input[type="date"] {
            width: 100%;
            padding: var(--space-sm) var(--space-md);
            border: 1px solid var(--medium-gray);
            border-radius: var(--radius-sm);
            font-size: 0.95rem;
        }

        /* --- Mobile Responsive Table Styles --- */
        @media (max-width: 992px) {
            .data-table {
                box-shadow: none;
                background-color: transparent;
                border-radius: 0;
            }
            .data-table thead {
                display: none;
            }
            .data-table tbody {
                display: block;
            }
            .data-table tr {
                display: block;
                margin-bottom: var(--space-md);
                border-radius: var(--radius-md);
                box-shadow: var(--shadow-sm);
                border-bottom: none;
                background-color: white;
                padding: var(--space-md);
            }
            .data-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: var(--space-sm) 0;
                border-bottom: 1px solid var(--light-gray);
            }
            .data-table td:first-child, .data-table td:last-child {
                width: auto;
                padding-right: 0;
            }
            .data-table td::before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                color: var(--dark-color);
                margin-right: var(--space-md);
            }
            .data-table td[data-label="Actions"] {
                justify-content: flex-end;
            }
            .data-table td[data-label="Select"],
            .data-table td[data-label="Actions"]::before {
                display: none;
            }
        }
        
        /* General Responsive Design */
        @media (max-width: 768px) {
            .header { flex-direction: column; align-items: stretch; gap: var(--space-md); }
            .main-nav { width: 100%; overflow-x: auto; padding-bottom: var(--space-xs); }
            .nav-btn { flex-shrink: 0; }
            .list-controls { flex-direction: column; align-items: stretch; }
            .search-input { max-width: 100%; }
            .pagination-container { flex-direction: column; align-items: center; }
        }
        @media (max-width: 576px) {
            .container { padding: var(--space-sm); }
            .card { padding: var(--space-md); }
            .stats-grid { grid-template-columns: 1fr; }
        }

        /* START: Added styles for multi-detail editing */
        .detail-edit-group {
            position: relative;
            padding: var(--space-sm) 0;
            border-top: 1px solid var(--light-gray);
        }
        .detail-edit-group:first-child {
            border-top: none;
            padding-top: 0;
        }
         .detail-edit-group:last-child {
            padding-bottom: 0;
        }
        .detail-edit-group .details-sub, .detail-edit-group .details-main {
            padding-right: 40px; /* Space for remove button */
        }

        .remove-detail-btn {
            position: absolute !important;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            border-color: var(--status-overdue) !important;
            color: var(--status-overdue) !important;
            background-color: white !important;
            width: 28px !important;
            height: 28px !important;
            padding: 0 !important;
        }
        .remove-detail-btn:hover {
            background-color: var(--light-gray) !important;
        }
        .add-detail-btn {
            margin-top: var(--space-md);
            width: 100%;
            border-style: dashed;
        }
        /* END: Added styles for multi-detail editing */
    </style>
</head>
<body>

    <div class="container">
        <header class="header" role="banner">
            <div class="header-title">
                <i class="fas fa-tools header-icon" aria-hidden="true"></i>
                <h1>Equipment Calibration System</h1>
            </div>
            
        </header>

        <main role="main">
            <div id="list">
                <!-- Reminder Bar -->
                <div id="reminder-bar" class="reminder-bar" role="alert">
                    <div class="reminder-content">
                        <div id="reminder-text"></div>
                        <button id="reminder-close" class="reminder-close" aria-label="Dismiss reminder">×</button>
                    </div>
                </div>

                <h2>Overview</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <i class="fas fa-tools stat-icon" aria-hidden="true"></i>
                            <h3>Total Equipment</h3>
                        </div>
                        <div id="total-equip-stat" class="stat-number">0</div>
                        <div class="stat-trend trend-down">
                            <i class="fas fa-arrow-down" aria-hidden="true"></i> 2% from last month
                        </div>
                    </div>
                    <div class="stat-card due">
                        <div class="stat-card-header">
                            <i class="fas fa-exclamation-circle stat-icon" aria-hidden="true"></i>
                            <h3>Due in 30 Days</h3>
                        </div>
                        <div id="due-soon-stat" class="stat-number">0</div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up" aria-hidden="true"></i> 5% from last month
                        </div>
                    </div>
                    <div class="stat-card overdue">
                        <div class="stat-card-header">
                            <i class="fas fa-clock stat-icon" aria-hidden="true"></i>
                            <h3>Overdue</h3>
                        </div>
                        <div id="overdue-stat" class="stat-number">0</div>
                        <div class="stat-trend trend-down">
                            <i class="fas fa-arrow-down" aria-hidden="true"></i> 10% from last month
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <i class="fas fa-check-circle stat-icon" aria-hidden="true"></i>
                            <h3>Compliant</h3>
                        </div>
                        <div id="compliant-stat" class="stat-number">0</div>
                        <div class="stat-trend trend-up">
                            <i class="fas fa-arrow-up" aria-hidden="true"></i> 3% from last month
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h2 id="list-title" class="card-title">Full Equipment List</h2>
                        <div class="card-actions" style="display: flex; gap: var(--space-sm);">
                             <div class="dropdown">
                                <button class="btn btn-outline" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-download" aria-hidden="true"></i> Export
                                </button>
                                <div class="dropdown-content">
                                    <button id="export-csv-btn"><i class="fas fa-file-csv" aria-hidden="true"></i> Export as CSV</button>
                                    <button id="export-json-btn"><i class="fas fa-file-code" aria-hidden="true"></i> Export as JSON</button>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    
                    <div class="list-controls">
                        <div class="search-input">
                            <label for="searchInput" class="visually-hidden">Search Equipment</label>
                            <i class="fas fa-search search-icon" aria-hidden="true"></i>
                            <input type="text" id="searchInput" placeholder="Search by name, ID, brand, etc..." aria-label="Search Equipment">
                        </div>
                        
                        <div class="filter-controls">
                             <button id="refresh-btn" class="btn btn-icon btn-outline tooltip" aria-label="Refresh Data">
                                <i class="fas fa-sync-alt" aria-hidden="true"></i>
                                <span class="tooltip-text">Refresh Data</span>
                            </button>
                        </div>
                    </div>
                    
                    <div id="bulk-actions-bar" class="bulk-actions-bar" aria-live="polite">
                        <span id="selected-count">0 items selected</span>
                        <button id="bulk-update-btn" class="btn btn-sm btn-outline" style="background-color: white; color: var(--primary-color);">
                            <i class="fas fa-calendar-day" aria-hidden="true"></i> Update Selected
                        </button>
                    </div>

                    <div class="table-container">
                        <table id="equipment-table" class="data-table" aria-labelledby="list-title">
                            <thead>
                                <tr>
                                    <th scope="col"><label class="visually-hidden" for="select-all-checkbox">Select all items</label><input type="checkbox" id="select-all-checkbox" aria-label="Select all items on this page"></th>
                                    <th scope="col" data-column="department" data-order="desc">
                                        <div class="th-content">
                                            <span>Hierarchy / Location</span>
                                            <i class="fas fa-sort table-sort-icon" aria-hidden="true"></i>
                                            <i class="fas fa-filter table-filter-icon" data-column-filter="department" aria-label="Filter by Department" role="button"></i>
                                        </div>
                                    </th>
                                    <th scope="col" data-column="equipment_name" data-order="desc">
                                        <div class="th-content">
                                            <span>Equipment</span>
                                            <i class="fas fa-sort table-sort-icon" aria-hidden="true"></i>
                                            <i class="fas fa-filter table-filter-icon" data-column-filter="brand" aria-label="Filter by Brand" role="button"></i>
                                        </div>
                                    </th>
                                    <th scope="col" data-column="calibration_id" data-order="desc">
                                        <div class="th-content">
                                            <span>Calibration Details</span>
                                            <i class="fas fa-sort table-sort-icon" aria-hidden="true"></i>
                                            <i class="fas fa-filter table-filter-icon" data-column-filter="calibration_type" aria-label="Filter by Calibration Type" role="button"></i>
                                        </div>
                                    </th>
                                    <th scope="col" data-column="capacity_range" data-order="desc">
                                        <div class="th-content">
                                            <span>Range & Precision</span>
                                             <i class="fas fa-sort table-sort-icon" aria-hidden="true"></i>
                                             <i class="fas fa-filter table-filter-icon" data-column-filter="capacity_range" aria-label="Filter by Capacity Range" role="button"></i>
                                        </div>
                                    </th>
                                    <th scope="col" data-column="calibration_date" data-order="desc">
                                        <div class="th-content">
                                            <span>Calibration Period</span>
                                            <i class="fas fa-sort table-sort-icon" aria-hidden="true"></i>
                                            <i class="fas fa-filter table-filter-icon" data-column-filter="formattedCalibration" aria-label="Filter by Calibration Date" role="button"></i>
                                        </div>
                                    </th>
                                    <th scope="col" data-column="status" data-order="desc">
                                        <div class="th-content">
                                            <span>Status</span><i class="fas fa-sort table-sort-icon" aria-hidden="true"></i>
                                            <i class="fas fa-filter table-filter-icon" data-column-filter="status" aria-label="Filter by status" role="button"></i>
                                        </div>
                                    </th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="equipment-tbody">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-container">
                        <div class="items-per-page-selector">
                            <label for="items-per-page">Rows:</label>
                            <select id="items-per-page" class="filter-select" style="padding: var(--space-xs) var(--space-sm);">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span id="pagination-summary" aria-live="polite"></span>
                        </div>
                        <div class="pagination" role="navigation" aria-label="Pagination">
                            <button class="pagination-btn" id="prev-page-btn" disabled aria-label="Go to previous page">
                                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                            </button>
                            <div id="pagination-pages" class="pagination"></div>
                            <button class="pagination-btn" id="next-page-btn" aria-label="Go to next page">
                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Hidden file input for uploads -->
    <input type="file" id="certificate-uploader" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">

    <!-- Bulk Update Modal -->
    <div id="bulk-update-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="bulk-update-title">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="bulk-update-title">Update Calibration Dates</h3>
                <button id="modal-close-btn" class="modal-close-btn" aria-label="Close dialog">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new-cal-date">New Calibration Date</label>
                    <input type="date" id="new-cal-date">
                </div>
                <div class="form-group">
                    <label for="new-expiry-date">New Expiry Date</label>
                    <input type="date" id="new-expiry-date">
                </div>
            </div>
            <div class="modal-footer">
                <button id="modal-cancel-btn" class="btn btn-outline">Cancel</button>
                <button id="modal-save-btn" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
    
    <!-- Renew/Update Modal -->
    <div id="renew-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="renew-title">
        <div class="modal-box" style="max-width: 550px;">
            <div class="modal-header" style="background-color: #2c5282; color: white; padding: var(--space-md); border-radius: var(--radius-md) var(--radius-md) 0 0; margin-bottom: 0;">
                <h3 id="renew-title" style="color: white; font-weight: 500;">Renew / Update License</h3>
                <button id="renew-modal-close-btn" class="modal-close-btn" aria-label="Close dialog" style="color: white;">×</button>
            </div>
            <div class="modal-body" style="padding: var(--space-xl);">
                <form id="renew-form">
                    <input type="hidden" id="renew-equipment-id">
                    <div class="form-group">
                        <label for="renew-unit-name">Unit Name</label>
                        <input type="text" id="renew-unit-name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="renew-corporate">Corporate</label>
                        <input type="text" id="renew-corporate" readonly>
                    </div>
                    <div class="form-group">
                        <label for="renew-regional">Regional</label>
                        <input type="text" id="renew-regional" readonly>
                    </div>
                   
                    
                    <div class="form-group">
                        <label for="renew-current-expiry">Current Expiry Date</label>
                        <input type="text" id="renew-current-expiry" readonly>
                    </div>
                    <div class="form-group">
                        <label for="renew-new-expiry">New Expiry Date</label>
                        <input type="date" id="renew-new-expiry" placeholder="dd-mm-yyyy">
                    </div>
                    <div class="form-group">
                        <label>Upload New Doc (Opt)</label>
                        <div class="file-upload-wrapper">
                            <!--<label for="renew-doc-upload" class="btn btn-outline" style="background-color: white; border: 1px solid #ccc;">-->
                            <!--    <i class="fas fa-cloud-upload-alt"></i> Choose File-->
                            <!--</label>-->
                            <input type="file" id="renew-doc-upload" style="display: block;">
                            <!--<span id="renew-doc-filename" style="margin-left: var(--space-sm); color: #28a745; font-style: italic;">No new file</span>-->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background-color: var(--light-gray); padding: var(--space-md); border-radius: 0 0 var(--radius-md) var(--radius-md); margin-top: 0;">
                <button id="renew-cancel-btn" class="btn btn-outline">Cancel</button>
                <button id="renew-save-btn" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;"><i class="fas fa-save"></i> Save as</button>
            </div>
        </div>
    </div>
    
    <!-- Deactivate Comment Modal -->
    <div id="deactivate-comment-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="deactivate-comment-title">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="deactivate-comment-title">Reason for Deactivation</h3>
                <button id="deactivate-comment-close-btn" class="modal-close-btn" aria-label="Close dialog">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="deactivate-equipment-id">
                <div class="form-group">
                    <label for="deactivation-comment">Please provide a reason for deactivating this equipment.</label>
                    <textarea id="deactivation-comment" rows="4" style="width: 100%; padding: var(--space-sm); border: 1px solid var(--medium-gray); border-radius: var(--radius-md); font-size: 0.95rem;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button id="deactivate-comment-cancel-btn" class="btn btn-outline">Cancel</button>
                <button id="deactivate-comment-confirm-btn" class="btn btn-primary" style="background-color: var(--status-overdue); border-color: var(--status-overdue);">Confirm Deactivation</button>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="history-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="history-title">
        <div class="modal-box" style="max-width: 90%; width: 1024px; padding: 0;">
            <div class="modal-header" style="padding: var(--space-md); border-bottom: 1px solid var(--medium-gray); display: flex; justify-content: space-between; align-items: center; margin-bottom: 0;">
                 <h3 id="history-title" style="margin: 0; font-size: 1.1rem; color: var(--dark-color);">Equipment Calibration History</h3>
                 <button id="history-modal-close-btn" class="modal-close-btn" aria-label="Close dialog" style="position: static; transform: none; color: var(--text-light);">×</button>
            </div>
            <div class="modal-body" style="padding: 0; max-height: 85vh; overflow-y: auto;">
                <style>
                    #history-content-wrapper { font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #1f2937; line-height: 1.5; font-size: 10pt; margin: 0; padding: 1.5rem; background-color: #ffffff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                    #history-content-wrapper .header-content { display: flex; justify-content: space-between; align-items: center; }
                    #history-content-wrapper .document-title { font-size: 16pt; font-weight: 700; letter-spacing: -0.5px; color: #111827;}
                    #history-content-wrapper .document-subtitle { font-size: 9pt; opacity: 0.9; margin-top: 2px; font-weight: 400; color: #4b5563;}
                    #history-content-wrapper .document-meta { text-align: right; font-size: 8pt; background: rgba(0,0,0,0.04); padding: 6pt 8pt; border-radius: 4px; }
                    #history-content-wrapper .meta-item { display: flex; justify-content: flex-end; gap: 8px; }
                    #history-content-wrapper .meta-label { font-weight: 500; }
                    #history-content-wrapper .equipment-section { display: grid; grid-template-columns: auto 1fr; gap: 20pt; margin-top: 25pt; margin-bottom: 25pt; background: #f9fafb; padding: 15pt; border-radius: 8px; border: 1px solid #e5e7eb; }
                    #history-content-wrapper .equipment-photo { width: 90pt; height: 90pt; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #0369a1; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
                    #history-content-wrapper .equipment-photo img { width: 70%; height: 70%; object-fit: contain; }
                    #history-content-wrapper .equipment-details { display: grid; grid-template-columns: 1fr 1fr; gap: 10pt 20pt; }
                    #history-content-wrapper .detail-item { display: flex; align-items: center; }
                    #history-content-wrapper .detail-label { font-weight: 500; min-width: 100pt; color: #4b5563; font-size: 9pt; }
                    #history-content-wrapper .detail-value { font-weight: 500; }
                    #history-content-wrapper .summary-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12pt; margin-bottom: 20pt; }
                    #history-content-wrapper .summary-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12pt; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
                    #history-content-wrapper .summary-card-title { font-size: 8pt; text-transform: uppercase; letter-spacing: 0.5pt; color: #6b7280; margin-bottom: 6pt; font-weight: 600; }
                    #history-content-wrapper .summary-card-value { font-size: 16pt; font-weight: 700; color: #0369a1; letter-spacing: -0.5px; }
                    #history-content-wrapper .summary-card-description { font-size: 8pt; color: #9ca3af; margin-top: 2pt; }
                    #history-content-wrapper .section-title { font-size: 12pt; font-weight: 600; color: #111827; margin: 15pt 0 10pt; padding-bottom: 5pt; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; }
                    #history-content-wrapper .section-title svg { margin-right: 8pt; width: 14pt; height: 14pt; color: #0369a1; }
                    #history-content-wrapper .calibration-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 15pt 0; page-break-inside: avoid; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e5e7eb;}
                    #history-content-wrapper .calibration-table th { background: #f9fafb; color: #374151; padding: 10pt 12pt; text-align: left; font-weight: 600; font-size: 9pt; text-transform: uppercase; letter-spacing: 0.5pt; border-bottom: 1px solid #e5e7eb;}
                    #history-content-wrapper .calibration-table th:first-child { border-top-left-radius: 8px; }
                    #history-content-wrapper .calibration-table th:last-child { border-top-right-radius: 8px; }
                    #history-content-wrapper .calibration-table td { padding: 12pt; border-bottom: 1px solid #e5e7eb; vertical-align: top; background-color: #ffffff; }
                    #history-content-wrapper .calibration-table tr:last-child td { border-bottom: none; }
                    #history-content-wrapper .technician-info { display: flex; align-items: center; gap: 8pt; }
                    #history-content-wrapper .technician-avatar { width: 24pt; height: 24pt; border-radius: 50%; background-color: #e0f2fe; display: flex; align-items: center; justify-content: center; color: #0369a1; font-size: 8pt; font-weight: 600; flex-shrink: 0; }
                    #history-content-wrapper .technician-details { line-height: 1.4; }
                    #history-content-wrapper .technician-name { font-weight: 500; }
                    #history-content-wrapper .technician-title { color: #6b7280; font-size: 8pt; }
                    #history-content-wrapper .status-badge { display: inline-block; padding: 4pt 8pt; border-radius: 20pt; font-size: 8pt; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5pt; }
                    #history-content-wrapper .status-passed { background-color: #ecfdf5; color: #10b981; }
                    #history-content-wrapper .status-failed { background-color: #fef2f2; color: #ef4444; }
                    #history-content-wrapper .status-due { background-color: #fffbeb; color: #f59e0b; }
                    #history-content-wrapper .status-container { display: flex; flex-direction: column; align-items: flex-start; gap: 6pt; }
                    #history-content-wrapper .action-link { display: inline-flex; align-items: center; gap: 4pt; font-size: 8pt; color: #6b7280; text-decoration: none; font-weight: 500; }
                    #history-content-wrapper .action-link:hover { color: #0369a1; }
                    #history-content-wrapper .action-link svg { width: 11pt; height: 11pt; flex-shrink: 0; color: #9ca3af; }
                    #history-content-wrapper .action-link:hover svg { color: #0369a1; }
                    #history-content-wrapper .signature-section { display: grid; grid-template-columns: 1fr 1fr; gap: 40pt; margin-top: 40pt; page-break-inside: avoid; }
                    #history-content-wrapper .signature-box { height: 40pt; border-bottom: 1px solid #d1d5db; margin-bottom: 8pt; position: relative; }
                    #history-content-wrapper .signature-stamp { position: absolute; right: 0; bottom: -5pt; width: 60pt; opacity: 0.8; }
                    #history-content-wrapper .signature-label { font-size: 9pt; color: #6b7280; text-align: left; margin-bottom: 3pt; }
                    #history-content-wrapper .signature-name { font-weight: 600; text-align: left; margin-top: 3pt; }
                    #history-content-wrapper .signature-details { font-size: 8pt; color: #9ca3af; margin-top: 2pt; }
                    #history-content-wrapper .footer-note { font-size: 8pt; color: #9ca3af; text-align: center; margin-top: 25pt; padding-top: 10pt; border-top: 1px solid #e5e7eb; line-height: 1.6; position: relative; }
                    #history-content-wrapper .watermark { position: fixed; opacity: 0.03; font-size: 72pt; color: #0369a1; transform: rotate(-30deg); top: 40%; left: 15%; z-index: -1; font-weight: 700; letter-spacing: 2pt; }
                    #history-content-wrapper .qr-code { position: absolute; right: 0; bottom: 0; width: 60pt; height: 60pt; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #9ca3af; font-size: 6pt; text-align: center; padding: 5pt; box-sizing: border-box; }
                    #history-content-wrapper .qr-code img { width: 40pt; height: 40pt; margin-bottom: 3pt; }
                    #history-content-wrapper .progress-container { margin-top: 20pt; background-color: #f3f4f6; border-radius: 20pt; height: 6pt; overflow: hidden; }
                    #history-content-wrapper .progress-bar { height: 100%; background: linear-gradient(90deg, #0ea5e9 0%, #0369a1 100%); width: 75%; border-radius: 20pt; transition: width 0.5s ease; }
                    #history-content-wrapper .progress-labels { display: flex; justify-content: space-between; margin-top: 4pt; font-size: 8pt; color: #6b7280; }
                </style>
                <div id="history-content-wrapper">
                    <!-- Watermark -->
                    <div class="watermark">CALIBRATION RECORD</div>
                    
                    <div class="header-content">
                        <div>
                            <div class="document-title">EQUIPMENT CALIBRATION HISTORY</div>
                            <div class="document-subtitle">Record of calibration events and compliance status</div>
                        </div>
                        <div class="document-meta">
                            <div class="meta-item"><span class="meta-label">RECORD ID:</span><span data-history-field="recordId"></span></div>
                            <div class="meta-item"><span class="meta-label">GENERATED:</span><span data-history-field="generatedDate"></span></div>
                        </div>
                    </div>
                    
                    <!-- Equipment Information -->
                    <div class="equipment-section">
                        <div class="equipment-photo"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iY3VycmVudENvbG9yIj48cGF0aCBkPSJNMTIgMkM2LjQ4NiAyIDIgNi40ODYgMiAxMnM0LjQ4NiAxMCAxMCAxMCAxMC00LjQ4NiAxMC0xMFMxNy41MTQgMiAxMiAyeiBtMCAxOGMtNC40MTEgMC04LTMuNTg5LTgtOHMzLjU4OS04IDgtOCA4IDMuNTg5IDggOC0zU4OSA4LTggOHoiLz48cGF0aCBkPSJNMTIgNmMtMy4zMDkgMC02IDIuNjkxLTYgNnM2IDcgNiA3IDYtMy42OTEgNi02LTIuNjkxLTYtNi02em0uMDQ3IDkuMzI4TDEyIDE1LjI4bC0uMDQ3LjA0N0M5LjY0OCAxMy4zNTQgOSAxMi4wMDkgOSAxMnMyLjY5MS0zIDMtM2MuOTkzIDAgMS4zNTMuNjQ4IDMuMzU0IDMuMDQ3QzE1LjA5MSAxMy42OTIgMTUgMTIgMTUgMTJzLTEuNjkxIDEuMzA5LTIuOTUzIDEuMzI4eiIvPjwvc3ZnPg==" alt="Equipment Icon"></div>
                        <div class="equipment-details">
                            <div class="detail-item"><div class="detail-label">Equipment Name:</div><div class="detail-value" data-history-field="equipmentName"></div></div>
                            <div class="detail-item"><div class="detail-label">Asset / Serial No:</div><div class="detail-value" data-history-field="assetNo"></div></div>
                            <div class="detail-item"><div class="detail-label">Location:</div><div class="detail-value" data-history-field="location"></div></div>
                            <div class="detail-item"><div class="detail-label">Manufacturer:</div><div class="detail-value" data-history-field="manufacturer"></div></div>
                            <div class="detail-item"><div class="detail-label">Purchase Date:</div><div class="detail-value" data-history-field="purchaseDate"></div></div>
                            <div class="detail-item"><div class="detail-label">Last Calibrated:</div><div class="detail-value" style="font-weight:700; color: #166534;" data-history-field="lastCalibrated"></div></div>
                            <div class="detail-item"><div class="detail-label">Cal. Interval:</div><div class="detail-value">12 Months</div></div>
                            <div class="detail-item"><div class="detail-label">Next Due:</div><div class="detail-value" style="font-weight:700; color: #be123c;" data-history-field="nextDue"></div></div>
                        </div>
                    </div>
                    
                    <!-- Calibration Summary -->
                    <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-1.5m-6 0h1.5m-1.5 0h-1.5m0 0v1.125c0 .621-.504 1.125-1.125 1.125H6.375c-.621 0-1.125-.504-1.125-1.125V16.5m6 0h3m-3 1.5v-1.5m-6 0h-3v-1.5m3 0v1.5" /></svg>Calibration Overview</div>
                    <div class="summary-cards">
                        <div class="summary-card"><div class="summary-card-title">Total Calibrations</div><div class="summary-card-value" data-history-field="totalCalibrations"></div><div class="summary-card-description">Since purchase</div></div>
                        <div class="summary-card"><div class="summary-card-title">Current Status</div><div class="summary-card-value"><span class="status-badge status-passed">In Tolerance</span></div><div class="summary-card-description">As of last calibration</div></div>
                        <div class="summary-card"><div class="summary-card-title">Passed Events</div><div class="summary-card-value" data-history-field="passedEvents"></div><div class="summary-card-description" data-history-field="passRate"></div></div>
                        <div class="summary-card"><div class="summary-card-title">Last Calibrated</div><div class="summary-card-value" data-history-field="lastCalibratedSummaryDate"></div><div class="summary-card-description" data-history-field="lastCalibratedSummaryTech"></div></div>
                    </div>
                    
                    <div class="progress-container"><div class="progress-bar" style="width: 0%;"></div></div>
                    <div class="progress-labels"><span data-history-field="progressStart"></span><span data-history-field="progressEnd"></span></div>
                    
                    <!-- Calibration History -->
                    <div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>Calibration History</div>
                    <table class="calibration-table">
                        <thead><tr><th style="width: 15%">Event ID</th><th style="width: 15%">Date</th><th style="width: 25%">Technician</th><th style="width: 25%">As Found / As Left</th><th style="width: 20%">Status / Certificate</th></tr></thead>
                        <tbody><!-- Dynamically populated by JS --></tbody>
                    </table>
                    
                    <!-- Signature Section -->
                    <div class="signature-section"><div><div class="signature-label">Reviewed By</div><div class="signature-box"></div><div class="signature-name">Rajesh Singh</div><div class="signature-details">Lab Supervisor | Date: 05-Jul-2023</div></div><div><div class="signature-label">Quality Manager Approval</div><div class="signature-box"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgNTAiIHN0eWxlPSJmb250LWZhbWlseTpBcmlhbDsiPjxwYXRoIGZpbGw9IiNlMGYyZmUiIGQ9Ik0wIDBoMTAwdjUwSDB6Ii8+PHRleHQgeD0iNTAiIHk9IjMwIiBmb250LXNpemU9IjgiIGZpbGw9IiMwMzY5YTEiIGZvbnQtd2VpZ2h0PSJib2xkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5BUFBST1ZFRDwvdGV4dD48L3N2Zz4=" class="signature-stamp" alt="Approved Stamp"></div><div class="signature-name">Priya Sharma</div><div class="signature-details">Quality Assurance Manager</div></div></div>
                    
                    <!-- Footer with QR Code -->
                    <div class="footer-note"><div class="qr-code"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0yMCAyMGgxMHYxMEgyMHpNNDAgMjBoMTB2MTBINDB6TTIwIDQwaDEwdjEwSDIwek00MCA0MGgxMHYxMEg0MHpNNjAgMjBoMTB2MTBINjB6TTYwIDQwaDEwdjEwSDYwek04MCAyMGgxMHYxMEg4MHpNODAgNDBoMTB2MTBIODB6TTIwIDYwaDEwdjEwSDIwek00MCA2MGgxMHYxMEg0MHpNNjAgNjBoMTB2MTBINjB6TTgwIDYwaDEwdjEwSDgwem0tNjAgMjBoMTB2MTBINjB6IiBmaWxsPSIjMDAwIi8+PC9zdmc+" alt="QR Code">Scan to verify</div>This is a system-generated document. For verification, please contact the Quality Department.<br>© 2023 Omega Instruments. All rights reserved.</div>
                </div>
            </div>
        </div>
    </div>


    <!-- Column Filter Dropdown -->
    <div id="filter-dropdown" class="filter-dropdown">
        <div class="filter-dropdown-header">
            <input type="text" id="filter-search" placeholder="Search values..." aria-label="Search filter values">
        </div>
        <div id="filter-dropdown-body" class="filter-dropdown-body"></div>
        <div class="filter-dropdown-footer">
            <button id="filter-apply-btn" class="btn btn-sm btn-primary">Apply</button>
            <button id="filter-clear-btn" class="btn btn-sm btn-outline">Clear</button>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- START: Refactored Data Structure ---
        const initialEquipmentData = [
            
            <?php foreach ($facility_equipment as $facility_equipments): ?>

    @php
        $calibration_list_item = DB::table('calibration_list_item')
            ->where('equipment_id', $facility_equipments->equipment_id)->orderBy('id', 'desc')->get();
    @endphp
    
    @php 
                $unitDetails = DB::table('users')->where('id',$facility_equipments->created_by ?? '')->first();
        $unitDetails2 = DB::table('users')->where('id',$unitDetails->created_by1 ?? '')->first();
        $unitDetails3 = DB::table('users')->where('id',$unitDetails->created_by ?? '')->first();
        @endphp

    {
        equipment_name: '{{ $facility_equipments->name ?? '' }}',
        brand: '{{ $facility_equipments->brand ?? '' }}',
        model_number: '{{ $facility_equipments->modal_number ?? '' }}',
        equipment_id: '{{$facility_equipments->equipment_id ?? ''}}',
        equipment_type: 'Electrical',
        corporate: '{{$unitDetails3->company_name ?? ''}}',
        regional: '{{$unitDetails2->company_name ?? ''}}',
        unit: '{{$unitDetails->company_name ?? ''}}',
        department: '{{ $facility_equipments->department ?? 'NA' }}',
        location: '{{ $facility_equipments->location_id ?? 'NA' }}',
        isActive: {{ $facility_equipments->calibaration_active ?? 0}},
        renewal_cycle_info: '2024 Cycle 1',
        company_logo: '{{ $facility_equipments->company_logo ?? '' }}',
        
        calibrations: [
            @foreach ($calibration_list_item as $cal)
                {
                    cal_id: '{{ $cal->cal_id }}',
                    calibration_id: '{{ $cal->calibration_id }}',
                    certificate_number: '{{ $cal->certificate_number }}',
                    calibration_type: '{{ $cal->calibration_type }}',
                    capacity_range: '{{ $cal->capacity_range }}',
                    calibration_range: '{{ $cal->calibration_range }}',
                    least_count: '{{ $cal->least_count }}',
                    calibration_date: '{{ $cal->calibration_date }}',
                    expiry_date: '{{ $cal->expiry_date }}',
                    certificate_url: '{{ $cal->certificate_url ?? "#" }}',
                    certificate_filename: '{{ $cal->certificate_filename ?? "" }}'
                }@if (!$loop->last),@endif
            @endforeach
        ]
    },

<?php endforeach; ?>

            
        ];
        // --- END: Refactored Data Structure ---
        
        let equipmentData = [];
        let currentFilteredData = [];
        let nextCalId = 100; // For new temp IDs

        // --- Global State ---
        let currentSortColumn = 'status';
        let currentSortOrder = 'desc';
        let currentPage = 1;
        let itemsPerPage = 10;
        let selectedItems = new Set();
        let currentUploadId = null;
        let activeFilters = {};
        let currentFilterColumn = null;
        let editingRowId = null;

        // --- Utility Functions ---
        function getStatus(item, isActive = true) {
            if (!isActive) return { key: 'info', text: 'Deactivated', class: 'status-info', icon: 'fa-ban', daysRemaining: Infinity };
            const expiryDateStr = item.calibrations && item.calibrations.length > 0 ? item.calibrations[0].expiry_date : null;
            if (!expiryDateStr) return { key: 'info', text: 'N/A', class: 'status-info', icon: 'fa-question-circle', daysRemaining: Infinity };
            
            const today = new Date();
            const expiryDate = new Date(expiryDateStr);
            today.setHours(0, 0, 0, 0);
            expiryDate.setHours(0, 0, 0, 0);
            const timeDiff = expiryDate.getTime() - today.getTime();
            const daysRemaining = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if (expiryDate < today) return { key: 'overdue', text: 'Overdue', class: 'status-overdue', icon: 'fa-exclamation-triangle', daysRemaining: daysRemaining };
            if (daysRemaining <= 30) return { key: 'due-soon', text: 'Due Soon', class: 'status-due-soon', icon: 'fa-clock', daysRemaining };
            if (daysRemaining <= 60) return { key: 'warning', text: 'Warning', class: 'status-warning', icon: 'fa-exclamation-circle', daysRemaining };
            return { key: 'compliant', text: 'Compliant', class: 'status-compliant', icon: 'fa-check-circle', daysRemaining };
        }
        function formatDate(dateStr, forInput = false) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return '';
            if (forInput) return date.toISOString().split('T')[0];
            return new Date(date.getTime() + date.getTimezoneOffset() * 60000).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
        }
       
        // --- Main App Initialization ---
        function initializeApp() {
            if (equipmentData.length === 0) {
                equipmentData = JSON.parse(JSON.stringify(initialEquipmentData));
            }
            document.getElementById('searchInput').value = '';
            
            currentPage = 1;
            selectedItems.clear();
            activeFilters = {};

            updateDashboard();
            showReminders();
            sortAndFilterEquipment();
            updateBulkActionUI();
            updateAllFilterIcons();
        }
        
        // --- Reminder Bar Logic ---
        function showReminders() {
            const reminderBar = document.getElementById('reminder-bar');
            const reminderText = document.getElementById('reminder-text');
            const reminderThreshold = 15; 
            const expiringSoon = equipmentData.filter(item => {
                const status = getStatus(item, item.isActive);
                return status.daysRemaining > 0 && status.daysRemaining <= reminderThreshold;
            });

            if (expiringSoon.length > 0) {
                reminderText.innerHTML = `<i class="fas fa-bell"></i> <strong>${expiringSoon.length}</strong> equipment certificate(s) will expire in the next ${reminderThreshold} days.`;
                reminderBar.style.display = 'block';
            } else {
                reminderBar.style.display = 'none';
            }
        }
        document.getElementById('reminder-close').addEventListener('click', () => {
            document.getElementById('reminder-bar').style.display = 'none';
        });

        // --- Dashboard Logic ---
        function updateDashboard() {
            const stats = { total: 0, dueSoon: 0, overdue: 0, compliant: 0, warning: 0 };
            equipmentData.forEach(item => {
                item.statusInfo = getStatus(item, item.isActive);
                if (item.calibrations && item.calibrations.length > 0) {
                    item.primaryCal = item.calibrations[0];
                } else {
                    item.primaryCal = {};
                }

                stats.total++;
                if (item.statusInfo.key === 'due-soon') stats.dueSoon++;
                else if (item.statusInfo.key === 'overdue') stats.overdue++;
                else if (item.statusInfo.key === 'compliant') stats.compliant++;
                else if (item.statusInfo.key === 'warning') stats.warning++;
            });
            document.getElementById('total-equip-stat').textContent = stats.total;
            document.getElementById('due-soon-stat').textContent = stats.dueSoon;
            document.getElementById('overdue-stat').textContent = stats.overdue;
            document.getElementById('compliant-stat').textContent = stats.compliant;
        }
        
        // --- Equipment List Logic ---
        function populateEquipmentTable(data, page = 1) {
            const equipmentTbody = document.getElementById('equipment-tbody');
            equipmentTbody.innerHTML = '';
            const totalItems = data.length;
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
            const paginatedData = data.slice(startIndex, endIndex);
            
            if (paginatedData.length === 0) {
                equipmentTbody.innerHTML = `<tr><td colspan="8" style="text-align: center; padding: 40px;">No equipment found matching criteria.</td></tr>`;
                document.getElementById('pagination-summary').textContent = 'Showing 0-0 of 0';
                return;
            }
            
            paginatedData.forEach(item => {
                const row = document.createElement('tr');
                row.dataset.id = item.equipment_id;
                row.classList.add(`status-border-${item.statusInfo.key}`);
                row.classList.toggle('deactivated-row', !item.isActive);

                let daysText = '';
                if(item.isActive && item.statusInfo.daysRemaining !== Infinity && item.statusInfo.text !== 'Compliant') {
                     if (item.statusInfo.text === 'Overdue') daysText = `<strong>${item.statusInfo.daysRemaining * -1}</strong> days overdue`;
                     else daysText = `Expires in <strong>${item.statusInfo.daysRemaining}</strong> days`;
                }
                const uploadAction = !item.company_logo
    ? `<button class="btn btn-icon btn-outline tooltip upload-btn" aria-label="Upload certificate" data-id="${item.equipment_id}">
         <i class="fas fa-upload"></i><span class="tooltip-text">Upload Cert</span>
       </button>
       <input type="file" id="upload-input-${item.equipment_id}" class="upload-input" style="display:none" accept="application/pdf" />`
    : `<a href="https://efsm.safefoodmitra.com/admin/public/cmimage/${item.company_logo}" target="_blank" class="btn btn-icon btn-outline tooltip" aria-label="View certificate">
         <i class="fas fa-file-pdf"></i><span class="tooltip-text">View Cert</span>
       </a>`;


                const isEditing = editingRowId === item.equipment_id;

                let actionButtonsHTML;
                if (isEditing) {
                    actionButtonsHTML = `
                        <button class="btn btn-icon btn-outline tooltip save-row-btn" aria-label="Save changes"><i class="fas fa-save"></i><span class="tooltip-text">Save</span></button>
                        <button class="btn btn-icon btn-outline tooltip cancel-row-btn" aria-label="Cancel editing"><i class="fas fa-times"></i><span class="tooltip-text">Cancel</span></button>
                    `;
                } else if (item.isActive) {
                    actionButtonsHTML = `
                        <button class="btn btn-icon btn-outline tooltip edit-row-btn" aria-label="Edit"><i class="fas fa-edit"></i><span class="tooltip-text">Edit</span></button>
                        <button class="btn btn-icon btn-outline tooltip renew-btn" aria-label="Renew"><i class="fas fa-sync-alt"></i><span class="tooltip-text">Renew</span></button>
                        <button class="btn btn-icon btn-outline tooltip history-btn" aria-label="History"><i class="fas fa-history"></i><span class="tooltip-text">History</span></button>
                        ${uploadAction}
                        <button class="btn btn-icon btn-outline tooltip deactivate-btn" aria-label="Deactivate"><i class="fas fa-toggle-off"></i><span class="tooltip-text">Deactivate</span></button>
                    `;
                } else {
                    actionButtonsHTML = `<button class="btn btn-icon btn-outline tooltip activate-btn" aria-label="Activate"><i class="fas fa-toggle-on"></i><span class="tooltip-text">Activate</span></button>`;
                }

                let calDetailsHTML = '', rangeHTML = '', periodHTML = '';
                
                if (isEditing) {
                    item.calibrations.forEach((cal, index) => {
                        calDetailsHTML += `
                            <div class="detail-edit-group" data-cal-index="${index}">
                                <input class="inline-edit-input" data-edit-field="calibration_id" value="${cal.calibration_id || ''}" placeholder="Cal ID"><br>
                                <div class="details-sub">
                                    Cert: <input class="inline-edit-input" data-edit-field="certificate_number" value="${cal.certificate_number || ''}" style="width: 70%;" placeholder="Cert #"><br>
                                    Type: <select class="inline-edit-input" data-edit-field="calibration_type" style="width: 70%;">
                                        <option value="External" ${cal.calibration_type === 'External' ? 'selected' : ''}>External</option>
                                        <option value="Internal" ${cal.calibration_type === 'Internal' ? 'selected' : ''}>Internal</option>
                                    </select>
                                </div>
                            </div>`;
                        rangeHTML += `
                            <div class="detail-edit-group" data-cal-index="${index}">
                                <div class="details-sub">
                                    <strong>Capacity:</strong> <input class="inline-edit-input" data-edit-field="capacity_range" value="${cal.capacity_range || ''}" placeholder="e.g. 0-100V"><br>
                                    <strong>Calibrated:</strong> <input class="inline-edit-input" data-edit-field="calibration_range" value="${cal.calibration_range || ''}" placeholder="e.g. 10-90V"><br>
                                    <strong>LC:</strong> <input class="inline-edit-input" data-edit-field="least_count" value="${cal.least_count || ''}" placeholder="e.g. 0.1V">
                                </div>
                            </div>`;
                        periodHTML += `
                            <div class="detail-edit-group" data-cal-index="${index}">
                                <div class="details-sub">
                                    <strong>Calibrated:</strong> <input type="date" class="inline-edit-input" data-edit-field="calibration_date" value="${formatDate(cal.calibration_date, true)}"><br>
                                    <strong>Expires:</strong> <input type="date" class="inline-edit-input" data-edit-field="expiry_date" value="${formatDate(cal.expiry_date, true)}">
                                </div>
                                ${item.calibrations.length > 1 ? `<button class="btn btn-icon btn-sm tooltip remove-detail-btn" data-cal-index="${index}" aria-label="Remove this detail"><i class="fas fa-trash-alt"></i><span class="tooltip-text">Remove</span></button>` : ''}
                            </div>`;
                    });
                    rangeHTML += `<button class="btn btn-sm btn-outline add-detail-btn"><i class="fas fa-plus-circle"></i> Add Detail</button>`;
                } else {
                    calDetailsHTML = item.calibrations.map((cal, index) => `
                        ${index > 0 ? '<hr style="margin: 8px 0; border-color: var(--light-gray);">' : ''}
                        <div>
                            <div class="details-main">${cal.calibration_id || 'N/A'}</div>
                            <div class="details-sub">Cert: ${cal.certificate_number || 'N/A'}<br>Type: ${cal.calibration_type || 'N/A'}</div>
                        </div>`).join('') || `<div class="details-sub">No details specified.</div>`;
                    
                    rangeHTML = item.calibrations.map((cal, index) => `
                        ${index > 0 ? '<hr style="margin: 8px 0; border-color: var(--light-gray);">' : ''}
                        <div class="details-sub">
                            <strong>Capacity:</strong> ${cal.capacity_range || 'N/A'}<br>
                            <strong>Calibrated:</strong> ${cal.calibration_range || 'N/A'}<br>
                            <strong>LC:</strong> ${cal.least_count || 'N/A'}
                        </div>`).join('') || `<div class="details-sub">No details specified.</div>`;

                    periodHTML = item.calibrations.map((cal, index) => `
                        ${index > 0 ? '<hr style="margin: 8px 0; border-color: var(--light-gray);">' : ''}
                        <div class="details-sub">
                            <strong>Calibrated:</strong> ${formatDate(cal.calibration_date)}<br>
                            <strong>Expires:</strong> ${formatDate(cal.expiry_date)}
                        </div>`).join('') || `<div class="details-sub">No dates specified.</div>`;
                }

                row.innerHTML = `
                    <td data-label="Select"><input type="checkbox" class="row-checkbox" data-id="${item.equipment_id}" ${selectedItems.has(item.equipment_id) ? 'checked' : ''}></td>
                    <td data-label="Hierarchy / Location" class="details-cell">
                        <div class="details-main">${item.department} / ${item.location}</div>
                        <div class="details-sub">${item.corporate} > ${item.regional} > ${item.unit}</div>
                    </td>
                    <td data-label="Equipment" class="details-cell">
                        <div class="details-main">${item.equipment_name}</div>
                        <div class="details-sub">${item.equipment_id} • ${item.brand} • ${item.model_number}</div>
                    </td>
                    <td data-label="Calibration Details">${calDetailsHTML}</td>
                    <td data-label="Range & Precision">${rangeHTML}</td>
                    <td data-label="Calibration Period">${periodHTML}</td>
                    <td data-label="Status" class="details-cell">
                        <div class="details-main" style="margin-bottom: 4px;"><span class="status-badge ${item.statusInfo.class}"><i class="fas ${item.statusInfo.icon}"></i> ${item.statusInfo.text}</span></div>
                        <div class="details-sub">${daysText}</div>
                    </td>
                    <td data-label="Actions" class="action-buttons">${actionButtonsHTML}</td>`;
                equipmentTbody.appendChild(row);
            });
            updatePaginationControls(totalItems);
            document.getElementById('pagination-summary').textContent = `Showing ${startIndex + 1}-${endIndex} of ${totalItems}`;
        }
        
        function updatePaginationControls(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const paginationPages = document.getElementById('pagination-pages');
            paginationPages.innerHTML = '';
            
            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = 'pagination-btn';
                if (i === currentPage) pageBtn.classList.add('active');
                pageBtn.textContent = i;
                pageBtn.setAttribute('aria-label', `Go to page ${i}`);
                if (i === currentPage) pageBtn.setAttribute('aria-current', 'page');
                pageBtn.addEventListener('click', () => { currentPage = i; sortAndFilterEquipment(); });
                paginationPages.appendChild(pageBtn);
            }
            
            document.getElementById('prev-page-btn').disabled = currentPage === 1;
            document.getElementById('next-page-btn').disabled = currentPage === totalPages || totalPages === 0;
        }

        function sortAndFilterEquipment() {
            let filteredData = [...equipmentData];
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            if (searchTerm) {
                filteredData = filteredData.filter(item => JSON.stringify(item).toLowerCase().includes(searchTerm));
            }

            Object.keys(activeFilters).forEach(column => {
                if (activeFilters[column] && activeFilters[column].length > 0) {
                    const filterValues = activeFilters[column];
                    filteredData = filteredData.filter(item => {
                         if (column === 'status') {
                            return filterValues.includes(item.statusInfo.text);
                        }
                        if (item.calibrations && item.calibrations.length > 0) {
                            return item.calibrations.some(cal => filterValues.includes(cal[column]));
                        }
                        return false;
                    });
                }
            });

            filteredData.sort((a, b) => {
                let valA, valB;
                if (currentSortColumn === 'status') { valA = a.statusInfo.daysRemaining; valB = b.statusInfo.daysRemaining; }
                else {
                    valA = a.primaryCal ? a.primaryCal[currentSortColumn] : null;
                    valB = b.primaryCal ? b.primaryCal[currentSortColumn] : null;
                }
                
                if (currentSortColumn.includes('date')) { valA = new Date(valA); valB = new Date(valB); }
                if (typeof valA === 'string') valA = valA.toLowerCase();
                if (typeof valB === 'string') valB = valB.toLowerCase();

                if (valA < valB) return currentSortOrder === 'asc' ? -1 : 1;
                if (valA > valB) return currentSortOrder === 'asc' ? 1 : -1;
                return 0;
            });
            currentFilteredData = filteredData;
            populateEquipmentTable(filteredData, currentPage);
            updateSelectAllCheckboxState();
        }

        // --- Event Listeners & Handlers ---
        const equipmentTbody = document.getElementById('equipment-tbody');

        equipmentTbody.addEventListener('click', e => {
            const row = e.target.closest('tr');
            if (!row) return;
            const id = row.dataset.id;
            
            if (e.target.closest('.add-detail-btn')) {
                e.preventDefault();
                const item = equipmentData.find(d => d.equipment_id === id);
                if (item) {
                    item.calibrations.push({ cal_id: nextCalId++, calibration_id: '', certificate_number: '', calibration_type: 'External', capacity_range: '', calibration_range: '', least_count: '', calibration_date: '', expiry_date: '' });
                    sortAndFilterEquipment();
                }
            }
            if (e.target.closest('.remove-detail-btn')) {
    e.preventDefault();

    const calIndex = parseInt(e.target.closest('.remove-detail-btn').dataset.calIndex, 10);
    const item = equipmentData.find(d => d.equipment_id === id);

    if (!item) return;

    // Get cal_id from the calibration to remove
    const calIdToRemove = item.calibrations[calIndex]?.cal_id;

    if (item.calibrations.length > 1 && calIdToRemove) {
        // AJAX call to remove calibration from DB
        fetch("{{ route('remove_calibration_list') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                cal_id: calIdToRemove
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log("Calibration removed:", data);
            // Remove from local array
            item.calibrations.splice(calIndex, 1);
            sortAndFilterEquipment();
        })
        .catch(err => {
            console.error("Error removing calibration:", err);
            alert("Error removing calibration.");
        });
    }
}


            if (e.target.closest('.edit-row-btn')) { editingRowId = id; sortAndFilterEquipment(); }
            if (e.target.closest('.cancel-row-btn')) { editingRowId = null; initializeApp(); }
            if (e.target.closest('.save-row-btn')) { saveRowChanges(row, id); }
           // if (e.target.closest('.upload-btn')) { document.getElementById('certificate-uploader').click(); currentUploadId = id; }
            if (e.target.closest('.renew-btn')) { openRenewModal(id); }
            if (e.target.closest('.deactivate-btn')) { openDeactivateModal(id); }
            if (e.target.closest('.activate-btn')) { activateItem(id); }
            if (e.target.closest('.history-btn')) {
                const item = equipmentData.find(d => d.equipment_id === id);
                if(item) {
                    populateHistoryModal(item, generateFakeHistory(item));
                    document.getElementById('history-modal').classList.add('visible');
                }
            }
        });
        
        // function saveRowChanges(rowElement, id) {
        //     const item = equipmentData.find(d => d.equipment_id === id);
        //     if (!item) return;

        //     const newCalibrations = [];
        //     const numGroups = item.calibrations.length;

        //     for (let i = 0; i < numGroups; i++) {
        //         const calGroup = rowElement.querySelector(`[data-label="Calibration Details"] [data-cal-index="${i}"]`);
        //         const rangeGroup = rowElement.querySelector(`[data-label="Range & Precision"] [data-cal-index="${i}"]`);
        //         const periodGroup = rowElement.querySelector(`[data-label="Calibration Period"] [data-cal-index="${i}"]`);
                
        //         if (calGroup && rangeGroup && periodGroup) {
        //             const newCal = {
        //                 cal_id: item.calibrations[i].cal_id,
        //                 calibration_id: calGroup.querySelector('[data-edit-field="calibration_id"]').value,
        //                 certificate_number: calGroup.querySelector('[data-edit-field="certificate_number"]').value,
        //                 calibration_type: calGroup.querySelector('[data-edit-field="calibration_type"]').value,
        //                 capacity_range: rangeGroup.querySelector('[data-edit-field="capacity_range"]').value,
        //                 calibration_range: rangeGroup.querySelector('[data-edit-field="calibration_range"]').value,
        //                 least_count: rangeGroup.querySelector('[data-edit-field="least_count"]').value,
        //                 calibration_date: periodGroup.querySelector('[data-edit-field="calibration_date"]').value,
        //                 expiry_date: periodGroup.querySelector('[data-edit-field="expiry_date"]').value,
        //             };
        //             newCalibrations.push(newCal);
        //         }
        //     }

        //     item.calibrations = newCalibrations;
        //     editingRowId = null;
        //     updateDashboard();
        //     sortAndFilterEquipment();
        // }


function saveRowChanges(rowElement, id) {
    const item = equipmentData.find(d => d.equipment_id === id);
    if (!item) return;

    const newCalibrations = [];
    const numGroups = item.calibrations.length;

    for (let i = 0; i < numGroups; i++) {
        const calGroup = rowElement.querySelector(`[data-label="Calibration Details"] [data-cal-index="${i}"]`);
        const rangeGroup = rowElement.querySelector(`[data-label="Range & Precision"] [data-cal-index="${i}"]`);
        const periodGroup = rowElement.querySelector(`[data-label="Calibration Period"] [data-cal-index="${i}"]`);
        
        if (calGroup && rangeGroup && periodGroup) {
            const newCal = {
                cal_id: item.calibrations[i].cal_id,
                calibration_id: calGroup.querySelector('[data-edit-field="calibration_id"]').value,
                certificate_number: calGroup.querySelector('[data-edit-field="certificate_number"]').value,
                calibration_type: calGroup.querySelector('[data-edit-field="calibration_type"]').value,
                capacity_range: rangeGroup.querySelector('[data-edit-field="capacity_range"]').value,
                calibration_range: rangeGroup.querySelector('[data-edit-field="calibration_range"]').value,
                least_count: rangeGroup.querySelector('[data-edit-field="least_count"]').value,
                calibration_date: periodGroup.querySelector('[data-edit-field="calibration_date"]').value,
                expiry_date: periodGroup.querySelector('[data-edit-field="expiry_date"]').value,
            };
            newCalibrations.push(newCal);
        }
    }

    // Send AJAX request to save to server
    fetch("{{ route('add_calibration_list') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            equipment_id: id,
            calibrations: newCalibrations
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Calibration list saved:", data);

        // Update local data only after success
        item.calibrations = newCalibrations;
        editingRowId = null;
        updateDashboard();
        sortAndFilterEquipment();
    })
    .catch(err => {
        console.error("Error saving calibration list:", err);
        alert("Error saving changes. Please try again.");
    });
}

        // --- History, Activation/Deactivation and Renew Logic ---
        function generateFakeHistory(item) {
            return item.calibrations.map((cal, index) => ({
                eventId: cal.calibration_id,
                date: new Date(cal.calibration_date),
                technician: { name: 'Anil Kumar', title: 'Sr. Calibration Tech.', initials: 'AK' },
                asFound: 'In Tolerance', asLeft: 'In Tolerance', status: 'Passed', notes: `Routine calibration for range: ${cal.capacity_range}`
            })).sort((a,b) => b.date - a.date);
        }

        function populateHistoryModal(item, history) {
            const modal = document.getElementById('history-modal');
            const today = new Date();
            const latestEvent = history[0];

            const updateField = (field, value) => {
                const el = modal.querySelector(`[data-history-field="${field}"]`);
                if (el) el.textContent = value;
            };
            
            updateField('recordId', `CAL-HIST-${item.equipment_id}`);
            updateField('generatedDate', today.toLocaleDateString(undefined, { day: '2-digit', month: 'short', year: 'numeric' }));
            updateField('equipmentName', item.equipment_name);
            updateField('assetNo', item.equipment_id);
            updateField('location', item.location);
            updateField('manufacturer', item.brand);
            updateField('purchaseDate', formatDate(item.calibrations[item.calibrations.length - 1].calibration_date)); // Guess
            updateField('lastCalibrated', formatDate(item.primaryCal.calibration_date));
            updateField('nextDue', formatDate(item.primaryCal.expiry_date));
            updateField('totalCalibrations', history.length);
            updateField('passedEvents', history.length);
            updateField('passRate', `100% Pass Rate`);
            updateField('lastCalibratedSummaryDate', formatDate(latestEvent.date));
            updateField('lastCalibratedSummaryTech', `By ${latestEvent.technician.name}`);

            const lastCalDate = latestEvent.date;
            const nextDueDate = new Date(item.primaryCal.expiry_date);
            if (!isNaN(nextDueDate.getTime()) && nextDueDate > lastCalDate) {
                const totalDuration = nextDueDate.getTime() - lastCalDate.getTime();
                const elapsedDuration = today.getTime() - lastCalDate.getTime();
                let percentage = (elapsedDuration / totalDuration) * 100;
                percentage = Math.max(0, Math.min(100, percentage));
                modal.querySelector('.progress-bar').style.width = `${percentage}%`;
                modal.querySelector('[data-history-field="progressStart"]').textContent = `Last Cal: ${formatDate(lastCalDate)}`;
                modal.querySelector('[data-history-field="progressEnd"]').textContent = `Next Due: ${formatDate(nextDueDate)}`;
            }

            const tableBody = modal.querySelector('.calibration-table tbody');
            tableBody.innerHTML = '';
            history.forEach(event => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${event.eventId}</td><td>${formatDate(event.date)}</td><td><div class="technician-info"><div class="technician-avatar">${event.technician.initials}</div><div class="technician-details"><div class="technician-name">${event.technician.name}</div><div class="technician-title">${event.technician.title}</div></div></div></td><td><div style="font-weight: 500;">${event.asFound} / ${event.asLeft}</div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">${event.notes}</div></td><td><div class="status-container"><div><span class="status-badge status-passed">${event.status}</span></div><a href="#" class="action-link" onclick="event.preventDefault()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.504 3.125A2.25 2.25 0 0013.25 1h-8.5A2.25 2.25 0 002.5 3.25v13.5A2.25 2.25 0 004.75 19h10.5A2.25 2.25 0 0017.5 16.75V7.125A2.25 2.25 0 0015.504 3.125zM10 12.5a.75.75 0 01-.75.75H8.5a.75.75 0 010-1.5h.75a.75.75 0 01.75.75z" clip-rule="evenodd" /></svg>View Certificate</a></div></td>`;
                tableBody.appendChild(row);
            });
        }


        function openRenewModal(id) {
            const item = equipmentData.find(d => d.equipment_id === id);
            if (!item || !item.primaryCal) return;
            const modal = document.getElementById('renew-modal');
            document.getElementById('renew-equipment-id').value = id;
            document.getElementById('renew-unit-name').value = item.unit;
            document.getElementById('renew-corporate').value = item.corporate;
            document.getElementById('renew-regional').value = item.regional;
            document.getElementById('renew-current-expiry').value = formatDate(item.primaryCal.expiry_date);
            document.getElementById('renew-new-expiry').value = '';
            document.getElementById('renew-doc-upload').value = '';
           // document.getElementById('renew-doc-filename').textContent = 'No new file';
            modal.classList.add('visible');
        }

       function saveRenewal() {
    const id = document.getElementById('renew-equipment-id').value;
    const item = equipmentData.find(d => d.equipment_id === id);
    if (!item) return;

    const newExpiry = document.getElementById('renew-new-expiry').value;
    const file = document.getElementById('renew-doc-upload').files[0];
    //const renewCategory = document.getElementById('renew-category').value;
    //const renewOtherCategory = document.getElementById('renew-other-category').value;

    if (!newExpiry) { 
        alert('New Expiry Date is required.'); 
        return; 
    }

    if (!file) { 
        alert('Please upload the renewal document.'); 
        return; 
    }

    // Prepare FormData
    let formData = new FormData();
    formData.append('equipment_id', id);
    formData.append('new_expiry_date', newExpiry);
    formData.append('renew_doc', file);
    //formData.append('renew_category', renewCategory);
   // formData.append('renew_other_category', renewOtherCategory);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    // Send AJAX request
    $.ajax({
        url: '{{ route("add_calibration_list_renew") }}',
        type: 'POST',
        data: formData,
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        success: function(response) {
            if (response.success) {
                // Update local data after success
                item.calibrations.forEach(cal => cal.expiry_date = newExpiry);

                document.getElementById('renew-modal').classList.remove('visible');
                updateDashboard();
                sortAndFilterEquipment();

                alert('Calibration renewed successfully!');
            } else {
                alert(response.message || 'Something went wrong!');
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Error renewing calibration!');
        }
    });
}


        function openDeactivateModal(id) {
            
           
            document.getElementById('deactivate-equipment-id').value = id;
            document.getElementById('deactivation-comment').value = '';
            document.getElementById('deactivate-comment-modal').classList.add('visible');
        }

        function confirmDeactivation() {
    const id = document.getElementById('deactivate-equipment-id').value;
    const comment = document.getElementById('deactivation-comment').value; // get comment text

    $.ajax({
        url: "{{ route('calibration_status_change') }}",
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            equipment_id: id,
            new_status: 0, // 0 for deactivate
            comment: comment
        },
        success: function (data) {
            console.log("Status update sent successfully.", data);

            // Update local data
            const item = equipmentData.find(d => d.equipment_id === id);
            if (item) {
                item.isActive = false;
                document.getElementById('deactivate-comment-modal').classList.remove('visible');
                updateDashboard();
                sortAndFilterEquipment();
            }
        },
        error: function (xhr) {
            console.error("Error while sending status update:", xhr.responseText);
            alert("Error: " + xhr.responseText);
        }
    });
}

        
        function activateItem(id) {
            const item = equipmentData.find(d => d.equipment_id === id);
            if (item) {
                item.isActive = true;
                updateDashboard();
                sortAndFilterEquipment();
                $.ajax({
        url: "{{ route('calibration_status_change') }}",
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            equipment_id: id,
            new_status: 1, // 0 for deactivate
        },
        success: function (data) {
            console.log("Status update sent successfully.", data);
            // Update local data
            const item = equipmentData.find(d => d.equipment_id === id);
            if (item) {
                item.isActive = false;
                document.getElementById('deactivate-comment-modal').classList.remove('visible');
                updateDashboard();
                sortAndFilterEquipment();
            }
        },
        error: function (xhr) {
            console.error("Error while sending status update:", xhr.responseText);
            alert("Error: " + xhr.responseText);
        }
    });
    location.reload();
            }
        }

        document.getElementById('renew-save-btn').addEventListener('click', saveRenewal);
        document.getElementById('renew-cancel-btn').addEventListener('click', () => document.getElementById('renew-modal').classList.remove('visible'));
        document.getElementById('renew-modal-close-btn').addEventListener('click', () => document.getElementById('renew-modal').classList.remove('visible'));
        document.getElementById('deactivate-comment-confirm-btn').addEventListener('click', confirmDeactivation);
        document.getElementById('deactivate-comment-cancel-btn').addEventListener('click', () => document.getElementById('deactivate-comment-modal').classList.remove('visible'));
        document.getElementById('deactivate-comment-close-btn').addEventListener('click', () => document.getElementById('deactivate-comment-modal').classList.remove('visible'));
        document.getElementById('history-modal-close-btn').addEventListener('click', () => document.getElementById('history-modal').classList.remove('visible'));


        const bulkActionsBar = document.getElementById('bulk-actions-bar');
        const selectedCountSpan = document.getElementById('selected-count');
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        
        function updateBulkActionUI() {
            selectedCountSpan.textContent = `${selectedItems.size} item${selectedItems.size > 1 ? 's' : ''} selected`;
            bulkActionsBar.classList.toggle('visible', selectedItems.size > 0);
        }

        function updateSelectAllCheckboxState() {
            const allVisibleCheckboxes = [...equipmentTbody.querySelectorAll('.row-checkbox')];
            if (allVisibleCheckboxes.length === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
                return;
            }
            const allVisibleSelected = allVisibleCheckboxes.every(cb => cb.checked);
            selectAllCheckbox.checked = allVisibleSelected;
            selectAllCheckbox.indeterminate = !allVisibleSelected && allVisibleCheckboxes.some(cb => cb.checked);
        }

        selectAllCheckbox.addEventListener('change', () => {
            equipmentTbody.querySelectorAll('.row-checkbox').forEach(cb => {
                cb.checked = selectAllCheckbox.checked;
                if (selectAllCheckbox.checked) selectedItems.add(cb.dataset.id);
                else selectedItems.delete(cb.dataset.id);
            });
            updateBulkActionUI();
        });

        equipmentTbody.addEventListener('change', e => {
            if (e.target.classList.contains('row-checkbox')) {
                if (e.target.checked) selectedItems.add(e.target.dataset.id);
                else selectedItems.delete(e.target.dataset.id);
                updateBulkActionUI();
                updateSelectAllCheckboxState();
            }
        });
        
        document.getElementById('searchInput').addEventListener('keyup', () => { currentPage = 1; sortAndFilterEquipment(); });
        document.getElementById('refresh-btn').addEventListener('click', () => { equipmentData = []; initializeApp(); });
        document.getElementById('items-per-page').addEventListener('change', e => { itemsPerPage = parseInt(e.target.value, 10); currentPage = 1; sortAndFilterEquipment(); });
        document.getElementById('prev-page-btn').addEventListener('click', () => { if (currentPage > 1) { currentPage--; sortAndFilterEquipment(); } });
        document.getElementById('next-page-btn').addEventListener('click', () => {
            const totalPages = Math.ceil(currentFilteredData.length / itemsPerPage);
            if(currentPage < totalPages) { currentPage++; sortAndFilterEquipment(); }
        });
        document.querySelectorAll('#equipment-table th .table-sort-icon').forEach(icon => {
            icon.addEventListener('click', (e) => {
                const th = e.target.closest('th');
                const column = th.dataset.column;
                if(!column) return;
                if (currentSortColumn === column) currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
                else { currentSortColumn = column; currentSortOrder = 'desc'; }
                document.querySelectorAll('#equipment-table th .table-sort-icon').forEach(i => i.className = 'fas fa-sort table-sort-icon');
                th.querySelector('.table-sort-icon').className = `fas fa-sort-${currentSortOrder === 'asc' ? 'up' : 'down'} table-sort-icon`;
                sortAndFilterEquipment();
            });
        });
        
        // --- Export & Filter Handlers ---
        function downloadFile(content, fileName, contentType) {
            const a = document.createElement("a");
            const file = new Blob([content], { type: contentType });
            a.href = URL.createObjectURL(file);
            a.download = fileName;
            a.click();
            URL.revokeObjectURL(a.href);
        }

        document.getElementById('export-csv-btn').addEventListener('click', () => {
            const headers = ["Equipment ID", "Equipment Name", "Brand", "Model", "Department", "Location", "Status", "Calibration ID", "Certificate No.", "Certificate URL", "Calibration Type", "Capacity/Range", "Calibrated Range", "Least Count", "Calibration Date", "Expiry Date"];
            let rows = [];
            currentFilteredData.forEach(item => {
                item.calibrations.forEach(cal => {
                    const rowData = [
                        item.equipment_id, item.equipment_name, item.brand, item.model_number, item.department, item.location, item.statusInfo.text,
                        cal.calibration_id,
                        cal.certificate_number,
                        cal.certificate_url, // Correctly added the URL data field here
                        cal.calibration_type,
                        cal.capacity_range,
                        cal.calibration_range,
                        cal.least_count,
                        cal.calibration_date,
                        cal.expiry_date
                    ];
                    rows.push(rowData.map(d => `"${String(d || '').replace(/"/g, '""')}"`).join(','));
                });
            });
            const csvContent = [headers.join(','), ...rows].join('\n');
            downloadFile(csvContent, `equipment_data_${new Date().toISOString().split('T')[0]}.csv`, 'text/csv;charset=utf-8;');
        });

        document.getElementById('export-json-btn').addEventListener('click', () => {
            const jsonContent = JSON.stringify(currentFilteredData, null, 2);
            downloadFile(jsonContent, `equipment_data_${new Date().toISOString().split('T')[0]}.json`, 'application/json');
        });

        // --- Initial Load ---
        initializeApp();
    });
    </script>
    
    <script>
    
    document.addEventListener('click', function(e) {
    if (e.target.closest('.upload-btn')) {
        const id = e.target.closest('.upload-btn').dataset.id;
        document.getElementById(`upload-input-${id}`).click();
    }
});

        document.addEventListener('change', function(e) {
    if (e.target.classList.contains('upload-input')) {
        const id = e.target.id.replace('upload-input-', '');
        const file = e.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('equipment_id', id);
        formData.append('certificate', file);

        fetch("{{ route('calibration_upload_file') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log("Upload success:", data);
            
            location.reload();
            // Refresh or update row to show View Cert link
        })
        .catch(err => {
            console.error("Upload error:", err);
            alert("Error uploading certificate.");
        });
    }
});

    </script>
</body>
</html>
