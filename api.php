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
			if(isset($input['friendid']) && $input['friendid'] != '') {
				$response = getMessagesFromFriend($userid, $input['friendid']);
			}
			else {
				$response = getNewestMessages($userid);
			}
        }
        else if($action == 'makePost') {
            if($input['friendid']) {
                $response = makePost($userid, $input['content'],
                    $input['friendid']);
            }
            else {
                $response = makePost($userid, $input['content']);
            }
        }
				else if($action == 'makeMessage') {
					$response = makeMessage($userid, $input['content'], 
										$input['friendid']);
				}
        else if($action == 'makeComment') {
            $response = makeComment($userid, $input['content'],
                $input['postid']);
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
        else if($action == 'getComments') {
            if($input['postids']) {
                $response = getComments($userid, $input['postids'],
                    $input['lastCall']);
            }
            else {
                $response = getComments($userid, null, $input['lastCall']);
            }
        }
        else if($action == 'getPossibleFriends') {
            $response = getSimilarNames($input['content']);
        }
        else if($action == 'makeFriend') {
            $friendid = getUserIdFromName($input['friendname']);
            $response = makeFriend($userid, $friendid);
        }
        else if($action == 'getFriends') {
            $response = getFriends($userid);
        }
        else {
            $err = 'Error: Improper api call';
        }

        return $err ? $err : json_encode($response);
    }
?>
