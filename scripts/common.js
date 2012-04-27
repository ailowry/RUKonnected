function customAlert(message) {
    $('.alert').text(message);
    $('.alert').fadeIn(100, function() {
        $('.alert').fadeOut(2000);
    });
}

function generatePossibleFriends() {
    var name = $("#friendfinderinput").val();
    $.post('api.php', {action: 'getPossibleFriends', content: name},
            function(res) {
                console.log(res);
                console.log(JSON.parse(res));
        $("#friendfinderinput").autocomplete({source: JSON.parse(res)});
        $("#friendfinderinput").autocomplete("enable");
    });
}

function makeFriendRequest() {
    var name = $("#friendfinderinput").val();
    $.post('api.php', {action: 'makeFriend', friendname: name},
            function(res) {
        if(res) {
            customAlert(res);
        }
    });
}
