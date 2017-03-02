<?php

/**
 *
 */
class Register
{

  // Form check
  function formCheck($registerData) {
    if (in_array("", $registerData)) {
      return true; // the user didn't enter all the fields
    } else {
      return false; // the user did entar all the fields
    }
  }

  // Password check
  function passwordCheck($registerData) {
    if ($registerData['password1'] != $registerData['password2']) {
      return true; // the user didn't enter the same passwords
    } else {
      return false; // the user did enter the same passwords
    }
  }

  // Sverok register API function
  function sverok($registerData, $date) {
    $api_key = "/IyyqLIZWwsUHVui/jrl+5i92WglCvsk";
    $request = array(
        "api_key" => $api_key,
        "member" => array(
            "firstname"             => $registerData['firstname'],
            "lastname"              => $registerData['lastname'],
            "renewed"               => $date,
            "gender_id"             => $registerData['gender'],
            "co"                    => [],
            "socialsecuritynumber"  => $registerData['ssn'],
            "email"                 => $registerData['email'],
            "phone1"                => $registerData['phone'],
            "phone2"                => [],
            "street"                => $registerData['address'],
            "zip_code"              => $registerData['zip_code'],
            "city"                  => $registerData['city']
    ));

    $data_string = json_encode($request);

    $url = "https://ebas.sverok.se/apis/submit_member.json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($ch);
    curl_close($ch);

    $content  = utf8_encode($result);
    $obj      = json_decode($content);

    if (empty($error = $obj->{'member_warnings'})){
      return false;
    } else {

      $ssn_error = $error->socialsecuritynumber;
      if (!empty($ssn_error[0])) {
        return $ssn_error[0];
      } else {

        $success = $obj->{'request_result'};
        if ($success != "fail") {
          return true;
        } else {
          return false;
        }
      }
    }
  }

  // Create the member in mysql
  function alreadyCreated($registerData) {

    // MySQL
    include __DIR__."/../mysql.php";

    // Check if the user already exists
    $username = $registerData['username'];
    $sql = "SELECT username FROM users WHERE username = '$username'";

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }

  }

  function createMember($registerData, $date) {

    // MySQL
    include __DIR__."/../mysql.php";

    //Encrypt the Username and Names so they can't do XSS exploits and troll things.
    $firstname = htmlspecialchars($registerData['firstname'],  ENT_QUOTES, 'UTF-8');
    $lastname  = htmlspecialchars($registerData['lastname'],   ENT_QUOTES, 'UTF-8');
    $username  = htmlspecialchars($registerData['username'],   ENT_QUOTES, 'UTF-8');
    $email     = htmlspecialchars($registerData['email'],      ENT_QUOTES, 'UTF-8');
    $phone     = htmlspecialchars($registerData['phone'],      ENT_QUOTES, 'UTF-8');
    $ssn       = htmlspecialchars($registerData['ssn'],        ENT_QUOTES, 'UTF-8');
    $address   = htmlspecialchars($registerData['address'],    ENT_QUOTES, 'UTF-8');
    $city      = htmlspecialchars($registerData['city'],       ENT_QUOTES, 'UTF-8');
    $zip_code  = htmlspecialchars($registerData['zip_code'],   ENT_QUOTES, 'UTF-8');
    $gender    = $registerData['gender'];

    // Encrypt the password
    $options = ['cost' => 12,];
    $password = password_hash($registerData['password1'], PASSWORD_BCRYPT, $options);

    //Insert Register Data into database Users
    $sql = "INSERT INTO users (firstname, lastname, username, password, email, phone, gender, ssn, address, city, zip_code, modified)
            VALUES ('$firstname', '$lastname', '$username', '$password', '$email', '$phone', '$gender', '$ssn', '$address', '$city', '$zip_code', '$date')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

  }

  function autoLogin($registerData) {

    // MySQL
    include __DIR__."/../mysql.php";

    $username  = htmlspecialchars($registerData['username'],   ENT_QUOTES, 'UTF-8');

    // Connect to the Database to get the User ID, Username and Password
    $sql = "SELECT id, username, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        if (password_verify($registerData['password1'], $row["password"])) {
          $_SESSION['logged-in'] = $row["id"];
          header("Location: /?home");
        }

      }
    }

  }

}
