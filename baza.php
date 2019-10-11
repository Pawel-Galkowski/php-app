<?php
include 'session.php';   

//Funckcja pokazująca aktualną tablę  
//---------------------------------------------------------------------
    function showTable(){
        $db = connectDatabase();
        $queries1 = "SELECT * FROM ".$_POST['choosen'];
        $score = $db->query($queries1);
        $finded = $score->num_rows;
        
        if($_POST['choosen'] == "users"){
            for($i = 0; $i < $finded; $i++){
                $line = $score->fetch_object();
                echo "<div>";
                echo "<p>Nick: ".$line->nick."<br/>Name: ".$line->name."<br/>Surname: ".$line->surname."</p>";
            }
        }
        else if ($_POST['choosen'] == "marks"){
            for($i = 0; $i < $finded; $i++){
                $line = $score->fetch_object();
                echo "<div>";
                echo "<p>Producent: <br/> Acer: ".$line->acer."<br/> Asus:  ".$line->asus."<br/> Lenovo: ".$line->lenovo."<br/> HP:".$line->hp."</p>";
            }
        }
    }
//Funckcje klientów oraz wywoałania funkcji i sprawdzacze   
//---------------------------------------------------------------------
    //dodawanie klienta
function globalClient(){
    if(isset($_POST['name'], $_POST['surname'],$_POST['nick'])){        
        addClient();
        $client_added = TRUE;
    }
    else{
       $client_added = FALSE;
    }
}

    function addClient(){    
        $db = connectDatabase();
        $sql = "INSERT INTO users (surname, name, password, age, nick, sex) VALUES('".$_POST['surname']."','".$_POST['name']."','NULL','NULL','".$_POST['nick']."','".$_POST['Sex']."')";
        
        $response = $db->query($sql);
        if($response == TRUE){
           echo '<script>alert("User added");</script>';
            header("location: baza.php");
            exit;
        } else {
            echo '<div id="modified_rows"> Wystapił błąd przy dodawaniu użytkownika</div>';
        }
        return false;
    }
  
    //usuwanie klienta
    if(isset($_POST['client_remove'])){
        removeClient();
        $client_removed = TRUE;
        header("location: baza.php");
            exit;
    }
    else{
        $client_removed = FALSE;        
    }

        function removeClient(){
        $delete = trim($_POST['client_remove']);
        $db = connectDatabase();
        $sql = "DELETE FROM users WHERE nick='".$delete."'";
        $response = $db->query($sql);
        echo '"<div id="modified_rows">Zmodyfikowane wiersze: '.$db->affected_rows.' wynik operacji: '.$response.'</div>';
    }

        function showClientList(){
        $db = connectDatabase();
        $sql = "SELECT * FROM users";
        $response = $db->query($sql);
        $finded = $response->num_rows;

        echo '<select name="users">';
        for($i = 0; $i < $finded; $i++){
            $line = $response->fetch_object();
            echo '<option value="'.$line->nick.'">'.$line->name.' '.$line->surname.'</option>';
        }
        echo '</select>';
    }

    function showSexList(){
        $db = connectDatabase();
        $sql = "SELECT * FROM users";
        $response = $db->query($sql);
        $finded = $response->num_rows;

        echo '<select name="users">';
        for($i = 0; $i < $finded; $i++){
            $line = $response->fetch_object();
            echo '<option value="'.$line->nick.'">'.$line->sex.'</option>';
        }
        echo '</select>';
    }

        function client_choose($nick){
        $db = connectDatabase();
        $sql = "select users.*, marks.* from users JOIN marks ON users.marks_name = marks.marks_name WHERE users.nick = ".$nick;
        $response = $db->query($sql);
        $row = $response->fetch_array();
        echo "$row[0] $row[1] $row[2] $row[3] $row[4] $row[5] $row[6] ";
    }
    //Funckje odpowiedzialne za marki 
    //---------------------------------------------------------------------  
    //dodawanie marki
    if(isset($_POST['marks_name'], $_POST['marks_producent'])){
        addMark();
        $marks_added = TRUE;        
    }
    else{
        $marks_added = FALSE;
    }

    function addMark(){
        echo "<script>conosle.log('marka!')</script>";
        try{
            $i;
            if($i=''){
                $i=1;
            }
            else{
                $i+=$i;
            }
            $db = connectDatabase();
            $sql = "INSERT INTO marks (acer, asus, lenovo, hp, id) VALUES('".$_POST['marks_name']."','".$_POST['marks_producent']."','NULL','NULL','".$i."')";
            if ($db->query($sql) == TRUE) {
                echo '<script>alert("Mark added");</script>';
                header("location: baza.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $db->error;
            }
        }
        catch(Exception $error){
            echo "nieudane: ".$error->getMessage();
        }
    }
 
    //usuwanie marki
    if(isset($_POST['mark_remove'])){
        removeMark();
        $mark_removed = TRUE;
    }
    else{
        $mark_removed = FALSE;        
    }
    
    function removeMark(){
        $delete = trim($_POST['mark_remove']);
        $db = connectDatabase();
        $sql = "DELETE FROM marks WHERE acer='".$delete."'";
        $response = $db->query($sql);
        if($db->affected_rows < 0){
            echo '<div id="modified_rows">Nie można usunac tego produktu!</div>';
        }
        else{
            echo '<div id="modified_rows">Zmodyfikowane wiersze: '.$db->affected_rows.' score operacji: '.$response.'</div>';
            header("location: baza.php");
        }
    }
        
        function showMarksList(){
        $db = connectDatabase();
        $sql = "SELECT * FROM marks";
        $response = $db->query($sql);
        $finded = $response->num_rows;
        
        echo '<select name="marks">';
        for($i = 0; $i < $finded; $i++){
            $line = $response->fetch_object();
            echo '<option value="'.$line->marks_name.'">'.$line->acer.'</option>'; 
             echo '<option value="'.$line->marks_name.'">'.$line->asus.'</option>';  
             echo '<option value="'.$line->marks_name.'">'.$line->lenovo.'</option>';
             echo '<option value="'.$line->marks_name.'">'.$line->hp.'</option>';  
            echo $line->marks;
        }
        echo '</select>';                
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
        <div class="loginform2">
            <div class="box2">
                <a href="index.php"><button>BACK</button></a>
                <a href="stats.php"><button>NEXT</button></a>
            </div>
            <a href="projekt.php"><button>Miniprojekt</button></a>
            <section id="wybortab">
                <p>Choose table: </p>
                <form id="tabela" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <select name="choosen">
                        <option value="users">users</option>
                        <option value="marks">marks</option>
                    </select>
                    <input type="submit" value="Ok" />
                </form>
            </section>
            <section id="zawartosc_tabeli">
                <p>Information from tables:</p>
                <?php 
                if(isset($_POST['choosen'])){        
                    showTable();
                }
            ?>
            </section>


            <!--dodawanie klienta-->
            <script>
                $ = function(id) {
                    return document.getElementById(id);
                }

                var allDigits = function(inputtext) {
                    var digits = /[0-9]|\./;
                    if (inputtext.match(digits)) {
                        alert("Zakaceptowano");
                        return true;
                    } else {
                        alert("Błędne dane!");
                        return false;
                    }
                }

                var testLength = function(inputtext) {
                    if (inputtext.length < 30 && inputtext != "") {
                        return true;
                    } else {
                        alert("Ups błąd w walidacji!");
                        return false;
                    }
                }


                window.onload = function() {
                    var ClientName = $("name");
                    var Client_surname = $("surname");
                    var Client_nick = $("nick");
                    var Mark_name = $("marks_name");
                    var Mark_producent = $("marks_producent");

                    $("button_submit1").onclick = function() {
                        if (testLength(ClientName.value) && testLength(Client_surname.value) && testLength(Client_nick.value)) {
                            <?php globalClient(); ?>
                            $("add_client_form").submit();
                        } else {
                            console.log("błąd walidacji usera");
                        }
                    }

                    $("button_submit2").onclick = function() {
                        if (testLength(Mark_name.value) && testLength(Mark_producent.value)) {
                            $("add_mark_form").submit();
                        }
                    }
                }

            </script>
            <section id="add_klient_box">
                <p>Dodaj klienta: </p>
                <form name="add_client_form" id="add_client_form" action="baza.php" method="post">
                    <label>Imie: </label><input type="text" id="name" name="name" required />
                    <label>Nazwisko: </label><input type="text" id="surname" name="surname" required />
                    <label>Nick: </label><input type="text" id="nick" name="nick" required />
                    <label>Sex: </label>
                    <select name="Sex">
                        <option value="be">be</option>
                        <option value="male">male</option>
                        <option value="female">female</option>
                        <option value="unknow">unknow</option>
                        <option value="other">other</option>
                    </select>
                    <input type="button" id="button_submit1" name="button_submit1" value="Dodaj">
                </form>
                <span></span>
            </section>


            <!--dodawanie marki-->
            <section id="add_mark_box">
                <p>Nowa marka: </p>
                <form name="add_mark_form" id="add_mark_form" action="baza.php" method="post">
                    <label>Marka: </label><input type="text" id="marks_name" name="marks_name" />
                    <label>Model: </label><input type="text" id="marks_producent" name="marks_producent" />
                    <input type="button" id="button_submit2" name="button_submit2" value="Dodaj">
                </form>
                <span id="marks_added"><?php if($marks_added){ echo "Dodano produkt!";}?></span>
            </section>


            <!--usuwanie klienta-->
            <section id="remove_klient_box">
                <p>usun klienta: </p>
                <form name="remove_klient_form" id="remove_klient_form" action="baza.php" method="post">
                    <label>Podaj nick: </label><input type="text" name="client_remove" />
                    <input type="submit" value="Usuń" />
                </form>
            </section>

            <!--usuwanie produktu-->
            <section id="remove_mark_box">
                <p>usun marke: </p>
                <form name="remove_marks_form" id="remove_marks_form" action="baza.php" method="post">
                    <label>Podaj Marke: </label><input type="text" name="mark_remove" />
                    <input type="submit" value="Usuń" />
                </form>
            </section>

            <!--edycja klienta-->
            <section id="edycja_klienta_box">
                <p>Edycja danych: </p>
                <form name="edycja_klienta_form" id="edycja_klienta_form" action="edit.php" method="post">
                    <input type="submit" value="Edytuj dane" />
                </form>
            </section>

            <!--edycja produktu-->
            <section id="mark_edit">
                <p>Edycja marek: </p>
                <form name="mark_edit_form" id="mark_edit_form" action="edit-marks.php" method="post">
                    <input type="submit" value="Edytuj Marki" />
                </form>
            </section>
        </div>
    </div>
</body>

</html>
