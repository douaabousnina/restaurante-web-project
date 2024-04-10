<?php
$title = "ERROR 404";
ob_start(); ?>
<div class="container">
    <br><br><br>
    <h1>
        SORRY, WRONG URL. :)
    </h1>
    <h2 class="center">ERROR 404</h2>
    <br><br><br>
</div>


<?php
$content = ob_get_clean();
include_once 'app/views/client/layout.php';
