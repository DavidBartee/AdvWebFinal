<?php
    require_once('config.php');
    include_once('includes/activity.class.php');
    include_once('includes/image.class.php');
    include_once('includes/activityDAO.class.php');
    include_once('includes/activityDAOMaria.class.php');

    session_start();
    $db = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $myname = $_POST['username'];
        $mypassword = $_POST['password'];

        $sql = $db->prepare("SELECT id FROM user WHERE username = :username and password_string = :password");
        $sql->bindParam(':username', $myname);
        $sql->bindParam(':password', $mypassword);
        $sql->execute();

        $result = $sql->fetchAll();
        $count = 0;
        foreach($result as $key => $value) {
            echo 'key: ' . $key . '<br/>
            value: ' . implode($value) . '<br/>';
            $count++;
        }
            
        if ($count == 1) {
            $_SESSION['loggedIn'] = true;
            header("location: management.php");
        } else {
            echo "Your login name or password is invalid";
        }
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