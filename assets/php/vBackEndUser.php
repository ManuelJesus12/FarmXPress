<?php
$data = array($_POST['email'], $_POST['cif'], $_POST['name'], $_POST['password'] ?? "PlaceholderPwd", $_POST['phone'], 
            $_POST['address'], $_POST['region'], $_POST['province'], $_POST['tipo'] ?? "C", null);
$allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];

if(isset($_SESSION["usuario"]) && isset($_SESSION["usuario"])=="ADMINISTRADOR") $method="select";
else if(isset($_SESSION["usuario"]) && isset($_SESSION["usuario"])!="ADMINISTRADOR") $method="viewUpdate";
else $method="viewRegister";

if(filter_var($data[0], FILTER_VALIDATE_EMAIL) && !is_array($this->selectUser($data[0], $fields[0]))) 
    $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_EMAIL);
else header("Location: principal.php?methodUser=$method&error=email");
if(preg_match('/^[A-Z]{1}[0-9]{8}$/', $data[1]) && !is_array($this->selectUser($data[1], $fields[1])))
    $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodUser=$method&error=cif");
if(preg_match('/^[0-9a-zA-ZÀ-ÿ\s]{3,100}$/', $data[2]) && !is_array($this->selectUser($data[2], $fields[2])))
    $data[2] = filter_var(trim($data[2]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodUser=$method&error=nombre");
if(preg_match('/^[0-9A-Za-z]{8,20}$/', $data[3]))
    $data[3] = password_hash(filter_var(trim($data[3])), PASSWORD_BCRYPT);
else header("Location: principal.php?methodUser=$method&error=contraseña");
if(preg_match('/^[1-9]{1}[0-9]{8}$/', $data[4]) && !is_array($this->selectUser($data[4], $fields[4])))
    $data[4] = filter_var(trim($data[4]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodUser=$method&error=tekéfono");
if(preg_match('/^[a-zA-Z0-9À-ÿ\s,.-]{5,200}$/', $data[5]) && !is_array($this->selectUser($data[5], $fields[5])))
    $data[5] = filter_var(trim($data[5]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodUser=$method&error=dirección");
if(is_string($data[6]) && is_string($data[7])){
    $data[6] = filter_var(trim($data[6]), FILTER_SANITIZE_STRING);
    $data[7] = filter_var(trim($data[7]), FILTER_SANITIZE_STRING);
}else header("Location: principal.php?methodUser=$method&error=provincia");

if(isset($_POST['userId'])){
    $user=$this->selectUser($_POST['userId']);
    $data[9]=$user['Avatar'];

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        if (in_array($_FILES['avatar']['type'], $allowedTypes) && $_FILES['avatar']['size'] <= (1024 * 1024)){
            $data[9]=$user['Usuario_ID'].".".strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $uploadFile = "../assets/img/users/".$data[9];
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        }else header("Location: principal.php?methodUser=$method?error=avatar");
    }
}else{
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        if (in_array($_FILES['avatar']['type'], $allowedTypes) && $_FILES['avatar']['size'] <= (1024 * 1024)){
            $data[9]=($this->countUser()['MAX']+1).".".strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
            $uploadFile = "../assets/img/users/".$data[9];
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        }else header("Location: principal.php?methodUser=$method?error=avatar");
    }
}
?>