<?php
/**
 * Gets an array of all messages user has sent or recieved
 * @param $userid The id of the user requesting messages
 * @return An array of messages the user has sent or recieved
 */
function getMessages($userid) {
    $userid_v = (int)$userid;
    $qStr = "SELECT * FROM Messages WHERE (UserID = $userid_v "
            . "OR FriendID = $userid_v)";
    $result = mysql_query($qStr);
    return fetchAllRows($result);
}

/**
 * Makes a post to the users wall, or a friends wall
 * @param $userid The id of the user making the post
 * @param $content the content of the post
 * @param $friendid The id of the friend to post to
 * @return True if post was success, error if post failed
 */
function makePost($userid, $text, $friendid = null) {
    $userid_v = (int)$userid;
    $text_v = mysql_real_escape_string($text);
    if($friendid) {
        $friendid_v = (int)$friendid;
        $qStr = "INSERT INTO Posts(UserID, PostContent, FriendUserID, "
                . "Time) VALUES($userid_v, '$text_v', $friendid_v, NOW())";
    }
    else {
        $qStr = "INSERT INTO Posts(UserID, PostContent, Time) "
                . "VALUES($userid_v, '$text_v', NOW())";
    }
    return mysql_query($qStr) ? true : mysql_error;
}

/**
 * Gets all posts that user, or a friend of that user, has made or recieved
 * @param $userid The userid of the user
 * @param $fromTime The cutoff point for items being too old to be relevent
 * @return An array of posts that user or friend of user made or recieved
 */
function getFeed($userid, $fromTime = null, $limitPosts = true) {
    $userid_v = (int)$userid;
    if($fromTime != null) {
        $fromTime_v = (int)$fromTime;
    }
    $qStr = "SELECT * FROM Friends WHERE UserID = $userid_v";
    $result = fetchAllRows(mysql_query($qStr));
    $friends = array();
    $friendsRegex = "($userid_v)";
    foreach($result as $row) {
        $fid = $row['FriendID'];
        $friends[] = $fid;
        $friendsRegex .= "|(^$fid$)";
    }

    $qStr2 = "SELECT * FROM Posts WHERE (UserID REGEXP '$friendsRegex' "
        . "OR FriendUserID REGEXP '$friendsRegex')"
        . ($fromTime_v ? " AND Time > FROM_UNIXTIME($fromTime_v)" : '')
        . " ORDER BY Time" . ($limitPosts ? " LIMIT 20" : '');
    $result2 = mysql_query($qStr2);
    $retval['posts'] = fetchAllRows($result2);
    $qStr3 = "SELECT Likes.UserID, Likes.PostID, Likes.Time "
        . "FROM Likes JOIN Posts ON Likes.PostID = Posts.PostID "
        . "WHERE (Posts.UserID REGEXP '$friendsRegex' OR FriendUserID REGEXP '$friendsRegex')"
        . ($fromTime_v ? " AND Likes.Time > FROM_UNIXTIME($fromTime_v)" : '');
    $result3 = mysql_query($qStr3);
    $retval['likes'] = fetchAllRows($result3);
    return $retval;
}

/**
 * Sends a friend request
 * @param $userid ID of user sending request
 * @param $friendid ID of friend recieving request
 * @return Returns true on success, an error on failure
 */
function makeFriendRequest($userid, $friendid) {
    $userid_v = (int)$userid;
    $friendid_v = (int)$friendid;
    $qStr = "INSERT INTO FriendRequests(UserID, FriendID, Time) "
            . "VALUES($userid_v, $friendid_v, NOW())";
    return mysql_query($qStr) ? true : mysql_error;
}

/**
 * Like a post
 * @param $userid the user liking the post
 * @param $postid the post to like
 * $return true if successful, error if not succesful
 */
function likePost($userid, $postid) {
    $userid_v = (int)$userid;
    $postid_v = (int)$postid;
    $qStr = "INSERT INTO Likes(UserID, PostID, Time) "
        . "VALUES($userid_v, $postid_v, NOW())";
    return mysql_query($qStr) ? true : mysql_error;
}

/**
 * Get display names and picture urls for an array of users
 * @param $userids the ids of users to look up
 * @returns an array of information about users
 */
function getUserInfo($userids) {
    $usersRegex = '';
    foreach($userids as $id) {
        $id_v = (int)$id;
        $usersRegex .= "|(^$id_v$)";
    }
    $usersRegex = preg_replace('/^\|/', '', $usersRegex);
    $qStr = "SELECT id, CONCAT(fname, ' ', lname) AS displayname, ProfilePicAddress "
        . "FROM Users WHERE id REGEXP '$usersRegex'";
    $result = mysql_query($qStr);
    return fetchAllRows($result);
}

/**
 * Fetches all rows from a database result
 * @param $result the database result object to fetch rows from
 * @return An Assoc array of results rows
 */
function fetchAllRows($result) {
    $rows = array();
    while($row = mysql_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
?>
