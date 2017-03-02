<?php

  $Reservation = new Reservation();
  $bookedSeats = $Reservation->tablesReserved();

  require_once 'app/lib/Braintree.php';

  Braintree_Configuration::environment('sandbox');
  Braintree_Configuration::merchantId('q4tt847kjwwt5kzv');
  Braintree_Configuration::publicKey('gnxrbrz6psbvcgzs');
  Braintree_Configuration::privateKey('4a5179b2605047b42157a45d0aa6de1a');

  $braintree_token = Braintree_ClientToken::generate();

  if (isset($_POST["reservedSeat"])) {
    echo "hello!";

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
      $Reservation->reserveSeat($_SESSION["logged-in"], $reservedSeat);

    } else {
      //payment error
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
        <form id="checkout" method="post" action="?reserve">
          <p>Vad kommer vara ditt favorit spel det här lanet?</p>
          <input type="text" class="field" name="favGame" placeholder="Counter Strike">
          <input type="text" class="gone" name="reservedSeat" value="<?php echo $_POST["seat"]; ?>">
          <p>Din plats <?php echo $_POST["seat"]; ?> kostar 200kr</p>
          <div id="braintree">
            <div id="payment-form"></div>
            <input type="submit" name="pay" class="button" value="Boka <?php echo $_POST["seat"]; ?> 200kr">
          </div>
        </form>
      </div>

    <?php else: ?>
      <div id="placements">
        <h1>Boka din sittplats</h1>

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
