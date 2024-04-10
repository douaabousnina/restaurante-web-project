<?php
$title = "Users 🙅🏿";
$options = '<option selected>Sort by</option>
            <option value="user_id">ID</option>
            <option value="user_surname">Name</option>
            <option value="user_login">Login</option>
            <option value="user_age">Age</option>
            <option value="user_email">Email</option>
            <option value="user_role">Role</option>';
ob_start();
?>
<div class="row justify-content-center">
    <div class="col-11">
        <table class="table table-hover table-bordered text-center align-middle" width="50">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Age</th>
                    <th scope="col">Login</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <th scope="row" ><?= $user['user_id'] ?></th>
                        <td><?= $user['user_surname'] ?></td>
                        <td><?= $user['user_email'] ?></td>
                        <td><?= $user['user_age'] ?></td>
                        <td><?= $user['user_login'] ?></td>
                        <td><?php echo $user['user_role']==0 ? 'user' : 'admin'; ?></td>
                        <td>
                            <a class="link-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top" href="index.php?adminAction=editUser&user_id=<?= $user['user_id'] ?>">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </a>
                            <a class="link-danger" href="index.php?adminAction=deleteUser&user_id=<?= $user['user_id'] ?>">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>

                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
include_once 'app/views/admin/layoutAdmin.php';
?>