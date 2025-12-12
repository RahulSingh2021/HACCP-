@extends('layouts.app2', ['pagetitle'=>'Dashboard'])

 <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">">

    <!-- JS Libraries for Export (Keep these) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        /* Sticky header for table */
        .table-responsive thead th {
            position: sticky;
            top: 0;
            z-index: 10;   /* Ensure header is above tbody, but allow dropdowns on top */
            background-color: #4a6fa5;
            color: white;
        }
        .cert-status-box {
            border: 1px solid var(--bs-border-color-translucent);
            border-radius: var(--bs-border-radius);
            padding: 0.75rem;
            background-color: #f8fafc;
            min-width: 340px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .cert-status-box::before {
            content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%;
            background-color: var(--bs-secondary-bg);
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        .cert-status-box.high-progress::before { background-color: var(--bs-success); }
        .cert-status-box.medium-progress::before { background-color: var(--bs-warning); }
        .cert-status-box.low-progress::before { background-color: var(--bs-danger); }
        tr:hover .cert-status-box::before { width: 6px; }
        tr:hover .cert-status-box { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .cert-metric {
            text-align: center; padding: 0.5rem; background-color: rgba(255,255,255,0.7);
            border-radius: var(--bs-border-radius-sm);
        }
        .cert-metric-label {
            font-size: 0.75em; font-weight: 600; color: var(--bs-secondary-color);
            margin-bottom: 0.15rem; white-space: nowrap;
        }
        .cert-metric-value { font-size: 1.1em; font-weight: 700; }
        .cert-metric-required .cert-metric-value { color: var(--bs-primary); }
        .cert-metric-valid .cert-metric-value { color: var(--bs-success); }
        .cert-metric-expiring .cert-metric-value { color: var(--bs-warning); }
        .cert-metric-invalid .cert-metric-value { color: var(--bs-danger); }
        .progress-container { position: relative; }
        .progress-container::after {
            content: attr(data-progress-text); position: absolute; right: 0.5rem; top: 50%;
            transform: translateY(-50%); font-size: 0.7em; color: var(--bs-secondary-color);
            font-weight: 600; z-index: 1; /* z-index for text on progress bar */
        }
        .filter-dropdown-menu {
            min-width: 220px;
        }
        .unit-filter-panel {
            min-width: 320px !important;
        }
        .filter-dropdown-menu label, .unit-filter-panel label {
            font-size: 0.85em; margin-bottom: 0.25rem; font-weight: 500;
        }
        .filter-icon {
            cursor: pointer; opacity: 0.7; transition: opacity 0.2s, color 0.2s; color: white;
        }
        .filter-icon:hover { opacity: 1; }
        .filter-icon.active { opacity: 1; color: #ffc107; }
        .sort-indicator {
            vertical-align: middle; opacity: 0.7; width: 1em; display: inline-block; text-align: center;
        }
        th:hover .sort-indicator { opacity: 1; }
        .sort-indicator.asc::after { content: ' ▲'; font-size: 0.8em;}
        .sort-indicator.desc::after { content: ' ▼'; font-size: 0.8em;}
        .cert-list-item { transition: background-color 0.2s; }
        .cert-list-item:hover { background-color: var(--bs-tertiary-bg); }
        .tooltip-custom { position: relative; display: inline-block; cursor: help; }
        .tooltiptext-custom {
            visibility: hidden; min-width: 150px; max-width: 220px; background-color: var(--bs-dark);
            color: var(--bs-white); text-align: center; border-radius: var(--bs-border-radius);
            padding: 0.5rem 0.75rem; position: absolute; z-index: 1080; bottom: 130%; left: 50%;
            transform: translateX(-50%) translateY(5px); opacity: 0;
            transition: opacity 0.25s ease-out, transform 0.25s ease-out;
            font-size: 0.8em; box-shadow: var(--bs-box-shadow-sm); pointer-events: none;
        }
        .tooltiptext-custom::after {
            content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px;
            border-width: 5px; border-style: solid; border-color: var(--bs-dark) transparent transparent transparent;
        }
        .tooltip-custom:hover .tooltiptext-custom { visibility: visible; opacity: 0.9; transform: translateX(-50%) translateY(0); }
        .table th, .table td { vertical-align: middle; }
        td.col-cert-status { text-align: center; }
        .filter-group-title {
            font-size: 0.9em; font-weight: 600; color: var(--bs-primary);
            margin-bottom: 0.3rem; padding-bottom: 0.3rem;
            border-bottom: 1px solid var(--bs-border-color-translucent);
        }
        .checkbox-list-container {
            max-height: 150px; overflow-y: auto; font-size: 0.9em;
        }
        .checkbox-list-container .form-check { margin-bottom: 0.3rem; }
        .checkbox-list-container .form-check-label { cursor: pointer; }
        .select-all-buttons .btn-link { font-size: 0.8em; }
        .filter-step-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;
        }
        .filter-step-header .btn-back { font-size: 0.8em; }
        .download-dropdown-item i { margin-right: 0.5rem; }
    </style>



@section('content')
 

<div class="container-fluid mt-3">
    <div class="row mb-3 align-items-center gy-2">
        <div class="col-md-6"><h2 class="text-primary">Unit Compliance Status</h2></div>
        <div class="col-md-6 d-flex justify-content-md-end gap-2">
             <button id="resetAllFiltersBtn" class="btn btn-sm btn-outline-secondary" title="Reset all filters"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset All</button>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-download me-1"></i> Download
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item download-dropdown-item" href="#" id="downloadUnitExcelLink"><i class="bi bi-file-earmark-excel text-info"></i> Unit Compliance (Excel)</a></li>
                    <li><a class="dropdown-item download-dropdown-item" href="#" id="downloadUnitPdfLink"><i class="bi bi-file-earmark-pdf text-danger"></i> Unit Compliance (PDF)</a></l/i>
                    <!--<li><hr class="dropdown-divider"></li>-->
                    <li style="display: none;"><a class="dropdown-item download-dropdown-item" href="#" id="downloadStaffCertsExcelLink"><i class="bi bi-person-badge text-success"></i> Staff Certificates (Excel)</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="table-responsive shadow-sm bg-white rounded">
        <table class="table table-hover table-striped table-bordered align-middle" id="complianceTable">
            <thead class="table-dark" style="background-color: #4a6fa5;">
                <tr>
                    <th scope="col" class="text-center" style="width: 60px;" data-column="slNo">Sl. <span class="sort-indicator"></span></th>
                    <th scope="col" style="min-width: 200px;" data-column="unitName">
                        Unit Details <span class="sort-indicator"></span>
                        <div class="dropdown d-inline-block ms-1">
                            <i class="bi bi-funnel-fill filter-icon" id="unitNameFilterIcon" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Filter by Unit Details"></i>
                            <div class="dropdown-menu unit-filter-panel p-3 shadow" aria-labelledby="unitNameFilterIcon" id="unitNameFilterDropdown">
                                <div id="corporateEntityFilterStep" class="filter-step">
                                    <div class="filter-step-header"><h6 class="filter-group-title mb-0">Corporate Entity</h6></div>
                                    <div class="d-flex justify-content-between align-items-center mb-1 select-all-buttons">
                                        <button type="button" class="btn btn-link btn-sm p-0" data-type="corporateEntity" id="selectAllCorporateEntity">Select All</button>
                                        <button type="button" class="btn btn-link btn-sm p-0" data-type="corporateEntity" id="deselectAllCorporateEntity">Deselect All</button>
                                    </div>
                                    <div class="checkbox-list-container border rounded p-2" id="corporateEntityCheckboxList"><small class="text-muted">Loading...</small></div>
                                </div>
                                <div id="regionFilterStep" class="filter-step d-none">
                                    <div class="filter-step-header">
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-back" id="backToCorporateEntity"><i class="bi bi-arrow-left me-1"></i>Back</button>
                                        <h6 class="filter-group-title mb-0">Region</h6><span> </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1 select-all-buttons">
                                        <button type="button" class="btn btn-link btn-sm p-0" data-type="region" id="selectAllRegion">Select All</button>
                                        <button type="button" class="btn btn-link btn-sm p-0" data-type="region" id="deselectAllRegion">Deselect All</button>
                                    </div>
                                    <div class="checkbox-list-container border rounded p-2" id="regionCheckboxList"><small class="text-muted">Select Corporate Entity first...</small></div>
                                </div>
                                <div id="unitFilterStep" class="filter-step d-none">
                                    <div class="filter-step-header">
                                         <button type="button" class="btn btn-sm btn-outline-secondary btn-back" id="backToRegion"><i class="bi bi-arrow-left me-1"></i>Back</button>
                                        <h6 class="filter-group-title mb-0">Unit</h6><span> </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1 select-all-buttons">
                                        <button type="button" class="btn btn-link btn-sm p-0" data-type="unit" id="selectAllUnit">Select All</button>
                                        <button type="button" class="btn btn-link btn-sm p-0" data-type="unit" id="deselectAllUnit">Deselect All</button>
                                    </div>
                                    <div class="checkbox-list-container border rounded p-2" id="unitCheckboxList"><small class="text-muted">Select Region first...</small></div>
                                </div>
                                <div class="d-flex justify-content-end pt-2 border-top mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="clearUnitFilterBtn">Clear All Steps</button>
                                    <button type="button" class="btn btn-sm btn-primary" id="applyAndCloseUnitFilterBtn" data-bs-dismiss="dropdown">Apply & Close</button>
                                </div>
                            </div>
                        </div>
                    </th>
                    <th scope="col" style="min-width: 280px;" data-column="address">
                        Address <span class="sort-indicator"></span>
                         <div class="dropdown d-inline-block ms-1">
                            <i class="bi bi-funnel-fill filter-icon" id="addressFilterIcon" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Filter by Address"></i>
                            <div class="dropdown-menu filter-dropdown-menu p-2 shadow" aria-labelledby="addressFilterIcon">
                                <label for="filterAddressInput" class="form-label">Contains text:</label>
                                <input type="text" class="form-control form-control-sm mb-2" id="filterAddressInput" placeholder="e.g., Anytown">
                                <div class="d-flex justify-content-end pt-2 border-top">
                                   <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="clearAddressFilterBtn">Clear</button>
                                   <button type="button" class="btn btn-sm btn-primary" id="applyAddressFilterBtn" data-bs-dismiss="dropdown">Apply</button>
                                </div>
                            </div>
                        </div>
                    </th>
                    <th scope="col" style="min-width: 380px;" data-column="certificateStatus">Certificate Status <span class="sort-indicator"></span></th>
                    <th scope="col" class="text-center" style="min-width: 200px;" data-column="complianceStatus">
                        Compliance Status <span class="sort-indicator"></span>
                        <div class="dropdown d-inline-block ms-1">
                            <i class="bi bi-funnel-fill filter-icon" id="complianceStatusFilterIcon" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Filter by Compliance Status"></i>
                            <div class="dropdown-menu filter-dropdown-menu p-2 shadow" aria-labelledby="complianceStatusFilterIcon">
                                <label for="filterComplianceStatusSelect" class="form-label">Select status:</label>
                                <select class="form-select form-select-sm mb-2" id="filterComplianceStatusSelect">
                                    <option value="">All Statuses</option>
                                    <option value="compliant">Compliant</option>
                                    <option value="expiring-soon">Expiring Soon</option>
                                    <option value="non-compliant">Non-Compliant</option>
                                </select>
                                <div class="d-flex justify-content-end pt-2 border-top">
                                    <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="clearComplianceFilterBtn">Clear</button>
                                    <button type="button" class="btn btn-sm btn-primary" id="applyComplianceFilterBtn" data-bs-dismiss="dropdown">Apply</button>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be populated by JavaScript -->
                <tr><td colspan="5" class="text-center p-5 text-muted"><i>Loading data...</i></td></tr>
            </tbody>
        </table>
    </div>
</div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailsModalLabel"><i class="bi bi-clipboard2-check me-2"></i><span id="modalUnitNameText">Unit Certificate Details</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3 pb-3 border-bottom">
                        <strong>Unit ID:</strong> <span id="modalUnitId" class="text-muted"></span> |
                        <strong>Address:</strong> <span id="modalUnitAddress" class="text-muted"></span>
                    </div>
                    <div class="cert-summary bg-light p-3 rounded border mb-4 shadow-sm">
                        <h6 class="text-primary mb-3">Status Summary</h6>
                        <div class="row g-3 text-center mb-3">
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Required</div><div id="modalReqCount" class="fs-4 fw-bold text-primary">0</div></div>
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Valid</div><div id="modalValidCount" class="fs-4 fw-bold text-success">0</div></div>
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Expiring Soon</div><div id="modalExpiringCount" class="fs-4 fw-bold text-warning">0</div></div>
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Issues</div><div id="modalInvalidCount" class="fs-4 fw-bold text-danger">0</div></div>
                        </div>
                        <div class="progress-container" id="modalProgressContainer" data-progress-text="0%" style="height: 12px;"><div class="progress" style="height: 12px;"><div class="progress-bar" id="modalProgressBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div>
                    </div>
                    <h6 class="text-primary mt-4 mb-3">Unit Certificate Details</h6>
                    <ul class="list-group list-group-flush" id="modalCertList"><li class="list-group-item text-center text-muted p-4"><i>Loading certificate details...</i></li></ul>
                </div>
                <div class="modal-footer bg-light"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

           <div id="ingredients-block"></div>

@endsection


@section('footerscript')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // All JavaScript code from the previous correct version goes here.
        // No changes to the JavaScript are needed for this specific z-index fix.
        // Ensure the entire script block from the prior working version is pasted here.
        const { jsPDF } = window.jspdf;
        const table = document.getElementById('complianceTable');
        const thead = table.querySelector('thead');
        const tbody = table.querySelector('tbody');
        const detailsModalEl = document.getElementById('detailsModal');
        const detailsModal = new bootstrap.Modal(detailsModalEl);
        const modalUnitNameText = document.getElementById('modalUnitNameText');
        const modalUnitId = document.getElementById('modalUnitId');
        const modalUnitAddress = document.getElementById('modalUnitAddress');
        const modalReqCount = document.getElementById('modalReqCount');
        const modalValidCount = document.getElementById('modalValidCount');
        const modalExpiringCount = document.getElementById('modalExpiringCount');
        const modalInvalidCount = document.getElementById('modalInvalidCount');
        const modalProgressContainer = document.getElementById('modalProgressContainer');
        const modalProgressBar = document.getElementById('modalProgressBar');
        const modalCertList = document.getElementById('modalCertList');

        const downloadUnitExcelLink = document.getElementById('downloadUnitExcelLink');
        const downloadUnitPdfLink = document.getElementById('downloadUnitPdfLink');
        const downloadStaffCertsExcelLink = document.getElementById('downloadStaffCertsExcelLink');
        const resetAllFiltersBtn = document.getElementById('resetAllFiltersBtn');


        let currentSortColumn = null;
        let currentSortDirection = 'asc';
        let activeFilters = { corporateEntities: [], regions: [], units: [], address: '', complianceStatus: '' };

        const unitData = [ 
            
            @foreach($documentsList as $index => $results)
        @php 
        $unitDetails = DB::table('users')->where('id',$results->id)->first();
        $unitDetails2 = DB::table('users')->where('id',$unitDetails->created_by1 ?? '')->first();
        $unitDetails3 = DB::table('users')->where('id',$unitDetails->created_by ?? '')->first();
        
        $CorporateName = Helper::CorporateName($unitDetails->created_by);
        @endphp
            { id: {{$results->id ?? ''}}, corporateEntity: "{{$unitDetails3->company_name ?? ''}}", region: "{{$unitDetails2->company_name ?? ''}}", name: "{{ $unitDetails->company_name }}", address: "{{ $unitDetails->Company_address }}", certificates: [], staffMembers: [] },
            
            @endforeach
            ];

        function getCertificateCounts(certificates) { const required = certificates.length; const valid = certificates.filter(c => c.status === 'valid').length; const expiring = certificates.filter(c => c.status === 'valid' && c.expiringSoon === true).length; const expired = certificates.filter(c => c.status === 'expired').length; const missing = certificates.filter(c => c.status === 'missing').length; const invalid = expired + missing; return { required, valid, expiring, expired, missing, invalid }; }
        function calculateProgress(counts) { return counts.required > 0 ? Math.round((counts.valid / counts.required) * 100) : 0; }
        function getProgressClass(progress, requiredCount) { if (requiredCount === 0) return 'high'; if (progress >= 80) return 'high'; if (progress >= 50) return 'medium'; return 'low'; }
        function getBootstrapProgressBg(progressClass) { switch(progressClass) { case 'high': return 'bg-success'; case 'medium': return 'bg-warning'; case 'low': return 'bg-danger'; default: return 'bg-secondary'; } }
        function getOverallStatus(counts) { const unit = unitData.find(u => u.certificates.length === counts.required); if (unit && unit.id === 0 && counts.required === 0) return 'compliant'; if (counts.required === 0) return 'non-compliant'; if (counts.valid < counts.required) return 'non-compliant'; if (counts.expiring > 0) return 'expiring-soon'; return 'compliant'; }
        function getBootstrapBadgeBg(status) { switch(status) { case 'compliant': return 'bg-success'; case 'expiring-soon': return 'bg-warning text-dark'; case 'non-compliant': return 'bg-danger'; default: return 'bg-secondary'; } }
        function getModalCertStatusBadge(status, isExpiringSoon) { if(isExpiringSoon) return 'bg-warning text-dark'; switch(status) { case 'valid': return 'bg-success'; case 'expired': return 'bg-danger'; case 'missing': return 'bg-secondary'; default: return 'bg-light text-dark'; } }
        function formatDate(dateString) { if (!dateString) return "N/A"; try { const date = new Date(dateString); if (isNaN(date.getTime())) return dateString; return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' }); } catch (e) { return dateString; } }
        function isStaffCertificateExpiringSoon(expiryDate, daysThreshold = 90) { if (!expiryDate) return false; try { const today = new Date(); today.setHours(0,0,0,0); const expiry = new Date(expiryDate); if(isNaN(expiry.getTime())) return false; expiry.setHours(0,0,0,0); const diffTime = expiry - today; const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); return diffDays >= 0 && diffDays <= daysThreshold; } catch (e) { return false; } }

        function createTableRow(unit, index) {
             let url = '{{route("corporatefostacunitlinces")}}';
                    $.ajax({
            type: "GET",
            url: url,
            data: { id: unit.id }, // id bhejni hai
            success: function(response) {
    var requried = response.data.requried;
    var valid = response.data.valid;
    var expiry = response.data.expiry;

    $("#requriedunit_" + unit.id).html(requried);
    $("#validunit_" + unit.id).html(valid);
    $("#expringunit_" + unit.id).html(expiry);

   var complianceHtml = (response.data.totalCompliance == 1)
    ? '<button class="btn btn-success btn-sm">Compliance</button>'
    : '<button class="btn btn-danger btn-sm">Non-Compliance</button>';

$("#compliance_status_" + unit.id).html(complianceHtml);

}
                    });
                    
            const counts = getCertificateCounts(unit.certificates); const progress = calculateProgress(counts);
            let progressClass, overallStatus, complianceStatusText, badgeBg, progressBg;
            if (unit.id === 0 && unit.certificates.length === 0) { progressClass = 'high'; overallStatus = 'compliant'; complianceStatusText = 'compliant'; badgeBg = getBootstrapBadgeBg('compliant'); progressBg = getBootstrapProgressBg('high'); }
            else { progressClass = getProgressClass(progress, counts.required); overallStatus = getOverallStatus(counts); complianceStatusText = overallStatus.replace('-', ' '); badgeBg = getBootstrapBadgeBg(overallStatus); progressBg = getBootstrapProgressBg(progressClass); }
            const tr = document.createElement('tr'); tr.dataset.unitId = unit.id; tr.style.cursor = 'pointer';
            const validTooltip = counts.required > 0 ? `<span class="tooltiptext-custom">${counts.valid} of ${counts.required} certs valid.</span>` : '<span class="tooltiptext-custom">No certs required.</span>';
            const expiringTooltip = counts.expiring > 0 ? `<span class="tooltiptext-custom">${counts.expiring} cert${counts.expiring !== 1 ? 's' : ''} expiring.</span>` : '<span class="tooltiptext-custom">No certs expiring.</span>';
            const invalidTooltip = (counts.expired > 0 || counts.missing > 0) ? `<span class="tooltiptext-custom">${counts.expired} expired, ${counts.missing} missing.</span>` : '<span class="tooltiptext-custom">No issues.</span>';
            const reqTooltip = counts.required > 0 ? `<span class="tooltiptext-custom">${counts.required} cert${counts.required !== 1 ? 's' : ''} required.</span>` : '<span class="tooltiptext-custom">No certs required.</span>';
            tr.innerHTML = `<td class="text-center">${index + 1}</td><td><div>${unit.name}</div><small class="text-muted">${unit.corporateEntity} - ${unit.region}</small></td><td>${unit.address}</td>
<td class="col-cert-status"><div class="cert-status-box high-progress"><div class="row g-2 mb-2 cert-metrics-grid"><div class="col cert-metric cert-metric-required"><span class="cert-metric-label">Required</span><span class="cert-metric-value tooltip-custom" id="requriedunit_${unit.id}">0<span class="tooltiptext-custom">No certs required.</span></span></div><div class="col cert-metric cert-metric-valid"><span class="cert-metric-label">Valid</span><span class="cert-metric-value tooltip-custom" id="validunit_${unit.id}">0<span class="tooltiptext-custom">No certs required.</span></span></div><div class="col cert-metric cert-metric-expiring"><span class="cert-metric-label" id="expringunit_${unit.id}">Expiring</span><span class="cert-metric-value tooltip-custom">0<span class="tooltiptext-custom">No certs expiring.</span></span></div></div><div class="progress-container" data-progress-text="N/A"><div class="progress" style="height: 10px;"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div></div><button class="btn btn-sm btn-outline-primary w-100 mt-2 view-details-btn"><i class="bi bi-search me-1"></i> View Details</button></div></td>            
            <td class="text-center"><span id="compliance_status_${unit.id}"></span></td>`;
            tr.addEventListener('click', (e) => { if (!e.target.closest('.view-details-btn') && !e.target.closest('.tooltip-custom') && !e.target.closest('.dropdown')) { openModal(unit.id); }});
            tr.querySelector('.view-details-btn').addEventListener('click', () => openModal(unit.id));
            return tr;
        }
        function populateTable(data) { tbody.innerHTML = ''; if (data.length === 0) { tbody.innerHTML = '<tr><td colspan="5" class="text-center p-5 text-muted"><i>No matching data found.</i></td></tr>'; return; } data.forEach((unit, index) => { tbody.appendChild(createTableRow(unit, index)); });}
        function openModal(unitId) {
            let url = '{{route("corporatefostaclinces")}}';
        $.ajax({
            type: "GET",
            url: url,
            data:{id:unitId},
            success: function(response) {
                if(response.status == true){
                    $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
                }
                else{
                          $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
                    //alert('error','There is some problem to get ingredient!Please contact to your server administrator');
                }
            },
            error: function(data) {
                      $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
               //alert('error','There is some problem to get ingredient!Please contact to your server administrator');
            }
        }); 
        
        
        
        }

        const unitNameFilterIcon = document.getElementById('unitNameFilterIcon');
        const corporateEntityFilterStepEl = document.getElementById('corporateEntityFilterStep');
        const regionFilterStepEl = document.getElementById('regionFilterStep');
        const unitFilterStepEl = document.getElementById('unitFilterStep');
        const corporateEntityCheckboxList = document.getElementById('corporateEntityCheckboxList');
        const regionCheckboxList = document.getElementById('regionCheckboxList');
        const unitCheckboxList = document.getElementById('unitCheckboxList');
        const filterAddressInput = document.getElementById('filterAddressInput');
        const addressFilterIcon = document.getElementById('addressFilterIcon');
        const filterComplianceStatusSelect = document.getElementById('filterComplianceStatusSelect');
        const complianceStatusFilterIcon = document.getElementById('complianceStatusFilterIcon');

        function showFilterStep(stepName) {
            [corporateEntityFilterStepEl, regionFilterStepEl, unitFilterStepEl].forEach(step => step.classList.add('d-none'));
            if (stepName === 'corporateEntity') corporateEntityFilterStepEl.classList.remove('d-none');
            else if (stepName === 'region') regionFilterStepEl.classList.remove('d-none');
            else if (stepName === 'unit') unitFilterStepEl.classList.remove('d-none');
        }

        function createCheckboxItem(id, value, label, type, isChecked) {
            const div = document.createElement('div');
            div.className = 'form-check';
            div.innerHTML = `
                <input class="form-check-input filter-checkbox" type="checkbox" value="${value}" id="${type}-${id}" data-type="${type}" ${isChecked ? 'checked' : ''}>
                <label class="form-check-label" for="${type}-${id}">${label}</label>
            `;
            return div;
        }

        function populateCorporateEntityCheckboxes() {
            corporateEntityCheckboxList.innerHTML = '';
            const corporateEntities = [...new Set(unitData.map(u => u.corporateEntity))].sort();
            if (corporateEntities.length === 0) { corporateEntityCheckboxList.innerHTML = '<small class="text-muted">No corporate entities.</small>'; return; }
            corporateEntities.forEach((ce, index) => {
                if (ce) corporateEntityCheckboxList.appendChild(createCheckboxItem(`ce-${index}`, ce, ce, 'corporateEntity', activeFilters.corporateEntities.includes(ce)));
            });
        }
        function populateRegionCheckboxes() {
            regionCheckboxList.innerHTML = '';
            let availableRegions = [];
            if (activeFilters.corporateEntities.length > 0) {
                availableRegions = [...new Set(unitData.filter(u => activeFilters.corporateEntities.includes(u.corporateEntity)).map(u => u.region))].sort();
            }
            activeFilters.regions = activeFilters.regions.filter(r => availableRegions.includes(r));
            if (availableRegions.length === 0) { regionCheckboxList.innerHTML = '<small class="text-muted">No regions for current selection or select Corporate Entity.</small>'; return; }
            availableRegions.forEach((r, index) => {
                if (r) regionCheckboxList.appendChild(createCheckboxItem(`reg-${index}`, r, r, 'region', activeFilters.regions.includes(r)));
            });
        }
        function populateUnitCheckboxes() {
            unitCheckboxList.innerHTML = '';
            let filteredUnits = [];
            if (activeFilters.corporateEntities.length > 0 && activeFilters.regions.length > 0) {
                filteredUnits = unitData.filter(u => activeFilters.corporateEntities.includes(u.corporateEntity) && activeFilters.regions.includes(u.region));
            }
            const availableUnits = [...new Set(filteredUnits.map(u => u.name))].sort();
            activeFilters.units = activeFilters.units.filter(uName => availableUnits.includes(uName));
            if (availableUnits.length === 0) { unitCheckboxList.innerHTML = '<small class="text-muted">No units for current selection or select Region.</small>'; return; }
            availableUnits.forEach((unitName, index) => {
                if (unitName) unitCheckboxList.appendChild(createCheckboxItem(`unit-${index}`, unitName, unitName, 'unit', activeFilters.units.includes(unitName)));
            });
        }

        document.getElementById('unitNameFilterDropdown').addEventListener('change', (event) => {
            if (event.target.classList.contains('filter-checkbox')) {
                const type = event.target.dataset.type;
                const value = event.target.value;
                const isChecked = event.target.checked;

                if (type === 'corporateEntity') {
                    if (isChecked) activeFilters.corporateEntities.push(value);
                    else activeFilters.corporateEntities = activeFilters.corporateEntities.filter(v => v !== value);
                    activeFilters.regions = []; activeFilters.units = [];
                    populateRegionCheckboxes(); populateUnitCheckboxes();
                    if (activeFilters.corporateEntities.length > 0) showFilterStep('region'); else showFilterStep('corporateEntity');
                } else if (type === 'region') {
                    if (isChecked) activeFilters.regions.push(value);
                    else activeFilters.regions = activeFilters.regions.filter(v => v !== value);
                    activeFilters.units = [];
                    populateUnitCheckboxes();
                    if (activeFilters.regions.length > 0) showFilterStep('unit'); else showFilterStep('region');
                } else if (type === 'unit') {
                    if (isChecked) activeFilters.units.push(value);
                    else activeFilters.units = activeFilters.units.filter(v => v !== value);
                }
            }
        });

        ['selectAllCorporateEntity', 'deselectAllCorporateEntity', 'selectAllRegion', 'deselectAllRegion', 'selectAllUnit', 'deselectAllUnit'].forEach(id => {
            document.getElementById(id).addEventListener('click', (event) => {
                const type = event.target.dataset.type;
                const selectAll = id.startsWith('selectAll');
                const checkboxContainer = document.getElementById(`${type}CheckboxList`);
                const checkboxes = checkboxContainer.querySelectorAll('.filter-checkbox');
                const currentStep = type === 'corporateEntity' ? 'corporateEntity' : (type === 'region' ? 'region' : 'unit');

                checkboxes.forEach(cb => { cb.checked = selectAll; });
                const values = Array.from(checkboxes).map(cb => cb.value);
                if (selectAll) activeFilters[`${type}s`] = [...new Set(values)];
                else activeFilters[`${type}s`] = [];

                if (type === 'corporateEntity') {
                    activeFilters.regions = []; activeFilters.units = [];
                    populateRegionCheckboxes(); populateUnitCheckboxes();
                    if (activeFilters.corporateEntities.length > 0 && selectAll) showFilterStep('region'); else showFilterStep('corporateEntity');
                } else if (type === 'region') {
                    activeFilters.units = [];
                    populateUnitCheckboxes();
                    if (activeFilters.regions.length > 0 && selectAll) showFilterStep('unit'); else showFilterStep('region');
                }
                 if (!selectAll) showFilterStep(currentStep);
            });
        });

        document.getElementById('backToCorporateEntity').addEventListener('click', () => {
            activeFilters.regions = []; activeFilters.units = [];
            populateRegionCheckboxes(); populateUnitCheckboxes();
            showFilterStep('corporateEntity');
        });
        document.getElementById('backToRegion').addEventListener('click', () => {
            activeFilters.units = [];
            populateUnitCheckboxes();
            showFilterStep('region');
        });


        function applyAllFiltersAndRender() {
            let filteredData = [...unitData];
            if (activeFilters.corporateEntities.length > 0) filteredData = filteredData.filter(unit => activeFilters.corporateEntities.includes(unit.corporateEntity));
            if (activeFilters.regions.length > 0) filteredData = filteredData.filter(unit => activeFilters.regions.includes(unit.region));
            if (activeFilters.units.length > 0) filteredData = filteredData.filter(unit => activeFilters.units.includes(unit.name));
            unitNameFilterIcon.classList.toggle('active', !!(activeFilters.corporateEntities.length || activeFilters.regions.length || activeFilters.units.length));
            if (activeFilters.address) filteredData = filteredData.filter(unit => unit.address.toLowerCase().includes(activeFilters.address.toLowerCase()));
            addressFilterIcon.classList.toggle('active', !!activeFilters.address);
            if (activeFilters.complianceStatus) {
                filteredData = filteredData.filter(unit => {
                    const counts = getCertificateCounts(unit.certificates);
                    return getOverallStatus(counts) === activeFilters.complianceStatus;
                });
            }
            complianceStatusFilterIcon.classList.toggle('active', !!activeFilters.complianceStatus);
            if (currentSortColumn) filteredData = sortData(filteredData, currentSortColumn, currentSortDirection);
            populateTable(filteredData);
        }

        document.getElementById('unitNameFilterIcon').addEventListener('show.bs.dropdown', () => {
            populateCorporateEntityCheckboxes(); populateRegionCheckboxes(); populateUnitCheckboxes();
            showFilterStep('corporateEntity');
        });
        document.getElementById('clearUnitFilterBtn').addEventListener('click', () => {
            activeFilters.corporateEntities = []; activeFilters.regions = []; activeFilters.units = [];
            populateCorporateEntityCheckboxes(); populateRegionCheckboxes(); populateUnitCheckboxes();
            showFilterStep('corporateEntity');
            applyAllFiltersAndRender();
        });
        document.getElementById('applyAndCloseUnitFilterBtn').addEventListener('click', () => { applyAllFiltersAndRender(); });

        document.getElementById('addressFilterIcon').addEventListener('show.bs.dropdown', () => { filterAddressInput.value = activeFilters.address; });
        document.getElementById('applyAddressFilterBtn').addEventListener('click', () => { activeFilters.address = filterAddressInput.value.trim(); applyAllFiltersAndRender(); });
        document.getElementById('clearAddressFilterBtn').addEventListener('click', () => { filterAddressInput.value = ""; activeFilters.address = ""; applyAllFiltersAndRender(); });
        document.getElementById('complianceStatusFilterIcon').addEventListener('show.bs.dropdown', () => { filterComplianceStatusSelect.value = activeFilters.complianceStatus; });
        document.getElementById('applyComplianceFilterBtn').addEventListener('click', () => { activeFilters.complianceStatus = filterComplianceStatusSelect.value; applyAllFiltersAndRender(); });
        document.getElementById('clearComplianceFilterBtn').addEventListener('click', () => { filterComplianceStatusSelect.value = ""; activeFilters.complianceStatus = ""; applyAllFiltersAndRender(); });
        resetAllFiltersBtn.addEventListener('click', () => {
            activeFilters = { corporateEntities: [], regions: [], units: [], address: '', complianceStatus: '' };
            populateCorporateEntityCheckboxes(); populateRegionCheckboxes(); populateUnitCheckboxes();
            showFilterStep('corporateEntity');
            filterAddressInput.value = ""; filterComplianceStatusSelect.value = "";
            applyAllFiltersAndRender();
        });

        function sortData(data, columnKey, direction) {
            const sortedData = [...data];
            sortedData.sort((a, b) => {
                 let cellA, cellB; let comparison = 0;
                 const countsA = getCertificateCounts(a.certificates); const countsB = getCertificateCounts(b.certificates);
                 const statusA = getOverallStatus(countsA); const statusB = getOverallStatus(countsB);
                 const indexA = data.indexOf(a); const indexB = data.indexOf(b);
                 switch (columnKey) {
                    case 'slNo': cellA = indexA; cellB = indexB; break;
                    case 'unitName': cellA = a.name.toLowerCase(); cellB = b.name.toLowerCase(); break;
                    case 'address': cellA = a.address.toLowerCase(); cellB = b.address.toLowerCase(); break;
                    case 'certificateStatus': comparison = countsA.required - countsB.required; if (comparison === 0) { comparison = countsB.valid - countsA.valid; } if (comparison === 0) { comparison = countsA.invalid - countsB.invalid; } cellA = 0; cellB = 0; break;
                    case 'complianceStatus': const statusOrder = { 'compliant': 1, 'expiring-soon': 2, 'non-compliant': 3 }; cellA = statusOrder[statusA] || 99; cellB = statusOrder[statusB] || 99; break;
                    default: cellA = ''; cellB = '';
                }
                 if (comparison === 0) { if (cellA > cellB) { comparison = 1; } else if (cellA < cellB) { comparison = -1; } }
                 return direction === 'desc' ? (comparison * -1) : comparison;
             });
             return sortedData;
        }
        thead.addEventListener('click', (event) => {
             const header = event.target.closest('th[data-column]');
             if (header && !event.target.closest('.dropdown')) {
                 const columnKey = header.dataset.column; const indicator = header.querySelector('.sort-indicator'); if (!indicator) return;
                 thead.querySelectorAll('th .sort-indicator').forEach(ind => { if (ind !== indicator) { ind.className = 'sort-indicator'; } });
                 if (currentSortColumn === columnKey) { currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc'; }
                 else { currentSortColumn = columnKey; currentSortDirection = 'asc'; }
                 indicator.className = `sort-indicator ${currentSortDirection}`; applyAllFiltersAndRender();
             }
        });

        function getCurrentlyDisplayedDataForExport() {
            let dataToExport = [...unitData];
            if (activeFilters.corporateEntities.length > 0) dataToExport = dataToExport.filter(u => activeFilters.corporateEntities.includes(u.corporateEntity));
            if (activeFilters.regions.length > 0) dataToExport = dataToExport.filter(u => activeFilters.regions.includes(u.region));
            if (activeFilters.units.length > 0) dataToExport = dataToExport.filter(u => activeFilters.units.includes(u.name));
            if (activeFilters.address) dataToExport = dataToExport.filter(u => u.address.toLowerCase().includes(activeFilters.address.toLowerCase()));
            if (currentSortColumn) dataToExport = sortData(dataToExport, currentSortColumn, currentSortDirection);
            return dataToExport;
        }
        function getVisibleTableDataForUnitExport() {
             let dataToDisplay = getCurrentlyDisplayedDataForExport();
             if (activeFilters.complianceStatus) { dataToDisplay = dataToDisplay.filter(u => { const counts = getCertificateCounts(u.certificates); return getOverallStatus(counts) === activeFilters.complianceStatus; }); }
             return dataToDisplay.map((unit, index) => {
                 const counts = getCertificateCounts(unit.certificates); let overallStatus = getOverallStatus(counts);
                 if (unit.id === 0 && unit.certificates.length === 0) { overallStatus = 'compliant'; }
                 return { slNo: index + 1, unitName: unit.name, unitCorporateEntity: unit.corporateEntity, unitRegion: unit.region, address: unit.address, requiredCerts: counts.required, validCerts: counts.valid, expiringCerts: counts.expiring, issues: counts.invalid, complianceStatus: overallStatus.replace('-', ' ') };
             });
         }
        function exportToExcel() {
             const dataToExport = getVisibleTableDataForUnitExport(); if (dataToExport.length === 0) { alert("No unit data to export."); return; }
             const exportHeaders = ["Sl. No", "Unit Name", "Corporate Entity", "Region", "Address", "Required Certs", "Valid Certs", "Expiring Certs", "Issues", "Compliance Status"];
             const exportRows = dataToExport.map(row => [row.slNo, row.unitName, row.unitCorporateEntity, row.unitRegion, row.address, row.requiredCerts, row.validCerts, row.expiringCerts, row.issues, row.complianceStatus]);
             const ws = XLSX.utils.aoa_to_sheet([exportHeaders, ...exportRows]); const wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, "Unit Compliance");
             const timestamp = new Date().toISOString().slice(0, 10); XLSX.writeFile(wb, `Unit_Compliance_Status_${timestamp}.xlsx`);
        }
        function exportToPdf() {
            const dataToExport = getVisibleTableDataForUnitExport(); if (dataToExport.length === 0) { alert("No unit data to export."); return; }
            const doc = new jsPDF({ orientation: 'landscape' });
            const exportHeaders = ["Sl.", "Unit", "Corp.", "Region", "Address", "Req", "Valid", "Exp.",  "Status"];
            const exportBody = dataToExport.map(row => [row.slNo, row.unitName, row.unitCorporateEntity, row.unitRegion, row.address, row.requiredCerts, row.validCerts, row.expiringCerts,  row.complianceStatus]);
            const timestamp = new Date().toLocaleString(); const title = "Unit Compliance Status Report";
            doc.autoTable({ head: [exportHeaders], body: exportBody, startY: 20, theme: 'grid', headStyles: { fillColor: [74, 111, 165] },
                columnStyles: { 0: { cellWidth: 8 }, 1: { cellWidth: 30 }, 2: {cellWidth: 25}, 3: {cellWidth: 20}, 4: { cellWidth: 50 }, 5: { cellWidth: 12, halign: 'center' }, 6: { cellWidth: 12, halign: 'center' }, 7: { cellWidth: 15, halign: 'center' }, 8: { cellWidth: 12, halign: 'center' }, 9: { cellWidth: 25, halign: 'center' } },
                didDrawPage: function (data) { doc.setFontSize(16); doc.setTextColor(40); doc.text(title, data.settings.margin.left, 15); let str = "Page " + doc.internal.getNumberOfPages(); doc.setFontSize(10); doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 10); doc.text(`Generated: ${timestamp}`, doc.internal.pageSize.width - data.settings.margin.right, doc.internal.pageSize.height - 10, { align: 'right' }); } });
            const filenameTimestamp = new Date().toISOString().slice(0, 10); doc.save(`Unit_Compliance_Status_${filenameTimestamp}.pdf`);
        }
        function exportStaffCertificatesToExcel() {
            const filteredUnits = getCurrentlyDisplayedDataForExport();
            if (filteredUnits.length === 0) { alert("No units match the current filters to export staff certificates from."); return; }
            const staffCertsData = []; let slNo = 1;
            filteredUnits.forEach(unit => {
                if (unit.staffMembers && unit.staffMembers.length > 0) {
                    unit.staffMembers.forEach(staff => {
                        if (staff.certificates && staff.certificates.length > 0) {
                            staff.certificates.forEach(cert => {
                                const expiringSoon = isStaffCertificateExpiringSoon(cert.expiry);
                                staffCertsData.push({ "Sl. No": slNo++, "Unit Name": unit.name, "Corporate Entity": unit.corporateEntity || "N/A", "Region": unit.region || "N/A", "Unit Address": unit.address, "Staff ID": staff.staffId || "N/A", "Staff Name": staff.staffName || "N/A", "Staff Role": staff.role || "N/A", "Certificate Name": cert.name, "Certificate Status": cert.status.charAt(0).toUpperCase() + cert.status.slice(1), "Expiry Date": formatDate(cert.expiry), "Expiring Soon": expiringSoon ? "Yes" : "No" });
                            });
                        } else { staffCertsData.push({ "Sl. No": slNo++, "Unit Name": unit.name, "Corporate Entity": unit.corporateEntity || "N/A", "Region": unit.region || "N/A", "Unit Address": unit.address, "Staff ID": staff.staffId || "N/A", "Staff Name": staff.staffName || "N/A", "Staff Role": staff.role || "N/A", "Certificate Name": "No certificates listed", "Certificate Status": "N/A", "Expiry Date": "N/A", "Expiring Soon": "N/A"}); }
                    });
                }
            });
            if (staffCertsData.length === 0) { alert("No staff certificate data found for the selected units."); return; }
            const ws = XLSX.utils.json_to_sheet(staffCertsData); const wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, "Staff Certificates");
            const timestamp = new Date().toISOString().slice(0, 10); XLSX.writeFile(wb, `Staff_Certificates_Status_${timestamp}.xlsx`);
        }

        downloadUnitExcelLink.addEventListener('click', (e) => { e.preventDefault(); exportToExcel(); });
        downloadUnitPdfLink.addEventListener('click', (e) => { e.preventDefault(); exportToPdf(); });
        downloadStaffCertsExcelLink.addEventListener('click', (e) => { e.preventDefault(); exportStaffCertificatesToExcel(); });

        document.addEventListener('DOMContentLoaded', () => {
            populateCorporateEntityCheckboxes(); populateRegionCheckboxes(); populateUnitCheckboxes();
            showFilterStep('corporateEntity');
            applyAllFiltersAndRender();
        });
    </script>
    
    
    <script>
        
         function openHistoryModal(licenseNumber) {
             
            
            let url = '{{route("UnitLincesHistory")}}';
        $.ajax({
            type: "GET",
            url: url,
            data:{id:licenseNumber},
            success: function(response) {
                if(response.status == true){
                    $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
                }
                else{
                          $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
                    //alert('error','There is some problem to get ingredient!Please contact to your server administrator');
                }
            },
            error: function(data) {
                      $('#ingredients-block').empty();
                    $('#ingredients-block').html(response);
                    $('#productexampleExtraLargeModal').modal('show');
               //alert('error','There is some problem to get ingredient!Please contact to your server administrator');
            }
        });    
}
    </script>
@endsection
   