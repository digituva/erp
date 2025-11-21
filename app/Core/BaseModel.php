<?php
namespace App\Core;

use PDO;

abstract class BaseModel
{
    protected PDO $db;
    protected string $table;
    protected array $fillable = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all(int $limit = 25, int $offset = 0): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id AND deleted_at IS NULL");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $filtered = array_intersect_key($data, array_flip($this->fillable));
        $columns = implode(',', array_keys($filtered));
        $placeholders = ':' . implode(', :', array_keys($filtered));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_combine(array_map(fn($k) => ':' . $k, array_keys($filtered)), array_values($filtered)));
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $filtered = array_intersect_key($data, array_flip($this->fillable));
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($filtered)));
        $sql = "UPDATE {$this->table} SET {$set}, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $filtered['id'] = $id;
        return $stmt->execute(array_combine(array_map(fn($k) => ':' . $k, array_keys($filtered)), array_values($filtered)));
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function connection(): PDO
    {
        return $this->db;
    }
}
