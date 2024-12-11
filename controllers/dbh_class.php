<?php

function insertIfNotExists($conn, $table, $column, $value) {
    // Check if the value already exists in the table
    $sql_check = "SELECT COUNT(*) FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql_check);

    // Check if preparation failed
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("s", $value); // "s" for string parameter
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // If the value doesn't exist, insert it
    if ($count == 0) {
        $sql_insert = "INSERT INTO $table ($column) VALUES (?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("s", $value); // "s" for string parameter
        $stmt->execute();
        $stmt->close();
    }
}

function insertProductIfNotExists($conn, $product_name, $price, $description, $image, $category_id) {
    // Check if the product with the same name and category_id already exists
    $sql_check = "SELECT COUNT(*) FROM products WHERE name = ? AND category_id = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("si", $product_name, $category_id); // "s" for string and "i" for integer
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    // If the product doesn't exist, insert it
    if ($count == 0) {
        $sql_insert = "INSERT INTO products (name, price, description, image, category_id) 
                    VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sdssi", $product_name, $price, $description, $image, $category_id); // Bind variables with types
        $stmt->execute();
        $stmt->close();
    }
}

class Dbh {
    protected function connect() {
        try {
            $server = "localhost";
            $username = "root";
            $password = "";
            $database = "cosodulieu";
            $conn = new mysqli($server, $username, $password, $database);

            if ($conn->connect_error) {
                throw new Exception("Connection failed: you must create cosodulieu database" . $conn->connect_error);
            }

            // Tạo bảng category
            $sql0 = "CREATE TABLE IF NOT EXISTS category (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) UNIQUE NOT NULL
            )";

            // Tạo bảng users
            $sql1 = "CREATE TABLE IF NOT EXISTS users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(1000) NOT NULL,
                email VARCHAR(50) NOT NULL,
                level INT(2) NOT NULL        
            )";

            // Tạo bảng products với khóa ngoại tham chiếu đến bảng category
            $sql2 = "CREATE TABLE IF NOT EXISTS products (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) UNIQUE NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                description TEXT,
                image VARCHAR(255) NOT NULL,
                category_id INT(6) UNSIGNED,
                FOREIGN KEY (category_id) REFERENCES category(id)
            )";

            // Thực thi các câu lệnh SQL
            if ($conn->query($sql0)) {
                // echo "Bảng category tạo thành công";
            } else {
                echo "Lỗi tạo bảng category: " . $conn->error;
            }

            if ($conn->query($sql1)) {
                // echo "Bảng users tạo thành công";
            } else {
                echo "Lỗi tạo bảng users: " . $conn->error;
            }

            if ($conn->query($sql2)) {
                // echo "Bảng products tạo thành công";
            } else {
                echo "Lỗi tạo bảng products: " . $conn->error;
            }


            // Insert categories if not exists
            insertIfNotExists($conn, 'category', 'name', 'Điện thoại');
            insertIfNotExists($conn, 'category', 'name', 'Máy tính bảng');
            insertIfNotExists($conn, 'category', 'name', 'Laptop');
            insertIfNotExists($conn, 'category', 'name', 'Đồng hồ');

            // Insert products if not exists (with category_id reference)
            // Insert products if not exists (with category_id reference)
            insertProductIfNotExists($conn, 'Samsung Galaxy S23 Ultra', 27000000, 'Điện thoại Samsung Galaxy S23 Ultra có camera và hiệu năng mạnh mẽ', 'samsung-galaxy-s23-ultra.jpg', 1);
            insertProductIfNotExists($conn, 'iPhone 14 Pro Max', 32000000, 'Điện thoại iPhone 14 Pro Max với màn hình OLED và chip A16 Bionic', 'iphone-14-pro-max.jpg', 1);
            insertProductIfNotExists($conn, 'MacBook Pro M2 2023', 50000000, 'Laptop MacBook Pro M2 2023 với chip M2 và màn hình Retina', 'macbook-pro-m2.jpg', 2);
            insertProductIfNotExists($conn, 'iPad Air 2022', 16000000, 'Máy tính bảng iPad Air 2022 với màn hình Liquid Retina và chip A14', 'ipad-air-2022.jpg', 2);
            insertProductIfNotExists($conn, 'Sony WH-1000XM5', 9000000, 'Tai nghe không dây Sony WH-1000XM5 với chống ồn chủ động', 'sony-wh-1000xm5.jpg', 4);
            insertProductIfNotExists($conn, 'Dell XPS 15 2023', 42000000, 'Laptop Dell XPS 15 với màn hình 4K và chip Intel i7 thế hệ mới', 'dell-xps-15-2023.jpg', 3);

            // if (!$conn->query($sql3)) {
            //     throw new Exception("Lỗi thêm dữ liệu vào bảng category: " . $conn->error);
            // }

            // if (!$conn->query($sql4)) {
            //     throw new Exception("Lỗi thêm dữ liệu vào bảng products: " . $conn->error);
            // }
            


            return $conn; // Trả về kết nối
        } 
        catch (Exception $e) {
            echo "Connection failed: " . $e->getMessage();
            return null; // Trả về null nếu kết nối thất bại
        }
    }
}
