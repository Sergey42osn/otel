$(function () {
    var cookieAgreement = Cookies.get('cookieAgreement');

    if (!cookieAgreement) {
        $('.cookie-agreement').fadeIn(600);
        $('.footer-bottom-part').attr('style','padding-bottom:200px');
    }

    $('.btnCookieAgreement-go').click(function () {
        $('.footer-bottom-part').attr('style','');
        $('.cookie-agreement').fadeOut(600);
        Cookies.set('cookieAgreement', '1', {
            expires: 365,
            path: '/',
            domain: 'ruking.production.am'
        });

    });
});
