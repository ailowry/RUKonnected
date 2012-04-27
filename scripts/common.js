function customAlert(message) {
    $('.alert').text(message);
    $('.alert').fadeIn(100, function() {
        $('.alert').fadeOut(2000);
    });
}
