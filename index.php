<html>
<head>

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
        //TODO: Proper message checking
        $Messages->display("s");
    ?>
    <!-- End success/failure checks -->

    <div class="createPost">
        <form action="createPost.php" method="post">
            <input type="text" name="title" />
            <input type="text" name="body" />
            <input type="submit" />
        </form>
    </div>
    <div class="displayPosts">
        <ul>
            <?php
                $cursor = $DBManager->getDb()->posts->find();
                $cursor->sort(array('_id' => -1));
                foreach($cursor as $post) {
                    echo "<div class='post'>";
                        echo "<li>" . $post['title'];
                        echo "<ul> <li>" . $post['body'] . "</li> </ul>";
                        echo "</li>";
                    echo "</div>";
                }
            ?>
        </ul>
    </div>
</div>

<div>
    $_SESSION:
    <?php var_dump($_SESSION); ?>
</div>

</body>
</html>
