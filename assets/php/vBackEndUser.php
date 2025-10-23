<?php
if(isset($_COOKIE["data-user"])){
    $data = json_decode($_COOKIE["data-user"], true);
    $fields = ["Email", "CIF", "Nombre", "Contraseña", "Teléfono", "Dirección"];

    if(filter_var($data[0], FILTER_VALIDATE_EMAIL) && !is_array($this->selectUser($data[0], $fields[0]))) 
        $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_EMAIL);
    else header("Location: principal.php?methodUser=viewRegister&action=-1");
    if(preg_match('/^[A-Z]{1}[0-9]{8}$/', $data[1]) && !is_array($this->selectUser($data[1], $fields[1])))
        $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodUser=viewRegister&action=-1");
    if(preg_match('/^[0-9a-zA-ZÀ-ÿ\s]{3,100}$/', $data[2]) && !is_array($this->selectUser($data[2], $fields[2])))
        $data[2] = filter_var(trim($data[2]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodUser=viewRegister&action=-1");
    if(preg_match('/^[0-9A-Za-z]{8,20}$/', $data[3]))
        $data[3] = filter_var(trim($data[3]));
    else header("Location: principal.php?methodUser=viewRegister&action=-1");
    if(preg_match('/^[1-9]{1}[0-9]{8}$/', $data[4]) && !is_array($this->selectUser($data[4], $fields[4])))
        $data[4] = filter_var(trim($data[4]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodUser=viewRegister&action=-1");
    if(preg_match('/^[a-zA-Z0-9À-ÿ\s,.-]{5,200}$/', $data[5]) && !is_array($this->selectUser($data[5], $fields[5])))
        $data[5] = filter_var(trim($data[5]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    else header("Location: principal.php?methodUser=viewRegister&action=-1");

}else header("Location: principal.php?methodUser=viewRegister&action=-1");
?>