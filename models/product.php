<?php
if (!class_exists('Dbh')) {
    require_once dirname(__DIR__) . '.../controllers/dbh_class.php';
}

class ProductController_fetch extends Dbh {
    public function fetchProducts($search = '') {
        $conn = $this->connect(); // Connect to the database

        // Escape the search term to prevent SQL injection
        $search = $conn->real_escape_string($search);

        // Use a case-insensitive search in the SQL query
        $sql = "SELECT * FROM products WHERE LOWER(name) LIKE LOWER(?)";
        $stmt = $conn->prepare($sql);
        $searchTerm = $search . "%"; // Chỉ thêm % vào cuối
        $stmt->bind_param("s", $searchTerm);
        
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        $stmt->close();
        $conn->close();

        return $products;
    }

    // Method to delete product
    public function deleteProduct($product_id) {
        $conn = $this->connect();
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    // Method to edit product (can be expanded for more fields)
    public function editProduct($product_id, $product_name, $price, $description, $category_id, $image_path) {
        $conn = $this->connect();
        $sql = "UPDATE products SET name = ?, price = ?, description = ?, image = ?, category_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssii", $product_name, $price, $description, $image_path, $category_id, $product_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Xử lý upload ảnh (kiểm tra xem ảnh có hợp lệ không)
    if (!empty($image)) {
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        // Kiểm tra định dạng ảnh
        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            $image_path = "../images/" . time() . "_" . $image; // Đặt tên file duy nhất
            $image_name = time() . "_" . $image;
            move_uploaded_file($image_tmp, $image_path);
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }
    } else {
        echo "Please upload an image.";
        exit();
    }

    // Thêm sản phẩm vào cơ sở dữ liệu
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "cosodulieu";
    $conn = new mysqli($server, $username, $password, $database);
    
    $sql = "INSERT INTO products (name, price, description, image, category_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssi", $product_name, $price, $description, $image_name, $category_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../index.php?page=edit_product"); // Quay lại trang admin
    exit();
}

// Handle delete product
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $productController = new ProductController_fetch();
    $productController->deleteProduct($product_id);
    header("Location: ../index.php?page=edit_product"); // Quay lại trang admin
    exit();
}

// Handle edit product
if (isset($_POST['edit_product'])) {
    // Lấy các giá trị từ form
    $product_id = $_POST['product_id'] ?? ''; // Nếu không có thì là chuỗi rỗng
    $product_name = $_POST['product_name'] ?? ''; // Kiểm tra xem có giá trị không
    $price = $_POST['price'] ?? ''; // Kiểm tra xem có giá trị không
    $description = $_POST['description'] ?? ''; // Kiểm tra xem có giá trị không
    $category_id = $_POST['category_id'] ?? ''; // Kiểm tra xem có giá trị không

    // Kết nối CSDL
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "cosodulieu";
    $conn = new mysqli($server, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Kiểm tra ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Xử lý upload ảnh (kiểm tra định dạng)
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            $image_path = "images/" . time() . "_" . $image;
            move_uploaded_file($image_tmp, $image_path);
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ (nếu có)
        $image_path = $_POST['existing_image'] ?? ''; 
    }

    // Tạo mảng để lưu trữ các thay đổi
    $updates = [];
    $params = [];

    // Kiểm tra giá trị của từng trường, nếu có thay đổi thì thêm vào mảng cập nhật
    if (!empty($product_name)) {
        $updates[] = "name = ?";
        $params[] = $product_name;
    }

    if (!empty($price)) {
        $updates[] = "price = ?";
        $params[] = $price;
    }

    if (!empty($description)) {
        $updates[] = "description = ?";
        $params[] = $description;
    }

    if (!empty($category_id)) {
        $updates[] = "category_id = ?";
        $params[] = $category_id;
    }

    if (!empty($image_path)) {
        $updates[] = "image = ?";
        $params[] = $image_path;
    }

    // Kiểm tra nếu có bất kỳ trường nào được cập nhật
    if (count($updates) > 0) {
        // Thêm ID sản phẩm vào cuối mảng params
        $params[] = $product_id;

        // Tạo câu lệnh SQL để cập nhật
        $sql = "UPDATE products SET " . implode(", ", $updates) . " WHERE id = ?";

        // Chuẩn bị và gắn tham số
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params); // Binding params dynamically
            $stmt->execute();
            $stmt->close();
        }

        // Quay lại trang admin sau khi cập nhật thành công
        header("Location: ../index.php?page=edit_product");
        exit();
    } else {
        echo "No data to update.";
    }
}


?>
