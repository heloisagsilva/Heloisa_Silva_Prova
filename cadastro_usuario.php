<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISSAO SUPONDE QUE O PERFIL 1 SEJA O ADMINISTRADOR
if($_SESSION['perfil']!=1){
    echo "Acesso negado!";
}

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $nome= $_POST['nome'];
    $email= $_POST['email'];
    $senha= password_hash($_POST['nome'], PASSWORD_DEFAULT);
    $id_perfil= $_POST['id_perfil'];

    $sql= "INSERT INTO usuario (nome, email, senha, id_perfil) VALUES (:nome, :email, :senha, :id_email)";
    $stmt= $pdo-> prepare($sql);
    $stmt= bindParam(':nome', $nome);
    $stmt= bindParam(':email', $email);
    $stmt= bindParam(':senha', $senha);
    $stmt= bindParam(':id_perfil', $id_perfil);

    if($stmt-> execute()){
        echo "<script> ('Usuario cadastrado com sucesso!!');</script";
    }
    else{
        echo "<script> alert('Erro ao encontrar usuario');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2> Cadastrar Usuario </h2>
    <form action="cadastro_usuario.php" method="POST">
        <label for="nome"> Nome: </label>
        <input type="text" id="nome" name="nome" required>

        <label for="senha"> Senha: </label>
        <input type="password" id="senha" name="senha" required>

        <label for="email"> Email: </label>
        <input type="email" id="email" name="email" required>

        <label for="id_perfil"> Perfil: </label>
        <select id="id_perfil" name="id_perfil">
            <option value="1"> Administrador </option>
            <option value="2"> Secretária </option>
            <option value="3"> Almoxarife </option>
            <option value="4"> Cliente </option>
        </select>

    <button type="submit"> Salvar </button>
    <button type="reset"> Cancelar </button>
</form>
    <a href="principal.php"> Voltar </a>
</body>
</html>