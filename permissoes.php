<?php
$id_perfil = $_SESSION['perfil'];
//DEFINIÇÃO DAS PERMISSÕES POR PERFIL
$permissoes = [
    //ADMIN
    1 => ["Cadastrar"=>["cadastro_usuario.php", "cadastro_perfil.php", "cadastro_cliente.php", "cadastro_fornecedor.php", "cadastro_produto.php", "cadastro_funcionario.php"],
          
          "Buscar"=>["buscar_usuario.php", "buscar_perfil.php", "buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php", "buscar_funcionario.php"],
          
          "Alterar"=>["alterar_usuario.php", "alterar_perfil.php", "alterar_cliente.php", "alterar_fornecedor.php", "alterar_produto.php", "alterar_funcionario.php"],
          
          "Excluir"=>["excluir_usuario.php", "excluir_perfil.php", "excluir_cliente.php", "excluir_fornecedor.php", "excluir_produto.php", "excluir_funcionario.php"]],

    //SECRETÁRIA
    2 => ["Cadastrar"=>["cadastro_cliente.php"],

          "Buscar"=>["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],

          "Alterar"=>["alterar_fornecedor.php", "alterar_produto.php"],

          "Excluir"=>["excluir_produto.php"]],

    // ALMOXARIFE
    3 => ["Cadastrar"=>["cadastro_fornecedor.php", "cadastro_produto.php"],

          "Buscar"=>["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],

          "Alterar"=>["alterar_fornecedor.php", "alterar_produto.php"],

          "Excluir"=>["excluir_produto.php"]],

    //CLIENTE
    4 => ["Cadastrar"=>["cadastro_cliente.php"],

          "Buscar"=>["buscar_cliente.php"],

          "Alterar"=>["alterar_cliente.php"]],
];


// OBTENDO AS OPÇÕES DISPONIVEIS PARA O PERFIL DO USUÁRIO LOGADO
$opcoes_menu = $permissoes["$id_perfil"];
?>