<?php
$data = array($_POST['review'], $_COOKIE["data-rev"] ?? 0, $_POST["pId"]);

if(preg_match('/^[a-zA-Z0-9À-ÿ\s]{5,255}$/', $data[0]))
    $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodProd=viewProduct&id=".$_POST["pId"]."&success=-1");
if(is_numeric($data[1]))
    $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_NUMBER_INT);
else header("Location: principal.php?methodProd=viewProduct&id=".$_POST["pId"]."&success=-1");
?>