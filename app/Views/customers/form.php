<?php use App\Core\CSRF; ?>
<div class="card">
    <div class="card-header">Cari <?php echo isset($customer) ? 'Düzenle' : 'Ekle'; ?></div>
    <div class="card-body">
        <form method="post" action="<?php echo isset($customer) ? '/customers/update?id=' . $customer['id'] : '/customers/store'; ?>">
            <input type="hidden" name="_token" value="<?php echo CSRF::token(); ?>">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cari Kodu</label>
                    <input type="text" name="code" class="form-control" value="<?php echo $customer['code'] ?? ''; ?>" required>
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Unvan</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $customer['name'] ?? ''; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vergi Dairesi</label>
                    <input type="text" name="tax_office" class="form-control" value="<?php echo $customer['tax_office'] ?? ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vergi No</label>
                    <input type="text" name="tax_number" class="form-control" value="<?php echo $customer['tax_number'] ?? ''; ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Adres</label>
                <input type="text" name="address" class="form-control" value="<?php echo $customer['address'] ?? ''; ?>">
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Telefon</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $customer['phone'] ?? ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">E-posta</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $customer['email'] ?? ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Yetkili</label>
                    <input type="text" name="contact_person" class="form-control" value="<?php echo $customer['contact_person'] ?? ''; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cari Tipi</label>
                    <select name="type" class="form-select">
                        <?php $types = ['Müşteri','Tedarikçi','Her ikisi']; ?>
                        <?php foreach ($types as $type): ?>
                            <option value="<?php echo $type; ?>" <?php echo (($customer['type'] ?? '') === $type) ? 'selected' : ''; ?>><?php echo $type; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ödeme Vadesi</label>
                    <input type="number" name="payment_terms" class="form-control" value="<?php echo $customer['payment_terms'] ?? 0; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Para Birimi</label>
                    <input type="text" name="currency" class="form-control" value="<?php echo $customer['currency'] ?? 'TRY'; ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Risk Limiti</label>
                    <input type="number" name="credit_limit" class="form-control" value="<?php echo $customer['credit_limit'] ?? 0; ?>">
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Kaydet</button>
        </form>
    </div>
</div>
