@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

<meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <!-- ADDED: Slim Select JS for Filters -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.min.js"></script>


    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500;700&family=Segoe+UI:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <!-- ADDED: Slim Select CSS for Filters -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.min.css" rel="stylesheet">

    <style>
    

    .schedule-card button.btn {
        
         background: transparent; 
    }
    
.schedule-card button.btn.btn-outline-secondary:hover {
    background: #6c757d;
}

.schedule-card button.btn.btn-outline-danger.btn-remove-schedule:hover {
    background: #dc3545;
}
i.fas.fa-eye {
    font-size: 13px;
}
i.fas.fa-times {
    
    font-size: 13px;
}
    
    
    svg.ss-arrow {
    float: right;
}
        /* --- TABS STYLES --- */
        :root {
            --primary-color: #3498db;
            --primary-color-dark: #2980b9;
            --secondary-color: #7f8c8d;
            --light-gray-color: #ecf0f1;
            --very-light-gray-color: #f8f9fa;
            /* Used for tab bar background */
            --dark-color: #2c3e50;
            --border-color: #bdc3c7;
            --white-color: #ffffff;

            --font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --border-radius: 8px;
            --box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --scroll-indicator-size: 30px;
            /* Width of the gradient indicator */
        }

        body {
            font-family: var(--font-family);
            margin: 0;
            background-color: var(--light-gray-color);
            color: var(--dark-color);
            line-height: 1.6;
        }

        .tabs-container {
            width: 100%;
            background-color: var(--white-color);
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin: 20px;
        }

        .tab-navigation {
            position: relative;
            display: flex;
            background-color: var(--very-light-gray-color);
            border-bottom: 1px solid var(--border-color);
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            padding: 0 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tab-navigation::-webkit-scrollbar {
            display: none;
        }

        .tab-navigation {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .tab-navigation::before,
        .tab-navigation::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: var(--scroll-indicator-size);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            z-index: 2;
        }

        .tab-navigation::before {
            left: 0;
            background: linear-gradient(to right, var(--very-light-gray-color) 30%, hsla(210, 17%, 98%, 0) 100%);
        }

        .tab-navigation::after {
            right: 0;
            background: linear-gradient(to left, var(--very-light-gray-color) 30%, hsla(210, 17%, 98%, 0) 100%);
        }

        .tab-navigation.show-scroll-indicator-left::before {
            opacity: 1;
        }

        .tab-navigation.show-scroll-indicator-right::after {
            opacity: 1;
        }

        .tab-navigation button {
            padding: 15px 20px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            font-size: 0.95em;
            font-weight: 500;
            color: var(--secondary-color);
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .tab-navigation button svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            transition: fill 0.3s ease;
        }

        .tab-navigation button:hover {
            color: var(--primary-color);
            background-color: #e0e6e8;
        }

        .tab-navigation button[aria-selected="true"] {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            font-weight: 600;
            background-color: var(--white-color);
        }

        .tab-navigation button[aria-selected="true"] svg {
            fill: var(--primary-color);
        }

        .tab-navigation button:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: -2px;
            z-index: 1;
        }

        .tab-content section {
            animation: fadeIn 0.5s ease-in-out;
            min-height: 150px;
        }

        .tab-content section:not(#equipment-panel):not(#cleaning-panel) {
            padding: 25px 30px;
        }

        #cleaning-panel {
            padding: 25px 30px !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-content section[hidden] {
            display: none;
        }

        .tab-content h2 {
            margin-top: 0;
            color: var(--primary-color-dark);
            border-bottom: 1px solid var(--light-gray-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .tab-content p {
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        @media (max-width: 900px) {
            .tab-navigation button {
                padding: 14px 16px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 600px) {
            .tabs-container {
                margin: 10px;
            }

            .tab-navigation button {
                padding: 12px 15px;
                font-size: 0.85em;
            }

            .tab-navigation button svg {
                width: 16px;
                height: 16px;
            }

            .tab-content section:not(#equipment-panel):not(#cleaning-panel) {
                padding: 20px;
            }

            .tab-content h2 {
                font-size: 1.3em;
            }
        }

        /* --- DASHBOARD STYLES (INTEGRATED) --- */
        #equipment-panel {
            --primary-color: #007bff;
            --primary-dark: #0056b3;
            --secondary-color: #28a745;
            --secondary-dark: #1e7e34;
            --danger-color: #dc3545;
            --danger-dark: #b02a37;
            --warning-color: #ffc107;
            --warning-dark: #d39e00;
            --info-color: #17a2b8;
            --info-dark: #117a8b;
            --success-color: #28a745;
            --success-dark: #1e7e34;
            --dark-color: #343a40;
            --dark-dark: #212529;
            --header-bg-color: #34495e;
            --light-bg: #f4f6f9;
            --light-gray: #e9ecef;
            --medium-gray: #ced4da;
            --dark-gray: #6c757d;
            --hygiene-color: #6f42c1;
            --efficiency-color: #fd7e14;
            --card-background: #ffffff;
            --card-border-radius: 8px;
            --button-border-radius: 6px;
            --input-border-radius: 6px;
            --card-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 5px 15px rgba(0, 0, 0, 0.08);
            /* --card-shadow-hover: 0 4px 8px rgba(0, 0, 0, 0.07), 0 10px 20px rgba(0, 0, 0, 0.1); */
            --mobile-fixed-header-height: 70px;
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }

        #equipment-panel * {
            box-sizing: border-box;
        }

        #equipment-panel .dashboard {
            display: grid;
            grid-template-columns: 1fr;
            min-height: 100vh;
            background-color: var(--light-bg);
        }

        #equipment-panel .main-content {
            padding: 1.5rem;
            overflow-y: auto;
        }

        #equipment-panel .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 0.5rem 1.5rem 1rem 1.5rem;
            border-bottom: 2px solid var(--light-gray);
        }

        #equipment-panel .header-title {
            font-size: 1.7rem;
            font-weight: 600;
            color: var(--dark-dark);
        }

        #equipment-panel .header-controls {
            display: flex;
            flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
            gap: 0.75rem;
            align-items: center;
        }

        #equipment-panel .toast-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border-radius: var(--button-border-radius);
            z-index: 1060;
            opacity: 0;
            transition: opacity 0.5s ease-in-out, top 0.5s ease-in-out;
            font-size: 0.9rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        #equipment-panel .toast-notification.show {
            opacity: 1;
            top: 30px;
        }

        #equipment-panel .toast-notification.danger {
            background-color: var(--danger-color);
        }

        #equipment-panel .table-responsive-container {
            position: relative;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            background: var(--card-background);
            border-radius: var(--card-border-radius);
            box-shadow: var(--card-shadow);
        }

        #equipment-panel table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 2960px;
        }

        #equipment-panel th:first-child,
        #equipment-panel td:first-child {
            position: sticky;
            left: 0;
            z-index: 10;
            background-color: var(--card-background);
        }

        #equipment-panel th {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: var(--header-bg-color);
        }

        #equipment-panel th:first-child {
            z-index: 30;
            background-color: var(--header-bg-color);
        }

        #equipment-panel th:nth-child(1),
        #equipment-panel td:nth-child(1) {
            min-width: 300px;
        }

        #equipment-panel th:nth-child(2),
        #equipment-panel td:nth-child(2) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(3),
        #equipment-panel td:nth-child(3) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(4),
        #equipment-panel td:nth-child(4) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(5),
        #equipment-panel td:nth-child(5) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(6),
        #equipment-panel td:nth-child(6) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(7),
        #equipment-panel td:nth-child(7) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(8),
        #equipment-panel td:nth-child(8) {
            min-width: 280px;
        }

        #equipment-panel th:nth-child(9),
        #equipment-panel td:nth-child(9) {
            min-width: 150px;
        }

        #equipment-panel th:nth-child(10),
        #equipment-panel td:nth-child(10) {
            min-width: 200px;
        }

        #equipment-panel th,
        #equipment-panel td {
            padding: 1rem 1.25rem;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: top;
        }

        #equipment-panel th {
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.75px;
        }

        #equipment-panel th>div {
            display: flex;
            align-items: center;
            width: 100%;
        }

        #equipment-panel th:first-child>div {
            justify-content: flex-start;
        }

        #equipment-panel th:not(:first-child)>div {
            justify-content: center;
            text-align: center;
        }

        #equipment-panel tr:hover {
            background-color: rgba(0, 123, 255, 0.03);
        }

        /* #equipment-panel tr:hover td:first-child {
            background-color: rgba(0, 123, 255, 0.015);
        } */
        td {
            transition: background 0.3s ease;
        }

        #equipment-panel .equipment-card {
            display: flex;
            align-items: flex-start;
        }

        #equipment-panel .equipment-info {
            flex: 1;
        }

        #equipment-panel .equipment-name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
        }

        #equipment-panel .equipment-row-number {
            font-weight: 500;
            margin-right: 0.4em;
            color: var(--dark-gray);
            font-size: 0.9em;
            flex-shrink: 0;
        }

        #equipment-panel .equipment-id {
            font-size: 0.7rem;
            color: var(--primary-color);
            background-color: rgba(0, 123, 255, 0.1);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        #equipment-panel .equipment-meta {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            font-size: 0.8rem;
            color: var(--dark-gray);
            margin-top: 0.5rem;
        }

        #equipment-panel .meta-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        #equipment-panel .meta-item i {
            width: 14px;
            text-align: center;
        }

        #equipment-panel .equipment-expand-btn {
            display: none;
            background: var(--light-bg);
            border: 1px solid var(--medium-gray);
            color: var(--dark-gray);
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: var(--button-border-radius);
            cursor: pointer;
            margin-top: 0.75rem;
            width: 100%;
            text-align: center;
            transition: background-color 0.2s, color 0.2s;
        }

        #equipment-panel .equipment-expand-btn:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-dark);
        }

        #equipment-panel .equipment-expand-btn .fas {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }

        #equipment-panel .equipment-expand-btn .expand-btn-text {
            margin-left: 0.3em;
        }

        #equipment-panel tr.is-expanded .equipment-expand-btn .fa-chevron-down {
            transform: rotate(180deg);
        }

        #equipment-panel .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.8rem;
            border-radius: 16px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 0.5rem;
            flex-shrink: 0;
        }

        #equipment-panel .status-operational {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--secondary-dark);
        }

        #equipment-panel .status-maintenance {
            background-color: rgba(255, 193, 7, 0.15);
            color: var(--warning-dark);
        }

        #equipment-panel .status-overdue {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-dark);
        }

        #equipment-panel .status-inactive {
            background-color: rgba(108, 117, 125, 0.1);
            color: var(--dark-gray);
        }

        #equipment-panel .schedule-card,
        #equipment-panel .breakdown-card {
            background: var(--card-background);
            padding: 1rem;
            border-radius: var(--card-border-radius);
            border: 1px solid var(--light-gray);
        }

        #equipment-panel .schedule-card {
            border-left: 3px solid var(--primary-color);
        }

        #equipment-panel .breakdown-card {
            border-left: 3px solid var(--danger-color);
        }

        #equipment-panel .card-data-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-bottom: 0.8rem;
            font-size: 0.8rem;
        }

        #equipment-panel .data-point {
            display: inline-flex;
            align-items: baseline;
            gap: 0.3rem;
            background-color: rgba(0, 0, 0, 0.025);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            border: 1px solid var(--light-gray);
        }

        #equipment-panel .data-point .schedule-label,
        #equipment-panel .data-point .breakdown-label {
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.7rem;
        }

        #equipment-panel .data-point .schedule-value {
            font-weight: 500;
            color: var(--dark-color);
        }

        #equipment-panel .breakdown-value.value-normal {
            color: var(--secondary-dark);
        }

        #equipment-panel .breakdown-value.value-warning {
            color: var(--warning-dark);
        }

        #equipment-panel .breakdown-value.value-critical {
            color: var(--danger-dark);
        }

        #equipment-panel .action-buttons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(38px, 1fr));
            gap: 0.35rem;
            margin-top: 0.8rem;
        }

        #equipment-panel .btn {
            padding: 0.6rem 0.75rem;
            border-radius: var(--button-border-radius);
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s ease-in-out;
            text-align: center;
            border: 1px solid transparent;
            cursor: pointer;
            text-transform: capitalize;
        }

        #equipment-panel .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        #equipment-panel .btn:active {
            transform: translateY(0);
            box-shadow: var(--card-shadow);
        }

        #equipment-panel .action-buttons-grid .btn,
        #equipment-panel .actions-column-grid .btn {
            padding: 0.5rem;
            min-width: auto;
            line-height: 1;
            gap: 0;
        }

        #equipment-panel .action-buttons-grid .btn i,
        #equipment-panel .actions-column-grid .btn i {
            margin-right: 0;
            font-size: 0.9em;
        }

        #equipment-panel .btn-edit {
            background-color: var(--primary-color);
            color: white;
        }

        #equipment-panel .btn-edit:hover {
            background-color: var(--primary-dark);
        }

        #equipment-panel .btn-note {
            background-color: var(--warning-color);
            color: var(--dark-dark);
            border: 1px solid var(--warning-dark);
        }

        #equipment-panel .btn-note:hover {
            background-color: var(--warning-dark);
            color: white;
        }

        #equipment-panel .btn-print {
            background-color: var(--info-color);
            color: white;
        }

        #equipment-panel .btn-print:hover {
            background-color: var(--info-dark);
        }

        #equipment-panel .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        #equipment-panel .btn-delete:hover {
            background-color: var(--danger-dark);
        }

        #equipment-panel .btn-history {
            background-color: var(--dark-gray);
            color: white;
        }

        #equipment-panel .btn-history:hover {
            background-color: var(--dark-color);
        }

        #equipment-panel .btn-view {
            background-color: var(--secondary-color);
            color: white;
        }

        #equipment-panel .btn-view:hover {
            background-color: var(--secondary-dark);
        }

        #equipment-panel .btn-add {
            background-color: var(--primary-color);
            color: white;
            opacity: 0.9;
        }

        #equipment-panel .btn-add:hover {
            background-color: var(--primary-dark);
            opacity: 1;
        }

        #equipment-panel .btn-qr {
            background-color: var(--dark-color);
            color: white;
        }

        #equipment-panel .btn-qr:hover {
            background-color: var(--dark-dark);
        }

        #equipment-panel .btn-download {
            background-color: var(--info-color);
            color: white;
            opacity: 0.9;
        }

        #equipment-panel .btn-download:hover {
            background-color: var(--info-dark);
            opacity: 1;
        }

        #equipment-panel .btn-add-equipment-header .btn-text {
            display: inline;
        }

        #equipment-panel .combined-trend-container {
            position: relative;
            width: 100%;
            max-width: 160px;
            height: 60px;
            margin-top: 1rem;
            cursor: pointer;
            border-radius: 4px;
            overflow: hidden;
        }

        #equipment-panel .combined-trend-graph {
            width: 100%;
            height: 100%;
            background-color: var(--light-bg);
            border-radius: 4px;
            padding: 0.25rem;
        }

        #equipment-panel .combined-trend-tooltip {
            position: absolute;
            bottom: 105%;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--dark-dark);
            color: white;
            padding: 0.35rem 0.6rem;
            border-radius: 4px;
            font-size: 0.7rem;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
            pointer-events: none;
            z-index: 100;
        }

        #equipment-panel .combined-trend-container:hover .combined-trend-tooltip {
            opacity: 1;
            transform: translateX(-50%) translateY(-5px);
        }

        #equipment-panel .actions-column-grid {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        #equipment-panel .actions-column-grid .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        #equipment-panel .actions-column-grid .btn-group .btn {
            flex: 1;
        }

        #equipment-panel .activation-log-display {
            font-size: 0.75rem;
            max-height: 70px;
            overflow-y: auto;
            border-top: 1px solid var(--light-gray);
            padding-top: 5px;
            margin-top: 0.5rem;
        }

        #equipment-panel .activation-log-display div {
            margin-bottom: 3px;
            line-height: 1.3;
        }

        #equipment-panel .activation-log-display strong {
            display: inline-block;
            min-width: 70px;
        }

        #equipment-panel .activation-log-display em {
            color: var(--dark-gray);
        }

        @keyframes pulse {
            0% {
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
            }

            70% {
                opacity: 0.8;
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        #equipment-panel .status-alert.status-overdue {
            animation: pulse 2s infinite;
            border-radius: 16px;
        }

        #equipment-panel .activation-toggle-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 34px;
        }

        #equipment-panel .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            flex-shrink: 0;
        }

        #equipment-panel .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        #equipment-panel .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--danger-color);
            transition: .4s;
        }

        #equipment-panel .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
        }

        #equipment-panel input:checked+.slider {
            background-color: var(--success-color);
        }

        #equipment-panel input:focus+.slider {
            box-shadow: 0 0 1px var(--success-color);
        }

        #equipment-panel input:checked+.slider:before {
            transform: translateX(26px);
        }

        #equipment-panel .slider.round {
            border-radius: 24px;
        }

        #equipment-panel .slider.round:before {
            border-radius: 50%;
        }

        #equipment-panel .activation-status-text {
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Styles for Monitoring Multi-Select Dropdown */
        #equipment-panel .multi-select-monitoring {
            position: relative;
            min-width: 200px;
        }

        #equipment-panel .multi-select-monitoring .multi-select-display {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white-color);
        }

        #equipment-panel .multi-select-monitoring .multi-select-display:focus,
        #equipment-panel .multi-select-monitoring .multi-select-display.open {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        #equipment-panel .multi-select-monitoring .multi-select-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            width: 100%;
            background: var(--white-color);
            border: 1px solid #dee2e6;
            border-radius: 4px;
            z-index: 101;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #equipment-panel .multi-select-monitoring .multi-select-search {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 1px solid #dee2e6;
            outline: none;
            font-size: 0.9rem;
        }

        #equipment-panel .multi-select-monitoring .multi-select-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 180px;
            overflow-y: auto;
        }

        #equipment-panel .multi-select-monitoring .multi-select-list li label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            cursor: pointer;
            font-weight: 400;
        }

        #equipment-panel .multi-select-monitoring .multi-select-list li:hover {
            background-color: #f8f9fa;
        }

        #equipment-panel .multi-select-monitoring .multi-select-list li label input[type="checkbox"] {
            cursor: pointer;
        }

        #equipment-panel .hidden {
            display: none;
        }

        @media (max-width: 1399.98px) {

            #equipment-panel th,
            #equipment-panel td {
                padding: 0.85rem 1rem;
            }
        }

        @media (max-width: 1199.98px) {
            #equipment-panel .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        @media (max-width: 991.98px) {
            #equipment-panel .main-content {
                padding: 1.25rem;
            }

            #equipment-panel .action-buttons-grid {
                grid-template-columns: repeat(auto-fit, minmax(36px, 1fr));
                gap: 0.25rem;
            }

            #equipment-panel .combined-trend-container {
                max-width: 120px;
                height: 45px;
            }

            .score-item-horizontal {
                font-size: 0.7rem;
                padding: 0.15rem 0.3rem;
                gap: 0.2rem;
            }

            #equipment-panel .btn {
                padding: 0.5rem;
            }

            #equipment-panel .pagination-controls-container {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start !important;
            }
        }

        @media (max-width: 767.98px) {
            #equipment-panel .header {
                position: static;
                box-shadow: none;
                border-bottom: 1px solid var(--medium-gray);
                padding: 1rem;
            }

            #equipment-panel .header .btn-add-equipment-header {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 56px !important;
                height: 56px;
                border-radius: 50%;
                padding: 0;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
                z-index: 990;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #equipment-panel .header .btn-add-equipment-header .btn-text {
                display: none;
            }

            #equipment-panel .header .btn-add-equipment-header i.fas {
                font-size: 1.5rem;
                margin-right: 0;
            }

            #equipment-panel .main-content {
                padding: 1rem;
                padding-top: 1rem;
                padding-bottom: 80px;
            }

            #equipment-panel .table-responsive-container {
                box-shadow: none;
                background: transparent;
                overflow-x: visible;
            }

            #equipment-panel .table-responsive-container table {
                min-width: 100%;
                border-collapse: collapse;
                background: transparent;
            }

            #equipment-panel .table-responsive-container thead {
                display: none;
            }

            #equipment-panel .table-responsive-container tr {
                display: block;
                margin-bottom: 1.5rem;
                background: var(--card-background);
                border-radius: var(--card-border-radius);
                box-shadow: var(--card-shadow);
                padding: 1rem;
                border: 1px solid var(--light-gray);
            }

            #equipment-panel .table-responsive-container tr:hover {
                background-color: var(--card-background);
            }

            #equipment-panel .table-responsive-container td {
                display: flex;
                flex-direction: column;
                padding: 0.85rem 0.25rem;
                border-bottom: 1px dotted var(--light-gray);
                width: 100% !important;
                min-width: 0 !important;
                background-color: transparent !important;
                position: static !important;
                left: auto !important;
                z-index: auto !important;
                text-align: left;
                min-height: auto;
            }

            #equipment-panel .table-responsive-container td:last-child {
                border-bottom: none;
            }

            #equipment-panel .table-responsive-container td::before {
                content: attr(data-label);
                display: block;
                font-weight: 600;
                color: var(--dark-gray);
                margin-bottom: 0.75rem;
                font-size: 0.7rem;
                text-transform: uppercase;
                flex-shrink: 0;
            }

            #equipment-panel .table-responsive-container td>.breakdown-card,
            #equipment-panel .table-responsive-container td>.schedule-card,
            #equipment-panel .table-responsive-container td>.performance-scores-horizontal,
            #equipment-panel .table-responsive-container td>.combined-trend-container,
            #equipment-panel .table-responsive-container td>.actions-column-grid,
            #equipment-panel .table-responsive-container td>.activation-toggle-container {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            #equipment-panel .table-responsive-container td>.activation-toggle-container {
                flex-direction: row;
                justify-content: flex-start;
            }

            #equipment-panel .table-responsive-container td[data-label="Actions"] .activation-log-display {
                width: 100%;
                margin-top: 1rem;
            }

            #equipment-panel .table-responsive-container .mobile-hide-action {
                display: none !important;
            }

            #equipment-panel .equipment-expand-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #equipment-panel tr:not(.is-expanded) .mobile-expandable-td {
                display: none !important;
            }

            #equipment-panel tr.is-expanded .mobile-expandable-td {
                display: block !important;
                border-top: 1px solid var(--light-gray);
                padding-top: 1rem;
                margin-top: 0.5rem;
            }

            #equipment-panel .pagination-controls-container {
                flex-direction: row;
                gap: 0;
            }
        }

        @media (max-width: 575.98px) {
            #equipment-panel .main-content {
                padding: 0.75rem;
                padding-top: 0.75rem;
                padding-bottom: 70px;
            }
        }

        /* --- ADD EQUIPMENT FORM MODAL STYLES --- */
        #addEquipmentModal {
            --form-primary: #4361ee;
            --form-primary-hover: #3a56d4;
            --form-primary-light: rgba(67, 97, 238, 0.1);
            --form-secondary: #6c757d;
            --form-danger: #f72585;
            --form-light: #f8f9fa;
            --form-dark: #212529;
            --form-border: #dee2e6;
            --form-radius: 12px;
            --form-radius-sm: 6px;
            --form-transition: all 0.25s ease-in-out;
            font-family: 'Inter', sans-serif;
        }

        #addEquipmentModal .modal-content {
            border-radius: var(--form-radius);
            border: none;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.09);
        }

        #addEquipmentModal .modal-header {
            padding: 25px 35px;
            border-bottom: 1px solid var(--form-border);
            background-color: var(--form-light);
            border-top-left-radius: var(--form-radius);
            border-top-right-radius: var(--form-radius);
        }

        #addEquipmentModal .modal-header .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--form-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #addEquipmentModal .modal-header .modal-title i {
            color: var(--form-primary);
        }

        #addEquipmentModal .modal-body {
            padding: 35px;
        }

        #addEquipmentModal .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.75rem;
            margin-bottom: 1.75rem;
        }

        #addEquipmentModal .form-group {
            flex: 1 1 calc(50% - 1rem);
            display: flex;
            flex-direction: column;
            min-width: 250px;
        }

        #addEquipmentModal .form-group-full-width {
            flex-basis: 100%;
        }

        #addEquipmentModal label {
            font-size: 0.875rem;
            color: #495057;
            margin-bottom: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #addEquipmentModal label .fa-solid {
            color: var(--form-secondary);
        }

        #addEquipmentModal label.required::after {
            content: '*';
            color: var(--form-danger);
            margin-left: 2px;
        }

        #addEquipmentModal .input-wrapper {
            position: relative;
        }

        #addEquipmentModal .input-wrapper .fa-solid {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--form-secondary);
            font-size: 0.9rem;
            transition: var(--form-transition);
        }

        #addEquipmentModal input[type="text"],
        #addEquipmentModal select {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid var(--form-border);
            border-radius: var(--form-radius-sm);
            font-size: 0.95rem;
            background-color: #fff;
            transition: var(--form-transition);
            appearance: none;
        }

        #addEquipmentModal input[readonly] {
            background-color: #e9ecef !important;
            cursor: not-allowed;
        }

        #addEquipmentModal select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 12px;
            padding-right: 3rem;
        }

        #addEquipmentModal input[type="text"]:focus,
        #addEquipmentModal select:focus {
            border-color: var(--form-primary);
            outline: 0;
            box-shadow: 0 0 0 3px var(--form-primary-light);
        }

        #addEquipmentModal .input-wrapper:has(input:focus) .fa-solid,
        #addEquipmentModal .input-wrapper:has(select:focus) .fa-solid {
            color: var(--form-primary);
        }

        #addEquipmentModal .radio-option-group {
            margin-bottom: 1.5rem;
            border: 1px solid var(--form-border);
            border-radius: var(--form-radius);
            background-color: #fff;
            transition: var(--form-transition);
        }

        #addEquipmentModal .radio-option-group.is-expanded {
            border-color: var(--form-primary);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            border-bottom-color: transparent;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.1);
        }

        #addEquipmentModal .radio-header {
            padding: 1rem 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #addEquipmentModal .radio-section-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--form-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #addEquipmentModal .radio-section-label i {
            color: var(--form-primary);
        }

        #addEquipmentModal .radio-toggle {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        #addEquipmentModal .radio-toggle input[type="radio"] {
            opacity: 0;
            position: absolute;
            width: 1px;
            height: 1px;
        }

        #addEquipmentModal .radio-toggle label {
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            color: var(--form-secondary);
            font-weight: 500;
            transition: var(--form-transition);
            margin-bottom: 0;
        }

        #addEquipmentModal .radio-toggle label:hover {
            color: var(--form-dark);
        }

        #addEquipmentModal .radio-toggle label::before {
            content: "";
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.6rem;
            background-color: #fff;
            border: 2px solid var(--form-border);
            transition: var(--form-transition);
        }

        #addEquipmentModal .radio-toggle input[type="radio"]:checked+label {
            color: var(--form-primary);
            font-weight: 600;
        }

        #addEquipmentModal .radio-toggle input[type="radio"]:checked+label::before {
            background-color: var(--form-primary);
            border-color: var(--form-primary);
            box-shadow: inset 0 0 0 4px white;
        }

        #addEquipmentModal .dynamic-details-section {
            display: none;
            padding: 1.75rem 1.5rem;
            margin-top: -1px;
            border: 1px solid var(--form-primary);
            border-top: 1px dashed var(--form-border);
            border-bottom-left-radius: var(--form-radius);
            border-bottom-right-radius: var(--form-radius);
            background-color: #fff;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeInForm {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #addEquipmentModal .dynamic-details-section.is-visible {
            display: block;
        }

        #addEquipmentModal .modal-footer {
            border-top: 1px solid var(--form-border);
            background-color: var(--form-light);
            padding: 1rem 35px;
        }

        #addEquipmentModal .footer-button {
            color: #fff;
            padding: 0.75rem 1.75rem;
            border: none;
            border-radius: var(--form-radius-sm);
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--form-transition);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        #addEquipmentModal .footer-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        #addEquipmentModal .footer-button.submit-button {
            background-color: var(--form-primary);
        }

        #addEquipmentModal .footer-button.submit-button:hover {
            background-color: var(--form-primary-hover);
        }

        @media (max-width: 768px) {

            #addEquipmentModal .modal-body,
            #addEquipmentModal .modal-header,
            #addEquipmentModal .modal-footer {
                padding: 20px;
            }

            #addEquipmentModal .form-group {
                flex-basis: 100%;
            }

            #addEquipmentModal .radio-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        /* --- CHECKLIST STYLES --- */
        #checklist-panel {
            padding: 0 !important;
            /* Override default padding */
        }

        #checklist-panel .checklist-container {
            max-width: 100%;
            margin: auto;
            background-color: var(--white-color);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        #checklist-panel .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        #checklist-panel .top-bar h1 {
            font-size: 1.25rem;
            margin: 0;
            font-weight: 600;
        }

        #checklist-panel .add-new-btn {
            background-color: #0d6efd;
            color: var(--white-color);
            border: none;
            border-radius: 6px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        #checklist-panel .add-new-btn:hover {
            background-color: #0b5ed7;
        }

        #checklist-panel .table-wrapper {
            overflow-x: auto;
        }

        #checklist-panel table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        #checklist-panel th,
        #checklist-panel td {
            padding: 1rem 1.5rem;
            text-align: left;
            white-space: nowrap;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        #checklist-panel thead {
            background-color: #f8f9fa;
        }

        #checklist-panel thead th {
            color: #212529;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        #checklist-panel .sortable-header {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        #checklist-panel .sort-icon {
            opacity: 0.4;
            display: inline-block;
            width: 16px;
            height: 16px;
        }

        #checklist-panel tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.3s ease-in-out;
        }

        #checklist-panel tbody tr:last-child {
            border-bottom: none;
        }

        #checklist-panel tbody td {
            color: #495057;
        }

        #checklist-panel .action-cell {
            position: relative;
        }

        #checklist-panel .action-btn {
            background-color: #6c757d;
            border: none;
            border-radius: 6px;
            padding: 0.5rem 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #checklist-panel .action-btn svg {
            fill: var(--white-color);
        }

        #checklist-panel .action-menu {
            position: absolute;
            top: calc(100% + 5px);
            right: 0;
            background-color: var(--white-color);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 100;
            width: max-content;
            overflow: hidden;
            padding: 0.5rem 0;
        }

        #checklist-panel .action-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        #checklist-panel .action-menu li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            cursor: pointer;
            font-size: 0.9rem;
            color: #212529;
            transition: background-color 0.2s ease;
        }

        #checklist-panel .action-menu li:hover {
            background-color: #f1f3f5;
        }

        #checklist-panel .action-menu li.delete-template:hover {
            background-color: #ffeef0;
            color: #dc3545;
        }

        #checklist-panel .action-menu li.delete-template:hover svg {
            fill: #dc3545;
        }

        #checklist-panel .action-menu svg {
            width: 18px;
            height: 18px;
            fill: #495057;
        }

        #checklist-panel .hidden {
            display: none;
        }

        #checklist-panel .editable-input {
            width: 90%;
            padding: 6px 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            border: 1px solid #0d6efd;
            border-radius: 4px;
            outline: none;
        }

        #checklist-panel .pagination-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 1rem 1.5rem;
            border-top: 1px solid #dee2e6;
            font-size: 0.875rem;
            color: #6c757d;
            gap: 1.5rem;
        }

        #checklist-panel .numeric-input {
            width: 60px;
            padding: 6px 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-align: center;
        }

        #checklist-panel .numeric-input:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        #checklist-panel .equipment-count-cell {
            position: relative;
        }

        #checklist-panel .multi-select-container {
            position: relative;
            min-width: 150px;
        }

        #checklist-panel .multi-select-display {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white-color);
        }

        #checklist-panel .multi-select-display:focus,
        #checklist-panel .multi-select-display.open {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        #checklist-panel .multi-select-dropdown {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            width: auto !important;
            padding: 20px;
            background: var(--white-color);
            border: 1px solid #dee2e6;
            border-radius: 4px;
            z-index: 101;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
       ul.multi-select-list1 {
    list-style: none;
    padding: 0px;
}

