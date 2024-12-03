<?php
defined('APP') or die();

$logged = !empty($_SESSION['user']); 
?>
<!doctype html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DB Nations</title>
    <link href="template/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/icons/bootstrap-icons.min.css" rel="stylesheet">
    <link href="template/stile.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid">
      <header>
        <h1 class="text-center">DB Nations</h1>
      </header>
      <main class="row">
        <nav class="col-2  p-2 ">
          <h1>Menu</h1>
          <?php if($logged) { ?>
            <p>Welcome <b><?= $_SESSION['user']['name'] ?></b></p>
          <?php } ?>
          <ul class="nav nav-pills nav-fill flex-column">
            <li class="nav-item">
              <a class="nav-link" href="?">
                <span class="bi-house"></span> Home
              </a>
            </li>
            <li class="nav-item">
              <?php if (!$logged) { ?> 
                <a class="nav-link" href="?option=login">
                  <span class="bi-lock"></span> Login
                </a>
              <?php } else { ?>
                <a class="nav-link" href="?option=login&task=logout">Logout</a>
              <?php } ?>
            </li>
            <?php if(grant("listContinents")) { ?><li class="nav-item"><a class="nav-link" href="?option=listContinents">List continents</a></li><?php } ?>
            <li class="nav-item"><a class="nav-link" href="?option=Continents">Continents</a></li>
            <li class="nav-item"><a class="nav-link" href="?option=CountriesFlags">Countries & Flags</a></li>
            <li class="nav-item"><a class="nav-link" href="?option=CountriesFlags&task=CountriesJS">Countries JS</a></li>
          </ul>
        </nav>
        <section class="col-10 p-2">
          <?php
           
            include("components/{$this->option}/View{$this->view}.php");
          
          ?>
        </section>
      </main>
    </div>
    <script src="template/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>