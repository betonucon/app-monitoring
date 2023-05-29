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
        <form class="form-horizontal" id="mydatamaster" method="post" action="{{ url('project') }}" enctype="multipart/form-data" >
          @csrf
              <!-- <input type="submit"> -->
          <input type="hidden" name="id" value="{{$id}}">
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
            <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Operasional Project</a></li>
            <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Cost Material</a></li>
            <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><i class="fa fa-check-square-o"></i> Cost Jasa</a></li>
            
            
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
            <div class="tab-pane" id="tab_4">
              
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Material Cost</label>

              </div>
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-1 control-label" style="width:2%"></label>
                  
                  <div class="col-sm-11">
                    
                    <div class="row">
                        <div class="col-sm-4">
                          <span class="btn btn-info btn-sm" id="addmaterial"><i class="fa fa-plus"></i> Add Material</span>
                          <span class="btn btn-danger btn-sm" onclick="reset_material({{$id}})"><i class="fa fa-file-excel-o"></i> Reset Material</span>
                        </div>
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4">
                          <input type="text" id="cari_material" placeholder="Search....." class="form-control input-sm">
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="">
                      <thead>
                        <tr style="background:#bcbcc7">
                          <th style="width: 10px">No</th>
                          <th>Material</th>
                          <th style="width:15%">H.Satuan</th>
                          <th style="width:8%">Qty</th>
                          <th style="width:8%">Satuan</th>
                          <th style="width:6%">Status</th>
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
                  <span  class="btn btn-sm btn-success" id="save-material" onclick="simpan_material()"><i class="fa fa-arrow-right"></i> Tambah dan Simpan</span>
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
                    <span  class="btn btn-sm btn-success" id="save-operasional" onclick="simpan_operasional()"><i class="fa fa-arrow-right"></i>  Tambah dan Simpan</span>
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
                    <span  class="btn btn-sm btn-success" id="save-jasa" onclick="simpan_jasa()"><i class="fa fa-arrow-right"></i>  Tambah dan Simpan</span>
                  </div>
                      
                </div>
            </div>
          </div>
        </form>
      </div>
      

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
      
      $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}");
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
        $(document).on('click', '.remove_operasional', function(){  
            $(this).parents('.addoperasional').remove();
        });
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



        $('#tampil-jasa-save').load("{{url('kontrak/tampil_jasa')}}?id={{$data->id}}");
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
                                              +'<td style="width:5%"><span class="btn btn-danger btn-xs remove_jasa"><i class="fa fa-close"></i></span></td>'
                                            +'</tr>');
                                            $(".biayanya").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                if(no>0){
                  $('#save-jasa').show();
                } 
            });
        });
        $(document).on('click', '.remove_jasa', function(){  
            $(this).parents('.addjasa').remove();
        });
        
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
       


        $('#cari_material').keyup(function(){
          $('#tampil-material-save').load("{{url('kontrak/tampil_material_kontrak')}}?id={{$data->id}}&cari="+$(this).val());
        })
        $('#tampil-material-save').load("{{url('kontrak/tampil_material_kontrak')}}?id={{$data->id}}");
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





      $('#dashboard-task').load("{{url('pengadaan/dashboard_task')}}?id={{$data->id}}&act=1");
      function show_progres(id){
        $('#modal-progres').modal('show');
        $('#tampil-progres').load("{{url('projectcontrol/modal_progres')}}?id="+id);

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
                           url: "{{url('kontrak/reset_material')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-material-save').load("{{url('kontrak/tampil_material_kontrak')}}?id={{$data->id}}");
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
                           url: "{{url('kontrak/reset_operasional')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}");
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
                           url: "{{url('kontrak/reset_jasa')}}",
                           data: "id="+id,
                           success: function(msg){
                               swal("Success! berhasil terhapus!", {
                                   icon: "success",
                               });
                               $('#tampil-jasa-save').load("{{url('kontrak/tampil_jasa')}}?id={{$data->id}}");
                           }
                       });
                   
                   
               } else {
                   
               }
           });
           
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
          
            
          var form=document.getElementById('mydatamaster');
          
              
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
                          swal("Success! berhasil diproses ", {
                              icon: "success",
                          });
                          $('#tampil_material').html("");
                          $('#save-material').hide();
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
        function simpan_operasional(){
          
            
          var form=document.getElementById('mydatamaster');
          
              
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
                          swal("Success! berhasil diproses ", {
                              icon: "success",
                          });
                          $('#save-operasional').hide();
                          $('#tampil_operasional').html("");
                          $('#tampil-operasional-save').load("{{url('kontrak/tampil_operasional')}}?id={{$data->id}}");
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
          
            
          var form=document.getElementById('mydatamaster');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('kontrak/store_risiko') }}",
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
                          location.assign("{{url('kontrak/view')}}?id={{encoder($id)}}&tab=1");
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
          
            
          var form=document.getElementById('mydatamaster');
          
              
              $.ajax({
                  type: 'POST',
                  url: "{{ url('kontrak/store_jasa') }}",
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
                          $('#save-jasa').hide();
                          $('#tampil_jasa').html("");
                          $('#tampil-jasa-save').load("{{url('kontrak/tampil_jasa')}}?id={{$data->id}}");
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
