<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\PrestasiModel;
use App\Models\PelanggaranModel;

use CodeItNow\BarcodeBundle\Utils\QrCode;
use App\Models\SekolahModel;

class Penunjang extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        echo "siak";
    }

    public function prestasi()
    {
        $nisn = session()->get('loggedSiswa');
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($nisn);
        $data = [
            'title' => "Prestasi",
            'siswa' => $siswa,
            //'userInfo' => $userInfo,
        ];
        echo view('Layout_siswa/header', $data);
        echo view('Layout_siswa/sidebar', $data);
        echo view('Siswa/viewPenunjang', $data);
        echo view('Layout_siswa/footer', $data);
    }


    public function ambilprestasi()
    {
        if ($this->request->isAJAX()) {
            $nis = session()->get('loggedSiswa');
            $prestasiModel = new PrestasiModel();
            $prestasi = $prestasiModel->where('nis', $nis)->findAll();
            $data = [
                'prestasi' => $prestasi,
            ];
            $msg = [
                'data' => view('Siswa/isiPrestasi', $data)
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function pelanggaran()
    {
        $nisn = session()->get('loggedSiswa');
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($nisn);
        $data = [
            'title' => "Pelanggaran",
            'siswa' => $siswa,
            //'userInfo' => $userInfo,
        ];
        echo view('Layout_siswa/header', $data);
        echo view('Layout_siswa/sidebar', $data);
        echo view('Siswa/viewPenunjang', $data);
        echo view('Layout_siswa/footer', $data);
    }


    public function ambilpelanggaran()
    {
        if ($this->request->isAJAX()) {
            $nis = session()->get('loggedSiswa');
            $pelanggaranModel = new PelanggaranModel();
            $pelanggaran = $pelanggaranModel->getPelanggaran($nis);
            $data = [
                'pelanggaran' => $pelanggaran,
            ];
            $msg = [
                'data' => view('Siswa/isiPelanggaran', $data)
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    //---------------------------------------------------------------------------------------

    private function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }

    private function tanggal_balik($tanggal)
    {
        $bulan = array(
            'Januari' => "01",
            'Februari' => "02",
            'Maret' => "03",
            'April' => "04",
            'Mei' => "05",
            'Juni' => "06",
            'Juli' => "07",
            'Agustus' => "08",
            'September' => "09",
            'Oktober' => "10",
            'November' => "11",
            'Desember' => "12",
        );
        $split = explode('-', $tanggal);
        //echo $split[2];
        return $split[2] . '-' . $split[1] . '-' . $split[0];
    }
}
