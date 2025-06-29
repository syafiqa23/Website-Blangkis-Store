<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<h5 class="card-title">Laporan Pendapatan</h5>

<form action="<?= base_url('admin/laporan/pendapatan/filter') ?>" method="post" class="row g-3 mb-3">
    <div class="col-md-3">
        <label for="awal" class="form-label">Tanggal Awal</label>
        <input type="date" name="awal" id="awal" class="form-control" value="<?= esc($awal) ?>">
    </div>
    <div class="col-md-3">
        <label for="akhir" class="form-label">Tanggal Akhir</label>
        <input type="date" name="akhir" id="akhir" class="form-control" value="<?= esc($akhir) ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Aksi</label><br>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="<?= base_url('admin/laporan/pendapatan/pdf?awal=' . $awal . '&akhir=' . $akhir) ?>" class="btn btn-danger">PDF</a>
        <a href="<?= base_url('admin/laporan/pendapatan/excel?awal=' . $awal . '&akhir=' . $akhir) ?>" class="btn btn-success">Excel</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Username</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $total = 0; ?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                </tr>
                <?php $total += $row['total_harga']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total Pendapatan</th>
                <th>Rp<?= number_format($total, 0, ',', '.') ?></th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">Total Laba</th>
                <th>Rp<?= number_format($laba, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
</div>
<?= $this->endSection() ?>