1. <!-- v_laporan_periodik.php -->
<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h5 class="card-title">Laporan Penjualan Periodik</h5>

<form method="post" action="<?= base_url('admin/laporan/periodik') ?>">
  <div class="row">
    <div class="col-md-3">
      <label>Dari Tanggal</label>
      <input type="date" name="tanggal_awal" class="form-control" value="<?= esc($tanggal_awal) ?>">
    </div>
    <div class="col-md-3">
      <label>Sampai Tanggal</label>
      <input type="date" name="tanggal_akhir" class="form-control" value="<?= esc($tanggal_akhir) ?>">
    </div>
    <div class="col-md-3 mt-4">
      <button class="btn btn-primary mt-2">Tampilkan</button>
    </div>
  </div>
</form>
<hr>

<a href="<?= base_url('admin/laporan/periodik/pdf?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' . $tanggal_akhir) ?>" class="btn btn-danger">Export PDF</a>
<a href="<?= base_url('admin/laporan/periodik/excel?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' . $tanggal_akhir) ?>" class="btn btn-success">Export Excel</a>
<br><br>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Konsumen</th>
      <th>Total</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    foreach ($laporan as $row): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
        <td><?= esc($row['username']) ?></td>
        <td><?= number_to_currency($row['total_harga'], 'IDR') ?></td>
        <td>
          <?php
          if ($row['status_bayar'] === 'lunas' && $row['status_kirim'] === 'sampai') {
            echo 'Selesai';
          } elseif ($row['status_bayar'] === 'lunas') {
            echo 'Diproses';
          } elseif ($row['status_kirim'] === 'sampai') {
            echo 'Dikirim (Belum Dibayar)';
          } else {
            echo 'Menunggu Pembayaran';
          }
          ?>
        </td>

      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?= $this->endSection() ?>