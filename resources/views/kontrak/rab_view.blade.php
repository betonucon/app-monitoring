  <div class="nav-tabs-custom" style="border: solid 2px white;">
      
      <ul class="nav nav-tabs">
        <li class="active"><a href="#subtab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-bars"></i> Cost Center & Kontrak</a></li>
        <li class=""><a href="#subtab_2" data-toggle="tab" aria-expanded="true"><i class="fa fa-users"></i> Personal & Cost</a></li>
        <li class=""><a href="#subtab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-bars"></i> Operasional Project</a></li>
        <li class=""><a href="#subtab_4" data-toggle="tab" aria-expanded="false"><i class="fa fa-bars"></i> Operasional Project</a></li>
        <!-- <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li> -->
        
        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
      </ul>
      <div class="tab-content" style="background: #f7eeee">
         
          <div class="tab-pane active" id="subtab_1">

              <div class="box-body">
                          
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-11 control-label" id="header-label"><i class="fa fa-bars"></i> Profit & Retensi </label>

                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Cost Center </label>

                  <div class="col-sm-2">
                    
                      <input type="text" id="cost" name="cost" value="{{$data->cost_center}}" readonly class="form-control  input-sm" placeholder="0000">
                   
                  </div>
                  <div class="col-sm-7">
                    <input type="text" id="area_cost" readonly class="form-control input-sm"  value="{{$data->area}}" placeholder="Ketik...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Margin Cost (%)</label>

                  <div class="col-sm-2">
                    <div class="input-group">
                      <input type="text" id="margin" name="margin" readonly value="{{$data->margin}}" class="form-control  input-sm" placeholder="0.0">
                    </div>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Project Manager</label>

                  <div class="col-sm-2">
                    <div class="input-group">
                      <input type="text" id="nik_pm" name="nik_pm" value="{{$data->nik_pm}}" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                  </div>
                  <div class="col-sm-7">
                    <input type="text" id="nama_pm" name="nama_pm" readonly class="form-control input-sm"  value="{{$data->nama_pm}}" placeholder="Ketik...">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Retensi (Start / End)</label>

                  <div class="col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                      <input type="text"  name="start_date_retensi" readonly value="{{$data->start_date_retensi}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="input-group">
                      <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                      <input type="text"  name="end_date_retensi" readonly value="{{$data->end_date_retensi}}" class="form-control  input-sm" placeholder="yyyy-mm-dd">
                    </div>
                  </div>
                  
                </div>
                
              </div>
          </div>
          <div class="tab-pane " id="subtab_2">

            <div class="box-body" >
              
              
                <table class="table table-bordered" id="">
                  <thead>
                    <tr style="background:#bcbcc7">
                      <th class="th-detail" style="width: 5%">No</th>
                      <th class="th-detail" style="width: 14%">NIK</th>
                      <th class="th-detail">Nama</th>
                      <th class="th-detail" style="width:20%">Job Project</th>
                      <th class="th-detail" style="width:14%">Salery</th>
                    </tr>
                  </thead>
                  <tbody id="tampil-personal-save"></tbody>
                  
                </table>
             
              
            </div>
          </div>

          <div class="tab-pane" id="subtab_3">
            <div class="box-body" >
                
                
                <table class="table table-bordered" id="">
                  <thead>
                    <tr style="background:#bcbcc7">
                      <th class="th-detail" style="width: 5%">No</th>
                      <th class="th-detail">Keterangan</th>
                      <th class="th-detail" style="width:14%">Biaya</th>
                    </tr>
                  </thead>
                  
                  <tbody id="tampil-operasional-save"></tbody>
                  
                </table>
            
              
            </div>
          </div>
          <div class="tab-pane" id="subtab_4">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Anggaran Perperiode</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="thh-detail" style="width: 5%">#</th>
                      <th class="thh-detail">Periode</th>
                      <th class="thh-detail" style="width: 15%">Personal</th>
                      <th class="thh-detail" style="width: 15%">Operasional</th>
                    </tr>
                </thead>
                <tbody>
                @foreach(get_periode($data->id) as $no=>$o)
           
                  <tr>
                      <td class="tdd-detail">{{$no+1}}</td>
                      <td class="tdd-detail">Bulan ke {{$no+1}} ({{bulan($o->bulan)}} {{$o->tahun}})</td>
                      <td class="tdd-detail text-right">{{uang($o->personal)}}</td>
                      <td class="tdd-detail  text-right">{{uang($o->operasional)}}</td>
                  </tr>
                @endforeach
                </tbody>
                 
              </table>
              </div>
              
            </div>
          </div>
      </div>
  </div>