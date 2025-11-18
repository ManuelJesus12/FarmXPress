<?php
$data = array($_POST['name'], $_POST['desc'], null);
$index = (isset($_POST['parent_cat'])) ? 'Cat' : 'Sub';

if(preg_match('/^[a-zA-Z0-9À-ÿ\s]{5,20}$/', $data[0]))
    $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?method".$index."=select?error=nombre");
if(preg_match('/^[a-zA-Z0-9À-ÿ\s,.-]{5,255}$/', $data[1]))
    $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?method".$index."=select?error=descripción");

if(isset($_POST['parent_cat']) && is_numeric($_POST['parent_cat']))
    $data[2] = filter_var(trim($_POST['parent_cat']), FILTER_SANITIZE_NUMBER_INT);
else if(isset($_POST['id']) && is_numeric($_POST['id']))
    $data[2] = filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
?>