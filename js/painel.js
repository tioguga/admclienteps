$(document).ready(function(){
    var janela =$('#janelamodal');
    var conteudo =$('.modal-body');

    janela.click(function () {
            $.post('ajax/painel.php', {acao:'form_cad'}, function (retorno) {
                $('#modalcadastro').modal({backdrop:'static'});
                conteudo.html(retorno);
            });
    });

    $('#modalcadastro').on("submit", 'form[name="form_cad"]', function () {
        var form=$(this);
        var botao= form.find(':button');
        $.ajax({
           url: 'ajax/controller.php',
           type: 'POST',
            data:"acao=cadastro&"+form.serialize(),
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
                        listarAdmin('ajax/painel.php', 'listar_admin', true);
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
    $.post('ajax/painel.php',{acao:'form_edit', id:id}, function (retorno) {
        $('#modalcadastro').modal({backdrop:'static'});
        conteudo.html(retorno);
    });
    return false;
});

//btn atualizar
$('#modalcadastro').on("submit", 'form[name="form_edit"]', function () {
    var dados=$(this);
    var botao= dados.find(':button');
    $.ajax({
       url:'ajax/controller.php',
        type: 'POST',
        data:"acao=edit_cadastro&"+dados.serialize(),
        beforeSend: function () {
            botao.attr('disabled', true);
            $('.load').fadeIn('slow');
    },
        success: function(retorno){
            if (retorno === 'atualizou'){
                dados.fadeOut('slow', function () {
                    msg('Atualizado com sucesso', 'sucesso');
                    listarAdmin('ajax/painel.php', 'listar_admin', true);
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
        $.post('ajax/controller.php',{acao: 'excluir', id: id}, function (retorno) {
            if (retorno === 'deletou'){
                alert("Deletou com Sucesso")
                listarAdmin('ajax/painel.php', 'listar_admin', true);
            }
        });
    }else{
        return false;
    }
});

//FUNCOES GERAIS
function listarAdmin(url, acao, atualiza) {
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

    listarAdmin('ajax/painel.php', 'listar_admin')


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