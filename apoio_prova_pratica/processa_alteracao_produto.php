<?php
session_start();
require ('conexao.php');

if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome_prod = $_POST['nome_prod'];  
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor_unitario = $_POST['valor_unitario'];  
    $nova_senha = !empty($_POST['nova_senha'])? 
    password_hash($_POST['nova_senha'],PASSWORD_DEFAULT): null;

    // Atualiza os dados do usuário
    if($nova_senha){
        $sql = "UPDATE produto SET nome_prod=:nome_prod, descricao=:descricao, qtde=:qtde, valor_unit=:valor_unit
                WHERE id_produto = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':senha',$nova_senha,PDO::PARAM_INT);
    } else{
        $sql = "UPDATE produto SET nome_prod=:nome_prod, descricao=:descricao, qtde=:qtde
                WHERE id_produto = :id";
        $stmt = $pdo -> prepare($sql);
    }
    $stmt -> bindParam(':nome',$nome);
    $stmt -> bindParam(':email',$email);
    $stmt -> bindParam(':id_perfil',$id_perfil);
    $stmt -> bindParam(':id',$id_produto);

    if($stmt -> execute()){
        echo "<script>alert('Usuário atualizado com sucesso!');window.location.href='buscar_usuario.php';</script>";
    } else{
        echo "<script>alert('Erro ao atualizar usuário!');window.location.href='alterar_usuario.php?id=$id_usuario';</script>";
    }
}
?>
