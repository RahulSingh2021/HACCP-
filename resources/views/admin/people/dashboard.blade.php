@extends('layouts.app1', ['pagetitle'=>'Dashboard'])



@section('content')
<style>


</style>

    <div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">
      
                            
                                    <div class="tab-content">
                                        
                                        <div class="tab-pane fade show active">
                                                                                      <form action="" method="get" id="filter_form">

                                            <div class="row row-cols-auto g-3 mb-3">
                                      
                                   <div class="col-2">
                                                    <select class="form-select" aria-label="Default select example" name="responsibilitys" onchange="this.form.submit()">
                                                        <option value="">Select Type</option>
                                    <option value="1" {{ ( "1" == @$_GET['responsibilitys']) ? 'selected' : '' }}>Responsibility</option>
                                    <option value="2" {{ ( "2" == @$_GET['responsibilitys']) ? 'selected' : '' }}>Location</option>
                                                    </select>
                                                </div>    
           
   
                        <div class="col-md-2"><input type="date" name="s_date" class="form-control"></div>
                        <div class="col-md-2"><input type="date" name="e_date" class="form-control"></div>
                        <div class="col-md-2"><button type="submit" class="btn btn-outline-dark px-3">Submit</button>
                        <a class="btn btn-outline-dark px-3" href="https://efsm.safefoodmitra.com/admin/public/index.php/inspection/dashboard">Clear Filter</a></div>

              
                        
                                            </div> 
                                            
                                            </form>
                                            <div class="row row-cols-auto" id="htmlContent"> 
                                            
                                            @foreach($responsibility as $responsibilitys)
                                                    <div class="mt-3 col-4">
                                                    <div class="card card-body p-3">
                                                    <h6 class="w-100 mt-1 text-center">{{$responsibilitys->name ?? ''}}</h6>
                                                    <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                    <th>SN.</th>
                                                    <th>Location</th>
                                                    <th>Open</th>
                                                    <th>Close</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        
                                                        
                                                        @if($responsibilityvalue=="2")
                                                        
                                                                       @php $i=1;
                                                                                                                      $second2 = 0;
                                                                                                  $second21 = 0;
                                                                                                  @endphp
                                                                                                  
                                                                       @php $authorityslocation = DB::table('locations')->where('parent',$responsibilitys->id ?? '')->get()  @endphp 
                                                                                                    

                                                       @foreach($authorityslocation as $authorityslocations)
                                                       
                                                          @php $second2+= Helper::opencase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                                       
                                                       $second21+= Helper::closecase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                                       
                                                       @endphp
                                                       
                                                       
                                                       
                                                          <tr>
                                                              <td>{{$i}}</td>
                                                    <td>{{$authorityslocations->name ?? ''}}</td>
                                                    <td>{{Helper::opencase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date)}}</td>
                                                    <td>{{Helper::closecase($authorityslocations->id ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date)}}</td>
                                                    </tr>

                                                       @php $i++; @endphp
                                                       @endforeach
                                                       
                                                                        <tr style="background: gray;color: #fff;">
                                                                        <td colspan="2">Total</td>
                                                                        <td>{{$second2}}</td>
                                                                        <td>{{$second21}}</td>
                                                                        </tr>
                                                       

                                                        @else
                                                                         @if(!empty($responsibilitys->location))
                                                      @php $authorityslocation = json_decode($responsibilitys->location) @endphp 
                                                                                                  @php $i=1;
                                                                                                  
                                                                                                  $first = 0;
                                                                                                  $first1 = 0;


@endphp

                                                       @foreach($authorityslocation as $authorityslocations)
                                                       
                                                       @php $first+= Helper::opencase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                                       
                                                       $first1+= Helper::closecase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date);
                                                       
                                                       @endphp
                                                          <tr>
                                                              <td>{{$i}}</td>
                                                              
                                                    <td>{{DB::table('locations')->where('id',$authorityslocations)->value('name')}}</td>
                                                    <td>{{Helper::opencase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date)}}</td>
                                                    <td>{{Helper::closecase($authorityslocations ?? '',$responsibilitys->id ?? '',$responsibilityvalue,$s_date,$e_date)}}</td>
                                                    </tr>
@php $i++; @endphp
                                           
                                           
           
                                                       @endforeach
                                                       
                   <tr style="background: gray;color: #fff;">
                                    <td colspan="2">Total</td>
                                    <td>{{$first}}</td>
                                    <td>{{$first1}}</td>
                                    </tr>
  
                                                       @endif
                                                        @endif
                                        
                                                       
                                               
                                                    
                                                    </tbody>
                                                    </table>
                                                    </div>
                                                    </div>
                                                    
                                                    
                                            @endforeach
                                  

                                        </div>
                                        
                         
                                       </div>
                                       
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    <!--end row-->
                                      
                     
                        <div class="row">
