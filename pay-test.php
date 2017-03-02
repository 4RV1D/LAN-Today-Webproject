<?php
  require_once 'app/lib/Braintree.php';

  Braintree_Configuration::environment('sandbox');
  Braintree_Configuration::merchantId('q4tt847kjwwt5kzv');
  Braintree_Configuration::publicKey('gnxrbrz6psbvcgzs');
  Braintree_Configuration::privateKey('4a5179b2605047b42157a45d0aa6de1a');

  $braintree_token = Braintree_ClientToken::generate();

  if (isset($_POST["submit"])) {
    $nonceFromTheClient = $_POST["payment_method_nonce"];

    $result = Braintree_Transaction::sale([
      'amount' => '10.00',
      'paymentMethodNonce' => $nonceFromTheClient,
      'options' => [
        'submitForSettlement' => True
      ]
    ]);

    var_dump($result);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Payment</title>
  </head>
  <body>

    <form id="checkout" method="post" action="pay-test.php">
      <div id="payment-form"></div>
      <input type="submit" value="Pay $10">
    </form>

    <script src="https://js.braintreegateway.com/js/braintree-2.30.0.min.js"></script>
    <script>
      braintree.setup('<?php echo $braintree_token ?>', 'dropin', {
        container: 'payment-form'
      });
    </script>

  </body>
</html>
