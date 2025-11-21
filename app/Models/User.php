<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class User extends BaseModel
{
    protected string $table = 'users';
    protected array $fillable = ['name', 'username', 'password', 'role', 'is_active'];

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username AND deleted_at IS NULL");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
}
