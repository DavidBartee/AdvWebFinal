<?php
    require_once('config.php');
    include_once('includes/activity.class.php');
    include_once('includes/image.class.php');
    include_once('includes/activityDAO.class.php');
    include_once('includes/activityDAOMaria.class.php');

    session_start();
    $db = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $myname = mysql_real_escape_string($_POST['username'], $db);
        $mypassword = mysql_real_escape_string($_POST['password'], $db);

        $sql = "SELECT id FROM user WHERE username = '$myname' and password_string = '$mypassword'";
        $result = mysql_query($sql, $db);
    }
?>

<html>

    <head>
        <title>Login</title>
    </head>

    <body>
        <div align="center">
            <form action="" method="post">
                <label>Username: </label><input type="text" name="username" class="box"/><br/>
                <label>Password: </label><input type="password" name="password" class="box"/><br/>
                <input type="submit" value="Submit" /><br/>
            </form>
        </div>
    </body>

</html>