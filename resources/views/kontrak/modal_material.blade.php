        <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th width="10%">Kode</th>
                <th>Material</th>
                <th width="10%">Qty</th>
                <th  width="10%">Satuan</th>
                <th  width="10%">Harga</th>
                <th  width="10%">Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($getdata as $no=>$o)
              <tr>
                <td>{{$no+1}}</td>
                <td>{{$o->kode_material}}</td>
                <td>{{$o->nama_material}}</td>
                <td style="text-align:right">{{$o->qty}}</td>
                <td>{{$o->satuan}}</td>
                <td style="text-align:right">{{uang($o->harga)}}</td>
                <td style="text-align:right">{{uang($o->total)}}</td>
              </tr>
              @endforeach
              <tr>
                <th colspan="6">Total</td>
                <th style="text-align:right">{{uang($total)}}</td>
              </tr>
            </tbody>
          </table>