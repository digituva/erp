<?php
namespace App\Models;

use App\Core\BaseModel;

class StockMovement extends BaseModel
{
    protected string $table = 'stock_movements';
    protected array $fillable = ['product_id', 'warehouse_id', 'quantity', 'movement_type', 'source_document', 'description'];
}
