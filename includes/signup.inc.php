<?php

    if (isset($_POST["submit"]))
    {
        // grab the form data
        $usr = $_POST["username"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        $pwdRepeat = $_POST["confirm_password"];

        // Instantiate SignupController class
        require_once "../controllers/dbh_class.php";
        require_once "../controllers/signup_class.php";
        require_once "../controllers/signup_controller.php";
        $signup = new SignupController($usr, $email, $pwd, $pwdRepeat);

        // Running the handlers and user signup
        $signup->signupUser();

        // going to the signup page
        header("location: ../index.php?page=login");
    }