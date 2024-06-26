<?php
$title = "Register";
ob_start(); ?>

<div class="container">
    <form method="post" action="index.php?action=addUser">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Name</label>
                <input type="text" class="form-control" name="user_surname" placeholder="Name">
            </div>
            <div class="form-group col-md-4">
                <label>Email</label>
                <input type="email" class="form-control" name="user_email" placeholder="Email">
                <small class="text-muted">
                    Enter a valid email, you'll receive a welcome email!
                </small>
            </div>
            <div class="form-group col-md-4">
                <label>Age</label>
                <input type="number" class="form-control" name="user_age" placeholder="Age">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Login</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                    </div>
                    <input type="text" class="form-control" name="user_login" placeholder="Username" required>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Password</label>
                <input type="password" class="form-control" name="user_password" placeholder="Password">
                <small class="text-muted">
                    Must be at least 7 characters long.
                </small>
            </div>
        </div>
        <div class="row">
            <div class="col-9"><a href="index.php?action=login">Already have an account? Log in!</a></div>
            <div class="col"> <button type="submit" name="submit-button" class="btn btn-success">Sign in !</button>
            </div>
        </div>
    </form>

    <br>

    <?= $error ?>
    <?= $message ?>

</div>

<?php
$content = ob_get_clean();
include_once 'app/views/client/layout.php';
