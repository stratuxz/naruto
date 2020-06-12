<!DOCTYPE html>
<html>
<head>
    <link href = "style.css" type = "text/css" rel = "stylesheet"></link>
</head>
<?php
    session_start();

    function test_input($name)
    {
        $name = trim($name);
        $name = stripslashes($name);
        $name = htmlspecialchars($name);
        $name = strtolower($name);

        return $name;
    }

    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
       $username = test_input($_SESSION['username']);
       $password = $_SESSION['password'];
    }

    $db_conn_str = 
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

    $connection = oci_connect($username, $password, $db_conn_str);
        
    if (!$connection)
    {
        die('Connection Failed');
    }

    function exists($name) // check if value exists within form 
    {
        if(isset($name))
        {
            return true;
        }
        return false;
    }

    $age = 0;
    $creator = "";
    $gaara_beast = "";
    $akatsuki = "";
    $kekkei = "";
    $tail_beast = "";

    $wrong = 0;
    $correct = 0;
    $total = 6;

    if (exists($_POST['age']) == true)
    {
        $age = (int)test_input($_POST['age']);

        if($age == 13)
        {
            $correct += 1;
        }
    }


    if (exists($_POST['t/f']) == true)
    {
        $creator = test_input($_POST['t/f']);

        if($creator == 'true')
        {
            $correct += 1;
        }
    }

    if (exists($_POST['beast']) == true)
    {
        $gaara_beast = test_input($_POST['beast']);

        if($gaara_beast == 'shukaku')
        {
            $correct += 1;
        }
    }

    if (exists($_POST['tru/fls']) == true)
    {
        $akatsuki = test_input($_POST['tru/fls']);

        if($akatsuki == 'true')
        {
            $correct += 1;
        }
    }

    if (exists($_POST['kg']) == true)
    {
        $kekkei = test_input($_POST['kg']);

        if($kekkei == 'third eye')
        {
            $correct += 1;
        }
    }


    if (exists($_POST['tail']) == true)
    {
        $tail_beast = test_input($_POST['tail']);

        if($tail_beast == 'gamabunta')
        {
            $correct += 1;
        }
    }

    $user_id = rand(0, 30000);

    $score = ($correct / $total) * 100;

    $user_statement = 'insert into zv80_User
                       values(:idd, :userr, :onee, :twoo, :threee, :fourr, :fivee, :sixx)';

    $query = oci_parse($connection, $user_statement);

    oci_bind_by_name($query, ":idd", $user_id);
    oci_bind_by_name($query, ":userr", $username);
    oci_bind_by_name($query, ":onee", $age);
    oci_bind_by_name($query, ":twoo", $creator);
    oci_bind_by_name($query, ":threee", $gaara_beast);
    oci_bind_by_name($query, ":fourr", $akatsuki);
    oci_bind_by_name($query, ":fivee", $kekkei);
    oci_bind_by_name($query, ":sixx", $tail_beast);

    oci_execute($query, OCI_DEFAULT);
    oci_commit($connection);
    oci_free_statement($query);

    oci_close($connection);

    session_destroy();

?>

<body>
    <p class = "links"> <a class = "admin" href = "login.html"> logout </a>
    <h2 id = "score"> Your score... <?php echo round($score, 2); ?>% </h2>

    <div class = "outline"> 
    <div class = "head">1. At what age did Itachi Uchiha become an Anbu Captain?</div>
    Your Answer: <?php echo $age; ?> <br><br>
    <strong> Correct Answer: </strong> 13. At age 7 Uchiha graduated from the Academy. At age 8, 
    he mastered the Sharingan. At age 10, he passed the Chuunin Exams.
    </div> 
    
    <br>

    <div class = "outline">
    <div class = "head">2. True or False. Jiraiya came up with the name Naruto while eating ramen.</div>
    Your Answer: <?php echo $creator; ?><br><br>
    <strong> Correct Answer: </strong> True. Jiraiya was eating ramen which had 'narutomaki' (fishcake) 
    as a topping. This is also how Masashi Kishimoto came up with the name 'Naruto Uzumaki.'
    </div><br>
    
    <div class = "outline">
    <div class = "head">3. Name the tailed beast that was inside Gaara.</div>

    Your Answer: <?php echo $gaara_beast; ?><br><br>
    <strong> Correct Answer: </strong> Shukaku. Gaara hosted the one tailed beast since birth.
    </div><br>

    <div class = "outline">
    <div class = "head">4. True or False. Orochimaru was part of the Akatsuki.</div>
    Your Answer: <?php echo $akatsuki; ?><br><br>
    <strong> Correct Answer: </strong> True. The reason he joined is unknown. His partner was Sasori.
    Orochimaru left before Itachi Uchiha joined.
    </div><br>

    <div class = "outline">
    <div class = "head">5. Which of the following is not a Kekkei Genkai?</div>
    Your Answer: <?php echo $kekkei; ?><br><br>
    <strong> Correct Answer: </strong> Third Eye. Kekkei Genkai, translating to bloodline limit, are
     abilities passed down genetically within a clan. The Third Eye is a jutsu Gaara uses for vision that
      his two eyes cannot see.
    </div><br>

    <div class = "outline">
    <div class = "head">6. Which of the following is not a Tailed Beast?</div>
    Your Answer: <?php echo $tail_beast; ?><br><br>
    <strong> Correct Answer: </strong> Gamabunta. Also known as The Chief Toad. He is summoned through the 
    summoning jutsu. Kurama is the 9 tailed beast, Gyuubi the 8 tailed beast, and Son Goku is the 4th tailed 
    beast.
    </div>
</body>
</html>