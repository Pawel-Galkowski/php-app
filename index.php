<?php
include 'session.php';
    if(isset($_POST['Numb'], $_POST['Numb2'], $_POST['calculating'])){
        $Number = trim($_POST['Numb']);
        $Number2 = trim($_POST['Numb2']);
        $func = trim($_POST['calculating']);
        
        switch($func){
            case "Adding":
                $result = $Number + $Number2;
                break;
            case "Subtraction":
                $result = $Number - $Number2;
                break;
            case "Division":
                $result = $Number * $Number2;
                break;
            case "Multiplication":
                $result = $Number / $Number2;
                break;
        }
    }
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
    <meta name="description" content="Zapraszam do zapoznania sie z moja wlasna strona www" />
    <meta name="keywords" content="PHP" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div id="wrapper">
        <div class="app-container2">
            <div class="loginform">
                <section id="logowanie">
                    <h2>Logowanie</h2>
                    <p id="powitanie">
                        <?php 
                    if(isset($_SESSION['logged'])){
                        echo "Witaj ".$_SESSION['logged']." ";
                ?>
                        <br />
                        <a href="logout.php"><button>WYLOGUJ</button></a>
                        <?php
                    }
                    else{
                        echo "Zostaniesz przekierowany za 5 sekund lub zaloguj sie: ";
                ?>
                        <a href="login.php">ZALOGUJ</a>
                        <?php
                    }
                ?>
                    </p>
                </section>
            </div>
        </div>
        <?php 
            if(isset($_SESSION['logged'])){?>
        <div class="app-container2">
            <div class="loginform">
                <section id="calculator">
                    <h2>Calc</h2>
                    <?php
                    if(isset($result)){
                        if(!empty($result)) echo "Wynik: ".$result;
                        unset($result);
                    }
                ?>
                    <form id="calc" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
                        Number: <input type="text" name="Numb"><br />
                        Number2: <input type="text" name="Numb2"><br />
                        <select id="fullwidth" name="calculating">
                            <option value="Adding">Adding (+)</option>
                            <option value="Subtraction">Subtraction (-)</option>
                            <option value="Division">Division (*)</option>
                            <option value="Multiplication">Multiplication (/)</option>
                        </select>
                        <Button type="submit" name="submit">Calculate</Button><br />
                    </form>
                </section>
            </div>
        </div>
        <?php
            } ?>

    </div>
    <?php 
        if(isset($_SESSION['logged'])){ ?>
    <div class="app-container2">
        <div class="loginform">
            <a href="baza.php"><button>Zarzadzanie bazami danych</button></a>
        </div>
    </div>
    <?php
        } ?>
</body>

</html>