.multi-select-list1 li {
    padding: 10px 0px 0px;
}

        #checklist-panel .multi-select-search {
            width: calc(100% - 20px);
            padding: 10px;
            border: none;
            border-bottom: 1px solid #dee2e6;
            outline: none;
            font-size: 0.9rem;
        }

        #checklist-panel .multi-select-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 220px;
            overflow-y: auto;
        }

        #checklist-panel .multi-select-list li label {
            display: block;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 400;
        }

        #checklist-panel .multi-select-list li:hover {
            background-color: #f8f9fa;
        }

        #checklist-panel .multi-select-list li label input[type="checkbox"] {
            cursor: pointer;
        }

        /* --- View Template Modal Styles --- */
        #viewTemplateModal .modal-body .detail-group {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        #viewTemplateModal .modal-body .detail-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }

        #viewTemplateModal .modal-body .detail-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: #212529;
        }

        #viewTemplateModal #viewTemplateEquipmentList {
            list-style: none;
            padding: 0;
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        #viewTemplateModal #viewTemplateEquipmentList li {
            padding: 0.6rem 1rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        #viewTemplateModal #viewTemplateEquipmentList li:last-child {
            border-bottom: none;
        }

        #viewTemplateModal #viewTemplateEquipmentList li.is-selected {
            font-weight: 600;
            color: #1a6334;
            background-color: #e9f5ee;
        }

        #viewTemplateModal #viewTemplateEquipmentList li .fa-check-square {
            color: #28a745;
        }

        #viewTemplateModal #viewTemplateEquipmentList li .far.fa-square {
            color: #ced4da;
        }

        /* --- ADDED: Filter Modal Styles --- */
        #filterModal {
            --filter-primary: #005A9C;
            --filter-primary-light: #e6f1f9;
            --filter-secondary: #495057;
            --filter-border: #ced4da;
            --filter-bg: #f8f9fa;
            --filter-surface: #ffffff;
            --filter-danger: #dc3545;
            --filter-danger-hover: #c82333;
            --filter-radius: 6px;
        }

        #filterModal .filter-group-header {
            color: var(--filter-primary);
            border-bottom: 2px solid var(--filter-primary-light);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 1.25em;
            font-weight: 600;
        }

        #filterModal .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        #filterModal .filter-item label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9em;
        }

        #filterModal .ss-main {
            width: 100%;
        }

        #filterModal .ss-main .ss-multi-selected {
            padding: 0.5rem;
            border-radius: var(--filter-radius);
            border: 1px solid var(--filter-border);
        }

        #filterModal .ss-main .ss-content {
            border-color: var(--filter-border);
            border-radius: var(--filter-radius);
            z-index: 1061;
            /* Ensure dropdown appears above modal content */
        }

        #filterModal .ss-main .ss-content .ss-list .ss-option.ss-highlighted,
        #filterModal .ss-main .ss-content .ss-list .ss-option:hover {
            background-color: var(--filter-primary-light);
            color: var(--filter-primary);
        }

        #filterModal .ss-main.ss-disabled .ss-multi-selected {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        
        
     #filterBtn button.btn {
    background: transparent !important; 
    border: none;
}
        
        
        
        .ss-content.form-control.slim-select.ss-open-above {
    overflow-y: auto !important;
}
.ss-content.form-control.slim-select.mydepartment.ss-open-below {
       overflow-y: auto !important;
}
        
        
    </style>
@section('content')
 
