<input type="hidden" name="id"  value="{{$data->id}}" placeholder="Ketik...">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Kode</label>

        <div class="col-sm-3">
            <input type="text" name="kode_material" class="form-control input-sm" disabled value="{{$data->kode_material}}" placeholder="Ketik...">
        </div>
    </div>
        
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Nama Material</label>

        <div class="col-sm-9">
            <input type="text" name="nama_material" disabled class="form-control input-sm"  value="{{$data->nama_material}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Harga Pengajuan</label>

        <div class="col-sm-6">
            <input type="text" name="harga_material" disabled id="harga_material" class="form-control input-sm"  value="{{$data->biaya}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Harga Actual</label>

        <div class="col-sm-6">
            <input type="text" name="biaya_actual" id="biaya_actual" class="form-control input-sm"  value="{{$data->biaya_actual}}" placeholder="Ketik...">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-3 control-label">Status Material</label>

        <div class="col-sm-4">
            <select name="status_material_id" class="form-control  input-sm" placeholder="0000">
                <option value="">Pilih------</option>
                @foreach(get_status_material() as $emp)
                    <option value="{{$emp->id}}" @if($data->status_material_id==$emp->id) selected @endif >{{$emp->id}}. {{$emp->status_material}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            
        </div>
    </div>

    <script>
        $("#harga_material").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
        $("#biaya_actual").inputmask({ alias : "currency", prefix: '', 'autoGroup': true, 'digits': 0, 'digitsOptional': false });
    </script>