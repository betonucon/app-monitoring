@extends('layouts.app')

@push('style')
  <style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: normal;
    }
  </style>
@endpush
@push('datatable')
<script type="text/javascript">
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#data-table-fixed-header').length !== 0) {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20,50,100],
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('barang/getdata')}}",
                      columns: [
                        { data: 'KD_Barang', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'KD_Barang' },
                        { data: 'Kd_JenisBarang' },
                        { data: 'Nama_Barang' },
                        { data: 'uang_Harga_Beli' },
                        
                      ],
                      
                });
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
			TableManageFixedHeader.init();
            
		});

        
    </script>
@endpush
@section('content')
<div class="content-wrapper" style="min-height: 926.281px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control Transaksi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    
    <section class="content">
      
        <div class="row">
            <div class="col-lg-2 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-aqua">
                  <div class="inner">
                      <h3>{{count_project(1)}}</h3>

                      <p>Total Project</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-green">
                  <div class="inner">
                      <h3>{{count_project(2)}}</h3>

                      <p>Rencana Project</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-yellow">
                  <div class="inner">
                      <h3>{{count_project(3)}}</h3>

                      <p>Kontrak</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-2 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-red">
                  <div class="inner">
                      <h3>{{count_project(4)}}</h3>

                      <p>Pengerjaan</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>{{count_project(5)}}</h3>

                      <p>Selesai</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
            <!-- small box -->
              <div class="small-box bg-aqua">
                  <div class="inner">
                      <h3>{{count_project(6)}}</h3>

                      <p>Tagihan</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                    <h3 class="box-title">Progres Project</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height:430px"></canvas>
                    </div>
                    </div>
                    <!-- /.box-body -->
                </div>

                <div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Rencana Project</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body responsive-bawah">
                    <table class="table table-bordered">
                      <tbody>
                        <tr style="background:blue;color:#fff">
                          <th style="width: 5%">#</th>
                          <th style="width: 15%">Customer</th>
                          <th>Project</th>
                          <th style="width: 20%">Status</th>
                        </tr>
                        @foreach(get_all_project() as $no=>$dr)
                        <tr @if($dr->outstanding>0) style="background:#ef9898" @endif>
                          <td>{{$no+1}}</td>
                          <td><b>{{$dr->singkatan_customer}}</b></td>
                          <td>{{$dr->deskripsi_project}}</td>
                          <td style="background:{{$dr->color}}">{{$dr->singkatan}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  
                </div>
                <div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Rencana Project Cancel</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body responsive-bawah">
                    <table class="table table-bordered">
                      <tbody>
                        <tr style="background:red;color:#fff">
                          <th style="width: 5%">#</th>
                          <th style="width: 15%">Customer</th>
                          <th>Project</th>
                          <th style="width: 20%">Status</th>
                        </tr>
                        @foreach(get_all_project_cancel() as $no=>$dr)
                        <tr @if($dr->outstanding>0) style="background:#ef9898" @endif>
                          <td>{{$no+1}}</td>
                          <td><b>{{$dr->singkatan_customer}}</b></td>
                          <td>{{$dr->deskripsi_project}}</td>
                          <td style="background:{{$dr->color}}">Cancel</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  
                </div>
            </div>
            <div class="col-md-4">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Progres Project</h3>

                  <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  @foreach(get_status() as $o)
                    <div class="progress-group">
                      <span class="progress-text">{{$o->status}}</span>
                      <span class="progress-number"><b>{{count_status_project($o->id)}}</b>/{{count_all_project()}}</span>

                      <div class="progress sm">
                        <div class="progress-bar progress-bar-{{$o->color}}" style="width: {{round((100/count_all_project())*count_status_project($o->id))}}%"></div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
        </div>
     
    </section>
  </div>
@endsection

@push('ajax')

<!-- FastClick -->
<!-- page script -->
<script>
 $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    
    var areaChartData = {
      labels  : [
            @foreach(get_status() as $o)

                '{{$o->singkatan}}',
            @endforeach
        ],
      datasets: [
        {
          label               : 'Progres Project',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          options: {
                animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 1,
                    to: 0,
                    loop: true
                }
                },
                scales: {
                y: { // defining min and max so hiding the dataset does not change scale range
                    min: 0,
                    max: 100
                }
                }
            },
          pointHighlightStroke: 'rgba(220,220,220,1)',
          fillColor: [
            @foreach(get_status() as $o)
                '{{$o->color}}',
            @endforeach
          ],
          strokeColor: [
            @foreach(get_status() as $o)
                '{{$o->color}}',
            @endforeach
          ],
          data                : [
            @foreach(get_status() as $o)
                {{$o->total}},
            @endforeach
          ]
        }
      ]
    }


    
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      
      
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = true
    barChart.Bar(barChartData, barChartOptions)
  })
</script>      
@endpush