@include('admin.popups.fhm.addequipment')
@include('admin.popups.fhm.importequipment')

  <div class="tabs-container">
        <!-- Tab Navigation remains the same -->
        <nav class="tab-navigation" aria-label="Facility Hygiene Sections">
            <button role="tab" aria-selected="true" aria-controls="dashboard-panel" id="dashboard-tab"><svg
                    viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2-8h4v4h-4v-4zm0-2h4v-2c0-1.1-.9-2-2-2s-2 .9-2 2v2z" />
                </svg>Dashboard</button>
            <button role="tab" aria-selected="false" aria-controls="equipment-panel" id="equipment-tab"><svg
                    viewBox="0 0 24 24">
                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z" />
                </svg>Master Equipment List</button>
            <button role="tab" aria-selected="false" aria-controls="checklist-panel" id="checklist-tab"><svg
                    viewBox="0 0 24 24">
                    <path
                        d="M7 5H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h3v-2H4V7h3V5zm10 14h3c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-3v2h3v10h-3v2zm-4-2h-2V5h2v12zm-4-4H7V9h2v6zm4-2h-2v-2h2v2z" />
                </svg>Checklist</button>
            <button role="tab" aria-selected="false" aria-controls="calibration-panel" id="calibration-tab"><svg
                    viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15l-4-4h8l-4 4zM12 6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                </svg>Calibration List</button>
            <button role="tab" aria-selected="false" aria-controls="cleaning-panel" id="cleaning-tab"><svg
                    viewBox="0 0 24 24">
                    <path
                        d="M15.5 5.5c0 .83-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5.67-1.5 1.5-1.5 1.5.67 1.5 1.5zM6 22h12v-2H6v2zm7-15.59V4h2v2.41l4.29 4.29c.39.39.39 1.02 0 1.41l-1.42 1.42-1.06-1.06-1.94 1.94-1.06-1.06-1.94 1.94-1.06-1.06-1.94 1.94-1.41-1.41c-.39-.39-.39-1.02 0-1.41L13 6.41z" />
                </svg>Facility Cleaning</button>
            <button role="tab" aria-selected="false" aria-controls="maintenance-panel" id="maintenance-tab"><svg
                    viewBox="0 0 24 24">
                    <path
                        d="M22.7 19l-2.1-2.1c.9-1.2 1.4-2.6 1.4-4.1 0-3.9-3.1-7-7-7s-7 3.1-7 7c0 1.5.5 2.9 1.4 4.1L2.3 19c-.6.6-.6 1.5 0 2.1.6.6 1.5.6 2.1 0L7 18.6c1.2.9 2.6 1.4 4.1 1.4s2.9-.5 4.1-1.4l2.6 2.6c.3.3.7.4 1.1.4.4 0 .8-.1 1.1-.4.5-.6.5-1.6-.1-2.2zm-10.6-2c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5z" />
                </svg>Facility Maintenance</button>
            <button role="tab" aria-selected="false" aria-controls="breakdown-panel" id="breakdown-tab"><svg
                    viewBox="0 0 24 24">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                </svg>Breakdown</button>
            <button role="tab" aria-selected="false" aria-controls="pest-panel" id="pest-tab"><svg viewBox="0 0 24 24">
                    <path
                        d="M20 8h-3V6c0-1.1-.9-2-2-2H9c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6h6v2H9V6zm11 14H4V10h3v1c0 .55.45 1 1 1s1-.45 1-1v-1h6v1c0 .55.45 1 1 1s1-.45 1-1v-1h3v10zM12 16c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                </svg>Pest Management</button>
        </nav>

        <div class="tab-content">
            <!-- Other Tab Panels ... -->
            <section id="dashboard-panel" role="tabpanel" aria-labelledby="dashboard-tab">
                <h2>Facility Hygiene Dashboard</h2>
                <p>Content for the Facility Hygiene Dashboard will appear here.</p>
            </section>
            <section id="equipment-panel" role="tabpanel" aria-labelledby="equipment-tab" hidden>
                <!-- All equipment-panel HTML (table, modals, etc.) goes here -->
                <div class="dashboard">
                    <div class="main-content">
                        <div class="header">
                            <h2 class="header-title">Master Equipment List</h2>
                            <div class="header-controls">
                                
                                  <button style="background: transparent;" class="btn btn-outline-secondary" id="filterBtn" title="Filter Equipment"
                                    data-bs-toggle="modal" data-bs-target="#filterModal1">
                                    <i class="fas fa-filter"></i> <span class="btn-text d-none d-sm-inline">Filter</span>
                                </button>
                                
                                
                                <!--<button style="background: transparent;" class="btn btn-outline-secondary" id="filterBtn" title="Filter Equipment"-->
                                <!--    data-bs-toggle="modal" data-bs-target="#filterModal">-->
                                <!--    <i class="fas fa-filter"></i> <span class="btn-text d-none d-sm-inline">Filter</span>-->
                                <!--</button>-->
                                <button style="background: transparent;" class="btn btn-outline-secondary" id="refreshMasterListBtn" title="Refresh & Reset Filters">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <!-- Data Import/Export Buttons -->
                                <a href="#" id="downloadSampleCsvBtn" class="btn btn-outline-info" title="Download sample CSV template">
                                    <i class="fas fa-download"></i> <span class="btn-text d-none d-sm-inline">Sample</span>
                                </a>
                                <button id="bulkUploadBtn" class="btn btn-outline-success" title="Bulk Upload Equipment from CSV" data-bs-toggle="modal" data-bs-target="#importequipment">
                                    <i class="fas fa-upload"></i> <span class="btn-text d-none d-sm-inline">Upload</span>
                                </button>
                                <button class="btn btn-success" id="downloadReportBtn" title="Download Equipment Report">
                                    <i class="fas fa-file-excel"></i> <span class="btn-text d-none d-sm-inline">Download Report</span>
                                </button>
                                <button class="btn btn-primary btn-add-equipment-header" title="Add New Equipment"
                                    data-bs-toggle="modal" data-bs-target="#addEquipmentModal"><i
                                        class="fas fa-plus"></i> <span class="btn-text d-none d-md-inline">Add Equipment</span></button>
                            </div>
                        </div>
                        <div id="toastNotification" class="toast-notification">Data Refreshed!</div>
                        <div class="table-responsive-container">
                            <table id="equipmentTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div>Equipment</div>
                                        </th>
                                        
                                        <th>
                                            <div>Cleaning Schedule</div>
                                        </th>
                                        <th>
                                            <div>Preventive Maintenance</div>
                                        </th>
                                        <th>
                                            <div>Breakdown Metrics</div>
                                        </th>
                                        <th>
                                            <div>Monitoring</div>
                                        </th>
                                        <th>
                                            <div>Registered Complain</div>
                                        </th>
                                        <th>
                                            <div>Calibration</div>
                                        </th>
                                        <th>
                                            <div>Activation</div>
                                        </th>
                                        <th>
                                            <div>Actions</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- Pagination Controls Container -->
                        <div class="pagination-controls-container d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex align-items-center">
                                <label for="itemsPerPageSelect" class="form-label me-2 mb-0 text-nowrap">Items per page:</label>
                                <select class="form-select form-select-sm" id="itemsPerPageSelect" style="width: 70px;">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm justify-content-end mb-0" id="paginationUl"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Modals -->
                <!-- Bulk Upload Modal -->
                 <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bulkUploadModalLabel"><i class="fas fa-upload"></i> Bulk Equipment Upload</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info" role="alert">
                                    <h6 class="alert-heading">Instructions</h6>
                                    <p>Please upload a CSV file with the following columns: <strong>equipmentId, equipmentName, makeBrandName, modalNumber, srNumber, selectDepartment, selectLocation</strong>. The `equipmentId` and `equipmentName` fields are required.</p>
                                    <p>If `selectDepartment` or `selectLocation` are left blank in the CSV, the default values selected below will be used.</p>
                                    <hr>
                                    <p class="mb-0">You can <a href="#" id="downloadSampleCsvInModal">download the sample template here</a> to get started.</p>
                                </div>
                                <div class="mb-3">
                                    <label for="bulkUploadDepartment" class="form-label">Default Department:</label>
                                    <select id="bulkUploadDepartment" name="bulkUploadDepartment" class="form-select" required>
                                        <option value="">Please Select Department</option>
                                        <option value="Quality Assurance">Quality Assurance</option>
                                        <option value="Manufacturing">Manufacturing</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Research & Development">Research & Development</option>
                                        <option value="Production">Production</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="bulkUploadLocation" class="form-label">Default Location:</label>
                                    <select id="bulkUploadLocation" name="bulkUploadLocation" class="form-select" required>
                                        <option value="">Select Location</option>
                                        <option value="Lab 1 (R&D)">Lab 1 (R&D)</option>
                                        <option value="Lab 3 (Analytics)">Lab 3 (Analytics)</option>
                                        <option value="Dispensing Booth 2">Dispensing Booth 2</option>
                                        <option value="Central Sterilization">Central Sterilization</option>
                                        <option value="Main Plant Floor">Main Plant Floor</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="csvFileInput" class="form-label fw-bold">Select CSV File</label>
                                    <input class="form-control" type="file" id="csvFileInput" accept=".csv" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="processCsvUploadBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Upload & Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Duplicate Found Modal -->
                <div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="duplicateModalLabel"><i class="fas fa-exclamation-triangle text-warning"></i> Duplicate Equipment Found</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>The following equipment from your CSV file already exists in the master list. These items will be skipped.</p>
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Equipment ID</th>
                                            <th>Equipment Name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="duplicateList">
                                        <!-- Duplicate items will be populated here by JS -->
                                    </tbody>
                                </table>
                                <p class="mt-3">Do you want to proceed by uploading only the non-duplicate items?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel Upload</button>
                                <button type="button" class="btn btn-primary" id="confirmPartialUploadBtn">Upload Non-Duplicates Only</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filterModalLabel"><i class="fas fa-filter"></i> Filter
                                    Equipment List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                 Location Filters 
                                <div class="filter-group">
                                    <h3 class="filter-group-header">Location Filters</h3>
                                    <div class="filter-grid">
                                        <div class="filter-item"><label for="corporate">Corporate</label><select
                                                id="corporate" multiple></select></div>
                                        <div class="filter-item"><label for="regional">Regional</label><select
                                                id="regional" multiple></select></div>
                                        <div class="filter-item"><label for="unit">Unit</label><select id="unit"
                                                multiple></select></div>
                                        <div class="filter-item"><label for="department">Department</label><select
                                                id="department" multiple></select></div>
                                        <div class="filter-item" style="display:none;"><label for="location">Location</label><select
                                                id="location" multiple></select></div>
                                    </div>
                                </div>
                                 Asset & Status Filters 
                                <div class="filter-group">
                                    <h3 class="filter-group-header">Asset & Status Filters</h3>
                                    <div class="filter-grid">
                                        <div class="filter-item"><label for="equipment">Equipment</label><select
                                                id="equipment" multiple></select></div>
                                        <div class="filter-item"><label for="equipmentStatus">Equipment
                                                Status</label><select id="equipmentStatus" multiple></select></div>
                                        <div class="filter-item"><label for="monitoring">Monitoring
                                                Parameter</label><select id="monitoring" multiple></select></div>
                                        <div class="filter-item"><label for="calibration">Calibration
                                                Required</label><select id="calibration" multiple></select></div>
                                    </div>
                                </div>
                                 Schedule & Compliance Filters 
                                <div class="filter-group">
                                    <h3 class="filter-group-header">Schedule & Compliance Filters</h3>
                                    <div class="filter-grid"
                                        style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                                        <div class="filter-item"><label for="cleaningFrequency">Cleaning
                                                Frequency</label><select id="cleaningFrequency" multiple></select></div>
                                        <div class="filter-item"><label for="pmFrequency">PM Frequency</label><select
                                                id="pmFrequency" multiple></select></div>
                                        <div class="filter-item"><label
                                                for="scheduleResponsibility">Responsibility</label><select
                                                id="scheduleResponsibility" multiple></select></div>
                                        <div class="filter-item"><label for="cleaningChecklist">Cleaning
                                                Checklist</label><select id="cleaningChecklist" multiple></select></div>
                                        <div class="filter-item"><label for="pmChecklist">PM Checklist</label><select
                                                id="pmChecklist" multiple></select></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="resetFiltersBtn" class="btn btn-danger me-auto">Reset All
                                    Filters</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="applyFiltersBtn" class="btn btn-primary">Apply
                                    Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                


<!-- Filter Equipment Modal -->
<!-- Filter Equipment Modal -->


<form action="" method="GET">
  <div class="modal fade" id="filterModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-filter"></i> Filter Equipment List</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
@php 

	$is_role = Auth::user()->is_role;
	
	@endphp
        <div class="modal-body">


<?php $unit_list = DB::table('users')->where('is_role', "2")->get(); 
?>


          <!-- Location Filters -->
            <h3 class="filter-group-header" style="color: #005a9c;
    border-bottom: 2px solid var(--filter-primary-light);
    /* padding-bottom: 0.75rem; */
    /* margin-bottom: 1.5rem; */
    font-size: 1.25em;
    font-weight
Specifies weight of glyphs in the font, their degree of blackness or stroke thickness.
Learn more

Don't show
: 600;">Location Filters</h3>
          <div class="row mb-3">
              
                @if($is_role==0)
            <div class="col-md-4">
              <label class="form-label">Corporate</label>
              <select class="form-control slim-select" name="Corporate[]" id="selectcorporate1" multiple>
                @foreach($unit_list as $unit_lists)
<option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>

@endforeach
              </select>
            </div>
            
            @endif


