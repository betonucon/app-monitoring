<?php

namespace App\Imports;
use App\Models\ProjectOperasional;
use App\Models\HeaderProject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportOperasional implements ToModel, WithStartRow
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
        if(($row[0]!=null || $row[0]!="") && ($row[1]!=null || $row[1]!="")){
            $mst=HeaderProject::where('id',$this->id)->first();
            if($mst->tab>2){
                $tab=$mst->tab;
            }else{
                $tab=4;
            }
            $header=HeaderProject::where('id',$this->id)->update(['tab'=>$tab]);
            return ProjectMaterial::UpdateOrcreate([
                'project_header_id'=>$this->id,
                'nama_material'=>$row[1],
                'status'=>1,
                
            ],[
                'biaya'=>ubah_uang($row[4]),
                'kode_material'=>0,
                
                'satuan_material'=>$row[3],
                'biaya_actual'=>ubah_uang($row[4]),
                'qty'=>ubah_uang($row[2]),
                'status_pengadaan'=>1,
                'total'=>(ubah_uang($row[4])*ubah_uang($row[2])),
                'total_actual'=>(ubah_uang($row[4])*ubah_uang($row[2])),
                'nama_material'=>$row[1],
                'created_at'=>date('Y-m-d H:i:s'),
            ]);
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
