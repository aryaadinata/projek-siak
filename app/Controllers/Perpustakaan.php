<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\UserModel;
use App\Models\PengunjungModel;
use App\Models\PtkModel;
use App\Models\SiswaModel;

class Perpustakaan extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
    }

    public function kunjungan()
    {
        return view('Perpustakaan/kunjungan');
    }

    public function ambilpengunjung()
    {
        if ($this->request->isAJAX()) {
            $string = $this->request->getVar("id");
            $pieces = explode("/", $string);
            $id = end($pieces);
            $siswaModel = new SiswaModel();
            $siswa = $siswaModel->getSiswabynisn($id);
            // $builder = $this->db->table('siswa');
            // $builder->select('*');
            // $builder->join('kelas', 'siswa.id_kelas = kelas.id_kelas', 'left');
            // $builder->where("nisn_en", $id);
            // $builder->where("status_aktif", 0);
            // $query = $builder->get();
            // $siswa = $query->getResultArray();
            $ptkModel = new PtkModel();
            $ptk = $ptkModel->where("nik_en", $id)->first();
            // $builder = $this->db->table('ptk');
            // $builder->select('*');
            // $builder->where("nik_en", $id);
            // $query = $builder->get();
            // $ptk = $query->getResultArray();

            if (!empty($siswa)) {
                $siswa[0]['jam'] = date("H:i:s");
                $data = $siswa;
                $jenis = 0;
            } else if (!empty($ptk)) {
                $ptk[0]['jam'] = date("H:i:s");
                $data = $ptk;
                $jenis = 1;
            } else {
                $data = "";
                $jenis = "99";
            }
            $msg = [
                'data' => $data,
                'jenis' => $jenis,
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function ambildatapengunjung()
    {
        //if ($this->request->isAJAX()) {
        $pengunjungModel = new PengunjungModel();
        $siswa = $pengunjungModel->getTodayVisitors();
        $data = [
            'siswa' => $siswa,
        ];
        $msg = [
            'data' => view("Perpustakaan/tabelPengunjung", $data)
        ];
        echo json_encode($msg);
        // } else {
        //     exit("Tidak dapat diproses");
        // }
    }

    public function inputpengunjung()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getVar('jenis') == 0) {
                $simpanpengunjung = [
                    'id_siswa' => $this->request->getVar('id'),
                    'tgl_kunjungan' => date('Y-m-d'),
                    'jam' => date("H:i:s"),
                ];
            } else {
                $simpanpengunjung = [
                    'id_ptk' => $this->request->getVar('id'),
                    'tgl_kunjungan' => date('Y-m-d'),
                    'jam' => date("H:i:s"),
                ];
            }
            $pengunjung = new PengunjungModel();
            $pengunjung->insert($simpanpengunjung);
            $msg = [
                'sukses' => 'Data pengunjung berhasil disimpan'
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak Dapat Diproses");
        }
    }
}
