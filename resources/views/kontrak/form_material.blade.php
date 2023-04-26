<input type="hidden" name="id"  value="{{$data->id}}" placeholder="Ketik...">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Kode</label>

        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon" @if($id==0) onclick="show_material()" @endif><i class="fa fa-search"></i></span>
                <input type="text" readonly id="kode_material"  name="kode_material" value="{{$data->kode_material}}" placeholder="ketik disini.." class="form-control  input-sm">
            </div>
        </div>
    </div>
        
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Nama Material</label>

        <div class="col-sm-9">
            <input type="text" name="nama_material" id="nama_material" readonly class="form-control input-sm"  value="{{$data->nama_material}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Qty</label>

        <div class="col-sm-2">
            <input type="text" name="qty"  id="qty" onkeyup="tentukan_qty(this.value)"  class="form-control input-sm"  value="{{$data->qty}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Harga</label>

        <div class="col-sm-3">
            <input type="text" name="biaya"  id="harga_material" onkeyup="tentukan_nilai(this.value)" class="form-control input-sm"  value="{{$data->biaya}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Total</label>

        <div class="col-sm-3">
            <input type="text" name="total" readonly id="total" class="form-control input-sm"  value="{{$data->biaya}}" placeholder="Ketik...">
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            
        </div>
    </div>

    <script>
        
        $("#total").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $("#qty").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $("#harga_material").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $("#biaya_actual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
    
        function tentukan_qty(qty){
                    
            var harga=$('#harga_material').val();
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
    </script>