<?php

namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function index(): string
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();
        return $this->twig->render('Category/index.html.twig', [
            'categories' => $categories,
            'toto' => 'Bonjour Monde',
        ]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $category = array_map('trim', $_POST);
            if (strlen($category['name']) === 0  || strlen($category['name']) > 46) {
                $errors[] = 'Veuillez saisir un nom';
            }
            if (empty($errors)) {
                $categoryManager = new CategoryManager();
                //$id = $categoryManager->insert($category);
                $categoryManager->insert($category);
                header('Location: /categories');
                return null;
            }
            return $this->twig->render('Category/add.html.twig');
        }
        return $this->twig->render('Category/add.html.twig');
    }

    public function show(int $id): string
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectOneById($id);
        return $this->twig->render('Category/show.html.twig', [
            'category' => $category,
        ]);
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $categoryManager = new CategoryManager();
            $categoryManager->delete((int) $id);
            header('Location: /categories');
        }
    }
}
