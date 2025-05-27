<?php
    // Include constants file session is already started there
    include('../config/constants.php');

    // Check if parameters are valid
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        // Sanitize inputs
        $id = (int)$_GET['id'];
        $image_name = basename($_GET['image_name']);
        // Validate parameters
        if($id <= 0 || !preg_match('/^[a-z0-9_\-\.]+$/i', $image_name)) {
            $_SESSION['unauthorize'] = "<div class='error'>Invalid request parameters!</div>";
            header('Location: '.SITEURL.'admin/manage-food.php');
            exit();
        }
        // Remove image if exists
        if(!empty($image_name)) {
            $path = "../images/food/".$image_name;
            
            if(file_exists($path) && is_file($path)) {
                if(!unlink($path)) {
                    $_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
                    header('Location: '.SITEURL.'admin/manage-food.php');
                    exit();
                }
            }
        }

        // Delete from database using prepared statement
        $sql = "DELETE FROM tbl_food WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if(mysqli_stmt_execute($stmt)) {
                $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            } else {
                $_SESSION['delete'] = "<div class='error'>Failed to delete food: ".mysqli_error($conn)."</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['delete'] = "<div class='error'>Database error: ".mysqli_error($conn)."</div>";
        }
        // Redirect to manage food page
        header('Location: '.SITEURL.'admin/manage-food.php');
        exit();

    } else {
        // Invalid request
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access attempt!</div>";
        header('Location: '.SITEURL.'admin/manage-food.php');
        exit();
    }
?>