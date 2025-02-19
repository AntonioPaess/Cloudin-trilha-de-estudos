<?php
session_start(); 
include('includes/header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Edit and Update Contacts
                        <a href="index.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?php
                    include('dbcon.php');
                    
                    if(isset($_GET['id']))
                    { 
                        $key_child = $_GET['id'];
                        $ref_table = 'contacts';
                        $getdata = $database->getReference($ref_table)->getChild($key_child)->getValue();

                        if($getdata !== null) 
                        {
                            ?>
                            <form action="code.php" method="POST">

                                
                                <input type="hidden" name="key" value="<?=$key_child;?>">
                                <div class="form-group mb-3">
                                    <label for="first_name">First name:</label>
                                    <input type="text" id="first_name" name="first_name" value ="<?=$getdata['first_name'];?>" class="form-control" required maxlength="50">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="last_name">Last name:</label>
                                    <input type="text" id="last_name" name="last_name" value ="<?=$getdata['last_name'];?>" class="form-control" required maxlength="50">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value ="<?=$getdata['email'];?>" class="form-control" required maxlength="100">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone">Phone number:</label>
                                    <input type="tel" id="phone" name="phone" value ="<?=$getdata['phone'];?>" class="form-control" required pattern="[0-9]{10,}" title="Please enter a valid phone number">
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" name="update" class="btn btn-primary">Update contact</button>
                                </div>
                            </form>
                            <?php
                        }
                        else
                        {
                            $_SESSION['status'] = "Invalid ID";
                            header('Location: index.php');
                            exit();
                        }
                    }
                    else
                        {
                            $_SESSION['status'] = "Data not found";
                            header('Location: index.php');
                            exit();
                        }


                    
                    ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>