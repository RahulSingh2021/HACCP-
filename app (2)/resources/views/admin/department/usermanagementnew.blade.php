<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{asset('assets/js/pace.min.js')}}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/dark-theme.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/semi-dark.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/header-colors.css')}}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
	
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.light.css" id="cm-theme" />
    <link rel="stylesheet" media="screen" href="https://cdn3.devexpress.com/jslib/19.1.4/css/dx.common.css" id="cm-theme" />

	 <meta name="csrf-token" content="{{ csrf_token() }}" />

     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <style>
        ul#pagination-list {
            display: none;
        }
        .footer-controls {
    display: none !important;
}
        :root {
            --primary-color: #4f46e5;
            --border-color: #e5e7eb;
            --text-color-light: #6b7280;
            --text-color-dark: #111827;
            --background-color: #f9fafb;
            --surface-color: #ffffff;
            --green: #22c55e;
            --red: #ef4444;
            --red-light: #fee2e2;
            --red-dark: #b91c1c;
            --blue: #3b82f6;
            --blue-light: #e0e7ff;
            --yellow-light: #fef9c3;
            --yellow-dark: #ca8a04;
        }

        /* --- Base & Container Styles --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--background-color); color: var(--text-color-dark); padding: 2rem; }
        .main-content-wrapper { display: flex; flex-direction: column; gap: 2rem; width: 100%; align-items: center; }
        .container { width: 100%; max-width: 1800px; background-color: var(--surface-color); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1); overflow: hidden; }

        /* --- Table Header & Actions --- */
        .table-header, .table-footer { padding: 1rem 1.5rem; display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: space-between; align-items: center; }
        .table-header { border-bottom: 1px solid var(--border-color); }
        .table-footer { border-top: 1px solid var(--border-color); font-size: 0.875rem; color: var(--text-color-light); }
        .header-title { flex-grow: 1; }
        .table-header h1, .table-header h2 { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.25rem; }
        .last-updated, .review-summary { font-size: 0.8rem; color: var(--text-color-light); }
        .table-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem; }
        .btn { padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; white-space: nowrap; }
        .btn-primary { background-color: var(--primary-color); color: white; border: 1px solid var(--primary-color); }
        .btn-primary:hover { background-color: #4338ca; }
        .btn-secondary { background-color: var(--surface-color); color: var(--text-color-dark); border: 1px solid var(--border-color); }
        /*.btn-secondary:hover { background-color: var(--background-color); }*/
        .btn-success { background-color: var(--green); color: white; border-color: var(--green); }
        .btn-success:hover { background-color: #16a34a; }
        .btn-danger { background-color: #f3f4f6; color: var(--red); border-color: #f3f4f6;}
        .btn-danger:hover { background-color: var(--red-light); }

        /* --- Pagination & Footer Controls --- */
        .footer-controls { display: flex; align-items: center; gap: 1rem; }
        .footer-controls label { font-weight: 500; }
        .footer-controls select { padding: 0.25rem; border-radius: 4px; border: 1px solid var(--border-color); }
        .pagination { display: flex; list-style: none; gap: 0.25rem; align-items: center; }
        .pagination li a { display: block; padding: 0.5rem 0.75rem; border-radius: 6px; text-decoration: none; color: var(--text-color-dark); transition: background-color 0.2s; }
        .pagination li a:hover { background-color: var(--background-color); }
        .pagination li.active a { background-color: var(--primary-color); color: white; font-weight: 600; }
        .pagination li.disabled a { color: #ccc; cursor: not-allowed; }
        .pagination li.disabled a:hover { background-color: transparent; }
        
        /* --- Table & UI States --- */
        .update-message { padding: 0.75rem 1.5rem; background-color: var(--blue-light); color: var(--primary-color); font-size: 0.875rem; font-weight: 500; display: none; text-align: center; border-bottom: 1px solid var(--border-color); }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th, td { padding: 1rem 1.5rem; text-align: left; vertical-align: middle; font-size: 0.875rem; }
        thead th { background-color: #f9fafb; color: var(--text-color-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid var(--border-color); position: relative; }
        tbody tr { border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease-in-out; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:not([data-editing="true"]):hover { background-color: #f8fafc; cursor: pointer; }
        #review-container { border: 2px solid var(--primary-color); }
        .review-section-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; background-color: #f3f4f6; border-bottom: 1px solid var(--border-color); }
        .review-section-header h3 { margin: 0; font-weight: 600; font-size: 1rem; }
        .matched-row { background-color: var(--yellow-light); }
        .matched-row .name { color: var(--yellow-dark); font-weight: 700; }
        .matched-row:not([data-editing="true"]):hover { background-color: #fef3c7; }
        .data-not-added { background-color: var(--red-light); color: var(--red-dark); padding: 0.1rem 0.4rem; border-radius: 4px; font-style: normal; font-weight: 500; }
        .invalid-data { background-color: var(--red-light); color: var(--red-dark); padding: 0.1rem 0.4rem; border-radius: 4px; font-weight: 500; }

        @keyframes fade-out-highlight { from { background-color: var(--yellow-light); } to { background-color: transparent; } }
        .row-updated { animation: fade-out-highlight 2s ease-out; }

        /* Editing & Actions */
        .action-cell { display: flex; gap: 0.75rem; justify-content: center; align-items: center; }
        .action-cell .icon { cursor: pointer; font-size: 1.1rem; transition: transform 0.2s, color 0.2s; }
        .action-cell .icon:hover { transform: scale(1.25); }
        .icon-accept-match { color: var(--green); }
        .icon-reject, .action-cell .fa-trash-alt:hover { color: var(--red); }
        td[data-editing="true"] span[contenteditable="true"]:not(.data-not-added) { display: inline-block; width: auto; min-width: 50px; background-color: #eff6ff; padding: 0.25rem 0.5rem; border-radius: 4px; outline: 2px solid var(--primary-color); cursor: text; }
        td[data-editing="true"] .data-not-added { background-color: var(--red-light); }
        
        /* --- Cell Content & Status Slider --- */
        .employee-cell { display: flex; align-items: center; gap: 1rem; }
        .avatar { width: 48px; height: 48px; border-radius: 50%; background-color: #e0e7ff; color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.1rem; flex-shrink: 0; }
        .employee-info .name { font-weight: 600; color: var(--text-color-dark); display: block; margin-bottom: 0.25rem; }
        .employee-details { margin-top: 0.5rem; font-size: 0.8rem; color: var(--text-color-light); display: flex; flex-wrap: wrap; gap: 0.25rem 1rem; }
        .employee-details span { display: flex; align-items: center; gap: 0.4rem; }
        .employee-details .fa-solid { font-size: 0.75rem; }
        .cell-stack > div { margin-bottom: 0.25rem; }
        .cell-stack > div:last-child { margin-bottom: 0; }
        .cell-stack .label { font-weight: 600; color: var(--text-color-dark); }
        .cell-stack .sub-label { color: var(--text-color-light); display: flex; align-items: center; gap: 0.5rem; }
        .status-slider input { display: none; }
        .status-slider .slider-track { cursor: pointer; width: 44px; height: 24px; background-color: var(--red); display: block; border-radius: 100px; position: relative; transition: background-color 0.2s; }
        .status-slider .slider-track::before { content: ''; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; background-color: white; border-radius: 50%; transition: 0.2s; }
        .status-slider input:checked + .slider-track { background-color: var(--green); }
        .status-slider input:checked + .slider-track::before { transform: translateX(20px); }
        
        /* Modal */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.6); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; visibility: hidden; transition: opacity 0.3s, visibility 0.3s; }
        .modal-overlay.visible { opacity: 1; visibility: visible; }
        .modal-content { background-color: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 550px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); transform: scale(0.95); transition: transform 0.3s; }
        .modal-overlay.visible .modal-content { transform: scale(1); }
        .modal-content h2 { font-size: 1.25rem; margin-bottom: 0.5rem; }
        .modal-content p { color: var(--text-color-light); margin-bottom: 1.5rem; }
        .modal-content textarea { width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; min-height: 100px; font-family: 'Inter', sans-serif; resize: vertical; margin-bottom: 1.5rem; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem; }
        #new-employee-form { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 1.5rem; max-height: 60vh; overflow-y: auto; padding: 0.5rem; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 0.25rem; font-weight: 500; font-size: 0.875rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; }

        /* --- Filter Dropdown Styles --- */
        .filter-icon { margin-left: 8px; color: var(--text-color-light); transition: color 0.2s; cursor: pointer; }
        thead th:hover .filter-icon, .filter-icon.active { color: var(--primary-color); }
        .filter-dropdown { display: none; position: absolute; top: 100%; left: 0; z-index: 10; width: 320px; background-color: var(--surface-color); border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 1rem; cursor: default; text-align: left; text-transform: none; }
        .filter-dropdown-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;}
        .filter-dropdown-header h4 { margin: 0; font-size: 1rem; font-weight: 600;}
        #clear-filters-btn { background: none; border: none; color: var(--primary-color); cursor: pointer; font-weight: 500; font-size: 0.8rem; padding: 0.25rem; }
        #clear-filters-btn:hover { text-decoration: underline; }
        .filter-section { margin-bottom: 1rem; }
        .filter-section > label { display: block; font-weight: 600; font-size: 0.875rem; color: var(--text-color-dark); margin-bottom: 0.5rem; }
        .filter-section input[type="search"], .filter-section input[type="date"] { width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.875rem; font-family: 'Inter', sans-serif; }
        .checkbox-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .checkbox-group label { font-weight: 400; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-bottom: 0; color: var(--text-color-dark); }
        .date-range { display: flex; align-items: center; gap: 0.5rem; }
        hr.filter-divider { border: none; border-top: 1px solid var(--border-color); margin: 1.5rem 0; }
        #filter-name-id-search { margin-bottom: 0.5rem; }
        #filter-name-id-list { max-height: 150px; overflow-y: auto; border: 1px solid var(--border-color); border-radius: 6px; padding: 0.5rem; }
        #filter-name-id-list label { display: flex; padding: 0.25rem 0.5rem; border-radius: 4px; align-items: center; }
        #filter-name-id-list label.select-all-label { font-weight: 600; border-bottom: 1px solid var(--border-color); margin-bottom: 0.25rem;}
        #filter-name-id-list label:not(.select-all-label):hover { background-color: var(--background-color); }
        #filter-no-employee-results { display: none; text-align: center; color: var(--text-color-light); font-style: italic; padding: 1rem 0; }
        #active-filters-container { padding: 0 1.5rem 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; }
        .filter-tag { background-color: var(--blue-light); color: var(--primary-color); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 500; display: flex; align-items: center; gap: 0.5rem; }
        .filter-tag .remove-tag { cursor: pointer; font-weight: bold; font-size: 1rem; line-height: 1; }
        .filter-tag .remove-tag:hover { color: var(--red-dark); }

        /* --- Custom Inline Edit Dropdown Styles --- */
        .custom-select-wrapper { position: relative; width: 100%; height: 100%; }
        .custom-select-trigger { width: 100%; background-color: #eff6ff; border: 1px solid var(--primary-color); border-radius: 6px; padding: 0.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .custom-select-trigger .fa-chevron-down { font-size: 0.75rem; color: var(--text-color-light); }
        .custom-select-panel { display: none; position: absolute; top: calc(100% + 4px); left: 0; width: 100%; min-width: 200px; background-color: var(--surface-color); border-radius: 8px; border: 1px solid var(--border-color); box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 101; }
        .custom-select-panel.open { display: block; }
        .custom-select-search-container { padding: 0.5rem; border-bottom: 1px solid var(--border-color); }
        .custom-select-search { width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--border-color); }
        .custom-select-options { max-height: 200px; overflow-y: auto; padding: 0.5rem; }
        .custom-select-option { padding: 0.5rem 0.75rem; border-radius: 4px; cursor: pointer; white-space: normal; }
        .custom-select-option:hover { background-color: var(--background-color); }
        .custom-select-option.selected { background-color: var(--blue-light); color: var(--primary-color); font-weight: 600; }
        .custom-select-option.hidden { display: none; }
        
        /* NEW: Style for date input during editing */
        td[data-editing="true"] input[type="date"] {
            background-color: #eff6ff;
            padding: 0.4rem 0.5rem;
            border-radius: 6px;
            border: 1px solid var(--primary-color);
            outline: 1px solid var(--primary-color);
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
        }
        
        button#download-xlsx-btn {
            border: 1px solid #ddd;
            background: transparent;
            color:#000;
        }
        button#download-xlsx-btn:hover {
            border: 1px solid #ddd;
            background: transparent;
            color:#000;
        }
        
        
        
         button#download-csv-btn {
            border: 1px solid #ddd;
            background: transparent;
            color:#000;
        }
        button#download-csv-btn:hover {
            border: 1px solid #ddd;
            background: transparent;
            color:#000;
        }
        .label.btn.btn-secondary {
            border: 1px solid #ddd;
            background: transparent;
            color:#000;
        }
        .label.btn.btn-secondary:hover {
            border: 1px solid #ddd;
            background: transparent;
            color:#000;
        }
    </style>
    <style>
        




  #status-modal111 {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    z-index: 9999;
  }



    </style>
    <?php 
        if(!empty(Session::get('unit_id'))  ){
         $login_user=  Session::get('unit_id');
        }
        else{
         $login_user=  Auth::user()->id;   
        }
    ?>
    <div class="main-content-wrapper">
    <div class="container" id="main-container">
        <header class="table-header">
            <div class="header-title"><h1>Employee Roster</h1><p class="last-updated" id="last-updated-msg"></p></div>
            <div class="table-actions">
                <button class="btn btn-secondary" id="download-csv-btn"><i class="bx bx-download"></i> Download Sample</button>
                <button class="btn btn-secondary" id="download-xlsx-btn"><i class="bxs-file"></i> Download Excel</button>
                <label for="csv-upload-input" class="btn btn-secondary"><i class="bx bx-upload"></i> Upload CSV</label>
                <input type="file" id="csv-upload-input" accept=".csv" style="display: none;">
                <button class="btn btn-primary" id="add-manual-btn"><i class="bx bx-plus"></i> New Employee</button>
            </div>
        </header>
        <div id="update-message" class="update-message"></div>
        <div id="active-filters-container"></div>
        <div class="table-wrapper">
            <table id="main-employee-table">
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Hierarchy</th>
                        <th>
                            Employee Info
                            <i class="fas fa-filter filter-icon"></i>
                            <div class="filter-dropdown">
                                <div class="filter-dropdown-header">
                                    <h4>Filter Options</h4>
                                    <button id="clear-filters-btn">Clear All</button>
                                </div>
                                <div class="filter-section">
                                    <label for="filter-name-id-search">Employee Name / Ticket No.</label>
                                    <input type="search" id="filter-name-id-search" placeholder="Search for employee...">
                                    <div id="filter-name-id-list" class="checkbox-group"></div>
                                    <p id="filter-no-employee-results">No employees found.</p>
                                </div>
                                <hr class="filter-divider">
                                <div class="filter-section">
                                    <label>Gender</label>
                                    <div class="checkbox-group" id="filter-gender-group">
                                        <label><input type="checkbox" value="Male"> Male</label>
                                        <label><input type="checkbox" value="Female"> Female</label>
                                        <label><input type="checkbox" value="Other"> Other</label>
                                    </div>
                                </div>
                                <hr class="filter-divider">
                                <div class="filter-section">
                                    <label>Date of Joining</label>
                                    <div class="date-range">
                                        <input type="date" id="filter-doj-from" title="From joining date">
                                        <span>to</span>
                                        <input type="date" id="filter-doj-to" title="To joining date">
                                    </div>
                                </div>
                                <hr class="filter-divider">
                                <div class="filter-section">
                                    <label>Date of Birth</label>
                                    <div class="date-range">
                                        <input type="date" id="filter-dob-from" title="From birth date">
                                        <span>to</span>
                                        <input type="date" id="filter-dob-to" title="To birth date">
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th>Contact</th>
                        <th>Role & Responsibility</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="table-footer" id="main-table-footer">
             <div class="footer-controls">
                <label for="rows-per-page">Rows per page:</label>
                <select id="rows-per-page"><option value="5">5</option><option value="10" selected>10</option><option value="25">25</option><option value="50">50</option></select>
            </div>
            <div id="pagination-info"></div>
            <nav><ul class="pagination" id="pagination-list"></ul></nav>
        </div>
    </div>

    <!-- REVIEW CONTAINER -->
    <div class="container" id="review-container" style="display: none;">
        <header class="table-header">
            <div class="header-title"><h2>Review Uploaded Data</h2><p class="review-summary" id="review-summary-msg"></p></div>
        </header>
        <div id="matched-records-section">
            <div class="review-section-header">
                <h3>Matched Records (Potential Duplicates)</h3>
                <div class="table-actions"><button class="btn btn-danger" id="discard-matched-btn"><i class="fas fa-times"></i> Discard All</button><button class="btn btn-secondary" id="acknowledge-matched-btn"><i class="fas fa-check-double"></i> Acknowledge All</button></div>
            </div>
            <div class="table-wrapper"><table id="matched-review-table"><thead><tr><th>Hierarchy</th><th>Employee Info</th><th>Contact</th><th>Role & Responsibility</th><th>Category</th><th>Match %</th><th>Actions</th></tr></thead><tbody></tbody></table></div>
        </div>
        <div id="new-records-section" style="margin-top: 2rem;">
            <div class="review-section-header">
                <h3>New Records to be Added</h3>
                <div class="table-actions"><button class="btn btn-danger" id="discard-unique-btn"><i class="fas fa-times"></i> Discard All</button><button class="btn btn-success" id="add-unique-btn"><i class="fas fa-plus"></i> Add All New</button></div>
            </div>
             <div class="table-wrapper"><table id="unique-review-table"><thead><tr><th>Hierarchy</th><th>Employee Info</th><th>Contact</th><th>Role & Responsibility</th><th>Category</th><th>Actions</th></tr></thead><tbody></tbody></table></div>
        </div>
    </div>
</div>

<!-- MODALS -->
<div class="modal-overlay" id="status-modal" >
  <div class="modal-content">
    <h2 id="modal-title">Change Status</h2>
    
    <p id="modal-description">Please provide a reason for deactivating this user:</p>
    <textarea id="modal-comments"  placeholder="Enter comments..."></textarea>
    <div class="modal-actions">
      <button class="btn btn-secondary" id="modal-cancel">Cancel</button>
      <button class="btn btn-primary"  id="modal-confirm">Confirm Change</button>
    </div>
  </div>
</div>


<div id="status-modal111" style="display: none;">
  <div class="modal-content" style="
    background: #fff;
    width: 500px;
    margin: 100px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  ">
    <h2 id="modal-title">Change Status</h2>
    <form method="post" action="{{ route('deactivateupdateStatus') }}">
        @csrf
    <p id="modal-description">Please provide a reason for deactivating this user:</p>
        <input type="hidden" id="edit_row" name="edit_row" value="">
    <textarea id="modal-comments" name="status_comment"  placeholder="Enter comments..." style="width: 100%; height: 100px;"></textarea>
    <div class="modal-actions" style="text-align: right; margin-top: 15px;">
      <button class="btn btn-secondary" id="modal-cancel">Cancel</button>
      <button class="btn btn-primary" type="submit">Confirm Change</button>
    </div>
    </form>
  </div>
</div>



        

<div class="modal-overlay" id="new-employee-modal">
    
    <form method="post" action="{{route('add_unit_user')}}">
                            @csrf
    <div class="modal-content"><h2>Add New Employee</h2><p>Fill in the details for the new employee below.</p>
    
                    <div class="row">
			
						
                 
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">I D</label>
                            <input type="text" class="form-control"  name="employer_id" placeholder="">
                            @if($errors->has('unit_name'))
    <div class="error">{{ $errors->first('unit_name') }}</div>
@endif
                        </div>
						
						   <div class="mb-3 col-md-6">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"  name="employer_fullname" placeholder="">
                            @if($errors->has('employer_fullname'))
    <div class="error">{{ $errors->first('employer_fullname') }}</div>
@endif
                        </div>
						
						
							   <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control"  name="email" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>
						
						
								   <div class="mb-3 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control"  name="contact_number" placeholder="">
                            @if($errors->has('contact_number'))
    <div class="error">{{ $errors->first('contact_number') }}</div>
@endif
                        </div>

        
<div class="mb-3 col-md-6">
                            <label class="form-label">Department</label>
									 
										 <select name="department" id="mydepartment" class="form-control" >
										 <option value="">Please Select Department </option>
										 
										   @foreach($departments as $departmentss)
										 <option value="{{$departmentss->name}}">{{$departmentss->name}} ({{Helper::userInfoShortName($departmentss->unit_id ?? '')}})</option>
										 
										 @endforeach
									 
									 </select>
                        </div>
						
					
					
						
						
						
								         <div class="mb-3 col-md-6">
                            <label class="form-label">Responsibility:</label>
									 
										 <select name="responsibility_id" id="mySelect" class="form-control" >
										 <option value="">Please Select Responsibility </option>
										 
										
										 @foreach($authority as $authoritys)
										 <option value="{{$authoritys->name}}">{{$authoritys->name}} ({{Helper::userInfoShortName($authoritys->unit_id ?? '')}})</option>
										 
										 @endforeach
									 
									 </select>

                        </div>
                        
                        
<div class="mb-3 col-md-6">
<label class="form-label">Designation</label>

<input type="text" class="form-control"  name="designation" placeholder="">


</div>


<div class="mb-3 col-md-6">
                         <label class="form-label">Food Handler</label>
										 <select name="cat_name" id="corporate_id_edit"   class="form-control" >
										 <option value="">Food Handler
 </option>
										  			 	 
	 <option value="Yes">Yes</option>
	 <option value="No">No</option>
	 <option value="NA">Not Applicable</option>

									
									 </select>
</div>


<div class="mb-3 col-md-6">
<label class="form-label">Staff Category</label>


										 <select name="staff_category" class="form-control" >
										 <option value="">Please Staff Category </option>
										 
										
										 @foreach($staff_users_list as $authoritys)
										 <option value="{{$authoritys->name}}">{{$authoritys->name}}</option>
										 
										 @endforeach
									 
									 </select>



</div>

		         <div class="mb-3 col-md-6">
                            <label class="form-label">Select Gender:</label>
									 
										 <select name="gender" id="mySelect" class="form-control" >
								
										 <option value="Male">Male</option>
										 <option value="Female">Female</option>
										 <option value="Other">Other</option>
				
									 </select>

                        </div>
            
            
            
		         <div class="mb-3 col-md-6">
                            <label class="form-label">Joined Date</label>
									 
							<input type="date" class="form-control" name="dog">

                        </div>
                                 <div class="mb-3 col-md-6">
                            <label class="form-label">Birth Date</label>
									 
							<input type="date" class="form-control" name="dob">

                        </div>
       
               
                     
   
    <div class="modal-actions">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Employee</button>        </div>
        
           </form>
        </div>
        </div>           




<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Global State & Elements ---
    let reviewState = { matched: [], unique: [] };
    let currentPage = 1;
    let rowsPerPage = 10;
    const mainContainer = document.getElementById('main-container');
    const reviewContainer = document.getElementById('review-container');
    const updateMessageEl = document.getElementById('update-message');
    const csvUploadInput = document.getElementById('csv-upload-input');
    const downloadCsvBtn = document.getElementById('download-csv-btn');
    const downloadXlsxBtn = document.getElementById('download-xlsx-btn');
    const addManualBtn = document.getElementById('add-manual-btn'); 
    const reviewSummaryMsg = document.getElementById('review-summary-msg');
    const mainTableBody = document.querySelector('#main-employee-table tbody');
    
    // Status Modal Elements
    const statusModal = document.getElementById('status-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalConfirmBtn = document.getElementById('modal-confirm');
    const modalCancelBtn = document.getElementById('modal-cancel');
    let activeToggle = null;

    // New Employee Modal Elements
    const newEmployeeModal = document.getElementById('new-employee-modal');
    const newEmployeeForm = document.getElementById('new-employee-form');
    const modalAddEmployeeBtn = document.getElementById('modal-add-employee-btn');
    const modalNewEmployeeCancel = document.getElementById('modal-new-employee-cancel');
    
    // Pagination & Update Info Elements
    const rowsPerPageSelect = document.getElementById('rows-per-page');
    const paginationInfo = document.getElementById('pagination-info');
    const paginationList = document.getElementById('pagination-list');
    const lastUpdatedMsg = document.getElementById('last-updated-msg');

    // Filter Elements
    const filterIcon = document.querySelector('.filter-icon');
    const filterDropdown = document.querySelector('.filter-dropdown');
    const clearFiltersBtn = document.getElementById('clear-filters-btn');
    const activeFiltersContainer = document.getElementById('active-filters-container');
    const employeeFilterSearch = document.getElementById('filter-name-id-search');
    const employeeFilterList = document.getElementById('filter-name-id-list');
    const noEmployeeResultsMsg = document.getElementById('filter-no-employee-results');

    const predefinedOptions = { /* Unchanged */
        Corporate: ['Global Tech Inc.', 'Quantum Solutions'],
        Regional: ['North America', 'EMEA', 'APAC'],
        Unit: ['Main Branch', 'Innovation Hub', 'Support Center'],
Department: [
@foreach($departments as $departmentss)
    '{{ $departmentss->name }}'{{ !$loop->last ? ',' : '' }}
@endforeach
],

Category: [
@foreach($staff_users_list as $authoritys)
    '{{ $authoritys->name }}'{{ !$loop->last ? ',' : '' }}
@endforeach
],

        FoodHandler: ['Yes', 'No', 'Not Applicable'],
        Role: ['Top Management', 'Food Safety Team Leader', 'Food Safety Team', 'Food Safety Coordinator CCP Monitor', 'Food Safety Coordinator', 'Developer', 'Designer', 'Analyst'],
        Gender: ['Male', 'Female', 'Other']
    };

    // --- Utility Functions ---
    const showUpdateMessage = (message, duration = 4000) => { /* Unchanged */
        updateMessageEl.textContent = message;
        updateMessageEl.style.display = 'block';
        setTimeout(() => { updateMessageEl.style.display = 'none'; }, duration);
    };
    const formatDateTime = (date) => date.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' });
    const updateLastUpdated = () => { lastUpdatedMsg.textContent = `Table Last Updated: ${formatDateTime(new Date())}`; };
    
    // --- Jaro-Winkler Similarity Function ---
    function jaroWinkler(s1, s2) { let m = 0; if (s1.length === 0 || s2.length === 0) return 0; if (s1 === s2) return 1; let r = (Math.floor(Math.max(s1.length, s2.length) / 2)) - 1, s1M = new Array(s1.length), s2M = new Array(s2.length); for (let i = 0; i < s1.length; i++) { let low = (i >= r) ? i - r : 0, high = (i + r <= s2.length) ? i + r : s2.length - 1; for (let j = low; j <= high; j++) { if (!s2M[j] && s1[i] === s2[j]) { s1M[i] = true; s2M[j] = true; m++; break; } } } if (m === 0) return 0; let k = 0, t = 0; for (let i = 0; i < s1.length; i++) { if (s1M[i]) { while (!s2M[k]) k++; if (s1[i] !== s2[k]) t++; k++; } } t /= 2; let jaro = ((m / s1.length) + (m / s2.length) + ((m - t) / m)) / 3; let p = 0.1, l = 0; if (jaro > 0.7) { while (s1[l] === s2[l] && l < 4) l++; jaro = jaro + l * p * (1 - jaro); } return jaro; }

    // --- HTML Generation ---
    const createReviewRowHTML = (empData, type) => { /* Unchanged */
        const placeholder = 'Data not Added';
        const getValue = (key) => empData[key] || placeholder;
        const getFormattedDate = (key) => empData[key] ? formatDateTime(new Date(empData[key])) : 'N/A';
        const avatarInitials = (empData.Name || 'NN').split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
        const actionsHTML = type === 'main' ? `<label class="status-slider"><input type="checkbox" class="status-toggle" ${empData.Status === '1' ? 'checked' : ''}><span class="slider-track"></span></label><i class="fas fa-trash-alt icon" title="Delete"></i>` : (type === 'matched' ? `<i class="fas fa-plus-circle icon icon-accept-match" title="Accept as New"></i><i class="fas fa-times-circle icon icon-reject" title="Reject"></i>` : `<i class="fas fa-times-circle icon icon-reject" title="Reject"></i>`);
        const similarityCell = type === 'matched' ? `<td><strong>${(empData.similarity * 100).toFixed(1)}%</strong></td>` : '';
        const rowClass = type === 'matched' ? 'matched-row' : '';
        const rowHTML = `<tr data-id="${empData.id}" class="${rowClass}"><td><div class="cell-stack"><div class="label"><span data-key="Corporate">${getValue('Corporate')}</span></div><div class="sub-label"><span data-key="Regional">${getValue('Regional')}</span></div><div class="sub-label"><span data-key="Unit">${getValue('Unit')}</span></div></div></td><td><div class="employee-cell"><div class="avatar">${avatarInitials}</div><div class="employee-info"><span class="name" data-key="Name">${getValue('Name')}</span><div class="employee-details"><span data-key="id-display"><i class="fa-solid fa-id-badge"></i> ID: <span data-key="ID">${getValue('ID')}</span></span><span><i class="fa-solid fa-venus-mars"></i> <span data-key="Gender">${getValue('Gender')}</span></span><span><i class="fa-solid fa-calendar-alt"></i> Joined: <span data-key="JoinedDate">${getValue('JoinedDate')}</span></span><span><i class="fa-solid fa-birthday-cake"></i> Born: <span data-key="BirthDate">${getValue('BirthDate')}</span></span><span class="row-last-updated"><i class="fa-solid fa-clock-rotate-left"></i> Updated: <span data-key="lastUpdated">${getFormattedDate('lastUpdated')}</span></span></div></div></div></td><td><div class="cell-stack"><div class="sub-label"><i class="fa-solid fa-envelope"></i> <span data-key="Email">${getValue('Email')}</span></div><div class="sub-label"><i class="fa-solid fa-phone"></i> <span data-key="Phone">${getValue('Phone')}</span></div></div></td><td><div class="cell-stack"><div class="label"><span data-key="Department">${getValue('Department')}</span></div><div class="sub-label"><span data-key="Role">${getValue('Role')}</span></div><div class="sub-label" data-derived-from="Department">Responsibility: <span>${getValue('Department')}</span></div></div></td><td><div class="cell-stack"><div class="label"><span data-key="Category">${getValue('Category')}</span></div><div class="sub-label">Food Handler: <span data-key="FoodHandler">${getValue('FoodHandler')}</span></div></div></td>${similarityCell}<td><div class="action-cell">${actionsHTML}</div></td></tr>`;
        const doc = new DOMParser().parseFromString(`<table><tbody>${rowHTML}</tbody></table>`, 'text/html');
        const rowElement = doc.querySelector('tr');
        rowElement.querySelectorAll('span[data-key]').forEach(span => { const key = span.dataset.key; const value = span.textContent; if (value === placeholder) { span.classList.add('data-not-added'); return; } const isDropdownField = Object.keys(predefinedOptions).includes(key); if (isDropdownField && !predefinedOptions[key].includes(value)) { span.classList.add('invalid-data'); } });
        return rowElement.outerHTML;
    };
    const createMainTableRowHTML = (empData) => { /* Unchanged */
        empData.Status = empData.Status || 'Active';
        const rowHTML = createReviewRowHTML(empData, 'main');
        const doc = new DOMParser().parseFromString(`<table><tbody>${rowHTML}</tbody></table>`, 'text/html');
        const row = doc.querySelector('tr');
        row.insertAdjacentHTML('afterbegin', '<td><input type="checkbox"></td>');
        return row.outerHTML;
    };
    const renderReviewTables = () => { /* Unchanged */
        const matchedTableBody = document.querySelector('#matched-review-table tbody');
        const uniqueTableBody = document.querySelector('#unique-review-table tbody');
        const matchedSection = document.getElementById('matched-records-section');
        const newSection = document.getElementById('new-records-section');
        matchedTableBody.innerHTML = reviewState.matched.map(emp => createReviewRowHTML(emp, 'matched')).join('');
        uniqueTableBody.innerHTML = reviewState.unique.map(emp => createReviewRowHTML(emp, 'unique')).join('');
        matchedSection.style.display = reviewState.matched.length > 0 ? 'block' : 'none';
        newSection.style.display = reviewState.unique.length > 0 ? 'block' : 'none';
        reviewSummaryMsg.textContent = `Found ${reviewState.matched.length} matched record(s) and ${reviewState.unique.length} new record(s).`;
        if (reviewState.matched.length === 0 && reviewState.unique.length === 0) { reviewContainer.style.display = 'none'; mainContainer.style.display = 'block'; showUpdateMessage("Review complete."); }
    };
    
    // --- Re-usable Edit/Save Logic ---
    // MODIFIED: enterEditMode and saveAndExitEditMode to handle date inputs
    function enterEditMode(row) {
        if (!row || row.dataset.editing === 'true') return;
        const placeholder = 'Data not Added';
        row.dataset.editing = 'true';

        row.querySelectorAll('span[data-key]').forEach(span => {
            const key = span.dataset.key;
            if (key === 'lastUpdated' || key === 'id-display') return;

            const isDropdownField = Object.keys(predefinedOptions).includes(key);

            if (key.includes('Date')) { // Handle date fields specifically
                const currentValue = span.textContent;
                const dateInput = document.createElement('input');
                dateInput.type = 'date';
                dateInput.dataset.key = key;
                if (currentValue !== placeholder) {
                    dateInput.value = currentValue;
                }
                dateInput.addEventListener('change', () => saveAndExitEditMode(row)); // Auto-save on change
                span.replaceWith(dateInput);
            } else if (isDropdownField) {
                // Custom select logic remains the same
                const currentValue = span.textContent;
                const options = predefinedOptions[key];
                const wrapper = document.createElement('div');
                wrapper.className = 'custom-select-wrapper';
                wrapper.dataset.key = key;
                wrapper.dataset.value = currentValue;
                const trigger = document.createElement('div');
                trigger.className = 'custom-select-trigger';
                trigger.innerHTML = `<span>${currentValue}</span><i class="fas fa-chevron-down"></i>`;
                const panel = document.createElement('div');
                panel.className = 'custom-select-panel';
                const searchContainer = document.createElement('div');
                searchContainer.className = 'custom-select-search-container';
                const searchInput = document.createElement('input');
                searchInput.type = 'search';
                searchInput.placeholder = 'Search...';
                searchInput.className = 'custom-select-search';
                searchContainer.appendChild(searchInput);
                const optionsList = document.createElement('div');
                optionsList.className = 'custom-select-options';
                options.forEach(opt => {
                    const optionEl = document.createElement('div');
                    optionEl.className = 'custom-select-option';
                    optionEl.dataset.value = opt;
                    optionEl.textContent = opt;
                    if (opt === currentValue) optionEl.classList.add('selected');
                    optionsList.appendChild(optionEl);
                });
                panel.appendChild(searchContainer);
                panel.appendChild(optionsList);
                wrapper.appendChild(trigger);
                wrapper.appendChild(panel);
                span.replaceWith(wrapper);
                trigger.addEventListener('click', (e) => { e.stopPropagation(); panel.classList.toggle('open'); });
                searchInput.addEventListener('input', () => {
                    const term = searchInput.value.toLowerCase();
                    optionsList.querySelectorAll('.custom-select-option').forEach(opt => {
                        opt.classList.toggle('hidden', !opt.textContent.toLowerCase().includes(term));
                    });
                });
                optionsList.addEventListener('click', (e) => {
                    if (e.target.classList.contains('custom-select-option')) {
                        wrapper.dataset.value = e.target.dataset.value;
                        saveAndExitEditMode(row);
                    }
                });
            } else { // It's a regular text field
                if (span.textContent === placeholder) { span.textContent = ''; }
                span.setAttribute('contenteditable', 'true');
            }
        });
        const firstEditable = row.querySelector('[contenteditable="true"], .custom-select-trigger, input[type="date"]');
        if (firstEditable) firstEditable.focus();
    }
    
    
    function saveAndExitEditMode(row) {
    if (!row || row.dataset.editing !== 'true') return;
    row.removeAttribute('data-editing');
    const id = row.dataset.id;
    const type = row.closest('table').id.includes('review-table') ? 'review' : 'main';
    const placeholder = 'Data not Added';

    const processField = (key, newValue) => {
        if (type === 'review') {
            const tableType = row.closest('table').id.includes('matched') ? 'matched' : 'unique';
            const record = reviewState[tableType].find(r => r.id === id);
            if (record) record[key] = newValue;
        }

        if (key === 'Department') {
            const responsibilitySpan = row.querySelector('[data-derived-from="Department"] span');
            if (responsibilitySpan) {
                const respValue = newValue || placeholder;
                responsibilitySpan.textContent = respValue;
                responsibilitySpan.classList.toggle('data-not-added', respValue === placeholder);
            }
        }
    };

    // Handle date inputs
    row.querySelectorAll('input[type="date"][data-key]').forEach(dateInput => {
        const key = dateInput.dataset.key;
        const newValue = dateInput.value;
        processField(key, newValue);

        const newSpan = document.createElement('span');
        newSpan.dataset.key = key;
        if (newValue) {
            newSpan.textContent = newValue;
        } else {
            newSpan.textContent = placeholder;
            newSpan.classList.add('data-not-added');
        }
        dateInput.replaceWith(newSpan);
    });

    // Handle custom select dropdowns
    row.querySelectorAll('.custom-select-wrapper').forEach(wrapper => {
        const key = wrapper.dataset.key;
        const newValue = wrapper.dataset.value;
        processField(key, newValue);

        const newSpan = document.createElement('span');
        newSpan.dataset.key = key;
        newSpan.textContent = newValue;
        if (predefinedOptions[key] && !predefinedOptions[key].includes(newValue)) {
            newSpan.classList.add('invalid-data');
        }
        wrapper.replaceWith(newSpan);
    });

    // Handle contenteditable spans
    row.querySelectorAll('span[contenteditable="true"]').forEach(span => {
        span.setAttribute('contenteditable', 'false');
        const key = span.dataset.key;
        // alert(key);
        const newValue = span.textContent.trim();
        // alert(newValue);
        processField(key, newValue);
        if (!newValue) {
            span.textContent = placeholder;
            span.classList.add('data-not-added');
        } else {
            span.classList.remove('data-not-added');
        }
    });

    // ✅ Collect updated data for AJAX
    // const updatedData = {};
    // row.querySelectorAll('[data-key]').forEach(el => {
    //     const key = el.dataset.key;
    //     let value = el.textContent?.trim() || el.value || '';
    //     if (el.tagName === 'SPAN' && el.classList.contains('data-not-added')) value = null;
    //     updatedData[key] = value;
    // });
    
    
    const updatedData = {};
    row.querySelectorAll('[data-key]').forEach(el => {
        let key = el.dataset.key;
        let value = el.textContent?.trim() || el.value || '';
        if (el.tagName === 'SPAN' && el.classList.contains('data-not-added')) value = null;
    
        // Replace empty key with 'FoodHandler'
        if (key === '') {
            key = 'FoodHandler';
        }
    
        updatedData[key] = value;
    });

    
console.log(row);
    // Include ID for DB update
    // ✅ Send data to server via AJAX
    fetch("{{ route('updateEmployee') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(updatedData)
    })
    .then(res => res.json())
    .then(res => {
        if (!res.success) {
            alert("Failed to update: " + res.message);
        }
    })
    .catch(err => {
        console.error('Update error:', err);
        alert("An error occurred while updating.");
    });

    // Continue existing update logic
    const updatedTimestamp = new Date();
    const updatedTimestampSpan = row.querySelector('span[data-key="lastUpdated"]');
    if (updatedTimestampSpan) updatedTimestampSpan.textContent = formatDateTime(updatedTimestamp);
    const employeeName = row.querySelector('.employee-info .name')?.textContent || 'record';
    showUpdateMessage(`Employee "${employeeName}" updated.`);
    row.classList.add('row-updated');
    row.addEventListener('animationend', () => row.classList.remove('row-updated'), { once: true });
    updateLastUpdated();
}


   
    // --- Status Slider Modal Logic ---
    function setupStatusToggles(container) { /* Unchanged */
        container.querySelectorAll('.status-toggle').forEach(toggle => {
            
          
            toggle.addEventListener('click', (e) => {
                if (e.target.closest('tr[data-editing="true"]')) return;
                e.preventDefault();
                activeToggle = e.currentTarget;
                const row = activeToggle.closest('tr');
                const employeeName = row.querySelector('.employee-info .name').textContent;
                const isBecomingActive = !activeToggle.checked;
                modalTitle.textContent = isBecomingActive ? `Activate ${employeeName}?` : `Deactivate ${employeeName}?`;
                statusModal.classList.add('visible');
            });
        });
    }
    function confirmStatusChange() { if (!activeToggle) return; activeToggle.checked = !activeToggle.checked; const row = activeToggle.closest('tr'); const updatedTimestampSpan = row.querySelector('span[data-key="lastUpdated"]'); if (updatedTimestampSpan) updatedTimestampSpan.textContent = formatDateTime(new Date()); closeStatusModal(); showUpdateMessage(`Status updated successfully.`); updateLastUpdated(); }
    function closeStatusModal() { statusModal.classList.remove('visible'); activeToggle = null; }
    
    // --- Pagination & Filter Logic ---
    function updatePaginationControls(totalRows) { /* Unchanged */
        paginationList.innerHTML = '';
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        if (totalPages <= 1) return;

        const prevLi = document.createElement('li');
        prevLi.innerHTML = `<a href="#" data-page="prev">«</a>`;
        if (currentPage === 1) prevLi.classList.add('disabled');
        paginationList.appendChild(prevLi);

        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement('li');
            if (i === currentPage) pageLi.classList.add('active');
            pageLi.innerHTML = `<a href="#" data-page="${i}">${i}</a>`;
            paginationList.appendChild(pageLi);
        }
        const nextLi = document.createElement('li');
        nextLi.innerHTML = `<a href="#" data-page="next">»</a>`;
        if (currentPage === totalPages) nextLi.classList.add('disabled');
        paginationList.appendChild(nextLi);
    }
    
   function renderMainTablePage() {
    $.ajax({
        url: '{{ route("usermanagementlist") }}',
        method: 'GET',
        data: {
            page: currentPage,
        },
        success: function(response) {
            currentRecipeUsageData = response.data; // Save paginated rows
            mainTableBody.innerHTML = ''; // Clear current rows

            if (response.data.length > 0) {
    response.data.forEach((recipe, index) => {
        const rowHtml = `
            <tr>
                <td><input type="checkbox" class="recipe-checkbox" value="${recipe.id}"></td>
                <td>
    <div class="cell-stack">
        ${recipe.corporateName ? `
            <div class="label"><span data-key="Corporate" class="invalid-data">${recipe.corporateName}</span></div>
        ` : ''}

        ${recipe.regionalName ? `
            <div class="sub-label"><span data-key="Regional" class="invalid-data">${recipe.regionalName}</span></div>
        ` : ''}

        ${recipe.unitName ? `
            <div class="sub-label"><span data-key="Unit" class="invalid-data">${recipe.unitName}</span></div>
        ` : ''}
    </div>
</td>

                <td>
                    <div class="employee-cell">
                        <div class="avatar">MR</div>
                        <div class="employee-info">
                            <span class="name" data-key="Name">${recipe.employer_fullname ?? ''}</span>
                            <div class="employee-details">
                                <span data-key="id-display">
                                    <i class="bx bxs-id-card"></i> ID: <span data-key="ID">${recipe.employe_id ?? ''}</span>
                                </span>
                                <span>
                                    <i class="bx bx-male-female"></i> <span data-key="Gender">${recipe.gender ?? ''}</span>
                                </span>
                                <span>
                                    <i class="bx bx-calendar"></i> Joined: <span data-key="JoinedDate">${recipe.dog ?? ''}</span>
                                </span>
                                <span>
                                    <i class="bx bx-cake"></i> Born: <span data-key="BirthDate">${recipe.dob ?? ''}</span>
                                </span>
                                <span class="row-last-updated">
                                    <i class="bx bx-time"></i> Updated: <span data-key="lastUpdated">${recipe.update_at ?? ''}</span>
                                </span>
                                <span class="edit_id" data-key="edit_id">${recipe.id ?? ''}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell-stack">
                        <div class="sub-label">
                            <i class="bx bx-envelope"></i> 
                            <span data-key="Email" class="data-not-added">${recipe.email ?? ''}</span>
                        </div>
                        <div class="sub-label">
                            <i class="bx bx-phone"></i> 
                            <span data-key="Phone" class="data-not-added">${recipe.contact_number ?? ''}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell-stack">
                        <div class="label"><span data-key="Department" class="invalid-data">${recipe.department ?? ''}</span></div>
                        <div class="sub-label"><span data-key="Role" class="invalid-data">Staff</span></div>
                        <div class="sub-label" data-derived-from="Department">Responsibility: <span>${recipe.responsibility_id ?? ''}</span></div>
                    </div>
                </td>
                <td>
                    <div class="cell-stack">
                        <div class="label"><span data-key="Category" class="invalid-data">${recipe.staff_category ?? ''}</span></div>
                        <div class="sub-label">Food Handler: <span data-key="FoodHandler">${recipe.cat_name ?? ''}</span></div>
                    </div>
                </td>
                <td>
                    <div class="action-cell">
                        <label class="status-slider">
                            <input type="checkbox" class="status-toggle" data-id="${recipe.id}" ${recipe.status === '1' ? 'checked' : ''}>
                            <span class="slider-track"></span>
                        </label>
                        <a href="/admin/public/index.php/unit_user-deletes/${recipe.id}" onclick="return confirm('Are you sure?')">
                            <i class="bx bxs-trash font-20"></i>
                        </a>
                    </div>
                </td>
            </tr>`;
        mainTableBody.insertAdjacentHTML('beforeend', rowHtml);
    });

    paginationInfo.textContent = `Showing ${response.from} to ${response.to} of ${response.total} entries`;
    updatePaginationControls(response.total, response.last_page);
} else {
    paginationInfo.textContent = 'No entries match your filter';
    mainTableBody.innerHTML = `<tr><td colspan="2" class="text-center">No data found.</td></tr>`;
    updatePaginationControls(0, 1);
}

        },
        error: function() {
            alert('Failed to load data.');
        }
    });
}
    function applyFilters() { /* Unchanged */
        const selectedEmployeeIds = Array.from(employeeFilterList.querySelectorAll('input:not(#filter-select-all):checked')).map(cb => cb.dataset.id);
        const selectedGenders = Array.from(document.querySelectorAll('#filter-gender-group input:checked')).map(cb => cb.value);
        const dojFrom = document.getElementById('filter-doj-from').value;
        const dojTo = document.getElementById('filter-doj-to').value;
        const dobFrom = document.getElementById('filter-dob-from').value;
        const dobTo = document.getElementById('filter-dob-to').value;
        const dojFromDate = dojFrom ? new Date(dojFrom) : null;
        const dojToDate = dojTo ? new Date(dojTo) : null;
        const dobFromDate = dobFrom ? new Date(dobFrom) : null;
        const dobToDate = dobTo ? new Date(dobTo) : null;
        if (dojToDate) dojToDate.setDate(dojToDate.getDate() + 1);
        if (dobToDate) dobToDate.setDate(dobToDate.getDate() + 1);
        mainTableBody.querySelectorAll('tr').forEach(row => {
            const rowEmployeeId = row.querySelector('span[data-key="ID"]')?.textContent || '';
            const gender = row.querySelector('span[data-key="Gender"]')?.textContent || '';
            const joinedDate = row.querySelector('span[data-key="JoinedDate"]')?.textContent ? new Date(row.querySelector('span[data-key="JoinedDate"]').textContent) : null;
            const birthDate = row.querySelector('span[data-key="BirthDate"]')?.textContent ? new Date(row.querySelector('span[data-key="BirthDate"]').textContent) : null;
            let isVisible = true;
            if (selectedEmployeeIds.length > 0 && !selectedEmployeeIds.includes(rowEmployeeId)) isVisible = false;
            if (isVisible && selectedGenders.length > 0 && !selectedGenders.includes(gender)) isVisible = false;
            if (isVisible && (dojFromDate || dojToDate)) { if (!joinedDate) { isVisible = false; } else { if (dojFromDate && joinedDate < dojFromDate) isVisible = false; if (dojToDate && joinedDate >= dojToDate) isVisible = false; } }
            if (isVisible && (dobFromDate || dobToDate)) { if (!birthDate) { isVisible = false; } else { if (dobFromDate && birthDate < dobFromDate) isVisible = false; if (dobToDate && birthDate >= dobToDate) isVisible = false; } }
            row.dataset.filteredOut = isVisible ? 'false' : 'true';
        });
        currentPage = 1;
        updateActiveFilterTags();
        renderMainTablePage();
        const activeFilterCount = activeFiltersContainer.children.length;
        filterIcon.classList.toggle('active', activeFilterCount > 0);
    }
    
    function updateActiveFilterTags() { /* Unchanged */
        activeFiltersContainer.innerHTML = '';
        const createTag = (type, value, removeAction) => {
            const tag = document.createElement('div');
            tag.className = 'filter-tag';
            tag.innerHTML = `<span>${type}: <strong>${value}</strong></span>`;
            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-tag';
            removeBtn.innerHTML = '×';
            removeBtn.title = 'Remove filter';
            removeBtn.addEventListener('click', removeAction);
            tag.appendChild(removeBtn);
            activeFiltersContainer.appendChild(tag);
        };
        const selectedEmployeeIds = Array.from(employeeFilterList.querySelectorAll('input:not(#filter-select-all):checked'));
        if (selectedEmployeeIds.length > 0) {
            createTag('Employees', `${selectedEmployeeIds.length} selected`, () => {
                selectedEmployeeIds.forEach(cb => cb.checked = false);
                applyFilters();
            });
        }
        const selectedGenders = Array.from(document.querySelectorAll('#filter-gender-group input:checked'));
        selectedGenders.forEach(cb => { createTag('Gender', cb.value, () => { cb.checked = false; applyFilters(); }); });
        const dojFrom = document.getElementById('filter-doj-from');
        const dojTo = document.getElementById('filter-doj-to');
        if (dojFrom.value || dojTo.value) { createTag('Joined', `${dojFrom.value || '...'} to ${dojTo.value || '...'}`, () => { dojFrom.value = ''; dojTo.value = ''; applyFilters(); }); }
        const dobFrom = document.getElementById('filter-dob-from');
        const dobTo = document.getElementById('filter-dob-to');
        if (dobFrom.value || dobTo.value) { createTag('Born', `${dobFrom.value || '...'} to ${dobTo.value || '...'}`, () => { dobFrom.value = ''; dobTo.value = ''; applyFilters(); }); }
    }
    
    function populateEmployeeFilterDropdown() { /* Unchanged */
        const existingCheckboxes = Array.from(employeeFilterList.querySelectorAll('input:not(#filter-select-all):checked')).map(cb => cb.dataset.id);
        employeeFilterList.innerHTML = ''; 
        const selectAllLabel = document.createElement('label');
        selectAllLabel.className = 'select-all-label';
        const selectAllCheckbox = document.createElement('input');
        selectAllCheckbox.type = 'checkbox';
        selectAllCheckbox.id = 'filter-select-all';
        selectAllLabel.appendChild(selectAllCheckbox);
        selectAllLabel.append(' Select / Deselect All');
        employeeFilterList.appendChild(selectAllLabel);
        const employees = [];
        mainTableBody.querySelectorAll('tr').forEach(row => {
            const name = row.querySelector('.name[data-key="Name"]')?.textContent || 'N/A';
            const id = row.querySelector('span[data-key="ID"]')?.textContent || 'N/A';
            if(id !== 'N/A') employees.push({name, id});
        });
        employees.sort((a,b) => a.name.localeCompare(b.name)).forEach(emp => {
            const label = document.createElement('label');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.dataset.id = emp.id;
            if(existingCheckboxes.includes(emp.id)) { checkbox.checked = true; }
            label.appendChild(checkbox);
            label.append(` ${emp.name} (${emp.id})`);
            employeeFilterList.appendChild(label);
        });
        const allEmployeeCheckboxes = employeeFilterList.querySelectorAll('input:not(#filter-select-all)');
        selectAllCheckbox.checked = allEmployeeCheckboxes.length > 0 && Array.from(allEmployeeCheckboxes).every(cb => cb.checked);
    }

    function clearFilters() { /* Unchanged */
        employeeFilterSearch.value = '';
        document.querySelectorAll('.filter-dropdown input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('.filter-dropdown input[type="date"]').forEach(input => input.value = '');
        applyFilters();
        filterDropdown.style.display = 'none';
    }


    // --- Event Listeners ---
    document.addEventListener('click', (e) => { /* Unchanged */
        const editingRow = document.querySelector('tr[data-editing="true"]');
        if (editingRow && !editingRow.contains(e.target)) { saveAndExitEditMode(editingRow); }
        document.querySelectorAll('.custom-select-panel.open').forEach(panel => { if (!panel.closest('.custom-select-wrapper').contains(e.target)) { panel.classList.remove('open'); } });
        const icon = e.target.closest('.icon-reject, .icon-accept-match, .action-cell .fa-trash-alt');
        if (icon) {
            const row = icon.closest('tr'); if (row.dataset.editing === 'true') return;
            if (icon.classList.contains('fa-trash-alt')) { row.remove(); showUpdateMessage('Employee removed.'); applyFilters(); updateLastUpdated(); return; }
            const id = row.dataset.id; const type = row.closest('table').id.includes('matched') ? 'matched' : 'unique';
            if (icon.classList.contains('icon-reject')) { reviewState[type] = reviewState[type].filter(emp => emp.id !== id); renderReviewTables(); showUpdateMessage(`Record ${id} rejected.`); } 
            else if (icon.classList.contains('icon-accept-match')) { const recordToMove = reviewState.matched.find(emp => emp.id === id); if (recordToMove) { reviewState.matched = reviewState.matched.filter(emp => emp.id !== id); reviewState.unique.push(recordToMove); renderReviewTables(); showUpdateMessage(`Record ${id} moved to 'New Records'.`); } }
        }
        if (filterDropdown.style.display === 'block' && !filterDropdown.contains(e.target) && !e.target.matches('.filter-icon')) {
             filterDropdown.style.display = 'none';
        }
    });
    document.addEventListener('dblclick', (e) => { /* Unchanged */
        const row = e.target.closest('#main-employee-table tbody tr, #review-container tbody tr');
        if (row) {
            const currentlyEditing = document.querySelector('tr[data-editing="true"]');
            if (currentlyEditing && currentlyEditing !== row) { saveAndExitEditMode(currentlyEditing); }
            enterEditMode(row);
        }
    });

    // --- New Employee Modal Logic ---
    function openNewEmployeeModal() { /* Unchanged */

        newEmployeeModal.classList.add('visible');
    }
   
    

    // --- Bulk Actions & Button Listeners ---
    addManualBtn.addEventListener('click', openNewEmployeeModal);
    document.getElementById('discard-matched-btn').addEventListener('click', () => { reviewState.matched = []; renderReviewTables(); });
    document.getElementById('acknowledge-matched-btn').addEventListener('click', () => { console.log("Acknowledged:", reviewState.matched); reviewState.matched = []; renderReviewTables(); });
    document.getElementById('discard-unique-btn').addEventListener('click', () => { reviewState.unique = []; renderReviewTables(); });
    // document.getElementById('add-unique-btn').addEventListener('click', () => { /* Unchanged */
    //     if(reviewState.unique.length === 0) return;
    //     const newRowsHTML = reviewState.unique.map(emp => createMainTableRowHTML({ ...emp, lastUpdated: new Date() })).join('');
    //     mainTableBody.insertAdjacentHTML('beforeend', newRowsHTML);
    //     setupStatusToggles(mainTableBody);
    //     showUpdateMessage(`Successfully added ${reviewState.unique.length} new employee(s).`);
    //     reviewState.unique = []; renderReviewTables();
    //     applyFilters();
    //     updateLastUpdated();
    // });
    
    
    document.getElementById('add-unique-btn').addEventListener('click', () => {
        
    if (reviewState.unique.length === 0) return;

    // 1. Send to DB via AJAX
    fetch("{{ route('importUserManagementData') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            employees: reviewState.unique
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            console.log(data.message); // Optional success message
        } else {
            alert("DB save failed: " + data.message);
        }
    })
    .catch(err => {
        console.error('DB save error', err);
        alert("Something went wrong while saving to database.");
    });

    // 2. Existing unchanged DOM logic
    const newRowsHTML = reviewState.unique.map(emp => createMainTableRowHTML({ ...emp, lastUpdated: new Date() })).join('');
    mainTableBody.insertAdjacentHTML('beforeend', newRowsHTML);
    setupStatusToggles(mainTableBody);
    showUpdateMessage(`Successfully added ${reviewState.unique.length} new employee(s).`);
    reviewState.unique = [];
    renderReviewTables();
    applyFilters();
    updateLastUpdated();
});

    
    // --- CSV & XLSX Logic ---
    const handleDownloadCSV = () => { /* Unchanged */
        const headers = ["Corporate", "Regional", "Unit", "Name", "ID", "Gender", "JoinedDate", "BirthDate", "Email", "Phone", "Department", "Role", "Category", "FoodHandler"];
        const csvContent = "data:text/csv;charset=utf-8," + headers.join(',') + '\n';
        const link = document.createElement("a"); link.setAttribute("href", encodeURI(csvContent)); link.setAttribute("download", "employee_data_template.csv");
        document.body.appendChild(link); link.click(); document.body.removeChild(link);
        showUpdateMessage('Sample CSV template downloaded!');
    };
    function parseCsvLine(line) { /* Unchanged */
        const fields = []; let currentField = ''; let inQuotes = false;
        for (let i = 0; i < line.length; i++) { const char = line[i]; if (char === '"' && (i === 0 || line[i - 1] !== '\\')) { inQuotes = !inQuotes; } else if (char === ',' && !inQuotes) { fields.push(currentField); currentField = ''; } else { currentField += char; } }
        fields.push(currentField); return fields.map(f => f.replace(/^"|"$/g, '').replace(/\\"/g, '"'));
    }
    function parseAndFormatDate(dateString) { /* Unchanged */
        if (!dateString) return '';
        const dateRegexes = [ /(?<year>\d{4})-(?<month>\d{1,2})-(?<day>\d{1,2})/, /(?<day>\d{1,2})-(?<month>\d{1,2})-(?<year>\d{4})/, /(?<month>\d{1,2})\/(?<day>\d{1,2})\/(<year>\d{4})/ ];
        for (const regex of dateRegexes) { const match = regex.exec(dateString); if (match) { const { year, month, day } = match.groups; const date = new Date(year, month - 1, day); if (!isNaN(date)) { const y = date.getFullYear(); const m = String(date.getMonth() + 1).padStart(2, '0'); const d = String(date.getDate()).padStart(2, '0'); return `${y}-${m}-${d}`; } } }
        return dateString;
    }
    const processAndDisplayUpload = (uploadedData) => { /* Unchanged */
        const existingEmployees = Array.from(document.querySelectorAll('#main-employee-table [data-key="ID"]')).map(el => ({ name: el.closest('.employee-info').querySelector('.name').textContent.trim(), id: el.textContent.trim() }));
        reviewState = { matched: [], unique: [] };
        uploadedData.forEach((newEmp, index) => {
            if (newEmp.JoinedDate) newEmp.JoinedDate = parseAndFormatDate(newEmp.JoinedDate);
            if (newEmp.BirthDate) newEmp.BirthDate = parseAndFormatDate(newEmp.BirthDate);
            newEmp.id = newEmp.ID || `temp-${Date.now()}-${index}`;
            newEmp.lastUpdated = new Date();
            let bestMatch = { found: false, score: 0 };
            existingEmployees.forEach(existingEmp => { const nameSim = jaroWinkler(newEmp.Name.toLowerCase(), existingEmp.name.toLowerCase()); const idSim = jaroWinkler(newEmp.ID, existingEmp.id); const score = Math.max(nameSim, idSim); if (score > 0.90 && score > bestMatch.score) { bestMatch = { found: true, score: score }; } });
            if (bestMatch.found) { newEmp.similarity = bestMatch.score; reviewState.matched.push(newEmp); } else { reviewState.unique.push(newEmp); }
        });
        if (reviewState.matched.length === 0 && reviewState.unique.length === 0) { showUpdateMessage("No data to review."); return; }
        renderReviewTables();
        mainContainer.style.display = 'none';
        reviewContainer.style.display = 'block';
        window.scrollTo(0, 0);
    };
    const handleFileUpload = (event) => { /* Unchanged */
        const file = event.target.files[0]; if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            const lines = e.target.result.trim().split(/\r?\n/);
            if (lines.length < 2) { showUpdateMessage("CSV is empty or invalid.", 5000); return; }
            const headers = parseCsvLine(lines[0]);
            const uploadedData = lines.slice(1).map(line => {
                const values = parseCsvLine(line);
                return headers.reduce((obj, header, index) => { obj[header.trim()] = values[index] ? values[index].trim() : ''; return obj; }, {});
            });
            processAndDisplayUpload(uploadedData);
        };
        reader.readAsText(file);
        csvUploadInput.value = '';
    };

    // --- Final Event Listener Setup ---
    csvUploadInput.addEventListener('change', handleFileUpload);
    downloadCsvBtn.addEventListener('click', handleDownloadCSV);
    downloadXlsxBtn.addEventListener('click', () => { /* Unchanged */
        const dataToExport = Array.from(mainTableBody.querySelectorAll('tr')).map(row => {
            const getCellText = (selector) => row.querySelector(selector)?.textContent.trim() || '';
            return {
                "Corporate": getCellText('span[data-key="Corporate"]'),
                "Regional": getCellText('span[data-key="Regional"]'),
                "Unit": getCellText('span[data-key="Unit"]'),
                "Name": getCellText('.name[data-key="Name"]'),
                "ID": getCellText('span[data-key="ID"]'),
                "Gender": getCellText('span[data-key="Gender"]'),
                "Joined Date": getCellText('span[data-key="JoinedDate"]'),
                "Birth Date": getCellText('span[data-key="BirthDate"]'),
                "Email": getCellText('span[data-key="Email"]'),
                "Phone": getCellText('span[data-key="Phone"]'),
                "Department": getCellText('span[data-key="Department"]'),
                "Role": getCellText('span[data-key="Role"]'),
                "Responsibility": getCellText('[data-derived-from="Department"] span'),
                "Category": getCellText('span[data-key="Category"]'),
                "Food Handler": getCellText('span[data-key="FoodHandler"]'),
                "Status": row.querySelector('.status-toggle')?.checked ? 'Active' : 'Inactive',
                "Last Updated": getCellText('span[data-key="lastUpdated"]')
            };
        });
        const worksheet = XLSX.utils.json_to_sheet(dataToExport);
        const colWidths = Object.keys(dataToExport[0] || {}).map(key => ({ wch: Math.max(key.length, ...dataToExport.map(row => row[key]?.length || 0)) + 2 }));
        worksheet['!cols'] = colWidths;
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Employee Roster");
        XLSX.writeFile(workbook, "Employee_Roster.xlsx");
        showUpdateMessage("Excel file download initiated.");
    });
    modalConfirmBtn.addEventListener('click', confirmStatusChange);
    modalCancelBtn.addEventListener('click', closeStatusModal);
    statusModal.addEventListener('click', (e) => { if (e.target === statusModal) closeStatusModal(); });
   
   

    // Pagination Listeners
    rowsPerPageSelect.addEventListener('change', (e) => { rowsPerPage = parseInt(e.target.value, 10); currentPage = 1; renderMainTablePage(); });
    paginationList.addEventListener('click', (e) => {
        alert("hello");
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link || link.parentElement.classList.contains('disabled')) return;
        const page = link.dataset.page;
        if (page === 'prev') { if (currentPage > 1) currentPage--; } 
        else if (page === 'next') { const totalRows = mainTableBody.querySelectorAll('tr:not([data-filtered-out="true"])').length; const totalPages = Math.ceil(totalRows / rowsPerPage); if (currentPage < totalPages) currentPage++; } 
        else { currentPage = parseInt(page, 10); }
        renderMainTablePage();
    });

    // --- Filter Listeners ---
    filterIcon.addEventListener('click', (e) => { /* Unchanged */
        e.stopPropagation();
        const isOpening = filterDropdown.style.display !== 'block';
        if (isOpening) { populateEmployeeFilterDropdown(); }
        filterDropdown.style.display = isOpening ? 'block' : 'none';
    });
    clearFiltersBtn.addEventListener('click', clearFilters);
    employeeFilterSearch.addEventListener('input', () => { /* Unchanged */
        const searchTerm = employeeFilterSearch.value.toLowerCase();
        let resultsFound = false;
        employeeFilterList.querySelectorAll('label:not(.select-all-label)').forEach(label => {
            const labelText = label.textContent.toLowerCase();
            const shouldShow = labelText.includes(searchTerm);
            label.style.display = shouldShow ? 'flex' : 'none';
            if(shouldShow) resultsFound = true;
        });
        noEmployeeResultsMsg.style.display = resultsFound ? 'none' : 'block';
    });
    filterDropdown.addEventListener('change', (e) => { /* Unchanged */
        if (e.target.matches('input[type="checkbox"], input[type="date"]')) {
            if(e.target.id === 'filter-select-all') {
                const isChecked = e.target.checked;
                employeeFilterList.querySelectorAll('input:not(#filter-select-all)').forEach(cb => cb.checked = isChecked);
            } else {
                const allCheckboxes = employeeFilterList.querySelectorAll('input:not(#filter-select-all)');
                document.getElementById('filter-select-all').checked = allCheckboxes.length > 0 && Array.from(allCheckboxes).every(cb => cb.checked);
            }
            applyFilters();
        }
    });

    // Initial setup
    setupStatusToggles(mainTableBody);
    renderMainTablePage();
    updateLastUpdated();
});
</script>


































 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    @if($errors->any())
