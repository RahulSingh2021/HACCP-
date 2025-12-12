@extends('layouts.app1', ['pagetitle' => 'Dashboard'])
@section('content')

<style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    h1 {
      color: #2a4d69;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
      vertical-align: middle;
    }
    th.staff {
      text-align: left;
      background-color: #f0f0f0;
    }
    th.category {
      background-color: #dbe9f4;
      font-weight: bold;
    }
    .completed {
      background-color: #d4edda;
    }
    .in-progress {
      background-color: #fff3cd;
    }
    .not-started {
      background-color: #f8d7da;
    }
    select {
      margin-top: 5px;
    }
  </style>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @include('admin.training.training_navbar')
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="training-types" role="tabpanel">
                                <div class="container-fluid py-4">
        <!-- Dashboard Header -->
          <table>
    <thead>
      <tr>
        <th class="staff" rowspan="2">Staff Role</th>
        <th class="category" colspan="2">Safety</th>
        <th class="category" colspan="2">Technical</th>
        <th class="category" colspan="2">Soft Skills</th>
      </tr>
      <tr>
        <th>Fire Safety</th>
        <th>Evacuation Drills</th>
        <th>Software Tools</th>
        <th>Equipment Handling</th>
        <th>Communication</th>
        <th>Teamwork</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th class="staff">Maintenance Staff</th>
        <td class="completed"><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
      </tr>
      <tr>
        <th class="staff">Security Staff</th>
        <td class="completed"><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
      </tr>
      <tr>
        <th class="staff">All Employees</th>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td class="in-progress"><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
        <td><select><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
      </tr>
      <!-- Additional rows would follow the same pattern -->
    </tbody>
  </table>
        
       
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
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
