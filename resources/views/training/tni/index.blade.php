<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Competency Mapping - Single Line Header</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #4361ee;
            --success-green: #2ecc71;
            --header-bg: #2f4050;
            --header-text: #ffffff;
            --border-color: #e7eaec;
            --text-dark: #333;
            --bg-light: #f4f6f9;
            --white: #ffffff;
            --col-hierarchy-width: 280px;
            --col-summary-min: 160px;
            --col-topic-min: 200px;
            --header-height: 45px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: "Segoe UI", Helvetica, Arial, sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--text-dark);
            overflow: hidden;
        }

        /* --- UNIFIED HEADER SECTION --- */
        .page-header {
            background: var(--white);
            padding: 10px 20px; /* Reduced padding for compact single line */
            border-bottom: 1px solid #ddd;
            flex-shrink: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            z-index: 1000;
            position: relative;
        }

        /* Flex container for the single line layout */
        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap; /* Try to keep on one line, scroll or wrap if very small */
            gap: 20px;
        }

        .left-section {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .right-section {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap; /* Wrap controls nicely on smaller screens */
            justify-content: flex-end;
            flex-grow: 1;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        /* Reusable Control Groups */
        .control-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .group-label {
            font-size: 13px;
            font-weight: 600;
            color: #555;
            white-space: nowrap;
        }

        /* Vertical Separator */
        .v-sep {
            width: 1px;
            height: 24px;
            background-color: #e0e0e0;
            margin: 0 5px;
        }

        /* --- BUTTONS & INPUTS --- */
        .btn {
            padding: 6px 14px; /* Slightly compact */
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid transparent;
            font-weight: 500;
            transition: all 0.2s;
            white-space: nowrap;
            height: 32px; /* Uniform height */
        }
        .btn-outline { background: white; border: 1px solid #ccc; color: #555; }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        
        .btn-history { background: #f8ac59; color: white; border: none; }
        .btn-history:hover { background: #df9b50; color: white; }

        .btn-icon {
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #555;
            border: 1px solid #ccc;
            background: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-icon:hover { background: #f5f5f5; color: var(--primary-blue); }

        .btn-upload { background-color: var(--white); border: 1px solid var(--primary-blue); color: var(--primary-blue); }
        .btn-upload:hover { background-color: #ebf0ff; }
        .btn-save { background-color: var(--success-green); color: white; border: none; }
        .btn-save:hover { background-color: #27ae60; }
        .btn-view { background-color: var(--header-bg); color: white; border: none; }
        .btn-view:disabled { background-color: #ccc; cursor: not-allowed; opacity: 0.7; }
        
        .file-status { 
            font-size: 11px; color: #555; font-style: italic; 
            max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
            margin-right: 5px;
        }

        /* --- MULTI SELECT --- */
        .multiselect { position: relative; display: inline-block; font-size: 13px; }
        .selectBox { position: relative; cursor: pointer; }
        .multiselect-btn {
            padding: 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #555;
            background-color: #fff;
            min-width: 130px; /* Slightly narrower to fit line */
            height: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .checkboxes {
            display: none;
            border: 1px solid #ccc;
            position: absolute;
            top: 100%;
            left: 0;
            width: 200px;
            background-color: #fff;
            z-index: 2000;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            border-radius: 4px;
        }
        .checkboxes label { display: block; padding: 8px 10px; cursor: pointer; border-bottom: 1px solid #f1f1f1; }
        .checkboxes label:hover { background-color: #f4f6f9; }
        .checkboxes input { margin-right: 8px; accent-color: var(--primary-blue); }

        /* --- LEGEND --- */
        .legend-content {
            font-size: 12px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .legend-item { white-space: nowrap; }
        .legend-sep { color: #ccc; }

        /* --- TABLE WRAPPER --- */
        .table-wrapper {
            flex-grow: 1;
            overflow: auto;
            position: relative;
            background: #fff;
            margin: 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            z-index: 1; 
        }

        .complex-table {
            width: max-content;
            min-width: 100%;
            border-collapse: separate; 
            border-spacing: 0;
        }

        .complex-table th, .complex-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            vertical-align: middle;
            background: #fff;
            position: relative; 
            z-index: 10;
        }

        /* --- COLUMN SIZING & STICKY --- */
        .col-summary-type { min-width: var(--col-summary-min); width: var(--col-summary-min); }
        .col-topic-type { min-width: var(--col-topic-min); width: var(--col-topic-min); }

        /* Sticky Headers */
        .complex-table thead th {
            position: sticky;
            background-color: var(--header-bg);
            color: var(--header-text);
            font-size: 13px;
            text-transform: uppercase;
            height: var(--header-height);
            border-right: 1px solid #455a64;
            white-space: nowrap;
            z-index: 30; 
        }
        .complex-table thead tr:nth-child(1) th { top: 0; }
        .complex-table thead tr:nth-child(2) th { top: var(--header-height); border-top: 1px solid #455a64; }
        
        /* Left Column Sticky */
        .complex-table .col-hierarchy {
            position: sticky; left: 0; 
            width: var(--col-hierarchy-width); min-width: var(--col-hierarchy-width);
            border-right: 2px solid #d1d1d1;
            background-color: #fff; 
            z-index: 20; 
        }
        .complex-table thead th.col-hierarchy {
            position: sticky; left: 0; top: 0;
            height: calc(var(--header-height) * 2);
            background-color: var(--header-bg); 
            z-index: 50; 
        }

        .parent-row td.col-hierarchy { background-color: #f8f9fa; }
        .child-row td.col-hierarchy { background-color: #fff; }

        /* --- CONTENT STYLES --- */
        .hierarchy-cell { display: flex; align-items: center; font-weight: 700; color: var(--header-bg); overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .role-text { font-weight: normal; color: #555; font-size: 13px; }
        .tree-toggle { background: var(--header-bg); color: white; border: none; width: 20px; height: 20px; line-height: 20px; text-align: center; border-radius: 4px; margin-right: 10px; cursor: pointer; flex-shrink: 0; }
        
        .radio-container { display: flex; flex-direction: row; align-items: center; justify-content: flex-start; gap: 12px; }
        .radio-label { display: flex; align-items: center; gap: 4px; font-size: 12px; cursor: pointer; white-space: nowrap; }
        .radio-label input { accent-color: var(--primary-blue); margin: 0; cursor: pointer; }

        .custom-select { width: 100%; padding: 6px; font-size: 13px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; }
        .custom-select:focus { outline: 1px solid var(--primary-blue); border-color: var(--primary-blue); }

        .col-toggle { cursor: pointer; margin-left: 8px; color: #a7b1c2; transition: 0.2s; font-size: 14px; }
        .col-toggle:hover { color: white; transform: scale(1.1); }

        .hidden { display: none !important; }
        .filter-hidden { display: none !important; }
        .disabled-row { background: #f9f9f9 !important; }
        
        .dept-status-text { font-size: 13px; font-weight: 600; color: var(--primary-blue); display: block; white-space: nowrap; }
        .dept-status-text.na { color: #999; font-weight: 500; }
        .na-text-display { font-size: 13px; color: #999; font-style: italic; display: block; text-align: center; white-space: nowrap;}
        
        .last-updated { display: block; font-size: 10px; color: #999; margin-top: 4px; text-align: left; font-style: italic; white-space: nowrap; }

        /* --- MODAL --- */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3000; display: flex; justify-content: center; align-items: center; }
        .modal-container { background: white; width: 600px; max-height: 80vh; border-radius: 6px; display: flex; flex-direction: column; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .modal-header { padding: 15px 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: var(--header-bg); color: white; border-radius: 6px 6px 0 0; }
        .modal-body { padding: 0; overflow-y: auto; }
        .history-list { list-style: none; margin: 0; padding: 0; }
        .history-item { padding: 12px 20px; border-bottom: 1px solid #f1f1f1; font-size: 13px; }
        .history-item:last-child { border-bottom: none; }
        .hist-time { font-weight: bold; color: var(--primary-blue); margin-right: 10px; font-size: 11px; }
        .hist-details { display: block; margin-top: 3px; color: #555; }
        .change-pill { background: #eee; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
        .close-modal { cursor: pointer; color: white; background: none; border: none; font-size: 18px; }

    </style>
</head>
<body>

<!-- UNIFIED SINGLE-LINE HEADER -->
<div class="page-header">
    <div class="header-row">
        
        <!-- Left: Title -->
        <div class="left-section">
            <div class="page-title">
                <i class="fas fa-user-shield"></i> Staff Competency Mapping
            </div>
        </div>

        <!-- Right: All Controls in one line -->
        <div class="right-section">

            <!-- 1. Filters -->
            <div class="control-group">
                <span class="group-label">Filter:</span>
                
                <div class="multiselect">
                    <div class="selectBox" onclick="toggleSelect('dept-check')">
                        <div class="multiselect-btn" id="btn-dept">Depts <i class="fas fa-caret-down"></i></div>
                    </div>
                    <div id="dept-check" class="checkboxes">
                        <label><input type="checkbox" value="Food Production" onchange="updateMultiFilter('dept')"> Food Production</label>
                        <label><input type="checkbox" value="F&B Service" onchange="updateMultiFilter('dept')"> F&B Service</label>
                        <label><input type="checkbox" value="Housekeeping" onchange="updateMultiFilter('dept')"> Housekeeping</label>
                        <label><input type="checkbox" value="Finance" onchange="updateMultiFilter('dept')"> Finance</label>
                        <label><input type="checkbox" value="Human Resource" onchange="updateMultiFilter('dept')"> Human Resource</label>
                    </div>
                </div>

                <div class="multiselect">
                    <div class="selectBox" onclick="toggleSelect('role-check')">
                        <div class="multiselect-btn" id="btn-role">Roles <i class="fas fa-caret-down"></i></div>
                    </div>
                    <div id="role-check" class="checkboxes">
                        <label><input type="checkbox" value="HOD" onchange="updateMultiFilter('role')"> HOD</label>
                        <label><input type="checkbox" value="Executive" onchange="updateMultiFilter('role')"> Executive</label>
                        <label><input type="checkbox" value="Staff" onchange="updateMultiFilter('role')"> Staff</label>
                    </div>
                </div>

                <div class="multiselect">
                    <div class="selectBox" onclick="toggleSelect('comp-check')">
                        <div class="multiselect-btn" id="btn-comp" style="border-color:var(--primary-blue);">Levels <i class="fas fa-caret-down"></i></div>
                    </div>
                    <div id="comp-check" class="checkboxes">
                        <label><input type="checkbox" value="1" onchange="updateMultiFilter('comp')"> 1 - Awareness</label>
                        <label><input type="checkbox" value="2" onchange="updateMultiFilter('comp')"> 2 - Basic</label>
                        <label><input type="checkbox" value="3" onchange="updateMultiFilter('comp')"> 3 - Supervised</label>
                        <label><input type="checkbox" value="4" onchange="updateMultiFilter('comp')"> 4 - Independent</label>
                        <label><input type="checkbox" value="5" onchange="updateMultiFilter('comp')"> 5 - Trainer</label>
                    </div>
                </div>

                <button class="btn-icon" onclick="resetFilters()" title="Reset Filters"><i class="fas fa-sync-alt"></i></button>
            </div>

            <div class="v-sep"></div>

            <!-- 2. Level Marking (Legend) -->
            <div class="control-group">
                <span class="group-label">Levels:</span>
                <div class="legend-content">
                    <span class="legend-item">1-Awareness</span> <span class="legend-sep">|</span>
                    <span class="legend-item">2-Basic</span> <span class="legend-sep">|</span>
                    <span class="legend-item">3-Supervised</span> <span class="legend-sep">|</span>
                    <span class="legend-item">4-Independent</span> <span class="legend-sep">|</span>
                    <span class="legend-item">5-Trainer</span>
                </div>
            </div>

            <div class="v-sep"></div>

            <!-- 3. Document Actions -->
            <div class="control-group">
                <input type="file" id="comp-doc-input" hidden onchange="handleFileSelect(this)">
                <span id="file-name-display" class="file-status hidden"></span>
                <button class="btn btn-upload" id="btn-upload" onclick="triggerUpload()"><i class="fas fa-paperclip"></i> Upload</button>
                <button class="btn btn-save hidden" id="btn-save" onclick="saveFile()"><i class="fas fa-save"></i> Save</button>
                <button class="btn btn-view" id="btn-view" onclick="viewFile()" disabled><i class="fas fa-eye"></i> View</button>
            </div>

            <div class="v-sep"></div>

            <!-- 4. Global Actions -->
            <div class="control-group">
                <button class="btn btn-history" onclick="toggleHistoryModal()"><i class="fas fa-history"></i> History</button>
                <button class="btn btn-outline"><i class="fas fa-download"></i> Export</button>
            </div>

        </div>
    </div>
</div>

<!-- TABLE WRAPPER -->
<div class="table-wrapper">
    <table class="complex-table">
        <thead>
            <tr id="header-row-top">
                <th class="col-hierarchy" rowspan="2">Hierarchy</th>
                <!-- Dynamic Main Topics injected here -->
            </tr>
            <tr id="header-row-sub">
                <!-- Dynamic Subtopics injected here -->
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Dynamic Body Content injected here -->
        </tbody>
    </table>
</div>

<!-- HISTORY MODAL -->
<div id="history-modal" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <span><i class="fas fa-history"></i> Change History</span>
            <button class="close-modal" onclick="toggleHistoryModal()">&times;</button>
        </div>
        <div class="modal-body">
            <ul id="history-list" class="history-list">
                <li class="history-item" style="text-align:center; color:#999;">No changes recorded yet.</li>
            </ul>
        </div>
    </div>
</div>

<script>
    // --- VARIABLES & STATE ---
    let changeHistory = [];
    let savedFileBlobUrl = null;
    let tempFile = null;
    let currentFocusVal = ""; 


const departments = @json($departments);
const roles = @json($roles);
const competencyTopics = @json($competencyTopics);

    // --- DATA ---
    // const departments = [
    //     { id: 'fp', name: 'Food Production', icon: 'fa-utensils' },
    //     { id: 'fbs', name: 'F&B Service', icon: 'fa-concierge-bell' },
    //     { id: 'hk', name: 'Housekeeping', icon: 'fa-broom' },
    //     { id: 'fin', name: 'Finance', icon: 'fa-calculator' },
    //     { id: 'hr', name: 'Human Resource', icon: 'fa-users' },
    //     { id: 'fo', name: 'Front Office', icon: 'fa-bell' },
    //     { id: 'eng', name: 'Engineering', icon: 'fa-tools' }
    // ];

    // const roles = [
    //     { id: 'hod', name: 'HOD', icon: 'fa-user-tie' },
    //     { id: 'exec', name: 'Executive', icon: 'fa-user-shield' },
    //     { id: 'staff', name: 'Staff', icon: 'fa-user' }
    // ];

    // // DYNAMIC TOPIC CONFIGURATION
    // const competencyTopics = [
    //     {
    //         id: 'haccp',
    //         title: 'HACCP / Food Safety',
    //         subtopics: ['Hygiene Standards', 'Process Control', 'Documentation', 'Quality Assurance']
    //     },
    //     {
    //         id: 'safety',
    //         title: 'Fire & Life Safety',
    //         subtopics: ['Evacuation', 'Extinguisher Use', 'First Aid', 'Hazard ID']
    //     },
    //     {
    //         id: 'guest',
    //         title: 'Guest Experience',
    //         subtopics: ['Grooming', 'Communication', 'VIP Protocol', 'Complaint Handling']
    //     },
    //     {
    //         id: 'it',
    //         title: 'IT & Data Security',
    //         subtopics: ['Password Mgmt', 'GDPR', 'Phishing', 'System Access']
    //     }
    // ];

    const dropdownOptions = `
        <option value="na" selected>Not Applicable</option>
        <option value="1">1 - Awareness</option>
        <option value="2">2 - Basic</option>
        <option value="3">3 - Supervised</option>
        <option value="4">4 - Independent</option>
        <option value="5">5 - Trainer</option>
    `;

    // --- INIT HEADERS ---
    function renderHeaders() {
        const topRow = document.getElementById('header-row-top');
        const subRow = document.getElementById('header-row-sub');
        
        let topHtml = '<th class="col-hierarchy" rowspan="2">Hierarchy</th>';
        let subHtml = '';

        competencyTopics.forEach(topic => {
            // Main Topic Header
            topHtml += `
                <th id="header-${topic.id}" colspan="1">
                    ${topic.title}
                    <i id="icon-${topic.id}" class="fas fa-plus-circle col-toggle" onclick="toggleTopic('${topic.id}')"></i>
                </th>`;
            
            // Subtopic Headers
            subHtml += `<th class="summary-col-${topic.id} col-summary-type">Summary</th>`;
            topic.subtopics.forEach(sub => {
                subHtml += `<th class="topic-col-${topic.id} col-topic-type hidden">${sub}</th>`;
            });
        });

        topRow.innerHTML = topHtml;
        subRow.innerHTML = subHtml;
    }

    // --- INIT BODY ---
    function renderBody() {
        const tableBody = document.getElementById('table-body');
        let html = '';

        departments.forEach(dept => {
            // --- Parent Row ---
            html += `
            <tr data-id="${dept.id}" data-type="parent" data-dept-name="${dept.name}" class="parent-row">
                <td class="col-hierarchy">
                    <div class="hierarchy-cell">
                        <button class="tree-toggle" onclick="toggleRow('${dept.id}')"><i class="fas fa-plus"></i></button>
                        <span><i class="fas ${dept.icon}" style="margin-right:8px; color:#666;"></i> ${dept.name}</span>
                    </div>
                </td>`;

            competencyTopics.forEach(topic => {
                html += `
                <td class="summary-col-${topic.id} col-summary-type">
                    <div class="radio-container">
                        <label class="radio-label"><input type="radio" name="${topic.id}_dept_${dept.id}" value="yes" onfocus="saveFocusVal(this)" onchange="handleDeptChange('${dept.id}', 'yes', '${dept.name}', '${topic.id}')" checked> App.</label>
                        <label class="radio-label"><input type="radio" name="${topic.id}_dept_${dept.id}" value="no" onfocus="saveFocusVal(this)" onchange="handleDeptChange('${dept.id}', 'no', '${dept.name}', '${topic.id}')"> N/A</label>
                    </div>
                    <div class="last-updated hidden" id="ts-${topic.id}-dept-${dept.id}"></div>
                </td>`;
                
                topic.subtopics.forEach(() => {
                    html += `<td class="topic-col-${topic.id} col-topic-type hidden"><span class="dept-status-text dept-status-${topic.id}">Applicable</span></td>`;
                });
            });

            html += `</tr>`;

            // --- Child Rows ---
            roles.forEach(role => {
                html += `
                <tr data-parent="${dept.id}" data-type="child" data-role-name="${role.name}" class="child-row hidden">
                    <td class="col-hierarchy">
                        <div class="hierarchy-cell" style="padding-left: 35px;">
                            <span class="role-text"><i class="fas ${role.icon}" style="margin-right:6px; color:#4361ee; font-size:11px;"></i> ${role.name}</span>
                        </div>
                    </td>`;

                competencyTopics.forEach(topic => {
                    html += `
                    <td class="summary-col-${topic.id} col-summary-type">
                        <div class="radio-container">
                            <label class="radio-label"><input type="radio" name="${topic.id}_role_${dept.id}_${role.id}" value="yes" onfocus="saveFocusVal(this)" onchange="handleRoleChange(this, 'yes', '${role.name}', '${topic.id}')" checked> App.</label>
                            <label class="radio-label"><input type="radio" name="${topic.id}_role_${dept.id}_${role.id}" value="no" onfocus="saveFocusVal(this)" onchange="handleRoleChange(this, 'no', '${role.name}', '${topic.id}')"> N/A</label>
                        </div>
                        <div class="last-updated hidden" id="ts-${topic.id}-role-${dept.id}-${role.id}"></div>
                    </td>`;

                    topic.subtopics.forEach((sub) => {
                        const subId = sub.replace(/\s+/g, '').toLowerCase(); 
                        const tsId = `ts-${dept.id}-${role.id}-${topic.id}-${subId}`;
                        html += `
                        <td class="topic-col-${topic.id} col-topic-type hidden">
                            <select class="custom-select competency-drop competency-drop-${topic.id}" onfocus="saveFocusVal(this)" onchange="updateTopicCompetency(this, '${dept.id}', '${role.id}', '${sub}', '${topic.id}')">
                                ${dropdownOptions}
                            </select>
                            <span class="na-text-display na-text-${topic.id} hidden">Not Applicable</span>
                            <div class="last-updated hidden" id="${tsId}"></div>
                        </td>`;
                    });
                });

                html += `</tr>`;
            });
        });

        tableBody.innerHTML = html;
    }

    // --- MULTI-SELECT UTILITIES ---
    function toggleSelect(id) {
        const checkboxes = document.getElementById(id);
        const wasOpen = checkboxes.style.display === "block";
        document.querySelectorAll('.checkboxes').forEach(el => el.style.display = "none");
        checkboxes.style.display = wasOpen ? "none" : "block";
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.multiselect')) {
            document.querySelectorAll('.checkboxes').forEach(el => el.style.display = "none");
        }
    });

    function updateMultiFilter(type) {
        const id = `${type}-check`;
        const btnId = `btn-${type}`;
        const checkboxes = document.querySelectorAll(`#${id} input[type="checkbox"]:checked`);
        const btn = document.getElementById(btnId);
        
        let label = "";
        let defaultLabel = "";
        
        if (type === 'dept') defaultLabel = "Depts";
        if (type === 'role') defaultLabel = "Roles";
        if (type === 'comp') defaultLabel = "Levels";

        if (checkboxes.length === 0) {
            label = defaultLabel;
        } else if (checkboxes.length === 1) {
            label = checkboxes[0].parentElement.innerText.trim(); 
        } else {
            label = `${checkboxes.length} Selected`;
        }
        
        btn.innerHTML = `${label} <i class="fas fa-caret-down"></i>`;
        
        filterData();
    }

    function getSelectedValues(id) {
        return Array.from(document.querySelectorAll(`#${id} input[type="checkbox"]:checked`)).map(cb => cb.value);
    }

    function isAnyFilterActive() {
        return (getSelectedValues('dept-check').length > 0 || getSelectedValues('role-check').length > 0 || getSelectedValues('comp-check').length > 0);
    }

    // --- FILTERING LOGIC ---
    function filterData() {
        const selDepts = getSelectedValues('dept-check');
        const selRoles = getSelectedValues('role-check');
        const selComps = getSelectedValues('comp-check');
        
        const isFiltering = isAnyFilterActive();
        const parents = document.querySelectorAll('tr[data-type="parent"]');

        parents.forEach(parent => {
            const deptName = parent.getAttribute('data-dept-name');
            const parentId = parent.getAttribute('data-id');
            const children = document.querySelectorAll(`tr[data-parent="${parentId}"]`);
            let visibleChildren = 0;
            
            const deptMatch = selDepts.length === 0 || selDepts.includes(deptName);

            children.forEach(child => {
                const roleName = child.getAttribute('data-role-name');
                const roleMatch = selRoles.length === 0 || selRoles.includes(roleName);
                
                let compMatch = true;
                if (selComps.length > 0) {
                    const drops = child.querySelectorAll('.competency-drop');
                    let hasSpecificLevel = false;
                    drops.forEach(d => {
                        const td = d.closest('td');
                        if (selComps.includes(d.value)) hasSpecificLevel = true;
                    });
                    compMatch = hasSpecificLevel;
                }

                if(deptMatch && roleMatch && compMatch) {
                    child.classList.remove('filter-hidden');
                    if(isFiltering) child.classList.remove('hidden');
                    visibleChildren++;
                } else {
                    child.classList.add('filter-hidden');
                }
            });

            if(visibleChildren > 0) {
                parent.classList.remove('filter-hidden');
                if(isFiltering) parent.querySelector('.tree-toggle i').className = 'fas fa-minus';
            } else {
                if(!isFiltering) parent.classList.remove('filter-hidden');
                else parent.classList.add('filter-hidden');
            }
        });
        
        if(!isFiltering) resetViewToDefault();
    }

    function resetFilters() {
        document.querySelectorAll('.checkboxes input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.getElementById('btn-dept').innerHTML = `Depts <i class="fas fa-caret-down"></i>`;
        document.getElementById('btn-role').innerHTML = `Roles <i class="fas fa-caret-down"></i>`;
        document.getElementById('btn-comp').innerHTML = `Levels <i class="fas fa-caret-down"></i>`;
        filterData();
    }

    // --- HISTORY & TIMESTAMP ---
    function getTimestamp() {
        const now = new Date();
        return now.toLocaleDateString() + ' ' + now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    function saveFocusVal(el) {
        if(el.type === 'radio') {
            const checked = document.querySelector(`input[name="${el.name}"]:checked`);
            currentFocusVal = checked ? (checked.value === 'yes' ? 'Applicable' : 'N/A') : 'Applicable';
        } else {
            currentFocusVal = el.options[el.selectedIndex].text;
        }
    }

    function logChange(context, field, oldVal, newVal, timestampElementId) {
        const ts = getTimestamp();
        if(timestampElementId) {
            const el = document.getElementById(timestampElementId);
            if(el) { el.textContent = "Upd: " + ts; el.classList.remove('hidden'); }
        }
        changeHistory.unshift({ time: ts, context: context, field: field, oldVal: oldVal, newVal: newVal });
        renderHistory();
    }

    function renderHistory() {
        const list = document.getElementById('history-list');
        if(changeHistory.length === 0) {
            list.innerHTML = '<li class="history-item" style="text-align:center; color:#999;">No changes recorded yet.</li>';
            return;
        }
        list.innerHTML = changeHistory.map(item => `
            <li class="history-item">
                <span class="hist-time">${item.time}</span>
                <strong>${item.context}</strong>
                <span class="hist-details">
                    Changed ${item.field} from <span class="change-pill">${item.oldVal}</span> to <span class="change-pill">${item.newVal}</span>
                </span>
            </li>
        `).join('');
    }

    function toggleHistoryModal() {
        document.getElementById('history-modal').classList.toggle('hidden');
    }

    // --- DYNAMIC TOGGLE ---
    function toggleTopic(topicId) {
        const headerCell = document.getElementById(`header-${topicId}`);
        const icon = document.getElementById(`icon-${topicId}`);
        const summaryCells = document.querySelectorAll(`.summary-col-${topicId}`);
        const topicCells = document.querySelectorAll(`.topic-col-${topicId}`);
        const topicData = competencyTopics.find(t => t.id === topicId);
        const subtopicCount = topicData ? topicData.subtopics.length : 1;
        const isCollapsed = !summaryCells[0].classList.contains('hidden');

        if (isCollapsed) {
            summaryCells.forEach(el => el.classList.add('hidden'));
            topicCells.forEach(el => el.classList.remove('hidden'));
            headerCell.setAttribute('colspan', subtopicCount);
            icon.className = 'fas fa-minus-circle col-toggle';
        } else {
            summaryCells.forEach(el => el.classList.remove('hidden'));
            topicCells.forEach(el => el.classList.add('hidden'));
            headerCell.setAttribute('colspan', '1');
            icon.className = 'fas fa-plus-circle col-toggle';
        }
    }

    // --- EVENT HANDLERS ---
    function handleDeptChange(deptId, status, deptName, topicId) {
        const newVal = status === 'yes' ? 'Applicable' : 'N/A';
        if(currentFocusVal !== newVal) {
            const topicTitle = competencyTopics.find(t=>t.id===topicId).title;
            logChange(deptName, `${topicTitle} Status`, currentFocusVal, newVal, `ts-${topicId}-dept-${deptId}`);
        }

        const parentRow = document.querySelector(`tr[data-id="${deptId}"]`);
        
        const statusSpans = parentRow.querySelectorAll(`.dept-status-${topicId}`);
        statusSpans.forEach(span => {
            span.textContent = status === 'yes' ? "Applicable" : "Not Applicable";
            status === 'yes' ? span.classList.remove('na') : span.classList.add('na');
        });

        const childRows = document.querySelectorAll(`tr[data-parent="${deptId}"]`);
        childRows.forEach(row => {
            const radios = row.querySelectorAll(`input[name^="${topicId}_role_${deptId}"]`);
            let targetRadio = null;
            radios.forEach(r => { if(r.value === status) targetRadio = r; });

            if (status === 'no') {
                if(targetRadio) targetRadio.checked = true;
                toggleRoleUI(row, 'no', topicId);
            } else {
                if(targetRadio) targetRadio.checked = true;
                toggleRoleUI(row, 'yes', topicId);
            }
        });

        if(isAnyFilterActive()) filterData();
    }

    function handleRoleChange(radio, status, roleName, topicId) {
        const newVal = status === 'yes' ? 'Applicable' : 'N/A';
        const row = radio.closest('tr');
        const deptName = document.querySelector(`tr[data-id="${row.getAttribute('data-parent')}"]`).getAttribute('data-dept-name');
        const topicTitle = competencyTopics.find(t=>t.id===topicId).title;
        const tsDiv = radio.closest('.radio-container').nextElementSibling;
        
        if(currentFocusVal !== newVal) {
            logChange(`${deptName} > ${roleName}`, `${topicTitle} Status`, currentFocusVal, newVal, tsDiv ? tsDiv.id : null);
        }

        toggleRoleUI(row, status, topicId);
        if(isAnyFilterActive()) filterData();
    }

    function updateTopicCompetency(select, deptId, roleId, topicSubName, topicId) {
        const newVal = select.options[select.selectedIndex].text;
        const roleRow = select.closest('tr');
        const actualRoleName = roleRow.getAttribute('data-role-name');
        const deptName = document.querySelector(`tr[data-id="${deptId}"]`).getAttribute('data-dept-name');
        
        const subId = topicSubName.replace(/\s+/g, '').toLowerCase(); 
        const tsId = `ts-${deptId}-${roleId}-${topicId}-${subId}`;

        if(currentFocusVal !== newVal) {
            logChange(`${deptName} > ${actualRoleName}`, topicSubName, currentFocusVal, newVal, tsId);
        }
        
        if(isAnyFilterActive()) filterData();
    }

    function toggleRoleUI(row, status, topicId) {
        const dropdowns = row.querySelectorAll(`.competency-drop-${topicId}`);
        const naTexts = row.querySelectorAll(`.na-text-${topicId}`);

        if (status === 'yes') {
            dropdowns.forEach(d => d.classList.remove('hidden'));
            naTexts.forEach(t => t.classList.add('hidden'));
        } else {
            dropdowns.forEach(d => d.classList.add('hidden'));
            naTexts.forEach(t => t.classList.remove('hidden'));
        }
    }

    function resetViewToDefault() {
        document.querySelectorAll('tr[data-type="child"]').forEach(r => {
            r.classList.add('hidden');
            r.classList.remove('filter-hidden');
        });
        document.querySelectorAll('tr[data-type="parent"]').forEach(r => {
            r.classList.remove('filter-hidden');
            r.querySelector('.tree-toggle i').className = 'fas fa-plus';
        });
    }

    function toggleRow(id) {
        const children = document.querySelectorAll(`tr[data-parent="${id}"]`);
        const icon = document.querySelector(`tr[data-id="${id}"] .tree-toggle i`);
        let isHidden = false;
        const visibleChild = Array.from(children).find(c => !c.classList.contains('hidden'));
        if(visibleChild) isHidden = true; 

        children.forEach(r => {
            if(!r.classList.contains('filter-hidden')) {
                isHidden ? r.classList.add('hidden') : r.classList.remove('hidden');
            }
        });
        icon.className = isHidden ? 'fas fa-plus' : 'fas fa-minus';
    }

    // --- UPLOAD ---
    function triggerUpload() { document.getElementById('comp-doc-input').click(); }
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            tempFile = input.files[0];
            document.getElementById('file-name-display').textContent = tempFile.name;
            document.getElementById('file-name-display').classList.remove('hidden');
            document.getElementById('btn-save').classList.remove('hidden');
            document.getElementById('btn-upload').classList.add('hidden'); 
        }
    }
    function saveFile() {
        if (!tempFile) return;
        savedFileBlobUrl = URL.createObjectURL(tempFile);
        document.getElementById('btn-save').classList.add('hidden');
        const upBtn = document.getElementById('btn-upload');
        upBtn.classList.remove('hidden');
        upBtn.innerHTML = '<i class="fas fa-paperclip"></i> Change';
        const vBtn = document.getElementById('btn-view');
        vBtn.disabled = false;
        document.getElementById('file-name-display').innerHTML = `<i class="fas fa-check-circle" style="color:var(--success-green)"></i> Saved`;
        tempFile = null;
    }
    function viewFile() { if (savedFileBlobUrl) window.open(savedFileBlobUrl, '_blank'); }

    // --- START ---
    renderHeaders();
    renderBody();

</script>
</body>
</html>