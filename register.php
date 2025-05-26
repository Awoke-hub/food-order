<?php
// Initialize variables
$errors = [];
$showAlert = false;
include('config/constants.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = "Invalid form submission";
    }
    // Sanitize and validate inputs
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $customer_name = trim(filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING));
    $customer_email = trim(filter_input(INPUT_POST, 'customer_email', FILTER_SANITIZE_EMAIL));
    $customer_contact = trim(filter_input(INPUT_POST, 'customer_contact', FILTER_SANITIZE_STRING));
    $customer_address = trim(filter_input(INPUT_POST, 'customer_address', FILTER_SANITIZE_STRING));
    // Validation rules
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (!preg_match('/^[0-9]{10}$/', $customer_contact)) {
        $errors[] = "Phone number must be exactly 10 digits";
    }
    if ($password !== $cpassword) {
        $errors[] = "Passwords do not match";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }
    // Check existing users
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR customer_email = ? OR customer_contact = ?");
        $stmt->bind_param("sss", $username, $customer_email, $customer_contact);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Username, email, or phone number already exists";
        }
        $stmt->close();
    }
    // Insert new user
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, customer_name, customer_email, customer_contact, customer_address, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, current_timestamp())");
        $stmt->bind_param("ssssss", $username, $hash, $customer_name, $customer_email, $customer_contact, $customer_address);

        if ($stmt->execute()) {
            $showAlert = true;
            // Clear form data
            $_POST = array();
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Food Order</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="http://localhost/food-order">
                    <img src="images/logo.jp" alt="Restaurant Logo" class="Restaurant-logo">
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <div class="container my-4">
        <?php if ($showAlert): ?>
            <div class="alert alert-success">
                Account created successfully! <a href="login.php">Login here</a>
            </div>
            <?php header("Refresh: 5; url=login.php"); ?>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <h2 class="text-center">Signup Here</h2>
        <h5>*All fields are required</h5>
        
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" class="form-control" name="customer_name" 
                       value="<?= htmlspecialchars($_POST['customer_name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Password </label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="cpassword" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="customer_email" 
                       value="<?= htmlspecialchars($_POST['customer_email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="tel" class="form-control" name="customer_contact" 
                       value="<?= htmlspecialchars($_POST['customer_contact'] ?? '') ?>" required>
                <small class="text-muted">10-digit number only</small>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" name="customer_address" required><?= 
                    htmlspecialchars($_POST['customer_address'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
    <?php include('partials-front/footer.php'); ?>
</body>
</html>