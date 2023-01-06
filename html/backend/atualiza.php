<?php
include_once('../frontend/header.php');
include_once('../databases/conexao.php');
$conn = conectar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">

    <title>EDITA LIVROS</title>
</head>

<body>
    <?php
   $conn = conectar();
  
  $i = $_POST['id'];
  $n = $_POST['name'];
  $s = $_POST['id_se'];
  
   $up = $conn->prepare("UPDATE books SET name = :name, session_id = :se WHERE id = :id");
   $up->bindValue(":name",$n );
   $up->bindValue(":se", $s);
   $up->bindValue(":id", $i);
   $up->execute();
       if($up->rowCount()==1){
        echo "<p class='fs-1' style ='color:green'>Livro atualizado com sucesso!!!</p>";
    }else{
        echo "<p class='fs-1' style ='color:red'>Id Inválido</p>";
    }
    ?>
    <form method="post" action="">
        <div class="mx-auto" style="margin-top: auto;">
            <h1>Edita Livros</h1>
            <p class="fs-2 bg-dark">Id</p>

            <input class="w-25 p-3" type="number" name="id" placeholder="Digite o id do livro" required>

            <p class="fs-2 bg-dark" style="margin-top: 15px;">Nome</p>

            <input class="w-25 p-3" type="text" name="name" placeholder="Digite o nome do livro" required>
            <p class="fs-2 bg-dark" style="margin-top: 15px;">Id_sessão</p>

            <input class="w-25 p-3" type="number" name="id_se" placeholder="Digite o id da sessão" required>
        </div>
        <button type="submit" class="btn btn-success btn-lg" style="margin-top: 15px;">ATUALIZAR</button>

    </form>
    <div class="container">
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