
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.6.2/dist/fuse.min.js"></script>
    <style>
        :root {
            /* Variables from Uploader Component */
            --primary-color: #2c3e50; /* Deep blue-gray */
            --secondary-color: #e74c3c; /* Soft red for actions/errors */
            --accent-color: #3498db; /* A brighter blue for links/highlights */
            --hover-color: #c0392b; /* Darker red for hover */
            --light-gray: #f8f9fa; /* Lighter background */
            --medium-gray: #ced4da; /* Borders */
            --dark-gray: #495057;  /* Main text color */
            --fixed-text-color: #6c757d; /* Slightly muted for non-editable template text */
            --border-radius: 8px; /* Slightly more rounded */
            --box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            --transition: all 0.3s ease-in-out;
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

            /* Variables from Details Component */
            --details-primary-color: #4361ee;
            --details-primary-light: #e0e7ff;
            --details-danger-color: #ef233c;
            --details-danger-light: #ffe0e3;
            --details-warning-color: #f77f00;
            --details-warning-light: #fff0e0;
            --details-success-color: #2ecc71;
            --details-gray-100: #f8f9fa;
            --details-gray-200: #e9ecef;
            --details-gray-300: #dee2e6;
            --details-gray-400: #ced4da;
            --details-gray-500: #adb5bd;
            --details-gray-600: #6c757d;
            --details-gray-700: #495057;
            --details-gray-800: #343a40;
            --details-gray-900: #212529;
            --details-border-radius: 0.375rem;
            --details-box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --details-transition: all 0.2s ease-in-out;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.65;
            color: var(--dark-gray);
            background-color: var(--light-gray);
            padding: 1.5rem;
            -webkit-tap-highlight-color: transparent;
        }

        .main-container {
             max-width: 800px;
             margin: 0 auto;
        }
        
        .details-container {
            background-color: white; 
            padding: 1.5rem; 
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow); 
            position: relative;
        }
        
        .form-group { 
            margin-bottom: 28px; 
            position: relative; 
        }
        .form-group:last-child {
            margin-bottom: 0;
        }
        
        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 500;
            color: var(--primary-color); 
            font-size: 0.95em;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.85em;
            margin-top: 6px;
            display: none;
        }

        .complaint-input-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            border: 1px solid var(--details-gray-300); 
            border-radius: var(--details-border-radius); 
            padding: 0.75rem 1rem;
            transition: all 0.2s ease-in-out;
        }
        .complaint-input-wrapper:focus-within {
            border-color: var(--details-primary-color); 
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25); 
        }

        .complaint-box { 
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            line-height: 1.8; 
            min-height: 24px;
        }
        .complaint-box p { 
            margin: 0; 
            display: flex; 
            flex-wrap: wrap; 
            align-items: baseline; 
            gap: 0.5rem; 
        }

        #direct-upload-options-container {
            transition: opacity 0.3s ease, transform 0.3s ease, width 0.3s ease;
            flex-shrink: 0;
        }

        .complaint-input-wrapper.has-media #direct-upload-options-container {
             opacity: 0;
             width: 0;
             overflow: hidden;
             pointer-events: none;
        }
        
        .direct-upload-options {
            display: flex;
            gap: 10px; 
            align-items: center;
        }

        .upload-option-direct {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--details-gray-600);
            transition: background-color 0.2s ease;
        }
        .upload-option-direct:hover {
            background-color: var(--details-gray-200);
        }
        .upload-option-direct svg {
            width: 22px;
            height: 22px;
            fill: currentColor;
        }
       
        .image-collage-preview { 
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px; 
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--details-gray-200);
            align-items: flex-start; 
        }
        
        .add-more-options-wrapper {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            gap: 15px;
            padding-top: 10px;
            border-top: 1px solid var(--light-gray);
            margin-top: 10px;
        }
        
        .preview-item {
            position: relative;
            width: 100%;
            height: 100px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            overflow: hidden;
            background-color: #f8f9fa;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex; 
            justify-content: center;
            align-items: center;
            cursor: pointer; 
        }
        .preview-item img, .preview-item video {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .preview-item-controls { position: absolute; top: 0; right: 0; padding: 4px; display: flex; gap: 4px; z-index: 2; background: linear-gradient(to bottom left, rgba(0,0,0,0.2), transparent 80%); border-top-right-radius: var(--border-radius);}
        
        .remove-preview-btn, .edit-preview-btn, .enlarge-preview-btn {
            background-color: rgba(255, 255, 255, 0.8);
            color: var(--primary-color);
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 12px;
            font-weight: bold;
            line-height: 22px;
            text-align: center;
            cursor: pointer;
            padding: 0;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .remove-preview-btn:hover { background-color: var(--secondary-color); color: white; }
        .edit-preview-btn { font-size: 10px; }
        .enlarge-preview-btn { font-size: 14px; }
        .edit-preview-btn:hover, .enlarge-preview-btn:hover { background-color: var(--accent-color); color: white; }
        
        .pdf-placeholder { width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.8em; padding: 8px; text-align: center; box-sizing: border-box; word-break: break-word; color: var(--fixed-text-color); }
        .pdf-placeholder svg { width: 30px; height: 30px; margin-bottom: 5px; fill: currentColor; }
        .video-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; pointer-events: none; }
        .video-overlay svg { width: 40px; height: 40px; fill: rgba(255,255,255,0.8); }
        .preview-item:hover .video-overlay { opacity: 0; }
        
        #image-preview-modal {
            display: none; position: fixed; z-index: 3000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.85); justify-content: center; align-items: center; animation: fadeIn 0.3s;
        }
        #image-preview-modal .modal-content {
            position: relative; display: flex; justify-content: center; align-items: center; max-width: 90vw; max-height: 90vh;
        }
        #image-preview-modal img, #image-preview-modal video {
            max-width: 100%; max-height: 100%; border-radius: var(--border-radius); box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        #image-preview-modal .close-preview {
            position: absolute; top: 10px; right: 10px; z-index: 10; color: #fff; font-size: 35px; font-weight: bold; cursor: pointer; background-color: rgba(0, 0, 0, 0.6); border-radius: 50%; width: 35px; height: 35px; line-height: 35px; text-align: center; transition: var(--transition); text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }
        #image-preview-modal .close-preview:hover {
            transform: scale(1.1); color: var(--secondary-color);
        }

        .confirmation-dialog, .upload-choice-modal, .image-editor-modal, .collage-maker-container, .video-recorder-modal { 
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); z-index: 2000; justify-content: center; align-items: center; padding: 20px; box-sizing: border-box;
        }
        .confirmation-content, .upload-choice-content, .image-editor-content, .collage-maker-content, .video-recorder-content { 
            background-color: white; border-radius: var(--border-radius); box-shadow: 0 8px 25px rgba(0,0,0,0.15); display: flex; flex-direction: column; overflow: hidden; 
        }

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
        .recording-indicator::before { content: '●'; margin-right: 5px; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }


        /* --- COLLAGE MAKER STYLES --- */
        .collage-maker-content { width: 100%; max-width: 800px; max-height: 90vh; }
        .collage-maker-header { padding: 15px 20px; background-color: var(--primary-color); color: white; display: flex; justify-content: space-between; align-items: center; }
        .collage-maker-header button { background: none; border: none; color: white; font-size: 1.5em; cursor: pointer; padding: 0 5px;}
        .collage-maker-body { flex: 1; display: flex; flex-direction: column; padding: 20px; overflow-y: auto; }
        .collage-preview-area {  flex-shrink: 0; width: 100%; min-height: 300px; aspect-ratio: 1 / 1; max-width: 500px;  margin: 0 auto 20px auto; border: 1px solid var(--medium-gray); border-radius: var(--border-radius); display: flex; justify-content: center; align-items: center; background-color: #f8f9fa; position: relative; overflow: hidden; }
        .collage-preview-area.empty::before { content: "Your collage will appear here"; color: var(--medium-gray); font-size: 1.2em; text-align: center; padding: 10px;}
        #collage-canvas { max-width: 100%; max-height: 100%; display: none; object-fit: contain; cursor: grab; touch-action: none; }
        .collage-controls { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; align-items: center; }
        .collage-controls select { padding: 8px 12px; border-radius: var(--border-radius); border: 1px solid var(--medium-gray); background-color: white; font-size: 0.9em; }
        .collage-maker-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 15px 20px; background-color: #f8f9fa; border-top: 1px solid var(--medium-gray);}
        .collage-maker-footer button { padding: 10px 20px; border-radius: var(--border-radius); cursor: pointer; font-weight: 500; }
        .cancel-collage-btn { background-color: var(--light-gray); border: 1px solid var(--medium-gray); color: var(--dark-gray); }
        .save-collage-btn { background-color: var(--secondary-color); color: white; border: none; }
        .collage-layouts { display: grid; grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); gap: 10px; margin-bottom: 15px;}
        .collage-layout { border: 1px solid var(--medium-gray); border-radius: var(--border-radius); padding: 5px; cursor: pointer; transition: all 0.2s ease; background-color: white;}
        .collage-layout:hover { border-color: var(--accent-color); }
        .collage-layout.active { border-color: var(--accent-color); background-color: rgba(52, 152, 219, 0.1); box-shadow: 0 0 0 2px var(--accent-color); }
        .layout-preview { width: 100%; aspect-ratio: 1 / 1; display: grid; gap: 2px; background-color: var(--medium-gray); position: relative; }
        .layout-cell { background-color: #e9ecef; border-radius: 2px; }
        .layout-diagonal-split .layout-preview { grid-template-columns: 1fr; grid-template-rows: 1fr; }
        .layout-diagonal-split .layout-cell:nth-child(1) { grid-area: 1 / 1 / 2 / 2; clip-path: polygon(0 0, 100% 0, 0 100%); background-color: #e9ecef;}
        .layout-diagonal-split .layout-cell:nth-child(2) { grid-area: 1 / 1 / 2 / 2; clip-path: polygon(100% 0, 100% 100%, 0 100%); background-color: #d8dcdf;}
        .layout-diamond-grid .layout-preview { transform: rotate(45deg) scale(0.7); }
        .layout-diamond-grid .layout-cell { transform: rotate(-45deg); }
        .layout-hex-grid .layout-preview { display: block; }
        .layout-hex-grid .layout-cell { position: absolute; width: 50%; height: 58%; background-color: #e9ecef; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }
        .layout-hex-grid .layout-cell:nth-child(1) { top: 21%; left: 25%; }
        .layout-hex-grid .layout-cell:nth-child(2) { top: 0; left: 0; }
        .layout-hex-grid .layout-cell:nth-child(3) { top: 0; right: 0; }
        .layout-hex-grid .layout-cell:nth-child(4) { bottom: 0; left: 0; }
        .layout-hex-grid .layout-cell:nth-child(5) { bottom: 0; right: 0; }
        .layout-fractured-glass .layout-cell { clip-path: polygon(0 0, 100% 20%, 50% 100%); }
        .layout-fractured-glass .layout-cell:nth-child(2) { clip-path: polygon(100% 20%, 100% 80%, 50% 100%); background: #d8dcdf; }
        .layout-origami-fold .layout-cell:nth-child(1) { clip-path: polygon(0 0, 50% 50%, 0 100%); }
        .layout-origami-fold .layout-cell:nth-child(2) { clip-path: polygon(0 0, 100% 0, 50% 50%); background: #d8dcdf;}


        /* --- IMAGE EDITOR MODAL --- */
        .image-editor-content { max-width: 90vw; width: 100%; min-height: 500px; max-height: 90vh; background-color: #333; }
        .image-editor-header { padding: 12px 20px; background-color: #333; border-bottom: 1px solid #444; color: white; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .image-editor-header h3 { margin: 0; font-size: 1.1em;}
        .image-editor-header button { background: none; border: none; color: #ccc; font-size: 1.5em; cursor: pointer; padding: 0 5px; transition: color 0.2s ease; }
        .image-editor-header button:hover { color: white; }
        .image-editor-body { flex-grow: 1; overflow: hidden; display: flex; background-color: var(--editor-bg); }
        .editor-side-panel { display: flex; flex-direction: column; gap: 15px; padding: 15px; width: 280px; flex-shrink: 0; overflow-y: auto; background-color: #444; }
        #main-editor-toolbar { display: grid; grid-template-columns: repeat(auto-fill, minmax(40px, 1fr)); gap: 8px; padding: 10px; background-color: #3a3a3a; border-radius: var(--border-radius); }
        #main-editor-toolbar button { padding: 8px; border-radius: 4px; border: 1px solid #555; background-color: #525252; color: #eee; cursor: pointer; font-size: 0.85em; transition: all 0.2s ease; aspect-ratio: 1 / 1; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1.2; }
        #main-editor-toolbar button svg { width: 1.8em; height: 1.8em; fill: currentColor; margin-bottom: 2px; }
        #main-editor-toolbar button:hover { background-color: #606060; border-color: #777; }
        #main-editor-toolbar button.active { background-color: var(--accent-color); color: white; border-color: var(--accent-color); }
        #editor-options-area { padding: 15px; background-color: #3a3a3a; border-radius: var(--border-radius); flex-shrink: 0; }
        .editor-options { display: none; padding: 0; }
        .editor-options.active { display: block; }
        .editor-option-group { margin-bottom: 15px; display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .editor-option-group label { margin-bottom: 4px; font-weight: normal; color: #ddd; font-size: 0.9em; flex-shrink: 0; width: 100%;}
        .editor-option-group input, .editor-option-group select, .editor-option-group button {  padding: 6px 8px; border-radius: 4px; border: 1px solid #666; font-size: 0.9em;  box-sizing: border-box; background-color: #525252; color: #fff; width: 100%; }
        .editor-option-group button { background-color: var(--accent-color); border-color: var(--accent-color); cursor: pointer; }
        .editor-option-group p {  width: 100%; text-align: center; font-style: italic; color: #bbb; }
        .editor-option-group input[type="color"] { padding: 0; border: 1px solid #666; height: 32px; min-width: 50px; flex-grow: 1; }
        .editor-option-group input[type="range"] { flex-grow: 1; padding: 0; }
        .editor-option-group .range-value-display { font-size: 0.85em; min-width: 30px; text-align: right; color: #ccc; }
        .editor-option-group input[type="checkbox"] { width: auto; margin-right: 4px; }
        .editor-option-group label[for="shape-fill-enable"] { width: auto; }
        .editor-workspace { flex-grow: 1; display: grid; grid-template-columns: 30px 1fr; grid-template-rows: 30px 1fr; overflow: hidden; position: relative; }
        .editor-workspace-corner { grid-area: 1 / 1 / 2 / 2; background-color: #2a2a2a; border-right: 1px solid #444; border-bottom: 1px solid #444; }
        .editor-ruler.top { grid-area: 1 / 2 / 2 / 3; border-bottom: 1px solid #444; background-color: var(--editor-ruler-bg); background-image: repeating-linear-gradient(to right, var(--editor-ruler-marks) 0, var(--editor-ruler-marks) 1px, transparent 1px, transparent 10px); }
        .editor-ruler.left { grid-area: 2 / 1 / 3 / 2; border-right: 1px solid #444; background-color: var(--editor-ruler-bg); background-image: repeating-linear-gradient(to bottom, var(--editor-ruler-marks) 0, var(--editor-ruler-marks) 1px, transparent 1px, transparent 10px); }
        .image-editor-preview-area {
            grid-area: 2 / 2 / 3 / 3; display: flex; justify-content: center; align-items: center; overflow: auto; padding: 20px;
            background-image: linear-gradient(45deg, var(--editor-checkerboard-dark) 25%, transparent 25%), linear-gradient(-45deg, var(--editor-checkerboard-dark) 25%, transparent 25%), linear-gradient(45deg, transparent 75%, var(--editor-checkerboard-dark) 75%), linear-gradient(-45deg, transparent 75%, var(--editor-checkerboard-dark) 75%);
            background-size: 20px 20px; background-position: 0 0, 0 10px, 10px -10px, -10px 0px; background-color: var(--editor-checkerboard-light);
            position: relative;
        }
        #image-editor-canvas { max-width: 100%; max-height: 100%; object-fit: contain; display: block; background-color: white; cursor: default; box-shadow: 0 5px 20px rgba(0,0,0,0.3); flex-shrink: 0; touch-action: none; }
        .image-editor-footer { padding: 12px 20px; background-color: #333; border-top: 1px solid #444; display: flex; justify-content: flex-end; flex-wrap: wrap; gap: 10px; flex-shrink: 0; }
        .image-editor-footer button { padding: 8px 15px; border-radius: var(--border-radius); cursor: pointer; font-weight: 500; border: 1px solid #666; font-size: 0.9em; background-color: #525252; color: #eee; transition: all 0.2s ease; }
        .image-editor-footer button:hover { background-color: #606060; border-color: #777; }
        #editor-save-changes-btn { background-color: var(--accent-color); border-color: var(--accent-color); color: white; }
        #editor-save-changes-btn:hover { background-color: var(--hover-color); border-color: var(--hover-color); }
        .sub-toolbar { display: none; }


        /* --- Details Component Styles (Scoped) --- */
        .details-container .form-group-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 10px;}
        .details-container .form-label { display: block; font-weight: 600; margin-bottom: 0; font-size: 1rem; color: var(--details-gray-800); }
        .details-container .form-label .required-star { color: var(--details-danger-color); }
        

        #complaint-sentence-template {
            opacity: 0;
            transition: opacity 0.4s ease;
            display: none;
        }
        .complaint-input-wrapper.is-typing #complaint-sentence-template {
            opacity: 1;
            display: inline;
        }

        .details-container .inline-input { 
            border: none; 
            background-color: transparent; 
            font-family: inherit; 
            font-size: inherit; 
            padding: 0; 
            min-width: 150px; 
            color: var(--details-gray-800); 
            display: inline-block;
            width: auto;
        }
        .details-container .inline-input:focus { outline: none; }
        .details-container .inline-input[contenteditable]:empty::before { content: attr(data-placeholder); color: var(--details-gray-500); pointer-events: none; }
        .details-container .highlight { background-color: var(--details-primary-light); border-radius: 0.25rem; font-weight: 500; padding: 0 0.125rem; transition: background-color var(--details-transition); cursor: pointer; }
        .details-container .misspelled { border-bottom: 2px dotted var(--details-danger-color); cursor: pointer; text-decoration: none; background-color: var(--details-danger-light); border-radius: 0.25rem; padding: 0 0.125rem; transition: all var(--details-transition); }
        .details-container .misspelled:hover { background-color: #f8d7da; }
        .details-container .optional-details-section { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--details-gray-200); }
        .details-container .optional-details-section h4 { margin-top: 0; margin-bottom: 0; font-size: 1rem; font-weight: 600; color: var(--details-gray-800); }
        .details-container .optional-selectors-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        .details-container .optional-selector-item > label { display: block; font-size: 0.9rem; font-weight: 500; color: var(--details-gray-700); margin-bottom: 0.25rem; }
        
        /* Multi-select styling */
        .details-container .multi-select-wrapper { position: relative; display: inline-flex; vertical-align: baseline; align-items: baseline; gap: 0.25rem; }
        .details-container .complaint-box .multi-select-wrapper { width: auto; }
        .details-container .optional-selector-item .multi-select-wrapper { width: 100%; }
        
        .details-container .pills-container { display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; width: 100%; min-height: 38px; padding: 0.375rem 0.5rem; cursor: pointer; border: 1px solid var(--details-gray-300); border-radius: var(--details-border-radius); background-color: white; box-sizing: border-box; }
        .details-container .pills-container:hover { border-color: var(--details-gray-500); }
        
        .details-container .pills-container.inline {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 2px 4px;
            border-radius: 4px;
            border-bottom: 1px solid transparent;
            transition: background-color 0.2s;
            min-height: initial; 
            width: auto;
            vertical-align: middle;
            background-color: var(--details-gray-100);
            border: 1px solid var(--details-gray-300);
        }
        .details-container .pills-container.inline:hover {
            background-color: var(--details-gray-200);
            border-color: var(--details-gray-400);
        }
        .details-container .pills-placeholder-text {
            color: var(--details-primary-color);
            font-weight: 500;
        }
        .pills-placeholder-add-icon, .pill-add-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.25em;
            height: 1.25em;
            background-color: var(--details-primary-color);
            color: white;
            border-radius: 50%;
            flex-shrink: 0;
            border: none;
            cursor: pointer;
            font-size: 1em;
            line-height: 1;
        }
        .pill-add-button {
            margin-left: 0.35rem;
        }
        .pills-placeholder-add-icon svg, .pill-add-button svg {
            width: 0.9em;
            height: 0.9em;
            fill: currentColor;
        }
        
        .details-container .pills-placeholder { display: flex; align-items: center; gap: 0.35rem; color: var(--details-gray-600); }
        .details-container .pills-placeholder > svg { flex-shrink: 0; }
        
        .details-container .pill { background-color: var(--details-primary-light); border-radius: 99px; padding: 0.2rem 0.6rem; font-size: 0.9em; display: flex; align-items: center; gap: 0.3rem; color: var(--details-primary-color); font-weight: 500; white-space: nowrap; }
        .details-container .pill .deselect-pill { cursor: pointer; font-weight: bold; font-size: 1.1em; line-height: 1; opacity: 0.6; }
        .details-container .pill .deselect-pill:hover { opacity: 1; }
        
        .details-container .pills-container.inline .pill { 
            background-color: transparent; 
            padding: 0; 
            border-radius: 0; 
            border-bottom: 1px dotted var(--details-primary-color);
        }
        
        .details-container .multi-select-dropdown { display: none; position: absolute; background-color: white; border: 1px solid var(--details-gray-300); border-radius: var(--details-border-radius); box-shadow: var(--details-box-shadow); z-index: 1000; min-width: 250px; max-height: 300px; display: none; flex-direction: column; margin-top: 0.25rem; }
        .details-container .multi-select-dropdown.active { display: flex; }
        .details-container .multi-select-search { padding: 0.5rem; border: none; border-bottom: 1px solid var(--details-gray-200); outline: none; }
        .details-container .multi-select-list-container { overflow-y: auto; flex-grow: 1; }
        
        .details-container .multi-select-item { 
            display: flex; 
            align-items: center; 
            padding: 0.5rem 0.75rem; 
            cursor: pointer; 
            transition: background-color 0.2s ease;
        }
        .details-container .multi-select-item.selected {
            background-color: var(--details-primary-light);
            font-weight: 500;
        }
        .details-container .multi-select-item:hover { background-color: var(--details-gray-200); }
        .details-container .multi-select-item label { margin-left: 0.5rem; cursor: pointer; flex-grow: 1; }
        
        /* NEW: Custom animated checkbox */
        .details-container .multi-select-item input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            position: relative;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid var(--details-gray-400);
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .details-container .multi-select-item input[type="checkbox"]:checked {
            background-color: var(--details-primary-color);
            border-color: var(--details-primary-color);
        }
        .details-container .multi-select-item input[type="checkbox"]::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .details-container .multi-select-item input[type="checkbox"]:checked::after {
            opacity: 1;
        }

        .details-container .multi-select-item.add-new-trigger {
            color: var(--details-primary-color);
            font-weight: 500;
        }
        .details-container .multi-select-item.add-new-trigger svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
        }

        .details-container .multi-select-add-new { display: flex; padding: 0.5rem; border-top: 1px solid var(--details-gray-200); }
        .details-container .multi-select-add-input { flex-grow: 1; border: 1px solid var(--details-gray-300); border-right: none; border-radius: var(--details-border-radius) 0 0 var(--details-border-radius); padding: 0.3rem; outline: none; }
        .details-container .multi-select-add-btn { 
            background-color: var(--details-primary-color); 
            color: white; 
            border: none; 
            border-radius: 0 var(--details-border-radius) var(--details-border-radius) 0; 
            padding: 0 0.5rem; 
            cursor: pointer; 
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-button { 
            display: block; 
            width: 100%; 
            padding: 0.875rem; 
            background-color: var(--details-primary-color); 
            color: white; 
            border: none; 
            border-radius: var(--details-border-radius); 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 1.1rem; 
            margin-top: 1.5rem; 
            transition: background-color var(--details-transition); 
        }
        .submit-button:hover { background-color: #3f37c9; }
        #modelStatus {
            font-size: 0.8rem; 
            color: var(--details-gray-600); 
            margin-top: 0.75rem;
        }


        /* --- RESPONSIVE & MOBILE STYLES --- */
        @media (min-width: 481px) {
            .image-collage-preview { 
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (min-width: 769px) {
            .image-collage-preview { 
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            body { padding: 0.75rem; }
            .collage-layouts { grid-template-columns: repeat(auto-fill, minmax(50px, 1fr)); }
            .preview-item .enlarge-preview-btn { display: none; }
            .image-editor-modal, .collage-maker-container { padding: 0; }
            .image-editor-content, .collage-maker-content { max-width: 100%; width: 100%; min-height: 100%; max-height: 100%; height: 100%; border-radius: 0; }
            .collage-maker-body { padding: 15px; }

            .optional-details-toggle-wrapper > h4 { 
                cursor: pointer; 
                display: flex; 
                justify-content: space-between; 
                align-items: center; 
            }
            .optional-toggle-icon {
                transition: transform 0.2s ease-in-out;
            }
            .optional-details-toggle-wrapper:not(.is-expanded) .optional-selectors-grid {
                display: none;
            }
            .optional-details-toggle-wrapper.is-expanded .optional-selectors-grid {
                margin-top: 1rem;
            }
            .optional-details-toggle-wrapper.is-expanded .optional-toggle-icon {
                transform: rotate(180deg);
            }


            /* Mobile Photo Editor Redesign */
            .image-editor-content { background-color: var(--mobile-editor-bg); }
            .image-editor-header { background: none; border-bottom: none; position: absolute; top: 0; left: 0; width: 100%; z-index: 10; }
            .image-editor-header h3 { display: none; }
            .image-editor-header button#close-image-editor-btn { font-size: 2em; color: var(--mobile-primary-text); text-shadow: 0 1px 3px rgba(0,0,0,0.4); }
            .image-editor-body { background: none; flex-direction: column; padding: 0; position: relative; }
            .editor-side-panel { display: none; }
            .editor-top-bar { position: absolute; top: 45px; left: 0; width: 100%; display: flex; justify-content: center; z-index: 5; transition: var(--transition); }
            #main-editor-toolbar { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; background: rgba(0,0,0,0.3); backdrop-filter: blur(5px); padding: 8px; border-radius: var(--border-radius); }
            #main-editor-toolbar button { background-color: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--mobile-primary-text); width: 44px; height: 44px; aspect-ratio: 1 / 1; font-size: 1.5em; flex-direction: row; }
            #main-editor-toolbar button svg { margin: 0; }
            #main-editor-toolbar button.active { background-color: var(--mobile-finish-btn-bg); border-color: var(--mobile-finish-btn-bg); }
            .editor-workspace { display: flex; flex-grow: 1; padding: 10px; }
            .editor-workspace-corner, .editor-ruler { display: none; }
            .image-editor-preview-area { width: 100%; height: 100%; padding: 0; background: none; }
            #image-editor-canvas { box-shadow: none; }

            /* Contextual Sub-Toolbars */
            .sub-toolbar { display: none; align-items: center; justify-content: center; gap: 10px; background: rgba(0,0,0,0.3); backdrop-filter: blur(5px); padding: 4px 10px; border-radius: var(--border-radius); color: var(--mobile-primary-text); width: 100%; max-width: 360px; }
            .sub-toolbar.active { display: flex; }
            .sub-toolbar-actions { flex: 1; display: flex; justify-content: flex-start; }
            .sub-toolbar-controls { flex-grow: 1; display: flex; align-items: center; justify-content: center; gap: 10px; }
            .sub-toolbar input[type="range"] { flex-grow: 1; max-width: 120px; }
            .sub-toolbar .color-swatch { width: 28px; height: 28px; border-radius: 50%; border: 2px solid white; cursor: pointer; }
            .sub-toolbar .color-swatch-input { display: none; }
            .sub-toolbar .range-value-display, .sub-toolbar select { font-size: 0.8em; min-width: 30px; text-align: center; color: var(--mobile-primary-text); background: none; border: none; }
            .sub-toolbar select { padding: 5px; border-radius: 4px; background: rgba(255,255,255,0.1); }
            .sub-toolbar > button, .sub-toolbar-actions button { background: none; border: none; color: var(--mobile-primary-text); font-size: 1.8em; padding: 5px; }
            .sub-toolbar-cancel { color: var(--mobile-cancel-color) !important; }
            .sub-toolbar-done { color: var(--mobile-confirm-color) !important; }
            .image-editor-footer { position: absolute; bottom: 0; left: 0; right: 0; height: 80px; background-color: #000000; border-top: 1px solid rgba(255,255,255,0.15); display: flex; justify-content: space-between; align-items: center; padding: 0 20px; transition: var(--transition); }
            .footer-actions-left, .footer-actions-right { flex: 1; }
            .footer-actions-right { text-align: right; }
            .image-editor-footer button {  background: none; border: none; color: var(--mobile-primary-text); font-size: 1.1em; font-weight: 500; padding: 10px; }
            #editor-reset-btn { font-size: 1.8em; color: var(--mobile-secondary-text); }
            #cancel-image-editor-btn { display: none; }
            #editor-save-changes-btn { background-color: var(--mobile-finish-btn-bg); color: white; font-weight: 600; padding: 10px 25px; border-radius: var(--border-radius); }
            .image-editor-content.ui-hidden .editor-top-bar,
            .image-editor-content.ui-hidden .image-editor-footer { opacity: 0; transform: translateY(150%); pointer-events: none; }
            .image-editor-content.ui-hidden .editor-top-bar { transform: translateY(-150%); }

            /* Details Component Mobile */
            .details-container { padding: 1rem; }
            .details-container .form-label { font-size: 1rem; }
            body.modal-open::after { content: ''; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999; }
            .details-container .multi-select-dropdown { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90vw; max-width: 400px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15); }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="details-container">
            <div class="form-group">
                <div class="form-group-header">
                    <label class="form-label" for="complaint-box">Choose Image <span class="required-star">*</span></label>
                </div>
                
                <input type="file" id="camera-file-input" accept="image/jpeg,image/png" capture="environment" style="display: none;">
                <input type="file" id="gallery-file-input" accept="image/*,video/*,application/pdf" multiple style="display: none;">
                <div class="error-message" id="image-error" aria-live="polite"></div>

                <div class="complaint-input-wrapper" id="complaintInputWrapper">
                    <div class="complaint-box" id="complaintBox">
                         <p>
                           
                            <span id="complaint-sentence-template">
                                <span>, indicating a deviation from the</span>
                                <span class="multi-select-wrapper" id="sopSelector"></span>
                                <span style="display: none;">
                                    <span>at</span>
                                    <span class="multi-select-wrapper" id="departmentSelector"></span>
                                </span>
                                <span>at</span>
                                <span class="multi-select-wrapper" id="locationSelector"></span>
                                <span>. This issue requires rectification by</span>
                                <span class="multi-select-wrapper" id="responsibilitySelector"></span>
                                <span>.</span>
                            </span>
                        </p>
                        <div id="image-collage-preview-area" class="image-collage-preview" style="display: none;"></div>
                        <button type="button" id="create-collage-btn" style="display: none; margin-top: 10px; width: 100%; padding: 10px; background-color: var(--accent-color); color: white; border: none; border-radius: var(--border-radius); cursor: pointer;">Create Collage from Images</button>
                    </div>

                    <div id="direct-upload-options-container">
                        <div id="direct-upload-options" class="direct-upload-options">
                            <button type="button" id="direct-camera-btn" class="upload-option-direct" aria-label="Take a photo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4,4H7L9,2H15L17,4H20A2,2 0 0,1 22,6V18A2,2 0 0,1 20,20H4A2,2 0 0,1 2,18V6A2,2 0 0,1 4,4M12,7A5,5 0 0,0 7,12A5,5 0 0,0 12,17A5,5 0 0,0 17,12A5,5 0 0,0 12,7M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9Z" /></svg>
                            </button>
                            <button type="button" id="direct-camcorder-btn" class="upload-option-direct" aria-label="Record a video">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z" /></svg>
                            </button>
                            <button type="button" id="direct-gallery-btn" class="upload-option-direct" aria-label="Upload from photos and videos">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.58,16.09L17.17,11.67C16.42,10.92,15.21,10.92,14.46,11.67L11.91,14.22L9.21,11.5C8.82,11.13,8.19,11.13,7.8,11.5L2.42,16.94C1.63,17.72,2.2,19,3.14,19H20.86C21.8,19,22.37,17.72,21.58,16.09M22,5V15.5C22,16.05,21.55,16.5,21,16.5H3C2.45,16.5,2,16.05,2,15.5V5C2,3.9,2.9,3,4,3H20C21.1,3,22,3.9,22,5Z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="modelStatus"></div>
            </div>
    
  
        </div>
        
        <button id="submitBtn11" onClick="divFunction()" class="submit-button">Save</button>
    </div>


    <!-- MODALS FROM UPLOADER COMPONENT -->
    <div id="image-preview-modal">
      <div class="modal-content">
        <span class="close-preview" id="close-image-preview-modal">&times;</span>
      </div>
    </div>
    <div id="upload-choice-modal" class="upload-choice-modal"></div>
    <div id="video-recorder-modal" class="video-recorder-modal">
        <div class="video-recorder-content">
            <video id="video-preview" autoplay muted playsinline></video>
            <div class="video-controls">
                <span class="recording-indicator" id="recording-indicator">Recording...</span>
                <button id="start-record-btn">Start Recording</button>
                <button id="stop-record-btn" style="display: none;">Stop Recording</button>
                <button id="save-video-btn" style="display: none;">Save Video</button>
                <button id="cancel-video-btn">Cancel</button>
            </div>
        </div>
    </div>
    <div id="collage-maker-container" class="collage-maker-container">
        <div class="collage-maker-content">
            <div class="collage-maker-header">
                <h3>Create Photo Collage</h3>
                <button type="button" id="close-collage-maker" aria-label="Close collage maker">×</button>
            </div>
            <div class="collage-maker-body">
                <div class="collage-preview-area empty" id="collage-maker-preview-area"> 
                    <canvas id="collage-canvas"></canvas>
                </div>
                <div class="collage-controls">
                    <select id="collage-layout-select" aria-label="Select collage layout">
                        <optgroup label="One-Photo Layouts"><option value="1" data-photo-count="1">Single Photo</option><option value="museum-frame" data-photo-count="1">Museum Frame</option><option value="floating-island" data-photo-count="1">Floating Island</option></optgroup>
                        <optgroup label="Two-Photo Layouts"><option value="side-by-side" selected data-photo-count="2">Side by Side</option><option value="stacked" data-photo-count="2">Stacked</option><option value="diagonal-split" data-photo-count="2">Diagonal Split</option><option value="left-big-right-small" data-photo-count="2">Left Big, Right Small</option><option value="ripped-paper" data-photo-count="2">Ripped Paper</option><option value="yin-yang" data-photo-count="2">Yin Yang Cut</option></optgroup>
                        <optgroup label="Three-Photo Layouts"><option value="triptych" data-photo-count="3">Triptych</option><option value="grid-3" data-photo-count="3">Grid (1 Big, 2 Small)</option><option value="sidebar-stack" data-photo-count="3">Sidebar Stack</option><option value="triple-harmony-grid" data-photo-count="3">Triple Harmony Grid</option><option value="puzzle-3" data-photo-count="3">Puzzle</option></optgroup>
                        <optgroup label="Four-Photo Layouts"><option value="grid-2x2" data-photo-count="4">Grid 2x2</option><option value="one-big-three-small" data-photo-count="4">1 Big, 3 Small</option><option value="masonry-4" data-photo-count="4">Masonry</option><option value="diamond-grid" data-photo-count="4">Diamond Grid</option></optgroup>
                        <optgroup label="Four-Photo (Abstract)"><option value="fractured-glass" data-photo-count="4">Fractured Glass</option><option value="venn-diagram" data-photo-count="4">Venn Diagram</option><option value="origami-fold" data-photo-count="4">Origami Fold</option><option value="pixel-melt" data-photo-count="4">Pixel Melt</option><option value="cyberpunk-grid" data-photo-count="4">Cyberpunk Grid</option></optgroup>
                        <optgroup label="Five+ Photo Layouts"><option value="polaroid-5" data-photo-count="5">Polaroid Stack</option><option value="hex-grid-5" data-photo-count="5">Hexagon Grid</option><option value="big-center-4-corners" data-photo-count="5">Big Center, 4 Corners</option><option value="grid-3-2" data-photo-count="5">3 Over 2 Grid</option><option value="plus5" data-photo-count="5">Plus Grid</option></optgroup>
                    </select>
                    <select id="collage-style-modifier" aria-label="Select style modifier"><option value="none">No Style</option><option value="crinkled-paper">Crinkled Paper</option><option value="vaporwave">Vaporwave</option><option value="glitchcore">Glitchcore</option></select>
                    <select id="collage-border-select" aria-label="Select collage border size"><option value="0">No Border</option><option value="2" selected>Thin</option><option value="5">Medium</option><option value="10">Thick</option></select>
                </div>
                <div class="collage-layouts" role="radiogroup" aria-label="Choose collage layout preset">
                    <div class="collage-layout active" data-layout="side-by-side" data-photo-count="2" role="radio" aria-checked="true"><div class="layout-preview" style="grid-template-columns: 1fr 1fr;"><div class="layout-cell"></div><div class="layout-cell"></div></div></div>
                    <div class="collage-layout" data-layout="triptych" data-photo-count="3" role="radio" aria-checked="false"><div class="layout-preview" style="grid-template-columns: 1fr 1fr 1fr;"><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div></div></div>
                    <div class="collage-layout" data-layout="triple-harmony-grid" data-photo-count="3" role="radio" aria-checked="false"><div class="layout-preview" style="grid-template: 1fr 1fr / 2fr 1fr;"><div class="layout-cell" style="grid-area: 1 / 1 / 3 / 2;"></div><div class="layout-cell" style="grid-area: 1 / 2 / 2 / 3;"></div><div class="layout-cell" style="grid-area: 2 / 2 / 3 / 3;"></div></div></div>
                    <div class="collage-layout" data-layout="grid-2x2" data-photo-count="4" role="radio" aria-checked="false"><div class="layout-preview" style="grid-template: 1fr 1fr / 1fr 1fr;"><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div></div></div>
                    <div class="collage-layout layout-diamond-grid" data-layout="diamond-grid" data-photo-count="4" role="radio" aria-checked="false"><div class="layout-preview" style="grid-template: 1fr 1fr / 1fr 1fr;"><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div></div></div>
                    <div class="collage-layout" data-layout="plus5" data-photo-count="5" role="radio" aria-checked="false"><div class="layout-preview" style="grid-template: 1fr 2fr 1fr / 1fr 2fr 1fr;"><div class="layout-cell" style="grid-area: 2/2/3/3"></div><div class="layout-cell" style="grid-area: 1/2/2/3"></div><div class="layout-cell" style="grid-area: 2/1/3/2"></div><div class="layout-cell" style="grid-area: 2/3/3/4"></div><div class="layout-cell" style="grid-area: 3/2/4/3"></div></div></div>
                    <div class="collage-layout layout-hex-grid" data-layout="hex-grid-5" data-photo-count="5" role="radio" aria-checked="false"><div class="layout-preview"><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div><div class="layout-cell"></div></div></div>
                    <div class="collage-layout layout-fractured-glass" data-layout="fractured-glass" data-photo-count="4" role="radio" aria-checked="false"><div class="layout-preview" style="display:block;"><div class="layout-cell" style="position:absolute;width:100%;height:100%;"></div><div class="layout-cell" style="position:absolute;width:100%;height:100%;"></div></div></div>
                    <div class="collage-layout layout-origami-fold" data-layout="origami-fold" data-photo-count="4" role="radio" aria-checked="false"><div class="layout-preview" style="display:block;"><div class="layout-cell" style="position:absolute;width:100%;height:100%;"></div><div class="layout-cell" style="position:absolute;width:100%;height:100%;"></div></div></div>
                </div>
            </div>
            <div class="collage-maker-footer">
                <button type="button" class="cancel-collage-btn" id="cancel-collage-btn">Cancel</button>
                <button type="button" class="save-collage-btn" id="save-collage-btn">Save Collage</button>
            </div>
        </div>
    </div>
    <div id="image-editor-modal" class="image-editor-modal">
        <div class="image-editor-content">
            <div class="image-editor-header">
                <h3>Edit Image</h3>
                <button type="button" id="close-image-editor-btn" aria-label="Close image editor">←</button>
            </div>
            <div class="image-editor-body">
                <div class="editor-top-bar">
                    <div id="main-editor-toolbar" class="editor-toolbar">
                        <button type="button" id="tool-crop-btn" data-tool="crop" title="Crop"><svg viewBox="0 0 24 24"><path d="M7,17V1H5V5H1V7H5V17A2,2 0 0,0 7,19H17V23H19V19H23V17M17,15H7V7H17V15Z" /></svg></button>
                        <button type="button" id="tool-rotate-btn" data-tool="rotate" title="Rotate 90°">↻</button>
                        <button type="button" id="tool-select-btn" data-tool="select" title="Select & Move">✥</button>
                        <button type="button" id="tool-text-btn" data-tool="text" title="Add Text">T</button>
                        <button type="button" id="tool-draw-btn" data-tool="draw" title="Freehand Draw">✎</button>
                        <button type="button" id="tool-rect-btn" data-tool="rect" title="Draw Rectangle">▭</button>
                        <button type="button" id="tool-circle-btn" data-tool="circle" title="Draw Circle">○</button>
                        <button type="button" id="tool-arrow-btn" data-tool="arrow" title="Draw Arrow">⬈</button>
                    </div>
                    <div id="crop-options-toolbar" class="sub-toolbar"><div class="sub-toolbar-actions"><button type="button" class="sub-toolbar-cancel" id="crop-cancel-btn-mobile" title="Cancel Crop">✗</button></div><div class="sub-toolbar-controls"><select id="aspect-ratio-select-mobile" title="Aspect Ratio"></select></div><button type="button" class="sub-toolbar-done" id="crop-apply-btn-mobile" title="Apply Crop">✓</button></div>
                    <div id="text-options-toolbar" class="sub-toolbar"><div class="sub-toolbar-actions"><button type="button" class="sub-toolbar-undo" title="Undo Last Object">↶</button></div><div class="sub-toolbar-controls"><label for="text-color-input-mobile" class="color-swatch"></label><input type="color" id="text-color-input-mobile" class="color-swatch-input"><select id="font-family-select-mobile"></select><input type="range" id="font-size-input-mobile" min="8" max="120" value="30"><span id="font-size-value-mobile" class="range-value-display">30px</span></div><button type="button" class="sub-toolbar-done" title="Done With Tool">✓</button></div>
                    <div id="draw-options-toolbar" class="sub-toolbar"><div class="sub-toolbar-actions"><button type="button" class="sub-toolbar-cancel" title="Cancel Current Drawing">✗</button><button type="button" class="sub-toolbar-undo" title="Undo Last Object">↶</button></div><div class="sub-toolbar-controls"><label for="draw-color-input-mobile" class="color-swatch"></label><input type="color" id="draw-color-input-mobile" class="color-swatch-input"><input type="range" id="brush-size-input-mobile" min="1" max="50" value="5"><span id="brush-size-value-mobile" class="range-value-display">5px</span></div><button type="button" class="sub-toolbar-done" title="Done With Tool">✓</button></div>
                    <div id="shape-options-toolbar" class="sub-toolbar"><div class="sub-toolbar-actions"><button type="button" class="sub-toolbar-cancel" title="Cancel Current Drawing">✗</button><button type="button" class="sub-toolbar-undo" title="Undo Last Object">↶</button></div><div class="sub-toolbar-controls"><label for="shape-stroke-color-input-mobile" class="color-swatch"></label><input type="color" id="shape-stroke-color-input-mobile" class="color-swatch-input"><input type="range" id="shape-stroke-width-input-mobile" min="1" max="20" value="2"><span id="shape-stroke-width-value-mobile" class="range-value-display">2px</span></div><button type="button" class="sub-toolbar-done" title="Done With Tool">✓</button></div>
                </div>
                <div class="editor-workspace">
                    <div class="editor-workspace-corner"></div><div class="editor-ruler top"></div><div class="editor-ruler left"></div>
                    <div class="image-editor-preview-area" id="image-editor-preview-area"><canvas id="image-editor-canvas" width="600" height="400"></canvas></div>
                </div>
                <div class="editor-side-panel">
                    <div id="editor-options-area">
                        <div class="editor-options" id="crop-options" data-tool-options="crop"><div class="editor-option-group"><label for="aspect-ratio-select">Aspect Ratio:</label><select id="aspect-ratio-select"><option value="free">Freeform</option><option value="1/1">1:1 Square</option><option value="4/3">4:3</option><option value="3/4">3:4</option><option value="16/9">16:9</option><option value="9/16">9:16</option></select></div><div class="editor-option-group"><button type="button" id="crop-apply-btn">Apply</button><button type="button" id="crop-cancel-btn" style="background-color: var(--fixed-text-color);">Cancel</button></div></div>
                        <div class="editor-options" id="text-options" data-tool-options="text"><div class="editor-option-group"><p>Click on image to place text.<br>Double-click existing text to edit.</p></div><div class="editor-option-group"><label for="font-family-select">Font:</label><select id="font-family-select"><option value="Arial, sans-serif">Arial</option><option value="Verdana, sans-serif">Verdana</option><option value="Georgia, serif">Georgia</option><option value="Times New Roman, serif">Times New Roman</option></select></div><div class="editor-option-group"><label for="font-size-input">Size:</label><input type="number" id="font-size-input" value="30" min="8" max="120" step="1"><label for="text-color-input">Color:</label><input type="color" id="text-color-input" value="#e74c3c"></div></div>
                        <div class="editor-options" id="draw-options" data-tool-options="draw"><div class="editor-option-group"><label for="brush-size-input">Brush Size:</label><input type="range" id="brush-size-input" min="1" max="50" value="5"><span id="brush-size-value" class="range-value-display">5px</span></div><div class="editor-option-group"><label for="draw-color-input">Color:</label><input type="color" id="draw-color-input" value="#e74c3c"></div></div>
                        <div class="editor-options" id="shape-options" data-tool-options="rect circle arrow"><div class="editor-option-group"><label for="shape-stroke-width-input">Line Width:</label><input type="range" id="shape-stroke-width-input" min="1" max="20" value="2"><span id="shape-stroke-width-value" class="range-value-display">2px</span></div><div class="editor-option-group"><label for="shape-stroke-color-input">Line Color:</label><input type="color" id="shape-stroke-color-input" value="#e74c3c"></div><div class="editor-option-group" data-tool-options-subset="rect circle"><label for="shape-fill-color-input">Fill Color:</label><input type="color" id="shape-fill-color-input" value="#ffffff"><input type="checkbox" id="shape-fill-enable" checked><label for="shape-fill-enable">Transparent</label></div></div>
                    </div>
                </div>
            </div>
            <div class="image-editor-footer">
                <div class="footer-actions-left"><button type="button" id="editor-reset-btn" title="Reset all changes">⟲</button></div>
                <div class="footer-actions-right"><button type="button" id="editor-save-changes-btn">Finish</button></div>
                <button type="button" id="cancel-image-editor-btn">Cancel</button>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
</body>
</html>
```