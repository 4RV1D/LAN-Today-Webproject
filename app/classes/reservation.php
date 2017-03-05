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

  	$sql = "SELECT firstname, lastname, username, avatar, seat, game, steam FROM users WHERE seat='$seat'";
  	$result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {

        if ($row['game'] != "") {
          $game = $row['game'];
        } else {
          $game = "Har inget favorit spel";
        }

        if ($row['steam'] != "") {
          $steam = "<br/><a href='http://steamcommunity.com/id/" . $row['steam'] . "' target='_blank'>Steam account</a>";
        } else {
          $steam = "<br/>Inget steam account";
        }

        return "<strong><a class='taken'>" . $seat . "</strong></a>
        <div class='hidden'>
          <div class='avatar' style='background: url(" . $row['avatar'] . "); background-size: cover; background-position: center;' ></div>
          <p><strong>" . $row['username'] . "</strong>
          <br/>" . $row['firstname'] . " " . $row['lastname'] . "
          <br/>" . $game . "
          " . $steam . "</p>
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

  function reserveSeat($id, $seat, $favGame, $steamID) {

    include __DIR__."/../mysql.php";

    $sql = "UPDATE users SET seat='$seat', steam='$steamID', game='$favGame' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "Error! Det gick inte att boka.";
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
