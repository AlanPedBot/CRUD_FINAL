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
    $sql = $pdo->prepare("SELECT id FROM users WHERE email =:e");
    $sql->bindValue(":e",$email);
    $sql->execute();
    if($sql->rowCount()>0){
        return false;
    }
    else{
        $sql = $pdo->prepare("INSERT INTO users (nome, telefone, email, senha) VALUES(:n, :t,:e,:s)");
        $sql->bindValue(":n",$nome);
        $sql->bindValue(":t",$telefone);
        $sql->bindValue(":e",$email);
        $sql->bindValue(":s",md5($senha));
        $sql->execute();
        return true;

    }

}
// Está função realiza o login dos usuários que estão cadastrados no banco de dados
function logar($email, $senha){
    $conexao = conn();
    $email = addslashes($_POST['email']);
    $entrar = addslashes($_POST['entrar']);
    $senha = md5($_POST['senha']);
  if (isset($entrar)) {
    $sql = $conexao->prepare("SELECT * FROM users WHERE email =
    :e AND senha = :s") or die("erro ao selecionar");
    $sql->bindValue(":e", $email);
    $sql->bindValue(":s", $senha);
    $sql->execute();
    if (($sql) && ($sql->rowCount()<=0)){
        echo "<p style ='width: 350px;
                    margin: 10px auto;
                    padding: 10px;
                    background-color: rgb(250, 128, 114, 0.3);
                    border: 1px solid rgb(165, 42, 42); text-size:5pt'>Login e/ou senha incorretos!</p>";
        die();
      }else{
        $dado = $sql->fetch();
        session_start();
        $_SESSION['id'] = $dado['id'];
        $_SESSION['nome'] = $dado['nome'];
        echo"<script language='javascript' type='text/javascript'>;window.location.
        href='../frontend/home'</script>";
      }
  }
          }

?>