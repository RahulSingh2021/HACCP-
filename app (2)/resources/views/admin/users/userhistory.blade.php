@extends('layouts.app', ['pagetitle'=>'Dashboard'])

<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}

body{

}

.table_container {
  display: flex;
  justify-content: center;
  align-items: center;
}

ul {
  padding-left:0px;
  list-style:none;
  margin-top:1rem;
}



.btn {
  cursor:pointer;
}

.details {
  display: none;
}

.details .open {
  display: table-cell;
}
</style>
@section('content')
  <div class="row row-cols-auto g-3 mb-3">
      <div class="card" style="    width: 100%;">
                <div class="card-body">
                                <div class="col-12">
                                        <div class="row row-cols-auto g-1 mb-3">
                                            <div class="col">
                                                <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnew-training-type">History</button>
                                            </div>                                            
                                        </div>
                                        
                                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped table-bordered data-t f-child"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Sr.NO.</th>
                                                        <th class="text-left">Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i=1; @endphp
                                                    @foreach($result as $results)
                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td>{{$results->reason ?? ''}}</td>
                                                    </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                    
                                             
                                                </tbody>
                                                    
                                                    
                                                    
                                               </div>
                                    </div>             
                                    </div>
                                    </div>
  
        
@endsection


   