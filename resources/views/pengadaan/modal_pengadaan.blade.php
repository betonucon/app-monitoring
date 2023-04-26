              <input type="hidden" name="id" value="{{$id}}">
              <div class="row">
              
                <div class="col-md-12">
                  
                    <div class="box-body">
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Material</label>

                        <div class="col-sm-8">
                          <input type="text"  class="form-control input-sm" name="nama_material" value="{{$data->nama_material}}" placeholder="ketik disini..">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Status Aset</label>

                        <div class="col-sm-4">
                          <div class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-search"></i></span>
                            <select name="status_aset_id"  class="form-control  input-sm" placeholder="0000">
                            
                              @foreach(get_status_aset() as $emp)
                                <option value="{{$emp->id}}" @if($data->status_aset_id==$emp->id) selected @endif >{{$emp->id}} - {{$emp->nama_aset}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Qty</label>

                        <div class="col-sm-2">
                          <input type="text"  class="form-control input-sm" id="qty" onkeyup="tentukan_qty(this.value)" name="qty" value="{{$data->qty}}" placeholder="ketik disini..">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Harga</label>

                        <div class="col-sm-4">
                          <input type="text"  class="form-control input-sm" onkeyup="tentukan_nilai(this.value)" id="biaya_actual" name="biaya_actual" value="{{$data->biaya_actual}}" placeholder="ketik disini..">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Total</label>

                        <div class="col-sm-4">
                          <input type="text" readonly class="form-control input-sm"  id="total" name="total_actual" value="{{$data->total_actual}}" placeholder="ketik disini..">
                        </div>
                      </div>
                      <div class="form-group">
                          <label for="inputEmail3" class="col-sm-3 control-label">Status Material</label>

                          <div class="col-sm-4">
                              <select name="status_material_id" class="form-control  input-sm" placeholder="0000">
                                  @foreach(get_status_material() as $emp)
                                      <option value="{{$emp->id}}" @if($data->status_material_id==$emp->id) selected @endif >{{$emp->id}}. {{$emp->status_material}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      
                    </div>
                    <!-- /.box-body -->
                    
                    <!-- /.box-footer -->
                  
                </div>
                
                
              </div>
              <script>
                  $("#qty").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                  $("#biaya_actual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                  $("#total").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
                  $('#modal-progres .modal-title').html("#{{$data->task}}");
                  function tentukan_qty(qty){
                    
                    var harga=$('#biaya_actual').val();
                    var qt = qty.replace(/,/g, "");
                    var nil = harga.replace(/,/g, "");
                    if(nil=="" || nil==0){
                      alert('Masukan harga');
                      $('#qty').val(0);
                    }else{
                      var hasil=(qt*nil);
                          $('#total').val(hasil);
                    }

                  }
                  function tentukan_nilai(harga){
                    var qty=$('#qty').val();
                    var qt = qty.replace(/,/g, "");
                    var nil = harga.replace(/,/g, "");
                    if(qt=="" || qt==0){
                      alert('Masukan qty');
                      $('#qty').val(0);
                    }else{
                      var hasil=(qt*nil);
                          $('#total').val(hasil);
                    }

                  }
                  $('#start_date').datepicker({
                    autoclose: true,
                    format:'yyyy-mm-dd'
                  });
                  $('#end_date').datepicker({
                    autoclose: true,
                    format:'yyyy-mm-dd'
                  });
              </script>