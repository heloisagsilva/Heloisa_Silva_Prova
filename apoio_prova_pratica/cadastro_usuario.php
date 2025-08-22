<?php
session_start();
require_once('conexao.php');
require_once('permissoes.php');

// Verifica se o usuário tem permissão supondo que o perfil 1 sejá o admin
if($_SESSION['perfil'] != 1){
    echo "Acesso negado!";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];  
    $email = $_POST['email'];  
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);  
    $id_perfil = $_POST['id_perfil'];  
    
    $sql = "INSERT INTO usuario(nome,email,senha,id_perfil)
            VALUES (:nome,:email,:senha,:id_perfil)";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":nome",$nome);
    $stmt -> bindParam(":email",$email);
    $stmt -> bindParam(":senha",$senha);
    $stmt -> bindParam(":id_perfil",$id_perfil);
    
    if($stmt -> execute()){
        echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar usuário');</script>";
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
    <title>Cadastrar usuário</title>
</head>
<body>
     
     <h2 align="center">Cadastrar usuário</h2>
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

     <form action="cadastro_usuario.php" method="POST">
        <label for="nome">Nome: </label>
        <input type="text" id="nome" name="nome" required/>

        <label for="email">E-mail: </label>
        <input type="email" id="email" name="email" required/>

        <label for="senha">Senha: </label>
        <input type="password" id="senha" name="senha" required/>

        <label for="id_perfil">Perfil: </label>
        <select id="id_perfil" name="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretária</option>
            <option value="3">Almoxarife</option>
            <option value="4">Cliente</option>
        </select>
        <br>
        <button type="submit">Salvar</button> <br>
        <button type="reset">Cancelar</button>
     </form>
     <a href="principal.php">Voltar</a>
</body>
</html>