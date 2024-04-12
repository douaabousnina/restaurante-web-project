<?php
$title = "Admin panel";


ob_start();
?>

<div class="container">
    <div class="alert alert-primary">
        Welcome, do3! 🥰
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <p>&nbsp;</p>
            <h4>Recent orders 💰</h4>
            <div class="col-12">
                <table class="table table-hover table-bordered text-center align-middle" width="50">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Meal</th>
                            <th scope="col">User</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        foreach ($orders as $order) :
                            $index++;
                            if ($index == 4) break; ?>
                            <tr>
                                <th scope="row"><?= $order['order_id'] ?></th>
                                <td class="col-1"><?= $order['order_date'] ?></td>
                                <td><?= $order['order_status'] ?></td>
                                <td>
                                    <a class="link-success" href="index.php?adminAction=userProfile&user_id=<?= $order['user_id'] ?>">
                                        View user profile (ID=<?= $order['user_id'] ?>)
                                    </a>
                                </td>
                                <td>
                                    <a class="link-warning" href="index.php?adminAction=mealInfo&meal_id=<?= $order['meal_id'] ?>">
                                        View meal info (ID=<?= $order['meal_id'] ?>)
                                    </a>
                                </td>

                                <td>
                                    <a href="index.php?adminAction=editOrder&order_id=<?= $order['order_id'] ?>" class="link-success">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </a>
                                    <a class="link-danger" href="index.php?adminAction=deleteOrder&order_id=<?= $order['order_id'] ?>">
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

            <a class="btn btn-success col-2 align-self-center" href="index.php?adminAction=orders">Show all orders</a>
            <h6>&nbsp;</h6>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include_once 'app/views/admin/layoutAdmin.php';
?>