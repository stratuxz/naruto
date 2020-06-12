<!DOCTYPE html>
<html>
<head>
    <link href = "style.css" type = "text/css" rel = "stylesheet"> </link>
</head>
<body>
<?php
    session_start();

    $username = strip_tags($_POST["username"]);

    $password = $_POST["password"];

	$_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    $db_conn_str = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                    (HOST = cedar.humboldt.edu)
                                    (PORT = 1521))
                               (CONNECT_DATA = (SID = STUDENT)))";

    $conn = oci_connect($_SESSION['username'], $_SESSION['password'], $db_conn_str);

        // exit if could not connect

    if (! $conn)
    {
        ?>
        <h2> <font color = "red"> Could not log into Oracle, sorry </font> </h2>

        <?php
        require_once("login.html");
        exit;
    }  
        // if I reach here -- I connected
?>

<?php require_once("naruto.html"); ?>
</body>
</html>






