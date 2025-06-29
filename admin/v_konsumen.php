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
        <h5 class="card-title">Data Konsumen</h5>

        <!-- Tabel Data Konsumen -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($konsumen)) : ?>
                    <?php foreach ($konsumen as $index => $row) : ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><?= esc($row['username']) ?></td>
                            <td><?= esc($row['email']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= esc($row['role']) ?></span></td>
                            <td><?= esc(date('d-m-Y H:i', strtotime($row['created_at']))) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data konsumen</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
