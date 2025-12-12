<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->


	<meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>efsms</title>
</head>
<style>
	
	
	th {
    font-size: 14px !important;
}
	
	 td {
    padding: 8px 10px;
    font-size: 14px;
}
	div#example_length {
    margin: 20px 0px;
}
	
	
	div#example_filter {
    display: none;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#example_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#example_paginate a {
    color: #fff !important;
}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #333 !important;
    border: 1px solid #979797;
    background-color: white;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #dcdcdc));
    background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
    background: #d10b1e !important;
    border: 0px !important;
}
	
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    border: 0px;
    background-color: #585858;
    background: red;
    background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
    background: -moz-linear-gradient(top, #585858 0%, #111 100%);
    background: -ms-linear-gradient(top, #585858 0%, #111 100%);
    background: -o-linear-gradient(top, #585858 0%, #111 100%);
    background: #d10b1e !important;
}
	
	.table>:not(:last-child)>:last-child>* {
    border-bottom-color: transparent;
}
	a.back {
    text-align: right;
    float: right;
    padding: 13px 30px;
    background: #17a00e;
    margin-bottom: 20px;
    border-radius: 6px;
    color: #fff;
}

a.active {
    color: #fff !important;
    text-decoration: none;
    background: #0d6efd;
}

.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
   width: 100% !important; 
}
.bootstrap-select button.btn {
    background: transparent !important;
    border: 1px solid #ddd;
    border-radius: 4px !important;
}
	</style>
	
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- STYLESHEETS REQUIRED (CONSOLIDATED) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
 <style>
        /* --- DESIGN SYSTEM & VARIABLES --- */
        :root {
            --sf-primary: #4A90E2;
            --sf-primary-dark: #357ABD;
            --sf-danger: #D0021B;
            --sf-success: #28a745;
            --sf-info: #0dcaf0;
            --sf-bg-color: #f7f8fc;
            --sf-card-bg: #ffffff;
            --sf-text-primary: #2c3e50;
            --sf-text-secondary: #7f8c9a;
            --sf-border-color: #e5e9f2;
            --sf-header-bg: #fbfdff;
            --sf-hover-bg: #f4f8fe;
            --sf-font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            --sf-border-radius: 12px;
            --sf-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        }

        /* --- General Layout & Typography --- */
        body {
            font-family: var(--sf-font-family);
            background-color: var(--sf-bg-color);
            margin: 0;
            color: var(--sf-text-primary);
            line-height: 1.6;
        }
        .layout-container {
            padding: 40px 30px;
        }
        .page-header { 
            margin-bottom: 30px; 
            padding-bottom: 15px;
            border-bottom: 1px solid var(--sf-border-color);
        }
        .page-title {
            font-size: 32px; font-weight: 700; color: var(--sf-text-primary); margin: 0;
        }

        /* --- Tabs --- */
        .tabs-nav {
            display: flex; border-bottom: 1px solid var(--sf-border-color);
            margin-bottom: 35px;
        }
        .tab-button {
            padding: 14px 25px; border: none; background-color: transparent; cursor: pointer;
            font-size: 16px; font-weight: 600; color: var(--sf-text-secondary); transition: all 0.3s ease;
            border-bottom: 3px solid transparent; position: relative; top: 1px; margin-right: 15px;
        }
        .tab-button i { margin-right: 10px; }
        .tab-button:not(.active):hover { color: var(--sf-text-primary); }
        .tab-button.active {
            color: var(--sf-primary); font-weight: 700; border-bottom-color: var(--sf-primary);
        }
        .tab-pane { display: none; animation: fadeIn 0.5s ease-in-out; }
        .tab-pane.active { display: block; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- SHARED CARD STYLE --- */
        .content-card {
            background-color: var(--sf-card-bg);
            border-radius: var(--sf-border-radius);
            border: 1px solid var(--sf-border-color);
            box-shadow: var(--sf-shadow);
            overflow: hidden;
        }

        /* --- IMPROVED: ACTIVE FILTER TAGS (SHARED) --- */
        .active-filters-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        .filter-tag {
            display: inline-flex;
            align-items: center;
            background-color: #e7f3ff;
            color: var(--sf-primary-dark);
            padding: 5px 10px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #b8d6f9;
        }
        .filter-tag .tag-label {
            color: #5a6d81;
            margin-right: 6px;
        }
        .filter-tag .tag-close-btn {
            all: unset; /* Reset button styles */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            margin-left: 8px;
            border-radius: 50%;
            background-color: #b8d6f9;
            color: var(--sf-primary-dark);
            font-size: 12px;
            line-height: 1;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }
        .filter-tag .tag-close-btn:hover {
            background-color: var(--sf-primary);
            color: white;
        }
        .clear-all-filters-btn {
            font-size: 13px;
            color: var(--sf-danger);
            background: transparent;
            border: none;
            font-weight: 500;
            cursor: pointer;
            padding: 5px;
            margin-left: 8px;
        }
        .clear-all-filters-btn:hover {
            text-decoration: underline;
        }

        /* --- SHARED FILTER & TABLE HEADER STYLES --- */
        thead th .filter-icon {
            margin-left: 8px; cursor: pointer; color: #adb5bd; transition: color 0.2s ease;
        }
        thead th .filter-icon:hover {
            color: var(--sf-text-primary);
        }
        thead th .filter-icon.active {
            color: var(--sf-primary);
        }
        .filter-popup {
            position: absolute; background-color: white; border: 1px solid #dee2e6; border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1); width: 250px; z-index: 1056;
            padding: 15px; display: none;
        }
        .filter-popup-content {
            max-height: 220px; overflow-y: auto; margin-top: 10px;
        }
        .filter-popup-footer {
            display: flex; justify-content: space-between; padding-top: 15px;
            margin-top: 10px; border-top: 1px solid #f1f1f1;
        }
        
        /* Styles specific to the #ingredients tab */
        #ingredients .filter-panel { padding: 25px; border-bottom: 1px solid var(--sf-border-color); }
        #ingredients .filter-grid { display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: end; }
        #ingredients .form-label { display: block; margin-bottom: 8px; font-size: 14px; color: var(--sf-text-primary); font-weight: 500; }
        #ingredients .form-control, #ingredients .form-select { width: 100%; padding: 10px 14px; border: 1px solid var(--sf-border-color); border-radius: 8px; box-sizing: border-box; font-size: 14px; height: 44px; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
        #ingredients .form-control:focus, #ingredients .form-select:focus { border-color: var(--sf-primary); box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2); outline: none; }
        #ingredients .btn { padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; justify-content: center; }
        #ingredients .btn-primary { background-color: var(--sf-primary); color: white; border-color: var(--sf-primary); }
        #ingredients .btn-primary:hover { background-color: var(--sf-primary-dark); border-color: var(--sf-primary-dark); }
        #ingredients .btn-info { background-color: var(--sf-info); color: white; border-color: var(--sf-info); }
        #ingredients .btn-outline-info { color: var(--sf-info); border-color: var(--sf-info); }
        #ingredients .btn-outline-info:hover { background-color: var(--sf-info); color: white; }
        #ingredients .btn-danger { background-color: var(--sf-danger); color: white; border-color: var(--sf-danger); }
        #ingredients .btn-success { background-color: var(--sf-success); color: white; border-color: var(--sf-success); }
        #ingredients .btn-secondary { background-color: #f0f2f5; color: var(--sf-text-secondary); border: 1px solid #e5e9f2; }
        #ingredients .btn-secondary:hover { background-color: #e5e9f2; color: var(--sf-text-primary); }
        #ingredients #globalClearBtn_ingredients { padding: 8px; line-height: 1; }
        #ingredients #globalClearBtn_ingredients i { margin: 0; }
        #ingredients .table-actions { padding: 15px 25px; display: flex; gap: 10px; }
        #ingredients .table-wrapper { overflow-x: auto; }
        #ingredients table { width: 100%; border-collapse: collapse; font-size: 14px; }
        #ingredients th, #ingredients td { padding: 16px 25px; text-align: left; border-bottom: 1px solid var(--sf-border-color); vertical-align: middle; }
        #ingredients thead { background-color: var(--sf-header-bg); }
        #ingredients thead th { font-weight: 600; color: var(--sf-text-secondary); border-bottom-width: 1px; border-color: var(--sf-border-color); text-transform: none; font-size: 13px; letter-spacing: 0.5px; }
        #ingredients tbody tr:last-child td { border-bottom: none; }
        #ingredients tbody tr:hover { background-color: var(--sf-hover-bg); }
        #ingredients .table-footer { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; font-size: 14px; color: var(--sf-text-secondary); border-top: 1px solid var(--sf-border-color); }
        #ingredients .action-btn { padding: 5px 10px; margin-right: 5px; border-radius: 6px; }
        #ingredients .action-btn .bi { vertical-align: middle; }
        #ingredients .keyword-container { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        #ingredients .keyword-badge { display: inline-flex; align-items: center; padding: 4px 10px; font-size: 12px; font-weight: 500; background-color: #e9ecef; border: 1px solid #dee2e6; border-radius: 16px; }
        /* -- Improved Keyword Button Styles -- */
        #ingredients .remove-keyword-btn { all: unset; display: inline-flex; justify-content: center; align-items: center; margin-left: 8px; width: 16px; height: 16px; border-radius: 50%; cursor: pointer; font-size: 12px; font-weight: bold; line-height: 1; color: #6c757d; transition: background-color 0.2s, color 0.2s; }
        #ingredients .remove-keyword-btn:hover { background-color: var(--sf-danger); color: white; }
        #ingredients .add-keyword-btn { all: unset; display: inline-flex; justify-content: center; align-items: center; width: 22px; height: 22px; border: 1.5px dashed #adb5bd; border-radius: 50%; cursor: pointer; color: #adb5bd; font-size: 16px; line-height: 1; font-weight: 600; transition: color 0.2s, border-color 0.2s; }
        #ingredients .add-keyword-btn:hover { color: var(--sf-primary); border-color: var(--sf-primary); }
        /* ------------------------------------ */
        #ingredients .fssai-symbol { display: inline-block; width: 16px; height: 16px; border: 1.5px solid; position: relative; vertical-align: middle; }
        #ingredients .fssai-symbol::before { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        #ingredients .fssai-veg { border-color: #128236; }
        #ingredients .fssai-veg::before { width: 8px; height: 8px; background-color: #128236; border-radius: 50%; }
        #ingredients .fssai-nonveg { border-color: #A5432D; }
        #ingredients .fssai-nonveg::before { width: 0; height: 0; background-color: transparent; border-left: 5px solid transparent; border-right: 5px solid transparent; border-bottom: 9px solid #A5432D; }
        #ingredients .type-container { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; }
        #ingredients .type-text { font-size: 11px; font-weight: 500; line-height: 1; color: #6c757d; }
    </style>

    <!-- STYLES FOR RECIPE TAB -->
    <style>
        /* --- GLOBAL & LAYOUT (Scoped to #recipe tab) --- */
        #recipe body {
            margin: 0; padding: 0; font-family: 'Roboto', sans-serif;
            background-color: #F7F9FC; color: #495057;
        }

        /* --- RECIPE LIST STYLES (now uses .content-card) --- */
        #recipeListContainer .filter-panel {
            padding: 20px 25px; border-bottom: 1px solid #dee2e6;
        }
        #recipeListContainer .btn {
            border: 1px solid transparent; padding: 10px 18px; border-radius: 6px; cursor: pointer;
            font-size: 14px; font-weight: 500; transition: all 0.2s ease-in-out;
            height: 40px;
        }
        #recipeListContainer .btn-danger { background-color: #dc3545; color: white; border-color: #dc3545; }
        #recipeListContainer .btn-danger:hover { background-color: #c82333; border-color: #bd2130;}
        #recipeListContainer .btn-primary { background-color: #0d6efd; color: white; border-color: #0d6efd; }
        #recipeListContainer .btn-primary:hover { background-color: #0b5ed7; border-color: #0a58ca; }
        #recipeListContainer .btn-secondary { background-color: #f8f9fa; color: #343a40; border-color: #ced4da; }
        #recipeListContainer .btn-secondary:hover { background-color: #e9ecef; border-color: #adb5bd; }
        #recipeListContainer .action-btn { padding: 5px 10px; margin: 2px; height: auto; }
        #recipeListContainer .action-btn .bi { vertical-align: middle; }
        
        #recipeListContainer .form-label { display: block; margin-bottom: 6px; font-size: 14px; color: #495057; font-weight: 500; }
        #recipeListContainer .form-control, #recipeListContainer .form-select {
            width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px;
            box-sizing: border-box; font-size: 14px; height: 40px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        /* --- Styles for the recipe filter bar --- */
        #recipeListContainer .filter-bar-main {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        #recipeListContainer .search-input-group {
            position: relative;
            flex-grow: 1;
        }
        #recipeListContainer .search-input-group .bi-search {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }
        #recipeListContainer .search-input-group #recipeGlobalSearchInput {
            padding-left: 35px;
        }
        #recipeListContainer .filter-buttons-group {
            display: flex;
            flex-shrink: 0;
            gap: 10px;
            align-items: center;
        }

        /* --- Styles for the recipe filter MODAL --- */
        #recipeFilterModal .modal-dialog {
             max-width: 600px;
        }
        #recipeFilterModal .modal-body {
            padding: 1rem 1.5rem;
        }
        #recipeFilterModal .row {
             margin-bottom: 1rem;
        }
        #recipeFilterModal .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            color: #495057;
        }
        #recipeFilterModal .form-control, 
        #recipeFilterModal .form-select,
        #recipeFilterModal .select2-container .select2-selection--single,
        #recipeFilterModal .select2-container .select2-selection--multiple {
            font-size: 0.9rem;
            min-height: 38px;
            height: 38px;
        }
        
        #recipeListContainer table {
            width: 100%; border-collapse: separate; border-spacing: 0; font-size: 14px;
        }
        #recipeListContainer th, #recipeListContainer td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; vertical-align: middle; }
        #recipeListContainer thead { background-color: #f8f9fa; }
        #recipeListContainer thead th {
            position: relative; font-weight: 600; color: #212529; border-bottom-width: 2px; border-color: #dee2e6;
            text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;
        }
        #recipeListContainer tbody tr:last-child td { border-bottom: none; }
        #recipeListContainer tbody tr:hover { background-color: #f1f5f9; }
        #recipeListContainer .fssai-symbol { display: inline-block; width: 16px; height: 16px; border: 1.5px solid; position: relative; vertical-align: middle; }
        #recipeListContainer .fssai-symbol::before { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        #recipeListContainer .fssai-veg { border-color: #128236; }
        #recipeListContainer .fssai-veg::before { width: 8px; height: 8px; background-color: #128236; border-radius: 50%; }
        #recipeListContainer .fssai-nonveg { border-color: #A5432D; }
        #recipeListContainer .fssai-nonveg::before { width: 0; height: 0; background-color: transparent; border-left: 5px solid transparent; border-right: 5px solid transparent; border-bottom: 9px solid #A5432D; }
        #recipeListContainer .type-container { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px; }
        #recipeListContainer .type-text { font-size: 11px; font-weight: 500; line-height: 1; color: #6c757d; }
        #recipeListContainer .unit-details-cell { font-size: 12px; line-height: 1.4; color: #495057; }
        #recipeListContainer .unit-details-cell b { color: #212529; }
        #recipeListContainer .deactivated-row { background-color: #f8f9fa !important; color: #6c757d; }
        #recipeListContainer .deactivated-row td, #recipeListContainer .deactivated-row b, #recipeListContainer .deactivated-row .fssai-symbol { color: #adb5bd !important; }
        #recipeListContainer .deactivated-row .fssai-veg, #recipeListContainer .deactivated-row .fssai-nonveg { border-color: #adb5bd; }
        #recipeListContainer .deactivated-row .fssai-veg::before, #recipeListContainer .deactivated-row .fssai-nonveg::before { background-color: #adb5bd; border-bottom-color: #adb5bd; }
        #recipeListContainer .table-footer { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; font-size: 14px; color: #6c757d; border-top: 1px solid #dee2e6; }


        /* --- RECIPE MAKER STYLES --- */
        #recipeMakerContainer { font-family: Arial, sans-serif; line-height: 1.6; }
        #recipeMakerContainer .content-card { padding: 30px; } /* Add padding to the new card wrapper */
        #recipeMakerContainer h1 { text-align: center; color: #333; margin-bottom: 25px; }
        #recipeMakerContainer h2, #recipeMakerContainer h3, #recipeMakerContainer h4, #recipeMakerContainer h5 { text-align: center; color: #333; }
        #recipeMakerContainer fieldset { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        #recipeMakerContainer legend { font-weight: bold; color: #555; padding: 0 10px; }
        #recipeMakerContainer input[type="text"], #recipeMakerContainer input[type="number"], #recipeMakerContainer input[type="file"], #recipeMakerContainer textarea, #recipeMakerContainer select { width: calc(100% - 22px); padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        #recipeMakerContainer textarea { resize: vertical; min-height: 60px;}
        #recipeMakerContainer input[readonly] { background-color: #f0f0f0; color: #555; cursor: default; }
        #recipeMakerContainer .section-step-header { display: flex; align-items: center; margin-bottom: 0px; margin-top:10px }
        #recipeMakerContainer .section-step-header .step-label { background-color: #5cb85c; color: white; padding: 8px 15px; font-weight: bold; border-radius: 4px 0 0 4px; }
        #recipeMakerContainer .section-step-header .step-title { padding: 8px 15px; background-color: #f0f0f0; border: 1px solid #ddd; border-left: none; border-radius: 0 4px 4px 0; flex-grow: 1; font-weight: bold; color: #333; }
        #recipeMakerContainer fieldset.step-header-fieldset > legend { background-color: #f0f0f0; border: 1px solid #ddd; border-radius: 4px 4px 0 0; padding: 0; margin-left: 0px; width: 100%; box-sizing: border-box; display: flex; align-items: stretch; border-bottom: 1px solid #ddd; line-height: normal; }
        #recipeMakerContainer fieldset.step-header-fieldset > legend .step-label-inline { background-color: #5cb85c; color: white; padding: 8px 15px; font-weight: bold; border-radius: 4px 0 0 0px; display: flex; align-items: center; white-space: nowrap; }
        #recipeMakerContainer fieldset.step-header-fieldset > legend .step-title-inline { padding: 8px 15px; font-weight: bold; color: #333; flex-grow: 1; background-color: #f0f0f0; border-left: none; display: flex; align-items: center; }
        #recipeMakerContainer fieldset.step-header-fieldset { padding-top: 15px; border-top: none; }
        #recipeMakerContainer .recipe-overview-group { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        #recipeMakerContainer .recipe-title-item { flex: 1 1 35%; min-width: 200px; } 
        #recipeMakerContainer .recipe-image-item { flex-grow: 0; flex-shrink: 0; flex-basis: auto; display: flex; flex-direction: column; align-items: flex-start; }
        #recipeMakerContainer .recipe-image-item .image-input-preview-container { display: flex; align-items: flex-end; gap: 5px; }
        #recipeMakerContainer .recipe-image-item label { margin-bottom: 3px; }
        #recipeMakerContainer .recipe-image-item input[type="file"] { width: auto; max-width: 150px; padding: 8px; margin-bottom:0; }
        #recipeMakerContainer #imagePreview { max-width:50px; max-height:50px; margin-bottom:0; border:1px solid #ddd; display:none; object-fit:cover; }
        #recipeMakerContainer .recipe-description-item { flex: 1 1 100%; margin-top: 10px; } 
        #recipeMakerContainer .recipe-description-item .label-button-group { display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px; }
        #recipeMakerContainer .recipe-description-item .label-button-group label { margin-bottom: 0;}
        #recipeMakerContainer #toggleDescriptionBtn { font-size: 0.8em; padding: 4px 8px; margin-bottom: 0; }
        #recipeMakerContainer .recipe-time-servings-item { flex-grow: 0; flex-shrink: 0; flex-basis: auto; }
        #recipeMakerContainer .recipe-time-servings-item label { margin-bottom: 0; } 
        #recipeMakerContainer .recipe-time-servings-item input { width: 100px; padding:8px; margin-bottom:0; }
        #recipeMakerContainer .ingredients-actions-group { display:flex; flex-wrap:wrap; gap:15px; align-items:flex-end; margin-bottom:10px; }
        #recipeMakerContainer .csv-upload-group { flex: 1 1 50%; display:flex; flex-direction: column; gap: 5px;}
        #recipeMakerContainer .csv-upload-group .file-process-row { display:flex; gap:10px; align-items:flex-end; }
        #recipeMakerContainer .csv-upload-group .file-process-row input[type="file"] { margin-bottom:0; padding:8px; width:auto; flex-grow:1; max-width: 250px;}
        #recipeMakerContainer .csv-upload-group .file-process-row button { margin-bottom:0; padding:8px 12px; }
        #recipeMakerContainer .csv-upload-group small { font-size: 0.8em; color: #666; }
        #recipeMakerContainer .db-search-group { flex: 1 1 40%; display:flex; flex-direction: column; gap: 5px;}
        #recipeMakerContainer .db-search-group .search-add-row { display: flex; gap: 10px; align-items: flex-end; }
        #recipeMakerContainer .db-search-group .search-add-row input[type="text"] { margin-bottom:0; padding:8px; flex-grow:1; }
        #recipeMakerContainer .db-search-group .search-add-row button { margin-bottom:0; padding: 8px 12px; flex-shrink: 0; background-color: #6c757d;}
        #recipeMakerContainer .review-table-card { margin-top: 20px; border: 1px solid #ddd; border-radius: 5px; }
        #recipeMakerContainer .review-table-card .card-header { padding: 10px 15px; border-bottom: 1px solid #ddd; border-radius: 5px 5px 0 0; }
        #recipeMakerContainer .review-table-card .card-header.bg-info { background-color: #e0f2f7; color: #31708f; }
        #recipeMakerContainer .review-table-card .card-header.bg-warning { background-color: #fff3cd; color: #664d03; }
        #recipeMakerContainer .review-table-card .card-header h5 { margin-bottom: .25rem; text-align: left; font-size: 1.1em;}
        #recipeMakerContainer .review-table-card .card-header p { margin-bottom: 0; font-size: 0.85em; text-align: left;}
        #recipeMakerContainer .review-table-card .card-body { padding: 15px; }
        #recipeMakerContainer .review-table-card table { width:100%; border-collapse: collapse; font-size: 0.9em; }
        #recipeMakerContainer .review-table-card th, #recipeMakerContainer .review-table-card td { border:1px solid #e0e0e0; padding:8px 10px; text-align:left; }
        #recipeMakerContainer .review-table-card th { background-color: #f8f9fa; }
        #recipeMakerContainer .review-table-card .badge { padding: .3em .5em; font-size: .75em; border-radius: .25rem; color: white; }
        #recipeMakerContainer .review-table-card .bg-success { background-color: #198754 !important; }
        #recipeMakerContainer .review-table-card .bg-info { background-color: #0dcaf0 !important; color: #000 !important; }
        #recipeMakerContainer .review-table-card .bg-secondary { background-color: #6c757d !important; }
        #recipeMakerContainer .review-table-card .btn-sm { padding: .25rem .5rem; font-size: .875rem; }
        #recipeMakerContainer #ingredientSearchResultsContainer { margin-top: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #f9f9f9; padding: 10px; display: none; }
        #recipeMakerContainer .search-result-list-inner { max-height: 250px; overflow-y: auto; margin-bottom: 10px; padding: 0; list-style-type: none; border: 1px solid #eee; }
        #recipeMakerContainer .search-result-header, #recipeMakerContainer .search-result-item { display: grid; grid-template-columns: 0.3fr 0.3fr 0.5fr 1.5fr 1fr 0.7fr 0.7fr 0.6fr 0.5fr 0.5fr 0.5fr; gap: 5px; padding: 8px 10px; font-size: 0.85em; align-items: center; border-bottom: 1px solid #eee; }
        #recipeMakerContainer .search-result-header { font-weight: bold; background-color: #f0f0f0; }
        #recipeMakerContainer .search-result-item:hover { background-color: #e9ecef; }
        #recipeMakerContainer .search-result-item div, #recipeMakerContainer .search-result-item input[type="checkbox"] { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        #recipeMakerContainer .search-result-item input[type="checkbox"] { margin-right: 5px; transform: scale(0.9); }
        #recipeMakerContainer .search-result-item .allergen-icon { font-style: italic; font-size: 0.9em; }
        #recipeMakerContainer .no-results-message { padding: 10px; text-align: center; color: #777; font-style: italic;}
        #recipeMakerContainer .fssai-logo-container { display: inline-flex; justify-content: center; align-items: center; width: 20px; height: 20px; }
        #recipeMakerContainer .fssai-logo { display: flex; width: 14px; height: 14px; border-width: 1.5px; border-style: solid; justify-content: center; align-items: center; box-sizing: border-box; }
        #recipeMakerContainer .fssai-veg .fssai-logo { border-color: #008000; }
        #recipeMakerContainer .fssai-veg .fssai-logo-dot { width: 7px; height: 7px; border-radius: 50%; background-color: #008000; }
        #recipeMakerContainer .fssai-nonveg .fssai-logo { border-color: #A0522D; }
        #recipeMakerContainer .fssai-nonveg .fssai-logo svg { fill: #A0522D; width: 90%;  height: 90%; }
        #recipeMakerContainer #selectedIngredientsReview { margin-top: 10px; padding: 8px; border: 1px dashed #ccc; background-color: #fff; font-size: 0.9em; }
        #recipeMakerContainer #selectedIngredientsReview p { margin: 0 0 8px 0; font-weight: bold; }
        #recipeMakerContainer .selected-items-container { display: flex; flex-wrap: wrap; gap: 8px; max-height: 80px; overflow-y: auto; }
        #recipeMakerContainer .selected-review-item { background-color: #e9ecef; padding: 4px 8px; border-radius: 4px; font-size: 0.9em; display: inline-flex; align-items: center; white-space: nowrap; }
        #recipeMakerContainer .remove-selected-review-btn { background-color: #dc3545; color: white; border: none; border-radius: 50%; width: 18px; height: 18px; font-size: 12px; line-height: 18px; text-align: center; cursor: pointer; margin-left: 6px; padding:0; font-weight: bold; }
        #recipeMakerContainer .remove-selected-review-btn:hover { background-color: #c82333; }
        #recipeMakerContainer #addSelectedIngredientsBtn { display: block; margin: 15px auto 0 auto; padding: 8px 15px; }
        #recipeMakerContainer .ingredients-table-container { overflow-x: auto; }
        #recipeMakerContainer .ingredient-header, #recipeMakerContainer .ingredient-item { display: grid; grid-template-columns: 0.3fr 0.4fr 0.4fr 0.8fr 1.5fr 1.5fr 1fr 1fr 1fr 0.7fr 0.7fr 0.7fr 0.7fr auto; gap: 6px; align-items: center; margin-bottom: 5px; padding-bottom: 5px; min-width: 1150px; }
        #recipeMakerContainer .ingredient-total-row { display: grid; grid-template-columns: 0.7fr 0.4fr 0.8fr 1.5fr 1.5fr 1fr 1fr 1fr 0.7fr 0.7fr 0.7fr 0.7fr auto; gap: 6px; align-items: center; margin-bottom: 5px; padding-bottom: 5px; min-width: 1150px; }
        #recipeMakerContainer .ingredient-header { font-weight:bold; border-bottom:1px solid #eee; margin-bottom:10px; font-size:0.9em; }
        #recipeMakerContainer .ingredient-header span, #recipeMakerContainer .ingredient-item > *, #recipeMakerContainer .ingredient-total-row > div { padding:4px; font-size:0.9em; overflow: hidden; text-overflow: ellipsis; }
        #recipeMakerContainer .ingredient-item .ingredient-logo-display { text-align: center; }
        #recipeMakerContainer .total-row-logo { display: flex; justify-content: center; align-items: center; }
        #recipeMakerContainer .ingredient-total-row > div.wrap-text { white-space: normal; word-break: break-word; }
        #recipeMakerContainer .ingredient-item input[type="text"], #recipeMakerContainer .ingredient-item input[type="number"] { width:100%; margin-bottom:0; padding:6px; }
        #recipeMakerContainer .ingredient-item input[type="checkbox"].ingredient-select-checkbox { width: auto; margin: auto; transform: scale(0.9); }
        #recipeMakerContainer .ingredient-total-row { border-top: 2px solid #333; margin-top: 10px; padding-top: 10px; font-weight: bold; background-color: #f8f9fa; }
        #recipeMakerContainer .ingredient-total-row > div { padding: 6px 4px; border-right: 1px solid #eee; }
        #recipeMakerContainer .ingredient-total-row > div:last-child { border-right: none; }
        #recipeMakerContainer .serving-notice { font-size: 0.85em; font-style: italic; color: #555; margin-left: 10px; font-weight: normal; }
        #recipeMakerContainer #deleteSelectedIngredientsBtn { margin: 10px 0 5px 0; background-color: #d9534f; }
        #recipeMakerContainer #deleteSelectedIngredientsBtn:hover { background-color: #c9302c; }
        #recipeMakerContainer .warning-bar { background-color: #e6e0c4; color: #54503c; padding: 10px 15px; border-radius: 4px; margin-bottom: 15px; display: flex; align-items: center; }
        #recipeMakerContainer .warning-bar .icon { font-size: 1.5em; margin-right: 10px; font-weight: bold; }
        #recipeMakerContainer .weight-inputs-group { display: flex; flex-wrap: wrap; gap: 15px; align-items: center; margin-top: 15px; }
        #recipeMakerContainer .weight-input-item { display: flex; align-items: center; border: 1px solid #007bff; border-radius: 4px; overflow: hidden; height: 38px; }
        #recipeMakerContainer .weight-input-item label { padding: 0 12px; margin-bottom: 0; background-color: #007bff; color: white; height: 100%; display: flex; align-items: center; font-weight: normal; font-size: 0.9em; }
        #recipeMakerContainer .weight-input-item input[type="number"] { border: none; border-radius: 0; margin-bottom: 0; padding: 8px 10px; width: 90px; text-align: right; height: 100%; box-sizing: border-box; border-left: 1px solid #007bff; border-right: 1px solid #007bff; }
        #recipeMakerContainer .weight-input-item input[readonly] { background-color: #e9ecef; color: #495057; }
        #recipeMakerContainer .weight-input-item .unit-indicator { padding: 0 10px; background-color: #007bff; color: white; font-weight: bold; font-size: 0.9em; height: 100%; display: flex; align-items: center; }
        #recipeMakerContainer #weightChange { width: 70px; } 
        #recipeMakerContainer #finalNutritionSummarySection table { width:100%; margin-top:10px; border-collapse: collapse; font-size: 0.9em; box-shadow: 0 2px 3px rgba(0,0,0,0.05); }
        #recipeMakerContainer #finalNutritionSummarySection th, #recipeMakerContainer #finalNutritionSummarySection td { border:1px solid #e0e0e0; padding:10px 12px; line-height: 1.4; }
        #recipeMakerContainer #finalNutritionSummarySection th { text-align:left; background-color: #f0f4f8; font-weight: 600; color: #333; }
        #recipeMakerContainer #finalNutritionSummarySection td:not(:first-child) { text-align:right; }
        #recipeMakerContainer #finalNutritionSummarySection td:first-child { font-weight: 500; } 
        #recipeMakerContainer #finalNutritionSummarySection tbody tr:nth-child(even) { background-color: #f9f9f9; }
        #recipeMakerContainer #finalNutritionSummarySection tbody tr:hover { background-color: #f1f1f1; }
        #recipeMakerContainer .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
        #recipeMakerContainer .modal-content { background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 5px; }
        #recipeMakerContainer .modal-header { display:flex; justify-content:space-between; align-items:center; padding-bottom:10px; border-bottom:1px solid #eee; }
        #recipeMakerContainer .modal-header .close-btn { font-size:1.5rem; font-weight:bold; cursor:pointer; border:none; background:none; }
        #recipeMakerContainer .modal-body { padding-top:15px; }
        #recipeMakerContainer .modal-footer { padding-top:15px; border-top:1px solid #eee; text-align:right; }
        #recipeMakerContainer .modal-footer button { margin-left:5px; }
        #recipeMakerContainer button, #recipeMakerContainer .button-link { background-color: #5cb85c; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em; margin-top: 5px; text-decoration: none; display: inline-block; }
        #recipeMakerContainer .button-link.secondary, #recipeMakerContainer button.secondary { background-color: #6c757d; }
        #recipeMakerContainer .button-link.secondary:hover, #recipeMakerContainer button.secondary:hover { background-color: #5a6268; }
        #recipeMakerContainer button:hover, #recipeMakerContainer .button-link:hover { background-color: #4cae4c; }
        #recipeMakerContainer button.remove-btn { background-color: #d9534f; padding: 6px 10px; font-size:0.9em; }
        #recipeMakerContainer button.remove-btn:hover { background-color: #c9302c; }
        #recipeMakerContainer .form-actions { display: flex; gap: 15px; margin-top: 20px; }
        #recipeMakerContainer .form-actions button { flex-grow: 1; padding: 12px; font-size: 1.1em; }
        #recipeMakerContainer #makerSaveRecipeDataBtn { background-color: #007bff; } 
        #recipeMakerContainer #makerSaveRecipeDataBtn:hover { background-color: #0056b3; }
        #recipeMakerContainer #downloadRecipeHtmlBtn { background-color: #17a2b8; } 
        #recipeMakerContainer #downloadRecipeHtmlBtn:hover { background-color: #117a8b; }
        #recipeMakerContainer hr { margin: 30px 0; border: 0; border-top: 1px solid #eee; }
        #recipeMakerContainer .matched { color: green; font-weight: bold; }
        #recipeMakerContainer .not-matched { color: orange; }
        #recipeMakerContainer .output-fssai-logo-container { display:inline-flex; vertical-align: middle; margin-right: 4px; }
        #recipeMakerContainer .validation-error { border: 1px solid red !important; animation: shake 0.5s; }
        @keyframes shake { 10%, 90% { transform: translate3d(-1px, 0, 0); } 20%, 80% { transform: translate3d(2px, 0, 0); } 30%, 50%, 70% { transform: translate3d(-4px, 0, 0); } 40%, 60% { transform: translate3d(4px, 0, 0); } }

        /* --- IMPROVEMENT: PDF Download Rules for Recipe Table --- */
        @media print {
            body * {
                visibility: hidden;
            }
            #recipeListContainer, #recipeListContainer * {
                visibility: visible;
            }
            #recipeListContainer {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print, .no-print * {
                display: none !important;
            }
            #recipeListContainer th:first-child,
            #recipeListContainer td:first-child,
            #recipeListContainer th:last-child,
            #recipeListContainer td:last-child {
                display: none;
            }
        }
        
        @media (max-width: 992px) {
            .layout-container { padding: 20px 15px; }
            #recipeListContainer .table-footer { flex-direction: column; align-items: stretch; gap: 15px; }
        }

        /* --- MOBILE VIEW STYLES (768px and below) --- */
        @media (max-width: 768px) {
            .tab-button[data-tab="ingredients"] {
                display: none;
            }
            
            /* Mobile Filter Modal: Bottom Sheet Style */
            #recipeFilterModal .modal-dialog {
                position: fixed;
                bottom: 0;
                margin: 0;
                width: 100%;
                max-width: 100%;
            }
            #recipeFilterModal .modal-content {
                max-height: 85vh;
                border-radius: 1.25rem 1.25rem 0 0;
                border: none;
            }
            
            /* Mobile Action Bar */
            #recipeListContainer .filter-panel { padding: 15px; }
            #recipeListContainer .filter-bar-main {
                display: flex;
                gap: 10px;
                align-items: center;
            }
            #recipeListContainer .filter-bar-main > .search-input-group {
                flex-grow: 1;
            }
             #recipeListContainer .filter-buttons-group {
                flex-shrink: 0; /* Prevent buttons from shrinking */
                display: flex;
                gap: 8px;
            }
            .mobile-actions-dropdown .dropdown-menu {
                width: 220px; /* Wider menu for easier tapping */
            }

            /* --- Mobile Card Layout for Table --- */
            #recipeListContainer thead,
            #recipeListContainer tbody tr.deactivated-row,
            #recipeListContainer tbody tr td:is(:nth-child(1), :nth-child(2), :nth-child(3), :nth-child(5), :nth-child(7), :nth-child(14)) { display: none; }
            #recipeListContainer table, #recipeListContainer tbody, #recipeListContainer tr { display: block; width: 100%; }
            #recipeListContainer td { border: none; padding: 0; display: block; width: 100%; }
            #recipeListContainer tbody tr { display: flex; flex-wrap: wrap; align-items: center; padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 15px; row-gap: 12px; column-gap: 8px; position: relative; }
            #recipeListContainer tbody tr:hover { background-color: #fff; }
            #recipeListContainer tbody tr td:nth-child(4) { order: 1; width: auto; }
            #recipeListContainer tbody tr td:nth-child(4) .type-container { gap: 0; }
            #recipeListContainer tbody tr td:nth-child(4) .type-text { display: none; }
            #recipeListContainer tbody tr td:nth-child(4) .fssai-symbol { width: 24px; height: 24px; }
            #recipeListContainer tbody tr td:nth-child(4) .fssai-veg::before { width: 10px; height: 10px; }
            #recipeListContainer tbody tr td:nth-child(4) .fssai-nonveg::before { border-left-width: 6px; border-right-width: 6px; border-bottom-width: 10px; }
            #recipeListContainer tbody tr td:nth-child(6) { order: 2; flex: 1; font-size: 1.2rem; font-weight: 500; line-height: 1.2; }
            #recipeListContainer tbody tr td:nth-child(9) { order: 3; width: 100%; }
            #recipeListContainer tbody tr td:nth-child(9) .portion-dropdown .btn { background-color: #f1f3f5; border: 1px solid #e9ecef; }
            #recipeListContainer tbody tr::before, #recipeListContainer tbody tr::after { font-size: .7rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: .5px; width: 100%; align-self: flex-start; }
            #recipeListContainer tbody tr::before { content: 'NUTRITIONAL INFORMATION'; order: 4; padding-bottom: 8px; border-bottom: 1px solid #e9ecef; }
            #recipeListContainer tbody tr::after { content: 'ALLERGENS'; order: 6; margin-top: 8px; padding-top: 12px; border-top: 1px solid #e9ecef; }
            
            /* Attractive Nutrient Cards */
            #recipeListContainer tbody tr td:is(:nth-child(10), :nth-child(11), :nth-child(12), :nth-child(13)) { 
                order: 5; 
                flex-basis: calc(50% - 6px); 
                flex-grow: 1; 
                background: #f8f9fa; 
                border-radius: 8px; 
                padding: 10px; 
            }
            .nutrient-display {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .nutrient-icon {
                font-size: 1.5rem;
                line-height: 1;
            }
            .nutrient-text {
                display: flex;
                flex-direction: column;
            }
            .nutrient-value { 
                font-size: 1.1rem; 
                font-weight: 500; 
                line-height: 1.1; 
                color: #212529; 
            }
            .nutrient-value small { 
                font-size: 0.75rem; 
                color: #6c757d; 
                text-transform: uppercase;
                margin-left: 2px;
            }
            .nutrient-label { 
                font-size: 0.7rem; 
                color: #6c757d; 
                text-transform: uppercase; 
                letter-spacing: 0.5px;
            }

            #recipeListContainer tbody tr td:nth-child(8) { order: 7; font-size: 0.9rem; align-self: flex-start; }
        }
        
        
        .d-flex button.btn {
    background: transparent !important;
    border: none !important;
}
    </style>
