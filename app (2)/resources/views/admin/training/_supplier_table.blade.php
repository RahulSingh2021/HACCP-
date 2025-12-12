    @if($suppliers)
            @foreach($suppliers as $supplier)
             <tr data-supplier-id="supplier-{{ $supplier->id }}">
                 @php 
                     $corporate = DB::table('users')->where('id',$supplier->corporate_id)->first();
                     $regional = DB::table('users')->where('id',$supplier->regional_id)->first();
                     $unit = DB::table('users')->where('id',$supplier->unit_id)->first();
                     
                     $created =  DB::table('users')->where('id',$supplier->created_by)->first();
                     $auth = Auth::id();
                 @endphp
                 
                <td><span class="cell-secondary" data-field="hierarchy">{{$corporate->company_name ?? 'N/A'}} > {{$regional->company_name ?? 'N/A'}} > {{$unit->company_name ?? 'N/A'}}</span></td>
                <td>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="cell-primary" data-field="supplierName">{{$supplier->name ?? 'N/A'}}</span>
                        
                       @if ($supplier->created_by == $auth)
                            <span class="delete-supplier" 
                                  data-supplier-id="{{ $supplier->id }}" 
                                  style="cursor:pointer" 
                                  title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     class="delete-icons" 
                                     viewBox="0 0 24 24" 
                                     width="20" 
                                     height="20">
                                    <path fill="red" d="M3 6h18v2H3V6zm2 3h14l-1.5 13h-11L5 9zm4 2v9h2v-9H9zm4 0v9h2v-9h-2z"/>
                                </svg>
                            </span>
                        @endif
                        <span class="badge {{ $supplier->status == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                            {{ $supplier->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                            
                    </div>
                    <span class="cell-secondary">
                        <strong>Uploaded by:</strong> {{$created->name ?? 'N/A'}}<br>
                        <strong>Service Nature:</strong> <span data-field="serviceNature">{{$supplier->service_nature ?? 'N/A'}}</span> <br>
                        <strong>Email:</strong> <span data-field="email">{{$supplier->email ?? 'N/A'}}</span> <br>
                        <div class="upload-container" data-container="license-upload">
                            <div class="upload-status-wrapper" data-upload-type="fssai">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <span>FSSAI: <span class="fssai-number" data-field="license-number">{{$supplier->license_number ?? 'N/A'}}</span> </span>
                                      <span class="badge {{ $supplier->license_expiry_date > now()->toDateString() ? 'text-bg-success' : 'text-bg-danger' }}" data-field="license-status">
                                            {{ $supplier->license_expiry_date > now()->toDateString() ? 'Valid' : 'Invalid' }}
                                        </span>

                                    </div>
                                    <div class="icon-actions"><button class="icon-button view-icon" data-bs-toggle="tooltip" title="View FSSAI"><i class="bi bi-eye-fill"></i></button><button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#uploadLicenseModal" title="Edit FSSAI"><i class="bi bi-pencil-fill"></i></button><button class="icon-button delete-icon" data-bs-toggle="tooltip" title="Delete FSSAI"><i class="bi bi-trash-fill"></i></button></div>
                                </div>
                            </div>
                        </div>
                        <strong>Address:</strong> <span data-field="address">{{$supplier->full_address ?? 'N/A'}}</span><br>
                        <strong>Data updated on:</strong> <span class="last-updated">{{$supplier->updated_at ?? 'N/A'}}</span>
                    </span>
                    <div class="form-check form-switch form-switch-accept-reject mt-2"><input class="form-check-input" type="checkbox" role="switch" id="acceptReject1" checked><label class="form-check-label small" for="acceptReject1">Accepted</label></div>
              
                    <!--<div class="form-check form-switch form-switch-accept-reject mt-2"><input class="form-check-input" type="checkbox" role="switch" id="acceptReject1" data-id="{{$supplier->id}}"><label class="form-check-label small" for="acceptReject1">Rejected</label></div>-->
                    <!-- <div class="form-check form-switch form-switch-accept-reject mt-2">-->
                    <!--    <input class="form-check-input acceptRejectSwitch" -->
                    <!--           type="checkbox" -->
                    <!--           role="switch" -->
                    <!--           id="acceptReject1" -->
                    <!--           data-id="{{ $supplier->id }}">-->
                    <!--    <label class="form-check-label small" for="acceptReject1">Rejected</label>-->
                    <!--</div>-->

                   
                </td>
                <td>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="cell-primary d-block">Type: <span data-field="contractType">{{$supplier->contract_type ?? 'N/A'}}</span></span>
                        <div class="contract-status-container"></div>
                    </div>
                    <span class="cell-secondary">
                        Contract No: <span data-field="contractNumber">{{$supplier->contract_number ?? 'N/A'}}</span><br>
                        Start: {{$supplier->contract_start_date ?? 'N/A'}} | End: <span data-field="contract-end-date">{{$supplier->contract_end_date ?? 'N/A'}}</span>
                    </span>
                    <div class="upload-container mt-2" data-container="contract-upload">
                        <div class="upload-status-wrapper" data-upload-type="contract-static"><div class="icon-actions mb-2">
                            
                              @if(!empty($supplier->contract_document))
                                <a href="{{$supplier->contract_document}}" 
                                   target="_blank" 
                                   class="icon-button view-icon" 
                                   data-bs-toggle="tooltip" 
                                   title="View Contract">
                                   <i class="bi bi-eye-fill"></i>
                                </a>
                            @endif
            
                            <!--<button class="icon-button view-icon" data-bs-toggle="tooltip" title="View Contract"><i class="bi bi-eye-fill"></i></button>-->
                            
                            
                            <!--<button class="icon-button edit-icon" data-bs-toggle="modal" data-bs-target="#uploadContractModal" title="Edit Contract"><i class="bi bi-pencil-fill"></i></button>-->
                            
                              {{-- ✅ Edit Contract --}}
                                <button class="icon-button edit-icon" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#uploadContractModal"
                                        data-id="{{ $supplier->id }}"
                                        data-type = "{{$supplier->contract_type}}"
                                        data-number="{{ $supplier->contract_number }}"
                                        data-start="{{ $supplier->contract_start_date }}"
                                        data-end="{{ $supplier->contract_end_date }}"
                                        title="Edit Contract">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                
                            
                            <!--<button class="icon-button delete-icon" data-bs-toggle="tooltip" title="Delete Contract"><i class="bi bi-trash-fill"></i></button>-->
                             {{-- ✅ Delete Contract --}}
                                <button class="icon-button delete-icon" 
                                        data-id="{{ $supplier->id }}" 
                                        data-bs-toggle="tooltip" 
                                        title="Delete Contract">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
            
                            
                            </div><span class="text-success small fw-bold d-flex align-items-center gap-1"><i class="bi bi-check-circle-fill"></i> Uploaded on: @if($supplier->contract_uploaded_on) {{$supplier->contract_uploaded_on}} @else N/A @endif</span></div>
                    </div>
                </td>
                <td>
                    <span class="cell-primary risk-category risk-medium">{{$supplier->risk}} Risk</span>
                    <!--<span class="cell-secondary d-block">Soya Chikka, Soya Vegget<br>Total Items: 2</span>-->
                    <span class="cell-secondary d-block">Total Items: {{$supplier->vendor_count}}</span>

                <div class="mt-2">
                  <button
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#listingModal{{$supplier->id}}"
                  >
                    Add & View List
                  </button>
                </div>
                </td>
                <td>
                    <span class="cell-primary d-block" data-field="audit-score">88 / 100</span>
                    <span class="cell-secondary">Freq: <span data-field="audit-frequency">Annually</span> | Last: <span data-field="audit-last-date">2023-11-15</span><br>NCs: <span class="nc-closed">3 Closed</span> / <span class="nc-open">1 Open</span></span>
                    <div class="mt-2"><button class="btn btn-sm btn-warning">Start Audit</button></div>
                </td>
                <td>
                    <span class="cell-primary d-block" data-field="eval-score">88% / >85%</span>
                    <span class="cell-secondary">Freq: Annually | Last: <span data-field="eval-last-date">2023-11-20</span></span>
                    <div class="mt-2"><button class="btn btn-sm btn-warning">Start Eval</button></div>
                </td>
                <td><span class="cell-primary d-block">2 Complains</span><span class="cell-secondary">Last: 2024-02-10</span><div class="mt-2"><button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#complainHistoryModal">History</button><button class="btn btn-sm btn-outline-danger mt-1" data-bs-toggle="modal" data-bs-target="#complianceLogModal">Create Ticket</button></div></td>
                <td>
                    <div class="d-flex flex-column gap-2">
                        <div class="open-ticket-button-placeholder"></div>
                        <button class="btn btn-sm btn-warning d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#editSupplierModal"><i class="bi bi-pencil-fill"></i> Edit</button>
                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#logBookModal">Log Book</button>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">Renew</button>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#renewHistoryModal">Renew History</button>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="toggle1" checked><label class="form-check-label" for="toggle1">Active</label></div>
                    </div>
                </td>
            </tr>

            @endforeach
            @endif