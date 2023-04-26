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
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('projectcontrol/getdatatask')}}?id={{$data->id}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'add' },
                        { data: 'task' },
                        { data: 'progresnya',className: "text-center" },
                        { data: 'duedate' ,className: "text-center" },
                        { data: 'status_now' },
                        { data: 'status_task' },
                        
                      ],
                      
                });
                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                });

                var tablematerial=$('#data-table-fixed-header-material').DataTable({
                    lengthMenu: [10,50,100],
                    searching:true,
                    lengthChange:true,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('material/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'seleksi' },
                        { data: 'kode_material' },
                        { data: 'nama_material' },
                        { data: 'harga' },
                        { data: 'satuan' },
                        // { data: 'stok' },
                        
                      ],
                      
                });

                
            });
        

        function show_hide(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('projectcontrol/getdatatask')}}?id={{$data->id}}").load();
        }
        function refresh_data(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('projectcontrol/getdatatask')}}?id={{$data->id}}").load();
        }
        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Project Control
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Project Control</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row" id="tampil-dashboard-role">
        
      </div>
      <div class="box box-default">
        <div class="box-header with-border">
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-default" onclick="refresh_data()"  title="Refresh Page"><i class="fa fa-refresh"></i> Refresh</button>
          </div>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-body" id="dashboard-task">
          
        </div>
        
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Task Pekerjaan</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Material Cost</a></li>
            
            
            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
          </ul>
          <div class="tab-content" style="background: #fff3f3;">
            <div class="tab-pane active" id="tab_1">
              <!-- /.box-header -->
              <div class="box-header with-border">
                <div class="row">
                  <div class="col-md-6">
                    <div class="btn-group" style="margin-top:5%">
                      <button type="button" class="btn btn-success btn-sm" onclick="tambah(0)"><i class="fa fa-plus"></i> Buat Task Pekerjaan</button>
                    </div>
                    
                  </div>
                  <div class="col-md-2">
                    <!-- <div class="form-group">
                      <label>Divisi</label>
                        <select onchange="pilih_jenis(this.value)" class="form-control  input-sm">
                          <option value="">All Data</option>
                          
                        </select>
                    
                    </div> -->
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Cari data</label>
                        <input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
                        
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-body">
                <div class="row">
                
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="data-table-fixed-header" class="cell-border display">
                          <thead>
                              <tr>
                                  <th width="5%">No</th>
                                  
                                  <th width="5%"></th>
                                  <th width="2%"></th>
                                  <th>Task</th>
                                  <th width="5%">Progres</th>
                                  <th width="15%">Date</th>
                                  <th width="8%">Time</th>
                                  <th width="8%">Status</th>
                                  
                              </tr>
                          </thead>
                          
                      </table>
                    </div>
                  </div>
                  
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
              </div>
            </div>
            <div class="tab-pane" id="tab_2">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label" style="margin: 20px 0px 20px 0px !important;" id="header-label"><i class="fa fa-bars"></i> Material Cost</label>

                  </div>
                  <div class="form-group">
                      
                      <div class="col-sm-12" style="padding: 0px;">
                        <div class="btn-group" >
                            <button type="button" class="btn btn-success btn-sm" onclick="tambah_material(0)"><i class="fa fa-plus"></i> Tambah Material</button>
                        </div>
                        <table class="table table-bordered" id="">
                          
                          <thead>
                            <tr style="background:#bcbcc7">
                              <th style="width: 10px">No</th>
                              <th style="width:6%">Kode</th>
                              <th>Material</th>
                              <th style="width:6%">Qty</th>
                              
                              <th style="width:9%">H Satuan</th>
                              <th style="width:9%">Total</th>
                              <th style="width:5%">Sts</th>
                              <th style="width:5%">Aset</th>
                              <th style="width:9%">Ready</th>
                              <th style="width:6%">Act</th>
                            </tr>
                          </thead>
                          
                          <tbody id="tampil-material-save"></tbody>
                          
                        </table>
                      </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
      <!-- /.box -->

    </section>
      <div class="modal fade" id="modal-form" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Task Form</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="mydata" method="post" action="{{ url('projectcontrol/store_task') }}" enctype="multipart/form-data" >
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
      <div class="modal fade" id="modal-draftmaterial" style="display: none;z-index: 3050;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Show Material</h4>
            </div>
            <div class="modal-body">
              <input type="text" id="no-material">
              <div class="table-responsive">
                  <table id="data-table-fixed-header-material" width="100%" class="cell-border display">
                      <thead>
                          <tr>
                              <th width="5%">No</th>
                              
                              <th width="5%"></th>
                              <th>Kode</th>
                              <th>Nama material</th>
                              <th width="15%">Harga</th>
                              <th width="8%">Satuan</th>
                              <!-- <th width="8%">Stok</th> -->
                          </tr>
                      </thead>
                      
                  </table>
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-material" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Form Material</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="mydatamat" method="post" action="{{ url('projectcontrol/store_task') }}" enctype="multipart/form-data" >
                  @csrf
                  <input type="text" name="project_header_id" value="{{$data->id}}">
                  <div id="tampil-material"></div>
                </form>
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button  class="btn btn-info pull-right" onclick="simpan_material()" >Simpan Progres</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-progres" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Task Form</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="mydataprogres" method="post" action="{{ url('projectcontrol/store_task') }}" enctype="multipart/form-data" >
                  @csrf
                  <input type="hidden" name="project_header_id" value="{{$data->id}}">
                  <div id="tampil-progres"></div>
                </form>
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button  class="btn btn-info pull-right" onclick="simpan_progres()" >Simpan Progres</button>
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
      function tambah(id){
        $('#modal-form').modal('show');
        $('#tampil-form').load("{{url('projectcontrol/modal_task')}}?project_header_id={{$data->id}}&id="+id);

      }
      function pilih_material(kode_material,nama_material,harga,stok){

     
        $('#modal-draftmaterial').modal('hide');
        $('#nama_material').val(nama_material);
        $('#kode_material').val(kode_material);
        $('#harga_material').val(harga);
        $('#normal_harga_material').val(harga);
        $('#qty').val(0);
        $('#total').val(0);
        $('#stok').val(stok);

      }

      function show_material(){
        $('#modal-draftmaterial').modal('show');
       
      }
      function tambah_material(id){
        $('#modal-material').modal({backdrop: 'static', keyboard: false});
        $('#tampil-material').load("{{url('projectcontrol/form_material')}}?project_header_id={{$data->id}}&id="+id);

      }
      $('#tampil-material-save').load("{{url('pengadaan/tampil_material')}}?id={{$data->id}}&act=1");
      $('#dashboard-task').load("{{url('pengadaan/dashboard_task')}}?id={{$data->id}}&act=1");
      function show_progres(id){
        $('#modal-progres').modal('show');
        $('#tampil-progres').load("{{url('projectcontrol/modal_progres')}}?id="+id);

      }
      function delete_data(id,act){
           
           swal({
               title: "Yakin menghapus data ini ?",
               text: "data akan hilang dari data  ini",
               type: "warning",
               icon: "error",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-danger",
               confirmButtonText: "Yes, delete it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                    if(act=='0'){
                       $.ajax({
                           type: 'GET',
                           url: "{{url('customer/delete')}}",
                           data: "id="+id+"&act="+act,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-fixed-header').DataTable();
                                  tables.ajax.url("{{ url('customer/getdata')}}").load();
                           }
                       });
                   
                    }else{
                      $.ajax({
                           type: 'GET',
                           url: "{{url('customer/delete')}}",
                           data: "id="+id+"&act="+act,
                           success: function(msg){
                               swal("Success! berhasil ditampilkan!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-fixed-header').DataTable();
                                  tables.ajax.url("{{ url('customer/getdata')}}?hide=1").load();
                           }
                       });
                    }
               } else {
                   
               }
           });
           
       } 
       
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            $.ajax({
                type: 'POST',
                url: "{{ url('projectcontrol/store_task') }}",
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
                            tables.ajax.url("{{ url('projectcontrol/getdatatask')}}?id={{$data->id}}").load();
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
        function simpan_material(){
            
            var form=document.getElementById('mydatamat');
            $.ajax({
                type: 'POST',
                url: "{{ url('pengadaan/store_material_pm') }}",
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
                        $('#modal-material').modal('hide');
                        $('#tampil-material').html("");
                        $('#tampil-material-save').load("{{url('pengadaan/tampil_material')}}?id={{$data->id}}&act=1");
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

        function simpan_progres(){
            
            var form=document.getElementById('mydataprogres');
            $.ajax({
                type: 'POST',
                url: "{{ url('projectcontrol/store_progres') }}",
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
                        $('#modal-progres').modal('hide');
                        $('#tampil-progres').html("");
                        $('#dashboard-task').load("{{url('pengadaan/dashboard_task')}}?id={{$data->id}}&act=1");
                        var tables=$('#data-table-fixed-header').DataTable();
                            tables.ajax.url("{{ url('projectcontrol/getdatatask')}}?id={{$data->id}}").load();
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
