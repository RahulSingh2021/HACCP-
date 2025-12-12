 <!-- Details Modal -->
    <div class="modal fade" id="productexampleExtraLargeModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailsModalLabel"><i class="bi bi-clipboard2-check me-2"></i><span id="modalUnitNameText">Unit Certificate Details</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3 pb-3 border-bottom">
                        <strong>Unit ID:</strong> <span id="modalUnitId" class="text-muted">{{$unit_id ?? ''}}</span> |
                        <strong>Address:</strong> <span id="modalUnitAddress" class="text-muted">{{$unitDetails->Company_address ?? ''}}</span>
                    </div>
                    <div class="cert-summary bg-light p-3 rounded border mb-4 shadow-sm">
                        <h6 class="text-primary mb-3">Status Summary</h6>
                        <div class="row g-3 text-center mb-3">
                            
                            @php
                            
                            
                             $unitId =  $unit_id; 
 $counts = Helper::totalValidCertificateByunitId($unitId);
    $valid = $counts['valid'];
    $expired = $counts['expired'];

    $validCount = $valid;
    $totalExpired = $expired;

     $validunituser = Helper::totalunitId($unitId); 

    $validunituser = Helper::totalunitId($unitId); // total units for this unitId
    $required = $validunituser / 25;

    // Count unit as compliant if valid certs >= required
    if ($valid >= $required) {
        $totalCompliance=1;
    }else{
      $totalCompliance=0;  
    }



                            @endphp
                            
                           
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Required</div>    <div id="modalReqCount" class="fs-4 fw-bold text-primary">{{$required}}
</div>
</div>
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Valid</div><div id="modalValidCount" class="fs-4 fw-bold text-success">{{$validCount}}</div></div>
                            <div class="col-6 col-sm-3 summary-item"><div class="small text-muted">Expiring Soon</div><div id="modalExpiringCount" class="fs-4 fw-bold text-warning">{{$totalExpired}}</div></div>
                        </div>
                        <div class="progress-container" id="modalProgressContainer" data-progress-text="0%" style="height: 12px;"><div class="progress" style="height: 12px;"><div class="progress-bar" id="modalProgressBar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div>
                    </div>
                    <h6 class="text-primary mt-4 mb-3">Unit Certificate Details</h6>
                    <ul class="list-group list-group-flush" id="modalCertList">

                @foreach($history as $historys)
                       <li class="list-group-item d-flex flex-wrap justify-content-between align-items-center cert-list-item">
                        <div class="flex-grow-1 me-3">
                            <div class="fw-bold">{{Helper::employeeDetails($historys->unit_id ?? '')->employer_fullname ?? ''}}</div>
                            
                            
                        @php
    $statusText = 'N/A';
    $badgeClass = 'bg-secondary';
    $formattedDate = '—';

    if (!empty($historys->trainingDate)) {
        $baseDate = \Carbon\Carbon::parse($historys->trainingDate);
        $validity = $historys->certificateValidity;

        if ($validity === '1 Year') {
            $dueDate = $baseDate->copy()->addYear();
        } elseif ($validity === '2 Years') {
            $dueDate = $baseDate->copy()->addYears(2);
        } else {
            $dueDate = null;
        }

        if ($dueDate) {
            $currentDate = \Carbon\Carbon::now();
            $diffInDays = $currentDate->diffInDays($dueDate, false);

            if ($diffInDays < 0) {
                $statusText = 'Expired';
                $badgeClass = 'bg-danger';
            } elseif ($diffInDays <= 30) {
                $statusText = 'Expiring Soon';
                $badgeClass = 'bg-warning text-dark';
            } else {
                $statusText = 'Valid';
                $badgeClass = 'bg-success';
            }

            $formattedDate = $dueDate->format('d M Y');
        } else {
            $statusText = 'Always Valid';
            $badgeClass = 'bg-success';
        }
    }
@endphp



<small class="text-muted">
    <span class="badge {{ $badgeClass }} me-2 text-capitalize">{{ $statusText }}</span>
    Expires: {{ $formattedDate }}
</small>

                        </div>
                        </li>
                        
                        @endforeach
                        
                        </ul>
                </div>
                <div class="modal-footer bg-light"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>