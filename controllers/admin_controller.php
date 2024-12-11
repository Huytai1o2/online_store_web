<?php

    class AdminController {
        public function index() {
            require_once 'views/shared_lib/head.php';
            require_once 'views/shared_lib/navbar.php';
            require_once 'views/admin_view.php';
            require_once 'views/shared_lib/footer.php';
        }

        public function editProduct() {
            require_once 'views/shared_lib/head.php';
            require_once 'views/shared_lib/navbar.php';
            require_once 'views/edit_product_view.php';
            require_once 'views/shared_lib/footer.php';
        }

        public function editUser() {
            require_once 'views/shared_lib/head.php';
            require_once 'views/shared_lib/navbar.php';
            require_once 'views/edit_user_view.php';
            require_once 'views/shared_lib/footer.php';
        }
    }