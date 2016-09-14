<?php
require_once "wis-twitter/php/lib/WISTwitter.inc.php";
require_once "wis-twitter/php/lib/Tweet.inc.php";

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'Tweet':
			post_tweet($_POST['tweetText']);
            break;
        case 'Refresh':
            get_tweets();
            break;
    }
}

function post_tweet($tweetText) {	
	$tweet = new Tweet('w097rxr', $tweetText);
	$postTweetObj = new WISTwitter();
	$postTweetObj->postTweet($tweet);
}

function get_tweets() {
	$getTweetObj = new WISTwitter();
	$tweets = $getTweetObj->getLatestTweets();

	$tweetArray = array();

	foreach ($tweets as $key => $tweet) {
	   $tweetArray[$key]['author'] = $tweet->getAuthor();
	   $tweetArray[$key]['tweetText'] = $tweet->getTweetText();
	   $tweetArray[$key]['date'] = $tweet->getDate();
	}

	$json_response = json_encode($tweetArray);
	echo $json_response;
}