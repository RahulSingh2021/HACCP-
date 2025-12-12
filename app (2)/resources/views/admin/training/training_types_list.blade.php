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
                                        <div class="row row-cols-auto g-1 mb-3">
                                            <div class="col">
                                                <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnew-training-type">Add Training Type</button>
                                            </div>                                            
                                        </div>
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped table-bordered data-t f-child"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">#</th>
                                                        <th class="text-left">Type</th>
                                                        <th class="text-left">Frequency</th>
                                                        <!--<th class="text-center">Status</th>-->
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @php $i=1; @endphp
                                                @foreach($training_types_list as $training_types)
                                                    <tr>
                                                        <td class="text-left">{{$i}}</td>
                                                        <td class="text-left">{{$training_types->name}}</td>
                                                        <td class="text-left">
                                                            @if( $training_types->frequency == '1' )
                                                                Weekly
                                                            @elseif($training_types->frequency == '2' )
                                                                Fortnightly
                                                            @elseif($training_types->frequency == '3' )
                                                                Monthly
                                                            @elseif($training_types->frequency == '4' )
                                                                Quarterly
                                                            @elseif($training_types->frequency == '5' )
                                                                Yearly
                                                            @elseif($training_types->frequency == '6' )
                                                                Two Years
                                                            @elseif($training_types->frequency == '7' )
                                                                Life Time
                                                            @endif
                                                        </td>
                                                        <!--<td class="text-center">-->
                                                        <!--    <input class='input-switch reserve-button' type="checkbox"  id="demo{{$training_types->id}}" data-id="{{$training_types->id}}" value="{{ $training_types->status }}" @if($training_types->status=='1') checked="on" @endif />-->
                                                        <!--    <label class="label-switch" for="demo{{$training_types->id}}"></label>-->
                                                        <!--    <span class="info-text"></span>-->
                                                        <!--</td>-->
                                                        <td class="text-right">
                                                            
                                                            
                    @php    $is_role=  Auth::user()->is_role;   @endphp
                    <?php 
                    if($is_role==1 || $is_role==3){ ?>
                    
                        @if(!empty(Session::get('unit_id')))
                         @php $login_user = Session::get('unit_id'); @endphp
                        @else
                           @php $login_user = Auth::user()->id;  @endphp
                        @endif
                        
                        @if($login_user == $training_types->unit_id) 
                         <a><i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#edit-training-type{{$training_types->id}}"></i></a>
                    <a href="https://efsm.safefoodmitra.com/admin/public/index.php/trainers/training_data_delete/{{$training_types->id}}"><i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this type?');"></i></a>
                        @endif
                    
                    
                    <?php  }
                    else{ ?>
                    
                    <a><i class="font-20 bx bxs-edit" data-bs-toggle="modal" data-bs-target="#edit-training-type{{$training_types->id}}"></i></a>
                    <a href="https://efsm.safefoodmitra.com/admin/public/index.php/trainers/training_data_delete/{{$training_types->id}}"><i class="font-20 bx bxs-trash" onclick="return confirm('Are you sure you want to delete this type?');"></i></a>
                    
                    <?php  }
                    
                    ?>
            
            
            
                                                           
                                                        </td>
                                                    </tr>
                                                    <!-- Edit Training Modal -->
                                                    <div class="modal fade" id="edit-training-type{{$training_types->id}}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Training Type</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body p-5">
                                                                    <form class="row" action="{{ route('training_data_edit') }}" method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$training_types->id}}" >
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label">Type:</label>
                                                                            <input type="text" name="name" value="{{$training_types->name}}" class="form-control" placeholder="Enter Type" autofocus>
                                                                        </div>
                                                                        <div class="mb-3 col-md-12">
                                                                            <label class="form-label">Add Frequency:</label>
                                                                            <select class="form-control" name="frequency">
                                                                                <option value="">Select Frequency</option>
                                                                                <option value="1" @if( $training_types->frequency == '1' ) selected="selected" @endif >Weekly</option>
                                                                                <option value="2" @if( $training_types->frequency == '2' ) selected="selected" @endif >Fortnightly</option>
                                                                                <option value="3" @if( $training_types->frequency == '3' ) selected="selected" @endif >Monthly</option>
                                                                                <option value="4" @if( $training_types->frequency == '4' ) selected="selected" @endif >Quarterly</option>
                                                                                <option value="5" @if( $training_types->frequency == '5' ) selected="selected" @endif >Yearly</option>
                                                                                <option value="6" @if( $training_types->frequency == '6' ) selected="selected" @endif >Two Years</option>
                                                                                <option value="7" @if( $training_types->frequency == '7' ) selected="selected" @endif >Life Time</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-4 col-md-12">
                                                                            <label class="form-label">Status:</label>
                                                                            <select class="form-control" name="status">
                                                                                <option value="">Select Option</option>
                                                                                <option value="1" @if( $training_types->status == '1' ) selected="selected" @endif >Active</option>
                                                                                <option value="0" @if( $training_types->status == '0' ) selected="selected" @endif >Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-12 text-center">
                                                                            <button type="submit" class="btn btn-primary px-3">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal -->
                                        
                                                    
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
        <!--end row-->
    </div>
    
<!-- Add Training Modal -->
<div class="modal fade" id="addnew-training-type" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Training Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <form class="row" action="{{ route('people_store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Type:</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Type" autofocus>
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Add Frequency:</label>
                        <select class="form-control" name="frequency">
                            <option value="">Select Frequency</option>
                            <option value="1">Weekly</option>
                            <option value="2">Fortnightly</option>
                            <option value="3">Monthly</option>
                            <option value="4">Quarterly</option>
                            <option value="5">Yearly</option>
                            <option value="6">Two Years</option>
                            <option value="7">Life Time</option>
                        </select>
                    </div>
                    <div class="mb-4 col-md-12">
                        <label class="form-label">Status:</label>
                        <select class="form-control" name="status">
                            <option value="">Select Option</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@endsection
@section('footerscript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/19.1.8/js/dx.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/1.7.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>

    <script>
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
