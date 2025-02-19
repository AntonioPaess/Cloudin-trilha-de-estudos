<?php
include('auth.php');
include('includes/header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Personalize My Store
                        <a href="index.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="store_name">Store name:</label>
                            <input type="text" id="store_name" name="store_name"  class="form-control" required maxlength="50">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description:</label>
                            <input type="text" id="description" name="description" class="form-control" required maxlength="200">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="primary_color">Primary Color:</label>
                                    <input type="color" id="primary_color" name="primary_color" class="form-control form-control-color w-40" value="#563d7c" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="secondary_color">Secondary Color:</label>
                                    <input type="color" id="secondary_color" name="secondary_color" class="form-control form-control-color w-40" value="#6c757d" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="personalize_store" class="btn btn-primary">Save your store</button>
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