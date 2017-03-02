<?php

  @session_start();
  include "app/autoload.php";

  $User = new User();

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>

  <title>LAN Today</title>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LAN Today en FÃ¶rening fÃ¶r LAN och E-sport event">
  <meta name="keywords" content="LAN,Today,LAN Today, E-sport">

  <meta property="og:title" content="LAN.Today">
  <meta property="og:image" content="assets/img/og-content-img.png">
  <meta property="og:description" content="LAN Today en FÃ¶rening fÃ¶r LAN och E-sport event">

  <link rel="stylesheet" href="assets/css/normalize.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <script src="assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

</head>
  <body>
    <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

  <?php

    if (isset($_SERVER['REQUEST_URI'])) {

      if ($_SERVER['REQUEST_URI'] == "/?login")
      {include __DIR__."/partials/login.php";}

      elseif ($_SERVER['REQUEST_URI'] == "/?register")
      {include __DIR__."/partials/register.php";}

      elseif ($_SERVER['REQUEST_URI'] == "/?user")
      {include __DIR__."/partials/user.php";}

      elseif ($_SERVER['REQUEST_URI'] == "/?reserve")
      {include __DIR__."/partials/reservation.php";}

      else {

  ?>

    <header>
      <div id="nav">
        <div class="wrapper">
          <a href="#header-main"><h1>LAN<span class="blue">TODAY</span></h1></a>
          <ul class="menu">
            <a href="#about"><li>Vad vi gör</li></a>
            <a href="#about-lan"><li>Våra LAN</li></a>
            <a href="#team"><li>Vårat Team</li></a>
            <a href="#sponsors"><li>Sponsorer</li></a>
            <?php if (isset($_SESSION['logged-in']) && $User->isLoggedIn($_SESSION['logged-in'])): ?>
              <a href="/?user"><li><strong><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $User->username($_SESSION['logged-in']); ?></li></strong></a>
              <?php if ($User->isAdmin($_SESSION['logged-in'])): ?>
                <a href="/admin/"><li><strong><i class="fa fa-lock" aria-hidden="true"></i> Admin</strong></li></a>
              <?php endif; ?>
              <a href="logout.php"><li><i class="fa fa-sign-out" aria-hidden="true"></i> logout</li></a>

            <?php else: ?>
              <a href="/?register"><li>Registrera dig</li></a>
              <a href="/?login"><li>Logga in <i class="fa fa-sign-in" aria-hidden="true"></i></li></a>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <div id="header-main">
        <div class="wrapper">
          <div class="align"></div>
          <div class="logo">
            <img src="assets/img/logo2.png" class="logo" alt="LAN Today Logo" />
          </div>
          <h2>En förening för dig som <br/> gillar LAN, Gaming & E-sport</h2>
          <br>
          <?php if (!isset($_SESSION['logged-in'])): ?>
            <a href="/?register" class="button"><i class="fa fa-id-card" aria-hidden="true" style="font-size: 32px; vertical-align: middle; margin-right: 10px;"></i>BLI MEDLEM NU!</a>
          <?php elseif (isset($_SESSION['logged-in'])): ?>
            <a href="/?user" class="button"><i class="fa fa-id-card" aria-hidden="true" style="font-size: 32px; vertical-align: middle; margin-right: 10px;"></i>GÅ TILL DIN PROFIL</a>
          <?php endif; ?>
        </div>
      </div>
    </header>

    <main id="about">
      <div class="wrapper">
        <div class="content-row">
          <img src="assets/img/vad-vi-gör.png" alt="">
          <article>
            <h1>Vad vi gör?</h1>
            <p>Techlan är en förening som drivs huvudsakligen av 10 st spelintresserade grabbar på 16-18 år. Techlan grundades i oktober 2016 av Hampus Precenth och Linus Olander i hopp om att bli en förening som vem som helst kan gå med i som är intresserad av E Sport, spel och LAN.</p>
          </article>
        </div>
      </div>
    </main>

    <main id="about-lan">
      <div class="wrapper">
        <div class="content-column">
          <article>
            <h1>Våra Lan</h1>
            <p>Vi kommer att anordna minst 2 Lan per år och de kommer att innehålla en massvis med aktiviteter och turneringar och självklart massa fina priser! Våra Lan är Drog och Alkoholfria! Under Lanets gång kommer som sagt turneringar huvudsakligen i Counter-Strike Global Offensive och i League of Legends hållas.</p>
          </article>

          <div class="youtube-container">
            <iframe
              src="https://www.youtube.com/embed/5dMVcVJzOSs?autoplay=0&showinfo=0&controls=0"
              frameborder="0"
              class="youtube">
            </iframe>
          </div>

          <div class="lan-gallery">
            <img src="assets/img/lan-pictures/7.jpg" alt="">
            <img src="assets/img/lan-pictures/3.jpg" alt="">
          </div>

          <br><br><br>
        </div>

      </div>
    </main>
    <main id="team">
      <div class="wrapper">
        <div class="content-column">
          <article>
            <h1>Vårat Team</h1>
            <p>Techlan är en förening som drivs huvudsakligen av 10 st spelintresserade grabbar på 16-18 år. Techlan grundades i oktober 2016 av Hampus Precenth och Linus Olander. Alla i vårt team studerar på gymnasiet och har olika erfarenheter av både Lan och E-Sport världen sen tidigare. Vi tillsammans har anordnat 2 Lan med ca 70 sittplatser och fler lan blir det!</p>
          </article>
          <div class="team-gallery">
            <div class="person">
              <img src="assets/img/team-pictures/hampus.png" alt="Hampus">
              <div class="info">
                <h4>Hampus Précenth</h4><br>
                <h5>Heppe</h5>
                <p>Ordförande</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/linus.png" alt="Linus">
              <div class="info">
                <h4>Linus Olander</h4><br>
                <h5>Laban</h5>
                <p>Vise Ordförande</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/adam.png" alt="">
              <div class="info">
                <h4>Adam Bohman</h4><br>
                <h5>Whiibie</h5>
                <p>Sekreterare</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/arvid.png" alt="Arvid">
              <div class="info">
                <h4>Arvid Gullqvist</h4><br>
                <h5>4RV1D</h5>
                <p>Webbutvecklare</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/johan.png" alt="Johan">
              <div class="info">
                <h4>Johan Viberg</h4><br>
                <h5>Yohi</h5>
                <p>Designer</p>
              </div>
            </div>
          </div>
          <div class="team-gallery">
            <div class="person">
              <img src="assets/img/team-pictures/lucas.png" alt="">
              <div class="info">
                <h4>Lucas Weber</h4><br>
                <h5>ZNAjBREE</h5>
                <p>Caster</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/bremer.png" alt="">
              <div class="info">
                <h4>Adam Bremer</h4><br>
                <h5>Abyssalis </h5>
                <p>Caster</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/niklas.png" alt="">
              <div class="info">
                <h4>Niklas Lindholm</h4><br>
                <h5>Nicke</h5>
                <p>Eventmanager</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/oskar.png" alt="">
              <div class="info">
                <h4>Oskar Åkesson</h4><br>
                <h5>Osquak</h5>
                <p>Event CREW</p>
              </div>
            </div>
            <div class="person">
              <img src="assets/img/team-pictures/gabriel.png" alt="">
              <div class="info">
                <h4>Gabriel Abdulahad</h4><br>
                <h5>crab</h5>
                <p>Event CREW</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <main id="sponsors">
      <div class="wrapper">
        <div class="content-column">
          <article>
            <h1>Sponsorer</h1>
            <p>För att vårt Lan ska bli ännu bättre och ännu större har vi några Sponsorer som hjälper oss men Lanet. De här sponsorerna kan ni kika in om ni klickar på deras logga här nedan. Om du har ett företag, en förening eller som privatperson vill sponsra vårt lan är det bara att höra av sig till oss via Facebook eller via våran mail som du hittar under kontakt.</p>
          </article>
          <div class="sponsors">
            <img src="assets/img/sponsors/strafe-white.svg" alt="Strafe">
            <img src="assets/img/sponsors/black-ant.png" alt="Black Ant">
            <img src="assets/img/sponsors/publiclir.png" alt="">
          </div>
        </div>
      </div>
    </main>

    <?php
      }}
    ?>

    <footer>

      <div class="sverok-img">
        <img src="assets/img/sverok.png" alt="">
      </div>

      <div class="wrapper">
        <div class="content">
          <h3>Kontakta Oss</h3>
          <p><strong>Email address</strong></p>
          <a href="">techlaninfo@gmail.com</a>
          <p><strong>Telefon</strong></p>
          <a href="">070 1337 11 97</a>
        </div>
        <div class="content">
          <h3>Social Media</h3>
          <a href="https://www.facebook.com/LAN-Today-105268206648797/" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i>Facebook</a><br/>
          <a href="https://www.youtube.com/channel/UCd1RRsHr97iOIlTikrQZnTA" class="youtube"><i class="fa fa-youtube" aria-hidden="true"></i>Youtube</a><br/>
          <a href="https://discord.gg/dEkYTtM" class="discord"><i class="fa fa-comments" aria-hidden="true"></i></i>Discord</a>
        </div>
        <div class="content">
          <h3>Sverok</h3><br/>
          <a href="#">Sveroks hemsida</a><br/>
        </div>
        <div class="content">
          <h3>Annat</h3><br>
          <a href="#">Person uppgifter (PUL)</a><br/><br/>
          <a href="#">Copyright ©</a>
        </div>
      </div>

      <hr>

      <div class="web-info">
        <p><strong>Webb Utvecklare</strong> - <i>Arvid Gullqvist</i>
        | <strong>Copyright ©</strong> Techlan <i>(2016 - 2017)</i></p>
      </div>
    </footer>

    <script src="https://use.fontawesome.com/febb14cc2a.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="assets/js/main.js"></script>

  </body>
</html>
