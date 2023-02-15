<?php

function name(){
   return "PT.UCON BETON";
}
function alamat(){
   return "Link Jombang Kali, Kel Masigit Kec Jombang";
}
function email(){
   return "uconbeton@gmail.com";
}
function phone(){
   return "082312053337";
}
function pimpinan(){
   return "SOLAWAT S.E";
}
function tanggal_indo_lengkap($date){
   return date('d-m-Y H:i:s',strtotime($date));
}
function tanggal_indo($date){
   return date('d M,Y',strtotime($date));
}
function no_decimal($nilai){
   return number_format($nilai, 0, '.', '');
}
function jam($date=null){
   if($date==""){
      return null;
   }else{
      return date('H:i:s',strtotime($date));
   }
   
}
function sekarang(){
   return date('Y-m-d H:i:s');
}
function selisih_waktu($waktu1,$waktu2){
   $waktu_awal        =strtotime($waktu1);
   $waktu_akhir    =strtotime($waktu2); // bisa juga waktu sekarang now()
   $diff    =$waktu_akhir - $waktu_awal;
   $jam    =floor($diff / (60 * 60));
   $menit    =$diff - $jam * (60 * 60);
   $data= $jam.'.'. floor( $menit / 60 );
   return $data;
}
function bulan_int($bulan)
{
   Switch ($bulan){
      case 1 : $bulan="Januari";
         Break;
      case 2 : $bulan="Februari";
         Break;
      case 3 : $bulan="Maret";
         Break;
      case 4 : $bulan="April";
         Break;
      case 5 : $bulan="Mei";
         Break;
      case 6 : $bulan="Juni";
         Break;
      case 7 : $bulan="Juli";
         Break;
      case 8 : $bulan="Agustus";
         Break;
      case 9 : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}

function ubah_uang($uang){
   $patr='/([^0-9]+)/';
   $ug=explode('.',$uang);
   $data=preg_replace($patr,'',$ug[0]);
   return $data;
}
function ubah_bulan($bulan){
   if($bulan>9){
      return '0'.$bulan;
   }else{
      return $bulan;
   }
   
}
function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}
function uang_pembulat($nil){
   return number_format($nil);
}
function uang($nil){
   return number_format($nil,0);
}
function no_sepasi($text){
   return str_replace(' ', '_', $text);
}
function encoder($b) {
   $data=base64_encode(base64_encode($b));
   return $data;
}
function decoder($b) {
   $data=base64_decode(base64_decode($b));
   return $data;
}
function link_dokumen($file){
   $curl = curl_init();
     curl_setopt ($curl, CURLOPT_URL, "".url_plug()."/".$file);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

     $result = curl_exec ($curl);
     curl_close ($curl);
   print $result;
}
function url_plug(){
    $data=url('/public/');
    return $data;
}
function barcoderider($id,$w,$h){
    $d = new Milon\Barcode\DNS2D();
    $d->setStorPath(__DIR__.'/cache/');
    return $d->getBarcodeHTML($id, 'QRCODE',$w,$h);
}
function barcoderr($id){
    $d = new Milon\Barcode\DNS2D();
    $d->setStorPath(__DIR__.'/cache/');
    return $d->getBarcodePNGPath($id, 'PDF417');
}
function parsing_validator($url){
    $content=utf8_encode($url);
    $data = json_decode($content,true);
 
    return $data;
}

function tanggal_indo_full($tgl){
    $data=date('d/m/Y H:i:s',strtotime($tgl));
    return $data;
}
function tanggal_indo_only($tgl){
    $data=date('Y-m-d',strtotime($tgl));
    return $data;
}
function prev_tanggal($tgl,$param){
   $tanggal=$tgl;
   $data    =date('Y-m-d 00:00:00.000', strtotime("$param days", strtotime($tanggal)));
   return $data;
}
function tanggal_tempo($param){
   $tanggal=date('Y-m-d');
   $data    =date('Y-m-d 00:00:00.000', strtotime("$param days", strtotime($tanggal)));
   return $data;
}

function penomoran_customer(){
    
    $cek=App\Models\Customer::count();
    if($cek>0){
        $mst=App\Models\Customer::orderBy('customer_code','Desc')->firstOrfail();
        $urutan = (int) substr($mst['customer_code'], 1, 5);
        $urutan++;
        $nomor='1'.sprintf("%05s",  $urutan);
    }else{
        $nomor='1'.sprintf("%05s",  1);
    }
    return $nomor;
}

function penomoran_cost_center($cost){
   $cs=strlen($cost);
    
    $cek=App\Models\HeaderProject::where('cost',$cost)->count();
    if($cek>0){
        $mst=App\Models\HeaderProject::where('cost',$cost)->orderBy('cost_center','Desc')->firstOrfail();
        $urutan = (int) substr($mst['cost_center'], (int)$cs, 3);
        $urutan++;
        $nomor=$cost.sprintf("%03s",  $urutan);
    }else{
        $nomor=$cost.sprintf("%03s",  1);
    }
    return $nomor;
}
function test_penomoran_cost_center($cost){
   $cs=strlen($cost);
    
    $cek=App\Models\HeaderProject::where('cost',$cost)->count();
    if($cek>0){
        $mst=App\Models\HeaderProject::where('cost',$cost)->orderBy('cost_center','Desc')->firstOrfail();
        $urutan = (int) substr($mst['cost_center'], $cs, 3);
        $nomor=$cost.sprintf("%03s",  ($urutan+1));
    }else{
        $nomor=$cost.sprintf("%03s",  1);
    }
    return $nomor;
}


?>