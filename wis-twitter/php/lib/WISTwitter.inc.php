<?php

require_once "Tweet.inc.php";
ini_set('allow_url_fopen', true);

class WISTwitter {
    /**
     * @access private
     */
    private static $WIS_TWITTER_SERVER_URL = 'http://knoesis-hpco.cs.wright.edu/wis-twitter/tweets';

    /**
     * Posts a tweet to the WISTwitter server
     * @param Tweet $tweet Tweet containing author and tweet text to be posted.
     * @exception if the posted tweet was invalid. If thrown, use
     * $ex->getMessage() to get the reason.
     */
	 
    public static function postTweet($tweet) {

        $url = self::$WIS_TWITTER_SERVER_URL;

        $data = json_encode(array('userId' => $tweet->getAuthor(), 'text' => $tweet->getTweetText()));

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n"
                    . "Content-Length: " . strlen($data) . "\r\n",
                'method'  => 'POST',
                'content' => $data,
                'ignore_errors' => TRUE
            )
        );

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $status = $http_response_header[0];

        if ($status != "HTTP/1.1 201 Created") {
            $response_json = json_decode($response);
            throw new Exception($response_json->message);
        }
    }

    /**
     * Get the list of latest Tweets from the WISTwitter server
     * @return Tweet[] An array of Tweet objects representing the latest tweets
     * @exception An exception is thrown if there was a problem communicating with the remote WISTwitter server. Please check your internet connection, then contact alan@knoesis.org and pavan@knoesis.org if the problem persists.
     */
    public static function getLatestTweets() {

        $url = self::$WIS_TWITTER_SERVER_URL;

        $options = array(
            'http' => array(
                'method'  => 'GET'
            )
        );

        $context  = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        if ($response === FALSE || ($response_arr = json_decode($response)) === NULL) {
            throw new Exception("There was a problem communicating with the remote WISTwitter server. Please check your internet connection, then contact alan@knoesis.org and pavan@knoesis.org if the problem persists.");
        }

        $ret_arr = array();

        if (count($response_arr) > 0) {
            foreach ($response_arr as $tweet) {
                array_push($ret_arr, new Tweet($tweet->userId, $tweet->text, $tweet->timestamp));
            }
        }

        return $ret_arr;
    }
}
