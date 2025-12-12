
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Form</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.6.2/dist/fuse.min.js"></script>
    <style>
    
    span#complaint-sentence-template {
    display: block !important;
}

#complaint-sentence-template {
    opacity: 1 !important;
}
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
            width: 200px;
            height: 200px;
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
                    <label class="form-label" for="complaint-box">Complaint Details <span class="required-star">*</span></label>
                </div>
                
                <input type="file" id="camera-file-input" accept="image/jpeg,image/png" capture="environment" style="display: none;">
                <input type="file" id="gallery-file-input" accept="image/*,video/*,application/pdf" multiple style="display: none;">
                <div class="error-message" id="image-error" aria-live="polite"></div>

                <div class="complaint-input-wrapper" id="complaintInputWrapper">
                    <div class="complaint-box" id="complaintBox">
                         <p>
                            <span contenteditable="true" class="inline-input" id="concernInput" data-placeholder="Type or add media...">{{$inspectionDetails->title ?? ''}}</span>
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
    
            <div class="optional-details-section optional-details-toggle-wrapper">
                <h4>
                    <span>Optional: Specify Items/People Involved</span>
                    <svg class="optional-toggle-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </h4>
                <div class="optional-selectors-grid">
                    <div class="optional-selector-item">
                        <label for="peopleSelector">Person(s)</label>
                        <span class="multi-select-wrapper" id="peopleSelector"></span>
                    </div>
                    <div class="optional-selector-item">
                        <label for="equipmentSelector">Equipment</label>
                        <span class="multi-select-wrapper" id="equipmentSelector"></span>
                    </div>
                    <div class="optional-selector-item">
                        <label for="foodSelector">Food Item(s)</label>
                        <span class="multi-select-wrapper" id="foodSelector"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <button id="submitBtn" class="submit-button">Edit Inspection</button>
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
    imageCollagePreviewArea.style.display = 'grid';

    // 👇 Default existing image URL (from PHP variable)
    // const existingImageURL = "{{ isset($inspectionDetails->image) ? asset('inspection/'.$inspectionDetails->image) : '' }}";

    // // 🟢 Case 1: No new files selected → show existing image
    // if (!hasFiles) {
    //     const item = document.createElement('div');
    //     item.className = 'preview-item';

    //     const img = document.createElement('img');
    //     img.src = existingImageURL;
    //     img.alt = 'Existing Inspection Image';
    //     item.appendChild(img);

    //     const controls = document.createElement('div');
    //     controls.className = 'preview-item-controls';

    //     const enlargeBtn = document.createElement('button');
    //     enlargeBtn.className = 'enlarge-preview-btn';
    //     enlargeBtn.innerHTML = '⚲';
    //     enlargeBtn.title = "Enlarge Image";
    //     enlargeBtn.onclick = (e) => { e.stopPropagation(); openImagePreviewModal(existingImageURL); };
    //     controls.appendChild(enlargeBtn);

    //     item.appendChild(controls);
    //     imageCollagePreviewArea.appendChild(item);

    //     return; // stop here, don't render file list
    // }
    
    const existingImageURL = "{{ isset($inspectionDetails->image) ? asset('inspection/'.$inspectionDetails->image) : '' }}";