<script>
    $(document).ready(function() {
    $('#addcompanydetails').modal('show');
});
     </script>
@endif




<script type="text/javascript">
    function add_location(id){
$("#department_id").val(id);
       $('#add_location').modal('show');
    }
	
	
	    function add_sublocation(id){
$("#location_id").val(id);
       $('#add_sublocation').modal('show');
    }
	
	
	
	var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
var collapseList = collapseElementList.map(function (collapseEl) {
    collapseEl.addEventListener('hidden.bs.collapse', function () {
        let children = this.querySelectorAll('.collapse.show');
        children.forEach((c)=>{
            var collapse = bootstrap.Collapse.getInstance(c)
            collapse.hide()
        })
    })
})



    function add_unit(id){
$("#company_id").val(id);
       $('#add_unit').modal('show');
    }
	
	
	    function add_regional(id){
$("#add_regional_id").val(id);
       $('#add_regional').modal('show');
    }
	
	@if(session()->has('add_authority'))
		  $(".test").addClass("testitem");

		@endif
	
</script>

									<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
										
										
									
										
	/****************** Delete All User Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclick').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxvalue").prop('checked', true);    
         } else {    
            $(".checkboxvalue").prop('checked',false);    
         }    
        }); 
  $("#delbutton1").click(function(){
         if (confirm("Are you sure you want to Delete Users!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_companydetails') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxvalue:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='company_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All User Details ****************/
										
										
										
											/****************** Delete All Department Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickdepartment').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxdepartmentvalue").prop('checked', true);    
         } else {    
            $(".checkboxdepartmentvalue").prop('checked',false);    
         }    
        }); 
  $("#delbuttondepartment").click(function(){
         if (confirm("Are you sure you want to Delete Department!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxdepartmentvalue:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_departments') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxdepartmentvalue:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='department_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All Department Details ****************/
										
										
										
										
																		
											/****************** Delete All responsibility Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickresponsibility').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxvalueresponsibility").prop('checked', true);    
         } else {    
            $(".checkboxvalueresponsibility").prop('checked',false);    
         }    
        }); 
  $("#delbuttonresponsibility").click(function(){
         if (confirm("Are you sure you want to Delete Responsibility!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxvalueresponsibility:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_responsibility') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxvalueresponsibility:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='responsibility_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All responsibility Details ****************/
										
										
										
	/****************** Delete All User Managment Details ****************/

