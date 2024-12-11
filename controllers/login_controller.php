<?php
require_once 'login_class.php';

class LoginController {
    public function index() {
        require_once 'views/shared_lib/head.php';
        require_once 'views/shared_lib/navbar.php';
        require_once 'views/login_view.php';
        require_once 'views/shared_lib/footer.php';
    }
}

class Login_Ctrl extends Login {
        
    private $usr;
    private $email;
    private $pwd;
    private $pwdRepeat;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
        $this->usr = $email;
        $this->pwdRepeat = $pwd;
    }

    public function loginUser() {
        if ($this->emptyInputLogin() == false) {
            // Show the popup message and return to the previous page
            echo "<script>alert('Please fill in all fields!'); history.back();</script>";
            exit();
        }

        $this->getUser($this->usr, $this->pwd);
    }

    public function signupUser() {
        if ($this->emptyInputSignup() == false) {
            // Show the popup message and return to the previous page
            echo "<script>alert('Please fill in all fields!'); history.back();</script>";
            exit();
        }
    
        if ($this->invalidUid($this->usr) == false) {
            // Show the popup message and return to the previous page
            echo "<script>alert('Please use only letters and numbers for your username!'); history.back();</script>";
            exit();
        }
    
        if ($this->invalidEmail($this->email) == false) {
            // Show the popup message and return to the previous page
            echo "<script>alert('Please use a valid email!'); history.back();</script>";
            exit();
        }
    
        if ($this->pwdMatch($this->pwd, $this->pwdRepeat) == false) {
            // Show the popup message and return to the previous page
            echo "<script>alert('Your passwords do not match!'); history.back();</script>";
            exit();
        }
    
        if ($this->usrTaken() == false) {
            // Show the popup message and return to the previous page
            echo "<script>alert('Username is already taken!'); history.back();</script>";
            exit();
        }
    
        $this->setUser($this->usr, $this->email, $this->pwd);
    }
    

    private function emptyInputLogin() {
        if (empty($this->usr) || empty($this->email) || empty($this->pwd) || empty($this->pwdRepeat)) {
            return false;
        }
        return true;
    }

    private function invalidUid($username) {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            return false;
        }
        return true;
    }

    private function invalidEmail($email) {
        if (!filter_var($this -> email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function pwdMatch($pwd, $pwdRepeat) {
        if ($this->pwd !== $this->pwdRepeat) {
            return false;
        }
        return true;
    }

    private function usrTaken(){
        if ($this->checkUser($this->usr, $this->email) == false) {
            return true;
        }
        return false;
    }
}