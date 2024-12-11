<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'shared_lib/head.php'; ?>
    <style>
        /* CSS for Product Cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer; /* Thay đổi cursor thành pointer khi di chuột vào sản phẩm */
            border-radius: 8px; /* Thêm bo góc cho thẻ card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ nhẹ */
        }

        /* Khi hover vào sản phẩm */
        .card:hover {
            transform: scale(1.05); /* Phóng to sản phẩm một chút */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Thêm bóng đổ khi hover */
        }

        /* Khi hover vào ảnh sản phẩm */
        .card-img-container:hover {
            opacity: 0.8; /* Làm mờ ảnh khi hover */
        }

        /* Modal Style */
        .modal-body {
            padding: 30px;
        }

        #modal-product-image {
            width: 100%;
            border-radius: 8px; /* Bo góc cho ảnh trong modal */
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Search box */
        .search-container {
            margin-bottom: 20px;
        }

        #search-box {
            width: 70%;
            display: inline-block;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <!-- Display the username if logged in -->
        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // if (isset($_SESSION['username'])) {
        //     echo "<p>Hello, " . htmlspecialchars($_SESSION['username']) . "!</p>";
        // } else {
        //     echo "<p>Please sign in or sign up to show your products.</p>";
        // }
        ?>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Our Product Catalog</h2>

        <form action="index.php" method="get" class="text-center mb-4">
            <!-- Add hidden field to ensure the page is set to 'product' -->
            <input type="hidden" name="page" value="product">

            <!-- Search Box -->
            <div class="search-container">
                <input type="text" id="search-box" name="search" placeholder="Search for products..."
                    value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>

            <!-- Dropdown Suggestions -->
            <div class="position-relative w-50 mx-auto">
                <ul id="suggestions" class="dropdown-menu w-100" style="display: none;">
                    <!-- Suggestions will be appended here dynamically -->
                </ul>
            </div>
        </form>

        <div class='row' id='product-list'>
            <?php
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card' data-bs-toggle='modal' data-bs-target='#productModal' 
                            data-id='" . htmlspecialchars($product['id']) . "'
                            data-name='" . htmlspecialchars($product['name']) . "'
                            data-price='" . htmlspecialchars($product['price']) . "'
                            data-description='" . htmlspecialchars($product['description']) . "'
                            data-image='" . htmlspecialchars($product['image']) . "'>
                            <div class='card-img-container'>
                                <img src='images/" . htmlspecialchars($product['image']) . "' 
                                    alt='" . htmlspecialchars($product['name']) . "' 
                                    class='card-img-top'>
                            </div>
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($product['name']) . "</h5>
                                <p class='card-text'>Price: VND " . htmlspecialchars($product['price']) . "</p>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No products found for '" . htmlspecialchars($search) . "'</p>";
            }
            ?>
        </div>

    </div>

    <?php include 'shared_lib/footer.php'; ?>
    <script src="js/load_product.js"></script>

    <!-- Modal for product details -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="product-details">
            <!-- Product details will be dynamically inserted here -->
            <div class="text-center">
                <img id="modal-product-image" src="" class="img-fluid" alt="Product Image" style="width: 50%">
            </div>
            <h5 id="modal-product-name"></h5>
            <p><strong>Price:</strong> <span id="modal-product-price"></span></p>
            <p><strong>Description:</strong> <span id="modal-product-description"></span></p>

            <!-- Add to Cart Button -->
            <button type="button" class="btn btn-primary">Add to Cart</button>

            <!-- Buy Now Button -->
            <button type="button" class="btn btn-success">Buy Now</button>
            </div>
        </div>
        </div>
    </div>
    </div>

    <script>
        // Khi Modal được mở, lấy thông tin sản phẩm và điền vào Modal
        var productModal = document.getElementById('productModal');
        productModal.addEventListener('show.bs.modal', function (event) {
            // Lấy dữ liệu từ thẻ sản phẩm
            var button = event.relatedTarget; // Sản phẩm được nhấn
            var productName = button.getAttribute('data-name');
            var productPrice = button.getAttribute('data-price');
            var productDescription = button.getAttribute('data-description');
            var productImage = button.getAttribute('data-image');
            
            // Cập nhật các phần tử trong Modal
            var modalProductName = productModal.querySelector('#modal-product-name');
            var modalProductPrice = productModal.querySelector('#modal-product-price');
            var modalProductDescription = productModal.querySelector('#modal-product-description');
            var modalProductImage = productModal.querySelector('#modal-product-image');
            
            modalProductName.textContent = productName;
            modalProductPrice.textContent = 'VND ' + productPrice;
            modalProductDescription.textContent = productDescription;
            modalProductImage.src = 'images/' + productImage;  // Đảm bảo ảnh hiển thị đúng
        });
    </script>

</body>
</html>