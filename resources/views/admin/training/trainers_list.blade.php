@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
@section('content')
<style>	
	th {
        font-size: 14px !important;
    }
        
        td {
        padding: 8px 10px;
        font-size: 14px;
    }
        div#example_length {
        margin: 20px 0px;
    }
        
        
        div#example_filter {
        display: none;
    }
    table.dataTable.no-footer {
        border-bottom: 1px solid #ddd;
        border-top: 1px solid #ddd;
    }
        div#example_paginate {
        background: #17a00e;
        margin: 10px 0px;
        color: #fff;
        padding: 5px 0px;
    }
        
        div#example_paginate a {
        color: #fff !important;
    }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #333 !important;
        border: 1px solid #979797;
        background-color: white;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, white), color-stop(100%, #dcdcdc));
        background: -webkit-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: -moz-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: -ms-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: -o-linear-gradient(top, white 0%, #dcdcdc 100%);
        background: #d10b1e !important;
        border: 0px !important;
    }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: white !important;
        border: 0px;
        background-color: #585858;
        background: red;
        background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
        background: -moz-linear-gradient(top, #585858 0%, #111 100%);
        background: -ms-linear-gradient(top, #585858 0%, #111 100%);
        background: -o-linear-gradient(top, #585858 0%, #111 100%);
        background: #d10b1e !important;
    }
        
        .table>:not(:last-child)>:last-child>* {
        border-bottom-color: transparent;
    }
        a.back {
        text-align: right;
        float: right;
        padding: 13px 30px;
        background: #17a00e;
        margin-bottom: 20px;
        border-radius: 6px;
        color: #fff;
    }

    a.active {
        color: #fff !important;
        text-decoration: none;
        background: #0d6efd;
    }
    .input-switch {
        display: none;
    }

    .label-switch {
        display: inline-block;
        position: relative;
    }

    .label-switch::before,
    .label-switch::after {
        content: "";
        display: inline-block;
        cursor: pointer;
        transition: all 0.5s;
    }

    .label-switch::before {
        width: 3em;
        height: 1em;
        border: 1px solid #b90731;
        border-radius: 4em;
        background: #e0525d;
    }

    .label-switch::after {
        position: absolute;
        left: 0;
        top: -3px;
        width: 1.5em;
        height: 1.5em;
        border: 1px solid #b90731;
        border-radius: 4em;
        background: #e0525d;
    }

    .input-switch:checked~.label-switch::before {
        background: #00a900;
        border-color: #008e00;
    }

    .input-switch:checked~.label-switch::after {
        left: unset;
        right: 0;
        background: #00ce00;
        border-color: #009a00;
    }

    .info-text {
        display: inline-block;
    }

    .info-text::before {
        content: "Inactive";
    }

    .input-switch:checked~.info-text::before {
        content: "Active";
    }

    .f-child tr th:first-child {
        width: 20px !important;
    }
    
    
    img, svg {
    vertical-align: middle;
    width: 20px;
}
.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
.pagination {

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

</style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @include('admin.training.training_navbar')
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="training-types" role="tabpanel">
                            <div class="row row-cols-auto g-3 mb-3">
                                <div class="col-12">
                                    <div class="col-12 align-self-center">
                                        <form method="get" action="{{route('trainers_data_index')}}">
                                            <div class="row row-cols-auto g-1 mb-3">
                                                <div class="col-2">
                                                    <input type="text" class="form-control" name="search" value="{{Request::get('search')}}" placeholder="Search And Add Trainer">
                                                </div>
                                                <div class="col-10">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                    <?php if(count($unit_users_list)>0){ ?>
                                                        <a href="javascript:void(0);" class="btn btn-primary addtrainers" onclick="return confirm('Are you sure you want to add this item?');">Add Selected</a>
                                                    <?php } ?>                                                 
                                                    <a href="javascript:void(0);" class="btn btn-danger deletetrainers" onclick="return confirm('Are you sure you want to delete this item?');">Delete Selected</a>
                                                </div>
                                            </div>
                                        <form>
                                        <?php if(!empty($unit_users_list)){ ?>
                                        <div class="table-responsive table-refresh">
                                            <table id="example" class="table table-striped table-bordered data-t f-child example"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th width="30"><input type="checkbox" class="checkboxclickusermanagment"></th>
                                                        <th class="text-left">#</th>
                                                        <th>Employee ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Gender</th>
                                                        <th>Email</th>
                                                        <th>Contact Number</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php $i=1; @endphp
                                                @forelse($unit_users_list as $unit_user)
                                                    <tr>
                                                        <td><input class="checkboxvalueusermanagment" type="checkbox" value="{{ $unit_user->employe_id }}"></td>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $unit_user->employe_id }}</td>
                                                        <td>{{ $unit_user->employer_fullname }}</td>
                                                        <td>{{ $unit_user->gender ?? '' }}</td>
                                                        <td>{{ $unit_user->email ?? '' }}</td>
                                                        <td>{{ $unit_user->contact_number }}</td>
                                                        <td>
                                                            @if($unit_user->status==1)
                                                            <span class="badge badge-success" style="background-color: green">Active</span>
                                                            @else
                                                            <span class="badge badge-danger" style="background-color: red">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{-- <a class="btn btn-primary btn-sm">Add</a> --}}
                                                            <a style="color: #008cff;" class="addtrainersplus" href="javascript:void(0);" 
                                                                onclick="return confirm('Are you sure you want to add this item?');" data-id="{{$unit_user->employe_id}}">
                                                                <i class="font-20 bx bxs-plus-circle"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php $i++;@endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">No Data Found</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <?php if(!empty($unit_users_list)){ ?>
                                            {!! $unit_users_list->withQueryString()->links('pagination::bootstrap-5') !!}
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="col-12 align-self-center">
                                        <h5>Trainers List</h5>
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped table-bordered data-t f-child"
                                                style="width:100%;display:none">
                                                <thead>
                                                    <tr>
                                                        <th width="30"><input type="checkbox" class="checkboxclickusermanagmentdelete"></th>
                                                        <th class="text-left">#</th>
                                                        <th>Employee ID  dsfs</th>
                                                        <th>Employee Name</th>
                                                        <th>Gender</th>
                                                        <th>Email</th>
                                                        <th>Contact Number</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                  
                                                @php $i=1; @endphp
                                                @forelse($trainers_list_datas as $trainers_list_datalist)
                                                
                                                @php  $trainers_list_data = DB::table('unit_users')->where('employe_id', $trainers_list_datalist->employe_id)->first()@endphp 
                                                    <tr>
                                                        <td><input class="checkboxvalueusermanagmentdelete" type="checkbox" value="{{ $trainers_list_datalist->id }}"></td>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $trainers_list_data->employe_id ?? '' }}</td>
                                                        <td>{{ $trainers_list_data->employer_fullname ?? '' }}</td>
                                                        <td>{{ $trainers_list_data->gender ?? '' }}</td>
                                                        <td>{{ $trainers_list_data->email ?? '' }}</td>
                                                        <td>{{ $trainers_list_data->contact_number ?? '' }}</td>
                                                        <td>
                                                            @if($trainers_list_data->status==1)
                                                            <span class="badge badge-success" style="background-color: green">Active</span>
                                                            @else
                                                            <span class="badge badge-danger" style="background-color: red">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a style="color: #FF0000;" href="{{ route('trainers_data_delete', $trainers_list_datalist->id) }}"
                                                                onclick="return confirm('Are you sure you want to delete this item?');">
                                                                <i class="font-20 bx bxs-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @php $i++;@endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">No Data Found</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <!--{!! $trainers_list_datas->withQueryString()->links('pagination::bootstrap-5') !!}-->
                                        </div>
                                        
                                        <div id="table-scroll" class="table-scroll">
  <table id="main-table" class="main-table  ">
    <thead>
      <tr>
        <th scope="col" style="text-align: center; margin: 30px !important;padding: 9px;vertical-align: middle;">Employee Details</th>
                        
              <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;"><strong>Unit Name</strong>
              <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;"><strong>Track Record</strong>
              <th style="text-align: center; margin: 30px !important;vertical-align: middle;padding: 9px !important;"><strong>Action</strong>
                                                                                         
      </th></tr>
    </thead>
    <tbody>

  @php $i=1; @endphp
                                                @forelse($trainers_list_datas as $trainers_list_datalist)
                                                
                                                @php  $trainers_list_data = DB::table('unit_users')->where('employe_id', $trainers_list_datalist->employe_id)->first()@endphp 
                    <tr><th style="min-width: 380px !important;text-align: center;padding: 16px;">
                    
                    
                    <strong
                                                                                    class="empName">{{ $trainers_list_data->employer_fullname }}</strong>
                                                                       
                    
                       <span class="departmentbg"
                                                                                    title="Department">
                                                                                    @php
                                                                                        $department_name = DB::table('departments')->where('id', $trainers_list_data->department)->first();
                                                                                    @endphp
                                                                                    {{ $department_name->name ?? '' }}
                                                                                </span>
                    
                    
                    
                      <span
                                                                                    class="assimanagerbg">{{ $trainers_list_data->designation ?? '' }}</span>                    
                    <br>
                    
                                 <span class="assimanagerbg"
                                                                                    title="Date of joining">{{ $trainers_list_data->dog }}</span>
                   <span
                                                                                    class="departmentbg">{{ $trainers_list_data->employe_id ?? '' }}</span>
                                                                                             
                    
                    <br>
                    

                    @if($trainers_list_data->status==1)
                    <span class="badge badge-success" style="background-color: green">Active</span>
                    @else
                    <span class="badge badge-danger" style="background-color: red">Inactive</span>
                    @endif                                                                                                              
                    
                    </th>
                    
                             <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                    
                               
                               
                               @if(!empty(Session::get('unit_id')))  
                               
                                <strong
                        class="empName">{{Helper::user_info(Session::get('unit_id'))->company_name ?? ''}}</strong>
                        
                        <span class="departmentbg">{{Helper::user_info(Session::get('unit_id'))->Company_address ?? ''}}
                        </span>
                               @else
                                <strong
                        class="empName">{{Helper::user_info($trainers_list_data->created_by)->company_name ?? ''}}</strong>
                        
                        <span class="departmentbg">{{Helper::user_info($trainers_list_data->created_by)->Company_address ?? ''}}
                        </span>
                               @endif
                        
                    

                    </td>
                    <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                    
                    @php $Details = Helper::trainerDetails($trainers_list_data->employer_fullname ) @endphp
         
                <p><strong>Time:{{$Details['time'];}}</strong></p>
                <p><strong>{{$Details['total_hours'];}}</strong></p>
                <p><strong>Total Employee Trained:{{$Details['total_enroll'];}}</strong></p>
                    
                    </td>
                    
             
                    
                    <td style="min-width: 300px !important;text-align: center;padding: 22px;">
                    
                    
                <a style="color: #FF0000;" href="{{ route('trainers_data_delete', $trainers_list_datalist->id) }}"
                                                                onclick="return confirm('Are you sure you want to delete this item?');">
                                                                <i class="font-20 bx bxs-trash"></i>
                                                            </a>
                    
                    </td>
                    
                    
                    
                    
                    </tr>
                    
                    @php $i++;@endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">No Data Found</td>
                                                    </tr>
                                                    @endforelse
      
                                  
    </tbody>

  </table>
  
     

                   <div class="mt-3 col-12 pagination" style="text-align: center;">
                     {!! $trainers_list_datas->withQueryString()->links('pagination::bootstrap-5') !!}

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
        </div>
        <!--end row-->
    </div>
