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
      Konfirmasi Proses Negosiasi
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Negosiasi</li>
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
                      <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Material Cost</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i>Bidding</a></li>
                      <li class="active"><a href="#tab_6" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i>Negosiasi</a></li>
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane" id="tab_1">
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

                      <div class="tab-pane" id="tab_4">
                        
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Material Cost</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <table class="table table-bordered" id="">
                                @if($data->status_id>6)
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
                                  </tr>
                                </thead>
                                @else
                                  <thead>
                                    <tr style="background:#bcbcc7">
                                      <th style="width: 10px">No</th>
                                      <th style="width:15%">Kode</th>
                                      <th>Material</th>
                                      <th style="width:15%">H.Satuan</th>
                                      <th style="width:8%">Qty</th>
                                      <th style="width:15%">Total</th>
                                    </tr>
                                  </thead>
                                @endif
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
                      <div class="tab-pane" id="tab_5">
                      
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Deskripsi Bidding</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai Bidding (Rp)</label>

                            <div class="col-sm-2">
                              <input type="text"  id="nilai" name="nilai_bidding"  class="form-control  input-sm" value="{{$data->nilai_bidding}}" placeholder="">
                            </div>
                            <div class="col-sm-7">
                              <input type="text" readonly name="terbilang" value="{{$data->terbilang}}" class="form-control  input-sm" placeholder="">
                            </div>
                            
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Bidding</label>

                            <div class="col-sm-2">
                              <div class="input-group">
                                <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                <input type="text" id="bidding_date" name="bidding_date"  value="{{$data->bidding_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Status Bidding</label>

                            <div class="col-sm-4">
                              <div class="input-group">
                                <span class="input-group-addon" ><i class="fa  fa-chevron-down"></i></span>
                                <select name="status_id"  class="form-control  input-sm" placeholder="0000">
                                  <option value="">Pilih------</option>
                                  <option value="8">Lolos dan lanjut</option>
                                  <option value="50">Cancel Proses</option>
                                  
                                </select>
                              </div>
                            </div>
                            
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Catatan Hasil Bidding</label>
                              <div class="col-sm-10">
                              <textarea  class="form-control input-sm"  name="hasil_bidding" placeholder="Ketik..." rows="7">{{$data->hasil_bidding}}</textarea>
                            </div>
                          </div>
                          
                          
                          
                          
                        </div>
                          
                      </div>
                      <div class="tab-pane active" id="tab_6">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Informasi Hasil Negosiasi</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai Kontrak (Rp)</label>

                            <div class="col-sm-2">
                              <input type="text"  id="nilai_negosiasi" name="nilai_negosiasi"  class="form-control  input-sm" value="" placeholder="">
                            </div>
                            <div class="col-sm-7">
                              <input type="text"  id="out" readonly name="terbilang" value="" class="form-control  input-sm" placeholder="">
                            </div>
                            
                            
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
            <button type="button" class="btn btn-sm btn-info" onclick="simpan_data()"><i class="fa fa-save"></i> Proses data</button>
              
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
       $("#nilai_negosiasi").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $(document).ready(function(){

          $("#nilai_negosiasi").keyup(function(){
            var angkane=$("#nilai_negosiasi").val();
            var nil = angkane.replace(/[.](?=.*?\.)/g, '');
            var nilai=parseFloat(nil.replace(/[^0-9.]/g,''))
            $("#out").val(terbilang(nilai)+' rupiah');

          });

        });
       $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}");
       $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}&act=1");
       $('#tampil-material-save').load("{{url('project/tampil_material')}}?id={{$data->id}}&act=1");
       function simpan_data(){
            
            swal({
                title: "Yakin data yang diinputkan sudah benar ?",
                text: "",
                type: "warning",
                icon: "info",
                showCancelButton: true,
                align:"center",
                confirmButtonClass: "btn-info",
                confirmButtonText: "Yes, cancel it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                      
                  var form=document.getElementById('mydata');
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('project/store_negosiasi') }}",
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
                                  title: "Success! berhasil diproses dan dilanjutkan keproses komtrak!",
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
                    
                      
                } else {
                    
                }
            });
            
        } 
    </script> 
@endpush
