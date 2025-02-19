<?php
include('auth.php');
include('includes/header.php');
require_once('includes/Token.php');

$storeInfo = null;
if(isset($_SESSION['verified_user_id'])) {
    $userId = $_SESSION['verified_user_id'];
    $storeInfo = getStoreInfo($userId);
}

// Pega o token da URL
$store_token = isset($_GET['store']) ? $_GET['store'] : null;

if ($store_token) {
    // Busca a loja pelo token
    $reference = $database->getReference('stores')->orderByChild('store_token')->equalTo($store_token);
    $snapshot = $reference->getValue();
    
    if ($snapshot) {
        $store_data = current($snapshot);
        // Usa $store_data para mostrar as informações da loja
    }
}
?>

<div class="container">
    <div class="row">

    
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
                        My Products
                        <a href="add-contact.php" class="btn btn-primary float-end"> Add Products</a>
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
                            include('dbcon.php');

                            $ref_table = 'stores/' . $userId . '/products';
                            $fetchdata = $database->getReference($ref_table)->getValue();

                            if($fetchdata > 0)
                            {   $i = 1;
                                foreach($fetchdata as $key => $row)
                                {
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?=$row['first_name']?></td>
                                            <td><?=$row['last_name']?></td>
                                            <td><?=$row['email']?></td>
                                            <td><?=$row['phone']?></td>
                                            <td>
                                                <a href="edit-contact.php?id=<?= $key;?>" class="btn btn-primary btn-sm">Edit</a>
                                            </td>
                                            <td> 
                                                
                                                <form action="code.php" method = "POST">
                                                    <button type = "submit" name = "delete_btn" value = "<?=$key?>" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                    <tr>
                                        <td colspan="7">No Record Found</td>
                                    </tr>

                                <?php
                                    
                            
                            }


                            ?>

                            <tr>
                                <td></td>
                            </tr>
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
                    $ref_table = 'store/product';
                    $totalresult = $database->getReference($ref_table)->getSnapshot()->numChildren();
                    echo $totalresult;
                    ?>
                </h5>
            </div>
        </div>
        </div>
</div>

<?php
include('includes/footer.php');
?>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>