<?php use App\Core\CSRF; ?>
<div class="card">
    <div class="card-header">Ürün <?php echo isset($product) ? 'Düzenle' : 'Ekle'; ?></div>
    <div class="card-body">
        <form method="post" action="<?php echo isset($product) ? '/products/update?id=' . $product['id'] : '/products/store'; ?>">
            <input type="hidden" name="_token" value="<?php echo CSRF::token(); ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Stok Kodu</label>
                    <input type="text" name="sku" class="form-control" value="<?php echo $product['sku'] ?? ''; ?>" required>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Ürün Adı</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $product['name'] ?? ''; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Barkod</label>
                    <input type="text" name="barcode" class="form-control" value="<?php echo $product['barcode'] ?? ''; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Birim</label>
                    <input type="text" name="unit" class="form-control" value="<?php echo $product['unit'] ?? ''; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">KDV %</label>
                    <input type="number" name="vat_rate" step="0.01" class="form-control" value="<?php echo $product['vat_rate'] ?? 0; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Alış Fiyatı</label>
                    <input type="number" name="purchase_price" step="0.01" class="form-control" value="<?php echo $product['purchase_price'] ?? 0; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Satış Fiyatı</label>
                    <input type="number" name="sale_price" step="0.01" class="form-control" value="<?php echo $product['sale_price'] ?? 0; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 mb-3">
                    <label class="form-label">Para Birimi</label>
                    <input type="text" name="currency" class="form-control" value="<?php echo $product['currency'] ?? 'TRY'; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Durum</label><br>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?php echo ($product['is_active'] ?? 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Aktif</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Kaydet</button>
        </form>
    </div>
</div>
