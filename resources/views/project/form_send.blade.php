              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  
                    <div class="box-body">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-11 control-label" id="header-label-modal"><i class="fa fa-bars"></i> Cost Code</label>

                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Komersil / Enginering</label>

                        <div class="col-sm-8">
                          <div class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-search"></i></span>
                            <select name="nik" readonly class="form-control  input-sm" placeholder="0000">
                            <option value="">Pilih------</option>
                              @foreach(get_employe_even(4) as $emp)
                                <option value="{{$emp->nik}}">{{$emp->nik}} - {{$emp->nama}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        
                      </div>
                      
                      <div class="form-group" style="margin-top:1%">
                        <label for="inputEmail3" class="col-sm-3 control-label">Catatan</label>
                        <div class="col-sm-8">
                          <textarea  class="form-control input-sm" name="catatan"   rows="4"></textarea>
                        </div>
                      </div>
                      
                      
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                
                
              </div>