<body>

    <div class="wrapper">

    
@include('layouts.header')
<div class="page-wrapper">
        <div class="page-content">
      @yield('content')
  </div>
</div>
@include('layouts.footer')
   @stack('js')
      </div>

      </div>
   

	
	
	
</body>


   <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- PDF Generation Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    
     
    <script>
        // --- GLOBAL SHARED DATA ---
        window.masterIngredientData = [
            { id: 1, name: "Kadhai Gravy", symbol: "Veg", keyword: "Gravy, Indian, Base", refrence: "Open Source", allergen: "Dairy", portion: 100, energy: 79, protein: 1.9, carb: 5, fat: 6, createdOn: "2025-01-03 16:30:18", status: 'active' },
            { id: 2, name: "Lamb Leg", symbol: "NonVeg", keyword: "Meat, Mutton", refrence: "Open Source", allergen: "None", portion: 150, energy: 282, protein: 36, carb: 0, fat: 14, createdOn: "2025-01-03 15:51:08", status: 'active' },
            { id: 3, name: "Spelt Flour", symbol: "Veg", keyword: "Grain, Flour, Baking", refrence: "USDA, FSSAI", allergen: "Gluten", portion: 100, energy: 338, protein: 14.6, carb: 70.2, fat: 2.4, createdOn: "2024-11-20 10:00:00", status: 'active' },
            { id: 4, name: "Olive Oil", symbol: "Veg", keyword: "Oil, Fat, Cooking oil", refrence: "USDA", allergen: "None", portion: 100, energy: 884, protein: 0, carb: 0, fat: 100, createdOn: "2024-10-15 12:00:00", status: 'inactive' },
            { id: 5, name: "Tomato", symbol: "Veg", keyword: "Vegetable, Fruit, Salad", refrence: "USDA", allergen: "None", portion: 100, energy: 18, protein: 0.9, carb: 3.9, fat: 0.2, createdOn: "2024-09-01 11:00:00", status: 'active' },
            { id: 6, name: "Chicken Breast", symbol: "NonVeg", keyword: "Poultry, Meat, White meat", refrence: "Internal Recipe", allergen: "None", portion: 150, energy: 248, protein: 46.5, carb: 0, fat: 5.4, createdOn: "2024-08-15 14:00:00", status: 'active' },
            { id: 7, name: "Salt, table, iodised", symbol: "Veg", keyword: "Seasoning", refrence: "USDA", allergen: "None", portion: 100, energy: 0, protein: 0, carb: 0, fat: 0, createdOn: "2024-01-01 12:00:00", status: 'active' }
        ];
        
        // --- GLOBAL CONTEXT FOR MODAL ---
        let ingredientModalContext = 'master_list'; // 'master_list' or 'recipe_maker'
    </script>
    
    <!-- SCRIPT FOR INGREDIENTS TAB -->
    <script>
        (function($) {
            "use strict";
            let recipeData = [ { id: 101, name: "Spicy Lamb Curry", ingredients: [{ ingredientId: 2, quantity: 250, unit: 'g' }, { ingredientId: 1, quantity: 200, unit: 'g' }] }, { id: 102, name: "Tomato & Basil Soup", ingredients: [{ ingredientId: 5, quantity: 500, unit: 'g' }] }, { id: 103, name: "Simple Salad", ingredients: [{ ingredientId: 5, quantity: 150, unit: 'g' }, { ingredientId: 4, quantity: 15, unit: 'g' }] } ];
            let activeColumnFilters = {}; let globalPortionDisplayMode = 'actual_portion'; let currentFilteredData = []; let currentPage = 1; let entriesPerPage = 10; let currentRecipeUsageData = [];
            const ingredientManagementTableBody = $('#ingredientManagementTableBody_ingredients');
            function applyFiltersAndRender() { let filteredData = [...window.masterIngredientData]; filteredData.sort((a, b) => { if (a.status === 'active' && b.status === 'inactive') return -1; if (a.status === 'inactive' && b.status === 'active') return 1; return 0; }); const searchTerm = $('#globalSearchInput_ingredients').val().toLowerCase(); if (searchTerm) { filteredData = filteredData.filter(item => (item.name || '').toLowerCase().includes(searchTerm) || (item.keyword || '').toLowerCase().includes(searchTerm) || (item.refrence || '').toLowerCase().includes(searchTerm) || (item.allergen || '').toLowerCase().includes(searchTerm) ); } const filterKeys = Object.keys(activeColumnFilters); if (filterKeys.length > 0) { filteredData = filteredData.filter(item => { return filterKeys.every(key => { const filterValues = activeColumnFilters[key]; if (!filterValues || (Array.isArray(filterValues) && filterValues.length === 0)) return true; if (key === 'createdOn') { const itemDate = new Date(item.createdOn); if (isNaN(itemDate.getTime())) return false; const startDate = filterValues.from ? new Date(filterValues.from) : null; const endDate = filterValues.to ? new Date(filterValues.to) : null; if (startDate) startDate.setHours(0, 0, 0, 0); if (endDate) endDate.setHours(23, 59, 59, 999); const isAfterStart = startDate ? itemDate >= startDate : true; const isBeforeEnd = endDate ? itemDate <= endDate : true; return isAfterStart && isBeforeEnd; } if (key === 'allergen' && filterValues.includes('None')) { return filterValues.includes(item[key]) || item[key] === '' || item[key] === 'None'; } return filterValues.includes(item[key]); }); }); } currentFilteredData = filteredData; currentPage = 1; renderPaginatedView(); }
            function renderPaginatedView() { const totalEntries = currentFilteredData.length; const totalPages = Math.ceil(totalEntries / entriesPerPage); currentPage = Math.min(Math.max(1, currentPage), totalPages) || 1; const start = (currentPage - 1) * entriesPerPage; const end = start + entriesPerPage; const paginatedData = currentFilteredData.slice(start, end); renderTable(paginatedData); renderPaginationControls(totalPages, totalEntries, start); updateActionButtonsState(); renderActiveFilterTags_ingredients(); updateFilterIconStates_ingredients(); }
            function createKeywordHtml(item) { const keywords = item.keyword ? item.keyword.split(',').map(k => k.trim()).filter(k => k) : []; let html = '<div class="keyword-container">'; keywords.forEach(kw => { html += `<span class="keyword-badge">${kw} <button class="remove-keyword-btn" data-keyword="${kw}" data-id="${item.id}" title="Remove '${kw}'">×</button></span>`; }); html += `<button class="add-keyword-btn" data-id="${item.id}" title="Add Keyword">+</button>`; return html; }
            function renderTable(dataToRender) { if (!ingredientManagementTableBody.length) return; ingredientManagementTableBody.empty(); dataToRender.forEach((item, index) => { const basePortion = item.portion || 100; const rowHtml = `<tr class="${item.status === 'inactive' ? 'inactive-row' : ''}" data-id="${item.id}" data-base-portion-grams="${basePortion}" data-base-energy="${item.energy || 0}" data-base-protein="${item.protein || 0}" data-base-carb="${item.carb || 0}" data-base-fat="${item.fat || 0}"><td><input type="checkbox" class="form-check-input ingredient-item-checkbox" data-id="${item.id}"></td><td>${((currentPage - 1) * entriesPerPage) + index + 1}</td><td>${getSymbolHtml_IngredientsManagement(item.symbol)}</td><td>${formatTimestamp(item.createdOn)}</td><td data-field="name">${item.name || ''}</td><td>${createKeywordHtml(item)}</td><td>${item.refrence || ''}</td><td>${item.allergen || 'None'}</td><td>${initializePortionDropdownHtml(basePortion, globalPortionDisplayMode)}</td><td data-nutrient="energy"></td><td data-nutrient="protein"></td><td data-nutrient="carb"></td><td data-nutrient="fat"></td><td>${getActionButtonsHtml(item)}</td></tr>`; const $row = $(rowHtml); ingredientManagementTableBody.append($row); updateNutritionData_IngredientsManagement($row[0], globalPortionDisplayMode === 'by_100g' ? 100 : basePortion, null, false); }); $('#ingredientsSelectAllHeader_ingredients').prop('checked', false); }
            function getActionButtonsHtml(item) { const isActive = item.status === 'active'; const toggleButtonHtml = `<button class="btn btn-sm ${isActive ? 'btn-outline-success' : 'btn-outline-secondary'} action-btn" data-action="ToggleStatus" data-id="${item.id}" title="${isActive ? 'Deactivate' : 'Activate'}"><i class="bi ${isActive ? 'bi-toggle-on' : 'bi-toggle-off'}"></i></button>`; return `<div class="d-flex">${toggleButtonHtml}<button class="btn btn-sm btn-outline-secondary action-btn" data-action="Edit" data-id="${item.id}" title="Edit"><i class="bi bi-pencil"></i></button><button class="btn btn-sm btn-outline-primary action-btn" data-action="ShowRecipes" data-id="${item.id}" title="Show Recipe Usage"><i class="bi bi-card-list"></i></button><button class="btn btn-sm btn-outline-info action-btn" data-action="Duplicate" data-id="${item.id}" title="Duplicate"><i class="bi bi-files"></i></button><button class="btn btn-sm btn-outline-danger action-btn" data-action="Delete" data-id="${item.id}" title="Delete"><i class="bi bi-trash"></i></button></div>`; }
            function renderPaginationControls(totalPages, totalEntries, start) { const paginationContainer = $('#paginationContainer_ingredients'); const entriesInfo = $('#entriesInfo_ingredients'); paginationContainer.empty(); if (totalEntries === 0) { entriesInfo.text('No entries found.'); return; } const end = Math.min(start + entriesPerPage, totalEntries); entriesInfo.text(`Showing ${start + 1} to ${end} of ${totalEntries} entries.`); let li = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a></li>`; paginationContainer.append(li); for (let i = 1; i <= totalPages; i++) { li = `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`; paginationContainer.append(li); } li = `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`; paginationContainer.append(li); }
            function updateActionButtonsState() { $('#deleteSelectedBtn_ingredients').css('display', $('#ingredients .ingredient-item-checkbox:checked').length > 0 ? 'inline-flex' : 'none'); }
            function downloadCSV(data, filename = 'ingredients.csv', customHeaders = null) { if (data.length === 0) { alert("No data to download."); return; } const defaultHeaders = ['ID', 'Name', 'Type', 'Keyword', 'Reference', 'Allergen', 'Portion (g)', 'Energy (kcal)', 'Protein (g)', 'Carb (g)', 'Fat (g)', 'Created On']; const headers = customHeaders || defaultHeaders; const csv = [ headers.join(','), ...data.map(row => headers.map(fieldName => { let field; const lookupKey = fieldName.toLowerCase().replace(/ \(.+\)/, '').replace(/ /g, ''); switch(fieldName) { case 'Type': field = row.symbol; break; case 'Portion (g)': field = row.portion; break; case 'Reference': field = row.refrence; break; default: field = row[lookupKey]; } if (field === null || typeof field === 'undefined') { field = ''; } const str = String(field).replace(/"/g, '""'); return `"${str}"`; }).join(',')) ].join('\r\n'); const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' }); const link = document.createElement("a"); const url = URL.createObjectURL(blob); link.setAttribute("href", url); link.setAttribute("download", filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); }
            function getSymbolHtml_IngredientsManagement(symbolType) { if (!symbolType) return ''; const lowerSymbol = symbolType.toLowerCase(); let symbolClass = ''; if (lowerSymbol === 'veg') { symbolClass = 'fssai-veg'; } else if (lowerSymbol === 'nonveg') { symbolClass = 'fssai-nonveg'; } else { return symbolType; } return `<div class="type-container"><span class="fssai-symbol ${symbolClass}" title="${symbolType}"></span><span class="type-text">${symbolType}</span></div>`; }
            function createFilterPopup(filterKey, targetIcon) { closeAllPopups(); const popup = document.createElement('div'); popup.className = 'filter-popup'; popup.dataset.filterKey = filterKey; let contentHtml = ''; const searchInputHtml = ['name', 'refrence', 'allergen'].includes(filterKey) ? '<input type="search" class="form-control form-control-sm mb-2 filter-popup-search" placeholder="Search...">' : ''; if (filterKey === 'createdOn') { const dates = activeColumnFilters.createdOn || {}; contentHtml = `<div class="mb-2"><label class="form-label small">From</label><input type="date" class="form-control form-control-sm date-from-filter" value="${dates.from || ''}"></div><div><label class="form-label small">To</label><input type="date" class="form-control form-control-sm date-to-filter" value="${dates.to || ''}"></div>`; } else if (filterKey === 'portion_display') { const checkedActualPortion = globalPortionDisplayMode === 'actual_portion' ? 'checked' : ''; const checkedBy100g = globalPortionDisplayMode === 'by_100g' ? 'checked' : ''; contentHtml = `<div class="form-check"><input class="form-check-input" type="radio" name="portionDisplay" value="actual_portion" id="filter-display-actual" ${checkedActualPortion}><label class="form-check-label" for="filter-display-actual">Actual Portion</label></div><div class="form-check"><input class="form-check-input" type="radio" name="portionDisplay" value="by_100g" id="filter-display-100g" ${checkedBy100g}><label class="form-check-label" for="filter-display-100g">By 100g</label></div>`; } else { const uniqueValues = getUniqueColumnValues(filterKey); const activeFiltersForThisKey = activeColumnFilters[filterKey] || []; uniqueValues.forEach(value => { const isChecked = activeFiltersForThisKey.includes(value) ? 'checked' : ''; const id = `filter-${filterKey}-${value.replace(/[^a-zA-Z0-9]/g, '')}`; contentHtml += `<div class="form-check"><input class="form-check-input filter-checkbox" type="checkbox" value="${value}" id="${id}" ${isChecked}><label class="form-check-label" for="${id}">${value}</label></div>`; }); } popup.innerHTML = `${searchInputHtml}<div class="filter-popup-content">${contentHtml}</div><div class="filter-popup-footer"><button class="btn btn-sm btn-primary apply-filter">Apply</button><button class="btn btn-sm btn-outline-secondary clear-filter">Clear</button></div>`; document.body.appendChild(popup); const iconRect = targetIcon.getBoundingClientRect(); popup.style.display = 'block'; popup.style.position = 'absolute'; popup.style.left = `${iconRect.left}px`; popup.style.top = `${iconRect.bottom + 5}px`; }
            function renderActiveFilterTags_ingredients() { const container = $('#activeFilters_ingredients'); container.empty(); const filters = activeColumnFilters; let hasFilters = false; Object.keys(filters).forEach(key => { const values = filters[key]; if (key === 'createdOn' && (values.from || values.to)) { hasFilters = true; const from = values.from ? formatTimestamp(new Date(values.from)) : '...'; const to = values.to ? formatTimestamp(new Date(values.to)) : '...'; container.append(`<div class="filter-tag"><span class="tag-label">Created:</span> ${from} to ${to} <button class="tag-close-btn" data-filter-key="${key}">×</button></div>`); } else if (Array.isArray(values) && values.length > 0) { hasFilters = true; const keyLabel = $(`#ingredients th[data-filter-key="${key}"]`).contents().filter(function(){ return this.nodeType == 3; }).text().trim(); values.forEach(val => { container.append(`<div class="filter-tag"><span class="tag-label">${keyLabel}:</span> ${val} <button class="tag-close-btn" data-filter-key="${key}" data-filter-value="${val}">×</button></div>`); }); } }); if (globalPortionDisplayMode === 'by_100g') { hasFilters = true; container.append(`<div class="filter-tag"><span class="tag-label">Portion:</span> By 100g <button class="tag-close-btn" data-filter-key="portion_display">×</button></div>`); } if (hasFilters) { container.append(`<button class="clear-all-filters-btn" id="clearAllTagsBtn_ingredients">Clear All</button>`); } }
            function updateFilterIconStates_ingredients() { $('#ingredients th[data-filter-key]').each(function() { const key = $(this).data('filterKey'); const icon = $(this).find('.filter-icon'); let isActive = false; if (key === 'portion_display') { isActive = globalPortionDisplayMode === 'by_100g'; } else if (key === 'createdOn') { isActive = activeColumnFilters.createdOn && (activeColumnFilters.createdOn.from || activeColumnFilters.createdOn.to); } else { isActive = activeColumnFilters[key] && activeColumnFilters[key].length > 0; } if (isActive) { icon.addClass('active bi-funnel-fill').removeClass('bi-funnel'); } else { icon.removeClass('active bi-funnel-fill').addClass('bi-funnel'); } }); }
            function initializePortionDropdownHtml(baseGrams, displayMode) { let buttonText = ''; if (displayMode === 'by_100g') { buttonText = '100g'; } else { buttonText = `1 Portion (${baseGrams}g)`; } return `<div class="dropdown portion-dropdown"><button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">${buttonText}</button><ul class="dropdown-menu"><li><a class="dropdown-item portion-option" href="#" data-type="portion">1 Portion (${baseGrams}g)</a></li><li><a class="dropdown-item portion-option" href="#" data-type="100g">100g</a></li><li><a class="dropdown-item portion-option" href="#" data-type="custom">Customized...</a></li></ul></div>`; }
            function updateNutritionData_IngredientsManagement(row, targetGrams, newLabel, updateLabel = true) { const baseGrams = parseFloat(row.dataset.basePortionGrams); if (!baseGrams || isNaN(baseGrams) || baseGrams === 0) return; const baseEnergy = parseFloat(row.dataset.baseEnergy); const baseProtein = parseFloat(row.dataset.baseProtein); const baseCarb = parseFloat(row.dataset.baseCarb); const baseFat = parseFloat(row.dataset.baseFat); const ratio = targetGrams / baseGrams; row.querySelector('[data-nutrient="energy"]').textContent = (baseEnergy * ratio).toFixed(0); row.querySelector('[data-nutrient="protein"]').textContent = (baseProtein * ratio).toFixed(1); row.querySelector('[data-nutrient="carb"]').textContent = (baseCarb * ratio).toFixed(1); row.querySelector('[data-nutrient="fat"]').textContent = (baseFat * ratio).toFixed(1); if (updateLabel && newLabel) { const toggleButton = row.querySelector('.portion-dropdown .dropdown-toggle'); if(toggleButton) toggleButton.textContent = newLabel; } }
            function getUniqueColumnValues(key) { const values = new Set(); window.masterIngredientData.forEach(item => { let value = item[key] || (key === 'allergen' ? 'None' : ''); if (value) values.add(value); }); return Array.from(values).sort(); }
            function closeAllPopups() { $('.filter-popup').remove(); }
            function saveOrCancelEdit(inputElement, shouldSave) { const cell = inputElement.parentElement; const originalValue = cell.dataset.originalValue; let finalValue = originalValue; if (shouldSave) { const newValue = inputElement.value.trim(); if (newValue) { finalValue = newValue; const row = cell.closest('tr'); const itemId = parseFloat(row.dataset.id); const item = window.masterIngredientData.find(i => i.id === itemId); if (item) { item.name = finalValue; } } } cell.textContent = finalValue; cell.classList.remove('editing'); }
            function formatTimestamp(dateInput) { const d = new Date(dateInput); if (isNaN(d.getTime())) return ''; const year = d.getFullYear(); const month = String(d.getMonth() + 1).padStart(2, '0'); const day = String(d.getDate()).padStart(2, '0'); return `${day}-${month}-${year}`; }
            
            function parseCsvLine(line) {
                const result = [];
                let currentField = '';
                let inQuotedField = false;
                for (let i = 0; i < line.length; i++) {
                    const char = line[i];
                    if (char === '"' && (i === 0 || line[i - 1] !== '\\')) {
                         inQuotedField = !inQuotedField;
                    } else if (char === ',' && !inQuotedField) {
                        result.push(currentField);
                        currentField = '';
                    } else {
                        currentField += char;
                    }
                }
                result.push(currentField);
                return result.map(f => f.replace(/^"|"$/g, '').replace(/""/g, '"').trim());
            }
            
            // Expose the apply function to be called from other scripts if needed
            window.applyIngredientsFilters = applyFiltersAndRender;

            $(document).ready(function() {
                $('.tabs-nav').on('click', '.tab-button', function() { const $this = $(this); const targetTabId = $this.data('tab'); $('.tab-button').removeClass('active'); $('.tab-pane').removeClass('active'); $this.addClass('active'); $('#' + targetTabId).addClass('active'); });
                const referenceOptions = ["USDA", "FSSAI", "Open Source", "Internal Recipe", "Supplier Data"]; const allergenOptions = ["None", "Gluten", "Dairy", "Nuts", "Soy", "Fish", "Shellfish", "Eggs", "Sesame"]; const refSelect = $('#form-refrence-select'); const allergenSelect = $('#form-allergen-select'); referenceOptions.forEach(opt => refSelect.append(new Option(opt, opt))); allergenOptions.forEach(opt => allergenSelect.append(new Option(opt, opt))); function initMultiSelect(selector, placeholder) { selector.select2({ theme: 'bootstrap-5', dropdownParent: $('#ingredientModal'), placeholder: placeholder, closeOnSelect: false, templateResult: function (data) { if (!data.id) { return data.text; } var $option = $(`<span><input type="checkbox" /> ${data.text}</span>`); var isSelected = (selector.val() || []).indexOf(data.id) > -1; $option.find('input').prop('checked', isSelected); return $option; } }).on('select2:select', function(e) { $('.select2-results__option[id*="' + e.params.data.id + '"] input').prop('checked', true); }).on('select2:unselect', function(e) { $('.select2-results__option[id*="' + e.params.data.id + '"] input').prop('checked', false); }); }
                initMultiSelect(refSelect, "Select reference(s)"); initMultiSelect(allergenSelect, "Select allergen(s)");
                
                $('#addManualBtn').on('click', (e) => { 
                    e.preventDefault(); 
                    window.ingredientModalContext = 'master_list';
                    const ingredientModal = new bootstrap.Modal(document.getElementById('ingredientModal'));
                    ingredientModal.show(); 
                });
                
                $('#downloadRecipeUsageBtn').on('click', function(e) { e.preventDefault(); const ingredientId = $(this).data('ingredient-id'); const ingredient = window.masterIngredientData.find(i => i.id === ingredientId); const filename = `recipe_usage_${ingredient.name.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.csv`; const dataToExport = currentRecipeUsageData.map(recipe => { const usedIngredient = recipe.ingredients.find(ing => ing.ingredientId === ingredientId); return { recipename: recipe.name, quantityused: `${usedIngredient.quantity}${usedIngredient.unit}` }; }); downloadCSV(dataToExport, filename, ['Recipe Name', 'Quantity Used']); });
                $('#globalSearchInput_ingredients').on('input', applyFiltersAndRender);
                $('#globalClearBtn_ingredients').on('click', () => { $('#globalSearchInput_ingredients').val(''); activeColumnFilters = {}; globalPortionDisplayMode = 'actual_portion'; applyFiltersAndRender(); });
                $('#showEntriesSelect_ingredients').on('change', (e) => { entriesPerPage = parseInt(e.target.value, 10); currentPage = 1; renderPaginatedView(); });
                $('#deleteSelectedBtn_ingredients').on('click', () => { const checkedIds = Array.from($('#ingredients .ingredient-item-checkbox:checked')).map(cb => parseFloat(cb.dataset.id)); if (checkedIds.length === 0 || !confirm(`Are you sure you want to delete ${checkedIds.length} selected ingredient(s)?`)) return; window.masterIngredientData = window.masterIngredientData.filter(item => !checkedIds.includes(item.id)); applyFiltersAndRender(); });
                $('#downloadExcelOption_ingredients').on('click', (e) => { e.preventDefault(); downloadCSV(currentFilteredData, 'ingredients_export.csv'); });
                $('#downloadPdfOption_ingredients').on('click', (e) => { e.preventDefault(); window.print(); });
                $('#importBtn').on('click', (e) => { e.preventDefault(); const fileInput = document.createElement('input'); fileInput.type = 'file'; fileInput.accept = '.csv'; fileInput.style.display = 'none'; fileInput.onchange = e => { const file = e.target.files[0]; if (!file) return; const reader = new FileReader(); reader.onload = (event) => { const text = event.target.result; try { const newIngredients = []; const lines = text.split(/\r\n|\n/).filter(line => line.trim() !== ''); if (lines.length < 2) throw new Error("CSV must contain a header and at least one data row."); const headers = parseCsvLine(lines.shift()); const headerMapping = { 'Name': 'name', 'Type': 'symbol', 'Keyword': 'keyword', 'Reference': 'refrence', 'Allergen': 'allergen', 'Portion (g)': 'portion', 'Energy (kcal)': 'energy', 'Protein (g)': 'protein', 'Carb (g)': 'carb', 'Fat (g)': 'fat' }; const internalKeys = headers.map(h => headerMapping[h.trim()]); lines.forEach(line => {  const values = parseCsvLine(line); if (values.length !== headers.length) { console.warn('Skipping malformed CSV line:', line); return; } const newIngredient = {}; internalKeys.forEach((key, index) => { if (key) newIngredient[key] = values[index] || ''; }); if (!newIngredient.portion || isNaN(parseFloat(newIngredient.portion))) { newIngredient.portion = 100; } newIngredient.id = Date.now() + Math.random(); newIngredient.createdOn = new Date().toISOString(); newIngredient.status = 'active'; if(newIngredient.name) newIngredients.push(newIngredient); }); window.masterIngredientData.unshift(...newIngredients); applyFiltersAndRender(); alert(`Successfully imported ${newIngredients.length} ingredients.`); } catch (error) { console.error("CSV Parsing Error:", error); alert("Failed to import CSV. Please check the file format and ensure it matches the sample."); } }; reader.onerror = () => alert("Error reading the file."); reader.readAsText(file); document.body.removeChild(fileInput); }; document.body.appendChild(fileInput); fileInput.click(); });
                $('#sampleCsvBtn').on('click', (e) => { e.preventDefault(); const sampleHeaders = ['Name', 'Type', 'Keyword', 'Reference', 'Allergen', 'Portion (g)', 'Energy (kcal)', 'Protein (g)', 'Carb (g)', 'Fat (g)']; const sampleCsvData = [ { name: "Tomato", symbol: "Veg", keyword: "Vegetable, Fruit", refrence: "USDA", allergen: "None", portion: 100, energy: 18, protein: 0.9, carb: 3.9, fat: 0.2 }, { name: "Chicken Breast", symbol: "NonVeg", keyword: "Poultry, Meat", refrence: "Internal Recipe", allergen: "None", portion: 150, energy: 248, protein: 46.5, carb: 0, fat: 5.4 } ]; downloadCSV(sampleCsvData, 'ingredients_import_sample.csv', sampleHeaders); });
                $('#activeFilters_ingredients').on('click', 'button', function() { if ($(this).is('#clearAllTagsBtn_ingredients')) { $('#globalClearBtn_ingredients').click(); return; } const key = $(this).data('filter-key'); const value = String($(this).data('filter-value')); if (key === 'portion_display') { globalPortionDisplayMode = 'actual_portion'; } else if (value && value !== 'undefined') { let currentValues = activeColumnFilters[key]; if (currentValues) { activeColumnFilters[key] = currentValues.filter(v => v !== value); if (activeColumnFilters[key].length === 0) { delete activeColumnFilters[key]; } } } else { delete activeColumnFilters[key]; } applyFiltersAndRender(); });
                $(document.body).on('click', (e) => { const target = e.target; if ($(target).closest('#ingredients').length && target.classList.contains('filter-icon')) { e.stopPropagation(); createFilterPopup(target.parentElement.dataset.filterKey, target); return; } if (!target.closest('.filter-popup')) { closeAllPopups(); } if (target.classList.contains('apply-filter')) { const p = target.closest('.filter-popup'); if (p && !$(p).closest('#recipeListContainer').length) { const k = p.dataset.filterKey; if (k === 'createdOn') { const from = p.querySelector('.date-from-filter').value; const to = p.querySelector('.date-to-filter').value; if(from || to) { activeColumnFilters.createdOn = { from, to }; } else { delete activeColumnFilters.createdOn; } } else if (k === 'portion_display') { const selectedRadio = p.querySelector('input[name="portionDisplay"]:checked'); globalPortionDisplayMode = selectedRadio ? selectedRadio.value : 'actual_portion'; } else { const v = Array.from(p.querySelectorAll('.filter-checkbox:checked')).map(cb => cb.value); if (v.length > 0) activeColumnFilters[k] = v; else delete activeColumnFilters[k]; } applyFiltersAndRender(); closeAllPopups(); } } if (target.classList.contains('clear-filter')) { const p = target.closest('.filter-popup'); if (p && !$(p).closest('#recipeListContainer').length) { const k = p.dataset.filterKey; if (k === 'portion_display') { globalPortionDisplayMode = 'actual_portion'; } else { delete activeColumnFilters[key]; } applyFiltersAndRender(); closeAllPopups(); } } });
                $(document.body).on('input', '.filter-popup-search', (e) => { const searchTerm = e.target.value.toLowerCase(); const content = e.target.nextElementSibling; $(content).find('.form-check').each(function() { const label = $(this).find('label').text().toLowerCase(); $(this).css('display', label.includes(searchTerm) ? '' : 'none'); }); });
                $('#ingredientsSelectAllHeader_ingredients').on('change', (e) => { $('#ingredientManagementTableBody_ingredients .ingredient-item-checkbox').prop('checked', e.target.checked); updateActionButtonsState(); });
                $('#paginationContainer_ingredients').on('click', 'a.page-link', (e) => { e.preventDefault(); const $link = $(e.currentTarget); if (!$link.parent().hasClass('disabled')) { currentPage = parseInt($link.data('page')); renderPaginatedView(); } });
                $('#ingredientManagementTableBody_ingredients').on('change', '.ingredient-item-checkbox', updateActionButtonsState);
                $('#ingredientManagementTableBody_ingredients').on('click', (e) => { const actionButton = e.target.closest('.action-btn'); const portionOption = e.target.closest('.portion-option'); const addKeywordButton = e.target.closest('.add-keyword-btn'); const removeKeywordButton = e.target.closest('.remove-keyword-btn'); if (actionButton) { e.preventDefault(); const action = actionButton.dataset.action; const id = parseFloat(actionButton.dataset.id); const item = window.masterIngredientData.find(i => i.id === id); if (!item) return; switch (action) { case 'ToggleStatus': item.status = (item.status === 'active') ? 'inactive' : 'active'; applyFiltersAndRender(); break; case 'Edit': window.ingredientModalContext = 'master_list'; $('#ingredientForm').data('editing-id', item.id); $('#ingredientModalLabel').text('Edit Ingredient'); $('#form-name').val(item.name); $('#form-symbol').val(item.symbol); $('#form-keyword').val(item.keyword); $('#form-portion').val(item.portion); $('#form-energy').val(item.energy); $('#form-protein').val(item.protein); $('#form-carb').val(item.carb); $('#form-fat').val(item.fat); const refArray = item.refrence ? item.refrence.split(', ') : []; $('#form-refrence-select').val(refArray).trigger('change'); const allergenArray = item.allergen ? item.allergen.split(', ') : []; $('#form-allergen-select').val(allergenArray).trigger('change'); new bootstrap.Modal(document.getElementById('ingredientModal')).show(); break; case 'ShowRecipes': currentRecipeUsageData = recipeData.filter(recipe => recipe.ingredients.some(ing => ing.ingredientId === item.id)); const tableBody = $('#recipeUsageModal #recipeListTableBody'); tableBody.empty(); $('#recipeUsageModalLabel').text(`Recipes Using "${item.name}"`); $('#downloadRecipeUsageBtn').data('ingredient-id', item.id); if (currentRecipeUsageData.length > 0) { currentRecipeUsageData.forEach(recipe => { const usedIngredient = recipe.ingredients.find(ing => ing.ingredientId === item.id); const rowHtml = `<tr><td>${recipe.name}</td><td><b>${usedIngredient.quantity}${usedIngredient.unit}</b></td></tr>`; tableBody.append(rowHtml); }); } else { tableBody.append('<tr><td colspan="2" class="text-center">This ingredient is not used in any recipes.</td></tr>'); } new bootstrap.Modal(document.getElementById('recipeUsageModal')).show(); break; case 'Delete': if (confirm(`Are you sure you want to delete "${item.name}"?`)) { window.masterIngredientData = window.masterIngredientData.filter(i => i.id !== id); applyFiltersAndRender(); } break; case 'Duplicate': const newItem = { ...item, id: Date.now() + Math.random(), name: `Copy of ${item.name}`, createdOn: new Date(), status: 'active' }; window.masterIngredientData.unshift(newItem); applyFiltersAndRender(); break; } } else if (portionOption) { e.preventDefault(); const row = portionOption.closest('tr'); const type = portionOption.dataset.type; const baseGrams = parseFloat(row.dataset.basePortionGrams); if (type === 'portion') { updateNutritionData_IngredientsManagement(row, baseGrams, `1 Portion (${baseGrams}g)`); } else if (type === '100g') { updateNutritionData_IngredientsManagement(row, 100, '100g'); } else if (type === 'custom') { const customGramsStr = prompt("Enter custom portion size in grams:", "150"); if (customGramsStr) { const customGramsNum = parseFloat(customGramsStr); if (!isNaN(customGramsNum) && customGramsNum > 0) { updateNutritionData_IngredientsManagement(row, customGramsNum, `Custom (${customGramsNum}g)`); } else { alert("Please enter a valid positive number for grams."); } } } } else if (addKeywordButton) { e.preventDefault(); const id = parseFloat(addKeywordButton.dataset.id); const item = window.masterIngredientData.find(i => i.id === id); const newKeyword = prompt(`Add keyword for "${item.name}":`); if (newKeyword && newKeyword.trim()) { const keywords = item.keyword ? item.keyword.split(',').map(k => k.trim()).filter(Boolean) : []; keywords.push(newKeyword.trim()); item.keyword = keywords.join(', '); applyFiltersAndRender(); } } else if (removeKeywordButton) { e.preventDefault(); const id = parseFloat(removeKeywordButton.dataset.id); const keywordToRemove = removeKeywordButton.dataset.keyword; const item = window.masterIngredientData.find(i => i.id === id); if (item && item.keyword) { let keywords = item.keyword.split(',').map(k => k.trim()); keywords = keywords.filter(k => k !== keywordToRemove); item.keyword = keywords.join(', '); applyFiltersAndRender(); } } });
                $('#ingredientManagementTableBody_ingredients').on('dblclick', 'td[data-field="name"]', (e) => { const cell = e.currentTarget; if (cell.classList.contains('editing')) return; const originalValue = cell.textContent.trim(); cell.dataset.originalValue = originalValue; cell.classList.add('editing'); cell.innerHTML = `<input type="text" class="form-control edit-input" value="${originalValue}" />`; const input = cell.querySelector('.edit-input'); input.focus(); input.select(); });
                $('#ingredientManagementTableBody_ingredients').on('blur', '.edit-input', (e) => { saveOrCancelEdit(e.target, true); }, true);
                $('#ingredientManagementTableBody_ingredients').on('keydown', '.edit-input', (e) => { if (e.key === 'Enter') { e.preventDefault(); saveOrCancelEdit(e.target, true); } else if (e.key === 'Escape') { e.preventDefault(); saveOrCancelEdit(e.target, false); } });
                
                applyFiltersAndRender(); 
            });
        })(jQuery);
    </script>

    <!-- SCRIPT FOR RECIPE TAB, MAKER & GLOBAL MODAL HANDLING -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recipeComponentRoot = document.getElementById('recipe');
            if (!recipeComponentRoot) return;

            // --- UI ELEMENT REFERENCES ---
            const recipeListContainer = recipeComponentRoot.querySelector('#recipeListContainer');
            const recipeMakerContainer = recipeComponentRoot.querySelector('#recipeMakerContainer');
            const createRecipeBtn = recipeComponentRoot.querySelector('#createRecipeBtn');
            const mobileCreateRecipeBtn = recipeComponentRoot.querySelector('#mobileCreateRecipeBtn');
            const filterModalEl = document.getElementById('recipeFilterModal');
            let recipeMakerInitialized = false;
            let unitHierarchy = {};

            // --- VIEW MANAGEMENT ---
            function showRecipeListView() {
                if(recipeMakerContainer) recipeMakerContainer.style.display = 'none';
                if(recipeListContainer) recipeListContainer.style.display = 'block';
                window.scrollTo(0, 0);
            }

            function showRecipeMakerView() {
                if(recipeListContainer) recipeListContainer.style.display = 'none';
                if(recipeMakerContainer) recipeMakerContainer.style.display = 'block';
                window.scrollTo(0, 0);
                if (!recipeMakerInitialized) {
                    setupRecipeMaker();
                    recipeMakerInitialized = true;
                }
            }
            
            // --- DATA & STATE FOR RECIPE LIST (WITH INGREDIENTS FOR EDITING) ---
            let tableData_RecipeList = [
                { id: 101, corporateName: "SFM Corporate", regionalName: "North India", unitName: "SFM Delhi Kitchen", name: "Spicy Lamb Curry", symbol: "NonVeg", refrence: "Internal, Open Source", allergen: "None, Dairy", portion: 250, energy: "450", protein: "40.5", carb: "5.0", fat: "25.0", createdOn: "2025-02-10 12:00:00", isActive: true, deactivatedOn: null, servings: 1, description: "A rich and spicy lamb curry.", notes: "Can be made spicier by adding more chili.", ingredients: [{ ingredientId: 2, quantity: 150 }, { ingredientId: 1, quantity: 120 }] },
                { id: 102, corporateName: "SFM Corporate", regionalName: "South India", unitName: "SFM Chennai Kitchen", name: "Vegan Lentil Soup", symbol: "Veg", refrence: "Internal", allergen: "None", portion: 300, energy: "250", protein: "12.5", carb: "35.0", fat: "5.0", createdOn: "2025-01-15 10:00:00", isActive: true, deactivatedOn: null, servings: 2, description: "A hearty and healthy vegan soup.", notes: "", ingredients: [{ ingredientId: 5, quantity: 450 }] },
                { id: 103, corporateName: "SFM Corporate", regionalName: "North India", unitName: "SFM Gurgaon Canteen", name: "Chicken Tikka Skewers", symbol: "NonVeg", refrence: "FSSAI", allergen: "Dairy", portion: 180, energy: "320", protein: "35.0", carb: "3.0", fat: "18.0", createdOn: "2024-12-20 14:00:00", isActive: false, deactivatedOn: "2025-02-01 09:00:00", servings: 1, description: "Classic chicken skewers.", notes: "Marinate overnight for best results.", ingredients: [{ ingredientId: 6, quantity: 150 }, { ingredientId: 1, quantity: 50 }] },
                { id: 104, corporateName: "Global Foods", regionalName: "West", unitName: "Mumbai Central", name: "Paneer Butter Masala", symbol: "Veg", refrence: "Open Source", allergen: "Dairy, Nuts", portion: 280, energy: "480", protein: "15.0", carb: "12.0", fat: "40.0", createdOn: "2024-11-05 18:00:00", isActive: true, deactivatedOn: null, servings: 4, description: "A creamy and rich paneer dish.", notes: "Add a touch of honey to balance the tanginess.", ingredients: [{ ingredientId: 1, quantity: 200 }, { ingredientId: 4, quantity: 30 }] },
            ];
            
            let recipeActiveColumnFilters = {};
            let recipeGlobalPortionDisplayMode = 'actual_portion';
            let recipeCurrentFilteredData = []; 
            let recipeCurrentPage = 1; 
            let recipeEntriesPerPage = 10;
            const recipeTableBody = recipeComponentRoot.querySelector('#recipeTableBody');
            
            // --- CORE FILTERING & RENDERING LOGIC ---
            function applyFiltersAndRender_Recipes() { 
                let filteredData = [...tableData_RecipeList]; 
                
                const searchTerm = recipeComponentRoot.querySelector('#recipeGlobalSearchInput').value.toLowerCase(); 
                if (searchTerm) { 
                    filteredData = filteredData.filter(item => 
                        (item.name || '').toLowerCase().includes(searchTerm)
                    ); 
                }
                
                const filterKeys = Object.keys(recipeActiveColumnFilters);
                if (filterKeys.length > 0) {
                    filteredData = filteredData.filter(item => {
                        return filterKeys.every(key => {
                            const filter = recipeActiveColumnFilters[key];
                            if (!filter || Object.keys(filter).length === 0) return true;

                            switch (key) {
                                case 'type':
                                    if (filter.value && item.symbol !== filter.value) return false;
                                    return true;
                                case 'unit':
                                    if (filter.corporate && item.corporateName !== filter.corporate) return false;
                                    if (filter.regional && item.regionalName !== filter.regional) return false;
                                    if (filter.unit && item.unitName !== filter.unit) return false;
                                    return true;
                                case 'dateRange':
                                    const itemDate = new Date(item.createdOn);
                                    const from = filter.from ? new Date(filter.from) : null;
                                    const to = filter.to ? new Date(filter.to) : null;
                                    if(from) from.setHours(0, 0, 0, 0);
                                    if(to) to.setHours(23, 59, 59, 999);
                                    return (!from || itemDate >= from) && (!to || itemDate <= to);
                                case 'kcalRange':
                                     const itemPortion = parseFloat(item.portion) || 100;
                                     const itemEnergy = parseFloat(item.energy);
                                     if (itemPortion === 0 || isNaN(itemEnergy)) return false;
                                     const kcalPer100g = (itemEnergy / itemPortion) * 100;
                                     
                                     const min = filter.min;
                                     const max = filter.max;
                                     return (min === null || kcalPer100g >= min) && (max === null || kcalPer100g <= max);
                                case 'references':
                                case 'allergens':
                                    if (!filter.values || filter.values.length === 0) return true;
                                    const itemProps = (item[key.slice(0, -1)] || '').split(',').map(v => v.trim());
                                    return filter.values.some(v => itemProps.includes(v));
                                default:
                                    return true;
                            }
                        });
                    });
                }
                
                filteredData.sort((a, b) => { 
                    if (a.isActive !== b.isActive) { return b.isActive - a.isActive; } 
                    return new Date(b.createdOn) - new Date(b.createdOn); 
                }); 
                
                recipeCurrentFilteredData = filteredData; 
                recipeCurrentPage = 1; 
                renderPaginatedView_Recipes(); 
            }

            function renderPaginatedView_Recipes(isForPrint = false) { 
                if(!recipeTableBody) return;

                let dataToRenderForView = recipeCurrentFilteredData;
                if (isForPrint) {
                    dataToRenderForView = recipeCurrentFilteredData.filter(item => item.isActive);
                    if (recipeGlobalPortionDisplayMode === 'per_100g') {
                        dataToRenderForView = dataToRenderForView.map(item => {
                            const newItem = { ...item }; 
                            if (newItem.portion > 0) {
                                const ratio = 100 / newItem.portion;
                                newItem.energy = (newItem.energy * ratio).toFixed(0);
                                newItem.protein = (newItem.protein * ratio).toFixed(1);
                                newItem.carb = (newItem.carb * ratio).toFixed(1);
                                newItem.fat = (newItem.fat * ratio).toFixed(1);
                                newItem.portion = 100;
                            }
                            return newItem;
                        });
                    }
                }

                const totalEntries = dataToRenderForView.length;
                const displayEntries = isForPrint ? totalEntries : recipeEntriesPerPage;
                const displayPage = isForPrint ? 1 : recipeCurrentPage;
                const totalPages = Math.ceil(totalEntries / displayEntries);
                recipeCurrentPage = Math.min(Math.max(1, displayPage), totalPages) || 1;
                const start = (recipeCurrentPage - 1) * displayEntries;
                const end = start + displayEntries;
                const paginatedData = dataToRenderForView.slice(start, end);

                renderTable_Recipes(paginatedData, isForPrint);

                if (!isForPrint) {
                    renderPaginationControls_Recipes(totalEntries, start);
                    updateActionButtonsState_Recipes();
                    renderActiveFilterTags_recipes();
                }
            }
            
            // --- TABLE & UI ELEMENT GENERATION ---
            function renderTable_Recipes(dataToRender, isForPrint = false) { 
                if (!recipeTableBody) return; 
                recipeTableBody.innerHTML = ''; 
                dataToRender.forEach((item, index) => { 
                    const row = recipeTableBody.insertRow(); 
                    if (!item.isActive) { row.classList.add('deactivated-row'); } 
                    row.dataset.id = item.id; 
                    row.dataset.basePortionGrams = item.portion || 100; 
                    row.dataset.baseEnergy = item.energy || 0; 
                    row.dataset.baseProtein = item.protein || 0; 
                    row.dataset.baseCarb = item.carb || 0; 
                    row.dataset.baseFat = item.fat || 0; 
                    
                    row.insertCell().innerHTML = isForPrint ? '' : `<input type="checkbox" class="form-check-input recipe-item-checkbox" data-id="${item.id}">`;
                    row.insertCell().textContent = ((recipeCurrentPage - 1) * recipeEntriesPerPage) + index + 1; 
                    const unitDetailsCell = row.insertCell(); 
                    unitDetailsCell.classList.add('unit-details-cell'); 
                    unitDetailsCell.innerHTML = `<div><b>Corporate:</b> ${item.corporateName || 'N/A'}</div><div><b>Regional:</b> ${item.regionalName || 'N/A'}</div><div><b>Unit:</b> ${item.unitName || 'N/A'}</div>`; 
                    row.insertCell().innerHTML = isForPrint ? getSymbolHtmlForPrint_Recipes(item.symbol) : getSymbolHtml_Recipes(item.symbol);
                    const dateCell = row.insertCell(); 
                    if(item.isActive) { dateCell.innerHTML = `Created: <br>${formatTimestamp_Recipes(item.createdOn)}`; } else { dateCell.innerHTML = `Deactivated: <br>${formatTimestamp_Recipes(item.deactivatedOn)}`; } 
                    const nameCell = row.insertCell(); nameCell.textContent = item.name || ''; nameCell.dataset.field = 'name'; 
                    row.insertCell().textContent = item.refrence || ''; 
                    row.insertCell().textContent = item.allergen || 'None'; 
                    
                    const portionCell = row.insertCell();
                    portionCell.innerHTML = isForPrint ? `${item.portion || 100}g` : initializePortionDropdownHtml_Recipes(item.portion || 100);
                    
                    ['energy', 'protein', 'carb', 'fat'].forEach(nutrient => {
                        const cell = row.insertCell();
                        cell.dataset.nutrient = nutrient; 
                        cell.dataset.nutrientLabel = nutrient.charAt(0).toUpperCase() + nutrient.slice(1);
                    });
                    
                    updateNutritionData_Recipes(row, recipeGlobalPortionDisplayMode === 'per_100g' && !isForPrint ? 100 : (item.portion || 100), null, false); 
                    
                    const actionsCell = row.insertCell(); 
                    actionsCell.innerHTML = isForPrint ? '' : getActionButtonsHtml_Recipes(item);
                }); 
                const selectAllHeader = recipeComponentRoot.querySelector('#recipeSelectAllHeader');
                if (selectAllHeader) selectAllHeader.checked = false; 
            }

            function renderPaginationControls_Recipes(totalEntries, start) { const paginationContainer = recipeComponentRoot.querySelector('#recipePaginationContainer'); const entriesInfo = recipeComponentRoot.querySelector('#recipeEntriesInfo'); if(!paginationContainer || !entriesInfo) return; paginationContainer.innerHTML = ''; if (totalEntries === 0) { entriesInfo.textContent = 'No recipes found.'; return; } const end = Math.min(start + recipeEntriesPerPage, totalEntries); entriesInfo.textContent = `Showing ${start + 1} to ${end} of ${totalEntries} entries.`; const totalPages = Math.ceil(totalEntries / recipeEntriesPerPage); let li = document.createElement('li'); li.className = `page-item ${recipeCurrentPage === 1 ? 'disabled' : ''}`; li.innerHTML = `<a class="page-link" href="#" data-page="${recipeCurrentPage - 1}">Previous</a>`; paginationContainer.appendChild(li); for (let i = 1; i <= totalPages; i++) { li = document.createElement('li'); li.className = `page-item ${recipeCurrentPage === i ? 'active' : ''}`; li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`; paginationContainer.appendChild(li); } li = document.createElement('li'); li.className = `page-item ${recipeCurrentPage === totalPages ? 'disabled' : ''}`; li.innerHTML = `<a class="page-link" href="#" data-page="${recipeCurrentPage + 1}">Next</a>`; paginationContainer.appendChild(li); }
            
            // --- HELPER FUNCTIONS ---
            function updateActionButtonsState_Recipes() {
                const selectedCount = recipeComponentRoot.querySelectorAll('#recipeListContainer .recipe-item-checkbox:checked').length;
                const deleteBtnDesktop = document.getElementById('recipeDeleteSelectedBtnDesktop');
                const deleteBtnMobile = document.getElementById('recipeDeleteSelectedBtnMobile');

                if (deleteBtnDesktop) {
                    deleteBtnDesktop.style.display = selectedCount > 0 ? 'inline-flex' : 'none';
                }
                if (deleteBtnMobile) {
                    deleteBtnMobile.style.display = selectedCount > 0 ? 'block' : 'none';
                }
            }

            function getSymbolHtml_Recipes(symbolType) { if (!symbolType) return ''; const lowerSymbol = symbolType.toLowerCase(); let symbolClass = ''; if (lowerSymbol === 'veg') { symbolClass = 'fssai-veg'; } else if (lowerSymbol === 'nonveg') { symbolClass = 'fssai-nonveg'; } else { return symbolType; } return `<div class="type-container"><span class="fssai-symbol ${symbolClass}" title="${symbolType}"></span><span class="type-text">${symbolType}</span></div>`; }
            
            function getSymbolHtmlForPrint_Recipes(symbolType) {
                if (!symbolType) return '';
                const lowerSymbol = symbolType.toLowerCase();
                let svg = '';
                if (lowerSymbol === 'veg') {
                    svg = `
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;">
                            <rect x="0.5" y="0.5" width="15" height="15" fill="none" stroke="#128236" stroke-width="1"/>
                            <circle cx="8" cy="8" r="4" fill="#128236"/>
                        </svg>`;
                } else if (lowerSymbol === 'nonveg') {
                    svg = `
                        <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;">
                            <rect x="0.5" y="0.5" width="15" height="15" fill="none" stroke="#A5432D" stroke-width="1"/>
                            <polygon points="8,3 3,13 13,13" fill="#A5432D"/>
                        </svg>`;
                } else {
                    return symbolType;
                }
                return `<div class="type-container" style="display: flex; align-items: center; justify-content: center;">${svg}</div>`;
            }

            function updateAllVisiblePortionDisplays() {
                const rows = recipeTableBody.querySelectorAll('tr');
                rows.forEach(row => {
                    const basePortion = parseFloat(row.dataset.basePortionGrams) || 100;
                    const newTargetGrams = recipeGlobalPortionDisplayMode === 'per_100g' ? 100 : basePortion;
                    const newLabel = recipeGlobalPortionDisplayMode === 'per_100g' ? `100g` : `1 Portion (${basePortion}g)`;
                    updateNutritionData_Recipes(row, newTargetGrams, newLabel);
                });
            }
            
            // Updated function for mobile nutrient cards
            function updateNutritionData_Recipes(row, targetGrams, newLabel, updateLabel = true) {
                const baseGrams = parseFloat(row.dataset.basePortionGrams);
                if (!baseGrams || isNaN(baseGrams) || baseGrams === 0) return;
                const ratio = targetGrams / baseGrams;
                
                const nutrientMap = {
                    energy: { icon: 'bi-fire', unit: 'KCAL', digits: 0, color: '#dc3545' },
                    protein: { icon: 'bi-gem', unit: 'G', digits: 1, color: '#0d6efd' },
                    carb: { icon: 'bi-graph-up', unit: 'G', digits: 1, color: '#ffc107' },
                    fat: { icon: 'bi-droplet-fill', unit: 'G', digits: 1, color: '#6c757d' }
                };

                for (const nutrient in nutrientMap) {
                    const config = nutrientMap[nutrient];
                    const baseValue = parseFloat(row.dataset[`base${nutrient.charAt(0).toUpperCase() + nutrient.slice(1)}`]);
                    const cell = row.querySelector(`[data-nutrient="${nutrient}"]`);
                    if (cell) {
                        const value = isNaN(baseValue) ? 0 : baseValue;
                        const finalValue = (value * ratio).toFixed(config.digits);

                        // This part is for the desktop view (hidden on mobile)
                        cell.textContent = finalValue;

                        // This part generates the new attractive mobile card
                        cell.innerHTML = `
                            <div class="nutrient-display">
                                <i class="bi ${config.icon} nutrient-icon" style="color: ${config.color};"></i>
                                <div class="nutrient-text">
                                    <span class="nutrient-value">${finalValue}<small>${config.unit}</small></span>
                                    <span class="nutrient-label">${nutrient}</span>
                                </div>
                            </div>
                        `;
                    }
                }

                if (updateLabel && newLabel) {
                    const toggleButton = row.querySelector('.portion-dropdown .dropdown-toggle');
                    if (toggleButton) toggleButton.textContent = newLabel;
                }
            }
            function getActionButtonsHtml_Recipes(item) { if (item.isActive) { return `<div class="d-flex flex-wrap"><button class="btn btn-sm btn-outline-secondary action-btn" data-action="Edit" data-id="${item.id}" title="Edit"><i class="bi bi-pencil"></i></button><button class="btn btn-sm btn-outline-info action-btn" data-action="Duplicate" data-id="${item.id}" title="Duplicate"><i class="bi bi-files"></i></button><button class="btn btn-sm btn-outline-success action-btn" data-action="Download" data-id="${item.id}" title="Download Row"><i class="bi bi-download"></i></button><button class="btn btn-sm btn-warning action-btn" data-action="Deactivate" data-id="${item.id}" title="Deactivate"><i class="bi bi-power"></i></button><button class="btn btn-sm btn-outline-danger action-btn" data-action="Delete" data-id="${item.id}" title="Delete"><i class="bi bi-trash"></i></button></div>`; } else { return `<div class="d-flex"><button class="btn btn-sm btn-success action-btn" data-action="Activate" data-id="${item.id}" title="Activate"><i class="bi bi-power"></i> Activate</button></div>`; } }
            function formatTimestamp_Recipes(dateInput) { if (!dateInput) return 'N/A'; const d = new Date(dateInput); if (isNaN(d.getTime())) return ''; const year = d.getFullYear(); const month = String(d.getMonth() + 1).padStart(2, '0'); const day = String(d.getDate()).padStart(2, '0'); return `${day}-${month}-${year}`; }
            function initializePortionDropdownHtml_Recipes(baseGrams) { let buttonText = recipeGlobalPortionDisplayMode === 'per_100g' ? '100g' : `1 Portion (${baseGrams}g)`; return `<div class="dropdown portion-dropdown"><button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">${buttonText}</button><ul class="dropdown-menu"><li><a class="dropdown-item portion-option" href="#" data-type="portion">1 Portion (${baseGrams}g)</a></li><li><a class="dropdown-item portion-option" href="#" data-type="100g">100g</a></li><li><a class="dropdown-item portion-option" href="#" data-type="custom">Customized...</a></li></ul></div>`; }
            
            function downloadCSV_Recipes(data, filename = 'recipes.csv') {
                if (data.length === 0) { alert("No data to download."); return; }
                const headers = ['No.', 'Date', 'Unit Details', 'Name', 'Type', 'Reference', 'Allergen', 'Portion (g)', 'Energy (kcal)', 'Protein (g)', 'Carb (g)', 'Fat (g)'];
                const csvRows = [headers.join(',')];
                
                data.forEach((row, index) => {
                    let { portion, energy, protein, carb, fat } = row;
                    
                    if (recipeGlobalPortionDisplayMode === 'per_100g' && row.portion > 0) {
                        const ratio = 100 / row.portion;
                        energy = (row.energy * ratio).toFixed(2);
                        protein = (row.protein * ratio).toFixed(2);
                        carb = (row.carb * ratio).toFixed(2);
                        fat = (row.fat * ratio).toFixed(2);
                        portion = 100;
                    }

                    const unitDetails = `Corporate: ${row.corporateName || 'N/A'}; Regional: ${row.regionalName || 'N/A'}; Unit: ${row.unitName || 'N/A'}`;

                    const values = [
                        index + 1,
                        formatTimestamp_Recipes(row.isActive ? row.createdOn : row.deactivatedOn),
                        `"${unitDetails}"`,
                        `"${row.name || ''}"`,
                        row.symbol || '',
                        `"${row.refrence || ''}"`,
                        `"${row.allergen || ''}"`,
                        portion || 0,
                        energy || 0,
                        protein || 0,
                        carb || 0,
                        fat || 0
                    ];
                    csvRows.push(values.join(','));
                });

                const csvString = csvRows.join('\r\n');
                const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement("a");
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            function getUniqueColumnValues_recipes(key) {
                const values = new Set();
                tableData_RecipeList.forEach(item => {
                    let itemValue = item[key] || '';
                    if (['refrence', 'allergen'].includes(key)) {
                        const parts = itemValue.split(',').map(v => v.trim()).filter(Boolean);
                        if (parts.length > 0) {
                            parts.forEach(p => values.add(p));
                        } else {
                            if (key === 'allergen') values.add('None');
                        }
                    } else {
                        if (itemValue) values.add(itemValue);
                    }
                });
                return Array.from(values).sort();
            }

            function getUnitHierarchy(data) {
                const hierarchy = {};
                data.forEach(item => {
                    if (!hierarchy[item.corporateName]) {
                        hierarchy[item.corporateName] = {};
                    }
                    if (!hierarchy[item.corporateName][item.regionalName]) {
                        hierarchy[item.corporateName][item.regionalName] = [];
                    }
                    if (!hierarchy[item.corporateName][item.regionalName].includes(item.unitName)) {
                        hierarchy[item.corporateName][item.regionalName].push(item.unitName);
                    }
                });
                return hierarchy;
            }

            function renderActiveFilterTags_recipes() {
                const container = document.getElementById('activeFilters_recipes');
                if(!container) return;
                container.innerHTML = '';
                const filters = recipeActiveColumnFilters;
                let hasFilters = false;

                if (recipeGlobalPortionDisplayMode === 'per_100g') {
                    container.innerHTML += `<div class="filter-tag"><span class="tag-label">Display:</span> Per 100g <button class="tag-close-btn" data-filter-key="portion_display">×</button></div>`;
                    hasFilters = true;
                }
                
                if (filters.type && filters.type.value) {
                    container.innerHTML += `<div class="filter-tag"><span class="tag-label">Type:</span> ${filters.type.value} <button class="tag-close-btn" data-filter-key="type">×</button></div>`;
                    hasFilters = true;
                }

                Object.keys(filters).forEach(key => {
                    if (key === 'type') return; 
                    const filter = filters[key];
                    if (!filter || Object.keys(filter).length === 0) return;

                    let tagHtml = '';
                    switch (key) {
                        case 'unit':
                            if (filter.corporate || filter.regional || filter.unit) {
                                const path = [filter.corporate, filter.regional, filter.unit].filter(Boolean).join(' > ');
                                tagHtml = `<div class="filter-tag"><span class="tag-label">Unit:</span> ${path} <button class="tag-close-btn" data-filter-key="${key}">×</button></div>`;
                            }
                            break;
                        case 'dateRange':
                             if (filter.from || filter.to) {
                                const from = filter.from ? formatTimestamp_Recipes(filter.from) : '...';
                                const to = filter.to ? formatTimestamp_Recipes(filter.to) : '...';
                                tagHtml = `<div class="filter-tag"><span class="tag-label">Date:</span> ${from} to ${to} <button class="tag-close-btn" data-filter-key="${key}">×</button></div>`;
                            }
                            break;
                        case 'kcalRange':
                            if (filter.min !== null || filter.max !== null) {
                                const min = filter.min ?? '...';
                                const max = filter.max ?? '...';
                                tagHtml = `<div class="filter-tag"><span class="tag-label">Kcal/100g:</span> ${min} to ${max} <button class="tag-close-btn" data-filter-key="${key}">×</button></div>`;
                            }
                            break;
                        case 'references':
                        case 'allergens':
                            if (filter.values && filter.values.length > 0) {
                                const keyLabel = key.charAt(0).toUpperCase() + key.slice(1, -1);
                                tagHtml = `<div class="filter-tag"><span class="tag-label">${keyLabel}:</span> ${filter.values.join(', ')} <button class="tag-close-btn" data-filter-key="${key}">×</button></div>`;
                            }
                            break;
                    }
                    if (tagHtml) {
                        hasFilters = true;
                        container.innerHTML += tagHtml;
                    }
                });

                if (hasFilters) {
                    container.innerHTML += `<button class="clear-all-filters-btn" id="clearAllTagsBtn_recipes">Clear All</button>`;
                }
            }
            
            // --- ADVANCED FILTER MODAL INITIALIZATION ---
            function setupAdvancedFilters() {
                unitHierarchy = getUnitHierarchy(tableData_RecipeList);
                
                const modalBody = $('#recipeFilterModal .modal-body');
                const select2Options = (placeholder) => ({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#recipeFilterModal'), // Attach to modal itself
                    placeholder: placeholder,
                    width: '100%'
                });
                
                const $corpSelect = modalBody.find('#modalCorporateName');
                const $regionSelect = modalBody.find('#modalRegionalName');
                const $unitSelect = modalBody.find('#modalUnitName');
                
                $corpSelect.select2(select2Options('Select Corporate...'));
                $regionSelect.select2(select2Options('Select Regional...'));
                $unitSelect.select2(select2Options('Select Unit...'));
                
                const refSelect = modalBody.find('#modalReference');
                refSelect.select2({...select2Options('Select references...'), closeOnSelect: false });

                const allergenSelect = modalBody.find('#modalAllergen');
                allergenSelect.select2({...select2Options('Select allergens...'), closeOnSelect: false });

                $corpSelect.on('change', function() {
                    const selectedCorp = $(this).val();
                    $regionSelect.html('<option value="">All Regionals</option>').prop('disabled', !selectedCorp);
                    $unitSelect.html('<option value="">All Units</option>').prop('disabled', true);
                    if (selectedCorp && unitHierarchy[selectedCorp]) {
                        Object.keys(unitHierarchy[selectedCorp]).sort().forEach(region => {
                            $regionSelect.append(new Option(region, region));
                        });
                    }
                    $regionSelect.trigger('change');
                });

                $regionSelect.on('change', function() {
                    const selectedCorp = $corpSelect.val();
                    const selectedRegion = $(this).val();
                    $unitSelect.html('<option value="">All Units</option>').prop('disabled', !selectedRegion);
                    if (selectedCorp && selectedRegion && unitHierarchy[selectedCorp][selectedRegion]) {
                        unitHierarchy[selectedCorp][selectedRegion].sort().forEach(unit => {
                            $unitSelect.append(new Option(unit, unit));
                        });
                    }
                });

                filterModalEl.addEventListener('show.bs.modal', function () {
                    if (recipeGlobalPortionDisplayMode === 'per_100g') {
                        modalBody.find('#modal-display-100g').prop('checked', true);
                    } else {
                        modalBody.find('#modal-display-actual').prop('checked', true);
                    }
                    const currentType = recipeActiveColumnFilters.type ? recipeActiveColumnFilters.type.value : 'All';
                    modalBody.find(`input[name="modalTypeFilter"][value="${currentType}"]`).prop('checked', true);
                    $corpSelect.html('<option value="">All Corporates</option>');
                    Object.keys(unitHierarchy).sort().forEach(corp => $corpSelect.append(new Option(corp, corp)));
                    const currentUnitFilter = recipeActiveColumnFilters.unit || {};
                    $corpSelect.val(currentUnitFilter.corporate).trigger('change');
                    $regionSelect.val(currentUnitFilter.regional).trigger('change');
                    $unitSelect.val(currentUnitFilter.unit).trigger('change');
                    const currentDateFilter = recipeActiveColumnFilters.dateRange || {};
                    modalBody.find('#modalDateFrom').val(currentDateFilter.from || '');
                    modalBody.find('#modalDateTo').val(currentDateFilter.to || '');
                    const currentKcalFilter = recipeActiveColumnFilters.kcalRange || {};
                    modalBody.find('#modalMinKcal').val(currentKcalFilter.min || '');
                    modalBody.find('#modalMaxKcal').val(currentKcalFilter.max || '');
                    const currentRefFilter = recipeActiveColumnFilters.references || {};
                    const uniqueRefs = getUniqueColumnValues_recipes('refrence');
                    refSelect.html('');
                    uniqueRefs.forEach(r => refSelect.append(new Option(r, r)));
                    refSelect.val(currentRefFilter.values || []).trigger('change');
                    const currentAllergenFilter = recipeActiveColumnFilters.allergens || {};
                    const uniqueAllergens = getUniqueColumnValues_recipes('allergen');
                    allergenSelect.html('');
                    uniqueAllergens.forEach(a => allergenSelect.append(new Option(a, a)));
                    allergenSelect.val(currentAllergenFilter.values || []).trigger('change');
                });

                $('#modalApplyFiltersBtn').on('click', function() {
                    recipeGlobalPortionDisplayMode = modalBody.find('input[name="modalPortionDisplay"]:checked').val() || 'actual_portion';
                    const typeFilterValue = modalBody.find('input[name="modalTypeFilter"]:checked').val();
                    if (typeFilterValue && typeFilterValue !== 'All') {
                        recipeActiveColumnFilters.type = { value: typeFilterValue };
                    } else {
                        delete recipeActiveColumnFilters.type;
                    }
                    recipeActiveColumnFilters.unit = { corporate: modalBody.find('#modalCorporateName').val(), regional: modalBody.find('#modalRegionalName').val(), unit: modalBody.find('#modalUnitName').val() };
                    recipeActiveColumnFilters.dateRange = { from: modalBody.find('#modalDateFrom').val() || null, to: modalBody.find('#modalDateTo').val() || null };
                    recipeActiveColumnFilters.kcalRange = { min: parseFloat(modalBody.find('#modalMinKcal').val()) || null, max: parseFloat(modalBody.find('#modalMaxKcal').val()) || null };
                    recipeActiveColumnFilters.references = { values: modalBody.find('#modalReference').val() };
                    recipeActiveColumnFilters.allergens = { values: modalBody.find('#modalAllergen').val() };
                    applyFiltersAndRender_Recipes();
                    updateAllVisiblePortionDisplays();
                });

                $('#modalClearFiltersBtn').on('click', function() {
                    modalBody.find('form')[0].reset();
                    modalBody.find('#modal-display-actual').prop('checked', true);
                    modalBody.find('#modal-type-all').prop('checked', true);
                    modalBody.find('select').val(null).trigger('change');
                });
            }

            // --- EVENT LISTENERS ---
            const createRecipeHandler = () => {
                showRecipeMakerView();
                resetRecipeMakerForm();
            };
            if(createRecipeBtn) createRecipeBtn.addEventListener('click', createRecipeHandler);
            if(mobileCreateRecipeBtn) mobileCreateRecipeBtn.addEventListener('click', createRecipeHandler);

            const recipeGlobalSearchInput = recipeComponentRoot.querySelector('#recipeGlobalSearchInput');
            if(recipeGlobalSearchInput) recipeGlobalSearchInput.addEventListener('input', applyFiltersAndRender_Recipes);
            
            const recipeGlobalClearBtn = recipeComponentRoot.querySelector('#recipeGlobalClearBtn');
            if (recipeGlobalClearBtn) recipeGlobalClearBtn.addEventListener('click', () => { 
                if (recipeGlobalSearchInput) recipeGlobalSearchInput.value = ''; 
                recipeActiveColumnFilters = {};
                recipeGlobalPortionDisplayMode = 'actual_portion';
                 if (filterModalEl) {
                    $('#modalClearFiltersBtn').click();
                }
                applyFiltersAndRender_Recipes(); 
                updateAllVisiblePortionDisplays();
            });

            const recipeShowEntriesSelect = recipeComponentRoot.querySelector('#recipeShowEntriesSelect');
            if(recipeShowEntriesSelect) recipeShowEntriesSelect.addEventListener('change', (e) => { recipeEntriesPerPage = parseInt(e.target.value, 10); recipeCurrentPage = 1; renderPaginatedView_Recipes(); });
            
            const deleteRecipeHandler = () => {
                const checkedIds = Array.from(recipeComponentRoot.querySelectorAll('#recipeListContainer .recipe-item-checkbox:checked')).map(cb => parseFloat(cb.closest('tr').dataset.id));
                if (checkedIds.length === 0 || !confirm(`Are you sure you want to delete ${checkedIds.length} selected recipe(s)?`)) return;
                tableData_RecipeList = tableData_RecipeList.filter(item => !checkedIds.includes(item.id));
                applyFiltersAndRender_Recipes();
            };
            $('#recipeDeleteSelectedBtnDesktop').on('click', deleteRecipeHandler);
            $('#recipeDeleteSelectedBtnMobile').on('click', deleteRecipeHandler);

            // Corrected, more robust event listener for portion changes
            document.addEventListener('click', function(e) {
                const portionOption = e.target.closest('#recipeTableBody .portion-option');
                if (!portionOption) return;

                e.preventDefault();
                const row = portionOption.closest('tr');
                if (!row) return;

                const type = portionOption.dataset.type;
                const baseGrams = parseFloat(row.dataset.basePortionGrams);

                if (type === 'portion') {
                    updateNutritionData_Recipes(row, baseGrams, `1 Portion (${baseGrams}g)`);
                } else if (type === '100g') {
                    updateNutritionData_Recipes(row, 100, '100g');
                } else if (type === 'custom') {
                    const customGramsStr = prompt("Enter custom portion size in grams:", "150");
                    if (customGramsStr) {
                        const customGramsNum = parseFloat(customGramsStr);
                        if (!isNaN(customGramsNum) && customGramsNum > 0) {
                            updateNutritionData_Recipes(row, customGramsNum, `Custom (${customGramsNum}g)`);
                        } else {
                            alert("Please enter a valid positive number for grams.");
                        }
                    }
                }
            });

            if(recipeTableBody) {
                recipeTableBody.addEventListener('change', (e) => {
                    if (e.target.classList.contains('recipe-item-checkbox')) {
                        updateActionButtonsState_Recipes();
                    }
                });
                recipeTableBody.addEventListener('click', (e) => { 
                    const actionButton = e.target.closest('.action-btn'); 
                    if (actionButton) {
                        e.preventDefault();
                        const action = actionButton.dataset.action; 
                        const id = parseFloat(actionButton.closest('tr').dataset.id); 
                        const item = tableData_RecipeList.find(i => i.id === id); 
                        if (!item) return; 
                        switch (action) { 
                            case 'Deactivate': if (confirm(`Are you sure you want to deactivate "${item.name}"?`)) { item.isActive = false; item.deactivatedOn = new Date().toISOString(); applyFiltersAndRender_Recipes(); } break; 
                            case 'Activate': item.isActive = true; item.deactivatedOn = null; applyFiltersAndRender_Recipes(); break; 
                            case 'Edit': populateRecipeMakerForEdit(item.id); break; 
                            case 'Delete': if (confirm(`Are you sure you want to delete "${item.name}"?`)) { tableData_RecipeList = tableData_RecipeList.filter(i => i.id !== id); applyFiltersAndRender_Recipes(); } break; 
                            case 'Duplicate': const newItem = { ...item, id: Date.now() + Math.random(), name: `Copy of ${item.name}`, createdOn: new Date().toISOString(), isActive: true, deactivatedOn: null }; tableData_RecipeList.unshift(newItem); applyFiltersAndRender_Recipes(); break; 
                            case 'Download': generateRecipePdf(item.id); break; 
                        }
                    }
                });
            }
            
            const selectAllHeaderCheckbox = recipeComponentRoot.querySelector('#recipeSelectAllHeader');
            if (selectAllHeaderCheckbox) {
                selectAllHeaderCheckbox.addEventListener('change', (e) => {
                    const checkboxes = recipeComponentRoot.querySelectorAll('#recipeListContainer .recipe-item-checkbox');
                    checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
                    updateActionButtonsState_Recipes();
                });
            }
            
            const paginationContainer = recipeComponentRoot.querySelector('#recipePaginationContainer');
            if (paginationContainer) {
                paginationContainer.addEventListener('click', (e) => {
                    e.preventDefault();
                    const link = e.target.closest('a.page-link');
                    if (link && !link.parentElement.classList.contains('disabled')) {
                        recipeCurrentPage = parseInt(link.dataset.page, 10);
                        renderPaginatedView_Recipes();
                    }
                });
            }

            const activeFiltersContainer = recipeComponentRoot.querySelector('#activeFilters_recipes');
            if (activeFiltersContainer) {
                activeFiltersContainer.addEventListener('click', function(e) {
                    const button = e.target.closest('button');
                    if (!button) return;
                    if (button.id === 'clearAllTagsBtn_recipes') {
                        recipeGlobalClearBtn.click();
                        return;
                    }
                    const key = button.dataset.filterKey;
                    if (key === 'portion_display') {
                        recipeGlobalPortionDisplayMode = 'actual_portion';
                        updateAllVisiblePortionDisplays();
                    } else {
                        delete recipeActiveColumnFilters[key];
                    }
                    applyFiltersAndRender_Recipes();
                });
            }

            const downloadExcelHandler = (e) => { 
                e.preventDefault(); 
                const activeDataToDownload = recipeCurrentFilteredData.filter(item => item.isActive);
                downloadCSV_Recipes(activeDataToDownload, 'filtered_recipes.csv'); 
            };
            $('#recipeDownloadExcelOption').on('click', downloadExcelHandler);
            $('#mobileDownloadExcelOption').on('click', downloadExcelHandler);
            
            const downloadPdfHandler = (e) => { 
                e.preventDefault();
                const originalPage = recipeCurrentPage;
                renderPaginatedView_Recipes(true); 
                window.print();
                setTimeout(() => {
                    recipeCurrentPage = originalPage;
                    renderPaginatedView_Recipes(false);
                }, 500);
            };
            $('#recipeDownloadPdfOption').on('click', downloadPdfHandler);
            $('#mobileDownloadPdfOption').on('click', downloadPdfHandler);


            setupAdvancedFilters();
            applyFiltersAndRender_Recipes();
            
            // --- RECIPE MAKER SCRIPT ---
            let unifiedAddableItems = []; 

            function rebuildUnifiedSearchSource() {
                unifiedAddableItems = [
                    ...window.masterIngredientData.map(item => ({...item, type: 'ingredient'})),
                    ...tableData_RecipeList.filter(item => item.isActive).map(item => ({...item, type: 'recipe'}))
                ];
                window.unifiedAddableItems = unifiedAddableItems;
            }
            window.rebuildUnifiedSearchSource = rebuildUnifiedSearchSource;

            function resetRecipeMakerForm() {
                const maker = recipeMakerContainer;
                const form = maker.querySelector('#recipeForm');
                const ingredientsContainer = maker.querySelector('#ingredientsContainer');
                const saveBtn = maker.querySelector('#makerSaveRecipeDataBtn');
                const title = maker.querySelector('h1');

                form.reset();
                ingredientsContainer.innerHTML = '';
                delete form.dataset.editingId;

                title.textContent = 'Recipe Maker';
                saveBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align:-.125em; margin-right:5px;"><path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z"/></svg>Save Data`;

                window.addIngredientToMaker({ symbol: 'Veg' });
            }

            function populateRecipeMakerForEdit(recipeId) {
                const recipeToEdit = tableData_RecipeList.find(r => r.id === recipeId);
                if (!recipeToEdit) {
                    alert("Error: Recipe not found for editing.");
                    return;
                }

                showRecipeMakerView(); 

                const maker = recipeMakerContainer;
                const form = maker.querySelector('#recipeForm');
                const ingredientsContainer = maker.querySelector('#ingredientsContainer');

                form.reset();
                ingredientsContainer.innerHTML = ''; 
                form.dataset.editingId = recipeId;
                maker.querySelector('h1').textContent = 'Edit Recipe';
                maker.querySelector('#makerSaveRecipeDataBtn').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16" style="vertical-align:-.125em; margin-right:5px;"><path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l-3.146-3.147a.5.5 0 0 1-.708.708l-4 4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0L4 13.293V1.5a.5.5 0 0 1 .5-.5"/></svg>Update Data`;

                maker.querySelector('#recipeTitle').value = recipeToEdit.name || '';
                maker.querySelector('#servings').value = recipeToEdit.servings || 1;
                maker.querySelector('#finalWeightPerServing').value = recipeToEdit.portion || '';
                maker.querySelector('#recipeDescription').value = recipeToEdit.description || '';
                maker.querySelector('#recipeNotes').value = recipeToEdit.notes || '';

                rebuildUnifiedSearchSource(); 
                
                if (recipeToEdit.ingredients && recipeToEdit.ingredients.length > 0) {
                    recipeToEdit.ingredients.forEach(ing => {
                        const fullIngredientData = unifiedAddableItems.find(i => i.id === ing.ingredientId);
                        
                        if (fullIngredientData) {
                            window.addIngredientToMaker({ ...fullIngredientData, actualQty: ing.quantity, fromDB: true });
                        } else {
                            console.warn(`Ingredient/Recipe with ID ${ing.ingredientId} from recipe "${recipeToEdit.name}" was not found in the master list or recipe list.`);
                        }
                    });
                } else {
                    window.addIngredientToMaker({ symbol: 'Veg' }); 
                }
            }
            
            // --- PDF GENERATION FOR INDIVIDUAL RECIPE (IMPROVED) ---
            function generateRecipePdf(recipeId) {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                const recipe = tableData_RecipeList.find(r => r.id === recipeId);
                if (!recipe) {
                    alert("Recipe data not found!");
                    return;
                }
                
                rebuildUnifiedSearchSource();
                const detailedIngredients = recipe.ingredients.map(ing => {
                    const fullData = unifiedAddableItems.find(item => item.id === ing.ingredientId);
                    return { ...fullData, quantity: ing.quantity };
                }).filter(Boolean);

                const pageW = doc.internal.pageSize.getWidth();
                const margin = 14;
                const primaryColor = [0, 123, 255];
                const setFont = (style = 'normal') => doc.setFont('helvetica', style);

                setFont('bold');
                doc.setTextColor(0);
                doc.setFontSize(14);
                doc.text(recipe.unitName || 'Unit Name', margin, 22);

                const isVeg = recipe.symbol.toLowerCase() === 'veg';
                const fssaiColor = isVeg ? '#128236' : '#A5432D';
                const headerLogoSize = 8;
                const recipeNameY = 31; 
                const logoX = margin;
                const logoY = recipeNameY - (headerLogoSize / 2) - 1;

                doc.setDrawColor(fssaiColor);
                doc.setLineWidth(0.8);
                doc.rect(logoX, logoY, headerLogoSize, headerLogoSize, 'S');
                doc.setFillColor(fssaiColor);
                if (isVeg) {
                    doc.circle(logoX + headerLogoSize / 2, logoY + headerLogoSize / 2, headerLogoSize / 4, 'F');
                } else {
                    const triSize = headerLogoSize / 1.8;
                    const triX = logoX + headerLogoSize / 2;
                    const triY = logoY + (headerLogoSize - triSize) / 1.5;
                    doc.triangle(triX, triY, triX - triSize / 2, triY + triSize * 0.866, triX + triSize / 2, triY + triSize * 0.866, 'F');
                }

                setFont('normal');
                doc.setFontSize(22);
                doc.text(recipe.name, margin + headerLogoSize + 3, recipeNameY);

                doc.setTextColor(80);
                doc.setFontSize(9);
                doc.text('Reference to Protocol:', pageW - margin, 18, { align: 'right' });
                doc.text('FSSAI Guidance Notes on Menu Labeling', pageW - margin, 22, { align: 'right' });
                doc.text(`Data Reference: ${recipe.refrence}`, pageW - margin, 26, { align: 'right' });
                
                setFont('bold');
                doc.setFontSize(12);
                doc.text(`Portion: 01  |  Size: ${recipe.portion} g/ml`, pageW - margin, 34, { align: 'right' });
                
                doc.setDrawColor(220);
                doc.line(margin, 45, pageW - margin, 45);

                const allAllergens = new Set();
                detailedIngredients.forEach(ing => {
                    if (ing.allergen && ing.allergen.toLowerCase() !== 'none') {
                        ing.allergen.split(',').forEach(a => allAllergens.add(a.trim()));
                    }
                });
                const allergenList = Array.from(allAllergens);
                const allergenString = allergenList.length > 0 ? allergenList.join(', ') : 'None';

                doc.setFillColor(255, 240, 242); 
                doc.setDrawColor(220);
                doc.rect(margin, 52, pageW - (margin * 2), 12, 'FD');
                
                setFont('bold');
                doc.setTextColor(200, 35, 51);
                doc.setFontSize(11);
                const allergenLabel = 'Allergen Ingredients: ';
                doc.text(allergenLabel, margin + 5, 59.5);
                
                setFont('normal');
                doc.setTextColor(80);
                doc.setFontSize(10);
                const allergenLabelWidth = doc.getTextWidth(allergenLabel);
                const availableWidthFor_Allergens = pageW - (margin * 2) - 10 - allergenLabelWidth;
                const allergenTextLines = doc.splitTextToSize(allergenString, availableWidthFor_Allergens);
                doc.text(allergenTextLines, margin + 5 + allergenLabelWidth, 59.5);
                
                let currentY = 72;

                let totalEnergy = 0, totalProtein = 0, totalCarb = 0, totalFat = 0, totalWeight = 0;
                detailedIngredients.forEach(ing => {
                    const factor = ing.quantity / (ing.portion || 100);
                    totalEnergy += (ing.energy || 0) * factor;
                    totalProtein += (ing.protein || 0) * factor;
                    totalCarb += (ing.carb || 0) * factor;
                    totalFat += (ing.fat || 0) * factor;
                    totalWeight += ing.quantity;
                });
                
                const concentrationFactor = totalWeight > 0 ? recipe.portion / totalWeight : 0;
                const perPortionEnergy = totalEnergy * concentrationFactor;
                const perPortionProtein = totalProtein * concentrationFactor;
                const perPortionCarb = totalCarb * concentrationFactor;
                const perPortionFat = totalFat * concentrationFactor;
                const per100gEnergy = recipe.portion > 0 ? (perPortionEnergy / recipe.portion) * 100 : 0;
                const per100gProtein = recipe.portion > 0 ? (perPortionProtein / recipe.portion) * 100 : 0;
                const per100gCarb = recipe.portion > 0 ? (perPortionCarb / recipe.portion) * 100 : 0;
                const per100gFat = recipe.portion > 0 ? (perPortionFat / recipe.portion) * 100 : 0;

                doc.setFillColor(232, 245, 253);
                doc.setDrawColor(200);
                const boxWidth = (pageW - (margin * 2) - 5) / 2;
                doc.rect(margin, currentY, boxWidth, 40, 'FD');
                doc.rect(margin + boxWidth + 5, currentY, boxWidth, 40, 'FD');

                setFont('bold');
                doc.setTextColor(0);
                doc.setFontSize(12);
                doc.text('Nutritional Information (per 100g)', margin + boxWidth / 2, currentY + 7, { align: 'center' });
                doc.text('Nutritional Information (per portion)', margin + boxWidth + 5 + boxWidth / 2, currentY + 7, { align: 'center' });
                
                setFont();
                doc.setFontSize(10);
                const drawNutrientRow = (label, y, per100, perPortion, unit) => {
                    doc.text(label, margin + 5, y);
                    doc.text(`${per100.toFixed(2)} ${unit}`, margin + boxWidth - 5, y, { align: 'right' });
                    doc.text(label, margin + boxWidth + 10, y);
                    doc.text(`${perPortion.toFixed(2)} ${unit}`, pageW - margin - 5, y, { align: 'right' });
                };
                drawNutrientRow('Energy:', currentY + 17, per100gEnergy, perPortionEnergy, 'KCal');
                drawNutrientRow('Protein:', currentY + 23, per100gProtein, perPortionProtein, 'g');
                drawNutrientRow('Carbohydrates:', currentY + 29, per100gCarb, perPortionCarb, 'g');
                drawNutrientRow('Fat:', currentY + 35, per100gFat, perPortionFat, 'g');

                currentY += 40 + 10;

                setFont('bold');
                doc.setFontSize(14);
                doc.text('Ingredients Summary (per Serving)', margin, currentY);
                currentY += 4;
                
                const servings = recipe.servings || 1;
                const tableBody = detailedIngredients.map((ing, index) => [
                    index + 1, ing.symbol || '', (ing.quantity / servings).toFixed(2), ing.name, ing.refrence, ing.allergen,
                    ((ing.energy || 0) * (ing.quantity / (ing.portion || 100)) / servings).toFixed(2),
                    ((ing.protein || 0) * (ing.quantity / (ing.portion || 100)) / servings).toFixed(2),
                    ((ing.carb || 0) * (ing.quantity / (ing.portion || 100)) / servings).toFixed(2),
                    ((ing.fat || 0) * (ing.quantity / (ing.portion || 100)) / servings).toFixed(2),
                ]);

                doc.autoTable({
                    startY: currentY, margin: { left: margin, right: margin },
                    head: [['SI', 'Symbol', 'Qty/Portion (g)', 'Ingredients Name', 'Reference', 'Allergen', 'Energy', 'Protein', 'Carb', 'Fat']],
                    body: tableBody, theme: 'grid',
                    headStyles: { fillColor: primaryColor, textColor: 255, fontStyle: 'bold', halign: 'center', fontSize: 8 },
                    alternateRowStyles: { fillColor: [245, 245, 245] },
                    columnStyles: { 0: { halign: 'center', cellWidth: 8, fontSize: 8 }, 1: { halign: 'center', cellWidth: 12 }, 2: { halign: 'right', cellWidth: 20, fontSize: 8 }, 3: { cellWidth: 35, fontSize: 8 }, 4: { cellWidth: 20, fontSize: 8 }, 5: { cellWidth: 18, fontSize: 8 }, 6: { halign: 'right', fontSize: 8 }, 7: { halign: 'right', fontSize: 8 }, 8: { halign: 'right', fontSize: 8 }, 9: { halign: 'right', fontSize: 8 } },
                    didDrawCell: (data) => {
                        if (data.column.index === 1 && data.cell.section === 'body') {
                            const symbol = data.cell.raw;
                            data.cell.text = '';
                            if(symbol) {
                                const isVeg = symbol.toLowerCase() === 'veg';
                                const color = isVeg ? '#128236' : '#A5432D';
                                const { x, y, width, height } = data.cell;
                                const logoSize = 5, logoX = x + (width - logoSize) / 2, logoY = y + (height - logoSize) / 2;
                                doc.setDrawColor(color);
                                doc.setLineWidth(0.5);
                                doc.rect(logoX, logoY, logoSize, logoSize, 'S');
                                doc.setFillColor(color);
                                if (isVeg) { doc.circle(logoX + logoSize / 2, logoY + logoSize / 2, logoSize / 4, 'F'); } 
                                else { const ts=logoSize/1.5,tx=logoX+logoSize/2,ty=logoY+(logoSize-ts)/1.5; doc.triangle(tx, ty, tx-ts/2, ty+ts*0.866, tx+ts/2, ty+ts*0.866, 'F');}
                            }
                        }
                    }
                });
                currentY = doc.autoTable.previous.finalY;

                currentY += 15;
                setFont('bold'); doc.setFontSize(12);
                doc.text('Additional Description / Notes:', margin, currentY);
                currentY += 3;
                
                setFont(); doc.setFontSize(10); doc.setTextColor(80);
                const notesText = doc.splitTextToSize(recipe.notes || "No additional notes provided.", pageW - (margin * 2) - 6);
                const notesBoxHeight = (notesText.length * doc.getLineHeight() * 0.5) + 6;
                doc.setDrawColor(200);
                doc.roundedRect(margin, currentY, pageW - (margin*2), notesBoxHeight, 3, 3, 'S');
                doc.text(notesText, margin + 3, currentY + 5);
                currentY += notesBoxHeight;

                doc.setFontSize(8); doc.setTextColor(150);
                const footerText = 'Note: The results are calculated using recipe submitted by client using the software. This document is generated automatically and should be used for reference purposes only.';
                doc.text(footerText, margin, doc.internal.pageSize.getHeight() - 15, { maxWidth: pageW - (margin * 2) });

                doc.save(`${recipe.name.replace(/\s+/g, '_')}.pdf`);
            }
            
            function setupRecipeMaker() {
                const maker = recipeComponentRoot.querySelector('#recipeMakerContainer');
                if (!maker) return;
                
                rebuildUnifiedSearchSource();

                window.addIngredientToMaker = (data = {}) => { 
                    const ingredientsContainer = maker.querySelector('#ingredientsContainer');
                    const newIngredient = document.createElement('div'); 
                    newIngredient.classList.add('ingredient-item'); 
                    const { id = null, name = '', userName = '', dbName = '', keyword = '', refrence = '', allergen = '', symbol = 'Veg', actualQty = '', fromDB = false, type = 'ingredient' } = data; 
                    
                    if(id) newIngredient.dataset.ingredientId = id;

                    const initialUserName = userName || name; 
                    const initialDbName = fromDB ? (dbName || name) : ''; 
                    const logoHtml = getFssaiLogoHtml(symbol); 
                    let finalReference = fromDB ? refrence : (data.refrence || ''); 
                    if (fromDB && type === 'recipe') { finalReference = 'Recipe'; } 
                    newIngredient.innerHTML = `<input type="checkbox" name="ingredientSelect[]" class="ingredient-select-checkbox" title="Select this ingredient"><input type="text" name="ingredientSlNo[]" value="" readonly style="background-color:#f0f0f0;"><div class="ingredient-logo-display">${logoHtml}</div><input type="number" step="any" name="ingredientActualQty[]" placeholder="Qty (g)" value="${actualQty}" required><input type="text" name="ingredientUserName[]" value="${initialUserName}" ${fromDB ? 'readonly style="background-color:#f0f0f0;"' : 'placeholder="Type name & Tab"'}><input type="text" name="ingredientDbName[]" value="${initialDbName}" readonly style="background-color:#f0f0f0;"><input type="text" name="ingredientKeyword[]" value="${fromDB ? keyword : (data.keyword || '')}" readonly style="background-color:#f0f0f0;"><input type="text" name="ingredientReference[]" value="${finalReference}" readonly style="background-color:#f0f0f0;"><input type="text" name="ingredientAllergen[]" value="${fromDB ? allergen : (data.allergen || '')}" readonly style="background-color:#f0f0f0;"><input type="number" step="any" name="ingredientEnergy[]" value="" readonly style="background-color:#f0f0f0;"><input type="number" step="any" name="ingredientProtein[]" value="" readonly style="background-color:#f0f0f0;"><input type="number" step="any" name="ingredientCarb[]" value="" readonly style="background-color:#f0f0f0;"><input type="number" step="any" name="ingredientFat[]" value="" readonly style="background-color:#f0f0f0;"><button type="button" class="remove-btn">Remove</button>`; 
                    ingredientsContainer.prepend(newIngredient); 
                    updateSerialNumbers(); 
                    if (actualQty) { 
                        calculateAndUpdateNutrition(newIngredient, data); 
                    } else { 
                        updateTotalsRow(); 
                    } 
                    if (!fromDB && !actualQty) newIngredient.querySelector('input[name="ingredientActualQty[]"]').focus(); 
                };

                const form = maker.querySelector('#recipeForm');
                const CSV_REVIEW_JW_MATCH_THRESHOLD = 0.85;
                let currentlyCheckedInSearch = {};
                let pendingReviewCSVIngredients = [];
                let unmatchedCSVIngredients = [];
                const ingredientsContainer = maker.querySelector('#ingredientsContainer');
                const processIngredientFileBtn = maker.querySelector('#processIngredientFileBtn');
                const downloadSampleCsvBtnNew = maker.querySelector('#downloadSampleCsvBtnNew');
                const ingredientSearchInput = maker.querySelector('#ingredientSearch');
                const searchResultsContainerDiv = maker.querySelector('#ingredientSearchResultsContainer');
                const resultsListInnerDiv = searchResultsContainerDiv.querySelector('.search-result-list-inner');
                const selectedIngredientsReviewDiv = maker.querySelector('#selectedIngredientsReview');
                const selectedIngredientsReviewContent = selectedIngredientsReviewDiv.querySelector('.selected-items-container');
                const addSelectedIngredientsBtn = maker.querySelector('#addSelectedIngredientsBtn');
                const servingsInput = maker.querySelector('#servings');
                const servingSizeNoticeStep2Span = maker.querySelector('#servingSizeNoticeStep2');
                const deleteSelectedIngredientsBtn = maker.querySelector('#deleteSelectedIngredientsBtn');
                const reviewMatchedSection = maker.querySelector('#reviewMatchedIngredientsSection');
                const reviewMatchedTableBody = maker.querySelector('#reviewMatchedIngredientsTable').querySelector('tbody');
                const reviewMatchedGlobalActions = maker.querySelector('#reviewMatchedActionsGlobal');
                const acceptAllMatchedBtn = maker.querySelector('#acceptAllMatchedBtn');
                const rejectAllMatchedBtn = maker.querySelector('#rejectAllMatchedBtn');
                const ignoreAllMatchedBtn = maker.querySelector('#ignoreAllMatchedBtn');
                const unmatchedSection = maker.querySelector('#unmatchedIngredientsSection');
                const unmatchedTableBody = maker.querySelector('#unmatchedIngredientsTable').querySelector('tbody');
                const unmatchedGlobalActions = maker.querySelector('#unmatchedActionsGlobal');
                const ignoreAllUnmatchedBtn = maker.querySelector('#ignoreAllUnmatchedBtn');
                const mapIngredientModal = maker.querySelector('#mapIngredientModal');
                const mapModalCloseBtns = mapIngredientModal.querySelectorAll('[data-dismiss-modal-custom]');
                const csvIngredientToMapNameEl = maker.querySelector('#csvIngredientToMapName');
                const csvIngredientToMapQuantityEl = maker.querySelector('#csvIngredientToMapQuantity');
                const selectDbIngredientForMapEl = maker.querySelector('#selectDbIngredientForMap');
                const unmatchedCsvItemIndexInput = maker.querySelector('#unmatchedCsvItemIndex');
                const confirmMapIngredientBtn = maker.querySelector('#confirmMapIngredientBtn');
                const makerSaveBtn = maker.querySelector('#makerSaveRecipeDataBtn');
                const makerBackBtn = maker.querySelector('#backToListBtn');
                const makerAddManualBtn = maker.querySelector('#makerAddManualBtn');
                const totalRowDisplayDiv = maker.querySelector('#ingredientTotalRowDisplay');
                const totalSlNoDiv = maker.querySelector('#totalSlNo');
                const totalLogoDiv = maker.querySelector('#totalLogo');
                const totalQtyDiv = maker.querySelector('#totalQty');
                const totalIngredientNamesDiv = maker.querySelector('#totalIngredientNames');
                const totalReferenceDiv = maker.querySelector('#totalReference');
                const totalAllergenDiv = maker.querySelector('#totalAllergen');
                const totalEnergyDiv = maker.querySelector('#totalEnergy');
                const totalProteinDiv = maker.querySelector('#totalProtein');
                const totalCarbDiv = maker.querySelector('#totalCarb');
                const totalFatDiv = maker.querySelector('#totalFat');
                const initialWeightPerServingInput = maker.querySelector('#initialWeightPerServing');
                const finalWeightPerServingInput = maker.querySelector('#finalWeightPerServing');
                const weightChangeInput = maker.querySelector('#weightChange');
                const getFssaiLogoHtml = (symbol, isOutput = false, forPdf = false) => { if (!symbol) return ''; const sym = symbol.toUpperCase(); const containerClass = isOutput ? 'output-fssai-logo-container' : 'fssai-logo-container'; let logoInnerHtml = ''; let typeClass = ''; if (sym === 'VEG') { typeClass = 'fssai-veg'; logoInnerHtml = forPdf ? `<svg viewBox="0 0 12 12" style="width:100%; height:100%;"><circle cx="6" cy="6" r="3" fill="green"/></svg>` : '<span class="fssai-logo-dot"></span>'; } else if (sym === 'NONVEG') { typeClass = 'fssai-nonveg'; logoInnerHtml = `<svg viewBox="0 0 12 12" preserveAspectRatio="xMidYMid meet"><polygon points="6,2.1 1.5,9.9 10.5,9.9" /></svg>`; } else { return ''; } const inlineStyle = forPdf ? `display:inline-flex !important; vertical-align:middle; width:20px !important; height:20px !important; justify-content:center; align-items:center;` : ""; const logoSpanStyle = forPdf ? `border-color:${typeClass === 'fssai-veg' ? 'green' : '#A0522D'} !important; display:flex !important; width:14px !important; height:14px !important; border-width:1.5px !important; border-style:solid !important; justify-content:center !important; align-items:center !important; box-sizing:border-box !important;` : ""; return `<span class="${containerClass} ${typeClass}" style="${inlineStyle}"><span class="fssai-logo" style="${logoSpanStyle}">${logoInnerHtml}</span></span>`; };
                
                const updateFinalNutrientTable = () => {
                    const rawTotalEnergy = parseFloat(totalEnergyDiv.textContent) || 0;
                    const rawTotalProtein = parseFloat(totalProteinDiv.textContent) || 0;
                    const rawTotalCarb = parseFloat(totalCarbDiv.textContent) || 0;
                    const rawTotalFat = parseFloat(totalFatDiv.textContent) || 0;
                    const numServings = parseInt(servingsInput.value) || 1;
                    const finalWPS_val = parseFloat(finalWeightPerServingInput.value);
                    let energyPerServingFinal = 0, proteinPerServingFinal = 0, carbPerServingFinal = 0, fatPerServingFinal = 0;
                    let energyPer100gFinal = 0, proteinPer100gFinal = 0, carbPer100gFinal = 0, fatPer100gFinal = 0;
                    let displayNA = false;
                    maker.querySelector('#fnTableFinalWeightPerServing').textContent = isNaN(finalWPS_val) || finalWPS_val < 0 ? "-" : finalWPS_val.toFixed(2);
                    if (isNaN(finalWPS_val) || finalWPS_val < 0 || numServings <= 0) {
                        displayNA = true;
                    } else if (finalWPS_val === 0) {
                        if (rawTotalEnergy > 0 || rawTotalProtein > 0 || rawTotalCarb > 0 || rawTotalFat > 0) {
                            displayNA = true;
                        }
                    } else {
                        const totalFinalWeight = finalWPS_val * numServings;
                        
                        energyPer100gFinal = (rawTotalEnergy / totalFinalWeight) * 100;
                        proteinPer100gFinal = (rawTotalProtein / totalFinalWeight) * 100;
                        carbPer100gFinal = (rawTotalCarb / totalFinalWeight) * 100;
                        fatPer100gFinal = (rawTotalFat / totalFinalWeight) * 100;
                        
                        energyPerServingFinal = energyPer100gFinal * (finalWPS_val / 100);
                        proteinPerServingFinal = proteinPer100gFinal * (finalWPS_val / 100);
                        carbPerServingFinal = carbPer100gFinal * (finalWPS_val / 100);
                        fatPerServingFinal = fatPer100gFinal * (finalWPS_val / 100);
                    }
                    maker.querySelector('#fnTableEnergyPer100g').textContent = displayNA ? 'N/A' : energyPer100gFinal.toFixed(2);
                    maker.querySelector('#fnTableProteinPer100g').textContent = displayNA ? 'N/A' : proteinPer100gFinal.toFixed(2);
                    maker.querySelector('#fnTableCarbPer100g').textContent = displayNA ? 'N/A' : carbPer100gFinal.toFixed(2);
                    maker.querySelector('#fnTableFatPer100g').textContent = displayNA ? 'N/A' : fatPer100gFinal.toFixed(2);
                    maker.querySelector('#fnTableEnergyPerServing').textContent = displayNA ? 'N/A' : energyPerServingFinal.toFixed(2);
                    maker.querySelector('#fnTableProteinPerServing').textContent = displayNA ? 'N/A' : proteinPerServingFinal.toFixed(2);
                    maker.querySelector('#fnTableCarbPerServing').textContent = displayNA ? 'N/A' : carbPerServingFinal.toFixed(2);
                    maker.querySelector('#fnTableFatPerServing').textContent = displayNA ? 'N/A' : fatPerServingFinal.toFixed(2);
                };

                const calculateRecipeWeightChange = () => { const initialWPerServing = parseFloat(initialWeightPerServingInput.value); const finalWPerServing = parseFloat(finalWeightPerServingInput.value); if (!isNaN(initialWPerServing) && !isNaN(finalWPerServing) && initialWPerServing > 0) { weightChangeInput.value = (((finalWPerServing - initialWPerServing) / initialWPerServing) * 100).toFixed(1); } else if (initialWPerServing === 0 && finalWPerServing > 0) { weightChangeInput.value = "∞"; } else if (initialWPerServing > 0 && finalWPerServing === 0) { weightChangeInput.value = "-100.0"; } else { weightChangeInput.value = ""; } updateFinalNutrientTable(); };
                const updateTotalsRow = () => { const allIngredientRows = ingredientsContainer.querySelectorAll('.ingredient-item'); const currentServings = servingsInput.value || 1; totalSlNoDiv.textContent = `Total (for ${currentServings} serving${currentServings > 1 ? 's' : ''}):`; if (allIngredientRows.length === 0) { totalRowDisplayDiv.style.display = 'none'; deleteSelectedIngredientsBtn.style.display = 'none'; initialWeightPerServingInput.value = "0.00"; [totalEnergyDiv, totalProteinDiv, totalCarbDiv, totalFatDiv].forEach(el => el.textContent = '0.00'); totalLogoDiv.innerHTML = getFssaiLogoHtml('Veg'); totalQtyDiv.textContent = '0 g'; totalIngredientNamesDiv.textContent = ''; totalReferenceDiv.textContent = ''; totalAllergenDiv.textContent = ''; calculateRecipeWeightChange(); return; } totalRowDisplayDiv.style.display = 'grid'; deleteSelectedIngredientsBtn.style.display = 'block'; let cumulativeWeightGrams = 0, cumulativeEnergy = 0, cumulativeProtein = 0, cumulativeCarb = 0, cumulativeFat = 0; const ingredientNamesSet = new Set(), referenceSet = new Set(), allergenSet = new Set(); let isAnyNonVeg = false; allIngredientRows.forEach(row => { cumulativeWeightGrams += parseFloat(row.querySelector('input[name="ingredientActualQty[]"]').value) || 0; if (row.querySelector('input[name="ingredientUserName[]"]').value.trim()) ingredientNamesSet.add(row.querySelector('input[name="ingredientUserName[]"]').value.trim()); if (row.querySelector('input[name="ingredientReference[]"]').value.trim()) referenceSet.add(row.querySelector('input[name="ingredientReference[]"]').value.trim()); if (row.querySelector('input[name="ingredientAllergen[]"]').value.trim()) { row.querySelector('input[name="ingredientAllergen[]"]').value.trim().split(',').forEach(a => { if(a.trim()) allergenSet.add(a.trim())}); } cumulativeEnergy += parseFloat(row.querySelector('input[name="ingredientEnergy[]"]').value) || 0; cumulativeProtein += parseFloat(row.querySelector('input[name="ingredientProtein[]"]').value) || 0; cumulativeCarb += parseFloat(row.querySelector('input[name="ingredientCarb[]"]').value) || 0; cumulativeFat += parseFloat(row.querySelector('input[name="ingredientFat[]"]').value) || 0; if (row.querySelector('.ingredient-logo-display .fssai-nonveg')) isAnyNonVeg = true; }); const numServings = parseInt(servingsInput.value) || 1; initialWeightPerServingInput.value = (cumulativeWeightGrams > 0 && numServings > 0) ? (cumulativeWeightGrams / numServings).toFixed(2) : "0.00"; totalLogoDiv.innerHTML = getFssaiLogoHtml(isAnyNonVeg ? 'NonVeg' : 'Veg'); totalQtyDiv.textContent = cumulativeWeightGrams >= 1000 ? `${(cumulativeWeightGrams / 1000).toFixed(2)} kg` : `${cumulativeWeightGrams.toFixed(0)} g`; totalIngredientNamesDiv.textContent = Array.from(ingredientNamesSet).join(', '); totalReferenceDiv.textContent = Array.from(referenceSet).join(', '); totalAllergenDiv.textContent = Array.from(allergenSet).join(', '); totalEnergyDiv.textContent = cumulativeEnergy.toFixed(2); totalProteinDiv.textContent = cumulativeProtein.toFixed(2); totalCarbDiv.textContent = cumulativeCarb.toFixed(2); totalFatDiv.textContent = cumulativeFat.toFixed(2); calculateRecipeWeightChange(); };
                const calculateAndUpdateNutrition = (ingredientRowElement, baseData) => { const actualQtyInput = ingredientRowElement.querySelector('input[name="ingredientActualQty[]"]'); const [energyInput, proteinInput, carbInput, fatInput] = ['Energy', 'Protein', 'Carb', 'Fat'].map(n => ingredientRowElement.querySelector(`input[name="ingredient${n}[]"]`)); const actualQty = parseFloat(actualQtyInput.value); if (isNaN(actualQty) || !baseData) { [energyInput, proteinInput, carbInput, fatInput].forEach(input => input.value = ''); } else { const factor = actualQty / (baseData.portion || 100); energyInput.value = (baseData.energy * factor).toFixed(2); proteinInput.value = (baseData.protein * factor).toFixed(2); carbInput.value = (baseData.carb * factor).toFixed(2); fatInput.value = (baseData.fat * factor).toFixed(2); } updateTotalsRow(); };
                const updateSerialNumbers = () => { const slNoElements = ingredientsContainer.querySelectorAll('.ingredient-item input[name="ingredientSlNo[]"]'); slNoElements.forEach((el, index) => el.value = index + 1); };
                const updateServingNotice = () => { const servingsVal = parseInt(servingsInput.value); if (isNaN(servingsVal) || servingsVal <= 0) servingsInput.value = 1; const servings = servingsInput.value; const noticeText = `(for ${servings} serving${servings > 1 ? 's' : ''})`; servingSizeNoticeStep2Span.textContent = noticeText; updateTotalsRow(); };
                
                const handleRemoveIngredient = (button) => { const itemToRemove = button.closest('.ingredient-item'); itemToRemove?.remove(); if (ingredientsContainer.children.length === 0) { window.addIngredientToMaker({ symbol: 'Veg' }); } else { updateSerialNumbers(); updateTotalsRow(); } };
                const csv_jaro_winkler_distance = (s1, s2, p = 0.1, lMax = 4) => { if (!s1 || !s2) return 0.0; if (s1 === s2) return 1.0; let len1 = s1.length; let len2 = s2.length; if (len1 === 0 || len2 === 0) return 0.0; const match_distance = Math.floor(Math.max(len1, len2) / 2) - 1; const s1_matches = new Array(len1).fill(false); const s2_matches = new Array(len2).fill(false); let matches = 0; for (let i = 0; i < len1; i++) { const start = Math.max(0, i - match_distance); const end = Math.min(i + match_distance + 1, len2); for (let j = start; j < end; j++) { if (s2_matches[j]) continue; if (s1[i] !== s2[j]) continue; s1_matches[i] = true; s2_matches[j] = true; matches++; break; } } if (matches === 0) return 0.0; let t = 0; let k = 0; for (let i = 0; i < len1; i++) { if (!s1_matches[i]) continue; while (!s2_matches[k]) k++; if (s1[i] !== s2[k]) t++; k++; } t /= 2; const jaro_dist = (matches / len1 + matches / len2 + (matches - t) / matches) / 3.0; let l = 0; const prefix_limit = Math.min(lMax, Math.min(len1, len2)); for (l = 0; l < prefix_limit; l++) { if (s1[l] !== s2[l]) break; } return jaro_dist + (l * p * (1 - jaro_dist)); };
                const csv_normalize_string_for_matching = (str) => str ? str.toLowerCase().replace(/\s*&\s*/g, " and ").replace(/[.,\/#!$%\^*;:{}=\-_`~()']/g,"").replace(/\s+/g, ' ').trim() : "";
                
                const displayReviewMatchedIngredients = () => {
                    reviewMatchedTableBody.innerHTML = '';
                    if (pendingReviewCSVIngredients.length === 0) {
                        reviewMatchedSection.style.display = 'none';
                        reviewMatchedGlobalActions.style.display = 'none';
                        return;
                    }
                    reviewMatchedSection.style.display = 'block';
                    reviewMatchedGlobalActions.style.display = 'block';
                    pendingReviewCSVIngredients.forEach((item, index) => {
                        let badgeClass = 'bg-secondary';
                        let displayText = item.matchType;
                        let matchedToCellHtml = item.matchedDbEntry.name;

                        if (item.matchContext) {
                           matchedToCellHtml += ` <small class="text-muted d-block">via: <strong>${item.matchContext}</strong></small>`;
                        }

                        if (item.jwScore) {
                            badgeClass = 'bg-info';
                            displayText = `${item.matchType} (${(item.jwScore * 100).toFixed(0)}%)`;
                        }

                        const row = reviewMatchedTableBody.insertRow();
                        row.innerHTML = `<td>${item.csvName}</td><td>${item.csvQuantity.toFixed(2)}</td><td>${matchedToCellHtml}</td><td><span class="badge ${badgeClass}">${displayText}</span></td><td><button type="button" class="btn-sm" style="background-color:#5cb85c;color:white;" data-action="accept" data-index="${index}">Accept</button><button type="button" class="btn-sm" style="background-color:#f0ad4e;color:white;" data-action="reject" data-index="${index}">Reject</button><button type="button" class="btn-sm secondary" data-action="ignore" data-index="${index}">Ignore</button></td>`;
                    });
                };
                
                const displayUnmatchedIngredients = () => {
                    unmatchedTableBody.innerHTML = '';
                    unmatchedGlobalActions.style.display = 'none';
                    if (unmatchedCSVIngredients.length === 0) {
                        unmatchedSection.style.display = 'none';
                        return;
                    }
                    unmatchedSection.style.display = 'block';
                    if (unmatchedCSVIngredients.length > 0) {
                        unmatchedGlobalActions.style.display = 'block';
                    }
                    unmatchedCSVIngredients.forEach((item, index) => { const row = unmatchedTableBody.insertRow(); row.innerHTML = `<td>${item.parseError ? `<span style="color:red;" title="${item.parseError} Original: ${item.originalLine || ''}">${item.csvName} (Err)</span>` : item.csvName}</td><td>${!isNaN(item.csvQuantity) ? item.csvQuantity.toFixed(2) : 'N/A'}</td><td>${item.parseError ? `<button type="button" class="btn-sm secondary" data-action="ignore-unmatched" data-index="${index}">Dismiss</button>` : `<button type="button" class="btn-sm" data-action="map" data-index="${index}">Map</button><button type="button" class="btn-sm secondary" data-action="ignore-unmatched" data-index="${index}">Ignore</button>`}</td>`; }); 
                };
                
                const processAndDisplayCsvResults = (csvData) => {
                    pendingReviewCSVIngredients = [];
                    unmatchedCSVIngredients = [];
                    try {
                        const lines = csvData.replace(/\r\n|\r/g, '\n').trim().split('\n');
                        let dataStartIndex = 0;
                        if (lines.length > 0) {
                            const headerLine = lines[0].toLowerCase();
                            if (headerLine.includes("ingredient") || headerLine.includes("quantity") || headerLine.includes("name") || headerLine.includes("qty")) {
                                dataStartIndex = 1;
                            }
                        }
                        if (dataStartIndex === lines.length) {
                            alert("CSV file contains only a header row or is empty.");
                            return;
                        }

                        for (let i = dataStartIndex; i < lines.length; i++) {
                            const line = lines[i].trim();
                            if (!line) continue;
                            const parts = line.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g)?.map(p => p.replace(/"/g, '').trim());
                            if (!parts || parts.length < 2) {
                                unmatchedCSVIngredients.push({ csvName: `UNPARSABLE_LINE_${i+1}`, csvQuantity: NaN, originalLine: line, parseError: "Could not parse line" });
                                continue;
                            }
                            const [rawCsvIngName, rawCsvQuantityStr] = parts;
                            const csvQuantity = parseFloat(rawCsvQuantityStr);
                            if (!rawCsvIngName || isNaN(csvQuantity) || csvQuantity <= 0) {
                                unmatchedCSVIngredients.push({ csvName: rawCsvIngName, csvQuantity: NaN, originalLine: line, parseError: "Invalid name or quantity" });
                                continue;
                            }
                            
                            const normalizedCsvIngName = csv_normalize_string_for_matching(rawCsvIngName);
                            let allPotentialMatches = [];

                            for (const dbIng of unifiedAddableItems) {
                                const matchCandidates = [];

                                const normalizedFullName = csv_normalize_string_for_matching(dbIng.name);
                                if (normalizedFullName) {
                                    matchCandidates.push({ term: normalizedFullName, type: 'Name' });
                                }
                                
                                if (dbIng.name && dbIng.name.includes(',')) {
                                    dbIng.name.split(',').forEach(part => {
                                        const normalizedPart = csv_normalize_string_for_matching(part);
                                        if (normalizedPart && normalizedPart !== normalizedFullName) {
                                            matchCandidates.push({ term: normalizedPart, type: 'Name Part', context: part.trim() });
                                        }
                                    });
                                }
                                
                                if (dbIng.keyword) {
                                    dbIng.keyword.split(',').forEach(kw => {
                                        const normalizedKw = csv_normalize_string_for_matching(kw);
                                        if (normalizedKw) {
                                            matchCandidates.push({ term: normalizedKw, type: 'Keyword', context: kw.trim() });
                                        }
                                    });
                                }

                                for (const candidate of matchCandidates) {
                                    const score = csv_jaro_winkler_distance(normalizedCsvIngName, candidate.term);
                                    if (score >= CSV_REVIEW_JW_MATCH_THRESHOLD) {
                                        allPotentialMatches.push({
                                            csvName: rawCsvIngName,
                                            csvQuantity: csvQuantity,
                                            matchedDbEntry: dbIng,
                                            matchType: `JW ${candidate.type}`,
                                            matchContext: candidate.context,
                                            jwScore: score
                                        });
                                    }
                                }
                            }

                            if (allPotentialMatches.length > 0) {
                                allPotentialMatches.sort((a, b) => b.jwScore - a.jwScore);
                                pendingReviewCSVIngredients.push(...allPotentialMatches);
                            } else {
                                unmatchedCSVIngredients.push({ csvName: rawCsvIngName, csvQuantity: csvQuantity, originalLine: line });
                            }
                        }
                    } catch (e) {
                        alert("An error occurred while processing the CSV file. Check console for details.");
                        console.error(e);
                    }
                    displayReviewMatchedIngredients();
                    displayUnmatchedIngredients();
                };

                const updateSelectedReviewAndSearchContainer = () => { selectedIngredientsReviewContent.innerHTML = ''; let hasSelections = false; for (const key in currentlyCheckedInSearch) { if (currentlyCheckedInSearch[key]) { hasSelections = true; const dbItem = unifiedAddableItems.find(i => i.id == key); if (dbItem) { const itemBox = document.createElement('span'); itemBox.className = 'selected-review-item'; itemBox.innerHTML = `${dbItem.name} <button type="button" class="remove-selected-review-btn" data-db-key="${dbItem.id}" title="Remove ${dbItem.name}">x</button>`; selectedIngredientsReviewContent.appendChild(itemBox); } } } selectedIngredientsReviewDiv.style.display = hasSelections ? 'block' : 'none'; addSelectedIngredientsBtn.style.display = hasSelections ? 'block' : 'none'; const searchTermActive = ingredientSearchInput.value.trim().length >= 2; if (searchTermActive || hasSelections) { searchResultsContainerDiv.style.display = 'block'; if (!searchTermActive) { resultsListInnerDiv.innerHTML = '<div class="no-results-message"><i>Review selections below or type to search.</i></div>'; } } else { searchResultsContainerDiv.style.display = 'none'; } };
                processIngredientFileBtn.addEventListener('click', () => { const ingredientFileUploadInput = maker.querySelector('#ingredientFileUpload'); if (!ingredientFileUploadInput.files.length) { alert('Please select a CSV file first.'); return; } const file = ingredientFileUploadInput.files[0]; const reader = new FileReader(); processIngredientFileBtn.disabled = true; processIngredientFileBtn.textContent = "Processing..."; reader.onload = (event) => { processAndDisplayCsvResults(event.target.result); ingredientFileUploadInput.value = ''; processIngredientFileBtn.disabled = false; processIngredientFileBtn.textContent = "Process File"; }; reader.onerror = () => { alert('Failed to read file!'); processIngredientFileBtn.disabled = false; processIngredientFileBtn.textContent = "Process File"; }; reader.readAsText(file); });
                downloadSampleCsvBtnNew.addEventListener('click', (e) => { e.preventDefault(); const sampleCSVData = `"Ingredient Name","Quantity (g)"\n"Tomato","150"\n"Chicken Breast","120"\n"Spicy Lamb Curry","200"\n"Salt","5"`; const blob = new Blob([sampleCSVData], { type: 'text/csv;charset=utf-8;' }); const link = document.createElement("a"); const url = URL.createObjectURL(blob); link.setAttribute("href", url); link.setAttribute("download", 'ingredients_and_recipes_sample.csv'); document.body.appendChild(link); link.click(); document.body.removeChild(link); URL.revokeObjectURL(url); });
                acceptAllMatchedBtn.addEventListener('click', () => { if (confirm(`Accept all ${pendingReviewCSVIngredients.length} remaining matched ingredients?`)) { for (let i = pendingReviewCSVIngredients.length - 1; i >= 0; i--) { const item = pendingReviewCSVIngredients[i]; window.addIngredientToMaker({ ...item.matchedDbEntry, actualQty: item.csvQuantity, fromDB: true }); } pendingReviewCSVIngredients = []; displayReviewMatchedIngredients(); } });
                rejectAllMatchedBtn.addEventListener('click', () => { if (confirm(`Reject all ${pendingReviewCSVIngredients.length} remaining matched ingredients? They will be moved to the Unmatched list.`)) { unmatchedCSVIngredients.push(...pendingReviewCSVIngredients.map(item => ({ csvName: item.csvName, csvQuantity: item.csvQuantity, originalLine: item.originalLine }))); pendingReviewCSVIngredients = []; displayReviewMatchedIngredients(); displayUnmatchedIngredients(); } });
                ignoreAllMatchedBtn.addEventListener('click', () => { if (pendingReviewCSVIngredients.length === 0) return; if (confirm(`Are you sure you want to ignore all ${pendingReviewCSVIngredients.length} auto-matched ingredients? They will be removed from this review list.`)) { pendingReviewCSVIngredients = []; displayReviewMatchedIngredients(); } });
                
                ignoreAllUnmatchedBtn.addEventListener('click', () => {
                    if (unmatchedCSVIngredients.length === 0) return;
                    if (confirm(`Are you sure you want to ignore all ${unmatchedCSVIngredients.length} unmatched ingredients? They will be removed from the list.`)) {
                        unmatchedCSVIngredients = [];
                        displayUnmatchedIngredients();
                    }
                });

                reviewMatchedTableBody.addEventListener('click', (event) => { const button = event.target.closest('button[data-index]'); if (!button) return; const { action, index } = button.dataset; const item = pendingReviewCSVIngredients[index]; if (!item) return; if (action === 'accept') { window.addIngredientToMaker({ ...item.matchedDbEntry, actualQty: item.csvQuantity, fromDB: true }); } else if (action === 'reject') { unmatchedCSVIngredients.push({ csvName: item.csvName, csvQuantity: item.csvQuantity, originalLine: item.originalLine }); displayUnmatchedIngredients(); } pendingReviewCSVIngredients.splice(index, 1); displayReviewMatchedIngredients(); });
                
                const closeMapModal = () => { mapIngredientModal.style.display = 'none'; const selectEl = $(selectDbIngredientForMapEl); if (selectEl.data('select2')) { selectEl.select2('destroy'); } selectEl.val(null); };
                
                unmatchedTableBody.addEventListener('click', (event) => { const button = event.target.closest('button[data-index]'); if (!button) return; const { action, index } = button.dataset; if (action === 'map') { const item = unmatchedCSVIngredients[index]; csvIngredientToMapNameEl.textContent = item.csvName; csvIngredientToMapQuantityEl.textContent = item.csvQuantity.toFixed(2); unmatchedCsvItemIndexInput.value = index; const ingredientsGroup = unifiedAddableItems.filter(i => i.type === 'ingredient').sort((a,b) => a.name.localeCompare(b.name)); const recipesGroup = unifiedAddableItems.filter(i => i.type === 'recipe').sort((a,b) => a.name.localeCompare(b.name)); let optionsHTML = '<option></option>'; optionsHTML += '<optgroup label="Ingredients">'; optionsHTML += ingredientsGroup.map(dbIng => `<option value="${dbIng.id}">${dbIng.name}</option>`).join(''); optionsHTML += '</optgroup>'; optionsHTML += '<optgroup label="Recipes">'; optionsHTML += recipesGroup.map(dbIng => `<option value="${dbIng.id}">${dbIng.name}</option>`).join(''); optionsHTML += '</optgroup>'; selectDbIngredientForMapEl.innerHTML = optionsHTML; mapIngredientModal.style.display = 'block'; $(selectDbIngredientForMapEl).select2({ theme: 'bootstrap-5', placeholder: 'Search and select an item...', dropdownParent: $(mapIngredientModal) }); } else if (action === 'ignore-unmatched') { unmatchedCSVIngredients.splice(index, 1); displayUnmatchedIngredients(); } });
                confirmMapIngredientBtn.addEventListener('click', () => { const selectedDbId = selectDbIngredientForMapEl.value; const itemIndex = parseInt(unmatchedCsvItemIndexInput.value); if (!selectedDbId || isNaN(itemIndex)) { alert("Please select an item."); return; } const dbEntry = unifiedAddableItems.find(i => i.id == selectedDbId); const unmatchedItem = unmatchedCSVIngredients.splice(itemIndex, 1)[0]; if (dbEntry && unmatchedItem) { window.addIngredientToMaker({ ...dbEntry, actualQty: unmatchedItem.csvQuantity, fromDB: true }); displayUnmatchedIngredients(); closeMapModal(); } });
                mapModalCloseBtns.forEach(btn => btn.addEventListener('click', closeMapModal));
                window.addEventListener('click', (event) => { if (event.target === mapIngredientModal) closeMapModal(); });
                ingredientsContainer.addEventListener('click', (event) => { if (event.target.matches('.remove-btn')) handleRemoveIngredient(event.target); });
                ingredientsContainer.addEventListener('input', (event) => { if (event.target.matches('input[name="ingredientActualQty[]"]')) { 
                    const row = event.target.closest('.ingredient-item');
                    const dbName = row.querySelector('input[name="ingredientDbName[]"]').value;
                    let baseData = unifiedAddableItems.find(item => item.name === dbName);
                    if (baseData) {
                         calculateAndUpdateNutrition(row, baseData);
                    }
                 } });
                ingredientSearchInput.addEventListener('input', () => { const searchTerm = ingredientSearchInput.value.trim().toLowerCase(); resultsListInnerDiv.innerHTML = ''; if (searchTerm.length < 2) { updateSelectedReviewAndSearchContainer(); return; } const foundItems = unifiedAddableItems.filter(item => { return item.name.toLowerCase().includes(searchTerm) || (item.type === 'ingredient' && item.keyword && item.keyword.toLowerCase().includes(searchTerm)) }); if (foundItems.length > 0) { foundItems.forEach(dbItem => { const resultItemDiv = document.createElement('div'); resultItemDiv.classList.add('search-result-item'); 
                
                const keywordOrTypeCell = dbItem.type === 'recipe' ? `Recipe (${dbItem.portion}g)` : dbItem.keyword || ''; 
                const refCell = dbItem.type === 'recipe' ? 'Sub-Recipe' : dbItem.refrence || '';

                resultItemDiv.innerHTML = `<div><input type="checkbox" data-db-key="${dbItem.id}" ${currentlyCheckedInSearch[dbItem.id] ? 'checked' : ''}></div><div>${dbItem.id || ''}</div> <div>${getFssaiLogoHtml(dbItem.symbol)}</div> <div title="${dbItem.name}">${dbItem.name}</div> <div title="${keywordOrTypeCell}">${keywordOrTypeCell}</div> <div title="${refCell}">${refCell}</div> <div>${dbItem.allergen && dbItem.allergen !=='None' ? `<span class="allergen-icon" title="Allergen: ${dbItem.allergen}">⚠️</span>` : '-'}</div> <div>${dbItem.energy}</div> <div>${dbItem.protein}</div> <div>${dbItem.carb}</div> <div>${dbItem.fat}</div>`; resultsListInnerDiv.appendChild(resultItemDiv); }); } else { resultsListInnerDiv.innerHTML = '<div class="no-results-message">No ingredients or recipes found.</div>'; } updateSelectedReviewAndSearchContainer(); });
                resultsListInnerDiv.addEventListener('change', (event) => { if (event.target.matches('input[type="checkbox"]')) { const key = event.target.dataset.dbKey; currentlyCheckedInSearch[key] = event.target.checked; updateSelectedReviewAndSearchContainer(); } });
                selectedIngredientsReviewContent.addEventListener('click', (event) => { if (event.target.matches('.remove-selected-review-btn')) { const key = event.target.dataset.dbKey; currentlyCheckedInSearch[key] = false; const checkboxInList = resultsListInnerDiv.querySelector(`input[data-db-key="${key}"]`); if (checkboxInList) checkboxInList.checked = false; updateSelectedReviewAndSearchContainer(); } });
                
                addSelectedIngredientsBtn.addEventListener('click', () => {
                    const checkedItems = Object.keys(currentlyCheckedInSearch).filter(key => currentlyCheckedInSearch[key]);
                    checkedItems.forEach(key => {
                        const dbItem = unifiedAddableItems.find(i => i.id == key);
                        if (dbItem) {
                            window.addIngredientToMaker({ ...dbItem, fromDB: true });
                        }
                    });
                    currentlyCheckedInSearch = {};
                    ingredientSearchInput.value = '';
                    resultsListInnerDiv.innerHTML = '';
                    updateSelectedReviewAndSearchContainer();
                });

                servingsInput.addEventListener('input', updateServingNotice);
                finalWeightPerServingInput.addEventListener('input', calculateRecipeWeightChange);
                makerAddManualBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.ingredientModalContext = 'recipe_maker';
                    const ingredientModal = new bootstrap.Modal(document.getElementById('ingredientModal'));
                    ingredientModal.show();
                });
                function validateAndSave() {
                    let firstErrorElement = null; const errors = [];
                    maker.querySelectorAll('.validation-error').forEach(el => el.classList.remove('validation-error'));
                    const highlightError = (element) => { element.classList.add('validation-error'); if (!firstErrorElement) firstErrorElement = element; };
                    if (!maker.querySelector('#recipeTitle').value.trim()) { errors.push("Recipe Title is required."); highlightError(maker.querySelector('#recipeTitle')); }
                    const servings = parseInt(maker.querySelector('#servings').value, 10);
                    if (isNaN(servings) || servings <= 0) { errors.push("Servings must be a number greater than 0."); highlightError(maker.querySelector('#servings')); }
                    const ingredientRows = maker.querySelectorAll('#ingredientsContainer .ingredient-item'); let allQuantitiesInvalid = true;
                    if (ingredientRows.length > 0) { ingredientRows.forEach((row) => { const qty = parseFloat(row.querySelector('input[name="ingredientActualQty[]"]').value); if (!isNaN(qty) && qty > 0) allQuantitiesInvalid = false; }); }
                    if (allQuantitiesInvalid) { errors.push("At least one ingredient must have a valid quantity (greater than 0)."); highlightError(ingredientsContainer); }
                    const finalWeight = parseFloat(maker.querySelector('#finalWeightPerServing').value);
                    if (isNaN(finalWeight) || finalWeight < 0) { errors.push("Final weight per serving must be a valid number (0 or greater)."); highlightError(maker.querySelector('#finalWeightPerServing')); }
                    if (errors.length > 0) { alert("Please fix the following issues before saving:\n\n- " + errors.join("\n- ")); if (firstErrorElement) { firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' }); setTimeout(() => { firstErrorElement.focus(); }, 500); } return; }
                    
                    const editingId = form.dataset.editingId ? parseInt(form.dataset.editingId, 10) : null;
                    
                    const recipePayload = {
                        name: maker.querySelector('#recipeTitle').value.trim(),
                        servings: servings,
                        portion: finalWeight,
                        symbol: maker.querySelector('#totalLogo .fssai-nonveg') ? 'NonVeg' : 'Veg',
                        allergen: maker.querySelector('#totalAllergen').textContent || 'None',
                        refrence: maker.querySelector('#totalReference').textContent || 'Internal',
                        description: maker.querySelector('#recipeDescription').value.trim(),
                        notes: maker.querySelector('#recipeNotes').value.trim(),
                        energy: parseFloat(maker.querySelector('#fnTableEnergyPerServing').textContent),
                        protein: parseFloat(maker.querySelector('#fnTableProteinPerServing').textContent),
                        carb: parseFloat(maker.querySelector('#fnTableCarbPerServing').textContent),
                        fat: parseFloat(maker.querySelector('#fnTableFatPerServing').textContent),
                        ingredients: Array.from(ingredientRows).map(row => ({
                            ingredientId: parseInt(row.dataset.ingredientId, 10),
                            quantity: parseFloat(row.querySelector('input[name="ingredientActualQty[]"]').value)
                        })).filter(ing => ing.ingredientId && ing.quantity > 0)
                    };

                    if (editingId) {
                        const recipeToUpdate = tableData_RecipeList.find(r => r.id === editingId);
                        if (recipeToUpdate) {
                            Object.assign(recipeToUpdate, recipePayload);
                            alert('Recipe updated successfully!');
                        }
                    } else {
                        const newRecipe = {
                            ...recipePayload,
                            id: Date.now(),
                            corporateName: "SFM Corporate",
                            regionalName: "Central",
                            unitName: "Main Kitchen",
                            createdOn: new Date().toISOString(),
                            isActive: true,
                            deactivatedOn: null
                        };
                        tableData_RecipeList.unshift(newRecipe);
                        alert('Recipe saved successfully!');
                    }

                    resetRecipeMakerForm(); 
                    document.querySelector('.tab-button[data-tab="recipe"]').click();
                    showRecipeListView();
                    applyFiltersAndRender_Recipes();
                }
                makerBackBtn.addEventListener('click', () => {
                    resetRecipeMakerForm();
                    showRecipeListView();
                });
                makerSaveBtn.addEventListener('click', validateAndSave);
                maker.addEventListener('input', (e) => { if (e.target.classList.contains('validation-error')) e.target.classList.remove('validation-error'); });
                window.addIngredientToMaker({ symbol: 'Veg' });
            }
            
                        // --- GLOBAL MODAL SAVE HANDLER ---
            $('#saveIngredientBtn').on('click', function(e) {
                e.preventDefault();
                const modal = document.getElementById('ingredientModal');
                const name = $('#form-name').val().trim();
                if (!name) {
                    alert('Ingredient Name is required.');
                    return;
                }
                const selectedReferences = $('#form-refrence-select').val();
                const selectedAllergens = $('#form-allergen-select').val();
                const editingId = $('#ingredientForm').data('editing-id');

                const itemData = {
                    name: name,
                    symbol: $('#form-symbol').val(),
                    keyword: $('#form-keyword').val(),
                    refrence: selectedReferences && selectedReferences.length > 0 ? selectedReferences.join(', ') : 'None',
                    allergen: selectedAllergens && selectedAllergens.length > 0 ? selectedAllergens.join(', ') : 'None',
                    portion: $('#form-portion').val() || 100,
                    energy: $('#form-energy').val() || 0,
                    protein: $('#form-protein').val() || 0,
                    carb: $('#form-carb').val() || 0,
                    fat: $('#form-fat').val() || 0,
                };

                if (window.ingredientModalContext === 'master_list') {
                    if (editingId) {
                        const itemToUpdate = window.masterIngredientData.find(i => i.id === editingId);
                        if(itemToUpdate) { Object.assign(itemToUpdate, itemData); }
                    } else {
                        const newIngredient = { ...itemData, id: Date.now() + Math.random(), createdOn: new Date().toISOString(), status: 'active' };
                        window.masterIngredientData.unshift(newIngredient);
                    }
                    if (typeof window.applyIngredientsFilters === 'function') {
                        window.applyIngredientsFilters();
                    }
                } else if (window.ingredientModalContext === 'recipe_maker') {
                    const newMasterIngredient = { ...itemData, id: Date.now() + Math.random(), createdOn: new Date().toISOString(), status: 'active' };
                    
                    if (typeof window.addIngredientToMaker === 'function') {
                        // Add to the recipe maker form's list
                        window.addIngredientToMaker({
                            ...newMasterIngredient,
                            userName: newMasterIngredient.name,
                            actualQty: newMasterIngredient.portion,
                            fromDB: false
                        });
                    }
                    // Also add to the main ingredients database for future use
                    window.masterIngredientData.unshift(newMasterIngredient);

                    // Rebuild the search source to include the new ingredient
                    if (typeof window.rebuildUnifiedSearchSource === 'function') {
                        window.rebuildUnifiedSearchSource();
                    }
                }

                bootstrap.Modal.getInstance(modal).hide();
            });

             $('#ingredientModal').on('hidden.bs.modal', function () { 
                $('#ingredientForm').trigger('reset').removeData('editing-id'); 
                $('#ingredientModalLabel').text('Add New Ingredient'); 
                $('#form-refrence-select').val(null).trigger('change'); 
                $('#form-allergen-select').val(null).trigger('change'); 
             });

        });
    </script>
 @yield('footerscript')

				

</html>
