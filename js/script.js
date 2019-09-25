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
    $('#modal-login').modal("show")
});

//Função para o botão Sair
$('.click-sair').click(function() {
    //Fazer ir pra página inicial
    window.location.href = ((window.origin).concat('/html/Imobiliaria.html'));
});

//Função para remover mensagem de erro do login
function removeMensagemErro() {
    $('#alerta-invalido').css('display', 'none')
}

//Função para validar o login
$('#enviar-login').click(function () {
    var usuario = document.getElementById('user').value;
    var senha = document.getElementById('senha').value;

    if (usuario === 'admin' && senha === 'admin') {
        removeMensagemErro()
        $("#barraNavegacaoRestrita").show()
        $("#barraNavegacaoPublico").hide()
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

//Funções para pesquisar - TELA LISTAGEM
$('.pesquisar-funcionario').click(function (){
    window.location.href = ((window.origin).concat('/html/Listagem/ListagemFuncionario.html'));
});

$('.pesquisar-cliente').click(function (){
    window.location.href = ((window.origin).concat('/html/Listagem/ListagemCliente.html'));
});

$('.pesquisar-imoveis').click(function (){
    window.location.href = ((window.origin).concat('/html/Listagem/ListagemImoveis.html'));
});

$('.pesquisar-interesses').click(function (){
    window.location.href = ((window.origin).concat('/html/Listagem/ListagemInteresses.html'));
});

//Função para ir na tela PESQUISAR IMÓVEIS
$('.buscar-imoveis').click(function (){
    window.location.href = ((window.origin).concat('/html/Pesquisa.html'));
});

$('#botaoDivPesquisa').click(function () {
    debugger
  $('#divPesquisa').show();
  $('#divPesquisa2').show();
});
