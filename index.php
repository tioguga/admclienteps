<?php
session_start();
require 'funcoes/banco/conexao.php';
conecta();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Cadastro de Clientes e Impressão de Boleto</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/estilos.css" rel="stylesheet" media="screen">

    </head>
    <body>

        <div class="container">
            <div class="login">
                <h2>ÁREA RESTRITA</h2>
                <div class="retorno"></div>
                <form action="" class="form" method="post" name="form_login">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" class="form-control input-lg" placeholder="Login">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Senha</label>
                        <input type="password" name="senha" class="form-control input-lg" placeholder="Senha">
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-user"></span> Logar</button>
                </form>
                <center><img src="imagem/imgload.gif" align="center" id="load" alt="carregando" style="display: none;" /></center>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-3.1.0.js"></script>
        <script type="text/javascript" src="js/jquery-2.2.4.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
    </body>
</html>
