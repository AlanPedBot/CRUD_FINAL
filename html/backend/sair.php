<?php
// Aqui é estartado uma sessão e assim que o usuário clica em sair a sessão é fechada 
session_start();
ob_start();
unset($_SESSION['id'], $_SESSION['nome']);
$_SESSION['msg'] = "<p style =' width: 350px;
margin: 10px auto;
padding: 10px;
background-color: rgb(50, 205, 50, 0.3);
border: 1px solid rgb(34, 139, 34);'>Deslogado com sucesso!</p>";

header("Location: login");