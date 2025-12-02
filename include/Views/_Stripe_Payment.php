<?php
require '../assets/vendor/Stripe/vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51RUYUb1gSXF4s3l5RSGxxR3CwWWnfk86K0HmICepS6eYLK0khqH4ethdACnxkO2uYXoNvoniL7T9zdTVvqKyqlQE00RlDxquwA');

$linkSuccess="https://localhost/FARMXPRESS/include/";

/* Función: Recoge datos de pago y crea una sesión de Stripe Checkout
    * Params: pId (ID del producto), price (precio del producto), month (meses de alquiler)
    * Return: Cookie con los datos del alquiler o pago, redirige a Stripe Checkout
    */
if(isset($_GET['methodRent'])){
    $price= isset($_POST['price']) ? $_POST['price'] : 0;
    $cookie_array=setcookie("data-rent", json_encode([
        'pId'   => isset($_POST['pId']) ? $_POST['pId'] : 0,
        'month' => isset($_POST['month']) ? $_POST['month'] : 0,
        'price' => $price
    ]), time() + (86400 * 30), "/");
    
    $linkSuccess.="principal.php?methodRent=insert";

}else if(isset($_GET['methodPay'])){
    $price= isset($_POST['amount']) ? $_POST['amount'] : 0;
    $cookie_array=setcookie("data-pay", json_encode([
        'rId' => isset($_POST['rId']) ? $_POST['rId'] : 0,
        'mPrice' => isset($_POST['mPrice']) ? $_POST['mPrice'] : 0,
        'month' => isset($_POST['month']) ? $_POST['month'] : 0,
        'amount' => $price,
    ]), time() + (86400 * 30), "/");
    
    $linkSuccess.="principal.php?methodPay=insert";

}else if(isset($_GET['methodMember'])){
    $data = json_decode($_COOKIE['data-member'], true);
    $price= isset($data['price']) ? $data['price'] : 0;

    $linkSuccess.="principal.php?methodMember=insert";
}

/* Función: Crea una sesión de Stripe Checkout y redirige al usuario
    * Params: price (precio del producto)
    * Return: Redirección a Stripe Checkout
    */
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => 'Operación de pago'],
                'unit_amount' => intval($price*100),
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $linkSuccess,
        'cancel_url' => 'http://localhost/FARMXPRESS/index.php',
    ]);

    // Redirect to Stripe Checkout
    header("Location: " . $session->url);
    exit();
} catch (Exception $e) {
    header("Location: http://localhost/FARMXPRESS/include/principal.php?methodProd=select&page=1&error=1");
}
?>

