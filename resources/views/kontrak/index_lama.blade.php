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
                    ajax:"{{ url('project/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'file' },
                        { data: 'cost_center' },
                        { data: 'customer' },
                        { data: 'start_date' },
                        { data: 'end_date' },
                        { data: 'selisih' },
                        { data: 'area' },
                        { data: 'status_now' },
                        
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

        function pilih_jenis(KD_Divisi){
          var tables=$('#data-table-fixed-header').DataTable();
          tables.ajax.url("{{ url('barang/getdata')}}?KD_Divisi="+KD_Divisi).load();
          tables.on( 'draw', function () {
              var count=tables.data().count();
                $('#count_data').html('Total data :'+count)  
          } );
              
        }
        function load_data(){  
              $.getJSON("{{ url('project/get_status_data')}}", function(data){
                  $.each(data, function(i, result){
                      $("#tampil-dashboard-role").append(result.action);
                  });
              });
        }
        $(document).ready(function() {
          TableManageFixedHeader.init();
          load_data();     
        });

        function show_hide(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('project/getdata')}}?hide=1").load();
        }
        function refresh_data(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('project/getdata')}}").load();
        }
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cost Center
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cost Center</li>
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
            <div class="col-md-6">
              <div class="btn-group" style="margin-top:5%">
                <button type="button" class="btn btn-success btn-sm" onclick="location.assign(`{{url('project/view')}}?id={{encoder(0)}}`)"><i class="fa fa-plus"></i> Buat Baru</button>
                
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
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
           
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="data-table-fixed-header" width="120%" class="cell-border display">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="4%"></th>
                            <th width="4%">File</th>
                            <th width="10%">Cost Center</th>
                            <th width="18%">Customer</th>
                            <th width="10%">Start</th>
                            <th width="10%">End</th>
                            <th width="7%">T.Hari</th>
                            <th >Area</th>
                            <th width="10%">Status</th>
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
    
      <div class="modal file" id="modal-file" style="display: none;">
        <div class="modal-dialog modal-lg" style="max-width:70%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">File Kontrak</h4>
            </div>
            <div class="modal-body">
                <div id="tampil_file"></div>
               
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
                            url: "{{url('project/delete')}}",
                            data: "id="+id+"&act="+act,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                var tables=$('#data-table-fixed-header').DataTable();
                                    tables.ajax.url("{{ url('project/getdata')}}").load();
                            }
                        });
                    
                      }else{
                        $.ajax({
                            type: 'GET',
                            url: "{{url('project/delete')}}",
                            data: "id="+id+"&act="+act,
                            success: function(msg){
                                swal("Success! berhasil ditampilkan!", {
                                    icon: "success",
                                });
                                var tables=$('#data-table-fixed-header').DataTable();
                                    tables.ajax.url("{{ url('project/getdata')}}?hide=1").load();
                            }
                        });
                      }
                      $("#tampil-dashboard-role").load(); 
                } else {
                    
                }
            });
            
        } 
        function show_file(file){
          $('#modal-file').modal('show');
          $('#tampil_file').html('<iframe src="{{url_plug()}}/_file_kontrak/'+file+'" height="500px" width="100%"></iframe>');
        }  
    </script>   
@endpush
