<?php

/**
 *
 */
class Page
{

  function pageVisit() {

    //MySQL
    include __DIR__."/../mysql.php";

    //Insert avatar link into database
    $sql = "UPDATE pageInfo SET views='views + 1' WHERE id='1'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

  }
}
