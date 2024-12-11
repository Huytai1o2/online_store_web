<?php
require_once 'controllers/home_controller.php';
require_once 'controllers/login_controller.php';
require_once 'controllers/product_controller.php';
require_once 'controllers/register_controller.php';
require_once 'controllers/admin_controller.php';

$page = $_GET['page'] ?? 'home';  // Default to 'home' if no page is provided
$search = $_GET['search'] ?? '';  // Capture the search term

switch ($page) {
    case 'home':
        $homeController = new HomeController();
        $homeController->index();
        break;
    case 'login':
        $loginController = new LoginController();
        $loginController->index();
        break;
    case 'product':
        $productController = new ProductController();
        $productController->index($search);  // Pass the search query to the product controller
        break;
    case 'register':
        $registerController = new RegisterController();
        $registerController->index();
        break;
    case 'admin':
        $adminController = new AdminController();
        $adminController->index();
        break;
    case 'edit_product':
        $adminController = new AdminController();
        $adminController->editProduct();
        break;

    case 'edit_user':
        $adminController = new AdminController();
        $adminController->editUser();
        break;
    default:
        echo '404 Not Found';
        break;
}