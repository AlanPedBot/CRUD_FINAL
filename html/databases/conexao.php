<?php
include_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

 function conectar(){
    $local_serve = $_ENV['LOCAL_SERVE'];
    $usuario_serve = $_ENV['USE_SERVE'];
    $senha_serve = $_ENV['SENHA_SERVE'];
    $banco_de_dados = $_ENV['BANCO_DADOS1'];

    try{
        $conn = new PDO("mysql:host=$local_serve;dbname=$banco_de_dados", $usuario_serve, $senha_serve);
        $conn->exec("SET CHACARACTER SET utf8");
    }catch(\Throwable $th){
        return $th;
        die;

    }
    return $conn;
}
?>