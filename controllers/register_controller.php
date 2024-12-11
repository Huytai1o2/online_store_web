<?php

class RegisterController {
    public function index() {
        require_once 'views/shared_lib/head.php';
        require_once 'views/shared_lib/navbar.php';
        require_once 'views/register_view.php';
        require_once 'views/shared_lib/footer.php';
    }
}