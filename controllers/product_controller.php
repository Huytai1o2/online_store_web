<?php

class ProductController {
    public function index($search = '') {  // Add $search as a parameter with a default value
        require_once 'models/product.php';

        // Instantiate the product fetcher and fetch products based on the search term
        $productController_fetch = new ProductController_fetch();
        $products = $productController_fetch->fetchProducts($search);

        // Include necessary files and pass $products and $search to the view
        require_once 'views/shared_lib/head.php';
        require_once 'views/shared_lib/navbar.php';
        require_once 'views/product_view.php'; // Ensure product_view.php uses $products and $search
        require_once 'views/shared_lib/footer.php';
    }
}
