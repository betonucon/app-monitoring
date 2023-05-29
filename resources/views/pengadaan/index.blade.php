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
                    searching:true,
                    lengthChange:false,
                    ordering:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('pengadaan/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'cost_center_project' ,className: "text-center" },
                        { data: 'customer' },
                        { data: 'deskripsi_project' },
                        { data: 'total' ,className: "text-center" },
                        { data: 'total_note' ,className: "text-center" },
                        { data: 'total_pengadaan' ,className: "text-center" },
                        { data: 'total_ready' ,className: "text-center" },
                        { data: 'updated_at' ,className: "text-left" },
                        
                      ],
                      
                });
                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })

                
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

        function show_hide(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('projectcontrol/getdatatask')}}?id={{$data->id}}").load();
        }
        function refresh_data(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('customer/getdata')}}").load();
        }
        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Draft Pengadaan
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Draft Pengadaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row" id="tampil-dashboard-role">
        
      </div>
      <div class="box box-default">
        <div class="box-header with-border">
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-default" onclick="show_hide()" title="Log Hidden"><i class="fa fa-trash-o"></i></button>
            <button type="button" class="btn btn-sm btn-default" onclick="refresh_data()"  title="Refresh Page"><i class="fa fa-refresh"></i></button>
            <button type="button" class="btn btn-sm btn-default"><i class="fa fa-cog"></i></button>
          </div>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-3">
              <!-- <div class="form-group">
                <label>Divisi</label>
                  <select onchange="pilih_jenis(this.value)" class="form-control  input-sm">
                    <option value="">All Data</option>
                    
                  </select>
               
              </div> -->
            </div>
            <div class="col-md-5">
              <ul class="nav nav-stacked">
                <li><a href="#" class="li-dashboard"><b>TA</b> = Total Material</span></a></li>   
                <li><a href="#" class="li-dashboard"><b>NT</b> = Total Material Belum Diproses</span></a></li>   
                <li><a href="#" class="li-dashboard"><b>PG</b> = Total Material Proses Pengadaan</span></a></li>   
                <li><a href="#" class="li-dashboard"><b>RD</b> = Total Material Siap didistribusikan</span></a></li>   
              </ul>
              
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                  <label>Cari data</label>
                  <input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
                  
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
           
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="data-table-fixed-header" class="table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="5%"></th>
                            <th width="10%">Cost Center</th>
                            <th width="20%">Customer</th>
                            
                            <th>Project</th>
                           
                            <th width="5%">TA</th>
                            <th width="5%">NT</th>
                            <th width="5%">PG</th>
                            <th width="5%">RD</th>
                            <th width="10%">Updated</th>
                            
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