$(document).ready(function(){
	
										  $('.checkboxclickusermanagment').on('click', function(e) {  
         if($(this).is(':checked',true))    
         {  
            $(".checkboxvalueusermanagment").prop('checked', true);    
         } else {    
            $(".checkboxvalueusermanagment").prop('checked',false);    
         }    
        }); 
  $("#delbuttonusermanagment").click(function(){
         if (confirm("Are you sure you want to Delete Users!")) {
          $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      
		 
			   var ids = [];    
            $(".checkboxvalueusermanagment:checked").each(function() {    
                ids.push($(this).val());  
            });

   if(ids.length <=0)    
            {    
                alert("Please select row.");    
            }  else {
				
				         
                  $.ajax({  
                      url:"{{ route('delete_all_usermanagment') }}",
                        type: 'DELETE',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:ids}, 
                        success: function (data) {  
                            if (data['success']) {  
                                $(".checkboxvalueusermanagment:checked").each(function() {    
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
                      $('table tr').filter("[data-row-id='usermanagment_detailss_" + value + "']").remove();  
                  });
			}       
         }

  });
});

	/****************** End Delete All User Managment Details ****************/
</script>

									
  


<script type="text/javascript">

$('.corporate_id').change(function(){ 
    var id = $(this).val();
	

	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.regional_id').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.regional_id').append(selOpts);
           }
        });
});
	
	
	
	
$('.regional_id').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.hotel_name').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('.hotel_name').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
 
	
	$('.mydepartment').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('.mydepartment1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('.mydepartment1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});




