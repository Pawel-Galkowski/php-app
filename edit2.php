<?php
include 'session.php'; 

function globalClient(){
    if(isset($_POST["marks_name"])){
        editClientName();
        $client_added = TRUE;
    }
    else if(isset($_POST['surname'])){
        editClientSurname();
        $client_added = TRUE;
    }
    else{
        $client_added = FALSE;        
    }
}

function showClient(){
    $db = connectDatabase();
    $query_mark = "SELECT * FROM `users` where nick = '".$_SESSION['logged']."'";
    $score = $db->query($query_mark);
    $finded = $score->num_rows;
    for($i = 0; $i < $finded; $i++){
        $line = $score->fetch_object();
        echo '<hr/>';
        echo '<form name="add_client_form" id="add_client_form" action="edit.php" method="post">';
        echo '<label><b>Imię: </b>'.$line->name.' </label>';
        echo '<input type="text" id="marks_name" name="marks_name" />';
        echo '<input type="button" id="button_submit1" name="button_submit1" value="Change">';
        echo '</form>';
        echo '<p></p>';
        echo '<form name="add_client_form2" id="add_client_form2" action="edit.php" method="post">';
        echo '<label><b>Nazwisko: </b>'.$line->surname.' </label>';
        echo '<input type="text" id="surname" name="surname"/>';
        echo '<input type="button" id="button_submit2" name="button_submit2" value="Change">';
        echo '<p></p>';
        echo '<p class="responseMsg2"></p>';
        echo '</form>';
        }
    $db->close();
}
      
function editClientName(){
        $db = connectDatabase();
        $sql = "UPDATE `users` SET `name`='".$_POST['marks_name']."' WHERE `nick`= '".$_SESSION['logged']."'";
        $response = $db->query($sql);
        if($response == TRUE){
            echo '<script>alert("User modified");</script>';
            header("location: edit.php");
            exit;
        } else {
            echo '<div id="modified_rows"> Wystapił błąd przy modyfikowaniu użytkownika</div>';
        }
        return false;
}

function editClientSurname(){   
        $db = connectDatabase();
        $newSurname = $_POST['surname'];
        $sql = "UPDATE `users` SET `surname`='".$newSurname."' WHERE `nick`= '".$_SESSION['logged']."'";
        $response = $db->query($sql);
        if($response == TRUE){
            echo '<script>alert("User modified");</script>';
            header("location: edit.php");
            exit;
        } else {
            echo '<div id="modified_rows"> Wystapił błąd przy modyfikowaniu użytkownika</div>';
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
            <section id="number">
            </section>
            <script>
            $ = function(id) {
        return document.getElementById(id);
    }
            
    var testLength = function(inputtext) {
        if (inputtext.length < 30) {
            return true;
        } else {
            alert("Ups błąd w walidacji!");
            return false;
        }
    }
    
    window.onload = function() {
        $("button_submit1").onclick = function() {
            var ClientName = $("marks_name").value;
            if(ClientName != ''){
                if (testLength(ClientName)) {
                    <?php globalClient(); ?>
                   $("add_client_form").submit();
                }
            }
        }

        $("button_submit2").onclick = function() {
            var ClientSurname = $("surname").value;
            if(ClientSurname != ''){
                if (testLength(ClientSurname)) {
                    <?php globalClient(); ?>
                    $("add_client_form2").submit();
                }
            }
        }
    }

</script>
            <hr />
            <section id="client_edit_box">
                <p> user: </p>
                <form name="client_edit_form" id="client_edit_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <?php
                    showClient();
                ?>
                </form>
            </section>
        </div>
    </div>
</body>

</html>
