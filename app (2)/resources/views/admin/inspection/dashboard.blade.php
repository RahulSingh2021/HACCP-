@extends('layouts.app1', ['pagetitle'=>'Dashboard'])



@section('content')
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

#chart4 {
  max-width: 750px;
  margin: 35px auto;
}


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
<h3 class="text-center">Overall SubCocern Wise Observation</h3>




<table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                    <th>SN.</th>
                                                    <th>Name</th>
    @if(!empty($responsibilityList))
    @foreach($responsibilityList as $Responsibilitys)
    <th>{{$Responsibilitys->name ?? '' }}</th>
    @endforeach
    @endif
                                                    <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        
                      @php $i=1; @endphp                                  
                                                                                                                                                                                        
          @foreach($concern_list as $concern_lists)                                                                                          
    
    <tr>
    <td>{{$i}}</td>
    
    <td>{{$concern_lists->title ?? ''}}</td>
      @if(!empty($responsibilityList))
        @foreach($responsibilityList as $Responsibilitys)
        <td>{{DB::table('inspection')->where('subconcern',$concern_lists->id)->where('responsibility',$Responsibilitys->id)->count() ?? '' }}</td>
        @endforeach
        @endif
    <td>{{$concern_lists->count ?? ''}}</td>
    </tr>
    @php $i++; @endphp
    @endforeach
                 
  
                                                                                                                                                       
                                                       
                                               
                                                    
                                                    </tbody>
                                                    </table>
</div>
</div>
</div>

<div class="col-6">
<div class="card">
<div class="card-body">
<h3 class="text-center">Overall Cocern Wise Observation</h3>




<table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                    <th>SN.</th>
                                                    <th>Name</th>
                                                    
@if(!empty($responsibilityList))
@foreach($responsibilityList as $Responsibilitys)
<th>{{$Responsibilitys->name ?? '' }}</th>
@endforeach
@endif
        
                                                    <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        
                      @php $i=1; @endphp                                  
                                                                                                                                                                                        
          @foreach($concern_itemlist as $concern_lists)                                                                                          
    
    <tr>
    <td>{{$i}}</td>
    
    <td>{{$concern_lists->title ?? ''}}</td>
    
        @if(!empty($responsibilityList))
        @foreach($responsibilityList as $Responsibilitys)
        <td>{{DB::table('inspection')->where('concern',$concern_lists->id)->where('responsibility',$Responsibilitys->id)->count() ?? '' }}</td>
        @endforeach
        @endif
            <td>{{$concern_lists->count ?? ''}}</td>

        
    </tr>
    @php $i++; @endphp
    @endforeach
                 
  
                                                                                                                                                       
                                                       
                                               
                                                    
                                                    </tbody>
                                                    </table>
</div>
</div>
</div>

    <div class="col-6">
        <div class="row">
            
            @foreach($concenvaluelistdata as $list)
        <div class="mt-6 col-12">
        <div class="card card-body p-3">
        <h6 class="w-100 mt-1 text-center">{{$list->name ?? ''}}</h6>
        <table class="table table-bordered ">
        <thead>
        <tr>
        <th>SN.</th>
        <th>SubCocern</th>
        
   
        
        @if(!empty($list->Responsibility))
        @php  $Responsibility = json_decode($list->Responsibility); @endphp
        @foreach($Responsibility as $Responsibilitys)
        <th>{{DB::table('authority')->where('id',$Responsibilitys)->value('name') ?? '' }}</th>
        @endforeach
        @endif
        <th>Total</th>
        </tr>
        </thead>
        <tbody>


@php $subconcernlist = Helper::subconcernlist($list->id); @endphp
@php $i=1; @endphp
@foreach($subconcernlist as $subconcernlistss)
        <tr>
        <td>{{$i}}</td>
        
        <td>{{$subconcernlistss->name ?? ''}}</td>
        
              @if(!empty($list->Responsibility))
        @php  $Responsibility = json_decode($list->Responsibility); @endphp
        @foreach($Responsibility as $Responsibilitys)
        <td>{{DB::table('inspection')->where('subconcern',$subconcernlistss->id)->where('responsibility',$Responsibilitys)->count() ?? '' }}</td>
        @endforeach
        @endif

        <td>{{Helper::subconcernlistcount($subconcernlistss->id)}}</td>
        </tr>
        @php $i++; @endphp
       @endforeach 
        </tbody>
        </table>
        </div>
        </div>
        @endforeach
        </div>
</div>

</div>                  
                     
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
                    
<!--<div id="chart4"></div>-->
<div id="chartdiv"></div>
@endsection


@section('footerscript')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@2.1.8"></script>

<script>
    // Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  layout: root.verticalLayout
}));

var data = [@foreach($ssubconcern_list as $datas){
  "company": "{{$datas->title ?? ''}}",
  "hardware": 15,
  "interalit": 10,
},@endforeach]


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "company",
  renderer: am5xy.AxisRendererX.new(root, {}),
  tooltip: am5.Tooltip.new(root, {})
}));

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  min: 0,
  max: 100,
  numberFormat: "#'%'",
  strictMinMax: true,
  calculateTotals: true,
  renderer: am5xy.AxisRendererY.new(root, {})
}));

var yRenderer = yAxis.get("renderer");
yRenderer.labels.template.setAll({
  fontSize: 13,
  fill: am5.color(0x666666)
});

// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/

var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));



// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function makeSeries(name, fieldName) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    stacked: true,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    valueYShow: "valueYTotalPercent",
    categoryXField: "company"
  }));

  series.columns.template.setAll({
    //tooltipText: "{name}, {categoryX}:{formatNumber('#.#')}",
    //tooltipY: am5.percent(10)
  });
  series.data.setAll(data);

  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      sprite: am5.Label.new(root, {
        text: "Rahul",
        fill: root.interfaceColors.get("alternativeText"),
        centerY: am5.p50,
        centerX: am5.p50,
        populateText: false
      })
    });
  });

  legend.data.push(series);
}

makeSeries("Hardware", "hardware");
makeSeries("Internal IT", "internalit");
makeSeries("Other", "other");
makeSeries("IT Services", "itservices");
makeSeries("Software", "software");

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);
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
    width: [4, 4]
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




