<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h4>Konfirmasi Pembayaran</h4>

<form action="<?= base_url('checkout/upload_bukti') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">

    <div class="mb-3">
        <label for="bukti" class="form-label">Upload Bukti Pembayaran (JPG/PNG/PDF)</label>
        <input class="form-control" type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
    </div>

    <button type="submit" class="btn btn-success">Kirim Bukti</button>
</form>

<?= $this->endSection() ?>
