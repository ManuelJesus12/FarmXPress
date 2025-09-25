<?php
$c = new PDO("mysql:host=localhost;dbname=FARMXPRESS", "root", "");
$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header('Content-Type: application/json');

if($_POST['userId']!=null)
    $query="SELECT * FROM USUARIOS WHERE " . $_POST["field"] . " = :value AND USUARIO_ID != :userId";
else
    $query="SELECT * FROM USUARIOS WHERE " . $_POST["field"] . " = :value";

$sql= $c->prepare($query);
$sql->bindParam(':value', $_POST["value"]);
if($_POST['userId']!=null)
    $sql->bindParam(':userId', $_POST["userId"]);

$sql->execute();
$result = $sql->fetchAll(PDO::FETCH_ASSOC);

if (is_array($result) && count($result) > 0)
    $result = $result[0][$_POST["field"]];
else $result = 0;

echo json_encode(["text" => $result]);
exit;
?>