@if($is_role == 0 || $is_role == 2)
            <div class="col-md-4">
              <label class="form-label">Regional</label>
       <select class="form-control slim-select regional_id1"  id="regional_id1" name="regional_id[]" multiple>
    <?php $unit_list = DB::table('users')->where('is_role', "1")->where('created_by',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach</select>
            </div>
            
               @endif


@if($is_role != 3)


            <div class="col-md-4">
              <label class="form-label">Unit</label>
              <select class="form-control slim-select hotel_name" name="unit_id[]" id="unitSelect" multiple>
              							     <?php $unit_list = DB::table('users')->where('is_role', "3")->where('created_by1',Auth::user()->id)->get(); ?>
            @foreach($unit_list as $unit_lists)
            <option value="{{$unit_lists->id}}">{{$unit_lists->company_name}}</option>
            
            @endforeach
              </select>
            </div>
            
            @endif
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <label class="form-label">Department</label>
              
            
              <select class="form-control slim-select mydepartment" name="department[]" id="departmentSelect" multiple>
                @foreach($departments as $dept)
                  <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
              </select>
            </div>
            
            
            

            <div class="col-md-6">
              <label class="form-label" >Location</label>
              
                      <select class="form-control slim-select" name="location_id[]" id="subDepartmentSelect" multiple>
                <!-- Dynamically populated -->
              </select>
        
            </div>
          </div>

          <!-- Asset & Status Filters -->
          <h6 class="fw-bold mb-3" style="color: #005a9c;
    border-bottom: 2px solid var(--filter-primary-light);
    /* padding-bottom: 0.75rem; */
    /* margin-bottom: 1.5rem; */
    font-size: 1.25em;
    font-weight
Specifies weight of glyphs in the font, their degree of blackness or stroke thickness.
Learn more

Don't show
: 600;">Asset & Status Filters</h6>
          <div class="row mb-4">
            <div class="col-md-4">
              <label class="form-label">Equipment</label>
              <select class="form-control slim-select" name="equipment_id[]" id="selectEquipment" multiple>
                @foreach($facility_equipment_filter as $equipment)
                  <option value="{{ $equipment->id }}">{{ $equipment->name ?? '' }}</option>
                @endforeach
              </select>
            </div>
            
               <div class="col-md-4">
              <label class="form-label">Equipment Status</label>
              <select class="form-control slim-select" name="equipment_status[]" id="monitoringParameter1" multiple>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
            
    

            <div class="col-md-4">
              <label class="form-label">Monitoring Parameter</label>
              <select class="form-control slim-select" name="monitoring_parameter[]" id="monitoringParameter" multiple>
                <option value="temp">Temperature</option>
                <option value="pressure">Pressure</option>
              </select>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-4">
              <label class="form-label">Calibration Required?</label>
              <select class="form-control slim-select" name="calibrationRequired[]" id="calibrationRequired" multiple>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
          </div>

          <!-- Schedule & Compliance Filters -->
          <h6 class="fw-bold mb-3" style="color: #005a9c;
    border-bottom: 2px solid var(--filter-primary-light);
    /* padding-bottom: 0.75rem; */
    /* margin-bottom: 1.5rem; */
    font-size: 1.25em;
    font-weight
Specifies weight of glyphs in the font, their degree of blackness or stroke thickness.
Learn more

Don't show
: 600;">Schedule & Compliance Filters</h6>
          <div class="row mb-4">
              
                   <div class="col-md-4">
              <label class="form-label">Cleaning Frequency</label>
              <select class="form-control slim-select" name="cleaningFrequency[]" id="monitoringParameter22" multiple>
                      @php
                  $cleaningFrequencies = DB::table('templates')->select('cleaning_frequency')->whereNotNull('cleaning_frequency')->groupBy('cleaning_frequency')->get();
                @endphp
                @foreach($cleaningFrequencies as $cf)
                  <option value="{{ strtolower($cf->cleaning_frequency) }}">{{ $cf->cleaning_frequency }}</option>
                @endforeach
              </select>
            </div>
            
            
                      <div class="col-md-4">
              <label class="form-label">PM Frequency</label>
              <select class="form-control slim-select" name="pmFrequency[]" id="monitoringParameter33" multiple>
                  @php
                  $pmFrequencies = DB::table('templates')->select('pm_frequency')->whereNotNull('pm_frequency')->groupBy('pm_frequency')->get();
                @endphp
                @foreach($pmFrequencies as $pf)
                  <option value="{{ strtolower($pf->pm_frequency) }}">{{ $pf->pm_frequency }}</option>
                @endforeach
              </select>
              </select>
            </div>

            
            
            <div class="col-md-4">
              <label class="form-label">Responsibility</label>
              <select class="form-control slim-select" name="responsibility_id[]" id="responsibility" multiple>
                @foreach($authority as $res)
                  <option value="{{ $res->name }}">{{ $res->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          
       
          
          
          

          <div class="row mb-4">
                 <div class="row mb-4">
            <div class="col-md-4">
              <label class="form-label">Cleaning Checklist</label>
              <select class="form-control slim-select" name="cleaningChecklist[]" id="calibrationRequired1" multiple>
                         <option value="yes">Checklist Attached</option>
                <option value="no">Checklist Not Attached</option>
              </select>
            </div>
            
                   <div class="col-md-4">
              <label class="form-label">Cleaning Checklist</label>
              <select class="form-control slim-select" name="pmChecklist[]" id="calibrationRequired22" multiple>
                           <option value="yes">Checklist Attached</option>
                <option value="no">Checklist Not Attached</option>
              </select>
            </div>
          </div>
          
          
          
       
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="resetFilters"><a href="https://efsm.safefoodmitra.com/admin/public/index.php/Facility-Hygiene-new">Reset All Filters</a></button>
          <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
      </div>
    </div>
  </div>
</form>




                <div class="modal fade" id="activationCommentModal" tabindex="-1"
                    aria-labelledby="activationCommentModalLabel" aria-hidden="true" data-bs-backdrop="static"
                    data-bs-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="activationCommentModalLabel">Activation Comments</h5><button
                                    type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="activationCommentModalCloseBtn"></button>
                            </div>
                            <div class="modal-body">
                                <form id="activationCommentForm"><input type="hidden"
                                        id="commentModalEquipmentId"><input type="hidden"
                                        id="commentModalOriginalState">
                                    <div class="mb-3"><label for="activationCommentText" class="form-label">Reason for
                                            <strong id="commentModalActionText">change</strong>:</label><textarea
                                            class="form-control" id="activationCommentTextarea" rows="3"
                                            required></textarea>
                                        <div class="invalid-feedback">Please provide a reason.</div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal" id="cancelActivationChangeBtn">Cancel</button><button
                                    type="button" class="btn btn-primary" id="saveActivationCommentBtn">Save
                                    Comment</button></div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="addEquipmentModalLabel"><i
                                        class="fa-solid fa-plus-circle"></i> Add New Equipment</h1><button type="button"
                                    class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                                                 <form id="addEquipmentForm" >
</form>
                                
                                 <form id="addEquipmentForm"  method="post" action="{{route('facility_store')}}" enctype="multipart/form-data">
                                     @csrf
                                     
                                      @php 
$regionalIds = DB::table('users')->where('id', Auth::id())->pluck('created_by1')->toArray();
$corporateIds = DB::table('users')->whereIn('id', $regionalIds)->pluck('created_by')->toArray();

    $categories = DB::table('fhm_category')->whereIn('created_by',$corporateIds)->get();
 
 @endphp
                                    <div class="form-row">
                                        <div class="form-group"><label for="equipmentName" class="required"><i
                                                    class="fa-solid fa-tag"></i>Equipment Name:</label>
                                            <div class="input-wrapper"><i class="fa-solid fa-font"></i><input
                                                    type="text" id="equipmentName" name="name"
                                                    placeholder="e.g. Autoclave" required></div>
                                        </div>
                                        
                                    <input type="hidden" name="oldequipmentId" id="oldequipmentId">
                                        
                                        
                                        
                                        <div class="form-group"><label for="equipmentId" class="required"><i
                                                    class="fa-solid fa-barcode"></i>Equipment ID:</label>
                                            <div class="input-wrapper"><i class="fa-solid fa-hashtag"></i><input
                                                    type="text" id="equipmentId" name="equipment_id"
                                                    placeholder="e.g. QA/AC/001" required></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group"><label for="makeBrandName"><i
                                                    class="fa-solid fa-industry"></i>Make/Brand Name:</label>
                                            <div class="input-wrapper"><i class="fa-solid fa-copyright"></i><input
                                                    type="text" id="makeBrandName" name="brand"
                                                    placeholder="Enter make or brand"></div>
                                        </div>
                                        <div class="form-group"><label for="modalNumber"><i
                                            class="fa-solid fa-cubes-stacked"></i>Model Number:</label>
                                            <div class="input-wrapper"><i class="fa-solid fa-barcode-read"></i><input
                                                    type="text" id="modalNumber" name="modal_number"
                                                    placeholder="Enter model number"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                         <div class="form-group"><label for="srNumber"><i
                                            class="fa-solid fa-fingerprint"></i>Serial Number:</label>
                                            <div class="input-wrapper"><i class="fa-solid fa-hashtag"></i><input
                                                    type="text" id="srNumber" name="srNumber"
                                                    placeholder="Enter serial number"></div>
                                        </div>
                                        <div class="form-group"><label for="selectDepartment" class="required"><i
                                                    class="fa-solid fa-building"></i>Select Department:</label>
                                            <div class="input-wrapper"><i class="fa-solid fa-users-gear"></i><select
                                                    id="mydepartment" class="mydepartment" name="selectDepartment"  required>
                                                    <option value="">Please Select Department</option>
                                                   		   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->id}}">{{$departmentss->name}}({{Helper::userInfoShortName($departmentss->unit_id ?? '')}})</option>
										 
										 @endforeach
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-full-width" style="margin-bottom: 1.75rem;"><label
                                            for="selectLocation" class="required"><i
                                                class="fa-solid fa-map-marker-alt"></i>Select Location:</label>
                                        <div class="input-wrapper"><i class="fa-solid fa-location-dot"></i><select
                                                name="location_id" id="mydepartment1" class="mydepartment1">
                                               
                                            </select></div>
                                    </div>
                                   
                                    
                                   <div class="form-row">
                                         <div class="form-group">
                                             <label class="form-label">DAY</label>
                           <select name="c_frequency" id="c_frequency" class="form-control">
    <option value="">Please Select DAY</option>
    <option value="Sunday">Sunday</option>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
</select>
                                        </div>
                                        <div class="form-group"><label class="form-label">Frequency In Month</label>
                            
                                <select class="form-select" aria-label="Default select example" id="p_frequency" name="p_frequency" >
        <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select>
                                        </div>
                                    </div>
                                
                               
                            </div>
                            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal"><i class="fa-solid fa-times"></i> Cancel</button>
                                    
                                    <button
                                    type="submit"  class="footer-button submit-button"><i
                                        class="fa-solid fa-check"></i> Submit</button></div>
                                        
                                        </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="viewTemplateModal" tabindex="-1" aria-labelledby="viewTemplateModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewTemplateModalLabel">View Checklist Template</h5><button
                                    type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h3 id="viewTemplateName" class="mb-4"></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="detail-group"><span class="detail-label">Cleaning Schedule</span>
                                            <p class="detail-value mb-1">By: <span id="viewCleaningResp"></span></p>
                                            <p class="detail-value mb-0">Freq: <span id="viewCleaningFreq"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-group"><span class="detail-label">Preventive
                                                Maintenance</span>
                                            <p class="detail-value mb-1">By: <span id="viewPmResp"></span></p>
                                            <p class="detail-value mb-0">Freq: <span id="viewPmFreq"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3"><span class="detail-label">Associated Equipment</span>
                                    <ul id="viewTemplateEquipmentList"></ul>
                                </div>
                            </div>
                            <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button></div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="checklist-panel" role="tabpanel" aria-labelledby="checklist-tab" hidden>
                <!-- All checklist-panel HTML goes here -->
                <div class="checklist-container">
                    <div class="top-bar">
                        <h1>Checklists</h1><button class="add-new-btn"> <a href="{{route('templates_store')}}" >Add New Checklist</a></button>
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th><span class="sortable-header">#</span></th>
                                    <th>Image</th>
                                    <th><span class="sortable-header">Name</span></th>
                                    <th>Equipment Count</th>
                                    <th><span class="sortable-header">Cleaning Responsibility</span></th>
                                    <th><span class="sortable-header">Cleaning Frequency</span></th>
                                    <th><span class="sortable-header">PM Responsibility</span></th>
                                    <th><span class="sortable-header">PM Frequency</span></th>
                                    <th><span class="sortable-header">Created Date</span></th>
                                    <th><span class="sortable-header">Modified Date</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="checklist-table-body">
                                
                               @foreach($list as $lists)
    @php
        // पहले से linked equipments की IDs निकाल लो
        $facility_equipmentslist = DB::table('template_equpiments')
            ->where('template_id', $lists->id ?? '')
            ->pluck('equpiments')
            ->toArray();
    @endphp

    <tr id="checklist-row-{{$lists->id ?? ''}}">
        <td class="row-number">1</td>
        <td>Image</td>
        <td class="editable-name"><span>{{$lists->template_name ?? ''}}</span></td>
        <td class="equipment-count-cell">
            <div class="multi-select-container">
                <div class="multi-select-display" tabindex="0" role="button"
                    aria-haspopup="listbox" aria-expanded="false">
                    <span class="equipment-count" id="equip-count-{{$lists->id}}">
                        {{ count($facility_equipmentslist) }} Equipments
                    </span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5H7z"></path>
                    </svg>
                </div>
                <div class="multi-select-dropdown hidden" role="listbox">
                    <input type="text" class="multi-select-search" placeholder="Search equipment...">
                    <ul class="multi-select-list1">
                        @foreach($facility_equipment_filter as $facility_equipmentslists)
                            <li>
                                <input 
                                    type="checkbox" 
                                    class="equipment-checkbox" 
                                    name="equipment" 
                                    data-checklist_id="{{ $lists->id ?? '' }}" 
                                    value="{{ $facility_equipmentslists->equipment_id ?? '' }}"
                                    {{ in_array($facility_equipmentslists->id, $facility_equipmentslist) ? 'checked' : '' }}
                                >
                                {{ $facility_equipmentslists->name ?? '' }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </td>
        <td class="cleaning-responsibility-cell editable-cell"><span>Production</span></td>
        <td class="cleaning-frequency-cell">
            <input type="number" class="numeric-input" value="14" min="1"> days
        </td>
        <td class="pm-responsibility-cell editable-cell"><span>Maintenance</span></td>
        <td class="pm-frequency-cell">
            <input type="number" class="numeric-input" value="3" min="1" max="12"> months
        </td>
        <td>2025-03-27<br>19:58:40</td>
        <td></td>
        <td class="action-cell">
            <button class="action-btn" aria-label="Actions">
                <svg width="20" height="20" viewBox="0 0 24 24">
                    <path
                        d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"
                        transform="rotate(90 12 12)">
                    </path>
                </svg>
            </button>
            <div class="action-menu hidden">
                <ul>
                    <li><a href="{{route('templates_update',$lists->id ?? '')}}">Edit template</a></li>
                    <li><a href="{{route('template_details',$lists->id ?? '')}}">View template</a></li>
                    <li class="duplicate-template">Duplicate template</li>
                    <li class="delete-template">Delete template</li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-footer"></div>
                </div>
            </section>
            <section id="calibration-panel" role="tabpanel" aria-labelledby="calibration-tab" hidden>
                <h2>Calibration List</h2>
                <p>The Calibration List content will appear here.</p>
            </section>
            <section id="cleaning-panel" role="tabpanel" aria-labelledby="cleaning-tab" hidden>
                <h2>Facility Cleaning</h2>
                <p>Facility Cleaning schedules and records will appear here.</p>
            </section>
            <section id="maintenance-panel" role="tabpanel" aria-labelledby="maintenance-tab" hidden>
                <h2>Facility Maintenance</h2>
                <p>Facility Maintenance records and schedules will appear here.</p>
            </section>
            <section id="breakdown-panel" role="tabpanel" aria-labelledby="breakdown-tab" hidden>
                <h2>Breakdown Management</h2>
                <p>Breakdown logs and management tools will appear here.</p>
            </section>
            <section id="pest-panel" role="tabpanel" aria-labelledby="pest-tab" hidden>
                <h2>Pest Management</h2>
                <p>Pest Management information and logs will appear here.</p>
            </section>
        </div>
    </div>

@endsection


@section('footerscript')

    <script>
        // --- GLOBAL FUNCTIONS & SHARED STATE ---
        let masterEquipmentSource = [];
        let tableRows = []; // Holds the master list TR elements
        let equipmentTabInitialized = false;
        let checklistTabInitialized = false;

        const downloadSampleCsv = (event) => {
            event.preventDefault();
            const headers = "equipmentId,equipmentName,makeBrandName,modalNumber,srNumber,selectDepartment,selectLocation";
            const sampleData = "EQ-BULK-001,New High-Speed Mixer,BrandX,HSM-2024,SN-HSM-1001,Production,Main Plant Floor\nEQ-BULK-002,Precision Scale 5,BrandY,PS-5,SN-PS-2045,Quality Assurance,Lab 3 (Analytics)";
            const csvContent = `${headers}\n${sampleData}`;
            
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            if (link.download !== undefined) { 
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", "equipment_upload_sample.csv");
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        };

        window.showChecklistTemplateModal = (checklistId) => {
            const checklistRow = document.getElementById(checklistId);
            if (!checklistRow) {
                console.error("Could not find checklist row:", checklistId);
                alert("Error: Could not find the source checklist template.");
                return;
            }

            const name = checklistRow.querySelector('.editable-name span')?.textContent.trim() || 'N/A';
            const cleaningResp = checklistRow.querySelector('.cleaning-responsibility-cell span')?.textContent.trim() || 'N/A';
            const cleaningFreqNum = checklistRow.querySelector('.cleaning-frequency-cell .numeric-input')?.value || '?';
            const cleaningFreqUnit = checklistRow.querySelector('.cleaning-frequency-cell')?.textContent.trim().split(' ').pop() || 'days';
            const pmResp = checklistRow.querySelector('.pm-responsibility-cell span')?.textContent.trim() || 'N/A';
            const pmFreqNum = checklistRow.querySelector('.pm-frequency-cell .numeric-input')?.value || '?';
            const pmFreqUnit = checklistRow.querySelector('.pm-frequency-cell')?.textContent.trim().split(' ').pop() || 'months';

            document.getElementById('viewTemplateName').textContent = name;
            document.getElementById('viewCleaningResp').textContent = cleaningResp;
            document.getElementById('viewCleaningFreq').textContent = `${cleaningFreqNum} ${cleaningFreqUnit}`;
            document.getElementById('viewPmResp').textContent = pmResp;
            document.getElementById('viewPmFreq').textContent = `${pmFreqNum} ${pmFreqUnit}`;

            const equipmentListContainer = document.getElementById('viewTemplateEquipmentList');
            const equipmentItems = Array.from(checklistRow.querySelectorAll('.multi-select-list li'));

            if (equipmentItems.length > 0) {
                equipmentListContainer.innerHTML = equipmentItems.map(item => {
                    const label = item.querySelector('label');
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    const isChecked = checkbox.checked;
                    const iconClass = isChecked ? 'fas fa-check-square' : 'far fa-square';
                    const liClass = isChecked ? 'is-selected' : '';
                    return `<li class="${liClass}"><i class="${iconClass}"></i> ${label.textContent.trim()}</li>`;
                }).join('');
            } else {
                equipmentListContainer.innerHTML = '<li>No equipment available in this template.</li>';
            }
            const templateModal = new bootstrap.Modal(document.getElementById('viewTemplateModal'));
            templateModal.show();
        };

        // window.linkEquipmentToChecklist = (selectElement, equipmentId) => {
        //     const checklistId = selectElement.value;
        //     if (!checklistId) return;

        //     const targetCheckbox = document.querySelector(`#${checklistId} .multi-select-list input[value="${equipmentId}"]`);
        //     if (targetCheckbox) {
        //         targetCheckbox.checked = true;
        //         // Dispatching the change event is crucial as it triggers the chain of updates.
        //         const changeEvent = new Event('change', { bubbles: true });
        //         targetCheckbox.dispatchEvent(changeEvent);

        //         const toast = document.getElementById('toastNotification');
        //         toast.textContent = `Linked ${equipmentId} to checklist.`;
        //         toast.className = 'toast-notification show';
        //         setTimeout(() => toast.classList.remove('show'), 3000);
        //     } else {
        //         console.error(`Could not find checkbox for equipment ${equipmentId} in checklist ${checklistId}`);
        //     }
        // };
        
        
        window.linkEquipmentToChecklist = (selectElement, equipmentId) => {
    const checklistId = selectElement.value;
    if (!checklistId) return;

    const targetCheckbox = document.querySelector(
        `#${checklistId} .multi-select-list input[value="${equipmentId}"]`
    );
    
    
    
    $.ajax({
            url: "{{ route('AddChecklistNew') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                equipment_id: equipmentId,
                checklist_id: checklistId,   // ЁЯСИ рдЕрдЧрд░ backend рдХреЛ checklist_id рднреА рдЪрд╛рд╣рд┐рдП
                calibration_status: "linked" // ЁЯСИ status рдХрд╛ рдирд╛рдо рдЕрдкрдиреА рдЬрд░реВрд░рдд рдХреЗ рд╣рд┐рд╕рд╛рдм рд╕реЗ рд░рдЦреЛ
            },
            success: function (response) {
                console.log("Calibration status updated:", response);

                // Toast show
                const toast = document.getElementById('toastNotification');
                toast.textContent = `Linked ${equipmentId} to checklist.`;
                toast.className = 'toast-notification show';
                setTimeout(() => toast.classList.remove('show'), 3000);
            },
            error: function (xhr) {
                console.error("Error updating calibration status:", xhr.responseText);
            }
        });

    if (targetCheckbox) {
        targetCheckbox.checked = true;
        // Trigger change event
        const changeEvent = new Event('change', { bubbles: true });
        targetCheckbox.dispatchEvent(changeEvent);

        // AJAX call to update calibration status
        

    } else {
        console.error(
            `Could not find checkbox for equipment ${equipmentId} in checklist ${checklistId}`
        );
    }
};


        document.addEventListener('DOMContentLoaded', () => {

            // --- Tabbing System ---
            const tabs = document.querySelectorAll('.tab-navigation button[role="tab"]');
            const tabPanels = document.querySelectorAll('.tab-content section[role="tabpanel"]');
            const tabNav = document.querySelector('.tab-navigation');

            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    const clickedTab = e.currentTarget;
                    tabs.forEach(t => t.setAttribute('aria-selected', 'false'));
                    tabPanels.forEach(panel => panel.setAttribute('hidden', true));
                    clickedTab.setAttribute('aria-selected', 'true');
                    const controlledPanel = document.getElementById(clickedTab.getAttribute('aria-controls'));
                    if (controlledPanel) controlledPanel.removeAttribute('hidden');

                    if (clickedTab.id === 'equipment-tab' && !equipmentTabInitialized) {
                        initializeEquipmentDashboard();
                        equipmentTabInitialized = true;
                        updateMasterListSchedules();
                    }
                    if (clickedTab.id === 'checklist-tab') {
                        if (!checklistTabInitialized) {
                            initializeChecklist();
                            checklistTabInitialized = true;
                        } else {
                            refreshAllChecklistEquipmentDropdowns();
                        }
                    }
                });
            });

            function updateScrollIndicators() {
                if (!tabNav) return;
                const scrollLeft = Math.round(tabNav.scrollLeft);
                const scrollWidth = tabNav.scrollWidth;
                const clientWidth = tabNav.clientWidth;
                const scrollEnd = Math.round(scrollWidth - clientWidth);
                tabNav.classList.toggle('show-scroll-indicator-left', scrollLeft > 0);
                tabNav.classList.toggle('show-scroll-indicator-right', scrollLeft < scrollEnd - 1);
            }

            if (tabNav) {
                updateScrollIndicators();
                tabNav.addEventListener('scroll', updateScrollIndicators, { passive: true });
            }
            window.addEventListener('resize', updateScrollIndicators);

            function loadInitialData() {
                const initialData = [
                    
                    <?php foreach ($facility_equipment as $facility_equipments): ?>
                    
                    { id: '{{$facility_equipments->equipment_id}}', name: '{{$facility_equipments->name ?? ''}}', modalNumber: '{{$facility_equipments->modal_number}}', srNumber: '{{$facility_equipments->srNumber}}' },
                   <?php endforeach; ?>
                ];
                masterEquipmentSource = initialData;
            }
            loadInitialData();

            // --- LINKING LOGIC BETWEEN TABS ---
            function getScheduleForEquipment(equipmentId) {
                const checklistBody = document.getElementById('checklist-table-body');
                if (!checklistBody) return null;

                for (const row of checklistBody.rows) {
                    const checkbox = row.querySelector(`.multi-select-list input[value="${equipmentId}"]`);
                    if (checkbox && checkbox.checked) {
                        const checklistId = row.id;
                        const checklistName = row.querySelector('.editable-name span')?.textContent.trim() || 'Untitled Checklist';
                        const cleaningResp = row.querySelector('.cleaning-responsibility-cell span')?.textContent.trim() || 'N/A';
                        const cleaningFreqNum = row.querySelector('.cleaning-frequency-cell .numeric-input')?.value || '?';
                        const cleaningFreqUnit = row.querySelector('.cleaning-frequency-cell')?.textContent.trim().split(' ').pop() || 'days';
                        const pmResp = row.querySelector('.pm-responsibility-cell span')?.textContent.trim() || 'N/A';
                        const pmFreqNum = row.querySelector('.pm-frequency-cell .numeric-input')?.value || '?';
                        const pmFreqUnit = row.querySelector('.pm-frequency-cell')?.textContent.trim().split(' ').pop() || 'months';

                        return {
                            checklistId,
                            checklistName,
                            cleaning: { resp: cleaningResp, freq: `${cleaningFreqNum} ${cleaningFreqUnit}` },
                            pm: { resp: pmResp, freq: `${pmFreqNum} ${pmFreqUnit}` }
                        };
                    }
                }
                return null;
            }

            function getAvailableChecklists() {
                const checklistRows = document.querySelectorAll('#checklist-table-body tr');
                
                
               // console.log(checklistRows);
                return Array.from(checklistRows).map(row => ({
                    id: row.id,
                    name: row.querySelector('.editable-name span')?.textContent.trim() || 'Untitled'
                }));
            }

//             function generateScheduleHtml(linkInfo, equipmentId, type,c_frequency,p_frequency,template_ids) {
                
       
//                 const scheduleDetails = linkInfo ? linkInfo[type] : null;

//                 if (linkInfo && scheduleDetails) {
//                     const borderColor = type === 'cleaning' ? 'var(--primary-color)' : 'var(--info-color)';
//                     let dropdownHtml = '';
//                     if (type === 'cleaning') {
//                         dropdownHtml = `<select class="form-select form-select-sm" aria-label="Cleaning Day Search"><option selected>Search by Day</option><option value="Sunday">Sunday</option><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option></select>`;
//                     } else if (type === 'pm') {
//                         dropdownHtml = `<select class="form-select form-select-sm" aria-label="PM Month Search"><option selected>Search by Month</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option></select>`;
//                     }

