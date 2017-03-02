<?php

/**
 *
 */
class Reservation
{

  function tablesReserved() {

    include __DIR__."/../mysql.php";

  	$sql = "SELECT seat FROM users";
  	$result = $conn->query($sql);

    if ($result->num_rows > 0) {

      $bookedSeats = array();

      while($row = $result->fetch_assoc()) {
        if ($row['seat'] != "0") {
          array_push($bookedSeats, $row['seat']);
        }
      }
    }
    return $bookedSeats;
  }

  function placements($bookedSeats, $seat) {
    if (in_array($seat, $bookedSeats)) {
      return $this->seatUserInfo($seat);
    } else {
      return "<a>" . $seat . "</a>
      <div class='hidden'>
        <form class='bookSeat' action='?reserve' method='post'>
          <input class='gone' type='text' name='seat' value='" . $seat . "'>
          <input class='submit' type='submit' name='reserve' value='Boka " . $seat . "'>
        </form>
      </div>";
    }
  }

  function is_reserved_bool($booked, $seat) {
    if (in_array($seat, $booked)) {
      return true;
    } else {
      return false;
    }
  }

  function seatUserInfo($seat) {

    include __DIR__."/../mysql.php";

  	$sql = "SELECT firstname, lastname, username, avatar, seat FROM users WHERE seat='$seat'";
  	$result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {

        return "<strong><a class='taken'>" . $seat . "</strong></a>
        <div class='hidden'>
          <div class='avatar' style='background: url(" . $row['avatar'] . "); background-size: cover; background-position: center;' ></div>
          <p><strong>" . $row['username'] . "</strong>
          <br/>" . $row['firstname'] . " " . $row['lastname'] . "
          <br/>Counter Strike</p>
        </div>";

      }
    } else {
      return "User not found.";
    }
  }

  function userSeat($id, $seat) {

    include __DIR__."/../mysql.php";

    $sql = "SELECT id, seat FROM users WHERE id='$id'";
  	$result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {

        if ($row['TableNum'] == $seat) {
          return true;
        } else {
          return false;
        }

      }
    } else {
      return "User not found.";
    }
  }

  function reserve($USERid, $seat) {

    include __DIR__."/../mysql.php";

    $sql = "UPDATE users SET TableNum='$seat' WHERE USERid='$USERid'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['reserve-success'] = "<p>Du har bokat plats " . $seat . "</p>";
        header("Location: ?page=boka&plats=" . $seat . "");
    } else {
        echo "Error: Din user finns inte.";
    }
  }

  function cancel($USERid, $seat) {
    include __DIR__."/../mysql.php";

    $sql = "UPDATE users SET TableNum='0' WHERE USERid = '$USERid'";

    if ($conn->query($sql) === TRUE) {
      $_SESSION['cancel-success'] = "<p>Du har avbokat plats" . $seat . "</p>";
      header("Location: ?page=boka&plats=" . $seat . "");
    } else {
      echo "Error: Din plats finns inte!";
    }
  }

}
