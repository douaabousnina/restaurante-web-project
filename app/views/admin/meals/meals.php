<?php
$title = "Meals 😋";
$options = '<option selected>Sort by</option>
            <option value="meal_id">ID</option>
            <option value="meal_name">Name</option>
            <option value="meal_price">Price</option>';
ob_start();
?>

<div class="row justify-content-center">
    <a href="index.php?adminAction=addMeal" class="btn btn-info col-1">Add meal</a>
</div>
<br>
<div class="row justify-content-center">

    <div class="col-10">
        <table class="table table-hover table-bordered text-center align-middle" width="50">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meals as $meal) : ?>
                    <tr>
                        <th scope="row"><?= $meal['meal_id'] ?></th>
                        <td class="col-1">
                            <img src="<?= $meal['meal_image_url'] ?>" alt="" class="" width="" height="50">
                        </td>
                        <td><?= $meal['meal_name'] ?></td>
                        <td><?= $meal['meal_price'] ?> &nbsp; TND</td>
                        <td>
                            <a class="link-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top" href="index.php?adminAction=editMeal&meal_id=<?= $meal['meal_id'] ?>">
                                <span class="material-symbols-outlined">
                                    edit
                                </span>
                            </a>
                            <a class="link-danger" href="index.php?adminAction=deleteMeal&meal_id=<?= $meal['meal_id'] ?>">
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