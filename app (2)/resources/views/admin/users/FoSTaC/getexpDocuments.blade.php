@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<style type="text/css">
   	button.dt-button.buttons-excel.buttons-html5 {
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    letter-spacing: 0.5px;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid #000;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
	
	.dt-buttons {
    text-align: right;
}

    .error {
    color: red;
    margin: 10px 0px;
}
	

	
		div#pm-schedule-maker_table_length {
    margin: 20px 0px;
}
	
	

table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
}
	div#pm-schedule-maker_table_paginate {
    background: #17a00e;
    margin: 10px 0px;
    color: #fff;
    padding: 5px 0px;
}
	
	div#pm-schedule-maker_table_paginate a {
    color: #fff !important;
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
  /*height: 350px;*/
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
  vertical-align: middle;
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
  position: sticky !import;
  left: 0;
  z-index: 2;
  background: #ccc;
}
thead th:first-child,
tfoot th:first-child {
  z-index: 5;
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
  vertical-align: middle;
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


#accordionFlushExample {
    display: none; /* Use fixed to make sure it's always in view */
}

#accordionFlushExample1 {
    display: none; /* Use fixed to make sure it's always in view */
}
#accordionFlushExample2 {
    display: none; /* Use fixed to make sure it's always in view */
}

button.btn.btn-primary.addmore {
    display: none;
}



@keyframes spin {
    to {
        transform: rotate(360deg); /* Rotate 360 degrees */
    }
}

.red {
    background-color: #e9bbbb57 !important;
}

.yellow {
    background-color:#ffeb3b14 !important;
}
</style>
@section('content')
   
                  <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
           
                                    <div class="tab-content">
                                        <div id="table-scroll" class="table-scroll">
       
  <table id="main-table" class="main-table  ">
                                                <thead>
                                                    <tr style="background: #426fc2;color: #fff;height: 55px;text-align: center;">
                                                    <!--<th width="30">SI No.</th>-->
													     <th>Employee Details</th>
													       <th>Certificate Number </th>
													   <th>Next Due Date</th>
													   <th>Uploaded Date</th>
													   <th>Action</th>

                                                  </tr>
                                                </thead>
                                                <tbody>

                                                    
@php $i=1; @endphp
                                                    @foreach($list as $lists)
                                                    
                                                    @php $userss = Helper::employeeDetails($lists->employee_id); @endphp
                                                 <tr style="text-align: center;" class="{{ $lists->rowClass }}">
                                                    <!--<td>{{$i}}</td>-->
        <th style="background: #ccc;text-align: center;padding: 17px;width: 330px;z-index: 99999999;" class="{{ $lists->rowClass }}">
<strong
    class="empName">{{ $userss->employer_fullname ?? '' }}</strong>                                                                              
    <span
    class="assimanagerbg">{{ $userss->employe_id ?? '' }}</span>
    
    <span
    class="assimanagerbg">{{ $userss->designation ?? '' }}</span>
    
    <br>
    

    
    
    <span class="assimanagerbg"
    title="Date of joining">{{ $userss->cat_name ?? '' }}</span>
        </th>
                <td class="{{ $lists->rowClass }}">{{$lists->lincess_number ?? ''}}</td>
        <td class="{{ $lists->rowClass }}">{{$lists->due_date ?? ''}}</td>
        <td class="{{ $lists->rowClass }}">{{$lists->created_at ?? ''}}</td>
        <td class="{{ $lists->rowClass }}">
            
            @if($user_type=="Corporate")
            
            
            {{$documentStatus}}
                 
                                                    @if(!empty($documentStatus))
                                                    
                                                    <a  href="{{route('uploadFoSTaC',[$id,'unit'])}}?documentStatus={{ $lists->rowClass }}&&employee_id={{$lists->employee_id}}">Update Information</a>
                                                                                   <br>
                            <a  href="{{route('allFoSTaCHistory',[$id,'Corporate',$lists->employee_id])}}?document_type={{$documentStatus}}" >History</a>
                                                    
                                                    @else
                                                    
                                                    <a  href="{{route('uploadFoSTaC',[$id,'unit'])}}?documentStatus={{ $lists->rowClass }}&&employee_id={{$lists->employee_id}}">Update Information</a>
                                                                            <br>
                          <a  href="{{route('allFoSTaCHistory',[$id,'Corporate',$lists->employee_id])}}?document_type={{$documentStatus}}" >History</a>
                                                    @endif
                                                    
                                                    

             <br>
            @endif
            
                @if($user_type=="regional")
                
                
                
                                                    @if(!empty($documentStatus))
                                                    
                                                    <a  href="{{route('uploadFoSTaC',[$id,'regional'])}}?documentStatus={{ $lists->rowClass }}&&employee_id={{$lists->employee_id}}">Update Information</a>
                                                                                   <br>
                                                 <a  href="{{route('allFoSTaCHistory',[$id,'Corporate',$lists->employee_id])}}?document_type={{$documentStatus}}" >History</a>
                                                    
                                                    @else
                                                    
                                                 <a  href="{{route('uploadFoSTaC',[$id,'regional'])}}?documentStatus={{ $lists->rowClass }}&&employee_id={{$lists->employee_id}}" >Update Information</a>
                                                                              <br>
                          <a  href="{{route('allFoSTaCHistory',[$id,'Corporate',$lists->employee_id])}}?document_type={{$documentStatus}}" >History</a>
                                                    @endif
                                                    
                                                    
       

             <br>
            @endif
            
                @if($user_type=="Unit")
                
                 @if(!empty($documentStatus))
                                                    
                                                    <a  href="{{route('uploadFoSTaC',[$userss->id,'regional'])}}?documentStatus={{ $lists->rowClass }}&&employee_id={{$lists->employee_id}}">Update Information</a>
                                                                                   <br>
                                                    <a  href="{{route('allFoSTaCHistory',[$id,'Corporate',$lists->employee_id])}}?document_type={{$documentStatus}}" >History</a>
                                                    
                                                    @else
                                                    
                                 <a  href="{{route('uploadFoSTaC',[$lists->unit_id,'unit'])}}?documentStatus={{ $lists->rowClass }}&&employee_id={{$lists->employee_id}}" >Update Information</a>
                                                              <br>
                          <a  href="{{route('allFoSTaCHistory',[$id,'Corporate',$lists->employee_id])}}?document_type={{$documentStatus}}" >History</a>
                                                    @endif
                                                    
                                                    
         

             <br>
            @endif
            
            
            

            <a target="_blank()" href="{{asset('documents')}}/{{$lists->image ?? ''}}">View</a>
</td>
						
						

                     
                                                  </tr>
@php $i++; @endphp
                                                  @endforeach
                                        
                                                  
                                                </tbody>
                                              </table>
                                        </div>
                              
                                                
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

<script>
    $(document).ready(function(){
  $('.show-details').click(function(){
    console.log($(this).find('.fa.fa-angle-down'));
    $(this).find('i')
           .toggleClass('fa-angle-down fa-angle-up');
    
    $(this).siblings('.details')
           .toggleClass('open')
           .slideToggle('milliseconds');
   });
});

</script>



   