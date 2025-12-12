
@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}

.collapseButton {
  vertical-align: text-top;
}

th, td {
  padding: 1em;
}

#hidden {
  display: none;
}


table {
  border-collapse: collapse;
}
p {
    margin-top: 0;
    margin-bottom: 5px !important;
}



table th, td {
  padding: 1em;
  text-align: center;
}

.pagination {
    display: block !important;
        margin-bottom: 20px;
}

img, svg {
    vertical-align: middle;
    width: 20px;
}
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
.pagination {
    display: block !important;
        margin-bottom: 20px;
}
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
    margin-top: 24px;
}
        .step-number {
            border-top: #333 2px solid;
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            position: relative;
        }

        .step-number:before {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
        }

        .step-number:after {
            content: "";
            background: #fff;
            display: block;
            position: absolute;
            height: 3px;
            width: 27px;
            top: -2px;
            z-index: 0;
            right: 0;
        }

        .step-number span {
            margin-top: -15px;
            text-align: center;
            z-index: 1;
        }

        .step-number em {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            text-align: center;
            font-style: normal;
            line-height: 30px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .ins-t td {
            font-size: 13px;
            padding: 5px 0px;
        }

        .cam-img {
            width: 100%;
            background: #f7f7f7;
            height: 80%;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .imageuploadify {
            min-height: 150px;
        }

        .imageuploadify-message {
            display: none !important;
        }

        .imageuploadify .imageuploadify-images-list i {
            font-size: 3em;
            height: 50px;
        }
        
        
        
        html {
  box-sizing: border-box;
}
*,
*:before,
*:after {
  box-sizing: inherit;
}
.intro {
  max-width: 1280px;
  margin: 1em auto;
}
.table-scroll {
  position: relative;
  width:100%;
  z-index: 1;
  margin: auto;
  overflow: auto;
  height: 950px;
}
.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  border: 1px solid #000;
  background: #fff;
  vertical-align: top;
}
.table-scroll thead th {
  background: #333;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
/* safari and ios need the tfoot itself to be position:sticky also */
.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #666;
  color: #fff;
  z-index:4;
}

a:focus {
  background: red;
} /* testing links*/

th:first-child {
  position: -webkit-sticky;
  position: sticky;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
}
#loader {
    position: fixed; /* Use fixed to make sure it's always in view */
    z-index: 9999999;
    width: 100%;
    height: 100%;
    background: rgba(147, 112, 219, 0.5); /* MediumVioletRed with opacity */
    text-align: center;
}

#loader::after {
    content: "";
    width: 60px;
    height: 60px;
    border: 6px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite; /* Animation to create spinner effect */
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -30px; /* Half of width */
    margin-top: -30px; /* Half of height */
}

@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}

.page-content a {
    color: #008cff !important;
}

.license-box {
          
          
            border-radius: 10px;
            padding: 20px;
            text-align: left;
            font-family: Arial, sans-serif;
        }
        .license-box div {
            margin-bottom: 10px;
        }
        .view-history a {
            color: blue;
            text-decoration: none;
        }
        .view-history a:hover {
            text-decoration: underline;
        }
        
                .corporateManageBx {
    padding: 25px;
    background: #fff;
    padding: 25px 15px;
    /* display: flex; */
    /* align-items: flex-start; */
    gap: 27px 21px;
    flex-wrap: wrap;
    margin: 0 0 30px;
    border-radius: 22px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.2);
}
</style>
    <link rel="stylesheet" href="{{asset('assets/css/new/style.css')}}" />

@section('content')

     @include('admin.users.popups.reginoal')
@include('admin.users.popups.unit')


  <div class="row">
                         <div class="col">
                
                                                <div class="col">
                                                    
                                                    <?php  $is_role = Auth::user()->is_role; ?>
                                                     @if($is_role==0)
                                                     
                                                                 <div class="card">
                                <div class="card-body">
              
                             
                                            <div class="row row-cols-auto g-3" style="
    margin-bottom: 20px;">
                    <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addcompanydetails" >+ Add Corporate</button>
                                 </div>
 
                              
                                                   </div>
                                            </div>
                    @endif
                    
                     @if($is_role !=1 && $is_role !=3)
                                                                     <div class="card">
                                <div class="card-body">
              
                             
                                            <div class="row row-cols-auto g-3" style="
    margin-bottom: 20px;">
                   <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addregionaldetails">+ Add Regional</button>
                                </div>
 
                              
                                                   </div>
                                            </div>
                    @endif
													
													                        <!--<button type="button" class="btn btn-outline-dark px-3" >Dashboard</button>-->
                        <!--<a href="{{route('department')}}" class="btn btn-outline-dark px-3" style="background: #0d6efd;border: navajowhite;color: #fff !important;">Unit Management</a>-->

        

                                                </div>
                               
                                            

                                            
                                            
                                       </div>
                          
                         
                                    </div>
