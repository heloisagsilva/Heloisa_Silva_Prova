<?php
session_start(); //inicia as nossas funcoes
require_once 'conexao.php';

if($_SERVER['REQUEST_METHOD']== "POST"){
    $email= $_POST['email'];
    $senha= $_POST['senha'];

    $sql= "SELECT * FROM usuario WHERE email= :email";
    $stmt= $pdo-> prepare ($sql);
    $stmt-> bindParam(':email', $email);
    $stmt->execute();
    $usuario= $stmt-> fetch(PDO::FETCH_ASSOC);

if($usuario && password_verify($senha, $usuario['senha'])){    //array (matriz)
    //LOGIM BEM SUCEDIDO DEFINE VARIAVEIS DE SESSÃO
    $_SESSION['usuario']= $usuario['nome'];
    $_SESSION['perfi']= $usuario['id_perfil'];
    $_SESSION['id_usuario']= $usuario['id_usuario'];

    //VERIFICA SE A SENHA É TEMPORARIA
if($usuario['senha_temporaria']){
    //REDIRECIONA PARA A TROCA DE SENHA 
    hearde("Location: alterar_senha.php"); //leva para o arquivo 
    exit();
} else{
    //REDIRECIONA PARA A PAGINA PRINCIPAL
    header("Location: principal.php");
    exit();
}
}else{
    //LOGIN INVALIDO
    echo"<script>alert('E-mail ou senha incorretos');window.location.href='login.php';</script>";
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2> Login </h2>
    <form action="login.php" method="POST">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Enviar</button>
    </form>
    <p> 
        <a href="recuperar_senha.php"> Esqueci minha senha</a>
    </p>
</body>
</html>