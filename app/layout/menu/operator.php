<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php?page=dashboard" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Kepegawaian
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php?page=data-pegawai" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>Data Pegawai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?page=data-penggajian" class="nav-link">
                  <i class="far  fa-check-square nav-icon"></i>
                  <p>Data Penggajian</p>
                </a>
              </li>
              
            </ul>
            <li class="nav-item">
                <a href="index.php?page=data-keuangan" class="nav-link">
                  <i class="far  fa-pencil-square-o nav-icon"></i>
                  <p>Data Keuangan</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <a href="auth/logout.php" class="nav-link text-red font-weight-bold">
              <i class="nav-icon fas  fa-power-off"></i>
              <p>
                Log Out
              </p>
            </a>
          </li>
        </ul>
      </nav>

      