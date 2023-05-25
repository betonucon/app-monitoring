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
                    ajax:"{{ url('customer/getdata')}}",
                      columns: [
                        { data: 'seleksi' },
                        { data: 'customer_code' },
                        { data: 'customer' },
                        
                      ],
                      
                });
                
                
            }
        };

        var handleDataTableFixedHeadermaterial = function() {
            "use strict";
            
            if ($('#data-table-fixed-header-material').length !== 0) {
                var table=$('#data-table-fixed-header-material').DataTable({
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
        function show_draft_customer(){
           
           $('#modal-draf').modal('show');
           var table=$('#data-table-fixed-header').DataTable();
               table.ajax.url("{{ url('customer/getdata')}}").load();
        }  
        
        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rencana Rencana
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Rencana Rencana</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-body">
            <form class="form-horizontal" id="mydata" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
              @csrf
              <!-- <input type="submit"> -->
              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  <!-- <div class="callout callout-success">
                    <h4>Penyusunan RAB</h4>

                    <p>Penyusunan nilai anggaran rencana project yang terdiri dari 4 aspek (Rencana , Biaya Operasional, Material Cos dan Risiko Project)</p>
                  </div> -->
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      @if($data->status_id==1)
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Rencana Pekerjaan</a></li>
                      <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Operasional Project</a></li>
                      <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Cost Material</a></li>
                      <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Cost Jasa</a></li>
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <li class="pull-right"><a href="#" class="text-muted"><span class="btn btn-success btn-sm" onclick="import_material()"><i class="fa fa-file-excel-o"></i> Upload Biaya Cost</span></a></li>
                      @else
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-check-square-o"></i> Rencana Pekerjaan</a></li>
                      <li class=""><a href="#" onclick="alert(`Tentukan rencana pekerjaan`)" aria-expanded="false"><i class="fa fa-check-square-o"></i> Operasional Project</a></li>
                      <li class=""><a href="#" onclick="alert(`Tentukan rencana pekerjaan`)" aria-expanded="false"><i class="fa fa-check-square-o"></i> Cost Material</a></li>
                      <li class=""><a href="#" onclick="alert(`Tentukan rencana pekerjaan`)" aria-expanded="false"><i class="fa fa-check-square-o"></i> Cost Jasa</a></li>
                      <li class=""><a href="#" onclick="alert(`Tentukan rencana pekerjaan`)" aria-expanded="false"><i class="fa fa-check-square-o"></i> Risiko Pekerjaan</a></li>
                      <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                      @endif
                      
                    </ul>
                    <div class="tab-content" style="background: #fff3f3;">
                    
                      <div class="tab-pane active" id="tab_1">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Rencana Pekerjaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Customer Cost</label>

                            <div class="col-sm-2">
                              <div class="input-group">
                                <span class="input-group-addon" onclick="show_draft_customer()"><i class="fa fa-search"></i></span>
                                <input type="text" id="customer_code" name="customer_code" readonly value="{{$data->customer_code}}" class="form-control  input-sm" placeholder="0000">
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" id="customer" readonly class="form-control input-sm"  value="{{$data->customer}}" placeholder="Ketik...">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Kategori Project</label>

                            <div class="col-sm-3">
                              <div class="input-group">
                                
                                  <select name="kategori_project_id" class="form-control  input-sm" placeholder="0000">
                                  <option value="">Pilih------</option>
                                    @foreach(get_kategori() as $emp)
                                      <option value="{{$emp->id}}" @if($data->kategori_project_id==$emp->id) selected @endif >{{$emp->kategori_project}} </option>
                                    @endforeach
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Tipe Project</label>

                            <div class="col-sm-5">
                              <div class="input-group">
                                
                                  <select name="tipe_project_id" class="form-control  input-sm" placeholder="0000">
                                  <option value="">Pilih------</option>
                                    @foreach(get_tipe() as $emp)
                                      <option value="{{$emp->id}}" @if($data->tipe_project_id==$emp->id) selected @endif >{{$emp->tipe_project}} ({{$emp->keterangan_tipe_project}})</option>
                                    @endforeach
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Ruang Lingkup Project</label>
                              <div class="col-sm-10">
                              <input  class="form-control input-sm" name="deskripsi_project" value="{{$data->deskripsi_project}}" placeholder="Ketik..." >
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nilai Project</label>
                              <div class="col-sm-2">
                              <input  class="form-control input-sm" name="nilai_project" id="nilai_project" value="{{$data->nilai_project}}" placeholder="Ketik..." >
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
                          
                          
                        </div>
                        <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              @if($id>0)
                              <span  class="btn btn-sm btn-info" onclick="simpan_data()"><i class="fa fa-save"></i> Update Data</span>
                              @else
                              <span  class="btn btn-sm btn-success" onclick="simpan_data()"><i class="fa fa-save"></i> Proses Data</span>
                              @endif
                            </div>
                                
                        </div>
                      </div>

                      <div class="tab-pane " id="tab_2">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Risiko Pekerjaan</label>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-10">
                              <div class="callout callout-warning" style="background-color: #f9fb87 !important;color: #000 !important;">
                                <p>Harap lengkapi semua isi agar dapat disimpan atau diproses.</p>
                              </div>
                              <span class="btn btn-info btn-sm" id="add"><i class="fa fa-plus"></i> Tambah Risiko</span>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Risiko Yang Terjadi</th>
                                    <th style="width:15%">Tipe</th>
                                    <th style="width:5%"></th>
                                  </tr>
                                </thead>
                                <tbody id="tampil-risiko-save"></tbody>
                                <tbody id="tampil_risiko"></tbody>
                              </table>
                            </div>
                        </div>
                        <div class="box-footer" style="text-align:center">
                          <div class="btn-group">
                            <span  class="btn btn-sm btn-success" id="save-risiko" onclick="simpan_risiko()"><i class="fa fa-arrow-right"></i> Berikutnya</span>
                            
                          </div>
                              
                        </div>
                      </div>

                      <div class="tab-pane" id="tab_4">
                        
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
                              
                              <span class="btn btn-danger btn-sm" onclick="reset_material({{$id}})"><i class="fa fa-file-excel-o"></i> Reset Material</span>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Material</th>
                                    <th style="width:15%">H.Satuan</th>
                                    <th style="width:8%">Qty</th>
                                    <th style="width:8%">Satuan</th>
                                    <th style="width:15%">Total</th>
                                    <th style="width:5%"></th>
                                  </tr>
                                </thead>
                                <tbody id="tampil_material"></tbody>
                                
                                <tbody id="tampil-material-save"></tbody>
                                
                              </table>
                            </div>
                        </div>
                        <div class="box-footer" style="text-align:center">
                          <div class="btn-group">
                            <span  class="btn btn-sm btn-success" id="save-material" onclick="simpan_material()"><i class="fa fa-arrow-right"></i> Berikutnya</span>
                          </div>
                              
                        </div>
                      </div>

                      <div class="tab-pane" id="tab_3">
                      
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Operasional Pekerjaan</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <div class="callout callout-warning" style="background-color: #f9fb87 !important;color: #000 !important;">
                                <p>Harap lengkapi semua isi agar dapat disimpan atau diproses.</p>
                              </div>
                              <span class="btn btn-info btn-sm" id="addoperasional"><i class="fa fa-plus"></i> Add Operasional</span>
                              <span class="btn btn-danger btn-sm" onclick="reset_operasional({{$id}})"><i class="fa fa-file-excel-o"></i> Reset operasional</span>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Keterangan Biaya</th>
                                    <th style="width:14%">Biaya</th>
                                    <th style="width:8%">F(x)</th>
                                    <th style="width:14%">Tot Biaya</th>
                                    <th style="width:5%"></th>
                                  </tr>
                                </thead>
                                <tbody id="tampil_operasional"></tbody>
                                
                                <tbody id="tampil-operasional-save"></tbody>
                                
                              </table>
                        
                          
                            </div>
                          </div>
                          <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              <span  class="btn btn-sm btn-success" id="save-operasional" onclick="simpan_operasional()"><i class="fa fa-arrow-right"></i> Berikutnya</span>
                            </div>
                                
                          </div>
                      </div>
                      <div class="tab-pane" id="tab_5">
                      
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Cost Jasa</label>

                          </div>
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                            
                            <div class="col-sm-11">
                              <div class="callout callout-warning" style="background-color: #f9fb87 !important;color: #000 !important;">
                                <p>Harap lengkapi semua isi agar dapat disimpan atau diproses.</p>
                              </div>
                              <span class="btn btn-info btn-sm" id="addjasa"><i class="fa fa-plus"></i> Add jasa</span>
                              <span class="btn btn-danger btn-sm" onclick="reset_jasa({{$id}})"><i class="fa fa-file-excel-o"></i> Reset jasa</span>
                              <table class="table table-bordered" id="">
                                <thead>
                                  <tr style="background:#bcbcc7">
                                    <th style="width: 10px">No</th>
                                    <th>Keterangan Biaya</th>
                                    <th style="width:14%">Biaya</th>
                                    <th style="width:8%">F(x)</th>
                                    <th style="width:14%">Tot Biaya</th>
                                    <th style="width:5%"></th>
                                  </tr>
                                </thead>
                                <tbody id="tampil_jasa"></tbody>
                                
                                <tbody id="tampil-jasa-save"></tbody>
                                
                              </table>
                        
                          
                            </div>
                          </div>
                          <div class="box-footer" style="text-align:center">
                            <div class="btn-group">
                              <span  class="btn btn-sm btn-success" id="save-jasa" onclick="simpan_jasa()"><i class="fa fa-arrow-right"></i> Berikutnya</span>
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
          @if($data->status_id>0)
            <div class="btn-group">
              <button  class="btn btn-sm btn-info" onclick="kirim_data()"><i class="fa fa-save"></i> Simpan & Publish</button>
              <button  class="btn btn-sm btn-danger" onclick="location.assign(`{{url('project')}}`)"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
          @endif      
        </div>
        
      </div>
     

    </section>
      <div class="modal fade" id="modal-draf" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button  class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Header Cost</h4>
            </div>
            <div class="modal-body">
              
                <table id="data-table-fixed-header" width="100%" class="cell-border display">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="20%">Cust Code</th>
                            <th >Nama Customer</th>
                        </tr>
                    </thead>
                    
                </table>
              
            </div>
            <div class="modal-footer">
              <button  class="btn btn-default pull-left" data-dismiss="modal">Close</button>
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
      <div class="modal fade" id="modal-import-material" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Import Material</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="mydataimportmaterial" method="post" action="{{ url('project/store_import_material') }}" enctype="multipart/form-data" >
                @csrf
                <input type="submit">
                <input type="text" value="{{$id}}" name="id">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">File Excel</label>

                    <div class="col-sm-9">
                      <div class="input-group">
                        <span class="input-group-addon" ><i class="fa fa-file-excel-o"></i></span>
                        <input type="file" id="file_excel_material" name="file_excel_material" readonly value="{{$data->start_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                      </div>
                    </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info pull-right" onclick="simpan_import_material()" >Import Data</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal fade" id="modal-import-operasional" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Import operasional</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="mydataimportoperasional" method="post" action="{{ url('project/store_import_operasional') }}" enctype="multipart/form-data" >
                @csrf
                <input type="submit">
                <input type="text" value="{{$id}}" name="id">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">File Excel</label>

                    <div class="col-sm-9">
                      <div class="input-group">
                        <span class="input-group-addon" ><i class="fa fa-file-excel-o"></i></span>
                        <input type="file" id="file_excel_operasional" name="file_excel_operasional" readonly value="{{$data->start_date}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                      </div>
                    </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-info pull-right" onclick="simpan_import_material()" >Import Data</button>
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

        $("#nilai_project").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $('#tampil-risiko-save').load("{{url('project/tampil_risiko')}}?id={{$data->id}}");
        $(document).ready(function(e) {
          $('#save-risiko').hide();
          var nom = {{$nom}};
            $("#add").click(function(){
                var no = nom++;
                $("#tampil_risiko").append('<tr style="background:#fff" class="added">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><input type="text" name="risiko[]" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><select name="status_risiko[]"  placeholder="ketik disini.." class="form-control  input-sm">'
                                                +'<option value="">Pilih--</option>'
                                                @foreach(get_status_risiko() as $jb)
                                                  +'<option value="{{$jb->status_risiko}}">{{$jb->status_risiko}}</option>'
                                                @endforeach
                                              +'</select></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_add"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                if(no>0){
                  $('#save-risiko').show();
                }
            });

            
            
              
        });

        $(document).on('click', '.remove_add', function(){  
            $(this).parents('tr').remove();
        }); 

        function sentuh_biaya() {
          $(".biayanya").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });  
          $('#save-operasional').show();
        }
        function import_material() {
            $('#modal-import-material').modal('show');
        }
        function import_operasional() {
            $('#modal-import-operasional').modal('show');
        }
        $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}");
        $(document).ready(function(e) {
          $('#save-operasional').hide();
          var nom = {{$nomper}};
            $("#addoperasional").click(function(){
                var no = nom++;
                $("#tampil_operasional").append('<tr style="background:#fff" class="addoperasional">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><input type="text" name="keterangan[]" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><input type="text" name="biayaopr[]" id="biayaopr'+no+'" placeholder="ketik disini.." class="form-control input-sm biayanya"></td>'
                                              +'<td><input type="text" name="qtyopr[]" onkeyup="tentukan_nilai_opr(this.value,'+no+')" id="qtyopr'+no+'" placeholder="ketik disini.." class="form-control input-sm biayanya"></td>'
                                              +'<td><input type="text"  id="totalopr'+no+'" placeholder="ketik disini.." class="form-control input-sm biayanya"></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_operasional"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $(".biayanya").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0){
                  $('#save-operasional').show();
                } 
            });
        });

        $('#tampil-jasa-save').load("{{url('project/tampil_jasa')}}?id={{$data->id}}");
        $(document).ready(function(e) {
          $('#save-jasa').hide();
          var nom = {{$nomjasa}};
            $("#addjasa").click(function(){
                var no = nom++;
                $("#tampil_jasa").append('<tr style="background:#fff" class="addjasa">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><input type="text" name="keteranganjasa[]" placeholder="ketik disini.." class="form-control  input-sm"></td>'
                                              +'<td><input type="text" name="biayajasa[]" id="biayajasa'+no+'" placeholder="ketik disini.." class="form-control input-sm biayanya"></td>'
                                              +'<td><input type="text" name="qtyjasa[]" onkeyup="tentukan_nilai_jasa(this.value,'+no+')" id="qtyjasa'+no+'" placeholder="ketik disini.." class="form-control input-sm biayanya"></td>'
                                              +'<td><input type="text"  id="totaljasa'+no+'" placeholder="ketik disini.." class="form-control input-sm biayanya"></td>'
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_operasional"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $(".biayanya").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0){
                  $('#save-jasa').show();
                } 
            });
        });
        
        $(document).on('click', '.remove_operasional', function(){  
            $(this).parents('.addoperasional').remove();
        });

        $('#tampil-material-save').load("{{url('project/tampil_material')}}?id={{$data->id}}");
        $(document).ready(function(e) {
          $('#save-material').hide();
          var nom = {{$nommat}};
            $("#addmaterial").click(function(){
                var no = nom++;
                $("#tampil_material").append('<tr style="background:#fff" class="addmaterial">'
                                              +'<td style="width: 10px">'+no+'</td>'
                                              +'<td><div class="input-group"><span class="input-group-addon" onclick="show_material('+no+')"><i class="fa fa-search"></i></span><input type="text" name="nama_material[]"    id="nama_material'+no+'" placeholder="ketik disini.." class="form-control  input-sm"><input type="hidden" readonly id="kode_material'+no+'"  name="kode_material[]" placeholder="ketik disini.." class="form-control  input-sm"></div></td>'
                                              +'<td><input type="text" name="biaya[]"    id="harga_material'+no+'" placeholder="ketik disini.." class="form-control input-sm"><input type="hidden" readonly  id="normal_harga_material'+no+'" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td><input type="text" name="qty[]" id="qty'+no+'" value="0" onkeyup="tentukan_nilai(this.value,'+no+')" style="text-align:right" placeholder="ketik disini.." class="form-control input-sm"></td>'
                                              +'<td><input type="text" name="satuan_material[]"  value=""  style="text-align:left" placeholder="ketik disini.." class="form-control input-sm"></td>'
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

        function show_material(no){

          
          $('#no-material').val(no);
          $('#modal-material').modal('show');
          var tables=$('#data-table-fixed-header-material').DataTable();
              tables.ajax.url("{{ url('material/getdata')}}").load();
        }
        function tentukan_nilai(qty,no){
          var harga=$('#harga_material'+no).val();
          var nil = harga.replace(/,/g, "");
          if(nil=="" || nil==0){
            alert('Masukan harga');
            $('#qty'+no).val(0);
          }else{
            var hasil=(qty*nil);
                $('#total'+no).val(hasil);
          }

        }
        function tentukan_nilai_opr(qty,no){
          var harga=$('#biayaopr'+no).val();
          var nil = harga.replace(/,/g, "");
          if(nil=="" || nil==0){
            alert('Masukan harga');
            $('#qtyopr'+no).val(0);
          }else{
            var hasil=(qty*nil);
                $('#totalopr'+no).val(hasil);
          }

        }
        function tentukan_nilai_jasa(qty,no){
          var harga=$('#biayajasa'+no).val();
          var nil = harga.replace(/,/g, "");
          if(nil=="" || nil==0){
            alert('Masukan harga');
            $('#qtyjasa'+no).val(0);
          }else{
            var hasil=(qty*nil);
                $('#totaljasa'+no).val(hasil);
          }

        }

        function pilih_material(kode_material,nama_material,harga,stok){

          var no=$('#no-material').val();
          $('#modal-material').modal('hide');
          $('#nama_material'+no).val(nama_material);
          $('#kode_material'+no).val(kode_material);
          $('#harga_material'+no).val(harga);
          $('#normal_harga_material'+no).val(harga);
          $('#qty'+no).val(0);
          $('#total'+no).val(0);
          $('#stok'+no).val(stok);

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
                           url: "{{url('project/delete_operasional')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil_pengeluaran').load("{{url('project/tampil_pengeluaran')}}?id={{$data->id}}");
                               $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        } 
        function delete_jasa(id){
           
           swal({
               title: "Yakin menghapus jasa ini ?",
               text: "data akan hilang dari daftar jasa",
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
                           url: "{{url('project/delete_jasa')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil_pengeluaran').load("{{url('project/tampil_pengeluaran')}}?id={{$data->id}}");
                               $('#tampil-jasa-save').load("{{url('project/tampil_jasa')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
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
                           url: "{{url('project/delete_material')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-material-save').load("{{url('project/tampil_material')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
        function reset_material(id){
           
           swal({
               title: "Yakin reset materiall ini ?",
               text: "semua data akan hilang dari daftar material",
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
                           url: "{{url('project/reset_material')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-material-save').load("{{url('project/tampil_material')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
        function reset_operasional(id){
           
           swal({
               title: "Yakin reset operasionall ini ?",
               text: "semua data akan hilang dari daftar operasional",
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
                           url: "{{url('project/reset_operasional')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }
        function reset_jasa(id){
           
           swal({
               title: "Yakin reset jasal ini ?",
               text: "semua data akan hilang dari daftar jasa",
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
                           url: "{{url('project/reset_jasa')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-jasa-save').load("{{url('project/tampil_jasa')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
        }

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
        function delete_risiko(id){
           
            swal({
                title: "Yakin menghapus risiko ini ?",
                text: "data akan hilang dari daftar risiko",
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
                            url: "{{url('project/delete_risiko')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                $('#tampil-risiko-save').load("{{url('project/tampil_risiko')}}?id={{$data->id}}");
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 
        
        function pilih_customer(customer_code,customer){
           
           $('#modal-draf').modal('hide');
           $('#customer_code').val(customer_code);
           $('#customer').val(customer);
           
        }  
       
        function kirim_data(){
           
           swal({
               title: "Yakin melakukan publish ?",
               text: "data akan hilang dari daftar material",
               type: "warning",
               icon: "info",
               showCancelButton: true,
               align:"center",
               confirmButtonClass: "btn-info",
               confirmButtonText: "Yes, publish it!",
               closeOnConfirm: false
           }).then((willDelete) => {
               if (willDelete) {
                var form=document.getElementById('mydata');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('project/publish') }}",
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
                   
               } else {
                   
               }
           });
           
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
                            location.assign("{{url('project/view')}}?id="+bat[2]+"&tab=2");
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
                  url: "{{ url('project/store_operasional') }}",
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
                          swal("Success! berhasil diproses ", {
                              icon: "success",
                          });
                          $('#tampil-operasional').html("");
                          $('#tampil-operasional-save').load("{{url('project/tampil_operasional')}}?id={{$data->id}}");
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
        function simpan_risiko(){
          
            
          var form=document.getElementById('mydata');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('project/store_risiko') }}",
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
                          location.assign("{{url('project/view')}}?id={{encoder($id)}}&tab=1");
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
                          swal("Success! berhasil diproses ", {
                              icon: "success",
                          });
                          $('#tampil-material').html("");
                          $('#tampil-material-save').load("{{url('project/tampil_material')}}?id={{$data->id}}");
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
        function simpan_jasa(){
          
            
          var form=document.getElementById('mydata');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('project/store_jasa') }}",
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
                          swal("Success! berhasil diproses ", {
                              icon: "success",
                          });
                          $('#tampil_jasa').html("");
                          $('#tampil-jasa-save').load("{{url('project/tampil_jasa')}}?id={{$data->id}}");
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
        function simpan_import_material(){
          
            
          var form=document.getElementById('mydataimportmaterial');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('project/store_import_material') }}",
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
                          swal("Success! berhasil diimport ", {
                              icon: "success",
                          });
                          location.reload();
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
