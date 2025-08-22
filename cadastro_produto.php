<?php
session_start();
require_once 'conexao.php';
require_once ('permissoes.php');

//VERIFICA SE O USUARIO TEM PERMISSAO SUPONDE QUE O PERFIL 1 SEJA O ADMINISTRADOR
if($_SESSION['perfil']!=1){
    echo "Acesso negado!";
}

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $nome_prod = trim($_POST['nome_prod']);
    $descricao = trim($_POST['descricao']);
    $qtde = $_POST['qtde'];
    $valor_unit = $_POST['valor_unit'];
        
        $sql = "INSERT INTO produto (nome_prod, descricao, qtde, valor_unit) VALUES (:nome_prod, :descricao, :qtde, :valor_unit)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_prod', $nome_prod);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':qtde', $qtde);
        $stmt->bindParam(':valor_unit', $valor_unit);

        if ($stmt->execute()) {
            echo "<script>alert('Produto cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar produto.');</script>";
        }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro produto</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<style>
    .numero{
    width: 80%; /* Ocupa toda a largura do formulário */
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    }
    </style>
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

    <h2 align="center"> Cadastrar produto </h2>
    <form action="cadastro_produto.php" method="POST">
        <label for="nome_prod"> Nome Produto: </label>
        <input type="text" id="nome_prod" name="nome_prod" required minlength="5" title="O nome deve possuir + de 5 letras">

        <label for="descricao"> Descrição: </label>
        <input type="text" id="descricao" name="descricao" required minlength="5" title="O nome deve possuir + de 5 letras">

        <label for="qtde"> Quantidade: </label>
        <input type="number" class="numero" id="qtde" name="qtde" required>

        <label for="valor_unit"> Valor unitario: </label>
        <input type="number" class="numero" id="valor_unit" name="valor_unit" required>

<br>
    <button type="submit" class="btn btn-outline-success"> Salvar </button> <br>
    <button type="reset" class="btn btn-outline-danger"> Cancelar </button>
</form>
</body>
</html>