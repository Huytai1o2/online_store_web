<!DOCTYPE html>
<html lang="en">
<head>
    <include src="shared_lib/head.php" />
</head>
<body>
    <include src="shared_lib/navbar.php" />
    
    <div class="container">
        <h1 class="text-center">Admin Panel</h1>

        <!-- Insert User Form -->
        <h2>Add Product</h2>
        <form method="POST" action="models/product.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <?php
                        // Fetch categories dynamically from the database
                        // connect to the database
                        $server = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "cosodulieu";
                        $conn = new mysqli($server, $username, $password, $database);

                        if ($conn->connect_error) {
                            throw new Exception("Connection failed: you must create cosodulieu database" . $conn->connect_error);
            }
                        $sql = "SELECT * FROM category";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
        </form>

        <!-- List of Products -->
        <h2 class="mt-5">Product List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all products and display them
                $sql = "SELECT p.*, c.name AS category_name 
                        FROM products p 
                        JOIN category c ON p.category_id = c.id";
                $result = $conn->query($sql);

                while ($product = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$product['id']}</td>
                            <td>{$product['name']}</td>
                            <td>{$product['price']}</td>
                            <td>{$product['category_name']}</td>
                            <td>
                                <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal'
                                        data-product_id='{$product['id']}' 
                                        data-product_name='{$product['name']}' 
                                        data-price='{$product['price']}' 
                                        data-description='{$product['description']}' 
                                        data-category_id='{$product['category_id']}' 
                                        data-image='{$product['image']}'>
                                    Edit
                                </button>
                                <form method='POST' action='models/product.php' style='display:inline;'>
                                    <input type='hidden' name='product_id' value='{$product['id']}'>
                                    <button type='submit' name='delete_product' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="models/product.php" enctype="multipart/form-data">
          <input type="hidden" name="product_id" id="product_id">
          <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name">
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id">
              <?php
              // Fetch categories dynamically from the database
              $sql = "SELECT * FROM category";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image">
          </div>
          <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    // Khi modal được mở, điền thông tin sản phẩm vào modal form
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        // Lấy dữ liệu từ nút edit
        var button = event.relatedTarget; // Nút Edit đã được nhấn
        var product_id = button.getAttribute('data-product_id');
        var product_name = button.getAttribute('data-product_name');
        var price = button.getAttribute('data-price');
        var description = button.getAttribute('data-description');
        var category_id = button.getAttribute('data-category_id');
        var image = button.getAttribute('data-image');

        // Điền dữ liệu vào form trong modal
        var modalProductId = editModal.querySelector('#product_id');
        var modalProductName = editModal.querySelector('#product_name');
        var modalPrice = editModal.querySelector('#price');
        var modalDescription = editModal.querySelector('#description');
        var modalCategoryId = editModal.querySelector('#category_id');
        var modalImage = editModal.querySelector('#image');

        modalProductId.value = product_id;
        modalProductName.value = product_name;
        modalPrice.value = price;
        modalDescription.value = description;
        modalCategoryId.value = category_id;
        modalImage.value = image;  // Nếu có thể, hiển thị tên ảnh hoặc hiển thị ảnh cũ
    });
</script>

</body>
</html>
