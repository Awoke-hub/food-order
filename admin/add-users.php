<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add User</h1>
        <br><br>

        <?php 
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="User name" required></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="User Password" required></td>
                </tr>
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="customer_name" placeholder="Full Name" required></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><input type="email" name="customer_email" placeholder="User email" required></td>
                </tr>
                <tr>
                    <td>Contact: </td>
                    <td><input type="text" name="customer_contact" placeholder="10-digit phone" pattern="\d{10}" required></td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td><input type="text" name="customer_address" placeholder="User address" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add User" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php'); ?>

<?php 
// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Include DB config (already has session_start and $conn)
    include('../config/constants.php'); 

    // Sanitize & validate inputs
    $username = trim($_POST['username']);
    $password_raw = $_POST['password'];
    $customer_name = trim($_POST['customer_name']);
    $customer_email = filter_var(trim($_POST['customer_email']), FILTER_SANITIZE_EMAIL);
    $customer_contact = trim($_POST['customer_contact']);
    $customer_address = trim($_POST['customer_address']);

    // Validate fields
    $errors = [];

    if (empty($username) || empty($password_raw) || empty($customer_name) || empty($customer_email) || empty($customer_contact) || empty($customer_address)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match('/^\d{10}$/', $customer_contact)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }

    if (strlen($password_raw) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }

    // Check for existing user with same username, email or contact
    if (empty($errors)) {
        $check = $conn->prepare("SELECT * FROM users WHERE username = ? OR customer_email = ? OR customer_contact = ?");
        $check->bind_param("sss", $username, $customer_email, $customer_contact);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Username, email, or contact already exists.";
        }
        $check->close();
    }

    // If no errors, insert the user
    if (empty($errors)) {
        $password = password_hash($password_raw, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, customer_name, customer_email, customer_contact, customer_address, created_at) 
                                VALUES (?, ?, ?, ?, ?, ?, current_timestamp())");
        $stmt->bind_param("ssssss", $username, $password, $customer_name, $customer_email, $customer_contact, $customer_address);

        if ($stmt->execute()) {
            $_SESSION['add'] = "<div class='success'>User added successfully.</div>";
            header("Location: " . SITEURL . "admin/manage-users.php");
            exit;
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to add user: " . htmlspecialchars($stmt->error) . "</div>";
            header("Location: " . SITEURL . "admin/add-users.php");
            exit;
        }
    } else {
        // Store error messages in session
        $_SESSION['add'] = "<div class='error'>" . implode("<br>", $errors) . "</div>";
        header("Location: " . SITEURL . "admin/add-users.php");
        exit;
    }
}
?>
