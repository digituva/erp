<?php use App\Core\CSRF; ?>
<div class="card">
    <div class="card-header">Satış Belgesi</div>
    <div class="card-body">
        <form method="post" action="/sales/store">
            <input type="hidden" name="_token" value="<?php echo CSRF::token(); ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Belge No</label>
                    <input type="text" name="doc_no" class="form-control" value="SF-<?php echo time(); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Müşteri</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Seçiniz</option>
                        <?php foreach ($customers as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tarih</label>
                    <input type="date" name="doc_date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Para Birimi</label>
                    <input type="text" name="currency" class="form-control" value="TRY">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Depo</label>
                    <input type="number" name="warehouse_id" class="form-control" value="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Not</label>
                    <input type="text" name="notes" class="form-control">
                </div>
            </div>
            <h5>Satır Detayları</h5>
            <div id="items">
                <div class="row g-2 align-items-end mb-2">
                    <div class="col-md-4">
                        <label class="form-label">Ürün</label>
                        <select name="items[0][product_id]" class="form-select">
                            <?php foreach ($products as $p): ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Miktar</label>
                        <input type="number" step="0.01" name="items[0][quantity]" class="form-control" value="1">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Birim Fiyat</label>
                        <input type="number" step="0.01" name="items[0][price]" class="form-control" value="0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">KDV %</label>
                        <input type="number" step="0.01" name="items[0][vat_rate]" class="form-control" value="18">
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Kaydet</button>
        </form>
    </div>
</div>
