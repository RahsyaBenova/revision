<!-- Main Content -->

<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="d-inline">User List</h4>
        </div>
        
        <form action="" method="post">
            <div class="form-group">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <input type="text" class="form-control" name="keyword" autocomplete="off" placeholder="Cari Nama Customer">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block" type="submit" name="cari">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="text-right">
            <!-- Button trigger modal -->
            <a href="index.php?page=user&act=create"><button type="button" class="btn btn-primary">
                Tambah User
            </button></a>
        </div>

    </div>
    <div class="card-body">
        <ul class="list list-styled-border">
            <?php
            $pdo = Koneksi::connect();
            if (isset($_POST['cari'])) {
                $key = htmlspecialchars($_POST['keyword']);
            }
            $paging = Page::getInstance($pdo, 'users');
            $rows = $paging->getdata(@$key, 'nama');
            $pages = $paging->getPageNumber();
            foreach ($rows as $row) {
            ?>
                <li class="media mb-3">
                    <div class="media-body">
                        <h6 class="media-title">
                            <span style="cursor:default" data-toggle="tooltip" title="Nama"> 
                                <?php echo $row["nama"] ?> 
                            </span>
                        </h6>
                        <div class="text-small text-muted">
                            <span style="cursor:default" data-toggle="tooltip" title="Username">@<?php echo $row["username"] ?> </span>
                            <div class="bullet"></div>
                            <span style="cursor:default" data-toggle="tooltip" title="role" class="text-primary">
                                <?php echo $row["level"] ?>
                            </span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit" href="index.php?page=user&act=edit&id=<?php echo $row["id"] ?>">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-danger btn-action tombol-hapus" data-toggle="tooltip" title="Delete" href='index.php?page=user&act=delete&id=<?php echo $row['id'] ?>'>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="card-footer text-right">
        <nav class="d-inline-block">
            <ul class="pagination mb-0">
                <li class="page-item">
                    <a class="page-link" href="index.php?page=user&halaman=<?= $paging->prevPage() ?>" tabindex="-1">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <?php
                for ($i = 1; $i <= $pages; $i++) :
                    $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';
                    if ($halaman == $i) {
                ?>
                        <li class="page-item active">
                            <a class="page-link active" href="index.php?page=user&halaman=<?= $i; ?>"><?= $i ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?page=user&halaman=<?= $i; ?>"><?= $i ?></a>
                        </li>
                <?php
                    }
                endfor;
                ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=user&halaman=<?= $paging->nextPage() ?>">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
</div>
