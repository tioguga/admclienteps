<?php
session_start();
require '../funcoes/banco/conexao.php';
//Gerar Boleto
$id=$_GET['id'];
function gerarboleto($id){ //funcao de pega id cliente
    $pdo = conecta();
    try{
        $boleto = $pdo->prepare("SELECT `clientes_nome`, `clientes_endereco1`, `clientes_endereco2`, `clientes_data_compra`, `clientes_valor_compra`, `clientes_dias_pagar`FROM `clientes` WHERE `id` = ?");
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
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers?o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est? dispon?vel sob a Licen?a GPL dispon?vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc? deve ter recebido uma c?pia da GNU Public License junto com     |
// | esse pacote; se n?o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora??es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo?o Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena??o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Ita?: Glauber Portella                        |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DIN?MICOS DO SEU CLIENTE PARA A GERA??O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul?rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

$dadosadm = $_SESSION['administrador'];
$dadoscliente = gerarboleto($id);


// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = $dadoscliente->clientes_dias_pagar;
$taxa_boleto = 0.00;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = "$dadoscliente->clientes_valor_compra"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = '28121983';  // Nosso numero - REGRA: M?ximo de 8 caracteres!
$dadosboleto["numero_documento"] = '0001';	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss?o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v?rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$dadoscliente->clientes_nome";
$dadosboleto["endereco1"] = "$dadoscliente->clientes_endereco1";
$dadosboleto["endereco2"] = "echo $dadoscliente->clientes_endereco2;";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra efetuado de $dadosadm->administrador_nome";
$dadosboleto["demonstrativo2"] = "Pagamento Unico<br>Taxa banc?ria - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "Sistema TioGuga Empreendimentos";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, N?o Receber ap?s o vencimento";
$dadosboleto["instrucoes2"] = "- ";
$dadosboleto["instrucoes3"] = "- Em caso de d?vidas entre em contato conosco: $dadosadm->administrador_telefone";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo Sistema TioGuga Empreendimentos";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURA??O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - ITA?
$dadosboleto["agencia"] = "$dadosadm->administrador_agencia"; // Num da agencia, sem digito
$dadosboleto["conta"] = "$dadosadm->administrador_conta";	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "$dadosadm->administrador_dv_conta"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITA?
$dadosboleto["carteira"] = "175";  // C?digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = "$dadosadm->administrador_nome";
$dadosboleto["cpf_cnpj"] = "$dadosadm->administrador_cpf";
$dadosboleto["endereco"] = "$dadosadm->administrador_endereco1";
$dadosboleto["cidade_uf"] = "$dadosadm->administrador_endereco2";
$dadosboleto["cedente"] = "$dadosadm->administrador_nome";

// N?O ALTERAR!
include("include/funcoes_itau.php"); 
include("include/layout_itau.php");