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
        $reference = $database->getReference('stores')->orderByChild($store_token)->getValue();
        $snapshot = $reference->getValues();
        
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

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($storeName); ?></h1>
        <p><?php echo htmlspecialchars($storeDescription); ?></p>

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <?php if(isset($_SESSION['status'])): ?>
                        <h5 class="alert alert-success"><?php echo $_SESSION['status']; ?></h5>
                        <?php unset($_SESSION['status']); ?>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?php echo htmlspecialchars($storeName); ?> - Products
                                <a href="add-product.php" class="btn btn-primary float-end">Add Products</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered tabel-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // 5. Verificar se $ownerUserId está definido antes de buscar produtos
                                    if (isset($ownerUserId)) {
                                        $ref_table = 'stores/' . $ownerUserId . '/products';
                                        $fetchdata = $database->getReference($ref_table)->getValue();
                                    } else {
                                        $fetchdata = null;
                                    }

                                    // 4. Ajustar exibição dos campos do produto
                                    if($fetchdata) {
                                        $i = 1;
                                        foreach($fetchdata as $key => $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['name'] ?? ''; ?></td>
                                                <td><?php echo $row['description'] ?? ''; ?></td>
                                                <td><?php echo $row['price'] ?? ''; ?></td>
                                                <td>
                                                    <?php if(isset($row['image_url'])): ?>
                                                        <img src="<?php echo $row['image_url']; ?>" height="50" alt="Product Image">
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="edit-contact.php?id=<?php echo $key; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                </td>
                                                <td>
                                                    <form action="code.php" method="POST">
                                                        <button type="submit" name="delete_btn" value="<?php echo $key; ?>" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7">No Record Found</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Number of Products:
                            <?php
                            // Exemplo de contagem global (se existir)
                            // Ajuste se quiser contar produtos específicos do ownerUserId
                            $ref_table = 'store/product';
                            $totalresult = $database->getReference($ref_table)->getSnapshot()->numChildren();
                            echo $totalresult;
                            ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
include('includes/footer.php');
?>