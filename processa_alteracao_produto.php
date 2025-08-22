<?php
session_start();
require ('conexao.php');

if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_produto = $_POST['id_produto'];
    $nome_prod = trim($_POST['nome_prod']);
    $descricao = $_POST['descricao'];
    $qtde = $_POST['qtde'];
    $valor_unit = $_POST['valor_unit'];
    $id_produto = $_POST['id_produto'];

    // Validação do nome: apenas letras e espaços
    if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome_prod)) {
        echo "<script>alert('O nome do produto deve conter apenas letras.');window.location.href='alterar_produto.php?id=$id_produto';</script>";
        exit();
    }

    // Atualiza os dados do usuário
    if($nova_senha){
        $sql = "UPDATE produto SET nome_prod=:nome_prod, descricao=:descricao,  qtde=:qtde, valor_unit=:valor_unit
                WHERE id_produto = :id_produto";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':senha',$nova_senha);
    } else{
        $sql = "UPDATE produto SET nome_prod=:nome_prod, descricao=:descricao,  qtde=:qtde, valor_unit=:valor_unit
                WHERE id_produto = :id_produto";
        $stmt = $pdo -> prepare($sql);
    }
    $stmt -> bindParam(':nome_prod',$nome_prod);
    $stmt -> bindParam(':descricao',$descricao);
    $stmt -> bindParam(':qtde',$qtde);
    $stmt -> bindParam(':valor_unit',$valor_unit);
    $stmt -> bindParam(':id_produto',$id_produto);

    if($stmt -> execute()){
        echo "<script>alert('Produto atualizado com sucesso!');window.location.href='buscar_produto.php';</script>";
    } else{
        echo "<script>alert('Erro ao atualizar produto!');window.location.href='alterar_produto.php?id=$id_produto';</script>";
    }
}
?>
