<?php
include('includes/header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Add Contacts
                        <a href="index.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="first_name">First name:</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" required maxlength="50">
                        </div>
                        <div class="form-group mb-3">
                            <label for="last_name">Last name:</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" required maxlength="50">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required maxlength="100">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Phone number:</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required pattern="[0-9]{10,}" title="Please enter a valid phone number">
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="save_contact" class="btn btn-primary">Save contact</button>
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