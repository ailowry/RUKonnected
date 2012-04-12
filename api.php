<?php
	require_once('auth.php');
    require('./apiFunctions.php');

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
        $userid = $_SESSION['SESS_MEMBER_ID'];
        $action = $input['action'];
        $err = null;

        if($action == 'getMessages') {
            $response = getMessages($userid);
        }
        else if($action == 'makePost') {
            if($input['friendid']) {
                $response = makePost($userid, $input['content'], $input['friendid']);
            }
            else {
                $response = makePost($userid, $input['content']);
            }
        }
        else if($action == 'getFeed') {
            $response = getFeed($userid, $input['lastCall']);
        }
        else if($action == 'makeFriendRequest') {
            $response = makeFriendRequest($userid, $input['friendid']);
        }
        else if($action == 'likePost') {
            $response = likePost($userid, $input['postid']);
        }
        else if($action == 'getUserInfo') {
            $response = getUserInfo($input['userids']);
        }
        else {
            $err = 'Error: Improper api call';
        }

        return $err ? $err : json_encode($response);
    }

