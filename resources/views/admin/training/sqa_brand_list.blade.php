
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Name Manager</title>
    <!-- Google Fonts and Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        :root {
            --primary-color: #2563eb; /* Modern blue */
            --primary-hover-color: #1d4ed8;
            --primary-light-color: #dbeafe;
            --secondary-color: #f8fafc;
            --text-color: #334155;
            --text-light-color: #64748b;
            --text-lighter-color: #94a3b8;
            --border-color: #e2e8f0;
            --border-light-color: #f1f5f9;
            --white-color: #ffffff;
            --danger-color: #ef4444;
            --danger-hover-color: #dc2626;
            --danger-light-color: #fee2e2;
            --success-color: #10b981;
            --success-hover-color: #059669;
            --success-light-color: #d1fae5;
            --warning-color: #f59e0b;
            --warning-light-color: #fef3c7;
            --info-color: #3b82f6;
            --info-light-color: #dbeafe;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--secondary-color);
            margin: 0;
            padding: 0;
            color: var(--text-color);
            line-height: 1.5;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .app-container {
            width: 100%;
            /*max-width: 1200px;*/
            padding: 1.5rem;
        }
        
        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light-color);
        }

        .app-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .app-title .material-icons {
            font-size: 2rem;
        }
        
        .main-actions {
            display: flex;
            gap: 0.75rem;
        }

        button {
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 6px;
            background-color: var(--primary-color);
            color: var(--white-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--card-shadow);
        }

        button:disabled { 
            background-color: #cbd5e1; 
            cursor: not-allowed; 
            box-shadow: none; 
            opacity: 0.7;
        }
        
        button:hover:not(:disabled) { 
            background-color: var(--primary-hover-color); 
            transform: translateY(-1px);
        }
        
        .button-secondary { 
            background-color: var(--white-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }
        
        .button-secondary:hover:not(:disabled) { 
            background-color: #f8fafc; 
            transform: translateY(-1px);
        }
        
        .button-success { 
            background-color: var(--success-color); 
        }
        
        .button-success:hover:not(:disabled) { 
            background-color: var(--success-hover-color);
        }
        
        .button-danger {
            background-color: var(--danger-color);
        }

        .button-danger:hover:not(:disabled) {
            background-color: var(--danger-hover-color);
        }

        .button-link { 
            background: none; 
            color: var(--primary-color); 
            padding: 0.375rem; 
            box-shadow: none;
        }
        
        .button-link:hover { 
            background: var(--primary-light-color); 
            transform: none;
        }

        .card {
            background: var(--white-color);
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            overflow-x: auto;
            margin-bottom: 1.5rem;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        #brandNameTable {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        
        #brandNameTable th, #brandNameTable td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        #brandNameTable th {
            font-weight: 600;
            color: var(--text-light-color);
            font-size: 0.875rem;
            background-color: #f8fafc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
        }
        
        #brandNameTable td { 
            font-size: 0.9375rem; 
        }
        
        #brandNameTable tr:last-child td { 
            border-bottom: none; 
        }
        
        #brandNameTable tr:hover td {
            background-color: #f8fafc;
        }
        
        #brandNameTable tr.row-selected td {
            background-color: var(--primary-light-color);
        }
        
        .actions-cell { 
            text-align: right; 
            display: flex; 
            align-items: center; 
            justify-content: flex-end; 
            gap: 0.5rem;
            min-width: 220px;
        }

        .actions-cell .button-small {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
            box-shadow: none;
            border: 1px solid transparent;
        }
        
        .actions-cell .button-success:disabled {
             background-color: var(--success-light-color);
             color: var(--success-color);
             border-color: var(--success-light-color);
             opacity: 1;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-approved { background-color: var(--success-light-color); color: var(--success-color); }
        .status-rejected { background-color: var(--danger-light-color); color: var(--danger-color); }
        .status-waiting { background-color: var(--warning-light-color); color: var(--warning-color); }

        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(15, 23, 42, 0.5); justify-content: center; align-items: center; padding: 1rem; }
        .modal-content { background-color: var(--white-color); padding: 0; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); width: 100%; max-width: 600px; position: relative; overflow: hidden; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); }
        .modal-header h2 { margin: 0; color: var(--text-color); font-size: 1.25rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; }
        .close-btn { color: var(--text-lighter-color); font-size: 1.5rem; font-weight: bold; cursor: pointer; border: none; background: none; padding: 0; display: flex; align-items: center; justify-content: center; }
        .close-btn:hover, .close-btn:focus { color: var(--text-color); }
        .modal-body { padding: 1.5rem; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 0.75rem; padding: 1.25rem 1.5rem; border-top: 1px solid var(--border-color); background-color: #f8fafc; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-color); }
        .form-group input { box-sizing: border-box; width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-color); border-radius: 6px; font-size: 1rem; transition: border-color 0.2s; }
        .form-group input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px var(--primary-light-color); }
        .review-instructions { margin: 0 0 1.5rem 0; font-size: 0.9375rem; color: var(--text-light-color); line-height: 1.6; }
        .review-body { display: grid; grid-template-columns: 1fr; gap: 1.5rem; max-height: 60vh; overflow-y: auto; padding-right: 0.5rem; }
        .review-section h3 { display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem; font-weight: 600; padding-bottom: 0.75rem; margin: 0 0 1rem 0; }
        .review-section h3 .material-icons { color: var(--warning-color); }
        .review-section.new-records h3 .material-icons { color: var(--success-color); }
        .review-list { list-style: none; padding: 0; margin: 0; }
        .review-list-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border-radius: 6px; border: 1px solid var(--border-color); transition: all 0.2s; margin-bottom: 0.5rem; }
        .review-list-item:hover { border-color: var(--primary-color); }
        .review-list-item.selected { background-color: var(--primary-light-color); border-color: var(--primary-color); }
        #duplicatesSection .review-list-item input[type="text"] { color: var(--danger-color); }
        .review-list-item input[type="text"] { flex-grow: 1; border: 1px solid var(--border-color); border-radius: 4px; font-size: 0.9375rem; padding: 0.5rem 0.75rem; }
        .review-list-item input[type="text"]:focus { outline: none; border-color: var(--primary-color); }
        .review-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; }
        .review-section-header label { font-size: 0.875rem; font-weight: 500; cursor: pointer; color: var(--primary-color); display: flex; align-items: center; gap: 0.5rem; }
        .review-item-actions { display: flex; gap: 0.25rem; }
        .review-item-actions button { background: none; border: none; padding: 0.375rem; cursor: pointer; border-radius: 4px; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s; }
        .review-item-actions button:hover { background-color: var(--border-light-color); }
        .review-item-actions .material-icons { font-size: 1.125rem; }
        .button-accept .material-icons { color: var(--success-color); }
        .button-reject .material-icons { color: var(--danger-color); }
        .file-upload-area { border: 2px dashed var(--border-color); border-radius: 8px; padding: 2rem; text-align: center; margin-bottom: 1.5rem; transition: all 0.2s; cursor: pointer; }
        .file-upload-area:hover { border-color: var(--primary-color); background-color: var(--primary-light-color); }
        .file-upload-area .material-icons { font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem; }
        .file-upload-area h3 { font-size: 1.125rem; margin-bottom: 0.5rem; color: var(--text-color); }
        .file-upload-area p { color: var(--text-light-color); margin-bottom: 1rem; }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-light-color); }
        .empty-state .material-icons { font-size: 3rem; margin-bottom: 1rem; color: var(--border-color); }
        .bulk-actions-bar { display: none; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background-color: var(--primary-light-color); border: 1px solid var(--primary-color); border-radius: 8px; margin-bottom: 1rem; }
        .bulk-actions-bar span { font-weight: 500; }
        .bulk-actions-bar .actions { display: flex; gap: 0.75rem; }
        
        .table-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light-color);
        }

        .search-container {
            position: relative;
            flex-grow: 1;
            min-width: 250px;
        }

        .search-container .material-icons {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-lighter-color);
        }

        #searchInput {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem; /* Left padding for icon */
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
        }
        
        .sorting-controls { display: flex; gap: 0.75rem; }
        .sort-btn { background-color: var(--white-color); color: var(--text-light-color); border: 1px solid var(--border-color); font-weight: 500; padding: 0.5rem 1rem; box-shadow: none; }
        .sort-btn.active { background-color: var(--primary-light-color); color: var(--primary-color); border-color: var(--primary-color); }

        .filter-icon { cursor: pointer; font-size: 1rem; vertical-align: middle; margin-left: 0.25rem; border-radius: 50%; padding: 0.25rem; transition: all 0.2s; }
        .filter-icon:hover { background-color: var(--border-color); }
        .filter-icon.active-filter { color: var(--primary-color); background-color: var(--primary-light-color); }

        .filter-dropdown { display: none; position: absolute; top: 100%; left: 0; background-color: var(--white-color); border: 1px solid var(--border-color); border-radius: 6px; box-shadow: var(--card-shadow); z-index: 10; width: 280px; }
        .filter-dropdown.show { display: block; }
        .filter-option { padding: 0.5rem 0.75rem; display: flex; align-items: center; }
        .filter-option label { margin-left: 0.5rem; cursor: pointer; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .filter-actions { display: flex; justify-content: space-between; padding: 0.75rem; border-top: 1px solid var(--border-light-color); background-color: #f8fafc; }
        .filter-actions button { padding: 0.375rem 0.75rem; font-size: 0.8125rem; box-shadow: none; }
        .filter-actions button:first-child { background-color: var(--white-color); color: var(--text-color); border: 1px solid var(--border-color); }
        .filter-actions button:last-child { background-color: var(--primary-color); }
        
        .filter-search-container { padding: 0.5rem; border-bottom: 1px solid var(--border-light-color); }
        .filter-search { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid var(--border-color); border-radius: 4px; font-size: 0.875rem; }
        .filter-list { max-height: 200px; overflow-y: auto; padding: 0.5rem 0; }

        @media (max-width: 768px) {
            .app-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .main-actions { width: 100%; flex-wrap: wrap; }
            button { flex: 1; min-width: 140px; }
            .modal-content { margin: 1rem; }
            .review-list-item { flex-wrap: wrap; }
            .review-item-actions { width: 100%; justify-content: flex-end; margin-top: 0.5rem; }
        }
    </style>
</head>
<body>

     <div class="app-container">
        <div class="app-header">
            <h1 class="app-title"><i class="material-icons">inventory</i> Brand Name Manager</h1>
            <div class="main-actions">
                <button id="openAddModalBtn"><i class="material-icons">add</i>Add Brand</button>
                <button id="openBulkUploadModalBtn"><i class="material-icons">upload</i>Bulk Upload</button>
            </div>
        </div>
        
        <div class="card">
            <div id="bulkActionsBar" class="bulk-actions-bar">
                <span id="selectionCount">0 items selected</span>
                <div class="actions">
                    <button id="bulkApproveBtn" class="button-success"><i class="material-icons">check</i>Approve</button>
                    <button id="bulkRejectBtn" class="button-secondary"><i class="material-icons">close</i>Reject</button>
                    <button id="bulkDeleteBtn" class="button-danger"><i class="material-icons">delete</i>Delete</button>
                </div>
            </div>
            <div class="table-toolbar">
                <div class="search-container">
                    <i class="material-icons">search</i>
                    <input type="text" id="searchInput" placeholder="Search brands...">
                </div>
                <div class="sorting-controls">
                    <button id="sortAlphaBtn" class="sort-btn active"><i class="material-icons">sort_by_alpha</i>Sort Alphabetically</button>
                    <button id="sortDateBtn" class="sort-btn"><i class="material-icons">event</i>Sort by Date</button>
                </div>
            </div>
            <div class="table-container">
                <table id="brandNameTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllCheckbox"></th>
                            <th>
                                Brand Name
                                <i class="material-icons filter-icon" id="brandFilterIcon">filter_list</i>
                                <div class="filter-dropdown" id="brandFilterDropdown">
                                    <div class="filter-search-container">
                                        <input type="text" id="brandFilterSearch" class="filter-search" placeholder="Search brands...">
                                    </div>
                                    <div class="filter-list" id="brandFilterList">
                                        <!-- Dynamic content here -->
                                    </div>
                                    <div class="filter-actions">
                                        <button id="clearBrandFilterBtn">Clear</button>
                                        <button id="applyBrandFilterBtn">Apply</button>
                                    </div>
                                </div>
                            </th>
                            <th>
                                Status
                                <i class="material-icons filter-icon" id="statusFilterIcon">filter_list</i>
                                <div class="filter-dropdown" id="statusFilterDropdown">
                                    <div class="filter-list">
                                        <div class="filter-option"><input type="checkbox" id="filterWaiting" value="waiting for approval"><label for="filterWaiting">Waiting for Approval</label></div>
                                        <div class="filter-option"><input type="checkbox" id="filterApproved" value="approved"><label for="filterApproved">Approved</label></div>
                                        <div class="filter-option"><input type="checkbox" id="filterRejected" value="rejected"><label for="filterRejected">Rejected</label></div>
                                    </div>
                                    <div class="filter-actions">
                                        <button id="clearStatusFilterBtn">Clear</button>
                                        <button id="applyStatusFilterBtn">Apply</button>
                                    </div>
                                </div>
                            </th>
                            <th>Last Updated</th>
                            <th>Updated By</th>
                            <th class="actions-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="brandNameList"></tbody>
                </table>
            </div>
        </div>
    </div>
      

    <!-- Modals -->
     <div id="addNameModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="material-icons">add_circle_outline</i> Add New Brand Name</h2>
                <button class="close-btn" type="button">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addBrandForm">
                    @csrf
                    <div class="form-group">
                        <label for="addNameInput">Brand Name</label>
                        <input type="text" id="addNameInput1" name="brand_name" placeholder="Enter the new brand name">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button-secondary close-btn">Cancel</button>
                        <button type="submit" id="saveNewBtn" class="button-success">
                            <i class="material-icons">save</i> Save Brand Name
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="successMessage" style="display:none; color:green; margin-top:10px;">
        ✅ Brand added successfully!
    </div>
    
    
    <div id="bulkUploadModal" class="modal"> <div class="modal-content"><div class="modal-header"><h2><i class="material-icons">upload_file</i>Bulk Upload Brand Names</h2><button class="close-btn">&times;</button></div><div class="modal-body"><div class="file-upload-area" onclick="document.getElementById('csvFile').click()"><i class="material-icons">cloud_upload</i><h3>Upload CSV File</h3><p>Click to browse or drag and drop your CSV file here</p><button>Choose File</button></div><input type="file" id="csvFile" accept=".csv" style="display: none;"><p style="text-align: center; color: var(--text-light-color); font-size: 0.875rem;"> CSV should contain one brand name per line. <a href="javascript:void(0)" onclick="downloadSampleCsv()" style="color: var(--primary-color); text-decoration: none;"> Download sample CSV </a></p></div></div> </div>
    <div id="reviewUploadModal" class="modal"> <div class="modal-content"><div class="modal-header"><h2><i class="material-icons">rate_review</i>Review Bulk Upload</h2><button class="close-btn">&times;</button></div><div class="modal-body"><p class="review-instructions">Review the data from your CSV file. You can edit brand names directly. Use the checkboxes to select which records to import.</p><div class="review-body"><div id="duplicatesSection" class="review-section duplicate-records"><div class="review-section-header"><h3><i class="material-icons">warning</i>Duplicate Records</h3><label><input type="checkbox" id="selectAllDuplicates"> Select All</label></div><ul id="duplicatesList" class="review-list"></ul></div><div id="newRecordsSection" class="review-section new-records"><div class="review-section-header"><h3><i class="material-icons">add_circle</i>New Records</h3><label><input type="checkbox" id="selectAllNew"> Select All</label></div><ul id="newNamesList" class="review-list"></ul></div></div></div><div class="modal-footer"><button class="button-secondary close-btn">Cancel</button><button id="importBtn" class="button-success"><i class="material-icons">check_circle</i>Import Selected (0)</button></div></div> </div>
    <div id="editNameModal" class="modal"> <div class="modal-content"><div class="modal-header"><h2><i class="material-icons">edit</i>Edit Brand Name</h2><button class="close-btn">&times;</button></div><div class="modal-body"><input type="hidden" id="editNameId"><div class="form-group"><label for="editNameInput">Brand Name</label><input type="text" id="editNameInput" placeholder="Enter brand name"></div></div><div class="modal-footer"><button class="button-secondary close-btn">Cancel</button><button id="saveEditBtn" class="button-success"><i class="material-icons">save</i>Save Changes</button></div></div> </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        }
    </script>

    <script>
    $(document).ready(function () {
         $("#addBrandForm").on("submit", function (e) {
            e.preventDefault();
        
            let brandName = $("#addNameInput1").val().trim();
            if (!brandName) {
                toastr.error("Brand Name is required");
                return;
            }
        
            $.ajax({
                url: "{{ route('sqa.brand.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    toastr.success(response.message);
                    $("#addBrandForm")[0].reset();
                    $("#addNameModal").hide();
                    setTimeout(()=>{
                        location.reload()
                    },2000)
                },
                error: function (xhr) {
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error("Something went wrong.");
                    }
                }
            });
        });

        // close modal
        $(".close-btn").on("click", function () {
            $("#addNameModal").hide();
        });
    });
    </script>

    <script>
         document.addEventListener("DOMContentLoaded", () => {
            loadBrands();
        });

        let brandNames = []; 
        
        async function loadBrands() {
            try {
                const res = await fetch("get-sqa-brand-list");
                const data = await res.json();
        
                if (data.success) {
                    brandNames = data.brands.map(b => ({
                        ...b,
                        dateOfUpdate: b.dateOfUpdate ? new Date(b.dateOfUpdate) : null
                    }));
                    
                    console.log("data.brands", data.brands);
                    console.log("brandNames", brandNames);
                    
                    initApps(); 
        
                } else {
                    console.error("Failed to load brands:", data.message);
                    initApps();
                }
            } catch (err) {
                console.error("Error fetching brands:", err);
                initApps();
            }
        }

        function initApps() {
              console.log("brandNames111111", brandNames);
    
        // let brandNames = [
        //     { id: 1, brandName: "Eleanor Vance", corporateName: "Vance Industries", regionalName: "North America", unitName: "Marketing", dateOfUpdate: new Date('2023-10-26T10:00:00Z'), updatedBy: "Admin", status: 'approved' },
        //     { id: 2, brandName: "Marcus Thorne", corporateName: "Thorne Corp", regionalName: "EMEA", unitName: "Sales", dateOfUpdate: new Date('2024-08-26T10:05:00Z'), updatedBy: "Admin", status: 'waiting for approval' },
        //     { id: 3, brandName: "Isabella Rossi", corporateName: "Rossi Goods", regionalName: "APAC", unitName: "Logistics", dateOfUpdate: new Date('2023-10-27T11:20:00Z'), updatedBy: "Admin", status: 'rejected' },
        //     { id: 4, brandName: "Apex Innovations", corporateName: "Apex Group", regionalName: "Global", unitName: "R&D", dateOfUpdate: new Date('2024-05-15T14:00:00Z'), updatedBy: "System", status: 'approved' },
        //     { id: 5, brandName: "Zenith Solutions", corporateName: "Zenith LLC", regionalName: "North America", unitName: "IT", dateOfUpdate: new Date('2024-09-01T09:30:00Z'), updatedBy: "Manual", status: 'waiting for approval' },
        //     { id: 6, brandName: "Quantum Leap", corporateName: "Quantum Dynamics", regionalName: "EMEA", unitName: "Research", dateOfUpdate: new Date('2024-09-02T11:00:00Z'), updatedBy: "Admin", status: 'approved' },
        //     { id: 7, brandName: "Stellar Goods", corporateName: "Stellar Co.", regionalName: "APAC", unitName: "Logistics", dateOfUpdate: new Date('2024-09-03T15:30:00Z'), updatedBy: "System", status: 'approved' },
        //     { id: 8, brandName: "Nova Digital", corporateName: "Nova Group", regionalName: "North America", unitName: "Marketing", dateOfUpdate: new Date('2024-09-04T10:00:00Z'), updatedBy: "Manual", status: 'waiting for approval' },
        //     { id: 9, brandName: "Fusion Foods", corporateName: "Fusion LLC", regionalName: "Global", unitName: "Sales", dateOfUpdate: new Date('2024-08-15T12:00:00Z'), updatedBy: "Admin", status: 'rejected' },
        //     { id: 10, brandName: "Pioneer Tech", corporateName: "Pioneer Inc.", regionalName: "EMEA", unitName: "IT", dateOfUpdate: new Date('2024-07-20T18:00:00Z'), updatedBy: "System", status: 'approved' },
        //     { id: 11, brandName: "Momentum Motors", corporateName: "Momentum Group", regionalName: "North America", unitName: "Sales", dateOfUpdate: new Date('2024-09-05T09:00:00Z'), updatedBy: "Manual", status: 'waiting for approval' },
        //     { id: 12, brandName: "Evergreen Essentials", corporateName: "Evergreen Co.", regionalName: "Global", unitName: "Marketing", dateOfUpdate: new Date('2023-11-30T14:45:00Z'), updatedBy: "Admin", status: 'approved' },
        //     { id: 13, brandName: "Catalyst Creations", corporateName: "Catalyst LLC", regionalName: "APAC", unitName: "R&D", dateOfUpdate: new Date('2024-09-01T16:20:00Z'), updatedBy: "System", status: 'approved' },
        //     { id: 14, brandName: "Horizon Health", corporateName: "Horizon Med", regionalName: "North America", unitName: "Research", dateOfUpdate: new Date('2024-06-10T13:00:00Z'), updatedBy: "Admin", status: 'rejected' },
        //     { id: 15, brandName: "Terra Firma", corporateName: "Terra Group", regionalName: "EMEA", unitName: "Logistics", dateOfUpdate: new Date('2024-09-05T10:15:00Z'), updatedBy: "Manual", status: 'waiting for approval' }
        // ];
        let nextId = 16;
        let currentSortMethod = 'alphabetical';
        let currentSearchTerm = '';
        let activeStatusFilters = [];
        let activeBrandFilters = [];
        
        // --- DOM ELEMENTS ---
        const brandNameListBody = document.getElementById('brandNameList');
        const addNameModal = document.getElementById('addNameModal'), bulkUploadModal = document.getElementById('bulkUploadModal'), reviewUploadModal = document.getElementById('reviewUploadModal'), editNameModal = document.getElementById('editNameModal');
        const openAddModalBtn = document.getElementById('openAddModalBtn'), openBulkUploadModalBtn = document.getElementById('openBulkUploadModalBtn'), closeButtons = document.querySelectorAll('.close-btn'), saveEditBtn = document.getElementById('saveEditBtn'), saveNewBtn = document.getElementById('saveNewBtn');
        const csvFileInput = document.getElementById('csvFile'), importBtn = document.getElementById('importBtn'), selectAllNewCheckbox = document.getElementById('selectAllNew'), selectAllDuplicatesCheckbox = document.getElementById('selectAllDuplicates');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox'), bulkActionsBar = document.getElementById('bulkActionsBar'), selectionCountSpan = document.getElementById('selectionCount'), bulkApproveBtn = document.getElementById('bulkApproveBtn'), bulkRejectBtn = document.getElementById('bulkRejectBtn'), bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const sortAlphaBtn = document.getElementById('sortAlphaBtn'), sortDateBtn = document.getElementById('sortDateBtn');
        const searchInput = document.getElementById('searchInput');
        // Status Filter
        const statusFilterIcon = document.getElementById('statusFilterIcon'), statusFilterDropdown = document.getElementById('statusFilterDropdown'), applyStatusFilterBtn = document.getElementById('applyStatusFilterBtn'), clearStatusFilterBtn = document.getElementById('clearStatusFilterBtn');
        // Brand Filter
        const brandFilterIcon = document.getElementById('brandFilterIcon'), brandFilterDropdown = document.getElementById('brandFilterDropdown'), brandFilterSearch = document.getElementById('brandFilterSearch'), brandFilterList = document.getElementById('brandFilterList'), applyBrandFilterBtn = document.getElementById('applyBrandFilterBtn'), clearBrandFilterBtn = document.getElementById('clearBrandFilterBtn');

        // --- MODAL HANDLING ---
        function openModal(modal) { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
        function closeModal(modal) { modal.style.display = 'none'; document.body.style.overflow = 'auto'; }
        openAddModalBtn.onclick = () => openModal(addNameModal); openBulkUploadModalBtn.onclick = () => openModal(bulkUploadModal); closeButtons.forEach(btn => btn.onclick = () => closeModal(btn.closest('.modal'))); window.onclick = (event) => { if (event.target.classList.contains('modal')) closeModal(event.target); };
        
        // --- EVENT LISTENERS ---
        renderBrandNameList();
        // document.addEventListener('DOMContentLoaded', renderBrandNameList);
        csvFileInput.addEventListener('change', handleFileUpload);
        importBtn.addEventListener('click', importSelectedData);
        saveEditBtn.addEventListener('click', saveBrandNameChanges);
        saveNewBtn.addEventListener('click', addNewBrandName);
        selectAllCheckbox.addEventListener('change', handleSelectAll);
        brandNameListBody.addEventListener('change', handleRowSelection);
        bulkApproveBtn.addEventListener('click', bulkApprove); bulkRejectBtn.addEventListener('click', bulkReject); bulkDeleteBtn.addEventListener('click', bulkDelete);
        sortAlphaBtn.addEventListener('click', () => setSortMethod('alphabetical')); sortDateBtn.addEventListener('click', () => setSortMethod('date'));
        searchInput.addEventListener('input', handleSearch);
        // Status Filter Listeners
        statusFilterIcon.addEventListener('click', toggleStatusFilterDropdown); applyStatusFilterBtn.addEventListener('click', applyStatusFilter); clearStatusFilterBtn.addEventListener('click', clearStatusFilter);
        // Brand Filter Listeners
        brandFilterIcon.addEventListener('click', toggleBrandFilterDropdown); applyBrandFilterBtn.addEventListener('click', applyBrandFilter); clearBrandFilterBtn.addEventListener('click', clearBrandFilter); brandFilterSearch.addEventListener('input', handleBrandFilterSearch);
        document.addEventListener('click', handleOutsideClick);

        // --- CORE FUNCTIONS ---
        function renderBrandNameList() {
            let processedBrands = [...brandNames];
            console.log("processedBrands",processedBrands);
            // 1. Apply Filters
            if (currentSearchTerm) { processedBrands = processedBrands.filter(item => Object.values(item).some(val => String(val).toLowerCase().includes(currentSearchTerm))); }
            if (activeStatusFilters.length > 0) { processedBrands = processedBrands.filter(item => activeStatusFilters.includes(item.status)); }
            if (activeBrandFilters.length > 0) { processedBrands = processedBrands.filter(item => activeBrandFilters.includes(item.brandName)); }

            // 2. Handle Empty State
            if (processedBrands.length === 0) {
                const message = currentSearchTerm || activeStatusFilters.length > 0 || activeBrandFilters.length > 0 ? "No results found" : "No brand names yet";
                const subMessage = currentSearchTerm || activeStatusFilters.length > 0 || activeBrandFilters.length > 0 ? "Try adjusting your search or filters." : "Add a brand to get started.";
                brandNameListBody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><i class="material-icons">search_off</i><h3>${message}</h3><p>${subMessage}</p></div></td></tr>`;
                return;
            }
            
            // 3. Partition and Sort
            const waitingItems = processedBrands.filter(item => item.status === 'waiting for approval').sort((a,b) => b.dateOfUpdate - a.dateOfUpdate);
            const rejectedItems = processedBrands.filter(item => item.status === 'rejected').sort((a,b) => b.dateOfUpdate - a.dateOfUpdate);
            const middleItems = processedBrands.filter(item => item.status !== 'waiting for approval' && item.status !== 'rejected');
            if (currentSortMethod === 'alphabetical') { middleItems.sort((a, b) => a.brandName.localeCompare(b.brandName)); } else { middleItems.sort((a, b) => b.dateOfUpdate - a.dateOfUpdate); }
            const sortedBrandNames = [...waitingItems, ...middleItems, ...rejectedItems];
            
            // 4. Render HTML
            brandNameListBody.innerHTML = sortedBrandNames.map(item => {
                let statusClass = '', statusText = '';
                switch (item.status) {
                    case 'approved': statusClass = 'status-approved'; statusText = 'Approved'; break;
                    case 'rejected': statusClass = 'status-rejected'; statusText = 'Rejected'; break;
                    case 'waiting for approval': statusClass = 'status-waiting'; statusText = 'Waiting for Approval'; break;
                }
                return `<tr data-id="${item.id}"><td><input type="checkbox" class="row-checkbox" data-id="${item.id}"></td><td><div><strong>${item.brandName}</strong></div><div style="font-size:0.8125rem;color:var(--text-light-color);">${item.corporateName} &gt; ${item.regionalName} &gt; ${item.unitName}</div></td><td><span class="status-badge ${statusClass}">${statusText}</span></td><td>${formatDate(item.dateOfUpdate)}</td><td>${item.updatedBy}</td><td class="actions-cell">${generateActionButtons(item)}</td></tr>`
            }).join('');
            
            // 5. Update UI states
            updateBulkActionUI(); updateSortButtonsUI(); updateFilterIconUI();
        }
        
        // function generateActionButtons(item){let b='';switch(item.status){case'waiting for approval':b+=`<button class="button-small button-success" title="Approve" onclick="approveBrandName(${item.id})">Approve</button><button class="button-small button-danger" title="Reject" onclick="rejectBrandName(${item.id})">Reject</button>`;break;case'approved':b+=`<button class="button-small button-success" disabled>Approved</button><button class="button-small button-danger" title="Reject" onclick="rejectBrandName(${item.id})">Reject</button>`;break;case'rejected':b+=`<button class="button-small button-success" title="Approve" onclick="approveBrandName(${item.id})">Approve</button>`;break}b+=`<button class="button-link" title="Edit" onclick="openEditModal(${item.id})"><i class="material-icons">edit</i></button>`;if(item.status!=='approved'){b+=`<button class="button-link" title="Delete" onclick="deleteBrandName(${item.id})"><i class="material-icons">delete</i></button>`}return b}
    
        function generateActionButtons(item) {
            let b = '';
        
            // If the user is NOT the creator, disable all buttons
            const disabled = item.auth_id !== item.created_by ? 'disabled' : '';
        
            switch (item.status) {
                case 'waiting for approval':
                    b += `<button class="button-small button-success" title="Approve" ${disabled}>Approve</button>`;
                    b += `<button class="button-small button-danger" title="Reject" ${disabled}>Reject</button>`;
                    break;
                case 'approved':
                    b += `<button class="button-small button-success" disabled>Approved</button>`;
                    b += `<button class="button-small button-danger" title="Reject" ${disabled}>Reject</button>`;
                    break;
                case 'rejected':
                    b += `<button class="button-small button-success" title="Approve" ${disabled}>Approve</button>`;
                    break;
            }
        
            b += `<button class="button-link" title="Edit" ${disabled}><i class="material-icons">edit</i></button>`;
        
            if (item.status !== 'approved') {
                b += `<button class="button-link" title="Delete" ${disabled}><i class="material-icons">delete</i></button>`;
            }
        
            return b;
        }

        
        
        brandNameListBody.addEventListener('click', handleActionButtons);

        function handleActionButtons(event) {
            const target = event.target.closest('button');
            if (!target) return; 
            const row = target.closest('tr');
            const id = parseInt(row.dataset.id);
        
            if (target.title === 'Approve') {
                approveBrandName(id);
            } else if (target.title === 'Reject') {
                rejectBrandName(id);
            } else if (target.title === 'Edit') {
                openEditModal(id);
            } else if (target.title === 'Delete') {
                deleteBrandName(id);
            }
        }
      
        function approveBrandName(id) {
                const dataToSend = {
                    _token: "{{ csrf_token() }}",
                    id: id
                };
                $.ajax({
                    url: "{{ route('sqa.single.brand.approve') }}",
                    method: "POST",
                    data: dataToSend,
                    success: function(response) {
                        toastr.success(response.message || "Brand approved successfully!");
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr) {
                        console.error("Error approving brand:", xhr);
                        toastr.error(xhr.responseJSON?.message || "Error approving brand.");
                    }
                });
        }
        function rejectBrandName(id) { 
            // updateBrandStatus([id], 'rejected', "Rejection Action"); 
            
             const dataToSend = {
                    _token: "{{ csrf_token() }}",
                    id: id
                };
                $.ajax({
                    url: "{{ route('sqa.single.brand.reject') }}",
                    method: "POST",
                    data: dataToSend,
                    success: function(response) {
                        toastr.success(response.message || "Brand rejected successfully!");
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr) {
                        console.error("Error rejecting brand:", xhr);
                        toastr.error(xhr.responseJSON?.message || "Error rejecting brand.");
                    }
                });
        }
        function formatDate(date) { return new Date(date).toLocaleString(undefined, { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' }); }
        function addNewBrandName(){const i=document.getElementById('addNameInput'),n=i.value.trim();if(!n){alert("Brand name cannot be empty.");return}if(brandNames.some(b=>b.brandName.toLowerCase()===n.toLowerCase())){alert("This brand name already exists.");return}brandNames.push({id:nextId++,brandName:n,corporateName:"Default Corp",regionalName:"Global",unitName:"Unassigned",dateOfUpdate:new Date(),updatedBy:"Manual",status:'waiting for approval'});i.value='';closeModal(addNameModal);renderBrandNameList()}
        // function deleteBrandName(id){const i=brandNames.find(b=>b.id===id);if(!i)return;if(i.status==='approved'){alert(`"${i.brandName}" cannot be deleted because it is approved.`);return}if(confirm(`Are you sure you want to delete "${i.brandName}"?`)){brandNames=brandNames.filter(b=>b.id!==id);renderBrandNameList()}}
        
        function deleteBrandName(id) {
            const i = brandNames.find(b => b.id === id);
            if (!i) {
                return;
            }
        
            if (i.status === 'approved') {
                toastr.success(`"${i.brandName}" cannot be deleted because it is approved.`);
                return;
            }
        
            if (confirm(`Are you sure you want to delete "${i.brandName}"?`)) {
                $.ajax({
                    url: "{{route('sqa.single.brand.delete')}}",  
                    type: 'GET',
                    data : { id },
                    success: function(response) {
                        brandNames = brandNames.filter(b => b.id !== id);
                        renderBrandNameList();
                        toastr.success(response.message || "Brand deleted successfully!");
                        setTimeout(()=>{
                                location.reload()
                        },2000)
                    },
                    error: function(xhr, status, error) {
                        toastr.error(`Could not delete "${i.brandName}". Please try again.`);
                    }
                });
            }
        }


        function openEditModal(id){const i=brandNames.find(b=>b.id===id);if(i){document.getElementById('editNameId').value=i.id;document.getElementById('editNameInput').value=i.brandName;openModal(editNameModal)}}
        // function saveBrandNameChanges(){
        // //     alert(parseInt(document.getElementById('editNameId').value));
        //     const id=parseInt(document.getElementById('editNameId').value),n=document.getElementById('editNameInput').value.trim(),i=brandNames.find(b=>b.id===id);if(i&&n){i.brandName=n;i.dateOfUpdate=new Date();i.updatedBy="Editor";closeModal(editNameModal);renderBrandNameList()}else{alert("Brand name cannot be empty.")}}
        
        function saveBrandNameChanges() {
            const id = parseInt(document.getElementById('editNameId').value);
            const newName = document.getElementById('editNameInput').value.trim();
        
            if (!newName) {
                alert("Brand name cannot be empty.");
                return;
            }
        
            const dataToSend = {
                _token: "{{ csrf_token() }}",
                id: id,
                name: newName
            };
        
            try {
                $.ajax({
                    url: "{{ route('sqa.single.brand.update') }}",
                    method: "POST",
                    data: dataToSend,
                    success: function(response) {
                        const brand = brandNames.find(b => b.id === id);
                        if (brand) {
                            brand.brandName = newName;
                            brand.dateOfUpdate = new Date();
                            brand.updatedBy = "Editor";
                            closeModal(editNameModal);
                            renderBrandNameList();
                            toastr.success(response.message || "Brand name updated successfully!");
                            setTimeout(()=>{
                                location.reload()
                            },2000)
                        }
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || "Error updating brand name.");
                    }
                });
            } catch (e) {
                console.error("AJAX request failed:", e);
                toastr.error("An unexpected error occurred.");
            }
        }

        
        
        
        // --- SEARCH & FILTERS ---
        function handleSearch(event) { currentSearchTerm = event.target.value.toLowerCase(); renderBrandNameList(); }
        function toggleStatusFilterDropdown(e) { e.stopPropagation(); brandFilterDropdown.classList.remove('show'); statusFilterDropdown.classList.toggle('show'); }
        function applyStatusFilter() { activeStatusFilters = Array.from(statusFilterDropdown.querySelectorAll('input:checked')).map(cb => cb.value); statusFilterDropdown.classList.remove('show'); renderBrandNameList(); }
        function clearStatusFilter() { activeStatusFilters = []; statusFilterDropdown.querySelectorAll('input').forEach(cb => cb.checked = false); statusFilterDropdown.classList.remove('show'); renderBrandNameList(); }
        
        function toggleBrandFilterDropdown(e) { e.stopPropagation(); statusFilterDropdown.classList.remove('show'); brandFilterDropdown.classList.toggle('show'); if (brandFilterDropdown.classList.contains('show')) populateBrandFilterDropdown(); }
        function populateBrandFilterDropdown() {
            const uniqueBrands = [...new Set(brandNames.map(item => item.brandName))].sort();
            const selectAllChecked = uniqueBrands.every(brand => activeBrandFilters.includes(brand));
            
            let optionsHTML = `<div class="filter-option">
                <input type="checkbox" id="brandFilterSelectAll" ${selectAllChecked ? 'checked' : ''}>
                <label for="brandFilterSelectAll"><strong>Select All</strong></label>
            </div>`;

            optionsHTML += uniqueBrands.map(brand => `
                <div class="filter-option" data-brand-name="${brand.toLowerCase()}">
                    <input type="checkbox" id="brand-${brand.replace(/\s+/g, '-')}" value="${brand}" ${activeBrandFilters.includes(brand) ? 'checked' : ''}>
                    <label for="brand-${brand.replace(/\s+/g, '-')}">${brand}</label>
                </div>
            `).join('');
            brandFilterList.innerHTML = optionsHTML;

            // Add event listener for the new "Select All" checkbox
            document.getElementById('brandFilterSelectAll').addEventListener('change', handleBrandFilterSelectAll);
        }
        function handleBrandFilterSearch(event) {
            const searchTerm = event.target.value.toLowerCase();
            brandFilterList.querySelectorAll('.filter-option').forEach(option => {
                const brandName = option.dataset.brandName;
                if(brandName) { // Exclude the 'Select All' option from filtering
                    option.style.display = brandName.includes(searchTerm) ? 'flex' : 'none';
                }
            });
        }
        function handleBrandFilterSelectAll(event) {
            brandFilterList.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = event.target.checked);
        }
        function applyBrandFilter() { activeBrandFilters = Array.from(brandFilterList.querySelectorAll('input:checked:not(#brandFilterSelectAll)')).map(cb => cb.value); brandFilterDropdown.classList.remove('show'); renderBrandNameList(); }
        function clearBrandFilter() { activeBrandFilters = []; brandFilterDropdown.querySelectorAll('input').forEach(cb => cb.checked = false); brandFilterDropdown.classList.remove('show'); renderBrandNameList(); }

        function updateFilterIconUI() {
            statusFilterIcon.classList.toggle('active-filter', activeStatusFilters.length > 0);
            brandFilterIcon.classList.toggle('active-filter', activeBrandFilters.length > 0);
        }
        function handleOutsideClick(event) {
            if (!statusFilterDropdown.contains(event.target) && !statusFilterIcon.contains(event.target)) { statusFilterDropdown.classList.remove('show'); }
            if (!brandFilterDropdown.contains(event.target) && !brandFilterIcon.contains(event.target)) { brandFilterDropdown.classList.remove('show'); }
        }

        // --- SORTING ---
        function setSortMethod(method) { currentSortMethod = method; renderBrandNameList(); }
        function updateSortButtonsUI() { sortAlphaBtn.classList.toggle('active', currentSortMethod === 'alphabetical'); sortDateBtn.classList.toggle('active', currentSortMethod === 'date'); }

        // --- BULK UPLOAD & REVIEW (Minified) ---
        function handleFileUpload(e){const t=e.target.files[0];if(!t)return;const n=new FileReader;n.onload=e=>{const t=e.target.result.split(/\r?\n/).map(e=>e.trim()).filter(Boolean),n=new Set(brandNames.map(e=>e.brandName.toLowerCase())),a=new Set;stagedUpload={new:[],duplicates:[]},t.forEach((e,t)=>{if(a.has(e.toLowerCase()))return;const o={tempId:`row-${t}`,brandName:e};n.has(e.toLowerCase())?stagedUpload.duplicates.push(o):stagedUpload.new.push(o),a.add(e.toLowerCase())}),renderReviewModal(),closeModal(bulkUploadModal),openModal(reviewUploadModal)},n.readAsText(t),csvFileInput.value=""}
    
    
        // function renderReviewModal(){document.getElementById("duplicatesList").innerHTML=stagedUpload.duplicates.map(e=>createReviewListItem(e,!1)).join(""),document.getElementById("newNamesList").innerHTML=stagedUpload.new.map(e=>createReviewListItem(e,!0)).join(""),document.getElementById("duplicatesSection").style.display=stagedUpload.duplicates.length>0?"block":"none",document.getElementById("newRecordsSection").style.display=stagedUpload.new.length>0?"block":"none",updateImportButtonState()}
        // function createReviewListItem(e,t){return`<li class="review-list-item ${t?"selected":""}" data-tempid="${e.tempId}"><input type="checkbox" class="record-checkbox" ${t?"checked":""} onchange="handleCheckboxChange(this)"><input type="text" value="${e.brandName}"><div class="review-item-actions"><button class="button-accept" title="Accept" onclick="acceptRow(this)"><i class="material-icons">check_circle</i></button><button class="button-reject" title="Reject" onclick="rejectRow(this)"><i class="material-icons">cancel</i></button></div></li>`}
       
       
       //start rows 
       
            function createReviewListItem(e, t) {
              return `<li class="review-list-item ${t ? "selected" : ""}" data-tempid="${e.tempId}">
                <input type="checkbox" class="record-checkbox" ${t ? "checked" : ""}>
                <input type="text" value="${e.brandName}">
                <div class="review-item-actions">
                  <button class="button-accept" title="Accept" data-action="accept"><i class="material-icons">check_circle</i></button>
                  <button class="button-reject" title="Reject" data-action="reject"><i class="material-icons">cancel</i></button>
                </div>
              </li>`;
            }
        
            function renderReviewModal() {
              const duplicatesList = document.getElementById("duplicatesList");
              const newNamesList = document.getElementById("newNamesList");
            
              duplicatesList.innerHTML = stagedUpload.duplicates.map(e => createReviewListItem(e, !1)).join("");
              newNamesList.innerHTML = stagedUpload.new.map(e => createReviewListItem(e, !0)).join("");
            
              document.getElementById("duplicatesSection").style.display = stagedUpload.duplicates.length > 0 ? "block" : "none";
              document.getElementById("newRecordsSection").style.display = stagedUpload.new.length > 0 ? "block" : "none";
            
              updateImportButtonState();
            
              // Attach a single click handler to each list
              duplicatesList.addEventListener('click', handleReviewAction);
              newNamesList.addEventListener('click', handleReviewAction);
            }
        
        
            function importSelectedData() {
                    const newBrands = [];
                    document.querySelectorAll(".record-checkbox:checked").forEach(e => {
                        const li = e.closest("li");
                        const brandName = li.querySelector('input[type="text"]').value.trim();
                
                        if (brandName && !brandNames.some(b => b.brandName.toLowerCase() === brandName.toLowerCase())) {
                            // push only brand name
                            newBrands.push({ brand_name: brandName });
                
                            // also update local UI array
                            brandNames.push({
                                id: nextId++,
                                brandName: brandName,
                                dateOfUpdate: new Date(),
                                status: "waiting for approval"
                            });
                        }
                    });
        
                     if (newBrands.length === 0) {
                        toastr.warning("No new brands selected for import");
                        return;
                    }
                
                    $.ajax({
                        url: "{{ route('sqa.brand.import') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            brands: newBrands
                        },
                        success: function (response) {
                            toastr.success(response.message || "Brands imported successfully!");
                            renderBrandNameList();
                            closeModal(reviewUploadModal);
                            setTimeout(()=>{
                                location.reload()
                            },2000)
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON?.message || "Error importing brands");
                        }
                    });
                }
        
            // function acceptRow(e){
            //     const t=e.closest(".review-list-item").querySelector(".record-checkbox");t.checked||(t.checked=!0,handleCheckboxChange(t))
            // }
            // function rejectRow(e){const t=e.closest(".review-list-item").querySelector(".record-checkbox");t.checked&&(t.checked=!1,handleCheckboxChange(t))}
              
             function handleReviewAction(event) {
                  const button = event.target.closest('button');
                  if (!button) {
                    return;
                  }
                
                  const action = button.dataset.action;
                  const listItem = button.closest(".review-list-item");
                  const checkbox = listItem.querySelector(".record-checkbox");
                  if (action === "accept") {
                    if (!checkbox.checked) {
                      checkbox.checked = true;
                      handleCheckboxChange(checkbox);
                    }
                  } else if (action === "reject") {
                    if (checkbox.checked) {
                      checkbox.checked = false;
                      handleCheckboxChange(checkbox);
                    }
                  }
                }
        
            const selectAllDuplicates = document.getElementById("selectAllDuplicates");
            const selectAllNew = document.getElementById("selectAllNew");
            
            selectAllDuplicates.addEventListener('change', () => {
                toggleSectionCheckboxes('duplicatesList', selectAllDuplicates.checked);
            });
            
            selectAllNew.addEventListener('change', () => {
                toggleSectionCheckboxes('newNamesList', selectAllNew.checked);
            });
            
            function toggleSectionCheckboxes(listId, isChecked) {
                const list = document.getElementById(listId);
                const checkboxes = list.querySelectorAll(".record-checkbox");
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                    handleCheckboxChange(checkbox);
                });
            }
        //end rows 
      
      
        function handleCheckboxChange(e){e.closest("li").classList.toggle("selected",e.checked),updateImportButtonState()}
        function updateImportButtonState(){const e=document.querySelectorAll(".record-checkbox:checked").length;importBtn.innerHTML=`<i class="material-icons">check_circle</i> Import Selected (${e})`,importBtn.disabled=0===e}
        function toggleSectionCheckboxes(e,t){document.getElementById(e).querySelectorAll(".review-list-item").forEach(e=>{const n=e.querySelector(".record-checkbox");n.checked=t,e.classList.toggle("selected",t)}),updateImportButtonState()}
        function downloadSampleCsv(){const e="data:text/csv;charset=utf-8,"+["Olivia Chen","Benjamin Carter","Sophia Rodriguez","Eleanor Vance"].join("\n"),t=encodeURI(e),n=document.createElement("a");n.setAttribute("href",t),n.setAttribute("download","sample_brand_names.csv"),document.body.appendChild(n),n.click(),document.body.removeChild(n)}

        // --- BULK ACTIONS ---
        function getSelectedIds(){return Array.from(document.querySelectorAll(".row-checkbox:checked")).map(e=>parseInt(e.dataset.id))}
        function updateBulkActionUI(){const e=getSelectedIds(),t=e.length;bulkActionsBar.style.display=t>0?"flex":"none",t>0&&(selectionCountSpan.textContent=`${t} item${t>1?"s":""} selected`,bulkDeleteBtn.disabled=e.some(e=>{var t;return"approved"===(null===(t=brandNames.find(t=>t.id===e))?void 0:t.status)})),document.querySelectorAll("#brandNameList tr").forEach(e=>{const t=e.querySelector(".row-checkbox");t&&e.classList.toggle("row-selected",t.checked)}),0===t&&(selectAllCheckbox.checked=!1)}
        function handleSelectAll(e){document.querySelectorAll(".row-checkbox").forEach(t=>{t.checked=e.target.checked}),updateBulkActionUI()}
        function handleRowSelection(e){if(e.target.classList.contains("row-checkbox")){const t=document.querySelectorAll(".row-checkbox").length,n=document.querySelectorAll(".row-checkbox:checked").length;selectAllCheckbox.checked=t>0&&t===n,updateBulkActionUI()}}
        function updateBrandStatus(e,t,n){e.forEach(e=>{const a=brandNames.find(t=>t.id===e);a&&(a.status=t,a.dateOfUpdate=new Date,a.updatedBy=n)}),renderBrandNameList()}
        // function bulkApprove(){
        //     const e=getSelectedIds();e.length>0&&updateBrandStatus(e,"approved","Bulk Approve"
            
        //     )}
        function bulkApprove() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                const data = {
                    ids: selectedIds,
                    status: 'approved',
                      _token: "{{ csrf_token() }}",
                };
        
                $.ajax({
                    url: "{{route('brands.bulk.update.approve')}}",
                    type: 'POST', 
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {
                        selectedIds.forEach(id => {
                            const brand = brandNames.find(b => b.id === id);
                            if (brand) {
                                brand.status = 'approved';
                            }
                        });
                        renderBrandNameList();
                        toastr.success(response.message || "Bulk approval successful!");
                        setTimeout(()=>{
                                location.reload()
                            },2000)
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message || "Bulk approval failed. Please try again.");
                    }
                });
            } else {
                // Alert the user if no brands are selected
                 toastr.error("Please select at least one brand to approve.");
            }
        }
        function bulkReject(){
            // const e=getSelectedIds();e.length>0&&updateBrandStatus(e,"rejected","Bulk Reject")
            const selectedIds = getSelectedIds();
            if (selectedIds.length > 0) {
                const data = {
                    ids: selectedIds,
                    status: 'rejected',
                      _token: "{{ csrf_token() }}",
                };
        
                $.ajax({
                    url: "{{route('brands.bulk.update.reject')}}",
                    type: 'POST', 
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {
                        selectedIds.forEach(id => {
                            const brand = brandNames.find(b => b.id === id);
                            if (brand) {
                                brand.status = 'rejected';
                            }
                        });
                        renderBrandNameList();
                        toastr.success(response.message || "Bulk rejected successfully!");
                        setTimeout(()=>{
                                location.reload()
                            },2000)
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message || "Bulk reject failed. Please try again.");
                    }
                });
            } else {
                // Alert the user if no brands are selected
                 toastr.error("Please select at least one brand to reject.");
            }
        }
        function bulkDelete(){
             const selectedIds = getSelectedIds();
                if (selectedIds.length > 0) {
                    const data = {
                        ids: selectedIds,
                        status: 'rejected',
                          _token: "{{ csrf_token() }}",
                    };
            
                     if (confirm(`Are you sure you want to delete ${selectedIds.length} brand name(s)?`)) {
    
                    $.ajax({
                        url: "{{route('brands.bulk.delete')}}",
                        type: 'POST', 
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            renderBrandNameList();
                            toastr.success(response.message || "Bulk deleted successfully!");
                            setTimeout(()=>{
                                    location.reload()
                                },2000)
                        },
                        error: function(xhr, status, error) {
                            toastr.error(xhr.responseJSON.message || "Bulk delete failed. Please try again.");
                        }
                    });
                     }
                } else {
                     toastr.error("Please select at least one brand to delete.");
                }
        }
}
    </script>
</body>
</html>