<?php
defined('APP') or die();

$logged = !empty($_SESSION['user']); 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DB Nations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
  </head>
  <body>
    <div class="container">
      <header>
        <h1 class="text-center">DB Nations</h1>
      </header>
      <main class="row">
        <nav class="col-2  p-2">
          <h1>Menu</h1>
          <?php if($logged) { ?>
            <p>Welcome <b><?= $_SESSION['user']['name'] ?></b>
          <?php } ?>
          <ul>
            <li>
              <?php if (!$logged) { ?> 
                <a href="?task=login">Login</a>
              <?php } else { ?>
                <a href="?task=logout">Logout</a>
              <?php } ?>
            </li>
            <li><a href="?option=Continents">Continents</a></li>
            <li><a href="?option=Countries">Countries</a></li>
            <li><a href="?option=Countries&task=defaultjs">Countries JS</a></li>
          </ul>
        </nav>
        <section class="col-10 p-2">
          <?php
          include("views/{$this->view}.php");
          ?>
        </section>
      </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>