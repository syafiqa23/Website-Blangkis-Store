<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h5 class="card-title">Hasil Pencarian untuk: "<?= esc($query) ?>"</h5>

<?php if (empty($results)): ?>
    <div class="alert alert-warning">
        Tidak ada produk ditemukan.
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($results as $product): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?= base_url('NiceAdmin/assets/img/' . $product['foto']) ?>" class="card-img-top" alt="<?= esc($product['nama']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($product['nama']) ?></h5>
                        <p class="card-text"><?= word_limiter(strip_tags($product['deskripsi']), 20) ?></p>
                        <p class="card-text"><strong>Rp<?= number_format($product['harga'], 0, ',', '.') ?></strong></p>
                        <a href="#" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
