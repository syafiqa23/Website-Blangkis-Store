<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<h4>History Transaksi Pembelian <strong><?= $username ?></strong></h4>
<hr>

<!-- Tombol Cetak Invoice (satu kali saja, di atas tabel) -->
<form action="<?= base_url('invoice') ?>" method="get" class="d-flex align-items-center gap-2 mb-3">
    <select name="id" class="form-select" required>
        <option value="">-- Pilih ID Transaksi --</option>
        <?php foreach ($transactions as $trans): ?>
            <option value="<?= $trans['id'] ?>">ID <?= $trans['id'] ?> - <?= $trans['created_at'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-success">Cetak Invoice</button>
</form>

<div class="table-responsive">
    <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Waktu Pembelian</th>
                <th>Total Bayar</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Status Kirim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buy)) :
                foreach ($buy as $index => $item) : ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= $item['alamat'] ?></td>
                        <td><?= ($item['status'] == "1") ? "Sudah Selesai" : "Belum Selesai" ?></td>
                        <td>
    <?php if ($item['status_kirim'] == 'diterima') : ?>
        <span class="badge bg-success">Diterima</span>
    <?php else : ?>
        <span class="badge bg-secondary">Belum Dikirim</span>
    <?php endif; ?>
</td>

                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                            <?php if ($item['status_kirim'] != 'diterima') : ?>
    <button type="button" class="btn btn-warning mt-1" data-bs-toggle="modal" data-bs-target="#konfirmasiModal-<?= $item['id'] ?>">
        Konfirmasi Diterima
    </button>

<?php endif; ?>
                        </td>
                    </tr>
<div class="modal fade" id="konfirmasiModal-<?= $item['id'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('konfirmasi-diterima/' . $item['id']) ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Penerimaan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah kamu yakin ingin mengonfirmasi bahwa barang sudah diterima?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Diterima</button>
                </div>
            </form>
        </div>
    </div>
</div>
                    <!-- Modal Detail Transaksi -->
                    <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Transaksi ID <?= $item['id'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($product[$item['id']])) : ?>
                                        <?php foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                            <div class="mb-2">
                                                <strong><?= $index2 + 1 ?>. <?= esc($item2['nama']) ?></strong><br>
                                                <?php if ($item2['foto'] && file_exists(FCPATH . "NiceAdmin/assets/img/" . $item2['foto'])) : ?>
                                                    <img src="<?= base_url("NiceAdmin/assets/img/" . $item2['foto']) ?>" width="100px"><br>
                                                <?php endif; ?>
                                                <small><?= esc($item2['deskripsi']) ?></small><br>
                                                Harga: <?= number_to_currency($item2['harga'], 'IDR') ?> x <?= $item2['jumlah'] ?> pcs<br>
                                                Subtotal: <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                        <strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'], 'IDR') ?>
                                    <?php else : ?>
                                        <p>Data produk tidak ditemukan.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach;
            endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>