//                     return `<div class="schedule-card" style="border-left: 3px solid ${borderColor};">
//                                 <div class="d-flex justify-content-between align-items-center mb-2">
//                                     <h6 class="mb-0 small text-truncate" style="font-weight: 600; max-width: 120px;" title="Linked to: ${linkInfo.checklistName}">
//                                         Linked: ${linkInfo.checklistName}
//                                     </h6>
//                                     <div class="btn-group btn-group-sm" role="group">
//                                         <button class="btn btn-outline-secondary" style="padding: .1rem .4rem;" title="View Checklist Template" onclick="showChecklistTemplateModal('${linkInfo.checklistId}')">
//                                             <i class="fas fa-eye"></i>
//                                         </button>
//                                         <button class="btn btn-outline-danger btn-remove-schedule" style="padding: .1rem .5rem;" title="Unlink Schedule" data-equipment-id="${equipmentId}" data-schedule-type="${type}">
//                                             <i class="fas fa-times"></i>
//                                         </button>
//                                     </div>
//                                 </div>
//                                 <div class="card-data-row">
//                                     <span class="data-point"><span class="schedule-label">By:</span><span class="schedule-value">${scheduleDetails.resp}</span></span>
//                                     <span class="data-point"><span class="schedule-label">Freq:</span><span class="schedule-value">${scheduleDetails.freq}</span></span>
//                                 </div>
//                                 <div class="mt-2">${dropdownHtml}</div>
//                             </div>`;
//                 }

//                 const availableChecklists = getAvailableChecklists();
//               // const optionsHtml = availableChecklists.map(cl => `<option value="${cl.id}">${cl.name}</option>`).join('');
                
                
                
//                 const optionsHtml = availableChecklists.map(cl => {
//     // id = "checklist-row-12" → सिर्फ 12 निकालना है
//     const numericId = cl.id.replace("checklist-row-", ""); 
    
//     // अगर template_ids में numericId है तो selected करो
//     const isSelected = template_ids.includes(parseInt(numericId));

//     return `<option value="${cl.id}" ${isSelected ? 'selected' : ''}>${cl.name}</option>`;
// }).join('');


                

//                 const months = [
//   "January", "February", "March", "April", "May", "June",
//   "July", "August", "September", "October", "November", "December"
// ];

// // Convert p_frequency to month name (make sure it's a valid 1-12)
// const monthName = months[(p_frequency - 1)] || "";

// // Check if c_frequency is "cleaning"
// const isCleaning = (type || "").toLowerCase() === "cleaning";

// // Decide what to display
// const scheduleInfo = isCleaning
//   ? `<p>DAY: ${c_frequency ?? '-'}</p>`
//   : `<p>MONTH: ${monthName ?? '-'}</p>`;
  

// return `<div class="schedule-card" style="padding: 0.5rem; border-left: 3px solid #ccc;">
//             <div class="text-muted small" style="font-weight: 500;">No schedule assigned</div>
//             <div class="mt-2">
//                 <select class="form-select form-select-sm" onchange="linkEquipmentToChecklist(this, '${equipmentId}')">
//                     <option value="" selected disabled>Link to a checklist...</option>
//                     ${optionsHtml}
//                 </select>

//                 ${scheduleInfo}
//             </div>
//         </div>`;
//             }


// function generateScheduleHtml(linkInfo, equipmentId, type, c_frequency, p_frequency, template_ids) {
//     const scheduleDetails = linkInfo ? linkInfo[type] : null;

//     const availableChecklists = getAvailableChecklists();
//     const selectedChecklist = availableChecklists.find(cl => {
//         const numericId = cl.id.replace("checklist-row-", "");
//         return template_ids.includes(parseInt(numericId));
//     });

//     if (selectedChecklist) {
//         const borderColor = "var(--info-color)";
//         let freqValue = "-";
//         let dropdownHtml = "";

//         if (c_frequency) {
//             const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
//             dropdownHtml = `<select class="form-select form-select-sm" 
//                                 onchange="updateScheduleFrequency('${equipmentId}', this.value, 'day')">
//                                 ${days.map(day => `<option value="${day}" ${c_frequency === day ? 'selected' : ''}>${day}</option>`).join('')}
//                             </select>`;
//             freqValue = c_frequency;
//         } else if (p_frequency) {
//             const months = [
//                 "January", "February", "March", "April", "May", "June",
//                 "July", "August", "September", "October", "November", "December"
//             ];
//             dropdownHtml = `<select class="form-select form-select-sm" 
//                                 onchange="updateScheduleFrequency('${equipmentId}', this.value, 'month')">
//                                 ${months.map((month, idx) => 
//                                     `<option value="${month}" ${p_frequency === (idx+1) ? 'selected' : ''}>${month}</option>`
//                                 ).join('')}
//                             </select>`;
//             freqValue = months[p_frequency - 1] || "-";
//         }

//         return `<div class="schedule-card" style="border-left: 3px solid ${borderColor};">
//                     <div class="d-flex justify-content-between align-items-center mb-2">
//                         <h6 class="mb-0 small text-truncate" style="font-weight: 600; max-width: 120px;" 
//                             title="Linked to: ${selectedChecklist.name}">
//                             Linked: ${selectedChecklist.name}
//                         </h6>
//                         <div class="btn-group btn-group-sm" role="group">
//                             <button class="btn btn-outline-secondary"
//                                 title="View Checklist Template" 
//                                 onclick="showChecklistTemplateModal('${selectedChecklist.id}')">
//                                 <i class="fas fa-eye"></i>
//                             </button>
//                             <button class="btn btn-outline-danger btn-remove-schedule" 
//                                 title="Unlink Schedule" 
//                                 data-equipment-id="${equipmentId}" data-schedule-type="${type}">
//                                 <i class="fas fa-times"></i>
//                             </button>
//                         </div>
//                     </div>
//                     <div class="card-data-row">
//                         <span class="data-point"><span class="schedule-label">By:</span><span class="schedule-value">-</span></span>
//                         <span class="data-point"><span class="schedule-label">Freq:</span><span class="schedule-value">${freqValue}</span></span>
//                     </div>
//                     <div class="mt-2">${dropdownHtml}</div>
//                 </div>`;
//     }

//     // Default fallback
//     const optionsHtml = availableChecklists.map(cl => {
//         const numericId = cl.id.replace("checklist-row-", "");
//         const isSelected = template_ids.includes(parseInt(numericId));
//         return `<option value="${cl.id}" ${isSelected ? 'selected' : ''}>${cl.name}</option>`;
//     }).join('');

//     return `<div class="schedule-card" style="padding: 0.5rem; border-left: 3px solid #ccc;">
//                 <div class="text-muted small" style="font-weight: 500;">No schedule assigned</div>
//                 <div class="mt-2">
//                     <select class="form-select form-select-sm" onchange="linkEquipmentToChecklist(this, '${equipmentId}')">
//                         <option value="" selected disabled>Link to a checklist...</option>
//                         ${optionsHtml}
//                     </select>
//                 </div>
//             </div>`;
// }



//             function updateMasterListSchedules() {
//                 if (!equipmentTabInitialized) return;
//                 tableRows.forEach(row => {
                    
//                   //console.log(row);
//                     const equipmentId = row.dataset.equipmentId;
//                     const c_frequency = row.dataset.c_frequency;
//                     const template_ids = row.dataset.template_ids;
                    
//                     //alert(c_frequency);
//                     const p_frequency = row.dataset.p_frequency;
//                     if (!equipmentId) return;
//                     const linkInfo = getScheduleForEquipment(equipmentId);

//                     // Add data attributes for filtering
//                     row.dataset.cleaningAttached = linkInfo ? 'attached' : 'not_attached';
//                     row.dataset.pmAttached = linkInfo ? 'attached' : 'not_attached';
//                     row.dataset.cleaningResp = linkInfo?.cleaning?.resp || 'none';
//                     row.dataset.pmResp = linkInfo?.pm?.resp || 'none';


//                     const cleaningCell = row.querySelector('td[data-label="Cleaning Schedule"]');
//                     const pmCell = row.querySelector('td[data-label="Preventive Maintenance"]');
//                     if (cleaningCell) cleaningCell.innerHTML = generateScheduleHtml(linkInfo, equipmentId, 'cleaning',c_frequency,p_frequency,template_ids);
//                     if (pmCell) pmCell.innerHTML = generateScheduleHtml(linkInfo, equipmentId, 'pm',c_frequency,p_frequency,template_ids);
//                 });
//             }


function generateScheduleHtml(linkInfo, equipmentId, type, c_frequency, p_frequency, template_ids) {
    const scheduleDetails = linkInfo ? linkInfo[type] : null;

    const availableChecklists = getAvailableChecklists();
    const selectedChecklist = availableChecklists.find(cl => {
        const numericId = cl.id.replace("checklist-row-", "");
        return template_ids.includes(parseInt(numericId));
    });

    if (selectedChecklist) {
        const borderColor = "var(--info-color)";
        let contentRows = "";



        // ✅ Cleaning frequency (only if value exists)
// ✅ Cleaning frequency (days)
if (c_frequency && type === "cleaning") {
    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

    const dropdownHtml = `<select class="form-select form-select-sm" 
                            onchange="updateScheduleFrequency('${equipmentId}', this.value, 'day')">
                            <option value="">Select Day</option>
                            ${days.map(day => 
                                `<option value="${day}" ${c_frequency === day ? 'selected' : ''}>${day}</option>`
                            ).join('')}
                          </select>`;

    contentRows += `
        <div class="card-data-row">
            <span class="data-point"><span class="schedule-label">Cleaning Freq:</span>
            <span class="schedule-value">${c_frequency}</span></span>
        </div>
        <div class="mt-2">${dropdownHtml}</div>`;
}

// ✅ PM frequency (months)
if (p_frequency && type === "pm") {
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const dropdownHtml = `<select class="form-select form-select-sm" 
                            onchange="updateScheduleFrequency('${equipmentId}', this.value, 'month')">
                            <option value="">Select Month</option>
                            ${months.map((month, idx) => 
                                `<option value="${idx+1}" ${p_frequency == (idx+1) ? 'selected' : ''}>${month}</option>`
                            ).join('')}
                          </select>`;

    contentRows += `
        <div class="card-data-row">
            <span class="data-point"><span class="schedule-label">PM Freq:</span>
            <span class="schedule-value">${months[p_frequency - 1] || "-"}</span></span>
        </div>
        <div class="mt-2">${dropdownHtml}</div>`;
}


        // ✅ Agar dono khali ho → bas linked card dikhaye
        if (!c_frequency && !p_frequency) {
            contentRows = `<div class="text-muted small">No frequency assigned</div>`;
        }

        return `<div class="schedule-card" style="border-left: 3px solid ${borderColor};">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 small text-truncate" style="font-weight: 600; max-width: 120px;" 
                            title="Linked to: ${selectedChecklist.name}">
                            Linked: ${selectedChecklist.name}
                        </h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-secondary"
                                title="View Checklist Template" 
                                onclick="showChecklistTemplateModal('${selectedChecklist.id}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-remove-schedule" 
                                title="Unlink Schedule" 
                                data-equipment-id="${equipmentId}" data-schedule-type="${type}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    ${contentRows}
                </div>`;
    }

    // Default fallback (no checklist linked)
    const optionsHtml = availableChecklists.map(cl => {
        const numericId = cl.id.replace("checklist-row-", "");
        const isSelected = template_ids.includes(parseInt(numericId));
        return `<option value="${cl.id}" ${isSelected ? 'selected' : ''}>${cl.name}</option>`;
    }).join('');

    return `<div class="schedule-card" style="padding: 0.5rem; border-left: 3px solid #ccc;">
                <div class="text-muted small" style="font-weight: 500;">No schedule assigned</div>
                <div class="mt-2">
                    <select class="form-select form-select-sm" onchange="linkEquipmentToChecklist(this, '${equipmentId}')">
                        <option value="" selected disabled>Link to a checklist...</option>
                        ${optionsHtml}
                    </select>
                </div>
            </div>`;
}


