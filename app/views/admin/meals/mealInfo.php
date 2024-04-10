<?php
$title = "Meal info";
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


<table class="table">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">ID</th>
      <td><?= $meal['meal_id'] ?></td>
    </tr>

    <tr>
      <th scope="row">Image</th>
      <td><?= $meal['meal_image_url'] ?></td>
    </tr>

    <tr>
      <th scope="row">Name</th>
      <td><?= $meal['meal_name'] ?></td>
    </tr>

    <tr>
      <th scope="row">Price</th>
      <td><?= $meal['meal_price'] ?></td>
    </tr>
  </tbody>
</table>

<?php
$content = ob_get_clean();
include_once 'app/views/admin/layoutAdmin.php';
?>
