<?php

$user = user::getInstance($pdo);
$allUsers = $user->getAllUsers();
?>

<?php
if ($_SESSION['level'] == "common_user" || $_SESSION['level'] == "operator") {
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    return false;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $level = htmlspecialchars($_POST['level']);


    $success = $user->tambahUser($nama, $username, $email, $password, $level);

    if ($success) {
        echo   "<script>window.location.href = 'index.php?page=user&msg=1'</script>";
    } else {
        echo "Gagal menambahkan user.";
    }
}
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tabel User</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
                            Tambah Data
                        </button>
                        <br><br>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Level/Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($allUsers as $user) {
                                    $no++;
                                    echo "<tr>
                                        <td width='3%'>{$no}</td>
                                        <td>{$user['nama']}</td>
                                        <td>{$user['username']}</td>
                                        <td>{$user['level']}</td>
                                        <td>
                                            <a href='index.php?page=user&act=edit&id={$user['id']}' class='btn btn-success btn-sm'>Edit</a>
                                            <a onclick='hapus_data({$user['id']})' class='btn btn-danger btn-sm'>Hapus</a>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Level/Role</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambahkan Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label>Nama Lengkap</label>
                        </div>
                        <div class="col">
                            <label>Username</label>
                        </div>
                        <div class="col">
                            <label>Email</label>
                        </div>
                        <div class="col">
                            <label>Password</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div class="col">
                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <input type="text" hidden class="form-control" name="level" value="common_user">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  }

  document.addEventListener("DOMContentLoaded", function() {
    var msg = getUrlParameter('msg');
    if (msg == 1) { 
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data berhasil ditambahkan',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
    else if (msg == 2) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data berhasil diupdate',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }else if (msg == 3) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data berhasil dihapus',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
  });
</script>

<script>
function hapus_data(data_id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true
    })

    swalWithBootstrapButtons.fire({
        title: 'Yakin Menghapus Data?',
        text: "kamu tidak dapat memulihkannya kembali",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            swalWithBootstrapButtons.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
            window.location.href = ("index.php?page=user&&act=delete&&id=" + data_id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Dibatalkan',
                'Data tetap ada',
                'error'
            )
        }
    })
}


</script>
