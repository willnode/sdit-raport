<nav class="main-header navbar navbar-expand navbar-dark elevation-2">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/user/" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/user/profile/" class="nav-link">Edit Profil</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item">
      <a class="nav-link" href="/user/logout">
        <i class="fa fa-sign-out-alt mr-2"></i> Keluar
      </a>
    </li>
  </ul>
</nav>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="/logo_dark.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
    <span class="brand-text font-weight-light">SDIT Ar-Ruhul Jadid</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= \Config\Services::login()->getAvatarUrl() ?>" alt="">
      </div>
      <div class="info">
        <a href="/user/profile/" class="d-block"><?= \Config\Services::login()->name ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="/user/" class="nav-link <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Beranda
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/user/nilai/" class="nav-link <?= ($page ?? '') === 'nilai' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-scroll"></i>
            <p>
              Input Nilai
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/user/siswa/" class="nav-link <?= ($page ?? '') === 'siswa' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-scroll"></i>
            <p>
              Data Siswa
            </p>
          </a>
        </li>
        <?php if (\Config\Services::login()->role === 'admin') : ?>
          <li class="nav-item">
            <a href="/user/pelajaran/" class="nav-link <?= ($page ?? '') === 'pelajaran' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-scroll"></i>
              <p>
                Data Pelajaran
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/user/leger/" class="nav-link <?= ($page ?? '') === 'leger' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-scroll"></i>
              <p>
                Leger Nilai
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/user/manage/" class="nav-link <?= ($page ?? '') === 'users' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Akun Guru
              </p>
            </a>
          </li>
        <?php endif ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>