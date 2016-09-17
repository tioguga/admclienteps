<?php
ob_start(); session_start();
require '../funcoes/banco/conexao.php';
require '../funcoes/login/login.php';
require '../funcoes/crud/crudcliente.php';
sleep(2);
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) :

    case 'cadastro_cliente': //faz o cadastro
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $telefone_ddd = filter_input(INPUT_POST, "telefone_ddd", FILTER_SANITIZE_STRING);
        $telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
        $endereco1 = filter_input(INPUT_POST, "endereco1", FILTER_SANITIZE_STRING);
        $endereco2 = filter_input(INPUT_POST, "endereco2", FILTER_SANITIZE_STRING);
        $administrador_id = filter_input(INPUT_POST, "id-adm", FILTER_SANITIZE_NUMBER_INT);
        if (cadastrocliente($nome, $email, $telefone_ddd, $telefone, $endereco1, $endereco2, $administrador_id)):
            echo "cadastrou";
        endif;
        break;

    case 'edit_cadastro_cliente': //faz a atualizacao
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $telefone_ddd = filter_input(INPUT_POST, "telefone_ddd", FILTER_SANITIZE_STRING);
        $telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
        $endereco1 = filter_input(INPUT_POST, "endereco1", FILTER_SANITIZE_STRING);
        $endereco2 = filter_input(INPUT_POST, "endereco2", FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        if (atualizarcliente($nome, $email, $telefone_ddd, $telefone, $endereco1, $endereco2, $id)):
            echo "atualizou";
        endif;
        break;
    case 'excluir_cliente': //faz a exclusao
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        if (deletarcliente($id)):
            echo "deletou";
        endif;
        break;
    default :
        echo 'erro';
        break;
endswitch;
ob_end_flush();
