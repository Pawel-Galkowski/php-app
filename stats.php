<?php
include 'session.php';

function showClient(){
    $db = connectDatabase();
    $query_mark = "SELECT * FROM `users` where nick='".$_SESSION['logged']."'";
    $score = $db->query($query_mark);
    $finded = $score->num_rows;
    for($i = 0; $i < $finded; $i++){
        $line = $score->fetch_object();
        echo '<hr/>';
        echo '<br/><b><label>Nazwa: </b><br/>'.$line->nick.' </label> <br/>';
        echo '<br/><b><label>Imię: </b><br/>'.$line->name.' </label> <br/>';
        echo '<br/><b><label>Nazwisko: </b><br/>'.$line->surname.' </label> <br/>';
        }
    $db->close();
}

function showMarks(){
    $db = connectDatabase();
    $query_mark = "SELECT * FROM `marks`";
    $score = $db->query($query_mark);
    $finded = $score->num_rows;
    for($i = 0; $i < $finded; $i++){
        $line = $score->fetch_object();
        echo '<hr/>';
        echo '<br/><b><label>Acer: </b><br/>'.$line->acer.' </label> <br/>';
        echo '<br/><b><label>Asus: </b><br/>'.$line->asus.' </label> <br/>';
        echo '<br/><b><label>Lenovo: </b><br/>'.$line->lenovo.' </label> <br/>';
        echo '<br/><b><label>HP: </b><br/>'.$line->hp.' </label> <br/>';
    }
    $db->close();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <title>Baza</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    <div class="app-container2">
    <div class="app-stats">
            <p>
                <a href="baza.php">
                    <input type="button" value="<-- Powrót"/>
                </a> 
            </p>
        <section id="number">
                        </section>

                        <hr />
                        <section id="client_edit_box">
                            <p>user: </p>
                            <form name="client_edit_form" id="client_edit_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <?php
                    showClient();
                ?>
                            </form>
                        </section>

                        <hr />
        <?php
            $db = connectDatabase();

            $sql = "SELECT * FROM marks";
            $score = $db->query($sql);
            $finded = $score->num_rows;
            if($finded == 1){
            echo 'Znaleziono '.$finded.' linię w sql';
            }else if($finded <5 && $finded >1){
                echo 'Znaleziono '.$finded.' linie w sql';
            }else
            echo 'Znaleziono '.$finded.' lini w sql';
            ?>
                        <section id="Mark_edit_box">
                            <p>marks: </p>
                            <form name="marks_edit_form" id="marks_edit_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <?php
                    showMarks();
                ?>
                            </form>
                        </section>

                        <hr />
                        <section id="dane_serwera">
                            <p>Dane serwera: </p>
                            <?php
                $db = connectDatabase();
                echo '<br />'.mysqli_get_client_info().'<br />';
                echo '<p>Host info: </p>';
                echo mysqli_get_host_info($db).'<br />';
                echo '<p>Serwer info: </p>';
                echo mysqli_get_server_info($db).'<br />';
            ?>
                        </section>
        </div></div>
</body>

</html>
