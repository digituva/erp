<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\BaseController;
use App\Core\CSRF;

class AuthController extends BaseController
{
    public function showLogin()
    {
        $this->view('auth/login');
    }

    public function login()
    {
        if (!CSRF::check($_POST['_token'] ?? null)) {
            die('CSRF token hatalı');
        }
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (Auth::login($username, $password)) {
            $this->redirect('/');
        } else {
            $error = 'Kullanıcı adı veya şifre hatalı';
            $this->view('auth/login', compact('error'));
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
