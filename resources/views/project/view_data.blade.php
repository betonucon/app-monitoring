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
                    ajax:"{{ url('cost/getdata')}}",
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
        Form Cost Center
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cost Center</li>
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
              <input type="submit">
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  
                    <div class="box-body">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Cost Code</label>

                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Header Cost</label>

                        <div class="col-sm-2">
                          <div class="input-group">
                            <span class="input-group-addon" onclick="show_draft()"><i class="fa fa-search"></i></span>
                            <input type="text" id="cost" name="cost" readonly class="form-control  input-sm" placeholder="0000">
                          </div>
                        </div>
                        <div class="col-sm-7">
                          <input type="text" id="area" readonly class="form-control input-sm"  value="{{$data->area}}" placeholder="Ketik...">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Customer</label>

                        <div class="col-sm-2">
                          <input type="text" id="customer_code" name="customer_code" readonly class="form-control input-sm"  value="{{$data->customer_code}}" placeholder="Ketik...">
                        </div>
                        <div class="col-sm-5">
                          <input type="text" id="customer" readonly class="form-control input-sm"  value="{{$data->customer}}" placeholder="Ketik...">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Deskripsi Project</label>

                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
                          <div class="col-sm-7">
                          <textarea  class="form-control input-sm" name="deskripsi_project"  placeholder="Ketik..." rows="4">{!! $data->deskripsi_project !!}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Start date / End date</label>

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
                        <label for="inputEmail3" class="col-sm-2 control-label">File Kontrak</label>

                        <div class="col-sm-4">
                          <input type="file" id="file" name="file" readonly value="{{$data->file}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                          <span class="help-block">Format file harus "pdf"</span>
                        </div>
                        
                        
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Nilai Kontrak (Rp)</label>

                        <div class="col-sm-2">
                          <input type="text"  id="nilai" name="nilai" value="" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                        </div>
                        <div class="col-sm-7">
                          <input type="text"  id="out" readonly name="terbilang" value="" class="form-control  input-sm" placeholder="yyyy-mm-dd">
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
              <button type="button" class="btn btn-danger" onclick="location.assign(`{{url('cost')}}`)">Kembali</button>
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
       
        $('#start_date').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });

        $('#end_date').datepicker({
          autoclose: true,
          format:'yyyy-mm-dd'
        });

        $("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
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
        function show_draft(){
           
            $('#modal-draf').modal('show');
            var tables=$('#data-table-fixed-header').DataTable();
                tables.ajax.url("{{ url('cost/getdata')}}").load();
        } 
        function pilih_customer(cost,customer_code,customer,area){
           
            $('#modal-draf').modal('hide');
            $('#cost').val(cost);
            $('#customer_code').val(customer_code);
            $('#customer').val(customer);
            $('#area').val(area);
            
        } 
       
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('project') }}",
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
        };
    </script> 
@endpush
