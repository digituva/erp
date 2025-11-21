<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\CSRF;
use App\Models\User;

class UserController extends BaseController
{
    private User $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function index()
    {
        if (!Auth::authorize(['super_admin', 'admin'])) {
            die('Yetki yok');
        }
        $users = $this->users->all(100);
        $this->view('users/index', compact('users'));
    }

    public function create()
    {
        $this->view('users/form');
    }

    public function store()
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF doğrulaması başarısız');
        }
        $data = [
            'name' => $_POST['name'] ?? '',
            'username' => $_POST['username'] ?? '',
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'role' => $_POST['role'] ?? 'sadece_goruntule',
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        $this->users->create($data);
        $this->redirect('/users');
    }

    public function edit(int $id)
    {
        $user = $this->users->find($id);
        $this->view('users/form', compact('user'));
    }

    public function update(int $id)
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF doğrulaması başarısız');
        }
        $data = [
            'name' => $_POST['name'] ?? '',
            'username' => $_POST['username'] ?? '',
            'role' => $_POST['role'] ?? 'sadece_goruntule',
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }
        $this->users->update($id, $data);
        $this->redirect('/users');
    }

    public function delete(int $id)
    {
        $this->users->delete($id);
        $this->redirect('/users');
    }
}
