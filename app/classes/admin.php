<?php

/**
 *
 */
class Admin
{

  function pageViews() {

    //MySQL
    include __DIR__."/../mysql.php";

    //Insert avatar link into database
    $sql = "SELECT id, views FROM pageInfo WHERE id='1'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        return $row["views"];
      }
    } else {
      return false;
    }

  }

  function allUserInfo() {
    // MySQL
    include __DIR__."/../mysql.php";

    // Connect to the Database to check if the login session exists.
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
          echo "<td>" . $row["firstname"] . " " . $row["lastname"] . "</td>";
          echo "<td>" . $row["username"] . "</td>";
          echo "<td>" . $row["email"] . "</td>";
          echo "<td>" . $row["seat"] . "</td>";
          echo "<td>" . $row["gender"] . "</td>";
          echo "<td>" . $row["phone"] . "</td>";
          echo "<td>" . $row["city"] . "</td>";
        echo "</tr>";
      }
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

}
