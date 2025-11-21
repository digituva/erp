<?php
namespace App\Core;

class BaseController
{
    protected function view(string $template, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $template . '.php';
        $layout = __DIR__ . '/../Views/layouts/main.php';
        if (file_exists($layout)) {
            include $layout;
        } else {
            include $viewFile;
        }
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
