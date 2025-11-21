<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Models\SalesDocument;
use App\Models\Product;
use App\Models\Customer;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
        $sales = new SalesDocument();
        $products = new Product();
        $customers = new Customer();

        $metrics = [
            'open_orders' => count($sales->all(50)),
            'product_count' => count($products->all(5)),
            'customer_count' => count($customers->all(5)),
        ];
        $this->view('dashboard/index', compact('metrics'));
    }
}
