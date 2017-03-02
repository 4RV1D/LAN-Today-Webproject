<?php

@session_start();

/**
 *
 */
class Login
{

  function loginUser($loginData) {

    // MySQL
    include __DIR__."/../mysql.php";

    $username = htmlspecialchars($loginData["username"],   ENT_QUOTES, 'UTF-8');

    // Connect to the Database to get the User ID, Username and Password
    $sql = "SELECT id, username, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        if (password_verify($loginData['password'], $row["password"])) {
          $_SESSION['logged-in'] = $row["id"];
          return true; // the username and password is correct login user.
        }

      }
    } else {
      return false; // The username doesn't exist
    }
  }

  // Form check
  function formCheck($loginData) {
    if (in_array("", $loginData)) {
      return true; // the user didn't enter all the fields
    } else {
      return false; // the user did enter all the fields
    }
  }

}
