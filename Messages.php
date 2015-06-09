<?php

/**
 * Class Messages
 *
 * This class is used for flashing messages until they're next displayed. When they're displayed they will be cleared
 * from the session.
 *
 * Messages can be displayed by type, or can all be displayed at once.
 *
 * Message types are:
 *      h - help,
 *      i - info,
 *      w - warning,
 *      e - error,
 *      s - success
 */

class Messages {
    
    //TODO: Proper message wrapping
    private $messageBefore;
    private $messageAfter;

    /**
     * Creates the array in the session for storing the flash messages, if the array does not exist already.
     *
     * Also initialises the message wrapper.
     */
    function __construct() {
        if(!isset($_SESSION)) session_start();

        if(!array_key_exists('flash_messages', $_SESSION)) $_SESSION['flash_messages'] = array();

        $this->messageBefore = "<div class='flashMessage %s'>";
        $this->messageAfter = "</div>";
    }

    /**
     * Add a message and it's type to the queue
     *
     * @param string $type The type of the message - From any of ('h','i','w','e','s')
     * @param string $message The message to be added to the messages
     * @param null $redirect The url to be redirected to once the message has been added
     * @return bool Whether the message was added successfully
     */
    public function addMessage($type, $message, $redirect=null) {

        if(!isset($_SESSION['flash_messages'])) return false;

        if(!isset($type) || !isset($message)) return false;

        if( strlen(trim($type)) == 1 ) {
            $type = str_replace(
                array('h',    'i',    'w',       'e',     's'),
                array('help', 'info', 'warning', 'error', 'success'),
                $type
            );
        }

        if( !array_key_exists( $type, $_SESSION['flash_messages'] ) ) $_SESSION['flash_messages'][$type] = array();

        $_SESSION['flash_messages'][$type][] = $message;

        if( !is_null($redirect) ) {
            header("Location: $redirect");
            exit();
        }
        return true;
    }

    /**
     * Display messages
     *
     * @param null $type The type of the message to display
     */
    public function display($type=null) {
        if(!is_null($type)) {
            foreach($_SESSION['flash_messages'][$type] as $message) {
                echo sprintf($this->messageBefore, $type);
                echo $message;
                echo $this->messageAfter;
            }
        } else {
            foreach($_SESSION['flash_messages'] as $type => $messages) {
                foreach($messages as $message) {
                    echo sprintf($this->messageBefore, $type);
                    echo "$message";
                    echo $this->messageAfter;
                }
            }
        }
        $this->clear();
    }

    /**
     * Check if there are messages waiting in the queue
     *
     * @param null $type The type of message to check for
     * @return bool If there is messages in the queue
     */
    public function hasMessage($type=null) {
        if(is_null($type)) {
            return !empty($_SESSION['flash_messages']);
        } else {
            return !empty($_SESSION['flash_messages'][$type]);
        }
    }

    /**
     * Used by the display function to clear displayed messages
     *
     * @param null $type
     */
    private function clear($type=null) {
        if(!is_null($type)) {
            unset($_SESSION['flash_messages'][$type]);
        } else {
            unset($_SESSION['flash_messages']);
        }
    }
}