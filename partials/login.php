<?php

  if (isset($_POST['login'])) {

  $loginData = array(
    'username'    => $_POST['username'],
    'password'   => $_POST['password']
  );

  // Call the Login class
  $Login = new Login();

  // Have the user entered all fields?
  if (!$Login->formCheck($loginData)) {

      // Login the user to the requested account.
      if ($Login->loginUser($loginData)) {
          header("Location: /?home");
      }

    }
  }

?>

  <div id="login">
    <div class="wrapper">
      <a href="/?home" class="close">Stäng <i class="fa fa-times" aria-hidden="true"></i></a>
      <div id="login-form">
        <form class="form" action="/?login" method="post">

          <br>
          <h1>Logga in</h1>
          <br>

          <?php if (isset($_POST['login'])): ?>
            <?php if ($Login->formCheck($loginData)): ?>
              <h3 class="error">Du måste fylla i alla fält.</h3><br/>

            <?php elseif (!$Login->loginUser($loginData)): ?>
              <h3 class="error">Fel användarnamn eller lösenord.</h3><br/>

            <?php endif; ?>
          <?php endif; ?>

          <div class="data">
            <div class="field-section">
              <h3>Användarnamn</h3>
                <i class="fa fa-user" aria-hidden="true"></i><input class="field" type="text" name="username" placeholder="användarnamn">
            </div>
            <div class="field-section">
              <h3>Lösenord</h3>
                <i class="fa fa-lock" aria-hidden="true"></i><input class="field" type="password" name="password" placeholder="lösenord">
            </div>
          </div>

          <input class="button" type="submit" name="login" value="Logga in">
        </form>
      </div>
    </div>
  </div>
</div>
