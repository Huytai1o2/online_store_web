<?php
require_once 'dbh_class.php';

class Login extends Dbh {

    protected function getUser($username, $password) {
        $conn = $this->connect();

        // Prepare the statement to fetch user details
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        
        if (!$stmt) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        
        // Bind parameters: "ss" means two strings (for username and email)
        $stmt->bind_param("ss", $username, $username);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 0) {
            // pop up an alert and back to the previous page
            echo "<script>alert('User does not exist!'); history.back();</script>";
            exit();
        }

        // Fetch the user details
        $user = $result->fetch_assoc();

        // Verify the input password with the hashed password from the database
        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session and set session variables
            session_start();
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Optionally, set a cookie to remember the user (expiry set for 1 day as an example)
            setcookie("username", $user['username'], time() + (86400 * 1), "/"); // 86400 = 1 day

            header("location: ../index.php?page=home");
            exit();
        } else {
            // Password does not match
            echo "password: " . $password . "<br>";
            echo "hashed password: " . $user['password'];
            // pop up an alert and back to the previous page
            echo "<script>alert('Incorrect password!'); history.back();</script>";
            exit();
        }

        // Close statement
        $stmt->close();
    }
}