<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Alamat</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($penjualan as $i => $jual): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($jual['username']) ?></td>
                <td><?= esc($jual['alamat']) ?></td>
                <td><?= $jual['total_harga'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
