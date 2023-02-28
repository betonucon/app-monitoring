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
                    searching:false,
                    paging:false,
                    ordering:false,
                    info:false,
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('project/getdatamaterial')}}?id={{$id}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { data: 'action' },
                        { data: 'kode_material' },
                        { data: 'nama_material' },
                        { data: 'qty' },
                        
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

        var handleDataTableFixedmaterialHeader = function() {
            "use strict";
            
            if ($('#data-table-fixedmaterial-header').length !== 0) {
                var table=$('#data-table-fixedmaterial-header').DataTable({
                    searching:true,
                    paging:false,
                    ordering:false,
                    info:false,
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('material/getdata')}}",
                      columns: [
                        { data: 'seleksi',width: '100'},
                        { data: 'kode_material' },
                        { data: 'nama_material' },
                        
                      ],
                      columnDefs: [
                        { "width": "5%", "targets": 0 }
                      ]
                      
                });
                
                
            }
        };

        var TableManageFixedmaterialHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedmaterialHeader();
                }
            };
        }();

        
        $(document).ready(function() {
          TableManageFixedHeader.init();
          TableManageFixedmaterialHeader.init();
           
        });

        
        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Display Project
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Display Project</li>
      </ol>
    </section>
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> COST : {{$data->cost_center}}
            <small class="pull-right">Date: {{$data->tgl_send_komersil}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
          From
          <address>
            <strong>{{$data->nama_kadis}} ({{$data->jabatan_kadis}})</strong><br>
            {{alamat()}}<br>
            
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-7 invoice-col">
          
            <table class="table">
              <tbody>
                <tr>
                  <th style="width:30%">Customer:</th>
                  <td>{{$data->customer}}</td>
                </tr>
                <tr>
                  <th>Cost Area</th>
                  <td>{{$data->area}}</td>
                </tr>
                <tr>
                  <th>Start End Date:</th>
                  <td>{{$data->start_date}} s/d {{$data->end_date}}</td>
                </tr>
                @if(in_array(Auth::user()->role_id,array(1,2,3,4,5,6,7)))
                <tr>
                  <th>Nilai Kontrak</th>
                  <td>{{uang($data->nilai)}}</td>
                </tr>
                <tr>
                  <th></th>
                  <td><i>{{$data->terbilang}}</i></td>
                </tr>
                @endif
                <tr>
                  <th>File Kontrak:</th>
                  <td><a href="javascript:;" onclick="show_file(`{{$data->file_kontrak}}`)" class="btn btn-xs btn-success"><i class="fa fa-file-pdf-o"></i> Download File</a></td>
                </tr>
              </tbody>
          </table>
          
        </div>
        
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        @if($data->status_id==2)
        <div class="col-md-12">
          <form class="form-horizontal" id="mydata" method="post" action="{{ url('project/store_material') }}" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                
                <div class="col-md-8" >
                  
                    <div class="box-body" style="background: #f0f0f7; border: solid 1px #94db94; border-bottom: solid 0px #94db94;">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Material</label>

                        <div class="col-sm-3">
                          <div class="input-group">
                            <span class="input-group-addon" onclick="show_draft()"><i class="fa fa-search"></i></span>
                            <input type="text" id="kode_material" name="kode_material" readonly class="form-control  input-sm" placeholder="0000">
                          </div>
                        </div>
                        <div class="col-sm-7">
                          <input type="text" id="nama_material" readonly class="form-control input-sm"  value="{{$data->nama_material}}" placeholder="Ketik...">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Qty</label>

                        <div class="col-sm-2">
                          <input type="text" name="qty" class="form-control input-sm" id="qty"  value="{{$data->qty}}" placeholder="Ketik...">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"></label>

                        <div class="col-sm-2">
                            <span class="btn btn-primary btn-xs" onclick="simpan_data()">Simpan</span>
                        </div>
                      </div>
                      
                      
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                <div class="col-md-4" >
                  
                    <div class="box-body" id="tampil_item" style="background: #f0f0f7; border: solid 1px #94db94; border-bottom: solid 0px #94db94;">
                      
                    </div>
                  
                </div>
                
                
              </div>
          </form>
        </div>
        @else

        @endif
        <div class="col-xs-12 table-responsive-mobile">
              <div >
                <table id="data-table-fixed-header"  class="cell-border display">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="7%"></th>
                            <th width="10%">Kode</th>
                            <th >Material</th>
                            <th width="10%">Qty</th>
                        </tr>
                    </thead>
                    
                </table>
              </div>
        </div>
        <!-- /.col -->
      </div>
      
      @if($data->status_id==2)
      <div class="row no-print" style="margin-top:2%">
        <div class="col-xs-12">
          <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <span class="btn btn-success pull-right" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</span>
          <span class="btn btn-primary pull-right" onclick="send_to()" style="margin-right: 5px;"><i class="fa fa-send-o"></i> Lanjutkan Proses</span>
          <span class="btn btn-primary pull-right" onclick="kembali_komersil()" style="margin-right: 5px;"><i class="fa fa-send-o"></i> Kembalikan Proses</span>
        </div>
      </div>
      @endif
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

    <div class="modal file" id="modal-kembali" style="display: none;">
        <div class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Alasan Pengembalian</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="mydatakembali" method="post" action="{{ url('project/kembali_komersil') }}" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" name="id" value="{{$id}}">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-10 control-label" id="header-label"><i class="fa fa-bars"></i> Keterangan</label>

              </div>
              <div class="form-group" style="margin-top:1%;margin-left:3%">
                <div class="col-sm-11">
                  <textarea  class="form-control input-sm" name="catatan" placeholder="keterangan pengembalian"  rows="5"></textarea>
                </div>
              </div>
            </form>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary pull-right" onclick="kembali_data()" >Proses</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

      <div class="modal fade" id="modal-draf" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Header Cost</h4>
            </div>
            <div class="modal-body">
              
                <table id="data-table-fixedmaterial-header" width="100%" class="cell-border display">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="15%">Kode</th>
                            <th >Material</th>
                        </tr>
                    </thead>
                    
                </table>
              
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
       
        $('#start_date').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });

        $('#tampil_item').load("{{url('project/total_item')}}?id={{encoder($id)}}");
        $('#end_date').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });

        function show_file(file){
          $('#modal-file').modal('show');
          $('#tampil_file').show();
          $('#tampil_file').html('<iframe src="{{url_plug()}}/_file_kontrak/'+file+'" height="500px" width="100%"></iframe>');
        }  

        function kembali_komersil(){
          $('#modal-kembali').modal('show');
        }  
        
        $("#qty").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        $(document).ready(function(){

          $("#nilai").keyup(function(){
          var angkane=$("#nilai").val();
          var nil = angkane.replace(/[.](?=.*?\.)/g, '');
          var nilai=parseFloat(nil.replace(/[^0-9.]/g,''))
          $("#out").val(terbilang(nilai));

        });

        });
        
        function delete_material(id){
           
            swal({
                title: "Yakin menghapus foto ini ?",
                text: "data akan hilang dari foto produk ini",
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
                            url: "{{url('project/delete_material')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                var tables=$('#data-table-fixed-header').DataTable();
                                tables.ajax.url("{{ url('project/getdatamaterial')}}?id={{$id}}").load();
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 

        function send_to(){
           
            swal({
                title: "Yakin untuk melanjutkan proses ?",
                text: "data akan lanjut ketahap berikutnya",
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
                            type: 'GET',
                            url: "{{url('project/kirim_procurement')}}",
                            data: "id={{$id}}",
                            success: function(msg){
                              var bat=msg.split('@');
                              if(bat[1]=='ok'){
                                  document.getElementById("loadnya").style.width = "0px";
                                  swal({
                                    title: "Success! berhasil kirim!",
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
                    
                    
                } else {
                    
                }
            });
            
        } 
        function show_draft(){
           
            $('#modal-draf').modal('show');
            var tables=$('#data-table-fixedmaterial-header').DataTable();
                tables.ajax.url("{{ url('material/getdata')}}").load();
        } 
        function pilih_material(kode_material,nama_material,harga){
           
            $('#modal-draf').modal('hide');
            $('#kode_material').val(kode_material);
            $('#nama_material').val(nama_material);
            
            
        } 
       
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('project/store_material') }}",
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
                            var tables=$('#data-table-fixed-header').DataTable();
                                tables.ajax.url("{{ url('project/getdatamaterial')}}?id={{$id}}").load();
                                $('#kode_material').val("");
                                $('#nama_material').val("");
                                $('#qty').val("");
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

        function kembali_data(){
            
            var form=document.getElementById('mydatakembali');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('project/kembali_komersil') }}",
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
        };
        
    </script> 
@endpush
