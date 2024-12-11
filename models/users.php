<?php
require_once dirname(__DIR__) . '/controllers/dbh_class.php';

class UserController extends Dbh {
    public function addUser($username, $email, $password) {
        $conn = $this->connect();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            // User added successfully
            // show a popup success message
            echo "<script>alert('User added successfully!');</script>";
            header("Location: ../index.php?page=edit_user"); // redirect to the admin page
        } else {
            // Handle errors
            // show a popup error message or redirect to previous page
            echo "<script>alert('Error adding user!'); history.back();</script>";
        }
        $stmt->close();
    }

    public function deleteUser($username) {
        $conn = $this->connect();

        $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            // User deleted successfully
            // show a popup success message
            // reset all id to start from 1
            $stmt = $conn->prepare("SET @autoid :=0");
            $stmt->execute();
            $stmt = $conn->prepare("UPDATE users SET id = @autoid := (@autoid + 1)");
            $stmt->execute();
            $stmt = $conn->prepare("ALTER TABLE users AUTO_INCREMENT = 1");
            $stmt->execute();
           echo "<script>alert('User deleted successfully!');</script>";
            header("Location: ../index.php?page=edit_user"); // redirect to the admin page
        } else {
            // Handle errors
            // show a popup error message or redirect to previous page
            echo "<script>alert('Error deleting user!'); history.back();</script>";
        }
        $stmt->close();
    }

    public function updateUser($username, $email, $password) {
        $conn = $this->connect();
        
        // find user by username and update email and password
        $stmt = $conn->prepare("UPDATE users SET email = ?, password = ? WHERE username = ?");
        $stmt->bind_param("sss", $email, $password, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllUsers() {
        $conn = $this->connect();

        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $stmt->close();
        return $users;
    }
}

// Handle POST requests for adding and deleting users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserController();

    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $controller->addUser($username, $email, $password);
    } elseif (isset($_POST['delete_user'])) {
        $username = $_POST['username'];
        $controller->deleteUser($username);
    }
}
