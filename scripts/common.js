/**
 * Flashes a alert message on the screen
 */
function customAlert(message) {
    $('.alert').text(message);
    $('.alert').fadeIn(100, function() {
        $('.alert').fadeOut(2000);
    });
}

/**
 * Creates the list of friends it's possible to friend
 */
function generatePossibleFriends() {
    var name = $("#friendfinderinput").val();
    $.post('api.php', {action: 'getPossibleFriends', content: name},
            function(res) {
        $("#friendfinderinput").autocomplete({source: JSON.parse(res)});
        $("#friendfinderinput").autocomplete("enable");
    });
}

/**
 * Friends user(for now)
 */
function makeFriendRequest() {
    var name = $("#friendfinderinput").val();
    $.post('api.php', {action: 'makeFriend', friendname: name}, function(res) {
        if(res) {
            customAlert('Friend Added');
            populateFriendsList();
        }
    });
}

/**
 * Populates the friends list with all of user's friends
 */
function populateFriendsList() {
    $('#friendslist').html('');
    $.post('api.php', {action: 'getFriends'}, function(res) {
        var friends = JSON.parse(res);
        var friendids = [];
        $.each(friends, function(key, val) {
            friendids.push(val.FriendID);
        });
        getUserInfo(friendids, function(users) {
            $.each(users, function(key, user) {
                console.log(user);
                var li = '<li userid="' + key + '"><a href="friend.php?id='
                    + key + '">' + user.displayname + '</a></li>'
                $('#friendslist').append($(li));
            });
        });
    });
}

/**
 * Gets the names of an array of users
 * @param userArray an array of userids to get display names for
 * @param next Callback
 * @returns An associative array of userids and corresponding display names
 */
function getUserInfo(userArray, next) {
    var postData = {action: 'getUserInfo'};
    postData.userids = userArray;
    $.post('api.php', postData, function(res) {
        res = $.parseJSON(res);
        var newUsers = {};
        $.each(res, function(key, row) {
            newUsers[row.id] =
                {displayname: row.displayname, pic: row.ProfilePicAddress};
        });
        next(newUsers); 
    });
}
