<?php

//Definição do "caminho" onde será guardada a foto
$THE_PATH = "api/files/webcam/webcam.jpg";


function uploadImg($img, $path){
    //Verificação se o ficheiro recebido é uma imagem
    $check = getimagesize($img["tmp_name"]);
    if($check == false) {
        http_response_code(400); #Código Status HTTP --> Bad request
        echo "File is not an image.";
    }
    //Upload da imagem para o "caminho" definido anteriormente   
    if (move_uploaded_file($img["tmp_name"], $path)) {
        echo "Image has been uploaded.";
    } else {
        echo "There was an error uploading the image.";
    }
}

if($_SERVER['REQUEST_METHOD']!='POST'){
    http_response_code(403); //Codigo Status HTTP --> método proibibido
    echo "metodo nao permitido";
    return;
}

if(!isset($_FILES['imagem'])){
    http_response_code(400); 
    echo "imagem nao definida";
    return;
}

$img = $_FILES['imagem'];

//Chamar a função 
uploadImg($img, $THE_PATH);