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
        <h2>Insert User</h2>
        <form method="POST" action="models/users.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
        </form>

        <!-- List of Users -->
        <h2 class="mt-5">User List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'models/users.php'; // Include your user controller that fetches users
                $userController = new UserController(); // Create an instance of UserController
                $users = $userController->getAllUsers(); // Call the correct method
                foreach ($users as $user) {
                    echo "<tr>
                        <td>{$user['id']}</td>
                        <td>{$user['username']}</td>
                        <td>{$user['email']}</td>
                        <td>
                            <form method='POST' action='models/users.php' style='display:inline;'>
                                <input type='hidden' name='username' value='{$user['username']}'>
                                <button type='submit' name='delete_user' class='btn btn-danger'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table> 
    </div>
</body>

</html>
