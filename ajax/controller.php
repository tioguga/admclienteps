<?php
ob_start(); session_start();
require '../funcoes/banco/conexao.php';
require '../funcoes/login/login.php';
require '../funcoes/crud/crud.php';
sleep(2);
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) :
    case 'login': //FAZ o login
        $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);
        if (login($login, $senha)):
        //cria a sessao
            $_SESSION['administrador'] = pegaLogin($login);
         else:
                $dados=pegaLogin($login);
               if (empty($login) || empty($senha)):
                   echo 'empty';
                elseif (!$dados):
                    echo 'noif';
                elseif ($dados->administrador_senha != md5(strrev($senha))):
                    echo 'diffpass';
                elseif ($dados->administrador_nivel >= 3):
                    echo 'non';
                endif;
        endif;
       break;

    case 'cadastro': //faz o cadastro
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
        $telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);
        $nivel = filter_input(INPUT_POST, "nivel", FILTER_SANITIZE_STRING);
        if (cadastro($nome, $login, $telefone, $email, $senha, $nivel)):
            echo "cadastrou";
        endif;
     break;

    case 'edit_cadastro': //faz a atualizacao
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        $telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        if (atualizar($nome, $telefone, $email, $login, $id)):
            echo "atualizou";
        endif;
    break;

    case 'excluir': //faz a exclusao
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
        if (deletar($id)):
            echo "deletou";
        endif;
    break;

     default :
        echo 'erro';
        break;
endswitch;
ob_end_flush();