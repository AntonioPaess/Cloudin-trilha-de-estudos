<?php
session_start();
if (isset($_SESSION['verified_user_id'])) {
    $_SESSION['status'] = "You are already Logged in.";
    header('Location: home.php');
    exit();
} 
include('includes/header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <?php
                if (isset($_SESSION['status'])) {
                    echo "<h5 class = 'alert - alert-success'>" . $_SESSION['status'] . "</h5>";
                    unset($_SESSION['status']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Store Register
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="admin_name">Admin Name:</label>
                                <input type="text" id="admin_name" name="admin_name" class="form-control" title="Please enter your store name for your link" required maxlength="50">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Admin Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required maxlength="100">
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" title="Please enter your password" required maxlength="50">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="register_btn" class="btn btn-primary">Register My Store</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    include('includes/footer.php');
    ?>