<?php

    if (isset($_POST["submit"])) {
        //grabbing data from the form
        $email = $_POST['username'];
        $password = $_POST['password'];

        // //echo "Login successful!";
        // echo "<script>alert('Login successful!');</script>";
        

        //instantiate login class
        include "../controllers/dbh_class.php";
        include "../controllers/login_class.php";
        include "../controllers/login_controller.php";
        $login = new Login_Ctrl($email, $password);

    
        //running error handlers and user login
        $login->loginUser();

        

        //going to the index page
        header("location: ../index.php?page=home");
    }

    // else {
    //     header("location: ../index.php?page=home");
    // }