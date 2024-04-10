<?php
$title = "Meals";
ob_start();
// session_start(); 
?>




<div class="container">

    <br>
    <h3>Meals 😋</h3>
    <br>

    <div class="row justify-content-center">
        <?php foreach ($meals as $meal) : ?>
            <div class="col-sm-4 mb-4">
                <div class="card" action="index.php?action=addToCart&meal_id=<?= $meal['meal_id'] ?>">
                    <a href="index.php?action=meal&meal_id=<?= $meal['meal_id'] ?>" class="card-link" style="text-decoration: none; color: inherit;">
                        <img class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" src="<?= $meal['meal_image_url'] ?>">
                        <div class="card-body" style="height:200px;">
                            <h5 class="card-title"><?= $meal['meal_name'] ?></h5>
                            <p class="card-text"><?= $meal['meal_price'] ?> <span class="">TND</span></p>
                            <br>
                    </a>
                    <form method="post" action="index.php?action=addToCart&meal_id=<?= $meal['meal_id'] ?>">
                        <div class="row">
                            <button type="submit" class="col-7 btn btn-success">Add to cart</button>
                            <div class="col-5">
                                <input type="number" name="quantity" class="form-control" value="1" min="1">
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-8"></div>
                        <small class="text-muted col-4">
                            quantity
                        </small>
                    </div>
                </div>
            </div>

    </div>
<?php endforeach; ?>
</div>
</div>



<?php
$content = ob_get_clean();
include_once 'app/views/client/layout.php';
