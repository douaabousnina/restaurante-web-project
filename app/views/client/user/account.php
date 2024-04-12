<?php
$title = "Account";
var_dump($_SESSION);
ob_start(); ?>

<div class="container">
    <h2>Edit your profile info</h2>



    <form method="post" action="index.php?action=updateAccount&user_id=<?= $user['user_id'] ?>">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label >Name</label>
                <input type="text" class="form-control" name="user_surname" value="<?= $user['user_surname'] ?>">
            </div>
            <div class="form-group col-md-4">
                <label>Email</label>
                <input type="email" class="form-control" name="user_email" value="<?= $user['user_email'] ?>">
            </div>
            <div class="form-group col-md-4">
                <label >Age</label>
                <input type="number" class="form-control" name="user_age" value="<?= $user['user_age'] ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <label>Login</label>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                    </div>
                    <input type="text" class="form-control" name="user_login" value="<?= $user['user_login'] ?>" required>
                </div>
            </div>
        </div>
        <h5>To confirm changes please enter your password:</h5>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Password</label>
                <input type="password" class="form-control" name="user_password" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label>Confirm your password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password">
            </div>
        </div>
        <div class="row">
            <div class="col-9"><a href="index.php?action=deleteAccount&user_id=<?= $user['user_id'] ?>" class="btn btn-danger">Click here if you want to delete your account</a></div>
            <div class="col"> <button type="submit" class="btn btn-success">Confirm</button>
            </div>
        </div>

    </form>

        
    <?= $message ?>
    <?= $error ?>
    
</div>

<?php
$content = ob_get_clean();
$registerContent = 'My account';
$registerStatus = 'active';
include_once 'app/views/client/layout.php';
