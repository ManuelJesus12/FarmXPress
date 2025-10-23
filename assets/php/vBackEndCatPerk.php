<?php
$index = (isset($_COOKIE["data-cat"])) ? "Category" : "Sub";

if(isset($_COOKIE["data-cat"]) || isset($_COOKIE["data-perk"])){
    $data  = (isset($_COOKIE["data-cat"])) ? json_decode($_COOKIE["data-cat"], true) : json_decode($_COOKIE["data-perk"], true);

    if(preg_match('/^[a-zA-Z0-9À-ÿ\s]{5,20}$/', $data[0]))
        $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?method".$index."=select?action=-1");
    if(preg_match('/^[a-zA-Z0-9À-ÿ\s,.-]{5,255}$/', $data[1]))
        $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?method".$index."=select?action=-1");
    
}else header("Location: principal.php?method".$index."=select?action=-1");
?>