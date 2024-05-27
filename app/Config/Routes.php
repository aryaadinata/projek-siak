<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/Auth/cek_login/', 'Auth::cek_login');

$routes->group('', ['filter' => 'filterlogin'], function ($routes) {
    $routes->get('/Ptk/detailguru/(:num)', 'Ptk::detailguru');
    $routes->get('/lihatguru/(:any)', 'Ptk::detailguru/$1');
    $routes->get('/Dashboard', 'Dashboard::index');
    $routes->get('/dashboard', 'dashboard::index');
    $routes->get('/Dashboard/(:segment)', 'Dashboard::$1');
    $routes->get('/dashboard/(:segment)', 'dashboard::$1');
    $routes->get('/admin/(:segment)', 'admin::$1');
    $routes->get('/Admin/(:segment)', 'Admin::$1');
    $routes->get('/Admin/biodata/', 'Admin::biodata/');
    $routes->post('/Admin/ambilidentitas', 'Admin::ambilidentitas');
    $routes->post('/Admin/formeditidentitas', 'Admin::formeditidentitas');
    $routes->post('/Admin/updateidentitas', 'Admin::updateidentitas');
    $routes->post('/Admin/inputtahun', 'Admin::inputtahun');
    $routes->post('/Admin/formedittahun', 'Admin::formedittahun');
    $routes->post('/Admin/updatetahun', 'Admin::updatetahun');
    $routes->post('/Admin/cekhapustahun', 'Admin::cekhapustahun');
    $routes->post('/Admin/hapustahun', 'Admin::hapustahun');
    $routes->post('/Admin/inputjurusan', 'Admin::inputjurusan');
    $routes->post('/Admin/formeditjurusan', 'Admin::formeditjurusan');
    $routes->post('/Admin/updatejurusan', 'Admin::updatejurusan');
    $routes->post('/Admin/cekhapusjurusan', 'Admin::cekhapusjurusan');
    $routes->post('/Admin/hapusjurusan', 'Admin::hapusjurusan');
    $routes->post('/Admin/inputkelas', 'Admin::inputkelas');
    $routes->post('/Admin/modalsiswa', 'Admin::modalsiswa');
    $routes->post('/Admin/formeditkelas', 'Admin::formeditkelas');
    $routes->post('/Admin/updatekelas', 'Admin::updatekelas');
    $routes->post('/Admin/cekhapuskelas', 'Admin::cekhapuskelas');
    $routes->post('/Admin/hapuskelas', 'Admin::hapuskelas');
    $routes->post('/Admin/ambildata', 'Admin::ambildata');
    $routes->post('/Admin/formtambahsiswa', 'Admin::formtambahsiswa');
    $routes->post('/Admin/inputsiswa', 'Admin::inputsiswa');
    $routes->post('/Admin/importsiswa', 'Admin::importsiswa');
    $routes->post('/Admin/pilihjurusan', 'Admin::pilihjurusan');
    $routes->post('/Admin/pilihkelas', 'Admin::pilihkelas');
    $routes->post('Admin/ambilbiodata/(:num)', 'Admin::ambilbiodata/$1');
    $routes->post('Admin/formeditbiodata', 'Admin::formeditbiodata');
    $routes->post('Admin/uploadfoto', 'Admin::uploadfoto');
    $routes->post('Admin/updatebiodata', 'Admin::updatebiodata');
    $routes->post('Admin/ambildata1', 'Admin::ambildata1');
    $routes->post('Admin/ambildata2', 'Admin::ambildata2');
    $routes->post('Admin/kembalikan', 'Admin::kembalikan');
    $routes->post('Admin/naikkan', 'Admin::naikkan');
    $routes->post('Admin/luluskan', 'Admin::luluskan');
    $routes->post('Admin/ambildatalulus', 'Admin::ambildatalulus');

    $routes->get('/Ptk/(:segment)', 'Ptk::$1');
    //$routes->get('/dataguru', 'dataguru');
    //$routes->get('/lihatguru', 'lihatguru');
    //$routes->get('/datapegawai', 'datapegawai');
    //$routes->get('/lihatpegawai', 'lihatpegawai');
    $routes->get('/Perpustakaan', 'Perpustakaan::index');
    $routes->get('/Perpustakaan/(:segment)', 'Perpustakaan::$1');
    //$routes->get('/admin/buat_user', 'admin::buat_user', ['filter' => 'filterlogin']);

    $routes->get('/dataguru', 'Ptk::data_guru/');
    $routes->get('/Admin/biodatasiswa/(:num)', 'Admin::biodata/$1');
    $routes->get('/datapegawai', 'Ptk::data_pegawai');
    $routes->get('/lihatpegawai/(:num)', 'Ptk::detailguru/$1');
    $routes->get('/uploadfotoguru', 'Ptk::uploadfoto');
    $routes->get('/uploadfotopegawai', 'Ptk::uploadfoto');
    $routes->get('/importguru', 'Ptk::viewimport');
    $routes->get('/importpegawai', 'Ptk::viewimport');
    $routes->post('/Ptk/ambilguru/', 'Ptk::ambilguru');
    $routes->post('/Ptk/ambildetailptk/(:num)', 'Ptk::ambildetailptk/$1');
    $routes->post('/Ptk/uploadfoto', 'Ptk::uploadfoto');
    $routes->post('/Ptk/formtambahguru/', 'Ptk::formtambahguru');
    $routes->post('/Ptk/inputguru/', 'Ptk::inputguru');
    $routes->post('/Ptk/importptk/', 'Ptk::importptk');
    $routes->post('/Ptk/formeditptk', 'Ptk::formeditptk');
    $routes->post('/Ptk/updateptk', 'Ptk::updateptk');
    $routes->post('/Ptk/ambilpegawai/', 'Ptk::ambilpegawai');
    $routes->post('/Ptk/formtambahpegawai/', 'Ptk::formtambahpegawai');
    $routes->post('/Ptk/inputpegawai/', 'Ptk::inputpegawai');

    $routes->get('/User/admin', 'User::admin');
    $routes->get('/User/ambiladmin', 'User::ambiladmin');
    $routes->get('/User/akun_ptk', 'User::akun_ptk');
    $routes->get('/User/ambilptk', 'User::ambilptk');
    $routes->get('/User/regis_user', 'User::regis_user');
    $routes->post('/User/hapususerptk', 'User::hapususerptk');

    //$routes->get('/Auth/regis_user', 'Auth::regis_user');
});

$routes->group('', ['filter' => 'filtersiswa'], function ($routes) {
    $routes->get('/Siswa', 'Siswa::index');
    $routes->get('/Siswa/(:segment)', 'Siswa::$1');
    $routes->get('/Penunjang/(:segment)', 'Penunjang::$1');
    $routes->get('/Auth/ambilsession', 'Penunjang::prestasi');
});
