<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\CSRF;
use App\Models\Customer;

class CustomerController extends BaseController
{
    private Customer $customers;

    public function __construct()
    {
        $this->customers = new Customer();
    }

    public function index()
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }
        $customers = $this->customers->all(100);
        $this->view('customers/index', compact('customers'));
    }

    public function create()
    {
        $this->view('customers/form');
    }

    public function store()
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF hatası');
        }
        $data = [
            'code' => $_POST['code'] ?? '',
            'name' => $_POST['name'] ?? '',
            'tax_office' => $_POST['tax_office'] ?? '',
            'tax_number' => $_POST['tax_number'] ?? '',
            'address' => $_POST['address'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'contact_person' => $_POST['contact_person'] ?? '',
            'type' => $_POST['type'] ?? 'Müşteri',
            'payment_terms' => $_POST['payment_terms'] ?? '',
            'currency' => $_POST['currency'] ?? 'TRY',
            'credit_limit' => $_POST['credit_limit'] ?? 0,
        ];
        $this->customers->create($data);
        $this->redirect('/customers');
    }

    public function edit(int $id)
    {
        $customer = $this->customers->find($id);
        $this->view('customers/form', compact('customer'));
    }

    public function update(int $id)
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF hatası');
        }
        $data = [
            'code' => $_POST['code'] ?? '',
            'name' => $_POST['name'] ?? '',
            'tax_office' => $_POST['tax_office'] ?? '',
            'tax_number' => $_POST['tax_number'] ?? '',
            'address' => $_POST['address'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'contact_person' => $_POST['contact_person'] ?? '',
            'type' => $_POST['type'] ?? 'Müşteri',
            'payment_terms' => $_POST['payment_terms'] ?? '',
            'currency' => $_POST['currency'] ?? 'TRY',
            'credit_limit' => $_POST['credit_limit'] ?? 0,
        ];
        $this->customers->update($id, $data);
        $this->redirect('/customers');
    }

    public function delete(int $id)
    {
        $this->customers->delete($id);
        $this->redirect('/customers');
    }
}
