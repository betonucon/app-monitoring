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
        Rencana Pekerjaan
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Rencana Pekerjaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        
        
        <div class="box-body">
          <form class="form-horizontal" id="mydata" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
              @csrf
              <!-- <input type="submit"> -->
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  <div class="callout callout-success">
                    <h4>Penyusunan RAB</h4>

                    <p>Penyusunan nilai anggaran rencana project yang terdiri dari 4 aspek (Rencana , Biaya Operasional, Material Cos dan Risiko Project)</p>
                  </div>
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Rencana Pekerjaan</a></li>
                      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Operasional Project</a></li>
                      <li class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Material Cost</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane " id="tab_1">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Rencana Pekerjaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Customer Cost</label>

                            <div class="col-sm-2">
                              <div class="input-group">
                                <input type="text" id="customer_code" name="cost" readonly value="{{$data->cost_header}}" class="form-control  input-sm" placeholder="0000">
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
                            <label for="inputEmail3" class="col-sm-2 control-label">Kategori Project</label>
                              <div class="col-sm-3">
                              <input  class="form-control input-sm" readonly  value="{{$data->kategori_project}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Tipe Project</label>
                              <div class="col-sm-5">
                              <input  class="form-control input-sm" readonly  value="{{$data->tipe_project}} ({{$data->keterangan_tipe_project}})" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai Project</label>

                            <div class="col-sm-5">
                              <div class="input-group">
                                <input type="text"  readonly value="{{uang($data->nilai_project)}}" class="form-control  input-sm text-right" placeholder="0000">
                              </div>
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
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Pembiayaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Operasional Cost</label>

                            <div class="col-sm-5">
                              <div class="input-group">
                                <input type="text"  readonly value="{{uang(sum_operasional($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Material Cost</label>

                            <div class="col-sm-5">
                              <div class="input-group">
                                <input type="text"  readonly value="{{uang(sum_material($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Total Pembiayaan</label>

                            <div class="col-sm-5">
                              <div class="input-group">
                                <input type="text"  readonly value="{{uang(sum_operasional($data->id)+sum_material($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Spase Anggaran</label>

                            <div class="col-sm-5">
                              <div class="input-group">
                                <input type="text"  readonly value="{{uang($data->nilai_project-(sum_operasional($data->id)+sum_material($data->id)))}}" class="form-control  input-sm text-right" placeholder="0000">
                              </div>
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
                                    <th>Tipe</th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-risiko-save"></tbody>
                                
                              </table>
                            </div>
                        </div>
                      </div>

                      <div class="tab-pane active" id="tab_4">
                        
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Material Cost</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th style="width:10%">Kode</th>
                                    <th>Material</th>
                                    <th style="width:8%">Qty</th>
                                    
                                    <th style="width:12%">H Pengajuan</th>
                                    <th style="width:12%">Total</th>
                                    <th style="width:12%">H Actual</th>
                                    <th style="width:12%">Total</th>
                                    <th style="width:5%">Sts</th>
                                    <th style="width:5%">Act</th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-material-save"></tbody>
                                
                              </table>
                            </div>
                        </div>
                        
                      </div>

                      <div class="tab-pane" id="tab_3">
                      
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Operasional Pekerjaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Keterangan</th>
                                    <th style="width:14%">Biaya</th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-operasional-save"></tbody>
                                
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
            <button  class="btn btn-sm btn-info" onclick="verifikasi_data_procurement()"><i class="fa fa-save"></i> Verifikasi</button>
              <button type="button" class="btn btn-danger btn-sm" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
                 
        </div>
        
      </div>
     

    </section>
      <div class="modal fade" id="modal-material" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Verifikasi Material</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="mydataverifikasi" method="post" action="{{ url('project/verifikasi_material') }}" enctype="multipart/form-data" >
                @csrf
                  <div id="form-verifikasi"></div>
              </form>
                
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary pull-right" onclick="verifikasi_data()" >Verifikasi</button>
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
       $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}&act=1");
       $('#tampil-material-save').load("{{url('project/tampil_material_proc')}}?id={{$data->id}}");
      
       function update_material(id){
          $('#modal-material').modal({backdrop: 'static', keyboard: false});
          $('#form-verifikasi').load("{{url('project/form_material')}}?id="+id);
       }

       function verifikasi_data(){
            
            var form=document.getElementById('mydataverifikasi');
            
                  $.ajax({
                      type: 'POST',
                      url: "{{ url('project/verifikasi_material') }}",
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
                                title: "Success! berhasil dikirim!",
                                icon: "success",
                              });
                              $('#modal-material').modal('hide');
                              $('#form-verifikasi').html("");
                              $('#tampil-material-save').load("{{url('project/tampil_material_proc')}}?id={{$data->id}}");
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
                
        };
       function verifikasi_data_procurement(){
            
            var form=document.getElementById('mydata');
            swal({
                title: "Yakin akan melakukan verifikasi ?",
                text: "",
                type: "warning",
                icon: "info",
                showCancelButton: true,
                align:"center",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                
                  $.ajax({
                      type: 'POST',
                      url: "{{ url('project/store_procurement') }}",
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
                                title: "Success! berhasil diverifikasi!",
                                icon: "success",
                              });
                              location.assign("{{url('project')}}")
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
            });
        };
    </script> 
@endpush
