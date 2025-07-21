<?php
session_start();

// Include the database connection file
include_once 'db_conn.php';

// Check if user is already logged in, if yes redirect to index page
if (isset($_SESSION['user_id']) || isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to fetch user from database
    $sql = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user credentials
    if ($user && password_verify($password, $user['Password'])) {
        // User authenticated, set session variables and redirect to index page
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_email'] = $user['Email'];
        header("Location: index.php");
        exit;
    } else {
        // Authentication failed, show error message
        $error_message = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">User Login</h2>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <br>
                    <a href="registration.php">Register if not a member</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>