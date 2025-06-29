<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="row">
    <div class="col-md-6">
      <img src="<?= base_url('NiceAdmin/assets/img/' . $produk['foto']) ?>" class="img-fluid" alt="Produk">
    </div>
    <div class="col-md-6">
      <div class="card-body">
        <h3 class="card-title"><?= $produk['nama'] ?></h3>
        <h5 class="text-success"><?= number_to_currency($produk['harga'], 'IDR') ?></h5>
        <p class="card-text"><strong>Stok:</strong> <?= $produk['jumlah'] ?></p>

        <!-- Tambahan deskripsi -->
        <p class="card-text"><strong>Deskripsi:</strong></p>
        <div class="bg-light p-2 rounded border" style="white-space: pre-line;">
          <?= esc($produk['deskripsi']) ?>
        </div>

        <p class="card-text mt-2"><small class="text-muted">Terakhir diperbarui: <?= $produk['updated_at'] ?: 'Belum pernah' ?></small></p>

        <?= form_open('keranjang') ?>
          <?= form_hidden('id', $produk['id']) ?>
          <?= form_hidden('nama', $produk['nama']) ?>
          <?= form_hidden('harga', $produk['harga']) ?>
          <?= form_hidden('foto', $produk['foto']) ?>
          <button type="submit" class="btn btn-primary btn-sm">+ Tambah ke Keranjang</button>
        <?= form_close() ?>

        <a href="<?= base_url('/') ?>" class="btn btn-secondary btn-sm">Kembali</a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
