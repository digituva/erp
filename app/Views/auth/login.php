<?php use App\Core\CSRF; ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Giriş Yap</div>
            <div class="card-body">
                <form method="post" action="/login">
                    <input type="hidden" name="_token" value="<?php echo CSRF::token(); ?>">
                    <div class="mb-3">
                        <label class="form-label">Kullanıcı Adı</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Şifre</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Giriş</button>
                </form>
            </div>
        </div>
    </div>
</div>
