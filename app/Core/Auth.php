<?php
namespace App\Core;

use App\Models\User;

class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function login(string $username, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            if (!$user['is_active']) {
                return false;
            }
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function authorize(array $roles): bool
    {
        $user = self::user();
        return $user && in_array($user['role'], $roles, true);
    }
}
