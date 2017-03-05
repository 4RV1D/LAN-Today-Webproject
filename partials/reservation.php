<?php

  if (!$User->isLoggedIn()) {
    header("Location: ?home");
  }

  $Reservation = new Reservation();
  $bookedSeats = $Reservation->tablesReserved();

  require_once 'app/lib/Braintree.php';

  Braintree_Configuration::environment('sandbox');
  Braintree_Configuration::merchantId('q4tt847kjwwt5kzv');
  Braintree_Configuration::publicKey('gnxrbrz6psbvcgzs');
  Braintree_Configuration::privateKey('4a5179b2605047b42157a45d0aa6de1a');

  $braintree_token = Braintree_ClientToken::generate();

  if (isset($_POST["reservedSeat"])) {

    $nonceFromTheClient = $_POST["payment_method_nonce"];

    $result = Braintree_Transaction::sale([
      'amount' => '200.00',
      'paymentMethodNonce' => $nonceFromTheClient,
      'options' => [
        'submitForSettlement' => True
      ]
    ]);

    if ($result->success) {
      // payment successful
      $transaction = $result->transaction;
      $reservedSeat = $_POST["reservedSeat"];
      $favGame = $_POST["favGame"];
      $steamID = $_POST["steamid"];

      if ($Reservation->reserveSeat($_SESSION["logged-in"], $reservedSeat, $favGame, $steamID)) {
        $_SESSION["paymentSuccess"] = "Din bokning gick igenom du har bokat platsen: " . $_POST["reservedSeat"] . ".";
        header("Location: ?reserve");
      }

    } else {
      // payment error
      $result->errors->deepAll();
    }

  } elseif (isset($_POST["pay"]) && !isset($_POST["reservedSeat"])) {
    echo "error!";
  }

?>

<div id="reservation">
  <div class="wrapper">
    <a href="/?home" class="close">Stäng <i class="fa fa-times" aria-hidden="true"></i></a>

    <?php if (isset($_POST["reserve"])): ?>
      <div id="booking">
        <h1>Betalning</h1>
        <br><a href="?reserve"><-- Gå tillbaka till platskarta</a><br>
        <form id="checkout" method="post" action="?reserve">
          <p>Vad kommer ditt favorit spel vara det här lanet?</p>
          <input type="text" class="field" name="favGame" placeholder="Counter Strike">
          <p>Ditt steamID <i>(inte nödvändig)</i></p>
          <input type="text" class="field" name="steamid" placeholder="username">
          <input type="text" class="gone" name="reservedSeat" value="<?php echo $_POST["seat"]; ?>">
          <div id="braintree">
            <div id="payment-form"></div>
            <p>Din plats <?php echo $_POST["seat"]; ?> kostar 200kr</p>
            <input type="submit" name="pay" class="button" value="Boka">
          </div>
        </form>
      </div>

    <?php else: ?>
      <div id="placements">
        <h1>Boka din sittplats</h1>

        <?php if (isset($_SESSION["paymentSuccess"])): ?>
          <br><h3><?php echo $_SESSION["paymentSuccess"]; session_unset($_SESSION["paymentSuccess"]); ?></h3><br>
        <?php endif; ?>

        <?php
          $i = 0; while ($i < 10) {
            echo "<ul class='seats'>";

            $a = 1; while ($a <= 4) {
              $seat = "A" . ($a + (4 * $i)) . "";
              echo "<li class='seat'>" . $Reservation->placements($bookedSeats, $seat) . "</li>";
              $a++;
            }

            echo "</ul>";
            $i++;
          }
        ?>

      </div>

    <?php endif; ?>

  </div>
</div>

<script src="https://js.braintreegateway.com/js/braintree-2.30.0.min.js"></script>
<script>
  braintree.setup('<?php echo $braintree_token ?>', 'dropin', {
    container: 'payment-form',
    form: 'checkout',
    paypal: {
      singleUse: true,
      amount: 200.00,
      currency: 'SEK',
      button: {
        type: 'checkout'
      }
    }
  });
</script>
