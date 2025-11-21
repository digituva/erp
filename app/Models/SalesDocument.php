<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class SalesDocument extends BaseModel
{
    protected string $table = 'sales_documents';
    protected array $fillable = ['doc_no', 'doc_type', 'customer_id', 'doc_date', 'currency', 'status', 'total', 'notes'];

    public function items(int $documentId): array
    {
        $stmt = $this->db->prepare('SELECT si.*, p.name as product_name FROM sales_items si JOIN products p ON p.id = si.product_id WHERE si.document_id = :id');
        $stmt->execute([':id' => $documentId]);
        return $stmt->fetchAll();
    }
}
