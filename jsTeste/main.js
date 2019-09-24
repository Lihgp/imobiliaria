// Função para quando mexer o scroll mudar o NAV
$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll > 1000) {
        $('.navbar').addClass('navbar-main');
    } 
    else {
        $('.navbar').removeClass('navbar-main');
    }
});

//Função para o botão Login
$('.click-login').click(function() {
    $('#modal-login').modal("show")
});

//Função para mudar div
$('#enviar-login').click(function () {
    debugger
})