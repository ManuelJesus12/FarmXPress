<?php
if(isset($_COOKIE["data-prod"])){
    $data = json_decode($_COOKIE["data-prod"], true);
    $fields = ["Nombre", "Descripción", "Referencia", "Precio_Mensual"];

    if(preg_match('/^[a-zA-Z0-9À-ÿ\s]{3,100}$/', $data[0]))
        $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodProd=select?action=-1");
    if(preg_match('/^[a-zA-Z0-9À-ÿ\s,.-]{5,255}$/', $data[1]))
        $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodProd=select?action=-1");
    if(preg_match('/^[A-Z]{1}[0-9]{4}$/', $data[2]) && !is_array($this->selectProduct($data[2], $fields[2])))
        $data[2] = filter_var(trim($data[2]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodProd=select?action=-1");
    if(is_numeric($data[3]) && $data[3] > 0)
        $data[3] = filter_var(trim($data[3]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    else header("Location: principal.php?methodProd=select?action=-1");
    
}else header("Location: principal.php?methodProd=select?action=-1");
?>