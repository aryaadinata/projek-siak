<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = "kelas";
    protected $primaryKey = "id_kelas";
    protected $allowedFields = ["id_kelas", 'nama_kelas', 'id_tingkat', 'id_jurusan', 'wali_kelas'];

    public function getJoinedData()
    {
        $builder = $this->db->table('kelas');
        $builder->select('kelas.*, tingkat.tingkat, jurusan.nama_jurusan, ptk.nama_ptk AS nama_wali_kelas');
        $builder->join('tingkat', 'kelas.id_tingkat = tingkat.id_tingkat');
        $builder->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan');
        $builder->join('ptk', 'ptk.nik_ptk = kelas.wali_kelas');
        $builder->orderBy('kelas.id_tingkat, kelas.nama_kelas', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }   
    
    public function getKelasByJurusanTingkat($id_jurusan, $id_tingkat)
    {
        return $this->where('id_jurusan', $id_jurusan)
                    ->where('id_tingkat', $id_tingkat)
                    ->findAll();
    }

    public function getKelasByTingkat($id_tingkat)
    {
        return $this->where('id_tingkat', $id_tingkat)
                    ->findAll();
    }
    // protected $table = 'pendidikan';
    // protected $primaryKey = 'id';
    // protected $allowedFields = ['jenjang', 'instansi', 'jurusan', 'tahun_masuk_lulus', 'no_ijazah', 'no_transkrip', 'file'];
}
