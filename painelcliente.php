<?php
ob_start(); session_start();
require 'funcoes/banco/conexao.php';
require 'funcoes/login/login.php';
require 'funcoes/crud/crudcliente.php';
logado('administrador');
if (isset($_GET["logout"]) && $_GET["logout"]=="true"):
    session_destroy();
    header("Location: index.php");
endif;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Adm. Clientes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/estilos.css" rel="stylesheet" media="screen">

    </head>
    <body>

        <nav class="navbar navbar-default" role="navigation">
            <div class="container">


                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Administrar Clientes</a>
                    <?php
                    $nivel = $_SESSION['administrador']->administrador_nivel;
                    if ($nivel == 1):
                    ?>
                        <a class="navbar-brand" href="painel.php">Administrar Moderadores</a>
                    <?php
                    endif;
                    ?>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">

                    <p class="pull-right logout">
                    	Bem Vindo: <?php echo $_SESSION['administrador']->administrador_nome ?> &nbsp
                        <a href="?logout=true" class="btn btn-danger" >Sair</a>
                    </p>
                    <p class="pull-right logout">
                      <a href="#" class="btn btn-success" id="cadastrartoken">Cadastrar Token</a>
                    </p>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <h2 class="linha">Clientes</h2>
                    <div class="box">

                                <div class="box-content nopadding">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Telefone</th>
                                                <th>E-mail</th>
                                                <th>Endereço</th>
                                                <th>Data da Compra</th>
                                                <th>Valor da Compra</th>
                                                <th width="150">Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                 <td colspan="5"><img src="imagem/imgload.gif" class="load" alt="Carregando"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <h2 class="linha">Menu</h2>
                    <div class="bloco">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge"><?php echo count(listarCliente()); ?></span>
                                Registros
                            </li>
                        </ul>

                        <div class="list-group">
						  <a href="#" class="list-group-item active">Administrar</a>
						  <a href="#" class="list-group-item" id="janelamodal">Cadastrar</a>
						</div>


                    </div>

                </div>

            </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalcadastrocliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Cadastro</h4>
                            </div>
                            <div class="modal-body"></div>
                        </div>
                    </div>
                    </div> <!-- /.Modal -->
            <!-- Modal -->
            <div class="modal fade" id="modaleditarcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Editar Cliente</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div> <!-- /.Modal -->
            <!-- Modal -->
            <div class="modal fade" id="modalvendacliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Efetuar Venda</h4>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div> <!-- /.Modal -->
        </div>
        <script type="text/javascript" src="js/jquery-3.1.0.js"></script>
        <script type="text/javascript" src="js/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/painelcliente.js"></script>
        <script type="text/javascript" src="js/maskedinput.min.js"></script>
        <!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
        <form action="https://pagseguro.uol.com.br/checkout/v2/donation.html" method="post">
            <!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
            <input type="hidden" name="currency" value="BRL" />
            <input type="hidden" name="receiverEmail" value="era.jogos.1@gmail.com" />
            <input type="hidden" name="iot" value="button" />
            <input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/doacoes/209x48-doar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
        </form>
        <!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
    </body>

</html>
