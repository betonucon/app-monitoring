              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  
                    <div class="box-body">
                      <div class="form-group" style="margin-top:1%">
                        <label for="inputEmail3" class="col-sm-2 control-label">Task</label>
                        <div class="col-sm-8">
                          <textarea  class="form-control input-sm" name="task" placeholder="ketik disini.."  rows="4">{!!$data->task!!}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Status Task</label>

                        <div class="col-sm-4">
                          <div class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-search"></i></span>
                            <select name="status_task_id"  class="form-control  input-sm" placeholder="0000">
                            <option value="">Pilih------</option>
                              @foreach(get_status_task() as $emp)
                                <option value="{{$emp->id}}" @if($data->status_task_id==$emp->id) selected @endif >{{$emp->id}} - {{$emp->status_task}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        
                      </div>
                      <div class="form-group" style="margin-top:1%">
                        <label for="inputEmail3" class="col-sm-2 control-label">Start & End Date</label>
                        <div class="col-sm-2">
                          <input type="text"  class="form-control input-sm" name="start" value="{{$data->start}}" id="start_date" placeholder="ketik disini..">
                        </div>
                        <div class="col-sm-2">
                          <input type="text"  class="form-control input-sm" name="end"  value="{{$data->end}}" id="end_date"  placeholder="ketik disini..">
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                
                
              </div>
              <script>
                  $('#modal-form .modal-title').html("#{{$mst->id}} {{$mst->deskripsi_project}}");
                  $('#start_date').datepicker({
                    autoclose: true,
                    format:'yyyy-mm-dd'
                  });
                  $('#end_date').datepicker({
                    autoclose: true,
                    format:'yyyy-mm-dd'
                  });
              </script>