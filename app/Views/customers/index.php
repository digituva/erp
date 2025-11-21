<div class="d-flex justify-content-between mb-3">
    <h3>Müşteri / Tedarikçi Kartları</h3>
    <a href="/customers/create" class="btn btn-primary">Yeni Kayıt</a>
</div>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Kod</th><th>Unvan</th><th>Tip</th><th>Telefon</th><th>E-posta</th><th>İşlemler</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?php echo htmlspecialchars($customer['code']); ?></td>
            <td><?php echo htmlspecialchars($customer['name']); ?></td>
            <td><?php echo htmlspecialchars($customer['type']); ?></td>
            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
            <td><?php echo htmlspecialchars($customer['email']); ?></td>
            <td>
                <a class="btn btn-sm btn-secondary" href="/customers/edit?id=<?php echo $customer['id']; ?>">Düzenle</a>
                <a class="btn btn-sm btn-danger" href="/customers/delete?id=<?php echo $customer['id']; ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
