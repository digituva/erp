<div class="d-flex justify-content-between mb-3">
    <h3>Satış Belgeleri</h3>
    <div>
        <a href="/sales/create" class="btn btn-primary">Yeni Belge</a>
        <a href="/sales/export" class="btn btn-outline-secondary">CSV</a>
    </div>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Belge No</th><th>Tarih</th><th>Müşteri</th><th>Durum</th><th>Toplam</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($documents as $doc): ?>
        <tr>
            <td><?php echo htmlspecialchars($doc['doc_no']); ?></td>
            <td><?php echo htmlspecialchars($doc['doc_date']); ?></td>
            <td><?php echo htmlspecialchars($doc['customer_id']); ?></td>
            <td><?php echo htmlspecialchars($doc['status']); ?></td>
            <td><?php echo number_format($doc['total'],2); ?> <?php echo $doc['currency']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
