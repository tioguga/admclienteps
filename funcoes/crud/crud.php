<?php
function cadastro($nome, $login, $telefone, $email, $senha, $nivel){ //funcao de cadastro
    $pdo = conecta();
    try{
        $cadastro = $pdo->prepare("INSERT INTO `administrador`(`administrador_nome`, `administrador_login`, `administrador_telefone`, `administrador_email`, `administrador_senha`, `administrador_nivel`) 
                                  VALUES (?,?,?,?,?)");
        $cadastro->bindValue(1, $nome, PDO::PARAM_STR);
        $cadastro->bindValue(2, $login, PDO::PARAM_STR);
        $cadastro->bindValue(3, $telefone, PDO::PARAM_STR);
        $cadastro->bindValue(4, $email, PDO::PARAM_STR);
        $cadastro->bindValue(5, md5(strrev($senha)), PDO::PARAM_STR);
        $cadastro->bindValue(6, $nivel, PDO::PARAM_STR);
        $cadastro->execute();
        if ($cadastro->rowCount() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

function listarAdmin(){ //funcao de listar admin
    $pdo = conecta();
    try{
        $listar = $pdo->query("SELECT * FROM `administrador`");
        if ($listar->rowCount() > 0):
            return $listar->fetchAll(PDO::FETCH_OBJ);
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

function pegaId($id){ //funcao de pega id admin
    $pdo = conecta();
    try{
        $pegaid = $pdo->prepare("SELECT * FROM `administrador` WHERE `id` = ?");
        $pegaid->bindValue(1, $id, PDO::PARAM_INT);
        $pegaid->execute();
        if ($pegaid->rowCount() > 0):
            return $pegaid->fetch(PDO::FETCH_OBJ);
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

//funcao atualiza

function atualizar($nome, $telefone, $email, $login, $id){ //atualiza admin
    $pdo = conecta();
    try{
        $atualizar = $pdo->prepare("UPDATE `administrador` SET `administrador_nome`=?,`administrador_telefone`=?,`administrador_email`=?,`administrador_login`=? WHERE `id`=?");
        $atualizar->bindValue(1, $nome, PDO::PARAM_STR);
        $atualizar->bindValue(2, $telefone, PDO::PARAM_STR);
        $atualizar->bindValue(3, $email, PDO::PARAM_STR);
        $atualizar->bindValue(4, $login, PDO::PARAM_STR);
        $atualizar->bindValue(5, $id, PDO::PARAM_INT);
        $atualizar->execute();
        if ($atualizar->rowCount() == 1):
            return TRUE;
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}


//funcao deletar

function deletar($id){ //deleta admin
    $pdo = conecta();
    try{
        $deletar = $pdo->prepare("DELETE FROM `administrador` WHERE `id`=?");
        $deletar->bindValue(1, $id, PDO::PARAM_INT);
        $deletar->execute();
        if ($deletar->rowCount() == 1):
            return TRUE;
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
