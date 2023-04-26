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
     function load_data(){  
		
        $.getJSON("{{ url('projectcontrol/getdata')}}?text={{$text}}", function(data){
			$('#tampil-project-load').hide();
            $.each(data, function(i, result){
                $("#tampil-project").append('<div class="col-md-6 col-sm-6 col-xs-12" >'
                  +'<div class="info-box" style="padding:2%" onclick="location.assign(`{{url('projectcontrol/task')}}?id='+result.id+'`)">'
                    
                      +'<span class="info-box-text" style="background: #f3f362; padding: 1%;"><b>#'+result.id+' '+result.deskripsi_project+'</b></span>'
                      +'<div class="row" style="padding:3% 4%">'
                        +'<div class="col-md-12" style="margin-bottom: 1.2%;">'
                        +'<b><i class="fa fa-clone"></i> '+result.customer+'</b>'
                        +'</div>'
                        +'<div class="col-md-12" style="margin-bottom: 1.2%;">'
                        +'<b><i class="fa fa-calendar-times-o"></i> Time : '+result.start_date+' s/d  '+result.end_date+' ('+result.outstanding+') days</b>'
                        +'</div>'
                        +'<div class="col-md-12" style="margin-bottom: 1.2%;">'
                        +'<b><i class="fa fa-calendar-times-o"></i> Task Pekerjaan : '+result.start_date+' s/d  '+result.end_date+' ('+result.outstanding+') days</b>'
                        +'</div>'
                        
                      +'</div>'
                      +'<div class="row" style="padding:0px 5%">'
                        
                        +'<div class="col-md-3 text-center" style="padding: 1%;background: #dcdceb;">'
                        +' <h5 style="margin:0px">Total Task</h5>'
                        +' <h3 style="margin:0px">'+result.total_task+'</h3>'
                        +'</div>'
                        +'<div class="col-md-1 text-center" ></div>'
                        +'<div class="col-md-3 text-center" style="padding: 1%;background: #f1f3d5;">'
                        +' <h5 style="margin:0px">Progres</h5>'
                        +' <h3 style="margin:0px">'+(result.total_task-result.total_task_selesai)+'</h3>'
                        +'</div>'
                        +'<div class="col-md-1 text-center" ></div>'
                        +'<div class="col-md-3 text-center" style="padding: 1%;background: #f7b2b2;">'
                        +' <h5 style="margin:0px">Solved</h5>'
                        +' <h3 style="margin:0px">'+result.total_task_selesai+'</h3>'
                        +'</div>'
                        
                        +'<div class="col-md-12" style="margin-top:4%">'
                          +'<div class="progress-group">'
                            +'<span class="progress-text">Progress Bar</span>'
                            +'<span class="progress-number"><b>'+result.total_task_progres+'</b>/100</span>'

                            +'<div class="progress lg">'
                              +'<div class="progress-bar progress-bar-aqua" style="width: '+result.total_task_progres+'%"></div>'
                            +'</div>'
                          +'</div>'
                        +'</div>'
                      +'</div>'
                  +'</div>'
                +'</div>');
            });
        });
	 }
	 $(document).ready(function() {
		
		$('#tampil-project-load').show()
		
		
	 });
	 window.setTimeout(function () {
		load_data();
	 }, 1000);
	
   function loader(){
    var text=$('#textcari').val();
    location.assign("{{url('projectcontrol')}}?text="+text);
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
      <div class="row">
        <div class="col-md-7">

        </div>
        <div class="col-md-4">
            <input type="text" id="textcari" placeholder="cari....." class="form-control">
        </div>
        <div class="col-md-1">
          <span class="btn btn-info" onclick="loader()">Cari</span>
        </div>
      </div>
      <hr style="border-top: 4px double #ced1ff;">
      <div class="row" id="tampil-project-load" style="height: 300px;background: #f9f6f6;">
        <div class="col-md-12">
          <div class="loadpage-content">
            
            <img src="{{url_plug()}}/img/logo.png?v={[date('ymdhis')}}" width="20%"><br>
            <img src="{{url_plug()}}/img/loading.gif" width="10%">
            
          </div>
        </div>
      </div>
      <div class="row" id="tampil-project">
        
      </div>
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
      <div class="modal file" id="modal-send" style="display: none;">
        <div class="modal-dialog" style="max-width:70%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Send To Komersil</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="mydatakirim" method="post" action="{{ url('project/kirim_komersil') }}" enctype="multipart/form-data" >
                  @csrf
                  <div id="tampil_form"></div>
              </form>
               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary pull-right" onclick="kirim_data()" >Kirim</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="modal file" id="modal-timeline" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Time Line</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="" method="post" action="{{ url('project/kirim_komersil') }}" enctype="multipart/form-data" >
                  @csrf
                  <div id="tampil_timeline"></div>
              </form>
               
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
      function send_data(id){
          $('#modal-send').modal('show')
          $('#tampil_form').load("{{url('project/form_send')}}?id="+id)
      }
      function show_timeline(id){
          $('#modal-timeline').modal('show')
          $('#tampil_timeline').load("{{url('project/timeline')}}?id="+id)
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
      function send_data_to(id){
            
            swal({
                title: "Yakin akan mengirim data keporses berikutnya ?",
                text: "",
                type: "warning",
                icon: "info",
                showCancelButton: true,
                align:"center",
                confirmButtonClass: "btn-info",
                confirmButtonText: "Yes, cancel it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                      
                        $.ajax({
                            type: 'GET',
                            url: "{{url('project/kirim_kadis_komersil')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terkirim!", {
                                    icon: "success",
                                });
                                var tables=$('#data-table-fixed-header').DataTable();
                                    tables.ajax.url("{{ url('project/getdata')}}").load();
                            }
                        });
                    
                      
                } else {
                    
                }
            });
            
      } 
        function show_file(file){
          $('#modal-file').modal('show');
          $('#tampil_file').show();
          $('#tampil_file').html('<iframe src="{{url_plug()}}/_file_kontrak/'+file+'" height="500px" width="100%"></iframe>');
        }  

        function kirim_data(){
            
            var form=document.getElementById('mydatakirim');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('project/kirim_komersil') }}",
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
                              title: "Success! berhasil dikirim!",
                              icon: "success",
                            });
                            $('#modal-send').modal('hide');
                            $('#tampil_form').hide();
                            
                            var tables=$('#data-table-fixed-header').DataTable();
                                tables.ajax.url("{{ url('project/getdata')}}").load();
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
