$(document).ready(function(){
    var janela =$('#janelamodal');
    var conteudo =$('.modal-body');

    janela.click(function () {
            $.post('ajax/painelcliente.php', {acao:'form_cad_cliente'}, function (retorno) {
                $('#modalcadastrocliente').modal({backdrop:'static'});
                conteudo.html(retorno);
            });
    });

    $('#modalcadastrocliente').on("submit", 'form[name="form_cad_cliente"]', function () {
        var form=$(this);
        var botao= form.find(':button');
        $.ajax({
           url: 'ajax/controllercliente.php',
           type: 'POST',
            data:"acao=cadastro_cliente&"+form.serialize(),
            beforeSend: function () {
                botao.attr('disabled', true);
                $('.load').fadeIn('slow');
            },
            success: function (retorno) {
                botao.attr('disabled', false);
                $('.load').fadeOut('slow');
                if (retorno ==='cadastrou'){
                    form.fadeOut('slow', function () {
                        msg('Cadastrado com sucesso', 'sucesso');
                        listarCliente('ajax/painelcliente.php', 'listar_cliente', true);
                    });
                }else{
                    msg('erro ao cadastrar', 'erro');
                }
            }
        });
        return false;
    });
});

// btn edit
$('.table').on("click", '#btn_edit', function () {
    var id=$(this).attr('data-id');
    var conteudo =$('.modal-body');
    $.post('ajax/painelcliente.php',{acao:'form_edit_cliente', id:id}, function (retorno) {
        $('#modaleditarcliente').modal({backdrop:'static'});
        conteudo.html(retorno);
    });
    return false;
});

//btn atualizar
$('#modaleditarcliente').on("submit", 'form[name="form_edit_cliente"]', function () {
    var dados=$(this);
    var botao= dados.find(':button');
    $.ajax({
       url:'ajax/controllercliente.php',
        type: 'POST',
        data:"acao=edit_cadastro_cliente&"+dados.serialize(),
        beforeSend: function () {
            botao.attr('disabled', true);
            $('.load').fadeIn('slow');
    },
        success: function(retorno){
            if (retorno === 'atualizou'){
                dados.fadeOut('slow', function () {
                    msg('Atualizado com sucesso', 'sucesso');
                    listarCliente('ajax/painelcliente.php', 'listar_cliente', true);
                });
            }else{
                    msg('Você não alterou nenhum dados', 'alerta');
                    $('.load').fadeOut('slow', function () {
                    botao.attr('disabled', false);
                });
            }
    }
    });
    return false;
});

//btn deletar
$('.table').on("click", '#btn_excluir', function () {
    var id=$(this).attr('data-id');
    if(confirm('Você deseja realmente excluir?')){
        $.post('ajax/controllercliente.php',{acao: 'excluir_cliente', id: id}, function (retorno) {
            if (retorno === 'deletou'){
                alert("Deletou com Sucesso");
                listarCliente('ajax/painelcliente.php', 'listar_cliente', true);
            }
        });
    }else{
        return false;
    }
});

//btn vender
$('.table').on("click", '#btn_vender', function () {
    var id=$(this).attr('data-id');
    var conteudo =$('.modal-body');
    $.post('ajax/painelcliente.php',{acao:'form_vender', id:id}, function (retorno) {
        $('#modalvendacliente').modal({backdrop:'static'});
        conteudo.html(retorno);
    });
    return false;
});

$('#modalvendacliente').on("submit", 'form[name="form_vender"]', function () {
    var dados=$(this);
    var botao= dados.find(':button');
    $.ajax({
        url:'ajax/controllercliente.php',
        type: 'POST',
        data:"acao=gerar_venda_cliente&"+dados.serialize(),
        beforeSend: function () {
            botao.attr('disabled', true);
            $('.load').fadeIn('slow');
        },
        success: function(retorno){
            if (retorno === 'vendeu'){
                dados.fadeOut('slow', function () {
                    msg('Venda Efetuada com sucesso', 'sucesso');
                    listarCliente('ajax/painelcliente.php', 'listar_cliente', true);
                });
            }else{
                msg('Erro ao Efetuar Venda', 'alerta');
                $('.load').fadeOut('slow', function () {
                    botao.attr('disabled', false);
                });
            }
        }
    });
    return false;
});

//FUNCOES GERAIS
function listarCliente(url, acao, atualiza) {
    $.post(url, {acao: acao}, function (retorno) {
       var tbody=$('.table').find('tbody');
        var load = tbody.find('.load');
        if (atualiza===true){
            tbody.html(retorno);
        }else   {
                load.fadeOut('slow', function () {
                    tbody.html(retorno);

                    });
                }
    });
}

    listarCliente('ajax/painelcliente.php', 'listar_cliente');


function msg(msg, tipo) {//funcao de mensagem
    var retorno = $('.retorno');
    var tipo = (tipo==='sucesso') ? 'success' : (tipo==='alerta') ? 'warning' : (tipo==='erro') ? 'danger' : (tipo==='info') ? 'info' : alert('Informe mensagens de sucesso, alerta, erro e info');

    retorno.empty().fadeOut('fast', function(){
        return $(this).html('<div class="alert alert-'+tipo+'">'+msg+'</div>').fadeIn('slow');
    });
    setTimeout(function () {
        retorno.fadeOut('slow').empty();
    },4000);
}
