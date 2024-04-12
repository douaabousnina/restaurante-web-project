<?php
$title = "ERROR 404";
ob_start(); ?>
<div class="container">
    <br><br><br>
    <h1>
        SORRY, WRONG URL. :)
    </h1>
    <br><br><br>
</div>


<?php
$content = ob_get_clean();
include_once 'app/views/admin/layoutAdmin.php';
