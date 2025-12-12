


 <div class="modal fade" id="productexampleExtraLargeModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">License History Log</h5>
                                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            Unit Name: <strong id="historyUnitName"><?= Auth::user()->company_name ?></strong>
                                        </div>
                                        <div class="col-md-6">
                                            License Number: <strong id="historyLicenseNumber">{{$lincess_number ?? ''}}</strong>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                    
                    <tr style="background-color: var(--primary-color, #2c5f9e);color: white;font-weight: 500;vertical-align: middle;white-space: nowrap;position: relative;height: 50px;">
                        <th style="padding: 10px;">Updated date</th>
                        <th style="padding: 10px;">Unit Name</th>
                        <!--<th>License Type</th>-->
                        <th style="padding: 10px;">License Number</th>
                        <th style="padding: 10px;">Expiry Date</th>
                        <th style="padding: 10px;">Status </th>
                        <th style="padding: 10px;">Category</th>
                        <th style="padding: 10px;">Update Comments</th>
                    </tr>
                    
                                               @foreach($history as $historys)
                    <tr>
                                           <td>{{$historys->updated_at ?? ''}}</td>
                        <td>{{Helper::user_info($historys->unit_id)->company_name ?? ''}}</td>
                        <!--<td>{{$historys->history ?? ''}}</td>-->
                        <td>{{$historys->lincess_number ?? '-'}}</td>
                        <td>{{$historys->due_date ?? ''}}</td>
                        <td >                                      @if(\Carbon\Carbon::parse($historys->due_date)->isFuture())
    Active
@else
    <span style="color: red;">Expired</span>
@endif<a href="{{asset('documents')}}/{{$historys->image ?? ''}}" target="_blank()">(view)</a></td>
                        <td>{{$historys->cat_type ?? ''}}</td>
                        <td>{{$historys->comment ?? ''}}</td>
                    </tr>
                   @endforeach
                </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>