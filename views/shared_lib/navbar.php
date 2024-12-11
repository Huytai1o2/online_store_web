<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo and brand -->
        <a class="navbar-brand" href="#">Logo</a>
        <!-- Button collapses on small screen -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php?page=home">Home</a>
                </li>
                
                <!-- Dropdown for Products -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Product
                    </a>
                    <ul class="dropdown-menu shadow-lg" aria-labelledby="navbarDropdown" style="max-height: 100px; 
                        overflow-y: auto;">
                        
                        <li><a class="dropdown-item" href="index.php?page=product">All product</a></li>
                        <?php
                        // Kết nối tới cơ sở dữ liệu
                        $server = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "cosodulieu";
                        $conn = new mysqli($server, $username, $password, $database);

                        // Kiểm tra kết nối
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Truy vấn dữ liệu từ bảng category
                        $sql = "SELECT * FROM category";
                        $result = $conn->query($sql);

                        // Lặp qua các danh mục và tạo mục trong dropdown
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<li><a class='dropdown-item' href='index.php?page=product&search=" . urlencode($row['name']) . "'>" . htmlspecialchars($row['name']) . "</a></li>";
                            }
                        } else {
                            echo "<li><a class='dropdown-item' href='#'>No Categories Available</a></li>";
                        }

                        // Đóng kết nối
                        $conn->close();
                        ?>
                    </ul>
                </li>

                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['username'])) {
                    if ($_SESSION['username'] === 'admin') {
                        echo '<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin
                                    </a>
                                    <ul class="dropdown-menu shadow-lg" aria-labelledby="navbarDropdownAdmin" style="right: 0">
                                        <li><a class="dropdown-item" href="index.php?page=edit_product">Edit Product</a></li>
                                        <li><a class="dropdown-item" href="index.php?page=edit_user">Edit User</a></li>
                                    </ul>
                                </li>';

                        echo '<li class="nav-item">
                                <form method="POST" action="controllers/logout_controller.php">
                                    <a class="nav-link" href="controllers/logout_controller.php">Logout</a>
                                </form>
                            </li>';
                    }
                } else {
                    echo '<li class="nav-item">
                              <a class="nav-link" href="index.php?page=login">Login</a>
                          </li>';
                }
                ?>

                <?php
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                if (!isset($_SESSION['username']))
                {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="index.php?page=register">Register</a>
                        </li>';
                }
                ?>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="index.php?page=register">Register</a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>