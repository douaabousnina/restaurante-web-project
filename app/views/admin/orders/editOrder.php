<?php
$title = "Edit order";
ob_start();
?>
<br>
<a class="link link-warning" href="index.php?adminAction=orders">
  <span class="material-symbols-outlined">
    arrow_back
  </span>
  Go Back
</a>
<div>&nbsp;</div>


<div class="row justify-content-center">
    <form method="post" action="index.php?adminAction=updateOrder&order_id=<?= $order['order_id'] ?>" class="col-9">

        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="order_id" value="<?= $order['order_id'] ?>" readonly>
            <label for="order_id">Order ID</label>
        </div>

        <div class="form-floating mb-3">
            <input type="date" class="form-control" name="order_date" value="<?= $order['order_date'] ?>" min="<?= $order['order_date'] ?>" max="<?=date('Y-m-d')?>">
            <label for="order_date">Order date</label>
        </div>

        <select class="form-select mb-3" name="order_status">
            <option selected disabled>Order status</option>
            <option value="Cancelled" <?= $order['order_status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
            <option value="Shipping" <?= $order['order_status'] === 'Shipping' ? 'selected' : '' ?>>Shipping</option>
            <option value="Completed" <?= $order['order_status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
        </select>

        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="meal_id" value="<?= $order['meal_id'] ?>" readonly>
            <label for="meal_id">Meal ID</label>
        </div>

        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="user_id" value="<?= $order['user_id'] ?>" readonly>
            <label for="user_id">User ID</label>
        </div>

        <div class="row justify-content-end">
            <button type="submit" class="btn btn-success col-2 mb-3">Edit order</button>
        </div>

    </form>
</div>

<p class="alert alert-warning">
    <strong>PS:</strong> I think elli this is useless.
</p>

<?php
$content = ob_get_clean();
include_once 'app/views/admin/layoutAdmin.php';
?>
