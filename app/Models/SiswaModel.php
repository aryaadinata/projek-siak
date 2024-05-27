<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = "siswa";
    protected $primaryKey = "nis";
    protected $allowedFields = [
        "nis", "nis_en", 'nisn', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jk',  'agama', "alamat", 'no_hp', 'email', 'alamat_ortu',
        'nama_ayah', "nama_ibu", "sekolah_asal", "foto", "tahun_masuk", 'id_kelas', "status_aktif", "tahun_out"
    ];

    public function countSiswa($status_aktif, $jk = null)
    {
        $builder = $this->builder();
        $builder->selectCount('nisn');

        if ($jk) {
            $builder->where('status_aktif', $status_aktif)->where('jk', $jk);
        } else {
            $builder->where('status_aktif', $status_aktif);
        }

        return $builder->countAllResults();
    }

    public function siswajoinkelas($id_kelas)
    {
        $builder = $this->db->table('siswa');
        $builder->select('*');
        $builder->join('kelas', 'siswa.id_kelas = kelas.id_kelas');
        $builder->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan');
        $builder->where("siswa.id_kelas", $id_kelas);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getSiswaByParameters($id_tingkat, $id_jurusan, $id_kelas)
    {
        $builder = $this->db->table('siswa');
        $builder->select('*');
        $builder->join('kelas', 'siswa.id_kelas = kelas.id_kelas', 'left');
        $builder->orderby('siswa.id_kelas,nama', 'ASC');
        $builder->where('siswa.status_aktif', 0);

        // Filter berdasarkan id_tingkat, id_jurusan, dan id_kelas jika tersedia
        if (!empty($id_tingkat)) {
            $builder->where('kelas.id_tingkat', $id_tingkat);
        }
        if (!empty($id_jurusan)) {
            $builder->where('kelas.id_jurusan', $id_jurusan);
        }
        if (!empty($id_kelas)) {
            $builder->where('siswa.id_kelas', $id_kelas);
        } else {
            $builder->where('siswa.id_kelas', null);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getSiswa()
    {
        $builder = $this->db->table('siswa');
        $builder->select('*');
        $builder->join('kelas', 'siswa.id_kelas = kelas.id_kelas', 'left');
        $builder->orderby('siswa.id_kelas,nama', 'ASC');
        $builder->where('siswa.status_aktif', 0);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function biodatasiswa($nis)
    {
        $builder = $this->db->table('siswa');
        $builder->select('*');
        $builder->join('kelas', 'siswa.id_kelas = kelas.id_kelas', 'left');
        $builder->where("nis", $nis);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function ambildatalulus($id_tahun)
    {
        $builder = $this->db->table('siswa');
        $builder->select('*');
        $builder->join('kelas', 'siswa.id_kelas = kelas.id_kelas');
        $builder->join('jurusan', 'kelas.id_jurusan = jurusan.id_jurusan');
        $builder->where("status_aktif", 1);
        $builder->where("tahun_out", $id_tahun);
        $query = $builder->get();
        return $query->getResultArray();
    }
    // protected $table = 'pendidikan';
    // protected $primaryKey = 'id';
    // protected $allowedFields = ['jenjang', 'instansi', 'jurusan', 'tahun_masuk_lulus', 'no_ijazah', 'no_transkrip', 'file'];
}
