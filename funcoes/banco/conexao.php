<?php
//CONSTANTES
define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '');
define('DB', 'adminboleto');
//FUNCAO DE CONEXAO
function conecta(){
    $dns = "mysql:host=" . HOST . ";dbname=" . DB;
    try{
        $conn=new PDO($dns, USUARIO, SENHA);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $conn; //Retorna a conexão com o Banco!
    }catch(PDOException $erro){
        echo $erro->getMessage();
    }
}