<?php
$title = $meal['meal_name'];
ob_start(); ?>


<div class="container">
    <a href="index.php?action=meals">See other meals</a>
    <hr>
    <div class="row">
        <div class="col-sm">
            <img src="<?= $meal['meal_image_url'] ?>" class="img-thumbnail">
        </div>
        <div class="col-sm">
            <h2><?= $meal['meal_name'] ?></h2>
            <h5> <?= $meal['meal_price'] ?> TND </h5>
            <br>
            <form method="post" action="index.php?action=addToCart&meal_id=<?= $meal['meal_id'] ?>">
                <div class="row">
                    <div class="col"></div>
                    <button type="submit" class="col-5 btn btn-success">Add to cart</button>
                    <div class="col-1"></div>
                    <div class="col-2">
                        <input type="number" name="quantity" class="form-control" value="1">
                        <small class="text-muted">
                            quantity
                        </small>
                    </div>

                    <div class="col"></div>
                </div>
            </form>
        </div>
    </div>
</div>




<?php
$content = ob_get_clean();
include_once 'app/views/client/layout.php';
