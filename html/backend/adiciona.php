<?php

session_start();
ob_start();
include_once '../databases/login_conexao.php';
// Verifica se existe algum id relacionado com o login se não houver retorna para o login
if(!isset($_SESSION["id"]))
{
    header("Location: ../backend/login");
}
include_once('../frontend/header.php');
include_once('../databases/conexao.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../css/style.css">

    <title>ADICIONA LIVROS</title>
</head>

<body>
    <?php
          // chama a função para conectar ao banco de dados
           $conn = conectar();
           
       // pega o valor enviado pelos inputs
           $name = $_POST["nome"];
           $id_s = $_POST["id_s"];
       // realiza a inserção no banco de dados atraves do script sql
       $insert = $conn->prepare("INSERT INTO books(name, session_id) VALUES (:name_l,:id_session)");   
       
       $insert->bindParam(':name_l', $name);
       $insert->bindParam(':id_session', $id_s);
       // Se o livro for inserido exibe a mensagem
       if($insert->execute()){
           echo "<p class='fs-1' style ='color:green'>Livro adicionado com sucesso!!!</p>";
           
       }else{
           echo "<p class='fs-1' style ='color:red'>Erro, valor ou informação inválida</p>";
         
       }
    ?>
    <!-- formulario que pega as informações pelos inputs  -->
    <form method="POST" action="">
        <div class="mx-auto" style="margin-top: auto;">
            <h1>Inserindo Livro</h1>
            <p class="fs-2 bg-dark">NOME </p>
            <input class="w-25 p-3" type="text" name="nome" placeholder="Digite o nome do livro" required>


            <p class="fs-2 bg-dark" style="margin-top: 15px;">ID_SESSÃO</p>

            <input class="w-25 p-3" type="number" name="id_s" placeholder="Digite a sessão do livro" required>
        </div>
        <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 15px;">ADICIONAR</button>
    </form>
    <div class="container">
        <h3>Na tabela abaixo é possível verificar se o livro foi inserido</h3>
        <table class="table table-secondary table-hover">
            <tr>
                <th width="30%"><strong>ID </strong></th>
                <th width="30%"><strong> Nome_livro</strong></th>
                <th width="30%"><strong>Id_Emprestado</strong></th>
                <th width="30%"><strong>Id_Sessão</strong></th>
            </tr>
        </table>
    </div>
    <?php
     $conn = conectar();
        
        //Recebe o número da página
        $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

        //Setar a quantidade de registros por página
        $limite_resultado = 5;

        //Calcula o inicio da visualização
        $inicio = ($limite_resultado * $pagina) - $limite_resultado;


        $query_usuarios = "SELECT * FROM books LIMIT $inicio, $limite_resultado";
        $result_usuarios = $conn->prepare($query_usuarios);
        $result_usuarios->execute();

        if (($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
            while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
                extract($row_usuario);
                ?>
    <table class="table table-secondary table-hover">
        <tr>
            <td width="30%"><?php echo $row_usuario['id']; ?></td>
            <td width="30%"><?php echo $row_usuario['name']; ?></td>
            <td width="30%"><?php echo $row_usuario['book_borrowed_id']; ?></td>
            <td width="30%"><?php echo $row_usuario['session_id']; ?></td>
        </tr>
    </table>
    <?php
            }

            //Contar a quantidade de registros no banco de dados
            $query_qnt_registros = "SELECT COUNT(id) AS num_result FROM books";
            $result_qnt_registros = $conn->prepare($query_qnt_registros);
            $result_qnt_registros->execute();
            $row_qnt_registros = $result_qnt_registros->fetch(PDO::FETCH_ASSOC);

            //Quantidade de página
            $qnt_pagina = ceil($row_qnt_registros['num_result'] / $limite_resultado);

            // Maximo de itens por pagina
            $maximo_link = 2;

            echo "<button type='button' class='btn btn-light'style='margin-bottom: 15px; margin-right: 3px;color:black;'><a href='delete?page=1'style='color:black;'>Primeira</a></li> </button>";

            for ($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; $pagina_anterior++) {
                if ($pagina_anterior >= 1) {
                    echo "<button type='button' class='btn btn-light'style='margin-bottom: 15px; margin-right: 3px;color:black;'><a href='delete?page=$pagina_anterior'style='color:black;'>$pagina_anterior</a></li> </button>";
                }
            }

            echo "<a style='color:black;'href=''>$pagina</a> ";

            for ($proxima_pagina = $pagina + 1; $proxima_pagina <= $pagina + $maximo_link; $proxima_pagina++) {
                if ($proxima_pagina <= $qnt_pagina) {
                    echo "<button type='button' class='btn btn-light'style='margin-bottom: 15px; margin-right: 3px;color:black;'><a href='delete?page=$proxima_pagina'style='color:black;'>$proxima_pagina</a></li> </button>";
                }
            }

            echo "<button type='button' class='btn btn-light'style='margin-bottom: 15px; margin-right: 3px;color:black;'><a href='delete?page=$qnt_pagina' style='color:black;'>Última</a> </li> </button>";
        } else {
            echo "<p style='color: #f00;'>Erro: Nenhum usuário encontrado!</p>";
        }
        ?>
</body>

</html>