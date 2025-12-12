


 <div class="modal fade" id="productexampleExtraLargeModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Training History for Alice Brown (ID: EMP-002)</h5>
                                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div style="margin-bottom: 15px; font-size: 14px; padding-bottom: 10px; border-bottom: 1px solid #eee;"><strong>Current Status:</strong> <span id="history-current-status" class="status completed">Completed</span></div>
                                   <h3 style="margin-top: 20px; margin-bottom: 10px; font-size: 1rem;">Training Record History</h3>
                                   
                                   <div class="scrollable-table">
                     <table class="parameter-history-table">
                         <thead><tr><th>Updated On</th><th>Training Level</th><th>Training Type</th><th>Training Date</th><th>Cert. Validity</th><th>Cert.</th><th>Overall Status</th><th>Updated By</th></tr></thead>
                         <tbody id="training-history-details">
                                                                            @foreach($history as $historys)

                             <tr class="history-header">
                                 <td>Current</td><td>{{$historys->trainingLevel ?? ''}}</td><td>{{$historys->trainingType ?? ''}}</td><td>{{$historys->trainingDate ?? ''}}</td><td>{{$historys->certificateValidity ?? ''}}</td><td>Uploaded</td>
                                 <td><span class="status completed">{{$historys->status ?? ''}}</span></td>
                                 <td>{{$exitsresult->employer_fullname ?? ''}}</td>
                                 </tr>
                                  @endforeach
                                 </tbody>
                     </table>
                 </div>
                 
                 
                                 
                                </div>
                            </div>
                        </div>
                    </div>