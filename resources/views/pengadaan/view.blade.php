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
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
          $(document).ready(function () {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20,50,100],
                    searching:true,
                    lengthChange:false,
                    paging:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: false,
                    ajax:"{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'pilih' },
                        { data: 'action' },
                        { data: 'singkatan_pengadaan' ,className: "text-center" },
                        // { data: 'singkatan_aset' ,className: "text-center" },
                        { data: 'nama_material' },
                        { data: 'qty' ,className: "text-center" },
                        { data: 'satuan_material' ,className: "text-center" },
                        { data: 'harga_satuan_actual' ,className: "text-right" },
                        { data: 'harga_total_actual' ,className: "text-right" },
                        
                      ],
                      
                });

                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })
                $('#cari_status_material').change(function(){
                    var text=$(this).val();
                    var status_aset=$('#cari_status_aset').val();
                    var tables=$('#data-table-fixed-header').DataTable();
                        tables.ajax.url("{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}&status_material_id="+text+"&status_aset_id="+status_aset).load();
                })
                $('#cari_status_aset').change(function(){
                    var text=$(this).val();
                    var status_material=$('#cari_status_material').val();
                    var tables=$('#data-table-fixed-header').DataTable();
                        tables.ajax.url("{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}&status_material_id="+status_material+"&status_aset_id="+text).load();
                })

                var tablepengadaan=$('#data-table-fixed-header-pengadaan').DataTable({
                    lengthMenu: [20,50,100],
                    searching:true,
                    lengthChange:false,
                    paging:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: false,
                    ajax:"{{ url('pengadaan/getdatapengadaan')}}?cost_center={{$data->cost_center_project}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'pilih' },
                        { data: 'action' },
                        { data: 'keterangan' },
                        { data: 'qty' ,className: "text-center" },
                        { data: 'harga_satuan' ,className: "text-right" },
                        { data: 'total_harga' ,className: "text-right" },
                        
                      ],
                      
                });
          });
       

        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengadaan
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pengadaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        
        
        <div class="box-body">
          <form class="form-horizontal" id="material" method="post" action="{{ url('pengadaan/store_ready') }}" enctype="multipart/form-data" >
              @csrf
              <input type="submit">
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  
                  @if($data->status_id>8)
                  <!-- <div class="btn-group" style="margin-bottom:1%">
                    <button type="button" class="btn btn-success btn-sm" onclick="window.open(`{{url('project/cetak')}}?id={{encoder($data->id)}}`)"><i class="fa fa-clone"></i> Cetak RABOP</button>
                  </div> -->
                  @endif
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Project</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Draft Pengadaan</a></li>
                      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Publish Pengadaan</a></li>
                      
                     
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane active" id="tab_1">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Rencana Pekerjaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Customer Cost Center</label>

                            <div class="col-sm-2">
                              <div class="input-group">
                                <input type="text" id="customer_code" name="cost" readonly value="{{$data->cost_center_project}}" class="form-control  input-sm" placeholder="0000">
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" id="customer" readonly class="form-control input-sm"  value="({{$data->customer_code}}) {{$data->customer}}" placeholder="Ketik...">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ruang Lingkup Project</label>
                              <div class="col-sm-10">
                              <input  class="form-control input-sm" readonly name="deskripsi_project" value="{{$data->deskripsi_project}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Kategori Project</label>
                                    <div class="col-sm-5">
                                    <input  class="form-control input-sm" readonly  value="{{$data->kategori_project}}" placeholder="Ketik..." >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Project Manager (PM)</label>

                                  <div class="col-sm-3">
                                    <div class="input-group">
                                      <input type="text" id="nik_pm" name="cost" readonly value="{{$data->nik_pm}}" class="form-control  input-sm" placeholder="0000">
                                    </div>
                                  </div>
                                  <div class="col-sm-5">
                                    <input type="text" id="nama_pem" readonly class="form-control input-sm"  value="{{$data->nama_pem}}" placeholder="Ketik...">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Durasi (Start / End)</label>

                                  <div class="col-sm-4">
                                    <div class="input-group">
                                      <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                      <input type="text" id="start_date" name="start_date" readonly value="{{$data->start_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="input-group">
                                      <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                      <input type="text" id="end_date" name="end_date" readonly value="{{$data->end_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                                    </div>
                                  </div>
                                  
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                  $rencanaall=(sum_biaya_jasa_kontrak($data->id)+sum_biaya_operasional_kontrak($data->id)+sum_biaya_operasional_kontrak($data->id));
                                  $permaterial=round((sum_biaya_material_kontrak($data->id)/$data->nilai_project)*100);
                                  $peroperasional=round((sum_biaya_operasional_kontrak($data->id)/$data->nilai_project)*100);
                                  $perjasa=round((sum_biaya_jasa_kontrak($data->id)/$data->nilai_project)*100);
                                  $allcost=$permaterial+$permaterial+$perjasa;
                                  $revenue=100-($permaterial+$permaterial+$perjasa);

                                ?>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Nilai Project</label>

                                  <div class="col-sm-5">
                                    <div class="input-group">
                                      <input type="text"  readonly value="{{uang($data->nilai_project)}}" class="form-control  input-sm text-right" placeholder="0000">
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Operasional Cost ({{$peroperasional}}%)</label>

                                  <div class="col-sm-5">
                                    <div class="input-group">
                                      <input type="text"  readonly value="{{uang(sum_biaya_operasional_kontrak($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Material Cost ({{$permaterial}}%)</label>

                                  <div class="col-sm-5">
                                    <div class="input-group">
                                      <input type="text"  readonly value="{{uang(sum_biaya_material_kontrak($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Jasa Cost ({{$perjasa}}%)</label>

                                  <div class="col-sm-5">
                                    <div class="input-group">
                                      <input type="text"  readonly value="{{uang(sum_biaya_jasa_kontrak($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Total Pembiayaan  ({{$allcost}}%)</label>

                                  <div class="col-sm-5">
                                    <div class="input-group">
                                      <input type="text"  readonly value="{{uang(sum_operasional($data->id)+sum_material($data->id))}}" class="form-control  input-sm text-right" placeholder="0000">
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-4 control-label">Revenue ({{$revenue}}%)</label>

                                  <div class="col-sm-5">
                                    <div class="input-group">
                                      <input type="text"  readonly value="{{uang($data->nilai_project-(sum_operasional($data->id)+sum_material($data->id)))}}" class="form-control  input-sm text-right" placeholder="0000">
                                    </div>
                                  </div>
                                  
                                </div>
                            </div>
                          </div>
                          
                          
                          
                          
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_2">
                       
                        <div class="row" style="padding:1%">
           
                          <div class="col-md-4" style="line-height: 6;">
                            
                            <button type="button" class="btn btn-primary btn-sm" onclick="proses_pengadaan()"><i class="fa fa-plus"></i>Pengadaan (PG)</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="proses_ready()"><i class="fa fa-plus"></i> Ready (RD)</button>
                
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>Status Aset</label>
                              <select  class="form-control  input-sm" id="cari_status_aset" placeholder="0000">
                                  <option value="">All Status--</option>
                                  @foreach(get_status_aset() as $emp)
                                    <option value="{{$emp->id}}" @if($data->status_aset_id==$emp->id) selected @endif >{{$emp->id}} - {{$emp->nama_aset}}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label>Status Material</label>
                              <select  class="form-control  input-sm" id="cari_status_material" placeholder="0000">
                                  <option value="">All Status--</option>
                                  
                                      <option value="2"  >Pengadaan</option>
                                      <option value="3"  >Stok</option>
                                  
                              </select>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label>Cari data</label>
                                <input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
                                
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            
                              <table id="data-table-fixed-header" width="100%" class="cell-border display">
                                  <thead>
                                      <tr>
                                          <th width="5%">No</th>
                                          
                                          <th width="2%"></th>
                                          <th width="2%"></th>
                                          <th width="6%">STS</th>
                                          <!-- <th width="6%">Aset</th> -->
                                          <th>Material</th>
                                          <th width="7%">Qty</th>
                                          <th width="9%">Satuan</th>
                                          <th width="9%">H.Satuan</th>
                                          <th width="9%">H.Total</th>
                                          
                                      </tr>
                                  </thead>
                                  
                              </table>
                            
                          </div>
                        </div>
                          
                        
                      </div>
                      <div class="tab-pane" id="tab_3">
                       
                        <div class="row" style="padding:1%">
           
                          <div class="col-md-4" >
                            
                            <button type="button" class="btn btn-primary btn-sm" onclick="proses_pengadaan()"><i class="fa fa-plus"></i> Proses Pengadaan</button>
                
                          </div>
                          <div class="col-md-2">
                            
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            
                              <table id="data-table-fixed-header-pengadaan" width="100%" class="cell-border display">
                                  <thead>
                                      <tr>
                                          <th width="5%">No</th>
                                          
                                          <th width="2%"></th>
                                          <th width="5%"></th>
                                          <th>Material</th>
                                          <th width="7%">Qty</th>
                                          <th width="9%">H.Satuan</th>
                                          <th width="9%">H.Total</th>
                                          
                                      </tr>
                                  </thead>
                                  
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
      <div class="modal fade" id="modal-form" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Review Material</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="mydatamaterial" method="post" action="{{ url('projectcontrol/store_task') }}" enctype="multipart/form-data" >
                  @csrf
                    <input type="hidden" name="project_header_id" value="{{$data->id}}">
                    <div id="tampil-form"></div>
                </form>
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button  class="btn btn-info pull-right" onclick="simpan_data()" >Simpan Task</button>
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
       function show_detail(id){
          $('#modal-form').modal('show');
          $('#tampil-form').load("{{url('pengadaan/modal_verifikasi')}}?id="+id);
       }
       $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}");
       $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}&act=1");
       $('#tampil-material-save').load("{{url('project/tampil_material')}}?id={{$data->id}}&act=1");
       
       function delete_pengadaan(id,ide,tipe){
           
           swal({
               title: "Yakin melakukan cancel ?",
               text: "",
               type: "warning",
               icon: "error",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-danger",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                       $.ajax({
                           type: 'GET',
                           url: "{{url('pengadaan/delete')}}",
                           data: "id="+id+"&ide="+ide+"&tipe="+tipe,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-fixed-header').DataTable();
                                    tables.ajax.url("{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}").load();
                               var tablesm=$('#data-table-fixed-header-pengadaan').DataTable();
                                  tablesm.ajax.url("{{ url('pengadaan/getdatapengadaan')}}?cost_center={{$data->cost_center_project}}").load();
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
       function simpan_data(){
            
            var form=document.getElementById('mydatamaterial');
            $.ajax({
                type: 'POST',
                url: "{{ url('pengadaan/store_material') }}",
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
                        swal("Success! berhasil disimpan!", {
                            icon: "success",
                        });
                        $('#modal-form').modal('hide');
                        $('#tampil-form').html("");
                        var tables=$('#data-table-fixed-header').DataTable();
                        tables.ajax.url("{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}").load();
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
        function proses_pengadaan(){
            
            var form=document.getElementById('material');
            $.ajax({
                type: 'POST',
                url: "{{ url('pengadaan/store_pengadaan') }}",
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
                        swal("Success! berhasil disimpan!", {
                            icon: "success",
                        });
                        $('#modal-form').modal('hide');
                        $('#tampil-form').html("");
                        var tables=$('#data-table-fixed-header').DataTable();
                            tables.ajax.url("{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}").load();
                        var tablesm=$('#data-table-fixed-header-pengadaan').DataTable();
                            tablesm.ajax.url("{{ url('pengadaan/getdatapengadaan')}}?cost_center={{$data->cost_center_project}}").load();
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
        function proses_ready(){
            
            var form=document.getElementById('material');
            $.ajax({
                type: 'POST',
                url: "{{ url('pengadaan/store_ready') }}",
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
                        swal("Success! berhasil disimpan!", {
                            icon: "success",
                        });
                        $('#modal-form').modal('hide');
                        $('#tampil-form').html("");
                        var tables=$('#data-table-fixed-header').DataTable();
                            tables.ajax.url("{{ url('pengadaan/getdatamaterial')}}?id={{$data->id}}").load();
                        var tablesm=$('#data-table-fixed-header-pengadaan').DataTable();
                            tablesm.ajax.url("{{ url('pengadaan/getdatapengadaan')}}?cost_center={{$data->cost_center_project}}").load();
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
