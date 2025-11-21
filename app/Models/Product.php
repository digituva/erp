<?php
namespace App\Models;

use App\Core\BaseModel;

class Product extends BaseModel
{
    protected string $table = 'products';
    protected array $fillable = ['sku', 'name', 'barcode', 'unit', 'vat_rate', 'purchase_price', 'sale_price', 'currency', 'is_active'];
}
