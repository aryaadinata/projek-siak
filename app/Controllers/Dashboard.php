<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\PtkModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        helper(['url']);
    }

    public function index()
    {
        $userModel = new UserModel();
        $loggedAdmin = session()->get('loggedAdmin');
        $userInfo = $userModel->find($loggedAdmin);
        // $jmlSiswa = $this->db->query("SELECT COUNT(nisn) as jml FROM siswa WHERE status_aktif=0");
        // $jmlSiswa = $jmlSiswa->getResultArray();
        // $jmlSiswaL = $this->db->query("SELECT COUNT(nisn) as jml FROM siswa WHERE status_aktif=0 AND jk='L'");
        // $jmlSiswaL = $jmlSiswaL->getResultArray();
        // $jmlSiswaP = $this->db->query("SELECT COUNT(nisn) as jml FROM siswa WHERE status_aktif=0 AND jk='P'");
        // $jmlSiswaP = $jmlSiswaP->getResultArray();
        // $jmlSiswa0 = $this->db->query("SELECT COUNT(nisn) as jml FROM siswa WHERE status_aktif=1");
        // $jmlSiswa0 = $jmlSiswa0->getResultArray();
        // $jmlGuru = $this->db->query("SELECT COUNT(nik_ptk) as jml FROM ptk WHERE jenis_ptk=0");
        // $jmlGuru = $jmlGuru->getResultArray();
        $siswaModel = new SiswaModel();

        $jmlSiswa = $siswaModel->countSiswa(0);
        $jmlSiswaL = $siswaModel->countSiswa(0, 'L');
        $jmlSiswaP = $siswaModel->countSiswa(0, 'P');
        $jmlSiswa0 = $siswaModel->countSiswa(1);

        $guruModel = new PtkModel();
        $jmlGuru = $guruModel->countGuru(0);

        $data = [
            'title' => "Dashboard",
            'userInfo' => $userInfo,
            'jmlsiswa' => $jmlSiswa,
            'jmlsiswaL' => $jmlSiswaL,
            'jmlsiswaP' => $jmlSiswaP,
            'jmlsiswa0' => $jmlSiswa0,
            'jmlguru' => $jmlGuru,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('Dashboard/dashboard', $data);
        echo view('Layout/footer', $data);
    }
}
