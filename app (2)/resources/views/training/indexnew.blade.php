@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
@section('content')
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Training Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Added Font Awesome 6.4.0 as requested by TNI mapping, 6.5.1 is already there, usually newer is fine -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://efsm.safefoodmitra.com/admin/public/assets/images/logo-icon.png" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SheetJS (xlsx) for Excel export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
   <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            
             --primary-color: #4f46e5;
            --border-color: #e5e7eb;
            --text-color-light: #6b7280;
            --text-color-dark: #111827;
            --background-color: #f9fafb;
            --surface-color: #ffffff;
            --dashboard-bg: #f8f9fc;
            --green: #22c55e;
            --red: #ef4444;
            --gray: #9ca3af;
            --blue: #3b82f6;
            --purple: #8b5cf6;
            --orange: #f97316;
            --yellow: #f59e0b;

            /* Dynamic 3D Chart Variables */
            --chart-color-high: #1f4e79;
            --chart-color-medium: #ed7d31;
            --chart-color-low: #2e752e;
            --chart-color-high-dark: #153554;
            --chart-color-medium-dark: #c16323;
            --chart-color-low-dark: #1f4d1f;
            --chart-color-grid: #e0e0e0;
            --chart-color-text: #333333;
            --chart-line-color: var(--purple);
            --chart-bar-width: 50px;
            --chart-bar-depth: 8px;
            --chart-bar-skew: -45deg;
            
            --primary-color: #4361ee;
            --primary-light: #e6f0ff;
            --secondary-color: #3f37c9;
            --dark-color: #1a1a2e;
            --light-color: #f8f9fa;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #f72585; /* Global danger color */
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
                        --primary-bg: #eef1f5; --container-bg: #ffffff; --border-color: #d1d9e6; --text-primary: #333a45; --text-secondary: #5a6576; --text-muted: #7b879a; --accent-color: #0077b6; --accent-color-darker: #005b8e; --accent-color-hover: #006aa3; --success-color: #2a9d8f; --success-color-hover: #268c80; --danger-color: #e76f51; --danger-color-hover: #d96343; --info-color: #457b9d;  --info-color-hover: #3c6a89; --warning-color: #f4a261; --warning-color-hover: #e09050; --modal-bg: rgba(0, 0, 0, 0.5); --modal-content-bg: #fff; --input-border-color: #ced4da; --input-focus-border-color: #86b7fe; --input-focus-box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.25); --font-family-sans-serif: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; --base-font-size: 16px; --line-height-base: 1.6; --border-radius: 0.375rem; --spacing-unit: 1rem;




          /*calendar*/
            --primary-color-green: #17a00e;
            --primary-light1: #e8f5e9;
            --secondary-color1: #2c3e50;
            --accent-color1: #3498db;
            --light-gray1: #f8f9fa;
            --medium-gray1: #e9ecef;
            --dark-gray1: #6c757d;
            --danger-color1: #dc3545;
            --warning-color1: #ffc107;
            --info-color1: #17a2b8;
            --border-radius1: 8px;
            --box-shadow1: 0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1);
            --transition1: all 0.3s ease;
        }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; background-color: #f5f7fb; color: #333; line-height: 1.6;padding: 0px;
            margin: 0; }
        .tab-container { display: flex; flex-direction: column; height: 100vh; width: 100vw; background-color: #ffffff; box-shadow: var(--box-shadow); overflow: hidden; }
        .tab-nav { display: flex; list-style-type: none; background-color: white; padding: 0 20px; flex-shrink: 0; overflow-x: auto; white-space: nowrap; border-bottom: 1px solid rgba(0, 0, 0, 0.08); position: relative; }
        .tab-nav::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 1px; background-color: rgba(0, 0, 0, 0.05); }
        .tab-nav::-webkit-scrollbar { height: 4px; }
        .tab-nav::-webkit-scrollbar-thumb { background-color: rgba(67, 97, 238, 0.3); border-radius: 2px; }
        .tab-nav::-webkit-scrollbar-track { background-color: transparent; }
        .tab-nav li { display: inline-flex; position: relative; }
        .tab-nav button { display: inline-flex; align-items: center; justify-content: center; background-color: transparent; color: #64748b; border: none; padding: 16px 24px; cursor: pointer; font-size: 14px; font-weight: 500; transition: var(--transition); outline: none; position: relative; text-transform: capitalize; letter-spacing: 0.2px; gap: 8px; }
        .tab-nav button i { font-size: 16px; }
        .tab-nav button:hover { color: var(--primary-color); }
        .tab-nav button.active { color: var(--primary-color); font-weight: 600; }
        .tab-nav button.active::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background-color: var(--primary-color); border-radius: 3px 3px 0 0; animation: slideIn 0.3s ease-out; }
        @keyframes slideIn { from { width: 0; opacity: 0; } to { width: 40px; opacity: 1; } }
        .tab-content { flex-grow: 1; padding: 24px; overflow-y: auto; background-color: #ffffff; position: relative; scroll-behavior: smooth; }
        .tab-pane { display: none; animation: fadeIn 0.4s ease-out forwards; }
        .tab-pane.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .tab-pane h2 { color: var(--dark-color); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid rgba(0, 0, 0, 0.05); font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .tab-pane h2 i { color: var(--primary-color); font-size: 1.2em; }
        .tab-pane p { color: #64748b; margin-bottom: 16px; max-width: 800px; }
        .tab-pane ul { list-style: none; margin: 16px 0; }
        .tab-pane li { position: relative; padding-left: 24px; margin-bottom: 10px; color: #475569; }
        .tab-pane li::before { content: ''; position: absolute; left: 8px; top: 10px; width: 6px; height: 6px; border-radius: 50%; background-color: var(--primary-color); }
        .mobile-tab-toggle { display: none; position: fixed; bottom: 24px; right: 24px; width: 56px; height: 56px; border-radius: 50%; background-color: var(--primary-color); color: white; border: none; box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3); cursor: pointer; z-index: 100; align-items: center; justify-content: center; transition: var(--transition); }
        .mobile-tab-toggle:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(67, 97, 238, 0.4); }
        .mobile-tab-toggle i { font-size: 20px; }
        @media (max-width: 992px) {
            .tab-nav button { padding: 14px 18px; font-size: 13px; }
            .tab-content { padding: 20px; }
        }
        @media (max-width: 768px) {
            .tab-nav { padding: 0 12px; position: fixed; top: 0; left: 0; width: 100%; z-index: 90; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); transform: translateY(-100%); transition: transform 0.3s ease; background-color: white; flex-direction: column; height: auto; max-height: 70vh; overflow-y: auto; white-space: normal; }
            .tab-nav.active { transform: translateY(0); }
            .tab-nav li { display: block; border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
            .tab-nav button { width: 100%; justify-content: flex-start; padding: 16px 20px; }
            .tab-nav button.active::after { left: 0; transform: none; width: 3px; height: 100%; border-radius: 0; animation: verticalSlideIn 0.3s ease-out; }
            @keyframes verticalSlideIn { from { height: 0; opacity: 0; } to { height: 100%; opacity: 1; } }
            .tab-content { padding-top: 80px; /* Adjusted to be consistent with data tab */ }
            .mobile-tab-toggle { display: flex; }
        }
        @media (max-width: 480px) {
            .tab-content { padding: 16px; padding-top: 70px; /* Adjusted to be consistent */ }
            .tab-pane h2 { font-size: 20px; }
        }
        
    </style>
    <style>
        /* Styles for Data Tab */
        #data main {
            /* Tracker specific color variables to match the provided image */
            --tracker-primary-color: var(--primary-color); /* Use main page's primary for interactive elements */
            --tracker-primary-dark: #3a52d1;
            --tracker-primary-light: var(--primary-light);

            --tracker-info-color: var(--primary-color); /* For filter trigger buttons */
            --tracker-info-dark: #3a52d1;

            --tracker-secondary-color: #6c757d; /* For neutral/secondary buttons like Clear, Refresh */
            --tracker-secondary-dark: #545b62;
            --tracker-secondary-text: #ffffff;

            /* Colors for data display as per image */
            --tracker-color-success: #28a745; /* Green for "Active" pill and "Attended" badge */
            --tracker-color-danger: #dc3545;  /* Red for "Not Attended" badge and relevant borders */
            --tracker-color-warning: #ffc107; /* If needed */

            --tracker-title-text-color: #007bff; /* Specific blue for Employee Name and Module Titles */

            --tracker-text-dark: #212529;     /* Dark text for labels, headings */
            --tracker-text-muted: #6c757d;    /* Lighter text for values, subtext */
            --tracker-text-on-primary: #ffffff; /* Text on colored backgrounds (green pills/badges) */

            /* Backgrounds as per image (employee details slightly off-white, modules white) */
            --tracker-bg-body: #f4f6f8;       /* For employee-details-block background */
            --tracker-bg-surface: #ffffff;     /* For training-module-column background */
            --tracker-bg-input: #ffffff;       /* For input fields */

            --tracker-border-color: #ced4da;
            --tracker-border-color-light: #e9ecef;
            --tracker-card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --tracker-focus-ring-color: rgba(67, 97, 238, 0.25); /* Based on main --primary-color */

            --tracker-border-radius-sm: 0.25rem;
            --tracker-border-radius-md: 0.5rem;
            --tracker-border-radius-lg: 0.75rem;
            font-family: 'Poppins', sans-serif; /* Ensure Poppins font consistent with main page */
        }

        #data main *:focus-visible { outline: 2px solid var(--tracker-primary-color); outline-offset: 2px; box-shadow: 0 0 0 0.2rem var(--tracker-focus-ring-color); }
        #data main *:focus:not(:focus-visible) { outline: none; }
        #data main .filter-section-container { background-color: var(--tracker-bg-surface); padding: 20px 25px; border-radius: var(--tracker-border-radius-md); box-shadow: var(--tracker-card-shadow); margin-bottom: 20px; }
        #data main .global-rating-legend { font-size: 0.8em; color: var(--tracker-text-muted); text-align: center; margin-bottom: 20px; padding: 8px 15px; background-color: var(--tracker-bg-surface); border-radius: var(--tracker-border-radius-sm); box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid var(--tracker-border-color-light); line-height: 1.4; }
        #data main .filter-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--tracker-border-color-light); }
        #data main .btn { padding: 0.5rem 1rem; border-radius: var(--tracker-border-radius-sm); text-decoration: none; font-size: 0.9em; font-weight: 500; border: 1px solid transparent; cursor: pointer; transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease; display: inline-flex; align-items: center; gap: 0.5em; line-height: 1.5; font-family: 'Poppins', sans-serif; }
        #data main .btn i { font-size: 1em; }
        #data main .btn-primary { background-color: var(--tracker-primary-color); color: var(--tracker-text-on-primary); border-color: var(--tracker-primary-color); }
        #data main .btn-primary:hover { background-color: var(--tracker-primary-dark); border-color: var(--tracker-primary-dark); }
        #data main .btn-secondary { background-color: var(--tracker-secondary-color); color: var(--tracker-secondary-text); border-color: var(--tracker-secondary-color); }
        #data main .btn-secondary:hover { background-color: var(--tracker-secondary-dark); border-color: var(--tracker-secondary-dark); }
        #data main .btn-info { background-color: var(--tracker-info-color); color: var(--tracker-text-on-primary); border-color: var(--tracker-info-color); }
        #data main .btn-info:hover { background-color: var(--tracker-info-dark); border-color: var(--tracker-info-dark); }
        #data main .btn-topic { background-color: var(--tracker-primary-color); color: var(--tracker-text-on-primary); padding: 8px 18px; border-radius: var(--tracker-border-radius-sm); text-decoration: none; font-size: 0.9em; font-weight: 500; border: none; cursor: pointer; }
        #data main .btn-topic:hover { background-color: var(--tracker-primary-dark); }
        #data main .top-filter-bar { display: flex; align-items: flex-end; gap: 15px; flex-wrap: wrap; }
        #data main .top-filter-bar .btn-filter-popup-trigger { height: 40px; box-sizing: border-box; }
        #data main .top-filter-bar .filter-box { flex: 1 1 220px; min-width: 200px; position: relative; }
        #data main .top-filter-bar .filter-box-label { display: block; font-size: 0.8em; color: var(--tracker-text-muted); margin-bottom: 4px; font-weight: 500; }
        #data main .input-field, #data main .top-filter-bar .datepicker-trigger-input, #data main .filter-popup-body .filter-box input[type="text"]:not(.custom-dropdown-search-input), #data main .filter-popup-body .filter-box select, #data main .filter-popup-body .filter-box .custom-dropdown-display { width: 100%; padding: 8px 10px; border: 1px solid var(--tracker-border-color); border-radius: var(--tracker-border-radius-sm); font-size: 0.9em; box-sizing: border-box; background-color: var(--tracker-bg-input); height: 40px; line-height: 1.5; transition: border-color 0.2s ease, box-shadow 0.2s ease; font-family: 'Poppins', sans-serif; }
        #data main .input-field:focus, #data main .top-filter-bar .datepicker-trigger-input:focus, #data main .filter-popup-body .filter-box input[type="text"]:not(.custom-dropdown-search-input):focus, #data main .filter-popup-body .filter-box select:focus, #data main .filter-popup-body .filter-box .custom-dropdown-display:focus { border-color: var(--tracker-primary-color); }
        #data main .top-filter-bar .datepicker-trigger-input { cursor: pointer; }
        #data main .top-filter-bar .btn-filter { padding: 0 18px; height: 40px; margin-left: auto; }
        #data main .top-filter-bar .btn-filter.secondary { margin-left: 0; }
        #data main .filter-popup-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); z-index: 1060; align-items: center; justify-content: center; padding: 20px; opacity: 0; transition: opacity 0.2s ease-in-out; }
        #data main .filter-popup-overlay.show { display: flex; opacity: 1; }
        #data main .filter-popup-content { background-color: var(--tracker-bg-surface); padding: 25px; border-radius: var(--tracker-border-radius-md); box-shadow: 0 8px 25px rgba(0,0,0,0.2); width: 100%; max-width: 550px; display: flex; flex-direction: column; max-height: calc(100vh - 40px); transform: scale(0.95); transition: transform 0.2s ease-in-out; }
        #data main .filter-popup-overlay.show .filter-popup-content { transform: scale(1); }
        #data main .filter-popup-header { display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid var(--tracker-border-color-light); flex-shrink: 0; }
        #data main .filter-popup-header h3 { margin: 0; font-size: 1.3em; color: var(--tracker-primary-dark); font-weight: 600; }
        #data main .filter-popup-close { background: none; border: none; font-size: 1.9em; font-weight: bold; color: var(--tracker-text-muted); cursor: pointer; line-height: 0.8; padding: 5px; border-radius: var(--tracker-border-radius-sm); }
        #data main .filter-popup-close:hover { color: var(--tracker-text-dark); }
        #data main .filter-popup-body { overflow-y: auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; flex-grow: 1; padding-right: 10px; }
        #data main .filter-popup-body .filter-box-label { display: block; font-size: 0.9em; color: var(--tracker-text-dark); margin-bottom: 8px; font-weight: 600; }
        #data main .filter-popup-body .filter-box select, #data main .filter-popup-body .filter-box .custom-dropdown-display { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; padding-right: 2.5rem; }
        #data main .filter-popup-body .filter-box .custom-dropdown-display::after { display: none; }
        #data main .custom-dropdown-container { position: relative; }
        #data main .custom-dropdown-options { display: none; position: absolute; top: 100%; left: 0; right: 0; background-color: var(--tracker-bg-surface); border: 1px solid var(--tracker-border-color); border-top: none; border-radius: 0 0 var(--tracker-border-radius-sm) var(--tracker-border-radius-sm); max-height: 200px; overflow-y: auto; z-index: 1070; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        #data main .custom-dropdown-options.show { display: block; }
        #data main .custom-dropdown-search-input { width: calc(100% - 20px); padding: 8px 10px; margin: 5px 10px; border: 1px solid var(--tracker-border-color-light); border-radius: var(--tracker-border-radius-sm); box-sizing: border-box; font-size: 0.9em; }
        #data main .custom-dropdown-options ul { list-style: none; padding: 0; margin: 0; }
        #data main .custom-dropdown-options li { padding: 8px 12px; cursor: pointer; font-size: 0.9em; transition: background-color 0.15s ease, color 0.15s ease; }
        #data main .custom-dropdown-options li:hover, #data main .custom-dropdown-options li.selected { background-color: var(--tracker-primary-color); color: var(--tracker-text-on-primary); }
        #data main .custom-dropdown-options li.no-results { padding: 8px 12px; font-style: italic; color: var(--tracker-text-muted); cursor: default; }
        #data main .custom-datepicker-popup { background-color: var(--tracker-bg-surface); border: 1px solid var(--tracker-border-color); border-radius: var(--tracker-border-radius-md); box-shadow: 0 5px 15px rgba(0,0,0,0.15); padding: 15px; width: fit-content; min-width: 300px; z-index: 1070; display: none; position: absolute; top: calc(100% + 5px); left: 0; }
        #data main .datepicker-popup-inputs { display: flex; gap: 10px; margin-bottom: 15px; }
        #data main .datepicker-popup-inputs .input-group { flex: 1; }
        #data main .datepicker-popup-inputs label { display: block; font-size: 0.8em; color: var(--tracker-text-muted); margin-bottom: 4px; }
        #data main .datepicker-popup-inputs input[type="text"] { width: 100%; padding: 8px 10px; border: 1px solid var(--tracker-border-color); border-radius: var(--tracker-border-radius-sm); font-size: 0.9em; background-color: var(--tracker-bg-input); }
        #data main .datepicker-popup-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; padding-top: 10px; border-top: 1px solid var(--tracker-border-color-light); }
        #data main .employee-list-container { display: flex; flex-direction: column; gap: 25px; }
        #data main .employee-card { background-color: var(--tracker-bg-surface); border-radius: var(--tracker-border-radius-lg); box-shadow: var(--tracker-card-shadow); overflow: hidden; display: flex; flex-direction: row; align-items: stretch; border: 1px solid var(--tracker-border-color-light); }
        #data main .employee-details-block { flex: 0 0 300px; padding: 25px; background-color: var(--tracker-bg-body); border-right: 1px solid var(--tracker-border-color-light); display: flex; flex-direction: column; }
        #data main .all-training-modules-wrapper { flex-grow: 1; display: flex; flex-direction: row; overflow-x: auto; overflow-y: hidden; padding: 20px 10px 20px 20px; align-items: stretch; gap: 18px; background-color: var(--tracker-bg-surface); }
        #data main .employee-name-status-wrapper { display: flex; align-items: center; gap: 10px; margin-bottom: 2px; flex-wrap: wrap; }
        #data main .employee-details-block .info-item h5 { margin: 0; font-size: 1.35em; color: var(--tracker-title-text-color); font-weight: 600; line-height: 1.3; }
        #data main .employee-id-subtext { font-size: 0.8em; color: var(--tracker-text-muted); margin: 0 0 15px 0; font-weight: 500; }
        #data main .employee-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px 15px; margin-bottom: 15px; font-size: 0.88em; }
        #data main .employee-details-block .info-item p { margin: 0; color: var(--tracker-text-muted); line-height: 1.5; }
        #data main .employee-details-block .info-item p strong { color: var(--tracker-text-dark); font-weight: 500; margin-right: 0.3em; }
        #data main .status-pill { padding: 4px 12px; border-radius: 999px; font-size: 0.75em; font-weight: 600; text-align: center; color: var(--tracker-text-on-primary); flex-shrink: 0; white-space: nowrap; line-height: 1.2; border-width: 1px; border-style: solid; }
        #data main .status-pill.Active { background-color: var(--tracker-color-success); border-color: var(--tracker-color-success); }
        #data main .status-pill.Inactive { background-color: var(--tracker-color-danger); border-color: var(--tracker-color-danger); }
        #data main .training-module-column { flex: 0 0 220px; background-color: var(--tracker-bg-surface); border: 1px solid var(--tracker-border-color-light); border-radius: var(--tracker-border-radius-md); padding: 15px; display: flex; flex-direction: column; box-shadow: 0 2px 4px rgba(0,0,0,0.03); height: 100%; box-sizing: border-box; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        #data main .training-module-column:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.06); }
        #data main .training-module-column.status-mod-Attended { border-left: 4px solid var(--tracker-color-success); }
        #data main .training-module-column.status-mod-Not-Attended { border-left: 4px solid var(--tracker-color-danger); }
        #data main .training-module-column .module-title { font-size: 1em; font-weight: 600; color: var(--tracker-title-text-color); margin-bottom: 10px; display: flex; align-items: center; gap: 0.5em; }
        #data main .training-module-column .module-title i.icon { font-size: 1.1em; color: var(--tracker-title-text-color); flex-shrink: 0; }
        #data main .status-badge { padding: 5px 16px; border-radius: 999px; font-size: 0.78em; font-weight: 600; display: inline-block; margin-bottom: 10px; line-height: 1.2; text-align: center; border-width: 1.5px; border-style: solid; transition: all 0.2s ease-in-out; }
        #data main .status-badge.Attended { background-color: var(--tracker-color-success); border-color: var(--tracker-color-success); color: var(--tracker-text-on-primary); }
        #data main .status-badge.Not-Attended { background-color: transparent; border-color: var(--tracker-color-danger); color: var(--tracker-color-danger); }
        #data main .module-inline-details p { margin: 4px 0; font-size: 0.85em; color: var(--tracker-text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        #data main .module-inline-details p strong { color: var(--tracker-text-dark); font-weight: 500; }
        #data main .module-inline-details .no-data { font-style: italic; color: #999; }
        #data main .module-competency-heading { font-size: 0.78em; font-weight: 600; color: var(--tracker-text-dark); margin-top: 10px; margin-bottom: 4px; padding-top: 8px; border-top: 1px solid var(--tracker-border-color-light); }
        #data main .module-proficiency-rating { display: flex; justify-content: space-between; align-items: center; font-size: 0.82em; color: var(--tracker-text-muted); margin-top: 0; }
        #data main .module-proficiency-rating > span { display: flex; align-items: center; }
        #data main .module-proficiency-rating strong { color: var(--tracker-text-dark); font-weight: 500; margin-right: 5px; }
        #data main .module-actual-rating-select { padding: 3px 5px; border: 1px solid var(--tracker-border-color); border-radius: var(--tracker-border-radius-sm); font-size: 0.95em; background-color: var(--tracker-bg-input); margin-left: 3px; min-width: 60px; height: auto; line-height: normal; -webkit-appearance: menulist-button; appearance: menulist-button; font-family: 'Poppins', sans-serif; }
        #data main [data-tooltip] { position: relative; cursor: help; }
        #data main [data-tooltip]::before, #data main [data-tooltip]::after { visibility:hidden; opacity:0; position:absolute; left:50%; transform:translateX(-50%); transition:opacity .2s ease, visibility .2s ease; z-index:10000; }
        #data main [data-tooltip]::before { content: attr(data-tooltip); bottom:125%; padding:8px 12px; border-radius:var(--tracker-border-radius-sm); background-color:var(--tracker-text-dark); color:var(--tracker-bg-surface); font-size:.85em; white-space:nowrap; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        #data main [data-tooltip]::after{ content:''; bottom:calc(125% - 5px); border:5px solid transparent; border-top-color:var(--tracker-text-dark); }
        #data main [data-tooltip]:hover::before, #data main [data-tooltip]:focus-visible::before, #data main [data-tooltip]:hover::after, #data main [data-tooltip]:focus-visible::after { visibility:visible; opacity:1; }
        #data main .should-actual-table { width: auto; max-width: 220px; border-collapse: collapse; border: 1px solid var(--tracker-border-color); font-size: 0.9em; border-radius: var(--tracker-border-radius-sm); overflow: hidden; }
        #data main .should-actual-table th, #data main .should-actual-table td { border: 1px solid var(--tracker-border-color); padding: 8px 12px; text-align: center; vertical-align: middle; }
        #data main .should-actual-table th { background-color: var(--tracker-border-color-light); font-weight: 600; color: var(--tracker-text-dark); }
        #data main .should-actual-table td { background-color: var(--tracker-bg-surface); }
        #data main .should-actual-table .fixed-value { line-height: 1.5; }
        #data main .should-actual-table select.input-field { width: 100%; min-width: 80px; margin: 0; box-sizing: border-box; font-size: inherit; -webkit-appearance: menulist-button; appearance: menulist-button; }
        @media (max-width: 992px) { #data main .top-filter-bar .btn-filter.primary { margin-left: 0; flex-basis: 100%; order: 5; } #data main .top-filter-bar .btn-filter.secondary { flex-basis: 100%; order: 6;} #data main .employee-card { flex-direction: column; } #data main .employee-details-block { flex-basis: auto; border-right: none; border-bottom: 1px solid var(--tracker-border-color-light); } #data main .all-training-modules-wrapper { overflow-x: visible; flex-direction: column; align-items: stretch; padding: 20px; } #data main .training-module-column { flex: 1 1 auto; min-width:0; margin-bottom:15px; } #data main .training-module-column.status-mod-Attended, #data main .training-module-column.status-mod-Not-Attended { border-left-width:4px;} }
        @media (max-width: 768px) { #data main .filter-header { flex-direction: column; align-items: flex-start; gap: 10px; } #data main .top-filter-bar { flex-direction: column; align-items: stretch; } #data main .top-filter-bar .btn-filter-popup-trigger, #data main .top-filter-bar .filter-box.date-picker-filter, #data main .top-filter-bar .btn-filter { width: 100%; margin-left: 0 !important; } #data main .custom-datepicker-popup { min-width: calc(100vw - 50px);max-width:90%;left:50%;transform:translateX(-50%);} #data main .filter-popup-content { max-width: calc(100% - 40px); } #data main .filter-popup-body { grid-template-columns: 1fr; } #data main .global-rating-legend { font-size: 0.75em; padding: 6px 10px; } }
        .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }

        /* Styles for Topic Tab (Training Calendar Management) */
        #topic {
            /* Scoped CSS Variables for Topic Tab */
            --topic-primary-bg: #eef1f5;
            --topic-container-bg: #ffffff;
            --topic-border-color: #d1d9e6;
            --topic-text-primary: #333a45;
            --topic-text-secondary: #5a6576;
            --topic-text-muted: #7b879a;
            --topic-accent-color: #0077b6;
            --topic-accent-color-darker: #005b8e;
            --topic-accent-color-hover: #006aa3;
            --topic-success-color: #2a9d8f;
            --topic-success-color-hover: #268c80;
            --topic-danger-color: #e76f51;
            --topic-danger-color-hover: #d96343;
            --topic-info-color: #457b9d;
            --topic-info-color-hover: #3c6a89;
            --topic-warning-color: #f4a261;
            --topic-warning-color-hover: #e09050;
            --topic-modal-bg: rgba(0, 0, 0, 0.5);
            --topic-modal-content-bg: #fff;
            --topic-input-border-color: #ced4da;
            --topic-input-focus-border-color: #86b7fe;
            --topic-input-focus-box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.25);
            --topic-font-family-sans-serif: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --topic-base-font-size: 16px; /* Default, can be overridden by main page if needed */
            --topic-line-height-base: 1.6;
            --topic-border-radius: 0.375rem;
            --topic-spacing-unit: 1rem;

            /* Apply base styles to the #topic container itself */
            font-family: var(--topic-font-family-sans-serif);
            background-color: var(--topic-primary-bg); /* Use its own variable */
            color: var(--topic-text-primary); /* Use its own variable */
            font-size: var(--topic-base-font-size);
            line-height: var(--topic-line-height-base);
            padding: 0 !important; /* Override tab-content padding to allow full control */
        }
        #topic .app-header { background-color: var(--topic-container-bg); padding: var(--topic-spacing-unit) calc(var(--topic-spacing-unit) * 1.5); text-align: center; border-bottom: 1px solid var(--topic-border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.07); z-index: 100; }
        #topic .app-header h1 { margin: 0; font-size: 1.6rem; font-weight: 600; color: var(--topic-accent-color); }
        #topic .main-content-area { flex-grow: 1; padding: calc(var(--topic-spacing-unit) * 1.5); width: 100%; }
        #topic .filters-container { background-color: var(--topic-container-bg); padding: var(--topic-spacing-unit); border-radius: calc(var(--topic-border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--topic-border-color); margin-bottom: calc(var(--topic-spacing-unit) * 1.5); }
        #topic .filters-container h3 { margin-top: 0; margin-bottom: var(--topic-spacing-unit); font-size: 1.2rem; color: var(--topic-accent-color); font-weight: 600; border-bottom: 1px solid var(--topic-border-color); padding-bottom: calc(var(--topic-spacing-unit) * 0.5); }
        #topic .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--topic-spacing-unit); align-items: end; }
        #topic .filters-container .form-group { margin-bottom: 0; }
        #topic .filters-container label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--topic-text-secondary); font-size: 0.9rem; }
        #topic .filters-container select, #topic .filters-container input[type="text"] { width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; line-height: 1.5; color: var(--topic-text-primary); background-color: #fff; background-clip: padding-box; border: 1px solid var(--topic-input-border-color); border-radius: var(--topic-border-radius); transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        #topic .filters-container select { appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; }
        #topic .filters-container select:focus, #topic .filters-container input[type="text"]:focus { border-color: var(--topic-input-focus-border-color); outline: 0; box-shadow: var(--topic-input-focus-box-shadow); }
        #topic .filters-container .btn { padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: var(--topic-border-radius); cursor: pointer; text-decoration: none; border: none; width: 100%; font-weight: 500; }
        #topic .filters-container .btn-secondary { background-color: var(--topic-text-muted); color: white; }
        #topic .filters-container .btn-secondary:hover { background-color: var(--topic-text-secondary); }
        #topic .hidden-by-filter { display: none !important; }
        #topic .top-action-buttons-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: var(--topic-spacing-unit); align-items: start; }
        #topic .action-group { background-color: var(--topic-container-bg); padding: var(--topic-spacing-unit); border-radius: calc(var(--topic-border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--topic-border-color); display: flex; flex-direction: column; }
        #topic .action-group h3 { margin-top: 0; margin-bottom: calc(var(--topic-spacing-unit) * 0.75); font-size: 1.1rem; color: var(--topic-accent-color); font-weight: 600; border-bottom: 1px solid var(--topic-border-color); padding-bottom: calc(var(--topic-spacing-unit) * 0.5); }
        #topic .action-group button:not(.btn-icon-action) { width: 100%; margin-bottom: calc(var(--topic-spacing-unit) * 0.5); } #topic .action-group button:last-child:not(.btn-icon-action) { margin-bottom: 0; }
        #topic .button-pair { display: flex; gap: calc(var(--topic-spacing-unit) * 0.5); } #topic .button-pair button { flex-grow: 1; }
        #topic .super-admin-dashboard-details { background-color: var(--topic-container-bg); border: 1px solid var(--topic-border-color); border-radius: calc(var(--topic-border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); margin-bottom: calc(var(--topic-spacing-unit) * 1.5); overflow: hidden; }
        #topic .super-admin-dashboard-summary { padding: var(--topic-spacing-unit) calc(var(--topic-spacing-unit) * 1.25); font-weight: 600; font-size: 1.15rem; color: var(--topic-accent-color); cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; border-bottom: 1px solid transparent; flex-wrap: wrap; }
        #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary { background-color: var(--topic-accent-color); color: white; border-bottom-color: var(--topic-accent-color-darker); }
        #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-content-wrapper .entity-name-display, #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-content-wrapper .entity-icon, #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count, #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count strong, #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .toggler-icon { color: white; }
        #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count { border-color: rgba(255,255,255,0.4); background-color: rgba(255,255,255,0.1); }
        #topic .super-admin-dashboard-summary::-webkit-details-marker, #topic .super-admin-dashboard-summary::marker { display: none; }
        #topic .super-admin-dashboard-summary .summary-actions { font-size: 0.8rem; margin-left: var(--topic-spacing-unit); }
        #topic .super-admin-dashboard-summary .toggler-icon { font-size: 0.875em; color: var(--topic-text-muted); transition: transform 0.25s ease-out; margin-left: auto; }
        #topic .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .toggler-icon { transform: rotate(90deg); }
        #topic .super-admin-dashboard-details .dashboard-action-buttons-container { padding: calc(var(--topic-spacing-unit) * 1.25); border-top: 1px solid var(--topic-border-color); }
        #topic .super-admin-dashboard-details .dashboard-action-buttons-container .top-action-buttons-grid { margin-bottom: 0; }
        #topic #topicAddTrainingProgramButton, #topic #topicDownloadFullSampleCsvButton, #topic #topicUploadFullCsvButton { padding: 0.6rem 1.2rem; font-size: 0.9rem; font-weight: 500; color: #fff; border: none; border-radius: var(--topic-border-radius); cursor: pointer; transition: background-color 0.2s ease, box-shadow 0.2s ease; text-align: center; }
        #topic #topicAddTrainingProgramButton:hover, #topic #topicDownloadFullSampleCsvButton:hover, #topic #topicUploadFullCsvButton:hover { box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #topic #topicAddTrainingProgramButton { background-color: var(--topic-accent-color); } #topic #topicAddTrainingProgramButton:hover { background-color: var(--topic-accent-color-hover); }
        #topic #topicDownloadFullSampleCsvButton { background-color: var(--topic-success-color); } #topic #topicDownloadFullSampleCsvButton:hover { background-color: var(--topic-success-color-hover); }
        #topic #topicUploadFullCsvButton { background-color: var(--topic-danger-color); } #topic #topicUploadFullCsvButton:hover { background-color: var(--topic-danger-color-hover); }
        #topic .scoped-upload-section { margin-top: 0; padding: var(--topic-spacing-unit); background-color: #f7f9fc; border-bottom: 1px solid var(--topic-border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--topic-spacing-unit); }
        #topic details > .scoped-upload-section + .entity-content-wrapper { border-top: none; }
        #topic .entity-content-wrapper > .scoped-upload-section { margin-top: var(--topic-spacing-unit); padding-top: var(--topic-spacing-unit); border-top: 1px dashed var(--topic-border-color); background-color: transparent; border-bottom: none; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--topic-spacing-unit); }
        #topic .scoped-upload-section h4 { font-size: 1rem; color: var(--topic-text-secondary); margin-bottom: 0; font-weight: 500; flex-grow: 1; }
        #topic .scoped-upload-section .button-pair { flex-shrink: 0; }
        #topic .scoped-upload-section .button-pair button, #topic .scoped-upload-section .action-button { font-size: 0.8rem; padding: 0.4rem 0.8rem; margin-bottom: 0; }
        #topic .action-button.download-sample { background-color: var(--topic-success-color); color: white; } #topic .action-button.download-sample:hover { background-color: var(--topic-success-color-hover); }
        #topic .action-button.upload-scoped { background-color: var(--topic-info-color); color: white; } #topic .action-button.upload-scoped:hover { background-color: var(--topic-info-color-hover); }
        #topic .upload-status-area { margin-top: 1rem; font-weight: 500; padding: 0.75rem; border-radius: var(--topic-border-radius); background-color: #e9ecef; border: 1px solid var(--topic-border-color); min-height: 40px; font-size: 0.85rem; line-height: 1.5; }
        #topic details.entity-level { margin-bottom: calc(var(--topic-spacing-unit) * 1.25); border-radius: calc(var(--topic-border-radius) * 1.5); background-color: var(--topic-container-bg); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--topic-border-color); overflow: hidden; transition: box-shadow 0.3s ease, opacity 0.3s ease; }
        #topic details.entity-level:hover { box-shadow: 0 5px 15px rgba(0, 30, 80, 0.1); }
        #topic summary.entity-summary { padding: var(--topic-spacing-unit) calc(var(--topic-spacing-unit) * 1.25); font-weight: 600; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s ease, color 0.2s ease; flex-wrap: wrap; }
        #topic summary.entity-summary::-webkit-details-marker, #topic summary.entity-summary::marker { display: none; }
        #topic summary.entity-summary:hover { background-color: #f8f9fa; }
        #topic details.training-program > summary.entity-summary { background-color: #f8f9fa; color: var(--topic-text-primary); font-size: 1.1rem; border-bottom: 1px solid transparent; }
        #topic details.training-program[open] > summary.entity-summary { background-color: var(--topic-accent-color); color: white; border-bottom-color: var(--topic-accent-color-darker); }
        #topic details.course-item > summary.entity-summary { background-color: #fafbfc; font-size: 1rem; color: var(--topic-text-secondary); border-bottom: 1px solid transparent; }
        #topic details.course-item[open] > summary.entity-summary { background-color: var(--topic-info-color); color: white; border-bottom-color: var(--topic-info-color-hover); }
        #topic details.entity-level[open] > summary.entity-summary .entity-icon, #topic details.entity-level[open] > summary.entity-summary .toggler-icon, #topic details.entity-level[open] > summary.entity-summary .summary-action-btn, #topic details.entity-level[open] > summary.entity-summary .edit-btn, #topic details.entity-level[open] > summary.entity-summary .activation-btn, #topic details.entity-level[open] > summary.entity-summary .entity-count, #topic details.entity-level[open] > summary.entity-summary .delete-btn  { color: white; }
        #topic .summary-content-wrapper { display: flex; align-items: center; gap: calc(var(--topic-spacing-unit) * 0.5); flex-grow: 1; min-width: 0; flex-wrap: wrap; }
        #topic .entity-icon { font-size: 1.25em; color: var(--topic-text-muted); line-height: 1; flex-shrink: 0; }
        #topic .entity-name-display { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        #topic .summary-actions { display: flex; align-items: center; gap: calc(var(--topic-spacing-unit) * 0.5); flex-shrink: 0; flex-wrap: wrap; }
        #topic .toggler-icon { font-size: 0.875em; color: var(--topic-text-muted); transition: transform 0.25s ease-out; padding: 0.25rem; line-height: 1; }
        #topic details[open] > summary.entity-summary .toggler-icon { transform: rotate(90deg); }
        #topic .entity-content-wrapper { padding: calc(var(--topic-spacing-unit) * 1.25); border-top: 1px solid var(--topic-border-color); background-color: var(--topic-container-bg); transition: opacity 0.3s ease; }
        #topic .entity-content-wrapper > details.entity-level { margin-top: var(--topic-spacing-unit); }
        #topic .entity-details-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--topic-spacing-unit); margin-bottom: var(--topic-spacing-unit); padding: var(--topic-spacing-unit); background-color: var(--topic-container-bg); border-radius: calc(var(--topic-border-radius) * 0.75); border: 1px solid #e9ecef; } #topic .detail-item { font-size: 0.9rem; } #topic .detail-item strong { color: var(--topic-text-secondary); display: block; margin-bottom: 0.25rem; font-weight: 500; } #topic .detail-item .value-display { color: var(--topic-text-muted); word-break: break-word; }
        #topic .entity-description { font-size: 0.95rem; color: var(--topic-text-secondary); margin-bottom: calc(var(--topic-spacing-unit) * 1.25); padding: 0.75rem var(--topic-spacing-unit); background-color: #f7f9fc; border-left: 4px solid var(--topic-accent-color); border-radius: 0 var(--topic-border-radius) var(--topic-border-radius) 0; }
        #topic .action-button, #topic .edit-btn, #topic .delete-btn { padding: 0.3rem 0.75rem; font-size: 0.8rem; font-weight: 500; line-height: 1.2; border-radius: calc(var(--topic-border-radius) * 0.75); margin-top: 0; box-shadow: none; text-decoration: none; white-space: nowrap; transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease; cursor: pointer; display: inline-flex; align-items: center; border: 1px solid transparent; }
        #topic .action-button:hover, #topic .edit-btn:hover, #topic .delete-btn:hover { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        #topic .action-button > span, #topic .edit-btn > span, #topic .delete-btn > span { display: inline-block; } #topic .action-button .btn-icon, #topic .edit-btn .btn-icon, #topic .delete-btn .btn-icon { margin-right: 0.3em; }
        #topic .edit-btn { background-color: transparent; border-color: var(--topic-warning-color); color: var(--topic-warning-color); }
        #topic .edit-btn:hover { background-color: var(--topic-warning-color); color: white !important; }
        #topic details[open] > summary.entity-summary .edit-btn { border-color: rgba(255,255,255,0.6); color: white; }
        #topic details[open] > summary.entity-summary .edit-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; }
        #topic .delete-btn { background-color: transparent; border-color: var(--topic-danger-color); color: var(--topic-danger-color); }
        #topic .delete-btn:hover { background-color: var(--topic-danger-color); color: white !important; }
        #topic details[open] > summary.entity-summary .delete-btn { border-color: rgba(255,255,255,0.6); color: white; }
        #topic details[open] > summary.entity-summary .delete-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; }
        #topic details.training-program:not([open]) > summary.entity-summary .summary-action-btn.add-course { color: var(--topic-success-color); border-color: var(--topic-success-color); background-color: transparent; }
        #topic details.training-program:not([open]) > summary.entity-summary .summary-action-btn.add-course:hover { background-color: var(--topic-success-color); color: white; }
        #topic details[open] > summary.entity-summary .summary-action-btn { color: white; border-color: rgba(255,255,255,0.6); background-color: rgba(255,255,255,0.1); }
        #topic details[open] > summary.entity-summary .summary-action-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; }
        #topic .activation-btn.active-state { border-color: var(--topic-success-color); color: var(--topic-success-color); background-color: transparent; }
        #topic .activation-btn.active-state:hover { background-color: var(--topic-success-color); color: white !important; }
        #topic .activation-btn.inactive-state { border-color: var(--topic-danger-color); color: var(--topic-danger-color); background-color: transparent; }
        #topic .activation-btn.inactive-state:hover { background-color: var(--topic-danger-color); color: white !important; }
        #topic details[open] > summary.entity-summary .activation-btn { border-color: rgba(255,255,255,0.6); color: white; background-color: rgba(255,255,255,0.1); }
        #topic details[open] > summary.entity-summary .activation-btn.active-state:hover { background-color: rgba(40, 167, 69, 0.5); border-color: white; }
        #topic details[open] > summary.entity-summary .activation-btn.inactive-state:hover { background-color: rgba(220, 53, 69, 0.5); border-color: white; }
        #topic .entity-count { font-size: 0.75rem; color: var(--topic-text-muted); margin-right: calc(var(--topic-spacing-unit) * 0.25); padding: 0.2rem 0.4rem; border: 1px solid var(--topic-border-color); border-radius: calc(var(--topic-border-radius) * 0.5); background-color: #f8f9fa; white-space: nowrap; line-height: 1.2; align-self: center; }
        #topic details[open] > summary.entity-summary .entity-count { color: white; border-color: rgba(255,255,255,0.4); background-color: rgba(255,255,255,0.1); }
        #topic details.entity-level[data-status="inactive"] > summary.entity-summary { opacity: 0.75; background-image: repeating-linear-gradient( -45deg, transparent, transparent 4px, rgba(0,0,0,0.02) 4px, rgba(0,0,0,0.02) 8px ); }
        #topic details.training-program[data-status="inactive"] > summary.entity-summary { background-color: #e0e0e0; }
        #topic details.course-item[data-status="inactive"] > summary.entity-summary { background-color: #f0f0f0; }
        #topic details.entity-level[data-status="inactive"] > summary.entity-summary .entity-name-display { text-decoration: line-through; color: var(--topic-text-muted) !important; }
        #topic details.entity-level[data-status="inactive"] .entity-content-wrapper { opacity: 0.6; pointer-events: none; }
        #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary { color: var(--topic-text-secondary) !important; }
        #topic details.training-program[data-status="inactive"][open] > summary.entity-summary { background-color: #d0d0d0 !important; }
        #topic details.course-item[data-status="inactive"][open] > summary.entity-summary { background-color: #e0e0e0 !important; }
        #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .entity-icon, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .toggler-icon, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .summary-action-btn, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .edit-btn, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .activation-btn, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .entity-count, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .delete-btn { color: var(--topic-text-secondary) !important; opacity: 0.7; border-color: rgba(0,0,0,0.2) !important; }
        #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .summary-action-btn:hover, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .edit-btn:hover, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .activation-btn:hover, #topic details.entity-level[data-status="inactive"][open] > summary.entity-summary .delete-btn:hover { background-color: rgba(0,0,0,0.05) !important; }
        #topic details:not([open]) > summary.entity-summary .summary-action-btn > span { color: inherit; }
        #topic details[open] > summary.entity-summary .summary-action-btn > span, #topic details[open] > summary.entity-summary .edit-btn > span, #topic details[open] > summary.entity-summary .activation-btn > span, #topic details[open] > summary.entity-summary .delete-btn > span { color: white; }
        #topic .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: var(--topic-modal-bg); }
        #topic .modal-content { background-color: var(--topic-modal-content-bg); margin: 5% auto; padding: calc(var(--topic-spacing-unit) * 1.5); border: 1px solid var(--topic-border-color); width: 80%; max-width: 650px; border-radius: var(--topic-border-radius); box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative; } #topic .modal-content[style*="max-width: 700px;"] { max-width: 750px !important; } #topic .modal-content[style*="max-width: 450px;"] { max-width: 450px !important; }
        #topic .modal-header { padding-bottom: var(--topic-spacing-unit); border-bottom: 1px solid var(--topic-border-color); margin-bottom: var(--topic-spacing-unit); }
        #topic .modal-header h2 { margin: 0; font-size: 1.5rem; color: var(--topic-text-primary); font-weight: 600; }
        #topic .close-btn { color: #aaa; position: absolute; top: calc(var(--topic-spacing-unit) * 0.75); right: calc(var(--topic-spacing-unit) * 1); font-size: 28px; font-weight: bold; line-height: 1; }
        #topic .close-btn:hover, #topic .close-btn:focus { color: black; text-decoration: none; cursor: pointer; }
        #topic .modal-body .form-group { margin-bottom: var(--topic-spacing-unit); }
        #topic .modal-body label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--topic-text-secondary); }
        #topic .modal-body input[type="text"], #topic .modal-body input[type="email"], #topic .modal-body input[type="tel"], #topic .modal-body input[type="date"], #topic .modal-body textarea, #topic .modal-body select, #topic .modal-body input[type="file"].form-control { width: 100%; padding: 0.5rem 0.75rem; font-size: 1rem; line-height: 1.5; color: var(--topic-text-primary); background-color: #fff; background-clip: padding-box; border: 1px solid var(--topic-input-border-color); border-radius: var(--topic-border-radius); transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        #topic .modal-body input[type="text"]:focus, #topic .modal-body input[type="email"]:focus, #topic .modal-body input[type="tel"]:focus, #topic .modal-body input[type="date"]:focus, #topic .modal-body textarea:focus, #topic .modal-body select:focus, #topic .modal-body input[type="file"].form-control:focus { border-color: var(--topic-input-focus-border-color); outline: 0; box-shadow: var(--topic-input-focus-box-shadow); }
        #topic .modal-body select { appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; }
        #topic .modal-body textarea { min-height: 80px; resize: vertical; }
        #topic .modal-body .subscription-fields { border-top: 1px solid var(--topic-border-color); margin-top: var(--topic-spacing-unit); padding-top: var(--topic-spacing-unit); }
        #topic .modal-footer { padding-top: var(--topic-spacing-unit); border-top: 1px solid var(--topic-border-color); margin-top: var(--topic-spacing-unit); text-align: right; }
        #topic .modal-footer .btn { padding: 0.625rem 1.25rem; font-size: 1rem; font-weight: 500; border-radius: var(--topic-border-radius); cursor: pointer; text-decoration: none; border: none; margin-left: 0.5rem; }
        #topic .modal-footer .btn-primary { background-color: var(--topic-accent-color); color: white; }
        #topic .modal-footer .btn-primary:hover { background-color: var(--topic-accent-color-hover); }
        #topic .modal-footer .btn-secondary { background-color: var(--topic-text-muted); color: white; }
        #topic .modal-footer .btn-secondary:hover { background-color: var(--topic-text-secondary); }
        #topic .btn-icon-action { background: none; border: none; cursor: pointer; font-size: 1.1em; padding: 0.2rem; color: var(--topic-text-muted); line-height: 1; }
        @media (max-width: 1200px) { }
        @media (max-width: 768px) { #topic .app-header h1 { font-size: 1.5rem; } #topic .main-content-area { padding: var(--topic-spacing-unit); } #topic .action-group button:not(.btn-icon-action), #topic .button-pair button { font-size: 0.9rem; padding: 0.6rem 1.2rem; width: 100%; } #topic .button-pair { flex-direction: column;} #topic .entity-details-grid { grid-template-columns: 1fr; } #topic summary.entity-summary { padding: calc(var(--topic-spacing-unit) * 0.75) var(--topic-spacing-unit); } #topic .entity-description { padding: 0.6rem calc(var(--topic-spacing-unit) * 0.75); } #topic .action-button, #topic .edit-btn, #topic .delete-btn { padding: 0.25rem 0.5rem; font-size: 0.75rem; } #topic .entity-count { font-size: 0.7rem; padding: 0.15rem 0.3rem; margin-right: calc(var(--topic-spacing-unit) * 0.3); } #topic .summary-actions { gap: calc(var(--topic-spacing-unit) * 0.3); } #topic .modal-content { margin: 5% auto; width: 90%; } #topic .filter-grid { grid-template-columns: 1fr; } }
        @media (max-width: 480px) { #topic .summary-actions .edit-btn > span, #topic .summary-actions .summary-action-btn > span, #topic .summary-actions .activation-btn > span, #topic .summary-actions .delete-btn > span { display: none; } #topic .summary-actions .edit-btn .btn-icon, #topic .summary-actions .summary-action-btn .btn-icon, #topic .summary-actions .activation-btn .btn-icon, #topic .summary-actions .delete-btn .btn-icon { margin-right:0; } #topic .action-button, #topic .edit-btn, #topic .summary-actions .activation-btn, #topic .delete-btn { padding: 0.3rem 0.5rem; } #topic .entity-count { font-size: 0.65rem; padding: 0.1rem 0.25rem; margin-right: calc(var(--topic-spacing-unit) * 0.2); } #topic .entity-count .count-label { display: none; } #topic .scoped-upload-section { flex-direction: column; align-items: stretch; } #topic .scoped-upload-section h4 { margin-bottom: calc(var(--topic-spacing-unit) * 0.5); text-align: center;} #topic .scoped-upload-section .button-pair { flex-direction: column; } }

        /* Styles for TNI Mapping Tab */
        #tni {
          /* Define TNI Tab specific CSS variables */
          --primary-color: #4361ee; /* Overrides global if needed for this tab */
          --primary-hover: #3a56d4;
          --secondary-color: #3f37c9; /* Overrides global if needed for this tab */
          --success-color: #4cc9f0; /* Overrides global if needed for this tab */
          --warning-color: #f8961e; /* Overrides global if needed for this tab */
          --danger-color: #f94144;  /* TNI Specific Danger Color */
          --light-bg: #f8f9fa;
          --dark-text: #212529;
          --medium-text: #495057;
          --light-text: #6c757d;
          --border-color: #dee2e6;
          --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
          --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
          --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
          --transition: all 0.3s ease;

          font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
          line-height: 1.6;
          background-color: #f5f7fb; /* Specific background for this tab's content area */
          color: var(--dark-text); /* Use TNI's dark-text */
          padding: 0 !important; /* Override .tab-content padding to allow full control by .container */
        }

        #tni .container {
          max-width: 1400px;
          margin: 0 auto;
          background-color: #fff;
          padding: 2rem; /* Inner padding for the content */
          border-radius: 12px;
          box-shadow: var(--shadow-lg);
        }

        #tni .header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 2rem;
          padding-bottom: 1.5rem;
          border-bottom: 1px solid var(--border-color);
        }

        #tni .header h1 {
          color: var(--primary-color); /* Uses TNI's primary color */
          font-weight: 600;
          font-size: 1.8rem;
          margin: 0;
        }

        #tni .header-controls {
          display: flex;
          gap: 1rem;
        }

        #tni .btn {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          padding: 0.5rem 1rem;
          border-radius: 6px;
          font-weight: 500;
          font-size: 0.875rem;
          cursor: pointer;
          transition: var(--transition);
          border: 1px solid transparent;
        }

        #tni .btn-primary {
          background-color: var(--primary-color);
          color: white;
        }

        #tni .btn-primary:hover {
          background-color: var(--primary-hover);
          box-shadow: var(--shadow-sm);
        }

        #tni .btn-outline {
          background-color: transparent;
          border-color: var(--border-color);
          color: var(--medium-text);
        }

        #tni .btn-outline:hover {
          background-color: var(--light-bg);
        }

        #tni .btn-sm {
          padding: 0.375rem 0.75rem;
          font-size: 0.8125rem;
        }

        #tni .table-responsive {
          overflow-x: auto;
          margin-top: 1.5rem;
          border-radius: 8px;
          border: 1px solid var(--border-color);
          box-shadow: var(--shadow-sm);
        }

        #tni table {
          width: 100%;
          border-collapse: separate;
          border-spacing: 0;
          min-width: 1000px;
        }

        #tni th, #tni td {
          padding: 0.75rem 1rem;
          text-align: left;
          vertical-align: middle;
          font-size: 0.875rem;
          border-right: 1px solid var(--border-color);
          border-bottom: 1px solid var(--border-color);
        }
         /* Remove right border for last th/td in a row */
        #tni th:last-child, #tni td:last-child {
            border-right: none;
        }
        /* Remove bottom border for last row's th/td */
        #tni tr:last-child th, #tni tr:last-child td {
            border-bottom: none;
        }


        #tni th {
          font-weight: 600;
          color: var(--medium-text);
          background-color: var(--light-bg);
          position: sticky;
          top: 0; /* For sticky headers to work, .tab-content overflow-y needs to be on the table-responsive or its parent */
        }

        #tni .hierarchical-column-header {
          text-align: left;
          background-color: #e9ecef;
          white-space: nowrap;
          font-weight: 600;
          color: var(--dark-text);
        }

        #tni .col-department { width: 160px; }
        #tni .col-category { width: 180px; }
        #tni .col-role { width: 200px; }

        #tni .category-header {
          background-color: #e2e8ee;
          color: #2a4d69;
          text-align: center;
          font-weight: 600;
          white-space: nowrap;
        }

        #tni .rotated-header {
          height: 120px;
          width: 40px;
          padding: 0;
          position: relative;
          background-color: #f1f3f5;
        }

        #tni .rotated-header > div {
          position: absolute;
          bottom: 0;
          left: 50%;
          transform: translateX(-50%) rotate(-90deg);
          transform-origin: 0 0;
          width: 120px; /* Should be equal to height of rotated-header */
          padding-bottom: 5px; /* space between text and cell border */
          text-align: center;
          font-weight: 500;
          font-size: 0.8rem;
          white-space: nowrap;
        }

        #tni tbody tr:hover {
          background-color: rgba(67, 97, 238, 0.05);
        }

        #tni .hierarchical-row-label {
          font-weight: 600;
          color: var(--dark-text);
          background-color: #f8f9fa;
          white-space: nowrap;
        }

        #tni .status-indicator {
          display: inline-block;
          width: 12px;
          height: 12px;
          border-radius: 50%;
          margin-right: 6px;
        }

        #tni .completed {
          background-color: var(--success-color); /* Uses TNI's success color */
        }

        #tni .in-progress {
          background-color: var(--warning-color); /* Uses TNI's warning color */
        }

        #tni .not-started {
          background-color: var(--danger-color); /* Uses TNI's danger color */
        }

        #tni select {
          padding: 0.5rem 0.75rem;
          border: 1px solid var(--border-color);
          border-radius: 4px;
          background-color: #fff;
          min-width: 80px;
          cursor: pointer;
          font-size: 0.875rem;
          transition: var(--transition);
          appearance: none;
          background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
          background-repeat: no-repeat;
          background-position: right 0.5rem center;
          background-size: 12px;
        }

        #tni select:focus {
          outline: none;
          border-color: var(--primary-color);
          box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        #tni .competency-select {
          display: flex;
          align-items: center;
        }

        #tni .competency-select select {
          flex-grow: 1;
        }

        #tni [data-tooltip] {
          position: relative;
          cursor: pointer;
        }

        #tni [data-tooltip]:hover::after {
          content: attr(data-tooltip);
          position: absolute;
          bottom: 100%;
          left: 50%;
          transform: translateX(-50%);
          background-color: #333;
          color: white;
          padding: 0.25rem 0.5rem;
          border-radius: 4px;
          font-size: 0.75rem;
          white-space: nowrap;
          z-index: 10;
          margin-bottom: 5px;
        }

        #tni .badge {
          display: inline-block;
          padding: 0.25rem 0.5rem;
          font-size: 0.75rem;
          font-weight: 600;
          line-height: 1;
          text-align: center;
          white-space: nowrap;
          vertical-align: baseline;
          border-radius: 0.25rem;
        }

        #tni .badge-primary {
          background-color: var(--primary-color);
          color: white;
        }

        #tni .badge-light {
          background-color: var(--light-bg);
          color: var(--medium-text);
        }

        #tni .filter-controls {
          display: flex;
          gap: 1rem;
          margin-bottom: 1.5rem;
          flex-wrap: wrap;
        }

        #tni .filter-group {
          display: flex;
          align-items: center;
          gap: 0.5rem;
        }

        #tni .filter-label {
          font-size: 0.875rem;
          color: var(--medium-text);
          font-weight: 500;
        }

        #tni .filter-select {
          padding: 0.375rem 0.75rem;
          border-radius: 4px;
          border: 1px solid var(--border-color);
          font-size: 0.875rem;
        }

        #tni .legend {
          display: flex;
          gap: 1.5rem;
          margin-top: 1.5rem;
          font-size: 0.875rem;
        }

        #tni .legend-item {
          display: flex;
          align-items: center;
          gap: 0.5rem;
        }

        @media (max-width: 768px) {
          #tni .container {
            padding: 1rem;
          }
          #tni .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
          }
          #tni .header-controls {
            width: 100%;
            justify-content: space-between;
          }
        }






    /* 1. Make the entire header row block sticky to the top */
    .make-sticky-head th {
      position: sticky;
      top: 0;
      z-index: 3;
      background: white; /* Important for sticky headers */
    }
    
    /* 2. Define sticky columns for the left */
    .sticky-col {
      position: sticky;
    }
    
    /* JavaScript will dynamically set the 'left' property */
    .sticky-col-1 {
      left: 0;
      z-index: 2; /* Must be lower than sticky header */
    }
    .sticky-col-2 {
      z-index: 2;
    }
    .sticky-col-3 {
      z-index: 2;
    }
    
    /* 3. Elevate the top-left corner cells to be on top of everything */
    thead .sticky-col {
      z-index: 4; /* Highest z-index */
    }







 /* The container for the tab buttons */
        .tab-buttons {
            display: flex;
            background-color: #e9ecef;
            border-bottom: 1px solid #dee2e6;
        }

        /* Individual tab button styling */
        .tab-button {
            padding: 15px 25px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            font-size: 16px;
            font-weight: 500;
            color: #495057;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
            border-bottom: 3px solid transparent; 
        }

        .tab-button:not(.active):hover {
            background-color: #f1f3f5;
        }

        .tab-button.active {
            color: #007bff;
            background-color: #ffffff; 
            /*border-bottom: 3px solid #007bff;*/
        }
        
        
         .tab-content-area {
             padding: 0; /* Remove padding to allow full-width content from your app */
        }
        
        /* Adjusted padding for the second tab's content */
        .tab-content-area .observation-content {
            padding: 25px;
        }

        /*.tab-content {*/
        /*    display: none; */
        /*}*/

        .tab-content.active {
            display: block; 
        }
        
        
         #addTrainingProgramButton, #downloadFullSampleCsvButton, #uploadFullCsvButton { padding: 0.6rem 1.2rem; font-size: 0.9rem; font-weight: 500; color: #fff; border: none; border-radius: var(--border-radius); cursor: pointer; transition: background-color 0.2s ease, box-shadow 0.2s ease; text-align: center; }
        #addTrainingProgramButton:hover, #downloadFullSampleCsvButton:hover, #uploadFullCsvButton:hover { box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #addTrainingProgramButton { background-color: var(--accent-color); } #addTrainingProgramButton:hover { background-color: var(--accent-color-hover); }
        #downloadFullSampleCsvButton { background-color: var(--success-color); } #downloadFullSampleCsvButton:hover { background-color: var(--success-color-hover); }
        #uploadFullCsvButton { background-color: var(--danger-color); } #uploadFullCsvButton:hover { background-color: var(--danger-color-hover); }
        
        
          #sopsTab { font-family: var(--font-family-sans-serif); color: var(--text-primary); line-height: var(--line-height-base); background-color: var(--primary-bg);}
        #sopsTab body { font-family: var(--font-family-sans-serif); margin: 0; background-color: var(--primary-bg); color: var(--text-primary); line-height: var(--line-height-base); display: flex; flex-direction: column; min-height: auto; }
        .app-header { background-color: var(--container-bg); padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.5); text-align: center; border-bottom: 1px solid var(--border-color); box-shadow: 0 2px 5px rgba(0,0,0,0.07); z-index: 100; }
        .app-header h1 { margin: 0; font-size: 1.6rem; font-weight: 600; color: var(--accent-color); }
        .main-content-area { flex-grow: 1; padding: calc(var(--spacing-unit) * 1.5); width: 100%; }
        .filters-container { background-color: var(--container-bg); padding: var(--spacing-unit); border-radius: calc(var(--border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--border-color); margin-bottom: calc(var(--spacing-unit) * 1.5); }
        .filters-container h3 { margin-top: 0; margin-bottom: var(--spacing-unit); font-size: 1.2rem; color: var(--accent-color); font-weight: 600; border-bottom: 1px solid var(--border-color); padding-bottom: calc(var(--spacing-unit) * 0.5); }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-unit); align-items: end; }
        .filters-container .form-group { margin-bottom: 0; }
        .filters-container label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-secondary); font-size: 0.9rem; }
        .filters-container select, .filters-container input[type="text"] { width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; line-height: 1.5; color: var(--text-primary); background-color: #fff; background-clip: padding-box; border: 1px solid var(--input-border-color); border-radius: var(--border-radius); transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        .filters-container select { appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; }
        .filters-container select:focus, .filters-container input[type="text"]:focus { border-color: var(--input-focus-border-color); outline: 0; box-shadow: var(--input-focus-box-shadow); }
        .filters-container .btn { padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: var(--border-radius); cursor: pointer; text-decoration: none; border: none; width: 100%; font-weight: 500; }
        .filters-container .btn-secondary { background-color: var(--text-muted); color: white; }
        .filters-container .btn-secondary:hover { background-color: var(--text-secondary); }
        .hidden { display: none !important; }
        .top-action-buttons-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: var(--spacing-unit); align-items: start; }
        .action-group { background-color: var(--container-bg); padding: var(--spacing-unit); border-radius: calc(var(--border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--border-color); display: flex; flex-direction: column; }
        .action-group h3 { margin-top: 0; margin-bottom: calc(var(--spacing-unit) * 0.75); font-size: 1.1rem; color: var(--accent-color); font-weight: 600; border-bottom: 1px solid var(--border-color); padding-bottom: calc(var(--spacing-unit) * 0.5); }
        .action-group button:not(.btn-icon-action) { width: 100%; margin-bottom: calc(var(--spacing-unit) * 0.5); } .action-group button:last-child:not(.btn-icon-action) { margin-bottom: 0; }
        .button-pair { display: flex; gap: calc(var(--spacing-unit) * 0.5); } .button-pair button { flex-grow: 1; }
        .super-admin-dashboard-details { background-color: var(--container-bg); border: 1px solid var(--border-color); border-radius: calc(var(--border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); margin-bottom: calc(var(--spacing-unit) * 1.5); overflow: hidden; }
        .super-admin-dashboard-summary { padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.25); font-weight: 600; font-size: 1.15rem; color: var(--accent-color); cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; border-bottom: 1px solid transparent; flex-wrap: wrap; }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary { background-color: var(--accent-color); color: white; border-bottom-color: var(--accent-color-darker); }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-content-wrapper .entity-name-display, .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-content-wrapper .entity-icon, .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count, .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count strong, .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .toggler-icon { color: white; }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count { border-color: rgba(255,255,255,0.4); background-color: rgba(255,255,255,0.1); }
        .super-admin-dashboard-summary::-webkit-details-marker, .super-admin-dashboard-summary::marker { display: none; }
        .super-admin-dashboard-summary .summary-actions { font-size: 0.8rem; margin-left: var(--spacing-unit); }
        .super-admin-dashboard-summary .toggler-icon { font-size: 0.875em; color: var(--text-muted); transition: transform 0.25s ease-out; margin-left: auto; }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .toggler-icon { transform: rotate(90deg); }
        .super-admin-dashboard-details .dashboard-action-buttons-container { padding: calc(var(--spacing-unit) * 1.25); border-top: 1px solid var(--border-color); }
        .super-admin-dashboard-details .dashboard-action-buttons-container .top-action-buttons-grid { margin-bottom: 0; }
       
        .scoped-upload-section, .keyword-management-section { margin-top: 0; padding: var(--spacing-unit); background-color: #f7f9fc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-unit); }
        .scoped-upload-section { border-bottom: 1px solid var(--border-color); }
        .keyword-management-section { border-top: 1px dashed var(--border-color); margin-top: var(--spacing-unit); }
        details > .scoped-upload-section + .entity-content-wrapper { border-top: none; }
        .entity-content-wrapper > .scoped-upload-section { margin-top: var(--spacing-unit); padding-top: var(--spacing-unit); border-top: 1px dashed var(--border-color); background-color: transparent; border-bottom: none; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-unit); }
        .scoped-upload-section h4, .keyword-management-section h4 { font-size: 1rem; color: var(--text-secondary); margin-bottom: 0; font-weight: 500; flex-grow: 1; }
        .scoped-upload-section .button-pair, .keyword-management-section .button-pair { flex-shrink: 0; }
        .scoped-upload-section .button-pair button, .scoped-upload-section .action-button, .keyword-management-section .button-pair button { font-size: 0.8rem; padding: 0.4rem 0.8rem; margin-bottom: 0; }
        .action-button.download-sample { background-color: var(--success-color); color: white; } .action-button.download-sample:hover { background-color: var(--success-color-hover); }
        .action-button.upload-scoped { background-color: var(--info-color); color: white; } .action-button.upload-scoped:hover { background-color: var(--info-color-hover); }
        .upload-status-area { margin-top: 1rem; font-weight: 500; padding: 0.75rem; border-radius: var(--border-radius); background-color: #e9ecef; border: 1px solid var(--border-color); min-height: 40px; font-size: 0.85rem; line-height: 1.5; }
        details.entity-level { margin-bottom: calc(var(--spacing-unit) * 1.25); border-radius: calc(var(--border-radius) * 1.5); background-color: var(--container-bg); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--border-color); overflow: hidden; transition: box-shadow 0.3s ease, opacity 0.3s ease; }
        details.entity-level:hover { box-shadow: 0 5px 15px rgba(0, 30, 80, 0.1); }
        summary.entity-summary { padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.25); font-weight: 600; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s ease, color 0.2s ease; flex-wrap: wrap; }
        summary.entity-summary::-webkit-details-marker, summary.entity-summary::marker { display: none; }
        summary.entity-summary:hover { background-color: #f8f9fa; }
        details.training-program > summary.entity-summary { background-color: #f8f9fa; color: var(--text-primary); font-size: 1.1rem; border-bottom: 1px solid transparent; } 
        details.training-program[open] > summary.entity-summary { background-color: var(--accent-color); color: white; border-bottom-color: var(--accent-color-darker); }
        details.course-item > summary.entity-summary { background-color: #fafbfc; font-size: 1rem; color: var(--text-secondary); border-bottom: 1px solid transparent; } 
        details.course-item[open] > summary.entity-summary { background-color: var(--info-color); color: white; border-bottom-color: var(--info-color-hover); }
        details.entity-level[open] > summary.entity-summary .entity-icon, details.entity-level[open] > summary.entity-summary .toggler-icon, details.entity-level[open] > summary.entity-summary .summary-action-btn, details.entity-level[open] > summary.entity-summary .edit-btn, details.entity-level[open] > summary.entity-summary .activation-btn, details.entity-level[open] > summary.entity-summary .entity-count, details.entity-level[open] > summary.entity-summary .delete-btn  { color: white; }
        .summary-content-wrapper { display: flex; align-items: center; gap: calc(var(--spacing-unit) * 0.5); flex-grow: 1; min-width: 0; flex-wrap: wrap; } 
        .entity-icon { font-size: 1.25em; color: var(--text-muted); line-height: 1; flex-shrink: 0; } 
        .entity-name-display { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; } 
        .summary-actions { display: flex; align-items: center; gap: calc(var(--spacing-unit) * 0.5); flex-shrink: 0; flex-wrap: wrap; } 
        .toggler-icon { font-size: 0.875em; color: var(--text-muted); transition: transform 0.25s ease-out; padding: 0.25rem; line-height: 1; } 
        details[open] > summary.entity-summary .toggler-icon { transform: rotate(90deg); }
        .entity-content-wrapper { padding: calc(var(--spacing-unit) * 1.25); border-top: 1px solid var(--border-color); background-color: var(--container-bg); transition: opacity 0.3s ease; }
        .entity-content-wrapper > details.entity-level { margin-top: var(--spacing-unit); } 
        .entity-description { font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 1rem; padding: 0.75rem var(--spacing-unit); background-color: #f7f9fc; border-left: 4px solid var(--accent-color); border-radius: 0 var(--border-radius) var(--border-radius) 0; }
        
        .keywords-display-container { margin-top: 1rem; margin-bottom: 0; padding: 0.75rem var(--spacing-unit); background-color: #f7f9fc; border-left: 4px solid var(--info-color); border-radius: 0 var(--border-radius) var(--border-radius) 0; display: flex; flex-wrap: wrap; align-items: flex-start; gap: 0.75rem; }
        .keywords-display-container strong { color: var(--text-secondary); font-weight: 500; line-height: 1.8; flex-shrink: 0; }
        .keywords-list { display: inline-flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
        .keyword-tag { background-color: var(--info-color); color: white; padding: 0.2rem 0.4rem 0.2rem 0.6rem; border-radius: var(--border-radius); font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.3rem; }
        .delete-keyword-btn { background: transparent; border: none; color: white; opacity: 0.6; cursor: pointer; padding: 0 0.2rem; font-size: 1.1em; line-height: 1; transition: opacity 0.2s; }
        .delete-keyword-btn:hover { opacity: 1; }
        .add-keyword-wrapper { position: relative; }
        .add-keyword-btn { background-color: transparent; border: 1px dashed var(--text-muted); color: var(--text-muted); padding: 0.2rem 0.6rem; font-size: 0.8rem; border-radius: var(--border-radius); cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 0.3em; }
        .add-keyword-btn:hover { background-color: var(--text-muted); color: white; border-style: solid; }
        .add-keyword-input-group { display: flex; align-items: center; gap: 0.25rem; }
        .add-keyword-input { font-size: 0.8rem; padding: 0.2rem 0.4rem; border: 1px solid var(--input-border-color); border-radius: var(--border-radius); width: 120px; }
        .add-keyword-input-group button { background: var(--text-muted); color: white; border: none; cursor: pointer; border-radius: var(--border-radius); font-size: 0.9rem; line-height: 1; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s; }
        .add-keyword-input-group button.save-keyword-btn { background-color: var(--success-color); }
        .add-keyword-input-group button.save-keyword-btn:hover { background-color: var(--success-color-hover); }
        .add-keyword-input-group button.cancel-keyword-btn { background-color: var(--danger-color); }
        .add-keyword-input-group button.cancel-keyword-btn:hover { background-color: var(--danger-color-hover); }
        
        .action-button, .edit-btn, .delete-btn { padding: 0.3rem 0.75rem; font-size: 0.8rem; font-weight: 500; line-height: 1.2; border-radius: calc(var(--border-radius) * 0.75); margin-top: 0; box-shadow: none; text-decoration: none; white-space: nowrap; transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease; cursor: pointer; display: inline-flex; align-items: center; border: 1px solid transparent; }
        .action-button:hover, .edit-btn:hover, .delete-btn:hover { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .action-button > span, .edit-btn > span, .delete-btn > span { display: inline-block; } .action-button .btn-icon, .edit-btn .btn-icon, .delete-btn .btn-icon { margin-right: 0.3em; } 
        .edit-btn { background-color: transparent; border-color: var(--warning-color); color: var(--warning-color); } 
        .edit-btn:hover { background-color: var(--warning-color); color: white !important; } 
        details[open] > summary.entity-summary .edit-btn { border-color: rgba(255,255,255,0.6); color: white; } 
        details[open] > summary.entity-summary .edit-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; } 
        .delete-btn { background-color: transparent; border-color: var(--danger-color); color: var(--danger-color); } 
        .delete-btn:hover { background-color: var(--danger-color); color: white !important; } 
        details[open] > summary.entity-summary .delete-btn { border-color: rgba(255,255,255,0.6); color: white; } 
        details[open] > summary.entity-summary .delete-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; } 
        details.training-program:not([open]) > summary.entity-summary .summary-action-btn.add-course { color: var(--success-color); border-color: var(--success-color); background-color: transparent; } 
        details.training-program:not([open]) > summary.entity-summary .summary-action-btn.add-course:hover { background-color: var(--success-color); color: white; } 
        details[open] > summary.entity-summary .summary-action-btn { color: white; border-color: rgba(255,255,255,0.6); background-color: rgba(255,255,255,0.1); } 
        details[open] > summary.entity-summary .summary-action-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; } 
        .activation-btn.active-state { border-color: var(--success-color); color: var(--success-color); background-color: transparent; } 
        .activation-btn.active-state:hover { background-color: var(--success-color); color: white !important; } 
        .activation-btn.inactive-state { border-color: var(--danger-color); color: var(--danger-color); background-color: transparent; } 
        .activation-btn.inactive-state:hover { background-color: var(--danger-color); color: white !important; } 
        details[open] > summary.entity-summary .activation-btn { border-color: rgba(255,255,255,0.6); color: white; background-color: rgba(255,255,255,0.1); } 
        details[open] > summary.entity-summary .activation-btn.active-state:hover { background-color: rgba(40, 167, 69, 0.5); border-color: white; } 
        details[open] > summary.entity-summary .activation-btn.inactive-state:hover { background-color: rgba(220, 53, 69, 0.5); border-color: white; }
        .entity-count { font-size: 0.75rem; color: var(--text-muted); margin-right: calc(var(--spacing-unit) * 0.25); padding: 0.2rem 0.4rem; border: 1px solid var(--border-color); border-radius: calc(var(--border-radius) * 0.5); background-color: #f8f9fa; white-space: nowrap; line-height: 1.2; align-self: center; } 
        details[open] > summary.entity-summary .entity-count { color: white; border-color: rgba(255,255,255,0.4); background-color: rgba(255,255,255,0.1); }
        details.entity-level[data-status="inactive"] > summary.entity-summary { opacity: 0.75; background-image: repeating-linear-gradient( -45deg, transparent, transparent 4px, rgba(0,0,0,0.02) 4px, rgba(0,0,0,0.02) 8px ); } 
        details.training-program[data-status="inactive"] > summary.entity-summary { background-color: #e0e0e0; } 
        details.course-item[data-status="inactive"] > summary.entity-summary { background-color: #f0f0f0; } 
        details.entity-level[data-status="inactive"] > summary.entity-summary .entity-name-display { text-decoration: line-through; color: var(--text-muted) !important; } 
        details.entity-level[data-status="inactive"] .entity-content-wrapper { opacity: 0.6; pointer-events: none; } 
        details.entity-level[data-status="inactive"][open] > summary.entity-summary { color: var(--text-secondary) !important; } 
        details.training-program[data-status="inactive"][open] > summary.entity-summary { background-color: #d0d0d0 !important; } 
        details.course-item[data-status="inactive"][open] > summary.entity-summary { background-color: #e0e0e0 !important; } 
        details.entity-level[data-status="inactive"][open] > summary.entity-summary .entity-icon, details.entity-level[data-status="inactive"][open] > summary.entity-summary .toggler-icon, details.entity-level[data-status="inactive"][open] > summary.entity-summary .summary-action-btn, details.entity-level[data-status="inactive"][open] > summary.entity-summary .edit-btn, details.entity-level[data-status="inactive"][open] > summary.entity-summary .activation-btn, details.entity-level[data-status="inactive"][open] > summary.entity-summary .entity-count, details.entity-level[data-status="inactive"][open] > summary.entity-summary .delete-btn { color: var(--text-secondary) !important; opacity: 0.7; border-color: rgba(0,0,0,0.2) !important; } 
        details.entity-level[data-status="inactive"][open] > summary.entity-summary .summary-action-btn:hover, details.entity-level[data-status="inactive"][open] > summary.entity-summary .edit-btn:hover, details.entity-level[data-status="inactive"][open] > summary.entity-summary .activation-btn:hover, details.entity-level[data-status="inactive"][open] > summary.entity-summary .delete-btn:hover { background-color: rgba(0,0,0,0.05) !important; }
        details:not([open]) > summary.entity-summary .summary-action-btn > span { color: inherit; } 
        details[open] > summary.entity-summary .summary-action-btn > span, details[open] > summary.entity-summary .edit-btn > span, details[open] > summary.entity-summary .activation-btn > span, details[open] > summary.entity-summary .delete-btn > span { color: white; }
        .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: var(--modal-bg); } .modal-content { background-color: var(--modal-content-bg); margin: 5% auto; padding: calc(var(--spacing-unit) * 1.5); border: 1px solid var(--border-color); width: 80%; max-width: 650px; border-radius: var(--border-radius); box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative; } .modal-content[style*="max-width: 700px;"] { max-width: 750px !important; } .modal-content[style*="max-width: 450px;"] { max-width: 450px !important; } .modal-header { padding-bottom: var(--spacing-unit); border-bottom: 1px solid var(--border-color); margin-bottom: var(--spacing-unit); } .modal-header h2 { margin: 0; font-size: 1.5rem; color: var(--text-primary); font-weight: 600; } .close-btn { color: #aaa; position: absolute; top: calc(var(--spacing-unit) * 0.75); right: calc(var(--spacing-unit) * 1); font-size: 28px; font-weight: bold; line-height: 1; } .close-btn:hover, .close-btn:focus { color: black; text-decoration: none; cursor: pointer; } .modal-body .form-group { margin-bottom: var(--spacing-unit); } .modal-body label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-secondary); } .modal-body input[type="text"], .modal-body input[type="email"], .modal-body input[type="tel"], .modal-body input[type="date"], .modal-body textarea, .modal-body select, .modal-body input[type="file"].form-control { width: 100%; padding: 0.5rem 0.75rem; font-size: 1rem; line-height: 1.5; color: var(--text-primary); background-color: #fff; background-clip: padding-box; border: 1px solid var(--input-border-color); border-radius: var(--border-radius); transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; } .modal-body input[type="text"]:focus, .modal-body input[type="email"]:focus, .modal-body input[type="tel"]:focus, .modal-body input[type="date"]:focus, .modal-body textarea:focus, .modal-body select:focus, .modal-body input[type="file"].form-control:focus { border-color: var(--input-focus-border-color); outline: 0; box-shadow: var(--input-focus-box-shadow); } .modal-body select { appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; } .modal-body textarea { min-height: 80px; resize: vertical; } .modal-body .subscription-fields { border-top: 1px solid var(--border-color); margin-top: var(--spacing-unit); padding-top: var(--spacing-unit); } .modal-footer { padding-top: var(--spacing-unit); border-top: 1px solid var(--border-color); margin-top: var(--spacing-unit); text-align: right; } .modal-footer .btn { padding: 0.625rem 1.25rem; font-size: 1rem; font-weight: 500; border-radius: var(--border-radius); cursor: pointer; text-decoration: none; border: none; margin-left: 0.5rem; } .modal-footer .btn-primary { background-color: var(--accent-color); color: white; } .modal-footer .btn-primary:hover { background-color: var(--accent-color-hover); } .modal-footer .btn-secondary { background-color: var(--text-muted); color: white; } .modal-footer .btn-secondary:hover { background-color: var(--text-secondary); } 
        .btn-icon-action { background: none; border: none; cursor: pointer; font-size: 1.1em; padding: 0.2rem; color: var(--text-muted); line-height: 1; }
        
        
        
        
        
        
        
            body.modal-open {
    overflow: hidden;
    padding-right: 0 !important;
}


        .main-container {
             width: 100%;
            max-width: 1800px;
            background-color: var(--surface-color);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 2rem auto;
        }
        
        /* --- Analytics Dashboard --- */
        .analytics-dashboard {
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--dashboard-bg);
        }
        .dashboard-header {
            margin-bottom: 1.5rem;
        }
        .dashboard-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
        }
        .dashboard-header p { font-size: 1rem; color: var(--text-color-light); margin-top: 0.5rem; }
        
        /* --- Dashboard Filter Bar --- */
        .dashboard-filter-bar { padding-bottom: 1.5rem; }
        .filter-controls-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }
        .filter-control-group { position: relative; }
        .filter-control-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-color-light);
            text-transform: uppercase;
        }
        
        .btn.filter-active {
            border-color: var(--primary-color);
            background-color: #eef2ff;
        }
        .btn .fa-filter.active, .btn .fa-sliders-h.active, .btn .fa-flag.active { 
            color: var(--primary-color); 
        }

        /* --- Dynamic 3D Chart Styles --- */
        .dynamic-chart-wrapper {
            padding: 2rem 0;
            color: var(--chart-color-text);
        }
        .chart-container {
            background-color: var(--surface-color);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            margin: auto;
            position: relative;
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .chart-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            flex-grow: 1;
        }
        .chart-header .right-controls {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .chart-actions {
            display: flex;
            gap: 0.5rem;
        }
        .chart-granularity-selector {
            display: flex;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            background-color: #f3f4f6;
        }
        .chart-granularity-selector button {
            background: none; border: none; padding: 0.4rem 0.8rem; font-size: 0.9rem;
            font-weight: 500; cursor: pointer; color: var(--text-color-light); transition: all 0.2s;
        }
        .chart-granularity-selector button:not(:last-child) {
            border-right: 1px solid var(--border-color);
        }
        .chart-granularity-selector button.active {
            background-color: var(--surface-color); color: var(--primary-color); box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }


        .chart-area {
                display: grid;
                grid-template-columns: auto auto 1fr auto;
                gap: 10px;
                /* overflow-x: auto; */
                padding-bottom: 15px;
            }
        .y-axis {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: right;
            font-size: 0.8rem;
            height: 300px;
            position: sticky; 
            background-color: var(--surface-color);
        }
        .y-axis.y-axis-left {
            padding-right: 10px;
            left: 0;
            z-index: 15;
        }
        /* CORRECTED: Make second axis a normal grid item */
        .y-axis.y-axis-avg {
            position: static;
            padding-right: 10px;
            font-weight: 600;
            color: var(--orange);
        }
        .y-axis.y-axis-right {
            text-align: left;
            padding-left: 10px;
            right: 0;
            z-index: 15;
            font-weight: 600;
            color: var(--text-color-dark);
        }
        .plot-area {
            position: relative;
            height: 300px;
            border-left: 1px solid var(--chart-color-grid);
            border-right: 1px solid var(--chart-color-grid);
        }
        #line-chart-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 12;
        }
        .grid-lines {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            display: flex; flex-direction: column; justify-content: space-between;
        }
        .grid-line { width: 100%; height: 1px; background-color: var(--chart-color-grid); }
        .grid-line:last-child { background-color: var(--chart-color-text); }

        .bars-container {
            position: relative; z-index: 10; display: flex;
            justify-content: space-around; align-items: flex-end; height: 100%; padding: 0 20px;
        }
        .bar-group {
            display: contents;
        }
        .bar {
            width: var(--chart-bar-width); height: 100%;
            display: flex; flex-direction: column-reverse;
            flex-shrink: 0;
        }
        .segment { position: relative; width: 100%; transition: height 0.3s ease-in-out; }

        .segment-label {
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }

        .bar-totals-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-around;
            padding: 0 20px;
            pointer-events: none;
            z-index: 11;
        }
        .bar-total-label {
            width: var(--chart-bar-width);
            flex-shrink: 0;
            position: relative;
        }
        .bar-total-label span {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: 0; 
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--text-color-dark);
            padding-bottom: 4px;
        }

        .segment::after {
            content: ''; position: absolute; top: 0; right: 0; width: var(--chart-bar-depth); height: 100%;
            transform: skewY(var(--chart-bar-skew)) translateX(var(--chart-bar-depth));
            transform-origin: top right;
        }
        .segment.top-segment::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: var(--chart-bar-depth);
            transform: skewX(var(--chart-bar-skew)) translateY(calc(-1 * var(--chart-bar-depth)));
            transform-origin: bottom left;
        }
        
        .high { background-color: var(--chart-color-high); }
        .high::before, .high::after { background-color: var(--chart-color-high-dark); }
        .medium { background-color: var(--chart-color-medium); }
        .medium::before, .medium::after { background-color: var(--chart-color-medium-dark); }
        .low { background-color: var(--chart-color-low); }
        .low::before, .low::after { background-color: var(--chart-color-low-dark); }
        
        .segment[data-tooltip]:hover { z-index: 100; }
        .segment[data-tooltip]::before {
            content: attr(data-tooltip); position: absolute; bottom: 105%; left: 50%;
            transform: translateX(-50%); padding: 0.5rem 0.75rem; border-radius: 6px;
            background-color: var(--text-color-dark); color: white; font-size: 0.8rem;
            white-space: pre; line-height: 1.4; pointer-events: none;
            opacity: 0; visibility: hidden; transition: opacity 0.2s, visibility 0.2s;
        }
        .segment[data-tooltip]:hover::before { opacity: 1; visibility: visible; }

        .x-axis { grid-column: 3 / 4; margin-top: 10px; font-size: 0.8rem; }
        .x-axis-labels {
            display: flex;
            justify-content: space-around;
            padding: 0 20px;
            margin-top: 5px; 
            height: 80px; 
        }
        .x-axis-label {
            flex-shrink: 0;
            width: var(--chart-bar-width);
            position: relative;
        }
        .x-axis-label > div {
            position: absolute;
            right: 8px;
            top: 5px;
            transform: rotate(-60deg);
            transform-origin: right top;
            white-space: nowrap;
            text-align: right;
        }
        .label-group { font-weight: 600; }
        .label-period { font-size: 0.75rem; color: var(--text-color-light); }
        
        .legend { display: flex; justify-content: center; align-items: center; gap: 20px; margin-top: 2rem; font-size: 0.9rem; flex-wrap: wrap; }
        .legend-item { display: flex; align-items: center; gap: 8px; cursor: pointer; transition: opacity 0.2s; }
        .legend-item.inactive {
            opacity: 0.4;
            text-decoration: line-through;
        }
        .legend-key { width: 15px; height: 15px; }
        .legend-key-line {
            width: 20px;
            height: 15px;
            border-top-width: 3px;
            border-top-style: solid;
        }
        .legend-key-line.dashed {
            border-top-style: dashed;
        }
        .legend-key-line.dotted {
            border-top-style: dotted;
        }

        .chart-no-data-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-color-light); font-size: 1.1rem; font-weight: 500;
            z-index: 20;
        }


        .table-controls-section { padding: 1.5rem; border-bottom: 1px solid var(--border-color); }
        .table-header { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: space-between; align-items: center; }
        .table-title-wrapper { display: flex; align-items: center; gap: 1rem; }
        .table-title-wrapper h1 { font-size: 1.25rem; font-weight: 600; }
        #refresh-table-btn .fa-sync-alt.spinning { transform: rotate(360deg); transition: transform 0.5s; }
        .header-controls { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .bulk-action-controls { display: flex; gap: 0.75rem; }
        .btn { padding: 0.6rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--surface-color); font-size: 0.9rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-color-dark); transition: all 0.2s; }
        .btn-primary { background-color: var(--primary-color); color: white; border-color: var(--primary-color); }
        .btn-primary:hover { background-color: #4338ca; }
        .bulk-status-btn .fa-check { color: var(--green); }
        .bulk-status-btn .fa-times { color: var(--red); }
        .bulk-status-btn:disabled { display: none; }
        
        .filter-tags-container {
            display: flex; flex-wrap: wrap; gap: 0.5rem;
            padding-top: 1rem;
        }
        .filter-tag {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.3rem 0.75rem; border-radius: 16px;
            font-size: 0.875rem; font-weight: 500;
        }
        .filter-tag-employee { background-color: #e0e7ff; color: #3730a3; }
        .filter-tag-corporate { background-color: #dbeafe; color: #1e40af; }
        .filter-tag-regional { background-color: #dcfce7; color: #166534; }
        .filter-tag-unit { background-color: #fee2e2; color: #991b1b; }
        .filter-tag-department { background-color: #fef3c7; color: #92400e; }
        .filter-tag-certification { background-color: #e5e5e5; color: #525252; }
        .filter-tag-trainerLevel { background-color: #fce7f3; color: #9d266b; }
        .remove-filter-tag { cursor: pointer; font-weight: bold; font-size: 1rem; transition: color 0.2s; }
        .remove-filter-tag:hover { color: var(--red); }

        .search-add-wrapper { position: relative; width: 350px; }
        .search-input-container .fa-magnifying-glass { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-color-light); }
        #employee-search-input { width: 100%; padding: 0.6rem 0.75rem 0.6rem 2.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s; }
        #employee-search-input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .search-results-container { position: absolute; top: calc(100% + 8px); left: 0; right: 0; background-color: var(--surface-color); border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 10; list-style: none; padding: 0; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s; display: flex; flex-direction: column; }
        .search-results-container.visible { opacity: 1; visibility: visible; transform: translateY(0); }
        #search-actions-container { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border-color); display: none; flex-direction: column; gap: 1rem; background-color: #f9fafb; }
        #search-actions-container.visible { display: flex; }
        .actions-bar { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        #selected-for-addition-preview { width: 100%; display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .selected-preview-tag { display: flex; align-items: center; gap: 0.5rem; background-color: #e0e7ff; color: var(--primary-color); padding: 0.25rem 0.6rem; border-radius: 16px; font-size: 0.8rem; font-weight: 500; }
        .remove-tag-btn { cursor: pointer; font-weight: bold; font-size: 1rem; line-height: 1; transition: color 0.2s; }
        .remove-tag-btn:hover { color: var(--red); }
        #search-results-list { max-height: 250px; overflow-y: auto; padding: 0.5rem; margin:0; }
        #search-results-list li { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem; cursor: pointer; border-radius: 6px; transition: background-color 0.15s; }
        #search-results-list li:hover { background-color: #f3f4f6; }
        .result-name { font-weight: 500; display: block; margin-bottom: 0.25rem; }
        .result-details { font-size: 0.8rem; color: var(--text-color-light); }
        .no-results { padding: 1rem; text-align: center; color: var(--text-color-light); }
        .select-all-container { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
        #bulk-add-btn { background-color: var(--primary-color); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        #bulk-add-btn:disabled { background-color: #a5b4fc; cursor: not-allowed; }

        /* --- Table --- */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th, td { padding: 1rem 1.5rem; text-align: left; vertical-align: middle; font-size: 0.875rem; }
        thead th { background-color: #f9fafb; color: var(--text-color-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); }
        
        tbody tr { border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease-in-out; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background-color: #f8fafc; }
        
        input[type="checkbox"] { width: 16px; height: 16px; border-radius: 4px; border: 1px solid #ccc; cursor: pointer; }

        .employee-cell { display: flex; align-items: center; gap: 1rem; }
        .avatar { width: 48px; height: 48px; border-radius: 50%; background-color: #e0e7ff; color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.1rem; flex-shrink: 0; }
        .employee-info .name { font-weight: 600; color: var(--text-color-dark); display: block; margin-bottom: 0.25rem; }
        .corporate-details { font-size: 0.8rem; color: var(--text-color-light); margin-top: 0.35rem; margin-bottom: 0.35rem; }
        .corporate-details span:not(:last-child)::after { content: '•'; margin: 0 0.5rem; color: var(--border-color); }
        .employee-details { margin-top: 0.5rem; font-size: 0.8rem; color: var(--text-color-light); display: flex; flex-wrap: wrap; gap: 0.25rem 1rem; }
        .employee-details span { display: flex; align-items: center; gap: 0.4rem; }
        .cell-stack { display: flex; flex-direction: column; gap: 0.4rem; }
        .cell-stack .label { font-weight: 600; }
        .cell-stack .sub-label { color: var(--text-color-light); display: flex; align-items: center; gap: 0.5rem; }
        
        .trainer-info-in-cell { margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--border-color); display:flex; flex-direction:column; gap: 0.4rem; }
        .trainer-qual { font-weight: 500; color: var(--text-color-dark); }
        .trainer-badges-wrapper { display: flex; justify-content: space-between; align-items: center; }
        .trainer-badges-left { display: flex; gap: 0.5rem; align-items: center; }

        .status-indicator { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; width: 110px; padding: 0.4rem 0.8rem; border-radius: 20px; font-weight: 500; color: white; cursor: pointer; transition: background-color 0.2s; }
        .status-indicator.status-active { background-color: var(--green); }
        .status-indicator.status-inactive { background-color: var(--red); }
        .status-indicator.status-neutral { background-color: var(--gray); }
        
        .action-cell { text-align: center; }
        .action-cell .icon { color: var(--text-color-light); font-size: 1.1rem; margin: 0 0.5rem; cursor: pointer; transition: transform 0.2s, color 0.2s; }
        .action-cell .icon:hover { transform: scale(1.2); color: var(--primary-color); }
        .action-cell .fa-trash-alt:hover { color: var(--red); }

        .table-pagination-footer { background-color: #f9fafb; padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; }
        .footer-left-controls { display: flex; align-items: center; gap: 1.5rem; }
        .pagination-info { color: var(--text-color-light); }
        .pagination-info b { color: var(--text-color-dark); }
        .rows-per-page-controls { display: flex; align-items: center; gap: 0.5rem; }
        .rows-per-page-controls label { color: var(--text-color-light); font-weight: 500; }
        .rows-per-page-controls select { border: 1px solid var(--border-color); border-radius: 6px; padding: 0.5rem; font-size: 0.9rem; background-color: white; }
        .pagination-controls { display: flex; gap: 0.5rem; }
        .page-btn { background-color: white; border: 1px solid var(--border-color); border-radius: 6px; padding: 0.5rem 1rem; cursor: pointer; transition: all 0.2s; color: var(--text-color-light); font-weight: 500; }
        .page-btn:hover:not(:disabled) { background-color: #f3f4f6; color: var(--text-color-dark); }
        .page-btn.active { background-color: var(--primary-color); border-color: var(--primary-color); color: white; z-index: 2; }
        .page-btn:disabled { background-color: #f9fafb; color: #d1d5db; cursor: not-allowed; }

        /* --- Filter Modal & Custom Dropdown Styles --- */
        .filter-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; display: none; align-items: center; justify-content: center; }
        .filter-modal-overlay.visible { display: flex; }
        .filter-modal { background-color: var(--surface-color); border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1); width: 90%; max-width: 960px; display: flex; flex-direction: column; }
        .filter-modal-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
        .filter-modal-header h2 { font-size: 1.125rem; font-weight: 600; color: var(--text-color-light); text-transform: uppercase; letter-spacing: 0.05em; }
        .close-filter-btn { background: none; border: none; font-size: 1.75rem; color: var(--text-color-light); cursor: pointer; line-height: 1; transition: color 0.2s; padding: 0; }
        .close-filter-btn:hover { color: var(--text-color-dark); }
        .filter-modal-body { padding: 1.5rem; max-height: 70vh; overflow-y: auto; }
        .filter-modal-footer { display: flex; justify-content: flex-end; gap: 0.75rem; padding: 1.25rem 1.5rem; border-top: 1px solid var(--border-color); background-color: #f9fafb; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; }
        #reset-employee-filters-btn { background-color: #e5e7eb; color: #374151; }
        #reset-employee-filters-btn:hover { background-color: #d1d5db; }
        
        .cascading-filter-container {
            display: flex;
            gap: 0;
            min-height: 350px;
        }
        .filter-column {
            flex: 1 1 25%;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--border-color);
        }
        .filter-column:last-child {
            border-right: none;
        }
        .filter-column-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .filter-column-body {
            padding: 0.5rem;
            overflow-y: auto;
            list-style: none;
            flex-grow: 1;
        }
        .filter-column.disabled .filter-column-header {
            color: var(--text-color-light);
        }
        .filter-column.disabled .filter-column-body {
            background-color: var(--background-color);
        }
        .filter-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
        }
        .filter-item:hover {
            background-color: #f3f4f6;
        }
        .filter-item input {
            cursor: pointer;
        }
        .filter-item label {
            cursor: pointer;
            flex-grow: 1;
        }
        .filter-item .context {
            font-size: 0.75rem;
            color: var(--text-color-light);
            margin-left: auto;
            white-space: nowrap;
        }

        #metrics-filter-modal .filter-modal-body {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .metrics-filter-group {
            display: grid;
            grid-template-columns: 1fr 20px 1fr;
            gap: 0.5rem 1rem;
            align-items: center;
        }
        .metrics-filter-group > label {
            grid-column: 1 / -1;
            margin-bottom: 0.25rem;
            font-weight: 600;
            color: var(--text-color-light);
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        #performance-level-filter-container {
            grid-column: 1 / -1;
        }
        .metrics-range-inputs {
            grid-column: 1 / -1;
            display: contents;
        }
        .metrics-range-inputs input {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.9rem;
        }
        .metrics-range-inputs span { text-align: center; }
        .input-with-adornment {
            position: relative;
        }
        .input-with-adornment input {
            padding-right: 2rem;
        }
        .input-with-adornment .input-adornment {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-color-light);
            pointer-events: none;
        }

        .custom-select-wrapper { position: relative; min-width: 180px; }
        .custom-select-trigger { display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0.75rem; border: 1px solid #ccc; border-radius: 6px; background-color: white; font-size: 0.9rem; cursor: pointer; user-select: none; }
        .custom-select-trigger .trigger-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .custom-select-trigger .fa-chevron-down { transition: transform 0.2s; }
        .custom-select-wrapper.open .custom-select-trigger .fa-chevron-down { transform: rotate(180deg); }
        .custom-select-options { position: absolute; top: calc(100% + 5px); left: 0; width: 100%; background-color: white; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1001; display: none; flex-direction: column; }
        .custom-select-wrapper.open .custom-select-options { display: flex; }
        .custom-select-search { padding: 0.75rem; border: none; border-bottom: 1px solid var(--border-color); outline: none; font-size: 0.9rem; }
        .custom-select-options ul { list-style: none; max-height: 200px; overflow-y: auto; padding: 0.5rem; margin: 0; }
        .custom-select-options li { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem; border-radius: 4px; cursor: pointer; }
        .custom-select-options li:hover { background-color: #f3f4f6; }
        .custom-select-options li.hidden { display: none; }
        .custom-select-options li label { font-weight: normal; cursor: pointer; flex-grow: 1; }
        
        
        
        
        
        
        
         .card {
            border-radius: var(--border-radius1);
            box-shadow: var(--box-shadow1);
            border: none;
            margin-bottom: 20px;
            transition: var(--transition1);
        }
        
        .card:hover {
            box-shadow: 0 10px 15px rgba(0,0,0,0.1), 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: var(--border-radius1) var(--border-radius1) 0 0 !important;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary-color1);
            margin-bottom: 0;
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: var(--transition1);
        }
        
        .btn .badge {
            position: relative;
            top: -1px;
        }
        
        .btn-primary1 {
            background-color: var(--primary-color-green);
            border-color: var(--primary-color-green);
            padding: 8px 20px;
        }
        
        .btn-primary1:hover {
            background-color: #148a0c;
            border-color: #148a0c;
            transform: translateY(-1px);
        }
        
        .btn-outline-secondary {
            border-color: var(--medium-gray1);
            color: var(--dark-gray1);
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--medium-gray1);
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
            color: var(--secondary-color1);
            background-color: var(--light-gray1);
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
            background-color: var(--primary-light1);
        }
        
        .badge {
            font-weight: 500;
            padding: 5px 10px;
            font-size: 0.85rem;
            border-radius: 4px;
        }
        
        .badge-primary {
            background-color: var(--primary-color-green);
        }
        
        .badge-secondary {
            background-color: var(--medium-gray1);
            color: var(--dark-gray1);
        }
        
        .badge-online {
            background-color: var(--accent-color1);
            color: white;
        }
        
        .badge-recorded {
            background-color: var(--info-color1);
            color: white;
        }

        .qrcode-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: white;
            padding: 5px;
            border: 1px solid var(--medium-gray1);
            border-radius: 4px;
            transition: var(--transition1);
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
            background-color: var(--primary-color-green);
            border-color: var(--primary-color-green);
        }
        
        .pagination .page-link {
            color: var(--primary-color-green);
            border-radius: 6px;
            margin: 0 3px;
            min-width: 38px;
            text-align: center;
        }
        
        .pagination .page-link:hover {
            background-color: var(--primary-light1);
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
            border-color: var(--primary-color-green);
            box-shadow: 0 0 0 0.25rem rgba(23, 160, 14, 0.25);
        }
        
        .bootstrap-select .dropdown-toggle {
            border-radius: 6px !important;
            padding: 8px 12px !important;
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
            color: var(--dark-gray1);
            border-radius: 4px;
            transition: var(--transition1);
        }
        
        .view-toggle-btn.active {
            background: var(--primary-color-green);
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
            background-color: var(--warning-color1);
        }
        
        .status-completed {
            background-color: var(--primary-color-green);
        }
        
        .status-ongoing {
            background-color: var(--accent-color1);
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

        .manage-participants-modal-body {
            --primary-color-green: #4f46e5;
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
        .manage-participants-modal-body .btn-primary1 { background-color: var(--primary-color-green); color: white; border-color: var(--primary-color-green); }
        .manage-participants-modal-body .btn-primary1:hover { background-color: #3f3da3; }
        .manage-participants-modal-body .btn-secondary { background-color: #f0f0f0; border: 1px solid #ddd; color: #555; }
        .manage-participants-modal-body .btn-secondary:hover { background-color: #e0e0e0; }
        .manage-participants-modal-body #add-new-employee-btn:hover, .manage-participants-modal-body #upload-file-btn:hover, .manage-participants-modal-body .bulk-status-btn:hover:not(:disabled) { background-color: #f3f4f6; border-color: var(--primary-color-green); }
        .manage-participants-modal-body .bulk-status-btn .fa-check { color: var(--green); }
        .manage-participants-modal-body .bulk-status-btn .fa-times { color: var(--red); }
        .manage-participants-modal-body .bulk-status-btn { display: none; } /* Hide by default, show with JS */
        
        .manage-participants-modal-body .search-add-wrapper { position: relative; width: 350px; }
        .manage-participants-modal-body .search-input-container .fa-magnifying-glass { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-color-light); }
        .manage-participants-modal-body #employee-search-input { width: 100%; padding: 0.6rem 0.75rem 0.6rem 2.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.9rem; transition: border-color 0.2s; }
        .manage-participants-modal-body #employee-search-input:focus { outline: none; border-color: var(--primary-color-green); box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .manage-participants-modal-body .search-results-container { position: absolute; top: calc(100% + 8px); left: 0; right: 0; background-color: var(--surface-color); border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 10; list-style: none; padding: 0; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s; display: flex; flex-direction: column; }
        .manage-participants-modal-body .search-results-container.visible { opacity: 1; visibility: visible; transform: translateY(0); }
        .manage-participants-modal-body #search-actions-container { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border-color); display: none; flex-direction: column; gap: 1rem; background-color: #f9fafb; }
        .manage-participants-modal-body #search-actions-container.visible { display: flex; }
        .manage-participants-modal-body .actions-bar { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .manage-participants-modal-body #selected-for-addition-preview { width: 100%; display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .manage-participants-modal-body .selected-preview-tag { display: flex; align-items: center; gap: 0.5rem; background-color: #e0e7ff; color: var(--primary-color-green); padding: 0.25rem 0.6rem; border-radius: 16px; font-size: 0.8rem; font-weight: 500; }
        .manage-participants-modal-body .remove-tag-btn { cursor: pointer; font-weight: bold; font-size: 1rem; line-height: 1; transition: color 0.2s; }
        .manage-participants-modal-body .remove-tag-btn:hover { color: var(--red); }
        .manage-participants-modal-body #search-results-list { max-height: 250px; overflow-y: auto; padding: 0.5rem; margin:0; }
        .manage-participants-modal-body #search-results-list li { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem; cursor: pointer; border-radius: 6px; transition: background-color 0.15s; }
        .manage-participants-modal-body #search-results-list li:hover { background-color: #f3f4f6; }
        .manage-participants-modal-body .result-name { font-weight: 500; display: block; margin-bottom: 0.25rem; }
        .manage-participants-modal-body .result-details { font-size: 0.8rem; color: var(--text-color-light); }
        .manage-participants-modal-body .no-results { padding: 1rem; text-align: center; color: var(--text-color-light); }
        .manage-participants-modal-body .select-all-container { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; }
        .manage-participants-modal-body #bulk-add-btn { background-color: var(--primary-color-green); color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .manage-participants-modal-body #bulk-add-btn:disabled { background-color: #a5b4fc; cursor: not-allowed; }
        .manage-participants-modal-body .table-wrapper { overflow-y: auto; flex-grow: 1; }
        .manage-participants-modal-body table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        .manage-participants-modal-body th, .manage-participants-modal-body td { padding: 1rem 1.5rem; text-align: left; vertical-align: middle; font-size: 0.875rem; }
        .manage-participants-modal-body thead th { background-color: #f9fafb; color: var(--text-color-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 5; }
        .manage-participants-modal-body tbody tr { border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease-in-out; }
        .manage-participants-modal-body tbody tr:last-child { border-bottom: none; }
        .manage-participants-modal-body tbody tr:hover { background-color: #f8fafc; }
        .manage-participants-modal-body input[type="checkbox"] { width: 16px; height: 16px; border-radius: 4px; border: 1px solid #ccc; cursor: pointer; }
        .manage-participants-modal-body .employee-cell { display: flex; align-items: center; gap: 1rem; }
        .manage-participants-modal-body .avatar { width: 48px; height: 48px; border-radius: 50%; background-color: #e0e7ff; color: var(--primary-color-green); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.1rem; flex-shrink: 0; }
        .manage-participants-modal-body .employee-info .name { font-weight: 600; color: var(--text-color-dark); display: block; margin-bottom: 0.25rem; }
        .manage-participants-modal-body .corporate-details { font-size: 0.8rem; color: var(--text-color-light); margin-top: 0.35rem; margin-bottom: 0.35rem; }
        .manage-participants-modal-body .corporate-details span:not(:last-child)::after { content: '•'; margin: 0 0.5rem; color: var(--border-color); }
        .manage-participants-modal-body .employee-details { margin-top: 0.5rem; font-size: 0.8rem; color: var(--text-color-light); display: flex; flex-wrap: wrap; gap: 0.25rem 1rem; }
        .manage-participants-modal-body .employee-details span { display: flex; align-items: center; gap: 0.4rem; }
        .manage-participants-modal-body .cell-stack > div { margin-bottom: 0.25rem; }
        .manage-participants-modal-body .cell-stack .label { font-weight: 600; }
        .manage-participants-modal-body .cell-stack .sub-label { color: var(--text-color-light); display: flex; align-items: center; gap: 0.5rem; }
        
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
        .manage-participants-modal-body .form-header { background-color: var(--primary-color-green); color: #ffffff; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .manage-participants-modal-body .form-header h2 { margin: 0; font-size: 1.25rem; font-weight: 500; }
        .manage-participants-modal-body .close-btn { background: none; border: none; color: #ffffff; font-size: 1.5rem; font-weight: bold; cursor: pointer; line-height: 1; }
        .manage-participants-modal-body .form-body { padding: 20px 30px; overflow-y: auto; }
        .manage-participants-modal-body .form-section { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #e7e7e7; }
        .manage-participants-modal-body .form-section:last-of-type { border-bottom: none; margin-bottom: 0; }
        .manage-participants-modal-body .form-section h3 { font-size: 1rem; color: var(--primary-color-green); margin: 0 0 20px 0; font-weight: 500; display: flex; align-items: center; }
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
         #pdf-review-section .imported-info span[contenteditable="true"]:focus { background-color: #fff; outline: 2px solid var(--primary-color-green); box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .suggestions-container { background-color: #f8fafc; border-radius: 6px; padding: 0.75rem; }
        .suggestions-container h6 { font-size: 0.8rem; font-weight: 600; color: var(--text-color-light); text-transform: uppercase; margin-bottom: 0.5rem; }
        .suggestion-link { display: block; padding: 0.5rem 0.75rem; border-radius: 4px; color: var(--accent-color1); text-decoration: none; margin-bottom: 4px; background-color: #fff; border: 1px solid #e9ecef; cursor: pointer; transition: all 0.2s ease; font-size: 0.85rem; }
        .suggestion-link:hover { background-color: var(--primary-light1); color: var(--primary-color-green); border-color: var(--primary-color-green); transform: translateX(3px); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .suggestion-link .badge { font-size: 0.7em; }
        .no-suggestions { color: var(--text-color-light); font-style: italic; padding: 0.5rem; }
        .action-cell { text-align: center; display: flex; gap: 5px; justify-content: flex-start; align-items: center; padding-top: 1rem !important; }
        .popover-header { background-color: var(--secondary-color1); color: white; font-weight: 600; }
        .popover-body { font-size: 0.85rem; }
  
        .table th .header-content { display: flex; justify-content: space-between; align-items: center; gap: 8px; }
        .filter-icon { cursor: pointer; transition: color 0.2s; font-size: 0.8em; }
        .filter-icon:hover { color: var(--primary-color-green) !important; }
        .th-filter-dropdown { width: 280px; box-shadow: 0 5px 15px rgba(0,0,0,0.15); border: 1px solid #ddd; z-index: 1050; }
        .th-filter-dropdown-wide { width: 450px; max-width: 450px; }
        .th-filter-dropdown .form-check-label { font-weight: 400; color: #333; font-size: 0.9rem; }
        .th-filter-dropdown .filter-options, .th-filter-dropdown .filter-options-main, .th-filter-dropdown .filter-options-sub { max-height: 150px; overflow-y: auto; padding-right: 5px; }
        .th-filter-dropdown .filter-options .form-check, .th-filter-dropdown .filter-options-main .form-check, .th-filter-dropdown .filter-options-sub .form-check { padding-left: 1.7em; margin-bottom: 0.5rem; }
        .th-filter-dropdown .form-control-sm { font-size: 0.85rem; }
        .table th { position: relative; }
        .filter-active { color: var(--primary-color-green) !important; font-weight: bold; }
        
    
        li a {
          text-decoration: none;
          color: inherit; /* Optional: to inherit text color */
        }
        .nav-container {
        margin-top:1px;
        }
        .modal-backdrop{position:relative !important;}
        .tab-pane li::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 10px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            /* background-color: var(--primary-color); */
        }
        
        .tab-pane .pagination li::before {
            content: none !important;
        }
        
        
    /*      .select2-container {*/
    /*    width: 100% !important;*/
    /*    z-index: 999999 !important;*/
    /*    position: relative !important;*/
    /*}*/

    /*.select2-dropdown {*/
    /*    z-index: 999999 !important;*/
    /*}*/

    /*.select2-container--default .select2-selection--single {*/
    /*    height: 38px;*/
    /*    padding: 6px 12px;*/
    /*    border: 1px solid #ced4da;*/
    /*    border-radius: 4px;*/
    /*    box-sizing: border-box;*/
    /*}*/

    /*.select2-search__field {*/
    /*    z-index: 999999 !important;*/
    /*    position: relative !important;*/
    /*    background: #fff !important;*/
    /*}*/

</style>
<!--@include('training.rolewise_mapping.style')-->

        <ul class="tab-nav" role="tablist" id="mainTabNav">
            <li><button class="tab-button active" data-tab-target="#dashboard" role="tab" aria-selected="true" aria-controls="dashboard"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></button></li>
            <li>
                <button class="tab-button" data-tab-target="#topic" role="tab" aria-selected="false" aria-controls="topic">
                    <i class="fas fa-book-open"></i> <span>Topics</span>
                </button>
            </li>
            <li><button class="tab-button" data-tab-target="#trainer" role="tab" aria-selected="false" aria-controls="trainer"><i class="fas fa-chalkboard-teacher"></i> <span>Trainers</span></button></li>
            <li><button class="tab-button" data-tab-target="#tni" role="tab" aria-selected="false" aria-controls="tni"><i class="fas fa-tasks"></i> <span>TNI Mapping</span></button></li>
            <li><button class="tab-button" data-tab-target="#competency" role="tab" aria-selected="false" aria-controls="competency"><i class="fas fa-sitemap"></i> <span>Competency</span></button></li>
            <li><button class="tab-button" data-tab-target="#data" role="tab" aria-selected="false" aria-controls="data"><i class="fas fa-database"></i> <span>Data</span></button></li>
            <li><button class="tab-button" data-tab-target="#calendar" role="tab" aria-selected="false" aria-controls="calendar"><i class="fas fa-calendar-alt"></i> <span>Calendar</span></button></li>
        </ul>

<button class="mobile-tab-toggle" id="mobileTabToggle" aria-label="Toggle tabs"><i class="fas fa-bars"></i></button>

    <div class="tab-content">
        <div id="dashboard" class="tab-pane" role="tabpanel" aria-labelledby="dashboard-tab">
            <h2><i class="fas fa-tachometer-alt"></i> Training Dashboard</h2>
            <p>Welcome to the Training Dashboard! Here you'll find an overview of training activities, progress, and key performance indicators.</p>
            <ul><li>Upcoming Trainings</li><li>Completion Rates</li><li>Overall Engagement</li></ul>
            <p><em>More charts and summaries would go here.</em></p>
        </div>
        <div id="topic" class="tab-pane" role="tabpanel" aria-labelledby="topic-tab">
        </div>
        <div id="trainer" class="tab-pane" role="tabpanel" aria-labelledby="trainer-tab">
       
        </div>
        <div id="tni" class="tab-pane" role="tabpanel" aria-labelledby="tni-tab">
            @include('training.rolewise_mapping.content')
        </div>
        <div id="competency" class="tab-pane" role="tabpanel" aria-labelledby="competency-tab">
            <h2><i class="fas fa-sitemap"></i> Competency Matrix</h2>
            <p>Visualize the skills and competencies across your organization. Identify skill gaps and plan training accordingly.</p>
            <p><em>A matrix-style display (e.g., table with roles vs. competencies) would be effective here.</em></p>
        </div>
        <div id="data" class="tab-pane" role="tabpanel" aria-labelledby="data-tab">
         <h1>Data</h1>
        </div>
        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
            <h2><i class="fas fa-calendar-alt" style="color:green"></i> Training Calendar</h2>
            <p>View the schedule of all upcoming and past training sessions. Filter by topic, trainer, or date.</p>
            <p><em>Consider integrating a JavaScript calendar library for a rich interactive experience.</em></p>
            
                 @include('training.calendar.content')
        </div>
    </div>
@endsection
@section('footerscript')
@include('training.calendar.script')
@include('training.trainer.script')
@include('training.topiclist.script')
@include('training.rolewise_mapping.script')
<script>
    function updateStickyColumns() {
        const firstCol = document.querySelector('.sticky-col-1');
        const secondCol = document.querySelector('.sticky-col-2');

        if (!firstCol || !secondCol) return;

        const firstColWidth = firstCol.offsetWidth;
        const secondColWidth = secondCol.offsetWidth;

        const allSecondCols = document.querySelectorAll('.sticky-col-2');
        const allThirdCols = document.querySelectorAll('.sticky-col-3');

        allSecondCols.forEach(cell => {
            cell.style.left = `${firstColWidth}px`;
        });

        allThirdCols.forEach(cell => {
            cell.style.left = `${firstColWidth + secondColWidth}px`;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateStickyColumns();

        // Resize handler
        window.addEventListener('resize', updateStickyColumns);

        // Tab System Fix (inject this into your existing tab button click)
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');
        const mobileTabToggle = document.getElementById('mobileTabToggle');
        const tabNav = document.getElementById('mainTabNav');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetPaneId = button.dataset.tabTarget;

                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
                tabPanes.forEach(pane => pane.classList.remove('active'));

                button.classList.add('active');
                button.setAttribute('aria-selected', 'true');

                const targetPane = document.querySelector(targetPaneId);
                if (targetPane) targetPane.classList.add('active');

                if (tabNav?.classList.contains('active')) {
                    tabNav.classList.remove('active');
                }

                // ⬇ Re-run column stickiness after tab changeSafety
                setTimeout(updateStickyColumns, 50); // Delay ensures DOM visibility
            });
        });

        // Mobile toggle
        if (mobileTabToggle) {
            mobileTabToggle.addEventListener('click', () => {
                tabNav.classList.toggle('active');
            });
        }

        // Close mobile tab menu when clicked outside
        document.addEventListener('click', e => {
            if (tabNav?.classList.contains('active') &&
                !tabNav.contains(e.target) &&
                !mobileTabToggle.contains(e.target)) {
                tabNav.classList.remove('active');
            }
        });
    });
</script>


<script>
    // Main Tab Navigation Script
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');
        const mobileTabToggle = document.getElementById('mobileTabToggle');
        const tabNav = document.getElementById('mainTabNav');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetPaneId = button.dataset.tabTarget;

                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
                tabPanes.forEach(pane => pane.classList.remove('active'));

                button.classList.add('active');
                button.setAttribute('aria-selected', 'true');
                const targetPane = document.querySelector(targetPaneId);
                if (targetPane) targetPane.classList.add('active');

                if (tabNav.classList.contains('active')) {
                    tabNav.classList.remove('active');
                }
            });
        });

        if (mobileTabToggle) {
            mobileTabToggle.addEventListener('click', () => tabNav.classList.toggle('active'));
        }

        document.addEventListener('click', e => {
            if (tabNav.classList.contains('active') && !tabNav.contains(e.target) && mobileTabToggle && !mobileTabToggle.contains(e.target)) {
                tabNav.classList.remove('active');
            }
        });
    });
</script>

<script>
// Script for Data Tab
document.addEventListener('DOMContentLoaded', function() {
    const dataTabContent = document.querySelector('#data main');
    if (!dataTabContent) {
        return;
    }

    const employeesData = [
        {
            id: "151-002246", name: "Mr. Ganesh Yadav", role: "Guest Service Supervisor", department: "Front Office", location: "Rambagh Palace", joinedDate: "2023-07-01", employeeStatus: "Active", staffCategory: "Permanent", foodHandlersCategory: "Non-Food Handler", corporate: "Corporate Alpha", regional: "North Region (Alpha)", unit: "Rambagh Palace Unit",
            trainingModules: [
                { title: "FoSTaC Certificate", fullTitle: "Food Safety Training and Certification", status: "Not Attended", scheduledDate: "2024-09-15", attendedDate: null, icon: "fas fa-certificate", shouldRating: 5, actualRating: null },
                { title: "Diversey (Existing)", fullTitle: "Diversey Training for Existing Employees", status: "Attended", scheduledDate: "2023-08-15", attendedDate: "2023-08-21", hours: "1:0:0", sessions: 1, icon: "fas fa-chalkboard-teacher", shouldRating: 5, actualRating: 4 }
            ]
        },
        {
            id: "151-002247", name: "Ms. Priya Sharma", role: "Housekeeping Attendant", department: "Housekeeping", location: "Rambagh Palace", joinedDate: "2022-05-15", employeeStatus: "Active", staffCategory: "Contractual", foodHandlersCategory: "Category B (General)", corporate: "Corporate Alpha", regional: "North Region (Alpha)", unit: "Rambagh Palace Unit",
            trainingModules: [
                { title: "FoSTaC Certificate", fullTitle: "Food Safety Training and Certification", status: "Attended", scheduledDate: "2023-01-01", attendedDate: "2023-01-10", hours: "8:0:0", sessions: 1, icon: "fas fa-certificate", shouldRating: 5, actualRating: 5 },
                { title: "Fire Safety Drill", fullTitle: "Annual Fire Safety Drill", status: "Attended", scheduledDate: "2024-05-20", attendedDate: "2024-06-01", hours: "2:0:0", sessions: 1, icon: "fas fa-fire-extinguisher", shouldRating: 5, actualRating: 4 },
                { title: "Customer Service Excellence", fullTitle: "Customer Service Excellence Program", status: "Not Attended", scheduledDate: "2024-10-01", attendedDate: null, icon: "fas fa-concierge-bell", shouldRating: 5, actualRating: null }
            ]
        },
        {
            id: "151-002248", name: "Mr. Arjun Singh", role: "Commis Chef", department: "Kitchen", location: "City Palace", joinedDate: "2024-01-20", employeeStatus: "Active", staffCategory: "Permanent", foodHandlersCategory: "Category A (High Risk)", corporate: "Corporate Beta", regional: "South Region (Beta)", unit: "City Palace Unit",
            trainingModules: [
                { title: "Basic Food Hygiene", fullTitle: "Basic Food Hygiene and Handling", status: "Attended", scheduledDate: "2024-02-10", attendedDate: "2024-02-15", icon: "fas fa-utensils", shouldRating: 5, actualRating: 5},
                { title: "Advanced Culinary Techniques", fullTitle: "Advanced Culinary Techniques Workshop", status: "Not Attended", scheduledDate: "2024-11-05", attendedDate: null, icon: "fas fa-hat-chef", shouldRating: 5, actualRating: null }
            ]
        },
        {
            id: "151-002249", name: "Ms. Ananya Reddy", role: "Front Desk Agent", department: "Front Office", location: "Rambagh Palace", joinedDate: "2023-11-05", employeeStatus: "Inactive", staffCategory: "Permanent", foodHandlersCategory: "Non-Food Handler", corporate: "Corporate Alpha", regional: "North Region (Alpha)", unit: "Rambagh Palace Unit",
            trainingModules: [
                { title: "Diversey (New)", fullTitle: "Diversey Training for New Employees", status: "Attended", scheduledDate: "2023-11-20", attendedDate: "2023-12-01", hours: "1:0:0", sessions: 1, icon: "fas fa-chalkboard-teacher", shouldRating: 5, actualRating: 3 }
            ]
        },
        {
            id: "151-002250", name: "Mr. Rohan Mehta", role: "Sous Chef", department: "Kitchen", location: "City Palace", joinedDate: "2021-03-10", employeeStatus: "Active", staffCategory: "Permanent", foodHandlersCategory: "Category A (High Risk)", corporate: "Corporate Beta", regional: "South Region (Beta)", unit: "City Palace Unit",
            trainingModules: [
                { title: "FoSTaC Certificate", fullTitle: "Food Safety Training and Certification", status: "Attended", scheduledDate: "2022-03-20", attendedDate: "2022-04-01", hours: "8:0:0", sessions: 1, icon: "fas fa-certificate", shouldRating: 5, actualRating: 5 },
                { title: "Customer Service Excellence", fullTitle: "Customer Service Excellence Program", status: "Attended", scheduledDate: "2023-05-01", attendedDate: "2023-05-15", hours: "4:0:0", sessions: 1, icon: "fas fa-concierge-bell", shouldRating: 5, actualRating: 4 }
            ]
        }
    ];

    const employeeListContainer = dataTabContent.querySelector('#employeeListContainer');
    const refreshFiltersBtn = dataTabContent.querySelector('#refreshFiltersBtn');

    const employeeDetailsFilterTriggerBtn = dataTabContent.querySelector('#employeeDetailsFilterTriggerBtn');
    const trainingTopicFilterTriggerBtn = dataTabContent.querySelector('#trainingTopicFilterTriggerBtn');
    const employeeDetailsPopupOverlay = dataTabContent.querySelector('#employeeDetailsPopupOverlay');
    const trainingTopicPopupOverlay = dataTabContent.querySelector('#trainingTopicPopupOverlay');
    const trainingStatusPopupSelect = dataTabContent.querySelector('#trainingStatusPopupSelect');
    const actualRatingPopupSelect = dataTabContent.querySelector('#actualRatingPopupSelect');

    let trainingPeriodDatePicker, joiningPeriodDatePicker;
    const customDropdowns = {};

    let lastFocusedElement = null;

    class CustomSearchableDropdown {
        constructor(containerElement, placeholderText, dataKey, onSelectionChangeCallback = null) {
            this.container = containerElement;
            this.displayElement = containerElement.querySelector('.custom-dropdown-display');
            this.optionsContainer = containerElement.querySelector('.custom-dropdown-options');
            this.searchInput = containerElement.querySelector('.custom-dropdown-search-input');
            this.listElement = containerElement.querySelector('ul');
            this.hiddenInput = containerElement.querySelector('input[type="hidden"]');
            this.placeholderText = placeholderText;
            this.dataKey = dataKey;
            this.onSelectionChange = onSelectionChangeCallback;
            this.options = []; this.selectedValue = ""; this.selectedText = placeholderText; this.init();
        }
        init() {
            this.displayElement.textContent = this.placeholderText;
            this.displayElement.addEventListener('click', () => this.toggleOptions());
            this.displayElement.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.toggleOptions();
                }
            });
            this.searchInput.addEventListener('input', () => this.filterOptions());
            this.searchInput.addEventListener('click', (e) => e.stopPropagation());
            document.addEventListener('click', (e) => { // Global click listener, make sure it works with other dropdowns
                if (!this.container.contains(e.target) && this.optionsContainer.classList.contains('show')) {
                    this.hideOptions();
                }
            });
            this.container.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.optionsContainer.classList.contains('show')) {
                    this.hideOptions();
                    this.displayElement.focus();
                }
            });
        }
        toggleOptions() {
            const isOpen = this.optionsContainer.classList.contains('show');
            // Close other open dropdowns specific to this tab
            dataTabContent.querySelectorAll('.custom-dropdown-options.show').forEach(openDropdown => {
                if (openDropdown !== this.optionsContainer) {
                    openDropdown.classList.remove('show');
                    const otherDisplay = openDropdown.closest('.custom-dropdown-container').querySelector('.custom-dropdown-display');
                    if (otherDisplay) otherDisplay.setAttribute('aria-expanded', 'false');
                }
            });
            this.optionsContainer.classList.toggle('show');
            this.displayElement.setAttribute('aria-expanded', this.optionsContainer.classList.contains('show'));
            if (this.optionsContainer.classList.contains('show')) {
                this.searchInput.focus();
                this.filterOptions();
            }
        }
        hideOptions() {
            this.optionsContainer.classList.remove('show');
            this.displayElement.setAttribute('aria-expanded', 'false');
        }
        populateOptions(newOptions, selectedValue = this.selectedValue) {
            this.options = newOptions.sort((a,b) => (a.text || a).localeCompare(b.text || b));
            this.selectedValue = selectedValue;
            this.selectedText = this.placeholderText;
            const selectedOpt = this.options.find(opt => (opt.value !== undefined ? opt.value : opt) === selectedValue);
            if (selectedOpt) { this.selectedText = selectedOpt.text || selectedOpt; }
            this.displayElement.textContent = this.selectedText;
            this.hiddenInput.value = this.selectedValue;
            this.filterOptions();
        }
        filterOptions() {
            const searchTerm = this.searchInput.value.toLowerCase();
            this.listElement.innerHTML = '';
            const filtered = this.options.filter(option => {
                const optionText = (option.text || option).toLowerCase();
                return optionText.includes(searchTerm);
            });
            if (filtered.length === 0) {
                this.listElement.innerHTML = '<li class="no-results" role="option">No results found</li>';
                return;
            }
            filtered.forEach(optionData => {
                const li = document.createElement('li');
                const value = optionData.value !== undefined ? optionData.value : optionData;
                const text = optionData.text || optionData;
                li.textContent = text;
                li.dataset.value = value;
                li.setAttribute('role', 'option');
                li.setAttribute('tabindex', '-1');
                if (value === this.selectedValue) {
                    li.classList.add('selected');
                    li.setAttribute('aria-selected', 'true');
                }
                li.addEventListener('click', () => this.selectOption(value, text));
                li.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        this.selectOption(value, text);
                    }
                });
                this.listElement.appendChild(li);
            });
        }
        selectOption(value, text) {
            this.selectedValue = value; this.selectedText = text;
            this.hiddenInput.value = value;
            this.displayElement.textContent = text;
            this.hideOptions();
            this.searchInput.value = '';
            this.displayElement.focus();
            if (this.onSelectionChange) { this.onSelectionChange(); }
        }
        getValue() { return this.hiddenInput.value; }
        clear() { this.selectOption("", this.placeholderText); }
    }

    class DatePicker {
        constructor(triggerEl, popupEl, onDateChangeCallback) {
            this.triggerEl = triggerEl; this.popupEl = popupEl;
            this.popupFromDateEl = popupEl.querySelector('.popup-from-date');
            this.popupToDateEl = popupEl.querySelector('.popup-to-date');
            this.applyBtnEl = popupEl.querySelector('.action-apply-dates');
            this.clearBtnEl = popupEl.querySelector('.action-clear-dates');
            this.onDateChangeCallback = onDateChangeCallback;
            this.selectedStartDate = null; this.selectedEndDate = null;
            this.init();
        }
        init() {
            this.triggerEl.addEventListener('click', (e) => { e.stopPropagation(); this.togglePopup(); });
            this.triggerEl.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.togglePopup();
                }
            });
            if (this.applyBtnEl) this.applyBtnEl.addEventListener('click', () => this.applyDates());
            if (this.clearBtnEl) this.clearBtnEl.addEventListener('click', () => this.clearDates());
            this.popupFromDateEl.addEventListener('input', (e) => this._formatDateInputOnTheFly(e));
            this.popupToDateEl.addEventListener('input', (e) => this._formatDateInputOnTheFly(e));
            document.addEventListener('click', (e) => { // Global click listener, ensure it doesn't conflict
                if (this.popupEl.style.display === 'block' && !this.popupEl.contains(e.target) && e.target !== this.triggerEl) this.hidePopup();
            });
             this.popupEl.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    this.hidePopup();
                    this.triggerEl.focus();
                }
            });
        }
        _formatDateInputOnTheFly(event) {
            const input = event.target;
            let value = input.value.replace(/\D/g, '').substring(0, 8);
            let formattedValue = '';
            if (value.length > 4) { formattedValue = `${value.substring(0, 2)}-${value.substring(2, 4)}-${value.substring(4)}`; }
            else if (value.length > 2) { formattedValue = `${value.substring(0, 2)}-${value.substring(2)}`; }
            else { formattedValue = value; }
            input.value = formattedValue;
        }
        togglePopup() {
            const isVisible = this.popupEl.style.display === 'block';
            // Close other date pickers specific to this tab
            dataTabContent.querySelectorAll('.custom-datepicker-popup').forEach(p => {
                if (p !== this.popupEl && p.style.display === 'block') p.style.display = 'none';
            });
            this.popupEl.style.display = isVisible ? 'none' : 'block';
            if (!isVisible) {
                this.popupFromDateEl.value = this.selectedStartDate ? this.formatToDDMMYYYY(this.selectedStartDate) : '';
                this.popupToDateEl.value = this.selectedEndDate ? this.formatToDDMMYYYY(this.selectedEndDate) : '';
                this.popupFromDateEl.focus();
            }
        }
        hidePopup() { this.popupEl.style.display = 'none'; }
        parseInputDate(dateString) {
            if (!dateString) return null; const parts = dateString.match(/^(\d{2})-(\d{2})-(\d{4})$/); if (parts) { const d = parseInt(parts[1],10), m = parseInt(parts[2],10)-1, y = parseInt(parts[3],10); const date = new Date(y,m,d); if(date.getFullYear()===y && date.getMonth()===m && date.getDate()===d) return date; } return null;
        }
        formatToDDMMYYYY(date) {
            if (!date) return ''; const d = String(date.getDate()).padStart(2,'0'), m = String(date.getMonth()+1).padStart(2,'0'), y = date.getFullYear(); return `${d}-${m}-${y}`;
        }
        applyDates() {
            const from = this.parseInputDate(this.popupFromDateEl.value), to = this.parseInputDate(this.popupToDateEl.value); const today = new Date(); today.setHours(0,0,0,0); if (this.popupFromDateEl.value && !from) { alert("Invalid 'From' date. Please use DD-MM-YYYY format."); this.popupFromDateEl.focus(); return; } if (this.popupToDateEl.value && !to) { alert("Invalid 'To' date. Please use DD-MM-YYYY format."); this.popupToDateEl.focus(); return; } if (from && from > today) { alert("'From' date cannot be in the future."); this.popupFromDateEl.focus(); return; } if (to && to > today) { alert("'To' date cannot be in the future."); this.popupToDateEl.focus(); return; } if (from && to && from > to) { alert("'From' date cannot be after 'To' date."); return; } this.selectedStartDate = from; this.selectedEndDate = to; this.updateTriggerInput(); this.hidePopup(); this.triggerEl.focus(); if (this.onDateChangeCallback) this.onDateChangeCallback();
        }
        clearDates() {
            this.selectedStartDate = null; this.selectedEndDate = null;
            this.popupFromDateEl.value = ''; this.popupToDateEl.value = '';
            this.updateTriggerInput();
            if (this.onDateChangeCallback) this.onDateChangeCallback();
        }
        updateTriggerInput() {
            if (this.selectedStartDate && this.selectedEndDate) this.triggerEl.value = `${this.formatToDDMMYYYY(this.selectedStartDate)} - ${this.formatToDDMMYYYY(this.selectedEndDate)}`; else if (this.selectedStartDate) this.triggerEl.value = `From ${this.formatToDDMMYYYY(this.selectedStartDate)}`; else if (this.selectedEndDate) this.triggerEl.value = `Up to ${this.formatToDDMMYYYY(this.selectedEndDate)}`; else this.triggerEl.value = '';
        }
        getDates() { return { start: this.selectedStartDate, end: this.selectedEndDate }; }
    }

    dataTabContent.querySelectorAll('.custom-dropdown-container').forEach(container => {
        const key = container.dataset.filterKey;
        if (key) {
            customDropdowns[key] = new CustomSearchableDropdown(
                container,
                container.querySelector('.custom-dropdown-display').textContent.trim(),
                key,
                applyFilters
            );
        }
    });

    if (dataTabContent.querySelector('#trainingPeriodTrigger') && dataTabContent.querySelector('#trainingPeriodPicker')) {
        trainingPeriodDatePicker = new DatePicker(dataTabContent.querySelector('#trainingPeriodTrigger'), dataTabContent.querySelector('#trainingPeriodPicker'), applyFilters);
    }
    if (dataTabContent.querySelector('#joiningPeriodTrigger') && dataTabContent.querySelector('#joiningPeriodPicker')) {
        joiningPeriodDatePicker = new DatePicker(dataTabContent.querySelector('#joiningPeriodTrigger'), dataTabContent.querySelector('#joiningPeriodPicker'), applyFilters);
    }


    function populateAllFilters() {
        const currentValues = getCurrentFilterValues();

        const uniqueValues = (key) => [...new Set(employeesData.map(e => e[key]).filter(Boolean))];
        const employeeNameOptions = employeesData.map(e => ({ value: e.id, text: `${e.id} - ${e.name}` }));
        const allTrainingTopics = [...new Set(employeesData.flatMap(emp => emp.trainingModules.map(mod => mod.title)))];

        const filterConfigs = {
            corporate: uniqueValues('corporate'),
            regional: uniqueValues('regional'),
            unit: uniqueValues('unit'),
            departmentPopup: uniqueValues('department'),
            staffCategoryPopup: uniqueValues('staffCategory'),
            foodHandlersCategoryPopup: uniqueValues('foodHandlersCategory'),
            employeeStatusPopup: uniqueValues('employeeStatus'),
            employeeNamePopup: employeeNameOptions,
            trainingTopicPopup: allTrainingTopics
        };

        for (const key in filterConfigs) {
            if (customDropdowns[key]) {
                customDropdowns[key].populateOptions(filterConfigs[key], currentValues[key.replace('Popup', '')]);
            }
        }
        if(trainingStatusPopupSelect) trainingStatusPopupSelect.value = currentValues.trainingStatus || "";
        if(actualRatingPopupSelect) actualRatingPopupSelect.value = currentValues.actualRating || "";
    }

    function applyFilters() {
        const filters = getCurrentFilterValues();
        let filteredEmployees = [...employeesData];

        ['corporate', 'regional', 'unit', 'department', 'staffCategory', 'foodHandlersCategory', 'employeeStatus'].forEach(key => {
            if (filters[key]) {
                filteredEmployees = filteredEmployees.filter(emp => emp[key] === filters[key]);
            }
        });
        if (filters.employeeName) {
            filteredEmployees = filteredEmployees.filter(emp => emp.id === filters.employeeName);
        }

        if (filters.joiningStart) {
            filteredEmployees = filteredEmployees.filter(emp => new Date(emp.joinedDate) >= filters.joiningStart);
        }
        if (filters.joiningEnd) {
            const endJoining = new Date(filters.joiningEnd);
            endJoining.setHours(23, 59, 59, 999);
            filteredEmployees = filteredEmployees.filter(emp => new Date(emp.joinedDate) <= endJoining);
        }

        if (filters.trainingTopic || filters.trainingStatus || filters.actualRating) {
            filteredEmployees = filteredEmployees.filter(emp => {
                return emp.trainingModules.some(mod => {
                    const topicMatch = filters.trainingTopic ? mod.title === filters.trainingTopic : true;
                    const statusMatch = filters.trainingStatus ? mod.status === filters.trainingStatus : true;
                    const ratingMatch = filters.actualRating ? (mod.actualRating != null && mod.actualRating == filters.actualRating) : true;
                    return topicMatch && statusMatch && ratingMatch;
                });
            });
        }

        const employeesToRender = filteredEmployees.map(emp => {
            const newModules = emp.trainingModules.map(mod => {
                let currentDisplayStatus = mod.status;
                const attendedDate = mod.attendedDate ? new Date(mod.attendedDate) : null;

                if (mod.status === "Attended" && attendedDate) {
                    if (filters.trainingStart || filters.trainingEnd) {
                        let isWithinDisplayPeriod = true;
                        if (filters.trainingStart && attendedDate < filters.trainingStart) {
                            isWithinDisplayPeriod = false;
                        }
                        if (filters.trainingEnd) {
                            const endTrainingPeriod = new Date(filters.trainingEnd);
                            endTrainingPeriod.setHours(23, 59, 59, 999);
                            if (attendedDate > endTrainingPeriod) {
                                isWithinDisplayPeriod = false;
                            }
                        }
                        currentDisplayStatus = isWithinDisplayPeriod ? "Attended" : "Not Attended";
                    }
                } else if (mod.status === "Not Attended") {
                     currentDisplayStatus = "Not Attended";
                }
                return { ...mod, displayStatus: currentDisplayStatus };
            });
            return { ...emp, trainingModules: newModules };
        });

        renderEmployeeList(employeesToRender);
    }

    function addModuleRatingChangeListeners() {
        dataTabContent.querySelectorAll('.module-actual-rating-select').forEach(select => {
            select.addEventListener('change', function(event) {
                const employeeId = event.target.dataset.employeeId;
                const moduleTitle = event.target.dataset.moduleTitle;
                const newActualRating = event.target.value;

                const empToUpdate = employeesData.find(e => e.id === employeeId);
                if (empToUpdate) {
                    const modToUpdate = empToUpdate.trainingModules.find(m => m.title === moduleTitle);
                    if (modToUpdate) {
                        modToUpdate.actualRating = newActualRating ? parseInt(newActualRating) : null;
                    }
                }
            });
        });
    }

    function renderEmployeeList(employeesToRender) {
        if (!employeeListContainer) return;
        employeeListContainer.innerHTML = '';
        if (employeesToRender.length === 0) {
            employeeListContainer.innerHTML = '<p style="text-align:center; color: var(--tracker-text-muted); padding: 20px;">No employees match the current filter criteria.</p>';
            return;
        }
        employeesToRender.forEach(emp => {
            const card = document.createElement('article');
            card.className = 'employee-card';
            card.setAttribute('aria-labelledby', `emp-name-${emp.id}`);

            const modulesHTML = emp.trainingModules.map(mod => {
                let ratingsHTML = '';
                if (mod.shouldRating !== undefined) {
                    let actualOptionsHTML = `<option value="" ${mod.actualRating == null ? 'selected' : ''}>N/A</option>`;
                    for (let i = 1; i <= 5; i++) {
                        actualOptionsHTML += `<option value="${i}" ${mod.actualRating === i ? 'selected' : ''}>${i}</option>`;
                    }

                    ratingsHTML = `
                        <p class="module-competency-heading">Competency Level</p>
                        <div class="module-proficiency-rating">
                            <span><strong>Should:</strong> ${mod.shouldRating}</span>
                            <span>
                                <strong>Actual:</strong>
                                <select class="module-actual-rating-select"
                                        data-module-title="${mod.title}" data-employee-id="${emp.id}"
                                        aria-label="Actual rating for ${mod.title} for employee ${emp.name}">
                                    ${actualOptionsHTML}
                                </select>
                            </span>
                        </div>
                    `;
                }

                const displayStatusClass = mod.displayStatus ? mod.displayStatus.replace(/\s+/g, '-') : 'Unknown';
                const attendedDateFormatted = mod.status === "Attended" && mod.attendedDate && trainingPeriodDatePicker ? trainingPeriodDatePicker.formatToDDMMYYYY(new Date(mod.attendedDate)) : '';
                const scheduledDateFormatted = mod.scheduledDate && trainingPeriodDatePicker ? trainingPeriodDatePicker.formatToDDMMYYYY(new Date(mod.scheduledDate)) : '';

                return `
                <div class="training-module-column status-mod-${displayStatusClass}">
                    <div class="module-title" data-tooltip="${mod.fullTitle || mod.title}" tabindex="0">
                        <i class="${mod.icon || 'fas fa-book'} icon" aria-hidden="true"></i> ${mod.title}
                    </div>
                    <span class="status-badge ${displayStatusClass}">${mod.displayStatus || 'N/A'}</span>
                    <div class="module-inline-details">
                        ${scheduledDateFormatted ? `<p><strong>Scheduled:</strong> ${scheduledDateFormatted}</p>` : ''}
                        ${attendedDateFormatted ? `<p><strong>Attended:</strong> ${attendedDateFormatted}</p>` : ''}
                        ${mod.status === "Attended" && mod.hours ? `<p><strong>Hours:</strong> ${mod.hours} | <strong>Sess:</strong> ${mod.sessions || 1}</p>` : ''}
                        ${(mod.displayStatus === "Not Attended") && !attendedDateFormatted ? `<p class="no-data">Awaiting Attendance</p>` : ''}
                    </div>
                    ${ratingsHTML}
                </div>`;
            }).join('');

            const joinedDateFormatted = emp.joinedDate && joiningPeriodDatePicker ? joiningPeriodDatePicker.formatToDDMMYYYY(new Date(emp.joinedDate)) : 'N/A';

            card.innerHTML = `
                <div class="employee-details-block">
                    <div class="info-item">
                        <div class="employee-name-status-wrapper">
                            <h5 id="emp-name-${emp.id}">${emp.name}</h5>
                            <span class="status-pill ${emp.employeeStatus}">${emp.employeeStatus}</span>
                        </div>
                        <p class="employee-id-subtext">(ID: ${emp.id})</p>
                        <div class="employee-info-grid">
                            <p><strong>Role:</strong> ${emp.role || 'N/A'}</p>
                            <p><strong>Joined:</strong> ${joinedDateFormatted}</p>
                            <p><strong>Dept:</strong> ${emp.department || 'N/A'}</p>
                            <p><strong>Unit:</strong> ${emp.unit || 'N/A'}</p>
                        </div>
                    </div>
                </div>
                <div class="all-training-modules-wrapper">${modulesHTML || '<p style="padding-left:15px; color: var(--tracker-text-muted);">No training modules available.</p>'}</div>`;
            employeeListContainer.appendChild(card);
        });
        addModuleRatingChangeListeners();
    }

    function getCurrentFilterValues() {
        return {
            corporate: customDropdowns.corporate?.getValue() || "",
            regional: customDropdowns.regional?.getValue() || "",
            unit: customDropdowns.unit?.getValue() || "",
            department: customDropdowns.departmentPopup?.getValue() || "",
            staffCategory: customDropdowns.staffCategoryPopup?.getValue() || "",
            foodHandlersCategory: customDropdowns.foodHandlersCategoryPopup?.getValue() || "",
            employeeStatus: customDropdowns.employeeStatusPopup?.getValue() || "",
            employeeName: customDropdowns.employeeNamePopup?.getValue() || "",
            trainingTopic: customDropdowns.trainingTopicPopup?.getValue() || "",
            trainingStatus: trainingStatusPopupSelect?.value || "",
            actualRating: actualRatingPopupSelect ? actualRatingPopupSelect.value : "",
            trainingStart: trainingPeriodDatePicker?.getDates().start,
            trainingEnd: trainingPeriodDatePicker?.getDates().end,
            joiningStart: joiningPeriodDatePicker?.getDates().start,
            joiningEnd: joiningPeriodDatePicker?.getDates().end,
        };
    }

    function setupPopup(triggerBtn, overlayEl) {
        if (!triggerBtn || !overlayEl) return;

        const openPopup = () => {
            lastFocusedElement = document.activeElement; // Use global activeElement
            overlayEl.classList.add('show');
            triggerBtn.setAttribute('aria-expanded', 'true');
            const firstFocusable = overlayEl.querySelector('button, [href], input:not([type="hidden"]), select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusable) firstFocusable.focus();
        };

        const closePopup = () => {
            overlayEl.classList.remove('show');
            triggerBtn.setAttribute('aria-expanded', 'false');
            if (lastFocusedElement) lastFocusedElement.focus();
        };

        triggerBtn.addEventListener('click', openPopup);

        overlayEl.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePopup();
            }
        });

        const closeBtn = overlayEl.querySelector('.filter-popup-close');
        if (closeBtn) closeBtn.addEventListener('click', closePopup);

        overlayEl.addEventListener('click', (e) => {
            if (e.target === overlayEl) closePopup();
        });

        const applyBtn = overlayEl.querySelector('button[data-action="apply-popup"]');
        if (applyBtn) applyBtn.addEventListener('click', () => { applyFilters(); closePopup(); });

        const clearBtn = overlayEl.querySelector('button[data-action="clear-popup"]');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (overlayEl.id === 'employeeDetailsPopupOverlay') {
                    Object.keys(customDropdowns).forEach(key => {
                        if (['corporate', 'regional', 'unit', 'departmentPopup', 'staffCategoryPopup', 'foodHandlersCategoryPopup', 'employeeStatusPopup', 'employeeNamePopup'].includes(key)) {
                            customDropdowns[key]?.clear();
                        }
                    });
                } else if (overlayEl.id === 'trainingTopicPopupOverlay') {
                    customDropdowns.trainingTopicPopup?.clear();
                    if(trainingStatusPopupSelect) trainingStatusPopupSelect.value = "";
                    if(actualRatingPopupSelect) actualRatingPopupSelect.value = "";
                }
                applyFilters();
            });
        }
    }

    if (employeeDetailsFilterTriggerBtn && employeeDetailsPopupOverlay) {
      setupPopup(employeeDetailsFilterTriggerBtn, employeeDetailsPopupOverlay);
    }
    if (trainingTopicFilterTriggerBtn && trainingTopicPopupOverlay) {
      setupPopup(trainingTopicFilterTriggerBtn, trainingTopicPopupOverlay);
    }


    if (refreshFiltersBtn) {
        refreshFiltersBtn.addEventListener('click', () => {
            Object.values(customDropdowns).forEach(dropdown => dropdown?.clear());
            if(trainingStatusPopupSelect) trainingStatusPopupSelect.value = "";
            if(actualRatingPopupSelect) actualRatingPopupSelect.value = "";
            trainingPeriodDatePicker?.clearDates();
            joiningPeriodDatePicker?.clearDates();
            applyFilters();
        });
    }

    populateAllFilters();
    renderEmployeeList(employeesData);
});
</script>

