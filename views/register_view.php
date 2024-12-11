<!DOCTYPE html>
<html lang="en">
<head>
    <include src="shared_lib/head.php" />
</head>
<body>
    <include src="shared_lib/navbar.php" />
    <!-- Content -->

    <div class="container mt-5 text-center">
        <h1>Welcome to my wesite</h1>
    </div>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Create an Account</h2>

        <form method="POST" action="includes/signup.inc.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required minlength="8">
                <i class="bi bi-eye-slash position-absolute" id="togglePassword" style="cursor: pointer; right: 10px; top: 50%; transform: translateY(-50%);"></i>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="8">
            </div>
            <!-- add the name attribute to the submit button -->
            <button type="submit" class="btn btn-primary w-100" name="submit">Sign Up</button>
        </form>
    </div>
    </div>

<include src="shared_lib/footer.php" />

</body>

</html>