@endsection
@section('footerscript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>

    <script>
    var yourArray = [];
    var yourArray2 = [];
    $('.checkboxclickusermanagment').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".checkboxvalueusermanagment").prop('checked', true);
            yourArray = [];
            $(".checkboxvalueusermanagment:checked").each(function(){
                yourArray.push($(this).val());                
            });
        } else {
            $(".checkboxvalueusermanagment").prop('checked', false);
            yourArray = [];
        }
    });
    $( ".checkboxvalueusermanagment" ).each(function(index) {
        $(this).on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(this).prop('checked', true);
                yourArray.push($(this).val());   
            } else {
                $(this).prop('checked', false);
                yourArray = yourArray.filter(e => e !== $(this).val());
            }
        });
    });
    $( ".addtrainersplus" ).each(function(index) { 
        $(this).on('click', function(e) {
            yourArray.push($(this).data('id')); 
            $.ajax
            ({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ route('trainers_add') }}",
                data : {'ids' : yourArray},
                type : 'POST',
                dataType : 'json',
                success: function(result)
                {
                    location.replace('{{route("trainers_data_index")}}');
                }
            });
        });
    });
    $( ".addtrainers" ).on( "click", function() {
        console.log(yourArray);
        $.ajax
        ({ 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{ route('trainers_add') }}",
            data : {'ids' : yourArray},
            type : 'POST',
            dataType : 'json',
            success: function(result)
            {
                location.replace('{{route("trainers_data_index")}}');
                console.log(result); return false;
            }
        });
    });

    $('.checkboxclickusermanagmentdelete').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".checkboxvalueusermanagmentdelete").prop('checked', true);
            yourArray2 = [];
            $(".checkboxvalueusermanagmentdelete:checked").each(function(){
                yourArray2.push($(this).val());                
            });
        } else {
            $(".checkboxvalueusermanagmentdelete").prop('checked', false);
            yourArray2 = [];
        }
    });
    $( ".checkboxvalueusermanagmentdelete" ).each(function(index) {
        $(this).on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(this).prop('checked', true);
                yourArray2.push($(this).val());   
            } else {
                $(this).prop('checked', false);
                yourArray2 = yourArray2.filter(e => e !== $(this).val());
            }
        });
    });
    $( ".deletetrainers" ).on( "click", function() {
        console.log(yourArray2);
        $.ajax
        ({ 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{ route('trainers_delete') }}",
            data : {'ids' : yourArray2},
            type : 'POST',
            dataType : 'json',
            success: function(result)
            {
                location.replace('{{url()->full()}}');
                console.log(result); return false;
            }
        });
    });

    $( ".reserve-button" ).each(function(index) {
        $(this).on("click", function(){
            if($(this).val()=='1'){
                $(this).val('0');
            } else {
                $(this).val('1');
            }
            var training_status_id = $(this).data('id');
            var training_status_update = $(this).val();
            $.ajax
            ({ 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : "{{ route('training_status_update') }}",
                data : {'id' : training_status_id, 'status' : training_status_update},
                type : 'POST',
                dataType : 'json',
                success: function(result)
                {
                    console.log(result); return false;
                }
            });
        });
    });
    </script>
@endsection
