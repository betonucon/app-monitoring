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

@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Rencana Pekerjaan
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Rencana Pekerjaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        
        <div class="box-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
              @csrf
              <!-- <input type="submit"> -->
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Rencana Pekerjaan</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li> -->
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane active" id="tab_1">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Rencana Pekerjaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Customer</label>

                            <div class="col-sm-2">
                              <div class="input-group">
                                <input type="text" id="customer_code" name="customer_code" readonly value="{{$data->customer_code}}" class="form-control  input-sm" placeholder="0000">
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" id="customer" readonly class="form-control input-sm"  value="{{$data->customer}}" placeholder="Ketik...">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ruang Lingkup Project</label>
                              <div class="col-sm-10">
                              <input  class="form-control input-sm" readonly name="deskripsi_project" value="{{$data->deskripsi_project}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Durasi (Start / End)</label>

                            <div class="col-sm-2">
                              <div class="input-group">
                                <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                <input type="text" id="start_date" name="start_date" readonly value="{{$data->start_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="input-group">
                                <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                <input type="text" id="end_date" name="end_date" readonly value="{{$data->end_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">CreateBy</label>
                              <div class="col-sm-5">
                              <input  class="form-control input-sm" disabled  value="{{$data->createby}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Progress</label>

                            <div class="col-sm-5">
                              
                                <input type="text"  readonly value="{{$data->status}}" style="color:{{$data->color}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                              
                            </div>
                            
                          </div>
                          
                          
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_2">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Risiko Pekerjaan</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label"></label>
                            
                            <div class="col-sm-10">
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Risiko Yang Terjadi</th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-risiko-save"></tbody>
                                
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                
                
              </div>
          </form>
        </div>
        <div class="box-footer">
        
            <div class="btn-group">
              <button type="button" class="btn btn-danger btn-sm" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
                 
        </div>
        
      </div>
     

    </section>
      <div class="modal fade" id="modal-draf" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Header Cost</h4>
            </div>
            <div class="modal-body">
              
                
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  </div>
@endsection

@push('ajax')
    <script> 
       
       $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}");
    </script> 
@endpush
