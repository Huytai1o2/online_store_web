<!DOCTYPE html>
<html lang="en">
<head>
    <include src="shared_lib/head.php" />
</head>
<body>
    <include src="shared_lib/navbar.php" />
<!-- Content -->

    <!-- Centered Login Form Container -->
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Login to Your Account</h2>
            <form method="POST" action="includes/login.inc.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username (Email):</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="8">
                </div>
                <button type="submit" class="btn btn-primary w-100" name="submit">Login</button>
            </form>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col mt">
                <h2>Column 1</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt tincidunt. Nullam nec purus nec nunc tincidunt tincidunt. Nullam nec purus nec nunc tincidunt tincidunt.</p>
            </div>
            <div class="col mt">
                <h2>Column 2</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt tincidunt. Nullam nec purus nec nunc tincidunt tincidunt. Nullam nec purus nec nunc tincidunt tincidunt.</p>
            </div>
            <div class="col mt">
                <h2>Column 3</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt tincidunt. Nullam nec purus nec nunc tincidunt tincidunt. Nullam nec purus nec nunc tincidunt tincidunt.</p>
            </div>
        </div>
    </div>

<include src="shared_lib/footer.php" />

</body>

</html>