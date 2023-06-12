<?php
include_once("pages/classes.php");
// session_start();
// unset($_SESSION['FFFF']);        
// unset($_SESSION["login"]);
// unset($_SESSION["user"]);
// unset($_SESSION["admin"]);
// include ("pages/entry.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="#">SHOP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php include_once("pages/menu.php") ?>
    </div>
  </nav>

  <div class="container py-5">
    <?php
    if (isset($_GET["page"])) {
      $page = $_GET["page"];

      if ($page == 1) include_once("pages/catalog.php");
      if ($page == 2) include_once("pages/cart.php");
      if ($page == 3) include_once("pages/register.php");
      if ($page == 4) include_once("pages/admin.php");
      if ($page == 5) include_once("pages/entry.php");
    }
    ?>
  </div>
</body>

</html>