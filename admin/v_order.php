<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Data Order</h5>

        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pemesan</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>Total Harga</th>
                    <th>Status Bayar</th>
                    <th>Status Kirim</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)) : ?>
                    <?php foreach ($orders as $index => $order) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($order['username']) ?></td>
                            <td><?= esc($order['alamat']) ?></td>
                            <td><?= isset($order['kelurahan']) ? esc($order['kelurahan']) : '-' ?></td>
                            <td><?= number_to_currency($order['total_harga'], 'IDR') ?></td>
                            <td>
                                <span class="badge bg-<?= (isset($order['status_bayar']) && $order['status_bayar'] == 'lunas') ? 'success' : 'warning' ?>">
                                    <?= isset($order['status_bayar']) ? esc($order['status_bayar']) : '-' ?>
                                </span>

                            </td>
                            <td>
                                <span class="badge bg-<?= (isset($order['status_kirim']) && $order['status_kirim'] == 'sampai') ? 'success' : 'secondary' ?>">
                                    <?= isset($order['status_kirim']) ? esc($order['status_kirim']) : '-' ?>
                                </span>

                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('invoice/' . $order['id']) ?>" class="btn btn-sm btn-info">
                                    Invoice
                                </a>
                                <?php if ($order['status_bayar'] != 'lunas') : ?>
                                    <a href="<?= base_url('admin/order/konfirmasi-bayar/' . $order['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pembayaran?')">
                                        Konfirmasi Bayar
                                    </a>
                                <?php endif ?>
                                <?php if ($order['status_bayar'] == 'lunas' && $order['status_kirim'] != 'sampai') : ?>
                                    <a href="<?= base_url('admin/order/konfirmasi-kirim/' . $order['id']) ?>" class="btn btn-sm btn-primary" onclick="return confirm('Ubah status jadi terkirim?')">
                                        Kirim
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data pesanan</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>