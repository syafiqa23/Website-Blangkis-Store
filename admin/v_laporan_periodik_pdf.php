<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Periodik</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #222;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h2, h5 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Blangkis Store</h2>
    <h5>Laporan Penjualan Periodik</h5>
    <p>Periode: <?= date('d-m-Y', strtotime($awal)) ?> s.d <?= date('d-m-Y', strtotime($akhir)) ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Username</th>
                <th>Jumlah Barang</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['jumlah_barang'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
