var REFRESH_RATE = 10000;
var POST_CONTAINER_CLASS = 'postarea';
var POST_TEMPLATE_URL = 'templates/post.stache';
var COMMENT_TEMPLATE_URL = 'templates/comment.stache';

/**
 * Starts app
 */
$(document).ready(function() {
    var localData = {};
    localData.users = {};

    loadTemplates(localData, function(res) {
        getFeed(localData);
        var timers = function() {
            getFeed(localData);
        }
        localData.timer = setInterval(timers, REFRESH_RATE);
    });
});

/**
 * Loads the templates needed for creating content
 * @param localData Local app data
 * @param next Callback
 */
function loadTemplates(localData, next) {
    $.get(POST_TEMPLATE_URL, function(res) {
        localData.postTemplate = res;
        $.get(COMMENT_TEMPLATE_URL, function(res2) {
            localData.commentTemplate = res2;
            next(localData);
        });
    });
}

/**
 * Renders wall from api feed
 * @param localData Local app data
 */
function getFeed(localData) {
    var data = {action: 'getFeed'};
    if(localData.lastUpdate) {
        data.lastCall = localData.lastUpdate
    }
    localData.lastUpdate = getUnixTime();

    $.post('api.php', data, function(res) {
        var data = $.parseJSON(res);
        var unknownUsers = checkPostsForUnknownUsers(data.posts, localData.users);
        if(unknownUsers) {
            getUserInfo(unknownUsers, function(newNames) {
                localData.users = $.extend(localData.users, newNames);
                renderPosts(data.posts, localData.postTemplate, localData.users);
            });
        }
        else {
            renderPosts(data.posts, localData.postTemplate, localData.users);
        }
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
        var userid = post.UserID;
        if(!knownUsers[userid] && $.inArray(userid, unknownUsers) == -1) {
            unknownUsers.push(userid); 
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
        if(!$('div[postid="' + post.PostID + '"]').length) {
            post = $.extend(post, users[post.UserID]);
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
    $('div[class="' + POST_CONTAINER_CLASS + '"]').prepend(e);
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
function makePost(form) {
    form = !form ? $('.postform') : form;
    var input = $(':input[name="content"]', form);
    $.post('api.php', {action: 'makePost', content: $(input).val()}, function(res) {
        $(input).val('');
    });
}
