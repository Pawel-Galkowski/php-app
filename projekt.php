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
        else if ($_POST['choosen'] == "produkty"){
            for($i = 0; $i < $finded; $i++){
                $line = $score->fetch_object();
                echo "<div>";
                echo "<p> ID: ".$line->ID."</p>";
                echo "<p> Name: ".$line->NAME."</p>";
                echo "<p> PRice: ".$line->price."</p>";   
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
        $sql = "INSERT INTO users (surname, name, password, age, nick, sex) VALUES('".$_POST['surname']."','".$_POST['name']."','NULL','".$_POST['age']."','".$_POST['nick']."','".$_POST['Sex']."')";
        
        $response = $db->query($sql);
        if($response == TRUE){
           echo 'alert("User added");';
            header("location: baza.php");
            exit;
        } else {
            echo '<div id="modified_rows"> Wystapił błąd przy dodawaniu użytkownika</div>';
        }
        return false;
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

if(!empty($_FILES['uploaded_file']))
  {
    $path = "./uploads/";
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      echo "The file ".  basename( $_FILES['uploaded_file']['name']). " has been uploaded";
    } else{
        echo "There was an error uploading the file, please try again!";
    }
  }

function fileEdit(){
// wczytanie starych danych

// otwarcie pliku do odczytu
$fp = fopen($_FILES['uploaded_file']['tmp_name'], "r");

//odczytanie danych
$stareDane = fread($fp, filesize($_FILES['uploaded_file']['tmp_name']));

// zamknięcie pliku
fclose($fp);

// stworzenie nowych danych

$noweDane  = $_POST['content_file'];
$noweDane .= $stareDane;

// zapisanie nowych danych

// otwarcie pliku do zapisu
$fp = fopen($_FILES['uploaded_file']['tmp_name'], "w");

// zapisanie danych
fputs($fp, $noweDane);

// zamknięcie pliku
fclose($fp);
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
                <a href="baza.php"><button>BACK</button></a>
            </div>
            <section id="wybortab">
                <p>Choose table: </p>
                <form id="tabela" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <select name="choosen">
                        <option value="users">users</option>
                        <option value="marks">marks</option>
                        <option value="produkty">produkty</option>
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
                    var Client_age = $("age");
                    var Mark_name = $("marks_name");
                    var Mark_producent = $("marks_producent");

                    $("button_submit1").onclick = function() {
                        if (testLength(ClientName.value) && testLength(Client_surname.value) && testLength(Client_nick.value) && Client_age != '') {
                            <?php globalClient(); ?>
                            $("add_client_form").submit();
                        } else {
                            console.log("błąd walidacji usera");
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
                    <label>Age: </label><input type="text" id="age" name="age" required />
                    <label>Sex: </label>
                    <?php showSexList(); ?>
                    <input type="button" id="button_submit1" name="button_submit1" value="Dodaj">
                </form>
                <form enctype="text/plain" action="projekt.php" method="POST">
                <p>Upload your file</p>
                <input type="file" name="uploaded_file" /><br />
                <input type="submit" value="Upload" />
                </form>
                <p>Add your text to file (available after adding file)</p>
                <form enctype="text/plain" action="projekt.php" method="POST">
                    <input type="text" name="content_file" id="content_file" />
                    <?php 
                    if(isset($_FILES['uploaded_file'])){        
                        showTable();
                    }
                    ?>
                </form>
                <span></span>
            </section>
        </div>
    </div>
</body>

</html>
