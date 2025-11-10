<?php
$data = array($_POST['name'], $_POST['desc'], $_POST['ref'], $_POST['price'], $_POST['cat'], null, null);
$allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];

if(preg_match('/^[a-zA-Z0-9À-ÿ\s]{3,100}$/', $data[0]))
    $data[0] = filter_var(trim($data[0]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodProd=select?error=nombre");
if(preg_match('/^[a-zA-Z0-9À-ÿ\s,.-]{5,255}$/', $data[1]))
    $data[1] = filter_var(trim($data[1]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodProd=select?error=descripción");
if(preg_match('/^[A-Z]{1}[0-9]{4}$/', $data[2]) && !is_array($this->selectProduct($data[2], $fields[2])))
    $data[2] = filter_var(trim($data[2]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else header("Location: principal.php?methodProd=select?error=referencia");
if(is_numeric($data[3]) && $data[3] > 0)
    $data[3] = filter_var(trim($data[3]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
else header("Location: principal.php?methodProd=select?error=precio");
    
if(isset($_POST['prodId'])){
    $product=$this->selectProduct($_POST['prodId']);
    $data[6]=$product['Imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        if (in_array($_FILES['imagen']['type'], $allowedTypes) && $_FILES['imagen']['size'] <= (1024 * 1024)){
            $data[6]=$product['Producto_ID'].".".strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $uploadFile = "../assets/img/products/".$data[6];
            move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile);
        }else header("Location: principal.php?methodProd=select?error=imagen");
    }
}else{
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        if (in_array($_FILES['imagen']['type'], $allowedTypes) && $_FILES['imagen']['size'] <= (1024 * 1024)){
            $data[6]=($this->countProduct()['MAX']+1).".".strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $uploadFile = "../assets/img/products/".$data[6];
            move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile);
        }else header("Location: principal.php?methodProd=select?error=imagen");
    }
}
?>