<?php
include_once('../frontend/header.php');
include_once("../databases/conexao.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">

    <title>DELETA LIVROS</title>
</head>

<body>
    <?php
      $id = $_POST['id'];
      $conn = conectar();
      $consul = $conn->prepare("SELECT * FROM books WHERE id = :id");
      $consul->bindValue(":id", $id);
      $consul->execute();
  
  
      $de = $conn->prepare("DELETE FROM books WHERE id = :id");
      $de->bindValue(":id", $id);
      $result = $de->execute();
      if($consul->rowCount()==1){
          echo "<p class='fs-1' style ='color:green'>Livro deletado com sucesso!!!</p>";
      }else{
          echo "<p class='fs-1' style ='color:red'>Id Inválido</p>";
      }
    ?>
    <form method="post" action="">
        <div class="mx-auto" style="margin-top: auto;">
            <h1>Deleta Livros</h1>
            <p class="fs-2 bg-dark">Id</p>

            <input class="w-25 p-3" type="number" name="id" placeholder="Digite o id do livro" required>
        </div>
        <button type="button" class="btn btn-danger btn-lg" style="margin-top: 15px;" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">DELETAR</button>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class=" modal-dialog">
                <div class=" modal-content" style="background-color:gray">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: red; font-weight:bold;">
                            ALERTA</h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p style="color:red;font-weight:bold;">Tem certeza que deseja deletar este ID?
                            Você não voltará
                            a velo
                            novamente!!!
                        </p>
                        <div>
                            <img src="https://cdn-icons-png.flaticon.com/512/564/564619.png" alt=""
                                style="height: 80px; width: 80px">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">EXCLUIR</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="container">
        <h3>Na tabela abaixo é possível escolher qual informação pode ser deletada no banco de dados</h3>
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