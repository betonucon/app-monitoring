
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-PROM | PT KPDP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link href="{{url_plug()}}/img/ks.png?v={{date('ymdhis')}}" rel="icon">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{url_plug()}}/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{url_plug()}}/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{url_plug()}}/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url_plug()}}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url_plug()}}/dist/css/skins/_all-skins.min.css">
  <script src="{{url_plug()}}/js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="{{url_plug()}}/dist/sweetalert.css">
  @stack('style')
  <style>
      body {
          font-family: sans-serif !important;
          font-weight: 400;
          font-size: 12px  !important;
          overflow-x: hidden;
          overflow-y: auto;
      }
      .table-responsive {
          min-height: 300px !important;
          overflow-x: auto;
      }
      .skin-purple-light .wrapper, .skin-purple-light .main-sidebar, .skin-purple-light .left-side {
          background-color: #2d58ad;
      }
      .skin-purple-light .sidebar a {
          color: #fff;
      }
      .skin-purple-light .sidebar-menu>li.header {
          color: #f1ecec;
          text-align: center;
          background: #344f85;
      }
      .user-panel>.image>img {
          width: 100%;
          max-width: 65px;
          height: auto;
      }
      .user-panel>.info {
          width: 100%;
          padding: 15px 5px 5px 15px;
          line-height: 1;
          text-align: center;
          position: absolute;
          left: 0px;
      }
      .skin-purple-light .sidebar-menu>li:hover>a, .skin-purple-light .sidebar-menu>li.active>a {
          color: #fffdfd;
          background: #8686a5;
      }
      .info-box {
        display: block;
        min-height: 90px;
        background-image: linear-gradient(to right top, #ffffff, #f4f1fb, #eae3f7, #e2d5f2, #dbc6ec);
        width: 100%;
        color: #817070;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        border-radius: 2px;
        margin-bottom: 15px;
        border: solid 2px #e9e2f1;
        border-radius: 10px 10px 10px 10px !important;
        cursor: pointer;
      }
      .info-box .progress {
          background: blue;
          margin: 5px -10px 5px -10px;
          height: 9px;
      }
      .info-box .progress .progress-bar {
          background: #e5330b;
      }
      table.dataTable thead  th {
          padding: 8px 7px !important;
          background: #e7e7f3;
          border-top: 1px solid rgb(0 0 0 / 15%) !important;
          border-bottom: 1px solid rgb(0 0 0 / 15%) !important;
          /* border-right: solid 1px #dbdbdf; */
      }
      #header-monitoring{
        display:none;
      }
      .form-group {
          margin-bottom: 3px;
      }
      .form-control:focus {
          border-color: #9c9fa1 !important;
          box-shadow: none;
      }
      table.dataTable tbody td {
          padding: 2px 7px !important;
          background:#fff !important;
          border-bottom: 0px solid rgb(0 0 0 / 15%) !important;
      }
      .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border-left: 0px solid #efefef !important;
        border-right: 1px solid #e1d9d9 !important;
      }
      .swal-text {
            width: 100%;
            color: #000;
        }
      @media screen and (max-width: 767px){
        .table-responsive {
            border: 1px solid #ddd0 !important;
        }
      }

      .loadpage {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1070;
        top: 0;
        left: 0;
        background-color: rgb(0,0,0);
        background-color: rgb(218 219 223);
        overflow-x: hidden;
        transition: transform .9s;
      }
      .loadpage-content {
        position: relative;
        top: 25%;
        width: 100%;
        text-align: center;
        margin-top: 30px;
        color:#fff;
        font-size:20px;
      }
      .treeview-menu>li>a {
          
          padding: 5px 5px 5px 25px;
          display: block;
          font-family: sans-serif !important;
          font-weight: 400;
          font-size: 12px !important;
      }
      #header-label {
          text-align: left;
          font-family: inherit;
          font-weight: 700;
          padding: 0px 0px;
          color: #77779b;
          font-size: 16px;
          margin: 20px 0px 20px 40px;
          border-bottom: solid 2px #dadadf;
      }
      #header-label-material {
        text-align: left;
        font-family: inherit;
        font-weight: 700;
        padding: 0px 0px;
        width: 97%;
        color: #77779b;
        font-size: 16px;
        margin: 20px 0px 20px 20px;
        border-bottom: solid 2px #dadadf;
      }
      #header-label-modal{
          text-align: left;
          font-family: inherit;
          font-weight: 700;
          padding: 0px 0px;
          color: #77779b;
          font-size: 16px;
          margin: 20px 0px 20px 0px;
          border-bottom: solid 2px #dadadf;
      }
      .loadnya {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1070;
        top: 0;
        left: 0;
        background-color: rgb(0,0,0);
        background-color: rgb(243 230 230 / 81%);
        overflow-x: hidden;
        transition: transform .9s;
      }
      .loadnya-content {
        position: relative;
        top: 25%;
        width: 100%;
        text-align: center;
        margin-top: 30px;
        color:#fff;
        font-size:20px;
      }
      .li-dashboard {
          position: relative;
          display: block;
          padding: 3px 15px !important;
      }
      .table-responsive {
          background: #e8e9fd;
          min-height: 300px !important;
          overflow-x: auto;
      }
      table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
        font-size: 11.5px !important;
      }
      @media only screen and (min-width: 600px) {

      }
      @media only screen and (max-width: 590px) {
        .table-responsive-mobile {
          min-height: 300px !important;
          overflow-x: auto;
        }
      }
      .responsive-bawah{
        max-height:400px;
        overflow-y:scroll;
      }
      .info-box-iconic {
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
        display: block;
        float: left;
        height: 55px !important;
        width: 50px;
        text-align: center;
        font-size: 20px;
        line-height: 50px;
        background: rgba(0,0,0,0.2);
    }
    .td-detail {
        background: #e3e3e9 !important;
        padding: 4px 4px 4px 7px !important;
        border: solid 1px #979090 !important;
    }
    .th-detail {
        padding: 4px 0px 4px 7px !important;
        border: solid 1px #979090 !important;
    }
    .tdd-detail {
        background: #fff !important;
        padding: 4px 4px 4px 7px !important;
        border: solid 1px #979090 !important;
    }
    .thh-detail {
        background: aqua !important;
        padding: 4px 0px 4px 7px !important;
        border: solid 1px #979090 !important;
    }
    .nav-tabs-custom>.nav-tabs>li.active>a, .nav-tabs-custom>.nav-tabs>li.active:hover>a {
        background-color: #fff3f3;
        color: #444;
    }
  </style>
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition fixed sidebar-mini sidebar-mini-expand-feature skin-purple-light">
<div id="loadnya" class="loadnya">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loadnya-content">
          <button class="btn btn-light" type="button" disabled>
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Loading...
          </button>
      </div>