// 🟢 Case 1: No new files selected → show existing image
if (!hasFiles) {

    // 🔴 If existing image is empty → stop here, don’t show image box
    if (!existingImageURL || existingImageURL.trim() === "") {
        return; 
    }

    const item = document.createElement('div');
    item.className = 'preview-item';

    const img = document.createElement('img');
    img.src = existingImageURL;
    img.alt = 'Existing Inspection Image';
    item.appendChild(img);

    const controls = document.createElement('div');
    controls.className = 'preview-item-controls';

    const enlargeBtn = document.createElement('button');
    enlargeBtn.className = 'enlarge-preview-btn';
    enlargeBtn.innerHTML = '⚲';
    enlargeBtn.title = "Enlarge Image";
    enlargeBtn.onclick = (e) => { 
        e.stopPropagation(); 
        openImagePreviewModal(existingImageURL); 
    };
    controls.appendChild(enlargeBtn);

    item.appendChild(controls);
    imageCollagePreviewArea.appendChild(item);

    return;
}

    // 🟢 Case 2: Show selected file previews
    const imageFileCount = selectedFiles.filter(f => f.type.startsWith('image/')).length;
    createCollageBtn.style.display = imageFileCount > 1 ? 'block' : 'none';

    selectedFiles.forEach((file, index) => {
        const item = document.createElement('div');
        item.className = 'preview-item';
        const controls = document.createElement('div');
        controls.className = 'preview-item-controls';

        const fileURL = URL.createObjectURL(file);

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = fileURL;
            img.alt = file.name;
            item.appendChild(img);
            item.ondblclick = (e) => { e.stopPropagation(); openImagePreviewModal(fileURL); };
            
            const enlargeBtn = document.createElement('button');
            enlargeBtn.className = 'enlarge-preview-btn';
            enlargeBtn.innerHTML = '⚲';
            enlargeBtn.title = "Enlarge Image";
            enlargeBtn.onclick = (e) => { e.stopPropagation(); openImagePreviewModal(fileURL); };
            controls.appendChild(enlargeBtn);

            const editBtn = document.createElement('button');
            editBtn.className = 'edit-preview-btn';
            editBtn.innerHTML = '✎';
            editBtn.title = "Edit Image";
            editBtn.onclick = (e) => { e.stopPropagation(); launchImageEditor(file, index); };
            controls.appendChild(editBtn);
        }

        const removeBtn = document.createElement('button');
        removeBtn.className = 'remove-preview-btn';
        removeBtn.innerHTML = '×';
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
            btn.innerHTML = `<div class="upload-option-direct-icon-bg">${iconSvg}</div>`;
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
            
                       // let allSops = ["Food Safety Policy", "Hygiene Standards", "Customer Service Protocol", "Equipment SOP", "Waste Management SOP", "General Safety Protocol"];

            let allSops = [@foreach($sops as $sop)"{{$sop->name}}", @endforeach];
            let allDepartments = [@foreach($departments as $department)'{{$department->name}}', @endforeach];
            
            @php
    // Department ID → Name mapping array
    $deptMap = $departments->pluck('name', 'id')->toArray();
@endphp


           let allLocations = [
        @foreach($locations as $location)
            {
                name: '{{ $location->name }}',
                department: '{{ $deptMap[$location->department_id] ?? "N/A" }}'
            },
        @endforeach
    ];
            let allResponsibilities = [@foreach($responsibility as $responsibilitys)'{{$responsibilitys->name}}', @endforeach];
            
            const allIndependentPeople = [
                
                @foreach($unit_list as $unit_lists)
                { name: '{{$unit_lists->employer_fullname}}', id: '{{$unit_lists->employe_id}}'},
                @endforeach
            ];
            const allIndependentEquipment = [
                    @foreach($facility_equipment as $facility_equipments)
                { name: '{{$facility_equipments->name}}', id: '{{$facility_equipments->id}}'},
                @endforeach

            ];
            const allFood = [ @foreach($sqa_raw_material_product as $sqa_raw_material_products)'{{$sqa_raw_material_products->name ?? ''}}', @endforeach];
            
            const initialLocations = [...allLocations];
            const initialResponsibilities = [...allResponsibilities];

            let selectedSops = [], selectedPeople = [], selectedEquipment = [], selectedFood = [], selectedResponsibilities = [];
            let selectedLocations = [];
            
            //       let masterKeywordList = [
            //     { canonical: 'Storage', type: 'keyword', aliases: ['Storage'], sop: ['Storage'] },
            // ];
            
    const masterKeywordList = [
        @foreach($userKeywords as $keyword)
        @php $sopsname = DB::table('sops')->where('id',$keyword->course_id)->value('name') @endphp
            {
                canonical: '{{ strtolower(trim($keyword->keyword)) }}',
                type: 'keyword',
                aliases: ['{{ strtolower(trim($keyword->keyword)) }}'],sop: ['{{$sopsname}}']
    
            },
        @endforeach
                @foreach($locations as $location)
               @php $department_name = DB::table('departments')->where('id', $location->department_id)->value('name'); @endphp
        { canonical: '{{ $location->name }}', type: 'location', selectValue: '{{ $location->name }} ({{ $department_name }})' },
        @endforeach
         @foreach($facility_equipment as $facility_equipments)
                    { canonical: '{{$facility_equipments->name}}', type: 'equipment', aliases: ['{{$facility_equipments->name}}'], selectValue: '{{$facility_equipments->name}} ({{$facility_equipments->id}})'},
                @endforeach
                               @foreach($unit_list as $unit_lists)
                    { canonical: '{{$unit_lists->employer_fullname}}', type: 'people', aliases: ['{{$unit_lists->employer_fullname}}'], selectValue: '{{$unit_lists->employer_fullname}} ({{$unit_lists->employe_id}})'},
                @endforeach
                @foreach($sqa_raw_material_product as $sqa_raw_material_products)
                { canonical: '{{$sqa_raw_material_products->name}}', type: 'food', selectValue: '{{$sqa_raw_material_products->name}}' },
                @endforeach
    
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
            
            function setupMultiSelectComponent({ containerId, config, dataProvider, selectedItems, onSelectionChange, displayFormatter }) {
                const defaultFormatter = item => (typeof item === 'object' && item !== null) ? item.name : item;
                const formatter = displayFormatter || defaultFormatter;

                const wrapper = document.getElementById(containerId);
                const isInline = wrapper.closest('.complaint-box');

                wrapper.innerHTML = `<div class="pills-container" tabindex="0"></div>
                    <div class="multi-select-dropdown">
                        <input type="search" class="multi-select-search" placeholder="Search..." autocomplete="off">
                        <div class="multi-select-list-container"></div>
                        <div class="multi-select-add-new">
                            <input type="text" class="multi-select-add-input" placeholder="Add custom...">
                            <button type="button" class="multi-select-add-btn" title="Add new item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
                            </button>
                        </div>
                    </div>`;

                const pillsContainer = wrapper.querySelector('.pills-container');
                if (isInline) pillsContainer.classList.add('inline');

                const dropdown = wrapper.querySelector('.multi-select-dropdown');
                const searchInput = wrapper.querySelector('.multi-select-search');
                const listContainer = wrapper.querySelector('.multi-select-list-container');
                const addInput = wrapper.querySelector('.multi-select-add-input');
                const addButton = wrapper.querySelector('.multi-select-add-btn');

                const isMobile = () => window.innerWidth <= 768;
                const showDropdown = () => { if (!dropdown.classList.contains('active')) { dropdown.classList.add('active'); if (isMobile()) document.body.classList.add('modal-open'); renderDropdownList(); searchInput.focus(); } };
                const hideDropdown = () => { dropdown.classList.remove('active'); if (isMobile()) document.body.classList.remove('modal-open'); };
                
                wrapper.show = showDropdown;

             

window.inspectionDetails = {!! json_encode($inspectionDetails ?? new stdClass()) !!};


// ✅ A dictionary to pick target array based on DB field name
const selectedMap = {
    //people: selectedPeople,
    equipment: selectedEquipment,
    food: selectedFood,
    sops: selectedSops,
};

// ✅ Auto-select from DB once (edit mode)
const prefillFromDB = () => {
    if (!window.inspectionDetails) return;

    Object.keys(selectedMap).forEach(dbKey => {
        const dbValue = window.inspectionDetails[dbKey];
        if (!dbValue || typeof dbValue !== "string") return;

        dbValue.split(',')
            .map(x => x.trim())
            .filter(Boolean)
            .forEach(val => {
                if (!selectedMap[dbKey].includes(val)) {
                    selectedMap[dbKey].push(val);
                }
            });
    });

    console.log("✅ DB Pre-load", selectedMap);
};
// ✅ Run once
prefillFromDB();


/*
|--------------------------------------------------------------------------
| ✅ RENDER PILLS LOGIC (Always read from selectedMap)
|--------------------------------------------------------------------------
*/
const renderPills = () => {
    const targetArray = selectedMap[config.dbKey] ?? selectedItems;
    selectedItems = targetArray;

    pillsContainer.innerHTML = '';

    if (isInline) {
        if (targetArray.length === 0) {
            pillsContainer.innerHTML = `
                <span class="pills-placeholder-text">[${config.label}]</span>
                <span class="pills-placeholder-add-icon">
                    <svg viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3
                        a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3
                        A.5.5 0 0 1 8 4z"/>
                    </svg>
                </span>`;
        } else {
            pillsContainer.innerHTML =
                targetArray.map(item =>
                    `<div class="pill">${item}
                        <span class="deselect-pill" data-item="${item}">×</span>
                    </div>`
                ).join('') +
                `<button type="button" class="pill-add-button">
                    <svg viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3
                        a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3
                        A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>`;
        }
    } else {
        pillsContainer.innerHTML =
            targetArray.length === 0
                ? `<span class="pills-placeholder">${config.svg}<span class="placeholder-text">${config.label}</span></span>`
                : targetArray.map(item =>
                    `<div class="pill">${item}
                        <span class="deselect-pill" data-item="${item}">×</span>
                    </div>`
                ).join('');
    }
};


/*
|--------------------------------------------------------------------------
| ✅ DROPDOWN LIST (Auto-check from selectedMap)
|--------------------------------------------------------------------------
*/
const renderDropdownList = () => {
    const targetArray = selectedMap[config.dbKey] ?? selectedItems;
    selectedItems = targetArray;

    const s = searchInput.value.toLowerCase();
    const filteredItems = dataProvider().filter(item =>
        formatter(item).toLowerCase().includes(s)
    );

    const addNewTriggerHtml = `
        <div class="multi-select-item add-new-trigger">
            <svg viewBox="0 0 24 24" fill="none"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            <label>Add New</label>
        </div>`;

    const itemsHtml = filteredItems.map(item => {
        const formatted = formatter(item);
        const isSelected = targetArray.includes(formatted);
        const id = `${containerId}-${formatted.replace(/[^a-zA-Z0-9]/g, '-')}`;

        return `
            <div class="multi-select-item ${isSelected ? 'selected' : ''}">
                <input type="checkbox" id="${id}"
                       data-item="${formatted}" ${isSelected ? 'checked' : ''}>
                <label for="${id}">${formatted}</label>
            </div>`;
    }).join('');

    listContainer.innerHTML =
        addNewTriggerHtml +
        (itemsHtml || `<div class="no-results">No results</div>`);
};


                
                const handleAddNewItem = () => {
                    const newItem = addInput.value.trim();
                    if (newItem && !dataProvider().some(i => formatter(i).toLowerCase() === newItem.toLowerCase())) {
                        dataProvider().push(newItem);
                        if (!selectedItems.includes(newItem)) { selectedItems.push(newItem); }
                        addInput.value = '';
                        renderPills();
                        renderDropdownList();
                        if (onSelectionChange) onSelectionChange();
                    }
                };

                pillsContainer.addEventListener('click', (e) => { 
                    
   
                    if (e.target.closest('.deselect-pill')) { 
                        const itemToRemove = e.target.closest('.deselect-pill').dataset.item;
                        const i = selectedItems.indexOf(itemToRemove); 
                        if (i > -1) { selectedItems.splice(i, 1); if (onSelectionChange) onSelectionChange(); } 
                        renderPills(); e.stopPropagation(); return; 
                    }
                    if (e.target.closest('.pill-add-button')) {
                         e.stopPropagation();
                         showDropdown();
                         return;
                    }
                    showDropdown(); 
                });

                listContainer.addEventListener('click', (e) => {
                    const itemElement = e.target.closest('.multi-select-item');
                    if (!itemElement) return;

                    if (itemElement.classList.contains('add-new-trigger')) {
                        e.preventDefault();
                        addInput.focus();
                        return;
                    }

                    const checkbox = itemElement.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        if (e.target !== checkbox) {
                            checkbox.checked = !checkbox.checked;
                        }
                         const itemValue = checkbox.dataset.item; 
                        if (checkbox.checked) { 
                            if (!selectedItems.includes(itemValue)) selectedItems.push(itemValue);
                            itemElement.classList.add('selected');
                        } 
                        else { 
                            const idx = selectedItems.indexOf(itemValue); 
                            if (idx > -1) selectedItems.splice(idx, 1);
                            itemElement.classList.remove('selected');
                        } 
                        if (onSelectionChange) onSelectionChange();
                        renderPills(); 
                    }
                });
                
                addButton.addEventListener('click', handleAddNewItem);
                addInput.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); handleAddNewItem(); } });
                searchInput.addEventListener('input', renderDropdownList);
                document.addEventListener('click', e => { if (!wrapper.contains(e.target)) { hideDropdown(); } });
                
                wrapper._update = () => { renderPills(); renderDropdownList(); };
                wrapper._update();
            }
            
            function processAndDisplayConcern() {
                const text = concernInput.textContent.trim();

                if (text === '') {
                    selectedSops.length = 0;
                    document.getElementById('sopSelector')._update();
                    previousMatchedItems = [];
                    return; 
                }

                const cursorPosition = getCursorPosition(concernInput);
                const segments = findBestMatches(concernInput.textContent);
                const currentMatchedItems = segments.filter(s => s.type === 'match').map(s => s.match.item);
                
                handleRemovedKeywords(currentMatchedItems);
                currentMatchedItems.forEach(item => applyMatch(item));
                
                const html = segments.map(s => {
                    if (s.type === 'match') {
                        const canonical = s.match.item.canonical;
                        const cssClass = s.text.toLowerCase() !== canonical.toLowerCase() && !s.match.item.aliases.includes(s.text.toLowerCase()) ? 'misspelled' : 'highlight';
                        return `<span class="${cssClass}" data-canonical="${canonical}">${s.text}</span>`;
                    }
                    return s.text;
                }).join('');
                concernInput.innerHTML = html;
                setCursorPosition(concernInput, cursorPosition);
                
                previousMatchedItems = currentMatchedItems;
            }
            
            function handleRemovedKeywords(currentItems) {
                const removedItems = previousMatchedItems.filter(pItem => !currentItems.some(cItem => cItem.canonical === pItem.canonical));
                removedItems.forEach(removed => {
                    const isStillReferenced = (value) => currentItems.some(c => c.selectValue === value || (c.sop && c.sop.includes(value)));
                    if (removed.sop) { removed.sop.forEach(sop => { if (!isStillReferenced(sop)) { const index = selectedSops.indexOf(sop); if (index > -1) selectedSops.splice(index, 1); } }); document.getElementById('sopSelector')._update(); }
                    if (removed.selectValue && !isStillReferenced(removed.selectValue)) {
                        const map = { 'people': selectedPeople, 'equipment': selectedEquipment, 'location': selectedLocations, 'responsibility': selectedResponsibilities, 'food': selectedFood };
                        const targetArray = map[removed.type];
                        if (targetArray) {
                            const index = targetArray.indexOf(removed.selectValue);
                            if (index > -1) {
                                targetArray.splice(index, 1);
                                if (['location', 'responsibility'].includes(removed.type)) { saveSelectionsToLocalStorage(); }
                            }
                            const element = document.getElementById(`${removed.type}Selector`);
                            if(element) element._update();
                        }
                    }
                });
            }

            function findBestMatches(text) {
                const tokens = text.split(/(\s+)/); const segments = []; let i = 0;
                while (i < tokens.length) {
                    if (!tokens[i].trim()) { segments.push({ type: 'text', text: tokens[i] }); i++; continue; }
                    let bestMatch = null;
                    for (let j = Math.min(i + 9, tokens.length); j > i; j--) {
                        const searchPhrase = tokens.slice(i, j).filter(t => t.trim()).join(' '); if (!searchPhrase) continue;
                        const results = fuse.search(searchPhrase);
                        if (results.length > 0 && results[0].score < fuseOptions.threshold) { bestMatch = { match: results[0], tokenCount: j - i, text: tokens.slice(i, j).join('') }; break; }
                    }
                    if (bestMatch) { segments.push({ type: 'match', ...bestMatch }); i += bestMatch.tokenCount; } 
                    else { segments.push({ type: 'text', text: tokens[i] }); i++; }
                }
                return segments;
            }

            // function applyMatch(match) {
            //     if (match.sop && match.sop.length > 0) { let changed = false; match.sop.forEach(sopName => { if (!selectedSops.includes(sopName)) { selectedSops.push(sopName); changed = true; } }); if (changed) document.getElementById('sopSelector')._update(); }
            //     if (match.type === 'category_trigger' && match.targetSelectId) { document.getElementById(match.targetSelectId)?.querySelector('.pills-container')?.click(); } 
            //     else if (match.selectValue) {
            //         const map = { 'people': { arr: selectedPeople, id: 'peopleSelector' }, 'equipment': { arr: selectedEquipment, id: 'equipmentSelector' }, 'location': { arr: selectedLocations, id: 'locationSelector' }, 'responsibility': { arr: selectedResponsibilities, id: 'responsibilitySelector' }, 'food': { arr: selectedFood, id: 'foodSelector' } };
            //         const target = map[match.type];
            //         if (target && !target.arr.includes(match.selectValue)) {
            //             target.arr.push(match.selectValue); 
            //             if (['location', 'responsibility'].includes(match.type)) { saveSelectionsToLocalStorage(); }
            //             document.getElementById(target.id)?._update(); 
            //         }
            //     }
            // }
            
            
                                  function applyMatch(match) {
                if (match.sop && match.sop.length > 0) { let changed = false; match.sop.forEach(sopName => { if (!selectedSops.includes(sopName)) { selectedSops.push(sopName); changed = true; } }); if (changed) document.getElementById('sopSelector')._update(); }
                if (match.type === 'category_trigger' && match.targetSelectId) { document.getElementById(match.targetSelectId)?.querySelector('.pills-container')?.click(); } 
                else if (match.selectValue) {
                    const map = { 'location': { arr: selectedLocations, id: 'locationSelector' }, 'responsibility': { arr: selectedResponsibilities, id: 'responsibilitySelector' } };
                    const target = map[match.type];
                    if (target && !target.arr.includes(match.selectValue)) {
                        target.arr.push(match.selectValue); 
                        if (['location', 'responsibility'].includes(match.type)) { saveSelectionsToLocalStorage(); }
                        document.getElementById(target.id)?._update(); 
                    }
                }
            }
            
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
function handleSubmit(e) {
        e.preventDefault();

        // Call the global function to get the files
        const filesToUpload = window.getUploadedFiles(); // CORRECT WAY TO GET FILES

        const savedLocs = JSON.parse(localStorage.getItem('previousLocations') || '[]');
        const savedResps = JSON.parse(localStorage.getItem('previousResponsibilities') || '[]');
        let needsConfirmation = false;
        let confirmationMessage = "You are using the same selections as your last submission for:";

        if (selectedLocations.length > 0 && arraysAreEqual(selectedLocations, savedLocs)) {
            needsConfirmation = true;
            confirmationMessage += "\n- Location(s)";
        }
        if (selectedResponsibilities.length > 0 && arraysAreEqual(selectedResponsibilities, savedResps)) {
            needsConfirmation = true;
            confirmationMessage += "\n- Responsibility";
        }
        confirmationMessage += "\n\nIs this correct?";

        const proceed = () => {
            const formData = new FormData();

            // --- Add text fields ---
            formData.append('concern', concernInput.textContent || '');
            formData.append('sops', JSON.stringify(selectedSops));
            formData.append('locations', JSON.stringify(selectedLocations));
            formData.append('responsibilities', JSON.stringify(selectedResponsibilities));
            formData.append('people', JSON.stringify(selectedPeople));
            formData.append('equipment', JSON.stringify(selectedEquipment));
            formData.append('food', JSON.stringify(selectedFood));
            formData.append('id', {{$id ?? ''}});
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            // --- IMPORTANT: Append all files from the filesToUpload array ---
            filesToUpload.forEach((file, index) => { // Use filesToUpload here
                formData.append(`files[${index}]`, file);
            });

            $.ajax({
    url: '{{ route("postbulkupload") }}',
    method: 'POST',
    data: formData,
    processData: false,  // IMPORTANT for FormData
    contentType: false,  // IMPORTANT for FormData
    success: function(response) {
        console.log('Complaint saved:', response);
        //alert("Complaint submitted successfully! The form will now be reset.");

        // --- Reset text fields and selections ---
        concernInput.innerHTML = "";
        complaintInputWrapper.classList.remove('is-typing');
        document.querySelector('#complaint-sentence-template').style.display = 'none';

        selectedSops.length = 0;
        selectedLocations.length = 0;
        selectedResponsibilities.length = 0;
        selectedPeople.length = 0;
        selectedEquipment.length = 0;
        selectedFood.length = 0;

        allLocations = [...initialLocations];
        allResponsibilities = [...initialResponsibilities];

     

        // --- Reset uploader component state ---
        document.dispatchEvent(new CustomEvent('form-reset'));

        // --- Redirect after success ---
        //window.location.href = "https://efsm.safefoodmitra.com/admin/public/index.php/inspection/list";
        const currentPage = new URLSearchParams(window.location.search).get("page") || 1;

window.location.href = `/admin/public/index.php/inspection/list?page=${currentPage}`;

    },
    error: function(xhr) {
        alert("Failed to submit complaint. Please try again.");
        console.error(xhr.responseText);
    }
});

        };

        if (needsConfirmation) {
            if (window.confirm(confirmationMessage)) { proceed(); }
            else { console.log("Submission cancelled by user."); }
        } else {
            proceed();
        }
    }

    // --- Attach handler ---
    document.getElementById('submitBtn').addEventListener('click', handleSubmit);


        })();
    });
    </script>
</body>
</html>
```