<div class="col-6">
<div class="card">
<div class="card-body">
<h3 class="text-center">Overall Responsibility Wise Observation</h3>
<div id="chart">
</div>



<table  style="width:100%;text-align: center;">
    
      <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Observation Status</th>
    @foreach($data as $datas)
    
    
    <th style="border: 1px solid black;">{{$datas['name'] ?? ''}}</th>
    @endforeach
        <th style="border: 1px solid black;">Total</th>

  </tr>
  
  
  <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Open</th>
    @php $firstsum=0; @endphp
    @foreach($data as $datas)
    @php $firstsum+= $datas['first'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['first'] ?? ''}}</td>
    @endforeach
    <td style="border: 1px solid black;">{{$firstsum ?? ''}}</td>
  </tr>
  <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Close</th>
    @php $first1sum=0; @endphp
    @foreach($data as $datas)
    @php $first1sum+= $datas['first1'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['first1'] ?? ''}}</td>
    @endforeach 
     <td style="border: 1px solid black;">{{$first1sum ?? ''}}</td></tr>
  <tr style="border: 1px solid black;">
      @php $totalsum=0; @endphp
    <th style="border: 1px solid black;">Total</th>
    @foreach($data as $datas)
    @php $totalsum+= $datas['total'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['total'] ?? ''}}</td>
    @endforeach
    
    <td style="border: 1px solid black;">{{$totalsum ?? ''}}</td>
    </tr>
</table>
</div>
</div>
</div>
<div class="col-6">
<div class="card">
<div class="card-body">
<h3 class="text-center">Overall Location Wise Observation</h3>
<div id="chart1">
</div>



<table  style="width:100%;text-align: center;">
    
      <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Observation Status</th>
    @foreach($locationdata as $datas)
    
    
    <th style="border: 1px solid black;">{{$datas['name'] ?? ''}}</th>
    @endforeach
        <th style="border: 1px solid black;">Total</th>

  </tr>
  
  
  <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Open</th>
    @php $firstsum=0; @endphp
    @foreach($locationdata as $datas)
    @php $firstsum+= $datas['first'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['first'] ?? ''}}</td>
    @endforeach
    <td style="border: 1px solid black;">{{$firstsum ?? ''}}</td>
  </tr>
  <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Close</th>
    @php $first1sum=0; @endphp
    @foreach($locationdata as $datas)
    @php $first1sum+= $datas['first1'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['first1'] ?? ''}}</td>
    @endforeach 
     <td style="border: 1px solid black;">{{$first1sum ?? ''}}</td></tr>
  <tr style="border: 1px solid black;">
      @php $totalsum=0; @endphp
    <th style="border: 1px solid black;">Total</th>
    @foreach($locationdata as $datas)
    @php $totalsum+= $datas['total'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['total'] ?? ''}}</td>
    @endforeach
    
    <td style="border: 1px solid black;">{{$totalsum ?? ''}}</td>
    </tr>
</table>
</div>
</div>
</div>
</div>


<div class="row">
    
    <div class="col-6">
<div class="card">
<div class="card-body">
<h3 class="text-center">Overall Cocern Wise Observation</h3>
<div id="chart2">
</div>



<table  style="width:100%;text-align: center;">
    
      <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Observation Status</th>
    @foreach($locationdata as $datas)
    
    
    <th style="border: 1px solid black;">{{$datas['name'] ?? ''}}</th>
    @endforeach
        <th style="border: 1px solid black;">Total</th>

  </tr>
  
  
  <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Open</th>
    @php $firstsum=0; @endphp
    @foreach($locationdata as $datas)
    @php $firstsum+= $datas['first'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['first'] ?? ''}}</td>
    @endforeach
    <td style="border: 1px solid black;">{{$firstsum ?? ''}}</td>
  </tr>
  <tr style="border: 1px solid black;">
    <th style="border: 1px solid black;">Close</th>
    @php $first1sum=0; @endphp
    @foreach($locationdata as $datas)
    @php $first1sum+= $datas['first1'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['first1'] ?? ''}}</td>
    @endforeach 
     <td style="border: 1px solid black;">{{$first1sum ?? ''}}</td></tr>
  <tr style="border: 1px solid black;">
      @php $totalsum=0; @endphp
    <th style="border: 1px solid black;">Total</th>
    @foreach($locationdata as $datas)
    @php $totalsum+= $datas['total'] ?? ''; @endphp
    <td style="border: 1px solid black;">{{$datas['total'] ?? ''}}</td>
    @endforeach
    
    <td style="border: 1px solid black;">{{$totalsum ?? ''}}</td>
    </tr>
</table>
</div>
</div>
</div>

</div>



                    </div>
                     </div>
                    <!--end row-->
                    

@endsection


@section('footerscript')

<script src="https://cdn.jsdelivr.net/npm/apexcharts@2.1.8"></script>

