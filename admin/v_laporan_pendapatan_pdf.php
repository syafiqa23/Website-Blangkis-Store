<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pendapatan</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Laporan Pendapatan</h3>
    <table width="100%">
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
            foreach ($data as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right">Total Laba</th>
                <th>Rp<?= number_format($laba, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>