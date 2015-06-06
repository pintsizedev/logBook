<html>
<head>
    <link href="assets/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/logBook.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/messages.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
spl_autoload_register(function($class) {
    include $class . '.php';
});
if(!isset($_SESSION)) {
    session_start();
}
$DBManager = new DBManager();
$Messages  = new Messages();
?>
<nav>

</nav>
<div class="container">
    <!-- Check for post successes/failures -->
    <?php
        if($Messages->hasMessage()) {
            $Messages->display();
        }
    ?>
    <!-- End success/failure checks -->

    <div id="createPost">
        <form action="createPost.php" method="post">
            <p class="formLabel">Title</p>
            <label>
                <input type="text" id="postTitle" name="title"/>
            </label>
            <p class="formLabel">Body</p>
            <label>
                <textarea id="postBody" name="body"></textarea>
            </label>
            <br>
            <input id="postSubmit" type="submit" />
        </form>
    </div>

    <div class="displayPosts">
        <ul>
            <?php
                $cursor = $DBManager->getDb()->posts->find();
                $cursor->sort(array('_id' => -1));
                foreach($cursor as $post) {
                    echo "<div class='post'>";
                        echo "<p class='postTitle'>" . $post['title'] . "</p>";
                        echo "<p class='postBody'>" . $post['body'] . "</p>";
                    echo "</div>";
                }
            ?>
        </ul>
    </div>
</div>
</body>
</html>
