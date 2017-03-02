<?php

/**
 *
 */
class User
{

  function username($loginSession) {

    // MySQL
    include __DIR__."/../mysql.php";

    // Connect to the Database to check if the login session exists.
    $sql = "SELECT id, username FROM users WHERE id='$loginSession'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          return $row["username"];
      }
    }

  }

  function avatar($loginSession) {

    // MySQL
    include __DIR__."/../mysql.php";

    // Connect to the Database to check if the login session exists.
    $sql = "SELECT id, avatar FROM users WHERE id='$loginSession'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          return $row["avatar"];
      }
    }

  }

  function name($loginSession) {

  }

  function allInfo($loginSession) {
    // MySQL
    include __DIR__."/../mysql.php";

    // Connect to the Database to check if the login session exists.
    $sql = "SELECT id, firstname, lastname, username, email, gender FROM users WHERE id='$loginSession'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          return $row;
      }
    } else {
      return false;
    }
  }

  function isLoggedIn($loginSession) {

    if (isset($_SESSION['logged-in'])) {
      return true;
    } else {
      return false;
    }

  }

  // Imgur Uploading
  function imgur($img, $loginSession) {

    $filename = $img['tmp_name'];
    $client_id = "1f8efdcdde18b9c";
    $handle = fopen($filename, "r");
    $data = fread($handle, filesize($filename));
    $pvars   = array('image' => base64_encode($data));
    $timeout = 30;

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $out = curl_exec($curl);

    curl_close($curl);
    $pms = json_decode($out, true);
    $url = $pms['data']['link'];

    if ($url = "") {
      header("Location: /?user");
      die();
    } else {

      $link = $pms['data']['link'];

      //MySQL
      include __DIR__."/../mysql.php";

      //Insert avatar link into database
      $sql = "UPDATE users SET avatar='$link' WHERE id='$loginSession'";

      if ($conn->query($sql) === TRUE) {
          return $link;
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

    }
  }

  function isAdmin($loginSession) {

    //MySQL
    include __DIR__."/../mysql.php";

    //Insert avatar link into database
    $sql = "SELECT id, admin FROM users WHERE id='$loginSession'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if ($row["admin"] == true) {
          return true;
        }
      }
    } else {
      return false;
    }

  }

}
