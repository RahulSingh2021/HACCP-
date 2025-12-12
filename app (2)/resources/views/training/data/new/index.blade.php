<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hierarchical Training Dashboard with Advanced Filtering</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        .action-button { background-color: var(--level1-color); color: white; border: none; padding: 8px 16px; border-radius: 5px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; display: flex; align-items: center; gap: 8px; }
        .action-button.excel { background-color: var(--download-btn-bg); }
        .action-button.excel:hover { background-color: var(--download-btn-hover-bg); }
        .action-button.refresh { background-color: #7f8c8d; }
        .action-button.refresh:hover { background-color: #6c7a7b; }
        
        /* Filters */
        .filter-group { display: flex; align-items: center; gap: 10px; border-left: 2px solid var(--border-color); margin-left: 5px; padding-left: 15px; }
        #employee-count-display { gap: 12px; font-size: 0.9em; }
        #employee-count-display span { display: inline-flex; align-items: center; gap: 6px; }
        .filter-group label { font-size: 0.9em; font-weight: 500; color: var(--secondary-text); }
        .filter-group select { padding: 8px 12px; border-radius: 5px; border: 1px solid var(--border-color); font-size: 0.9em; background-color: #fff; height: 37px; box-sizing: border-box; }
        .custom-select-filter { position: relative; min-width: 150px; }
        .custom-select-filter .select-button { width: 100%; text-align: left; padding: 8px 12px; border-radius: 5px; border: 1px solid var(--border-color); font-size: 0.9em; background-color: #fff; color: var(--primary-text); cursor: pointer; display: flex; justify-content: space-between; align-items: center; height: 37px; box-sizing: border-box; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .custom-select-filter .select-button::after { content: '\f078'; font-family: 'Font Awesome 6 Free'; font-weight: 900; font-size: 0.8em; margin-left: 8px; }
        .custom-select-filter .select-dropdown { position: absolute; top: 105%; left: 0; width: 250px; background-color: #fff; border: 1px solid var(--border-color); border-radius: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 1001; display: none; padding: 8px; }
        .custom-select-filter.active .select-dropdown { display: block; }
        .custom-select-filter .select-search { width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid var(--border-color); border-radius: 4px; box-sizing: border-box; }
        .custom-select-filter .select-list { max-height: 200px; overflow-y: auto; }
        .custom-select-filter .select-list label { display: block; padding: 8px 10px; cursor: pointer; border-radius: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .custom-select-filter .select-list label:hover { background-color: var(--hover-bg); }
        .custom-select-filter .select-list label input { margin-right: 10px; }

        .custom-date-filter .date-input-group { display: flex; align-items: center; gap: 10px; }
        .custom-date-filter .date-input-group label { font-weight: 500; min-width: 40px; color: var(--secondary-text); }
        .custom-date-filter .date-input-group input[type="date"] { flex-grow: 1; padding: 6px 8px; border-radius: 5px; border: 1px solid var(--border-color); font-size: 0.9em; color: var(--primary-text); }
        
        /* Modal Styles */
        .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.6); display: none; align-items: center; justify-content: center; z-index: 1000; }
        .modal-overlay.active { display: flex; }
        
        /* New: Higher Z-Index for Rubric Modal so it opens on top of Competency Manager */
        #rubric-modal-overlay { z-index: 2000; }

        .modal { background-color: #fff; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); width: 90%; max-width: 650px; font-family: 'Inter', system-ui, -apple-system, sans-serif; display: flex; flex-direction: column; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid var(--border-color); }
        .modal-header h3 { margin: 0; font-size: 1.25rem; font-weight: 600; color: var(--level1-color); }
        .modal-close { background: none; border: none; font-size: 1.75rem; font-weight: 300; color: #666; cursor: pointer; line-height: 1; padding: 0; }
        .modal-body { padding: 24px; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 16px 24px; border-top: 1px solid var(--border-color); }
        .modal-footer button { padding: 10px 20px; border-radius: 5px; border: none; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s; }
        .modal-footer .btn-secondary { background-color: #6c757d; color: white; }
        .modal-footer .btn-primary { background-color: #007bff; color: white; }
        
        #topic-filter-modal .modal-body, #hierarchy-filter-modal .modal-body { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 500; color: var(--primary-text); }
        #topic-filter-modal .form-group select, #general-filter-modal select, #hierarchy-filter-modal .form-group select { width: 100%; padding: 10px 12px; border-radius: 5px; border: 1px solid var(--border-color); font-size: 1rem; background-color: #fff; color: var(--primary-text); height: auto; }

        /* Download Modal */
        #download-modal .modal-body { display: grid; grid-template-columns: 1fr; gap: 15px; }
        .download-option-group { border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; }
        .download-option-group h4 { margin: 0; padding: 10px 15px; background-color: #f8f9fa; font-size: 0.9rem; color: var(--primary-text); border-bottom: 1px solid var(--border-color); }
        .download-option-button { width: 100%; padding: 12px 20px; font-size: 1rem; font-weight: 500; border: none; border-bottom: 1px solid #e9ecef; background-color: #fff; color: var(--primary-text); cursor: pointer; transition: all 0.2s ease; text-align: left; display: flex; align-items: center; gap: 15px; }
        .download-option-button:last-child { border-bottom: none; }
        .download-option-button i { color: var(--level1-color); font-size: 1.5em; width: 1.5em; text-align: center; }
        .download-option-button:hover { background-color: #e9ecef; }
        .download-option-button div { display: flex; flex-direction: column; }
        .download-option-button .option-title { font-weight: 600; }
        .download-option-button .option-desc { font-size: 0.85em; color: var(--secondary-text); }
        
        /* Session History Modal */
        #session-history-modal .modal-body { padding: 0; }
        #session-history-modal .modal-body .table-wrapper { max-height: 60vh; overflow-y: auto; }
        #session-history-modal table { width: 100%; border-collapse: collapse; }
        #session-history-modal th, #session-history-modal td { padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
        #session-history-modal th { background-color: var(--summary-bg); font-weight: 600; position: sticky; top: 0; }
        #session-history-modal td { background-color: #fff; }

         /* Training Card */
        #training-card-modal-overlay .modal { max-width: 90vw; max-height: 90vh; }
        #training-card-modal-overlay .modal-body { padding: 0; overflow-y: auto; }
        #training-card-content { font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #1f2937; line-height: 1.5; font-size: 10pt; margin: 0; padding: 20pt; background-color: #ffffff; }
        
        /* TABLE STYLES */
        .table-container { max-width: 95%; margin: 20px auto 0; border: 1px solid var(--border-color); box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); border-radius: 10px; max-height: 70vh; overflow-x: auto; }
        .interactive-table { width: 100%; border-collapse: collapse; background-color: #ffffff; table-layout: auto; }
        .interactive-table th, .interactive-table td { border: 1px solid var(--border-color); vertical-align: top; padding: 12px 15px; }
        .interactive-table td:not(.hierarchy-col) { min-width: 200px; }
        .hierarchy-col { text-align: left; font-weight: 600; position: sticky; left: 0; z-index: 5; min-width: 380px; background-color: #fdfdfd; box-shadow: 2px 0 5px rgba(0,0,0,0.05); }
        .interactive-table thead th { position: sticky; top: 0; background-color: var(--header-bg); color: var(--light-text); z-index: 10; vertical-align: middle; }
        .interactive-table thead tr:first-child th { top: 0; }
        .interactive-table thead tr:nth-child(2) th { top: 49px; }
        .interactive-table thead .hierarchy-col { z-index: 15; }
        .interactive-table tbody tr:hover { background-color: var(--hover-bg); }
        .interactive-table tbody tr { border-left: 5px solid transparent; }
        .interactive-table tbody tr:hover { border-left-color: var(--level2-color); }
        .shrinkable-header { cursor: pointer; background-color: #4a627a; }
        .shrinkable-header:hover { background-color: #5c7a97; }
        .summary-col { background-color: var(--summary-bg); font-weight: 600; }
        
        /* Employee Details */
        .employee-details-block { padding: 5px; }
        .employee-header { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap;}
        .employee-name { font-size: 1.2em; font-weight: 600; color: var(--level1-color); }
        .status-badge { padding: 3px 12px; border-radius: 12px; font-size: 0.8em; font-weight: 600; color: white; text-transform: uppercase; }
        .status-badge.active { background-color: #28a745; }
        .status-badge.inactive { background-color: #dc3545; }
        .employee-id-num { font-size: 0.9em; color: var(--secondary-text); margin-left: 5px;}
        .employee-info-container { border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 10px; font-size: 0.85em; line-height: 1.4; }
        .info-line { display: flex; flex-wrap: wrap; align-items: center; gap: 4px 10px; }
        .info-line:not(:last-child) { margin-bottom: 5px; }
        .info-item-linear { color: var(--secondary-text); white-space: nowrap; }
        .info-label-linear { color: var(--primary-text); font-weight: 600; }
        .info-separator { color: var(--border-color); font-weight: 300; align-self: center; }
        .summary-status-badge { padding: 3px 10px; border-radius: 12px; font-size: 0.8em; font-weight: 600; text-transform: uppercase; margin-left: 5px; vertical-align: middle; }
        .summary-status-badge.attended { background-color: #28a745; color: white; }
        .summary-status-badge.partially { background-color: #ffc107; color: #212529; }
        .summary-status-badge.not-attended { background-color: #dc3545; color: white; }
        .summary-status-badge.na { background-color: #6c757d; color: white; }
        .view-card-btn { font-size: 0.8em !important; padding: 2px 8px !important; margin-left: auto !important; background-color: var(--level3-color) !important; color: var(--primary-text) !important; }
        
        /* Metric Cell */
        .employee-metric-cell { font-size: 0.9em; color: var(--primary-text); padding: 8px; }
        .employee-metric-cell .training-details-summary { display: flex; flex-direction: column; gap: 4px; margin-bottom: 8px; font-size: 0.95em; }
        .employee-metric-cell .training-details-summary i { width: 1.4em; text-align: center; color: var(--icon-color); }
        .employee-metric-cell hr { border: 0; border-top: 1px solid var(--border-color); margin: 8px 0; }
        .employee-metric-cell .competency-header { font-weight: 600; margin-bottom: 6px; text-align: left; }
        .employee-metric-cell .competency-scores { display: flex; align-items: center; justify-content: flex-start; gap: 1rem; margin-bottom: 8px; }
        .employee-metric-cell .competency-scores > span { display: inline-flex; align-items: center; gap: 6px; }
        .employee-metric-cell .competency-bar-container { height: 18px; background-color: #e9ecef; border-radius: 4px; overflow: hidden; }
        .employee-metric-cell .competency-bar-fill { height: 100%; background-color: var(--competency-bar-bg); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 0.85em; transition: width 0.4s ease-in-out; }
        .session-link { cursor: pointer; color: var(--level1-color); font-weight: 600; text-decoration: none; }
        .session-link:hover { text-decoration: underline; }

        .pagination-controls { display: flex; justify-content: space-between; align-items: center; max-width: 95%; margin: 15px auto 0; padding: 10px 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .pagination-item { display: flex; align-items: center; gap: 12px; }
        .pagination-item label { font-size: 0.9em; color: var(--secondary-text); }
        .pagination-item select, .pagination-item button { border: 1px solid var(--border-color); background-color: #fff; border-radius: 5px; padding: 8px 12px; cursor: pointer; font-size: 0.9em; color: var(--primary-text); }
        .pagination-item button { background-color: #e0e6eb; }
        
        /* NEW: Score Button & History Styles */
        .score-btn { background: #fff; border: 1px solid #ccc; border-radius: 4px; padding: 5px 10px; font-size: 0.9em; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; white-space: nowrap; }
        .score-btn:hover { background-color: #f0f4f8; border-color: var(--level1-color); color: var(--level1-color); }
        .score-btn .prev-score { color: #999; font-weight: 400; font-size: 0.9em; margin-right: 2px; }
        .score-btn .fa-arrow-right { font-size: 0.8em; color: #bbb; margin: 0 4px; }
        
        .history-container { margin-top: 25px; border-top: 2px dashed var(--border-color); padding-top: 15px; }
        .history-container h4 { margin: 0 0 15px 0; color: var(--primary-text); }
        .history-table { width: 100%; border-collapse: collapse; font-size: 0.85em; }
        .history-table th { background-color: #f8f9fa; text-align: left; padding: 8px; border-bottom: 2px solid #dee2e6; color: var(--secondary-text); }
        .history-table td { padding: 8px; border-bottom: 1px solid #dee2e6; vertical-align: top; }
        .history-evidence-link { color: var(--level1-color); text-decoration: none; display: flex; align-items: center; gap: 5px; }
        .history-evidence-link:hover { text-decoration: underline; }

        /* NEW: Rubric Styles */
        .rubric-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .rubric-table th { background: #34495e; color: #fff; padding: 10px; text-align: left; font-size: 0.9em; }
        .rubric-table td { border-bottom: 1px solid #eee; padding: 10px; font-size: 0.9em; vertical-align: middle; }
        .rubric-score-badge { background-color: var(--level1-color); color: white; padding: 4px 10px; border-radius: 50%; font-weight: bold; font-size: 0.85em; }
        .info-icon-btn { background: none; border: none; color: var(--level1-color); cursor: pointer; font-size: 0.9em; margin-left: 4px; opacity: 0.7; transition: opacity 0.2s; }
        .info-icon-btn:hover { opacity: 1; }

        .mobile-only { display: none; }
        .mobile-flex-group { display: none; }
        @media (max-width: 992px) {
            body { padding: 15px; }
            .dashboard-controls { flex-direction: column; align-items: stretch; gap: 10px; padding: 15px; }
            .desktop-only { display: none; }
            .mobile-only { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
            .mobile-only .action-button { flex-grow: 1; justify-content: center; }
            .filter-group { border-left: none; padding-left: 0; margin-left: 0; flex-wrap: wrap; justify-content: center; gap: 15px; }
            .hierarchy-col { min-width: 320px; }
        }
        @media (max-width: 768px) {
            body { padding: 10px; font-size: 14px; }
            h1 { font-size: 1.6rem; margin-bottom: 15px; }
            .table-container { max-width: 100%; }
            .pagination-controls { flex-direction: column; gap: 15px; max-width: 100%; }
            #topic-filter-modal .modal-body, #hierarchy-filter-modal .modal-body { grid-template-columns: 1fr; gap: 20px; }
            .modal { width: 95%; max-width: 500px; }
            .mobile-flex-group { display: flex; width: 100%; gap: 10px; }
            .mobile-flex-group .action-button { flex: 1; font-size: 0.85em; padding: 10px 8px; }
        }
    </style>
     <style id="training-card-dynamic-styles"></style>
</head>
<body>
    <h1>Hierarchical Training Dashboard</h1>
    <div id="dashboard-container"></div>

    <!-- Download Modal -->
    <div id="download-modal-overlay" class="modal-overlay">
        <div id="download-modal" class="modal">
            <div class="modal-header"><h3>Download Options</h3><button class="modal-close" data-action="close-download-modal">×</button></div>
            <div class="modal-body">
                 <div class="download-option-group">
                    <h4>Detailed Reports (CSV)</h4>
                    <button class="download-option-button" data-action="download-attendance-report"><i class="fas fa-calendar-check"></i><div><span class="option-title">Attendance Dates Report</span><span class="option-desc">Dates of attended sessions.</span></div></button>
                    <button class="download-option-button" data-action="download-summary-report"><i class="fas fa-chart-pie"></i><div><span class="option-title">Competency Summary Report</span><span class="option-desc">Metrics & competency %.</span></div></button>
                </div>
            </div>
            <div class="modal-footer"><button class="btn-secondary" data-action="close-download-modal">Close</button></div>
        </div>
    </div>

    <!-- Hierarchy Filter Modal -->
    <div id="hierarchy-filter-modal-overlay" class="modal-overlay">
        <div id="hierarchy-filter-modal" class="modal">
            <div class="modal-header"><h3>Hierarchy Filters</h3><button class="modal-close" data-action="close-hierarchy-filter">×</button></div>
            <div class="modal-body">
                <div class="form-group"><label>Region:</label><div id="modal-region-filter" class="custom-select-filter" data-filter-type="region"><button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search" placeholder="Search..."><div class="select-list"></div></div></div></div>
                <div class="form-group"><label>Unit:</label><div id="modal-unit-filter" class="custom-select-filter" data-filter-type="unit"><button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search" placeholder="Search..."><div class="select-list"></div></div></div></div>
                <div class="form-group"><label>Department:</label><div id="modal-department-filter" class="custom-select-filter" data-filter-type="department"><button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search" placeholder="Search..."><div class="select-list"></div></div></div></div>
                 <div class="form-group"><label>Role:</label><div id="modal-role-filter" class="custom-select-filter" data-filter-type="role"><button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search" placeholder="Search..."><div class="select-list"></div></div></div></div>
            </div>
            <div class="modal-footer"><button class="btn-secondary" data-action="clear-hierarchy-filter">Clear</button><button class="btn-primary" data-action="apply-hierarchy-filter">Apply & Close</button></div>
        </div>
    </div>

    <!-- Topic Filter Modal -->
    <div id="topic-filter-modal-overlay" class="modal-overlay">
        <div id="topic-filter-modal" class="modal">
            <div class="modal-header"><h3>Topic Filters</h3><button class="modal-close" data-action="close-topic-filter">×</button></div>
            <div class="modal-body">
                <div class="form-group"><label>Topic:</label><div id="modal-topic-filter" class="custom-select-filter" data-filter-type="topic"><button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search" placeholder="Search..."><div class="select-list"></div></div></div></div>
                <div class="form-group"><label>Sub-Topic:</label><div id="modal-subtopic-filter" class="custom-select-filter" data-filter-type="subtopic"><button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search" placeholder="Search..."><div class="select-list"></div></div></div></div>
                <div class="form-group"><label>Proficiency Target:</label><select id="filter-proficiency-target"><option value="">-- Select --</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>
            </div>
            <div class="modal-footer"><button class="btn-secondary" data-action="clear-topic-filter">Clear</button><button class="btn-primary" data-action="apply-topic-filter">Apply & Close</button></div>
        </div>
    </div>
    
    <!-- Period Filter Modal -->
    <div id="period-filter-modal-overlay" class="modal-overlay">
        <div id="period-filter-modal" class="modal">
            <div class="modal-header"><h3>Period Filters</h3><button class="modal-close" data-action="close-period-filter">×</button></div>
            <div class="modal-body">
                <div class="download-option-group"><h4>Training Period</h4><div class="custom-date-filter" style="padding: 15px;"><div class="date-input-group" style="margin-bottom: 10px;"><label>From:</label><input type="date" id="filter-training-from"></div><div class="date-input-group"><label>To:</label><input type="date" id="filter-training-to"></div></div></div>
                <div class="download-option-group"><h4>Joining Period</h4><div class="custom-date-filter" style="padding: 15px;"><div class="date-input-group" style="margin-bottom: 10px;"><label>From:</label><input type="date" id="filter-joining-from"></div><div class="date-input-group"><label>To:</label><input type="date" id="filter-joining-to"></div></div></div>
            </div>
            <div class="modal-footer"><button class="btn-secondary" data-action="clear-period-filter">Clear All</button><button class="btn-primary" data-action="apply-period-filter">Apply & Close</button></div>
        </div>
    </div>
    
    <!-- Session History Modal -->
    <div id="session-history-modal-overlay" class="modal-overlay">
        <div id="session-history-modal" class="modal" style="max-width: 700px;">
            <div class="modal-header"><h3 id="session-history-title">Session History</h3><button class="modal-close" data-action="close-session-history">×</button></div>
            <div class="modal-body"><div class="table-wrapper"><table><thead><tr><th>Date</th><th>Certificate</th><th>Training Sheet</th></tr></thead><tbody id="session-history-table-body"></tbody></table></div></div>
             <div class="modal-footer"><button class="btn-secondary" data-action="close-session-history">Close</button></div>
        </div>
    </div>

    <!-- Training Card Modal -->
    <div id="training-card-modal-overlay" class="modal-overlay">
        <div id="training-card-modal" class="modal">
            <div class="modal-header"><h3>Employee Training Card</h3><button class="modal-close" data-action="close-training-card">×</button></div>
            <div class="modal-body"><div id="training-card-content"></div></div>
             <div class="modal-footer"><button class="btn-secondary" data-action="close-training-card">Close</button><button class="btn-primary" data-action="download-training-card">Download Card</button></div>
        </div>
    </div>

    <!-- General Filter Modal (Mobile) -->
    <div id="general-filter-modal-overlay" class="modal-overlay">
        <div id="general-filter-modal" class="modal">
            <div class="modal-header"><h3>General Filters</h3><button class="modal-close" data-action="close-general-filter">×</button></div>
            <div class="modal-body"></div>
            <div class="modal-footer"><button class="btn-secondary" data-action="clear-general-filter">Clear Filters</button><button class="btn-primary" data-action="close-general-filter">Apply & Close</button></div>
        </div>
    </div>

    <!-- Competency Manager Modal (Update & History) -->
    <div id="verification-modal-overlay" class="modal-overlay">
        <div id="verification-modal" class="modal" style="max-width: 700px;">
            <div class="modal-header"><h3>Manage Competency Score</h3><button class="modal-close" data-action="close-verification-modal">×</button></div>
            <div class="modal-body">
                <!-- SECTION 1: UPDATE FORM -->
                <div style="background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <h4 style="margin-top:0; color: var(--level1-color);">Update Score</h4>
                    <p style="margin-bottom: 15px; color: #666; font-size: 0.9em;">Update score for <strong id="verify-employee-name">...</strong> on topic <strong id="verify-metric-display">...</strong></p>
                    <form id="verification-form">
                        <input type="hidden" id="verify-emp-id"><input type="hidden" id="verify-metric-name">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <!-- NEW: Info Icon added here -->
                                <label style="display:block; font-size: 0.85em; margin-bottom: 5px; font-weight:600;">New Score (0-5) <button type="button" class="info-icon-btn" data-action="open-rubric-modal" title="View Rubric"><i class="fas fa-info-circle"></i></button>:</label>
                                <select id="verify-new-score-select" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><option value="0">0 - Not Competent</option><option value="1">1 - Beginner</option><option value="2">2 - Learner</option><option value="3">3 - Competent</option><option value="4">4 - Proficient</option><option value="5">5 - Expert</option></select>
                            </div>
                             <div><label style="display:block; font-size: 0.85em; margin-bottom: 5px; font-weight:600;">Evidence Type:</label><select id="verify-evidence-type" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><option value="Certificate">Certificate</option><option value="Assessment">Assessment</option><option value="Observation">Observation</option></select></div>
                        </div>
                        <div class="form-group"><label>Upload Proof (PDF/Image):</label><input type="file" id="verify-file-upload" class="form-control" style="border: 1px solid #dbe4e8; padding: 6px; width: 100%; border-radius: 4px;"></div>
                        <div class="form-group"><label>Remarks:</label><textarea id="verify-remarks" rows="2" style="width: 100%; padding: 8px; border: 1px solid #dbe4e8; border-radius: 4px;"></textarea></div>
                        <div style="text-align: right;"><button class="btn-primary" type="button" data-action="confirm-verification" style="background-color: #28a745;"><i class="fas fa-save"></i> Update Score</button></div>
                    </form>
                </div>
                <!-- SECTION 2: HISTORY TABLE -->
                <div class="history-container"><h4><i class="fas fa-history"></i> Change History</h4><div style="max-height: 200px; overflow-y: auto;"><table class="history-table"><thead><tr><th>Date</th><th>Score</th><th>Evidence</th><th>Remarks</th></tr></thead><tbody id="history-table-body"></tbody></table></div></div>
            </div>
        </div>
    </div>
    
    <!-- NEW: Competency Rubric Modal -->
    <div id="rubric-modal-overlay" class="modal-overlay">
        <div id="rubric-modal" class="modal" style="max-width: 500px;">
            <div class="modal-header"><h3>Competency Standards</h3><button class="modal-close" data-action="close-rubric-modal">×</button></div>
            <div class="modal-body">
                <p style="color: #666; font-size: 0.9em; margin-bottom: 15px;">Reference guide for evaluating competency levels.</p>
                <table class="rubric-table"><thead><tr><th style="width: 50px;">Lvl</th><th>Definition</th><th>Description</th></tr></thead>
                    <tbody>
                        <tr><td><span class="rubric-score-badge">1</span></td><td><strong>Beginner</strong></td><td>Has basic knowledge. Needs full supervision to perform tasks.</td></tr>
                        <tr><td><span class="rubric-score-badge">2</span></td><td><strong>Learner</strong></td><td>Can perform simple tasks. Needs help with complex situations.</td></tr>
                        <tr><td><span class="rubric-score-badge">3</span></td><td><strong>Competent</strong></td><td>Can work independently on standard tasks. Meets expectations.</td></tr>
                        <tr><td><span class="rubric-score-badge">4</span></td><td><strong>Proficient</strong></td><td>High skill level. Can troubleshoot issues and help others.</td></tr>
                        <tr><td><span class="rubric-score-badge">5</span></td><td><strong>Expert</strong></td><td>Subject Matter Expert. Can train others and drive improvements.</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"><button class="btn-secondary" data-action="close-rubric-modal">Close</button></div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let lastScrollState = null;
        
        // --- 🎯 CONFIGURATION ---
        const API_ENDPOINT = "{{route('training.config.data')}}"; // 🚨 REPLACE THIS WITH YOUR ACTUAL BACKEND URL
        // --- 🎯 END CONFIGURATION ---

        const state = { 
            rawData: [], 
            viewData: [], 
            // Moved training catalog and roles into state for dynamic updating
            trainingCatalog: {}, 
            FOOD_HANDLER_ROLES: [],
            globalFilterOptions: { employees: [], hierarchy: { region: [], unit: [], department: [], role: [] } }, 
            ui: { 
                expandedCols: new Set(), expandedRows: new Set(), 
                pagination: { currentPage: 1, rowsPerPage: 20, totalRows: 0, totalPages: 1 }, 
                filters: { 
                    employees: [], topicFilters: { topic: [], subtopic: [], proficiency: '' }, 
                    dateRange: { from: null, to: null }, joiningDateRange: { from: null, to: null }, 
                    isFoodHandler: '', attendanceStatus: '', hierarchy: { region: [], unit: [], department: [], role: [] }
                } 
            }, 
        };
        
        let prunedNodes = [];

        // ---------------------------------------------------------------------
        // 🚀 CORE FUNCTION FOR DYNAMIC DATA FETCHING
        // ---------------------------------------------------------------------

        // async function fetchRealData() {
        //     try {
        //         // Fetching training catalog and food handler roles (if dynamic)
        //         // For now, setting static mock data to keep the dashboard working structure.
        //         state.trainingCatalog = { 
        //             "HACCP": ['Type A', 'Type B', 'Type C', 'Type D'], 
        //             "Safety": ['Fire Drills', 'First Aid', 'Evacuation Procedures'], 
        //             "Service": ['Guest Interaction', 'Complaint Handling'] 
        //         };
        //         state.FOOD_HANDLER_ROLES = ['Commis Chef', 'Waiter', 'Stewarding'];
                
        //         const response = await fetch(API_ENDPOINT); 
                
        //         console.log("response",response)
        //         if (!response.ok) {
        //             throw new Error(`HTTP error! status: ${response.status} - Failed to fetch training data.`);
        //         }
                
        //         const data = await response.json();
                
        //         console.log("Data fetched successfully:", data);

        //         // --- DATA VALIDATION/TRANSFORMATION (CRITICAL STEP) ---
        //         // The dashboard expects 'data' to be an array containing the root node of the hierarchy, e.g.,
        //         // [ {id: 'corp-hq', name: 'Corporate HQ', type: 'corporate', children: [...] } ]
        //         if (!Array.isArray(data) || data.length === 0 || !data[0].id) {
        //              console.error("API did not return data in the expected hierarchical format. Returning empty structure.");
        //              return []; 
        //         }
                
        //         // If the data format needs transformation (e.g., from flat list to hierarchy), 
        //         // perform that transformation here before returning 'data'.
                
        //         return data;
        //     } catch (error) {
        //         console.error("Error fetching data from backend:", error);
                
        //         // --- FALLBACK (Remove mock data function after testing is complete) ---
        //         // For development, you can use a fallback mock generator:
        //         // return generateMockDataFallback(); 
        //         return []; 
        //     }
        // }
        
        
        async function fetchRealData() {
    try {
        
        // ❌ Removed static assignment of state.trainingCatalog and state.FOOD_HANDLER_ROLES
        
        const response = await fetch(API_ENDPOINT); 
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status} - Failed to fetch training data.`);
        }
        
        const responseData = await response.json(); // Fetches { hierarchy: [...], catalog: {...}, foodHandlerRoles: [...] }
        
        console.log("Data fetched successfully:", responseData);

        // 🎯 CRITICAL: Set State from API Response
        if (responseData.catalog && typeof responseData.catalog === 'object') {
            state.trainingCatalog = responseData.catalog; // Use dynamic catalog for headers/filters
        } else {
             // Fallback to empty if catalog structure is missing
             state.trainingCatalog = {}; 
        }

        if (responseData.foodHandlerRoles && Array.isArray(responseData.foodHandlerRoles)) {
            state.FOOD_HANDLER_ROLES = responseData.foodHandlerRoles; // Use dynamic roles for Food Handler filter
        }

        // 🚨 Validation and return of the hierarchy data
        if (!responseData.hierarchy || !Array.isArray(responseData.hierarchy) || responseData.hierarchy.length === 0 || !responseData.hierarchy[0].id) {
             console.error("API did not return data in the expected hierarchical format. Returning empty structure.");
             return []; 
        }
        
        return responseData.hierarchy; // Return only the hierarchy data for processing
        
    } catch (error) {
        console.error("Error fetching data from backend:", error);
        return []; 
    }
}
        
        // Example fallback (You can remove this function after your API is live)
        function generateMockDataFallback() {
             function createEmployees(departmentName, unitName, count) {
                const employeesList = [];
                const firstNames = ['Arjun', 'Priya', 'Rohan', 'Sneha', 'Vikram', 'Anjali', 'Karan', 'Meera', 'Aditya', 'Diya'];
                const lastNames = ['Singh', 'Patel', 'Kumar', 'Sharma', 'Gupta', 'Reddy', 'Chopra', 'Verma'];
                const allRoles = (departmentName === 'Engineering') ? ['Engineer', 'Accountant'] : ['Commis Chef', 'Waiter', 'Housekeeping Staff', 'Front Desk Agent', 'Stewarding'];
                for (let i = 1; i <= count; i++) {
                    const employeeId = `emp-${unitName}-${departmentName.replace(/\s/g, '-')}-${i}`;
                    const employeeName = `Mr. ${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
                    const employeeMetrics = {};
                    const joiningDateRaw = new Date(Date.now() - Math.random() * 3 * 365 * 24 * 60 * 60 * 1000);
                    const formattedJoiningDate = `${String(joiningDateRaw.getDate()).padStart(2, '0')}-${String(joiningDateRaw.getMonth() + 1).padStart(2, '0')}-${joiningDateRaw.getFullYear()}`;
                    for (const topic in state.trainingCatalog) {
                        employeeMetrics[topic] = state.trainingCatalog[topic].flatMap(subtopic => {
                            const sessions = [];
                            if (Math.random() > 0.2) {
                                const numSessions = 1 + Math.floor(Math.random() * 3);
                                const targetCompetency = 3 + Math.floor(Math.random() * 3);
                                for (let j = 0; j < numSessions; j++) {
                                    const attended = Math.random() > 0.15 ? 1 : 0;
                                    const actualHours = attended ? (Math.random() > 0.5 ? 2 : 1.5) * (0.9 + Math.random() * 0.2) : 0;
                                    const d = new Date(Date.now() - Math.random() * (j + 1) * 90 * 24 * 60 * 60 * 1000);
                                    const date = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')} ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}:${String(d.getSeconds()).padStart(2, '0')}`;
                                    const actualCompetency = attended ? Math.round(targetCompetency * (0.8 + Math.random() * 0.2)) : 0;
                                    const history = [];
                                    if(attended && actualCompetency > 0) { history.push({ date: date, score: actualCompetency, type: 'System', remarks: 'Initial Entry', url: '#' }); }
                                    sessions.push({ name: subtopic, attended, total: 1, actualHours, targetHours: (Math.random() > 0.5 ? 2 : 1.5), date, targetCompetency, actualCompetency, certificateUrl: attended ? '#' : null, trainingSheetUrl: attended ? '#' : null, history: history });
                                }
                            }
                            return sessions;
                        });
                    }
                    employeesList.push({
                        id: employeeId, name: employeeName, type: 'employee', status: Math.random() > 0.1 ? 'Active' : 'Inactive',
                        role: allRoles[Math.floor(Math.random() * allRoles.length)], joiningDate: formattedJoiningDate,
                        employeeIdNum: `(ID: ${100 + Math.floor(Math.random() * 899)}-${100000 + Math.floor(Math.random() * 899999)})`, employees: 1, metrics: employeeMetrics
                    });
                }
                return employeesList;
            }
            return [{
                id: 'corp-hq', name: 'Corporate HQ', type: 'corporate', children: [{
                    id: 'region-americas', name: 'Americas', type: 'region', children: [{
                        id: 'unit-east-coast', name: 'East Coast Ops', type: 'unit', children: [{
                            id: 'dept-east-coast-engineering', name: 'Engineering', type: 'department', children: createEmployees('Engineering', 'East-Coast', 10)
                        }, {
                            id: 'dept-east-coast-fb', name: 'F&B Service', type: 'department', children: createEmployees('F&B Service', 'East-Coast', 10)
                        }]
                    }]
                }]
            }];
        }
        // End of generateMockDataFallback

        // ---------------------------------------------------------------------
        // ⚙️ UTILITY FUNCTIONS
        // ---------------------------------------------------------------------
        
        function parseDateTime(dateTimeString) { if (!dateTimeString) return null; try { const [datePart, timePart] = dateTimeString.split(' '); const [year, month, day] = datePart.split('-'); if (timePart) { const [hours, minutes, seconds] = timePart.split(':'); return new Date(year, month - 1, day, hours, minutes, seconds); } return new Date(year, month - 1, day); } catch (e) { return null; } }
        function parseDateToUTC(dateString) { if (!dateString) return null; if (/^\d{4}-\d{2}-\d{2}/.test(dateString)) { const [y, m, d] = dateString.substring(0,10).split('-').map(Number); return new Date(Date.UTC(y, m - 1, d)); } if (/^\d{2}-\d{2}-\d{4}$/.test(dateString)) { const [d, m, y] = dateString.split('-').map(Number); return new Date(Date.UTC(y, m - 1, d)); } return null; }
        function deepClone(obj) { if (obj === null || typeof obj !== 'object') return obj; const clone = Array.isArray(obj) ? [] : {}; for (const key in obj) { if (key !== 'parent' && Object.prototype.hasOwnProperty.call(obj, key)) clone[key] = deepClone(obj[key]); } return clone; }
        function getFullPath(node) { const pathArray = []; let current = node; while (current) { if (current.type !== 'employee') pathArray.push({ type: current.type, name: current.name }); current = current.parent; } return pathArray.reverse(); }
        function findNodeById(nodes, id) { for (const node of nodes) { if (node.id === id) return node; if (node.children) { const found = findNodeById(node.children, id); if (found) return found; } } return null; }
        function findMetricForEmployee(employeeId, metricName) {
            const employeeNode = findNodeById(state.rawData, employeeId);
            if (!employeeNode || !employeeNode.metrics) return null;
            const allMatchingMetrics = [];
            for (const topic in employeeNode.metrics) { employeeNode.metrics[topic].forEach(metric => { if (metric.name === metricName) { allMatchingMetrics.push(metric); } }); }
            if (allMatchingMetrics.length === 0) return null;
            if (allMatchingMetrics.length === 1) return allMatchingMetrics[0];
            allMatchingMetrics.sort((a, b) => { const dateA = parseDateTime(a.date); const dateB = parseDateTime(b.date); if (!dateB) return -1; if (!dateA) return 1; return dateB - dateA; });
            return allMatchingMetrics[0];
        }
        function addParentLinksAndHeadcounts(node, parent = null) { node.parent = parent; if (node.type === 'employee') { node.headcount = 1; return 1; } let total = 0; if (node.children) { node.children.forEach(child => { total += addParentLinksAndHeadcounts(child, node); }); } node.headcount = total; return total; }
        function getAllNodesByType(nodes, type) { let results = []; for (const node of nodes) { if (node.type === type) results.push(node); if (node.children) results = results.concat(getAllNodesByType(node.children, type)); } return results; }
        function convertDecimalToHMS(d) { if (d === undefined || d === null) return '0:0:0'; d = Number(d); const h = Math.floor(d); const m = Math.floor((d * 60) % 60); const s = Math.floor((d * 3600) % 60); return `${h}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`; }
        
        // ---------------------------------------------------------------------
        // 🔄 FILTER AND ROLLUP LOGIC (Uses state.trainingCatalog and state.FOOD_HANDLER_ROLES)
        // ---------------------------------------------------------------------

        function filterMetricsByDate(metrics, dateRange) {
            const { from, to } = dateRange; if (!from && !to) return metrics;
            const fromDate = parseDateToUTC(from); const toDate = parseDateToUTC(to);
            if (toDate) toDate.setUTCHours(23, 59, 59, 999); 
            const filtered = {};
            for (const topicKey in metrics) {
                const subtopicMetrics = metrics[topicKey].filter(metric => {
                    if (!metric.date) return false; const metricDate = parseDateToUTC(metric.date);
                    if (!metricDate) return false; if (fromDate && metricDate < fromDate) return false; if (toDate && metricDate > toDate) return false; return true;
                });
                if (subtopicMetrics.length > 0) filtered[topicKey] = subtopicMetrics;
            }
            return filtered;
        }
        
        function filterMetrics(metrics, topicFilters) {
            const { topic: selectedTopics, subtopic: selectedSubtopics, proficiency } = topicFilters;
            if (selectedTopics.length === 0 && selectedSubtopics.length === 0 && !proficiency) return metrics;
            const filtered = {};
            for (const topicKey in metrics) {
                if (selectedTopics.length > 0 && !selectedTopics.includes(topicKey)) continue;
                const subtopicMetrics = metrics[topicKey].filter(metric => {
                    if (selectedSubtopics.length > 0 && !selectedSubtopics.includes(metric.name)) return false;
                    if (proficiency && metric.targetCompetency !== parseInt(proficiency, 10)) return false;
                    return true;
                });
                if (subtopicMetrics.length > 0) filtered[topicKey] = subtopicMetrics;
            }
            return filtered;
        }
        
        function calculateRollups(node) {
            if (node.type === 'employee') {
                let isVisible = true;
                const { joiningDateRange, isFoodHandler, hierarchy } = state.ui.filters;
                const path = getFullPath(node);
                const pathInfo = { region: path.find(p => p.type === 'region')?.name, unit: path.find(p => p.type === 'unit')?.name, department: path.find(p => p.type === 'department')?.name };
                if (hierarchy.region.length > 0 && !hierarchy.region.includes(pathInfo.region)) isVisible = false;
                if (hierarchy.unit.length > 0 && !hierarchy.unit.includes(pathInfo.unit)) isVisible = false;
                if (hierarchy.department.length > 0 && !hierarchy.department.includes(pathInfo.department)) isVisible = false;
                if (hierarchy.role.length > 0 && !hierarchy.role.includes(node.role)) isVisible = false;
                if (joiningDateRange.from || joiningDateRange.to) {
                    const employeeJoiningDate = parseDateToUTC(node.joiningDate);
                    const fromDate = parseDateToUTC(joiningDateRange.from);
                    const toDate = parseDateToUTC(joiningDateRange.to);
                    if (toDate) toDate.setUTCHours(23, 59, 59, 999);
                    if (!employeeJoiningDate || (fromDate && employeeJoiningDate < fromDate) || (toDate && employeeJoiningDate > toDate)) isVisible = false;
                }
                if (isFoodHandler) {
                    const isHandler = state.FOOD_HANDLER_ROLES.includes(node.role);
                    if ((isFoodHandler === 'yes' && !isHandler) || (isFoodHandler === 'no' && isHandler)) isVisible = false;
                }
                if (!isVisible) { node.summary = { employees: 0, metrics: {}, individual: {} }; return node.summary; }
                const dateFilteredMetrics = filterMetricsByDate(node.metrics, state.ui.filters.dateRange);
                const finalMetrics = filterMetrics(dateFilteredMetrics, state.ui.filters.topicFilters);
                if (Object.keys(finalMetrics).length === 0 && (state.ui.filters.topicFilters.topic.length > 0 || state.ui.filters.topicFilters.subtopic.length > 0)) { node.summary = { employees: 0, metrics: {}, individual: {} }; return node.summary; }
                const individualSummary = { metricsByTopic: {} };
                for (const topic in node.metrics) {
                    const topicSummary = { attended: 0, actualHours: 0, targetCompetency: 0, actualCompetency: 0 };
                    const uniqueSubtopics = {};
                    node.metrics[topic].forEach(session => {
                        if(session.attended){ topicSummary.attended++; topicSummary.actualHours += session.actualHours; }
                        if (session.targetCompetency > 0) {
                            const key = session.name;
                            if (!uniqueSubtopics[key] || parseDateTime(session.date) > parseDateTime(uniqueSubtopics[key].date)) uniqueSubtopics[key] = session;
                        }
                    });
                    Object.values(uniqueSubtopics).forEach(session => { topicSummary.targetCompetency += session.targetCompetency; topicSummary.actualCompetency += session.actualCompetency; });
                    individualSummary.metricsByTopic[topic] = topicSummary;
                }
                node.summary = { employees: 1, metrics: finalMetrics, individual: individualSummary };
                return node.summary;
            }
            const summary = { employees: 0, metrics: {}, individual: { metricsByTopic: {} } };
            if (node.children) node.children.forEach(child => { const childSummary = calculateRollups(child); summary.employees += childSummary.employees; });
            node.summary = summary; return node.summary;
        }
        
        function filterTreeBySummary(node) {
            if (!node) return null;
            if (node.children) node.children = node.children.map(child => filterTreeBySummary(child)).filter(child => child !== null);
            if ((node.summary && node.summary.employees > 0) || (node.children && node.children.length > 0)) return node;
            return null;
        }
        
        function flattenHierarchy(nodes) {
            const employees = [];
            function traverse(node) {
                if (node.type === 'employee' && node.summary.employees > 0) {
                    employees.push({ id: node.id, name: node.name, fullPath: getFullPath(node), type: 'employee', summary: node.summary, allMetrics: node.metrics, status: node.status, role: node.role, joiningDate: node.joiningDate, employeeIdNum: node.employeeIdNum });
                } else if (node.children) node.children.forEach(traverse);
            }
            nodes.forEach(traverse);
            return employees;
        }

        function applyPagination(data) {
            const { pagination, filters } = state.ui;
            pagination.totalRows = data.length;
            if (pagination.rowsPerPage === -1 || filters.employees.length > 0) { pagination.totalPages = 1; pagination.currentPage = 1; return data.map(row => ({ ...row, isPaginatedVisible: true })); }
            pagination.totalPages = Math.ceil(pagination.totalRows / pagination.rowsPerPage) || 1;
            pagination.currentPage = Math.min(pagination.currentPage, pagination.totalPages);
            const startIndex = (pagination.currentPage - 1) * pagination.rowsPerPage;
            const endIndex = startIndex + pagination.rowsPerPage;
            const pagedRowIds = new Set(data.slice(startIndex, endIndex).map(r => r.id));
            return data.map(row => ({ ...row, isPaginatedVisible: pagedRowIds.has(row.id) }));
        }
        
        function calculateOverallSummary(employeeMetrics) {
            const allSessions = Object.values(employeeMetrics || {}).flat();
            console.log("allSessions",allSessions)
            if (allSessions.length === 0) return { status: 'Not Applicable', statusClass: 'na', totalSessions: 0, totalHours: '0:0:0', avgShould: '0.0', avgActual: '0.0', competencyPct: 'NA' };
            let totalSessionsAttended = 0; let totalHoursAttended = 0; const subtopicGroups = {};
            allSessions.forEach(session => { if (session.attended) { totalSessionsAttended++; totalHoursAttended += session.actualHours; } if (!subtopicGroups[session.name]) subtopicGroups[session.name] = []; subtopicGroups[session.name].push(session); });
            const totalApplicableCount = Object.keys(subtopicGroups).length;
            if (totalApplicableCount === 0) return { status: 'Not Applicable', statusClass: 'na', totalSessions: 0, totalHours: '0:0:0', avgShould: '0.0', avgActual: '0.0', competencyPct: 'NA' };
            let attendedSubtopicsCount = 0; let totalTargetCompetency = 0; let totalActualCompetency = 0;
            for (const subtopicName in subtopicGroups) {
                const sessions = subtopicGroups[subtopicName];
                if (sessions.some(s => s.attended)) attendedSubtopicsCount++;
                const latestSession = sessions.reduce((latest, current) => !latest || parseDateTime(current.date) > parseDateTime(latest.date) ? current : latest, null);
                if (latestSession) { totalTargetCompetency += latestSession.targetCompetency; totalActualCompetency += latestSession.actualCompetency; }
            }
            let status = 'Partially Attended'; let statusClass = 'partially';
            if (attendedSubtopicsCount === totalApplicableCount) { status = 'Attended'; statusClass = 'attended'; } else if (attendedSubtopicsCount === 0) { status = 'Not Attended'; statusClass = 'not-attended'; }
            const avgShould = totalApplicableCount > 0 ? (totalTargetCompetency / totalApplicableCount) : 0;
            const avgActual = totalApplicableCount > 0 ? (totalActualCompetency / totalApplicableCount) : 0;
            const competencyPct = avgShould > 0 ? `${Math.round((avgActual / avgShould) * 100)}%` : 'NA';
            return { status, statusClass, totalSessions: totalSessionsAttended, totalHours: convertDecimalToHMS(totalHoursAttended), avgShould: avgShould.toFixed(1), avgActual: avgActual.toFixed(1), competencyPct };
        }
        
        function getCatalogToRender(selectedTopics, selectedSubtopics) {
            let catalogToRender = state.trainingCatalog;
            if (selectedTopics.length > 0 || selectedSubtopics.length > 0) {
                const filteredCatalog = {};
                if (selectedSubtopics.length > 0) {
                    for (const topic in state.trainingCatalog) {
                        const relevantSubtopics = state.trainingCatalog[topic].filter(sub => selectedSubtopics.includes(sub));
                        if (relevantSubtopics.length > 0) { if (selectedTopics.length === 0 || selectedTopics.includes(topic)) filteredCatalog[topic] = relevantSubtopics; }
                    }
                } else if (selectedTopics.length > 0) { selectedTopics.forEach(topic => { if (state.trainingCatalog[topic]) filteredCatalog[topic] = state.trainingCatalog[topic]; }); }
                catalogToRender = filteredCatalog;
            }
            return catalogToRender;
        }
        
        // ---------------------------------------------------------------------
        // 🖼️ RENDERING FUNCTIONS
        // ---------------------------------------------------------------------
        
        function renderCompetencyCell(summary, rowData, isSummary = false) {
            const { date, attended, actualHours, history } = summary;
            let { targetCompetency, actualCompetency } = summary;

            if (isSummary) {
                const topicName = summary.name;
                const topicMetricsForDisplay = (rowData.summary.metrics[topicName] || []);
                let totalTarget = 0; let totalActual = 0; const uniqueSubtopics = {};
                topicMetricsForDisplay.forEach(session => {
                    if (session.targetCompetency > 0) {
                       const key = session.name; if (!uniqueSubtopics[key] || parseDateTime(session.date) > parseDateTime(uniqueSubtopics[key].date)) uniqueSubtopics[key] = session;
                    }
                });
                Object.values(uniqueSubtopics).forEach(session => { totalTarget += session.targetCompetency; totalActual += session.actualCompetency; });
                targetCompetency = Object.keys(uniqueSubtopics).length > 0 ? totalTarget / Object.keys(uniqueSubtopics).length : 0;
                actualCompetency = Object.keys(uniqueSubtopics).length > 0 ? totalActual / Object.keys(uniqueSubtopics).length : 0;
            }

            targetCompetency = Math.round(targetCompetency * 10) / 10;
            actualCompetency = Math.round(actualCompetency * 10) / 10;
            const competencyPct = targetCompetency > 0 ? Math.round((actualCompetency / targetCompetency) * 100) : 0;

            if (isSummary) {
                const topicName = summary.name;
                const filteredMetricsForTopic = rowData.summary.metrics[topicName] || [];
                const subtopicGroups = {};
                filteredMetricsForTopic.forEach(m => { if (!subtopicGroups[m.name]) subtopicGroups[m.name] = []; subtopicGroups[m.name].push(m); });
                const attendedCount = Object.values(subtopicGroups).filter(sessions => sessions.some(s => s.attended)).length;
                const totalCount = Object.keys(subtopicGroups).length;
                let attendanceStatusHtml;
                if (totalCount === 0) attendanceStatusHtml = `<div><i class="fas fa-ban" style="color: #6c757d;"></i><strong style="color: #6c757d;">Not Applicable</strong></div>`;
                else if (attendedCount === totalCount) attendanceStatusHtml = `<div><i class="fas fa-check-square" style="color: #28a745;"></i><strong style="color: #28a745;">Attended</strong></div>`;
                else if (attendedCount > 0) attendanceStatusHtml = `<div><i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i><strong style="color: #ffc107;">Partially Attended</strong></div>`;
                else attendanceStatusHtml = `<div><i class="fas fa-times-circle" style="color: #dc3545;"></i><strong style="color: #dc3545;">Not Attended</strong></div>`;
                const actualHrs = filteredMetricsForTopic.reduce((sum, s) => sum + (s.attended ? s.actualHours : 0), 0);
                console.log("actualHrsactualHrs",actualHrs)
                
                // const actualHrsDecimal = filteredMetricsForTopic.reduce((sum, s) => sum + (s.attended ? Number(s.actualHours) : 0), 0);
                // JavaScript - inside renderCompetencyCell (isSummary block)
                
                // ... [previous unchanged HTML/variable declarations] ...
                                
                // 🎯 F I X E D   L O G I C
                const actualHrsDecimal = filteredMetricsForTopic.reduce((sum, s) => {
                    // 1. सुनिश्चित करें कि actualHours एक संख्या है (0 यदि null/undefined है)
                    const hours = Number(s.actualHours) || 0; 
                    
                    // 2. केवल तभी योग करें जब सत्र 'attended' हो
                    return sum + (s.attended ? hours : 0);
                }, 0); // <--- सुनिश्चित करता है कि योग संख्या है
                
                // 💡 (Optional Debug) अब आप इसे सुरक्षित रूप से लॉग कर सकते हैं:
                // console.log("actualHrsDecimal (Final Sum):", actualHrsDecimal);
                
                
                // 🎯 2. INLINE H:M:S CONVERSION LOGIC (unchanged and correct)
                const d = Number(actualHrsDecimal) || 0; 
                const h = Math.floor(d);
                const m = Math.floor((d * 60) % 60);
                const s = Math.floor((d * 3600) % 60);
                
                const final_h = isNaN(h) ? 0 : h;
                const final_m = isNaN(m) ? 0 : m;
                const final_s = isNaN(s) ? 0 : s;
                
                const hmsHours = `${final_h}:${String(final_m).padStart(2, '0')}:${String(final_s).padStart(2, '0')}`;
                // ... [rest of the return HTML] ...



                return `<div class="employee-metric-cell"><div class="training-details-summary">
                ${attendanceStatusHtml}<div><i class="fas fa-check-circle"></i><span>Sub-Topics Attended: ${attendedCount} / ${totalCount}</span></div><div><i class="fas fa-stopwatch"></i>
                <span>Total Hours: ${hmsHours}</span></div></div><hr/><div class="competency-section">
                <div class="competency-header">Overall Competency</div><div class="competency-scores"><span>Should: <strong>${targetCompetency.toFixed(1)}</strong></span><span>Actual: <strong>${actualCompetency.toFixed(1)}</strong></span></div><div class="competency-bar-container"><div class="competency-bar-fill" style="width: ${competencyPct}%;">${competencyPct}%</div></div></div></div>`;
            }
            
            
            // ${convertDecimalToHMS(actualHrs)}

            // const hmsHours = convertDecimalToHMS(actualHours);
            
            
              const hmsHours = actualHours;
            
            const sessionCountDisplay = attended > 0 ? `<a class="session-link" data-action="open-session-history" data-employee-id="${rowData.id}" data-metric-name="${summary.name}">${attended}</a>` : `<strong>${attended}</strong>`;
            let attendanceDisplayHtml;
            if (targetCompetency === 0) attendanceDisplayHtml = `<div>Attended: <strong>NA</strong></div>`;
            else if (attended > 0 && date) attendanceDisplayHtml = `<div>Attended: <strong>${new Date(date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })} (Attended)</strong></div>`;
            else attendanceDisplayHtml = `<div>Attended: <strong>Not Attended</strong></div>`;

            let detailsHtml = `<div class="training-details-summary">${attendanceDisplayHtml}<div>Hours: <strong>${hmsHours}</strong> | Sess: ${sessionCountDisplay}</div></div><hr/>`;

            let evidenceIcon = '';
            if (history && history.length > 0) {
                const hasValidEvidence = history.some(h => h.url && h.url !== '#');
                if(hasValidEvidence) evidenceIcon = `<i class="fas fa-paperclip" style="color: #28a745; margin-left:4px;"></i>`;
            }

            let scoreDisplay = Math.round(actualCompetency);
            if (history && history.length > 1) {
                const currentScore = history[history.length - 1].score;
                const prevScore = history[history.length - 2].score;
                if (currentScore !== prevScore) {
                    scoreDisplay = `<span class="prev-score">${prevScore}</span> <i class="fas fa-arrow-right"></i> <strong>${currentScore}</strong>`;
                }
            }

            const actualCompetencyHtml = `<button class="score-btn" data-action="open-competency-manager" data-employee-id="${rowData.id}" data-metric-name="${summary.name}">${scoreDisplay} ${evidenceIcon}</button>`;
            
            const targetHtml = `<strong>${targetCompetency}</strong><button class="info-icon-btn" data-action="open-rubric-modal" title="View Competency Scale"><i class="fas fa-info-circle"></i></button>`;

            return `<div class="employee-metric-cell">${detailsHtml}<div class="competency-header">Competency</div><div class="competency-scores"><span>Should: ${targetHtml}</span><span>Actual: ${actualCompetencyHtml}</span></div><div class="competency-bar-container"><div class="competency-bar-fill" style="width: ${competencyPct}%;">${competencyPct}%</div></div></div>`;
        }
        
        function renderTopicSummaryCell(rowData, topicName) { return renderCompetencyCell({ name: topicName }, rowData, true); }

        function renderRow(rowData, serialNumber, catalogToRender) {
            const { id, name, summary, status, role, joiningDate, employeeIdNum, isPaginatedVisible } = rowData;
            if (!isPaginatedVisible) return '';
            const isFoodHandler = state.FOOD_HANDLER_ROLES.includes(role);
            const foodHandlerIcon = isFoodHandler ? `<i class="fas fa-utensils" title="Food Handler" style="color: var(--icon-color); margin-left: 8px; font-size: 0.9em;"></i>` : '';
            const employeeDisplayName = serialNumber ? `${serialNumber}. ${name}` : name;
            const hierarchyPath = rowData.fullPath; const reversedPath = [...hierarchyPath].reverse();
            const hierarchyItems = reversedPath.map(p => { let typeLabel = p.type.charAt(0).toUpperCase() + p.type.slice(1); if (typeLabel === 'Region') typeLabel = 'Regional'; if (typeLabel === 'Corporate') return null; return `<span class="info-item-linear"><strong class="info-label-linear">${typeLabel}:</strong> ${p.name}</span>`; }).filter(Boolean);
            const allInfoItems = [ ...hierarchyItems, `<span class="info-item-linear"><strong class="info-label-linear">Role:</strong> ${role}</span>`, `<span class="info-item-linear"><strong class="info-label-linear">Joined:</strong> ${joiningDate}</span>` ];
            const combinedInfoHtml = allInfoItems.join('<span class="info-separator">|</span>');
            const overallSummary = calculateOverallSummary(summary.metrics);
            let hierarchyCellHtml = `<div class="employee-details-block"><div class="employee-header"><span class="employee-name">${employeeDisplayName}</span> ${foodHandlerIcon}<span class="status-badge ${status.toLowerCase()}">${status}</span><button class="action-button view-card-btn" data-action="open-training-card" data-employee-id="${id}">View Card</button></div><div><span class="employee-id-num">${employeeIdNum}</span></div><div class="employee-info-container"><div class="info-line">${combinedInfoHtml}</div><div class="info-line"><span class="info-item-linear"><strong class="info-label-linear">Training Status:</strong> <span class="summary-status-badge ${overallSummary.statusClass}">${overallSummary.status}</span></span><span class="info-separator">|</span><span class="info-item-linear"><strong class="info-label-linear">Sessions:</strong> ${overallSummary.totalSessions}</span><span class="info-separator">|</span><span class="info-item-linear"><strong class="info-label-linear">Hours:</strong> ${overallSummary.totalHours}</span><span class="info-separator">|</span><span class="info-item-linear"><strong class="info-label-linear">Competency (Should/Actual):</strong> ${overallSummary.avgShould} / ${overallSummary.avgActual}</span></div></div></div>`;
            const visibleMetricGroups = summary.metrics || {}; 
            let metricCellsHtml = '';
            for (const topic in catalogToRender) {
                const subtopicsInCatalog = catalogToRender[topic]; const subtopicsInData = visibleMetricGroups[topic] || [];
                const isColExpanded = state.ui.expandedCols.has(topic);
                if (isColExpanded) {
                    metricCellsHtml += subtopicsInCatalog.map(subtopicName => {
                        let cellContent; const sessions = subtopicsInData.filter(m => m.name === subtopicName);
                        if (sessions.length > 0) {
                            const latestSession = sessions.reduce((latest, current) => (parseDateTime(current.date) > parseDateTime(latest.date)) ? current : latest);
                            const totalAttended = sessions.reduce((sum, s) => sum + s.attended, 0);
                            const totalHours = sessions.reduce((sum, s) => sum + s.actualHours, 0);
                            const targetHours = sessions.reduce((sum, s) => sum + s.targetHours, 0);
                            const sessionHistory = latestSession.history || [];
                            cellContent = renderCompetencyCell({ ...latestSession, attended: totalAttended, total: sessions.length, actualHours: totalHours, targetHours: targetHours, history: sessionHistory }, rowData, false);
                        } else { cellContent = renderCompetencyCell({ name: subtopicName, attended: 0, total: 0, actualHours: 0, targetHours: 0, targetCompetency: 0, date: null, actualCompetency: 0, history: [] }, rowData, false); }
                        return `<td>${cellContent}</td>`;
                    }).join('');
                } else { metricCellsHtml += `<td class="summary-col">${renderTopicSummaryCell(rowData, topic)}</td>`; }
            }
            return `<tr data-id="${id}" class="employee"><td class="hierarchy-col">${hierarchyCellHtml}</td>${metricCellsHtml}</tr>`;
        }
        
        function renderTable(viewData) {
            const { topic: selectedTopics, subtopic: selectedSubtopics } = state.ui.filters.topicFilters;
            let catalogToRender = getCatalogToRender(selectedTopics, selectedSubtopics);
            let header1Html = ''; let header2Html = '';
            for (const topic in catalogToRender) {
                const subtopics = catalogToRender[topic]; const isColExpanded = state.ui.expandedCols.has(topic);
                const colspan = isColExpanded ? subtopics.length : 1; const iconClass = isColExpanded ? 'fa-minus-circle' : 'fa-plus-circle';
                header1Html += `<th class="shrinkable-header" colspan="${colspan}" data-action="toggle-column" data-col-group="${topic}">${topic} <i class="toggle-icon-col fas ${iconClass}"></i></th>`;
                if (isColExpanded) { header2Html += subtopics.map(m => `<th>${m}</th>`).join(''); } else { header2Html += `<th class="summary-col">Summary</th>`; }
            }
            let serialCounter = (state.ui.pagination.currentPage - 1) * state.ui.pagination.rowsPerPage;
            const finalBodyHtml = viewData.map(rowData => { if (rowData.isPaginatedVisible) { serialCounter++; return renderRow(rowData, serialCounter, catalogToRender); } return ''; }).join('');
            return `<div class="table-container"><table class="interactive-table"><thead><tr><th rowspan="2" class="hierarchy-col">Staff Details</th>${header1Html}</tr><tr>${header2Html}</tr></thead><tbody>${finalBodyHtml || `<tr><td colspan="${Object.keys(catalogToRender).length + 1}" style="text-align:center; padding: 40px; font-size: 1.1em; color: var(--secondary-text);">No staff members match the current filter criteria.</td></tr>`}</tbody></table></div>`;
        }
        
        function renderControls() {
            const { filters } = state.ui;
            const attendanceStatusFilter = `<div class="filter-group"><label for="filter-attendance-status">Status:</label><select id="filter-attendance-status" data-action="filter-change"><option value="" ${filters.attendanceStatus === '' ? 'selected' : ''}>All</option><option value="attended" ${filters.attendanceStatus === 'attended' ? 'selected' : ''}>Attended</option><option value="partially_attended" ${filters.attendanceStatus === 'partially_attended' ? 'selected' : ''}>Partially Attended</option><option value="not_attended" ${filters.attendanceStatus === 'not_attended' ? 'selected' : ''}>Not Attended</option><option value="not_applicable" ${filters.attendanceStatus === 'not_applicable' ? 'selected' : ''}>Not Applicable</option></select></div>`;
            const desktopFoodHandlerFilter = `<div class="desktop-only filter-group"><label for="filter-food-handler">Food Handler:</label><select id="filter-food-handler" data-action="filter-change"><option value="" ${filters.isFoodHandler === '' ? 'selected' : ''}>All</option><option value="yes" ${filters.isFoodHandler === 'yes' ? 'selected' : ''}>Yes</option><option value="no" ${filters.isFoodHandler === 'no' ? 'selected' : ''}>No</option></select></div>`;
            const desktopEmployeeFilter = `<div class="desktop-only filter-group"><div id="employee-filter-container" class="custom-select-filter" data-filter-type="employees"></div></div>`;
            const mobileFilterButtons = `<div class="mobile-only"><button id="mobile-general-filter-btn" class="action-button" data-action="open-general-filter"><i class="fas fa-users-cog"></i> General Filters</button> </div>`;
            const mobileCombinedButtons = `<div class="mobile-flex-group"> <button id="mobile-topic-filter-btn" class="action-button" data-action="open-topic-filter" style="background-color: #007bff;"><i class="fas fa-filter"></i> Topic Filters</button> <button class="action-button" data-action="open-period-filter" style="background-color: #007bff;"><i class="fas fa-calendar-alt"></i> Period Filters</button> </div>`;
            const employeeCountDisplay = `<div id="employee-count-display" class="filter-group"></div>`;
            const refreshButton = `<button class="action-button refresh" data-action="refresh" title="Refresh Data"><i class="fas fa-sync-alt"></i></button>`;
            const downloadButton = `<button class="action-button excel" data-action="open-download-modal" title="Download Data"><i class="fas fa-file-excel"></i> Download</button>`;
            return `<div class="dashboard-controls">${mobileFilterButtons}<div class="desktop-only" style="display:flex; gap: 15px;"><button class="action-button" data-action="open-hierarchy-filter" style="background-color: #007bff;" title="Filter by Hierarchy"><i class="fas fa-sitemap"></i> Hierarchy Filters</button>${attendanceStatusFilter}<button class="action-button" data-action="open-topic-filter" style="background-color: #007bff;" title="Filter by Training Topic"><i class="fas fa-filter"></i> Topic Filters</button><button class="action-button" data-action="open-period-filter" style="background-color: #007bff;"><i class="fas fa-calendar-alt"></i> Period Filters</button></div>${mobileCombinedButtons}${desktopFoodHandlerFilter}${employeeCountDisplay}${desktopEmployeeFilter}${refreshButton}${downloadButton}</div>`;
        }
        
        function renderPagination() { if (state.ui.filters.employees.length > 0) { return ''; } const { currentPage, totalPages, rowsPerPage, totalRows } = state.ui.pagination; let pageInfo = `Page ${totalPages > 0 ? currentPage : 0} of ${totalPages}`; if (rowsPerPage === -1) { pageInfo = `Showing all ${totalRows} items`; } return ` <div class="pagination-controls"> <div class="pagination-item"> <label for="rows-per-page">Rows per page:</label> <select id="rows-per-page" data-action="change-rows-per-page"> <option value="20" ${rowsPerPage === 20 ? 'selected' : ''}>20</option> <option value="50" ${rowsPerPage === 50 ? 'selected' : ''}>50</option> <option value="100" ${rowsPerPage === 100 ? 'selected' : ''}>100</option> <option value="-1" ${rowsPerPage === -1 ? 'selected' : ''}>All</option> </select> </div> <div class="pagination-item"> <button id="prev-page-btn" data-action="change-page" data-direction="-1" ${currentPage <= 1 ? 'disabled' : ''} title="Previous Page"><i class="fas fa-chevron-left"></i></button> <span id="page-info">${pageInfo}</span> <button id="next-page-btn" data-action="change-page" data-direction="1" ${currentPage >= totalPages || totalPages === 0 ? 'disabled' : ''} title="Next Page"><i class="fas fa-chevron-right"></i></button> </div> </div> `; }
        
        function getFilteredData(data, filters) {
            const { employees: selectedEmployees } = filters;
            if (selectedEmployees.length > 0) { const employeeNodes = getAllNodesByType(data, 'employee').filter(emp => selectedEmployees.includes(`${emp.name} ${emp.employeeIdNum}`)); return { nodesForTable: employeeNodes }; }
            return { nodesForTable: data };
        }
        
        function getAvailableFilterOptions(rawData) {
            const options = { employees: new Set(), hierarchy: { region: new Set(), unit: new Set(), department: new Set(), role: new Set() } };
            const allEmployeesInScope = getAllNodesByType(rawData, 'employee');
            allEmployeesInScope.forEach(e => { 
                options.employees.add(`${e.name} ${e.employeeIdNum}`); options.hierarchy.role.add(e.role);
                const path = getFullPath(e);
                const region = path.find(p => p.type === 'region'); const unit = path.find(p => p.type === 'unit'); const department = path.find(p => p.type === 'department');
                if (region) options.hierarchy.region.add(region.name); if (unit) options.hierarchy.unit.add(unit.name); if (department) options.hierarchy.department.add(department.name);
            });
            return { employees: [...options.employees].sort(), hierarchy: { region: [...options.hierarchy.region].sort(), unit: [...options.hierarchy.unit].sort(), department: [...options.hierarchy.department].sort(), role: [...options.hierarchy.role].sort() } };
        }
        
        function updateFilterControls() {
            const { employees: employeeItems } = state.globalFilterOptions; const { employees: selectedEmployees } = state.ui.filters;
            const updateSelect = (container, items, selectedItems, placeholder) => {
                if (!container) return; const button = container.querySelector('.select-button'); const list = container.querySelector('.select-list'); const search = container.querySelector('.select-search');
                list.innerHTML = ''; items.forEach(item => { const isChecked = selectedItems.includes(item); list.innerHTML += `<label><input type="checkbox" value="${item}" ${isChecked ? 'checked' : ''}><span>${item}</span></label>`; });
                if (button) {
                    if (selectedItems.length === 0) { button.textContent = placeholder; button.title = placeholder; } else { const displayNames = selectedItems.map(item => item.split(' (ID:')[0]); const text = displayNames.join(', '); button.textContent = text; button.title = text; }
                }
                if (search) search.placeholder = `Search ${placeholder}...`;
            };
            const employeeFilterContainer = document.getElementById('employee-filter-container');
            if(employeeFilterContainer){ if(!employeeFilterContainer.innerHTML) employeeFilterContainer.innerHTML = `<button class="select-button" data-action="toggle-select-dropdown"></button><div class="select-dropdown"><input type="text" class="select-search"><div class="select-list"></div></div>`; updateSelect(employeeFilterContainer, employeeItems, selectedEmployees, 'All Employees'); }
        }
        
        function processViewData() {
            if (state.rawData.length === 0) {
                 state.viewData = []; 
                 state.ui.pagination.totalRows = 0;
                 return;
            }
            
            calculateRollups(state.rawData[0]); 
            const { nodesForTable: initialNodes } = getFilteredData(state.rawData, state.ui.filters);
            const clonedNodes = deepClone(initialNodes);
            prunedNodes = clonedNodes.map(node => filterTreeBySummary(node)).filter(node => node !== null); 
            prunedNodes.forEach(rootNode => addParentLinksAndHeadcounts(rootNode, null));
            let flatData = flattenHierarchy(prunedNodes); 
            const { attendanceStatus } = state.ui.filters;
            if (attendanceStatus) {
                flatData = flatData.filter(employee => {
                    const overallSummary = calculateOverallSummary(employee.summary.metrics);
                    if (attendanceStatus === 'not_applicable') return overallSummary.statusClass === 'na'; if (attendanceStatus === 'attended') return overallSummary.statusClass === 'attended'; if (attendanceStatus === 'partially_attended') return overallSummary.statusClass === 'partially'; if (attendanceStatus === 'not_attended') return overallSummary.statusClass === 'not-attended'; return false;
                });
            }
            
            flatData.sort((a, b) => {
                const isActiveA = a.status === 'Active';
                const isActiveB = b.status === 'Active';
                if (isActiveA && !isActiveB) return -1; 
                if (!isActiveA && isActiveB) return 1; 
                return a.name.localeCompare(b.name);
            });

            state.viewData = applyPagination(flatData);
        }

        function reprocessAndRender() { 
            if (!state.globalFilterOptions.hierarchy.region.length && state.rawData.length > 0) { 
                state.globalFilterOptions = getAvailableFilterOptions(state.rawData); 
            } 
            render({ fullRender: true }); 
        }
        
        function render(options = { fullRender: false, updateTable: true, updatePagination: true, updateControls: true }) {
            const container = document.getElementById('dashboard-container'); 
            if (!container) return;
            
            if (options.fullRender || options.updateTable) processViewData();
            
            // If rawData is empty, display an error message
            if (state.rawData.length === 0) {
                 container.innerHTML = '<div style="text-align: center; padding: 50px; color: #dc3545;">No data available. Please refresh or check the backend connection.</div>';
                 return;
            }

            const tableContainer = container.querySelector('.table-container');
            const scrollPos = tableContainer ? { top: tableContainer.scrollTop, left: tableContainer.scrollLeft } : { top: 0, left: 0 };
            
            if (options.fullRender || container.innerHTML === '') {
                container.innerHTML = `${renderControls()}${renderTable(state.viewData)}${renderPagination()}`;
            } else {
                if (options.updateTable) { if (tableContainer) tableContainer.outerHTML = renderTable(state.viewData); }
                if (options.updatePagination) { const paginationControls = container.querySelector('.pagination-controls'); const newPaginationHTML = renderPagination(); if (paginationControls) { if (newPaginationHTML) paginationControls.outerHTML = newPaginationHTML; else paginationControls.innerHTML = ''; } else if (newPaginationHTML) { container.insertAdjacentHTML('beforeend', newPaginationHTML); } }
                if (options.updateControls) { const controls = container.querySelector('.dashboard-controls'); if (controls) controls.outerHTML = renderControls(); }
            }
            
            if (options.updateTable) { const newTableContainer = container.querySelector('.table-container'); if(newTableContainer) { newTableContainer.scrollTop = scrollPos.top; newTableContainer.scrollLeft = scrollPos.left; } }
            
            updateFilterControls();
            
            const countDisplay = document.getElementById('employee-count-display');
            if (countDisplay) {
                const totalVisibleInTable = state.ui.pagination.totalRows;
                let fhCount = 0; let nfhCount = 0;
                const unpaginatedData = flattenHierarchy(prunedNodes);
                unpaginatedData.forEach(employeeNode => { if (state.FOOD_HANDLER_ROLES.includes(employeeNode.role)) fhCount++; else nfhCount++; });
                countDisplay.innerHTML = `<span style="font-weight: 500; color: var(--secondary-text);"><i class="fas fa-users"></i> Filtered Total: ${totalVisibleInTable}</span><span title="Food Handlers"><i class="fas fa-utensils" style="color: var(--level1-color);"></i> ${fhCount}</span><span title="Non-Food Handlers"><i class="fas fa-user-tie" style="color: var(--download-btn-bg);"></i> ${nfhCount}</span>`;
            }
            const generalFilterBtn = document.getElementById('mobile-general-filter-btn');
            if (generalFilterBtn) { const { employees, isFoodHandler } = state.ui.filters; const isActive = employees.length > 0 || isFoodHandler; generalFilterBtn.style.backgroundColor = isActive ? 'var(--level1-color)' : '#007bff'; generalFilterBtn.innerHTML = isActive ? `<i class="fas fa-check-circle"></i> General Filters Active` : `<i class="fas fa-users-cog"></i> General Filters`; }
            if (lastScrollState) { const newTableContainer = document.querySelector('.table-container'); if (newTableContainer) { newTableContainer.scrollTop = lastScrollState.top; newTableContainer.scrollLeft = lastScrollState.left; } lastScrollState = null; }
        }
        
        // ---------------------------------------------------------------------
        // 📥 EXPORT LOGIC
        // ---------------------------------------------------------------------

        function generateAndDownloadCsv(filename, headers, rows) {
            const csvContent = [ headers.join(','), ...rows.map(row => row.map(field => { const fieldStr = String(field ?? ''); if (fieldStr.includes(',') || fieldStr.includes('"') || fieldStr.includes('\n')) { return `"${fieldStr.replace(/"/g, '""')}"`; } return fieldStr; }).join(',')) ].join('\r\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' }); const link = document.createElement("a");
            if (link.download !== undefined) { const url = URL.createObjectURL(blob); link.setAttribute("href", url); link.setAttribute("download", filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); }
        }
        
        function getBaseEmployeeInfo(employee, index) {
            const pathInfo = { Corporate: '', Regional: '', Unit: '', Department: '' };
            employee.fullPath.forEach(p => { if (p.type === 'corporate') pathInfo.Corporate = p.name; if (p.type === 'region') pathInfo.Regional = p.name; if (p.type === 'unit') pathInfo.Unit = p.name; if (p.type === 'department') pathInfo.Department = p.name; });
            const employeeId = employee.employeeIdNum.replace(/[()ID:\s]/g, ''); const isFoodHandler = state.FOOD_HANDLER_ROLES.includes(employee.role) ? 'Yes' : 'No';
            return [ index + 1, pathInfo.Corporate, pathInfo.Regional, pathInfo.Unit, pathInfo.Department, employeeId, employee.name, employee.role, isFoodHandler, employee.status, employee.joiningDate ];
        }
        
        function exportAttendanceReport() {
            let dataToExport = flattenHierarchy(prunedNodes);
            dataToExport.sort((a, b) => { const isActiveA = a.status === 'Active'; const isActiveB = b.status === 'Active'; if (isActiveA && !isActiveB) return -1; if (!isActiveA && isActiveB) return 1; return a.name.localeCompare(b.name); });
            const { attendanceStatus } = state.ui.filters;
            if (attendanceStatus) {
                dataToExport = dataToExport.filter(employee => {
                    const overallSummary = calculateOverallSummary(employee.summary.metrics);
                    if (attendanceStatus === 'not_applicable') return overallSummary.statusClass === 'na'; if (attendanceStatus === 'attended') return overallSummary.statusClass === 'attended'; if (attendanceStatus === 'partially_attended') return overallSummary.statusClass === 'partially'; if (attendanceStatus === 'not_attended') return overallSummary.statusClass === 'not-attended'; return false;
                });
            }
            const baseHeaders = ["S.No.", "Corporate", "Regional", "Unit", "Department", "Employee ID", "Employee Name", "Role", "Food Handler", "Status", "Joined Date"];
            const { topic: selectedTopics, subtopic: selectedSubtopics } = state.ui.filters.topicFilters;
            const catalogToRender = getCatalogToRender(selectedTopics, selectedSubtopics);
            const trainingHeaders = Object.entries(catalogToRender).flatMap(([topic, subtopics]) => subtopics.map(sub => `${sub} (${topic})`));
            const headers = [...baseHeaders, ...trainingHeaders];
            const rows = dataToExport.map((employee, index) => {
                const baseInfo = getBaseEmployeeInfo(employee, index);
                const trainingData = trainingHeaders.map(header => {
                    const match = header.match(/(.+) \((.+)\)/); if (!match) return ''; const subtopicName = match[1]; const topicName = match[2];
                    const allSessionsForSubtopic = (employee.allMetrics[topicName] || []).filter(s => s.name === subtopicName);
                    if (allSessionsForSubtopic.length === 0) return 'NA';
                    const attendedSessions = allSessionsForSubtopic.filter(s => s.attended === 1);
                    if (attendedSessions.length === 0) return 'Not Attended';
                    return attendedSessions.map(s => { const d = parseDateTime(s.date); if (!d) return ''; const day = String(d.getDate()).padStart(2, '0'); const month = String(d.getMonth() + 1).padStart(2, '0'); const year = d.getFullYear(); return `${day}-${month}-${year}`; }).join('\n');
                });
                return [...baseInfo, ...trainingData];
            }).filter(Boolean);
            generateAndDownloadCsv("Attendance_Dates_Report.csv", headers, rows);
        }

        function exportSummaryReport() {
            let dataToExport = flattenHierarchy(prunedNodes);
            dataToExport.sort((a, b) => { const isActiveA = a.status === 'Active'; const isActiveB = b.status === 'Active'; if (isActiveA && !isActiveB) return -1; if (!isActiveA && isActiveB) return 1; return a.name.localeCompare(b.name); });
            const { attendanceStatus } = state.ui.filters;
            if (attendanceStatus) {
                dataToExport = dataToExport.filter(employee => {
                    const overallSummary = calculateOverallSummary(employee.summary.metrics);
                    if (attendanceStatus === 'not_applicable') return overallSummary.statusClass === 'na'; if (attendanceStatus === 'attended') return overallSummary.statusClass === 'attended'; if (attendanceStatus === 'partially_attended') return overallSummary.statusClass === 'partially'; if (attendanceStatus === 'not_attended') return overallSummary.statusClass === 'not-attended'; return false;
                });
            }
            const baseHeaders = ["S.No.", "Corporate", "Regional", "Unit", "Department", "Employee ID", "Employee Name", "Role", "Food Handler", "Status", "Joined Date"];
            const overallSummaryHeaders = [ "Overall Training Status", "Overall Total Sessions (Attended)", "Overall Total Hours (Attended)", "Overall Avg Competency (Should)", "Overall Avg Competency (Actual)", "Overall Competency %" ];
            const { topic: selectedTopics, subtopic: selectedSubtopics } = state.ui.filters.topicFilters;
            const catalogToRender = getCatalogToRender(selectedTopics, selectedSubtopics);
            const topicSummaryHeaders = Object.keys(catalogToRender).flatMap(topic => [ `${topic} - Total Sessions (Attended)`, `${topic} - Total Hours (Attended)`, `${topic} - Competency (Should)`, `${topic} - Competency (Actual)`, `${topic} - Overall Competency %` ]);
            const headers = [...baseHeaders, ...overallSummaryHeaders, ...topicSummaryHeaders];
            const rows = dataToExport.map((employee, index) => {
                const baseInfo = getBaseEmployeeInfo(employee, index);
                const overallSummary = calculateOverallSummary(employee.summary.metrics);
                const overallSummaryData = [ overallSummary.status, overallSummary.totalSessions, overallSummary.totalHours, overallSummary.avgShould, overallSummary.avgActual, overallSummary.competencyPct ];
                const topicSummaryData = Object.keys(catalogToRender).flatMap(topic => {
                    const metricsForTopic = (employee.allMetrics[topic] || []).filter(s => { const isInSubtopicFilter = !selectedSubtopics.length || selectedSubtopics.includes(s.name); return isInSubtopicFilter; });
                    if (metricsForTopic.length === 0) return ["NA", "0.00", "NA", "NA", "NA"]; 
                    const topicSummary = { attendedSessions: 0, actualHours: 0, targetCompetency: 0, actualCompetency: 0 }; const uniqueSubtopics = {};
                    metricsForTopic.forEach(session => { if(session.attended){ topicSummary.attendedSessions++; topicSummary.actualHours += session.actualHours; } if (session.targetCompetency > 0) { const key = session.name; if (!uniqueSubtopics[key] || parseDateTime(session.date) > parseDateTime(uniqueSubtopics[key].date)) uniqueSubtopics[key] = session; } });
                    Object.values(uniqueSubtopics).forEach(session => { topicSummary.targetCompetency += session.targetCompetency; topicSummary.actualCompetency += session.actualCompetency; });
                    const competencyPct = topicSummary.targetCompetency > 0 ? ((topicSummary.actualCompetency / topicSummary.targetCompetency) * 100).toFixed(0) + '%' : 'NA';
                    return [ topicSummary.attendedSessions, topicSummary.actualHours.toFixed(2), topicSummary.targetCompetency, topicSummary.actualCompetency, competencyPct ];
                });
                return [...baseInfo, ...overallSummaryData, ...topicSummaryData];
            }).filter(Boolean);
            generateAndDownloadCsv("Competency_Summary_Report.csv", headers, rows);
        }

        // ---------------------------------------------------------------------
        // ⚡ EVENT HANDLERS
        // ---------------------------------------------------------------------

        function handleAction(e) {
            const actionTarget = e.target.closest('[data-action]'); if (!actionTarget) return;
            const { action, colGroup, employeeId, metricName } = actionTarget.dataset;
            let shouldReprocess = false;
            let renderOptions = { updateTable: true, updatePagination: true, updateControls: false };
            
            const actions = {
                'open-download-modal': () => document.getElementById('download-modal-overlay').classList.add('active'),
                'close-download-modal': () => document.getElementById('download-modal-overlay').classList.remove('active'),
                'download-attendance-report': () => { exportAttendanceReport(); document.getElementById('download-modal-overlay').classList.remove('active'); },
                'download-summary-report': () => { exportSummaryReport(); document.getElementById('download-modal-overlay').classList.remove('active'); },
                'change-rows-per-page': () => { state.ui.pagination.rowsPerPage = parseInt(actionTarget.value, 10); state.ui.pagination.currentPage = 1; renderOptions.updateTable = false; shouldReprocess = true; },
                'change-page': () => { const direction = parseInt(actionTarget.dataset.direction, 10); const { currentPage, totalPages } = state.ui.pagination; const newPage = currentPage + direction; if (newPage >= 1 && newPage <= totalPages) { state.ui.pagination.currentPage = newPage; render({ updateTable: true, updatePagination: true, updateControls: false }); } },
                'toggle-column': () => { const tableContainer = document.querySelector('.table-container'); if (tableContainer) { lastScrollState = { top: tableContainer.scrollTop, left: tableContainer.scrollLeft }; } state.ui.expandedCols.has(colGroup) ? state.ui.expandedCols.delete(colGroup) : state.ui.expandedCols.add(colGroup); render({ updateTable: true, updatePagination: true, updateControls: false }); },
                'open-general-filter': () => {
                    const modalBody = document.querySelector('#general-filter-modal .modal-body'); const { filters } = state.ui;
                    modalBody.innerHTML = `<div class="form-group"><label>Employee:</label><div id="employee-filter-container" class="custom-select-filter" data-filter-type="employees"></div></div><div class="form-group"><label>Food Handler:</label><select id="filter-food-handler"><option value="">All</option><option value="yes">Yes</option><option value="no">No</option></select></div><div class="form-group"><label>Attendance Status:</label><select id="filter-attendance-status"><option value="">All</option><option value="attended">Attended</option><option value="partially_attended">Partially Attended</option><option value="not_attended">Not Attended</option><option value="not_applicable">Not Applicable</option></select></div>`;
                    document.getElementById('filter-food-handler').value = filters.isFoodHandler; document.getElementById('filter-attendance-status').value = filters.attendanceStatus; updateFilterControls(); document.getElementById('general-filter-modal-overlay').classList.add('active');
                },
                'close-general-filter': () => document.getElementById('general-filter-modal-overlay').classList.remove('active'),
                'clear-general-filter': () => { Object.assign(state.ui.filters, { employees: [], isFoodHandler: '', attendanceStatus: '' }); document.getElementById('general-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'download-training-card': () => {
                    const cardContent = document.getElementById('training-card-content'); const modal = document.getElementById('training-card-modal'); if (!cardContent || !modal) return;
                    modal.style.maxWidth = '1000px';
                    html2canvas(cardContent, { scale: 2, backgroundColor: '#ffffff' }).then(canvas => { const { jsPDF } = window.jspdf; const imgData = canvas.toDataURL('image/png'); const pdf = new jsPDF({ orientation: 'portrait', unit: 'px', format: [canvas.width, canvas.height] }); pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height); pdf.save('employee-training-card.pdf'); modal.style.maxWidth = '90vw'; });
                },
                'open-training-card': () => {
                    const cardContentEl = document.getElementById('training-card-content');
                    const cardStylesEl = document.getElementById('training-card-dynamic-styles');
                    cardStylesEl.textContent = ` #training-card-content { font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #1f2937; line-height: 1.5; font-size: 10pt; margin: 0; padding: 20pt; background-color: #ffffff; -webkit-print-color-adjust: exact; print-color-adjust: exact; } #training-card-content .header-content { display: flex; justify-content: space-between; align-items: center; } #training-card-content .document-title { font-size: 16pt; font-weight: 700; letter-spacing: -0.5px; } #training-card-content .document-subtitle { font-size: 9pt; opacity: 0.9; margin-top: 2px; font-weight: 400; } #training-card-content .document-meta { text-align: right; font-size: 8pt; background: rgba(255,255,255,0.15); padding: 6pt 8pt; border-radius: 4px; } #training-card-content .meta-item { display: flex; justify-content: flex-end; gap: 8px; } #training-card-content .meta-label { font-weight: 500; } #training-card-content .employee-section { display: grid; grid-template-columns: auto 1fr; gap: 20pt; margin-bottom: 25pt; background: #f9fafb; padding: 15pt; border-radius: 8px; border: 1px solid #e5e7eb; } #training-card-content .employee-photo { width: 90pt; height: 90pt; background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 9pt; font-weight: 500; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); } #training-card-content .employee-photo img { width: 100%; height: 100%; object-fit: cover; } #training-card-content .employee-details { display: grid; grid-template-columns: 1fr 1fr; gap: 10pt 20pt; } #training-card-content .detail-item { display: flex; align-items: center; } #training-card-content .detail-label { font-weight: 500; min-width: 100pt; color: #4b5563; font-size: 9pt; } #training-card-content .detail-value { font-weight: 500; } #training-card-content .summary-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12pt; margin-bottom: 20pt; } #training-card-content .summary-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12pt; box-shadow: 0 1px 2px rgba(0,0,0,0.05); } #training-card-content .summary-card-title { font-size: 8pt; text-transform: uppercase; letter-spacing: 0.5pt; color: #6b7280; margin-bottom: 6pt; font-weight: 600; } #training-card-content .summary-card-value { font-size: 16pt; font-weight: 700; color: #4f46e5; letter-spacing: -0.5px; } #training-card-content .summary-card-description { font-size: 8pt; color: #9ca3af; margin-top: 2pt; } #training-card-content .section-title { font-size: 12pt; font-weight: 600; color: #111827; margin: 15pt 0 10pt; padding-bottom: 5pt; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; } #training-card-content .section-title svg { margin-right: 8pt; width: 14pt; height: 14pt; color: #4f46e5; } #training-card-content .training-table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 15pt 0; page-break-inside: avoid; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); } #training-card-content .training-table th { background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%); color: white; padding: 10pt 12pt; text-align: left; font-weight: 600; font-size: 9pt; text-transform: uppercase; letter-spacing: 0.5pt; } #training-card-content .training-table th:first-child { border-top-left-radius: 8px; } #training-card-content .training-table th:last-child { border-top-right-radius: 8px; } #training-card-content .training-table td { padding: 12pt; border-bottom: 1px solid #e5e7eb; vertical-align: top; background-color: #ffffff; } #training-card-content .training-table tr:last-child td { border-bottom: none; } #training-card-content .training-topic { font-weight: 600; display: flex; align-items: center; gap: 8pt; } #training-card-content .training-status { display: inline-block; width: 10pt; height: 10pt; border-radius: 50%; background-color: #10b981; flex-shrink: 0; } #training-card-content .training-date { font-weight: 500; white-space: nowrap; } #training-card-content .training-time { color: #6b7280; font-size: 9pt; margin-top: 3pt; } #training-card-content .trainer-info { display: flex; align-items: center; gap: 8pt; } #training-card-content .trainer-avatar { width: 24pt; height: 24pt; border-radius: 50%; background-color: #e0e7ff; display: flex; align-items: center; justify-content: center; color: #4f46e5; font-size: 8pt; font-weight: 600; flex-shrink: 0; } #training-card-content .trainer-details { line-height: 1.4; } #training-card-content .trainer-name { font-weight: 500; } #training-card-content .trainer-title { color: #6b7280; font-size: 8pt; } #training-card-content .status-badge { display: inline-block; padding: 4pt 8pt; border-radius: 20pt; font-size: 8pt; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5pt; } #training-card-content .status-completed { background-color: #ecfdf5; color: #10b981; } #training-card-content .status-container { display: flex; flex-direction: column; align-items: flex-start; gap: 6pt; } #training-card-content .action-links { display: flex; flex-direction: column; align-items: flex-start; gap: 4pt; } #training-card-content .action-link { display: inline-flex; align-items: center; gap: 4pt; font-size: 8pt; color: #6b7280; text-decoration: none; font-weight: 500; transition: color 0.2s; } #training-card-content .action-link:hover { color: #4f46e5; } #training-card-content .action-link svg { width: 11pt; height: 11pt; flex-shrink: 0; color: #9ca3af; transition: color 0.2s; } #training-card-content .action-link:hover svg { color: #4f46e5; } #training-card-content .certificate-badge { display: inline-flex; align-items: center; gap: 4pt; background: linear-gradient(90deg, #10b981 0%, #34d399 100%); color: white; padding: 3pt 8pt 3pt 6pt; border-radius: 20pt; font-size: 8pt; font-weight: 600; margin-left: 8pt; } #training-card-content .signature-section { display: grid; grid-template-columns: 1fr 1fr; gap: 40pt; margin-top: 40pt; page-break-inside: avoid; } #training-card-content .signature-box { height: 40pt; border-bottom: 1px solid #d1d5db; margin-bottom: 8pt; position: relative; } #training-card-content .signature-stamp { position: absolute; right: 0; bottom: -5pt; width: 60pt; opacity: 0.8; } #training-card-content .signature-label { font-size: 9pt; color: #6b7280; text-align: left; margin-bottom: 3pt; } #training-card-content .signature-name { font-weight: 600; text-align: left; margin-top: 3pt; } #training-card-content .signature-details { font-size: 8pt; color: #9ca3af; margin-top: 2pt; } #training-card-content .footer-note { font-size: 8pt; color: #9ca3af; text-align: center; margin-top: 25pt; padding-top: 10pt; border-top: 1px solid #e5e7eb; line-height: 1.6; position: relative; } #training-card-content .watermark { position: fixed; opacity: 0.03; font-size: 72pt; color: #4f46e5; transform: rotate(-30deg); top: 40%; left: 20%; z-index: -1; font-weight: 700; letter-spacing: 2pt; } #training-card-content .qr-code { position: absolute; right: 0; bottom: 0; width: 60pt; height: 60pt; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 4px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #9ca3af; font-size: 6pt; text-align: center; padding: 5pt; box-sizing: border-box; } #training-card-content .qr-code img { width: 40pt; height: 40pt; margin-bottom: 3pt; } `;
                    cardContentEl.innerHTML = ` <div class="watermark">TRAINING RECORD</div><div id="header"><div class="header-content"><div><div class="document-title">EMPLOYEE TRAINING RECORD</div><div class="document-subtitle">Comprehensive training history and certifications</div></div><div class="document-meta"><div class="meta-item"><span class="meta-label">DOC ID:</span><span>TR-151-002246</span></div><div class="meta-item"><span class="meta-label">GENERATED:</span><span>05-Jul-2023</span></div><div class="meta-item"><span class="meta-label">VALID THRU:</span><span>05-Jul-2024</span></div></div></div></div><div class="employee-section"><div class="employee-photo"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iIzRmNDZlNSI+PHBhdGggZD0iTTEyIDJDNi40NzcgMiAyIDYuNDc3IDIgMTJzNC40NzcgMTAgMTAgMTAgMTAtNC40NzcgMTAtMTBTMTcuNTIzIDIgMTIgMnptMCAyYzIuMzIzIDAgNC40MzYuODA0IDYuMDU1IDIuMTQ1TDE3LjA2IDguMDRjLS41NzgtLjU5MS0xLjM0OC0uOTYtMi4yMjQtLjk2aC0uMDFjLTEuOTMzIDAtMy41IDEuNTY3LTMuNSAzLjUgMCAuODc2LjM2OSAxLjY0Ni45NiAyLjIyNGwtMy4xOTUgMy45MDlDNy4xOTYgMTYuNTM2IDYgMTQuNDIzIDYgMTJjMC0zLjMxNCAyLjY4Ni02IDYtNnptLjc3NiA5LjQyNGMuNTkzLjU3MyAxLjM4Ni45MjYgMi4yMjQuOTI2IDEuOTMzIDAgMy41LTEuNTY3IDMuNS0zLjUgMC0uODM4LS4zNTMtMS42MzEtLjkyNi0yLjIyNGwzLjg5NS0zLjg5QzE2LjgwNCA3LjU2NCAxNy44NzcgNyAxOSA3YzIuNzYxIDAgNSAyLjIzOSA1IDUgMCAxLjEyMy0uNTY0IDIuMTk2LTEuNDg2IDIuOTc0bC0zLjg5LTMuODl6TTQgMTJjMCAxLjQ2Ni40ODMgMi44NCAxLjI2OSAzLjg5NWwzLjg5LTMuODljLjU5MS41NzguOTYgMS4zNDguOTYgMi4yMjRDMTAuMTE5IDE2LjY1MyA4LjY1MyAxOCAxMiAxOCAxNS41MjMgMTggMTkgMTQuNjIzIDE5IDEwLjE0VjguNzU3bC02LjMyNCA2LjMyNEMxMy4yNjQgMTUuNjM3IDEyLjQ5NCAxNiAxMS42MTggMTZjLTEuMjUgMC0yLjQxNC0uNTU3LTMuMTk1LTEuNzc2bC0zLjg5IDMuODljLS43ODEtMS4wNTUtMS4yNjktMi40MjktMS4yNjktMy44OTV6Ii8+PC9zdmc+" alt="Employee Photo"></div><div class="employee-details"><div class="detail-item"><div class="detail-label">Employee Name:</div><div class="detail-value">Ganesh Yadav</div></div><div class="detail-item"><div class="detail-label">Employee ID:</div><div class="detail-value">151-002246</div></div><div class="detail-item"><div class="detail-label">Department:</div><div class="detail-value">Engineering</div></div><div class="detail-item"><div class="detail-label">Designation:</div><div class="detail-value">Guest Service Supervisor</div></div><div class="detail-item"><div class="detail-label">Date of Birth:</div><div class="detail-value">01-Jan-1970</div></div><div class="detail-item"><div class="detail-label">Date of Joining:</div><div class="detail-value">01-Jul-2023</div></div><div class="detail-item"><div class="detail-label">Contact Number:</div><div class="detail-value">+91 98765 43210</div></div><div class="detail-item"><div class="detail-label">Email:</div><div class="detail-value">ganesh.yadav@company.com</div></div></div></div><div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>Training Summary</div><div class="summary-cards"><div class="summary-card"><div class="summary-card-title">Total Trainings</div><div class="summary-card-value">5</div><div class="summary-card-description">All completed successfully</div></div><div class="summary-card"><div class="summary-card-title">Training Hours</div><div class="summary-card-value">38h</div><div class="summary-card-description">65% of annual target</div></div><div class="summary-card"><div class="summary-card-title">Certifications</div><div class="summary-card-value">3</div><div class="summary-card-description">Industry recognized</div></div><div class="summary-card"><div class="summary-card-title">Last Training</div><div class="summary-card-value">20-Jun-2023</div><div class="summary-card-description">Advanced First Aid</div></div></div><div class="progress-container"><div class="progress-bar"></div></div><div class="progress-labels"><span>0h</span><span>Annual Target: 60h</span></div><div class="section-title"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>Training History</div><table class="training-table"><thead><tr><th style="width: 35%">Training Program</th><th style="width: 15%">Date</th><th style="width: 10%">Duration</th><th style="width: 25%">Trainer</th><th style="width: 15%">Status</th></tr></thead><tbody><tr class="certificate-row"><td><div class="training-topic"><span class="training-status"></span>FSSAI Certification<span class="certificate-badge"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>CERTIFIED</span></div><div style="font-size: 8pt; color: #6b7280; margin-top: 4pt;">Food Safety and Standards Authority of India</div></td><td><div class="training-date">16-Jan-2023</div><div class="training-time">10:00 AM - 6:00 PM</div></td><td>8h</td><td><div class="trainer-info"><div class="trainer-avatar">PC</div><div class="trainer-details"><div class="trainer-name">Mr. Prem Chand Sharma</div><div class="trainer-title">FSSAI Certified Trainer</div></div></div></td><td><div class="status-container"><div><span class="status-badge status-completed">Completed</span></div><div class="action-links"><a href="#" class="action-link"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.504 3.125A2.25 2.25 0 0013.25 1h-8.5A2.25 2.25 0 002.5 3.25v13.5A2.25 2.25 0 004.75 19h10.5A2.25 2.25 0 0017.5 16.75V7.125A2.25 2.25 0 0015.504 3.125zm-2.13 5.197L9.93 11.765l-1.56-1.56a.75.75 0 00-1.06 1.06l2.09 2.09a.75.75 0 001.06 0l4.03-4.03a.75.75 0 00-1.06-1.06z" clip-rule="evenodd" /></svg>View Certificate</a></div></div></td></tr></tbody></table><div class="signature-section"><div><div class="signature-label">Employee Signature</div><div class="signature-box"></div><div class="signature-name">Ganesh Yadav</div><div class="signature-details">ID: 151-002246 | Date: 05-Jul-2023</div></div><div><div class="signature-label">HR Manager Approval</div><div class="signature-box"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgNTAiIHN0eWxlPSJmb250LWZhbWlseTpBcmlhbDsiPjxwYXRoIGZpbGw9IiNkN2UxZmYiIGQ9Ik0wIDBoMTAwdjUwSDB6Ii8+PHRleHQgeD0iNTAiIHk9IjMwIiBmb250LXNpemU9IjgiIGZpbGw9IiM0ZjQ2ZTUiIGZvbnQtd2VpZ2h0PSJib2xkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5BUFBST1ZFRDwvdGV4dD48L3N2Zz4=" class="signature-stamp" alt="Approved Stamp"></div><div class="signature-name">Priya Sharma</div><div class="signature-details">HR Manager | Training Department</div></div></div><div class="footer-note"><div class="qr-code"><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0yMCAyMGgxMHYxMEgyMHpNNDAgMjBoMTB2MTBINDB6TTIwIDQwaDEwdjEwSDIwek00MCA0MGgxMHYxMEg0MHpNNjAgMjBoMTB2MTBINjB6TTYwIDQwaDEwdjEwSDYwek04MCAyMGgxMHYxMEg4MHpNODAgNDBoMTB2MTBIODB6TTIwIDYwaDEwdjEwSDIwek00MCA2MGgxMHYxMEg0MHpNNjAgNjBoMTB2MTBINjB6TTgwIDYwaDEwdjEwSDgwem0tNjAgMjBoMTB2MTBINjB6IiBmaWxsPSIjMDAwIi8+PC9zdmc+" alt="QR Code">Scan to verify</div>This document is system generated and valid without physical signature.<br>For verification, please contact HR department at hr@company.com or call +91 1800 123 4567<br>© 2023 Company Name. All rights reserved.</div>`;
                    document.getElementById('training-card-modal-overlay').classList.add('active');
                },
                'close-training-card': () => { document.getElementById('training-card-dynamic-styles').textContent = ''; document.getElementById('training-card-modal-overlay').classList.remove('active'); },
                'open-session-history': () => {
                    const employeeNode = findNodeById(state.rawData, employeeId); if (!employeeNode) return;
                    const sessions = Object.values(employeeNode.metrics).flat().filter(m => m.name === metricName);
                    sessions.sort((a, b) => { const dateA = parseDateTime(a.date); const dateB = parseDateTime(b.date); if (!dateB) return -1; if (!dateA) return 1; return dateB - dateA; });
                    const modalTitle = document.getElementById('session-history-title'); const modalBody = document.getElementById('session-history-table-body');
                    modalTitle.textContent = `Session Details for ${employeeNode.name} - ${metricName}`; modalBody.innerHTML = '';
                    if (sessions.length > 0) { sessions.forEach(session => { const sessionDate = parseDateTime(session.date); const formattedDate = sessionDate ? sessionDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : 'Invalid Date'; const certLink = session.certificateUrl ? `<a href="${session.certificateUrl}" target="_blank">View PDF <i class="fas fa-external-link-alt"></i></a>` : 'N/A'; const sheetLink = session.trainingSheetUrl ? `<a href="${session.trainingSheetUrl}" target="_blank">View PDF <i class="fas fa-external-link-alt"></i></a>` : 'N/A'; modalBody.innerHTML += `<tr><td>${formattedDate}</td><td>${certLink}</td><td>${sheetLink}</td></tr>`; }); } else { modalBody.innerHTML = `<tr><td colspan="3" style="text-align: center;">No session history found.</td></tr>`; }
                    document.getElementById('session-history-modal-overlay').classList.add('active');
                },
                'close-session-history': () => document.getElementById('session-history-modal-overlay').classList.remove('active'),
                'toggle-select-dropdown': () => { const p = actionTarget.closest('.custom-select-filter'); const a = p.classList.contains('active'); document.querySelectorAll('.custom-select-filter.active, .custom-date-filter.active').forEach(dd => dd.classList.remove('active')); if (!a) p.classList.add('active'); },
                'refresh': () => init(true),
                'open-topic-filter': () => { populateTopicFilterModal(); document.getElementById('topic-filter-modal-overlay').classList.add('active'); },
                'close-topic-filter': () => document.getElementById('topic-filter-modal-overlay').classList.remove('active'),
                'open-hierarchy-filter': () => { populateHierarchyFilterModal(); document.getElementById('hierarchy-filter-modal-overlay').classList.add('active'); },
                'close-hierarchy-filter': () => document.getElementById('hierarchy-filter-modal-overlay').classList.remove('active'),
                'apply-hierarchy-filter': () => { state.ui.filters.hierarchy.region = Array.from(document.querySelectorAll('#modal-region-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.hierarchy.unit = Array.from(document.querySelectorAll('#modal-unit-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.hierarchy.department = Array.from(document.querySelectorAll('#modal-department-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.hierarchy.role = Array.from(document.querySelectorAll('#modal-role-filter .select-list input:checked')).map(cb => cb.value); document.getElementById('hierarchy-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'clear-hierarchy-filter': () => { state.ui.filters.hierarchy = { region: [], unit: [], department: [], role: [] }; document.getElementById('hierarchy-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'open-period-filter': () => { document.getElementById('filter-training-from').value = state.ui.filters.dateRange.from || ''; document.getElementById('filter-training-to').value = state.ui.filters.dateRange.to || ''; document.getElementById('filter-joining-from').value = state.ui.filters.joiningDateRange.from || ''; document.getElementById('filter-joining-to').value = state.ui.filters.joiningDateRange.to || ''; document.getElementById('period-filter-modal-overlay').classList.add('active'); },
                'close-period-filter': () => { document.getElementById('period-filter-modal-overlay').classList.remove('active'); },
                'clear-period-filter': () => { state.ui.filters.dateRange = { from: null, to: null }; state.ui.filters.joiningDateRange = { from: null, to: null }; document.getElementById('period-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'apply-period-filter': () => { state.ui.filters.dateRange.from = document.getElementById('filter-training-from').value || null; state.ui.filters.dateRange.to = document.getElementById('filter-training-to').value || null; state.ui.filters.joiningDateRange.from = document.getElementById('filter-joining-from').value || null; state.ui.filters.joiningDateRange.to = document.getElementById('filter-joining-to').value || null; document.getElementById('period-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'apply-topic-filter': () => { state.ui.filters.topicFilters.topic = Array.from(document.querySelectorAll('#modal-topic-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.topicFilters.subtopic = Array.from(document.querySelectorAll('#modal-subtopic-filter .select-list input:checked')).map(cb => cb.value); state.ui.filters.topicFilters.proficiency = document.getElementById('filter-proficiency-target').value; document.getElementById('topic-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'clear-topic-filter': () => { state.ui.filters.topicFilters = { topic: [], subtopic: [], proficiency: '' }; document.getElementById('topic-filter-modal-overlay').classList.remove('active'); shouldReprocess = true; },
                'close-verification-modal': () => { document.getElementById('verification-modal-overlay').classList.remove('active'); },
                
                'open-competency-manager': () => {
                    const empId = actionTarget.dataset.employeeId;
                    const metricName = actionTarget.dataset.metricName;
                    const node = findNodeById(state.rawData, empId);
                    const metric = findMetricForEmployee(empId, metricName);
                    const currentScore = metric ? metric.actualCompetency : 0;
                    
                    document.getElementById('verify-employee-name').textContent = node.name;
                    document.getElementById('verify-metric-display').textContent = metricName;
                    document.getElementById('verify-emp-id').value = empId;
                    document.getElementById('verify-metric-name').value = metricName;
                    document.getElementById('verify-new-score-select').value = Math.round(currentScore);
                    document.getElementById('verify-remarks').value = '';
                    document.getElementById('verify-file-upload').value = '';
                    
                    const historyBody = document.getElementById('history-table-body');
                    historyBody.innerHTML = '';
                    
                    if (metric && metric.history && metric.history.length > 0) {
                        [...metric.history].reverse().forEach(h => {
                            let dateStr = 'N/A';
                            try { dateStr = new Date(h.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }); } catch(e){}
                            const evidenceHtml = h.url && h.url !== '#' ? `<a href="#" class="history-evidence-link"><i class="fas fa-file-pdf"></i> ${h.type}</a>` : h.type;
                            historyBody.innerHTML += `<tr><td>${dateStr}</td><td><span class="status-badge active" style="font-size: 0.9em;">${h.score}</span></td><td>${evidenceHtml}</td><td>${h.remarks || '-'}</td></tr>`;
                        });
                    } else { historyBody.innerHTML = '<tr><td colspan="4" style="text-align:center; color:#999;">No history available.</td></tr>'; }
                    document.getElementById('verification-modal-overlay').classList.add('active');
                },
                
                'confirm-verification': () => {
                    const empId = document.getElementById('verify-emp-id').value;
                    const metricName = document.getElementById('verify-metric-name').value;
                    const newScore = parseInt(document.getElementById('verify-new-score-select').value, 10);
                    const remarks = document.getElementById('verify-remarks').value;
                    const type = document.getElementById('verify-evidence-type').value;
                    const fileInput = document.getElementById('verify-file-upload');
                    const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'manual_upload.pdf';
                    
                    const m = findMetricForEmployee(empId, metricName);
                    if (m) {
                        m.actualCompetency = newScore;
                        if (!m.history) m.history = [];
                        m.history.push({ date: new Date().toISOString(), score: newScore, type: type, remarks: remarks || 'Manual Update', url: 'path/to/' + fileName });
                    }
                    document.getElementById('verification-modal-overlay').classList.remove('active');
                    shouldReprocess = true; 
                },

                'open-rubric-modal': () => { document.getElementById('rubric-modal-overlay').classList.add('active'); },
                'close-rubric-modal': () => { document.getElementById('rubric-modal-overlay').classList.remove('active'); }
            };

            if (actions[action]) { actions[action](); }
            if (shouldReprocess) { reprocessAndRender(); } else if (renderOptions.updateTable || renderOptions.updatePagination) { render(renderOptions); }
        }

        // ---------------------------------------------------------------------
        // 🧪 INITIALIZATION HELPERS
        // ---------------------------------------------------------------------
        
        function initFilterEventListeners() {
            document.addEventListener('click', (e) => { if (!e.target.closest('.custom-select-filter, .custom-date-filter')) { document.querySelectorAll('.custom-select-filter.active, .custom-date-filter.active').forEach(dd => dd.classList.remove('active')); } });
            document.body.addEventListener('change', e => {
                const target = e.target;
                if (target.dataset.action === 'filter-change') { if (target.id === 'filter-food-handler') { state.ui.filters.isFoodHandler = target.value; } if (target.id === 'filter-attendance-status') { state.ui.filters.attendanceStatus = target.value; } reprocessAndRender(); return; }
                const customSelect = target.closest('.custom-select-filter');
                if (customSelect && target.type === 'checkbox') {
                    const filterType = customSelect.dataset.filterType;
                    if (Object.keys(state.ui.filters.hierarchy).includes(filterType)) return;
                    const value = target.value; const selectedArray = state.ui.filters[filterType]; if (!selectedArray) return; if (target.checked) { if (!selectedArray.includes(value)) selectedArray.push(value); } else { const index = selectedArray.indexOf(value); if (index > -1) selectedArray.splice(index, 1); } reprocessAndRender();
                }
            });
            document.body.addEventListener('input', e => { if (e.target.classList.contains('select-search')) { const searchTerm = e.target.value.toLowerCase(); const list = e.target.nextElementSibling; list.querySelectorAll('label').forEach(label => { label.style.display = label.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none'; }); } });
        }
        
        function updateButtonLabel(container, selectedItems, placeholder) { const button = container.querySelector('.select-button'); if (selectedItems.length === 0) { button.textContent = placeholder; } else if (selectedItems.length === 1) { button.textContent = selectedItems[0]; } else { button.textContent = `${selectedItems.length} selected`; } }
        
        function populateTopicFilterModal() { 
            const { topic: selectedTopics, subtopic: selectedSubtopics, proficiency } = state.ui.filters.topicFilters; 
            const topicFilter = document.getElementById('modal-topic-filter'); const subtopicFilter = document.getElementById('modal-subtopic-filter');
            const allTopics = Object.keys(state.trainingCatalog); const topicList = topicFilter.querySelector('.select-list'); topicList.innerHTML = ''; 
            allTopics.forEach(topic => { const isChecked = selectedTopics.includes(topic); topicList.innerHTML += `<label><input type="checkbox" value="${topic}" ${isChecked ? 'checked' : ''}><span>${topic}</span></label>`; }); 
            updateButtonLabel(topicFilter, selectedTopics, 'All Topics'); 
            let availableSubtopics = []; 
            if (selectedTopics.length > 0) { availableSubtopics = [...new Set(selectedTopics.flatMap(topic => state.trainingCatalog[topic] || []))]; } else { availableSubtopics = [...new Set(Object.values(state.trainingCatalog).flat())]; } 
            const subtopicList = subtopicFilter.querySelector('.select-list'); subtopicList.innerHTML = ''; 
            availableSubtopics.sort().forEach(subtopic => { const isChecked = selectedSubtopics.includes(subtopic); subtopicList.innerHTML += `<label><input type="checkbox" value="${subtopic}" ${isChecked ? 'checked' : ''}><span>${subtopic}</span></label>`; }); 
            updateButtonLabel(subtopicFilter, selectedSubtopics, 'All Sub-Topics'); 
            document.getElementById('filter-proficiency-target').value = proficiency; 
        }
        
        function initTopicFilterModal() {
            const topicFilter = document.getElementById('modal-topic-filter'); 
            topicFilter.addEventListener('change', e => { if (e.target.type === 'checkbox') { updateSubtopicOptions(); } }); 
            const updateSubtopicOptions = () => {
                const selectedTopics = Array.from(topicFilter.querySelectorAll('.select-list input:checked')).map(cb => cb.value); let availableSubtopics = [];
                if (selectedTopics.length > 0) { availableSubtopics = [...new Set(selectedTopics.flatMap(topic => state.trainingCatalog[topic] || []))]; } else { availableSubtopics = [...new Set(Object.values(state.trainingCatalog).flat())]; }
                const previouslySelectedSubtopics = Array.from(subtopicFilter.querySelectorAll('.select-list input:checked')).map(cb => cb.value); const list = subtopicFilter.querySelector('.select-list'); list.innerHTML = '';
                availableSubtopics.sort().forEach(subtopic => { const isChecked = previouslySelectedSubtopics.includes(subtopic); list.innerHTML += `<label><input type="checkbox" value="${subtopic}" ${isChecked ? 'checked' : ''}><span>${subtopic}</span></label>`; });
                updateButtonLabel(subtopicFilter, previouslySelectedSubtopics, 'All Sub-Topics');
            };
        }
        
        function initHierarchyFilterModal() { 
            const modal = document.getElementById('hierarchy-filter-modal'); 
            modal.addEventListener('change', (e) => { if (e.target.type === 'checkbox') { updateDependentHierarchyFilters(); } }); 
        }
        
        function populateHierarchyFilterModal() { updateDependentHierarchyFilters(true); }
        
        function updateDependentHierarchyFilters(isInitial = false) {
            const { hierarchy } = state.globalFilterOptions;
            const tempFilters = { region: Array.from(document.querySelectorAll('#modal-region-filter input:checked')).map(cb => cb.value), unit: Array.from(document.querySelectorAll('#modal-unit-filter input:checked')).map(cb => cb.value), department: Array.from(document.querySelectorAll('#modal-department-filter input:checked')).map(cb => cb.value), role: Array.from(document.querySelectorAll('#modal-role-filter input:checked')).map(cb => cb.value) };
            if (isInitial) { Object.assign(tempFilters, state.ui.filters.hierarchy); }
            const allEmployees = getAllNodesByType(state.rawData, 'employee');
            const filteredEmployees = allEmployees.filter(emp => {
                const path = getFullPath(emp); const pathInfo = { region: path.find(p => p.type === 'region')?.name, unit: path.find(p => p.type === 'unit')?.name, department: path.find(p => p.type === 'department')?.name };
                if (tempFilters.region.length > 0 && !tempFilters.region.includes(pathInfo.region)) return false; if (tempFilters.unit.length > 0 && !tempFilters.unit.includes(pathInfo.unit)) return false; if (tempFilters.department.length > 0 && !tempFilters.department.includes(pathInfo.department)) return false; return true;
            });
            const available = { region: new Set(isInitial || tempFilters.region.length === 0 ? hierarchy.region : tempFilters.region), unit: new Set(), department: new Set(), role: new Set() };
            (tempFilters.region.length > 0 ? filteredEmployees : allEmployees).forEach(emp => { const path = getFullPath(emp); const unit = path.find(p => p.type === 'unit')?.name; if (unit) available.unit.add(unit); });
            (tempFilters.unit.length > 0 ? filteredEmployees : allEmployees.filter(emp => { const path = getFullPath(emp); const region = path.find(p => p.type === 'region')?.name; return tempFilters.region.length === 0 || tempFilters.region.includes(region); })).forEach(emp => { const path = getFullPath(emp); const department = path.find(p => p.type === 'department')?.name; if (department) available.department.add(department); });
            filteredEmployees.forEach(emp => { available.role.add(emp.role); });
            renderMultiSelect('modal-region-filter', [...available.region].sort(), tempFilters.region, 'All Regions'); renderMultiSelect('modal-unit-filter', [...available.unit].sort(), tempFilters.unit, 'All Units'); renderMultiSelect('modal-department-filter', [...available.department].sort(), tempFilters.department, 'All Departments'); renderMultiSelect('modal-role-filter', [...available.role].sort(), tempFilters.role, 'All Roles');
        }
        
        function renderMultiSelect(containerId, items, selectedItems, placeholder) { const container = document.getElementById(containerId); if (!container) return; const list = container.querySelector('.select-list'); list.innerHTML = ''; items.forEach(item => { const isChecked = selectedItems.includes(item); list.innerHTML += `<label><input type="checkbox" value="${item}" ${isChecked ? 'checked' : ''}><span>${item}</span></label>`; }); updateButtonLabel(container, selectedItems, placeholder); }

        // ---------------------------------------------------------------------
        // 🏁 MAIN INITIALIZATION
        // ---------------------------------------------------------------------

        async function init(isRefresh = false) { 
            const container = document.getElementById('dashboard-container');
            if (container && !isRefresh) {
                 // Show initial loading message before fetch begins
                 container.innerHTML = '<div style="text-align: center; padding: 50px;"><i class="fas fa-spinner fa-spin fa-2x" style="color: var(--level1-color);"></i><p style="margin-top: 15px;">Loading dashboard data...</p></div>';
            }
            
            if (!isRefresh || state.rawData.length === 0) { 
                const realData = await fetchRealData();
                state.rawData = realData;
                
                if (state.rawData.length > 0) {
                    addParentLinksAndHeadcounts(state.rawData[0]);
                } else {
                    // Stop initialization if no data is available
                    render(); 
                    return; 
                }
            }
            
            // Reset filters and UI state
            Object.assign(state.ui, { 
                expandedRows: new Set(), expandedCols: new Set(), 
                pagination: { ...state.ui.pagination, currentPage: 1 }, 
                filters: { employees: [], topicFilters: { topic: [], subtopic: [], proficiency: '' }, dateRange: { from: null, to: null }, joiningDateRange: { from: null, to: null }, isFoodHandler: '', attendanceStatus: '', hierarchy: { region: [], unit: [], department: [], role: [] } } 
            }); 
            
            reprocessAndRender(); 
        }

        document.addEventListener('click', handleAction);
        document.body.addEventListener('change', e => {
            const actionTarget = e.target.closest('[data-action]');
            if (actionTarget && (actionTarget.dataset.action === 'change-rows-per-page' || actionTarget.dataset.action === 'filter-change')) { handleAction(e); }
        });
        
        init();
        initTopicFilterModal();
        initHierarchyFilterModal();
        initFilterEventListeners();
    });
</script>
</body>
</html>