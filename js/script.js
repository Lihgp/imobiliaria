// Função para quando mexer o scroll mudar o NAV
$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll > 1000) {
        $('.navbar').css('background-color', 'rgb(65, 55, 102)')
    } 
    else {
        $('.navbar').css('background-color', 'rgba(65, 55, 102, 0.616)')
    }
});

//Função para o botão Login
$('.click-login').click(function() {
    debugger
    $('#modal-login').modal("show")
});

//Função para remover mensagem de erro do login
function removeMensagemErro() {
    $('#alerta-invalido').css('display', 'none')
}

//Função para validar o login
$('#enviar-login').click(function () {
    debugger
    var usuario = document.getElementById('user').value;
    var senha = document.getElementById('senha').value;

    if (usuario === 'admin' && senha === 'admin') {
        removeMensagemErro()
        $("#barraNavegacaoPublico").hide()
        $("#barraNavegacaoRestrita").show()
        $('#modal-login').modal("hide")
        //Adicionar um efeito de LOAD
    } else {
        $("#alerta-invalido").fadeIn(200)
        $('#alerta-invalido').css('display', 'inline-block')
        $('#alerta-invalido').css('width', '100%')
        $('#alerta-invalido').text('Usuário ou senha incorreto.')
    }
})

// Função para quando clicar no X do modal, sair a mensagem de erro
$('.close').click(removeMensagemErro())

// Função para quando sair do modal sair a mensagem de erro
$("#modal-login").on('hide.bs.modal', removeMensagemErro());

$('#botaoDivPesquisa').click(function () {
    debugger
  $('#divPesquisa').show();
  $('#divPesquisa2').show();
});
