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
                    searching:true,
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('cost/getdata')}}?customer_code={{$data->customer_code}}",
                      columns: [
                        { data: 'seleksi' },
                        { data: 'no_cost' },
                        { data: 'customer_code' },
                        { data: 'customer' },
                        { data: 'area' },
                        
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kontrak
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kontrak</li>
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
                      <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Kontrak</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> RAB</a></li>
                      <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li> -->
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane " id="tab_1">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Detail Kontrak</label>

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
                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai Kontrak (Rp) </label>
                            <div class="col-sm-2">
                              <input type="text"  style="text-align:right" name="nilai" disabled  class="form-control  input-sm" value="{{uang($data->nilai)}}" placeholder="">
                            </div>
                            <div class="col-sm-7">
                              <input type="text"   readonly name="terbilang" value="{{terbilang($data->nilai)}}" class="form-control  input-sm" placeholder="">
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
                                <tbody id="tampil_risiko"></tbody>
                              </table>
                            </div>
                        </div>
                      </div>
                      <div class="tab-pane active" id="tab_3" >
                        <div id="tampil_pengeluaran"></div>
                        @include('kontrak.rab_view')
                      </div>
                    </div>
                    
                  
                </div>
                
                
              </div>
          </form>
        </div>
        <div class="box-footer">
        
        <div class="btn-group">
              <button type="button" class="btn btn-sm btn-danger" onclick="location.assign(`{{url('kontrak')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
              <button type="button" class="btn btn-sm btn-primary" onclick="approve_data()"><i class="fa  fa-check-square"></i> Approve</button>
            </div>
                 
        </div>
        
      </div>
     

    </section>
      <div class="modal file" id="modal-approve" style="display: none;">
        <div class="modal-dialog" style="max-width:70%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Konfirmasi / Approve</h4>
            </div>
            <div class="modal-body" style="padding: 0px 25px">
              <form class="form-horizontal" id="mydataapprove" method="post" action="{{ url('project/approve_mgr_operasional') }}" enctype="multipart/form-data" >
                  @csrf
                  <input type="hidden" name="id" value="{{$id}}">
                  <div class="row">
                  
                    <div class="col-md-12">
                      
                        <div class="box-body">
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label-modal"><i class="fa fa-bars"></i> Approval</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Status Approve</label>

                            <div class="col-sm-8">
                              <div class="input-group">
                                <span class="input-group-addon" ><i class="fa  fa-chevron-down"></i></span>
                                <select name="status_id" onchange="pilih_status(this.value)" class="form-control  input-sm" placeholder="0000">
                                  <option value="">Pilih------</option>
                                  <option value="11">Setujui</option>
                                  <option value="8">Kembalikan</option>
                                  
                                </select>
                              </div>
                            </div>
                            
                          </div>
                          
                          <div class="form-group" id="tampil-catatan" style="margin-top:1%">
                            <label for="inputEmail3" class="col-sm-3 control-label">Alasan Kembalian</label>
                            <div class="col-sm-8">
                              <textarea  class="form-control input-sm" name="catatan" placeholder="ketik disini....."  rows="5"></textarea>
                            </div>
                          </div>
                          
                          
                        </div>
                        <!-- /.box-body -->
                        
                        <!-- /.box-footer -->
                      
                    </div>
                    
                    
                  </div>
              </form>
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary pull-right" onclick="approve_proses()" >Approve</button>
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
       
        
        
        $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
        $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}&act=1");
        $('#tampil-personal-save').load("{{url('kontrak/tampil_personal')}}?id={{$data->id}}&act=1");
        $('#tampil-catatan').hide()

        function approve_data(){
          $('#modal-approve').modal('show')
        }

        function pilih_status(id){
          if(id==8){
            $('#tampil-catatan').show()
          }else{
            $('#tampil-catatan').hide()
          }
          
        }
        

        $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}&act=1");
       
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        $("#margin").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 1, 'digitsOptional': false });
        
    </script> 
@endpush
