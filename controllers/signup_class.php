<?php
class Signup extends Dbh {

protected function setUser($username, $email, $password) {
    $level = 1;
    $conn = $this->connect();
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, level) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sssi", $username, $email, $hashedPwd, $level);

    if (!$stmt->execute()) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    // reset all id to start from 1
    $stmt = $conn->prepare("SET @autoid :=0");
    $stmt->execute();
    $stmt = $conn->prepare("UPDATE users SET id = @autoid := (@autoid+1)");
    $stmt->execute();
    $stmt = $conn->prepare("ALTER TABLE users AUTO_INCREMENT = 1");
    $stmt->execute();

    $stmt->close();
    $conn->close();
}

protected function checkUser($username) {
    // $conn = $this->connect();

    // // check the connection
    // $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    
    // if (!$stmt) {
    //     header("location: ../signup.php?error=stmtfailed");
    //     exit();
    // }

    // $stmt->bind_param("ss", $username, $email);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // if ($result->num_rows > 0) {
    //     $stmt->close();
    //     $conn->close();
    //     return true;
    // } else {
    //     $stmt->close();
    //     $conn->close();
    //     return false;
    // }

    $conn = $this->connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

protected function checkEmail($email) {
    $conn = $this->connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
}
