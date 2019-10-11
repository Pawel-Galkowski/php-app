<?php
include 'session.php';

function globalClient(){
    if(isset($_POST["user_name"])){        
        editMarkName();
        $mark_added = TRUE;
    }
    else if(isset($_POST["user_surname"])){        
        editMarkName2();
        $mark_added = TRUE;
    }
    else{
       $mark_added = FALSE;
    }
}

function showMarks(){
    $db = connectDatabase();
    $query_mark = "SELECT * FROM `users` where nick = '".$_SESSION['logged']."'";
    $score = $db->query($query_mark);
    $finded = $score->num_rows;
    for($i = 0; $i < $finded; $i++){
        $line = $score->fetch_object();
        print_r($line->nick);
        echo '<hr/>';
        echo '<form name="add_client_form" id="add_client_form" action="edit.php" method="post">';
        echo '<br/><b><label>imie: </b> '.$line->name.' </label> <br/>';
        echo '<input type="text" id="user_name" name="user_name" />';
        echo '<input type="button" id="button_submit1" name="button_submit1" value="Change"> <br/>';
        echo '<p class="responseMsg"></p>';
        echo '</form>';
        echo '<hr/>';
        echo '<form name="add_client_form2" id="add_client_form2" action="edit.php" method="post">';
        echo '<br/><b><label>nazwisko: </b> '.$line->surname.' </label> <br/>';
        echo '<input type="text" id="user_surname" name="user_surname" />';
        echo '<input type="button" id="button_submit2" name="button_submit2" value="Change"> <br/>';
        echo '<p class="responseMsg"></p>';
        echo '</form>';
    }
    $db->close();
}

function editMarkName(){    
    $db = connectDatabase();
    $sql = "UPDATE `users`SET `name`='".$_POST['user_name']."' WHERE `nick`= '".$_SESSION['logged']."'";
    $response = $db->query($sql);
    if($response == TRUE){
        echo '<script>alert("Mark modified");</script>';
        header("location: edit.php");
        exit;
    } else {
        echo '<div id="modified_rows"> Wystapił błąd przy modyfikowaniu marki</div>';
    }
    return false;
}

function editMarkName2(){    
    $db = connectDatabase();
    $sql = "UPDATE `users`SET `name`='".$_POST['user_name']."' WHERE `nick`= '".$_SESSION['logged']."'";
    $response = $db->query($sql);
    if($response == TRUE){
        echo '<script>alert("Mark modified");</script>';
        header("location: edit.php");
        exit;
    } else {
        echo '<div id="modified_rows"> Wystapił błąd przy modyfikowaniu marki</div>';
    }
    return false;
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
                    <input type="button" value="<-- Powrót" />
                </a>
            </p>
            <hr />
            <script>
    $ = function(id) {
        return document.getElementById(id);
    }

    var testLength = function(inputtext) {
        if (inputtext != "") {
            return true;
        } else {
            alert("Ups błąd w walidacji!");
            return false;
        }
    }

window.onload = function(){ 
    $("button_submit1").onclick = function(){
        var acerValue = $("user_name").value;
        if(acerValue != ''){
            if(testLength(acerValue.value)) {
                <?php globalClient(); ?>
                $("add_client_form").submit();
            }
        }
    }
    $("button_submit2").onclick = function(){
        var acerValue = $("user_surname").value;
        if(acerValue != ''){
            if(testLength(acerValue.value)) {
                <?php globalClient(); ?>
                $("add_client_form2").submit();
            }
        }
    }
};
</script>
     <section id="Mark_edit_box">
                <p>Uzytkownik o nicku: </p>
                <?php showMarks(); ?>
            </section>
        </div>
    </div>
</body>
</html>
