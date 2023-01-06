<?php
require_once '../databases/login_conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style_login.css">
    <title>LOGIN</title>
</head>

<body style="background-image: url(../images/livros1.jpg); background-position: 50% 100%;">
    <div style=" margin:150px auto 0px auto; width: 420px; text-align:center;">
        <h1>Entrar</h1>
        <form method="POST" action="../frontend/home">
            <input type="email" name="email" placeholder="Email" maxlength="40" required>
            <input type="password" name="senha" placeholder="Senha" maxlength="15" required>
            <input type="submit" value="ACESSAR">
            <div>
                <div>
                    <a href="cadastrar.php">Ainda não está
                        cadastrado?<strong> Cadastre-se!</strong></a>
                </div>
            </div>
        </form>
    </div>
    <?php
    if(isset($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            $con = conn();
           
            if(logar($email,$senha)){
                header("location: ./frontend/home");
            }
            else{
                echo "<p style ='width: 350px;
                    margin: 10px auto;
                    padding: 10px;
                    background-color: rgb(250, 128, 114, 0.3);
                    border: 1px solid rgb(165, 42, 42); text-size:5pt'>Email e/ou senha inválidos</p>";
            }
            
    }
    ?>
</body>

</html>