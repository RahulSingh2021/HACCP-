<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Advanced Thawing Record with Enhanced Features</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Select2 for searchable dropdowns -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <style>
        :root {
            --primary-color: #007bff;
            --header-bg-color: #6f42c1;
            --header-text-color: #ffffff;
            --subheading-color: #6f42c1;
            --body-bg-color: #f4f7f6;
            --info-box-bg: #e9ecef;
            --card-border-color: #dee2e6;
        }
        body { background-color: var(--body-bg-color); }
        .title { color: var(--primary-color); font-weight: bold; }
        
        .table > thead { vertical-align: middle; }
        .table-custom-header th { background-color: var(--header-bg-color); color: var(--header-text-color); }
        
        /* --- Styles for Sticky Header and Column --- */
        .table-responsive {
            max-height: 75vh; /* Set a max-height for the scrolling container */
            overflow: auto;
        }
        .table-custom-header th {
            position: sticky;
            top: 0;
            z-index: 2;
        }
        .fixed-column { 
            position: sticky; 
            left: 0; 
            z-index: 1; 
            background-color: #f8f9fa; /* A slightly off-white to distinguish */
        }
         /* Ensure the top-left corner cell is above others */
        .table-custom-header th.fixed-column {
            z-index: 3;
        }

        .cell-subheading { font-weight: 600; color: var(--subheading-color); }
        .signature-pad-container { border: 1px solid #ced4da; border-radius: 0.25rem; position: relative; }
        .signature-pad-container canvas { width: 100%; height: 150px; border-radius: 0.25rem; }
        .signature-image { max-width: 120px; height: auto; border-bottom: 1px solid #eee; }
        .clear-signature { position: absolute; top: 5px; right: 5px; }
        .select2-container { width: 100% !important; }
        .temp-img-preview { max-height: 60px; border-radius: 4px; margin-top: 5px; border: 1px solid #ddd; padding: 2px; }
        .temp-thumbnail { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 1px solid #ccc; margin-top: 4px; }
        .camera-icon { cursor: pointer; }
        .standard-text { font-size: 0.8em; font-style: italic; color: #666; }
        
        #issueInfoBanner, #completionInfoBanner, #consolidatedInfo { background-color: var(--info-box-bg); }
        #completionStandardBanner { background-color: #cff4fc; border: 1px solid #9eeaf9; color: #055160; }

        .filter-icon {
            cursor: pointer;
            color: #ffffff;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .filter-icon:hover, .filter-icon.active { opacity: 1; }
        .filter-icon.active { color: #0dcaf0; }
        .filter-form-label { font-weight: 600; color: var(--subheading-color); margin-bottom: .5rem; }

        /* --- Mobile Responsive Card View --- */
        @media (max-width: 768px) {
            .table-responsive {
                max-height: none; /* Remove height constraint on mobile */
                border: none;
            }
            .table thead {
                display: none; /* Hide the original header */
            }
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 1rem;
                border: 1px solid var(--card-border-color);
                border-radius: 0.375rem;
                background-color: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            .table td {
                text-align: right; /* Align content to the right */
                padding: 0.75rem;
                position: relative;
                border-bottom: 1px solid #eee;
            }
             .table td:last-child {
                border-bottom: none;
            }
            .table td::before {
                content: attr(data-label); /* Use data-label for the title */
                position: absolute;
                left: 0.75rem;
                width: 50%;
                text-align: left;
                font-weight: 600;
                color: var(--subheading-color);
            }
            .fixed-column {
                position: static; /* Unstick the first column */
                left: auto;
                z-index: auto;
                background-color: transparent;
            }
            /* Adjustments for complex cells in mobile view */
            .table td .signature-image, .table td .temp-thumbnail {
                max-width: 80px;
            }
            .table td .btn {
                width: auto;
                padding: .25rem .5rem;
                font-size: .875rem;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid mt-4">
    <div class="text-center mb-4"><h1 class="title">Thawing Record (OPRP)</h1></div>
    <div class="d-flex justify-content-end mb-3 gap-2">
        <button type="button" class="btn btn-warning" id="clearAllFiltersBtn" onclick="clearAllFilters()">
            <i class="bi bi-x-circle"></i> Clear All Filters
        </button>
        <button type="button" class="btn btn-info" id="bulkVerifyBtn" onclick="openBulkVerificationModal()" disabled>
            <i class="bi bi-check2-circle"></i> Bulk Verify
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#thawingModal">
            <i class="bi bi-plus-circle"></i> Add New Record
        </button>
    </div>
    <!-- Main Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle table-custom-header">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th class="fixed-column">Outlet Details <i class="bi bi-funnel filter-icon ms-1" data-filter-key="outlet"></i></th>
                    <th>Product Details <i class="bi bi-funnel filter-icon ms-1" data-filter-key="product"></i></th>
                    <th>Unit Details <i class="bi bi-funnel filter-icon ms-1" data-filter-key="unitDetails"></i></th>
                    <th>Quantity Details / Method <i class="bi bi-funnel filter-icon ms-1" data-filter-key="quantity"></i></th>
                    <th>Thawing Started <i class="bi bi-funnel filter-icon ms-1" data-filter-key="thawStart"></i></th>
                    <th>Initial Temp. <i class="bi bi-funnel filter-icon ms-1" data-filter-key="initialTemp"></i></th>
                    <th>Initiated by</th>
                    <th>Thawing Completed <i class="bi bi-funnel filter-icon ms-1" data-filter-key="thawEnd"></i></th>
                    <th>Final Temp. <i class="bi bi-funnel filter-icon ms-1" data-filter-key="finalTemp"></i></th>
                    <th>Time Lapse <i class="bi bi-funnel filter-icon ms-1" data-filter-key="timelapse"></i></th>
                    <th>Completed by <i class="bi bi-funnel filter-icon ms-1" data-filter-key="completedBy"></i></th>
                    <th>Issued To / Shelf Life <i class="bi bi-funnel filter-icon ms-1" data-filter-key="issuedTo"></i></th>
                    <th>Corrective Action</th>
                    <th>Verification <i class="bi bi-funnel filter-icon ms-1" data-filter-key="verification"></i></th>
                </tr>
            </thead>
            <tbody id="thawingTableBody"></tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div class="d-flex justify-content-between align-items-center mt-3" id="pagination-container">
        <div class="d-flex align-items-center">
            <span class="me-2">Show</span>
            <select class="form-select form-select-sm" id="rowsPerPageSelect" style="width: auto;" onchange="changeRowsPerPage(this.value)">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <span class="ms-2">entries</span>
        </div>
        <div id="pagination-status" class="text-muted"></div>
        <nav>
            <ul class="pagination mb-0" id="pagination-links"></ul>
        </nav>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="thawingModal" tabindex="-1"><div class="modal-dialog modal-xl"><div class="modal-content">
    <div class="modal-header bg-primary text-white"><h5 class="modal-title" id="thawingModalLabel">Start Thawing Record</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
    <div class="modal-body"><form id="thawingForm">
        <input type="hidden" id="editRecordUUID">
        <input type="hidden" id="thawStartHidden">
        <div class="row g-3">
            <div class="col-lg-4">
                <h5 class="mb-3">1. Select Item & Quantity</h5>
                <div class="mb-3"><label for="outletName" class="form-label">Outlet Location</label><select class="form-select" id="outletName" required></select></div>
                <div class="mb-3"><label for="productName" class="form-label">Product Name</label><select class="form-select" id="productName" required disabled></select></div>
                <div class="mb-3">
                    <label class="form-label">Available Batches (FEFO)</label>
                    <div id="batchSelectionSummary" class="form-control" style="height: auto; min-height: 80px; background-color: #e9ecef; font-size: 0.9em; max-height: 150px; overflow-y: auto;">
                         <small class="text-muted">Select a product to see stock.</small>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="thawingQuantity" class="form-label">Thawing Qty (kg)</label>
                    <input type="number" class="form-control" id="thawingQuantity" step="0.1" required disabled>
                    <div id="quantityError" class="text-danger small mt-1"></div>
                </div>
                 <div class="mb-3">
                    <label class="form-label">Batch Issuance Details (FEFO)</label>
                    <div id="issuingBatchDetails" class="form-control" style="height: auto; min-height: 80px; background-color: #f8f9fa; font-size: 0.9em;">
                         <small class="text-muted">Enter a quantity to see which batches will be used.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="mb-3">2. Enter Thawing Details</h5>
                <div class="mb-3">
                    <label for="initialTemp" class="form-label">Initial Temp (°C) <small>(Std: ≤ -18°C)</small></label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="initialTemp" max="0" step="0.1" placeholder="≤ -18°C" required>
                        <span class="input-group-text camera-icon" onclick="triggerImageCapture('initialTempImgInput')"><i class="bi bi-camera-fill"></i></span>
                    </div>
                    <div id="thawStartDisplay" class="small text-muted mt-1"></div>
                    <input type="file" accept="image/*" capture="environment" id="initialTempImgInput" class="d-none" onchange="handleImageCapture(event, 'initialTempImgPreview')">
                    <img id="initialTempImgPreview" class="temp-img-preview d-none" />
                </div>
                <div class="mb-3"><label for="thawingMethod" class="form-label">Thawing Method</label><select class="form-select" id="thawingMethod"><option>Refrigerator</option><option>Chilled Running Water</option><option>Microwave</option></select></div>
                
                <div class="mb-3 d-none" id="waterTempContainer">
                    <label for="waterTemp" class="form-label">Water Temp (°C) <small>(Std: < 15°C)</small></label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="waterTemp" max="21" step="0.1">
                        <span class="input-group-text camera-icon" onclick="triggerImageCapture('waterTempImgInput')"><i class="bi bi-camera-fill"></i></span>
                    </div>
                    <input type="file" accept="image/*" capture="environment" id="waterTempImgInput" class="d-none" onchange="handleImageCapture(event, 'waterTempImgPreview')">
                    <img id="waterTempImgPreview" class="temp-img-preview d-none" />
                </div>

                <div class="mb-3"><label for="thawingUnit" class="form-label">Thawing Unit Number</label><select class="form-select" id="thawingUnit"></select></div>
            </div>
            <div class="col-lg-4">
                <h5 class="mb-2">3. Initiated By</h5>
                <div class="mb-3"><label for="initiatedBy" class="form-label">Name</label><input type="text" class="form-control" id="initiatedBy" required readonly></div>
                <div class="mb-3"><label class="form-label">Signature</label><div class="signature-pad-container"><canvas id="initiatedBySignPad"></canvas><button type="button" class="btn btn-sm btn-outline-danger clear-signature" onclick="initiatedBySignaturePad.clear()"><i class="bi bi-x-lg"></i></button></div></div>
            </div>
        </div>
    </form></div>
    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-primary" onclick="saveRecord()">Save Record</button></div>
</div></div></div>

<!-- Complete Thawing Modal -->
<!--<div class="modal fade" id="completeThawingModal" tabindex="-1">-->
<!--    <div class="modal-dialog modal-lg modal-dialog-centered">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header flex-column align-items-start">-->
<!--                <h5 class="modal-title mb-2">Complete Thawing Process</h5>-->
<!--                <div id="completionInfoBanner" class="p-2 w-100 rounded small"></div>-->
<!--                <div id="completionStandardBanner" class="p-2 w-100 rounded small mt-2"></div>-->
<!--                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"></button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <form id="completeThawingForm">-->
<!--                    <input type="hidden" id="completeRecordUUID">-->
<!--                     <input type="hidden" id="completeRecordId" class="completeRecordId">-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <h5>Completion Details</h5>-->
<!--                            <div class="mb-3">-->
<!--                                <label for="finalTemp" class="form-label">Final Temp (°C)</label>-->
<!--                                <div class="input-group">-->
<!--                                    <input type="number" class="form-control" id="finalTemp" placeholder="< 5°C" max="5" step="0.1" required>-->
<!--                                    <span class="input-group-text camera-icon" onclick="triggerImageCapture('finalTempImgInput')"><i class="bi bi-camera"></i></span>-->
<!--                                </div>-->
<!--                                <input type="file" accept="image/*" capture="environment" id="finalTempImgInput" class="d-none" onchange="handleImageCapture(event, 'finalTempImgPreview')">-->
<!--                                <img id="finalTempImgPreview" class="temp-img-preview d-none" />-->
<!--                            </div>-->
<!--                            <div class="mb-3">-->
<!--                                <label for="correctiveAction" class="form-label">Corrective Action</label>-->
<!--                                <textarea class="form-control" id="correctiveAction" rows="4"></textarea>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <h5>Completed By</h5>-->
<!--                            <div class="mb-3">-->
<!--                                <label for="completedByName" class="form-label">Name</label>-->
<!--                                <input type="text" class="form-control" id="completedByName" readonly required>-->
<!--                            </div>-->
<!--                            <div class="mb-3">-->
<!--                                <label class="form-label">Signature</label>-->
<!--                                <div class="signature-pad-container">-->
<!--                                    <canvas id="completedBySignPad"></canvas>-->
<!--                                    <button type="button" class="btn btn-sm btn-outline-danger clear-signature" onclick="completedBySignaturePad.clear()"><i class="bi bi-x-lg"></i></button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
<!--                <button type="button" class="btn btn-primary" onclick="saveCompletion()">Save Completion</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- Complete Thawing Modal -->
<div class="modal fade" id="completeThawingModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header flex-column align-items-start">
        <h5 class="modal-title mb-2">Complete Thawing Process</h5>
        <div id="completionInfoBanner" class="p-2 w-100 rounded small"></div>
        <div id="completionStandardBanner" class="p-2 w-100 rounded small mt-2"></div>
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="completeThawingForm">
          <!-- Hidden fields -->
          <input type="hidden" id="completeRecordUUID" name="uuid">
          <input type="hidden" id="completeRecordId" name="id">  <!-- agar aap DB id bhej rahe hain -->
          
          <div class="row">
            <div class="col-md-6">
              <h5>Completion Details</h5>
              <div class="mb-3">
                <label for="finalTemp" class="form-label">Final Temp (°C)</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="finalTemp" name="final_temp" placeholder="< 5°C" max="5" step="0.1" required>
                  <span class="input-group-text camera-icon" onclick="triggerImageCapture('finalTempImgInput')"><i class="bi bi-camera"></i></span>
                </div>
                <input type="file" accept="image/*" capture="environment" id="finalTempImgInput" class="d-none" onchange="handleImageCapture(event, 'finalTempImgPreview')">
                <img id="finalTempImgPreview" class="temp-img-preview d-none" />
              </div>
              
              <div class="mb-3">
                <label for="correctiveAction" class="form-label">Corrective Action</label>
                <textarea class="form-control" id="correctiveAction" name="corrective_action" rows="4"></textarea>
              </div>
            </div>
            
            <div class="col-md-6">
              <h5>Completed By</h5>
              <div class="mb-3">
                <label for="completedByName" class="form-label">Name</label>
                <input type="text" class="form-control" id="completedByName" name="completed_by" readonly required>
              </div>
              <div class="mb-3">
                <label class="form-label">Signature</label>
                <div class="signature-pad-container">
                  <canvas id="completedBySignPad"></canvas>
                  <button type="button" class="btn btn-sm btn-outline-danger clear-signature" onclick="completedBySignaturePad.clear()">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveCompletion()">Save Completion</button>
      </div>
    </div>
  </div>
</div>



<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Verification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <input type="hidden" id="verificationRecordUUID">
                          <input type="hidden" id="verificationRecordID">
                    <div class="mb-3">
                        <label for="verificationComments" class="form-label">Comments</label>
                        <textarea class="form-control" id="verificationComments" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="verifierName" class="form-label">Verifier Name</label>
                        <input type="text" class="form-control" id="verifierName" required>
                    </div>
                    <div class="mb-3">
                        <label for="verifierSignature" class="form-label">Signature</label>
                        <div class="signature-pad-container">
                            <canvas id="verifierSignPad"></canvas>
                            <button type="button" class="btn btn-sm btn-outline-danger clear-signature" onclick="verifierSignaturePad.clear()"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveVerification()">Save Verification</button>
            </div>
        </div>
    </div>
</div>

<!-- Issue Quantity Modal -->
<div class="modal fade" id="issueModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Issue Quantity to Sections</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="issueRecordUUID">
                <div class="p-3 mb-3 rounded" id="issueInfoBanner"></div>
                <h6 class="mb-3">Issued Items</h6>
                <div id="issuedItemsContainer">
                    <!-- Issued items will be dynamically added here -->
                </div>
                
                <hr>
                
                <h6 class="mb-3">Add New Item</h6>
                <div class="row g-3 align-items-center">
                    <div class="col-sm-4">
                        <select class="form-select" id="newIssueSection" aria-label="Section"></select>
                    </div>
                    <div class="col-sm-3">
                         <select class="form-select" id="newIssuePurpose" aria-label="Purpose"></select>
                    </div>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="newIssueQuantity" placeholder="Quantity (kg)" step="0.1">
                    </div>
                    <div class="col-sm-2 text-end">
                        <button type="button" class="btn btn-success w-100" onclick="addIssuedItem()">
                            <i class="bi bi-plus-circle"></i> Add
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveIssuedItems()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Temperature Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="fullScreenImage" src="" class="img-fluid" alt="Temperature Reading">
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="filterModalBody">
                <!-- Dynamic filter content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link text-danger" id="clearCurrentFilterBtn">Clear this Filter</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="applyFilterBtn">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    const currentUser = @json(['name' => $user_name]);
    const outlets = @json($outlets);
    
    let products = [ 
        // { id: 101, outletId: 1, name: "Frozen Chicken Breast", brand: "Prime Cuts" }, 
        // { id: 102, outletId: 1, name: "Frozen Beef Patties", brand: "Grill Master" }, 
        // { id: 201, outletId: 2, name: "Frozen Croissants", brand: "Paris Morning" }, 
        // { id: 301, outletId: 3, name: "Frozen Corn Kernels", brand: "Farm Fresh" },
        // { id: 401, outletId: 4, name: "Frozen Fish Fillets", brand: "Ocean's Best" }
    ];
    
     
    let batches = [ 
        // { productId: 101, number: "BT-CH-002", quantity: 30.0, manufacturingDate: "2025-07-01", stockInDate: "2025-08-12", storedUnit: "Freezer A-2", expiryDate: "2026-08-01" }, 
        // { productId: 101, number: "BT-CH-001", quantity: 25.5, manufacturingDate: "2025-06-01", stockInDate: "2025-08-10", storedUnit: "Freezer A-1", expiryDate: "2026-07-01" }, 
        // { productId: 101, number: "BT-CH-003-EMPTY", quantity: 0, manufacturingDate: "2025-07-01", stockInDate: "2025-08-15", storedUnit: "Freezer A-3", expiryDate: "2026-08-01" },
        // { productId: 102, number: "BT-BF-055", quantity: 50.2, manufacturingDate: "2025-06-15", stockInDate: "2025-07-20", storedUnit: "Freezer B-1", expiryDate: "2026-01-15" }, 
        // { productId: 201, number: "BT-CR-781", quantity: 15.0, manufacturingDate: "2025-08-01", stockInDate: "2025-09-02", storedUnit: "Walk-in C", expiryDate: "2025-12-01" }, 
        // { productId: 301, number: "BT-CN-334", quantity: 100.0, manufacturingDate: "2025-05-10", stockInDate: "2025-06-15", storedUnit: "Deep Freeze 3", expiryDate: "2027-06-10" },
        // { productId: 401, number: "BT-FF-001", quantity: 0, manufacturingDate: "2025-09-01", stockInDate: "2025-09-10", storedUnit: "Deep Freeze 4", expiryDate: "2027-09-01" }
    ];
    
    let selectedOutlet = null;
    
    const sections = ["Section A", "Section B", "Pastry Kitchen", "Main Line"];
    const purposes = ["Cold Preparation", "Cooking", "Serving"];
    const thawingUnits = ["Unit 1", "Unit 2", "Thaw Master A", "Thaw Master B"];
    const placeholderImg = "data:image/gif;base64,R0lGODlhAQABAIAAAP8AAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";


    // let allTableData = [];
    
  let allTableData = @json($thrawings);
    let currentViewData = [];
    let activeFilters = {};
    let currentPage = 1;
    let rowsPerPage = 10;
    let selectedBatchesForThawing = [];
    let liveTimerInterval;
    
    let initiatedBySignaturePad, completedBySignaturePad, verifierSignaturePad;
    const thawingModalEl = document.getElementById('thawingModal');
    const verificationModalEl = document.getElementById('verificationModal');
    const issueModalEl = document.getElementById('issueModal');
    const completeThawingModalEl = document.getElementById('completeThawingModal');
    const filterModalEl = document.getElementById('filterModal');
    let verificationModal, issueModal, imageViewerModal, completeThawingModal, filterModal;
    const tableBody = document.getElementById('thawingTableBody');

    $(document).ready(function() {
        initiatedBySignaturePad = new SignaturePad(document.getElementById('initiatedBySignPad'));
        verifierSignaturePad = new SignaturePad(document.getElementById('verifierSignPad'));
        completedBySignaturePad = new SignaturePad(document.getElementById('completedBySignPad'));

        verificationModal = new bootstrap.Modal(verificationModalEl);
        issueModal = new bootstrap.Modal(issueModalEl);
        imageViewerModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
        completeThawingModal = new bootstrap.Modal(completeThawingModalEl);
        filterModal = new bootstrap.Modal(filterModalEl);

        const thawingUnitSelect = document.getElementById('thawingUnit');
        thawingUnits.forEach(unit => thawingUnitSelect.innerHTML += `<option value="${unit}">${unit}</option>`);

        // const $outletName = $('#outletName').select2({ theme: 'bootstrap-5', dropdownParent: thawingModalEl, placeholder: 'Select...', data: [{ id: '', text: '' }].concat(outlets.map(o => ({ id: o.id, text: `${o.corporate} / ${o.regional} / ${o.unit} / ${o.department} / ${o.location}` }))) });
        
        const $outletName = $('#outletName').select2({
          theme: 'bootstrap-5',
          dropdownParent: thawingModalEl,
          placeholder: 'Select...',
          allowClear: true,
          data: [{ id: '', text: '' }].concat(
            outlets.map(o => ({
              id: o.id.toString(),
              text: `${o.corporate} / ${o.regional} / ${o.unit} / ${o.department} / ${o.location}`,
              corporate: o.corporate,
              regional: o.regional,
              unit: o.unit,
              department: o.department,
              location: o.location
            }))
          )
        });

        const $productName = $('#productName').select2({ theme: 'bootstrap-5', dropdownParent: thawingModalEl, placeholder: 'Select...' });
       

        $outletName.on('select2:select', function (e) {
          const data = e.params.data;
          selectedOutlet = e.params.data;
          const outletDetails = {
            corporate: data.corporate,
            regional: data.regional,
            unit: data.unit,
            department: data.department,
            location: data.location
          };
        
          $.ajax({
            url: "{{ route('record.new.thawing.get.issue.interactive.product') }}",
            method: 'GET',
            data: outletDetails,
            beforeSend: function () {
              $('#productName')
                .prop('disabled', true)
                .html('<option>Loading...</option>');
            },
            success: function (response) {
              products = response;
              const productOptions = products.map(p => ({
                id: p.id,
                text: p.name
              }));
        
              $('#productName')
                .empty()
                .select2({
                  theme: 'bootstrap-5',
                  dropdownParent: thawingModalEl,
                  placeholder: 'Select product...',
                  data: [{ id: '', text: '' }].concat(productOptions)
                })
                .prop('disabled', false);
            },
            error: function (err) {
              alert('Failed to load products.');
            }
          });
        });

    
        $('#productName').on('select2:select', function(e) {
            const productId = e.params.data.id;
            const productName = e.params.data.text; 
        
            $.ajax({
                url: "{{ route('record.new.thawing.get.issue.interactive.product.details') }}",
                method: 'GET',
                data: { 
                    product_id: productId, 
                    product_name: productName 
                },
                beforeSend: function() {
                    $('#productDetails').html('Loading...');
                },
                success: function(response) {
                    batches = response;
                    $('#productDetails').html(`
                        <p><strong>${productName}</strong> has <b>${batches.length}</b> batch(es) available.</p>
                    `);
        
                    resetBatchStep();
                    
                    if ($('#productName').val()) {
                        $('#thawingQuantity').prop('disabled', false);
                        displayBatchStockSummary();
                    }
                },
                error: function(err) {
                    alert('Failed to load product details.');
                }
            });
        });
        
               
        // $outletName.on('change', function() {
        //     const outletId = $(this).val(); 
        //     resetProductStep();
        //     if (outletId) {
        //         const prods = products.filter(p => p.outletId === parseInt(outletId));
        //         $productName.empty().select2({ theme: 'bootstrap-5', dropdownParent: thawingModalEl, placeholder: 'Select...', data: [{ id: '', text: '' }].concat(prods.map(p => ({ id: p.id, text: p.name }))) }).prop('disabled', false);
        //     }
        // });


        // $productName.on('change', function() {
        //     resetBatchStep();
        //     if ($(this).val()) {
        //         $('#thawingQuantity').prop('disabled', false);
        //         displayBatchStockSummary();
        //     }
        // });

        $('#thawingQuantity').on('input', function() {
            displayBatchStockSummary();
        });
        
        $('#thawingMethod').on('change', function() {
            const waterTempContainer = $('#waterTempContainer');
            const waterTempInput = $('#waterTemp');
            if ($(this).val() === 'Chilled Running Water') {
                waterTempContainer.removeClass('d-none');
                waterTempInput.prop('required', true);
            } else {
                waterTempContainer.addClass('d-none');
                waterTempInput.prop('required', false);
            }
        });

        $('#initialTemp').on('input', function(e) {
            if (this.value.length > 0 && this.value[0] !== '-') {
                this.value = '-' + this.value;
            }
        });

        $('#initialTemp').on('input', function() {
            if (!$('#thawStartHidden').val()) {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                const isoTime = now.toISOString().slice(0, 16);
                const readableTime = new Date(isoTime).toLocaleString([], { dateStyle: 'short', timeStyle: 'short' });
                $('#thawStartHidden').val(isoTime);
                $('#thawStartDisplay').html(`<strong>Thaw Started:</strong> ${readableTime}`);
            }
        });
        
        thawingModalEl.addEventListener('show.bs.modal', function (event) {
            prepareAdd();
        });

        verificationModalEl.addEventListener('shown.bs.modal', function() {
            verifierSignaturePad.fromData(verifierSignaturePad.toData()); 
        });
        
        completeThawingModalEl.addEventListener('shown.bs.modal', function() {
            completedBySignaturePad.fromData(completedBySignaturePad.toData());
        });


        generateMockData(116);
        filterAndDisplayTable();
        
        if (liveTimerInterval) clearInterval(liveTimerInterval);
        liveTimerInterval = setInterval(updateLiveTimers, 60000);

        // ##### FILTER EVENT LISTENERS #####
        $('.filter-icon').on('click', function() {
            const filterKey = $(this).data('filter-key');
            const headerText = $(this).parent().text().trim();
            openFilterModal(filterKey, headerText);
        });

        $('#applyFilterBtn').on('click', saveCurrentFilter);
        $('#clearCurrentFilterBtn').on('click', clearCurrentFilter);
    });
    
    
 
    function refreshTable() {
        filterAndDisplayTable();
    }

    function triggerImageCapture(inputId) {
        document.getElementById(inputId).click();
    }

    function handleImageCapture(event, previewId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewElement = document.getElementById(previewId);
                previewElement.src = e.target.result;
                previewElement.dataset.imgData = e.target.result;
                previewElement.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    }

    function generateUUID() { return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c => (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)); }

    // function displayBatchStockSummary() {
    //     const productId = $('#productName').val();
    //     const summaryDiv = $('#batchSelectionSummary');
    //     const issuingDiv = $('#issuingBatchDetails');
    //     const errorDiv = $('#quantityError');
    //     const requestedQty = parseFloat($('#thawingQuantity').val());

    //     issuingDiv.html('<small class="text-muted">Enter a quantity to see which batches will be used.</small>');
    //     errorDiv.text('');
    //     $('#thawingQuantity').removeClass('is-invalid');

    //     if (!productId) {
    //         summaryDiv.html('<small class="text-muted">Select a product to see stock.</small>');
    //         return;
    //     }

    //     const product = products.find(p => p.id === parseInt(productId));
    //     const availableBatches = batches.filter(b => b.productId === parseInt(productId) && b.quantity > 0).sort((a, b) => new Date(a.expiryDate) - new Date(b.expiryDate));

    //     if (availableBatches.length === 0) {
    //         summaryDiv.html('<strong class="text-danger">No stock available for this product.</strong>');
    //         issuingDiv.html('<strong class="text-danger">No stock available.</strong>');
    //         return;
    //     }

    //     let totalStock = 0;
    //     let summaryHtml = '';
    //     availableBatches.forEach(batch => {
    //         totalStock += batch.quantity;
    //         summaryHtml += `
    //             <div class="mb-2 pb-1 border-bottom">
    //                 <div><strong>Batch: ${batch.number}</strong></div>
    //                 <div class="small text-muted">
    //                     <span>Brand: ${product.brand}</span> | <span>Stored: ${batch.storedUnit}</span><br>
    //                     <span>Mfg: ${new Date(batch.manufacturingDate).toLocaleDateString()} | Exp: ${new Date(batch.expiryDate).toLocaleDateString()}</span>
    //                 </div>
    //                 <div class="text-end"><strong>Available: ${batch.quantity.toFixed(2)}kg</strong></div>
    //             </div>`;
    //     });
    //     summaryDiv.html(`<div class="batch-summary-total">Total Available: ${totalStock.toFixed(2)}kg</div>` + summaryHtml);

    //     if (!requestedQty || requestedQty <= 0) {
    //         return;
    //     }

    //     if (requestedQty > totalStock) {
    //         errorDiv.text(`Quantity exceeds available stock of ${totalStock.toFixed(2)}kg.`);
    //         $('#thawingQuantity').addClass('is-invalid');
    //         return;
    //     }

    //     let remainingQtyToSelect = requestedQty;
    //     let detailsHtml = '';
    //     for (const batch of availableBatches) {
    //         if (remainingQtyToSelect <= 0) break;
            
    //         const qtyFromThisBatch = Math.min(remainingQtyToSelect, batch.quantity);
    //         const balanceQty = batch.quantity - qtyFromThisBatch;

    //         detailsHtml += `
    //             <div class="mb-2 pb-1 border-bottom">
    //                 <div class="d-flex justify-content-between">
    //                     <span><strong>Batch: ${batch.number}</strong></span>
    //                     <span class="text-primary"><strong>Issued: ${qtyFromThisBatch.toFixed(2)}kg</strong></span>
    //                 </div>
    //                 <div class="small text-muted">
    //                      <span>Brand: ${product.brand}</span> | <span>Stored: ${batch.storedUnit}</span><br>
    //                      <span>Mfg: ${new Date(batch.manufacturingDate).toLocaleDateString()} | Exp: ${new Date(batch.expiryDate).toLocaleDateString()}</span>
    //                 </div>
    //                 <div class="text-end text-success small">
    //                     <strong>Balance: ${balanceQty.toFixed(2)}kg</strong>
    //                 </div>
    //             </div>`;
    //         remainingQtyToSelect -= qtyFromThisBatch;
    //     }
    //     issuingDiv.html(detailsHtml);
    // }
    
    
    function displayBatchStockSummary() {
        const productId = $('#productName').val();
        const summaryDiv = $('#batchSelectionSummary');
        const issuingDiv = $('#issuingBatchDetails');
        const errorDiv = $('#quantityError');
        const requestedQty = parseFloat($('#thawingQuantity').val());
    
        issuingDiv.html('<small class="text-muted">Enter a quantity to see which batches will be used.</small>');
        errorDiv.text('');
        $('#thawingQuantity').removeClass('is-invalid');
    
        if (!productId) {
            summaryDiv.html('<small class="text-muted">Select a product to see stock.</small>');
            return;
        }
    
        const productName = $('#productName option:selected').text();
        const product = products.find(p => p.name === productName);
    
        const availableBatches = batches
            .filter(b => b.productName === productName && b.quantity > 0)
            .sort((a, b) => new Date(a.expiryDate) - new Date(b.expiryDate));
    
        if (availableBatches.length === 0) {
            summaryDiv.html('<strong class="text-danger">No stock available for this product.</strong>');
            issuingDiv.html('<strong class="text-danger">No stock available.</strong>');
            return;
        }
    
        let totalStock = 0;
        let summaryHtml = '';
        availableBatches.forEach(batch => {
            totalStock += batch.quantity;
            summaryHtml += `
                <div class="mb-2 pb-1 border-bottom">
                    <div><strong>Batch: ${batch.number}</strong></div>
                    <div class="small text-muted">
                        <span>Brand: ${product.brand}</span> | <span>Stored: ${batch.storedUnit}</span><br>
                        <span>Mfg: ${new Date(batch.manufacturingDate).toLocaleDateString()} | Exp: ${new Date(batch.expiryDate).toLocaleDateString()}</span>
                    </div>
                    <div class="text-end"><strong>Available: ${batch.quantity.toFixed(2)}kg</strong></div>
                </div>`;
        });
        summaryDiv.html(`<div class="batch-summary-total">Total Available: ${totalStock.toFixed(2)}kg</div>` + summaryHtml);
    
        if (!requestedQty || requestedQty <= 0) return;
    
        if (requestedQty > totalStock) {
            errorDiv.text(`Quantity exceeds available stock of ${totalStock.toFixed(2)}kg.`);
            $('#thawingQuantity').addClass('is-invalid');
            return;
        }
    
        selectedBatchesForThawing = [];
    
        let remainingQtyToSelect = requestedQty;
        let detailsHtml = '';
    
        for (const batch of availableBatches) {
            if (remainingQtyToSelect <= 0) break;
    
            const qtyFromThisBatch = Math.min(remainingQtyToSelect, batch.quantity);
            const balanceQty = batch.quantity - qtyFromThisBatch;
    
            selectedBatchesForThawing.push({
                id:batch.productId,
                batchNumber: batch.number,
                issuedQty: qtyFromThisBatch,
                beforeQty: batch.quantity,
                balanceQty: balanceQty,
                storedUnit: batch.storedUnit,
                manufacturingDate: batch.manufacturingDate,
                expiryDate: batch.expiryDate
            });
    
            detailsHtml += `
                <div class="mb-2 pb-1 border-bottom">
                    <div class="d-flex justify-content-between">
                        <span><strong>Batch: ${batch.number}</strong></span>
                        <span class="text-primary"><strong>Issued: ${qtyFromThisBatch.toFixed(2)}kg</strong></span>
                    </div>
                    <div class="small text-muted">
                        <span>Brand: ${product.brand}</span> | <span>Stored: ${batch.storedUnit}</span><br>
                        <span>Mfg: ${new Date(batch.manufacturingDate).toLocaleDateString()} | Exp: ${new Date(batch.expiryDate).toLocaleDateString()}</span>
                    </div>
                    <div class="text-end text-success small">
                        <strong>Balance: ${balanceQty.toFixed(2)}kg</strong>
                    </div>
                </div>`;
    
            remainingQtyToSelect -= qtyFromThisBatch;
        }
    
        issuingDiv.html(detailsHtml);
    }


    
    // ----------------- Batches auto-selection -----------------
    function autoSelectBatchesForSave() {
        const productId = $('#productName').val();
        const requestedQty = parseFloat($('#thawingQuantity').val());
        selectedBatchesForThawing = [];
        if (!productId || !requestedQty || requestedQty <= 0) return false;
    
        const availableBatches = batches
            .filter(b => b.productId === parseInt(productId) && b.quantity > 0)
            .sort((a, b) => new Date(a.expiryDate) - new Date(b.expiryDate)); // FEFO
    
        let remainingQtyToThaw = requestedQty;
        let totalAvailable = availableBatches.reduce((sum, b) => sum + b.quantity, 0);
    
        if (requestedQty > totalAvailable) {
            alert(`Error: Requested quantity (${requestedQty.toFixed(2)}kg) exceeds total available stock (${totalAvailable.toFixed(2)}kg).`);
            return false;
        }
    
        for (const batch of availableBatches) {
            if (remainingQtyToThaw <= 0) break;
            const qtyFromThisBatch = Math.min(remainingQtyToThaw, batch.quantity);
            selectedBatchesForThawing.push({ batchNumber: batch.number, quantityToThaw: qtyFromThisBatch });
            remainingQtyToThaw -= qtyFromThisBatch;
        }
    
        return true;
    }
        
    
    
    
    
    // function autoSelectBatchesForSave() {
    //     const productId = $('#productName').val();
    //     const requestedQty = parseFloat($('#thawingQuantity').val());
    //     selectedBatchesForThawing = [];
    //     if (!productId || !requestedQty || requestedQty <= 0) return false;
    //     const availableBatches = batches.filter(b => b.productId === parseInt(productId) && b.quantity > 0).sort((a, b) => new Date(a.expiryDate) - new Date(b.expiryDate));
    //     let remainingQtyToThaw = requestedQty;
    //     let totalAvailable = availableBatches.reduce((sum, b) => sum + b.quantity, 0);
    //     if (requestedQty > totalAvailable) {
    //         alert(`Error: Requested quantity (${requestedQty.toFixed(2)}kg) exceeds total available stock (${totalAvailable.toFixed(2)}kg).`);
    //         return false;
    //     }
    //     for (const batch of availableBatches) {
    //         if (remainingQtyToThaw <= 0) break;
    //         const qtyFromThisBatch = Math.min(remainingQtyToThaw, batch.quantity);
    //         selectedBatchesForThawing.push({ batchNumber: batch.number, quantityToThaw: qtyFromThisBatch });
    //         remainingQtyToThaw -= qtyFromThisBatch;
    //     }
    //     return true;
    // }

    // function saveRecord() {
    //     const form = document.getElementById('thawingForm'); if (!form.checkValidity()) { form.reportValidity(); return; }
    //     if (initiatedBySignaturePad.isEmpty()) { alert("Initiator's signature is required."); return; }
    //     if (!document.getElementById('initialTempImgPreview').dataset.imgData) { alert("Initial temperature image is mandatory."); return; }
    //     if (!$('#thawStartHidden').val()) { alert("Please enter an initial temperature to set the start time."); return; }
        
    //     const method = document.getElementById('thawingMethod').value;
    //     if (method === 'Chilled Running Water' && !document.getElementById('waterTempImgPreview').dataset.imgData) {
    //         alert("Water temperature image is mandatory for the 'Chilled Running Water' method.");
    //         return;
    //     }
    //     alert(method)
    //     if (!autoSelectBatchesForSave()) { return; }

    //     const commonData = {
    //         outlet: outlets.find(o => o.id === parseInt($('#outletName').val())),
    //         product: products.find(p => p.id === parseInt($('#productName').val())),
    //         method: method,
    //         thawStart: document.getElementById('thawStartHidden').value, 
    //         initialTemp: document.getElementById('initialTemp').value, 
    //         initialTempImg: document.getElementById('initialTempImgPreview').dataset.imgData || "", 
    //         thawingUnit: document.getElementById('thawingUnit').value,
    //         initiatedBy: document.getElementById('initiatedBy').value, 
    //         initiatedBySign: initiatedBySignaturePad.toDataURL(),
    //         waterTemp: method === 'Chilled Running Water' ? document.getElementById('waterTemp').value : "",
    //         waterTempImg: method === 'Chilled Running Water' ? document.getElementById('waterTempImgPreview').dataset.imgData : ""
    //     };
    //      alert(commonData)
    //     selectedBatchesForThawing.forEach(selection => {
    //         const batch = batches.find(b => b.number === selection.batchNumber);
    //         const newRecord = {
    //             uuid: generateUUID(),
    //             outletId: commonData.outlet.id, outletCorporate: commonData.outlet.corporate, outletRegional: commonData.outlet.regional, outletUnit: commonData.outlet.unit, outletDepartment: commonData.outlet.department, outletLocation: commonData.outlet.location,
    //             productId: commonData.product.id, productName: commonData.product.name, brandName: commonData.product.brand, 
    //             manufacturingDate: batch.manufacturingDate, expiryDate: batch.expiryDate,
    //             batchNumber: batch.number, 
    //             totalQty: batch.quantity,
    //             thawingQuantity: selection.quantityToThaw,
    //             storedUnit: batch.storedUnit,
    //             method: commonData.method,
    //             thawStart: commonData.thawStart,
    //             initialTemp: commonData.initialTemp,
    //             initialTempImg: commonData.initialTempImg,
    //             thawingUnit: commonData.thawingUnit,
    //             initiatedBy: commonData.initiatedBy,
    //             initiatedBySign: commonData.initiatedBySign,
    //             waterTemp: commonData.waterTemp,
    //             waterTempImg: commonData.waterTempImg,
    //             thawCompleted: "", finalTemp: "", finalTempImg: "", completedBy: "", completedBySign: "", correctiveAction: "", verifierName: "", verificationComments: "", verifierSignature: "", issued: "[]"
    //         };
    //          alert(newRecord)
    //         allTableData.unshift(newRecord);
    //     });

    //     filterAndDisplayTable(); 
    //     bootstrap.Modal.getInstance(thawingModalEl).hide();
    // }
    
    
    // function saveRecord() {
//     const form = document.getElementById('thawingForm');
//     if (!form) {
//         alert("Form element with id 'thawingForm' not found!");
//         return;
//     }

//     if (!form.checkValidity()) {
//         form.reportValidity();
//         return;
//     }

//     // Signature check
//     if (typeof initiatedBySignaturePad === 'undefined' || initiatedBySignaturePad.isEmpty()) {
//         alert("Initiator's signature is required.");
//         return;
//     }

//     const initialTempImgPreview = document.getElementById('initialTempImgPreview');
//     if (!initialTempImgPreview || !initialTempImgPreview.dataset.imgData) {
//         alert("Initial temperature image is mandatory.");
//         return;
//     }

//     const thawStartHidden = document.getElementById('thawStartHidden');
//     if (!thawStartHidden || !thawStartHidden.value) {
//         alert("Please enter an initial temperature to set the start time.");
//         return;
//     }

//     const thawingMethodEl = document.getElementById('thawingMethod');
//     if (!thawingMethodEl) {
//         alert("Thawing method element not found.");
//         return;
//     }
//     const method = thawingMethodEl.value;

//     if (method === 'Chilled Running Water') {
//         const waterTempImgPreview = document.getElementById('waterTempImgPreview');
//         if (!waterTempImgPreview || !waterTempImgPreview.dataset.imgData) {
//             alert("Water temperature image is mandatory for the 'Chilled Running Water' method.");
//             return;
//         }
//     }

//     const outletSelect = document.getElementById('outletName');
//     const outletId = parseInt(outletSelect?.value);
//     const outlet = outlets.find(o => o.id === outletId);
//     if (!outlet) {
//         alert("Selected outlet not found.");
//         return;
//     }

//     const productSelect = document.getElementById('productName');
//     const productId = parseInt(productSelect?.value);
//     const product = products.find(p => p.id === productId);
//     if (!product) {
//         alert("Selected product not found.");
//         return;
//     }

//     // Auto-select batches and validate stock
//     if (!autoSelectBatchesForSave()) return;

//     // Prepare all records
//     let recordsToSave = [];

//     selectedBatchesForThawing.forEach(selection => {
//         const batch = batches.find(b => b.number === selection.batchNumber);
//         if (!batch) {
//             alert(`Batch number ${selection.batchNumber} not found.`);
//             return;
//         }

//         // Calculate balance after issue
//         const issuedQty = selection.quantityToThaw;
//         const balanceQty = batch.quantity - issuedQty;

//         // Prepare issued info for this batch
//         const issuedInfo = {
//             batchNumber: batch.number,
//             issuedQty: issuedQty,
//             balanceQty: balanceQty,
//             storedUnit: batch.storedUnit,
//             manufacturingDate: batch.manufacturingDate,
//             expiryDate: batch.expiryDate
//         };

//         recordsToSave.push({
//             uuid: generateUUID(),
//             outletId: outlet.id,
//             outletCorporate: outlet.corporate,
//             outletRegional: outlet.regional,
//             outletUnit: outlet.unit,
//             outletDepartment: outlet.department,
//             outletLocation: outlet.location,

//             productId: product.id,
//             productName: product.name,
//             brandName: product.brand,

//             manufacturingDate: batch.manufacturingDate,
//             expiryDate: batch.expiryDate,
//             batchNumber: batch.number,
//             totalQty: batch.quantity,
//             thawingQuantity: issuedQty,
//             storedUnit: batch.storedUnit,

//             method: method,
//             thawStart: thawStartHidden.value,
//             initialTemp: document.getElementById('initialTemp')?.value || '',
//             initialTempImg: initialTempImgPreview.dataset.imgData,
//             thawingUnit: document.getElementById('thawingUnit')?.value || '',
//             initiatedBy: document.getElementById('initiatedBy')?.value || '',
//             initiatedBySign: initiatedBySignaturePad.toDataURL(),
//             waterTemp: method === 'Chilled Running Water' ? document.getElementById('waterTemp')?.value || '' : '',
//             waterTempImg: method === 'Chilled Running Water' ? document.getElementById('waterTempImgPreview')?.dataset.imgData : '',

//             thawCompleted: "",
//             finalTemp: "",
//             finalTempImg: "",
//             completedBy: "",
//             completedBySign: "",
//             correctiveAction: "",
//             verifierName: "",
//             verificationComments: "",
//             verifierSignature: "",
//             issued: JSON.stringify([issuedInfo]) // ✅ Store batch issue info
//         });
//     });

//     // 1️⃣ ALERT DATA FOR VERIFICATION
//     console.log("Records to save:", recordsToSave);

//     // 2️⃣ AJAX POST to save the records
//     $.ajax({
//         url: "{{route('record.new.thawing.save-record')}}",
//         type: 'POST',
//         data: {
//             _token: $('meta[name="csrf-token"]').attr('content'),
//             records: recordsToSave
//         },
//         success: function(response) {
//             alert('Records saved successfully!');
//             allTableData.unshift(...recordsToSave);
//             filterAndDisplayTable();

//             const thawingModalEl = document.getElementById('thawingModal');
//             if (thawingModalEl) {
//                 const modalInstance = bootstrap.Modal.getInstance(thawingModalEl);
//                 if (modalInstance) modalInstance.hide();
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(xhr.responseText);
//             alert('Error saving records. Check console for details.');
//         }
//     });
// }


    function saveRecord() {
        const form = document.getElementById('thawingForm');
        if (!form || !form.checkValidity()) {
            form?.reportValidity();
            return;
        }
    
        if (initiatedBySignaturePad.isEmpty()) {
            alert("Initiator's signature is required.");
            return;
        }
    
        const initialTempImgPreview = document.getElementById('initialTempImgPreview');
        if (!initialTempImgPreview.dataset.imgData) {
            alert("Initial temperature image is mandatory.");
            return;
        }
    
        const thawStartHidden = document.getElementById('thawStartHidden');
        if (!thawStartHidden.value) {
            alert("Please enter an initial temperature to set the start time.");
            return;
        }
    
        const method = document.getElementById('thawingMethod').value;
        if (method === 'Chilled Running Water' && !document.getElementById('waterTempImgPreview').dataset.imgData) {
            alert("Water temperature image is mandatory for the 'Chilled Running Water' method.");
            return;
        }
    
        const productId = parseInt($('#productName').val());
        const product = products.find(p => p.id === productId);
    
        if (!selectedOutlet) { alert("Please select an outlet!"); return; }
     
        if (!selectedOutlet || !product) {
            alert("Outlet or product not found!");
            return;
        }
    
        let issuedDetails = selectedBatchesForThawing.map(b => ({
            id:b.id,
            batchNumber: b.batchNumber,
            issuedQty: b.issuedQty,
            beforeQty: b.beforeQty,
            balanceQty: b.balanceQty
        }));
    
        let record = {
            uuid: generateUUID(),
            outletId: selectedOutlet.id,
            outletCorporate: selectedOutlet.corporate,
            outletRegional: selectedOutlet.regional,
            outletUnit: selectedOutlet.unit,
            outletDepartment: selectedOutlet.department,
            outletLocation: selectedOutlet.location,
            productId: product.id,
            productName: product.name,
            brandName: product.brand,
            method: method,
            thawStart: thawStartHidden.value,
            thawingQuantity: $('#thawingQuantity').val(),
            initialTemp: $('#initialTemp').val(),
            initialTempImg: initialTempImgPreview.dataset.imgData,
            thawingUnit: $('#thawingUnit').val(),
            initiatedBy: $('#initiatedBy').val(),
            initiatedBySign: initiatedBySignaturePad.toDataURL(),
            waterTemp: method === 'Chilled Running Water' ? $('#waterTemp').val() : '',
            waterTempImg: method === 'Chilled Running Water' ? $('#waterTempImgPreview').data('imgData') : '',
            issued: JSON.stringify(issuedDetails),
            thawCompleted: "",
            finalTemp: "",
            finalTempImg: "",
            completedBy: "",
            completedBySign: "",
            correctiveAction: "",
            verifierName: "",
            verificationComments: "",
            verifierSignature: ""
        };
    alert(record)
        $.ajax({
            url: "{{ route('record.new.thawing.save-record') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: record,
            success: function (response) {
                alert("Record saved successfully!");
                allTableData.unshift(record);
                filterAndDisplayTable();
    
                const modalEl = document.getElementById('thawingModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance?.hide();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Error saving record. Check console for details.");
            }
        });
    }

    function displayTable() {
        // const paginatedData = currentViewData.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage);
        const paginatedData = @json($thrawings).slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage);
        renderTablePage(paginatedData);
        setupPagination();
    }
    
    // function showBatchDetails(batchNumber) {
    //     const batch = batches.find(b => b.number === batchNumber);
    //     if (batch) {
    //         const details = `Batch Details:\n` +
    //                       `\nNumber: ${batch.number}` +
    //                       `\nProduct ID: ${batch.productId}` +
    //                       `\nOriginal Quantity: ${batch.quantity.toFixed(2)} kg` +
    //                       `\nManufacturing Date: ${new Date(batch.manufacturingDate).toLocaleDateString()}` +
    //                       `\nStock-In Date: ${new Date(batch.stockInDate).toLocaleDateString()}` +
    //                       `\nExpiry Date: ${new Date(batch.expiryDate).toLocaleDateString()}` +
    //                       `\nStored In: ${batch.storedUnit}`;
    //         alert(details);
    //     } else {
    //         alert(`Details for batch ${batchNumber} not found.`);
    //     }
    // }
    
 function showBatchDetails(data) {
    // Ensure data is an object (not undefined or string)
    if (!data || typeof data !== 'object') {
        console.error('Invalid batch data:', data);
        alert('Batch details not available.');
        return;
    }

    // Safely extract and format fields
    const productId = data.productId ?? 'N/A';
    const batchNumber = data.batchNumber ?? 'N/A';
    const quantity = parseFloat(data.quantity ?? 0).toFixed(2);
    const manufacturingDate = data.manufacturingDate
        ? new Date(data.manufacturingDate).toLocaleDateString()
        : 'N/A';
    const stockInDate = data.stockInDate
        ? new Date(data.stockInDate).toLocaleDateString()
        : 'N/A';
    const expiryDate = data.expiryDate
        ? new Date(data.expiryDate).toLocaleDateString()
        : 'N/A';
    const storedUnit = data.storedUnit ?? 'N/A';

    // Build details string
    const details = 
        `📦 Batch Details:\n` +
        `----------------------------\n` +
        `Batch Number: ${batchNumber}\n` +
        `Product ID: ${productId}\n` +
        `Quantity: ${quantity} kg\n` +
        `Manufacturing Date: ${manufacturingDate}\n` +
        `Stock-In Date: ${stockInDate}\n` +
        `Expiry Date: ${expiryDate}\n` +
        `Stored In: ${storedUnit}`;

    // Show details in alert or modal
    alert(details);
}


    function showImageInModal(imgDataUrl) {
        if (imgDataUrl) {
            document.getElementById('fullScreenImage').src = imgDataUrl;
            imageViewerModal.show();
        }
    }

    // function renderTablePage(dataToRender) {
    //     tableBody.innerHTML = '';
    //     if (dataToRender.length === 0) {
    //         tableBody.innerHTML = `<tr><td colspan="15" class="text-center py-4">No records match the current filters.</td></tr>`;
    //         return;
    //     }
       
    //     //  dataToRender.forEach((data, index) => {
    //     //     const row = tableBody.insertRow();
    //     //     row.dataset.uuid = data.uuid;
            
    //     //     const serialNumber = (currentPage - 1) * rowsPerPage + index + 1;
    //     //     const start = new Date(data.thawStart); 
    //     //     const completed = data.thawCompleted ? new Date(data.thawCompleted) : null;
            
    //     //     const initialTempImgHtml = data.initialTempImg ? `<img src="${data.initialTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.initialTempImg}')">` : '';
    //     //     const finalTempImgHtml = data.finalTempImg ? `<img src="${data.finalTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.finalTempImg}')">` : '';

    //     //     const isComplete = data.thawCompleted && data.thawCompleted !== "";
            
    //     //     let verificationCellHtml = '';
    //     //     let issuedToCellHtml = 'N/A';

    //     //     if (isComplete) {
    //     //         const verifyButtonHtml = data.verifierName 
    //     //             ? `<img src="${data.verifierSignature}" class="signature-image" alt="Verifier Signature"/><br><span class="small text-muted">${data.verifierName}</span><br><button class="btn btn-sm btn-outline-secondary mt-1" onclick="openVerificationModal(this)">Edit</button>` 
    //     //             : `<button class="btn btn-sm btn-info" onclick="openVerificationModal(this)">Verify</button>`;
    //     //         verificationCellHtml = `<div class="form-check mb-2"><input type="checkbox" class="form-check-input verification-checkbox mx-auto" onchange="toggleBulkVerifyButton()"></div>${verifyButtonHtml}`;
                
    //     //         const issuedData = JSON.parse(data.issued);
    //     //         const totalThawed = parseFloat(data.thawingQuantity);
    //     //         let totalIssued = 0;
                
    //     //         let issuedItemsHtml = issuedData.map(item => {
    //     //             const qty = parseFloat(item.quantity);
    //     //             totalIssued += qty;
    //     //             return `<div><span class="cell-subheading">${item.section} (${item.purpose || 'N/A'}):</span> ${qty.toFixed(2)} kg</div>`;
    //     //         }).join('');

    //     //         const remainingQty = totalThawed - totalIssued;
                
    //     //         const shelfLifeDate = new Date(data.thawCompleted);
    //     //         shelfLifeDate.setHours(shelfLifeDate.getHours() + 24);
    //     //         const shelfLifeFormatted = shelfLifeDate.toLocaleString([], { day: 'numeric', month: 'numeric', year: 'numeric', hour: '2-digit', minute:'2-digit' });

    //     //         issuedToCellHtml = `
    //     //             ${issuedItemsHtml}
    //     //             <div><span class="cell-subheading">Rem:</span> ${remainingQty.toFixed(2)} kg</div>
    //     //             <div><span class="cell-subheading">Shelf Life:</span><br>${shelfLifeFormatted}</div>
    //     //             <button class="btn btn-sm btn-outline-primary mt-1" onclick="openIssueModal(this)"><i class="bi bi-pencil"></i> Issue</button>
    //     //         `;
    //     //     }

    //     //     let quantityDetailsHtml = `
    //     //         <span class="cell-subheading">Batch Qty:</span> ${parseFloat(data.totalQty).toFixed(2)}kg<br>
    //     //         <span class="cell-subheading">Thawed:</span> ${parseFloat(data.thawingQuantity).toFixed(2)}kg<br>
    //     //         <span class="cell-subheading">Method:</span> ${data.method}`;

    //     //     if (data.method === 'Chilled Running Water' && data.waterTemp) {
    //     //         const waterTempImgHtml = data.waterTempImg ? `<img src="${data.waterTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.waterTempImg}')">` : '';
    //     //         quantityDetailsHtml += `<div class="d-flex align-items-center mt-1">
    //     //                                     <span class="me-2"><span class="cell-subheading">Water:</span> ${data.waterTemp}°C</span>
    //     //                                     ${waterTempImgHtml}
    //     //                                 </div>`;
    //     //     }

    //     //     row.innerHTML = `
    //     //         <td data-label="S.No.">${serialNumber}</td>
    //     //         <td data-label="Outlet Details" class="fixed-column">
    //     //             <span class="cell-subheading">Corp:</span> ${data.outletCorporate}<br>
    //     //             <span class="cell-subheading">Regional:</span> ${data.outletRegional}<br>
    //     //             <span class="cell-subheading">Unit:</span> ${data.outletUnit}<br>
    //     //             <span class="cell-subheading">Dept:</span> ${data.outletDepartment}<br>
    //     //             <span class="cell-subheading">Loc:</span> ${data.outletLocation}
    //     //         </td>
    //     //         <td data-label="Product Details">
    //     //             <span class="cell-subheading">Product:</span> ${data.productName}<br>
    //     //             <span class="cell-subheading">Batch:</span> <a href="#" onclick="showBatchDetails('${data.batchNumber}'); return false;">${data.batchNumber}</a><br>
    //     //             <span class="cell-subheading">Exp:</span> ${new Date(data.expiryDate).toLocaleDateString()}
    //     //         </td>
    //     //         <td data-label="Unit Details">
    //     //             <span class="cell-subheading">Storage:</span> <a href="#" onclick="alert('Viewing details for storage unit: ${data.storedUnit}')">${data.storedUnit}</a><br>
    //     //             <span class="cell-subheading">Thawing:</span> <a href="#" onclick="alert('Viewing details for unit: ${data.thawingUnit}')">${data.thawingUnit}</a>
    //     //         </td>
    //     //         <td data-label="Quantity / Method">${quantityDetailsHtml}</td>
    //     //         <td data-label="Thawing Started" class="text-nowrap">${start.toLocaleDateString()}<br>${start.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</td>
    //     //         <td data-label="Initial Temp." class="text-center">
    //     //             <span class="d-block">${data.initialTemp}°C</span>
    //     //             <span class="d-block standard-text">(Std: ≤ -18°C)</span>
    //     //             ${initialTempImgHtml}
    //     //         </td>
    //     //         <td data-label="Initiated by">${data.initiatedBy}<br>${data.initiatedBySign ? `<img src="${data.initiatedBySign}" class="signature-image" alt="Initiator Signature">` : ''}</td>
    //     //         <td data-label="Thawing Completed" class="text-nowrap">${completed ? `${completed.toLocaleDateString()}<br>${completed.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}` : `<button class="btn btn-sm btn-success" onclick="openCompleteModal(this)">Complete</button>`}</td>
    //     //         <td data-label="Final Temp." class="text-center">
    //     //             ${data.finalTemp ? `<span class="d-block">${data.finalTemp}°C</span><span class="d-block standard-text">(Std: < 5°C)</span>${finalTempImgHtml}` : 'N/A'}
    //     //         </td>
    //     //         <td data-label="Time Lapse" class="time-lapse-cell" data-thaw-start="${data.thawStart}" data-thaw-completed="${data.thawCompleted || ''}">
    //     //             ${formatTimeLapse(data.thawStart, data.thawCompleted)}
    //     //         </td>
    //     //         <td data-label="Completed by">${data.completedBy ? `${data.completedBy}<br>${data.completedBySign ? `<img src="${data.completedBySign}" class="signature-image" alt="Completer Signature">` : ''}` : 'N/A'}</td>
    //     //         <td data-label="Issued To / Shelf Life" class="issued-to-cell">${issuedToCellHtml}</td>
    //     //         <td data-label="Corrective Action">${data.correctiveAction || 'N/A'}</td>
    //     //         <td data-label="Verification" class="text-center align-middle">${verificationCellHtml}</td>
    //     //     `;
    //     // });
        
        
    //       dataToRender.forEach((data, index) => {
    //         const row = tableBody.insertRow();
    //         row.dataset.uuid = data.uuid;
            
    //         const serialNumber = (currentPage - 1) * rowsPerPage + index + 1;
    //         const start = new Date(data.thawStart); 
    //         // const completed = data.thawCompleted ? new Date(data.thawCompleted) : null;
    //         const completed = data.thawCompleted ? data.thawCompleted : null;
    //         console.log("completed checkkro1111111111",completed);
    //         const initialTempImgHtml = data.initialTempImg ? `<img src="${data.initialTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.initialTempImg}')">` : '';
    //         const finalTempImgHtml = data.finalTempImg ? `<img src="${data.finalTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.finalTempImg}')">` : '';

    //         const isComplete = data.thawCompleted && data.thawCompleted !== "";
            
    //         let verificationCellHtml = '';
    //         let issuedToCellHtml = 'N/A';

    //         if (isComplete) {
    //             const verifyButtonHtml = data.verifierName 
    //                 ? `<img src="${data.verifierSignature}" class="signature-image" alt="Verifier Signature"/><br><span class="small text-muted">${data.verifierName}</span><br><button class="btn btn-sm btn-outline-secondary mt-1" onclick="openVerificationModal(this)">Edit</button>` 
    //                 : `<button class="btn btn-sm btn-info" onclick="openVerificationModal(this)">Verify</button>`;
    //             verificationCellHtml = `<div class="form-check mb-2"><input type="checkbox" class="form-check-input verification-checkbox mx-auto" onchange="toggleBulkVerifyButton()"></div>${verifyButtonHtml}`;
                
    //             const issuedData = JSON.parse(data.issued);
    //             const totalThawed = parseFloat(data.thawingQuantity);
    //             let totalIssued = 0;
                
    //             let issuedItemsHtml = issuedData.map(item => {
    //                 const qty = parseFloat(item.quantity);
    //                 totalIssued += qty;
    //                 return `<div><span class="cell-subheading">${item.section} (${item.purpose || 'N/A'}):</span> ${qty.toFixed(2)} kg</div>`;
    //             }).join('');

    //             const remainingQty = totalThawed - totalIssued;
                
    //             // const shelfLifeDate = new Date(data.thawCompleted);
    //              const shelfLifeDate = data.thawCompleted;
    //             shelfLifeDate.setHours(shelfLifeDate.getHours() + 24);
    //             const shelfLifeFormatted = shelfLifeDate.toLocaleString([], { day: 'numeric', month: 'numeric', year: 'numeric', hour: '2-digit', minute:'2-digit' });

    //             issuedToCellHtml = `
    //                 ${issuedItemsHtml}
    //                 <div><span class="cell-subheading">Rem:</span> ${remainingQty.toFixed(2)} kg</div>
    //                 <div><span class="cell-subheading">Shelf Life:</span><br>${shelfLifeFormatted}</div>
    //                 <button class="btn btn-sm btn-outline-primary mt-1" onclick="openIssueModal(this)"><i class="bi bi-pencil"></i> Issue</button>
    //             `;
    //         }

    //         let quantityDetailsHtml = `
    //             <span class="cell-subheading">Batch Qty:</span> ${parseFloat(data.totalQty).toFixed(2)}kg<br>
    //             <span class="cell-subheading">Thawed:</span> ${parseFloat(data.thawingQuantity).toFixed(2)}kg<br>
    //             <span class="cell-subheading">Method:</span> ${data.method}`;

    //         if (data.method === 'Chilled Running Water' && data.waterTemp) {
    //             const waterTempImgHtml = data.waterTempImg ? `<img src="${data.waterTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.waterTempImg}')">` : '';
    //             quantityDetailsHtml += `<div class="d-flex align-items-center mt-1">
    //                                         <span class="me-2"><span class="cell-subheading">Water:</span> ${data.waterTemp}°C</span>
    //                                         ${waterTempImgHtml}
    //                                     </div>`;
    //         }

    //         row.innerHTML = `
    //             <td data-label="S.No.">${serialNumber}</td>
    //             <td data-label="Outlet Details" class="fixed-column">
    //                 <span class="cell-subheading">Corp:</span> ${data.outletCorporate}<br>
    //                 <span class="cell-subheading">Regional:</span> ${data.outletRegional}<br>
    //                 <span class="cell-subheading">Unit:</span> ${data.outletUnit}<br>
    //                 <span class="cell-subheading">Dept:</span> ${data.outletDepartment}<br>
    //                 <span class="cell-subheading">Loc:</span> ${data.outletLocation}
    //             </td>
    //             <td data-label="Product Details">
    //                 <span class="cell-subheading">Product:</span> ${data.productName}<br>
    //                 <span class="cell-subheading">Batch:</span> <a href="#" onclick='showBatchDetails(${JSON.stringify(data)}); return false;'>${data.batchNumber}</a><br>
    //                 <span class="cell-subheading">Exp:</span> ${new Date(data.expiryDate).toLocaleDateString()}
    //             </td>
    //             <td data-label="Unit Details">
    //                 <span class="cell-subheading">Storage:</span> <a href="#" onclick="alert('Viewing details for storage unit: ${data.storedUnit}')">${data.storedUnit}</a><br>
    //                 <span class="cell-subheading">Thawing:</span> <a href="#" onclick="alert('Viewing details for unit: ${data.thawingUnit}')">${data.thawingUnit}</a>
    //             </td>
    //             <td data-label="Quantity / Method">${quantityDetailsHtml}</td>
    //             <td data-label="Thawing Started" class="text-nowrap">${start.toLocaleDateString()}<br>${start.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</td>
    //             <td data-label="Initial Temp." class="text-center">
    //                 <span class="d-block">${data.initialTemp}°C</span>
    //                 <span class="d-block standard-text">(Std: ≤ -18°C)</span>
    //                 ${initialTempImgHtml}
    //             </td>
    //             <td data-label="Initiated by">${data.initiatedBy}<br>${data.initiatedBySign ? `<img src="${data.initiatedBySign}" class="signature-image" alt="Initiator Signature">` : ''}</td>
    //             <td data-label="Thawing Completed" class="text-nowrap">${completed ? `${completed.toLocaleDateString()}<br>${completed.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}` : `<button class="btn btn-sm btn-success" onclick="openCompleteModal(this,${data.id})">Complete</button>`}</td>
    //             <td data-label="Final Temp." class="text-center">
    //                 ${data.finalTemp ? `<span class="d-block">${data.finalTemp}°C</span><span class="d-block standard-text">(Std: < 5°C)</span>${finalTempImgHtml}` : 'N/A'}
    //             </td>
    //             <td data-label="Time Lapse" class="time-lapse-cell" data-thaw-start="${data.thawStart}" data-thaw-completed="${data.thawCompleted || ''}">
    //                 ${formatTimeLapse(data.thawStart, data.thawCompleted)}
    //             </td>
    //             <td data-label="Completed by">${data.completedBy ? `${data.completedBy}<br>${data.completedBySign ? `<img src="${data.completedBySign}" class="signature-image" alt="Completer Signature">` : ''}` : 'N/A'}</td>
    //             <td data-label="Issued To / Shelf Life" class="issued-to-cell">${issuedToCellHtml}</td>
    //             <td data-label="Corrective Action">${data.correctiveAction || 'N/A'}</td>
    //             <td data-label="Verification" class="text-center align-middle">${verificationCellHtml}</td>
    //         `;
    //     });
    // }

function renderTablePage(dataToRender) {
        tableBody.innerHTML = '';
        if (dataToRender.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="15" class="text-center py-4">No records match the current filters.</td></tr>`;
            return;
        }
       
        dataToRender.forEach((data, index) => {
            const row = tableBody.insertRow();
            row.dataset.uuid = data.uuid;
            
            const serialNumber = (currentPage - 1) * rowsPerPage + index + 1;
            const start = new Date(data.thawStart); 
            
            // FIX 1: Ensure we create a Date object from the thawCompleted string
            const completedDate = data.thawCompleted ? new Date(data.thawCompleted) : null;
            
            const initialTempImgHtml = data.initialTempImg ? `<img src="${data.initialTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.initialTempImg}')">` : '';
            const finalTempImgHtml = data.finalTempImg ? `<img src="${data.finalTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.finalTempImg}')">` : '';

            // Use the original string for comparison and data attribute
            const isComplete = data.thawCompleted && data.thawCompleted !== ""; 
            
            let verificationCellHtml = '';
            let issuedToCellHtml = 'N/A';

                    // <button class="btn btn-sm btn-outline-secondary mt-1" onclick="openVerificationModal(this,${data.id})">Edit</button>` 
            if (isComplete) {
                const verifyButtonHtml = data.verifierName 
                    ? `<img src="${data.verifierSignature}" class="signature-image" alt="Verifier Signature"/><br><span class="small text-muted">${data.verifierName}</span><br>`
                    : `<button class="btn btn-sm btn-info" onclick="openVerificationModal(this,${data.id})">Verify</button>`;
                // verificationCellHtml = `<div class="form-check mb-2"><input type="checkbox" class="form-check-input verification-checkbox mx-auto" onchange="toggleBulkVerifyButton()"></div>${verifyButtonHtml}`;
                  verificationCellHtml = `<div class="form-check mb-2"></div>${verifyButtonHtml}`;
                
                
                // Ensure data.issued is an array string before parsing
                const issuedData = JSON.parse(data.issued || '[]'); 
                const totalThawed = parseFloat(data.thawingQuantity) || 0;
                let totalIssued = 0;
                
                let issuedItemsHtml = issuedData.map(item => {
                    const qty = parseFloat(item.quantity) || 0;
                    totalIssued += qty;
                    return `<div><span class="cell-subheading">${item.section} (${item.purpose || 'N/A'}):</span> ${qty.toFixed(2)} kg</div>`;
                }).join('');

                const remainingQty = totalThawed - totalIssued;
                
                // FIX 2: Correctly calculate Shelf Life using the Date object
                const shelfLifeDate = new Date(data.thawCompleted);
                shelfLifeDate.setHours(shelfLifeDate.getHours() + 24); // Add 24 hours
                const shelfLifeFormatted = shelfLifeDate.toLocaleString([], { day: 'numeric', month: 'numeric', year: 'numeric', hour: '2-digit', minute:'2-digit' });

                issuedToCellHtml = `
                    ${issuedItemsHtml}
                    <div><span class="cell-subheading">Rem:</span> ${remainingQty.toFixed(2)} kg</div>
                    <div><span class="cell-subheading">Shelf Life:</span><br>${shelfLifeFormatted}</div>
                    <button class="btn btn-sm btn-outline-primary mt-1" onclick="openIssueModal(this)"><i class="bi bi-pencil"></i> Issue</button>
                `;
            }

            let quantityDetailsHtml = `
                <span class="cell-subheading">Batch Qty:</span> ${(parseFloat(data.totalQty) || 0).toFixed(2)}kg<br>
                <span class="cell-subheading">Thawed:</span> ${(parseFloat(data.thawingQuantity) || 0).toFixed(2)}kg<br>
                <span class="cell-subheading">Method:</span> ${data.method}`;

            if (data.method === 'Chilled Running Water' && data.waterTemp) {
                const waterTempImgHtml = data.waterTempImg ? `<img src="${data.waterTempImg}" class="temp-thumbnail" onclick="showImageInModal('${data.waterTempImg}')">` : '';
                quantityDetailsHtml += `<div class="d-flex align-items-center mt-1">
                                            <span class="me-2"><span class="cell-subheading">Water:</span> ${data.waterTemp}°C</span>
                                            ${waterTempImgHtml}
                                        </div>`;
            }

            // FIX 3: Use completedDate for display
            row.innerHTML = `
                <td data-label="S.No.">${serialNumber}</td>
                <td data-label="Outlet Details" class="fixed-column">
                    <span class="cell-subheading">Corp:</span> ${data.outletCorporate}<br>
                    <span class="cell-subheading">Regional:</span> ${data.outletRegional}<br>
                    <span class="cell-subheading">Unit:</span> ${data.outletUnit}<br>
                    <span class="cell-subheading">Dept:</span> ${data.outletDepartment}<br>
                    <span class="cell-subheading">Loc:</span> ${data.outletLocation}
                </td>
                <td data-label="Product Details">
                    <span class="cell-subheading">Product:</span> ${data.productName}<br>
                    <span class="cell-subheading">Batch:</span> <a href="#" onclick='showBatchDetails(${JSON.stringify(data)}); return false;'>${data.batchNumber}</a><br>
                    <span class="cell-subheading">Exp:</span> ${new Date(data.expiryDate).toLocaleDateString()}
                </td>
                <td data-label="Unit Details">
                    <span class="cell-subheading">Storage:</span> <a href="#" onclick="alert('Viewing details for storage unit: ${data.storedUnit}')">${data.storedUnit}</a><br>
                    <span class="cell-subheading">Thawing:</span> <a href="#" onclick="alert('Viewing details for unit: ${data.thawingUnit}')">${data.thawingUnit}</a>
                </td>
                <td data-label="Quantity / Method">${quantityDetailsHtml}</td>
                <td data-label="Thawing Started" class="text-nowrap">${start.toLocaleDateString()}<br>${start.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</td>
                <td data-label="Initial Temp." class="text-center">
                    <span class="d-block">${data.initialTemp}°C</span>
                    <span class="d-block standard-text">(Std: ≤ -18°C)</span>
                    ${initialTempImgHtml}
                </td>
                <td data-label="Initiated by">${data.initiatedBy}<br>${data.initiatedBySign ? `<img src="${data.initiatedBySign}" class="signature-image" alt="Initiator Signature">` : ''}</td>
                <td data-label="Thawing Completed" class="text-nowrap">${completedDate ? `${completedDate.toLocaleDateString()}<br>${completedDate.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}` : `<button class="btn btn-sm btn-success" onclick="openCompleteModal(this,${data.id})">Complete</button>`}</td>
                <td data-label="Final Temp." class="text-center">
                    ${data.finalTemp ? `<span class="d-block">${data.finalTemp}°C</span><span class="d-block standard-text">(Std: < 5°C)</span>${finalTempImgHtml}` : 'N/A'}
                </td>
                <td data-label="Time Lapse" class="time-lapse-cell" data-thaw-start="${data.thawStart}" data-thaw-completed="${data.thawCompleted || ''}">
                    ${formatTimeLapse(data.thawStart, data.thawCompleted)}
                </td>
                <td data-label="Completed by">${data.completedBy ? `${data.completedBy}<br>${data.completedBySign ? `<img src="${data.completedBySign}" class="signature-image" alt="Completer Signature">` : ''}` : 'N/A'}</td>
                <td data-label="Issued To / Shelf Life" class="issued-to-cell">${issuedToCellHtml}</td>
                <td data-label="Corrective Action">${data.correctiveAction || 'N/A'}</td>
                <td data-label="Verification" class="text-center align-middle">${verificationCellHtml}</td>
            `;
        });
    }
    
    function formatTimeLapse(startTime, endTime) {
        if (!startTime) return 'N/A';
        const start = new Date(startTime);
        const end = endTime ? new Date(endTime) : new Date();
        let diff = end.getTime() - start.getTime();
        if (diff < 0) return 'N/A';
        let totalMinutes = Math.floor(diff / 60000);
        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;
        return `${hours}h ${minutes}m`;
    }

    function updateLiveTimers() {
        document.querySelectorAll('.time-lapse-cell').forEach(cell => {
            const completedTime = cell.dataset.thawCompleted;
            if (!completedTime) {
                const startTime = cell.dataset.thawStart;
                cell.textContent = formatTimeLapse(startTime, null);
            }
        });
    }

    function prepareAdd() {
        document.getElementById('thawingForm').reset();
        document.getElementById('editRecordUUID').value = '';
        $('#thawingModalLabel').text('Start Thawing Record');
        $('#outletName').val(null).trigger('change');
        resetProductStep();
        $('.temp-img-preview').addClass('d-none').attr('src', '').removeAttr('data-img-data');
        $('#thawStartDisplay').html('');
        $('#thawStartHidden').val('');
        $('#initiatedBy').val(currentUser.name);
        if(initiatedBySignaturePad) initiatedBySignaturePad.clear();
        
        $('#waterTempContainer').addClass('d-none');
        $('#waterTemp').prop('required', false);
    }
    
    function resetProductStep() { 
        $('#productName').val(null).trigger('change').prop('disabled', true); 
        resetBatchStep(); 
    }

    function resetBatchStep() { 
        $('#thawingQuantity').val('').prop('disabled', true).removeClass('is-invalid');
        $('#batchSelectionSummary').html('<small class="text-muted">Select a product to see stock.</small>');
        $('#issuingBatchDetails').html('<small class="text-muted">Enter a quantity to see which batches will be used.</small>');
        $('#quantityError').text('');
        selectedBatchesForThawing = [];
    }
    
    // ##### COMPLETION MODAL FUNCTIONS #####
    function openCompleteModal(button,id) {
        const uuid = button.closest('tr').dataset.uuid;
        const record = allTableData.find(r => r.uuid === uuid);
        if (!record) return;
        
        $('#completeThawingForm').trigger('reset');
        completedBySignaturePad.clear();
        $('#finalTempImgPreview').addClass('d-none').attr('src', '').removeAttr('data-img-data');

        $('#completionInfoBanner').html(`<strong>Product:</strong> ${record.productName}, <strong>Batch:</strong> ${record.batchNumber}, <strong>Thawing Qty:</strong> ${record.thawingQuantity}kg`);
        let standardHtml = `<strong>Standard:</strong> Product temp < 5°C, Max duration: 90 mins.`;
        if (record.method === 'Chilled Running Water') {
            standardHtml = `<strong>Standard:</strong> Water temp < 15°C, Product temp < 5°C, Max duration: 90 mins.`;
        }
        $('#completionStandardBanner').html(standardHtml);

        $('#completeRecordId').val(id);
        $('#completeRecordUUID').val(uuid);
        $('#completedByName').val(currentUser.name);
        
        completeThawingModal.show();
    }

    // function saveCompletion() {
    //     const form = document.getElementById('completeThawingForm');
    //     if (!form.checkValidity()) { form.reportValidity(); return; }
    //     if (completedBySignaturePad.isEmpty()) { alert("Completer's signature is required."); return; }
    //     if (!document.getElementById('finalTempImgPreview').dataset.imgData) { alert("Final temperature image is mandatory."); return; }

    //     const uuid = $('#completeRecordUUID').val();
    //     const id = $('#completeRecordId').val();
    //     alert(id);
    //     alert(uuid);
    //     const record = allTableData.find(r => r.uuid === uuid);
    //     if (record) {
    //         const now = new Date();
    //         now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            
    //         record.thawCompleted = now.toISOString().slice(0, 16);
    //         record.finalTemp = $('#finalTemp').val();
    //         record.finalTempImg = $('#finalTempImgPreview').data('imgData') || '';
    //         record.correctiveAction = $('#correctiveAction').val();
    //         record.completedBy = $('#completedByName').val();
    //         record.completedBySign = completedBySignaturePad.toDataURL();
    //     }

    //     completeThawingModal.hide();
    //     filterAndDisplayTable();
    // }
    
    function saveCompletion() {
    const form = document.getElementById('completeThawingForm');
    if (!form.checkValidity()) { form.reportValidity(); return; }
    if (completedBySignaturePad.isEmpty()) { alert("Completer's signature is required."); return; }
    if (!document.getElementById('finalTempImgPreview').dataset.imgData) { alert("Final temperature image is mandatory."); return; }

    const uuid = $('#completeRecordUUID').val();
    const id   = $('#completeRecordId').val();  // make sure this hidden/input exists
    const finalTemp         = $('#finalTemp').val();
    const finalTempImgData  = $('#finalTempImgPreview').data('imgData');
    const correctiveAction  = $('#correctiveAction').val();
    const completedBy       = $('#completedByName').val();
    const completedBySign   = completedBySignaturePad.toDataURL();

    // ---  Show data to be saved (alert for debug)  ---
    alert(
      "Will save data:\n" +
      "UUID: " + uuid + "\n" +
      "ID: " + id + "\n" +
      "Final Temp: " + finalTemp + "\n" +
      "Final Temp Img Data length: " + (finalTempImgData ? finalTempImgData : 'none') + "\n" +
      "Corrective Action: " + correctiveAction + "\n" +
      "Completed By: " + completedBy + "\n" +
      "Signature Data URL length: " +completedBySign
    );

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // --- AJAX request to send data to server ---
    $.ajax({
      url: "{{route('record.new.thawing.save.complete.of.record')}}",
      method: 'POST',
      dataType: 'json',
      data: {
        uuid: uuid,
        id: id,
        final_temp: finalTemp,
        final_temp_img: finalTempImgData,
        corrective_action: correctiveAction,
        completed_by: completedBy,
        completed_by_sign: completedBySign,
        thawCompleted: new Date().toISOString().slice(0,16)
      },
      success: function(response) {
        toastr.success('Save successful! Response: ' + JSON.stringify(response));
        // optionally update front-end data
        const record = allTableData.find(r => r.uuid === uuid);
        if (record) {
        //   record.thawCompleted = new Date().toISOString().slice(0,16);
          record.finalTemp      = finalTemp;
          record.finalTempImg   = finalTempImgData;
          record.correctiveAction = correctiveAction;
          record.completedBy     = completedBy;
          record.completedBySign = completedBySign;
        }
        completeThawingModal.hide();
        filterAndDisplayTable();
          setTimeout(function() {
            location.reload();
          }, 2000);
      },
      error: function(xhr, status, error) {
        alert('Save failed! ' + error);
      }
    });
}

    
    function openVerificationModal(button,id) {
        const uuid = button.closest('tr').dataset.uuid;
        const record = allTableData.find(r => r.uuid === uuid);
        if (!record) return;
        $('#verificationForm').trigger('reset');
        verifierSignaturePad.clear();

        $('#verificationRecordUUID').val(uuid);
         $('#verificationRecordID').val(id);
        
        $('#verificationComments').val(record.verificationComments);
        $('#verifierName').val(record.verifierName || currentUser.name);

        if(record.verifierSignature) {
            verifierSignaturePad.fromDataURL(record.verifierSignature);
        }
        
        verificationModal.show();
    }

    function saveVerification() {
          const form = document.getElementById('verificationForm');
          if (!form.checkValidity()) { form.reportValidity(); return; }
          if (verifierSignaturePad.isEmpty()) { alert("Verifier's signature is required."); return; }
        
          const uuid = $('#verificationRecordUUID').val();
          const id = $('#verificationRecordID').val();
          const verificationComments = $('#verificationComments').val();
          const verifierName = $('#verifierName').val();
          const verifierSignature = verifierSignaturePad.toDataURL();
        
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        
          $.ajax({
            url: "{{route('record.new.thawing.save.verify.of.record')}}", 
            method: 'POST',
            dataType: 'json',
            data: {
              uuid: uuid,
              id: id,
              verification_comments: verificationComments,
              verifier_name: verifierName,
              verifier_signature: verifierSignature
            },
            success: function(response) {
              toastr.success('Save successful!');
              const record = allTableData.find(r => r.uuid === uuid);
              if (record) {
                record.verificationComments = verificationComments;
                record.verifierName = verifierName;
                record.verifierSignature = verifierSignature;
              }
              verificationModal.hide();
              filterAndDisplayTable();
                setTimeout(function() {
                    location.reload();
                  }, 2000);
            },
            error: function(xhr, status, error) {
              console.error('Save failed:', xhr.responseText || status);
              alert('Save failed! ' + error);
            }
          });
    }


    // ##### ISSUE MODAL FUNCTIONS #####
    // function openIssueModal(button) {
    //     const uuid = button.closest('tr').dataset.uuid;
    //     const record = allTableData.find(r => r.uuid === uuid);
    //     if (!record) return;

    //     $('#issueRecordUUID').val(uuid);

    //     const shelfLifeDate = new Date(record.thawCompleted);
    //     shelfLifeDate.setHours(shelfLifeDate.getHours() + 24);
    //     $('#issueInfoBanner').data('shelf-life', shelfLifeDate.toISOString().slice(0, 16));
    //     $('#issueInfoBanner').data('total-thawed', record.thawingQuantity);
        
    //     const sectionSelect = $('#newIssueSection');
    //     sectionSelect.html('<option value="">Choose Section...</option>');
    //     const issuedSections = JSON.parse(record.issued).map(item => item.section);
    //     sections.forEach(s => {
    //         if (!issuedSections.includes(s)) {
    //             sectionSelect.append(`<option value="${s}">${s}</option>`);
    //         }
    //     });
        
    //     const purposeSelect = $('#newIssuePurpose');
    //     purposeSelect.html('<option value="">Choose Purpose...</option>');
    //     purposes.forEach(p => {
    //          purposeSelect.append(`<option value="${p}">${p}</option>`);
    //     });

    //     renderIssuedItemsInModal(JSON.parse(record.issued));
    //     updateRemainingBanner();
    //     issueModal.show();
    // }
    
    function openIssueModal(button) {
        const uuid = button.closest('tr').dataset.uuid;
        const record = allTableData.find(r => r.uuid === uuid);
        if (!record) return;
    
        $('#issueRecordUUID').val(uuid);
    
        const shelfLifeDate = new Date(record.thawCompleted);
        shelfLifeDate.setHours(shelfLifeDate.getHours() + 24);
        $('#issueInfoBanner').data('shelf-life', shelfLifeDate.toISOString().slice(0, 16));
        $('#issueInfoBanner').data('total-thawed', record.thawingQuantity);
    
    
        let issuedItems = [];
        try {
            issuedItems = JSON.parse(record.issued || '[]');
        } catch (e) {
            console.error("Error parsing issued items JSON:", e);
            issuedItems = [];
        }
    
        const sectionSelect = $('#newIssueSection');
        sectionSelect.html('<option value="">Choose Section...</option>');
        const issuedSections = issuedItems.map(item => item.section);
        sections.forEach(s => {
            if (!issuedSections.includes(s)) {
                sectionSelect.append(`<option value="${s}">${s}</option>`);
            }
        });
        
        const purposeSelect = $('#newIssuePurpose');
        purposeSelect.html('<option value="">Choose Purpose...</option>');
        purposes.forEach(p => {
             purposeSelect.append(`<option value="${p}">${p}</option>`);
        });
    
        renderIssuedItemsInModal(issuedItems); // अपडेटेड फ़ंक्शन कॉल
        updateRemainingBanner();
        issueModal.show();
    }
        
    // function addIssuedItem() {
    //     const section = $('#newIssueSection').val();
    //     const purpose = $('#newIssuePurpose').val();
    //     const quantity = parseFloat($('#newIssueQuantity').val());
    //     if (!section || !purpose || !quantity || quantity <= 0) {
    //         alert("Please select a section, purpose, and enter a valid quantity.");
    //         return;
    //     }

    //     const { remaining } = calculateIssuedTotal();
    //     if (quantity > remaining) {
    //         alert(`Quantity cannot exceed remaining ${remaining.toFixed(2)} kg.`);
    //         return;
    //     }

    //     renderIssuedItemsInModal([{ section, purpose, quantity, shelfLife: '' }]);
        
    //     $('#newIssueSection option[value="' + section + '"]').remove();
    //     $('#newIssueSection').val('');
    //     $('#newIssuePurpose').val('');
    //     $('#newIssueQuantity').val('');
    //     updateRemainingBanner();
    // }

    let currentIssuedItems = []; 
    
    function addIssuedItem() {
        const section = $('#newIssueSection').val();
        const purpose = $('#newIssuePurpose').val();
        const quantity = parseFloat($('#newIssueQuantity').val());
    
        if (!section || !purpose || !quantity || quantity <= 0) {
            alert("Please select a section, purpose, and enter a valid quantity.");
            return;
        }
        const { remaining } = calculateIssuedTotal();
        if (quantity > remaining) {
            alert(`Quantity cannot exceed remaining ${remaining.toFixed(2)} kg.`);
            return;
        }
        const newItem = { section, purpose, quantity, shelfLife: '' };
    
        currentIssuedItems.push(newItem); 
        renderIssuedItemsInModal(currentIssuedItems); 
        $('#newIssueSection option[value="' + section + '"]').remove();
        $('#newIssueSection').val('');
        $('#newIssuePurpose').val('');
        $('#newIssueQuantity').val('');
        updateRemainingBanner();
    }


    // function renderIssuedItemsInModal(items) {
    //     const container = $('#issuedItemsContainer');
    //     if (items.length === 0) {
    //         container.html('<p class="text-muted text-center">No items issued yet.</p>');
    //         return;
    //     }
    //     if (container.find('p').length > 0) container.html('');

    //     const shelfLifeDateTime = $('#issueInfoBanner').data('shelf-life');
    //     const shelfLifeFormatted = shelfLifeDateTime ? new Date(shelfLifeDateTime).toLocaleString([], { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' }) : '';
        
    //     items.forEach(item => {
    //         const itemHtml = `
    //             <div class="row g-3 align-items-center mb-2">
    //                 <div class="col-sm-3">
    //                     <input type="text" class="form-control issued-section-name" value="${item.section}" readonly>
    //                 </div>
    //                  <div class="col-sm-3">
    //                     <input type="text" class="form-control issued-purpose" value="${item.purpose}" readonly>
    //                 </div>
    //                 <div class="col-sm-2">
    //                     <input type="number" class="form-control issued-quantity" value="${parseFloat(item.quantity).toFixed(2)}" step="0.1" oninput="updateRemainingBanner()">
    //                 </div>
    //                 <div class="col-sm-3">
    //                     <input type="text" class="form-control issued-shelf-life" value="${shelfLifeFormatted}" readonly>
    //                 </div>
    //                 <div class="col-sm-1">
    //                     <button type="button" class="btn btn-danger btn-sm" onclick="removeIssuedItem(this)">
    //                         <i class="bi bi-trash"></i>
    //                     </button>
    //                 </div>
    //             </div>`;
    //         container.append(itemHtml);
    //     });
    // }
    
    function renderIssuedItemsInModal(items) {
        const container = $('#issuedItemsContainer');
        container.html(''); 
        if (!items || items.length === 0) {
            container.html('<p class="text-muted text-center">No items issued yet.</p>');
            return;
        }
        
        const shelfLifeDateTime = $('#issueInfoBanner').data('shelf-life');
        const shelfLifeFormatted = shelfLifeDateTime ? new Date(shelfLifeDateTime).toLocaleString([], { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' }) : '';
        
        items.forEach(item => {
            const quantityValue = (parseFloat(item.quantity) || 0).toFixed(2);
            
            const itemHtml = `
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-sm-3">
                        <input type="text" class="form-control issued-section-name" value="${item.section || ''}" readonly>
                    </div>
                     <div class="col-sm-3">
                        <input type="text" class="form-control issued-purpose" value="${item.purpose || ''}" readonly>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" class="form-control issued-quantity" value="${quantityValue}" step="0.1" oninput="updateRemainingBanner()">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control issued-shelf-life" value="${shelfLifeFormatted}" readonly>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeIssuedItem(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;
            container.append(itemHtml);
        });
    }
    
    function removeIssuedItem(button) {
        const sectionName = $(button).closest('.row').find('.issued-section-name').val();
        $('#newIssueSection').append(`<option value="${sectionName}">${sectionName}</option>`);
        $(button).closest('.row').remove();
        if ($('#issuedItemsContainer').children().length === 0) {
            $('#issuedItemsContainer').html('<p class="text-muted text-center">No items issued yet.</p>');
        }
        updateRemainingBanner();
    }
    
    function calculateIssuedTotal() {
        const totalThawed = parseFloat($('#issueInfoBanner').data('total-thawed'));
        let issuedTotal = 0;
        $('.issued-quantity').each(function() {
            issuedTotal += parseFloat($(this).val()) || 0;
        });
        return { totalThawed, issuedTotal, remaining: totalThawed - issuedTotal };
    }

    function updateRemainingBanner() {
        const { totalThawed, issuedTotal, remaining } = calculateIssuedTotal();
        const shelfLifeDate = new Date($('#issueInfoBanner').data('shelf-life'));
        const shelfLifeFormatted = shelfLifeDate.toLocaleString([], {day: 'numeric', month: 'numeric', year: 'numeric', hour: '2-digit', minute:'2-digit'});

        $('#issueInfoBanner').html(`
            <strong>Thawing Qty:</strong> ${totalThawed.toFixed(2)} kg | 
            <strong>Remaining:</strong> <span class="${remaining < 0 ? 'text-danger' : ''}">${remaining.toFixed(2)} kg</span><br>
            <strong>Shelf Life:</strong> ${shelfLifeFormatted}
        `);
    }

    // function saveIssuedItems() {
    //     const { remaining } = calculateIssuedTotal();
    //     if (remaining < 0) {
    //         alert("Total issued quantity cannot exceed thawed quantity.");
    //         return;
    //     }

    //     const uuid = $('#issueRecordUUID').val();
    //     const record = allTableData.find(r => r.uuid === uuid);
    //     if (!record) return;

    //     const issuedItems = [];
    //     $('#issuedItemsContainer .row').each(function() {
    //         const section = $(this).find('.issued-section-name').val();
    //         const purpose = $(this).find('.issued-purpose').val();
    //         const quantity = $(this).find('.issued-quantity').val();
    //         const shelfLife = $(this).find('.issued-shelf-life').val();
    //         if (section && parseFloat(quantity) > 0) {
    //             issuedItems.push({ section, purpose, quantity, shelfLife });
    //         }
    //     });

    //     record.issued = JSON.stringify(issuedItems);
    //     issueModal.hide();
    //     filterAndDisplayTable();
    // }

    // function saveIssuedItems() {
    //     const { remaining } = calculateIssuedTotal();
    //     if (remaining < 0) {
    //         alert("Total issued quantity cannot exceed thawed quantity.");
    //         return;
    //     }
    
    //     const uuid = $('#issueRecordUUID').val();
    //     const record = allTableData.find(r => r.uuid === uuid);
    //     if (!record) return;
    
    //     const issuedItems = [];
    //     $('#issuedItemsContainer .row').each(function() {
    //         const section = $(this).find('.issued-section-name').val();
    //         const purpose = $(this).find('.issued-purpose').val();
    //         const quantity = $(this).find('.issued-quantity').val();
    //         const shelfLife = $(this).find('.issued-shelf-life').val();
    //         if (section && parseFloat(quantity) > 0) {
    //             issuedItems.push({ section, purpose, quantity: parseFloat(quantity).toFixed(2), shelfLife });
    //         }
    //     });
    
    //     record.issued = JSON.stringify(issuedItems);
    //     issueModal.hide();
    //     filterAndDisplayTable();
    // }
    
    
// function saveIssuedItems() {
//     const { remaining } = calculateIssuedTotal();
//     if (remaining < 0) {
//         alert("Total issued quantity cannot exceed thawed quantity.");
//         return;
//     }

//     const uuid = $('#issueRecordUUID').val();
//     const record = allTableData.find(r => r.uuid === uuid);
//     if (!record) return;

//     const issuedItems = [];
//     $('#issuedItemsContainer .row').each(function() {
//         const section = $(this).find('.issued-section-name').val();
//         const purpose = $(this).find('.issued-purpose').val();
//         const quantity = $(this).find('.issued-quantity').val();
//         const shelfLife = $(this).find('.issued-shelf-life').val();
//         if (section && parseFloat(quantity) > 0) {
//             issuedItems.push({
//                 section,
//                 purpose,
//                 quantity: parseFloat(quantity).toFixed(2),
//                 shelfLife
//             });
//         }
//     });


//     record.issued = JSON.stringify(issuedItems);

//     // Show data being sent
//     alert("Sending data to server:\n" +
//           "UUID: " + uuid + "\n" +
//           "Issued Items: " + record.issued);

//     // --- AJAX Setup with CSRF Token ---
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     $.ajax({
//         url: "{{ route('record.new.thawing.save.issued.items') }}", // apna route
//         method: 'POST',
//         dataType: 'json',
//         data: {
//             uuid: uuid,
//             issued: record.issued
//         },
//         success: function(response) {
//             toastr.success('Issued items saved successfully!');
//             alert('Server response: ' + JSON.stringify(response));
//             issueModal.hide();
//             filterAndDisplayTable();
//         },
//         error: function(xhr, status, error) {
//             console.error('Save failed:', xhr.responseText || status);
//             toastr.error('Save failed! ' + error);
//             alert('Save failed! ' + error);
//         }
//     });
// }


    function saveIssuedItems() {
        const { remaining } = calculateIssuedTotal();
        if (remaining < 0) {
            alert("Total issued quantity cannot exceed thawed quantity.");
            return;
        }
    
        const uuid = $('#issueRecordUUID').val();
        const record = allTableData.find(r => r.uuid === uuid);
        if (!record) return;
    
        const issuedItems = [];
        $('#issuedItemsContainer .row').each(function() {
            const section = $(this).find('.issued-section-name').val();
            const purpose = $(this).find('.issued-purpose').val();
            const quantity = $(this).find('.issued-quantity').val();
            const shelfLife = $(this).find('.issued-shelf-life').val();
    
            if (section && parseFloat(quantity) > 0) {
                issuedItems.push({
                    section,
                    purpose,
                    quantity: parseFloat(quantity).toFixed(2),
                    shelfLife
                });
            }
        });
    
        const issuedJson = JSON.stringify(issuedItems);
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    
        $.ajax({
            url:  "https://efsm.safefoodmitra.com/admin/public/index.php/record-new/thawing/save-issued-items",   // change to your actual route
            method: 'POST',
            dataType: 'json',
            data: {
                uuid: uuid,
                issued: issuedJson
            },
            success: function(response) {
                toastr.success('Issued items saved successfully!');
                alert('Server response: ' + JSON.stringify(response));
                issueModal.hide();
                filterAndDisplayTable();
            },
            error: function(xhr, status, error) {
                console.error('Save failed:', xhr.responseText || status);
                toastr.error('Save failed! ' + error);
                alert('Save failed! ' + error);
            }
        });
    }
    
    function generateMockData(count) {
        const methods = ['Refrigerator', 'Chilled Running Water', 'Microwave'];
        for (let i = 0; i < count; i++) {
            const outlet = outlets[i % outlets.length];
            const product = products.find(p => p.outletId === outlet.id && batches.some(b => b.productId === p.id && b.quantity > 0)) || products[i % products.length];
            const availableBatches = batches.filter(b => b.productId === product.id && b.quantity > 0);
            if (availableBatches.length === 0) continue;
            const batch = availableBatches[i % availableBatches.length];
            
            const startDate = new Date();
            startDate.setHours(startDate.getHours() - (i * 2));
            
            const isCompleted = i % 2 === 0;
            let completedDate = "";
            let verifierName = "";
            if(isCompleted) {
                const completed = new Date(startDate.getTime());
                completed.setHours(completed.getHours() + (8 + i % 4));
                completedDate = completed.toISOString().slice(0,16);
                if (i % 4 === 0) { // Some completed records are also verified
                    verifierName = `Verifier ${i}`;
                }
            }
            const method = methods[i % methods.length];
            const thawingQuantity = Math.min(batch.quantity, 5 + (i % 5));
            const mockPurpose = purposes[i % purposes.length];

            allTableData.push({
                uuid: generateUUID(), 
                outletId: outlet.id, outletCorporate: outlet.corporate, outletRegional: outlet.regional, outletUnit: outlet.unit, outletDepartment: outlet.department, outletLocation: outlet.location,
                productId: product.id, productName: product.name, brandName: product.brand, 
                manufacturingDate: batch.manufacturingDate, expiryDate: batch.expiryDate,
                batchNumber: batch.number, totalQty: batch.quantity, thawingQuantity: thawingQuantity, storedUnit: batch.storedUnit,
                method: method,
                thawStart: startDate.toISOString().slice(0,16), initialTemp: -18.5 + (i%5), thawingUnit: thawingUnits[i % thawingUnits.length],
                initiatedBy: `User ${Math.floor(i/2) + 1}`, initiatedBySign: '', initialTempImg: placeholderImg,
                waterTemp: method === 'Chilled Running Water' ? 15 + (i % 5) : '',
                waterTempImg: method === 'Chilled Running Water' ? placeholderImg : '',
                thawCompleted: completedDate,
                finalTemp: isCompleted ? (2.5 + (i % 3)) : '', finalTempImg: isCompleted ? placeholderImg : '', 
                completedBy: isCompleted ? `User ${Math.floor(i/2) + 1}` : '', completedBySign: '',
                correctiveAction: isCompleted && (i%8 === 0) ? 'Temperature slightly high, moved to cooler section.' : '', 
                verifierName: verifierName, verificationComments: '', verifierSignature: '', 
                issued: isCompleted ? JSON.stringify([{section: sections[i % sections.length], purpose: mockPurpose, quantity: thawingQuantity, shelfLife: ''}]) : '[]'
            });
        }
    }
    
    function toggleBulkVerifyButton() { /* Logic for bulk verify button not implemented */ }
    
    // ##### PAGINATION FUNCTIONS #####
    function changeRowsPerPage(value) {
        rowsPerPage = parseInt(value);
        currentPage = 1;
        displayTable();
    }

    function goToPage(page) {
        const totalPages = Math.ceil(currentViewData.length / rowsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            displayTable();
        }
    }

    function setupPagination() {
        const paginationLinks = document.getElementById('pagination-links');
        const paginationStatus = document.getElementById('pagination-status');
        paginationLinks.innerHTML = '';

        const totalRows = currentViewData.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        const startRow = (currentPage - 1) * rowsPerPage + 1;
        const endRow = Math.min(currentPage * rowsPerPage, totalRows);

        if (totalRows > 0) {
            paginationStatus.textContent = `Showing ${startRow} to ${endRow} of ${totalRows} entries`;
        } else {
            paginationStatus.textContent = 'No entries found';
        }

        if (totalPages <= 1) return;

        let firstLi = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" onclick="goToPage(1)">&laquo;</a></li>`;
        paginationLinks.innerHTML += firstLi;

        const maxPagesToShow = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
        let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
        if (endPage - startPage + 1 < maxPagesToShow) {
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }
        
        if (startPage > 1) {
            paginationLinks.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="goToPage(1)">1</a></li>`;
            if (startPage > 2) {
                 paginationLinks.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            let pageLi = `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" onclick="goToPage(${i})">${i}</a></li>`;
            paginationLinks.innerHTML += pageLi;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationLinks.innerHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            paginationLinks.innerHTML += `<li class="page-item"><a class="page-link" href="#" onclick="goToPage(${totalPages})">${totalPages}</a></li>`;
        }
        
        let lastLi = `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" onclick="goToPage(${totalPages})">&raquo;</a></li>`;
        paginationLinks.innerHTML += lastLi;
    }

    // ################# FILTERING LOGIC #################
    
    function getUniqueValues(key) {
        return [...new Set(allTableData.map(item => item[key]))].filter(Boolean).sort();
    }
    
    function getUniqueIssuedLocations() {
        const locations = new Set();
        allTableData.forEach(row => {
            if (row.issued && row.issued.length > 2) { // Check for non-empty array "[]"
                try {
                    const issuedItems = JSON.parse(row.issued);
                    issuedItems.forEach(item => locations.add(item.section));
                } catch (e) { /* Ignore parsing errors */ }
            }
        });
        return [...locations].sort();
    }
    
    function createFilterHTML(filterKey) {
        let html = `<form id="filterForm" data-filter-key="${filterKey}">`;
        const f = activeFilters[filterKey] || {};

        const createSelect = (id, label, options, selectedVal) => `
            <div class="mb-2">
                <label class="filter-form-label">${label}</label>
                <select id="${id}" class="form-select filter-select2">
                    <option value="">Any</option>
                    ${options.map(o => `<option value="${o}" ${o === selectedVal ? 'selected' : ''}>${o}</option>`).join('')}
                </select>
            </div>`;

        switch (filterKey) {
            case 'outlet':
                html += createSelect('f_corp', 'Corporate', getUniqueValues('outletCorporate'), f.corp);
                html += createSelect('f_regional', 'Regional', getUniqueValues('outletRegional'), f.regional);
                html += createSelect('f_unit', 'Unit', getUniqueValues('outletUnit'), f.unit);
                html += createSelect('f_dept', 'Department', getUniqueValues('outletDepartment'), f.dept);
                html += createSelect('f_loc', 'Location', getUniqueValues('outletLocation'), f.loc);
                break;
            case 'product':
                html += createSelect('f_prodName', 'Product Name', getUniqueValues('productName'), f.prodName);
                html += `<div class="mb-2"><label class="filter-form-label">Batch Number</label><input type="text" id="f_batch" class="form-control" value="${f.batch || ''}"></div>`;
                html += `
                    <label class="filter-form-label">Manufacturing Date</label>
                    <div class="input-group mb-2"><span class="input-group-text">From</span><input type="date" id="f_mfgFrom" class="form-control" value="${f.mfgFrom || ''}"></div>
                    <div class="input-group mb-2"><span class="input-group-text">To</span><input type="date" id="f_mfgTo" class="form-control" value="${f.mfgTo || ''}"></div>
                    <label class="filter-form-label">Expiry Date</label>
                    <div class="input-group mb-2"><span class="input-group-text">From</span><input type="date" id="f_expFrom" class="form-control" value="${f.expFrom || ''}"></div>
                    <div class="input-group mb-2"><span class="input-group-text">To</span><input type="date" id="f_expTo" class="form-control" value="${f.expTo || ''}"></div>
                `;
                break;
            case 'unitDetails':
                html += createSelect('f_storedUnit', 'Storage Unit (Freezer)', getUniqueValues('storedUnit'), f.storedUnit);
                html += createSelect('f_thawingUnit', 'Thawing Unit (Chiller)', getUniqueValues('thawingUnit'), f.thawingUnit);
                break;
            case 'quantity':
                const methods = ['Refrigerator', 'Chilled Running Water', 'Microwave'];
                html += `
                    <label class="filter-form-label">Thawing Quantity (kg)</label>
                    <div class="input-group mb-2"><span class="input-group-text">From</span><input type="number" id="f_qtyFrom" class="form-control" value="${f.qtyFrom || ''}"></div>
                    <div class="input-group mb-3"><span class="input-group-text">To</span><input type="number" id="f_qtyTo" class="form-control" value="${f.qtyTo || ''}"></div>
                    <label class="filter-form-label">Method</label>
                    <select id="f_method" class="form-select">
                        <option value="">Any</option>
                        ${methods.map(m => `<option value="${m}" ${f.method === m ? 'selected' : ''}>${m}</option>`).join('')}
                    </select>
                `;
                break;
            case 'thawStart':
            case 'thawEnd':
                const fromVal = f.from || '';
                const toVal = f.to || '';
                const isIncompleteChecked = f.incomplete ? 'checked' : '';
                html += `
                    <label class="filter-form-label">Date Range</label>
                    <div class="input-group mb-2"><span class="input-group-text">From</span><input type="datetime-local" id="f_from" class="form-control" value="${fromVal}"></div>
                    <div class="input-group mb-2"><span class="input-group-text">To</span><input type="datetime-local" id="f_to" class="form-control" value="${toVal}"></div>
                `;
                if (filterKey === 'thawEnd') {
                    html += `<div class="form-check mt-2"><input class="form-check-input" type="checkbox" id="f_incomplete" ${isIncompleteChecked}><label class="form-check-label" for="f_incomplete">Show Incomplete Only</label></div>`;
                }
                break;
             case 'initialTemp':
             case 'finalTemp':
                 html += `
                    <label class="filter-form-label">Temperature Range (°C)</label>
                    <div class="input-group mb-2"><span class="input-group-text">Min</span><input type="number" step="0.1" id="f_min" class="form-control" value="${f.min ?? ''}"></div>
                    <div class="input-group mb-2"><span class="input-group-text">Max</span><input type="number" step="0.1" id="f_max" class="form-control" value="${f.max ?? ''}"></div>
                `;
                 break;
             case 'timelapse':
                 html += `
                     <label class="filter-form-label">Time Lapse Range (Hours & Minutes)</label>
                     <div class="input-group mb-2">
                         <span class="input-group-text">From</span>
                         <input type="number" class="form-control" placeholder="Hours" id="f_fromH" value="${f.fromH || ''}">
                         <input type="number" class="form-control" placeholder="Mins" id="f_fromM" value="${f.fromM || ''}">
                     </div>
                     <div class="input-group mb-2">
                         <span class="input-group-text">To</span>
                         <input type="number" class="form-control" placeholder="Hours" id="f_toH" value="${f.toH || ''}">
                         <input type="number" class="form-control" placeholder="Mins" id="f_toM" value="${f.toM || ''}">
                     </div>
                 `;
                 break;
            case 'completedBy':
                html += createSelect('f_name', 'Completed By Name', getUniqueValues('completedBy'), f.name);
                break;
            case 'issuedTo':
                html += createSelect('f_loc', 'Location Name (Section)', getUniqueIssuedLocations(), f.loc);
                break;
            case 'verification':
                 html += `
                    <label class="filter-form-label">Verification Status</label>
                    <select id="f_status" class="form-select">
                        <option value="">Any</option>
                        <option value="completed" ${f.status === 'completed' ? 'selected' : ''}>Completed</option>
                        <option value="pending" ${f.status === 'pending' ? 'selected' : ''}>Pending</option>
                    </select>
                 `;
                 break;
            default:
                html += `<p>No filter options available for this column.</p>`;
        }
        return html + `</form>`;
    }
    
    function openFilterModal(filterKey, headerText) {
        $('#filterModalLabel').text(`Filter by ${headerText}`);
        $('#filterModalBody').html(createFilterHTML(filterKey));
        
        $('.filter-select2').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#filterModal'),
            placeholder: 'Any'
        });

        filterModal.show();
    }

    function saveCurrentFilter() {
        const form = $('#filterForm');
        const filterKey = form.data('filter-key');
        let currentFilter = {};

        switch (filterKey) {
            case 'outlet':
                currentFilter = { corp: $('#f_corp').val(), regional: $('#f_regional').val(), unit: $('#f_unit').val(), dept: $('#f_dept').val(), loc: $('#f_loc').val() };
                break;
            case 'product':
                currentFilter = { prodName: $('#f_prodName').val(), batch: $('#f_batch').val(), mfgFrom: $('#f_mfgFrom').val(), mfgTo: $('#f_mfgTo').val(), expFrom: $('#f_expFrom').val(), expTo: $('#f_expTo').val() };
                break;
            case 'unitDetails':
                currentFilter = { storedUnit: $('#f_storedUnit').val(), thawingUnit: $('#f_thawingUnit').val() };
                break;
            case 'quantity':
                currentFilter = { qtyFrom: $('#f_qtyFrom').val(), qtyTo: $('#f_qtyTo').val(), method: $('#f_method').val() };
                break;
            case 'thawStart':
            case 'thawEnd':
                 currentFilter = { from: $('#f_from').val(), to: $('#f_to').val() };
                 if (filterKey === 'thawEnd') currentFilter.incomplete = $('#f_incomplete').is(':checked');
                 break;
            case 'initialTemp':
            case 'finalTemp':
                 currentFilter = { min: $('#f_min').val(), max: $('#f_max').val() };
                 break;
            case 'timelapse':
                currentFilter = { fromH: $('#f_fromH').val(), fromM: $('#f_fromM').val(), toH: $('#f_toH').val(), toM: $('#f_toM').val() };
                break;
            case 'completedBy':
                currentFilter = { name: $('#f_name').val() };
                break;
            case 'issuedTo':
                 currentFilter = { loc: $('#f_loc').val() };
                 break;
            case 'verification':
                 currentFilter = { status: $('#f_status').val() };
                 break;
        }

        if (Object.values(currentFilter).every(v => v === "" || v === false || v === null)) {
            delete activeFilters[filterKey];
        } else {
            activeFilters[filterKey] = currentFilter;
        }

        filterAndDisplayTable();
        filterModal.hide();
    }

    function clearCurrentFilter() {
        const filterKey = $('#filterForm').data('filter-key');
        delete activeFilters[filterKey];
        filterAndDisplayTable();
        filterModal.hide();
    }
    
    function clearAllFilters() {
        activeFilters = {};
        filterAndDisplayTable();
    }

    function filterAndDisplayTable() {
        currentViewData = allTableData.filter(row => {
            return Object.keys(activeFilters).every(key => {
                const f = activeFilters[key];
                if (!f) return true;

                switch (key) {
                    case 'outlet':
                        return (!f.corp || row.outletCorporate === f.corp) &&
                               (!f.regional || row.outletRegional === f.regional) &&
                               (!f.unit || row.outletUnit === f.unit) &&
                               (!f.dept || row.outletDepartment === f.dept) &&
                               (!f.loc || row.outletLocation === f.loc);
                    case 'product':
                        const mfgDate = new Date(row.manufacturingDate);
                        const expDate = new Date(row.expiryDate);
                        return (!f.prodName || row.productName === f.prodName) &&
                               (!f.batch || row.batchNumber.toLowerCase().includes(f.batch.toLowerCase())) &&
                               (!f.mfgFrom || mfgDate >= new Date(f.mfgFrom)) &&
                               (!f.mfgTo || mfgDate <= new Date(f.mfgTo)) &&
                               (!f.expFrom || expDate >= new Date(f.expFrom)) &&
                               (!f.expTo || expDate <= new Date(f.expTo));
                    case 'unitDetails':
                        return (!f.storedUnit || row.storedUnit === f.storedUnit) &&
                               (!f.thawingUnit || row.thawingUnit === f.thawingUnit);
                    case 'quantity':
                        const qty = parseFloat(row.thawingQuantity);
                        const fromQty = f.qtyFrom !== '' && !isNaN(f.qtyFrom) ? parseFloat(f.qtyFrom) : null;
                        const toQty = f.qtyTo !== '' && !isNaN(f.qtyTo) ? parseFloat(f.qtyTo) : null;
                        const fromOk = fromQty === null || qty >= fromQty;
                        const toOk = toQty === null || qty <= toQty;
                        return fromOk && toOk && (!f.method || row.method === f.method);
                    case 'thawStart':
                        const startDate = new Date(row.thawStart);
                        return (!f.from || startDate >= new Date(f.from)) && (!f.to || startDate <= new Date(f.to));
                    case 'thawEnd':
                        const isComplete = !!row.thawCompleted;
                        if (f.incomplete) return !isComplete;
                        if (!isComplete) return false;
                        const hasDateFilter = f.from || f.to;
                        if (hasDateFilter) {
                            const endDate = new Date(row.thawCompleted);
                            const fromOk = !f.from || endDate >= new Date(f.from);
                            const toOk = !f.to || endDate <= new Date(f.to);
                            return fromOk && toOk;
                        }
                        return true; // Show all completed if no date range is set
                    case 'initialTemp':
                    case 'finalTemp':
                        const temp = parseFloat(row[key]);
                        if (isNaN(temp)) return false;
                        const min = f.min !== '' && !isNaN(f.min) ? parseFloat(f.min) : null;
                        const max = f.max !== '' && !isNaN(f.max) ? parseFloat(f.max) : null;
                        const minPass = min === null || temp >= min;
                        const maxPass = max === null || temp <= max;
                        return minPass && maxPass;
                    case 'timelapse':
                        if (!row.thawStart || !row.thawCompleted) return false;
                        const diffMins = (new Date(row.thawCompleted).getTime() - new Date(row.thawStart).getTime()) / 60000;
                        const fromMins = (parseInt(f.fromH || 0) * 60) + parseInt(f.fromM || 0);
                        const toMins = (parseInt(f.toH || 0) * 60) + parseInt(f.toM || 0);
                        return (!fromMins || diffMins >= fromMins) && (!toMins || diffMins <= toMins);
                    case 'completedBy':
                        return !f.name || row.completedBy === f.name;
                    case 'issuedTo':
                        const issuedData = JSON.parse(row.issued);
                        return !f.loc || issuedData.some(item => item.section === f.loc);
                    case 'verification':
                        if (f.status === 'completed') return !!row.verifierName;
                        if (f.status === 'pending') return !!row.thawCompleted && !row.verifierName;
                        return true;
                    default: return true;
                }
            });
        });
        
        updateFilterIcons();
        currentPage = 1;
        displayTable();
    }
    
    function updateFilterIcons() {
        $('.filter-icon').removeClass('active');
        Object.keys(activeFilters).forEach(key => {
            $(`.filter-icon[data-filter-key="${key}"]`).addClass('active');
        });
    }
</script>

</body>
</html>