<script>
// Script for Topic Tab (Training Calendar Management)
document.addEventListener('DOMContentLoaded', function() {
    const topicPane = document.getElementById('topic');
    if (!topicPane) {
        // console.warn("Topic tab pane not found. Training Calendar Management script will not run.");
        return;
    }

    // Helper to get elements scoped to the topicPane
    function getTopicElementById(id) {
        const element = topicPane.querySelector('#' + id);
        if (!element) {
            // console.warn(`TopicTab: Element with ID '${id}' not found within #topic pane.`);
        }
        return element;
    }
    function queryTopicSelectorAll(selector) {
        return topicPane.querySelectorAll(selector);
    }


    // --- CONSTANTS & GLOBALS (scoped to this script's execution context) ---
    let topicCurrentEntityType = null, topicCurrentEntityId = null, topicCurrentParentId = null, topicCurrentParentName = '';
    let topicFilterProgramEl, topicFilterCourseEl, topicClearFiltersButtonEl;

    // --- UTILITY FUNCTIONS ---
    function topicGenerateId(prefix) { return `topic_${prefix}_${Date.now()}_${Math.floor(Math.random() * 1000)}`; }

    // --- MODAL FUNCTIONS ---
    window.topicOpenModal = function(modalId) { // Make available to inline onclick
        const modalElement = getTopicElementById(modalId);
        if (modalElement) modalElement.style.display = 'block';
    }
    window.topicCloseModal = function(modalId) { // Make available to inline onclick
        const modalElement = getTopicElementById(modalId);
        if (!modalElement) return;
        modalElement.style.display = 'none';
        if (modalId === 'topicProgramModal' || modalId === 'topicCourseModal') {
            const form = getTopicElementById(modalId.replace('Modal', 'Form'));
            if (form) form.reset();
            topicCurrentEntityType = topicCurrentEntityId = topicCurrentParentId = topicCurrentParentName = null;
        } else if (modalId === 'topicUploadCoursesModal' || modalId === 'topicSuperAdminCsvUploadModal') {
            const formId = modalId.replace('Modal','Form');
            const statusId = modalId.replace('Modal','Status');
            const formEl = getTopicElementById(formId);
            if (formEl) formEl.reset();
            const statusEl = getTopicElementById(statusId);
            if(statusEl) {
                statusEl.innerHTML = '';
                statusEl.style.backgroundColor = '#e9ecef';
                statusEl.style.color = 'var(--topic-text-primary)';
            }
        }
    }
    function topicGetDisplayValue(element, fieldName) {
        const contentWrapper = element.querySelector('.entity-content-wrapper');
        if (!contentWrapper) return '';
        const el = contentWrapper.querySelector(`.entity-description[data-field="${fieldName}"]`);
        return el ? el.textContent.trim() : '';
    }

    // --- CORE CRUD & DISPLAY FUNCTIONS for Training Calendar ---
    window.topicOpenAddModal = function(entityType, parentId, parentName) {
        topicCurrentEntityType = entityType; topicCurrentParentId = parentId; topicCurrentParentName = parentName; topicCurrentEntityId = null;
        let modalId, modalTitleElId, formId, titlePrefix = "Add New";
        if (entityType === 'program') {
            modalId = 'topicProgramModal'; modalTitleElId = 'topicProgramModalTitle'; formId = 'topicProgramForm';
            getTopicElementById('topicProgramEntityId').value = '';
            getTopicElementById(modalTitleElId).textContent = `${titlePrefix} Training Program`;
        } else if (entityType === 'course') {
            modalId = 'topicCourseModal'; modalTitleElId = 'topicCourseModalTitle'; formId = 'topicCourseForm';
            getTopicElementById('topicCourseParentId').value = parentId;
            getTopicElementById(modalTitleElId).textContent = `${titlePrefix} Course under "${parentName}"`;
        }
        if (modalId) {
            const formElement = getTopicElementById(formId);
            if (formElement) formElement.reset();
            topicOpenModal(modalId);
        }
    }

    window.topicOpenEditModal = function(entityType, entityId) {
        topicCurrentEntityType = entityType; topicCurrentEntityId = entityId; topicCurrentParentId = null;
        const entityEl = getTopicElementById(entityId);
        if (!entityEl) { console.error("TopicTab: Entity not found:", entityId); return; }
        let modalId, modalTitleElId, titlePrefix = "Edit";
        const entityNameDisplay = entityEl.querySelector('.entity-name-display').textContent;

        if (entityType === 'program') {
            modalId = 'topicProgramModal'; modalTitleElId = 'topicProgramModalTitle';
            getTopicElementById('topicProgramEntityId').value = entityId;
            getTopicElementById('topicProgramNameModal').value = entityNameDisplay;
            getTopicElementById('topicProgramDescriptionModal').value = topicGetDisplayValue(entityEl, 'description');
            getTopicElementById(modalTitleElId).textContent = `${titlePrefix} Training Program`;
        } else if (entityType === 'course') {
            modalId = 'topicCourseModal'; modalTitleElId = 'topicCourseModalTitle';
            getTopicElementById('topicCourseEntityId').value = entityId;
            getTopicElementById('topicCourseNameModal').value = entityNameDisplay;
            getTopicElementById('topicCourseDescriptionModal').value = topicGetDisplayValue(entityEl, 'description');
            getTopicElementById(modalTitleElId).textContent = `${titlePrefix} Course`;
        }
        if (modalId) topicOpenModal(modalId);
    }

    function topicUpdateDisplay(element, fieldName, newValue) {
        const contentWrapper = element.querySelector('.entity-content-wrapper');
        if (!contentWrapper) return;
        const descEl = contentWrapper.querySelector(`.entity-description[data-field="${fieldName}"]`);
        if (descEl) {
            descEl.textContent = newValue || 'No description provided.';
        }
    }

    window.topicSaveProgram = function() { const entityIdInput = getTopicElementById('topicProgramEntityId'); const entityId = entityIdInput.value; const name = getTopicElementById('topicProgramNameModal').value; const description = getTopicElementById('topicProgramDescriptionModal').value; const nameEscaped = name.replace(/'/g, "\\'"); if (entityId) { const progElement = getTopicElementById(entityId); if (!progElement) return; progElement.querySelector('.entity-name-display').textContent = name; progElement.querySelector('.summary-action-btn.add-course')?.setAttribute('onclick', `topicOpenAddModal('course', '${entityId}', '${nameEscaped}')`); progElement.querySelector('.scoped-upload-section .download-sample').setAttribute('onclick', `topicDownloadCourseSampleCsv('${entityId}', '${nameEscaped}')`); progElement.querySelector('.scoped-upload-section .upload-scoped').setAttribute('onclick', `topicOpenUploadCoursesCsvModal('${entityId}', '${nameEscaped}')`); topicUpdateDisplay(progElement, 'description', description); } else { const newProgId = topicGenerateId('prog'); const mainContentArea = getTopicElementById('topicMainContentArea'); const firstProgram = mainContentArea.querySelector('.training-program'); const programHTML = ` <details class="entity-level training-program" id="${newProgId}" data-status="active"> <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">🎓</span> <span class="entity-name-display">${name}</span> </div> <div class="summary-actions"> <span class="entity-count course-count" id="${newProgId}-course-count"><span class="count-label">Courses: </span>0</span> <button type="button" class="edit-btn" onclick="topicOpenEditModal('program', '${newProgId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="topicDeleteProgramOrCourse('program', '${newProgId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" onclick="topicOpenAddModal('course', '${newProgId}', '${nameEscaped}')" class="action-button summary-action-btn add-course"><span class="btn-icon">➕</span><span>Add Course</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="topicToggleActivation('${newProgId}', 'program', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary> <div class="scoped-upload-section"> <h4>Bulk Add Courses to this Program</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="topicDownloadCourseSampleCsv('${newProgId}', '${nameEscaped}')">📄 Sample CSV for Courses</button> <button type="button" class="action-button upload-scoped" onclick="topicOpenUploadCoursesCsvModal('${newProgId}', '${nameEscaped}')">⬆️ Upload Courses CSV</button> </div> </div> <div class="entity-content-wrapper"> <div class="entity-details-grid"></div> <p class="entity-description" data-field="description">${description || 'No description provided.'}</p> <div class="course-container"></div> </div> </details>`; if (firstProgram) { firstProgram.insertAdjacentHTML('beforebegin', programHTML); } else { const dashboardDetails = topicPane.querySelector('.super-admin-dashboard-details'); if(dashboardDetails) dashboardDetails.insertAdjacentHTML('afterend', programHTML); else { mainContentArea.insertAdjacentHTML('afterbegin', programHTML); } } const newProgElement = getTopicElementById(newProgId); if (newProgElement) { topicUpdateProgramEntityCounts(newProgElement); } entityIdInput.value = ''; } topicCloseModal('topicProgramModal'); topicPopulateProgramFilter(); topicApplyAllFilters(); topicUpdateSuperAdminDashboardStats(); }
    window.topicSaveCourse = function() { const entityId = getTopicElementById('topicCourseEntityId').value; const parentId = getTopicElementById('topicCourseParentId').value; const courseName = getTopicElementById('topicCourseNameModal').value; const description = getTopicElementById('topicCourseDescriptionModal').value; if (entityId) { const courseElement = getTopicElementById(entityId); if (!courseElement) return; courseElement.querySelector('.entity-name-display').textContent = courseName; topicUpdateDisplay(courseElement, 'description', description); } else if (parentId) { const programElement = getTopicElementById(parentId); if (!programElement) return; const newCourseId = topicGenerateId('course'); const courseNameEscaped = courseName.replace(/'/g, "\\'"); const courseHTML = ` <details class="entity-level course-item" id="${newCourseId}" data-status="active"> <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">📖</span> <span class="entity-name-display">${courseName}</span> </div> <div class="summary-actions">  <button type="button" class="edit-btn" onclick="topicOpenEditModal('course', '${newCourseId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="topicDeleteProgramOrCourse('course', '${newCourseId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="topicToggleActivation('${newCourseId}', 'course', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>  <div class="entity-content-wrapper"> <div class="entity-details-grid"> </div> <p class="entity-description" data-field="description">${description || 'No description.'}</p>  </div> </details>`; const courseContainer = programElement.querySelector('.course-container'); courseContainer.insertAdjacentHTML('beforeend', courseHTML); topicUpdateProgramEntityCounts(programElement); } topicCloseModal('topicCourseModal'); topicPopulateCourseFilter(); topicApplyAllFilters(); topicUpdateSuperAdminDashboardStats(); }
    window.topicDeleteProgramOrCourse = function(entityType, entityId) {
        const entityElement = getTopicElementById(entityId);
        if (!entityElement) return;
        const entityName = entityElement.querySelector('.entity-name-display').textContent;
        let message = `Are you sure you want to delete the ${entityType} "${entityName}"?`;
        if (entityType === 'program') {
            message += " This will also delete all its courses.";
        }
        if (confirm(message)) {
            const parentProgramElement = entityElement.closest('.training-program');
            if (entityType === 'program') {
                const courses = entityElement.querySelectorAll('.course-item');
                courses.forEach(course => course.remove());
            }
            entityElement.remove();

            if (parentProgramElement && entityType === 'course' && parentProgramElement.id !== entityId) {
                topicUpdateProgramEntityCounts(parentProgramElement);
            }
            topicPopulateProgramFilter();
            topicPopulateCourseFilter();
            topicApplyAllFilters();
            topicUpdateSuperAdminDashboardStats();
        }
    }

    window.topicToggleActivation = function(entityId, entityType, buttonElement) { const entityElement = getTopicElementById(entityId); if (!entityElement) return; const currentStatus = entityElement.dataset.status; const newStatus = currentStatus === 'active' ? 'inactive' : 'active'; entityElement.dataset.status = newStatus; buttonElement.classList.toggle('active-state', newStatus === 'active'); buttonElement.classList.toggle('inactive-state', newStatus === 'inactive'); buttonElement.innerHTML = `<span class="btn-icon">${newStatus === 'active' ? '🟢' : '🔴'}</span><span>${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`; topicApplyAllFilters(); topicUpdateAllCountsAndDisplays(); }
    function topicSetSpanText(spanId, label, count) { const spanElement = getTopicElementById(spanId); if (spanElement) { const labelElement = spanElement.querySelector('.count-label'); if (labelElement) spanElement.innerHTML = `<span class="count-label">${label} </span>${count}`; else spanElement.textContent = `${label} ${count}`; }}

    function topicUpdateCourseEntityCounts(courseElement) {
        if (!courseElement) return;
    }

    function topicUpdateProgramEntityCounts(progElement) {
        if (!progElement) return;
        const progId = progElement.id;
        const courses = progElement.querySelectorAll('.course-container .entity-level.course-item:not(.hidden-by-filter)');
        topicSetSpanText(`${progId}-course-count`, 'Courses:', courses.length);
    }

    function topicUpdateSuperAdminDashboardStats() {
        const allPrograms = queryTopicSelectorAll('.training-program');
        const allCourses = queryTopicSelectorAll('.course-item');
        const totalProgramsEl = getTopicElementById('topicDashStatTotalPrograms');
        const totalCoursesEl = getTopicElementById('topicDashStatTotalCourses');
        if (totalProgramsEl) totalProgramsEl.textContent = allPrograms.length;
        if (totalCoursesEl) totalCoursesEl.textContent = allCourses.length;
    }

    function topicUpdateAllCountsAndDisplays() {
        queryTopicSelectorAll('.training-program:not(.hidden-by-filter)').forEach(topicUpdateProgramEntityCounts);
        queryTopicSelectorAll('.course-item:not(.hidden-by-filter)').forEach(topicUpdateCourseEntityCounts);
        topicUpdateSuperAdminDashboardStats();
    }

    // --- FILTER FUNCTIONS ---
    function topicPopulateProgramFilter() {
        const filterEl = getTopicElementById('topicFilterProgram');
        if (!filterEl) return;
        const currentValue = filterEl.value;
        filterEl.innerHTML = '<option value="all">All Programs</option>';
        queryTopicSelectorAll('.training-program').forEach(prog => {
            const name = prog.querySelector('.entity-name-display').textContent;
            filterEl.innerHTML += `<option value="${prog.id}">${name}</option>`;
        });
        filterEl.value = currentValue;
    }

    function topicPopulateCourseFilter() {
        const filterEl = getTopicElementById('topicFilterCourse');
        if (!filterEl) return;
        const currentValue = filterEl.value;
        filterEl.innerHTML = '<option value="all">All Courses</option>';
        const selectedProgramId = getTopicElementById('topicFilterProgram').value;

        queryTopicSelectorAll('.course-item').forEach(course => {
            const parentProgram = course.closest('.training-program');
            if (selectedProgramId === 'all' || (parentProgram && parentProgram.id === selectedProgramId)) {
                const name = course.querySelector('.entity-name-display').textContent;
                const progName = parentProgram?.querySelector('.entity-name-display').textContent || 'Unknown Program';
                filterEl.innerHTML += `<option value="${course.id}">${name} (${progName})</option>`;
            }
        });
         filterEl.value = currentValue;
    }


    function topicApplyProgramFilter(progId) {
        queryTopicSelectorAll('.training-program').forEach(prog => {
            prog.classList.toggle('hidden-by-filter', progId !== 'all' && prog.id !== progId);
        });
        queryTopicSelectorAll('.course-item').forEach(course => {
            const parentProgram = course.closest('.training-program');
            course.classList.toggle('hidden-by-filter', progId !== 'all' && (!parentProgram || parentProgram.id !== progId));
        });
        topicPopulateCourseFilter();
    }

    function topicApplyCourseFilter(courseId) {
        const selectedProgramId = getTopicElementById('topicFilterProgram').value;
        queryTopicSelectorAll('.course-item').forEach(course => {
            const parentProgram = course.closest('.training-program');
            const hideByProgram = selectedProgramId !== 'all' && (!parentProgram || parentProgram.id !== selectedProgramId);
            const hideByCourse = courseId !== 'all' && course.id !== courseId;
            course.classList.toggle('hidden-by-filter', hideByCourse || hideByProgram);
        });
    }

    function topicApplyAllFilters() {
        queryTopicSelectorAll('.training-program, .course-item').forEach(el => {
            el.classList.remove('hidden-by-filter');
        });
        const progFilterValue = getTopicElementById('topicFilterProgram').value;
        const courseFilterValue = getTopicElementById('topicFilterCourse').value;
        topicApplyProgramFilter(progFilterValue);
        topicApplyCourseFilter(courseFilterValue);
        topicUpdateAllCountsAndDisplays();
    }


    function topicClearAllFilters() {
        getTopicElementById('topicFilterProgram').value = 'all';
        getTopicElementById('topicFilterCourse').value = 'all';
        queryTopicSelectorAll('.training-program, .course-item').forEach(el => {
            el.classList.remove('hidden-by-filter');
        });
        topicPopulateProgramFilter();
        topicPopulateCourseFilter();
        topicUpdateAllCountsAndDisplays();
    }

    // --- CSV HANDLING FUNCTIONS ---
    window.topicDownloadFullSampleCsv = function() {
        const csvContent = `Level,ParentName,Name,Description
Program,,Foundational Skills Program,"Core training for all new employees"
Course,Foundational Skills Program,Intro to Company Policies,"Overview of key company policies"
Program,,Advanced Leadership Development,"For senior managers and team leads"
Course,Advanced Leadership Development,Strategic Thinking Workshop,"Develop strategic planning skills"`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'full_training_calendar_sample.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    window.topicDownloadCourseSampleCsv = function(progId, progName) {
        const csvContent = `Level,ParentName,Name,Description
Course,${progName},New Course Title,"Course description details"`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', `courses_sample_for_${progName.replace(/[^a-z0-9]/gi, '_')}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    window.topicOpenSuperAdminCsvUploadModal = function() {
        getTopicElementById('topicSuperAdminCsvUploadForm').reset();
        getTopicElementById('topicSuperAdminCsvUploadStatus').innerHTML = '';
        topicOpenModal('topicSuperAdminCsvUploadModal');
    }

    window.topicOpenUploadCoursesCsvModal = function(progId, progName) {
        getTopicElementById('topicUploadCoursesForm').reset();
        getTopicElementById('topicUploadCoursesStatus').innerHTML = '';
        getTopicElementById('topicUploadCoursesProgramId').value = progId;
        getTopicElementById('topicUploadCoursesProgramName').value = progName;
        getTopicElementById('topicUploadCoursesTargetProgramName').textContent = progName;
        getTopicElementById('topicUploadCoursesTargetProgramNameMirror').textContent = progName;
        topicOpenModal('topicUploadCoursesModal');
    }

    window.topicHandleSuperAdminCsvUpload = function() {
        const fileInput = getTopicElementById('topicSuperAdminFileCsv');
        const statusEl = getTopicElementById('topicSuperAdminCsvUploadStatus');
        if (!fileInput.files.length) {
            statusEl.textContent = 'Please select a CSV file first.';
            statusEl.style.backgroundColor = '#ffebee';
            statusEl.style.color = '#c62828';
            return;
        }

        const file = fileInput.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const csvData = e.target.result;
                const lines = csvData.split('\n').filter(line => line.trim() !== '');
                const headers = lines[0].split(',').map(h => h.trim().toLowerCase());

                const requiredHeaders = ['level', 'name'];
                if (!requiredHeaders.every(rh => headers.includes(rh))) {
                    statusEl.innerHTML = 'Error: CSV must contain "Level" and "Name" columns.';
                    statusEl.style.backgroundColor = '#ffebee';
                    statusEl.style.color = '#c62828';
                    return;
                }

                const programEntities = [];
                const courseEntities = [];

                for (let i = 1; i < lines.length; i++) {
                    const values = lines[i].split(',');
                    const entity = {};
                    headers.forEach((header, index) => {
                        entity[header] = values[index] ? values[index].trim() : '';
                    });

                    if (entity.level.toLowerCase() === 'program') {
                        programEntities.push(entity);
                    } else if (entity.level.toLowerCase() === 'course') {
                        courseEntities.push(entity);
                    }
                }

                programEntities.forEach(topicProcessProgramFromCsv);
                courseEntities.forEach(topicProcessCourseFromCsv);

                statusEl.innerHTML = 'Successfully processed CSV file!<br>' +
                    `Programs: ${programEntities.length}<br>` +
                    `Courses: ${courseEntities.length}`;
                statusEl.style.backgroundColor = '#e8f5e9';
                statusEl.style.color = '#2e7d32';

            } catch (error) {
                console.error('TopicTab: Error processing CSV:', error);
                statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
                statusEl.style.backgroundColor = '#ffebee';
                statusEl.style.color = '#c62828';
            } finally {
                topicPopulateProgramFilter();
                topicPopulateCourseFilter();
                topicUpdateAllCountsAndDisplays();
                topicApplyAllFilters();
                topicCloseModal('topicSuperAdminCsvUploadModal');
            }
        };
        reader.readAsText(file);
    }

    function topicProcessProgramFromCsv(csvRow) {
        const name = csvRow.name;
        const description = csvRow.description || 'No description provided.';

        const existingProgElement = Array.from(queryTopicSelectorAll('.training-program .entity-name-display'))
                                   .find(el => el.textContent.trim() === name.trim());
        if (existingProgElement) {
            console.log(`TopicTab: Program "${name}" already exists. Skipping creation.`);
            return existingProgElement.closest('.training-program').id;
        }

        const progId = topicGenerateId('prog');
        const nameEscaped = name.replace(/'/g, "\\'");
        const progHTML = `
            <details class="entity-level training-program" id="${progId}" data-status="active">
                <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">🎓</span> <span class="entity-name-display">${name}</span> </div> <div class="summary-actions"> <span class="entity-count course-count" id="${progId}-course-count"><span class="count-label">Courses: </span>0</span> <button type="button" class="edit-btn" onclick="topicOpenEditModal('program', '${progId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="topicDeleteProgramOrCourse('program', '${progId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" onclick="topicOpenAddModal('course', '${progId}', '${nameEscaped}')" class="action-button summary-action-btn add-course"><span class="btn-icon">➕</span><span>Add Course</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="topicToggleActivation('${progId}', 'program', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>
                <div class="scoped-upload-section"> <h4>Bulk Add Courses to this Program</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="topicDownloadCourseSampleCsv('${progId}', '${nameEscaped}')">📄 Sample CSV for Courses</button> <button type="button" class="action-button upload-scoped" onclick="topicOpenUploadCoursesCsvModal('${progId}', '${nameEscaped}')">⬆️ Upload Courses CSV</button> </div> </div>
                <div class="entity-content-wrapper"> <div class="entity-details-grid"></div> <p class="entity-description" data-field="description">${description}</p> <div class="course-container"></div> </div>
            </details>`;

        const mainContentArea = getTopicElementById('topicMainContentArea');
        const firstProgram = mainContentArea.querySelector('.training-program');
        if (firstProgram) {
            firstProgram.insertAdjacentHTML('beforebegin', progHTML);
        } else {
            const dashboardDetails = topicPane.querySelector('.super-admin-dashboard-details');
            if (dashboardDetails) {
                dashboardDetails.insertAdjacentHTML('afterend', progHTML);
            } else {
                mainContentArea.insertAdjacentHTML('afterbegin', progHTML);
            }
        }
        return progId;
    }


    function topicProcessCourseFromCsv(csvRow) {
        const programName = csvRow.parentname;
        const name = csvRow.name;
        const description = csvRow.description || 'No description.';

        const programElement = Array.from(queryTopicSelectorAll('.training-program')).find(prog =>
            prog.querySelector('.entity-name-display').textContent.trim() === programName.trim()
        );

        if (!programElement) {
            console.warn(`TopicTab: CSV Warning: Program parent "${programName}" not found for course "${name}". Skipping course.`);
            return null;
        }

        const existingCourseElement = Array.from(programElement.querySelectorAll('.course-item .entity-name-display')).find(el => el.textContent.trim() === name.trim());
        if (existingCourseElement) {
            console.log(`TopicTab: Course "${name}" under program "${programName}" already exists. Skipping creation.`);
            return existingCourseElement.closest('.course-item').id;
        }

        const courseId = topicGenerateId('course');
        const courseHTML = `
            <details class="entity-level course-item" id="${courseId}" data-status="active">
                <summary class="entity-summary"> <div class="summary-content-wrapper"> <span class="entity-icon">📖</span> <span class="entity-name-display">${name}</span> </div> <div class="summary-actions"> <button type="button" class="edit-btn" onclick="topicOpenEditModal('course', '${courseId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" class="delete-btn" onclick="topicDeleteProgramOrCourse('course', '${courseId}')"><span class="btn-icon">🗑️</span><span>Delete</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="topicToggleActivation('${courseId}', 'course', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary>
                <div class="entity-content-wrapper"> <div class="entity-details-grid"> </div> <p class="entity-description" data-field="description">${description}</p> </div>
            </details>`;

        const courseContainer = programElement.querySelector('.course-container');
        if (courseContainer) {
            courseContainer.insertAdjacentHTML('beforeend', courseHTML);
        } else {
            console.error(`TopicTab: CRITICAL ERROR: Could not find .course-container in program "${programName}" (ID: ${programElement.id}) while trying to add course "${name}".`);
            return null;
        }
        return courseId;
    }

    window.topicHandleUploadCoursesCsv = function() {
        const fileInput = getTopicElementById('topicUploadCoursesFileCsv');
        const statusEl = getTopicElementById('topicUploadCoursesStatus');
        const progId = getTopicElementById('topicUploadCoursesProgramId').value;
        const progName = getTopicElementById('topicUploadCoursesProgramName').value;

        if (!fileInput.files.length) {
            statusEl.textContent = 'Please select a CSV file first.';
            statusEl.style.backgroundColor = '#ffebee';
            statusEl.style.color = '#c62828';
            return;
        }

        const file = fileInput.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const csvData = e.target.result;
                const lines = csvData.split('\n').filter(line => line.trim() !== '');
                const headers = lines[0].split(',').map(h => h.trim().toLowerCase());

                const requiredHeaders = ['level', 'name'];
                if (!requiredHeaders.every(rh => headers.includes(rh))) {
                    statusEl.innerHTML = 'Error: CSV must contain "Level" and "Name" columns.';
                    statusEl.style.backgroundColor = '#ffebee';
                    statusEl.style.color = '#c62828';
                    return;
                }

                const courseEntities = [];

                for (let i = 1; i < lines.length; i++) {
                    const values = lines[i].split(',');
                    const entity = {};
                    headers.forEach((header, index) => {
                        entity[header] = values[index] ? values[index].trim() : '';
                    });

                    if (entity.level.toLowerCase() === 'course') {
                        entity.parentname = progName;
                        courseEntities.push(entity);
                    }
                }

                courseEntities.forEach(topicProcessCourseFromCsv);

                statusEl.innerHTML = 'Successfully processed CSV file!<br>' +
                    `Courses: ${courseEntities.length}`;
                statusEl.style.backgroundColor = '#e8f5e9';
                statusEl.style.color = '#2e7d32';
            } catch (error) {
                console.error('TopicTab: Error processing CSV:', error);
                statusEl.innerHTML = 'Error processing CSV file: ' + error.message;
                statusEl.style.backgroundColor = '#ffebee';
                statusEl.style.color = '#c62828';
            } finally {
                const programElement = getTopicElementById(progId);
                if (programElement) topicUpdateProgramEntityCounts(programElement);
                topicPopulateCourseFilter();
                topicUpdateAllCountsAndDisplays();
                topicApplyAllFilters();
                topicCloseModal('topicUploadCoursesModal');
            }
        };
        reader.readAsText(file);
    }


    // --- INITIALIZATION ---
    // Make sure these elements are found using the scoped getter
    topicFilterProgramEl = getTopicElementById('topicFilterProgram');
    topicFilterCourseEl = getTopicElementById('topicFilterCourse');
    topicClearFiltersButtonEl = getTopicElementById('topicClearFiltersButton');

    if (topicFilterProgramEl) topicFilterProgramEl.addEventListener('change', function() {
        topicApplyAllFilters();
    });
    if (topicFilterCourseEl) topicFilterCourseEl.addEventListener('change', function() {
        topicApplyAllFilters();
    });
    if (topicClearFiltersButtonEl) topicClearFiltersButtonEl.addEventListener('click', topicClearAllFilters);

    topicPopulateProgramFilter();
    topicPopulateCourseFilter();
    topicUpdateAllCountsAndDisplays();
    topicApplyAllFilters();

    // Close modals when clicking outside - specific to topic modals
    window.addEventListener('click', function(event) {
        const modals = queryTopicSelectorAll('.modal'); // Use scoped selector
        modals.forEach(modal => {
            if (event.target === modal) {
                topicCloseModal(modal.id); // Use scoped close function
            }
        });
    });
});
</script>

@endsection