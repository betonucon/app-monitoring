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
              
                <div class="col-md-9">
                  
                    <div class="box-body">
                     
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Kode</label>

                        <div class="col-sm-2">
                          <input type="text" name="kode_material" class="form-control input-sm" {{$disabled}} value="{{$data->kode_material}}" placeholder="Ketik...">
                        </div>
                      </div>
                     
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Nama Material</label>

                        <div class="col-sm-9">
                          <input type="text" name="nama_material" class="form-control input-sm"  value="{{$data->nama_material}}" placeholder="Ketik...">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Satuan</label>

                        <div class="col-sm-4">
                            <select name="satuan"  class="form-control  input-sm" placeholder="0000">
                              <option value="">Pilih------</option>
                              @foreach(get_satuan() as $emp)
                                <option value="{{$emp->satuan}}" @if($data->satuan==$emp->satuan) selected @endif >{{$emp->satuan}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Harga (Rp)</label>

                        <div class="col-sm-4">
                          <input type="text"  id="nilai" name="harga"  class="form-control  input-sm" value="{{$data->harga}}" placeholder="">
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
  </div>
@endsection

@push('ajax')
    <script> 

$("#nilai").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 2, 'digitsOptional': false });
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('material') }}",
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
                            location.assign("{{url('material')}}");
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
