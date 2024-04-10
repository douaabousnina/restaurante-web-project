<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Restaurant✨é✨</a>

  <div  id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item <?=$homeStatus?>">
        <a class="nav-link" href="index.php?action=home">Home </a>
      </li>
      <li class="nav-item <?=$mealsStatus?>">
        <a class="nav-link" href="index.php?action=meals">Meals</a>
      </li>
      <li class="nav-item <?=$cartStatus?>">
        <a class="nav-link" href="index.php?action=cart">Cart</a>
      </li>
      
      <li class="nav-item <?=$cartStatus?>">
        <?= $navElement ?>
      </li>
    </ul>
    
  </div>
</nav>