    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if(Request::is('home')==1 || Request::is('/')==1) active @endif"><a href="{{url('home')}}"><i class="fa fa-home text-white"></i> <span>Home</span></a></li>
        @if(Auth::user()->role_id==1)
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-database text-white"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if((Request::is('employe')==1 || Request::is('employe/*')==1)|| (Request::is('customer')==1 || Request::is('customer/*')==1) || (Request::is('cost/*')==1 || Request::is('cost')==1) ) block @endif">
              <li @if(Request::is('employe')==1 || Request::is('employe/*')==1) class="active" @endif ><a href="{{url('employe')}}">&nbsp;<i class="fa  fa-sort-down"></i> Employe</a></li>
              <li @if(Request::is('customer')==1 || Request::is('customer/*')==1) class="active" @endif><a href="{{url('customer')}}">&nbsp;<i class="fa  fa-sort-down"></i> Customer</a></li>
              <li @if(Request::is('cost')==1 || Request::is('cost/*')==1) class="active" @endif><a href="{{url('cost')}}">&nbsp;<i class="fa  fa-sort-down"></i> Cost</a></li>
              
            </ul>
          </li>
          <li class="treeview ">
            <a href="#">
              <i class="fa fa-cube text-white"></i> <span>Material</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('material')==1 || Request::is('material/*')==1) block @endif">
              <li @if(Request::is('material')==1 || Request::is('material/*')==1) class="active" @endif><a href="{{url('material')}}">&nbsp;<i class="fa  fa-sort-down"></i> Draf Material</a></li>
              <li @if(Request::is('material/masuk')==1 || Request::is('material/*')==1) class="active" @endif><a href="{{url('material/masuk')}}">&nbsp;<i class="fa  fa-sort-down"></i> Draf In</a></li>
              <li @if(Request::is('material/masuk')==1 || Request::is('material/*')==1) class="active" @endif><a href="{{url('material/keluar')}}">&nbsp;<i class="fa  fa-sort-down"></i> Draf Out</a></li>
            
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-database text-white"></i> <span>Rencana Pekerjaan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if((Request::is('project/*')==1 || Request::is('project')==1)) block @endif">
              <li><a href="{{url('project')}}">{!!notifikasi_side(1)!!}&nbsp;<i class="fa  fa-sort-down"></i>List Project</a></li>
              <li><a href="{{url('salesorder/approved')}}">&nbsp;<i class="fa  fa-sort-down"></i> Approved Request</a></li>
            </ul>
          </li>
        @endif

        @if(Auth::user()->role_id==2)
          <li @if(Request::is('project')==1 || Request::is('project/*')==1) class="active" @endif><a href="{{url('project')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Rencana Pekerjaan</span></a></li>
        @endif

        @if(Auth::user()->role_id==3)
          <li @if(Request::is('project')==1 || Request::is('project/*')==1) class="active" @endif><a href="{{url('project')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Rencana Pekerjaan</span></a></li>
        @endif

        @if(Auth::user()->role_id==4)
          <li @if(Request::is('project')==1 || Request::is('project/*')==1) class="active" @endif><a href="{{url('project')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Rencana Pekerjaan</span></a></li>
        @endif

        @if(Auth::user()->role_id==5)
          <li class="treeview">
            <a href="#">
              <i class="fa fa-cube text-white"></i> <span>Material</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="display:@if(Request::is('material')==1 || Request::is('material/*')==1) block @endif">
              <li @if(Request::is('material')==1 || Request::is('material/*')==1) class="active" @endif><a href="{{url('material')}}">&nbsp;<i class="fa  fa-sort-down"></i> Draf Material</a></li>
              <li @if(Request::is('material/masuk')==1 || Request::is('material/*')==1) class="active" @endif><a href="{{url('material/masuk')}}">&nbsp;<i class="fa  fa-sort-down"></i> Draf In</a></li>
              <li @if(Request::is('material/masuk')==1 || Request::is('material/*')==1) class="active" @endif><a href="{{url('material/keluar')}}">&nbsp;<i class="fa  fa-sort-down"></i> Draf Out</a></li>
            
            </ul>
          </li>
          <!-- <li @if(Request::is('project')==1 || Request::is('project/*')==1) class="active" @endif><a href="{{url('project')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Verifikasi Project</span></a></li> -->
          <li @if(Request::is('pengadaan')==1 || Request::is('pengadaan/*')==1) class="active" @endif><a href="{{url('pengadaan')}}"><i class="fa fa-calendar text-white"></i>&nbsp;<span>Draft Pengadaan </span></a></li>
        @endif
        @if(Auth::user()->role_id==6)
          <li @if(Request::is('project')==1 || Request::is('project/*')==1) class="active" @endif><a href="{{url('project')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Rencana Pekerjaan</span></a></li>
          <li @if(Request::is('kontrak')==1 || Request::is('kontrak/*')==1) class="active" @endif><a href="{{url('kontrak')}}"><i class="fa fa-briefcase text-white"></i>{!!notifikasi_side_kontrak(1)!!}&nbsp;<span>Kontrak</span></a></li>
        @endif
        @if(Auth::user()->role_id==7)
          <li @if(Request::is('project')==1 || Request::is('project/*')==1) class="active" @endif><a href="{{url('project')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Rencana Pekerjaan</span></a></li>
          <li @if(Request::is('kontrak')==1 || Request::is('kontrak/*')==1) class="active" @endif><a href="{{url('kontrak')}}"><i class="fa fa-briefcase text-white"></i>&nbsp;<span>Kontrak</span></a></li>
        @endif
        @if(Auth::user()->role_id==8)
          <li @if(Request::is('projectcontrol')==1 || Request::is('projectcontrol/*')==1) class="active" @endif><a href="{{url('projectcontrol')}}"><i class="fa fa-calendar text-white"></i>{!!notifikasi_side(1)!!}&nbsp;<span>Rencana Pekerjaan</span></a></li>
          <li @if(Request::is('kontrak')==1 || Request::is('kontrak/*')==1) class="active" @endif><a href="{{url('kontrak')}}"><i class="fa fa-briefcase text-white"></i>&nbsp;<span>Kontrak</span></a></li>
        @endif
        @if(count_pm()>0)
          <li @if(Request::is('projectcontrol')==1 || Request::is('projectcontrol/*')==1) class="active" @endif><a href="{{url('projectcontrol')}}"><i class="fa fa-calendar text-white"></i><span>Project Control</span></a></li>
        @endif
      </ul>