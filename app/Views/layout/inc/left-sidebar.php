<div class="left-side-bar">
    <div class="brand-logo">
        <a href="<?= base_url('admin'); ?>">
            <img src="/assets/vendors/images/logo.png" alt="" class="dark-logo" />
            <img src="/assets/vendors/images/logo.png" alt="" class="light-logo" />
        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <!-- Dashboard -->
                <li>
                    <a href="<?= base_url('/'); ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span>
                        <span class="mtext">Dashboard</span>
                    </a>
                </li>

                <!-- Kelola Data -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-folder"></span>
                        <span class="mtext">Kelola Data</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('/members'); ?>">Member</a></li>
                        <li><a href="<?= base_url('/categories'); ?>">Kategori</a></li>
                        <li><a href="<?= base_url('/racks'); ?>">Rak</a></li>
                        <li><a href="<?= base_url('/books'); ?>">Buku</a></li>
                        <li><a href="<?= base_url('/ebooks'); ?>">Ebook</a></li>
                        <li><a href="<?= base_url('/finesettings'); ?>">Denda</a></li>
                    </ul>
                </li>

                <!-- Sirkulasi -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-book"></span>
                        <span class="mtext">Sirkulasi</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('/loans'); ?>">Peminjaman Buku</a></li>
                        <li><a href="<?= base_url('/reservations'); ?>">Reservasi Buku</a></li>
                    </ul>
                </li>

                <!-- Denda -->
                <li>
                    <a href="<?= base_url('/fines'); ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-exclamation-circle"></span>
                        <span class="mtext">Denda</span>
                    </a>
                </li>


                <!-- Laporan -->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-bar-chart"></span>
                        <span class="mtext">Laporan</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('reports/loan-reports-by-member'); ?>">Laporan per Member</a></li>
                        <li><a href="<?= base_url('reports/loan-reports'); ?>">Laporan Peminjaman</a></li>
                        <li><a href="<?= base_url('reports/member-reports'); ?>">Laporan Member</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= base_url('/admins'); ?>" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person-circle"></span>
                        <span class="mtext">Admin</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>