<?php

  @session_start();
  include "../app/autoload.php";

  $User = new User();
  $Admin = new Admin();

  if (!isset($_SESSION['logged-in'])) {
    header("Location: /?home");
  } elseif (!$User->isAdmin($_SESSION['logged-in'])) {
    header("Location: /?home");
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Admin Panel</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LAN Today en FÃ¶rening fÃ¶r LAN och E-sport event">
    <meta name="keywords" content="LAN,Today,LAN Today, E-sport">

    <meta property="og:title" content="LAN.Today">
    <meta property="og:image" content="../assets/img/og-content-img.png">
    <meta property="og:description" content="LAN Today en FÃ¶rening fÃ¶r LAN och E-sport event">

    <link rel="stylesheet" href="../assets/css/normalize.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <script src="../assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

  </head>
  <body>

      <div id="nav">
        <div class="wrapper">
          <ul class="menu">
            <a href="?page=home"><li>Home</li></a>
            <a href="?page=users"><li>Users</li></a>
            <a href="?page=events"><li>Events</li></a>
            <a href="?page=news"><li>News</li></a>
          </ul>
        </div>
      </div>

      <div id="admin-main">
        <?php
          if (!isset($_GET["page"]) || isset($_GET["page"]) && $_GET["page"] == "home") {
            include "home.php";
          } elseif (isset($_GET["page"]) && $_GET["page"] == "users") {
            include "users.php";
          }
        ?>
      </div>

    <script src="https://use.fontawesome.com/febb14cc2a.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="../assets/js/main.js"></script>

  </body>
</html>
