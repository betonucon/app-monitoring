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
                    ajax:"{{ url('project/getdata')}}",
                    
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { data: 'seleksi' },
                        { data: 'cost_center' },
                        { data: 'customer' },
                        { data: 'deskripsi_project' },
                        
                      ],
                      
                });
                
                
            }
        };

        var handleDataTableFixedHeadermaterial = function() {
            "use strict";
            
            if ($('#data-table-fixed-header-material').length !== 0) {
                var table=$('#data-table-fixed-header-material').DataTable({
                    lengthMenu: [10,20,50,100],
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
                        
                      ],
                      
                });
                

                
            }
        };

        var TableManageFixedHeadermaterial = function () {
            "use strict";
            return {
                //main function
                init: function () {
                  handleDataTableFixedHeadermaterial();
                }
            };
        }();
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
          TableManageFixedHeadermaterial.init();
           
        });

        
        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form material
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">material</li>
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
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('material') }}" enctype="multipart/form-data" >
              @csrf
              <input type="hidden" name="id" value="{{$id}}">
              
              <div class="row">
              
                <div class="col-md-11">
                  
                    <div class="box-body">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Sumber Stok</label>

                        <div class="col-sm-4">
                            <select name="kategori_stok_id" onchange="pilih_sumber(this.value)" class="form-control  input-sm" placeholder="0000">
                              <option value="">Pilih------</option>
                              @foreach(get_kategori_stok() as $emp)
                                <option value="{{$emp->id}}" @if($data->kategori_stok_id==$emp->id) selected @endif >{{$emp->kategori_stok}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-group" id="sumber">
                        <label for="inputEmail3" class="col-sm-2 control-label">Cost Center</label>

                        <div class="col-sm-2">
                          <div class="input-group"><span class="input-group-addon" onclick="show_cost()"><i class="fa fa-search"></i></span><input type="text" readonly id="cost_center" value="{{$data->cost_center}}" name="cost_center" placeholder="ketik disini.." class="form-control  input-sm"></div>
                        </div>
                        <div class="col-sm-3">
                          <input type="hidden" name="customer_code" class="form-control input-sm" readonly  value="{{$data->customer_code}}"  id="customer_code" placeholder="Ketik...">
                          <input type="text" name="customer" class="form-control input-sm" value="{{$data->nama_customer}}" readonly id="customer" placeholder="Ketik...">
                        </div>
                        <div class="col-sm-5">
                          <input type="text" name="deskripsi_project" class="form-control input-sm" readonly  value="{{$data->deskripsi_project}}"  id="deskripsi_project" placeholder="Ketik...">
                        </div>
                      </div>
                     
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Tanggal</label>

                        <div class="col-sm-2">
                          <div class="input-group"><span class="input-group-addon" ><i class="fa fa-calendar-check-o"></i></span><input type="text" readonly id="tanggal"  name="tanggal" value="{{$data->tanggal}}" placeholder="ketik disini.." class="form-control  input-sm"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Material Cost</label>

                      </div>
                      <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <div class="callout callout-warning" style="background-color: #f9fb87 !important;color: #000 !important;">
                                <p>Harap lengkapi semua isi agar dapat disimpan atau diproses.</p>
                              </div>
                              <span class="btn btn-info btn-sm" id="addmaterial"><i class="fa fa-plus"></i> Add Material</span>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th style="width:15%">Kode</th>
                                    <th>Material</th>
                                    <th style="width:15%">H.Satuan</th>
                                    <th style="width:8%">Qty</th>
                                    <th style="width:15%">Total</th>
                                    <th style="width:5%"></th>
                                  </tr>
                                </thead>
                                <tbody id="tampil_material"></tbody>
                                
                                <tbody id="tampil-material-save"></tbody>
                                
                              </table>
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
              <button type="button" class="btn btn-info" onclick="simpan_data()">Simpan</button>
              <button type="button" class="btn btn-danger" onclick="location.assign(`{{url('material')}}`)">Kembali</button>
            </div>
                 
        </div>
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
      <div class="modal fade" id="modal-cost" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Show Cost</h4>
            </div>
            <div class="modal-body">
              <input type="text" id="no-material">
              <div class="table-responsive">
                  <table id="data-table-fixed-header" width="100%" class="cell-border display">
                      <thead>
                          <tr>
                              <th width="5%">No</th>
                              
                              <th width="5%"></th>
                              <th width="10%">Cost Center</th>
                              <th width="20%">Customer</th>
                              <th >Deskripsi</th>
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
                              <th width="10%">Kode</th>
                              <th>Nama material</th>
                              <th width="15%">Harga</th>
                              <th width="8%">Satuan</th>
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
        @if($id==0)
          $("#sumber").hide();
          function pilih_sumber(id){
            if(id==2){
              $("#sumber").show();
            }else{
              $("#sumber").hide();
            }
          }

          function show_cost(){
            $('#modal-cost').modal('show');
            var tables=$('#data-table-fixed-header').DataTable();
              tables.ajax.url("{{ url('project/getdata')}}").load();
           }
        @else
           @if($data->kategori_stok_id==1)
           $("#sumber").hide();
           @else

           @endif
        @endif
        
        $('#tanggal').datepicker({ format: 'yyyy-mm-dd' });
        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });

        


        $('#tampil-material-save').load("{{url('project/tampil_material_in')}}?id={{$data->id}}");
        $(document).ready(function(e) {
          $('#save-material').hide();
          var nom = {{$count}};
            $("#addmaterial").click(function(){
                var no = nom++;
                $("#tampil_material").append('<tr style="background:#fff" class="addmaterial">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><div class="input-group"><span class="input-group-addon" onclick="show_material('+no+')"><i class="fa fa-search"></i></span><input type="text" readonly id="kode_material'+no+'"  name="kode_material[]" placeholder="ketik disini.." class="form-control  input-sm"></div></td>'
                                              +'<td><input type="text" name="nama_material[]"  readonly  id="nama_material'+no+'" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><input type="text" name="biaya[]"    id="harga_material'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td><input type="text" name="qty[]" id="qty'+no+'" value="0" onkeyup="tentukan_nilai(this.value,'+no+')" style="text-align:right" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td><input type="text" name="total[]" id="total'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_material"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $("#harga_material"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                                            $("#total"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                                            // $("#qtynya"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                                            $("#stok"+no).inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0 || nom>0){
                  $('#save-material').show();
                } 
            });
        });
        $(document).on('click', '.remove_material', function(){  
            $(this).parents('.addmaterial').remove();
        });

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
                           url: "{{url('project/delete_material')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-material-save').load("{{url('project/tampil_material_in')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }

        function show_material(no){

          
          $('#no-material').val(no);
          $('#modal-material').modal('show');
          var tables=$('#data-table-fixed-header-material').DataTable();
              tables.ajax.url("{{ url('material/getdata')}}").load();
        }
        function tentukan_nilai(qty,no){
          var harga=$('#harga_material'+no).val();
          var nil = harga.replace(/,/g, "");
          if(nil==""){
            alert('Pilih Material');
            show_material(no)
            $('#qty'+no).val(0);
          }else{
            var hasil=(qty*nil);
                $('#total'+no).val(hasil);
          }

        }

        function pilih_material(kode_material,nama_material,harga,stok){

          var no=$('#no-material').val();
          $('#modal-material').modal('hide');
          $('#nama_material'+no).val(nama_material);
          $('#kode_material'+no).val(kode_material);
          $('#harga_material'+no).val(harga);
          $('#normal_harga_material'+no).val(harga);
          $('#stok'+no).val(stok);

        }
        

        function pilih_cost(cost_center,customer_code,customer,deskripsi_project){

          $('#modal-cost').modal('hide');
          $('#cost_center').val(cost_center);
          $('#customer_code').val(customer_code);
          $('#customer').val(customer);
          $('#deskripsi_project').val(deskripsi_project);

        }
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('material/store_stok') }}",
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
                            location.assign("{{url('material/masuk')}}");
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
