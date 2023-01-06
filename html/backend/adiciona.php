<?php
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
    <link rel="stylesheet" href="../CSS/style.css">

    <title>ADICIONA LIVROS</title>
</head>

<body>
    <?php
          
           $conn = conectar();
           
       
           $name = $_POST["nome"];
           $id_s = $_POST["id_s"];
       
       $insert = $conn->prepare("INSERT INTO books(name, session_id) VALUES (:name_l,:id_session)");   
       
       $insert->bindParam(':name_l', $name);
       $insert->bindParam(':id_session', $id_s);
       
       if($insert->execute()){
           echo "<p class='fs-1' style ='color:green'>Livro adicionado com sucesso!!!</p>";
           
       }else{
           echo "<p class='fs-1' style ='color:red'>Erro, valor ou informação inválida</p>";
         
       }
    ?>

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
            $num = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM books");
            $stmt->execute();
            $buscar = $stmt->fetchAll();
            foreach ($buscar as $busca){
            ?>
    <table class="table table-secondary table-hover">
        <tr>
            <td width="30%"><?php echo $busca['id']; ?></td>
            <td width="30%"><?php echo $busca['name']; ?></td>
            <td width="30%"><?php echo $busca['book_borrowed_id']; ?></td>
            <td width="30%"><?php echo $busca['session_id']; ?></td>
        </tr>
    </table>
    </div>
    <?php
      }
    ?>
</body>

</html>