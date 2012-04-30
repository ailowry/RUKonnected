var REFRESH_RATE = 1000;
var POST_CONTAINER_CLASS = 'postarea';
var COMMENT_CONTAINER_CLASS = 'commentarea';
var POST_TEMPLATE_URL = 'templates/post.stache';
var COMMENT_TEMPLATE_URL = 'templates/comment.stache';

/**
 * Starts app
 */
function startApp(friendID) {
    var localData = {};
    localData.users = {};
    localData.postids = [];
    generatePossibleFriends(); 
    populateFriendsList();

    loadTemplates(localData, function(res) {
        var timers = function() {
            getFeed(localData, function(localData) {
                getComments(localData, function(localData) {});
            });
        }
        timers();
        localData.timer = setInterval(timers, REFRESH_RATE);
        localData.dateTimer = setInterval(function() {
            jQuery("abbr.timeago").timeago();
        }, 60000);
    });
}

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
function getFeed(localData, next) {
    var postData = {action: 'getFeed'};
    if(localData.lastFeedUpdate) {
        postData.lastCall = localData.lastFeedUpdate;
    }
    localData.lastFeedUpdate = getUnixTime() - 30;

    $.post('api.php', postData, function(res) {
        var data = $.parseJSON(res);
        $.each(data.posts, function(key, post) {
            localData.postids.push(post.PostID);
        });
        var unknownUsers = checkPostsForUnknownUsers(data.posts,
            localData.users);
        if(unknownUsers) {
            getUserInfo(unknownUsers, function(newNames) {
                localData.users = $.extend(localData.users, newNames);
                renderPosts(data.posts, localData.postTemplate,
                    localData.users);
                next(localData);
            });
        }
        else {
            renderPosts(data.posts, localData.postTemplate, localData.users);
            next(localData);
        }
    });
}

/**
 * Gets all comments by friends and on friend's posts
 * @param localData Local app data
 */
function getComments(localData, next) {
    if(localData.postids) {
        var postData = {action: 'getComments', postids: localData.postids};
        if(localData.lastCommentUpdate) {
            postData.lastCall = localData.lastCommentUpdate;
        }
        localData.lastCommentUpdate = getUnixTime() - 30;

        $.post('api.php', postData, function(res) {
            var comments = $.parseJSON(res);
            renderComments(comments, localData.commentTemplate,
                localData.users);
            next(localData);
        });
    }
    else {
        next(localData);
    }
}

/**
 * Renders an array of comments
 * @param comments An array of comments to render
 * @param template The template to use to render comments
 * @param users An array of user information
 */
function renderComments(comments, template, users) {
    $.each(comments, function(key, comment) {
        if($('div[postid="' + comment.PostID + '"]').length
                && !$('div[commentid="' + comment.CommentID + '"]').length) {
            comment = $.extend(comment, users[comment.UserID]);
            renderComment(comment, template);
        }
    });
    jQuery("abbr.timeago").timeago();
}

/**
 * Render a comment
 * @param comment The comment to render
 * @param template The template to use to render comments
 */
function renderComment(comment, template) {
    var e = Mustache.render(template, comment);
    $('div[class="' + COMMENT_CONTAINER_CLASS + '"]'
        + '[postid="' + comment.PostID + '"]').append(e);
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
 * Makes a post to api from form
 * @param form the form that is sending data
 */
function makePost(form) {
    form = !form ? $('.postform') : form;
    var input = $(':input[name="content"]', form);
    $.post('api.php', {action: 'makePost', content: $(input).val()},
            function(res) {
        $(input).val('');
        if(res) {
            customAlert("Post successful");
        }
    });
}

/**
 * Posts a new comment
 * @param form The form that the comment is coming from
 */
function makeComment(form) {
    var postData = {
        action: 'makeComment',
        postid: $(form).attr('postid'),
        content: $(form).children('textarea').val()
    };
    $.post('api.php', postData, function(res) {
        if(res) {
            customAlert("Comment posted");
        }
    });
}
