@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style>
        :root {
            --primary: #2e7d32;
            --secondary: #00695c;
            --accent: #ff8f00;
            --warning: #d32f2f;
            --light-bg: #f5f5f5;
            --card-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-bg);
            color: #333;
        }
        
        /* Top Navigation Bar */
        .top-nav {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        .top-nav-items {
            display: flex;
            height: 100%;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0 20px;
            cursor: pointer;
            transition: all 0.3s;
            height: 100%;
            position: relative;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: rgba(255,255,255,0.15);
        }
        
        .nav-item i {
            margin-right: 8px;
        }
        
        .nav-item.active:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: white;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-left: 15px;
        }
        
        .main-content {
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            padding: 10px 15px;
            border-radius: 30px;
            width: 300px;
            box-shadow: var(--card-shadow);
        }
        
        .search-bar input {
            border: none;
            outline: none;
            margin-left: 10px;
            width: 100%;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card.warning {
            border-left: 4px solid var(--warning);
        }
        
        .stat-card h3 {
            margin-top: 0;
            color: #666;
            font-size: 14px;
        }
        
        .stat-card .value {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-card .change {
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        
        .stat-card .change.positive {
            color: var(--primary);
        }
        
        .stat-card .change.negative {
            color: var(--warning);
        }
        
        .main-cards {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-title {
            margin: 0;
            font-size: 18px;
        }
        
        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
        }
        
        .compliance-chart {
            height: 300px;
            background: #f9f9f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            margin-bottom: 20px;
        }
        
        .audit-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .audit-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .audit-item:last-child {
            border-bottom: none;
        }
        
        .audit-info {
            display: flex;
            align-items: center;
        }
        
        .audit-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e3f2fd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
        }
        
        .audit-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-compliant {
            background: #e8f5e9;
            color: var(--primary);
        }
        
        .status-noncompliant {
            background: #ffebee;
            color: var(--warning);
        }
        
        .status-pending {
            background: #fff8e1;
            color: #ff8f00;
        }
        
        .tasks-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .task-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .task-item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            background: white;
            box-shadow: var(--card-shadow);
        }
        
        .task-priority {
            width: 10px;
            height: 100%;
            border-radius: 5px 0 0 5px;
            margin-right: 15px;
        }
        
        .priority-high {
            background-color: var(--warning);
        }
        
        .priority-medium {
            background-color: var(--accent);
        }
        
        .priority-low {
            background-color: var(--primary);
        }
        
        .task-due {
            font-size: 12px;
            color: #999;
        }
        
        /* License Management Styles */
        .tab-container {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            border-bottom: 3px solid var(--primary);
            font-weight: bold;
        }
        

        
        .license-form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            max-width: 600px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1b5e20;
        }
        
        .license-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: var(--card-shadow);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .license-table th, 
        .license-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .license-table th {
            background-color: #f7f7f7;
            font-weight: 600;
        }
        
        .license-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #e8f5e9;
            color: var(--primary);
        }
        
        .badge-warning {
            background: #fff8e1;
            color: #ff8f00;
        }
        
        .badge-danger {
            background: #ffebee;
            color: var(--warning);
        }
        
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--primary);
            margin-right: 10px;
        }
        
        .action-btn:hover {
            opacity: 0.8;
        }
        
        .history-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        
        .history-item:last-child {
            border-bottom: none;
        }
        
        .history-details {
            flex: 1;
        }
        
        .history-date {
            color: #777;
            font-size: 14px;
        }
        
        /* Food Test Styles */
        .filter-bar {
            padding: 15px 20px;
            background: white;
            border-radius: 10px 10px 0 0;
            border-bottom: 1px solid #eee;
        }

        .parameter-badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #e3f2fd;
            border-radius: 10px;
            font-size: 12px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        /* Medical Reports Styles */
        .medical-filter {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .medical-filter .form-group {
            margin-bottom: 0;
            flex: 1;
            min-width: 200px;
        }
        
        .medical-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        
        .medical-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .medical-staff-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .medical-staff-photo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .medical-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        
        .status-clear {
            background: #e8f5e9;
            color: var(--primary);
        }
        
        .status-pending {
            background: #fff8e1;
            color: #ff8f00;
        }
        
        .status-failed {
            background: #ffebee;
            color: var(--warning);
        }
        
        .medical-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .medical-detail-item {
            margin-bottom: 10px;
        }
        
        .medical-detail-label {
            font-weight: 500;
            color: #666;
            margin-bottom: 5px;
        }
        
        .medical-tests {
            margin-top: 20px;
        }
        
        .test-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .test-item:last-child {
            border-bottom: none;
        }
        
        .test-result {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .test-pass {
            color: var(--primary);
        }
        
        .test-fail {
            color: var(--warning);
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 700px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
        
        /* Dashboard sections */
        .dashboard-section {
            display: none;
        }
        
        .dashboard-section.active {
            display: block;
        }

        /* Add Test Modal */
        .param-checkbox-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .param-checkbox {
            display: flex;
            align-items: center;
        }

        .param-checkbox input {
            margin-right: 8px;
        }

        /* New styles for nested parameters */
        .param-category {
            margin-bottom: 10px;
            grid-column: 1 / -1;
        }
        
        .sub-params {
            border-left: 2px solid #ddd;
            padding-left: 10px;
            margin-top: 5px;
            transition: all 0.3s ease;
            display: none;
            margin-left: 20px;
        }
        
        .category-checkbox {
            margin-right: 8px;
        }
        
        .param-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .param-checkbox input {
            margin-right: 8px;
        }
        
        @media (max-width: 992px) {
            .top-nav-items {
                display: none;
            }
            
            .main-cards {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                width: 95%;
                padding: 20px;
            }

            .filter-bar {
                flex-direction: column;
                gap: 10px;
            }

            .param-checkbox-container {
                grid-template-columns: 1fr;
            }
            
            .search-bar {
                width: 200px;
            }
            
            .medical-details {
                grid-template-columns: 1fr;
            }
        }
        
        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .top-nav-items {
                position: fixed;
                top: 60px;
                left: 0;
                width: 100%;
                background: linear-gradient(to bottom, var(--primary), var(--secondary));
                flex-direction: column;
                height: auto;
                display: none;
            }
            
            .top-nav-items.show {
                display: flex;
            }
            
            .nav-item {
                padding: 15px 20px;
                height: auto;
            }
            
            .search-bar {
                width: 100%;
                margin: 10px 0;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .medical-staff-info {
                flex-direction: column;
                align-items: flex-start;
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
                <button role="tab" aria-selected="true" aria-controls="panel-dashboard" id="tab-dashboard" class="active">
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
            <div role="tabpanel" id="panel-dashboard" aria-labelledby="tab-dashboard" class="tab-panel-main active ">
                											 	 <div class="" id="company-details1" role="tabpanel">
							
														 
							<div class="header">
            <h1 id="section-title">Compliance Dashboard</h1>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>
        </div>							     
      <div class="col-sm-12 col-lg-12 mg-b-20">
          
                             	      <div id="dashboard" class="dashboard-section active">
            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Overall Compliance</h3>
                    <div class="value">87%</div>
                    <div class="change positive">
                        <i class="fas fa-arrow-up"></i> 5% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Hygiene Rating</h3>
                    <div class="value">4.2 <small>/5</small></div>
                    <div class="change positive">
                        <i class="fas fa-arrow-up"></i> 0.3 from last audit
                    </div>
                </div>
                <div class="stat-card warning">
                    <h3>Licenses Expiring</h3>
                    <div class="value">3</div>
                    <div class="change negative">
                        <i class="fas fa-exclamation-circle"></i> Requires attention
                    </div>
                </div>
                <div class="stat-card">
                    <h3>RUCO Collection</h3>
                    <div class="value">425 <small>liters</small></div>
                    <div class="change positive">
                        <i class="fas fa-arrow-up"></i> 12% target achieved
                    </div>
                </div>
            </div>
            
            <!-- Main Cards -->
            <div class="main-cards">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Compliance Trend</h2>
                        <a href="#" class="view-all">View Report</a>
                    </div>
                    <div class="compliance-chart">
                        [Compliance Trend Chart Would Appear Here]
                    </div>
                    <div class="card-footer">
                        <div class="legend">
                            <span><i class="fas fa-square" style="color: var(--primary)"></i> Compliant</span>
                            <span><i class="fas fa-square" style="color: var(--accent)"></i> Needs Improvement</span>
                            <span><i class="fas fa-square" style="color: var(--warning)"></i> Non-Compliant</span>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Audits</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <ul class="audit-list">
                        <li class="audit-item">
                            <div class="audit-info">
                                <div class="audit-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div>
                                    <div>Kitchen Hygiene</div>
                                    <small>15 May 2023</small>
                                </div>
                            </div>
                            <span class="audit-status status-compliant">Compliant</span>
                        </li>
                        <li class="audit-item">
                            <div class="audit-info">
                                <div class="audit-icon">
                                    <i class="fas fa-flask"></i>
                                </div>
                                <div>
                                    <div>Food Testing</div>
                                    <small>10 May 2023</small>
                                </div>
                            </div>
                            <span class="audit-status status-noncompliant">2 Issues</span>
                        </li>
                        <li class="audit-item">
                            <div class="audit-info">
                                <div class="audit-icon">
                                    <i class="fas fa-file-contract"></i>
                                </div>
                                <div>
                                    <div>Pest Control</div>
                                    <small>5 May 2023</small>
                                </div>
                            </div>
                            <span class="audit-status status-pending">Pending Review</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Tasks Section -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Pending Actions</h2>
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="tasks-container">
                    <ul class="task-list">
                        <li class="task-item">
                            <div style="display: flex;">
                                <div class="task-priority priority-high"></div>
                                <div>
                                    <div>Renew FSSAI License</div>
                                    <div class="task-due">Due in 7 days</div>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v"></i>
                        </li>
                        <li class="task-item">
                            <div style="display: flex;">
                                <div class="task-priority priority-medium"></div>
                                <div>
                                    <div>Schedule Pest Control</div>
                                    <div class="task-due">Due in 14 days</div>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v"></i>
                        </li>
                    </ul>
                    <ul class="task-list">
                        <li class="task-item">
                            <div style="display: flex;">
                                <div class="task-priority priority-high"></div>
                                <div>
                                    <div>Medical Tests for 3 Staff</div>
                                    <div class="task-due">Overdue by 2 days</div>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v"></i>
                        </li>
                        <li class="task-item">
                            <div style="display: flex;">
                                <div class="task-priority priority-low"></div>
                                <div>
                                    <div>Submit RUCO Report</div>
                                    <div class="task-due">Due in 30 days</div>
                                </div>
                            </div>
                            <i class="fas fa-ellipsis-v"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>				 
														 
                                        </div>
                    
                            
										
                                  </div>      

            </div>


        </div>
    </div>




                    
                    

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


   