</script>



<script>
$(document).ready(function() {
    $('.input-switch').change(function() {
        var checkboxId = $(this).attr('id');
        var isChecked = $(this).is(':checked');
        var status = isChecked ? '1' : '0';
              $("#unit_id").val(checkboxId);
              $("#topic_id").val(status);
$('#changestatus').modal('show');


    });
});
</script>

<script>
    $(document).ready(function () {
        // On change of the dropdown
        $('.status-dropdown').on('change', function () {

            let selectedValue = $(this).val(); // Get selected value
            if (selectedValue == '3') {
                // If "Left" is selected
                $('.hidebox').show(); // Hide elements with hidebox class
            } else {
                // Otherwise, show them
                $('.hidebox').hide();
            }
        });
    });
</script>
<script>
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('delete-employee')) {
        const id = e.target.dataset.id;

        if (!id) return;

        if (confirm('Are you sure you want to delete this employee?')) {
            const url = "{{ route('DeleteEmployee', ':id') }}".replace(':id', id);

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    e.target.closest('tr').remove();
                    alert('Deleted successfully');
                } else {
                    alert('Delete failed: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Server error.');
            });
        }
    }
});
</script>





<script>
let lastStatus = {};
let activeToggle = null;
let requestedStatus = null;

$(document).on('change', '.status-toggle', function () {
    const checkbox = this;
    const recipeId = $(checkbox).data('id');
    const isChecked = $(checkbox).is(':checked');
    const wasChecked = lastStatus[recipeId] !== undefined ? lastStatus[recipeId] : !isChecked;
    activeToggle = checkbox;
    requestedStatus = isChecked ? 1 : 0;
    $("#edit_row").val(recipeId);
    if (wasChecked && !isChecked) {
        $('#modal-comments').val('');
        $('#status-modal111').fadeIn(); // Display modal
    } else {
        
               
                  $.ajax({  
                      url:"{{ route('activateupdateStatus') }}",
                        type: 'POST',  
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                       data:{ ids:recipeId}, 
                        success: function (data) {  
                              
                        },  
                        error: function (data) {  
                            alert(data.responseText);  
                        }  
                    });  
                    
                    
        
        lastStatus[recipeId] = isChecked;
        showUpdateMessage("Status updated.");
        updateLastUpdated(recipeId);
    }
});


$(document).ready(function () {
    $('#modal-cancel').on('click', function () {
        $('#status-modal111').fadeOut();
    });
});








</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>

<script type="text/javascript">
      

  
	

$('#mySelect').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_list') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mySelect1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mySelect1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
	
	
	
	
$('#mySelect1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('regional_unitlist') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mySelect2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['company_name'];
                selOpts += "<option value='"+val+"'>"+val+"</option>";
            }
            $('#mySelect2').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});
 
	
	$('#mydepartment').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('department_location') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mydepartment1').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mydepartment1').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});

		$('#mydepartment1').change(function(){ 
    var id = $(this).val();
	        $.ajax({
           type:'GET',
           url:"{{ route('location_sublocation') }}",
           data:{id:id},
				dataType: "json",
           success:function(datalist){
          var data =  datalist.data;
					$('#mydepartment2').empty();
					           var selOpts = "";
            for (i=0;i<data.length;i++)
            {
                var id = data[i]['id'];
                var val = data[i]['name'];
                selOpts += "<option value='"+id+"'>"+val+"</option>";
            }
            $('#mydepartment2').append(selOpts);
                    //alert(data.success);
                    //location.reload();
             
           }
        });
});

</script>


   