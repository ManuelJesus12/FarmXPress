<?php
$data = array($_POST['name'], $_POST['price'], $_POST['months']);

if(preg_match('/^[a-zA-Z0-9À-ÿ\s]{5,20}$/', $data[0]))
    $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodSub=select?action=-1");
if(is_numeric($data[1]) && $data[1] > 0)
    $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodSub=select?action=-1");
if(is_numeric($data[2]) && $data[2] > 0)
    $data[2] = filter_var(trim($data[2]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodSub=select?action=-1");
?>