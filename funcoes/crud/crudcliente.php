<?php
function cadastrocliente($nome, $email, $telefone_ddd, $telefone, $endereco1, $endereco2, $cep, $administrador_id){ //funcao de cadastro
    $pdo = conecta();
    try{
        $cadastro = $pdo->prepare("INSERT INTO `clientes`(`clientes_nome`,`clientes_email`,`clientes_telefone_ddd`, `clientes_telefone`, `clientes_endereco1`, `clientes_endereco2`, `clientes_cep`, `administrador_id`)
                                  VALUES (?,?,?,?,?,?,?,?)");
        $cadastro->bindValue(1, $nome, PDO::PARAM_STR);
        $cadastro->bindValue(2, $email, PDO::PARAM_STR);
        $cadastro->bindValue(3, $telefone_ddd, PDO::PARAM_STR);
        $cadastro->bindValue(4, $telefone, PDO::PARAM_STR);
        $cadastro->bindValue(5, $endereco1, PDO::PARAM_STR);
        $cadastro->bindValue(6, $endereco2, PDO::PARAM_STR);
        $cadastro->bindValue(7, $cep, PDO::PARAM_STR);
        $cadastro->bindValue(8, $administrador_id, PDO::PARAM_INT);
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

function listarCliente(){ //funcao de listar Clientes
    $adm_id = $_SESSION['administrador']->id;
    $pdo = conecta();
    try{
        $listar = $pdo->query("SELECT * FROM `clientes` WHERE `administrador_id` ='".$adm_id."'");
        if ($listar->rowCount() > 0):
            return $listar->fetchAll(PDO::FETCH_OBJ);
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

function pegaIdcliente($id){ //funcao de pega id cliente
    $pdo = conecta();
    try{
        $pegaid = $pdo->prepare("SELECT * FROM `clientes` WHERE `id` = ?");
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

function atualizarcliente($nome, $email, $telefone_ddd, $telefone, $endereco1, $endereco2, $cep, $id){ //atualiza clientes
    $pdo = conecta();
    try{
        $atualizar = $pdo->prepare("UPDATE `clientes` SET `clientes_nome`=?,`clientes_email`=?,`clientes_telefone_ddd`=?,`clientes_telefone`=?,`clientes_endereco1`=?,`clientes_endereco2`=?,`clientes_cep`=? WHERE `id`=?");
        $atualizar->bindValue(1, $nome, PDO::PARAM_STR);
        $atualizar->bindValue(2, $email, PDO::PARAM_STR);
        $atualizar->bindValue(3, $telefone_ddd, PDO::PARAM_STR);
        $atualizar->bindValue(4, $telefone, PDO::PARAM_STR);
        $atualizar->bindValue(5, $endereco1, PDO::PARAM_STR);
        $atualizar->bindValue(6, $endereco2, PDO::PARAM_STR);
        $atualizar->bindValue(7, $cep, PDO::PARAM_STR);
        $atualizar->bindValue(8, $id, PDO::PARAM_INT);
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

function deletarcliente($id){ //deleta cliente
    $pdo = conecta();
    try{
        $deletar = $pdo->prepare("DELETE FROM `clientes` WHERE `id`=?");
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

//funcao vender

function vendacliente($datacompra, $valorcompra, $diaspagar, $id){ //atualiza clientes
    $pdo = conecta();
    try{
        $venda = $pdo->prepare("UPDATE `clientes` SET `clientes_data_compra`=?,`clientes_valor_compra`=?, `clientes_dias_pagar`=? WHERE `id`=?");
        $venda->bindValue(1, $datacompra, PDO::PARAM_STR);
        $venda->bindValue(2, $valorcompra, PDO::PARAM_STR);
        $venda->bindValue(3, $diaspagar, PDO::PARAM_INT);
        $venda->bindValue(4, $id, PDO::PARAM_INT);
        $venda->execute();
        if ($venda->rowCount() == 1):
            return TRUE;
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
// funcao cadastrar token
function cadastrotoken($tokenpagseguro, $administrador_id){ //funcao de cadastro
    $pdo = conecta();
    try{
        $cadastro = $pdo->prepare("INSERT INTO `administrador`(`administrador_token_pagseguro`, `administrador_id`)
                                  VALUES (?,?)");
        $cadastro->bindValue(1, $tokenpagseguro, PDO::PARAM_STR);
        $cadastro->bindValue(2, $administrador_id, PDO::PARAM_INT);
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
//Gerar Boleto
function pagseguro($id){ //funcao de pega id cliente
    $pdo = conecta();
    try{
        $boleto = $pdo->prepare("SELECT `clientes_nome`, `clientes_email`, `clientes_endereco1`, `clientes_endereco2`, `clientes_cep`, `clientes_data_compra`, `clientes_valor_compra` FROM `clientes` WHERE `id` = ?");
        $boleto->bindValue(1, $id, PDO::PARAM_INT);
        $boleto->execute();
        if ($boleto->rowCount() > 0):
            return $boleto->fetch(PDO::FETCH_OBJ);
        else:
            return FALSE;
        endif;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
