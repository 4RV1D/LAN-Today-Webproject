<?php

  // Check if user is logged in if not redirect to home page.
  if (!$User->isLoggedIn($_SESSION['logged-in'])) {
    header("Location: /?home");
  }

  if ($User->allInfo($_SESSION['logged-in']) == false) {
    header("Location: /?home");
  } else {
    $userInfo = $User->allInfo($_SESSION['logged-in']);
  }

  if (isset($_POST['submit'])) {

    $check = getimagesize($_FILES['imageUpload']['tmp_name']);

    if($check !== false) {
      $User->imgur($_FILES['imageUpload'], $_SESSION['logged-in']);
    } else {
      echo "Du måste ladda up en bild (.jpg, .png, .gif)";
    }

  }

?>

<div id="user">
  <div class="wrapper">
    <a href="/?home" class="close">Stäng <i class="fa fa-times" aria-hidden="true"></i></a>

    <div id="profil">
      <div class="profil-information">

        <?php if ($User->avatar($_SESSION['logged-in']) == null): ?>
          <form action="/?user" method="POST" enctype="multipart/form-data">
            <div class="avatar" id="avatar" ></div>
            <label class="upload" for="image-file"><strong>Välj Profilbild</strong></label>
            <input type="file" name="imageUpload" id="image-file"/>
            <button type="submit" name="submit" class="submit">Ladda up</button>
          </form>

        <?php else: ?>
          <form action="/?user" method="POST" enctype="multipart/form-data">
            <div class="avatar" id="avatar" style="background: url(<?php echo $User->avatar($_SESSION['logged-in']); ?>); background-size: cover; background-position: center;" ></div>
            <label class="upload" for="image-file"><strong>Välj Profilbild</strong></label>
            <input type="file" name="imageUpload" id="image-file"/>
            <button type="submit" name="submit" class="submit">Ladda up</button>
          </form>

      	<?php endif; ?>

        <div class="info">
          <ul>
            <li><span class="blue"><h2><?php echo $userInfo["username"] ?></h2></span></li>
            <li><strong>Namn:</strong> <?php echo $userInfo["firstname"] ?> <?php echo $userInfo["lastname"] ?></li>
            <li><strong>Email:</strong> <?php echo $userInfo["email"] ?></li>
            <li><strong>LAN Plats:</strong> Har inte bokat plats</li>
            <li><strong>Turneringar:</strong> Inte anmäld till någon turnering</li>
          </ul>
        </div>
      </div>

      <div class="events">
        <h1>Händelser</h1>
        <p>Det finns tyvärr inga händelser just nu<br>
        Vi planerar att ha ett LAN i påsk</p>
      </div>
    </div>
  </div>
</div>
