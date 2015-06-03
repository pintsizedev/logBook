<?php
spl_autoload_register(function($class) {
    include $class . '.php';
});


$DBManager = new DBManager();
$Messages = new Messages();

$data = array("title" => $_POST['title'], "body" => $_POST['body']);

$DBManager->addPost($data);

$Messages->addMessage('s', "Test Message");

$Messages->addMessage('s', "Post was added successfully!", 'index.php');