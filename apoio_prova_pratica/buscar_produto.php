<?php
session_start();
require_once 'conexao.php';
require_once ('permissoes.php');

//VERIFCA SE O USARIO TEM PERMISSAO DE adm OU secretaria
if($_SESSION['perfil'] !=1 && $_SESSION['perfil'] !=2){
    echo "<script>alert('Acesso negado!');windown.location.href='principal.php';</script>";
    exit();
}
$usuario= []; //INICIALIZA A VARIAVEL PARA EVITAR ERROS

//SE FORMULARIO FOR ENVIADO, BUSCA USUARIO PELO O ID OU NOME
if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['busca'])){
    $busca= trim($_POST['busca']);

//VERIFICA SE A BUSCA É UM NUMERO OU UM NOME 
if(is_numeric($busca)){
    $sql= "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod ASC";
    $stmt= $pdo-> prepare($sql);
    $stmt-> bindParam(':busca', $busca, PDO::PARAM_INT);
}else {
    $sql= "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome_prod ORDER BY nome_prod ASC";
    $stmt= $pdo-> prepare($sql);
    $stmt-> bindValue(':busca_nome_prod', "$busca%", PDO::PARAM_STR);
}
}else {
    $sql= "SELECT * FROM produto ORDER BY nome_prod ASC";
    $stmt= $pdo-> prepare($sql);
}

$stmt-> execute();
$usuarios= $stmt-> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Produto</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
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

    <h2 align="center"> Lista de Produtos </h2>
    <form action="buscar_produto.php" method="POST">
        <label for="busca"> Digite o ID ou NOME(opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit"> Pesquisar</button>
    </form>

    <?php if(!empty($usuarios)):?>
        <table class="table" border="1" align="center">
            <tr>
                <th> ID </th>
                <th> NOME PRODUTO </th>
                <th> DESCRIÇÃO </th>
                <th> QUANTIDADE </th>
                <th> VALOR UNITARIO </th>
            </tr>
            <?php foreach($usuarios as $usuario):?>
            <tr>
                <td> <?=htmlspecialchars($usuario['id_produto'])?></td>
                <td> <?=htmlspecialchars($usuario['nome_prod'])?></td>
                <td> <?=htmlspecialchars($usuario['descricao'])?></td>
                <td> <?=htmlspecialchars($usuario['qtde'])?></td>
                <td> <?=htmlspecialchars($usuario['valor_unit'])?></td>
                <td> 
                    <a href="alterar_produto.php?id=<?=htmlspecialchars($usuario['id_produto'])?>">Alterar</a>
                    <a href="excluir_produto.php?id=<?=htmlspecialchars($usuario['id_produto'])?>"onclick="return confirm
                            ('Ter certeza que deseja excluir este produto?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <?php else:?>
            <p> Nenhum produto encontrado.</p>
        <?php endif;?>
        <br>
</body>
<br>
<adress>
    <center>
        Heloisa Gonçalves da Silva/ Desenvolvimento de Sistemas
    </center>
</adress>
</html>