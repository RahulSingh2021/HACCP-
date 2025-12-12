@extends('layouts.app2', ['pagetitle'=>'Dashboard'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- EXTERNAL LIBRARIES FOR PDF/EXCEL -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.6.2/dist/fuse.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

      <style>
      button.action-btn.btn.btn-sm.btn-success.text-white.btn-complete-task {
    background: #198754 !important;
}
button#clearFiltersModalBtn {
    background: #6c757d !important;
    padding: 10px;
}
.hide-important {
    display: none !important;
}
ul#paginationControls {
    display: none;
}


.card-footer.d-flex.justify-content-between.align-items-center.flex-wrap.gap-2 {
    padding: 20px 0;
    margin: 20px;
}
button#applybutton {
    background: #0a58ca !important;
    padding: 10px;
}
button.action-btn.btn.btn-sm.btn-outline-success.btn-breakdown-update {
    background: #198754 !important;
    color: #fff !important;
    padding: 10px;
    font-size: 12px !important;
}

.pagination {
    margin: 0px !important;
}
a.page-link {
    padding: 3px 12px !important;
}
span.page-link {
    padding: 3px 12px;
}
button.action-btn.btn.btn-sm.btn-warning.btn-breakdown-update {
    background: #ffc107 !important;
}
.page-content button.btn.btn-secondary {
    background: #6c757d !important;
}
button#confirmBreakdownResolveBtn {
    background: #ffc107 !important;
}
button.action-btn.btn.btn-sm.btn-info.text-white.btn-assign {
    background: #25cff2 !important;
    padding: 10px !important;

}

button.action-btn.btn.btn-sm.btn-outline-secondary.btn-progress {
    background: #6c757d !important;
    color: #fff;
}

button.action-btn.btn.btn-sm.btn-outline-danger.btn-delete {
    background: #dc3545 !important;
    text-align: center;
    display: block;
    color:#fff !important;
}

button#clearVerificationSignatureBtn {
    background: #6c757d !important;
    color: #fff !important;
}

button.btn.btn-secondary {
    background: #565e64 !important;
}

button#rejectBreakdownBtn {
    background: #dc3545 !important;
}

button#finalSubmitVerificationBtn {
    background: #198754 !important;
}

button.action-btn.btn.btn-sm.btn-outline-danger.btn-delete:hover {
    background: #dc3545 !important;
    text-align: center;
    display: block;
    color:#fff !important;
}
      .page-wrapper {
    height: 100%;
    margin-top: 40px !important;
    margin-bottom: 30px;
    margin-left: 0px;
}
ul#breakdownEquipmentList {
    height: 250px;
    overflow-y: auto; /* ✅ Vertical scroll */
    overflow-x: hidden; /* Optional: prevent horizontal scroll */
    scrollbar-width: thin; /* Firefox */
}

button.btn.btn-icon.btn-star {
    background: none !important;
}
button#detailsFilterBtn {
    background: none !important;
}
button#areaFilterBtn {
    background: none !important;
}
button#statusFilterBtn {
    background: none !important;
}

button#trackingFilterBtn {
    background: none !important;
}

.page-content button.btn {
    background-color: #008cff !important;
    border: none;

}


.btn i {
    font-size: 19px !important;
    margin-top: -9px !important;
    margin-right: 5px !important;
}

.page-content {
    padding: 0px !important;
}
.page-footer {
    background: #ffffff;
    left: 0px;
    right: 0;
    bottom: 0;
     position: relative !important; 
    text-align: center;
    padding: 7px;
    font-size: 14px;
    border-top: 1px solid #e4e4e4;
    z-index: 3;
}


button.btn {
     background: none !important; 
    border: none;
}

