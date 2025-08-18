<?php
session_start();
require ('conexao.php');
require_once ('permissoes.php');

// Verifica se o usuário tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!').window.location.href='principal.php';</script>";
    exit();
}

// Inicializa variável para armazenar usuários
$usuarios = [];

// Busca todos os usuários cadastrados em ordem alfabética
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$usuarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);

// Se um ID for passado via GET, exclui o usuário
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    // Exclui o usuário do banco de dados
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(':id',$id_usuario,PDO::PARAM_INT);

    if($stmt -> execute()){
        echo "<script>alert('Usuário excluido com sucesso!').window.location.href='excluir_usuario.php';</script>";
    } else{
        echo "<script>alert('Erro ao excluir usuário!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
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

    <h1 align="center"> Excluir usuario </h2>
    <br><br>
    <?php if (!empty($usuarios)): ?>
        <table class="table" border="1" align="center">
            <tr>
                <th> Id </th>
                <th> Nome </th>
                <th> Email </th>
                <th> Perfil </th>
                <th> Ações </th>
            </tr>
        <?php foreach($usuarios as $usuario):?>
            <tr>
                <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                <td><?=htmlspecialchars($usuario['nome'])?></td>
                <td><?=htmlspecialchars($usuario['email'])?></td>
                <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                <td>
                    <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>"
                    onclick= "return confirm('Tem certeza que deseja excluir este usuario?')"> 
                    Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else:?>
            <p> Nenhum usuario encontrado</p>
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