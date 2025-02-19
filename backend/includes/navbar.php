<?php
if(isset($_SESSION['verified_user_id'])) {
    require_once(__DIR__ . '/Token.php');
    
    $storeInfo = getStoreInfo($_SESSION['verified_user_id']);
    
    $primaryColor = isset($storeInfo['primary_color']) ? $storeInfo['primary_color'] : '#343a40';
    $secondaryColor = isset($storeInfo['secondary_color']) ? $storeInfo['secondary_color'] : '#6c757d';
    $storeName = isset($storeInfo['store_name']) ? $storeInfo['store_name'] : 'My Store';
    
    // Define a classe do navbar baseado na cor
    $navbarClass = isLightColor($primaryColor) ? 'navbar-light' : 'navbar-dark';
} else {
    $primaryColor = '#343a40';
    $storeName = 'My Store';
    $navbarClass = 'navbar-dark';
}
?>

<nav class="navbar navbar-expand-lg <?php echo $navbarClass; ?>" style="background-color: <?php echo $primaryColor; ?>;">
    <div class="container">
        <a class="navbar-brand" href="home.php"><?php echo htmlspecialchars($storeName); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="mystore.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Marketplace</a>
                </li>

                <?php if(!isset($_SESSION['verified_user_id'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>

                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>


        </div>
    </div>

</nav>