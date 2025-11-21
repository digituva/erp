<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\CSRF;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesDocument;
use App\Models\StockMovement;

class SalesController extends BaseController
{
    private SalesDocument $sales;
    private Customer $customers;
    private Product $products;
    private StockMovement $stock;

    public function __construct()
    {
        $this->sales = new SalesDocument();
        $this->customers = new Customer();
        $this->products = new Product();
        $this->stock = new StockMovement();
    }

    public function index()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
        $documents = $this->sales->all(100);
        $this->view('sales/index', compact('documents'));
    }

    public function create()
    {
        $customers = $this->customers->all(100);
        $products = $this->products->all(100);
        $this->view('sales/form', compact('customers', 'products'));
    }

    public function store()
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF doğrulaması başarısız');
        }
        $docId = $this->sales->create([
            'doc_no' => $_POST['doc_no'] ?? 'SF-' . time(),
            'doc_type' => $_POST['doc_type'] ?? 'fatura',
            'customer_id' => (int)($_POST['customer_id'] ?? 0),
            'doc_date' => $_POST['doc_date'] ?? date('Y-m-d'),
            'currency' => $_POST['currency'] ?? 'TRY',
            'status' => 'Taslak',
            'total' => 0,
            'notes' => $_POST['notes'] ?? ''
        ]);

        $total = 0;
        foreach ($_POST['items'] as $item) {
            if (empty($item['product_id']) || empty($item['quantity'])) {
                continue;
            }
            $productId = (int)$item['product_id'];
            $qty = (float)$item['quantity'];
            $price = (float)$item['price'];
            $lineTotal = $qty * $price;
            $total += $lineTotal;
            $stmt = $this->sales->connection()->prepare('INSERT INTO sales_items(document_id, product_id, quantity, price, vat_rate) VALUES(:doc,:prod,:qty,:price,:vat)');
            $stmt->execute([
                ':doc' => $docId,
                ':prod' => $productId,
                ':qty' => $qty,
                ':price' => $price,
                ':vat' => (float)$item['vat_rate']
            ]);
            // stok düşümü örnek
            $this->stock->create([
                'product_id' => $productId,
                'warehouse_id' => (int)($_POST['warehouse_id'] ?? 1),
                'quantity' => -$qty,
                'movement_type' => 'sales',
                'source_document' => $docId,
                'description' => 'Satış faturası'
            ]);
        }

        $this->sales->update($docId, ['total' => $total]);
        $this->redirect('/sales');
    }

    public function exportCsv()
    {
        $documents = $this->sales->all(500);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sales.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Belge No', 'Müşteri', 'Tarih', 'Toplam']);
        foreach ($documents as $doc) {
            fputcsv($out, [$doc['doc_no'], $doc['customer_id'], $doc['doc_date'], $doc['total']]);
        }
        fclose($out);
        exit;
    }
}
