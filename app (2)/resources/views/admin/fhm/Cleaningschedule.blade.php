@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

<meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- PDF Generation Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoVBL5gI9kLmbG0CsdTkrPWMvcHMAnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <style>
        :root {
            --primary-color: #3498db;
            --task-primary-color: #6a0dad;
            --success-color: #27ae60;
            --warning-color: #f39c12; 
            --danger-color: #e74c3c; 
            --info-color: #3498db;   
            --light-color: #f8f9fa;
            --secondary-color: #6c757d;
            --task-light-grey: #f4f4f8;
            --medium-gray: #dee2e6;
            --task-medium-grey: #e0e0e6;
            --dark-gray: #212529;
            --task-dark-grey: #495057;
            --white: #ffffff;
            --neutral-gray: #7f8c8d;
            --card-bg-light: #fdfdfd;
            --card-border-light: #e9ecef;
            --task-card-border-radius: 0.5rem;
            --task-card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --task-text-color: var(--dark-gray);
            --task-secondary-color: var(--success-color);
            --task-pencil-color: #b0bec5;
            --task-pencil-text-color: white;

            --bs-primary: var(--primary-color);
            --bs-secondary: var(--secondary-color);
            --bs-success: var(--success-color);
            --bs-info: var(--info-color); 
            --bs-warning: var(--warning-color);
            --bs-danger: var(--danger-color);
            --bs-light: var(--light-color);
            --bs-dark: var(--dark-gray);

            --global-modal-bg: #ffffff;
            --global-modal-border-color: #dee2e6;
            --global-modal-header-bg: #f8f9fa;
            --global-text-color: #212529;
            --global-label-color: #495057;
            --global-input-border-color: #ced4da;
            --global-button-primary-bg: #28a745; 
            --global-button-secondary-bg: #6c757d; 
            --global-button-light-bg: #f8f9fa;
            --global-button-text-color: #ffffff;
            --global-signature-pad-border: #adb5bd;
            --global-placeholder-color: #adb5bd;

            --mobile-header-tools-height: 60px;
            --mobile-status-filters-height: 42px; 
        }

        html { height: 100%; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0; background-color: var(--bs-light); color: var(--bs-dark);
            line-height: 1.6; min-height: 100%; display: flex; flex-direction: column;
        }
        body.task-view-active { background-color: var(--task-light-grey); }
        .page-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
        .content-container-main { flex-grow: 1; display: flex; flex-direction: column; width: 100%; transition: padding-top 0.3s ease-in-out; }
        
        .header-tools { 
            z-index: 1030; 
            gap: 8px; 
        }
        .search-filter-wrapper { gap: 0.5rem; }
        .search-box-container { position: relative; flex-grow: 1; }
        .search-box { padding: 10px 15px 10px 40px; border: 1px solid var(--medium-gray); border-radius: 6px; font-size: 14px; width: 100%; transition: all 0.3s; }
        .search-box-container .fa-search { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa; }
        .search-box.form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25); }
        .table-container { overflow-x: auto; border-radius: 8px; margin-bottom: 1.5rem; }
        table#cleaningTable { width: 100%; border-collapse: separate; border-spacing: 0; } 

        @media (min-width: 768px) {
            table#cleaningTable { border-spacing: 0 20px; }
            table#cleaningTable thead { display: none; } 
            table#cleaningTable tbody tr:not(.hierarchy-group-header) {
                display: flex; flex-wrap: nowrap; gap: 15px; padding: 15px; border: 1px solid var(--medium-gray);
                border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.07); background-color: var(--bs-light);
            }
            table#cleaningTable tbody tr:not(.hierarchy-group-header):hover { background-color: #eef3f7; box-shadow: 0 6px 12px rgba(0,0,0,0.1); }
            table#cleaningTable td { 
                display: flex; flex-direction: column; flex: 1 1 220px; min-width: 200px;
                background-color: var(--card-bg-light); border: 1px solid var(--card-border-light);
                border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                border-bottom: none; text-align: left; transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
             table#cleaningTable td:not(.mobile-td-wrapper) { }
            table#cleaningTable td:hover:not(.mobile-td-wrapper) { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.08); }
            table#cleaningTable td::before {
                content: attr(data-label); font-weight: 600; display: block; margin-bottom: 10px;
                color: var(--primary-color); font-size: 0.9em; border-bottom: 1px solid var(--medium-gray); padding-bottom: 8px;
            }
            .content-container-main {
                 padding-top: 0 !important;
            }
        }
        
        table#cleaningTable tbody tr { border-left: 5px solid transparent; transition: border-left-color 0.3s ease-in-out; }
        table#cleaningTable tbody tr.task-row-verified { border-left-color: var(--success-color) !important; }
        table#cleaningTable tbody tr.task-row-completed-pending-verification { border-left-color: var(--info-color) !important; }
        table#cleaningTable tbody tr.task-row-ongoing { border-left-color: var(--warning-color) !important; }
        table#cleaningTable tbody tr.task-row-overdue { border-left-color: var(--danger-color) !important; }


        tbody tr.walk-in-chiller-item {
            border-top: 1px solid var(--medium-gray) !important;
            border-right: 1px solid var(--medium-gray) !important;
            border-bottom: 1px solid var(--medium-gray) !important;
            background-color: #fff9f0 !important;
        }
        tbody tr.walk-in-chiller-item.task-row-overdue,
        tbody tr.walk-in-chiller-item.task-row-verified {
            background-color: #fff9f0 !important;
        }

        .scheduled-date-info .date-with-day { font-size: 0.9em; }
        .scheduled-date-info .date-with-day .date-value { font-size: 1.05em; }
        .scheduled-date-info .date-with-day .day-value { text-transform: capitalize; }
        .rescheduled-info { font-size: 0.8em; color: #777; margin-top: 3px; padding-top: 3px; border-top: 1px dashed #eee; }
        .rescheduled-info strong { color: #555; }

        .badge.bg-cleaning-completed, 
        .badge.bg-completed, 
        .badge.bg-verified { background-color: var(--success-color) !important; color: var(--white) !important; }
        
        .badge.bg-verification-due, 
        .badge.bg-verification-pending { background-color: var(--info-color) !important; color: var(--white) !important; }
        
        .badge.bg-ongoing { background-color: var(--warning-color) !important; color: var(--white) !important; } 
        .badge.bg-overdue { background-color: var(--danger-color) !important; color: var(--white) !important; }
        .badge.bg-na { background-color: var(--neutral-gray) !important; color: var(--white) !important; }
        .badge.bg-no-evidence { background-color: var(--bs-secondary) !important; color: var(--white) !important; }

        .evidence-link { color: var(--primary-color); text-decoration: none; display: inline-block; padding: 4px 0; transition: all 0.2s; }
        .evidence-link:hover { text-decoration: underline; color: #2980b9; }

        .checklist-summary { font-size: 0.9em; line-height: 1.5; }
        .checklist-summary .total-line { margin-bottom: 8px; } 
        .checklist-summary .counts-line { display: flex; flex-wrap: wrap; gap: 10px; align-items: baseline; } 
        .checklist-summary .count-item { display: inline-flex; align-items: center; white-space: nowrap; } 
        .checklist-summary .count-label { margin-right: 4px; font-size: 0.95em; color: var(--secondary-color); } 
        .checklist-summary span.count-badge { 
            font-weight: bold; padding: 3px 7px; border-radius: 5px; color: var(--white);
            min-width: 20px; display: inline-block; text-align: center; font-size: 0.9em;
        }
        .checklist-count-total { background-color: var(--primary-color); }
        .checklist-count-yes { background-color: var(--success-color); }
        .checklist-count-no { background-color: var(--danger-color); }
        .checklist-count-na { background-color: var(--neutral-gray); }

        @media (min-width: 768px) {
             .checklist-summary .count-label { font-size: 1em; }
        }

        .action-buttons { display: flex; flex-direction: column; gap: 10px; margin-top: 10px; }
        .action-buttons .btn { width: 100%; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); color: var(--white); }
        .btn-primary:hover { background-color: #2980b9; border-color: #2980b9; }
        .btn-warning { background-color: var(--warning-color); border-color: var(--warning-color); color: var(--white); }
        .btn-warning:hover { background-color: #e67e22; border-color: #e67e22; }
        .btn-info { background-color: var(--info-color); border-color: var(--info-color); color: var(--white); }
        .btn-info:hover { filter: brightness(90%); }
        .btn-outline-info { color: var(--info-color); border-color: var(--info-color); }
        .btn-outline-info:hover { background-color: var(--info-color); color: var(--white); }

        .equipment-details { line-height: 1.5; }
        .equipment-name { font-weight: 600; margin-bottom: 4px; color: #2c3e50; }
        .equipment-meta { font-size: 13px; color: #666; }
        .equipment-meta strong { font-weight: 500; color: #444;}
        .equipment-meta .text-muted {font-size: 0.9em;}
        .completion-section, .verification-section { display: flex; flex-direction: column; gap: 6px; }
        .completion-section > .schedule-status-badge,
        .verification-section > .schedule-status-badge {
            margin-bottom: 5px !important;
            display: block !important;
            width: fit-content !important;
            align-self: flex-start;
        }
        .personnel-info { display: flex; align-items: center; gap: 8px; }
        .avatar { width: 28px; height: 28px; border-radius: 50%; background-color: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold; flex-shrink: 0; }
        .signature { font-family: 'Brush Script MT', cursive; font-size: 17px; color: #555; margin: 5px 0; }
        .signature-panel-container { width: 100%; max-width:400px; margin: 0 auto; }
        .signature-panel { height: 150px; border: 1px dashed var(--global-signature-pad-border); border-radius: 6px; background-color: #fdfdfd; position: relative; touch-action: none; }
        .signature-panel canvas { position: absolute; left: 0; top: 0; width: 100%; height: 100%; cursor: crosshair; }
        .signature-panel-placeholder { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: var(--global-placeholder-color); font-style: italic; pointer-events: none; }
        .signature-actions {text-align: center; margin-top: 10px;}

        .comment { font-size: 13px; color: #666; margin-top: 8px; padding: 8px; background-color: #f5f5f5; border-radius: 6px; border-left: 3px solid var(--primary-color); transition: all 0.3s; white-space: pre-wrap; }
        .comment:hover:not([contenteditable="true"]) { background-color: #ebf5fb; border-left-color: #2980b9; }
        .comment[contenteditable="true"]:hover, .comment[contenteditable="true"]:focus { background-color: #fff !important; box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.3) !important; }
        tbody tr.walk-in-chiller-item td[data-label="Equipment Details"]:not(.mobile-td-wrapper) { background-color: var(--white); }
        tbody tr.walk-in-chiller-item td[data-label="Equipment Details"]:not(.mobile-td-wrapper)::before { display: none; }
        tbody tr.walk-in-chiller-item .equipment-name { font-size: 1.3em; font-weight: bold; text-align: center; width: 100%; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid var(--dark-gray); color: var(--dark-gray); }
        tbody tr.walk-in-chiller-item .equipment-meta { text-align: left; padding-left: 5px; }
        .items-per-page-selector .form-label-sm { font-size: 0.875em; }
        #verificationNeededBtn .badge { font-size: 0.65em; line-height: 1; padding: .25em .4em }
        #advancedFilterToggleBtn .badge { font-size: 0.65em; line-height: 1; padding: .25em .4em }
        .modal-content { border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.15); }
        .form-actions { margin-top: 25px; }
        .toast { box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1100; }
        .dragging { opacity: 0.5; background-color: #eaf2f8; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .dropzone { border: 2px dashed var(--primary-color); background-color: rgba(52, 152, 219, 0.1); }

        .task-page-view-content-wrapper .equipment-info-card { background-color: white; padding: 20px; border-radius: var(--task-card-border-radius); box-shadow: var(--task-card-shadow); margin-bottom: 20px; }
        .task-page-view-content-wrapper .equipment-header { display: flex; align-items: center; margin-bottom: 15px; gap: 15px; }
        .task-page-view-content-wrapper .equipment-header .icon { font-size: 1.6em; color: var(--task-primary-color); }
        .task-page-view-content-wrapper .equipment-header h1 { font-size: 1.5em; margin: 0; color: var(--task-text-color); font-weight: 600; }
        .task-page-view-content-wrapper .status-badge { background-color: var(--task-secondary-color); color: white; padding: 4px 10px; border-radius: 15px; font-size: 0.75em; font-weight: 500; text-transform: uppercase; }
        .task-page-view-content-wrapper .equipment-details .image-placeholder { width: 80px; height: 80px; background-color: #e9ecef; border-radius: var(--task-card-border-radius); display: flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 1.5em; }
        .task-page-view-content-wrapper .detail-item { font-size: 0.85em; min-height: 35px; word-break: break-word;}
        .task-page-view-content-wrapper .detail-item .label { display: block; color: var(--task-dark-grey); font-size: 0.8em; margin-bottom: 2px; display: flex; align-items: center; gap: 4px; }
        .task-page-view-content-wrapper .detail-item .label i { color: var(--task-primary-color); width: 14px; text-align: center; }
        .task-page-view-content-wrapper .detail-item .value { font-weight: 500; }
        .task-page-view-content-wrapper .question-card {
            background-color: white;
            padding: 15px;
            border-radius: var(--task-card-border-radius);
            box-shadow: var(--task-card-shadow);
            margin-bottom: 20px;
            border-left: 5px solid var(--medium-gray);
            position: relative;
            transition: border-left-color 0.3s ease;
        }
        .task-page-view-content-wrapper .question-card.answered-yes { border-left-color: var(--success-color); }
        .task-page-view-content-wrapper .question-card.answered-no { border-left-color: var(--danger-color); }
        .task-page-view-content-wrapper .question-card.answered-na { border-left-color: var(--neutral-gray); }

        .task-page-view-content-wrapper .question-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .task-page-view-content-wrapper .question-text { font-size: 1em; font-weight: 500; flex-grow: 1; padding-right: 100px; }
        .task-page-view-content-wrapper .question-marks { position: absolute; top: 15px; right: 15px; font-size: 0.8em; color: var(--secondary-color); }
        .task-page-view-content-wrapper .question-marks .fa-info-circle { cursor: pointer; }
        
        .task-page-view-content-wrapper .answer-options { display: flex; gap: 8px; margin-bottom: 15px; }
        .task-page-view-content-wrapper .answer-button { flex-grow: 1; padding: 8px 12px; border: 1px solid var(--task-medium-grey); border-radius: 6px; background-color: white; cursor: pointer; text-align: center; font-size: 0.9em; color: var(--task-dark-grey); transition: all 0.2s; }
        .task-page-view-content-wrapper .answer-button:hover { opacity: 0.85; }
        .task-page-view-content-wrapper .answer-button.yes { background-color: white; color: var(--task-secondary-color); border-color: var(--task-secondary-color); }
        .task-page-view-content-wrapper .answer-button.yes.selected, .task-page-view-content-wrapper .answer-button.yes:hover { background-color: var(--task-secondary-color); color: white; }
        .task-page-view-content-wrapper .answer-button.no { background-color: white; color: var(--danger-color); border-color: var(--danger-color); }
        .task-page-view-content-wrapper .answer-button.no.selected, .task-page-view-content-wrapper .answer-button.no:hover { background-color: var(--danger-color); color: white; }
        .task-page-view-content-wrapper .answer-button.na { background-color: white; color: var(--task-pencil-color); border-color: var(--task-pencil-color); }
        .task-page-view-content-wrapper .answer-button.na.selected, .task-page-view-content-wrapper .answer-button.na:hover { background-color: var(--task-pencil-color); color: var(--task-pencil-text-color); }
        .task-page-view-content-wrapper .answer-button.selected { font-weight: bold; }

        .task-page-view-content-wrapper .question-footer { border-top: 1px dashed var(--medium-gray); padding-top: 10px; }
        .task-page-view-content-wrapper .question-actions { display: flex; gap: 15px; font-size: 0.85em; }
        .task-page-view-content-wrapper .question-actions a { color: var(--primary-color); cursor: pointer; text-decoration: none; }
        .task-page-view-content-wrapper .question-actions a:hover { text-decoration: underline; }
        .task-page-view-content-wrapper .question-comment-area { display: none; margin-top: 10px; }
        .task-page-view-content-wrapper .question-comment-area textarea { width: 100%; font-size: 0.9em; }

        .task-page-view-content-wrapper .media-display-area, .task-page-view-content-wrapper .notes-display-area { background-color: white; padding: 15px; border-radius: var(--task-card-border-radius); box-shadow: var(--task-card-shadow); margin-bottom: 15px; }
        .task-page-view-content-wrapper .media-display-area h3, .task-page-view-content-wrapper .notes-display-area h3 { margin-top: 0; margin-bottom: 10px; font-size: 1em; color: var(--task-dark-grey); font-weight: 600; }
        .task-page-view-content-wrapper .media-grid { display: flex; flex-wrap: wrap; gap: 10px; }
        .task-page-view-content-wrapper .media-item { position: relative; width: 70px; height: 70px; background-color: var(--task-medium-grey); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.7em; overflow: hidden; }
        .task-page-view-content-wrapper .media-item i { font-size: 1.3em; color: var(--task-dark-grey); }
        .task-page-view-content-wrapper .media-item .remove-media-btn { position: absolute; top: 1px; right: 1px; background-color: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 18px; height: 18px; font-size: 0.6em; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .task-page-view-content-wrapper .note-item { background-color: #f9f9f9; padding: 8px; border-radius: 4px; margin-bottom: 6px; font-size: 0.85em; border: 1px solid #eee; display: flex; justify-content: space-between; align-items: flex-start; }
        .task-page-view-content-wrapper .note-item p { margin: 0; white-space: pre-wrap; }
        .task-page-view-content-wrapper .note-actions button { background: none; border: none; color: var(--task-primary-color); cursor: pointer; font-size: 0.85em; margin-left: 6px; }
        .task-page-view-content-wrapper .notes-input-area { background-color: white; padding: 15px; border-radius: var(--task-card-border-radius); box-shadow: var(--task-card-shadow); margin-bottom: 15px; display: none; }
        .task-page-view-content-wrapper .notes-input-area textarea { min-height: 70px; font-size: 0.9em; margin-bottom: 8px; }
        .task-page-view-content-wrapper .actions-bar { background-color: white; padding: 12px 15px; border-radius: var(--task-card-border-radius); box-shadow: var(--task-card-shadow); margin-bottom: 20px; display: flex; gap: 15px; align-items: center; border-left: 4px solid var(--task-primary-color); }
        .task-page-view-content-wrapper .action-item { color: var(--task-primary-color); cursor: pointer; font-size: 0.9em; display: inline-flex; align-items: center; gap: 6px; }
        .task-page-view-content-wrapper .action-item:hover { text-decoration: underline; }
        .task-page-view-content-wrapper .submission-area { text-align: center; margin-top: 25px; }
        .task-page-view-content-wrapper .complete-button { padding: 10px 25px; font-size: 0.95em; }

        .global-verify-modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5); display: none; justify-content: center;
            align-items: center; z-index: 1090; /* Highest priority for global verification */
        }
        .global-verify-modal-container {
            background-color: var(--global-modal-bg); border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15); width: 100%; max-width: 600px;
            overflow: hidden; border: 1px solid var(--global-modal-border-color);
        }
        .global-verify-modal-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 20px; background-color: var(--global-modal-header-bg);
            border-bottom: 1px solid var(--global-modal-border-color);
        }
        .global-verify-modal-title {
            font-size: 1.25em; font-weight: 500; color: var(--global-text-color);
            display: flex; align-items: center; gap: 8px;
        }
        .global-verify-modal-title .fa-user-check { color: var(--global-text-color); }
        .global-verify-modal-close-btn {
            background: none; border: none; font-size: 1.5em;
            color: var(--global-label-color); cursor: pointer;
        }
        .global-verify-modal-body { padding: 20px; max-height: 70vh; overflow-y: auto; }
        .global-verify-modal-body .info-section {
            background-color: #f8f9fa; padding: 12px 15px; border-radius: 6px;
            margin-bottom: 20px; border: 1px solid #e9ecef;
        }
        .global-verify-modal-body .info-section p { margin: 5px 0; font-size: 0.95em; color: var(--global-text-color); }
        .global-verify-modal-body .info-section strong { font-weight: 500; }
        .global-verify-modal-body .form-group { margin-bottom: 20px; }
        .global-verify-modal-body .form-group label {
            display: block; margin-bottom: 8px; font-size: 0.9em;
            font-weight: 500; color: var(--global-label-color);
        }
        .global-verify-modal-body .form-group textarea {
            width: 100%; box-sizing: border-box; min-height: 100px; padding: 10px 12px;
            border: 1px solid var(--global-input-border-color); border-radius: 6px;
            font-family: inherit; font-size: 1em; resize: vertical;
        }
        .global-verify-modal-body .form-group textarea:focus {
            outline: none; border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .global-verify-modal-footer {
            padding: 15px 20px; background-color: var(--global-modal-header-bg);
            border-top: 1px solid var(--global-modal-border-color); display: flex;
            justify-content: flex-end; gap: 10px;
        }
        .global-verify-modal-footer button {
            padding: 10px 20px; border: none; border-radius: 6px; font-size: 0.95em;
            font-weight: 500; cursor: pointer;
        }
        .global-verify-modal-footer .btn-cancel {
            background-color: var(--global-button-secondary-bg); color: var(--global-button-text-color);
        }
        .global-verify-modal-footer .btn-cancel:hover { background-color: #5a6268; }
        .global-verify-modal-footer .btn-complete {
            background-color: var(--global-button-primary-bg); color: var(--global-button-text-color);
            display: flex; align-items: center; gap: 8px;
        }
        .global-verify-modal-footer .btn-complete:hover { background-color: #218838; }

        /* Styles for Verification Modal Review Content */
        #globalModalReviewContent {
            border-top: 1px solid var(--global-modal-border-color);
            border-bottom: 1px solid var(--global-modal-border-color);
            padding-top: 15px;
            padding-bottom: 5px;
            background-color: #fdfdfd;
        }
        #globalModalReviewContent .review-section {
            margin-bottom: 20px;
        }
        #globalModalReviewContent .review-section-header {
            font-size: 1.05em;
            font-weight: 600;
            color: var(--global-text-color);
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 8px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        #globalModalReviewContent .personnel-info-block .personnel-info { display: flex; align-items: center; gap: 8px; }
        #globalModalReviewContent .personnel-info-block .avatar { width: 32px; height: 32px; font-size: 14px; }
        #globalModalReviewContent .personnel-info-block .name { font-weight: bold; }
        #globalModalReviewContent .personnel-info-block .date { color: var(--global-label-color); font-size: 0.9em; }
        #globalModalReviewContent .signature-review-img { max-width: 180px; height: auto; display: block; margin-top: 10px; border: 1px solid #ddd; border-radius: 4px; }
        #globalModalReviewContent .comment-review { font-size: 0.95em; margin-top: 10px; padding: 10px; background-color: #f0f4f8; border-radius: 4px; border-left: 3px solid var(--primary-color); white-space: pre-wrap; word-break: break-word; }

        #globalModalReviewContent .evidence-grid { display: flex; flex-wrap: wrap; gap: 10px; }
        #globalModalReviewContent .evidence-item a { text-decoration: none; color: var(--primary-color); text-align: center; }
        #globalModalReviewContent .evidence-item i { font-size: 2em; }
        #globalModalReviewContent .evidence-item-placeholder { font-style: italic; color: var(--global-label-color); }


        .verification-section .form-check { margin-top: 10px !important; }
        .modal-info-section { background-color: #f8f9fa; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e9ecef; }
        .modal-info-section p { margin: 5px 0; font-size: 0.95em; color: var(--global-text-color); }
        .modal-info-section strong { font-weight: 500; }


        .mobile-task-card-view {
            background-color: var(--white); border-radius: 8px; padding: 15px;
            width: 100%; text-align: left;
        }
        .mobile-equipment-name {
            color: var(--task-dark-grey); font-size: 1.1em; font-weight: 600;
            border-bottom: 1px solid var(--medium-gray); padding-bottom: 10px;
            margin-bottom: 12px; text-align: left; display: flex;
            align-items: center; gap: 8px;
        }
        .mobile-equipment-name i { color: var(--primary-color); margin-right: 0; flex-shrink: 0; }
        .mobile-top-info {
            display: flex; justify-content: space-between; align-items: flex-start;
            margin-bottom: 12px; gap: 10px;
        }
        .mobile-top-info .mobile-info-col {}
        .mobile-top-info .mobile-info-col.text-end { text-align: right; }
        .mobile-top-info .mobile-detail-item { font-size: 0.9em; margin-bottom: 5px; line-height: 1.4; }
        .mobile-top-info .mobile-detail-item .mobile-label {
            color: var(--secondary-color); display: block; font-size: 0.8em; margin-bottom: 2px;
        }
        .mobile-top-info .mobile-detail-item .mobile-value { font-weight: 500; color: var(--task-dark-grey); }
        .mobile-top-info .mobile-detail-item .mobile-value small { font-size: 0.85em; }

        .mobile-top-info .mobile-info-col.text-end .mobile-detail-item.status-value {
            display: flex; flex-direction: column; align-items: flex-end;
        }
        .mobile-top-info .mobile-detail-item.status-value .mobile-value {
            font-size: 1em; padding: 3px 8px; border-radius: 4px; color: white !important;
            margin-top: 2px; display: inline-block; text-align: center;
        }
        .mobile-section { padding-top: 12px; margin-bottom: 12px; }
        .mobile-section:not(:first-of-type):not(.mobile-details-collapsible > .mobile-section:first-of-type) {
             border-top: 1px dashed var(--medium-gray);
         }
        .mobile-section-header {
            font-size: 0.8em; font-weight: 600; color: var(--secondary-color);
            margin-bottom: 8px; text-transform: uppercase; text-align: left;
        }
        .mobile-section .personnel-info-block { margin-bottom: 8px; }
        .mobile-section .personnel-info-block .d-flex.align-items-center {
            margin-bottom: 4px; justify-content: flex-start;
        }
        .mobile-section .personnel-info-block .mobile-detail-item {
            font-size: 0.9em; text-align: left; margin-bottom: 4px;
        }
        .mobile-section .personnel-info-block .mobile-detail-item .mobile-label {
            color: var(--secondary-color); display: block; font-size: 0.8em;
        }
        .mobile-section .personnel-info-block .mobile-detail-item .mobile-value { font-weight: 500; }
        .mobile-section .mobile-signature-img {
            max-width: 150px; height: auto; border: 1px solid var(--light-color);
            display: block; margin-top: 4px; margin-bottom: 8px; border-radius: 3px;
        }
         .mobile-section .signature-placeholder-text {
            font-style: italic; color: var(--secondary-color); font-size: 0.9em;
            display: block; margin-top: 4px; margin-bottom: 8px; text-align: left;
        }
        .mobile-section .mobile-comment {
            font-size: 0.85em; color: var(--task-dark-grey); white-space: pre-wrap;
            background-color: #f9f9f9; padding: 10px; border-radius: 4px;
            border-left: 3px solid var(--primary-color); margin-top: 4px; text-align: left;
            word-break: break-word;
        }
        .mobile-evidence-images-container {
            display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; justify-content: flex-start;
        }
        .mobile-evidence-img {
            width: 70px; height: 70px; object-fit: cover; border-radius: 4px;
            border: 1px solid var(--medium-gray);
        }
        .mobile-evidence-img.placeholder {
            background-color: var(--light-color); display: flex; align-items: center;
            justify-content: center; font-size: 0.8em; color: var(--secondary-color); text-align: center;
        }
        .mobile-evidence-img.placeholder span { display: block; }
        .mobile-evidence-images-container .evidence-link i { font-size: 1.5em; }
        .mobile-actions-footer {
             display: flex; 
             justify-content: flex-start; 
             flex-wrap: wrap; 
             gap: 10px; margin-top: 15px;
             padding-top: 15px; border-top: 1px solid var(--medium-gray);
        }
        .mobile-actions-footer .btn { 
            flex-grow: 1; flex-basis: 0; text-align: center;
            min-width: calc(50% - 5px); 
        }
        .mobile-actions-footer .mobile-task-selection { 
            width: 100%; 
            order: -1; 
            margin-bottom: 10px; 
            background-color: transparent;
            border: none;
            padding: 0 !important;
        }

        .mobile-actions-footer .btn-outline-secondary { 
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .mobile-actions-footer .btn-outline-secondary:hover {
            background-color: var(--secondary-color);
            color: var(--white);
        }
         .mobile-actions-footer .btn-outline-info {
            color: var(--info-color);
            border-color: var(--info-color);
        }
        .mobile-actions-footer .btn-outline-info:hover {
            background-color: var(--info-color);
            color: var(--white);
        }
        .mobile-actions-footer .btn-outline-warning {
            color: var(--warning-color);
            border-color: var(--warning-color);
        }
        .mobile-actions-footer .btn-outline-warning:hover {
            background-color: var(--warning-color);
            color: var(--white);
        }


        .mobile-verification-action,
        .mobile-attend-action {
            text-align: center; padding-top: 12px; margin-top: 12px;
            border-top: 1px dashed var(--medium-gray);
        }
        .mobile-verification-action .btn,
        .mobile-attend-action .btn { width: auto; padding-left: 20px; padding-right: 20px; }

        .mobile-task-selection {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }
        .mobile-task-selection .form-check-input {
            width: 1.3em;
            height: 1.3em;
            margin-top: 0.1em;
            cursor: pointer;
        }
        .mobile-task-selection .form-check-label {
            font-size: 0.9em;
            font-weight: 500;
            color: var(--primary-color);
            margin-left: 0.5em;
            cursor: pointer;
        }


        .mobile-schedule-indicator-text {
            display: inline-block; padding: 4px 8px; border-radius: 16px; line-height: 1.3;
            transition: all 0.2s ease-in-out; font-weight: 500; margin-top: 2px;
            border: 1px solid transparent; text-align: center; font-size: 0.85em;
            width: 100%; box-sizing: border-box;
        }
        .mobile-schedule-indicator-text.status-verified { 
            background-color: var(--success-color) !important; color: white !important;
            padding: 6px 8px; border-radius: 50px; border: 1px solid var(--success-color) !important;
        }
        .mobile-schedule-indicator-text.status-cleaning-completed { 
            border: 1px solid var(--info-color) !important; background-color: #e3f2fd !important;
            color: var(--info-color) !important;
        }
        .mobile-schedule-indicator-text.status-ongoing { 
            border: 1px solid var(--warning-color) !important; background-color: #fff8e1 !important; 
            color: #795548 !important; 
        }
        .mobile-schedule-indicator-text.status-overdue { 
            border: 1px solid var(--danger-color) !important; background-color: #ffebee !important; 
            color: var(--danger-color) !important;
        }
         .mobile-top-info .mobile-rescheduled-info {
            font-size: 0.8em; color: #777; margin-top: 2px;
        }
        .mobile-top-info .mobile-rescheduled-info strong { color: #555; }


        .mobile-details-toggle-btn {
            display: block; width: 100%; text-align: center; padding: 8px 10px;
            margin-top: 10px; margin-bottom: 10px; font-size: 0.85em; font-weight: 500;
            color: var(--primary-color); background-color: var(--bs-light);
            border: 1px solid var(--medium-gray); border-radius: 6px; cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .mobile-details-toggle-btn:hover { background-color: #e9ecef; }
        .mobile-details-toggle-btn .toggle-icon { margin-left: 8px; transition: transform 0.3s ease; }
        .mobile-details-toggle-btn.expanded .toggle-icon { transform: rotate(180deg); }

        .mobile-details-collapsible {
            display: none; overflow: hidden; transition: max-height 0.3s ease-out; max-height: 0;
        }
        .mobile-details-collapsible.show { display: block; max-height: 2000px; }
        .mobile-details-collapsible > .mobile-section { margin-top: 0; padding-top: 12px; }
        .mobile-details-collapsible > .mobile-section:first-of-type { border-top: 1px dashed var(--medium-gray); }
        .mobile-details-collapsible > .mobile-section:not(:first-of-type) { border-top: 1px dashed var(--medium-gray); }

        /* Z-index management to prevent modal clashes */
        #addScheduleModal, #verificationModal, #taskAttendModal, 
        #assignTaskModal, #rescheduleTaskModal, #accessFilterModal, 
        #advancedFilterModal, #viewChecklistModal, #viewHistoryModal {
            z-index: 1060;
        }

        #taskMediaGalleryModalInModal { 
            z-index: 1080; 
        }
        
        .assign-personnel-list { max-height: 250px; overflow-y: auto; border: 1px solid var(--medium-gray); border-radius: 0.25rem; padding: 0.5rem; }
        .assign-personnel-list .list-group-item { padding: 0.5rem 0.75rem; border: none; border-bottom: 1px solid var(--light-color); cursor: pointer; }
        .assign-personnel-list .list-group-item:last-child { border-bottom: none; }
        .assign-personnel-list .list-group-item:hover { background-color: var(--bs-light); }
        .assign-personnel-list .form-check-input { margin-top: 0.2em; }
        .assignment-history-container { margin-top: 20px; padding-top: 15px; border-top: 1px solid var(--medium-gray); }
        .assignment-history-container h6 { font-size: 0.95em; color: var(--secondary-color); margin-bottom: 10px; }
        .assignment-history-list { list-style-type: none; padding-left: 0; max-height: 150px; overflow-y: auto; font-size: 0.85em;}
        .assignment-history-list li { padding: 6px 0; border-bottom: 1px dashed var(--light-color); }
        .assignment-history-list li:last-child { border-bottom: none; }
        .assignment-history-list .log-timestamp { color: var(--secondary-color); font-size: 0.9em; display: block; }
        .assignment-history-list .log-details {}

        /* BUGFIX: Merged the two media query blocks into one for cleaner code */
        @media (max-width: 767.98px) {
            .content-container-main {
                border-radius: 0 !important;
                box-shadow: none !important;
                padding-top: calc(var(--mobile-header-tools-height) + var(--mobile-status-filters-height)) !important;
            }
            .header-tools {
                position: fixed !important; 
                top: 0;
                left: 0;
                right: 0;
                height: var(--mobile-header-tools-height);
                z-index: 1031 !important; 
                background-color: var(--white);
                padding: 0.5rem 0.75rem !important; 
                margin-bottom: 0 !important;
                box-shadow: 0 1px 3px rgba(0,0,0,0.12);
                display: flex !important; 
                align-items: center !important;
                box-sizing: border-box;
            }
            .header-tools .search-filter-wrapper {
                width: 100%;
                flex-wrap: nowrap; 
            }
            .header-tools .search-box-container { min-width: 100px; } 
            .header-tools .search-box { font-size: 0.8rem; padding-top: 0.4rem; padding-bottom: 0.4rem; } 
            .header-tools .btn { font-size: 0.65rem; padding: 0.25rem 0.4rem; white-space: nowrap; } 
            .header-tools #verificationNeededBtn .badge { font-size: 0.6em; top: 2px; right: -5px; } 

            #mainScheduleView {
                padding-top: 0 !important;
            }

            #mobileStatusFilters { 
                position: fixed !important; 
                top: var(--mobile-header-tools-height); 
                left: 0;
                right: 0;
                z-index: 1030;
                background-color: var(--white);
                padding: 0.35rem 0.75rem !important; 
                margin-bottom: 0 !important;
                border-bottom: 1px solid var(--medium-gray);
                height: var(--mobile-status-filters-height);
                box-sizing: border-box;
                display: flex !important;
                overflow-x: auto !important;
                overflow-y: hidden;
                gap: 0.5rem; 
                -webkit-overflow-scrolling: touch; 
                scrollbar-width: none; 
            }
            #mobileStatusFilters::-webkit-scrollbar { display: none; }
            #mobileStatusFilters .btn {
                white-space: nowrap; 
                flex-shrink: 0; 
                border-radius: 15px; 
                font-size: 0.75rem; 
                padding: 0.2rem 0.6rem; 
                display: inline-flex; 
                align-items: center;
                gap: 4px; 
            }
            #mobileStatusFilters .btn .count-badge-status { 
                background-color: var(--secondary-color); 
                color: white;
                font-size: 0.7em;
                padding: 0.1em 0.4em;
                border-radius: 0.25rem;
                line-height: 1;
                min-width: 16px; 
                text-align: center;
            }
            #mobileStatusFilters .btn.active .count-badge-status { 
                background-color: var(--white);
                color: var(--primary-color);
            }
            #mobileStatusFilters .btn.active {
                background-color: var(--primary-color);
                color: white;
                border-color: var(--primary-color);
                font-weight: 500;
            }

            table#cleaningTable tbody tr {
                display: block; margin-bottom: 15px;
                border: 1px solid var(--medium-gray); border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.07); background-color: var(--bs-light);
                padding: 0; 
            }
            table#cleaningTable td.mobile-td-wrapper { 
                display: block !important; padding: 0 !important; border: none !important;
                background-color: transparent !important; box-shadow: none !important; width: 100%;
            }
            table#cleaningTable td[data-label]:not(.mobile-td-wrapper) { display: none !important; }

            .mobile-actions-placeholder { display: none !important; }
            .mobile-section .row { display: block; }
            .mobile-section .row > [class^="col-"] {
                width: 100%; padding-left: 0; padding-right: 0;
                text-align: left !important; margin-bottom: 8px;
            }
            .mobile-section .row > [class^="col-"]:last-child { margin-bottom: 0; }
            #taskAttendModal .modal-dialog, #assignTaskModal .modal-dialog, #accessFilterModal .modal-dialog, #advancedFilterModal .modal-dialog, #rescheduleTaskModal .modal-dialog { max-width: 95%; margin: 1.75rem auto; }
            .task-page-view-content-wrapper .equipment-details .image-placeholder { margin: 0 auto 15px auto; }
            .task-page-view-content-wrapper .answer-options { flex-direction: column; }
            .task-page-view-content-wrapper .answer-button { margin-bottom: 5px; }
            .task-page-view-content-wrapper .actions-bar { flex-direction: column; align-items: flex-start; gap: 10px;}
            .global-verify-modal-body .info-section p,
            .global-verify-modal-body .form-group label { text-align: left; }

            .mobile-section .checklist-summary { padding-left: 0; } 
            .mobile-section .checklist-summary .counts-line { gap: 8px; } 
            .mobile-section .checklist-summary span.count-badge { padding: 2px 6px; font-size: 0.85em;}

            .chart-container-wrapper {
                padding: 0;
            }
            .chart-container {
               padding: 10px;
            }
            .chart-title {
               font-size: 20px;
               margin-bottom: 15px;
            }
            .bar {
               width: 20px;
               margin: 0 5px;
            }
            .x-axis-region-name { font-size: 14px; }
            .x-axis-months { font-size: 12px; }
            .legend { flex-direction: column; align-items: center; gap: 5px; }
            .x-axis-labels { flex-direction: column; padding-left: 0; }
            .x-axis-region { border-right: none; border-bottom: 1px solid #dee2e6; padding-bottom: 10px; margin-bottom: 5px; }
            .x-axis-region:last-child { border-bottom: none; margin-bottom: 0; }
        }

        /* Hierarchical Filter Dropdown Styling */
        #hierarchicalAccessFilterSelect optgroup {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        #hierarchicalAccessFilterSelect option {
            padding-left: 15px;
        }
        #hierarchicalAccessFilterSelect option.corporate-option {
             font-style: italic;
        }
        #hierarchicalAccessFilterSelect option.regional-option {
            padding-left: 25px; 
        }
        #hierarchicalAccessFilterSelect option.unit-option {
            padding-left: 35px; 
        }

        /* Shared Checklist Modal Styles */
        #globalModalReviewContent .checklist-item,
        #viewChecklistModal .checklist-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        #globalModalReviewContent .checklist-item-question,
        #viewChecklistModal .checklist-item-question {
            font-weight: bold;
            margin-bottom: 8px;
        }
        #globalModalReviewContent .checklist-item-answer,
        #viewChecklistModal .checklist-item-answer {
            margin-bottom: 8px;
        }
        #globalModalReviewContent .checklist-item-answer .badge,
        #viewChecklistModal .checklist-item-answer .badge {
            font-size: 0.9em;
        }
        #globalModalReviewContent .checklist-item-comment,
        #viewChecklistModal .checklist-item-comment {
            font-size: 0.9em;
            color: #555;
            background-color: #eef;
            padding: 5px;
            border-radius: 3px;
            white-space: pre-wrap;
            margin-top: 8px;
        }

        /* --- STYLES FOR DYNAMIC HISTORY MODAL --- */
        #viewHistoryModal .modal-body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb; /* --bg-page */
            color: #4b5563; /* --text-secondary */
            padding: 2rem;
        }
        #viewHistoryModal .history-page-wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }
        #viewHistoryModal .icon-sm { width: 20px; height: 20px; }
        #viewHistoryModal .icon-md { width: 24px; height: 24px; }
        #viewHistoryModal .icon-lg { width: 28px; height: 28px; }

        #viewHistoryModal .equipment-container { display: flex; flex-direction: column; gap: 1.5rem; }
        #viewHistoryModal .equipment-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        #viewHistoryModal .breadcrumbs { font-size: 14px; color: #6b7280; }
        #viewHistoryModal .breadcrumbs span { margin: 0 0.5rem; }
        #viewHistoryModal .breadcrumbs a { color: #4b5563; text-decoration: none; transition: color 0.2s; }
        #viewHistoryModal .breadcrumbs a:hover { color: #4f46e5; }
        #viewHistoryModal .title-group { display: flex; align-items: center; gap: 1rem; }
        #viewHistoryModal .title-group h1 { font-size: 30px; font-weight: 700; color: #111827; margin: 0; }
        #viewHistoryModal .status-badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-weight: 500; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; }
        #viewHistoryModal .status-badge.active { background-color: #e7f8f3; color: #10b981; }
        #viewHistoryModal .action-button { display: inline-flex; align-items: center; gap: 8px; background-color: #4f46e5; color: #ffffff; border: none; border-radius: 8px; padding: 10px 16px; font-family: inherit; font-size: 14px; font-weight: 500; cursor: pointer; transition: background-color 0.2s; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
        #viewHistoryModal .action-button:hover { background-color: #4338ca; }
        #viewHistoryModal .details-card { background-color: #ffffff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); border: 1px solid #e5e7eb; display: flex; align-items: flex-start; gap: 2.5rem; }
        #viewHistoryModal .image-placeholder { width: 140px; height: 140px; background-color: #f3f4f6; border-radius: 8px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; border: 1px solid #e5e7eb; }
        #viewHistoryModal .image-placeholder .icon-lg { color: #6b7280; }
        #viewHistoryModal .info-grid { flex-grow: 1; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem 1.5rem; }
        #viewHistoryModal .info-item { display: flex; align-items: flex-start; gap: 12px; }
        #viewHistoryModal .info-item .icon-sm { flex-shrink: 0; color: #4f46e5; margin-top: 2px; }
        #viewHistoryModal .info-item .text-content { display: flex; flex-direction: column; }
        #viewHistoryModal .info-item .label { font-size: 13px; color: #6b7280; margin-bottom: 2px; }
        #viewHistoryModal .info-item .value { font-size: 15px; font-weight: 500; color: #111827; }

        #viewHistoryModal .schedule-container { width: 100%; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); border: 1px solid #e5e7eb; overflow: hidden; }
        #viewHistoryModal .schedule-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid #e5e7eb; }
        #viewHistoryModal .schedule-title { display: flex; align-items: center; gap: 12px; }
        #viewHistoryModal .schedule-title .icon-md { color: #4f46e5; }
        #viewHistoryModal .schedule-title h2 { font-size: 18px; font-weight: 600; color: #111827; margin: 0; }
        #viewHistoryModal .schedule-filter select { font-family: inherit; font-size: 14px; padding: 6px 10px; border: 1px solid #e5e7eb; border-radius: 6px; background-color: #ffffff; color: #4b5563; }
        #viewHistoryModal .schedule-table { width: 100%; border-collapse: collapse; }
        #viewHistoryModal .schedule-table thead th { text-align: left; padding: 12px 24px; font-size: 12px; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; background-color: #f3f4f6; }
        #viewHistoryModal .schedule-table tbody tr { transition: background-color 0.15s ease-in-out; }
        #viewHistoryModal .schedule-table tbody tr:hover { background-color: #f9fafb; }
        #viewHistoryModal .schedule-table tbody td { padding: 16px 24px; font-size: 14px; color: #4b5563; vertical-align: top; border-bottom: 1px solid #e5e7eb; }
        #viewHistoryModal .schedule-table tbody tr:last-child td { border-bottom: none; }
        #viewHistoryModal .schedule-table .cell-main-text { color: #111827; font-weight: 500; margin-bottom: 4px; }
        #viewHistoryModal .status-badge.completed { background-color: #e7f8f3; color: #10b981; }
        #viewHistoryModal .verification-details { display: flex; flex-direction: column; gap: 8px; }
        #viewHistoryModal .verification-comment { font-size: 13px; font-style: italic; color: #6b7280; max-width: 250px; border-left: 3px solid #e5e7eb; padding-left: 12px; }
        #viewHistoryModal .view-checklist-btn { display: inline-flex; align-items: center; gap: 6px; background-color: #ffffff; color: #4b5563; border: 1px solid #e5e7eb; border-radius: 6px; padding: 6px 12px; font-size: 13px; font-weight: 500; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
        #viewHistoryModal .view-checklist-btn:hover { background-color: #f3f4f6; border-color: #d1d5db; color: #111827; }
        #viewHistoryModal .view-checklist-btn .icon-sm { color: #6b7280; transition: color 0.2s; }
        #viewHistoryModal .view-checklist-btn:hover .icon-sm { color: #4b5563; }
        
        /* Advanced Filter Dropdown with Checkboxes */
        .filter-dropdown-container {
            position: relative;
            width: 100%;
        }
        .filter-dropdown-toggle {
            width: 100%;
            text-align: left;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .375rem .75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-dropdown-toggle::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            border: none;
            margin-left: 0.5em;
        }
        .filter-dropdown-toggle .badge {
            background-color: var(--primary-color);
        }

        .filter-dropdown-panel {
            display: none;
            position: absolute;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
            z-index: 1070; /* Above modal content, below modal header */
            padding: 0.5rem;
            margin-top: 0.25rem;
        }
        .filter-dropdown-panel.show {
            display: block;
        }
        .filter-dropdown-search {
            width: 100%;
            padding: .375rem .75rem;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            margin-bottom: 0.5rem;
        }
        .filter-options-list {
            max-height: 150px;
            overflow-y: auto;
            padding: 0;
            margin: 0;
        }
        .filter-option-item {
            display: block;
            padding: .25rem .5rem;
        }
        .filter-option-item:hover {
            background-color: #f8f9fa;
        }

       /* --- CHART STYLES --- */
        .chart-container-wrapper {
            margin-bottom: 2rem;
            padding: 0; /* Task 2: Full width */
        }
        .chart-container {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 25px 30px;
            max-width: 100%; /* Task 2: Full width */
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }
        .chart-title {
            text-align: center;
            font-size: 28px;
            color: #495057;
            margin-bottom: 25px;
        }
        .chart-area {
            display: flex;
            height: 300px;
            border-bottom: 1px solid #adb5bd;
            position: relative; /* For positioning average labels */
        }
        .y-axis {
            display: flex;
            flex-direction: column-reverse;
            justify-content: space-between;
            padding-right: 15px;
            height: 280px;
            color: #6c757d;
            font-size: 14px;
            text-align: right;
            position: relative;
            top: -10px;
        }
        .chart-main {
            width: 100%;
            position: relative;
            border-left: 1px solid #ced4da;
        }
        .grid-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 280px;
            display: flex;
            flex-direction: column-reverse;
            justify-content: space-between;
        }
        .grid-line {
            width: 100%;
            height: 1px;
            background-color: #e9ecef;
        }
        .bars-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            height: 100%;
            padding: 0 15px;
            align-items: flex-end;
            position: relative;
            z-index: 1;
        }
        .bar {
            display: flex;
            flex-direction: column-reverse;
            width: 45px;
            margin: 0 15px;
        }
        .bar-segment {
            transition: opacity 0.2s ease;
            position: relative; /* For label positioning */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .bar-segment:hover { opacity: 0.85; }
        .bar-segment.completed { background-color: #2b5d73; }
        .bar-segment.overdue { background-color: #e87a33; }
        .bar-segment.ongoing { background-color: #1e6a45; }
        
        /* Task 1: Style for data labels on bars */
        .bar-segment .data-label {
            color: white;
            font-weight: 600;
            font-size: 12px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }

        .x-axis-labels {
            display: flex;
            padding-left: 55px; /* Aligns with chart-main content */
            justify-content: space-around;
        }
        .x-axis-region {
            flex-basis: 0;
            flex-grow: 1;
            text-align: center;
            padding: 5px 0;
            border-right: 2px solid #e0e0e6;
        }
        .x-axis-region:last-child {
            border-right: none;
        }
        .x-axis-months {
            display: flex;
            justify-content: space-around;
            font-size: 14px;
            color: #495057;
            padding: 0 10px;
            margin-top: 4px; /* Space between corp name and months */
        }
        .x-axis-region-name {
            font-size: 16px;
            font-weight: 600; /* Bolder corporate name */
            color: #343a40;
            margin-top: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #f0f0f0; /* Subtle line under corp name */
        }
        .bars-container-group {
            flex-basis: 0;
            flex-grow: 1;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 100%;
        }
        .legend {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin: 0 15px;
            font-size: 14px;
            color: #495057;
        }
        .legend-color {
            width: 14px;
            height: 14px;
            margin-right: 8px;
        }
        
        /* Task 1: Styles for right-side Y-axis average labels */
        .y-axis-right {
            position: relative;
            height: 280px; /* Match grid height */
            top: -10px; /* Align with left axis */
            width: 100px; /* Give it some space */
            text-align: left;
        }
        .avg-label {
            position: absolute;
            transform: translateY(-50%);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            border-left: 2px solid;
            padding-left: 8px;
            margin-left: 8px;
        }

        @media (max-width: 900px) {
             .chart-container {
                padding: 15px;
             }
             .bar {
                width: 30px;
                margin: 0 10px;
             }
             .x-axis-labels {
                padding-left: 45px;
             }
        }
        
        /* --- NEW HIERARCHY STYLES --- */
        @media (max-width: 767.98px) {
            tr.hierarchy-group-header {
                border-left: none !important; /* Override other border styles */
            }
            tr.hierarchy-group-header td {
               background-color: #f0f2f5;
               padding: 0.75rem;
               font-weight: bold;
               border-left: 5px solid var(--primary-color);
               border-radius: 0;
               box-shadow: none;
            }
        }
        @media (min-width: 768px) {
            tr.hierarchy-group-header {
                display: block;
                width: 100%;
                margin-top: 2rem;
                margin-bottom: 1rem;
                padding: 0;
                background: transparent !important;
                box-shadow: none !important;
                border: none !important;
                border-left-color: transparent !important;
            }
            tr.hierarchy-group-header:first-child {
                margin-top: 0;
            }
             tr.hierarchy-group-header:hover {
                background: transparent !important;
            }
            tr.hierarchy-group-header td {
                display: block;
                width: 100%;
                padding: 0;
                border: none;
                border-bottom: 2px solid var(--medium-gray);
                padding-bottom: 0.5rem;
                background: transparent !important;
                box-shadow: none !important;
                color: var(--dark-gray);
                font-size: 1.5rem;
                font-weight: 600;
            }
            tr.hierarchy-group-header td::before {
                display: none !important;
            }
        }
tr.hierarchy-group-header {
    display: none;
}

    </style>
@section('content')


<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto" id="toastTitle">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">Default toast message.</div>
        </div>
    </div>

    <div class="page-wrapper container-fluid px-0 px-md-3 py-md-3">
        <div class="header-tools d-flex justify-content-between align-items-center mb-md-4 p-3 bg-white shadow-sm">
            <div class="search-filter-wrapper d-flex align-items-center flex-grow-1">
                <div class="search-box-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="mainSearchBox" class="form-control search-box" placeholder="Search equipment or location...">
                </div>
                <button class="btn btn-outline-primary btn-sm flex-shrink-0 ms-2" id="accessFilterBtn" type="button" title="Change Access View"><i class="fas fa-sitemap"></i> <span class="d-none d-sm-inline">View As</span></button>
                <button class="btn btn-primary btn-sm flex-shrink-0 ms-1" id="advancedFilterToggleBtn" type="button" title="Advanced Filters">
                    <i class="fas fa-filter"></i> <span class="d-none d-sm-inline">Filter</span>
                    <span class="badge bg-info ms-1" id="advFilterCountBadge" style="display: none;">0</span>
                </button>
                <button class="btn btn-outline-info btn-sm flex-shrink-0 position-relative ms-1" id="verificationNeededBtn" type="button" title="Tasks Awaiting Verification">
                    <i class="fas fa-user-check"></i> <span id="verificationNeededBtnText" class="d-none d-sm-inline">Verify</span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="verificationNeededCount">
                        0 <span class="visually-hidden">tasks needing verification</span>
                    </span>
                </button>
                 <button class="btn btn-outline-secondary btn-sm flex-shrink-0 ms-1" id="refreshBtn" type="button" title="Refresh Data">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm flex-shrink-0 ms-1" id="downloadReportBtn" type="button" title="Download Report">
                    <i class="fas fa-download"></i>
                </button>
                <button class="btn btn-outline-warning btn-sm flex-shrink-0 ms-1" id="simulateRemindersBtn" type="button" title="Simulate Weekly Reminders">
                    <i class="fas fa-bell"></i> <span class="d-none d-sm-inline">Reminders</span>
                </button>
            </div>
        </div>

        <div class="content-container-main bg-white p-md-4 rounded-3 shadow">
            
            <div id="mainScheduleView" class="px-0 mt-4"> 

                <div class="chart-container-wrapper">
                    <!-- NEW CONTROLS START -->
                    <div class="d-flex justify-content-center align-items-center gap-3 mb-3 flex-wrap" id="timelineControls">
                        <div class="form-group d-flex align-items-center">
                            <label for="timePeriodSelect" class="form-label me-2 mb-0">View:</label>
                            <select id="timePeriodSelect" class="form-select form-select-sm" style="width: auto;">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly" selected>Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="form-group d-flex align-items-center">
                             <label for="timeRangeInput" class="form-label me-2 mb-0">Show Last:</label>
                             <input type="number" id="timeRangeInput" class="form-control form-control-sm" value="2" min="1" max="52" style="width: 70px;">
                             <span id="timeRangeLabel" class="ms-2">Months</span>
                        </div>
                        <button id="updateTimelineBtn" class="btn btn-sm btn-primary">Update</button>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary" id="downloadPngBtn" title="Download as PNG"><i class="fas fa-file-image"></i> PNG</button>
                            <button class="btn btn-sm btn-outline-secondary" id="downloadPdfBtn" title="Download as PDF"><i class="fas fa-file-pdf"></i> PDF</button>
                        </div>
                    </div>
                    <!-- NEW CONTROLS END -->

                    <div class="chart-container" id="chartToDownload">
                        <h2 class="chart-title">Cleaning Schedule Timeline</h2>
                        <div class="chart-area">
                            <div class="y-axis">
                                <!-- Y-axis labels generated by JS -->
                            </div>
                            <div class="chart-main">
                                <div class="grid-lines">
                                    <div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div><div class="grid-line"></div>
                                </div>
                                <div class="bars-container">
                                    <!-- Bars are now generated by JavaScript -->
                                </div>
                                <canvas id="lineChartCanvas" style="position: absolute; top: 0; left: 0; right: 0; z-index: 2; pointer-events: none;"></canvas>
                            </div>
                            <div class="y-axis y-axis-right">
                                <!-- Right Y-axis labels for averages generated by JS -->
                            </div>
                        </div>
                
                        <div class="x-axis-labels">
                           <!-- X-Axis labels are now generated by JavaScript -->
                        </div>
                        
                        <div class="legend">
                            <!-- Legend items generated by JS -->
                        </div>
                    </div>
                </div>

                <div id="mobileStatusFilters" class="d-flex overflow-auto py-2 px-1 mb-2 d-md-none">
                    <button class="btn btn-sm btn-outline-secondary active" data-status-filter="all">All <span class="count-badge-status d-none" id="count-all"></span></button>
                    <button class="btn btn-sm btn-outline-secondary" data-status-filter="ongoing">Ongoing <span class="count-badge-status d-none" id="count-ongoing"></span></button>
                    <button class="btn btn-sm btn-outline-secondary" data-status-filter="overdue">Overdue <span class="count-badge-status d-none" id="count-overdue"></span></button>
                    <button class="btn btn-sm btn-outline-secondary" data-status-filter="completed">Completed <span class="count-badge-status d-none" id="count-completed"></span></button>
                    <button class="btn btn-sm btn-outline-secondary" data-status-filter="verified">Verified <span class="count-badge-status d-none" id="count-verified"></span></button>
                </div>

                <div class="table-container">
                    <table id="cleaningTable">
                        <tbody>
                            <tr id="no-data-message" style="display: none;">
                                <td colspan="6" style="text-align: center; padding: 40px; font-style: italic; color: var(--secondary-color);">
                                    No cleaning schedule data available.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center mt-auto pt-3 gap-md-3">
                    <div class="items-per-page-selector order-md-first mb-2 mb-md-0 me-md-3">
                        <label for="itemsPerPage" class="form-label-sm me-1">Show:</label>
                        <select class="form-select form-select-sm d-inline-block" id="itemsPerPage" style="width: auto;">
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select>
                        <span class="ms-1">entries</span>
                    </div>
                    <nav aria-label="Cleaning schedule pages" class="order-md-last">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-angle-double-left"></i></a></li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Add Schedule Modal -->
            <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="modalTitleLabel" aria-hidden="true"> <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="modalTitleLabel"><i class="fas fa-calendar-plus"></i> Add New Cleaning Schedule</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body"> <form id="scheduleForm"> <div class="mb-3"> <label class="form-label" for="equipment"><i class="fas fa-cogs"></i> Equipment</label> <select id="equipment" class="form-select" required> <option value="">Select Equipment</option> <option value="centrifuge">Centrifuge Model X-200</option> <option value="microscope">Microscope Model M-400</option> <option value="autoclave">Autoclave Unit A-150</option> <option value="biosafety">Biosafety Cabinet BSC-1200</option> <option value="chiller">Walk in Chiller</option> </select> </div> <div class="mb-3"> <label class="form-label" id="scheduleDateLabel" for="scheduleDate"><i class="fas fa-calendar-day"></i> Scheduled Date</label> <input type="date" id="scheduleDate" class="form-control" required> </div> <div class="mb-3"> <label class="form-label" for="frequency"><i class="fas fa-redo"></i> Cleaning Frequency</label> <select id="frequency" class="form-select" required> <option value="daily">Daily</option> <option value="weekly">Weekly</option> <option value="biweekly">Bi-weekly (14 days)</option> <option value="monthly">Monthly</option> <option value="quarterly">Quarterly (90 days)</option> </select> </div> <div class="mb-3 form-group-hidden" id="totalCheckPointsGroup"> <label class="form-label" for="totalCheckPoints"><i class="fas fa-list-ol"></i> Total Check Points</label> <input type="number" id="totalCheckPoints" class="form-control" min="1" placeholder="Enter total number of check points" required> </div> <div class="mb-3 form-group-hidden" id="checklistDetailsGroup"> <label class="form-label" for="checklistDetails"><i class="fas fa-tasks"></i> Checklist Details / Notes</label> <textarea id="checklistDetails" class="form-control" rows="3" placeholder="Describe the checklist items..."></textarea> </div> <div class="mb-3"> <label class="form-label" for="assignedToRole"><i class="fas fa-user-tag"></i> Assigned To (Role/Group)</label> <select id="assignedToRole" class="form-select" required> <option value="">Select Role/Group</option> </select> </div> <div class="mb-3"> <label class="form-label" for="notes"><i class="fas fa-sticky-note"></i> Additional Notes</label> <textarea id="notes" class="form-control" rows="3"></textarea> </div> </form> </div> <div class="modal-footer form-actions"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button> <button type="submit" form="scheduleForm" class="btn btn-primary"><i class="fas fa-save"></i> Save Schedule</button> </div> </div> </div> </div>
            <!-- Verification Modal -->
            <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="verificationModalLabel"><i class="fas fa-user-check"></i> Verify Cleaning Task</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body"> <form id="verificationForm"> <input type="hidden" id="verificationTaskId"> <div class="mb-3 p-2 bg-light border rounded"> <strong>Equipment:</strong> <span id="verifyEqName" class="fw-bold"></span><br> <strong>Scheduled:</strong> <span id="verifyEqScheduledDate"></span> </div> <div class="mb-3"> <label for="verificationNotes" class="form-label">Verification Notes/Comments:</label> <textarea class="form-control" id="verificationNotes" rows="3"></textarea> </div> <div class="mb-3"> <label class="form-label">Verifier Signature:</label> <div class="signature-panel-container"> <div class="signature-panel" id="verifierSignaturePanel"> <canvas id="verifierSignatureCanvas"></canvas> <span id="verifierSignaturePlaceholder" class="signature-panel-placeholder">Sign Here</span> </div> </div> <div class="text-center mt-2"> <button type="button" class="btn btn-sm btn-outline-secondary" id="clearVerifierSignatureBtn">Clear Signature</button> </div> </div> </form> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <button type="button" class="btn btn-success" id="completeVerificationBtn"><i class="fas fa-check-double"></i> Verification Complete</button> </div> </div> </div> </div>
            <!-- Task Attend Modal -->
            <div class="modal fade" id="taskAttendModal" tabindex="-1" aria-labelledby="taskAttendModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskAttendModalLabel">Attend Cleaning Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="taskAttendModalCloseBtn"></button>
                        </div>
                        <div class="modal-body p-0"> 
                            <div class="task-page-view-content-wrapper p-3">
                                <section class="equipment-info-card">
                                    <div class="equipment-header">
                                        <span class="icon" id="modalTaskEqIcon"><i class="fas fa-cogs"></i></span>
                                        <h1 id="modalTaskEqName" class="h5">Equipment Name</h1>
                                        <span class="status-badge" id="modalTaskEqStatus">Status</span>
                                    </div>
                                    <div class="equipment-details">
                                        <div class="row">
                                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                                <div class="image-placeholder mx-auto" id="modalTaskEqImage"><i class="fas fa-image"></i></div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-sm-6 col-lg-4 detail-item"><span class="label"><i class="fas fa-tag"></i> Equipment ID</span><span class="value" id="modalTaskEqId">--</span></div>
                                                    <div class="col-sm-6 col-lg-4 detail-item"><span class="label"><i class="fas fa-industry"></i> Make/Brand</span><span class="value" id="modalTaskEqMake">--</span></div>
                                                    <div class="col-sm-6 col-lg-4 detail-item"><span class="label"><i class="fas fa-map-marker-alt"></i> Location</span><span class="value" id="modalTaskEqLocation">--</span></div>
                                                    <div class="col-sm-6 col-lg-4 detail-item"><span class="label"><i class="fas fa-calendar-alt"></i> Installation Date</span><span class="value" id="modalTaskEqInstallDate">--</span></div>
                                                    <div class="col-sm-6 col-lg-4 detail-item">
                                                        <span class="label" id="modalTaskScheduledDateLabel"><i class="fas fa-calendar-check"></i> Scheduled Date</span>
                                                        <span class="value" id="modalTaskEqScheduleDate">--</span>
                                                    </div>
                                                    <div class="col-sm-6 col-lg-4 detail-item"><span class="label"><i class="fas fa-user-tag"></i> Assigned To</span><span class="value" id="modalTaskEqResponsibility">--</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="question-card-container" id="modalQuestionCardContainer"></div>
                                <section class="media-display-area" id="modalMediaDisplayArea" style="display: none;">
                                    <h3>Attached Media</h3> <div class="media-grid" id="modalMediaGrid"></div>
                                </section>
                                <section class="notes-display-area" id="modalNotesDisplayArea" style="display: none;">
                                    <h3>Notes</h3> <div id="modalNotesList"></div>
                                </section>
                                <section class="notes-input-area" id="modalNotesInputArea">
                                    <textarea id="modalNoteTextarea" class="form-control" placeholder="Enter your note..."></textarea>
                                    <input type="hidden" id="modalEditingNoteIndex" value="-1">
                                    <button class="btn btn-sm btn-primary mt-2 save-note-btn" id="modalSaveNoteBtn">Save Note</button>
                                </section>
                                <section class="actions-bar">
                                    <span class="action-item" id="modalAddNoteAction"><i class="fas fa-pencil-alt"></i> Add note</span>
                                    <!--<span class="action-item" id="modalAttachMediaAction"><i class="fas fa-paperclip"></i> Attach media</span>-->
                                </section>
                                <section class="submission-area">
                                   <label class="form-label">Technician Signature:</label>
                                   <div class="signature-panel-container">
                                        <div class="signature-panel" id="modalSignaturePanel">
                                            <canvas id="modalSignatureCanvas"></canvas> 
                                            <span id="modalSignaturePlaceholder" class="signature-panel-placeholder">Sign Here</span>
                                        </div>
                                    </div>
                                    <div class="signature-actions">
                                        <button class="btn btn-sm btn-outline-secondary clear-sig-btn" id="modalClearSignatureBtn">Clear</button>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalTaskCancelBtn">Cancel</button>
                            <button type="button" class="btn btn-success complete-button" id="modalCompleteTaskBtn">Complete Task</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Task Media Gallery Modal (nested) -->
            <div class="modal fade" id="taskMediaGalleryModalInModal" tabindex="-1" aria-labelledby="taskMediaGalleryModalInModalLabel" aria-hidden="true">
                 <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskMediaGalleryModalInModalLabel">Media Gallery (for Task)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Select or capture media. Maximum 5 items.</p>
                            <div class="gallery-actions d-flex gap-2 mb-3">
                                <button id="modalTaskTakePhotoBtn" type="button" class="btn btn-primary"><i class="fas fa-camera"></i> Take Photo</button>
                                <button id="modalTaskTakeVideoBtn" type="button" class="btn btn-primary"><i class="fas fa-video"></i> Take Video</button>
                            </div>
                            <p class="media-upload-limit" id="modalTaskMediaUploadLimitText">0 of 5 items selected.</p>
                            <div class="media-grid mb-3" id="modalTaskModalMediaPreviewGrid"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" id="modalTaskSaveMediaFromModalBtn" type="button">Done</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Assign Task Modal -->
            <div class="modal fade" id="assignTaskModal" tabindex="-1" aria-labelledby="assignTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignTaskModalLabel"><i class="fas fa-user-plus"></i> Assign Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-info-section">
                                <p><strong>Equipment:</strong> <span id="modalAssignEqName"></span></p>
                                <p><strong>ID:</strong> <span id="modalAssignEqId"></span></p>
                                <p><strong>Location:</strong> <span id="modalAssignEqLocation"></span></p>
                                <p><strong>Current Role/Group:</strong> <span id="modalAssignCurrentRole"></span></p>
                            </div>
                            <div class="mb-3">
                                <label for="assignSearchInput" class="form-label">Search and Select Personnel (from current role/group):</label>
                                <input type="text" class="form-control mb-2" id="assignSearchInput" placeholder="Type to search...">
                                <div id="assignPersonnelList" class="list-group assign-personnel-list">
                                </div>
                                <div id="noPersonnelMessage" class="text-muted mt-2" style="display: none;">No personnel found for this role or matching your search.</div>
                            </div>
                            <div class="assignment-history-container mt-3">
                                <h6><i class="fas fa-history"></i> Assignment History</h6>
                                <ul id="assignmentHistoryList" class="assignment-history-list">
                                </ul>
                                <p id="noAssignmentHistoryMessage" class="text-muted small" style="display: none;">No assignment history for this task.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="sendAssignmentBtn"><i class="fas fa-paper-plane"></i> Send Assignment</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reschedule Task Modal -->
            <div class="modal fade" id="rescheduleTaskModal" tabindex="-1" aria-labelledby="rescheduleTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rescheduleTaskModalLabel"><i class="fas fa-calendar-alt"></i> Reschedule Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="rescheduleForm">
                                <input type="hidden" id="rescheduleTaskId">
                                <div class="modal-info-section">
                                    <p><strong>Equipment:</strong> <span id="rescheduleEqName"></span></p>
                                    <p><strong>Current Schedule Date:</strong> <span id="rescheduleCurrentDate"></span></p>
                                </div>
                                <div class="mb-3">
                                    <label for="rescheduleNewDate" class="form-label"><strong>1. Select New Schedule Date</strong></label>
                                    <input type="date" class="form-control" id="rescheduleNewDate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rescheduleNotes" class="form-label"><strong>2. Reason for Rescheduling</strong></label>
                                    <textarea class="form-control" id="rescheduleNotes" rows="3" placeholder="A reason is required to proceed..." required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveRescheduleBtn">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access Filter Modal (View As) -->
            <div class="modal fade" id="accessFilterModal" tabindex="-1" aria-labelledby="accessFilterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="accessFilterModalLabel"><i class="fas fa-sitemap"></i> Select User Role / View</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="hierarchicalAccessFilterSelect" class="form-label">Select View:</label>
                                <select class="form-select" id="hierarchicalAccessFilterSelect" size="10">
                                    <!-- Options populated by JS -->
                                </select>
                            </div>
                            <p class="small text-muted">This simulates role-based access. Real security is backend-enforced.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="applyAccessFilterBtn">Apply View</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Filter Modal -->
            <div class="modal fade" id="advancedFilterModal" tabindex="-1" aria-labelledby="advancedFilterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="advancedFilterModalLabel"><i class="fas fa-filter"></i> Advanced Filters</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Corporate:</label>
                                    <div class="filter-dropdown-container" id="advFilterCorporateContainer">
                                        <button type="button" class="filter-dropdown-toggle">
                                            <span>All Corporates</span>
                                            <span class="badge">0</span>
                                        </button>
                                        <div class="filter-dropdown-panel">
                                            <input type="text" class="filter-dropdown-search" placeholder="Search Corporates...">
                                            <div class="filter-options-list"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region:</label>
                                    <div class="filter-dropdown-container" id="advFilterRegionContainer">
                                        <button type="button" class="filter-dropdown-toggle">
                                            <span>All Regions</span>
                                            <span class="badge">0</span>
                                        </button>
                                        <div class="filter-dropdown-panel">
                                            <input type="text" class="filter-dropdown-search" placeholder="Search Regions...">
                                            <div class="filter-options-list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit:</label>
                                    <div class="filter-dropdown-container" id="advFilterUnitContainer">
                                        <button type="button" class="filter-dropdown-toggle">
                                            <span>All Units</span>
                                            <span class="badge">0</span>
                                        </button>
                                        <div class="filter-dropdown-panel">
                                            <input type="text" class="filter-dropdown-search" placeholder="Search Units...">
                                            <div class="filter-options-list"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department:</label>
                                    <div class="filter-dropdown-container" id="advFilterDepartmentContainer">
                                        <button type="button" class="filter-dropdown-toggle">
                                            <span>All Departments</span>
                                            <span class="badge">0</span>
                                        </button>
                                        <div class="filter-dropdown-panel">
                                            <input type="text" class="filter-dropdown-search" placeholder="Search Departments...">
                                            <div class="filter-options-list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Equipment:</label>
                                    <div class="filter-dropdown-container" id="advFilterEquipmentContainer">
                                        <button type="button" class="filter-dropdown-toggle">
                                            <span>All Equipment</span>
                                            <span class="badge">0</span>
                                        </button>
                                        <div class="filter-dropdown-panel">
                                            <input type="text" class="filter-dropdown-search" placeholder="Search Equipment...">
                                            <div class="filter-options-list"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cleaning Status:</label>
                                    <div class="filter-dropdown-container" id="advFilterStatusContainer">
                                        <button type="button" class="filter-dropdown-toggle">
                                            <span>All Statuses</span>
                                            <span class="badge">0</span>
                                        </button>
                                        <div class="filter-dropdown-panel">
                                            <input type="text" class="filter-dropdown-search" placeholder="Search Statuses...">
                                            <div class="filter-options-list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top mt-2 pt-3">
                                <div class="col-md-6 mb-3">
                                    <label for="advFilterFromDate" class="form-label">Filter by Scheduled Date (From):</label>
                                    <input type="date" class="form-control" id="advFilterFromDate">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="advFilterToDate" class="form-label">Filter by Scheduled Date (To):</label>
                                    <input type="date" class="form-control" id="advFilterToDate">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" id="resetAdvancedFiltersBtn">Reset Filters</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="applyAdvancedFiltersBtn">Apply Filters</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Checklist Modal -->
            <div class="modal fade" id="viewChecklistModal" tabindex="-1" aria-labelledby="viewChecklistModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewChecklistModalLabel">Completed Checklist Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="viewChecklistModalBody">
                            <!-- Checklist content will be injected here by JS -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View History Modal -->
            <div class="modal fade" id="viewHistoryModal" tabindex="-1" aria-labelledby="viewHistoryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen-xl-down modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewHistoryModalLabel">Equipment Cleaning History</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="history-page-wrapper">
                                <!-- Equipment Details Component -->
                                <div class="equipment-container">
                                    <header class="equipment-header">
                                        <div>
                                             <nav class="breadcrumbs" id="historyBreadcrumbs">
                                                <!-- Dynamic breadcrumbs -->
                                            </nav>
                                            <div class="title-group">
                                                <h1 id="historyEquipmentName">Equipment Name</h1>
                                                <span class="status-badge active">Active</span>
                                            </div>
                                        </div>
                                        <button class="action-button" id="downloadHistoryPdfBtn" data-equipment-id="">
                                            <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                            Download Report
                                        </button>
                                    </header>
                            
                                    <div class="details-card">
                                        <div class="image-placeholder">
                                            <i class="fas fa-image fa-3x text-muted" id="historyEquipmentIcon"></i>
                                        </div>
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h13.5m-13.5 7.5h13.5m-1.5-13.5l-3.375 3.375m-1.5-1.5L12 3m5.25 5.25l-3.375 3.375M3 19.5h18a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3A1.5 1.5 0 001.5 6v12a1.5 1.5 0 001.5 1.5z" /></svg>
                                                <div class="text-content">
                                                    <span class="label">Equipment ID</span>
                                                    <span class="value" id="historyEquipmentID">--</span>
                                                </div>
                                            </div>
                                             <div class="info-item">
                                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6M9 12h6m-6 5.25h6M3.75 6.75h.008v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM20.25 6.75h.008v.008h-.008V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                                <div class="text-content">
                                                    <span class="label">Make/Brand</span>
                                                    <span class="value" id="historyEquipmentMake">--</span>
                                                </div>
                                            </div>
                                             <div class="info-item">
                                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                                <div class="text-content">
                                                    <span class="label">Location</span>
                                                    <span class="value" id="historyEquipmentLocation">--</span>
                                                </div>
                                            </div>
                                             <div class="info-item">
                                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 12.75h.008v.008H12v-.008z" /></svg>
                                                <div class="text-content">
                                                    <span class="label">Installation Date</span>
                                                    <span class="value" id="historyEquipmentInstallDate">--</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Cleaning Schedule Component -->
                                <div class="schedule-container">
                                    <header class="schedule-header">
                                        <div class="schedule-title">
                                            <svg class="icon-md" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.998 15.998 0 011.622-3.385m5.043.025a15.998 15.998 0 001.622-3.385m3.388 1.62a15.998 15.998 0 00-1.622-3.385m-5.043.025a15.998 15.998 0 01-3.388-1.621m7.744 4.24a15.998 15.998 0 00-3.388-1.622m-5.043.025a15.998 15.998 0 01-1.622-3.385m-3.388 1.621a15.998 15.998 0 011.622-3.385m5.043.025a15.998 15.998 0 013.388 1.622m-7.744-4.242a15.998 15.998 0 003.388 1.622m5.043-.025a15.998 15.998 0 00-1.622 3.385m-3.388-1.622a15.998 15.998 0 00-1.622 3.385" /></svg>
                                            <h2>Cleaning Schedule</h2>
                                        </div>
                                        <div class="schedule-filter">
                                            <select name="time-filter" id="time-filter">
                                                <option value="all-time">All Time</option>
                                                <option value="last-7-days">Last 7 Days</option>
                                                <option value="last-30-days">Last 30 Days</option>
                                            </select>
                                        </div>
                                    </header>
                            
                                    <table class="schedule-table">
                                        <thead>
                                            <tr>
                                                <th>Scheduled</th>
                                                <th>Cleaning</th>
                                                <th>Status</th>
                                                <th>Verification</th>
                                                <th>Checklist</th>
                                            </tr>
                                        </thead>
                                        <tbody id="historyScheduleTableBody">
                                            <!-- Dynamic history rows will be injected here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="global-verify-modal-overlay" id="globalVerifyTaskModalOverlay">
        <div class="global-verify-modal-container" id="globalVerifyTaskModalContainer">
            <div class="global-verify-modal-header">
                <h2 class="global-verify-modal-title"><i class="fas fa-user-check"></i> Verify Cleaning Task</h2>
                <button class="global-verify-modal-close-btn" id="globalModalCloseBtn" aria-label="Close modal">×</button>
            </div>
            <div class="global-verify-modal-body">
                <div class="modal-info-section">
                    <p><strong>Equipment:</strong> <span id="globalModalVerifyEqName"></span></p>
                    <p><strong>Scheduled:</strong> <span id="globalModalVerifyEqScheduledDate"></span></p>
                </div>

                <div id="globalModalReviewContent" class="mb-4">
                    <!-- Dynamic content will be injected here -->
                </div>

                <div class="form-group">
                    <label for="globalModalVerificationNotes">Verification Notes/Comments:</label>
                    <textarea id="globalModalVerificationNotes" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="globalModalVerifierSignatureCanvas">Verifier Signature:</label>
                     <div class="signature-panel-container">
                        <div class="signature-panel" id="globalModalSignaturePadContainer">
                            <canvas id="globalModalVerifierSignatureCanvas"></canvas>
                            <span class="signature-panel-placeholder" id="globalModalSignaturePlaceholderText">Sign Here</span>
                        </div>
                    </div>
                    <div class="signature-actions">
                        <button class="btn btn-sm btn-outline-secondary" id="globalModalClearVerifierSignatureBtn">Clear Signature</button>
                    </div>
                </div>
            </div>
            <div class="global-verify-modal-footer">
                <button class="btn-cancel" id="globalModalCancelVerificationBtn">Cancel</button>
                <button class="btn-complete" id="globalModalCompleteVerificationBtn">
                    <i class="fas fa-check-circle"></i> Verification Complete
                </button>
            </div>
        </div>
    </div>
@endsection


@section('footerscript')

   <script>
        // Make jspdf available in the global scope
        window.jspdf = window.jspdf;

        let addScheduleModalInstance, verificationModalInstance, liveToastInstance, 
            taskAttendModalInstance, taskAttend_mediaGalleryModalInstance, 
            assignTaskModalInstance, accessFilterModalInstance, advancedFilterModalInstance,
            rescheduleModalInstance, viewChecklistModalInstance, viewHistoryModalInstance;

        let verifierSignaturePad, globalVerifyModal_SignaturePad;
        let taskAttend_SignaturePad = null; 
        let currentRowForVerification = null;
        let taskAttend_currentAttendingRow = null;
        let currentTaskForAssignment = null; 
        let currentTaskForReschedule = null;

        let taskAttend_notes = [];
        let taskAttend_attachedMedia = [];
        let taskAttend_tempModalMedia = [];
        let allTasksDataOriginal = []; 
        let tasksData = []; 
        let tasksToVerify = []; 
        let currentMobileFilterStatus = 'all'; 
        let selectedTasksForVerification = new Set();
        let mainSearchTerm = '';

        let currentUserAccessLevel = 'super_admin'; 
        let currentAccessScope = {
            corporate: null,
            region: null,
            unit: null
        };
        let currentAdvancedFilters = {
            corporate: [], region: [], unit: [], department: [], equipment: [], status: [],
            fromDate: '', toDate: ''
        };
        

        const personnelData = [
            { id: 'p1', name: 'John Smith', role: 'Lab Staff', email: 'john.s@example.com', phone: '123-456-7890' },
            { id: 'p2', name: 'Sarah Johnson', role: 'Lab Staff', email: 'sarah.j@example.com', phone: '123-456-7891' },
            { id: 'p3', name: 'Michael Brown', role: 'Technician A', email: 'michael.b@example.com', phone: '234-567-8901' },
            { id: 'p4', name: 'Lisa Wong', role: 'Technician B', email: 'lisa.w@example.com', phone: '234-567-8902' },
            { id: 'p5', name: 'David Lee', role: 'Kitchen Staff', email: 'david.l@example.com', phone: '345-678-9012' },
            { id: 'p6', name: 'Emily White', role: 'Kitchen Staff', email: 'emily.w@example.com', phone: '345-678-9013' },
            { id: 'p7', name: 'Robert Green', role: 'Research Staff', email: 'robert.g@example.com', phone: '456-789-0123' },
            { id: 'p8', name: 'Alice Wonderland', role: 'Lab Technicians', email: 'alice.w@example.com', phone: '567-890-1234' },
            { id: 'p9', name: 'Bob The Builder', role: 'Supervisor', email: 'bob.supervisor@example.com', phone: '567-890-1235' }, 
            { id: 'p10', name: 'Charlie Day', role: 'Analyst C', email: 'charlie.d@example.com', phone: '678-901-2345' },
            { id: 'p11', name: 'Ethan Miller', role: 'Lab Staff', email: 'ethan.m@example.com', phone: '123-456-7892' },
        ];

        const FREQUENCY_DAYS_MAP = {
            'daily': 1, 'weekly': 7, 'biweekly': 14, 'monthly': 30, 'quarterly': 90 
        };


        const globalVerifyModalOverlay = document.getElementById('globalVerifyTaskModalOverlay');
        const globalVerifyModalContainer = document.getElementById('globalVerifyTaskModalContainer');
        const globalModalCloseBtn = document.getElementById('globalModalCloseBtn');
        const globalModalCancelVerificationBtn = document.getElementById('globalModalCancelVerificationBtn');
        const globalModalCompleteVerificationBtn = document.getElementById('globalModalCompleteVerificationBtn');
        const globalModalVerifierSignatureCanvas = document.getElementById('globalModalVerifierSignatureCanvas');
        const globalModalSignaturePlaceholderText = document.getElementById('globalModalSignaturePlaceholderText');
        const globalModalClearVerifierSignatureBtn = document.getElementById('globalModalClearVerifierSignatureBtn');
        const globalModalVerifyEqName = document.getElementById('globalModalVerifyEqName');
        const globalModalVerifyEqScheduledDate = document.getElementById('globalModalVerifyEqScheduledDate');
        const globalModalVerificationNotes = document.getElementById('globalModalVerificationNotes');

        const mainScheduleView = document.getElementById('mainScheduleView');
        const cleaningTableBody = document.getElementById("cleaningTable").tBodies[0]; 
        const noDataMessageRow = document.getElementById('no-data-message');
        const mainSearchBox = document.getElementById('mainSearchBox');

        const modalTaskEqIcon = document.getElementById('modalTaskEqIcon');
        const modalTaskEqName = document.getElementById('modalTaskEqName');
        const modalTaskEqStatus = document.getElementById('modalTaskEqStatus');
        const modalTaskEqImage = document.getElementById('modalTaskEqImage');
        const modalTaskEqId = document.getElementById('modalTaskEqId');
        const modalTaskEqMake = document.getElementById('modalTaskEqMake');
        const modalTaskEqLocation = document.getElementById('modalTaskEqLocation');
        const modalTaskEqInstallDate = document.getElementById('modalTaskEqInstallDate');
        const modalTaskEqScheduleDate = document.getElementById('modalTaskEqScheduleDate');
        const modalTaskScheduledDateLabel = document.getElementById('modalTaskScheduledDateLabel');
        const modalTaskEqResponsibility = document.getElementById('modalTaskEqResponsibility'); 
        const modalQuestionCardContainer = document.getElementById('modalQuestionCardContainer');
        const modalAddNoteAction = document.getElementById('modalAddNoteAction');
        const modalNotesInputArea = document.getElementById('modalNotesInputArea');
        const modalNotesDisplayArea = document.getElementById('modalNotesDisplayArea');
        const modalNoteTextarea = document.getElementById('modalNoteTextarea');
        const modalSaveNoteBtn = document.getElementById('modalSaveNoteBtn');
        const modalNotesList = document.getElementById('modalNotesList');
        const modalEditingNoteIndexInput = document.getElementById('modalEditingNoteIndex');
        const modalAttachMediaAction = document.getElementById('modalAttachMediaAction');
        const modalMediaDisplayArea = document.getElementById('modalMediaDisplayArea');
        const modalMediaGrid = document.getElementById('modalMediaGrid');
        const modalSignaturePadCanvas = document.getElementById('modalSignatureCanvas');
        const modalSignaturePlaceholder = document.getElementById('modalSignaturePlaceholder');
        const modalClearSignatureBtn = document.getElementById('modalClearSignatureBtn');
        const modalCompleteTaskBtn = document.getElementById('modalCompleteTaskBtn');
        const modalTaskTakePhotoBtn = document.getElementById('modalTaskTakePhotoBtn');
        const modalTaskTakeVideoBtn = document.getElementById('modalTaskTakeVideoBtn');
        const modalTaskModalMediaPreviewGrid = document.getElementById('modalTaskModalMediaPreviewGrid');
        const modalTaskSaveMediaFromModalBtn = document.getElementById('modalTaskSaveMediaFromModalBtn');
        const modalTaskMediaUploadLimitText = document.getElementById('modalTaskMediaUploadLimitText');

        const modalAssignEqNameEl = document.getElementById('modalAssignEqName');
        const modalAssignEqIdEl = document.getElementById('modalAssignEqId');
        const modalAssignEqLocationEl = document.getElementById('modalAssignEqLocation');
        const modalAssignCurrentRoleEl = document.getElementById('modalAssignCurrentRole');
        const assignSearchInputEl = document.getElementById('assignSearchInput');
        const assignPersonnelListEl = document.getElementById('assignPersonnelList');
        const noPersonnelMessageEl = document.getElementById('noPersonnelMessage');
        const sendAssignmentBtnEl = document.getElementById('sendAssignmentBtn');
        const assignmentHistoryListEl = document.getElementById('assignmentHistoryList');
        const noAssignmentHistoryMessageEl = document.getElementById('noAssignmentHistoryMessage');

        const accessFilterBtn = document.getElementById('accessFilterBtn'); 
        const advancedFilterToggleBtn = document.getElementById('advancedFilterToggleBtn');
        const advFilterCountBadge = document.getElementById('advFilterCountBadge');
        const refreshBtn = document.getElementById('refreshBtn');
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        const verificationNeededBtn = document.getElementById('verificationNeededBtn');
        const completeVerificationBtn = document.getElementById('completeVerificationBtn'); 
        const simulateRemindersBtn = document.getElementById('simulateRemindersBtn');

        const hierarchicalAccessFilterSelect = document.getElementById('hierarchicalAccessFilterSelect');
        const applyAccessFilterBtn = document.getElementById('applyAccessFilterBtn'); 

        const applyAdvancedFiltersBtn = document.getElementById('applyAdvancedFiltersBtn');
        const resetAdvancedFiltersBtn = document.getElementById('resetAdvancedFiltersBtn');


        const TASK_MAX_MEDIA_ITEMS = 5;

        function isMobileView() {
            return window.matchMedia("(max-width: 767.98px)").matches;
        }

        function getFormattedDate(offsetDays = 0, includeDayName = false, baseDate = new Date()) {
            const date = new Date(baseDate);
            date.setDate(date.getDate() + offsetDays);
            date.setHours(0,0,0,0); 
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const dateStr = `${year}-${month}-${day}`;
            
            if (includeDayName) {
                const dayName = date.toLocaleDateString(undefined, { weekday: 'long' });
                return { dateStr: dateStr, dayName: dayName };
            }
            return dateStr;
        }
        
        function getDayNameFromDateString(dateStr) {
            if (!dateStr) return '';
            if (!/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
                console.warn("Invalid dateStr for getDayNameFromDateString:", dateStr);
                return 'Invalid Date';
            }
            const date = new Date(dateStr.replace(/-/g, '/') + 'T00:00:00'); 
            if (isNaN(date.getTime())) return ''; 
            return date.toLocaleDateString(undefined, { weekday: 'long' });
        }


        function getDateWithOffset(days, baseDateStr = null) {
             const baseDate = baseDateStr ? new Date(baseDateStr.replace(/-/g, '/') + 'T00:00:00') : new Date();
             if(isNaN(baseDate.getTime())) { 
                baseDate = new Date();
             }
             baseDate.setDate(baseDate.getDate() + days);
             baseDate.setHours(0, 0, 0, 0); 
             return baseDate;
        }


        function formatDate(dateString, includeTime = false, fullTimestamp = false) {
            if (!dateString) return 'N/A';
            let options = { year: 'numeric', month: 'short', day: 'numeric' };
            if (includeTime || fullTimestamp) {
                options.hour = '2-digit';
                options.minute = '2-digit';
                if (fullTimestamp) options.second = '2-digit';
                options.hour12 = true;
            }

            const date = (dateString instanceof Date) ? dateString : new Date(String(dateString).replace(/-/g, '/').replace('T', ' ')); 

            if (isNaN(date.getTime())) {
                console.error("formatDate resulted in Invalid Date for input:", dateString);
                return 'Invalid Date';
            }
            
            return date.toLocaleDateString(undefined, options).replace(/, /g, ' '); 
        }


        function createAvatar(name) {
            if (!name) return '';
            const initials = name.split(' ').map(n => n[0]).join('').toUpperCase();
            return `<div class="avatar" title="${name}">${initials}</div>`;
        }

        function showToast(title, message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toastTitleEl = document.getElementById('toastTitle');
            const toastMessageEl = document.getElementById('toastMessage');
            const toastIconEl = toastEl.querySelector('.toast-header i');

            toastTitleEl.textContent = title;
            toastMessageEl.textContent = message;

            toastIconEl.className = 'me-2 '; 
            if (type === 'success') {
                toastIconEl.classList.add('fas', 'fa-check-circle', 'text-success');
            } else if (type === 'error') {
                toastIconEl.classList.add('fas', 'fa-times-circle', 'text-danger');
            } else if (type === 'warning') {
                toastIconEl.classList.add('fas', 'fa-exclamation-triangle', 'text-warning');
            } else if (type === 'info') {
                 toastIconEl.classList.add('fas', 'fa-info-circle', 'text-info');
            }

            toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark');
            toastEl.classList.add('bg-light');


            if (!liveToastInstance) {
                liveToastInstance = new bootstrap.Toast(toastEl, { delay: 5000 });
            }
            liveToastInstance.show();
        }

        function setupSignaturePad(canvasId, placeholderId, clearBtnId, options = {}) {
            const canvas = document.getElementById(canvasId);
            const placeholder = document.getElementById(placeholderId);
            const clearButton = document.getElementById(clearBtnId);

            if (!canvas) {
                console.error("Canvas element not found for ID:", canvasId);
                return null;
            }
            
            let signaturePadInstance = new SignaturePad(canvas, {
                backgroundColor: 'rgb(253, 253, 253)', penColor: 'rgb(0, 0, 0)', ...options
            });

            function resizeCanvas() {
                clearTimeout(resizeCanvas.timeoutId); 
                resizeCanvas.timeoutId = setTimeout(() => {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const parent = canvas.parentElement;
                    if (!parent || parent.offsetParent === null || parent.offsetWidth <= 0 || parent.offsetHeight <= 0) {
                        return; 
                    }
                    const width = parent.offsetWidth;
                    const height = parent.offsetHeight;

                    if (width > 0 && height > 0) {
                         canvas.width = width * ratio;
                         canvas.height = height * ratio;
                         canvas.style.width = `${width}px`;
                         canvas.style.height = `${height}px`;
                         canvas.getContext("2d").scale(ratio, ratio);
                         
                         if (signaturePadInstance && !signaturePadInstance.isEmpty()) {
                             const data = signaturePadInstance.toData();
                             signaturePadInstance.clear(); 
                             signaturePadInstance.fromData(data); 
                         } else if (signaturePadInstance) {
                             signaturePadInstance.clear(); 
                         }
                         
                         if (placeholder) {
                            placeholder.style.display = signaturePadInstance && signaturePadInstance.isEmpty() ? 'block' : 'none';
                         }
                    }
                }, 100); 
            }

            window.addEventListener("resize", resizeCanvas); 

            const modal = canvas.closest('.modal');
            if (modal) {
                modal.addEventListener('shown.bs.modal', () => {
                    resizeCanvas(); 
                     if (signaturePadInstance && signaturePadInstance.isEmpty() && placeholder) {
                        placeholder.style.display = 'block';
                    }
                });
            } else if (canvas === globalModalVerifierSignatureCanvas && globalVerifyModalOverlay) {
                 const observer = new MutationObserver(() => {
                     if (globalVerifyModalOverlay.style.display === 'flex') {
                        resizeCanvas();
                         if (signaturePadInstance && signaturePadInstance.isEmpty() && placeholder) {
                            placeholder.style.display = 'block';
                        }
                     }
                 });
                 observer.observe(globalVerifyModalOverlay, { attributes: true, attributeFilter: ['style'] });
            }


            if (placeholder) {
                signaturePadInstance.onBegin = () => { placeholder.style.display = 'none'; };
                signaturePadInstance.onEnd = () => { 
                    if (signaturePadInstance.isEmpty()) placeholder.style.display = 'block'; 
                };
                if (canvas.offsetParent !== null) { 
                    if (signaturePadInstance.isEmpty()) placeholder.style.display = 'block'; else placeholder.style.display = 'none';
                }
            }

            if (clearButton) {
                clearButton.addEventListener('click', (e) => {
                    e.stopPropagation(); 
                    signaturePadInstance.clear();
                    if (placeholder) placeholder.style.display = 'block';
                });
            }
            
            if (canvas.offsetParent !== null) {
                resizeCanvas();
            }
            
            return signaturePadInstance;
        }

        function initializeSampleDataAndTable() {
             const baseDateForOffsets = new Date('2025-07-15T12:00:00Z');

             allTasksDataOriginal = [
                // --- APEX CORP DATA (Americas) ---
                
                <?php foreach ($cleaning_schedule as $facility_equipmentsssss): ?>
    @php 
        $facility_equipments = DB::table('facility_equipment')->where('id',$facility_equipmentsssss->facility_equipment_id ?? '')->first();
        $unitDetails = DB::table('users')->where('id',$facility_equipments->created_by ?? '')->first();
        $unitDetails2 = DB::table('users')->where('id',$unitDetails->created_by1 ?? '')->first();
        $unitDetails3 = DB::table('users')->where('id',$unitDetails->created_by ?? '')->first();

        // Default values
        $status = 'ongoing';
        $verificationStatus = null;
        $completedBy = null;
        $verifiedBy = null;
        $completionDate = null;
        $verificationDate = null;

        // If completed
        if(!empty($facility_equipmentsssss->complete_status)) {
            $status = $facility_equipmentsssss->complete_status; 
            $verificationStatus = $facility_equipmentsssss->verificationStatus; 
            $completedBy = DB::table('users')->where('id',$facility_equipmentsssss->completed_by ?? '')->value('name');
            $verifiedBy = DB::table('users')->where('id',$facility_equipmentsssss->verified_by ?? '')->value('name');
            $completionDate = $facility_equipmentsssss->complete_date ?? null;
            $verificationDate = $facility_equipmentsssss->verificationDate ?? null;
        } else {
            // Status decide based on schedule date
            if(!empty($facility_equipmentsssss->cleaning_task_start_date)) {
                $scheduledDate = \Carbon\Carbon::parse($facility_equipmentsssss->cleaning_task_start_date);
                if($scheduledDate->isFuture()) {
                    $status = 'ongoing';
                } elseif($scheduledDate->isPast()) {
                    $status = 'overdue';
                }
            }
        }

        // ✅ Fix completedBy properly
        if ($facility_equipmentsssss->completedBy) {
            $unitDetails4 = DB::table('users')->where('id', $facility_equipmentsssss->completedBy)->first();
            $completedBy = $unitDetails4->name ?? null;
        }
        
         if ($facility_equipmentsssss->verifiedBy) {
            $unitDetails5 = DB::table('users')->where('id', $facility_equipmentsssss->verifiedBy)->first();
            $verifiedBy = $unitDetails5->name ?? null;
        }
    @endphp

    {
        id: '{{$facility_equipmentsssss->id ?? ''}}', 
        equipmentName: '{{$facility_equipments->name ?? ''}}', 
        equipmentIcon: 'fas fa-thermometer-empty',
        scheduledDateStr: '{{$facility_equipmentsssss->cleaning_task_start_date ?? ''}}', 
        signature: '{{$facility_equipmentsssss->signature ?? ''}}', 
        verifierSignature: '{{$facility_equipmentsssss->verifierSignature ?? ''}}', 
        verificationNotes: '{{$facility_equipmentsssss->verificationNotes ?? ''}}', 
        equipmentId: '{{$facility_equipments->id ?? ''}}', 
        location: '{{$facility_equipments->location_id ?? 'NA'}}',
        assignedTo: [], 
        frequency: 'weekly', 
        totalCheckpoints: 3, 

        status: '{{$status}}', 
        verificationStatus: '{{$verificationStatus ?? 'pending'}}', 
        completedBy: '{{$completedBy ?? ''}}', 
        verifiedBy: '{{$verifiedBy ?? ''}}',
        completionDate: '{{$completionDate ?? ''}}', 
        verificationDate: '{{$verificationDate ?? ''}}',

        checklistAnswers: { yes: 3, no: 0, na: 0 },
        unitName: '{{$unitDetails->company_name ?? ''}}', 
        regionName: '{{$unitDetails2->company_name ?? ''}}', 
        corporateName: '{{$unitDetails3->company_name ?? ''}}', 
        departmentName: '{{$facility_equipments->department ?? 'NA'}}'
    },
<?php endforeach; ?>
         
            ];
            
            allTasksDataOriginal.forEach(task => {
                task.scheduledDate = task.scheduledDateStr;
                task.signature = task.signature;
                task.verificationNotes = task.verificationNotes;
                task.verifierSignature = task.verifierSignature;
                if (!task.frequency) task.frequency = 'weekly';
                if (!task.checklistAnswers) task.checklistAnswers = { yes: 0, no: 0, na: 0 };
                if (!task.assignedTo) task.assignedTo = []; 
                if (!task.assignmentLog) task.assignmentLog = []; 
                if (!task.unitName) task.unitName = "Default Unit"; 
                if (!task.regionName) task.regionName = "Default Region";
                if (!task.corporateName) task.corporateName = "";
                if (!task.departmentName) task.departmentName = "Default Dept";
                if (!task.checklistQuestions) task.checklistQuestions = [];
                if(task.checklistQuestions.length > 0 && !task.totalCheckpoints) {
                    task.totalCheckpoints = task.checklistQuestions.length;
                }
            });

            currentUserAccessLevel = 'super_admin';
            currentAccessScope = { corporate: null, region: null, unit: null };

            populateHierarchicalAccessFilterDropdown();
            applyAccessFiltersAndRender(); 
        }

        function applyAccessFiltersAndRender() {
            // 1. Filter by Access Level (View As)
            let accessFilteredTasks = allTasksDataOriginal.filter(task => {
                if (currentUserAccessLevel === 'super_admin') return true;
                if (currentUserAccessLevel === 'corporate') {
                    return task.corporateName === currentAccessScope.corporate;
                }
                if (currentUserAccessLevel === 'regional') {
                    return task.corporateName === currentAccessScope.corporate && 
                           task.regionName === currentAccessScope.region;
                }
                if (currentUserAccessLevel === 'unit') {
                    return task.corporateName === currentAccessScope.corporate && 
                           task.regionName === currentAccessScope.region && 
                           task.unitName === currentAccessScope.unit;
                }
                return false;
            });

            // 2. Filter by Advanced Filters
            let advancedFilteredTasks = accessFilteredTasks.filter(task => {
                const statusMatch = currentAdvancedFilters.status.length === 0 || 
                    currentAdvancedFilters.status.some(s => 
                        s === 'completed_pending' ? (task.status === 'completed' && task.verificationStatus === 'pending') : task.status === s
                    );

                const fromDateStr = currentAdvancedFilters.fromDate;
                const toDateStr = currentAdvancedFilters.toDate;

                const dateMatch = (() => {
                    if (!fromDateStr && !toDateStr) return true;
                    const taskDate = task.scheduledDate; 
                    if (fromDateStr && taskDate < fromDateStr) return false;
                    if (toDateStr && taskDate > toDateStr) return false;
                    return true;
                })();

                return (currentAdvancedFilters.corporate.length === 0 || currentAdvancedFilters.corporate.includes(task.corporateName)) &&
                       (currentAdvancedFilters.region.length === 0 || currentAdvancedFilters.region.includes(task.regionName)) &&
                       (currentAdvancedFilters.unit.length === 0 || currentAdvancedFilters.unit.includes(task.unitName)) &&
                       (currentAdvancedFilters.department.length === 0 || currentAdvancedFilters.department.includes(task.departmentName)) &&
                       (currentAdvancedFilters.equipment.length === 0 || currentAdvancedFilters.equipment.includes(task.equipmentName)) &&
                       statusMatch &&
                       dateMatch;
            });

            updateAdvancedFilterBadge();

            // 3. Filter by Main Search Box
            tasksData = advancedFilteredTasks.filter(task => {
                if (mainSearchTerm === '') return true;
                return (task.equipmentName?.toLowerCase().includes(mainSearchTerm)) ||
                       (task.location?.toLowerCase().includes(mainSearchTerm)) ||
                       (task.equipmentId?.toLowerCase().includes(mainSearchTerm)) ||
                       (task.departmentName?.toLowerCase().includes(mainSearchTerm)) ||
                       (task.unitName?.toLowerCase().includes(mainSearchTerm));
            });

            renderTable(); 
            updateVerificationNeededButtonText(); 
            updateMobileStatusFilterCounts();
            updateTimelineChart();
        }

        /**
         * Renders the table with hierarchical grouping.
         * Tasks are grouped by corporateName and displayed under a group header.
         */
        function renderTable() {
            cleaningTableBody.innerHTML = '';
            let dataToRender = tasksData;

            // Apply mobile status filter if active
            const mobileFiltersElement = document.getElementById('mobileStatusFilters');
            const isMobileViewForFilter = mobileFiltersElement && getComputedStyle(mobileFiltersElement).display !== 'none';

            if (isMobileViewForFilter && currentMobileFilterStatus !== 'all') {
                dataToRender = tasksData.filter(task => {
                    if (currentMobileFilterStatus === 'completed') {
                        return task.status === 'completed' && task.verificationStatus === 'pending';
                    }
                    return task.status === currentMobileFilterStatus;
                });
            }

            // Group data by corporateName
            const groupedData = dataToRender.reduce((acc, task) => {
                const key = task.corporateName || 'Uncategorized';
                if (!acc[key]) {
                    acc[key] = [];
                }
                acc[key].push(task);
                return acc;
            }, {});

            const sortedGroupKeys = Object.keys(groupedData).sort();

            if (sortedGroupKeys.length === 0) {
                noDataMessageRow.style.display = 'table-row';
                const colCount = 6;
                const noDataCell = noDataMessageRow.querySelector('td');
                noDataCell.setAttribute('colspan', colCount.toString());

                if (mainSearchTerm) {
                    noDataCell.textContent = `No results found for "${mainSearchTerm}".`;
                } else if (isMobileViewForFilter && currentMobileFilterStatus !== 'all') {
                    const filterText = currentMobileFilterStatus.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    noDataCell.textContent = `No tasks found for "${filterText}" filter.`;
                } else if (currentUserAccessLevel !== 'super_admin' || Object.values(currentAdvancedFilters).some(arr => arr.length > 0) || currentAdvancedFilters.fromDate || currentAdvancedFilters.toDate) {
                    noDataCell.textContent = `No cleaning schedule data available for the current filter combination.`;
                } else {
                    noDataCell.textContent = "No cleaning schedule data available.";
                }
                return;
            }

            noDataMessageRow.style.display = 'none';

            // Render groups and their tasks
            sortedGroupKeys.forEach(groupName => {
                const groupHeaderRow = document.createElement('tr');
                groupHeaderRow.className = 'hierarchy-group-header';
                const headerCell = document.createElement('td');
                headerCell.textContent = groupName;
                groupHeaderRow.appendChild(headerCell);
                cleaningTableBody.appendChild(groupHeaderRow);

                const tasksInGroup = groupedData[groupName];
                // Task 3: Sort tasks by scheduled date descending (latest first) within each group
                tasksInGroup.sort((a, b) => new Date(b.scheduledDate) - new Date(a.scheduledDate));

                tasksInGroup.forEach(taskData => {
                    const row = document.createElement('tr');
                    row.dataset.id = taskData.id;
                    row.dataset.status = taskData.status;
                    row.dataset.totalCheckpoints = taskData.totalCheckpoints;
                    row.draggable = true;
                    if (taskData.equipmentName.toLowerCase().includes('walk in chiller')) {
                        row.classList.add('walk-in-chiller-item');
                    }
                    updateTaskRow(row, taskData);
                    cleaningTableBody.appendChild(row);
                });
            });

            addDragAndDropListeners();
            updateVerificationNeededButtonText();
            updateMobileStatusFilterCounts();
        }


        function updateTdContent(row, label, contentGenerator) {
            const td = row.querySelector(`td[data-label="${label}"]`);
            if (td) {
                td.innerHTML = ''; 
                try {
                    contentGenerator(td);
                }
                catch (error) { console.error(`Error generating content for TD "${label}" in row ${row.dataset.id}:`, error, error.stack); td.textContent = 'Error rendering content.'; }
            }
        }

        function updateTaskRow(row, taskData) {
            // Clear existing content and set up the structure
            row.innerHTML = `
                <td data-label="Equipment Details" class="d-none d-md-flex"></td>
                <td data-label="Cleaning Checklist" class="d-none d-md-flex"></td>
                <td data-label="Evidence" class="d-none d-md-flex"></td>
                <td data-label="Completion Details" class="d-none d-md-flex"></td>
                <td data-label="Verification Details" class="d-none d-md-flex"></td>
                <td data-label="Actions" class="d-none d-md-flex"></td>
                <td class="mobile-td-wrapper d-block d-md-none"></td>
            `;

            updateTdContent(row, "Equipment Details", (td) => {
                const dayName = getDayNameFromDateString(taskData.scheduledDate);
                if (dayName === 'Invalid Date') console.error("Invalid dayName for task", taskData.id, "from scheduledDate", taskData.scheduledDate);

                const equipDetailsDiv = document.createElement('div');
                equipDetailsDiv.className = 'equipment-details w-100';
                
                let responsibilityDisplay = taskData.responsibility || 'N/A';
                if (taskData.assignedTo && taskData.assignedTo.length > 0) {
                    responsibilityDisplay = `<strong>${taskData.assignedTo.join(', ')}</strong> <small class="text-muted">(Role: ${taskData.responsibility || 'N/A'})</small>`;
                }

                let scheduleDateLabelText = (taskData.status === 'ongoing' || taskData.status === 'overdue') ? 'Active Till' : 'Scheduled';

                equipDetailsDiv.innerHTML = `
                    <div class="equipment-name mb-1"><i class="${taskData.equipmentIcon || 'fas fa-tools'} me-1"></i> ${taskData.equipmentName}</div>
                    <div class="scheduled-date-info mb-2 mt-1">
                        <div class="date-with-day">
                            <small class="text-muted d-block">${scheduleDateLabelText}:</small>
                            <span class="date-value fw-bold">${formatDate(taskData.scheduledDate)}</span>
                            <span class="day-value text-muted">(${dayName || 'N/A'})</span>
                        </div>
                        ${taskData.rescheduledFrom ? `<div class="rescheduled-info">Rescheduled from: <strong>${formatDate(taskData.rescheduledFrom)}</strong></div>` : ''}
                    </div>
                    <div class="equipment-meta">ID: ${taskData.equipmentId || 'N/A'}</div>
                    <div class="equipment-meta">Location: ${taskData.location || 'N/A'}</div>
                    <div class="equipment-meta"><strong>Corp / Region:</strong> ${taskData.corporateName || 'N/A'} / ${taskData.regionName || 'N/A'}</div>
                    <div class="equipment-meta"><strong>Unit / Dept:</strong> ${taskData.unitName || 'N/A'} / ${taskData.departmentName || 'N/A'}</div>
                    <div class="equipment-meta">R: ${responsibilityDisplay}</div>
                    <div class="equipment-meta">Freq: <span style="text-transform:capitalize;">${taskData.frequency || 'N/A'}</span></div>
                `;
                td.appendChild(equipDetailsDiv);
            });

            updateTdContent(row, "Cleaning Checklist", (td) => {
                if (taskData.status === 'completed' || taskData.status === 'verified') {
                    const contentWrapper = document.createElement('div');
                    contentWrapper.className = 'w-100 d-flex flex-column gap-2';

                    const summaryDiv = document.createElement('div');
                    summaryDiv.className = 'checklist-summary';
                    summaryDiv.innerHTML = `
                        <div class="total-line">
                            <span class="count-label">Total Points:</span>
                            <span class="count-badge checklist-count-total">${taskData.totalCheckpoints || '-'}</span>
                        </div>
                        <div class="counts-line">
                            <div class="count-item">
                                <span class="count-label">Yes:</span>
                                <span class="count-badge checklist-count-yes">${(taskData.checklistAnswers && taskData.checklistAnswers.yes !== undefined) ? taskData.checklistAnswers.yes : '-'}</span>
                            </div>
                            <div class="count-item">
                                <span class="count-label">No:</span>
                                <span class="count-badge checklist-count-no">${(taskData.checklistAnswers && taskData.checklistAnswers.no !== undefined) ? taskData.checklistAnswers.no : '-'}</span>
                            </div>
                            <div class="count-item">
                                 <span class="count-label">NA:</span>
                                 <span class="count-badge checklist-count-na">${(taskData.checklistAnswers && taskData.checklistAnswers.na !== undefined) ? taskData.checklistAnswers.na : '-'}</span>
                            </div>
                        </div>
                    `;
                    contentWrapper.appendChild(summaryDiv);

                    if (taskData.checklistQuestions && taskData.checklistQuestions.length > 0) {
                        const viewBtn = document.createElement('button');
                        viewBtn.className = 'btn btn-sm btn-outline-primary mt-2';
                        viewBtn.innerHTML = '<i class="fas fa-list-check"></i> View Checklist';
                        viewBtn.onclick = (e) => {
                            e.stopPropagation();
                            openViewChecklistModal(taskData);
                        };
                        contentWrapper.appendChild(viewBtn);
                    }
                    
                    td.appendChild(contentWrapper);

                } else {
                    const placeholder = document.createElement('div');
                    placeholder.className = 'text-muted fst-italic small w-100';
                    placeholder.textContent = 'Checklist not yet submitted.';
                    td.appendChild(placeholder);
                }
            });

            updateTdContent(row, "Evidence", (td) => {
                const evidenceContainer = document.createElement('div');
                evidenceContainer.className = 'w-100';
                if (taskData.evidence && taskData.evidence.length > 0) {
                    taskData.evidence.forEach(ev => {
                        const evidenceEl = document.createElement('div');
                        evidenceEl.style.marginBottom = '5px';
                        if (ev.type === 'photo' || ev.type === 'video') {
                             evidenceEl.innerHTML = `<a href="${ev.url || '#'}" class="evidence-link" target="_blank"><i class="fas ${ev.type === 'photo' ? 'fa-image' : 'fa-video'}"></i> ${ev.name || 'View Media'}</a>
                                                <div class="small text-muted">Uploaded: ${formatDate(ev.timestamp, true)}</div>`;
                        } else {
                            evidenceEl.innerHTML = `<span><i class="fas fa-file-alt me-1"></i>${ev.name || 'Evidence'}</span> <div class="small text-muted">${formatDate(ev.timestamp, true)}</div>`;
                        }
                        evidenceContainer.appendChild(evidenceEl);
                    });
                } else {
                     const badge = document.createElement('span');
                     badge.className = 'badge schedule-status-badge';
                     if (taskData.status === 'completed' || taskData.status === 'verified') {
                         badge.classList.add('bg-no-evidence'); badge.textContent = 'No Evidence';
                     } else {
                         badge.classList.add('bg-secondary'); badge.textContent = 'N/A'; 
                     }
                    evidenceContainer.appendChild(badge);
                }
                td.appendChild(evidenceContainer);
            });

            updateTdContent(row, "Completion Details", (td) => {
                const completionSection = document.createElement('div');
                completionSection.className = 'completion-section w-100';
                let statusBadgeText = 'Unknown', statusBadgeClass = 'bg-secondary';
             

                switch (taskData.status) {
                    case 'ongoing': statusBadgeText = 'Ongoing'; statusBadgeClass = 'bg-ongoing'; break; 
                    case 'overdue': statusBadgeText = 'Overdue'; statusBadgeClass = 'bg-overdue'; break;
                    case 'completed': statusBadgeText = 'Cleaning Completed'; statusBadgeClass = 'bg-cleaning-completed'; break; 
                    case 'verified': statusBadgeText = 'Verified'; statusBadgeClass = 'bg-verified'; break; 
                    default: statusBadgeText = taskData.status ? taskData.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'Unknown'; statusBadgeClass = 'bg-secondary';
                }

                const statusBadge = document.createElement('span');
                statusBadge.className = `badge schedule-status-badge ${statusBadgeClass}`; statusBadge.textContent = statusBadgeText;
                completionSection.appendChild(statusBadge);

                if (taskData.completedBy && (taskData.status === 'completed' || taskData.status === 'verified')) {
            
                    const completedInfo = document.createElement('div'); completedInfo.className = 'personnel-info mt-1';
                    completedInfo.innerHTML = `${createAvatar(taskData.completedBy)}<div><span class="fw-bold">${taskData.completedBy}</span><small class="text-muted d-block">on ${formatDate(taskData.completionDate, true)}</small></div>`;
                    completionSection.appendChild(completedInfo);
                   if (taskData.signature) {
    const sigImg = document.createElement('img');
    // Base URL add karke full path banao
    sigImg.src = `https://efsm.safefoodmitra.com/admin/public/${taskData.signature}`;
    sigImg.alt = "Signature";
    sigImg.style.cssText = 'width: 100px; height: auto; border: 1px solid #eee; margin-top: 5px; display: block;';
    completionSection.appendChild(sigImg);
}
                    if (taskData.comment) {
                        const commentDiv = document.createElement('div'); commentDiv.className = 'comment mt-1'; commentDiv.textContent = taskData.completionNotes; completionSection.appendChild(commentDiv);
                    }
                } else if (['ongoing', 'overdue'].includes(taskData.status)) {
                     const notCompletedText = document.createElement('small'); notCompletedText.className = 'text-muted d-block mt-1';
                     notCompletedText.textContent = 'Not yet attended.';
                     completionSection.appendChild(notCompletedText);
                }
                 td.appendChild(completionSection);
            });

            updateTdContent(row, "Verification Details", (td) => {
                const verificationSection = document.createElement('div');
                verificationSection.className = 'verification-section w-100';
                let verificationBadgeText = '', verificationBadgeClass = '', needsCheckbox = false;
                
                
                console.log(taskData.verificationStatus);

                if (taskData.status === 'verified') { 
                    verificationBadgeText = 'Verified'; verificationBadgeClass = 'bg-verified';
                    const badge = document.createElement('span'); badge.className = `badge schedule-status-badge ${verificationBadgeClass}`; badge.textContent = verificationBadgeText; verificationSection.appendChild(badge);
                    if (taskData.verifiedBy) {
                        const verifierInfo = document.createElement('div'); verifierInfo.className = 'personnel-info mt-1';
                        verifierInfo.innerHTML = `${createAvatar(taskData.verifiedBy)}<div><span class="fw-bold">${taskData.verifiedBy}</span><small class="text-muted d-block">on ${formatDate(taskData.verificationDate, true)}</small></div>`;
                        verificationSection.appendChild(verifierInfo);
                        
                        


                   if (taskData.verifierSignature) {
    const sigImg = document.createElement('img');
    sigImg.src = `https://efsm.safefoodmitra.com/admin/public/${taskData.verifierSignature}`;
    sigImg.alt = "Verifier Signature";
    sigImg.style.cssText = 'width: 100px; height: auto; border: 1px solid #eee; margin-top: 5px; display: block;';
    verificationSection.appendChild(sigImg);
}
                        if (taskData.verificationNotes) {
                            const commentDiv = document.createElement('div'); commentDiv.className = 'comment mt-1'; commentDiv.textContent = taskData.verificationNotes; verificationSection.appendChild(commentDiv);
                        }
                    }
                } else if (taskData.status === 'completed' && taskData.verificationStatus === 'pending') { 
                    verificationBadgeText = 'Verification Due'; verificationBadgeClass = 'bg-verification-due'; 
                    needsCheckbox = true; 
                    const badge = document.createElement('span'); badge.className = `badge schedule-status-badge ${verificationBadgeClass}`; badge.textContent = verificationBadgeText; verificationSection.appendChild(badge);
                } else if (['ongoing', 'overdue'].includes(taskData.status)) { 
                    verificationBadgeText = 'N/A'; verificationBadgeClass = 'bg-na';
                    const badge = document.createElement('span'); badge.className = `badge schedule-status-badge ${verificationBadgeClass}`; badge.textContent = verificationBadgeText;
                    const pendingCleaningText = document.createElement('small'); pendingCleaningText.className = 'text-muted d-block mt-1';
                    pendingCleaningText.textContent = 'Pending cleaning completion.';
                    verificationSection.appendChild(pendingCleaningText);
                } else { 
                    verificationBadgeText = 'N/A'; verificationBadgeClass = 'bg-na';
                    const badge = document.createElement('span'); badge.className = `badge schedule-status-badge ${verificationBadgeClass}`; badge.textContent = verificationBadgeText; verificationSection.appendChild(badge);
                }
                
                 if (needsCheckbox && !isMobileView()) { 
                    const checkboxContainer = document.createElement('div'); checkboxContainer.className = 'form-check mt-2';
                    const checkboxId = `verifyCheckbox-${taskData.id}`;
                    const checkbox = document.createElement('input'); checkbox.className = 'form-check-input task-verify-cb'; checkbox.type = 'checkbox'; checkbox.id = checkboxId; checkbox.style.cursor = 'pointer';
                    const label = document.createElement('label'); label.className = 'form-check-label'; label.htmlFor = checkboxId; label.textContent = 'Verify Task'; label.style.cursor = 'pointer';
                    checkboxContainer.appendChild(checkbox); checkboxContainer.appendChild(label);
                    verificationSection.appendChild(checkboxContainer);
                    const clickHandler = (event) => { event.stopPropagation(); if (event.target.type === 'checkbox') event.target.checked = false; handleSingleVerifyTrigger(taskData, row); };
                    checkbox.addEventListener('click', clickHandler); label.addEventListener('click', clickHandler);
                 }
                 td.appendChild(verificationSection);
             });

            updateTdContent(row, "Actions", (td) => {
                const actionButtonsDiv = document.createElement('div');
                actionButtonsDiv.className = 'action-buttons w-100';
                actionButtonsDiv.innerHTML = ''; 
                
                if (taskData.status === 'ongoing' || taskData.status === 'overdue') {
                    const attendBtn = document.createElement('button');
                    attendBtn.className = 'btn btn-sm btn-primary btn-attend';
                    attendBtn.innerHTML = '<i class="fas fa-clipboard-check"></i> Attend Task';
                    attendBtn.onclick = (e) => { e.stopPropagation(); openTaskAttendModal(taskData, row); };
                    actionButtonsDiv.appendChild(attendBtn);
                    
                    // const assignToBtnDesktop = document.createElement('button');
                    // assignToBtnDesktop.className = 'btn btn-sm btn-outline-info'; 
                    // assignToBtnDesktop.innerHTML = '<i class="fas fa-user-plus"></i> Assign To';
                    // assignToBtnDesktop.onclick = (e) => { e.stopPropagation(); openAssignTaskModal(taskData, row); };
                    // actionButtonsDiv.appendChild(assignToBtnDesktop);

                    // const rescheduleBtnDesktop = document.createElement('button');
                    // rescheduleBtnDesktop.className = 'btn btn-sm btn-outline-warning';
                    // rescheduleBtnDesktop.innerHTML = '<i class="fas fa-calendar-alt"></i> Reschedule';
                    // rescheduleBtnDesktop.onclick = (e) => { e.stopPropagation(); openRescheduleModal(taskData, row); };
                    // actionButtonsDiv.appendChild(rescheduleBtnDesktop);
                }

                const historyBtnDesktop = document.createElement('button');
                historyBtnDesktop.className = 'btn btn-sm btn-outline-secondary'; 
                historyBtnDesktop.innerHTML = '<i class="fas fa-history"></i> View History';
                historyBtnDesktop.onclick = (e) => { e.stopPropagation(); openHistoryModal(taskData); };
                actionButtonsDiv.appendChild(historyBtnDesktop);

                if (actionButtonsDiv.childElementCount === 0) {
                    actionButtonsDiv.innerHTML = '<small class="text-muted w-100 text-center">No actions available</small>';
                }
                td.appendChild(actionButtonsDiv);
            });

            const mobileTdWrapper = row.querySelector('.mobile-td-wrapper');
            mobileTdWrapper.innerHTML = ''; // Clear previous mobile card

            const mobileCard = document.createElement('div');
            mobileCard.className = 'mobile-task-card-view';

            const createMobileDetailItem = (label, value, valueClass = '', labelClass = 'mobile-label', containerClass = 'mobile-detail-item') => {
                const item = document.createElement('div');
                item.className = containerClass;
                let valueHTML = `<span class="mobile-value ${valueClass}">${value || 'N/A'}</span>`; 
                if(label) {
                    item.innerHTML = `<span class="${labelClass} d-block">${label}:</span> ${valueHTML}`;
                } else { item.innerHTML = valueHTML; }
                return item;
            };
            const createMobileSectionHeader = (title) => {
                const header = document.createElement('h6');
                header.className = 'mobile-section-header';
                header.textContent = title;
                return header;
            };

            const equipNameHeader = document.createElement('h5');
            equipNameHeader.className = 'mobile-equipment-name';
            equipNameHeader.innerHTML = `<i class="${taskData.equipmentIcon || 'fas fa-tools'}"></i> ${taskData.equipmentName}`;
            mobileCard.appendChild(equipNameHeader);

            const topInfoContainer = document.createElement('div');
            topInfoContainer.className = 'mobile-top-info';
            const leftInfoCol = document.createElement('div');
            leftInfoCol.className = 'mobile-info-col';

            const dayNameForMobile = getDayNameFromDateString(taskData.scheduledDate);
            const scheduleLabelMobile = (taskData.status === 'ongoing' || taskData.status === 'overdue') ? 'Active Till' : 'Schedule Date';

            const scheduleDateItemContainer = createMobileDetailItem(scheduleLabelMobile, `${formatDate(taskData.scheduledDate)}, ${dayNameForMobile ? dayNameForMobile.substring(0,3).toUpperCase() : 'N/A'}`, '', 'mobile-label', 'mobile-detail-item');
            
            const scheduleDateValueSpan = scheduleDateItemContainer.querySelector('.mobile-value');
            if (scheduleDateValueSpan) { scheduleDateValueSpan.classList.add('mobile-schedule-indicator-text'); }
            leftInfoCol.appendChild(scheduleDateItemContainer);

            if (taskData.rescheduledFrom) {
                const rescheduledInfoMobile = document.createElement('div');
                rescheduledInfoMobile.className = 'mobile-detail-item mobile-rescheduled-info';
                rescheduledInfoMobile.innerHTML = `(Rescheduled from: <strong>${formatDate(taskData.rescheduledFrom)}</strong>)`;
                leftInfoCol.appendChild(rescheduledInfoMobile);
            }

            leftInfoCol.appendChild(createMobileDetailItem('Location', taskData.location, '', 'mobile-label', 'mobile-detail-item'));
            leftInfoCol.appendChild(createMobileDetailItem('Corp/Region', `${taskData.corporateName || 'N/A'} / ${taskData.regionName || 'N/A'}`, '', 'mobile-label', 'mobile-detail-item'));
            leftInfoCol.appendChild(createMobileDetailItem('Unit/Dept', `${taskData.unitName || 'N/A'} / ${taskData.departmentName || 'N/A'}`, '', 'mobile-label', 'mobile-detail-item'));
            
            let mobileResponsibilityDisplay = taskData.responsibility || 'N/A';
            if (taskData.assignedTo && taskData.assignedTo.length > 0) {
                mobileResponsibilityDisplay = `${taskData.assignedTo.join(', ')} <small class="text-muted">(${taskData.responsibility})</small>`;
            }
            const assignedToItem = createMobileDetailItem('Assigned To', '', '', 'mobile-label', 'mobile-detail-item');
            assignedToItem.querySelector('.mobile-value').innerHTML = mobileResponsibilityDisplay;
            leftInfoCol.appendChild(assignedToItem);


            const rightInfoCol = document.createElement('div');
            rightInfoCol.className = 'mobile-info-col text-end';

            let statusTextMobile = 'Unknown';
            let statusBadgeMobileClass = 'bg-secondary'; 
            let mobileIndicatorClass = ''; 

             switch (taskData.status) {
                 case 'ongoing': 
                    statusTextMobile = "Ongoing"; 
                    statusBadgeMobileClass = 'bg-ongoing'; 
                    mobileIndicatorClass = 'status-ongoing';
                    break;
                 case 'overdue': 
                    statusTextMobile = "Overdue"; 
                    statusBadgeMobileClass = 'bg-overdue';
                    mobileIndicatorClass = 'status-overdue';
                    break;
                 case 'completed': 
                    statusTextMobile = "Cleaning Completed"; 
                    statusBadgeMobileClass = 'bg-cleaning-completed'; 
                    mobileIndicatorClass = 'status-cleaning-completed';
                    break;
                 case 'verified': 
                    statusTextMobile = "Verified"; 
                    statusBadgeMobileClass = 'bg-verified';
                    mobileIndicatorClass = 'status-verified';
                    break;
                 default: 
                    statusTextMobile = taskData.status ? taskData.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'Unknown'; 
                    statusBadgeMobileClass = 'bg-secondary';
             }
            if (scheduleDateValueSpan && mobileIndicatorClass) {
                scheduleDateValueSpan.classList.add(mobileIndicatorClass);
            }

            const statusItem = createMobileDetailItem('Status', statusTextMobile, `badge ${statusBadgeMobileClass}`, 'mobile-label', 'mobile-detail-item status-value');
            rightInfoCol.appendChild(statusItem);
            topInfoContainer.appendChild(leftInfoCol);
            topInfoContainer.appendChild(rightInfoCol);
            mobileCard.appendChild(topInfoContainer);

            let detailsWrapper = null;
            let toggleButton = null;
            // Show toggle button ONLY if verified.
            if (taskData.status === 'verified') { 
                toggleButton = document.createElement('button');
                toggleButton.type = 'button';
                toggleButton.className = 'mobile-details-toggle-btn';
                toggleButton.dataset.target = `#mobile-details-${taskData.id}`;
                toggleButton.innerHTML = `Show Details <i class="fas fa-chevron-down toggle-icon"></i>`;
                mobileCard.appendChild(toggleButton);
                detailsWrapper = document.createElement('div');
                detailsWrapper.id = `mobile-details-${taskData.id}`; 
                detailsWrapper.className = 'mobile-details-collapsible';
            } else if (taskData.status === 'completed' && taskData.verificationStatus === 'pending') {
                // If completed but not verified, still need a container for the inner sections. No toggle.
                detailsWrapper = document.createElement('div');
                detailsWrapper.id = `mobile-details-${taskData.id}`;
                detailsWrapper.className = 'mobile-details-visible-no-toggle'; 
            }


            const generateMobileSectionContent = (sectionType) => {
                 const section = document.createElement('div');
                 section.className = 'mobile-section';
                 switch(sectionType) {
                    case 'checklist':
                        if (!['completed', 'verified'].includes(taskData.status)) {
                            section.style.display = 'none';
                            break;
                        }
                        section.appendChild(createMobileSectionHeader('Checklist Summary'));
                        const summaryDiv = document.createElement('div');
                        summaryDiv.className = 'checklist-summary';
                        summaryDiv.innerHTML = `
                            <div class="total-line">
                                <span class="count-label">Total Points:</span>
                                <span class="count-badge checklist-count-total">${taskData.totalCheckpoints || '-'}</span>
                            </div>
                            <div class="counts-line">
                                <div class="count-item">
                                    <span class="count-label">Yes:</span>
                                    <span class="count-badge checklist-count-yes">${(taskData.checklistAnswers && taskData.checklistAnswers.yes !== undefined) ? taskData.checklistAnswers.yes : '-'}</span>
                                </div>
                                <div class="count-item">
                                    <span class="count-label">No:</span>
                                    <span class="count-badge checklist-count-no">${(taskData.checklistAnswers && taskData.checklistAnswers.no !== undefined) ? taskData.checklistAnswers.no : '-'}</span>
                                </div>
                                <div class="count-item">
                                    <span class="count-label">NA:</span>
                                    <span class="count-badge checklist-count-na">${(taskData.checklistAnswers && taskData.checklistAnswers.na !== undefined) ? taskData.checklistAnswers.na : '-'}</span>
                                </div>
                            </div>
                        `;
                        section.appendChild(summaryDiv);
                        break;
                     case 'evidence':
                        if ((taskData.status === 'completed' || taskData.status === 'verified') && taskData.evidence && taskData.evidence.length > 0) {
                             section.appendChild(createMobileSectionHeader('Evidence Image'));
                             const evidenceContent = document.createElement('div');
                             evidenceContent.className = 'mobile-evidence-images-container';
                            taskData.evidence.forEach(ev => {
                                const link = document.createElement('a');
                                link.href = ev.url || '#'; link.target = '_blank';
                                link.title = ev.name || (ev.type === 'photo' ? 'View Photo' : 'View Video');
                                if (ev.type === 'photo') {
                                    link.innerHTML = `<img src="${ev.url || 'https://via.placeholder.com/70x70.png?text=Img'}" alt="${ev.name || 'Evidence'}" class="mobile-evidence-img">`;
                                } else if (ev.type === 'video') {
                                    link.innerHTML = `<div class="mobile-evidence-img placeholder"><i class="fas fa-video fa-lg"></i></div>`;
                                }
                                evidenceContent.appendChild(link);
                            });
                            section.appendChild(evidenceContent);
                         } else if (taskData.status === 'completed' || taskData.status === 'verified') {
                             section.appendChild(createMobileSectionHeader('Evidence Image'));
                             const evidenceContent = document.createElement('div');
                             evidenceContent.className = 'mobile-evidence-images-container';
                             evidenceContent.innerHTML = `<div class="mobile-evidence-img placeholder"><span>No Image</span></div>`;
                             section.appendChild(evidenceContent);
                         }
                         else { section.style.display = 'none'; }
                        break;
                     case 'completion':
                        if (taskData.status === 'completed' || taskData.status === 'verified') {
                             const attendedInfoBlock = document.createElement('div');
                             attendedInfoBlock.className = 'personnel-info-block';
                             attendedInfoBlock.appendChild(createMobileSectionHeader('Task Attended By'));
                             if (taskData.completedBy) {
                                const attendedByDiv = document.createElement('div');
                                attendedByDiv.className = 'd-flex align-items-center';
                                attendedByDiv.innerHTML = `${createAvatar(taskData.completedBy)} <span class="ms-2 fw-bold">${taskData.completedBy}</span>`;
                                attendedInfoBlock.appendChild(attendedByDiv);
                             } else { attendedInfoBlock.appendChild(createMobileDetailItem('', 'N/A')); }
                             attendedInfoBlock.appendChild(createMobileDetailItem('Attended On', formatDate(taskData.completionDate, true)));
                             section.appendChild(attendedInfoBlock);
                             if (taskData.completionSignature || taskData.completedBy) {
                                section.appendChild(createMobileSectionHeader('Signature'));
                                 if (taskData.completionSignature && taskData.completionSignature.length > 50) {
                                    const sigImg = document.createElement('img'); sigImg.src = taskData.completionSignature; sigImg.alt = "Signature"; sigImg.className = 'mobile-signature-img'; section.appendChild(sigImg);
                                 } else if (taskData.completedBy) {
                                    const sigPlaceholder = document.createElement('p'); sigPlaceholder.className = 'signature-placeholder-text'; sigPlaceholder.textContent = '(Signed)'; section.appendChild(sigPlaceholder);
                                }
                             }
                             if (taskData.completionNotes) {
                                section.appendChild(createMobileSectionHeader('Comment'));
                                const attendedComment = document.createElement('p'); attendedComment.className = 'mobile-comment'; attendedComment.textContent = taskData.completionNotes; section.appendChild(attendedComment);
                             }
                        } else { section.style.display = 'none'; }
                        break;
                     case 'verification':
                         if (taskData.status === 'verified' && taskData.verificationStatus === 'verified') { 
                             const verifiedInfoBlock = document.createElement('div');
                             verifiedInfoBlock.className = 'personnel-info-block';
                             verifiedInfoBlock.appendChild(createMobileSectionHeader('Verified by'));
                             if (taskData.verifiedBy) {
                                 const verifiedByDiv = document.createElement('div'); verifiedByDiv.className = 'd-flex align-items-center'; verifiedByDiv.innerHTML = `${createAvatar(taskData.verifiedBy)} <span class="ms-2 fw-bold">${taskData.verifiedBy}</span>`; verifiedInfoBlock.appendChild(verifiedByDiv);
                             } else { verifiedInfoBlock.appendChild(createMobileDetailItem('', 'N/A')); }
                             verifiedInfoBlock.appendChild(createMobileDetailItem('Verified On', formatDate(taskData.verificationDate, true)));
                             section.appendChild(verifiedInfoBlock);
                             if (taskData.verifierSignature || taskData.verifiedBy) {
                                 section.appendChild(createMobileSectionHeader('Verifier Signature'));
                                 if (taskData.verifierSignature && taskData.verifierSignature.length > 50) {
                                    const sigImg = document.createElement('img'); sigImg.src = taskData.verifierSignature; sigImg.alt = "Verifier Signature"; sigImg.className = 'mobile-signature-img'; section.appendChild(sigImg);
                                 } else if (taskData.verifiedBy) {
                                    const sigPlaceholder = document.createElement('p'); sigPlaceholder.className = 'signature-placeholder-text'; sigPlaceholder.textContent = '(Signed)'; section.appendChild(sigPlaceholder);
                                 }
                             }
                             if (taskData.verificationNotes) {
                                section.appendChild(createMobileSectionHeader('Verifier Comment'));
                                const verifiedComment = document.createElement('p'); verifiedComment.className = 'mobile-comment'; verifiedComment.textContent = taskData.verificationNotes; section.appendChild(verifiedComment);
                             }
                         } else { section.style.display = 'none'; } 
                         break;
                 }
                 return (section.style.display !== 'none' && section.hasChildNodes()) ? section : null;
            };

            const targetContainer = detailsWrapper || mobileCard; 

            const checklistSection = generateMobileSectionContent('checklist');
            if (checklistSection) targetContainer.appendChild(checklistSection);
            const evidenceSection = generateMobileSectionContent('evidence');
            if (evidenceSection) targetContainer.appendChild(evidenceSection);
            const completionSection = generateMobileSectionContent('completion');
            if (completionSection) targetContainer.appendChild(completionSection);
            const verificationSection = generateMobileSectionContent('verification');
            if (verificationSection) targetContainer.appendChild(verificationSection);

            if (detailsWrapper && !toggleButton) { 
                mobileCard.appendChild(detailsWrapper);
            } else if (detailsWrapper && toggleButton) { 
                 mobileCard.appendChild(detailsWrapper);
            }


            let verificationActionSection = mobileCard.querySelector('.mobile-verification-action');
            let attendActionSection = mobileCard.querySelector('.mobile-attend-action');
            let actionsFooter = mobileCard.querySelector('.mobile-actions-footer');
            
            if (!actionsFooter) {
                actionsFooter = document.createElement('div');
                actionsFooter.className = 'mobile-actions-footer';
            }
            actionsFooter.innerHTML = ''; 

            if (taskData.status === 'completed' && taskData.verificationStatus === 'pending') {
                if (!verificationActionSection) {
                    verificationActionSection = document.createElement('div');
                    verificationActionSection.className = 'mobile-verification-action';
                    if (actionsFooter.parentNode === mobileCard) mobileCard.insertBefore(verificationActionSection, actionsFooter);
                    else mobileCard.appendChild(verificationActionSection);
                }
                verificationActionSection.innerHTML = '';
                verificationActionSection.style.cssText = 'display: flex; justify-content: space-between; align-items: center; text-align: left; padding-top: 12px; margin-top: 12px; border-top: 1px dashed var(--medium-gray);';

                const verifyBtnMobile = document.createElement('button');
                verifyBtnMobile.className = 'btn btn-warning btn-sm';
                verifyBtnMobile.innerHTML = '<i class="fas fa-user-check"></i> Verify Task';
                verifyBtnMobile.onclick = (e) => { e.stopPropagation(); handleSingleVerifyTrigger(taskData, row); };
                verificationActionSection.appendChild(verifyBtnMobile);

                const selectionContainer = document.createElement('div');
                selectionContainer.className = 'mobile-task-selection form-check';
                selectionContainer.style.width = 'auto';

                const checkboxId = `multiVerifyCb-${taskData.id}`;
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'form-check-input mobile-verify-select-cb';
                checkbox.id = checkboxId;
                checkbox.dataset.taskId = taskData.id;
                if (selectedTasksForVerification.has(taskData.id)) {
                    checkbox.checked = true;
                }
                checkbox.addEventListener('change', handleMobileMultiSelectChange);

                const label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = checkboxId;
                label.textContent = 'Select for bulk verification';

                selectionContainer.appendChild(checkbox);
                selectionContainer.appendChild(label);
                verificationActionSection.appendChild(selectionContainer);

            } else if (taskData.status === 'ongoing' || taskData.status === 'overdue') { 
                 if (!attendActionSection) { 
                    attendActionSection = document.createElement('div');
                    attendActionSection.className = 'mobile-attend-action';
                    if (actionsFooter.parentNode === mobileCard) mobileCard.insertBefore(attendActionSection, actionsFooter);
                    else mobileCard.appendChild(attendActionSection);
                 }
                 attendActionSection.innerHTML = ''; 
                 const attendBtnMobile = document.createElement('button');
                 attendBtnMobile.className = 'btn btn-primary btn-sm';
                 attendBtnMobile.innerHTML = '<i class="fas fa-clipboard-check"></i> Attend Task';
                 attendBtnMobile.onclick = (e) => { e.stopPropagation(); openTaskAttendModal(taskData, row); };
                 attendActionSection.appendChild(attendBtnMobile);
            }


            const historyBtn = document.createElement('button');
            historyBtn.className = 'btn btn-outline-secondary btn-sm';
            historyBtn.innerHTML = '<i class="fas fa-history"></i> History';
            historyBtn.onclick = (e) => { e.stopPropagation(); openHistoryModal(taskData); };
            actionsFooter.appendChild(historyBtn);
            
            if (taskData.status === 'ongoing' || taskData.status === 'overdue') { 
                const assignToBtnMobile = document.createElement('button');
                assignToBtnMobile.className = 'btn btn-outline-info btn-sm';
                assignToBtnMobile.innerHTML = '<i class="fas fa-user-plus"></i> Assign';
                assignToBtnMobile.onclick = (e) => { e.stopPropagation(); openAssignTaskModal(taskData, row); };
                actionsFooter.appendChild(assignToBtnMobile);

                const rescheduleBtnMobile = document.createElement('button');
                rescheduleBtnMobile.className = 'btn btn-outline-warning btn-sm';
                rescheduleBtnMobile.innerHTML = '<i class="fas fa-calendar-alt"></i> Reschedule';
                rescheduleBtnMobile.onclick = (e) => { e.stopPropagation(); openRescheduleModal(taskData, row); };
                actionsFooter.appendChild(rescheduleBtnMobile);
            }

            if (actionsFooter.parentNode !== mobileCard && actionsFooter.hasChildNodes()) { 
                mobileCard.appendChild(actionsFooter);
            }


            row.classList.remove(
                'task-row-verified', 'task-row-completed-pending-verification',
                'task-row-ongoing', 'task-row-overdue'
            );
            if (scheduleDateValueSpan) {
                scheduleDateValueSpan.classList.remove(
                    'status-verified', 'status-cleaning-completed',
                    'status-ongoing', 'status-overdue'
                );
            }

            switch(taskData.status) {
                case 'verified':
                    row.classList.add('task-row-verified');
                    if (scheduleDateValueSpan) scheduleDateValueSpan.classList.add('status-verified');
                    break;
                case 'completed': 
                    row.classList.add('task-row-completed-pending-verification');
                    if (scheduleDateValueSpan) scheduleDateValueSpan.classList.add('status-cleaning-completed');
                    break;
                case 'overdue':
                    row.classList.add('task-row-overdue');
                    if (scheduleDateValueSpan) scheduleDateValueSpan.classList.add('status-overdue');
                    break;
                case 'ongoing':
                    row.classList.add('task-row-ongoing'); 
                    if (scheduleDateValueSpan) scheduleDateValueSpan.classList.add('status-ongoing');
                    break;
            }

            mobileTdWrapper.appendChild(mobileCard);
        }
       
        function handleSingleVerifyTrigger(taskData, row) {
            tasksToVerify = [{ task: taskData, row: row }];

            // --- Populate basic info ---
            globalModalVerifyEqName.textContent = taskData.equipmentName;
            globalModalVerifyEqScheduledDate.textContent = formatDate(taskData.scheduledDate);
            globalVerifyModalContainer.dataset.verifyingTaskId = taskData.id;

            const reviewContentContainer = document.getElementById('globalModalReviewContent');
            if (!reviewContentContainer) {
                console.error("Review content container not found in verification modal.");
                return;
            }
            reviewContentContainer.innerHTML = ''; // Clear previous content

            // --- Create and Append Completion Details Section ---
            const completionSection = document.createElement('div');
            completionSection.className = 'review-section';
            completionSection.innerHTML = `<h3 class="review-section-header"><i class="fas fa-user-tie"></i> Completion Details</h3>`;

            const completionBody = document.createElement('div');
            if (taskData.completedBy) {
                const personnelInfoHTML = `
                    <div class="personnel-info-block mb-3">
                        <div class="personnel-info">
                            ${createAvatar(taskData.completedBy)}
                            <div>
                                <div class="name">${taskData.completedBy}</div>
                                <div class="date">Completed on: ${formatDate(taskData.completionDate, true)}</div>
                            </div>
                        </div>
                        ${taskData.completionSignature && taskData.completionSignature.length > 50 ? 
                            `<img src="${taskData.completionSignature}" alt="Technician Signature" class="signature-review-img">` :
                            '<p class="text-muted small mt-2">(No signature image)</p>'}
                    </div>
                `;
                completionBody.innerHTML += personnelInfoHTML;
                if (taskData.completionNotes) {
                    completionBody.innerHTML += `<div class="comment-review"><strong>Technician Comment:</strong><br>${taskData.completionNotes}</div>`;
                } else {
                    completionBody.innerHTML += `<p class="text-muted small">(No comments from technician)</p>`;
                }
            } else {
                completionBody.innerHTML = `<p class="text-muted">Completion details not available.</p>`;
            }
            completionSection.appendChild(completionBody);
            reviewContentContainer.appendChild(completionSection);

            // --- Create and Append Checklist Review Section ---
            const checklistSection = document.createElement('div');
            checklistSection.className = 'review-section';
            checklistSection.innerHTML = `<h3 class="review-section-header"><i class="fas fa-tasks"></i> Completed Checklist</h3>`;
            const checklistBody = document.createElement('div');

            if (taskData.checklistQuestions && taskData.checklistQuestions.length > 0) {
                taskData.checklistQuestions.forEach((q, index) => {
                    let answerBadge = '<span class="badge bg-secondary">Not Answered</span>';
                    if (q.answer) {
                        let badgeClass = '';
                        switch (q.answer) {
                            case 'yes': badgeClass = 'bg-success'; break;
                            case 'no': badgeClass = 'bg-danger'; break;
                            case 'na': badgeClass = 'bg-na'; break;
                        }
                        answerBadge = `<span class="badge ${badgeClass}">${q.answer.toUpperCase()}</span>`;
                    }

                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'checklist-item';
                    itemDiv.innerHTML = `
                        <div class="checklist-item-question">${index + 1}. ${q.text}</div>
                        <div class="checklist-item-answer">Answer: ${answerBadge}</div>
                        ${q.comment ? `<div class="checklist-item-comment"><strong>Comment:</strong> ${q.comment}</div>` : ''}
                    `;
                    checklistBody.appendChild(itemDiv);
                });
            } else {
                checklistBody.innerHTML = '<p class="text-muted evidence-item-placeholder">No checklist items were recorded for this task.</p>';
            }
            checklistSection.appendChild(checklistBody);
            reviewContentContainer.appendChild(checklistSection);
            
            // --- Create and Append Evidence Review Section ---
            const evidenceSection = document.createElement('div');
            evidenceSection.className = 'review-section';
            evidenceSection.innerHTML = `<h3 class="review-section-header"><i class="fas fa-paperclip"></i> Attached Evidence</h3>`;
            const evidenceBody = document.createElement('div');
            evidenceBody.className = 'evidence-grid';

            if (taskData.evidence && taskData.evidence.length > 0) {
                taskData.evidence.forEach(ev => {
                    const evidenceEl = document.createElement('div');
                    evidenceEl.className = 'evidence-item';
                    evidenceEl.innerHTML = `
                        <a href="${ev.url || '#'}" target="_blank" title="${ev.name || 'View Media'}">
                            <i class="fas ${ev.type === 'photo' ? 'fa-image' : 'fa-video'}"></i>
                            <span class="d-block small">${ev.name || 'Media'}</span>
                        </a>`;
                    evidenceBody.appendChild(evidenceEl);
                });
            } else {
                evidenceBody.innerHTML = '<p class="text-muted evidence-item-placeholder">No evidence was attached.</p>';
            }
            evidenceSection.appendChild(evidenceBody);
            reviewContentContainer.appendChild(evidenceSection);

            // --- Clear verifier inputs and show modal ---
            globalVerifyModal_SignaturePad?.clear();
            globalModalVerificationNotes.value = '';
            if (globalModalSignaturePlaceholderText) globalModalSignaturePlaceholderText.style.display = 'block';

            globalVerifyModalOverlay.style.display = 'flex';
            setTimeout(() => { 
                globalVerifyModal_SignaturePad?.clear(); 
                window.dispatchEvent(new Event('resize')); 
                const modalBody = globalVerifyModalOverlay.querySelector('.global-verify-modal-body');
                if(modalBody) modalBody.scrollTop = 0;
            }, 150);
            globalModalVerificationNotes.focus();
        }

        function handleMobileMultiSelectChange(event) {
            const checkbox = event.target;
            const taskId = checkbox.dataset.taskId;
            if (checkbox.checked) {
                selectedTasksForVerification.add(taskId);
            } else {
                selectedTasksForVerification.delete(taskId);
            }
            updateVerificationNeededButtonText();
        }

        function updateVerificationNeededButtonText() {
            const button = document.getElementById('verificationNeededBtn');
            const btnTextSpan = document.getElementById('verificationNeededBtnText');
            const badge = document.getElementById('verificationNeededCount');
            if (!button || !btnTextSpan || !badge) return;

            const totalPending = tasksData.filter(t => t.status === 'completed' && t.verificationStatus === 'pending').length;

            button.classList.remove('btn-success', 'btn-warning', 'btn-outline-info', 'text-dark', 'text-white');
            badge.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-white'); 
            badge.style.color = ''; 


            if (isMobileView() && selectedTasksForVerification.size > 0) {
                btnTextSpan.textContent = 'Verify Selected'; 
                if(button.querySelector('.d-none.d-sm-inline')) button.querySelector('.d-none.d-sm-inline').textContent = 'Verify Selected';

                badge.textContent = selectedTasksForVerification.size;
                badge.classList.remove('d-none');
                badge.classList.add('bg-white'); 
                badge.style.color = 'var(--success-color)'; 
                
                button.classList.add('btn-success'); 
                button.classList.add('text-white');
                button.title = `Verify ${selectedTasksForVerification.size} selected tasks`;
            } else {
                btnTextSpan.textContent = 'Verify'; 
                if(button.querySelector('.d-none.d-sm-inline')) button.querySelector('.d-none.d-sm-inline').textContent = 'Verify Task';


                badge.textContent = totalPending;
                badge.classList.toggle('d-none', totalPending === 0);
                
                if (totalPending > 0) {
                    button.classList.add('btn-warning');
                    button.classList.add('text-dark');
                    badge.classList.add('bg-danger'); 
                    button.title = `${totalPending} tasks awaiting verification in current view`;
                } else {
                    button.classList.add('btn-outline-info');
                    button.title = "No tasks currently need verification in current view";
                }
            }
        }



let currentEquipmentId = null;
let currentChecklistId = null;



        function openTaskAttendModal(taskData, row) {
            taskAttend_currentAttendingRow = row;
            // Deep copy of questions to avoid modifying the original data before saving
            let tempChecklistQuestions = JSON.parse(JSON.stringify(taskData.checklistQuestions || []));
            
            taskAttend_notes = taskData.notes ? [{ text: taskData.notes, timestamp: new Date().toISOString() }] : [];
            taskAttend_attachedMedia = taskData.evidence ? JSON.parse(JSON.stringify(taskData.evidence)) : [];

            modalTaskEqIcon.innerHTML = `<i class="${taskData.equipmentIcon || 'fas fa-tools'}"></i>`;
            modalTaskEqName.textContent = taskData.equipmentName;

            let currentStatusText = 'Unknown';
            let scheduleModalLabelText = 'Scheduled Date'; // Default

                          switch (taskData.status) {
                 case 'ongoing': 
                    currentStatusText = "Ongoing"; 
                    scheduleModalLabelText = "Active Till";
                    break;
                 case 'overdue': 
                    currentStatusText = "Overdue"; 
                    scheduleModalLabelText = "Active Till";
                    break; 
                 default: 
                    currentStatusText = taskData.status ? taskData.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'Unknown';
             }
            modalTaskEqStatus.textContent = currentStatusText;
            if (modalTaskScheduledDateLabel) {
                modalTaskScheduledDateLabel.innerHTML = `<i class="fas fa-calendar-check"></i> ${scheduleModalLabelText}`;
            }


            modalTaskEqId.textContent = taskData.equipmentId || '--';
            modalTaskEqMake.textContent = taskData.equipmentMake || '--';
            modalTaskEqLocation.textContent = taskData.location || '--';
            modalTaskEqInstallDate.textContent = taskData.equipmentInstallDate ? formatDate(taskData.equipmentInstallDate) : '--';
            modalTaskEqScheduleDate.textContent = formatDate(taskData.scheduledDate);
            
            let responsibilityText = taskData.responsibility || '--';
            if (taskData.assignedTo && taskData.assignedTo.length > 0) {
                responsibilityText = taskData.assignedTo.join(', ');
            }
            modalTaskEqResponsibility.textContent = responsibilityText;


            modalQuestionCardContainer.innerHTML = '';
            if(tempChecklistQuestions.length > 0) {
                tempChecklistQuestions.forEach((q, index) => {
                    // Pass the temporary question object to be mutated inside the modal
                    const card = createTaskQuestionCard(q, index, taskData.id);
                    modalQuestionCardContainer.appendChild(card);
                });
            } else {
                modalQuestionCardContainer.innerHTML = `<p class="text-center text-muted">No checklist questions defined for this task.</p>`;
            }
            // Store the temporary checklist questions on the container to retrieve later
            modalQuestionCardContainer.dataset.checklist = JSON.stringify(tempChecklistQuestions);


                        taskAttend_renderNotes();
            taskAttend_renderMedia();
            
            if (taskAttend_SignaturePad) { 
                taskAttend_SignaturePad.clear();
                if(modalSignaturePlaceholder) modalSignaturePlaceholder.style.display = 'block';
            } else if (modalSignaturePlaceholder) {
                 modalSignaturePlaceholder.style.display = 'block';
            }

            taskAttend_tempModalMedia = [];

            taskAttendModalInstance.show();
            
                currentEquipmentId = taskData.id;
    currentChecklistId = taskData.checklistId;
        }

        function createTaskQuestionCard(question, index, taskId) {
            const card = document.createElement('div');
            card.className = 'question-card';
            if (question.answer) {
                card.classList.add(`answered-${question.answer}`);
            }
            card.dataset.questionId = question.id;
            card.innerHTML = `
                <div class="question-header">
                    <div class="question-text">${index + 1}. ${question.text}</div>
                    <div class="question-marks" title="Marks for this question">
                        Marks: --/${question.marks}
                        <i class="fas fa-info-circle text-muted"></i>
                    </div>
                </div>
                <div class="answer-options">
                    <button class="answer-button yes" data-answer="yes">Yes</button>
                    <button class="answer-button no" data-answer="no">No</button>
                    <button class="answer-button na" data-answer="na">N/A</button>
                </div>
                <div class="question-footer">
                    <div class="question-actions">
                        <a class="add-comment-link"><i class="fas fa-comment"></i> Add Comment</a>
                        <a class="create-action-link"><i class="fas fa-plus-square"></i> Create Action</a>
                    </div>
                    <div class="question-comment-area">
                        <textarea class="form-control" rows="2" placeholder="Enter comment for this question...">${question.comment || ''}</textarea>
                    </div>
                </div>
            `;
            const buttons = card.querySelectorAll('.answer-button');
            buttons.forEach(btn => {
                if (question.answer === btn.dataset.answer) {
                    btn.classList.add('selected');
                }
            });
             if (question.comment) {
                card.querySelector('.question-comment-area').style.display = 'block';
            }
            return card;
        }

        // function setupGlobalVerifyModalListeners() {
        //     if (!globalVerifyModalOverlay) return;
        //     globalModalCloseBtn.addEventListener('click', closeGlobalVerifyModal);
        //     globalModalCancelVerificationBtn.addEventListener('click', closeGlobalVerifyModal);
        //     globalVerifyModalOverlay.addEventListener('click', (e) => { if (e.target === globalVerifyModalOverlay) closeGlobalVerifyModal(); });
            
        //     globalModalCompleteVerificationBtn.addEventListener('click', () => {
        //         const notes = globalModalVerificationNotes.value.trim();
        //         if (globalVerifyModal_SignaturePad && globalVerifyModal_SignaturePad.isEmpty()) {
        //             showToast('Signature Required', 'Verifier signature is required.', 'warning'); return;
        //         }
        //         const signatureData = globalVerifyModal_SignaturePad ? globalVerifyModal_SignaturePad.toDataURL() : null;
        //         const verifierName = "Bob The Builder"; 
        //         const verificationDate = new Date().toISOString();
                
        //         let verifiedCount = 0;
        //         if (tasksToVerify.length > 0) { 
        //             tasksToVerify.forEach(info => {
        //                 const originalTask = allTasksDataOriginal.find(t => t.id === info.task.id);
        //                 if (originalTask && originalTask.status === 'completed' && originalTask.verificationStatus === 'pending') {
        //                     Object.assign(originalTask, {
        //                         status: 'verified', 
        //                         verificationStatus: 'verified', 
        //                         verifiedBy: verifierName,
        //                         verificationDate,
        //                         verificationNotes: notes, 
        //                         verifierSignature: signatureData
        //                      });
        //                     verifiedCount++;
        //                 }
        //             });
        //             tasksToVerify = []; 
        //             if (verifiedCount > 0) {
        //                 showToast("Verification Complete", `${verifiedCount} task(s) verified by ${verifierName}.`);
        //                 applyAccessFiltersAndRender(); 
        //             } else {
        //                  showToast("No Action", "No tasks were updated. They might have been already verified or not eligible.", "info");
        //             }
        //         } else {
        //             showToast("Error", "No task context for verification.", "error");
        //         }
                
        //         selectedTasksForVerification.clear(); 
        //         closeGlobalVerifyModal();
        //     });
        // }
        
        
        function setupGlobalVerifyModalListeners() {
    if (!globalVerifyModalOverlay) return;
    globalModalCloseBtn.addEventListener('click', closeGlobalVerifyModal);
    globalModalCancelVerificationBtn.addEventListener('click', closeGlobalVerifyModal);
    globalVerifyModalOverlay.addEventListener('click', (e) => { if (e.target === globalVerifyModalOverlay) closeGlobalVerifyModal(); });
    
    globalModalCompleteVerificationBtn.addEventListener('click', () => {
        const notes = globalModalVerificationNotes.value.trim();
        if (globalVerifyModal_SignaturePad && globalVerifyModal_SignaturePad.isEmpty()) {
            showToast('Signature Required', 'Verifier signature is required.', 'warning'); 
            return;
        }

        const signatureData = globalVerifyModal_SignaturePad ? globalVerifyModal_SignaturePad.toDataURL() : null;
        const verifierName = "{{ Auth::user()->name ?? 'Verifier' }}"; // ✅ login user ka naam
        const verificationDate = new Date().toISOString();

        let verifiedCount = 0;

        if (tasksToVerify.length > 0) {
            tasksToVerify.forEach(info => {
                const originalTask = allTasksDataOriginal.find(t => t.id === info.task.id);
                if (originalTask && originalTask.status === 'completed' && originalTask.verificationStatus === 'pending') {
                    
                    // ✅ Frontend update
                    Object.assign(originalTask, {
                        status: 'verified',
                        verificationStatus: 'verified',
                        verifiedBy: verifierName,
                        verificationDate,
                        verificationNotes: notes,
                        verifierSignature: signatureData
                    });

                    // ✅ Backend update via AJAX
                    $.ajax({
                        url: "{{ route('verifiedTask') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            task_id: originalTask.id,
                            notes: notes,
                            signature: signatureData,
                            verification_date: verificationDate
                        },
                        success: function (response) {
                            console.log("Task verified saved:", response);
                        },
                        error: function (xhr) {
                            console.error("Error saving verification:", xhr.responseText);
                        }
                    });

                    verifiedCount++;
                }
            });

            tasksToVerify = [];
            if (verifiedCount > 0) {
                showToast("Verification Complete", `${verifiedCount} task(s) verified by ${verifierName}.`);
                applyAccessFiltersAndRender();
            } else {
                showToast("No Action", "No tasks were updated. They might have been already verified or not eligible.", "info");
            }
        } else {
            showToast("Error", "No task context for verification.", "error");
        }

        selectedTasksForVerification.clear();
        closeGlobalVerifyModal();
    });
}


        function closeGlobalVerifyModal() {
             if (globalVerifyModalOverlay) {
                 globalVerifyModalOverlay.style.display = 'none'; 
                 globalModalVerificationNotes.value = '';
                 globalVerifyModal_SignaturePad?.clear();
                 if (globalModalSignaturePlaceholderText) globalModalSignaturePlaceholderText.style.display = 'block';
                 delete globalVerifyModalContainer.dataset.verifyingTaskId; 
                 tasksToVerify = []; 
                 updateVerificationNeededButtonText();
             }
        }
        
        function updateMobileStatusFilterCounts() {
            const counts = {
                all: tasksData.length,
                ongoing: tasksData.filter(t => t.status === 'ongoing').length,
                overdue: tasksData.filter(t => t.status === 'overdue').length,
                completed: tasksData.filter(t => t.status === 'completed' && t.verificationStatus === 'pending').length,
                verified: tasksData.filter(t => t.status === 'verified').length
            };

            document.querySelectorAll('#mobileStatusFilters .btn').forEach(btn => {
                const filterStatus = btn.dataset.statusFilter;
                const countBadge = btn.querySelector('.count-badge-status');
                if (countBadge) {
                    const count = counts[filterStatus] || 0;
                    countBadge.textContent = count;
                    countBadge.classList.toggle('d-none', count === 0);
                }
            });
        }

       function handleCompleteTaskSubmission() {
    if (!taskAttend_currentAttendingRow) { showToast("Error", "No task context.", "error"); return; }
    if (taskAttend_SignaturePad && taskAttend_SignaturePad.isEmpty()) { showToast('Signature Required', 'Technician signature required.', 'warning'); return; }

    const currentTaskId = taskAttend_currentAttendingRow.dataset.id;
    
    console.log(taskAttend_currentAttendingRow);
    const taskIndexInOriginal = allTasksDataOriginal.findIndex(t => t.id === currentTaskId);
    if (taskIndexInOriginal === -1) { showToast("Error", "Task data not found in master list.", "error"); return; }
    
    const task = allTasksDataOriginal[taskIndexInOriginal]; 
    let allAnswered = true;
    
    const finalChecklistData = JSON.parse(modalQuestionCardContainer.dataset.checklist);
    
    if (finalChecklistData.length > 0) {
        finalChecklistData.forEach(q => {
            if (q.answer === null) {
                allAnswered = false;
            }
        });
         if (!allAnswered) { showToast('Incomplete', 'Please answer all checklist questions before completing.', 'warning'); return; }
    }

    let completedByPerson = "Technician"; 
    if (task.assignedTo && task.assignedTo.length > 0) {
        completedByPerson = task.assignedTo[0];
    } else if (task.responsibility) {
        const personInRole = personnelData.find(p => p.role === task.responsibility);
        if (personInRole) completedByPerson = personInRole.name;
        else completedByPerson = task.responsibility; 
    }
    
    // Save checklist answers
    task.checklistQuestions = finalChecklistData;
    task.checklistAnswers = { yes: 0, no: 0, na: 0 };
    task.checklistQuestions.forEach(q => { if (q.answer) task.checklistAnswers[q.answer]++; });

    const signatureData = taskAttend_SignaturePad ? taskAttend_SignaturePad.toDataURL() : null;

    Object.assign(task, {
        status: 'completed', 
        completedBy: completedByPerson, 
        completionDate: new Date().toISOString(),
        completionSignature: signatureData,
        verificationStatus: 'pending' 
    });

    task.completionNotes = taskAttend_notes.filter(n => !n.questionId).map(n => n.text).join('\n');
    task.evidence = [...taskAttend_attachedMedia];

    // ✅ Ajax call for saving completion + signature
    $.ajax({
        url: "{{ route('completeTask') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            task_id: currentTaskId,
            equipment_id: task.equipmentId, 
            checklist_id: currentChecklistId,
            completed_by: completedByPerson,
            completion_date: new Date().toISOString(),
            completion_notes: task.completionNotes,
            signature: signatureData,   // <-- ये base64 image जाएगा DB में
            checklist_data: JSON.stringify(finalChecklistData),
            evidence: JSON.stringify(task.evidence)
        },
        success: function(response) {
            console.log("Task completed saved:", response);
            showToast('Task Attended', `${task.equipmentName} completed by ${completedByPerson}. Pending verification.`);
        },
        error: function(xhr) {
            console.error("Error saving completion:", xhr.responseText);
            showToast("Error", "Unable to save task completion!", "error");
        }
    });

    applyAccessFiltersAndRender(); 
    taskAttendModalInstance.hide();
    taskAttend_currentAttendingRow = null;
}

        function handleAddNoteAction() {
            modalNotesInputArea.style.display = 'block'; 
            modalNoteTextarea.value = ''; 
            modalEditingNoteIndexInput.value = -1; 
            modalNoteTextarea.focus();
        }

        function handleSaveNoteAction() {
    const noteText = modalNoteTextarea.value.trim(); 
    if (!noteText) return;

    const editingIdx = parseInt(modalEditingNoteIndexInput.value);
    let noteObj = { text: noteText, timestamp: new Date().toISOString() };

    if (editingIdx > -1 && editingIdx < taskAttend_notes.length) {
        if (!taskAttend_notes[editingIdx].questionId) {
            taskAttend_notes[editingIdx].text = noteText;
            noteObj = taskAttend_notes[editingIdx];
        }
    } else {
        taskAttend_notes.push(noteObj);
    }

    // ---- AJAX Call to Save Note ----
    $.ajax({
        url: "{{ route('saveNotes') }}",   // <-- आपका Laravel route
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
           equipment_id: currentEquipmentId,   // अब ये हमेशा available रहेगा
        checklist_id: currentChecklistId,
            note: noteText,                   // note text
            timestamp: noteObj.timestamp      // time भी भेज दें
        },
        success: function (response) {
            console.log("Note saved successfully:", response);

            // Toast notification
            const toast = document.getElementById('toastNotification');
            toast.textContent = "Note saved successfully!";
            toast.className = 'toast-notification show';
            setTimeout(() => toast.classList.remove('show'), 3000);
        },
        error: function (xhr) {
            console.error("Error saving note:", xhr.responseText);
        }
    });

    taskAttend_renderNotes(); 
    modalNotesInputArea.style.display = 'none'; 
    modalNoteTextarea.value = ''; 
    modalEditingNoteIndexInput.value = -1;
}

        function handleAttachMediaAction() {
             if (taskAttend_mediaGalleryModalInstance) {
                taskAttend_tempModalMedia = [...taskAttend_attachedMedia];
                taskAttend_renderModalMediaPreview();
                try {
                    const modalElement = document.getElementById('taskMediaGalleryModalInModal');
                     if (!modalElement.classList.contains('show')) {
                        taskAttend_mediaGalleryModalInstance.show();
                     }
                } catch (error) {
                    console.error('Error showing media gallery modal:', error);
                    showToast('Error', 'Could not open media gallery.', 'error');
                }
            } else {
                console.error('Media gallery modal instance is not available!');
                showToast('Error', 'Media gallery component not ready.', 'error');
            }
        }
        
        function handleSaveMediaFromGallery() {
            taskAttend_attachedMedia = [...taskAttend_tempModalMedia]; 
            taskAttend_renderMedia(); 
            taskAttend_mediaGalleryModalInstance.hide();
        }

        function handleTakePhotoInGallery() { taskAttend_addTempMediaItem('photo'); }
        function handleTakeVideoInGallery() { taskAttend_addTempMediaItem('video'); }


        function handleQuestionCardClick(event) {
            const answerButton = event.target.closest('.answer-button');
            const addCommentLink = event.target.closest('.add-comment-link');
            const createActionLink = event.target.closest('.create-action-link');

            if (answerButton) {
                event.stopPropagation();
                const parentCard = answerButton.closest('.question-card');
                const questionId = parentCard.dataset.questionId;
                const newAnswer = answerButton.dataset.answer;

                // Update UI immediately
                parentCard.querySelectorAll('.answer-button').forEach(b => b.classList.remove('selected'));
                answerButton.classList.add('selected');
                parentCard.classList.remove('answered-yes', 'answered-no', 'answered-na');
                parentCard.classList.add(`answered-${newAnswer}`);

                // Update the temporary checklist data stored on the container
                let checklistData = JSON.parse(modalQuestionCardContainer.dataset.checklist);
                const questionToUpdate = checklistData.find(q => q.id === questionId);
                if (questionToUpdate) {
                    questionToUpdate.answer = newAnswer;
                }
                modalQuestionCardContainer.dataset.checklist = JSON.stringify(checklistData);
            }

            if (addCommentLink) {
                event.preventDefault();
                event.stopPropagation();
                const commentArea = addCommentLink.closest('.question-footer').querySelector('.question-comment-area');
                commentArea.style.display = commentArea.style.display === 'block' ? 'none' : 'block';
                 if (commentArea.style.display === 'block') {
                    commentArea.querySelector('textarea').focus();
                }
            }
            if (createActionLink) {
                event.preventDefault();
                event.stopPropagation();
                showToast('Action (Simulated)', 'This would open a form to create a corrective action.', 'info');
            }
        }

        function handleQuestionCommentInput(event) {
            if (event.target.tagName === 'TEXTAREA') {
                 const parentCard = event.target.closest('.question-card');
                const questionId = parentCard.dataset.questionId;
                const newComment = event.target.value;

                let checklistData = JSON.parse(modalQuestionCardContainer.dataset.checklist);
                const questionToUpdate = checklistData.find(q => q.id === questionId);
                if (questionToUpdate) {
                    questionToUpdate.comment = newComment;
                }
                modalQuestionCardContainer.dataset.checklist = JSON.stringify(checklistData);
            }
        }

        function handleNoteActionClick(event) {
            const editBtn = event.target.closest('.edit-note-btn');
            const deleteBtn = event.target.closest('.delete-note-btn');

            if (editBtn) {
                const idx = parseInt(editBtn.dataset.index); 
                if (idx >= 0 && idx < taskAttend_notes.length) { 
                    modalNoteTextarea.value = taskAttend_notes[idx].text; 
                    modalEditingNoteIndexInput.value = idx; 
                    modalNotesInputArea.style.display = 'block'; 
                    modalNoteTextarea.focus(); 
                }
            } else if (deleteBtn) {
                if(confirm('Delete note?')) { 
                    const idx = parseInt(deleteBtn.dataset.index); 
                    if (idx >= 0 && idx < taskAttend_notes.length) { 
                        taskAttend_notes.splice(idx, 1); 
                        taskAttend_renderNotes(); 
                    }
                }
            }
        }

        function handleRemoveMediaItemClick(event) {
            const removeBtn = event.target.closest('.remove-media-btn');
            if (removeBtn) {
                if(confirm('Remove media?')) { 
                    const idx = parseInt(removeBtn.dataset.index); 
                    if (idx >= 0 && idx < taskAttend_attachedMedia.length) { 
                        taskAttend_attachedMedia.splice(idx, 1); 
                        taskAttend_renderMedia(); 
                    }
                }
            }
        }

        function handleRemoveTempMediaItemClick(event) {
            const removeBtn = event.target.closest('.remove-media-btn');
             if (removeBtn) {
                const idx = parseInt(removeBtn.dataset.index); 
                if (idx >= 0 && idx < taskAttend_tempModalMedia.length) { 
                    taskAttend_tempModalMedia.splice(idx, 1); 
                    taskAttend_renderModalMediaPreview(); 
                }
            }
        }

        function setupTaskAttendModalListeners() {
            if (!taskAttendModalInstance) return;

            modalCompleteTaskBtn.removeEventListener('click', handleCompleteTaskSubmission); 
            modalCompleteTaskBtn.addEventListener('click', handleCompleteTaskSubmission);

            modalAddNoteAction.removeEventListener('click', handleAddNoteAction);
            modalAddNoteAction.addEventListener('click', handleAddNoteAction);
            
            modalSaveNoteBtn.removeEventListener('click', handleSaveNoteAction);
            modalSaveNoteBtn.addEventListener('click', handleSaveNoteAction);

            modalAttachMediaAction.removeEventListener('click', handleAttachMediaAction);
            modalAttachMediaAction.addEventListener('click', handleAttachMediaAction);
            
            modalTaskSaveMediaFromModalBtn.removeEventListener('click', handleSaveMediaFromGallery);
            modalTaskSaveMediaFromModalBtn.addEventListener('click', handleSaveMediaFromGallery);

            modalTaskTakePhotoBtn.removeEventListener('click', handleTakePhotoInGallery);
            modalTaskTakePhotoBtn.addEventListener('click', handleTakePhotoInGallery);

            modalTaskTakeVideoBtn.removeEventListener('click', handleTakeVideoInGallery);
            modalTaskTakeVideoBtn.addEventListener('click', handleTakeVideoInGallery);
            
            modalQuestionCardContainer.removeEventListener('click', handleQuestionCardClick); 
            modalQuestionCardContainer.addEventListener('click', handleQuestionCardClick);

            modalQuestionCardContainer.removeEventListener('input', handleQuestionCommentInput);
            modalQuestionCardContainer.addEventListener('input', handleQuestionCommentInput);


            modalNotesList.removeEventListener('click', handleNoteActionClick); 
            modalNotesList.addEventListener('click', handleNoteActionClick);
            
            modalMediaGrid.removeEventListener('click', handleRemoveMediaItemClick); 
            modalMediaGrid.addEventListener('click', handleRemoveMediaItemClick);

            modalTaskModalMediaPreviewGrid.removeEventListener('click', handleRemoveTempMediaItemClick); 
            modalTaskModalMediaPreviewGrid.addEventListener('click', handleRemoveTempMediaItemClick);
        }


        function taskAttend_addTempMediaItem(type) {
            if (taskAttend_tempModalMedia.length >= TASK_MAX_MEDIA_ITEMS) { showToast('Limit Reached', `Max ${TASK_MAX_MEDIA_ITEMS} media items.`, 'warning'); return; }
            const newItem = { id: `media_${Date.now()}_${Math.random().toString(16).slice(2)}`, type, name: `${type}_${new Date().toLocaleTimeString().replace(/[:\s]/g, '')}.${type === 'photo' ? 'jpg' : 'mp4'}`, data: `data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=`, timestamp: new Date().toISOString() }; 
            taskAttend_tempModalMedia.push(newItem); taskAttend_renderModalMediaPreview();
        }
        function taskAttend_renderModalMediaPreview() {
            modalTaskModalMediaPreviewGrid.innerHTML = '';
            taskAttend_tempModalMedia.forEach((item, index) => {
                const mediaDiv = document.createElement('div'); mediaDiv.className = 'media-item';
                mediaDiv.innerHTML = `<i class="fas ${item.type === 'photo' ? 'fa-image' : 'fa-video'}"></i><button class="remove-media-btn" data-index="${index}" title="Remove ${item.name}">×</button>`;
                mediaDiv.title = item.name; modalTaskModalMediaPreviewGrid.appendChild(mediaDiv);
            });
            modalTaskMediaUploadLimitText.textContent = `${taskAttend_tempModalMedia.length} of ${TASK_MAX_MEDIA_ITEMS} items.`;
        }
        function taskAttend_renderNotes() {
            modalNotesList.innerHTML = ''; const generalNotes = taskAttend_notes.filter(n => !n.questionId);
            if (generalNotes.length > 0) {
                modalNotesDisplayArea.style.display = 'block';
                generalNotes.forEach(note => {
                    const originalIndex = taskAttend_notes.findIndex(fn => fn === note); if (originalIndex === -1) return;
                    const noteEl = document.createElement('div'); noteEl.className = 'note-item';
                    noteEl.innerHTML = `<p>${note.text}</p><div class="note-actions"><button data-index="${originalIndex}" class="edit-note-btn" title="Edit"><i class="fas fa-edit"></i></button><button data-index="${originalIndex}" class="delete-note-btn" title="Delete"><i class="fas fa-trash"></i></button></div>`;
                    modalNotesList.appendChild(noteEl);
                });
            } else { modalNotesDisplayArea.style.display = 'none'; }
        }
        function taskAttend_renderMedia() {
            modalMediaGrid.innerHTML = '';
            if (taskAttend_attachedMedia.length > 0) {
                modalMediaDisplayArea.style.display = 'block';
                taskAttend_attachedMedia.forEach((item, index) => {
                    const mediaEl = document.createElement('div'); mediaEl.className = 'media-item';
                    mediaEl.innerHTML = `<i class="fas ${item.type === 'photo' ? 'fa-image' : 'fa-video'}"></i><button class="remove-media-btn" data-index="${index}" title="Remove ${item.name}">×</button>`;
                    mediaEl.title = item.name; modalMediaGrid.appendChild(mediaEl);
                });
            } else { modalMediaDisplayArea.style.display = 'none'; }
        }

        let draggedItem = null;
        function addDragAndDropListeners() { const rows = cleaningTableBody.querySelectorAll('tr:not(#no-data-message)'); rows.forEach(r => { r.addEventListener('dragstart', handleDragStart); r.addEventListener('dragover', handleDragOver); r.addEventListener('dragleave', handleDragLeave); r.addEventListener('drop', handleDrop); r.addEventListener('dragend', handleDragEnd); }); }
        function handleDragStart(e) { draggedItem = this; setTimeout(() => this.classList.add('dragging'), 0); e.dataTransfer.effectAllowed = 'move'; try { e.dataTransfer.setData('text/plain', this.dataset.id); } catch (err) { console.warn("Drag data error:", err); }}
        function handleDragOver(e) { e.preventDefault(); if (this !== draggedItem && this.id !== 'no-data-message') this.classList.add('dropzone'); e.dataTransfer.dropEffect = 'move'; }
        function handleDragLeave() { this.classList.remove('dropzone'); }
        function handleDrop(e) {
            e.preventDefault(); this.classList.remove('dropzone');
            if (draggedItem && draggedItem !== this && this.id !== 'no-data-message') {
                const dId = draggedItem.dataset.id; const tId = this.dataset.id;
                const dIdxOriginal = allTasksDataOriginal.findIndex(t => t.id === dId);
                const tIdxOriginal = allTasksDataOriginal.findIndex(t => t.id === tId);
                if (dIdxOriginal > -1 && tIdxOriginal > -1) { 
                    const [taskToMove] = allTasksDataOriginal.splice(dIdxOriginal, 1); 
                    allTasksDataOriginal.splice(tIdxOriginal, 0, taskToMove); 
                    applyAccessFiltersAndRender(); 
                    showToast('Order Updated', 'Task order changed.', 'info'); 
                }
                else console.error("Drag/drop task ID not found in master list.");
            }
        }
        function handleDragEnd() { if (draggedItem) draggedItem.classList.remove('dragging'); cleaningTableBody.querySelectorAll('tr.dropzone').forEach(r => r.classList.remove('dropzone')); draggedItem = null; }

        const handleVerificationClick = () => {
            tasksToVerify = [];
            let hasTasks = false;

            if (isMobileView() && selectedTasksForVerification.size > 0) {
                selectedTasksForVerification.forEach(taskId => {
                    const task = tasksData.find(t => t.id === taskId);
                    if (task && task.status === 'completed' && task.verificationStatus === 'pending') {
                        const row = cleaningTableBody.querySelector(`tr[data-id="${task.id}"]`);
                        if (row) { tasksToVerify.push({ task, row }); hasTasks = true; }
                    }
                });
            } else {
                tasksData.forEach(task => {
                    if (task.status === 'completed' && task.verificationStatus === 'pending') {
                        const row = cleaningTableBody.querySelector(`tr[data-id="${task.id}"]`);
                        if (row) { tasksToVerify.push({ task, row }); hasTasks = true; }
                    }
                });
            }

            if (!hasTasks) {
                showToast("No Tasks", "No tasks are currently selected or pending verification in the current view.", "info");
                return;
            }

            if (tasksToVerify.length === 1) {
                // If only one task, show the detailed view
                handleSingleVerifyTrigger(tasksToVerify[0].task, tasksToVerify[0].row);
                return; // Important: exit here to avoid showing the modal again
            }

            // For multiple tasks (bulk verification), show a simplified modal
            const reviewContentContainer = document.getElementById('globalModalReviewContent');
            if(reviewContentContainer) reviewContentContainer.innerHTML = '<p class="text-muted text-center p-3">Review details are not shown for bulk verification. You are verifying all selected tasks based on their summary status.</p>';
            
            globalModalVerifyEqName.textContent = `${tasksToVerify.length} Tasks Selected`;
            globalModalVerifyEqScheduledDate.textContent = "Multiple Dates";

            globalModalVerificationNotes.value = '';
            globalVerifyModal_SignaturePad?.clear();
            if (globalModalSignaturePlaceholderText) globalModalSignaturePlaceholderText.style.display = 'block';

            globalVerifyModalOverlay.style.display = 'flex';
            setTimeout(() => { globalVerifyModal_SignaturePad?.clear(); window.dispatchEvent(new Event('resize')); }, 150);
            globalModalVerificationNotes.focus();
        };


        function openAssignTaskModal(taskData, row) {
            currentTaskForAssignment = { task: taskData, row: row }; 
            modalAssignEqNameEl.textContent = taskData.equipmentName;
            modalAssignEqIdEl.textContent = taskData.equipmentId || 'N/A';
            modalAssignEqLocationEl.textContent = taskData.location || 'N/A';
            modalAssignCurrentRoleEl.textContent = taskData.responsibility || 'N/A';

            populateAssignModalPersonnel(taskData.responsibility, taskData.assignedTo);
            const originalTask = allTasksDataOriginal.find(t => t.id === taskData.id);
            populateAssignmentHistory(originalTask ? originalTask.assignmentLog : []);
            assignSearchInputEl.value = ''; 
            assignTaskModalInstance.show();
        }
        
        function populateAssignmentHistory(log) {
            assignmentHistoryListEl.innerHTML = '';
            if (!log || log.length === 0) {
                noAssignmentHistoryMessageEl.style.display = 'block';
                assignmentHistoryListEl.style.display = 'none';
                return;
            }
            noAssignmentHistoryMessageEl.style.display = 'none';
            assignmentHistoryListEl.style.display = 'block';

            log.slice().reverse().forEach(entry => { 
                const li = document.createElement('li');
                const assignedToList = entry.assignedToNames.join(', ');
                li.innerHTML = `
                    <span class="log-timestamp">${formatDate(entry.timestamp, false, true)}</span>
                    <span class="log-details">
                        ${entry.action} to <strong>${assignedToList}</strong> by ${entry.assignedBy || 'System'}.
                        ${entry.previousAssignees ? `<br><small class="text-muted">Previous: ${entry.previousAssignees}</small>` : ''}
                    </span>
                `;
                assignmentHistoryListEl.appendChild(li);
            });
        }


        function populateAssignModalPersonnel(currentRole, currentlyAssignedNames = []) {
            assignPersonnelListEl.innerHTML = '';
            const relevantPersonnel = personnelData.filter(p => p.role === currentRole);

            if (relevantPersonnel.length === 0) {
                assignPersonnelListEl.style.display = 'none';
                noPersonnelMessageEl.style.display = 'block';
                noPersonnelMessageEl.textContent = `No personnel found for the role: "${currentRole}".`;
                return;
            }
            
            assignPersonnelListEl.style.display = 'block';
            noPersonnelMessageEl.style.display = 'none';

            relevantPersonnel.forEach(person => {
                const isChecked = currentlyAssignedNames.includes(person.name);
                const listItem = document.createElement('label');
                listItem.className = 'list-group-item d-flex align-items-center';
                listItem.innerHTML = `
                    <input class="form-check-input me-2" type="checkbox" value="${person.id}" data-name="${person.name}" ${isChecked ? 'checked' : ''}>
                    ${person.name} <small class="text-muted ms-1">(${person.role})</small>
                `;
                assignPersonnelListEl.appendChild(listItem);
                   });

            assignSearchInputEl.addEventListener('input', () => {
                const searchTerm = assignSearchInputEl.value.toLowerCase();
                const items = assignPersonnelListEl.getElementsByTagName('label');
                let visibleCount = 0;
                Array.from(items).forEach(item => {
                    const personName = item.textContent.toLowerCase();
                    if (personName.includes(searchTerm)) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                if(visibleCount === 0 && items.length > 0) {
                    noPersonnelMessageEl.textContent = "No personnel matching your search.";
                    noPersonnelMessageEl.style.display = 'block';
                } else if (items.length > 0) {
                     noPersonnelMessageEl.style.display = 'none';
                }
            });
        }

        function handleSendAssignment() {
            if (!currentTaskForAssignment) return;
            
            const originalTask = allTasksDataOriginal.find(t => t.id === currentTaskForAssignment.task.id);
            if (!originalTask) {
                showToast('Error', 'Original task data not found for assignment.', 'error');
                return;
            }


            const selectedPersonnelNames = [];
            const selectedPersonnelContacts = []; 

            const checkboxes = assignPersonnelListEl.querySelectorAll('input[type="checkbox"]:checked');
            checkboxes.forEach(cb => {
                                selectedPersonnelNames.push(cb.dataset.name);
                const personDetails = personnelData.find(p => p.id === cb.value);
                if (personDetails) {
                    if (personDetails.email) 
                                            selectedPersonnelContacts.push(`${personDetails.name} (Email: ${personDetails.email})`);
                    if (personDetails.phone) selectedPersonnelContacts.push(`${personDetails.name} (Phone: ${personDetails.phone})`);
                }
            });

            if (selectedPersonnelNames.length === 0) {
                showToast('Selection Required', 'Please select at least one person to assign the task.', 'warning');
                return;
            }
            
            const previousAssignees = originalTask.assignedTo.length > 0 ? 
                                      originalTask.assignedTo.join(', ') : 
                                      `Role: ${originalTask.responsibility}`;

            const logEntry = {
                timestamp: new Date().toISOString(),
                assignedBy: "System User", 
                assignedToNames: [...selectedPersonnelNames],
                action: originalTask.assignedTo.length > 0 ? "Re-assigned" : "Assigned",
                previousAssignees: previousAssignees 
            };
            if (!originalTask.assignmentLog) originalTask.assignmentLog = [];
            originalTask.assignmentLog.push(logEntry);


            originalTask.assignedTo = selectedPersonnelNames;
            applyAccessFiltersAndRender(); 
            
            showToast('Assignment Updated', 
                `${originalTask.equipmentName} assigned to: ${selectedPersonnelNames.join(', ')}.`, 
                'success');
            
            if(selectedPersonnelContacts.length > 0) {
                showToast('Notification Sent (Simulated)', 
                `Notifications would be sent to: ${selectedPersonnelContacts.slice(0,2).join('; ')}${selectedPersonnelContacts.length > 2 ? '...' : ''}`, 'info');
            }
            
            showToast('Tracking Log Updated', 
                `${logEntry.action} ${originalTask.equipmentName} to ${selectedPersonnelNames.join(', ')} by ${logEntry.assignedBy}.`, 'info');


            assignTaskModalInstance.hide();
            currentTaskForAssignment = null;
        }

        function populateRoleDropdown() {
            const assignedToRoleSelect = document.getElementById('assignedToRole');
            if (!assignedToRoleSelect) return;

            assignedToRoleSelect.innerHTML = '<option value="">Select Role/Group</option>'; 
            const uniqueRoles = [...new Set(personnelData.map(p => p.role))];
            uniqueRoles.sort().forEach(role => {
                const option = document.createElement('option');
                option.value = role;
                option.textContent = role;
                assignedToRoleSelect.appendChild(option);
            });
        }

        function simulateWeeklyReminders() {
            let reminderCount = 0;
            allTasksDataOriginal.forEach(task => {
                if (task.status === 'ongoing' || task.status === 'overdue') {
                    reminderCount++;
                    console.log(`REMINDER (Simulated): Email & Mobile notification sent for task: "${task.equipmentName}" (ID: ${task.id}), Unit: ${task.unitName}, Status: ${task.status}, Scheduled: ${formatDate(task.scheduledDate)}`);
                    if (reminderCount <= 3) {
                        showToast(`Reminder: ${task.equipmentName}`, `Status: ${task.status}. Unit: ${task.unitName}. Notification sent.`, 'info');
                    }
                }
            });

            if (reminderCount > 0) {
                showToast('Reminders Sent', `${reminderCount} reminder(s) for ongoing/overdue tasks have been simulated. Check console for details.`, 'success');
            } else {
                showToast('No Reminders Needed', 'No ongoing or overdue tasks requiring reminders at this time.', 'info');
            }
        }

        function populateHierarchicalAccessFilterDropdown() {
            hierarchicalAccessFilterSelect.innerHTML = '';

            const superAdminOpt = document.createElement('option');
            superAdminOpt.value = 'super_admin::'; 
            superAdminOpt.textContent = 'Super Admin View';
            superAdminOpt.classList.add('fw-bold');
            hierarchicalAccessFilterSelect.appendChild(superAdminOpt);

            const corporates = {};
            allTasksDataOriginal.forEach(task => {
                if (!corporates[task.corporateName]) {
                    corporates[task.corporateName] = {};
                }
                if (!corporates[task.corporateName][task.regionName]) {
                    corporates[task.corporateName][task.regionName] = [];
                }
                if (!corporates[task.corporateName][task.regionName].includes(task.unitName)) {
                    corporates[task.corporateName][task.regionName].push(task.unitName);
                }
            });

            Object.keys(corporates).sort().forEach(corpName => {
                const corpOpt = document.createElement('option');
                corpOpt.value = `corporate::${corpName}`;
                corpOpt.textContent = `Corporate: ${corpName} Admin`;
                corpOpt.classList.add('corporate-option');
                hierarchicalAccessFilterSelect.appendChild(corpOpt);

                Object.keys(corporates[corpName]).sort().forEach(regionName => {
                    const regionOpt = document.createElement('option');
                    regionOpt.value = `regional::${corpName}::${regionName}`;
                    regionOpt.textContent = `Regional: ${regionName} (${corpName}) Admin`;
                    regionOpt.classList.add('regional-option');
                    hierarchicalAccessFilterSelect.appendChild(regionOpt);

                    corporates[corpName][regionName].sort().forEach(unitName => {
                        const unitOpt = document.createElement('option');
                        unitOpt.value = `unit::${corpName}::${regionName}::${unitName}`;
                        unitOpt.textContent = `Unit: ${unitName} (${regionName}, ${corpName}) Admin`;
                        unitOpt.classList.add('unit-option');
                        hierarchicalAccessFilterSelect.appendChild(unitOpt);
                    });
                });
            });
            
             if (currentUserAccessLevel === 'super_admin') {
                hierarchicalAccessFilterSelect.value = 'super_admin::';
            } else if (currentAccessScope.unit) { 
                hierarchicalAccessFilterSelect.value = `unit::${currentAccessScope.corporate}::${currentAccessScope.region}::${currentAccessScope.unit}`;
            } else if (currentAccessScope.region) {
                 hierarchicalAccessFilterSelect.value = `regional::${currentAccessScope.corporate}::${currentAccessScope.region}`;
            } else if (currentAccessScope.corporate) {
                 hierarchicalAccessFilterSelect.value = `corporate::${currentAccessScope.corporate}`;
            }

        }
        
        function handleApplyAccessFilter() {
            const selectedValue = hierarchicalAccessFilterSelect.value;
            if (!selectedValue) return;

            const parts = selectedValue.split('::');
            currentUserAccessLevel = parts[0]; 
            
            currentAccessScope = { corporate: null, region: null, unit: null }; 

            if (currentUserAccessLevel === 'corporate') {
                currentAccessScope.corporate = parts[1];
            } else if (currentUserAccessLevel === 'regional') {
                currentAccessScope.corporate = parts[1];
                currentAccessScope.region = parts[2];
            } else if (currentUserAccessLevel === 'unit') {
                currentAccessScope.corporate = parts[1];
                currentAccessScope.region = parts[2];
                currentAccessScope.unit = parts[3];
            }
            
            handleResetAdvancedFilters(false);
            
            applyAccessFiltersAndRender();
            
            accessFilterModalInstance.hide();
            let scopeText = "All (Super Admin)";
            if(currentAccessScope.unit) scopeText = currentAccessScope.unit;
            else if(currentAccessScope.region) scopeText = `${currentAccessScope.region} (Region)`;
            else if(currentAccessScope.corporate) scopeText = `${currentAccessScope.corporate} (Corporate)`;
            showToast("View Changed", `Viewing data for: ${scopeText}`, "info");
        }

        function populateAdvancedFilterDropdowns(sourceData) {
            const statusOptions = [
                { value: "ongoing", text: "Ongoing" },
                { value: "overdue", text: "Overdue" },
                { value: "completed_pending", text: "Completed (Verification Due)" },
                { value: "verified", text: "Verified" }
            ];

            const populate = (containerId, items, currentSelections) => {
                const container = document.getElementById(containerId);
                const list = container.querySelector('.filter-options-list');
                list.innerHTML = '';
                const uniqueItems = [...new Set(items.filter(Boolean))].sort();

                if (uniqueItems.length === 0) {
                    list.innerHTML = '<small class="text-muted px-2">No options available</small>';
                } else {
                     uniqueItems.forEach(item => {
                                                const checked = currentSelections.includes(item) ? 'checked' : '';
                        const itemEl = document.createElement('div');
                        itemEl.className = 'filter-option-item';
                        itemEl.innerHTML = `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="${item}" id="adv-filter-${containerId}-${item.replace(/\s+/g, '-')}" ${checked}>
                                <label class="form-check-label" for="adv-filter-${containerId}-${item.replace(/\s+/g, '-')}">
                                    ${item}
                                </label>
                            </div>
                        `;
                        list.appendChild(itemEl);
                    });
                }
                updateDropdownToggle(containerId, currentSelections.length);
            };
            
            const populateStatus = (containerId, options, currentSelections) => {
                 const container = document.getElementById(containerId);
                const list = container.querySelector('.filter-options-list');
                list.innerHTML = '';
                 options.forEach(item => {
                    const checked = currentSelections.includes(item.value) ? 'checked' : '';
                    const itemEl = document.createElement('div');
                    itemEl.className = 'filter-option-item';
                    itemEl.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="${item.value}" id="adv-filter-status-${item.value}" ${checked}>
                            <label class="form-check-label" for="adv-filter-status-${item.value}">
                                ${item.text}
                            </label>
                        </div>
                    `;
                    list.appendChild(itemEl);
                });
                 updateDropdownToggle(containerId, currentSelections.length);
            };

            let filteredForCorp = sourceData;
            if (currentAdvancedFilters.corporate.length > 0) {
                filteredForCorp = sourceData.filter(t => currentAdvancedFilters.corporate.includes(t.corporateName));
            }
            populate('advFilterCorporateContainer', sourceData.map(t => t.corporateName), currentAdvancedFilters.corporate);
            
            let filteredForRegion = filteredForCorp;
            if (currentAdvancedFilters.region.length > 0) {
                filteredForRegion = filteredForCorp.filter(t => currentAdvancedFilters.region.includes(t.regionName));
            }
            populate('advFilterRegionContainer', filteredForCorp.map(t => t.regionName), currentAdvancedFilters.region);

            let filteredForUnit = filteredForRegion;
            if (currentAdvancedFilters.unit.length > 0) {
                filteredForUnit = filteredForRegion.filter(t => currentAdvancedFilters.unit.includes(t.unitName));
            }
            populate('advFilterUnitContainer', filteredForRegion.map(t => t.unitName), currentAdvancedFilters.unit);
            
            let filteredForDept = filteredForUnit;
            if(currentAdvancedFilters.department.length > 0) {
                filteredForDept = filteredForUnit.filter(t => currentAdvancedFilters.department.includes(t.departmentName));
            }
            populate('advFilterDepartmentContainer', filteredForUnit.map(t => t.departmentName), currentAdvancedFilters.department);

            populate('advFilterEquipmentContainer', filteredForDept.map(t => t.equipmentName), currentAdvancedFilters.equipment);
            
            populateStatus('advFilterStatusContainer', statusOptions, currentAdvancedFilters.status);
            
            // Populate date fields
            document.getElementById('advFilterFromDate').value = currentAdvancedFilters.fromDate;
            document.getElementById('advFilterToDate').value = currentAdvancedFilters.toDate;
        }

        
        applyAdvancedFiltersBtn.addEventListener('click', () => {
             const getSelected = (containerId) => {
                const container = document.getElementById(containerId);
                const checked = container.querySelectorAll('.filter-options-list input:checked');
                return Array.from(checked).map(cb => cb.value);
            };

            currentAdvancedFilters.corporate = getSelected('advFilterCorporateContainer');
            currentAdvancedFilters.region = getSelected('advFilterRegionContainer');
            currentAdvancedFilters.unit = getSelected('advFilterUnitContainer');
            currentAdvancedFilters.department = getSelected('advFilterDepartmentContainer');
            currentAdvancedFilters.equipment = getSelected('advFilterEquipmentContainer');
            currentAdvancedFilters.status = getSelected('advFilterStatusContainer');
            currentAdvancedFilters.fromDate = document.getElementById('advFilterFromDate').value;
            currentAdvancedFilters.toDate = document.getElementById('advFilterToDate').value;

            applyAccessFiltersAndRender(); 
            advancedFilterModalInstance.hide();
            showToast('Advanced Filters Applied', 'Data view updated.', 'info');
        });
        
        function handleResetAdvancedFilters(showMsg = true) {
            currentAdvancedFilters = { corporate: [], region: [], unit: [], department: [], equipment: [], status: [], fromDate: '', toDate: '' };
            
            const filterContainers = document.querySelectorAll('#advancedFilterModal .filter-dropdown-container');
            filterContainers.forEach(container => {
                container.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                container.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
                updateDropdownToggle(container.id, 0);
            });
            document.getElementById('advFilterFromDate').value = '';
            document.getElementById('advFilterToDate').value = '';

            const initialDataForFilters = allTasksDataOriginal.filter(task => {
                if (currentUserAccessLevel === 'super_admin') return true;
                if (currentUserAccessLevel === 'corporate') return task.corporateName === currentAccessScope.corporate;
                if (currentUserAccessLevel === 'regional') return task.corporateName === currentAccessScope.corporate && task.regionName === currentAccessScope.region;
                if (currentUserAccessLevel === 'unit') return task.corporateName === currentAccessScope.corporate && task.regionName === currentAccessScope.region && task.unitName === currentAccessScope.unit;
                return false;
            });
            populateAdvancedFilterDropdowns(initialDataForFilters);

            applyAccessFiltersAndRender();
            if (showMsg) {
                showToast('Advanced Filters Reset', 'Showing all data for current access level.', 'info');
            }
            updateAdvancedFilterBadge();
        }
        
        function updateDropdownToggle(containerId, count) {
            const container = document.getElementById(containerId);
            if(container) {
                                const badge = container.querySelector('.badge');
                if(badge) badge.textContent = count;
            }
        }

        function openRescheduleModal(taskData, row) {
            currentTaskForReschedule = { task: taskData, row: row };
            document.getElementById('rescheduleTaskId').value = taskData.id;
            document.getElementById('rescheduleEqName').textContent = taskData.equipmentName;
            document.getElementById('rescheduleCurrentDate').textContent = formatDate(taskData.scheduledDate);
            const dateInput = document.getElementById('rescheduleNewDate');
            dateInput.value = '';
            dateInput.min = new Date().toISOString().split("T")[0];
            document.getElementById('rescheduleNotes').value = '';
            rescheduleModalInstance.show();
        }

        function handleSaveReschedule() {
            if (!currentTaskForReschedule) return;
            const taskId = document.getElementById('rescheduleTaskId').value;
            const newDate = document.getElementById('rescheduleNewDate').value;
            const notes = document.getElementById('rescheduleNotes').value.trim();

            if (!newDate) {
                showToast('Invalid Date', 'Please select a new schedule date.', 'warning');
                return;
            }
            
            if (!notes) {
                showToast('Reason Required', 'Please provide a reason for rescheduling.', 'warning');
                return;
            }

            const originalTask = allTasksDataOriginal.find(t => t.id === taskId);
            if (originalTask) {
                originalTask.rescheduledFrom = originalTask.scheduledDate;
                originalTask.scheduledDate = newDate;
                originalTask.rescheduleNotes = notes; 

                const today = getDateWithOffset(0);
                const newScheduledDate = new Date(newDate.replace(/-/g, '/') + 'T00:00:00');
                if (newScheduledDate < today) {
                    originalTask.status = 'overdue';
                } else {
                    originalTask.status = 'ongoing';
                }
                
                applyAccessFiltersAndRender();
                rescheduleModalInstance.hide();
                showToast('Task Rescheduled', `${originalTask.equipmentName} has been rescheduled to ${formatDate(newDate)}.`, 'success');
                        } else {
                showToast('Error', 'Could not find the task to reschedule.', 'error');
            }
        }

        function openViewChecklistModal(taskData) {
            const modalBody = document.getElementById('viewChecklistModalBody');
            modalBody.innerHTML = ''; 

            const modalTitle = document.getElementById('viewChecklistModalLabel');
            modalTitle.textContent = `Checklist for: ${taskData.equipmentName}`;

            if (!taskData.checklistQuestions || taskData.checklistQuestions.length === 0) {
                modalBody.innerHTML = '<p class="text-muted">No checklist details recorded for this task.</p>';
                viewChecklistModalInstance.show();
                return;
            }

            taskData.checklistQuestions.forEach((q, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'checklist-item';

                let answerBadge = '<span class="badge bg-secondary">Not Answered</span>';
                if (q.answer) {
                    let badgeClass = '';
                    switch (q.answer) {
                        case 'yes': badgeClass = 'bg-success'; break;
                        case 'no': badgeClass = 'bg-danger'; break;
                        case 'na': badgeClass = 'bg-na'; break;
                    }
                    answerBadge = `<span class="badge ${badgeClass}">${q.answer.toUpperCase()}</span>`;
                }

                itemDiv.innerHTML = `
                    <div class="checklist-item-question">${index + 1}. ${q.text}</div>
                    <div class="checklist-item-answer">Answer: ${answerBadge}</div>
                    ${q.comment ? `<div class="checklist-item-comment"><strong>Comment:</strong> ${q.comment}</div>` : ''}
                `;
                modalBody.appendChild(itemDiv);
            });

            viewChecklistModalInstance.show();
        }

        function openViewChecklistModalById(taskId) {
            const taskData = allTasksDataOriginal.find(t => t.id === taskId);
            if (taskData) {
                openViewChecklistModal(taskData);
            }
        }

                function downloadHistoryAsPDF() {
            const downloadBtn = document.getElementById('downloadHistoryPdfBtn');
            const equipmentId = downloadBtn.dataset.equipmentId;
            const filename = `History_Report_${equipmentId || 'Equipment'}_${new Date().toISOString().slice(0,10)}.pdf`;
            const contentToCapture = document.querySelector('#viewHistoryModal .history-page-wrapper');
            
            showToast('Generating PDF', 'Please wait, your report is being created...', 'info');

            html2canvas(contentToCapture, {
                scale: 2, useCORS: true, logging: false,
                windowWidth: contentToCapture.scrollWidth,
                windowHeight: contentToCapture.scrollHeight
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                
                const pdf = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const canvasAspectRatio = canvas.width / canvas.height;
                let imgWidth = pdfWidth - 20; 
                let imgHeight = imgWidth / canvasAspectRatio;
                let heightLeft = imgHeight;
                let position = 10;

                pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                heightLeft -= (pdfHeight - 20);

                while (heightLeft > 0) {
                    position = position - (pdfHeight - 20);
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= (pdfHeight - 20);
                }

                pdf.save(filename);
                showToast('Download Ready', `Successfully generated ${filename}.`, 'success');
            }).catch(err => {
                console.error("PDF Generation Error:", err);
                showToast('Error', 'Could not generate PDF report. See console for details.', 'error');
            });
        }
        
        function setupAdvancedFilterDropdowns() {
            const filterContainers = document.querySelectorAll('#advancedFilterModal .filter-dropdown-container');
            filterContainers.forEach(container => {
                const toggle = container.querySelector('.filter-dropdown-toggle');
                const panel = container.querySelector('.filter-dropdown-panel');
                const searchInput = container.querySelector('.filter-dropdown-search');
                const optionsList = container.querySelector('.filter-options-list');

                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    filterContainers.forEach(otherContainer => {
                        if (otherContainer !== container) {
                            otherContainer.querySelector('.filter-dropdown-panel').classList.remove('show');
                        }
                    });
                    panel.classList.toggle('show');
                });

                searchInput.addEventListener('keyup', () => {
                    const filter = searchInput.value.toLowerCase();
                    const items = optionsList.querySelectorAll('.filter-option-item');
                    items.forEach(item => {
                        const label = item.querySelector('label');
                        if (label.textContent.toLowerCase().includes(filter)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });

                optionsList.addEventListener('change', (e) => {
                    if (e.target.type === 'checkbox') {
                         const checkedCount = optionsList.querySelectorAll('input:checked').length;
                         updateDropdownToggle(container.id, checkedCount);
                    }
                });
            });

            document.addEventListener('click', (e) => {
                const openPanel = document.querySelector('.filter-dropdown-panel.show');
                if (openPanel && !openPanel.parentElement.contains(e.target)) {
                    openPanel.classList.remove('show');
                }
            });
        }
        
        function updateAdvancedFilterBadge() {
            const activeDropdownFilters = Object.keys(currentAdvancedFilters)
                .filter(key => Array.isArray(currentAdvancedFilters[key]))
                .reduce((acc, key) => acc + (currentAdvancedFilters[key].length > 0 ? 1 : 0), 0);

            const isDateFilterActive = currentAdvancedFilters.fromDate || currentAdvancedFilters.toDate;
            const totalActiveFilters = activeDropdownFilters + (isDateFilterActive ? 1 : 0);
            
            if (totalActiveFilters > 0) {
                advFilterCountBadge.textContent = totalActiveFilters;
                advFilterCountBadge.style.display = 'inline-block';
            } else {
                advFilterCountBadge.style.display = 'none';
            }
        }
        
        // --- DYNAMIC CHART FUNCTIONS ---
        
        function setupTimelineInteractions() {
            const timePeriodSelect = document.getElementById('timePeriodSelect');
            const timeRangeInput = document.getElementById('timeRangeInput');
            const timeRangeLabel = document.getElementById('timeRangeLabel');
            const updateTimelineBtn = document.getElementById('updateTimelineBtn');
            const downloadPngBtn = document.getElementById('downloadPngBtn');
            const downloadPdfBtn = document.getElementById('downloadPdfBtn');
            const chartContainer = document.getElementById('chartToDownload');

            timePeriodSelect.addEventListener('change', (e) => {
                const period = e.target.value;
                let label = '';
                switch(period) {
                    case 'daily': label = 'Days'; break;
                    case 'weekly': label = 'Weeks'; break;
                    case 'monthly': label = 'Months'; break;
                    case 'yearly': label = 'Years'; break;
                }
                timeRangeLabel.textContent = label;
                // Task 2: Default behavior - trigger update when period changes.
                document.getElementById('updateTimelineBtn').click(); 
            });
            
            timeRangeInput.addEventListener('change', () => {
                const period = timePeriodSelect.value;
                if(period === 'monthly') timeRangeInput.value = Math.max(1, Math.min(12, timeRangeInput.value));
            });

            updateTimelineBtn.addEventListener('click', updateTimelineChart);
            downloadPngBtn.addEventListener('click', () => downloadChartAs('png'));
            downloadPdfBtn.addEventListener('click', () => downloadChartAs('pdf'));

            function downloadChartAs(format) {
                const filename = `Cleaning_Schedule_Timeline_${new Date().toISOString().slice(0,10)}.${format}`;
                showToast('Generating Image...', 'Please wait while the chart is being prepared.', 'info');
                html2canvas(chartContainer, { scale: 2, backgroundColor: '#ffffff' }).then(canvas => {
                    if (format === 'png') {
                        const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
                        const link = document.createElement('a');
                        link.download = filename;
                        link.href = image;
                        link.click();
                        showToast('Download Ready', `${filename} has been downloaded.`, 'success');
                    } else if (format === 'pdf') {
                        const imgData = canvas.toDataURL('image/png');
                        const { jsPDF } = window.jspdf;
                        const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = pdf.internal.pageSize.getHeight();
                        const canvasWidth = canvas.width;
                        const canvasHeight = canvas.height;
                                                const canvasAspectRatio = canvasWidth / canvasHeight;
                        
                                                
                        let imgWidth = pdfWidth - 20; 
                        let imgHeight = imgWidth / canvasAspectRatio;

                        if (imgHeight > pdfHeight - 20) {
                            imgHeight = pdfHeight - 20;
                            imgWidth = imgHeight * canvasAspectRatio;
                        }

                        const xPos = (pdfWidth - imgWidth) / 2;
                        const yPos = (pdfHeight - imgHeight) / 2;

                        pdf.addImage(imgData, 'PNG', xPos, yPos, imgWidth, imgHeight);
                        pdf.save(filename);
                        showToast('Download Ready', `${filename} has been downloaded.`, 'success');
                    }
                }).catch(err => {
                    console.error("Chart download error:", err);
                    showToast('Download Failed', 'Could not generate the chart image.', 'error');
                });
            }
        }

        function updateTimelineChart() {
            const period = document.getElementById('timePeriodSelect').value;
            const range = parseInt(document.getElementById('timeRangeInput').value, 10);
            
            const barsContainer = document.querySelector('.bars-container');
            const xAxisLabelsContainer = document.querySelector('.x-axis-labels');
            const yAxisContainer = document.querySelector('.y-axis');
            const yAxisRightContainer = document.querySelector('.y-axis-right');
            const chartTitleEl = document.querySelector('.chart-title');
            const lineCanvas = document.getElementById('lineChartCanvas');
            const legendContainer = document.querySelector('.legend');
            
            barsContainer.innerHTML = '';
            xAxisLabelsContainer.innerHTML = '';
            yAxisContainer.innerHTML = '';
            yAxisRightContainer.innerHTML = '';
            legendContainer.innerHTML = ''; 

            const ctx = lineCanvas.getContext('2d');
            
            // Debounce resize to prevent flicker
            setTimeout(() => {
                if (barsContainer.offsetWidth > 0 && barsContainer.offsetHeight > 0) {
                    ctx.canvas.width = barsContainer.offsetWidth;
                    ctx.canvas.height = barsContainer.offsetHeight;
                    ctx.clearRect(0, 0, lineCanvas.width, lineCanvas.height);
                } else {
                    return; // Don't draw if container isn't visible
                }

                // Task 2: By default, graph shows latest two timelines based on selected period
                const now = new Date('2025-07-26T12:00:00Z');
                now.setHours(23, 59, 59, 999); 
                
                const timeBuckets = [];
                for (let i = 0; i < range; i++) {
                    const end = new Date(now);
                    const start = new Date(now);
                    let label = '';
                    let labelOptions = {};

                    if (period === 'daily') {
                        end.setDate(now.getDate() - i);
                        start.setDate(now.getDate() - i); start.setHours(0, 0, 0, 0);
                        labelOptions = { month: 'short', day: 'numeric' };
                    } else if (period === 'weekly') {
                        const weekEndDate = new Date(now);
                        weekEndDate.setDate(now.getDate() - (i * 7));
                        const weekStartDate = new Date(weekEndDate);
                        weekStartDate.setDate(weekEndDate.getDate() - 6);
                        
                        end.setTime(weekEndDate.getTime());
                        start.setTime(weekStartDate.getTime());
                        start.setHours(0, 0, 0, 0);
                        
                        label = `${start.toLocaleDateString(undefined, {month:'short', day:'numeric'})} - ${end.toLocaleDateString(undefined, {month:'short', day:'numeric'})}`;
                    } else if (period === 'monthly') {
                        end.setMonth(now.getMonth() - i, now.getDate());
                        start.setMonth(now.getMonth() - i, 1); start.setHours(0, 0, 0, 0);
                        labelOptions = { month: 'short', year: '2-digit' };
                    } else if (period === 'yearly') {
                        end.setFullYear(now.getFullYear() - i, 11, 31);
                        start.setFullYear(now.getFullYear() - i, 0, 1);
                        start.setHours(0, 0, 0, 0);
                        labelOptions = { year: 'numeric' };
                    }
                    if (!label) {
                       label = end.toLocaleDateString(undefined, labelOptions);
                    }
                    timeBuckets.push({ start, end, label });
                }
                timeBuckets.reverse();
                
                let groupingKey = 'corporateName';
                let chartTitle = "Status by Corporate";
                if (currentAdvancedFilters.equipment.length > 0) {
                    groupingKey = 'equipmentName'; chartTitle = "Status by Equipment";
                } else if (currentAdvancedFilters.department.length > 0) {
                    groupingKey = 'equipmentName'; chartTitle = "Status by Equipment in Selected Department(s)";
                } else if (currentAdvancedFilters.unit.length > 0) {
                    groupingKey = 'departmentName'; chartTitle = "Status by Department in Selected Unit(s)";
                } else if (currentAdvancedFilters.region.length > 0) {
                    groupingKey = 'unitName'; chartTitle = "Status by Unit in Selected Region(s)";
                } else if (currentAdvancedFilters.corporate.length > 0) {
                    groupingKey = 'regionName'; chartTitle = "Status by Region in Selected Corporate(s)";
                }
                chartTitleEl.textContent = chartTitle;


                const tasksByGroup = tasksData.reduce((acc, task) => {
                    const key = task[groupingKey] || 'Uncategorized';
                    if (!acc[key]) acc[key] = [];
                    acc[key].push(task);
                    return acc;
                }, {});
                
                const groupNames = Object.keys(tasksByGroup).sort();

                const processedChartData = groupNames.map(groupName => {
                    const groupTasks = tasksByGroup[groupName];
                    const dataPoints = timeBuckets.map(bucket => {
                        const tasksInBucket = groupTasks.filter(task => {
                            const taskDate = new Date(task.scheduledDate);
                            return taskDate >= bucket.start && taskDate <= bucket.end;
                        });
                        return {
                            label: bucket.label,
                            completed: tasksInBucket.filter(t => t.status === 'verified').length,
                            overdue: tasksInBucket.filter(t => t.status === 'overdue').length,
                            ongoing: tasksInBucket.filter(t => t.status === 'ongoing' || (t.status === 'completed' && t.verificationStatus === 'pending')).length,
                        };
                    });
                    return { groupName: groupName, dataPoints: dataPoints };
                });

                if (groupNames.length === 0) {
                    barsContainer.innerHTML = `<div class="text-center text-muted p-5 w-100">No data available for the current filters to display in the chart.</div>`;
                     xAxisLabelsContainer.innerHTML = '';
                     yAxisContainer.innerHTML = '';
                     legendContainer.innerHTML = '';
                    return;
                }
                
                const allPoints = processedChartData.flatMap(d => d.dataPoints);
                const totalCompleted = allPoints.reduce((sum, p) => sum + p.completed, 0);
                const totalOverdue = allPoints.reduce((sum, p) => sum + p.overdue, 0);
                const totalOngoing = allPoints.reduce((sum, p) => sum + p.ongoing, 0);
                const numBucketsWithData = timeBuckets.length * groupNames.length;

                const avgCompleted = numBucketsWithData > 0 ? totalCompleted / numBucketsWithData : 0;
                const avgOverdue = numBucketsWithData > 0 ? totalOverdue / numBucketsWithData : 0;
                const avgOngoing = numBucketsWithData > 0 ? totalOngoing / numBucketsWithData : 0;


                const maxCount = Math.max(10, ...allPoints.map(p => p.completed + p.overdue + p.ongoing));
                const yAxisMax = Math.ceil(maxCount / 5) * 5; 
                const scaleFactor = 280 / yAxisMax;

                // Render Y-Axis
                for (let i = 0; i <= yAxisMax; i += Math.max(1, Math.round(yAxisMax / 5))) {
                     if (i > yAxisMax) continue;
                     const labelSpan = document.createElement('span');
                     labelSpan.textContent = i;
                     yAxisContainer.appendChild(labelSpan);
                }

                // Render Bars and X-Axis Labels for each group
                processedChartData.forEach(groupData => {
                    const barGroupContainer = document.createElement('div');
                    barGroupContainer.className = 'bars-container-group';

                    const xLabelGroupContainer = document.createElement('div');
                    xLabelGroupContainer.className = 'x-axis-region';
                    xLabelGroupContainer.innerHTML = `<div class="x-axis-region-name">${groupData.groupName}</div>`;
                    
                    const monthsContainer = document.createElement('div');
                    monthsContainer.className = 'x-axis-months';

                    groupData.dataPoints.forEach(dataPoint => {
                        const barDiv = document.createElement('div');
                        barDiv.className = 'bar';
                        barDiv.title = `${groupData.groupName} - ${dataPoint.label}\nCompleted: ${dataPoint.completed}\nOverdue: ${dataPoint.overdue}\nOngoing: ${dataPoint.ongoing}`;
                        
                        const completedHeight = dataPoint.completed * scaleFactor;
                        const overdueHeight = dataPoint.overdue * scaleFactor;
                        const ongoingHeight = dataPoint.ongoing * scaleFactor;
                        
                        const createSegment = (value, height, className) => {
                            const segment = document.createElement('div');
                            segment.className = `bar-segment ${className}`;
                            segment.style.height = `${height}px`;
                            segment.title = `${value} ${className.split(' ')[0]}`;
                            // Task 1: Add data label if segment is tall enough
                            if (height > 18 && value > 0) {
                                segment.innerHTML = `<span class="data-label">${value}</span>`;
                            }
                            return segment;
                        };

                        barDiv.appendChild(createSegment(dataPoint.ongoing, ongoingHeight, 'ongoing'));
                        barDiv.appendChild(createSegment(dataPoint.overdue, overdueHeight, 'overdue'));
                        barDiv.appendChild(createSegment(dataPoint.completed, completedHeight, 'completed'));
                        
                        barGroupContainer.appendChild(barDiv);

                        const monthLabelDiv = document.createElement('div');
                        monthLabelDiv.textContent = dataPoint.label;
                        monthsContainer.appendChild(monthLabelDiv);
                    });

                    xLabelGroupContainer.appendChild(monthsContainer);
                    xAxisLabelsContainer.appendChild(xLabelGroupContainer);
                    barsContainer.appendChild(barGroupContainer);
                });
                
                // Task 1: Draw average lines on canvas and add labels to the right Y-axis
                const drawLineAndLabel = (avgValue, color, labelText) => {
                    if (avgValue > yAxisMax) return; // Don't draw if average is off the chart
                    const yPos = lineCanvas.height - (avgValue * scaleFactor);
                    
                    // Draw line on canvas
                    ctx.beginPath();
                    ctx.setLineDash([5, 5]);
                    ctx.moveTo(0, yPos);
                    ctx.lineTo(lineCanvas.width, yPos);
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 1.5;
                    ctx.stroke();
                    ctx.setLineDash([]); // Reset for next line

                    // Add label to the right y-axis div
                    const labelDiv = document.createElement('div');
                    labelDiv.className = 'avg-label';
                    labelDiv.style.top = `${yPos}px`;
                    labelDiv.style.borderColor = color;
                    labelDiv.style.color = color;
                    labelDiv.textContent = `${labelText}: ${avgValue.toFixed(1)}`;
                    yAxisRightContainer.appendChild(labelDiv);
                };
                
                drawLineAndLabel(avgCompleted, '#2b5d73', 'Avg Completed');
                drawLineAndLabel(avgOverdue, '#e87a33', 'Avg Overdue');
                drawLineAndLabel(avgOngoing, '#1e6a45', 'Avg Ongoing');


                // Rebuild legend
                legendContainer.innerHTML = `
                    <div class="legend-item"><div class="legend-color" style="background-color: #2b5d73;"></div>Completed</div>
                    <div class="legend-item"><div class="legend-color" style="background-color: #e87a33;"></div>Overdue</div>
                    <div class="legend-item"><div class="legend-color" style="background-color: #1e6a45;"></div>Ongoing/Pending</div>
                `;
            }, 100); // Small delay to ensure DOM is ready
        }
        
        // BUGFIX: Implement the missing openHistoryModal function
        function openHistoryModal(taskData) {
            if (!viewHistoryModalInstance || !taskData) return;

            // --- 1. Populate Header and Details Card ---
            document.getElementById('historyEquipmentName').textContent = taskData.equipmentName;
            document.getElementById('historyEquipmentID').textContent = taskData.equipmentId;
            document.getElementById('historyEquipmentMake').textContent = taskData.equipmentMake || '--';
            document.getElementById('historyEquipmentLocation').textContent = taskData.location;
            document.getElementById('historyEquipmentInstallDate').textContent = taskData.equipmentInstallDate ? formatDate(taskData.equipmentInstallDate) : '--';
            document.getElementById('historyEquipmentIcon').className = `fas ${taskData.equipmentIcon || 'fa-tools'} fa-3x text-muted`;
            document.getElementById('downloadHistoryPdfBtn').dataset.equipmentId = taskData.equipmentId;
            
            const breadcrumbs = document.getElementById('historyBreadcrumbs');
            breadcrumbs.innerHTML = `${taskData.corporateName} <span>></span> ${taskData.regionName} <span>></span> ${taskData.unitName}`;

            // --- 2. Fetch and Render History ---
            const historyTableBody = document.getElementById('historyScheduleTableBody');
            const timeFilter = document.getElementById('time-filter');

            const renderHistory = () => {
                const equipmentHistory = allTasksDataOriginal
                    .filter(t => t.equipmentId === taskData.equipmentId)
                    .sort((a, b) => new Date(b.scheduledDate) - new Date(a.scheduledDate)); // Most recent first

                let filteredHistory = equipmentHistory;
                const filterValue = timeFilter.value;
                const now = new Date();
                if (filterValue === 'last-7-days') {
                    const sevenDaysAgo = new Date(now.setDate(now.getDate() - 7));
                    filteredHistory = equipmentHistory.filter(t => new Date(t.scheduledDate) >= sevenDaysAgo);
                } else if (filterValue === 'last-30-days') {
                    const thirtyDaysAgo = new Date(now.setDate(now.getDate() - 30));
                    filteredHistory = equipmentHistory.filter(t => new Date(t.scheduledDate) >= thirtyDaysAgo);
                }

                historyTableBody.innerHTML = '';
                if (filteredHistory.length === 0) {
                    historyTableBody.innerHTML = `<tr><td colspan="5" class="text-center text-muted p-4">No history records found for this period.</td></tr>`;
                    return;
                }

                filteredHistory.forEach(task => {
                    const tr = document.createElement('tr');
                    
                    let statusBadge = `<span class="status-badge" style="background-color: #e5e7eb; color: #4b5563;">${task.status}</span>`;
                    if (task.status === 'verified') statusBadge = `<span class="status-badge completed">Verified</span>`;
                    else if (task.status === 'completed') statusBadge = `<span class="status-badge" style="background-color: #e0f2fe; color: #0ea5e9;">Pending Verification</span>`;
                    else if (task.status === 'overdue') statusBadge = `<span class="status-badge" style="background-color: #fee2e2; color: #ef4444;">Overdue</span>`;

                    tr.innerHTML = `
                        <td>
                            <div class="cell-main-text">${formatDate(task.scheduledDate)}</div>
                            <div class="text-xs text-gray-500">Frequency: ${task.frequency}</div>
                        </td>
                        <td>
                            ${task.completedBy ? `
                            <div class="cell-main-text">${task.completedBy}</div>
                            <div class="text-xs text-gray-500">${formatDate(task.completionDate, true)}</div>
                            ` : 'N/A'}
                        </td>
                        <td>${statusBadge}</td>
                        <td>
                             ${task.verifiedBy ? `
                            <div class="verification-details">
                                <div class="cell-main-text">${task.verifiedBy}</div>
                                <div class="text-xs text-gray-500">${formatDate(task.verificationDate, true)}</div>
                                ${task.verificationNotes ? `<div class="verification-comment">${task.verificationNotes}</div>` : ''}
                            </div>
                             ` : 'N/A'}
                        </td>
                        <td>
                            ${(task.checklistQuestions && task.checklistQuestions.length > 0) ? `
                            <a href="#" class="view-checklist-btn" data-task-id="${task.id}">
                                <svg class="icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM10.5 12h.008v.008h-.008V12zm0 3h.008v.008h-.008V15zm0 3h.008v.008h-.008V18z" /></svg>
                                View
                            </a>
                            ` : '<span class="text-gray-400">N/A</span>'}
                        </td>
                    `;
                    historyTableBody.appendChild(tr);
                });
            };

            // --- 3. Add Event Listeners and Show Modal ---
            timeFilter.removeEventListener('change', renderHistory); // Avoid duplicate listeners
            timeFilter.addEventListener('change', renderHistory);
            
            historyTableBody.removeEventListener('click', handleHistoryChecklistClick);
            historyTableBody.addEventListener('click', handleHistoryChecklistClick);
            
            function handleHistoryChecklistClick(e) {
                const btn = e.target.closest('.view-checklist-btn');
                if (btn) {
                    e.preventDefault();
                    const taskId = btn.dataset.taskId;
                    const task = allTasksDataOriginal.find(t => t.id === taskId);
                    if (task) {
                        openViewChecklistModal(task);
                    }
                }
            }
            
            renderHistory(); // Initial render
            viewHistoryModalInstance.show();
        }

        /**
         * Generates the HTML for the detailed PDF report based on the currently filtered data.
         * @returns {string} The complete HTML string for the report.
         */
        function generateReportHTML() {
            const visibleTasks = tasksData; // Use the currently filtered data
            
            // Group checklist questions by category for the report
            const categorizeQuestion = (questionText) => {
                const text = questionText.toLowerCase();
                if (text.includes('door') || text.includes('gasket') || text.includes('outer body')) return 'external';
                if (text.includes('chamber') || text.includes('racks') || text.includes('internal')) return 'internal';
                return 'final';
            };

            let tableRowsHTML = visibleTasks.map(task => {
                // Prepare checklist data by category
                const checklistByCategory = { external: [], internal: [], final: [] };
                if (task.checklistQuestions && task.checklistQuestions.length > 0) {
                    task.checklistQuestions.forEach(q => {
                        const category = categorizeQuestion(q.text);
                        checklistByCategory[category].push(
                            `<div class="qa-item">
                                <span class="question">${q.text}</span>
                                <span class="answer">Ans: ${q.answer ? q.answer.charAt(0).toUpperCase() + q.answer.slice(1) : 'N/A'}</span>
                            </div>`
                        );
                    });
                }

                // Prepare evidence HTML
                const evidenceHTML = (task.evidence && task.evidence.length > 0)
                    ? task.evidence.map(ev => 
                        `<a href="#" class="evidence-link">
                            <img src="${ev.url || 'https://via.placeholder.com/100x75.png?text=No+Image'}" alt="${ev.name || 'Evidence'}" class="evidence-image">
                        </a>`
                      ).join('')
                    : 'N/A';

                return `
                <tr>
                    <td>
                        <div class="detail-list">
                            <div class="detail-item">Corporate:<span class="detail-value">${task.corporateName || 'N/A'}</span></div>
                            <div class="detail-item">Regional:<span class="detail-value">${task.regionName || 'N/A'}</span></div>
                            <div class="detail-item">Unit:<span class="detail-value">${task.unitName || 'N/A'}</span></div>
                            <div class="detail-item">Department:<span class="detail-value">${task.departmentName || 'N/A'}</span></div>
                            <div class="detail-item">Location:<span class="detail-value">${task.location || 'N/A'}</span></div>
                        </div>
                    </td>
                    <td>
                        <div class="detail-list">
                            <div class="detail-item">Name:<span class="detail-value">${task.equipmentName || 'N/A'}</span></div>
                            <div class="detail-item">ID:<span class="detail-value">${task.equipmentId || 'N/A'}</span></div>
                            <div class="detail-item">Make/Brand:<span class="detail-value">${task.equipmentMake || 'N/A'}</span></div>
                            <div class="detail-item">Install Date:<span class="detail-value">${task.equipmentInstallDate ? formatDate(task.equipmentInstallDate) : 'N/A'}</span></div>
                            <div class="detail-item">Responsibility:<span class="detail-value">${task.responsibility || 'N/A'}</span></div>
                            <div class="detail-item">Frequency:<span class="detail-value">${task.frequency || 'N/A'}</span></div>
                        </div>
                    </td>
                    <td>
                        <div class="timeline-details">
                            <div>Scheduled: <span class="cell-main-text">${formatDate(task.scheduledDate)}</span></div>
                            ${task.completedDate ? `<div>Completed: <span class="cell-main-text">${formatDate(task.completionDate, true)}</span></div>` : ''}
                            ${task.completedBy ? `<div class="by-line">By: ${task.completedBy}</div>` : ''}
                            <div class="status-wrapper"><span class="status-badge completed">${task.status.charAt(0).toUpperCase() + task.status.slice(1)}</span></div>
                        </div>
                    </td>
                    <td>
                        <div class="verification-details">
                            ${task.verifiedBy ? `<div class="cell-main-text">${formatDate(task.verificationDate, true)}</div>
                            <div>Verified by: ${task.verifiedBy}</div>` : 'N/A'}
                            ${task.verificationNotes ? `<div class="verification-comment">${task.verificationNotes}</div>` : ''}
                        </div>
                    </td>
                    <td><div class="qa-container">${checklistByCategory.external.join('') || 'N/A'}</div></td>
                    <td><div class="qa-container">${checklistByCategory.internal.join('') || 'N/A'}</div></td>
                    <td><div class="qa-container">${checklistByCategory.final.join('') || 'N/A'}</div></td>
                    <td><div class="evidence-images">${evidenceHTML}</div></td>
                </tr>
                `;
            }).join('');

            // Return the full HTML structure
            return `
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Cleaning Schedule Report</title>
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    :root { --primary-brand: #4f46e5; --status-green: #10b981; --status-green-bg: #e7f8f3; --status-green-dark: #059669; --text-primary: #111827; --text-secondary: #4b5563; --text-muted: #6b7280; --bg-page: #f9fafb; --bg-card: #ffffff; --bg-muted: #f3f4f6; --border-color: #e5e7eb; --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05); }
                    body { font-family: 'Inter', sans-serif; background-color: var(--bg-card); color: var(--text-secondary); margin: 0; padding: 1rem; }
                    .schedule-container { width: 100%; border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; }
                    .schedule-header { padding: 16px 24px; border-bottom: 1px solid var(--border-color); }
                    .schedule-header h2 { font-size: 18px; font-weight: 600; color: var(--text-primary); margin: 0; }
                    .schedule-table { width: 100%; border-collapse: collapse; }
                    .schedule-table thead th { text-align: left; padding: 12px 24px; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; background-color: var(--bg-muted); white-space: nowrap; }
                    .schedule-table tbody td { padding: 12px 24px; font-size: 12px; color: var(--text-secondary); vertical-align: top; border-bottom: 1px solid var(--border-color); }
                    .schedule-table tbody tr:last-child td { border-bottom: none; }
                    .cell-main-text { color: var(--text-primary); font-weight: 500; }
                    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-weight: 500; font-size: 12px; text-transform: uppercase; }
                    .status-badge.completed { background-color: var(--status-green-bg); color: var(--status-green); }
                    .verification-details, .timeline-details, .qa-container, .detail-list { display: flex; flex-direction: column; gap: 4px; }
                    .verification-comment { font-style: italic; color: var(--text-muted); border-left: 2px solid var(--border-color); padding-left: 8px; }
                    .qa-item .question { font-size: 11px; } .qa-item .answer { font-weight: 600; font-size: 12px; color: var(--status-green-dark); }
                    .detail-item { white-space: nowrap; } .detail-value { font-weight: 500; color: var(--text-primary); margin-left: 0.5em; }
                    .evidence-images { display: flex; flex-wrap: wrap; gap: 8px; } .evidence-image { width: 80px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color); }
                </style>
            </head>
            <body>
                <div class="schedule-container" id="report-content">
                    <header class="schedule-header"><h2>Cleaning Schedule Report</h2></header>
                    <table class="schedule-table">
                        <thead>
                            <tr><th>Hierarchy</th><th>Details</th><th>Task & Status</th><th>Verification & Notes</th><th>External Checks</th><th>Internal Checks</th><th>Final Checks</th><th>Evidence</th></tr>
                        </thead>
                        <tbody>${tableRowsHTML}</tbody>
                    </table>
                </div>
            </body>
            </html>
            `;
        }

        /**
         * Handles the click on the main "Download Report" button.
         * Generates a detailed report and initiates a PDF download.
         */
        function handleDownloadReport() {
            const reportBtn = document.getElementById('downloadReportBtn');
            const originalBtnContent = reportBtn.innerHTML;

            showToast('Generating Report', 'Please wait, your detailed PDF report is being created...', 'info');
            reportBtn.disabled = true;
            reportBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
            
            // Generate the HTML for the report in a hidden iframe to render it
            const reportHTML = generateReportHTML();
            const iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.left = '-9999px';
            iframe.style.top = '-9999px';
            document.body.appendChild(iframe);

            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(reportHTML);
            iframe.contentWindow.document.close();

            iframe.onload = () => {
                setTimeout(() => { // Timeout ensures all assets (like fonts) are loaded
                    const reportElement = iframe.contentWindow.document.getElementById('report-content');

                    html2canvas(reportElement, {
                        scale: 2,
                        useCORS: true,
                        width: reportElement.scrollWidth,
                        height: reportElement.scrollHeight,
                        windowWidth: reportElement.scrollWidth,
                        windowHeight: reportElement.scrollHeight
                    }).then(canvas => {
                        const { jsPDF } = window.jspdf;
                        const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a3' });
                        
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = pdf.internal.pageSize.getHeight();
                        const ratio = canvas.width / canvas.height;
                        
                        let imgWidth = pdfWidth - 20; // with margin
                        let imgHeight = imgWidth / ratio;

                        // If height is too large, scale based on height instead
                        if (imgHeight > pdfHeight - 20) {
                            imgHeight = pdfHeight - 20;
                            imgWidth = imgHeight * ratio;
                        }
                        
                        const xOffset = (pdfWidth - imgWidth) / 2;
                        const yOffset = (pdfHeight - imgHeight) / 2;
                        
                        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', xOffset, yOffset, imgWidth, imgHeight);
                        pdf.save(`Cleaning_Report_${new Date().toISOString().slice(0,10)}.pdf`);
                        
                        showToast('Download Ready', 'Report has been successfully generated.', 'success');
                    }).catch(err => {
                        console.error("Error generating PDF report:", err);
                        showToast('Error', 'Could not generate the PDF. Please check the console.', 'error');
                    }).finally(() => {
                        reportBtn.disabled = false;
                        reportBtn.innerHTML = originalBtnContent;
                        document.body.removeChild(iframe);
                    });
                }, 500); // 500ms delay
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            console.log("DOM Loaded. Initializing...");
            try {
                addScheduleModalInstance = new bootstrap.Modal(document.getElementById('addScheduleModal'));
                verificationModalInstance = new bootstrap.Modal(document.getElementById('verificationModal'));
                taskAttendModalInstance = new bootstrap.Modal(document.getElementById('taskAttendModal'));
                assignTaskModalInstance = new bootstrap.Modal(document.getElementById('assignTaskModal'));
                rescheduleModalInstance = new bootstrap.Modal(document.getElementById('rescheduleTaskModal'));
                accessFilterModalInstance = new bootstrap.Modal(document.getElementById('accessFilterModal'));
                advancedFilterModalInstance = new bootstrap.Modal(document.getElementById('advancedFilterModal'));
                viewChecklistModalInstance = new bootstrap.Modal(document.getElementById('viewChecklistModal'));
                viewHistoryModalInstance = new bootstrap.Modal(document.getElementById('viewHistoryModal'));

                const galleryModalEl = document.getElementById('taskMediaGalleryModalInModal');
                if (galleryModalEl) {
                     taskAttend_mediaGalleryModalInstance = new bootstrap.Modal(galleryModalEl);
                } else { console.error("Media Gallery Modal element not found!"); }
            } catch (error) { console.error("Modal init error:", error); }

            populateRoleDropdown(); 

            try {
                verifierSignaturePad = setupSignaturePad('verifierSignatureCanvas', 'verifierSignaturePlaceholder', 'clearVerifierSignatureBtn');
                globalVerifyModal_SignaturePad = setupSignaturePad('globalModalVerifierSignatureCanvas', 'globalModalSignaturePlaceholderText', 'globalModalClearVerifierSignatureBtn');
                
                const taskAttendModalEl = document.getElementById('taskAttendModal');
                if (taskAttendModalEl) {
                    taskAttendModalEl.addEventListener('shown.bs.modal', () => {
                        if (!taskAttend_SignaturePad) { 
                            taskAttend_SignaturePad = setupSignaturePad('modalSignatureCanvas', 'modalSignaturePlaceholder', 'modalClearSignatureBtn');
                        } else { 
                            taskAttend_SignaturePad.clear();
                            if (document.getElementById('modalSignaturePlaceholder')) {
                                document.getElementById('modalSignaturePlaceholder').style.display = 'block';
                            }
                        }
                        const modalCanvas = document.getElementById('modalSignatureCanvas');
                        if (modalCanvas && taskAttend_SignaturePad) {
                            setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 50);
                        }
                    });
                }

             } catch (error) { console.error("Sig pad init error:", error); }

            initializeSampleDataAndTable(); 
            setupGlobalVerifyModalListeners();
            setupTaskAttendModalListeners(); 
            setupAdvancedFilterDropdowns();
            setupTimelineInteractions();

            if (mainSearchBox) mainSearchBox.addEventListener('input', (e) => {
                mainSearchTerm = e.target.value.toLowerCase();
                applyAccessFiltersAndRender();
            });
            if (applyAccessFilterBtn) applyAccessFilterBtn.addEventListener('click', handleApplyAccessFilter);
            
            const originalResetAdvancedFilters = handleResetAdvancedFilters;
            handleResetAdvancedFilters = function(showMsg = true) {
                originalResetAdvancedFilters(showMsg);
                // No need to call updateTimelineChart here, it's called by applyAccessFiltersAndRender
            };

            if (resetAdvancedFiltersBtn) resetAdvancedFiltersBtn.addEventListener('click', () => handleResetAdvancedFilters(true));
            if (sendAssignmentBtnEl) sendAssignmentBtnEl.addEventListener('click', handleSendAssignment);
            if (simulateRemindersBtn) simulateRemindersBtn.addEventListener('click', simulateWeeklyReminders);
            if (accessFilterBtn) accessFilterBtn.addEventListener('click', () => accessFilterModalInstance.show());
            if (advancedFilterToggleBtn) advancedFilterToggleBtn.addEventListener('click', () => {
                 const initialData = allTasksDataOriginal.filter(task => {
                    if (currentUserAccessLevel === 'super_admin') return true;
                    if (currentUserAccessLevel === 'corporate') return task.corporateName === currentAccessScope.corporate;
                    if (currentUserAccessLevel === 'regional') return task.corporateName === currentAccessScope.corporate && task.regionName === currentAccessScope.region;
                    if (currentUserAccessLevel === 'unit') return task.corporateName === currentAccessScope.corporate && task.regionName === currentAccessScope.region && task.unitName === currentAccessScope.unit;
                    return false;
                });
                 populateAdvancedFilterDropdowns(initialData); 
                 advancedFilterModalInstance.show();
            });
            
            document.getElementById('saveRescheduleBtn')?.addEventListener('click', handleSaveReschedule);
            document.getElementById('downloadHistoryPdfBtn')?.addEventListener('click', downloadHistoryAsPDF);
            document.getElementById('downloadReportBtn')?.addEventListener('click', handleDownloadReport);

            const mobileStatusFilterContainer = document.getElementById('mobileStatusFilters');
            if (mobileStatusFilterContainer) {
                mobileStatusFilterContainer.addEventListener('click', (event) => {
                    const targetButton = event.target.closest('button[data-status-filter]');
                    if (targetButton) {
                        event.preventDefault();
                        selectedTasksForVerification.clear(); 
                        currentMobileFilterStatus = targetButton.dataset.statusFilter;
                        mobileStatusFilterContainer.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                        targetButton.classList.add('active');
                        renderTable(); 
                    }
                });
            }

            document.addEventListener('click', function(event) {
                const toggleBtn = event.target.closest('.mobile-details-toggle-btn');
                if (toggleBtn) {
                    event.preventDefault();
                    event.stopPropagation();
                    const targetId = toggleBtn.dataset.target;
                    if (!targetId) return;
                    const targetElement = document.querySelector(targetId);
                    if (!targetElement) return;
                    const isExpanded = targetElement.classList.contains('show');
                    const buttonElement = toggleBtn;
                    if (isExpanded) {
                        targetElement.classList.remove('show');
                        buttonElement.classList.remove('expanded');
                        buttonElement.innerHTML = `Show Details <i class="fas fa-chevron-down toggle-icon"></i>`;
                        targetElement.style.maxHeight = null;
                    } else {
                        targetElement.classList.add('show');
                        buttonElement.classList.add('expanded');
                        buttonElement.innerHTML = `Hide Details <i class="fas fa-chevron-up toggle-icon"></i>`;
                        targetElement.style.maxHeight = targetElement.scrollHeight + "px";
                    }
                }
            });
            
            const handleRefreshClick = () => {
                showToast('Refreshed', 'Reloading all data and resetting filters.', 'info');
                selectedTasksForVerification.clear();
                currentMobileFilterStatus = 'all'; 
                mainSearchTerm = '';
                if(mainSearchBox) mainSearchBox.value = '';
                const mobileFilters = document.getElementById('mobileStatusFilters');
                if(mobileFilters) {
                    mobileFilters.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                    const allBtn = mobileFilters.querySelector('button[data-status-filter="all"]');
                    if(allBtn) allBtn.classList.add('active');
                }
                currentUserAccessLevel = 'super_admin'; 
                currentAccessScope = { corporate: null, region: null, unit: null };
                handleResetAdvancedFilters(false);
                
                initializeSampleDataAndTable(); 
             };
            
            if(verificationNeededBtn) verificationNeededBtn.addEventListener('click', handleVerificationClick);
            if(refreshBtn) refreshBtn.addEventListener('click', handleRefreshClick);

            console.log("Initial setup complete.");
        });

    </script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

@endsection
