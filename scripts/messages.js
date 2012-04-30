var REFRESH_RATE = 1000;
var MESSAGE_CONTAINER_CLASS = 'messagearea';
var MESSAGE_TEMPLATE_URL = 'templates/message.stache';

/**
 * Starts app
 */
$(document).ready(function() {
    var localData = {};
    localData.users = {};
    generatePossibleFriends(); 
    populateFriendsList();

    loadTemplates(localData, function(res) {
        getFeed(localData);
        var timers = function() {
            getFeed(localData);
        }
    timers();
		localData.timer = setInterval(timers, REFRESH_RATE);
    localData.dateTimer = setInterval(function() {
        jQuery("abbr.timeago").timeago();
    }, 60000);
	});	
});

/**
 * Loads the templates needed for creating content
 * @param localData Local app data
 * @param next Callback
 */
function loadTemplates(localData, next) {
    $.get(MESSAGE_TEMPLATE_URL, function(res) {
        localData.messageTemplate = res;
				next(localData);
    });
}

/**
 * Renders wall from api feed
 * @param localData Local app data
 */
function getFeed(localData, friendid) {
		var data = {action: 'getMessages'};
    if(localData.lastUpdate) {
        data.lastCall = localData.lastUpdate
    }
		if(friendid) {
			data.friendid = friendid;
		}
    localData.lastUpdate = getUnixTime();

    $.post('api.php', data, function(res) {
		renderResponse(localData, res, function(localData) {
			$(".msglink").click(function(e){
				e = e.currentTarget;
				console.log(e);
				clearInterval(localData.timer);
				loadMessagesFromFriend($(e).attr("userid"), localData);
			});
		});
	});
}

function renderResponse(localData, res, next) {
	var data = $.parseJSON(res);
	var unknownUsers = checkPostsForUnknownUsers(data, localData.users);
	if(unknownUsers) {
		getUserInfo(unknownUsers, function(newNames) {
			localData.users = $.extend(localData.users, newNames);
			renderPosts(data, localData.messageTemplate, localData.users);
			next(localData);
		});
	}
	else {
		renderPosts(data, localData.messageTemplate, localData.users);
			next(localData);
	}
}

function loadMessagesFromFriend( friendid, localData ) {
	$(".messagearea").html("");
	console.log(friendid);
	$.post("api.php", {action: "getMessages", friendid: friendid}, function(res) {
		renderResponse(localData, res, function(){});
	});
}

/**
 * Takes a set of posts and determines if any of the user's names are unknown
 * @param posts Posts to look for unknown users in
 * @param knownUsers Associative array of known display names
 * @returns An array of ids for users whose names are not known
 */
function checkPostsForUnknownUsers(posts, knownUsers) {
    var unknownUsers = [];
    $.each(posts.reverse(), function(key, post) {
        var userid = post.SenderID;
        var friendid = post.ReceiverID;
        if(!knownUsers[userid] && $.inArray(userid, unknownUsers) == -1) {
            unknownUsers.push(userid); 
        }
        if(!knownUsers[friendid] && $.inArray(friendid, unknownUsers) == -1) {
            unknownUsers.push(friendid); 
        }
    });
    return unknownUsers.length > 0 ? unknownUsers : null;
}

/**
 * Takes an array of posts and renders them on the wall
 * @param posts An array of posts to render
 * @param template The template to use when rendering posts
 * @param users An array of display names that may be used for rendering posts
 */
function renderPosts(posts, template, users) {
    $.each(posts, function(key, post) {
        if(!$('div[msgid="' + post.MessageID + '"]').length) {
            var uid = (post.SenderID != currentuser ? post.SenderID : post.ReceiverID);
			post.LinkID = uid;
            post.direction = uid == post.SenderID ? 'From' : 'To';
            post = $.extend(post, users[uid]);
            renderPost(post, template);
        }
    });
}

/**
 * Renders a post on the wall
 * @param post The post to be rendered
 * @param template The template to use when rendering the post
 */
function renderPost(post, template) {
    var e = Mustache.render(template, post);
	$('div[class="' + MESSAGE_CONTAINER_CLASS + '"]').prepend(e);
}

/**
 * Gets the current time in linux format
 * @returns The current time in linux format
 */
function getUnixTime() {
    return Math.round(new Date().getTime() / 1000); 
}

/**
 * Gets the names of an array of users
 * @param userArray an array of userids to get display names for
 * @param next Callback
 * @returns An associative array of userids and corresponding display names
 */
function getUserInfo(userArray, next) {
    var data = {action: 'getUserInfo'};
    data.userids = userArray;
    $.post('api.php', data, function(res) {
        res = $.parseJSON(res);
        var newUsers = {};
        $.each(res, function(key, row) {
            newUsers[row.id] =
                {displayname: row.displayname, pic: row.ProfilePicAddress};
        });
        next(newUsers); 
    });
}

/**
 * Makes a post to api from form
 * @param form the form that is sending data
 */
function makeMessage(form) {
    form = !form ? $('.msgform') : form;
    var input = $(':input[name="content"]', form);
    $.post('api.php', {action: 'makeMessage', content: $(input).val(), 
				friendid: $(input).attr('friendid')}, function(res) {
					$(input).val('');
    });
}
