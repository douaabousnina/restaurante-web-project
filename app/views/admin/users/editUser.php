<?php
$title = "Edit user";
ob_start();
?>
<br>
<a class="link link-warning" href="index.php?adminAction=users">
  <span class="material-symbols-outlined">
    arrow_back
  </span>
  Go Back
</a>
<br>
<div class="row justify-content-center">
    <form method="post" action="index.php?adminAction=updateUser&user_id=<?= $user['user_id'] ?>" class="col-9" >

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="user_surname" value="<?= $user['user_surname'] ?>" >
            <label>Name</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="user_email" value="<?= $user['user_email'] ?>" >
            <label>Email</label>
        </div>

        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="user_age" value="<?= $user['user_age'] ?>" >
            <label>Age</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="user_login" value="<?= $user['user_login'] ?>" >
            <label>Login</label>
        </div>

        <select class="form-select mb-3" name="user_role">
            <option selected disabled>Role</option>
            <option value="user" <?= $user['user_role'] === 0 ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['user_role'] === 1 ? 'selected' : '' ?>>Admin</option>
        </select>

        <div class="row justify-content-end">
            <button type="submit" class="btn btn-success col-2 mb-3">Edit user</button>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
include_once 'app/views/admin/layoutAdmin.php';
?>
