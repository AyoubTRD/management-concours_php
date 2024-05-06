<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/components/header_init.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $titre_document; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/public/skeleton/normalize.css">
  <link rel="stylesheet" href="/public/skeleton/skeleton.css">
  <link rel="stylesheet" href="/public/main.css">
</head>
<body>

<header class="container flex items-center">
  <div class="row u-full-width flex items-center">
    <h4 class="eight columns"><?php echo $titre_header; ?></h4>

    <div class="four columns">
      <nav>
        <ul>
        <?php if (!$est_authentifie) {
            echo "<li><a href='/inscription.php'>Inscription</a></li>
        <li><a href='/authentication.php'>Authentication</a></li>";
        } else {
            if ($est_admin) {
                echo "<li><a href='/administration.php'>Administration</a></li>";
            }
            echo "<li><a href='/deconnexion.php'>Deconnexion</a></li>";
        } ?>
        </ul>
      </nav>
    </div>
  </div>
</header>

<hr style="margin-top: 0">
<main class="container">
