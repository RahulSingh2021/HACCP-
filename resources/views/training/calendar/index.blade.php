<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Training Calendar | efsms</title>
    
    <!-- Favicon -->
    <link rel="icon" href="https://efsm.safefoodmitra.com/admin/public/assets/images/logo-icon.png" type="image/png" />
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    
    <!-- Flatpickr for date/time picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #17a00e;
            --primary-light: #e8f5e9;
            --secondary-color: #2c3e50;
            --accent-color: #3498db;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #6c757d;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .card {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            margin-bottom: 20px;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: 0 10px 15px rgba(0,0,0,0.1), 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0;
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn .badge {
            position: relative;
            top: -1px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 8px 20px;
        }
        
        .btn-primary:hover {
            background-color: #148a0c;
            border-color: #148a0c;
            transform: translateY(-1px);
        }
        
        .btn-outline-secondary {
            border-color: var(--medium-gray);
            color: var(--dark-gray);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--medium-gray);
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.85rem;
        }
        
        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table th {
            font-weight: 600;
            color: var(--secondary-color);
            background-color: var(--light-gray);
            border-top: 1px solid #dee2e6;
            padding: 12px 15px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
            border-top: 1px solid #f0f0f0;
        }
        
        .table tr:hover td {
            background-color: var(--primary-light);
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            font-size: 0.85rem;
            border-radius: 4px;
        }
        
        .badge-primary {
            background-color: var(--primary-color);
        }
        
        .badge-secondary {
            background-color: var(--medium-gray);
            color: var(--dark-gray);
        }
        
        .badge-online {
            background-color: var(--accent-color);
            color: white;
        }
        
        .badge-recorded {
            background-color: var(--info-color);
            color: white;
        }

        .qrcode-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: white;
            padding: 5px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            transition: var(--transition);
            cursor: pointer;
        }
        
        .qrcode-img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .attendance-stats {
            font-size: 0.9rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .pagination .page-link {
            color: var(--primary-color);
            border-radius: 6px;
            margin: 0 3px;
            min-width: 38px;
            text-align: center;
        }
        
        .pagination .page-link:hover {
            background-color: var(--primary-light);
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .modal-footer {
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        
        .form-control, .form-select {
            border-radius: 6px;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(23, 160, 14, 0.25);
        }
        
        .bootstrap-select .dropdown-toggle {
            border-radius: 6px !important;
            padding: 8px 12px !important;
            border: 1px solid #e0e0e0 !important;
        }

        .bootstrap-select.is-invalid .dropdown-toggle {
            border-color: var(--danger-color) !important;
        }
        
        .view-toggle {
            display: flex;
            background: white;
            border-radius: 6px;
            padding: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .view-toggle-btn {
            padding: 6px 12px;
            border: none;
            background: transparent;
            font-weight: 500;
            color: var(--dark-gray);
            border-radius: 4px;
            transition: var(--transition);
        }
        
        .view-toggle-btn.active {
            background: var(--primary-color);
            color: white;
        }
        
        .training-status {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
        }
        
        .status-upcoming {
            background-color: var(--warning-color);
        }
        
        .status-completed {
            background-color: var(--primary-color);
        }
        
        .status-ongoing {
            background-color: var(--accent-color);
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .modal.fade .modal-dialog {
            animation: fadeIn 0.3s ease-out;
        }
        .bg-purple {
            background-color: #6f42c1;
        }
        .handwritten-text {
            font-family: 'Caveat', cursive;
            color: #0d6efd;
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>

    <!-- CSS for Participant Management Modal -->
    <style>
        .manage-participants-modal-body {
            --primary-color: #4f46e5;
            --border-color: #e5e7eb;
            --text-color-light: #6b7280;
            --text-color-dark: #111827;
            --background-color: #f9fafb;
            --surface-color: #ffffff;
            --green: #22c55e;
            --red: #ef4444;
            --gray: #9ca3af;
        }
        .manage-participants-modal-body * { box-sizing: border-box; }
        .manage-participants-modal-body .main-container {
            width: 100%;
            height: 100%;
            background-color: var(--surface-color);
            overflow: hidden;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .manage-participants-modal-body .table-header { padding: 1rem 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); }
        .manage-participants-modal-body .table-header h1 { font-size: 1.25rem; font-weight: 600; margin-bottom: 0;}
        .manage-participants-modal-body .header-left { display: flex; align-items: center; gap: 1rem; }
        .manage-participants-modal-body .roster-counts { display: flex; gap: 0.75rem; }
        .manage-participants-modal-body .roster-counts .badge { font-size: 0.8rem; padding: 0.4em 0.8em; }
        
        .manage-participants-modal-body .header-controls { display: flex; align-items: center; gap: 1rem; }
        .manage-participants-modal-body .bulk-action-controls { display: flex; gap: 0.75rem; }
        .manage-participants-modal-body .btn { padding: 0.6rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--surface-color); font-size: 0.9rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-color-dark); transition: all 0.2s; }
        .manage-participants-modal-body .btn-primary { background-color: var(--primary-color); color: white; border-color: var(--primary-color); }
        .manage-participants-modal-body .btn-primary:hover { background-color: #3f3da3; }
        .manage-participants-modal-body .btn-secondary { background-color: #f0f0f0; border: 1px solid #ddd; color: #555; }
        .manage-participants-modal-body .btn-secondary:hover { background-color: #e0e0e0; }
        .manage-participants-modal-body #add-new-employee-btn:hover, .manage-participants-modal-body #upload-file-btn:hover, .manage-participants-modal-body .bulk-status-btn:hover:not(:disabled) { background-color: #f3f4f6; border-color: var(--primary-color); }
        .manage-participants-modal-body .bulk-status-btn .fa-check { color: var(--green); }
        .manage-participants-modal-body .bulk-status-btn .fa-times { color: var(--red); }
        .manage-participants-modal-body .bulk-status-btn { display: none; } /* Hide by default, show with JS */
        
        .manage-participants-modal-body .search-add-wrapper { position: relative; width: 350px; }
        .manage-participants-modal-body .search-input-container .fa-magnifying-glass { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-color-light); }
        .manage-participants-modal-body #employee-search-input { width: 100%; padding: 0.6rem 0.75rem 0.6rem 2.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s; }
        .manage-participants-modal-body #employee-search-input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .manage-participants-modal-body .search-results-container { position: absolute; top: calc(100% + 8px); left: 0; right: 0; background-color: var(--surface-color); border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 10; list-style: none; padding: 0; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s; display: flex; flex-direction: column; }
        .manage-participants-modal-body .search-results-container.visible { opacity: 1; visibility: visible; transform: translateY(0); }
        .manage-participants-modal-body #search-actions-container { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 1rem; background-color: #f9fafb; }
        .manage-participants-modal-body .actions-bar { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .manage-participants-modal-body #selected-for-addition-preview { width: 100%; display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.75rem; }
        .manage-participants-modal-body .selected-preview-tag { display: flex; align-items: center; gap: 0.5rem; background-color: #e0e7ff; color: var(--primary-color); padding: 0.25rem 0.6rem; border-radius: 16px; font-size: 0.8rem; font-weight: 500; }
        .manage-participants-modal-body .remove-tag-btn { cursor: pointer; font-weight: bold; font-size: 1rem; line-height: 1; transition: color 0.2s; }
        .manage-participants-modal-body .remove-tag-btn:hover { color: var(--red); }
        .manage-participants-modal-body #search-results-list { max-height: 250px; overflow-y: auto; padding: 0.5rem; margin:0; }
        .manage-participants-modal-body #search-results-list li { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem; cursor: pointer; border-radius: 6px; transition: background-color 0.15s; }
        .manage-participants-modal-body #search-results-list li:hover { background-color: #f3f4f6; }
        .manage-participants-modal-body .result-name { font-weight: 500; display: block; margin-bottom: 0.25rem; }
        .manage-participants-modal-body .result-details { font-size: 0.8rem; color: var(--text-color-light); }
        .manage-participants-modal-body .no-results { padding: 1rem; text-align: center; color: var(--text-color-light); }
        .manage-participants-modal-body .select-all-container { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
        .manage-participants-modal-body #bulk-add-btn { background-color: var(--primary-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .manage-participants-modal-body #bulk-add-btn:disabled { background-color: #a5b4fc; cursor: not-allowed; }
        
        .manage-participants-modal-body .table-wrapper { overflow-y: auto; flex-grow: 1; }
        .manage-participants-modal-body .table-wrapper table { width: 100%; border-collapse: collapse; }
        .manage-participants-modal-body input[type="checkbox"] { width: 16px; height: 16px; border-radius: 4px; border: 1px solid #ccc; cursor: pointer; }
        .manage-participants-modal-body .avatar { width: 48px; height: 48px; border-radius: 50%; background-color: #e0e7ff; color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.1rem; flex-shrink: 0; }
        
        /* Styles for employee card row */
        .manage-participants-modal-body .employee-card-list-item td {
            border-bottom: 1px solid var(--border-color);
            padding: 0;
            background-color: #fff;
        }
        .manage-participants-modal-body .employee-card-list-item:last-child td {
            border-bottom: none;
        }
        .manage-participants-modal-body .employee-card-list-item:hover td {
             background-color: #f8fafc;
        }
        .employee-card-row {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            width: 100%;
        }
        .employee-card-row strong {
            font-weight: 600;
            color: var(--text-color-dark);
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        .employee-card-row > div {
            color: var(--text-color-light);
        }
        .card-col-select {
            flex-shrink: 0;
        }
        .card-col-org {
            flex: 1 1 150px;
            min-width: 120px;
        }
        .card-col-main-info {
            flex: 2 1 380px;
            min-width: 350px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .card-col-main-info .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.25rem 1rem;
            font-size: 0.8rem;
        }
        .card-col-main-info .details-grid i {
            margin-right: 0.4rem;
            width: 12px;
            text-align: center;
        }
        .card-col-contact, .card-col-role, .card-col-category {
            flex: 1 1 190px;
            min-width: 160px;
        }
        .card-col-contact span, .card-col-role span, .card-col-category span {
            display: block;
            margin-bottom: 0.25rem;
        }
        .card-col-contact i {
            margin-right: 0.5rem;
            width: 12px;
        }
        .card-col-status {
            flex: 0 0 210px;
        }
        .card-col-actions {
            flex-shrink: 0;
            text-align: center;
        }
        .card-col-actions .icon {
            cursor: pointer;
            color: var(--red);
            font-size: 1rem;
            transition: transform 0.2s;
        }
        .card-col-actions .icon:hover {
            transform: scale(1.1);
        }

        .status-slider-container { position: relative; width: 210px; height: 30px; user-select: none; }
        .status-slider-track { display: flex; justify-content: space-around; align-items: center; width: 100%; height: 100%; background-color: #e9ecef; border-radius: 15px; position: relative; overflow: hidden; }
        .status-slider-label { flex: 1; text-align: center; font-size: 0.8rem; font-weight: 600; color: #495057; cursor: pointer; z-index: 2; transition: color 0.3s ease; }
        .status-slider-thumb { position: absolute; top: 2px; bottom: 2px; width: calc(100% / 3 - 4px); background-color: var(--gray); border-radius: 13px; z-index: 1; transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), background-color 0.3s ease; left: 2px; }
        .status-slider-container.status-neutral .status-slider-thumb { transform: translateX(100%); background-color: var(--gray); }
        .status-slider-container.status-neutral .status-slider-label[data-value="neutral"] { color: white; }
        .status-slider-container.status-present .status-slider-thumb { transform: translateX(200%); background-color: var(--green); }
        .status-slider-container.status-present .status-slider-label[data-value="present"] { color: white; }
        .status-slider-container.status-absent .status-slider-thumb { transform: translateX(0%); background-color: var(--red); }
        .status-slider-container.status-absent .status-slider-label[data-value="absent"] { color: white; }

        .manage-participants-modal-body .table-footer { background-color: #f9fafb; padding: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 10px; }
        .manage-participants-modal-body .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); display: none; justify-content: center; align-items: center; z-index: 1060; padding: 20px; }
        .manage-participants-modal-body .modal-overlay.visible { display: flex; }
        .manage-participants-modal-body .form-container { background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); max-width: 800px; width: 100%; max-height: 90vh; display: flex; flex-direction: column; }
        .manage-participants-modal-body .form-header { background-color: var(--primary-color); color: #ffffff; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .manage-participants-modal-body .form-header h2 { margin: 0; font-size: 1.25rem; font-weight: 500; }
        .manage-participants-modal-body .close-btn { background: none; border: none; color: #ffffff; font-size: 1.5rem; font-weight: bold; cursor: pointer; line-height: 1; }
        .manage-participants-modal-body .form-body { padding: 20px 30px; overflow-y: auto; }
        .manage-participants-modal-body .form-section { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #e7e7e7; }
        .manage-participants-modal-body .form-section:last-of-type { border-bottom: none; margin-bottom: 0; }
        .manage-participants-modal-body .form-section h3 { font-size: 1rem; color: var(--primary-color); margin: 0 0 20px 0; font-weight: 500; display: flex; align-items: center; }
        .manage-participants-modal-body .form-section h3 i { margin-right: 10px; font-size: 1.1rem; }
        .manage-participants-modal-body .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 30px; }
        .manage-participants-modal-body .form-group { display: flex; flex-direction: column; }
        .manage-participants-modal-body .form-group label { margin-bottom: 6px; font-size: 0.875rem; color: #555; }
        .manage-participants-modal-body .form-container input[type="text"], .manage-participants-modal-body .form-container input[type="email"], .manage-participants-modal-body .form-container input[type="date"], .manage-participants-modal-body .form-container select { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9rem; box-sizing: border-box; background-color: #fff; color: #444; }
        .manage-participants-modal-body .form-container input::placeholder { color: #aaa; }
        .manage-participants-modal-body .form-container select { -webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 10px center; background-size: 1em; padding-right: 2.5em; }
        .manage-participants-modal-body .form-container select:disabled { background-color: #e9ecef; cursor: not-allowed; }
        .manage-participants-modal-body .form-footer { background-color: #f9f9f9; padding: 15px 30px; border-top: 1px solid #e7e7e7; display: flex; justify-content: flex-end; gap: 10px; flex-shrink: 0; }
        
        #pdf-review-section { background-color: #fdfdfe; border-bottom: 1px solid var(--border-color); }
        #pdf-review-section h4 { color: var(--text-color-dark); font-weight: 600; }
        #pdf-review-section .table-responsive { max-height: 50vh; border: 1px solid var(--border-color); border-radius: 8px; }
        #pdf-review-section .table { --bs-table-bg: var(--bs-body-bg); }
        #pdf-review-section td, #pdf-review-section th { padding: 1rem; vertical-align: top; }
        #pdf-review-section .imported-info .name { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; }
        #pdf-review-section .imported-info .imported-details { display: flex; flex-wrap: wrap; gap: 0.5rem 1.5rem; font-size: 0.85rem; margin-top: 0.5rem; }
        #pdf-review-section .imported-info .imported-details > div { display: flex; align-items: center; gap: 0.5rem; }
        #pdf-review-section .imported-info .imported-details small { color: var(--text-color-light); font-weight: 500; }
        #pdf-review-section .imported-info span[contenteditable="true"] { padding: 2px 5px; border-radius: 4px; background-color: #fef9c3; border-bottom: 1px dashed #d1c782; cursor: text; }
        #pdf-review-section .imported-info span[contenteditable="true"]:focus { background-color: #fff; outline: 2px solid var(--primary-color); box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .suggestions-container { background-color: #f8fafc; border-radius: 6px; padding: 0.75rem; }
        .suggestions-container h6 { font-size: 0.8rem; font-weight: 600; color: var(--text-color-light); text-transform: uppercase; margin-bottom: 0.5rem; }
        .suggestion-link { display: block; padding: 0.5rem 0.75rem; border-radius: 4px; color: var(--accent-color); text-decoration: none; margin-bottom: 4px; background-color: #fff; border: 1px solid #e9ecef; cursor: pointer; transition: all 0.2s ease; font-size: 0.85rem; }
        .suggestion-link:hover { background-color: var(--primary-light); color: var(--primary-color); border-color: var(--primary-color); transform: translateX(3px); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .suggestion-link .badge { font-size: 0.7em; }
        .no-suggestions { color: var(--text-color-light); font-style: italic; padding: 0.5rem; }
        .action-cell { text-align: center; display: flex; gap: 5px; justify-content: flex-start; align-items: center; padding-top: 1rem !important; }
        .popover-header { background-color: var(--secondary-color); color: white; font-weight: 600; }
        .popover-body { font-size: 0.85rem; }

        /* Styles for review dropdowns */
        .imported-details .form-select-sm {
            padding-top: 0.2rem;
            padding-bottom: 0.2rem;
            min-width: 150px;
        }

    </style>
    
    <!-- CSS for Table Header Filters -->
    <style>
        .table th .header-content { display: flex; justify-content: space-between; align-items: center; gap: 8px; }
        .filter-icon { cursor: pointer; transition: color 0.2s; font-size: 0.8em; }
        .filter-icon:hover { color: var(--primary-color) !important; }
        .th-filter-dropdown { width: 280px; box-shadow: 0 5px 15px rgba(0,0,0,0.15); border: 1px solid #ddd; z-index: 1050; }
        .th-filter-dropdown-wide { width: 450px; max-width: 450px; }
        .th-filter-dropdown .form-check-label { font-weight: 400; color: #333; font-size: 0.9rem; }
        .th-filter-dropdown .filter-options, .th-filter-dropdown .filter-options-main, .th-filter-dropdown .filter-options-sub { max-height: 150px; overflow-y: auto; padding-right: 5px; }
        .th-filter-dropdown .filter-options .form-check, .th-filter-dropdown .filter-options-main .form-check, .th-filter-dropdown .filter-options-sub .form-check { padding-left: 1.7em; margin-bottom: 0.5rem; }
        .th-filter-dropdown .form-control-sm { font-size: 0.85rem; }
        .table th { position: relative; }
        .filter-active { color: var(--primary-color) !important; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h1 class="page-title">Training Calendar</h1>
                            <div class="ms-3 view-toggle">
                                <button class="view-toggle-btn active" data-view="table"><i class="fas fa-table me-1"></i>Table</button>
                                <button class="view-toggle-btn" data-view="calendar"><i class="far fa-calendar-alt me-1"></i>Calendar</button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                           <button class="btn btn-outline-secondary" id="refresh-table-btn"><i class="fas fa-sync-alt me-2"></i>Refresh</button>
                           <!-- MODIFIED BUTTON to trigger modal -->
                           <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exportOptionsModal"><i class="fas fa-file-excel me-2"></i>Export to Excel</button>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTrainingModal"><i class="fas fa-plus me-2"></i>Add Training</button>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-primary text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Total Trainings</h6><h3 class="mb-0" id="total-trainings-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-calendar-alt fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-info text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Upcoming</h6><h3 class="mb-0" id="upcoming-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-clock fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-warning text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Ongoing</h6><h3 class="mb-0" id="ongoing-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-spinner fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-success text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Completed</h6><h3 class="mb-0" id="completed-count">0</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-check-circle fa-2x"></i></div></div></div></div></div>
                             <div class="col-lg col-md-4 col-sm-6 mb-3"><div class="card bg-purple text-white h-100"><div class="card-body"><div class="d-flex justify-content-between align-items-center"><div><h6 class="text-uppercase mb-0">Total Participants</h6><h3 class="mb-0" id="total-participants-count">{{$total_participant ?? 0}}</h3></div><div class="bg-white bg-opacity-25 p-3 rounded-circle"><i class="fas fa-users fa-2x"></i></div></div></div></div></div>
                        </div>
                        
                        <!-- Training List (Table View) -->
                        <div id="tableView">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th data-column-index="1"><div class="header-content"><span>Status</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search" ></div><div class="filter-options"></div><hr class="my-2"><button class="btn btn-sm btn-primary w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th data-column-index="2"><div class="header-content"><span>Mode</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search" ></div><div class="filter-options"></div><hr class="my-2"><button class="btn btn-sm btn-primary w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th data-column-index="3"><div class="header-content"><span>Training Topic & Sub Topic</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown th-filter-dropdown-wide"><div class="row gx-3"><div id="main-topic-wrapper" class="col-12"><h6 class="dropdown-header px-0 small text-uppercase">Main Topic</h6><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search-main" ></div><div class="filter-options-main"></div></div><div id="sub-topic-wrapper" class="col-6" style="display: none;"><h6 class="dropdown-header px-0 small text-uppercase">Sub Topic</h6><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search-sub" ></div><div class="filter-options-sub"></div></div></div><hr class="my-2"><div class="row gx-2"><div class="col"><button class="btn btn-sm btn-outline-secondary w-100 reset-filter-btn">Reset</button></div><div class="col"><button class="btn btn-sm btn-primary w-100 apply-filter-btn">Apply</button></div></div></div></div></div></th>
                                            <th data-column-index="4"><div class="header-content"><span>Trainer</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><input type="search" class="form-control form-control-sm filter-search" ></div><div class="filter-options"></div><hr class="my-2"><button class="btn btn-sm btn-primary w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <!--<th data-column-index="5"><div class="header-content"><span>Time</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><label class="form-label small">From</label><input type="text" class="form-control form-control-sm date-range-from"></div><div class="mb-2"><label class="form-label small">To</label><input type="text" class="form-control form-control-sm date-range-to"></div><hr class="my-2"><button class="btn btn-sm btn-primary w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>-->
                                            <th data-column-index="5"><div class="header-content"><span>Time</span><div class="dropdown"><i class="fas fa-filter text-muted filter-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside"></i><div class="dropdown-menu p-3 th-filter-dropdown"><div class="mb-2"><label class="form-label small">From</label>
                                            <!--<input type="text" class="form-control form-control-sm date-range-from">-->
                                            <input type="datetime-local" class="form-control form-control-sm date-range-from" step="1">
                                            </div><div class="mb-2"><label class="form-label small">To111</label>
                                            <!--<input type="text" class="form-control form-control-sm date-range-to">-->
                                            <input type="datetime-local" class="form-control form-control-sm date-range-to" step="1">
                                            </div><hr class="my-2"><button class="btn btn-sm btn-primary w-100 apply-filter-btn">Apply</button><button class="btn btn-sm btn-outline-secondary w-100 mt-1 reset-filter-btn">Reset</button></div></div></div></th>
                                            <th>Participants</th>
                                            <th>QR Code</th>
                                            <th>Training Sheet</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                           @foreach($lms_list as $lms_lists)
                                        <tr>
                                            <td>{{$loop->index+1}}</td>
                                            <td><span class="training-status status-completed"></span>Completed</td><td><span class="badge bg-primary">{{$lms_lists->course_mode ?? ''}}</span></td>
                                            <td><strong>
                                                @php
                                                    $sopName = null;
                                                    if (!empty($lms_lists->sop_id)) {
                                                        $sopData = DB::table('sops')->where('id', $lms_lists->sop_id)->first();
                                                        $sopName = $sopData->name ?? $lms_lists->sop_id;
                                                    }
                                                @endphp
                                                
                                                @if(!empty($sopName))
                                                    {{ $sopName }}
                                                @else
                                                    {{ Helper::TrainingTopicName($lms_lists->sop_id ?? '') }}
                                                @endif
                                                </strong>
                                                <br/>
                                                <span class="text-muted">
                                                    @if($lms_lists->sub_sop_id)
                                                    {{$lms_lists->sub_sop_id}}
                                                    @else
                                                    --
                                                    @endif
                                                </span>
                                                <div class="text-muted small mt-1">
                                                    @if(!empty($lms_lists->remark))
                                                     ({{$lms_lists->remark ?? ''}})
                                                    @endif
                                                </div></td>
                                                <td>{{$lms_lists->trainer ?? ''}}   @if($lms_lists->company_name) ({{$lms_lists->company_name ?? ''}}) @endif</td>
                                                <td><div class="d-flex flex-column">
                                                    <small class="text-muted">  
                                                @php
                                                    $start = $lms_lists->start_time ? \Carbon\Carbon::parse($lms_lists->start_time) : null;
                                                    $end = $lms_lists->end_time ? \Carbon\Carbon::parse($lms_lists->end_time) : null;
                                                @endphp
                                                
                                                @if ($start && $end)
                                                    @if ($start->toDateString() === $end->toDateString())
                                                        {{ $start->format('d M Y, h:i A') }} to <span>{{ $end->format('h:i A') }}</span>
                                                    @else
                                                        {{ $start->format('d M Y, h:i A') }} to <span>{{ $end->format('d M Y, h:i A') }}</span>
                                                    @endif
                                                @else
                                                    -
                                            <!--data-training-id="489"-->
                                                @endif</small></div></td><td><div class="attendance-stats">
                                                        <button type="button" 
                                            class="btn btn-sm btn-outline-primary open-participants-modal"
                                                             data-training-id="{{$lms_lists->id}}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#manageParticipantsModal">
                                        <i class="fas fa-user-edit me-1"></i>Manage
                                                <span class="badge rounded-pill bg-success ms-2" title="Present">
                                                {{ DB::table('tbl_lms_training_participants')
                                                    ->where('tbl_lms_id', $lms_lists->id)
                                                    ->where('status', 'present')
                                                    ->count() }}

                                
                                                </span>
                                                <span class="badge rounded-pill bg-danger ms-1" title="Absent">
                                                    {{ DB::table('tbl_lms_training_participants')
                                                        ->where('tbl_lms_id', $lms_lists->id)
                                                        ->where('status', 'absent')
                                                        ->count() }}
                                                </span></button></div></td><td>
                                                <img src="{{$lms_lists->qr_code}}" alt="QR Code" style="width: 80px;
                                                height: 80px;
                                                object-fit: contain;
                                                background: white;
                                                padding: 5px;
                                                border: 1px solid var(--medium-gray1);
                                                border-radius: 4px;
                                                transition: var(--transition1);
                                                cursor: pointer;">
                                                </td>
                                                
                                                @if($lms_lists->training_upload_file)
                                                <td><div class="d-flex flex-column"><small class="text-muted">Uploaded:{{$lms_lists->training_upload_file_date ?? ''}}</small>
                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                <a target="_blank()" href="{{$lms_lists->training_upload_file}}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-eye me-1"></i>View</a><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTrainingSheet{{$lms_lists->id}}">
                                                    <i class="fas fa-edit me-1"></i>Edit</button>
                                                    
                                                       <a href="javascript:void(0);" 
                                                           data-id="{{ $lms_lists->id }}" 
                                                           data-url="{{ url('training/calendar/delete-training-pdf/'.$lms_lists->id) }}" 
                                                           class="btn btn-sm btn-outline-danger delete-training">
                                                           <i class="fas fa-trash me-1"></i> Delete
                                                        </a>
                                                    
                                                    </div></div></td>

                                                    <!--<a href="javascript:void(0);" onclick="return confirm('Are you sure you want to delete this item?');" -->
                                                    <!--data-id="{{ $lms_lists->id }}" data-url="https://efsm.safefoodmitra.com/admin/public/index.php/training/calendar/delete/{{$lms_lists->id}}" class="btn btn-sm btn-outline-danger">-->
                                                 
                                                @else
                                                 <td><div class="d-flex flex-column"><small class="text-muted">Not uploaded yet</small><div class="mt-2"><button class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#editTrainingSheet{{$lms_lists->id}}"><i class="fas fa-upload me-1"></i>Upload</button></div></div></td>
                                                @endif
                                                
                                                            
                                                            
                                                <td><div class="action-buttons">
                                                                
                                                                <!--<a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>-->
                                                                <!--<a href="#" onclick="return confirm('Are you sure?');"   data-id="{{ $lms_lists->id }}" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete">-->
                                                               <!--<a href="#" style="border:1px solid blue; color:blue; background:white"  class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTrainingModal{{ $lms_lists->id }}">-->
                                                            
                                                          <button class="btn btn-sm btn-outline-warning edit-training-btn" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editTrainingModal" 
                                                                    data-id="{{ $lms_lists->id }}" 
                                                                    data-fetch-url="{{ route('get.training.calendar.data', $lms_lists->id) }}" 
                                                                    data-update-url="{{ route('update.training.calendar.data', $lms_lists->id) }}">
                                                                <i class="fas fa-edit me-1"></i> 
                                                            </button>
                                                            
                                                            <!--<i class="fas fa-edit"></i>-->
                                                     </a>
                                                     
                                                                
                                                                    <a href="#" 
                                                                       data-id="{{ $lms_lists->id }}"
                                                                       onclick="deleteItem(this); return false;"
                                                                       class="btn btn-sm btn-outline-danger">
                                                                    <i class="fas fa-trash"></i></a></div></td></tr>
                                                                    
                                        <!--<tr><td>2</td><td><span class="training-status status-ongoing"></span>Ongoing</td><td><span class="badge badge-online">Online</span></td><td><strong>Allergen Management</strong><div class="text-muted small mt-1">Identifying Major Allergens</div></td><td>Ms. Priya Sharma</td><td><div class="d-flex flex-column"><small class="text-muted">May 25, 2024</small><span>2:00 PM - 4:00 PM</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="490"><i class="fas fa-user-edit me-1"></i>Manage<span class="badge rounded-pill bg-success ms-2" title="Present">12</span><span class="badge rounded-pill bg-danger ms-1" title="Absent">3</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F490" alt="QR Code" class="qrcode-img" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to enlarge"></td><td><div class="d-flex flex-column"><small class="text-muted">Not uploaded yet</small><div class="mt-2"><button class="btn btn-sm btn-primary"><i class="fas fa-upload me-1"></i>Upload</button></div></div></td><td><div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>-->
                                        <!--<tr><td>3</td><td><span class="training-status status-upcoming"></span>Upcoming</td><td><span class="badge badge-recorded">Recorded</span></td><td><strong>Food Safety Management</strong><div class="text-muted small mt-1">HACCP Level 1: Principles</div></td><td>Dr. Alok Nath</td><td><div class="d-flex flex-column"><small class="text-muted">Jun 05, 2025</small><span>10:00 AM - 12:00 PM</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="491"><i class="fas fa-user-edit me-1"></i>Manage<span class="badge rounded-pill bg-success ms-2" title="Present">0</span><span class="badge rounded-pill bg-danger ms-1" title="Absent">0</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F491" alt="QR Code" class="qrcode-img" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to enlarge"></td><td><div class="text-muted">Not available</div></td><td><div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>-->
                                        <!--<tr><td>4</td><td><span class="training-status status-completed"></span>Completed</td><td><span class="badge bg-primary">Classroom</span></td><td><strong>Personal Hygiene</strong><div class="text-muted small mt-1">Illness Reporting Policy</div></td><td>Mr. Sanjay Verma</td><td><div class="d-flex flex-column"><small class="text-muted">Jul 10, 2025</small><span>9:00 AM - 10:00 AM</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="492"><i class="fas fa-user-edit me-1"></i>Manage <span class="badge rounded-pill bg-success ms-2">25</span><span class="badge rounded-pill bg-danger ms-1">1</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F492" alt="QR Code" class="qrcode-img"></td><td><div class="text-muted">Not available</div></td><td> <div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>-->
                                        <!--<tr><td>5</td><td><span class="training-status status-upcoming"></span>Upcoming</td><td><span class="badge badge-online">Online</span></td><td><strong>Food Safety Management</strong><div class="text-muted small mt-1">Internal Auditing for Food Safety</div></td><td>Dr. Alok Nath</td><td><div class="d-flex flex-column"><small class="text-muted">Jan 01, 2025</small><span>2:00 PM - 5:00 PM</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="493"><i class="fas fa-user-edit me-1"></i>Manage <span class="badge rounded-pill bg-success ms-2">0</span><span class="badge rounded-pill bg-danger ms-1">0</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F493" alt="QR Code" class="qrcode-img"></td><td><div class="text-muted">Not available</div></td><td> <div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>-->
                                        <!--<tr><td>6</td><td><span class="training-status status-completed"></span>Completed</td><td><span class="badge badge-online">Online</span></td><td><strong>Allergen Management</strong><div class="text-muted small mt-1">Preventing Cross-Contamination</div></td><td>Ms. Priya Sharma</td><td><div class="d-flex flex-column"><small class="text-muted">Feb 15, 2025</small><span>11:00 AM - 12:00 PM</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="494"><i class="fas fa-user-edit me-1"></i>Manage <span class="badge rounded-pill bg-success ms-2">15</span><span class="badge rounded-pill bg-danger ms-1">0</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F494" alt="QR Code" class="qrcode-img"></td><td><div class="text-muted">Not available</div></td><td> <div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>-->
                                     @endforeach
                                  
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination Controls -->
                            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                                <div class="text-muted small">
                                    <label for="rows-per-page-select" class="form-label me-2 mb-0 d-inline-block">Rows per page:</label>
                                    <select class="form-select form-select-sm d-inline-block" id="rows-per-page-select" style="width: 70px;"><option value="3">3</option><option value="5" selected>5</option><option value="10">10</option><option value="all">All</option></select>
                                </div>
                                <nav aria-label="Page navigation"><ul class="pagination justify-content-end mb-0" id="pagination-controls"></ul></nav>
                            </div>
                        </div>
                        
                        <!-- Calendar View (Hidden by default) -->
                        <div id="calendarView" style="display: none;">
                            <div class="text-center py-5">
                                <h4>Calendar View Coming Soon</h4>
                                <p class="text-muted">We're working on an interactive calendar view for your trainings.</p>
                                <button class="btn btn-primary switch-view" data-view="table"><i class="fas fa-table me-2"></i>Back to Table View</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modals -->
    <!-- NEW: Export Options Modal -->
    <div class="modal fade" id="exportOptionsModal" tabindex="-1" aria-labelledby="exportOptionsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exportOptionsModalLabel">Export Options</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="export-type-select" class="form-label">Select Export Format:</label>
              <select class="form-select" id="export-type-select">
                <option value="combined" selected>Combined Sheet</option>
                <option value="trainer_wise">Trainer Wise Sheets</option>
                <option value="topic_wise">Training Topic Wise Sheets</option>
                <option value="month_wise">Month Wise Sheets</option>
              </select>
            </div>
            <div class="form-text">
                The exported Excel file will only contain the data currently visible in the table (respecting any active filters).
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirm-export-btn"><i class="fas fa-download me-2"></i>Download</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="addTrainingModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header">
        <h5 class="modal-title">Add New Training</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">
            <form class="row g-3"  action="{{route('add.training.calendar.data')}}" method="POST" id="addTrainingForm">
                @csrf
                <div class="col-md-6"><label for="courseTitlesSelect" class="form-label">Training Topic <span class="text-danger">*</span></label>
                <!-- CHANGE START --><select class="form-select selectpicker" id="courseTitlesSelect" name="course_titles" data-live-search="true" title="Select Training Topic" required>
                    
                </select><!-- CHANGE END --></div><div class="col-md-6" id="subTopicWrapper" style="display: none;"><label for="subTopicSelect" class="form-label">Sub Topic <span class="text-danger">*</span>
                </label><!-- CHANGE START --><select class="form-select selectpicker" id="subTopicSelect" name="sub_topic" data-live-search="true" title="Select Sub Topic">
                    
                </select><!-- CHANGE END --></div><div class="col-md-6"><label for="courseModeSelect" class="form-label">Course Mode <span class="text-danger">*</span>
                </label><select class="form-select" id="courseModeSelect" name="course_mode" required><option value="">Select Course Mode</option><option value="Classroom">Classroom</option>
                <option value="Practical">Practical</option>
                <option value="Online">Online</option><option value="Recorded">Recorded</option></select></div><div class="col-12"><label class="form-label">Training Topic Remark</label>
                <textarea class="form-control" name="remark" rows="2"></textarea></div><div class="col-md-6"><label for="trainerScopeSelect" class="form-label">Trainer Scope <span class="text-danger">*</span></label>
                <select class="form-select" id="trainerScopeSelect" name="trainer_scope" required><option value="unit">Within Unit</option><option value="regional">Regional</option><option value="corporate">Corporate</option>
                <option value="external">External</option></select></div><div class="col-md-6" id="trainerNameWrapper"><label for="trainerNameSelect" class="form-label">Trainer Name <span class="text-danger">*</span></label>
                <select class="selectpicker form-control" id="trainerNameSelect" name="trainer" data-live-search="true" required></select></div><div class="col-md-6" id="externalTrainerNameWrapper" style="display: none;">
                    <label class="form-label">External Trainer Name <span class="text-danger">*</span></label><input type="text" class="form-control" name="external_trainer_name"></div>
                    <div class="col-md-6" id="externalCompanyNameWrapper" style="display: none;"><label class="form-label">Company Name</label><input type="text" class="form-control" name="external_company_name"></div>
                    <div class="col-md-6"><label class="form-label">Start Time <span class="text-danger">*</span></label><input type="datetime-local" class="form-control" id="startTimeInput1" name="start_time" step="1" required></div>
                    <div class="col-md-6"><label class="form-label">End Time <span class="text-danger">*</span></label><input type="datetime-local" class="form-control" id="endTimeInput1" name="end_time" required></div>
                    <div class="col-12"><label class="form-label">Training Location/URL</label><input type="text" class="form-control" name="location" ></div><div class="col-12">
                        <label class="form-label">Training Description</label><textarea class="form-control" name="description" rows="3"></textarea></div><div class="col-12 mt-4"><hr><div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2">
                                
                            </i>Save Training</button></div></div></form>
                            
                            
                            </div></div></div></div>
                            
                            
                            
    <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Training QR Code</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body text-center"><img id="modalQrcode" src="" alt="QR Code" class="img-fluid mb-3"><div class="d-grid gap-2">
        <a href="#" id="downloadQrcode" class="btn btn-primary" download><i class="fas fa-download me-2"></i>Download</a></div></div></div></div></div>
   
    @foreach($lms_list as $lms_lists)
    <div class="modal fade" id="editTrainingSheet{{$lms_lists->id}}" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header">
        <h5 class="modal-title">Upload Training Sheet</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">
          <form method="post" 
              action="{{ route('add.upload.training.calendar') }}" 
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lms_id" value="{{$lms_lists->id}}"/>
            
            <div class="mb-3">
                <label for="trainingSheetFile" class="form-label">Select Sheet <span class="text-danger">*</span></label>
               <input class="form-control" 
                       type="file" 
                       name="training_file" 
                       id="trainingSheetFile" 
                       accept=".xlsx,.csv,.ods,.pdf" 
                       required>            </div>
        
                   <div class="mb-3">
                        <label for="uploadDate" class="form-label">Upload Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="uploadDate1" name="upload_date" 
                               value="{{ \Carbon\Carbon::parse($lms_lists->training_upload_file_date)->format('Y-m-d') }}" required>
                    </div>

        
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-2"></i>Upload</button>
            </div>
        </form>
        </div></div></div></div>
    @endforeach
    
    
    
<div class="modal fade" id="editTrainingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Training</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" action="#" method="POST" id="editTrainingForm">
                    @csrf
                    <input type="hidden" name="_method" value="PUT"> 
                    <input type="hidden" name="training_id" id="editTrainingId"> 

                    <div class="col-md-6">
                        <label for="courseTitlesSelectEdit" class="form-label">Training Topic <span class="text-danger">*</span></label>
                        <select class="form-select selectpicker" id="courseTitlesSelectEdit" name="course_titles" data-live-search="true" required>
                            </select>
                    </div>

                    <div class="col-md-6" id="subTopicWrapperEdit" style="display: none;">
                        <label for="subTopicSelectEdit" class="form-label">Sub Topic <span class="text-danger">*</span></label>
                        <select class="form-select selectpicker" id="subTopicSelectEdit" name="sub_topic" data-live-search="true">
                            </select>
                    </div>

                    <div class="col-md-6">
                        <label for="courseModeSelectEdit" class="form-label">Course Mode <span class="text-danger">*</span></label>
                        <select class="form-select" id="courseModeSelectEdit" name="course_mode" required>
                            <option value="">Select Course Mode</option>
                            <option value="Classroom">Classroom</option>
                            <option value="Practical">Practical</option>
                            <option value="Online">Online</option>
                            <option value="Recorded">Recorded</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Training Topic Remark</label>
                        <textarea class="form-control" name="remark" id="remarkInputEdit" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="trainerScopeSelectEdit" class="form-label">Trainer Scope <span class="text-danger">*</span></label>
                        <select class="form-select" id="trainerScopeSelectEdit" name="trainer_scope" required>
                            <option value="unit">Within Unit</option>
                            <option value="regional">Regional</option>
                            <option value="corporate">Corporate</option>
                            <option value="external">External</option>
                        </select>
                    </div>

                    <div class="col-md-6" id="trainerNameWrapperEdit">
                        <label for="trainerNameSelectEdit" class="form-label">Trainer Name <span class="text-danger">*</span></label>
                        <select class="selectpicker form-control" id="trainerNameSelectEdit" name="trainer" data-live-search="true" required>
                            </select>
                    </div>

                    <div class="col-md-6" id="externalTrainerNameWrapperEdit" style="display: none;">
                        <label class="form-label">External Trainer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="external_trainer_name" id="externalTrainerNameInputEdit">
                    </div>

                    <div class="col-md-6" id="externalCompanyNameWrapperEdit" style="display: none;">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="external_company_name" id="externalCompanyNameInputEdit">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Start Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="startTimeInputEdit" name="start_time" step="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">End Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="endTimeInputEdit" name="end_time" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Training Location/URL</label>
                        <input type="text" class="form-control" name="location" id="locationInputEdit">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Training Description</label>
                        <textarea class="form-control" name="description" id="descriptionInputEdit" rows="3"></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <hr>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Update Training</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        
    
    <!-- Manage Participants Modal -->
    <div class="modal fade" id="manageParticipantsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Training Participants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <input type="hidden" id="modal-training-id" name="training_id">
                <div class="modal-body p-0 manage-participants-modal-body">
                    <div class="main-container">
                        <header class="table-header">
                            <div class="header-left">
                                <h1>Employee Roster</h1>
                                <div id="roster-counts" class="roster-counts"></div>
                            </div>
                            <div class="header-controls">
                                <div class="bulk-action-controls">
                                    <button id="mark-present-btn" class="btn bulk-status-btn"><i class="fas fa-check"></i> Mark Present</button>
                                    <button id="mark-absent-btn" class="btn bulk-status-btn"><i class="fas fa-times"></i> Mark Absent</button>
                                </div>
                                <button id="upload-file-btn" class="btn"><i class="fas fa-upload"></i> Upload File</button>
                                <button id="add-new-employee-btn" class="btn"><i class="fas fa-user-plus"></i> Add New Employee</button>
                                <div class="search-add-wrapper">
                                    <div class="search-input-container"><i class="fas fa-magnifying-glass"></i><input type="text" id="employee-search-input" placeholder="Search & add employees..."></div>
                                    <div class="search-results-container" id="search-results-container">
                                        <div id="search-actions-container">
                                            <div id="selected-for-addition-preview"></div>
                                            <div class="actions-bar">
                                                <div class="select-all-container">
                                                    <input type="checkbox" id="select-all-checkbox">
                                                    <label for="select-all-checkbox">Select All</label>
                                                </div>
                                                <button id="bulk-add-btn" class="btn-primary" disabled>Add Selected</button>
                                            </div>
                                        </div>
                                        <ul id="search-results-list"></ul>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <div id="pdf-review-section" class="p-4" style="display: none;"><div class="d-flex justify-content-between align-items-center mb-3"><div><h4 class="mb-0 d-inline-block"><i class="fas fa-user-edit text-primary me-2"></i>Review Imported</h4><small class="text-muted ms-2">Link to existing employees or add as new.</small></div><div><button id="add-all-reviewed-btn" class="btn btn-sm btn-success"><i class="fas fa-check-double me-1"></i> Add All</button><button id="discard-all-reviewed-btn" class="btn btn-sm btn-danger"><i class="fas fa-times me-1"></i> Discard All</button></div></div><div class="table-responsive"><table class="table table-sm table-hover"><thead id="reviewed-participants-thead"></thead><tbody id="reviewed-participants-tbody"></tbody></table></div></div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr><th><input type="checkbox" id="select-all-table-checkbox"></th><th>Employee Info</th><th>Contact</th><th>Role & Responsibility</th><th>Category</th><th>Status</th><th>Actions</th></tr>
                                </thead>
                                <tbody id="employee-table-body"></tbody>
                            </table>
                        </div>
                        <footer class="table-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-ban"></i> Cancel</button><button type="button" class="btn btn-primary" id="main-submit-btn"><i class="fas fa-check"></i> Save & Submit Attendance</button></footer>
                    </div>
                    <div class="modal-overlay" id="add-employee-modal"><div class="form-container" id="add-employee-form-container"><div class="form-header"><h2>Add New User</h2><button class="close-btn">×</button></div><div class="form-body"><form id="add-employee-form" action="#"><div class="form-section"><h3><i class="fas fa-sitemap"></i> Organization Information</h3><div class="form-grid"><div class="form-group"><label for="corporate-select">Corporate Name</label><select id="corporate-select"><option value="">Select Corporate</option></select></div><div class="form-group"><label for="regional-select">Regional</label><select id="regional-select" disabled><option value="">Select Regional</option></select></div><div class="form-group"><label for="unit-select">Unit Name</label><select id="unit-select" disabled><option value="">Select Unit</option></select></div><div class="form-group"><label for="department-select">Department</label><select class="selectpicker form-control" id="department-select" data-live-search="true" disabled><option value="">Select Department</option></select></div></div></div><div class="form-section"><h3><i class="fas fa-user"></i> Personal Information</h3><div class="form-grid"><div class="form-group"><label for="employee-id">Employee ID</label><input type="text" id="employee-id" required></div><div class="form-group"><label for="full-name">Full Name</label><input type="text" id="full-name" required></div><div class="form-group"><label for="email">Email Address</label><input type="email" id="email" required></div><div class="form-group"><label for="contact">Contact Number</label><input type="text" id="contact"></div><div class="form-group"><label for="gender">Gender</label><select id="gender"><option>Male</option><option>Female</option><option>Other</option></select></div><div class="form-group"><label for="designation">Designation</label><input type="text" id="designation"></div><div class="form-group"><label for="date-joining">Date of Joining</label><input type="date" id="date-joining"></div><div class="form-group"><label for="date-birth">Date of Birth</label><input type="date" id="date-birth"></div></div></div><div class="form-section"><h3><i class="fas fa-briefcase"></i> Employment Details</h3><div class="form-grid"><div class="form-group"><label for="staff-category">Staff Category</label><select id="staff-category"><option>Staff</option><option>Executive</option><option>Contractor</option></select></div><div class="form-group"><label for="food-handlers-category">Food Handler</label><select id="food-handlers-category"><option>No</option><option>Yes</option></select></div></div></div></form></div><div class="form-footer"><button type="button" class="btn btn-secondary" id="modal-cancel-btn"><i class="fas fa-ban"></i> Cancel</button><button type="submit" form="add-employee-form" class="btn btn-primary" id="modal-submit-btn"><i class="fas fa-check"></i> Submit</button></div></div></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- File Upload Modal -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Import Participants from File</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div id="upload-file-step"><p class="text-muted">Upload a CSV or PDF file. <a href="#" id="download-sample-csv-btn">Download Sample CSV</a>.</p><div class="mb-3"><label for="file-upload-input" class="form-label">Select File</label><input class="form-control" type="file" id="file-upload-input" accept=".pdf,.csv"></div><div class="form-check form-switch mb-3" id="handwriting-option-wrapper" style="display: none;"><input class="form-check-input" type="checkbox" id="detect-handwriting-checkbox"><label class="form-check-label" for="detect-handwriting-checkbox">Detect handwritten text <small class="text-muted">(For PDFs, simulates OCR)</small></label></div><div class="d-flex justify-content-end"><button class="btn btn-primary" id="extract-table-btn" disabled><i class="fas fa-cogs me-2"></i>Extract Table</button></div></div><div id="pdf-loading-step" style="display: none;" class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3" id="loading-text">Analyzing file...</p></div><div id="pdf-review-step" style="display: none;"><div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>Map the columns to the required fields. Data in <span class="handwritten-text">blue</span> was identified as handwritten.</div><div class="row g-3 mb-3 p-3 bg-light rounded border"><div class="col-md-4"><label for="map-id-select" class="form-label fw-bold">Map Employee ID to:</label><select id="map-id-select" class="form-select"></select></div><div class="col-md-4"><label for="map-name-select" class="form-label fw-bold">Map Full Name to:</label><select id="map-name-select" class="form-select"></select></div><div class="col-md-4"><label for="map-department-select" class="form-label fw-bold">Map Department to:</label><select id="map-department-select" class="form-select"></select></div></div><h5>Extracted Data Preview</h5><div class="table-responsive" style="max-height: 400px;"><table class="table table-bordered table-striped table-sm"><thead id="pdf-review-thead"></thead><tbody id="pdf-review-tbody"></tbody></table></div><div class="modal-footer mt-3 pb-0 px-0"><button type="button" class="btn btn-outline-secondary" id="pdf-back-btn">Back</button><button type="button" class="btn btn-primary" id="import-participants-btn"><i class="fas fa-user-check me-2"></i>Review & Add</button></div></div></div></div></div>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- ADDED: SheetJS for Excel Export -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr settings
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
        </script>
        <script>
            window.topicData = @json($finalDataSops);   
             window.allTrainers = @json($allTrainers);  
             
              window.allMasterList = @json($allMasterList);   
               window.allTrainingParticipantData = @json($allTrainingParticipantData);   
        </script>
        //  <script>
        // $(document).ready(function() {
            
        //     let topicData = window.topicData || {}; 
        //     let allTrainers = window.allTrainers || []; 
        
        //     function formatDateTimeLocal(dateTimeString) {
        //         if (!dateTimeString) return '';
        //         const date = new Date(dateTimeString);
        //         if (isNaN(date.getTime())) return '';
        //         return date.toISOString().slice(0, 19); 
        //     }
        
        //     const addTrainingModalEl = document.getElementById('addTrainingModal');
        //     const courseTitlesSelect = document.getElementById('courseTitlesSelect');
        //     const subTopicWrapper = document.getElementById('subTopicWrapper');
        //     const subTopicSelect = document.getElementById('subTopicSelect');
        //     const trainerScopeSelect = document.getElementById('trainerScopeSelect');
        //     const trainerNameSelect = document.getElementById('trainerNameSelect');
        //     const externalTrainerNameWrapper = document.getElementById('externalTrainerNameWrapper');
        //     const externalCompanyNameWrapper = document.getElementById('externalCompanyNameWrapper');
        
        //     const courseTitlesSelectEdit = document.getElementById('courseTitlesSelectEdit');
        //     const subTopicWrapperEdit = document.getElementById('subTopicWrapperEdit');
        //     const subTopicSelectEdit = document.getElementById('subTopicSelectEdit');
        //     const trainerScopeSelectEdit = document.getElementById('trainerScopeSelectEdit');
        //     const trainerNameSelectEdit = document.getElementById('trainerNameSelectEdit');
        //     const externalTrainerNameWrapperEdit = document.getElementById('externalTrainerNameWrapperEdit');
        //     const externalCompanyNameWrapperEdit = document.getElementById('externalCompanyNameWrapperEdit');
        //     const externalTrainerNameInputEdit = document.getElementById('externalTrainerNameInputEdit');
        //     const externalCompanyNameInputEdit = document.getElementById('externalCompanyNameInputEdit');
        
        //     function handleTrainerNameChange(selectElement, externalNameWrapper, companyNameWrapper) { 
        //         const isAddNew = selectElement.value === 'add_new_external';
        //         externalNameWrapper.style.display = isAddNew ? 'block' : 'none';
        //         companyNameWrapper.style.display = isAddNew ? 'block' : 'none';
        //     }
        
        //     function updateSubTopics(courseSelect, subTopicWrapper, subTopicSelect, selectedValue = null) { 
        //         const selectedTopic = courseSelect.value;
        //         const subTopics = topicData[selectedTopic] || [];
        //         subTopicWrapper.style.display = subTopics.length > 0 ? 'block' : 'none';
        //         subTopicSelect.required = subTopics.length > 0;
                
        //         $(subTopicSelect).empty();
        //         subTopicSelect.add(new Option("Select Sub Topic", "", false, false));
        
        //         if (subTopics.length > 0) {
        //             subTopics.forEach(sub => {
        //                 const isSelected = sub === selectedValue;
        //                 subTopicSelect.add(new Option(sub, sub, false, isSelected));
        //             });
        //         }
        //         $(subTopicSelect).selectpicker('refresh');
        //     }
            
        //     function updateTrainerNames(scopeSelect, nameSelect, selectedValue = null) { 
        //         const scope = scopeSelect.value; 
        //         const filteredTrainers = allTrainers.filter(t => t.scope === scope); 
                
        //         $(nameSelect).empty();
        //         nameSelect.add(new Option("Select Trainer", "", false, false));
                
        //         if (filteredTrainers.length > 0) {
        //             filteredTrainers.forEach(t => {
        //                 const isSelected = t.name === selectedValue;
        //                 $(nameSelect).append(new Option(t.name, t.name, false, isSelected));
        //             });
        //         } 
        //         if (scope === 'external') $(nameSelect).append(new Option('Add New External Trainer...', 'add_new_external'));
        //         $(nameSelect).selectpicker('refresh'); 
        //     }
        
        //     if (addTrainingModalEl) {
    
        //         addTrainingModalEl.addEventListener('show.bs.modal', function () { 
        //             $(courseTitlesSelect).empty();
        //             courseTitlesSelect.add(new Option("Select Training Topic", "", false, false));
        //             for (const topic in topicData) courseTitlesSelect.add(new Option(topic, topic)); 
        //             $(courseTitlesSelect).selectpicker('refresh');
                    
        //             updateSubTopics(courseTitlesSelect, subTopicWrapper, subTopicSelect);
        //             trainerScopeSelect.value = 'unit'; 
        //             updateTrainerNames(trainerScopeSelect, trainerNameSelect); 
        //         });
        
        //         $(courseTitlesSelect).on('change', () => updateSubTopics(courseTitlesSelect, subTopicWrapper, subTopicSelect));
        //         $(trainerScopeSelect).on('change', () => updateTrainerNames(trainerScopeSelect, trainerNameSelect));
        //         $(trainerNameSelect).on('change', () => handleTrainerNameChange(trainerNameSelect, externalTrainerNameWrapper, externalCompanyNameWrapper));
        //     }
        
        //     $(document).on('click', '.edit-training-btn', function() {
                
        //         const trainingId = $(this).data('id');
        //         const fetchUrl = $(this).data('fetch-url');
        //         const updateUrl = $(this).data('update-url');
        
        //         $('#editTrainingForm').attr('action', updateUrl);
        //         $('#editTrainingId').val(trainingId);
                
        //         $.ajax({
        //             url: fetchUrl,
        //             method: 'GET',
        //             dataType: 'json',
        //             success: function(response) {
        //                 const data = response.data;
                    
        //                 populateMainTopicsEdit(data.sop_id); 
        
        //                 trainerScopeSelectEdit.value = data.trainer_scope; 
                        
        //                 updateTrainerNames(trainerScopeSelectEdit, trainerNameSelectEdit, data.trainer);
                    
        //                 updateSubTopics(courseTitlesSelectEdit, subTopicWrapperEdit, subTopicSelectEdit, data.sub_sop_id); 
        
        //                 $('#courseModeSelectEdit').val(data.course_mode);
        //                 $('#remarkInputEdit').val(data.remark);
        //                 $('#locationInputEdit').val(data.training_location); 
        //                 $('#descriptionInputEdit').val(data.short_description); 
                        
        //                 $('#startTimeInputEdit').val(formatDateTimeLocal(data.start_time));
        //                 $('#endTimeInputEdit').val(formatDateTimeLocal(data.end_time));
                        
        //                 if (data.trainer_scope === 'external') {
                            
        //                     $('#externalTrainerNameInputEdit').val(data.external_trainer_name || '');
        //                     $('#externalCompanyNameInputEdit').val(data.external_company_name || '');
                            
        //                     const isTrainerInList = $(trainerNameSelectEdit).find(`option[value="${data.trainer}"]`).length > 0;
        
        //                     if (!isTrainerInList) {
        //                         $('#trainerNameSelectEdit').val('add_new_external');
        //                     }
                            
        //                     handleTrainerNameChange(trainerNameSelectEdit, externalTrainerNameWrapperEdit, externalCompanyNameWrapperEdit); 
        
        //                 } else {
        //                     $('#trainerNameWrapperEdit').show();
        //                     $('#externalTrainerNameWrapperEdit').hide();
        //                     $('#externalCompanyNameWrapperEdit').hide();
        //                     $('#externalTrainerNameInputEdit').val('');
        //                     $('#externalCompanyNameInputEdit').val('');
        //                 }
                        
        //                 $('.selectpicker').selectpicker('refresh');
                        
        //             },
        //             error: function(xhr) {
        //                 console.log(xhr.responseText);
        //             }
        //         });
        //     });
        
        //     function populateMainTopicsEdit(selectedValue = null) {
        //         $(courseTitlesSelectEdit).empty(); 
        //         courseTitlesSelectEdit.add(new Option("Select Training Topic", "", false, false));
        //         for (const topic in topicData) {
        //              courseTitlesSelectEdit.add(new Option(topic, topic, false, topic === selectedValue));
        //         }
        //     }
        // });
        //  </script>
<script>
$(document).ready(function() {
    
    
    let topicData = window.topicData || {}; 
    let allTrainers = window.allTrainers || []; 
    
    function formatDateTimeLocal(dateTimeString) {
        if (!dateTimeString) return '';
        const date = new Date(dateTimeString);
        if (isNaN(date.getTime())) return '';
        return date.toISOString().slice(0, 19); 
    }
    
    const addTrainingModalEl = document.getElementById('addTrainingModal');
    const courseTitlesSelect = document.getElementById('courseTitlesSelect');
    const subTopicWrapper = document.getElementById('subTopicWrapper');
    const subTopicSelect = document.getElementById('subTopicSelect');
    const trainerScopeSelect = document.getElementById('trainerScopeSelect');
    const trainerNameSelect = document.getElementById('trainerNameSelect');
    const externalTrainerNameWrapper = document.getElementById('externalTrainerNameWrapper');
    const externalCompanyNameWrapper = document.getElementById('externalCompanyNameWrapper');
    
    const courseTitlesSelectEdit = document.getElementById('courseTitlesSelectEdit');
    const subTopicWrapperEdit = document.getElementById('subTopicWrapperEdit');
    const subTopicSelectEdit = document.getElementById('subTopicSelectEdit');
    const trainerScopeSelectEdit = document.getElementById('trainerScopeSelectEdit');
    const trainerNameSelectEdit = document.getElementById('trainerNameSelectEdit');
    const externalTrainerNameWrapperEdit = document.getElementById('externalTrainerNameWrapperEdit');
    const externalCompanyNameWrapperEdit = document.getElementById('externalCompanyNameWrapperEdit');
    const externalTrainerNameInputEdit = document.getElementById('externalTrainerNameInputEdit');
    const externalCompanyNameInputEdit = document.getElementById('externalCompanyNameInputEdit');
    
    function handleTrainerNameChange(selectElement, externalNameWrapper, companyNameWrapper) { 
        const isAddNew = selectElement.value === 'add_new_external';
        externalNameWrapper.style.display = isAddNew ? 'block' : 'none';
        companyNameWrapper.style.display = isAddNew ? 'block' : 'none';
    }
    
    function updateSubTopics(courseSelect, subTopicWrapper, subTopicSelect, selectedValue = null) { 
        const selectedTopic = courseSelect.value;
        const subTopics = topicData[selectedTopic] || [];
        subTopicWrapper.style.display = subTopics.length > 0 ? 'block' : 'none';
        subTopicSelect.required = subTopics.length > 0;
        
        $(subTopicSelect).empty();
        subTopicSelect.add(new Option("Select Sub Topic", "", false, false));
        
        if (subTopics.length > 0) {
            subTopics.forEach(sub => {
                const isSelected = sub === selectedValue;
                subTopicSelect.add(new Option(sub, sub, false, isSelected));
            });
        }
        $(subTopicSelect).selectpicker('refresh');
    }
    
    function updateTrainerNames(scopeSelect, nameSelect, selectedValue = null) { 
        const scope = scopeSelect.value; 
        const filteredTrainers = allTrainers.filter(t => t.scope === scope); 
        
        $(nameSelect).empty();
        nameSelect.add(new Option("Select Trainer", "", false, false));
        
        if (filteredTrainers.length > 0) {
            filteredTrainers.forEach(t => {
                const isSelected = t.name === selectedValue;
                $(nameSelect).append(new Option(t.name, t.name, false, isSelected));
            });
        } 
        if (scope === 'external') $(nameSelect).append(new Option('Add New External Trainer...', 'add_new_external'));
        $(nameSelect).selectpicker('refresh'); 
    }
    
    
    if (addTrainingModalEl) {
        
        addTrainingModalEl.addEventListener('show.bs.modal', function () { 
            $(courseTitlesSelect).empty();
            courseTitlesSelect.add(new Option("Select Training Topic", "", false, false));
            for (const topic in topicData) courseTitlesSelect.add(new Option(topic, topic)); 
            $(courseTitlesSelect).selectpicker('refresh');
            
            updateSubTopics(courseTitlesSelect, subTopicWrapper, subTopicSelect);
            trainerScopeSelect.value = 'unit'; 
            updateTrainerNames(trainerScopeSelect, trainerNameSelect); 
        });
        
        $(courseTitlesSelect).on('change', () => updateSubTopics(courseTitlesSelect, subTopicWrapper, subTopicSelect));
        $(trainerScopeSelect).on('change', () => updateTrainerNames(trainerScopeSelect, trainerNameSelect));
        $(trainerNameSelect).on('change', () => handleTrainerNameChange(trainerNameSelect, externalTrainerNameWrapper, externalCompanyNameWrapper));
    }
    
    
    $(document).on('click', '.edit-training-btn', function() {
        
        const trainingId = $(this).data('id');
        const fetchUrl = $(this).data('fetch-url');
        const updateUrl = $(this).data('update-url');
        
        $('#editTrainingForm').attr('action', updateUrl);
        $('#editTrainingId').val(trainingId);
        
        $.ajax({
            url: fetchUrl,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                const data = response.data;
                
                populateMainTopicsEdit(data.sop_id); 
                
                trainerScopeSelectEdit.value = data.trainer_scope; 
                
                updateTrainerNames(trainerScopeSelectEdit, trainerNameSelectEdit, data.trainer);
                
                updateSubTopics(courseTitlesSelectEdit, subTopicWrapperEdit, subTopicSelectEdit, data.sub_sop_id); 
                
                $('#courseModeSelectEdit').val(data.course_mode);
                $('#remarkInputEdit').val(data.remark);
                $('#locationInputEdit').val(data.training_location); 
                $('#descriptionInputEdit').val(data.short_description); 
                
                $('#startTimeInputEdit').val(formatDateTimeLocal(data.start_time));
                $('#endTimeInputEdit').val(formatDateTimeLocal(data.end_time));
                
                if (data.trainer_scope === 'external') {
                    
                    $('#externalTrainerNameInputEdit').val(data.external_trainer_name || '');
                    $('#externalCompanyNameInputEdit').val(data.external_company_name || '');
                    
                    const isTrainerInList = $(trainerNameSelectEdit).find(`option[value="${data.trainer}"]`).length > 0;
                    
                    if (!isTrainerInList) {
                        $('#trainerNameSelectEdit').val('add_new_external');
                    }
                    
                    handleTrainerNameChange(trainerNameSelectEdit, externalTrainerNameWrapperEdit, externalCompanyNameWrapperEdit); 
                    
                } else {
                    $('#trainerNameWrapperEdit').show();
                    $('#externalTrainerNameWrapperEdit').hide();
                    $('#externalCompanyNameWrapperEdit').hide();
                    $('#externalTrainerNameInputEdit').val('');
                    $('#externalCompanyNameInputEdit').val('');
                }
                
                $('.selectpicker').selectpicker('refresh');
                
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
    
    function populateMainTopicsEdit(selectedValue = null) {
        $(courseTitlesSelectEdit).empty(); 
        courseTitlesSelectEdit.add(new Option("Select Training Topic", "", false, false));
        for (const topic in topicData) {
            courseTitlesSelectEdit.add(new Option(topic, topic, false, topic === selectedValue));
        }
    }
    
    $(courseTitlesSelectEdit).on('change', () => updateSubTopics(courseTitlesSelectEdit, subTopicWrapperEdit, subTopicSelectEdit, null));
    
    $(trainerScopeSelectEdit).on('change', () => updateTrainerNames(trainerScopeSelectEdit, trainerNameSelectEdit));
    
    $(trainerNameSelectEdit).on('change', () => handleTrainerNameChange(trainerNameSelectEdit, externalTrainerNameWrapperEdit, externalCompanyNameWrapperEdit));
});
</script>
       <script>
            $(document).ready(function() {  
                const editTrainingForm = document.getElementById('editTrainingForm'); 
            
                if (editTrainingForm) {
                    editTrainingForm.addEventListener('submit', function(event) {
                        
                        event.preventDefault(); 
                        
                        const formData = new FormData(editTrainingForm);
                        $.ajax({
                            url: editTrainingForm.action, 
                            method: 'POST', 
                            data: formData,
                            processData: false, 
                            contentType: false, 
                            
                            success: function(response) {
                                if (response.success) { 
                                    toastr.success('Updated Successfully');
                                    $('#editTrainingModal').modal('hide');
                                    
                                    setTimeout(()=>{
                                        location.reload();
                                    },2000)
                                } else {
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Unable to update');
                            }
                        });
                    });
                }
            });  
            </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let topicData = window.topicData;

            let allTrainers = window.allTrainers;
            // const topicData = { "Food Safety Management": ["Introduction to Food Safety", "HACCP Level 1: Principles", "HACCP Level 2: Implementation", "Internal Auditing for Food Safety"], "Personal Hygiene": ["Handwashing Techniques", "Uniform and Personal Protective Equipment (PPE)", "Illness Reporting Policy"], "Allergen Management": ["Identifying Major Allergens", "Preventing Cross-Contamination", "Labeling and Communication"], "Diversey Training For Existing Employees": [], "Emergency Procedures": ["Fire Safety", "First Aid Basics"] };
            // const allTrainers = [ { name: "Mr. Sanjay Verma", scope: "unit" }, { name: "Ms. Anjali Patil", scope: "unit" }, { name: "Mr. Raj Sharma", scope: "regional" }, { name: "Ms. Deepa Iyer", scope: "regional" }, { name: "Dr. Alok Nath", scope: "corporate" }, { name: "Mr. Kuldeep Kumar Sharma", scope: "external" }, { name: "Ms. Priya Sharma", scope: "external" } ];
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl); });
            flatpickr("#uploadDate", { dateFormat: "Y-m-d", defaultDate: "today" });
            const commonConfig = { enableTime: true, dateFormat: "Y-m-d H:i", altInput: true, altFormat: "M j, Y h:i K", allowInput: true };
            let endDatePicker = flatpickr("#endTimeInput", commonConfig);
            let startDatePicker = flatpickr("#startTimeInput", { ...commonConfig, onChange: function(selectedDates) { if (selectedDates[0]) { endDatePicker.set('minDate', selectedDates[0]); } } });
            const viewToggleButtons = document.querySelectorAll('.view-toggle-btn, .switch-view');
            const tableView = document.getElementById('tableView'); const calendarView = document.getElementById('calendarView');
            function switchView(viewName) { document.querySelectorAll('.view-toggle-btn').forEach(btn => btn.classList.toggle('active', btn.dataset.view === viewName)); tableView.style.display = viewName === 'table' ? 'block' : 'none'; calendarView.style.display = viewName === 'calendar' ? 'block' : 'none'; }
            viewToggleButtons.forEach(button => button.addEventListener('click', function() { switchView(this.dataset.view); }));
            const qrcodeModal = new bootstrap.Modal(document.getElementById('qrcodeModal'));
            document.body.addEventListener('click', function(event) { if (event.target.classList.contains('qrcode-img')) { document.getElementById('modalQrcode').src = event.target.src; document.getElementById('downloadQrcode').href = event.target.src; qrcodeModal.show(); }});
            const searchActionsContainer = document.getElementById('search-actions-container');

            const addTrainingModalEl = document.getElementById('addTrainingModal');
            const addTrainingModal = new bootstrap.Modal(addTrainingModalEl);
            const addTrainingForm = document.getElementById('addTrainingForm');
            if (addTrainingModalEl) {
                const courseTitlesSelect = document.getElementById('courseTitlesSelect'); const subTopicWrapper = document.getElementById('subTopicWrapper'); const subTopicSelect = document.getElementById('subTopicSelect'); const trainerScopeSelect = document.getElementById('trainerScopeSelect'); const trainerNameSelect = document.getElementById('trainerNameSelect'); const externalTrainerNameWrapper = document.getElementById('externalTrainerNameWrapper'); const externalCompanyNameWrapper = document.getElementById('externalCompanyNameWrapper');
                function populateMainTopics() { 
                    courseTitlesSelect.innerHTML = ''; 
                    for (const topic in topicData) courseTitlesSelect.add(new Option(topic, topic)); 
                    // CHANGE START
                    $(courseTitlesSelect).selectpicker('refresh');
                    // CHANGE END
                }
                function updateSubTopics() { 
                    const selectedTopic = courseTitlesSelect.value; 
                    const subTopics = topicData[selectedTopic] || []; 
                    subTopicWrapper.style.display = subTopics.length > 0 ? 'block' : 'none'; 
                    subTopicSelect.required = subTopics.length > 0; 
                    if (subTopics.length > 0) { 
                        subTopicSelect.innerHTML = ''; 
                        subTopics.forEach(sub => subTopicSelect.add(new Option(sub, sub))); 
                    }
                    // CHANGE START
                    $(subTopicSelect).selectpicker('refresh');
                    // CHANGE END
                }
                function updateTrainerNames() { const scope = trainerScopeSelect.value; const filteredTrainers = allTrainers.filter(t => t.scope === scope); $(trainerNameSelect).empty(); if (filteredTrainers.length > 0) filteredTrainers.forEach(t => $(trainerNameSelect).append(new Option(t.name, t.name))); if (scope === 'external') $(trainerNameSelect).append(new Option('Add New External Trainer...', 'add_new_external')); $(trainerNameSelect).selectpicker('refresh'); handleTrainerNameChange(); }
                function handleTrainerNameChange() { const isAddNew = trainerNameSelect.value === 'add_new_external'; externalTrainerNameWrapper.style.display = isAddNew ? 'block' : 'none'; externalCompanyNameWrapper.style.display = isAddNew ? 'block' : 'none'; externalTrainerNameWrapper.querySelector('input').required = isAddNew; }
                courseTitlesSelect.addEventListener('change', updateSubTopics); trainerScopeSelect.addEventListener('change', updateTrainerNames); trainerNameSelect.addEventListener('change', handleTrainerNameChange);
                addTrainingModalEl.addEventListener('show.bs.modal', function () { populateMainTopics(); updateSubTopics(); trainerScopeSelect.value = 'unit'; updateTrainerNames(); });
                
                addTrainingForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const mainTableBody = document.querySelector('#tableView tbody');
                    const newId = `T-${Date.now().toString().slice(-6)}`;
                    const formData = new FormData(addTrainingForm); const newTraining = Object.fromEntries(formData.entries());
                    let trainerName = newTraining.trainer; if (trainerName === 'add_new_external') trainerName = newTraining.external_trainer_name;
                    const startDate = new Date(newTraining.start_time); const endDate = new Date(newTraining.end_time); const dateString = startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); const timeString = `${startDate.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})} - ${endDate.toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})}`;
                    let modeBadgeClass = 'bg-primary'; if(newTraining.course_mode === 'Online') modeBadgeClass = 'badge-online'; if(newTraining.course_mode === 'Recorded') modeBadgeClass = 'badge-recorded';
                    const newRowHTML = `<tr><td>${mainTableBody.rows.length + 1}</td><td><span class="training-status status-upcoming"></span>Upcoming</td><td><span class="badge ${modeBadgeClass}">${newTraining.course_mode}</span></td><td><strong>${newTraining.course_titles}</strong><div class="text-muted small mt-1">${newTraining.sub_topic || ''}</div></td><td>${trainerName}</td><td><div class="d-flex flex-column"><small class="text-muted">${dateString}</small><span>${timeString}</span></div></td><td><div class="attendance-stats"><button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#manageParticipantsModal" data-training-id="${newId}"><i class="fas fa-user-edit me-1"></i>Manage<span class="badge rounded-pill bg-success ms-2" title="Present">0</span><span class="badge rounded-pill bg-danger ms-1" title="Absent">0</span></button></div></td><td><img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=https%3A%2F%2Fefsm.safefoodmitra.com%2Fadmin%2Fpublic%2Findex.php%2Fscanlms%2F${newId}" alt="QR Code" class="qrcode-img" data-bs-toggle="tooltip" title="Click to enlarge"></td><td><div class="text-muted">Not available</div></td><td><div class="action-buttons"><a href="#" class="btn btn-sm btn-outline-primary action-btn" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a><a href="#" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-outline-danger action-btn" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></a></div></td></tr>`;
                    mainTableBody.insertAdjacentHTML('afterbegin', newRowHTML);
                    addTrainingForm.reset(); 
                    // CHANGE START
                    $(trainerNameSelect).selectpicker('val', '');
                    $(courseTitlesSelect).selectpicker('val', '');
                    $(subTopicSelect).selectpicker('val', '');
                    // CHANGE END
                    addTrainingModal.hide();
                    window.tableManager.populateFilters(); window.tableManager.applyAllFilters();
                });
            }
        });
    </script>
    
    <script>
    
             function deleteItem(el) {
            if (!confirm("Are you sure?")) return;
        
            let id = el.dataset.id;
            let url = `/admin/public/training/calendar/delete-calendar-data/${id}`; 
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message); 
                    el.closest('tr').remove();
                } else {
                    toastr.error(data.message);  
                }
            })
            .catch(error => {
                console.error("Error:", error);
                toastr.error("Something went wrong!");
            });
        }

    
         $('.delete-training').on('click', function(e) {
        e.preventDefault(); 

        var id = $(this).data('id');
        var url = $(this).data('url');
        if(confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message || 'Deleted successfully!');
                        // $('#training-row-' + id).remove(); 
                         setTimeout(()=>{
                        location.reload()
                    },2000)
                        
                    } else {
                        toastr.error(response.message || 'Failed to delete.');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Something went wrong!');
                }
            });
        }
    });


    
        $('#addTrainingForm').on('submit', function(e) {
            e.preventDefault(); 
            let formData = $(this).serialize(); 
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Training added successfully!');
                    $('#addTrainingForm')[0].reset();
                    $('#addTrainingForm select').selectpicker('refresh'); 
                    $('#addTrainingModal').modal('hide');
                    setTimeout(()=>{
                        location.reload()
                    },2000)
                },
                error: function(xhr, status, error) {
                    // Error feedback
                    console.log(xhr.responseText);
                    toastr.error('Something went wrong. Check console.');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.querySelector('#tableView tbody');
            const filterableHeaders = document.querySelectorAll('thead th[data-column-index]');
            const paginationControls = document.getElementById('pagination-controls');
            const rowsPerPageSelect = document.getElementById('rows-per-page-select');
            
            let activeFilters = {}; let topicHierarchy = {}; let currentPage = 1; let rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
            const totalCountEl = document.getElementById('total-trainings-count'); const upcomingCountEl = document.getElementById('upcoming-count'); const ongoingCountEl = document.getElementById('ongoing-count'); const completedCountEl = document.getElementById('completed-count'); const participantsCountEl = document.getElementById('total-participants-count');

            const tableManager = {
                updateDashboardMetrics() {
                    let total = 0, upcoming = 0, ongoing = 0, completed = 0, participants = 0;
                    tableBody.querySelectorAll('tr').forEach(row => {
                        if (row.dataset.filtered === 'true') return;
                        total++; const statusText = row.cells[1].textContent; if (statusText.includes('Upcoming')) upcoming++; if (statusText.includes('Ongoing')) ongoing++; if (statusText.includes('Completed')) completed++;
                        row.cells[6].querySelectorAll('.badge').forEach(badge => { const count = parseInt(badge.textContent, 10); if (!isNaN(count)) participants += count; });
                    });
                    totalCountEl.textContent = total; upcomingCountEl.textContent = upcoming; ongoingCountEl.textContent = ongoing; completedCountEl.textContent = completed; participantsCountEl.textContent = participants;
                },
                displayPage(page) { currentPage = page; const visibleRows = Array.from(tableBody.rows).filter(row => row.dataset.filtered !== 'true'); tableBody.querySelectorAll('tr').forEach(row => row.style.display = 'none'); const start = (page - 1) * rowsPerPage; const end = rowsPerPage === Infinity ? visibleRows.length : start + rowsPerPage; visibleRows.slice(start, end).forEach(row => row.style.display = ''); },
                setupPagination() { const visibleRows = Array.from(tableBody.rows).filter(row => row.dataset.filtered !== 'true'); const pageCount = rowsPerPage === Infinity ? 1 : Math.ceil(visibleRows.length / rowsPerPage); paginationControls.innerHTML = ''; if (pageCount <= 1) return; 
                
                
                
                let html = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="prev"><i class="fas fa-angle-left"></i></a></li>`;
                for (let i = 1; i <= pageCount; i++) html += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                html += `<li class="page-item ${currentPage === pageCount ? 'disabled' : ''}"><a class="page-link" href="#" data-page="next"><i class="fas fa-angle-right"></i></a></li>`; paginationControls.innerHTML = html; },
                
                
                
                
                getCellContent(row, index) { const cell = row.cells[index]; if (!cell) return ''; switch(index) { case 1: return cell.textContent.trim(); case 2: return cell.querySelector('.badge')?.textContent.trim() || ''; case 3: return { main: cell.querySelector('strong')?.textContent.trim() || '', sub: cell.querySelector('.text-muted')?.textContent.trim() || '' }; case 4: return cell.textContent.trim(); case 5: const dateText = cell.querySelector('small')?.textContent.trim(); try { return new Date(dateText).toISOString(); } catch (e) { return dateText; } default: return cell.textContent.trim(); }},
                updateSubTopicFilter() { const topicHeader = document.querySelector('th[data-column-index="3"]'); if (!topicHeader) return; const mainTopicWrapper = topicHeader.querySelector('#main-topic-wrapper'); const subTopicWrapper = topicHeader.querySelector('#sub-topic-wrapper'); const mainTopicCheckboxes = topicHeader.querySelectorAll('.filter-options-main .form-check-input:checked'); const subTopicContainer = topicHeader.querySelector('.filter-options-sub'); mainTopicWrapper.classList.toggle('col-6', mainTopicCheckboxes.length > 0); mainTopicWrapper.classList.toggle('col-12', mainTopicCheckboxes.length === 0); subTopicWrapper.style.display = mainTopicCheckboxes.length > 0 ? 'block' : 'none'; const relevantSubTopics = new Set(); if (mainTopicCheckboxes.length > 0) mainTopicCheckboxes.forEach(cb => { if (topicHierarchy[cb.value]) topicHierarchy[cb.value].forEach(sub => relevantSubTopics.add(sub)); }); const sortedSubTopics = Array.from(relevantSubTopics).sort(); subTopicContainer.innerHTML = sortedSubTopics.map(value => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${value}" id="filter-sub-${value.replace(/\s+/g, '')}"><label class="form-check-label" for="filter-sub-${value.replace(/\s+/g, '')}">${value}</label></div>`).join(''); if (sortedSubTopics.length === 0 && mainTopicCheckboxes.length > 0) subTopicContainer.innerHTML = '<div class="text-muted small px-2">No sub-topics for selection.</div>'; },
                populateFilters() { const uniqueValues = {}; topicHierarchy = {}; filterableHeaders.forEach(th => { const index = parseInt(th.dataset.columnIndex, 10); if (index !== 3 && index !== 5) uniqueValues[index] = new Set(); }); for (const row of tableBody.rows) { for (const indexStr in uniqueValues) { const index = parseInt(indexStr, 10); const content = this.getCellContent(row, index); if (content) uniqueValues[index].add(content); } const topicContent = this.getCellContent(row, 3); if (topicContent.main) { if (!topicHierarchy[topicContent.main]) topicHierarchy[topicContent.main] = new Set(); if (topicContent.sub) topicHierarchy[topicContent.main].add(topicContent.sub); } } filterableHeaders.forEach(th => { const index = parseInt(th.dataset.columnIndex, 10); if (index === 3) { const mainTopicContainer = th.querySelector('.filter-options-main'); const sortedMainTopics = Object.keys(topicHierarchy).sort(); mainTopicContainer.innerHTML = sortedMainTopics.map(value => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${value}" id="filter-main-${value.replace(/\s+/g, '')}"><label class="form-check-label" for="filter-main-${value.replace(/\s+/g, '')}">${value}</label></div>`).join(''); mainTopicContainer.addEventListener('change', this.updateSubTopicFilter); this.updateSubTopicFilter(); } else if (index !== 5) { const dropdown = th.querySelector('.filter-options'); if (dropdown) { const sortedValues = Array.from(uniqueValues[index]).sort(); dropdown.innerHTML = sortedValues.map(value => `<div class="form-check"><input class="form-check-input" type="checkbox" value="${value}" id="filter-${index}-${value.replace(/\s+/g, '')}"><label class="form-check-label" for="filter-${index}-${value.replace(/\s+/g, '')}">${value}</label></div>`).join(''); } } }); },
                applyAllFilters() { for (const row of tableBody.rows) { let isVisible = true; for (const key in activeFilters) { const index = parseInt(key, 10); const filter = activeFilters[key]; const content = this.getCellContent(row, index); if (index === 3) { const mainTopics = filter.main || []; const subTopics = filter.sub || []; const mainMatch = mainTopics.length === 0 || mainTopics.includes(content.main); const subMatch = subTopics.length === 0 || subTopics.includes(content.sub); if (!mainMatch || (mainTopics.length > 0 && !subMatch)) { isVisible = false; break; } } else if (index === 5) { const rowDate = new Date(content); if (isNaN(rowDate)) { isVisible = false; break; } const fromDate = filter.from ? new Date(filter.from) : null; const toDate = filter.to ? new Date(filter.to) : null; if (fromDate && rowDate < fromDate) { isVisible = false; break; } if (toDate) { toDate.setHours(23, 59, 59); if(rowDate > toDate) { isVisible = false; break; } } } else { if (filter.length > 0 && !filter.includes(content)) { isVisible = false; break; } } } row.dataset.filtered = isVisible ? 'false' : 'true'; } this.updateDashboardMetrics(); this.setupPagination(); this.displayPage(1); }
            };
            window.tableManager = tableManager;
            // paginationControls.addEventListener('click', (e) => { e.preventDefault(); const target = e.target.closest('.page-link'); if (!target || target.parentElement.classList.contains('disabled')) return; const page = target.dataset.page; if (page === 'prev') { if (currentPage > 1) currentPage--; } else if (page === 'next') { const pageCount = Math.ceil(Array.from(tableBody.rows).filter(r=>r.dataset.filtered!=='true').length / rowsPerPage); if (currentPage < pageCount) currentPage++; } else { currentPage = parseInt(page, 10); } tableManager.setupPagination(); tableManager.displayPage(currentPage); });
           
            
            tableManager.setupPagination = function () {
            const rows = Array.from(tableBody.rows).filter(r => r.dataset.filtered !== 'true');
            const pageCount = Math.ceil(rows.length / rowsPerPage);
        
            let html = "";
        
            html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="prev"><i class="fas fa-angle-left"></i></a>
                     </li>`;
        
            html += `<li class="page-item ${currentPage === 1 ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="1">1</a>
                     </li>`;
        
            if (currentPage > 3) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        
            for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                if (i > 1 && i < pageCount) {
                    html += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                             </li>`;
                }
            }
        
            if (currentPage < pageCount - 2) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        
            if (pageCount > 1) {
                html += `<li class="page-item ${currentPage === pageCount ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${pageCount}">${pageCount}</a>
                         </li>`;
            }
        
            html += `<li class="page-item ${currentPage === pageCount ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="next"><i class="fas fa-angle-right"></i></a>
                     </li>`;
        
            paginationControls.innerHTML = html;
        };
        
        
        
        paginationControls.addEventListener('click', (e) => { 
            e.preventDefault(); 
            const target = e.target.closest('.page-link'); 
            if (!target || target.parentElement.classList.contains('disabled')) return; 
        
            const page = target.dataset.page; 
        
            if (page === 'prev') { 
                if (currentPage > 1) currentPage--; 
            } 
            else if (page === 'next') { 
                const pageCount = Math.ceil(
                    Array.from(tableBody.rows)
                        .filter(r => r.dataset.filtered !== 'true')
                        .length / rowsPerPage
                ); 
                if (currentPage < pageCount) currentPage++; 
            } 
            else { 
                currentPage = parseInt(page, 10); 
            } 
        
            tableManager.setupPagination(); 
            tableManager.displayPage(currentPage); 
        });

           
           
           
           
           
           
           
            rowsPerPageSelect.addEventListener('change', (e) => { const value = e.target.value; rowsPerPage = value === 'all' ? Infinity : parseInt(value, 10); tableManager.setupPagination(); tableManager.displayPage(1); });
            filterableHeaders.forEach(th => { const index = th.dataset.columnIndex; const dropdownMenu = th.querySelector('.dropdown-menu'); const filterIcon = th.querySelector('.filter-icon'); dropdownMenu.querySelector('.apply-filter-btn').addEventListener('click', () => { if (index === '3') { const selectedMain = Array.from(dropdownMenu.querySelectorAll('.filter-options-main .form-check-input:checked')).map(cb => cb.value); const selectedSub = Array.from(dropdownMenu.querySelectorAll('.filter-options-sub .form-check-input:checked')).map(cb => cb.value); if (selectedMain.length > 0 || selectedSub.length > 0) { activeFilters[index] = { main: selectedMain, sub: selectedSub }; filterIcon.classList.add('filter-active'); } else { delete activeFilters[index]; filterIcon.classList.remove('filter-active'); } } else if (index === '5') { const from = dropdownMenu.querySelector('.date-range-from').value; const to = dropdownMenu.querySelector('.date-range-to').value; if(from || to) { activeFilters[index] = { from, to }; filterIcon.classList.add('filter-active'); } else { delete activeFilters[index]; filterIcon.classList.remove('filter-active'); } } else { const selected = Array.from(dropdownMenu.querySelectorAll('.filter-options .form-check-input:checked')).map(cb => cb.value); if (selected.length > 0) { activeFilters[index] = selected; filterIcon.classList.add('filter-active'); } else { delete activeFilters[index]; filterIcon.classList.remove('filter-active'); } } tableManager.applyAllFilters(); bootstrap.Dropdown.getInstance(filterIcon).hide(); }); dropdownMenu.querySelector('.reset-filter-btn').addEventListener('click', () => { delete activeFilters[index]; if (index === '3') { dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false); dropdownMenu.querySelectorAll('input[type="search"]').forEach(input => input.value=''); tableManager.updateSubTopicFilter(); } else if (index === '5') { dropdownMenu.querySelector('.date-range-from')._flatpickr.clear(); dropdownMenu.querySelector('.date-range-to')._flatpickr.clear(); } else { dropdownMenu.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false); const searchInput = dropdownMenu.querySelector('.filter-search'); if(searchInput) searchInput.value = ''; } filterIcon.classList.remove('filter-active'); dropdownMenu.querySelectorAll('.filter-search').forEach(input => { input.dispatchEvent(new Event('input')); }); tableManager.applyAllFilters(); bootstrap.Dropdown.getInstance(filterIcon).hide(); }); dropdownMenu.querySelectorAll('.filter-search, .filter-search-main, .filter-search-sub').forEach(searchInput => { searchInput.addEventListener('input', (e) => { const searchTerm = e.target.value.toLowerCase(); let container = e.target.closest('div').nextElementSibling; container.querySelectorAll('.form-check').forEach(item => { item.style.display = item.querySelector('label').textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none'; }); }); }); });

            // --- START: NEW EXPORT LOGIC ---
            const exportModal = new bootstrap.Modal(document.getElementById('exportOptionsModal'));
            
            function getVisibleTableData() {
                const data = [];
                const headers = ['#', 'Status', 'Mode', 'Training Topic', 'Sub Topic', 'Trainer', 'Date', 'Time', 'Participants (Present)', 'Participants (Absent)'];
                
                tableBody.querySelectorAll('tr').forEach(row => {
                    if (row.dataset.filtered !== 'true') {
                        const present = row.cells[6].querySelector('.bg-success')?.textContent || '0';
                        const absent = row.cells[6].querySelector('.bg-danger')?.textContent || '0';
                        const dateStr = row.cells[5].querySelector('small')?.textContent.trim();
                        const timeStr = row.cells[5].querySelector('span')?.textContent.trim();
                        
                        const rowData = {
                            '#': row.cells[0].textContent.trim(),
                            'Status': row.cells[1].textContent.trim(),
                            'Mode': row.cells[2].textContent.trim(),
                            'Training Topic': row.cells[3].querySelector('strong').textContent.trim(),
                            'Sub Topic': row.cells[3].querySelector('.text-muted').textContent.trim(),
                            'Trainer': row.cells[4].textContent.trim(),
                            'Date': dateStr,
                            'Time': timeStr,
                            'Participants (Present)': parseInt(present, 10),
                            'Participants (Absent)': parseInt(absent, 10),
                        };
                        data.push(rowData);
                    }
                });
                return data;
            }

            document.getElementById('confirm-export-btn').addEventListener('click', () => {
                const exportType = document.getElementById('export-type-select').value;
                const data = getVisibleTableData();

                if (data.length === 0) {
                    alert("No data available to export.");
                    return;
                }

                const wb = XLSX.utils.book_new();

                switch (exportType) {
                    case 'combined': {
                        const ws = XLSX.utils.json_to_sheet(data);
                        XLSX.utils.book_append_sheet(wb, ws, 'All Trainings');
                        XLSX.writeFile(wb, 'All_Trainings.xlsx');
                        break;
                    }
                    case 'trainer_wise': {
                        const groupedByTrainer = data.reduce((acc, row) => {
                            const trainer = row['Trainer'] || 'Unknown Trainer';
                            if (!acc[trainer]) acc[trainer] = [];
                            acc[trainer].push(row);
                            return acc;
                        }, {});

                        for (const trainerName in groupedByTrainer) {
                            const ws = XLSX.utils.json_to_sheet(groupedByTrainer[trainerName]);
                            // Sheet names have a 31-character limit
                            const safeSheetName = trainerName.substring(0, 31);
                            XLSX.utils.book_append_sheet(wb, ws, safeSheetName);
                        }
                        XLSX.writeFile(wb, 'Trainings_by_Trainer.xlsx');
                        break;
                    }
                    case 'topic_wise': {
                        const groupedByTopic = data.reduce((acc, row) => {
                            const topic = row['Training Topic'] || 'Unknown Topic';
                            if (!acc[topic]) acc[topic] = [];
                            acc[topic].push(row);
                            return acc;
                        }, {});

                        for (const topicName in groupedByTopic) {
                            const ws = XLSX.utils.json_to_sheet(groupedByTopic[topicName]);
                            const safeSheetName = topicName.substring(0, 31);
                            XLSX.utils.book_append_sheet(wb, ws, safeSheetName);
                        }
                        XLSX.writeFile(wb, 'Trainings_by_Topic.xlsx');
                        break;
                    }
                    case 'month_wise': {
                        const groupedByMonth = data.reduce((acc, row) => {
                            try {
                                const date = new Date(row['Date']);
                                // Format as 'Jan-25', 'Feb-25', etc.
                                const monthYear = date.toLocaleDateString('en-US', { month: 'short' }) + '-' + date.getFullYear().toString().slice(-2);
                                if (!acc[monthYear]) acc[monthYear] = [];
                                acc[monthYear].push(row);
                            } catch (e) {
                                // Handle invalid dates if necessary
                            }
                            return acc;
                        }, {});

                        // Sort sheets chronologically
                        const sortedKeys = Object.keys(groupedByMonth).sort((a, b) => new Date(`01-${a}`) - new Date(`01-${b}`));

                        sortedKeys.forEach(monthKey => {
                           const ws = XLSX.utils.json_to_sheet(groupedByMonth[monthKey]);
                           XLSX.utils.book_append_sheet(wb, ws, monthKey);
                        });
                        XLSX.writeFile(wb, 'Trainings_by_Month.xlsx');
                        break;
                    }
                }
                exportModal.hide();
            });
            // --- END: NEW EXPORT LOGIC ---

            document.getElementById('refresh-table-btn').addEventListener('click', (e) => { const btn = e.currentTarget; const icon = btn.querySelector('i'); icon.classList.add('fa-spin'); btn.disabled = true; setTimeout(() => { tableManager.populateFilters(); tableManager.applyAllFilters(); icon.classList.remove('fa-spin'); btn.disabled = false; }, 500); });
            // flatpickr(".date-range-from", { dateFormat: "Y-m-d" }); flatpickr(".date-range-to", { dateFormat: "Y-m-d" });
            tableManager.populateFilters(); tableManager.applyAllFilters();
        });
        
        $(document).on('click', '.open-participants-modal', function () {
            let trainingId = $(this).data('training-id');
            $('#modal-training-id').val(trainingId);
                // $.ajax({
                //     url: "{{ route('get.calendar.training.participants') }}",   
                //     method: "GET",
                //     data: { training_id: trainingId },
                //     success: function (response) {
                //      window.masterEmployeeList = response.masterEmployeeList;
                //         window.trainingParticipantData = response.trainingParticipantData;
            
                //         // Trigger custom event to populate DOM
                //         $(document).trigger('participantsDataLoaded', [trainingId]);

                //     },
                //     error: function (xhr) {
                //         console.error(xhr);
                //         // toastr.error("Failed to load participants");
                //     }
                // });
    
        });


    </script>

    <script>
        // $(document).on('participantsDataLoaded', function(event, trainingId) {
        //     populateDOM(trainingId);
        // });
        
        // function populateDOM(trainingId) {
        //     let masterEmployeeList = window.masterEmployeeList;
        //     let trainingParticipantData = window.trainingParticipantData;
        
        //     console.log("DOMContentLoadedDOMContentLoadedDOMContentLoadedDOMContentLoadedDOMContentLoadedDOMContentLoaded")
        //     console.log("window.masterEmployeeList",window.masterEmployeeList)
        //         console.log("window.trainingParticipantData",window.trainingParticipantData)
        
        //           let masterEmployeeList = window.masterEmployeeList || [];
        //           let trainingParticipantData = window.trainingParticipantData || {};
                  
        //             // let masterEmployeeList = [ { id: '151-002246', name: 'Ganesh Yadav', initials: 'GY', corporate: 'Global Tech Inc.', regional: 'North America', unit: 'Innovation Hub', gender: 'Male', email: 'e@gmail.com', phone: '982749832', department: 'Food Production', role: 'Top Management', category: 'Apprentice', foodHandler: 'Yes', joined: '2023-07-01', born: '1970-01-01' }, { id: '151-001122', name: 'Jatan Singh', initials: 'JS', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'jatan.s@example.com', phone: '9876543220', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-03-01', born: '1999-01-01' }, { id: '151-005767', name: 'Prateek Jain', initials: 'PJ', corporate: 'Global Hotels Inc.', regional: 'North America', unit: 'New York Central', gender: 'Male', email: 'prateek.j@example.com', phone: '9876543210', department: 'Engineering', role: 'Engineer', category: 'Executive', foodHandler: 'No', joined: '2022-12-15', born: '1988-03-10' }, { id: '151-008912', name: 'Priya Sharma', initials: 'PS', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Paris Charm', gender: 'Female', email: 'priya.s@example.com', phone: '9876543211', department: 'Front Office', role: 'Manager', category: 'Executive', foodHandler: 'No', joined: '2023-02-20', born: '1995-11-25' }, { id: '151-003456', name: 'Rohan Mehra', initials: 'RM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'rohan.m@example.com', phone: '9876543212', department: 'F&B Service', role: 'Captain', category: 'Staff', foodHandler: 'Yes', joined: '2021-08-01', born: '1992-07-14' }, { id: '151-009123', name: 'Anjali Verma', initials: 'AV', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Rome Boutique', gender: 'Female', email: 'anjali.v@example.com', phone: '9876543213', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-01-05', born: '1998-01-30' }, { id: '151-007788', name: 'Siddhi Mehta', initials: 'SM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Corporate HQ', gender: 'Female', email: 'siddhi@example.com', phone: '9876543214', department: 'Sales', role: 'Asst Manager', category: 'Executive', foodHandler: 'No', joined: '2020-05-18', born: '1990-09-03' }, ];
        //             // let trainingParticipantData = { '489': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present' } }, '490': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'absent', '151-007788': 'absent', '151-001122': 'absent' } }, '492': { roster: Array(26).fill(0).map((_,i) => masterEmployeeList[i % masterEmployeeList.length].id), statuses: {'151-001122': 'absent'} } };
                   
        //             const allDepartments = ["Food Production", "Engineering", "Sales", "Front Office", "Housekeeping", "F&B Service", "HR", "Kitchen"];
        //             const allRoles = ["Top Management", "Associate", "Engineer", "Manager", "Captain", "Supervisor", "Asst Manager", "Commis Chef", "Technician"];
                    
        //             const orgData = {
        //                 "Global Tech Inc.": {
        //                     "North America": {
        //                         "Innovation Hub": ["Food Production", "Engineering", "Sales"],
        //                         "New York Central": ["Front Office", "Engineering", "Sales"]
        //                     }
        //                 },
        //                 "Global Hotels Inc.": {
        //                     "Asia-Pacific": {
        //                         "Mumbai Grand": ["Housekeeping", "F&B Service", "Engineering", "Front Office"],
        //                         "Corporate HQ": ["Sales", "HR"]
        //                     }
        //                 },
        //                 "Boutique Stays LLC": {
        //                     "Europe": {
        //                         "Paris Charm": ["Front Office", "Housekeeping"],
        //                         "Rome Boutique": ["Housekeeping"]
        //                     }
        //                 }
        //             };
        
        
        //             let currentTrainingId = null; let rosterEmployeeIds = []; let selectedForAddition = []; let selectedInTableIds = [];
        //             const tableBody = document.getElementById('employee-table-body'); const selectAllTableCheckbox = document.getElementById('select-all-table-checkbox'); const markPresentBtn = document.getElementById('mark-present-btn'); const markAbsentBtn = document.getElementById('mark-absent-btn'); const mainSubmitBtn = document.getElementById('main-submit-btn');
        //             const manageParticipantsModalBody = document.querySelector('.manage-participants-modal-body'); const rosterCountsEl = document.getElementById('roster-counts');
                    
        //             const searchInput = document.getElementById('employee-search-input');
        //             const resultsContainer = document.getElementById('search-results-container');
        //             const resultsList = document.getElementById('search-results-list');
        //             const selectionPreviewContainer = document.getElementById('selected-for-addition-preview');
        //             const selectAllCheckbox = document.getElementById('select-all-checkbox');
        //             const bulkAddBtn = document.getElementById('bulk-add-btn');
        //             let currentSearchResults = [];
                    
        //             // Add/Edit Employee Modal elements
        //             const addNewEmployeeBtn = document.getElementById('add-new-employee-btn');
        //             const addEmployeeModal = document.getElementById('add-employee-modal');
        //             const addEmployeeFormContainer = document.getElementById('add-employee-form-container');
        //             const addEmployeeForm = document.getElementById('add-employee-form');
        //             const modalCloseBtn = addEmployeeFormContainer.querySelector('.close-btn');
        //             const modalCancelBtn = document.getElementById('modal-cancel-btn');
        
        
        //             function jaroWinkler(s1, s2) { let m = 0; if (s1.length === 0 || s2.length === 0) return 0; if (s1 === s2) return 1; let range = Math.floor(Math.max(s1.length, s2.length) / 2) - 1, s1Matches = new Array(s1.length), s2Matches = new Array(s2.length); for (let i = 0; i < s1.length; i++) { let low = (i >= range) ? i - range : 0, high = (i + range <= s2.length - 1) ? i + range : s2.length - 1; for (let j = low; j <= high; j++) { if (!s2Matches[j] && s1[i] === s2[j]) { s1Matches[i] = true; s2Matches[j] = true; m++; break; } } } if (m === 0) return 0; let k = 0, t = 0; for (let i = 0; i < s1.length; i++) { if (s1Matches[i]) { while (!s2Matches[k]) k++; if (s1[i] !== s2[k]) t++; k++; } } t /= 2; let jaro = ((m / s1.length) + (m / s2.length) + ((m - t) / m)) / 3; let p = 0.1, l = 0; if (jaro > 0.7) { while (s1[l] === s2[l] && l < 4) l++; jaro = jaro + l * p * (1 - jaro); } return jaro; }
        
                        
        //             // function renderSelectionPreview() {
        //             //     selectionPreviewContainer.innerHTML = '';
        //             //     if (selectedForAddition.length === 0) return;
        //             //     selectedForAddition.forEach(id => {
        //             //         const employee = masterEmployeeList.find(e => e.id === id);
        //             //         if (employee) { selectionPreviewContainer.innerHTML += `<div class="selected-preview-tag">${employee.name}<span class="remove-tag-btn" data-employee-id="${id}">Ã—</span></div>`; }
        //             //     });
        //             // }
        //               function updateAddSelectionUI() {
        //                 console.log('aaaa');
        //                 const selectionCount = selectedForAddition.length;
        //                 console.log('aaaa11111',selectionCount);
        //                 bulkAddBtn.disabled = selectionCount === 0;
        //                 bulkAddBtn.textContent = selectionCount > 0 ? `Add Selected (${selectionCount})` : 'Add Selected';
        //                 // if (selectionCount > 0) { searchActionsContainer.classList.add('visible'); renderSelectionPreview(); } else { searchActionsContainer.classList.remove('visible'); selectionPreviewContainer.innerHTML = ''; }
        //             }
        
                    
        //             let renderedEmployeeIds = [];
                    
        //             function renderSearchResults(searchTerm = '') {
        //                 resultsList.innerHTML = '';
        //                 renderedEmployeeIds = []; // reset each search
                    
        //                 if (!searchTerm.trim()) {
        //                     resultsList.innerHTML = '<li class="no-results">Please enter a search term.</li>';
        //                     selectAllCheckbox.checked = false;
        //                     resultsContainer.classList.remove('visible');
        //                     return;
        //                 }
                    
        //                 fetch(`https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/search-employees-trainer?search=${encodeURIComponent(searchTerm)}`)
        //                     .then(res => res.json())
        //                     .then(data => {
        //                         if (data.length === 0) {
        //                             resultsList.innerHTML = '<li class="no-results">No available employees found.</li>';
        //                             selectAllCheckbox.checked = false;
        //                         } else {
        //                             data.forEach(emp => {
        //                                 const empIdStr = String(emp.id); // use unique employee ID
                    
        //                                 // Skip if already rendered
        //                                 if (renderedEmployeeIds.includes(empIdStr)) return;
                    
        //                                 renderedEmployeeIds.push(empIdStr); // mark as rendered
                    
        //                                 const isSelected = selectedForAddition.includes(empIdStr);
                    
        //                                 const li = document.createElement('li');
        //                                 li.dataset.employeeId = empIdStr;
        //                                 li.innerHTML = `
        //                                     <input type="checkbox" class="emp-checkbox" ${isSelected ? 'checked' : ''}>
        //                                     <div class="result-info">
        //                                         <span class="result-name">${emp.employer_fullname}</span>
        //                                         <span class="result-details">ID: ${emp.employe_id} • Dept: ${emp.department || ''}</span>
        //                                     </div>
        //                                 `;
                    
        //                                 li.addEventListener('click', e => {
        //                                     if (e.target.tagName.toLowerCase() !== 'input') {
        //                                         const checkbox = li.querySelector('input.emp-checkbox');
        //                                         checkbox.checked = !checkbox.checked;
        //                                         toggleSelection(empIdStr);
        //                                     }
        //                                 });
                    
        //                                 li.querySelector('input.emp-checkbox').addEventListener('click', e => {
        //                                     e.stopPropagation();
        //                                     toggleSelection(empIdStr);
        //                                 });
                    
        //                                 resultsList.appendChild(li);
        //                             });
                    
        //                             // Update selectAll checkbox
        //                             selectAllCheckbox.checked = renderedEmployeeIds.every(id => selectedForAddition.includes(id));
        //                         }
                    
        //                         resultsContainer.classList.add('visible');
        //                     })
        //                     .catch(err => {
        //                         console.error(err);
        //                         resultsList.innerHTML = '<li class="no-results">Error fetching results.</li>';
        //                         selectAllCheckbox.checked = false;
        //                         resultsContainer.classList.remove('visible');
        //                     });
        //             }
        //             // ============================
        //             // Toggle Individual Selection
        //             // ============================
        //             function toggleSelection(employeeId) {
        //                 employeeId = String(employeeId);
        //                 const index = selectedForAddition.indexOf(employeeId);
        //                 if (index > -1) {
        //                     selectedForAddition.splice(index, 1);
        //                 } else {
        //                     selectedForAddition.push(employeeId);
        //                 }
                    
        //                 updateAddSelectionUI();
        //                 updateSelectAllCheckbox();
        //             }
                    
        //             // ============================
        //             // Update Select All Checkbox
        //             // ============================
        //             function updateSelectAllCheckbox() {
        //                 const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId);
        //                 if (visibleIds.length === 0) {
        //                     selectAllCheckbox.checked = false;
        //                     return;
        //                 }
        //                 selectAllCheckbox.checked = visibleIds.every(id => selectedForAddition.includes(id));
        //             }
                    
        //             // ============================
        //             // Select All Checkbox Event
        //             // ============================
        //             selectAllCheckbox.addEventListener('change', () => {
        //                 const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId);
                    
        //                 if (selectAllCheckbox.checked) {
        //                     visibleIds.forEach(id => {
        //                         if (!selectedForAddition.includes(id)) selectedForAddition.push(id);
        //                     });
        //                 } else {
        //                     selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id));
        //                 }
                    
        //                 // Update checkboxes in DOM without re-rendering
        //                 visibleIds.forEach(id => {
        //                     const li = resultsList.querySelector(`li[data-employee-id="${id}"]`);
        //                     if (li) {
        //                         const checkbox = li.querySelector('input.emp-checkbox');
        //                         if (checkbox) checkbox.checked = selectAllCheckbox.checked;
        //                     }
        //                 });
                    
        //                 updateAddSelectionUI();
        //             });
                    
        //             // ============================
        //             // Search Input Event
        //             // ============================
        //             searchInput.addEventListener('input', () => {
        //                 renderSearchResults(searchInput.value);
        //             });
                    
        //             // ============================
        //             // Update Add Button UI
        //             // ============================
        //             function updateAddSelectionUI() {
        //                 const count = selectedForAddition.length;
        //                 if (bulkAddBtn) {
        //                     bulkAddBtn.textContent = `Add Selected (${count})`;
        //                     bulkAddBtn.disabled = count === 0;
        //                 }
        //             }
                    
        //             // ============================
        //             // Bulk Add Event
        //             // ============================
        //             bulkAddBtn.addEventListener('click', () => {
                    
        //                 let trainingId = document.getElementById('modal-training-id').value;
        //             alert(trainingId)
        //                 alert(selectedForAddition)
                
        //                 if (selectedForAddition.length === 0) return;
                    
        //                 $.ajax({
        //                     url: "{{ route('add.calendar.training.participant') }}",
        //                     method: 'POST',
        //                     data: {
        //                         training_id: trainingId,
        //                         employee_ids: selectedForAddition,  // array
        //                         _token: $('meta[name="csrf-token"]').attr('content')
        //                     },
        //                     success: function (response) {
        //                         selectedForAddition = [];
        //                         updateAddSelectionUI();
        //                         toastr.success("Added successfully!");
        //                         sessionStorage.setItem('activateTab', '#trainer');
        //                         window.location.reload();
        //                     },
        //                     error: function () {
        //                         toastr.error("Failed to add employees");
        //                     }
        //                 });
        //             });
        
        //             searchInput.addEventListener('input', () => renderSearchResults(searchInput.value));
        //           searchInput.addEventListener('focus', () => renderSearchResults(searchInput.value));
        
        //             function updateRosterCounts() { let present = 0, absent = 0, neutral = 0; rosterEmployeeIds.forEach(id => { const data = trainingParticipantData[currentTrainingId]; if (data && data.statuses) { switch (data.statuses[id]) { case 'present': present++; break; case 'absent': absent++; break; default: neutral++; } } }); rosterCountsEl.innerHTML = `<span class="badge bg-success">Present: ${present}</span><span class="badge bg-danger">Absent: ${absent}</span><span class="badge bg-secondary">Neutral: ${neutral}</span>`; }
                    
        //             function renderTable() {
        //                 if (!tableBody) return;
        //                 const thead = document.querySelector('.table-wrapper thead');
        //                 if (thead) thead.style.display = 'none';
        //                 const currentData = trainingParticipantData[currentTrainingId];
        //                 const sortedRoster = rosterEmployeeIds
        //                     .map(id => {
        //                         const emp = masterEmployeeList.find(e => e.id === id);
        //                         if (emp) {
        //                             return { ...emp, status: (currentData && currentData.statuses[id]) ? currentData.statuses[id] : 'neutral' };
        //                         }
        //                         return null;
        //                     })
        //                     .filter(Boolean)
        //                     .sort((a, b) => a.name.localeCompare(b.name));
        
        //                 tableBody.innerHTML = sortedRoster.map(emp => {
        //                     if (!emp.updated) {
        //                       emp.updated = new Date(Date.now() - Math.random() * 1e10).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
        //                     }
        //                     const isSelected = selectedInTableIds.includes(emp.id);
        //                     const statusSliderHTML = `<div class="status-slider-container status-${emp.status || 'neutral'}" data-employee-id="${emp.id}"><div class="status-slider-track"><div class="status-slider-label" data-value="absent">Absent</div><div class="status-slider-label" data-value="neutral">Neutral</div><div class="status-slider-label" data-value="present">Present</div><div class="status-slider-thumb"></div></div></div>`;
        //                     const prefix = emp.gender === 'Male' ? 'Mr.' : 'Ms.';
        //                     const displayName = `${prefix} ${emp.name}`;
                            
        //                     return `
        //                     <tr class="employee-card-list-item" data-employee-id="${emp.id}">
        //                         <td class="p-0">
        //                             <div class="employee-card-row">
        //                                 <div class="card-col-select">
        //                                     <input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}>
        //                                 </div>
        
        //                                 <div class="card-col-org">
        //                                     <strong>${emp.corporate || 'N/A'}</strong>
        //                                     <span>${emp.regional || 'N/A'}</span>
        //                                     <span>${emp.unit || 'N/A'}</span>
        //                                 </div>
        
        //                                 <div class="card-col-main-info">
        //                                     <div class="avatar">${emp.initials}</div>
        //                                     <div>
        //                                         <strong>${displayName}</strong>
        //                                         <div class="details-grid">
        //                                             <span><i class="fas fa-id-card-clip"></i>ID: ${emp.id}</span>
        //                                             <span><i class="fas fa-user"></i>${emp.gender}</span>
        //                                             <span><i class="fas fa-birthday-cake"></i>Born: ${emp.born}</span>
        //                                             <span><i class="fas fa-calendar-alt"></i>Joined: ${emp.joined}</span>
        //                                             <span><i class="fas fa-clock"></i>Updated: ${emp.updated}</span>
        //                                         </div>
        //                                     </div>
        //                                 </div>
        
        //                                 <div class="card-col-contact">
        //                                     <span><i class="fas fa-envelope"></i>${emp.email}</span>
        //                                     <span><i class="fas fa-phone"></i>${emp.phone}</span>
        //                                 </div>
        
        //                                 <div class="card-col-role">
        //                                     <strong>${emp.department || 'N/A'}</strong>
        //                                     <span>${emp.role || 'N/A'}</span>
        //                                     <span>Responsibility: ${emp.department || 'N/A'}</span>
        //                                 </div>
        
        //                                 <div class="card-col-category">
        //                                     <strong>${emp.category || 'N/A'}</strong>
        //                                     <span>Food Handler: ${emp.foodHandler}</span>
        //                                 </div>
                                        
        //                                 <div class="card-col-status">
        //                                      ${statusSliderHTML}
        //                                 </div>
        
        //                                 <div class="card-col-actions">
        //                                     <i class="fas fa-trash-alt icon" title="Remove from Roster"></i>
        //                                 </div>
        //                             </div>
        //                         </td>
        //                     </tr>`;
        //                 }).join('');
        
        //                 updateBulkActionButtons();
        //                 updateSelectAllTableCheckboxState();
        //                 updateRosterCounts();
        //             }
        
        
        //                 function updateBulkActionButtons() {
        //                     const hasSelection = selectedInTableIds.length > 0; markActiveBtn.disabled = !hasSelection; markInactiveBtn.disabled = !hasSelection;
        //                 }
        //                 function updateSelectAllTableCheckboxState() { 
        //                       console.log('ccccc');
        //                     const individualRows = tableBody.querySelectorAll('tr'); if (individualRows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const visibleIdsOnPage = Array.from(individualRows).map(row => row.dataset.employeeId); const selectedOnPage = visibleIdsOnPage.filter(id => selectedInTableIds.includes(id));
        //                     const allSelectedOnPage = visibleIdsOnPage.length > 0 && selectedOnPage.length === visibleIdsOnPage.length; selectAllTableCheckbox.checked = allSelectedOnPage; 
        //                     selectAllTableCheckbox.indeterminate = selectedOnPage.length > 0 && !allSelectedOnPage;
        //                 }
                        
            
        //             // function updateBulkActionButtons() { const hasSelection = selectedInTableIds.length > 0; markPresentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; markAbsentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; }
        //             // function updateSelectAllTableCheckboxState() { if(!selectAllTableCheckbox || !tableBody) return; const rows = tableBody.querySelectorAll('tr'); if (rows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const allSelected = rows.length > 0 && rows.length === selectedInTableIds.length; selectAllTableCheckbox.checked = allSelected; selectAllTableCheckbox.indeterminate = selectedInTableIds.length > 0 && !allSelected; }
        //             function bulkUpdateStatus(newStatus) { selectedInTableIds.forEach(id => { trainingParticipantData[currentTrainingId].statuses[id] = newStatus; }); selectedInTableIds = []; renderTable(); }
                    
        //             const manageParticipantsModalEl = document.getElementById('manageParticipantsModal');
        //             manageParticipantsModalEl.addEventListener('show.bs.modal', function(event) { currentTrainingId = event.relatedTarget.dataset.trainingId; if (!trainingParticipantData[currentTrainingId]) { trainingParticipantData[currentTrainingId] = { roster: [], statuses: {} }; } rosterEmployeeIds = [...trainingParticipantData[currentTrainingId].roster]; selectedInTableIds = []; selectedForAddition = []; renderTable(); });
        //             if(tableBody) tableBody.addEventListener('click', (e) => { const row = e.target.closest('tr[data-employee-id]'); if (!row) return; const employeeId = row.dataset.employeeId; if (e.target.classList.contains('row-checkbox')) { if (e.target.checked) { if (!selectedInTableIds.includes(employeeId)) selectedInTableIds.push(employeeId); } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } updateBulkActionButtons(); updateSelectAllTableCheckboxState(); } else if (e.target.closest('.fa-trash-alt')) { if (confirm(`Remove ${row.querySelector('.card-col-main-info strong').textContent.trim()} from this training?`)) { rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId); delete trainingParticipantData[currentTrainingId].statuses[employeeId]; selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); renderTable(); } } const sliderLabel = e.target.closest('.status-slider-label'); if (sliderLabel) { const newStatus = sliderLabel.dataset.value; if (trainingParticipantData[currentTrainingId].statuses[employeeId] !== newStatus) { trainingParticipantData[currentTrainingId].statuses[employeeId] = newStatus; const sliderContainer = sliderLabel.closest('.status-slider-container'); sliderContainer.className = 'status-slider-container'; sliderContainer.classList.add(`status-${newStatus}`); updateRosterCounts(); } } });
        //             if(markPresentBtn) markPresentBtn.addEventListener('click', () => bulkUpdateStatus('present'));
        //             if(markAbsentBtn) markAbsentBtn.addEventListener('click', () => bulkUpdateStatus('absent'));
        //             if(mainSubmitBtn) mainSubmitBtn.addEventListener('click', () => { if (!currentTrainingId) return; trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds; let presentCount = 0, absentCount = 0; Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => { if (status === 'present') presentCount++; if (status === 'absent') absentCount++; }); const mainTableRow = document.querySelector(`button[data-training-id="${currentTrainingId}"]`)?.closest('tr'); if(mainTableRow) { mainTableRow.querySelector('.badge.bg-success').textContent = presentCount; mainTableRow.querySelector('.badge.bg-danger').textContent = absentCount; } window.tableManager.updateDashboardMetrics(); bootstrap.Modal.getInstance(manageParticipantsModalEl).hide(); });
        
        //             // File Upload and Review Logic 
        //             const uploadFileBtn = document.getElementById('upload-file-btn'); const uploadFileModalEl = document.getElementById('uploadFileModal'); const uploadFileModal = new bootstrap.Modal(uploadFileModalEl, { keyboard: false }); const fileUploadStep = document.getElementById('upload-file-step'); const pdfLoadingStep = document.getElementById('pdf-loading-step'); const pdfReviewStep = document.getElementById('pdf-review-step'); const fileUploadInput = document.getElementById('file-upload-input'); const handwritingOptionWrapper = document.getElementById('handwriting-option-wrapper'); const detectHandwritingCheckbox = document.getElementById('detect-handwriting-checkbox'); const extractTableBtn = document.getElementById('extract-table-btn'); const pdfBackBtn = document.getElementById('pdf-back-btn'); const importParticipantsBtn = document.getElementById('import-participants-btn'); const loadingText = document.getElementById('loading-text'); const mapIdSelect = document.getElementById('map-id-select'); const mapNameSelect = document.getElementById('map-name-select'); const mapDepartmentSelect = document.getElementById('map-department-select'); const reviewThead = document.getElementById('pdf-review-thead'); const reviewTbody = document.getElementById('reviewed-participants-tbody'); const downloadSampleCsvBtn = document.getElementById('download-sample-csv-btn'); let simulatedExtractedData = [];
                    
        //             function triggerCsvDownload(csvString, filename) {
        //                 const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
        //                 const link = document.createElement('a');
        //                 if (link.download !== undefined) {
        //                     const url = URL.createObjectURL(blob);
        //                     link.setAttribute('href', url);
        //                     link.setAttribute('download', filename);
        //                     link.style.visibility = 'hidden';
        //                     document.body.appendChild(link);
        //                     link.click();
        //                     document.body.removeChild(link);
        //                     URL.revokeObjectURL(url);
        //                 }
        //             }
        
        //             if (downloadSampleCsvBtn) {
        //                 downloadSampleCsvBtn.addEventListener('click', (e) => {
        //                     e.preventDefault();
        //                     const csvHeaders = ['Sr. No', 'Participant Name', 'Department', 'Designation'];
        //                     const csvRows = [
        //                         ['151-001234', 'Amit Kumar', 'Housekeeping', 'Associate'],
        //                         ['151-005678', 'Sunita Sharma', 'F&B Service', 'Captain'],
        //                         ['151-009012', 'Rajesh Patel', 'Engineering', 'Technician']
        //                     ];
        //                     const csvContent = [
        //                         csvHeaders.join(','),
        //                         ...csvRows.map(row => row.join(','))
        //                     ].join('\n');
        //                     triggerCsvDownload(csvContent, 'sample_participants.csv');
        //                 });
        //             }
        
        //             function showFileUploadStep(step) { fileUploadStep.style.display = 'none'; pdfLoadingStep.style.display = 'none'; pdfReviewStep.style.display = 'none'; if (step === 'upload') fileUploadStep.style.display = 'block'; if (step === 'loading') pdfLoadingStep.style.display = 'block'; if (step === 'review') pdfReviewStep.style.display = 'block'; }
        //             uploadFileModalEl.addEventListener('hidden.bs.modal', () => { showFileUploadStep('upload'); fileUploadInput.value = ''; handwritingOptionWrapper.style.display = 'none'; detectHandwritingCheckbox.checked = false; if(extractTableBtn) extractTableBtn.disabled = true; });
        //             if (uploadFileBtn) { uploadFileBtn.addEventListener('click', () => { showFileUploadStep('upload'); uploadFileModal.show(); }); }
        //             if (fileUploadInput) { fileUploadInput.addEventListener('change', () => { extractTableBtn.disabled = !fileUploadInput.files.length; if(fileUploadInput.files.length > 0) { const fileExtension = fileUploadInput.files[0].name.split('.').pop().toLowerCase(); handwritingOptionWrapper.style.display = fileExtension === 'pdf' ? 'block' : 'none'; } else { handwritingOptionWrapper.style.display = 'none'; } }); }
        //             if (extractTableBtn) { extractTableBtn.addEventListener('click', () => { const file = fileUploadInput.files[0]; if (!file) return; const fileExtension = file.name.split('.').pop().toLowerCase(); showFileUploadStep('loading'); if (fileExtension === 'csv') { loadingText.textContent = "Parsing CSV file..."; const reader = new FileReader(); reader.onload = (e) => { const text = e.target.result; const rows = text.split('\n').filter(row => row.trim() !== ''); const headers = rows.shift().split(',').map(h => h.trim().replace(/"/g, '')); const headerMap = { "Unit Name": "Department", "ID Number": "Sr. No", "Employee Name": "Participant Name" }; const internalHeaders = headers.map(h => headerMap[h] || h); simulatedExtractedData = rows.map(row => { const values = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g).map(v => v.trim().replace(/"/g, '')); let obj = {}; headers.forEach((header, index) => { obj[headerMap[header] || header] = values[index]; }); return obj; }); populateReviewUI(internalHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }; reader.readAsText(file); } else if (fileExtension === 'pdf') { const detectHandwriting = detectHandwritingCheckbox.checked; loadingText.textContent = detectHandwriting ? "Analyzing document layout and performing OCR/HCR..." : "Analyzing PDF..."; setTimeout(() => { const baseData = [ { "Sr. No": "151-001122", "Participant Name": "Jatan Singh", "Department": "Housekeeping", "Designation": "Associate" }, { "Sr. No": "151-002246", "Participant Name": "Ganesh Y.", "Department": "Engineering", "Designation": "Supervisor" }, { "Sr. No": "999-12345", "Participant Name": "Joy Guha Roy", "Department": "Kitchen", "Designation": "Commis Chef" } ]; const pdfHeaders = ["Sr. No", "Participant Name", "Department", "Designation"]; simulatedExtractedData = detectHandwriting ? JSON.parse(JSON.stringify(baseData)).map(row => { /* ... handwritten logic ... */ return row; }) : JSON.parse(JSON.stringify(baseData)); populateReviewUI(pdfHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }, detectHandwriting ? 2500 : 1000); } }); }
        //             function populateReviewUI(headers, autoSelect) { const optionsHtml = headers.map(h => `<option value="${h}">${h}</option>`).join(''); mapIdSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapNameSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapDepartmentSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapIdSelect.value = autoSelect.id; mapNameSelect.value = autoSelect.name; mapDepartmentSelect.value = autoSelect.dept; reviewThead.innerHTML = `<tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>`; reviewTbody.innerHTML = simulatedExtractedData.map(row => `<tr>${headers.map(h => `<td class="${row.handwritten && row.handwritten[h] ? 'handwritten-text' : ''}">${row[h] !== undefined ? row[h] : ''}</td>`).join('')}</tr>`).join(''); showFileUploadStep('review'); }
        //             if (pdfBackBtn) { pdfBackBtn.addEventListener('click', () => { showFileUploadStep('upload'); }); }
        //             if (importParticipantsBtn) { 
        //                 importParticipantsBtn.addEventListener('click', () => { 
        //                     const idCol = mapIdSelect.value, nameCol = mapNameSelect.value, deptCol = mapDepartmentSelect.value, roleCol = 'Designation';
        //                     if (!nameCol) { alert('Please map the Full Name column.'); return; } 
        //                     const reviewSection = document.getElementById('pdf-review-section'); 
        //                     const reviewTbody = document.getElementById('reviewed-participants-tbody'); 
        //                     reviewTbody.innerHTML = ''; 
        
        //                     // Get a list of names currently in the roster for quick checking
        //                     const rosterNames = rosterEmployeeIds.map(id => masterEmployeeList.find(emp => emp.id === id)?.name.toLowerCase());
        
        //                     simulatedExtractedData.forEach(rowData => { 
        //                         const importedName = rowData[nameCol] || '', importedId = rowData[idCol] || '', importedDept = rowData[deptCol] || '', importedRole = rowData[roleCol] || ''; 
        //                         const initials = importedName.split(' ').map(n=>n[0]).join('').toUpperCase(); 
                                
        //                         // Check for duplicate names already in the roster
        //                         const isInRoster = rosterNames.some(rosterName => jaroWinkler(importedName.toLowerCase(), rosterName) > 0.9);
        //                         const rosterBadge = isInRoster ? `<span class="badge bg-warning ms-2">In Roster</span>` : '';
        
        //                         let matches = []; 
        //                         const idMatch = masterEmployeeList.find(e=>e.id===importedId); 
        //                         if (idMatch){ matches.push({employee:idMatch, score:1, isIdMatch:true}); } 
        //                         else if(importedName) { matches = masterEmployeeList.map(emp => ({employee:emp, score: jaroWinkler(importedName.toLowerCase(), emp.name.toLowerCase()), isIdMatch:false})).filter(m=>m.score > 0.8 && !rosterEmployeeIds.includes(m.employee.id)).sort((a,b)=>b.score - a.score).slice(0,3); } 
                                
        //                         const popoverContent = (emp) => `<strong>ID:</strong> ${emp.id}<br><strong>Unit:</strong> ${emp.unit || 'N/A'}`; 
        //                         let suggestionsHTML = matches.length > 0 ? matches.map(m => `<a href="#" class="suggestion-link" data-employee='${JSON.stringify(m.employee)}' data-bs-toggle="popover" data-bs-trigger="hover" title="DB Record: ${m.employee.name}" data-bs-content="${popoverContent(m.employee)}"><i class="fas ${m.isIdMatch ? 'fa-id-badge text-success' : 'fa-user text-primary'} me-2"></i> ${m.employee.name} <span class="badge ${m.isIdMatch ? 'bg-success' : 'bg-primary'} float-end">${m.isIdMatch ? 'ID Match' : (m.score * 100).toFixed(0) + '%'}</span></a>`).join('') : '<div class="no-suggestions">No matches in DB.</div>'; 
                                
        //                         const actionsHTML = `<button class="btn btn-sm btn-outline-success add-reviewed-participant-btn" title="Add to Roster"><i class="fas fa-check"></i></button> ${matches.length === 0 ? `<button class="btn btn-sm btn-outline-primary add-manual-btn" title="Add as new employee"><i class="fas fa-user-plus"></i></button>` : ''} <button class="btn btn-sm btn-outline-danger discard-reviewed-participant-btn" title="Discard row"><i class="fas fa-trash"></i></button>`; 
                                
        //                         const createSelect = (options, selectedValue) => {
        //                             let uniqueOptions = [...new Set([...options, selectedValue].filter(Boolean))].sort();
        //                             return `<select class="form-select form-select-sm">${uniqueOptions.map(opt => `<option value="${opt}" ${opt === selectedValue ? 'selected' : ''}>${opt}</option>`).join('')}</select>`;
        //                         };
        
        //                         const deptDropdown = createSelect(allDepartments, importedDept);
        //                         const roleDropdown = createSelect(allRoles, importedRole);
        
        //                         const tr = document.createElement('tr'); 
        //                         tr.innerHTML = `<td><div class="employee-cell imported-info"><div class="avatar">${initials}</div><div class="employee-info w-100"><div class="name"><span contenteditable="true" class="imported-name-cell">${importedName}</span><span class="badge bg-success ms-2 matched-indicator" style="display:none;">Matched</span>${rosterBadge}</div><div class="imported-details"><div><small>ID:</small><span contenteditable="true" class="editable-id">${importedId}</span></div><div><small>Dept:</small><span class="editable-dept">${deptDropdown}</span></div><div><small>Role:</small><span class="editable-role">${roleDropdown}</span></div></div></div></div></td><td><div class="suggestions-container"><h6>Potential Matches</h6>${suggestionsHTML}</div></td><td class="action-cell">${actionsHTML}</td>`; 
        //                         reviewTbody.appendChild(tr); 
        //                     }); 
        //                     new bootstrap.Popover(reviewTbody, { selector: '[data-bs-toggle="popover"]', container: 'body', trigger: 'hover focus', html: true }); 
        //                     reviewSection.style.display = 'block'; 
        //                     uploadFileModal.hide(); 
        //                 }); 
        //             }
        //             function addParticipantToRoster(data) { if (!data.id && !data.name) return; if (!data.id) data.id = `NEW-${Date.now().toString().slice(-6)}`; if (rosterEmployeeIds.includes(data.id)) return; if (!masterEmployeeList.some(emp => emp.id === data.id)) { masterEmployeeList.push({ id: data.id, name: data.name, initials: data.name.split(' ').map(n => n[0]).join('').toUpperCase(), department: data.department, role: data.role, status: 'neutral' }); } rosterEmployeeIds.push(data.id); trainingParticipantData[currentTrainingId].statuses[data.id] = 'neutral'; renderTable(); }
        //             if(manageParticipantsModalBody) { manageParticipantsModalBody.addEventListener('click', e => { const targetBtn = e.target.closest('a, button'); if (!targetBtn) return; e.preventDefault(); const reviewTbody = document.getElementById('reviewed-participants-tbody'); if (targetBtn.matches('.suggestion-link')) { const tr = targetBtn.closest('tr'); const employeeData = JSON.parse(targetBtn.dataset.employee); tr.querySelector('.editable-id').textContent = employeeData.id; tr.querySelector('.imported-name-cell').textContent = employeeData.name; tr.querySelector('.editable-dept select').value = employeeData.department || ''; tr.querySelector('.editable-role select').value = employeeData.role || ''; tr.querySelector('.matched-indicator').style.display = 'inline-block'; } if (targetBtn.matches('.add-manual-btn')) { const tr = targetBtn.closest('tr'); addEmployeeModal.dataset.sourceRowIndex = Array.from(reviewTbody.children).indexOf(tr); addEmployeeForm.reset(); document.getElementById('add-employee-form-container').querySelector('h2').textContent = "Add New User from Import"; document.getElementById('full-name').value = tr.querySelector('.imported-name-cell').textContent.trim(); document.getElementById('employee-id').value = tr.querySelector('.editable-id').textContent.trim(); document.getElementById('department-select').value = tr.querySelector('.editable-dept select').value; document.getElementById('designation').value = tr.querySelector('.editable-role select').value; addEmployeeModal.classList.add('visible'); } if (targetBtn.matches('.add-reviewed-participant-btn')) { const tr = targetBtn.closest('tr'); const employeeName = tr.querySelector('.imported-name-cell').textContent.trim(); if (!employeeName) { alert('Participant Name cannot be empty.'); return; } addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: employeeName, department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); tr.remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.matches('.discard-reviewed-participant-btn')) { targetBtn.closest('tr').remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.id === 'add-all-reviewed-btn') { if (confirm(`Add all ${reviewTbody.rows.length} participants?`)) { [...reviewTbody.rows].forEach(tr => { addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: tr.querySelector('.imported-name-cell').textContent.trim(), department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); }); reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } if (targetBtn.id === 'discard-all-reviewed-btn') { if (confirm('Discard all imported participants?')) { reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } }); }
                    
        //             function initAddEmployeeForm() {
        //                 const corporateSelect = document.getElementById('corporate-select');
        //                 const regionalSelect = document.getElementById('regional-select');
        //                 const unitSelect = document.getElementById('unit-select');
        //                 const departmentSelect = document.getElementById('department-select');
        
        //                 function populateDropdown(selectElement, options, placeholder) {
        //                     selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        //                     options.forEach(option => selectElement.add(new Option(option, option)));
        //                     selectElement.disabled = options.length === 0;
        //                 }
        
        //                 populateDropdown(corporateSelect, Object.keys(orgData), 'Select Corporate');
        
        //                 corporateSelect.addEventListener('change', () => {
        //                     const selectedCorporate = corporateSelect.value;
        //                     const regionals = selectedCorporate ? Object.keys(orgData[selectedCorporate]) : [];
        //                     populateDropdown(regionalSelect, regionals, 'Select Regional');
        //                     populateDropdown(unitSelect, [], 'Select Unit');
        //                     $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
        //                 });
                        
        //                 regionalSelect.addEventListener('change', () => {
        //                     const selectedCorporate = corporateSelect.value;
        //                     const selectedRegional = regionalSelect.value;
        //                     const units = selectedCorporate && selectedRegional ? Object.keys(orgData[selectedCorporate][selectedRegional]) : [];
        //                     populateDropdown(unitSelect, units, 'Select Unit');
        //                     $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
        //                 });
        
        //                 unitSelect.addEventListener('change', () => {
        //                     const selectedCorporate = corporateSelect.value;
        //                     const selectedRegional = regionalSelect.value;
        //                     const selectedUnit = unitSelect.value;
        //                     const departments = selectedCorporate && selectedRegional && selectedUnit ? orgData[selectedCorporate][selectedRegional][selectedUnit] : [];
        //                     $(departmentSelect).empty().append('<option value="">Select Department</option>');
        //                     departments.forEach(dept => $(departmentSelect).append(new Option(dept, dept)));
        //                     $(departmentSelect).prop('disabled', departments.length === 0).selectpicker('refresh');
        //                 });
                        
        //                 function hideAddEmployeeModal() {
        //                     addEmployeeModal.classList.remove('visible');
        //                     addEmployeeForm.reset();
        //                     populateDropdown(regionalSelect, [], 'Select Regional');
        //                     populateDropdown(unitSelect, [], 'Select Unit');
        //                     $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
        //                     delete addEmployeeModal.dataset.sourceRowIndex; 
        //                 }
        
        //                 if (modalCloseBtn) modalCloseBtn.addEventListener('click', hideAddEmployeeModal);
        //                 if (modalCancelBtn) modalCancelBtn.addEventListener('click', hideAddEmployeeModal);
        
        //                 if (addNewEmployeeBtn) {
        //                     addNewEmployeeBtn.addEventListener('click', () => {
        //                         addEmployeeForm.reset();
        //                         addEmployeeFormContainer.querySelector('h2').textContent = "Add New Employee";
        //                         delete addEmployeeModal.dataset.sourceRowIndex;
        //                         addEmployeeModal.classList.add('visible');
        //                     });
        //                 }
                        
        //                 if (addEmployeeForm) {
        //                     addEmployeeForm.addEventListener('submit', (e) => {
        //                         e.preventDefault();
        //                         const newEmployee = {
        //                             id: document.getElementById('employee-id').value.trim(),
        //                             name: document.getElementById('full-name').value.trim(),
        //                             corporate: corporateSelect.value,
        //                             regional: regionalSelect.value,
        //                             unit: unitSelect.value,
        //                             department: $(departmentSelect).val(),
        //                             email: document.getElementById('email').value.trim(),
        //                             phone: document.getElementById('contact').value.trim(),
        //                             gender: document.getElementById('gender').value,
        //                             role: document.getElementById('designation').value.trim(),
        //                             joined: document.getElementById('date-joining').value,
        //                             born: document.getElementById('date-birth').value,
        //                             category: document.getElementById('staff-category').value,
        //                             foodHandler: document.getElementById('food-handlers-category').value
        //                         };
        //                         newEmployee.initials = newEmployee.name.split(' ').map(n => n[0]).join('').toUpperCase();
        //                         if (!newEmployee.id || !newEmployee.name) {
        //                             alert('Employee ID and Full Name are required.');
        //                             return;
        //                         }
        //                         if (masterEmployeeList.some(emp => emp.id === newEmployee.id)) {
        //                             alert(`An employee with ID ${newEmployee.id} already exists.`);
        //                             return;
        //                         }
        //                         masterEmployeeList.unshift(newEmployee);
        //                         addParticipantToRoster(newEmployee);
        //                         if (addEmployeeModal.dataset.sourceRowIndex) {
        //                             const reviewTbody = document.getElementById('reviewed-participants-tbody');
        //                             const rowIndex = parseInt(addEmployeeModal.dataset.sourceRowIndex, 10);
        //                             if (reviewTbody.rows[rowIndex]) { reviewTbody.rows[rowIndex].remove(); }
        //                              if (reviewTbody.rows.length === 0) { document.getElementById('pdf-review-section').style.display = 'none'; }
        //                         }
        //                         hideAddEmployeeModal();
        //                     });
        //                 }
        //             }
        //             initAddEmployeeForm();
        //         // });
        //     }
    
    
        document.addEventListener('DOMContentLoaded', () => {
             let masterEmployeeList =  window.allMasterList;
             console.log("masterEmployeeList",masterEmployeeList);
             
             let trainingParticipantData =  window.allTrainingParticipantData;
                         console.log("trainingParticipantData",trainingParticipantData);

            // let masterEmployeeList = [ { id: '151-002246', name: 'Ganesh Yadav', initials: 'GY', corporate: 'Global Tech Inc.', regional: 'North America', unit: 'Innovation Hub', gender: 'Male', email: 'e@gmail.com', phone: '982749832', department: 'Food Production', role: 'Top Management', category: 'Apprentice', foodHandler: 'Yes', joined: '2023-07-01', born: '1970-01-01' }, { id: '151-001122', name: 'Jatan Singh', initials: 'JS', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'jatan.s@example.com', phone: '9876543220', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-03-01', born: '1999-01-01' }, { id: '151-005767', name: 'Prateek Jain', initials: 'PJ', corporate: 'Global Hotels Inc.', regional: 'North America', unit: 'New York Central', gender: 'Male', email: 'prateek.j@example.com', phone: '9876543210', department: 'Engineering', role: 'Engineer', category: 'Executive', foodHandler: 'No', joined: '2022-12-15', born: '1988-03-10' }, { id: '151-008912', name: 'Priya Sharma', initials: 'PS', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Paris Charm', gender: 'Female', email: 'priya.s@example.com', phone: '9876543211', department: 'Front Office', role: 'Manager', category: 'Executive', foodHandler: 'No', joined: '2023-02-20', born: '1995-11-25' }, { id: '151-003456', name: 'Rohan Mehra', initials: 'RM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Mumbai Grand', gender: 'Male', email: 'rohan.m@example.com', phone: '9876543212', department: 'F&B Service', role: 'Captain', category: 'Staff', foodHandler: 'Yes', joined: '2021-08-01', born: '1992-07-14' }, { id: '151-009123', name: 'Anjali Verma', initials: 'AV', corporate: 'Boutique Stays LLC', regional: 'Europe', unit: 'Rome Boutique', gender: 'Female', email: 'anjali.v@example.com', phone: '9876543213', department: 'Housekeeping', role: 'Associate', category: 'Staff', foodHandler: 'No', joined: '2024-01-05', born: '1998-01-30' }, { id: '151-007788', name: 'Siddhi Mehta', initials: 'SM', corporate: 'Global Hotels Inc.', regional: 'Asia-Pacific', unit: 'Corporate HQ', gender: 'Female', email: 'siddhi@example.com', phone: '9876543214', department: 'Sales', role: 'Asst Manager', category: 'Executive', foodHandler: 'No', joined: '2020-05-18', born: '1990-09-03' }, ];
            // let trainingParticipantData = { '489': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present' } }, '490': { roster: ['151-002246', '151-001122', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122', '151-002246', '151-005767', '151-008912', '151-003456', '151-009123', '151-007788', '151-001122'], statuses: { '151-002246': 'present', '151-001122': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'present', '151-007788': 'present', '151-001122': 'present', '151-002246': 'present', '151-005767': 'present', '151-008912': 'present', '151-003456': 'present', '151-009123': 'absent', '151-007788': 'absent', '151-001122': 'absent' } }, '492': { roster: Array(26).fill(0).map((_,i) => masterEmployeeList[i % masterEmployeeList.length].id), statuses: {'151-001122': 'absent'} } };
           
            const allDepartments = ["Food Production", "Engineering", "Sales", "Front Office", "Housekeeping", "F&B Service", "HR", "Kitchen"];
            const allRoles = ["Top Management", "Associate", "Engineer", "Manager", "Captain", "Supervisor", "Asst Manager", "Commis Chef", "Technician"];
            
            const orgData = {
                "Global Tech Inc.": {
                    "North America": {
                        "Innovation Hub": ["Food Production", "Engineering", "Sales"],
                        "New York Central": ["Front Office", "Engineering", "Sales"]
                    }
                },
                "Global Hotels Inc.": {
                    "Asia-Pacific": {
                        "Mumbai Grand": ["Housekeeping", "F&B Service", "Engineering", "Front Office"],
                        "Corporate HQ": ["Sales", "HR"]
                    }
                },
                "Boutique Stays LLC": {
                    "Europe": {
                        "Paris Charm": ["Front Office", "Housekeeping"],
                        "Rome Boutique": ["Housekeeping"]
                    }
                }
            };


            let currentTrainingId = null; let rosterEmployeeIds = []; let selectedForAddition = []; let selectedInTableIds = [];
            const tableBody = document.getElementById('employee-table-body'); const selectAllTableCheckbox = document.getElementById('select-all-table-checkbox'); const markPresentBtn = document.getElementById('mark-present-btn'); const markAbsentBtn = document.getElementById('mark-absent-btn'); const mainSubmitBtn = document.getElementById('main-submit-btn');
            const manageParticipantsModalBody = document.querySelector('.manage-participants-modal-body'); const rosterCountsEl = document.getElementById('roster-counts');
            
            const searchInput = document.getElementById('employee-search-input');
            const resultsContainer = document.getElementById('search-results-container');
            const resultsList = document.getElementById('search-results-list');
            const selectionPreviewContainer = document.getElementById('selected-for-addition-preview');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const bulkAddBtn = document.getElementById('bulk-add-btn');
            let currentSearchResults = [];
            
            // Add/Edit Employee Modal elements
            const addNewEmployeeBtn = document.getElementById('add-new-employee-btn');
            const addEmployeeModal = document.getElementById('add-employee-modal');
            const addEmployeeFormContainer = document.getElementById('add-employee-form-container');
            const addEmployeeForm = document.getElementById('add-employee-form');
            const modalCloseBtn = addEmployeeFormContainer.querySelector('.close-btn');
            const modalCancelBtn = document.getElementById('modal-cancel-btn');


            function jaroWinkler(s1, s2) { let m = 0; if (s1.length === 0 || s2.length === 0) return 0; if (s1 === s2) return 1; let range = Math.floor(Math.max(s1.length, s2.length) / 2) - 1, s1Matches = new Array(s1.length), s2Matches = new Array(s2.length); for (let i = 0; i < s1.length; i++) { let low = (i >= range) ? i - range : 0, high = (i + range <= s2.length - 1) ? i + range : s2.length - 1; for (let j = low; j <= high; j++) { if (!s2Matches[j] && s1[i] === s2[j]) { s1Matches[i] = true; s2Matches[j] = true; m++; break; } } } if (m === 0) return 0; let k = 0, t = 0; for (let i = 0; i < s1.length; i++) { if (s1Matches[i]) { while (!s2Matches[k]) k++; if (s1[i] !== s2[k]) t++; k++; } } t /= 2; let jaro = ((m / s1.length) + (m / s2.length) + ((m - t) / m)) / 3; let p = 0.1, l = 0; if (jaro > 0.7) { while (s1[l] === s2[l] && l < 4) l++; jaro = jaro + l * p * (1 - jaro); } return jaro; }

                
        // function renderSelectionPreview() {
        //     selectionPreviewContainer.innerHTML = '';
        //     if (selectedForAddition.length === 0) return;
        //     selectedForAddition.forEach(id => {
        //         const employee = masterEmployeeList.find(e => e.id === id);
        //         if (employee) { selectionPreviewContainer.innerHTML += `<div class="selected-preview-tag">${employee.name}<span class="remove-tag-btn" data-employee-id="${id}">Ã—</span></div>`; }
        //     });
        // }
      function updateAddSelectionUI() {
        const selectionCount = selectedForAddition.length;
        bulkAddBtn.disabled = selectionCount === 0;
        bulkAddBtn.textContent = selectionCount > 0 ? `Add Selected (${selectionCount})` : 'Add Selected';
        // if (selectionCount > 0) { searchActionsContainer.classList.add('visible'); renderSelectionPreview(); } else { searchActionsContainer.classList.remove('visible'); selectionPreviewContainer.innerHTML = ''; }
     }

   
    
    
    
    
    let renderedEmployeeIds = [];
    
    function renderSearchResults(searchTerm = '') {
        resultsList.innerHTML = '';
        renderedEmployeeIds = []; // reset each search
    
        if (!searchTerm.trim()) {
            resultsList.innerHTML = '<li class="no-results">Please enter a search term.</li>';
            selectAllCheckbox.checked = false;
            resultsContainer.classList.remove('visible');
            return;
        }
    
        fetch(`https://efsm.safefoodmitra.com/admin/public/index.php/training/trainer/search-employees-trainer?search=${encodeURIComponent(searchTerm)}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    resultsList.innerHTML = '<li class="no-results">No available employees found.</li>';
                    selectAllCheckbox.checked = false;
                } else {
                    data.forEach(emp => {
                        const empIdStr = String(emp.id); // use unique employee ID
    
                        // Skip if already rendered
                        if (renderedEmployeeIds.includes(empIdStr)) return;
    
                        renderedEmployeeIds.push(empIdStr); // mark as rendered
    
                        const isSelected = selectedForAddition.includes(empIdStr);
    
                        const li = document.createElement('li');
                        li.dataset.employeeId = empIdStr;
                        li.innerHTML = `
                            <input type="checkbox" class="emp-checkbox" ${isSelected ? 'checked' : ''}>
                            <div class="result-info">
                                <span class="result-name">${emp.employer_fullname}</span>
                                <span class="result-details">ID: ${emp.employe_id} • Dept: ${emp.department || ''}</span>
                            </div>
                        `;
    
                        li.addEventListener('click', e => {
                            if (e.target.tagName.toLowerCase() !== 'input') {
                                const checkbox = li.querySelector('input.emp-checkbox');
                                checkbox.checked = !checkbox.checked;
                                toggleSelection(empIdStr);
                            }
                        });
    
                        li.querySelector('input.emp-checkbox').addEventListener('click', e => {
                            e.stopPropagation();
                            toggleSelection(empIdStr);
                        });
    
                        resultsList.appendChild(li);
                    });
    
                    // Update selectAll checkbox
                    selectAllCheckbox.checked = renderedEmployeeIds.every(id => selectedForAddition.includes(id));
                }
    
                resultsContainer.classList.add('visible');
            })
            .catch(err => {
                console.error(err);
                resultsList.innerHTML = '<li class="no-results">Error fetching results.</li>';
                selectAllCheckbox.checked = false;
                resultsContainer.classList.remove('visible');
            });
    }
    // ============================
    // Toggle Individual Selection
    // ============================
    function toggleSelection(employeeId) {
        employeeId = String(employeeId);
        const index = selectedForAddition.indexOf(employeeId);
        if (index > -1) {
            selectedForAddition.splice(index, 1);
        } else {
            selectedForAddition.push(employeeId);
        }
    
        updateAddSelectionUI();
        updateSelectAllCheckbox();
    }
    
    // ============================
    // Update Select All Checkbox
    // ============================
    function updateSelectAllCheckbox() {
        const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId);
        if (visibleIds.length === 0) {
            selectAllCheckbox.checked = false;
            return;
        }
        selectAllCheckbox.checked = visibleIds.every(id => selectedForAddition.includes(id));
    }
    
    // ============================
    // Select All Checkbox Event
    // ============================
    selectAllCheckbox.addEventListener('change', () => {
        const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId);
    
        if (selectAllCheckbox.checked) {
            visibleIds.forEach(id => {
                if (!selectedForAddition.includes(id)) selectedForAddition.push(id);
            });
        } else {
            selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id));
        }
    
        // Update checkboxes in DOM without re-rendering
        visibleIds.forEach(id => {
            const li = resultsList.querySelector(`li[data-employee-id="${id}"]`);
            if (li) {
                const checkbox = li.querySelector('input.emp-checkbox');
                if (checkbox) checkbox.checked = selectAllCheckbox.checked;
            }
        });
    
        updateAddSelectionUI();
    });
    
    // ============================
    // Search Input Event
    // ============================
    searchInput.addEventListener('input', () => {
        renderSearchResults(searchInput.value);
    });
    
    // ============================
    // Update Add Button UI
    // ============================
    function updateAddSelectionUI() {
        const count = selectedForAddition.length;
        if (bulkAddBtn) {
            bulkAddBtn.textContent = `Add Selected (${count})`;
            bulkAddBtn.disabled = count === 0;
        }
    }
    
    // ============================
    // Bulk Add Event
    // ============================
    bulkAddBtn.addEventListener('click', () => {
    
        let trainingId = document.getElementById('modal-training-id').value;


        if (selectedForAddition.length === 0) return;
    
        $.ajax({
            url: "{{ route('add.calendar.training.participant') }}",
            method: 'POST',
            data: {
                training_id: trainingId,
                employee_ids: selectedForAddition,  // array
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
//                 console.log("responseresponse",response)



//  window.masterEmployeeList = response.allMasterList;
//     window.trainingParticipantData = response.allTrainingParticipantData;

//     console.log("Updated master list", window.masterEmployeeList);
//     console.log("Updated participant data", window.trainingParticipantData);

//     toastr.success("Added successfully!");

//     selectedForAddition = [];
//     updateAddSelectionUI();



//     //                   masterEmployeeList = response.allMasterList;
//     // trainingParticipantData = response.allTrainingParticipantData;  
//                 // selectedForAddition = [];
//                 // updateAddSelectionUI();
//                 // toastr.success("Added successfully!");
//                 sessionStorage.setItem('activateTab', '#trainer');
                // window.location.reload();
                
                masterEmployeeList = response.allMasterList;
            trainingParticipantData = response.allTrainingParticipantData;
            window.masterEmployeeList = response.allMasterList;
            window.trainingParticipantData = response.allTrainingParticipantData;

            // 2. ✨ नया महत्वपूर्ण कदम: rosterEmployeeIds को अपडेट करें
            // यह वह array है जिसका उपयोग renderTable() करता है
            if (trainingParticipantData[trainingId]) {
                // सर्वर से प्राप्त नए roster IDs का उपयोग करें
                rosterEmployeeIds = [...trainingParticipantData[trainingId].roster];
            }
            
            // 3. सर्च और ऐड UI को रीसेट करें
            selectedForAddition = [];
            updateAddSelectionUI();
            searchInput.value = '';
            resultsContainer.classList.remove('visible');

            // 4. टेबल को तुरंत री-रेंडर करें!
            renderTable(); 
            
            toastr.success("Employees added successfully!");
            sessionStorage.setItem('activateTab', '#trainer');
                
        
                
                
            },
            error: function () {
                toastr.error("Failed to add employees");
            }
        });
    });

    
        
        
    
    
    
    
    
    
    
    
    
    


        searchInput.addEventListener('input', () => renderSearchResults(searchInput.value));
        searchInput.addEventListener('focus', () => renderSearchResults(searchInput.value));


        // selectAllCheckbox.addEventListener('change', () => {
        //  const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId); 
        //  alert(visibleIds)
        //  if (selectAllCheckbox.checked) { 
        //      visibleIds.forEach(id => !selectedForAddition.includes(id) && selectedForAddition.push(id));
             
        //  } else { selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id)); } renderSearchResults(searchInput.value); updateAddSelectionUI(); }
        //  );

                 
                 
    
            
            // function performSearch() {
            //     const searchTerm = searchInput.value.toLowerCase();
            //     if (searchTerm.length > 0) {
            //         currentSearchResults = masterEmployeeList.filter(emp =>
            //             !rosterEmployeeIds.includes(emp.id) &&
            //             (emp.name.toLowerCase().includes(searchTerm) || emp.id.toLowerCase().includes(searchTerm))
            //         );
            //         if (currentSearchResults.length === 0) {
            //             resultsList.innerHTML = `<li class="no-results">No employees found.</li>`;
            //         }
            //     } else {
            //         currentSearchResults = [];
            //         resultsList.innerHTML = `<li class="no-results">Type to search for employees.</li>`;
            //     }
            //     updateAddSelectionUI();
            // }
            
            // if (searchInput) {
            //     // searchInput.addEventListener('input', performSearch);
            //     // searchInput.addEventListener('focus', () => {
            //     //     resultsContainer.classList.add('visible');
            //     //     performSearch();
            //     // });
                
            //     searchInput.addEventListener('input', () => renderSearchResults(searchInput.value));
            //     searchInput.addEventListener('focus', () => renderSearchResults(searchInput.value));
        

            //     selectAllCheckbox.addEventListener('change', () => {
            //      const visibleIds = Array.from(resultsList.querySelectorAll('li[data-employee-id]')).map(li => li.dataset.employeeId); 
            //      alert(visibleIds)
            //      if (selectAllCheckbox.checked) { 
                     
                     
            //          visibleIds.forEach(id => !selectedForAddition.includes(id) && selectedForAddition.push(id));
                     
            //      } else { selectedForAddition = selectedForAddition.filter(id => !visibleIds.includes(id)); } renderSearchResults(searchInput.value); updateAddSelectionUI(); }
            //      );

                 
                 
                 
                 
            //     bulkAddBtn.addEventListener('click', () => {
            //         selectedForAddition.forEach(id => {
            //             if (!rosterEmployeeIds.includes(id)) {
            //                 rosterEmployeeIds.push(id);
            //                  if(trainingParticipantData[currentTrainingId]) {
            //                     trainingParticipantData[currentTrainingId].statuses[id] = 'neutral';
            //                 }
            //             }
            //         });
            //         selectedForAddition = [];
            //         searchInput.value = '';
            //         resultsContainer.classList.remove('visible');
            //         renderTable();
            //     });
            // }




  
            function updateRosterCounts() { let present = 0, absent = 0, neutral = 0; rosterEmployeeIds.forEach(id => { const data = trainingParticipantData[currentTrainingId]; if (data && data.statuses) { switch (data.statuses[id]) { case 'present': present++; break; case 'absent': absent++; break; default: neutral++; } } }); rosterCountsEl.innerHTML = `<span class="badge bg-success">Present: ${present}</span><span class="badge bg-danger">Absent: ${absent}</span><span class="badge bg-secondary">Neutral: ${neutral}</span>`; }
            
            function renderTable() {
                if (!tableBody) return;
                const thead = document.querySelector('.table-wrapper thead');
                if (thead) thead.style.display = 'none';
                const currentData = trainingParticipantData[currentTrainingId];
                const sortedRoster = rosterEmployeeIds
                    .map(id => {
                        const emp = masterEmployeeList.find(e => e.id === id);
                        if (emp) {
                            return { ...emp, status: (currentData && currentData.statuses[id]) ? currentData.statuses[id] : 'neutral' };
                        }
                        return null;
                    })
                    .filter(Boolean)
                    .sort((a, b) => a.name.localeCompare(b.name));

                tableBody.innerHTML = sortedRoster.map(emp => {
                    if (!emp.updated) {
                      emp.updated = new Date(Date.now() - Math.random() * 1e10).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
                    }
                    const isSelected = selectedInTableIds.includes(emp.id);
                    const statusSliderHTML = `<div class="status-slider-container status-${emp.status || 'neutral'}" data-employee-id="${emp.id}"><div class="status-slider-track"><div class="status-slider-label" data-value="absent">Absent</div><div class="status-slider-label" data-value="neutral">Neutral</div><div class="status-slider-label" data-value="present">Present</div><div class="status-slider-thumb"></div></div></div>`;
                    const prefix = emp.gender === 'Male' ? 'Mr.' : 'Ms.';
                    // const displayName = `${prefix} ${emp.name}`;
                    const displayName = `${emp.name}`;
                    
                    return `
                    <tr class="employee-card-list-item" data-main-id="${emp.main_id}" data-employee-id="${emp.id}">
                        <td class="p-0">
                            <div class="employee-card-row">
                                <div class="card-col-select">
                                    <input type="checkbox" class="row-checkbox" ${isSelected ? 'checked' : ''}>
                                </div>

                                <div class="card-col-org">
                                    <strong>${emp.corporate || 'N/A'}</strong>
                                    <span>${emp.regional || 'N/A'}</span>
                                    <span>${emp.unit || 'N/A'}</span>
                                </div>

                                <div class="card-col-main-info">
                                    <div class="avatar">${emp.initials}</div>
                                    <div>
                                        <strong>${displayName}</strong>
                                        <div class="details-grid">
                                            <span><i class="fas fa-id-card-clip"></i>ID: ${emp.id}</span>
                                            <span><i class="fas fa-user"></i>${emp.gender}</span>
                                            <span><i class="fas fa-birthday-cake"></i>Born: ${emp.born}</span>
                                            <span><i class="fas fa-calendar-alt"></i>Joined: ${emp.joined}</span>
                                            <span><i class="fas fa-clock"></i>Updated: ${emp.updated}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-col-contact">
                                    <span><i class="fas fa-envelope"></i>${emp.email}</span>
                                    <span><i class="fas fa-phone"></i>${emp.phone}</span>
                                </div>

                                <div class="card-col-role">
                                    <strong>${emp.department || 'N/A'}</strong>
                                    <span>${emp.role || 'N/A'}</span>
                                    <span>Responsibility: ${emp.department || 'N/A'}</span>
                                </div>

                                <div class="card-col-category">
                                    <strong>${emp.category || 'N/A'}</strong>
                                    <span>Food Handler: ${emp.foodHandler}</span>
                                </div>
                                
                                <div class="card-col-status">
                                     ${statusSliderHTML}
                                </div>

                                <div class="card-col-actions">
                                    <i class="fas fa-trash-alt icon" title="Remove from Roster" data-id="${emp.main_id}"></i>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                }).join('');

                updateBulkActionButtons();
                updateSelectAllTableCheckboxState();
                updateRosterCounts();
            }


  function updateBulkActionButtons() {
        console.log('bbbbbb');
        const hasSelection = selectedInTableIds.length > 0; 
        
    }
    function updateSelectAllTableCheckboxState() { 
          console.log('ccccc');
        const individualRows = tableBody.querySelectorAll('tr'); if (individualRows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const visibleIdsOnPage = Array.from(individualRows).map(row => row.dataset.employeeId); const selectedOnPage = visibleIdsOnPage.filter(id => selectedInTableIds.includes(id));
        const allSelectedOnPage = visibleIdsOnPage.length > 0 && selectedOnPage.length === visibleIdsOnPage.length; selectAllTableCheckbox.checked = allSelectedOnPage; 
        selectAllTableCheckbox.indeterminate = selectedOnPage.length > 0 && !allSelectedOnPage;
        
         console.log('ccccc111111_individualRows',individualRows);
         console.log('ccccc111111_allSelectedOnPage',allSelectedOnPage);
    }
    
    
            // function updateBulkActionButtons() { const hasSelection = selectedInTableIds.length > 0; markPresentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; markAbsentBtn.style.display = hasSelection ? 'inline-flex' : 'none'; }
            // function updateSelectAllTableCheckboxState() { if(!selectAllTableCheckbox || !tableBody) return; const rows = tableBody.querySelectorAll('tr'); if (rows.length === 0) { selectAllTableCheckbox.checked = false; selectAllTableCheckbox.indeterminate = false; return; } const allSelected = rows.length > 0 && rows.length === selectedInTableIds.length; selectAllTableCheckbox.checked = allSelected; selectAllTableCheckbox.indeterminate = selectedInTableIds.length > 0 && !allSelected; }
            function bulkUpdateStatus(newStatus) { selectedInTableIds.forEach(id => { trainingParticipantData[currentTrainingId].statuses[id] = newStatus; }); selectedInTableIds = []; renderTable(); }
            
            const manageParticipantsModalEl = document.getElementById('manageParticipantsModal');
            manageParticipantsModalEl.addEventListener('show.bs.modal', function(event) { currentTrainingId = event.relatedTarget.dataset.trainingId; if (!trainingParticipantData[currentTrainingId]) { trainingParticipantData[currentTrainingId] = { roster: [], statuses: {} }; } rosterEmployeeIds = [...trainingParticipantData[currentTrainingId].roster]; selectedInTableIds = []; selectedForAddition = []; renderTable(); });
            if(tableBody) tableBody.addEventListener('click', (e) => { const row = e.target.closest('tr[data-employee-id]'); if (!row) return; const employeeId = row.dataset.employeeId; if (e.target.classList.contains('row-checkbox')) { if (e.target.checked) { if (!selectedInTableIds.includes(employeeId)) selectedInTableIds.push(employeeId); } else { selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); } updateBulkActionButtons(); updateSelectAllTableCheckboxState(); } else if (e.target.closest('.fa-trash-alt')) { 
                
                // if (confirm(`Remove ${row.querySelector('.card-col-main-info strong').textContent.trim()} from this training?`)) { rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId); delete trainingParticipantData[currentTrainingId].statuses[employeeId]; selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId); renderTable(); } 
                
                 const participantId = row.querySelector('.fa-trash-alt').dataset .id;

                if (confirm(`Remove ${row.querySelector('.card-col-main-info strong').textContent.trim()} from this training?`)) {
                    $.ajax({
                        url: "{{route('calendar.remove.participant')}}",
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                            training_id: currentTrainingId,
                            participant_id: participantId
                        },
                        success: function(res) {
                            rosterEmployeeIds = rosterEmployeeIds.filter(id => id !== employeeId);
                            delete trainingParticipantData[currentTrainingId].statuses[employeeId];
                            selectedInTableIds = selectedInTableIds.filter(id => id !== employeeId);
                
                            renderTable();
                            toastr.success("Employee removed successfully!");
                        },
                        error: function() {
                            toastr.error("Failed to remove employee.");
                        }
                    });
                
                }



            } const sliderLabel = e.target.closest('.status-slider-label'); if (sliderLabel) { const newStatus = sliderLabel.dataset.value; if (trainingParticipantData[currentTrainingId].statuses[employeeId] !== newStatus) { trainingParticipantData[currentTrainingId].statuses[employeeId] = newStatus; const sliderContainer = sliderLabel.closest('.status-slider-container'); sliderContainer.className = 'status-slider-container'; sliderContainer.classList.add(`status-${newStatus}`); updateRosterCounts(); } } });
            if(markPresentBtn) markPresentBtn.addEventListener('click', () => bulkUpdateStatus('present'));
            if(markAbsentBtn) markAbsentBtn.addEventListener('click', () => bulkUpdateStatus('absent'));
            
            
            // if(mainSubmitBtn) mainSubmitBtn.addEventListener('click', () => { if (!currentTrainingId) return; trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds; let presentCount = 0, absentCount = 0; Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => { if (status === 'present') presentCount++; if (status === 'absent') absentCount++; }); const mainTableRow = document.querySelector(`button[data-training-id="${currentTrainingId}"]`)?.closest('tr'); if(mainTableRow) { mainTableRow.querySelector('.badge.bg-success').textContent = presentCount; mainTableRow.querySelector('.badge.bg-danger').textContent = absentCount; } window.tableManager.updateDashboardMetrics(); bootstrap.Modal.getInstance(manageParticipantsModalEl).hide(); });
            
        //  if (mainSubmitBtn) mainSubmitBtn.addEventListener('click', () => {
        //      alert(currentTrainingId)
        //     if (!currentTrainingId) return;
        
        //     trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds;
        
        //     let presentCount = 0, absentCount = 0;
        
        //     Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => {
        //         if (status === 'present') presentCount++;
        //         if (status === 'absent') absentCount++;
        //     });
        
        //     const mainTableRow = document.querySelector(
        //         `button[data-training-id="${currentTrainingId}"]`
        //     )?.closest('tr');
        
        //     if (mainTableRow) {
        //         mainTableRow.querySelector('.badge.bg-success').textContent = presentCount;
        //         mainTableRow.querySelector('.badge.bg-danger').textContent = absentCount;
        //     }
        
        //     window.tableManager.updateDashboardMetrics();
        
        //     let mainIdStatuses = {};
        //     Object.keys(trainingParticipantData[currentTrainingId].statuses).forEach(empId => {
        //         const row = document.querySelector(`tr[data-employee-id="${empId}"]`);
        //         if (row) {
        //             const mainId = row.dataset.mainId; // get data-main-id
        //             mainIdStatuses[mainId] = trainingParticipantData[currentTrainingId].statuses[empId];
        //         }
        //     });
        //     $.ajax({
        //         url: "{{route('calendar.update.participant.status')}}",
        //         method: "POST",
        //         data: {
        //             _token: $('meta[name="csrf-token"]').attr("content"),
        //             training_id: currentTrainingId,
        //             statuses: mainIdStatuses
        //         },
        //         success: function (res) {
        //             console.log("Status updated successfully", res);
        //             toastr.success('Status updated successfully');
        //         },
        //         error: function () {
        //              toastr.error("Failed to update attendance status.");
        //         }
        //     });
        
        //     bootstrap.Modal.getInstance(manageParticipantsModalEl).hide();
        // });


if (mainSubmitBtn) {
    mainSubmitBtn.addEventListener('click', () => {



        if (!currentTrainingId) return;

        trainingParticipantData[currentTrainingId].roster = rosterEmployeeIds;

        let presentCount = 0, absentCount = 0;

        Object.values(trainingParticipantData[currentTrainingId].statuses).forEach(status => {
            if (status === 'present') presentCount++;
            if (status === 'absent') absentCount++;
        });

        const mainTableRow = document.querySelector(
            `button[data-training-id="${currentTrainingId}"]`
        )?.closest('tr');

        // -------- SAFE BADGE UPDATES --------
        if (mainTableRow) {
            const presentBadge = mainTableRow.querySelector('.badge.bg-success');
            const absentBadge  = mainTableRow.querySelector('.badge.bg-danger');

            if (presentBadge) presentBadge.textContent = presentCount;
            if (absentBadge)  absentBadge.textContent  = absentCount;
        }

        // -------- SAFE METRIC UPDATE --------
        if (window.tableManager?.updateDashboardMetrics) {
            window.tableManager.updateDashboardMetrics();
        }

        // -------- BUILD mainIdStatuses --------
        let mainIdStatuses = {};

        Object.keys(trainingParticipantData[currentTrainingId].statuses).forEach(empId => {
            const row = document.querySelector(`tr[data-employee-id="${empId}"]`);

            if (row) {
                const mainId = row.dataset.mainId;
                if (mainId) {
                    mainIdStatuses[mainId] = trainingParticipantData[currentTrainingId].statuses[empId];
                }
            }
        });

        // -------- AJAX UPDATE --------
        $.ajax({
            url: "{{route('calendar.update.participant.status')}}",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                training_id: currentTrainingId,
                statuses: mainIdStatuses
            },
            success: function (res) {
                console.log("Status updated successfully", res);
                toastr.success('Status updated successfully');
            },
            error: function () {
                toastr.error("Failed to update attendance status.");
            }
        });

        // -------- CLOSE MODAL --------
        bootstrap.Modal.getInstance(manageParticipantsModalEl)?.hide();
    });
}


            // File Upload and Review Logic 
            const uploadFileBtn = document.getElementById('upload-file-btn'); const uploadFileModalEl = document.getElementById('uploadFileModal'); const uploadFileModal = new bootstrap.Modal(uploadFileModalEl, { keyboard: false }); const fileUploadStep = document.getElementById('upload-file-step'); const pdfLoadingStep = document.getElementById('pdf-loading-step'); const pdfReviewStep = document.getElementById('pdf-review-step'); const fileUploadInput = document.getElementById('file-upload-input'); const handwritingOptionWrapper = document.getElementById('handwriting-option-wrapper'); const detectHandwritingCheckbox = document.getElementById('detect-handwriting-checkbox'); const extractTableBtn = document.getElementById('extract-table-btn'); const pdfBackBtn = document.getElementById('pdf-back-btn'); const importParticipantsBtn = document.getElementById('import-participants-btn'); const loadingText = document.getElementById('loading-text'); const mapIdSelect = document.getElementById('map-id-select'); const mapNameSelect = document.getElementById('map-name-select'); const mapDepartmentSelect = document.getElementById('map-department-select'); const reviewThead = document.getElementById('pdf-review-thead'); const reviewTbody = document.getElementById('reviewed-participants-tbody'); const downloadSampleCsvBtn = document.getElementById('download-sample-csv-btn'); let simulatedExtractedData = [];
            
            function triggerCsvDownload(csvString, filename) {
                const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                if (link.download !== undefined) {
                    const url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', filename);
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                }
            }

            if (downloadSampleCsvBtn) {
                downloadSampleCsvBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const csvHeaders = ['Sr. No', 'Participant Name', 'Department', 'Designation'];
                    const csvRows = [
                        ['151-001234', 'Amit Kumar', 'Housekeeping', 'Associate'],
                        ['151-005678', 'Sunita Sharma', 'F&B Service', 'Captain'],
                        ['151-009012', 'Rajesh Patel', 'Engineering', 'Technician']
                    ];
                    const csvContent = [
                        csvHeaders.join(','),
                        ...csvRows.map(row => row.join(','))
                    ].join('\n');
                    triggerCsvDownload(csvContent, 'sample_participants.csv');
                });
            }

            function showFileUploadStep(step) { fileUploadStep.style.display = 'none'; pdfLoadingStep.style.display = 'none'; pdfReviewStep.style.display = 'none'; if (step === 'upload') fileUploadStep.style.display = 'block'; if (step === 'loading') pdfLoadingStep.style.display = 'block'; if (step === 'review') pdfReviewStep.style.display = 'block'; }
            uploadFileModalEl.addEventListener('hidden.bs.modal', () => { showFileUploadStep('upload'); fileUploadInput.value = ''; handwritingOptionWrapper.style.display = 'none'; detectHandwritingCheckbox.checked = false; if(extractTableBtn) extractTableBtn.disabled = true; });
            if (uploadFileBtn) { uploadFileBtn.addEventListener('click', () => { showFileUploadStep('upload'); uploadFileModal.show(); }); }
            if (fileUploadInput) { fileUploadInput.addEventListener('change', () => { extractTableBtn.disabled = !fileUploadInput.files.length; if(fileUploadInput.files.length > 0) { const fileExtension = fileUploadInput.files[0].name.split('.').pop().toLowerCase(); handwritingOptionWrapper.style.display = fileExtension === 'pdf' ? 'block' : 'none'; } else { handwritingOptionWrapper.style.display = 'none'; } }); }
            if (extractTableBtn) { extractTableBtn.addEventListener('click', () => { const file = fileUploadInput.files[0]; if (!file) return; const fileExtension = file.name.split('.').pop().toLowerCase(); showFileUploadStep('loading'); if (fileExtension === 'csv') { loadingText.textContent = "Parsing CSV file..."; const reader = new FileReader(); reader.onload = (e) => { const text = e.target.result; const rows = text.split('\n').filter(row => row.trim() !== ''); const headers = rows.shift().split(',').map(h => h.trim().replace(/"/g, '')); const headerMap = { "Unit Name": "Department", "ID Number": "Sr. No", "Employee Name": "Participant Name" }; const internalHeaders = headers.map(h => headerMap[h] || h); simulatedExtractedData = rows.map(row => { const values = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g).map(v => v.trim().replace(/"/g, '')); let obj = {}; headers.forEach((header, index) => { obj[headerMap[header] || header] = values[index]; }); return obj; }); populateReviewUI(internalHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }; reader.readAsText(file); } else if (fileExtension === 'pdf') { const detectHandwriting = detectHandwritingCheckbox.checked; loadingText.textContent = detectHandwriting ? "Analyzing document layout and performing OCR/HCR..." : "Analyzing PDF..."; setTimeout(() => { const baseData = [ { "Sr. No": "151-001122", "Participant Name": "Jatan Singh", "Department": "Housekeeping", "Designation": "Associate" }, { "Sr. No": "151-002246", "Participant Name": "Ganesh Y.", "Department": "Engineering", "Designation": "Supervisor" }, { "Sr. No": "999-12345", "Participant Name": "Joy Guha Roy", "Department": "Kitchen", "Designation": "Commis Chef" } ]; const pdfHeaders = ["Sr. No", "Participant Name", "Department", "Designation"]; simulatedExtractedData = detectHandwriting ? JSON.parse(JSON.stringify(baseData)).map(row => { /* ... handwritten logic ... */ return row; }) : JSON.parse(JSON.stringify(baseData)); populateReviewUI(pdfHeaders, {id: "Sr. No", name: "Participant Name", dept: "Department"}); }, detectHandwriting ? 2500 : 1000); } }); }
            function populateReviewUI(headers, autoSelect) { const optionsHtml = headers.map(h => `<option value="${h}">${h}</option>`).join(''); mapIdSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapNameSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapDepartmentSelect.innerHTML = `<option value="">--Select--</option>${optionsHtml}`; mapIdSelect.value = autoSelect.id; mapNameSelect.value = autoSelect.name; mapDepartmentSelect.value = autoSelect.dept; reviewThead.innerHTML = `<tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>`; reviewTbody.innerHTML = simulatedExtractedData.map(row => `<tr>${headers.map(h => `<td class="${row.handwritten && row.handwritten[h] ? 'handwritten-text' : ''}">${row[h] !== undefined ? row[h] : ''}</td>`).join('')}</tr>`).join(''); showFileUploadStep('review'); }
            if (pdfBackBtn) { pdfBackBtn.addEventListener('click', () => { showFileUploadStep('upload'); }); }
            if (importParticipantsBtn) { 
                importParticipantsBtn.addEventListener('click', () => { 
                    const idCol = mapIdSelect.value, nameCol = mapNameSelect.value, deptCol = mapDepartmentSelect.value, roleCol = 'Designation';
                    if (!nameCol) { alert('Please map the Full Name column.'); return; } 
                    const reviewSection = document.getElementById('pdf-review-section'); 
                    const reviewTbody = document.getElementById('reviewed-participants-tbody'); 
                    reviewTbody.innerHTML = ''; 

                    // Get a list of names currently in the roster for quick checking
                    const rosterNames = rosterEmployeeIds.map(id => masterEmployeeList.find(emp => emp.id === id)?.name.toLowerCase());

                    simulatedExtractedData.forEach(rowData => { 
                        const importedName = rowData[nameCol] || '', importedId = rowData[idCol] || '', importedDept = rowData[deptCol] || '', importedRole = rowData[roleCol] || ''; 
                        const initials = importedName.split(' ').map(n=>n[0]).join('').toUpperCase(); 
                        
                        // Check for duplicate names already in the roster
                        const isInRoster = rosterNames.some(rosterName => jaroWinkler(importedName.toLowerCase(), rosterName) > 0.9);
                        const rosterBadge = isInRoster ? `<span class="badge bg-warning ms-2">In Roster</span>` : '';

                        let matches = []; 
                        const idMatch = masterEmployeeList.find(e=>e.id===importedId); 
                        if (idMatch){ matches.push({employee:idMatch, score:1, isIdMatch:true}); } 
                        else if(importedName) { matches = masterEmployeeList.map(emp => ({employee:emp, score: jaroWinkler(importedName.toLowerCase(), emp.name.toLowerCase()), isIdMatch:false})).filter(m=>m.score > 0.8 && !rosterEmployeeIds.includes(m.employee.id)).sort((a,b)=>b.score - a.score).slice(0,3); } 
                        
                        const popoverContent = (emp) => `<strong>ID:</strong> ${emp.id}<br><strong>Unit:</strong> ${emp.unit || 'N/A'}`; 
                        let suggestionsHTML = matches.length > 0 ? matches.map(m => `<a href="#" class="suggestion-link" data-employee='${JSON.stringify(m.employee)}' data-bs-toggle="popover" data-bs-trigger="hover" title="DB Record: ${m.employee.name}" data-bs-content="${popoverContent(m.employee)}"><i class="fas ${m.isIdMatch ? 'fa-id-badge text-success' : 'fa-user text-primary'} me-2"></i> ${m.employee.name} <span class="badge ${m.isIdMatch ? 'bg-success' : 'bg-primary'} float-end">${m.isIdMatch ? 'ID Match' : (m.score * 100).toFixed(0) + '%'}</span></a>`).join('') : '<div class="no-suggestions">No matches in DB.</div>'; 
                        
                        const actionsHTML = `<button class="btn btn-sm btn-outline-success add-reviewed-participant-btn" title="Add to Roster"><i class="fas fa-check"></i></button> ${matches.length === 0 ? `<button class="btn btn-sm btn-outline-primary add-manual-btn" title="Add as new employee"><i class="fas fa-user-plus"></i></button>` : ''} <button class="btn btn-sm btn-outline-danger discard-reviewed-participant-btn" title="Discard row"><i class="fas fa-trash"></i></button>`; 
                        
                        const createSelect = (options, selectedValue) => {
                            let uniqueOptions = [...new Set([...options, selectedValue].filter(Boolean))].sort();
                            return `<select class="form-select form-select-sm">${uniqueOptions.map(opt => `<option value="${opt}" ${opt === selectedValue ? 'selected' : ''}>${opt}</option>`).join('')}</select>`;
                        };

                        const deptDropdown = createSelect(allDepartments, importedDept);
                        const roleDropdown = createSelect(allRoles, importedRole);

                        const tr = document.createElement('tr'); 
                        tr.innerHTML = `<td><div class="employee-cell imported-info"><div class="avatar">${initials}</div><div class="employee-info w-100"><div class="name"><span contenteditable="true" class="imported-name-cell">${importedName}</span><span class="badge bg-success ms-2 matched-indicator" style="display:none;">Matched</span>${rosterBadge}</div><div class="imported-details"><div><small>ID:</small><span contenteditable="true" class="editable-id">${importedId}</span></div><div><small>Dept:</small><span class="editable-dept">${deptDropdown}</span></div><div><small>Role:</small><span class="editable-role">${roleDropdown}</span></div></div></div></div></td><td><div class="suggestions-container"><h6>Potential Matches</h6>${suggestionsHTML}</div></td><td class="action-cell">${actionsHTML}</td>`; 
                        reviewTbody.appendChild(tr); 
                    }); 
                    new bootstrap.Popover(reviewTbody, { selector: '[data-bs-toggle="popover"]', container: 'body', trigger: 'hover focus', html: true }); 
                    reviewSection.style.display = 'block'; 
                    uploadFileModal.hide(); 
                }); 
            }
            function addParticipantToRoster(data) { if (!data.id && !data.name) return; if (!data.id) data.id = `NEW-${Date.now().toString().slice(-6)}`; if (rosterEmployeeIds.includes(data.id)) return; if (!masterEmployeeList.some(emp => emp.id === data.id)) { masterEmployeeList.push({ id: data.id, name: data.name, initials: data.name.split(' ').map(n => n[0]).join('').toUpperCase(), department: data.department, role: data.role, status: 'neutral' }); } rosterEmployeeIds.push(data.id); trainingParticipantData[currentTrainingId].statuses[data.id] = 'neutral'; renderTable(); }
            if(manageParticipantsModalBody) { manageParticipantsModalBody.addEventListener('click', e => { const targetBtn = e.target.closest('a, button'); if (!targetBtn) return; e.preventDefault(); const reviewTbody = document.getElementById('reviewed-participants-tbody'); if (targetBtn.matches('.suggestion-link')) { const tr = targetBtn.closest('tr'); const employeeData = JSON.parse(targetBtn.dataset.employee); tr.querySelector('.editable-id').textContent = employeeData.id; tr.querySelector('.imported-name-cell').textContent = employeeData.name; tr.querySelector('.editable-dept select').value = employeeData.department || ''; tr.querySelector('.editable-role select').value = employeeData.role || ''; tr.querySelector('.matched-indicator').style.display = 'inline-block'; } if (targetBtn.matches('.add-manual-btn')) { const tr = targetBtn.closest('tr'); addEmployeeModal.dataset.sourceRowIndex = Array.from(reviewTbody.children).indexOf(tr); addEmployeeForm.reset(); document.getElementById('add-employee-form-container').querySelector('h2').textContent = "Add New User from Import"; document.getElementById('full-name').value = tr.querySelector('.imported-name-cell').textContent.trim(); document.getElementById('employee-id').value = tr.querySelector('.editable-id').textContent.trim(); document.getElementById('department-select').value = tr.querySelector('.editable-dept select').value; document.getElementById('designation').value = tr.querySelector('.editable-role select').value; addEmployeeModal.classList.add('visible'); } if (targetBtn.matches('.add-reviewed-participant-btn')) { const tr = targetBtn.closest('tr'); const employeeName = tr.querySelector('.imported-name-cell').textContent.trim(); if (!employeeName) { alert('Participant Name cannot be empty.'); return; } addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: employeeName, department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); tr.remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.matches('.discard-reviewed-participant-btn')) { targetBtn.closest('tr').remove(); if (reviewTbody.rows.length === 0) document.getElementById('pdf-review-section').style.display = 'none'; } if (targetBtn.id === 'add-all-reviewed-btn') { if (confirm(`Add all ${reviewTbody.rows.length} participants?`)) { [...reviewTbody.rows].forEach(tr => { addParticipantToRoster({ id: tr.querySelector('.editable-id').textContent.trim(), name: tr.querySelector('.imported-name-cell').textContent.trim(), department: tr.querySelector('.editable-dept select').value, role: tr.querySelector('.editable-role select').value }); }); reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } if (targetBtn.id === 'discard-all-reviewed-btn') { if (confirm('Discard all imported participants?')) { reviewTbody.innerHTML = ''; document.getElementById('pdf-review-section').style.display = 'none'; } } }); }
            
            function initAddEmployeeForm() {
                const corporateSelect = document.getElementById('corporate-select');
                const regionalSelect = document.getElementById('regional-select');
                const unitSelect = document.getElementById('unit-select');
                const departmentSelect = document.getElementById('department-select');

                function populateDropdown(selectElement, options, placeholder) {
                    selectElement.innerHTML = `<option value="">${placeholder}</option>`;
                    options.forEach(option => selectElement.add(new Option(option, option)));
                    selectElement.disabled = options.length === 0;
                }

                populateDropdown(corporateSelect, Object.keys(orgData), 'Select Corporate');

                corporateSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const regionals = selectedCorporate ? Object.keys(orgData[selectedCorporate]) : [];
                    populateDropdown(regionalSelect, regionals, 'Select Regional');
                    populateDropdown(unitSelect, [], 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                });
                
                regionalSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const selectedRegional = regionalSelect.value;
                    const units = selectedCorporate && selectedRegional ? Object.keys(orgData[selectedCorporate][selectedRegional]) : [];
                    populateDropdown(unitSelect, units, 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                });

                unitSelect.addEventListener('change', () => {
                    const selectedCorporate = corporateSelect.value;
                    const selectedRegional = regionalSelect.value;
                    const selectedUnit = unitSelect.value;
                    const departments = selectedCorporate && selectedRegional && selectedUnit ? orgData[selectedCorporate][selectedRegional][selectedUnit] : [];
                    $(departmentSelect).empty().append('<option value="">Select Department</option>');
                    departments.forEach(dept => $(departmentSelect).append(new Option(dept, dept)));
                    $(departmentSelect).prop('disabled', departments.length === 0).selectpicker('refresh');
                });
                
                function hideAddEmployeeModal() {
                    addEmployeeModal.classList.remove('visible');
                    addEmployeeForm.reset();
                    populateDropdown(regionalSelect, [], 'Select Regional');
                    populateDropdown(unitSelect, [], 'Select Unit');
                    $(departmentSelect).empty().append('<option value="">Select Department</option>').prop('disabled', true).selectpicker('refresh');
                    delete addEmployeeModal.dataset.sourceRowIndex; 
                }

                if (modalCloseBtn) modalCloseBtn.addEventListener('click', hideAddEmployeeModal);
                if (modalCancelBtn) modalCancelBtn.addEventListener('click', hideAddEmployeeModal);

                if (addNewEmployeeBtn) {
                    addNewEmployeeBtn.addEventListener('click', () => {
                        addEmployeeForm.reset();
                        addEmployeeFormContainer.querySelector('h2').textContent = "Add New Employee";
                        delete addEmployeeModal.dataset.sourceRowIndex;
                        addEmployeeModal.classList.add('visible');
                    });
                }
                
                if (addEmployeeForm) {
                    addEmployeeForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const newEmployee = {
                            id: document.getElementById('employee-id').value.trim(),
                            name: document.getElementById('full-name').value.trim(),
                            corporate: corporateSelect.value,
                            regional: regionalSelect.value,
                            unit: unitSelect.value,
                            department: $(departmentSelect).val(),
                            email: document.getElementById('email').value.trim(),
                            phone: document.getElementById('contact').value.trim(),
                            gender: document.getElementById('gender').value,
                            role: document.getElementById('designation').value.trim(),
                            joined: document.getElementById('date-joining').value,
                            born: document.getElementById('date-birth').value,
                            category: document.getElementById('staff-category').value,
                            foodHandler: document.getElementById('food-handlers-category').value
                        };
                        newEmployee.initials = newEmployee.name.split(' ').map(n => n[0]).join('').toUpperCase();
                        if (!newEmployee.id || !newEmployee.name) {
                            alert('Employee ID and Full Name are required.');
                            return;
                        }
                        if (masterEmployeeList.some(emp => emp.id === newEmployee.id)) {
                            alert(`An employee with ID ${newEmployee.id} already exists.`);
                            return;
                        }
                        masterEmployeeList.unshift(newEmployee);
                        addParticipantToRoster(newEmployee);
                        if (addEmployeeModal.dataset.sourceRowIndex) {
                            const reviewTbody = document.getElementById('reviewed-participants-tbody');
                            const rowIndex = parseInt(addEmployeeModal.dataset.sourceRowIndex, 10);
                            if (reviewTbody.rows[rowIndex]) { reviewTbody.rows[rowIndex].remove(); }
                             if (reviewTbody.rows.length === 0) { document.getElementById('pdf-review-section').style.display = 'none'; }
                        }
                        hideAddEmployeeModal();
                    });
                }
            }
            initAddEmployeeForm();
        });
    </script>
</body>
</html>
```