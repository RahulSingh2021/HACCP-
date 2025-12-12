<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hierarchical Training Dashboard with Advanced Filtering</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts for second chart -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SheetJS for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- Libraries for Chart Download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        /* General Styling */
        :root {
            --primary-text: #2c3e50; --secondary-text: #555; --light-text: #ecf0f1; --icon-color: #7f8c8d;
            --border-color: #dbe4e8; --header-bg: #34495e; --summary-bg: #f0f4f8; --hover-bg: #f1f3f4;
            --level1-color: #2980b9; --level2-color: #3498db; --level3-color: #a9cce3;
            --download-btn-bg: #1D6F42; --download-btn-hover-bg: #165934;
            --competency-bar-bg: #007bff;
        }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; color: var(--primary-text); }
        h1 { text-align: center; color: var(--primary-text); font-weight: 600; }
        .dashboard-controls { display: flex; justify-content: center; align-items: center; gap: 15px; margin: 0 auto 20px; padding: 10px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); max-width: 95%; flex-wrap: wrap; }
        .toggle-item { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9em; color: var(--secondary-text); user-select: none; }
        .toggle-box { width: 18px; height: 18px; border: 2px solid #bdc3c7; border-radius: 4px; display: flex; justify-content: center; align-items: center; transition: all 0.2s ease; }
        .toggle-box .fa-check { font-size: 0.8em; color: white; opacity: 0; transform: scale(0.5); transition: all 0.2s ease; }
        .toggle-item.active .toggle-box { background-color: var(--level2-color); border-color: var(--level2-color); }
        .toggle-item.active .toggle-box .fa-check { opacity: 1; transform: scale(1); }
        .action-button { background-color: var(--level1-color); color: white; border: none; padding: 8px 16px; border-radius: 5px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; gap: 8px; }
        .action-button.excel { background-color: var(--download-btn-bg); }
        .action-button.excel:hover { background-color: var(--download-btn-hover-bg); }
        .action-button.refresh { background-color: #7f8c8d; }
        .action-button.refresh:hover { background-color: #6c7a7b; }
        
        /* Custom Multi-Select & Date Filter Styling */
        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 2px solid var(--border-color);
            margin-left: 5px;
            padding-left: 15px;
        }
        #employee-count-display {
            gap: 12px;
            font-size: 0.9em;
        }
        #employee-count-display span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-group label { font-size: 0.9em; font-weight: 500; color: var(--secondary-text); }
        .filter-group select { padding: 8px 12px; border-radius: 5px; border: 1px solid var(--border-color); font-size: 0.9em; background-color: #fff; height: 37px; box-sizing: border-box; }
        .custom-select-filter {
            position: relative;
            min-width: 150px;
        }
        .custom-select-filter .select-button {
            width: 100%; text-align: left; padding: 8px 12px; border-radius: 5px;
            border: 1px solid var(--border-color); font-size: 0.9em; background-color: #fff;
            color: var(--primary-text); cursor: pointer; display: flex; justify-content: space-between; align-items: center;
            height: 37px; box-sizing: border-box;
        }
        .custom-select-filter .select-button::after {
            content: '\f078'; font-family: 'Font Awesome 6 Free'; font-weight: 900;
            font-size: 0.8em; margin-left: 8px;
        }
        .custom-select-filter .select-dropdown {
            position: absolute; top: 105%; left: 0; width: 250px; background-color: #fff;
            border: 1px solid var(--border-color); border-radius: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 1001; display: none; padding: 8px;
        }
        .custom-select-filter.active .select-dropdown { display: block; }
        .custom-select-filter .select-search {
            width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid var(--border-color);
            border-radius: 4px; box-sizing: border-box;
        }
        .custom-select-filter .select-list { max-height: 200px; overflow-y: auto; }
        .custom-select-filter .select-list label {
            display: block; padding: 8px 10px; cursor: pointer; border-radius: 4px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .custom-select-filter .select-list label:hover { background-color: var(--hover-bg); }
        .custom-select-filter .select-list label input { margin-right: 10px; }

        /* Styles for date inputs inside the filter modal */
        .custom-date-filter .date-input-group { display: flex; align-items: center; gap: 10px; }
        .custom-date-filter .date-input-group label { font-weight: 500; min-width: 40px; color: var(--secondary-text); }
        .custom-date-filter .date-input-group input[type="date"] {
            flex-grow: 1; padding: 6px 8px; border-radius: 5px; border: 1px solid var(--border-color);
            font-size: 0.9em; color: var(--primary-text);
        }
        
        /* START: View Mode Slider CSS */
        .view-mode-toggle { display: flex; align-items: center; gap: 10px; padding: 0 15px; border-left: 2px solid var(--border-color); margin-left: 5px;}
        .view-mode-toggle > span { font-size: 0.9em; font-weight: 500; color: var(--secondary-text); }
        .switch { position: relative; display: inline-block; width: 60px; height: 34px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; }
        .slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; }
        input:checked + .slider { background-color: var(--level1-color); }
        input:focus + .slider { box-shadow: 0 0 1px var(--level1-color); }
        input:checked + .slider:before { transform: translateX(26px); }
        .slider.round { border-radius: 34px; }
        .slider.round:before { border-radius: 50%; }
        /* END: View Mode Slider CSS */

        /* Generic Modal Styles (for Filters and Downloads) */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: none; align-items: center; justify-content: center; z-index: 1000;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background-color: #fff; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            width: 90%; max-width: 650px; font-family: 'Inter', system-ui, -apple-system, sans-serif;
            display: flex; flex-direction: column;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid var(--border-color); }
        .modal-header h3 { margin: 0; font-size: 1.25rem; font-weight: 600; color: var(--level1-color); }
        .modal-close { background: none; border: none; font-size: 1.75rem; font-weight: 300; color: #666; cursor: pointer; line-height: 1; padding: 0; }
        .modal-body { padding: 24px; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 16px 24px; border-top: 1px solid var(--border-color); }
        .modal-footer button { padding: 10px 20px; border-radius: 5px; border: none; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
        .modal-footer .btn-secondary { background-color: #6c757d; color: white; }
        .modal-footer .btn-secondary:hover { background-color: #5a6268; }
        .modal-footer .btn-primary { background-color: #007bff; color: white; }
        .modal-footer .btn-primary:hover { background-color: #0069d9; }
        
        /* Specifics for Filter Modal */
        #topic-filter-modal .modal-body { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 500; color: var(--primary-text); }
        #topic-filter-modal .form-group .custom-select-filter .select-button { height: 43px; font-size: 1rem; }
        #topic-filter-modal .form-group select, #general-filter-modal select { width: 100%; padding: 10px 12px; border-radius: 5px; border: 1px solid var(--border-color); font-size: 1rem; background-color: #fff; color: var(--primary-text); height: auto; }
        #topic-filter-modal .form-group select:disabled { background-color: #f8f9fa; color: #6c757d; cursor: not-allowed; }

        /* Styles for Metric Filter Modal */
        #metric-filter-modal .modal-body {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px 24px;
        }
        #metric-filter-modal .toggle-item {
            font-size: 1rem;
        }

        /* Specifics for Download Modal */
        #download-modal .modal-body {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .download-option-group {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }
        .download-option-group h4 {
            margin: 0;
            padding: 10px 15px;
            background-color: #f8f9fa;
            font-size: 0.9rem;
            color: var(--primary-text);
            border-bottom: 1px solid var(--border-color);
        }
        .download-option-button {
            width: 100%;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            border-bottom: 1px solid #e9ecef;
            background-color: #fff;
            color: var(--primary-text);
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .download-option-group .download-option-button:last-child {
            border-bottom: none;
        }
        .download-option-button i {
            color: var(--level1-color);
            font-size: 1.5em;
            width: 1.5em;
            text-align: center;
        }
        .download-option-button:hover {
            background-color: #e9ecef;
        }
        .download-option-button div {
            display: flex;
            flex-direction: column;
        }
        .download-option-button .option-title {
            font-weight: 600;
        }
        .download-option-button .option-desc {
            font-size: 0.85em;
            color: var(--secondary-text);
        }
        
        /* START: Session History Modal Styles */
        #session-history-modal .modal-body {
            padding: 0;
        }
        #session-history-modal .modal-body .table-wrapper {
            max-height: 60vh;
            overflow-y: auto;
        }
        #session-history-modal table {
            width: 100%;
            border-collapse: collapse;
        }
        #session-history-modal th, #session-history-modal td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        #session-history-modal th {
            background-color: var(--summary-bg);
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        #session-history-modal td {
             background-color: #fff;
        }
         #session-history-modal tr:last-child td {
            border-bottom: none;
        }
        #session-history-modal a {
            color: var(--level1-color);
            text-decoration: none;
            font-weight: 500;
        }
         #session-history-modal a:hover {
            text-decoration: underline;
        }
        #session-history-modal a.disabled {
            color: var(--secondary-text);
            pointer-events: none;
            cursor: default;
        }
        /* END: Session History Modal Styles */

         /* Training Card Modal Styles */
        #training-card-modal-overlay .modal {
            max-width: 90vw;
            max-height: 90vh;
        }
        #training-card-modal-overlay .modal-body {
            padding: 0;
            overflow-y: auto;
        }
        #training-card-content {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1f2937;
            line-height: 1.5;
            font-size: 10pt;
            margin: 0;
            padding: 20pt;
            background-color: #ffffff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Table Styles */
        .table-container { max-width: 95%; margin: 20px auto 0; border: 1px solid var(--border-color); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); border-radius: 10px; max-height: 70vh; overflow-x: auto;}
        .interactive-table { width: 100%; border-collapse: collapse; background-color: #ffffff; table-layout: auto; }
        .interactive-table th, .interactive-table td { border: 1px solid var(--border-color); vertical-align: middle; padding: 12px 15px; }
        .interactive-table td:not(.hierarchy-col), .interactive-table th:not(.hierarchy-col) { min-width: 200px; }
        .hierarchy-col {
            text-align: left;
            font-weight: 600;
            position: sticky;
            left: 0;
            z-index: 5;
            min-width: 330px;
            background-color: inherit;
            transition: box-shadow 0.2s ease-in-out;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }
        .overall-summary-col {
            background-color: inherit;
            border-left: 1px solid var(--border-color);
        }
        .interactive-table thead th { position: sticky; top: 0; background-color: var(--header-bg); color: var(--light-text); z-index: 10; }
        .interactive-table thead tr:first-child th { top: 0; }
        .interactive-table thead tr:nth-child(2) th { top: 49px; }
        .interactive-table thead .hierarchy-col { z-index: 15; }
        .expandable > .hierarchy-col { cursor: pointer; display: flex; align-items: center; }
        .expand-icon { margin-right: 15px; width: 1em; display: inline-block; text-align: center; }
        .hierarchy-icon { margin-right: 10px; color: var(--icon-color); width: 1.2em; text-align: center;}
        tr[data-level="1"] > .hierarchy-col { border-left: 5px solid var(--level1-color); font-weight: 700; font-size: 1.05em; }
        tr[data-level="2"] > .hierarchy-col { border-left: 5px solid var(--level2-color); padding-left: 35px; }
        tr[data-level="3"] > .hierarchy-col { border-left: 5px solid var(--level3-color); padding-left: 55px; }
        tr.employee > .hierarchy-col { font-weight: 400; background-color: #fdfdfd; }
        tr:not(.employee):hover { background-color: var(--hover-bg); }
        tr.employee:hover { background-color: #f7f9fa; }
        tr.hidden { display: none; }
        .shrinkable-header { cursor: pointer; background-color: #4a627a; }
        .shrinkable-header:hover { background-color: #5c7a97; }
        .toggle-icon-col { margin-left: 10px; opacity: 0.8; font-size: 0.9em; }
        .summary-col { background-color: var(--summary-bg); font-weight: 600; }
        .cell-wrapper { display: flex; flex-direction: column; gap: 4px; padding: 5px 0; min-height: 70px; align-items: stretch; justify-content: center; }
        .main-visuals-wrapper.hidden { display: none; }
        .main-metric-area { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 4px; }
        .status-icon { font-size: 1.8em; line-height: 1; }
        .good-status { color: #2ecc71; }
        .warning-status { color: #f39c12; }
        .poor-status { color: #e74c3c; }
        .main-metric { font-size: 2.2em; font-weight: 700; color: var(--primary-text); line-height: 1; }
        .progress-bar-container { height: 6px; background-color: #e0e6eb; border-radius: 3px; overflow: hidden; margin: 0 10px; }
        .progress-bar-fill { height: 100%; background-color: #3498db; border-radius: 3px; transition: width 0.5s ease-in-out; }
        .details-pane { display: flex; justify-content: center; gap: 12px; row-gap: 5px; text-align: center; margin-top: 2px; flex-wrap: wrap; }
        .detail-item { display: flex; align-items: center; gap: 6px; font-size: 0.85em; color: var(--secondary-text); font-weight: 500; }
        .detail-item.hidden { display: none; }
        .detail-item i { color: var(--icon-color); font-size: 1.1em; width: 1.2em; text-align: center; }
        
        /* Employee Detail Styles */
        .employee-details-block { padding: 10px 15px; }
        .employee-header { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .employee-name { font-size: 1.1em; font-weight: 600; color: var(--level1-color); }
        .status-badge { padding: 3px 12px; border-radius: 12px; font-size: 0.8em; font-weight: 600; color: white; text-transform: uppercase; }
        .status-badge.active { background-color: #28a745; }
        .status-badge.inactive { background-color: #dc3545; }
        .employee-id-num { font-size: 0.9em; color: var(--secondary-text); margin-bottom: 12px; }
        .employee-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px 20px; font-size: 0.9em;}
        .info-item { display: flex; align-items: center; gap: 8px; }
        .info-item .fa { width: 1em; text-align: center; color: var(--icon-color); }
        tr.employee > .hierarchy-col { vertical-align: top;}
        .view-card-btn {
            font-size: 0.8em !important; padding: 2px 8px !important; margin-left: 10px !important; background-color: var(--level3-color) !important; color: var(--primary-text) !important;
        }
        
        /* START: Employee Metric Cell Styles (MODIFIED) */
        .employee-metric-cell { font-size: 0.9em; color: var(--primary-text); padding: 8px; }
        .employee-metric-cell .training-details-summary { display: flex; flex-direction: column; gap: 4px; margin-bottom: 8px; font-size: 0.95em; }
        .employee-metric-cell .training-details-summary > div { display: block; }
        .employee-metric-cell .training-details-summary i { width: 1.4em; text-align: center; color: var(--icon-color); } /* For summary cell */
        .employee-metric-cell hr { border: 0; border-top: 1px solid var(--border-color); margin: 8px 0; }
        .employee-metric-cell .competency-header { font-weight: 600; margin-bottom: 6px; text-align: left; }
        .employee-metric-cell .competency-scores { display: flex; align-items: center; justify-content: flex-start; gap: 1rem; margin-bottom: 8px; }
        .employee-metric-cell .competency-scores > span { display: inline-flex; align-items: center; gap: 6px; }
        .employee-metric-cell .competency-scores select {
            padding: 4px; border: 1px solid #ccc; border-radius: 4px;
            font-size: 0.95em; width: 55px; cursor: pointer;
            background-position: right 5px center;
        }
        .employee-metric-cell .competency-bar-container { height: 18px; background-color: #e9ecef; border-radius: 4px; overflow: hidden; }
        .employee-metric-cell .competency-bar-fill {
            height: 100%; background-color: var(--competency-bar-bg);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 600; font-size: 0.85em;
            transition: width 0.4s ease-in-out;
        }
        /* END: Employee Metric Cell Styles (MODIFIED) */

        .session-link {
            cursor: pointer;
            color: var(--level1-color);
            font-weight: 600;
            text-decoration: none;
        }
        .session-link:hover {
            text-decoration: underline;
        }

        .pagination-controls { display: flex; justify-content: space-between; align-items: center; max-width: 95%; margin: 15px auto 0; padding: 10px 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .pagination-item { display: flex; align-items: center; gap: 12px; }
        .pagination-item label { font-size: 0.9em; color: var(--secondary-text); }
        .pagination-item select, .pagination-item button { border: 1px solid var(--border-color); background-color: #fff; border-radius: 5px; padding: 8px 12px; cursor: pointer; font-size: 0.9em; color: var(--primary-text); }
        .pagination-item button { background-color: #e0e6eb; }
        .pagination-item button:hover:not(:disabled) { background-color: #d1d9e0; }
        .pagination-item button:disabled { cursor: not-allowed; opacity: 0.5; }
        #page-info { font-weight: 600; font-size: 0.9em; min-width: 100px; text-align: center;}
        
        /* --- CSS For ALL Timeline Charts --- */
        :root {
            --primary-color: #4f46e5;
            --border-color-2: #e5e7eb;
            --text-color-light: #6b7280;
            --text-color-dark: #111827;
            --background-color: #f9fafb;
            --surface-color: #ffffff;
            --attended-color: #22c55e;
            --not-attended-color: #ef4444;
            --chart-color-grid: #e0e0e0;
            --chart-color-text: #333333;
        }

        #charts-section.hidden { display: none; }
        .timeline-charts-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; max-width: 95%; margin: 20px auto; }
        @media (max-width: 1200px) { .timeline-charts-grid { grid-template-columns: 1fr; } }
        .timeline-chart-wrapper * { box-sizing: border-box; }
        .timeline-chart-wrapper { font-family: 'Inter', sans-serif; color: var(--text-color-dark); background-color: var(--surface-color); border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; }
        .timeline-chart-wrapper .chart-container { padding: 1.5rem; width: 100%; position: relative; flex-grow: 1; display: flex; flex-direction: column; }
        .timeline-chart-wrapper .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .timeline-chart-wrapper .chart-title { text-align: center; font-size: 1.2rem; font-weight: 600; margin: 0; flex-grow: 1; }
        
        .timeline-control-group { border-left: 2px solid var(--border-color); margin-left: 5px; padding-left: 15px; display: flex; align-items: center; gap: 1rem; }
        .chart-granularity-selector { display: flex; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; background-color: #f3f4f6; }
        .chart-granularity-selector button { text-transform: capitalize; background: none; border: none; padding: 0.4rem 0.8rem; font-size: 0.9em; font-weight: 500; cursor: pointer; color: var(--secondary-text); transition: all 0.2s; height: 37px; box-sizing: border-box; }
        .chart-granularity-selector button:not(:last-child) { border-right: 1px solid var(--border-color); }
        .chart-granularity-selector button.active { background-color: var(--surface-color); color: var(--level1-color); box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-weight: 600; }
        .timeline-period-control { display: flex; align-items: center; gap: 0.5rem; }
        .timeline-period-control label { font-size: 0.9em; font-weight: 500; color: var(--secondary-text); }
        .timeline-period-control input { width: 60px; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 8px; text-align: center; font-size: 0.9em; height: 37px; box-sizing: border-box; }
        .timeline-period-control button { padding: 0.4rem 0.6rem; height: 37px; }
        
        .timeline-chart-wrapper .chart-area { display: grid; grid-template-columns: auto 1fr auto; gap: 10px; padding-bottom: 15px; flex-grow: 1; }
        .timeline-chart-wrapper .y-axis { display: flex; flex-direction: column; text-align: right; font-size: 0.8rem; height: auto; position: sticky; background-color: var(--surface-color); }
        .timeline-chart-wrapper .y-axis.y-axis-left { padding-right: 10px; left: 0; z-index: 15; justify-content: space-between; height: 100%; }
        .timeline-chart-wrapper .y-axis .axis-title { font-size: 0.9rem; font-weight: 700; color: var(--primary-color); text-align: center; padding-bottom: 5px; height: 20px; line-height: 20px; }
        .timeline-chart-wrapper .y-axis .axis-labels { display: flex; flex-direction: column; justify-content: space-between; height: 100%; text-align: left; }
        .timeline-chart-wrapper .plot-area { position: relative; height: 250px; border-left: 1px solid var(--chart-color-grid); border-right: 1px solid var(--chart-color-grid); }
        .timeline-chart-wrapper .chart-canvas { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 12; }
        .timeline-chart-wrapper .grid-lines { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: space-between; }
        .timeline-chart-wrapper .grid-line { width: 100%; height: 1px; background-color: var(--chart-color-grid); }
        .timeline-chart-wrapper .grid-line:last-child { background-color: var(--chart-color-text); }
        .timeline-chart-wrapper .bars-container { position: relative; z-index: 10; display: flex; justify-content: space-around; align-items: flex-end; height: 100%; }
        .timeline-chart-wrapper .bar-wrapper { flex: 1; height: 100%; display: flex; justify-content: center; align-items: flex-end; }
        .timeline-chart-wrapper .bar { height: 100%; display: flex; flex-direction: column-reverse; }
        .timeline-chart-wrapper .segment { position: relative; width: 100%; transition: height 0.3s ease-in-out; border-radius: 4px 4px 0 0; }
        .timeline-chart-wrapper .segment-label { color: white; font-size: 0.75rem; font-weight: bold; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none; text-shadow: 1px 1px 2px rgba(0,0,0,0.7); }
        .timeline-chart-wrapper .bar-totals-container { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: space-around; pointer-events: none; z-index: 11; }
        .timeline-chart-wrapper .bar-total-wrapper { flex: 1; position: relative; }
        .timeline-chart-wrapper .bar-total-wrapper span { position: absolute; left: 50%; transform: translateX(-50%); bottom: 0; font-weight: 700; font-size: 0.8rem; color: var(--text-color-dark); padding-bottom: 4px; }
        .timeline-chart-wrapper .attended-bar { background-color: var(--attended-color); }
        .timeline-chart-wrapper .not-attended-bar { background-color: var(--not-attended-color); }
        
        .timeline-chart-wrapper .x-axis { grid-column: 2 / 3; }
        .timeline-chart-wrapper .x-axis-labels { display: flex; justify-content: space-around; padding: 8px 0 0 0; min-height: 70px; border-top: 1px solid var(--chart-color-text); }
        .timeline-chart-wrapper .x-axis-period-group { flex: 1; display: flex; justify-content: space-around; border-left: 1px dashed #ccc; padding: 0 5px; }
        .timeline-chart-wrapper .x-axis-period-group:first-child { border-left: none; }
        .timeline-chart-wrapper .x-axis-hierarchy-label { flex: 1; font-size: 0.85em; color: var(--secondary-text); padding: 0 2px; line-height: 1.2; }
        .timeline-chart-wrapper .x-axis-hierarchy-label span { display: block; text-align: center; }
        .label-hierarchy-main { font-weight: 600; color: var(--primary-text); }
        .label-hierarchy-parent { font-size: 0.9em; }
        .label-period-month, .label-period-year { color: var(--text-color-light); font-size: 0.9em; }

        .timeline-chart-wrapper .legend { display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 1.5rem; font-size: 0.9rem; flex-wrap: wrap; }
        .timeline-chart-wrapper .legend-item { display: flex; align-items: center; gap: 8px; transition: opacity 0.2s; user-select: none;}
        .timeline-chart-wrapper .legend-item.interactive { cursor: pointer; }
        .timeline-chart-wrapper .legend-item.inactive { opacity: 0.4; text-decoration: line-through; }
        .timeline-chart-wrapper .legend-key { width: 15px; height: 15px; border-radius: 3px; }
        .timeline-chart-wrapper .chart-no-data-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: center; color: var(--text-color-light); font-size: 1.1rem; font-weight: 500; z-index: 20; }
        
        .chart-download-options { position: relative; }
        .chart-download-options .download-btn { padding: 0.5rem 0.8rem; border: 1px solid var(--border-color); border-radius: 6px; background-color: #fff; cursor: pointer; }
        .chart-download-options:hover .download-dropdown { display: block; }
        .chart-download-options .download-dropdown { display: none; position: absolute; top: 100%; right: 0; background-color: #fff; border: 1px solid var(--border-color); border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 100; overflow: hidden; }
        .chart-download-options .download-dropdown a { display: block; padding: 0.75rem 1.25rem; color: var(--primary-text); text-decoration: none; font-size: 0.9em; white-space: nowrap; }
        .chart-download-options .download-dropdown a:hover { background-color: var(--hover-bg); }

        /* --- CSS for Role-Wise Chart --- */
        #role-wise-chart-wrapper .role-chart-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Make it fill the wrapper space */
        }
        #role-wise-chart-wrapper .role-chart-grid {
            display: flex;
            position: relative;
            height: 320px;
        }
        #role-wise-chart-wrapper .role-y-axis { display: flex; flex-direction: column-reverse; justify-content: space-between; padding-right: 15px; color: #595959; font-size: 0.8em; text-align: right; flex-shrink: 0; }
        #role-wise-chart-wrapper .role-y-axis-right { display: flex; flex-direction: column-reverse; justify-content: space-between; padding-left: 15px; color: #c0392b; font-size: 0.8em; font-weight: 600; text-align: left; flex-shrink: 0; }
        #role-wise-chart-wrapper .role-chart-area {
            flex-grow: 1;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            position: relative;
            border-bottom: 1px solid #c9c9c9;
            background-image: repeating-linear-gradient( to top, #e0e0e0, #e0e0e0 1px, transparent 1px, transparent calc(100% / 8) );
            background-size: 100% 100%;
        }
        #role-wise-chart-wrapper .role-chart-line-canvas { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 5; }
        #role-wise-chart-wrapper .role-bar-group { flex: 1; display: flex; justify-content: space-around; height: 100%; align-items: flex-end; padding: 0 5%; z-index: 2; position: relative; }
        #role-wise-chart-wrapper .role-bar-stack { display: flex; flex-direction: column; width: 60%; max-width: 70px; height: 100%; justify-content: flex-end; }
        #role-wise-chart-wrapper .role-bar-segment { width: 100%; display: flex; justify-content: center; align-items: center; color: white; font-size: 0.9em; font-weight: 500; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); transition: all 0.3s ease-in-out; box-sizing: border-box; border: 1px solid rgba(0,0,0,0.1); }
        #role-wise-chart-wrapper .role-bar-stack:hover .role-bar-segment { opacity: 0.85; transform: scale(1.02); }
        #role-wise-chart-wrapper .role-x-axis { display: flex; padding-left: 30px; padding-right: 30px; padding-top: 5px; color: #595959; }
        #role-wise-chart-wrapper .role-x-axis-group { flex: 1; text-align: center; padding: 5px 0px; border-left: 1px dashed #c9c9c9; }
        #role-wise-chart-wrapper .role-x-axis-group:first-child { border-left: none; }
        /* START: MODIFICATION FOR ROLE-WISE CHART X-AXIS */
        #role-wise-chart-wrapper .role-x-axis-main-label {
            font-size: 0.9em;
            padding: 5px;
            margin: 0 5px;
            line-height: 1.3;
        }
        #role-wise-chart-wrapper .role-x-axis-main-label span {
            display: block;
            text-align: center;
        }
        #role-wise-chart-wrapper .role-x-axis-main-label .label-hierarchy-main {
            font-weight: 600;
            color: var(--primary-text);
        }
        #role-wise-chart-wrapper .role-x-axis-main-label .label-hierarchy-parent {
            font-size: 0.9em;
            color: var(--secondary-text);
        }
        #role-wise-chart-wrapper .role-x-axis-main-label .label-period-month {
            color: var(--text-color-light);
            font-weight: 500;
        }
        /* END: MODIFICATION FOR ROLE-WISE CHART X-AXIS */
        #role-wise-chart-wrapper .role-x-axis-period-labels { display: flex; justify-content: space-around; width: 100%; padding-top: 5px; }
        #role-wise-chart-wrapper .role-x-axis-period-label { flex: 1; text-align: center; font-size: 0.8em; }
        #role-wise-chart-wrapper .role-group-separator { border-left: 1px dashed #c9c9c9; }
        #role-wise-chart-wrapper .role-legend-key-line { width: 18px; height: 1px; border-top: 3px solid; background: none !important; border-radius: 0 !important; display: inline-block; vertical-align: middle; }
        #role-wise-chart-wrapper .role-chart-no-data-overlay { position: absolute; inset: 0; background: rgba(255, 255, 255, 0.8); display: flex; align-items: center; justify-content: center; color: var(--text-color-light); font-size: 1.1rem; font-weight: 500; z-index: 20; }
    </style>
     <style id="training-card-dynamic-styles"></style>

    <!-- ================================================================== -->
    <!-- ========= START: RESPONSIVE AND MOBILE-FIRST STYLES ========== -->
    <!-- ================================================================== -->
    <style>
        /* 
         * This section defines the responsive behavior of the dashboard.
         * It uses a "mobile-first" approach, where the default styles are for mobile
         * and are then overridden for larger screens.
         */

        .mobile-only { display: none; }
        .mobile-flex-group { display: none; }

        /* For Tablets and smaller desktops */
        @media (max-width: 992px) {
            body {
                padding: 15px;
            }
            .dashboard-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 15px;
            }
            /* Hide desktop-specific elements */
            .desktop-only { display: none; }
            /* Show mobile-specific elements */
            .mobile-only {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
            }
            .mobile-only .action-button {
                flex-grow: 1; /* Make buttons take up space */
                justify-content: center;
            }
            
            .filter-group, .view-mode-toggle, .timeline-control-group {
                border-left: none;
                padding-left: 0;
                margin-left: 0;
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
            .hierarchy-col { min-width: 280px; }
            .timeline-chart-wrapper .chart-header {
                flex-direction: column;
                align-items: center;
            }
            .timeline-chart-wrapper .chart-container { padding: 1rem; }
            #role-wise-chart-wrapper .role-x-axis {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        /* 
         * START: REDESIGNED RESPONSIVE TABLE FOR SMALLER SCREENS 
         * This is the core of the new responsive table design.
        */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                font-size: 14px; /* Adjust base font size */
            }
            h1 { font-size: 1.6rem; margin-bottom: 15px; }
            .table-container { 
                max-width: 100%;
                border: none;
                box-shadow: none;
                overflow-x: hidden; /* Prevent main page scroll */
            }
            
            .interactive-table {
                display: block;
                border: none;
            }
            .interactive-table thead {
                display: none; /* Hide desktop headers */
            }
            .interactive-table tbody {
                display: block;
            }
            .interactive-table tr {
                display: flex; /* Use flexbox for the row layout */
                border: 1px solid var(--border-color);
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                margin-bottom: 1rem;
                overflow: hidden; /* Important for border-radius */
            }
            /* The hierarchy column is now a flex item, not a table-cell */
            .interactive-table .hierarchy-col {
                position: static; /* Remove sticky positioning */
                width: 100%; /* Take full width within its flex container */
                flex-shrink: 0; /* Prevent it from shrinking */
                border-bottom: 1px solid var(--border-color);
                box-shadow: none;
                background-color: #f8f9fa;
            }
            /* The container for all horizontally scrollable metric cells */
            .metrics-scroll-container {
                display: flex;
                overflow-x: auto; /* Enable horizontal scrolling */
                -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
                width: 100%;
            }
            .metrics-scroll-container::-webkit-scrollbar {
                height: 5px;
            }
            .metrics-scroll-container::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 5px;
            }
            .interactive-table td {
                display: block; /* Ensures cells behave as blocks */
                border: none;
                border-left: 1px solid var(--border-color);
                padding: 12px 15px;
            }
            .interactive-table .hierarchy-col,
            .interactive-table .metrics-scroll-container {
                display: block; /* Stack hierarchy and metrics vertically */
                width: 100%;
            }
            .interactive-table td:first-child {
                border-left: none;
            }

            .employee-info-grid { grid-template-columns: 1fr; gap: 8px; }
            .employee-header { flex-wrap: wrap; gap: 8px; }

            .main-metric { font-size: 2em; }
            .status-icon { font-size: 1.6em; }
            .details-pane { gap: 10px; }
            .detail-item { font-size: 0.8em; }

            .pagination-controls { flex-direction: column; gap: 15px; max-width: 100%; }
            .pagination-item { width: 100%; justify-content: center; }

            #topic-filter-modal .modal-body { grid-template-columns: 1fr; gap: 20px; }
            .modal { width: 95%; max-width: 500px; }
            
            .timeline-chart-wrapper .chart-title { font-size: 1.1rem; }
            .timeline-chart-wrapper .x-axis-hierarchy-label .label-hierarchy-parent {
                display: none; /* Hide parent label to save space */
            }

            .mobile-flex-group {
                display: flex;
                width: 100%;
                gap: 10px;
            }
             .mobile-flex-group .action-button {
                flex: 1; /* Each takes 50% width */
                font-size: 0.85em;
                padding: 10px 8px;
            }
        }
        /* END: REDESIGNED RESPONSIVE TABLE */

        /* For standard mobile phones */
        @media (max-width: 576px) {
            h1 { font-size: 1.4rem; }
            .dashboard-controls { gap: 15px; }

            .employee-name { font-size: 1em; }
            .status-badge { padding: 2px 8px; font-size: 0.75em; }

            .timeline-control-group {
                flex-direction: column;
                width: 100%;
                align-items: stretch;
            }
            .chart-granularity-selector { width: 100%; justify-content: center; }
            .chart-granularity-selector button { flex-grow: 1; }
            .timeline-period-control { justify-content: center; }
            .download-option-button { flex-direction: column; align-items: flex-start; text-align: left; }
            .download-option-button i { margin-bottom: 5px; }
        }
    </style>
    <!-- ================================================================ -->
    <!-- ========= END: RESPONSIVE AND MOBILE-FIRST STYLES ========== -->
    <!-- ================================================================ -->
</head>
<body>
    <h1>Hierarchical Training Dashboard</h1>
    <div id="dashboard-container"></div>

    <!-- START: Training Topic Filter Modal HTML -->
    <div id="topic-filter-modal-overlay" class="modal-overlay">
        <div id="topic-filter-modal" class="modal">
            <div class="modal-header">
                <h3>Training Topic Filters</h3>
                <button class="modal-close" data-action="close-topic-filter">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Training Topic:</label>
                    <div id="modal-topic-filter" class="custom-select-filter" data-filter-type="topic">
                        <button class="select-button" data-action="toggle-select-dropdown"></button>
                        <div class="select-dropdown">
                            <input type="text" class="select-search" placeholder="Search Topics...">
                            <div class="select-list"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Training Sub-Topic:</label>
                     <div id="modal-subtopic-filter" class="custom-select-filter" data-filter-type="subtopic">
                        <button class="select-button" data-action="toggle-select-dropdown"></button>
                        <div class="select-dropdown">
                            <input type="text" class="select-search" placeholder="Search Sub-Topics...">
                            <div class="select-list"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="filter-proficiency-target">Proficiency Target:</label>
                    <select id="filter-proficiency-target">
                        <option value="">-- Select --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" data-action="clear-topic-filter">Clear</button>
                <button class="btn-primary" data-action="apply-topic-filter">Apply & Close</button>
            </div>
        </div>
    </div>
    <!-- END: Training Topic Filter Modal HTML -->
    
    <!-- START: Period Filter Modal HTML -->
    <div id="period-filter-modal-overlay" class="modal-overlay">
        <div id="period-filter-modal" class="modal">
            <div class="modal-header">
                <h3>Period Filters</h3>
                <button class="modal-close" data-action="close-period-filter">×</button>
            </div>
            <div class="modal-body">
                <div class="download-option-group">
                    <h4>Training Period</h4>
                    <div class="custom-date-filter" style="padding: 15px;">
                         <div class="date-input-group"><label for="filter-training-from">From:</label><input type="date" id="filter-training-from"></div>
                         <div class="date-input-group"><label for="filter-training-to">To:</label><input type="date" id="filter-training-to"></div>
                    </div>
                </div>
                <div class="download-option-group">
                    <h4>Joining Period</h4>
                    <div class="custom-date-filter" style="padding: 15px;">
                         <div class="date-input-group"><label for="filter-joining-from">From:</label><input type="date" id="filter-joining-from"></div>
                         <div class="date-input-group"><label for="filter-joining-to">To:</label><input type="date" id="filter-joining-to"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" data-action="clear-period-filter">Clear All</button>
                <button class="btn-primary" data-action="apply-period-filter">Apply & Close</button>
            </div>
        </div>
    </div>
    <!-- END: Period Filter Modal HTML -->

    <!-- START: Download Options Modal HTML -->
    <div id="download-modal-overlay" class="modal-overlay">
        <div id="download-modal" class="modal" style="max-width: 550px;">
            <div class="modal-header">
                <h3>Download Full Report</h3>
                <button class="modal-close" data-action="close-download-modal">×</button>
            </div>
            <div class="modal-body">
                <div class="download-option-group">
                    <h4>Summary Report</h4>
                    <button class="download-option-button" data-action="download-summary">
                        <i class="fas fa-sitemap"></i>
                        <div>
                            <span class="option-title">Full Summary Report</span>
                            <span class="option-desc">Exports the hierarchical summary and chart data based on active filters.</span>
                        </div>
                    </button>
                </div>
                <div class="download-option-group">
                    <h4>Detailed Employee Trackers</h4>
                     <button class="download-option-button" data-action="download-tracker-dates">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <span class="option-title">Tracker - Attendance Dates</span>
                            <span class="option-desc">Exports attendance dates for all employees matching filters.</span>
                        </div>
                    </button>
                    <button class="download-option-button" data-action="download-tracker-competency">
                        <i class="fas fa-star-half-alt"></i>
                        <div>
                            <span class="option-title">Tracker - Competency Scores</span>
                            <span class="option-desc">Exports competency scores for all employees matching filters.</span>
                        </div>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" data-action="close-download-modal">Close</button>
            </div>
        </div>
    </div>
    <!-- END: Download Options Modal HTML -->
    
    <!-- START: Session History Modal HTML -->
    <div id="session-history-modal-overlay" class="modal-overlay">
        <div id="session-history-modal" class="modal" style="max-width: 700px;">
            <div class="modal-header">
                <h3 id="session-history-title">Session History</h3>
                <button class="modal-close" data-action="close-session-history">×</button>
            </div>
            <div class="modal-body">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Session Date</th>
                                <th>Certificate</th>
                                <th>Training Sheet</th>
                            </tr>
                        </thead>
                        <tbody id="session-history-table-body">
                            <!-- Rows will be injected here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
             <div class="modal-footer">
                <button class="btn-secondary" data-action="close-session-history">Close</button>
            </div>
        </div>
    </div>
    <!-- END: Session History Modal HTML -->

    <!-- START: Training Card Modal HTML -->
    <div id="training-card-modal-overlay" class="modal-overlay">
        <div id="training-card-modal" class="modal">
            <div class="modal-header">
                <h3>Employee Training Card</h3>
                <button class="modal-close" data-action="close-training-card">×</button>
            </div>
            <div class="modal-body">
                <div id="training-card-content">
                    <!-- The HTML provided by the user will be injected here -->
                </div>
            </div>
             <div class="modal-footer">
                <button class="btn-secondary" data-action="close-training-card">Close</button>
                <button class="btn-primary" data-action="download-training-card">Download Card</button>
            </div>
        </div>
    </div>
    <!-- END: Training Card Modal HTML -->

    <!-- START: General Filter Modal HTML (for mobile) -->
    <div id="general-filter-modal-overlay" class="modal-overlay">
        <div id="general-filter-modal" class="modal">
            <div class="modal-header">
                <h3>General Filters</h3>
                <button class="modal-close" data-action="close-general-filter">×</button>
            </div>
            <div class="modal-body">
                <!-- Content will be injected by JS -->
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" data-action="clear-general-filter">Clear Filters</button>
                <button class="btn-primary" data-action="close-general-filter">Apply & Close</button>
            </div>
        </div>
    </div>
    <!-- END: General Filter Modal HTML -->

    <!-- START: Metric Filter Modal HTML (for mobile) -->
    <div id="metric-filter-modal-overlay" class="modal-overlay">
        <div id="metric-filter-modal" class="modal" style="max-width: 450px;">
            <div class="modal-header">
                <h3>Display Metrics</h3>
                <button class="modal-close" data-action="close-metric-filter">×</button>
            </div>
            <div class="modal-body">
                 <!-- Content will be injected by JS -->
            </div>
            <div class="modal-footer">
                <button class="btn-primary" data-action="close-metric-filter">Done</button>
            </div>
        </div>
    </div>
    <!-- END: Metric Filter Modal HTML -->

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        
        let roleChartVisibility = {}; 
        // START: MODIFICATION - Added a variable to store the table's scroll position.
        // This helps restore the view after a data update, improving user experience.
        let lastScrollState = null;
        // END: MODIFICATION

        // --- START: CHART LOGIC ---
        let chartDataCache = null;
        function initializeAllCharts() {

            // Define configurations for all bar chart metrics
            const barMetricConfig = {
                // For Hours Chart
                actualHours: { key: 'actualHours', label: 'Actual Hrs', color: '#8b5cf6', format: v => v.toFixed(1) },
                targetHours: { key: 'targetHours', label: 'Target Hrs', color: '#f97316', format: v => v.toFixed(1) },
                // For Averages Chart
                avgTraining: { key: 'avgTraining', label: 'Avg Training/Emp', color: '#ffc107', format: v => v.toFixed(1) },
                avgHours: { key: 'avgHours', label: 'Avg Hrs/Emp', color: '#e83e8c', format: v => v.toFixed(1) },
            };

            const visibilityState = {
                summaryBar: { attended: true, notAttended: true },
                hierarchy: {} // State for toggling hierarchy bar groups
            };
            
            /**
             * Returns the financial year string (e.g., "2024-2025") for a given date.
             * The financial year runs from April 1 to March 31.
             * @param {Date} d The input date object.
             * @returns {string} The financial year string.
             */
            function getFinancialYearKey(d) {
                const year = d.getUTCFullYear();
                const month = d.getUTCMonth(); // 0 = January, 3 = April
                if (month >= 3) { // April or later, it's the start of a new financial year
                    return `${year}-${year + 1}`;
                } else { // Before April (Jan, Feb, Mar), it's part of the previous financial year
                    return `${year - 1}-${year}`;
                }
            }
            
            function getStartOfWeek(d) { const date = new Date(d); const day = date.getUTCDay(); const diff = date.getUTCDate() - day + (day === 0 ? -6 : 1); return new Date(date.setUTCDate(diff)); }

            function getPeriodKey(dateString, granularity) { 
                if (!dateString) return null; 
                // Handles "YYYY-MM-DD" or "YYYY-MM-DD HH:mm:ss"
                const d = new Date(dateString.substring(0, 10) + 'T00:00:00Z'); 
                if (isNaN(d.getTime())) return null; 
                const year = d.getUTCFullYear(); 
                const month = String(d.getUTCMonth() + 1).padStart(2, '0'); 
                const day = String(d.getUTCDate()).padStart(2, '0'); 
                switch(granularity) { 
                    case 'daily': return `${year}-${month}-${day}`; 
                    case 'weekly': const startOfWeek = getStartOfWeek(d); const wYear = startOfWeek.getUTCFullYear(); const wMonth = String(startOfWeek.getUTCMonth() + 1).padStart(2, '0'); const wDay = String(startOfWeek.getUTCDate()).padStart(2, '0'); return `${wYear}-${wMonth}-${wDay}`; 
                    case 'monthly': return `${year}-${month}`; 
                    case 'yearly': return getFinancialYearKey(d);
                    default: return null; 
                } 
            }

            function getChartTimeline(granularity, periods) {
                const keys = [];
                let current = new Date(); current.setUTCHours(12);
                const numPeriods = Math.min(Math.max(periods, 1), 12);
                for (let i = 0; i < numPeriods; i++) {
                    const key = getPeriodKey(current.toISOString().slice(0, 10), granularity);
                    // This check prevents adding duplicate keys if the loop steps within the same financial year.
                    if (keys.length === 0 || keys[keys.length - 1] !== key) {
                        keys.push(key);
                    }
                    switch (granularity) {
                        case 'daily': current.setUTCDate(current.getUTCDate() - 1); break;
                        case 'weekly': current.setUTCDate(current.getUTCDate() - 7); break;
                        case 'monthly': current.setUTCDate(1); current.setUTCMonth(current.getUTCMonth() - 1); break;
                        case 'yearly': current.setUTCFullYear(current.getUTCFullYear() - 1); break;
                    }
                }
                keys.reverse();
                const labels = keys.map(key => { if (granularity === 'daily') return new Date(key + 'T00:00:00Z').toLocaleDateString('en-US', { timeZone: 'UTC', month: 'short', day: 'numeric' }); if (granularity === 'weekly') return `W/C ${new Date(key + 'T00:00:00Z').toLocaleDateString('en-US', { timeZone: 'UTC', month: 'short', day: 'numeric' })}`; if (granularity === 'monthly') { const [year, month] = key.split('-'); return new Date(Date.UTC(year, month - 1, 2)).toLocaleString('default', { timeZone: 'UTC', month: 'short', year: '2-digit' }); } if (granularity === 'yearly') return key; return key; });
                return { keys, labels };
            }
            
            function calculateSummaryForPeriod(nodes, periodRange) {
                const summary = { metrics: {} };
                const employeeNodes = getAllNodesByType(nodes, 'employee');
                employeeNodes.forEach(node => {
                    const globalDateFilteredMetrics = filterMetricsByDate(node.metrics, state.ui.filters.dateRange);
                    const topicFilteredMetrics = filterMetrics(globalDateFilteredMetrics, state.ui.filters.topicFilters);
                    for (const topicKey in topicFilteredMetrics) {
                        const subtopicMetrics = topicFilteredMetrics[topicKey].filter(metric => {
                            if (!metric.date) return false;
                            const metricDate = parseDateTime(metric.date);
                            if (!metricDate) return false;
                            return metricDate >= periodRange.start && metricDate <= periodRange.end;
                        });
                        if (subtopicMetrics.length > 0) {
                            if (!summary.metrics[topicKey]) summary.metrics[topicKey] = [];
                            subtopicMetrics.forEach(metric => {
                                let existing = summary.metrics[topicKey].find(m => m.name === metric.name);
                                if (!existing) {
                                    existing = { name: metric.name, attended: 0, total: 0, actualHours: 0, targetHours: 0 };
                                    summary.metrics[topicKey].push(existing);
                                }
                                existing.attended += metric.attended;
                                existing.total += metric.total;
                                existing.actualHours += metric.actualHours;
                                existing.targetHours += metric.targetHours;
                            });
                        }
                    }
                });
                return summary;
            }

            function calculateTimelineChartData() {
                const allEmployeesInView = getUnpaginatedFilteredEmployeesForExport();
                const { nodesForTable } = getFilteredData(state.rawData, state.ui.filters);
                if (!nodesForTable || nodesForTable.length === 0 || allEmployeesInView.length === 0) return null;

                let chartLevel = '';
                let baseGroupNodes;
                const topLevelNodeType = nodesForTable[0].type;
                switch (topLevelNodeType) {
                    case 'corporate': chartLevel = 'region'; baseGroupNodes = nodesForTable[0].children || []; break;
                    case 'region': chartLevel = 'unit'; baseGroupNodes = nodesForTable.flatMap(r => r.children || []); break;
                    case 'unit': chartLevel = 'department'; baseGroupNodes = nodesForTable.flatMap(u => u.children || []); break;
                    default: chartLevel = 'topic'; baseGroupNodes = []; break;
                }
                
                const granularity = document.querySelector('#summary-chart-wrapper .chart-granularity-selector .active').dataset.granularity;
                const periods = parseInt(document.querySelector('#summary-chart-wrapper .timeline-periods-input').value, 10) || 2;
                const timeline = getChartTimeline(granularity, periods);
                
                const aggregatedData = {};
                const allRelevantGroupLabels = new Set();
                
                timeline.keys.forEach((periodKey) => { 
                    aggregatedData[periodKey] = {};
                    let periodStart, periodEnd;
                    if (granularity === 'yearly') { 
                        const [startYear, endYear] = periodKey.split('-').map(Number);
                        periodStart = new Date(Date.UTC(startYear, 3, 1)); // April 1st
                        periodEnd = new Date(Date.UTC(endYear, 3, 0, 23, 59, 59)); // March 31st
                    } 
                    else { 
                        periodStart = new Date(periodKey + 'T00:00:00Z'); 
                        if (granularity === 'monthly') { periodEnd = new Date(periodStart.getFullYear(), periodStart.getUTCMonth() + 1, 0, 23, 59, 59); } 
                        else if (granularity === 'weekly') { periodEnd = new Date(periodStart.getTime() + 6 * 24 * 60 * 60 * 1000); periodEnd.setUTCHours(23, 59, 59); } 
                        else { periodEnd = new Date(periodStart); periodEnd.setUTCHours(23, 59, 59); } 
                    }
                    
                    if (chartLevel === 'topic') {
                        const { topic: selectedTopicsFromFilter } = state.ui.filters.topicFilters;
                        const topicsInPeriod = Object.keys(calculateSummaryForPeriod(nodesForTable, {start: periodStart, end: periodEnd}).metrics);
                         (selectedTopicsFromFilter.length > 0 ? selectedTopicsFromFilter.filter(t => topicsInPeriod.includes(t)) : topicsInPeriod).forEach(topic => {
                             allRelevantGroupLabels.add(topic);
                             const topicSummary = calculateSummaryForPeriod(nodesForTable, { start: periodStart, end: periodEnd });
                             const metrics = topicSummary.metrics[topic] || [];
                             aggregatedData[periodKey][topic] = metrics.reduce((acc, m) => { acc.attended += m.attended; acc.total += m.total; acc.actualHours += m.actualHours; acc.targetHours += m.targetHours; return acc; }, { attended: 0, total: 0, actualHours: 0, targetHours: 0 });
                         });
                    } else {
                        const potentialGroupLabels = [...new Set(baseGroupNodes.map(node => getContextualName(node)))].sort();
                        potentialGroupLabels.forEach(label => {
                            allRelevantGroupLabels.add(label);
                            let nodesForGroup = baseGroupNodes.filter(n => getContextualName(n) === label);
                            const summaryForGroupInPeriod = calculateSummaryForPeriod(nodesForGroup, { start: periodStart, end: periodEnd });
                            const metrics = Object.values(summaryForGroupInPeriod.metrics).flat();
                            aggregatedData[periodKey][label] = metrics.reduce((acc, m) => { acc.attended += m.attended; acc.total += m.total; acc.actualHours += m.actualHours; acc.targetHours += m.targetHours; return acc; }, { attended: 0, total: 0, actualHours: 0, targetHours: 0 });
                        });
                    }
                });

                const groupLabels = [...allRelevantGroupLabels].sort();
                const barChartDataSets = {};
                
                groupLabels.forEach(label => {
                    barChartDataSets[label] = {};
                    Object.keys(barMetricConfig).forEach(key => { barChartDataSets[label][key] = {}; });
                     
                    const nodesForGroup = (chartLevel === 'topic') ? nodesForTable.filter(n => getContextualName(n) === label) : baseGroupNodes.filter(n => getContextualName(n) === label);
                    const groupEmployees = getAllNodesByType(nodesForGroup, 'employee');
                    const groupEmployeeCount = new Set(groupEmployees.map(e => e.id)).size;

                    timeline.keys.forEach(periodKey => {
                        const groupData = aggregatedData[periodKey][label] || { actualHours: 0, targetHours: 0, attended: 0, total: 0 };
                        
                        barChartDataSets[label].actualHours[periodKey] = groupData.actualHours;
                        barChartDataSets[label].targetHours[periodKey] = groupData.targetHours;
                        barChartDataSets[label].avgTraining[periodKey] = groupEmployeeCount > 0 ? (groupData.attended / groupEmployeeCount) : 0;
                        barChartDataSets[label].avgHours[periodKey] = groupEmployeeCount > 0 ? (groupData.actualHours / groupEmployeeCount) : 0;
                        
                    });
                });
                
                const maxTotalInBar = Math.max(...Object.values(aggregatedData).flatMap(periodData => Object.values(periodData).map(group => group.total)));
                
                return {
                    timeline, aggregatedData, barChartDataSets, groupLabels,
                    yAxisBarCeiling: maxTotalInBar > 0 ? Math.ceil(maxTotalInBar * 1.2 / 5) * 5 || 5 : 5
                };
            }
            
            function renderStackedBarChart(data) {
                const containerId = 'summary-chart';
                const container = document.getElementById(`${containerId}-container`);
                const barsContainer = container.querySelector(`#${containerId}-bars-container`);
                const barTotalsContainer = container.querySelector(`#${containerId}-bar-totals-container`);
                const labelsAxis = container.querySelector(`#${containerId}-xaxis-labels`);
                const yAxisLeft = container.querySelector(`#${containerId}-yaxis`);
                const gridLines = container.querySelector(`#${containerId}-grid-lines`);
                const noDataOverlay = container.querySelector(`#${containerId}-no-data-overlay`);
                const legendContainer = container.querySelector(`#${containerId}-legend`);
                [barsContainer, barTotalsContainer, labelsAxis, yAxisLeft, gridLines, legendContainer].forEach(el => { if(el) el.innerHTML = '' });

                if (!data || !data.groupLabels || data.groupLabels.length === 0) { noDataOverlay.style.display = 'flex'; return; }
                noDataOverlay.style.display = 'none';

                const { timeline, aggregatedData, groupLabels, yAxisBarCeiling } = data;

                // Initialize visibility state for any new groups
                groupLabels.forEach(label => {
                    if (visibilityState.hierarchy[label] === undefined) {
                        visibilityState.hierarchy[label] = true;
                    }
                });

                const visibleGroupLabels = groupLabels.filter(label => visibilityState.hierarchy[label]);

                yAxisLeft.innerHTML = ''; for (let i = 5; i >= 0; i--) { const val = (yAxisBarCeiling / 5) * i; yAxisLeft.innerHTML += `<span>${Number.isInteger(val) ? val : val.toFixed(1)}</span>`; }
                gridLines.innerHTML = ''; for (let i = 0; i <= 5; i++) { gridLines.innerHTML += `<div class="grid-line"></div>`; }
                
                let barsHTML = '', totalsHTML = '', labelsHTML = '';
                
                visibleGroupLabels.forEach(label => {
                    let hierarchyGroupHtml_XAxis = ''; // For the x-axis labels of this group

                    timeline.keys.forEach((periodKey, periodIndex) => {
                        const overall = aggregatedData[periodKey]?.[label] || { total: 0, attended: 0 };
                        const notAttended = overall.total - overall.attended;
                        
                        // START FIX: Calculate heights and totals based on visibility state
                        const attendedHeight = visibilityState.summaryBar.attended && yAxisBarCeiling > 0 ? (overall.attended / yAxisBarCeiling) * 100 : 0;
                        const notAttendedHeight = visibilityState.summaryBar.notAttended && yAxisBarCeiling > 0 ? (notAttended / yAxisBarCeiling) * 100 : 0;
                        const visibleTotal = (visibilityState.summaryBar.attended ? overall.attended : 0) + (visibilityState.summaryBar.notAttended ? notAttended : 0);
                        const totalHeight = yAxisBarCeiling > 0 ? (visibleTotal / yAxisBarCeiling) * 100 : 0;
                        // END FIX

                        const tooltip = `${label} - ${timeline.labels[periodIndex]}\nTotal Mandates: ${overall.total}\nAttended: ${overall.attended}\nMissed: ${notAttended}`;
                        
                        let segmentsHTML = '';
                        // START FIX: Conditionally add segments to the HTML
                        if (visibilityState.summaryBar.attended) {
                            segmentsHTML += `<div class="segment attended-bar" style="height: ${attendedHeight}%;" data-tooltip="${tooltip}">${attendedHeight > 5 ? `<span class="segment-label">${overall.attended}</span>` : ''}</div>`;
                        }
                        if (visibilityState.summaryBar.notAttended) {
                            segmentsHTML += `<div class="segment not-attended-bar" style="height: ${notAttendedHeight}%;" data-tooltip="${tooltip}">${notAttendedHeight > 5 ? `<span class="segment-label">${notAttended}</span>` : ''}</div>`;
                        }
                        // END FIX
                        
                        barsHTML += `<div class="bar-wrapper"><div class="bar" style="width: 50%">${segmentsHTML}</div></div>`;
                        
                        // START FIX: Only show total if at least one series is visible and the total is > 0
                        if (visibleTotal > 0 && (visibilityState.summaryBar.attended || visibilityState.summaryBar.notAttended)) {
                            totalsHTML += `<div class="bar-total-wrapper"><span style="bottom: ${totalHeight}%;">${visibleTotal}</span></div>`; 
                        } else {
                            totalsHTML += `<div class="bar-total-wrapper"></div>`;
                        }
                        // END FIX

                        const [mainHierarchy, parentHierarchy] = label.includes(' (') ? label.replace(')','').split(' (') : [label, ''];
                        
                        hierarchyGroupHtml_XAxis += `
                        <div class="x-axis-hierarchy-label">
                            <span class="label-hierarchy-main">${mainHierarchy}</span>
                            <span class="label-hierarchy-parent">${parentHierarchy ? '(' + parentHierarchy + ')' : ''}</span>
                            <span class="label-period-month">${timeline.labels[periodIndex]}</span>
                        </div>`;
                    });
                    labelsHTML += `<div class="x-axis-period-group">${hierarchyGroupHtml_XAxis}</div>`;
                });
                
                barsContainer.innerHTML = barsHTML; barTotalsContainer.innerHTML = totalsHTML; labelsAxis.innerHTML = labelsHTML;

                // START FIX: Build Legend with interactive series items
                legendContainer.innerHTML = `
                    <div class="legend-item interactive ${visibilityState.summaryBar.attended ? '' : 'inactive'}" data-series-id="attended">
                        <div class="legend-key" style="background-color: var(--attended-color);"></div>
                        <span>Attended</span>
                    </div>
                    <div class="legend-item interactive ${visibilityState.summaryBar.notAttended ? '' : 'inactive'}" data-series-id="notAttended">
                        <div class="legend-key" style="background-color: var(--not-attended-color);"></div>
                        <span>Not Attended</span>
                    </div>
                `;
                // END FIX
                if (groupLabels.length > 1) {
                    legendContainer.innerHTML += '<div style="margin: 0 15px; border-left: 1px solid #ccc;"></div>';
                    legendContainer.innerHTML += groupLabels.map((label, index) =>
                        `<div class="legend-item interactive ${visibilityState.hierarchy[label] ? '' : 'inactive'}" data-hierarchy-label="${label}">
                            <div class="legend-key" style="background-color: #a5a5a5;"></div>
                            <span>${label}</span>
                        </div>`
                    ).join('');
                }
            }

            function renderGroupedBarChart(data, chartId, yAxisTitle, yAxisSuffix, metricsToShow) {
                const container = document.getElementById(`${chartId}-container`);
                const canvas = container.querySelector(`#${chartId}-canvas`);
                const yAxis = container.querySelector(`#${chartId}-yaxis`);
                const gridLines = container.querySelector(`#${chartId}-grid-lines`);
                const noDataOverlay = container.querySelector(`#${chartId}-no-data-overlay`);
                const legendContainer = container.querySelector(`#${chartId}-legend`);
                const labelsAxis = container.querySelector(`#${chartId}-xaxis-labels`);
                [yAxis, gridLines, legendContainer, labelsAxis].forEach(el => { if(el) el.innerHTML = '' });
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                if (!data || !data.barChartDataSets || data.groupLabels.length === 0) { noDataOverlay.style.display = 'flex'; return; }
                noDataOverlay.style.display = 'none';

                const { timeline, barChartDataSets, groupLabels } = data;
                groupLabels.forEach(label => { if (visibilityState.hierarchy[label] === undefined) { visibilityState.hierarchy[label] = true; } });

                let yAxisCeiling = 0;
                const visibleGroups = groupLabels.filter(label => visibilityState.hierarchy[label]);
                if (visibleGroups.length > 0) {
                    metricsToShow.forEach(key => {
                        visibleGroups.forEach(label => {
                            const values = Object.values(barChartDataSets[label][key]);
                            if (values.length > 0) yAxisCeiling = Math.max(yAxisCeiling, ...values);
                        });
                    });
                }
                yAxisCeiling = yAxisCeiling > 0 ? (Math.ceil(yAxisCeiling * 1.2) || 1) : 1;

                yAxis.innerHTML = `<div class="axis-title">${yAxisTitle}</div><div class="axis-labels"></div>`;
                const yAxisLabelsContainer = yAxis.querySelector('.axis-labels');
                for (let i = 5; i >= 0; i--) { const val = (yAxisCeiling / 5) * i; yAxisLabelsContainer.innerHTML += `<span>${Number.isInteger(val) ? val.toFixed(0) : val.toFixed(1)}${yAxisSuffix}</span>`; }
                gridLines.innerHTML = ''; for (let i = 0; i <= 5; i++) { gridLines.innerHTML += `<div class="grid-line"></div>`; }
                
                const dpr = window.devicePixelRatio || 1;
                canvas.width = canvas.clientWidth * dpr; canvas.height = canvas.clientHeight * dpr;
                ctx.scale(dpr, dpr);

                let labelsHTML = '';
                visibleGroups.forEach(label => {
                    let periodGroupHtml = '';
                    timeline.keys.forEach((periodKey, periodIndex) => {
                        const [mainHierarchy, parentHierarchy] = label.includes(' (') ? label.replace(')','').split(' (') : [label, ''];
                        periodGroupHtml += `
                        <div class="x-axis-hierarchy-label">
                            <span class="label-hierarchy-main">${mainHierarchy}</span>
                            <span class="label-hierarchy-parent">${parentHierarchy ? '(' + parentHierarchy + ')' : ''}</span>
                            <span class="label-period-month">${timeline.labels[periodIndex]}</span>
                        </div>`;
                    });
                    labelsHTML += `<div class="x-axis-period-group">${periodGroupHtml}</div>`;
                });
                labelsAxis.innerHTML = labelsHTML;
                
                const seriesColors = ['#4472c4', '#ed7d31', '#a5a5a5', '#ffc000', '#5b9bd5', '#70ad47', '#c00000', '#9e480e'];
                
                const groupCount = visibleGroups.length;
                if (groupCount > 0) {
                    const groupWidth = canvas.clientWidth / groupCount;
                    const periodWidth = groupWidth / timeline.keys.length;
                    const barWidth = periodWidth * 0.7 / metricsToShow.length;

                    visibleGroups.forEach((label, groupIndex) => {
                        const groupStart_x = groupIndex * groupWidth;
                        timeline.keys.forEach((periodKey, periodIndex) => {
                            const periodStart_x = groupStart_x + (periodIndex * periodWidth);

                            metricsToShow.forEach((metricKey, metricIndex) => {
                                const value = barChartDataSets[label][metricKey][periodKey] || 0;
                                if (value > 0) {
                                    const bar_x = periodStart_x + (periodWidth * 0.15) + (metricIndex * barWidth);
                                    const barHeight = yAxisCeiling > 0 ? (value / yAxisCeiling) * canvas.clientHeight : 0;
                                    const bar_y = canvas.clientHeight - barHeight;

                                    const metricConfig = barMetricConfig[metricKey];
                                    if (metricsToShow.length > 1) {
                                        ctx.fillStyle = seriesColors[metricIndex % seriesColors.length];
                                    } else {
                                        ctx.fillStyle = seriesColors[groupLabels.indexOf(label) % seriesColors.length];
                                    }

                                    ctx.fillRect(bar_x, bar_y, barWidth, barHeight);
                                    
                                    ctx.save();
                                    ctx.fillStyle = '#333';
                                    ctx.font = 'bold 9px Inter';
                                    ctx.textAlign = 'center';
                                    const formattedValue = barMetricConfig[metricKey].format(value);
                                    ctx.fillText(formattedValue, bar_x + barWidth / 2, bar_y - 4);
                                    ctx.restore();
                                }
                            });
                        });
                    });
                }
                
                legendContainer.innerHTML = '';
                if (metricsToShow.length > 1) {
                    legendContainer.innerHTML += metricsToShow.map((key, index) => `<div class="legend-item"><div class="legend-key" style="background-color: ${seriesColors[index % seriesColors.length]};"></div><span>${barMetricConfig[key].label}</span></div>`).join('');
                     legendContainer.innerHTML += '<div style="margin: 0 15px; border-left: 1px solid #ccc;"></div>';
                }
                legendContainer.innerHTML += groupLabels.map((label, index) => `<div class="legend-item interactive ${visibilityState.hierarchy[label] ? '' : 'inactive'}" data-hierarchy-label="${label}"><div class="legend-key" style="background-color: ${metricsToShow.length > 1 ? '#aaa' : seriesColors[index % seriesColors.length]};"></div><span>${label}</span></div>`).join('');
            }

            function renderAll() {
                chartDataCache = calculateTimelineChartData();
                renderStackedBarChart(chartDataCache); 
                renderGroupedBarChart(chartDataCache, 'hours-chart', 'Hours', 'h', ['actualHours', 'targetHours']);
                renderGroupedBarChart(chartDataCache, 'averages-chart', 'Value', '', ['avgTraining', 'avgHours']);
                updateRoleWiseChart();
            }
            
            function handleChartDownload(chartId, format) {
                const chartWrapper = document.getElementById(chartId + '-wrapper');
                if (!chartWrapper) return;

                html2canvas(chartWrapper, { scale: 2, backgroundColor: '#ffffff' }).then(canvas => {
                    if (format === 'png') {
                        const link = document.createElement('a');
                        link.download = `${chartId}.png`;
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    } else if (format === 'pdf') {
                        const { jsPDF } = window.jspdf;
                        const imgData = canvas.toDataURL('image/png');
                        const pdf = new jsPDF({
                            orientation: 'landscape',
                            unit: 'px',
                            format: [canvas.width, canvas.height]
                        });
                        pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                        pdf.save(`${chartId}.pdf`);
                    }
                });
            }
            
            function syncGranularity(sourceWrapper) {
                const newGranularity = sourceWrapper.querySelector('.chart-granularity-selector .active').dataset.granularity;
                const newPeriods = sourceWrapper.querySelector('.timeline-periods-input').value;
                
                document.querySelectorAll('.timeline-chart-wrapper').forEach(wrapper => {
                    if (wrapper.id !== sourceWrapper.id && wrapper.id !== 'role-wise-chart-wrapper') {
                        wrapper.querySelector('.chart-granularity-selector .active')?.classList.remove('active');
                        wrapper.querySelector(`[data-granularity="${newGranularity}"]`)?.classList.add('active');
                        wrapper.querySelector('.timeline-periods-input').value = newPeriods;
                    }
                });
            }

            function setupEventListeners() {
                const dashboardContainer = document.getElementById('dashboard-container');

                dashboardContainer.addEventListener('click', (e) => {
                    const button = e.target.closest('button');
                    if (button) {
                        const wrapper = button.closest('.timeline-chart-wrapper');
                        if (wrapper && wrapper.id !== 'role-wise-chart-wrapper') {
                            if (button.parentElement.classList.contains('chart-granularity-selector')) {
                                syncGranularity(wrapper);
                                renderAll();
                            }
                            else if (button.classList.contains('timeline-refresh-btn')) {
                                renderAll();
                            }
                        }
                    }

                    const legendItem = e.target.closest('.legend-item.interactive');
                    if (legendItem) {
                        const isHierarchy = legendItem.dataset.hierarchyLabel;
                        const isSeries = legendItem.dataset.seriesId;
                        if (isHierarchy) {
                            const label = legendItem.dataset.hierarchyLabel;
                            visibilityState.hierarchy[label] = !visibilityState.hierarchy[label];
                            document.querySelectorAll(`.legend-item[data-hierarchy-label="${label}"]`).forEach(item => item.classList.toggle('inactive'));
                            renderAll();
                        } else if (isSeries) {
                            const seriesId = legendItem.dataset.seriesId;
                            visibilityState.summaryBar[seriesId] = !visibilityState.summaryBar[seriesId];
                            legendItem.classList.toggle('inactive');
                            renderStackedBarChart(chartDataCache);
                        }
                    }

                    const downloadAction = e.target.closest('[data-action="download-chart"]');
                    if (downloadAction) {
                        e.preventDefault();
                        const chartId = downloadAction.closest('.timeline-chart-wrapper').id.replace('-wrapper','');
                        handleChartDownload(chartId, downloadAction.dataset.format);
                    }
                });

                dashboardContainer.addEventListener('change', e => {
                    if (e.target.classList.contains('timeline-periods-input')) {
                        const wrapper = e.target.closest('.timeline-chart-wrapper');
                         if (wrapper.id !== 'role-wise-chart-wrapper') {
                           syncGranularity(wrapper);
                           renderAll();
                        }
                    }
                });
            }
            
            setupEventListeners();
            return renderAll;
        }
        
        function renderAllChartsHtml() {
            const createChartHtml = (id, title) => {
                const granularities = ['daily', 'weekly', 'monthly', 'yearly'];
                const getGranularityButtons = (activeGranularity = 'monthly') => {
                    return granularities.map(g => `<button data-granularity="${g}" class="${g === activeGranularity ? 'active' : ''}">${g.charAt(0).toUpperCase() + g.slice(1)}</button>`).join('');
                };

                return `
                <div id="${id}-wrapper" class="timeline-chart-wrapper">
                    <div id="${id}-container" class="chart-container">
                        <div class="chart-header">
                            <h2 id="${id}-title" class="chart-title">${title}</h2>
                            <div class="timeline-control-group">
                                <div class="chart-granularity-selector">${getGranularityButtons()}</div>
                                <div class="timeline-period-control">
                                    <label>Periods:</label>
                                    <input type="number" class="timeline-periods-input" value="2" min="1" max="12">
                                    <button class="action-button refresh timeline-refresh-btn" style="padding: 8px 12px;" title="Refresh Chart Data"><i class="fas fa-sync-alt"></i></button>
                                </div>
                            </div>
                            <div class="chart-download-options">
                                <button class="download-btn"><i class="fas fa-download"></i></button>
                                <div class="download-dropdown">
                                    <a href="#" data-action="download-chart" data-format="png">Download as PNG</a>
                                    <a href="#" data-action="download-chart" data-format="pdf">Download as PDF</a>
                                </div>
                            </div>
                        </div>
                        <div class="chart-area">
                            <div class="y-axis y-axis-left" id="${id}-yaxis"></div>
                            <div class="plot-area">
                                <canvas id="${id}-canvas" class="chart-canvas"></canvas>
                                <div id="${id}-grid-lines" class="grid-lines"></div>
                                <div id="${id}-bars-container" class="bars-container"></div>
                                <div id="${id}-bar-totals-container" class="bar-totals-container"></div>
                            </div>
                        </div>
                        <div class="x-axis">
                            <div id="${id}-xaxis-labels" class="x-axis-labels"></div>
                        </div>
                        <div class="legend" id="${id}-legend"></div>
                        <div id="${id}-no-data-overlay" class="chart-no-data-overlay" style="display: none;">
                            <span>No data available for the selected filters</span>
                        </div>
                    </div>
                </div>`;
            }
            
            const roleWiseChartHtml = `
            <div id="role-wise-chart-wrapper" class="timeline-chart-wrapper">
                <div class="chart-container" style="padding: 1.5rem;">
                     <div class="chart-header">
                        <h2 id="role-wise-chart-title" class="chart-title">Role Wise Training Status</h2>
                        <div class="timeline-control-group">
                           <button class="action-button refresh" data-action="refresh" title="Refresh Data" style="padding: 8px 12px;"><i class="fas fa-sync-alt"></i></button>
                        </div>
                    </div>
                    <div class="role-chart-container">
                        <div class="role-chart-grid">
                            <div class="role-y-axis"></div>
                            <div class="role-chart-area">
                                 <canvas class="role-chart-line-canvas"></canvas>
                            </div>
                            <div class="role-y-axis-right"></div>
                        </div>
                        <div class="role-x-axis"></div>
                    </div>
                    <div id="role-wise-chart-legend" class="legend"></div>
                    <div class="role-chart-no-data-overlay" style="display: none;">
                         <span>No data available for the selected filters</span>
                    </div>
                </div>
            </div>
            `;
            
            return `
            <div id="charts-section" class="${state.ui.showGraphs ? '' : 'hidden'}">
                <div class="timeline-charts-grid">
                    ${createChartHtml('summary-chart', 'Training Attendance Summary')}
                    ${createChartHtml('hours-chart', 'Training Hours Analysis')}
                    ${createChartHtml('averages-chart', 'Employee Training Averages')}
                    ${roleWiseChartHtml}
                </div>
            </div>
            `;
        }


        // --- START: DYNAMIC ROLE-WISE CHART LOGIC ---
        function updateRoleWiseChart() {
            const chartData = chartDataCache; 

            const container = document.getElementById('role-wise-chart-wrapper');
            const chartArea = container.querySelector('.role-chart-area');
            const xAxisContainer = container.querySelector('.role-x-axis');
            const yAxisLeft = container.querySelector('.role-y-axis');
            const yAxisRight = container.querySelector('.role-y-axis-right');
            const legendContainer = container.querySelector('#role-wise-chart-legend');
            const canvas = container.querySelector('.role-chart-line-canvas');
            const noDataOverlay = container.querySelector('.role-chart-no-data-overlay');

            [chartArea.innerHTML, xAxisContainer.innerHTML, legendContainer.innerHTML, yAxisLeft.innerHTML, yAxisRight.innerHTML] = ['', '', '', '', ''];
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);


            if (!chartData || !chartData.groupLabels || chartData.groupLabels.length === 0) {
                noDataOverlay.style.display = 'flex';
                return;
            }
            noDataOverlay.style.display = 'none';
            
            const { timeline, groupLabels } = chartData;

            const allEmployeesInView = getUnpaginatedFilteredEmployeesForExport();
            const allRoles = [...new Set(allEmployeesInView.map(e => e.role))].sort();
            
            const roleAggregatedData = {};
            timeline.keys.forEach(periodKey => {
                roleAggregatedData[periodKey] = {};
                groupLabels.forEach(groupLabel => {
                    roleAggregatedData[periodKey][groupLabel] = {};
                    allRoles.forEach(role => {
                        roleAggregatedData[periodKey][groupLabel][role] = { attended: 0, total: 0 };
                    });
                });
            });

            const { nodesForTable } = getFilteredData(state.rawData, state.ui.filters);
            let baseGroupNodes;
            const topLevelNodeType = nodesForTable[0].type;
             switch (topLevelNodeType) {
                case 'corporate': baseGroupNodes = nodesForTable[0].children || []; break;
                case 'region': baseGroupNodes = nodesForTable.flatMap(r => r.children || []); break;
                case 'unit': baseGroupNodes = nodesForTable.flatMap(u => u.children || []); break;
                default: baseGroupNodes = []; break;
            }

            timeline.keys.forEach(periodKey => {
                let periodStart, periodEnd;
                const granularity = document.querySelector('#summary-chart-wrapper .chart-granularity-selector .active').dataset.granularity;
                if (granularity === 'yearly') { const [startYear, endYear] = periodKey.split('-').map(Number); periodStart = new Date(Date.UTC(startYear, 3, 1)); periodEnd = new Date(Date.UTC(endYear, 3, 0, 23, 59, 59)); } 
                else { periodStart = new Date(periodKey + 'T00:00:00Z'); if (granularity === 'monthly') { periodEnd = new Date(periodStart.getFullYear(), periodStart.getUTCMonth() + 1, 0, 23, 59, 59); } else if (granularity === 'weekly') { periodEnd = new Date(periodStart.getTime() + 6 * 24 * 60 * 60 * 1000); periodEnd.setUTCHours(23, 59, 59); } else { periodEnd = new Date(periodStart); periodEnd.setUTCHours(23, 59, 59); } }
                
                groupLabels.forEach(label => {
                    const nodesForGroup = baseGroupNodes.filter(n => getContextualName(n) === label);
                    const employeesInGroup = getAllNodesByType(nodesForGroup, 'employee');

                    employeesInGroup.forEach(emp => {
                        const dateFilteredMetrics = filterMetricsByDate(emp.metrics, { start: periodStart, end: periodEnd });
                        const finalMetrics = filterMetrics(dateFilteredMetrics, state.ui.filters.topicFilters);
                        const allMetricsForPeriod = Object.values(finalMetrics).flat();
                        const attended = allMetricsForPeriod.reduce((sum, m) => sum + m.attended, 0);
                        const total = allMetricsForPeriod.length;

                        if (roleAggregatedData[periodKey][label][emp.role]) {
                            roleAggregatedData[periodKey][label][emp.role].attended += attended;
                            roleAggregatedData[periodKey][label][emp.role].total += total;
                        }
                    });
                });
            });
            
            let maxAttendedStack = 0;
            let maxMissed = 0;

            timeline.keys.forEach(periodKey => {
                groupLabels.forEach(label => {
                    const totalAttendedInStack = allRoles.reduce((sum, role) => sum + roleAggregatedData[periodKey][label][role].attended, 0);
                    const totalInStack = allRoles.reduce((sum, role) => sum + roleAggregatedData[periodKey][label][role].total, 0);
                    if (totalAttendedInStack > maxAttendedStack) maxAttendedStack = totalAttendedInStack;
                    if ((totalInStack - totalAttendedInStack) > maxMissed) maxMissed = (totalInStack - totalAttendedInStack);
                });
            });

            const attendedCeiling = maxAttendedStack > 0 ? Math.ceil(maxAttendedStack * 1.2 / 5) * 5 || 5 : 5;
            const missedCeiling = maxMissed > 0 ? Math.ceil(maxMissed * 1.2 / 5) * 5 || 5 : 5;
            
            for (let i = 5; i >= 0; i--) {
                yAxisLeft.innerHTML += `<span>${(attendedCeiling / 5) * i}</span>`;
                yAxisRight.innerHTML += `<span>${(missedCeiling / 5) * i}</span>`;
            }

            let barsHtml = '';
            let xAxisHtml = '';
            const seriesColors = ['#4472c4', '#ed7d31', '#a5a5a5', '#ffc000', '#5b9bd5', '#70ad47'];
            const linePoints = [];

            let groupIndex = 0;
            timeline.keys.forEach((periodKey) => {
                groupLabels.forEach((label) => {
                    let stackHtml = '';
                    let totalAttended = 0;
                    let totalMandates = 0;

                    allRoles.forEach((role, roleIndex) => {
                        const roleData = roleAggregatedData[periodKey][label][role];
                        totalAttended += roleData.attended;
                        totalMandates += roleData.total;
                        const height = attendedCeiling > 0 ? (roleData.attended / attendedCeiling) * 100 : 0;
                        if (height > 0) {
                            stackHtml += `<div class="role-bar-segment" style="height: ${height}%; background-color: ${seriesColors[roleIndex % seriesColors.length]};" title="${role}: ${roleData.attended} Attended"></div>`;
                        }
                    });

                    barsHtml += `<div class="role-bar-group"><div class="role-bar-stack">${stackHtml}</div></div>`;

                    const missed = totalMandates - totalAttended;
                    linePoints.push(missed);
                    
                    const [mainHierarchy, parentHierarchy] = label.includes(' (') ? label.replace(')','').split(' (') : [label, ''];
                    xAxisHtml += `
                        <div class="role-x-axis-group" style="${groupIndex === 0 ? 'border-left: none;' : ''}">
                            <div class="role-x-axis-main-label">
                                <span class="label-hierarchy-main">${mainHierarchy}</span>
                                <span class="label-hierarchy-parent">${parentHierarchy ? '(' + parentHierarchy + ')' : ''}</span>
                                <span class="label-period-month">${timeline.labels[timeline.keys.indexOf(periodKey)]}</span>
                            </div>
                        </div>
                    `;
                    groupIndex++;
                });
            });
            
            chartArea.innerHTML = barsHtml + `<canvas class="role-chart-line-canvas"></canvas>`;
            xAxisContainer.innerHTML = xAxisHtml;
            
            const newCanvas = container.querySelector('.role-chart-line-canvas');
            const newCtx = newCanvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            newCanvas.width = newCanvas.clientWidth * dpr;
            newCanvas.height = newCanvas.clientHeight * dpr;
            newCtx.scale(dpr, dpr);
            
            const pointCount = linePoints.length;
            if (pointCount > 1) {
                newCtx.strokeStyle = '#c0392b';
                newCtx.lineWidth = 2.5;
                newCtx.beginPath();
                
                linePoints.forEach((point, index) => {
                    const x = (newCanvas.clientWidth / pointCount) * (index + 0.5);
                    const y = newCanvas.clientHeight - (missedCeiling > 0 ? (point / missedCeiling) * newCanvas.clientHeight : 0);
                    if (index === 0) newCtx.moveTo(x, y);
                    else newCtx.lineTo(x, y);
                });
                newCtx.stroke();
            }

            linePoints.forEach((point, index) => {
                const x = (newCanvas.clientWidth / pointCount) * (index + 0.5);
                const y = newCanvas.clientHeight - (missedCeiling > 0 ? (point / missedCeiling) * newCanvas.clientHeight : 0);
                newCtx.fillStyle = '#c0392b';
                newCtx.beginPath();
                newCtx.arc(x, y, 4, 0, 2 * Math.PI);
                newCtx.fill();

                newCtx.fillStyle = '#333';
                newCtx.font = 'bold 10px Inter';
                newCtx.textAlign = 'center';
                newCtx.fillText(point, x, y - 8);
            });

            legendContainer.innerHTML = allRoles.map((role, index) => `
                <div class="legend-item"><div class="legend-key" style="background-color: ${seriesColors[index % seriesColors.length]};"></div><span>${role} (Attended)</span></div>
            `).join('');
            legendContainer.innerHTML += `
                <div class="legend-item" style="margin-left: 20px;"><div class="legend-key role-legend-key-line" style="border-color: #c0392b;"></div><span>Missed Sessions</span></div>
            `;
        }
        // --- END: DYNAMIC ROLE-WISE CHART LOGIC ---
        
        // --- Dashboard Core Logic ---
        const state = { rawData: [], viewData: [], globalFilterOptions: {}, ui: { showGraphs: true, viewMode: 'individual', visibleMetrics: new Set(['attended', 'not-attended', 'hours-achieved', 'hours-target', 'avg-training', 'avg-hours']), expandedCols: new Set(), expandedRows: new Set(), pagination: { currentPage: 1, rowsPerPage: 20, totalRows: 0, totalPages: 1 }, filters: { region: [], unit: [], department: [], employees: [], role: [], topicFilters: { topic: [], subtopic: [], proficiency: '' }, dateRange: { from: null, to: null }, joiningDateRange: { from: null, to: null }, isFoodHandler: '' } }, };
        let chartUpdater; 
        const trainingCatalog = { "HACCP": ['Type A', 'Type B', 'Type C', 'Type D'], "Safety": ['Fire Drills', 'First Aid', 'Evacuation Procedures'], "Service": ['Guest Interaction', 'Complaint Handling'] };
        const FOOD_HANDLER_ROLES = ['Commis Chef', 'Waiter', 'Stewarding'];

        // START: FIXED MOCK DATA GENERATION
        function generateMockData() { const departments = ['Food Production', 'F&B Service', 'Stewarding', 'Finance', 'Housekeeping', 'Engineering']; function createDepartment(name, unitName) { const numEmployees = 20 + Math.floor(Math.random() * 30); const employeesList = []; const firstNames = ['Arjun', 'Priya', 'Rohan', 'Sneha', 'Vikram', 'Anjali', 'Karan', 'Meera', 'Aditya', 'Diya']; const lastNames = ['Singh', 'Patel', 'Kumar', 'Sharma', 'Gupta', 'Reddy', 'Chopra', 'Verma']; const allRoles = ['Commis Chef', 'Waiter', 'Housekeeping Staff', 'Front Desk Agent', 'Engineer', 'Accountant', 'Stewarding']; for (let i = 1; i <= numEmployees; i++) { const employeeId = `emp-${unitName}-${name.replace(/\s/g, '-')}-${i}`; const employeeName = `Mr. ${firstNames[Math.floor(Math.random()*firstNames.length)]} ${lastNames[Math.floor(Math.random()*lastNames.length)]}`; const employeeMetrics = {}; const joiningDateRaw = new Date(Date.now() - Math.random() * 3 * 365 * 24 * 60 * 60 * 1000); const formattedJoiningDate = `${String(joiningDateRaw.getDate()).padStart(2, '0')}-${String(joiningDateRaw.getMonth() + 1).padStart(2, '0')}-${joiningDateRaw.getFullYear()}`; for (const topic in trainingCatalog) { employeeMetrics[topic] = trainingCatalog[topic].flatMap(subtopic => { const sessions = []; const isRequired = Math.random() > 0.2; if(isRequired) { const numSessions = 1 + Math.floor(Math.random() * 3); const targetCompetency = 3 + Math.floor(Math.random() * 3); for(let j=0; j < numSessions; j++) { const attended = Math.random() > 0.15 ? 1 : 0; const targetHours = (Math.random() > 0.5 ? 2 : 1.5); const actualHours = attended ? targetHours * (0.9 + Math.random() * 0.2) : 0; const d = new Date(Date.now() - Math.random() * (j + 1) * 90 * 24 * 60 * 60 * 1000); const date = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')} ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}:${String(d.getSeconds()).padStart(2, '0')}`; const actualCompetency = attended ? Math.round(targetCompetency * (0.8 + Math.random() * 0.2)) : 0; const certificateUrl = attended ? 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf' : null; const trainingSheetUrl = attended ? 'https://www.clickdimensions.com/links/TestPDFfile.pdf' : null; sessions.push({ name: subtopic, attended, total: 1, actualHours, targetHours, date, targetCompetency, actualCompetency, certificateUrl, trainingSheetUrl }); } } return sessions; }); } employeesList.push({ id: employeeId, name: employeeName, type: 'employee', status: Math.random() > 0.1 ? 'Active' : 'Inactive', role: allRoles[Math.floor(Math.random() * allRoles.length)], joiningDate: formattedJoiningDate, employeeIdNum: `(ID: ${100 + Math.floor(Math.random() * 899)}-${100000 + Math.floor(Math.random() * 899999)})`, employees: 1, metrics: employeeMetrics }); } return { id: `dept-${unitName}-${name.replace(/\s/g, '-')}-${Math.random()}`, name, type: 'department', children: employeesList }; } return [{ id: 'corp-hq', name: 'Corporate HQ', type: 'corporate', children: [ { id: 'region-americas', name: 'Americas', type: 'region', children: [{ id: 'unit-east-coast', name: 'East Coast Ops', type: 'unit', children: departments.map(name => createDepartment(name, 'East-Coast')) }] }, { id: 'region-europe', name: 'Europe', type: 'region', children: [{ id: 'unit-we-hub', name: 'Western Europe Hub', type: 'unit', children: departments.map(name => createDepartment(name, 'WE-Hub')) }] }, { id: 'region-apac', name: 'Asia-Pacific', type: 'region', children: [{ id: 'unit-tokyo', name: 'Tokyo Central', type: 'unit', children: departments.map(name => createDepartment(name, 'Tokyo')) }, { id: 'unit-singapore', name: 'Singapore Hub', type: 'unit', children: departments.map(name => createDepartment(name, 'Singapore')) }] }, { id: 'region-mea', name: 'MEA', type: 'region', children: [{ id: 'unit-dubai', name: 'Dubai Distribution', type: 'unit', children: departments.map(name => createDepartment(name, 'Dubai')) }] }, ] }]; }
        // END: FIXED MOCK DATA GENERATION
        
        // Function to parse YYYY-MM-DD HH:mm:ss
        function parseDateTime(dateTimeString) {
            if (!dateTimeString) return null;
            try {
                const [datePart, timePart] = dateTimeString.split(' ');
                const [year, month, day] = datePart.split('-');
                if (timePart) {
                    const [hours, minutes, seconds] = timePart.split(':');
                    return new Date(year, month - 1, day, hours, minutes, seconds);
                }
                return new Date(year, month - 1, day);
            } catch (e) {
                return null;
            }
        }
        
        function parseDateToUTC(dateString) {
            if (!dateString) return null;
            if (/^\d{4}-\d{2}-\d{2}/.test(dateString)) { // yyyy-mm-dd or yyyy-mm-dd hh:mm:ss
                const [y, m, d] = dateString.substring(0,10).split('-').map(Number);
                return new Date(Date.UTC(y, m - 1, d));
            }
            if (/^\d{2}-\d{2}-\d{4}$/.test(dateString)) { // dd-mm-yyyy
                const [d, m, y] = dateString.split('-').map(Number);
                return new Date(Date.UTC(y, m - 1, d));
            }
            return null;
        }

        function filterMetricsByDate(metrics, dateRange) {
            const { from, to } = dateRange;
            if (!from && !to) return metrics;
            
            const fromDate = parseDateToUTC(from);
            const toDate = parseDateToUTC(to);
            if (toDate) toDate.setUTCHours(23, 59, 59, 999); 

            const filtered = {};
            for (const topicKey in metrics) {
                const subtopicMetrics = metrics[topicKey].filter(metric => {
                    if (!metric.date) return false;
                    const metricDate = parseDateToUTC(metric.date);
                    if (!metricDate) return false;
                    if (fromDate && metricDate < fromDate) return false;
                    if (toDate && metricDate > toDate) return false;
                    return true;
                });
                if (subtopicMetrics.length > 0) {
                    filtered[topicKey] = subtopicMetrics;
                }
            }
            return filtered;
        }
        
        function filterMetrics(metrics, topicFilters) {
            const { topic: selectedTopics, subtopic: selectedSubtopics, proficiency } = topicFilters;
            if (selectedTopics.length === 0 && selectedSubtopics.length === 0 && !proficiency) {
                return metrics;
            }
            const filtered = {};
            for (const topicKey in metrics) {
                if (selectedTopics.length > 0 && !selectedTopics.includes(topicKey)) {
                    continue;
                }
                const subtopicMetrics = metrics[topicKey].filter(metric => {
                    if (selectedSubtopics.length > 0 && !selectedSubtopics.includes(metric.name)) return false;
                    if (proficiency && metric.targetCompetency !== parseInt(proficiency, 10)) return false;
                    return true;
                });
                if (subtopicMetrics.length > 0) {
                    filtered[topicKey] = subtopicMetrics;
                }
            }
            return filtered;
        }
        
        function isEmployeeConsideredAttended(employeeNode) {
            if (!employeeNode || !employeeNode.summary || !employeeNode.summary.metrics) {
                return false;
            }
            const metrics = employeeNode.summary.metrics;
            const allFilteredSubtopics = Object.values(metrics).flat();
            const mandatorySubtopics = allFilteredSubtopics.filter(m => m.targetCompetency > 0);
            if (mandatorySubtopics.length === 0) {
                return true;
            }
            return mandatorySubtopics.every(m => m.attended === 1);
        }

        function calculateRollups(node) {
            if (node.type === 'employee') {
                let isVisible = true;
                const { joiningDateRange, isFoodHandler, role: selectedRoles } = state.ui.filters;
                if (joiningDateRange.from || joiningDateRange.to) {
                    const employeeJoiningDate = parseDateToUTC(node.joiningDate);
                    const fromDate = parseDateToUTC(joiningDateRange.from);
                    const toDate = parseDateToUTC(joiningDateRange.to);
                    if (toDate) toDate.setUTCHours(23, 59, 59, 999);
                    if (!employeeJoiningDate || (fromDate && employeeJoiningDate < fromDate) || (toDate && employeeJoiningDate > toDate)) {
                        isVisible = false;
                    }
                }
                if (isFoodHandler) {
                    const isHandler = FOOD_HANDLER_ROLES.includes(node.role);
                    if ((isFoodHandler === 'yes' && !isHandler) || (isFoodHandler === 'no' && isHandler)) {
                        isVisible = false;
                    }
                }
                if (selectedRoles.length > 0 && !selectedRoles.includes(node.role)) {
                    isVisible = false;
                }
                if (!isVisible) {
                    node.summary = { employees: 0, attendedCount: 0, totalActualHours: 0, totalTargetHours: 0, totalSessionsAttended: 0, totalSessionsMandatory: 0, metrics: {} };
                    return node.summary;
                }
                const dateFilteredMetrics = filterMetricsByDate(node.metrics, state.ui.filters.dateRange);
                const finalMetrics = filterMetrics(dateFilteredMetrics, state.ui.filters.topicFilters);
                if (Object.keys(finalMetrics).length === 0 && (state.ui.filters.topicFilters.topic.length > 0 || state.ui.filters.topicFilters.subtopic.length > 0)) {
                    node.summary = { employees: 0, attendedCount: 0, totalActualHours: 0, totalTargetHours: 0, totalSessionsAttended: 0, totalSessionsMandatory: 0, metrics: {} };
                    return node.summary;
                }
                const allFilteredMetrics = Object.values(finalMetrics).flat();
                const mandatoryMetrics = allFilteredMetrics.filter(m => m.targetCompetency > 0);
                node.summary = {
                    employees: 1,
                    metrics: finalMetrics,
                    attendedCount: isEmployeeConsideredAttended({ summary: { metrics: finalMetrics } }) ? 1 : 0,
                    totalActualHours: allFilteredMetrics.reduce((sum, m) => sum + m.actualHours, 0),
                    totalTargetHours: allFilteredMetrics.reduce((sum, m) => sum + m.targetHours, 0),
                    totalSessionsAttended: allFilteredMetrics.reduce((sum, m) => sum + m.attended, 0),
                    totalSessionsMandatory: mandatoryMetrics.length,
                };
                return node.summary;
            }
            const summary = { employees: 0, attendedCount: 0, totalActualHours: 0, totalTargetHours: 0, totalSessionsAttended: 0, totalSessionsMandatory: 0, metrics: {} };
            if (node.children) {
                node.children.forEach(child => {
                    const childSummary = calculateRollups(child);
                    summary.employees += childSummary.employees;
                    summary.attendedCount += childSummary.attendedCount;
                    summary.totalActualHours += childSummary.totalActualHours;
                    summary.totalTargetHours += childSummary.totalTargetHours;
                    summary.totalSessionsAttended += childSummary.totalSessionsAttended;
                    summary.totalSessionsMandatory += childSummary.totalSessionsMandatory;
                    for (const topic in childSummary.metrics) {
                        if (!summary.metrics[topic]) summary.metrics[topic] = [];
                        childSummary.metrics[topic].forEach((childMetric) => {
                            const existingMetric = summary.metrics[topic].find(m => m.name === childMetric.name);
                            if (!existingMetric) {
                                summary.metrics[topic].push({ ...childMetric });
                            } else {
                                existingMetric.attended += childMetric.attended;
                                existingMetric.total += childMetric.total;
                                existingMetric.actualHours += childMetric.actualHours;
                                existingMetric.targetHours += childMetric.targetHours;
                                existingMetric.actualCompetency += childMetric.actualCompetency;
                                existingMetric.targetCompetency += childMetric.targetCompetency;
                            }
                        });
                    }
                });
            }
            node.summary = summary;
            return node.summary;
        }

        function filterTreeBySummary(node) {
            if (!node) return null;
            if (node.children) {
                node.children = node.children
                    .map(child => filterTreeBySummary(child))
                    .filter(child => child !== null);
            }
            if ((node.summary && node.summary.employees > 0) || (node.children && node.children.length > 0)) {
                return node;
            }
            return null;
        }
        
        function deepClone(obj) {
            if (obj === null || typeof obj !== 'object') {
                return obj;
            }
            const clone = Array.isArray(obj) ? [] : {};
            for (const key in obj) {
                if (key !== 'parent' && Object.prototype.hasOwnProperty.call(obj, key)) {
                    clone[key] = deepClone(obj[key]);
                }
            }
            return clone;
        }

        function getContextualName(node) {
            if (!node || !node.type) return '';
            if (node.parent && node.type !== 'corporate' && node.type !== 'employee') {
                return `${node.name} (${node.parent.name})`;
            }
            return node.name;
        }

        function getFullPath(node) {
            const path = { corporate: 'N/A', region: 'N/A', unit: 'N/A', department: 'N/A' };
            let current = node;
            while (current) {
                if (path[current.type] === 'N/A') {
                    path[current.type] = current.name;
                }
                current = current.parent;
            }
            return path;
        }
        
        // START: OPTIMIZATION - Modified flattenHierarchy to add parentId and calculate initial visibility.
        // This is crucial for the new, faster row toggling. It prepares the data so that rows
        // know their parent and whether they should be rendered as hidden initially.
        function flattenHierarchy(nodes, level = 1, parentId = '', isParentCollapsed = false) {
            return nodes.flatMap(node => {
                const isExpanded = state.ui.expandedRows.has(node.id);
                const isHiddenByParent = isParentCollapsed;

                const row = {
                    id: node.id,
                    name: node.name,
                    displayName: getContextualName(node),
                    fullPath: getFullPath(node),
                    level,
                    type: node.type,
                    summary: node.summary,
                    headcount: node.headcount,
                    hasChildren: !!node.children?.length,
                    isExpanded,
                    parentId: parentId, // Keep track of the parent
                    isInitiallyHidden: isHiddenByParent // Determine if it should be hidden on render
                };
                if (node.type === 'employee') {
                    row.status = node.status;
                    row.role = node.role;
                    row.joiningDate = node.joiningDate;
                    row.employeeIdNum = node.employeeIdNum;
                }
                
                // A child's parent is collapsed if the current node is NOT expanded OR if its own parent was collapsed.
                const areChildrenCollapsed = !isExpanded || isHiddenByParent;

                return [row, ...(node.children ? flattenHierarchy(node.children, level + 1, node.id, areChildrenCollapsed) : [])];
            });
        }
        // END: OPTIMIZATION

        function applyFiltersToView(data) { return data.map(row => ({ ...row, isVisible: true })); }
        function applyPagination(data) { const { pagination, filters } = state.ui; const baseRows = data.filter(row => row.isVisible); const rowsToPaginate = baseRows.filter(row => row.level === 1); pagination.totalRows = rowsToPaginate.length; if (pagination.rowsPerPage === -1 || filters.employees.length > 0) { pagination.totalPages = 1; pagination.currentPage = 1; return data.map(row => ({ ...row, isPaginatedVisible: row.isVisible })); } pagination.totalPages = Math.ceil(pagination.totalRows / pagination.rowsPerPage) || 1; pagination.currentPage = Math.min(pagination.currentPage, pagination.totalPages); const startIndex = (pagination.currentPage - 1) * pagination.rowsPerPage; const pagedTopLevelRows = rowsToPaginate.slice(startIndex, startIndex + pagination.rowsPerPage); const pagedTopLevelRowIds = new Set(pagedTopLevelRows.map(r => r.id)); const finalVisibleIds = new Set(); let currentTopLevelId = null; baseRows.forEach(row => { if (row.level === 1) { currentTopLevelId = row.id; } if (pagedTopLevelRowIds.has(currentTopLevelId)) { finalVisibleIds.add(row.id); } }); return data.map(row => ({ ...row, isPaginatedVisible: finalVisibleIds.has(row.id) && row.isVisible })); }
        function getVisibleMetricGroups(summary) { if (!summary || !summary.metrics) return {}; return summary.metrics; }
        function convertDecimalToHMS(d) { if (d === undefined || d === null) return '0:0:0'; d = Number(d); const h = Math.floor(d); const m = Math.floor((d * 60) % 60); const s = Math.floor((d * 3600) % 60); return `${h}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`; }
        
        /**
         * START: MODIFIED FUNCTION
         * Renders a cell for an employee. Returns a compact layout for individual subtopics
         * and a more detailed summary layout for the "Overall Summary" column.
         */
        function renderCompetencyCell(summary, rowData, isSummary = false) {
            const { date, targetCompetency, actualCompetency, attended, total, actualHours, targetHours } = summary;
            const competencyPct = targetCompetency > 0 ? Math.round((actualCompetency / targetCompetency) * 100) : 0;

            // This is for the OVERALL SUMMARY column cell for an employee. It remains as it was.
            if (isSummary) {
                let detailsHtml = `
                    <div class="training-details-summary">
                        <div><i class="fas fa-check-circle"></i><span>Total Sessions: ${attended} / ${total}</span></div>
                        <div><i class="fas fa-stopwatch"></i><span>Total Hours: ${convertDecimalToHMS(actualHours)} / ${convertDecimalToHMS(targetHours)}</span></div>
                    </div><hr/>`;
                
                const actualCompetencyHtml = `<span>${actualCompetency}</span>`;
                
                return `
                    <div class="employee-metric-cell">
                        ${detailsHtml}
                        <div class="competency-section">
                            <div class="competency-header">Overall Competency</div>
                            <div class="competency-scores">
                                <span><i class="fas fa-crosshairs" title="Target"></i> ${targetCompetency}</span>
                                <span><i class="fas fa-award" title="Actual"></i> ${actualCompetencyHtml}</span>
                            </div>
                            <div class="competency-bar-container"><div class="competency-bar-fill" style="width: ${competencyPct}%;">${competencyPct}%</div></div>
                        </div>
                    </div>`;
            }

            // This is for the INDIVIDUAL SUBTOPIC column cell, matching the new design.
            const hmsHours = convertDecimalToHMS(actualHours);
            const formattedDate = date ? new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : 'N/A';
            const sessionCountDisplay = attended > 0 
                ? `<a class="session-link" data-action="open-session-history" data-employee-id="${rowData.id}" data-metric-name="${summary.name}">${attended}</a>`
                : `<strong>${attended}</strong>`;

            let detailsHtml = `
                <div class="training-details-summary">
                    <div>Attended: <strong>${formattedDate}</strong></div>
                    <div>Hours: <strong>${hmsHours}</strong> | Sess: ${sessionCountDisplay}</div>
                </div>
                <hr/>`;

            let selectOptions = '';
            for(let i=0; i <= 5; i++) {
                selectOptions += `<option value="${i}" ${i === actualCompetency ? 'selected' : ''}>${i}</option>`;
            }
            const actualCompetencyHtml = `<select data-action="update-competency" data-employee-id="${rowData.id}" data-metric-name="${summary.name}">${selectOptions}</select>`;

            return `
                <div class="employee-metric-cell">
                    ${detailsHtml}
                    <div class="competency-header">Competency</div>
                    <div class="competency-scores">
                        <span>Should: <strong>${targetCompetency}</strong></span>
                        <span>Actual: ${actualCompetencyHtml}</span>
                    </div>
                    <div class="competency-bar-container"><div class="competency-bar-fill" style="width: ${competencyPct}%;">${competencyPct}%</div></div>
                </div>`;
        }
        // END: MODIFIED FUNCTION
        
        function renderCell(summary, rowData) {
            if (rowData.type === 'employee') {
                const overallMetrics = Object.values(summary.metrics || {}).flat().reduce((acc, metric) => { acc.attended += metric.attended; acc.total += metric.total; acc.actualHours += metric.actualHours; acc.targetHours += metric.targetHours; acc.actualCompetency += metric.actualCompetency; acc.targetCompetency += metric.targetCompetency; return acc; }, { attended: 0, total: 0, actualHours: 0, targetHours: 0, actualCompetency: 0, targetCompetency: 0 });
                return renderCompetencyCell(overallMetrics, rowData, true);
            }

            const { employees, attendedCount, totalActualHours, totalTargetHours, totalSessionsAttended, totalSessionsMandatory } = summary;
            const headcount = rowData.headcount;
            const isIndividualMode = state.ui.viewMode === 'individual';
            
            let totalInView, attendedInView, percentage, attendedLabel, notAttendedLabel;

            if (isIndividualMode) {
                totalInView = employees;
                attendedInView = attendedCount;
                attendedLabel = "Fully Attended";
                notAttendedLabel = "Not Fully Attended";
            } else {
                totalInView = totalSessionsMandatory;
                attendedInView = totalSessionsAttended;
                attendedLabel = "Sessions Attended";
                notAttendedLabel = "Sessions Missed";
            }
            
            if (totalInView === 0) {
                 return '<div class="cell-wrapper" style="justify-content: center; color: #999;">N/A</div>';
            }

            const notAttendedInView = totalInView - attendedInView;
            percentage = totalInView > 0 ? Math.round((attendedInView / totalInView) * 100) : 0;
            
            let statusClass = 'poor-status', statusIcon = 'fa-times-circle';
            if (percentage >= 95) { 
                statusClass = 'good-status'; 
                statusIcon = 'fa-check-circle'; 
            } else if (percentage >= 80) { 
                statusClass = 'warning-status'; 
                statusIcon = 'fa-exclamation-triangle'; 
            }
            
            const avgTpe = headcount > 0 ? (totalSessionsAttended / headcount).toFixed(1) : '0.0';
            const avgHpe = headcount > 0 ? (totalActualHours / headcount).toFixed(1) : '0.0';

            const { visibleMetrics } = state.ui;

            return `
                <div class="cell-wrapper">
                    <div class="main-visuals-wrapper">
                        <div class="main-metric-area">
                            <i class="status-icon fas ${statusIcon} ${statusClass}"></i>
                            <div class="main-metric">${percentage}%</div>
                        </div>
                        <div class="progress-bar-container" title="${percentage}% Complete">
                            <div class="progress-bar-fill" style="width: ${percentage}%;"></div>
                        </div>
                    </div>
                    <div class="details-pane">
                        <div class="detail-item ${visibleMetrics.has('attended') ? '' : 'hidden'}" title="${attendedLabel}">
                            <i class="fas fa-user-check"></i>
                            <span>${attendedInView}</span>
                        </div>
                        <div class="detail-item ${visibleMetrics.has('not-attended') ? '' : 'hidden'}" title="${notAttendedLabel}">
                            <i class="fas fa-user-times"></i>
                            <span>${notAttendedInView}</span>
                        </div>
                        <div class="detail-item ${visibleMetrics.has('hours-achieved') ? '' : 'hidden'}" title="Actual Hours (Sum)">
                            <i class="fas fa-stopwatch"></i>
                            <span>${totalActualHours.toFixed(1)}h</span>
                        </div>
                        <div class="detail-item ${visibleMetrics.has('hours-target') ? '' : 'hidden'}" title="Target Hours (Sum)">
                            <i class="fas fa-bullseye"></i>
                            <span>${totalTargetHours.toFixed(1)}h</span>
                        </div>
                        <div class="detail-item ${visibleMetrics.has('avg-training') ? '' : 'hidden'}" title="Avg. Sessions / Headcount">
                            <i class="fas fa-user-graduate"></i>
                            <span>${avgTpe}</span>
                        </div>
                        <div class="detail-item ${visibleMetrics.has('avg-hours') ? '' : 'hidden'}" title="Avg. Hours / Headcount">
                            <i class="fas fa-user-clock"></i>
                            <span>${avgHpe}h</span>
                        </div>
                    </div>
                </div>
            `;
        }

        /**
         * NEW FUNCTION: Renders a summary cell for a specific topic or sub-topic,
         * matching the design of the main "Overall Summary" cell.
         */
        function renderTopicSummaryCell(summary) {
            const { attended, total, actualHours, targetHours } = summary;
            
            // In the context of a topic, the main metric is session completion.
            const totalSessionsMandatory = total;
            const totalSessionsAttended = attended;

            if (totalSessionsMandatory === 0) {
                return '<div class="cell-wrapper" style="justify-content: center; color: #999;">N/A</div>';
            }
            
            const notAttended = totalSessionsMandatory - totalSessionsAttended;
            const percentage = Math.round((totalSessionsAttended / totalSessionsMandatory) * 100);

            let statusClass = 'poor-status', statusIcon = 'fa-times-circle';
            if (percentage >= 95) {
                statusClass = 'good-status';
                statusIcon = 'fa-check-circle';
            } else if (percentage >= 80) {
                statusClass = 'warning-status';
                statusIcon = 'fa-exclamation-triangle';
            }

            // The details pane for a topic summary is simpler than the overall summary.
            // We focus on the core metrics for that specific topic.
            return `
                <div class="cell-wrapper">
                    <div class="main-visuals-wrapper">
                        <div class="main-metric-area">
                            <i class="status-icon fas ${statusIcon} ${statusClass}"></i>
                            <div class="main-metric">${percentage}%</div>
                        </div>
                        <div class="progress-bar-container" title="${percentage}% Complete">
                            <div class="progress-bar-fill" style="width: ${percentage}%;"></div>
                        </div>
                    </div>
                    <div class="details-pane">
                        <div class="detail-item" title="Sessions Attended">
                            <i class="fas fa-user-check"></i>
                            <span>${totalSessionsAttended}</span>
                        </div>
                        <div class="detail-item" title="Sessions Missed">
                            <i class="fas fa-user-times"></i>
                            <span>${notAttended}</span>
                        </div>
                        <div class="detail-item" title="Actual Hours (Sum)">
                            <i class="fas fa-stopwatch"></i>
                            <span>${actualHours.toFixed(1)}h</span>
                        </div>
                        <div class="detail-item" title="Target Hours (Sum)">
                            <i class="fas fa-bullseye"></i>
                            <span>${targetHours.toFixed(1)}h</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // START: REDESIGNED `renderRow` FUNCTION
        // This function is now much simpler for mobile. It creates the hierarchy block
        // and a single scrollable container for all the metrics.
        function renderRow(rowData, serialNumber, catalogToRender) {
            const { id, displayName, level, type, summary, hasChildren, isExpanded, isVisible, isPaginatedVisible, status, role, joiningDate, employeeIdNum, fullPath, parentId, isInitiallyHidden } = rowData;
            if (!isVisible || !isPaginatedVisible) return '';
            
            let hierarchyCellHtml = '';
            if (type === 'employee') {
                const isFoodHandler = FOOD_HANDLER_ROLES.includes(role);
                const foodHandlerIcon = isFoodHandler ? `<i class="fas fa-utensils" title="Food Handler" style="color: var(--icon-color); margin-left: 8px; font-size: 0.9em;"></i>` : '';
                const employeeDisplayName = serialNumber ? `${serialNumber}. ${displayName}` : displayName;
                hierarchyCellHtml = `
                    <div class="employee-details-block">
                        <div class="employee-header">
                            <span class="employee-name">${employeeDisplayName}</span> ${foodHandlerIcon}
                             <button class="action-button view-card-btn" data-action="open-training-card" data-employee-id="${id}">View Card</button>
                            <span class="status-badge ${status.toLowerCase()}">${status}</span>
                        </div>
                        <div class="employee-id-num">${employeeIdNum}</div>
                        <div class="employee-info-grid">
                            <div class="info-item"><i class="fas fa-id-badge"></i><span class="info-value">${role}</span></div>
                            <div class="info-item"><i class="fas fa-calendar-check"></i><span class="info-value">${joiningDate}</span></div>
                            <div class="info-item"><i class="fas fa-building-user"></i><span class="info-value">${fullPath.department}</span></div>
                            <div class="info-item"><i class="fas fa-map-location-dot"></i><span class="info-value">${fullPath.unit}</span></div>
                        </div>
                    </div>`;
            } else {
                let iconClass = 'fa-question-circle';
                switch(type) {
                    case 'corporate': iconClass = 'fa-sitemap'; break;
                    case 'region': iconClass = 'fa-globe-americas'; break;
                    case 'unit': iconClass = 'fa-building-shield'; break;
                    case 'department': iconClass = 'fa-users-gear'; break;
                }
                hierarchyCellHtml = `<i class="expand-icon fas ${hasChildren ? (isExpanded ? 'fa-minus-square' : 'fa-plus-square') : ''}"></i> <i class="hierarchy-icon fas ${iconClass}"></i> ${displayName}`;
            }
            
            const visibleMetricGroups = getVisibleMetricGroups(summary); 
            let metricCellsHtml = `<td class="overall-summary-col">${renderCell(summary, rowData)}</td>`;
            
            for (const topic in catalogToRender) {
                const subtopicsInCatalog = catalogToRender[topic];
                const subtopicsInData = visibleMetricGroups[topic] || [];

                const isColExpanded = state.ui.expandedCols.has(topic);
                if (isColExpanded) {
                    metricCellsHtml += subtopicsInCatalog.map(subtopicName => {
                        const sessions = subtopicsInData.filter(m => m.name === subtopicName);
                        let cellContent;

                        if (rowData.type === 'employee') {
                            if (sessions.length > 0) {
                                const latestSession = sessions.reduce((latest, current) => (parseDateTime(current.date) > parseDateTime(latest.date)) ? current : latest);
                                const totalAttended = sessions.reduce((sum, s) => sum + s.attended, 0);
                                const totalHours = sessions.reduce((sum, s) => sum + s.actualHours, 0);
                                const targetHours = sessions.reduce((sum, s) => sum + s.targetHours, 0);
                                cellContent = renderCompetencyCell({ ...latestSession, attended: totalAttended, total: sessions.length, actualHours: totalHours, targetHours: targetHours }, rowData, false);
                            } else {
                                cellContent = renderCompetencyCell({ name: subtopicName, attended: 0, total: 0, actualHours: 0, targetHours: 0, targetCompetency: 0, date: null, actualCompetency: 0 }, rowData, false);
                            }
                        } else {
                            const groupSummary = sessions.reduce((acc, metric) => { 
                                acc.attended += metric.attended; acc.total += metric.total; acc.actualHours += metric.actualHours; acc.targetHours += metric.targetHours; return acc; 
                            }, { attended: 0, total: 0, actualHours: 0, targetHours: 0 });
                             cellContent = renderTopicSummaryCell(groupSummary);
                        }
                        return `<td>${cellContent}</td>`;

                    }).join('');
                } else {
                     const groupSummary = subtopicsInData.reduce((acc, metric) => { 
                        acc.attended += metric.attended; acc.total += metric.total; acc.actualHours += metric.actualHours; acc.targetHours += metric.targetHours; return acc; 
                    }, { attended: 0, total: 0, actualHours: 0, targetHours: 0 });
                    
                    metricCellsHtml += `<td class="summary-col" colspan="1">${renderTopicSummaryCell(groupSummary)}</td>`;
                }
            }
            
            const rowClass = `${type} ${hasChildren ? 'expandable' : ''} ${isInitiallyHidden ? 'hidden' : ''}`;
            const hierarchyColAction = type !== 'employee' ? `data-action="toggle-row" data-id="${id}"` : '';

            // The magic happens here: for smaller screens, we wrap the metric cells in the scroll container.
            // For larger screens, we just output the cells directly.
            return `
                <tr data-id="${id}" data-parent-id="${parentId || ''}" data-level="${level}" class="${rowClass}">
                    <td class="hierarchy-col" ${hierarchyColAction}>${hierarchyCellHtml}</td>
                    
                    <!-- This container is only used for the mobile layout via CSS -->
                    <div class="metrics-scroll-container">
                        ${metricCellsHtml}
                    </div>
                </tr>
            `;
        }
        // END: REDESIGNED `renderRow` FUNCTION


        function renderTable(viewData) {
            const { topic: selectedTopics, subtopic: selectedSubtopics } = state.ui.filters.topicFilters;
            let catalogToRender = trainingCatalog;

            if (selectedTopics.length > 0 || selectedSubtopics.length > 0) {
                const filteredCatalog = {};
                if (selectedSubtopics.length > 0) {
                    for (const topic in trainingCatalog) {
                        const relevantSubtopics = trainingCatalog[topic].filter(sub => selectedSubtopics.includes(sub));
                        if (relevantSubtopics.length > 0) {
                            if (selectedTopics.length === 0 || selectedTopics.includes(topic)) {
                                filteredCatalog[topic] = relevantSubtopics;
                            }
                        }
                    }
                } else if (selectedTopics.length > 0) {
                    selectedTopics.forEach(topic => {
                        if (trainingCatalog[topic]) {
                            filteredCatalog[topic] = trainingCatalog[topic];
                        }
                    });
                }
                catalogToRender = filteredCatalog;
            }

            let header1Html = '';
            let header2Html = '';
            for (const topic in catalogToRender) {
                const subtopics = catalogToRender[topic];
                const isColExpanded = state.ui.expandedCols.has(topic);
                const colspan = isColExpanded ? subtopics.length : 1;
                const iconClass = isColExpanded ? 'fa-minus-circle' : 'fa-plus-circle';
                header1Html += `<th class="shrinkable-header" colspan="${colspan}" data-action="toggle-column" data-col-group="${topic}">${topic} <i class="toggle-icon-col fas ${iconClass}"></i></th>`;
                if (isColExpanded) {
                    header2Html += subtopics.map(m => `<th>${m}</th>`).join('');
                } else {
                    header2Html += `<th class="summary-col" colspan="1">Summary</th>`;
                }
            }
            
            let serialCounter = (state.ui.pagination.currentPage - 1) * state.ui.pagination.rowsPerPage;
            const finalBodyHtml = viewData.map(rowData => {
                let currentNumber = null;
                if (rowData.isPaginatedVisible && rowData.type === 'employee') {
                    serialCounter++;
                    currentNumber = serialCounter;
                }
                return renderRow(rowData, currentNumber, catalogToRender);
            }).join('');
            
            return `
                <div class="table-container">
                    <table class="interactive-table">
                        <thead>
                            <tr>
                                <th rowspan="2" class="hierarchy-col">Hierarchy</th>
                                <!-- The scroll container is not used in the header -->
                                <th rowspan="2" class="overall-summary-col">Overall Summary</th>
                                ${header1Html}
                            </tr>
                            <tr>${header2Html}</tr>
                        </thead>
                        <tbody>${finalBodyHtml}</tbody>
                    </table>
                </div>`;
        }
        
        function updateChartTitles() {
            const { topic, subtopic } = state.ui.filters.topicFilters;
            let filterText = '';

            if (subtopic.length === 1) {
                filterText = subtopic[0];
            } else if (subtopic.length > 1) {
                filterText = `${subtopic.length} Sub-Topics`;
            } else if (topic.length === 1) {
                filterText = topic[0];
            } else if (topic.length > 1) {
                filterText = `${topic.length} Topics`;
            }

            const titles = {
                'summary-chart': 'Training Attendance Summary',
                'hours-chart': 'Training Hours Analysis',
                'averages-chart': 'Employee Training Averages',
                'role-wise-chart': 'Role Wise Training Status'
            };

            for (const id in titles) {
                const titleElement = document.getElementById(`${id}-title`);
                if (titleElement) {
                    titleElement.textContent = filterText ? `${titles[id]} (Filtered by: ${filterText})` : titles[id];
                }
            }
        }

        function renderControls() {
            const { visibleMetrics, filters } = state.ui;
            const metrics = [
                { id: 'attended', label: 'Attended' }, { id: 'not-attended', label: 'Not Attended' },
                { id: 'hours-achieved', label: 'Hours Achieved' }, { id: 'hours-target', 'label': 'Hours Target' },
                { id: 'avg-training', label: 'Avg Training / Emp' }, { id: 'avg-hours', label: 'Avg Hours / Emp' },
            ];
            
            // Desktop Layout Parts
            const desktopMetricToggles = `<div class="desktop-only" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">${metrics.map(m => `<div class="toggle-item ${visibleMetrics.has(m.id) ? 'active' : ''}" data-action="toggle-metric" data-metric-id="${m.id}"><span class="toggle-box"><i class="fas fa-check"></i></span><span class="toggle-label">${m.label}</span></div>`).join('')}</div>`;
            const desktopHierarchyFilters = `<div class="desktop-only filter-group"> <div id="region-filter-container" class="custom-select-filter" data-filter-type="region"></div> <div id="unit-filter-container" class="custom-select-filter" data-filter-type="unit"></div> <div id="department-filter-container" class="custom-select-filter" data-filter-type="department"></div> <div id="role-filter-container" class="custom-select-filter" data-filter-type="role"></div> <div id="employee-filter-container" class="custom-select-filter" data-filter-type="employees"></div></div>`;
            const desktopFoodHandlerFilter = `<div class="desktop-only filter-group"><label for="filter-food-handler">Food Handler:</label><select id="filter-food-handler"><option value="" ${filters.isFoodHandler === '' ? 'selected' : ''}>All</option><option value="yes" ${filters.isFoodHandler === 'yes' ? 'selected' : ''}>Yes</option><option value="no" ${filters.isFoodHandler === 'no' ? 'selected' : ''}>No</option></select></div>`;

            // Mobile Layout Parts
            const mobileFilterButtons = `<div class="mobile-only"> <button id="mobile-metric-filter-btn" class="action-button" data-action="open-metric-filter"><i class="fas fa-chart-pie"></i> Display Metrics</button> <button id="mobile-general-filter-btn" class="action-button" data-action="open-general-filter"><i class="fas fa-users-cog"></i> General Filters</button> </div>`;
            const mobileCombinedButtons = `<div class="mobile-flex-group"> <button id="mobile-topic-filter-btn" class="action-button" data-action="open-topic-filter" style="background-color: #007bff;"><i class="fas fa-filter"></i> Topic Filters</button> <button id="mobile-period-filter-btn" class="action-button" data-action="open-period-filter" style="background-color: #007bff;"><i class="fas fa-calendar-alt"></i> Period Filters</button> </div>`;

            // Common Parts
            const viewModeSlider = `<div class="view-mode-toggle"><span>Overall</span><label class="switch"><input type="checkbox" id="view-mode-slider" ${state.ui.viewMode === 'individual' ? 'checked' : ''}><span class="slider round"></span></label><span>Individual</span></div>`;
            const employeeCountDisplay = `<div id="employee-count-display" class="filter-group"></div>`;
            const graphToggleButton = `<button id="graph-toggle-btn" class="action-button" data-action="toggle-graphs" style="background-color: #555;"><i class="fas fa-eye-slash"></i> Hide Graphs</button>`;
            const refreshButton = `<button class="action-button refresh" data-action="refresh" title="Refresh Data"><i class="fas fa-sync-alt"></i></button>`;
            const downloadButton = `<button class="action-button excel" data-action="open-download-modal"><i class="fas fa-file-excel"></i> Download Report</button>`;

            return `
                <div class="dashboard-controls">
                    ${desktopMetricToggles}
                    ${viewModeSlider}
                    ${mobileFilterButtons}
                    <div class="desktop-only" style="display:flex; gap: 15px;">
                        <button class="action-button" data-action="open-topic-filter" style="background-color: #007bff;" title="Filter by Training Topic"><i class="fas fa-filter"></i> Topic Filters</button>
                        <button class="action-button" data-action="open-period-filter" style="background-color: #007bff;"><i class="fas fa-calendar-alt"></i> Period Filters</button>
                    </div>
                    ${mobileCombinedButtons}
                    ${desktopFoodHandlerFilter}
                    ${employeeCountDisplay}
                    ${graphToggleButton}
                    ${desktopHierarchyFilters}
                    ${refreshButton}
                    ${downloadButton}
                </div>`;
        }
        
        function renderPagination() { if (state.ui.filters.employees.length > 0) { return ''; } const { currentPage, totalPages, rowsPerPage, totalRows } = state.ui.pagination; let pageInfo = `Page ${totalPages > 0 ? currentPage : 0} of ${totalPages}`; if (rowsPerPage === -1) { pageInfo = `Showing all ${totalRows} items`; } return ` <div class="pagination-controls"> <div class="pagination-item"> <label for="rows-per-page">Rows per page:</label> <select id="rows-per-page" data-action="change-rows-per-page"> <option value="20" ${rowsPerPage === 20 ? 'selected' : ''}>20</option> <option value="50" ${rowsPerPage === 50 ? 'selected' : ''}>50</option> <option value="100" ${rowsPerPage === 100 ? 'selected' : ''}>100</option> <option value="-1" ${rowsPerPage === -1 ? 'selected' : ''}>All</option> </select> </div> <div class="pagination-item"> <button id="prev-page-btn" data-action="change-page" data-direction="-1" ${currentPage === 1 ? 'disabled' : ''} title="Previous Page"><i class="fas fa-chevron-left"></i></button> <span id="page-info">${pageInfo}</span> <button id="next-page-btn" data-action="change-page" data-direction="1" ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''} title="Next Page"><i class="fas fa-chevron-right"></i></button> </div> </div> `; }
        
        // --- HIERARCHY FILTER FIX: INCORPORATED ---
        /**
         * Filters the raw data based on the selected hierarchy filters.
         * This version uses a progressive filtering approach, ensuring that selections at higher
         * levels of the hierarchy correctly constrain the data available to lower levels.
         * @param {Array} data - The array of root nodes to filter (typically state.rawData).
         * @param {Object} filters - The current filter state from state.ui.filters.
         * @returns {Object} An object containing the filtered nodes as `nodesForTable`.
         */
        function getFilteredData(data, filters) {
            const { 
                region: selectedRegions, 
                unit: selectedUnits, 
                department: selectedDepartments, 
                employees: selectedEmployees 
            } = filters;

            // If a specific employee is selected, that takes highest precedence.
            if (selectedEmployees.length > 0) {
                const employeeNodes = getAllNodesByType(data, 'employee').filter(emp => selectedEmployees.includes(`${emp.name} ${emp.employeeIdNum}`));
                return { nodesForTable: employeeNodes };
            }

            // Start with the top-level nodes (the single corporate node in an array)
            let nodes = data;

            // Progressively filter down the hierarchy
            if (selectedRegions.length > 0) {
                // Find all regions within the current set of nodes, then filter by selection
                nodes = getAllNodesByType(nodes, 'region').filter(r => selectedRegions.includes(getContextualName(r)));
            }

            if (selectedUnits.length > 0) {
                // Find all units within the already-filtered nodes, then filter by selection
                nodes = getAllNodesByType(nodes, 'unit').filter(u => selectedUnits.includes(getContextualName(u)));
            }

            if (selectedDepartments.length > 0) {
                // Find all departments within the already-filtered nodes, then filter by selection
                nodes = getAllNodesByType(nodes, 'department').filter(d => selectedDepartments.includes(getContextualName(d)));
            }
            
            // Return the most specific set of nodes selected
            return { nodesForTable: nodes };
        }
        
        function getAvailableFilterOptions(rawData, currentFilters) {
            const options = { regions: new Set(), units: new Set(), departments: new Set(), roles: new Set(), employees: new Set() };
            const allRegions = getAllNodesByType(rawData, 'region');
            allRegions.forEach(r => options.regions.add(getContextualName(r)));
            const regionsToScan = currentFilters.region.length > 0 ? allRegions.filter(r => currentFilters.region.includes(getContextualName(r))) : allRegions;
            const allUnitsInScope = regionsToScan.flatMap(r => r.children || []).filter(u => u.type === 'unit');
            allUnitsInScope.forEach(u => options.units.add(getContextualName(u)));
            const unitsToScan = currentFilters.unit.length > 0 ? allUnitsInScope.filter(u => currentFilters.unit.includes(getContextualName(u))) : allUnitsInScope;
            const allDepartmentsInScope = unitsToScan.flatMap(u => u.children || []).filter(d => d.type === 'department');
            allDepartmentsInScope.forEach(d => options.departments.add(getContextualName(d)));
            const departmentsToScan = currentFilters.department.length > 0 ? allDepartmentsInScope.filter(d => currentFilters.department.includes(getContextualName(d))) : allDepartmentsInScope;
            const allEmployeesInScope = departmentsToScan.flatMap(d => d.children || []).filter(e => e.type === 'employee');
            allEmployeesInScope.forEach(e => { options.employees.add(`${e.name} ${e.employeeIdNum}`); if (e.role) options.roles.add(e.role); });
            return { regions: [...options.regions].sort(), units: [...options.units].sort(), departments: [...options.departments].sort(), employees: [...options.employees].sort(), roles: [...options.roles].sort() };
        }
        
        function updateFilterControls() {
            const { regions, units, departments, employees: employeeItems, roles } = state.globalFilterOptions;
            const { region: selectedRegions, unit: selectedUnits, department: selectedDepartments, employees: selectedEmployees, role: selectedRoles } = state.ui.filters;
            
            const updateSelect = (container, items, selectedItems, placeholder) => {
                if (!container) return;
                const button = container.querySelector('.select-button');
                const list = container.querySelector('.select-list');
                const search = container.querySelector('.select-search');
                list.innerHTML = ''; // Clear previous options
                items.forEach(item => { const isChecked = selectedItems.includes(item); list.innerHTML += `<label><input type="checkbox" value="${item}" ${isChecked ? 'checked' : ''}><span>${item}</span></label>`; });
                if (button) {
                    if (selectedItems.length === 0) { button.textContent = placeholder; } 
                    else if (selectedItems.length === 1) { const shortName = selectedItems[0].split(' (ID:')[0]; button.textContent = shortName; } 
                    else { button.textContent = `${selectedItems.length} selected`; }
                }
                if (search) search.placeholder = `Search ${placeholder}...`;
            };

            const regionFilterContainer = document.getElementById('region-filter-container');
            if (regionFilterContainer) {
                if(!regionFilterContainer.innerHTML) regionFilterContainer.innerHTML = `<button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search"><div class="select-list"></div></div>`;
                updateSelect(regionFilterContainer, regions, selectedRegions, 'All Regions');
            }
            const unitFilterContainer = document.getElementById('unit-filter-container');
            if (unitFilterContainer) {
                if(!unitFilterContainer.innerHTML) unitFilterContainer.innerHTML = `<button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search"><div class="select-list"></div></div>`;
                updateSelect(unitFilterContainer, units, selectedUnits, 'All Units');
            }
            const departmentFilterContainer = document.getElementById('department-filter-container');
            if(departmentFilterContainer){
                if(!departmentFilterContainer.innerHTML) departmentFilterContainer.innerHTML = `<button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search"><div class="select-list"></div></div>`;
                updateSelect(departmentFilterContainer, departments, selectedDepartments, 'All Departments');
            }
            const roleFilterContainer = document.getElementById('role-filter-container');
            if(roleFilterContainer) {
                if(!roleFilterContainer.innerHTML) roleFilterContainer.innerHTML = `<button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search"><div class="select-list"></div></div>`;
                updateSelect(roleFilterContainer, roles, selectedRoles, 'All Roles');
            }
            const employeeFilterContainer = document.getElementById('employee-filter-container');
            if(employeeFilterContainer){
                if(!employeeFilterContainer.innerHTML) employeeFilterContainer.innerHTML = `<button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search"><div class="select-list"></div></div>`;
                updateSelect(employeeFilterContainer, employeeItems, selectedEmployees, 'All Employees');
            }
        }
        
        function autoExpandFilteredNodes() {
            const { region, unit, department } = state.ui.filters;
            if (department.length > 0 || unit.length > 0 || region.length > 0) {
                 const allNodes = getAllNodesByType(state.rawData, 'department').concat(getAllNodesByType(state.rawData, 'unit'), getAllNodesByType(state.rawData, 'region'));
                 allNodes.forEach(node => {
                     const contextualName = getContextualName(node);
                     if (department.includes(contextualName) || unit.includes(contextualName) || region.includes(contextualName)) {
                         state.ui.expandedRows.add(node.id);
                     }
                 });
            }
        }
        
        function processViewData() {
            calculateRollups(state.rawData[0]); 
            const { nodesForTable: initialNodes } = getFilteredData(state.rawData, state.ui.filters);
            const clonedNodes = deepClone(initialNodes);
            const prunedNodes = clonedNodes.map(node => filterTreeBySummary(node)).filter(node => node !== null); 
            autoExpandFilteredNodes();
            let flatData = flattenHierarchy(prunedNodes);
            let filteredData = applyFiltersToView(flatData); 
            state.viewData = applyPagination(filteredData);
        }

        function reprocessAndRender() { 
            state.globalFilterOptions = getAvailableFilterOptions(state.rawData, state.ui.filters);
            render({ fullRender: true, updateChart: true });
        }
        
        function render(options = { fullRender: false, updateTable: true, updatePagination: true, updateControls: true, updateChart: false }) {
            const container = document.getElementById('dashboard-container'); 
            if (!container) return;
            
            // Only re-process all data if we are doing a full render (e.g., filter change)
            if (options.fullRender || options.updateTable) {
                processViewData();
            }

            const tableContainer = container.querySelector('.table-container');
            const scrollPos = tableContainer ? { top: tableContainer.scrollTop, left: tableContainer.scrollLeft } : { top: 0, left: 0 };

            if (options.fullRender || container.innerHTML === '') {
                container.innerHTML = `
                    ${renderControls()}
                    ${renderAllChartsHtml()}
                    ${renderTable(state.viewData)}
                    ${renderPagination()}`;
                chartUpdater = initializeAllCharts();
            } else {
                if (options.updateTable) {
                    if (tableContainer) tableContainer.outerHTML = renderTable(state.viewData);
                }
                if (options.updatePagination) {
                    const paginationControls = container.querySelector('.pagination-controls');
                    const newPaginationHTML = renderPagination();
                    if (paginationControls) { if (newPaginationHTML) paginationControls.outerHTML = newPaginationHTML; else paginationControls.innerHTML = ''; } 
                    else if (newPaginationHTML) { container.insertAdjacentHTML('beforeend', newPaginationHTML); }
                }
                if (options.updateControls) {
                    const controls = container.querySelector('.dashboard-controls');
                    if (controls) controls.outerHTML = renderControls();
                }
            }
             if (options.updateTable) {
                const newTableContainer = container.querySelector('.table-container');
                if(newTableContainer) {
                    newTableContainer.scrollTop = scrollPos.top;
                    newTableContainer.scrollLeft = scrollPos.left;
                }
             }
            
            updateChartTitles();
            updateFilterControls();
            
            if (options.updateChart && state.ui.showGraphs) {
                if (chartUpdater) chartUpdater();
            }

            const countDisplay = document.getElementById('employee-count-display');
            if (countDisplay) {
                let fhCount = 0; let nfhCount = 0;
                const allVisibleEmployees = getUnpaginatedFilteredEmployeesForExport();
                allVisibleEmployees.forEach(employeeNode => { if (FOOD_HANDLER_ROLES.includes(employeeNode.role)) fhCount++; else nfhCount++; });
                countDisplay.innerHTML = `<span style="font-weight: 500; color: var(--secondary-text);"><i class="fas fa-users"></i> Filtered Total:</span><span title="Food Handlers"><i class="fas fa-utensils" style="color: var(--level1-color);"></i> ${fhCount}</span><span title="Non-Food Handlers"><i class="fas fa-user-tie" style="color: var(--download-btn-bg);"></i> ${nfhCount}</span>`;
            }
            // Update both desktop and mobile buttons
            const topicFilterButtons = document.querySelectorAll('[data-action="open-topic-filter"]');
            topicFilterButtons.forEach(btn => {
                const { topic, subtopic, proficiency } = state.ui.filters.topicFilters;
                const isActive = topic.length > 0 || subtopic.length > 0 || proficiency;
                btn.style.backgroundColor = isActive ? 'var(--level1-color)' : '#007bff';
                btn.innerHTML = isActive ? `<i class="fas fa-check-circle"></i> Topic Filters Active` : `<i class="fas fa-filter"></i> Topic Filters`;
            });
            const periodFilterButtons = document.querySelectorAll('[data-action="open-period-filter"]');
            periodFilterButtons.forEach(btn => {
                 const { dateRange, joiningDateRange } = state.ui.filters;
                const isActive = dateRange.from || dateRange.to || joiningDateRange.from || joiningDateRange.to;
                btn.style.backgroundColor = isActive ? 'var(--level1-color)' : '#007bff';
                btn.innerHTML = isActive ? `<i class="fas fa-check-circle"></i> Period Filters Active` : `<i class="fas fa-calendar-alt"></i> Period Filters`;
            });
            const generalFilterBtn = document.getElementById('mobile-general-filter-btn');
            if (generalFilterBtn) {
                 const { region, unit, department, role, employees, isFoodHandler } = state.ui.filters;
                 const isActive = region.length > 0 || unit.length > 0 || department.length > 0 || role.length > 0 || employees.length > 0 || isFoodHandler;
                 generalFilterBtn.style.backgroundColor = isActive ? 'var(--level1-color)' : '#007bff';
                 generalFilterBtn.innerHTML = isActive ? `<i class="fas fa-check-circle"></i> General Filters Active` : `<i class="fas fa-users-cog"></i> General Filters`;
            }

            // Restore scroll position if it was saved from a data update action
            if (lastScrollState) {
                const newTableContainer = document.querySelector('.table-container');
                if (newTableContainer) {
                    newTableContainer.scrollTop = lastScrollState.top;
                    newTableContainer.scrollLeft = lastScrollState.left;
                }
                lastScrollState = null; // Reset after use
            }
        }
        
        // START: OPTIMIZATION - This is the new, high-performance function for toggling rows.
        /**
         * Recursively toggles the visibility of child rows directly in the DOM.
         * This avoids a full table re-render and is extremely fast.
         * @param {string} parentId - The ID of the parent row to expand/collapse.
         * @param {boolean} expand - True to expand (show children), false to collapse (hide children).
         */
        function toggleRowVisibility(parentId, expand) {
            const childRows = document.querySelectorAll(`tr[data-parent-id="${parentId}"]`);

            childRows.forEach(child => {
                const childId = child.dataset.id;
                
                if (expand) {
                    child.classList.remove('hidden');
                    // If the child itself is marked as expanded in the state, recursively show its children.
                    if (state.ui.expandedRows.has(childId)) {
                        toggleRowVisibility(childId, true);
                    }
                } else {
                    // When collapsing, always hide all descendants.
                    child.classList.add('hidden');
                    toggleRowVisibility(childId, false);
                }
            });
        }
        // END: OPTIMIZATION

        function handleAction(e) {
            const actionTarget = e.target.closest('[data-action]'); if (!actionTarget) return;
            const { action, id, colGroup, metricId, employeeId, metricName } = actionTarget.dataset;
            let shouldReprocess = false;
            let renderOptions = { updateTable: true, updatePagination: true, updateControls: false, updateChart: true };
            
            const actions = {
                // START: OPTIMIZATION - Rewritten toggle-row action to be instantaneous.
                // This is the core of the performance improvement. It no longer re-renders the table.
                'toggle-row': () => {
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (!row) return;

                    const isCurrentlyExpanded = state.ui.expandedRows.has(id);
                    const expand = !isCurrentlyExpanded; // The new desired state

                    // 1. Update the state (source of truth)
                    if (expand) {
                        state.ui.expandedRows.add(id);
                    } else {
                        state.ui.expandedRows.delete(id);
                    }

                    // 2. Update the icon on the clicked row immediately
                    const icon = row.querySelector('.expand-icon');
                    if (icon) {
                        icon.classList.toggle('fa-plus-square', !expand);
                        icon.classList.toggle('fa-minus-square', expand);
                    }

                    // 3. Call the fast DOM manipulation function to show/hide children
                    toggleRowVisibility(id, expand);
                    
                    // 4. Prevent the slow full-table re-render for this action
                    renderOptions.updateTable = false;
                    renderOptions.updatePagination = false;
                    renderOptions.updateChart = false;
                },
                // END: OPTIMIZATION
                'toggle-column': () => {
                     const tableContainer = document.querySelector('.table-container');
                     if (tableContainer) { lastScrollState = { top: tableContainer.scrollTop, left: tableContainer.scrollLeft }; }
                     state.ui.expandedCols.has(colGroup) ? state.ui.expandedCols.delete(colGroup) : state.ui.expandedCols.add(colGroup);
                     // This still needs a re-render because it changes the table structure (headers, colspan)
                     render({ updateTable: true, updatePagination: true, updateControls: false, updateChart: false });
                },
                // --- START: NEW MODAL ACTIONS ---
                // This logic correctly populates and displays modals for a responsive mobile experience.
                'open-metric-filter': () => {
                    const modalBody = document.querySelector('#metric-filter-modal .modal-body');
                    const metrics = [
                        { id: 'attended', label: 'Attended' }, { id: 'not-attended', label: 'Not Attended' },
                        { id: 'hours-achieved', label: 'Hours Achieved' }, { id: 'hours-target', 'label': 'Hours Target' },
                        { id: 'avg-training', label: 'Avg Training / Emp' }, { id: 'avg-hours', label: 'Avg Hours / Emp' },
                    ];
                    modalBody.innerHTML = metrics.map(m => `<div class="toggle-item ${state.ui.visibleMetrics.has(m.id) ? 'active' : ''}" data-action="toggle-metric" data-metric-id="${m.id}"><span class="toggle-box"><i class="fas fa-check"></i></span><span>${m.label}</span></div>`).join('');
                    document.getElementById('metric-filter-modal-overlay').classList.add('active');
                },
                'close-metric-filter': () => document.getElementById('metric-filter-modal-overlay').classList.remove('active'),
                'open-general-filter': () => {
                    const modalBody = document.querySelector('#general-filter-modal .modal-body');
                    const { filters } = state.ui;
                    modalBody.innerHTML = `
                        <div class="form-group"><label>Region:</label><div id="region-filter-container" class="custom-select-filter" data-filter-type="region"></div></div>
                        <div class="form-group"><label>Unit:</label><div id="unit-filter-container" class="custom-select-filter" data-filter-type="unit"></div></div>
                        <div class="form-group"><label>Department:</label><div id="department-filter-container" class="custom-select-filter" data-filter-type="department"></div></div>
                        <div class="form-group"><label>Role:</label><div id="role-filter-container" class="custom-select-filter" data-filter-type="role"></div></div>
                        <div class="form-group"><label>Employee:</label><div id="employee-filter-container" class="custom-select-filter" data-filter-type="employees"></div></div>
                        <div class="form-group"><label>Food Handler:</label><select id="filter-food-handler"><option value="">All</option><option value="yes">Yes</option><option value="no">No</option></select></div>
                    `;
                    document.getElementById('filter-food-handler').value = filters.isFoodHandler;
                    updateFilterControls(); // Populate the new containers
                    document.getElementById('general-filter-modal-overlay').classList.add('active');
                },
                'close-general-filter': () => document.getElementById('general-filter-modal-overlay').classList.remove('active'),
                'clear-general-filter': () => {
                    Object.assign(state.ui.filters, { region: [], unit: [], department: [], employees: [], role: [], isFoodHandler: '' });
                    document.getElementById('general-filter-modal-overlay').classList.remove('active');
                    shouldReprocess = true;
                },
                // --- END: NEW MODAL ACTIONS ---
                 'download-training-card': () => {
                    const cardContent = document.getElementById('training-card-content');
                    const modal = document.getElementById('training-card-modal');
                    if (!cardContent || !modal) return;
                    
                    modal.style.maxWidth = '1000px';

                    html2canvas(cardContent, { scale: 2, backgroundColor: '#ffffff' }).then(canvas => {
                        const { jsPDF } = window.jspdf;
                        const imgData = canvas.toDataURL('image/png');
                        const pdf = new jsPDF({
                            orientation: 'portrait',
                            unit: 'px',
                            format: [canvas.width, canvas.height]
                        });
                        pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                        pdf.save('employee-training-card.pdf');
                        
                        modal.style.maxWidth = '90vw';
                    });
                },
                'open-training-card': () => {
                    const cardContentEl = document.getElementById('training-card-content');
                    const cardStylesEl = document.getElementById('training-card-dynamic-styles');
                    cardStylesEl.textContent = `
                        #training-card-content { font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #1f2937; line-height: 1.5; font-size: 10pt; margin: 0; padding: 20pt; background-color: #ffffff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                        #training-card-content .header-content { display: flex; justify-content: space-between; align-items: center; }
                        #training-card-content .document-title { font-size: 16pt; font-weight: 700; letter-spacing: -0.5px; }
                        #training-card-content .document-subtitle { font-size: 9pt; opacity: 0.9; margin-top: 2px; font-weight: 400; }
                        #training-card-content .document-meta { text-align: right; font-size: 8pt; background: rgba(255,255,255,0.15); padding: 6pt 8pt; border-radius: 4px; }
                        #training-card-content .meta-item { display: flex; justify-content: flex-end; gap: 8px; }
                        #training-card-content .meta-label { font-weight: 500; }
                        #training-card-content .employee-section { display: grid; grid-template-columns: auto 1fr; gap: 20pt; margin-bottom: 25pt; background: #f9fafb; padding: 15pt; border-radius: 8px; border: 1px solid #e5e7eb; }
                        #training-card-content .employee-photo { width: 90pt; height: 90pt; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 9pt; font-weight: 500; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
                        #training-card-content .employee-photo img { width: 100%; height: 100%; object-fit: cover; }
                        #training-card-content .employee-details { display: grid; grid-template-columns: 1fr 1fr; gap: 10pt 20pt; }
                        #training-card-content .detail-item { display: flex; align-items: center; }
                        #training-card-content .detail-label { font-weight: 500; min-width: 100pt; color: #4b5563; font-size: 9pt; }
                        #training-card-content .detail-value { font-weight: 500; }
                        #training-card-content .summary-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12pt; margin-bottom: 20pt; }
                        #training-card-content .summary-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12pt; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
                        #training-card-content .summary-card-title { font-size: 8pt; text-transform: uppercase; letter-spacing: 0.5pt; color: #6b7280; margin-bottom: 6pt; font-weight: 600; }
                        #training-card-content .summary-card-value { font-size: 16pt; font-weight: 700; color: #4f46e5; letter-spacing: -0.5px; }
                        #training-card-content .summary-card-description { font-size: 8pt; color: #9ca3af; margin-top: 2pt; }
                        #training-card-content .section-title { font-size: 12pt; font-weight: 600; color: #111827; margin: 15pt 0 10pt; padding-bottom: 5pt; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; }
                        #training-card-content .section-title svg { margin-right: 8pt; width: 14pt; height: 14pt; color: #4f46e5; }
                        #training-card-content .training-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 15pt 0; page-break-inside: avoid; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
                        #training-card-content .training-table th { background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); color: white; padding: 10pt 12pt; text-align: left; font-weight: 600; font-size: 9pt; text-transform: uppercase; letter-spacing: 0.5pt; }
                        #training-card-content .training-table th:first-child { border-top-left-radius: 8px; }
                        #training-card-content .training-table th:last-child { border-top-right-radius: 8px; }
                        #training-card-content .training-table td { padding: 12pt; border-bottom: 1px solid #e5e7eb; vertical-align: top; background-color: #ffffff; }
                        #training-card-content .training-table tr:last-child td { border-bottom: none; }
                        #training-card-content .training-topic { font-weight: 600; display: flex; align-items: center; gap: 8pt; }
                        #training-card-content .training-status { display: inline-block; width: 10pt; height: 10pt; border-radius: 50%; background-color: #10b981; flex-shrink: 0; }
                        #training-card-content .training-date { font-weight: 500; white-space: nowrap; }
                        #training-card-content .training-time { color: #6b7280; font-size: 9pt; margin-top: 3pt; }
                        #training-card-content .trainer-info { display: flex; align-items: center; gap: 8pt; }
                        #training-card-content .trainer-avatar { width: 24pt; height: 24pt; border-radius: 50%; background-color: #e0e7ff; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 8pt; font-weight: 600; flex-shrink: 0; }
                        #training-card-content .trainer-details { line-height: 1.4; }
                        #training-card-content .trainer-name { font-weight: 500; }
                        #training-card-content .trainer-title { color: #6b7280; font-size: 8pt; }
                        #training-card-content .status-badge { display: inline-block; padding: 4pt 8pt; border-radius: 20pt; font-size: 8pt; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5pt; }
                        #training-card-content .status-completed { background-color: #ecfdf5; color: #10b981; }
                        #training-card-content .status-container { display: flex; flex-direction: column; align-items: flex-start; gap: 6pt; }
                        #training-card-content .action-links { display: flex; flex-direction: column; align-items: flex-start; gap: 4pt; }
                        #training-card-content .action-link { display: inline-flex; align-items: center; gap: 4pt; font-size: 8pt; color: #6b7280; text-decoration: none; font-weight: 500; transition: color 0.2s; }
                        #training-card-content .action-link:hover { color: #4f46e5; }
                        #training-card-content .action-link svg { width: 11pt; height: 11pt; flex-shrink: 0; color: #9ca3af; transition: color 0.2s; }
                        #training-card-content .action-link:hover svg { color: #4f46e5; }
                        #training-card-content .certificate-badge { display: inline-flex; align-items: center; gap: 4pt; background: linear-gradient(90deg, #10b981 0%, #34d399 100%); color: white; padding: 3pt 8pt 3pt 6pt; border-radius: 20pt; font-size: 8pt; font-weight: 600; margin-left: 8pt; }
                        #training-card-content .signature-section { display: grid; grid-template-columns: 1fr 1fr; gap: 40pt; margin-top: 40pt; page-break-inside: avoid; }
                        #training-card-content .signature-box { height: 40pt; border-bottom: 1px solid #d1d5db; margin-bottom: 8pt; position: relative; }
                        #training-card-content .signature-stamp { position: absolute; right: 0; bottom: -5pt; width: 60pt; opacity: 0.8; }
                        #training-card-content .signature-label { font-size: 9pt; color: #6b7280; text-align: left; margin-bottom: 3pt; }
                        #training-card-content .signature-name { font-weight: 600; text-align: left; margin-top: 3pt; }
                        #training-card-content .signature-details { font-size: 8pt; color: #9ca3af; margin-top: 2pt; }
                        #training-card-content .footer-note { font-size: 8pt; color: #9ca3af; text-align: center; margin-top: 25pt; padding-top: 10pt; border-top: 1px solid #e5e7eb; line-height: 1.6; position: relative; }
                        #training-card-content .watermark { position: fixed; opacity: 0.03; font-size: 72pt; color: #4f46e5; transform: rotate(-30deg); top: 40%; left: 20%; z-index: -1; font-weight: 700; letter-spacing: 2pt; }
                        #training-card-content .qr-code { position: absolute; right: 0; bottom: 0; width: 60pt; height: 60pt; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #9ca3af; font-size: 6pt; text-align: center; padding: 5pt; box-sizing: border-box; }
                        #training-card-content .qr-code img { width: 40pt; height: 40pt; margin-bottom: 3pt; }
                    `;
                    cardContentEl.innerHTML = `
                        <div class="watermark">TRAINING RECORD</div><div id="header"><div class="header-content"><div><div class="document-title">EMPLOYEE TRAINING RECORD</div><div class="document-subtitle">Comprehensive training history and certifications</div></div><div class="document-meta"><div class="meta-item"><span class="meta-label">DOC ID:</span><span>TR-151-002246</span></div><div class="meta-item"><span class="meta-label">GENERATED:</span><span>05-Jul-2023</span></div><div class="meta-item"><span class="meta-label">VALID THRU:</span><span>05-Jul-2024</span></div></div></div></div><div class="employee-section"><div class="employee-photo"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iIzRmNDZlNSI+PHBhdGggZD0iTTEyIDJDNi40NzcgMiAyIDYuNDc3IDIgMTJzNC40NzcgMTAgMTAgMTAgMTAtNC40NzcgMTAtMTBTMTcuNTIzIDIgMTIgMnptMCAyYzIuMzIzIDAgNC40MzYuODA0IDYuMDU1IDIuMTQ1TDE3LjA2IDguMDRjLS41NzgtLjU5MS0xLjM0OC0uOTYtMi4yMjQtLjk2aC0uMDFjLTEuOTMzIDAtMy41IDEuNTY3LTMuNSAzLjUgMCAuODc2LjM2OSAxLjY0Ni45NiAyLjIyNGwtMy4xOTUgMy45MDlDNy4xOTYgMTYuNTM2IDYgMTQuNDIzIDYgMTJjMC0zLjMxNCAyLjY4Ni02IDYtNnptLjc3NiA5LjQyNGMuNTkzLjU3MyAxLjM4Ni45MjYgMi4yMjQuOTI2IDEuOTMzIDAgMy41LTEuNTY3IDMuNS0zLjUgMC0uODM4LS4zNTMtMS42MzEtLjkyNi0yLjIyNGwzLjg5NS0zLjg5QzE2LjgwNCA3LjU2NCAxNy44NzcgNyAxOSA3YzIuNzYxIDAgNSAyLjIzOSA1IDUgMCAxLjEyMy0uNTY0IDIuMTk2LTEuNDg2IDIuOTc0bC0zLjg5LTMuODl6TTQgMTJjMCAxLjQ2Ni40ODMgMi44NCAxLjI2OSAzLjg5NWwzLjg5LTMuODljLjU5MS41NzguOTYgMS4zNDguOTYgMi4yMjRDMTAuMTE5IDE1LjM1MyA4LjY1MyAxNiA3IDE2Yy0yLjc2MSAwLTUtMi4yMzktNS01eiIvPjwvc3ZnPg==" alt="Employee Photo"></div><div class="employee-details"><div class="detail-item"><div class="detail-label">Employee Name:</div><div class="detail-value">Ganesh Yadav</div></div><div class="detail-item"><div class="detail-label">Employee ID:</div><div class="detail-value">151-002246</div></div><div class="detail-item"><div class="detail-label">Department:</div><div class="detail-value">Engineering</div></div><div class="detail-item"><div class="detail-label">Designation:</div><div class="detail-value">Guest Service Supervisor</div></div><div class="detail-item"><div class="detail-label">Date of Birth:</div><div class="detail-value">01-Jan-1970</div></div><div class="detail-item"><div class="detail-label">Date of Joining:</div><div class="detail-value">01-Jul-2023</div></div><div class="detail-item"><div class="detail-label">Contact Number:</div><div class="detail-value">+91 98765 43210</div></div><div class="detail-item"><div class="detail-label">Email:</div><div class="detail-value">ganesh.yadav@company.com</div></div></div></div><div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>Training Summary</div><div class="summary-cards"><div class="summary-card"><div class="summary-card-title">Total Trainings</div><div class="summary-card-value">5</div><div class="summary-card-description">All completed successfully</div></div><div class="summary-card"><div class="summary-card-title">Training Hours</div><div class="summary-card-value">38h</div><div class="summary-card-description">65% of annual target</div></div><div class="summary-card"><div class="summary-card-title">Certifications</div><div class="summary-card-value">3</div><div class="summary-card-description">Industry recognized</div></div><div class="summary-card"><div class="summary-card-title">Last Training</div><div class="summary-card-value">20-Jun-2023</div><div class="summary-card-description">Advanced First Aid</div></div></div><div class="progress-container"><div class="progress-bar"></div></div><div class="progress-labels"><span>0h</span><span>Annual Target: 60h</span></div><div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>Training History</div><table class="training-table"><thead><tr><th style="width: 35%">Training Program</th><th style="width: 15%">Date</th><th style="width: 10%">Duration</th><th style="width: 25%">Trainer</th><th style="width: 15%">Status</th></tr></thead><tbody><tr class="certificate-row"><td><div class="training-topic"><span class="training-status"></span>FSSAI Certification<span class="certificate-badge"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>CERTIFIED</span></div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">Food Safety and Standards Authority of India</div></td><td><div class="training-date">16-Jan-2023</div><div class="training-time">10:00 AM - 6:00 PM</div></td><td>8h</td><td><div class="trainer-info"><div class="trainer-avatar">PC</div><div class="trainer-details"><div class="trainer-name">Mr. Prem Chand Sharma</div><div class="trainer-title">FSSAI Certified Trainer</div></div></div></td><td><div class="status-container"><div><span class="status-badge status-completed">Completed</span></div><div class="action-links"><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.5 2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5c0 1.519 1.231 2.75 2.75 2.75h3.5A2.75 2.75 0 0014 5V2.75a.75.75 0 00-.75-.75z" clip-rule="evenodd" /><path d="M3.25 8.006a2.5 2.5 0 012.5-2.5h8.5a2.5 2.5 0 012.5 2.5v7.244a2.5 2.5 0 01-2.5 2.5h-8.5a2.5 2.5 0 01-2.5-2.5V8.006zM7.5 10a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5zM7.5 12.5a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5z" /></svg>Attendance Sheet</a><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.504 3.125A2.25 2.25 0 0013.25 1h-8.5A2.25 2.25 0 002.5 3.25v13.5A2.25 2.25 0 004.75 19h10.5A2.25 2.25 0 0017.5 16.75V7.125A2.25 2.25 0 0015.504 3.125zm-2.13 5.197L9.93 11.765l-1.56-1.56a.75.75 0 00-1.06 1.06l2.09 2.09a.75.75 0 001.06 0l4.03-4.03a.75.75 0 00-1.06-1.06z" clip-rule="evenodd" /></svg>View Certificate</a></div></div></td></tr><tr><td><div class="training-topic"><span class="training-status"></span>Workplace Safety</div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">Occupational health and safety standards</div></td><td><div class="training-date">10-Mar-2023</div><div class="training-time">9:00 AM - 1:00 PM</div></td><td>4h</td><td><div class="trainer-info"><div class="trainer-avatar">PS</div><div class="trainer-details"><div class="trainer-name">Ms. Priya Singh</div><div class="trainer-title">Safety Officer</div></div></div></td><td><div class="status-container"><div><span class="status-badge status-completed">Completed</span></div><div class="action-links"><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.5 2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5c0 1.519 1.231 2.75 2.75 2.75h3.5A2.75 2.75 0 0014 5V2.75a.75.75 0 00-.75-.75z" clip-rule="evenodd" /><path d="M3.25 8.006a2.5 2.5 0 012.5-2.5h8.5a2.5 2.5 0 012.5 2.5v7.244a2.5 2.5 0 01-2.5 2.5h-8.5a2.5 2.5 0 01-2.5-2.5V8.006zM7.5 10a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5zM7.5 12.5a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5z" /></svg>Attendance Sheet</a></div></div></td></tr><tr class="certificate-row"><td><div class="training-topic"><span class="training-status"></span>Customer Service Excellence<span class="certificate-badge"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>CERTIFIED</span></div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">Advanced customer interaction techniques</div></td><td><div class="training-date">05-Apr-2023</div><div class="training-time">2:00 PM - 5:00 PM</div></td><td>3h</td><td><div class="trainer-info"><div class="trainer-avatar">RK</div><div class="trainer-details"><div class="trainer-name">Mr. Rajesh Kumar</div><div class="trainer-title">HR Department</div></div></div></td><td><div class="status-container"><div><span class="status-badge status-completed">Completed</span></div><div class="action-links"><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.5 2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5c0 1.519 1.231 2.75 2.75 2.75h3.5A2.75 2.75 0 0014 5V2.75a.75.75 0 00-.75-.75z" clip-rule="evenodd" /><path d="M3.25 8.006a2.5 2.5 0 012.5-2.5h8.5a2.5 2.5 0 012.5 2.5v7.244a2.5 2.5 0 01-2.5 2.5h-8.5a2.5 2.5 0 01-2.5-2.5V8.006zM7.5 10a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5zM7.5 12.5a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5z" /></svg>Attendance Sheet</a><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.504 3.125A2.25 2.25 0 0013.25 1h-8.5A2.25 2.25 0 002.5 3.25v13.5A2.25 2.25 0 004.75 19h10.5A2.25 2.25 0 0017.5 16.75V7.125A2.25 2.25 0 0015.504 3.125zm-2.13 5.197L9.93 11.765l-1.56-1.56a.75.75 0 00-1.06 1.06l2.09 2.09a.75.75 0 001.06 0l4.03-4.03a.75.75 0 00-1.06-1.06z" clip-rule="evenodd" /></svg>View Certificate</a></div></div></td></tr><tr><td><div class="training-topic"><span class="training-status"></span>New Equipment Training</div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">Model XYZ-4000 operation and maintenance</div></td><td><div class="training-date">15-May-2023</div><div class="training-time">11:00 AM - 4:00 PM</div></td><td>5h</td><td><div class="trainer-info"><div class="trainer-avatar">AP</div><div class="trainer-details"><div class="trainer-name">Mr. Amit Patel</div><div class="trainer-title">Engineering Head</div></div></div></td><td><div class="status-container"><div><span class="status-badge status-completed">Completed</span></div><div class="action-links"><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.5 2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5c0 1.519 1.231 2.75 2.75 2.75h3.5A2.75 2.75 0 0014 5V2.75a.75.75 0 00-.75-.75z" clip-rule="evenodd" /><path d="M3.25 8.006a2.5 2.5 0 012.5-2.5h8.5a2.5 2.5 0 012.5 2.5v7.244a2.5 2.5 0 01-2.5 2.5h-8.5a2.5 2.5 0 01-2.5-2.5V8.006zM7.5 10a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5zM7.5 12.5a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5z" /></svg>Attendance Sheet</a></div></div></td></tr>
<tr class="certificate-row"><td><div class="training-topic"><span class="training-status"></span>Advanced First Aid<span class="certificate-badge"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>CERTIFIED</span></div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">Red Cross certified advanced first aid training</div></td><td><div class="training-date">20-Jun-2023</div><div class="training-time">10:00 AM - 6:00 PM</div>
</td>
<td>8h</td>
<td>
    <div class="trainer-info">
        <div class="trainer-avatar">NS</div>
        <div class="trainer-details">
            <div class="trainer-name">Dr. Neha Sharma</div>
            <div class="trainer-title">Medical Officer</div>
        </div>
    </div>
</td>
<td>
    <div class="status-container">
        <div><span class="status-badge status-completed">Completed</span></div>
        <div class="action-links">
            <a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.5 2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5h-2V2.75a.75.75 0 00-1.5 0V5c0 1.519 1.231 2.75 2.75 2.75h3.5A2.75 2.75 0 0014 5V2.75a.75.75 0 00-.75-.75z" clip-rule="evenodd" /><path d="M3.25 8.006a2.5 2.5 0 012.5-2.5h8.5a2.5 2.5 0 012.5 2.5v7.244a2.5 2.5 0 01-2.5 2.5h-8.5a2.5 2.5 0 01-2.5-2.5V8.006zM7.5 10a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5zM7.5 12.5a.75.75 0 000 1.5h5a.75.75 0 000-1.5h-5z" /></svg>Attendance Sheet</a>
            <a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.504 3.125A2.25 2.25 0 0013.25 1h-8.5A2.25 2.25 0 002.5 3.25v13.5A2.25 2.25 0 004.75 19h10.5A2.25 2.25 0 0017.5 16.75V7.125A2.25 2.25 0 0015.504 3.125zm-2.13 5.197L9.93 11.765l-1.56-1.56a.75.75 0 00-1.06 1.06l2.09 2.09a.75.75 0 001.06 0l4.03-4.03a.75.75 0 00-1.06-1.06z" clip-rule="evenodd" /></svg>View Certificate</a>
        </div>
    </div>
</td>
</tr>
</tbody></table>
<div class="signature-section"><div><div class="signature-label">Employee Signature</div><div class="signature-box"></div><div class="signature-name">Ganesh Yadav</div><div class="signature-details">ID: 151-002246 | Date: 05-Jul-2023</div></div><div><div class="signature-label">HR Manager Approval</div><div class="signature-box"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgNTAiIHN0eWxlPSJmb250LWZhbWlseTpBcmlhbDsiPjxwYXRoIGZpbGw9IiNkN2UxZmYiIGQ9Ik0wIDBoMTAwdjUwSDB6Ii8+PHRleHQgeD0iNTAiIHk9IjMwIiBmb250LXNpemU9IjgiIGZpbGw9IiM0ZjQ2ZTUiIGZvbnQtd2VpZhtPSJib2xkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5BUFBST1ZFRDwvdGV4dD48L3N2Zz4=" class="signature-stamp" alt="Approved Stamp"></div><div class="signature-name">Priya Sharma</div><div class="signature-details">HR Manager | Training Department</div></div></div><div class="footer-note"><div class="qr-code"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0yMCAyMGgxMHYxMEgyMHpNNDAgMjBoMTB2MTBINDB6TTIwIDQwaDEwdjEwSDIwek00MCA0MGgxMHYxMEg0MHpNNjAgMjBoMTB2MTBINjB6TTYwIDQwaDEwdjEwSDYwek04MCAyMGgxMHYxMEg4MHpNODAgNDBoMTB2MTBIODB6TTIwIDYwaDEwdjEwSDIwek00MCA2MGgxMHYxMEg0MHpNNjAgNjBoMTB2MTBINjB6TTgwIDYwaDEwdjEwSDgwem0tNjAgMjBoMTB2MTBINjB6IiBmaWxsPSIjMDAwIi8+PC9zdmc+" alt="QR Code">Scan to verify</div>This document is system generated and valid without physical signature.<br>For verification, please contact HR department at hr@company.com or call +91 1800 123 4567<br>© 2023 Company Name. All rights reserved.</div>
                    `;
                    document.getElementById('training-card-modal-overlay').classList.add('active');
                },
                'close-training-card': () => {
                    document.getElementById('training-card-dynamic-styles').textContent = '';
                    document.getElementById('training-card-modal-overlay').classList.remove('active');
                },
                'open-session-history': () => {
                    const employeeNode = findNodeById(state.rawData, employeeId);
                    if (!employeeNode) return;
                    
                    const sessions = Object.values(employeeNode.metrics).flat().filter(m => m.name === metricName);
                    sessions.sort((a, b) => {
                        const dateA = parseDateTime(a.date);
                        const dateB = parseDateTime(b.date);
                        if (!dateB) return -1;
                        if (!dateA) return 1;
                        return dateB - dateA;
                    });

                    const modalTitle = document.getElementById('session-history-title');
                    const modalBody = document.getElementById('session-history-table-body');
                    
                    modalTitle.textContent = `Session Details for ${employeeNode.name} - ${metricName}`;
                    modalBody.innerHTML = '';

                    if (sessions.length > 0) {
                        sessions.forEach(session => {
                            const sessionDate = parseDateTime(session.date);
                            const formattedDate = sessionDate ? sessionDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : 'Invalid Date';
                            const certLink = session.certificateUrl ? `<a href="${session.certificateUrl}" target="_blank">View PDF <i class="fas fa-external-link-alt"></i></a>` : 'N/A';
                            const sheetLink = session.trainingSheetUrl ? `<a href="${session.trainingSheetUrl}" target="_blank">View PDF <i class="fas fa-external-link-alt"></i></a>` : 'N/A';
                            modalBody.innerHTML += `<tr><td>${formattedDate}</td><td>${certLink}</td><td>${sheetLink}</td></tr>`;
                        });
                    } else {
                        modalBody.innerHTML = `<tr><td colspan="3" style="text-align: center;">No session history found.</td></tr>`;
                    }
                    
                    document.getElementById('session-history-modal-overlay').classList.add('active');
                },
                'close-session-history': () => document.getElementById('session-history-modal-overlay').classList.remove('active'),
                'toggle-metric': () => { state.ui.visibleMetrics.has(metricId) ? state.ui.visibleMetrics.delete(metricId) : state.ui.visibleMetrics.add(metricId); render({ updateTable: true, updateControls: true }); },
                'toggle-select-dropdown': () => { const p = actionTarget.closest('.custom-select-filter'); const a = p.classList.contains('active'); document.querySelectorAll('.custom-select-filter.active, .custom-date-filter.active').forEach(dd => dd.classList.remove('active')); if (!a) p.classList.add('active'); },
                'refresh': () => init(true),
                'toggle-graphs': () => {
                    state.ui.showGraphs = !state.ui.showGraphs;
                    const chartsSection = document.getElementById('charts-section');
                    const toggleBtn = document.getElementById('graph-toggle-btn');
                    chartsSection.classList.toggle('hidden');
                    if (toggleBtn) {
                        if (state.ui.showGraphs) {
                            toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Hide Graphs';
                        } else {
                            toggleBtn.innerHTML = '<i class="fas fa-eye"></i> Show Graphs';
                        }
                    }
                    renderOptions = { updateTable: false, updatePagination: false, updateControls: false, updateChart: false };
                },
                'open-download-modal': () => document.getElementById('download-modal-overlay').classList.add('active'),
                'close-download-modal': () => document.getElementById('download-modal-overlay').classList.remove('active'),
                'download-summary': () => { downloadSummaryExcel(); document.getElementById('download-modal-overlay').classList.remove('active'); },
                'download-tracker-dates': () => { downloadTrackerExcel('dates'); document.getElementById('download-modal-overlay').classList.remove('active'); },
                'download-tracker-competency': () => { downloadTrackerExcel('competency'); document.getElementById('download-modal-overlay').classList.remove('active'); },
                'open-topic-filter': () => { populateTopicFilterModal(); document.getElementById('topic-filter-modal-overlay').classList.add('active'); },
                'close-topic-filter': () => document.getElementById('topic-filter-modal-overlay').classList.remove('active'),
                'open-period-filter': () => {
                    document.getElementById('filter-training-from').value = state.ui.filters.dateRange.from || '';
                    document.getElementById('filter-training-to').value = state.ui.filters.dateRange.to || '';
                    document.getElementById('filter-joining-from').value = state.ui.filters.joiningDateRange.from || '';
                    document.getElementById('filter-joining-to').value = state.ui.filters.joiningDateRange.to || '';
                    document.getElementById('period-filter-modal-overlay').classList.add('active');
                },
                'close-period-filter': () => {
                    document.getElementById('period-filter-modal-overlay').classList.remove('active');
                },
                'clear-period-filter': () => {
                    state.ui.filters.dateRange = { from: null, to: null };
                    state.ui.filters.joiningDateRange = { from: null, to: null };
                    document.getElementById('period-filter-modal-overlay').classList.remove('active');
                    shouldReprocess = true;
                },
                'apply-period-filter': () => {
                    state.ui.filters.dateRange.from = document.getElementById('filter-training-from').value || null;
                    state.ui.filters.dateRange.to = document.getElementById('filter-training-to').value || null;
                    state.ui.filters.joiningDateRange.from = document.getElementById('filter-joining-from').value || null;
                    state.ui.filters.joiningDateRange.to = document.getElementById('filter-joining-to').value || null;
                    document.getElementById('period-filter-modal-overlay').classList.remove('active');
                    shouldReprocess = true;
                },
                'apply-topic-filter': () => { state.ui.filters.topicFilters.topic = Array.from(document.querySelectorAll('#modal-topic-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.topicFilters.subtopic = Array.from(document.querySelectorAll('#modal-subtopic-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.topicFilters.proficiency = document.getElementById('filter-proficiency-target').value; document.getElementById('topic-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'clear-topic-filter': () => { state.ui.filters.topicFilters = { topic: [], subtopic: [], proficiency: '' }; document.getElementById('topic-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'update-competency': () => { 
                    const tableContainer = document.querySelector('.table-container');
                    if (tableContainer) {
                        lastScrollState = {
                            top: tableContainer.scrollTop,
                            left: tableContainer.scrollLeft
                        };
                    }
                    const m = findMetricForEmployee(employeeId, metricName); 
                    if(m) m.actualCompetency = parseInt(actionTarget.value, 10); 
                    shouldReprocess = true; 
                }
            };
            
            if (actions[action]) {
                 actions[action]();
            }

            if (shouldReprocess) {
                 reprocessAndRender();
            } else if (renderOptions.updateTable || renderOptions.updatePagination) {
                 // This block now mainly handles pagination and column toggles, but not row toggles.
                 render(renderOptions);
            }
        }
        
        function getUnpaginatedFilteredEmployeesForExport() {
            calculateRollups(state.rawData[0]);
            const { nodesForTable } = getFilteredData(state.rawData, state.ui.filters);
            const clonedNodes = deepClone(nodesForTable);
            const prunedNodes = clonedNodes.map(node => filterTreeBySummary(node)).filter(node => node !== null);
            prunedNodes.forEach(rootNode => addParentLinksAndHeadcounts(rootNode, null));
            const employeeNodes = getAllNodesByType(prunedNodes, 'employee');
            return employeeNodes.map(node => ({ ...node, fullPath: getFullPath(node) }));
        }

        function downloadTrackerExcel(type = 'dates') {
            const employees = getUnpaginatedFilteredEmployeesForExport();
            
                        employees.sort((a, b) => {
                const deptA = a.fullPath.department || '';
                const deptB = b.fullPath.department || '';
                const roleA = a.role || '';
                const roleB = b.role || '';
                const attendedA = a.summary.totalSessionsAttended || 0;
                const attendedB = b.summary.totalSessionsAttended || 0;

                if (deptA.localeCompare(deptB) !== 0) {
                    return deptA.localeCompare(deptB);
                }
                if (roleA.localeCompare(roleB) !== 0) {
                    return roleA.localeCompare(roleB);
                }
                return attendedB - attendedA;
            });

            const dataToExport = [];
            const subTopicHeaders = [];
            Object.entries(trainingCatalog).forEach(([topic, subtopics]) => { 
                subtopics.forEach(sub => subTopicHeaders.push({ name: `${sub} (${topic})`, topic, sub }));
            });

            let header;
            if (type === 'dates') {
                header = ['S.No.', 'Corporate', 'Regional', 'Unit', 'Department', 'Employee ID', 'Employee Name', 'Role', 'Food Handler', 'Status', 'Joined Date', 'Total Sessions Attended', 'Total Training Hours'];
                                subTopicHeaders.forEach(h => header.push(h.name));
            } else { // competency
                header = ['S.No.', 'Corporate', 'Regional', 'Unit', 'Department', 'Employee ID', 'Employee Name', 'Role', 'Food Handler', 'Status', 'Joined Date'];
                subTopicHeaders.forEach(h => header.push(`${h.name} (Should)`, `${h.name} (Actual)`));
            }
            dataToExport.push(header);

            let s_no = 1;
            employees.forEach(employeeNode => {
                if (!employeeNode || !employeeNode.metrics) return;
                
                let dataRow;
                if(type === 'dates') {
                    dataRow = [ 
                        s_no++, employeeNode.fullPath.corporate, employeeNode.fullPath.region, 
                        employeeNode.fullPath.unit, employeeNode.fullPath.department, 
                        employeeNode.employeeIdNum.replace(/\(ID: (.*)\)/, '$1'), employeeNode.name, 
                        employeeNode.role, FOOD_HANDLER_ROLES.includes(employeeNode.role) ? 'Yes' : 'No', 
                        employeeNode.status, parseDateToUTC(employeeNode.joiningDate),
                        employeeNode.summary.totalSessionsAttended,
                        Number(employeeNode.summary.totalActualHours.toFixed(2))
                    ];
                } else {
                     dataRow = [ 
                        s_no++, employeeNode.fullPath.corporate, employeeNode.fullPath.region, 
                        employeeNode.fullPath.unit, employeeNode.fullPath.department, 
                        employeeNode.employeeIdNum.replace(/\(ID: (.*)\)/, '$1'), employeeNode.name, 
                        employeeNode.role, FOOD_HANDLER_ROLES.includes(employeeNode.role) ? 'Yes' : 'No', 
                        employeeNode.status, parseDateToUTC(employeeNode.joiningDate)
                    ];
                }
                
                subTopicHeaders.forEach(h => {
                    const topicMetrics = employeeNode.metrics[h.topic];
                    const allSessionsForSubtopic = topicMetrics ? topicMetrics.filter(m => m.name === h.sub && m.attended > 0 && m.date) : [];
                    
                    if (type === 'dates') {
                        if (allSessionsForSubtopic.length > 0) {
                            const formattedDates = allSessionsForSubtopic.map(session => {
                                const d = parseDateTime(session.date);
                                if (!d) return '';
                                const day = String(d.getDate()).padStart(2, '0');
                                const month = String(d.getMonth() + 1).padStart(2, '0');
                                const year = d.getFullYear();
                                const hours = String(d.getHours()).padStart(2, '0');
                                const minutes = String(d.getMinutes()).padStart(2, '0');
                                const seconds = String(d.getSeconds()).padStart(2, '0');
                                return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
                            }).join("\n"); // Newline character for multi-line cells in Excel
                            dataRow.push(formattedDates);
                        } else {
                            dataRow.push('');
                        }
                    } else { // competency
                        let shouldValue = '', actualValue = '';
                        if (allSessionsForSubtopic.length > 0) {
                            const latestSession = allSessionsForSubtopic.reduce((latest, current) => (parseDateTime(current.date) > parseDateTime(latest.date)) ? current : latest);
                            shouldValue = latestSession.targetCompetency;
                            actualValue = latestSession.actualCompetency;
                        }
                        dataRow.push(shouldValue, actualValue);
                    }
                });
                dataToExport.push(dataRow);
            });

            const ws = XLSX.utils.aoa_to_sheet(dataToExport);
            const headerStyle = { font: { bold: true }, fill: { fgColor: { rgb: "FFD3D3D3" } }, alignment: { wrapText: true, vertical: 'top' } };
            const dateStyle = { num_fmt: "dd-mm-yyyy" };
            const centerStyle = { alignment: { horizontal: "center" }};
            const multiLineStyle = { alignment: { wrapText: true, vertical: 'top' } };

            const range = XLSX.utils.decode_range(ws['!ref']);
            for (let C = range.s.c; C <= range.e.c; ++C) {
                if(ws[XLSX.utils.encode_cell({c:C, r:0})]) {
                    ws[XLSX.utils.encode_cell({c:C, r:0})].s = headerStyle;
                }
                for (let R = 1; R <= range.e.r; ++R) {
                    const cell = ws[XLSX.utils.encode_cell({c:C, r:R})];
                    if(!cell) continue;
                    if (cell.v instanceof Date) {
                        cell.s = dateStyle;
                    } else if (typeof cell.v === 'string' && cell.v.includes('\n')) {
                        cell.s = multiLineStyle; // Apply multi-line style
                    } else if (typeof cell.v === 'number' || header[C].toLowerCase().includes('status') || header[C].toLowerCase().includes('handler') || header[C].toLowerCase().includes('s.no.')) {
                        cell.s = centerStyle;
                    }
                }
            }
            
            ws['!cols'] = header.map((h, i) => {
                if (i > 10 && type === 'dates') return { wch: 25 }; // Wider for dates
                if (h.includes('(Should)') || h.includes('(Actual)')) return { wch: 10 };
                return { wch: 20 };
            });

            ws['!autofilter'] = { ref: `A1:${XLSX.utils.encode_col(header.length - 1)}1` };
            const xSplit = type === 'dates' ? 13 : 11;
            ws['!view'] = { state: 'frozen', ySplit: 1, xSplit: xSplit };
            
            const wb = XLSX.utils.book_new();
            const sheetName = type === 'dates' ? 'Tracker (Dates)' : 'Tracker (Competency)';
            XLSX.utils.book_append_sheet(wb, ws, sheetName);
            XLSX.writeFile(wb, `Training_${sheetName}_FullReport.xlsx`);
        }
        
        function downloadSummaryExcel() { 
            const wb = XLSX.utils.book_new();

            // --- 1. Main Summary Sheet ---
            const { nodesForTable } = getFilteredData(state.rawData, state.ui.filters);
            const clonedNodes = deepClone(nodesForTable);
            const prunedNodes = clonedNodes.map(node => filterTreeBySummary(node)).filter(node => node !== null);
            const allNodeIds = new Set();
            const collectIds = (nodes) => { nodes.forEach(n => { allNodeIds.add(n.id); if(n.children) collectIds(n.children); }); };
            collectIds(prunedNodes);
            const originalExpandedState = state.ui.expandedRows;
            state.ui.expandedRows = allNodeIds;
            const summaryData = flattenHierarchy(prunedNodes);
            state.ui.expandedRows = originalExpandedState; // Restore original state

            const dataToExport = [];
            const headers = ["Hierarchy Level", "Name", "Total Employees", "Fully Attended", "Attendance %", "Total Sessions Attended", "Total Mandatory Sessions", "Total Actual Hours", "Total Target Hours"];
            dataToExport.push(headers);
            summaryData.forEach(row => {
                const summary = row.summary;
                if (!summary) return;
                const attendancePct = summary.employees > 0 ? `${Math.round((summary.attendedCount / summary.employees) * 100)}%` : 'N/A';
                dataToExport.push([
                    " ".repeat(row.level * 2) + row.type.charAt(0).toUpperCase() + row.type.slice(1), row.displayName,
                    summary.employees, summary.attendedCount, attendancePct,
                    summary.totalSessionsAttended, summary.totalSessionsMandatory,
                    Number(summary.totalActualHours.toFixed(2)), Number(summary.totalTargetHours.toFixed(2))
                ]);
            });
            const ws = XLSX.utils.aoa_to_sheet(dataToExport);
            ws['!cols'] = headers.map((h, i) => ({ wch: i === 0 ? 30 : i === 1 ? 40 : 20 }));
            XLSX.utils.book_append_sheet(wb, ws, "Full Summary Report");

            // --- 2. Chart Data Sheets ---
            const chartData = calculateTimelineChartData();
            if (chartData && chartData.groupLabels.length > 0) {
                // Attendance Summary Data
                const attendanceExport = [['Group', 'Period', 'Total Mandates', 'Attended', 'Not Attended']];
                chartData.groupLabels.forEach(label => {
                    chartData.timeline.keys.forEach((periodKey, i) => {
                                                const data = chartData.aggregatedData[periodKey]?.[label] || { total: 0, attended: 0 };
                        attendanceExport.push([label, chartData.timeline.labels[i], data.total, data.attended, data.total - data.attended]);
                    });
                });
                const ws_att = XLSX.utils.aoa_to_sheet(attendanceExport);
                XLSX.utils.book_append_sheet(wb, ws_att, "Attendance Summary Data");

                // Hours Analysis Data
                const hoursExport = [['Group', 'Period', 'Actual Hours', 'Target Hours']];
                chartData.groupLabels.forEach(label => {
                     chartData.timeline.keys.forEach((periodKey, i) => {
                        const actual = chartData.barChartDataSets[label]?.actualHours?.[periodKey] || 0;
                        const target = chartData.barChartDataSets[label]?.targetHours?.[periodKey] || 0;
                        hoursExport.push([label, chartData.timeline.labels[i], Number(actual.toFixed(2)), Number(target.toFixed(2))]);
                    });
                });
                const ws_hrs = XLSX.utils.aoa_to_sheet(hoursExport);
                XLSX.utils.book_append_sheet(wb, ws_hrs, "Hours Analysis Data");

                // Employee Averages Data
                const averagesExport = [['Group', 'Period', 'Avg Training per Employee', 'Avg Hours per Employee']];
                chartData.groupLabels.forEach(label => {
                     chartData.timeline.keys.forEach((periodKey, i) => {
                        const avgTraining = chartData.barChartDataSets[label]?.avgTraining?.[periodKey] || 0;
                        const avgHours = chartData.barChartDataSets[label]?.avgHours?.[periodKey] || 0;
                        averagesExport.push([label, chartData.timeline.labels[i], Number(avgTraining.toFixed(2)), Number(avgHours.toFixed(2))]);
                    });
                });
                const ws_avg = XLSX.utils.aoa_to_sheet(averagesExport);
                XLSX.utils.book_append_sheet(wb, ws_avg, "Employee Averages Data");
            }
            
            XLSX.writeFile(wb, "Training_Summary_FullReport.xlsx");
        }

        function findNodeById(nodes, id) { for (const node of nodes) { if (node.id === id) return node; if (node.children) { const found = findNodeById(node.children, id); if (found) return found; } } return null; }
        
        function findMetricForEmployee(employeeId, metricName) {
            const employeeNode = findNodeById(state.rawData, employeeId);
            if (!employeeNode || !employeeNode.metrics) return null;

            const allMatchingMetrics = [];
            for (const topic in employeeNode.metrics) {
                employeeNode.metrics[topic].forEach(metric => {
                    if (metric.name === metricName) {
                        allMatchingMetrics.push(metric);
                    }
                });
            }

            if (allMatchingMetrics.length === 0) return null;
            if (allMatchingMetrics.length === 1) return allMatchingMetrics[0];

            // If there are multiple sessions, sort by date and return the most recent one
            allMatchingMetrics.sort((a, b) => {
                const dateA = parseDateTime(a.date);
                const dateB = parseDateTime(b.date);
                if (!dateB) return -1;
                if (!dateA) return 1;
                return dateB - dateA;
            });

            return allMatchingMetrics[0];
        }

        function addParentLinksAndHeadcounts(node, parent = null) { node.parent = parent; if (node.type === 'employee') { node.headcount = 1; return 1; } let total = 0; if (node.children) { node.children.forEach(child => { total += addParentLinksAndHeadcounts(child, node); }); } node.headcount = total; return total; }
        function getAllNodesByType(nodes, type) { let results = []; for (const node of nodes) { if (node.type === type) results.push(node); if (node.children) results = results.concat(getAllNodesByType(node.children, type)); } return results; }

        function initFilterEventListeners() {
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.custom-select-filter, .custom-date-filter')) {
                    document.querySelectorAll('.custom-select-filter.active, .custom-date-filter.active').forEach(dd => dd.classList.remove('active'));
                }
            });

            document.body.addEventListener('change', e => {
                const target = e.target;

                if (target.id === 'view-mode-slider') {
                    state.ui.viewMode = target.checked ? 'individual' : 'overall';
                    reprocessAndRender();
                    return;
                }

                if (target.id === 'filter-food-handler') {
                    state.ui.filters.isFoodHandler = target.value;
                    reprocessAndRender();
                    return;
                }

                const customSelect = target.closest('.custom-select-filter');
                if (customSelect && target.type === 'checkbox') {
                    const filterType = customSelect.dataset.filterType;
                    const value = target.value;
                    const selectedArray = state.ui.filters[filterType];
                    if (!selectedArray) return;

                    if (target.checked) {
                        if (!selectedArray.includes(value)) selectedArray.push(value);
                    } else {
                        const index = selectedArray.indexOf(value);
                        if (index > -1) selectedArray.splice(index, 1);
                    }

                    const hierarchy = ['region', 'unit', 'department', 'role'];
                    if (filterType === 'employees' && state.ui.filters.employees.length > 0) {
                        hierarchy.forEach(f => state.ui.filters[f] = []);
                    } else {
                        state.ui.filters.employees = [];
                        const currentFilterIndex = hierarchy.indexOf(filterType);
                        if (currentFilterIndex > -1) {
                            for (let i = currentFilterIndex + 1; i < hierarchy.length; i++) {
                                const filterToClear = hierarchy[i];
                                state.ui.filters[filterToClear] = [];
                            }
                        }
                    }
                    reprocessAndRender();
                }
            });

            document.body.addEventListener('input', e => {
                if (e.target.classList.contains('select-search')) {
                    const searchTerm = e.target.value.toLowerCase();
                    const list = e.target.nextElementSibling;
                    list.querySelectorAll('label').forEach(label => {
                        label.style.display = label.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none';
                    });
                }
            });
        }
        function initTopicFilterModal() {
            const topicFilter = document.getElementById('modal-topic-filter');
            const subtopicFilter = document.getElementById('modal-subtopic-filter');
            topicFilter.addEventListener('change', e => { if (e.target.type === 'checkbox') { updateSubtopicOptions(); } });
            const updateSubtopicOptions = () => {
                const selectedTopics = Array.from(topicFilter.querySelectorAll('.select-list input:checked')).map(cb => cb.value);
                let availableSubtopics = [];
                if (selectedTopics.length > 0) {
                    availableSubtopics = [...new Set(selectedTopics.flatMap(topic => trainingCatalog[topic] || []))];
                } else {
                    availableSubtopics = [...new Set(Object.values(trainingCatalog).flat())];
                }
                const previouslySelectedSubtopics = Array.from(subtopicFilter.querySelectorAll('.select-list input:checked')).map(cb => cb.value);
                const list = subtopicFilter.querySelector('.select-list');
                list.innerHTML = '';
                availableSubtopics.sort().forEach(subtopic => {
                    const isChecked = previouslySelectedSubtopics.includes(subtopic);
                    list.innerHTML += `<label><input type="checkbox" value="${subtopic}" ${isChecked ? 'checked' : ''}><span>${subtopic}</span></label>`;
                });
                updateButtonLabel(subtopicFilter, previouslySelectedSubtopics, 'All Sub-Topics');
            };
        }
        function updateButtonLabel(container, selectedItems, placeholder) { const button = container.querySelector('.select-button'); if (selectedItems.length === 0) { button.textContent = placeholder; } else if (selectedItems.length === 1) { button.textContent = selectedItems[0]; } else { button.textContent = `${selectedItems.length} selected`; } }
        function populateTopicFilterModal() { const { topic: selectedTopics, subtopic: selectedSubtopics, proficiency } = state.ui.filters.topicFilters; const topicFilter = document.getElementById('modal-topic-filter'); const subtopicFilter = document.getElementById('modal-subtopic-filter'); const allTopics = Object.keys(trainingCatalog); const topicList = topicFilter.querySelector('.select-list'); topicList.innerHTML = ''; allTopics.forEach(topic => { const isChecked = selectedTopics.includes(topic); topicList.innerHTML += `<label><input type="checkbox" value="${topic}" ${isChecked ? 'checked' : ''}><span>${topic}</span></label>`; }); updateButtonLabel(topicFilter, selectedTopics, 'All Topics'); let availableSubtopics = []; if (selectedTopics.length > 0) { availableSubtopics = [...new Set(selectedTopics.flatMap(topic => trainingCatalog[topic] || []))]; } else { availableSubtopics = [...new Set(Object.values(trainingCatalog).flat())]; } const subtopicList = subtopicFilter.querySelector('.select-list'); subtopicList.innerHTML = ''; availableSubtopics.sort().forEach(subtopic => { const isChecked = selectedSubtopics.includes(subtopic); subtopicList.innerHTML += `<label><input type="checkbox" value="${subtopic}" ${isChecked ? 'checked' : ''}><span>${subtopic}</span></label>`; }); updateButtonLabel(subtopicFilter, selectedSubtopics, 'All Sub-Topics'); document.getElementById('filter-proficiency-target').value = proficiency; }

        function init(isRefresh = false) { 
            if (!isRefresh || state.rawData.length === 0) {
                state.rawData = generateMockData();
                addParentLinksAndHeadcounts(state.rawData[0]);
            }
            Object.assign(state.ui, { 
                showGraphs: true,
                viewMode: 'individual', expandedRows: new Set(['corp-hq']), expandedCols: new Set(), 
                pagination: { ...state.ui.pagination, currentPage: 1 },
                filters: { region: [], unit: [], department: [], employees: [], role: [], topicFilters: { topic: [], subtopic: [], proficiency: '' }, dateRange: { from: null, to: null }, joiningDateRange: { from: null, to: null }, isFoodHandler: '' }
            }); 
            roleChartVisibility = {};
            reprocessAndRender(); 
        }

        document.addEventListener('click', handleAction);
        document.body.addEventListener('change', e => {
             // This listener handles multiple change events.
            const actionTarget = e.target.closest('[data-action]');
            
            // Handle competency and pagination changes
            if (actionTarget && (actionTarget.dataset.action === 'change-rows-per-page' || actionTarget.dataset.action === 'update-competency')) {
                handleAction(e);
            }
            
            // Handle other general changes like filters
            handleAction(e);
        });
        
        init();
        initTopicFilterModal();
        initFilterEventListeners();
    });
    </script>
</body>
</html>
```