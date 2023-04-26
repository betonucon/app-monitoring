              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  
                    <div class="box-body">
                      
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Status & Progres</label>

                        <div class="col-sm-4">
                          <div class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-search"></i></span>
                            <select name="status_task_id"  class="form-control  input-sm" placeholder="0000">
                            
                              @foreach(get_status_task() as $emp)
                                <option value="{{$emp->id}}" @if($data->status_task_id==$emp->id) selected @endif >{{$emp->id}} - {{$emp->status_task}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <select name="progres"  class="form-control  input-sm" placeholder="0000">
                            
                            @foreach(get_progres_task() as $emp)
                              <option value="{{$emp->progres}}" @if($data->progres==$emp->progres) selected @endif >{{$emp->progres}}%</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group" style="margin-top:1%">
                        <label for="inputEmail3" class="col-sm-2 control-label">Catatan Progres</label>
                        <div class="col-sm-8">
                          <textarea  class="form-control input-sm" name="catatan" placeholder="ketik disini.."  rows="4"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Attachment</label>

                        <div class="col-sm-5">
                          <input type="file"  class="form-control input-sm" name="file[]" multiple placeholder="ketik disini..">
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                
                
              </div>
              <script>
                  $('#modal-progres .modal-title').html("#{{$data->task}}");
                  $('#start_date').datepicker({
                    autoclose: true,
                    format:'yyyy-mm-dd'
                  });
                  $('#end_date').datepicker({
                    autoclose: true,
                    format:'yyyy-mm-dd'
                  });
              </script>