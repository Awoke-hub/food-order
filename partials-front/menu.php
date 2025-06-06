<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online food delivery</title>
    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
        <div class="logo">
        <a href="<?php echo SITEURL; ?>" title="Restaurant Logo">
            <img src="images/logo.jpg" alt="Restaurant Logo" class="restaurant-logo">
        </a>
    </div>   
<br> 
<div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>index.php">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>foods.php">Foods</a>
                    </li>
                    <li>            
							<?php
						if(empty($_SESSION["u_id"]))
							{
								echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>';
							}
						else
							{
                                    echo  '<li class="nav-item"><a href="myorders.php" class="nav-link active">Myorders</a> </li>';
									echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
							}
						?>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>           
    <!-- Navbar Section Ends Here -->