<?php
    require('./db.php');

    if($_GET['action']) {
        $input = $_GET;
    }
    else if($_POST['action']) {
        $input = $_POST;
    }

    echo $input ? routeAction($input) : 'Error: Improper api call';

    /**
     * Takes a data set and routes it to correct operation
     * @param $input A set of GET or POST data
     * @return Result of routing
     */
    function routeAction($input) {
        // Temporary test value
        $userid = 1;

        $action = $input['action'];
        $err = null;

        if($action == 'getMessages') {
            $response = getMessages($userid);
        }
        else if($action == 'makePost') {
            if($input['friendID']) {
                $response = makePost($userid, $input['content'], $input['friendID']);
            }
            else {
                $response = makePost($userid, $input['content']);
            }
        }
        else if($action == 'getFeed') {
            $response = getFeed($userid);
        }
        else {
            $err = 'Error: Improper api call';
        }

        return $err ? $err : json_encode($response);
    }

    /**
     * Gets an array of all messages user has sent or recieved
     * @param $userid The id of the user requesting messages
     * @return An array of messages the user has sent or recieved
     */
    function getMessages($userid) {
        $userid = (int)$userid;
        $qStr = "SELECT * FROM Messages WHERE (UserID = $userid "
                . "OR FriendID = $userid)";
        $result = mysql_query($qStr);
        return mysql_fetch_assoc($result);
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
        $result = mysql_query($qStr);
        return mysql_fetch_assoc($result);
    }

    /**
     * Gets all posts that user, or a friend of that user, has made or recieved
     * @param $userid The userid of the user
     * @return An array of posts that user or friend of user made or recieved
     */
    function getFeed($userid) {
        $userid_v = (int)$userid;
        $qStr = "SELECT * FROM Friends WHERE UserID = $userid_v";
        $result = mysql_query($qStr);
        $friends = array();
        $friendsRegex = "($userid_v)";
        foreach($result as $row) {
            $fid = $row['FriendID'];
            $friends.push($fid);
            $friendsRegex .= "|($fid)";
        }

        $qStr2 = "SELECT * FROM Posts WHERE UserID REGEXP $friendsRegex "
                 . "OR FriendUserID = $friendsRegex";
        $result2 = mysql_query($qStr2);
        return fetchAllRows($result2);
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
