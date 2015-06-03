<?php

class Messages {

    //TODO: Proper message wrapping
    private $messageBefore;
    private $messageAfter;

    function __construct() {
        if(!isset($_SESSION)) session_start();

        if(!array_key_exists('flash_messages', $_SESSION)) $_SESSION['flash_messages'] = array();

        $this->messageBefore = "<div class=%s>";
        $this->messageAfter = "</div>";
    }

    function addMessage($type, $message, $redirect=null) {

        if(!isset($_SESSION['flash_messages'])) return false;

        if(!isset($type) || !isset($message)) return false;

        if( !array_key_exists( $type, $_SESSION['flash_messages'] ) ) $_SESSION['flash_messages'][$type] = array();

        $_SESSION['flash_messages'][$type][] = $message;

        if( !is_null($redirect) ) {
            header("Location: $redirect");
            exit();
        }
        return true;
    }

    function display($type=null) {
        if(!is_null($type)) {
            foreach($_SESSION['flash_messages'][$type] as $message) {
                echo sprintf($this->messageBefore, $type);
                echo $message;
                echo $this->messageAfter;
            }
        } else {
            foreach($_SESSION['flash_messages'] as $type => $messages) {
                echo "$type : <br>";
                foreach($messages as $message) {
                    echo "$message <br>";
                }
                echo "<br>";
            }
        }

        $this->clear();
    }

    function clear($type=null) {
        if(!is_null($type)) {
            unset($_SESSION['flash_messages'][$type]);
        } else {
            unset($_SESSION['flash_messages']);
        }
    }

    //TODO: hasMessages($type)
}