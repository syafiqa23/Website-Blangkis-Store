<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Menu Umum - Semua Role -->
        <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'profile' ? '' : 'collapsed' ?>" href="<?= base_url('profile') ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'contact' ? '' : 'collapsed' ?>" href="<?= base_url('contact') ?>">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= uri_string() == '' ? '' : 'collapsed' ?>" href="<?= base_url('/') ?>">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'keranjang' ? '' : 'collapsed' ?>" href="<?= base_url('keranjang') ?>">
                <i class="bi bi-cart-check"></i>
                <span>Keranjang</span>
            </a>
        </li>

        <!-- Menu Khusus Admin -->
        <?php if (session()->get('role') == 'admin') : ?>
            <li class="nav-heading">Admin Menu</li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'admin' ? '' : 'collapsed' ?>" href="<?= base_url('admin') ?>">
                    <i class="bi bi-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'admin/produk' ? '' : 'collapsed' ?>" href="<?= base_url('admin/produk') ?>">
                    <i class="bi bi-box"></i>
                    <span>Produk</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'admin/kategori' ? '' : 'collapsed' ?>" href="<?= base_url('admin/kategori') ?>">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'admin/konsumen' ? '' : 'collapsed' ?>" href="<?= base_url('admin/konsumen') ?>">
                    <i class="bi bi-people"></i>
                    <span>Konsumen</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= uri_string() == 'admin/order' ? '' : 'collapsed' ?>" href="<?= base_url('admin/order') ?>">
                    <i class="bi bi-list-check"></i>
                    <span>Order</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= str_starts_with(uri_string(), 'admin/laporan') ? '' : 'collapsed' ?>" data-bs-toggle="collapse" href="#laporan-nav">
                    <i class="bi bi-file-earmark-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="laporan-nav" class="nav-content collapse <?= str_starts_with(uri_string(), 'admin/laporan') ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('admin/laporan') ?>" class="<?= uri_string() == 'admin/laporan/global' ? 'active' : '' ?>">
                            <i class="bi bi-circle"></i><span>Laporan Global</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/laporan/periodik') ?>" class="<?= uri_string() == 'admin/laporan/periodik' ? 'active' : '' ?>">
                            <i class="bi bi-circle"></i><span>Laporan Periodik</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('admin/laporan/pendapatan') ?>" class="<?= uri_string() == 'admin/laporan/pendapatan' ? 'active' : '' ?>">
                            <i class="bi bi-circle"></i><span>Laporan Pendapatan</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

    </ul>

</aside><!-- End Sidebar -->
