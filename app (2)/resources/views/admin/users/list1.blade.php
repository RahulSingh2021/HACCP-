@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}
</style>
@section('content')
 
                    <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="pill" href="#company-details" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    
                                                    <div class="tab-title">Company Details</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#location-management" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Location Management</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Authority" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                   <div class="tab-title">Authority</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#user-management" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">User Management</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="company-details" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col">
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addcompanydetails" style="position: absolute;right:16px;top: 16px;">+ Add User</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
                                                    <th width="30">No.</th>
                                                    <th>Hotle Name</th>
                                                    <th>Employee ID</th>
                                                    <th>Employee Full Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Department</th>
                                                    <th width="80">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>1</td>
                                                    <td>this feilds are editable...</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td><ul id="myUL">
                                                        <li><span class="caret">Department Name<i class='bx bx-pencil font-18 me-1'></i></span>
                                                                  <ul class="nested">
                                                                    
                                                        <li><span class="caret">Location Name<i class='bx bx-pencil font-18 me-1'></i></span>
                                                                      <ul class="nested">
                                                                       
                                                        <li><span class="caret">Sub Location Name <i class='bx bx-pencil font-18 me-1'></i></span>
                                                                          <ul class="nested">
                                                               
                                                                <li>Sub Sub Location <i class='bx bx-pencil font-18 me-1'></i></li>
                                                                            
                                                                          </ul>
                                                                        </li>
                                                            
                                                                      </ul>
                                                                      
                                                                    </li> 
                                                                         
                                                                  </ul>
                                                                </li>
                                                              </ul></td>
                                                    <td align="center">
                                                    <i data-bs-toggle="modal" data-bs-target="#addnewuser" class="font-20 bx bxs-pencil" style="cursor:pointer;"></i>
                                                        <i class="font-20 bx bxs-trash"></i> </td>
                                                  </tr>
                                                  <tr>
                                                    <td>2</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                   
                                                  </tr>
                                                  <tr>
                                                    <td>3</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                   
                                                  </tr>
                                                  
                                                </tbody>
                                              </table>
                                        </div>
                                        <div class="tab-pane fade" id="location-management" role="tabpanel">
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row row-cols-auto g-1">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-outline-dark px-3">Add Department</button>
                                                        </div>
                                                        
                                                        <div class="col">
                                    <button type="button" class="btn btn-outline-dark px-2"><i class='bx bx-trash font-18 me-0'></i></button>
                                                        </div>
                                                
                                                    </div> 
                                                    <table class="table table-bordered table-striped mt-4">
                                                    <thead>
                                                      <tr>
                                                        <th width="30"><input class="form-check-input" type="checkbox" value=""></th>
                                                        <th width="30">SN.</th>
                                                        <th>Department Name</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td><input class="form-check-input" type="checkbox" value=""></td>
                                                        <td>1</td>
                                                        <td><ul id="myUL">
                                                    <li><span class="caret">Department Name 1 <i class='bx bx-pencil font-18 me-1'></i></span>
                                                              <ul class="nested">
                                                                <li><button type="button" class="btn p-0">+ Add New Location</button></li>
                                                        <li>Location 1 <i class='bx bx-pencil font-18 me-1'></i></li>
                                                        <li>Location 2 <i class='bx bx-pencil font-18 me-1'></i></li>
                                                        <li><span class="caret">Location 3 <i class='bx bx-pencil font-18 me-1'></i></span>
                                                                  <ul class="nested">
                                                                    <li><button type="button" class="btn p-0">+ Add New Sub Location</button></li>
                                                    <li>3 Sub Location 1 <i class='bx bx-pencil font-18 me-1'></i></li>
                                                    <li>3 Sub Location 2 <i class='bx bx-pencil font-18 me-1'></i></li>
                                                    <li><span class="caret">3 Sub Location 3 <i class='bx bx-pencil font-18 me-1'></i></span>
                                                                      <ul class="nested">
                                                                        <li><button type="button" class="btn p-0">+ Add New Sub Location</button></li>
                                                                        <li>3 Sub Sub Location 1 <i class='bx bx-pencil font-18 me-1'></i></li>
                                                                        <li>3 Sub Sub Location 1 <i class='bx bx-pencil font-18 me-1'></i></li>
                                                                        
                                                                      </ul>
                                                                    </li>
                                                        
                                                                  </ul>
                                                                  
                                                                </li> 
                                                                     
                                                              </ul>
                                                            </li>
                                                          </ul></td>
                                                      </tr>
                                                      <tr>
                                                        <td><input class="form-check-input" type="checkbox" value=""></td>
                                                        <td>2</td>
                                                        <td>Department Name here... <i class='bx bx-pencil font-18 me-1'></i></td>
                                                      </tr>
                                                      <tr>
                                                        <td><input class="form-check-input" type="checkbox" value=""></td>
                                                        <td>3</td>
                                                        <td>Department Name here... <i class='bx bx-pencil font-18 me-1'></i></td>
                                                      </tr>                                                  
                                                    </tbody>
                                                </table></div>
                                                
                                                
                                                
                                            </div>
                                            

                                            
                                            
                                       </div>
                                       <div class="tab-pane fade" id="Authority" role="tabpanel">
                                            
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row row-cols-auto g-1">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-outline-dark px-3">Add Authority Name</button>
                                                    </div>
                                                    
                                                    <div class="col">
                                <button type="button" class="btn btn-outline-dark px-2"><i class='bx bx-trash font-18 me-0'></i></button>
                                                    </div>
                                            
                                                </div> 
                                                <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
                                                    <th width="30"><input class="form-check-input" type="checkbox" value=""></th>
                                                    <th width="30">SN.</th>
                                                    <th>Authority Name</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>1</td>
                                                    <td>Authority Name here... <i class='bx bx-pencil font-18 me-1'></i></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>2</td>
                                                    <td>Authority Name here... <i class='bx bx-pencil font-18 me-1'></i></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>3</td>
                                                    <td>Authority Name here... <i class='bx bx-pencil font-18 me-1'></i></td>
                                                  </tr>                                                  
                                                </tbody>
                                            </table></div>
                                            
                                            
                                            
                                        </div>
                                        

                                        
                                        
                                   </div>
                                        <div class="tab-pane fade" id="user-management" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col">
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewuser" style="position: absolute;right:16px;top: 16px;">+ Add User</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
                                                    <th width="30">No.</th>
                                                    <th>Hotle Name</th>
                                                    <th>Employee ID</th>
                                                    <th>Employee Full Name</th>
                                                    <th>Contact Number</th>
                                                    <th>Department</th>
                                                    <th width="80">Action</th>
                                                    <th>Athority</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td>1</td>
                                                    <td>this feilds are editable...</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td><ul id="myUL">
                                                        <li><span class="caret">Department Name<i class='bx bx-pencil font-18 me-1'></i></span>
                                                                  <ul class="nested">
                                                                    
                                                        <li><span class="caret">Location Name<i class='bx bx-pencil font-18 me-1'></i></span>
                                                                      <ul class="nested">
                                                                       
                                                        <li><span class="caret">Sub Location Name <i class='bx bx-pencil font-18 me-1'></i></span>
                                                                          <ul class="nested">
                                                               
                                                                <li>Sub Sub Location <i class='bx bx-pencil font-18 me-1'></i></li>
                                                                            
                                                                          </ul>
                                                                        </li>
                                                            
                                                                      </ul>
                                                                      
                                                                    </li> 
                                                                         
                                                                  </ul>
                                                                </li>
                                                              </ul></td>
                                                    <td align="center">
                                                    <i data-bs-toggle="modal" data-bs-target="#addnewuser" class="font-20 bx bxs-pencil" style="cursor:pointer;"></i>
                                                        <i class="font-20 bx bxs-trash"></i> </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <i class="font-20 bx bx-menu" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>                                                          
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin: 0px;">
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                        <li><a class="dropdown-item" href="#"> 
                                                                            <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                                                                            <label class="form-check-label" for="flexCheckIndeterminate">Indeterminate checkbox</label>
                                                                            </div>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                            </div>  
                                                        </td>
                                                  </tr>
                                                  <tr>
                                                    <td>2</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                  </tr>
                                                  <tr>
                                                    <td>3</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                  </tr>
                                                  
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
        
@endsection



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@if($errors->any())
<script>
    $(document).ready(function() {
    $('#addcompanydetails').modal('show');
});
     </script>
@endif

   