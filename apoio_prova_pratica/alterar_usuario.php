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
    if(!empty($_POST['busca_usuario'])){
        $busca = trim($_POST['busca_usuario']);

        // Verifica se a busca é um número(id) ou um nome
        if(is_numeric($busca)){
            $sql = "SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':busca',$busca,PDO::PARAM_INT);
        } else{
            $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
        }
        $stmt -> execute();
        $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

        // Se o usuário não for encontrado, exibe um alerta
        if(!$usuario){
            echo "<script>alert('Usuário não encontrado!');</script>";
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
    <title>Alterar usuário</title>
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

     <h2 align="center">Alterar usuário</h2>

     <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou nome do usuário</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
        <!--DIV para exibir sugestões de usuários-->
        <div id="sugestoes"></div>

        <button type="submit">Pesquisar</button>
     </form>

     <?php if($usuario): ?>
       <!--Formulário para alterar usuário-->
       <form action="processa_alteracao_usuario.php" method="POST">
          <input type="hidden" name="id_usuario" 
           value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

           <label for="nome">Nome:</label>
           <input type="text" id="nome" name="nome" 
           value="<?= htmlspecialchars($usuario['nome']) ?>" required>

           <label for="email">Email:</label>
           <input type="email" id="email "name="email" 
           value="<?= htmlspecialchars($usuario['email']) ?>" required>

           <label for="id_perfil">Perfil:</label>
           <select id="id_perfil" name="id_perfil">
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
