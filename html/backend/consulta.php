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
    <link rel="stylesheet" href="../css/style.css">

    <title>BUSCA LIVRO</title>
</head>

<body>

    <?php
    // Pega o id atraves do método GET e faz a busca da informação pesquisada atraves do id
         $num = $_GET['id'];
         $stmt = $conn->prepare("SELECT * FROM books WHERE id = :id");
         $stmt->bindValue(":id", $num);
         $result = $stmt->execute();

         
         if($stmt->rowCount()==1){
             echo "<p class='fs-1' style ='color:green'>Busca realizada com sucesso!!!</p>";
         }else{
             echo "<p class='fs-1' style ='color:red'>Id Inválido</p>";
         }
    ?>
    <!-- formulario que pega as informações pelos inputs -->
    <form method="get" action="">
        <div class="mx-auto" style="margin-top: auto;">
            <h1>Buscando Livros</h1>
            <p class=" fs-2 bg-dark">ID_LIVRO</p>

            <input class="w-25 p-3" type="number" name="id" placeholder="Digite o id do livro" required>
        </div>
        <button type="submit" class="btn btn-light btn-lg" style="margin-top: 15px;">BUSCAR</button>
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
        <?php
          // Faz a busca de todos os registros do banco de dados 
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