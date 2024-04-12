<?php
$title = "Home";
ob_start(); ?>

<br>

<div class="container-sm">

    <?= $welcomeMessage ?>

    <?= $message ?>
    <?= $error ?>

    <div class="jumbotron">
        <h1 class="display-4">Craving a delicious meal?</h1>
        <p class="lead">You came to the right place 🫡</p>
        <hr class="my-4">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="index.php?action=meals" role="button">Order now!</a>
        </p>
    </div>


    <div class="container">
        <h3>Check out our best <span class="badge badge-danger">DEALS</span> !</h3>
        <div class="row">
            <?php $counter = 0;
            foreach ($meals as $meal) :
                if ($counter >= 3) break; ?>
                <div class="col">
                    <div class="card">
                        <a href="index.php?action=meal&meal_id=<?= $meal['meal_id'] ?>" class="card-link" style="text-decoration: none; color: inherit;">
                            <img class="card-img-top" src="<?= $meal['meal_image_url'] ?>">
                            <div class="card-body">
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
    <?php
                $counter++;
            endforeach; ?>
    </div>
</div>





</div>

<?php
$content = ob_get_clean();
$homeStatus = 'active';
include_once 'layout.php';
