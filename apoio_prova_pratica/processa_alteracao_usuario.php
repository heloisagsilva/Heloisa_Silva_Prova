<?php
session_start();
require ('conexao.php');

if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_usuario = $_POST['id_usuario'];
    $nome = trim($_POST['nome']);
    $email = $_POST['email'];
    $id_perfil = $_POST['id_perfil'];
    $nova_senha_plain = !empty($_POST['nova_senha']) ? $_POST['nova_senha'] : null;
    $nova_senha = null;
    if ($nova_senha_plain !== null) {
        if (!preg_match('/^[A-Za-z0-9]{8}$/', $nova_senha_plain)) {
            echo "<script>alert('A nova senha deve conter exatamente 8 caracteres (letras e/ou números).');window.location.href='alterar_usuario.php?id=$id_usuario';</script>";
            exit();
        }
        $nova_senha = password_hash($nova_senha_plain, PASSWORD_DEFAULT);
    }

    // Validação do nome: apenas letras e espaços
    if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome)) {
        echo "<script>alert('O nome deve conter apenas letras.');window.location.href='alterar_usuario.php?id=$id_usuario';</script>";
        exit();
    }

    // Atualiza os dados do usuário
    if($nova_senha){
        $sql = "UPDATE usuario SET nome=:nome, email=:email, id_perfil=:id_perfil, senha=:senha
                WHERE id_usuario = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':senha',$nova_senha);
    } else{
        $sql = "UPDATE usuario SET nome=:nome, email=:email, id_perfil=:id_perfil
                WHERE id_usuario = :id";
        $stmt = $pdo -> prepare($sql);
    }
    $stmt -> bindParam(':nome',$nome);
    $stmt -> bindParam(':email',$email);
    $stmt -> bindParam(':id_perfil',$id_perfil);
    $stmt -> bindParam(':id',$id_usuario);

    if($stmt -> execute()){
        echo "<script>alert('Usuário atualizado com sucesso!');window.location.href='buscar_usuario.php';</script>";
    } else{
        echo "<script>alert('Erro ao atualizar usuário!');window.location.href='alterar_usuario.php?id=$id_usuario';</script>";
    }
}
?>
