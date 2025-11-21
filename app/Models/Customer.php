<?php
namespace App\Models;

use App\Core\BaseModel;

class Customer extends BaseModel
{
    protected string $table = 'customers';
    protected array $fillable = [
        'code', 'name', 'tax_office', 'tax_number', 'address', 'phone', 'email', 'contact_person', 'type', 'payment_terms', 'currency', 'credit_limit'
    ];
}
