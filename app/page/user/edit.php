<?php
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id = $_GET['id'];

if (isset($_POST["edit"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $username = htmlspecialchars($_POST["username"]);
    $level = $_POST["level"];
    if ($crudUser->update($id, $nama, $username, $level)) {

        echo "<script>window.location.href = 'index.php?page=user'</script>";
    }
}

if (isset($id)) {
    extract($crudUser->getID($id));
}

?>

<div class="section-header">
    <h1>Edit User</h1>
</div>
<div class="row">
    <div class="col-12 col-md-6 col-lg-10">
        <div class="card">
            <form method="POST">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nama">Name</label>
                            <input id="nama" type="text" class="form-control" name="nama" value="<?php echo $nama; ?>" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input id="username" type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>level</label>
                            <select class="form-control selectric" name="level" value="<?php echo $level; ?>" required>
                                <option value="admin">admin</option>
                                <option value="superAdmin">superAdmin</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="edit">
                            Edit
                        </button>
                        <br>
                        <div class="text-center">
                            <a href="index.php?page=user&act=confirm-Password&id=<?= $id ?>">Change Password</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>