<?php
include 'session.php';
global $scoreLine;

function globalClient(){
    if(isset($_POST["marks_name"])){        
        editMarkName();
        $mark_added = TRUE;
    }
    else{
       $mark_added = FALSE;
    }
}

function showMarks(){
    $db = connectDatabase();
    $query_mark = "SELECT * FROM `marks`";
    $score = $db->query($query_mark);
    $finded = $score->num_rows;
    for($i = 0; $i < $finded; $i++){
        $line = $score->fetch_object();
        $scoreLine = $line->acer;
        print_r($line->acer);
        echo '<hr/>';
        echo '<form name="add_client_form" id="add_client_form" action="edit-marks.php" method="post">';
        echo '<br/><b><label>acer: </b> '.$line->acer.' </label> <br/>';
        echo '<input type="text" id="marks_name" name="marks_name" />';
        echo '<input type="button" id="button_submit1" name="button_submit1" value="Change"> <br/>';
        echo '<p class="responseMsg"></p>';
        echo '</form>';
    }
    $db->close();
}

function editMarkName(){    
    $db = connectDatabase();
    $sql = "UPDATE `marks` SET `acer`='".$_POST['marks_name']."' WHERE `id`= 1";
    $response = $db->query($sql);
    if($response == TRUE){
        echo '<script>alert("Mark modified");</script>';
        header("location: edit-marks.php");
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
        var acerValue = $("marks_name").value;
        if(acerValue != ''){
            if(testLength(acerValue.value)) {
                <?php globalClient(); ?>
                $("add_client_form").submit();
            }
        }
    }
};
</script>
     <section id="Mark_edit_box">
                <p>marks: </p>
                <?php showMarks(); ?>
            </section>
        </div>
    </div>
</body>
</html>
