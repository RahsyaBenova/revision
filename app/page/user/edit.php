<?php

// Pemeriksaan level pengguna
if ($_SESSION['level'] !== "superadmin") {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id = $_GET['id'];

if (isset($_POST["edit"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $level = $_POST["level"];
    if ($crudUser->update($id, $nama, $username, $level)) {
        echo "<script>window.location.href = 'index.php?page=user&&msg=2'</script>";
    }
}

if (isset($id)) {
    extract($crudUser->getID($id));
}
?>

<div class="container">
    <div class="section-header text-center">
        <h1>Edit User</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <form method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nama">Name</label>
                                <input id="nama" type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" autofocus required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Level</label>
                                <select class="form-control selectric" name="level" required>
                                    <option value="superadmin" <?php echo ($level == 'superadmin') ? 'selected' : ''; ?>>SuperAdmin</option>
                                    <option value="operator" <?php echo ($level == 'operator') ? 'selected' : ''; ?>>Operator</option>
                                    <option value="common_user" <?php echo ($level == 'common_user') ? 'selected' : ''; ?>>Common user</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" name="edit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
