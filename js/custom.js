$(document).ready(function(){
	$('form[name="form_login"]').submit(function (){
        var forma=$(this);
        var botao=$(this).find(':button');
        $.ajax({
            url:"ajax/controller.php",
            type:"POST",
            data:"acao=login&"+forma.serialize(),
            beforeSend: function(){
                botao.html('Aguarde').attr('disabled', true);
            },
            success: function(retorno){
                botao.attr('disabled',false).html('<span class="glyphicon glyphicon-user"></span> Logar');
                if(retorno==='empty'){
                    msg('É preciso digitar o Login e a Senha para continuar', 'alerta');
                } else if(retorno==='noif'){
                    msg('Login e/ou Senha diferentes', 'erro');
                } else if(retorno==='diffpass'){
                    msg('Login e/ou Senha diferentes', 'erro');
                } else if(retorno==='non'){
                    msg('Você não tem acesso a Essa Area', 'alerta');
                } else {
                    forma.fadeOut('fast',function(){
                        msg('Login Efetudo com Sucesso, Aguarde...', 'sucesso');
                        $('#load').fadeIn('slow');
                    });
                    setTimeout(function () {
                        $(location).attr('href','painelcliente.php')
                    }), 3000;
                }
            },
        });
	    return false;
    });
});
//Funcoes Gerais
function msg(msg, tipo) {
    var retorno = $('.retorno');
    var tipo = (tipo==='sucesso') ? 'success' : (tipo==='alerta') ? 'warning' : (tipo==='erro') ? 'danger' : (tipo==='info') ? 'info' : alert('Informe mensagens de sucesso, alerta, erro e info');

    retorno.empty().fadeOut('fast', function(){
        return $(this).html('<div class="alert alert-'+tipo+'">'+msg+'</div>').fadeIn('slow');
    });

    setTimeout(function () {
           retorno.fadeOut('slow').empty();
    },4000);
}