<?php

class Tweet {
    
    private $author;
    private $tweetText;
    private $date;
    
    function __construct($author, $tweetText, $date = NULL) {
        $this->author = $author;
        $this->tweetText = $tweetText;
		$this->date = $date;
    }
    
    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getTweetText() {
        return $this->tweetText;
    }

    public function setTweetText($tweet) {
        $this->tweetText = $tweet;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }    
}

?>