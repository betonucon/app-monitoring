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
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('employe/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'nik' },
                        { data: 'nama' },
                        { data: 'jabatan' },
                        { data: 'role' },
                        
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

        
        function load_data(){  
              $.getJSON("{{ url('employe/getrole')}}", function(data){
                  $.each(data, function(i, result){
                      $("#tampil-dashboard-role").append(result.action);
                  });
              });
        }

        $(document).ready(function() {
          TableManageFixedHeader.init();
          load_data().load();     
        });

        function show_hide(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('employe/getdata')}}?hide=1").load();
        }
        function refresh_data(){
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('employe/getdata')}}").load();
        }
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mst Barang
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barang</li>
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
                <button type="button" class="btn btn-success btn-sm" onclick="location.assign(`{{url('employe/view')}}?id={{encoder(0)}}`)"><i class="fa fa-plus"></i> Buat Baru</button>
                
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
                <table id="data-table-fixed-header" class="cell-border display">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="5%"></th>
                            <th width="15%">NIK</th>
                            <th>Nama</th>
                            <th width="15%">Jabatan</th>
                            <th width="15%">Otorisasi</th>
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
    <!-- /.content -->
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
                           url: "{{url('employe/delete')}}",
                           data: "id="+id+"&act="+act,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-fixed-header').DataTable();
                                  tables.ajax.url("{{ url('employe/getdata')}}").load();
                           }
                       });
                   
                    }else{
                      $.ajax({
                           type: 'GET',
                           url: "{{url('employe/delete')}}",
                           data: "id="+id+"&act="+act,
                           success: function(msg){
                               swal("Success! berhasil ditampilkan!", {
                                   icon: "success",
                               });
                               var tables=$('#data-table-fixed-header').DataTable();
                                  tables.ajax.url("{{ url('employe/getdata')}}?hide=1").load();
                           }
                       });
                    }
                    $("#tampil-dashboard-role").load(); 
               } else {
                   
               }
           });
           
      }   
    </script>   
@endpush
