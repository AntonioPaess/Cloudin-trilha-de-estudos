<?php
session_start();
include('dbcon.php');

// Pega o token da URL se existir
$store_token = isset($_GET['store']) ? $_GET['store'] : '';

if (isset($_SESSION['verified_user_id'])) {
    $_SESSION['status'] = "You are already Logged in.";
    header('Location: mystore.php?store=' . $store_token);
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
                            Login
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php<?php echo $store_token ? '?store=' . $store_token : ''; ?>" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email adress:</label>
                                <input type="email" id="email" name="email" class="form-control" required maxlength="100">
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" title="Please enter your password" required maxlength="50">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
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