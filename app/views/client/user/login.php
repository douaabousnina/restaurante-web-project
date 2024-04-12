<?php
$title = "Login";
ob_start(); ?>

<div class="container">

    <h3>Weclome back!</h3>
    <br>
    <form method="post" action="index.php?action=verifyLogin">

        <div class="form-group ">
            <label for="user_login">Username</label>
            <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input type="text" class="form-control" name="user_login" placeholder="Username" required>
            </div>
        </div>
        <div class="form-group ">
            <label for="user_password">Password</label>
            <input type="password" class="form-control" name="user_password" placeholder="Password">
        </div>

        <div class="row">
            <div class="col-9">
                <a href="index.php?action=register">Are you new here? Join us!</a>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-success" name='login-btn'>Login</button>
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
