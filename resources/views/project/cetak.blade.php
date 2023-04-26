<html>
    <head>
        <title>RABOP</title>
        <style>
            html{
                margin:1%;
                font-family: 'Open Sans';
                font-style: normal;
                font-weight: normal;
                src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
            }
            .head{
                height:70px;
                width:100%;
                border-bottom:double 4px #000;
                text-align:center;
                font-weight:bold;
                font-size:14px;
                text-transform:uppercase
            }
            table{
                border-collapse:collapse;
            }
            .tth{
                padding:4px;
                background:aqua;
                text-transform:uppercase
            }
            .ttd{
                padding:4px;
            }
            .ttdhg{
                padding:4px;
                text-transform:uppercase;
            }
            .ttdf{
                padding:4px;
                text-align:left;
                border:solid 1px #fff;
                font-weight:bold;
                font-size:14px;
            }
            .ttdc{
                padding:4px;
                text-align:center;
            }
            .ttdl{
                padding:4px;
                text-align:right;
            }
            .body{
                width:100%;
                font-size:12px;
                margin-top:2%;
            }
            .head p{
                margin:2px;
            }
        </style>
    </head>
    <body>
        <div class="head">
            <p>Rencana Anggaran Biaya(RAB)</p>
            <p>Proposal pengajuan rencana project</p>
            <p>PT. Krakatau Perbengkelan dan Perawatan</p>
        </div>
        
        <div class="body"> 
            <table width="100%" border="0">
                
                <tr>
                    <td class="ttdf"  colspan="4">A.INFORMASI PROJECT</td>
                </tr>
                <tr>
                    <td class="ttdhg" width="1%"></td>
                    <td class="ttdhg" width="20%">Customer</td>
                    <td class="ttdhg" width="3%">:</td>
                    <td class="ttdhg" > {{$data->customer}} ({{$data->singkatan_customer}})</td>
                </tr>
                <tr>
                    <td class="ttdhg"></td>
                    <td class="ttdhg">Cost</td>
                    <td class="ttdhg">:</td>
                    <td class="ttdhg" > {{$data->header_cost}}</td>
                </tr>
                <tr>
                    <td class="ttdhg"></td>
                    <td class="ttdhg">DESKRIPSI</td>
                    <td class="ttdhg">:</td>
                    <td class="ttdhg" >  {{$data->deskripsi_project}}</td>
                </tr>
                <tr>
                    <td class="ttdhg"></td>
                    <td class="ttdhg">KATEGORI PROJECT</td>
                    <td class="ttdhg">:</td>
                    <td class="ttdhg" > ({{$data->kategori_project}}) {{$data->keterangan_tipe_project}}</td>
                </tr>
                <tr>
                    <td class="ttdhg"></td>
                    <td class="ttdhg">NILAI DIAJUKAN</td>
                    <td class="ttdhg">:</td>
                    <td class="ttdhg" > {{uang($data->nilai)}}</td>
                </tr>
                <tr>
                    <td class="ttdhg"></td>
                    <td class="ttdhg">NILAI BIDDING</td>
                    <td class="ttdhg">:</td>
                    <td class="ttdhg" > {{uang($data->nilai_bidding)}}</td>
                </tr>
                <tr>
                    <td class="ttdhg"></td>
                    <td class="ttdhg">NILAI PROJECT</td>
                    <td class="ttdhg">:</td>
                    <td class="ttdhg" > {{uang($data->nilai_project)}}</td>
                </tr>
                
            
        </table>
        </div>
        <div class="body"> 
            <table width="100%" border="1">
                <tr>
                    <td class="ttdf" colspan="6">B. MATERIAL</td>
                </tr>
                <tr>
                    <th rowspan="2" class="tth">NO</th>
                    <th rowspan="2" class="tth">Komponen Pembiayaan</th>
                    <th class="tth" colspan="2">Volume</th>
                    <th rowspan="2" class="tth">Harga Satuan</th>
                    <th rowspan="2" class="tth">Total</th>
                </tr>
                <tr>
                    <th class="tth">JML</th>
                    <th class="tth">SATUAN</th>
                </tr>
                
                <?php
                    $biaya=0;
                ?>
                @foreach(get_material_project($data->id) as $no=>$o)
                    <?php
                        $biaya+=$o->total;
                    ?>
                    <tr>
                        <td class="ttdc">{{$no+1}}</td>
                        <td class="ttd">{{$o->material_name}}</td>
                        <td class="ttdc">{{$o->qty}}</td>
                        <td class="ttdc">{{$o->satuan}}</td>
                        <td class="ttdl">{{uang($o->harga)}}</td>
                        <td class="ttdl">{{uang($o->total)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="ttdl" colspan="5">TOTAL</td>
                    <td class="ttdl">{{count_material_project($data->id)}}</td>
                </tr>
            </table><br>
            <table width="100%" border="1">
                <tr>
                    <td class="ttdf" colspan="6">C. PEMBIAYAAN LAINNYA</td>
                </tr>
                <tr>
                    <th  class="tth" width="5%">NO</th>
                    <th colspan="4" class="tth">Keterangan</th>
                    <th  class="tth">Total</th>
                </tr>
                @foreach(get_biaya_project($data->id) as $no=>$o)
                    <?php
                        $biaya+=$o->biaya;
                    ?>
                    <tr>
                        <td class="ttdc">{{$no+1}}</td>
                        <td class="ttd" colspan="4">{{$o->keterangan}}</td>
                        <td class="ttdl">{{uang($o->biaya)}}</td>
                    </tr>
                @endforeach
                <tr >
                    <td class="ttdl" colspan="5">TOTAL</td>
                    <td class="ttdl">{{count_biaya_project($data->id)}}</td>
                </tr>
            </table>
            
        </div>
        <div class="body" >
            <table width="100%" border="1">
                <tr>
                    <td class="ttdf" colspan="3">D. RISIKO PROJECA</td>
                </tr>
                <tr>
                    <th class="tth" width="5%">NO</th>
                    <th class="tth">Risiko</th>
                    <th class="tth"  width="20%">Tingkat</th>
                </tr>
                @foreach(get_risiko_project($data->id) as $no=>$o)
                    
                    <tr>
                        <td class="ttdc">{{$no+1}}</td>
                        <td class="ttd">{{$o->risiko}}</td>
                        <td class="ttd">{{$o->status_risiko}}</td>
                    </tr>
                @endforeach
            </table>
            <br>
            <table width="40%" border="1" align="right">
               
                    <tr>
                        <td class="ttd" style="background:aqua" colspan="2">TOTAL BIAYA</td>
                    </tr>
                    <tr>
                        <td class="ttdl">Biaya Material</td>
                        <td class="ttdl" width="30%">{{count_material_project($data->id)}}</td>
                    </tr>
                    <tr>
                        <td class="ttdl">Biaya Operasional</td>
                        <td class="ttdl">{{count_biaya_project($data->id)}}</td>
                    </tr>
               
            </table>
        </div>
    </body>
</html>