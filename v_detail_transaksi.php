<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Detail Transaksi</h4>

<table class="table table-bordered">
    <tr>
        <th>Username</th>
        <td><?= esc($transaksi['username']) ?></td>
    </tr>
    <tr>
        <th>Alamat</th>
        <td><?= esc($transaksi['alamat']) ?></td>
    </tr>
    <tr>
        <th>Kelurahan</th>
        <td><?= esc($transaksi['kelurahan']) ?></td>
    </tr>
    <tr>
        <th>Layanan</th>
        <td><?= esc($transaksi['layanan']) ?></td>
    </tr>
    <tr>
        <th>Ongkir</th>
        <td>Rp<?= number_format($transaksi['ongkir'], 0, ',', '.') ?></td>
    </tr>
    <tr>
        <th>Total Harga</th>
        <td>Rp<?= number_format($transaksi['total_harga'], 0, ',', '.') ?></td>
    </tr>
    <tr>
        <th>Status Bayar</th>
        <td><?= ucfirst($transaksi['status_bayar']) ?></td>
    </tr>
    <tr>
        <th>Bukti Pembayaran</th>
        <td>
            <?php if ($transaksi['bukti_pembayaran']): ?>
                <a href="<?= base_url($transaksi['bukti_pembayaran']) ?>" target="_blank">
                    <img src="<?= base_url($transaksi['bukti_pembayaran']) ?>" alt="Bukti" style="max-width: 300px;">
                </a>
            <?php else: ?>
                <em>Belum diunggah</em>
            <?php endif; ?>
        </td>
    </tr>
</table>

<h5 class="mt-5">Detail Produk</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($details as $item): ?>
        <tr>
            <td><?= esc($item['nama']) ?></td>
            <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
            <td><?= $item['jumlah'] ?></td>
            <td>Rp<?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