function updateMasterListSchedules() {
    if (!equipmentTabInitialized) return;
    tableRows.forEach(row => {
        const equipmentId = row.dataset.equipmentId;
        const c_frequency = row.dataset.c_frequency;
        const p_frequency = row.dataset.p_frequency;
        const template_ids = row.dataset.template_ids;

        if (!equipmentId) return;
        const linkInfo = getScheduleForEquipment(equipmentId);

        // Add data attributes for filtering
        row.dataset.cleaningAttached = linkInfo ? 'attached' : 'not_attached';
        row.dataset.pmAttached = linkInfo ? 'attached' : 'not_attached';
        row.dataset.cleaningResp = linkInfo?.cleaning?.resp || 'none';
        row.dataset.pmResp = linkInfo?.pm?.resp || 'none';

        // ✅ Cleaning
        const cleaningCell = row.querySelector('td[data-label="Cleaning Schedule"]');
        if (cleaningCell) cleaningCell.innerHTML = generateScheduleHtml(linkInfo, equipmentId, 'cleaning', c_frequency, null, template_ids);

        // ✅ PM
        const pmCell = row.querySelector('td[data-label="Preventive Maintenance"]');
        if (pmCell) pmCell.innerHTML = generateScheduleHtml(linkInfo, equipmentId, 'pm', null, p_frequency, template_ids);
    });
}


            // --- Checklist Tab Main Function ---
            function getGloballyLinkedEquipmentIds() {
                const linkedIds = new Set();
                document.querySelectorAll('#checklist-table-body .multi-select-list input:checked').forEach(cb => {
                    linkedIds.add(cb.value);
                });
                return linkedIds;
            }

            function refreshAllChecklistEquipmentDropdowns() {
                const globallyLinkedIds = getGloballyLinkedEquipmentIds();
                const allChecklistRows = document.querySelectorAll('#checklist-table-body tr');

                allChecklistRows.forEach(row => {
                    const list = row.querySelector('.multi-select-list');
                    if (!list) return;

                    const locallyCheckedIds = new Set(
                        Array.from(row.querySelectorAll('.multi-select-list input:checked')).map(cb => cb.value)
                    );

                    list.innerHTML = masterEquipmentSource.map(eq => {
                        const isAvailable = !globallyLinkedIds.has(eq.id) || locallyCheckedIds.has(eq.id);
                        if (isAvailable) {
                            const isChecked = locallyCheckedIds.has(eq.id);
                            return `<li><label><input type="checkbox" name="equipment" value="${eq.id}" ${isChecked ? 'checked' : ''}> ${eq.name} (${eq.id})</label></li>`;
                        }
                        return '';
                    }).join('');
                });
            }

            function initializeChecklist() {
                const checklistPanel = document.getElementById('checklist-panel');
                if (!checklistPanel) return;
                const tableBody = checklistPanel.querySelector('#checklist-table-body');

                function updateEquipmentCount(container) {
                    const displaySpan = container.querySelector('.multi-select-display span');
                    const checkedCount = container.querySelectorAll('input[type="checkbox"]:checked').length;
                    displaySpan.textContent = `${checkedCount} Equipment${checkedCount !== 1 ? 's' : ''}`;
                }

                updateRowNumbers();

                const firstRowList = tableBody.querySelector('#checklist-row-1 .multi-select-list');
                if (firstRowList) {
                    firstRowList.innerHTML = masterEquipmentSource.map(eq => `<li><label><input type="checkbox" name="equipment" value="${eq.id}"> ${eq.name} (${eq.id})</label></li>`).join('');
                }
                refreshAllChecklistEquipmentDropdowns();
                updateEquipmentCount(tableBody.querySelector('#checklist-row-1 .multi-select-container'));


                checklistPanel.addEventListener('change', (event) => {
                    const checkbox = event.target.closest('.multi-select-list input[type="checkbox"]');
                    if (checkbox) {
                        updateEquipmentCount(checkbox.closest('.multi-select-container'));
                        refreshAllChecklistEquipmentDropdowns();
                        updateMasterListSchedules();
                    }
                });

                checklistPanel.addEventListener('click', (event) => {
                    const actionButton = event.target.closest('.action-btn');
                    const duplicateButton = event.target.closest('.duplicate-template');
                    const deleteButton = event.target.closest('.delete-template');
                    const display = event.target.closest('.multi-select-display');

                    if (actionButton) {
                        const menu = actionButton.nextElementSibling;
                        document.querySelectorAll('#checklist-panel .action-menu').forEach(m => { if (m !== menu) m.classList.add('hidden'); });
                        menu.classList.toggle('hidden');
                    }
                    if (duplicateButton) {
                        const rowToDuplicate = duplicateButton.closest('tr');
                        const newRow = rowToDuplicate.cloneNode(true);
                        newRow.querySelector('.action-menu').classList.add('hidden');
                        rowToDuplicate.after(newRow);
                        updateRowNumbers();

                        newRow.querySelectorAll('.multi-select-list input[type="checkbox"]').forEach(cb => { cb.checked = false; });

                        refreshAllChecklistEquipmentDropdowns();
                        updateEquipmentCount(newRow.querySelector('.multi-select-container'));
                        updateMasterListSchedules();
                    }
                    if (deleteButton) {
                        const rowToDelete = deleteButton.closest('tr');
                        if (confirm('Are you sure you want to delete this template?')) {
                            rowToDelete.remove();
                            updateRowNumbers();
                            refreshAllChecklistEquipmentDropdowns();
                            updateMasterListSchedules();
                        }
                    }
                    if (display) {
                        const dropdown = display.nextElementSibling;
                        dropdown.classList.toggle('hidden');
                        display.classList.toggle('open');
                        display.setAttribute('aria-expanded', !dropdown.classList.contains('hidden'));
                    }
                });

                checklistPanel.addEventListener('keyup', (event) => {
                    if (event.target.matches('.multi-select-search')) {
                        const searchInput = event.target;
                        const filter = searchInput.value.toLowerCase();
                        const list = searchInput.nextElementSibling;
                        list.querySelectorAll('li').forEach(item => {
                            const txtValue = item.textContent || item.innerText;
                            item.style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
                        });
                    }
                });

                function makeCellEditable(event) {
                    const cell = event.target.closest('.editable-cell, .editable-name');
                    if (!cell || cell.querySelector('input')) return;
                    const span = cell.querySelector('span');
                    const currentText = span.textContent.trim();
                    span.style.display = 'none';
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = currentText;
                    input.className = 'editable-input';
                    cell.appendChild(input);
                    input.focus();
                    input.select();

                    const saveOrRevert = () => {
                        span.textContent = input.value.trim() || currentText;
                        span.style.display = '';
                        updateMasterListSchedules();
                    };

                    input.addEventListener('blur', saveOrRevert);
                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') input.blur();
                        else if (e.key === 'Escape') {
                            input.value = currentText;
                            input.blur();
                        }
                    });
                }
                checklistPanel.addEventListener('dblclick', makeCellEditable);

                function updateRowNumbers() {
                    tableBody.querySelectorAll('tr').forEach((row, index) => {
                        const numberCell = row.querySelector('.row-number');
                        if (numberCell) numberCell.textContent = index + 1;
                        row.id = `checklist-row-${index + 1}`;
                    });
                }

                document.addEventListener('click', (event) => {
                    if (!event.target.closest('#checklist-panel .action-cell')) {
                        document.querySelectorAll('#checklist-panel .action-menu').forEach(menu => menu.classList.add('hidden'));
                    }
                    if (!event.target.closest('#checklist-panel .equipment-count-cell')) {
                        document.querySelectorAll('#checklist-panel .multi-select-dropdown').forEach(dropdown => {
                            const display = dropdown.previousElementSibling;
                            dropdown.classList.add('hidden');
                            display.classList.remove('open');
                            display.setAttribute('aria-expanded', 'false');
                        });
                    }
                });
            }

            // --- Equipment Dashboard Main Function ---
            function initializeEquipmentDashboard() {
                const dashboardRoot = document.getElementById('equipment-panel');
                if (!dashboardRoot) return;

                let equipmentActivationLogs = {};
                const showFullScreenChart = (equipmentId) => alert(`Showing full screen chart for ${equipmentId}`);
                const downloadQRCode = (el, equipmentId) => alert(`Generating QR code for ${equipmentId}...`);
                Object.assign(window, { showFullScreenChart, downloadQRCode });

                const tbody = dashboardRoot.querySelector('#equipmentTable tbody');
                const toastNotification = dashboardRoot.querySelector('#toastNotification');
                const refreshBtn = dashboardRoot.querySelector('#refreshMasterListBtn');
                let currentPage = 1;
                let itemsPerPage = 10;
                let filteredTableRows = [];
                const itemsPerPageSelect = dashboardRoot.querySelector('#itemsPerPageSelect');
                const paginationUl = dashboardRoot.querySelector('#paginationUl');
                const activationCommentModal = new bootstrap.Modal(dashboardRoot.querySelector('#activationCommentModal'));
                const commentModalEquipmentIdInput = dashboardRoot.querySelector('#commentModalEquipmentId');
                const commentModalOriginalStateInput = dashboardRoot.querySelector('#commentModalOriginalState');
                const activationCommentTextarea = dashboardRoot.querySelector('#activationCommentTextarea');
                const saveActivationCommentBtn = dashboardRoot.querySelector('#saveActivationCommentBtn');
                const cancelActivationChangeBtn = dashboardRoot.querySelector('#cancelActivationChangeBtn');
                const activationCommentModalCloseBtn = dashboardRoot.querySelector('#activationCommentModalCloseBtn');

                // Bulk upload & sample download elements
                const bulkUploadModalEl = document.getElementById('bulkUploadModal');
                const bulkUploadModal = new bootstrap.Modal(bulkUploadModalEl);
                const downloadSampleBtn = document.getElementById('downloadSampleCsvBtn');
                const downloadSampleInModalBtn = document.getElementById('downloadSampleCsvInModal');
                const processCsvBtn = document.getElementById('processCsvUploadBtn');
                const csvFileInput = document.getElementById('csvFileInput');
                const duplicateModalEl = document.getElementById('duplicateModal');
                const duplicateModal = new bootstrap.Modal(duplicateModalEl);
                const duplicateListBody = document.getElementById('duplicateList');
                const confirmPartialUploadBtn = document.getElementById('confirmPartialUploadBtn');
                const downloadReportBtn = document.getElementById('downloadReportBtn');


                downloadSampleBtn.addEventListener('click', downloadSampleCsv);
                downloadSampleInModalBtn.addEventListener('click', downloadSampleCsv);


                if (itemsPerPageSelect) {
                    itemsPerPage = parseInt(itemsPerPageSelect.value, 10);
                    itemsPerPageSelect.addEventListener('change', function () {
                        itemsPerPage = parseInt(this.value, 10);
                        currentPage = 1;
                        applyAllFilters();
                    });
                }

                // --- START: FILTER MODAL LOGIC (REFACTORED FOR REUSABILITY) ---
                const filterModal = new bootstrap.Modal(dashboardRoot.querySelector('#filterModal'));
                const slimSelects = {};
                
                var is_role = {{Auth::user()->is_role}};
 
                const cascadingConfig = [
                    { id: 'corporate', label: 'Corporate', child: 'regional', dataKey: 'regionals', filterKey: 'corporate' },
                    { id: 'regional', label: 'Regional', child: 'unit', dataKey: 'units', filterKey: 'regional' },
                    { id: 'unit', label: 'Unit', child: 'department', dataKey: 'departments', filterKey: 'unit' },
                    { id: 'department', label: 'Department', child: 'location', dataKey: 'departments', filterKey: 'department' },
                    { id: 'location', label: 'Location', child: null, dataKey: null, filterKey: 'location' }
                ];
                const independentFiltersConfig = [
                    { id: 'equipment', label: 'Equipment', dataKey: 'equipment', filterKey: 'equipmentId' },
                    { id: 'equipmentStatus', label: 'Equipment Status', dataKey: 'equipmentStatus', filterKey: 'status' },
                    { id: 'monitoring', label: 'Monitoring Parameter', dataKey: 'monitoring', filterKey: 'monitoring' },
                    { id: 'calibration', label: 'Calibration', dataKey: 'calibration', filterKey: 'calibration' },
                    { id: 'cleaningFrequency', label: 'Cleaning Frequency', dataKey: 'cleaningFrequency', filterKey: 'cleaningFreq' },
                    { id: 'pmFrequency', label: 'PM Frequency', dataKey: 'pmFrequency', filterKey: 'pmFreq' },
                    { id: 'scheduleResponsibility', label: 'Responsibility', dataKey: 'scheduleResponsibility', filterKey: 'responsibility' },
                    { id: 'cleaningChecklist', label: 'Cleaning Checklist', dataKey: 'checklistStatus', filterKey: 'cleaningAttached' },
                    { id: 'pmChecklist', label: 'PM Checklist', dataKey: 'checklistStatus', filterKey: 'pmAttached' },
                ];
                
                const allFilterConfigs = [...cascadingConfig, ...independentFiltersConfig];
                const clearAndDisableSlimSelect = (instance) => {
                    instance.setData([]);
                    instance.disable();
                };
                const coreResetFilters = () => {
                    cascadingConfig.forEach((config, index) => {
                        if (slimSelects[config.id]) {
                            if (index === 0) {
                                slimSelects[config.id].setSelected([]);
                            } else { 
                                clearAndDisableSlimSelect(slimSelects[config.id]); 
                            }
                        }
                    });
                    independentFiltersConfig.forEach(config => {
                        if (slimSelects[config.id]) {
                            slimSelects[config.id].setSelected([]);
                        }
                    });
                    applyAllFilters();
                };
                refreshBtn.addEventListener('click', () => {
                    const icon = refreshBtn.querySelector('i');
                    icon.classList.add('fa-spin');
                    showToast('Refreshing & resetting filters...', 'success');

                    setTimeout(() => {
                        coreResetFilters();
                        icon.classList.remove('fa-spin');
                        showToast('Master list has been refreshed.', 'success');
                    }, 750);
                });
                function initializeFilters() {
                    const filterData = {
            corporates: [
            @php
            $corporates = DB::table('users')->where('is_role', 2)->get();
            @endphp
            @foreach($corporates as $corp)
                { id: "corp{{$corp->id}}", name: "{{$corp->company_name}}" },
            @endforeach
            ],

    regionals: {
        @foreach($corporates as $corp)
            corp{{$corp->id}}: [
                @php
                    $regionals = DB::table('users')
                        ->where('is_role', 1)
                        ->where('created_by', $corp->id)
                        ->get();
                @endphp
                @foreach($regionals as $reg)
                    { id: "reg{{$reg->id}}", name: "{{$reg->company_name}}" },
                @endforeach
            ],
        @endforeach
    },
    units: {
        @foreach($corporates as $corp)
            @php
                $regionals = DB::table('users')
                    ->where('is_role', 1)
                    ->where('created_by', $corp->id)
                    ->get();
            @endphp
            @foreach($regionals as $reg)
                reg{{$reg->id}}: [
                    @php
                        $units = DB::table('users')
                            ->where('is_role', 3)
                            ->where('created_by1', $reg->id)
                            ->get();
                    @endphp
                    @foreach($units as $unit)
                        { id: "unit{{$unit->id}}", name: "{{$unit->company_name}}" },
                    @endforeach
                ],
            @endforeach
        @endforeach
    },

   departments: {
    @php
        $units = DB::table('users')->where('is_role', 3)->get();
    @endphp
    @foreach($units as $unit)
        "unit{{ $unit->id }}": [
            @php
                $unitCorporateList = DB::table('users')
                ->where('id', $unit->id)
                ->pluck('created_by')
                ->toArray();
                
                $unitRegionalList = DB::table('users')
                ->where('id', $unit->id)
                ->pluck('created_by1')
                ->toArray();
                $all_users = array_merge($unitCorporateList,$unitRegionalList, [$unit->id]); 
                $departments = DB::table('departments')->whereIn('unit_id', $all_users)->get();
                $responsibility = DB::table('authority')->whereIn('unit_id', $all_users)->get();
            @endphp
            @foreach($departments as $dept)
                { id: "dept{{ $dept->id }}", name: "{{ $dept->name }}" }@if(!$loop->last),@endif
            @endforeach
        ]@if(!$loop->last),@endif
    @endforeach
},

locations: {
    @php
        $departments = DB::table('departments')->get();
    @endphp

    @foreach($departments as $dept1)
        "dept{{ $dept1->id }}": [
            @php
                $locations = DB::table('locations')
                    ->where('department_id', $dept1->id)
                    ->select('id', 'name', 'department_id') // yaha dept_id bhi le lo
                    ->get();
            @endphp

            @foreach($locations as $loc)
                { 
                    id: "loc{{ $loc->id }}", 
                    name: "{{ $loc->name }} (Dept: {{ $loc->department_id }})" 
                }@if(!$loop->last),@endif
            @endforeach
        ]@if(!$loop->last),@endif
    @endforeach
},
                        equipment: masterEquipmentSource.map(eq => ({ id: eq.id, name: `${eq.name} (${eq.id})` })),
                        equipmentStatus: [{ id: 'active', name: 'Active' }, { id: 'inactive', name: 'Inactive' }],
                        monitoring: [{ id: 'temp', name: 'Temperature' }, { id: 'pressure', name: 'Pressure' }],
                        calibration: [{ id: 'yes', name: 'Yes' }, { id: 'no', name: 'No' }],
                        
                        
                        
                        
                                 cleaningFrequency: [
            @php
                $cleaningFrequencies = DB::table('templates')
        ->select('cleaning_frequency')
        ->whereNotNull('cleaning_frequency')
        ->groupBy('cleaning_frequency')
        ->get();
            @endphp
            @foreach($cleaningFrequencies as $cf)

                { id: "{{ strtolower($cf->cleaning_frequency) }}", name: "{{ $cf->cleaning_frequency }}" },
            @endforeach
            ],
            
            
                                         pmFrequency: [
            @php
                $cleaningFrequencies = DB::table('templates')
        ->select('pm_frequency')
        ->whereNotNull('pm_frequency')
        ->groupBy('pm_frequency')
        ->get();
            @endphp
            @foreach($cleaningFrequencies as $cf)

                { id: "{{ strtolower($cf->pm_frequency) }}", name: "{{ $cf->pm_frequency }}" },
            @endforeach
            ],


                   scheduleResponsibility: [
        @foreach($responsibility as $responsibilitys)
            { id: "{{$responsibilitys->name}}", name: "{{$responsibilitys->name}}" },
        @endforeach
    ],

                        checklistStatus: [{ id: 'attached', name: 'Checklist Attached' }, { id: 'not_attached', name: 'Checklist Not Attached' }]
                    };
                    
                    
   



                    const populateSlimSelect = (instance, dataItems = []) => {
                        const formattedData = dataItems.map(item => ({ text: item.name, value: item.id, selected: false }));
                        instance.setData(formattedData);
                        if (dataItems.length > 0) instance.enable();
                    };

                    const handleCascadingChange = (changedId) => {
                        const config = cascadingConfig.find(c => c.id === changedId);
                        if (!config || !config.child) return;
                        const currentIndex = cascadingConfig.findIndex(c => c.id === changedId);
                        for (let i = currentIndex + 1; i < cascadingConfig.length; i++) {
                            clearAndDisableSlimSelect(slimSelects[cascadingConfig[i].id]);
                        }
                        const selectedParentIds = slimSelects[config.id].getSelected();
                        const childConfig = cascadingConfig.find(c => c.id === config.child);
                        if (selectedParentIds.length > 0) {
                            const childData = selectedParentIds.flatMap(id => filterData[config.dataKey][id] || []);
                            populateSlimSelect(slimSelects[childConfig.id], childData);
                        } else {
                            clearAndDisableSlimSelect(slimSelects[childConfig.id]);
                        }
                    };

                    allFilterConfigs.forEach(config => {
                        const isCascading = cascadingConfig.some(c => c.id === config.id);
                        const onChangeCallback = isCascading ? () => handleCascadingChange(config.id) : () => { };
                        slimSelects[config.id] = new SlimSelect({
                            select: `#${config.id}`,
                            settings: {
                                placeholderText: `Select ${config.label}`,
                                searchPlaceholder: 'Search...',
                                allowDeselect: true,
                                closeOnSelect: false,
                                showCheckBoxes: true,
                            },
                            events: { afterChange: onChangeCallback }
                        });
                    });

                    // Initial population
                    populateSlimSelect(slimSelects.corporate, filterData.corporates);
                    independentFiltersConfig.forEach(config => {
                        populateSlimSelect(slimSelects[config.id], filterData[config.dataKey]);
                    });
                    cascadingConfig.slice(1).forEach(config => clearAndDisableSlimSelect(slimSelects[config.id]));

                    dashboardRoot.querySelector('#resetFiltersBtn').addEventListener('click', () => {
                         coreResetFilters();
                         showToast('Filters have been reset.', 'success');
                    });
                    dashboardRoot.querySelector('#applyFiltersBtn').addEventListener('click', () => {
                        applyAllFilters();
                        filterModal.hide();
                        showToast('Filters applied.', 'success');
                    });
                }
                // --- END: FILTER MODAL LOGIC ---

                // --- START: BULK UPLOAD LOGIC ---
                function addEquipmentFromData(items) {
                    let successfulUploads = 0;
                    items.forEach((item, index) => {
                         masterEquipmentSource.push({ 
                            id: item.equipmentId, 
                            name: item.equipmentName,
                            modalNumber: item.modalNumber,
                            srNumber: item.srNumber
                        });
                        const newRow = document.createElement('tr');
                        newRow.dataset.equipmentId = item.equipmentId;
                        newRow.dataset.department = item.selectDepartment;
                        newRow.dataset.location = item.selectLocation;
                        newRow.dataset.creationTimestamp = Date.now() + index;
                        newRow.dataset.calibrationDueDate = item.calDueDate || '';
                        newRow.innerHTML = getRowHtml(item);
                        tableRows.unshift(newRow); 
                        updateRowEventListeners(newRow);
                        successfulUploads++;
                    });

                    if(successfulUploads > 0) {
                        applyAllFilters();
                        showToast(`${successfulUploads} equipment item(s) uploaded successfully.`, 'success');
                    } else {
                        showToast('No new equipment was added.', 'info');
                    }
                }
                
                processCsvBtn.addEventListener('click', () => {
                    const file = csvFileInput.files[0];
                    const defaultDept = document.getElementById('bulkUploadDepartment').value;
                    const defaultLoc = document.getElementById('bulkUploadLocation').value;

                    if (!file) { alert("Please select a CSV file to upload."); return; }
                    if (!defaultDept || !defaultLoc) { alert("Please select a default Department and Location."); return; }

                    const spinner = processCsvBtn.querySelector('.spinner-border');
                    processCsvBtn.disabled = true;
                    spinner.classList.remove('d-none');

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const text = event.target.result;
                        const lines = text.split(/\r\n|\n/).filter(line => line.trim() !== '');
                        if (lines.length < 2) {
                            alert("CSV file is empty or contains only a header.");
                            processCsvBtn.disabled = false;
                            spinner.classList.add('d-none');
                            return;
                        }

                        const headers = lines[0].split(',').map(h => h.trim());
                        const requiredHeaders = ['equipmentId', 'equipmentName'];
                        if (!requiredHeaders.every(h => headers.includes(h))) {
                            alert(`CSV file must contain the following headers: ${requiredHeaders.join(', ')}.`);
                            processCsvBtn.disabled = false;
                            spinner.classList.add('d-none');
                            return;
                        }
                        
                        const headerMap = {};
                        headers.forEach((h, i) => headerMap[h] = i);

                        const existingIds = new Set(masterEquipmentSource.map(eq => eq.id));
                        let newItems = [];
                        let duplicateItems = [];

                        for (let i = 1; i < lines.length; i++) {
                            const values = lines[i].split(',');
                            const equipmentId = values[headerMap.equipmentId]?.trim();

                            if (!equipmentId || !values[headerMap.equipmentName]?.trim()) {
                                console.warn(`Skipping row ${i + 1}: Missing required equipmentId or equipmentName.`);
                                continue;
                            }
                            
                            const newEquipmentData = {
                                equipmentId: equipmentId,
                                equipmentName: values[headerMap.equipmentName]?.trim(),
                                makeBrandName: values[headerMap.makeBrandName]?.trim() || 'N/A',
                                modalNumber: values[headerMap.modalNumber]?.trim() || 'N/A',
                                srNumber: values[headerMap.srNumber]?.trim() || 'N/A',
                                selectDepartment: values[headerMap.selectDepartment]?.trim() || defaultDept,
                                selectLocation: values[headerMap.selectLocation]?.trim() || defaultLoc,
                                calibration: { enabled: false },
                                monitoringDevices: []
                            };

                            if (existingIds.has(equipmentId)) {
                                duplicateItems.push(newEquipmentData);
                            } else {
                                newItems.push(newEquipmentData);
                            }
                        }

                        // Hide spinner and re-enable button
                        processCsvBtn.disabled = false;
                        spinner.classList.add('d-none');
                        bulkUploadModal.hide();

                        if(duplicateItems.length > 0) {
                            duplicateListBody.innerHTML = duplicateItems.map(item => `<tr><td>${item.equipmentId}</td><td>${item.equipmentName}</td></tr>`).join('');
                            
                            // Use .one() to ensure the event handler runs only once
                            $(confirmPartialUploadBtn).one('click', function() {
                                addEquipmentFromData(newItems);
                                duplicateModal.hide();
                            });
                            
                            duplicateModal.show();
                        } else {
                            addEquipmentFromData(newItems);
                        }

                        csvFileInput.value = ''; // Reset file input
                    };
                    reader.readAsText(file);
                });

                // --- END: BULK UPLOAD LOGIC ---

                // --- START: DOWNLOAD REPORT LOGIC ---
                function downloadEquipmentReport() {
                    const headers = [
                        "Sr Number", "Equipment Name", "Cleaning Checklist Category", "Department", "Location", "Brand", 
                        "Modal Number", "Equipment ID", "Cleaning Responsibility", "Speacial Cleaning Frequency", 
                        "Speacial Cleaning Day", "PM Responsibility", "PM Freqency", "PM Frequency Start Month", 
                        "Breakdown Number", "Total Cost Of breakdown", "Monitoring Device", "Complain Count", 
                        "Calibration Unique ID", "Calibration Type", "Capacity Range", "Calibration Current utility Range", 
                        "Calibration Least Count", "Calibration Due Date", "Calibration Date", "Certificate number"
                    ];

                    const escapeCsvField = (field) => {
                        if (field === null || field === undefined) return '';
                        const str = String(field);
                        if (str.includes(',') || str.includes('"') || str.includes('\n')) {
                            const escapedStr = str.replace(/"/g, '""');
                            return `"${escapedStr}"`;
                        }
                        return str;
                    };
                    
                    const rows = filteredTableRows.map(row => {
                        const equipmentId = row.dataset.equipmentId;
                        const eqData = masterEquipmentSource.find(eq => eq.id === equipmentId) || {};
                        const scheduleInfo = getScheduleForEquipment(equipmentId);

                        const cleaningDaySelect = row.querySelector('td[data-label="Cleaning Schedule"] select');
                        const pmMonthSelect = row.querySelector('td[data-label="Preventive Maintenance"] select');

                        const monitoringDevices = Array.from(row.querySelectorAll('td[data-label="Monitoring"] input:checked'))
                            .map(cb => cb.value)
                            .join('; ');

                        const data = {
                            srNumber: eqData.srNumber || 'N/A',
                            equipmentName: eqData.name || 'N/A',
                            cleaningChecklistCategory: scheduleInfo?.checklistName || '',
                            department: row.dataset.department || 'N/A',
                            location: row.dataset.location || 'N/A',
                            brand: row.querySelector('.fa-copyright').nextElementSibling.textContent.trim(),
                            modalNumber: row.querySelector('.modal-number-text').textContent.trim(),
                            equipmentId: equipmentId,
                            cleaningResponsibility: scheduleInfo?.cleaning.resp || '',
                            speacialCleaningFrequency: scheduleInfo?.cleaning.freq || '',
                            speacialCleaningDay: cleaningDaySelect?.value || '',
                            pmResponsibility: scheduleInfo?.pm.resp || '',
                            pmFrequency: scheduleInfo?.pm.freq || '',
                            pmFrequencyStartMonth: pmMonthSelect?.value || '',
                            breakdownNumber: '0', // Placeholder
                            totalCostOfBreakdown: '0', // Placeholder
                            monitoringDevice: monitoringDevices,
                            complainCount: '0', // Placeholder
                            calibrationUniqueId: 'N/A', // Placeholder
                            calibrationType: 'N/A', // Placeholder
                            capacityRange: 'N/A', // Placeholder
                            calibrationCurrentUtilityRange: 'N/A', // Placeholder
                            calibrationLeastCount: 'N/A', // Placeholder
                            calibrationDueDate: row.dataset.calibrationDueDate || '',
                            calibrationDate: 'N/A', // Placeholder
                            certificateNumber: 'N/A' // Placeholder
                        };
                        return headers.map(header => escapeCsvField(data[header.replace(/ /g, '').replace('Freqency','Frequency').replace('Speacial', 'special').charAt(0).toLowerCase() + header.replace(/ /g, '').replace('Freqency','Frequency').replace('Speacial', 'special').slice(1)]));
                    });

                    const csvContent = [
                        headers.join(','),
                        ...rows.map(row => row.join(','))
                    ].join('\n');

                    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                    const link = document.createElement("a");
                    const url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    const today = new Date().toISOString().slice(0, 10);
                    link.setAttribute("download", `FHM_Equipment_List_${today}.csv`);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }

                downloadReportBtn.addEventListener('click', downloadEquipmentReport);
                // --- END: DOWNLOAD REPORT LOGIC ---


                function showToast(message, type = 'success') {
                    toastNotification.textContent = message;
                    toastNotification.className = 'toast-notification';
                    if (type === 'danger') toastNotification.classList.add('danger');
                    toastNotification.classList.add('show');
                    setTimeout(() => toastNotification.classList.remove('show'), 3000);
                }

                function renderTablePage() {
                    tbody.innerHTML = '';
                    const start = (currentPage - 1) * itemsPerPage;
                    const end = start + itemsPerPage;
                    const pageRows = filteredTableRows.slice(start, end);

                    if (pageRows.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="10" class="text-center p-5">No equipment found matching your criteria.</td></tr>`;
                    } else {
                        pageRows.forEach(row => {
                            tbody.appendChild(row);
                            const canvas = row.querySelector('.combined-trend-graph canvas');
                            if (canvas && !canvas.chart) createPerformanceChart(canvas.id);
                        });
                    }
                }

                function renderPaginationControls() {
                    if (!paginationUl) return;
                    paginationUl.innerHTML = '';
                    const totalPages = Math.ceil(filteredTableRows.length / itemsPerPage);
                    if (totalPages <= 1) return;
                    
                    let pagesHtml = '';
                    for (let i = 1; i <= totalPages; i++) {
                        pagesHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" onclick="event.preventDefault(); goToPage(${i})">${i}</a></li>`;
                    }
                    
                    paginationUl.innerHTML = `
                        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                           <a class="page-link" href="#" onclick="event.preventDefault(); goToPage(${currentPage - 1})">Previous</a>
                        </li>
                        ${pagesHtml}
                        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                           <a class="page-link" href="#" onclick="event.preventDefault(); goToPage(${currentPage + 1})">Next</a>
                        </li>`;
                }

                window.goToPage = (pN) => {
                    const totalPages = Math.ceil(filteredTableRows.length / itemsPerPage);
                    if (pN < 1 || pN > totalPages) return;
                    currentPage = pN;
                    renderTablePage();
                    renderPaginationControls();
                };

                function applyAllFilters() {
                    updateMasterListSchedules();
                    const selectedFilters = {};
                    allFilterConfigs.forEach(config => {
                        if (slimSelects[config.id] && slimSelects[config.id].getSelected) {
                            const selected = slimSelects[config.id].getSelected();
                            if (selected.length > 0) {
                                selectedFilters[config.filterKey] = selected;
                            }
                        }
                    });

                    filteredTableRows = tableRows.filter(row => {
                        if (selectedFilters.equipmentId && !selectedFilters.equipmentId.includes(row.dataset.equipmentId)) return false;
                        if (selectedFilters.department && !selectedFilters.department.includes(row.dataset.department)) return false;
                        if (selectedFilters.location && !selectedFilters.location.includes(row.dataset.location)) return true;
                        if (selectedFilters.status) {
                            const isRowActive = row.querySelector('.activation-toggle-checkbox').checked;
                            const rowStatus = isRowActive ? 'active' : 'inactive';
                            if (!selectedFilters.status.includes(rowStatus)) return false;
                        }
                        if (selectedFilters.calibration) {
                            const equipmentId = row.dataset.equipmentId;
                           // const isCalibrated = row.querySelector(`#cal-yes-${equipmentId}`).checked;
                           const isCalibrated = row.querySelector(`[id="cal-yes-${equipmentId}"]`).checked;

                            const requiredState = isCalibrated ? 'yes' : 'no';
                            if (!selectedFilters.calibration.includes(requiredState)) return false;
                        }
                        if (selectedFilters.cleaningAttached && !selectedFilters.cleaningAttached.includes(row.dataset.cleaningAttached)) return false;
                        if (selectedFilters.pmAttached && !selectedFilters.pmAttached.includes(row.dataset.pmAttached)) return false;
                        if (selectedFilters.responsibility) {
                             if (!selectedFilters.responsibility.includes(row.dataset.cleaningResp) && !selectedFilters.responsibility.includes(row.dataset.pmResp)) {
                                return false;
                            }
                        }
                        return true;
                    });

                    filteredTableRows.sort((rowA, rowB) => {
                        const isActiveA = rowA.querySelector('.activation-toggle-checkbox')?.checked ?? true;
                        const isActiveB = rowB.querySelector('.activation-toggle-checkbox')?.checked ?? true;
                        if (isActiveA && !isActiveB) return -1;
                        if (!isActiveA && isActiveB) return 1;
                        return parseInt(rowB.dataset.creationTimestamp || '0') - parseInt(rowA.dataset.creationTimestamp || '0');
                    });

                    filteredTableRows.forEach((row, index) => {
                        const rowNumEl = row.querySelector('.equipment-row-number');
                        if (rowNumEl) rowNumEl.textContent = `${index + 1}.`;
                    });

                    currentPage = 1;
                    renderTablePage();
                    renderPaginationControls();
                }

                function updateRowEventListeners(row) {
                    const expandBtn = row.querySelector('.equipment-expand-btn');
                    if (expandBtn) expandBtn.addEventListener('click', () => {
                        const tr = expandBtn.closest('tr');
                        tr.classList.toggle('is-expanded');
                        expandBtn.querySelector('.expand-btn-text').textContent = tr.classList.contains('is-expanded') ? 'Collapse Details' : 'Expand Details';
                    });
                    const activationCheckbox = row.querySelector('.activation-toggle-checkbox');
                    if (activationCheckbox) updateToggleTextAndBadge(activationCheckbox);
                    updateActionLogDisplay(row.dataset.equipmentId, row);

                    const monitoringContainer = row.querySelector('.multi-select-monitoring');
                    if (monitoringContainer) {
                        updateMonitoringDisplay(monitoringContainer);
                    }
                }

                tbody.addEventListener('click', function (event) {
                    const target = event.target;

                    if (target.classList.contains('activation-toggle-checkbox')) {
                        const row = target.closest('tr');
                        const originalStateChecked = !target.checked;
                        commentModalEquipmentIdInput.value = row.dataset.equipmentId;
                        commentModalOriginalStateInput.value = originalStateChecked.toString();
                        const actionText = target.checked ? 'Reactivation' : 'Deactivation';
                        dashboardRoot.querySelector('#commentModalActionText').textContent = actionText;
                        dashboardRoot.querySelector('#activationCommentModalLabel').textContent = `${actionText} Comments`;
                        activationCommentTextarea.value = '';
                        activationCommentTextarea.classList.remove('is-invalid');
                        target.checked = originalStateChecked; // Revert change until confirmed
                        activationCommentModal.show();
                        return;
                    }

                    const removeBtn = target.closest('.btn-remove-schedule');
                    if (removeBtn) {
                        const equipmentId = removeBtn.dataset.equipmentId;
                        if (!equipmentId) return;
                        const checklistCheckbox = document.querySelector(`#checklist-table-body .multi-select-list input[value="${equipmentId}"]:checked`);
                        if (checklistCheckbox) {
                            const changeEvent = new Event('change', { bubbles: true });
                            checklistCheckbox.checked = false;
                            checklistCheckbox.dispatchEvent(changeEvent);
                        }
                        return;
                    }
                });

                tbody.addEventListener('change', function (event) {
                    const target = event.target;
                    if (target.closest('.multi-select-monitoring')) {
                        updateMonitoringDisplay(target.closest('.multi-select-monitoring'));
                    }
                });

                function updateMonitoringDisplay(container) {
                    const displaySpan = container.querySelector('.multi-select-display span');
                    const checkedCount = container.querySelectorAll('input[type="checkbox"]:checked').length;
                    if (checkedCount === 0) {
                        displaySpan.textContent = 'None selected';
                    } else {
                        displaySpan.textContent = `${checkedCount} parameter(s) selected`;
                    }
                }

                function updateToggleTextAndBadge(checkbox) {
                    const statusTextElement = checkbox.closest('.activation-toggle-container').querySelector('.activation-status-text');
                    const mainStatusBadge = checkbox.closest('tr').querySelector('.equipment-name .status-badge');
                    if (checkbox.checked) {
                        statusTextElement.textContent = 'Active';
                        statusTextElement.style.color = 'var(--success-dark)';
                        if (mainStatusBadge) {
                            let originalStatus = mainStatusBadge.dataset.originalStatus || 'Operational';
                            mainStatusBadge.textContent = originalStatus;
                            mainStatusBadge.className = `status-badge ${mainStatusBadge.dataset.originalStatusClass || 'status-operational'}`;
                            if (originalStatus.toLowerCase() === 'overdue') mainStatusBadge.classList.add('status-alert');
                        }
                    } else {
                        statusTextElement.textContent = 'Inactive';
                        statusTextElement.style.color = 'var(--danger-dark)';
                        if (mainStatusBadge) {
                            if (!mainStatusBadge.dataset.originalStatus) {
                                mainStatusBadge.dataset.originalStatus = mainStatusBadge.textContent.trim();
                                mainStatusBadge.dataset.originalStatusClass = Array.from(mainStatusBadge.classList).find(c => c.startsWith('status-') && !['status-inactive', 'status-alert'].includes(c)) || 'status-operational';
                            }
                            mainStatusBadge.textContent = 'Inactive';
                            mainStatusBadge.className = 'status-badge status-inactive';
                        }
                    }
                }

   saveActivationCommentBtn.addEventListener('click', function () {
    const equipmentId = commentModalEquipmentIdInput.value;
    const comment = activationCommentTextarea.value.trim();

    if (!comment) {
        activationCommentTextarea.classList.add('is-invalid');
        return;
    }

    activationCommentTextarea.classList.remove('is-invalid');

    const row = dashboardRoot.querySelector(`tr[data-equipment-id="${equipmentId}"]`);
    const checkbox = row?.querySelector('.activation-toggle-checkbox');
    if (!checkbox) return;

    const targetStateIsActive = !(commentModalOriginalStateInput.value === 'true');
    checkbox.checked = targetStateIsActive;

    updateToggleTextAndBadge(checkbox);

    if (!equipmentActivationLogs[equipmentId]) {
        equipmentActivationLogs[equipmentId] = [];
    }

    equipmentActivationLogs[equipmentId].unshift({
        timestamp: new Date().toLocaleString(),
        action: targetStateIsActive ? 'Activated' : 'Deactivated',
        comment: comment,
        user: 'System User'
    });
    updateActionLogDisplay(equipmentId, row);
    activationCommentModal.hide();
    showToast(`${equipmentId} ${targetStateIsActive ? 'Activated' : 'Deactivated'}.`);
    applyAllFilters();
    // тЬЕ Send data to server via AJAX
    $.ajax({
        url: "{{ route('fhm_status_change') }}",
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            equipment_id: equipmentId,
            new_status: targetStateIsActive ? 1 : 0,
            comment: comment
        },
        success: function (data) {
            console.log("Status update sent successfully.", data);
        },
        error: function (xhr) {
            console.error("Error while sending status update:", xhr.responseText);
            alert("Error: " + xhr.responseText);
        }
    });
});
                const handleModalCloseOrCancel = () => {
                    const equipmentId = commentModalEquipmentIdInput.value;
                    if (!equipmentId) return;
                    const checkbox = dashboardRoot.querySelector(`tr[data-equipment-id="${equipmentId}"] .activation-toggle-checkbox`);
                    if (checkbox) checkbox.checked = commentModalOriginalStateInput.value === 'true';
                    activationCommentTextarea.classList.remove('is-invalid');
                    commentModalEquipmentIdInput.value = '';
                };
                cancelActivationChangeBtn.addEventListener('click', handleModalCloseOrCancel);
                activationCommentModalCloseBtn.addEventListener('click', handleModalCloseOrCancel);
                function updateActionLogDisplay(equipmentId, row) {
                    const logDisplay = row?.querySelector('.activation-log-display');
                    if (!logDisplay) return;
                    const logs = equipmentActivationLogs[equipmentId] || [];
                    logDisplay.innerHTML = logs.length === 0 ? '<small>No activation history yet.</small>' : logs.slice(0, 5).map(log => `<div><strong>${log.action}:</strong> ${log.comment} <em>(${log.user} at ${log.timestamp})</em></div>`).join('');
                }
                const addEquipmentModal = new bootstrap.Modal(dashboardRoot.querySelector('#addEquipmentModal'));
                const addEquipmentForm = dashboardRoot.querySelector('#addEquipmentForm');
                if (addEquipmentForm) {
                    new Pikaday({ field: dashboardRoot.querySelector('#calDueDate'), format: 'YYYY-MM-DD' });
                    window.getRowHtml = (data) => {
                        //console.log(data);
                        const calCheckedYes = data.calibration?.enabled ? 'checked' : '';
                        const calCheckedNo = !data.calibration?.enabled ? 'checked' : '';
                        const allMonitoringDevices = ['Temperature', 'Humidity', 'Airflow', 'RPM', 'Pressure'];
                        const monitoringDevicesHtml = allMonitoringDevices.map(device => {
                            const isChecked = (data.monitoringDevices || []).includes(device);
                            return `<li><label><input type="checkbox" name="monitoring-device" value="${device}" ${isChecked ? 'checked' : ''}> ${device}</label></li>`;
                        }).join('');

                        return `
                        <td data-label="Equipment">
                            <div class="equipment-card">
                                <div class="equipment-info">
                                    <div class="equipment-name">
                                        <span class="equipment-row-number"></span> ${data.equipmentName} <span class="status-badge status-operational">Operational</span>
                                    </div>
                                    <span class="equipment-id">${data.equipmentId}</span>
                                    <div class="equipment-meta">
                                        <div class="meta-item"><i class="fas fa-cubes"></i> <span>${data.selectDepartment}</span></div>
                                        <div class="meta-item"><i class="fas fa-map-marker-alt"></i> <span>${data.selectLocation}</span></div>
                                        <div class="meta-item"><i class="fas fa-copyright"></i> <span>${data.makeBrandName || 'N/A'}</span></div>
                                        <div class="meta-item"><i class="fas fa-barcode-read"></i> <span class="modal-number-text">${data.modalNumber || 'N/A'}</span></div>
                                        <div class="meta-item"><i class="fas fa-fingerprint"></i> <span class="sr-number-text">${data.srNumber || 'N/A'}</span></div>
                                    </div>
                                    <button class="equipment-expand-btn"><i class="fas fa-chevron-down"></i> <span class="expand-btn-text">Expand</span></button>
                                </div>
                            </div>
                        </td>
                        <td data-label="Cleaning Schedule" class="mobile-expandable-td"></td>
                        <td data-label="Preventive Maintenance" class="mobile-expandable-td"></td>
                        <td data-label="Breakdown Metrics" class="mobile-expandable-td"><div class="breakdown-card">...</div></td>
                        <td data-label="Monitoring" class="mobile-expandable-td">
                            <div class="multi-select-monitoring" id="monitoring-dd-${data.equipmentId}">
                                <div class="multi-select-display" tabindex="0"><span>None selected</span><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5H7z"></path></svg></div>
                                <div class="multi-select-dropdown hidden">
                                    <input type="text" class="multi-select-monitoring-search" placeholder="Search devices..."><ul class="multi-select-list">${monitoringDevicesHtml}</ul>
                                </div>
                            </div>
                        </td>
                        <td data-label="Registered Complain" class="mobile-expandable-td"><div class="breakdown-card">...</div></td>
                        <td data-label="Calibration" class="mobile-expandable-td">
                            <div class="d-flex align-items-center" style="gap: 1rem;">
                                <div class="form-check"><input class="form-check-input" type="radio" name="calibration-${data.equipmentId}" data-equipmentId="${data.equipmentId}" id="cal-yes-${data.equipmentId}" ${calCheckedYes}><label class="form-check-label" for="cal-yes-${data.equipmentId}">Yes</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="calibration-${data.equipmentId}" data-equipmentId="${data.equipmentId}" id="cal-no-${data.equipmentId}" ${calCheckedNo}><label class="form-check-label" for="cal-no-${data.equipmentId}">No</label></div>
                            </div>
                        </td>
                        <td data-label="Activation" class="mobile-expandable-td"><div class="activation-toggle-container"><label class="switch"><input type="checkbox" class="activation-toggle-checkbox" checked><span class="slider round"></span></label><span class="activation-status-text">Active</span></div></td>
                        <td data-label="Actions" class="mobile-expandable-td"><div class="actions-column-grid"><button class="btn btn-edit" title="Edit" onclick="openEditModal(this)"><i class="fas fa-pencil-alt"></i></button><button class="btn btn-qr" title="QR" onclick="downloadQRCode(this, '${data.equipmentId}')"><i class="fas fa-qrcode"></i></button>
                        <a href="https://efsm.safefoodmitra.com/admin/public/index.php/deleteFhm/${data.equipmentId}" class="btn btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fas fa-trash-alt"></i></a>
                        
                        </div><div class="activation-log-display mt-2"></div></td>`;
                    }

                    addEquipmentForm.addEventListener('submit', function (event) {
                        event.preventDefault(); event.stopPropagation();
                        if (!addEquipmentForm.checkValidity()) { addEquipmentForm.classList.add('was-validated'); return; }
                        const data = Object.fromEntries(new FormData(addEquipmentForm).entries());
                        const editId = addEquipmentForm.dataset.editId;

                        if (editId) {
                            const rowToUpdate = tableRows.find(row => row.dataset.equipmentId === editId);
                            if (rowToUpdate) {
                                masterEquipmentSource = masterEquipmentSource.map(eq => eq.id === editId ? { id: editId, name: data.equipmentName, modalNumber: data.modalNumber, srNumber: data.srNumber } : eq);
                                const currentMonitoring = JSON.parse(addEquipmentForm.dataset.currentMonitoring || '[]');
                                const currentCalibration = addEquipmentForm.querySelector('#calYes').checked;
                                rowToUpdate.dataset.calibrationDueDate = data.calDueDate || '';
                                rowToUpdate.innerHTML = getRowHtml({ ...data, monitoringDevices: currentMonitoring, calibration: { enabled: currentCalibration } });
                                rowToUpdate.dataset.department = data.selectDepartment; // Update data attribute
                                rowToUpdate.dataset.location = data.selectLocation; // Update data attribute
                                updateRowEventListeners(rowToUpdate);
                                showToast(`Equipment ${editId} updated.`);
                            }
                        } else {
                             // Check for duplicate ID before adding
                            if (masterEquipmentSource.some(eq => eq.id === data.equipmentId)) {
                                alert(`Error: Equipment ID "${data.equipmentId}" already exists. Please use a unique ID.`);
                                return;
                            }
                            masterEquipmentSource.push({ id: data.equipmentId, name: data.equipmentName, modalNumber: data.modalNumber, srNumber: data.srNumber });
                            const newRow = document.createElement('tr');
                            newRow.dataset.equipmentId = data.equipmentId;
                            newRow.dataset.department = data.selectDepartment; // Set data attribute
                            newRow.dataset.location = data.selectLocation; // Set data attribute
                            newRow.dataset.creationTimestamp = Date.now();
                            newRow.dataset.calibrationDueDate = data.calDueDate || '';
                            newRow.innerHTML = getRowHtml({ ...data, monitoringDevices: [], calibration: { enabled: data.calibration === 'yes' } });
                            tableRows.unshift(newRow);
                            updateRowEventListeners(newRow);
                            showToast(`Equipment ${data.equipmentId} added.`);
                        }
                        updateMasterListSchedules();
                        applyAllFilters();
                        addEquipmentModal.hide();
                    });

                    window.openEditModal = (el) => {
                        const row = el.closest('tr');
                        if (!row) return;
                        
                       
                        
                        const equipmentId = row.dataset.equipmentId;
                        const rawName = row.querySelector('.equipment-name').textContent.trim();
                        const name = rawName.replace(/^\d+\.?\s*/, '').trim();                      
                        const brand = row.querySelector('.fa-copyright').nextElementSibling.textContent.trim();
                        const modalNumber = row.querySelector('.modal-number-text').textContent.trim();
                        const srNumber = row.querySelector('.sr-number-text').textContent.trim();
                        const department = row.dataset.department; // Read from data attribute
                        const location = row.dataset.location; // Read from data attribute
                         const c_frequency = row.dataset.c_frequency; // Read from data attribute
                        const p_frequency = row.dataset.p_frequency; // Read from data attribute
                        const template_ids = row.dataset.template_ids; // Read from data attribute
                        const safeEquipmentId = equipmentId.replace(/[^\w-]/g, '_');
                        const isCalibrationEnabled = row.querySelector(`#cal-yes-${safeEquipmentId}`)?.checked;
                        const calDueDate = row.dataset.calibrationDueDate || '';
                        const selectedMonitoring = Array.from(row.querySelectorAll('.multi-select-monitoring input:checked')).map(cb => cb.value);

                        dashboardRoot.querySelector('#addEquipmentModalLabel').innerHTML = `<i class="fa-solid fa-pencil-alt"></i> Edit Equipment`;
                        dashboardRoot.querySelector('.submit-button').innerHTML = `<i class="fa-solid fa-check"></i> Save Changes`;
                        addEquipmentForm.dataset.editId = equipmentId;
                        dashboardRoot.querySelector('#equipmentName').value = name;
                        const eqIdInput = dashboardRoot.querySelector('#equipmentId');
                        eqIdInput.value = equipmentId;
                        eqIdInput.readOnly = false;
                        dashboardRoot.querySelector('#makeBrandName').value = brand;
                        dashboardRoot.querySelector('#modalNumber').value = modalNumber;
                        dashboardRoot.querySelector('#oldequipmentId').value = equipmentId;
                        dashboardRoot.querySelector('#srNumber').value = srNumber;
                        dashboardRoot.querySelector('#p_frequency').value = p_frequency;
                        dashboardRoot.querySelector('#c_frequency').value = c_frequency;
                        dashboardRoot.querySelector('#mydepartment').value = 167;
                        addEquipmentForm.dataset.currentMonitoring = JSON.stringify(selectedMonitoring);
                        const calRadio = dashboardRoot.querySelector(isCalibrationEnabled ? '#calYes' : '#calNo');
                        if (calRadio) { 
                            calRadio.checked = true; 
                            calRadio.dispatchEvent(new Event('change', { bubbles: true })); 
                            dashboardRoot.querySelector('#calDueDate').value = calDueDate;
                        }

                        addEquipmentModal.show();
                    }
                    dashboardRoot.querySelector('#addEquipmentModal').addEventListener('hidden.bs.modal', () => {
                        addEquipmentForm.reset(); addEquipmentForm.classList.remove('was-validated');
                        dashboardRoot.querySelector('#addEquipmentModalLabel').innerHTML = `<i class="fa-solid fa-plus-circle"></i> Add New Equipment`;
                        dashboardRoot.querySelector('.submit-button').innerHTML = `<i class="fa-solid fa-check"></i> Submit`;
                        delete addEquipmentForm.dataset.editId;
                        delete addEquipmentForm.dataset.currentMonitoring;
                        dashboardRoot.querySelector('#equipmentId').readOnly = false;
                        dashboardRoot.querySelectorAll('.dynamic-details-section.is-visible').forEach(el => el.classList.remove('is-visible'));
                        dashboardRoot.querySelectorAll('.radio-option-group.is-expanded').forEach(el => el.classList.remove('is-expanded'));
                    });

                    window.deleteRow = (el) => {
                        const row = el.closest('tr');
                        if (row && confirm('Are you sure you want to delete this equipment?')) {
                            const equipmentIdToDelete = row.dataset.equipmentId;
                            masterEquipmentSource = masterEquipmentSource.filter(eq => eq.id !== equipmentIdToDelete);
                            tableRows = tableRows.filter(r => r !== row);
                            applyAllFilters();
                            showToast(`Equipment deleted.`, 'danger');
                        }
                    }
                }

                function createPerformanceChart(canvasId) {
                    const ctx = dashboardRoot.querySelector(`#${canvasId}`);
                    if (!ctx) return;
                    if (ctx.chart) ctx.chart.destroy();
                    ctx.chart = new Chart(ctx, { type: 'line', data: { labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'], datasets: [{ data: Array.from({ length: 7 }, () => Math.floor(Math.random() * 30) + 65), borderColor: 'rgba(0, 123, 255, 0.6)', borderWidth: 2, pointRadius: 0, tension: 0.4 }, { data: Array.from({ length: 7 }, () => Math.floor(Math.random() * 20) + 75), borderColor: 'rgba(111, 66, 193, 0.6)', borderWidth: 2, pointRadius: 0, tension: 0.4 }, { data: Array.from({ length: 7 }, () => Math.floor(Math.random() * 40) + 55), borderColor: 'rgba(253, 126, 20, 0.6)', borderWidth: 2, pointRadius: 0, tension: 0.4 }] }, options: { animation: false, responsive: true, maintainAspectRatio: false, scales: { x: { display: false }, y: { display: false, min: 20, max: 100 } }, plugins: { legend: { display: false }, tooltip: { enabled: false } } } });
                }

                const initialTimestamp = Date.now();
                const initialDataForTable = [
                    <?php foreach ($facility_equipment as $facility_equipments): ?>
                    
                    
                    
                    @php $template_ids = DB::table('template_equpiments')->where('equpiments',$facility_equipments->id)->value('template_id'); @endphp

                                { 
    equipmentId: '{{$facility_equipments->equipment_id}}', 
    equipmentName: '{{$facility_equipments->name ?? ''}}', 
    makeBrandName: '{{$facility_equipments->brand}}', 
    modalNumber: '{{$facility_equipments->modal_number}}', 
    srNumber: '{{$facility_equipments->srNumber}}', 
    selectDepartment: '{{$facility_equipments->department ?? 'NA'}}', 
    selectLocation: '{{$facility_equipments->location_id ?? 'NA'}}',
    c_frequency: '{{$facility_equipments->c_frequency ?? 'NA'}}',
    p_frequency: '{{$facility_equipments->p_frequency ?? 'NA'}}',
    template_ids: '{{$template_ids ?? 'NA'}}',
    calibration: { 
        enabled: {{ $facility_equipments->Calibration_status === 'Yes' ? 'true' : 'false' }},
        dueDate: '2025-12-31' 
    }, 
    monitoringDevices: ['Temperature', 'RPM'],
    inactive: {{ $facility_equipments->calibaration_active == 0 ? 'true' : 'false' }}
},
                    <?php endforeach; ?>
                ];
                initialDataForTable.forEach((d, index) => {
                    const row = document.createElement('tr');
                    row.dataset.p_frequency = d.p_frequency;
                    row.dataset.c_frequency = d.c_frequency;
                    row.dataset.template_ids = d.template_ids;
                    row.dataset.equipmentId = d.equipmentId;
                    row.dataset.department = d.selectDepartment;
                    row.dataset.location = d.selectLocation;
                    row.dataset.creationTimestamp = initialTimestamp - (index * 10000);
                    row.dataset.calibrationDueDate = d.calibration?.dueDate || '';
                    row.innerHTML = getRowHtml(d);
                    if (d.inactive) row.querySelector('.activation-toggle-checkbox').checked = false;
                    tableRows.push(row);
                    updateRowEventListeners(row);
                });

                // Initialize everything on first load
                initializeFilters();
                applyAllFilters();
            }

            // Close dropdowns on outside click (global)
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.multi-select-monitoring')) {
                    document.querySelectorAll('.multi-select-monitoring .multi-select-dropdown').forEach(d => d.classList.add('hidden'));
                }
            });
        });
    </script>
