$('.container-p1-img img').click(function() {
    //verifica o tamanho da tela 
    var width = parseInt($('body').css('width'));
    if (width > 700) {


        $('.container-p1-img img').css({ 'opacity': '0.1' });
        $('.pop_up_fundo').css({ 'visibility': 'visible' });
        $('.pop_up').css({ 'visibility': 'visible' });
    }
});

$('.fechar-album img').click(function() {
    sair();
});

var sair = function() {
    //mostra os botoes do menu



    $('.container-p1-img').css({ 'background-color': '#FFF' });
    $('.container-p1-img img').css({ 'opacity': '1' });
    $('.pop_up_fundo').css({ 'visibility': 'hidden' });
    $('.pop_up').css({ 'visibility': 'hidden' });
}