 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0"><?= $title ?></h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="/Admin">Dashboard</a></li>
             <li class="breadcrumb-item active"><?= $title ?></li>
           </ol>
         </div><!-- /.col -->
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->

   <!-- Main content -->
   <div class="content">
     <div class="container-fluid">
       <div class="row">
         <div class="col-lg-12">
           <div class="card">
             <div class="card-header d-flex p-0">
               <h3 class="card-title p-3">Tabel <?= $title ?></h3>
               <ul class="nav nav-pills ml-auto p-2">
                 <li class="nav-item btn-primary">
                   <button type="button" class="btn nav-link tomboltambah" style="color:aliceblue"><i class="fas fa-plus"></i> Tambah</button>
                 </li>
                 <li class="nav-item btn-info">
                   <button type="button" class="btn nav-link tombolgenerate" style="color:aliceblue"><i class="fas fa-user-plus"></i> Generate</button>
                 </li>
               </ul>
             </div>
             <!-- /.card-header -->
             <div class="card-body">
               <p class="card-text viewdata">

               </p>
             </div>
             <!-- /.card-body -->
           </div>
           <!-- /.card -->
         </div>
       </div>
       <!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->

 <?php if ($title == "Akun Admin") : ?>
   <script>
     function dataadmin() {
       $.ajax({
         url: "<?= site_url('User/ambiladmin') ?>",
         dataType: "json",
         beforeSend: function() {
           $('.viewdata').html('<div class="overlay"><h3><i class="fa fa-spin fa-spinner"></i> Loading...</h3></div>');
         },
         success: function(response) {
           $('.viewdata').html(response.data);
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       });
     }
     $(document).ready(function() {
       dataadmin();
       $('.tomboltambah').click(function(e) {
         e.preventDefault();
         $.ajax({
           url: "<?= site_url('Admin/formtambahjurusan') ?>",
           dataType: "json",
           beforeSend: function() {
             $(".tomboltambah").attr("disabled", "disable");
             $(".tomboltambah").html('<i class="fas fa-spin fa-spinner"></i> Loading...</a>');
           },
           success: function(response) {
             $(".tomboltambah").removeAttr("disabled");
             $(".tomboltambah").html('<i class="fas fa-plius"></i> Tambah</a>');
             $('.viewmodal').html(response.data).show();
             $('#modaltambahjurusan').modal('show');
           }

         });
       })
     })

     function edit(id_jurusan) {
       $.ajax({
         type: "post",
         url: "<?= site_url('Admin/formeditjurusan') ?>",
         data: {
           id_jurusan: id_jurusan
         },
         dataType: "json",
         success: function(response) {
           if (response.data) {
             $('.viewmodal').html(response.data).show();
             $('#modaleditjurusan').modal('show');
           }
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       })
     }

     function hapus(id_jurusan) {
       $.ajax({
         type: "post",
         url: "<?= site_url('Admin/cekhapusjurusan') ?>",
         data: {
           id_jurusan: id_jurusan
         },
         dataType: "json",
         success: function(response) {
           if (response.error) {
             if (response.error.id_jurusan) {
               Swal.fire({
                 icon: 'error',
                 title: 'Peringatan',
                 text: response.error.id_jurusan,
                 showConfirmButton: true,
               });
             }
           } else {
             Swal.fire({
               title: `Yakin Hapus Jurusan Ini ?`,
               text: 'Jurusan yang terhapus tidak dapat dikembalikan !',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Hapus',
               cancelButtonText: 'Batal',
             }).then((result) => {
               if (result.isConfirmed) {
                 $.ajax({
                   type: "post",
                   url: "<?= site_url('Admin/hapusjurusan') ?>",
                   data: {
                     id_jurusan: id_jurusan
                   },
                   dataType: "json",
                   success: function(response) {
                     if (response.sukses) {
                       Swal.fire({
                         position: 'top',
                         toast: 'false',
                         icon: 'success',
                         title: response.sukses,
                         showConfirmButton: false,
                         timer: 3000
                       });
                       datajurusan();
                     }
                   },
                   error: function(xhr, ajaxOption, trhownError) {
                     alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
                   }
                 })
               }
             })
           }
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       })

     }
   </script>
 <?php elseif ($title == "Akun PTK") : ?>
   <script>
     function dataptk() {
       $.ajax({
         url: "<?= site_url('User/ambilptk') ?>",
         dataType: "json",
         beforeSend: function() {
           $('.viewdata').html('<div class="overlay"><h3><i class="fa fa-spin fa-spinner"></i> Loading...</h3></div>');
         },
         success: function(response) {
           $('.viewdata').html(response.data);
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       });
     }
     $(document).ready(function() {
       dataptk();
     })

     $('.tombolgenerate').click(function(e) {
       e.preventDefault();
       $.ajax({
         url: "<?= site_url('User/regis_user') ?>",
         dataType: "json",
         beforeSend: function() {
           $(".tombolgenerate").attr("disabled", "disable");
           $(".tombolgenerate").html('<i class="fas fa-spin fa-spinner"></i> Generating...</a>');
         },
         success: function(response) {
           $(".tombolgenerate").removeAttr("disabled");
           $(".tombolgenerate").html('<i class="fas fa-user-plus"></i> Generate</a>');
           if (response.sukses) {
             Swal.fire({
               icon: 'success',
               title: "Generate User Berhasil",
               text: response.sukses,
               showConfirmButton: true,
             });
           }
           dataptk();
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       });
     })

     function edit(id_kelas) {
       $.ajax({
         type: "post",
         url: "<?= site_url('Admin/formeditkelas') ?>",
         data: {
           id_kelas: id_kelas
         },
         dataType: "json",
         success: function(response) {
           if (response.data) {
             $('.viewmodal').html(response.data).show();
             $('#modaleditkelas').modal('show');
           }
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       })
     }

     function siswa(id_kelas) {
       $.ajax({
         type: "post",
         url: "<?= site_url('Admin/modalsiswa') ?>",
         data: {
           id_kelas: id_kelas
         },
         dataType: "json",
         success: function(response) {
           if (response.data) {
             console.log(id_kelas)
             $('.viewmodal').html(response.data).show();
             $('#modalsiswa').modal('show');
           }
         },
         error: function(xhr, ajaxOption, trhownError) {
           alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
         }
       })
     }

     function hapus(username) {
       Swal.fire({
         title: `Yakin hapus user ` + username + `  ?`,
         text: 'User yang dihapus tidak akan dapat mengakses seluruh sistem !',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Hapus',
         cancelButtonText: 'Batal',
       }).then((result) => {
         if (result.isConfirmed) {
           $.ajax({
             type: "post",
             url: "<?= site_url('User/hapususerptk') ?>",
             data: {
               username: username
             },
             dataType: "json",
             success: function(response) {
               if (response.sukses) {
                 Swal.fire({
                   position: 'top',
                   toast: 'false',
                   icon: 'success',
                   title: response.sukses,
                   showConfirmButton: false,
                   timer: 3000
                 });
                 dataptk();
               }
             },
             error: function(xhr, ajaxOption, trhownError) {
               alert(xhr.status + "\n" + xhr.responseText + "\n" + trhownError);
             }
           })
         }
       })
     }
   </script>
 <?php endif ?>