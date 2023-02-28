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
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Kontrak</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> RAB</a></li>
                      <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li> -->
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane active" id="tab_1">
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
                      <div class="tab-pane" id="tab_3" >
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
            </div>
                 
        </div>
        
      </div>
     

    </section>
      <div class="modal fade" id="modal-draf" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Header Cost</h4>
            </div>
            <div class="modal-body">
              
                <table id="data-table-fixed-header" width="100%" class="cell-border display">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="15%">Cost</th>
                            <th width="20%">Cust Code</th>
                            <th width="30%" >Nama Customer</th>
                            <th >Area</th>
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
       
        
        
        $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
        $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}&act=1");
        $('#tampil-personal-save').load("{{url('kontrak/tampil_personal')}}?id={{$data->id}}&act=1");
        $(document).ready(function(e) {
          $('#save-personal').hide();
          $('#save-operasional').hide();
          var nom = {{$nom}};
            $("#add").click(function(){
                var no = nom++;
                $("#tampil_personal").append('<tr style="background:#fff" class="added">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><input type="text" name="nik[]" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><input type="text" name="nama[]" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><select name="job_id[]" placeholder="ketik disini.." class="form-control  input-sm">'
                                                +'<option value="">Pilih Job---</option>'
                                                @foreach(get_job() as $jb)
                                                  +'<option value="{{$jb->id}}">{{$jb->job}}</option>'
                                                @endforeach
                                              +'</select></td>'
                                              +'<td><input type="text" name="nilai[]" id="nilainya'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_add"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $("#nilainya"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0){
                  $('#save-personal').show();
                }                           
            });
           
        });
        $(document).on('click', '.remove_add', function(){  
            $(this).parents('.added').remove();
        }); 

        $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}&act=1");
        $(document).ready(function(e) {
          var nom = {{$nomper}};
            $("#addoperasional").click(function(){
                var no = nom++;
                $("#tampil_operasional").append('<tr style="background:#fff" class="addoperasional">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><input type="text" name="keterangan[]" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><input type="text" name="biaya[]" id="biayanya'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_operasional"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $("#biayanya"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0){
                  $('#save-operasional').show();
                } 
            });
        });
        $(document).on('click', '.remove_operasional', function(){  
            $(this).parents('.addoperasional').remove();
        }); 

        
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        $("#margin").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 1, 'digitsOptional': false });
        $(document).ready(function(){

          $("#nilai").keyup(function(){
            var angkane=$("#nilai").val();
            var nil = angkane.replace(/[.](?=.*?\.)/g, '');
            var nilai=parseFloat(nil.replace(/[^0-9.]/g,''))
            $("#out").val(terbilang(nilai));

          });

        });


        function delete_data(id){
           
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
                            url: "{{url('barang/hapus_foto')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                $('#tampil-foto').load("{{url('barang/modal_foto')}}?KD_Barang={{$data->KD_Barang}}");
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 
        function delete_personal(id){
           
            swal({
                title: "Yakin menghapus personal ini ?",
                text: "data akan hilang dari daftar personal",
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
                            url: "{{url('kontrak/delete_personal')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
                                $('#tampil-personal-save').load("{{url('kontrak/tampil_personal')}}?id={{$data->id}}&act=1");
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 
        function delete_operasional(id){
           
            swal({
                title: "Yakin menghapus operasional ini ?",
                text: "data akan hilang dari daftar operasional",
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
                            url: "{{url('kontrak/delete_operasional')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
                                $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}&act=1");
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 
        function show_draft(){
           
            $('#modal-draf').modal('show');
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('cost/getdata')}}?customer_code={{$data->customer_code}}").load();
        }  
        function pilih_customer(cost,customer_code,customer,area){
           
           $('#modal-draf').modal('hide');
           $('#cost').val(cost);
           $('#area_cost').val(area);
           
       } 
       
       function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('kontrak') }}",
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
                              title: "Success! RAB Berhasil diproses!",
                              icon: "success",
                            });
                            location.assign("{{url('kontrak')}}");
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
        function simpan_personal(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('kontrak/store_personal') }}",
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
                              title: "Success! berhasil upload!",
                              icon: "success",
                            });
                            $("#tampil_personal").html('');
                            $('#save-personal').hide();
          
                            $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
                            $('#tampil-personal-save').load("{{url('kontrak/tampil_personal')}}?id={{$data->id}}&act=1");
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
        function simpan_operasional(){
          
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('kontrak/store_operasional') }}",
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
                              title: "Success! berhasil upload!",
                              icon: "success",
                            });
                            $('#save-operasional').hide();
                            $("#tampil_operasional").html('');
                            $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
                            $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}&act=1");
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
