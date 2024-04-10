<?php
$title = "Add meal";
ob_start();
?>

<br>
<a class="link link-warning" href="index.php?adminAction=meals">
  <span class="material-symbols-outlined">
    arrow_back
  </span>
  Go Back
</a>
<div>&nbsp;</div>

<hr>
<div class="row justify-content-center">
    <form method="post" action="index.php?adminAction=storeMeal" class="col-9">

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="meal_name">
            <label for="meal_name">Meal name</label>
        </div>

        <div class="form-floating mb-3">
            <input type="number" class="form-control" name="meal_price" step="0.001">
            <label for="meal_price">Meal price</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="meal_image_url">
            <label for="meal_image_url">Meal image URL</label>
        </div>


        <div class="row justify-content-end">
            <button type="submit" class="btn btn-success col-2 mb-3">Add meal</button>
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