<div class="containerr p-2">
    <div class="table-boxes">
<div class="table-responsive">
    <div>
        
         
             @php $i=1; @endphp
                
                
                
         <!-- New Structure -->
         <div class="corporateManageBx">
                                           @foreach($users as $userss)
            
            
                <div class="corporManagHead"> 
                           <ul>
                  <li>
                     <label>Unit Name:</label>
                     <span>{{$userss->login_id ?? ''}} <a data-bs-toggle="modal" data-bs-target="#editcompanydetails{{$userss->id}}"> <i class="font-20 bx bxs-edit"></i></a></span>
                  </li>

                  <li>
                     <label>Contact Person Name:</label>
                     <span>{{$userss->name ?? ''}}</span>
                  </li>

                  <li>
                     <label>Designation:</label>
                     <span>{{$userss->designation ?? ''}}</span>
                  </li>

                  <li>
                     <label>Email:</label>
                     <span>{{$userss->email ?? ''}}</span>
                  </li>

                  <li>
                     <label>Company Number:</label>
                     <span>{{$userss->mobile_number ?? ''}}</span>
                  </li>
               </ul>
            </div>
            <div class="tableHeadTitle">
               <p>{{$userss->Company_address ?? ''}}</p>
               </div>
               
    <table>

        <tbody>
            
  
                        
                               
                                    
                                    <tr>


             <div class="fssaiBx">
    <div class="fssaiListing">
        <h2>FSSAI License</h2>
        <div class="fssaicntbx">
        <ul>
            <li>( @if(Helper::lastDocuments($userss->id))
                <p><strong>Uploaded</strong></p>
                            <p><strong class="text-red"><a href="{{route('allUnitHistory',[$userss->id,'unit'])}}">History</a></strong></p>
            @else
                <p><strong>Not uploaded:<a href="{{route('unitHistory',[$userss->id,'unit'])}}">1</a></strong></p>
            @endif )</li>
            <li><strong>Valid:</strong> <span><a href="{{route('getDocuments',[$userss->id,'Central','Unit'])}}">{{ Helper::getDocuments($userss->id, 'Central', 'Unit','License') }} View</a></span> ( About to expried:<span><a href="{{route('getexpDocuments',[$userss->id,'Central','1','Unit'])}}">{{Helper::getexpDocuments($userss->id,"Central","1","Unit","License")}} View</a></span> )</li>
            <li><strong>Expired:</strong> <span> <a href="{{route('getexpDocuments',[$userss->id,'Central','2','Unit'])}}">{{Helper::getexpDocuments($userss->id,"Central","2","Unit","License")}} View</a></span></li>
        </ul>
        <div class="iconbx">
        <i class='bx bxs-id-card'></i>
        </div>
        </div>

    </div>


    <div class="fssaiListing hraListing">
        


        <h2>HRA</h2>
        <div class="fssaicntbx">
        <ul>
            <li><strong>Total Unit:</strong> <span><a href="{{route('getallDocuments',[$userss->id,'All','unit'])}}?document_type=HRA">{{ Helper::getexpDocuments($userss->id,"Central","2","unit","HRA")  +  Helper::getDocuments($userss->id, 'Central', 'unit','HRA') }}</a></span> ( Uploaded:<span>0</span>, Not Uploaded:<span><a href="{{ route('units', [$userss->id, '1', 'pending']) }}?document_type=HRA">
        {{ Helper::units($userss->id, '1', 'pending','HRA') }} View
    </a></span> )</li>
            <li><strong>Valid:</strong> <span> <a href="{{ route('getDocuments', [$userss->id, 'Central', 'unit']) }}?document_type=HRA">
        {{ Helper::getDocuments($userss->id, 'Central', 'unit','HRA') }}
    </a></span>Near Expiry:<span> <a href="{{ route('getexpDocuments', [$userss->id, 'Central', '1', 'unit']) }}?document_type=HRA">
        {{ Helper::getexpDocuments($userss->id, 'Central', '1', 'unit','HRA') }}
    </a></span>, NA:<span><a href="{{route('getallDocuments',[$userss->id,'NA','Corporate'])}}?document_type=HRA">{{ Helper::totalDocuments($userss->id, 'NA', 'unit','HRA') }}</a></span></li>
            <li><strong>Expired:</strong> <span><a href="{{ route('getexpDocuments', [$userss->id, 'Central', '2', 'unit']) }}?document_type=HRA">
        {{ Helper::getexpDocuments($userss->id, 'Central', '2', 'unit','HRA') }}
    </a></span></li>
        </ul>
        <div class="iconbx">
        <i class='bx bxs-id-card'></i>
        </div>
        </div>
        <div class="historyLink">
            <a href="#">History</a>
        </div>
    </div>



    <div class="fssaiListing tpaListing">
        <h2>TPA</h2>


        <div class="fssaicntbx">
            <ul>
                <li><strong>Total Unit:</strong> <span><a href="{{route('getallDocuments',[$userss->id,'All','unit'])}}?document_type=TPA">{{ Helper::getexpDocuments($userss->id,"Central","2","unit","TPA")  +  Helper::getDocuments($userss->id, 'Central', 'unit','TPA') }}</a></span> ( Uploaded:<span>0</span>, Not Uploaded:<span><a href="{{ route('units', [$userss->id, '1', 'pending']) }}?document_type=TPA">
        {{ Helper::units($userss->id, '1', 'pending','TPA') }} View
    </a></span> )</li>
                <li><strong>Valid:</strong>  <a href="{{ route('getDocuments', [$userss->id, 'Central', 'unit']) }}?document_type=TPA">
        {{ Helper::getDocuments($userss->id, 'Central', 'unit','TPA') }}
    </a>   ( Near Expiry:<span>   <a href="{{ route('getexpDocuments', [$userss->id, 'Central', '1', 'unit']) }}?document_type=TPA">
        {{ Helper::getexpDocuments($userss->id, 'Central', '1', 'unit','TPA') }}
    </a></span>, NA: <span><a href="{{route('getallDocuments',[$userss->id,'NA','Corporate'])}}?document_type=TPA">{{ Helper::totalDocuments($userss->id, 'NA', 'unit','TPA') }}</a></span></li>
                <li><strong>Expired:</strong> <span><a href="{{ route('getexpDocuments', [$userss->id, 'Central', '2', 'unit']) }}?document_type=TPA">
        {{ Helper::getexpDocuments($userss->id, 'Central', '2', 'unit','TPA') }}
    </a></span></li>
            </ul>
            <div class="iconbx">
                <i class='bx bxs-id-card'></i>
            </div>
        </div>
        <div class="historyLink">
            <a href="{{route('allUnitHistory',[$userss->id,'unit'])}}?document_type=TPA">History</a>
        </div>
    </div>


    <div class="fssaiListing fostacListing">
        <h2>FoSTaC</h2>
        <div class="fssaicntbx">
            
                       @php 
    $totalEmploye = Helper::totalcorporateregionalunitfostag($userss->id); // Missing semicolon here
    
    $totalEmployeDocuments = Helper::getFoSTaCDocuments($userss->id, '1', 'unit');
    $getFoSTaCExpiredDocuments = Helper::getFoSTaCExpiredDocuments($userss->id, '4', 'unit');
    $getFoSTaCNearDocuments = Helper::getFoSTaCNearDocuments($userss->id, '3', 'unit');
    $getFoSTaCValidDocuments = Helper::getFoSTaCValidDocuments($userss->id, '1', 'unit');
        $getFoSTaCValidDocuments = Helper::getFoSTaCValidDocuments($userss->id, '1', 'unit');
        
@endphp

       
            <ul>
                <li><strong>Total Unit:</strong> <span>33</span> ( Compliance: <span> <a href="{{ route('unitsFoSTaC', [$userss->id, '1', 'pending', 'unit']) }}?document_type=FoSTaC&Compliance=Compliance">
        {{ Helper::unitsFoSTaC($userss->id, '1') }}
    </a></span>, Not Compliance :<span> <a href="{{ route('unitsFoSTaC', [$userss->id, '1', 'pending', 'unit']) }}?document_type=FoSTaC&Compliance=NotCompliance">
        {{ Helper::unitsFoSTaC($userss->id, '2') }}
    </a></span>)</li>
                <li><strong>Food Handlers Count:</strong> <span>{{$totalEmploye}}</span>: Certificate Required:@if($totalEmploye > 0) {{$totalEmploye/25}} @else 0 @endif</li>
                <li><strong>Total Certificate:</strong> <span><a href="{{route('getFoSTaCDocuments',[$userss->id,1,'Corporate'])}}">{{$totalEmployeDocuments ?? 0}}</a></span> (Valid: <span><a href="{{route('getFoSTaCDocuments',[$userss->id,2,'unit'])}}">
         {{$getFoSTaCValidDocuments ?? 0}}
    </a> </span> ( Near Expiry:<span><a href="{{route('getFoSTaCDocuments',[$userss->id,3,'unit'])}}">
        {{$getFoSTaCNearDocuments ?? 0}}
    </a></span> )</li>
                <li><strong>Expired:</strong> <span><a href="">
                    {{$getFoSTaCExpiredDocuments ?? 0}}
                    </a></span></li>
            </ul>
            <div class="iconbx">
                <i class='bx bxs-id-card'></i>
            </div>
        </div>
        
    </div>


    <div class="fssaiListing testingListing">
        <h2>Testing</h2>
        <div class="fssaicntbx">
            <ul>
                <li><strong>Food Report:</strong> (Compliance:<span>0</span>, Not Compliance: <span>0</span>)</li>
                <li><strong>Water Report:</strong> (Compliance: <span>0</span>, Not Compliance: <span>0</span>)</li>
                <li><strong>Hand Swab(Compliance:</strong> <span>0</span>, Not Compliance: <span>0</span>)</li>
                <li><strong>Environment:</strong> (Compliance: 0, Not Compliance :0)</li>
                <li><strong>Expired:</strong> <span>0</span></li>
            </ul>
            <div class="iconbx">
                <i class='bx bxs-id-card'></i>
            </div>
        </div>
       
    </div>

    <div class="fssaiListing medicalListing">
        <h2>Medical Fitness</h2>
        <div class="fssaicntbx">
            <ul>
                <li><strong>Total Unit:</strong> <span>33</span> (Compliance: <span>0</span>, Not Compliance: <span>0</span>)</li>
                <li><strong>Food Handlers Count:</strong> <span>33</span></li>
                <li><strong>Total Certificate:</strong> <span>88</span> (Valid: <span>88</span> ( Near Expiry: <span>0</span>)</li>
                <li><strong>Expired:</strong> <span>0</span></li>
            </ul>
            <div class="iconbx">
                <i class='bx bxs-id-card'></i>
            </div>
        </div>
       
    </div>

    <div class="fssaiListing calibrationgListing">
        <h2>Calibration</h2>
        <div class="fssaicntbx">
            <ul>
                <li><strong>Total Unit:</strong> <span>33</span> (Compliance: <span>0</span>, Not Compliance: <span>0</span>)</li>
                <li><strong>Total Equipment:</strong> <span>33</span> Certificate Required:</li>
                <li><strong>Total Certificate:</strong> <span>88</span> (Valid: <span>88</span> ( Near Expiry: <span>0</span>)</li>
                <li><strong>Expired:</strong> <span>0</span></li>
            </ul>
            <div class="iconbx">
                <i class='bx bxs-id-card'></i>
            </div>
    </div>
    
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4" style="    width: 100%;">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Orders</p>
                                    <h4 class="my-1 text-info">4805</h4>
                                    <p class="mb-0 font-13">+2.5% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-cart'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Revenue</p>
                                    <h4 class="my-1 text-danger">$84,245</h4>
                                    <p class="mb-0 font-13">+5.4% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-wallet'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Bounce Rate</p>
                                    <h4 class="my-1 text-success">34.6%</h4>
                                    <p class="mb-0 font-13">-4.5% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Customers</p>
                                    <h4 class="my-1 text-warning">8.4K</h4>
                                    <p class="mb-0 font-13">+8.4% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            <div class="row" style="    width: 100%;">
                <div class="col-12 col-lg-8">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Sales Overview</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Sales</span>
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Visits</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">24.15M</h5>
                                    <small class="mb-0">Overall Visitor <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">12:38</h5>
                                    <small class="mb-0">Visitor Duration <span> <i class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">639.82</h5>
                                    <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Trending Products</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-container-2 mt-4">
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Jeans <span class="badge bg-success rounded-pill">25</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">T-Shirts <span class="badge bg-danger rounded-pill">10</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Shoes <span class="badge bg-primary rounded-pill">65</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--end row-->


           <div class="row row-cols-1 row-cols-lg-3" style="    width: 100%;">
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <p class="font-weight-bold mb-1 text-secondary">Weekly Revenue</p>
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <h4 class="mb-0">$89,540</h4>
                                </div>
                                <div class="">
                                    <p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i class="bx bxs-up-arrow-alt mr-2"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="chart-container-0">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Orders Summary</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1">
                                <canvas id="chart4"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Top Selling Categories</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-0">
                                <canvas id="chart5"></canvas>
                            </div>
                        </div>
                        <div class="row row-group border-top g-0">
                            <div class="col">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-danger">$45,216</h4>
                                    <p class="mb-0">Clothing</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-success">$68,154</h4>
                                    <p class="mb-0">Electronic</p>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
            </div><!--end row-->
            
  
    
                           
                                       
                          
                                    
                                </tbody>
                            </table>
                   
                        
                        </tr>
          
</div>

       @endforeach
       
                        <div class="mt-3 col-12 pagination" style="text-align: center;">

                                                        {{ $users->appends(request()->query())->links() }}


</div> 
</div>
</div>
</div>
</div>

                      <div class="modal fade" id="addunitdetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">

<input type="hidden" name="is_role" value="2">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Corporate ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Person Name:</label>
                            <input type="text" class="form-control"  name="Contact_Person_Name" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Full Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>

                              <div class="mb-12 col-md-12">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
                      <div class="modal fade" id="addcompanydetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add  Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                         <form></form>
                        <form method="post" action="{{route('add_users')}}">
                            @csrf
                    <div class="row">

<input type="hidden" name="is_role" value="2">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Corporate ID:</label>
                            <input type="text" class="form-control"  name="login_id" placeholder="">
                            @if($errors->has('login_id'))
    <div class="error">{{ $errors->first('login_id') }}</div>
@endif
                        </div>

                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Name:</label>
                            <input type="text" class="form-control"  name="company_name" placeholder="">
                            @if($errors->has('company_name'))
    <div class="error">{{ $errors->first('company_name') }}</div>
@endif
                        </div>


                               <div class="mb-3 col-md-6">
                            <label class="form-label">Company Address
:</label>
                            <input type="text" class="form-control"  name="Company_address" placeholder="">
                            @if($errors->has('Company_address'))
    <div class="error">{{ $errors->first('Company_address') }}</div>
@endif
                        </div>

                   

                   

                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Contact Person Name </label>
                            <input type="text" name="name" class="form-control" placeholder="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif

                        </div>
						
						            <div class="mb-3 col-md-6">
                            <label class="form-label">Designation:</label>
                            <input type="text" class="form-control"  name="designation" placeholder="">
                            @if($errors->has('designation'))
    <div class="error">{{ $errors->first('designation') }}</div>
@endif
                        </div>
         <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Mobile Number </label>
                            <input type="text" name="mobile_number" class="form-control" placeholder="">
                            @if($errors->has('mobile_number'))
    <div class="error">{{ $errors->first('mobile_number') }}</div>
@endif
                        </div>
                              <div class="mb-3 col-md-6">
                            <label class="form-label">Enter Email </label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            @if($errors->has('email'))
    <div class="error">{{ $errors->first('email') }}</div>
@endif
                        </div>

                     

                              <div class="mb-6 col-md-6">
                            <label class="form-label">Enter Password </label>
                            <input type="text" name="password" class="form-control" placeholder="">
                            @if($errors->has('password'))
    <div class="error">{{ $errors->first('password') }}</div>
@endif
                        </div>
               
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Add  Details</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
                                    
                                </div>
                                
                            </div>
                        </div>
       
                        
                    </div>




@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
    $(function(){
  $('.header-level').click(function(){
    $(this).next('.sub-level').find('table').toggle();
  });
});
</script>

<script>
    function collapse(cell){
  var row = cell.parentElement;
  var target_row = row.parentElement.children[row.rowIndex + 1];
  if (target_row.style.display == 'table-row') {
    cell.innerHTML = '+';
    target_row.style.display = 'none';
  } else {
    cell.innerHTML = '-';
    target_row.style.display = 'table-row';
  }
}
</script>
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





   