<?php use App\Core\CSRF; ?>
<div class="card">
    <div class="card-header">Kullanıcı <?php echo isset($user) ? 'Düzenle' : 'Ekle'; ?></div>
    <div class="card-body">
        <form method="post" action="<?php echo isset($user) ? '/users/update?id=' . $user['id'] : '/users/store'; ?>">
            <input type="hidden" name="_token" value="<?php echo CSRF::token(); ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ad Soyad</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $user['name'] ?? ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kullanıcı Adı</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $user['username'] ?? ''; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Şifre</label>
                    <input type="password" name="password" class="form-control" <?php echo isset($user) ? '' : 'required'; ?>>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rol</label>
                    <select name="role" class="form-select">
                        <?php $roles = ['super_admin','admin','yonetici','muhasebe','satis','depo','uretim','ik','sadece_goruntule']; ?>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role; ?>" <?php echo (isset($user['role']) && $user['role']===$role)?'selected':''; ?>><?php echo $role; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?php echo ($user['is_active'] ?? 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>
            <button class="btn btn-primary" type="submit">Kaydet</button>
        </form>
    </div>
</div>