</div>
<div id="loadpage" class="loadpage">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="loadpage-content">
        
            <img src="{{url_plug()}}/img/load.gif?v={[date('ymdhis')}}" width="20%">
        
      </div>
</div>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <span class="logo-mini"><b>A</b>LT</span>
      <span class="logo-lg" style="text-align: left;"><b><img src="{{url_plug()}}/img/ks.png?v={{date('ymdhis')}}" width="20%" alt="User Image"> E-PROM</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url_plug()}}/img/akun.png" class="user-image" alt="User Image">
              <span class="hidden-xs">@ {{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{url_plug()}}/img/akun.png" class="img-circle" alt="User Image">

                <p>
                  @ {{Auth::user()->name}} - {{Auth::user()->role['role']}}
                  <small>Online</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#"  onclick="switch_to({{Auth::user()->role_utama}})"><span class="btn btn-primary btn-xs">{{Auth::user()->roleutama['short']}}</span></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">switch</a>
                  </div>
                  @if(count_pm()>0)
                  <div class="col-xs-4 text-center">
                    <a href="#" onclick="switch_to(8)"><span class="btn btn-primary btn-xs">PM</span></a>
                  </div>
                  @else
                  <div class="col-xs-4 text-center">
                    <a href="#"></a>
                  </div>
                  @endif
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" id="logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="background: #e7e7ef;height: 130px;">
        <div class="image" style="text-align: center;">
          <img src="{{url_plug()}}/img/akun.png" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <p>PT Krakatau Perbekalan</p>
          <a href="#"><i class="fa fa-circle text-success"></i>@ {{Auth::user()->name}} Online</a>
        </div>
      </div>
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      @include('layouts.side')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2023 <a href="#">PT.KPDP</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
       

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane active" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<!-- <script src="{{url_plug()}}/bower_components/jquery/dist/jquery.min.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url_plug()}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->

