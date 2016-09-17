<?php
require '../funcoes/banco/conexao.php';
require '../funcoes/crud/crud.php';
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) :
    case 'form_cad': //FAZ A INTERACAO
?>
        <div class="retorno"></div>
        <form action="" name="form_cad" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Digite o Nome">
            </div>
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" name="login" placeholder="Digite o Login">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" placeholder="Digite a Senha">
            </div>
            <div class="form-group">
                <label for="ddd">DDD</label>
                <input type="text" class="form-control" name="ddd" placeholder="Digite o DDD">
            </div>
            <div class="form-group">
                <label for="telefone">telefone</label>
                <input type="text" class="form-control" name="telefone" placeholder="Digite o Telefone">
            </div>
            <div class="form-group">
                <label for="endereco1">Endereço 1</label>
                <input type="text" class="form-control" name="endereco1" placeholder="Digite a Rua, Nº da casa e o Bairro">
            </div>
            <div class="form-group">
                <label for="endereco2">Endereço 2</label>
                <input type="text" class="form-control" name="endereco2" placeholder="Digite a Cidade e o Estado">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" name="cep" placeholder="Digite o CEP">
                </div>
                <div class="form-group">
                <label for="nomebanco">Nome do Banco</label>
                <input type="text" class="form-control" name="nomebanco" placeholder="Digite o Nome do Banco">
            </div>
            <div class="form-group">
                <label for="agencia">Agencia</label>
                <input type="text" class="form-control" name="agencia" placeholder="Digite o Numero da Agencia">
            </div>
            <div class="form-group">
                <label for="conta">Conta</label>
                <input type="text" class="form-control" name="conta" placeholder="Digite o Numero da Conta">
            </div>
            <div class="form-group">
                <label for="dv">DV</label>
                <input type="text" class="form-control" name="dv" placeholder="Digite o DV da Conta">
            </div>
            <div class="form-group">
                <label for="nivel">Nivel</label>
                <select class="form-control" name="nivel">
                    <option value="disabled">Escolha uma Opção</option>
                    <option value="1">Administrador</option>
                    <option value="2">Moderador</option>
                 </select>
            </div>

            <div class="checkbox">

            <p class="pull-right">
                <img src="imagem/imgload.gif" class="load" alt="carregando" style="display: none" />
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </p>
            </div>

        </form>
<?php
        break;
    case 'listar_admin': //lista admin
            if (listarAdmin()):
                $admin = listarAdmin();
                foreach ($admin as $adm):
                    $nivel=($adm->administrador_nivel == 1) ? 'Admin' : 'Moderador';
                    ?>
                    <tr>
                        <td><?php echo $adm->administrador_nome; ?></td>
                        <td><?php echo "$adm->administrador_telefone_ddd"."$adm->administrador_telefone"; ?></td>
                        <td><?php echo $adm->administrador_email; ?></td>
                        <td><?php echo $adm->administrador_login; ?></td>
                        <td><?php echo $nivel; ?></td>
                        <td>
                            <a href="#" id="btn_edit" data-id="<?php echo $adm->id; ?>" class="btn btn-warning">Editar</a>
                            <a href="#" id="btn_excluir"  data-id="<?php echo $adm->id; ?>" class="btn btn-danger">Excluir</a>
                        </td>
                    <?php
                endforeach;
            else:


            endif;
        break;

    case 'form_edit' :
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $dados = pegaId($id);
        ?>

        <div class="retorno"></div>
        <form action="" name="form_edit" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" value="<?php echo $dados->administrador_nome; ?>" class="form-control" placeholder="Digite o Nome">
            </div>
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" name="login" value="<?php echo $dados->administrador_login; ?>" class="form-control" placeholder="Digite o Login">
            </div>
            <div class="form-group">
                <label for="ddd">DDD</label>
                <input type="text" name="ddd" value="<?php echo $dados->administrador_ddd; ?>" class="form-control" placeholder="Digite o DDD">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" value="<?php echo $dados->administrador_telefone; ?>" class="form-control" placeholder="Digite o Telefone">
            </div>
            <div class="form-group">
                <label for="endereco1">Endereço 1</label>
                <input type="text" class="form-control" name="endereco1" value="<?php echo $dados->administrador_endereco1; ?>" placeholder="Digite a Rua, Nº da casa e o Bairro">
            </div>

            <div class="form-group">
                <label for="endereco2">Endereço 2</label>
                <input type="text" class="form-control" name="endereco2" value="<?php echo $dados->administrador_endereco2; ?>" placeholder="Digite a Cidade e o Estado">
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" name="cep" value="<?php echo $dados->administrador_cep; ?>" placeholder="Digite o CEP">
            </div>
            <div class="form-group">
                <label for="nomebanco">Nome do Banco</label>
                <input type="text" class="form-control" name="nomebanco" value="<?php echo $dados->administrador_banco; ?>"placeholder="Digite o Nome do Banco">
            </div>
            <div class="form-group">
                <label for="agencia">Agencia</label>
                <input type="text" class="form-control" name="agencia" value="<?php echo $dados->administrador_agencia; ?>" placeholder="Digite o Numero da Agencia">
            </div>
            <div class="form-group">
                <label for="conta">Conta</label>
                <input type="text" class="form-control" name="conta" value="<?php echo $dados->administrador_conta; ?>"placeholder="Digite o Numero da Conta">
            </div>
            <div class="form-group">
                <label for="dv">DV</label>
                <input type="text" class="form-control" name="dv" value="<?php echo $dados->administrador_dv_conta; ?>" placeholder="Digite o DV da Conta">
            </div>
            <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $dados->id; ?>" class="form-control">
            </div>
            <div class="form-group">
                <input type="hidden" name="token_pagseguro" value="<?php echo $dados->id; ?>" class="form-control">
            </div>
            <div class="checkbox">

            <p class="pull-right">
                <img src="imagem/imgload.gif" class="load" alt="carregando" style="display: none" />
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </p>
            </div>

        </form>
<?php

    break;
    default :
        echo 'Nada';
        break;
endswitch;
