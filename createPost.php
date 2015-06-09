<?php
spl_autoload_register(function($class) {
    include $class . '.php';
});


$DBManager = new DBManager();
$Messages = new Messages();

if(strlen($_POST['title']) == 0 or strlen($_POST['body']) == 0) {
    $Messages->addMessage('e', "You didn't fill out both fields!", 'index.php');
}

$data = array("title" => $_POST['title'], "body" => $_POST['body'], "posted" => date("d/m/Y - H:i"));

$DBManager->addPost($data);

$Messages->addMessage('s', "Post was added successfully!", 'index.php');