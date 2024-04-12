<?php
$title = "Cart";
ob_start(); ?>


<div class="container">
    <h3>Products in your cart:</h3>
    <div class="row">
        <div class="col-8"></div>
        <a href="index.php?action=clearCart" class="btn col-3" data-toggle="tooltip" data-placement="right" title="Clear cart">
            <span class="material-symbols-outlined">
                remove_shopping_cart
            </span>
        </a>
    </div>

    <div class="row">
        <div class="col-8"></div>
        <small class="text-muted col-3 text-center">
            Clear cart
        </small>
    </div>

    <hr>

    <?= $message ?>
    <?= $error ?>


    <?php
    foreach ($cartItems as $cartItem) :
        $meal = $cartItem['meal'];
    ?>

        <div class="row">
            <div class="col-sm">
                <img src="<?= $meal['meal_image_url'] ?>" class="img-fluid">
            </div>
            <div class="col-sm">
                <h2><?= $meal['meal_name'] ?></h2>
                <h5><?= $meal['meal_price'] ?> TND </h5>
            </div>
            <div class="col-sm">
                <form action="index.php?action=setQuantity&meal_id=<?= $meal['meal_id'] ?>" id="addToCartForm" method="post">
                    <input type="number" name="quantity" class="form-control" min="1" value="<?= $cartItem['quantity'] ?>" onchange="submitForm()">
                </form>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-8"></div>
                    <a href="index.php?action=removeFromCart&meal_id=<?= $meal['meal_id'] ?>" class="btn col-3" data-toggle="tooltip" data-placement="right" title="Clear cart">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                    </a>
                </div>

                <div class="row">
                    <div class="col-8"></div>
                    <small class="text-muted col-3 text-center">
                        Delete item
                    </small>
                </div>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>

<?= $cartMessage ?>

    <div class="row">
        <h2 class="col-8">Total</h2>
        <h2 class="col"><?= $total ?></h2>
        <h2 class="col">TND</h2>
    </div>

</div>


<script>
    function submitForm() {
        document.getElementById('addToCartForm').submit();
    }
</script>


<?php
$content = ob_get_clean();
include_once 'app/views/client/layout.php';