.btn:focus {
    outline: 0 !important; 
    box-shadow: 0 !important; 
}

        :root {
            --primary-color: #3a7bd5; --secondary-color: #e74c3c; --success-color: #28a745; --warning-color: #ffc107; --danger-color: #dc3545; --info-color: #17a2b8;
            --light-gray: #f8f9fa; --medium-gray: #ced4da; --dark-gray: #343a40; --text-muted: #6c757d; --border-color: #e0e0e0;
            --border-radius: 6px; --box-shadow: 0 4px 12px rgba(0,0,0,0.08); --transition: all 0.3s ease-in-out;
            --details-primary-light: #e0e7ff;
            --error-color: #e74c3c;
            /* Editor Pro Desktop Theme */
            --editor-bg: #525252;
            --editor-ruler-bg: #3a3a3a;
            --editor-ruler-marks: #888;
            --editor-checkerboard-light: #707070;
            --editor-checkerboard-dark: #5e5e5e;
            /* Editor Mobile Theme */
            --mobile-editor-bg: #1a1a1a;
            --mobile-toolbar-bg: #2b2b2b;
            --mobile-primary-text: #ffffff;
            --mobile-secondary-text: #a0a0a0;
            --mobile-finish-btn-bg: #007aff;
            --mobile-confirm-color: #34c759;
            --mobile-cancel-color: #ff3b30;
            /* Details Component Variables */
            --details-primary-color: #4361ee;
            --details-danger-color: #ef233c;
            --details-danger-light: #ffe0e3;
            --details-gray-100: #f8f9fa;
            --details-gray-200: #e9ecef;
            --details-gray-300: #dee2e6;
            --details-gray-500: #adb5bd;
            --details-gray-600: #6c757d;
            --details-gray-800: #343a40;
            --details-border-radius: 0.375rem;
            --details-box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --details-transition: all 0.2s ease-in-out;
        }
        /* --- REWORK: Layout for Scrollable Table --- */
        html, body {
            height: 100%;
            overflow: hidden; /* Prevent the whole page from scrolling */
        }
        .page-wrapper {
            height: 100%;
            padding: 1rem;
        }
        .page-content {
            height: 100%;
        }
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-body {
            flex-grow: 1; /* Allow body to take up all available space */
            overflow-y: auto; /* Make the card body scrollable */
        }
        .table-report thead th { 
            position: sticky; /* Stick to the top of the scrolling container (.card-body) */
            top: 0;
            z-index: 10;
            background-color: #f8f9fa; 
        }
        /* --- END REWORK --- */

        body { font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif; background-color: #f5f7fa; }
        .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: none; }
        
        .card-header { 
            background-color: #fff; 
            border-bottom: 1px solid var(--border-color);
        }
        .table-report thead th { 
            font-weight: 600; 
            color: var(--dark-gray); 
            border-bottom: 2px solid var(--border-color); 
            padding: 12px 16px; 
        }

        .table-report { font-size: 14px; border-collapse: separate; border-spacing: 0; min-width: 1400px; }
        .table-report tbody tr:hover { background-color: rgba(58,123,213,0.05); }
        .table-report td { padding: 12px 16px; vertical-align: middle; border-top: 1px solid var(--border-color); }
        .btn-icon { background: transparent; border: none; color: var(--text-muted); opacity: .6; transition: opacity .2s ease, color .2s ease; }
        .btn-icon:hover { opacity: 1; }
        .concern-details { display: flex; align-items: flex-start; }
        .concern-details .concern-title-wrapper { flex-grow: 1; }
        .concern-details .concern-title { font-weight: 500; color: var(--dark-gray); }
        .concern-title strong { color: var(--primary-color); font-weight: 700; }
        .concern-details .concern-id { font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; display: block; background-color: var(--light-gray); padding: 2px 6px; border-radius: 4px; display: inline-block; }
        .concern-details .concern-meta { display: flex; flex-wrap: wrap; gap: 8px 16px; font-size: 13px; color: var(--text-muted); }
        .concern-details .concern-meta span { display: flex; align-items: center; gap: 4px; }
        .concern-responsibility { font-size: 13px; color: var(--text-muted); margin-top: 8px; padding-top: 8px; border-top: 1px dashed var(--border-color); display: flex; align-items: center; gap: 6px; }
        .concern-responsibility strong { color: var(--dark-gray); }
        .risk-score-badge { padding: .2em .5em; border-radius: 4px; font-weight: 600; background-color: #e9ecef; color: #495057; }
        .image-cell { display: flex; gap: 12px; align-items: center; }
        .report-image-thumb { width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #e9ecef; cursor: pointer; transition: transform .2s ease; }
        .report-image-thumb:hover { transform: scale(1.05); }
        .image-label { position: absolute; bottom: 6px; left: 6px; background-color: rgba(0,0,0,.7); color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; }
        .after-photo-placeholder { width: 80px; height: 80px; border-radius: 8px; border: 2px dashed #adb5bd; background-color: #f8f9fa; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #adb5bd; }
        .status-badge { padding: .35em .65em; border-radius: 50px; font-size: 12px; font-weight: 600; }
        .status-open { background-color: rgba(220,53,69,.1); color: var(--danger-color); }
        .status-resolved { background-color: rgba(40,167,69,.1); color: var(--success-color); }
        .status-in-progress { background-color: rgba(23,162,184,.1); color: var(--info-color); }
        .status-scheduled { background-color: rgba(255,193,7,.1); color: #856404; }
        .status-verified { background-color: #0d6efd; color: white; }
        .status-not-applicable { background-color: #6c757d; color: white; }
        .status-follow-up-created { background-color: #e8dff5; color: #6a0dad; } /* New status style */
        .badge-breakdown { background-color: var(--details-danger-light); color: var(--danger-color); border: 1px solid var(--danger-color); }
        .action-btn-group, .action-btn-group-vertical { display: flex; flex-wrap: wrap; gap: 6px; }
        .action-btn { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
        .progress-tracker { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
        .step { position: relative; flex: 1; text-align: center; }
        .step:not(:first-child)::before { content: ''; position: absolute; top: 12px; right: 50%; width: 100%; height: 2px; background-color: var(--border-color); z-index: 1; }
        .step-icon { position: relative; z-index: 2; width: 24px; height: 24px; border-radius: 50%; background-color: #fff; border: 2px solid var(--border-color); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; margin-bottom: 8px; }
        .step-label { font-size: 12px; color: var(--text-muted); }
        .step-label strong { display: block; font-weight: 500; color: var(--dark-gray); }
        .step-label .step-time { font-size: 11px; }
        .step.is-completed .step-icon { background-color: var(--success-color); border-color: var(--success-color); color: #fff; }
        .step.is-completed::before { background-color: var(--success-color); }
        .step.is-completed .step-label { color: var(--dark-gray); }
        .step.is-scheduled .step-icon { background-color: var(--warning-color); border-color: var(--warning-color); color: #fff; }
        .step-label .scheduled-note { font-size: 11px; display: block; margin-top: 2px; color: #856404; font-weight: 600; }
        .time-since-reported { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
        .filter-list { list-style: none; padding-left: 0; max-height: 200px; overflow-y: auto; border: 1px solid #eee; border-radius: .375rem; padding: .5rem; font-size: 0.9rem; }
        .filter-list .form-check-label { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dropdown-menu.p-3 { min-width: 280px; }
        .image-modal-body img, .image-modal-body video { width: 100%; max-height: 50vh; display: block; margin: auto; }
        .table-report thead th .fa-filter { font-size: 0.8em; }
        .table-report thead th .btn-icon { opacity: 0.4; } .table-report thead th:hover .btn-icon { opacity: 1; }
        .table-report thead th > .d-flex { gap: 8px; }
        @keyframes row-flash { 0%, 100% { background-color: inherit; } 50% { background-color: #fff3cd; } }
        .flash-reminder { animation: row-flash 1s ease-in-out; }
        .table-report td:first-child, .table-report th:first-child { text-align: center; }
        #bulkAcknowledgeBtn { font-weight: 500; }
        #offline-status-container { font-size: 0.9rem; }
        #connection-status-indicator.status-online { background-color: var(--success-color); }
        #connection-status-indicator.status-offline { background-color: var(--danger-color); }
        .table-report tbody tr.is-draft { background-color: #fffbe6; opacity: 0.9; }
        .table-report tbody tr.is-draft:hover { background-color: #fff9d9; opacity: 1; }
        .table-report tbody tr.is-breakdown { background-color: var(--details-danger-light) !important; }
        .status-draft { background-color: rgba(255,193,7,.1); color: #856404; }
        .media-upload-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; z-index: 5; transition: opacity 0.3s ease; opacity: 1; }
        .media-upload-overlay .spinner-border { width: 1.5rem; height: 1.5rem; }
        .upload-progress-text { font-size: 0.8rem; font-weight: 600; margin-top: 5px; }
        .media-upload-overlay.hidden { opacity: 0; pointer-events: none; }
        .media-upload-overlay.upload-error .spinner-border, .media-upload-overlay.upload-error .upload-progress-text { display: none; }
        .upload-error-icon { font-size: 1.5rem; color: var(--warning-color); display: none; }
        .media-upload-overlay.upload-error .upload-error-icon { display: block; }
        .upload-retry-btn { background: var(--primary-color); color: white; border: none; border-radius: 4px; padding: 2px 8px; font-size: 0.75rem; margin-top: 5px; cursor: pointer; display: none; }
        .media-upload-overlay.upload-error .upload-retry-btn { display: block; }
        .video-thumbnail-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.3); color: rgba(255, 255, 255, 0.85); display: flex; align-items: center; justify-content: center; font-size: 2rem; border-radius: 8px; pointer-events: none; transition: opacity 0.2s ease; z-index: 2; }
        .image-cell .position-relative:hover .video-thumbnail-overlay { opacity: 0; }
        .action-btn-group-mobile { display: none; }
        .btn-star { font-size: 1.1rem; color: var(--text-muted); opacity: 0.5; vertical-align: top; padding: 0 8px 0 0; line-height: 1; }
        .btn-star:hover { opacity: 1; }
        tr[data-starred="true"] .btn-star, .btn-star.is-starred { color: var(--warning-color); opacity: 1; }
        #followUpFilterBtn.active, #breakdownFilterBtn.active { background-color: var(--primary-color); color: #fff; border-color: var(--primary-color); }
        .is-editing { outline: 2px solid var(--primary-color); background-color: #f8f9fa; border-radius: 4px; padding: 4px; }
        
        #bulkUploadDropzone { 
            position: relative; 
            border: 2px dashed var(--medium-gray); 
            border-radius: var(--border-radius); 
            padding: 2rem; 
            text-align: center; 
            background-color: var(--light-gray);
            transition: all var(--transition); 
        }
        #bulkUploadDropzone.is-dragover { 
            background-color: var(--details-primary-light); 
            border-color: var(--primary-color);
            transform: scale(1.02);
        }
        #bulkUploadDropzone .dropzone-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            pointer-events: none;
        }
        #bulkUploadDropzone .dropzone-icon {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        #bulkUploadDropzone h6 {
            font-weight: 600;
            color: var(--dark-gray);
        }
        #bulkUploadDropzone p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }
        #bulkUploadDropzone label { 
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
            cursor: pointer; 
        }
        #bulkImageInput { 
            width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1; 
        }
        
        #bulkUploadPreviewArea { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; margin-top: 1.5rem; max-height: 40vh; overflow-y: auto; }
        .bulk-preview-card { position: relative; border: 1px solid var(--border-color); border-radius: var(--border-radius); overflow: hidden; }
        .bulk-preview-card img { width: 100%; height: 100px; object-fit: cover; }
        .bulk-preview-card .location-overlay { position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.7); color: white; font-size: 0.75rem; padding: 4px 6px; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .bulk-preview-card .remove-bulk-image-btn { position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(0,0,0,0.1); border-radius: 50%; color: var(--danger-color); font-weight: bold; line-height: 18px; text-align: center; cursor: pointer; }
        #bulkLocationList { max-height: 200px; overflow-y: auto; }
        #historyModalBody { background-color: #f4f7fa; padding: 20px; }
        .history-modal .report-container { width: 100%; max-width: 1200px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e6ed; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); overflow: hidden; }
        .history-modal .report-timestamps { background-color: #f8f9fa; padding: 12px 20px; border-bottom: 1px solid #e0e6ed; display: flex; justify-content: space-between; font-size: 13px; color: #52616b; }
        .history-modal .report-header { display: flex; justify-content: space-between; align-items: flex-start; padding: 20px; gap: 20px; }
        .history-modal .evidence-section { display: flex; gap: 15px; }
        .history-modal .evidence-image-wrapper { width: 120px; height: 90px; border-radius: 6px; position: relative; cursor: pointer; overflow: hidden; border: 1px solid #e0e6ed; }
        .history-modal .evidence-image-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
        .history-modal .evidence-image-wrapper:hover img { transform: scale(1.1); }
        .history-modal .evidence-tag { position: absolute; bottom: 6px; left: 6px; background-color: rgba(0, 0, 0, 0.7); color: white; padding: 3px 6px; font-size: 11px; font-weight: 500; border-radius: 4px; }
        .history-modal .report-details { flex-grow: 1; padding: 0 15px; }
        .history-modal .report-details h2 { margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: #2c3e50; }
        .history-modal .report-details .meta-info { font-size: 14px; color: #52616b; margin-bottom: 8px; }
        .history-modal .risk { display: inline-block; background-color: #f1f3f5; padding: 4px 8px; border-radius: 4px; font-weight: 500; }
        .history-modal .header-right-panel { display: flex; align-items: flex-start; gap: 30px; }
        .history-modal .area-status { text-align: right; min-width: 180px; }
        .history-modal .area-status .area { font-size: 14px; line-height: 1.5; color: #52616b; }
        .history-modal .status { margin-top: 10px; }
        .history-modal .status-badge { display: inline-flex; align-items: center; color: white; padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .history-modal .status-badge.status-open { background-color: #e74c3c; }
        .history-modal .status-badge.status-closed { background-color: #2ecc71; }
        .history-modal .status-badge::before { content: ''; width: 8px; height: 8px; background-color: white; border-radius: 50%; margin-right: 6px; }
        .history-modal .time-ago { font-size: 12px; color: #8492a6; margin-top: 6px; display: block; }
        .history-modal .download-button { padding: 8px 16px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: 500; transition: background-color 0.2s, opacity 0.2s; white-space: nowrap; border: none; cursor: pointer; }
        .history-modal .download-button:hover { background-color: #2980b9; }
        .history-modal .download-button:disabled { background-color: #a9cce3; cursor: not-allowed; }
        .history-modal .report-table-wrapper { padding: 10px; }
        .history-modal .report-table { width: 100%; border-collapse: collapse; }
        .history-modal .report-table th, .history-modal .report-table td { padding: 16px; text-align: left; border-bottom: 1px solid #e0e6ed; vertical-align: top; }
        .history-modal .report-table tr:last-child td { border-bottom: none; }
        .history-modal .report-table th { background-color: #f8f9fa; color: #495057; font-size: 13px; font-weight: 600; text-transform: uppercase; }
        .history-modal .status-tag { display: inline-block; padding: 5px 12px; border-radius: 15px; font-weight: 500; font-size: 13px; }
        .history-modal .status-non-compliance { background-color: #fdf2e3; color: #da7c0c; border: 1px solid #fbe5c5; }
        .history-modal .status-in-progress { background-color: #e3f2fd; color: #1e88e5; border: 1px solid #bbdefb; }
        .history-modal .status-breakdown-update { background-color: #fff3e0; color: #e65100; border: 1px solid #ffe0b2; }
        .history-modal .status-not-applicable { background-color: #f1f3f5; color: #52616b; border: 1px solid #ced4da; }
        .history-modal .status-compliance-verified { background-color: var(--success-color); color: white; border: 1px solid #198754;}
        .history-modal .status-non-compliance-found { background-color: var(--danger-color); color: white; border: 1px solid #dc3545;}
        .history-modal .table-image { width: 80px; height: 60px; border-radius: 4px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease; border: 1px solid #e0e6ed; }
        .history-modal .table-image:hover { transform: scale(1.05); }
        .history-modal .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); display: flex; justify-content: center; align-items: center; z-index: 1056; opacity: 0; visibility: hidden; transition: opacity 0.3s, visibility 0.3s; }
        .history-modal .modal-overlay.visible { opacity: 1; visibility: visible; }
        .history-modal .modal-content { position: relative; max-width: 90vw; max-height: 90vh; }
        .history-modal .modal-content img { display: block; max-width: 100%; max-height: 100%; border-radius: 8px; }
        .history-modal .modal-close { position: absolute; top: -30px; right: -20px; color: white; font-size: 30px; font-weight: bold; cursor: pointer; }
        .mobile-evidence-header { display: none; }
        .signature-pad { border: 1px solid var(--medium-gray); border-radius: var(--border-radius); background-color: #fff; cursor: crosshair; }

        /* --- Complaint Form Styles --- */
        #complaintFormModal .modal-body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.65;
            color: var(--dark-gray);
            background-color: var(--light-gray);
            padding: 1.5rem;
            -webkit-tap-highlight-color: transparent;
        }
        #complaintFormModal .main-container { max-width: 800px; margin: 0 auto; }
        #complaintFormModal .details-container { background-color: white; padding: 1.5rem; border-radius: var(--border-radius); box-shadow: var(--box-shadow); position: relative; }
        #complaintFormModal .form-group { margin-bottom: 28px; position: relative; }
        #complaintFormModal .form-group:last-child { margin-bottom: 0; }
        #complaintFormModal label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--primary-color); font-size: 0.95em; }
        #complaintFormModal .error-message { color: var(--error-color); font-size: 0.85em; margin-top: 6px; display: none; }
        #complaintFormModal .complaint-input-wrapper { display: flex; align-items: flex-start; gap: 1rem; border: 1px solid var(--details-gray-300); border-radius: var(--details-border-radius); padding: 0.75rem 1rem; transition: all 0.2s ease-in-out; }
        #complaintFormModal .complaint-input-wrapper:focus-within { border-color: var(--details-primary-color); box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25); }
        #complaintFormModal .complaint-box { flex-grow: 1; display: flex; flex-direction: column; line-height: 1.8; min-height: 24px; }
        #complaintFormModal .complaint-box p { margin: 0; display: flex; flex-wrap: wrap; align-items: baseline; gap: 0.5rem; }
        #complaintFormModal #direct-upload-options-container { transition: opacity 0.3s ease, transform 0.3s ease, width 0.3s ease; flex-shrink: 0; }
        #complaintFormModal .complaint-input-wrapper.has-media #direct-upload-options-container { opacity: 0; width: 0; overflow: hidden; pointer-events: none; }
        #complaintFormModal .direct-upload-options { display: flex; gap: 10px; align-items: center; }
        #complaintFormModal .upload-option-direct { background: none; border: none; cursor: pointer; padding: 4px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--details-gray-600); transition: background-color 0.2s ease; }
        #complaintFormModal .upload-option-direct:hover { background-color: var(--details-gray-200); }
        #complaintFormModal .upload-option-direct svg { width: 22px; height: 22px; fill: currentColor; }
        #complaintFormModal .image-collage-preview { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--details-gray-200); align-items: flex-start; }
        #complaintFormModal .add-more-options-wrapper { grid-column: 1 / -1; display: flex; justify-content: center; gap: 15px; padding-top: 10px; border-top: 1px solid var(--light-gray); margin-top: 10px; }
        #complaintFormModal .preview-item { position: relative; width: 100%; height: 100px; border: 1px solid var(--medium-gray); border-radius: var(--border-radius); overflow: hidden; background-color: #f8f9fa; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; justify-content: center; align-items: center; cursor: pointer; }
        #complaintFormModal .preview-item img, .preview-item video { max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain; display: block; }
        #complaintFormModal .preview-item-controls { position: absolute; top: 0; right: 0; padding: 4px; display: flex; gap: 4px; z-index: 2; background: linear-gradient(to bottom left, rgba(0,0,0,0.2), transparent 80%); border-top-right-radius: var(--border-radius); }
        #complaintFormModal .remove-preview-btn, #complaintFormModal .edit-preview-btn, #complaintFormModal .enlarge-preview-btn { background-color: rgba(255, 255, 255, 0.8); color: var(--primary-color); border: 1px solid rgba(0,0,0,0.1); border-radius: 50%; width: 22px; height: 22px; font-size: 12px; font-weight: bold; line-height: 22px; text-align: center; cursor: pointer; padding: 0; transition: all 0.2s ease; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        #complaintFormModal .remove-preview-btn:hover { background-color: var(--secondary-color); color: white; }
        #complaintFormModal .edit-preview-btn { font-size: 10px; }
        #complaintFormModal .enlarge-preview-btn { font-size: 14px; }
        #complaintFormModal .edit-preview-btn:hover, #complaintFormModal .enlarge-preview-btn:hover { background-color: var(--accent-color); color: white; }
        #complaintFormModal .pdf-placeholder { width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.8em; padding: 8px; text-align: center; box-sizing: border-box; word-break: break-word; color: var(--fixed-text-color); }
        #complaintFormModal .pdf-placeholder svg { width: 30px; height: 30px; margin-bottom: 5px; fill: currentColor; }
        #complaintFormModal .video-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; pointer-events: none; }
        #complaintFormModal .video-overlay svg { width: 40px; height: 40px; fill: rgba(255,255,255,0.8); }
        #complaintFormModal .preview-item:hover .video-overlay { opacity: 0; }
        #image-preview-modal { display: none; position: fixed; z-index: 1060; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.85); justify-content: center; align-items: center; animation: fadeIn 0.3s; }
        #image-preview-modal .modal-content { position: relative; display: flex; justify-content: center; align-items: center; max-width: 90vw; max-height: 90vh; }
        #image-preview-modal img, #image-preview-modal video { max-width: 100%; max-height: 100%; border-radius: var(--border-radius); box-shadow: 0 10px 30px rgba(0,0,0,0.4); }
        #image-preview-modal .close-preview { position: absolute; top: 10px; right: 10px; z-index: 10; color: #fff; font-size: 35px; font-weight: bold; cursor: pointer; background-color: rgba(0, 0, 0, 0.6); border-radius: 50%; width: 35px; height: 35px; line-height: 35px; text-align: center; transition: var(--transition); text-shadow: 0 1px 2px rgba(0,0,0,0.5); }
        #image-preview-modal .close-preview:hover { transform: scale(1.1); color: var(--secondary-color); }
        .confirmation-dialog, .upload-choice-modal, .image-editor-modal, .collage-maker-container, .video-recorder-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 1056; justify-content: center; align-items: center; padding: 20px; box-sizing: border-box; }
        .confirmation-content, .upload-choice-content, .image-editor-content, .collage-maker-content, .video-recorder-content { background-color: white; border-radius: var(--border-radius); box-shadow: 0 8px 25px rgba(0,0,0,0.15); display: flex; flex-direction: column; overflow: hidden; }
        #upload-choice-modal { display: none !important; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleUp { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes slideUp { from { transform: translateY(100%); } to { translateY(0); } }
        .video-recorder-content { max-width: 640px; width: 100%; padding: 20px; }
        #video-preview { width: 100%; max-height: 480px; background: #000; border-radius: var(--border-radius); margin-bottom: 15px; }
        .video-controls { display: flex; justify-content: center; gap: 10px; align-items: center; }
        .video-controls button { padding: 10px 20px; border-radius: var(--border-radius); cursor: pointer; font-weight: 500; border: 1px solid var(--medium-gray); }
        #stop-record-btn { background-color: var(--secondary-color); color: white; border-color: var(--secondary-color); }
        .recording-indicator { font-size: 0.9em; color: var(--secondary-color); display: none; }
        .recording-indicator::before { content: 'тЧП'; margin-right: 5px; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
        /* --- Styles for other modals from complaint form --- */
        .collage-maker-content { width: 100%; max-width: 800px; max-height: 90vh; }
        .collage-maker-header { padding: 15px 20px; background-color: var(--primary-color); color: white; display: flex; justify-content: space-between; align-items: center; }
        .image-editor-content { max-width: 90vw; width: 100%; min-height: 500px; max-height: 90vh; background-color: #333; }
        .image-editor-header { padding: 12px 20px; background-color: #333; border-bottom: 1px solid #444; color: white; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        /* Additional specific styles from the complaint form are numerous and are included below for brevity */
        .details-container .form-group-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 10px;}
        .details-container .form-label { display: block; font-weight: 600; margin-bottom: 0; font-size: 1rem; color: var(--details-gray-800); }
        .details-container .form-label .required-star { color: var(--details-danger-color); }
        #complaint-sentence-template { opacity: 0; transition: opacity 0.4s ease; display: none; }
        .complaint-input-wrapper.is-typing #complaint-sentence-template { opacity: 1; display: inline; }
        .details-container .inline-input { border: none; background-color: transparent; font-family: inherit; font-size: inherit; padding: 0; min-width: 150px; color: var(--details-gray-800); display: inline-block; width: auto; }
        .details-container .inline-input:focus { outline: none; }
        .details-container .inline-input[contenteditable]:empty::before { content: attr(data-placeholder); color: var(--details-gray-500); pointer-events: none; }
        .details-container .highlight { background-color: var(--details-primary-light); border-radius: 0.25rem; font-weight: 500; padding: 0 0.125rem; transition: background-color var(--details-transition); cursor: pointer; }
        .details-container .misspelled { border-bottom: 2px dotted var(--details-danger-color); cursor: pointer; text-decoration: none; background-color: var(--details-danger-light); border-radius: 0.25rem; padding: 0 0.125rem; transition: all var(--details-transition); }
        .details-container .optional-details-section { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--details-gray-200); }
        .details-container .optional-details-section h4 { margin-top: 0; margin-bottom: 0; font-size: 1rem; font-weight: 600; color: var(--details-gray-800); }
        .details-container .optional-selectors-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .details-container .optional-selector-item > label { display: block; font-size: 0.9rem; font-weight: 500; color: var(--details-gray-700); margin-bottom: 0.25rem; }
        .details-container .multi-select-wrapper { position: relative; display: inline-flex; vertical-align: baseline; align-items: baseline; gap: 0.25rem; }
        .details-container .complaint-box .multi-select-wrapper { width: auto; }
        .details-container .optional-selector-item .multi-select-wrapper { width: 100%; }
        .details-container .pills-container { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; width: 100%; min-height: 38px; padding: 0.375rem 0.5rem; cursor: pointer; border: 1px solid var(--details-gray-300); border-radius: var(--details-border-radius); background-color: white; box-sizing: border-box; }
        .details-container .pills-container.inline { display: inline-flex; align-items: center; gap: 0.35rem; padding: 2px 4px; border-radius: 4px; border-bottom: 1px solid transparent; transition: background-color 0.2s; min-height: initial; width: auto; vertical-align: middle; background-color: var(--details-gray-100); border: 1px solid var(--details-gray-300); }
        .details-container .pills-container.inline:hover { background-color: var(--details-gray-200); border-color: var(--details-gray-400); }
        .details-container .pills-placeholder-text { color: var(--details-primary-color); font-weight: 500; }
        .pills-placeholder-add-icon, .pill-add-button { display: inline-flex; align-items: center; justify-content: center; width: 1.25em; height: 1.25em; background-color: var(--details-primary-color); color: white; border-radius: 50%; flex-shrink: 0; border: none; cursor: pointer; font-size: 1em; line-height: 1; }
        .pill-add-button { margin-left: 0.35rem; }
        .pills-placeholder-add-icon svg, .pill-add-button svg { width: 0.9em; height: 0.9em; fill: currentColor; }
        .details-container .pills-placeholder { display: flex; align-items: center; gap: 0.35rem; color: var(--details-gray-600); }
        .details-container .pills-placeholder > svg { flex-shrink: 0; }
        .details-container .pill { background-color: var(--details-primary-light); border-radius: 99px; padding: 0.2rem 0.6rem; font-size: 0.9em; display: flex; align-items: center; gap: 0.3rem; color: var(--details-primary-color); font-weight: 500; white-space: nowrap; }
        .details-container .pill .deselect-pill { cursor: pointer; font-weight: bold; font-size: 1.1em; line-height: 1; opacity: 0.6; }
        .details-container .pill .deselect-pill:hover { opacity: 1; }
        .details-container .pills-container.inline .pill { background-color: transparent; padding: 0; border-radius: 0; border-bottom: 1px dotted var(--details-primary-color); }
        .details-container .multi-select-dropdown { display: none; position: absolute; background-color: white; border: 1px solid var(--details-gray-300); border-radius: var(--details-border-radius); box-shadow: var(--details-box-shadow); z-index: 1055; min-width: 250px; max-height: 300px; display: none; flex-direction: column; margin-top: 0.25rem; }
        .details-container .multi-select-dropdown.active { display: flex; }
        .details-container .multi-select-search { padding: 0.5rem; border: none; border-bottom: 1px solid var(--details-gray-200); outline: none; }
        .details-container .multi-select-list-container { overflow-y: auto; flex-grow: 1; }
        .details-container .multi-select-item { display: flex; align-items: center; padding: 0.5rem 0.75rem; cursor: pointer; transition: background-color 0.2s ease; }
        .details-container .multi-select-item.selected { background-color: var(--details-primary-light); font-weight: 500; }
        .details-container .multi-select-item:hover { background-color: var(--details-gray-200); }
        .details-container .multi-select-item label { margin-left: 0.5rem; cursor: pointer; flex-grow: 1; }
        .details-container .multi-select-item input[type="checkbox"] { appearance: none; -webkit-appearance: none; position: relative; width: 18px; height: 18px; border-radius: 4px; border: 2px solid var(--details-gray-400); cursor: pointer; flex-shrink: 0; transition: all 0.2s ease; }
        .details-container .multi-select-item input[type="checkbox"]:checked { background-color: var(--details-primary-color); border-color: var(--details-primary-color); }
        .details-container .multi-select-item input[type="checkbox"]::after { content: ''; position: absolute; top: 1px; left: 5px; width: 5px; height: 10px; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg); opacity: 0; transition: opacity 0.2s ease; }
        .details-container .multi-select-item input[type="checkbox"]:checked::after { opacity: 1; }
        .details-container .multi-select-item.add-new-trigger { color: var(--details-primary-color); font-weight: 500; }
        .details-container .multi-select-item.add-new-trigger svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2; }
        .details-container .multi-select-add-new { display: flex; padding: 0.5rem; border-top: 1px solid var(--details-gray-200); }
        .details-container .multi-select-add-input { flex-grow: 1; border: 1px solid var(--details-gray-300); border-right: none; border-radius: var(--details-border-radius) 0 0 var(--details-border-radius); padding: 0.3rem; outline: none; }
        .details-container .multi-select-add-btn { background-color: var(--details-primary-color); color: white; border: none; border-radius: 0 var(--details-border-radius) var(--details-border-radius) 0; padding: 0 0.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        #complaintFormModal .submit-button { display: block; width: 100%; padding: 0.875rem; background-color: var(--details-primary-color); color: white; border: none; border-radius: var(--details-border-radius); cursor: pointer; font-weight: 600; font-size: 1.1rem; margin-top: 1.5rem; transition: background-color var(--details-transition); }
        #complaintFormModal .submit-button:hover { background-color: #3f37c9; }
        #complaintFormModal #modelStatus { font-size: 0.8rem; color: var(--details-gray-600); margin-top: 0.75rem; }
        
        .alert-ticker { display: none; padding: 8px; color: white; font-size: 0.9rem; font-weight: 500; overflow: hidden; white-space: nowrap; }
        .alert-ticker.observation { background-color: var(--primary-color); }
        .alert-ticker.breakdown { background-color: var(--danger-color); }
        .alert-ticker.verification { background-color: var(--warning-color); color: #212529; }
        .ticker-wrap { display: flex; align-items: center; }
        .ticker-content { display: inline-block; padding-left: 100%; animation: marquee 20s linear infinite; }
        .ticker-content i { margin-right: 10px; }
        .ticker-close { background: none; border: none; color: white; font-size: 1.5rem; font-weight: bold; line-height: 1; opacity: 0.8; cursor: pointer; margin-left: auto; padding: 0 15px; }
        .ticker-close:hover { opacity: 1; }
        .verification .ticker-close { color: #212529; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }
        /* --- END REWORK --- */

        #toast-container { position: fixed; top: 20px; right: 20px; z-index: 1060; display: flex; flex-direction: column; gap: 10px; }
        .toast-notification { padding: 15px 20px; border-radius: var(--border-radius); color: white; background-color: var(--success-color); box-shadow: var(--box-shadow); opacity: 0; animation: toast-fade-in 0.5s forwards, toast-fade-out 0.5s 4.5s forwards; font-weight: 500; }
        @keyframes toast-fade-in { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toast-fade-out { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); } }
        
        .breakdown-history-table {
            font-size: 0.85rem;
        }
        .breakdown-history-table thead {
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .mobile-card-view {
            display: none;
        }
        
        /* --- MOBILE CARD STYLES --- */
        .complaint-card-mobile {
            --card-bg: #ffffff;
            --primary-text: #333333;
            --secondary-text: #6c757d;
            --border-color: #e9ecef;
            --orange: #f0ad4e;
            --green: #28a745;
            --grey: #ced4da;
            --blue: #007bff;
            --danger: #dc3545;
            --light-grey-bg: #f8f9fa;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            max-width: 450px;
            width: 100%;
            padding: 1.5rem;
            box-sizing: border-box;
            margin: 0 auto;
            border: 2px solid transparent;
        }

        .card-border-1 {
            border-image: linear-gradient(to top right, #3a7bd5, #00d2ff) 1;
        }
        .card-border-2 {
            border: 2px dashed var(--danger-color);
        }
        .card-border-3 {
            border-image: linear-gradient(to top right, #ff416c, #ff4b2b) 1;
        }
        .card-border-4 {
            border: 2px solid var(--success-color);
            border-radius: 20px;
        }
        
        .complaint-card-mobile .section-title {
            font-weight: 600;
            color: var(--primary-text);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .complaint-card-mobile .escalation-matrix {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 1.5rem;
        }
        
        .complaint-card-mobile .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .complaint-card-mobile .details-grid .detail-item.full-width {
            grid-column: 1 / -1;
        }
        
        .complaint-card-mobile .detail-item .label {
            color: var(--secondary-text);
            display: block;
            margin-bottom: 0.25rem;
            font-weight: 400;
        }

        .complaint-card-mobile .detail-item .value {
            color: var(--primary-text);
            font-weight: 600;
        }

        .complaint-card-mobile .detail-item .time-since-reported {
            font-size: 0.8rem;
            font-weight: 400;
            display: block;
            margin-top: 2px;
        }
        
        .complaint-card-mobile .comment-section {
            margin-bottom: 1.5rem;
        }
        
        .complaint-card-mobile .comment-section .label {
            color: var(--secondary-text);
            font-weight: 400;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }
        
        .complaint-card-mobile .comment-section .value {
            color: var(--primary-text);
            font-weight: 500;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .complaint-card-mobile .collapsible-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-in-out, opacity 0.3s ease-in-out;
            opacity: 0;
            visibility: hidden;
        }

        .complaint-card-mobile.is-expanded .collapsible-details {
            max-height: 1500px;
            opacity: 1;
            visibility: visible;
        }

        .card-expander .expand-toggle-btn {
            border-radius: 50px;
            padding: 5px 15px;
            font-weight: 500;
            width: 150px;
        }

        .card-expander .expand-toggle-btn .fa-chevron-up {
            transform: rotate(180deg);
        }

        .card-expander .expand-toggle-btn i {
            transition: transform 0.3s ease;
        }


@media (max-width: 767px) {
    .page-content button.btn {
        background-color: #008cff !important;
        border: none;
        padding: 18px 6px;
        color: #fff !important;
    }
    i.fas.fa-chevron-down.ms-2 {
    font-size: 17px !important;
    margin: -6px;
}
    
    button#followUpFilterBtn {
    padding: 9px;
}
button#breakdownFilterBtn {
    padding: 9px;
}
button#refreshBtn {
        padding: 9px;

}

button.btn-sm.btn-info.text-white {
    padding: 10px;
}
button#exportExcelBtn {
    padding: 11px;
}

button#newReportBtn {
    padding: 10px;
}

.page-wrapper {
    height: 100%;
    padding: 5px !important;
     margin-top: 30px !important;
}

.card-footer.d-flex.justify-content-between.align-items-center.flex-wrap.gap-2 {
    margin-bottom: 54px;
    padding: 6px 0px;
}

button.btn.btn-sm.btn-outline-secondary.nav-link {
    display: none;
}



}
        /* --- Responsive Styles --- */
        @media (min-width: 992.02px) {
            .mobile-card-view { display: none !important; }
        }

        @media (max-width: 992px) {
            
            .desktop-view { display: none !important; }
            .mobile-card-view { display: block !important; }

            .card-header h5 { display: none; }
            .table-report { min-width: 100%; border-spacing: 0; border-collapse: collapse; }
            .table-report thead { display: none; }
            
            .table-report tbody tr {
                display: block;
                border: none;
                background-color: transparent;
                padding: 0;
                margin-bottom: 1.5rem;
                box-shadow: none;
            }
             .table-report td {
                 display: block;
                 border: none;
                 padding: 0;
             }
           
            /* Responsive History Modal */
            .history-modal .report-header { flex-direction: column; align-items: stretch; gap: 1rem; }
            .history-modal .evidence-section { justify-content: center; }
            .history-modal .header-right-panel { flex-direction: row; justify-content: space-between; align-items: center; margin-top: 1rem; }
            .history-modal .area-status { text-align: left; }
            .history-modal .report-table thead { display: none; }
            .history-modal .report-table tbody tr { display: block; margin-bottom: 1rem; padding: 1rem; border: 1px solid var(--border-color); border-radius: var(--border-radius); }
            .history-modal .report-table td { display: flex; justify-content: space-between; text-align: right; padding: .5rem 0; border: none; }
            .history-modal .report-table tr td:last-child { border-bottom: none; }
            .history-modal .report-table td > * { max-width: 60%; }
            .history-modal .report-table td::before { content: attr(data-label); font-weight: bold; text-align: left; margin-right: 1rem; }
            /* Complaint Form Responsive */
            #complaintFormModal .modal-body { padding: 0.75rem; }
            #complaintFormModal .image-collage-preview { grid-template-columns: repeat(3, 1fr); }
            .optional-details-toggle-wrapper > h4 { cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
            .optional-toggle-icon { transition: transform 0.2s ease-in-out; }
            .optional-details-toggle-wrapper:not(.is-expanded) .optional-selectors-grid { display: none; }
            .optional-details-toggle-wrapper.is-expanded .optional-selectors-grid { margin-top: 1rem; }
            .optional-details-toggle-wrapper.is-expanded .optional-toggle-icon { transform: rotate(180deg); }
            body.modal-open::after { content: ''; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1051; }
            .details-container .multi-select-dropdown { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90vw; max-width: 400px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15); }
        
            #bulkUploadModal .modal-dialog {
                max-width: 100%;
                margin: 0;
            }
            #bulkUploadModal .modal-content {
                height: 100vh;
                border-radius: 0;
                border: none;
            }
             #bulkUploadModal .modal-body {
                overflow-y: auto;
            }
        }
        
        button#bulkAcknowledgeBtn {
    border: 0px;
}   
button#newReportBtn {
    border: 0px;
}
button#exportExcelBtn {
    border: 0px;
}

button.btn-sm.btn-info.text-white {
    border: 0px;
}

span.badge.badge-breakdown.mt-1.Breakdownspan {
    background-color: var(--details-danger-light);
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
}
    </style>

@section('content')

    <div id="toast-container"></div>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card" style="z-index:000;">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">Report Management</h5>
                        
                        




                        <div class="d-flex gap-1 align-items-center flex-wrap">
                            <div id="offline-status-container" class="d-flex align-items-center ">
                               <span id="connection-status-indicator" class="badge rounded-pill"></span>
                               <span id="connection-status-text" class="d-none d-sm-inline small fw-bold"></span>
                            </div>
                            <button class="btn-sm btn-outline-primary d-lg-none" id="mobileFilterBtn" data-bs-toggle="modal" data-bs-target="#filterModal">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                                      
    <button style="color: #fff;" class="btn btn-sm btn-outline-secondary nav-link" 
            onclick="window.location='{{ route('department') }}'" 
            style="background: auto !important;">
        <i class="fas fa-map-marker-alt me-1 me-sm-2"></i>
        <span class="d-none d-sm-inline">Location Management</span>
    </button>



    <button style="color: #fff;" class="btn btn-sm btn-outline-secondary nav-link" 
            onclick="window.location='{{ route('responsibility') }}'" 
            style="background: auto !important;">
        <i class="fas fa-tasks me-1 me-sm-2"></i>
        <span class="d-none d-sm-inline">Responsibility</span>
    </button>



    <button style="color: #fff;" class="btn btn-sm btn-outline-secondary nav-link" 
            onclick="window.location='{{ route('userconcern') }}'" 
            style="background: auto !important;">
        <i class="fas fa-exclamation-circle me-1 me-sm-2"></i>
        <span class="d-none d-sm-inline">Concern Management</span>
    </button>

                            <button class="btn-sm btn-outline-secondary" id="followUpFilterBtn" style="background: auto !important;">
                                <i class="fas fa-star me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Follow Up</span>
                            </button>
                            <button class="btn-sm btn-outline-danger" id="breakdownFilterBtn">
                                <i class="fas fa-exclamation-triangle me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Breakdown</span>
                            </button>
                            <button class="btn-sm btn-outline-secondary" id="refreshBtn">
                                <i class="fas fa-sync-alt me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline"><a href="https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list">Refresh</a></span>
                            </button>
                            <button class="btn-sm btn-warning" id="bulkAcknowledgeBtn" style="display: none;">
                                <i class="fas fa-check-double me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Acknowledge (<span id="selectedCount">0</span>)</span>
                            </button>
                            <button class="btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                                <i class="fas fa-images me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Bulk Upload</span>
                            </button>
                      <button class="btn-sm btn-primary" id="newReportBtn"
        onclick="window.location.href='https://efsm.safefoodmitra.com/admin/public/index.php/inspection/bulkupload'">
    <i class="fas fa-plus me-1 me-sm-2"></i>
    <span class="d-none d-sm-inline">New Report</span>
</button>
                            
                            <!--    <button class="btn-sm btn-primary" id="newReportBtn1" >-->
                            <!--    <span > <i class="fas fa-plus me-1 me-sm-2"></i>New Report</span>-->
                            <!--</button>-->
                            
                            
                            <button class="btn-sm btn-success" id="exportExcelBtn">
                                <i class="fas fa-file-excel me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Export to Excel</span>
                            </button>
                        </div>
                    </div>
                    <!-- Alert Ticker Container -->
                    <div id="alert-container" class="mt-2">
                        <div id="observation-ticker" class="alert-ticker observation">
                            <div class="ticker-wrap"><div class="ticker-content"></div><button class="ticker-close">&times;</button></div>
                        </div>
                        <div id="breakdown-ticker" class="alert-ticker breakdown">
                             <div class="ticker-wrap"><div class="ticker-content"></div><button class="ticker-close">&times;</button></div>
                        </div>
                        <div id="verification-ticker" class="alert-ticker verification">
                             <div class="ticker-wrap"><div class="ticker-content"></div><button class="ticker-close">&times;</button></div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-report" id="incidentReportTable">
                             <thead>
                                <tr>
                                    <th width="40"><input class="form-check-input" type="checkbox" id="selectAllCheckbox" title="Select all"></th>
                                    <th width="180">Evidence</th>
                                    <th width="450">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Report Details</span>
                                            <div class="dropdown d-none d-lg-block">
                                                <button class="btn btn-sm btn-icon detailsFilterBtn" type="button" id="detailsFilterBtn" data-bs-toggle="dropdown" data-bs-strategy="fixed" aria-expanded="false" data-bs-auto-close="outside" title="Filter Details">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <div class="dropdown-menu p-3" aria-labelledby="detailsFilterBtn" style="min-width: 300px;">
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-bold">SOP Name</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search SOPs..." id="sopSearchInput">
                                                        <div id="sopFilterList" class="filter-list"></div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-bold">Risk</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search Risks..." id="riskSearchInput">
                                                        <div id="riskFilterList" class="filter-list"></div>
                                                    </div>
                                                    <div>
                                                        <label class="form-label small fw-bold">Responsibility</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="responsibilitySearchInput">
                                                        <div id="responsibilityFilterList" class="filter-list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="250">Closure Comments</th>
                                    <th width="220">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Area</span>
                                            <div class="dropdown d-none d-lg-block">
                                                <button class="btn btn-sm btn-icon areaFilterBtn" type="button" id="areaFilterBtn" data-bs-toggle="dropdown" data-bs-strategy="fixed" aria-expanded="false" data-bs-auto-close="outside" title="Filter Area">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <div class="dropdown-menu p-3" aria-labelledby="areaFilterBtn" style="min-width: 300px;">
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-bold">Regional</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="regionSearchInput">
                                                        <div id="regionFilterList" class="filter-list"></div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-bold">Unit</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="unitSearchInput">
                                                        <div id="unitFilterList" class="filter-list"></div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-bold">Department</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="departmentSearchInput">
                                                        <div id="departmentFilterList" class="filter-list"></div>
                                                    </div>
                                                    <div>
                                                        <label class="form-label small fw-bold">Location</label>
                                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="locationSearchInput">
                                                        <div id="locationFilterList" class="filter-list"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="180">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Status</span>
                                             <div class="dropdown d-none d-lg-block">
                                                <button class="btn btn-sm btn-icon statusFilterBtn" type="button" id="statusFilterBtn" data-bs-toggle="dropdown" data-bs-strategy="fixed" aria-expanded="false" data-bs-auto-close="outside" title="Filter Status">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <div class="dropdown-menu p-3" aria-labelledby="statusFilterBtn">
                                                    <input type="search" class="form-control form-control-sm mb-2" placeholder="Search..." id="statusSearchInput">
                                                    <div id="statusFilterList" class="filter-list" style="max-height: 150px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="450">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Tracking Status</span>
                                            <div class="dropdown d-none d-lg-block">
                                                <button class="btn btn-sm btn-icon" type="button" id="trackingFilterBtn" data-bs-toggle="dropdown" data-bs-strategy="fixed" aria-expanded="false" data-bs-auto-close="outside" title="Filter Tracking Status">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                                <div class="dropdown-menu p-3" aria-labelledby="trackingFilterBtn" style="min-width: 320px;">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">By Reporting Date</label>
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">From</span>
                                                            <input type="date" class="form-control" id="reportingDateFrom">
                                                        </div>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">To</span>
                                                            <input type="date" class="form-control" id="reportingDateTo">
                                                        </div>
                                                    </div>
                                                     <div class="mb-3">
                                                        <label class="form-label small fw-bold">By Closure Date</label>
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">From</span>
                                                            <input type="date" class="form-control" id="closureDateFrom">
                                                        </div>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">To</span>
                                                            <input type="date" class="form-control" id="closureDateTo">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="form-label small fw-bold">By Timeline Stage</label>
                                                        <div id="timelineStageFilterList">
                                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="owner" id="pendingOwnerAck"><label class="form-check-label" for="pendingOwnerAck">Pending Owner Ack</label></div>
                                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="assignment" id="pendingAssignment"><label class="form-check-label" for="pendingAssignment">Pending Assignment</label></div>
                                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="staff" id="pendingStaffAck"><label class="form-check-label" for="pendingStaffAck">Pending Staff Ack</label></div>
                                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="completion" id="pendingCompletion"><label class="form-check-label" for="pendingCompletion">Pending Completion</label></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be dynamically injected by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div id="paginationInfo" class="text-muted small"></div>
                    <div class="d-flex align-items-center">
                       <select id="itemsPerPageSelect" class="form-select form-select-sm me-3" style="width:auto;">
    <option value="3"  {{ request('limit') == 3 ? 'selected' : '' }}>3 per page</option>
    <option value="5"  {{ request('limit') == 5 ? 'selected' : '' }}>5 per page</option>
    <option value="10" {{ request('limit') == 10 || request('limit') == null ? 'selected' : '' }}>10 per page</option>
    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25 per page</option>
    <option value="all" {{ request('limit') == 'all' ? 'selected' : '' }}>All</option>
</select>
                        <!--<select class="form-select form-select-sm me-3" id="itemsPerPageSelect" style="width: auto;"><option value="3" >3 per page</option><option value="5">5 per page</option><option value="10" selected>10 per page</option><option value="25">25 per page</option></select>-->
                        <nav aria-label="Page navigation"><ul class="pagination pagination-sm mb-0" id="paginationControls"></ul></nav>
  

{{ $inspection_list->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HTML TEMPLATE FOR TABLE ROW -->
    <template id="report-row-template">
        <tr data-incident-id="" data-reported-time="" data-sop="" data-risk="" data-region="" data-unit="" data-department="" data-location="" data-status="" data-registered-by="">
            <!-- DESKTOP VIEW CELLS -->
            <td class="desktop-view" data-label="Select">
                <!-- Checkbox will be added by JS if needed -->
            </td>
            <td class="desktop-view" data-label="Evidence">
                <div class="image-cell">
                    <!-- Image thumbnails will be injected here -->
                </div>
            </td>
            <td class="desktop-view concern-details" data-label="Report Details">
                <button class="btn btn-icon btn-star" title="Mark for follow-up"><i class="far fa-star"></i></button>
                <div class="concern-title-wrapper">
                    <div class="concern-id"></div>
                    <div class="concern-title"></div>
                    <div class="concern-meta"></div>
                    <div class="concern-responsibility"></div>
                </div>
            </td>
            <td class="desktop-view" data-label="Closure Comments"><span class="closure-comments-cell">---</span></td>
            <td class="desktop-view" data-label="Area"><span></span></td>
            <td class="desktop-view" data-label="Status"><div><span class="status-badge"></span><div class="time-since-reported"></div></div></td>
            <td class="desktop-view" data-label="Tracking Status"><div class="progress-tracker"></div></td>
            <td class="desktop-view" data-label="Actions">
                <div class="action-btn-group">
                    <button class="action-btn btn-compliance" title="Mark as Compliance"><i class="fas fa-check-circle text-success"></i></button>
                    <button class="action-btn btn-not-compliance" title="Mark as Not Compliance / Re-open"><i class="fas fa-times-circle text-danger"></i></button>
                    <button class="action-btn btn-not-applicable" title="Mark as Not Applicable"><i class="fas fa-ban text-secondary"></i></button>
                    <button class="action-btn btn-not-applicable1" title="Not Done"><i class="fas fa-hourglass-half text-warning"></i></button>
                    <button class="action-btn btn-breakdown" title="Mark as Breakdown"><i class="fas fa-exclamation-triangle text-danger"></i></button>
                    <button class="action-btn btn-breakdown-update" title="Update Breakdown Status"><i class="fas fa-tasks text-primary"></i></button>
                    <button class="action-btn btn-edit" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                    <button class="action-btn btn-view" title="View"><i class="fas fa-eye"></i></button>
                    <button class="action-btn btn btn-sm btn-info text-white btn-assign" title="Acknowledge & Assign"><i class="fas fa-user-plus"></i></button>
                    <button class="action-btn btn btn-sm btn-success text-white btn-complete-task" title="Complete Task"><i class="fas fa-check-double"></i></button>
                    <button class="action-btn btn btn-sm btn-outline-secondary btn-progress" title="Progress Update"><i class="fas fa-comment-dots"></i></button>
                    <button class="action-btn btn btn-sm btn-outline-danger btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>

            <!-- MOBILE VIEW CONTAINER -->
            <td class="mobile-card-view">
                <div class="complaint-card-mobile">
                    <!-- Always Visible Content -->
                    <div class="image-cell" style="padding-bottom: 1.5rem; flex-wrap: wrap; justify-content: center;">
                        <!-- Mobile images will be injected here -->
                    </div>
                    <div class="action-btn-group d-flex justify-content-center flex-wrap gap-2 mb-3 border-bottom pb-3">
                         <button class="action-btn btn-star" title="Mark for follow-up"><i class="far fa-star"></i></button>
                        <button class="action-btn btn-compliance" title="Mark as Compliance"><i class="fas fa-check-circle text-success"></i></button>
                        <button class="action-btn btn-not-compliance" title="Mark as Not Compliance / Re-open"><i class="fas fa-times-circle text-danger"></i></button>
                        <button class="action-btn btn-not-applicable" title="Mark as Not Applicable"><i class="fas fa-ban text-secondary"></i></button>
                        <button class="action-btn btn-not-applicable1" title="Not Done"><i class="fas fa-hourglass-half text-warning"></i></button>
                        <button class="action-btn btn-breakdown" title="Mark as Breakdown"><i class="fas fa-exclamation-triangle text-danger"></i></button>
                        <button class="action-btn btn-breakdown-update" title="Update Breakdown Status"><i class="fas fa-tasks text-primary"></i></button>
                        <button class="action-btn btn-edit" title="Edit"><i class="fas fa-pencil-alt"></i></button>
                        <button class="action-btn btn-view" title="View"><i class="fas fa-eye"></i></button>
                        <button class="action-btn btn btn-sm btn-info text-white btn-assign" title="Acknowledge & Assign"><i class="fas fa-user-plus"></i></button>
                        <button class="action-btn btn btn-sm btn-success text-white btn-complete-task" title="Complete Task"><i class="fas fa-check-double"></i></button>
                        <button class="action-btn btn btn-sm btn-outline-secondary btn-progress" title="Progress Update"><i class="fas fa-comment-dots"></i></button>
                        <button class="action-btn btn btn-sm btn-outline-danger btn-delete" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </div>
                     <div class="comment-section">
                        <div class="label">Concern Comments:</div>
                        <div class="value" data-mobile="concern-comments"></div>
                    </div>
                    <div class="comment-section">
                        <div class="label">Closure Comments:</div>
                        <div class="value" data-mobile="closure-comments"></div>
                    </div>

                    <!-- Collapsible Section -->
                    <div class="collapsible-details">
                        <h2 class="section-title mt-4">Escalation Matrix</h2>
                        <div class="escalation-matrix progress-tracker">
                            <!-- Mobile escalation matrix will be dynamically populated here -->
                        </div>
                        <div class="details-grid">
                            <div class="detail-item">
                                <span class="label">Complain Number:</span>
                                <span class="value" data-mobile="complain-number"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Created By:</span>
                                <span class="value" data-mobile="created-by"></span>
                            </div>
                            <div class="detail-item full-width">
                                <span class="label">Area:</span>
                                <span class="value" data-mobile="area"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Created Date:</span>
                                <span class="value" data-mobile="created-date"></span>
                            </div>
                             <div class="detail-item">
                                <span class="label">Closer Date:</span>
                                <span class="value" data-mobile="closer-date"></span>
                            </div>
                             <div class="detail-item">
                                <span class="label">Responsibility:</span>
                                <span class="value" data-mobile="responsibility"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Risk:</span>
                                <span class="value" data-mobile="risk"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Status:</span>
                                <span class="value" data-mobile="status"></span>
                                <span class="time-since-reported"></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Closed By:</span>
                                <span class="value" data-mobile="closed-by"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Expander Button -->
                    <div class="card-expander text-center mt-2 border-top pt-3">
                        <button class="btn btn-sm btn-outline-primary expand-toggle-btn">
                            <span>Show Details</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                    </div>
                </div>
            </td>
        </tr>
    </template>
    
    <!-- MOBILE FILTER MODAL -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Reports</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="filterAccordion">
                        <!-- Report Details Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDetails">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetails" aria-expanded="false" aria-controls="collapseDetails">
                                    Report Details
                                </button>
                            </h2>
                            <div id="collapseDetails" class="accordion-collapse collapse" aria-labelledby="headingDetails" data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">SOP Name</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search SOPs..." id="sopSearchInput_mobile">
                                        <div id="sopFilterList_mobile" class="filter-list"></div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Risk</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search Risks..." id="riskSearchInput_mobile">
                                        <div id="riskFilterList_mobile" class="filter-list"></div>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">Responsibility</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="responsibilitySearchInput_mobile">
                                        <div id="responsibilityFilterList_mobile" class="filter-list"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Area Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingArea">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseArea" aria-expanded="false" aria-controls="collapseArea">
                                    Area
                                </button>
                            </h2>
                            <div id="collapseArea" class="accordion-collapse collapse" aria-labelledby="headingArea" data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                     <div class="mb-2">
                                        <label class="form-label small fw-bold">Regional</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="regionSearchInput_mobile">
                                        <div id="regionFilterList_mobile" class="filter-list"></div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Unit</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="unitSearchInput_mobile">
                                        <div id="unitFilterList_mobile" class="filter-list"></div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Department</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="departmentSearchInput_mobile">
                                        <div id="departmentFilterList_mobile" class="filter-list"></div>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">Location</label>
                                        <input type="search" class="form-control form-control-sm mb-1" placeholder="Search..." id="locationSearchInput_mobile">
                                        <div id="locationFilterList_mobile" class="filter-list"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Status Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingStatus">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStatus" aria-expanded="false" aria-controls="collapseStatus">
                                    Status
                                </button>
                            </h2>
                            <div id="collapseStatus" class="accordion-collapse collapse" aria-labelledby="headingStatus" data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <input type="search" class="form-control form-control-sm mb-2" placeholder="Search..." id="statusSearchInput_mobile">
                                    <div id="statusFilterList_mobile" class="filter-list" style="max-height: 150px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Tracking Filter -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTracking">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTracking" aria-expanded="false" aria-controls="collapseTracking">
                                    Tracking Status
                                </button>
                            </h2>
                            <div id="collapseTracking" class="accordion-collapse collapse" aria-labelledby="headingTracking" data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                     <div class="mb-3">
                                        <label class="form-label small fw-bold">By Reporting Date</label>
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text">From</span>
                                            <input type="date" class="form-control" id="reportingDateFrom_mobile">
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">To</span>
                                            <input type="date" class="form-control" id="reportingDateTo_mobile">
                                        </div>
                                    </div>
                                     <div class="mb-3">
                                        <label class="form-label small fw-bold">By Closure Date</label>
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text">From</span>
                                            <input type="date" class="form-control" id="closureDateFrom_mobile">
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">To</span>
                                            <input type="date" class="form-control" id="closureDateTo_mobile">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">By Timeline Stage</label>
                                        <div id="timelineStageFilterList_mobile">
                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="owner" id="pendingOwnerAck_mobile"><label class="form-check-label" for="pendingOwnerAck_mobile">Pending Owner Ack</label></div>
                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="assignment" id="pendingAssignment_mobile"><label class="form-check-label" for="pendingAssignment_mobile">Pending Assignment</label></div>
                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="staff" id="pendingStaffAck_mobile"><label class="form-check-label" for="pendingStaffAck_mobile">Pending Staff Ack</label></div>
                                             <div class="form-check"><input class="form-check-input" type="checkbox" value="completion" id="pendingCompletion_mobile"><label class="form-check-label" for="pendingCompletion_mobile">Pending Completion</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="clearFiltersModalBtn">Clear Filters</button>
                    <button type="button" class="btn btn-primary" id="applybutton" data-bs-dismiss="modal">Apply</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="assignModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Acknowledge Report</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div id="assignChoiceContainer"><p>How would you like to proceed?</p><div class="d-grid gap-2"><button type="button" class="btn btn-primary btn-lg" id="showAssignDetailsBtn"><i class="fas fa-user-friends me-2"></i> Assign to Staff</button><button type="button" class="btn btn-success btn-lg" id="attendMyselfBtn"><i class="fas fa-user-check me-2"></i> Attend Myself</button><button type="button" class="btn btn-warning btn-lg text-dark" id="scheduleTaskBtn"><i class="far fa-calendar-alt me-2"></i> Schedule Task</button></div></div><div id="assignDetailsContainer" style="display: none;"><input type="hidden" id="assignIncidentId"><div class="mb-3"><label class="form-label">Assign To:</label><input type="text" class="form-control" id="staffSearchInput" placeholder="Search for staff..."><ul id="staffSelectionList" class="filter-list mt-2" style="max-height: 150px;"></ul></div><div class="mb-3"><label for="assignmentNotes" class="form-label">Notes:</label><textarea class="form-control" id="assignmentNotes" rows="3"></textarea></div></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary d-none" id="confirmAssignmentBtn">Confirm Assignment</button></div></div></div></div>
    <div class="modal fade" id="staffAckModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Acknowledge Task</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="staffAckIncidentId"><p>Attend to this task now or schedule it?</p></div><div class="modal-footer d-flex justify-content-between"><button type="button" class="btn btn-primary" id="attendNowBtn"><i class="fas fa-bolt me-2"></i>Attend Now</button><button type="button" class="btn btn-secondary" id="attendLaterBtn"><i class="far fa-calendar-alt me-2"></i>Schedule</button></div></div></div></div>
    <div class="modal fade" id="attendLaterModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Schedule Task</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="attendLaterIncidentId"><p>Provide a tentative date and time.</p><div class="mb-3"><label for="tentativeDate" class="form-label">Date</label><input type="date" class="form-control" id="tentativeDate"></div><div class="mb-3"><label for="tentativeTime" class="form-label">Time</label><input type="time" class="form-control" id="tentativeTime"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmScheduleBtn">Schedule</button></div></div></div></div>
    <div class="modal fade" id="closureModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Observation Closure Form</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="closureIncidentId"><div class="mb-3"><label for="correctiveAction" class="form-label">Corrective Action Taken:</label><textarea class="form-control" id="correctiveAction" rows="4"></textarea></div><div class="mb-3"><label for="afterPhoto" class="form-label">Upload "After" Photo:</label><input class="form-control" type="file" id="afterPhoto" accept="image/*"></div><div id="afterPhotoPreviewContainer" class="text-center d-none mt-3"><img id="afterPhotoPreview" src="" alt="After Photo Preview" style="max-height: 200px; border-radius: 8px;"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="confirmClosureBtn">Submit Closure</button></div></div></div></div>
    <div class="modal fade" id="scheduleModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Schedule Task</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="scheduleIncidentId"><p>Select a date and add comments for the scheduled task.</p><div class="mb-3"><label for="scheduleDate" class="form-label">Date</label><input type="date" class="form-control" id="scheduleDate"></div><div class="mb-3"><label for="scheduleComments" class="form-label">Comments</label><textarea class="form-control" id="scheduleComments" rows="3"></textarea></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmMainScheduleBtn">Confirm Schedule</button></div></div></div></div>
    <div class="modal fade" id="imageModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Image Preview</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body image-modal-body text-center"></div></div></div></div>
    <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="bulkUploadModalLabel">Bulk Image Upload</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><div class="row g-3"><div class="col-12"><label for="bulkLocationSearch" class="form-label"><strong>Step 1:</strong> Select a Location for this batch</label><div class="dropdown"><input type="text" class="form-control" id="bulkLocationSearch" placeholder="Search and select a location..." data-bs-toggle="dropdown" autocomplete="off"><input type="hidden" id="bulkLocationSelectValue"><ul class="dropdown-menu w-100" id="bulkLocationList" aria-labelledby="bulkLocationSearch"></ul></div></div>
    <div class="col-12">
        <label class="form-label"><strong>Step 2:</strong> Add Images</label>
        <div id="bulkUploadDropzone">
            <input type="file" id="bulkImageInput" multiple accept="image/*">
            <label for="bulkImageInput"></label> 
            <div class="dropzone-content">
                <i class="fas fa-cloud-arrow-up dropzone-icon"></i>
                <h6>Drag & drop files here</h6>
                <p class="small">Maximum file size: 10MB</p>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('bulkImageInput').click();">
                    <i class="fas fa-folder-open me-2"></i>Or Browse Files
                </button>
            </div>
        </div>
    </div>
</div><hr class="my-4"><div id="bulkUploadPreviewArea"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="processBulkUploadBtn" disabled><span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span> Process Upload (<span id="bulkImageCount">0</span>)</button></div></div></div></div>
        
    <!-- Breakdown Modals -->
    <div class="modal fade" id="breakdownModal" tabindex="-1" aria-labelledby="breakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="breakdownModalLabel">Breakdown Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="breakdownForm">
                        <input type="hidden" id="breakdownIncidentId">
                        <div class="mb-3">
                            <label for="breakdownEquipmentSearch" class="form-label">Equipment</label>
                            <div class="dropdown">
                                <input type="text" class="form-control" id="breakdownEquipmentSearch" placeholder="Search and select equipment..." data-bs-toggle="dropdown" autocomplete="off" required>
                                <input type="hidden" id="breakdownEquipment">
                                <ul class="dropdown-menu w-100" id="breakdownEquipmentList" aria-labelledby="breakdownEquipmentSearch">
                                    <!-- Search results will be populated here by JS -->
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="breakdownRootCause" class="form-label">Root Cause for Breakdown</label>
                            <textarea class="form-control" id="breakdownRootCause" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="breakdownClosureDate" class="form-label">Tentative Closure Date</label>
                            <input type="date" class="form-control" id="breakdownClosureDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="breakdownStepTaken" class="form-label">Current Step Taken</label>
                            <textarea class="form-control" id="breakdownStepTaken" rows="2" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBreakdownBtn">Save Details</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="breakdownUpdateModal" tabindex="-1" aria-labelledby="breakdownUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="breakdownUpdateModalLabel">Breakdown Status Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div id="breakdownUpdateFormContainer">
                        <h6 class="mb-3">Post New Update</h6>
                        <form id="breakdownUpdateForm">
                            <input type="hidden" id="breakdownUpdateIncidentId">
                             <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="breakdownUpdateDate" class="form-label">Update Date</label>
                                    <input type="date" class="form-control" id="breakdownUpdateDate" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="breakdownUpdateCost" class="form-label">Cost Incurred</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" id="breakdownUpdateCost" min="0" step="0.01" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="breakdownUpdateComments" class="form-label">Corrective Action / Comments</label>
                                <textarea class="form-control" id="breakdownUpdateComments" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4">
                        <h6 class="mb-3">Breakdown History</h6>
                        <div class="table-responsive" style="max-height: 40vh; overflow-y: auto;">
                            <!-- REWORK: Table styling updated for consistency -->
                            <table class="table table-bordered table-striped table-sm breakdown-history-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Reported Date</th>
                                        <th>Reported By</th>
                                        <th>Breakdown Reason</th>
                                        <th>Tentative Date</th>
                                        <th>Corrective Action</th>
                                        <th>Closure Date</th>
                                        <th>Rectified By</th>
                                        <th>Verified By</th>
                                        <th>Verification Date</th>
                                        <th>Incurred Expenses</th>
                                    </tr>
                                </thead>
                                <tbody id="breakdownHistoryContainer">
                                    <!-- History will be injected here by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmBreakdownUpdateBtn">Post Update</button>
                    <button type="button" class="btn btn-warning" id="confirmBreakdownResolveBtn">Resolve Breakdown</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Verification Modal -->
    <div class="modal fade" id="breakdownVerificationModal" tabindex="-1" aria-labelledby="breakdownVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-lg-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="breakdownVerificationModalLabel">Verify Breakdown Closure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="breakdownVerificationIncidentId">
                    <div class="mb-3">
                       <label for="verificationComments" class="form-label">Verification Comments</label>
                       <textarea class="form-control" id="verificationComments" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                       <label for="verificationSignaturePad" class="form-label d-block">Verification Signature</label>
                       <canvas id="verificationSignaturePad" class="signature-pad" width="400" height="150"></canvas>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2 d-block" id="clearVerificationSignatureBtn">Clear Signature</button>
                    </div>
                    <div class="mt-4">
                        <h6 class="mb-3">Breakdown History for Review</h6>
                         <div class="table-responsive" style="max-height: 30vh; overflow-y: auto;">
                             <!-- REWORK: Table styling updated for consistency -->
                            <table class="table table-bordered table-striped table-sm breakdown-history-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Reported Date</th>
                                        <th>Reported By</th>
                                        <th>Breakdown Reason</th>
                                        <th>Corrective Action</th>
                                        <th>Rectified By</th>
                                        <th>Incurred Expenses</th>
                                    </tr>
                                </thead>
                                <tbody id="verificationHistoryContainer">
                                    <!-- Simplified History will be injected here by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="rejectBreakdownBtn">Reject</button>
                    <button type="button" class="btn btn-success" id="finalSubmitVerificationBtn">Final Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Non-Compliance, NA, History Modals -->
    <div class="modal fade" id="nonComplianceModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Re-open as Non-Compliance</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>This will create a <strong>new open observation</strong> based on the previous one. Please provide the reason and new evidence.</p><form id="nonComplianceForm"><input type="hidden" id="nonComplianceOriginalId"><div class="mb-3"><label for="nonComplianceComments" class="form-label">Reason for Non-Compliance:</label><textarea class="form-control" id="nonComplianceComments" rows="4" required></textarea></div><div class="mb-3"><label for="nonCompliancePhoto" class="form-label">Upload New "Before" Photo:</label><input class="form-control" type="file" id="nonCompliancePhoto" accept="image/*" required></div><div id="nonCompliancePhotoPreviewContainer" class="text-center d-none mt-3"><img id="nonCompliancePhotoPreview" src="" alt="Non-Compliance Photo Preview" style="max-height: 200px; border-radius: 8px;"></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" id="confirmNonComplianceBtn">Create New Observation</button></div></div></div></div>
    <div class="modal fade" id="naModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Mark as Not Applicable</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Provide a reason for marking this as not applicable. This will be added to the follow-up history.</p><form id="naForm"><input type="hidden" id="naIncidentId"><div class="mb-3"><label for="naComments" class="form-label">Reason:</label><textarea class="form-control" id="naComments" rows="4" required></textarea></div><div class="mb-3"><label for="naEvidence" class="form-label">Upload Evidence (Optional):</label><input class="form-control" type="file" id="naEvidence" accept="image/*,video/*"></div></form></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" id="confirmNaBtn">Submit</button></div></div></div></div>
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true"><div class="modal-dialog modal-fullscreen"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="historyModalLabel">Follow Up History</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body history-modal" id="historyModalBody"><div id="report-root" class="report-container"><div class="report-timestamps"><div><strong>Start Date:</strong> <span data-js="start-date"></span></div><div><strong>End Date:</strong> <span data-js="end-date"></span></div></div><div class="report-header"><div class="evidence-section" data-js="evidence-section"></div><div class="report-details"><h2 data-js="title"></h2><div class="meta-info" data-js="meta-info"></div><div class="meta-info" data-js="risk"></div><div class="meta-info" data-js="responsibility"></div></div><div class="header-right-panel"><div class="area-status"><div class="area" data-js="area"></div><div class="status" data-js="status-header"></div></div><div><button class="download-button" data-js="download-button">Download PDF</button></div></div></div><div class="report-table-wrapper"><table class="report-table"><thead><tr><th>Date & Time</th><th>Status</th><th>Comments</th><th>Image/Video</th></tr></thead><tbody data-js="history-table-body"></tbody></table></div></div><div id="report-update-section" class="report-update-section mt-4 p-3 bg-light border rounded" style="max-width: 1200px; margin: 1.5rem auto 0 auto;"><h5 class="mb-3">Post a Progress Update or Comment</h5><div class="mb-3"><label for="historyComment" class="form-label">Comment</label><textarea class="form-control" id="historyComment" rows="3" placeholder="Provide details about the delay or progress..."></textarea></div><div class="mb-3"><label for="historyEvidence" class="form-label">Attach Evidence (Optional)</label><input class="form-control" type="file" id="historyEvidence" accept="image/*,video/*"></div><div class="text-end"><button class="btn btn-primary" id="postHistoryUpdateBtn">Post Update</button></div></div><div id="image-modal" class="modal-overlay" role="dialog" aria-modal="true"><div class="modal-content"><span class="modal-close" data-js="modal-close" aria-label="Close image view">&times;</span><img src="" alt="Enlarged report image" data-js="modal-image"></div></div></div></div></div></div>


<div class="modal fade" id="naModal1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Not Done</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="naForm">
                    <input type="hidden" id="naIncidentId1">

                    <div class="mb-3">
                        <label for="naComments" class="form-label">Reason:</label>
                        <textarea class="form-control" id="naComments" rows="4" required></textarea>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmNaBtn1">Submit</button>
            </div>
        </div>
    </div>
</div>

    <!-- Complaint Form Modal -->

    <!-- END Complaint Form Modal -->

 
    
    
    
    
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Centered + Large -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title exampleModalLabeltext" id="exampleModalLabel">Observation Closure Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body -->
      <div class="modal-body">
          
          <input type="hidden" value="" id="closureIncidentIds">
          <input type="hidden" value="" id="closureIncidentIds1">
        @include('admin.inspection.Observation_Closure_Form')
      </div>
 
      
    </div>
  </div>
</div>



	
@endsection


@section('footerscript')
	   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	   <script>
    window.allDepartments = {!! json_encode($departments->pluck('name')) !!};
    window.allLocations   = {!! json_encode($locations->pluck('name')) !!};
    window.allresponsibility   = {!! json_encode($responsibility->pluck('name')) !!};
    window.allsops   = {!! json_encode($sops->pluck('name')) !!};
</script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    
        // --- CONSOLIDATED AND REWORKED SCRIPT ---
        
        let bulkUploadFiles = [];
        let reportDatabase = {};
        let mobileCardStyleCounter = 0;

        // Mock data for equipment, normally fetched from a server.
        const dummyEquipmentData = {
            "Maintenance-Main Kitchen": ["EQ-MK-001 (Oven)", "EQ-MK-002 (Dishwasher)", "EQ-MK-003 (Exhaust Hood)"],
            "Engineering-Hall 3": ["EQ-H3-101 (Fire Panel)", "EQ-H3-102 (HVAC Unit)"],
            "Food Production-Back Area": ["EQ-FP-055 (Freezer)", "EQ-FP-056 (Blast Chiller)"],
            
            
"Default": [
  @foreach($facility_equipment as $facility_equipments)
    "{{$facility_equipments->name}}"
    @if(!$loop->last),@endif
  @endforeach
]
        };
        
        // Initial static data that will be processed into the table on load.
const initialReportData = [
@foreach($inspection_list as $inspection)
    @php
        $breakdown_history = DB::table('brakdown_history')->where('inspection_id', $inspection->id)->first();
        $isBreakdown = $breakdown_history ? true : false;
        $lastHistory = DB::table('brakdown_history')->where('inspection_id', $inspection->id)->orderBy('id', 'desc')->first();
        $breakdownStatus = $lastHistory->breakdownStatus ?? null;
                $unitDetails = DB::table('users')->where('id',$inspection->unit_id ?? '')->first();
        $unitDetails2 = DB::table('users')->where('id',$unitDetails->created_by1 ?? '')->first();
        $unitDetails3 = DB::table('users')->where('id',$unitDetails->created_by ?? '')->first();
        
              $createduserDetails = DB::table('users')->where('id',$inspection->unit_id ?? '')->first();
              
    @endphp
    {
        incidentId: "{{$inspection->id}}",
        reportedTime: "{{$inspection->created_at}}",
        completedTime: "{{ ($inspection->select_action == 'Resolved') ? $inspection->updated_at : '' }}",
        sop: "SOP: {{$inspection->sops ?? ''}}",
        risk: "Major",
  region: "{{ $inspection->regional ?? ($unitDetails2->company_name ?? '') }}",
unit: "{{ $inspection->unit ?? ($unitDetails->company_name ?? '') }}",
        department: "{{$inspection->sublocation ?? ''}}",
        location: "{{$inspection->location ?? ''}}",
        status: "{{$inspection->select_action ?? ''}}",
        starred: "{{$inspection->starred ?? ''}}",
        registeredBy: "{{ Helper::user_info($inspection->unit_id)->name ?? '' }}",
        assignedTo: "{{ Helper::user_info($inspection->updated_by)->name ?? '' }}",
        title: @json($inspection->title ?? ''),
        responsibility: "{{$inspection->responsibility}}",
        closureComments: "{{$inspection->closure_comments ?? ''}}",
        reopencomment: "{{$inspection->closureComments ?? ''}}",
        images: {
            before: "{{ !empty($inspection->image) ? asset('inspection/' . $inspection->image) : '' }}",
            after: "{{ !empty($inspection->image1) ? asset('inspection/' . $inspection->image1) : '' }}"
        },
        class_name: "{{$inspection->id ?? 'N/A'}}",
        // ЁЯСЗ Breakdown info added dynamically
        isBreakdown: "{{$isBreakdown ? 'true' : 'false'}}",
        breakdownStatus: "{{$breakdownStatus}}",
        breakdown: {
            equipment_id: "{{ $breakdown_history->equipment_id ?? '' }}",
            breakdown: "{{ $breakdown_history->breakdown ?? '' }}",
            tentative_closure_date: "{{ $breakdown_history->tentative_closure_date ?? '' }}",
            current_step_taken: "{{ $breakdown_history->current_step_taken ?? '' }}"
        },
        progress: [
            { 
    stage: 'Registered', 
    user: '{{$createduserDetails->name ?? ''}}', 
    time: '{{ \Carbon\Carbon::parse($inspection->created_at)->format("d-M Y h:i A") }}' 
},
            { stage: 'Owner Ack.', user: 'Rahul V.', time: '19-May 14:30' },
            { stage: 'Assigned', user: 'to Ajay S. (E021)', time: '19-May 14:32' },
            { stage: 'Staff Ack.', user: 'by Ajay S. (E021)', time: '19-May 15:05' },
            { stage: 'Completed', user: 'by Ajay S. (E021)', time: '20-May 14:45' }
        ]
    }@if(!$loop->last),@endif
@endforeach
];

  
  

        const IdGenerator = (() => {
            let dailyCounters = {};
            const pad = (num, size) => ('000' + num).slice(-size);
            const getTodayKey = () => {
                const d = new Date();
                return `${pad(d.getDate(), 2)}${pad(d.getMonth() + 1, 2)}${d.getFullYear()}`;
            };

            return {
                generate: () => {
                    const key = getTodayKey();
                    if (!dailyCounters[key]) { dailyCounters[key] = 0; }
                    dailyCounters[key]++;
                    return `${key}-${pad(dailyCounters[key], 3)}`;
                }
            };
        })();

        // Manages alert tickers and toast notifications.
        const AlertManager = {
            init() {
                this.obsTicker = document.getElementById('observation-ticker');
                this.breakdownTicker = document.getElementById('breakdown-ticker');
                this.verificationTicker = document.getElementById('verification-ticker');
                this.toastContainer = document.getElementById('toast-container');
                
                document.querySelectorAll('.ticker-close').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.target.closest('.alert-ticker').style.display = 'none';
                    });
                });
            },
            _showTicker(tickerEl, message) {
                const contentEl = tickerEl.querySelector('.ticker-content');
                contentEl.innerHTML = message;
                tickerEl.style.display = 'block';
            },
            showObservation(message) {
                this._showTicker(this.obsTicker, `<i class="fas fa-info-circle"></i> ${message}`);
            },
            showBreakdown(message) {
                this._showTicker(this.breakdownTicker, `<i class="fas fa-exclamation-triangle"></i> ${message}`);
            },
            showVerification(message) {
                this._showTicker(this.verificationTicker, `<i class="fas fa-user-check"></i> ${message}`);
            },
            showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast-notification ${type}`;
                toast.innerHTML = message;
                this.toastContainer.appendChild(toast);
                setTimeout(() => { toast.remove(); }, 5000);
            }
        };
    
        // Centralized object to manage all Bootstrap modals.
        const ActionModals = {
            assign: new bootstrap.Modal(document.getElementById("assignModal")),
            staffAck: new bootstrap.Modal(document.getElementById("staffAckModal")),
            attendLater: new bootstrap.Modal(document.getElementById("attendLaterModal")),
            closure: new bootstrap.Modal(document.getElementById("closureModal")),
            schedule: new bootstrap.Modal(document.getElementById("scheduleModal")),
            image: new bootstrap.Modal(document.getElementById("imageModal")),
            bulkUpload: new bootstrap.Modal(document.getElementById("bulkUploadModal")),
            history: new bootstrap.Modal(document.getElementById("historyModal")),
            nonCompliance: new bootstrap.Modal(document.getElementById("nonComplianceModal")),
            na: new bootstrap.Modal(document.getElementById("naModal")),
            na1: new bootstrap.Modal(document.getElementById("naModal1")),
            breakdown: new bootstrap.Modal(document.getElementById("breakdownModal")),
            breakdownUpdate: new bootstrap.Modal(document.getElementById("breakdownUpdateModal")),
            breakdownVerification: new bootstrap.Modal(document.getElementById("breakdownVerificationModal")),
            filter: new bootstrap.Modal(document.getElementById("filterModal"))
        };
        window.ActionModals = ActionModals;

        // Utility to compress images before processing.
        function compressImage(file, options = { maxWidth: 1024, quality: 0.8 }) {
            return new Promise((resolve, reject) => {
                if (!file.type.startsWith('image/')) { return resolve(file); }
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        let { width, height } = img;
                        if (width > options.maxWidth) { height *= options.maxWidth / width; width = options.maxWidth; }
                        canvas.width = width; canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        canvas.toBlob((blob) => {
                            if (!blob) { return reject(new Error('Canvas to Blob conversion failed.')); }
                            resolve(new File([blob], file.name, { type: 'image/jpeg', lastModified: Date.now() }));
                        }, 'image/jpeg', options.quality);
                    };
                    img.onerror = (error) => reject(error);
                    img.src = event.target.result;
                };
                reader.onerror = (error) => reject(error);
                reader.readAsDataURL(file);
            });
        }
    
        // Manages offline status and syncs drafts using IndexedDB.
        const OfflineManager = {
            db: null, isSyncing: false,
            init() {
                const request = indexedDB.open('EFSMS_DB', 1);
                request.onupgradeneeded = e => { 
                    if (!e.target.result.objectStoreNames.contains('offlineDrafts')) {
                        e.target.result.createObjectStore('offlineDrafts', { keyPath: 'id' }); 
                    }
                };
                request.onsuccess = e => {
                    this.db = e.target.result;
                    window.addEventListener('online', this.updateOnlineStatus.bind(this));
                    window.addEventListener('offline', this.updateOnlineStatus.bind(this));
                    this.updateOnlineStatus();
                };
                request.onerror = e => console.error('DB Error:', e.target.error);
            },
            updateOnlineStatus() {
                const online = navigator.onLine;
                const indicator = document.getElementById('connection-status-indicator');
                const text = document.getElementById('connection-status-text');
                indicator.className = `badge rounded-pill ${online ? 'status-online' : 'status-offline'}`;
                text.textContent = online ? 'Online' : 'Offline';
                if(online) {
                    text.classList.remove('text-danger');
                    text.classList.add('text-success');
                } else {
                    text.classList.add('text-danger');
                    text.classList.remove('text-success');
                }

                if (online) { 
                    UploadManager.retryAllFailed(); 
                    this.syncDrafts();
                } else { 
                    this.loadAndDisplayDrafts(); 
                }
            },
            saveDraft(data) {
                return new Promise((resolve, reject) => {
                    const tx = this.db.transaction('offlineDrafts', 'readwrite');
                    tx.oncomplete = () => { resolve(data); };
                    tx.onerror = e => reject(e.target.error);
                    tx.objectStore('offlineDrafts').put(data);
                });
            },
            getDrafts: () => new Promise(resolve => OfflineManager.db.transaction('offlineDrafts').objectStore('offlineDrafts').getAll().onsuccess = e => resolve(e.target.result)),
            deleteDraft: id => new Promise(resolve => OfflineManager.db.transaction('offlineDrafts', 'readwrite').objectStore('offlineDrafts').delete(id).onsuccess = () => resolve()),
            async loadAndDisplayDrafts() {
                const drafts = await this.getDrafts();
                drafts.forEach(draft => {
                    if (!document.querySelector(`tr[data-draft-id="${draft.id}"]`)) {
                        ReportProcessor.createAndDisplayDraftRow(draft);
                    }
                });
            },
            async syncDrafts() {
                if (this.isSyncing) return;
                const drafts = await this.getDrafts();
                if (drafts.length === 0) return;

                this.isSyncing = true;
                
                for (let i = 0; i < drafts.length; i++) {
                    const draft = drafts[i];
                    document.querySelector(`tr[data-draft-id="${draft.id}"]`)?.remove();
                    await this.deleteDraft(draft.id);
                    await new Promise(r => setTimeout(r, 300));
                }

                this.isSyncing = false;
            }
        };
    
        // Simulates media uploads.
        const UploadManager = {
            retryAllFailed() {},
            _performUpload(file, mediaId) {
                const mediaContainer = document.getElementById(mediaId);
                if (!mediaContainer) return;
                const progressText = mediaContainer.querySelector('.upload-progress-text');
                let percent = 0;
                const interval = setInterval(() => {
                    percent += 10;
                    if(progressText) progressText.textContent = `${percent}%`;
                    if (percent >= 100) {
                        clearInterval(interval);
                        if(progressText) progressText.textContent = 'тЬУ';
                        setTimeout(() => {
                            mediaContainer.querySelector('.media-upload-overlay')?.classList.add('hidden');
                            mediaContainer.dataset.mediaStatus = 'complete';
                        }, 500);
                    }
                }, 150);
            }
        };
    
        // Handles creating and populating report rows in the table.
        const ReportProcessor = {
            processSingleBulkUpload(file, locationString) {
                const [department, location] = locationString.split(' / ').map(s => s.trim());
                const data = {
                    title: "Bulk Upload: General Observation",
                    sop: "SOP: General Observation",
                    risk: "Minor",
                    region: region || 'N/A',
                    unit: unit || 'N/A',
                    department: department || 'N/A',
                    location: location || 'N/A',
                    status: 'Open',
                    registeredBy: 'Bulk Upload',
                    responsibility: 'Unassigned',
                    images: { before: URL.createObjectURL(file) },
                    progress: [ { stage: 'Registered', user: 'Bulk Upload', time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) } ]
                };
                this.createAndDisplayRow(data);
            },
            createAndDisplayRow(data, isFromSync = false) {
                
                console.log(data);
                const template = document.getElementById('report-row-template');
                const newRow = template.content.cloneNode(true).querySelector('tr');
                
                const now = new Date();
                const incidentId = data.incidentId || `INC${now.getTime()}`;
                const complaintId = data.complaintId || IdGenerator.generate();
                
Object.assign(newRow.dataset, {
    incidentId: incidentId,
    complaintId: complaintId,
    reportedTime: data.reportedTime || now.toISOString(),
    completedTime: data.completedTime || '',
    sop: data.sop,
    risk: data.risk,
    region: data.region,
    unit: data.unit,
    department: data.department,
    reopencomment: data.reopencomment,
    location: data.location,
    status: data.status,
    status1: data.status1,
    isBreakdown: data.isBreakdown, // тЬЕ use camelCase instead of hyphen
    breakdownStatus: data.breakdownStatus, // тЬЕ use camelCase instead of hyphen
    starred: data.starred == 1 ? "true" : "false",
    registeredBy: data.registeredBy,
    assignedTo: data.assignedTo || ''
});

// тЬЕ Add breakdown class if value > 0
if (data.isBreakdown && Number(data.isBreakdown) > 0) {
    newRow.classList.add('is-breakdown');
}
                newRow.querySelector('.concern-id').textContent = complaintId;
                newRow.querySelector('.concern-title').innerHTML = data.title;
                
                let metaHTML = `
                    <span data-type="sop"><i class="fas fa-book me-1"></i> ${data.sop}</span>
                    <span data-type="dev"><i class="fas fa-exclamation-triangle me-1"></i> Dev: ${data.risk}</span>
                    <span class="risk-score-badge" data-type="risk-score"></span>`;

                if (data.originalIncidentId) {
                    metaHTML += `<span class="badge bg-secondary">Re-opened from 
                        <a href="#" class="text-white fw-bold" data-original-id="${data.originalIncidentId}">#${data.originalIncidentId}</a>
                    </span>`;
                }
                newRow.querySelector('.concern-meta').innerHTML = metaHTML;

                newRow.querySelector('.concern-responsibility').innerHTML = `<strong>Responsibility:</strong>&nbsp;<span>${data.responsibility || 'Unassigned'}</span>`;
                //newRow.querySelector('.closure-comments-cell').textContent = data.closureComments || '---';
        let html = "";

// If reopencomment exists → add div at top
if (data.reopencomment) {
    html += `<div class="text-danger fw-bold border-bottom pb-1 mb-1">
                Re-opened: ${data.reopencomment}
            </div>`;
}

// Then show closure comments + department under the div
html += `${data.closureComments || '---'}`;

newRow.querySelector('.closure-comments-cell').innerHTML = html;
                const areaText = `${data.department} / ${data.location}`;
                newRow.querySelector('td[data-label="Area"] span').textContent = areaText;
                
                const desktopImageCell = newRow.querySelector('.desktop-view .image-cell');
                desktopImageCell.innerHTML = '';
                if (data.images?.before) desktopImageCell.innerHTML += `<div class="position-relative" data-media-status="complete"><img src="${data.images.before}" class="report-image-thumb" crossorigin="anonymous"><span class="image-label">Before</span></div>`;
                if (data.images?.after) desktopImageCell.innerHTML += `<div class="position-relative" data-media-status="complete"><img src="${data.images.after}" class="report-image-thumb" crossorigin="anonymous"><span class="image-label">After</span></div>`;
                if (data.videos?.before) desktopImageCell.innerHTML += `<div class="position-relative" data-media-status="complete"><div class="video-thumbnail-overlay"><i class="fas fa-play-circle"></i></div><video class="report-image-thumb" src="${data.videos.before}" muted loop></video><span class="image-label">Before</span></div>`;
                
                
                const progressTracker = newRow.querySelector('.desktop-view .progress-tracker');
                const stages = ['Registered', 'Owner Ack.', 'Assigned', 'Staff Ack.', 'Completed'];
                const icons = ['fa-flag', 'fa-user-check', 'fa-user-plus', 'fa-clipboard-check', 'fa-check'];
                const progressHTML = stages.map((stage, index) => {
                    const stepData = (data.progress || []).find(p => p.stage === stage);
                    const isCompleted = !!stepData;
                    return `
                        <div class="step ${isCompleted ? 'is-completed' : ''}">
                            <div class="step-icon"><i class="fas ${icons[index]}"></i></div>
                            <div class="step-label">
                                <strong>${stage}</strong>
                                <span>${stepData ? `by ${stepData.user}` : 'Pending'}</span>
                                ${stepData?.time ? `<span class="step-time">${stepData.time}</span>` : ''}
                            </div>
                        </div>`;
                }).join('');
                progressTracker.innerHTML = progressHTML;


                // --- MOBILE VIEW POPULATION ---
                const mobileCard = newRow.querySelector('.complaint-card-mobile');
                const mobileImageCell = mobileCard.querySelector('.image-cell');
                mobileImageCell.innerHTML = desktopImageCell.innerHTML;

                mobileCardStyleCounter++;
                mobileCard.classList.add('card-border-' + ((mobileCardStyleCounter % 4) + 1));


                const mobileEscalationMatrix = mobileCard.querySelector('.escalation-matrix');
                mobileEscalationMatrix.innerHTML = progressHTML;
                
                mobileCard.querySelector('[data-mobile="complain-number"]').textContent = complaintId;
                mobileCard.querySelector('[data-mobile="created-by"]').textContent = data.registeredBy || 'N/A';
                mobileCard.querySelector('[data-mobile="area"]').textContent = areaText;
                mobileCard.querySelector('[data-mobile="created-date"]').textContent = new Date(data.reportedTime).toLocaleString();
                mobileCard.querySelector('[data-mobile="closer-date"]').textContent = data.completedTime ? new Date(data.completedTime).toLocaleString() : '';
                mobileCard.querySelector('[data-mobile="responsibility"]').textContent = data.responsibility || 'Unassigned';
                mobileCard.querySelector('[data-mobile="risk"]').textContent = data.risk || 'N/A';
                mobileCard.querySelector('[data-mobile="status"]').textContent = data.status;
                mobileCard.querySelector('[data-mobile="status"]').style.color = data.status === 'Open' ? 'var(--danger-color)' : 'var(--green)';
                mobileCard.querySelector('[data-mobile="closed-by"]').textContent = data.status === 'Resolved' ? (data.assignedTo || 'N/A') : '';
                mobileCard.querySelector('[data-mobile="concern-comments"]').textContent = data.title;
                const closureText = data.closureComments && data.closureComments !== '---' ? data.closureComments : '';
                mobileCard.querySelector('[data-mobile="closure-comments"]').textContent = closureText;
               // document.querySelector("#incidentReportTable tbody").prepend(newRow);
               document.querySelector("#incidentReportTable tbody").append(newRow);
                IncidentTableManager.allTableRows.unshift(newRow);
                IncidentTableManager.calculateAndSetRiskScore(newRow);
                ReportHistoryManager.initializeReportData(newRow);
                IncidentTableManager.updateRowUI(newRow); 
                
                if (!data.incidentId) {
                     AlertManager.showObservation(`New Observation Reported: "${data.title}" at ${data.location}`);
                }

                return newRow;
            },
            createAndDisplayDraftRow(draft) {
                 const newRow = document.createElement('tr');
                 newRow.classList.add('is-draft');
                 newRow.dataset.draftId = draft.id;
                 newRow.innerHTML = `
                    <td data-label="Select"></td>
                    <td data-label="Evidence">
                        <div class="mobile-evidence-header"><span class="status-badge status-draft"><i class="fas fa-save me-1"></i> Draft</span></div>
                        <div class="image-cell">${(draft.files || []).map(f => `<div class="position-relative"><img src="${URL.createObjectURL(f)}" class="report-image-thumb"></div>`).join('')}</div>
                        <div class="action-btn-group-mobile"><button class="action-btn btn btn-sm btn-outline-danger btn-delete-draft" title="Delete Draft"><i class="fas fa-trash-alt"></i></button></div>
                    </td>
                    <td data-label="Report Details"><div class="concern-title">${draft.concern}</div></td>
                    <td data-label="Closure Comments">---</td><td data-label="Area">${draft.location}</td>
                    <td data-label="Status"><div><span class="status-badge status-draft"><i class="fas fa-save me-1"></i> Draft</span></div></td>
                    <td data-label="Tracking Status"><span>Pending upload</span></td>
                    <td data-label="Actions"><div class="action-btn-group"><button class="action-btn btn btn-sm btn-outline-danger btn-delete-draft" title="Delete Draft"><i class="fas fa-trash-alt"></i></button></div></td>
                 `;
                 document.querySelector("#incidentReportTable tbody").prepend(newRow);
                 IncidentTableManager.allTableRows.unshift(newRow);
                 IncidentTableManager.displayPage(IncidentTableManager.currentPage);

                 newRow.querySelector('.btn-delete-draft').addEventListener('click', async () => {
                    if (confirm('Delete this draft?')) { 
                        await OfflineManager.deleteDraft(draft.id); 
                        newRow.remove(); 
                        IncidentTableManager.allTableRows = IncidentTableManager.allTableRows.filter(r => r !== newRow);
                        IncidentTableManager.applyAllFilters();
                    }
                 });
            }
        };

        const GlobalFilterManager = {
            showFollowUpsOnly: false,
            showBreakdownsOnly: false,

            init() {
                document.getElementById('followUpFilterBtn').addEventListener('click', () => {
                    this.showFollowUpsOnly = !this.showFollowUpsOnly;
                    document.getElementById('followUpFilterBtn').classList.toggle('active', this.showFollowUpsOnly);
                    IncidentTableManager.displayPage(1);
                });
                document.getElementById('breakdownFilterBtn').addEventListener('click', () => {
                    this.showBreakdownsOnly = !this.showBreakdownsOnly;
                    document.getElementById('breakdownFilterBtn').classList.toggle('active', this.showBreakdownsOnly);
                    IncidentTableManager.displayPage(1);
                });
            },

            clear() {
                this.showFollowUpsOnly = false;
                this.showBreakdownsOnly = false;
                document.getElementById('followUpFilterBtn').classList.remove('active');
                document.getElementById('breakdownFilterBtn').classList.remove('active');
            }
        };

        const FilterManager = {
            activeFilters: { sop: [], risk: [], responsibility: [] },

            init() {
                this.populateFilters();
                this.addEventListeners();
            },

            populateFilters() {
                const uniqueSOPs = new Set();
                const uniqueRisks = new Set();
                const uniqueResponsibilities = new Set();

                IncidentTableManager.allTableRows.forEach(row => {
                    if (row.dataset.sop) uniqueSOPs.add(row.dataset.sop);
                    if (row.dataset.risk) uniqueRisks.add(row.dataset.risk);
                    const resp = row.querySelector('.concern-responsibility span');
                    if (resp && resp.textContent) uniqueResponsibilities.add(resp.textContent);
                });

                this.renderFilterOptions('sop', Array.from(uniqueSOPs).sort());
                this.renderFilterOptions('risk', Array.from(uniqueRisks).sort());
                this.renderFilterOptions('responsibility', Array.from(uniqueResponsibilities).sort());
            },

            // renderFilterOptions(type, options) {
                
            //     console.log(type);
            //     const container = document.getElementById(`${type}FilterList`);
            //     const mobileContainer = document.getElementById(`${type}FilterList_mobile`);
            //     const html = options.map((option, index) => `
            //         <div class="form-check">
            //             <input class="form-check-input" type="checkbox" value="${option}" id="${type}Filter-${index}">
            //             <label class="form-check-label" for="${type}Filter-${index}" title="${option}">${option}</label>
            //         </div>
            //     `).join('');
            //     container.innerHTML = html;
            //     if(mobileContainer) mobileContainer.innerHTML = html.replaceAll(`id="${type}Filter-`, `id="${type}Filter_mobile-`);
            // },
            
            renderFilterOptions(type, options) {
    
  console.log(type);

    // 🔥 Backend full list override for department & location
    if (type === "responsibility" && window.allresponsibility) {
        options = window.allresponsibility;
    }
    
        if (type === "sop" && window.allsops) {
        options = window.allsops;
    }
     
    

    

    const container = document.getElementById(`${type}FilterList`);
    const mobileContainer = document.getElementById(`${type}FilterList_mobile`);

    if (!container || !options) return;

    const html = options.map((option, index) => `
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="${option}" id="${type}Filter-${index}">
            <label class="form-check-label" for="${type}Filter-${index}" title="${option}">${option}</label>
        </div>
    `).join('');

    container.innerHTML = html;

    if (mobileContainer) {
        mobileContainer.innerHTML = html.replaceAll(
            `id="${type}Filter-`,
            `id="${type}Filter_mobile-`
        );
    }
},


            addEventListeners() {
                ['sop', 'risk', 'responsibility'].forEach(type => {
                    const setupListeners = (suffix = '') => {
                        const listContainer = document.getElementById(`${type}FilterList${suffix}`);
                        const searchInput = document.getElementById(`${type}SearchInput${suffix}`);

                        listContainer.addEventListener('change', e => {
                            if (e.target.type === 'checkbox') {
                                this.updateActiveFilters(type, e.target.value, e.target.checked);
                                this.updateMainFilterIcon();
                                this.syncCheckboxes(type, e.target.value, e.target.checked);
                                IncidentTableManager.displayPage(1);
                            }
                        });

                        searchInput.addEventListener('keyup', () => {
                            const searchTerm = searchInput.value.toLowerCase();
                            const items = listContainer.querySelectorAll('.form-check');
                            items.forEach(item => {
                                const label = item.querySelector('label');
                                item.style.display = label.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
                            });
                        });
                    };
                    setupListeners('');
                    setupListeners('_mobile');
                });
            },
            
            syncCheckboxes(type, value, isChecked) {
                document.querySelectorAll(`#${type}FilterList input[value="${value}"], #${type}FilterList_mobile input[value="${value}"]`).forEach(cb => {
                    cb.checked = isChecked;
                });
            },

            updateActiveFilters(type, value, isChecked) {
                const filterSet = new Set(this.activeFilters[type]);
                if (isChecked) {
                    filterSet.add(value);
                } else {
                    filterSet.delete(value);
                }
                this.activeFilters[type] = Array.from(filterSet);
            },
            
            updateMainFilterIcon() {
                const filterBtn = document.getElementById('detailsFilterBtn');
                if (!filterBtn) return;
                const hasActiveFilters = Object.values(this.activeFilters).some(arr => arr.length > 0);
                if (hasActiveFilters) {
                    filterBtn.classList.add('text-primary');
                } else {
                    filterBtn.classList.remove('text-primary');
                }
            },
            
            clear() {
                Object.keys(this.activeFilters).forEach(type => this.activeFilters[type] = []);
                document.querySelectorAll('#detailsFilterBtn + .dropdown-menu .form-check-input, #filterModal .form-check-input').forEach(chk => chk.checked = false);
                this.updateMainFilterIcon();
            }
        };

        const AreaFilterManager = {
            activeFilters: { region: [], unit: [], department: [], location: [] },

            init() {
                this.populateFilters();
                this.addEventListeners();
            },

            populateFilters() {
                const unique = {
                    region: new Set(),
                    unit: new Set(),
                    department: new Set(),
                    location: new Set()
                };

                IncidentTableManager.allTableRows.forEach(row => {
                    if (row.dataset.region) unique.region.add(row.dataset.region);
                    if (row.dataset.unit) unique.unit.add(row.dataset.unit);
                    if (row.dataset.department) unique.department.add(row.dataset.department);
                    if (row.dataset.location) unique.location.add(row.dataset.location);
                });

                Object.keys(unique).forEach(type => {
                    this.renderFilterOptions(type, Array.from(unique[type]).sort());
                });
            },
            
  
renderFilterOptions(type, options) {
    
  

    // 🔥 Backend full list override for department & location
    if (type === "department" && window.allDepartments) {
        options = window.allDepartments;
    }
    if (type === "location" && window.allLocations) {
        options = window.allLocations;
    }
    

    const container = document.getElementById(`${type}FilterList`);
    const mobileContainer = document.getElementById(`${type}FilterList_mobile`);

    if (!container || !options) return;

    const html = options.map((option, index) => `
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="${option}" id="${type}Filter-${index}">
            <label class="form-check-label" for="${type}Filter-${index}" title="${option}">${option}</label>
        </div>
    `).join('');

    container.innerHTML = html;

    if (mobileContainer) {
        mobileContainer.innerHTML = html.replaceAll(
            `id="${type}Filter-`,
            `id="${type}Filter_mobile-`
        );
    }
},

            addEventListeners() {
                Object.keys(this.activeFilters).forEach(type => {
                     const setupListeners = (suffix = '') => {
                        const listContainer = document.getElementById(`${type}FilterList${suffix}`);
                        const searchInput = document.getElementById(`${type}SearchInput${suffix}`);

                        listContainer.addEventListener('change', e => {
                            if (e.target.type === 'checkbox') {
                                this.updateActiveFilters(type, e.target.value, e.target.checked);
                                this.updateMainFilterIcon();
                                this.syncCheckboxes(type, e.target.value, e.target.checked);
                                IncidentTableManager.displayPage(1);
                            }
                        });

                        searchInput.addEventListener('keyup', () => {
                            const searchTerm = searchInput.value.toLowerCase();
                            const items = listContainer.querySelectorAll('.form-check');
                            items.forEach(item => {
                                const label = item.querySelector('label');
                                item.style.display = label.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
                            });
                        });
                    };
                    setupListeners('');
                    setupListeners('_mobile');
                });
            },
            
            syncCheckboxes(type, value, isChecked) {
                document.querySelectorAll(`#${type}FilterList input[value="${value}"], #${type}FilterList_mobile input[value="${value}"]`).forEach(cb => {
                    cb.checked = isChecked;
                });
            },

            updateActiveFilters(type, value, isChecked) {
                const filterSet = new Set(this.activeFilters[type]);
                if (isChecked) {
                    filterSet.add(value);
                } else {
                    filterSet.delete(value);
                }
                this.activeFilters[type] = Array.from(filterSet);
            },

            updateMainFilterIcon() {
                const filterBtn = document.getElementById('areaFilterBtn');
                if (!filterBtn) return;
                const hasActiveFilters = Object.values(this.activeFilters).some(arr => arr.length > 0);
                if (hasActiveFilters) {
                    filterBtn.classList.add('text-primary');
                } else {
                    filterBtn.classList.remove('text-primary');
                }
            },

            clear() {
                Object.keys(this.activeFilters).forEach(type => this.activeFilters[type] = []);
                document.querySelectorAll('#areaFilterBtn + .dropdown-menu .form-check-input, #filterModal .form-check-input').forEach(chk => chk.checked = false);
                this.updateMainFilterIcon();
            }
        };

        const StatusFilterManager = {
            activeFilters: { status: [] },

            init() {
                this.populateFilters();
                this.addEventListeners();
            },

            populateFilters() {
                const statuses = ['Open', 'Resolved', 'In Progress', 'Verified', 'Not Applicable', 'Follow-up Created'];
                this.renderFilterOptions('status', statuses);
            },

            renderFilterOptions(type, options) {
                
                console.log(type);
                
        
                 const container = document.getElementById(`${type}FilterList`);
                const mobileContainer = document.getElementById(`${type}FilterList_mobile`);
                const html = options.map((option, index) => `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${option}" id="${type}Filter-${index}">
                        <label class="form-check-label" for="${type}Filter-${index}">${option}</label>
                    </div>
                `).join('');
                 container.innerHTML = html;
                if(mobileContainer) mobileContainer.innerHTML = html.replaceAll(`id="${type}Filter-`, `id="${type}Filter_mobile-`);
            },
            
            addEventListeners() {
                 const setupListeners = (suffix = '') => {
                    const listContainer = document.getElementById(`statusFilterList${suffix}`);
                    const searchInput = document.getElementById(`statusSearchInput${suffix}`);

                    listContainer.addEventListener('change', e => {
                        if (e.target.type === 'checkbox') {
                            this.updateActiveFilters('status', e.target.value, e.target.checked);
                            this.updateMainFilterIcon();
                            this.syncCheckboxes('status', e.target.value, e.target.checked);
                            IncidentTableManager.displayPage(1);
                        }
                    });

                    searchInput.addEventListener('keyup', () => {
                        const searchTerm = searchInput.value.toLowerCase();
                        const items = listContainer.querySelectorAll('.form-check');
                        items.forEach(item => {
                            const label = item.querySelector('label');
                            item.style.display = label.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
                        });
                    });
                };
                setupListeners('');
                setupListeners('_mobile');
            },

            syncCheckboxes(type, value, isChecked) {
                document.querySelectorAll(`#${type}FilterList input[value="${value}"], #${type}FilterList_mobile input[value="${value}"]`).forEach(cb => {
                    cb.checked = isChecked;
                });
            },

            updateActiveFilters(type, value, isChecked) {
                const filterSet = new Set(this.activeFilters[type]);
                if (isChecked) filterSet.add(value);
                else filterSet.delete(value);
                this.activeFilters[type] = Array.from(filterSet);
            },

            updateMainFilterIcon() {
                const filterBtn = document.getElementById('statusFilterBtn');
                if (!filterBtn) return;
                const hasActiveFilters = this.activeFilters.status.length > 0;
                if (hasActiveFilters) filterBtn.classList.add('text-primary');
                else filterBtn.classList.remove('text-primary');
            },
            
            clear() {
                this.activeFilters.status = [];
                document.querySelectorAll('#statusFilterList .form-check-input, #statusFilterList_mobile .form-check-input').forEach(chk => chk.checked = false);
                this.updateMainFilterIcon();
            }
        };

        const TrackingStatusFilterManager = {
            activeFilters: {
                reportingFrom: '', reportingTo: '',
                closureFrom: '', closureTo: '',
                timelineStages: []
            },

            init() {
                this.addEventListeners();
            },

            addEventListeners() {
                const setupListeners = (suffix = '') => {
                    const container = suffix 
                        ? document.getElementById('collapseTracking') 
                        : document.getElementById('trackingFilterBtn').nextElementSibling;
                    
                    container.addEventListener('change', e => {
                        this.updateActiveFilters();
                        this.updateMainFilterIcon();
                        this.syncInputs();
                        IncidentTableManager.displayPage(1);
                    });
                };
                setupListeners('');
                setupListeners('_mobile');
            },
            
            updateActiveFilters() {
                this.activeFilters.reportingFrom = document.getElementById('reportingDateFrom').value;
                this.activeFilters.reportingTo = document.getElementById('reportingDateTo').value;
                this.activeFilters.closureFrom = document.getElementById('closureDateFrom').value;
                this.activeFilters.closureTo = document.getElementById('closureDateTo').value;
                this.activeFilters.timelineStages = Array.from(document.querySelectorAll('#timelineStageFilterList input:checked')).map(cb => cb.value);
            },
            
            syncInputs() {
                const desktopIds = ['reportingDateFrom', 'reportingDateTo', 'closureDateFrom', 'closureDateTo'];
                desktopIds.forEach(id => {
                    document.getElementById(id + '_mobile').value = document.getElementById(id).value;
                });
                
                const stageIds = ['pendingOwnerAck', 'pendingAssignment', 'pendingStaffAck', 'pendingCompletion'];
                stageIds.forEach(id => {
                    document.getElementById(id + '_mobile').checked = document.getElementById(id).checked;
                });
            },
            
            updateMainFilterIcon() {
                const filterBtn = document.getElementById('trackingFilterBtn');
                const hasActiveFilters = this.activeFilters.reportingFrom || this.activeFilters.reportingTo ||
                                         this.activeFilters.closureFrom || this.activeFilters.closureTo ||
                                         this.activeFilters.timelineStages.length > 0;
                if (hasActiveFilters) {
                    filterBtn.classList.add('text-primary');
                } else {
                    filterBtn.classList.remove('text-primary');
                }
            },
            
            clear() {
                ['reportingDateFrom', 'reportingDateTo', 'closureDateFrom', 'closureDateTo'].forEach(id => {
                    document.getElementById(id).value = '';
                    document.getElementById(id + '_mobile').value = '';
                });
                ['pendingOwnerAck', 'pendingAssignment', 'pendingStaffAck', 'pendingCompletion'].forEach(id => {
                     document.getElementById(id).checked = false;
                     document.getElementById(id + '_mobile').checked = false;
                });

                this.updateActiveFilters();
                this.updateMainFilterIcon();
            }
        };
    
        // Main object for managing the incidents table.
        const IncidentTableManager = {
            allTableRows: [], activeRows: [], currentPage: 1, itemsPerPage: 10, 
            staffData: [ { id: "E021", name: "Ajay S." }, { id: "E045", name: "Mohan K." }, { id: "T001", name: "Engineering Team" } ],
            KEYWORD_WEIGHTS: { food: 10, pipe: 8, wiring: 12, alarm: 15, leak: 8 },
            SEVERITY_MARKINGS: { Critical: 10, Major: 5, Minor: 2 },
            
            init() {
                initialReportData.forEach(data => ReportProcessor.createAndDisplayRow(data));
                
                
                this.activeRows = [...this.allTableRows];

                this.setupPagination();
                this.attachEventListeners();
                this.initBulkActions();
                this.startReminderNotifications();
                this.initAssignModal();
                this.initBreakdownModals();
                this.setupBulkUpload(); 
                this.updateTimers();
                setInterval(this.updateTimers.bind(this), 60000);

                document.getElementById('confirmNaBtn').addEventListener('click', () => this.handleNaConfirmation());
                document.getElementById('confirmNonComplianceBtn').addEventListener('click', () => this.handleNonComplianceConfirmation());
                document.getElementById('nonCompliancePhoto').addEventListener('change', (e) => {
                    const [file] = e.target.files;
                    if (file) {
                        const preview = document.getElementById('nonCompliancePhotoPreview');
                        const container = document.getElementById('nonCompliancePhotoPreviewContainer');
                        preview.src = URL.createObjectURL(file);
                        container.classList.remove('d-none');
                    }
                });
                
                GlobalFilterManager.init();
                FilterManager.init();
                AreaFilterManager.init();
                StatusFilterManager.init();
                TrackingStatusFilterManager.init();

                this.displayPage(1);
            },

            clearAllFilters() {
                GlobalFilterManager.clear();
                FilterManager.clear();
                AreaFilterManager.clear();
                StatusFilterManager.clear();
                TrackingStatusFilterManager.clear();
                this.displayPage(1);
            },

            setupBulkUpload() {
                const modalEl = document.getElementById('bulkUploadModal');
                const dropzone = document.getElementById('bulkUploadDropzone');
                const fileInput = document.getElementById('bulkImageInput');
                const previewArea = document.getElementById('bulkUploadPreviewArea');
                const locationSearch = document.getElementById('bulkLocationSearch');
                const locationValue = document.getElementById('bulkLocationSelectValue');
                const locationList = document.getElementById('bulkLocationList');
                const processBtn = document.getElementById('processBulkUploadBtn');
                const processBtnSpinner = processBtn.querySelector('.spinner-border');
                const imageCountSpan = document.getElementById('bulkImageCount');
                
                const allLocations = [
                    
              @foreach($locations as $location)
    @php 
        $department_name = DB::table('departments')->where('id', $location->department_id)->value('name');
        $unit = DB::table('users')->where('id', $location->created_by)->first();
        
        $regional = DB::table('users')->where('id', $unit->created_by1)->first();
        $corporate = DB::table('users')->where('id', $unit->created_by)->first();
        
    @endphp
    "{{ $corporate->company_name ?? '' }} / {{ $regional->company_name ?? '' }} / {{ $unit->company_name ?? '' }} / {{ $department_name }} / {{ $location->name ?? '' }}",
@endforeach
                ];

                const checkProcessButtonState = () => {
                    const hasLocation = locationValue.value.trim() !== '';
                    const hasFiles = bulkUploadFiles.length > 0;
                    processBtn.disabled = !(hasLocation && hasFiles);
                };

                const updateBulkUploadUI = () => {
                    previewArea.innerHTML = '';
                    bulkUploadFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const card = document.createElement('div');
                            card.className = 'bulk-preview-card';
                            card.innerHTML = `
                                <img src="${e.target.result}" alt="${file.name}">
                                <div class="remove-bulk-image-btn" data-index="${index}" title="Remove image">&times;</div>
                            `;
                            previewArea.appendChild(card);
                        }
                        reader.readAsDataURL(file);
                    });
                    imageCountSpan.textContent = bulkUploadFiles.length;
                    checkProcessButtonState();
                };

                const renderLocationList = (filter = '') => {
                    locationList.innerHTML = '';
                    const filtered = allLocations.filter(loc => loc.toLowerCase().includes(filter.toLowerCase()));
                    if (filtered.length === 0) {
                        locationList.innerHTML = `<li><span class="dropdown-item-text text-muted">No locations found</span></li>`;
                    } else {
                        filtered.forEach(loc => {
                            const li = document.createElement('li');
                            const a = document.createElement('a');
                            a.className = 'dropdown-item';
                            a.href = '#';
                            a.textContent = loc;
                            a.addEventListener('click', (e) => {
                                e.preventDefault();
                                locationSearch.value = loc;
                                locationValue.value = loc;
                                checkProcessButtonState();
                                const dropdown = bootstrap.Dropdown.getInstance(locationSearch) || new bootstrap.Dropdown(locationSearch);
                                dropdown.hide();
                            });
                            li.appendChild(a);
                            locationList.appendChild(li);
                        });
                    }
                };

                locationSearch.addEventListener('keyup', () => renderLocationList(locationSearch.value));
                locationSearch.addEventListener('focus', () => renderLocationList(locationSearch.value));
                
                const handleFiles = (files) => {
                    const newFiles = Array.from(files).filter(file => file.type.startsWith('image/'));
                    bulkUploadFiles.push(...newFiles);
                    updateBulkUploadUI();
                };

                fileInput.addEventListener('change', () => handleFiles(fileInput.files));
                
                dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('is-dragover'); });
                dropzone.addEventListener('dragleave', () => dropzone.classList.remove('is-dragover'));
                dropzone.addEventListener('drop', (e) => { e.preventDefault(); dropzone.classList.remove('is-dragover'); handleFiles(e.dataTransfer.files); });
                
                previewArea.addEventListener('click', (e) => {
                    if (e.target.classList.contains('remove-bulk-image-btn')) {
                        const index = parseInt(e.target.dataset.index, 10);
                        bulkUploadFiles.splice(index, 1);
                        updateBulkUploadUI();
                    }
                });


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});



        
processBtn.addEventListener('click', async () => {

    processBtn.disabled = true;
    processBtnSpinner.classList.remove('d-none');

    const selectedLocation = locationValue.value;

    // Compress files
    const compressedFiles = await Promise.all(
        bulkUploadFiles.map(f => compressImage(f))
    );

    const chunkSize = 20;

    for (let i = 0; i < compressedFiles.length; i += chunkSize) {

        const chunk = compressedFiles.slice(i, i + chunkSize);
        const formData = new FormData();

        formData.append("location", selectedLocation);

        chunk.forEach(file => {
            formData.append("files[]", file);
        });

        await $.ajax({
            url: '{{ route("bulkuploaddata") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false
        });

        console.log(`Uploaded chunk ${i/chunkSize + 1}`);
    }

    alert("All files uploaded successfully!");

    // FIXED reload
    window.location.reload();

    processBtn.disabled = false;
    processBtnSpinner.classList.add('d-none');
});
                modalEl.addEventListener('hidden.bs.modal', () => {
                    bulkUploadFiles = [];
                    locationSearch.value = '';
                    locationValue.value = '';
                    fileInput.value = '';
                    updateBulkUploadUI();
                });
            },

            getFormattedTime: () => new Date().toLocaleTimeString('en-US', { hour: "2-digit", minute: "2-digit", hour12: false }),
            calculateAndSetRiskScore(row) {
                const title = (row.querySelector(".concern-title")?.textContent || "").toLowerCase();
                const risk = row.dataset.risk;
                const keywordScore = Object.keys(this.KEYWORD_WEIGHTS).reduce((score, key) => title.includes(key) ? score + this.KEYWORD_WEIGHTS[key] : score, 0);
                const totalScore = keywordScore + (this.SEVERITY_MARKINGS[risk] || 0);
                const level = totalScore > 15 ? "High" : totalScore > 8 ? "Medium" : "Low";
                const badge = row.querySelector(".risk-score-badge");
                if (badge) badge.innerHTML = `<i class="fas fa-calculator me-1"></i>Risk: ${totalScore} (${level})`;
            },
            formatDuration(ms) {
                if (ms < 0) return "0m"; let t = Math.floor(ms / 60000); const d = Math.floor(t / 1440); t %= 1440; const h = Math.floor(t / 60); t %= 60; return [d && `${d}d`, h && `${h}h`, t >= 0 && `${t}m`].filter(Boolean).join(' ') || "0m";
            },
            updateTimers() {
                document.querySelectorAll("tr[data-reported-time]").forEach(row => {
                    row.querySelectorAll(".time-since-reported").forEach(timerEl => {
                        const start = new Date(row.dataset.reportedTime);
                        const end = row.dataset.completedTime ? new Date(row.dataset.completedTime) : new Date();
                        timerEl.textContent = `${this.formatDuration(end - start)} ${row.dataset.completedTime ? 'total' : 'ago'}`;
                    });
                });
            },
            setupPagination() {
                document.getElementById("itemsPerPageSelect").addEventListener("change", e => { this.itemsPerPage = parseInt(e.target.value, 10); this.displayPage(1); });
                document.getElementById("paginationControls").addEventListener("click", e => {
                    e.preventDefault(); const link = e.target.closest("a");
                    if (!link || link.parentElement.classList.contains("disabled") || link.parentElement.classList.contains("active")) return;
                    const page = link.dataset.page, totalPages = Math.ceil(this.activeRows.length / this.itemsPerPage);
                    if (page === "prev") { if (this.currentPage > 1) this.displayPage(this.currentPage - 1); }
                    else if (page === "next") { if (this.currentPage < totalPages) this.displayPage(this.currentPage + 1); }
                    else this.displayPage(parseInt(page, 10));
                });
            },
            displayPage(page) {
                this.currentPage = page || 1;
                this.applyAllFilters();
                
                this.allTableRows.forEach(row => row.style.display = 'table-row');
                
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;

                this.activeRows.slice(start, end).forEach(row => {
                    row.style.display = 'table-row';
                });

                this.renderPaginationControls(); this.updatePaginationInfo();
            },

            // renderPaginationControls() {
            //     const controls = document.getElementById("paginationControls"), totalPages = Math.ceil(this.activeRows.length / this.itemsPerPage);
            //     controls.innerHTML = ""; if (totalPages <= 1) return;
            //     const createItem = (p, t, d = false, a = false) => `<li class="page-item ${d ? 'disabled' : ''} ${a ? 'active' : ''}"><a class="page-link" href="#" data-page="${p}">${t}</a></li>`;
            //     controls.innerHTML += createItem("prev", "┬л", this.currentPage === 1);
            //     for (let i = 1; i <= totalPages; i++) controls.innerHTML += createItem(i, i, false, i === this.currentPage);
            //     controls.innerHTML += createItem("next", "┬╗", this.currentPage === totalPages);
            // },
            renderPaginationControls() {
    const controls = document.getElementById("paginationControls"),
        totalPages = Math.ceil(this.activeRows.length / this.itemsPerPage),
        current = this.currentPage;

    controls.innerHTML = "";
    if (totalPages <= 1) return;

    const createItem = (p, t, disabled = false, active = false) => `
        <li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${p}">${t}</a>
        </li>`;

    const addEllipsis = () =>
        controls.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;

    // Prev
    controls.innerHTML += createItem(current - 1, "&laquo;", current === 1);

    const pageLinks = [];
    const maxPagesToShow = 5; // current page ke 5 pages view

    let start = Math.max(1, current - 2);
    let end = Math.min(totalPages, current + 2);

    if (start > 2) {
        pageLinks.push(1);
        pageLinks.push("...");
    }

    for (let i = start; i <= end; i++) {
        pageLinks.push(i);
    }

    if (end < totalPages - 1) {
        pageLinks.push("...");
        pageLinks.push(totalPages);
    }

    pageLinks.forEach(p => {
        if (p === "...") {
            controls.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        } else {
            controls.innerHTML += createItem(p, p, false, p === current);
        }
    });

    // Next
    controls.innerHTML += createItem(current + 1, "&raquo;", current === totalPages);
},
            updatePaginationInfo() {
                const info = document.getElementById("paginationInfo"), total = this.activeRows.length, start = total > 0 ? (this.currentPage - 1) * this.itemsPerPage + 1 : 0, end = Math.min(start + this.itemsPerPage - 1, total);
                info.textContent = `Showing ${start} to ${end} of ${total} entries`;
            },

applyAllFilters() {
    this.activeRows = this.allTableRows.filter(row => {
        if (row.classList.contains('is-draft')) return false;

        const sopMatch = FilterManager.activeFilters.sop.length === 0 ||
                         FilterManager.activeFilters.sop.includes(row.dataset.sop);

        const riskMatch = FilterManager.activeFilters.risk.length === 0 ||
                          FilterManager.activeFilters.risk.includes(row.dataset.risk);

        const respEl = row.querySelector('.concern-responsibility span');
        const responsibilityMatch = FilterManager.activeFilters.responsibility.length === 0 ||
                                    (respEl && FilterManager.activeFilters.responsibility.includes(respEl.textContent));

        const regionMatch = AreaFilterManager.activeFilters.region.length === 0 ||
                            AreaFilterManager.activeFilters.region.includes(row.dataset.region);

        const unitMatch = AreaFilterManager.activeFilters.unit.length === 0 ||
                          AreaFilterManager.activeFilters.unit.includes(row.dataset.unit);

        const departmentMatch = AreaFilterManager.activeFilters.department.length === 0 ||
                                AreaFilterManager.activeFilters.department.includes(row.dataset.department);

        const locationMatch = AreaFilterManager.activeFilters.location.length === 0 ||
                              AreaFilterManager.activeFilters.location.includes(row.dataset.location);

        const statusMatch = StatusFilterManager.activeFilters.status.length === 0 ||
                            StatusFilterManager.activeFilters.status.includes(row.dataset.status);

        const { reportingFrom, reportingTo, timelineStages } = TrackingStatusFilterManager.activeFilters;
        let trackingMatch = true;

        if (reportingFrom || reportingTo) {
            const reportedTime = new Date(row.dataset.reportedTime);
            reportedTime.setHours(0,0,0,0);

            const from = reportingFrom ? new Date(reportingFrom).setHours(0,0,0,0) : -Infinity;
            const to = reportingTo ? new Date(reportingTo).setHours(0,0,0,0) : Infinity;

            if (reportedTime < from || reportedTime > to) trackingMatch = false;
        }

        if (trackingMatch && timelineStages.length > 0) {
            const steps = row.querySelectorAll('.progress-tracker .step');
            const stageChecks = {
                owner: steps[1] && !steps[1].classList.contains('is-completed'),
                assignment: steps[2] && !steps[2].classList.contains('is-completed'),
                staff: steps[3] && !steps[3].classList.contains('is-completed'),
                completion: steps[4] && !steps[4].classList.contains('is-completed')
            };
            const matched = timelineStages.some(s => stageChecks[s]);
            if (!matched) trackingMatch = false;
        }

        const followUpMatch = !GlobalFilterManager.showFollowUpsOnly || row.dataset.starred === "true";
        const breakdownMatch = !GlobalFilterManager.showBreakdownsOnly || row.dataset.isBreakdown === "true";

        return sopMatch && riskMatch && responsibilityMatch &&
               regionMatch && unitMatch && departmentMatch &&
               locationMatch && statusMatch && trackingMatch &&
               followUpMatch && breakdownMatch;
    });

    // ==========================
    // BUILD URL (merge filters with current URL)
    // ==========================
    const currentParams = new URLSearchParams(window.location.search); // existing URL params
    const newParams = new URLSearchParams(currentParams.toString()); // copy

    const mergeParam = (key, arr) => {
        if (arr.length) {
            const existing = newParams.get(key) ? newParams.get(key).split(',') : [];
            const merged = Array.from(new Set([...existing, ...arr])); // merge without duplicates
            newParams.set(key, merged.join(','));
        }
    };

    mergeParam('sop', FilterManager.activeFilters.sop);
    mergeParam('risk', FilterManager.activeFilters.risk);
    mergeParam('responsibility', FilterManager.activeFilters.responsibility);
    mergeParam('region', AreaFilterManager.activeFilters.region);
    mergeParam('unit', AreaFilterManager.activeFilters.unit);
    mergeParam('department', AreaFilterManager.activeFilters.department);
    mergeParam('location', AreaFilterManager.activeFilters.location);
    mergeParam('status', StatusFilterManager.activeFilters.status);

    if (TrackingStatusFilterManager.activeFilters.reportingFrom)
        newParams.set('reportingFrom', TrackingStatusFilterManager.activeFilters.reportingFrom);

    if (TrackingStatusFilterManager.activeFilters.reportingTo)
        newParams.set('reportingTo', TrackingStatusFilterManager.activeFilters.reportingTo);

    mergeParam('timelineStages', TrackingStatusFilterManager.activeFilters.timelineStages);

    if (GlobalFilterManager.showFollowUpsOnly) newParams.set('followups', "1");
    if (GlobalFilterManager.showBreakdownsOnly) newParams.set('breakdown', "1");

    // ==========================
    // REDIRECT ONLY IF URL CHANGED
    // ==========================
    if (newParams.toString() !== currentParams.toString()) {
        const baseUrl = "https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list";
        window.location.href = `${baseUrl}?${newParams.toString()}`;
    }
},



            initBulkActions() {}, updateBulkActionUI() {}, initAssignModal() {}, addCheckboxToRowIfNeeded(row) {},
            getSelectedRows: () => Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.closest('tr')),
            startReminderNotifications() {},
            
            updateRowUI(row) {
                const status = row.dataset.status;
                const isStarred = row.dataset.starred === 'true';
                const isBreakdown = row.dataset.isBreakdown === 'true';
                const breakdownStatus = row.dataset.breakdownStatus;
                
                const isFinalState = ['Resolved', 'Verified', 'Not Applicable', 'Follow-up Created'].includes(status);

                const statusMap = {
                    'Open': { class: 'status-open', icon: 'fa-exclamation-circle' },
                    'In Progress': { class: '', icon: 'fa-tasks' },
                    'Resolved': { class: 'status-resolved', icon: 'fa-check-circle' },
                    'Verified': { class: 'status-verified', icon: 'fa-user-check' },
                    'Not Applicable': { class: 'status-not-applicable', icon: 'fa-ban' },
                    'Follow-up Created': { class: 'status-follow-up-created', icon: 'fa-copy' }
                };

const statusInfo = statusMap[status] || { class: 'status-open', icon: 'fa-exclamation-circle' };

row.querySelectorAll('.status-badge').forEach(badge => {
    badge.className = `status-badge ${statusInfo.class}`;
    
    let badgeHtml = '';

    // ✅ If status is "In Progress" → show Breakdown badge also
    if (status === "In Progress") {
        badgeHtml = `
            <span class="status-badge status-in-progress">
                <i class="fas ${statusInfo.icon} me-1"></i> ${status}
            </span>
            <span class="badge badge-breakdown mt-1 Breakdownspan">
                Breakdown
            </span>
        `;
    } else {
        badgeHtml = `<i class="fas ${statusInfo.icon} me-1"></i> ${status}`;
    }

    badge.innerHTML = badgeHtml;
});
                

const isOpenStar =
    (status === 'Open' || status === 'Not Done'); // sirf status check

const visibility = {
    '.btn-compliance': isFinalState ,
    '.btn-not-compliance': true,
    // SIRF OPEN / NOT DONE me show
    '.btn-not-applicable': isOpenStar,
    '.btn-not-applicable1': isOpenStar,
    '.btn-assign': !isFinalState,
    '.btn-complete-task': !isFinalState,
    '.btn-progress': !isFinalState,
    '.btn-edit': !isFinalState,
    '.btn-delete': !isFinalState,
    '.btn-view': isFinalState,
    '.btn-breakdown': !isFinalState && !isBreakdown,
    '.btn-breakdown-update': isBreakdown
};
               
         
                for (const selector in visibility) {
                    row.querySelectorAll(selector).forEach(btn => {
                        btn.style.display = visibility[selector] ? 'inline-flex' : 'none';
                    });
                }
                
                row.querySelectorAll('.btn-not-compliance').forEach(btn => {
                    btn.title = isFinalState ? 'Re-open as new observation' : 'Log Non-Compliance';
                });

                if (isBreakdown) {
                    row.querySelectorAll('.btn-breakdown-update').forEach(btn => {
                        const equipmentName = row.dataset.breakdownEquipment || "Breakdown";
                        if (breakdownStatus === 'pending-verification') {
                            btn.className = 'action-btn btn btn-sm btn-warning btn-breakdown-update';
                            btn.innerHTML = `<i class="fas fa-user-check"></i>`;
                            btn.title = `Verify ${equipmentName} Closure`;
                        } else if (breakdownStatus === 'resolved') {
                            btn.className = 'action-btn btn btn-sm btn-outline-success btn-breakdown-update';
                            btn.innerHTML = `<i class="fas fa-history"></i>`;
                            btn.title = `View ${equipmentName} History Card`;
                        } else { 
                             btn.className = 'action-btn btn-breakdown-update';
                             btn.innerHTML = '<i class="fas fa-tasks text-primary"></i>';
                             btn.title = "Update Breakdown Status";
                        }
                    });
                }else{
                    console.log("no brackdown")
                }
            },

            initBreakdownModals() {
                const breakdownModalEl = document.getElementById('breakdownModal');
                
                let equipmentSearchHandler;

                breakdownModalEl.addEventListener('show.bs.modal', e => {
                    const incidentId = e.relatedTarget.closest('tr').dataset.incidentId;
                    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
                    document.getElementById('breakdownIncidentId').value = incidentId;
                    
                    const equipmentSearchInput = document.getElementById('breakdownEquipmentSearch');
                    const equipmentHiddenInput = document.getElementById('breakdownEquipment');
                    const equipmentListContainer = document.getElementById('breakdownEquipmentList');
                    
                    equipmentSearchInput.value = ''; equipmentHiddenInput.value = ''; equipmentListContainer.innerHTML = '';

                    const department = row.dataset.department;
                    const location = row.dataset.location;
                    const key = `${department}-${location}`;
                    const equipmentOptions = dummyEquipmentData[key] || dummyEquipmentData['Default'];
                    
                    const fuse = new Fuse(equipmentOptions, { threshold: 0.4 });

                    const renderList = (items) => {
                        equipmentListContainer.innerHTML = '';
                        if (items.length === 0) {
                            equipmentListContainer.innerHTML = '<li><span class="dropdown-item-text text-muted">No equipment found</span></li>';
                            return;
                        }
                        items.forEach(item => {
                            const li = document.createElement('li');
                            const a = document.createElement('a');
                            a.className = 'dropdown-item'; a.href = '#'; a.style.cursor = 'pointer'; a.textContent = item;
                            a.addEventListener('click', (evt) => {
                                evt.preventDefault();
                                equipmentSearchInput.value = item; equipmentHiddenInput.value = item;
                                const dropdown = bootstrap.Dropdown.getInstance(equipmentSearchInput);
                                if (dropdown) dropdown.hide();
                            });
                            li.appendChild(a); equipmentListContainer.appendChild(li);
                        });
                    };
                    if (equipmentSearchHandler) { equipmentSearchInput.removeEventListener('keyup', equipmentSearchHandler); }
                    equipmentSearchHandler = () => {
                        const searchTerm = equipmentSearchInput.value;
                        if (!searchTerm) { renderList(equipmentOptions); } 
                        else { renderList(fuse.search(searchTerm).map(result => result.item)); }
                    };
                    equipmentSearchInput.addEventListener('keyup', equipmentSearchHandler);
                    renderList(equipmentOptions);
                    
                    if(row.dataset.isBreakdown === 'true') {
                        equipmentSearchInput.value = row.dataset.breakdownEquipment || '';
                        equipmentHiddenInput.value = row.dataset.breakdownEquipment || '';
                        document.getElementById('breakdownRootCause').value = row.dataset.breakdownRootCause || '';
                        document.getElementById('breakdownClosureDate').value = row.dataset.breakdownClosureDate || '';
                        document.getElementById('breakdownStepTaken').value = row.dataset.breakdownStepTaken || '';
                    } else {
                       document.getElementById('breakdownForm').reset();
                       equipmentSearchInput.value = ''; equipmentHiddenInput.value = '';
                    }
                });


document.getElementById('confirmBreakdownBtn').addEventListener('click', function() {

    
    const incidentId = document.getElementById('breakdownIncidentId').value;
    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
    if (!row) return;

    const breakdownEquipment = document.getElementById('breakdownEquipment').value;
    const breakdownRootCause = document.getElementById('breakdownRootCause').value;
    const breakdownClosureDate = document.getElementById('breakdownClosureDate').value;
    const breakdownStepTaken = document.getElementById('breakdownStepTaken').value;
    const breakdownStartTime = new Date().toISOString();

    // === Update row data ===
    Object.assign(row.dataset, {
        isBreakdown: 'true',
        breakdownStatus: 'active',
        breakdownStartTime: breakdownStartTime,
        breakdownTotalCost: '0',
        breakdownEquipment: breakdownEquipment,
        breakdownRootCause: breakdownRootCause,
        breakdownClosureDate: breakdownClosureDate,
        breakdownStepTaken: breakdownStepTaken
    });

    const firstHistoryEntry = {
        date: breakdownStartTime,
        reportedBy: row.dataset.registeredBy,
        breakdownReason: breakdownRootCause,
        tentativeDate: breakdownClosureDate,
        correctiveAction: breakdownStepTaken,
        incurredExpenses: '0.00'
    };
    ReportHistoryManager.addBreakdownHistoryEntry(incidentId, firstHistoryEntry);

    // === Update UI ===
    row.classList.add('is-breakdown');
    const statusCell = row.querySelector('td[data-label="Status"] > div');
    if (statusCell && !statusCell.querySelector('.badge-breakdown')) {
        statusCell.insertAdjacentHTML('beforeend', '<span class="badge badge-breakdown mt-1">Breakdown</span>');
    }

    // === AJAX Call to Save Breakdown in Database ===
    $.ajax({
        url: '{{ route("brakedown") }}', // Laravel route
        method: 'POST',
        data: {
            inspection_id: incidentId,
            breakdown_equipment: breakdownEquipment,
            breakdown_root_cause: breakdownRootCause,
            breakdown_closure_date: breakdownClosureDate,
            breakdown_step_taken: breakdownStepTaken,
            breakdown_start_time: breakdownStartTime,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log('Breakdown saved successfully:', response);
            location.reload();
            AlertManager.showBreakdown(`BREAKDOWN REPORTED: ${breakdownEquipment} in ${row.dataset.location}.`);
        },
        error: function (xhr) {
            console.error('Error saving breakdown:', xhr.responseText);
            alert('Something went wrong while saving the breakdown.');
        }
    });

    // === Close Modal ===
    ActionModals.breakdown.hide();
});



                const breakdownUpdateModalEl = document.getElementById('breakdownUpdateModal');
                breakdownUpdateModalEl.addEventListener('show.bs.modal', e => {
                    const incidentId = e.relatedTarget.closest('tr').dataset.incidentId;
                    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
                    document.getElementById('breakdownUpdateIncidentId').value = incidentId;
                    
                    const equipmentName = row.dataset.breakdownEquipment || "Equipment";
                    document.getElementById('breakdownUpdateModalLabel').textContent = `(${equipmentName}) Breakdown Status Update`;

                    const updateFormContainer = document.getElementById('breakdownUpdateFormContainer');
                    const postUpdateButton = document.getElementById('confirmBreakdownUpdateBtn');
                    const resolveButton = document.getElementById('confirmBreakdownResolveBtn');
                    const isReadOnly = row.dataset.breakdownStatus === 'resolved' || row.dataset.status === 'Resolved';
                    
                    updateFormContainer.style.display = 'block';
                    updateFormContainer.querySelectorAll('input, textarea').forEach(el => el.disabled = isReadOnly);
                    postUpdateButton.style.display = isReadOnly ? 'none' : 'inline-block';
                    resolveButton.style.display = isReadOnly ? 'none' : 'inline-block';
                    
                    if (!isReadOnly) {
                        document.getElementById('breakdownUpdateForm').reset();
                        document.getElementById('breakdownUpdateDate').value = new Date().toISOString().split('T')[0];
                    }
                    this.populateBreakdownHistory(incidentId, document.getElementById('breakdownHistoryContainer'));
                });
                

                document.getElementById('confirmBreakdownUpdateBtn').addEventListener('click', () => {
    const incidentId = document.getElementById('breakdownUpdateIncidentId').value;
    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
    if (!row) return;

    const comments = document.getElementById('breakdownUpdateComments').value;
    const cost = parseFloat(document.getElementById('breakdownUpdateCost').value) || 0;
    const updateDate = document.getElementById('breakdownUpdateDate').value;

    if (!comments.trim()) {
        alert('Corrective Action/Comments are required for an update.');
        return;
    }

    // Prepare breakdown data for backend
    const breakdownEquipment = row.dataset.equipment || 'N/A';
    const breakdownRootCause = row.dataset.rootCause || 'N/A';
    const breakdownClosureDate = updateDate;
    const breakdownStepTaken = comments;
    const breakdownStartTime = row.dataset.startTime || new Date().toISOString();

    // === Add history locally ===
    const updateHistoryEntry = {
        date: new Date(updateDate).toISOString(),
        reportedBy: row.dataset.registeredBy,
        correctiveAction: comments,
        incurredExpenses: cost.toFixed(2),
        rectifiedBy: row.dataset.assignedTo || 'System'
    };

    ReportHistoryManager.addBreakdownHistoryEntry(incidentId, updateHistoryEntry);

    let currentCost = parseFloat(row.dataset.breakdownTotalCost) || 0;
    row.dataset.breakdownTotalCost = currentCost + cost;

    // Refresh local UI
    this.populateBreakdownHistory(incidentId, document.getElementById('breakdownHistoryContainer'));
    document.getElementById('breakdownUpdateForm').reset();
    document.getElementById('breakdownUpdateDate').value = new Date().toISOString().split('T')[0];

    // === AJAX Call to Laravel backend ===
    $.ajax({
        url: '{{ route("brakedown") }}', // Laravel route
        method: 'POST',
        data: {
            inspection_id: incidentId,
            breakdown_equipment: breakdownEquipment,
            breakdown_root_cause: breakdownRootCause,
            breakdown_closure_date: breakdownClosureDate,
            breakdown_step_taken: breakdownStepTaken,
            breakdown_start_time: breakdownStartTime,
            incurred_cost: cost.toFixed(2), // Optional: send cost to backend
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log('Breakdown updated successfully:', response);
            location.reload();
            AlertManager.showBreakdown(`✅ Breakdown updated for ${breakdownEquipment} in ${row.dataset.location}.`);
        },
        error: function (xhr) {
            console.error('Error updating breakdown:', xhr.responseText);
            alert('Something went wrong while updating the breakdown.');
        }
    });
});


     document.getElementById('confirmBreakdownResolveBtn').addEventListener('click', () => {
    const incidentId = document.getElementById('breakdownUpdateIncidentId').value;
    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
    if (!row) return;

    // Frontend update first
    row.dataset.breakdownStatus = 'pending-verification';
    this.updateRowUI(row);

    // Hide modal
    ActionModals.breakdownUpdate.hide();

    // ✅ AJAX call to update backend status
    $.ajax({
        url: '{{ route("updateBreakdownStatus") }}',
        method: 'POST',
        data: {
            inspection_id: incidentId,
            status: 'Pending Verification',
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.status === 'success') {
                AlertManager.showSuccess('Breakdown status updated to Pending Verification.');
            } else {
                AlertManager.showError('Status update failed.');
            }
            location.reload();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            AlertManager.showError('Server error while updating status.');
        }
    });

    // Show notification
    AlertManager.showVerification(`PENDING VERIFICATION: ${row.dataset.breakdownEquipment} in ${row.dataset.location} is ready for closure verification.`);
});
                
                const verificationModalEl = document.getElementById('breakdownVerificationModal');
                const vCanvas = document.getElementById('verificationSignaturePad');
                const vCtx = vCanvas.getContext('2d');
                let vDrawing = false, vHasSigned = false;

                function getPointerPos(canvasDom, pointerEvent) {
                    const rect = canvasDom.getBoundingClientRect();
                    return { x: pointerEvent.clientX - rect.left, y: pointerEvent.clientY - rect.top };
                }
                vCanvas.addEventListener('mousedown', (e) => { vDrawing = true; const pos = getPointerPos(vCanvas, e); vCtx.beginPath(); vCtx.moveTo(pos.x, pos.y); });
                vCanvas.addEventListener('mouseup', () => { vDrawing = false; });
                vCanvas.addEventListener('mousemove', (e) => { if (vDrawing) { vHasSigned = true; const pos = getPointerPos(vCanvas, e); vCtx.lineTo(pos.x, pos.y); vCtx.stroke(); }});
                document.getElementById('clearVerificationSignatureBtn').addEventListener('click', () => { vCtx.clearRect(0, 0, vCanvas.width, vCanvas.height); vHasSigned = false; });
                
                verificationModalEl.addEventListener('show.bs.modal', e => {
                    const incidentId = e.relatedTarget.closest('tr').dataset.incidentId;
                    document.getElementById('breakdownVerificationIncidentId').value = incidentId;
                    document.getElementById('verificationComments').value = '';
                    vCtx.clearRect(0, 0, vCanvas.width, vCanvas.height); vHasSigned = false;
                    this.populateBreakdownHistory(incidentId, document.getElementById('verificationHistoryContainer'), true);
                });

                document.getElementById('finalSubmitVerificationBtn').addEventListener('click', () => {
    const incidentId = document.getElementById('breakdownVerificationIncidentId').value;
    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
    if (!row) return;

    const comments = document.getElementById('verificationComments').value;
    if (!comments.trim()) { 
        alert('Verification comments are required.'); 
        return; 
    }
    if (!vHasSigned) { 
        alert('A signature is required for verification.'); 
        return; 
    }

    // === Local UI Updates ===
    const resolutionTime = new Date();
    const finalHistoryEntry = {
        date: resolutionTime.toISOString(),
        correctiveAction: "Breakdown closure verified.",
        closureDate: resolutionTime.toISOString(),
        rectifiedBy: row.dataset.assignedTo || 'System',
        verifiedBy: 'Manager (Verified)',
        verificationDate: resolutionTime.toISOString(),
        verificationComments: comments,
        signature: vCanvas.toDataURL()
    };
    ReportHistoryManager.addBreakdownHistoryEntry(incidentId, finalHistoryEntry);

    row.dataset.breakdownStatus = 'resolved';
    //updateRowStatus(row, 'Resolved'); // make sure updateRowStatus is defined globally
    
    this.updateRowStatus(row, 'Resolved');

    const tracker = row.querySelector('.progress-tracker');
    if (tracker) tracker.querySelectorAll('.step').forEach(step => step.classList.add('is-completed'));

    row.classList.remove('is-breakdown');
    if (row.querySelector('.badge-breakdown')) row.querySelector('.badge-breakdown').remove();
    //updateTimers();

    // === AJAX: Send verification to backend ===
    $.ajax({
        url: '{{ route("brakedownVerify") }}',
        method: 'POST',
        data: {
            inspection_id: incidentId,
            breakdown_equipment: row.dataset.breakdownEquipment || '',
            breakdown_root_cause: row.dataset.breakdownRootCause || '',
            breakdown_closure_date: resolutionTime.toISOString(),
            breakdown_step_taken: "Breakdown closure verified.",
            breakdown_start_time: row.dataset.breakdownStartTime || '',
            verification_comments: comments,
            signature: vCanvas.toDataURL(),
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log('Breakdown verified successfully:', response);
            AlertManager.showToast(`Breakdown for ${row.dataset.breakdownEquipment} has been verified and closed.`, 'success');
            
            location.reload();
        },
        error: function (xhr) {
            console.error('Error verifying breakdown:', xhr.responseText);
            alert('Something went wrong while verifying the breakdown.');
        }
    });

    ActionModals.breakdownVerification.hide();
});
                
                document.getElementById('rejectBreakdownBtn').addEventListener('click', () => {
                    const incidentId = document.getElementById('breakdownVerificationIncidentId').value;
                    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
                    if (!row) return;
                    
                    const comments = document.getElementById('verificationComments').value;
                    if (!comments.trim()) { alert('Rejection comments are required.'); return; }
                    
                    const rejectionTime = new Date();
                    const rejectionHistoryEntry = {
                        date: rejectionTime.toISOString(), correctiveAction: "Breakdown closure REJECTED.",
                        verifiedBy: 'Manager (Rejected)', verificationComments: comments
                    };
                    ReportHistoryManager.addBreakdownHistoryEntry(incidentId, rejectionHistoryEntry);

                    row.dataset.breakdownStatus = 'active';
                    this.updateRowUI(row);
                    ActionModals.breakdownVerification.hide();
                });
            },

            populateBreakdownHistory(incidentId, container, isSimple = false) {

    // Show temporary loading message
    container.innerHTML = `<tr><td colspan="${isSimple ? 6 : 10}" class="text-center">Loading history...</td></tr>`;

    $.ajax({
        url: '{{ route("brakedownhistory") }}', // Laravel route to get breakdown history
        method: 'POST',
        data: { inspection_id: incidentId },
        success: function (response) {
            const history = Array.isArray(response.data) ? response.data : [];

            if (history.length === 0) {
                container.innerHTML = `<tr><td colspan="${isSimple ? 6 : 10}" class="text-center">No history yet.</td></tr>`;
                return;
            }

            // Sort by date (ascending)
            history.sort((a, b) => new Date(a.date) - new Date(b.date));

            // Build HTML rows
            container.innerHTML = history.map(entry => {
                const entryDate = new Date(entry.date);
                const formattedReportedDate = `${entryDate.toLocaleDateString()} ${entryDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                let correctiveActionText = entry.current_step_taken || '---';
                if (entry.verification_comments) {
                    correctiveActionText += `<div class="mt-2 pt-1 border-top" style="'var(--success-color)'};"><strong>Verification:</strong> ${entry.verification_comments}</div>`;
                }

                if (isSimple) {
                    return `
                    <tr>
                        <td>${entry.Reported_Date}</td>
                        <td>${entry.reportedBy || '---'}</td>
                        <td>${entry.breakdown || '---'}</td>
                        <td>${correctiveActionText}</td>
                        <td>${entry.rectifiedBy || '---'}</td>
                        <td>₹${parseFloat(entry.incurred_cost || 0).toFixed(2)}</td>
                    </tr>`;
                } else {
                    const formattedTentativeDate = entry.tentativeDate ? new Date(entry.tentativeDate).toLocaleDateString() : '---';
                    const formattedClosureDate = entry.closureDate ? new Date(entry.closureDate).toLocaleDateString() : '---';
                    const formattedVerificationDate = entry.verificationDate ? new Date(entry.verificationDate).toLocaleDateString() : '---';

                    let verifiedByContent = entry.verifiedBy || '---';
                    if (entry.signature) {
                        verifiedByContent += `<br><img src="https://efsm.safefoodmitra.com/admin/public/inspection/${entry.signature}" alt="Signature" style="height: 30px; background-color: white; border: 1px solid #ddd; margin-top: 5px;">`;
                    }

                    return `
                    <tr>
                        <td>${entry.Reported_Date}</td>
                        <td>${entry.reportedBy || '---'}</td>
                        <td>${entry.breakdown || '---'}</td>
                        <td>${entry.tentative_closure_date}</td>
                        <td>${correctiveActionText}</td>
                        <td>${formattedClosureDate}</td>
                        <td>${entry.rectifiedBy || '---'}</td>
                        <td>${verifiedByContent}</td>
                        <td>${formattedVerificationDate}</td>
                        <td>₹${parseFloat(entry.incurred_cost || 0).toFixed(2)}</td>
                    </tr>`;
                }
            }).join('');
        },
        error: function (xhr) {
            console.error('Error loading breakdown history:', xhr.responseText);
            container.innerHTML = `<tr><td colspan="${isSimple ? 6 : 10}" class="text-center text-danger">Failed to load history.</td></tr>`;
        }
    });
},

            showHistoryFor(incidentId) {
                const historyModal = ActionModals.history._element;
                historyModal.dataset.incidentId = incidentId;
                ReportComponent.init(incidentId);
                ActionModals.history.show();
            },

            attachEventListeners() {
                document.getElementById('refreshBtn').addEventListener('click', () => this.clearAllFilters());
                document.getElementById('clearFiltersModalBtn').addEventListener('click', () => this.clearAllFilters());

                
                document.getElementById('confirmClosureBtn').addEventListener('click', () => {
            
                    const incidentId = document.getElementById('closureIncidentId').value;
                    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);
                    if(row) {
                         this.updateRowStatus(row, 'Resolved');
                         AlertManager.showToast(`Observation "${row.querySelector('.concern-title').textContent}" has been addressed.`, 'success');
                    }
                    ActionModals.closure.hide();
                });
                
                const table = document.getElementById('incidentReportTable');
                table.addEventListener('click', e => {
                    const originalLink = e.target.closest('a[data-original-id]');
                    if (originalLink) {
                        e.preventDefault();
                        const originalId = originalLink.dataset.originalId;
                        this.showHistoryFor(originalId);
                        return;
                    }
                    
                    const btn = e.target.closest('button, img, video');
                    if (!btn) return;
                    
                    if (btn.classList.contains('expand-toggle-btn')) {
                        const currentMobileCard = btn.closest('.complaint-card-mobile');
                        
                        // Collapse others before expanding the current one
                        document.querySelectorAll('.complaint-card-mobile.is-expanded').forEach(card => {
                            if (card !== currentMobileCard) {
                                card.classList.remove('is-expanded');
                                const otherBtn = card.querySelector('.expand-toggle-btn');
                                if(otherBtn) {
                                    otherBtn.querySelector('span').textContent = 'Show Details';
                                    const icon = otherBtn.querySelector('i');
                                    icon.classList.remove('fa-chevron-up');
                                    icon.classList.add('fa-chevron-down');
                                }
                            }
                        });

                        currentMobileCard.classList.toggle('is-expanded');

                        const textSpan = btn.querySelector('span');
                        const icon = btn.querySelector('i');
                        if (currentMobileCard.classList.contains('is-expanded')) {
                            textSpan.textContent = 'Hide Details';
                            icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                        } else {
                            textSpan.textContent = 'Show Details';
                            icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                        }
                        return;
                    }
                    
                    const row = btn.closest('tr');
                    if (!row) return;
                    
          if (btn.classList.contains('btn-star')) {
    const isCurrentlyStarred = row.dataset.starred === 'true';
    const newStarState = !isCurrentlyStarred;
    const inspectionId = row.dataset.incidentId; 

    // UI Update
    row.dataset.starred = newStarState.toString();
    row.querySelectorAll('.btn-star').forEach(b => b.classList.toggle('is-starred', newStarState));
    row.querySelectorAll('.btn-star i').forEach(i => {
        i.classList.toggle('fas', newStarState);
        i.classList.toggle('far', !newStarState);
    });

    // UI Refresh
    this.updateRowUI(row);

    // === AJAX CALL ===
    $.ajax({
        url: '{{ route("followinspection") }}', // Laravel route
        method: 'POST',
        data: {
            inspection_id: inspectionId,
            starred: newStarState ? 1 : 0,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log('FollowInspection updated:', response);
        },
        error: function (xhr) {
            console.error('Error updating FollowInspection:', xhr.responseText);
            alert('Something went wrong while updating follow inspection.');
        }
    });
}
                 
                    
                    else if (btn.classList.contains('btn-compliance')) {

    const incidentId = row.dataset.incidentId;

    // Already existing line
    ReportHistoryManager.addHistoryEntry(incidentId, {
        date: new Date().toISOString(),
        status: 'Compliance Verified',
        comments: 'The resolution has been verified as compliant.'
    });

    // Already existing update
    this.updateRowStatus(row, 'Verified');
    AlertManager.showToast('Report marked as compliant.', 'success');


    // ✅ Added AJAX Call
    $.ajax({
        url: '{{ route("inspection_compliant_history") }}',
        method: 'POST',
        data: {
            inspection_id: incidentId,
            status: 'Compliance Verified',
            comments: 'The resolution has been verified as compliant.',
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            console.log('Compliance updated:', response);
        },
        error: function (xhr) {
            console.error('Error updating compliance:', xhr.responseText);
            alert('Something went wrong while updating compliance.');
        }
    });

}
                    else if(btn.classList.contains('btn-not-compliance')) {
                        document.getElementById('nonComplianceOriginalId').value = row.dataset.incidentId;
                            document.getElementById('closureIncidentIds1').value = 2;
                        //ActionModals.nonCompliance.show();
                        
                            document.getElementById('closureIncidentIds').value = row.dataset.incidentId;
    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    
    document.querySelector('.header').textContent = 'Reason for Non-Compliance:';
    document.querySelector('.exampleModalLabeltext').textContent = 'Re-open as Non-Compliance';

document.querySelectorAll('.reopenbox').forEach(el => {
    el.style.display = 'block';
});


    myModal.show();
    
                    }
                    else if(btn.classList.contains('btn-not-applicable')) {
                        document.getElementById('naIncidentId').value = row.dataset.incidentId;
                        ActionModals.na.show();
                    }
                    
                    else if(btn.classList.contains('btn-not-applicable1')) {
                        document.getElementById('naIncidentId1').value = row.dataset.incidentId;
                       
                       
                        const incidentId = row.dataset.incidentId;
    $.ajax({
        url: '{{ route("inspection_compliant_history") }}',
        method: 'POST',
        data: {
            inspection_id: incidentId,
            status: 'Not Done',
            type: 4,
            comments: 'The resolution has been not done as compliant.',
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            location.reload();
            console.log('Compliance updated:', response);
        },
        error: function (xhr) {
            console.error('Error updating compliance:', xhr.responseText);
            alert('Something went wrong while updating compliance.');
        }
    });
    
    AlertManager.showToast('Report marked as not done.', 'success');
    
    
                    }
                    
                    
                    else if(btn.classList.contains('btn-breakdown')) { ActionModals.breakdown.show(btn); }
                    else if(btn.classList.contains('btn-breakdown-update')) {
                        
                   
                        const status = row.dataset.breakdownStatus;
const breakdownUpdateFormContainer = document.getElementById('breakdownUpdateFormContainer');

if (status === 'resolved') {
    breakdownUpdateFormContainer.classList.add('hide-important');
} else {
    breakdownUpdateFormContainer.classList.remove('hide-important');
}
                        if (status === 'pending-verification') { ActionModals.breakdownVerification.show(btn); } 
                        else { ActionModals.breakdownUpdate.show(btn); }
                    }
                  else if (btn.classList.contains('btn-edit')) {
    const inspectionId = row.dataset.incidentId;
    if (!inspectionId) {
        console.error("Inspection ID not found in dataset");
        return;
    }
    
    const currentPage = new URLSearchParams(window.location.search).get("page") || 1;

window.location.href = `/admin/public/index.php/inspection/editinspection/${inspectionId}?page=${currentPage}`;
    //window.location.href = `/admin/public/index.php/inspection/editinspection/${inspectionId}`;
}
                    else if (btn.classList.contains('btn-assign')) { ActionModals.assign.show(btn); }
                    else if (btn.classList.contains('btn-acknowledge-staff')) { ActionModals.staffAck.show(btn); }
                   // else if (btn.classList.contains('btn-complete-task')) { document.getElementById('closureIncidentId').value = row.dataset.incidentId; ActionModals.closure.show(btn); }
                   
                   else if (btn.classList.contains('btn-complete-task')) {
                
    document.getElementById('closureIncidentIds').value = row.dataset.incidentId;
    document.getElementById('closureIncidentIds1').value = 1;
       document.querySelector('.header').textContent = 'Observation Closure Form';
      document.querySelector('.exampleModalLabeltext').textContent = 'Observation Closure Form';
    
    // agar aapko ActionModals.closure.show(btn) ki zarurat nahi hai to ye hata dein:
    // ActionModals.closure.show(btn);

    // Bootstrap modal show karne ke liye:
    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    document.querySelectorAll('.reopenbox').forEach(el => {
    el.style.display = 'none';
});
    myModal.show();
}

                    else if (btn.classList.contains('btn-history') || btn.classList.contains('btn-progress') || btn.classList.contains('btn-view')) { ActionModals.history.show(btn); }
                  //  else if (btn.classList.contains('btn-delete') && confirm('Delete this report11?')) { row.remove(); this.allTableRows = this.allTableRows.filter(r => r !== row); this.displayPage(this.currentPage); }
                  
                  else if (btn.classList.contains('btn-delete') && confirm('Delete this report?')) {
                      console.log(row);
    const reportId = row.dataset.incidentId; // assuming each row has data-id="123"

    $.ajax({
        url: '{{ route("deleteInspection") }}',
        method: 'POST',
        data: {
            id: reportId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.status === 'success') {
                // remove row from table
                row.remove();
                // update local rows array if needed
                this.allTableRows = this.allTableRows.filter(r => r !== row);
                this.displayPage(this.currentPage);

               // toastr.success(response.message || 'Report deleted successfully');
            } else {
                toastr.error(response.message || 'Failed to delete report');
            }
        }.bind(this), // bind 'this' so that displayPage works
        error: function(xhr) {
            toastr.error('Something went wrong while deleting');
            console.error(xhr.responseText);
        }
    });
}

                    else if (btn.classList.contains('report-image-thumb')) {
                         const modalBody = document.querySelector("#imageModal .modal-body");
                         const mediaSrc = btn.tagName === 'IMG' ? btn.src : btn.querySelector('source')?.src || btn.src;
                         modalBody.innerHTML = btn.tagName === 'VIDEO' 
                            ? `<video src="${mediaSrc}" controls autoplay style="max-width:100%; max-height: 80vh;"></video>`
                            : `<img src="${mediaSrc}" class="img-fluid" />`;
                         ActionModals.image.show();
                    }
                });
                document.getElementById('newReportBtn').addEventListener('click', () => { ComplaintFormManager.prepareForNew(); });
            },



handleNaConfirmation() {
    const incidentId = document.getElementById('naIncidentId').value;
    const comments = document.getElementById('naComments').value;
    const fileInput = document.getElementById('naEvidence');
    const row = document.querySelector(`tr[data-incident-id="${incidentId}"]`);

    if (!row || !comments) {
        alert('Please provide a reason.');
        return;
    }

    // ✅ UI update
    ReportHistoryManager.addHistoryEntry(incidentId, {
        date: new Date().toISOString(),
        status: 'Not Applicable',
        comments: comments
    });
    this.updateRowStatus(row, 'Not Applicable');
    AlertManager.showToast('Report marked as Not Applicable.', 'info');
    ActionModals.na.hide();

    // ✅ Prepare FormData
    const formData = new FormData();
    formData.append('inspection_id', incidentId);
    formData.append('status', 'Not Applicable');
    formData.append('comments', comments);
    formData.append('type', 3);
    formData.append('_token', '{{ csrf_token() }}');

    // ✅ Append file if selected
    if (fileInput && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        console.log('File selected:', file.name);
        formData.append('naEvidence', file);
    } else {
        console.log('No file selected');
    }

    // ✅ Send AJAX request
    $.ajax({
        url: '{{ route("inspection_compliant_history") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log('✅ Response:', response);
            document.getElementById('naForm').reset();
        },
        error: function (xhr) {
            console.error('❌ AJAX Error:', xhr.responseText);
            alert('Something went wrong while marking Not Applicable.');
        }
    });
},

            
            handleNonComplianceConfirmation() {
                
    
                const originalId = document.getElementById('nonComplianceOriginalId').value;
                const comments = document.getElementById('nonComplianceComments').value;
                const fileInput = document.getElementById('nonCompliancePhoto');
                const row = document.querySelector(`tr[data-incident-id="${originalId}"]`);
                if (!row || !comments.trim()) { alert('Please provide a reason.'); return; }

                const isClosed = ['Resolved', 'Verified'].includes(row.dataset.status);

                if(isClosed) { 
                    if(!fileInput.files.length) { alert('Please provide new evidence to re-open a task.'); return; }
                    
                    ReportHistoryManager.addHistoryEntry(originalId, { date: new Date().toISOString(), status: 'Non-Compliance Found', comments: `A new follow-up report was created. Reason: ${comments}` });
                    this.updateRowStatus(row, 'Follow-up Created');
                    
                    const originalCommentCell = row.querySelector('.closure-comments-cell');
                    if(originalCommentCell) {
                        originalCommentCell.innerHTML = `<div class="text-danger fw-bold border-bottom pb-1 mb-1">Re-opened: ${comments}</div>` + originalCommentCell.innerHTML;
                    }

                     const newReportData = {
                        title: `(Re-opened) ${row.querySelector('.concern-title').innerText}`,
                        sop: row.dataset.sop,
                        location: row.dataset.location,
                        department: row.dataset.department,
                        unit: row.dataset.unit,
                        region: row.dataset.region,
                        risk: row.dataset.risk,
                        status: 'Open',
                        registeredBy: 'System',
                        images: { before: URL.createObjectURL(fileInput.files[0]) },
                        originalIncidentId: originalId
                    };
                    const newRow = ReportProcessor.createAndDisplayRow(newReportData);
                    this.displayPage(this.currentPage);
                    AlertManager.showToast('New non-compliance report created.', 'warning');

                } else {
                     ReportHistoryManager.addHistoryEntry(originalId, { 
                        date: new Date().toISOString(), 
                        status: 'Non-Compliance Logged', 
                        comments: `Non-compliance noted. Reason: ${comments}` 
                    });
                    AlertManager.showToast('Non-compliance has been logged.', 'info');
                }

                ActionModals.nonCompliance.hide();
                document.getElementById('nonComplianceForm').reset();
            },

            updateRowStatus(row, newStatus) {
                row.dataset.status = newStatus;
                if (['Resolved', 'Verified', 'Not Applicable', 'Follow-up Created'].includes(newStatus)) {
                    row.dataset.completedTime = new Date().toISOString();
                }
                this.updateRowUI(row);
                this.updateTimers();
            }
        };
    
        const ReportHistoryManager = {
            initializeReportData(row) {
                const id = row.dataset.incidentId;
                if (!reportDatabase[id]) {
                    const areaParts = row.querySelector('td[data-label="Area"] span').innerText.split(' / ');
                    reportDatabase[id] = {
                        id: id, title: row.querySelector('.concern-title').innerText, sop: row.dataset.sop, startDate: row.dataset.reportedTime, endDate: row.dataset.completedTime || null, deviation: row.dataset.risk,
                        risk: { level: Math.floor(Math.random() * 20), category: row.dataset.risk }, responsibility: row.querySelector('.concern-responsibility span').innerText, 
                        area: row.querySelector('td[data-label="Area"] span').innerText, status: row.dataset.status,
                        imageBefore: row.querySelector('.report-image-thumb')?.src, imageAfter: row.querySelectorAll('.report-image-thumb')[1]?.src, 
                        history: [], breakdownHistory: []
                    };
                }
            },
            addHistoryEntry(incidentId, entry) { if(reportDatabase[incidentId]) { reportDatabase[incidentId].history.unshift(entry); } },
            addBreakdownHistoryEntry(incidentId, entry) { if(reportDatabase[incidentId]) { reportDatabase[incidentId].breakdownHistory.push(entry); } }
        };

        const ReportComponent = {
             init: async function(id) {
                 const data = reportDatabase[id] || { history: [] };
                 const row = document.querySelector(`tr[data-incident-id="${id}"]`);
                 this.render(data);
                 this.setupEventListeners();
                 const updateSection = document.getElementById('report-update-section');
                 if (row && (row.dataset.status === 'Resolved' || row.dataset.status === 'Verified' || row.dataset.status === 'Not Applicable')) { 
                     updateSection.style.display = 'none'; 
                 } else { 
                     updateSection.style.display = 'block'; 
                 }
             },
            formatDate: (dateString) => { if (!dateString) return "Pending"; const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }; return new Date(dateString).toLocaleDateString('en-US', options); },
            render: function(data) { 
                const modalBody = document.getElementById('historyModalBody');
                modalBody.querySelector('[data-js="start-date"]').textContent = this.formatDate(data.startDate);
                modalBody.querySelector('[data-js="end-date"]').textContent = this.formatDate(data.endDate);
                const evidenceSection = modalBody.querySelector('[data-js="evidence-section"]');
                evidenceSection.innerHTML = `<div class="evidence-image-wrapper" data-img-src="${data.imageBefore}"><img src="${data.imageBefore}" alt="Before image"><div class="evidence-tag">Before</div></div>${data.imageAfter ? `<div class="evidence-image-wrapper" data-img-src="${data.imageAfter}"><img src="${data.imageAfter}" alt="After image"><div class="evidence-tag">After</div></div>` : ''}`;
                modalBody.querySelector('[data-js="title"]').textContent = data.title;
                modalBody.querySelector('[data-js="meta-info"]').innerHTML = `<span>SOP: ${data.sop}</span> &nbsp;&nbsp; <span>&#9888; Dev: ${data.deviation}</span>`;
                modalBody.querySelector('[data-js="risk"]').innerHTML = `<span class="risk">Risk: ${data.risk.level} (${data.risk.category})</span>`;
                modalBody.querySelector('[data-js="responsibility"]').innerHTML = `<span>Responsibility: ${data.responsibility}</span>`;
                modalBody.querySelector('[data-js="area"]').innerHTML = data.area.replace(/\//g, '/<br>');
                const tableBody = modalBody.querySelector('[data-js="history-table-body"]');
                
               console.log(data);
                
                $.ajax({
    url: '{{ route("inspection_progress_comments") }}',
    method: 'POST',
    data: {
        inspection_id: data.id,
        _token: '{{ csrf_token() }}'
    },
    success: function (response) {
        const history = Array.isArray(response.data) ? response.data : [];

        if (history.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="4" class="text-center">No history yet.</td></tr>`;
            return;
        }

        tableBody.innerHTML = history.map(item => `
            <tr>
                <td data-label="Date & Time">${new Date(item.created_at).toLocaleString()}</td>
                <td data-label="Status">
                    <span class="status-tag status-${(item.status || '').toLowerCase().replace(/\s+/g, '-')}">
                        ${item.status}
                    </span>
                </td>
                <td data-label="Comments">${item.comment}</td>
                <td data-label="Evidence">
                    ${item.evidence ? 
                        (/\.(mp4|mov|avi|mkv)$/i.test(item.evidence) 
                            ? `<video controls width="200"><source src="https://efsm.safefoodmitra.com/admin/public/inspection/${item.evidence}" type="video/mp4"></video>`
                            : `<img src="https://efsm.safefoodmitra.com/admin/public/inspection/${item.evidence}" alt="Evidence" class="table-image" style="max-height: 80px;">`)
                        : 'N/A'}
                </td>
            </tr>
        `).join('');
    },
    error: function (xhr) {
        console.error('Error loading progress history:', xhr.responseText);
        tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Failed to load history.</td></tr>`;
    }
});


            },
             setupEventListeners: function() {
                const modalBody = document.getElementById('historyModalBody');
                modalBody.addEventListener('click', (e) => { const imageWrapper = e.target.closest('[data-img-src]'); if (imageWrapper) { modalBody.querySelector('[data-js="modal-image"]').src = imageWrapper.dataset.imgSrc; modalBody.querySelector('#image-modal').classList.add('visible'); } });
                modalBody.querySelector('[data-js="modal-close"]').addEventListener('click', () => modalBody.querySelector('#image-modal').classList.remove('visible'));

                $('#postHistoryUpdateBtn').on('click', function () {
    const incidentId = ActionModals.history._element.dataset.incidentId;
    const comment = $('#historyComment').val().trim();
    const evidenceFile = $('#historyEvidence')[0].files[0];

    if (!comment && !evidenceFile) {
        alert('Please add a comment or attach evidence.');
        return;
    }

    let formData = new FormData();
    formData.append('incident_id', incidentId);
    formData.append('comment', comment || 'Evidence provided.');
    if (evidenceFile) {
        formData.append('evidence', evidenceFile);
    }
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
        url: '{{ route("postprogress") }}',
        method: 'POST',
        data: formData,
        processData: false,  // required for FormData
        contentType: false,  // required for FormData
        success: function (response) {

            
            if (response.success || response.status === "success") {
    alert('Progress updated successfully.');
    location.reload(true); // force reload from server
    return; // ⛔ UI update code skip ho jayega
}
            else {
                alert(response.message || 'Something went wrong.');
            }
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseText);
            alert('Error submitting progress update.');
        }
    });
});


            }
        };
        
        document.getElementById('historyModal').addEventListener('show.bs.modal', (e) => { const incidentId = e.relatedTarget.closest('tr').dataset.incidentId; ActionModals.history._element.dataset.incidentId = incidentId; ReportComponent.init(incidentId); });
        

// ====================== EXPORT BUTTON CLICK ======================
document.getElementById('exportExcelBtn').addEventListener('click', () => {
    showLoader(); // show white overlay immediately

    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('per_page', '25');
    currentUrl.searchParams.set('limit', 'all');
    currentUrl.searchParams.set('export_excel', '1'); // trigger auto export
    window.location.href = currentUrl.toString(); // redirect
});

// ====================== LOADER FUNCTIONS ======================
function showLoader() {
    let loader = document.createElement('div');
    loader.id = 'excelLoader';
    loader.style.position = 'fixed';
    loader.style.top = 0;
    loader.style.left = 0;
    loader.style.width = '100%';
    loader.style.height = '100%';
    loader.style.background = 'rgba(255,255,255,0.95)'; // white overlay
    loader.style.display = 'flex';
    loader.style.alignItems = 'center';
    loader.style.justifyContent = 'center';
    loader.style.zIndex = 9999;
    loader.innerHTML = `
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    `;
    document.body.appendChild(loader);
}

function hideLoader() {
    const loader = document.getElementById('excelLoader');
    if (loader) loader.remove();
}

// ====================== PAGE LOAD AUTO EXPORT ======================
window.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('export_excel') === '1') {
        // Remove the flag to prevent loop
        urlParams.delete('export_excel');
        history.replaceState(null, '', `${window.location.pathname}?${urlParams.toString()}`);

        await exportAllDataToExcel();
    }
});

// async function exportAllDataToExcel() {
//     showLoader();
//     const btn = document.getElementById('exportExcelBtn');
//     btn.disabled = true;
//     btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Preparing data...`;

//     // Convert image URL to base64
//     async function imageUrlToBase64(url) {
//         if (!url || url.includes('default')) return null;
//         try {
//             const response = await fetch(url);
//             const blob = await response.blob();
//             return await new Promise((resolve, reject) => {
//                 const reader = new FileReader();
//                 reader.onloadend = () => resolve(reader.result.split(',')[1]); // only base64 part
//                 reader.onerror = reject;
//                 reader.readAsDataURL(blob);
//             });
//         } catch (e) {
//             console.error("Image fetch error:", e, url);
//             return null;
//         }
//     }

//     const workbook = new ExcelJS.Workbook();
//     const worksheet = workbook.addWorksheet('Report');

//     // Define columns
//     worksheet.columns = [
//         { header: 'Sl No', key: 'sl_no', width: 8 },
//         { header: 'Complaint ID', key: 'complaint_id', width: 20 },
//         { header: 'Report Id', key: 'id', width: 20 },
//         { header: 'Reported Date', key: 'reported_date', width: 25 },
//         { header: 'Area', key: 'area', width: 45 },
//         { header: 'Reported By', key: 'reported_by', width: 20 },
//         { header: 'Report details', key: 'details', width: 50 },
//         { header: 'Before Image', key: 'before_image', width: 15 },
//         { header: 'Responsibility', key: 'responsibility', width: 30 },
//         { header: 'After Image', key: 'after_image', width: 15 },
//         { header: 'Closure Comments', key: 'closure_comments', width: 50 },
//         { header: 'SOPs', key: 'sops', width: 30 },
//         { header: 'Risk', key: 'risk', width: 15 },
//         { header: 'Total Hrs', key: 'total_hrs', width: 12 },
//         { header: 'Assigned To', key: 'assigned_to', width: 30 },
//         { header: 'Tracking Status', key: 'tracking_status', width: 30 },
//         { header: 'Follow-up History', key: 'follow_up_history', width: 60, style: { alignment: { wrapText: true } } },
//         { header: 'Breakdown History', key: 'breakdown_history', width: 60, style: { alignment: { wrapText: true } } }
//     ];
//     worksheet.getRow(1).font = { bold: true };

//     const rowsToProcess = IncidentTableManager.activeRows;

//     for (const [index, row] of rowsToProcess.entries()) {
//         const na = (val) => val || 'NA';
//         const closureComments = row.querySelector('.closure-comments-cell')?.innerText;

//         const totalHrs = (row.dataset.completedTime && row.dataset.reportedTime)
//             ? ((new Date(row.dataset.completedTime) - new Date(row.dataset.reportedTime)) / 3600000).toFixed(2)
//             : 'NA';

//         const trackingText = Array.from(row.querySelectorAll('.progress-tracker .step-label'))
//             .map(label => label.innerText.replace(/\n/g, ' '))
//             .join('\n');

//         const incidentId = row.dataset.incidentId;
//         const reportData = reportDatabase[incidentId];

//         const followUpHistory = (reportData.history || [])
//             .map(h => `[${new Date(h.date).toLocaleString()}] - ${h.status}: ${h.comments}`)
//             .join('\n');

//         const breakdownHistory = (reportData.breakdownHistory || [])
//             .map(h => {
//                 let parts = [`[${new Date(h.date).toLocaleString()}]`];
//                 if (h.breakdownReason) parts.push(`Reason: ${h.breakdownReason}`);
//                 if (h.correctiveAction) parts.push(`Action: ${h.correctiveAction}`);
//                 if (h.incurredExpenses) parts.push(`Cost: ${h.incurredExpenses}`);
//                 if (h.verifiedBy) parts.push(`Verified by ${h.verifiedBy}: ${h.verificationComments}`);
//                 return parts.join(' - ');
//             }).join('\n');

//         const rowData = {
//             sl_no: index + 1,
//             complaint_id: row.dataset.complaintId,
//             id: incidentId,
//             reported_date: new Date(row.dataset.reportedTime).toLocaleString('en-GB'),
//             area: row.querySelector('td[data-label="Area"] span')?.innerText,
//             reported_by: na(row.dataset.registeredBy),
//             details: row.querySelector('.concern-title')?.innerText,
//             responsibility: row.querySelector('.concern-responsibility span')?.innerText,
//             closure_comments: (closureComments && closureComments.trim() !== '---') ? closureComments : 'NA',
//             sops: na(row.dataset.sop),
//             risk: na(row.dataset.risk),
//             total_hrs: totalHrs,
//             assigned_to: na(row.dataset.assignedTo),
//             tracking_status: trackingText,
//             follow_up_history: followUpHistory || 'No follow-up history.',
//             breakdown_history: row.dataset.isBreakdown ? (breakdownHistory || 'No breakdown history.') : 'NA'
//         };

//         const addedRow = worksheet.addRow(rowData);
//         addedRow.height = 90;
//         addedRow.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };

//         // BEFORE IMAGE
//         const beforeImgEl = row.querySelector('.image-cell img.report-image-thumb');
//         const beforeImgBase64 = beforeImgEl ? await imageUrlToBase64(beforeImgEl.src) : null;
//         if (beforeImgBase64) {
//             const imgId = workbook.addImage({ base64: beforeImgBase64, extension: 'jpeg' });
//             worksheet.addImage(imgId, { tl: { col: 7, row: index + 1 }, ext: { width: 150, height: 150 } });
//         }

//         // AFTER IMAGE
//         const allImages = row.querySelectorAll('.image-cell img.report-image-thumb');
//         const afterImgEl = allImages.length > 1 ? allImages[1] : null;
//         const afterImgBase64 = afterImgEl ? await imageUrlToBase64(afterImgEl.src) : null;
//         if (afterImgBase64 && afterImgBase64 !== beforeImgBase64) {
//             const imgId = workbook.addImage({ base64: afterImgBase64, extension: 'jpeg' });
//             worksheet.addImage(imgId, { tl: { col: 9, row: index + 1 }, ext: { width: 150, height: 150 } });
//         }

//         btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Processing ${index + 1}/${rowsToProcess.length}...`;
//     }

//     btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Generating file...`;

//     const buffer = await workbook.xlsx.writeBuffer();
//     const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
//     const link = document.createElement("a");
//     link.href = URL.createObjectURL(blob);
//     link.download = `Report_${new Date().toISOString().slice(0,10)}.xlsx`;
//     link.click();
//     URL.revokeObjectURL(link.href);

//     hideLoader();
//     window.location.href = 'https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list';
// }


// async function exportAllDataToExcel() {
//     showLoader();

//     const btn = document.getElementById('exportExcelBtn');
//     btn.disabled = true;
//     btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Preparing data...`;

//     // Convert image URL to base64
//     async function imageUrlToBase64(url) {
//         if (!url || url.includes('default')) return null;
//         try {
//             const response = await fetch(url);
//             const blob = await response.blob();
//             return await new Promise((resolve, reject) => {
//                 const reader = new FileReader();
//                 reader.onloadend = () => resolve(reader.result.split(',')[1]);
//                 reader.onerror = reject;
//                 reader.readAsDataURL(blob);
//             });
//         } catch (e) {
//             console.error("Image fetch error:", e, url);
//             return null;
//         }
//     }

//     // ⭐ NEW FUNCTION — Follow-up comments fetch
//     async function getFollowUpHistory(inspectionId) {
//         try {
//             const response = await fetch("{{ route('get_inspection_progress_comments') }}", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                     "X-CSRF-TOKEN": "{{ csrf_token() }}"
//                 },
//                 body: JSON.stringify({ inspection_id: inspectionId })
//             });

//             const json = await response.json();

//             // Response format:
//             // { data: { id, inspection_id, comment, status, created_at ... } }
//             if (!json || !json.data) {
//                 return "No follow-up history.";
//             }

//             const d = json.data;

//             return `[${new Date(d.created_at).toLocaleString()}] - ${d.status}: ${d.comment}`;

//         } catch (error) {
//             console.error("Follow-up fetch error:", error);
//             return "No follow-up history.";
//         }
//     }

//     const workbook = new ExcelJS.Workbook();
//     const worksheet = workbook.addWorksheet('Report');

//     worksheet.columns = [
//         { header: 'Sl No', key: 'sl_no', width: 8 },
//         { header: 'Complaint ID', key: 'complaint_id', width: 20 },
//         { header: 'Report Id', key: 'id', width: 20 },
//         { header: 'Reported Date', key: 'reported_date', width: 25 },
//         { header: 'Area', key: 'area', width: 45 },
//         { header: 'Reported By', key: 'reported_by', width: 20 },
//         { header: 'Report details', key: 'details', width: 50 },
//         { header: 'Before Image', key: 'before_image', width: 15 },
//         { header: 'Responsibility', key: 'responsibility', width: 30 },
//         { header: 'After Image', key: 'after_image', width: 15 },
//         { header: 'Closure Comments', key: 'closure_comments', width: 50 },
//         { header: 'SOPs', key: 'sops', width: 30 },
//         { header: 'Risk', key: 'risk', width: 15 },
//         { header: 'Total Hrs', key: 'total_hrs', width: 12 },
//         { header: 'Assigned To', key: 'assigned_to', width: 30 },
//         { header: 'Tracking Status', key: 'tracking_status', width: 30 },
//         { header: 'Follow-up History', key: 'follow_up_history', width: 60, style: { alignment: { wrapText: true } } },
//         { header: 'Breakdown History', key: 'breakdown_history', width: 60, style: { alignment: { wrapText: true } } }
//     ];
//     worksheet.getRow(1).font = { bold: true };

//     const rowsToProcess = IncidentTableManager.activeRows;

//     for (const [index, row] of rowsToProcess.entries()) {
//         const na = (v) => v || "NA";

//         const incidentId = row.dataset.incidentId;

//         // ⭐ GET FOLLOW-UP HISTORY FROM SERVER API
//         const followUpHistory = await getFollowUpHistory(incidentId);

//         const addedRow = worksheet.addRow({
//             sl_no: index + 1,
//             complaint_id: row.dataset.complaintId,
//             id: incidentId,
//             reported_date: new Date(row.dataset.reportedTime).toLocaleString("en-GB"),
//             area: row.querySelector('td[data-label="Area"] span')?.innerText,
//             reported_by: na(row.dataset.registeredBy),
//             details: row.querySelector('.concern-title')?.innerText,
//             responsibility: row.querySelector('.concern-responsibility span')?.innerText,
//             closure_comments: na(row.querySelector('.closure-comments-cell')?.innerText),
//             sops: na(row.dataset.sop),
//             risk: na(row.dataset.risk),
//             total_hrs: row.dataset.completedTime
//                 ? ((new Date(row.dataset.completedTime) - new Date(row.dataset.reportedTime)) / 3600000).toFixed(2)
//                 : "NA",
//             assigned_to: na(row.dataset.assignedTo),
//             tracking_status: Array.from(row.querySelectorAll('.progress-tracker .step-label'))
//                 .map(label => label.innerText.replace(/\n/g, ' '))
//                 .join('\n'),
//             follow_up_history: followUpHistory,
//             breakdown_history: row.dataset.isBreakdown ? "Breakdown history here" : "No breakdown history."
//         });

//         addedRow.height = 90;
//         addedRow.alignment = {
//             vertical: "middle",
//             horizontal: "center",
//             wrapText: true
//         };

//         // BEFORE IMAGE
//         const beforeImgEl = row.querySelector('.image-cell img.report-image-thumb');
//         const beforeImgBase64 = beforeImgEl ? await imageUrlToBase64(beforeImgEl.src) : null;

//         if (beforeImgBase64) {
//             const imgId = workbook.addImage({ base64: beforeImgBase64, extension: 'jpeg' });
//             worksheet.addImage(imgId, { tl: { col: 7, row: index + 1 }, ext: { width: 150, height: 150 } });
//         }

//         // AFTER IMAGE
//         const allImages = row.querySelectorAll('.image-cell img.report-image-thumb');
//         const afterImgEl = allImages.length > 1 ? allImages[1] : null;
//         const afterImgBase64 = afterImgEl ? await imageUrlToBase64(afterImgEl.src) : null;

//         if (afterImgBase64 && afterImgBase64 !== beforeImgBase64) {
//             const imgId = workbook.addImage({ base64: afterImgBase64, extension: 'jpeg' });
//             worksheet.addImage(imgId, { tl: { col: 9, row: index + 1 }, ext: { width: 150, height: 150 } });
//         }

//         btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Processing ${index + 1}/${rowsToProcess.length}...`;
//     }

//     btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Generating file...`;

//     const buffer = await workbook.xlsx.writeBuffer();
//     const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });

//     const link = document.createElement("a");
//     link.href = URL.createObjectURL(blob);
//     link.download = `Report_${new Date().toISOString().slice(0, 10)}.xlsx`;
//     link.click();

//     URL.revokeObjectURL(link.href);

//     hideLoader();

//     window.location.href = 'https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list';
// }


async function exportAllDataToExcel() {

    showLoader();
    const btn = document.getElementById('exportExcelBtn');
    btn.disabled = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Preparing data...`;


    // ------------------------------
    // Convert Image to Base64
    // ------------------------------
    async function imageUrlToBase64(url) {
        if (!url || url.includes('default')) return null;

        try {
            const response = await fetch(url, { mode: "cors" });
            const blob = await response.blob();

            return await new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onloadend = () => resolve(reader.result.split(',')[1]);
                reader.onerror = reject;
                reader.readAsDataURL(blob);
            });
        } catch (e) {
            console.error("Image fetch error:", e, url);
            return null;
        }
    }


    // ------------------------------
    // FOLLOW-UP HISTORY API
    // ------------------------------
    async function getFollowUpHistory(inspectionId) {
        try {
            const res = await fetch("{{ route('get_inspection_progress_comments') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ inspection_id: inspectionId })
            });

            const json = await res.json();

            if (!json?.data) return "No follow-up history.";

            const h = json.data;
            return `[${new Date(h.created_at).toLocaleString()}] - ${h.status}: ${h.comment}`;

        } catch (err) {
            console.error("Follow-up error", err);
            return "Unable to load follow-up history.";
        }
    }



    // -----------------------------------------------------
    // FIXED BREAKDOWN HISTORY (REPORT API + AJAX MERGED)
    // -----------------------------------------------------
    async function getMergedBreakdownHistory(incidentId, reportData) {

        let merged = [];

        // ---- MAIN REPORT API HISTORY ----
        if (reportData?.breakdownHistory?.length) {
            merged = reportData.breakdownHistory.map(h => ({
                date: h.date || h.created_at,
                status: h.breakdownStatus,
                equipment: h.equipment_id,
                issue: h.breakdownReason || h.breakdown,
                action: h.correctiveAction,
                cost: h.incurredExpenses,
                verifyComments: h.verificationComments
            }));
        }

        // ---- AJAX HISTORY ----
        try {
            const ajax = await $.ajax({
                url: '{{ route("brakedownhistory") }}',
                method: 'POST',
                data: { inspection_id: incidentId, _token: '{{ csrf_token() }}' }
            });

            if (ajax?.data?.length) {
                const ajaxMapped = ajax.data.map(h => ({
                    date: h.Reported_Date || h.created_at,
                    status: h.breakdownStatus,
                    equipment: h.equipment_id,
                    issue: h.breakdown,
                    action: h.current_step_taken,
                    cost: h.incurred_cost,
                    verifyComments: h.verification_comments
                }));
                merged = [...merged, ...ajaxMapped];
            }

        } catch (err) {
            console.error("Breakdown fetch error:", err);
        }

        // ---- NO HISTORY ----
        if (!merged.length) return "No breakdown history.";

        // ---- SORT ----
        merged.sort((a, b) => new Date(a.date) - new Date(b.date));

        // ---- FORMAT ----
        return merged
            .map(h => {
                let p = [`[${new Date(h.date).toLocaleString()}]`];

                if (h.status) p.push(`Status: ${h.status}`);
                if (h.equipment) p.push(`Equipment: ${h.equipment}`);
                if (h.issue) p.push(`Issue: ${h.issue}`);
                if (h.action) p.push(`Action: ${h.action}`);
                if (h.cost) p.push(`Cost: ${h.cost}`);
                if (h.verifyComments) p.push(`Verified: ${h.verifyComments}`);

                return p.join(" - ");
            })
            .join("\n");
    }



    // ------------------------------
    // WORKBOOK INIT
    // ------------------------------
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet('Report');

    worksheet.columns = [
        { header: 'Sl No', key: 'sl_no', width: 8 },
        { header: 'Complaint ID', key: 'complaint_id', width: 20 },
        { header: 'Report Id', key: 'id', width: 20 },
        { header: 'Reported Date', key: 'reported_date', width: 25 },
        { header: 'Area', key: 'area', width: 40 },
        { header: 'Reported By', key: 'reported_by', width: 20 },
        { header: 'Report details', key: 'details', width: 55 },
        { header: 'Before Image', key: 'before_image', width: 15 },
        { header: 'Responsibility', key: 'responsibility', width: 25 },
        { header: 'After Image', key: 'after_image', width: 15 },
        { header: 'Closure Comments', key: 'closure_comments', width: 45 },
        { header: 'SOPs', key: 'sops', width: 30 },
        { header: 'Risk', key: 'risk', width: 20 },
        { header: 'Total Hrs', key: 'total_hrs', width: 12 },
        { header: 'Assigned To', key: 'assigned_to', width: 30 },
        { header: 'Tracking Status', key: 'tracking_status', width: 30 },
        { header: 'Follow-up History', key: 'follow_up_history', width: 60, style: { alignment: { wrapText: true } } },
        { header: 'Breakdown History', key: 'breakdown_history', width: 60, style: { alignment: { wrapText: true } } }
    ];

    worksheet.getRow(1).font = { bold: true };


    // ------------------------------
    // PROCESS ALL ROWS
    // ------------------------------
    const rowsToProcess = IncidentTableManager.activeRows;

    for (const [index, row] of rowsToProcess.entries()) {

        const na = (v) => v || 'NA';
        const incidentId = row.dataset.incidentId;

        const reportData = IncidentTableManager.fullReportData?.[incidentId] || {};

        // FOLLOW-UP
        const followUpHistory = await getFollowUpHistory(incidentId);

        // BREAKDOWN
        const breakdownHistory = row.dataset.isBreakdown === "1"
            ? await getMergedBreakdownHistory(incidentId, reportData)
            : "NA";


        const rowData = {
            sl_no: index + 1,
            complaint_id: row.dataset.complaintId,
            id: incidentId,
            reported_date: new Date(row.dataset.reportedTime).toLocaleString('en-GB'),
            area: row.querySelector('td[data-label="Area"] span')?.innerText,
            reported_by: na(row.dataset.registeredBy),
            details: row.querySelector('.concern-title')?.innerText,
            responsibility: row.querySelector('.concern-responsibility span')?.innerText,
            closure_comments: na(row.querySelector('.closure-comments-cell')?.innerText),
            sops: na(row.dataset.sop),
            risk: na(row.dataset.risk),
            total_hrs: na(row.dataset.totalHrs),
            assigned_to: na(row.dataset.assignedTo),
            tracking_status: na(row.querySelector('.progress-tracker')?.innerText),
            follow_up_history: followUpHistory,
            breakdown_history: breakdownHistory
        };

        const addedRow = worksheet.addRow(rowData);
        addedRow.height = 90;
        addedRow.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };


        // BEFORE IMAGE
        const beforeImgEl = row.querySelector('.image-cell img.report-image-thumb');
        const beforeImgBase64 = beforeImgEl ? await imageUrlToBase64(beforeImgEl.src) : null;

        if (beforeImgBase64) {
            const imgId = workbook.addImage({ base64: beforeImgBase64, extension: 'jpeg' });
            worksheet.addImage(imgId, { tl: { col: 7, row: index + 1 }, ext: { width: 150, height: 150 } });
        }

        // AFTER IMAGE
        const allImgs = row.querySelectorAll('.image-cell img.report-image-thumb');
        const afterImgEl = allImgs.length > 1 ? allImgs[1] : null;
        const afterImgBase64 = afterImgEl ? await imageUrlToBase64(afterImgEl.src) : null;

        if (afterImgBase64 && afterImgBase64 !== beforeImgBase64) {
            const imgId = workbook.addImage({ base64: afterImgBase64, extension: 'jpeg' });
            worksheet.addImage(imgId, { tl: { col: 9, row: index + 1 }, ext: { width: 150, height: 150 } });
        }

        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Processing ${index + 1}/${rowsToProcess.length}...`;
    }


    btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Generating file...`;

    const buffer = await workbook.xlsx.writeBuffer();
    const link = document.createElement("a");
    link.href = URL.createObjectURL(new Blob([buffer]));
    link.download = `Report_${new Date().toISOString().slice(0, 10)}.xlsx`;
    link.click();

    hideLoader();
    window.location.href = 'https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list';
}




        // --- INITIALIZATION ---
        AlertManager.init();
        OfflineManager.init();
        IncidentTableManager.init();
        
        (() => { /* Placeholder for Complaint Form JS */ })();

    });
    


    </script>

<script>
        $(document).on('click', '#newReportBtn1', function (e) {
    e.preventDefault();

    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();
});
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
                            enlargeBtn.className = 'enlarge-preview-btn'; enlargeBtn.innerHTML = 'тЪ▓';
                            enlargeBtn.title = "Enlarge Image";
                            enlargeBtn.onclick = (e) => { e.stopPropagation(); openImagePreviewModal(fileURL); };
                            controls.appendChild(enlargeBtn);
                            const editBtn = document.createElement('button');
                            editBtn.className = 'edit-preview-btn'; editBtn.innerHTML = 'тЬО';
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
                        removeBtn.className = 'remove-preview-btn'; removeBtn.innerHTML = '├Ч';
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

    // --- Attach handler ---
    document.getElementById('submitBtn').addEventListener('click', handleSubmit);


        })();
    });
    




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
        
        
       const correctiveAction = $('#correctiveAction1').val();   // textarea value
    const closureIncidentId = $('#closureIncidentIds').val();
    const closureIncidentId1 = $('#closureIncidentIds1').val();
        
        
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('corrective_action', correctiveAction);
    formData.append('closure_incident_id', closureIncidentId);
    formData.append('type', closureIncidentId1);

        compressedFiles.forEach((file, idx) => {
            formData.append(`files[${idx}]`, file);
        });

        $.ajax({
            url: "{{ route('postafterimage') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
success: function(response) {
    if (response.status === 'success') {
        setTimeout(() => {
            location.reload();
        }, 1000); // wait 2 seconds before reload
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


    </script>
    
    <script>
document.addEventListener('DOMContentLoaded', () => {

    // Map FilterList → URL Param
    const filterParamMap = {
        statusFilterList: "status",
        regionFilterList: "region",
        unitFilterList: "unit",
        departmentFilterList: "department",
        sopFilterList: "sop",
        riskFilterList: "risk",
        responsibilityFilterList: "responsibility"
    };

    const params = new URLSearchParams(window.location.search);

    // -------------------------
    // CHECKBOX FILTER HANDLING
    // -------------------------
    Object.keys(filterParamMap).forEach(filterID => {

        const listContainer = document.getElementById(filterID);
        if (!listContainer) return;

        const urlParamName = filterParamMap[filterID];  // correct mapping
        const urlValue = params.get(urlParamName);

        if (!urlValue) return;

        const selectedValues = urlValue.split(",").map(v => v.trim());
        const checkboxes = listContainer.querySelectorAll("input[type='checkbox']");

        checkboxes.forEach(chk => {
            if (selectedValues.includes(chk.value)) {
                chk.checked = true;
            }
        });

        // Set in activeFilters also
        if (!StatusFilterManager.activeFilters[urlParamName]) {
            StatusFilterManager.activeFilters[urlParamName] = [];
        }

        StatusFilterManager.activeFilters[urlParamName] = selectedValues;
    });

    // -------------------------
    // DATE FILTER HANDLING
    // -------------------------
    const dateMappings = {
        reportingFrom: "reportingDateFrom",
        reportingTo: "reportingDateTo",
        closureFrom: "closureDateFrom",
        closureTo: "closureDateTo"
    };

    Object.keys(dateMappings).forEach(paramKey => {
        const inputID = dateMappings[paramKey];
        const urlValue = params.get(paramKey);

        if (urlValue) {
            const input = document.getElementById(inputID);
            if (input) input.value = urlValue;
        }
    });

    // -------------------------
    // REFRESH UI
    // -------------------------
    if (typeof StatusFilterManager.updateMainFilterIcon === "function") {
        StatusFilterManager.updateMainFilterIcon();
    }

    if (typeof IncidentTableManager.displayPage === "function") {
        IncidentTableManager.displayPage(1);
    }

});
document.getElementById("itemsPerPageSelect").addEventListener("change", function () {
    let val = this.value;

    let url = new URL(window.location.href);

    url.searchParams.set('limit', val);

    window.location.href = url.toString();
});
    </script>
@endsection




