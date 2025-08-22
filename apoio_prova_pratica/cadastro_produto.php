<?php
session_start();
require_once('conexao.php');
require_once('permissoes.php');

// Verifica se o usuário tem permissão supondo que o perfil 1 sejá o admin
if($_SESSION['perfil'] != 1){
    echo "Acesso negado!";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome_prod = $_POST['nome_prod'];  
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor_unitario = $_POST['valor_unitario'];  
    
    $sql = "INSERT INTO produto(nome_prod,descricao,qtde,valor_unit)
            VALUES (:nome_prod,:descricao,:qtde,:valor_unit)";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":nome_prod",$nome_prod);
    $stmt -> bindParam(":descricao",$descricao);
    $stmt -> bindParam(":qtde",$quantidade);
    $stmt -> bindParam(":valor_unit",$valor_unit);
    
    if($stmt -> execute()){
        echo "<script>alert('Produto cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar produto');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="validacao.js"></script>
    <title>Cadastrar produto</title>
</head>
<body>
     
<nav>
        <ul class="menu">
            <?php foreach($opcoes_menu as $categoria => $arquivos) { ?>
                <li class="dropdown">
                    <a href="#"><?= $categoria ?></a>

                    <ul class="dropdown-menu">
                        <?php foreach($arquivos as $arquivo) { ?>
                            <li>   
                                <a href="<?= $arquivo ?>"><?= ucfirst(str_replace("_", " ", basename($arquivo, ".php"))) ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </nav>
<br>
    <a href="principal.php" class="btn btn-outline-primary">Voltar</a>

     <h2 align="center">Cadastrar produto</h2>
     <form action="cadastro_produto.php" method="POST">
        <label for="nome_prod">Nome_produto: </label>
        <input type="text" id="nome_prod" name="nome_prod" required/>

        <label for="descricao">Descrição: </label>
        <input type="text" id="descricao" name="descricao" required/>

        <label for="quantidade">Quantidade: </label>
        <input type="number" id="qtde" name="quantidade" required/>

        <label for="valor_unitario">Valor Unitário: </label>
        <input type="number" id="valor_unit" name="valor_unitario" required/>
<br>
        <button type="submit">Salvar</button><br>
        <button type="reset">Cancelar</button>
     </form>
</body>
</html>