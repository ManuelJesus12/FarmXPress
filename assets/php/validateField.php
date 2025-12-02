<?php
$c = new PDO("mysql:host=localhost;dbname=farmxpress", "root", "");
$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header('Content-Type: application/json');

if($_POST['objectId']!=null)
    $query="SELECT * FROM ".$_POST["type"]."s WHERE ".$_POST["field"]." = :value AND ".$_POST["type"]."_ID != :objectId";
else
    $query="SELECT * FROM ".$_POST["type"]."s WHERE ".$_POST["field"]." = :value";

$sql= $c->prepare($query);
$sql->bindParam(':value', $_POST["value"]);
if($_POST['objectId']!=null) $sql->bindParam(':objectId', $_POST["objectId"]);

$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

if (is_array($result) && count($result) > 0)
    $result = $result[0][$_POST["field"]];
else $result = 0;

echo json_encode(["text" => $result]);
exit;
?>