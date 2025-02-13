<?php
session_start();
include('includes/header.php');
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
                        PHP Firebase CRUD - Realtime Database
                        <a href="add-contact.php" class="btn btn-primary float-end"> Add Contacts</a>
                    </h4>
                </div>
                <div class="card-body">

                    <table class="table table-bordered tabel-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Email Id</th>
                                <th>Phone number</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('dbcon.php');

                            $ref_table = 'contacts';
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
                                                <a href="delete-contact.php" class="btn btn-danger btn-sm">Delete</a>
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
</div>

<?php
include('includes/footer.php');
?>