
    <!-- Style block for the Tab Interface -->
    <style>
        /* Basic styles for the body */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
            padding: 20px;
            margin: 0; /* Reset margin */
        }

        /* The main container for the tabs */
        .tab-container {
            width: 100%;
            max-width: 95%; /* Increased max-width for the larger content */
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden; 
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
            border-bottom: 3px solid #007bff;
        }

        .tab-content-area {
             padding: 0; /* Remove padding to allow full-width content from your app */
        }
        
        /* Adjusted padding for the second tab's content */
        .tab-content-area .observation-content {
            padding: 25px;
        }

        .tab-content {
            display: none; 
        }

        .tab-content.active {
            display: block; 
        }
        
        /* Simple styling for the Observation Tab content */
        .observation-content h3 {
            margin-top: 0;
            color: #343a40;
        }
        
        .observation-content textarea {
            width: 100%;
            min-height: 400px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box; 
        }
    </style>
    
    <!-- Style block from your provided code -->
    <style>
        :root {
            --primary-bg: #eef1f5; --container-bg: #ffffff; --border-color: #d1d9e6; --text-primary: #333a45; --text-secondary: #5a6576; --text-muted: #7b879a; --accent-color: #0077b6; --accent-color-darker: #005b8e; --accent-color-hover: #006aa3; --success-color: #2a9d8f; --success-color-hover: #268c80; --danger-color: #e76f51; --danger-color-hover: #d96343; --info-color: #457b9d;  --info-color-hover: #3c6a89; --warning-color: #f4a261; --warning-color-hover: #e09050; --modal-bg: rgba(0, 0, 0, 0.5); --modal-content-bg: #fff; --input-border-color: #ced4da; --input-focus-border-color: #86b7fe; --input-focus-box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.25); --font-family-sans-serif: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; --base-font-size: 16px; --line-height-base: 1.6; --border-radius: 0.375rem; --spacing-unit: 1rem;
        }
        *, *::before, *::after { box-sizing: border-box; } 
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
        #addTrainingProgramButton, #downloadFullSampleCsvButton, #uploadFullCsvButton { padding: 0.6rem 1.2rem; font-size: 0.9rem; font-weight: 500; color: #fff; border: none; border-radius: var(--border-radius); cursor: pointer; transition: background-color 0.2s ease, box-shadow 0.2s ease; text-align: center; }
        #addTrainingProgramButton:hover, #downloadFullSampleCsvButton:hover, #uploadFullCsvButton:hover { box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #addTrainingProgramButton { background-color: var(--accent-color); } #addTrainingProgramButton:hover { background-color: var(--accent-color-hover); }
        #downloadFullSampleCsvButton { background-color: var(--success-color); } #downloadFullSampleCsvButton:hover { background-color: var(--success-color-hover); }
        #uploadFullCsvButton { background-color: var(--danger-color); } #uploadFullCsvButton:hover { background-color: var(--danger-color-hover); }
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
        @media (max-width: 1200px) { }
        @media (max-width: 768px) { 
            .app-header h1 { font-size: 1.5rem; } 
            .main-content-area { padding: var(--spacing-unit); } 
            .action-group button:not(.btn-icon-action), .button-pair button { font-size: 0.9rem; padding: 0.6rem 1.2rem; width: 100%; } 
            .button-pair { flex-direction: column;} 
            summary.entity-summary { padding: calc(var(--spacing-unit) * 0.75) var(--spacing-unit); } 
            .entity-description { padding: 0.6rem calc(var(--spacing-unit) * 0.75); } 
            .action-button, .edit-btn, .delete-btn { padding: 0.25rem 0.5rem; font-size: 0.75rem; } 
            .entity-count { font-size: 0.7rem; padding: 0.15rem 0.3rem; margin-right: calc(var(--spacing-unit) * 0.3); } 
            .summary-actions { gap: calc(var(--spacing-unit) * 0.3); } 
            .modal-content { margin: 5% auto; width: 90%; } 
            .filter-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) { 
            .summary-actions .edit-btn > span, .summary-actions .summary-action-btn > span, .summary-actions .activation-btn > span, .summary-actions .delete-btn > span { display: none; } 
            .summary-actions .edit-btn .btn-icon, .summary-actions .summary-action-btn .btn-icon, .summary-actions .activation-btn .btn-icon, .summary-actions .delete-btn .btn-icon { margin-right:0; } 
            .action-button, .edit-btn, .summary-actions .activation-btn, .delete-btn { padding: 0.3rem 0.5rem; } 
            .entity-count { font-size: 0.65rem; padding: 0.1rem 0.25rem; margin-right: calc(var(--spacing-unit) * 0.2); } 
            .entity-count .count-label { display: none; }
            .scoped-upload-section, .keyword-management-section { flex-direction: column; align-items: stretch; } 
            .scoped-upload-section h4, .keyword-management-section h4 { margin-bottom: calc(var(--spacing-unit) * 0.5); text-align: center;} 
            .scoped-upload-section .button-pair, .keyword-management-section .button-pair { flex-direction: column; }
        }
    </style>