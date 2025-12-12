@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #17a2b8;
            --light-gray: #ecf0f1;
            --dark-gray: #7f8c8d;
            --text-color: #2c3e50;
            --body-bg-color: #f5f7fa; /* Added for explicit use */
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        html { scroll-behavior: smooth; }
        body {
            background-color: var(--body-bg-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh; /* MODIFICATION: Ensure body covers viewport height */
        }

        .top-nav {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0 20px;
            position: relative;
            z-index: 1000;
        }
        
        .logo { padding: 15px 0; }
        .logo h2 { color: var(--primary-color); font-size: 1.4rem; margin:0; }
        .user-role-selector-container { padding: 10px 0; display: flex; align-items: center; gap: 10px; }
        .user-role-selector-container label { font-size: 0.9rem; font-weight: 500; color: var(--dark-gray); }
        #userRoleSelector {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 0.9rem;
            background-color: white;
            cursor: pointer;
            min-width: 250px;
        }
        #userRoleSelector:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        /* Style for Add New User button in top nav (no longer used here, but kept for potential reuse) */
        .top-nav .control-btn.add-user {
            margin-left: 15px; /* Spacing from role selector */
            padding: 8px 12px; /* Match role selector padding */
            font-size: 0.9rem; /* Match role selector font size */
        }


        .main-content {
            /* max-width: 1800px; */ /* MODIFICATION: Removed */
            /* margin: 20px auto; */   /* MODIFICATION: Removed */
            width: 100%;             /* MODIFICATION: Added for clarity, makes it full width */
            padding: 20px;           /* Kept for internal spacing */
            margin-top: 20px;        /* Kept */
            margin-bottom: 20px;     /* Kept */
        }
        .header { margin-bottom: 30px; border-bottom: 1px solid var(--light-gray); padding-bottom: 15px; min-height: 2rem; }
        .header h1 { color: var(--text-color); font-size: 1.8rem; }

        .compliance-cards-container { display: flex; flex-wrap: wrap; gap: 30px; margin-bottom: 30px; justify-content: flex-start; align-items: flex-start; }
        .training-card {
            background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #ccc; padding: 20px; width: 100%; transition: border-left-color 0.3s ease;
            display: flex; flex-direction: column; gap: 15px; flex: 1 1 400px; min-width: 350px;
        }
        .training-card.status-due-soon { border-left-color: #f59e0b; }
        .training-card.status-due-soon .status-badge { background-color: #fffbeb; color: #d97706; border: 1px solid #fcd34d; }
        .training-card.status-due-soon .progress-bar { background-color: #f59e0b; }
        .training-card.status-due-soon .btn-primary { background-color: #f59e0b; border-color: #f59e0b; color: #ffffff; }
        .training-card.status-due-soon .btn-primary:hover { background-color: #d97706; border-color: #d97706; }
        .training-card.status-due-soon .btn-secondary { background-color: #ffffff; border-color: #d1d5db; color: #374151; }
        .training-card.status-due-soon .btn-secondary:hover { background-color: #f3f4f6; }
        .training-card.status-due-soon .expired-info { display: none; }
        .training-card.status-due-soon .near-expiry-info { display: inline-flex; }
        .training-card.status-due-soon .expiring-soon-info { display: inline-flex; }
        .training-card.status-due-soon .unit-needs-attention-info { display: inline-flex; }

        .training-card.status-non-compliant { border-left-color: #ef4444; }
        .training-card.status-non-compliant .status-badge { background-color: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .training-card.status-non-compliant .progress-bar { background-color: var(--danger-color); }
        .training-card.status-non-compliant .btn-primary { background-color: #ef4444; border-color: #ef4444; color: #ffffff; }
        .training-card.status-non-compliant .btn-primary:hover { background-color: #dc2626; border-color: #dc2626; }
        .training-card.status-non-compliant .btn-secondary { background-color: #ffffff; border: 1px solid #d1d5db; color: #374151; }
        .training-card.status-non-compliant .btn-secondary:hover { background-color: #f3f4f6; }
        .training-card.status-non-compliant .expired-info { display: inline-flex; }
        .training-card.status-non-compliant .near-expiry-info { display: inline-flex; }
        .training-card.status-non-compliant .expiring-soon-info { display: inline-flex; }
        .training-card.status-non-compliant .unit-needs-attention-info { display: inline-flex; }

        .training-card.status-compliant { border-left-color: #10b981; }
        .training-card.status-compliant .status-badge { background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0; }
        .training-card.status-compliant .progress-bar { background-color: #10b981; }
        .training-card.status-compliant .btn-primary { background-color: #10b981; border-color: #10b981; color: #ffffff; }
        .training-card.status-compliant .btn-primary:hover { background-color: #059669; border-color: #059669; }
        .training-card.status-compliant .btn-secondary { background-color: #ffffff; border-color: #d1d5db; color: #374151; }
        .training-card.status-compliant .btn-secondary:hover { background-color: #f3f4f6; }
        .training-card.status-compliant .expired-info,
        .training-card.status-compliant .near-expiry-info,
        .training-card.status-compliant .expiring-soon-info,
        .training-card.status-compliant .unit-needs-attention-info { display: none; }

        .training-card .card-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; }
        .training-card .card-title { font-size: 1.3rem; font-weight: 600; color: #1f2937; margin: 0; display: flex; align-items: center; gap: 8px; }
        .training-card .icon-book, .training-card .icon-building { color: #6b7280; font-size: 1.1em; }
        .training-card .status-badge { font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 12px; white-space: nowrap; margin-top: 2px; }
        .training-card .progress-section { display: flex; align-items: center; gap: 10px; }
        .training-card .progress-bar-container { flex-grow: 1; background-color: #e5e7eb; border-radius: 5px; height: 8px; overflow: hidden; }
        .training-card .progress-bar { height: 100%; border-radius: 5px; transition: width 0.5s ease-in-out; }
        .training-card .progress-text { font-size: 0.875rem; color: #4b5563; white-space: nowrap; font-weight: 500; }
        .training-card .card-details { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 15px; font-size: 0.875rem; color: #4b5563; padding-top: 5px; }
        .training-card .detail-item { display: flex; align-items: center; gap: 6px; }
        .training-card .detail-item strong { color: #1f2937; font-weight: 600; }
        .training-card .detail-item i { color: #6b7280; font-size: 1.1em; }

        #fostac-valid-count-link, #fostac-expiring-count-link {
            cursor: pointer; text-decoration: none; color: inherit; border-bottom: 1px dashed var(--primary-color);
            transition: color 0.2s ease, border-bottom-color 0.2s ease; padding: 0 2px; margin: 0 -2px;
        }
        #fostac-valid-count-link:hover, #fostac-expiring-count-link:hover { color: var(--primary-color); border-bottom-color: transparent; }

        .training-card .card-extra-info { font-size: 0.875rem; margin-top: -5px; display: flex; flex-direction: column; gap: 5px; }
        .training-card .card-extra-info i { margin-right: 4px; }
        .training-card .expired-info, .training-card .near-expiry-info, .training-card .expiring-soon-info, .training-card .unit-needs-attention-info { display: none; align-items: center;}
        .expired-info { color: var(--danger-color); font-weight: 600; } .expired-info i { color: var(--danger-color); }
        .near-expiry-info { color: var(--danger-color); font-weight: 600; } .near-expiry-info i { color: var(--danger-color); }
        .expiring-soon-info { color: var(--warning-color); font-weight: 500; } .expiring-soon-info i { color: var(--warning-color); }
        .unit-needs-attention-info { color: var(--warning-color); font-weight: 500; align-items: center; }
        .unit-needs-attention-info i { color: var(--warning-color); }

        .training-card .card-actions { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
        .training-card .btn {
            padding: 8px 16px; border: 1px solid transparent; border-radius: 6px; font-size: 0.875rem; font-weight: 500;
            cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center;
            gap: 6px; line-height: 1.5;
        }
        .training-card .btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .training-card .btn i { font-size: 0.95em; width: 1.1em; text-align: center; }
        .training-card .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); color: #ffffff; }
        .training-card .btn-primary:hover { background-color: var(--secondary-color); border-color: var(--secondary-color); }
        .training-card .btn-secondary { background-color: #ffffff; border-color: #d1d5db; color: #374151; }
        .training-card .btn-secondary:hover { background-color: #f3f4f6; border-color: #adb5bd; }

        .employee-records-section { scroll-margin-top: 80px; }
        .table-container { overflow-x: auto; margin-bottom: 0px; }
        .reports-table { width: 100%; border-collapse: collapse; min-width: 1750px; }
        .reports-table th, .reports-table td { padding: 10px 12px; text-align: left; border-bottom: 1px solid var(--light-gray); font-size: 13px; vertical-align: middle; }
        .reports-table th { background-color: #f8f9fa; font-weight: 600; white-space: nowrap; position: sticky; top: 0; z-index: 10; color: var(--text-color); cursor: default; position: relative; }
        .reports-table tbody tr:hover { background-color: #f1f4f6; }
        .reports-table th:first-child, .reports-table td.sl-no { text-align: center; width: 50px; min-width: 50px; padding: 10px 5px; }
        .reports-table td[data-field="daysLeft"] { text-align: center; font-weight: 500; }
        .days-left-low { color: var(--warning-color); }
        .days-left-very-low { color: var(--danger-color); }
        select.employee-select { width: 100%; min-width: 150px; padding: 4px 8px; border-radius: 4px; border: 1px solid #ced4da; font-size: 12px; cursor: pointer; height: 28px; vertical-align: middle; appearance: auto; background-image: none; padding-right: 8px; }

        .status { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; display: inline-block; white-space: nowrap; text-align: center; line-height: 1.4; }
        .status.pending { background-color: #fff3cd; color: #856404; }
        .status.completed { background-color: #d4edda; color: #155724; }
        .status.expired { background-color: #f8d7da; color: #721c24; }
        .status.draft { background-color: #d1ecf1; color: #0c5460; }

        .action-buttons { display: flex; gap: 5px; flex-wrap: wrap; align-items: center;}
        .action-btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
        .action-btn:hover:not([disabled]) { opacity: 0.8; transform: translateY(-1px); }
        .action-btn[disabled] { opacity: 0.6; cursor: not-allowed; }
        .main-action-btn.update { background-color: var(--warning-color); color: white; }
        .main-action-btn.save-draft { background-color: var(--info-color); color: white; }
        .main-action-btn.final-submit { background-color: var(--success-color); color: white; }
        .history-btn { background-color: #6c757d; color: white; }
        .cancel-btn { background-color: #6c757d; color: white; } /* Task 3: This is the cancel button */
        .delete-btn { background-color: var(--danger-color); color: white; }
        .delete-btn:hover:not([disabled]) { background-color: #c82333; }
        .action-btn span { margin-left: 4px; }

        .deactivate-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
            margin-left: 5px;
        }
        .deactivate-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .deactivate-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: var(--danger-color);
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .deactivate-label {
            font-size: 11px;
            color: var(--dark-gray);
        }
        tr[data-deactivated="true"] {
            background-color: #f0f0f0 !important;
            opacity: 0.7;
        }

        .table-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .desktop-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            width: 100%;
        }
        .mobile-controls {
            display: none;
            width: 100%;
            gap: 10px;
            align-items: center;
            padding: 5px 0;
        }
        .mobile-search {
            flex-grow: 1;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .filter-mobile-btn, .refresh-mobile-btn {
            padding: 8px 12px !important;
            font-size: 14px !important;
        }
        .refresh-mobile-btn {
            background-color: var(--info-color) !important;
        }
        .refresh-mobile-btn:hover {
            background-color: #138496 !important;
        }
        .filter-mobile-btn {
            background-color: var(--primary-color) !important;
        }
        .filter-mobile-btn:hover {
            background-color: var(--secondary-color) !important;
        }

        .control-btn { background-color: var(--primary-color); color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 5px; }
        .control-btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .control-btn.add { background-color: var(--success-color); }
        .control-btn.add:hover { background-color: #218838; }
        .control-btn.add-user { background-color: #563d7c; }
        .control-btn.add-user:hover { background-color: #422e61;}
        .control-btn.refresh { background-color: var(--info-color); }
        .control-btn.refresh:hover { background-color: #138496; }
        .control-btn.export { background-color: #6c757d; }
        .control-btn.export:hover { background-color: #5a6268; }
        .control-btn.schedule { background-color: #fd7e14; }
        .control-btn.schedule:hover { background-color: #e66a00; }


        select.training-level-select, input.training-date-input, input.dob-input, input.doj-input, select.validity-select { padding: 4px 8px; border-radius: 4px; border: 1px solid #ced4da; font-size: 12px; cursor: pointer; max-width: 120px; height: 28px; vertical-align: middle; }
        input.training-date-input, input.dob-input, input.doj-input { width: 110px; }
        select.training-level-select, select.validity-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 16px 12px; padding-right: 1.8rem; }
        select:disabled, input:disabled { background-color: #e9ecef; cursor: not-allowed; opacity: 0.7; }
        td[data-field="trainingType"][contenteditable="true"],
        td[data-field="unitName"][contenteditable="true"] {
             background-color: white; outline: 1px solid var(--primary-color); padding: 9px 11px; border-radius: 3px;
        }

        .certificate-upload { display: inline-flex; align-items: center; position: relative; gap: 8px; }
        .certificate-upload input[type="file"] { position: absolute; left: 0; top: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer; }
        .certificate-upload input[type="file"]:disabled + .certificate-btn { cursor: not-allowed; opacity: 0.7; background-color: #e9ecef; }
        .certificate-upload input[type="file"]:disabled + .certificate-btn:hover { background-color: #e9ecef; }
        .certificate-btn { background-color: var(--light-gray); color: var(--text-color); padding: 5px 10px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; font-size: 12px; transition: background-color 0.3s, transform 0.2s; border: 1px solid #ced4da; height: 28px; }
        .certificate-btn:hover { background-color: #dee2e6; transform: translateY(-1px); }
        .certificate-btn i { margin-right: 5px; }
        .certificate-status { font-size: 12px; color: var(--dark-gray); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px; }
        .certificate-status.uploaded { color: var(--success-color); font-weight: 500; }

        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); z-index: 1040;
            display: flex; justify-content: center; align-items: center;
            opacity: 0; visibility: hidden; transition: opacity 0.3s ease-in-out, visibility 0s 0.3s linear;
        }
        .modal.show { opacity: 1; visibility: visible; transition: opacity 0.3s ease-in-out, visibility 0s 0s linear; }
        .modal-content {
            background-color: white; border-radius: 8px; width: 90%; max-width: 1200px; max-height: 85vh;
            display: flex; flex-direction: column; box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            transform: scale(0.95); transition: transform 0.3s ease-in-out;
        }
        .modal.show .modal-content { transform: scale(1); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 15px 25px; border-bottom: 1px solid var(--light-gray); flex-shrink: 0; }
        .modal-header h2 { color: var(--primary-color); font-size: 1.25rem; }
        .close-modal { background: none; border: none; font-size: 28px; font-weight: bold; cursor: pointer; color: var(--dark-gray); transition: color 0.2s; line-height: 1; }
        .close-modal:hover { color: var(--danger-color); }
        .modal-body { padding: 25px; overflow-y: auto; flex-grow: 1; }
        .modal-body .form-group label { /* Ensure labels in modals are styled if not already from general form styles */
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid var(--light-gray);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .modal-footer .btn { /* Generic button styling for modal footers if needed */
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }
        .modal-footer .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: 1px solid var(--primary-color);
        }
        .modal-footer .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .modal-footer .btn-secondary {
            background-color: var(--light-gray);
            color: var(--text-color);
            border: 1px solid #ccc;
        }
        .modal-footer .btn-secondary:hover {
            background-color: #e0e0e0;
        }


        .history-table, .parameter-history-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .history-table th, .history-table td, .parameter-history-table th, .parameter-history-table td { padding: 8px 10px; border: 1px solid #dee2e6; font-size: 12px; text-align: left; }
        .history-table th, .parameter-history-table th { background-color: #f8f9fa; font-weight: 600; }
        .parameter-history-table th, .parameter-history-table td { text-align: center; white-space: nowrap; }
        .parameter-history-table th { position: sticky; top: -1px; z-index: 10; background-color: #f8f9fa; }
        .parameter-history-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .parameter-history-table tbody tr:hover { background-color: #f1f1f1; }
        .history-header { font-weight: 600; background-color: #e9ecef; }
        .scrollable-table { overflow-x: auto; width: 100%; }

        .edit-mode { background-color: #fff9e6 !important; outline: 1px dashed var(--warning-color); outline-offset: -1px; }
        .edit-mode [contenteditable="true"] { background-color: white; outline: 1px solid var(--primary-color); padding: 9px 11px; border-radius: 3px; }
        tr.new-record-edit td[data-field="empId"] select.employee-select { outline: 2px solid var(--primary-color); background-color: #eef7ff; }

        th .filter-icon { margin-left: 5px; cursor: pointer; color: var(--dark-gray); transition: color 0.2s; font-size: 0.8em; vertical-align: middle; }
        th .filter-icon:hover { color: var(--primary-color); }
        th[data-filter-active="true"] .filter-icon { color: var(--primary-color); }
        .filter-dropdown { position: absolute; top: calc(100% + 5px); left: 0; background-color: white; border: 1px solid #ccc; border-radius: 4px; padding: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.15); z-index: 101; min-width: 200px; display: none; font-size: 12px; }
        .filter-dropdown.show { display: block; }
        .filter-dropdown input[type="text"] { width: 100%; padding: 6px 8px; margin-bottom: 8px; border: 1px solid #ddd; border-radius: 3px; font-size: 12px; }
        .filter-dropdown .filter-options { max-height: 150px; overflow-y: auto; margin-bottom: 8px; border: 1px solid #eee; padding: 5px; }
        .filter-dropdown label { cursor: pointer; white-space: nowrap; display: flex; align-items: center; gap: 5px; border-radius: 3px; }
        .filter-dropdown .standard-filter-content label { padding: 5px 3px; }
        .filter-dropdown label:hover { background-color: #f5f5f5; }
        .filter-dropdown input[type="checkbox"] { cursor: pointer; margin: 0; }
        .filter-buttons { display: flex; justify-content: space-between; margin-top: 8px; padding-top: 8px; border-top: 1px solid #eee; }
        .filter-dropdown button { padding: 4px 10px; border: none; border-radius: 3px; cursor: pointer; font-size: 12px; transition: background-color 0.2s, transform 0.2s; }
        .filter-dropdown button:hover { transform: translateY(-1px); }
        .filter-dropdown .filter-apply-btn { background-color: var(--primary-color); color: white; }
        .filter-dropdown .filter-apply-btn:hover { background-color: var(--secondary-color); }
        .filter-dropdown .filter-clear-btn { background-color: var(--light-gray); color: var(--text-color); }
        .filter-dropdown .filter-clear-btn:hover { background-color: #e0e0e0; }

        .filter-dropdown .custom-filter-content label { display: block; margin-bottom: 3px; font-size: 11px; font-weight: 500; color: var(--text-color); }
        .filter-dropdown .custom-filter-content select, .filter-dropdown .custom-filter-content input[type="date"] { width: 100%; padding: 5px 8px; border: 1px solid #ccc; border-radius: 3px; font-size: 12px; background-color: white; margin-bottom: 8px; appearance: auto; background-image: none; padding-right: 8px; }
        .filter-dropdown .custom-filter-content select:disabled { background-color: #e9ecef; cursor: not-allowed; opacity: 0.7; }

        .pagination-container { display: flex; justify-content: space-between; align-items: center; padding: 15px 5px; border-top: 1px solid var(--light-gray); margin-top: 10px; font-size: 12px; flex-wrap: wrap; gap: 10px; }
        .rows-per-page-selector label { margin-right: 5px; color: var(--dark-gray); }
        .rows-per-page-selector select { padding: 3px 6px; border-radius: 4px; border: 1px solid #ccc; font-size: 12px; }
        .pagination-controls { display: flex; align-items: center; flex-wrap: nowrap; gap: 5px; }
        .pagination-controls button:not(.page-number-btn) { background-color: var(--primary-color); color: white; }
        .pagination-controls button:disabled { background-color: var(--light-gray); color: var(--dark-gray); cursor: not-allowed; opacity: 0.6; }
        .page-number-btn {
            padding: 5px 10px; margin: 0; border: 1px solid var(--light-gray); background-color: white; color: var(--primary-color);
            cursor: pointer; border-radius: 4px; font-size: 12px; transition: all 0.2s; display: inline-flex;
            align-items: center; justify-content: center; min-width: 30px; height: 28px; line-height: 1;
        }
        .page-number-btn:hover { background-color: var(--light-gray); transform: translateY(-1px); }
        .page-number-btn.active { background-color: var(--primary-color); color: white; border-color: var(--primary-color); font-weight: bold; transform: none; }
        #pageInfo { color: var(--dark-gray); margin-left: 15px;}
        #pageNumbers { display: inline-flex; gap: 5px; align-items: center; }
        #pageNumbers span { color: var(--dark-gray); }

        /* --- Mobile Card View Styles --- */
        .mobile-card-view {
            display: none;
            padding: 10px 0;
        }
        .mobile-data-card {
            background-color: #ffffff;
            border: 1px solid var(--light-gray);
            border-left: 5px solid var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            padding: 15px;
            font-size: 14px;
        }
        .mobile-data-card.status-completed-card { border-left-color: var(--success-color); }
        .mobile-data-card.status-expired-card { border-left-color: var(--danger-color); }
        .mobile-data-card.status-draft-card { border-left-color: var(--info-color); }
        .mobile-data-card.status-pending-card { border-left-color: var(--warning-color); }
        .mobile-data-card[data-deactivated="true"] {
            border-left-color: var(--dark-gray) !important;
            background-color: #f0f0f0;
            opacity: 0.8;
        }
        .mobile-data-card[data-deactivated="true"] .status-mobile {
            background-color: var(--dark-gray) !important;
            color: white !important;
        }
        .card-header-mobile {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid var(--light-gray);
            padding-bottom: 10px;
            margin-bottom: 10px;
            gap: 10px;
        }
        .unit-info-mobile {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-width: 0;
        }
        .unit-name-mobile {
            font-weight: 600;
            font-size: 1.15em;
            color: var(--text-color);
            word-break: break-word;
        }
        .corp-region-mobile {
            font-size: 0.85em;
            color: var(--dark-gray);
            word-break: break-word;
        }
        .status-mobile {
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            white-space: nowrap;
            text-align: center;
            line-height: 1.4;
            flex-shrink: 0;
        }
        .status-mobile.completed { background-color: #d4edda; color: #155724; }
        .status-mobile.expired { background-color: #f8d7da; color: #721c24; }
        .status-mobile.draft { background-color: #d1ecf1; color: #0c5460; }
        .status-mobile.pending { background-color: #fff3cd; color: #856404; }

        .card-body-mobile {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 10px;
            margin-bottom: 15px;
        }
        .info-col-mobile {
            display: flex;
            flex-direction: column;
        }
        .info-col-mobile .label {
            font-size: 0.8em;
            color: var(--dark-gray);
            margin-bottom: 3px;
        }
        .info-col-mobile .value {
            font-weight: 500;
            color: var(--text-color);
            word-break: break-word;
        }
        .info-col-mobile .value.days-left-low { color: var(--warning-color); }
        .info-col-mobile .value.days-left-very-low { color: var(--danger-color); }
        .card-footer-mobile {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--light-gray);
        }
        .certificate-actions-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .certificate-info-mobile {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .certificate-info-mobile .pdf-icon-mobile {
            font-size: 2em;
            color: #e53935;
        }
        .certificate-info-mobile .certificate-status-mobile {
            font-size: 0.85em;
            color: var(--dark-gray);
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .certificate-info-mobile .certificate-status-mobile.uploaded {
            color: var(--success-color);
            font-weight: 500;
        }
        .certificate-upload-mobile {
            position: relative;
        }
        .certificate-upload-mobile input[type="file"] {
            position: absolute; left: 0; top: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer;
        }
        .certificate-btn-mobile {
            padding: 4px 8px; font-size: 0.8em; background-color: var(--light-gray); color: var(--text-color);
            border: 1px solid #ccc; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
        }
        .certificate-btn-mobile:hover { background-color: #dee2e6; }

        .actions-mobile { display: none; }

        .deactivate-container-mobile {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed var(--light-gray);
            font-size: 0.9em;
        }
        .mobile-data-card.edit-mode-card {
            outline: 2px dashed var(--warning-color);
            background-color: #fff9e6 !important;
        }
        .mobile-data-card.edit-mode-card .value { }
        .mobile-data-card.edit-mode-card .info-col-mobile input[type="text"],
        .mobile-data-card.edit-mode-card .info-col-mobile input[type="date"],
        .mobile-data-card.edit-mode-card .info-col-mobile select {
            background-color: white;
            border: 1px solid var(--primary-color);
            padding: 5px 8px;
            font-size: 1em;
            width: 100%;
            border-radius: 3px;
            margin-top: 2px;
            box-sizing: border-box;
        }
        .mobile-data-card.edit-mode-card .info-col-mobile select {
            appearance: auto;
            background-image: none;
            padding-right: 8px;
        }
        .mobile-data-card.edit-mode-card .certificate-btn-mobile {
            opacity: 1;
        }
        .mobile-data-card.edit-mode-card .certificate-upload-mobile input[type="file"]:disabled + .certificate-btn-mobile {
            cursor: not-allowed; opacity: 0.7; background-color: #e9ecef;
        }

        /* --- Generic 2x2 Details Grid for Mobile --- */
        .details-grid-2x2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 15px;
            margin-bottom: 15px;
        }

        /* MODIFICATION: Removed .main-content { max-width: 95%; } from this media query block */
        @media (max-width: 1800px) { /* .main-content { max-width: 95%; } */ .reports-table { min-width: 1600px; } }
        @media (max-width: 1300px) { .reports-table { min-width: 1400px; } }
        @media (max-width: 900px) {
             .compliance-cards-container { flex-direction: column; align-items: stretch; }
             .training-card { max-width: none; flex-basis: auto; }
             .top-nav .control-btn.add-user { /* Adjust for smaller screens if needed - this rule is now less relevant as the button moved */
                margin-left: 0;
                margin-top: 5px; /* Stack below role selector */
                width: 100%;
             }
             .user-role-selector-container { /* Make space for button below */
                flex-wrap: wrap;
                width: 100%; /* Ensure it takes full width to allow button stacking */
                justify-content: space-between; /* Align items properly when wrapped */
             }
             #userRoleSelector {
                flex-grow: 1; /* Allow selector to take available space */
             }
        }
        @media (max-width: 768px) {
            .nav-container { flex-direction: column; align-items: flex-start; padding-bottom: 10px; }
            .logo h2 { font-size: 1.2rem; }
            .user-role-selector-container { width: 100%; justify-content: flex-start; padding-top: 5px;}
            #userRoleSelector { flex-grow: 1; }
            .header h1 { font-size: 1.5rem; }
            .reports-table th, .reports-table td { padding: 8px 10px; font-size: 12px;}
            .action-buttons { flex-wrap: wrap; }
            .modal-content { width: 95%; max-height: 90vh;}
            .modal-header h2 { font-size: 1.1rem; }
            .pagination-container { flex-direction: column; align-items: center; gap: 15px;}
            .rows-per-page-selector { order: 1; }
            .pagination-controls { order: 2; justify-content: center; width: 100%; }
            #pageInfo { order: 3; margin-left: 0; text-align: center; width: 100%;}

            .table-container { display: none; }
            .mobile-card-view { display: block; }

            .desktop-controls { display: none; }
            .mobile-controls { display: flex; }
            .reports-table th .filter-icon { display: none; }
            .deactivate-container-mobile { display: none !important; }

            .table-controls {
                position: -webkit-sticky;
                position: sticky;
                top: 0;
                background-color: var(--body-bg-color);
                z-index: 990;
                padding-top: 10px;
                padding-bottom: 10px;
                margin-bottom: 0;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .employee-records-section {
                scroll-margin-top: 60px;
            }
        }
        @media (max-width: 576px) {
            .action-btn { padding: 4px 8px; font-size: 11px; }
            .control-btn { font-size: 13px; padding: 7px 12px; }
            .training-card { min-width: 0; }
        }
         @media (max-width: 480px) {
            .mobile-data-card { padding: 12px; font-size: 13px; }
            .card-header-mobile { flex-direction: column; align-items: stretch; gap: 5px;}
            .status-mobile { width: fit-content; align-self: flex-start; margin-top: 5px;}
            .card-body-mobile {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .details-grid-2x2 {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .certificate-actions-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
             .top-nav .control-btn.add-user { /* Full width button on very small screens - this rule is now less relevant */
                font-size: 0.85rem;
             }
        }
        @media (max-width: 400px) {
             .training-card .card-actions { flex-direction: column; align-items: stretch; }
             .training-card { padding: 15px; }
             .training-card .progress-text, .training-card .detail-item, .training-card .card-extra-info, .training-card .btn { font-size: 0.85em; }
             .training-card .card-title { font-size: 1.15em; }
             .pagination-controls { flex-wrap: wrap; justify-content: center; }
             #pageNumbers { flex-wrap: wrap; justify-content: center; }

            /* Styles for mobile controls on very small screens */
            #mobileFilterBtn .btn-text {
                display: none; /* Hide text "Filters" */
            }
            #mobileFilterBtn {
                padding-left: 10px !important;  /* Adjust padding for icon-only */
                padding-right: 10px !important;
                min-width: auto; /* Allow button to shrink */
            }
        }

        /* Add User Modal Styles */
        .add-user-modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
            padding: 20px;
            box-sizing: border-box;
        }
        .add-user-modal-container.show {
            display: flex;
        }
        .add-user-modal-content {
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            width: 850px;
            max-width: 95%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.3s ease-out;
            overflow: hidden;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .add-user-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 25px;
            border-bottom: 1px solid #eee;
            background-color: var(--primary-color);
            color: white;
        }
        .add-user-modal-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .add-user-close-button {
            font-size: 24px;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0 5px;
            transition: var(--transition);
        }
        .add-user-close-button:hover {
            color: white;
            transform: scale(1.1);
        }
        .add-user-modal-body {
            padding: 25px;
            overflow-y: auto;
            flex-grow: 1;
        }
        #addUserForm { display: flex; flex-direction: column; gap: 20px; }
        .form-section {
            background-color: #f9fafb;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .form-section h3 {
            margin-top: 0; margin-bottom: 20px; color: var(--primary-color); font-size: 16px;
            font-weight: 600; display: flex; align-items: center;
        }
        .form-section h3 svg { margin-right: 10px; color: var(--secondary-color); }
        .form-row { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 15px; }
        .form-group { flex: 1 1 calc(50% - 10px); min-width: 250px; }
        .form-group.full-width { flex: 1 1 100%; }
        /* label { display: block; margin-bottom: 8px; font-size: 13px; color: #555; font-weight: 500; } */ /* Already in modal-body */
        input[type="text"], input[type="email"], input[type="tel"], select {
            width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: var(--border-radius);
            font-size: 14px; box-sizing: border-box; background-color: white; color: #333; transition: var(--transition);
        }
        #addUserForm input:focus, #addUserForm select:focus,
        #scheduleTrainingForm select:focus, #scheduleTrainingForm input:focus { /* Added for schedule form */
            outline: none; border-color: var(--secondary-color); box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        #addUserForm select {
            height: 40px; appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2212%22%20height%3D%226%22%20viewBox%3D%220%200%2012%206%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M0%200L6%206L12%200H0Z%22%20fill%3D%22%23888888%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat; background-position: right 12px center; background-size: 12px 6px; padding-right: 35px;
        }
        #addUserForm select:disabled { background-color: #f5f5f5; cursor: not-allowed; }
        .filter-group-modal { margin-bottom: 15px; position: relative; }
        .filter-group-modal::after {
            content: ''; position: absolute; bottom: -8px; left: 0; right: 0; height: 1px; background-color: #eee;
        }
        .filter-group-modal:last-child::after { display: none; }
        .date-input-container { position: relative; display: flex; width: 100%; }
        .date-input-container input[type="text"] { padding-right: 35px; }
        .calendar-icon {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none;
        }
        .form-actions {
            display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px;
            padding-top: 20px; border-top: 1px solid #eee;
        }
        .form-actions .btn {
            padding: 10px 20px; border: none; border-radius: var(--border-radius);
            font-size: 14px; font-weight: 500; cursor: pointer; transition: var(--transition);
            display: inline-flex; align-items: center; justify-content: center;
        }
        .form-actions .btn svg { margin-right: 8px; }
        .form-actions .btn-primary { background-color: var(--secondary-color); color: white; }
        .form-actions .btn-primary:hover { background-color: #2980b9; }
        .form-actions .btn-secondary { background-color: #f5f5f5; color: #555; }
        .form-actions .btn-secondary:hover { background-color: #e0e0e0; }
        @media (max-width: 768px) {
            .add-user-modal-content .form-group { flex: 1 1 100%; }
            .add-user-modal-content .form-actions { flex-direction: column; }
            .add-user-modal-content .form-actions .btn { width: 100%; }
            #scheduleTrainingModal .modal-content { /* Ensure schedule modal is also responsive */
                max-width: 90%;
            }
            #scheduleEmployeeSelect {
                min-height: 120px; /* Adjust height for smaller screens */
            }
        }
        .filter-group-modal { animation: slideIn 0.3s ease-out forwards; opacity: 0; transform: translateY(10px); }
        @keyframes slideIn { to { opacity: 1; transform: translateY(0); } }

        /* Mobile Filter Modal Specific Styles */
        #mobile-filter-options-container .filter-group {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        #mobile-filter-options-container .filter-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        #mobile-filter-options-container .filter-group h4 {
            font-size: 1rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        #mobile-filter-options-container .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9em;
            font-weight: 500;
        }
        #mobile-filter-options-container .filter-group input[type="date"],
        #mobile-filter-options-container .filter-group select,
        #mobile-filter-options-container .filter-group input[type="text"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        #mobile-filter-options-container .filter-options-list {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 4px;
        }
        #mobile-filter-options-container .filter-options-list label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: normal;
            font-size: 0.9em;
            padding: 5px 0;
            cursor: pointer;
        }
        #mobile-filter-options-container .filter-options-list label:hover {
            background-color: #f5f5f5;
        }
        #mobile-filter-options-container .filter-options-list input[type="checkbox"] {
            margin-right: 5px;
        }

        /* Schedule Training Modal Specific Styles */
        #scheduleTrainingModal .modal-body label {
            margin-bottom: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-color);
        }
        #scheduleEmployeeSelect {
            width: 100%;
            min-height: 150px; /* Good default height for multiple select */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        #scheduleEmployeeSelect option {
            padding: 5px;
        }
        #scheduleTrainingDate { /* Inherits .training-date-input but can be overridden */
            width: 100%;
            padding: 10px 12px;
            box-sizing: border-box;
            height: auto; /* Override fixed height from .training-date-input */
            font-size: 0.9rem;
        }




        .modal-overlay {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        /*.modal {*/
        /*    background-color: #fff;*/
        /*    border-radius: 8px;*/
        /*    box-shadow: 0 4px 12px rgba(0,0,0,0.15);*/
        /*    width: 600px;*/
        /*    max-width: 100%;*/
        /*    overflow: hidden;*/
        /*}*/

        .modal-header {
            background-color: #347ab6;
            color: #fff;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.4em;
            font-weight: 500;
        }

        .modal-header .close-button {
            background: none;
            border: none;
            font-size: 1.8em;
            color: #fff;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            opacity: 0.8;
        }
        .modal-header .close-button:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 20px;
            max-height: calc(85vh - 120px);
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group > label:not(.employee-item label) {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95em;
        }

        /* Employee Search Input */
        #employee-search {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 0.9em;
        }
        #employee-search:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }


        .employee-list-container {
            border: 1px solid #ced4da;
            border-radius: 4px;
            max-height: 130px; /* Slightly reduced to accommodate search */
            overflow-y: auto;
            padding: 5px 10px;
            background-color: #fff;
        }

        .employee-list-container .employee-item {
            padding: 6px 0;
            display: flex; /* Important for visibility toggle */
            align-items: center;
            font-size: 0.9em;
            transition: background-color 0.15s ease; /* Smooth hover */
        }
        .employee-list-container input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(0.9);
        }
        .employee-list-container .employee-item label {
            font-weight: normal;
            margin-bottom: 0;
            cursor: pointer;
            color: #333;
            flex-grow: 1; /* Allow label to take available space */
        }
        .employee-list-container .employee-item:hover {
            background-color: #f0f8ff;
        }

        #selected-employees-display-container {
            margin-top: 15px;
        }
        #selected-employees-display-container > label {
            font-weight: 600;
            color: #333;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        .selected-summary-box {
            border: 1px solid #e0e0e0;
            padding: 8px 12px;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 0.85em;
            min-height: 1.5em;
            line-height: 1.4;
            color: #555;
            word-break: break-word;
        }


        .date-time-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .date-time-group input[type="date"],
        .date-time-group input[type="time"] {
            padding: 8px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 0.9em;
            box-sizing: border-box;
            background-color: #fff;
            flex: 1;
        }

        .modal-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 8px 18px;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .btn-cancel {
            background-color: #e9ecef;
            border-color: #ced4da;
            color: #333;
        }
        .btn-cancel:hover {
            background-color: #d3d9df;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        
        .cursor {
    color: #0d6efd;
    text-align: center;
    margin-top: 7px;
    cursor: pointer;
}

.text-muted {
    color: #6c757d !important;
    font-weight: 700;
}


button.action-btn.main-action-btn.save-draft {
    display: none !important;
}

    </style>
    <!-- Bootstrap 5 CSS -->



@section('content')
 


<!-- Modal -->
<div class="modal fade" id="trainingModal" tabindex="-1" aria-labelledby="trainingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Schedule Training</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
      <form id="scheduleTrainingForm">
                <div class="form-group">
                    <label for="employee-select-list-label">Select Employees:</label>
                    
                    <input type="search" id="employee-search" placeholder="Search employees...">

                    <div id="employee-select-list" class="employee-list-container" role="group" aria-labelledby="employee-select-list-label">
                        <?php foreach ($unit_users_list as $user): ?>
                        <div class="employee-item">
                            <input type="checkbox" id="emp-016" name="employees" value="<?= $user->id ?>">
                            <label for="emp-016"><?= $user->employer_fullname ?> (<?= $user->employe_id ?>)</label>
                        </div>
                        <?php endforeach; ?>
                        
                    </div>

                    
                </div>

                <div class="form-group">
                    <label for="from-date">Training From:</label>
                    <div class="date-time-group">
                        <input type="date" id="from-date" name="fromDate" required>
                        <input type="time" id="from-time" name="fromTime" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="to-date">Training To:</label>
                    <div class="date-time-group">
                        <input type="date" id="to-date" name="toDate" required>
                        <input type="time" id="to-time" name="toTime" required>
                    </div>
                </div>
            </form>

      </div>
    </div>
  </div>
</div>


    <div class="main-content">
       

        <div class="compliance-cards-container">
             <div class="training-card" id="fostacTrainingCard1">
                 <div class="card-header">
                     <h3 class="card-title"><i class="fa-solid fa-book-open icon-book"></i> FOSTAC Training</h3>
                     <span class="status-badge" id="fostac-training-status-badge">DUE SOON</span>
                 </div>
                 <div class="progress-section">
                     <div class="progress-bar-container"><div class="progress-bar" id="fostac-training-progress-bar" style="width: 0%;"></div></div>
                     <span class="progress-text" id="fostac-training-progress-text">{{ $validCount }} / {{ $requiredsum }}</span>
                 </div>
                 <div class="card-details">
                     
                     
                     
                     
                     <div class="detail-item"><i class="fa-regular fa-calendar-check icon-calendar"></i><span>Next Due: <strong id="fostac-training-next-due">N/A</strong></span></div>
                     <div class="detail-item"><i class="fa-solid fa-users icon-users"></i><span>Valid Certificates : <a href="#" id="fostac-valid-count-link" title="Click to view valid (non-expiring) certificates"><strong id="fostac-training-valid-certs44">{{ $validCount }} / {{ $requiredsum }}
</strong></a> Employees</span></div>
                 </div>
                 <div class="card-extra-info">
                      
                     <span class="expiring-soon-info" id="fostac-training-expiring-soon"><i class="fa-solid fa-triangle-exclamation"></i> Expiring Soon (&lt;60d): <a href="#" id="fostac-expiring-count-link" title="Click to view expiring certificates"><span id="fostac-training-expiring-soon-count1">{{$totalExpired}}</span></a> certificates</span>
                 </div>
                 <div class="card-actions"><button class="btn btn-secondary" id="fostac-view-all-btn"><i class="fa-regular fa-eye"></i> View Certificates</button></div>
             </div>
             <div class="training-card status-compliant" id="fostacUnitCard">
                 <div class="card-header">
                     <h3 class="card-title"><i class="fa-solid fa-building-shield icon-building"></i> FoSTaC Unit Compliance</h3>
                     <span class="status-badge" id="unit-card-status-badge">COMPLIANT</span>
                 </div>
                 <div class="progress-section">
                     <div class="progress-bar-container"><div class="progress-bar" id="unit-card-progress-bar" style="width: 0%;"></div></div>
                     <span class="progress-text" id="unit-card-progress-text1">{{$totalCompliance}}% Compliant ({{$totalCompliance}}/{{ $uniqueLoginUsers }} Units)</span>
                 </div>
                 <div class="card-details">
                     
                   
                     <div class="detail-item"><i class="fa-regular fa-calendar-check icon-calendar"></i><span id="unit-card-next-expiry-parent"><strong id="unit-card-next-expiry">N/A</strong></span></div>
                     <div class="detail-item"><i class="fa-solid fa-check-circle icon-check"></i><span>Compliant Units: <strong id="unit-card-compliant-units11">{{$totalCompliance}}/{{ $uniqueLoginUsers }}</strong></span></div>
                 </div>
                 <div class="card-extra-info">
                      <span class="unit-needs-attention-info" id="unit-card-needs-attention" style="display: none;"><i class="fa-solid fa-triangle-exclamation"></i> Needs Attention: <span id="unit-card-needs-attention-count">0</span> units</span>
                 </div>
                 <div class="card-actions"><button class="btn btn-secondary" 0><a href="{{route('corporatefostac')}}"><i class="fa-regular fa-eye"></i> View Units/Areas</a></button></div>
             </div>
        </div>

        <div class="employee-records-section">
            <div class="table-controls">
                 <div class="desktop-controls">
                     
                 
                     
                     @if(Auth::user()->is_role==3)
                        
                        <button id="addNewEmployeeBtn" class="control-btn add"> <i class="fas fa-plus"></i> Add New Record </button>
                    <button id="addNewUserBtn" class="control-btn add-user"> <i class="fas fa-user-plus"></i> Add New User </button>
                    <button id="refreshTableBtn" class="control-btn refresh"> <i class="fas fa-sync-alt"></i> Refresh Table </button>
                    <button id="exportTableBtn" class="control-btn export"> <i class="fas fa-download"></i> Export Visible Data </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#trainingModal">
  <i class="fas fa-calendar-alt"></i> Schedule FoSTaC Training
</button>
                     @else
                    <button id="refreshTableBtn" class="control-btn refresh"> <i class="fas fa-sync-alt"></i> Refresh Table </button>
                    <button id="exportTableBtn" class="control-btn export"> <i class="fas fa-download"></i> Export Visible Data </button>
                    
                     @endif
                     
                    
                    
                    
                    

<span id="activeCardFilterInfo" style="margin-left: auto; font-size: 0.9em; color: var(--dark-gray); font-style: italic;"></span>
                </div>
                <div class="mobile-controls">
                    <button id="mobileFilterBtn" class="control-btn filter-mobile-btn"> <i class="fas fa-filter"></i> <span class="btn-text">Filters</span> </button>
                    <input type="text" id="mobileSearchInput" placeholder="Search records..." class="mobile-search">
                    <button id="mobileRefreshBtn" class="control-btn refresh-mobile-btn"> <i class="fas fa-sync-alt"></i> </button>
                </div>
            </div>
            <div class="table-container">
                <table class="reports-table" id="currentTrainingsTable">
                     <thead>
                        <tr>
                            <th>Sl No</th>
                            <th data-column-id="unitName">Unit Name <i class="fas fa-filter filter-icon" data-column="1"></i></th>
                            <th data-column-id="empId">Emp ID <i class="fas fa-filter filter-icon" data-column="2"></i></th>
                            <th data-column-id="name">Name <i class="fas fa-filter filter-icon" data-column="3"></i></th>
                            <th data-column-id="department">Dept <i class="fas fa-filter filter-icon" data-column="4"></i></th>
                            <th data-column-id="designation">Design. <i class="fas fa-filter filter-icon" data-column="5"></i></th>
                            <th data-column-id="foodHandlerCategory">Food Handler <i class="fas fa-filter filter-icon" data-column="6"></i></th>
                            <th data-column-id="staffCategory">Staff Category <i class="fas fa-filter filter-icon" data-column="7"></i></th>
                            <th data-column-id="dob">DOB <i class="fas fa-filter filter-icon" data-column="8"></i></th>
                            <th data-column-id="doj">DOJ <i class="fas fa-filter filter-icon" data-column="9"></i></th>
                            <th data-column-id="trainingLevel">Training Level <i class="fas fa-filter filter-icon" data-column="10"></i></th>
                            <th data-column-id="trainingType">Training Type <i class="fas fa-filter filter-icon" data-column="11"></i></th>
                            <th data-column-id="trainingDate">Training Date <i class="fas fa-filter filter-icon" data-column="12"></i></th>
                            <th data-column-id="certificateValidity">Cert. Validity <i class="fas fa-filter filter-icon" data-column="13"></i></th>
                            <th>Days Left</th>
                            <th data-column-id="certificate">Certificate <i class="fas fa-filter filter-icon" data-column="15"></i></th>
                            <th data-column-id="status">Status <i class="fas fa-filter filter-icon" data-column="16"></i></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="current-trainings-body">
                        <tr><td colspan="18" style="text-align: center; padding: 20px; color: var(--dark-gray);">Loading training data...</td></tr>
                    </tbody>
                </table>
                 <div class="filter-dropdown" id="filterDropdownTemplate" style="display: none;">
                     <div class="standard-filter-content">
                        <input type="text" placeholder="Search options..." class="filter-search">
                        <div class="filter-options"></div>
                     </div>
                     <div class="custom-filter-content"></div>
                     <div class="filter-buttons">
                         <button class="filter-apply-btn">Apply</button>
                         <button class="filter-clear-btn">Clear</button>
                     </div>
                 </div>
            </div>
            <div id="mobile-cards-container" class="mobile-card-view"></div>

             <div class="pagination-container">
                <div class="rows-per-page-selector">
                    <label for="rowsPerPageSelect">Rows per page:</label>
                    <select id="rowsPerPageSelect"><option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select>
                </div>
                 <div class="pagination-controls">
                     <button id="prevPageBtn" class="action-btn" disabled><i class="fas fa-chevron-left"></i></button>
                     <div id="pageNumbers"></div>
                     <button id="nextPageBtn" class="action-btn" disabled><i class="fas fa-chevron-right"></i></button>
                 </div>
                  <span id="pageInfo"></span>
             </div>
        </div>
    </div>

     <div class="modal" id="historyModal">
        <!-- Modal content remains the same -->
        <div class="modal-content">
            <div class="modal-header">
                <h2>Training History for <span id="history-emp-name"></span> (ID: <span id="history-emp-id"></span>)</h2>
                <button class="close-modal" onclick="closeModal('historyModal')" aria-label="Close history modal">×</button>
            </div>
            <div class="modal-body" id="history-content">
                <div style="margin-bottom: 15px; font-size: 14px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                    <strong>Current Status:</strong> <span id="history-current-status" class="status">N/A</span>
                </div>
                <h3 style="margin-top: 20px; margin-bottom: 10px; font-size: 1rem;">Training Record History</h3>
                <div class="scrollable-table">
                     <table class="parameter-history-table">
                         <thead>
                             <tr>
                                 <th>Updated On</th>
                                 <th>Training Level</th>
                                 <th>Training Type</th>
                                 <th>Training Date</th>
                                 <th>Cert. Validity</th>
                                 <th>Cert.</th>
                                 <th>Overall Status</th>
                                 <th>Updated By</th>
                             </tr>
                         </thead>
                         <tbody id="training-history-details">
                             <tr><td colspan="8" style="text-align: center; padding: 20px; color: var(--dark-gray);">Training history unavailable.</td></tr>
                         </tbody>
                     </table>
                 </div>
                <h3 style="margin-top: 25px; margin-bottom: 10px; font-size: 1rem;">Change Log</h3>
                <div class="table-container">
                    <table class="history-table">
                        <thead> <tr> <th>Date</th> <th>Action</th> <th>Changed By</th> <th>Details</th> </tr> </thead>
                        <tbody id="change-history-details"> <tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--dark-gray);">No changes recorded.</td></tr> </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>

    <div class="add-user-modal-container" id="addUserModalContainer">
        <div class="add-user-modal-content">
            <div class="add-user-modal-header">
                <h2>Add New User</h2>
                <button class="add-user-close-button" aria-label="Close">×</button>
            </div>
            <div class="add-user-modal-body">
                <form id="addUserForm">
                    <div class="form-section">
                        <h3>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            Organization Information
                        </h3>
                        <div id="corporateFilter" class="filter-group-modal" style="animation-delay: 0.1s">
                            
                        </div>
                        <div id="regionalFilter" class="filter-group-modal" style="display: none; animation-delay: 0.2s">
                            <label for="regional">Regional</label>
                            <select id="regional" name="regional" required></select>
                        </div>
                        <div id="unitFilter" class="filter-group-modal" style="display: none; animation-delay: 0.3s">
                            <label for="unit">Unit</label>
                            <select id="unit" name="unit" required></select>
                        </div>
                        <div id="departmentFilter" class="filter-group-modal" style="display: none; animation-delay: 0.4s">
                            <label for="department">Department</label>
                            <select id="department" name="department" required></select>
                        </div>
                        <div id="locationFilter" class="filter-group-modal" style="display: none; animation-delay: 0.5s">
                            <label for="location">Location</label>
                            <select id="location" name="location" required></select>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Personal Information
                        </h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="employeeId">Employee ID</label>
                                <input type="text" id="employeeId" name="employeeId" required>
                            </div>
                            <div class="form-group">
                                <label for="employeeFullName">Full Name</label>
                                <input type="text" id="employeeFullName" name="employeeFullName" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="emailId">Email Address</label>
                                <input type="email" id="emailId" name="emailId" required>
                            </div>
                            <div class="form-group">
                                <label for="contactNumber">Contact Number</label>
                                <input type="tel" id="contactNumber" name="contactNumber" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="selectGender">Gender</label>
                                <select id="selectGender" name="selectGender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not-to-say">Prefer not to say</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <input type="text" id="designation" name="designation" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="doj">Date of Joining</label>
                                <div class="date-input-container">
                                    <input type="text" id="doj" name="doj" placeholder="DD-MM-YYYY" required>
                                    <svg class="calendar-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <div class="date-input-container">
                                    <input type="text" id="dob" name="dob" placeholder="DD-MM-YYYY" required>
                                    <svg class="calendar-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 13.255A23.931 23.931 0 0 0 12 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2m4 6h.01M5 20h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"></path>
                            </svg>
                            Employment Details
                        </h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="staffCategory">Staff Category</label>
                                <select id="staffCategory" name="staffCategory" required>
                                    <option value="">Select Staff Category</option>
                                    <option value="permanent">Permanent</option>
                                    <option value="contract">Contract</option>
                                    <option value="temporary">Temporary</option>
                                    <option value="intern">Intern</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="selectFoodHandlersCategory">Food Handlers Category</label>
                                <select id="selectFoodHandlersCategory" name="selectFoodHandlersCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="High Risk">High Risk</option>
                                    <option value="Medium Risk">Medium Risk</option>
                                    <option value="Low Risk">Low Risk</option>
                                    <option value="No Risk">No Risk</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary add-user-cancel-button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Filter Modal -->
    <div class="modal" id="mobileFilterModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Filter Records</h2>
                <button class="close-modal" data-modal-id="mobileFilterModal" aria-label="Close filter modal">×</button>
            </div>
            <div class="modal-body" id="mobile-filter-options-container">
                <p>Loading filter options...</p>
            </div>
            <div class="modal-footer">
                <button id="mobileClearAllTableFiltersBtn" class="btn btn-secondary">Clear All Filters</button>
                <button class="btn btn-primary" onclick="closeModal('mobileFilterModal')">Apply & Close</button>
            </div>
        </div>
    </div>

    <!-- Schedule FoSTaC Training Modal -->
    <div class="modal" id="scheduleTrainingModal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h2>Schedule FoSTaC Training</h2>
                <button class="close-modal" data-modal-id="scheduleTrainingModal" aria-label="Close schedule training modal">×</button>
            </div>
            <div class="modal-body">
                <form id="scheduleTrainingForm">
                    <div class="form-group full-width">
                        <label for="scheduleEmployeeSelect">Select Employees (Ctrl/Cmd + Click for multiple):</label>
                        <select id="scheduleEmployeeSelect" name="scheduleEmployeeSelect" multiple required>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="form-group full-width" style="margin-top: 15px;">
                        <label for="scheduleTrainingDate">Scheduled Training Date:</label>
                        <input type="date" id="scheduleTrainingDate" name="scheduleTrainingDate" class="training-date-input" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('scheduleTrainingModal')">Cancel</button>
                <button type="button" id="confirmScheduleBtn" class="btn btn-primary">Schedule Training</button>
            </div>
        </div>
    </div>



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
    <div id="ingredients-block"></div>
                    <!--end row-->  
                    
         <!-- Bootstrap Modal -->

           

@endsection


@section('footerscript')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

 <script>
        // --- Global Variables ---
        let currentUserRole = 'unit';
        let currentUserEntity = null;
        let currentUserName = 'Super Admin';
        const DEACTIVATE_REASON_PLACEHOLDER = "Deactivated";

        // State for mobile-specific filters
        let mobileFilterState = {
            searchText: { empId: '', name: '' }, // empId will be set by dropdown, name can be part of display
            cascadingOrg: { corporate: '', regional: '', unit: '' }
        };
        let mobileEmployeeSelectElement; // To hold the reference to the employee select in mobile filter modal


        const employeeMasterList = {
            <?php foreach ($unit_users_list as $user): ?>
            '<?= $user->employe_id ?>': { name: '<?= $user->employer_fullname ?>', department: '<?= $user->department_name ?>', designation: '<?= $user->designation ?>', foodHandlerCategory: '<?= $user->cat_name ?>', staffCategory: '<?= $user->staff_category ?>', dob: '<?= $user->dob ?>', doj: '<?= $user->dog ?>' },
            <?php endforeach; ?>

        };

        let trainingData = {
            <?php foreach ($documentsList as $user): ?>
            @php 
                $unitDetails = DB::table('users')->where('id',$user->created_by ?? '')->first();
        $unitDetails2 = DB::table('users')->where('id',$unitDetails->created_by1 ?? '')->first();
        $unitDetails3 = DB::table('users')->where('id',$unitDetails->created_by ?? '')->first();
        @endphp
        
            '<?= $user->employe_id ?>': { unitName: '<?= Auth::user()->company_name ?>',
            corporate: '{{$unitDetails3->company_name ?? ''}}',
             unitName1: '{{$unitDetails->company_name ?? ''}}',
            regional: '{{$unitDetails2->company_name ?? ''}}', empId: '<?= $user->employe_id ?>', name: '<?= $user->employer_fullname ?>', department: '<?= $user->department_name ?>', designation: '<?= $user->designation ?>', foodHandlerCategory: '<?= $user->cat_name ?>', staffCategory: '<?= $user->staff_category ?>', dob: '<?= $user->dob ?>', doj: '<?= $user->dog ?>', trainingLevel: '<?= $user->trainingLevel ?>', trainingType: '<?= $user->trainingType ?>', trainingDate: '<?= $user->trainingDate ?>', certificateValidity: '<?= $user->certificateValidity ?>', status: 'completed', certificate: 'https://efsm.safefoodmitra.com/admin/public/documents/<?= $user->image ?>', history: [], isDeactivated: false, deactivationReason: '', deactivationDate: null, nextScheduledDate: null },
            <?php endforeach; ?>

        };

        let originalRowData = {};

        const unitHierarchy = {
            "Apex Corp": {
                "Northern Region": ["<?= Auth::user()->company_name ?>", "Unit Beta", "Warehouse North"],
                "Southern Region": ["Unit Gamma", "Factory South"]
            },
            "Beta Solutions": {
                "Eastern Division": ["Unit Delta", "Office East"],
                "Western Division": ["Unit Epsilon", "Logistics West"]
            },
            "Global Services": {
                "Headquarters": ["Admin Central", "IT Hub"],
                "Shared Operations": ["Central Labs", "Support Center"]
            }
        };

        let currentPage = 1;
        let rowsPerPage = 10;
        let currentTableFilter = 'default';
        const expiringSoonThreshold = 60;
        const nearExpiryThreshold = 30;

        const FOSTAC_LEVELS = ['Awareness', 'Basic', 'Advanced', 'Supervisor', 'Trainer', 'Assessor'];
        const FOSTAC_TYPES = ['General', 'Catering', 'Manufacturing', 'Retail & Distribution', 'Storage & Transport', 'Milk & Milk Products', 'Meat & Poultry', 'Fish & Seafood', 'Bakery', 'Edible Oil & Fat', 'Water', 'Health Supplements', 'FSMS'];
        const FOSTAC_VALIDITY = ['1 Year', '2 Years'];

        // --- User Context and Data Visibility ---
        function setUserContext(role, entity, name) {
            currentUserRole = role;
            currentUserEntity = entity;
            currentUserName = name;
            console.log(`User context set to: Role=${role}, Entity=${entity}, Name=${name}`);

            document.title = `${currentUserName} - FoSTaC Tracker`;
            const mainHeaderH1 = document.getElementById('mainHeaderText');
            if (mainHeaderH1) {
                let headerText = "Employee FoSTaC Training Records";
                if (currentUserRole === 'corporate' && currentUserEntity) headerText = `${currentUserEntity} - ${headerText}`;
                else if (currentUserRole === 'regional' && currentUserEntity) headerText = `${currentUserEntity} - ${headerText}`;
                else if (currentUserRole === 'unit' && currentUserEntity) headerText = `${currentUserEntity} - ${headerText}`;
                else if (currentUserRole === 'superadmin') headerText = `Super Admin View - ${headerText}`;
                mainHeaderH1.textContent = headerText;
            }
        }

        function getAccessibleUnits() {
            const accessible = new Set();
            if (currentUserRole === 'superadmin') {
                Object.values(unitHierarchy).forEach(corps => {
                    Object.values(corps).forEach(regions => {
                        regions.forEach(unit => accessible.add(unit));
                    });
                });
            } else if (currentUserRole === 'corporate') {
                if (currentUserEntity && unitHierarchy[currentUserEntity]) {
                    Object.values(unitHierarchy[currentUserEntity]).forEach(unitsInRegionArray => {
                        unitsInRegionArray.forEach(unit => accessible.add(unit));
                    });
                }
            } else if (currentUserRole === 'regional') {
                for (const corpName in unitHierarchy) {
                    if (unitHierarchy[corpName][currentUserEntity]) {
                        unitHierarchy[corpName][currentUserEntity].forEach(unit => accessible.add(unit));
                        break;
                    }
                }
            } else if (currentUserRole === 'unit') {
                if (currentUserEntity) {
                    accessible.add(currentUserEntity);
                }
            }
            return Array.from(accessible);
        }

        function getVisibleTrainingData() {
            const accessibleUnits = getAccessibleUnits();
            const visibleData = {};
            for (const empId in trainingData) {
                if (trainingData[empId] && accessibleUnits.includes(trainingData[empId].unitName)) {
                    visibleData[empId] = trainingData[empId];
                }
            }
            return visibleData;
        }

        // --- Status Calculation (Includes Days Left) ---
        function calculateOverallStatus(employeeTrainingData, isFinalizing = false) {
            if (!employeeTrainingData) { return { status: 'pending', isExpired: false, calculatedExpiryDate: null, daysLeft: null }; }

            const today = new Date(); today.setHours(0, 0, 0, 0);
            let status = 'pending'; let isExpired = false; let calculatedExpiryDate = null; let daysLeft = null;
            const trainingDateStr = employeeTrainingData.trainingDate; const validity = employeeTrainingData.certificateValidity; let tempDaysLeft = null;
            if (trainingDateStr && validity) {
                try {
                    const trainingDate = new Date(trainingDateStr + 'T00:00:00');
                    if (!isNaN(trainingDate.getTime())) {
                        let expiryYear = trainingDate.getFullYear(); let expiryMonth = trainingDate.getMonth(); let expiryDay = trainingDate.getDate();
                        if (validity === '1 Year') expiryYear += 1; else if (validity === '2 Years') expiryYear += 2;
                        calculatedExpiryDate = new Date(expiryYear, expiryMonth, expiryDay);
                        let expiryCheckDate = new Date(calculatedExpiryDate); expiryCheckDate.setDate(expiryCheckDate.getDate() - 1); expiryCheckDate.setHours(23, 59, 59, 999);
                        if (today > expiryCheckDate) { isExpired = true; status = 'expired'; tempDaysLeft = -1 * Math.ceil(Math.abs(today.getTime() - expiryCheckDate.getTime()) / (1000 * 60 * 60 * 24)); }
                        else { const diffTime = expiryCheckDate.getTime() - today.getTime(); tempDaysLeft = Math.max(0, Math.ceil(diffTime / (1000 * 60 * 60 * 24))); status = 'completed'; }
                    } else { status = 'pending'; }
                } catch (e) { console.error("Error calculating expiry date:", e, "for data:", employeeTrainingData); status = 'pending'; }
            } else { status = 'pending'; }
            daysLeft = tempDaysLeft;
            if (isFinalizing && employeeTrainingData?.status === 'draft') { /* Use calculated status/daysLeft */ }
            else if (employeeTrainingData?.status === 'draft' && !isFinalizing) { status = 'draft'; daysLeft = null; calculatedExpiryDate = null; }
            else if (status === 'pending') { daysLeft = null; calculatedExpiryDate = null; }
            else if (status === 'expired') { daysLeft = tempDaysLeft !== null ? tempDaysLeft : null; }
            const finalExpiryDate = calculatedExpiryDate ? new Date(new Date(calculatedExpiryDate).setDate(calculatedExpiryDate.getDate() - 1)) : null;
            return { status, isExpired, calculatedExpiryDate: finalExpiryDate, daysLeft };
        }

        // --- Dashboard Card Update Function ---
        function updateDashboardCards() {
            const currentVisibleData = getVisibleTrainingData();
            const allEmployeeIds = Object.keys(currentVisibleData);
            const activeEmployeeIds = allEmployeeIds.filter(empId => !(currentVisibleData[empId].isDeactivated));
            const totalActiveRecords = activeEmployeeIds.length;

            let validCertCount_Overall = 0, expiredCertCount_Overall = 0, pendingDraftCertCount_Overall = 0, expiringSoonCertCount_Overall = 0, nearExpiryCertCount_Overall = 0;
            let earliestExpiryDateObj_Overall = null, earliestDaysLeft_Overall = Infinity;

            activeEmployeeIds.forEach(empId => {
                const emp = currentVisibleData[empId];
                const { status: calculatedStatus, daysLeft, calculatedExpiryDate } = calculateOverallStatus(emp, false);
                const effectiveStatus = emp.status === 'draft' ? 'draft' : (emp.status === 'pending' ? 'pending' : calculatedStatus);

                switch(effectiveStatus) {
                    case 'completed':
                        if (daysLeft !== null && daysLeft >= 0) {
                            if (daysLeft <= nearExpiryThreshold) { nearExpiryCertCount_Overall++; expiringSoonCertCount_Overall++; }
                            else if (daysLeft <= expiringSoonThreshold) { expiringSoonCertCount_Overall++; }
                            else { validCertCount_Overall++; }
                            if (calculatedExpiryDate) {
                                if (!earliestExpiryDateObj_Overall || calculatedExpiryDate < earliestExpiryDateObj_Overall) {
                                    earliestExpiryDateObj_Overall = calculatedExpiryDate;
                                    earliestDaysLeft_Overall = daysLeft;
                                } else if (earliestExpiryDateObj_Overall && calculatedExpiryDate.getTime() === earliestExpiryDateObj_Overall.getTime()) {
                                     earliestDaysLeft_Overall = Math.min(earliestDaysLeft_Overall, daysLeft);
                                }
                            }
                        } else { pendingDraftCertCount_Overall++;}
                        break;
                    case 'expired': expiredCertCount_Overall++; break;
                    case 'pending': case 'draft': pendingDraftCertCount_Overall++; break;
                }
            });

            const totalCompliance = {{ $totalCompliance }};
    const uniqueLoginUsers = {{ $uniqueLoginUsers }};

    const employeeCompliancePercentage = uniqueLoginUsers > 0 
        ? ((totalCompliance / uniqueLoginUsers) * 100).toFixed(2) 
        : 0;

$("#unit-card-progress-bar").css("width", employeeCompliancePercentage + "%");

const validCount = {{ $validCount }};
const requiredSum = {{ $requiredsum }};

const employeeCompliancePercentage1 = requiredSum > 0 
    ? ((validCount / requiredSum) * 100).toFixed(2) 
    : 0;
    
    
$("#fostac-training-progress-bar").css("width", employeeCompliancePercentage1 + "%");



const fostacTrainingCard12222 = document.getElementById('fostacTrainingCard12222');

// ✅ Add class based on compliance percentage
if (employeeCompliancePercentage1 >= 100) {
    fostacTrainingCard12222.classList.add('status-compliant111');
} else if (employeeCompliancePercentage1 >= 50) {
    fostacTrainingCard12222.classList.add('status-due-soon22');
} else {
    fostacTrainingCard12222.classList.add('status-non-compliant33');
}

// ✅ Select element by ID



            const earliestExpiryDateStr_Overall = earliestExpiryDateObj_Overall ? earliestExpiryDateObj_Overall.toISOString().split('T')[0] : (totalActiveRecords > 0 ? 'N/A' : '--');

            const fostacTrainingCard = document.getElementById('fostacTrainingCard');
            if (fostacTrainingCard) {
                const fostacStatusBadge = document.getElementById('fostac-training-status-badge');
                const fostacProgressBar = document.getElementById('fostac-training-progress-bar');
                const fostacProgressText = document.getElementById('fostac-training-progress-text');
                const fostacNextDue = document.getElementById('fostac-training-next-due');
                const fostacValidCertsText = document.getElementById('fostac-training-valid-certs');
                const fostacExpiredSpan = document.getElementById('fostac-training-expired');
                const fostacExpiredCount = document.getElementById('fostac-training-expired-count');
                const fostacNearExpirySpan = document.getElementById('fostac-training-near-expiry');
                const fostacNearExpiryCount = document.getElementById('fostac-training-near-expiry-count');
                const fostacExpiringSpan = document.getElementById('fostac-training-expiring-soon');
                const fostacExpiringCount = document.getElementById('fostac-training-expiring-soon-count');

                fostacTrainingCard.classList.remove('status-due-soon', 'status-non-compliant', 'status-compliant');
                let cardStatusText = 'COMPLIANT'; let cardStatusClass = 'status-compliant';
                 if (expiredCertCount_Overall > 0) { cardStatusText = 'ACTION REQUIRED'; cardStatusClass = 'status-non-compliant'; }
                 else if (nearExpiryCertCount_Overall > 0) { cardStatusText = 'DUE SOON'; cardStatusClass = 'status-due-soon'; }
                 else if (expiringSoonCertCount_Overall > 0) { cardStatusText = 'DUE SOON'; cardStatusClass = 'status-due-soon'; }
                 else if (pendingDraftCertCount_Overall > 0 && totalActiveRecords > 0) { cardStatusText = 'PENDING DATA'; cardStatusClass = 'status-due-soon'; }
                 else if (totalActiveRecords === 0 && Object.keys(currentVisibleData).length > 0) {
                    cardStatusText = 'ALL DEACTIVATED'; cardStatusClass = 'status-due-soon';
                 }
                 else if (totalActiveRecords === 0) {cardStatusText = 'NO ACTIVE DATA'; cardStatusClass = 'status-due-soon';}

                fostacTrainingCard.classList.add(cardStatusClass);
                if(fostacStatusBadge) fostacStatusBadge.textContent = cardStatusText;
                if(fostacProgressBar) fostacProgressBar.style.width = `${employeeCompliancePercentage.toFixed(1)}%`;
                if(fostacProgressText) fostacProgressText.textContent = `${Math.round(employeeCompliancePercentage)}% (${validCertCount_Overall + expiringSoonCertCount_Overall}/${totalActiveRecords})`;
                if(fostacNextDue) fostacNextDue.textContent = earliestExpiryDateStr_Overall;
                if(fostacValidCertsText) fostacValidCertsText.textContent = `${validCertCount_Overall}/${totalActiveRecords}`;
                if(fostacExpiredSpan && fostacExpiredCount) { fostacExpiredCount.textContent = expiredCertCount_Overall; fostacExpiredSpan.style.display = (expiredCertCount_Overall > 0) ? 'inline-flex' : 'none'; }
                if(fostacNearExpirySpan && fostacNearExpiryCount) { fostacNearExpiryCount.textContent = nearExpiryCertCount_Overall; fostacNearExpirySpan.style.display = (nearExpiryCertCount_Overall > 0) ? 'inline-flex' : 'none'; }
                if(fostacExpiringSpan && fostacExpiringCount) { fostacExpiringCount.textContent = expiringSoonCertCount_Overall; fostacExpiringSpan.style.display = (expiringSoonCertCount_Overall > 0) ? 'inline-flex' : 'none'; }
            }
            
            
    

            const unitDataAggregation = {};
            activeEmployeeIds.forEach(empId => {
                const emp = currentVisibleData[empId];
                if (emp && emp.unitName) {
                    if (!unitDataAggregation[emp.unitName]) {
                        unitDataAggregation[emp.unitName] = { totalEmployeesInUnit: 0, validCertificatesInUnit: 0 };
                    }
                    unitDataAggregation[emp.unitName].totalEmployeesInUnit++;
                    const { status: calculatedStatus, isExpired } = calculateOverallStatus(emp, false);
                    if (emp.status === 'completed' && calculatedStatus === 'completed' && !isExpired) {
                        unitDataAggregation[emp.unitName].validCertificatesInUnit++;
                    }
                }
            });

            let totalUnitsAssessed = 0;
            let compliantUnitCount = 0;
            let nonCompliantUnitNames = [];

            for (const unitName in unitDataAggregation) {
                totalUnitsAssessed++;
                const unitStats = unitDataAggregation[unitName];
                if (unitStats.totalEmployeesInUnit === 0 || unitStats.validCertificatesInUnit >= unitStats.totalEmployeesInUnit) {
                    compliantUnitCount++;
                } else {
                    nonCompliantUnitNames.push(unitName);
                }
            }

            const unitCompliancePercentage = totalUnitsAssessed > 0 ? (compliantUnitCount / totalUnitsAssessed) * 100 : (totalActiveRecords > 0 ? 0 : 100);

            const unitCard = document.getElementById('fostacUnitCard');
            if (unitCard) {
                const unitStatusBadge = document.getElementById('unit-card-status-badge');
            
                const unitProgressText = document.getElementById('unit-card-progress-text');
                const unitDetailItemParentSpan = document.getElementById('unit-card-next-expiry-parent');
                const unitCompliantUnitsEl = document.getElementById('unit-card-compliant-units');
                const unitNeedsAttentionSpan = document.getElementById('unit-card-needs-attention');
                const unitNeedsAttentionCountEl = document.getElementById('unit-card-needs-attention-count');

                unitCard.classList.remove('status-due-soon', 'status-non-compliant', 'status-compliant');
                let unitCardStatusText = 'COMPLIANT';
                let unitCardStatusClass = 'status-compliant';

                if (totalUnitsAssessed === 0 && totalActiveRecords > 0) { unitCardStatusText = 'NO ACTIVE UNITS'; unitCardStatusClass = 'status-due-soon'; }
                else if (totalUnitsAssessed === 0 && totalActiveRecords === 0) { unitCardStatusText = 'NO ACTIVE DATA'; unitCardStatusClass = 'status-due-soon'; }
                else if (nonCompliantUnitNames.length > 0) { unitCardStatusText = 'NON-COMPLIANT'; unitCardStatusClass = 'status-non-compliant';}

                unitCard.classList.add(unitCardStatusClass);
                if(unitStatusBadge) unitStatusBadge.textContent = unitCardStatusText;
                if(unitProgressBar) unitProgressBar.style.width = `${unitCompliancePercentage.toFixed(1)}%`;
                if(unitProgressText) unitProgressText.textContent = totalUnitsAssessed > 0 ? `${Math.round(unitCompliancePercentage)}% Compliant (${compliantUnitCount}/${totalUnitsAssessed} Units)` : (totalActiveRecords > 0 ? 'No Active Units' : 'No Active Data');

                if (unitDetailItemParentSpan) {
                    const iconElement = unitDetailItemParentSpan.querySelector('i');
                    unitDetailItemParentSpan.textContent = '';
                    if (iconElement) {
                            iconElement.className = "fa-solid " + (nonCompliantUnitNames.length > 0 ? "fa-triangle-exclamation" : (totalUnitsAssessed > 0 ? "fa-shield-alt" : "fa-question-circle"));
                            unitDetailItemParentSpan.appendChild(iconElement);
                            unitDetailItemParentSpan.appendChild(document.createTextNode(' '));
                    }
                    let detailTextNode;
                    if (totalUnitsAssessed === 0) detailTextNode = document.createTextNode('Unit Status: N/A');
                    else if (nonCompliantUnitNames.length > 0) {
                        detailTextNode = document.createTextNode(`Non-Compliant: ${nonCompliantUnitNames.length} Unit${nonCompliantUnitNames.length === 1 ? '' : 's'}`);
                        unitDetailItemParentSpan.title = `Non-compliant units: ${nonCompliantUnitNames.join(', ')}`;
                    } else {
                        detailTextNode = document.createTextNode('All Assessed Units Compliant');
                        unitDetailItemParentSpan.title = '';
                    }
                        unitDetailItemParentSpan.appendChild(detailTextNode);
                }

                if(unitCompliantUnitsEl) unitCompliantUnitsEl.textContent = `${compliantUnitCount}/${totalUnitsAssessed}`;
                if(unitNeedsAttentionCountEl) unitNeedsAttentionCountEl.textContent = nonCompliantUnitNames.length;
            }
        }

        // --- Helper to Clear All Column Filters ---
        function clearAllColumnFilters(thead = null) {
             if (!thead) thead = document.getElementById('currentTrainingsTable')?.querySelector('thead');
             if (!thead) return;
             thead.querySelectorAll('th[data-filter-active="true"]').forEach(th => {
                 th.dataset.filterActive = 'false'; th.dataset.filterType = ''; th.dataset.filterValue = '';
                 const filterIcon = th.querySelector('.filter-icon'); if (filterIcon) filterIcon.style.color = '';
                  const dropdown = th.querySelector('.filter-dropdown');
                  if (dropdown) {
                       const filterType = determineFilterType(th.cellIndex);
                        if (filterType === 'unit_column_filter') { dropdown.querySelectorAll('.filter-unit-select').forEach(sel => sel.selectedIndex = 0); }
                        else if (filterType === 'date') { dropdown.querySelectorAll('.filter-date-input').forEach(input => input.value = ''); }
                        else { dropdown.querySelectorAll('.filter-options input[type="checkbox"]').forEach(cb => cb.checked = false); const searchInput = dropdown.querySelector('.filter-search'); if (searchInput) searchInput.value = ''; filterDropdownOptions(dropdown, ''); }
                    }
             });
        }

        // --- Setup Card Click Listeners ---
        function setupCardClickListeners() {
            const validLink = document.getElementById('fostac-valid-count-link');
            const expiringLink = document.getElementById('fostac-expiring-count-link');
            const viewCertificateBtn = document.getElementById('fostac-view-all-btn');
            const cardFilterInfo = document.getElementById('activeCardFilterInfo');
            const recordsSection = document.querySelector('.employee-records-section');

            const applyCardFilter = (filterType, scrollToTable = false) => {
                 currentTableFilter = filterType;
                 clearAllColumnFilters();
                 applyAllFilters();

                 if (cardFilterInfo) {
                     if (filterType === 'validOnly') cardFilterInfo.textContent = 'Showing: Valid Certificates Only (>60 days left)';
                     else if (filterType === 'expiringSoon') cardFilterInfo.textContent = 'Showing: Expiring Soon Only (<60d)';
                     else cardFilterInfo.textContent = '';
                 }
                 if (scrollToTable && recordsSection) {
                    recordsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                 }
            };

            if (validLink) validLink.addEventListener('click', (e) => { e.preventDefault(); applyCardFilter('validOnly', true); });
            if (expiringLink) expiringLink.addEventListener('click', (e) => { e.preventDefault(); applyCardFilter('expiringSoon', true); });
            if (viewCertificateBtn) viewCertificateBtn.addEventListener('click', (e) => { e.preventDefault(); applyCardFilter('validOnly', true); });

            const unitViewBtn = document.getElementById('unit-card-view-btn');
            if (unitViewBtn) {
                 unitViewBtn.addEventListener('click', (e) => {
                     e.preventDefault();
                     alert("Unit Compliance View feature has been removed or is under maintenance.");
                 });
            }
        }

        // --- DOMContentLoaded ---
        document.addEventListener('DOMContentLoaded', () => {
            setupModalClosers();
            setupUserRoleSwitcher();
            setupRowsPerPageSelector();
            setupFilterIcons();
            setupFileInputs();
            setupControlButtons();
            setupCardClickListeners();
            setupPaginationEventListeners();
            setupAddUserModal();
            setupScheduleTrainingModal(); // New setup

            const currentTrainingsBody = document.getElementById('current-trainings-body');
            if(currentTrainingsBody) {
                currentTrainingsBody.addEventListener('change', handleEmployeeSelectionChange);
            }

            const roleSelector = document.getElementById('userRoleSelector');
            if (roleSelector) {
                if (roleSelector.options.length > 0) {
                    const event = new Event('change');
                    roleSelector.dispatchEvent(event);
                } else {
                    setUserContext('superadmin', null, 'Super Admin');
                    refreshTable();
                }
            } else {
                 setUserContext('superadmin', null, 'Super Admin');
                 refreshTable();
            }
             // For the general search input in mobile controls (distinct from modal search)
            const mobileMainSearchInput = document.getElementById('mobileSearchInput');
            if(mobileMainSearchInput) {
                mobileMainSearchInput.addEventListener('input', (event) => {
                    mobileFilterState.searchText.name = event.target.value; // General search targets name
                    mobileFilterState.searchText.empId = ''; // Clear specific empId if general search is used
                    if (mobileEmployeeSelectElement) mobileEmployeeSelectElement.value = ''; // Clear employee dropdown
                    applyAllFilters();
                });
            }
        });

        // --- User Role Switcher Setup ---
        function setupUserRoleSwitcher() {
            const selector = document.getElementById('userRoleSelector');
            if (!selector) return;
            selector.innerHTML = '';

            let option = new Option('Super Admin View', 'superadmin::Super Admin');
            option.dataset.role = 'superadmin'; option.dataset.entity = ''; option.dataset.name = 'Super Admin';
            selector.add(option);

            for (const corpName in unitHierarchy) {
                option = new Option(`Corporate: ${corpName} Admin`, `corporate:${corpName}:${corpName} Admin`);
                option.dataset.role = 'corporate'; option.dataset.entity = corpName; option.dataset.name = `${corpName} Admin`;
                selector.add(option);
                for (const regionName in unitHierarchy[corpName]) {
                    const regionDisplayName = `${regionName} (${corpName}) Admin`;
                    option = new Option(`Regional: ${regionDisplayName}`, `regional:${regionName}:${regionDisplayName}`);
                    option.dataset.role = 'regional'; option.dataset.entity = regionName; option.dataset.name = regionDisplayName;
                    selector.add(option);
                    unitHierarchy[corpName][regionName].forEach(unitName => {
                        const unitDisplayName = `${unitName} (${regionName}, ${corpName}) Admin`;
                        option = new Option(`Unit: ${unitDisplayName}`, `unit:${unitName}:${unitDisplayName}`);
                        option.dataset.role = 'unit'; option.dataset.entity = unitName; option.dataset.name = unitDisplayName;
                        selector.add(option);
                    });
                }
            }
            selector.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const role = selectedOption.dataset.role;
                const entity = selectedOption.dataset.entity || null;
                const name = selectedOption.dataset.name;

                setUserContext(role, entity, name);
                refreshTable();
            });
        }

        // --- Helper to get Unit Hierarchy Details ---
        function getUnitHierarchyDetails(unitName) {
            for (const corpName in unitHierarchy) {
                for (const regionName in unitHierarchy[corpName]) {
                    if (unitHierarchy[corpName][regionName].includes(unitName)) {
                        return { corporateEntity: corpName, region: regionName };
                    }
                }
            }
            return { corporateEntity: 'N/A', region: 'N/A' };
        }

        // --- Create Mobile Card Element ---
        function createMobileCard(empId, employeeTraining, isNew = false) {
            const card = document.createElement('div');
            card.className = 'mobile-data-card';
            card.setAttribute('data-emp-id', empId);

            const masterDetails = employeeMasterList[empId];
            const displayData = {
                empId: empId,
                name: employeeTraining?.name || masterDetails?.name || (isNew ? 'Select Employee' : 'N/A'),
                unitName: employeeTraining?.unitName || (isNew && currentUserRole === 'unit' && currentUserEntity ? currentUserEntity : ''),
                trainingLevel: employeeTraining?.trainingLevel || null,
                trainingType: employeeTraining?.trainingType || (isNew ? 'General' : null),
                trainingDate: employeeTraining?.trainingDate || null,
                certificateValidity: employeeTraining?.certificateValidity || (isNew ? '2 Years' : null),
                certificate: employeeTraining?.certificate || null,
                unit_id: employeeTraining?.unit_id || null,
                nextScheduledDate: employeeTraining?.nextScheduledDate || null,
                status: employeeTraining?.status || 'pending',
                isDeactivated: employeeTraining?.isDeactivated || false,
                deactivationReason: employeeTraining?.deactivationReason || '',
                deactivationDate: employeeTraining?.deactivationDate || null
            };

            const { corporateEntity, region } = getUnitHierarchyDetails(displayData.unitName);
            const { status: overallStatus, calculatedExpiryDate, daysLeft } = calculateOverallStatus(displayData, false);

            let cardStatusClassSuffix = overallStatus || 'pending';
            cardStatusClassSuffix = cardStatusClassSuffix === 'overdue' ? 'expired' : cardStatusClassSuffix;
            card.classList.add(`status-${cardStatusClassSuffix}-card`);


            if (displayData.isDeactivated) {
                card.setAttribute('data-deactivated', 'true');
            }

            let statusTextForCard = (overallStatus === 'overdue' ? 'Expired' : (overallStatus || 'pending')).charAt(0).toUpperCase() + (overallStatus || 'pending').slice(1);
            if (displayData.status === 'pending' && displayData.nextScheduledDate) {
                statusTextForCard += ` (Next Scheduled Date: ${displayData.nextScheduledDate})`;
            }
            if (displayData.isDeactivated) {
                statusTextForCard += ` (Deactivated`;
                if (displayData.deactivationDate) {
                    statusTextForCard += ` on ${displayData.deactivationDate}`;
                }
                statusTextForCard += `)`;
            }
            const statusClassForPill = overallStatus === 'overdue' ? 'expired' : (overallStatus || 'pending');

            const formattedExpiryDate = calculatedExpiryDate ? calculatedExpiryDate.toISOString().split('T')[0] : 'N/A';

            const certificateDisplayText = displayData.certificate ? displayData.certificate : 'Not uploaded';
            const certificateIsUploaded = !!displayData.certificate;

            let daysLeftClass = '';
            if (daysLeft !== null && daysLeft >= 0) {
                if (daysLeft <= nearExpiryThreshold) daysLeftClass = 'days-left-very-low';
                else if (daysLeft <= expiringSoonThreshold) daysLeftClass = 'days-left-low';
            }
            const daysLeftDisplay = daysLeft !== null ? daysLeft : '-';

            const initialStage = (isNew || displayData.status === 'draft') ? 'drafting' : 'view';
            card.setAttribute('data-edit-stage', initialStage);
            if (isNew) card.classList.add('new-mobile-card-edit');

            card.innerHTML = `
                <div class="card-header-mobile">
                    <div class="unit-info-mobile">
                        <span class="unit-name-mobile" data-field="unitName">${displayData.unitName || 'N/A'}</span>
                        <span class="corp-region-mobile">7787878</span>
                    </div>
                    <span class="status-mobile ${statusClassForPill}" data-field="statusPill">${statusTextForCard}</span>
                </div>
                <div class="card-body-mobile">
                    <div class="info-col-mobile">
                        <span class="label">Employee Name:</span>
                        <span class="value emp-name-mobile" data-field="name">${displayData.name}</span>
                    </div>
                    <div class="info-col-mobile">
                        <span class="label">E Code:</span>
                        <span class="value emp-id-mobile" data-field="empIdDisplay">${empId}</span>
                    </div>
                    <div class="info-col-mobile">
                        <span class="label">Certificate Valid till:</span>
                        <span class="value cert-valid-till-mobile" data-field="certExpiryDate">${formattedExpiryDate}</span>
                    </div>
                    <div class="info-col-mobile">
                        <span class="label">Days Left:</span>
                        <span class="value days-left-mobile ${daysLeftClass}" data-field="daysLeftDisplay">${daysLeftDisplay}</span>
                    </div>
                </div>
                <div class="card-footer-mobile">
                    <div class="certificate-actions-row">
                        <div class="certificate-info-mobile" data-field="certificateDisplay">
                            <i class="fas fa-file-pdf pdf-icon-mobile"></i>
                            <span class="certificate-status-mobile ${certificateIsUploaded ? 'uploaded' : ''}" title="${certificateDisplayText}">${certificateDisplayText}</span>
                        </div>
                        <div class="actions-mobile">
                            <!-- Buttons are here but the .actions-mobile div is hidden by CSS -->
                        </div>
                    </div>
                    <div class="deactivate-container-mobile" style="display: none;">
                        <!-- Content remains but container hidden by CSS -->
                    </div>
                </div>
            `;
            return card;
        }

        // --- Data Loading ---
        function loadInitialData() {
            const tableBody = document.getElementById('current-trainings-body');
            const mobileCardsContainer = document.getElementById('mobile-cards-container');

            if (!tableBody || !mobileCardsContainer) {
                console.error("Table body or mobile cards container not found!"); return;
            }
            tableBody.innerHTML = '';
            mobileCardsContainer.innerHTML = '';

            const currentVisibleData = getVisibleTrainingData();
            const dataEntries = Object.entries(currentVisibleData);

            if (dataEntries.length === 0) {
                const noDataMessage = `<tr><td colspan="18" style="text-align: center; padding: 20px; color: var(--dark-gray);">No training data found for your current view (${currentUserName}).</td></tr>`;
                tableBody.innerHTML = noDataMessage;
                mobileCardsContainer.innerHTML = `<div style="text-align: center; padding: 20px; color: var(--dark-gray);">No training data found for your current view (${currentUserName}).</div>`;
                const paginationContainer = document.querySelector('.pagination-container');
                if(paginationContainer) paginationContainer.style.setProperty('display', 'none');
                return;
            } else {
                const paginationContainer = document.querySelector('.pagination-container');
                if(paginationContainer) paginationContainer.style.removeProperty('display');
            }

            dataEntries.sort(([,a], [,b]) => (a?.name || '').localeCompare(b?.name || ''));

            for (const [empId, employeeTraining] of dataEntries) {
                const newRow = createTableRow(empId, employeeTraining);
                newRow.style.display = 'block';
                tableBody.appendChild(newRow);

                const newCard = createMobileCard(empId, employeeTraining);
                //newCard.style.display = 'none';
                mobileCardsContainer.appendChild(newCard);
            }
        }

       
        
        function createTableRow(empId, employeeTraining, isNew = false) {
    const row = document.createElement('tr');
    row.setAttribute('data-emp-id', empId);
    const masterDetails = employeeMasterList[empId] || {};

    let unitNameForNewRecord = '';
    if (isNew && currentUserRole === 'unit' && currentUserEntity) {
        unitNameForNewRecord = currentUserEntity;
    }

    const displayData = {
        empId: empId,
        name: employeeTraining?.name || masterDetails?.name || (isNew ? 'Select Employee' : 'N/A'),
        department: employeeTraining?.department || masterDetails?.department || '',
        designation: employeeTraining?.designation || masterDetails?.designation || '',
        foodHandlerCategory: employeeTraining?.foodHandlerCategory || masterDetails?.foodHandlerCategory || '',
        staffCategory: employeeTraining?.staffCategory || masterDetails?.staffCategory || '',
        dob: employeeTraining?.dob || masterDetails?.dob || '',
        doj: employeeTraining?.doj || masterDetails?.doj || '',
        unitName: employeeTraining?.unitName || '',
        corporate: employeeTraining?.corporate || '',
        regional: employeeTraining?.regional || '',
        unitName1: employeeTraining?.unitName1 || '',
        trainingLevel: employeeTraining?.trainingLevel || null,
        trainingType: employeeTraining?.trainingType || (isNew ? 'General' : null),
        trainingDate: employeeTraining?.trainingDate || null,
        certificateValidity: employeeTraining?.certificateValidity || (isNew ? '2 Years' : null),
        certificate: employeeTraining?.certificate || null,
        nextScheduledDate: employeeTraining?.nextScheduledDate || null,
        unit_id: employeeTraining?.unit_id || null,
        status: employeeTraining?.status || 'pending',
        isDeactivated: employeeTraining?.isDeactivated || false,
        deactivationReason: employeeTraining?.deactivationReason || '',
        deactivationDate: employeeTraining?.deactivationDate || null
    };

    const initialStage = (isNew || displayData.status === 'draft') ? 'drafting' : 'view';
    row.setAttribute('data-edit-stage', initialStage);
    if (isNew) {
        row.classList.add('new-record-edit');
    }

    if (displayData.isDeactivated) {
        row.setAttribute('data-deactivated', 'true');
    }

    const { status: overallStatus, daysLeft } = calculateOverallStatus(displayData, false);

    const createOptions = (optionsArray, selectedValue) => {
        let html = `<option value="" ${!selectedValue ? 'selected' : ''}>--</option>`;
        optionsArray.forEach(opt => html += `<option value="${opt}" ${selectedValue === opt ? 'selected' : ''}>${opt}</option>`);
        return html;
    };

    const createEmployeeOptions = (selectedEmpId) => {
        let html = `<option value="">-- Select Employee --</option>`;
        Object.keys(employeeMasterList)
            .sort((a, b) => employeeMasterList[a].name.localeCompare(employeeMasterList[b].name))
            .forEach(id => {
                const emp = employeeMasterList[id];
                html += `<option value="${id}" ${selectedEmpId === id ? 'selected' : ''}>${id} - ${emp.name}</option>`;
            });
        return html;
    };

    let daysLeftClass = '';
    if (daysLeft !== null && daysLeft >= 0) {
        if (daysLeft <= nearExpiryThreshold) daysLeftClass = 'days-left-very-low';
        else if (daysLeft <= expiringSoonThreshold) daysLeftClass = 'days-left-low';
    }

    const daysLeftDisplay = daysLeft !== null ? daysLeft : '-';
    const certificateDisplayText = displayData.certificate ? displayData.certificate : 'Not uploaded';
    const certificateIsUploaded = !!displayData.certificate;
    const fileInputId = `cert-${empId.replace(/[^a-zA-Z0-9_-]/g, '')}`;

    let statusTextToDisplay = (overallStatus === 'overdue' ? 'Expired' : (overallStatus || 'pending')).charAt(0).toUpperCase() + (overallStatus || 'pending').slice(1);
    if (displayData.status === 'pending' && displayData.nextScheduledDate) {
        statusTextToDisplay += ` (Next Scheduled Date: ${displayData.nextScheduledDate})`;
    }
    if (displayData.isDeactivated) {
        statusTextToDisplay += ` (Deactivated`;
        if (displayData.deactivationDate) {
            statusTextToDisplay += ` on ${displayData.deactivationDate}`;
        }
        statusTextToDisplay += `)`;
    }

    const statusClass = overallStatus === 'overdue' ? 'expired' : (overallStatus || 'pending');

    const unitNameCellContent = displayData.unitName || (isNew && currentUserRole !== 'unit' ? '' : 'N/A');
    const unitNameEditableAttr = 'false';

    row.innerHTML = `
        <td class="sl-no"></td>
        <td data-field="unitName" contenteditable="${unitNameEditableAttr}"><div>${displayData.unitName1}</div> <small class="text-muted">${displayData.corporate} &gt; ${displayData.regional}</small> </td>
        <td data-field="empId">${isNew ? `<select class="employee-select select2">${createEmployeeOptions(null)}</select>` : empId}</td>
        <td data-field="name">${displayData.name}</td>
        <td data-field="department">${displayData.department || 'N/A'}</td>
        <td data-field="designation">${displayData.designation || 'N/A'}</td>
        <td data-field="foodHandlerCategory">${displayData.foodHandlerCategory || 'N/A'}</td>
        <td data-field="staffCategory">${displayData.staffCategory || 'N/A'}</td>
        <td data-field="dob">${displayData.dob || '-'}</td>
        <td data-field="doj">${displayData.doj || '-'}</td>
        <td data-field="trainingLevel"><select class="training-level-select select2" disabled>${createOptions(FOSTAC_LEVELS, displayData.trainingLevel)}</select></td>
        <td data-field="trainingType" contenteditable="false">${displayData.trainingType || 'N/A'}</td>
        <td data-field="trainingDate"><input type="date" class="training-date-input" value="${displayData.trainingDate || ''}" disabled></td>
        <td data-field="certificateValidity"><select class="validity-select select2" disabled>${createOptions(FOSTAC_VALIDITY, displayData.certificateValidity)}</select></td>
        <td data-field="daysLeft" class="${daysLeftClass}">${daysLeftDisplay}</td>
        <td data-field="certificate">
            <div class="certificate-upload">
                <input type="file" id="${fileInputId}" class="certificate-input" data-emp="${empId}" accept=".pdf,.jpg,.png,.jpeg,.doc,.docx" disabled>
                <label for="${fileInputId}" class="certificate-btn"><i class="fas fa-upload"></i> Upload</label>
            </div>
            <span class="certificate-status ${certificateIsUploaded ? 'uploaded' : ''}" title="${certificateDisplayText}"></span>
            <div class="cursor" onclick="viewDocument('${certificateDisplayText}')"><i class="fas fa-file-pdf"></i></div>
        </td>
        <td data-field="status"><span class="status ${statusClass}">${statusTextToDisplay}</span></td>
        <td>
            <div class="action-buttons">
                <button class="action-btn main-action-btn update" onclick="startEditing(this)" style="display: ${initialStage === 'view' && !isNew ? 'inline-flex' : 'none'};"><i class="fas fa-pencil-alt"></i> <span>Update</span></button>
                <button class="action-btn main-action-btn save-draft" onclick="saveAsDraft(this)" style="display: none;"><i class="fas fa-save"></i> <span>Save as Draft</span></button>
                <button class="action-btn main-action-btn final-submit" onclick="finalSubmit(this)" style="display: none;"><i class="fas fa-check-circle"></i> <span>Final Submit</span></button>
                <button class="action-btn history-btn" onclick="showHistoryModal('${empId}')" style="display: ${initialStage === 'view' && !isNew ? 'inline-flex' : 'none'};"><i class="fas fa-history"></i> <span>History</span></button>
                <button class="action-btn delete-btn" onclick="handleDeleteRecord('${empId}')" style="display: ${initialStage === 'view' && !isNew ? 'inline-flex' : 'none'};"><i class="fas fa-trash-alt"></i> <span>Delete</span></button>
                <button class="action-btn cancel-btn" onclick="cancelMultiStageEdit(this)" style="display: ${initialStage === 'view' ? 'none' : 'inline-flex'};"><i class="fas fa-times"></i> <span>Cancel</span></button>
                <div class="deactivate-container" style="display: ${initialStage === 'view' && !isNew ? 'flex' : 'none'};">
                    <label class="deactivate-switch">
                        <input type="checkbox" class="deactivate-toggle" data-emp-id="${empId}" ${displayData.isDeactivated ? 'checked' : ''}>
                        <span class="slider"></span>
                    </label>
                    <span class="deactivate-label">${displayData.isDeactivated ? 'Deactivated' : 'Deactivate'}</span>
                </div>
            </div>
        </td>`;

    // Init select2 with dropdown parent set
    setTimeout(() => {
        $(row).find('select.select2').select2({
            width: '100%',
            dropdownParent: $(row)
        });
    }, 10);

    // Attach onchange event to employee dropdown
    const empSelect = row.querySelector('.employee-select');
    if (empSelect) {
        empSelect.addEventListener('change', function () {
            const selectedId = this.value;
            if (selectedId && employeeMasterList[selectedId]) {
                const emp = employeeMasterList[selectedId];
                row.setAttribute('data-emp-id', selectedId);
                row.querySelector('[data-field="name"]').innerText = emp.name;
                row.querySelector('[data-field="department"]').innerText = emp.department || 'N/A';
                row.querySelector('[data-field="designation"]').innerText = emp.designation || 'N/A';
                row.querySelector('[data-field="foodHandlerCategory"]').innerText = emp.foodHandlerCategory || 'N/A';
                row.querySelector('[data-field="staffCategory"]').innerText = emp.staffCategory || 'N/A';
                row.querySelector('[data-field="dob"]').innerText = emp.dob || '-';
                row.querySelector('[data-field="doj"]').innerText = emp.doj || '-';

                // Enable relevant fields
                row.querySelector('.training-level-select').disabled = false;
                row.querySelector('.training-date-input').disabled = false;
                row.querySelector('.validity-select').disabled = false;
                row.querySelector('.certificate-input').disabled = false;

                // Re-initialize select2 for now-enabled dropdowns
                $(row).find('.training-level-select, .validity-select').select2({
                    width: '100%',
                    dropdownParent: $(row)
                });
            }
        });
    }

    const deactivateToggle = row.querySelector('.deactivate-toggle');
    if (deactivateToggle) {
        deactivateToggle.addEventListener('change', handleDeactivateToggle);
    }

    if (initialStage === 'drafting') {
        updateButtonUI(row, 'drafting');
    }

    return row;
}


     
        
        function handleEmployeeSelectionChange(event) {
    const selectElement = event.target;
    if (!selectElement.classList.contains('employee-select')) return;

    const row = selectElement.closest('tr');
    const selectedEmpId = selectElement.value;

    if (!row || !row.classList.contains('new-record-edit')) return;

    if (selectedEmpId && trainingData[selectedEmpId] && getVisibleTrainingData()[selectedEmpId]) {
        const empDetails = employeeMasterList[selectedEmpId];
        alert(`User ${empDetails.name} (ID: ${selectedEmpId}) already has a training record in your current view. Scrolling to existing record.`);
        const existingRow = document.querySelector(`tr[data-emp-id="${selectedEmpId}"]:not(.new-record-edit)`);
        if (existingRow) {
            existingRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            existingRow.style.outline = '2px dashed var(--warning-color)';
            setTimeout(() => { if (existingRow) existingRow.style.outline = ''; }, 3000);
        }
        row.remove();
        applyAllFilters();
        return;
    }

    const fieldsToClear = ['name', 'department', 'designation', 'foodHandlerCategory', 'staffCategory', 'dob', 'doj', 'trainingType'];
    fieldsToClear.forEach(field => {
        const cell = row.querySelector(`td[data-field="${field}"]`);
        if (cell) cell.textContent = '';
    });

    row.querySelector('select.training-level-select').value = '';
    row.querySelector('input.training-date-input').value = '';
    row.querySelector('select.validity-select').value = '';

    const certStatus = row.querySelector('.certificate-status');
    if (certStatus) {
        certStatus.textContent = 'Not uploaded';
        certStatus.classList.remove('uploaded');
        certStatus.title = 'Not uploaded';
    }

    const unitNameCell = row.querySelector('td[data-field="unitName"]');

    if (selectedEmpId && employeeMasterList[selectedEmpId]) {
        const empDetails = employeeMasterList[selectedEmpId];
        row.setAttribute('data-emp-id', selectedEmpId);

        const fieldsToUpdate = {
            name: empDetails.name,
            department: empDetails.department,
            designation: empDetails.designation,
            foodHandlerCategory: empDetails.foodHandlerCategory,
            staffCategory: empDetails.staffCategory,
            dob: empDetails.dob || '-',
            doj: empDetails.doj || '-'
        };

        for (const field in fieldsToUpdate) {
            const cell = row.querySelector(`td[data-field="${field}"]`);
            if (cell) cell.textContent = fieldsToUpdate[field] || 'N/A';
        }

        if (unitNameCell) {
            unitNameCell.textContent = (currentUserRole === 'unit' && currentUserEntity) ? currentUserEntity : 'N/A';
        }

        row.querySelector('td[data-field="trainingType"]').textContent = 'General';
        row.querySelector('select.validity-select').value = '2 Years';

        // ✅ Enable all editable fields & buttons
        row.querySelector('.training-level-select').disabled = false;
        row.querySelector('.training-date-input').disabled = false;
        row.querySelector('.validity-select').disabled = false;
        row.querySelector('.certificate-input').disabled = false;
        row.querySelector('.save-draft').disabled = false;
        row.querySelector('.final-submit').disabled = false;

        // Optional: remove visually disabled style from upload label
        const label = row.querySelector(`label[for^="cert-"]`);
        if (label) label.classList.remove('disabled');

        makeRowEditable(row, true);
        updateButtonUI(row, 'drafting');
        row.dataset.editStage = 'drafting';

    } else {
        row.setAttribute('data-emp-id', 'NEW_RECORD_' + Date.now());
        if (unitNameCell) {
            unitNameCell.textContent = (currentUserRole === 'unit' && currentUserEntity) ? currentUserEntity : '';
        }

        makeRowEditable(row, false);
        updateButtonUI(row, 'drafting');
        row.dataset.editStage = 'drafting';
    }
}

$(document).on('select2:select', '.employee-select', handleEmployeeSelectionChange);

        // --- Modal Handling ---
        function showModal(modalId) { const modal = document.getElementById(modalId); if (modal) { modal.classList.add('show'); document.body.style.overflow = 'hidden'; } }
        function closeModal(modalId) { const modal = document.getElementById(modalId); if (modal) { modal.classList.remove('show'); document.body.style.overflow = ''; } }
        function setupModalClosers() {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', function(event) { if (event.target === this) { closeModal(this.id); } });
                modal.querySelectorAll('.close-modal, .add-user-close-button, .add-user-cancel-button').forEach(button => {
                    const targetModalId = button.dataset.modalId || modal.id; // Use data-modal-id if present
                    button.addEventListener('click', () => closeModal(targetModalId));
                });
            });
        }


        // --- Control Buttons & Export ---
        function setupControlButtons() {
            const addBtn = document.getElementById('addNewEmployeeBtn');
            const addUserBtn = document.getElementById('addNewUserBtn');
            const refreshBtn = document.getElementById('refreshTableBtn');
            const exportBtn = document.getElementById('exportTableBtn');
            const scheduleTrainingBtn = document.getElementById('scheduleTrainingBtn');

            const mobileFilterBtn = document.getElementById('mobileFilterBtn');
            const mobileRefreshBtn = document.getElementById('mobileRefreshBtn');


            if (addBtn) addBtn.addEventListener('click', addNewEmployeeRecord);
            if (addUserBtn) addUserBtn.addEventListener('click', openAddUserModal);
            if (refreshBtn) refreshBtn.addEventListener('click', refreshTable);
            if (exportBtn) exportBtn.addEventListener('click', exportTableToCSV);
            if (scheduleTrainingBtn) {
                scheduleTrainingBtn.addEventListener('click', openScheduleTrainingModal);
            }

            if (mobileFilterBtn) mobileFilterBtn.addEventListener('click', openMobileFilterModal);
            if (mobileRefreshBtn) mobileRefreshBtn.addEventListener('click', refreshTable);
        }

        function addNewEmployeeRecord() {
            const existingNewRow = document.querySelector('tr.new-record-edit');
            if (existingNewRow) { alert("Please complete or cancel the current new record first."); existingNewRow.scrollIntoView({ behavior: 'smooth', block: 'center' }); existingNewRow.querySelector('select.employee-select')?.focus(); return; }
            const tableBody = document.getElementById('current-trainings-body');
            const mobileCardsContainer = document.getElementById('mobile-cards-container');
            if (!tableBody || !mobileCardsContainer) return;

            let defaultUnitName = '';
            if (currentUserRole === 'unit' && currentUserEntity) {
                defaultUnitName = currentUserEntity;
            }
            const tempId = 'NEW_RECORD_' + Date.now();
            const newRow = createTableRow(tempId, { unitName: defaultUnitName }, true);
            const newCard = createMobileCard(tempId, { unitName: defaultUnitName }, true);

            const placeholderRow = tableBody.querySelector('td[colspan="18"]'); if (placeholderRow) placeholderRow.closest('tr').remove();
            tableBody.insertBefore(newRow, tableBody.firstChild);
            mobileCardsContainer.insertBefore(newCard, mobileCardsContainer.firstChild);

            makeRowEditable(newRow, false); // Initial setup for new row fields

            newRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
            newRow.querySelector('select.employee-select')?.focus();
            applyAllFilters();
        }

        function refreshTable() {
            console.log(`Refreshing table for ${currentUserName}`);
            const cardFilterInfo = document.getElementById('activeCardFilterInfo');
            closeAllFilterDropdowns();
            clearAllColumnFilters();
            currentTableFilter = 'default';
            if (cardFilterInfo) cardFilterInfo.textContent = '';
            const newRecordRow = document.querySelector('tr.new-record-edit'); if (newRecordRow) newRecordRow.remove();
            const newMobileCard = document.querySelector('.new-mobile-card-edit'); if (newMobileCard) newMobileCard.remove();


            loadInitialData();
            applyAllFilters();
            updateDashboardCards();
            console.log("Table refreshed for " + currentUserName + ".");


            const refreshBtnDesktop = document.getElementById('refreshTableBtn');
            const refreshBtnMobile = document.getElementById('mobileRefreshBtn');

            const showRefreshMessage = (btn) => {
                if (btn) {
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check"></i> Refreshed!';
                    btn.disabled = true;
                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    }, 2000);
                }
            };
            showRefreshMessage(refreshBtnDesktop);
            showRefreshMessage(refreshBtnMobile);
        }

        function escapeCSVValue(value) {
            const stringValue = value === null || value === undefined ? '' : String(value);
            if (stringValue.includes(',') || stringValue.includes('"') || stringValue.includes('\n') || stringValue.includes('\r')) {
                const escapedValue = stringValue.replace(/"/g, '""');
                return `"${escapedValue}"`;
            }
            return stringValue;
        }

        function exportTableToCSV() {
            const tableBody = document.getElementById('current-trainings-body');
            if (!tableBody) { alert("Error: Could not find data to export."); return; }

            const visibleRows = getVisibleItems(tableBody, 'tr');

            if (visibleRows.length === 0) { alert("No data available to export based on current filters."); return; }

            const csv = [];
            const headers = [];
            const headerCells = document.querySelectorAll('#currentTrainingsTable thead th');

            headerCells.forEach((th, index) => {
                if (index < headerCells.length - 1) {
                    let headerText = th.firstChild?.textContent?.trim() || th.textContent.trim();
                    headers.push(escapeCSVValue(headerText));
                }
            });
            csv.push(headers.join(','));

            visibleRows.forEach(row => {
                const rowData = [];
                const cells = row.querySelectorAll('td');
                cells.forEach((td, index) => {
                    if (index < cells.length - 1) {
                        let cellValue = '';
                        const field = td.dataset.field;

                        if (field === 'empId' && td.querySelector('select')) cellValue = td.querySelector('select').value || 'N/A';
                        else if (field === 'trainingLevel' && td.querySelector('select')) cellValue = td.querySelector('select').value || '';
                        else if (field === 'certificateValidity' && td.querySelector('select')) cellValue = td.querySelector('select').value || '';
                        else if (field === 'trainingDate' && td.querySelector('input[type="date"]')) cellValue = td.querySelector('input[type="date"]').value || '';
                        else if (field === 'certificate') cellValue = td.querySelector('.certificate-status')?.textContent.trim() || 'Not uploaded';
                        else if (field === 'status') cellValue = td.querySelector('.status')?.textContent.trim() || 'Pending';
                        else cellValue = td.textContent.trim();

                        rowData.push(escapeCSVValue(cellValue));
                    }
                });
                csv.push(rowData.join(','));
            });

            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");

            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                const today = new Date().toISOString().split('T')[0];
                link.setAttribute("href", url);
                link.setAttribute("download", `fostac_export_${currentUserName.replace(/\s+/g, '_')}_${today}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            } else {
                alert("CSV export is not supported in your browser.");
            }
        }

        // --- Edit Handling ---
        function startEditing(button) {
            const row = button.closest('tr');
            const empId = row.dataset.empId;
            if (!empId || empId.startsWith('NEW_RECORD_')) return;

            const currentlyEditingRow = document.querySelector('tr.edit-mode');
            if (currentlyEditingRow && currentlyEditingRow !== row) {
                alert("Please save or cancel the currently editing row first.");
                currentlyEditingRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            if (!trainingData[empId]) {
                const master = employeeMasterList[empId] || {};
                trainingData[empId] = {
                    empId: empId, name: master.name, department: master.department, designation: master.designation,
                    foodHandlerCategory: master.foodHandlerCategory, staffCategory: master.staffCategory,
                    dob: master.dob, doj: master.doj,
                    unitName: (currentUserRole === 'unit' ? currentUserEntity : 'N/A'),
                    trainingLevel: null, trainingType: 'General', trainingDate: null,
                    certificateValidity: '2 Years', certificate: null, status: 'pending',
                    history: [], isDeactivated: false, deactivationReason: '', deactivationDate: null, nextScheduledDate: null
                };
            }
            originalRowData[empId] = JSON.parse(JSON.stringify(trainingData[empId]));
            makeRowEditable(row, true);
            updateButtonUI(row, 'drafting');
            row.dataset.editStage = 'drafting';
        }

         
        function saveAsDraft(button) {
    const row = button.closest('tr');
    const empId = row.dataset.empId;

    if (empId.startsWith('NEW_RECORD_')) {
        alert("Please select an employee first.");
        return;
    }

    if (!employeeMasterList[empId]) {
        alert(`Error: Employee ${empId} not found in master list.`);
        return;
    }

    const collectedData = collectRowData(row);
    const empMasterDetails = employeeMasterList[empId];
    const isNewRecord = !originalRowData[empId];

    // Prepare form data
    const formData = new FormData();
    formData.append('empId', empId);
    formData.append('unitName', collectedData.unitName || 'N/A');
    formData.append('name', empMasterDetails.name);
    formData.append('department', empMasterDetails.department);
    formData.append('designation', empMasterDetails.designation);
    formData.append('foodHandlerCategory', empMasterDetails.foodHandlerCategory);
    formData.append('staffCategory', empMasterDetails.staffCategory);
    formData.append('dob', empMasterDetails.dob);
    formData.append('doj', empMasterDetails.doj);
    formData.append('trainingLevel', collectedData.trainingLevel);
    formData.append('trainingType', collectedData.trainingType || 'General');
    formData.append('trainingDate', collectedData.trainingDate);
    formData.append('certificateValidity', collectedData.certificateValidity || '2 Years');
    formData.append('status', 'draft');

    // Get the file
    const fileInput = row.querySelector('.certificate-input');
    if (fileInput && fileInput.files.length > 0) {
        formData.append('certificate', fileInput.files[0]);
    }

    // Submit via AJAX
    fetch('{{ route('saveDocuments') }}', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
})

    .then(response => response.json())
    .then(data => {
        alert('Draft saved successfully! Click "Final Submit" or "Cancel".');

        trainingData[empId] = {
            ...(trainingData[empId] || {}),
            empId: empId,
            unitName: collectedData.unitName || 'N/A',
            name: empMasterDetails.name,
            department: empMasterDetails.department,
            designation: empMasterDetails.designation,
            foodHandlerCategory: empMasterDetails.foodHandlerCategory,
            staffCategory: empMasterDetails.staffCategory,
            dob: empMasterDetails.dob,
            doj: empMasterDetails.doj,
            trainingLevel: collectedData.trainingLevel,
            trainingType: collectedData.trainingType || 'General',
            trainingDate: collectedData.trainingDate,
            certificateValidity: collectedData.certificateValidity || '2 Years',
            certificate: data.certificate || null,
            status: 'draft',
            history: trainingData[empId]?.history || []
        };

        if (!originalRowData[empId]) {
            originalRowData[empId] = { status: 'pending' };
        }

        row.classList.remove('new-record-edit');
        makeRowNonEditable(row, empId);
        updateButtonUI(row, 'finalizing');
        row.dataset.editStage = 'finalizing';

        updateDashboardCards();
        if (isNewRecord) applyAllFilters();
        else displayTablePage(currentPage);
        
        
    })
    .catch(error => {
        console.error('Save error:', error);
        alert('Error saving draft. Please try again.');
    });
}

        function finalSubmit(button) {
    const row = button.closest('tr');
    const empId = row.dataset.empId;

    if (empId.startsWith('NEW_RECORD_')) {
        alert("Please select an employee first.");
        return;
    }

    if (!employeeMasterList[empId]) {
        alert(`Error: Employee ${empId} not found in master list.`);
        return;
    }

    const collectedData = collectRowData(row);
    const empMasterDetails = employeeMasterList[empId];
    const isNewRecord = !originalRowData[empId];

    // Prepare form data
    const formData = new FormData();
    formData.append('empId', empId);
    formData.append('unitName', collectedData.unitName || 'N/A');
    formData.append('name', empMasterDetails.name);
    formData.append('department', empMasterDetails.department);
    formData.append('designation', empMasterDetails.designation);
    formData.append('foodHandlerCategory', empMasterDetails.foodHandlerCategory);
    formData.append('staffCategory', empMasterDetails.staffCategory);
    formData.append('dob', empMasterDetails.dob);
    formData.append('doj', empMasterDetails.doj);
    formData.append('trainingLevel', collectedData.trainingLevel);
    formData.append('trainingType', collectedData.trainingType || 'General');
    formData.append('trainingDate', collectedData.trainingDate);
    formData.append('certificateValidity', collectedData.certificateValidity || '2 Years');
    formData.append('status', 'Active');

    // Get the file
    const fileInput = row.querySelector('.certificate-input');
    if (fileInput && fileInput.files.length > 0) {
        formData.append('certificate', fileInput.files[0]);
    }

    // Submit via AJAX
    fetch('{{ route('saveDocuments') }}', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
})

  setTimeout(() => location.reload(), 1000);

}


        function cancelMultiStageEdit(button) {
            const row = button.closest('tr');
            const empId = row.dataset.empId;
            const currentStage = row.dataset.editStage;

            if (empId.startsWith('NEW_RECORD_')) {
                row.remove();
                const tableBody = document.getElementById('current-trainings-body');
                if (tableBody && Object.keys(getVisibleTrainingData()).length === 0 && tableBody.rows.length === 0) {
                    loadInitialData();
                }
                applyAllFilters();
            } else if ((currentStage === 'drafting' || currentStage === 'finalizing') && originalRowData[empId]) {
                trainingData[empId] = JSON.parse(JSON.stringify(originalRowData[empId]));
                delete originalRowData[empId];
                makeRowNonEditable(row, empId);
                updateButtonUI(row, 'view');
                row.dataset.editStage = 'view';
                alert('Changes discarded. Reverted to previous state.');
                updateDashboardCards();
                applyAllFilters();
            } else {
                if (trainingData[empId]){
                    makeRowNonEditable(row, empId);
                    updateButtonUI(row, 'view');
                    row.dataset.editStage = 'view';
                } else {
                    row.remove();
                }
                delete originalRowData[empId];
                applyAllFilters();
            }
        }


        // --- Delete Record Handling ---
        function handleDeleteRecord(licenseNo) {
            
            
 if (!licenseNo) {
                alert("Error: License number is missing.");
                return;
            }
            if (!confirm(`Are you sure you want to permanently delete license ${licenseNo}? This action cannot be undone.`)) {
                return;
            }

          
            
            // 🔁 Send status as "Active" or "Deactivated"
    const url = '{{ route("fostacDelete") }}';
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
    
            
            location.reload();
        }

        // --- Row Editability ---
        function makeRowEditable(row, isSetupAfterSelection = false) {
            
           
            row.classList.add('edit-mode');
            const isNewRecordRow = row.classList.contains('new-record-edit');
            const empIdSelect = row.querySelector('select.employee-select');
            const unitNameCell = row.querySelector('td[data-field="unitName"]');

            if (isNewRecordRow && !isSetupAfterSelection) {
                if (empIdSelect) empIdSelect.disabled = false;
                if (unitNameCell) {
                    if (currentUserRole === 'unit' && currentUserEntity) {
                        unitNameCell.textContent = currentUserEntity;
                        unitNameCell.contentEditable = false;
                    } else {
                        unitNameCell.contentEditable = true;
                    }
                }
                row.querySelectorAll('td[data-field="trainingType"]').forEach(td => td.contentEditable = false);
                row.querySelectorAll('select.training-level-select, input.training-date-input, select.validity-select, input.certificate-input').forEach(el => el.disabled = true);
                const fileInputLabel = row.querySelector('.certificate-btn'); if (fileInputLabel) { fileInputLabel.style.cursor = 'not-allowed'; fileInputLabel.style.opacity = '0.7'; }
                if (empIdSelect) empIdSelect.focus();
                return;
            }

            if (empIdSelect) empIdSelect.disabled = false;

            if (unitNameCell) {
                if (currentUserRole === 'unit') {
                    unitNameCell.contentEditable = false;
                    if ((isNewRecordRow || !unitNameCell.textContent.trim()) && currentUserEntity) {
                         unitNameCell.textContent = currentUserEntity;
                    }
                } else {
                    unitNameCell.contentEditable = true;
                }
            }

            row.querySelector('td[data-field="trainingType"]').contentEditable = true;
            row.querySelectorAll('select.training-level-select, input.training-date-input, select.validity-select, input.certificate-input').forEach(el => el.disabled = false);
            const fileInput = row.querySelector('.certificate-input');
            if (fileInput && !fileInput.disabled) {
                const label = fileInput.nextElementSibling; if (label?.classList.contains('certificate-btn')) { label.style.cursor = 'pointer'; label.style.opacity = '1'; }
            }
            const daysLeftCell = row.querySelector('td[data-field="daysLeft"]'); if (daysLeftCell) daysLeftCell.textContent = '-';
            const firstEditable = row.querySelector('td[data-field="unitName"][contenteditable="true"], td[data-field="trainingType"][contenteditable="true"], select.training-level-select:not([disabled])');
            if (firstEditable) setTimeout(() => firstEditable.focus(), 0);
        }

        function makeRowNonEditable(row, empId) { row.classList.remove('edit-mode'); const employeeTraining = trainingData[empId]; if (!employeeTraining) { return; } const setFieldValue = (selector, value, isSelect = false) => { const element = row.querySelector(selector); if (element) { element.value = value || (isSelect ? "" : ""); element.disabled = true; } }; const setTdText = (field, value) => { const td = row.querySelector(`td[data-field="${field}"]`); if (td) { td.textContent = value || 'N/A'; td.contentEditable = false; } }; const empIdCell = row.querySelector('td[data-field="empId"]'); if (empIdCell && empIdCell.querySelector('select')) { empIdCell.innerHTML = empId; } else if (empIdCell) { empIdCell.textContent = empId; } setTdText('name', employeeTraining.name); setTdText('department', employeeTraining.department); setTdText('designation', employeeTraining.designation); setTdText('foodHandlerCategory', employeeTraining.foodHandlerCategory); setTdText('staffCategory', employeeTraining.staffCategory); setTdText('dob', employeeTraining.dob || '-'); setTdText('doj', employeeTraining.doj || '-'); setTdText('unitName', employeeTraining.unitName); setTdText('trainingType', employeeTraining.trainingType); setFieldValue('select.training-level-select', employeeTraining.trainingLevel, true); setFieldValue('input.training-date-input', employeeTraining.trainingDate); setFieldValue('select.validity-select', employeeTraining.certificateValidity, true); const fileInput = row.querySelector('.certificate-input'); const certStatusSpan = row.querySelector('.certificate-status'); const certLabel = row.querySelector('.certificate-btn'); if (fileInput) { fileInput.value = ''; fileInput.disabled = true; } if (certLabel) { certLabel.style.cursor = 'not-allowed'; certLabel.style.opacity = '0.7'; } if (certStatusSpan) { const cert = employeeTraining.certificate; const certText = cert ? cert : 'Not uploaded'; certStatusSpan.textContent = certText; certStatusSpan.title = certText; certStatusSpan.classList.toggle('uploaded', !!cert); } const { daysLeft } = calculateOverallStatus(employeeTraining, false); updateStatusPill(row, employeeTraining); updateDaysLeftCell(row, daysLeft); }

        function updateDaysLeftCell(row, daysLeft) {
             const daysLeftCell = row.querySelector('td[data-field="daysLeft"]');
             if (daysLeftCell) {
                 let daysLeftClass = ''; if (daysLeft !== null && daysLeft >= 0) { if (daysLeft <= nearExpiryThreshold) daysLeftClass = 'days-left-very-low'; else if (daysLeft <= expiringSoonThreshold) daysLeftClass = 'days-left-low'; }
                 const daysLeftDisplay = daysLeft !== null ? daysLeft : '-'; daysLeftCell.textContent = daysLeftDisplay; daysLeftCell.classList.remove('days-left-low', 'days-left-very-low'); if (daysLeftClass) daysLeftCell.classList.add(daysLeftClass);
             }
        }

        // --- Data Collection ---
        function collectRowData(row) {
            const empId = row.dataset.empId; const collectedData = {};
            const getValue = (selector, isContentEditable = false, isDate = false, isFile = false) => { const element = row.querySelector(selector); if (!element) { return isFile ? null : ''; } let value; if (isFile) { if (element.files && element.files.length > 0) value = element.files[0].name; else { const statusSpan = row.querySelector('.certificate-status'); const currentText = statusSpan ? statusSpan.textContent.trim() : ''; value = (currentText && currentText !== 'Not uploaded') ? currentText : null; } } else if (isContentEditable) value = element.textContent.trim(); else value = element.value; if (isDate && value === "") value = null; if (element.tagName === 'SELECT' && value === "") value = null; return value; };

            const unitNameCell = row.querySelector('td[data-field="unitName"]');
            if (unitNameCell) {
                if (currentUserRole === 'unit' && !unitNameCell.isContentEditable) {
                    collectedData.unitName = unitNameCell.textContent.trim() || currentUserEntity;
                } else {
                    collectedData.unitName = getValue('td[data-field="unitName"]', true);
                }
            } else {
                collectedData.unitName = (currentUserRole === 'unit' && currentUserEntity) ? currentUserEntity : 'N/A';
            }

            collectedData.trainingLevel = getValue('select.training-level-select');
            collectedData.trainingType = getValue('td[data-field="trainingType"]', true);
            collectedData.trainingDate = getValue('input.training-date-input', false, true);
            collectedData.certificateValidity = getValue('select.validity-select');
            collectedData.certificate = getValue('.certificate-input', false, false, true);
            collectedData.nextScheduledDate = trainingData[empId]?.nextScheduledDate || null;
            return collectedData;
        }

        // --- UI Updates ---
        function updateButtonUI(row, stage) {
             const updateBtn = row.querySelector('.action-btn.update');
             const saveDraftBtn = row.querySelector('.action-btn.save-draft');
             const finalSubmitBtn = row.querySelector('.action-btn.final-submit');
             const cancelBtn = row.querySelector('.action-btn.cancel-btn');
             const historyBtn = row.querySelector('.action-btn.history-btn');
             const deleteBtn = row.querySelector('.action-btn.delete-btn');
             const deactivateContainer = row.querySelector('.deactivate-container');

             [updateBtn, saveDraftBtn, finalSubmitBtn, cancelBtn, historyBtn, deleteBtn].forEach(btn => {
                 if (btn) btn.style.display = 'none';
             });
             if (deactivateContainer) deactivateContainer.style.display = 'none';

            const isNewRecordRow = row.classList.contains('new-record-edit');
            const isEmpSelectedForNewRow = isNewRecordRow && row.querySelector('select.employee-select')?.value;


             switch (stage) {
                 case 'drafting':
                     if (saveDraftBtn) saveDraftBtn.style.display = 'inline-flex';
                     if (finalSubmitBtn) finalSubmitBtn.style.display = 'inline-flex';
                     if (cancelBtn) cancelBtn.style.display = 'inline-flex';

                     const disableActionsForNewUnselected = isNewRecordRow && !isEmpSelectedForNewRow;
                     if (saveDraftBtn) saveDraftBtn.disabled = disableActionsForNewUnselected;
                     if (finalSubmitBtn) finalSubmitBtn.disabled = disableActionsForNewUnselected;
                     break;
                 case 'finalizing':
                     if (finalSubmitBtn) finalSubmitBtn.style.display = 'inline-flex';
                     if (cancelBtn) cancelBtn.style.display = 'inline-flex';
                     if (finalSubmitBtn) finalSubmitBtn.disabled = false;
                     break;
                 case 'view':
                 default:
                     if (updateBtn) updateBtn.style.display = 'inline-flex';
                     if (historyBtn && !isNewRecordRow) historyBtn.style.display = 'inline-flex';
                     if (deleteBtn && !isNewRecordRow) deleteBtn.style.display = 'inline-flex';
                     if (deactivateContainer && !isNewRecordRow) deactivateContainer.style.display = 'flex';
                     if (updateBtn) updateBtn.disabled = false;
                     break;
             }
        }

        function updateStatusPill(row, employeeTraining) {
             const statusCell = row.querySelector('td[data-field="status"]');
             if (statusCell && employeeTraining) {
                 const { status: overallStatus } = calculateOverallStatus(employeeTraining, false);
                 
                 let statusClass = overallStatus || 'pending';
                 statusClass = statusClass === 'overdue' ? 'expired' : statusClass;

                 let statusText = statusClass ? statusClass.charAt(0).toUpperCase() + statusClass.slice(1) : 'Pending';

                 if (employeeTraining.status === 'pending' && employeeTraining.nextScheduledDate) {
                     statusText += ` (Next Scheduled Date: ${employeeTraining.nextScheduledDate})`;
                 }

                 if (employeeTraining.isDeactivated) {
                     statusText += " (Deactivated";
                     if (employeeTraining.deactivationDate) statusText += ` on ${employeeTraining.deactivationDate}`;
                     statusText += ")";
                 }
                 statusCell.innerHTML = `<span class="status ${statusClass}">${statusText}</span>`;
             }
        }

        // --- History Modal ---
     
        // --- File Input Handling ---
        function setupFileInputs() {
            const tableBody = document.getElementById('current-trainings-body'); if(tableBody) { tableBody.addEventListener('change', function(event) { if (event.target.classList.contains('certificate-input')) { const input = event.target; const uploadDiv = input.closest('.certificate-upload'); if (!uploadDiv) return; const statusSpan = uploadDiv.querySelector('.certificate-status'); if (!statusSpan) return; if (input.files && input.files.length > 0) { const fileName = input.files[0].name; statusSpan.textContent = fileName; statusSpan.classList.add('uploaded'); statusSpan.title = fileName; } else { const row = input.closest('tr'); const empId = row?.dataset.empId; let previousCert = null; if (row?.classList.contains('edit-mode') && originalRowData[empId]) previousCert = originalRowData[empId].certificate; else if (trainingData[empId]) previousCert = trainingData[empId].certificate; const displayText = previousCert ? previousCert : 'Not uploaded'; statusSpan.textContent = displayText; statusSpan.title = displayText; statusSpan.classList.toggle('uploaded', !!previousCert); } } }); }
        }

        // --- Filtering Logic ---
        function setupFilterIcons() {
            const currentTrainingsTable = document.getElementById('currentTrainingsTable');
            if (currentTrainingsTable) {
                currentTrainingsTable.querySelectorAll('th .filter-icon[data-column]').forEach(icon => { icon.addEventListener('click', (event) => { event.stopPropagation(); toggleFilterDropdown(icon.closest('th'), parseInt(icon.dataset.column, 10)); }); });
            }
            document.addEventListener('click', (event) => { const activeDropdown = document.querySelector('.filter-dropdown.show'); if (activeDropdown && !event.target.closest('.filter-dropdown') && !event.target.closest('.filter-icon')) { closeAllFilterDropdowns(); } });
        }
        function toggleFilterDropdown(th, columnIndex) { const existingDropdown = th.querySelector('.filter-dropdown'); const isCurrentlyOpen = existingDropdown && existingDropdown.classList.contains('show'); closeAllFilterDropdowns(); if (isCurrentlyOpen) return; let dropdown = existingDropdown; if (!dropdown) { const template = document.getElementById('filterDropdownTemplate'); if (!template) { console.error("Filter template not found!"); return; } dropdown = template.cloneNode(true); dropdown.id = ''; dropdown.style.display = ''; dropdown.querySelector('.filter-apply-btn').addEventListener('click', () => applyFilter(th)); dropdown.querySelector('.filter-clear-btn').addEventListener('click', () => clearFilter(th)); th.appendChild(dropdown); } populateFilterContent(th, dropdown, columnIndex); dropdown.classList.add('show'); const thRect = th.getBoundingClientRect(); dropdown.style.left = `0px`; dropdown.style.top = `${thRect.height}px`; dropdown.style.minWidth = `${thRect.width < 200 ? 200 : thRect.width}px`; }
        function closeAllFilterDropdowns() { document.querySelectorAll('.filter-dropdown.show').forEach(d => d.classList.remove('show')); }

        function populateFilterContent(th, dropdown, columnIndex) {
            const standardContent = dropdown.querySelector('.standard-filter-content');
            const customContent = dropdown.querySelector('.custom-filter-content');
            const optionsContainer = standardContent.querySelector('.filter-options');
            const searchInput = standardContent.querySelector('.filter-search');
            standardContent.style.display = 'none'; customContent.innerHTML = ''; customContent.style.display = 'none';
            if (optionsContainer) optionsContainer.innerHTML = ''; if (searchInput) searchInput.value = '';

            const filterType = determineFilterType(columnIndex);
            if (!filterType) return;

            if (filterType === 'unit_column_filter') {
                customContent.style.display = 'block';
                const accessibleUnits = getAccessibleUnits().sort((a, b) => a.localeCompare(b));
                let optionsHTML = '<option value="">-- All Accessible Units --</option>';
                accessibleUnits.forEach(unit => {
                    optionsHTML += `<option value="${unit}">${unit}</option>`;
                });
                customContent.innerHTML = `
                    <div style="margin-bottom: 8px;">
                        <label for="filter-unit-column-select" style="display:block; margin-bottom: 4px;">Unit:</label>
                        <select id="filter-unit-column-select" class="filter-unit-select" style="width:100%;">
                            ${optionsHTML}
                        </select>
                    </div>`;
            } else if (filterType === 'date') {
                customContent.style.display = 'block';
                let prefix = '';
                if (columnIndex === 8) prefix = 'dob'; else if (columnIndex === 9) prefix = 'doj'; else if (columnIndex === 12) prefix = 'trainingDate';
                populateDateFilter(customContent, prefix);
            } else {
                standardContent.style.display = 'block';
                if (filterType === 'status') populateCheckboxFilterOptions(th, dropdown);
                else if (filterType === 'certificateStatus') populateCertificateCheckboxOptions(th, dropdown);
                else populateCheckboxFilterOptions(th, dropdown);

                if (searchInput) {
                    const newSearchInput = searchInput.cloneNode(true);
                    standardContent.replaceChild(newSearchInput, searchInput);
                    newSearchInput.addEventListener('input', (e) => filterDropdownOptions(dropdown, e.target.value));
                }
            }
            loadFilterState(th, dropdown);
        }

        function populateDateFilter(container, prefix) { container.innerHTML = `<div style="margin-bottom: 8px;"><label for="${prefix}-filter-date-from">From:</label><input type="date" id="${prefix}-filter-date-from" class="filter-date-input"></div><div><label for="${prefix}-filter-date-to">To:</label><input type="date" id="${prefix}-filter-date-to" class="filter-date-input"></div>`; }
        function populateCheckboxFilterOptions(th, dropdown) { const columnIndex = th.cellIndex; const tableBody = th.closest('table').querySelector('tbody'); const optionsContainer = dropdown.querySelector('.filter-options'); optionsContainer.innerHTML = ''; if (!tableBody || !optionsContainer) return; const uniqueValues = new Set(); Array.from(tableBody.rows).forEach(row => { if (row.dataset.filteredOut === 'true' || row.querySelector('td[colspan]') || row.classList.contains('new-record-edit') || row.cells.length <= columnIndex) return; const cell = row.cells[columnIndex]; let value = ''; if (columnIndex === 16) { value = cell.querySelector('.status')?.textContent.trim() || 'Pending'; } else { const inputElement = cell.querySelector('select'); if (inputElement) value = inputElement.options[inputElement.selectedIndex]?.textContent.trim() || inputElement.value; else value = cell.textContent.trim(); } if (value === null || value === undefined || value === '' || value === '--' || value === '-' || value === 'N/A') value = '(Empty)'; uniqueValues.add(value); }); const sortedValues = Array.from(uniqueValues).sort((a, b) => { if (a === '(Empty)') return -1; if (b === '(Empty)') return 1; return a.localeCompare(b); }); if (sortedValues.length === 0) { optionsContainer.innerHTML = '<span style="color: var(--dark-gray); font-style: italic; padding: 5px;">No options</span>'; return; } sortedValues.forEach(value => { const label = document.createElement('label'); const checkbox = document.createElement('input'); checkbox.type = 'checkbox'; checkbox.value = value; label.append(checkbox, ` ${value}`); optionsContainer.appendChild(label); }); }
         function populateCertificateCheckboxOptions(th, dropdown) { const optionsContainer = dropdown.querySelector('.filter-options'); optionsContainer.innerHTML = ''; ['Uploaded', 'Not uploaded'].forEach(value => { const label = document.createElement('label'); const checkbox = document.createElement('input'); checkbox.type = 'checkbox'; checkbox.value = value; label.append(checkbox, ` ${value}`); optionsContainer.appendChild(label); }); }
        function filterDropdownOptions(dropdown, searchTerm) { const optionsContainer = dropdown.querySelector('.filter-options'); if (!optionsContainer) return; const lowerSearchTerm = searchTerm.toLowerCase(); optionsContainer.querySelectorAll('label').forEach(label => label.style.display = (lowerSearchTerm === '' || label.textContent.toLowerCase().includes(lowerSearchTerm)) ? 'flex' : 'none'); }
         function loadFilterState(th, dropdown) {
             const filterType = th.dataset.filterType; const filterValueJSON = th.dataset.filterValue; if (!filterType || !filterValueJSON) return;
             try {
                 const filterValues = JSON.parse(filterValueJSON);
                 if (filterType === 'unit_column_filter' && filterValues.unit) {
                     const unitSelect = dropdown.querySelector('#filter-unit-column-select');
                     if (unitSelect) unitSelect.value = filterValues.unit;
                 } else if (filterType === 'date' && (filterValues.from || filterValues.to)) {
                     let prefix = ''; const colIndex = th.cellIndex;
                     if (colIndex === 8) prefix = 'dob'; else if (colIndex === 9) prefix = 'doj'; else if (colIndex === 12) prefix = 'trainingDate';
                     const fromInput = dropdown.querySelector(`#${prefix}-filter-date-from`); const toInput = dropdown.querySelector(`#${prefix}-filter-date-to`);
                     if (fromInput) fromInput.value = filterValues.from || ''; if (toInput) toInput.value = filterValues.to || '';
                 } else if (['checkbox', 'status', 'certificateStatus'].includes(filterType) && filterValues.values) {
                     const selectedValues = new Set(filterValues.values);
                     dropdown.querySelectorAll('.filter-options input[type="checkbox"]').forEach(cb => cb.checked = selectedValues.has(cb.value));
                 }
             } catch (e) { console.error("Error parsing filter state:", e); }
         }
        function applyFilter(th) {
            const columnIndex = th.cellIndex; const dropdown = th.querySelector('.filter-dropdown'); if (!dropdown || columnIndex === 14) return;
            let isActiveFilter = false; let filterData = {};
            const filterType = determineFilterType(columnIndex);

            if (filterType === 'unit_column_filter') {
                const unitV = dropdown.querySelector('#filter-unit-column-select')?.value;
                if (unitV) { filterData = { type: 'unit_column_filter', unit: unitV }; isActiveFilter = true; }
            } else if (filterType === 'date') {
                let prefix = ''; if (columnIndex === 8) prefix = 'dob'; else if (columnIndex === 9) prefix = 'doj'; else if (columnIndex === 12) prefix = 'trainingDate';
                const fromV = dropdown.querySelector(`#${prefix}-filter-date-from`)?.value || '';
                const toV = dropdown.querySelector(`#${prefix}-filter-date-to`)?.value || '';
                if (fromV || toV) { filterData = { type: 'date', from: fromV, to: toV }; isActiveFilter = true; }
            } else if (['checkbox', 'status', 'certificateStatus'].includes(filterType)) {
                const selectedCheckboxes = Array.from(dropdown.querySelectorAll('.filter-options input[type="checkbox"]:checked')).map(cb => cb.value);
                if (selectedCheckboxes.length > 0) { filterData = { type: filterType, values: selectedCheckboxes }; isActiveFilter = true; }
            }

            th.dataset.filterActive = isActiveFilter ? 'true' : 'false';
            th.dataset.filterType = isActiveFilter ? filterData.type : '';
            th.dataset.filterValue = isActiveFilter ? JSON.stringify(filterData) : '';
            const filterIcon = th.querySelector('.filter-icon');
            if (filterIcon) filterIcon.style.color = isActiveFilter ? 'var(--primary-color)' : '';
            applyAllFilters(th.closest('thead'));
            closeAllFilterDropdowns();
        }
        function clearFilter(th) {
            const columnIndex = th.cellIndex; const dropdown = th.querySelector('.filter-dropdown'); if (!dropdown || columnIndex === 14) return;
            const filterType = determineFilterType(columnIndex);

            if (filterType === 'unit_column_filter') { dropdown.querySelectorAll('.filter-unit-select').forEach(sel => sel.selectedIndex = 0); }
            else if (filterType === 'date') { dropdown.querySelectorAll('.filter-date-input').forEach(input => input.value = ''); }
            else { dropdown.querySelectorAll('.filter-options input[type="checkbox"]').forEach(cb => cb.checked = false); const searchInput = dropdown.querySelector('.filter-search'); if (searchInput) searchInput.value = ''; filterDropdownOptions(dropdown, ''); }

            th.dataset.filterActive = 'false'; th.dataset.filterType = ''; th.dataset.filterValue = '';
            const filterIcon = th.querySelector('.filter-icon'); if (filterIcon) filterIcon.style.color = '';
            applyAllFilters(th.closest('thead'));
            closeAllFilterDropdowns();
        }
        function determineFilterType(columnIndex) {
            if (columnIndex === 1) return 'unit_column_filter';
            const colMap = { 8: 'date', 9: 'date', 12: 'date', 15: 'certificateStatus', 16: 'status', 14: null };
            return colMap[columnIndex] ?? 'checkbox';
        }

        function applyAllFilters(thead = null) {
            if (!thead) thead = document.getElementById('currentTrainingsTable')?.querySelector('thead');
            const tableBody = document.getElementById('current-trainings-body');
            const mobileCardsContainer = document.getElementById('mobile-cards-container');
            if (!tableBody || !thead || !mobileCardsContainer) return;

            const activeColumnFilters = [];
            thead.querySelectorAll('th[data-filter-active="true"]').forEach(th => {
                try { activeColumnFilters.push({ columnIndex: th.cellIndex, type: th.dataset.filterType, config: JSON.parse(th.dataset.filterValue || '{}') }); }
                catch (e) { console.error("Error parsing column filter config for column", th.cellIndex, e); }
            });

            const processItem = (item, isCard = false) => {
                if ((isCard && item.classList.contains('new-mobile-card-edit')) || (!isCard && item.classList.contains('new-record-edit'))) {
                    item.dataset.filteredOut = 'false'; return;
                }
                if (!isCard && item.querySelector('td[colspan]')) {
                    item.dataset.filteredOut = 'false'; return;
                }

                let showItem = true;
                const empId = item.dataset.empId;
                const employeeDataForStatus = trainingData[empId];
                let itemStatus = 'pending', itemDaysLeft = null;

                if (employeeDataForStatus) {
                    const { status: calculatedStatus, daysLeft } = calculateOverallStatus(employeeDataForStatus, false);
                    itemStatus = employeeDataForStatus.status === 'draft' ? 'draft' : calculatedStatus;
                    itemDaysLeft = daysLeft;

                    if (mobileFilterState.searchText.empId && employeeDataForStatus.empId.toLowerCase().indexOf(mobileFilterState.searchText.empId.toLowerCase()) === -1) {
                        showItem = false;
                    }

                    if (showItem && mobileFilterState.searchText.name && employeeDataForStatus.name.toLowerCase().indexOf(mobileFilterState.searchText.name.toLowerCase()) === -1) {
                         showItem = false;
                    }

                    if (showItem && (mobileFilterState.cascadingOrg.corporate || mobileFilterState.cascadingOrg.regional || mobileFilterState.cascadingOrg.unit)) {
                        const { corporateEntity, region } = getUnitHierarchyDetails(employeeDataForStatus.unitName);
                        if (mobileFilterState.cascadingOrg.corporate && corporateEntity !== mobileFilterState.cascadingOrg.corporate) {
                            showItem = false;
                        }
                        if (showItem && mobileFilterState.cascadingOrg.regional && region !== mobileFilterState.cascadingOrg.regional) {
                            showItem = false;
                        }
                        if (showItem && mobileFilterState.cascadingOrg.unit && employeeDataForStatus.unitName !== mobileFilterState.cascadingOrg.unit) {
                            showItem = false;
                        }
                    }

                    if (showItem) {
                        if (currentTableFilter === 'default' && itemStatus === 'expired' && !employeeDataForStatus.isDeactivated) showItem = false;
                        else if (currentTableFilter === 'validOnly' && (employeeDataForStatus.isDeactivated || !(itemStatus === 'completed' && itemDaysLeft !== null && itemDaysLeft > expiringSoonThreshold))) showItem = false;
                        else if (currentTableFilter === 'expiringSoon' && (employeeDataForStatus.isDeactivated || !(itemStatus === 'completed' && itemDaysLeft !== null && itemDaysLeft >= 0 && itemDaysLeft <= expiringSoonThreshold))) showItem = false;
                    }

                } else {
                    itemStatus = 'pending';

                    if (!item.classList.contains('new-record-edit') && !item.classList.contains('new-mobile-card-edit')) {
                         if (currentTableFilter === 'validOnly' || currentTableFilter === 'expiringSoon') showItem = false;

                         if (mobileFilterState.searchText.empId && empId.toLowerCase().indexOf(mobileFilterState.searchText.empId.toLowerCase()) === -1) showItem = false;
                         if (showItem && mobileFilterState.searchText.name) {
                             const nameElement = item.querySelector(isCard ? '.emp-name-mobile' : 'td[data-field="name"]');
                             if (nameElement && nameElement.textContent.toLowerCase().indexOf(mobileFilterState.searchText.name.toLowerCase()) === -1) {
                                showItem = false;
                             } else if (!nameElement) {
                                showItem = false;
                             }
                         }

                         if (showItem && (mobileFilterState.cascadingOrg.corporate || mobileFilterState.cascadingOrg.regional || mobileFilterState.cascadingOrg.unit)) {
                            showItem = false;
                         }
                    }
                }

                if (showItem && employeeDataForStatus) {
                    for (const filter of activeColumnFilters) {
                        if (!showItem) break;

                        let cellValue = '';
                        if (!isCard) {
                            const cell = item.cells[filter.columnIndex];
                            if (!cell) { showItem = false; break; }
                            if (filter.type === 'status') {
                                cellValue = cell.querySelector('.status')?.textContent.trim() || 'Pending';
                            } else if (filter.type === 'certificateStatus') cellValue = cell.querySelector('span.certificate-status')?.classList.contains('uploaded') ? 'Uploaded' : 'Not uploaded';
                            else if (filter.type === 'date') cellValue = cell.querySelector('input[type="date"]')?.value || cell.textContent.trim();
                            else { const sel = cell.querySelector('select'); cellValue = sel ? (sel.options[sel.selectedIndex]?.textContent.trim() || sel.value) : cell.textContent.trim(); if ([null, undefined, '', '--', '-', 'N/A'].includes(cellValue)) cellValue = '(Empty)'; }
                        } else {
                             const thElementForCard = document.querySelector(`#currentTrainingsTable thead th[data-column="${filter.columnIndex}"]`);
                             const dataFieldKey = thElementForCard?.dataset.columnId;

                            if (filter.type === 'status') {
                                let statusText = (itemStatus === 'overdue' ? 'Expired' : (itemStatus || 'pending')).charAt(0).toUpperCase() + (itemStatus || 'pending').slice(1);
                                if (employeeDataForStatus.status === 'pending' && employeeDataForStatus.nextScheduledDate) {
                                    statusText += ` (Next Scheduled Date: ${employeeDataForStatus.nextScheduledDate})`;
                                }
                                if (employeeDataForStatus.isDeactivated) {
                                     statusText += ` (Deactivated`;
                                     if(employeeDataForStatus.deactivationDate) statusText += ` on ${employeeDataForStatus.deactivationDate}`;
                                     statusText += `)`;
                                }
                                cellValue = statusText;
                            } else if (filter.type === 'certificateStatus') {
                                cellValue = employeeDataForStatus.certificate ? 'Uploaded' : 'Not uploaded';
                            } else if (dataFieldKey && employeeDataForStatus) {
                                cellValue = employeeDataForStatus[dataFieldKey] || '';
                                if ([null, undefined, '', '--', '-', 'N/A'].includes(cellValue)) cellValue = '(Empty)';
                            }
                        }

                        switch (filter.type) {
                            case 'unit_column_filter': if (filter.config.unit && employeeDataForStatus.unitName !== filter.config.unit) showItem = false; break;
                            case 'date': if (!cellValue || cellValue === '-' || cellValue === '(Empty)') { if (filter.config.from || filter.config.to) showItem = false; } else { try { const rd = new Date(cellValue+'T00:00:00'); const fd = filter.config.from ? new Date(filter.config.from+'T00:00:00') : null; const td = filter.config.to ? new Date(filter.config.to+'T23:59:59') : null; if(isNaN(rd.getTime())) {showItem = false; break;} if (fd && rd < fd) showItem = false; if (td && rd > td) showItem = false; } catch(e){ showItem = false; } } break;
                            case 'status': case 'certificateStatus': case 'checkbox': const selected = new Set(filter.config.values || []); if (!selected.has(cellValue)) showItem = false; break;
                        }
                    }
                }
                item.dataset.filteredOut = showItem ? 'false' : 'true';
            };

            Array.from(tableBody.rows).forEach(row => processItem(row, false));
            Array.from(mobileCardsContainer.children).forEach(card => processItem(card, true));

            displayTablePage(1);
        }


        // --- Pagination ---
        function setupRowsPerPageSelector() {
            const selector = document.getElementById('rowsPerPageSelect');
            if (selector) {
                rowsPerPage = parseInt(selector.value, 10);
                selector.addEventListener('change', (event) => {
                    rowsPerPage = parseInt(event.target.value, 10);
                    displayTablePage(1);
                });
            } else { rowsPerPage = 10; }
        }

        function setupPaginationEventListeners() {
            const prevPageBtn = document.getElementById('prevPageBtn');
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', () => {
                    if (currentPage > 1) displayTablePage(currentPage - 1);
                });
            }
            const nextPageBtn = document.getElementById('nextPageBtn');
            if(nextPageBtn) {
                nextPageBtn.addEventListener('click', () => {
                    const tableBody = document.getElementById('current-trainings-body');
                    const totalVisibleItems = getVisibleItems(tableBody, 'tr').length;
                    const totalPages = Math.ceil(totalVisibleItems / rowsPerPage);
                    if (currentPage < totalPages) displayTablePage(currentPage + 1);
                });
            }
        }

        function getVisibleItems(container, itemSelector, isCard = false) {
            if (!container) return [];
            return Array.from(container.querySelectorAll(itemSelector)).filter(item =>
                item.dataset.filteredOut !== 'true' &&
                (isCard ? !item.classList.contains('new-mobile-card-edit') : (!item.classList.contains('new-record-edit') && !item.querySelector('td[colspan]')))
            );
        }

        function displayTablePage(page) {
            currentPage = page;
            const tableBody = document.getElementById('current-trainings-body');
            const mobileCardsContainer = document.getElementById('mobile-cards-container');

            if (tableBody) Array.from(tableBody.rows).forEach(row => { if (!row.classList.contains('new-record-edit') && !row.querySelector('td[colspan]')) row.style.display = 'none'; });
            if (mobileCardsContainer) Array.from(mobileCardsContainer.children).forEach(card => { if (!card.classList.contains('new-mobile-card-edit')) card.style.display = 'none'; });

            const rowsToPaginate = getVisibleItems(tableBody, 'tr');
            const cardsToPaginate = getVisibleItems(mobileCardsContainer, '.mobile-data-card', true);


            const totalVisibleItems = rowsToPaginate.length;
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            rowsToPaginate.slice(startIndex, endIndex).forEach((row, index) => {
                row.style.display = '';
                const slNoCell = row.querySelector('td.sl-no');
                if (slNoCell) slNoCell.textContent = startIndex + index + 1;
            });

            cardsToPaginate.slice(startIndex, endIndex).forEach(card => {
                card.style.display = '';
            });


            const newRecordRow = tableBody.querySelector('tr.new-record-edit');
            if (newRecordRow) {
                newRecordRow.style.display = '';
                const slNoCell = newRecordRow.querySelector('td.sl-no');
                if(slNoCell) slNoCell.textContent = '+';
            }
            if(mobileCardsContainer){
                const newMobileCard = mobileCardsContainer.querySelector('.new-mobile-card-edit');
                if (newMobileCard) {
                    newMobileCard.style.display = '';
                }
            }

            setupPagination(totalVisibleItems);
        }


        function setupPagination(totalItems) {
            const pageNumbersContainer = document.getElementById('pageNumbers');
            const pageInfoSpan = document.getElementById('pageInfo');
            const prevBtn = document.getElementById('prevPageBtn');
            const nextBtn = document.getElementById('nextPageBtn');
            const paginationContainer = document.querySelector('.pagination-container');

            if (!pageNumbersContainer || !pageInfoSpan || !prevBtn || !nextBtn || !paginationContainer) return;

            const totalPages = Math.ceil(totalItems / rowsPerPage);
            pageNumbersContainer.innerHTML = '';

            if (totalPages <= 1 && totalItems === 0) {
                paginationContainer.style.display = 'none';
                pageInfoSpan.textContent = 'No items matching filters';
                return;
            } else if (totalPages <= 1) {
                 paginationContainer.style.display = 'none';
                 pageInfoSpan.textContent = `Total: ${totalItems} item${totalItems !== 1 ? 's' : ''}`;
                 return;
            } else {
                 paginationContainer.style.display = 'flex';
            }

            pageNumbersContainer.style.display = 'inline-flex';
            const maxPageButtons = 5;
            let startPage, endPage;
            if (totalPages <= maxPageButtons) {
                startPage = 1; endPage = totalPages;
            } else {
                const maxPagesBeforeCurrent = Math.floor((maxPageButtons - 3) / 2);
                const maxPagesAfterCurrent = Math.ceil((maxPageButtons - 3) / 2);
                if (currentPage <= maxPagesBeforeCurrent + 1) { startPage = 1; endPage = maxPageButtons - 1; }
                else if (currentPage >= totalPages - maxPagesAfterCurrent) { startPage = totalPages - (maxPageButtons - 2); endPage = totalPages; }
                else { startPage = currentPage - maxPagesBeforeCurrent; endPage = currentPage + maxPagesAfterCurrent; }
            }
            if (startPage > 1) {
                pageNumbersContainer.appendChild(createPageButton(1));
                if (startPage > 2) { const ellipsis = document.createElement('span'); ellipsis.textContent = '...'; pageNumbersContainer.appendChild(ellipsis); }
            }
            for (let i = startPage; i <= endPage; i++) { pageNumbersContainer.appendChild(createPageButton(i)); }
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) { const ellipsis = document.createElement('span'); ellipsis.textContent = '...'; pageNumbersContainer.appendChild(ellipsis); }
                pageNumbersContainer.appendChild(createPageButton(totalPages));
            }
            const startIndexPagination = (currentPage - 1) * rowsPerPage;
            const startItemInfo = totalItems === 0 ? 0 : startIndexPagination + 1;
            const endItemInfo = Math.min(startIndexPagination + rowsPerPage, totalItems);
            pageInfoSpan.textContent = totalItems > 0 ? `Showing ${startItemInfo}-${endItemInfo} of ${totalItems} item${totalItems !== 1 ? 's' : ''}` : 'No items';
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages || totalItems === 0;
        }


        function createPageButton(pageNumber) {
            const button = document.createElement('button');
            button.textContent = pageNumber;
            button.classList.add('page-number-btn');
            if (pageNumber === currentPage) { button.classList.add('active'); }
            button.addEventListener('click', () => displayTablePage(pageNumber));
            return button;
        }

        function handleMainActionCard(button) {
            const card = button.closest('.mobile-data-card');
            alert(`Action '${button.title}' for card Emp ID: ${card.dataset.empId}. Edit/Save for cards not fully implemented yet.`);
        }
        function handleDeleteRecordCard(button) {
            
          
            const card = button.closest('.mobile-data-card');
            const empId = card.dataset.empId;
            const employeeName = trainingData[empId]?.name || employeeMasterList[empId]?.name || empId;
            if (confirm(`Are you sure you want to delete the training record for ${employeeName} (ID: ${empId}) from this card? This action cannot be undone.`)) {
                let recordExisted = false;
                if (trainingData[empId]) { delete trainingData[empId]; recordExisted = true; }
                if (originalRowData[empId]) delete originalRowData[empId];

                card.remove();

                const tableRow = document.querySelector(`#current-trainings-body tr[data-emp-id="${empId}"]`);
                if (tableRow) tableRow.remove();

                const tableBody = document.getElementById('current-trainings-body');
                if (tableBody && Object.keys(getVisibleTrainingData()).length === 0) {
                    loadInitialData();
                }

                if (recordExisted) {
                    updateDashboardCards();
                    applyAllFilters();
                    alert(`Record for ${employeeName} deleted successfully.`);
                } else {
                    applyAllFilters();
                    alert(`Card for ${employeeName} removed.`);
                }
            }
        }
        function cancelMultiStageEditCard(button) {
            const card = button.closest('.mobile-data-card');
            alert(`Cancel for card Emp ID: ${card.dataset.empId}. Edit/Cancel for cards not fully implemented yet.`);
        }



        function handleDeactivateToggle(event) {
            const checkbox = event.target;
            const empId = checkbox.dataset.empId;
            const row = checkbox.closest('tr');
            const deactivateLabel = row.querySelector('.deactivate-label');
            const currentDate = new Date().toISOString().split('T')[0];

            if (trainingData[empId]) {
                const isDeactivating = checkbox.checked;
                let reason = DEACTIVATE_REASON_PLACEHOLDER;

                 if (isDeactivating) {
                    if (!confirm(`Are you sure you want to deactivate employee ${trainingData[empId].name || empId}?`)) {
                        checkbox.checked = false;
                        return;
                    }
                    const userReason = prompt("Please enter reason for deactivation:", DEACTIVATE_REASON_PLACEHOLDER);
                    if (userReason === null) {
                        checkbox.checked = false;
                        return;
                    }
                    reason = userReason || DEACTIVATE_REASON_PLACEHOLDER;
                    trainingData[empId].deactivationDate = currentDate;
                } else {
                     if (!confirm(`Are you sure you want to reactivate employee ${trainingData[empId].name || empId}?`)) {
                        checkbox.checked = true;
                        return;
                    }
                    trainingData[empId].deactivationDate = null;
                }

                trainingData[empId].isDeactivated = isDeactivating;
                trainingData[empId].deactivationReason = isDeactivating ? reason : '';

                row.setAttribute('data-deactivated', isDeactivating.toString());
                if (deactivateLabel) deactivateLabel.textContent = isDeactivating ? 'Deactivated' : 'Deactivate';

                updateStatusPill(row, trainingData[empId]);

                const mobileCard = document.querySelector(`.mobile-data-card[data-emp-id="${empId}"]`);
                if (mobileCard) {
                    mobileCard.setAttribute('data-deactivated', isDeactivating.toString());
                    const { status: overallStatus } = calculateOverallStatus(trainingData[empId], false);
                    const statusPillCard = mobileCard.querySelector('.status-mobile');
                     let statusTextForCard = (overallStatus === 'overdue' ? 'Expired' : (overallStatus || 'pending')).charAt(0).toUpperCase() + (overallStatus || 'pending').slice(1);
                    if (trainingData[empId].status === 'pending' && trainingData[empId].nextScheduledDate) {
                         statusTextForCard += ` (Next Scheduled Date: ${trainingData[empId].nextScheduledDate})`;
                    }
                    if (isDeactivating) {
                         statusTextForCard += ` (Deactivated`;
                         if (trainingData[empId].deactivationDate) statusTextForCard += ` on ${trainingData[empId].deactivationDate}`;
                         statusTextForCard += `)`;
                    }
                    const statusClassForPill = overallStatus === 'overdue' ? 'expired' : (overallStatus || 'pending');
                     if(statusPillCard) {
                        statusPillCard.textContent = statusTextForCard;
                        statusPillCard.className = `status-mobile ${statusClassForPill}`;
                    }
                }

                console.log(`Record ${empId} ${isDeactivating ? 'deactivated' : 'reactivated'} from table.`);
                updateDashboardCards();
                 applyAllFilters();
            } else {
                console.error(`Training data not found for employee ${empId} during deactivation attempt from table.`);
            }
        }

        // --- Add User Modal Logic ---
        function openAddUserModal() {
            const modalContainer = document.getElementById('addUserModalContainer');
            if (modalContainer) {
                modalContainer.classList.add('show');
                document.body.style.overflow = 'hidden';
                initializeAddUserFormFilters();
                document.getElementById('addUserForm')?.reset();
            }
        }

        function closeAddUserModal() {
            const modalContainer = document.getElementById('addUserModalContainer');
            if (modalContainer) {
                modalContainer.classList.remove('show');
                document.body.style.overflow = '';
                document.getElementById('addUserForm')?.reset();
                hideFiltersAfterAddUser('corporate');
            }
        }

        function setupAddUserModal() {
            const addUserModalContainer = document.getElementById('addUserModalContainer');
            if (!addUserModalContainer) return;

            const closeButton = addUserModalContainer.querySelector('.add-user-close-button');
            // const cancelButton = addUserModalContainer.querySelector('.add-user-cancel-button'); // Already handled by generic closer
            const addUserForm = document.getElementById('addUserForm');

            // if (closeButton) closeButton.addEventListener('click', closeAddUserModal); // Already handled by generic closer
            // if (cancelButton) cancelButton.addEventListener('click', closeAddUserModal); // Already handled by generic closer

            // addUserModalContainer.addEventListener('click', (event) => { // Already handled by generic closer
            //      if (event.target === addUserModalContainer) {
            //          closeAddUserModal();
            //      }
            // });

            if (addUserForm) {
                addUserForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const formData = {
                        corporate: addUserForm.elements.corporate.value,
                        regional: addUserForm.elements.regional.value,
                        unit: addUserForm.elements.unit.value,
                        department: addUserForm.elements.department.value,
                        location: addUserForm.elements.location.value,
                        employeeId: addUserForm.elements.employeeId.value.trim(),
                        employeeFullName: addUserForm.elements.employeeFullName.value.trim(),
                        emailId: addUserForm.elements.emailId.value.trim(),
                        contactNumber: addUserForm.elements.contactNumber.value.trim(),
                        selectGender: addUserForm.elements.selectGender.value,
                        designation: addUserForm.elements.designation.value.trim(),
                        doj: addUserForm.elements.doj.value,
                        dob: addUserForm.elements.dob.value,
                        staffCategory: addUserForm.elements.staffCategory.value,
                        selectFoodHandlersCategory: addUserForm.elements.selectFoodHandlersCategory.value
                    };

                    if (employeeMasterList[formData.employeeId]) {
                        alert(`Employee ID ${formData.employeeId} already exists. Please use a unique ID.`);
                        return;
                    }
                    if (!formData.employeeId || !formData.employeeFullName || !formData.unit) {
                         alert("Employee ID, Full Name, and Unit are required.");
                         return;
                    }

                    let departmentName = formData.department;
                    const deptSelect = addUserForm.elements.department;
                    if(deptSelect.value && deptSelect.options[deptSelect.selectedIndex] && deptSelect.options[deptSelect.selectedIndex].text !== `Select Department` && deptSelect.options[deptSelect.selectedIndex].text !== `No Department available`){
                        departmentName = deptSelect.options[deptSelect.selectedIndex].text;
                    } else {
                        departmentName = 'N/A';
                    }


                    employeeMasterList[formData.employeeId] = {
                        name: formData.employeeFullName,
                        department: departmentName,
                        designation: formData.designation,
                        foodHandlerCategory: formData.selectFoodHandlersCategory,
                        staffCategory: formData.staffCategory,
                        dob: formData.dob,
                        doj: formData.doj
                    };

                    trainingData[formData.employeeId] = {
                        unitName: formData.unit,
                        empId: formData.employeeId,
                        name: formData.employeeFullName,
                        department: departmentName,
                        designation: formData.designation,
                        foodHandlerCategory: formData.selectFoodHandlersCategory,
                        staffCategory: formData.staffCategory,
                        dob: formData.dob,
                        doj: formData.doj,
                        trainingLevel: null,
                        trainingType: null,
                        trainingDate: null,
                        certificateValidity: null,
                        status: 'pending',
                        certificate: null,
                        history: [],
                        isDeactivated: false,
                        deactivationReason: '',
                        deactivationDate: null,
                        nextScheduledDate: null
                    };

                    console.log("New User Data (Master):", employeeMasterList[formData.employeeId]);
                    console.log("New Training Record Stub:", trainingData[formData.employeeId]);
                    alert(`User ${formData.employeeFullName} (ID: ${formData.employeeId}) added. Their FoSTaC training record is now pending.`);
                    closeAddUserModal();
                    refreshTable();
                });
            }
            initializeAddUserFormFilters();
        }

        const addUserFilterData = {
            corporates: [
                { id: "Apex Corp", name: "Apex Corp" },
                { id: "Beta Solutions", name: "Beta Solutions" },
                { id: "Global Services", name: "Global Services" }
            ],
            regionals: {
                "Apex Corp": [
                    { id: "Northern Region", name: "Northern Region" },
                    { id: "Southern Region", name: "Southern Region" }
                ],
                "Beta Solutions": [
                    { id: "Eastern Division", name: "Eastern Division" },
                    { id: "Western Division", name: "Western Division" }
                ],
                "Global Services": [
                    { id: "Headquarters", name: "Headquarters"},
                    { id: "Shared Operations", name: "Shared Operations"}
                ]
            },
            units: {}, 
            departments: { 
                "<?= Auth::user()->company_name ?>": [{id: "Operations_UA", name: "Operations"}, {id: "Kitchen_UA", name: "Kitchen"}],
                "Unit Beta": [{id: "Logistics_UB", name: "Logistics"}],
                "Warehouse North": [{id: "Warehouse_WN", name: "Warehouse"}],
                "Unit Gamma": [{id: "Production_UG", name: "Production"}],
                "Factory South": [{id: "Maintenance_FS", name: "Maintenance"}, {id: "Quality_FS", name: "Quality"}],
                "Unit Delta": [{id: "Sales_UD", name: "Sales"}, {id: "CustomerService_UD", name: "Customer Service"}],
                "Office East": [{id: "Admin_OE", name: "Admin"}, {id: "Marketing_OE", name: "Marketing"}],
                "Unit Epsilon": [{id: "FieldOps_UE", name: "Field Ops"}],
                "Logistics West": [{id: "Logistics_LW", name: "Logistics"}],
                "Admin Central": [{id: "HR_AC", name: "HR"}, {id: "Finance_AC", name: "Finance"}],
                "IT Hub": [{id: "IT_IH", name: "IT"}],
                "Central Labs": [{id: "RnD_CL", name: "R&D"}],
                "Support Center": [{id: "Support_SC", name: "Support"}],
            },
            locations: { 
                 "Operations_UA": [{id: "Floor1_UA_Ops", name: "Floor 1"}, {id: "OfficeA_UA_Ops", name: "Office A"}],
                 "Kitchen_UA": [{id: "MainKitchen_UA_Kit", name: "Main Kitchen"}],
                 "Logistics_UB": [{id: "Dock1_UB_Log", name: "Dock 1"}],
            }
        };
        for (const corp in unitHierarchy) {
            for (const region in unitHierarchy[corp]) {
                if (!addUserFilterData.units[region]) {
                    addUserFilterData.units[region] = [];
                }
                unitHierarchy[corp][region].forEach(unit => {
                    addUserFilterData.units[region].push({ id: unit, name: unit });
                });
            }
        }


        function populateAddUserSelect(selectElement, items, placeholder) {
            if (!selectElement) return;
            selectElement.innerHTML = `<option value="">Select ${placeholder}</option>`;
            if (items && items.length > 0) {
                items.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
                selectElement.disabled = false;
            } else {
                selectElement.disabled = true;
                const noItemOption = document.createElement('option');
                noItemOption.value = "";
                noItemOption.textContent = `No ${placeholder} available`;
                noItemOption.disabled = true;
                selectElement.appendChild(noItemOption);
            }
        }

        function showAddUserFilterWithAnimation(containerId) {
            const container = document.getElementById(containerId);
            if (container) {
                container.style.display = 'block';
                void container.offsetWidth; 
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }
        }

        function hideFiltersAfterAddUser(currentFilterKey) {
            const filterOrder = ['corporate', 'regional', 'unit', 'department', 'location'];
            const currentIndex = filterOrder.indexOf(currentFilterKey);
            const addUserForm = document.getElementById('addUserForm');
            if(!addUserForm) return;

            for (let i = currentIndex + 1; i < filterOrder.length; i++) {
                const filterName = filterOrder[i];
                const filterContainer = document.getElementById(`${filterName}Filter`);
                const selectElement = addUserForm.elements[filterName];

                if (filterContainer) filterContainer.style.display = 'none';
                if (selectElement) populateAddUserSelect(selectElement, [], filterName.charAt(0).toUpperCase() + filterName.slice(1));
            }
        }

        function initializeAddUserFormFilters() {
            const addUserForm = document.getElementById('addUserForm');
            if (!addUserForm) return;

            populateAddUserSelect(addUserForm.elements.corporate, addUserFilterData.corporates, 'Corporate');
            const corporateFilterContainer = document.getElementById('corporateFilter');
            if (corporateFilterContainer) corporateFilterContainer.style.display = 'block'; 
            hideFiltersAfterAddUser('corporate'); 

            

            addUserForm.elements.regional.addEventListener('change', function() {
                const selectedRegionalId = this.value;
                populateAddUserSelect(addUserForm.elements.unit, addUserFilterData.units[selectedRegionalId] || [], 'Unit');
                if (selectedRegionalId) showAddUserFilterWithAnimation('unitFilter');
                else hideFiltersAfterAddUser('regional');
                 if (!selectedRegionalId) {
                    hideFiltersAfterAddUser('unit');
                    hideFiltersAfterAddUser('department');
                }
            });

            addUserForm.elements.unit.addEventListener('change', function() {
                const selectedUnitId = this.value;
                populateAddUserSelect(addUserForm.elements.department, addUserFilterData.departments[selectedUnitId] || [], 'Department');
                if (selectedUnitId) showAddUserFilterWithAnimation('departmentFilter');
                else hideFiltersAfterAddUser('unit');
                 if (!selectedUnitId) {
                    hideFiltersAfterAddUser('department');
                }
            });
             addUserForm.elements.department.addEventListener('change', function() {
                const selectedDeptId = this.value; 
                populateAddUserSelect(addUserForm.elements.location, addUserFilterData.locations[selectedDeptId] || [], 'Location');
                if (selectedDeptId) showAddUserFilterWithAnimation('locationFilter');
                else hideFiltersAfterAddUser('department');
            });
        }

        // --- Schedule Training Modal Logic ---
        function setupScheduleTrainingModal() {
            const confirmBtn = document.getElementById('confirmScheduleBtn');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', handleConfirmSchedule);
            }
             // Close button inside modal is handled by generic setupModalClosers
        }

        function openScheduleTrainingModal() {
            const employeeSelect = document.getElementById('scheduleEmployeeSelect');
            const dateInput = document.getElementById('scheduleTrainingDate');
            if (!employeeSelect || !dateInput) return;

            employeeSelect.innerHTML = ''; // Clear previous options
            const visibleData = getVisibleTrainingData();
            const employeesToSchedule = Object.values(visibleData)
                .filter(emp => !emp.isDeactivated) // Only active employees
                .sort((a, b) => (a.name || '').localeCompare(b.name || ''));

            if (employeesToSchedule.length === 0) {
                employeeSelect.innerHTML = '<option value="" disabled>No active employees found in your current view to schedule.</option>';
            } else {
                employeesToSchedule.forEach(emp => {
                    const option = document.createElement('option');
                    option.value = emp.empId;
                    option.textContent = `${emp.name} (${emp.empId})`;
                    employeeSelect.appendChild(option);
                });
            }

            // Set default date to e.g., 7 days from now
            const defaultDate = new Date();
            defaultDate.setDate(defaultDate.getDate() + 7);
            dateInput.value = defaultDate.toISOString().split('T')[0];

            showModal('scheduleTrainingModal');
        }

        function handleConfirmSchedule() {
            const employeeSelect = document.getElementById('scheduleEmployeeSelect');
            const dateInput = document.getElementById('scheduleTrainingDate');
            const selectedEmpIds = Array.from(employeeSelect.selectedOptions).map(opt => opt.value);
            const scheduledDate = dateInput.value;

            if (selectedEmpIds.length === 0) {
                alert("Please select at least one employee.");
                return;
            }
            if (!scheduledDate) {
                alert("Please select a training date.");
                return;
            }

            let scheduledCount = 0;
            selectedEmpIds.forEach(empId => {
                if (trainingData[empId]) {
                    trainingData[empId].nextScheduledDate = scheduledDate;
                    trainingData[empId].status = 'pending'; // Mark as pending for scheduled training
                    // Clear previous completed training details if any
                    trainingData[empId].trainingDate = null;
                    trainingData[empId].certificateValidity = null;
                    trainingData[empId].certificate = null;
                    // Could add a history entry here if needed
                    scheduledCount++;
                }
            });

            if (scheduledCount > 0) {
                alert(`Training scheduled for ${scheduledCount} employee(s) on ${scheduledDate}.`);
                closeModal('scheduleTrainingModal');
                refreshTable();
            } else {
                alert("No employees were scheduled. Please check selection.");
            }
        }


        // --- Mobile Filter Modal Functions ---
        function createMobileFilterGroup(titleText) {
            const groupDiv = document.createElement('div');
            groupDiv.className = 'filter-group';
            const title = document.createElement('h4');
            title.textContent = titleText;
            groupDiv.appendChild(title);
            return groupDiv;
        }

        function populateMobileEmployeeFilter() {
            if (!mobileEmployeeSelectElement) return;

            const currentOrgFilters = mobileFilterState.cascadingOrg;
            const currentSelectedEmpIdInState = mobileFilterState.searchText.empId;

            let eligibleEmployees = [];
            for (const empId in trainingData) {
                const empRecord = trainingData[empId];
                if (empRecord && empRecord.unitName && empRecord.name) {
                    const { corporateEntity, region } = getUnitHierarchyDetails(empRecord.unitName);
                    let orgMatch = true;
                    if (currentOrgFilters.corporate && corporateEntity !== currentOrgFilters.corporate) {
                        orgMatch = false;
                    }
                    if (orgMatch && currentOrgFilters.regional && region !== currentOrgFilters.regional) {
                        orgMatch = false;
                    }
                    if (orgMatch && currentOrgFilters.unit && empRecord.unitName !== currentOrgFilters.unit) {
                        orgMatch = false;
                    }

                    if (orgMatch) {
                        eligibleEmployees.push({ id: empId, name: empRecord.name });
                    }
                }
            }

            eligibleEmployees.sort((a, b) => a.name.localeCompare(b.name));

            mobileEmployeeSelectElement.innerHTML = '<option value="">-- All Employees --</option>';
            let isCurrentSelectionStillValid = false;
            eligibleEmployees.forEach(emp => {
                const option = document.createElement('option');
                option.value = emp.id;
                option.textContent = `${emp.id} - ${emp.name}`;
                mobileEmployeeSelectElement.appendChild(option);
                if (emp.id === currentSelectedEmpIdInState) {
                    isCurrentSelectionStillValid = true;
                }
            });

            if (isCurrentSelectionStillValid) {
                mobileEmployeeSelectElement.value = currentSelectedEmpIdInState;
            } else {
                if (currentSelectedEmpIdInState) {
                     mobileFilterState.searchText.empId = '';
                     mobileFilterState.searchText.name = ''; 
                }
                mobileEmployeeSelectElement.value = "";
            }
        }

        function openMobileFilterModal() {
            const filterContainer = document.getElementById('mobile-filter-options-container');
            filterContainer.innerHTML = '';


            const orgGroup = createMobileFilterGroup('Filter by Organization');
            const selects = {};

            const populateCascadingSelect = (selectElement, items, placeholder, currentValue) => {
                selectElement.innerHTML = `<option value="">All ${placeholder}s</option>`;
                if (items && items.length > 0) {
                    items.forEach(item => {
                        const option = document.createElement('option');
                        option.value = typeof item === 'string' ? item : item.id;
                        option.textContent = typeof item === 'string' ? item : item.name;
                        selectElement.appendChild(option);
                    });
                }
                selectElement.value = currentValue || "";
            };

            const corporateLabel = document.createElement('label'); corporateLabel.textContent = 'Corporate:';
            selects.corporate = document.createElement('select');
            const corps = Object.keys(unitHierarchy).sort();
            populateCascadingSelect(selects.corporate, corps.map(c => ({id: c, name: c})), 'Corporate', mobileFilterState.cascadingOrg.corporate);
            orgGroup.appendChild(corporateLabel); orgGroup.appendChild(selects.corporate);

            const regionalLabel = document.createElement('label'); regionalLabel.textContent = 'Regional:';
            selects.regional = document.createElement('select');
            orgGroup.appendChild(regionalLabel); orgGroup.appendChild(selects.regional);

            const unitLabel = document.createElement('label'); unitLabel.textContent = 'Unit:';
            selects.unit = document.createElement('select');
            orgGroup.appendChild(unitLabel); orgGroup.appendChild(selects.unit);


            selects.corporate.addEventListener('change', function() {
                mobileFilterState.cascadingOrg.corporate = this.value;
                mobileFilterState.cascadingOrg.regional = '';
                mobileFilterState.cascadingOrg.unit = '';
                const regions = this.value ? Object.keys(unitHierarchy[this.value] || {}).sort() : [];
                populateCascadingSelect(selects.regional, regions.map(r => ({id: r, name: r})), 'Regional', '');
                populateCascadingSelect(selects.unit, [], 'Unit', '');
                populateMobileEmployeeFilter();
                applyAllFilters();
            });

            selects.regional.addEventListener('change', function() {
                mobileFilterState.cascadingOrg.regional = this.value;
                mobileFilterState.cascadingOrg.unit = '';
                const selectedCorp = mobileFilterState.cascadingOrg.corporate;
                const units = (selectedCorp && this.value && unitHierarchy[selectedCorp]) ? (unitHierarchy[selectedCorp][this.value] || []).sort() : [];
                populateCascadingSelect(selects.unit, units.map(u => ({id: u, name: u})), 'Unit', '');
                populateMobileEmployeeFilter();
                applyAllFilters();
            });

            selects.unit.addEventListener('change', function() {
                mobileFilterState.cascadingOrg.unit = this.value;
                populateMobileEmployeeFilter();
                applyAllFilters();
            });


            const initialCorp = mobileFilterState.cascadingOrg.corporate;
            const initialRegional = mobileFilterState.cascadingOrg.regional;
            if (initialCorp) {
                const regions = Object.keys(unitHierarchy[initialCorp] || {}).sort();
                populateCascadingSelect(selects.regional, regions.map(r => ({id: r, name: r})), 'Regional', initialRegional);
                if (initialRegional && unitHierarchy[initialCorp] && unitHierarchy[initialCorp][initialRegional]) {
                    const units = (unitHierarchy[initialCorp][initialRegional] || []).sort();
                     populateCascadingSelect(selects.unit, units.map(u => ({id: u, name: u})), 'Unit', mobileFilterState.cascadingOrg.unit);
                } else {
                    populateCascadingSelect(selects.unit, [], 'Unit', '');
                }
            } else {
                populateCascadingSelect(selects.regional, [], 'Regional', '');
                populateCascadingSelect(selects.unit, [], 'Unit', '');
            }
            filterContainer.appendChild(orgGroup);



            const employeeSearchGroup = createMobileFilterGroup('Filter by Employee');
            const empLabel = document.createElement('label');
            empLabel.textContent = 'Employee:';
            mobileEmployeeSelectElement = document.createElement('select');
            mobileEmployeeSelectElement.id = 'mobileEmployeeFilterSelect';

            mobileEmployeeSelectElement.addEventListener('change', function() {
                const selectedEmpId = this.value;
                if (selectedEmpId && trainingData[selectedEmpId]) {
                    mobileFilterState.searchText.empId = trainingData[selectedEmpId].empId;
                    mobileFilterState.searchText.name = ''; 
                     const mobileMainSearch = document.getElementById('mobileSearchInput');
                     if(mobileMainSearch) mobileMainSearch.value = '';
                } else {
                    mobileFilterState.searchText.empId = '';
                }
                applyAllFilters();
            });

            employeeSearchGroup.appendChild(empLabel);
            employeeSearchGroup.appendChild(mobileEmployeeSelectElement);
            filterContainer.appendChild(employeeSearchGroup);

            populateMobileEmployeeFilter();


            const statusTh = document.querySelector('#currentTrainingsTable thead th[data-column-id="status"]');
            if (statusTh) {
                const statusGroup = createMobileFilterGroup('Certification Status');
                const optionsListDiv = document.createElement('div');
                optionsListDiv.className = 'filter-options-list';

                const uniqueStatusValues = new Set();
                const currentVisibleData = getVisibleTrainingData();
                Object.values(currentVisibleData).forEach(empData => {
                    let statusText = (calculateOverallStatus(empData, false).status || 'pending');
                    statusText = statusText === 'overdue' ? 'Expired' : statusText.charAt(0).toUpperCase() + statusText.slice(1);
                    if (empData.status === 'pending' && empData.nextScheduledDate) {
                        statusText += ` (Next Scheduled Date: ${empData.nextScheduledDate})`;
                    }
                    if (empData.isDeactivated) {
                        statusText += ` (Deactivated`;
                        if (empData.deactivationDate) statusText += ` on ${empData.deactivationDate}`;
                        statusText += `)`;
                    }
                    uniqueStatusValues.add(statusText);
                });
                const statusOrder = Array.from(uniqueStatusValues).sort();


                const currentStatusFilterValues = getActiveFilterValueForColumn(statusTh, 'values') || [];

                statusOrder.forEach(optVal => {
                    const label = document.createElement('label');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = optVal;
                    if (currentStatusFilterValues.includes(optVal)) checkbox.checked = true;
                    checkbox.addEventListener('change', () => applyMobileCheckboxFilter(statusTh, 'status', optionsListDiv));
                    label.appendChild(checkbox);
                    label.appendChild(document.createTextNode(` ${optVal}`));
                    optionsListDiv.appendChild(label);
                });
                statusGroup.appendChild(optionsListDiv);
                filterContainer.appendChild(statusGroup);
            }



            const tableHeaders = document.querySelectorAll('#currentTrainingsTable thead th[data-column]');
            tableHeaders.forEach(th => {
                const columnIndex = parseInt(th.dataset.column, 10);
                const columnId = th.dataset.columnId;
                const filterType = determineFilterType(columnIndex);
                const headerText = th.firstChild?.textContent?.trim() || th.textContent.trim();


                if (columnId === 'status' || columnId === 'unitName' || columnId === 'empId' || columnId === 'name' || !filterType || !headerText || columnIndex === 14 ) {
                    return;
                }

                const groupDiv = createMobileFilterGroup(headerText.replace(/\s*<i.*<\/i>/, '').trim());

                if (filterType === 'date') {
                     let prefix = '';
                        if (columnIndex === 8) prefix = 'dob'; else if (columnIndex === 9) prefix = 'doj'; else if (columnIndex === 12) prefix = 'trainingDate';
                    const currentFilterValue = getActiveFilterValueForColumn(th);

                    const fromLabel = document.createElement('label'); fromLabel.textContent = "From:";
                    const dateFromInput = document.createElement('input'); dateFromInput.type = 'date';
                    dateFromInput.dataset.dateType = "from";
                    if(currentFilterValue && currentFilterValue.from) dateFromInput.value = currentFilterValue.from;
                    dateFromInput.addEventListener('change', () => applyMobileDateFilter(th, filterType, dateFromInput, groupDiv.querySelector(`input[data-date-type="to"]`)));

                    const toLabel = document.createElement('label'); toLabel.textContent = "To:";
                    const dateToInput = document.createElement('input'); dateToInput.type = 'date';
                    dateToInput.dataset.dateType = "to";
                    if(currentFilterValue && currentFilterValue.to) dateToInput.value = currentFilterValue.to;
                    dateToInput.addEventListener('change', () => applyMobileDateFilter(th, filterType, groupDiv.querySelector(`input[data-date-type="from"]`), dateToInput));

                    groupDiv.appendChild(fromLabel); groupDiv.appendChild(dateFromInput);
                    groupDiv.appendChild(toLabel); groupDiv.appendChild(dateToInput);
                } else if (['checkbox', 'certificateStatus'].includes(filterType)) {
                    const optionsListDiv = document.createElement('div');
                    optionsListDiv.className = 'filter-options-list';
                    let options = [];
                    if (filterType === 'certificateStatus') {
                        options = ['Uploaded', 'Not uploaded'];
                    } else {
                        const uniqueValues = new Set();
                        const tableBody = document.getElementById('current-trainings-body');
                        if (tableBody) {
                            Array.from(tableBody.rows).forEach(row => {
                                if (!row.classList.contains('new-record-edit') && !row.querySelector('td[colspan]')) {
                                    if (row.cells.length > columnIndex) {
                                        const cell = row.cells[columnIndex];
                                        let value = cell.querySelector('select') ? (cell.querySelector('select').options[cell.querySelector('select').selectedIndex]?.textContent.trim() || cell.querySelector('select').value) : cell.textContent.trim();
                                        if (value && value !== '--' && value !== '-' && value !== 'N/A') uniqueValues.add(value);
                                        else uniqueValues.add('(Empty)');
                                    }
                                }
                            });
                        }
                        options = Array.from(uniqueValues).sort((a,b) => a === '(Empty)' ? -1 : b === '(Empty)' ? 1 : a.localeCompare(b));
                    }
                    const currentFilterValues = getActiveFilterValueForColumn(th, 'values') || [];
                    options.forEach(optVal => {
                        const label = document.createElement('label');
                        const checkbox = document.createElement('input'); checkbox.type = 'checkbox'; checkbox.value = optVal;
                        if(currentFilterValues.includes(optVal)) checkbox.checked = true;
                        checkbox.addEventListener('change', () => applyMobileCheckboxFilter(th, filterType, optionsListDiv));
                        label.appendChild(checkbox); label.appendChild(document.createTextNode(` ${optVal}`));
                        optionsListDiv.appendChild(label);
                    });
                    if(options.length === 0) optionsListDiv.innerHTML = '<span style="font-style: italic; color: var(--dark-gray)">No options available</span>';
                    groupDiv.appendChild(optionsListDiv);
                }
                filterContainer.appendChild(groupDiv);
            });

            const mobileClearAllBtn = document.getElementById('mobileClearAllTableFiltersBtn');
            if (mobileClearAllBtn) {
                mobileClearAllBtn.onclick = () => {
                    clearAllColumnFilters();
                    mobileFilterState.searchText = { empId: '', name: '' };
                    mobileFilterState.cascadingOrg = { corporate: '', regional: '', unit: '' };
                     const mobileMainSearch = document.getElementById('mobileSearchInput');
                    if(mobileMainSearch) mobileMainSearch.value = '';


                    openMobileFilterModal(); 
                };
            }
            showModal('mobileFilterModal');
        }


        function getActiveFilterValueForColumn(th, key = null) {
            if (th.dataset.filterActive === 'true' && th.dataset.filterValue) {
                try {
                    const config = JSON.parse(th.dataset.filterValue);
                    return key ? config[key] : config;
                } catch (e) { return key === 'values' ? [] : null; }
            }
            return key === 'values' ? [] : null;
        }

        function applyMobileColumnFilter(thElement, filterType, value) {
            let isActiveFilter = false;
            let filterData = {};

            if (filterType === 'unit_column_filter') { 
                if (value) { filterData = { type: 'unit_column_filter', unit: value }; isActiveFilter = true; }
            }

            thElement.dataset.filterActive = isActiveFilter ? 'true' : 'false';
            thElement.dataset.filterType = isActiveFilter ? filterData.type : '';
            thElement.dataset.filterValue = isActiveFilter ? JSON.stringify(filterData) : '';

            applyAllFilters();
        }

        function applyMobileDateFilter(thElement, filterType, fromInput, toInput) {
            const fromV = fromInput.value || '';
            const toV = toInput.value || '';
            let isActiveFilter = false;
            let filterData = {};

            if (fromV || toV) { filterData = { type: 'date', from: fromV, to: toV }; isActiveFilter = true; }

            thElement.dataset.filterActive = isActiveFilter ? 'true' : 'false';
            thElement.dataset.filterType = isActiveFilter ? filterData.type : '';
            thElement.dataset.filterValue = isActiveFilter ? JSON.stringify(filterData) : '';
            applyAllFilters();
        }

        function applyMobileCheckboxFilter(thElement, filterType, optionsListDiv) {
            const selectedCheckboxes = Array.from(optionsListDiv.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);
            let isActiveFilter = false;
            let filterData = {};

            if (selectedCheckboxes.length > 0) { filterData = { type: filterType, values: selectedCheckboxes }; isActiveFilter = true; }

            thElement.dataset.filterActive = isActiveFilter ? 'true' : 'false';
            thElement.dataset.filterType = isActiveFilter ? filterData.type : '';
            thElement.dataset.filterValue = isActiveFilter ? JSON.stringify(filterData) : '';
            applyAllFilters();
        }

    </script>
    
    
    <script>
        function showHistoryModal(licenseNumber) {
            let url = '{{route("UnitFocHistory")}}';
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
    </script>

<script>
  $(document).ready(function () {
    $('#participants').multiselect({
      nonSelectedText: 'Select Participants',
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      buttonWidth: '100%'
    });
  });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const employeeCheckboxes = document.querySelectorAll('input[name="employees"]');
        const selectedEmployeesSummaryDiv = document.getElementById('selected-employees-summary');
        const selectedCountSpan = document.getElementById('selected-count');
        const employeeSearchInput = document.getElementById('employee-search');
        const employeeItems = document.querySelectorAll('.employee-list-container .employee-item');
        
        const MAX_DISPLAY_NAMES_IN_SUMMARY = 3; 

        function updateSelectedEmployeesSummary() {
            const selectedEmployees = Array.from(employeeCheckboxes)
                                         .filter(cb => cb.checked)
                                         .map(cb => {
                                             const label = document.querySelector(label[for="${cb.id}"]);
                                             return label ? label.textContent.trim() : cb.value;
                                         });

            const count = selectedEmployees.length;
            selectedCountSpan.textContent = count;

            if (count === 0) {
                selectedEmployeesSummaryDiv.textContent = 'None selected.';
                selectedEmployeesSummaryDiv.style.color = '#6c757d';
            } else {
                let summaryText = '';
                if (count <= MAX_DISPLAY_NAMES_IN_SUMMARY) {
                    summaryText = selectedEmployees.join(', ');
                } else {
                    const firstFew = selectedEmployees.slice(0, MAX_DISPLAY_NAMES_IN_SUMMARY -1).join(', ');
                    const remainingCount = count - (MAX_DISPLAY_NAMES_IN_SUMMARY -1);
                    summaryText = ${firstFew}, ... and ${remainingCount} more;
                }
                selectedEmployeesSummaryDiv.textContent = summaryText;
                selectedEmployeesSummaryDiv.style.color = '#333';
            }
        }

        function handleEmployeeSearch() {
            const searchTerm = employeeSearchInput.value.toLowerCase();
            employeeItems.forEach(item => {
                const label = item.querySelector('label');
                const itemName = label ? label.textContent.toLowerCase() : '';
                if (itemName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        updateSelectedEmployeesSummary(); // Initial call

        employeeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedEmployeesSummary);
        });

        if (employeeSearchInput) {
            employeeSearchInput.addEventListener('input', handleEmployeeSearch);
        }

        const closeButton = document.querySelector('.modal-header .close-button');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                const modalElement = document.querySelector('.modal-overlay');
                if (modalElement) {
                    modalElement.style.display = 'none';
                }
            });
        }

        const cancelButton = document.querySelector('.btn-cancel');
        if (cancelButton) {
            cancelButton.addEventListener('click', () => {
                document.getElementById('scheduleTrainingForm').reset();
                if (employeeSearchInput) employeeSearchInput.value = ''; // Clear search
                handleEmployeeSearch(); // Re-show all items after clearing search
                updateSelectedEmployeesSummary();
                alert('Form cancelled and reset. (Modal remains visible for demo)');
            });
        }
        
        const form = document.getElementById('scheduleTrainingForm');
        if(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 
                
                const selectedEmployeesData = Array.from(document.querySelectorAll('input[name="employees"]:checked'))
                                             .map(cb => {
                                                 const label = document.querySelector(label[for="${cb.id}"]);
                                                 return label ? label.textContent.trim() : cb.value;
                                             });
                const fromDate = document.getElementById('from-date').value;
                const fromTime = document.getElementById('from-time').value;
                const toDate = document.getElementById('to-date').value;
                const toTime = document.getElementById('to-time').value;
                
                let errors = [];
                if (selectedEmployeesData.length === 0) {
                    errors.push('Please select at least one employee.');
                }
                if (!fromDate) {
                    errors.push('Please select a "From" date.');
                }
                if (!fromTime) {
                    errors.push('Please select a "From" time.');
                }
                if (!toDate) {
                     errors.push('Please select a "To" date.');
                }
                if (!toTime) {
                     errors.push('Please select a "To" time.');
                }
                if (fromDate && fromTime && toDate && toTime) {
                    const fromDateTime = new Date(${fromDate}T${fromTime});
                    const toDateTime = new Date(${toDate}T${toTime});
                    if (toDateTime <= fromDateTime) {
                        errors.push('"To" date and time must be after "From" date and time.');
                    }
                }

                if (errors.length > 0) {
                    alert("Please correct the following errors:\n\n- " + errors.join('\n- '));
                    return;
                }

                const summary = `Training Scheduled!\n
Employees:
- ${selectedEmployeesData.join('\n- ')}

From: ${fromDate} at ${fromTime}
To:   ${toDate} at ${toTime}`;
                
                alert(summary);
                
                // Optionally, reset form fully after submission:
                // form.reset();
                // if (employeeSearchInput) employeeSearchInput.value = ''; 
                // handleEmployeeSearch(); 
                // updateSelectedEmployeesSummary();
            });
        }
    });
</script>

<script>
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
</script>


<!-- jQuery -->
<!-- jQuery (must come first) -->



@endsection
   