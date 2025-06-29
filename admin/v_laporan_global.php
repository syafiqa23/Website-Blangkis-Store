<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Laporan Penjualan Global</h5>

        <div class="mb-3">
            <a href="<?= base_url('admin/laporan/export-global/pdf') ?>" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="<?= base_url('admin/laporan/export-global/excel') ?>" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>

        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>Status Bayar</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPendapatan = 0;
                if (!empty($penjualan)) :
                    foreach ($penjualan as $i => $jual) :
                        $totalPendapatan += $jual['total_harga'];
                ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($jual['created_at'])) ?></td>
                            <td><?= esc($jual['username']) ?></td>
                            <td><?= esc($jual['alamat']) ?></td>
                            <td><?= esc($jual['kelurahan']) ?></td>
                            <td>
                                <span class="badge bg-<?= $jual['status_bayar'] == 'lunas' ? 'success' : 'warning' ?>">
                                    <?= $jual['status_bayar'] ?>
                                </span>
                            </td>
                            <td><?= number_to_currency($jual['total_harga'], 'IDR') ?></td>
                        </tr>
                <?php
                    endforeach;
                else :
                ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data penjualan.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>

        <div class="alert alert-info mt-3">
            <strong>Total Pendapatan:</strong> <?= number_to_currency($totalPendapatan, 'IDR') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
