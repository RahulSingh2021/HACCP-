
@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <style>
        :root {
            --primary-bg: #eef1f5; --container-bg: #ffffff; --border-color: #d1d9e6; --text-primary: #333a45; --text-secondary: #5a6576; --text-muted: #7b879a; --accent-color: #0077b6; --accent-color-darker: #005b8e; --accent-color-hover: #006aa3; --success-color: #2a9d8f; --success-color-hover: #268c80; --danger-color: #e76f51; --danger-color-hover: #d96343; --info-color: #457b9d;  --info-color-hover: #3c6a89; --warning-color: #f4a261; --warning-color-hover: #e09050; --pending-color: var(--text-muted); --trial-color: #6f42c1; --basic-color: var(--info-color); --pro-color: var(--success-color); --ultra-pro-color: #9b59b6; --common-feature-color: #e85d04; --modal-bg: rgba(0, 0, 0, 0.5); --modal-content-bg: #fff; --input-border-color: #ced4da; --input-focus-border-color: #86b7fe; --input-focus-box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.25); --font-family-sans-serif: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; --base-font-size: 16px; --line-height-base: 1.6; --border-radius: 0.375rem; --spacing-unit: 1rem;
            --unit-summary-bg: #f4f6f9; --unit-summary-hover-bg: #e9ecf1; --unit-summary-open-bg: var(--warning-color); --unit-summary-open-border: var(--warning-color-hover); --unit-summary-inactive-bg: #f0f0f0; --unit-summary-inactive-open-bg: #e0e0e0;
        }
        *, *::before, *::after { box-sizing: border-box; } html { font-size: var(--base-font-size); scroll-behavior: smooth; }
        body { font-family: var(--font-family-sans-serif); margin: 0; background-color: var(--primary-bg); color: var(--text-primary); line-height: var(--line-height-base); display: flex; flex-direction: column; min-height: 100vh; }
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
        .hidden-by-filter { display: none !important; }

        .top-action-buttons-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: var(--spacing-unit); align-items: start; }
        .action-group { background-color: var(--container-bg); padding: var(--spacing-unit); border-radius: calc(var(--border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--border-color); display: flex; flex-direction: column; }
        .action-group h3 { margin-top: 0; margin-bottom: calc(var(--spacing-unit) * 0.75); font-size: 1.1rem; color: var(--accent-color); font-weight: 600; border-bottom: 1px solid var(--border-color); padding-bottom: calc(var(--spacing-unit) * 0.5); }
        .action-group button:not(.btn-icon-action) { width: 100%; margin-bottom: calc(var(--spacing-unit) * 0.5); } .action-group button:last-child:not(.btn-icon-action) { margin-bottom: 0; }
        .button-pair { display: flex; gap: calc(var(--spacing-unit) * 0.5); } .button-pair button { flex-grow: 1; }

        .super-admin-dashboard-details { background-color: var(--container-bg); border: 1px solid var(--border-color); border-radius: calc(var(--border-radius) * 1.5); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); margin-bottom: calc(var(--spacing-unit) * 1.5); overflow: hidden; }
        .super-admin-dashboard-summary { padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.25); font-weight: 600; font-size: 1.15rem; color: var(--accent-color); cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; border-bottom: 1px solid transparent; flex-wrap: wrap; }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary { background-color: var(--accent-color); color: white; border-bottom-color: var(--accent-color-darker); }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-content-wrapper .entity-name-display,
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-content-wrapper .entity-icon,
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count,
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count strong,
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .toggler-icon { color: white; }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .summary-actions .entity-count { border-color: rgba(255,255,255,0.4); background-color: rgba(255,255,255,0.1); }
        .super-admin-dashboard-summary::-webkit-details-marker, .super-admin-dashboard-summary::marker { display: none; }
        .super-admin-dashboard-summary .summary-actions { font-size: 0.8rem; margin-left: var(--spacing-unit); }
        .super-admin-dashboard-summary .toggler-icon { font-size: 0.875em; color: var(--text-muted); transition: transform 0.25s ease-out; margin-left: auto; }
        .super-admin-dashboard-details[open] > .super-admin-dashboard-summary .toggler-icon { transform: rotate(90deg); }
        .super-admin-dashboard-details .dashboard-action-buttons-container { padding: calc(var(--spacing-unit) * 1.25); border-top: 1px solid var(--border-color); }
        .super-admin-dashboard-details .dashboard-action-buttons-container .top-action-buttons-grid { margin-bottom: 0; }

        #addCorporateEntityButton, #downloadFullSampleCsvButton, #uploadFullCsvButton { padding: 0.6rem 1.2rem; font-size: 0.9rem; font-weight: 500; color: #fff; border: none; border-radius: var(--border-radius); cursor: pointer; transition: background-color 0.2s ease, box-shadow 0.2s ease; text-align: center; }
        #addCorporateEntityButton:hover, #downloadFullSampleCsvButton:hover, #uploadFullCsvButton:hover { box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        #addCorporateEntityButton { background-color: var(--accent-color); } #addCorporateEntityButton:hover { background-color: var(--accent-color-hover); }
        #downloadFullSampleCsvButton { background-color: var(--success-color); } #downloadFullSampleCsvButton:hover { background-color: var(--success-color-hover); }
        #uploadFullCsvButton { background-color: var(--danger-color); } #uploadFullCsvButton:hover { background-color: var(--danger-color-hover); }

        .scoped-upload-section { margin-top: 0; padding: var(--spacing-unit); background-color: #f7f9fc; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-unit); }
        details > .scoped-upload-section + .entity-content-wrapper { border-top: none; }
        .entity-content-wrapper > .scoped-upload-section { margin-top: var(--spacing-unit); padding-top: var(--spacing-unit); border-top: 1px dashed var(--border-color); background-color: transparent; border-bottom: none; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-unit); }
        .scoped-upload-section h4 { font-size: 1rem; color: var(--text-secondary); margin-bottom: 0; font-weight: 500; flex-grow: 1; }
        .scoped-upload-section .button-pair { flex-shrink: 0; }
        .scoped-upload-section .button-pair button, .scoped-upload-section .action-button { font-size: 0.8rem; padding: 0.4rem 0.8rem; margin-bottom: 0; }
        .action-button.download-sample { background-color: var(--success-color); color: white; } .action-button.download-sample:hover { background-color: var(--success-color-hover); }
        .action-button.upload-scoped { background-color: var(--info-color); color: white; } .action-button.upload-scoped:hover { background-color: var(--info-color-hover); }
        .upload-status-area { margin-top: 1rem; font-weight: 500; padding: 0.75rem; border-radius: var(--border-radius); background-color: #e9ecef; border: 1px solid var(--border-color); min-height: 40px; font-size: 0.85rem; line-height: 1.5; }

        details.entity-level { margin-bottom: calc(var(--spacing-unit) * 1.25); border-radius: calc(var(--border-radius) * 1.5); background-color: var(--container-bg); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--border-color); overflow: hidden; transition: box-shadow 0.3s ease, opacity 0.3s ease; }
        details.entity-level:hover { box-shadow: 0 5px 15px rgba(0, 30, 80, 0.1); }
        summary.entity-summary { padding: var(--spacing-unit) calc(var(--spacing-unit) * 1.25); font-weight: 600; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s ease, color 0.2s ease; flex-wrap: wrap; }
        summary.entity-summary::-webkit-details-marker, summary.entity-summary::marker { display: none; }
        summary.entity-summary:hover { background-color: #f8f9fa; }
        details.corporate-entity > summary.entity-summary { background-color: #f8f9fa; color: var(--text-primary); font-size: 1.1rem; border-bottom: 1px solid transparent; }
        details.corporate-entity[open] > summary.entity-summary { background-color: var(--accent-color); color: white; border-bottom-color: var(--accent-color-darker); }
        details.regional-office > summary.entity-summary { background-color: #fafbfc; font-size: 1rem; color: var(--text-secondary); border-bottom: 1px solid transparent; }
        details.regional-office[open] > summary.entity-summary { background-color: var(--info-color); color: white; border-bottom-color: var(--info-color-hover); }
        details.corporate-entity[open] > summary.entity-summary .entity-icon, details.corporate-entity[open] > summary.entity-summary .toggler-icon, details.corporate-entity[open] > summary.entity-summary .summary-action-btn, details.corporate-entity[open] > summary.entity-summary .edit-btn, details.corporate-entity[open] > summary.entity-summary .activation-btn, details.corporate-entity[open] > summary.entity-summary .entity-count,
        details.regional-office[open] > summary.entity-summary .entity-icon, details.regional-office[open] > summary.entity-summary .toggler-icon, details.regional-office[open] > summary.entity-summary .summary-action-btn, details.regional-office[open] > summary.entity-summary .edit-btn, details.regional-office[open] > summary.entity-summary .activation-btn, details.regional-office[open] > summary.entity-summary .entity-count { color: white; }
        
        .summary-content-wrapper { display: flex; align-items: center; gap: calc(var(--spacing-unit) * 0.5); flex-grow: 1; min-width: 0; flex-wrap: wrap; } 
        .entity-icon { font-size: 1.25em; color: var(--text-muted); line-height: 1; flex-shrink: 0; } 
        .entity-name-display, .unit-name-display { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; } 
        .unit-name-display { font-weight: 600; font-size: 0.95rem; } 
        .summary-actions { display: flex; align-items: center; gap: calc(var(--spacing-unit) * 0.5); flex-shrink: 0; flex-wrap: wrap; } 
        .toggler-icon { font-size: 0.875em; color: var(--text-muted); transition: transform 0.25s ease-out; padding: 0.25rem; line-height: 1; } 
        details[open] > summary.entity-summary .toggler-icon, details[open] > summary.unit-summary .toggler-icon { transform: rotate(90deg); }
        
        .entity-content-wrapper { padding: calc(var(--spacing-unit) * 1.25); border-top: 1px solid var(--border-color); background-color: var(--container-bg); transition: opacity 0.3s ease; }
        .entity-content-wrapper > details.entity-level { margin-top: var(--spacing-unit); } 
        .entity-details-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--spacing-unit); margin-bottom: var(--spacing-unit); padding: var(--spacing-unit); background-color: var(--container-bg); border-radius: calc(var(--border-radius) * 0.75); border: 1px solid #e9ecef; } .detail-item { font-size: 0.9rem; } .detail-item strong { color: var(--text-secondary); display: block; margin-bottom: 0.25rem; font-weight: 500; } .detail-item .value-display, .detail-item a.value-display { color: var(--text-muted); text-decoration: none; word-break: break-word; } .detail-item a.value-display { color: var(--accent-color); } .detail-item a.value-display:hover { text-decoration: underline; color: var(--accent-color-darker); } .detail-icon { margin-right: 0.375rem; color: var(--text-muted); }
        .entity-description { font-size: 0.95rem; color: var(--text-secondary); margin-bottom: calc(var(--spacing-unit) * 1.25); padding: 0.75rem var(--spacing-unit); background-color: #f7f9fc; border-left: 4px solid var(--accent-color); border-radius: 0 var(--border-radius) var(--border-radius) 0; }
        .unit-section-header { font-size: 1.05rem; color: var(--text-primary); margin-top: calc(var(--spacing-unit) * 1.5); margin-bottom: var(--spacing-unit); padding-bottom: calc(var(--spacing-unit) * 0.5); border-bottom: 1px solid var(--border-color); font-weight: 500; } 
        
        .unit-list { list-style-type: none; padding-left: 0; display: flex; flex-direction: column; gap: var(--spacing-unit); }
        details.unit-item-container { border-radius: calc(var(--border-radius) * 1.5); background-color: var(--container-bg); box-shadow: 0 3px 8px rgba(0, 30, 80, 0.08); border: 1px solid var(--border-color); overflow: hidden; transition: box-shadow 0.3s ease, opacity 0.3s ease; }
        details.unit-item-container:hover { box-shadow: 0 5px 15px rgba(0, 30, 80, 0.1); }
        summary.unit-summary { padding: calc(var(--spacing-unit) * 0.75) calc(var(--spacing-unit) * 1.25); font-weight: 500; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.2s ease, color 0.2s ease; flex-wrap: wrap; background-color: var(--unit-summary-bg); color: var(--text-secondary); font-size: 0.95rem; border-bottom: 1px solid transparent; }
        summary.unit-summary::-webkit-details-marker, summary.unit-summary::marker { display: none; }
        summary.unit-summary:hover { background-color: var(--unit-summary-hover-bg); }
        details.unit-item-container[open] > summary.unit-summary { background-color: var(--unit-summary-open-bg); color: white; border-bottom-color: var(--unit-summary-open-border); }
        details.unit-item-container[open] > summary.unit-summary .unit-icon, details.unit-item-container[open] > summary.unit-summary .toggler-icon, details.unit-item-container[open] > summary.unit-summary .edit-btn, details.unit-item-container[open] > summary.unit-summary .activation-btn, details.unit-item-container[open] > summary.unit-summary .subscription-badge, details.unit-item-container[open] > summary.unit-summary .unit-name-display, details.unit-item-container[open] > summary.unit-summary .unit-summary-subscription-info, details.unit-item-container[open] > summary.unit-summary .unit-summary-subscription-info .summary-subscribed-date, details.unit-item-container[open] > summary.unit-summary .unit-summary-subscription-info .summary-expires-date, details.unit-item-container[open] > summary.unit-summary .unit-summary-subscription-info .summary-status-text { color: white; }
        .unit-summary-subscription-info { font-size: 0.8em; margin-left: 0.75rem; color: var(--text-muted); white-space: nowrap; flex-basis: 100%; text-align: left; margin-top: 0.25rem; }
        .summary-content-wrapper > .unit-name-display + .unit-summary-subscription-info { flex-basis: auto; margin-left: 0.75rem; margin-top: 0; }
        details.unit-item-container[open] > summary.unit-summary .edit-btn, details.unit-item-container[open] > summary.unit-summary .activation-btn { border-color: rgba(255,255,255,0.6); background-color: rgba(255,255,255,0.1); }
        details.unit-item-container[open] > summary.unit-summary .edit-btn:hover, details.unit-item-container[open] > summary.unit-summary .activation-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; }
        .unit-icon { font-size: 1.1em; color: var(--text-muted); } 
        .summary-content-wrapper .entity-logo-display[style*="display: block"] + .unit-icon, .summary-content-wrapper .entity-logo-display[style*="display: inline-block"] + .unit-icon, .summary-content-wrapper .entity-logo-display[style*="display: flex"] + .unit-icon { display: none !important; }
        .unit-details-content-wrapper { padding: calc(var(--spacing-unit) * 1.25); border-top: 1px solid var(--border-color); background-color: var(--container-bg); }

        .unit-active-features { margin-top: 0.75rem; margin-bottom: 0.75rem; padding: 0.75rem; background-color: #f8f9fa; border-radius: var(--border-radius); border-left: 3px solid var(--info-color); font-size: 0.85rem; }
        .unit-active-features strong { display: block; margin-bottom: 0.5rem; color: var(--text-primary); font-weight: 600; font-size: 0.9rem; }
        .unit-active-features .active-features-list { list-style: none; padding-left: 0; margin-top: 0; color: var(--text-secondary); }
        .unit-active-features .active-features-list li { padding: 0.3rem 0; display: flex; align-items: flex-start; border-bottom: 1px solid #eef1f5; }
        .unit-active-features .active-features-list li:last-child { border-bottom: none; }
        .unit-active-features .active-features-list li::before { content: "\f00c"; font-family: "Font Awesome 6 Free"; font-weight: 900; color: var(--success-color); margin-right: 0.6em; font-size: 0.9em; padding-top: 0.15em; flex-shrink: 0; }

        .subscription-badge { font-size: 0.7rem; padding: 0.2em 0.5em; border-radius: 0.25rem; color: white; font-weight: bold; text-transform: uppercase; white-space: nowrap; align-self: center; margin-left: 0.5rem; } 
        details.unit-item-container summary.unit-summary .summary-actions .subscription-badge { margin-right: calc(var(--spacing-unit) * 0.25); margin-left: 0; }
        .badge-trial { background-color: var(--trial-color); } .badge-basic { background-color: var(--basic-color); } .badge-pro { background-color: var(--pro-color); } .badge-ultrapro { background-color: var(--ultra-pro-color); } .badge-expired { background-color: var(--text-muted); } .badge-pending-approval { background-color: var(--pending-color); color: white; } 
        .unit-subscription-info { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.75rem; border-top: 1px dashed #eee; border-bottom: 1px dashed #eee; padding: 0.5rem 0; } 
        .unit-subscription-info > div { margin-bottom: 0.25rem; } .unit-subscription-info strong { font-weight: 500; color: var(--text-primary); } 
        .days-left-expiry-soon { color: var(--warning-color-hover, #c69500); font-weight: bold; } .days-left-expired { color: var(--danger-color); font-weight: bold; } 
        .activation-requested-text { font-size: 0.75rem; color: var(--info-color); margin-top: 0.25rem; font-style: italic;} 
        
        .unit-contact-details { font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; display: flex; flex-wrap: wrap; gap: calc(var(--spacing-unit) * 0.5) calc(var(--spacing-unit) * 0.75); align-items: flex-start; margin-bottom: 0.75rem; }
        .unit-contact-details > div[data-field] { display: flex; align-items: flex-start; flex: 1 1 auto; min-width: 180px; word-break: break-word; margin-bottom: 0; }
        .unit-contact-details span.detail-icon { font-size: 0.9em; margin-right: 0.4em; flex-shrink: 0; padding-top: 0.15em; width: 1.2em; text-align: center; } 
        .unit-contact-details a.value-display { color: var(--accent-color); text-decoration: none; } 
        .unit-contact-details a.value-display:hover { text-decoration: underline; color: var(--accent-color-darker); }
        
        .action-button, .edit-btn, .unit-action-btn { padding: 0.3rem 0.75rem; font-size: 0.8rem; font-weight: 500; line-height: 1.2; border-radius: calc(var(--border-radius) * 0.75); margin-top: 0; box-shadow: none; text-decoration: none; white-space: nowrap; transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease; cursor: pointer; display: inline-flex; align-items: center; border: 1px solid transparent; }
        .action-button:hover, .edit-btn:hover, .unit-action-btn:hover { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .action-button > span, .edit-btn > span, .unit-action-btn > span { display: inline-block; } .action-button .btn-icon, .edit-btn .btn-icon, .unit-action-btn .btn-icon { margin-right: 0.3em; } 
        .edit-btn { background-color: transparent; border-color: var(--warning-color); color: var(--warning-color); } 
        .edit-btn:hover { background-color: var(--warning-color); color: white !important; } 
        details.corporate-entity:not([open]) > summary.entity-summary .summary-action-btn.add-regional { color: var(--success-color); border-color: var(--success-color); background-color: transparent; } 
        details.corporate-entity:not([open]) > summary.entity-summary .summary-action-btn.add-regional:hover { background-color: var(--success-color); color: white; } 
        details.regional-office:not([open]) > summary.entity-summary .summary-action-btn.add-unit { color: var(--info-color); border-color: var(--info-color); background-color: transparent; } 
        details.regional-office:not([open]) > summary.entity-summary .summary-action-btn.add-unit:hover { background-color: var(--info-color); color: white; } 
        details[open] > summary.entity-summary .edit-btn, details[open] > summary.unit-summary .edit-btn,
        details[open] > summary.entity-summary .summary-action-btn { border-color: rgba(255,255,255,0.6); color: white; background-color: rgba(255,255,255,0.1); } 
        details[open] > summary.entity-summary .edit-btn:hover, details[open] > summary.unit-summary .edit-btn:hover,
        details[open] > summary.entity-summary .summary-action-btn:hover { background-color: rgba(255,255,255,0.2); border-color: white; } 
        
        .activation-btn.active-state { border-color: var(--success-color); color: var(--success-color); background-color: transparent; } 
        .activation-btn.active-state:hover { background-color: var(--success-color); color: white !important; } 
        .activation-btn.inactive-state { border-color: var(--danger-color); color: var(--danger-color); background-color: transparent; } 
        .activation-btn.inactive-state:hover { background-color: var(--danger-color); color: white !important; } 
        details[open] > summary.entity-summary .activation-btn, details[open] > summary.unit-summary .activation-btn { border-color: rgba(255,255,255,0.6); color: white; background-color: rgba(255,255,255,0.1); } 
        details[open] > summary.entity-summary .activation-btn.active-state:hover, details[open] > summary.unit-summary .activation-btn.active-state:hover { background-color: rgba(40, 167, 69, 0.5); border-color: white; } 
        details[open] > summary.entity-summary .activation-btn.inactive-state:hover, details[open] > summary.unit-summary .activation-btn.inactive-state:hover { background-color: rgba(220, 53, 69, 0.5); border-color: white; }

        .unit-item-actions-bar-secondary { display: flex; flex-wrap: wrap; gap: calc(var(--spacing-unit) * 0.5); align-items: center; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #eee; }
        .unit-subscription-choice-group { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .unit-subscription-choice-group label { display: inline-flex; align-items: center; padding: 0.3rem 0.6rem; font-size: 0.75rem; font-weight: 500; border: 1px solid var(--border-color); border-radius: var(--border-radius); cursor: pointer; transition: background-color 0.2s, color 0.2s, border-color 0.2s; background-color: #f8f9fa; color: var(--text-secondary); }
        .unit-subscription-choice-group input[type="radio"] { opacity: 0; position: fixed; width: 0; }
        .unit-subscription-choice-group input[type="radio"]:checked + label { color: white; font-weight: bold; }
        .unit-subscription-choice-group input[type="radio"][value="free_trial"]:checked + label { background-color: var(--trial-color); border-color: var(--trial-color); }
        .unit-subscription-choice-group input[type="radio"][value="basic"]:checked + label { background-color: var(--basic-color); border-color: var(--basic-color); }
        .unit-subscription-choice-group input[type="radio"][value="pro"]:checked + label { background-color: var(--pro-color); border-color: var(--pro-color); }
        .unit-subscription-choice-group input[type="radio"][value="ultra_pro"]:checked + label { background-color: var(--ultra-pro-color); border-color: var(--ultra-pro-color); }
        .unit-subscription-choice-group label:hover { background-color: #e9ecef; border-color: var(--accent-color); }
        .unit-subscription-choice-group input[type="radio"]:disabled + label { cursor: not-allowed; opacity: 0.6; background-color: #e9ecef; }

        .unit-action-btn.renew { border-color: var(--pro-color); color: var(--pro-color); } .unit-action-btn.renew:hover { background-color: var(--pro-color); color: white !important; } 
        .unit-action-btn.upgrade { border-color: var(--trial-color); color: var(--trial-color); } .unit-action-btn.upgrade:hover { background-color: var(--trial-color); color: white !important; } 
        .unit-action-btn.approve { border-color: var(--success-color); color: var(--success-color); } .unit-action-btn.approve:hover { background-color: var(--success-color); color: white !important; } 
        .unit-action-btn.request-activation { border-color: var(--info-color); color: var(--info-color); } .unit-action-btn.request-activation:hover { background-color: var(--info-color); color: white !important; } 
        .entity-count { font-size: 0.75rem; color: var(--text-muted); margin-right: calc(var(--spacing-unit) * 0.25); padding: 0.2rem 0.4rem; border: 1px solid var(--border-color); border-radius: calc(var(--border-radius) * 0.5); background-color: #f8f9fa; white-space: nowrap; line-height: 1.2; align-self: center; } 
        details[open] > summary.entity-summary .entity-count { color: white; border-color: rgba(255,255,255,0.4); background-color: rgba(255,255,255,0.1); }
        
        details.entity-level[data-status="inactive"] > summary.entity-summary { opacity: 0.75; background-image: repeating-linear-gradient( -45deg, transparent, transparent 4px, rgba(0,0,0,0.02) 4px, rgba(0,0,0,0.02) 8px ); } 
        details.corporate-entity[data-status="inactive"] > summary.entity-summary { background-color: #e0e0e0; } 
        details.regional-office[data-status="inactive"] > summary.entity-summary { background-color: var(--unit-summary-inactive-bg); } 
        details.entity-level[data-status="inactive"] > summary.entity-summary .entity-name-display { text-decoration: line-through; color: var(--text-muted) !important; } 
        details.entity-level[data-status="inactive"] .entity-content-wrapper { opacity: 0.6; pointer-events: none; } 
        details.entity-level[data-status="inactive"][open] > summary.entity-summary { color: var(--text-secondary) !important; } 
        details.corporate-entity[data-status="inactive"][open] > summary.entity-summary { background-color: #d0d0d0 !important; } 
        details.regional-office[data-status="inactive"][open] > summary.entity-summary { background-color: #dadada !important; } 
        details.entity-level[data-status="inactive"][open] > summary.entity-summary .entity-icon, details.entity-level[data-status="inactive"][open] > summary.entity-summary .toggler-icon, details.entity-level[data-status="inactive"][open] > summary.entity-summary .summary-action-btn, details.entity-level[data-status="inactive"][open] > summary.entity-summary .edit-btn, details.entity-level[data-status="inactive"][open] > summary.entity-summary .activation-btn, details.entity-level[data-status="inactive"][open] > summary.entity-summary .entity-count { color: var(--text-secondary) !important; opacity: 0.7; border-color: rgba(0,0,0,0.2) !important; } 
        details.entity-level[data-status="inactive"][open] > summary.entity-summary .summary-action-btn:hover, details.entity-level[data-status="inactive"][open] > summary.entity-summary .edit-btn:hover, details.entity-level[data-status="inactive"][open] > summary.entity-summary .activation-btn:hover { background-color: rgba(0,0,0,0.05) !important; }

        details.unit-item-container[data-status="inactive"] > summary.unit-summary { background-color: var(--unit-summary-inactive-bg) !important; opacity: 0.75; background-image: repeating-linear-gradient( -45deg, transparent, transparent 4px, rgba(0,0,0,0.02) 4px, rgba(0,0,0,0.02) 8px ); }
        details.unit-item-container[data-status="inactive"] > summary.unit-summary .unit-summary-subscription-info { display: none !important; }
        details.unit-item-container[data-status="inactive"][open] > summary.unit-summary { background-color: var(--unit-summary-inactive-open-bg) !important; color: var(--text-secondary) !important; }
        details.unit-item-container[data-status="inactive"] > summary.unit-summary .unit-name-display { text-decoration: line-through; color: var(--text-muted) !important; }
        details.unit-item-container[data-status="inactive"] .unit-details-content-wrapper { opacity: 0.6; pointer-events: none; }
        details.unit-item-container[data-status="inactive"] .unit-details-content-wrapper .unit-subscription-info, details.unit-item-container[data-status="inactive"] .unit-details-content-wrapper .unit-active-features, details.unit-item-container[data-status="inactive"] .unit-details-content-wrapper .unit-item-actions-bar-secondary { display: none !important; }
        details.unit-item-container[data-status="inactive"][open] > summary.unit-summary .unit-icon, details.unit-item-container[data-status="inactive"][open] > summary.unit-summary .toggler-icon, details.unit-item-container[data-status="inactive"][open] > summary.unit-summary .edit-btn, details.unit-item-container[data-status="inactive"][open] > summary.unit-summary .activation-btn { color: var(--text-secondary) !important; opacity: 0.7; border-color: rgba(0,0,0,0.2) !important; }
        details.unit-item-container[data-status="inactive"][open] > summary.unit-summary .edit-btn:hover, details.unit-item-container[data-status="inactive"][open] > summary.unit-summary .activation-btn:hover { background-color: rgba(0,0,0,0.05) !important; }

        details.unit-item-container[data-status="pending-approval"] > summary.unit-summary { background-color: #eef2f7 !important; border-left: 4px solid var(--pending-color); opacity: 0.9; }
        details.unit-item-container[data-status="pending-approval"] > summary.unit-summary .unit-summary-subscription-info { display: none !important; }
        details.unit-item-container[data-status="pending-approval"] > summary.unit-summary .unit-name-display { color: var(--pending-color) !important; }
        details.unit-item-container[data-status="pending-approval"] .unit-details-content-wrapper .unit-subscription-info, details.unit-item-container[data-status="pending-approval"] .unit-details-content-wrapper .unit-active-features, details.unit-item-container[data-status="pending-approval"] .unit-details-content-wrapper .unit-item-actions-bar-secondary { display: none !important; }

        details.unit-item-container[data-status="active"][data-effective-status="inactive"] > summary.unit-summary { background-color: #ffebee !important; border-left: 4px solid var(--danger-color); opacity: 0.85; }
        details.unit-item-container[data-status="active"][data-effective-status="inactive"] > summary.unit-summary .unit-name-display { color: var(--danger-color) !important; }
        details.unit-item-container[data-status="active"][data-effective-status="inactive"] .unit-details-content-wrapper .unit-contact-details, details.unit-item-container[data-status="active"][data-effective-status="inactive"] .unit-details-content-wrapper .unit-subscription-info { opacity: 0.8; }
        details.unit-item-container[data-status="active"][data-effective-status="expiry-soon"] > summary.unit-summary { background-color: #fffde7 !important; border-left: 4px solid var(--warning-color); }
        details.unit-item-container[data-status="active"][data-effective-status="expiry-soon"] > summary.unit-summary .unit-name-display { color: var(--warning-color-hover) !important; }

        details:not([open]) > summary.entity-summary .summary-action-btn > span { color: inherit; } 
        details[open] > summary.entity-summary .summary-action-btn > span, details[open] > summary.entity-summary .edit-btn > span, details[open] > summary.entity-summary .activation-btn > span,
        details[open] > summary.unit-summary .edit-btn > span, details[open] > summary.unit-summary .activation-btn > span { color: white; }
        
        .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: var(--modal-bg); } .modal-content { background-color: var(--modal-content-bg); margin: 5% auto; padding: calc(var(--spacing-unit) * 1.5); border: 1px solid var(--border-color); width: 80%; max-width: 650px; border-radius: var(--border-radius); box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative; } .modal-content[style*="max-width: 700px;"] { max-width: 750px !important; } .modal-content[style*="max-width: 450px;"] { max-width: 450px !important; } .modal-header { padding-bottom: var(--spacing-unit); border-bottom: 1px solid var(--border-color); margin-bottom: var(--spacing-unit); } .modal-header h2 { margin: 0; font-size: 1.5rem; color: var(--text-primary); font-weight: 600; } .close-btn { color: #aaa; position: absolute; top: calc(var(--spacing-unit) * 0.75); right: calc(var(--spacing-unit) * 1); font-size: 28px; font-weight: bold; line-height: 1; } .close-btn:hover, .close-btn:focus { color: black; text-decoration: none; cursor: pointer; } .modal-body .form-group { margin-bottom: var(--spacing-unit); } .modal-body label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text-secondary); }
        .modal-body input[type="text"], .modal-body input[type="email"], .modal-body input[type="tel"], .modal-body input[type="date"], .modal-body textarea, .modal-body select, .modal-body input[type="file"].form-control { width: 100%; padding: 0.5rem 0.75rem; font-size: 1rem; line-height: 1.5; color: var(--text-primary); background-color: #fff; background-clip: padding-box; border: 1px solid var(--input-border-color); border-radius: var(--border-radius); transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        .modal-body input[type="text"]:focus, .modal-body input[type="email"]:focus, .modal-body input[type="tel"]:focus, .modal-body input[type="date"]:focus, .modal-body textarea:focus, .modal-body select:focus, .modal-body input[type="file"].form-control:focus { border-color: var(--input-focus-border-color); outline: 0; box-shadow: var(--input-focus-box-shadow); }
        .modal-body select { appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px 12px; } .modal-body textarea { min-height: 80px; resize: vertical; } .modal-body .subscription-fields { border-top: 1px solid var(--border-color); margin-top: var(--spacing-unit); padding-top: var(--spacing-unit); } .modal-footer { padding-top: var(--spacing-unit); border-top: 1px solid var(--border-color); margin-top: var(--spacing-unit); text-align: right; } .modal-footer .btn { padding: 0.625rem 1.25rem; font-size: 1rem; font-weight: 500; border-radius: var(--border-radius); cursor: pointer; text-decoration: none; border: none; margin-left: 0.5rem; } .modal-footer .btn-primary { background-color: var(--accent-color); color: white; } .modal-footer .btn-primary:hover { background-color: var(--accent-color-hover); } .modal-footer .btn-secondary { background-color: var(--text-muted); color: white; } .modal-footer .btn-secondary:hover { background-color: var(--text-secondary); } .logo-upload-container { display: flex; flex-direction: column; align-items: flex-start; } .logo-upload-container img { object-fit: contain; background-color: #f8f9fa; border: 1px solid var(--input-border-color); border-radius: var(--border-radius); margin-bottom: 10px; } .logo-upload-container input[type="file"] { margin-top: 5px; } .logo-upload-container .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; border-radius: 0.2rem; } .logo-upload-container .btn-outline-danger { color: var(--danger-color); border-color: var(--danger-color); background-color: transparent; } .logo-upload-container .btn-outline-danger:hover { color: #fff; background-color: var(--danger-color); border-color: var(--danger-color); } .entity-logo-display { border: 1px solid var(--border-color); background-color: #fff; object-fit: contain; align-self: center; flex-shrink: 0; } .summary-content-wrapper .entity-logo-display[style*="display: block"] + .entity-icon, .summary-content-wrapper .entity-logo-display[style*="display: inline-block"] + .entity-icon, .summary-content-wrapper .entity-logo-display[style*="display: flex"] + .entity-icon { display: none !important; } 
        details.entity-level[open] > summary.entity-summary .entity-logo-display, details.unit-item-container[open] > summary.unit-summary .entity-logo-display { border-color: rgba(255,255,255,0.5); }
        .btn-icon-action { background: none; border: none; cursor: pointer; font-size: 1.1em; padding: 0.2rem; color: var(--text-muted); line-height: 1; }

        @media (max-width: 768px) { 
            .app-header h1 { font-size: 1.5rem; } 
            .main-content-area { padding: var(--spacing-unit); } 
            .action-group button:not(.btn-icon-action), .button-pair button { font-size: 0.9rem; padding: 0.6rem 1.2rem; width: 100%; } 
            .button-pair { flex-direction: column;} 
            .entity-details-grid { grid-template-columns: 1fr; } 
            summary.entity-summary, summary.unit-summary { padding: calc(var(--spacing-unit) * 0.75) var(--spacing-unit); } 
            .entity-description { padding: 0.6rem calc(var(--spacing-unit) * 0.75); } 
            .action-button, .edit-btn, .unit-action-btn { padding: 0.25rem 0.5rem; font-size: 0.75rem; } 
            .entity-count { font-size: 0.7rem; padding: 0.15rem 0.3rem; margin-right: calc(var(--spacing-unit) * 0.3); } 
            .summary-actions { gap: calc(var(--spacing-unit) * 0.3); } 
            .modal-content { margin: 5% auto; width: 90%; } 
            .subscription-badge { font-size: 0.65rem; } 
            .unit-subscription-info { font-size: 0.75rem; } 
            .filter-grid { grid-template-columns: 1fr; }
            .unit-summary-subscription-info { font-size: 0.75em; }
            .unit-contact-details > div[data-field] { min-width: 160px; }
        }
        @media (max-width: 600px) { 
            .unit-summary-subscription-info { flex-basis: 100%; margin-left: 0; margin-top: 0.25rem; text-align: left; white-space: normal; }
            .unit-contact-details { gap: calc(var(--spacing-unit) * 0.3) calc(var(--spacing-unit) * 0.75); }
            .unit-contact-details > div[data-field] { min-width: calc(50% - var(--spacing-unit) * 0.375); }
        }
        @media (max-width: 480px) { 
            .summary-actions .edit-btn > span, .summary-actions .summary-action-btn > span, .summary-actions .activation-btn > span,
            summary.unit-summary .summary-actions .edit-btn > span, summary.unit-summary .summary-actions .activation-btn > span { display: none; } 
            .summary-actions .edit-btn .btn-icon, .summary-actions .summary-action-btn .btn-icon, .summary-actions .activation-btn .btn-icon,
            summary.unit-summary .summary-actions .edit-btn .btn-icon, summary.unit-summary .summary-actions .activation-btn .btn-icon { margin-right:0; } 
            .action-button, .edit-btn, .unit-action-btn, .summary-actions .activation-btn { padding: 0.3rem 0.5rem; } 
            .entity-count { font-size: 0.65rem; padding: 0.1rem 0.25rem; margin-right: calc(var(--spacing-unit) * 0.2); } 
            .entity-count .count-label { display: none; }
            .summary-content-wrapper .entity-logo-display { align-self: flex-start; margin-bottom: 0.25rem; } 
            .summary-actions .subscription-badge { align-self: flex-start; margin-bottom: 0.5rem; } 
            .scoped-upload-section { flex-direction: column; align-items: stretch; } .scoped-upload-section h4 { margin-bottom: calc(var(--spacing-unit) * 0.5); text-align: center;} .scoped-upload-section .button-pair { flex-direction: column; }
            .unit-item-actions-bar-secondary { flex-direction: column; align-items: stretch;}
            .unit-item-actions-bar-secondary .unit-action-btn.renew { margin-top: 0.5rem; text-align:center;}
            .unit-summary-subscription-info { font-size: 0.7em; }
            .unit-contact-details > div[data-field] { min-width: 100%; }
        }
        
       
    </style>

@section('content')



 <header class="app-header"> <h1>Corporate Structure Management</h1> </header>
    <main class="main-content-area" id="mainContentArea">
        <div class="filters-container">
            <h3>Filter View</h3>
            <div class="filter-grid">
                <div class="form-group"> <label for="filterCorporate">Corporate Entity:</label> <select id="filterCorporate" class="form-control"> <option value="all">All Corporates</option> </select> </div>
                <div class="form-group"> <label for="filterRegional">Regional Office:</label> <select id="filterRegional" class="form-control"> <option value="all">All Regionals</option> </select> </div>
                <div class="form-group"> <label for="filterUnit">Search Units (by Name):</label> <input type="text" id="filterUnit" class="form-control" placeholder="Enter unit name..."> </div>
                <div class="form-group filter-actions"> <button type="button" id="clearFiltersButton" class="btn btn-secondary">Clear Filters</button> </div>
            </div>
        </div>
<?php  $is_role = Auth::user()->is_role; ?>

<details class="super-admin-dashboard-details">
            <summary class="super-admin-dashboard-summary">
                <div class="summary-content-wrapper"> <span class="entity-icon">📊</span> <span class="entity-name-display">Super Admin Dashboard</span> </div>
                <div class="summary-actions" id="superAdminDashboardStatsContainer"> <span class="entity-count"><span class="count-label">Total Corporates: </span><strong id="dashStatTotalCorporates">1</strong></span> <span class="entity-count"><span class="count-label">Total Regionals: </span><strong id="dashStatTotalRegionals">1</strong></span> <span class="entity-count"><span class="count-label">Total Units: </span><strong id="dashStatTotalUnits">5</strong></span> <span class="entity-count"><span class="count-label">Active Units: </span><strong id="dashStatActiveUnits">2</strong></span> <span class="entity-count"><span class="count-label">Pending Units: </span><strong id="dashStatPendingUnits">1</strong></span> <span class="entity-count"><span class="count-label">Expired/Off Units: </span><strong id="dashStatInactiveUnits">2</strong></span> </div>
                <span class="toggler-icon">▶</span>
            </summary>
            <div class="dashboard-action-buttons-container">
                <div class="top-action-buttons-grid">
                    <div class="action-group manual-entry"> <h3>Manual / Detailed Entry</h3> <button type="button" id="addCorporateEntityButton" data-bs-toggle="modal" data-bs-target="#addcompanydetails">➕ Add Corporate Entity</button> </div>
                    <div class="action-group super-admin-csv"> <h3>Super Admin - Bulk Upload Full Structure (CSV)</h3> <div class="button-pair"> <button type="button" id="downloadFullSampleCsvButton" onclick="downloadFullSampleCsv()">📄 Full Sample CSV</button> <button type="button" id="uploadFullCsvButton" onclick="openSuperAdminCsvUploadModal()">⬆️ Upload Full CSV</button> </div> </div>
                </div>

                <div class="feature-management-module-wrapper">
                    <style>
                        .feature-management-module-wrapper {
                            --feature-primary-color: #2563eb; --feature-primary-light: #3b82f6; --feature-secondary-color: #10b981; --feature-danger-color: #ef4444; --feature-warning-color: #f59e0b; --feature-info-color: #06b6d4; --feature-light-gray-color: #f3f4f6; --feature-medium-gray-color: #d1d5db; --feature-dark-gray-color: #6b7280; --feature-text-color: #1f2937; --feature-text-color-light: #4b5563; --feature-background-color: #f9fafb; --feature-white-color: #ffffff; --feature-border-radius: 8px; --feature-box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); --feature-box-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); --feature-transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); --feature-main-feature-row-bg: #eef2ff; --feature-main-feature-row-hover-bg: #e0e7ff; 
                        }
                        .feature-management-module-wrapper *, .feature-management-module-wrapper *::before, .feature-management-module-wrapper *::after { box-sizing: border-box; }
                        .feature-management-content-area { font-family: var(--font-family-sans-serif); background-color: var(--feature-white-color); padding: 30px 40px; border-radius: var(--feature-border-radius); box-shadow: var(--feature-box-shadow); margin-top: calc(var(--spacing-unit) * 1.5); color: var(--feature-text-color); line-height: 1.6; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
                        .feature-management-module-wrapper .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--feature-light-gray-color); flex-shrink: 0; }
                        .feature-management-module-wrapper .section-header h2 { color: var(--feature-text-color); font-weight: 600; margin: 0; font-size: 1.6em; display: flex; align-items: center; gap: 10px; }
                        .feature-management-module-wrapper .btn { padding: 10px 18px; border: none; border-radius: var(--feature-border-radius); cursor: pointer; font-size: 0.95em; font-weight: 500; transition: var(--feature-transition); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; }
                        .feature-management-module-wrapper .btn:disabled { background-color: var(--feature-medium-gray-color) !important; color: var(--feature-dark-gray-color) !important; cursor: not-allowed; box-shadow: none; transform: none; }
                        .feature-management-module-wrapper .btn:disabled:hover { box-shadow: none; transform: none; }
                        .feature-management-module-wrapper .btn:hover { box-shadow: var(--feature-box-shadow-hover); transform: translateY(-1px); }
                        .feature-management-module-wrapper .btn:active { transform: translateY(0); }
                        .feature-management-module-wrapper .btn-primary { background-color: var(--feature-primary-color); color: var(--feature-white-color); }
                        .feature-management-module-wrapper .btn-primary:hover:not(:disabled) { background-color: var(--feature-primary-light); }
                        .feature-management-module-wrapper .btn-success { background-color: var(--feature-secondary-color); color: var(--feature-white-color); }
                        .feature-management-module-wrapper .btn-success:hover:not(:disabled) { background-color: #0d9f6e; }
                        .feature-management-module-wrapper .btn-warning { background-color: var(--feature-warning-color); color: var(--feature-white-color); }
                        .feature-management-module-wrapper .btn-warning:hover:not(:disabled) { background-color: #e58a08; }
                        .feature-management-module-wrapper .btn-danger { background-color: var(--feature-danger-color); color: var(--feature-white-color); }
                        .feature-management-module-wrapper .btn-danger:hover:not(:disabled) { background-color: #dc2626; }
                        .feature-management-module-wrapper .btn-info { background-color: var(--feature-info-color); color: var(--feature-white-color); }
                        .feature-management-module-wrapper .btn-info:hover:not(:disabled) { background-color: #06a6c2; }
                        .feature-management-module-wrapper .btn-light { background-color: var(--feature-light-gray-color); color: var(--feature-text-color); border: 1px solid var(--feature-medium-gray-color); }
                        .feature-management-module-wrapper .btn-light:hover:not(:disabled) { background-color: #e5e7eb; }
                        .feature-management-module-wrapper .btn-icon { padding: 8px 10px; font-size: 0.9em; min-width: 36px; justify-content: center; }
                        .feature-management-module-wrapper .btn-sm { padding: 7px 12px; font-size: 0.85em; }
                        .feature-management-module-wrapper .table-scroll-container { overflow-y: auto; border: 1px solid var(--feature-medium-gray-color); border-radius: var(--feature-border-radius); position: relative; max-height: 600px; }
                        .feature-management-module-wrapper table { width: 100%; border-collapse: separate; border-spacing: 0; }
                        .feature-management-module-wrapper th, .feature-management-module-wrapper td { border-bottom: 1px solid var(--feature-light-gray-color); padding: 14px 16px; text-align: left; vertical-align: middle; border-right: 1px solid var(--feature-light-gray-color); }
                        .feature-management-module-wrapper th:last-child, .feature-management-module-wrapper td:last-child { border-right: none; }
                        .feature-management-module-wrapper th { background-color: #f8fafc; color: var(--feature-text-color); font-weight: 600; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px; position: sticky; top: 0; z-index: 10; }
                        .feature-management-module-wrapper tr:last-child td { border-bottom: none; }
                        .feature-management-module-wrapper tr.main-feature-row { background-color: var(--feature-main-feature-row-bg); transition: background-color 0.2s ease, opacity 0.2s ease; font-weight: 500; }
                        .feature-management-module-wrapper tr.main-feature-row:hover { background-color: var(--feature-main-feature-row-hover-bg); }
                        .feature-management-module-wrapper .expand-toggle { cursor: pointer; margin-right: 10px; color: var(--feature-primary-color); display: inline-flex; align-items: center; width: 16px; font-size: 0.9em; }
                        .feature-management-module-wrapper .expand-toggle:hover { color: var(--feature-primary-light); }
                        .feature-management-module-wrapper .feature-name-cell { display: flex; align-items: center; }
                        .feature-management-module-wrapper .sub-feature-row { background-color: var(--feature-background-color); transition: opacity 0.2s ease; }
                        .feature-management-module-wrapper .sub-feature-row td:first-child { padding-left: 40px; position: relative; }
                        .feature-management-module-wrapper .sub-feature-row td:first-child::before { content: '\f054'; font-family: "Font Awesome 6 Free"; font-weight: 900; position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--feature-primary-color); font-size: 0.8em; opacity: 0.7; }
                        .feature-management-module-wrapper .sub-feature-row:hover { background-color: #f1f5f9; }
                        .feature-management-module-wrapper .plan-checkbox { display: block; margin: 0 auto; width: 18px; height: 18px; accent-color: var(--feature-primary-color); cursor: pointer; }
                        .feature-management-module-wrapper .plan-checkbox:disabled { cursor: not-allowed; opacity: 0.7; }
                        .feature-management-module-wrapper td.plan-cell { text-align: center; vertical-align: middle; }
                        .feature-management-module-wrapper .plan-label { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.75em; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
                        .feature-management-module-wrapper .plan-free { background-color: #e0f2fe; color: #0369a1; } .feature-management-module-wrapper .plan-basic { background-color: #dcfce7; color: #166534; } .feature-management-module-wrapper .plan-pro { background-color: #fef3c7; color: #92400e; } .feature-management-module-wrapper .plan-ultra { background-color: #ede9fe; color: #5b21b6; } .feature-management-module-wrapper .org-corporate { background-color: #cffafe; color: #0891b2; } .feature-management-module-wrapper .org-regional { background-color: #ccfbf1; color: #047857; } .feature-management-module-wrapper .org-unit { background-color: #fef9c3; color: #713f12; }
                        .feature-management-module-wrapper .actions-cell { white-space: nowrap; } .feature-management-module-wrapper .actions-cell .btn { margin-right: 5px; } .feature-management-module-wrapper .actions-cell .btn:last-child { margin-right: 0; }
                        .feature-management-module-wrapper .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1060; display: flex; justify-content: center; align-items: center; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease; backdrop-filter: blur(2px); }
                        .feature-management-module-wrapper .modal-overlay.active { opacity: 1; visibility: visible; }
                        .feature-management-module-wrapper .modal { background-color: var(--feature-white-color); padding: 0; border-radius: var(--feature-border-radius); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); z-index: 1061; width: 90%; max-width: 700px; max-height: 90vh; display: flex; flex-direction: column; transform: translateY(-20px); transition: transform 0.3s ease; }
                        .feature-management-module-wrapper .modal-overlay.active .modal { transform: translateY(0); }
                        .feature-management-module-wrapper .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 25px; border-bottom: 1px solid var(--feature-light-gray-color); }
                        .feature-management-module-wrapper .modal-header h2 { margin: 0; font-size: 1.4em; font-weight: 600; color: var(--feature-text-color); display: flex; align-items: center; gap: 10px; }
                        .feature-management-module-wrapper .close-modal-btn { font-size: 1.5em; color: var(--feature-dark-gray-color); background: none; border: none; cursor: pointer; padding: 5px; line-height: 1; transition: color 0.2s ease; }
                        .feature-management-module-wrapper .close-modal-btn:hover { color: var(--feature-danger-color); }
                        .feature-management-module-wrapper .modal-body { padding: 25px; overflow-y: auto; flex-grow: 1; }
                        .feature-management-module-wrapper .form-group { margin-bottom: 20px; }
                        .feature-management-module-wrapper .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--feature-text-color-light); font-size: 0.95em; }
                        .feature-management-module-wrapper .form-control { width: 100%; padding: 12px 15px; border: 1px solid var(--feature-medium-gray-color); border-radius: var(--feature-border-radius); font-size: 1em; color: var(--feature-text-color); transition: border-color 0.2s ease, box-shadow 0.2s ease; font-family: var(--font-family-sans-serif); }
                        .feature-management-module-wrapper .form-control:focus { border-color: var(--feature-primary-color); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
                        .feature-management-module-wrapper textarea.form-control { min-height: 120px; resize: vertical; line-height: 1.5; }
                        .feature-management-module-wrapper .tier-options { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px; }
                        .feature-management-module-wrapper .tier-option { display: flex; align-items: center; }
                        .feature-management-module-wrapper .tier-option label { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: var(--feature-border-radius); cursor: pointer; transition: background-color 0.2s ease; font-weight: 500; margin: 0; }
                        .feature-management-module-wrapper .tier-option label:hover { background-color: var(--feature-light-gray-color); }
                        .feature-management-module-wrapper .tier-option input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--feature-primary-color); cursor: pointer; margin: 0; }
                        .feature-management-module-wrapper .modal-footer { padding: 20px 25px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--feature-light-gray-color); background-color: #f8fafc; border-bottom-left-radius: var(--feature-border-radius); border-bottom-right-radius: var(--feature-border-radius); }
                        .feature-management-module-wrapper .tooltip { position: relative; display: inline-block; cursor: help; } .feature-management-module-wrapper .feature-name-text { font-weight: 500; }
                        .feature-management-module-wrapper .tooltip .tooltiptext { visibility: hidden; width: 260px; background-color: #1f2937; color: #f9fafb; text-align: left; border-radius: var(--feature-border-radius); padding: 12px 16px; position: absolute; z-index: 1070; bottom: 130%; left: 50%; transform: translateX(-50%); opacity: 0; transition: opacity 0.2s ease; font-size: 0.9em; line-height: 1.5; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                        .feature-management-module-wrapper .tooltip .tooltiptext::after { content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px; border-width: 5px; border-style: solid; border-color: #1f2937 transparent transparent transparent; }
                        .feature-management-module-wrapper .tooltip:hover .tooltiptext { visibility: visible; opacity: 1; }
                        .feature-management-module-wrapper .status-indicator { display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 6px; }
                        .feature-management-module-wrapper .status-active { background-color: var(--feature-secondary-color); } .feature-management-module-wrapper .status-draft { background-color: var(--feature-warning-color); } .feature-management-module-wrapper .status-archived { background-color: var(--feature-dark-gray-color); }
                        .feature-management-module-wrapper .badge { display: inline-block; padding: 4px 8px; font-size: 0.75em; font-weight: 600; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 4px; }
                        .feature-management-module-wrapper .badge-primary { background-color: var(--feature-primary-color); color: white; } .feature-management-module-wrapper .badge-secondary { background-color: var(--feature-secondary-color); color: white; }
                        .feature-management-module-wrapper .empty-state { text-align: center; padding: 40px 20px; color: var(--feature-text-color-light); flex-grow: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; }
                        .feature-management-module-wrapper .empty-state i { font-size: 3em; color: var(--feature-medium-gray-color); margin-bottom: 15px; }
                        .feature-management-module-wrapper .empty-state h3 { font-weight: 500; margin-bottom: 10px; color: var(--feature-text-color); }
                        .feature-management-module-wrapper .empty-state p { max-width: 500px; margin: 0 auto 20px; }
                        .feature-management-module-wrapper .filter-bar { display: flex; gap: 15px; margin-bottom: 25px; flex-wrap: wrap; flex-shrink: 0; }
                        .feature-management-module-wrapper .search-box { flex: 1; min-width: 250px; position: relative; }
                        .feature-management-module-wrapper .search-box input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid var(--feature-medium-gray-color); border-radius: var(--feature-border-radius); font-size: 0.95em; transition: var(--feature-transition); }
                        .feature-management-module-wrapper .search-box input:focus { border-color: var(--feature-primary-color); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
                        .feature-management-module-wrapper .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--feature-dark-gray-color); }
                        .feature-management-module-wrapper .filter-options { display: flex; gap: 10px; align-items: center; }
                        .feature-management-module-wrapper .filter-dropdown { position: relative; }
                        .feature-management-module-wrapper .filter-dropdown select { padding: 10px 15px; border: 1px solid var(--feature-medium-gray-color); border-radius: var(--feature-border-radius); font-size: 0.95em; background-color: white; cursor: pointer; appearance: none; padding-right: 35px; }
                        .feature-management-module-wrapper .filter-dropdown::after { content: '\f078'; font-family: "Font Awesome 6 Free"; font-weight: 900; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--feature-dark-gray-color); font-size: 0.8em; }
                        @media (max-width: 1024px) { .feature-management-content-area { padding: 20px; } }
                        @media (max-width: 768px) { .feature-management-content-area { padding: 15px; } .feature-management-module-wrapper .section-header { flex-direction: column; align-items: flex-start; gap: 15px; } .feature-management-module-wrapper th, .feature-management-module-wrapper td { padding: 10px 8px; font-size: 0.9em; } .feature-management-module-wrapper .sub-feature-row td:first-child { padding-left: 30px; } .feature-management-module-wrapper .modal { width: 95%; } .feature-management-module-wrapper .filter-bar { flex-direction: column; gap: 10px; } .feature-management-module-wrapper .search-box { min-width: 100%; } .feature-management-module-wrapper .filter-options { flex-wrap: wrap; } .feature-management-module-wrapper .feature-name-cell { flex-wrap: wrap; } .feature-management-module-wrapper .expand-toggle { margin-bottom: 5px; } }
                        @media (max-width: 480px) { .feature-management-content-area { padding: 10px; } .feature-management-module-wrapper .btn { padding: 8px 12px; font-size: 0.85em; } .feature-management-module-wrapper .actions-cell { white-space: normal; } .feature-management-module-wrapper .actions-cell .btn { margin-bottom: 5px; } .feature-management-module-wrapper .modal-body { padding: 20px 15px; } .feature-management-module-wrapper .modal-footer { padding: 15px; flex-wrap: wrap; justify-content: center; } .feature-management-module-wrapper .modal-footer .btn { flex: 1; min-width: 120px; } }
                        @keyframes fm_fadeIn { from { opacity: 0; } to { opacity: 1; } } 
                        .feature-management-module-wrapper .fade-in { animation: fm_fadeIn 0.3s ease-in-out; }
                        .feature-management-module-wrapper .toast-container { position: fixed; top: 20px; right: 20px; z-index: 1100; max-width: 350px; }
                        .feature-management-module-wrapper .toast { padding: 15px 20px; border-radius: var(--feature-border-radius); color: white; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; box-shadow: var(--feature-box-shadow); transform: translateX(120%); transition: transform 0.3s ease; }
                        .feature-management-module-wrapper .toast.show { transform: translateX(0); }
                        .feature-management-module-wrapper .toast-success { background-color: var(--feature-secondary-color); } .feature-management-module-wrapper .toast-error { background-color: var(--feature-danger-color); } .feature-management-module-wrapper .toast-info { background-color: var(--feature-info-color); } .feature-management-module-wrapper .toast-warning { background-color: var(--feature-warning-color); }
                        .feature-management-module-wrapper .close-toast { margin-left: auto; background: none; border: none; color: white; cursor: pointer; opacity: 0.8; font-size: 1.2em; line-height: 1; padding: 0 5px; }
                        .feature-management-module-wrapper .close-toast:hover { opacity: 1; }
                    </style>

                    <div class="feature-management-content-area fade-in">
                        <div class="filter-bar">
                            <div class="search-box"> <i class="fas fa-search"></i> <input type="text" id="fm_searchInput" placeholder="Search features..." oninput="fm_filterFeatures()"> </div>
                            <div class="filter-options">
                                <div class="filter-dropdown"> <select id="fm_tierFilter" onchange="fm_filterFeatures()" aria-label="Filter by Tier"> <option value="">All Tiers</option> <option value="free_trial">Free Trial</option> <option value="basic">Basic</option> <option value="pro">Pro</option> <option value="ultra_pro">Ultra Pro</option> </select> </div>
                                <div class="filter-dropdown"> <select id="fm_typeFilter" onchange="fm_filterFeatures()" aria-label="Filter by Type"> <option value="">All Types</option> <option value="main">Main Features</option> <option value="sub">Sub-features</option> </select> </div>
                                <button class="btn btn-light" onclick="fm_resetFilters()"> <i class="fas fa-undo"></i> Reset </button>
                            </div>
                        </div>
                        <div class="section-header"> <h2><i class="fas fa-list-ul"></i> Subscription Feature Catalog</h2> <button id="fm_addNewMainFeatureBtn" class="btn btn-primary"> <i class="fas fa-plus"></i> Add Main Feature </button> </div>
                        <div class="table-scroll-container">
                            <table id="fm_featuresTable">
                                <thead> <tr> <th>Feature Name</th> <th>Description</th> <th class="plan-cell">Free Trial</th> <th class="plan-cell">Basic</th> <th class="plan-cell">Pro</th> <th class="plan-cell">Ultra Pro</th> <th>Actions</th> </tr> </thead>
                                <tbody id="fm_featuresTableBody"></tbody>
                            </table>
                        </div>
                        <div id="fm_emptyState" class="empty-state" style="display: none;"> <i class="fas fa-inbox"></i> <h3>No Features Found</h3> <p>Your search didn't match any features. Try adjusting your filters or add a new feature to get started.</p> <button id="fm_addNewFromEmptyBtn" class="btn btn-primary"> <i class="fas fa-plus"></i> Add New Feature </button> </div>
                    </div>
                
                    <div id="fm_featureModalOverlay" class="modal-overlay">
                        <div id="fm_featureModal" class="modal" role="dialog" aria-labelledby="fm_modalTitle" aria-modal="true">
                            <div class="modal-header"> <h2 id="fm_modalTitle"><i class="fas fa-plus-square"></i> Add New Feature</h2> <button class="close-modal-btn" id="fm_closeModalBtn" aria-label="Close modal">×</button> </div>
                            <form id="fm_featureForm" class="modal-form">
                                <div class="modal-body">
                                    <input type="hidden" id="fm_featureId" name="featureId"> <input type="hidden" id="fm_parentId" name="parentId">
                                    <div class="form-group"> <label for="fm_featureName">Feature Name</label> <input type="text" id="fm_featureName" name="featureName" class="form-control" required placeholder="e.g., Allergen Tracking, Temperature Monitoring"> </div>
                                    <div class="form-group"> <label for="fm_featureDescription">Description</label> <textarea id="fm_featureDescription" name="featureDescription" class="form-control" placeholder="Describe what this feature does, its benefits, and any important details..."></textarea> </div>
                                    <div class="form-group"> <label>Available In Subscription Tiers</label>
                                        <div class="tier-options">
                                            <div class="tier-option"><label><input type="checkbox" name="tiers" value="free_trial"> <span class="plan-label plan-free">Free Trial</span></label></div>
                                            <div class="tier-option"><label><input type="checkbox" name="tiers" value="basic"> <span class="plan-label plan-basic">Basic</span></label></div>
                                            <div class="tier-option"><label><input type="checkbox" name="tiers" value="pro"> <span class="plan-label plan-pro">Pro</span></label></div>
                                            <div class="tier-option"><label><input type="checkbox" name="tiers" value="ultra_pro"> <span class="plan-label plan-ultra">Ultra Pro</span></label></div>
                                        </div>
                                    </div>
                                    <div class="form-group"> <label>Accessible By Organizational Levels</label>
                                        <div class="tier-options" id="fm_orgLevelOptions">
                                            <div class="tier-option"><label><input type="checkbox" name="orgLevels" value="corporate"> <span class="plan-label org-corporate">Corporate</span></label></div>
                                            <div class="tier-option"><label><input type="checkbox" name="orgLevels" value="regional"> <span class="plan-label org-regional">Regional</span></label></div>
                                            <div class="tier-option"><label><input type="checkbox" name="orgLevels" value="unit"> <span class="plan-label org-unit">Unit</span></label></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer"> <button type="button" id="fm_cancelModalBtn" class="btn btn-light">Cancel</button> <button type="submit" id="fm_submitFeatureBtn" class="btn btn-success"> <i class="fas fa-check"></i> Add Feature </button> </div>
                            </form>
                        </div>
                    </div>
                    <div class="toast-container" id="fm_toastContainer" aria-live="polite" aria-atomic="true"></div>
                    <script>
                    const fm_featuresTable = document.getElementById('fm_featuresTable');
                    const fm_featuresTableBody = document.getElementById('fm_featuresTableBody');
                    const fm_addNewMainFeatureBtn = document.getElementById('fm_addNewMainFeatureBtn');
                    const fm_addNewFromEmptyBtn = document.getElementById('fm_addNewFromEmptyBtn');
                    const fm_emptyState = document.getElementById('fm_emptyState');
                    const fm_searchInput = document.getElementById('fm_searchInput');
                    const fm_tierFilter = document.getElementById('fm_tierFilter');
                    const fm_typeFilter = document.getElementById('fm_typeFilter');
                    const fm_featureModalOverlay = document.getElementById('fm_featureModalOverlay');
                    const fm_featureModal = document.getElementById('fm_featureModal');
                    const fm_modalTitle = document.getElementById('fm_modalTitle');
                    const fm_closeModalBtn = document.getElementById('fm_closeModalBtn');
                    const fm_cancelModalBtn = document.getElementById('fm_cancelModalBtn');
                    const fm_featureForm = document.getElementById('fm_featureForm');
                    const fm_featureIdInput = document.getElementById('fm_featureId');
                    const fm_parentIdInput = document.getElementById('fm_parentId'); 
                    const fm_featureNameInput = document.getElementById('fm_featureName');
                    const fm_featureDescriptionInput = document.getElementById('fm_featureDescription');
                    const fm_tierCheckboxes = fm_featureForm.querySelectorAll('input[name="tiers"]');
                    const fm_orgLevelCheckboxes = fm_featureForm.querySelectorAll('input[name="orgLevels"]');
                    const fm_submitFeatureBtn = document.getElementById('fm_submitFeatureBtn');
                    const fm_toastContainer = document.getElementById('fm_toastContainer');
            
                    let fm_editingFeatureId = null, fm_currentParentIdForSubFeature = null, fm_modalTriggerElement = null;
                    let fm_currentSimulatedUserLevel = 'corporate'; 
                    let fm_featuresData = [ 
                        { id: 1, name: "HACCP Plan Management", description: "Comprehensive HACCP plan creation, CCP monitoring, and corrective action workflows.", tiers: ["pro", "ultra_pro"], isExpanded: false, allowedLevels: ['corporate', 'regional', 'unit'], subFeatures: [ { id: 101, parentId: 1, name: "HACCP Plan Builder", description: "Interactive tool to create and manage digital HACCP plans compliant with regulations.", tiers: ["pro", "ultra_pro"], allowedLevels: ['corporate', 'regional'] }, { id: 102, parentId: 1, name: "CCP Monitoring Setup", description: "Define critical control points, set limits, and schedule monitoring tasks.", tiers: ["pro", "ultra_pro"], allowedLevels: ['corporate', 'regional', 'unit'] }, { id: 103, parentId: 1, name: "Corrective Actions", description: "Automated workflows for documenting and resolving deviations from critical limits.", tiers: ["ultra_pro"], allowedLevels: ['corporate', 'regional', 'unit'] } ] },
                        { id: 2, name: "Temperature Monitoring", description: "Automated and manual temperature logging for refrigerators, freezers, and cooking processes with alert notifications.", tiers: ["basic", "pro", "ultra_pro"], isExpanded: false, allowedLevels: ['corporate', 'regional', 'unit'], subFeatures: [ { id: 201, parentId: 2, name: "Smart Sensor Integration", description: "Connect Bluetooth/WiFi temperature sensors for continuous monitoring.", tiers: ["pro", "ultra_pro"], allowedLevels: ['unit'] }, { id: 202, parentId: 2, name: "Manual Logging", description: "Record temperature checks with timestamps and user identification.", tiers: ["basic", "pro", "ultra_pro"], allowedLevels: ['unit'] } ] },
                        { id: 3, name: "Supplier Compliance", description: "Track supplier certifications, audit results, and manage approval status. Includes document storage.", tiers: ["ultra_pro"], isExpanded: false, allowedLevels: ['corporate'], subFeatures: [] },
                        { id: 4, name: "Training Management", description: "Assign and track employee training completion for food safety courses and internal procedures.", tiers: ["pro", "ultra_pro"], isExpanded: false, allowedLevels: ['corporate', 'regional'], subFeatures: [ { id: 401, parentId: 4, name: "Course Library", description: "Pre-built food safety training courses and materials.", tiers: ["pro", "ultra_pro"], allowedLevels: ['corporate', 'regional'] }, { id: 402, parentId: 4, name: "Custom Training", description: "Create and assign your own training materials and procedures.", tiers: ["ultra_pro"], allowedLevels: ['corporate'] } ] },
                        { id: 5, name: "Audit Management", description: "Schedule, conduct, and document internal and external food safety audits.", tiers: ["pro", "ultra_pro"], isExpanded: false, allowedLevels: ['corporate', 'regional', 'unit'], subFeatures: [] },
                        { id: 6, name: "Allergen Control", description: "Tools to manage allergen information, prevent cross-contamination, and generate allergen statements.", tiers: ["basic", "pro", "ultra_pro"], isExpanded: false, allowedLevels: ['unit'], subFeatures: [] },
                        { id: 7, name: "Basic Reporting", description: "Access to standard, pre-defined reports.", tiers: ["free_trial", "basic"], isExpanded: false, allowedLevels: ['unit'], subFeatures: [] }
                    ];
                    let fm_nextId = 403; 
            
                    function fm_getNextId() { let maxId = 0; fm_featuresData.forEach(f => { if (f.id > maxId) maxId = f.id; if (f.subFeatures) { f.subFeatures.forEach(sf => { if (sf.id > maxId) maxId = sf.id; }); } }); fm_nextId = Math.max(fm_nextId, maxId + 1); return fm_nextId++; }
                    function fm_showToast(message, type = 'success') { const toast = document.createElement('div'); toast.className = `toast toast-${type}`; toast.setAttribute('role', type === 'error' || type === 'warning' ? 'alert' : 'status'); toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i><span>${message}</span><button class="close-toast" aria-label="Close notification">×</button>`; fm_toastContainer.appendChild(toast); setTimeout(() => toast.classList.add('show'), 10); toast.querySelector('.close-toast').addEventListener('click', () => fm_hideToast(toast)); setTimeout(() => fm_hideToast(toast), 5000); }
                    function fm_hideToast(toast) { toast.classList.remove('show'); setTimeout(() => { if (toast.parentElement) toast.remove(); }, 300); }
                    function fm_findFeature(id, parentId = null) { id = parseInt(id); if (parentId) { parentId = parseInt(parentId); const parent = fm_featuresData.find(f => f.id === parentId); return parent ? parent.subFeatures.find(sf => sf.id === id) : null; } return fm_featuresData.find(f => f.id === id); }
                    function fm_toggleExpand(featureId) { const mainFeature = fm_featuresData.find(f => f.id === featureId); if (mainFeature) { mainFeature.isExpanded = !mainFeature.isExpanded; fm_filterFeatures(); }}
            
                    function fm_renderFeatures(featuresToRender = fm_featuresData) {
                        fm_featuresTableBody.innerHTML = '';
                        const displayFeatures = featuresToRender || fm_featuresData;
                        if (!displayFeatures || displayFeatures.length === 0) { fm_emptyState.style.display = 'flex'; fm_featuresTable.style.display = 'none'; document.querySelector('.feature-management-module-wrapper .table-scroll-container').style.display = 'none'; return; }
                        fm_emptyState.style.display = 'none'; fm_featuresTable.style.display = ''; document.querySelector('.feature-management-module-wrapper .table-scroll-container').style.display = 'block';
                        let hasVisibleRows = false;
                        displayFeatures.forEach(feature => {
                            if (!feature) return; hasVisibleRows = true;
                            const isMainAllowed = feature.allowedLevels && feature.allowedLevels.includes(fm_currentSimulatedUserLevel);
                            const mainFeatureRow = document.createElement('tr'); mainFeatureRow.className = 'main-feature-row'; if (!isMainAllowed) mainFeatureRow.style.opacity = "0.65"; mainFeatureRow.dataset.featureId = feature.id;
                            mainFeatureRow.innerHTML = `
                                <td class="feature-name-cell">
                                    <span class="expand-toggle" onclick="fm_toggleExpand(${feature.id})" role="button" tabindex="0" aria-expanded="${feature.isExpanded === true}" aria-label="${feature.isExpanded ? 'Collapse' : 'Expand'} ${feature.name} sub-features"><i class="fas ${feature.isExpanded ? 'fa-chevron-down' : 'fa-chevron-right'}"></i></span>
                                    <span class="feature-name-text">${feature.name}</span><span class="badge badge-primary" style="margin-left: 8px;">Main</span>
                                </td>
                                <td><div class="tooltip"><span>${feature.description.substring(0, 60)}${feature.description.length > 60 ? '...' : ''}</span><span class="tooltiptext">${feature.description}</span></div></td>
                                <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${feature.tiers.includes('free_trial') ? 'checked' : ''} ${!isMainAllowed ? 'disabled' : ''} aria-label="${feature.name} available in Free Trial" onchange="fm_updateFeatureTier(${feature.id}, null, 'free_trial', this.checked)"></td>
                                <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${feature.tiers.includes('basic') ? 'checked' : ''} ${!isMainAllowed ? 'disabled' : ''} aria-label="${feature.name} available in Basic" onchange="fm_updateFeatureTier(${feature.id}, null, 'basic', this.checked)"></td>
                                <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${feature.tiers.includes('pro') ? 'checked' : ''} ${!isMainAllowed ? 'disabled' : ''} aria-label="${feature.name} available in Pro" onchange="fm_updateFeatureTier(${feature.id}, null, 'pro', this.checked)"></td>
                                <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${feature.tiers.includes('ultra_pro') ? 'checked' : ''} ${!isMainAllowed ? 'disabled' : ''} aria-label="${feature.name} available in Ultra Pro" onchange="fm_updateFeatureTier(${feature.id}, null, 'ultra_pro', this.checked)"></td>
                                <td class="actions-cell">
                                    <button class="btn btn-sm btn-primary btn-edit-feature" onclick="fm_editFeature(${feature.id})" aria-label="Edit ${feature.name}" ${!isMainAllowed ? 'disabled' : ''}><i class="fas fa-edit"></i> Edit</button>
                                    <button class="btn btn-sm btn-success btn-add-subfeature" onclick="fm_addSubFeature(${feature.id})" aria-label="Add sub-feature to ${feature.name}" ${!isMainAllowed ? 'disabled' : ''}><i class="fas fa-plus"></i> Add Sub-feature</button>
                                    <button class="btn btn-sm btn-danger btn-delete-feature" onclick="fm_deleteFeature(${feature.id})" aria-label="Delete ${feature.name}" ${!isMainAllowed ? 'disabled' : ''}><i class="fas fa-trash"></i> Delete</button>
                                </td>`;
                            fm_featuresTableBody.appendChild(mainFeatureRow);
                            const actualIsExpanded = feature.isExpandedForFilter ? true : feature.isExpanded;
                            if (actualIsExpanded && feature.subFeatures && feature.subFeatures.length > 0) {
                                feature.subFeatures.forEach(subFeature => {
                                    if (!subFeature) return; hasVisibleRows = true;
                                    const isSubAllowedOnItsOwn = subFeature.allowedLevels && subFeature.allowedLevels.includes(fm_currentSimulatedUserLevel);
                                    const trulyDisableSub = !isSubAllowedOnItsOwn || !isMainAllowed;
                                    const subFeatureRow = document.createElement('tr'); subFeatureRow.className = 'sub-feature-row'; if (trulyDisableSub || (!isSubAllowedOnItsOwn && isMainAllowed)) subFeatureRow.style.opacity = "0.65";
                                    subFeatureRow.dataset.featureId = subFeature.id; subFeatureRow.dataset.parentId = feature.id;
                                    subFeatureRow.innerHTML = `
                                        <td>${subFeature.name}</td>
                                        <td><div class="tooltip"><span>${subFeature.description.substring(0, 60)}${subFeature.description.length > 60 ? '...' : ''}</span><span class="tooltiptext">${subFeature.description}</span></div></td>
                                        <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${subFeature.tiers.includes('free_trial') ? 'checked' : ''} ${trulyDisableSub ? 'disabled' : ''} aria-label="${subFeature.name} available in Free Trial" onchange="fm_updateFeatureTier(${subFeature.id}, ${feature.id}, 'free_trial', this.checked)"></td>
                                        <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${subFeature.tiers.includes('basic') ? 'checked' : ''} ${trulyDisableSub ? 'disabled' : ''} aria-label="${subFeature.name} available in Basic" onchange="fm_updateFeatureTier(${subFeature.id}, ${feature.id}, 'basic', this.checked)"></td>
                                        <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${subFeature.tiers.includes('pro') ? 'checked' : ''} ${trulyDisableSub ? 'disabled' : ''} aria-label="${subFeature.name} available in Pro" onchange="fm_updateFeatureTier(${subFeature.id}, ${feature.id}, 'pro', this.checked)"></td>
                                        <td class="plan-cell"><input type="checkbox" class="plan-checkbox" ${subFeature.tiers.includes('ultra_pro') ? 'checked' : ''} ${trulyDisableSub ? 'disabled' : ''} aria-label="${subFeature.name} available in Ultra Pro" onchange="fm_updateFeatureTier(${subFeature.id}, ${feature.id}, 'ultra_pro', this.checked)"></td>
                                        <td class="actions-cell">
                                            <button class="btn btn-sm btn-primary btn-edit-feature" onclick="fm_editFeature(${subFeature.id}, ${feature.id})" aria-label="Edit ${subFeature.name}" ${trulyDisableSub ? 'disabled' : ''}><i class="fas fa-edit"></i> Edit</button>
                                            <button class="btn btn-sm btn-danger btn-delete-feature" onclick="fm_deleteFeature(${subFeature.id}, ${feature.id})" aria-label="Delete ${subFeature.name}" ${trulyDisableSub ? 'disabled' : ''}><i class="fas fa-trash"></i> Delete</button>
                                        </td>`;
                                    fm_featuresTableBody.appendChild(subFeatureRow);
                                });
                            }
                        });
                        if (!hasVisibleRows && displayFeatures.length > 0) { fm_emptyState.style.display = 'flex'; fm_featuresTable.style.display = 'none'; document.querySelector('.feature-management-module-wrapper .table-scroll-container').style.display = 'none'; }
                    }
            
                    function fm_filterFeatures() {
                        const searchTerm = fm_searchInput.value.toLowerCase().trim(), selectedTier = fm_tierFilter.value, selectedType = fm_typeFilter.value;
                        const filteredResult = fm_featuresData.map(mainFeature => {
                            const currentMainFeatureState = { ...mainFeature }; 
                            const mainMatchesSearch = searchTerm === '' || currentMainFeatureState.name.toLowerCase().includes(searchTerm) || currentMainFeatureState.description.toLowerCase().includes(searchTerm);
                            const mainMatchesTier = selectedTier === '' || currentMainFeatureState.tiers.includes(selectedTier);
                            const filteredSubFeatures = (currentMainFeatureState.subFeatures || []).filter(sub => (searchTerm === '' || sub.name.toLowerCase().includes(searchTerm) || sub.description.toLowerCase().includes(searchTerm)) && (selectedTier === '' || sub.tiers.includes(selectedTier)));
                            const showMainBasedOnSearchAndTier = mainMatchesSearch && mainMatchesTier;
                            let isExpandedForFilter = false;
                            if (selectedType === 'main') return showMainBasedOnSearchAndTier ? { ...currentMainFeatureState, subFeatures: [] } : null; 
                            else if (selectedType === 'sub') { if (filteredSubFeatures.length > 0) { isExpandedForFilter = true; return { ...currentMainFeatureState, subFeatures: filteredSubFeatures, isExpandedForFilter }; } return null; } 
                            else { if (showMainBasedOnSearchAndTier) return { ...currentMainFeatureState, subFeatures: filteredSubFeatures }; else if (filteredSubFeatures.length > 0) { isExpandedForFilter = true; return { ...currentMainFeatureState, subFeatures: filteredSubFeatures, isExpandedForFilter }; } return null; }
                        }).filter(feature => feature !== null);
                        fm_renderFeatures(filteredResult);
                    }
                    function fm_resetFilters() { fm_searchInput.value = ''; fm_tierFilter.value = ''; fm_typeFilter.value = ''; fm_renderFeatures(fm_featuresData); }
                    function fm_openModal() { fm_modalTriggerElement = document.activeElement; fm_featureModalOverlay.classList.add('active'); setTimeout(() => fm_featureNameInput.focus(), 50); }
                    function fm_closeModal() { fm_featureModalOverlay.classList.remove('active'); if (fm_modalTriggerElement) { fm_modalTriggerElement.focus(); fm_modalTriggerElement = null; } }
                    function fm_setupModalForNewMainFeature() { fm_editingFeatureId = null; fm_currentParentIdForSubFeature = null; fm_modalTitle.innerHTML = '<i class="fas fa-plus-square"></i> Add New Main Feature'; fm_submitFeatureBtn.innerHTML = '<i class="fas fa-check"></i> Add Feature'; fm_featureForm.reset(); fm_featureIdInput.value = ''; fm_parentIdInput.value = ''; fm_orgLevelCheckboxes.forEach(cb => cb.value === 'corporate' ? cb.checked = true : cb.checked = false); fm_openModal(); }
                    function fm_addSubFeature(parentId) { const parentFeature = fm_featuresData.find(f => f.id === parentId); if (!parentFeature) return; fm_editingFeatureId = null; fm_currentParentIdForSubFeature = parentId; fm_modalTitle.innerHTML = `<i class="fas fa-plus-square"></i> Add Sub-feature to ${parentFeature.name}`; fm_submitFeatureBtn.innerHTML = `<i class="fas fa-check"></i> Add Sub-feature`; fm_featureForm.reset(); fm_parentIdInput.value = parentId; fm_featureIdInput.value = ''; fm_orgLevelCheckboxes.forEach(checkbox => { checkbox.checked = parentFeature.allowedLevels && parentFeature.allowedLevels.includes(checkbox.value); }); fm_openModal(); }
                    function fm_editFeature(id, parentId = null) { const feature = fm_findFeature(id, parentId); if (!feature) return; fm_editingFeatureId = id; fm_currentParentIdForSubFeature = parentId; fm_modalTitle.innerHTML = `<i class="fas fa-edit"></i> Edit ${parentId ? 'Sub-feature' : 'Feature'}`; fm_submitFeatureBtn.innerHTML = `<i class="fas fa-save"></i> Save Changes`; fm_featureIdInput.value = id; fm_parentIdInput.value = parentId || ''; fm_featureNameInput.value = feature.name; fm_featureDescriptionInput.value = feature.description; fm_tierCheckboxes.forEach(cb => cb.checked = feature.tiers.includes(cb.value)); fm_orgLevelCheckboxes.forEach(cb => cb.checked = feature.allowedLevels && feature.allowedLevels.includes(cb.value)); fm_openModal(); }
                    function fm_deleteFeature(id, parentId = null) { const feature = fm_findFeature(id, parentId); const featureName = feature ? feature.name : 'this feature'; if (!confirm(`Are you sure you want to delete "${featureName}"? This action cannot be undone.`)) return; if (parentId) { const parent = fm_featuresData.find(f => f.id === parentId); if (parent && parent.subFeatures) parent.subFeatures = parent.subFeatures.filter(sf => sf.id !== id); } else { fm_featuresData = fm_featuresData.filter(f => f.id !== id); } fm_filterFeatures(); fm_showToast('Feature deleted successfully!'); if (typeof updateAllCountsAndDisplays === 'function') updateAllCountsAndDisplays(); }
                    function fm_saveFeature(event) {
                        event.preventDefault(); if (!fm_featureForm.checkValidity()) { fm_featureForm.reportValidity(); fm_showToast('Please fill all required fields.', 'warning'); return; }
                        const idToSave = fm_editingFeatureId ? parseInt(fm_editingFeatureId) : fm_getNextId(), name = fm_featureNameInput.value.trim(), description = fm_featureDescriptionInput.value.trim();
                        const tiers = Array.from(fm_tierCheckboxes).filter(cb => cb.checked).map(cb => cb.value); const orgLevels = Array.from(fm_orgLevelCheckboxes).filter(cb => cb.checked).map(cb => cb.value);
                        const featureProps = { name, description, tiers, allowedLevels: orgLevels }, parentIdFromForm = fm_parentIdInput.value ? parseInt(fm_parentIdInput.value) : null;
                        if (parentIdFromForm) { const parent = fm_featuresData.find(f => f.id === parentIdFromForm); if (!parent) { fm_showToast('Error: Parent feature not found.', 'error'); return; } if (!parent.subFeatures) parent.subFeatures = []; if (fm_editingFeatureId && fm_currentParentIdForSubFeature === parentIdFromForm) { const idx = parent.subFeatures.findIndex(sf => sf.id === idToSave); if (idx !== -1) parent.subFeatures[idx] = { ...parent.subFeatures[idx], id: idToSave, ...featureProps }; } else { parent.subFeatures.push({ id: idToSave, parentId: parentIdFromForm, ...featureProps }); } } 
                        else { if (fm_editingFeatureId && !fm_currentParentIdForSubFeature) { const idx = fm_featuresData.findIndex(f => f.id === idToSave); if (idx !== -1) fm_featuresData[idx] = { ...fm_featuresData[idx], ...featureProps }; } else { fm_featuresData.push({ id: idToSave, ...featureProps, subFeatures: [], isExpanded: false }); } }
                        fm_closeModal(); fm_filterFeatures(); fm_showToast(`Feature ${fm_editingFeatureId ? 'updated' : 'added'} successfully!`); fm_editingFeatureId = null; fm_currentParentIdForSubFeature = null; fm_featureForm.reset(); fm_featureIdInput.value = ''; fm_parentIdInput.value = ''; if (typeof updateAllCountsAndDisplays === 'function') updateAllCountsAndDisplays();
                    }
                    function fm_updateFeatureTier(featureId, parentId, tier, isChecked) { const feature = fm_findFeature(featureId, parentId); if (!feature) return; if (isChecked) { if (!feature.tiers.includes(tier)) feature.tiers.push(tier); } else { feature.tiers = feature.tiers.filter(t => t !== tier); } if (typeof updateAllCountsAndDisplays === 'function') updateAllCountsAndDisplays(); }
            
                    if(fm_addNewMainFeatureBtn) fm_addNewMainFeatureBtn.addEventListener('click', fm_setupModalForNewMainFeature);
                    if(fm_addNewFromEmptyBtn) fm_addNewFromEmptyBtn.addEventListener('click', fm_setupModalForNewMainFeature);
                    if(fm_closeModalBtn) fm_closeModalBtn.addEventListener('click', fm_closeModal);
                    if(fm_cancelModalBtn) fm_cancelModalBtn.addEventListener('click', fm_closeModal);
                    if(fm_featureModalOverlay) fm_featureModalOverlay.addEventListener('click', e => { if (e.target === fm_featureModalOverlay) fm_closeModal(); });
                    document.addEventListener('keydown', e => { if (e.key === 'Escape' && fm_featureModalOverlay && fm_featureModalOverlay.classList.contains('active')) fm_closeModal(); });
                    if(fm_featureForm) fm_featureForm.addEventListener('submit', fm_saveFeature);
                    document.addEventListener('DOMContentLoaded', () => { if (!fm_featuresTable) return; let maxInitialId = 0; fm_featuresData.forEach(f => { if (f.id > maxInitialId) maxInitialId = f.id; if (f.subFeatures) f.subFeatures.forEach(sf => { if (sf.id > maxInitialId) maxInitialId = sf.id; }); }); fm_nextId = maxInitialId + 1; fm_renderFeatures(); });
                    </script>
                </div>
            </div>
        </details>
<div class="modal fade" id="addcompanydetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">

<input type="hidden" name="is_role" value="2">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Corporate ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                   

                   

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Contact Person Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>
						
						            <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>
         <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>
                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                     

                              <div class="mb-6 col-md-6">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@php $i = 1; @endphp

@foreach($users as $corporate)


<details class="entity-level corporate-entity" id="corp_{{ $corporate->id }}" data-status="active" data-logo-src="">
    <summary class="entity-summary">
        <div class="summary-content-wrapper">
            <img src="#" alt="" class="entity-logo-display" style="display:none; width: 32px; height: 32px; border-radius: var(--border-radius); margin-right: 0.5rem;">
            <span class="entity-icon">🏛️</span>
            <span class="entity-name-display">{{ $corporate->login_id }}</span>
        </div>
        <div class="summary-actions">
            <span class="entity-count regional-count"><span class="count-label">Regionals: </span>0</span>
            <span class="entity-count unit-count-pending"><span class="count-label">Pending: </span>0</span>
            <span class="entity-count unit-count-active"><span class="count-label">Active: </span>0</span>
            <span class="entity-count unit-count-expiry"><span class="count-label">Expiry Soon: </span>0</span>
            <span class="entity-count unit-count-inactive"><span class="count-label">Expired/Off: </span>0</span>
            <button type="button" class="edit-btn" onclick="openEditModal('corporate', 'corp_{{ $corporate->id }}')">
                <span class="btn-icon">✏️</span><span>Edit</span>
            </button>
            <button type="button" class="action-button summary-action-btn add-regional"
    onclick="openAddRegionalModal({{ $corporate->id }}, '{{ $corporate->company_name }}')">
    ➕ Add Regional
</button>
            <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('corp_{{ $corporate->id }}', 'corporate', this)">
                <span class="btn-icon">🟢</span><span>Active</span>
            </button>
            <span class="toggler-icon">▶</span>
        </div>
    </summary>

    <div class="scoped-upload-section">
        <h4>Bulk Add Regionals & Units to this Corporate</h4>
        <div class="button-pair">
            <button type="button" class="action-button download-sample" onclick="downloadRegionalSampleCsv('corp_{{ $corporate->id }}', '{{ $corporate->login_id }}')">📄 Sample CSV for Regionals</button>
            <button type="button" class="action-button upload-scoped" onclick="openUploadRegionalsCsvModal('corp_{{ $corporate->id }}', '{{ $corporate->login_id }}')">⬆️ Upload Regionals CSV</button>
        </div>
    </div>

    <div class="entity-content-wrapper">
        <div class="entity-details-grid">
            <div class="detail-item" data-field="address"><strong><span class="detail-icon">📍</span>Address:</strong> <span class="value-display">{{ $corporate->Company_address ?? '' }}</span></div>
            <div class="detail-item" data-field="contactPerson"><strong><span class="detail-icon">👤</span>Contact:</strong> <span class="value-display">{{ $corporate->name ?? '' }} ({{ $corporate->designation ?? '' }})</span></div>
            <div class="detail-item" data-field="email"><strong><span class="detail-icon">✉️</span>Email:</strong> <a href="mailto:{{ Auth::user()->email }}" class="value-display">{{ $corporate->email ?? '' }}</a></div>
            <div class="detail-item" data-field="phone"><strong><span class="detail-icon">📞</span>Phone:</strong> <a href="tel:+{{ Auth::user()->mobile_number }}" class="value-display">{{ $corporate->mobile_number ?? '' }}</a></div>
        </div>
        <p class="entity-description" data-field="description">Oversees all regional operations and global strategy.</p>

        <div class="regional-container">
            
              @php 	
  
  			$regionals = DB::table('users')->where('created_by', $corporate->id ?? '')->where('is_role', "1")->get(); @endphp
  			
  			
            @foreach($regionals as $regional)
                @php
                    $regionalId = 'reg_' . $regional->id;
                    $unitusers = DB::table('users')->where('created_by1', $regional->id)->where('is_role', 3)->get();
                @endphp

                <details class="entity-level regional-office" id="{{ $regionalId }}" data-status="active" data-logo-src="">
                    <summary class="entity-summary">
                        <div class="summary-content-wrapper">
                            <img src="#" alt="" class="entity-logo-display" style="display:none; width: 28px; height: 28px; border-radius: var(--border-radius); margin-right: 0.5rem;">
                            <span class="entity-icon">🌍</span>
                            <span class="entity-name-display">{{ $regional->company_name ?? '' }}</span>
                        </div>
                        <div class="summary-actions">
                            <span class="entity-count unit-count-pending"><span class="count-label">Pending: </span>1</span>
                            <span class="entity-count unit-count-active"><span class="count-label">Active: </span>1</span>
                            <span class="entity-count unit-count-expiry"><span class="count-label">Expiry Soon: </span>1</span>
                            <span class="entity-count unit-count-inactive"><span class="count-label">Expired/Off: </span>2</span>
                            <button type="button" class="edit-btn" onclick="openEditModal('regional', '{{ $regionalId }}')">
                                <span class="btn-icon">✏️</span><span>Edit</span>
                            </button>
                            <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('{{ $regionalId }}', 'regional', this)">
                                <span class="btn-icon">🟢</span><span>Active</span>
                            </button>
                            <span class="toggler-icon">▶</span>
                        </div>
                    </summary>

                    <div class="scoped-upload-section">
                        <h4>Bulk Add Units to this Regional</h4>
                         
                        <div class="button-pair">
                            <button type="button" class="action-button summary-action-btn add-regional"
    onclick="openAddUnitModal({{ $regional->id }}, '{{ $regional->company_name }}',{{ $regional->created_by }})">
    ➕ Add Unit
</button>
                            <button type="button" class="action-button download-sample" onclick="downloadUnitSampleCsv('{{ $regionalId }}', '{{ $regional->company_name }}')">📄 Sample CSV for Units</button>
                            <button type="button" class="action-button upload-scoped" onclick="openUploadUnitsCsvModal('{{ $regionalId }}', '{{ $regional->company_name }}')">⬆️ Upload Units CSV</button>
                        </div>
                    </div>

                    <div class="entity-content-wrapper">
                        <div class="entity-details-grid">
                            <div class="detail-item" data-field="address"><strong><span class="detail-icon">📍</span>Address:</strong> <span class="value-display">{{ $regional->Company_address ?? '' }}</span></div>
                            <div class="detail-item" data-field="contactPerson"><strong><span class="detail-icon">👤</span>Contact:</strong> <span class="value-display">{{ $regional->Company_address ?? '' }} (Regional Director)</span></div>
                            <div class="detail-item" data-field="email"><strong><span class="detail-icon">✉️</span>Email:</strong> <a href="mailto:{{ $regional->email }}" class="value-display">{{ $regional->email ?? '' }}</a></div>
                            <div class="detail-item" data-field="phone"><strong><span class="detail-icon">📞</span>Phone:</strong> <a href="tel:+{{ $regional->mobile_number }}" class="value-display">+{{ $regional->mobile_number ?? '' }}</a></div>
                        </div>
                        <p class="entity-description" data-field="description">Manages operations in USA and Canada.</p>

                        <h3 class="unit-section-header">Operational Units:</h3>
                       
                        <ul class="unit-list">
                            @foreach($unitusers as $unit)
                                @php $unitId = 'unit_' . $unit->id; @endphp
                                <details class="unit-item-container" id="{{ $unitId }}" data-status="pending-approval" data-effective-status="pending-approval" data-logo-src="">
                                    <summary class="unit-summary">
                                        <div class="summary-content-wrapper">
                                            <img src="#" alt="" class="entity-logo-display" style="display:none; width: 28px; height: 28px; border-radius: var(--border-radius); margin-right: 0.5rem;">
                                            <span class="entity-icon unit-icon">⚙️</span>
                                            <span class="unit-name-display">{{ $unit->company_name ?? '' }}</span>
                                            <span class="unit-summary-subscription-info" style="display: none;">S: <span class="summary-subscribed-date"></span> | E: <span class="summary-expires-date"></span> | St: <span class="summary-status-text"></span></span>
                                        </div>
                                        <div class="summary-actions">
                                            <button type="button" class="edit-btn" onclick="openEditModal('unit', '{{ $unitId }}', 'approve')">
                                                <span class="btn-icon">✏️</span><span>Approve/Edit</span>
                                            </button>
                                            <span class="subscription-badge badge-pending-approval">Pending</span>
                                        </div>
                                    </summary>
                                    <div class="unit-details-content-wrapper">
                                        <div class="unit-contact-details">
                                            <div data-field="contactPerson"><span class="detail-icon">👤</span><span class="value-display">{{ $unit->name ?? '' }}</span></div>
                                            <div data-field="email"><span class="detail-icon">✉️</span><a href="mailto:{{ $unit->email }}" class="value-display">{{ $unit->email ?? '' }}</a></div>
                                            <div data-field="address"><span class="detail-icon">📍</span><span class="value-display">{{ $unit->Company_address ?? '' }}</span></div>
                                            <div data-field="phone"><span class="detail-icon">📞</span><a href="tel:{{ $unit->mobile_number }}" class="value-display">{{ $unit->mobile_number ?? '' }}</a></div>
                                        </div>
                                    </div>
                                </details>
                            @endforeach
                        </ul>
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</details>

@endforeach
        <div id="entityContainer" class="entity-container"></div>
    </main>

       <div id="corporateModal" class="modal"> <div class="modal-content"> 
       <div class="modal-header"> <h2 id="corporateModalTitle">Add/Edit Corporate Entity</h2> <span class="close-btn" onclick="closeModal('corporateModal')">×</span> </div>
       
<form id="corporateForm" class="modal-body" onsubmit="event.preventDefault(); saveCorporate();">
    <input type="hidden" id="corporateEntityId">

    <div class="form-group">
        <label for="corporateNameModal">Name</label>
        <input type="text" id="corporateNameModal" required>
    </div>

    <div class="form-group">
        <label for="corporateAddressModal">Address</label>
        <input type="text" id="corporateAddressModal">
    </div>

    <div class="form-group">
        <label for="corporateContactPersonModal">Contact Person</label>
        <input type="text" id="corporateContactPersonModal">
    </div>

    <div class="form-group">
        <label for="corporateEmailModal">Email</label>
        <input type="email" id="corporateEmailModal">
    </div>

    <div class="form-group">
        <label for="corporatePhoneModal">Phone</label>
        <input type="tel" id="corporatePhoneModal">
    </div>

    <div class="form-group">
        <label for="corporateDescriptionModal">Description</label>
        <textarea id="corporateDescriptionModal"></textarea>
    </div>

    <!-- ✅ Submit Button Here -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>       
       
       
       </div> </div>
       
       
    <div id="regionalModal" class="modal"> <div class="modal-content"> <div class="modal-header"> <h2 id="regionalModalTitle">Add/Edit Regional Division</h2> <span class="close-btn" onclick="closeModal('regionalModal')">×</span> </div> 
    
<form id="regionalForm" class="modal-body" onsubmit="event.preventDefault(); saveRegional();">
    <input type="hidden" id="regionalEntityId">
    <input type="hidden" id="regionalParentId">

    <div class="form-group">
        <label for="regionalNameModal">Name</label>
        <input type="text" id="regionalNameModal" required>
    </div>

    <div class="form-group">
        <label for="regionalAddressModal">Address</label>
        <input type="text" id="regionalAddressModal">
    </div>

    <div class="form-group">
        <label for="regionalContactPersonModal">Contact Person</label>
        <input type="text" id="regionalContactPersonModal">
    </div>

    <div class="form-group">
        <label for="regionalEmailModal">Email</label>
        <input type="email" id="regionalEmailModal">
    </div>

    <div class="form-group">
        <label for="regionalPhoneModal">Phone</label>
        <input type="tel" id="regionalPhoneModal">
    </div>

    <div class="form-group">
        <label for="regionalDescriptionModal">Description</label>
        <textarea id="regionalDescriptionModal"></textarea>
    </div>

    <!-- ✅ Submit Button Here -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
    
    
    </div> </div>
    
    <div id="unitModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="unitModalTitle">Add/Edit Unit</h2>
            <span class="close-btn" onclick="closeModal('unitModal')">×</span>
        </div>

        <form id="unitForm" class="modal-body" onsubmit="event.preventDefault(); saveUnit();">
            <!-- Hidden Inputs -->
            <input type="hidden" id="unitEntityId" name="id">
            <input type="hidden" id="unitParentId" name="corporate_id">
            <input type="hidden" id="unitModalActionType" name="action_type">

            <!-- Unit Name -->
            <div class="form-group">
                <label for="unitNameModal">Name</label>
                <input type="text" id="unitNameModal" name="name" class="form-control" required>
            </div>

            <!-- Regional Selection -->
            <div class="form-group">
                <label for="unitRegionalSelect">Select Regional Division</label>
                <select id="unitRegionalSelect" name="regional_id" class="form-control" required>
                    <option value="">-- Select Regional --</option>
                </select>
            </div>

            <!-- Subscription Fields (conditionally visible) -->
            <div class="subscription-fields" style="display:none;">
                <div class="form-group">
                    <label for="subscriptionTypeModal">Subscription Type</label>
                    <select id="subscriptionTypeModal" name="subscription_type" class="form-control">
                        <option value="free_trial">Trial</option>
                        <option value="basic">Basic</option>
                        <option value="pro">Pro</option>
                        <option value="ultra_pro">Ultra Pro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subscribedDateModal">Subscribed Date</label>
                    <input type="date" id="subscribedDateModal" name="subscribed_date" class="form-control">
                </div>
            </div>

            <hr style="margin: 1rem 0;">

            <!-- Contact Person -->
            <div class="form-group">
                <label for="unitContactPersonModal">Contact Person</label>
                <input type="text" id="unitContactPersonModal" name="contact_person" class="form-control">
            </div>

            <!-- Contact Email -->
            <div class="form-group">
                <label for="unitEmailModal">Contact Email</label>
                <input type="email" id="unitEmailModal" name="email" class="form-control">
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="unitAddressModal">Address</label>
                <input type="text" id="unitAddressModal" name="address" class="form-control">
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label for="unitPhoneModal">Phone</label>
                <input type="tel" id="unitPhoneModal" name="phone" class="form-control">
            </div>

            <!-- Footer Submit Button -->
            <div class="modal-footer">
                <button type="submit" id="unitFormSubmitButton" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

                   
                   
                   
                   
                                         <div class="modal fade" id="addregionaldetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="regionalModalDynamicTitle">Add Regional</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">
          <div class="mb-3 col-md-6">
                            <label class="form-label">Regional ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>
                        <input type="hidden" name="is_role" value="1">
                       <input type="hidden" name="created_by" id="regionalCorporateId" value="">


              

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Regional Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label"> Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                   
 <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Contact Person Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>
                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                             
						
						      <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                        

                              <div class="mb-12 col-md-12">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
                          <div class="modal fade" id="addunitdetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                              <input type="hidden" name="created_by" id="unitregionalCorporateId" value="">
                         				 <input type="hidden" name="is_role" value="3">

                                      <input type="hidden" name="created_by1" id="clickregionalId" value="">
                    <div class="row">
           <div class="mb-3 col-md-6">
                            <label class="form-label">Unit ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>
                        
                       

             

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Unit Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label">Unit Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                


                              <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Person Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>
						
						
                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                         

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>
						
						     <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                              <div class="mb-6 col-md-6">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const EXPIRY_SOON_DAYS_THRESHOLD = 7;
    let currentEntityType, currentEntityId, currentParentId, currentParentName = '';
    let filterCorporateEl, filterRegionalEl, filterUnitEl, clearFiltersButtonEl;
    let subscriptionSettings = {
        common: {planKey: 'common',idPrefix: 'common',displayName: 'Common Features',icon: '🌐',features: []},
        freeTrial: {planKey: 'freeTrial',idPrefix: 'ft',displayName: 'Free Trial',icon: '🎁',validityDays: 7,costINR: 0,features: []},
        basic: {planKey: 'basic',idPrefix: 'basic',displayName: 'Basic',icon: '⚙️',validityDays: 30,costINR: 499,features: []},
        pro: {planKey: 'pro',idPrefix: 'pro',displayName: 'Pro',icon: '🚀',validityDays: 365,costINR: 1999,features: []},
        ultraPro: { planKey: 'ultraPro',idPrefix: 'ultra',displayName: 'Ultra Pro',icon: '🌟', validityDays: 730, costINR: 3999,features: []}
    };

    function generateId(prefix) { return `${prefix}_${Date.now()}_${Math.floor(Math.random() * 1000)}`; }
    function formatDate(dateString) { if (!dateString) return 'N/A'; const date = new Date(dateString + 'T00:00:00Z'); return date.toLocaleDateString(undefined, { timeZone: 'UTC', year: 'numeric', month: 'short', day: 'numeric' }); }
    function getTodayDateString() { return new Date().toISOString().split('T')[0]; }
    function getPlanSettingsKey(subscriptionType) { if (!subscriptionType) return null; return subscriptionType === 'free_trial' ? 'freeTrial' : (subscriptionType === 'ultra_pro' ? 'ultraPro' : subscriptionType); }
    function calculateEndDate(subscribedDateStr, subscriptionType) {
        if (!subscribedDateStr || !subscriptionType) return null;
        const planSettings = subscriptionSettings[getPlanSettingsKey(subscriptionType)];
        const durationDays = planSettings ? planSettings.validityDays : null;
        if (!durationDays && subscriptionType !== 'common') console.warn(`Validity days not found for subscription type: ${subscriptionType}.`);
        if (!durationDays) return null;
        const subscribedDate = new Date(subscribedDateStr + 'T00:00:00Z');
        const endDate = new Date(subscribedDate);
        endDate.setUTCDate(subscribedDate.getUTCDate() + parseInt(durationDays) -1); 
        return endDate.toISOString().split('T')[0];
    }
    function calculateDaysLeft(endDateString) { 
        if (!endDateString) return null; 
        const today = new Date(); today.setUTCHours(0,0,0,0); 
        const endDate = new Date(endDateString + 'T00:00:00Z'); 
        const normalizedEndDateForCalc = new Date(endDate); normalizedEndDateForCalc.setUTCHours(23,59,59,999);
        return Math.ceil((normalizedEndDateForCalc - today) / (1000 * 60 * 60 * 24)); 
    }
    function getSubscriptionEffectiveStatus(daysLeft) { if (daysLeft === null || typeof daysLeft === 'undefined') return 'inactive'; if (daysLeft <= 0) return 'inactive'; if (daysLeft <= EXPIRY_SOON_DAYS_THRESHOLD) return 'expiry-soon'; return 'active'; }

    function previewLogo(event, previewElId, removeBtnId) { const preview = document.getElementById(previewElId), removeBtn = document.getElementById(removeBtnId), file = event.target.files[0], reader = new FileReader(); reader.onloadend = () => { preview.src = reader.result; preview.style.display = 'block'; if (removeBtn) removeBtn.style.display = 'inline-block'; const hiddenDataElId = previewElId.replace('Preview', 'HiddenLogoData'); if (document.getElementById(hiddenDataElId)) document.getElementById(hiddenDataElId).value = ''; }; if (file) reader.readAsDataURL(file); else { preview.src = '#'; preview.style.display = 'none'; if (removeBtn) removeBtn.style.display = 'none'; }}
    function removeLogo(previewElId, inputElId, hiddenDataElId) { document.getElementById(previewElId).src = '#'; document.getElementById(previewElId).style.display = 'none'; document.getElementById(inputElId).value = ''; if (document.getElementById(hiddenDataElId)) document.getElementById(hiddenDataElId).value = 'REMOVED'; const removeBtn = document.getElementById(previewElId.replace('Preview', 'RemoveLogoBtn')); if (removeBtn) removeBtn.style.display = 'none'; }
    function resetLogoFields(prefix) { ['LogoPreview', 'LogoInput', 'HiddenLogoData', 'RemoveLogoBtn'].forEach(suffix => { const el = document.getElementById(`${prefix}${suffix}`); if (el) { if (suffix === 'LogoPreview') { el.src = '#'; el.style.display = 'none'; } else if (suffix === 'LogoInput' || suffix === 'HiddenLogoData') el.value = ''; else if (suffix === 'RemoveLogoBtn') el.style.display = 'none'; } }); }
    function updateEntityLogoDisplay(entityElementOrSummary, logoDataUrl) {
        let summaryElement = entityElementOrSummary.tagName === 'DETAILS' ? entityElementOrSummary.querySelector('summary') : entityElementOrSummary;
        if(!summaryElement) return;
        const displayLogoEl = summaryElement.querySelector('.entity-logo-display'), displayIconEl = summaryElement.querySelector('.entity-icon, .unit-icon'), parentDetailsElement = summaryElement.closest('details');
        if (displayLogoEl) { if (logoDataUrl && logoDataUrl !== '#' && logoDataUrl !== 'REMOVED' && logoDataUrl !== 'null') { displayLogoEl.src = logoDataUrl; displayLogoEl.style.display = 'block'; if (displayIconEl) displayIconEl.style.display = 'none'; } else { displayLogoEl.src = '#'; displayLogoEl.style.display = 'none'; if (displayIconEl) displayIconEl.style.display = 'block'; }}
        if (parentDetailsElement) parentDetailsElement.dataset.logoSrc = (logoDataUrl && logoDataUrl !== 'REMOVED' && logoDataUrl !== 'null') ? logoDataUrl : '';
    }
    function openModal(modalId) { document.getElementById(modalId).style.display = 'block'; }
    function closeModal(modalId) { 
        const modal = document.getElementById(modalId); if (!modal) return; modal.style.display = 'none';
        const formIdMap = {'corporateModal':'corporateForm', 'regionalModal':'regionalForm', 'unitModal':'unitForm', 'uploadRegionalsModal':'uploadRegionalsForm', 'uploadUnitsModal':'uploadUnitsForm', 'superAdminCsvUploadModal':'superAdminCsvUploadForm'};
        const form = document.getElementById(formIdMap[modalId]); if (form) form.reset();
        if (['corporateModal', 'regionalModal', 'unitModal'].includes(modalId)) { resetLogoFields(modalId.replace('Modal', '')); currentEntityType = currentEntityId = currentParentId = currentParentName = null; if (document.getElementById('unitModalActionType')) document.getElementById('unitModalActionType').value = ''; }
        else if (['uploadRegionalsModal', 'uploadUnitsModal', 'superAdminCsvUploadModal'].includes(modalId)) { const statusEl = document.getElementById(modalId.replace('Modal','Status')); if(statusEl) { statusEl.innerHTML = ''; statusEl.style.backgroundColor = '#e9ecef'; statusEl.style.color = 'var(--text-primary)'; }}
        else if (modalId === 'renewConfirmModal') { ['renewUnitNameDisplay','renewCurrentSubTypeDisplay','renewLastSubscribedDateDisplay','renewNextValidDateDisplay'].forEach(id => document.getElementById(id).textContent = ''); }
    }
    function getDisplayValue(element, fieldName) { const cw = element.matches('.unit-item-container') ? element.querySelector('.unit-details-content-wrapper') : element; if (!cw) return ''; const el = cw.querySelector(`.detail-item[data-field="${fieldName}"] .value-display, .unit-contact-details div[data-field="${fieldName}"] .value-display, .entity-description[data-field="${fieldName}"]`); return el ? el.textContent.trim() : ''; }

  
   function openEditModal(entityType, entityId, actionType = null) {
    currentEntityType = entityType;
    currentEntityId = entityId;
    currentParentId = null;

    const entityEl = document.getElementById(entityId);
    if (!entityEl) {
        console.error("Entity not found:", entityId);
        return;
    }

    if (document.getElementById('unitModalActionType')) {
        document.getElementById('unitModalActionType').value = actionType || '';
    }

    const entityLogoSrc = entityEl.dataset.logoSrc || '';
    const entityNameDisplay = entityEl.querySelector('.entity-name-display, .unit-name-display')?.textContent || '';
    let modalId, modalTitleElId, titlePrefix = "Edit";

    // CORPORATE or REGIONAL
    if (entityType === 'corporate' || entityType === 'regional') {
        modalId = `${entityType}Modal`;
        modalTitleElId = `${entityType}ModalTitle`;

        document.getElementById(`${entityType}EntityId`).value = entityId;
        document.getElementById(`${entityType}NameModal`).value = entityNameDisplay;

        ['Address', 'ContactPerson', 'Email', 'Phone', 'Description'].forEach(f => {
            const field = document.getElementById(`${entityType}${f}Modal`);
            if (field) field.value = getDisplayValue(entityEl, f.toLowerCase());
        });

        document.getElementById(modalTitleElId).textContent =
            `${titlePrefix} ${entityType.charAt(0).toUpperCase() + entityType.slice(1)} ${entityType === 'regional' ? 'Division' : 'Entity'}`;

        resetLogoFields(entityType);
        if (entityLogoSrc) {
            document.getElementById(`${entityType}LogoPreview`).src = entityLogoSrc;
            document.getElementById(`${entityType}LogoPreview`).style.display = 'block';
            document.getElementById(`${entityType}HiddenLogoData`).value = entityLogoSrc;
            const removeBtn = document.getElementById(`${entityType}RemoveLogoBtn`);
            if (removeBtn) removeBtn.style.display = 'inline-block';
        }
    }

    // UNIT
    else if (entityType === 'unit') {
      
        modalId = 'unitModal';
        modalTitleElId = 'unitModalTitle';

        const unitFormSubmitButton = document.getElementById('unitFormSubmitButton');
        const subscriptionFieldsDiv = document.querySelector('#unitModal .subscription-fields');
        const subscribedDateInput = document.getElementById('subscribedDateModal');

        document.getElementById('unitEntityId').value = entityId;
        document.getElementById('unitNameModal').value = entityNameDisplay;

        ['ContactPerson', 'Email', 'Address', 'Phone'].forEach(f => {
            const field = document.getElementById(`unit${f}Modal`);
            if (field) field.value = getDisplayValue(entityEl, f.toLowerCase());
        });

        // Load regionals for selected corporate
        const corporateId = entityEl.dataset.corporateId;
        const currentRegionalId = entityEl.dataset.regionalId;
        
   // Step 1: Fetch corporate ID using entityId
$.ajax({
    type: 'GET',
    url: "{{ route('unit_corporate_id') }}",
    data: { id: entityId },
    dataType: 'json',
    success: function (response) {
       const corporateId = response.data.created_by;
const regionalId = response.data.created_by1; // <-- will be used in the dropdown selection

// Step 2: Now fetch the regional list for that corporate
$.ajax({
    type: 'GET',
    url: "{{ route('regional_list') }}",
    data: { id: corporateId },
    dataType: 'json',
    success: function (response) {
        const data = response.data || [];
        const regionalSelect = document.getElementById('unitRegionalSelect');
        regionalSelect.innerHTML = '<option value="">-- Select Regional --</option>';

        data.forEach(function (regional) {
            const opt = document.createElement('option');
            opt.value = regional.id;
            opt.textContent = regional.company_name;

            // ✅ Select the matching regional ID
            if (regional.id == regionalId) {
                opt.selected = true;
            }

            regionalSelect.appendChild(opt);
        });
    },
    error: function (err) {
        console.error('Failed to load regionals', err);
    }
});
    },
    error: function (err) {
        console.error('Failed to load corporate ID', err);
    }
});

                
                



        // Logo
        resetLogoFields('unit');
        if (entityLogoSrc) {
            document.getElementById('unitLogoPreview').src = entityLogoSrc;
            document.getElementById('unitLogoPreview').style.display = 'block';
            document.getElementById('unitHiddenLogoData').value = entityLogoSrc;
            const removeBtn = document.getElementById('unitRemoveLogoBtn');
            if (removeBtn) removeBtn.style.display = 'inline-block';
        }

        // Subscription logic
        const cMS = entityEl.dataset.status;
        const cSD = entityEl.dataset.subscribedDate;
        let cST = entityEl.dataset.subscriptionType;

        if (!cST && cMS === 'active') {
            cST = 'free_trial';
            entityEl.dataset.subscriptionType = cST;
        }

        if (actionType === 'approve' && cMS === 'pending-approval') {
            subscriptionFieldsDiv.style.display = 'block';
            subscribedDateInput.required = true;
            unitFormSubmitButton.textContent = 'Approve & Save Subscription';
            titlePrefix = "Approve Unit & Set Subscription";
            document.getElementById('subscriptionTypeModal').value = 'free_trial';
            document.getElementById('subscribedDateModal').value = getTodayDateString();
        } else if (cMS === 'active' && (!actionType || actionType.startsWith('upgrade-'))) {
            subscriptionFieldsDiv.style.display = 'block';
            subscribedDateInput.required = true;
            unitFormSubmitButton.textContent = 'Save Changes';

            if (actionType?.startsWith('upgrade-')) {
                const targetPlan = actionType.split('-')[1];
                titlePrefix = `Upgrade Unit to ${subscriptionSettings[getPlanSettingsKey(targetPlan)]?.displayName || targetPlan}`;
                document.getElementById('subscriptionTypeModal').value = targetPlan;
                document.getElementById('subscribedDateModal').value = getTodayDateString();
            } else {
                titlePrefix = "Edit Unit Subscription";
                document.getElementById('subscriptionTypeModal').value = cST || 'free_trial';
                document.getElementById('subscribedDateModal').value = cSD || getTodayDateString();
            }
        } else {
            subscriptionFieldsDiv.style.display = 'none';
            subscribedDateInput.required = false;
            unitFormSubmitButton.textContent = 'Save Changes';

            if (cMS === 'pending-approval') {
                titlePrefix = "Edit Pending Unit Details";
            } else if (cMS === 'inactive') {
                titlePrefix = "Edit Manually Inactive Unit Details";
            } else {
                titlePrefix = "Edit Unit Details";
            }
        }

        document.getElementById(modalTitleElId).textContent = titlePrefix;
    }

    if (modalId) openModal(modalId);
}

    function updateDisplay(element, fieldName, newValue, isLink = false, linkPrefix = '') { const cw = element.matches('.unit-item-container') ? element.querySelector('.unit-details-content-wrapper') : element.querySelector('.entity-content-wrapper'); if (!cw) return; const vE = cw.querySelector(`.detail-item[data-field="${fieldName}"] .value-display, .unit-contact-details div[data-field="${fieldName}"] .value-display`), dE = cw.querySelector(`.entity-description[data-field="${fieldName}"]`); if (vE) { vE.textContent = newValue || 'Not Set'; if (isLink) vE.href = newValue ? linkPrefix + newValue : '#'; } else if (dE) dE.textContent = newValue || 'No description provided.'; }

    
    
   
    
    function updateUnitDisplayAndSubscriptionInfo(unitElement) { 
        if (!unitElement) return; const unitId = unitElement.id;
        const summaryEl = unitElement.querySelector('summary.unit-summary'), contentWrapperEl = unitElement.querySelector('.unit-details-content-wrapper');
        if (!summaryEl || !contentWrapperEl) return;
        updateEntityLogoDisplay(summaryEl, unitElement.dataset.logoSrc);
        const manualStatus = unitElement.dataset.status, subType = unitElement.dataset.subscriptionType, subscribedDate = unitElement.dataset.subscribedDate, endDate = unitElement.dataset.subscriptionEndDate;
        const summaryActionsContainer = summaryEl.querySelector('.summary-actions'), badgeEl = summaryActionsContainer.querySelector('.subscription-badge');
        const summarySubInfoContainer = summaryEl.querySelector('.unit-summary-subscription-info'), summarySubscribedDateEl = summaryEl.querySelector('.summary-subscribed-date'), summaryExpiresDateEl = summaryEl.querySelector('.summary-expires-date'), summaryStatusTextEl = summaryEl.querySelector('.summary-status-text');
        if (contentWrapperEl.querySelector('.unit-subscription-info')) contentWrapperEl.querySelector('.unit-subscription-info').style.display = 'none';
        const secondaryActionsBar = contentWrapperEl.querySelector('.unit-item-actions-bar-secondary'), featuresSectionEl = contentWrapperEl.querySelector('.unit-active-features');
        summaryActionsContainer.querySelectorAll('.edit-btn, .activation-btn, .approve, .toggler-icon').forEach(btn => btn.remove());
        if (secondaryActionsBar) secondaryActionsBar.innerHTML = ''; 
        let primaryActionButtonHTML = '', togglerIconHTML = `<span class="toggler-icon">▶</span>`, editButtonHTML = `<button type="button" class="edit-btn" onclick="openEditModal('unit', '${unitId}', null)"><span class="btn-icon">✏️</span><span>Edit</span></button>`;

        if (manualStatus === 'pending-approval') { unitElement.dataset.effectiveStatus = 'pending-approval'; if (badgeEl) { badgeEl.textContent = 'Pending'; badgeEl.className = 'subscription-badge badge-pending-approval'; } if (summarySubInfoContainer) summarySubInfoContainer.style.display = 'none'; if (featuresSectionEl) featuresSectionEl.style.display = 'none'; if (secondaryActionsBar) secondaryActionsBar.style.display = 'none'; primaryActionButtonHTML = `<button type="button" class="action-button summary-action-btn approve" onclick="openEditModal('unit', '${unitId}', 'approve')"><span class="btn-icon">✅</span><span>Approve</span></button>`; }
        else if (manualStatus === 'inactive') { unitElement.dataset.effectiveStatus = 'manual-inactive'; if (badgeEl) { badgeEl.textContent = 'Inactive'; badgeEl.className = 'subscription-badge badge-expired'; } if (summarySubInfoContainer) summarySubInfoContainer.style.display = 'none'; if (featuresSectionEl) featuresSectionEl.style.display = 'none'; if (secondaryActionsBar) secondaryActionsBar.style.display = 'none'; primaryActionButtonHTML = `<button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleUnitActivation('${unitId}', this)"><span class="btn-icon">🟢</span><span>Activate</span></button>`; }
        else if (manualStatus === 'active') {
            if (summarySubInfoContainer) summarySubInfoContainer.style.display = ''; if (featuresSectionEl) featuresSectionEl.style.display = 'block'; if (secondaryActionsBar) secondaryActionsBar.style.display = 'flex'; 
            if (badgeEl) { badgeEl.textContent = subType ? (subscriptionSettings[getPlanSettingsKey(subType)]?.displayName || subType) : 'N/A'; badgeEl.className = 'subscription-badge'; if (subType) { let badgeClass = subType.toLowerCase(); if (badgeClass === 'free_trial') badgeClass = 'trial'; if (badgeClass === 'ultra_pro') badgeClass = 'ultrapro'; badgeEl.classList.add(`badge-${badgeClass}`); } else badgeEl.classList.add('badge-expired'); }
            if (summarySubscribedDateEl) summarySubscribedDateEl.textContent = formatDate(subscribedDate); if (summaryExpiresDateEl) summaryExpiresDateEl.textContent = formatDate(endDate);
            const daysLeft = calculateDaysLeft(endDate), effectiveSubscriptionStatus = getSubscriptionEffectiveStatus(daysLeft); unitElement.dataset.effectiveStatus = effectiveSubscriptionStatus;
            if (summaryStatusTextEl) { if (daysLeft === null) summaryStatusTextEl.textContent = "N/A"; else if (effectiveSubscriptionStatus === 'inactive') summaryStatusTextEl.textContent = `Expired`; else if (effectiveSubscriptionStatus === 'expiry-soon') summaryStatusTextEl.textContent = `Expires Soon`; else summaryStatusTextEl.textContent = `Active`; }
            const detailedDaysLeftDisplay = contentWrapperEl.querySelector('.unit-subscription-info .days-left-display'); if(detailedDaysLeftDisplay) { detailedDaysLeftDisplay.classList.remove('days-left-expired', 'days-left-expiry-soon'); if (daysLeft === null) detailedDaysLeftDisplay.textContent = "N/A"; else if (effectiveSubscriptionStatus === 'inactive') { detailedDaysLeftDisplay.textContent = `Expired (${Math.abs(daysLeft-1)+1} days ago)`; detailedDaysLeftDisplay.classList.add('days-left-expired'); } else if (effectiveSubscriptionStatus === 'expiry-soon') { detailedDaysLeftDisplay.textContent = `${daysLeft} days left (Expires Soon!)`; detailedDaysLeftDisplay.classList.add('days-left-expiry-soon'); } else detailedDaysLeftDisplay.textContent = `${daysLeft} days left`; }
            primaryActionButtonHTML = `<button type="button" class="action-button summary-action-btn activation-btn inactive-state" onclick="toggleUnitActivation('${unitId}', this)"><span class="btn-icon">🔴</span><span>Deactivate</span></button>`;
            const subscriptionChoices = [ { value: 'free_trial', label: 'Trial' }, { value: 'basic', label: 'Basic' }, { value: 'pro', label: 'Pro' }, { value: 'ultra_pro', label: 'Ultra Pro' } ];
            let choiceHTML = '<div class="unit-subscription-choice-group">'; subscriptionChoices.forEach(choice => { choiceHTML += `<input type="radio" id="${unitId}_subchoice_${choice.value}" name="${unitId}_subchoice" value="${choice.value}" ${subType === choice.value ? 'checked' : ''} onchange="handleSubscriptionChoiceChange('${unitId}', '${choice.value}')"><label for="${unitId}_subchoice_${choice.value}">${choice.label}</label>`; }); choiceHTML += '</div>';
            if(secondaryActionsBar) { secondaryActionsBar.innerHTML = choiceHTML; secondaryActionsBar.innerHTML += `<button type="button" class="unit-action-btn renew" onclick="openRenewConfirmationModal('${unitId}')"><span class="btn-icon">🔄</span><span>Renew</span></button>`; }
            renderUnitFeatures(unitElement, subType); 
        }
        summaryActionsContainer.insertAdjacentHTML('beforeend', editButtonHTML + primaryActionButtonHTML + togglerIconHTML);
    }
    function toggleUnitActivation(unitId, buttonElement) { 
        const unitElement = document.getElementById(unitId); if (!unitElement) return;
        const currentStatus = unitElement.dataset.status, newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        unitElement.dataset.status = newStatus;
        if (newStatus === 'active' && !unitElement.dataset.subscriptionType) { unitElement.dataset.subscriptionType = 'free_trial'; unitElement.dataset.subscribedDate = getTodayDateString(); unitElement.dataset.subscriptionEndDate = calculateEndDate(getTodayDateString(), 'free_trial'); }
        updateUnitDisplayAndSubscriptionInfo(unitElement); 
        const regionalEl = unitElement.closest('.regional-office'); if (regionalEl) { updateRegionalEntityCounts(regionalEl); const corporateEl = regionalEl.closest('.corporate-entity'); if (corporateEl) updateCorporateEntityCounts(corporateEl); }
        applyAllFilters(); updateSuperAdminDashboardStats();
    }
    function toggleActivation(entityId, entityType, buttonElement) { const entityElement = document.getElementById(entityId); if (!entityElement) return; const currentStatus = entityElement.dataset.status, newStatus = currentStatus === 'active' ? 'inactive' : 'active'; entityElement.dataset.status = newStatus; buttonElement.classList.toggle('active-state', newStatus === 'active'); buttonElement.classList.toggle('inactive-state', newStatus === 'inactive'); buttonElement.innerHTML = `<span class="btn-icon">${newStatus === 'active' ? '🟢' : '🔴'}</span><span>${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`; applyAllFilters(); updateAllCountsAndDisplays(); }
    function setSpanText(spanId, label, count) { const spanEl = document.getElementById(spanId); if (spanEl) { const labelEl = spanEl.querySelector('.count-label'); if (labelEl) spanEl.innerHTML = `<span class="count-label">${label} </span>${count}`; else spanEl.textContent = `${label} ${count}`; }}
    function updateRegionalEntityCounts(regionalElement) {
        if (!regionalElement) return { active: 0, inactive: 0, expiry: 0, pending: 0 };
        const regionalId = regionalElement.id; let counts = { active: 0, inactive: 0, expiry: 0, pending: 0 };
        regionalElement.querySelectorAll('.unit-list .unit-item-container:not(.hidden-by-filter)').forEach(unit => { const mS = unit.dataset.status, eSS = unit.dataset.effectiveStatus; if (mS === 'pending-approval') counts.pending++; else if (mS === 'active') { if (eSS === 'active') counts.active++; else if (eSS === 'expiry-soon') counts.expiry++; else if (eSS === 'inactive') counts.inactive++; } else if (mS === 'inactive') counts.inactive++; });
        setSpanText(`${regionalId}-unit-count-pending`, 'Pending:', counts.pending); setSpanText(`${regionalId}-unit-count-active`, 'Active:', counts.active); setSpanText(`${regionalId}-unit-count-inactive`, 'Expired/Off:', counts.inactive); setSpanText(`${regionalId}-unit-count-expiry`, 'Expiry Soon:', counts.expiry);
        return counts;
    }
    function updateCorporateEntityCounts(corpElement) { if (!corpElement) return; const corpId = corpElement.id; const regionalOffices = corpElement.querySelectorAll('.regional-container .entity-level.regional-office:not(.hidden-by-filter)'); let totalCounts = { active: 0, inactive: 0, expiry: 0, pending: 0 }; regionalOffices.forEach(ro => { const regCounts = updateRegionalEntityCounts(ro); totalCounts.active += regCounts.active; totalCounts.inactive += regCounts.inactive; totalCounts.expiry += regCounts.expiry; totalCounts.pending += regCounts.pending; }); setSpanText(`${corpId}-regional-count`, 'Regionals:', regionalOffices.length); setSpanText(`${corpId}-total-unit-count-pending`, 'Pending:', totalCounts.pending); setSpanText(`${corpId}-total-unit-count-active`, 'Active Units:', totalCounts.active); setSpanText(`${corpId}-total-unit-count-inactive`, 'Expired/Off Units:', totalCounts.inactive); setSpanText(`${corpId}-total-unit-count-expiry`, 'Expiry Soon:', totalCounts.expiry); }
    function updateSuperAdminDashboardStats() {
        const allCorporates = document.querySelectorAll('.corporate-entity'), allRegionals = document.querySelectorAll('.regional-office'), allUnits = document.querySelectorAll('.unit-item-container'); 
        let totalActiveUnits = 0, totalPendingUnits = 0, totalInactiveOrExpiredUnits = 0;
        allUnits.forEach(unit => { const mS = unit.dataset.status, eSS = unit.dataset.effectiveStatus; if (mS === 'pending-approval') totalPendingUnits++; else if (mS === 'active') { if (eSS === 'active' || eSS === 'expiry-soon') totalActiveUnits++; else if (eSS === 'inactive') totalInactiveOrExpiredUnits++; } else if (mS === 'inactive') totalInactiveOrExpiredUnits++; });
        document.getElementById('dashStatTotalCorporates').textContent = allCorporates.length; document.getElementById('dashStatTotalRegionals').textContent = allRegionals.length; document.getElementById('dashStatTotalUnits').textContent = allUnits.length; document.getElementById('dashStatActiveUnits').textContent = totalActiveUnits; document.getElementById('dashStatPendingUnits').textContent = totalPendingUnits; document.getElementById('dashStatInactiveUnits').textContent = totalInactiveOrExpiredUnits;
    }
    function updateAllCountsAndDisplays() { 
        const trialUnit = document.getElementById('unit_trial_active'); if (trialUnit && !trialUnit.dataset.subscribedDate) { const today = new Date(); today.setDate(today.getDate() - (subscriptionSettings.freeTrial.validityDays - 4) ); trialUnit.dataset.subscribedDate = today.toISOString().split('T')[0]; trialUnit.dataset.subscriptionEndDate = calculateEndDate(trialUnit.dataset.subscribedDate, "free_trial"); }
        const proUnit = document.getElementById('unit_pro_active'); if (proUnit && proUnit.dataset.subscribedDate === "2023-03-01" && !proUnit.dataset.subscriptionEndDate) proUnit.dataset.subscriptionEndDate = calculateEndDate("2023-03-01", "pro");
        const basicUnit = document.getElementById('unit_basic_active'); if (basicUnit && !basicUnit.dataset.subscribedDate && !basicUnit.dataset.subscriptionEndDate) { const today = new Date(); today.setDate(today.getDate() - (subscriptionSettings.basic.validityDays - 10)); basicUnit.dataset.subscribedDate = today.toISOString().split('T')[0]; basicUnit.dataset.subscriptionEndDate = calculateEndDate(basicUnit.dataset.subscribedDate, "basic"); }
        const expiredUnit = document.getElementById('unit_expired'); if (expiredUnit && expiredUnit.dataset.subscribedDate === "2023-09-01" && !expiredUnit.dataset.subscriptionEndDate) { const pastSubDate = new Date("2023-09-01T00:00:00Z"), basicValidity = subscriptionSettings.basic.validityDays || 30, intendedEndDate = new Date(pastSubDate); intendedEndDate.setUTCDate(intendedEndDate.getUTCDate() + basicValidity -1); const todayForComparison = new Date(); todayForComparison.setUTCHours(0,0,0,0); if (intendedEndDate >= todayForComparison) { const forcedSubDate = new Date(); forcedSubDate.setUTCDate(forcedSubDate.getUTCDate() - (basicValidity + 5)); expiredUnit.dataset.subscribedDate = forcedSubDate.toISOString().split('T')[0]; } else expiredUnit.dataset.subscribedDate = pastSubDate.toISOString().split('T')[0]; expiredUnit.dataset.subscriptionEndDate = calculateEndDate(expiredUnit.dataset.subscribedDate, "basic"); }
        document.querySelectorAll('.unit-item-container').forEach(updateUnitDisplayAndSubscriptionInfo); 
        document.querySelectorAll('.corporate-entity, .regional-office').forEach(el => updateEntityLogoDisplay(el.querySelector('summary'), el.dataset.logoSrc));
        document.querySelectorAll('.corporate-entity:not(.hidden-by-filter)').forEach(updateCorporateEntityCounts);
        updateSuperAdminDashboardStats();
    }
    function openRenewConfirmationModal(unitId) {
        const unitEl = document.getElementById(unitId); if (!unitEl) { alert("Error: Unit not found."); return; }
        const unitName = unitEl.querySelector('.unit-name-display').textContent, currentSubType = unitEl.dataset.subscriptionType, currentEndDate = unitEl.dataset.subscriptionEndDate, planSettingsKey = getPlanSettingsKey(currentSubType);
        if (!currentSubType || !planSettingsKey || !subscriptionSettings[planSettingsKey]) { alert(`Error: Subscription type "${currentSubType}" details not found for unit ${unitName}. Cannot renew.`); return; }
        let newSubStartDate; const daysLeft = currentEndDate ? calculateDaysLeft(currentEndDate) : -1;
        if (currentEndDate && daysLeft > 0) { const cEDObj = new Date(currentEndDate + 'T00:00:00Z'); cEDObj.setUTCDate(cEDObj.getUTCDate() + 1); newSubStartDate = cEDObj.toISOString().split('T')[0]; } else newSubStartDate = getTodayDateString();
        const nextValidDate = calculateEndDate(newSubStartDate, currentSubType);
        document.getElementById('renewUnitNameDisplay').textContent = unitName; document.getElementById('renewCurrentSubTypeDisplay').textContent = subscriptionSettings[planSettingsKey]?.displayName || currentSubType; document.getElementById('renewLastSubscribedDateDisplay').textContent = formatDate(newSubStartDate); document.getElementById('renewNextValidDateDisplay').textContent = nextValidDate ? formatDate(nextValidDate) : 'N/A';
        document.getElementById('renewConfirmUnitId').value = unitId; document.getElementById('renewConfirmNewSubDate').value = newSubStartDate; document.getElementById('renewConfirmNewEndDate').value = nextValidDate || ''; document.getElementById('renewConfirmSubType').value = currentSubType;
        openModal('renewConfirmModal');
    }
    function processUnitRenewal() {
        const unitId = document.getElementById('renewConfirmUnitId').value, newSubDate = document.getElementById('renewConfirmNewSubDate').value, newEndDate = document.getElementById('renewConfirmNewEndDate').value, subType = document.getElementById('renewConfirmSubType').value;
        const unitEl = document.getElementById(unitId); if (!unitEl) { alert("Error: Unit not found during renewal process."); closeModal('renewConfirmModal'); return; }
        unitEl.dataset.subscribedDate = newSubDate; unitEl.dataset.subscriptionEndDate = newEndDate; unitEl.dataset.subscriptionType = subType;
        updateUnitDisplayAndSubscriptionInfo(unitEl);
        const regionalEl = unitEl.closest('.regional-office'); if (regionalEl) { updateRegionalEntityCounts(regionalEl); const corporateEl = regionalEl.closest('.corporate-entity'); if (corporateEl) updateCorporateEntityCounts(corporateEl); }
        updateSuperAdminDashboardStats(); closeModal('renewConfirmModal');
    }

    function populateCorporateFilter() { const filterEl = document.getElementById('filterCorporate'); if (!filterEl) return; filterEl.innerHTML = '<option value="all">All Corporates</option>'; document.querySelectorAll('.corporate-entity:not(.hidden-by-filter)').forEach(corp => { filterEl.innerHTML += `<option value="${corp.id}">${corp.querySelector('.entity-name-display').textContent}</option>`; }); }
    function populateRegionalFilter() { const filterEl = document.getElementById('filterRegional'); if (!filterEl) return; filterEl.innerHTML = '<option value="all">All Regionals</option>'; document.querySelectorAll('.regional-office:not(.hidden-by-filter)').forEach(reg => { const corpName = reg.closest('.corporate-entity')?.querySelector('.entity-name-display').textContent || 'Unknown'; filterEl.innerHTML += `<option value="${reg.id}">${reg.querySelector('.entity-name-display').textContent} (${corpName})</option>`; }); }
    function applyCorporateFilter(corpId) { if (corpId === 'all') document.querySelectorAll('.corporate-entity, .regional-office, .unit-item-container').forEach(el => el.classList.remove('hidden-by-filter')); else { document.querySelectorAll('.corporate-entity').forEach(corp => corp.classList.toggle('hidden-by-filter', corp.id !== corpId)); document.querySelectorAll('.regional-office').forEach(reg => reg.classList.toggle('hidden-by-filter', !reg.closest(`#${corpId}`))); document.querySelectorAll('.unit-item-container').forEach(unit => unit.classList.toggle('hidden-by-filter', !unit.closest(`#${corpId}`))); } populateRegionalFilter(); updateAllCountsAndDisplays(); }
    function applyRegionalFilter(regId) { if (regId === 'all') document.querySelectorAll('.regional-office, .unit-item-container').forEach(el => el.classList.remove('hidden-by-filter')); else { document.querySelectorAll('.regional-office').forEach(reg => reg.classList.toggle('hidden-by-filter', reg.id !== regId)); document.querySelectorAll('.unit-item-container').forEach(unit => unit.classList.toggle('hidden-by-filter', !unit.closest(`#${regId}`))); } updateAllCountsAndDisplays(); }
    function applyUnitNameFilter(searchTerm) { if (!searchTerm) { document.querySelectorAll('.unit-item-container').forEach(unit => unit.classList.remove('hidden-by-filter')); return; } const term = searchTerm.toLowerCase(); document.querySelectorAll('.unit-item-container').forEach(unit => unit.classList.toggle('hidden-by-filter', !unit.querySelector('.unit-name-display').textContent.toLowerCase().includes(term))); updateAllCountsAndDisplays(); }
    function applyAllFilters() { const corpFV = document.getElementById('filterCorporate').value, regFV = document.getElementById('filterRegional').value, unitFV = document.getElementById('filterUnit').value; if (corpFV !== 'all') { applyCorporateFilter(corpFV); if (regFV !== 'all') applyRegionalFilter(regFV); } else if (regFV !== 'all') applyRegionalFilter(regFV); if (unitFV) applyUnitNameFilter(unitFV); updateAllCountsAndDisplays(); }
    function clearAllFilters() { document.getElementById('filterCorporate').value = 'all'; document.getElementById('filterRegional').value = 'all'; document.getElementById('filterUnit').value = ''; document.querySelectorAll('.corporate-entity, .regional-office, .unit-item-container').forEach(el => el.classList.remove('hidden-by-filter')); updateAllCountsAndDisplays(); }

    function downloadCsv(filename, content) { const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' }); const url = URL.createObjectURL(blob); const link = document.createElement('a'); link.setAttribute('href', url); link.setAttribute('download', filename); link.style.visibility = 'hidden'; document.body.appendChild(link); link.click(); document.body.removeChild(link); }
    function downloadFullSampleCsv() { const csvContent = `Level,ParentName,Name,Address,ContactPerson,Email,Phone,Description,LogoURL\nCorporate,,Global Corp Inc.,1 Corporate Way, Mr. CEO,ceo@global.com,+1234567890,"Global headquarters",\nRegional,Global Corp Inc.,North America Div,123 NA Street, Jane Doe,jane@na.com,+1987654321,"NA operations",\nUnit,North America Div,NYC Office,1 Broadway, John Smith,john@ny.com,+12125551234,"NYC branch office",\nRegional,Global Corp Inc.,Europe Div,45 EU Avenue, Hans Schmidt,hans@eu.com,+4912345678,"European HQ",\nUnit,Europe Div,Paris Office,1 Champs Elysees, Pierre Dupont,pierre@paris.com,+33123456789,"French operations"`; downloadCsv('full_corporate_structure_sample.csv', csvContent); }
    function downloadRegionalSampleCsv(corpId, corpName) { const csvContent = `Level,ParentName,Name,Address,ContactPerson,Email,Phone,Description,LogoURL\nRegional,${corpName},New Regional Division,123 Main St, Regional Manager,manager@regional.com,+1555123456,"Regional description",\nUnit,New Regional Division,New Unit,456 Unit Ave, Unit Manager,manager@unit.com,+1555987654,"Unit description"`; downloadCsv(`regional_units_sample_for_${corpName.replace(/[^a-z0-9]/gi, '_')}.csv`, csvContent); }
    function downloadUnitSampleCsv(regId, regName) { const csvContent = `Level,ParentName,Name,Address,ContactPerson,Email,Phone,Description,LogoURL\nUnit,${regName},New Unit,789 Unit Lane, Unit Head,head@unit.com,+1555111222,"Unit details"`; downloadCsv(`units_sample_for_${regName.replace(/[^a-z0-9]/gi, '_')}.csv`, csvContent); }
    
    function parseCsvFile(file, callback) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const lines = e.target.result.split('\n');
                const headers = lines[0].split(',').map(h => h.trim());
                if (!headers.includes('Level') || !headers.includes('Name')) throw new Error('CSV must contain "Level" and "Name" columns.');
                const dataRows = [];
                for (let i = 1; i < lines.length; i++) {
                    if (!lines[i].trim()) continue;
                    const values = lines[i].split(','); const entity = {};
                    headers.forEach((header, index) => entity[header] = values[index] ? values[index].trim() : '');
                    dataRows.push(entity);
                }
                callback(null, dataRows);
            } catch (error) { callback(error, null); }
        };
        reader.readAsText(file);
    }
    function processCsvUpload(fileInputId, statusElId, processFn) {
        const fileInput = document.getElementById(fileInputId), statusEl = document.getElementById(statusElId);
        if (!fileInput.files.length) { statusEl.textContent = 'Please select a CSV file.'; statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828'; return; }
        parseCsvFile(fileInput.files[0], (error, dataRows) => {
            if (error) { console.error('Error parsing CSV:', error); statusEl.innerHTML = 'Error parsing CSV: ' + error.message; statusEl.style.backgroundColor = '#ffebee'; statusEl.style.color = '#c62828'; return; }
            processFn(dataRows, statusEl);
        });
    }
    function handleSuperAdminCsvUpload() { processCsvUpload('superAdminFileCsv', 'superAdminCsvUploadStatus', (dataRows, statusEl) => { const counts = { corps: 0, regionals: 0, units: 0 }; dataRows.forEach(row => { if (row.Level === 'Corporate') { processCorporateFromCsv(row); counts.corps++; } else if (row.Level === 'Regional') { processRegionalFromCsv(row); counts.regionals++; } else if (row.Level === 'Unit') { processUnitFromCsv(row); counts.units++; } }); statusEl.innerHTML = `Successfully processed CSV!<br>Corporates: ${counts.corps}<br>Regionals: ${counts.regionals}<br>Units: ${counts.units}`; statusEl.style.backgroundColor = '#e8f5e9'; statusEl.style.color = '#2e7d32'; populateCorporateFilter(); populateRegionalFilter(); updateAllCountsAndDisplays(); }); }
    function handleUploadRegionalsCsv() { const corpName = document.getElementById('uploadRegionalsCorporateName').value; processCsvUpload('uploadRegionalsFileCsv', 'uploadRegionalsStatus', (dataRows, statusEl) => { const counts = { regionals: 0, units: 0 }; dataRows.forEach(row => { if (row.Level === 'Regional') { row.ParentName = corpName; processRegionalFromCsv(row); counts.regionals++; } else if (row.Level === 'Unit') { processUnitFromCsv(row); counts.units++; } }); statusEl.innerHTML = `Successfully processed CSV!<br>Regionals: ${counts.regionals}<br>Units: ${counts.units}`; statusEl.style.backgroundColor = '#e8f5e9'; statusEl.style.color = '#2e7d32'; const corpEl = document.getElementById(document.getElementById('uploadRegionalsCorporateId').value); if (corpEl) updateCorporateEntityCounts(corpEl); populateRegionalFilter(); updateAllCountsAndDisplays(); }); }
    function handleUploadUnitsCsv() { const regName = document.getElementById('uploadUnitsRegionalName').value; processCsvUpload('uploadUnitsFileCsv', 'uploadUnitsStatus', (dataRows, statusEl) => { let unitCount = 0; dataRows.forEach(row => { if (row.Level === 'Unit') { row.ParentName = regName; processUnitFromCsv(row); unitCount++; } }); statusEl.innerHTML = `Successfully processed CSV!<br>Units: ${unitCount}`; statusEl.style.backgroundColor = '#e8f5e9'; statusEl.style.color = '#2e7d32'; const regEl = document.getElementById(document.getElementById('uploadUnitsRegionalId').value); if (regEl) { updateRegionalEntityCounts(regEl); const corpEl = regEl.closest('.corporate-entity'); if (corpEl) updateCorporateEntityCounts(corpEl); } updateAllCountsAndDisplays(); }); }
    
    function openSuperAdminCsvUploadModal() { document.getElementById('superAdminCsvUploadForm').reset(); document.getElementById('superAdminCsvUploadStatus').innerHTML = ''; openModal('superAdminCsvUploadModal'); }
    function openUploadRegionalsCsvModal(corpId, corpName) { document.getElementById('uploadRegionalsForm').reset(); document.getElementById('uploadRegionalsStatus').innerHTML = ''; document.getElementById('uploadRegionalsCorporateId').value = corpId; document.getElementById('uploadRegionalsCorporateName').value = corpName; document.getElementById('uploadRegionalsTargetCorpName').textContent = corpName; document.getElementById('uploadRegionalsTargetCorpNameMirror').textContent = corpName; document.getElementById('downloadSampleRegionalScoped').onclick = () => downloadRegionalSampleCsv(corpId, corpName); openModal('uploadRegionalsModal'); }
    function openUploadUnitsCsvModal(regId, regName) { document.getElementById('uploadUnitsForm').reset(); document.getElementById('uploadUnitsStatus').innerHTML = ''; document.getElementById('uploadUnitsRegionalId').value = regId; document.getElementById('uploadUnitsRegionalName').value = regName; document.getElementById('uploadUnitsTargetRegionalName').textContent = regName; document.getElementById('uploadUnitsTargetRegionalNameMirror').textContent = regName; document.getElementById('downloadSampleUnitScoped').onclick = () => downloadUnitSampleCsv(regId, regName); openModal('uploadUnitsModal'); }

    function processCorporateFromCsv(csvRow) {
        const existingCorp = Array.from(document.querySelectorAll('.corporate-entity .entity-name-display')).find(el => el.textContent === csvRow.Name); if (existingCorp) return existingCorp.closest('.corporate-entity').id;
        const corpId = generateId('corp'), nameEscaped = csvRow.Name.replace(/'/g, "\\'");
        const corpHTML = `<details class="entity-level corporate-entity" id="${corpId}" data-status="active" data-logo-src="${csvRow.LogoURL || ''}"> <summary class="entity-summary"> <div class="summary-content-wrapper"> <img src="${csvRow.LogoURL || '#'}" alt="" class="entity-logo-display" style="display:${csvRow.LogoURL ? 'block' : 'none'}; width: 32px; height: 32px; border-radius: var(--border-radius); margin-right: 0.5rem;"> <span class="entity-icon" style="display:${csvRow.LogoURL ? 'none' : 'block'};">🏛️</span> <span class="entity-name-display">${csvRow.Name}</span> </div> <div class="summary-actions"> <span class="entity-count regional-count" id="${corpId}-regional-count"><span class="count-label">Regionals: </span>0</span> <span class="entity-count unit-count-pending" id="${corpId}-total-unit-count-pending"><span class="count-label">Pending: </span>0</span> <span class="entity-count unit-count-active" id="${corpId}-total-unit-count-active"><span class="count-label">Active: </span>0</span> <span class="entity-count unit-count-expiry" id="${corpId}-total-unit-count-expiry"><span class="count-label">Expiry Soon: </span>0</span> <span class="entity-count unit-count-inactive" id="${corpId}-total-unit-count-inactive"><span class="count-label">Expired/Off: </span>0</span> <button type="button" class="edit-btn" onclick="openEditModal('corporate', '${corpId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" onclick="openAddModal('regional', '${corpId}', '${nameEscaped}')" class="action-button summary-action-btn add-regional"><span class="btn-icon">➕</span><span>Add Regional</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${corpId}', 'corporate', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary> <div class="scoped-upload-section"> <h4>Bulk Add Regionals & Units to this Corporate</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="downloadRegionalSampleCsv('${corpId}', '${nameEscaped}')">📄 Sample CSV for Regionals</button> <button type="button" class="action-button upload-scoped" onclick="openUploadRegionalsCsvModal('${corpId}', '${nameEscaped}')">⬆️ Upload Regionals CSV</button> </div> </div> <div class="entity-content-wrapper"> <div class="entity-details-grid"> <div class="detail-item" data-field="address"><strong><span class="detail-icon">📍</span>Address:</strong> <span class="value-display">${csvRow.Address || 'Not Set'}</span></div> <div class="detail-item" data-field="contactPerson"><strong><span class="detail-icon">👤</span>Contact Person:</strong> <span class="value-display">${csvRow.ContactPerson || 'Not Set'}</span></div> <div class="detail-item" data-field="email"><strong><span class="detail-icon">✉️</span>Email:</strong> <a href="${csvRow.Email ? 'mailto:'+csvRow.Email : '#'}" class="value-display">${csvRow.Email || 'Not Set'}</a></div> <div class="detail-item" data-field="phone"><strong><span class="detail-icon">📞</span>Phone:</strong> <a href="${csvRow.Phone ? 'tel:'+csvRow.Phone : '#'}" class="value-display">${csvRow.Phone || 'Not Set'}</a></div> </div> <p class="entity-description" data-field="description">${csvRow.Description || 'No description provided.'}</p> <div class="regional-container"></div> </div> </details>`;
        const mainContentArea = document.getElementById('mainContentArea'), firstCorp = mainContentArea.querySelector('.corporate-entity'), dashboardDetails = document.querySelector('.super-admin-dashboard-details'), topActions = document.querySelector('.top-action-buttons-grid');
        if (firstCorp) firstCorp.insertAdjacentHTML('beforebegin', corpHTML); else if(dashboardDetails) dashboardDetails.insertAdjacentHTML('afterend', corpHTML); else if (topActions) topActions.insertAdjacentHTML('afterend', corpHTML); return corpId;
    }
    function processRegionalFromCsv(csvRow) {
        const corporateEl = Array.from(document.querySelectorAll('.corporate-entity')).find(corp => corp.querySelector('.entity-name-display').textContent === csvRow.ParentName); if (!corporateEl) { console.error(`Corporate parent "${csvRow.ParentName}" not found for regional "${csvRow.Name}"`); return null; }
        const existingReg = Array.from(corporateEl.querySelectorAll('.regional-office .entity-name-display')).find(el => el.textContent === csvRow.Name); if (existingReg) return existingReg.closest('.regional-office').id;
        const regId = generateId('reg'), nameEscaped = csvRow.Name.replace(/'/g, "\\'");
        const regHTML = `<details class="entity-level regional-office" id="${regId}" data-status="active" data-logo-src="${csvRow.LogoURL || ''}"> <summary class="entity-summary"> <div class="summary-content-wrapper"> <img src="${csvRow.LogoURL || '#'}" alt="" class="entity-logo-display" style="display:${csvRow.LogoURL ? 'block' : 'none'}; width: 28px; height: 28px; border-radius: var(--border-radius); margin-right: 0.5rem;"> <span class="entity-icon" style="display:${csvRow.LogoURL ? 'none' : 'block'};">🌍</span> <span class="entity-name-display">${csvRow.Name}</span> </div> <div class="summary-actions"> <span class="entity-count unit-count-pending" id="${regId}-unit-count-pending"><span class="count-label">Pending: </span>0</span> <span class="entity-count unit-count-active" id="${regId}-unit-count-active"><span class="count-label">Active: </span>0</span> <span class="entity-count unit-count-expiry" id="${regId}-unit-count-expiry"><span class="count-label">Expiry Soon: </span>0</span> <span class="entity-count unit-count-inactive" id="${regId}-unit-count-inactive"><span class="count-label">Expired/Off: </span>0</span> <button type="button" class="edit-btn" onclick="openEditModal('regional', '${regId}')"><span class="btn-icon">✏️</span><span>Edit</span></button> <button type="button" onclick="openAddModal('unit', '${regId}', '${nameEscaped}')" class="action-button summary-action-btn add-unit"><span class="btn-icon">➕</span><span>Add Unit</span></button> <button type="button" class="action-button summary-action-btn activation-btn active-state" onclick="toggleActivation('${regId}', 'regional', this)"><span class="btn-icon">🟢</span><span>Active</span></button> <span class="toggler-icon">▶</span> </div> </summary> <div class="scoped-upload-section"> <h4>Bulk Add Units to this Regional</h4> <div class="button-pair"> <button type="button" class="action-button download-sample" onclick="downloadUnitSampleCsv('${regId}', '${nameEscaped}')">📄 Sample CSV for Units</button> <button type="button" class="action-button upload-scoped" onclick="openUploadUnitsCsvModal('${regId}', '${nameEscaped}')">⬆️ Upload Units CSV</button> </div> </div> <div class="entity-content-wrapper"> <div class="entity-details-grid"> <div class="detail-item" data-field="address"><strong><span class="detail-icon">📍</span>Address:</strong> <span class="value-display">${csvRow.Address || 'Not Set'}</span></div> <div class="detail-item" data-field="contactPerson"><strong><span class="detail-icon">👤</span>Contact:</strong> <span class="value-display">${csvRow.ContactPerson || 'Not Set'}</span></div> <div class="detail-item" data-field="email"><strong><span class="detail-icon">✉️</span>Email:</strong> <a href="${csvRow.Email ? 'mailto:'+csvRow.Email : '#'}" class="value-display">${csvRow.Email || 'Not Set'}</a></div> <div class="detail-item" data-field="phone"><strong><span class="detail-icon">📞</span>Phone:</strong> <a href="${csvRow.Phone ? 'tel:'+csvRow.Phone : '#'}" class="value-display">${csvRow.Phone || 'Not Set'}</a></div> </div> <p class="entity-description" data-field="description">${csvRow.Description || 'No description.'}</p> <h3 class="unit-section-header">Operational Units:</h3> <ul class="unit-list"></ul> </div> </details>`;
        corporateEl.querySelector('.regional-container').insertAdjacentHTML('beforeend', regHTML); return regId;
    }
    function processUnitFromCsv(csvRow) {
        const regionalEl = Array.from(document.querySelectorAll('.regional-office')).find(reg => reg.querySelector('.entity-name-display').textContent === csvRow.ParentName); if (!regionalEl) { console.error(`Regional parent "${csvRow.ParentName}" not found for unit "${csvRow.Name}"`); return null; }
        const unitId = generateId('unit');
        const unitHTML = `<details class="unit-item-container" id="${unitId}" data-status="pending-approval" data-effective-status="pending-approval" data-subscription-type="free_trial" data-logo-src="${csvRow.LogoURL || ''}"> <summary class="unit-summary"> <div class="summary-content-wrapper"> <img src="${csvRow.LogoURL || '#'}" alt="" class="entity-logo-display" style="display:${csvRow.LogoURL ? 'block':'none'}; width: 28px; height: 28px; border-radius: var(--border-radius); margin-right: 0.5rem;"> <span class="entity-icon unit-icon" style="display:${csvRow.LogoURL ? 'none':'block'};">⚙️</span> <span class="unit-name-display">${csvRow.Name}</span> <span class="unit-summary-subscription-info" style="display: none;"> S: <span class="summary-subscribed-date"></span> | E: <span class="summary-expires-date"></span> | St: <span class="summary-status-text"></span> </span> </div> <div class="summary-actions"> <span class="subscription-badge badge-pending-approval">Pending</span> </div> </summary> <div class="unit-details-content-wrapper"> <div class="unit-subscription-info" style="display:none;"> <div><strong>Subscribed:</strong> <span class="subscribed-date-display"></span></div> <div><strong>Expires:</strong> <span class="expires-date-display"></span></div> <div><strong>Status:</strong> <span class="days-left-display"></span></div> </div> <div class="unit-contact-details"> <div data-field="contactPerson"><span class="detail-icon">👤</span><span class="value-display">${csvRow.ContactPerson || 'Not Set'}</span></div> <div data-field="email"><span class="detail-icon">✉️</span><a href="${csvRow.Email ? 'mailto:'+csvRow.Email : '#'}" class="value-display">${csvRow.Email || 'Not Set'}</a></div> <div data-field="address"><span class="detail-icon">📍</span><span class="value-display">${csvRow.Address || 'Not Set'}</span></div> <div data-field="phone"><span class="detail-icon">📞</span><a href="${csvRow.Phone ? 'tel:'+csvRow.Phone : '#'}" class="value-display">${csvRow.Phone || 'Not Set'}</a></div> </div> <div class="unit-active-features" style="display:none;"> <strong>Active Features:</strong> <ul class="active-features-list"></ul> </div> <div class="unit-item-actions-bar-secondary"></div> </div> </details>`;
        regionalEl.querySelector('.unit-list').insertAdjacentHTML('beforeend', unitHTML); return unitId;
    }

    document.addEventListener('DOMContentLoaded', () => {
        filterCorporateEl = document.getElementById('filterCorporate'); filterRegionalEl = document.getElementById('filterRegional'); filterUnitEl = document.getElementById('filterUnit'); clearFiltersButtonEl = document.getElementById('clearFiltersButton');
        if (filterCorporateEl) filterCorporateEl.addEventListener('change', function() { applyCorporateFilter(this.value); filterRegionalEl.value = 'all'; });
        if (filterRegionalEl) filterRegionalEl.addEventListener('change', () => applyRegionalFilter(filterRegionalEl.value));
        if (filterUnitEl) filterUnitEl.addEventListener('input', () => applyUnitNameFilter(filterUnitEl.value));
        if (clearFiltersButtonEl) clearFiltersButtonEl.addEventListener('click', clearAllFilters);
        ['superAdminCsvUploadForm', 'uploadRegionalsForm', 'uploadUnitsForm'].forEach(formId => {
            const form = document.getElementById(formId);
            if (form) form.addEventListener('submit', (event) => {
                event.preventDefault();
                if (formId === 'superAdminCsvUploadForm') handleSuperAdminCsvUpload();
                else if (formId === 'uploadRegionalsForm') handleUploadRegionalsCsv();
                else if (formId === 'uploadUnitsForm') handleUploadUnitsCsv();
            });
        });
        populateCorporateFilter(); populateRegionalFilter(); updateAllCountsAndDisplays();
    });
    window.addEventListener('click', (event) => document.querySelectorAll('.modal').forEach(modal => { if (event.target === modal) closeModal(modal.id); }));
</script>

<script>
    function openAddRegionalModal(corporateId, corporateName) {
        // Set the hidden corporate ID field
        document.getElementById('regionalCorporateId').value = corporateId;

        // Update the modal title with corporate name
        document.getElementById('regionalModalDynamicTitle').textContent = `Add Regional under "${corporateName}"`;

        // Reset the form
        document.querySelector('#addregionaldetails form').reset();

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('addregionaldetails'));
        modal.show();
    }
</script>

<script>
    function openAddUnitModal(corporateId, corporateName,corporateID) {
        // Set the hidden corporate ID field
         document.getElementById('unitregionalCorporateId').value = corporateID;
        document.getElementById('clickregionalId').value = corporateId;

        // Update the modal title with corporate name
        document.getElementById('regionalModalDynamicTitle').textContent = `Add Unit under "${corporateName}"`;

        // Reset the form
        document.querySelector('#addunitdetails form').reset();

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('addunitdetails'));
        modal.show();
    }
</script>

<script>
function saveCorporate() {
    var id = document.getElementById("corporateEntityId").value;
    var name = document.getElementById("corporateNameModal").value;
    var address = document.getElementById("corporateAddressModal").value;
    var contactPerson = document.getElementById("corporateContactPersonModal").value;
    var email = document.getElementById("corporateEmailModal").value;
    var phone = document.getElementById("corporatePhoneModal").value;
    var description = document.getElementById("corporateDescriptionModal").value;

    // Create the data object
    var formData = {
        id: id,
        name: name,
        address: address,
        contact_person: contactPerson,
        email: email,
        phone: phone,
        description: description,
        _token: '{{ csrf_token() }}' // For Laravel CSRF protection
    };

    // Send AJAX request
    fetch("{{ route('edit_users') }}", {
        method: "POST", // or PUT if your route uses PUT
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Update failed: " + data.message);
        }
    })
    .catch(error => {
       location.reload();
    });
}

function saveRegional() {
    var id = document.getElementById("regionalEntityId").value;
    var name = document.getElementById("regionalNameModal").value;
    var address = document.getElementById("regionalAddressModal").value;
    var contactPerson = document.getElementById("regionalContactPersonModal").value;
    var email = document.getElementById("regionalEmailModal").value;
    var phone = document.getElementById("regionalPhoneModal").value;
    var description = document.getElementById("regionalDescriptionModal").value;

    // Create the data object
    var formData = {
        id: id,
        name: name,
        address: address,
        contact_person: contactPerson,
        email: email,
        phone: phone,
        description: description,
        _token: '{{ csrf_token() }}' // For Laravel CSRF protection
    };

    // Send AJAX request
    fetch("{{ route('edit_users') }}", {
        method: "POST", // or PUT if your route uses PUT
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Update failed: " + data.message);
        }
    })
    .catch(error => {
       location.reload();
    });
}
</script>

<script type="text/javascript">
$('#mySelect').change(function() { 
    var id = $(this).val(); // selected corporate ID

    $.ajax({
        type: 'GET',
        url: "{{ route('regional_list') }}",
        data: { id: id },
        dataType: "json",
        success: function(datalist) {
            var data = datalist.data;
            $('#unitRegionalSelect').empty(); // clear existing options

            var selOpts = '<option value="">-- Select Regional --</option>';
            for (var i = 0; i < data.length; i++) {
                var regId = data[i]['id'];
                var regName = data[i]['company_name'];
                selOpts += "<option value='" + regId + "'>" + regName + "</option>";
            }

            $('#unitRegionalSelect').append(selOpts);
        }
    });
});

function openUnitModal(corpId) {
    $('#mySelect').val(corpId).change(); // trigger the change to load regionals
    $('#unitParentId').val(corpId); // set parent ID
    $('#unitModal').show(); // open modal
}


</script>

<script>
    function saveUnit() {
    const unitId = document.getElementById('unitEntityId').value;
    const name = document.getElementById('unitNameModal').value;
    const contactPerson = document.getElementById('unitContactPersonModal').value;
    const email = document.getElementById('unitEmailModal').value;
    const address = document.getElementById('unitAddressModal').value;
    const phone = document.getElementById('unitPhoneModal').value;
    const parentId = document.getElementById('unitParentId').value;
    const regionalId = document.getElementById('unitRegionalSelect').value;
    const subscriptionType = document.getElementById('subscriptionTypeModal').value;
    const subscribedDate = document.getElementById('subscribedDateModal').value;
    const actionType = document.getElementById('unitModalActionType').value;

    if (!name || !regionalId) {
        alert("Please fill all required fields.");
        return;
    }

    const payload = {
        id: unitId,
        name,
        contact_person: contactPerson,
        email,
        address,
        phone,
        corporate_id: parentId,
        regional_id: regionalId,
        subscription_type: subscriptionType,
        subscribed_date: subscribedDate,
        action_type: actionType,
        _token: '{{ csrf_token() }}'
    };

    $.ajax({
        type: 'POST',
        url: "{{ route('edit_users') }}", // 🔁 Replace with your actual save route
        data: payload,
        dataType: 'json',
        success: function (response) {
            location.reload();
            // Optionally refresh unit list here
        },
        error: function (xhr, status, error) {
            
            location.reload();
            
        }
    });
}

</script>

   