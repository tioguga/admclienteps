<?php
function login($login, $senha){ //FUNCAO DE LOGIN
    $pdo = conecta();
    try{
        $logar = $pdo->prepare("SELECT * FROM `administrador` WHERE `administrador_login` = ? AND `administrador_senha` = ? AND `administrador_nivel` <= '2'");
        $logar->bindValue(1, $login, PDO::PARAM_STR);
        $logar->bindValue(2, md5(strrev($senha)), PDO::PARAM_STR);
        $logar->execute();
        if ($logar->rowCount() == 1):
            return TRUE;
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
function pegaLogin($login){ //Pega LOGIN
    $pdo = conecta();
    try{
        $bylogin = $pdo->prepare("SELECT * FROM `administrador` WHERE `administrador_login` = ?");
        $bylogin->bindValue(1, $login, PDO::PARAM_STR);
        $bylogin->execute();
        if ($bylogin->rowCount()==1):
            return $bylogin->fetch(PDO::FETCH_OBJ);
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
function logado($sessao){ //administrador logado
    if (!isset($_SESSION[$sessao]) || empty($_SESSION[$sessao])):
        header("Location: index.php");
     else:
         return true;
     endif;
}