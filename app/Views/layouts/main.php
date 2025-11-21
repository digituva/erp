<?php
use App\Core\Auth;
use App\Core\CSRF;
$viewFile = $viewFile ?? __DIR__;
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">ERP</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/customers">Müşteriler</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">Ürünler</a></li>
                <li class="nav-item"><a class="nav-link" href="/sales">Satış</a></li>
                <?php if (Auth::authorize(['super_admin','admin'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/users">Kullanıcılar</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (Auth::check()): ?>
                    <li class="nav-item"><span class="navbar-text text-white me-2"><?php echo htmlspecialchars(Auth::user()['name']); ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Çıkış</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container py-4">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php include $viewFile; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
