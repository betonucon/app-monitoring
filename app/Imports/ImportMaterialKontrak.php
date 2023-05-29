<?php

namespace App\Imports;
use App\Models\ProjectMaterial;
use App\Models\HeaderProject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class ImportMaterialKontrak implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $id;
    public function __construct(int $id)
    {
        $this->id = $id; 
    }
    
    public function model(array $row)
    {
        if(($row[0]!=null || $row[0]!="") && ($row[2]!=null || $row[2]!="")){
            $mst=HeaderProject::where('id',$this->id)->first();
            $header=HeaderProject::where('id',$this->id)->update(['tab'=>$tab]);
            if($mst->tab>2){
                $tab=$mst->tab;
            }else{
                $tab=4;
            }
            if($row[1]=='MAT'){
                $save=ProjectMaterial::UpdateOrcreate([
                    'project_header_id'=>$this->id,
                    'nama_material'=>$row[2],
                    'status'=>1,
                    'kategori_ide'=>1,
                    'state'=>2,
                ],[
                    'biaya'=>ubah_uang($row[5]),
                    'kode_material'=>0,
                    
                    'satuan_material'=>$row[4],
                    'biaya_actual'=>ubah_uang($row[5]),
                    'qty'=>ubah_uang($row[3]),
                    'qty_out'=>0,
                    'status_pengadaan'=>1,
                    'total'=>(ubah_uang($row[5])*ubah_uang($row[3])),
                    'total_actual'=>(ubah_uang($row[5])*ubah_uang($row[3])),
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
            }
            if($row[1]=='OPR'){
                $save=ProjectMaterial::UpdateOrcreate([
                    'project_header_id'=>$this->id,
                    'nama_material'=>$row[2],
                    'status'=>1,
                    'kategori_ide'=>2,
                    'state'=>2,
                ],[
                    'biaya'=>ubah_uang($row[4]),
                    'kode_material'=>0,
                    
                    'satuan_material'=>'Item',
                    'biaya_actual'=>ubah_uang($row[4]),
                    'qty'=>ubah_uang($row[3]),
                    'qty_out'=>0,
                    'status_pengadaan'=>1,
                    'total'=>(ubah_uang($row[4])*ubah_uang($row[3])),
                    'total_actual'=>(ubah_uang($row[4])*ubah_uang($row[3])),
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
            }
            if($row[1]=='JASA'){
                $save=ProjectMaterial::UpdateOrcreate([
                    'project_header_id'=>$this->id,
                    'nama_material'=>$row[2],
                    'status'=>1,
                    'kategori_ide'=>3,
                    'state'=>2,
                    
                ],[
                    'biaya'=>ubah_uang($row[4]),
                    'kode_material'=>0,
                    'qty_out'=>0,
                    'satuan_material'=>'Item',
                    'biaya_actual'=>ubah_uang($row[4]),
                    'qty'=>ubah_uang($row[3]),
                    'status_pengadaan'=>1,
                    'total'=>(ubah_uang($row[4])*ubah_uang($row[3])),
                    'total_actual'=>(ubah_uang($row[4])*ubah_uang($row[3])),
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
            }
            
            return $save;
        }
        
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 4;
    }
}
