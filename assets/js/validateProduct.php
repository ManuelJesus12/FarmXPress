<?php
$c = new PDO("mysql:host=localhost;dbname=FARMXPRESS", "root", "");
$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header('Content-Type: application/json');

if($_POST['prodId']!=null)
    $query="SELECT * FROM PRODUCTOS WHERE " . $_POST["field"] . " = :value AND PRODUCTO_ID != :prodId";
else
    $query="SELECT * FROM PRODUCTOS WHERE " . $_POST["field"] . " = :value";

$sql= $c->prepare($query);
$sql->bindParam(':value', $_POST["value"]);
if($_POST['prodId']!=null)
    $sql->bindParam(':prodId', $_POST["prodId"]);

$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

if (is_array($result) && count($result) > 0)
    $result = $result[0][$_POST["field"]];
else $result = 0;

echo json_encode(["text" => $result]);
exit;
?>