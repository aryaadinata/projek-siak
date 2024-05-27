<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\TahunModel;
use App\Models\PtkModel;
use App\Libraries\Hash;

class Ptk extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
    }

    public function data_guru()
    {
        $userModel = new UserModel();
        $loggedAdmin = session()->get('loggedAdmin');
        $userInfo = $userModel->find($loggedAdmin);
        $data = [
            'title' => "Data Guru",
            'userInfo' => $userInfo,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('Ptk/viewPtk', $data);
        echo view('Layout/footer', $data);
    }

    function ambilguru()
    {
        if ($this->request->isAJAX()) {
            $ptkModel = new PtkModel();
            $guru = $ptkModel->where('jenis_ptk', 0)->findAll();
            $data = [
                'guru' => $guru,
            ];
            $msg = [
                'data' => view('Ptk/dataGuru', $data)
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function data_pegawai()
    {
        $userModel = new UserModel();
        $loggedAdmin = session()->get('loggedAdmin');
        $userInfo = $userModel->find($loggedAdmin);
        $data = [
            'title' => "Data Pegawai",
            'userInfo' => $userInfo,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('Ptk/viewPtk', $data);
        echo view('Layout/footer', $data);
    }

    function ambilpegawai()
    {
        if ($this->request->isAJAX()) {
            $ptkModel = new PtkModel();
            $pegawai = $ptkModel->where('jenis_ptk', 1)->findAll();
            $data = [
                'pegawai' => $pegawai
            ];
            $msg = [
                'data' => view('Ptk/dataPegawai', $data)
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    function formtambahguru()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('Ptk/modaltambahguru')
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function inputguru()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate(
                [
                    'nik' => [
                        'label' => "NIK",
                        'rules' => "required|is_unique[ptk.nik_ptk]",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique' => '{field} sudah terdaftar !',
                        ]
                    ],
                    'nuptk' => [
                        'label' => "NUPTK",
                        'rules' => "is_unique[ptk.nuptk]",
                        'errors' => [
                            'is_unique' => '{field} sudah terdaftar !',
                        ]
                    ],
                    'nama_ptk' => [
                        'label' => "Nama PTK",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'status_pegawai' => [
                        'label' => "Status Kepegawaian",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} wajib dipilih !'
                        ]
                    ],
                    'tempat_lahir' => [
                        'label' => "Tempat Lahir",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'tgl_lahir' => [
                        'label' => "Tanggal Lahir",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'jk' => [
                        'label' => "Jenis Kelamin",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} wajib dipilih !'
                        ]
                    ],
                    'no_hp' => [
                        'label' => "No. HP",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'email' => [
                        'label' => "Email",
                        'rules' => "permit_empty|valid_email|is_unique[ptk.email]",
                        'errors' => [
                            'valid_email' => '{field} tidak valid !',
                            'is_unique' => '{field} sudah terdaftar !'
                        ]
                    ],
                ]
            );
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nik' => $validation->getError('nik'),
                        'nik_en' => md5($validation->getError('nik')),
                        'nuptk' => $validation->getError('nuptk'),
                        'nama_ptk' => $validation->getError('nama_ptk'),
                        'status_pegawai' => $validation->getError('status_pegawai'),
                        'tempat_lahir' => $validation->getError('tempat_lahir'),
                        'tgl_lahir' => $validation->getError('tgl_lahir'),
                        'jk' => $validation->getError('jk'),
                        'no_hp' => $validation->getError('no_hp'),
                        'email' => $validation->getError('email'),
                    ]
                ];
            } else {
                $simpanptk = [
                    'nik_ptk' => $this->request->getVar('nik'),
                    'nama_ptk' => $this->request->getVar('nama_ptk'),
                    'gelar_depan' => $this->request->getVar('gelar_depan'),
                    'gelar_belakang' => $this->request->getVar('gelar_belakang'),
                    'jenis_ptk' => 0,
                    'nip' => $this->request->getVar('nip'),
                    'nuptk' => $this->request->getVar('nuptk'),
                    'tmp_lahir_ptk' => $this->request->getVar('tempat_lahir'),
                    'tgl_lahir_ptk' => $this->request->getVar('tgl_lahir'),
                    'jk_ptk' => $this->request->getVar('jk'),
                    'agama_ptk' => $this->request->getVar('agama'),
                    'alamat_ptk' => $this->request->getVar('alamat'),
                    'no_hp_ptk' => $this->request->getVar('no_hp'),
                    'email' => $this->request->getVar('email'),
                    'status_pegawai' => $this->request->getVar('status_pegawai'),
                ];
                $ptk = new PtkModel();
                $ptk->insert($simpanptk);
                $msg = [
                    'sukses' => 'Data guru berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Tidak Dapat Diproses");
        }
    }

    public function detailguru($nik)
    {
        $uri = service('uri');
        $ptkModel = new PTKModel();
        $ptk = $ptkModel->where('nik_en', $nik)->first();
        if ($uri->getSegment(1) == "lihatguru") {
            $title = "Detail Guru";
        } else {
            $title = "Detail Pegawai";
        }
        $data = [
            'title' => $title,
            'ptk' => $ptk,
            //'userInfo' => $userInfo,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('Ptk/viewDetailPtk', $data);
        echo view('Layout/footer', $data);
    }

    public function formeditptk()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getVar('nik');
            $ptkModel = new PTKModel();
            $ptk = $ptkModel->where('nik_ptk', $nik)->first();
            $data = [
                'ptk' => $ptk,
                //'tanggal_indo' => $this->tanggal_indo($ptk[0]["tanggal_lahir"]),
            ];
            $msg = [
                'data' => view('Ptk/editPtk', $data)
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function updateptk()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate(
                [
                    'nuptk' => [
                        'label' => "NUPTK",
                        'rules' => "is_unique[ptk.nuptk,nik_ptk," . $this->request->getVar('nik_ptk') . "]",
                        'errors' => [
                            'is_unique' => '{field} sudah terdaftar !'
                        ]
                    ],
                    'nama_ptk' => [
                        'label' => "Nama PTK",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'status_pegawai' => [
                        'label' => "Status Kepegawaian",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} wajib dipilih !'
                        ]
                    ],
                    'tempat_lahir' => [
                        'label' => "Tempat Lahir",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'tgl_lahir' => [
                        'label' => "Tanggal Lahir",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'jk' => [
                        'label' => "Jenis Kelamin",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} wajib dipilih !'
                        ]
                    ],
                    'no_hp' => [
                        'label' => "No. HP",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'email' => [
                        'label' => "Email",
                        'rules' => "required|valid_email|is_unique[ptk.email,nik_ptk," . $this->request->getVar('nik_ptk') . "]",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !',
                            'valid_email' => '{field} tidak valid !',
                            'is_unique' => '{field} sudah digunakan !'
                        ]
                    ],
                ]
            );
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nuptk' => $validation->getError('nuptk'),
                        'nama_ptk' => $validation->getError('nama_ptk'),
                        'status_pegawai' => $validation->getError('status_pegawai'),
                        'tempat_lahir' => $validation->getError('tempat_lahir'),
                        'tgl_lahir' => $validation->getError('tgl_lahir'),
                        'jk' => $validation->getError('jk'),
                        'no_hp' => $validation->getError('no_hp'),
                        'email' => $validation->getError('email'),
                    ]
                ];
            } else {
                $nik = $this->request->getVar('nik_ptk');
                $simpanptk = [
                    'nik_ptk' => $this->request->getVar('nik_ptk'),
                    'nama_ptk' => $this->request->getVar('nama_ptk'),
                    'gelar_depan' => $this->request->getVar('gelar_depan'),
                    'gelar_belakang' => $this->request->getVar('gelar_belakang'),
                    'nip' => $this->request->getVar('nip'),
                    'nuptk' => $this->request->getVar('nuptk'),
                    'tmp_lahir_ptk' => $this->request->getVar('tempat_lahir'),
                    'tgl_lahir_ptk' => $this->request->getVar('tgl_lahir'),
                    'jk_ptk' => $this->request->getVar('jk'),
                    'agama_ptk' => $this->request->getVar('agama'),
                    'alamat_ptk' => $this->request->getVar('alamat'),
                    'no_hp_ptk' => $this->request->getVar('no_hp'),
                    'email' => $this->request->getVar('email'),
                    'status_pegawai' => $this->request->getVar('status_pegawai'),
                ];
                $ptk = new PtkModel();
                $ptk->update($nik, $simpanptk);
                $msg = [
                    'sukses' => 'Data siswa berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Tidak Dapat Diproses");
        }
    }

    function ambildetailptk($nik)
    {
        //if ($this->request->isAJAX()) {
        $ptkModel = new PtkModel();
        $ptk = $ptkModel->where('nik_ptk', $nik)->findAll();
        if ($ptk[0]["tgl_lahir_ptk"] != 0) {
            $tanggal_indo = $this->tanggal_indo($ptk[0]["tgl_lahir_ptk"]);
        } else {
            $tanggal_indo = "";
        }
        $data = [
            'ptk' => $ptk,
            'tanggal_indo' => $tanggal_indo,
        ];
        $msg = [
            'data' => view('Ptk/detailPtk', $data)
        ];
        echo json_encode($msg);
        // } else {
        //     exit("Tidak dapat diproses");
        // }
    }

    public function uploadfoto()
    {
        $uri = service('uri');
        $nik = $this->request->getVar("nik_ptk");
        $validation = \config\Services::validation();
        $valid = $this->validate([
            'foto' => [
                'label' => "Foto",
                'rules' => 'uploaded[foto]|ext_in[foto,jpg]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih {field} Terlebih Dahulu !',
                    'ext_in' => '{field} harus ekstensi jpg',
                    'max_size' => 'Size {field} maksimal 1 MB',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ]
            ],
        ]);
        if (!$valid) {
            $this->session->setFlashdata('foto', $validation->getError('foto'));
            return redirect()->back();
        } else {
            $foto = $this->request->getFile('foto');
            $ext = $foto->getClientExtension();
            $ptkModel = new PtkModel();
            $namaFoto = $nik . "." . $ext;
            $foto->move("dist/img/pasfotoptk", $namaFoto, true);
            //$foto->move("dist/img/pasfoto" . 'uploads', null, true);

            $simpandata = [
                'foto' => $namaFoto,
            ];
            $ptkModel->update($nik, $simpandata);

            $this->session->setFlashdata('suksesupload', "Upload Foto Berhasil");
            return redirect()->back();
        }
    }

    function formtambahpegawai()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('Ptk/modaltambahpegawai')
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function inputpegawai()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $valid = $this->validate(
                [
                    'nik' => [
                        'label' => "NIK",
                        'rules' => "required|is_unique[ptk.nik_ptk]",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique' => '{field} sudah terdaftar !',
                        ]
                    ],
                    'nuptk' => [
                        'label' => "NUPTK",
                        'rules' => "required|is_unique[ptk.nuptk]",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique' => '{field} sudah terdaftar !',
                        ]
                    ],
                    'nama_ptk' => [
                        'label' => "Nama PTK",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'status_pegawai' => [
                        'label' => "Status Kepegawaian",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} wajib dipilih !'
                        ]
                    ],
                    'tempat_lahir' => [
                        'label' => "Tempat Lahir",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'tgl_lahir' => [
                        'label' => "Tanggal Lahir",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'jk' => [
                        'label' => "Jenis Kelamin",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} wajib dipilih !'
                        ]
                    ],
                    'no_hp' => [
                        'label' => "No. HP",
                        'rules' => "required",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !'
                        ]
                    ],
                    'email' => [
                        'label' => "Email",
                        'rules' => "required|valid_email|is_unique[ptk.email]",
                        'errors' => [
                            'required' => '{field} tidak boleh kosong !',
                            'valid_email' => '{field} tidak valid !',
                            'is_unique' => '{field} sudah terdaftar !'
                        ]
                    ],
                ]
            );
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nik' => $validation->getError('nik'),
                        'nuptk' => $validation->getError('nuptk'),
                        'nama_ptk' => $validation->getError('nama_ptk'),
                        'status_pegawai' => $validation->getError('status_pegawai'),
                        'tempat_lahir' => $validation->getError('tempat_lahir'),
                        'tgl_lahir' => $validation->getError('tgl_lahir'),
                        'jk' => $validation->getError('jk'),
                        'no_hp' => $validation->getError('no_hp'),
                        'email' => $validation->getError('email'),
                    ]
                ];
            } else {
                $simpanptk = [
                    'nik_ptk' => $this->request->getVar('nik'),
                    'nama_ptk' => $this->request->getVar('nama_ptk'),
                    'gelar_depan' => $this->request->getVar('gelar_depan'),
                    'gelar_belakang' => $this->request->getVar('gelar_belakang'),
                    'jenis_ptk' => 1,
                    'nip' => $this->request->getVar('nip'),
                    'nuptk' => $this->request->getVar('nuptk'),
                    'tmp_lahir_ptk' => $this->request->getVar('tempat_lahir'),
                    'tgl_lahir_ptk' => $this->request->getVar('tgl_lahir'),
                    'jk_ptk' => $this->request->getVar('jk'),
                    'agama_ptk' => $this->request->getVar('agama'),
                    'alamat_ptk' => $this->request->getVar('alamat'),
                    'no_hp_ptk' => $this->request->getVar('no_hp'),
                    'email' => $this->request->getVar('email'),
                    'status_pegawai' => $this->request->getVar('status_pegawai'),
                ];
                $ptk = new PtkModel();
                $ptk->insert($simpanptk);
                $msg = [
                    'sukses' => 'Data pegawai berhasil disimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Tidak Dapat Diproses");
        }
    }

    function formimportsiswa()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('Admin/modalimport')
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak dapat diproses");
        }
    }

    public function importptk()
    {
        $validation = \config\Services::validation();
        $valid = $this->validate([
            'ptk' => [
                'label' => "File",
                'rules' => 'uploaded[ptk]|ext_in[ptk,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Pilih {field} Terlebih Dahulu !',
                    'ext_in' => '{field} harus ekstensi xls atau xlsx',
                ]
            ],
        ]);
        if (!$valid) {
            $this->session->setFlashdata('ptk', $validation->getError('ptk'));
            if ($this->request->getVar("jenis_ptk") == 0) {
                return redirect()->to('/importguru');
            } else {
                return redirect()->to('/importpegawai');
            }
        } else {
            $file_excel = $this->request->getFile('ptk');
            $ext = $file_excel->getClientExtension();
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file_excel);
            $data = $spreadsheet->getActiveSheet()->toArray();
            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue;
                }
                $simpanptk = [
                    'nik_ptk' => $row[0],
                    'nik_en' => md5($row[0]),
                    'nama_ptk' => $row[1],
                    'gelar_depan' => $row[2],
                    'gelar_belakang' => $row[3],
                    'jenis_ptk' => $this->request->getVar("jenis_ptk"),
                    'status_pegawai' => $row[4],
                    'nip' => $row[5],
                    'nuptk' => $row[6],
                    'tmp_lahir_ptk' => $row[7],
                    'tgl_lahir_ptk' => $row[8],
                    'jk_ptk' => $row[9],
                    'agama_ptk' => $row[10],
                    'alamat_ptk' => $row[11],
                    'no_hp_ptk' => $row[12],
                    'email' => $row[13],
                ];
                $ptk = new PtkModel();
                $ptk->insert($simpanptk);
            }
            $this->session->setFlashdata('suksesimport', "Import PTK Berhasil");
            if ($this->request->getVar("jenis_ptk") == 0) {
                return redirect()->to('/importguru');
            } else {
                return redirect()->to('/importpegawai');
            }
        }
    }

    function viewimport()
    {
        $uri = service('uri');
        $userModel = new UserModel();
        $loggedAdmin = session()->get('loggedAdmin');
        $userInfo = $userModel->find($loggedAdmin);
        $jurusanModel = new JurusanModel();
        $jurusan = $jurusanModel->findAll();
        $kelasModel = new KelasModel();
        $kelas = $kelasModel->findAll();
        if ($uri->getSegment(1) == "importguru") {
            $jenis_ptk = 0;
        } else {
            $jenis_ptk = 1;
        }
        $data = [
            'title' => "Import PTK",
            'jenis_ptk' => $jenis_ptk,
            'userInfo' => $userInfo,
        ];
        echo view('Layout/header', $data);
        echo view('Layout/sidebar', $data);
        echo view('Ptk/importptk', $data);
        echo view('Layout/footer', $data);
    }

    function cekhapusguru()
    {
        if ($this->request->isAJAX()) {
            $validation = \config\Services::validation();
            $nik = $this->request->getVar('nik');
            $valid = $this->validate([
                'wali' => [
                    'label' => "Guru",
                    'rules' => "is_unique[kelas.wali_kelas]",
                    'errors' => [
                        'is_unique' => '{field} ini tidak boleh dihapus karena berstatus sebagai wali kelas !',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'wali' => $validation->getError('wali'),
                    ]
                ];
            } else {
                $msg = [
                    'sukses' => $this->request->getVar('nik')
                ];
            }
            echo json_encode($msg);
        } else {
            exit("Tidak Dapat Diproses");
        }
    }

    public function hapusptk()
    {
        if ($this->request->isAJAX()) {
            $ptk = new PtkModel();
            $id = $this->request->getVar('nik');
            $ptk->delete($id);
            $msg = [
                'sukses' => 'PTK berhasil dihapus !'
            ];
            echo json_encode($msg);
        } else {
            exit("Tidak Dapat Diproses");
        }
    }

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
}