<script>
  const loggedInUserId = "{{ auth()->user()->id }}";
</script>

<script>
$(document).ready(function() {
  // Logged-in user ID (set this variable from backend)
   const loggedInUserId = "{{ auth()->user()->id }}";

  // Initialize SlimSelect for all selects with class 'slim-select'
  const slimSelectInstances = {};

  $('.slim-select').each(function() {
    const selectId = $(this).attr('id');
    if (!slimSelectInstances[selectId]) { // avoid re-initializing
      slimSelectInstances[selectId] = new SlimSelect({
        select: `#${selectId}`,
        settings: { closeOnSelect: false }
      });
    }
  });

  // When Corporate changes -> Update Regional dynamically
  $('#selectcorporate1').on('change', function() {
    const selectedCorporateIds = $(this).val() || [];

    if (selectedCorporateIds.length === 0) {
      slimSelectInstances['regional_id1'].setData([]);
      slimSelectInstances['regional_id1'].setSelected([]);
      slimSelectInstances['unitSelect'].setData([]);
      slimSelectInstances['unitSelect'].setSelected([]);
      // Do NOT clear departmentSelect here (optional based on your needs)
      return;
    }

    $.ajax({
      url: "{{ route('filterregional_list') }}",
      method: 'GET',
      data: { corporate_ids: selectedCorporateIds },
      dataType: 'json',
      success: function(response) {
        const data = response.data || [];
        const options = data.map(item => ({ text: item.company_name, value: item.id.toString() }));

        slimSelectInstances['regional_id1'].setData(options);
        slimSelectInstances['regional_id1'].setSelected([]);

        // Clear Unit when Regional changes
        slimSelectInstances['unitSelect'].setData([]);
        slimSelectInstances['unitSelect'].setSelected([]);

        // Do NOT clear departmentSelect here
      },
      error: function() {
        slimSelectInstances['regional_id1'].setData([]);
        slimSelectInstances['regional_id1'].setSelected([]);
      }
    });
  });

  // When Regional changes -> Update Unit dynamically
  $('#regional_id1').on('change', function() {
    const selectedRegionalIds = $(this).val() || [];

    if (selectedRegionalIds.length === 0) {
      slimSelectInstances['unitSelect'].setData([]);
      slimSelectInstances['unitSelect'].setSelected([]);
      // Do NOT clear departmentSelect here
      return;
    }

    $.ajax({
      url: "{{ route('filterrregional_unitlist') }}",
      method: 'GET',
      data: { regional_ids: selectedRegionalIds },
      dataType: 'json',
      success: function(response) {
        const data = response.data || [];
        const options = data.map(item => ({ text: item.company_name, value: item.id.toString() }));
        slimSelectInstances['unitSelect'].setData(options);
        slimSelectInstances['unitSelect'].setSelected([]);

        // Do NOT clear departmentSelect here
      },
      error: function() {
        slimSelectInstances['unitSelect'].setData([]);
        slimSelectInstances['unitSelect'].setSelected([]);
      }
    });
  });

  // When Unit changes -> Update Department dynamically based on Unit selection
  $('#unitSelect').on('change', function() {
    const selectedUnitIds = $(this).val() || [];

    let dataToSend = {};
    if (selectedUnitIds.length === 0) {
      // Send logged-in user ID if Unit empty
      dataToSend = { unit_ids: [loggedInUserId] };
    } else {
      dataToSend = { unit_ids: selectedUnitIds };
    }

    $.ajax({
      url: "{{ route('filterrunitdeprtmentlist') }}", // Backend route to get departments by unit
      method: 'GET',
      data: dataToSend,
      dataType: 'json',
      success: function(response) {
        const data = response.data || [];
        const options = data.map(item => ({ text: item.name, value: item.id.toString() }));
        slimSelectInstances['departmentSelect'].setData(options);
        slimSelectInstances['departmentSelect'].setSelected([]);
      },
      error: function() {
        slimSelectInstances['departmentSelect'].setData([]);
        slimSelectInstances['departmentSelect'].setSelected([]);
      }
    });
  });

  // When Department changes -> Update Sub Department dynamically
  $('#departmentSelect').on('change', function() {
    const selectedDeptIds = $(this).val() || [];

    if (selectedDeptIds.length === 0) {
      slimSelectInstances['subDepartmentSelect'].setData([]);
      slimSelectInstances['subDepartmentSelect'].setSelected([]);
      return;
    }

    $.ajax({
      url: "{{ route('filterdepartment_location') }}",
      method: 'GET',
      data: { department_ids: selectedDeptIds },
      dataType: 'json',
      success: function(response) {
        const data = response.data || [];
        const options = data.map(item => ({ text: item.name, value: item.id.toString() }));
        slimSelectInstances['subDepartmentSelect'].setData(options);
        slimSelectInstances['subDepartmentSelect'].setSelected([]);
      },
      error: function() {
        slimSelectInstances['subDepartmentSelect'].setData([]);
        slimSelectInstances['subDepartmentSelect'].setSelected([]);
      }
    });
  });

  // Reset all filters on button click
  $('#resetFilters').on('click', function() {
    Object.keys(slimSelectInstances).forEach(id => {
      slimSelectInstances[id].setSelected([]);
      // Optional: Reset data to default if needed
    });
  });

  // On page load, if Unit is empty, trigger change to load departments for logged-in user
  if ($('#unitSelect').val() == null || $('#unitSelect').val().length === 0) {
    $('#unitSelect').trigger('change');
  }
  // ELSE do nothing, keep existing departmentSelect data intact on page load
});
</script>


