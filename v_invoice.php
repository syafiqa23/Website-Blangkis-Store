<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Invoice</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('failed')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('failed') ?>
        </div>
    <?php endif; ?>
    <hr>

    <div class="mb-4">
        <strong>Nama Pengguna:</strong> <?= esc($transaction['username']) ?><br>
        <strong>Alamat:</strong> <?= esc($transaction['alamat']) ?><br>
        <strong>Tanggal Transaksi:</strong> <?= date('d M Y H:i', strtotime($transaction['created_at'])) ?><br>
        <strong>Status:</strong> <?= $transaction['status'] == 0 ? 'Menunggu Konfirmasi' : 'Diproses' ?><br>
        <strong>Status Pembayaran:</strong> <?= esc($transaction['status_bayar'] ?? 'Belum Ada') ?><br>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Bukti Pembayaran</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0;
            foreach ($details as $index => $item) : ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= esc($item['nama']) ?></td>
                    <td><?= esc($item['deskripsi']) ?></td>
                    <td>
                      <?php if ($index == 0 && !empty($transaction['bukti_pembayaran'])): ?>
    <?php $buktiPath = $transaction['bukti_pembayaran']; ?>
    <a href="<?= base_url($buktiPath) ?>" target="_blank">
        <img src="<?= base_url($buktiPath) ?>" alt="Bukti" style="max-width: 100px;">
    </a>
<?php elseif ($index == 0): ?>
    <span class="text-muted">Belum diunggah</span>
<?php endif; ?>

                    </td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= esc($item['jumlah']) ?></td>
                    <td>Rp <?= number_format($item['subtotal_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-end">Ongkir</th>
                <th>Rp <?= number_format($transaction['ongkir'], 0, ',', '.') ?></th>
            </tr>
            <tr>
                <th colspan="6" class="text-end">Total</th>
                <th>Rp <?= number_format($transaction['total_harga'], 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

    <button onclick="window.print()" class="btn btn-primary">Cetak Invoice</button>
</div>

<?= $this->endSection() ?>
