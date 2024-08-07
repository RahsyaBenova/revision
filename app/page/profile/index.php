<?php
$pdo = Koneksi::connect();
$auth = Auth::getInstance($pdo);

if (!$auth->isLoggedIn()) {
    echo "<h1>Anda harus login terlebih dahulu!</h1>";
    echo "<script>window.location.href = 'index.php?page=login';</script>";
    exit;
}

$user = $auth->getUser();

if (!$user) {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}

?>

<div class="container">
    <div class="section-header text-center">
        <h1>Profile User</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <form method="POST" action="index.php?page=profile&&act=check">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nama">Name</label>
                                <input id="nama" type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="email">Email</label>
                                <input id="email" type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="level">Role</label>
                                <input id="level" type="text" class="form-control" name="level" value="<?php echo htmlspecialchars($user['level']); ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="edit">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
    </div>
</div>



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
        text: 'Password berhasil diupdate',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
    else if (msg == 2) {
      Swal.fire({
        icon: 'error',
        title: 'Salah',
        text: 'Password yang anda masukkan salah',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
  });
</script>