<script>
    $(document).on('change', 'input[name="equipment"]', function() {

    let equipmentId = $(this).val();
    let checklistId = $(this).data('checklist_id');
    let isChecked   = $(this).is(':checked');
    
    // agar check hua to "linked", warna "unlinked"
    let status = isChecked ? "linked" : "unlinked";

    $.ajax({
        url: "{{ route('AddChecklistNew') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            equipment_id: equipmentId,
            checklist_id: checklistId,
            calibration_status: status
        },
        success: function (response) {
            console.log("Calibration status updated:", response);

            // Toast show
            const toast = document.getElementById('toastNotification');
            toast.textContent = `${status.toUpperCase()} equipment ${equipmentId} with checklist.`;
            toast.className = 'toast-notification show';
            setTimeout(() => toast.classList.remove('show'), 3000);
        },
        error: function (xhr) {
            console.error("Error updating calibration status:", xhr.responseText);
        }
    });
});
</script>


<script>
    function updateScheduleFrequency(equipmentId, value, type) {
    $.ajax({
        url: "{{ route('updateEqupiments') }}",  // 🔹 आपका backend route
        method: "POST",
        data: {
            equipment_id: equipmentId,
            frequency_value: value,
            frequency_type: type, // 'day' or 'month'
            _token: $('meta[name="csrf-token"]').attr('content') // Laravel CSRF
        },
        success: function(response) {
location.reload();
        },
        error: function(xhr) {
            console.error("❌ Error updating frequency", xhr.responseText);
        }
    });
}


$(document).on('click', '.btn-remove-schedule', function () {
    let equipmentId = $(this).data('equipment-id');
    let type = $(this).data('schedule-type');

    if (!confirm("Are you sure you want to unlink this schedule?")) return;

    $.ajax({
        url: "{{ route('deletelinkEqupiments') }}", // ✅ apna route lagao
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            equipment_id: equipmentId,
            schedule_type: type
        },
        success: function (response) {
            location.reload();
        },
        error: function (xhr) {
            alert("Error unlinking schedule!");
            console.error(xhr.responseText);
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // jab bhi checkbox change hoga
    document.querySelectorAll(".equipment-checkbox").forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            let checklistId = this.getAttribute("data-checklist_id");

            // us template ke sare checkbox count karo jo checked hai
            let checkedCount = document.querySelectorAll(
                '.equipment-checkbox[data-checklist_id="' + checklistId + '"]:checked'
            ).length;

            // span update karo
            document.getElementById("equip-count-" + checklistId).innerText = checkedCount + " Equipments";
        });
    });
});
</script>

@endsection
