<div class="d-flex justify-content-between mb-3">
    <h3>Ürünler</h3>
    <a href="/products/create" class="btn btn-primary">Yeni Ürün</a>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Stok Kodu</th><th>Ürün Adı</th><th>Barkod</th><th>Birim</th><th>Satış Fiyatı</th><th>Durum</th><th>İşlemler</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo htmlspecialchars($product['sku']); ?></td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['barcode']); ?></td>
            <td><?php echo htmlspecialchars($product['unit']); ?></td>
            <td><?php echo number_format($product['sale_price'], 2); ?> <?php echo $product['currency']; ?></td>
            <td><?php echo $product['is_active'] ? 'Aktif' : 'Pasif'; ?></td>
            <td>
                <a class="btn btn-sm btn-secondary" href="/products/edit?id=<?php echo $product['id']; ?>">Düzenle</a>
                <a class="btn btn-sm btn-danger" href="/products/delete?id=<?php echo $product['id']; ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
