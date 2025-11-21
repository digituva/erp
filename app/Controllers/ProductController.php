<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\CSRF;
use App\Models\Product;

class ProductController extends BaseController
{
    private Product $products;

    public function __construct()
    {
        $this->products = new Product();
    }

    public function index()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
        $products = $this->products->all(100);
        $this->view('products/index', compact('products'));
    }

    public function create()
    {
        $this->view('products/form');
    }

    public function store()
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF hatası');
        }
        $data = [
            'sku' => $_POST['sku'] ?? '',
            'name' => $_POST['name'] ?? '',
            'barcode' => $_POST['barcode'] ?? '',
            'unit' => $_POST['unit'] ?? '',
            'vat_rate' => $_POST['vat_rate'] ?? 0,
            'purchase_price' => $_POST['purchase_price'] ?? 0,
            'sale_price' => $_POST['sale_price'] ?? 0,
            'currency' => $_POST['currency'] ?? 'TRY',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $this->products->create($data);
        $this->redirect('/products');
    }

    public function edit(int $id)
    {
        $product = $this->products->find($id);
        $this->view('products/form', compact('product'));
    }

    public function update(int $id)
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF hatası');
        }
        $data = [
            'sku' => $_POST['sku'] ?? '',
            'name' => $_POST['name'] ?? '',
            'barcode' => $_POST['barcode'] ?? '',
            'unit' => $_POST['unit'] ?? '',
            'vat_rate' => $_POST['vat_rate'] ?? 0,
            'purchase_price' => $_POST['purchase_price'] ?? 0,
            'sale_price' => $_POST['sale_price'] ?? 0,
            'currency' => $_POST['currency'] ?? 'TRY',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $this->products->update($id, $data);
        $this->redirect('/products');
    }

    public function delete(int $id)
    {
        $this->products->delete($id);
        $this->redirect('/products');
    }
}
