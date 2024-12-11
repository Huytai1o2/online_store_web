<?php

    class SignupController extends Signup {
        
        private $usr;
        private $email;
        private $pwd;
        private $pwdRepeat;

        public function __construct($usr, $email, $pwd, $pwdRepeat) {
            $this->usr = $usr;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->pwdRepeat = $pwdRepeat;
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

            if ($this->emailTaken() == false) {
                // Show the popup message and return to the previous page
                echo "<script>alert('Email is already taken!'); history.back();</script>";
                exit();
            }
        
            $this->setUser($this->usr, $this->email, $this->pwd);
        }
        

        private function emptyInputSignup() {
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
            if ($this->checkUser($this->usr) == false) {
                return true;
            }
            return false;
        }

        private function emailTaken() {
            if ($this->checkEmail($this->email) == false) {
                return true;
            }
            return false;
        }
    }