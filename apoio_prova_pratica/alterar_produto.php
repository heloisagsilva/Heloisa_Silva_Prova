<?php
session_start();
require_once('conexao.php');
require_once ('permissoes.php');

// Verifica se o usuário tem permissão de adm
if($_SESSION['perfil'] != 1){
    echo "<script>alert('Acesso negado!').window.location.href='principal.php';</script>";
    exit();
}

// Inicializa variáveis
$usuario = null;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['busca_produto'])){
        $busca = trim($_POST['busca_produto']);

        // Verifica se a busca é um número(id) ou um nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':busca',$busca,PDO::PARAM_INT);
        } else{
            $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome_prod ORDER BY nome_prod";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindValue(':busca_nome_prod',"$busca%",PDO::PARAM_STR);
        }
        $stmt -> execute();
        $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

        // Se o usuário não for encontrado, exibe um alerta
        if(!$usuario){
            echo "<script>alert('Produto não encontrado!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<!--Certifique-se que o javascript está sendo carregado corretamente-->
    <script src="script.js"></script>
    <title>Alterar produto</title>
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

     <h2 align="center">Alterar produto</h2>

     <form action="alterar_usuario.php" method="POST">
        <label for="busca_produto">Digite o ID ou nome do usuário</label>
        <input type="text" id="busca_produto" name="busca_produto" required onkeyup="buscarSugestoes()">
        <!--DIV para exibir sugestões de usuários-->
        <div id="sugestoes"></div>

        <button type="submit">Pesquisar</button>
     </form>

     <?php if($usuario): ?>
       <!--Formulário para alterar usuário-->
       <form action="processa_alteracao_usuario.php" method="POST">
          <input type="hidden" name="id_produto" 
           value="<?= htmlspecialchars($usuario['id_produto']) ?>">

           <label for="nome">Nome produto:</label>
           <input type="text" id="nome_prod" name="nome_prod" 
           value="<?= htmlspecialchars($usuario['nome_prod']) ?>" required>

           <label for="quantidade">Quantidade:</label>
           <input type="number" id="qtde "name="quantidade" 
           value="<?= htmlspecialchars($usuario['qtde']) ?>" required>

           <label for="valor_unitario">Perfil:</label>
           <select id="valor_unit" name="valor_unitario">
              <option value="1" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Administrador</option>
              <option value="2" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Secretária</option>
              <option value="3" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Almoxarife</option>
              <option value="4" <?=$usuario['id_perfil'] == 1 ? 'select':''?>>Cliente</option>
           </select>
       <!--Se o usuário logado for adm, exibir opção de alterar senha-->
       <?php if($_SESSION['perfil'] == 1): ?>
           <label for="nova_senha">Nova senha</label>
           <input type="password" id="nova_senha" name="nova_senha">
       <?php endif; ?>
<br>
           <button type="submit" class="btn btn-outline-success">Alterar</button> <br>
           <button type="reset" class="btn btn-outline-danger">Cancelar</button>
       </form>
     <?php endif; ?>
</body>
<br>
<adress>
    <center>
        Heloisa Gonçalves da Silva/ Desenvolvimento de Sistemas
    </center>
</adress>
</html>
