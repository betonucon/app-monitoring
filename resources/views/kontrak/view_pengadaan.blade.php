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
                        { data: 'stok' },
                        
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
              <input type="hidden" name="id" value="{{$data->id}}">
              <div class="row">
              
                <div class="col-md-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Kontrak</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> RAB</a></li>
                      <li class="active"><a href="#tab_4" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Pengadaan Material</a></li>
                      <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li> -->
                      
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                      <div class="tab-pane" id="tab_1">
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
                      <div class="tab-pane active" id="tab_4">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-12 control-label" id="header-label-material"><i class="fa fa-bars"></i> Material Project</label>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-12" style="margin-left: 0%;">
                            <span class="btn btn-info btn-sm" id="addmaterial"><i class="fa fa-plus"></i> Add Material</span>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th style="width:15%">Kode</th>
                                    <th>Material</th>
                                    <th style="width:8%">Stok</th>
                                    <th style="width:15%">H.Satuan</th>
                                    <th style="width:8%">Qty</th>
                                    <th style="width:10%">Order</th>
                                    <th style="width:15%">Total</th>
                                    <th style="width:5%"></th>
                                  </tr>
                                </thead>
                                <tbody id="tampil_material"></tbody>
                                <tbody id="save-material">
                                  <tr>
                                      <td colspan="6"><span class="btn btn-success btn-sm" onclick="simpan_material()">Save Material</span>
                                  </tr>
                                </tbody>
                                <tbody id="tampil-material-save"></tbody>
                                
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                  
                </div>
                
                
              </div>
          </form>
        </div>
        <div class="box-footer">
        
          <div class="btn-group">
              <button type="button" class="btn btn-sm btn-info" onclick="simpan_data()"><i class="fa fa-save"></i> Simpan</button>
              <button type="button" class="btn btn-sm btn-danger" onclick="location.assign(`{{url('projectcontrol')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
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
              <h4 class="modal-title">Show Material</h4>
            </div>
            <div class="modal-body">
              <input type="text" id="no-draf">
              <div class="table-responsive">
                  <table id="data-table-fixed-header" width="100%" class="cell-border display">
                      <thead>
                          <tr>
                              <th width="5%">No</th>
                              
                              <th width="5%"></th>
                              <th width="10%">Kode</th>
                              <th>Nama material</th>
                              <th width="15%">Harga</th>
                              <th width="8%">Satuan</th>
                              <th width="8%">Stok</th>
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
  </div>
@endsection

@push('ajax')
<script> 
       
        
        
       $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}&act=1");
       $('#tampil-risiko-save').load("{{url('project/tampil_risiko_view')}}?id={{$data->id}}&act=1");
       $('#tampil-personal-save').load("{{url('kontrak/tampil_personal')}}?id={{$data->id}}&act=1");
       $('#tampil-catatan').hide()

       function approve_data(){
         $('#modal-approve').modal('show')
       }

       function pilih_status(id){
         if(id==8){
           $('#tampil-catatan').show()
         }else{
           $('#tampil-catatan').hide()
         }
         
       }
       

       $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}&act=1");
       $('#save-material').hide();
       $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
       $("#margin").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 1, 'digitsOptional': false });
       
       $('#tampil-material-save').load("{{url('kontrak/tampil_material')}}?id={{$data->id}}");
        $(document).ready(function(e) {
          var nom = {{$nommat}};
            $("#addmaterial").click(function(){
                var no = nom++;
                $("#tampil_material").append('<tr style="background:#fff" class="addmaterial">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><div class="input-group"><span class="input-group-addon" onclick="show_material('+no+')"><i class="fa fa-search"></i></span><input type="text" readonly id="kode_material'+no+'"  name="kode_material[]" placeholder="ketik disini.." class="form-control  input-sm"></div></td>'
                                              +'<td><input type="text" name="nama_material[]"  readonly  id="nama_material'+no+'" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><input type="text" name="stok[]" readonly id="stok'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td><input type="text" name="biaya[]"  readonly  id="harga_material'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<input type="text"   readonly  id="normal_harga_material'+no+'" placeholder="ketik disini.." class="form-control input-sm">'
                                              +'<td><input type="text" name="qty[]" id="qtynya'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td><select name="status_material_id[]" placeholder="ketik disini.." class="form-control  input-sm">'
                                                +'<option value="">status--</option>'
                                                @foreach(get_status_material() as $jb)
                                                  +'<option value="{{$jb->id}}">{{$jb->status_material}}</option>'
                                                @endforeach
                                              +'</select></td>'
                                              +'<td><input type="text" name="total[]" id="total'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_material"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $("#harga_material"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                                            $("#total"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                                            $("#qtynya"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                                            $("#stok"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0){
                  $('#save-material').show();
                } 
            });
        });
        $(document).on('click', '.remove_material', function(){  
            $(this).parents('.addmaterial').remove();
        });
        function show_material(no){

          $('#no-draf').val(no);
          $('#modal-draf').modal('show');
          var tables=$('#data-table-fixed-header').DataTable();
              tables.ajax.url("{{ url('material/getdata')}}").load();
        }
        function pilih_material(kode_material,nama_material,harga,stok){

          var no=$('#no-draf').val();
          $('#modal-draf').modal('hide');
          $('#nama_material'+no).val(nama_material);
          $('#kode_material'+no).val(kode_material);
          $('#harga_material'+no).val(harga);
          $('#normal_harga_material'+no).val(harga);
          $('#stok'+no).val(stok);
          
        }
        function delete_material(id){
           
           swal({
               title: "Yakin menghapus materiall ini ?",
               text: "data akan hilang dari daftar material",
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
                           url: "{{url('kontrak/delete_material')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-material-save').load("{{url('kontrak/tampil_material')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
       }
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('kontrak/store_pengadaan') }}",
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
        }
        function simpan_material(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('kontrak/store_material') }}",
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
                              title: "Success! berhasil disimpan!",
                              icon: "success",
                            });
                            $("#tampil_material").html('');
                            $('#save-material').hide();
          
                            $('#tampil_pengeluaran').load("{{url('kontrak/tampil_pengeluaran')}}?id={{$data->id}}");
                            $('#tampil-material-save').load("{{url('kontrak/tampil_material')}}?id={{$data->id}}");
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
