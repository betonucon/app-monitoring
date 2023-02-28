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
              <button type="button" class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
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
              <form class="form-horizontal" id="mydataapprove" method="post" action="{{ url('project/approve_direktur_operasional') }}" enctype="multipart/form-data" >
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
                                  <option value="6">Setujui</option>
                                  <option value="1">Kembalikan</option>
                                  
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
       
        $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}");
        $('#tampil-catatan').hide()

        function approve_data(){
          $('#modal-approve').modal('show')
        }

        function pilih_status(id){
          if(id==1){
            $('#tampil-catatan').show()
          }else{
            $('#tampil-catatan').hide()
          }
          
        }

        
        function approve_proses(){
            
            var form=document.getElementById('mydataapprove');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('project/approve_direktur_operasional') }}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
                        document.getElementById("loadnya").style.width = "100%";
                    },
                    success: function(msg){
                        var bat=msg.split('@');
                        if(bat[1]=='ok'){
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                              title: "Success! berhasil diproses!",
                              icon: "success",
                            });
                            location.assign("{{url('project')}}");
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                                title: 'Notifikasi',
                               
                                html:true,
                                text:'ss',
                                icon: 'error',
                                buttons: {
                                    cancel: {
                                        text: 'Tutup',
                                        value: null,
                                        visible: true,
                                        className: 'btn btn-dangers',
                                        closeModal: true,
                                    },
                                    
                                }
                            });
                            $('.swal-text').html('<div style="width:100%;background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>')
                        }
                        
                        
                    }
                });
        }
    </script> 
@endpush
