@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
@section('content')
<style>	

</style>
    <div class="row">
        <div class="col">
            <div class="card">
            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="align-self-center mb-0">Training</h5>
                                    <button class="printbtn"><i class="fa fa-print" aria-hidden="true"></i></button>
                                </div>
                                <hr>
                                
                                <div class="table-responsive Hscrolldesign">
                                    <table class="trainingcardTable">
                                        <thead>
                                            <tr>
                                                <th colspan="5">{{$unit_users_list->employer_fullname ?? ''}} Card</th>
                                            </tr>
                                            <tr>
                                                           @php $departments = DB::table('departments')->where('id', $unit_users_list->department)->first() @endphp
                                                <th>Department:{{$departments->name ?? ''}}</th>
                                                <th colspan="2">Designation :{{$unit_users_list->designation ?? ''}}</th>
                                                <th>Id: {{$unit_users_list->employe_id ?? ''}}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>
                                                    <b>DOB:</b> 
                                                    
                                                    @if(!empty($unit_users_list->dob))
                                                    {{$unit_users_list->dob ?? ''}}
                                                    @endif
                                                    
                                                    
                                                </td>

                                                <td colspan="2">
                                                    <b>DOJ:</b>  @if(!empty($unit_users_list->dog))
                                                    {{$unit_users_list->dog ?? ''}}
                                                    @endif
                                                </td>

                                                <td>
                                                    <p><b>Mob:</b> {{$unit_users_list->contact_number ?? ''}}</p>
                                                    <p><b>Email:</b> {{$unit_users_list->email ?? ''}}</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Training Topic</th>
                                                <th>Date &amp; Time</th>
                                                <th>Training Hrs</th>
                                                <th>Trainer Name</th>
                                            </tr>
                                            
                                            @foreach($lms_list as $lms_lists)
                                            
                                         
                                            
                                            @php $lmsDetails = DB::table('tbl_lms')->where('id', $lms_lists->course_id)->first() @endphp
                                       @php $training_types = DB::table('training_types')->where('id', $lmsDetails->course_titles)->first() @endphp

                                            <tr>
                                                <td>{{$training_types->name ?? ''}}
                                                
                                                   @if(!empty($lmsDetails->remark))
                                                                                ({{$lmsDetails->remark ?? ''}})
                                                                                @endif
                                                                                
                                                                                </td>
                                                <td>{{$lmsDetails->start_time ?? ''}} to<br>
                                                                                {{$lmsDetails->end_time ?? ''}}</td>
                                                <td>{{Helper::TotalTimeByTopic($lms_lists->topic_id,$unit_users_list->id)}}</td>
                                                <td>{{$lmsDetails->trainer ?? ''}}
                                                                                
                                                                                @if($lmsDetails->company_name) ({{$lmsDetails->company_name ?? ''}}) @endif
                                                                                
                                                                            </td>
                                            </tr>
                                            @endforeach
                                     
                                        </tbody>
                                    </table>
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