<script>
    var options = {
  chart: {
    height: 350,
    type: "line",
    stacked: false
  },
  dataLabels: {
    enabled: true,
    
  },
  colors: ['#d7ed19','#558B2F', '#e71a1a'],
  series: [
           {
      name: 'Total',
      type: 'column',
      data: [@foreach($locationdata as $datas){{$datas['total'] ?? ''}},@endforeach]
    },
    {
      name: 'Close',
      type: 'column',
      data: [@foreach($data as $datas){{$datas['first1'] ?? ''}},@endforeach]
    },
    {
      name: "Open",
      type: 'column',
      data: [@foreach($data as $datas){{$datas['first'] ?? ''}},@endforeach]
    },
    // {
    //   name: "Line C",
    //   type: 'line',
    //   data: [@foreach($data as $datas){{$datas['total'] ?? ''}},@endforeach]
    // },
  ],
  stroke: {
    width: [4,4, 4]
  },
  plotOptions: {
    bar: {
      columnWidth: "60%"
    }
  },
  xaxis: {
    categories: [@foreach($data as $datas)'{{$datas['name'] ?? ''}}',@endforeach]
  },
  yaxis: [
    {
      seriesName: 'Close',
      axisTicks: {
        show: true
      },
      axisBorder: {
        show: true,
      },
      title: {
        text: "Observation Number"
      }
    },
    {
      seriesName: 'Close',
      show: false
    }
  ],
  tooltip: {
    shared: false,
    intersect: true,
    x: {
      show: false
    }
  },
  legend: {
    horizontalAlign: "center",
    offsetX: 40
  }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();

</script>

<script>
    var options = {
  chart: {
    height: 350,
    type: "line",
    stacked: false
  },
  dataLabels: {
    enabled: true,
    
  },
  colors: ['#d7ed19','#558B2F', '#e71a1a'],
  series: [
    
       {
      name: 'Total',
      type: 'column',
      data: [@foreach($locationdata as $datas){{$datas['total'] ?? ''}},@endforeach]
    },
    {
      name: 'Close',
      type: 'column',
      data: [@foreach($locationdata as $datas){{$datas['first1'] ?? ''}},@endforeach]
    },
    {
      name: "Open",
      type: 'column',
      data: [@foreach($locationdata as $datas){{$datas['first'] ?? ''}},@endforeach]
    },
    // {
    //   name: "Line C",
    //   type: 'line',
    //   data: [@foreach($data as $datas){{$datas['total'] ?? ''}},@endforeach]
    // },
  ],
  stroke: {
    width: [4,4, 4]
  },
  plotOptions: {
    bar: {
      columnWidth: "60%"
    }
  },
  xaxis: {
    categories: [@foreach($locationdata as $datas)'{{$datas['name'] ?? ''}}',@endforeach]
  },
  yaxis: [
    {
      seriesName: 'Close',
      axisTicks: {
        show: true
      },
      axisBorder: {
        show: true,
      },
      title: {
        text: "Observation Number"
      }
    },
    {
      seriesName: 'Close',
      show: false
    }
  ],
  tooltip: {
    shared: false,
    intersect: true,
    x: {
      show: false
    }
  },
  legend: {
    horizontalAlign: "center",
    offsetX: 40
  }
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);

chart.render();

</script>


<script>
    var options = {
  chart: {
    height: 350,
    type: "line",
    stacked: false
  },
  dataLabels: {
    enabled: true,
    
  },
  colors: ['#558B2F', '#e71a1a'],
  series: [
    
    {
      name: 'Close',
      type: 'column',
      data: [@foreach($locationdata as $datas){{$datas['first1'] ?? ''}},@endforeach]
    },
    {
      name: "Open",
      type: 'column',
      data: [@foreach($locationdata as $datas){{$datas['first'] ?? ''}},@endforeach]
    },
    // {
    //   name: "Line C",
    //   type: 'line',
    //   data: [@foreach($data as $datas){{$datas['total'] ?? ''}},@endforeach]
    // },
  ],
  stroke: {
    width: [4, 4]
  },
  plotOptions: {
    bar: {
      columnWidth: "60%"
    }
  },
  xaxis: {
    categories: [@foreach($locationdata as $datas)'{{$datas['name'] ?? ''}}',@endforeach]
  },
  yaxis: [
    {
      seriesName: 'Close',
      axisTicks: {
        show: true
      },
      axisBorder: {
        show: true,
      },
      title: {
        text: "Observation Number"
      }
    },
    {
      seriesName: 'Close',
      show: false
    }
  ],
  tooltip: {
    shared: false,
    intersect: true,
    x: {
      show: false
    }
  },
  legend: {
    horizontalAlign: "center",
    offsetX: 40
  }
};

var chart = new ApexCharts(document.querySelector("#chart2"), options);

chart.render();

</script>
@endsection




