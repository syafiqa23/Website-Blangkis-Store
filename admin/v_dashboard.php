<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Total Produk</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                        <i class="bi bi-box"></i>
                    </div>
                    <div class="ps-3">
                        <h6><?= $total_produk ?></h6>
                        <span class="text-muted small pt-2 ps-1">Data Produk</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Produk Card -->

    <div class="col-lg-3 col-md-6">
        <div class="card info-card customers-card">
            <div class="card-body">
                <h5 class="card-title">Total Konsumen</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                        <h6><?= $total_konsumen ?></h6>
                        <span class="text-muted small pt-2 ps-1">Akun Guest</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Konsumen Card -->

    <div class="col-lg-3 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="ps-3">
                        <h6><?= $total_transaksi ?></h6>
                        <span class="text-muted small pt-2 ps-1">Order Terdata</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Transaksi Card -->

    <div class="col-lg-3 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Pendapatan</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="ps-3">
                        <h6><?= number_to_currency($total_pendapatan, 'IDR') ?></h6>
                        <span class="text-muted small pt-2 ps-1">Lunas Dibayar</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Pendapatan Card -->
</div>
<?= $this->endSection() ?>
