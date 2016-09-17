<?php
ob_start(); session_start();
require '../funcoes/banco/conexao.php';
require '../funcoes/crud/crudcliente.php';
include_once '../funcoes/login/login.php';
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
switch ($acao) :
    case 'form_cad_cliente': //FAZ A INTERACAO
        $adm_id = $_SESSION['administrador']->id;
        ?>
        <div class="retorno"></div>
        <form action="" name="form_cad_cliente" method="post">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Digite o Nome">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Digite o telefone">
            </div>
            <div class="form-group">
                <label for="telefone_ddd">DDD</label>
                <input type="text" class="form-control" name="telefone_ddd" placeholder="Digite o DDD">
            </div>
            <div class="form-group">
                <label for="telefone">telefone</label>
                <input type="text" class="form-control" name="telefone" placeholder="Digite o telefone">
            </div>
            <div class="form-group">
                <label for="endereco1">Endereço 1</label>
                <input type="text" class="form-control" name="endereco1" placeholder="Digite a Rua, Bairro e o Nº da casa">
            </div>

            <div class="form-group">
                <label for="endereco2">Endereço 2</label>
                <input type="text" class="form-control" name="endereco2" placeholder="Digite a Cidade e o Estado">
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" name="cep" placeholder="Digite o CEP">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" name="id-adm" value="<?php echo $adm_id; ?>">
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

    case 'listar_cliente': //lista admin
            if (listarCliente()):
                $cliente = listarCliente();
                foreach ($cliente as $cli):
                    ?>
                    <tr>
                        <td><?php echo $cli->clientes_nome; ?></td>
                        <td><?php echo "$cli->clientes_telefone_ddd"."$cli->clientes_telefone"; ?></td>
                        <td><?php echo $cli->clientes_email; ?></td>
                        <td><?php echo "$cli->clientes_endereco1"."<br/>$cli->clientes_endereco2"."<br/>$cli->clientes_cep"; ?></td>
                        <td><?php echo $cli->clientes_data_compra; ?></td>
                        <td><?php echo $cli->clientes_valor_compra; ?></td>
                        <td>
                            <a href="#" id="btn_edit" data-id="<?php echo $cli->id; ?>" class="btn btn-warning">Editar</a>
                            <a href="#" id="btn_excluir"  data-id="<?php echo $cli->id; ?>" class="btn btn-danger">Excluir</a>
                            <a href="#" id="btn_vender"  data-id="<?php echo $cli->id; ?>" class="btn btn-success">Efet. Venda</a>
                            <input type="image" name="submit" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" alt="Pague com PagSeguro">
                        </td>
                    <?php
                endforeach;
            else:
            endif;
        break;

    case 'form_edit_cliente' :
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $dados = pegaIdcliente($id);
        ?>

        <div class="retorno"></div>
        <form action="" name="form_edit_cliente" method="post">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" value="<?php echo $dados->clientes_nome; ?>" class="form-control" placeholder="Digite o Nome">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="telefone" value="<?php echo $dados->clientes_email; ?>" class="form-control" placeholder="Digite o e-mail">
                </div>
                <div class="form-group">
                    <label for="telefone_ddd">DDD</label>
                    <input type="text" name="telefone" value="<?php echo $dados->clientes_telefone_ddd; ?>" class="form-control" placeholder="Digite o ddd">
                </div>
                <div class="form-group">
                    <label for="telefone">telefone</label>
                    <input type="text" name="telefone" value="<?php echo $dados->clientes_telefone; ?>" class="form-control" placeholder="Digite o telefone">
                </div>
                <div class="form-group">
                    <label for="endereco1">Endereço 1</label>
                    <input type="text" name="endereco1" value="<?php echo $dados->clientes_endereco1; ?>" class="form-control" placeholder="Digite a Rua, Nº da casa e o Bairro">
                </div>
                <div class="form-group">
                    <label for="endereco2">Endereço 2</label>
                    <input type="text" name="endereco2" value="<?php echo $dados->clientes_endereco2; ?>" class="form-control" placeholder="Digite a Cidade, Estado">
                </div>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" value="<?php echo $dados->clientes_cep; ?>" class="form-control" placeholder="Digite o CEP">
                </div>
                <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $dados->id; ?>" class="form-control">
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
    // Gerar Boleto Bancario
    case 'form_vender' :
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $dados = pegaIdcliente($id);
        ?>
        <div class="retorno"></div>
        <form action="" name="form_vender" method="post">
            <div class="form-group">
                <label for="datacompra">Data da Compra</label>
                <input type="date" name="datacompra" value="<?php echo date("d/m/y") ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="valorcompra">Valor da Compra</label>
                <input type="text" name="valorcompra" value="" class="form-control" placeholder="Digite o Valor da Compra">
            </div>
            <div class="form-group">
                <label for="diaspagar">Quant. Dias p/ Pagar</label>
                <input type="number" name="diaspagar" value="" class="form-control" placeholder="Digite a Quantidade de Dias à Pagar">
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $dados->id; ?>" class="form-control">
            </div>
            <div class="checkbox">

                <p class="pull-right">
                    <img src="imagem/imgload.gif" class="load" alt="carregando" style="display: none" />
                    <button type="submit" class="btn btn-primary">Efetuar Venda</button>
                </p>
            </div>
        </form>
        <?php
        break;
    default :
        echo 'Nada';
        break;
endswitch;
ob_end_flush();
