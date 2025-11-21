<div class="d-flex justify-content-between mb-3">
    <h3>Kullanıcılar</h3>
    <a href="/users/create" class="btn btn-primary">Yeni Kullanıcı</a>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Ad Soyad</th>
        <th>Kullanıcı Adı</th>
        <th>Rol</th>
        <th>Durum</th>
        <th>İşlemler</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td><?php echo $user['is_active'] ? 'Aktif' : 'Pasif'; ?></td>
            <td>
                <a class="btn btn-sm btn-secondary" href="/users/edit?id=<?php echo $user['id']; ?>">Düzenle</a>
                <a class="btn btn-sm btn-danger" href="/users/delete?id=<?php echo $user['id']; ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