<script src="{{url_plug()}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="{{url_plug()}}/bower_components/chart.js/Chart.js"></script>
<script type='text/javascript' src="{{url_plug()}}/js/jquery.inputmask.bundle.js"></script>

<!-- date-range-picker -->
<script src="{{url_plug()}}/bower_components/moment/min/moment.min.js"></script>
<script src="{{url_plug()}}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="{{url_plug()}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="{{url_plug()}}/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="{{url_plug()}}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="{{url_plug()}}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{{url_plug()}}/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="{{url_plug()}}/bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="{{url_plug()}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url_plug()}}/dist/js/demo.js"></script>
<link rel="stylesheet" type="text/css" href="{{url_plug()}}/dist/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="{{url_plug()}}/dist/jquery.dataTables.js"></script>
@stack('datatable')
@stack('ajax')
<!-- Page script -->
<script type="text/javascript">
   
    //  function load(){
		// 	document.getElementById("loadpage").style.width = "100%";
		// }
		// function close_load(){
		// 	document.getElementById("loadpage").style.width = "0%";
		// }
		// $(document).ready(function() {
			
		// 	load();
		// });
		
		// window.setTimeout(function () {
		// 	document.getElementById("loadpage").style.width = "0%";
		// }, 1000);


    $('#tanggal_app').datepicker({
      autoclose: true,
      format:'yyyy-mm-dd'
    });
        
        $('.dropdown-toggle').dropdown()
        $("#logout").on("click", function() {
          swal({
                title: "Yakin melakukan logout?",
                text: "Proses logout akan mengluarkan anda dari sistem",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                    location.assign("{{url('logout-perform')}}")
                  } else {
                    
                  }
              });
        }) 

        function hanyaAngka(evt) {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57)){
    
            return false;
          }else{
            return true;
          }
          
        }
        function switch_to(role_id) {
          $.ajax({
              type: 'GET',
              url: "{{url('employe/switch_to')}}",
              data: "role_id="+role_id,
              success: function(msg){
                  location.assign("{{url('/')}}")
              }
          });
          
        }
        
        function terbilang(angka){

            var bilne=["","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas"];

            if(angka < 12){

              return bilne[angka];

            }else if(angka < 20){

              return terbilang(angka-10)+" Belas";

            }else if(angka < 100){

              return terbilang(Math.floor(parseInt(angka)/10))+" Puluh "+terbilang(parseInt(angka)%10);

            }else if(angka < 200){

              return "Seratus "+terbilang(parseInt(angka)-100);

            }else if(angka < 1000){

              return terbilang(Math.floor(parseInt(angka)/100))+" Ratus "+terbilang(parseInt(angka)%100);

            }else if(angka < 2000){

              return "Seribu "+terbilang(parseInt(angka)-1000);

            }else if(angka < 1000000){

              return terbilang(Math.floor(parseInt(angka)/1000))+" Ribu "+terbilang(parseInt(angka)%1000);

            }else if(angka < 1000000000){

              return terbilang(Math.floor(parseInt(angka)/1000000))+" Juta "+terbilang(parseInt(angka)%1000000);

            }else if(angka < 1000000000000){

              return terbilang(Math.floor(parseInt(angka)/1000000000))+" Milyar "+terbilang(parseInt(angka)%1000000000);

            }else if(angka < 1000000000000000){

              return terbilang(Math.floor(parseInt(angka)/1000000000000))+" Trilyun "+terbilang(parseInt(angka)%1000000000000);

            }

        }
  </script>

</body>
</html>
