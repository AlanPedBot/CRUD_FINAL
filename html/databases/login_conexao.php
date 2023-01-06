<?php
// Esta função, faz a conexão com o banco de dados login
include_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
function conn(){
    $local_serve = $_ENV['LOCAL_SERVE'];
    $usuario_serve = $_ENV['USE_SERVE'];
    $senha_serve = $_ENV['SENHA_SERVE'];
    $banco_de_dados = $_ENV['BANCO_DADOS2'];

    try{
        $pdo = new PDO("mysql:host=$local_serve;dbname=$banco_de_dados", $usuario_serve, $senha_serve);
        $pdo->exec("SET CHACARACTER SET utf8");
    }catch(\Throwable $th){
        return $th;
        die;

    }
    return $pdo;
}
function cadastrar($nome, $telefone, $email, $senha){
    $pdo = conn();


    // Verifica se o usuário já está cadastrado no sistema
    $sql = $pdo->prepare("SELECT id FROM user WHERE email =:e");
    $sql->bindValue(":e",$email);
    $sql->execute();
    if($sql->rowCount()>0){
        return false;
    }
    else{
        $sql = $pdo->prepare("INSERT INTO user (nome, telefone, email, senha) VALUES(:n, :t,:e,:s)");
        $sql->bindValue(":n",$nome);
        $sql->bindValue(":t",$telefone);
        $sql->bindValue(":e",$email);
        $sql->bindValue(":s",md5($senha));
        $sql->execute();
        return true;

    }

}
function logar($email, $senha){
    $pdo = conn();
    $sql = $pdo->prepare("SELECT id FROM user WHERE email =:e AND senha = :s");
    $sql->bindValue("e:", $email);
    $sql->bindValue("s:", md5($senha));
    $sql->execute();
    if($sql->rowCount() > 0){
        $dado = $sql->fetch();
        session_start();
        $_SESSION['id'] = $dado['id'];
        return true;
    }
    else{
        return false;
    }
}

?>