<?php
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\CustomerController;
use App\Controllers\ProductController;
use App\Controllers\SalesController;

require __DIR__ . '/../vendor/autoload.php';
$config = require __DIR__ . '/../config/config.php';
date_default_timezone_set($config['timezone']);
session_start();

$router = new Router();
$auth = new AuthController();
$dashboard = new DashboardController();
$userController = new UserController();
$customerController = new CustomerController();
$productController = new ProductController();
$salesController = new SalesController();

$router->get('/login', fn() => $auth->showLogin());
$router->post('/login', fn() => $auth->login());
$router->get('/logout', fn() => $auth->logout());
$router->get('/', fn() => $dashboard->index());

$router->get('/users', fn() => $userController->index());
$router->get('/users/create', fn() => $userController->create());
$router->post('/users/store', fn() => $userController->store());
$router->get('/users/edit', fn() => $userController->edit((int)($_GET['id'] ?? 0)));
$router->post('/users/update', fn() => $userController->update((int)($_GET['id'] ?? 0)));
$router->get('/users/delete', fn() => $userController->delete((int)($_GET['id'] ?? 0)));

$router->get('/customers', fn() => $customerController->index());
$router->get('/customers/create', fn() => $customerController->create());
$router->post('/customers/store', fn() => $customerController->store());
$router->get('/customers/edit', fn() => $customerController->edit((int)($_GET['id'] ?? 0)));
$router->post('/customers/update', fn() => $customerController->update((int)($_GET['id'] ?? 0)));
$router->get('/customers/delete', fn() => $customerController->delete((int)($_GET['id'] ?? 0)));

$router->get('/products', fn() => $productController->index());
$router->get('/products/create', fn() => $productController->create());
$router->post('/products/store', fn() => $productController->store());
$router->get('/products/edit', fn() => $productController->edit((int)($_GET['id'] ?? 0)));
$router->post('/products/update', fn() => $productController->update((int)($_GET['id'] ?? 0)));
$router->get('/products/delete', fn() => $productController->delete((int)($_GET['id'] ?? 0)));

$router->get('/sales', fn() => $salesController->index());
$router->get('/sales/create', fn() => $salesController->create());
$router->post('/sales/store', fn() => $salesController->store());
$router->get('/sales/export', fn() => $salesController->exportCsv());

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($method, $path);
