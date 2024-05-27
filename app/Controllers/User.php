<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\TahunModel;
use App\Models\PtkModel;
use App\Libraries\Hash;

class User extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function admin()
    {
        $userModel = new UserModel();
        $loggedAdmin = session()->get('loggedAdmin');
        $userInfo = $userModel->find($loggedAdmin);
        $data = [
            'title' => "Akun Admin",
            'userInfo' => $userInfo,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('User/viewUser', $data);
        echo view('Layout/footer', $data);
    }

    function ambiladmin()
    {
        if ($this->request->isAJAX()) {
            $userModel = new UserModel();
            $admin = $userModel->where("level", 0)->findAll();
            $data = [
                'admin' => $admin,
            ];
            $msg = [
                'data' => view('User/dataAdmin', $data)
            ];
            echo json_encode($msg);
        } else {
            return redirect()->back();
        }
    }

    public function akun_ptk()
    {
        $userModel = new UserModel();
        $loggedAdmin = session()->get('loggedAdmin');
        $userInfo = $userModel->find($loggedAdmin);
        $data = [
            'title' => "Akun PTK",
            'userInfo' => $userInfo,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('User/viewUser', $data);
        echo view('Layout/footer', $data);
    }

    function ambilptk()
    {
        if ($this->request->isAJAX()) {
            $userModel = new UserModel();
            $ptk = $userModel->where("level", 1)->findAll();
            $data = [
                'ptk' => $ptk,
            ];
            $msg = [
                'data' => view('User/dataPTK', $data)
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function regis_user()
    {
        ini_set('max_execution_time', -1);
        if ($this->request->isAJAX()) {
            $ptkModel = new PtkModel();
            $ptk = $ptkModel->findAll();
            $userModel = new UserModel();
            $jml = 0;
            //$batchInsertData = [];

            foreach ($ptk as $ptkData) {
                $existingUser = $userModel->where('username', $ptkData["nik_ptk"])->first();
                if (!$existingUser) {
                    $values = [
                        "username" => $ptkData["nik_ptk"],
                        "nama" => $ptkData["nama_ptk"],
                        "pass" => Hash::make($this->tanggal_password($ptkData["tgl_lahir_ptk"])),
                        "level" => "1",
                    ];
                    //$batchInsertData[] = $values;
                    $userModel->insert($values);
                    $jml++;
                }
            }

            // // Memasukkan data dalam potongan-potongan kecil
            // $chunkSize = 100; // Atur ukuran potongan sesuai dengan kebutuhan Anda
            // foreach (array_chunk($batchInsertData, $chunkSize) as $chunk) {
            //     $userModel->chunkInsert($chunk);
            // }

            if ($jml > 0) {
                $msg = [
                    'sukses' => $jml . ' user PTK berhasil digenerate dengan password default tanggal lahir (ddmmyyy)'
                ];
            } else {
                $msg = [
                    'sukses' => ' Tidak ada user baru Digenerate !'
                ];
            }
            echo json_encode($msg);
        } else {
            return redirect()->back();
        }
    }

    public function hapususerptk()
    {
        if ($this->request->isAJAX()) {
            $user = new UserModel();
            $username = $this->request->getVar('username');
            $user->delete($username);
            $msg = [
                'sukses' => 'User berhasil dihapus !'
            ];
            echo json_encode($msg);
        } else {
            return redirect()->back();
        }
    }

    private function tanggal_password($tanggal)
    {
        $split = explode('-', $tanggal);
        return $split[2] . $split[1] . $split[0];
    }
}
