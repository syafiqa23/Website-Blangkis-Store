<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Global</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Global</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                <th>Status Bayar</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($penjualan as $i => $jual): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($jual['created_at'])) ?></td>
                    <td><?= esc($jual['username']) ?></td>
                    <td><?= esc($jual['alamat']) ?></td>
                   <td><?= esc($jual['kelurahan_nama']) ?></td>
                    <td><?= esc($jual['status_bayar']) ?></td>
                    <td><?= 'Rp ' . number_format($jual['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
