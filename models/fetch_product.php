<?php
require_once 'product.php';

header('Content-Type: application/json'); // Đặt kiểu phản hồi là JSON

if (isset($_POST['search'])) {
    $search = $_POST['search'];

    $productController_fetch = new ProductController_fetch();
    $products = $productController_fetch->fetchProducts($search);

    // Nếu có sản phẩm, trả về danh sách sản phẩm dạng JSON
    if (!empty($products)) {
        echo json_encode([
            'status' => 'success',
            'data' => $products
        ]);
    } else {
        // Nếu không tìm thấy sản phẩm
        echo json_encode([
            'status' => 'no_results',
            'message' => 'No products found'
        ]);
    }
    exit;
}

// Nếu không có tham số 'search', trả về lỗi
echo json_encode([
    'status' => 'error',
    'message' => 'No search term provided'
]);
exit;
