<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


include('auth.php');
include('includes/header.php');
require_once('includes/Token.php');

// Inicialização das variáveis com valores padrão
$primaryColor = '#343a40';
$secondaryColor = '#6c757d';
$storeName = 'My Store';
$storeDescription = '';
$ownerUserId = null;

// Verifica usuário logado e obtém informações da loja
if (isset($_SESSION['verified_user_id'])) {
    $userId = $_SESSION['verified_user_id'];
    $storeInfo = getStoreInfo($userId);
    
    // Se existe um token na URL, usa ele, senão usa o token da loja do usuário
    $store_token = isset($_GET['store']) ? $_GET['store'] : 
                   (isset($storeInfo['store_token']) ? $storeInfo['store_token'] : null);
} else {
    // Se não está logado, só verifica o token da URL
    $store_token = isset($_GET['store']) ? $_GET['store'] : null;
}

// Busca informações da loja pelo token
if ($store_token) {
    try {
        $snapshot = $database->getReference('stores')->orderByChild('store_token')->equalTo($store_token)->getValue();
         
        
        if ($snapshot) {
            $store_data = current($snapshot);
            $primaryColor = $store_data['primary_color'] ?? '#343a40';
            $secondaryColor = $store_data['secondary_color'] ?? '#6c757d';
            $storeName = $store_data['store_name'] ?? 'My Store';
            $storeDescription = $store_data['description'] ?? '';
            $ownerUserId = $store_data['user_id'] ?? null;
        } else {
            echo "No store found with token: " . htmlspecialchars($store_token); // Debug
        }
    } catch (Exception $e) {
        echo "Error fetching store data: " . $e->getMessage(); // Debug
    }
} else {
    echo "Store token not provided."; // Debug
}
?>


    <title><?php echo htmlspecialchars($storeName); ?></title>
    <style>
        :root {
            --primary-color: <?php echo $primaryColor; ?>;
            --secondary-color: <?php echo $secondaryColor; ?>;
        }
    </style>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Add Your Product
                        <a href="index.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="product_name">Product name:</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" required maxlength="50">
                        </div>
                        <div class="form-group mb-3">
                            <label for="product_descripton">Description:</label>
                            <input type="text" id="product_descripton" name="product_descripton" class="form-control" required maxlength="50">
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" class="form-control" required maxlength="100">
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Image:</label>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   class="form-control" 
                                   accept="image/png"
                                   required>
                            <small class="text-muted">Apenas arquivos PNG são aceitos</small>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="save_contact" class="btn btn-primary">Save Your Product</button>
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