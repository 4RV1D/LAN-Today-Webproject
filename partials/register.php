<?php

  include "app/autoload.php";

  if (isset($_POST['register'])) {

    $date = date("Y-m-d");
    $registerData = array(
      'firstname'   => $_POST['firstname'],
      'lastname'    => $_POST['lastname'],
      'username'    => $_POST['username'],
      'password1'   => $_POST['password1'],
      'password2'   => $_POST['password2'],
      'email'       => $_POST['email'],
      'phone'       => $_POST['phone'],
      'gender'      => $_POST['gender'],
      'ssn'         => $_POST['ssn'],
      'address'     => $_POST['address'],
      'city'        => $_POST['city'],
      'zip_code'    => $_POST['zip_code']
    );

    // Call the Register class
    $Register = new Register();

    // Check the userinformation
    if (!$Register->formCheck($registerData)) {           // Have the user entered all fields?
      if (!$Register->passwordCheck($registerData)) {     // Are the passwords equals?
        if (!$Register->alreadyCreated($registerData)) {  // Is the user already created?

          // Registering member on sverok
          if (!$Register->sverok($registerData, $date)) {

            // Create the member in the mysql database
            if ($Register->createMember($registerData, $date)) {
              $Register->autoLogin($registerData);
            }
          }
        }
      }
    }
  }

?>

<div id="register">
  <div id="main">
    <div class="wrapper">
      <a href="/?home" class="close">Stäng <i class="fa fa-times" aria-hidden="true"></i></a>
      <div id="register-form">
        <form class="form" action="/?register" method="post">
          <br>
          <h1>Registrera dig här</h1>
          <br>
          <?php if (isset($_POST['register']) && $Register->formCheck($registerData)): ?>
            <h3 class="error">Du måste fylla i alla fält.</h3><br/>

          <?php else: ?>
            <?php if (isset($_POST['register']) && $Register->passwordCheck($registerData)): ?>
              <h3 class="error">Dina lösenord matchar inte.</h3>

            <?php else: ?>
              <?php if (isset($_POST['register']) && $Register->alreadyCreated($registerData)): ?>
                <h3 class="error">Ditt användarnamn används redan.</h3>

              <?php else: ?>
                <?php if (isset($_POST['register']) && $Register->sverok($registerData, $date)): ?>
                  <h3 class="error"><?php echo $Register->sverok($registerData, $date); ?></h3>
                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>

          <div class="data">
            <div class="field-section">
              <h3>Användar Information</h3>
                <i class="fa fa-user" aria-hidden="true"></i><input class="field" type="text" name="username" placeholder="Användarnamn">
                <i class="fa fa-envelope" aria-hidden="true"></i><input class="field" type="email" name="email" placeholder="Email Address"><br/><br/>
                <i class="fa fa-lock" aria-hidden="true"></i><input class="field" type="password" name="password1" placeholder="Lösenord">
                <i class="fa fa-lock" aria-hidden="true"></i><input class="field" type="password" name="password2" placeholder="Bekräfta Lösenord">
            </div>
            <div class="field-section">
              <h3>Person Information</h3>
                <i class="fa fa-user" aria-hidden="true"></i><input class="field" type="text" name="firstname" placeholder="Förstanamn">
                <i class="fa fa-user" aria-hidden="true"></i><input class="field" type="text" name="lastname" placeholder="Andranamn"><br/><br/>
                <i class="fa fa-phone" aria-hidden="true"></i><input class="field" type="tel" name="phone" placeholder="Telefonnummer">
                <i class="fa fa-id-card" aria-hidden="true"></i><input class="field" type="text" name="ssn" placeholder="Personnummer (åååå-mm-dd-xxxx)"><br/>

                <i class="fa fa-male" aria-hidden="true"></i><i class="fa fa-female" aria-hidden="true"></i>
                <select class="field" name="gender">
                  <option value="0" selected>Male</option>
                  <option value="1">Female</option>
                </select>
            </div>
            <div class="field-section">
              <h3>Lokalisering</h3>
              <i class="fa fa-location-arrow" aria-hidden="true"></i><input class="field" type="text" name="address" placeholder="Address">
              <i class="fa fa-location-arrow" aria-hidden="true"></i><input class="field" type="text" name="city" placeholder="Stad"><br/><br/>
              <i class="fa fa-map-marker" aria-hidden="true"></i><input class="field" type="text" name="zip_code" placeholder="Postnummer">
            </div>
          </div>

          <input class="button" type="submit" name="register" value="Registrera Dig!">
        </form>
      </div>
    </div>
  </div>
</div>
